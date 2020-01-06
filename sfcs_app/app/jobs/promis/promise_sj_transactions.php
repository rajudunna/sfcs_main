<?php
error_reporting(0); 
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
$log="";
	
if(isset($_GET["date"]))
{
    $date=$_GET["date"];
}
else
{
    $date = date("Y-m-d");
}

$conn = odbc_connect("$promis_sql_driver_name;Server=$promis_sql_odbc_server;Database=$promis_db;", $promis_sql_odbc_user,$promis_sql_odbc_pass);
$log.="<table border=1><tr><th>SL no</th><th>Insert Query</th><th>Status</th></tr>";	
if($conn)
{
	$log.="<tr><th></th><th>Connected successfully</th><th></th></tr>";	
	//To get promis_operation_id & Flag
	$get_details1 = "select * from $bai_pro3.promis_ops_mapping where flag>0";
	$result1=mysqli_query($link, $get_details1) or die ("Error1.1=".$get_details.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		$promis_op_code[$row1['sfcs_operation_id']]=$row1['promis_operation_id'];	
		$flag_check[$row1['sfcs_operation_id']]=$row1['flag'];	
	}
	//To get module description & promis_division_code
	$get_module_desc = "select * from $bai_pro3.promis_module_mapping";
	$result_module = $link->query($get_module_desc);
	while($row_mod = $result_module->fetch_assoc())
	{
		$prom_div_code[$row_mod['sfcs_module_name']] = $row_mod['promis_division_code'];
	}
	//To get user id
	$get_user_id = "select uid,username from central_administration_sfcs.user_list";
	$result_user = $link->query($get_user_id);
	while($row_user = $result_user->fetch_assoc())
	{
		$uid[$row_user['username']] = $row_user['uid'];
	}
	$i=0;
	$get_details = "select * from $bai_pro3.promisdata where trans_date ='$date'";
	$result1=mysqli_query($link, $get_details) or die ("Error1.1=".$get_details.mysqli_error($GLOBALS["___mysqli_ston"]));
	$log.="<tr><th></th><th>".$get_details."</th><th></th></tr>";	
	while($row1=mysqli_fetch_array($result1))
	{
		$i++;
		$operation_id = $row1['operation_id'];
		$unique_id = $row1['bundle_number'];
		$co_no = $row1['co_id'];
		$color_code = $row1['colour_code'];
		$color_desc = $row1['colour_desc'];
		$size_code = $row1['size_code'];
		$size_desc = $row1['size_desc'];
		$schedule = $row1['schedule_id'];
		$z_code = $row1['z_name'];
		$z_desc = $row1['z_desc'];
		$mo_number = $row1['mo_number'];
		$reported_quantity = $row1['quantity'];
		$module = $row1['division_code'];
		$bundle_no = $row1['bundle_number'];
		$user_id = $row1['user_id'];
		$reason = $row1['rejection_reason'];
		$time = $row1['slot_id'];
		$gate_pass_no = $row1['gate_pass_no'];
		$id = $row1['unique_id'];
		$trans_date = $row1['trans_date'];
		
		if($reason <> '')
		{
			$rejection_reason = $reason;
		}
		else
		{
			$rejection_reason = 'NONE';
		}
			
		// Check gatepass		
		if($gate_pass_no == ''){
			$gate_pass_no=0;
		}
		// Checking weather code is available ir not
		if($flag_check[$operation_id]<>'')
		{
			if($flag_check[$operation_id]=='2' && $reason=='')
			{
				// To get sewing job
				$get_sewing_job = "select input_job_no from $bai_pro3.pac_stat_log_input_job where tid =$bundle_no";
				$result_get_sewing_job = $link->query($get_sewing_job);
				while($row_job = $result_get_sewing_job->fetch_assoc()) 
				{
					$sewing_job_number = $row_job['input_job_no'];
				}
				$sewing_job_no=explode(".",$sewing_job_number)[0];
				$inserting_qry = "INSERT INTO [$promis_db].[dbo].[ProMIS_SX_OR_Day_Unique](Unique_ID,
				CO_ID,
				Colour_Code,
				Colour_Description,
				Size_Code,
				Size_Description,
				Schedule_ID,
				Z_Code,
				Z_Description,
				Country_ID,
				MRNNO,
				Cut_ID,
				Bundle_ID,
				Operation_ID,
				MO_Number,
				Trans_Date,
				Division_Code,
				Slot_ID,
				Quantity,
				UID,
				GPNO,
				Session_ID)		
				Values('".$id."','".$co_no."','".$color_code."','".$color_desc."','".$size_code."','".$size_desc."','".$schedule."','".$z_code."','".$z_desc."','1','".$sewing_job_no."',0,'".$bundle_no."','".$promis_op_code[$operation_id]."','".$mo_number."','".$trans_date."','".$prom_div_code[$module]."','".$time."','".$reported_quantity."','".$uid[$user_id]."','".$gate_pass_no."','0')";
				//echo "Table - ProMIS_SX_OR_Day_Unique ---".$inserting_qry."<br>";
				$odbc_result=odbc_exec($conn, $inserting_qry);
				$status='Failed';
				if($odbc_result){
					$status='Success';
					$sql_update="UPDATE $bai_pro3.`m3_transactions` SET `promis_status` = 1 WHERE `id` = ".$id."";
					$sql_result=mysqli_query($link, $sql_update) or exit("Updatting issue".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				$log.="<tr><th>".$i."</th><th>".$inserting_qry."</th><th>".$status."</th></tr>";	
			}
			else
			{
				if($reason <> '')
				{
					$div_code = 'RJCT';
					$mod_mode = 2;
				}
				else
				{
					$div_code = 'DIV';
					$mod_mode = 1;
				}
				$sewing_job_no = 1;		
				$inserting_qry = "INSERT INTO [$promis_db].[dbo].[ProMIS_SX_OR_Day_MQTY](
				CO_ID,
				Colour_Code,
				Colour_Description,
				Size_Code,
				Size_Description,
				Schedule_ID,
				Z_Code,
				Z_Description,
				Country_ID,
				MRNNO,
				Operation_ID,
				MO_Number,
				Trans_Date,
				Division_Code,
				Quantity,
				UID,
				Module_Mode,
				Reason_Code,
				Remarks)
				Values('".$co_no."','".$color_code."','".$color_desc."','".$size_code."','".$size_desc."','".$schedule."','".$z_code."','".$z_desc."','1','".$sewing_job_no."','".$promis_op_code[$operation_id]."','".$mo_number."','".$trans_date."','".$div_code."','".$reported_quantity."','".$uid[$user_id]."','".$mod_mode."','".$rejection_reason."','NULL')";	
				//echo "Table - ProMIS_SX_OR_Day_MQTY ---".$inserting_qry."<br>";	
				$odbc_result1=odbc_exec($conn, $inserting_qry);
				$status='Failed';
				if($odbc_result1){
					$status='Success';
					$sql_update="UPDATE $bai_pro3.`m3_transactions` SET `promis_status` = 1 WHERE `id` = ".$id."";
					$sql_result=mysqli_query($link, $sql_update) or exit("Updatting issue".mysqli_error($GLOBALS["___mysqli_ston"]));		
				}
				$log.="<tr><th>".$i."</th><th>".$inserting_qry."</th><th>".$status."</th></tr>";	
			}
		}
		
	}
}
else
{
  print("Connection Failed")."\n";
	$log.="<tr><th></th><th>Connection Failed</th><th></th></tr>";	

}	
$log.="</table>";
$include_path=getenv('config_job_path');
$directory = $include_path.'\sfcs_app\app\m3_log_files\\'.'promise_logs';
if (!file_exists($directory)) {
	mkdir($directory, 0777, true);
}
$file_name_string = 'Promise_'.date("Y-m-d-H-i-s").'.html';
$my_file=$include_path.'\sfcs_app\app\m3_log_files\\'.'promise_logs\\'.$file_name_string;
$handle = fopen($my_file, 'a') or die('Cannot open file:  '.$my_file);
$file_data_request = $log;
fwrite($handle,"\n".$file_data_request); 

fclose($handle); 


?>

