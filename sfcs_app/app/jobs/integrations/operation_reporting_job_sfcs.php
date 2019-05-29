<?php

$start_timestamp = microtime(true);
error_reporting(0);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');

$sql="select *,sum(quantity) as qty from $bai_pro3.m3_transactions where response_status='pe' group by mo_no,workstation_id,op_code,reason";
$transaction_result=mysqli_query($link, $sql) or exit("m3_transactions ERROR".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row=mysqli_fetch_array($transaction_result))
{
   
    $mo_number = $row['mo_no'];
    $op_code = $row['op_code'];
    $workstation_id = $row['workstation_id'];
    $quantity = $row['qty'];
    $remarks = $row['remarks'];
    $log_user = $row['log_user'];
    $tran_status_code = $row['tran_status_code'];
    $shift = $row['shift'];
    $reason = $row['reason'];
    $module_no = $row['module_no'];
    $op_des = $row['op_des'];
    $ref_no = $row['ref_no'];
    $response_status = $row['response_status'];
    $m3_ops_code = $row['m3_ops_code'];
    $m3_trail_count = $row['m3_trail_count'];
    $api_type = $row['api_type'];
    $date_time = $row['date_time'];

  
    $cur_date = date('Y-m-d H:s:i');
    $inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_bulk_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`m3_ops_code`,`response_status`,`api_type`) 
    VALUES ('$date_time','$mo_number',$quantity,'$reason','$remarks','$log_user','$tran_status_code','$module_no','$shift',$op_code,'$op_des',$ref_no,'$workstation_id','$m3_ops_code','pending',' $api_type')";
    mysqli_query($link,$inserting_into_m3_tran_log) or exit("While inserting into m3_tranlog".mysqli_error($GLOBALS["___mysqli_ston"]));

    $insert_id=mysqli_insert_id($link);

    $qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET m3_bulk_tran_id=$insert_id,response_status='complete'  WHERE mo_no='$mo_number' and  workstation_id ='$workstation_id' and op_code='$op_code' and reason='$reason'";
    // echo  $qry_m3_transactions."<br>";
    $res=mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
}

$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." seconds.");
?>