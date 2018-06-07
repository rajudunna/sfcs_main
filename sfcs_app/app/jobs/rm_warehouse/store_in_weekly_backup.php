

<?php
$start_timestamp = microtime(true);
set_time_limit(90000);
error_reporting(0);
include('C:\xampp\htdocs\sfcs_main\sfcs_app\common\config\config_jobs.php');

$sql="select * FROM bai_rm_pj1.store_in_weekly_backup WHERE SUBSTRING_INDEX(sticker_qty,\".\",1)=SUBSTRING_INDEX(grn_qty,\".\",1)";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$lot_no=$sql_row['lot_no'];
	$check1=0;
	$check2=0;
	
	$sql1="insert ignore into bai_rm_pj1.store_in_backup select * from bai_rm_pj1.store_in where lot_no=\"$lot_no\"";
	// echo $sql1."<br/>";
	mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_affected_rows($link)>0) {
		$check1=1;

	}
	
	$sql1="insert ignore into bai_rm_pj1.store_out_backup select * from bai_rm_pj1.store_out where tran_tid in (select tid from bai_rm_pj1.store_in where lot_no=\"$lot_no\")";
	mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_affected_rows($link)>0){
		$check2=1;
	}
	
	if($check1==1 and $check2==1)
	{
		$sql1="delete from bai_rm_pj1.store_out where tran_tid in (select tid from bai_rm_pj1.store_in where lot_no=\"$lot_no\")";
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql1="delete from bai_rm_pj1.store_in where lot_no=\"$lot_no\"";
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql1="update bai_rm_pj1.sticker_report set backup_status=1 where lot_no=\"$lot_no\"";
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
}
print('job Completed Successfully')."\n";
	
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." Seconds.");
	
	?>
