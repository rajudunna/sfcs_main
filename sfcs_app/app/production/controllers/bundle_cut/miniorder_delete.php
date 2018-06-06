<?php
// include("dbconf.php");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));

$mini_order_ref=$_GET['mini_order_ref'];
$schedule=$_GET['sch'];
//$schedule = echo_title("brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
$sch_check="J".$schedule;
$check_club = echo_title("$bai_pro3.bai_orders_db_confirm","count(*)","order_joins",$sch_check,$link);
if($check_club>0)
{
	//$doc_id=$_GET['doc_no'];
	$table_name="$bai_pro3.plandoc_stat_log";

	$sql11="select * from $table_name where order_tid like '%".$schedule."%'";
	//echo $sql11."<br>";
	$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($sql_result11))
	{
		$doc_no_tmp[]=$row1['doc_no'];
	}
	$sql11="select * from $table_name where org_doc_no in (".implode(",",$doc_no_tmp).")";
	//echo $sql11."<br>";
	$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($sql_result11))
	{
		$doc_no[]=$row1['doc_no'];
	}
	$sql11="select * from `$m3_bulk_ops_rep_db`.`m3_sfcs_tran_log` where m3_op_des='MRN_RE01' and sfcs_doc_no in ('".implode(",",$doc_no)."')";
	//echo $sql11."<br>";
	$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rows=mysqli_num_rows($sql_result11);
	$sql12="select * from `$brandix_bts`.`tbl_miniorder_data` where mini_order_status='1' and docket_number in ('".implode(",",$doc_no)."')";
	$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rows1=mysqli_num_rows($sql_result12);
	if($rows==0 && $rows1==0)	
	{
		$sql="insert ignore into $brandix_bts.tbl_miniorder_data_deleted select * from brandix_bts.tbl_miniorder_data where docket_numnber in ('".implode(",",$doc_no)."')";
		//echo $sql."<br>";
		$result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql11="select count(*) from $brandix_bts.tbl_miniorder_data where docket_numnber in ('".implode(",",$doc_no)."')";
		$result11=mysqli_query($link, $sql11) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($result11)>0)
		{
			$sql1="delete from $brandix_bts_uat.view_set_snap_1_tbl where tbl_miniorder_data_bundle_number in (select bundle_number from brandix_bts.tbl_miniorder_data  where docket_numnber in ('".implode(",",$doc_no)."'))";
			mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql2="delete from $brandix_bts_uat.view_set_1_snap where bundle_transactions_20_repeat_bundle_id in (select bundle_number from brandix_bts.tbl_miniorder_data  where docket_numnber in ('".implode(",",$doc_no)."'))";
			mysqli_query($link, $sql2) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql3="delete from $brandix_bts_uat.bundle_transactions_20_repeat_virtual_snap_ini_bundles where bundle_barcode in (select bundle_number from brandix_bts.tbl_miniorder_data where docket_numnber in ('".implode(",",$doc_no)."'))";
			mysqli_query($link, $sql3) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql31="delete from $brandix_bts_uat.view_set_3_snap where tbl_miniorder_data_bundle_number in (select bundle_number from brandix_bts.tbl_miniorder_data where docket_numnber in ('".implode(",",$doc_no)."'))";
			mysqli_query($link, $sql31) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql11="delete from $brandix_bts.tbl_miniorder_data where docket_numnber in ('".implode(",",$doc_no)."'))";
			//echo $sql1."<br>";
			mysqli_query($link, $sql11) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}
	else
	{
		echo "<script>swal('Already MRN or Bundle ticket Printed','','warning');</script>";
	}
}
else
{
	$sql11="select * from `$m3_bulk_ops_rep_db`.`m3_sfcs_tran_log` where m3_op_des='MRN_RE01' and sfcs_schedule='".$schedule."'";
	//echo $sql11."<br>";
	$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rows=mysqli_num_rows($sql_result11);
	if($rows==0)
	{
		$sql="insert ignore into $brandix_bts.tbl_miniorder_data_deleted select * from brandix_bts.tbl_miniorder_data where mini_ordeR_ref='".$mini_order_ref."'";
		//echo $sql."<br>";
		$result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
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
	else
	{
		echo "<script>swal('Already MRN or Bundle ticket Printed','','warning');</script>";
	}
}
$url=getFullURLLevel($_GET['r'],'mini_order_deletion.php',0,'N');
header("Location:$url");
?>