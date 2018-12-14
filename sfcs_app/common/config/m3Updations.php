
<?php

// LOGIC TO INSERT TRANSACTIONS IN M3_TRANSACTIONS TABLE

//function updateM3Transactions($input_doc_no,$op_code,$op_code,$input_shift,$plan_module){
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/rest_api_calls.php');
function updateM3Transactions($ref_id,$op_code,$qty)
{
    $obj = new rest_api_calls();    
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
   
    $host = $api_hostname;
    $port = $api_port_no;
    $company_num = $company_no;
    $plant_code = $global_facility_code;

    $details_query = "Select shift,assigned_module,style,mapped_color from $brandix_bts.bundle_creation_data where bundle_number = '$ref_id' and operation_id = '$op_code'";
    $details_result = mysqli_query($link,$details_query) or exit("Problem in getting details from the BCD");
    while($row = mysqli_fetch_array($details_result)){
        $input_shift = $row['shift'];
        $plan_module  = $row['assigned_module'];
        $style = $row['style'];
        $color = $row['mapped_color'];
    }
    //getting main operation_code from operation mapping
    //$bundle_creation_data_check = "SELECT main_operationnumber FROM `$brandix_bts`.`tbl_style_ops_master` WHERE style ='$style' AND color ='$color' and operation_code = '$op_code'";
    $bundle_creation_data_check = "SELECT main_operationnumber FROM $bai_pro3.schedule_oprations_master 
                                    WHERE style ='$style' AND description ='$color' and operationnumber = '$op_code'";
    // echo $bundle_creation_data_check;
	$bundle_creation_data_check_result=mysqli_query($link, $bundle_creation_data_check) or exit("Sql Error bundle_creation_data_check".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($bundle_creation_data_check_result) > 0)
	{
        while($row_bundle_creation_data_check_result =mysqli_fetch_array($bundle_creation_data_check_result))
		{
            $main_ops_code = $row_bundle_creation_data_check_result['main_operationnumber'];
        }
    }
    // echo 'main'.$main_ops_code;
    //got the main ops code


    $current_date = date("Y-m-d H:i:s");
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
    //getting mos and filling up

    $qry_to_check_mo_numbers = "SELECT *,mq.id as mq_id FROM $bai_pro3.`mo_operation_quantites` mq  
                                where ref_no = '$ref_id' and op_code='$op_code' ";
    // echo $qry_to_check_mo_numbers;
    $qry_nop_result=mysqli_query($link,$qry_to_check_mo_numbers) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
    $total_bundle_present_qty = $qty;
    $total_bundle_rec_present_qty = $qty;
    while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
    {
        $total_bundle_present_qty = $total_bundle_rec_present_qty;
        // echo $total_bundle_present_qty;
        if($total_bundle_present_qty > 0)
        {
            $mo_number = $nop_qry_row['mo_no'];
            $mo_quantity = $nop_qry_row['bundle_quantity'];
            $good_quantity_past = $nop_qry_row['good_quantity'];
            $rejected_quantity_past = $nop_qry_row['rejected_quantity'];
            $id = $nop_qry_row['mq_id'];
            $ops_des = $nop_qry_row ['op_desc'];
            $balance_max_updatable_qty = $mo_quantity - ($good_quantity_past + $rejected_quantity_past);
            // echo $balance_max_updatable_qty .'-'. $total_bundle_rec_present_qty;
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
                //echo $update_qry.'</br>';
                $ims_pro_qty_updating = mysqli_query($link,$update_qry) or exit("While updating mo_operation_quantites".mysqli_error($GLOBALS["___mysqli_ston"]));

                // 763 mo filling for new operation start
                    $application='Carton_Ready';
                    $get_routing_query="SELECT operation_code from $brandix_bts.tbl_ims_ops where appilication='$application'";
                    //echo $get_routing_query;
                    $routing_result=mysqli_query($link, $get_routing_query) or exit("error while fetching opn routing");
                    $opn_routing=mysqli_fetch_array($routing_result);
                    $opn_routing_code = $opn_routing['operation_code'];

                    if ($opn_routing_code == $op_code)
                    {
                        $get_count = "SELECT COUNT(*) as count FROM $bai_pro3.`tbl_carton_ready` WHERE mo_no='$mo_number' and operation_id='$op_code';";
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
                        // echo $insert_update_tbl_carton_ready.'<br>';
                        mysqli_query($link,$insert_update_tbl_carton_ready) or exit("While updating/inserting tbl_carton_ready");
                    }                        
                // 763 mo filling for new operation end
                $dep_ops_array_qry = "select default_operration from $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$color' and operation_code='$op_code'";
                $result_dep_ops_array_qry = $link->query($dep_ops_array_qry);
                while($row = $result_dep_ops_array_qry->fetch_assoc()) 
                {
                    $is_m3 = $row['default_operration'];
                }
                if(strtolower($is_m3) == 'yes')
                {
                    $cur_date = date('Y-m-d H:s:i');
                    $inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`m3_ops_code`,`response_status`) 
                    VALUES ('$current_date','$mo_number',$to_update_qty,'','Normal','$username','','$b_module','$b_shift',$op_code,'$ops_des',$id,'$work_station_id','$main_ops_code','')";
                    // echo $inserting_into_m3_tran_log;
                    mysqli_query($link,$inserting_into_m3_tran_log) or exit("While inserting into m3_tranlog".mysqli_error($GLOBALS["___mysqli_ston"]));
                

                    $insert_id=mysqli_insert_id($link);
                    // //M3 Rest API Call
                    if($enable_api_call == 'YES'){
            
                        $api_url = $host.":".$port."/m3api-rest/execute/PMS070MI/RptOperation?CONO=$company_num&FACI=$plant_code&MFNO=$mo_number&OPNO=$main_ops_code&DPLG=$work_station_id&MAQA=$to_update_qty&DSP1=1&DSP2=1&DSP3=1&DSP4=1";
                        $api_data = $obj->getCurlAuthRequest($api_url);
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


function updateM3TransactionsReversal($bundle_no,$reversalval,$op_code){
    $obj = new rest_api_calls();
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
    $current_date = date("Y-m-d H:i:s");

    $host = $api_hostname;
    $port = $api_port_no;
    $company_num = $company_no;
    $plant_code = $global_facility_code;
    
    $details_query = "Select shift,assigned_module,style,mapped_color from $brandix_bts.bundle_creation_data where bundle_number = '$bundle_no' and operation_id = '$op_code'";
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
    $bundle_creation_data_check = "SELECT main_operationnumber FROM $bai_pro3.schedule_oprations_master 
                                    WHERE style ='$style' AND description ='$color' and operationnumber = '$op_code'";
    // echo $bundle_creation_data_check;
	$bundle_creation_data_check_result=mysqli_query($link, $bundle_creation_data_check) or exit("Sql Error bundle_creation_data_check".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($bundle_creation_data_check_result) > 0)
	{
        while($row_bundle_creation_data_check_result =mysqli_fetch_array($bundle_creation_data_check_result))
		{
            $main_ops_code = $row_bundle_creation_data_check_result['main_operationnumber'];
        }
    }
    // echo 'main'.$main_ops_code;
    //got the main ops code

    $b_tid    = $bundle_no;
    $b_rep_qty= $reversalval;
    
    $qry_to_get_work_station_id = "SELECT work_center_id,short_cut_code FROM $brandix_bts.`tbl_orders_ops_ref` WHERE operation_code = '$op_code'";
    $result_qry_to_get_work_station_id=mysqli_query($link,$qry_to_get_work_station_id) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row=mysqli_fetch_array($result_qry_to_get_work_station_id))
    {
        $work_station_id = $row['work_center_id'];
        $short_key_code  = $row['short_cut_code'];
        // $b_style = $row['style'];
    }
    if(!$work_station_id)
    {
        $qry_to_get_work_station_id = "SELECT work_station_id FROM bai_pro3.`work_stations_mapping` WHERE operation_code = '$short_key_code' AND module = '$plan_module'";
        //echo $qry_to_get_work_station_id;
        $result_qry_to_get_work_station_id=mysqli_query($link,$qry_to_get_work_station_id) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($row=mysqli_fetch_array($result_qry_to_get_work_station_id))
        {
            $work_station_id = $row['work_station_id'];
        } 
    }
    $qry_to_check_mo_numbers = "select * from $bai_pro3.mo_operation_quantites where ref_no = $bundle_no and op_code = $op_code order by mo_no";
    // echo $qry_to_check_mo_numbers.'-';
    $qry_nop_result=mysqli_query($link,$qry_to_check_mo_numbers) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
    $total_bundle_rec_present_qty = $b_rep_qty;
    while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
    {
        $total_bundle_present_qty = $total_bundle_rec_present_qty;
        // echo $total_bundle_present_qty;
        if($total_bundle_present_qty > 0)
        {
            $mo_number = $nop_qry_row['mo_no'];
            $mo_quantity = $nop_qry_row['bundle_quantity'];
            $good_quantity_past = $nop_qry_row['good_quantity'];
            $rejected_quantity_past = $nop_qry_row['rejected_quantity'];
            $id = $nop_qry_row['id'];
            $balance_max_updatable_qty = $good_quantity_past ;
            // echo $balance_max_updatable_qty .'-'. $total_bundle_rec_present_qty;
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
                // echo $update_qry.'</br>';

                // 763 mo filling for new operation start
                    $application='Carton_Ready';
                    $get_routing_query="SELECT operation_code from $brandix_bts.tbl_ims_ops where appilication='$application'";
                    //echo $get_routing_query;
                    $routing_result=mysqli_query($link, $get_routing_query) or exit("error while fetching opn routing");
                    $opn_routing=mysqli_fetch_array($routing_result);
                    $opn_routing_code = $opn_routing['operation_code'];

                    if ($opn_routing_code == $op_code)
                    {
                        $get_count = "SELECT COUNT(*) as count FROM $bai_pro3.`tbl_carton_ready` WHERE mo_no='$mo_number' and operation_id='$op_code';";
                        $count_result = $link->query($get_count);
                        while($row = $count_result->fetch_assoc()) 
                        {
                            $count = $row['count'];
                        }

                        if ($count > 0)
                        {
                            $insert_update_tbl_carton_ready = "UPDATE $bai_pro3.tbl_carton_ready set remaining_qty = remaining_qty - $to_update_qty, cumulative_qty = cumulative_qty - $to_update_qty where mo_no= $mo_number";
                        }
                        // echo $insert_update_tbl_carton_ready.'<br>';
                        mysqli_query($link,$insert_update_tbl_carton_ready) or exit("While updating/inserting tbl_carton_ready");
                    }                        
                // 763 mo filling for new operation end

                $ims_pro_qty_updating = mysqli_query($link,$update_qry) or exit("While updating mo_operation_quantites".mysqli_error($GLOBALS["___mysqli_ston"]));
                $dep_ops_array_qry = "select default_operration from $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$b_colors' and operation_code='$op_code'";
                $result_dep_ops_array_qry = $link->query($dep_ops_array_qry);
                while($row = $result_dep_ops_array_qry->fetch_assoc()) 
                {
                    $is_m3 = $row['default_operration'];
                }
               
                if($is_m3 == 'Yes' || $is_m3 == 'yes' || $is_m3 == 'YES')
                {                    
                    $to_update_qty = '-'.$b_rep_qty;
                    $inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`,`m3_ops_code`) 
                     VALUES ('$current_date','$mo_number','$to_update_qty','','Normal','$username','',$plan_module,'$input_shift',$op_code,'',$id,'$work_station_id','','$main_ops_code')";
                    // echo $inserting_into_m3_tran_log;
                    mysqli_query($link,$inserting_into_m3_tran_log) or exit("While inserting into m3_tranlog".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $insert_id=mysqli_insert_id($link);
                   
                    // //M3 Rest API Call
                    if($enable_api_call == 'YES'){
                        $api_url = $host.":".$port."/m3api-rest/execute/PMS070MI/RptOperation?CONO=$company_num&FACI=$plant_code&MFNO=$mo_number&OPNO=$main_ops_code&DPLG=$work_station_id&MAQA=$to_update_qty&DSP1=1&DSP2=1&DSP3=1&DSP4=1";
                        $api_data = $obj->getCurlAuthRequest($api_url);
                        $decoded = json_decode($api_data,true);
                        $type=$decoded['@type'];
                        $code=$decoded['@code'];
                        $message=$decoded['Message'];
                    } 

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
    return true;
    
}//Function ends


function updateM3TransactionsRejections($ref_id,$op_code,$r_qty,$r_reasons)
{
    $obj = new rest_api_calls();
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    $current_date = date("Y-m-d H:i:s");

    $host = $api_hostname;
    $port = $api_port_no;
    $company_num = $company_no;
    $plant_code = $global_facility_code;
    
    $details_query = "Select shift,assigned_module,style,mapped_color from $brandix_bts.bundle_creation_data where bundle_number = '$ref_id' and operation_id = '$op_code'";
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
    $bundle_creation_data_check = "SELECT DISTINCT Main_OperationNumber FROM $bai_pro3.schedule_oprations_master WHERE style ='$style' AND description ='$color'  AND SMV > 0";
    // echo $bundle_creation_data_check;
	$bundle_creation_data_check_result=mysqli_query($link, $bundle_creation_data_check) or exit("Sql Error bundle_creation_data_check".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($bundle_creation_data_check_result) > 0)
	{
        while($row_bundle_creation_data_check_result =mysqli_fetch_array($bundle_creation_data_check_result))
		{
            $main_ops_code = $row_bundle_creation_data_check_result['Main_OperationNumber'];
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
        $qry_to_check_mo_numbers = "SELECT *,mq.id as mq_id FROM $bai_pro3.`mo_operation_quantites` mq  
                                    where ref_no = '$ref_id' and op_code='$op_code' ";
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
            $balance_max_updatable_qty = $mo_quantity - ($good_quantity_past + $rejected_quantity_past);
            // echo $total_bundle_present_qty;
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
                    if(strtolower($is_m3) == 'yes')
                    {
                        $inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`,`m3_ops_code`) 
                        VALUES ('$current_date','$mo_number',$to_update_qty,'$r_reasons[$key]','Normal','$username','',$b_module,'$b_shift',$op_code,'',$id,'$work_station_id','','$main_ops_code')";
                        //echo $inserting_into_m3_tran_log.'</br>';
                        mysqli_query($link,$inserting_into_m3_tran_log) or exit("While inserting into the m3_transactions".mysqli_error($GLOBALS["___mysqli_ston"]));
                    
                        //getting the last inserted record
                        $insert_id=mysqli_insert_id($link);
        
                        //M3 Rest API Call
                        if($enable_api_call == 'YES'){
                            $api_url = $host.":".$port."/m3api-rest/execute/PMS070MI/RptOperation?CONO=$company_num&FACI=$plant_code&MFNO=$mo_number&OPNO=$main_ops_code&DPLG=$work_station_id&SCQA=$to_update_qty&SCRE=".$r_reasons[$key]."&DSP1=1&DSP2=1&DSP3=1&DSP4=1";
                            $api_data = $obj->getCurlAuthRequest($api_url);
                            $decoded = json_decode($api_data,true);
                            $type=$decoded['@type'];
                            $code=$decoded['@code'];
                            $message=$decoded['Message'];
                        }

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
                            $qry_transactionslog="INSERT INTO $brandix_bts.`transactions_log` (`transaction_id`,`response_message`,`created_by`,`created_at`,`updated_at`) VALUES ('$insert_id','$message','$username','$current_date')"; 
                            mysqli_query($link,$qry_transactionslog) or exit("While inserting into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
                        }
                    }
                }
            }
        }
    }
    return true;
}
?>
