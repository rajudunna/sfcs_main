<?php
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
error_reporting(0);

$sel_data ="select * FROM brandix_bts.open_style_wip where DATE(created_time)='".date("Y-m-d")."'";
$check_data_result = mysqli_query($link,$sel_data) or exit('checking  Error ');
if(mysqli_num_rows($check_data_result) ==0)
{
	//echo "Test---1Exist<br>";
	$delete_data ="DELETE FROM $brandix_bts.open_style_wip";
	//echo $delete_data."<br>";
	mysqli_query($link,$delete_data) or exit('Deleteing Data if exist in that date');

	$get_temp_data ="INSERT INTO $brandix_bts.open_style_wip (style,SCHEDULE,color,size,operation_code,good_qty,rejected_qty,status) 
	SELECT style,SCHEDULE,color,size_title,operation_id,SUM(recevied_qty) AS good_qty,SUM(rejected_qty) AS rejected_qty,'open' 
	FROM $brandix_bts.bundle_creation_data_temp where schedule in (SELECT DISTINCT order_del_no FROM `bai_pro3`.bai_orders_db_confirm where order_stat='') GROUP BY style,SCHEDULE,color,size_title,operation_id";
	mysqli_query($link,$get_temp_data) or exit('Inserting Data in that date');
	//echo $get_temp_data."<br>";
	
} 
else
{
	//echo "Test---1 New<br>";
	$delete_data ="DELETE FROM $brandix_bts.open_style_wip";
	//echo $delete_data."<br>";
	mysqli_query($link,$delete_data) or exit('Deleteing Data if exist in that date');

	$get_temp_data ="INSERT INTO $brandix_bts.open_style_wip (style,SCHEDULE,color,size,operation_code,good_qty,rejected_qty,status) 
	SELECT style,SCHEDULE,color,size_title,operation_id,SUM(recevied_qty) AS good_qty,SUM(rejected_qty) AS rejected_qty, 'open' 
	FROM $brandix_bts.bundle_creation_data_temp where DATE(scanned_date)<'".date('Y-m-d')."' and schedule in (SELECT DISTINCT order_del_no FROM `bai_pro3`.bai_orders_db_confirm where order_stat='') GROUP BY style,SCHEDULE,color,size_title,operation_id";
	mysqli_query($link,$get_temp_data) or exit('Inserting Data in that date');
	//echo $get_temp_data."<br>";
	
	$get_temp_data_temp ="INSERT IGNORE INTO $brandix_bts.open_style_wip (style,SCHEDULE,color,size,operation_code,good_qty,rejected_qty,status) 
	SELECT style,SCHEDULE,color,size_title,operation_id,0,0 ,'open'
	FROM $brandix_bts.bundle_creation_data_temp where DATE(scanned_date)='".date('Y-m-d')."' and schedule in (SELECT DISTINCT order_del_no FROM `bai_pro3`.bai_orders_db_confirm where order_stat='') GROUP BY style,SCHEDULE,color,size_title,operation_id";
	mysqli_query($link,$get_temp_data_temp) or exit('Inserting Data in that date');
	//echo $get_temp_data_temp."<br>";
}


?>