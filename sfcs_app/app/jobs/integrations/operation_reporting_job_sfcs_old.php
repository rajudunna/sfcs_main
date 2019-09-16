<?php

$start_timestamp = microtime(true);
error_reporting(0);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
$cur_date = date('Y-m-d H:s:i');
$add_filter_qry="IF(m3_op_des in ('ASPS','ASPR','BSPS','BSPR'),'1',IF(m3_op_des in ('SIN','PS','PR','CUT','LAY'),'01',IF(sfcs_mod_no>0,LPAD(CAST(sfcs_mod_no as SIGNED),2,0),'01')))";

$sql="SELECT *,sum(quantity) as qty,group_concat(id) as ids,concat('$facility_code',m3_op_des,$add_filter_qry) as work_center FROM `m3_bulk_ops_rep_db`.`m3_sfcs_tran_log` where sfcs_status ='10' and m3_bulk_tran_id IS NULL group by m3_mo_no,m3_op_code,sfcs_reason";
$transaction_result=mysqli_query($link_sfcs, $sql) or exit("m3_transactions ERROR".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row=mysqli_fetch_array($transaction_result))
{
    $mo_number = $row['m3_mo_no'];
    $op_code = $row['m3_op_code'];
    $workstation_id = $row['work_center'];
    $quantity = $row['sfcs_qty'];
    $remarks = $row['sfcs_remarks'];
    $log_user = $row['sfcs_log_user'];
    $tran_status_code = 0;
    $shift = $row['sfcs_shift'];
    $reason = $row['sfcs_reason'];
    $module_no = $row['sfcs_mod_no'];
    $op_des = $row['m3_op_des'];
    $ref_no = $row['sfcs_tid_ref'];
    $response_status = 'pending';
    $m3_ops_code = $row['m3_op_code'];
    $m3_trail_count = 0; 
    $date_time = $row['sfcs_log_time'];
    $ids=$row['ids'];  
    $api_type='opn';
	if($op_code==200)
	{
		$inserting_into_m3_tran_log1 = "INSERT INTO $bai_pro3.`m3_bulk_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`m3_ops_code`,`response_status`,`m3_trail_count`,`api_type`)
		VALUES ('$cur_date','$mo_number',$quantity,'$reason','$remarks','$log_user','$tran_status_code','$module_no','$shift',$op_code,'$op_des',$ref_no,'$workstation_id','$m3_ops_code','$response_status',$m3_trail_count,'fg')";
		mysqli_query($link_sfcs,$inserting_into_m3_tran_log1) or exit("While inserting into m3_tranlog".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_bulk_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`m3_ops_code`,`response_status`,`m3_trail_count`,`api_type`)
		VALUES ('$cur_date','$mo_number',$quantity,'$reason','$remarks','$log_user','$tran_status_code','$module_no','$shift',$op_code,'$op_des',$ref_no,'$workstation_id','$m3_ops_code','$response_status',$m3_trail_count,'$api_type')";
		mysqli_query($link_sfcs,$inserting_into_m3_tran_log) or exit("While inserting into m3_tranlog".mysqli_error($GLOBALS["___mysqli_ston"]));	
	}
	else
	{
		$inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_bulk_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`m3_ops_code`,`response_status`,`m3_trail_count`,`api_type`)
		VALUES ('$cur_date','$mo_number',$quantity,'$reason','$remarks','$log_user','$tran_status_code','$module_no','$shift',$op_code,'$op_des',$ref_no,'$workstation_id','$m3_ops_code','$response_status',$m3_trail_count,'$api_type')";
		mysqli_query($link_sfcs,$inserting_into_m3_tran_log) or exit("While inserting into m3_tranlog".mysqli_error($GLOBALS["___mysqli_ston"]));		
	}    
	$insert_id=mysqli_insert_id($link_sfcs);
	
    $qry_m3_transactions="UPDATE `m3_bulk_ops_rep_db`.`m3_sfcs_tran_log` SET m3_bulk_tran_id=$insert_id  WHERE sfcs_tid in ($ids) ";
    $res=mysqli_query($link_sfcs,$qry_m3_transactions) or exit("While updating into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
}

$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." seconds.");
?>
