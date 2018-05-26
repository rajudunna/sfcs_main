<?php

function surplus_auto_correct($location_ref,$conn)
{
	$location_allocated_qty=0;
	$location_id=$location_ref;
	$link=$conn;

	$sql1="select location_id from bai_pro3.bai_qms_db where location_id=\"".$location_id."\" order by qms_schedule,qms_color,qms_size";
	//echo $sql1."-".$link;
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rows_count1=mysqli_num_rows($sql_result1);
	if($rows_count1 > 0)
	{
		$sql="select sum(qms_qty) as qms_qty,group_concat(qms_tid) as qms_tid from ".bai_pro3.".bai_qms_db where location_id=\"".$location_id."\"";
		//echo $sql."-".$link;
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$sql2="select COALESCE(SUM(qms_qty),0) as qty from ".bai_pro3.".bai_qms_db where ref1 in (".$sql_row['qms_tid'].") and qms_tran_type in (12,13)";
			//echo $sql2."<br>";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$resr_qty=$sql_row2["qty"];
			}
			$location_allocated_qty=$location_allocated_qty+($sql_row['qms_qty']-$resr_qty);
		}
		
		$sql_update="update bai_pro3.bai_qms_location_db SET qms_cur_qty=".$location_allocated_qty." where qms_location_id=\"".$location_id."\"";
		//echo $sql_update."<br>";
		mysqli_query($link, $sql_update) or exit("Sql Error Update=".$sql_update."-".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	else
	{
		$sql_update="update bai_pro3.bai_qms_location_db SET qms_cur_qty=0 where qms_location_id=\"".$location_id."\"";
		//echo $sql_update."<br>";
		mysqli_query($link, $sql_update) or exit("Sql Error Update=".$sql_update."-".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
}

?>
