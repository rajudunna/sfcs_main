<?php 
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');

$conn = odbc_connect("$promis_sql_driver_name;Server=$promis_sql_odbc_server;Database=$promis_db;", $promis_sql_odbc_user,$promis_sql_odbc_pass);

$get_sewing_details = "SELECT input_job_no,carton_act_qty,size_code,input_job_no_random,doc_no,type_of_sewing  from $bai_pro3.pac_stat_log_input_job where api_status = 0";
$result1=mysqli_query($link, $get_sewing_details) or die ("Error1.1=".$get_sewing_details.mysqli_error($GLOBALS["___mysqli_ston"]));
while($row1=mysqli_fetch_array($result1))
{
    $input_job = $row1['input_job_no_random'];
    $job_no = $row1['input_job_no'];
    $quantity = $row1['carton_act_qty'];
    $size = $row1['size_code'];
    $docket = $row['doc_no'];
    $type = $row['type_of_sewing'];

    if($type == 2)
    {
       $sewing_type ='1';
    }
	else
    {
       $sewing_type ='0';
    }

    $get_details = "select style,schedule,color from $brandix_bts.bundle_creation_data where docket_number = '$docket' limit 1";
    $result_checking_qry = $link->query($get_details);
	while($row2 = $result_checking_qry->fetch_assoc()) 
	{
      $style = $row2['style'];
      $schedule = $row2['schedule'];
      $color = $row2['color'];
	}

	$get_planning_details = "select input_module,DATE(log_time) from $bai_pro3.plan_dashboard_input where input_job_no_random_ref='$input_job'";
	$result_planning_details = $link->query($get_planning_details);
	if(mysqli_num_rows($result_planning_details)>0)
	{
		while($row3 = $result_planning_details->fetch_assoc())
		{
		   $module = 'CW-Team-'.$row3['input_module'];
		   $log_time = $row3['log_time'];
		}
	}
	else
	{
		$get_planning_details1 = "select input_module,DATE(log_time) from $bai_pro3.plan_dashboard_input_backup where input_job_no_random_ref='$input_job' limit 1";
		$result_planning_details1 = $link->query($get_planning_details1);
		if(mysqli_num_rows($result_planning_details1)>0)
		{
			while($row31 = $result_planning_details1->fetch_assoc())
			{
			   $module = 'CW-Team-'.$row31['input_module'];
			   $log_time = $row31['log_time'];
			}
		}
		else
		{
			$module=0;
			$log_time='0000-00-00'
		}
	}
	$get_co_details = "select REFERENCEORDER from $m3_inputs.mo_details where style ='$style' and SCHEDULE='$schedule' AND colourdesc='$color' AND sizedesc='$size'";
	$result_co_details = $link->query($get_co_details);
	while($row4 = $result_co_details->fetch_assoc())
	{
       $co_no = $row4['REFERENCEORDER'];
	}

	$inserting__qry = "INSERT IGNORE INTO [$promis_db].[dbo].[ProMIS_SX_SJ_Master](MRNNo,
     CO_ID,
     Schedule_ID,
     Colour_Code,
     Size_Code,
     Country_ID,
     Colour_Description,
     Size_Description,
     Quantity,
     Prod_Line,
     Plan_Date,
     Shade,
     ERP_MRNNo,
     Manual_Flag,
     Error_Flag,
     Freez_Flag,
     Block_Flag,
     Sew_Line,
     Plan_Date2) values('$job_no','$co_no','$schedule','$color','$size','1','$color','$size','$quantity','$module','$log_time','$sewing_type','1','NULL','NULL')";
	$insert_qry_result = $link->query($inserting__qry);

}	



$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.")."\n";

?>

