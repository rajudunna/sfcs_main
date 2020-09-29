<?php
function getCheckList($get_style,$get_schedule,$plantcode){
	$url1 = getFullURL($_GET['r'],'print_bundle_check_list.php','R');

    $table = '<table class="table table-bordered">
    				<thead>
    					<tr class="info">
    						<th>S.No</th>
    						<th>Cut Number</th>
    						<th>Docket</th>
    						<th>Sewing Job Number</th>
    						<th>Color</th>
    						<th>Bundles</th>
    						<th>Quantity</th>
    						<th>Control</th>
    					</tr></thead>';
    //get mpos
    global $link_new;
    global $pps;
    $master_po_details_id=array();
    $qry_mmp_mo_qty="SELECT master_po_details_id FROM $pps.`mp_mo_qty` WHERE plant_code='$plantcode' AND schedule='$get_schedule'";
    $mp_mo_qty_result=mysqli_query($link_new, $qry_mmp_mo_qty) or exit("Sql Error at mp_color_detail".mysqli_error($GLOBALS["___mysqli_ston"]));
    $mp_mo_qty_num=mysqli_num_rows($mp_mo_qty_result);
    /**From above query we get master po details id */
    if($mp_mo_qty_num>0){
        while($mp_mo_qty_row=mysqli_fetch_array($mp_mo_qty_result))
            {
                
                $master_po_details_id[]=$mp_mo_qty_row["master_po_details_id"];
            }
        }
    $master_po_details_id=array_unique($master_po_details_id);
    /**Based master po details id we can get masetr po number */    
    $master_po_number=array();
    $qry_mp_color_details="SELECT master_po_number FROM $pps.mp_color_detail WHERE master_po_details_id IN ('".implode("','" , $master_po_details_id)."')";
    $mp_color_details_result=mysqli_query($link_new, $qry_mp_color_details) or exit("Sql Error at mp_color_detail".mysqli_error($GLOBALS["___mysqli_ston"]));
    $mp_color_details_num=mysqli_num_rows($mp_color_details_result);
    if($mp_color_details_num>0){
        while($mp_color_details_row=mysqli_fetch_array($mp_color_details_result))
            {
                
                $master_po_number[]=$mp_color_details_row["master_po_number"];
            }
    }
    $master_po_number=array_unique($master_po_number);

    /**So we will show master description based on masetr po number */
    $master_po_description=array();
    $qry_toget_podescri="SELECT master_po_description,master_po_number FROM $pps.mp_order WHERE master_po_number IN ('".implode("','" , $master_po_number)."')";
    $toget_podescri_result=mysqli_query($link_new, $qry_toget_podescri) or exit("Sql Error at mp_order".mysqli_error($GLOBALS["___mysqli_ston"]));
    $toget_podescri_num=mysqli_num_rows($toget_podescri_result);
    if($mp_color_details_num>0){
        while($toget_podescri_row=mysqli_fetch_array($toget_podescri_result))
        {
            $get_mpo[] = $toget_podescri_row["master_po_number"];
        }
        $get_mpo = implode("','", $get_mpo);

        $sub_po_description=array();
        /**Below query to get sub po's by using master po's */
        $qry_toget_sub_order="SELECT po_description,po_number FROM $pps.mp_sub_order WHERE master_po_number in ('$get_mpo') AND plant_code='$plantcode'";
        // echo $qry_toget_sub_order;
        $toget_sub_order_result=mysqli_query($link_new, $qry_toget_sub_order) or exit("Sql Error at mp_order".mysqli_error($GLOBALS["___mysqli_ston"]));
        $toget_podescri_num=mysqli_num_rows($toget_sub_order_result);
        if($toget_podescri_num>0){
            while($toget_sub_order_row=mysqli_fetch_array($toget_sub_order_result))
            {
                $po_number[]=$toget_sub_order_row["po_number"];
            }
        }
    }

    if(sizeof($po_number) > 0) {
        $po_number = implode("','", $po_number);

        /**By using po's we are getting*/
        $qry_cut_numbers="SELECT cut_number,jm_cut_job_id FROM $pps.jm_cut_job WHERE po_number in ('$po_number') AND plant_code='$plantcode'";
        $toget_cut_result=mysqli_query($link_new, $qry_cut_numbers) or exit("Sql Error at cutnumbers".mysqli_error($GLOBALS["___mysqli_ston"]));
        $toget_cut_num=mysqli_num_rows($toget_cut_result);
        if($toget_cut_num>0){
            while($toget_cut_row=mysqli_fetch_array($toget_cut_result))
            {
                $cuts[$toget_cut_row['jm_cut_job_id']]=$toget_cut_row['cut_number']; 
            }
            if(sizeof($cuts) > 0) {
                $sno = 1;
                foreach ($cuts as $cut_job_id => $cut_num) {
                    $table .= "<tr>";
                    $table .= "<td>".$sno."</td>";
                    $table .= "<td>".$cut_num."</td>";
                    // qry to get dockets using cut_job_id
                    $qry_get_dockets="SELECT jm_docket_id From $pps.jm_dockets WHERE jm_cut_job_id  = '$cut_job_id' AND plant_code='$plantcode' order by docket_number ASC";
                    $toget_dockets_result=mysqli_query($link_new, $qry_get_dockets) or exit("Sql Error at dockets".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $toget_dockets_num=mysqli_num_rows($toget_dockets_result);
                    if($toget_dockets_num>0){
                        $jm_dockets_idss = array();
                        $jm_dockets_id = '';
                        while($toget_docket_row=mysqli_fetch_array($toget_dockets_result))
                        {
                            $jm_dockets_idss[]=$toget_docket_row['jm_docket_id']; 
                        }
                        $jm_dockets_id = implode("','", $jm_dockets_idss);
                    }
                    //qry to get dockets in through dockets id
                    $qry_get_docketlines="SELECT group_concat(docket_line_number) as docket_line_number FROM $pps.jm_docket_lines WHERE jm_docket_id IN ('$jm_dockets_id') AND plant_code='$plantcode'";
                    $qry_get_docketlines_result=mysqli_query($link_new, $qry_get_docketlines) or exit("Sql Error at docket lines".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $docketlines_num=mysqli_num_rows($qry_get_docketlines_result);
                    if($docketlines_num>0){
                        $docket_line_number = '';
                        while($docketline_row=mysqli_fetch_array($qry_get_docketlines_result))
                        {
                            $docket_line_number=$docketline_row['docket_line_number']; 
                        }
                        $table .= "<td>".$docket_line_number."</td>";
                    }

                    //Qry to fetch jm_job_header_id from jm_jobs_header
                    $get_jm_job_header_id="SELECT jm_job_header_id FROM $pps.jm_job_header WHERE ref_id='$cut_job_id' AND plant_code='$plantcode'";
                    $jm_job_header_id_result=mysqli_query($link_new, $get_jm_job_header_id) or exit("Sql Error at get_jm_job_header_id".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $jm_job_header_id_result_num=mysqli_num_rows($jm_job_header_id_result);
                    if($jm_job_header_id_result_num>0){
                        $jm_job_header_id = array();
                        while($jm_job_header_id_row=mysqli_fetch_array($jm_job_header_id_result))
                        {
                            $jm_job_header_id[]=$jm_job_header_id_row['jm_job_header_id'];
                        }
                    }
                    
                    $get_job_details = "SELECT jg.jm_jg_header_id,jg.job_number as job_number,bun.fg_color as color,sum(bun.quantity) as qty,bun.size as size,GROUP_CONCAT(bun.bundle_number) as bun_num,GROUP_CONCAT(distinct(fg_color)) as fg_color,COUNT(bun.bundle_number) AS cnt FROM $pps.jm_jg_header jg LEFT JOIN $pps.jm_job_bundles bun ON bun.jm_jg_header_id = jg.jm_jg_header_id WHERE jg.plant_code = '$plantcode' AND jg.jm_job_header IN ('".implode("','" , $jm_job_header_id)."') AND jg.is_active=1 GROUP BY jg.job_number";
                    // echo $get_job_details;
                    $get_job_details_result=mysqli_query($link_new, $get_job_details) or exit("$get_job_details".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if($get_job_details_result>0){
                        $job_numberss = array();
                        $job_header_idss = array();
                        $sewing_job_numbers='';
                        $job_header_ids_list='';
                        $qty = 0;
                        $cnt = 0;
                        $fg_colorss = array();
                        while($get_job_details_row=mysqli_fetch_array($get_job_details_result))
                        {
                            $job_numberss[] = $get_job_details_row['job_number'];
                            $job_header_idss[] = $get_job_details_row['jm_jg_header_id'];
                            $qty += $get_job_details_row['qty'];
                            $fg_colorss[] = $get_job_details_row['fg_color'];
                            $cnt += $get_job_details_row['cnt'];
                        }
                        $fg_colorsss = implode(",", array_unique($fg_colorss));
                        $sewing_job_numbers = implode(",", $job_numberss);
                    }
                    $table .= "<td>".$sewing_job_numbers."</td>";
                    $table .= "<td>".$fg_colorsss."</td>";
                    $table .= "<td>".$cnt."</td>";
                    $table .= "<td>".$qty."</td>";
                    $table .= "<td ><a class='btn btn-warning' href='$url1?style=$get_style&schedule=$get_schedule&doc_no=".$docket_line_number."&org_doc_no=".$docket_line_number."&acutno=".$cut_num."&color_code=".$m['color_code']."&plantcode=".$plantcode."&cut_job_id=".$cut_job_id."'' onclick=\"return popitup2('$url1?style=$get_style&schedule=$get_schedule&doc_no=".$docket_line_number."&org_doc_no=".$docket_line_number."&acutno=".$cut_num."&color_code=".$m['color_code']."&plantcode=".$plantcode."&cut_job_id=".$cut_job_id."')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Print Check List</a>
                    </td>";
                    $sno++;
                    $table .= "</tr>";
                }
            }
        }
    }

    $table .= "</table>";
    return $table;
}

?>