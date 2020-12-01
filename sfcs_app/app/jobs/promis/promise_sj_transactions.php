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
	$get_details = "select ref_no,m3_ops_code,mo_no,CAST(date_time AS DATE) AS trans_date,module_no AS division_code,
	quantity AS quantity,log_user,id,
	reason,CASE WHEN CAST(date_time AS TIME) BETWEEN '08:45:00' AND '09:44:59' THEN 1 WHEN CAST(date_time AS TIME) BETWEEN '09:45:00' AND '10:44:59' THEN 2 WHEN CAST(date_time AS TIME) BETWEEN '10:45:00' AND '11:44:59' THEN 3 WHEN CAST(date_time AS TIME) BETWEEN '11:45:00' AND '12:59:59' THEN 4 WHEN CAST(date_time AS TIME) BETWEEN '13:00:00' AND '14:14:59' THEN 5 WHEN CAST(date_time AS TIME) BETWEEN '14:15:00' AND '15:14:59' THEN 6 WHEN CAST(date_time AS TIME) BETWEEN '15:15:00' AND '16:14:59' THEN 7 WHEN CAST(date_time AS TIME) BETWEEN '16:15:00' AND '16:59:59' THEN 8 WHEN CAST(date_time AS TIME) BETWEEN '17:00:00' AND '18:00:00' THEN 9 ELSE 10 END AS slot_id from $bai_pro3.m3_transactions where api_type='opn' and promis_status=0 and date_time between '$date 00:00:00' and '$date 23:59:59'";
	$result1=mysqli_query($link, $get_details) or die ("Error1.1=".$get_details.mysqli_error($GLOBALS["___mysqli_ston"]));
	$log.="<tr><th></th><th>".$get_details."</th><th></th></tr>";	
	while($row1=mysqli_fetch_array($result1))
	{
		$i++;		
		$operation_id = $row1['m3_ops_code'];
		$mo_number = $row1['mo_no'];
		$reported_quantity = $row1['quantity'];
		$module = $row1['division_code'];
		$user_id = $row1['log_user'];
		$reason = $row1['reason'];
		$time = $row1['slot_id'];
		//$gate_pass_no = $row1['gate_pass_no'];
		$id = $row1['id'];
		$trans_date = $row1['trans_date'];
		
		//To get user barcode
		$barcode_sql = "select ref_no from $bai_pro3.mo_operation_quantites where id=".$row1['ref_no'];
		$barcode_res = $link->query($barcode_sql);
		while($result_row = $barcode_res->fetch_assoc())
		{
			$unique_id = $result_row['ref_no'];
			$bundle_no = $result_row['ref_no'];
		}
		//To get user barcode
		$gate_pass_no=0;
		$gatepass_sql = "select gate_id as gate_pass_no from $brandix_bts.gatepass_track where bundle_no=$bundle_no";
		$gatepass_sql_res = $link->query($gatepass_sql);
		while($result_val = $gatepass_sql_res->fetch_assoc())
		{
			$gate_pass_no = $result_val['gate_pass_no'];
		}
		//To Info
		$mo_data = "select mos.REFERENCEORDER AS co_id,mos.COLORCODE AS colour_code,mos.COLOURDESC AS colour_desc,mos.SIZECODE AS size_code,mos.SIZEDESC AS size_desc,mos.SCHEDULE AS schedule_id,mos.ZCODE AS z_name,mos.ZDESC AS z_desc from $m3_inputs.mo_details mos where MONUMBER='$mo_number'";
		$result_mo_data = $link->query($mo_data);
		while($row_mo = $result_mo_data->fetch_assoc())
		{
			$co_no = $row_mo['co_id'];
			$color_code = $row_mo['colour_code'];
			$color_desc = $row_mo['colour_desc'];
			$size_code = $row_mo['size_code'];
			$size_desc = $row_mo['size_desc'];
			$schedule = $row_mo['schedule_id'];
			$z_code = $row_mo['z_name'];
			$z_desc = $row_mo['z_desc'];
		}
		
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
					$sql_update="UPDATE $bai_pro3.m3_transactions SET promis_status = 1 WHERE id = ".$id;
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
					$sql_update="UPDATE $bai_pro3.m3_transactions SET promis_status = 1 WHERE id = ".$id;
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

