<?php
    include('C:\xampp\htdocs\sfcs_app\common\config\config_jobs.php');
	set_time_limit(6000000);
	
	// $sql = "select * from $m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE sfcs_status IN (0,40) order by sfcs_tid*1 limit 500";
	$sql="select * FROM $m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE sfcs_status IN (0,40) ORDER BY sfcs_tid*1 LIMIT 500";
	$sql_result=mysqli_query($link, $sql) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($sql_result))
	{
		$sql3="select  * FROM $bai_pro3.bai_orders_db WHERE order_del_no=".$row["sfcs_schedule"]." and order_col_des='".$row["sfcs_color"]."' and order_s_".$row["sfcs_size"].">0 ";	
		// echo $sql3;
		$sql_result3=mysqli_query($link, $sql3) or die("Sql Error00423".mysqli_error($GLOBALS["___mysqli_ston"]));

		if(mysqli_num_rows($sql_result3) > 0)
		{
			while($sql_row3=mysqli_fetch_array($sql_result3))
			{
				$sizecode=$sql_row3['title_size_'.$row["sfcs_size"].''];
			}
			$sizecode_ref=$sizecode;
		}
		else
		{
			$sizecode_ref=$row["sfcs_size"];
		}
		
		$sql1="select * from $bai_pro3.schedule_oprations_master where ScheduleNumber='".$row["sfcs_schedule"]."' and Description='".$row["sfcs_color"]."' and SizeId='".$sizecode_ref."' and OperationNumber='".$row["m3_op_code"]."'";
		// echo $sql1."<br>";
		$sql_result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row1=mysqli_fetch_array($sql_result1))
		{
			$sql2 = "UPDATE $m3_bulk_ops_rep_db.m3_sfcs_tran_log SET m3_mo_no='".$row1["MONumber"]."',work_centre='".$row1["WorkCenterId"]."',m3_size='".$sizecode."' WHERE sfcs_tid='".$row["sfcs_tid"]."'";
			// echo $sql2."<br>";
			mysqli_query($link, $sql2) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
		}			
	}
?>
