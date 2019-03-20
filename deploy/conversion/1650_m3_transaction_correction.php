<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
error_reporting(0);
$m3_transactions_qry ="SELECT * FROM bai_pro3.m3_transactions WHERE m3_ops_code = 200 AND date_time >= '2019-02-28 14:44:33' AND quantity > 0";
$m3_transactions_qry_result=mysqli_query($link,$m3_transactions_qry) or exit("Initial Query Error".mysqli_error($GLOBALS["___mysqli_ston"]));
echo "Running<br/>";
$my_file = '1650_script_execution_log.txt';
$handle = fopen($my_file, 'a') or die('Cannot open file:  '.$my_file);
while($m3_transactions_qry_result_row=mysqli_fetch_array($m3_transactions_qry_result))
{
    $date_time =  date("Y-m-d H:i:s");
    $transaction_id = $m3_transactions_qry_result_row['id'];
    $mo_no = $m3_transactions_qry_result_row['mo_no'];
    $quantity =  $m3_transactions_qry_result_row['quantity'];
    $reason = $m3_transactions_qry_result_row['reason'];
    $remarks = $m3_transactions_qry_result_row['remarks'];
    $log_user = $m3_transactions_qry_result_row['log_user'];
    $tran_status_code = $m3_transactions_qry_result_row['tran_status_code'];
    $module_no = $m3_transactions_qry_result_row['module_no'];
    $shift = $m3_transactions_qry_result_row['shift'];
    $op_code = $m3_transactions_qry_result_row['op_code'];
    $op_des = $m3_transactions_qry_result_row['op_des'];
    $ref_no = $m3_transactions_qry_result_row['ref_no'];
    $workstation_id = $m3_transactions_qry_result_row['workstation_id'];
    $response_status = $m3_transactions_qry_result_row['response_status'];
    $m3_ops_code = $m3_transactions_qry_result_row['m3_ops_code'];
    $m3_trail_count =$m3_transactions_qry_result_row['m3_trail_count'];
    $api_type = $m3_transactions_qry_result_row['api_type'];
    fwrite($handle,"\n".$transaction_id);
    $insert_qry_neg = "INSERT INTO $bai_pro3.`m3_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`,`m3_ops_code`,`m3_trail_count`,`api_type`) values ('$date_time','$mo_no','".($quantity*-1)."','$reason','$remarks','$log_user','$module_no','$shift','$op_code','$op_des','$ref_no',
    '$workstation_id','fail','$m3_ops_code','$m3_trail_count','$api_type')";
    $res_insert_qry_neg = $link->query($insert_qry_neg);
    if($res_insert_qry_neg)
    {
        fwrite($handle,"-".'fail');
    }
    $insert_qry_pass = "INSERT INTO $bai_pro3.`m3_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`,`m3_ops_code`,`m3_trail_count`,`api_type`) values ('$date_time','$mo_no','$quantity','$reason','$remarks','$log_user','$module_no','$shift','$op_code','$op_des','$ref_no',
    '$workstation_id','pass','$m3_ops_code','$m3_trail_count','$api_type')";
    $res_insert_qry_pass = $link->query($insert_qry_pass);
    if($res_insert_qry_pass)
    {
        fwrite($handle,"-".'pass');
    }
}
echo "success";


?>