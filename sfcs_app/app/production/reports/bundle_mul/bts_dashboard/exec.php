<?php
include("dbconf.php");
?>


<?php
					
$sql11="select * FROM brandix_bts.view_set_1 where bundle_transactions_20_repeat_operation_id='4' and bundle_transactions_20_repeat_rejection_quantity>0 and date(bundle_transactions_date_time)='".date("y-m-d")."'";
$resutlt11=mysqli_query($link, $sql11) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row11=mysqli_fetch_array($resutlt11))
{
	$var_sync_rep_id=$row11['bundle_transactions_20_repeat_id'];
	$var_sycn_operation_id=$row11['bundle_transactions_20_repeat_operation_id'];
	$sql1="UPDATE brandix_bts_uat.view_set_1_snap SET bundle_transactions_20_repeat_quantity='".$row11['bundle_transactions_20_repeat_quantity']."',bundle_transactions_20_repeat_rejection_quantity='".$row11['bundle_transactions_20_repeat_rejection_quantity']."' where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
	echo $sql1."<br>";
	mysqli_query($link, $sql1) or exit("Sql Error24".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql1="UPDATE brandix_bts_uat.view_set_snap_1_tbl SET bundle_transactions_20_repeat_quantity='".$row11['bundle_transactions_20_repeat_quantity']."',bundle_transactions_20_repeat_rejection_quantity='".$row11['bundle_transactions_20_repeat_rejection_quantity']."' where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
	mysqli_query($link, $sql1) or exit("Sql Error25".mysqli_error($GLOBALS["___mysqli_ston"]));
	echo $sql1."<br>";
}					

//echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";


?>