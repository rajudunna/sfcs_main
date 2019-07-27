<?php 
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');

$conn = odbc_connect("$promis_sql_driver_name;Server=$promis_sql_odbc_server;Database=$promis_db;", $promis_sql_odbc_user,$promis_sql_odbc_pass);

$get_sewing_details = "SELECT input_job_no,sum(carton_act_qty) as qty,size_code,input_job_no_random,doc_no,type_of_sewing from $bai_pro3.pac_stat_log_input_job where input_job_no_random not in (select input_job_no_random from $bai_pro3.job_pro_track) group by input_job_no_random";
$result1=mysqli_query($link, $get_sewing_details) or die ("Error1.1=".$get_sewing_details.mysqli_error($GLOBALS["___mysqli_ston"]));
while($row1=mysqli_fetch_array($result1))
{
    $input_job = $row1['input_job_no_random'];
    $job_no = $row1['input_job_no'];
    $quantity = $row1['qty'];
    $size = $row1['size_code'];
    $docket = $row1['doc_no'];
    $type = $row1['type_of_sewing'];

    if($type == 2)
    {
       $sewing_type ='1';
    }
	else
    {
       $sewing_type ='0';
    }

    $get_details = "select order_style_no,order_del_no,order_col_des from $bai_pro3.order_cat_doc_mix where doc_no = '$docket'";
    //echo $get_details;
    $result_checking_qry = $link->query($get_details);
	while($row2 = $result_checking_qry->fetch_assoc()) 
	{
		$style = $row2['order_style_no'];
		$schedule = $row2['order_del_no'];
		$color = $row2['order_col_des'];
	}
	$get_co_details = "select co_no from $bai_pro3.bai_orders_db_confirm where order_del_no='$schedule' limit 1";
	$result_co_details = $link->query($get_co_details);
	while($row4 = $result_co_details->fetch_assoc())
	{
       $co_no = $row4['co_no'];
	}
	$get_planning_details = "select input_module,log_time from $bai_pro3.plan_dashboard_input where input_job_no_random_ref='$input_job'";
	// echo $get_planning_details;
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
		$get_planning_details1 = "select input_module,log_time from $bai_pro3.plan_dashboard_input_backup where input_job_no_random_ref='$input_job' limit 1";
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
			$log_time=' ';
		}
	}
	
	//color column length is 15 so we are trimming
    $color1 = substr($color,13);


	$inserting_qry = "INSERT INTO [$promis_db].[dbo].[ProMIS_SX_SJ_Master](MRNNo,
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
     Manual_Flag,
     Freez_Flag,
     Sew_Line,
     Plan_Date2) values('".$job_no."','".$co_no."','".$schedule."','".$color1."','".$size."','1','".$color."','".$size."','".$quantity."','".$module."','".$log_time."','".$sewing_type."','1','NULL',NULL)";
      // echo $inserting_qry;
      // die();
	odbc_exec($conn, $inserting_qry);	
	
	$sql1221="INSERT INTO `bai_pro3`.`job_pro_track` (`input_job_no_random`, `log_time`) VALUES ('".$input_job."', '".date('Y-m-d H:i:s')."')";
	$link->query($sql1221);

}	



$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.")."\n";

?>

