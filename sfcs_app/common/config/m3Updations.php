
<?php

// LOGIC TO INSERT TRANSACTIONS IN M3_TRANSACTIONS TABLE

//function updateM3Transactions($input_doc_no,$op_code,$op_code,$input_shift,$plan_module){
function  updateM3Transactions($ref_id,$op_code,$qty)
{
    include("config_ajax.php");

    $details_query = "Select shift,assigned_module from $brandx_bts.bundle_creation_data where bundle_no = '$ref_id' and op_code = '$op_code'";
    $details_result = mysqli_query($link,$details_query) or exit("Problem in getting details from the BCD");
    while($row = mysqli_fetch_array($details_result)){
        $plan_module = $row['shift'];
        $input_shift  = $row['assigned_module'];
    }
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
                // if($is_m3 == 'yes')
                // {
                $inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_transactions` (`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`) VALUES ('$mo_number',$to_update_qty,'','Normal',user(),'',$b_module,'$b_shift',$op_code,'$ops_des',$id,'$work_station_id','')";
            //echo $inserting_into_m3_tran_log.'</br>';
                mysqli_query($link,$inserting_into_m3_tran_log) or exit("While inserting into m3_tranlog".mysqli_error($GLOBALS["___mysqli_ston"]));
            // }

                $insert_id=mysqli_insert_id($link);

                // //M3 Rest API Call
                if($enable_api_call == 'YES'){
                    $api_url = $host.":".$port."/m3api-rest/execute/PMS070MI/RptOperation?CONO=$company_num&FACI=$plant_code&MFNO=$mo_number&OPNO=$b_op_id&DPLG=$work_station_id&MAQA=$to_update_qty&SCQA=''&SCRE=''&DSP1=1&DSP2=1&DSP3=1&DSP4=1";
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
                    $qry_transactionslog="INSERT INTO $brandix_bts.`transactions_log` (`transaction_id`,`response_message`,`created_by`,`created_at`) VALUES ('$insert_id',$message,USER(),$current_date)"; 
                    mysqli_query($link,$qry_transactionslog) or exit("While inserting into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
                }
            }
        }
    }

}


function updateM3TransactionsReversal($bundle_no,$reversalval,$op_code){
    include('config_ajax.php');
    $current_date = date("Y-m-d H:i:s");

    $details_query = "Select shift,assigned_module from $brandx_bts.bundle_creation_data where bundle_no = '$bundle_no' and op_code = '$op_code'";
    $details_result = mysqli_query($link,$details_query) or exit("Problem in getting details from the BCD");
    while($row = mysqli_fetch_array($details_result)){
        $plan_module  = $row['shift'];
        $input_shift  = $row['assigned_module'];
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
        $b_style = $row['style'];
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
            $ims_pro_qty_updating = mysqli_query($link,$update_qry) or exit("While updating mo_operation_quantites".mysqli_error($GLOBALS["___mysqli_ston"]));
            $dep_ops_array_qry = "select default_operration from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$b_colors' and operation_code='$op_code'";
            $result_dep_ops_array_qry = $link->query($dep_ops_array_qry);
            while($row = $result_dep_ops_array_qry->fetch_assoc()) 
            {
                $is_m3 = $row['default_operration'];
            }
            if($is_m3 == 'Yes')
            {                    
                $to_update_qty = '-'.$b_rep_qty;
                $inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_transactions` (`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`) VALUES ('$mo_number','$to_update_qty','','Normal',user(),'',$plan_module,'$input_shift',$op_code,'',$id,'$work_station_id','')";
                // echo $inserting_into_m3_tran_log;
                mysqli_query($link,$inserting_into_m3_tran_log) or exit("While inserting into m3_tranlog".mysqli_error($GLOBALS["___mysqli_ston"]));
                $insert_id=mysqli_insert_id($link);

                // //M3 Rest API Call
                if($enable_api_call == 'YES'){
                    $api_url = $host.":".$port."/m3api-rest/execute/PMS070MI/RptOperation?CONO=$company_num&FACI=$plant_code&MFNO=$mo_number&OPNO=$op_code&DPLG=$work_station_id&MAQA=$to_update_qty&SCQA=''&SCRE=''&DSP1=1&DSP2=1&DSP3=1&DSP4=1";
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
                        $qry_transactionslog="INSERT INTO $brandix_bts.`transactions_log` (`transaction_id`,`response_message`,`created_by`,`created_at`) VALUES ('$insert_id',$message,USER(),$current_date)"; 
                        mysqli_query($link,$qry_transactionslog) or exit("While inserting into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
                    }
                }
                
            }
        }
    }
    
}//Function ends


function updateM3TransactionsRejections($ref_id,$op_code,$r_qty,$r_reasons)
{
    include('config_ajax.php');
    $current_date = date("Y-m-d H:i:s");
    $details_query = "Select shift,assigned_module from $brandx_bts.bundle_creation_data where bundle_no = '$ref_id' and op_code = '$op_code'";
    $details_result = mysqli_query($link,$details_query) or exit("Problem in getting details from the BCD");
    while($row = mysqli_fetch_array($details_result)){
        $plan_module = $row['shift'];
        $input_shift  = $row['assigned_module'];
    }
    
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
                
                    $inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_transactions` (`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`) VALUES ('$mo_number',$to_update_qty,'$r_reasons[$key]','Normal',user(),'',$b_module,'$b_shift',$op_code,'',$id,'$work_station_id','')";
                    // echo $inserting_into_m3_tran_log.'</br>';
                    mysqli_query($link,$inserting_into_m3_tran_log) or exit("While inserting into the m3_transactions".mysqli_error($GLOBALS["___mysqli_ston"]));

                    //getting the last inserted record
                    $insert_id=mysqli_insert_id($link);

                    //M3 Rest API Call
                    if($enable_api_call == 'YES'){
                        $api_url = $host.":".$port."/m3api-rest/execute/PMS070MI/RptOperation?CONO=$company_num&FACI=$plant_code&MFNO=$mo_number&OPNO=$b_op_id&DPLG=$work_station_id&MAQA=''&SCQA=$to_update_qty&SCRE='$r_reasons[$key]'&DSP1=1&DSP2=1&DSP3=1&DSP4=1";
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
                        $qry_transactionslog="INSERT INTO $brandix_bts.`transactions_log` (`transaction_id`,`response_message`,`created_by`,`created_at`,`updated_at`) VALUES ('$insert_id',$message,USER(),$current_date)"; 
                        mysqli_query($link,$qry_transactionslog) or exit("While inserting into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
                    }
                }
            }
        }
    }
    return true;
}
?>
