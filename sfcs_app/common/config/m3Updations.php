
<?php
// LOGIC TO INSERT TRANSACTIONS IN M3_TRANSACTIONS TABLE
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/rest_api_calls.php');
function updateM3Transactions($ref_id,$op_code,$qty)
{
    $obj = new rest_api_calls();    
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');

    $host = $api_hostname;
    $port = $api_port_no;
    $company_num = $company_no;
    $plant_code = $global_facility_code;

    $details_query = "Select shift,assigned_module,style,mapped_color from $brandix_bts.bundle_creation_data where bundle_number = $ref_id and operation_id = $op_code";
    $details_result = mysqli_query($link,$details_query) or exit("Problem in getting details from the BCD");
    while($row = mysqli_fetch_array($details_result)){
        $input_shift = $row['shift'];
        $plan_module  = $row['assigned_module'];
        $style = $row['style'];
        $color = $row['mapped_color'];
    }
    $current_date = date("Y-m-d H:i:s");
    $b_shift  = $input_shift;
    $b_module = $plan_module;

    //getting work_station_id
    $qry_to_get_work_station_id = "SELECT work_center_id,short_cut_code FROM $brandix_bts.`tbl_orders_ops_ref` WHERE operation_code = '$op_code'";
    $result_qry_to_get_work_station_id=mysqli_query($link,$qry_to_get_work_station_id) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row=mysqli_fetch_array($result_qry_to_get_work_station_id))
    {
        $work_station_id = $row['work_center_id'];
        $short_key_code  = $row['short_cut_code'];
    }
    if(!$work_station_id)
    {
        $qry_to_get_work_station_id = "SELECT work_station_id FROM bai_pro3.`work_stations_mapping` WHERE operation_code = '$short_key_code' AND module = '$b_module'";
        $result_qry_to_get_work_station_id=mysqli_query($link,$qry_to_get_work_station_id) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($row=mysqli_fetch_array($result_qry_to_get_work_station_id))
        {
            $work_station_id = $row['work_station_id'];
        } 
    }
    //getting mos and filling up

    $qry_to_check_mo_numbers = "SELECT *,mq.id as mq_id FROM $bai_pro3.`mo_operation_quantites` mq  
                                where ref_no = $ref_id and op_code=$op_code";
    $qry_nop_result=mysqli_query($link,$qry_to_check_mo_numbers) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
    $total_bundle_present_qty = $qty;
    $total_bundle_rec_present_qty = $qty;
    while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
    {
        $total_bundle_present_qty = $total_bundle_rec_present_qty;
        if($total_bundle_present_qty > 0)
        {
            $mo_number = trim($nop_qry_row['mo_no']);
            $mo_quantity = $nop_qry_row['bundle_quantity'];
            $good_quantity_past = $nop_qry_row['good_quantity'];
            $rejected_quantity_past = $nop_qry_row['rejected_quantity'];
            $id = $nop_qry_row['mq_id'];
            $ops_des = $nop_qry_row ['op_desc'];
            $balance_max_updatable_qty = $mo_quantity - ($good_quantity_past + $rejected_quantity_past);
            if($balance_max_updatable_qty > 0)
            {
                if($balance_max_updatable_qty >= $total_bundle_rec_present_qty)
                {
                    $to_update_qty = $total_bundle_rec_present_qty; 
                    $actual_rep_qty = $good_quantity_past+$total_bundle_rec_present_qty;
                    $update_qry = "update $bai_pro3.mo_operation_quantites set good_quantity = $actual_rep_qty where id= $id";
                    $total_bundle_rec_present_qty = 0;
                }
                else
                {
                    $to_update_qty = $balance_max_updatable_qty; 
                    $actual_rep_qty = $good_quantity_past+$balance_max_updatable_qty;
                    $update_qry = "update $bai_pro3.mo_operation_quantites set good_quantity = $actual_rep_qty where id= $id";
                    $total_bundle_rec_present_qty = $total_bundle_rec_present_qty - $balance_max_updatable_qty;
                }
                $ims_pro_qty_updating = mysqli_query($link,$update_qry) or exit("While updating mo_operation_quantites".mysqli_error($GLOBALS["___mysqli_ston"]));

                // 763 mo filling for new operation start
                // To get last operation in sewing category for that style and color
                    $application='sewing';
                    $get_last_opn_sewing = "SELECT tbl_style_ops_master.operation_code FROM $brandix_bts.tbl_style_ops_master LEFT JOIN $brandix_bts.`tbl_orders_ops_ref` ON tbl_orders_ops_ref.operation_code = tbl_style_ops_master.operation_code WHERE style='$style' AND color = '$color' AND category='$application' ORDER BY CAST(tbl_style_ops_master.operation_order AS CHAR) DESC LIMIT 1";
                    $result_last_opn_sewing=mysqli_query($link, $get_last_opn_sewing) or exit("error while fetching pre_op_code_b4_carton_ready");
                    if (mysqli_num_rows($result_last_opn_sewing) > 0)
                    {
                        $final_op_code=mysqli_fetch_array($result_last_opn_sewing);
                        $sewing_last_opn = $final_op_code['operation_code'];
                    }
                    
                    if($sewing_last_opn == $op_code)
                    {
                        $get_count = "SELECT COUNT(*) as count FROM $bai_pro3.`tbl_carton_ready` WHERE mo_no='$mo_number'";
                        $count_result = $link->query($get_count);
                        while($row = $count_result->fetch_assoc()) 
                        {
                            $count = $row['count'];
                        }

                        if ($count > 0)
                        {
                            $update_tbl_carton_ready = "UPDATE $bai_pro3.tbl_carton_ready set remaining_qty = remaining_qty + $to_update_qty, cumulative_qty = cumulative_qty + $to_update_qty where mo_no= '$mo_number'";
							mysqli_query($link,$update_tbl_carton_ready);
                        }
                        else
                        {
                            $insert_tbl_carton_ready = "INSERT INTO $bai_pro3.tbl_carton_ready (operation_id, mo_no, remaining_qty, cumulative_qty) VALUES ('$op_code', '$mo_number', '$to_update_qty', '$to_update_qty')";
							mysqli_query($link,$insert_tbl_carton_ready);
                            $affectced_rows=mysqli_affected_rows($link);
                            if($affectced_rows == -1)
                            {
                                $insert_update_tbl_carton_ready = "UPDATE $bai_pro3.tbl_carton_ready set remaining_qty = remaining_qty + $to_update_qty, cumulative_qty = cumulative_qty + $to_update_qty where mo_no= '$mo_number'";
                                mysqli_query($link,$insert_update_tbl_carton_ready);
                            }
                        }
                        //mysqli_query($link,$insert_update_tbl_carton_ready);
                    }                                                                                      
                // 763 mo filling for new operation end
                $dep_ops_array_qry = "select default_operration from $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$color' and operation_code=$op_code";
                $result_dep_ops_array_qry = $link->query($dep_ops_array_qry);
                while($row = $result_dep_ops_array_qry->fetch_assoc()) 
                {
                    $is_m3 = $row['default_operration'];
                }
                if(strtolower($is_m3) == 'yes')
                {
                    //getting m3_op_code
                    $bundle_creation_data_check = "SELECT Main_OperationNumber FROM $bai_pro3.schedule_oprations_master WHERE MONumber = '$mo_number' AND OperationNumber = $op_code";
                    $bundle_creation_data_check_result=mysqli_query($link, $bundle_creation_data_check) or exit("Sql Error bundle_creation_data_check".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if(mysqli_num_rows($bundle_creation_data_check_result) > 0)
                    {
                        while($row_bundle_creation_data_check_result =mysqli_fetch_array($bundle_creation_data_check_result))
                        {
                            $main_ops_code = $row_bundle_creation_data_check_result['Main_OperationNumber'];
                        }
                    }
                    //got the main ops code
                    $cur_date = date('Y-m-d H:s:i');
                    $inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`m3_ops_code`,`response_status`,`api_type`) 
                    VALUES ('$current_date','$mo_number',$to_update_qty,'','Normal','$username','','$b_module','$b_shift',$op_code,'$ops_des',$id,'$work_station_id','$main_ops_code','pending','opn')";
                    mysqli_query($link,$inserting_into_m3_tran_log) or exit("While inserting into m3_tranlog".mysqli_error($GLOBALS["___mysqli_ston"]));
                }                
            }
        }
    } 
    return true;
}
function updateM3TransactionsReversal($bundle_no,$reversalval,$op_code)
{
    $obj = new rest_api_calls();
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    $current_date = date("Y-m-d H:i:s");

    $host = $api_hostname;
    $port = $api_port_no;
    $company_num = $company_no;
    $plant_code = $global_facility_code;
    
    $details_query = "Select shift,assigned_module,style,mapped_color from $brandix_bts.bundle_creation_data where bundle_number = $bundle_no and operation_id = $op_code";
    $details_result = mysqli_query($link,$details_query) or exit("Problem in getting details from the BCD");
    while($row = mysqli_fetch_array($details_result)){
        $input_shift = $row['shift'];
        $plan_module  = $row['assigned_module'];
        $style = $row['style'];
        $color = $row['mapped_color'];
        $b_colors = $row['mapped_color'];
    }
    $b_tid    = $bundle_no;
    $b_rep_qty= $reversalval;
    
    $qry_to_get_work_station_id = "SELECT work_center_id,short_cut_code FROM $brandix_bts.`tbl_orders_ops_ref` WHERE operation_code = '$op_code'";
    $result_qry_to_get_work_station_id=mysqli_query($link,$qry_to_get_work_station_id) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row=mysqli_fetch_array($result_qry_to_get_work_station_id))
    {
        $work_station_id = $row['work_center_id'];
        $short_key_code  = $row['short_cut_code'];
    }
    if(!$work_station_id)
    {
        $qry_to_get_work_station_id = "SELECT work_station_id FROM bai_pro3.`work_stations_mapping` WHERE operation_code = '$short_key_code' AND module = '$plan_module'";
        $result_qry_to_get_work_station_id=mysqli_query($link,$qry_to_get_work_station_id) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($row=mysqli_fetch_array($result_qry_to_get_work_station_id))
        {
            $work_station_id = $row['work_station_id'];
        } 
    }
    $qry_to_check_mo_numbers = "select * from $bai_pro3.mo_operation_quantites where ref_no = $bundle_no and op_code = $op_code order by mo_no*1";
    $qry_nop_result=mysqli_query($link,$qry_to_check_mo_numbers) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
    $total_bundle_rec_present_qty = $b_rep_qty;
    while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
    {
        $total_bundle_present_qty = $total_bundle_rec_present_qty;
        if($total_bundle_present_qty > 0)
        {
            $mo_number = trim($nop_qry_row['mo_no']);
            $mo_quantity = $nop_qry_row['bundle_quantity'];
            $good_quantity_past = $nop_qry_row['good_quantity'];
            $rejected_quantity_past = $nop_qry_row['rejected_quantity'];
            $id = $nop_qry_row['id'];
            $balance_max_updatable_qty = $good_quantity_past ;
            if($balance_max_updatable_qty > 0)
            {
                if($balance_max_updatable_qty >= $total_bundle_rec_present_qty)
                {
                    $to_update_qty = $total_bundle_rec_present_qty; 
                    $actual_rep_qty = $good_quantity_past-$total_bundle_rec_present_qty;
                    $update_qry = "update $bai_pro3.mo_operation_quantites set good_quantity = $actual_rep_qty where id= $id";
                    $total_bundle_rec_present_qty = 0;
                }
                else
                {
                    $to_update_qty = $balance_max_updatable_qty; 
                    $actual_rep_qty = $good_quantity_past-$balance_max_updatable_qty;
                    $update_qry = "update $bai_pro3.mo_operation_quantites set good_quantity = $actual_rep_qty where id= $id";
                    $total_bundle_rec_present_qty = $total_bundle_rec_present_qty - $balance_max_updatable_qty;
                }

                // 763 mo filling for new operation start
                    $application='Carton_Ready';
                    $get_routing_query="SELECT operation_code from $brandix_bts.tbl_ims_ops where appilication='$application'";
                    $routing_result=mysqli_query($link, $get_routing_query) or exit("error while fetching opn routing");
                    if (mysqli_num_rows($routing_result) > 0)
                    {
                        $opn_routing=mysqli_fetch_array($routing_result);
                        $opn_routing_code = $opn_routing['operation_code'];
                    }
                    else
                    {
                        $opn_routing_code = 200;
                    }

                    $get_details_b4_carton_ready = "SELECT ops_sequence,operation_order FROM $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$color' AND operation_code=$opn_routing_code";
                    $result_details_b4_carton_ready=mysqli_query($link, $get_details_b4_carton_ready) or exit("error while fetching pre_op_code_b4_carton_ready");
                    if (mysqli_num_rows($result_details_b4_carton_ready) > 0)
                    {
                        $op_order=mysqli_fetch_array($result_details_b4_carton_ready);
                        $ops_sequence = $op_order['ops_sequence'];
                        $operation_order = $op_order['operation_order'];

                        $get_pre_op_code_b4_carton_ready = "SELECT operation_code FROM $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$color' AND ops_sequence = '$ops_sequence' AND CAST(operation_order AS CHAR) < '$operation_order' AND operation_code NOT IN (10,200,15) ORDER BY operation_order DESC LIMIT 1;";
                        $result_pre_op_b4_carton_ready=mysqli_query($link, $get_pre_op_code_b4_carton_ready) or exit("error while fetching pre_op_code_b4_carton_ready");
                        if (mysqli_num_rows($result_pre_op_b4_carton_ready) > 0)
                        {
                            $final_op_code=mysqli_fetch_array($result_pre_op_b4_carton_ready);
                            $opn_b4_200 = $final_op_code['operation_code'];
                        }
                        
                        if ($opn_b4_200 == $op_code)
                        {
                            $get_count = "SELECT COUNT(*) as count FROM $bai_pro3.`tbl_carton_ready` WHERE mo_no='$mo_number'";
                            $count_result = $link->query($get_count);
                            while($row = $count_result->fetch_assoc()) 
                            {
                                $count = $row['count'];
                            }

                            if ($count > 0)
                            {
                                $insert_update_tbl_carton_ready = "UPDATE $bai_pro3.tbl_carton_ready set remaining_qty = remaining_qty - $to_update_qty, cumulative_qty = cumulative_qty - $to_update_qty where mo_no= '$mo_number'";
                                mysqli_query($link,$insert_update_tbl_carton_ready) or exit("While updating/inserting tbl_carton_ready");
                            }
                        }
                    }                          
                // 763 mo filling for new operation end

                $ims_pro_qty_updating = mysqli_query($link,$update_qry) or exit("While updating mo_operation_quantites".mysqli_error($GLOBALS["___mysqli_ston"]));
                $dep_ops_array_qry = "select default_operration from $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$b_colors' and operation_code=$op_code";
                $result_dep_ops_array_qry = $link->query($dep_ops_array_qry);
                while($row = $result_dep_ops_array_qry->fetch_assoc()) 
                {
                    $is_m3 = $row['default_operration'];
                }
                
                if($is_m3 == 'Yes' || $is_m3 == 'yes' || $is_m3 == 'YES')
                {
                        //getting m3_op_code
                        $bundle_creation_data_check = "SELECT Main_OperationNumber FROM bai_pro3.schedule_oprations_master WHERE MONumber = '$mo_number' AND OperationNumber = $op_code";
                        $bundle_creation_data_check_result=mysqli_query($link, $bundle_creation_data_check) or exit("Sql Error bundle_creation_data_check".mysqli_error($GLOBALS["___mysqli_ston"]));
                        if(mysqli_num_rows($bundle_creation_data_check_result) > 0)
                        {
                            while($row_bundle_creation_data_check_result =mysqli_fetch_array($bundle_creation_data_check_result))
                            {
                                $main_ops_code = $row_bundle_creation_data_check_result['Main_OperationNumber'];
                            }
                        }
                        //got the main ops code                    
                    $to_update_qty = '-'.$to_update_qty;
                    $inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`,`m3_ops_code`,`api_type`) 
                        VALUES ('$current_date','$mo_number','$to_update_qty','','Normal','$username','',$plan_module,'$input_shift',$op_code,'',$id,'$work_station_id','pending','$main_ops_code','opn')";
                    mysqli_query($link,$inserting_into_m3_tran_log) or exit("While inserting into m3_tranlog".mysqli_error($GLOBALS["___mysqli_ston"]));
                }
            }
        }
    }
    return true;
    
}
function updateM3TransactionsRejections($ref_id,$op_code,$r_qty,$r_reasons)
{
    $obj = new rest_api_calls();
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    $current_date = date("Y-m-d H:i:s");

    $host = $api_hostname;
    $port = $api_port_no;
    $company_num = $company_no;
    $plant_code = $global_facility_code;
    
    $details_query = "Select shift,assigned_module,style,mapped_color from $brandix_bts.bundle_creation_data where bundle_number = $ref_id and operation_id = $op_code";
    $details_result = mysqli_query($link,$details_query) or exit("Problem in getting details from the BCD");
    while($row = mysqli_fetch_array($details_result)){
        $input_shift = $row['shift'];
        $plan_module  = $row['assigned_module'];
        $style = $row['style'];
        $color = $row['mapped_color'];
        $b_colors = $row['mapped_color'];
    }
    //getting main operation_code from operation mapping
    if($op_code != 15)
    {
        $dep_ops_array_qry1 = "select default_operration,operation_order,main_operationnumber from $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$color' and operation_code=$op_code";
        $result_dep_ops_array_qry1 = $link->query($dep_ops_array_qry1);
        while($row1 = $result_dep_ops_array_qry1->fetch_assoc()) 
        {
            $def_op = $row1['default_operration'];
            $operation_order = $row1['operation_order'];
            $main_operationnumber = $row1['main_operationnumber'];
        }

        if($def_op=='yes'|| $def_op=='Yes')
		{
            $main_ops_code = $main_operationnumber;
        }
        else{
            //query excluding packing in rejection
            $dep_ops_array_qry2="SELECT tm.main_operationnumber FROM $brandix_bts.tbl_style_ops_master tm LEFT JOIN $brandix_bts.tbl_orders_ops_ref tr ON tr.operation_code=tm.operation_code WHERE tm.style ='$style' AND tm.color='$color' AND default_operration='yes' AND tr.category <> 'packing' and tm.operation_order > '$operation_order' ORDER BY tm.operation_order ASC limit 1";

            // $dep_ops_array_qry2 = "select main_operationnumber from $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$color' and default_operration='yes' and operation_order > '$operation_order' order by ASC limit 1";//quiry with including packing
            $result_dep_ops_array_qry2 = $link->query($dep_ops_array_qry2);
            if(mysqli_num_rows($result_dep_ops_array_qry2) > 0)
            {
                while($row2 = $result_dep_ops_array_qry2->fetch_assoc()) 
                {
                    $main_ops_code = $row2['main_operationnumber'];
                }
            }else
            {
                //query excluding packing in rejections
                $dep_ops_array_qry3="SELECT tm.main_operationnumber FROM $brandix_bts.tbl_style_ops_master tm LEFT JOIN $brandix_bts.tbl_orders_ops_ref tr ON tr.operation_code=tm.operation_code WHERE tm.style ='$style' AND tm.color='$color' AND default_operration='yes' AND tr.category <> 'packing' and tm.operation_order < '$operation_order' ORDER BY tm.operation_order DESC limit 1";
               
                // $dep_ops_array_qry3 = "select main_operationnumber from $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$color' and default_operration='yes' and operation_order < '$operation_order' order by DESC limit 1";//query including packing in rejections
                $result_dep_ops_array_qry3 = $link->query($dep_ops_array_qry3);
                while($row3 = $result_dep_ops_array_qry3->fetch_assoc()) 
                {
                    $main_ops_code = $row3['main_operationnumber'];
                } 
            }
        }

    }
    else
    {
        $main_ops_code = $op_code;
    }
    
    $b_shift  = $input_shift;
    $b_module = $plan_module;

    //getting work_station_id
    $qry_to_get_work_station_id = "SELECT work_center_id,short_cut_code FROM $brandix_bts.`tbl_orders_ops_ref` WHERE operation_code = '$main_ops_code'";
    $result_qry_to_get_work_station_id=mysqli_query($link,$qry_to_get_work_station_id) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row=mysqli_fetch_array($result_qry_to_get_work_station_id))
    {
        if(mysqli_num_rows($result_qry_to_get_work_station_id) > 0)
        {
            $work_station_id = $row['work_center_id'];
            $short_key_code  = $row['short_cut_code'];
        }
        if(!$work_station_id)
        {
            $qry_to_get_work_station_id1 = "SELECT work_center_id,short_cut_code FROM $brandix_bts.`tbl_orders_ops_ref` WHERE operation_code = '$op_code'";
            $result_qry_to_get_work_station_id1=mysqli_query($link,$qry_to_get_work_station_id1) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($row1=mysqli_fetch_array($result_qry_to_get_work_station_id1))
            {
                if(mysqli_num_rows($result_qry_to_get_work_station_id) > 0)
                {
                    $work_station_id = $row1['work_center_id'];
                    $short_key_code  = $row1['short_cut_code'];
                }
            }
        }
    }
    if(!$work_station_id)
    {
        $qry_to_get_work_station_id2 = "SELECT work_station_id FROM bai_pro3.`work_stations_mapping` WHERE operation_code = '$short_key_code' AND module = '$b_module'";
        $result_qry_to_get_work_station_id2=mysqli_query($link,$qry_to_get_work_station_id2) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($row2=mysqli_fetch_array($result_qry_to_get_work_station_id2))
        {
            $work_station_id = $row2['work_station_id'];
        } 
    }

    foreach($r_qty as $key=>$value)
    {
        $qry_to_check_mo_numbers = "SELECT *,mq.id as mq_id FROM $bai_pro3.`mo_operation_quantites` mq  
                                    where ref_no = $ref_id and op_code=$op_code ";
        $qry_nop_result=mysqli_query($link,$qry_to_check_mo_numbers) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
        $total_bundle_rej_present_qty = $r_qty[$key];
        while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
        {
            $total_bundle_present_qty = $total_bundle_rej_present_qty;
            $mo_number = trim($nop_qry_row['mo_no']);
            $mo_quantity = $nop_qry_row['bundle_quantity'];
            $ops_des = $nop_qry_row['op_desc'];
            $good_quantity_past = $nop_qry_row['good_quantity'];
            $rejected_quantity_past = $nop_qry_row['rejected_quantity'];
            $id = $nop_qry_row['id'];
            $balance_max_updatable_qty = $mo_quantity - ($good_quantity_past + $rejected_quantity_past);
            if($total_bundle_present_qty > 0)
            {
                if($balance_max_updatable_qty > 0)
                {
                    if($balance_max_updatable_qty >= $total_bundle_rej_present_qty)
                    {
                        $to_update_qty = $total_bundle_rej_present_qty;
                        $actual_rej_qty = $rejected_quantity_past+$total_bundle_rej_present_qty;
                        $update_qry = "update $bai_pro3.mo_operation_quantites set rejected_quantity = $actual_rej_qty where id= $id";
                        $total_bundle_rej_present_qty = 0;
                    }
                    else
                    {
                        $to_update_qty = $balance_max_updatable_qty;
                        $actual_rej_qty = $rejected_quantity_past+$balance_max_updatable_qty;
                        $update_qry = "update $bai_pro3.mo_operation_quantites set rejected_quantity = $actual_rej_qty where id= $id";
                        $total_bundle_rej_present_qty = $total_bundle_rej_present_qty - $balance_max_updatable_qty;
                    }
                    $ims_pro_qty_updating = mysqli_query($link,$update_qry) or exit("While updating mo_operation_quantites".mysqli_error($GLOBALS["___mysqli_ston"]));
                
                    $dep_ops_array_qry = "select default_operration from $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$color' and operation_code=$op_code";
                    $result_dep_ops_array_qry = $link->query($dep_ops_array_qry);
                    while($row = $result_dep_ops_array_qry->fetch_assoc()) 
                    {
                        $is_m3 = $row['default_operration'];
                    }
                   
                        //got the main ops code
                    if($is_m3 == 'Yes' || $is_m3 == 'yes' || $is_m3 == 'YES')
                    {
                        $rej_opn_sch_opn_master = "SELECT Main_OperationNumber FROM bai_pro3.schedule_oprations_master WHERE MONumber = '$mo_number' AND OperationNumber = $op_code";
                        $rej_opn_sch_opn_res=mysqli_query($link, $rej_opn_sch_opn_master) or exit("Sql Error sch opn master opn for rejections".mysqli_error($GLOBALS["___mysqli_ston"]));
                        if(mysqli_num_rows($rej_opn_sch_opn_res) > 0)
                        {
                            while($row_rej_opn_sch_opn_res=mysqli_fetch_array($rej_opn_sch_opn_res))
                            {
                                $main_ops_code = $row_rej_opn_sch_opn_res['Main_OperationNumber'];
                            }
                        }
                    }
                    // if(strtolower($is_m3) == 'yes')
                    // {
                        $inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`,`m3_ops_code`,`api_type`) 
                        VALUES ('$current_date','$mo_number',$to_update_qty,'$r_reasons[$key]','Normal','$username','',$b_module,'$b_shift',$op_code,'$ops_des',$id,'$work_station_id','pending','$main_ops_code','opn')";
                        mysqli_query($link,$inserting_into_m3_tran_log) or exit("While inserting into the m3_transactions".mysqli_error($GLOBALS["___mysqli_ston"]));
                    
                    // }
                }
            }
        }
    }
    return true;
}
function updateM3CartonScan($b_op_id, $b_tid, $team_id, $deduct_from_carton_ready)
{
    $obj = new rest_api_calls();
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    error_reporting(0);
    $current_date = date("Y-m-d H:i:s");
    $fg_opn = 200;

    $host = $api_hostname;
    $port = $api_port_no;
    $company_num = $company_no;
    $plant_code = $global_facility_code;

    $flag_ok = 0;   $flag_nok = 0;
    //getting workstation id
    $qry_to_get_work_station_id = "SELECT work_center_id,short_cut_code FROM $brandix_bts.`tbl_orders_ops_ref` WHERE category='packing' AND default_operation='Yes';";
    $result_qry_to_get_work_station_id=mysqli_query($link,$qry_to_get_work_station_id) or exit("Error while getting workstation  id");
    while($row=mysqli_fetch_array($result_qry_to_get_work_station_id))
    {
        $work_station_id = $row['work_center_id'];
        $short_key_code = $row['short_cut_code'];
    }

    $mo_array  = array();   $mo_qty_array = array();
    $validate_qry = "SELECT mo_no,sum(bundle_quantity) as bun_quantity from $bai_pro3.mo_operation_quantites where ref_no in (".$b_tid.") and op_code = $b_op_id group by mo_no*1";
    //echo $validate_qry;
    $qry_nop_result=mysqli_query($link,$validate_qry) or exit("Bundles Query Error14 => ".$validate_qry);
    while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
    {
        $mo_array[] = $nop_qry_row['mo_no'];
        $mo_qty_array[] = $nop_qry_row['bun_quantity'];
    }

    if ($deduct_from_carton_ready)
    {
        for ($i=0; $i < sizeof($mo_array); $i++)
        {
            $check_in_tbl_carton_ready = "select remaining_qty from bai_pro3.tbl_carton_ready where mo_no = $mo_array[$i] ";
            //echo $check_in_tbl_carton_ready;
            $tbl_carton_ready_check_result=mysqli_query($link,$check_in_tbl_carton_ready) or exit("error while fetching tbl_carton_ready");
            if (mysqli_num_rows($tbl_carton_ready_check_result) > 0)
            {
                while($result=mysqli_fetch_array($tbl_carton_ready_check_result))
                {
                    $remaining_qty = $result['remaining_qty'];
                    if (($remaining_qty - $mo_qty_array[$i]) >= 0)
                    {
                        // mo eligible for scan
                        $flag_ok = 1;
                    }
                    else
                    {
                        // mo not eligible for scan
                        $flag_nok = 1;
                    }
                }
            }
            else
            {
                $flag_nok = 1;
            } 
        }
    }
    else
    {
        $flag_ok = 1;
    }  
    //echo $flag_nok;
    if ($flag_nok == 0)
    {
        $qry_to_check_mo_numbers = "select * from $bai_pro3.mo_operation_quantites where ref_no in (".$b_tid.") and op_code = $b_op_id";
        // echo $qry_to_check_mo_numbers;
        $qry_nop_result=mysqli_query($link,$qry_to_check_mo_numbers) or exit("Bundles Query Error14 => ".$qry_to_check_mo_numbers);
        while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
        {
            $mo_number = trim($nop_qry_row['mo_no']);
            $mo_quantity = $nop_qry_row['bundle_quantity'];
            $good_quantity_past = $nop_qry_row['good_quantity'];
            $id = $nop_qry_row['id'];

            if ($deduct_from_carton_ready)
            {
                $insert_update_tbl_carton_ready = "UPDATE $bai_pro3.tbl_carton_ready set remaining_qty = remaining_qty - $mo_quantity where mo_no= '$mo_number'";
                // echo $insert_update_tbl_carton_ready;
                mysqli_query($link,$insert_update_tbl_carton_ready) or exit("While updating tbl_carton_ready");
            }

                $update_qry = "update $bai_pro3.mo_operation_quantites set good_quantity = $mo_quantity where id = $id";
                // echo $update_qry;
                mysqli_query($link,$update_qry) or exit("While updating mo_operation_quantites"); 
                
                //M3 Rest API Call START
                //getting m3_op_code
                $bundle_creation_data_check = "SELECT Main_OperationNumber FROM bai_pro3.schedule_oprations_master WHERE MONumber = '$mo_number' AND OperationNumber = $b_op_id";
                $bundle_creation_data_check_result=mysqli_query($link, $bundle_creation_data_check) or exit("Sql Error bundle_creation_data_check".mysqli_error($GLOBALS["___mysqli_ston"]));
                if(mysqli_num_rows($bundle_creation_data_check_result) > 0)
                {
                    while($row_bundle_creation_data_check_result =mysqli_fetch_array($bundle_creation_data_check_result))
                    {
                        $main_ops_code = $row_bundle_creation_data_check_result['Main_OperationNumber'];
                    }
                }
                // 200 Operation start
                $inserting_into_m3_tran_log_pms070mi = "INSERT INTO $bai_pro3.`m3_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`module_no`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`,`m3_ops_code`,`api_type`) VALUES ('".date('Y-m-d H:i:s')."','$mo_number','$mo_quantity','','Normal','$username','$team_id','$b_op_id','$short_key_code','$id','$work_station_id','pending','$main_ops_code','opn')";
                // echo $inserting_into_m3_tran_log_pms070mi;
                mysqli_query($link,$inserting_into_m3_tran_log_pms070mi) or exit("While inserting into m3_tranlog pms070mi");
                                      
                // 200 Operation End
                if ($b_op_id == $fg_opn)
                {
                    // FG start
                        $inserting_into_m3_tran_log_fg_pms050mi = "INSERT INTO $bai_pro3.`m3_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`module_no`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`,`m3_ops_code`,`api_type`) VALUES ('".date('Y-m-d H:i:s')."','$mo_number','$mo_quantity','','Normal','$username','$team_id','$b_op_id','$short_key_code','$id','$work_station_id','pending','$main_ops_code','fg')";
                        // echo $inserting_into_m3_tran_log_fg_pms050mi;
                        mysqli_query($link,$inserting_into_m3_tran_log_fg_pms050mi) or exit("While inserting into m3_tranlog");
                                             
                    // FG End
                }  
            //M3 Rest API Call END
        }
        return 1;
    }
    else
    {
        return 0;
    }   
}

function updateM3CartonScanReversal($b_op_id, $b_tid, $deduct_from_carton_ready)
{
    $obj = new rest_api_calls();
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    $current_date = date("Y-m-d H:i:s");
    $fg_opn = 200;
    $host = $api_hostname;
    $port = $api_port_no;
    $company_num = $company_no;
    $plant_code = $global_facility_code;

    $b_op_id_query = "SELECT work_center_id,short_cut_code FROM $brandix_bts.`tbl_orders_ops_ref` WHERE category='packing' AND default_operation='Yes';";
    $sql_result=mysqli_query($link, $b_op_id_query) or exit("Error while fetching operation code");
    while($sql_row=mysqli_fetch_array($sql_result))
    {
        $work_station_id = $sql_row['work_center_id'];
        $short_key_code = $sql_row['short_cut_code'];
    }

    $qry_to_check_mo_numbers = "select * from $bai_pro3.mo_operation_quantites where ref_no in (".$b_tid.") and op_code = $b_op_id";
    $qry_nop_result=mysqli_query($link,$qry_to_check_mo_numbers) or exit("Bundles Query Error14 => ".$qry_to_check_mo_numbers);
    while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
    {
        $mo_number = trim($nop_qry_row['mo_no']);
        $mo_quantity = $nop_qry_row['bundle_quantity'];
        $good_quantity_past = $nop_qry_row['good_quantity'];
        $id = $nop_qry_row['id'];
        $negative_qty = $good_quantity_past * -1;

        // $insert_update_tbl_carton_ready = "UPDATE $bai_pro3.tbl_carton_ready set remaining_qty = remaining_qty + $good_quantity_past where mo_no= '$mo_number'";
        // echo $insert_update_tbl_carton_ready;
        // mysqli_query($link,$insert_update_tbl_carton_ready) or exit("While updating tbl_carton_ready");

        if ($deduct_from_carton_ready)
        {
            $insert_update_tbl_carton_ready = "UPDATE $bai_pro3.tbl_carton_ready set remaining_qty = remaining_qty + $good_quantity_past where mo_no= '$mo_number'";
            // echo $insert_update_tbl_carton_ready;
            mysqli_query($link,$insert_update_tbl_carton_ready) or exit("While updating tbl_carton_ready");
        }
        $update_qry = "update $bai_pro3.mo_operation_quantites set good_quantity = '0' where id= $id";
        mysqli_query($link,$update_qry) or exit("While updating mo_operation_quantites");

        // M3 Rest API Call START
            $bundle_creation_data_check = "SELECT Main_OperationNumber FROM bai_pro3.schedule_oprations_master WHERE MONumber = '$mo_number' AND OperationNumber = $b_op_id";
            $bundle_creation_data_check_result=mysqli_query($link, $bundle_creation_data_check) or exit("Sql Error bundle_creation_data_check".mysqli_error($GLOBALS["___mysqli_ston"]));
            if(mysqli_num_rows($bundle_creation_data_check_result) > 0)
            {
                while($row_bundle_creation_data_check_result =mysqli_fetch_array($bundle_creation_data_check_result))
                {
                    $main_ops_code = $row_bundle_creation_data_check_result['Main_OperationNumber'];
                }
            }
            // 200 Operation start
            $inserting_into_m3_tran_log_pms070mi = "INSERT INTO $bai_pro3.`m3_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`,`m3_ops_code`,`api_type`) VALUES ('".date('Y-m-d H:i:s')."','$mo_number','$negative_qty','','cpk_reversal','$username','$b_op_id','$short_key_code','$id','$work_station_id','pending','$main_ops_code','opn')";
            // echo $inserting_into_m3_tran_log_pms070mi;
            mysqli_query($link,$inserting_into_m3_tran_log_pms070mi) or exit("While inserting into m3_tranlog pms070mi");
                
            // 200 Operation End
            if ($b_op_id == $fg_opn)
            {
                // FG start
                $inserting_into_m3_tran_log_pms050mi = "INSERT INTO $bai_pro3.`m3_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`,`m3_ops_code`,`api_type`) VALUES ('".date('Y-m-d H:i:s')."','$mo_number','$negative_qty','','cpk_reversal','$username','$b_op_id','$short_key_code','$id','$work_station_id','pending','$main_ops_code','fg')";
                // echo $inserting_into_m3_tran_log_pms050mi;
                mysqli_query($link,$inserting_into_m3_tran_log_pms050mi) or exit("While inserting into m3_tranlog pms050mi");
            }
            // FG End
        //M3 Rest API Call END
    }
}
function updateM3TransactionsRejectionsReversal($ref_id,$op_code,$r_qty,$r_reasons)
{
    $obj = new rest_api_calls();
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    $current_date = date("Y-m-d H:i:s");

    $host = $api_hostname;
    $port = $api_port_no;
    $company_num = $company_no;
    $plant_code = $global_facility_code;
    
    $details_query = "Select shift,assigned_module,style,mapped_color from $brandix_bts.bundle_creation_data where bundle_number = $ref_id and operation_id = $op_code";
    $details_result = mysqli_query($link,$details_query) or exit("Problem in getting details from the BCD");
    while($row = mysqli_fetch_array($details_result)){
        $input_shift = $row['shift'];
        $plan_module  = $row['assigned_module'];
        $style = $row['style'];
        $color = $row['mapped_color'];
        $b_colors = $row['mapped_color'];
    }
   //getting main operation_code from operation mapping
    //$bundle_creation_data_check = "SELECT main_operationnumber FROM `$brandix_bts`.`tbl_style_ops_master` WHERE style ='$style' AND color ='$color' and operation_code = '$op_code'";
    $main_ops_code = $op_code;
  
    $dep_ops_array_qry4 = "select default_operration,operation_order,main_operationnumber from $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$color' and operation_code=$op_code";
    $result_dep_ops_array_qry4 = $link->query($dep_ops_array_qry4);
    while($row4= $result_dep_ops_array_qry4->fetch_assoc()) 
    {
        $def_op = $row4['default_operration'];
        $operation_order = $row4['operation_order'];
        $main_operationnumber = $row4['main_operationnumber'];
    }

    if($def_op=='yes'||$def_op=='Yes') 
    {
        $main_ops_code = $main_operationnumber;
    }
    else{
        // query excluding packing in rejection reversal 
        $dep_ops_array_qry5= "SELECT tm.main_operationnumber FROM $brandix_bts.tbl_style_ops_master tm LEFT JOIN $brandix_bts.tbl_orders_ops_ref tr ON tr.operation_code=tm.operation_code WHERE tm.style ='$style' AND tm.color='$color' AND default_operration='yes' AND tr.category <> 'packing' and tm.operation_order > '$operation_order' ORDER BY tm.operation_order ASC limit 1";

        // $dep_ops_array_qry4 = "select main_operationnumber from $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$color' and default_operration='yes' and operation_order > '$operation_order' order by ASC limit 1";//query including packing in rejection reversal
        $result_dep_ops_array_qry5 = $link->query($dep_ops_array_qry5);
        if(mysqli_num_rows($result_dep_ops_array_qry5) > 0)
        {
            while($row5= $result_dep_ops_array_qry5->fetch_assoc()) 
            {
                $main_ops_code = $row5['main_operationnumber'];
            }
        }else
        {
            // query excluding packing in rejection reversal 
            $dep_ops_array_qry6="SELECT tm.main_operationnumber FROM $brandix_bts.tbl_style_ops_master tm LEFT JOIN $brandix_bts.tbl_orders_ops_ref tr ON tr.operation_code=tm.operation_code WHERE tm.style ='$style' AND tm.color='$color' AND default_operration='yes' AND tr.category <> 'packing' and tm.operation_order < '$operation_order' ORDER BY tm.operation_order DESC limit 1";

            // $dep_ops_array_qry6= "select main_operationnumber from $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$color' and default_operration='yes' and operation_order <'$operation_order' order by DESC limit 1 ";//query including packing in rejection reversal
            $result_dep_ops_array_qry6= $link->query($dep_ops_array_qry6);
            while($row6= $result_dep_ops_array_qry6->fetch_assoc()) 
            {
                $main_ops_code = $row6['main_operationnumber'];
            } 
        }
    }
    if($op_code == 15)
        $main_ops_code = $op_code;
        
    $b_shift  = $input_shift;
    $b_module = $plan_module;

    //getting work_station_id
    $qry_to_get_work_station_id = "SELECT work_center_id,short_cut_code FROM $brandix_bts.`tbl_orders_ops_ref` WHERE operation_code = '$op_code'";
    // echo $qry_to_get_work_station_id;
    $result_qry_to_get_work_station_id=mysqli_query($link,$qry_to_get_work_station_id) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row=mysqli_fetch_array($result_qry_to_get_work_station_id))
    {
        $work_station_id = $row['work_center_id'];
        $short_key_code  = $row['short_cut_code'];
    }
    if(!$work_station_id)
    {
        $qry_to_get_work_station_id = "SELECT work_station_id FROM bai_pro3.`work_stations_mapping` WHERE operation_code = '$short_key_code' AND module = '$b_module'";
        //echo $qry_to_get_work_station_id;
        $result_qry_to_get_work_station_id=mysqli_query($link,$qry_to_get_work_station_id) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($row=mysqli_fetch_array($result_qry_to_get_work_station_id))
        {
            $work_station_id = $row['work_station_id'];
        } 
    }
    foreach($r_qty as $key=>$value)
    {
        $qry_to_check_mo_numbers = "SELECT *,mq.id as mq_id FROM $bai_pro3.`mo_operation_quantites` mq where ref_no = $ref_id and op_code=$op_code";
        //echo $qry_to_check_mo_numbers;
        $qry_nop_result=mysqli_query($link,$qry_to_check_mo_numbers) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
        $total_bundle_rej_present_qty = $r_qty[$key];
        while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
        {
            $total_bundle_present_qty = $total_bundle_rej_present_qty;
            $mo_number = trim($nop_qry_row['mo_no']);
            $mo_quantity = $nop_qry_row['bundle_quantity'];
            $good_quantity_past = $nop_qry_row['good_quantity'];
            $rejected_quantity_past = $nop_qry_row['rejected_quantity'];
            $id = $nop_qry_row['id'];
            //$mo_no = $nop_qry_row['id'];
            $balance_max_updatable_qty = $rejected_quantity_past;
            // echo $total_bundle_present_qty;
            if($total_bundle_present_qty > 0)
            {
                if($balance_max_updatable_qty > 0)
                {
                    if($balance_max_updatable_qty >= $total_bundle_rej_present_qty)
                    {
                        $to_update_qty = $total_bundle_rej_present_qty;
                        $actual_rej_qty = $rejected_quantity_past-$total_bundle_rej_present_qty;
                        $update_qry = "update $bai_pro3.mo_operation_quantites set rejected_quantity = $actual_rej_qty where id= $id";
                        $total_bundle_rej_present_qty = 0;
                    }
                    else
                    {
                        $to_update_qty = $balance_max_updatable_qty;
                        $actual_rej_qty = $rejected_quantity_past-$balance_max_updatable_qty;
                        $update_qry = "update $bai_pro3.mo_operation_quantites set rejected_quantity = $actual_rej_qty where id= $id";
                        $total_bundle_rej_present_qty = $total_bundle_rej_present_qty - $balance_max_updatable_qty;
                    }
                    //echo $update_qry.'</br>';
                    $ims_pro_qty_updating = mysqli_query($link,$update_qry) or exit("While updating mo_operation_quantites".mysqli_error($GLOBALS["___mysqli_ston"]));
                    //echo $update_qry.'</br>';
                    // echo $r_reasons[$key];
                
                    $dep_ops_array_qry = "select default_operration from $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$color' and operation_code='$main_ops_code'";
                    $result_dep_ops_array_qry = $link->query($dep_ops_array_qry);
                    while($row = $result_dep_ops_array_qry->fetch_assoc()) 
                    {
                        $is_m3 = $row['default_operration'];
                    }
                    
                    if($is_m3 == 'Yes' || $is_m3 == 'yes' || $is_m3 == 'YES')
                    {
                        $rej_opn_sch_opn_master = "SELECT Main_OperationNumber FROM bai_pro3.schedule_oprations_master WHERE MONumber = '$mo_number' AND OperationNumber = $op_code";
                        $rej_opn_sch_opn_res=mysqli_query($link, $rej_opn_sch_opn_master) or exit("Sql Error sch opn master opn for rejections".mysqli_error($GLOBALS["___mysqli_ston"]));
                        if(mysqli_num_rows($rej_opn_sch_opn_res) > 0)
                        {
                            while($row_rej_opn_sch_opn_res=mysqli_fetch_array($rej_opn_sch_opn_res))
                            {
                                $main_ops_code = $row_rej_opn_sch_opn_res['Main_OperationNumber'];
                            }
                        }
                    }

                    // if(strtolower($is_m3) == 'yes')
                    // {
                        $to_update_qty = -$to_update_qty;
                        $inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`,`m3_ops_code`,`api_type`) 
                        VALUES ('$current_date','$mo_number',$to_update_qty,'$r_reasons[$key]','Normal','$username','','$b_module','$b_shift',$op_code,'',$id,'$work_station_id','pending','$main_ops_code','opn')";
                        mysqli_query($link,$inserting_into_m3_tran_log) or exit("While inserting into the m3_transactions".mysqli_error($GLOBALS["___mysqli_ston"]));
                    
                    // }
                }
            }
        }
    }
    return true;
}

function updateM3TransactionsLay($ref_id,$op_code,$qty,$cut_num)
{
    $obj = new rest_api_calls();    
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');

    $host = $api_hostname;
    $port = $api_port_no;
    $company_num = $company_no;
    $plant_code = $global_facility_code;

    $details_query = "Select shift,assigned_module,style,mapped_color from $brandix_bts.bundle_creation_data where bundle_number = $ref_id and operation_id = $op_code";
    $details_result = mysqli_query($link,$details_query) or exit("Problem in getting details from the BCD");
    while($row = mysqli_fetch_array($details_result)){
        $input_shift = $row['shift'];
        $plan_module  = $row['assigned_module'];
        $style = $row['style'];
        $color = $row['mapped_color'];
    }
    $current_date = date("Y-m-d H:i:s");
    $b_shift  = $input_shift;
    $b_module = $plan_module;

    //getting work_station_id
    $qry_to_get_work_station_id = "SELECT work_center_id,short_cut_code FROM $brandix_bts.`tbl_orders_ops_ref` WHERE operation_code = '$op_code'";
    $result_qry_to_get_work_station_id=mysqli_query($link,$qry_to_get_work_station_id) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row=mysqli_fetch_array($result_qry_to_get_work_station_id))
    {
        $work_station_id = $row['work_center_id'];
        $short_key_code  = $row['short_cut_code'];
    }
    if(!$work_station_id)
    {
        $qry_to_get_work_station_id = "SELECT work_station_id FROM bai_pro3.`work_stations_mapping` WHERE operation_code = '$short_key_code' AND module = '$b_module'";
        $result_qry_to_get_work_station_id=mysqli_query($link,$qry_to_get_work_station_id) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($row=mysqli_fetch_array($result_qry_to_get_work_station_id))
        {
            $work_station_id = $row['work_station_id'];
        } 
    }
    //getting mos and filling up

    $qry_to_check_mo_numbers = "SELECT *,mq.id as mq_id FROM $bai_pro3.`mo_operation_quantites` mq  
                                where ref_no = $ref_id and op_code=$op_code";
    $qry_nop_result=mysqli_query($link,$qry_to_check_mo_numbers) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
 
    while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
    {
        $mo_number = trim($nop_qry_row['mo_no']);
        $mo_quantity = $nop_qry_row['bundle_quantity'];
        $good_quantity_past = $nop_qry_row['good_quantity'];
        $rejected_quantity_past = $nop_qry_row['rejected_quantity'];
        $id = $nop_qry_row['mq_id'];
        $ops_des = $nop_qry_row ['op_desc'];

        // $update_qry = "update $bai_pro3.mo_operation_quantites set good_quantity = $actual_rep_qty where id= $id";
        // mysqli_query($link,$update_qry) or exit("While updating mo_operation_quantites".mysqli_error($GLOBALS["___mysqli_ston"]));

        $dep_ops_array_qry = "select default_operration from $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$color' and operation_code=$op_code";
        $result_dep_ops_array_qry = $link->query($dep_ops_array_qry);
        while($row = $result_dep_ops_array_qry->fetch_assoc()) 
        {
            $is_m3 = $row['default_operration'];
        }
        if(strtolower($is_m3) == 'yes')
        {
            //getting m3_op_code
            // $bundle_creation_data_check = "SELECT Main_OperationNumber FROM bai_pro3.schedule_oprations_master WHERE MONumber = '$mo_number' AND OperationNumber = $op_code";
            // $bundle_creation_data_check_result=mysqli_query($link, $bundle_creation_data_check) or exit("Sql Error bundle_creation_data_check".mysqli_error($GLOBALS["___mysqli_ston"]));
            // if(mysqli_num_rows($bundle_creation_data_check_result) > 0)
            // {
            //     while($row_bundle_creation_data_check_result =mysqli_fetch_array($bundle_creation_data_check_result))
            //     {
            //         $main_ops_code = $row_bundle_creation_data_check_result['Main_OperationNumber'];
            //     }
            // }
            //got the main ops code
            $cur_date = date('Y-m-d H:s:i');
            $inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`m3_ops_code`,`response_status`,`api_type`) 
            VALUES ('$current_date','$mo_number',$qty,'','$cut_num','$username','','$b_module','$b_shift',$op_code,'$ops_des',$id,'$work_station_id','$main_ops_code','pending','opn')";
            mysqli_query($link,$inserting_into_m3_tran_log) or exit("While inserting into m3_tranlog".mysqli_error($GLOBALS["___mysqli_ston"]));
            
        }
    } 
    return true;
}

?>
