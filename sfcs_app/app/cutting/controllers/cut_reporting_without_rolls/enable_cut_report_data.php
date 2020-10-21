<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/m3Updations.php');
$data = $_POST;
$doc_no = $data['doc_no'];

        $finishedrolls="SELECT distinct(roll_no) as roll_no,alloc_type_id FROM $bai_pro3.`docket_roll_info` WHERE docket=".$doc_no;
        $finishedrollsresult = mysqli_query($link,$finishedrolls);
        // echo $finishedrolls;
        if(mysqli_num_rows($finishedrollsresult) > 0)
        {
            while($row = mysqli_fetch_array($finishedrollsresult))
            {
                $response_data1[] = $row['roll_no'];
                $response_data2[] = $row['alloc_type_id'];
            }
            /*get mark length */
            $mlength="SELECT mklength FROM bai_pro3.`order_cat_doc_mk_mix` WHERE doc_no=".$doc_no;
            $mlengthresult = mysqli_query($link,$mlength);
            $marklength = mysqli_fetch_array($mlengthresult);

            $totalreportedplies="SELECT sum(reporting_plies) as totalreportedplies FROM $bai_pro3.`docket_roll_info` where docket=".$doc_no;
            $totalreportedpliesresult = mysqli_query($link,$totalreportedplies);
            $totalreportedplie = mysqli_fetch_array($totalreportedpliesresult);

            $docketrolls="SELECT lay_sequence,reporting_plies,damages,joints,endbits,shortages,fabric_return,allocated_qty,ref2,ref4 AS shade,roll_width,roll_id,fabric_cad_allocation.tran_pin as alloc_type_id,
            (
                CASE 
                    WHEN fabric_cad_allocation.tran_pin IN ( '" . implode( "', '" , $response_data2 ) . "' ) THEN 1 
                    ELSE 0
                END) AS existed
            FROM $bai_rm_pj1.`fabric_cad_allocation` left join `bai_rm_pj1`.`store_in` on `bai_rm_pj1`.`fabric_cad_allocation`.roll_id=`bai_rm_pj1`.`store_in`.tid left join `bai_pro3`.`docket_roll_info` on `bai_pro3`.`docket_roll_info`.alloc_type_id=`bai_rm_pj1`.`fabric_cad_allocation`.tran_pin WHERE doc_no='".$doc_no."' group by roll_id" ; 
            // echo $docketrolls;
            $docketrollsresult = mysqli_query($link,$docketrolls);
            $response_data=array();
            if(mysqli_num_rows($docketrollsresult) > 0){
                $i=0;
                while($row = mysqli_fetch_array($docketrollsresult))
                {
                    $row['bgcolor'] = 'white';
                    $response_data[] = $row;
                }
                $get_cut_number_query="SELECT pcutno,order_tid FROM $bai_pro3.`plandoc_stat_log` WHERE doc_no=".$doc_no;
                $get_cut_number_query_result = mysqli_query($link,$get_cut_number_query);
                if(mysqli_num_rows($get_cut_number_query_result) > 0)
                { 
                    while($cut_row = mysqli_fetch_array($get_cut_number_query_result))
                    {
                        $pcut_no=$cut_row['pcutno'];
                        $order_tid=$cut_row['order_tid'];
                        $get_style_schedule_color_qry="select order_style_no as style,order_del_no as schedule,order_col_des as color from $bai_pro3.bai_orders_db where order_tid ='".$order_tid."'";
                        $get_style_schedule_color_qry_res=mysqli_query($link, $get_style_schedule_color_qry) OR EXIT("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($sql_rowx121=mysqli_fetch_array($get_style_schedule_color_qry_res))
                        {
                            $style=$sql_rowx121['style'];
                            $schedule=$sql_rowx121['schedule'];
                            $color=$sql_rowx121['color'];
                        }
                        $new_color=$color.'^'.$pcut_no;
                    }
                    if($pcut_no){
                        $mrn_request_qry="SELECT tid FROM $bai_rm_pj2.`mrn_track` WHERE style='".$style."' and schedule='".$schedule."' and color = '".$new_color."' and status='9'";
                        // echo $mrn_request_qry;
                        $mrn_request_qry_result = mysqli_query($link,$mrn_request_qry);
                        if(mysqli_num_rows($mrn_request_qry_result) > 0)
                        {
                            while($mrn_track_row=mysqli_fetch_array($mrn_request_qry_result))
                            {
                                $tid[]=$mrn_track_row['tid'];
                            }
                        }
                        $mrn_details="SELECT lay_sequence,reporting_plies,damages,joints,endbits,shortages,fabric_return,iss_qty AS allocated_qty,ref2,ref4 AS shade,ref3 as roll_width,`store_in`.tid  as roll_id,mrn_out_allocation.tid as alloc_type_id,
                        (
                            CASE 
                                WHEN store_in.tid IN ( '" . implode( "', '" , $response_data1 ) . "' ) AND mrn_out_allocation.cut_status=1 THEN 1 
                                ELSE 0
                            END) AS existed FROM bai_rm_pj2.`mrn_out_allocation` LEFT JOIN `bai_rm_pj1`.`store_in` ON `bai_rm_pj2`.`mrn_out_allocation`.lable_id=`bai_rm_pj1`.`store_in`.tid LEFT JOIN `bai_pro3`.`docket_roll_info` ON `bai_pro3`.`docket_roll_info`.alloc_type_id=`bai_rm_pj2`.`mrn_out_allocation`.tid WHERE mrn_tid IN ( '" . implode( "', '" , $tid ) . "' ) GROUP BY mrn_out_allocation.tid"; 
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
                       
                    }
                }
                $result['totalreportedplie']=$totalreportedplie;
                $result['response_data']=$response_data;
                $result['marklength']=$marklength['mklength'];

                echo json_encode($result);
                exit(0);
            } 
            
            
        }else
        {
            $checkdocket="SELECT plan_lot_ref FROM $bai_pro3.`plandoc_stat_log` WHERE doc_no=".$doc_no;
            $checkdocketresult = mysqli_query($link,$checkdocket);
                if(mysqli_num_rows($checkdocketresult) > 0)
                {
                    if($row1 = mysqli_fetch_array($checkdocketresult))
                    {

                        if($row1['plan_lot_ref']!="Stock")
                        {
                                 /*get mark length */
                                $mlength="SELECT mklength FROM $bai_pro3.`order_cat_doc_mk_mix` WHERE doc_no=".$doc_no;
                                $mlengthresult = mysqli_query($link,$mlength);
                                $marklength = mysqli_fetch_array($mlengthresult);

                                $docketrolls="SELECT lay_sequence,reporting_plies,damages,joints,endbits,shortages,fabric_return,allocated_qty,ref2,ref4 AS shade,roll_width,roll_id,fabric_cad_allocation.tran_pin as alloc_type_id FROM $bai_rm_pj1.`fabric_cad_allocation` left join `bai_rm_pj1`.`store_in` on `bai_rm_pj1`.`fabric_cad_allocation`.roll_id=`bai_rm_pj1`.`store_in`.tid left join `bai_pro3`.`docket_roll_info` on `bai_pro3`.`docket_roll_info`.roll_no=`bai_rm_pj1`.`fabric_cad_allocation`.roll_id AND `bai_pro3`.`docket_roll_info`.docket=`bai_rm_pj1`.`fabric_cad_allocation`.doc_no WHERE doc_no='".$doc_no ."' order by `bai_rm_pj1`.`store_in`.ref4, bai_rm_pj1.fabric_cad_allocation.allocated_qty"; 
                                $docketrollsresult = mysqli_query($link,$docketrolls);
                                $response_data=array();
                                if(mysqli_num_rows($docketrollsresult) > 0)
                                {
                                $i=0;
                                while($row = mysqli_fetch_array($docketrollsresult))
                                {
                                    $row['bgcolor'] = 'white';
                                    $response_data[] = $row;
                                }
                                $get_cut_number_query="SELECT pcutno,order_tid FROM $bai_pro3.`plandoc_stat_log` WHERE doc_no=".$doc_no;
                                $get_cut_number_query_result = mysqli_query($link,$get_cut_number_query);
                                if(mysqli_num_rows($get_cut_number_query_result) > 0)
                                { 
                                    while($cut_row = mysqli_fetch_array($get_cut_number_query_result))
                                    {
                                        $pcut_no=$cut_row['pcutno'];
                                        $order_tid=$cut_row['order_tid'];
                                        $get_style_schedule_color_qry="select order_style_no as style,order_del_no as schedule,order_col_des as color from $bai_pro3.bai_orders_db where order_tid ='".$order_tid."'";
                                        $get_style_schedule_color_qry_res=mysqli_query($link, $get_style_schedule_color_qry) OR EXIT("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        while($sql_rowx121=mysqli_fetch_array($get_style_schedule_color_qry_res))
                                        {
                                            $style=$sql_rowx121['style'];
                                            $schedule=$sql_rowx121['schedule'];
                                            $color=$sql_rowx121['color'];
                                        }
                                        $new_color=$color.'^'.$pcut_no;
                                    }
                                    if($pcut_no){
                                        $mrn_request_qry="SELECT tid FROM $bai_rm_pj2.`mrn_track` WHERE style='".$style."' and schedule='".$schedule."' and color = '".$new_color."' and status='9'";
                                        // echo $mrn_request_qry;
                                        $mrn_request_qry_result = mysqli_query($link,$mrn_request_qry);
                                        if(mysqli_num_rows($mrn_request_qry_result) > 0)
                                        {
                                            while($mrn_track_row=mysqli_fetch_array($mrn_request_qry_result))
                                            {
                                                $tid=$mrn_track_row['tid'];
                                                $mrn_details="SELECT lay_sequence,reporting_plies,damages,joints,endbits,shortages,fabric_return,iss_qty AS allocated_qty,ref2,ref4 AS shade,ref3 as roll_width,store_in.tid as roll_id,mrn_out_allocation.tid as alloc_type_id FROM bai_rm_pj2.`mrn_out_allocation` LEFT JOIN `bai_rm_pj1`.`store_in` ON `bai_rm_pj2`.`mrn_out_allocation`.lable_id=`bai_rm_pj1`.`store_in`.tid LEFT JOIN `bai_pro3`.`docket_roll_info` ON `bai_pro3`.`docket_roll_info`.alloc_type_id=`bai_rm_pj2`.`mrn_out_allocation`.tid WHERE mrn_tid='".$tid."' GROUP BY mrn_out_allocation.tid"; 
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
                                $result['marklength']=$marklength['mklength'];
            
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
            




