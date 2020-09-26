<?php
function getJobsDetails($sub_po,$plantcode){

    global $link_new;
    global $pps; 
    $data=array();


    //qry to get cutjobid
    $qry_cut_numbers="SELECT jm_cut_job_id FROM $pps.jm_cut_job WHERE po_number='$sub_po' AND plant_code='$plantcode' GROUP BY cut_number";
   
    $toget_cut_result=mysqli_query($link_new, $qry_cut_numbers) or exit("Sql Error at cutnumbers".mysqli_error($GLOBALS["___mysqli_ston"]));
    $toget_cut_num=mysqli_num_rows($toget_cut_result);
      if($toget_cut_num>0){
        while($toget_cut_row=mysqli_fetch_array($toget_cut_result))
        {
            $cut_job_id[]=$toget_cut_row['jm_cut_job_id'];
        }
        $cut_job_id = implode("','", $cut_job_id);
        //qry to get dockets using cut_job_id
        $qry_get_dockets="SELECT jm_docket_id From $pps.jm_dockets WHERE jm_cut_job_id in ('$cut_job_id') AND plant_code='$plantcode' order by docket_number ASC";
        //   echo $qry_get_dockets;
        $toget_dockets_result=mysqli_query($link_new, $qry_get_dockets) or exit("Sql Error at dockets".mysqli_error($GLOBALS["___mysqli_ston"]));
        $toget_dockets_num=mysqli_num_rows($toget_dockets_result);
        if($toget_dockets_num>0)
        {
            while($toget_docket_row=mysqli_fetch_array($toget_dockets_result))
            {
                $jm_dockets[]=$toget_docket_row['jm_docket_id']; 
            }
            $jm_dockets = implode("','", $jm_dockets);
        }

        //qry to get dockets in through dockets id
        $qry_get_docketlines="SELECT jm_docket_line_id,docket_line_number FROM $pps.jm_docket_lines WHERE jm_docket_id IN ('$jm_dockets') AND plant_code='$plantcode' order by docket_line_number";
        $qry_get_docketlines_result=mysqli_query($link_new, $qry_get_docketlines) or exit("Sql Error at docket lines".mysqli_error($GLOBALS["___mysqli_ston"]));
        $docketlines_num=mysqli_num_rows($qry_get_docketlines_result);
        if($docketlines_num>0){
            while($docketline_row=mysqli_fetch_array($qry_get_docketlines_result))
            {
                $docket_no[] = $docketline_row['docket_line_number']; 
            }
        }
        $doc = implode(",", $docket_no);
        $data['cut']['doc_no'] = $doc;
        $docket_no = implode("','", $docket_no);

        $marker_length=0;
        $cum_qty=0;
        $docket_info_query = "SELECT doc_line.plies,doc_line.fg_color,doc.marker_version_id,doc.ratio_comp_group_id,cut.cut_number,cut.po_number,ratio_cg.ratio_id,mso.po_description FROM $pps.jm_docket_lines doc_line LEFT JOIN $pps.jm_dockets doc ON doc.jm_docket_id = doc_line.jm_docket_id LEFT JOIN $pps.jm_cut_job cut ON cut.jm_cut_job_id = doc.jm_cut_job_id LEFT JOIN $pps.mp_sub_order mso ON mso.po_number = cut.po_number LEFT JOIN $pps.lp_ratio_component_group ratio_cg ON ratio_cg.ratio_wise_component_group_id = doc.ratio_comp_group_id WHERE doc_line.plant_code = '$plantcode' AND doc_line.docket_line_number in ('$docket_no') AND doc_line.is_active=true";
        // var_dump($docket_info_query);
        $docket_info_result=mysqli_query($link_new,$docket_info_query) or exit("$docket_info_query".mysqli_error($GLOBALS["___mysqli_ston"]));
        if($docket_info_result>0){
            while($row = mysqli_fetch_array($docket_info_result))
            {
                $data['cut']['color'] = $row['fg_color'];
                $data['cut']['cutjob'] = $row['cut_number'];
                $data['cut']['plies'] =  $row['plies'];
                $data['cut']['po_number'] = $row['po_number'];
                $data['cut']['po_description'] = $row['po_description'];

                $ratio_id = $row['ratio_id'];
                $marker_id = $row['marker_version_id'];
                
                $size_ratios='';
                $qry_ratio_size="SELECT size,size_ratio FROM $pps.lp_ratio_size WHERE ratio_id='$ratio_id' AND plant_code='$plantcode'";
                $qry_ratio_size_result=mysqli_query($link_new, $qry_ratio_size) or exit("Sql Errorat_size_ratios".mysqli_error($GLOBALS["___mysqli_ston"]));
                $qry_ratio_size_num=mysqli_num_rows($qry_ratio_size_result);
                if($qry_ratio_size_num>0){
                    $s=0;
                    $ratio_sum=0;
                    while($sql_row1=mysqli_fetch_array($qry_ratio_size_result))
                    {   
                        $data['cut']['size'][$s] = $sql_row1['size'];
                        $data['cut'][$data['cut']['size'][$s]] = $sql_row1['size_ratio'];
                        $ratio_sum += $sql_row1['size_ratio'];
                        $s++;
                    }
                }
                $data['cut']['qty'] = ($ratio_sum * $data['cut']['plies']);
                $cum_qty += $data['cut']['qty'];
                $data['cut']['cum_qty'] = $cum_qty;

                $get_marker_details="SELECT length From $pps.lp_markers WHERE marker_version_id in ('$marker_id') AND plant_code='$plantcode' and default_marker_version=1";
                // echo $get_marker_details;
                $get_marker_details_result=mysqli_query($link_new, $get_marker_details) or exit("Sql Error at dockets".mysqli_error($GLOBALS["___mysqli_ston"]));
                $get_marker_details_num=mysqli_num_rows($get_marker_details_result);
                if($get_marker_details_num>0)
                {
                    while($get_marker_details_row=mysqli_fetch_array($get_marker_details_result))
                    {
                        $length=$get_marker_details_row['length']; 
                        $marker_length = $length * $data['cut']['plies'];
                    }
                }
                $data['cut']['marker_length'] =  $marker_length;
            }
        }


        $style=array();
        $color=array();
        $schedule=array();
        //To get schedule,color
        $qry_get_sch_col="SELECT schedule,color FROM $pps.`mp_sub_mo_qty` LEFT JOIN $pps.`mp_mo_qty` ON mp_sub_mo_qty.`master_po_details_mo_quantity_id`= mp_mo_qty.`master_po_details_mo_quantity_id`
        WHERE po_number='$sub_po' AND mp_sub_mo_qty.plant_code='$plantcode'";
        $qry_get_sch_col_result=mysqli_query($link_new, $qry_get_sch_col) or exit("Sql Error at qry_get_sch_col".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($row=mysqli_fetch_array($qry_get_sch_col_result))
        {
            $schedule[]=$row['schedule'];
            $color[]=$row['color'];
        }
        $color_bulk=array_unique($color);
        $data['cut']['color']=array_unique($color);

        //To get style
        $qry_get_style="SELECT style FROM $pps.`mp_mo_qty` LEFT JOIN $pps.`mp_color_detail` ON mp_color_detail.`master_po_details_id`=mp_mo_qty.`master_po_details_id` WHERE mp_mo_qty.color in ('".implode("','" , $color_bulk)."') and mp_color_detail.plant_code='$plantcode'";
        $qry_get_style_result=mysqli_query($link_new, $qry_get_style) or exit("Sql Error at qry_get_style".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($row1=mysqli_fetch_array($qry_get_style_result))
        {
            $style[]=$row1['style'];
        }    
        $data['cut']['style']=array_unique($style);
        $data['cut']['schedule']=array_unique($schedule);
    }

    //Qry to fetch jm_job_header_id from jm_jobs_header
    $get_jm_job_header_id="SELECT jm_job_header_id FROM $pps.jm_job_header WHERE po_number='$sub_po' AND plant_code='$plantcode'";
    $jm_job_header_id_result=mysqli_query($link_new, $get_jm_job_header_id) or exit("Sql Error at get_jm_job_header_id".mysqli_error($GLOBALS["___mysqli_ston"]));
    $jm_job_header_id_result_num=mysqli_num_rows($jm_job_header_id_result);
    if($jm_job_header_id_result_num>0){
        while($jm_job_header_id_row=mysqli_fetch_array($jm_job_header_id_result))
        {
            $jm_job_header_id[]=$jm_job_header_id_row['jm_job_header_id'];
        }
    }
    
    $get_job_details = "SELECT jg.job_number as job_number,bun.fg_color as color,sum(bun.quantity) as qty ,bun.size as size FROM $pps.jm_jg_header jg LEFT JOIN $pps.jm_job_bundles bun ON bun.jm_jg_header_id = jg.jm_jg_header_id WHERE jg.plant_code = '$plantcode' AND jg.jm_job_header IN ('".implode("','" , $jm_job_header_id)."') AND jg.is_active=1 GROUP BY bun.size";
    // echo $get_job_details;
    $get_job_details_result=mysqli_query($link_new, $get_job_details) or exit("$get_job_details".mysqli_error($GLOBALS["___mysqli_ston"]));
    if($get_job_details_result>0){
        while($get_job_details_row=mysqli_fetch_array($get_job_details_result))
        {
            $job_numbers[] = $get_job_details_row['job_number'];
        }
        $job_numbers = implode(",", $job_numbers);
       
        $data['cut']['sewing_job'] = trim($job_numbers,"'");

    }
    // var_dump($data);

    return array(
        'data' => $data
    );
}

?>