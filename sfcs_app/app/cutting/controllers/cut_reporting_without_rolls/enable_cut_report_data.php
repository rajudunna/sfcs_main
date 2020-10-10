<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
//include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/m3Updations.php');
$data = $_POST;
$doc_no = $data['doc_no'];
$plantcode = $data['plantcode'];

        // $host="192.168.0.110:3337";
        // $user="postgres";
        // $pass="devpgsql";
        $link_new = mysqli_connect($host, $user, $pass);
        //$finishedrolls="SELECT distinct(roll_no) as roll_no,alloc_type_id FROM $bai_pro3.`docket_roll_info` WHERE docket=".$doc_no;
        /**getting jm docket line id based on doc number from jm_docket_line */
        //$qryGetJmDocketLines="SELECT jm_docket_line_id FROM $pps.jm_docket_lines WHERE docket_line_number='$doc_no' AND plant_code='$plantcode' AND is_active=1";
        $qryGetJmDocketLines="SELECT jdl.`jm_docket_line_id`,jdl.`plies`,jd.`jm_cut_job_id`,jd.`ratio_comp_group_id`,DATE(jdl.created_at) as created_at,ratio_cg.master_po_details_id FROM $pps.jm_dockets jd 
        LEFT JOIN $pps.jm_docket_lines jdl ON jdl.jm_docket_id=jd.jm_docket_id
        LEFT JOIN $pps.lp_ratio_component_group ratio_cg ON ratio_cg.ratio_wise_component_group_id = jd.ratio_comp_group_id
         WHERE jd.plant_code='$plantcode' AND jdl.docket_line_number='$doc_no'";
        $GetJmDocketLinesresult = mysqli_query($link_new,$qryGetJmDocketLines);
        if(mysqli_num_rows($GetJmDocketLinesresult) > 0)
        {   
            while($docketLinesRow = mysqli_fetch_array($GetJmDocketLinesresult))
            {
                $jmDocketLineId = $docketLinesRow['jm_docket_line_id'];
                $ratio_comp_group_id = $docketLinesRow['ratio_comp_group_id'];
                $jm_cut_job_id = $docketLinesRow['jm_cut_job_id'];
                $master_po_details_id = $docketLinesRow['master_po_details_id'];
            }
            /**getting lay plies to verify cut qty reporting done or not */
            $qryGetlpLay="SELECT plies,lp_lay_id FROM $pps.lp_lay WHERE jm_docket_line_id='$jmDocketLineId' AND plant_code='$plantcode' AND is_active=1";
            $getLpLayresult = mysqli_query($link_new,$qryGetlpLay);
            if(mysqli_num_rows($getLpLayresult) > 0)
            {   
                $totalPlies=0;
                while($lpLayRow = mysqli_fetch_array($getLpLayresult))
                {
                    $lpLayId[] = $lpLayRow['lp_lay_id'];
                    $totalPlies = $totalPlies+$lpLayRow['plies'];
                }

                /**getting roll id from lp_roll */
                
                if(sizeof($lpLayId) > 0)
                {
                    // while($row = mysqli_fetch_array($finishedrollsresult))
                    // {
                    //     $response_data1[] = $row['roll_no'];
                    //     $response_data2[] = $row['alloc_type_id'];
                    // }
                    /*get mark length */
                    // $mlength="SELECT mklength FROM bai_pro3.`order_cat_doc_mk_mix` WHERE doc_no=".$doc_no;
                    // $mlengthresult = mysqli_query($link,$mlength);
                    // $marklength = mysqli_fetch_array($mlengthresult);
                    $qry_lp_markers="SELECT `length`,`width`,`efficiency`,`marker_version`,`marker_type_name`,`pattern_version`,`perimeter`,`remark1`,`remark2`,`remark3`,`remark4` FROM $pps.`lp_markers` WHERE `ratio_wise_component_group_id`='$ratio_comp_group_id' AND default_marker_version=1 AND `plant_code`='$plantcode' AND is_active=1";
                    $lp_markers_result=mysqli_query($link_new, $qry_lp_markers) or exit("Sql Errorat_lp_markers".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $lp_markers_num=mysqli_num_rows($lp_markers_result);
                    if($lp_markers_num>0){
                        while($sql_row1=mysqli_fetch_array($lp_markers_result))
                        {
                            $marklength = $sql_row1['length'];
                        }
                    }

                    // $totalreportedplies="SELECT sum(reporting_plies) as totalreportedplies FROM $bai_pro3.`docket_roll_info` where docket=".$doc_no;
                    // $totalreportedpliesresult = mysqli_query($link,$totalreportedplies);
                    // $totalreportedplie = mysqli_fetch_array($totalreportedpliesresult);
                    $totalreportedplie=$totalPlies;

                    // $docketrolls="SELECT lay_sequence,reporting_plies,damages,joints,endbits,shortages,fabric_return,allocated_qty,ref2,ref4 AS shade,roll_width,roll_id,fabric_cad_allocation.tran_pin as alloc_type_id,
                    // (
                    //     CASE 
                    //         WHEN fabric_cad_allocation.tran_pin IN ( '" . implode( "', '" , $response_data2 ) . "' ) THEN 1 
                    //         ELSE 0
                    //     END) AS existed
                    // FROM $bai_rm_pj1.`fabric_cad_allocation` left join `bai_rm_pj1`.`store_in` on `bai_rm_pj1`.`fabric_cad_allocation`.roll_id=`bai_rm_pj1`.`store_in`.tid left join `bai_pro3`.`docket_roll_info` on `bai_pro3`.`docket_roll_info`.alloc_type_id=`bai_rm_pj1`.`fabric_cad_allocation`.tran_pin WHERE doc_no='".$doc_no."' group by roll_id" ; 
                    // echo $docketrolls;
                    $docketrolls="SELECT lp_roll_id,roll_no,plies,lay_sequence FROM $pps WHERE lp_lay_id IN ( '" . implode( "', '" , $lpLayId ) . "' ) AND plant_code='$plantcode' AND is_active=1";
                    $docketrollsresult = mysqli_query($link_new,$docketrolls);
                    $response_data=array();
                    if(mysqli_num_rows($docketrollsresult) > 0){
                        $i=0;
                        while($row = mysqli_fetch_array($docketrollsresult))
                        {   
                            $rollNum=$row['roll_no'];
                            /**getting roll attributes */
                            $qryGetattri="SELECT attribute_name,attribute_value FROM $pps.lp_roll_attribute WHERE lp_roll_id='$rollNum' AND plant_code='$plantcode' AND is_active=1";
                            $attributeResult = mysqli_query($link_new,$qryGetattri);
                            while($attriRow = mysqli_fetch_array($attributeResult))
                            {
                                $row[$attriRow['attribute_name']]=$attriRow['attribute_value'];
                            }
                            $row['bgcolor'] = 'white';
                            $response_data[] = $row;
                        }
                        
                        $getCutnumber="SELECT cut_number FROM $pps.jm_cut_job WHERE jm_cut_job_id='$jm_cut_job_id' AND plant_code='$plantcode' AND is_active=1";
                                        // echo $getCutnumber;
                                        $get_cut_number_query_result = mysqli_query($link_new,$getCutnumber);
                                        if(mysqli_num_rows($get_cut_number_query_result) > 0)
                                        { 
                                            while($cut_row = mysqli_fetch_array($get_cut_number_query_result))
                                            {   
                                                $cutNumber=$cut_row['cut_number'];
                                                // $pcut_no=$cut_row['cut_number'];
                                                // $order_tid=$cut_row['order_tid'];
                                                /**getting style wrt ratio_comp_group_id  */
                                                // get the style and master po info
                                                $style_info_query = "SELECT mpc.style,mpc.color 
                                                FROM $pps.mp_color_detail mpc 
                                                LEFT JOIN $pps.mp_order mp ON mpc.master_po_number = mp.master_po_number
                                                WHERE mpc.master_po_details_id = '$mp_detail_id' AND mpc.plant_code='$plantcode' and mpc.is_active=1";
                                                $style_info_result=mysqli_query($link_new, $style_info_query) or exit("Sql style_info_query".mysqli_error($GLOBALS["___mysqli_ston"]));
                                            
                                                while($row = mysqli_fetch_array($style_info_result))
                                                {
                                                    $style = $row['style'];
                                                    $color = $row['color'];
                                                }
                                                
                                                // $get_style_schedule_color_qry="select order_style_no as style,order_del_no as schedule,order_col_des as color from $bai_pro3.bai_orders_db where order_tid ='".$order_tid."'";
                                                // $get_style_schedule_color_qry_res=mysqli_query($link, $get_style_schedule_color_qry) OR EXIT("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                // while($sql_rowx121=mysqli_fetch_array($get_style_schedule_color_qry_res))
                                                // {
                                                //     $style=$sql_rowx121['style'];
                                                //     $schedule=$sql_rowx121['schedule'];
                                                //     $color=$sql_rowx121['color'];
                                                // }
                                                $new_color=$color.'^'.$cutNumber;
                                            }
                                            if($cutNumber){
                                                //$mrn_request_qry="SELECT tid FROM $wms.`mrn_track` WHERE style='".$style."' and schedule='".$schedule."' and color = '".$new_color."' and status='9'";
                                                $mrn_request_qry="SELECT tid FROM $wms.`mrn_track` WHERE style='".$style."'  and color = '".$new_color."' and status='9'";
                                                // echo $mrn_request_qry;
                                                $mrn_request_qry_result = mysqli_query($link,$mrn_request_qry);
                                                if(mysqli_num_rows($mrn_request_qry_result) > 0)
                                                {
                                                    while($mrn_track_row=mysqli_fetch_array($mrn_request_qry_result))
                                                    {
                                                        $tid=$mrn_track_row['tid'];
                                                        $mrn_details="SELECT lay_sequence,reporting_plies,damages,joints,endbits,shortages,fabric_return,iss_qty AS allocated_qty,ref2,ref4 AS shade,ref3 as roll_width,store_in.tid as roll_id,mrn_out_allocation.tid as alloc_type_id FROM $wms.`mrn_out_allocation` LEFT JOIN $wms.`store_in` ON $wms.`mrn_out_allocation`.lable_id=$wms.`store_in`.tid WHERE mrn_tid='".$tid."' GROUP BY mrn_out_allocation.tid"; 
                                                        // echo $mrn_details.'<br/>';
                                                        $mrn_detailsresult = mysqli_query($link,$mrn_details);
                                                        if(mysqli_num_rows($mrn_detailsresult) > 0)
                                                        {
                                                            while($mrn_row=mysqli_fetch_array($mrn_detailsresult))
                                                            {
                                                                $mrn_row['bgcolor'] = 'pink';
                                                                $response_data[] = $mrn_row;
                                                            }
                                                        }
                                                        // var_dump($response_data);
                                                        // $result['response_data']=$mrn_data;
                                                    }
                                                }
                                            }
                                        }

                        $result['totalreportedplie']=$totalreportedplie;
                        $result['response_data']=$response_data;
                        $result['marklength']=$marklength['mklength'];

                        echo json_encode($result);
                        exit(0);
                    }    
                }
            }else
            {
                //$checkdocket="SELECT * FROM $bai_pro3.`plandoc_stat_log` WHERE doc_no=".$doc_no;
                /**check entered docket existing or not in requested table*/
                $checkdocket="SELECT plan_lot_ref FROM $pps.requested_dockets WHERE jm_docket_line_id='$jmDocketLineId' AND plant_code='$plantcode' AND is_active=1";
                $checkdocketresult = mysqli_query($link_new,$checkdocket);
                    if(mysqli_num_rows($checkdocketresult) > 0)
                    {
                        if($row1 = mysqli_fetch_array($checkdocketresult))
                        {
                            if($row1['plan_lot_ref']!="Stock")
                            {
                                    /*get mark length */
                                    // $mlength="SELECT mklength FROM $bai_pro3.`order_cat_doc_mk_mix` WHERE doc_no=".$doc_no;
                                    // $mlengthresult = mysqli_query($link,$mlength);
                                    // $marklength = mysqli_fetch_array($mlengthresult);
                                    $qry_lp_markers="SELECT `length`,`width`,`efficiency`,`marker_version`,`marker_type_name`,`pattern_version`,`perimeter`,`remark1`,`remark2`,`remark3`,`remark4` FROM $pps.`lp_markers` WHERE `ratio_wise_component_group_id`='$ratio_comp_group_id' AND default_marker_version=1 AND `plant_code`='$plantcode' AND is_active=1";
                                    $lp_markers_result=mysqli_query($link_new, $qry_lp_markers) or exit("Sql Errorat_lp_markers".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $lp_markers_num=mysqli_num_rows($lp_markers_result);
                                    if($lp_markers_num>0){
                                        while($sql_row1=mysqli_fetch_array($lp_markers_result))
                                        {
                                            $marklength = $sql_row1['length'];
                                        }
                                    }
                                    // $docketrolls="SELECT lay_sequence,reporting_plies,damages,joints,endbits,shortages,fabric_return,allocated_qty,ref2,ref4 AS shade,roll_width,roll_id,fabric_cad_allocation.tran_pin as alloc_type_id FROM $bai_rm_pj1.`fabric_cad_allocation` left join `bai_rm_pj1`.`store_in` on `bai_rm_pj1`.`fabric_cad_allocation`.roll_id=`bai_rm_pj1`.`store_in`.tid left join `bai_pro3`.`docket_roll_info` on `bai_pro3`.`docket_roll_info`.roll_no=`bai_rm_pj1`.`fabric_cad_allocation`.roll_id AND `bai_pro3`.`docket_roll_info`.docket=`bai_rm_pj1`.`fabric_cad_allocation`.doc_no WHERE doc_no='".$doc_no ."' order by `bai_rm_pj1`.`store_in`.ref4, bai_rm_pj1.fabric_cad_allocation.allocated_qty";
                                    $docketrolls="SELECT allocated_qty,ref2,ref4 AS shade,roll_width,roll_id,fabric_cad_allocation.tran_pin as alloc_type_id FROM $wms.`fabric_cad_allocation` 
                                    left join $wms.`store_in` on $wms.`fabric_cad_allocation`.roll_id=$wms.`store_in`.tid 
                                    WHERE $wms.fabric_cad_allocation.doc_no='".$jmDocketLineId ."' AND $wms.fabric_cad_allocation.plant_code='$plantcode' order by $wms.`store_in`.ref4, $wms.fabric_cad_allocation.allocated_qty";
                                    //echo  $docketrolls;
                                    $docketrollsresult = mysqli_query($link_new,$docketrolls);
                                    $response_data=array();
                                    if(mysqli_num_rows($docketrollsresult) > 0)
                                    {
                                        $i=0;
                                        while($row = mysqli_fetch_array($docketrollsresult))
                                        {   
                                            /**getting lay seq and joints */
                                            $row['bgcolor'] = 'white';
                                            $response_data[] = $row;
                                        }
                                        //$get_cut_number_query="SELECT pcutno,order_tid FROM $bai_pro3.`plandoc_stat_log` WHERE doc_no=".$doc_no;
                                        $getCutnumber="SELECT cut_number FROM $pps.jm_cut_job WHERE jm_cut_job_id='$jm_cut_job_id' AND plant_code='$plantcode' AND is_active=1";
                                        // echo $getCutnumber;
                                        $get_cut_number_query_result = mysqli_query($link_new,$getCutnumber);
                                        if(mysqli_num_rows($get_cut_number_query_result) > 0)
                                        { 
                                            while($cut_row = mysqli_fetch_array($get_cut_number_query_result))
                                            {   
                                                $cutNumber=$cut_row['cut_number'];
                                                // $pcut_no=$cut_row['cut_number'];
                                                // $order_tid=$cut_row['order_tid'];
                                                /**getting style wrt ratio_comp_group_id  */
                                                // get the style and master po info
                                                $style_info_query = "SELECT mpc.style,mpc.color 
                                                FROM $pps.mp_color_detail mpc 
                                                LEFT JOIN $pps.mp_order mp ON mpc.master_po_number = mp.master_po_number
                                                WHERE mpc.master_po_details_id = '$mp_detail_id' AND mpc.plant_code='$plantcode' and mpc.is_active=1";
                                                $style_info_result=mysqli_query($link_new, $style_info_query) or exit("Sql style_info_query".mysqli_error($GLOBALS["___mysqli_ston"]));
                                            
                                                while($row = mysqli_fetch_array($style_info_result))
                                                {
                                                    $style = $row['style'];
                                                    $color = $row['color'];
                                                }
                                                
                                                // $get_style_schedule_color_qry="select order_style_no as style,order_del_no as schedule,order_col_des as color from $bai_pro3.bai_orders_db where order_tid ='".$order_tid."'";
                                                // $get_style_schedule_color_qry_res=mysqli_query($link, $get_style_schedule_color_qry) OR EXIT("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                // while($sql_rowx121=mysqli_fetch_array($get_style_schedule_color_qry_res))
                                                // {
                                                //     $style=$sql_rowx121['style'];
                                                //     $schedule=$sql_rowx121['schedule'];
                                                //     $color=$sql_rowx121['color'];
                                                // }
                                                $new_color=$color.'^'.$cutNumber;
                                            }
                                            if($cutNumber){
                                                //$mrn_request_qry="SELECT tid FROM $wms.`mrn_track` WHERE style='".$style."' and schedule='".$schedule."' and color = '".$new_color."' and status='9'";
                                                $mrn_request_qry="SELECT tid FROM $wms.`mrn_track` WHERE style='".$style."'  and color = '".$new_color."' and status='9'";
                                                // echo $mrn_request_qry;
                                                $mrn_request_qry_result = mysqli_query($link,$mrn_request_qry);
                                                if(mysqli_num_rows($mrn_request_qry_result) > 0)
                                                {
                                                    while($mrn_track_row=mysqli_fetch_array($mrn_request_qry_result))
                                                    {
                                                        $tid=$mrn_track_row['tid'];
                                                        $mrn_details="SELECT lay_sequence,reporting_plies,damages,joints,endbits,shortages,fabric_return,iss_qty AS allocated_qty,ref2,ref4 AS shade,ref3 as roll_width,store_in.tid as roll_id,mrn_out_allocation.tid as alloc_type_id FROM $wms.`mrn_out_allocation` LEFT JOIN $wms.`store_in` ON $wms.`mrn_out_allocation`.lable_id=$wms.`store_in`.tid WHERE mrn_tid='".$tid."' GROUP BY mrn_out_allocation.tid"; 
                                                        // echo $mrn_details.'<br/>';
                                                        $mrn_detailsresult = mysqli_query($link,$mrn_details);
                                                        if(mysqli_num_rows($mrn_detailsresult) > 0)
                                                        {
                                                            while($mrn_row=mysqli_fetch_array($mrn_detailsresult))
                                                            {
                                                                $mrn_row['bgcolor'] = 'pink';
                                                                $response_data[] = $mrn_row;
                                                            }
                                                        }
                                                        // var_dump($response_data);
                                                        // $result['response_data']=$mrn_data;
                                                    }
                                                }
                                            }
                                        }

                                        $result['response_data']=$response_data;
                                        $result['marklength']=$marklength;
                    
                                        echo json_encode($result);
                                        exit(0);
                                    }
                            }else if($row1['plan_lot_ref']=="Stock")
                            {
                                echo "Not Available";
                                exit(0);
                            }
                        } 
                    }
            }    
        }
        

        
            




