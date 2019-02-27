
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
            $mo_number = $nop_qry_row['mo_no'];
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

                        $get_pre_op_code_b4_carton_ready = "SELECT operation_code FROM $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$color' AND ops_sequence = '$ops_sequence' AND CAST(operation_order AS CHAR) < '$operation_order' AND operation_code NOT IN (10,200,15) ORDER BY operation_order DESC LIMIT 1";
                        $result_pre_op_b4_carton_ready=mysqli_query($link, $get_pre_op_code_b4_carton_ready) or exit("error while fetching pre_op_code_b4_carton_ready");
                        if (mysqli_num_rows($result_pre_op_b4_carton_ready) > 0)
                        {
                            $final_op_code=mysqli_fetch_array($result_pre_op_b4_carton_ready);
                            $opn_b4_200 = $final_op_code['operation_code'];
                        }
                        
                        if ($opn_b4_200 == $op_code)
                        {
                            $get_count = "SELECT COUNT(*) as count FROM $bai_pro3.`tbl_carton_ready` WHERE mo_no=$mo_number";
                            $count_result = $link->query($get_count);
                            while($row = $count_result->fetch_assoc()) 
                            {
                                $count = $row['count'];
                            }

                            if ($count > 0)
                            {
                                $insert_update_tbl_carton_ready = "UPDATE $bai_pro3.tbl_carton_ready set remaining_qty = remaining_qty + $to_update_qty, cumulative_qty = cumulative_qty + $to_update_qty where mo_no= $mo_number";
                            }
                            else
                            {
                                $insert_update_tbl_carton_ready = "INSERT INTO $bai_pro3.tbl_carton_ready (operation_id, mo_no, remaining_qty, cumulative_qty) VALUES ('$op_code', '$mo_number', '$to_update_qty', '$to_update_qty');";
                            }
                            mysqli_query($link,$insert_update_tbl_carton_ready) or exit("While updating/inserting tbl_carton_ready");
                        }
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
                    $bundle_creation_data_check = "SELECT Main_OperationNumber FROM bai_pro3.schedule_oprations_master WHERE MONumber = $mo_number AND OperationNumber = $op_code";
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
                    VALUES ('$current_date','$mo_number',$to_update_qty,'','Normal','$username','','$b_module','$b_shift',$op_code,'$ops_des',$id,'$work_station_id','$main_ops_code','','opn')";
                    mysqli_query($link,$inserting_into_m3_tran_log) or exit("While inserting into m3_tranlog".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $insert_id=mysqli_insert_id($link);
                    // //M3 Rest API Call
                    if($enable_api_call == 'YES'){
            
                        $api_url = $host.":".$port."/m3api-rest/execute/PMS070MI/RptOperation?CONO=$company_num&FACI=$plant_code&MFNO=$mo_number&OPNO=$main_ops_code&DPLG=$work_station_id&MAQA=$to_update_qty&REMK=$insert_id&DSP1=1&DSP2=1&DSP3=1&DSP4=1";
                        $api_data = $obj->getCurlAuthRequest1($api_url,$insert_id);
                        $decoded = json_decode($api_data,true);
                        $type=$decoded['@type'];
                        $code=$decoded['@code'];
                        $message=$decoded['Message'];

                        //validating response pass/fail and inserting log
                        if($type!='ServerReturnedNOK'){
                            //updating response status in m3_transactions
                            $qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='pass' WHERE id=".$insert_id;
                            mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));

                        }else{
                            //updating response status in m3_transactions
                            $qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='fail' WHERE id=".$insert_id;
                            mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 Transactions".mysqli_error($GLOBALS["___mysqli_ston"]));

                            //insert transactions details into transactions_log
                            $qry_transactionslog="INSERT INTO $brandix_bts.`transactions_log`(`transaction_id`,`response_message`,`created_by`,`created_at`) VALUES ('$insert_id','$message','$username','$current_date')"; 
                            mysqli_query($link,$qry_transactionslog) or exit("While inserting into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
                        }
                    }
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
    $qry_to_check_mo_numbers = "select * from $bai_pro3.mo_operation_quantites where ref_no = $bundle_no and op_code = $op_code order by mo_no";
    $qry_nop_result=mysqli_query($link,$qry_to_check_mo_numbers) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
    $total_bundle_rec_present_qty = $b_rep_qty;
    while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
    {
        $total_bundle_present_qty = $total_bundle_rec_present_qty;
        if($total_bundle_present_qty > 0)
        {
            $mo_number = $nop_qry_row['mo_no'];
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
                            $get_count = "SELECT COUNT(*) as count FROM $bai_pro3.`tbl_carton_ready` WHERE mo_no=$mo_number";
                            $count_result = $link->query($get_count);
                            while($row = $count_result->fetch_assoc()) 
                            {
                                $count = $row['count'];
                            }

                            if ($count > 0)
                            {
                                $insert_update_tbl_carton_ready = "UPDATE $bai_pro3.tbl_carton_ready set remaining_qty = remaining_qty - $to_update_qty, cumulative_qty = cumulative_qty - $to_update_qty where mo_no= $mo_number";
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
                        $bundle_creation_data_check = "SELECT Main_OperationNumber FROM bai_pro3.schedule_oprations_master WHERE MONumber = $mo_number AND OperationNumber = $op_code";
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
                        VALUES ('$current_date','$mo_number','$to_update_qty','','Normal','$username','',$plan_module,'$input_shift',$op_code,'',$id,'$work_station_id','','$main_ops_code','opn')";
                    mysqli_query($link,$inserting_into_m3_tran_log) or exit("While inserting into m3_tranlog".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $insert_id=mysqli_insert_id($link);
                    
                    // //M3 Rest API Call
                    if($enable_api_call == 'YES'){
                        $api_url = $host.":".$port."/m3api-rest/execute/PMS070MI/RptOperation?CONO=$company_num&FACI=$plant_code&MFNO=$mo_number&OPNO=$main_ops_code&DPLG=$work_station_id&MAQA=$to_update_qty&REMK=$insert_id&DSP1=1&DSP2=1&DSP3=1&DSP4=1";
                        $api_data = $obj->getCurlAuthRequest1($api_url,$insert_id);
                        $decoded = json_decode($api_data,true);
                        $type=$decoded['@type'];
                        $code=$decoded['@code'];
                        $message=$decoded['Message'];
                   
                        //validating response pass/fail and inserting log
                        if($type!='ServerReturnedNOK'){
                            //updating response status in m3_transactions
                            $qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='pass' WHERE id=".$insert_id;
                            mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));

                        }else{
                            //updating response status in m3_transactions
                            $qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='fail' WHERE id=".$insert_id;
                            mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 Transactions".mysqli_error($GLOBALS["___mysqli_ston"]));

                            //insert transactions details into transactions_log
                            $qry_transactionslog="INSERT INTO $brandix_bts.`transactions_log` (`transaction_id`,`response_message`,`created_by`,`created_at`) VALUES ('$insert_id','$message','$username','$current_date')"; 
                            mysqli_query($link,$qry_transactionslog) or exit("While inserting into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
                        }
                    }
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
        $bundle_creation_data_check = "SELECT DISTINCT OperationNumber FROM $bai_pro3.schedule_oprations_master WHERE style ='$style' AND description ='$color'  AND SMV > 0";
        $bundle_creation_data_check_result=mysqli_query($link, $bundle_creation_data_check) or exit("Sql Error bundle_creation_data_check".mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($bundle_creation_data_check_result) > 0)
        {
            while($row_bundle_creation_data_check_result =mysqli_fetch_array($bundle_creation_data_check_result))
            {
                $main_ops_code = $row_bundle_creation_data_check_result['OperationNumber'];
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

    foreach($r_qty as $key=>$value)
    {
        $qry_to_check_mo_numbers = "SELECT *,mq.id as mq_id FROM $bai_pro3.`mo_operation_quantites` mq  
                                    where ref_no = $ref_id and op_code=$op_code ";
        $qry_nop_result=mysqli_query($link,$qry_to_check_mo_numbers) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
        $total_bundle_rej_present_qty = $r_qty[$key];
        while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
        {
            $total_bundle_present_qty = $total_bundle_rej_present_qty;
            $mo_number = $nop_qry_row['mo_no'];
            $mo_quantity = $nop_qry_row['bundle_quantity'];
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
                        //getting m3_op_code
                        $bundle_creation_data_check = "SELECT Main_OperationNumber FROM bai_pro3.schedule_oprations_master WHERE MONumber = $mo_number AND OperationNumber = $main_ops_code";
                        $bundle_creation_data_check_result=mysqli_query($link, $bundle_creation_data_check) or exit("Sql Error bundle_creation_data_check".mysqli_error($GLOBALS["___mysqli_ston"]));
                        if(mysqli_num_rows($bundle_creation_data_check_result) > 0)
                        {
                            while($row_bundle_creation_data_check_result =mysqli_fetch_array($bundle_creation_data_check_result))
                            {
                                $main_ops_code = $row_bundle_creation_data_check_result['Main_OperationNumber'];
                            }
                        }
                        //got the main ops code
                    // if(strtolower($is_m3) == 'yes')
                    // {
                        $inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`,`m3_ops_code`,`api_type`) 
                        VALUES ('$current_date','$mo_number',$to_update_qty,'$r_reasons[$key]','Normal','$username','',$b_module,'$b_shift',$op_code,'',$id,'$work_station_id','','$main_ops_code','opn')";
                        mysqli_query($link,$inserting_into_m3_tran_log) or exit("While inserting into the m3_transactions".mysqli_error($GLOBALS["___mysqli_ston"]));
                    
                        //getting the last inserted record
                        $insert_id=mysqli_insert_id($link);
        
                        //M3 Rest API Call
                        if($enable_api_call == 'YES'){
                            $api_url = $host.":".$port."/m3api-rest/execute/PMS070MI/RptOperation?CONO=$company_num&FACI=$plant_code&MFNO=$mo_number&OPNO=$main_ops_code&DPLG=$work_station_id&SCQA=$to_update_qty&MAQA=$to_update_qty&REMK=$insert_id&SCRE=".$r_reasons[$key]."&DSP1=1&DSP2=1&DSP3=1&DSP4=1";
                            $api_data = $obj->getCurlAuthRequest1($api_url,$insert_id);
                            $decoded = json_decode($api_data,true);
                            $type=$decoded['@type'];
                            $code=$decoded['@code'];
                            $message=$decoded['Message'];
                        
                            //validating response pass/fail and inserting log
                            if($type!='ServerReturnedNOK')
                            {
                                //updating response status in m3_transactions
                                $qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='pass' WHERE id=".$insert_id;
                                mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));

                            }
                            else
                            {
                                //updating response status in m3_transactions
                                $qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='fail' WHERE id=".$insert_id;
                                mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 Transactions".mysqli_error($GLOBALS["___mysqli_ston"]));

                                //insert transactions details into transactions_log
                                $qry_transactionslog="INSERT INTO $brandix_bts.`transactions_log` (`transaction_id`,`response_message`,`created_by`,`created_at`) VALUES ('$insert_id','$message','$username','$current_date')"; 
                                mysqli_query($link,$qry_transactionslog) or exit("While inserting into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
                            }
                        }
                    // }
                }
            }
        }
    }
    return true;
}
function updateM3CartonScan($b_op_id, $b_tid, $team_id)
{
    $obj = new rest_api_calls();
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    $current_date = date("Y-m-d H:i:s");

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
    $validate_qry = "SELECT mo_no,sum(bundle_quantity) as bun_quantity from $bai_pro3.mo_operation_quantites where ref_no in (".$b_tid.") and op_code = $b_op_id group by mo_no";
    $qry_nop_result=mysqli_query($link,$validate_qry) or exit("Bundles Query Error14 => ".$qry_to_check_mo_numbers);
    while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
    {
        $mo_array[] = $nop_qry_row['mo_no'];
        $mo_qty_array[] = $nop_qry_row['bun_quantity'];
    }

    for ($i=0; $i < sizeof($mo_array); $i++)
    {
        $check_in_tbl_carton_ready = "select remaining_qty from bai_pro3.tbl_carton_ready where mo_no = $mo_array[$i] ";
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
    
    if ($flag_nok == 0)
    {
        $qry_to_check_mo_numbers = "select * from $bai_pro3.mo_operation_quantites where ref_no in (".$b_tid.") and op_code = $b_op_id";
        // echo $qry_to_check_mo_numbers;
        $qry_nop_result=mysqli_query($link,$qry_to_check_mo_numbers) or exit("Bundles Query Error14 => ".$qry_to_check_mo_numbers);
        while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
        {
            $mo_number = $nop_qry_row['mo_no'];
            $mo_quantity = $nop_qry_row['bundle_quantity'];
            $good_quantity_past = $nop_qry_row['good_quantity'];
            $id = $nop_qry_row['id'];

            $insert_update_tbl_carton_ready = "UPDATE $bai_pro3.tbl_carton_ready set remaining_qty = remaining_qty - $mo_quantity where mo_no= $mo_number";
            // echo $insert_update_tbl_carton_ready;
            mysqli_query($link,$insert_update_tbl_carton_ready) or exit("While updating tbl_carton_ready");

            $update_qry = "update $bai_pro3.mo_operation_quantites set good_quantity = $mo_quantity where id = $id";
            // echo $update_qry;
            mysqli_query($link,$update_qry) or exit("While updating mo_operation_quantites");        
            
            //M3 Rest API Call START
                //getting m3_op_code
                $bundle_creation_data_check = "SELECT Main_OperationNumber FROM bai_pro3.schedule_oprations_master WHERE MONumber = $mo_number AND OperationNumber = $b_op_id";
                $bundle_creation_data_check_result=mysqli_query($link, $bundle_creation_data_check) or exit("Sql Error bundle_creation_data_check".mysqli_error($GLOBALS["___mysqli_ston"]));
                if(mysqli_num_rows($bundle_creation_data_check_result) > 0)
                {
                    while($row_bundle_creation_data_check_result =mysqli_fetch_array($bundle_creation_data_check_result))
                    {
                        $main_ops_code = $row_bundle_creation_data_check_result['Main_OperationNumber'];
                    }
                }
                // 200 Operation start
                    $inserting_into_m3_tran_log_pms070mi = "INSERT INTO $bai_pro3.`m3_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`module_no`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`,`m3_ops_code`,`api_type`) VALUES ('".date('Y-m-d H:i:s')."','$mo_number','$mo_quantity','','Normal','$username','$team_id','$b_op_id','$short_key_code','$id','$work_station_id','','$main_ops_code','opn')";
                    // echo $inserting_into_m3_tran_log_pms070mi;
                    mysqli_query($link,$inserting_into_m3_tran_log_pms070mi) or exit("While inserting into m3_tranlog pms070mi");
                    $insert_id_pms070mi=mysqli_insert_id($link);
                    // Given API => /m3api-rest/execute/PMS070MI/RptOperation?CONO=200&FACI=EKG&MFNO=7512415&OPNO=130&DPLG=Q01AL01&MAQA=1&SCQA=1&SCRE=""&DSP1=1&DSP2=1&DSP3=1&DSP4=1
                    if($enable_api_call == 'YES')
                    {
                        $api_url_pms070mi = $host.":".$port."/m3api-rest/execute/PMS070MI/RptOperation?CONO=$company_num&FACI=$plant_code&MFNO=$mo_number&OPNO=$main_ops_code&DPLG=$work_station_id&MAQA=$mo_quantity&REMK=$insert_id_pms070mi&DSP1=1&DSP2=1&DSP3=1&DSP4=1";
                        $api_data_pms070mi = $obj->getCurlAuthRequest1($api_url_pms070mi,$insert_id_pms070mi);
                        $decoded_pms070mi = json_decode($api_data_pms070mi,true);
                        if(isset($decoded_pms070mi['@type']))
                        {
                            $type_pms070mi=$decoded_pms070mi['@type'];
                        }
                        else
                        {
                            $type_pms070mi=0;
                        }
                        //validating response pass/fail and inserting log
                        if($type_pms070mi!='ServerReturnedNOK')
                        {
                            //updating response status in m3_transactions
                            $qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='pass' WHERE id=".$insert_id_pms070mi."";
                            mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 transaction log");
                        }
                        else
                        {
                            //$code_pms070mi=$decoded_pms070mi['@code'];
                            $message_pms070mi=$decoded_pms070mi['Message'];
                            //updating response status in m3_transactions
                            $qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='fail' WHERE id=".$insert_id_pms070mi."";
                            mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 Transactions");

                            //insert transactions details into transactions_log
                            $qry_transactionslog="INSERT INTO $brandix_bts.`transactions_log` (`transaction_id`,`response_message`,`created_by`,`created_at`) VALUES ('$insert_id_pms070mi','$message_pms070mi','$username','$current_date')";
                            mysqli_query($link,$qry_transactionslog) or exit("While inserting into M3 transaction log");
                        }
                    }                        
                // 200 Operation End

                // FG start
                    $inserting_into_m3_tran_log_fg_pms050mi = "INSERT INTO $bai_pro3.`m3_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`module_no`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`,`m3_ops_code`,`api_type`) VALUES ('".date('Y-m-d H:i:s')."','$mo_number','$mo_quantity','','Normal','$username','$team_id','$b_op_id','$short_key_code','$id','$work_station_id','','$main_ops_code','fg')";
                    // echo $inserting_into_m3_tran_log_fg_pms050mi;
                    mysqli_query($link,$inserting_into_m3_tran_log_fg_pms050mi) or exit("While inserting into m3_tranlog");
                    $insert_id_pms050mi=mysqli_insert_id($link);
                    // Given API => m3api-rest/execute/PMS050MI/RptReceipt?CONO=200&FACI=Q01&MFNO=7512409&RPQA=35&DSP1=1&DSP2=1&DSP3=1&DSP4=1&DSP5=1
                    if($enable_api_call == 'YES')
                    {
                        $api_url_pms050mi = $host.":".$port."/m3api-rest/execute/PMS050MI/RptReceipt?CONO=$company_num&FACI=$plant_code&MFNO=$mo_number&RPQA=$mo_quantity&REMK=$insert_id_pms050mi&DSP1=1&DSP2=1&DSP3=1&DSP4=1&DSP5=1";
                        $api_data_pms050mi = $obj->getCurlAuthRequest1($api_url_pms050mi,$insert_id_pms050mi);
                        $decoded_pms050mi = json_decode($api_data_pms050mi,true);
                        if(isset($decoded_pms050mi['@type']))
                        {
                            $type_pms050mi=$decoded_pms050mi['@type'];
                        }
                        else
                        {
                            $type_pms050mi=0;
                        }
                        //validating response pass/fail and inserting log
                        if($type_pms050mi!='ServerReturnedNOK')
                        {
                            //updating response status in m3_transactions
                            $qry_m3_transactions_pms050mi="UPDATE $bai_pro3.`m3_transactions` SET response_status='pass' WHERE id=".$insert_id_pms050mi."";
                            mysqli_query($link,$qry_m3_transactions_pms050mi) or exit("While updating into M3 transaction log");
                        }
                        else
                        {
                            //updating response status in m3_transactions
                            //$code=$decoded_pms050mi['@code'];
                            $message_pms050mi=$decoded_pms050mi['Message'];
                            $qry_m3_transactions_pms050mi="UPDATE $bai_pro3.`m3_transactions` SET response_status='fail' WHERE id=".$insert_id_pms050mi."";
                            mysqli_query($link,$qry_m3_transactions_pms050mi) or exit("While updating into M3 Transactions");

                            //insert transactions details into transactions_log
                            $qry_transactionslog_pms050mi="INSERT INTO $brandix_bts.`transactions_log` (`transaction_id`,`response_message`,`created_by`,`created_at`) VALUES ('$insert_id_pms050mi','$message_pms050mi','$username','$current_date')";
                            mysqli_query($link,$qry_transactionslog_pms050mi) or exit("While inserting into M3 transaction log");
                        }
                    }                        
                // FG End
            //M3 Rest API Call END
        }

        return 1;
    }
    else
    {
        return 0;
    }   
}

function updateM3CartonScanReversal($b_op_id, $b_tid)
{
    $obj = new rest_api_calls();
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    $current_date = date("Y-m-d H:i:s");

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
        $mo_number = $nop_qry_row['mo_no'];
        $mo_quantity = $nop_qry_row['bundle_quantity'];
        $good_quantity_past = $nop_qry_row['good_quantity'];
        $id = $nop_qry_row['id'];
        $negative_qty = $good_quantity_past * -1;

        $insert_update_tbl_carton_ready = "UPDATE $bai_pro3.tbl_carton_ready set remaining_qty = remaining_qty + $good_quantity_past where mo_no= $mo_number";
        // echo $insert_update_tbl_carton_ready;
        mysqli_query($link,$insert_update_tbl_carton_ready) or exit("While updating tbl_carton_ready");

        $update_qry = "update $bai_pro3.mo_operation_quantites set good_quantity = '0' where id= $id";
        mysqli_query($link,$update_qry) or exit("While updating mo_operation_quantites");

        // M3 Rest API Call START
            //getting m3_op_code
            $bundle_creation_data_check = "SELECT Main_OperationNumber FROM bai_pro3.schedule_oprations_master WHERE MONumber = $mo_number AND OperationNumber = $b_op_id";
            $bundle_creation_data_check_result=mysqli_query($link, $bundle_creation_data_check) or exit("Sql Error bundle_creation_data_check".mysqli_error($GLOBALS["___mysqli_ston"]));
            if(mysqli_num_rows($bundle_creation_data_check_result) > 0)
            {
                while($row_bundle_creation_data_check_result =mysqli_fetch_array($bundle_creation_data_check_result))
                {
                    $main_ops_code = $row_bundle_creation_data_check_result['Main_OperationNumber'];
                }
            }
            // 200 Operation start
                $inserting_into_m3_tran_log_pms070mi = "INSERT INTO $bai_pro3.`m3_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`,`m3_ops_code`,`api_type`) VALUES ('".date('Y-m-d H:i:s')."','$mo_number','$negative_qty','','cpk_reversal','$username','$b_op_id','$short_key_code','$id','$work_station_id','','$main_ops_code','opn')";
                // echo $inserting_into_m3_tran_log_pms070mi;
                mysqli_query($link,$inserting_into_m3_tran_log_pms070mi) or exit("While inserting into m3_tranlog pms070mi");
                $insert_id_pms070mi=mysqli_insert_id($link);
                // Given API => /m3api-rest/execute/PMS070MI/RptOperation?CONO=200&FACI=EKG&MFNO=7512415&OPNO=130&DPLG=Q01AL01&MAQA=1&SCQA=1&SCRE=""&DSP1=1&DSP2=1&DSP3=1&DSP4=1
                if($enable_api_call == 'YES')
                {
                    $api_url_pms070mi = $host.":".$port."/m3api-rest/execute/PMS070MI/RptOperation?CONO=$company_num&FACI=$plant_code&MFNO=$mo_number&OPNO=$main_ops_code&DPLG=$work_station_id&MAQA=$negative_qty&REMK=$insert_id_pms070mi&DSP1=1&DSP2=1&DSP3=1&DSP4=1";
                    $api_data_pms070mi = $obj->getCurlAuthRequest1($api_url_pms070mi,$insert_id_pms070mi);
                    $decoded_pms070mi = json_decode($api_data_pms070mi,true);
                    $type_pms070mi=$decoded_pms070mi['@type'];
                    $code_pms070mi=$decoded_pms070mi['@code'];
                    $message_pms070mi=$decoded_pms070mi['Message'];
                    //validating response pass/fail and inserting log
                    if($type_pms070mi!='ServerReturnedNOK')
                    {
                        //updating response status in m3_transactions
                        $qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='pass' WHERE id=".$insert_id_pms070mi."";
                        mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 transaction log pms070mi");
                    }
                    else
                    {
                        //updating response status in m3_transactions
                        $qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='fail' WHERE id=".$insert_id_pms070mi."";
                        mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 Transactions pms070mi");

                        //insert transactions details into transactions_log
                        $qry_transactionslog="INSERT INTO $brandix_bts.`transactions_log` (`transaction_id`,`response_message`,`created_by`,`created_at`) VALUES ('$insert_id_pms070mi','$message_pms070mi','$username','$current_date')";
                        mysqli_query($link,$qry_transactionslog) or exit("While inserting into M3 transaction log pms070mi");
                    }
                }
            // 200 Operation End

            // FG start
                $inserting_into_m3_tran_log_pms050mi = "INSERT INTO $bai_pro3.`m3_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`,`m3_ops_code`,`api_type`) VALUES ('".date('Y-m-d H:i:s')."','$mo_number','$negative_qty','','cpk_reversal','$username','$b_op_id','$short_key_code','$id','$work_station_id','','$main_ops_code','fg')";
                // echo $inserting_into_m3_tran_log_pms050mi;
                mysqli_query($link,$inserting_into_m3_tran_log_pms050mi) or exit("While inserting into m3_tranlog pms050mi");
                $insert_id_pms050mi=mysqli_insert_id($link);
                // Given API => m3api-rest/execute/PMS050MI/RptReceipt?CONO=200&FACI=Q01&MFNO=7512409&RPQA=35&DSP1=1&DSP2=1&DSP3=1&DSP4=1&DSP5=1
                if($enable_api_call == 'YES')
                {
                    $api_url_pms050mi = $host.":".$port."/m3api-rest/execute/PMS050MI/RptReceipt?CONO=$company_num&FACI=$plant_code&MFNO=$mo_number&RPQA=$negative_qty&REMK=$insert_id_pms050mi&DSP1=1&DSP2=1&DSP3=1&DSP4=1&DSP5=1";
                    $api_data_pms050mi = $obj->getCurlAuthRequest1($api_url_pms050mi,$insert_id_pms050mi);
                    $decoded_pms050mi = json_decode($api_data_pms050mi,true);
                    $type_pms050mi=$decoded_pms050mi['@type'];
                    $code=$decoded_pms050mi['@code'];
                    $message_pms050mi=$decoded_pms050mi['Message'];
                    //validating response pass/fail and inserting log
                    if($type_pms050mi!='ServerReturnedNOK')
                    {
                        //updating response status in m3_transactions
                        $qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='pass' WHERE id=".$insert_id_pms050mi."";
                        mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 transaction log pms050mi");
                    }
                    else
                    {
                        //updating response status in m3_transactions
                        $qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='fail' WHERE id=".$insert_id_pms050mi."";
                        mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 Transactions pms050mi");
                        
                        //insert transactions details into transactions_log
                        $qry_transactionslog="INSERT INTO $brandix_bts.`transactions_log` (`transaction_id`,`response_message`,`created_by`,`created_at`) VALUES ('$insert_id_pms050mi','$message_pms050mi','$username','$current_date')"; 
                        mysqli_query($link,$qry_transactionslog) or exit("While inserting into M3 transaction log pms050mi");
                    }
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
    $bundle_creation_data_check = "SELECT DISTINCT OperationNumber FROM $bai_pro3.schedule_oprations_master WHERE style ='$style' AND description ='$color'  AND SMV > 0";
    // echo $bundle_creation_data_check;
    $bundle_creation_data_check_result=mysqli_query($link, $bundle_creation_data_check) or exit("Sql Error bundle_creation_data_check".mysqli_error($GLOBALS["___mysqli_ston"]));
    if(mysqli_num_rows($bundle_creation_data_check_result) > 0)
    {
        while($row_bundle_creation_data_check_result =mysqli_fetch_array($bundle_creation_data_check_result))
        {
            $main_ops_code = $row_bundle_creation_data_check_result['OperationNumber'];
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
            $mo_number = $nop_qry_row['mo_no'];
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
                     $bundle_creation_data_check = "SELECT Main_OperationNumber FROM bai_pro3.schedule_oprations_master WHERE MONumber = $mo_number AND OperationNumber = $main_ops_code";
                        $bundle_creation_data_check_result=mysqli_query($link, $bundle_creation_data_check) or exit("Sql Error bundle_creation_data_check".mysqli_error($GLOBALS["___mysqli_ston"]));
                        if(mysqli_num_rows($bundle_creation_data_check_result) > 0)
                        {
                            while($row_bundle_creation_data_check_result =mysqli_fetch_array($bundle_creation_data_check_result))
                            {
                                $main_ops_code = $row_bundle_creation_data_check_result['Main_OperationNumber'];
                            }
                        }
                    // if(strtolower($is_m3) == 'yes')
                    // {
                        $to_update_qty = -$to_update_qty;
                        $inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`,`m3_ops_code`) 
                        VALUES ('$current_date','$mo_number',$to_update_qty,'$r_reasons[$key]','Normal','$username','',$b_module,'$b_shift',$op_code,'',$id,'$work_station_id','','$main_ops_code')";
                        mysqli_query($link,$inserting_into_m3_tran_log) or exit("While inserting into the m3_transactions".mysqli_error($GLOBALS["___mysqli_ston"]));
                    
                        //getting the last inserted record
                        $insert_id=mysqli_insert_id($link);
        
                        //M3 Rest API Call
                        if($enable_api_call == 'YES'){
                            $api_url = $host.":".$port."/m3api-rest/execute/PMS070MI/RptOperation?CONO=$company_num&FACI=$plant_code&MFNO=$mo_number&OPNO=$main_ops_code&DPLG=$work_station_id&SCQA=$to_update_qty&MAQA=$to_update_qty&REMK=$insert_id&SCRE=".$r_reasons[$key]."&DSP1=1&DSP2=1&DSP3=1&DSP4=1";
                            $api_data = $obj->getCurlAuthRequest1($api_url,$insert_id);
                            $decoded = json_decode($api_data,true);
                            $type=$decoded['@type'];
                            $code=$decoded['@code'];
                            $message=$decoded['Message'];
                        

                           //validating response pass/fail and inserting log
                            if($type!='ServerReturnedNOK')
                            {
                                //updating response status in m3_transactions
                                $qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='pass' WHERE id=".$insert_id;
                                mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
                            }
                            else
                            {
                                //updating response status in m3_transactions
                                $qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='fail' WHERE id=".$insert_id;
                                mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 Transactions".mysqli_error($GLOBALS["___mysqli_ston"]));

                                //insert transactions details into transactions_log
                                $qry_transactionslog="INSERT INTO $brandix_bts.`transactions_log` (`transaction_id`,`response_message`,`created_by`,`created_at`) VALUES ('$insert_id','$message','$username','$current_date')"; 
                                mysqli_query($link,$qry_transactionslog) or exit("While inserting into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
                            }
                        }
                    // }
                }
            }
        }
    }
    return true;
}

?>