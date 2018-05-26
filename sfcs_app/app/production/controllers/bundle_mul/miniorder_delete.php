<?php
$global_path = getFullURLLevel($_GET['r'],'',4,'R');

include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'dbconf.php',0,'R'));
include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/user_acl_v1.php");

$mini_order_ref=$_GET['mini_order_ref'];
if($_GET['ops']==1)
{
	$sql="insert ignore into $brandix_bts.tbl_miniorder_data_deleted select * from brandix_bts.tbl_miniorder_data where mini_order_ref='".$mini_order_ref."'";
	// echo $sql."<br>";
	$result=mysqli_query($link, $sql) or exit("Sql Error123456".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql11="select count(*) from $brandix_bts.tbl_miniorder_data where mini_order_ref='".$mini_order_ref."'";
	$result11=mysqli_query($link, $sql11) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($result11)>0)
	{
		$sql1="delete from $brandix_bts_uat.view_set_snap_1_tbl where tbl_miniorder_data_bundle_number in (select bundle_number from brandix_bts.tbl_miniorder_data where mini_order_ref='".$mini_order_ref."')";
		mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql2="delete from $brandix_bts_uat.view_set_1_snap where bundle_transactions_20_repeat_bundle_id in (select bundle_number from brandix_bts.tbl_miniorder_data where mini_order_ref='".$mini_order_ref."')";
		mysqli_query($link, $sql2) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql3="delete from $brandix_bts_uat.bundle_transactions_20_repeat_virtual_snap_ini_bundles where bundle_barcode in (select bundle_number from brandix_bts.tbl_miniorder_data where mini_order_ref='".$mini_order_ref."')";
		mysqli_query($link, $sql3) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql3="delete from $brandix_bts_uat.view_set_3_snap where tbl_miniorder_data_bundle_number in (select bundle_number from brandix_bts.tbl_miniorder_data where mini_order_ref='".$mini_order_ref."')";
		mysqli_query($link, $sql3) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql1="delete from $brandix_bts.tbl_miniorder_data where mini_order_ref='".$mini_order_ref."'";
		//echo $sql1."<br>";
		mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
}
$url1 = getFullUrl($_GET['r'],'mini_order_deletion.php','N');
header("Location:$url1&deleted=yes");
?>