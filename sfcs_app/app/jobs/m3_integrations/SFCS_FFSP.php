<?php
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
$driver_name = 'SQL Server Native Client 11.0';
$serverName='BAS-DBSRV-01';
$m3_databasename='BEL_RMDashboard';
$uid='sfcsproject4';
$pwd='Brand@2018';
$connect = odbc_connect("$driver_name,Server=$serverName,Database=$m3_databasename;", $uid,$pwd);
//$conn = odbc_connect($conn_string,$user_ms,$password_ms);
error_reporting(1);

$get_details="select order_style_no,order_del_no,order_col_des from bai_pro3.bai_orders_db_confirm limit 1";
//echo $get_details."<br>";
$result=mysqli_query($link, $get_details) or exit("NOT Updated schedule and color details".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row = mysqli_fetch_array($result))
{
	$schedule =$row['order_del_no'];
	$color = $row['order_col_des'];
	$style= $row['order_style_no'];
	
	$lay_plan_status_value=0;
	$lay_plan_status_query="SELECT COUNT(DISTINCT order_del_no) as value FROM BAI_PRO3.bai_orders_db_confirm WHERE order_del_no='".$schedule."' and order_col_des='".$color."'";
	echo $lay_plan_status_query."<br>";
	$result1=mysqli_query($link, $lay_plan_status_query) or exit("NOT Updated schedule and color details".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1 = mysqli_fetch_array($result1))
	{
		$lay_plan_status_value=$row1["value"];
	}

	if($lay_plan_status_value=='1')
	{
		$lay_plan_status='DONE';
	}			
	else
	{
		$lay_plan_status='NOT DONE';
	}
	
	
	$total_jobs_value=0;
	$total_jobs="SELECT COUNT(cat_ref) as value FROM BAI_PRO3.order_cat_doc_mix WHERE order_del_no IN ('".$schedule."') and order_col_des='".$color."' AND category IN (\"Body\",\"Front\")";
	echo $total_jobs."<br>";
	$total_jobs_result=mysqli_query($link, $total_jobs) or exit("NOT Updated schedule and color details".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($total_jobs_row = mysqli_fetch_array($total_jobs_result))
	{
		// echo $total_jobs."---".$total_jobs_row["value"]."<BR><BR>";
		$total_jobs_value=$total_jobs_row["value"];
	}	
	
	
	$input_qty=0;
	$input_qty="SELECT COUNT(cat_ref) as value FROM BAI_PRO3.order_cat_doc_mix WHERE order_del_no IN ('".$schedule."') and order_col_des='".$color."' AND category IN (\"Body\",\"Front\")";
	echo $input_qty."<br>";
	$input_qty_result=mysqli_query($link, $input_qty) or exit("NOT Updated schedule and color details".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($input_qty_row = mysqli_fetch_array($input_qty_result))
	{
		// echo $planned_jobs."---".$planned_jobs_row["value"]."<BR><BR>";
		$input_qty_value=$input_qty_row["value"];
	}	
	
	
	$input_status_value=0;
	$input_status_value="SELECT COUNT(DISTINCT order_del_no) as value FROM BAI_PRO3.bai_orders_db_confirm WHERE order_del_no='".$schedule."' and order_col_des='".$color."'";
	echo $input_status_value."<br>";
	$result1=mysqli_query($link, $input_status_value) or exit("NOT Updated schedule and color details".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1 = mysqli_fetch_array($result1))
	{
		$input_status_value=$row1["value"];
	}

	if($input_status_value=='1')
	{
		$input_status='DONE';
	}			
	else
	{
		$input_status='NOT DONE';
	}
	
	
	$planned_jobs_value=0;
	$planned_jobs="SELECT COUNT(cat_ref) as value FROM BAI_PRO3.order_cat_doc_mix WHERE order_del_no IN ('".$schedule."') and order_col_des='".$color."' AND category IN (\"Body\",\"Front\")";
	echo $planned_jobs."<br><br><br>";
	$planned_jobs_result=mysqli_query($link, $planned_jobs) or exit("NOT Updated schedule and color details".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($planned_jobs_row = mysqli_fetch_array($planned_jobs_result))
	{
		// echo $planned_jobs."---".$planned_jobs_row["value"]."<BR><BR>";
		$planned_jobs_value=$planned_jobs_row["value"];
	}	
	
		
		
		if($lay_done='1')
		{
			 $lay_done='DONE';
		}
		else
		{
			 $lay_done='NOT DONE';
		}
	$sql_check='SELECT COUNT(*) as count FROM [BAS-DBSRV-01].[BEL_RMDashboard].dbo.SFCS_FSP_Integration WHERE Schedule="'.$schedule.'" and ColorId="'.$color.'"';
	echo $sql_check."<br>";
	$result=mssql_query($myDB, $sql_check) or die("Couldn't open database $myDB");
	while($row = mssql_query($result))
	{
		$count1=$row['count'];
		 if($count1=0)
		{
			$sql2='SELECT * FROM [BAS-DBSRV-01].[BEL_RMDashboard].dbo.SFCS_FSP_Integration WHERE Schedule="'.$schedule.'" and ColorId="'.$color.'"';
			echo $sql2."<br>";
	
			/*$sql2='insert [BAS-DBSRV-01].[BEL_RMDashboard].dbo.SFCS_FSP_Integration(Schedule,FactoryId,ColorId,PCD,LayPlanPrepStatusDesc,NoOfCutJobs,LayPlanGenerationStatusDesc,InputStatusDesc,NoOfJobsPlanned) values("'.$schedule.'","'.$facility_code.'","'.$color.'","'.$lay_done.'",CAST ("'.$total_jobs_value.'" as VARCHAR(MAX)),"'.$lay_plan_status.'",CAST ("'.$input_status.'" as VARCHAR(MAX)),CAST ("'.$planned_jobs_value.'" as VARCHAR(MAX)))';*/
			$result7=mssql_query($myDB, $sql2) or die("Data not updated $myDB");
			echo $result7."<br><br>";
			
		}
		else
		{	
			$sql2='update [BAS-DBSRV-01].[BEL_RMDashboard].dbo.SFCS_FSP_Integration set LayPlanGenerationStatusDesc="'.$lay_done.'",
			NoOfJobsPlanned="'.$planned_jobs_value.'",NoOfCutJobs=CAST ($total_jobs as VARCHAR(MAX)),
			LayPlanPrepStatusDesc="'.$lay_plan_status.'",InputStatusDesc=CAST ("'.$input_status.'" as VARCHAR(MAX)) where Schedule="'.$schedule.'" AND ColorId="'.$color.'"';
			$result8=mssql_query($myDB, $sql2) or die("data not updated $myDB");
			echo $result8."<br><br>";
			
		}
	
	}
	echo "Orders=".$style."/".$schedule."/".$color."/".$lay_plan_status."/".$planned_jobs_value."/".$total_jobs_value."/".$input_qty_value."/".$input_status." <br><br>";
}

?>