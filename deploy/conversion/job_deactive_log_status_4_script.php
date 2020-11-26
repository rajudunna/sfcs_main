<?php

ini_set('max_execution_time', '50000');

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

	$job_deactive = "SELECT style,schedule,GROUP_CONCAT(\"'\",input_job_no,\"'\") as input_job FROM $bai_pro3.`job_deactive_log` WHERE remove_type = '3' GROUP BY style,schedule";
	// echo $job_deactive;
	$job_deactive_result=mysqli_query($link, $job_deactive) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($deactive_jobs_row=mysqli_fetch_array($job_deactive_result))
	{
		$input_jobs[$deactive_jobs_row['style']][$deactive_jobs_row['schedule']]= $deactive_jobs_row['input_job'];
	}
	foreach ($input_jobs as $key1 => $value1) 
	{
		foreach ($value1 as $key => $job_numbers) 
		{
			$bcd_qry = "select id from $brandix_bts.bundle_creation_data where style='".$key1."' and schedule='".$key."' and input_job_no in ($job_numbers) and bundle_qty_status=3 ";
			echo $bcd_qry."---";
			$bcd_qry_res=mysqli_query($link, $bcd_qry) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($bcd_qry_row=mysqli_fetch_array($bcd_qry_res))
			{
				$bcd_jobs[]=$bcd_qry_row['id'];
			}
			if(sizeof($bcd_jobs)>0)
			{
				$bcd_table_update="UPDATE $brandix_bts.bundle_creation_data SET bundle_qty_status=4 WHERE id in (".implode(",",$bcd_jobs).") and bundle_qty_status=3 ";
				// echo $bcd_table_update;
				echo " Executed_schedule-".$key."<br/>";
				$bcd_table_update_resultx=mysqli_query($link, $bcd_table_update) or exit("Sql Error144".mysqli_error($GLOBALS["___mysqli_ston"]));
				// die();
			}
			else
			{
				echo " Schedule_not_executed-".$key."<br/>";
			}
			unset($bcd_jobs);
		}
	}
	echo "Script Completed Successfully";
?>