<?php
error_reporting(0); 
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
// echo "promis_sql_driver_name : ".$promis_sql_driver_name."</br>";
// echo "promis_sql_odbc_server : ".$promis_sql_odbc_server."</br>";
// echo "promis_db : ".$promis_db."</br>";
// echo "promis_sql_odbc_user : ".$promis_sql_odbc_user."</br>";
// echo "promis_sql_odbc_pass : ".$promis_sql_odbc_pass."</br>";
if(isset($_GET["date"]))
{
    $date=$_GET["date"];
}
else
{
    $date = date("Y-m-d");
}
$conn = odbc_connect("$promis_sql_driver_name;Server=$promis_sql_odbc_server;Database=$promis_db;", $promis_sql_odbc_user,$promis_sql_odbc_pass);

if($conn)
{
	$ops_arry=array(30,75,200,15,144,50,115,143,40,110,144,50,115,143,40,110,148,143,125,120,115,110,200,10,190,50,40,130,6,5,22,21,1,100,190,195,148,70,147,60,125,120,500);
	$ops_arry_1=array(610,20,200,15,144,50,115,143,40,110,144,50,115,143,40,110,148,143,125,120,115,110,200,10,190,50,40,800,6,5,25,22,1,30,190,195,148,70,147,60,125,120,500);
	for($i=0;$i<sizeof($ops_arry);$i++)
	{
		$ops_value[$ops_arry[$i]]=$ops_arry_1[$i];
	}

    $get_details1 = "select operation_code,category from $brandix_bts.tbl_orders_ops_ref";
	$result1=mysqli_query($link, $get_details1) or die ("Error1.1=".$get_details.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		$status[$row1['operation_code']]=$row1['category'];	
	}
	//To get module description
	$get_module_desc = "select module_name,module_description from $bai_pro3.module_master";
	$result_module = $link->query($get_module_desc);
	while($row_mod = $result_module->fetch_assoc())
	{
		$module_desc[$row_mod['module_name']] = $row_mod['module_description'];
	}
	//To get user id
	$get_user_id = "select uid,username from central_administration_sfcs.user_list";
	$result_user = $link->query($get_user_id);
	while($row_user = $result_user->fetch_assoc())
	{
		$uid[$row_user['username']] = $row_user['uid'];
	}

	//Deletion in Promis
	// if(isset($_GET["date"]))
	// {
	//    $delete_data_cut = "DELETE FROM [$promis_db].[dbo].[ProMIS_SX_OR_Day_MQTY] WHERE trans_date ='$date'"; 
	//    odbc_exec($conn, $delete_data_cut);
	   
	//    $delete_data_qty = "DELETE FROM [$promis_db].[dbo].[ProMIS_SX_OR_Day_Unique] WHERE trans_date ='$date'"; 
	//    odbc_exec($conn, $delete_data_qty);
	// }

	$get_details = "select * from $bai_pro3.promisdata where trans_date ='$date'";
	$result1=mysqli_query($link, $get_details) or die ("Error1.1=".$get_details.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
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
		if($gate_pass_no=' '){
			$gate_pass_no=0;
		}
		// $Hour = date('H');
		// $min = date('i');
		// if($min>0)
		// {
			// $Time=$Hour+1;
		// }
		// else
		// {
			// $Time=$Hour;
		// }
		// $final_val=ltrim(date("md"), "0").$time;
		if($status[$operation_id]=='sewing')
		{
			// To get sewing job
			$get_sewing_job = "select input_job_no from $bai_pro3.pac_stat_log_input_job where tid ='$bundle_no'";
			$result_get_sewing_job = $link->query($get_sewing_job);
			while($row_job = $result_get_sewing_job->fetch_assoc()) 
			{
				$sewing_job_no = $row_job['input_job_no'];
			}
			
			//$val=explode("-",$trans_date);
				
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
			Values('".$unique_id."','".$co_no."','".$color_code."','".$color_desc."','".$size_code."','".$size_desc."','".$schedule."','".$z_code."','".$z_desc."','1','".$sewing_job_no."',0,'".$bundle_no."','".$ops_value[$operation_id]."','".$mo_number."','".$date."','".$module_desc[$module]."','".$time."','".$reported_quantity."','".$uid[$user_id]."','".$gate_pass_no."','0')";
			
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
			Values('".$co_no."','".$color_code."','".$color_desc."','".$size_code."','".$size_desc."','".$schedule."','".$z_code."','".$z_desc."','1','".$sewing_job_no."','".$ops_value[$operation_id]."','".$mo_number."','".$date."','".$div_code."','".$reported_quantity."','".$uid[$user_id]."','".$mod_mode."','".$rejection_reason."','NULL')";			
		}
		odbc_exec($conn, $inserting_qry);	
	}
}
else
{
  print("Connection Failed")."\n";
}	
	

$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.")."\n";

?>

