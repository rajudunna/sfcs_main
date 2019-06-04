<?php
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
$connect = odbc_connect("$driver_name;Server=$sfsp_serverName;Database=$sfsp_m3_databasename;", $sfsp_uid,$sfsp_pwd);
error_reporting(1);

$get_details="select order_style_no,order_del_no,order_col_des from bai_pro3.bai_orders_db_confirm where order_joins not in ('1','2') group by order_style_no,order_del_no,order_col_des";
echo $get_details."<br>";
$result=mysqli_query($link, $get_details) or exit("NOT Updated schedule and color details".mysqli_error($GLOBALS["___mysqli_ston"]));
echo mysqli_num_rows($result);
while($row = mysqli_fetch_array($result))
{
	   $schedule =$row['order_del_no'];

	   $color = $row['order_col_des'];

	   $style= $row['order_style_no'];

	   $lay_plan_status_value=0;
	   $lay_plan_status_query="SELECT COUNT(DISTINCT order_del_no) as value FROM BAI_PRO3.bai_orders_db_confirm WHERE order_del_no='".$schedule."' and order_col_des='".$color."'";
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
	   $total_jobs_result=mysqli_query($link, $total_jobs) or exit("NOT Updated schedule and color details".mysqli_error($GLOBALS["___mysqli_ston"]));
	   while($total_jobs_row = mysqli_fetch_array($total_jobs_result))
	   {
			$total_jobs_value=$total_jobs_row["value"];
	   }    

	   $input_qty=0;
	   $input_qty="SELECT COUNT(cat_ref) as value FROM BAI_PRO3.order_cat_doc_mix WHERE order_del_no IN ('".$schedule."') and order_col_des='".$color."' AND category IN (\"Body\",\"Front\")";
	   $input_qty_result=mysqli_query($link, $input_qty) or exit("NOT Updated schedule and color details".mysqli_error($GLOBALS["___mysqli_ston"]));
	   while($input_qty_row = mysqli_fetch_array($input_qty_result))
	   {
			$input_qty_value=$input_qty_row["value"];
	   }             

	   $input_status_value=0;
	   $input_status_value="SELECT COUNT(DISTINCT order_del_no) as value FROM BAI_PRO3.bai_orders_db_confirm WHERE order_del_no='".$schedule."' and order_col_des='".$color."'";
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
	   $planned_jobs_result=mysqli_query($link, $planned_jobs) or exit("NOT Updated schedule and color details".mysqli_error($GLOBALS["___mysqli_ston"]));
	   while($planned_jobs_row = mysqli_fetch_array($planned_jobs_result))
	   {
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
       $sql_check="SELECT COUNT(*) as count FROM [BEL_RMDashboard].[dbo].[SFCS_FSP_Integration] WHERE Schedule=".$schedule." and ColorId='".$color."'";
       echo $sql_check."<br>";
	   $result_check=odbc_exec($connect, $sql_check) or exit("Error=".odbc_errormsg($connect));
	   while(odbc_fetch_row($result_check))
	   {
		  $count1=odbc_result($result_check,1);

		  if($count1==0)
		  {
             $sql2="insert [$sfsp_serverName].[$sfsp_m3_databasename].dbo.SFCS_FSP_Integration(Schedule,FactoryId,ColorId,LayPlanPrepStatusDesc,NoOfCutJobs,LayPlanGenerationStatusDesc,InputStatusDesc,NoOfJobsPlanned) values('".$schedule."','".$facility_code."','".$color."','".$lay_done."','".$total_jobs_value."','".$lay_plan_status."','".$input_status."','".$planned_jobs_value."')";
             echo $sql2."<br>";
			 $result7=odbc_exec($connect, $sql2) or exit("Error2=".odbc_errormsg($connect));
		  }
		  else
		  {             
            $sql2="update [$sfsp_serverName].[$sfsp_m3_databasename].dbo.SFCS_FSP_Integration set LayPlanGenerationStatusDesc='".$lay_done."', NoOfJobsPlanned='".$planned_jobs_value."',NoOfCutJobs='".$total_jobs_value."',LayPlanPrepStatusDesc='".$lay_plan_status."',InputStatusDesc='".$input_status."' where Schedule='".$schedule."' AND ColorId='".$color."'";
            echo $sql2."<br>";
			$result8=odbc_exec($connect, $sql2) or exit("Error3=".odbc_errormsg($connect));
		  }
	   }
}  

?>