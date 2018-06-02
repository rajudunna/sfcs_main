
<?php
include("dbconf.php");

/*
	$myFile = "sesssion_track_new.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "<?php $"."current_session='on'; ?>";
	fwrite($fh, $stringData);
*/

	$sql="update snap_session_track set session_status='on'  where session_id=1";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));


/*

CREATE  TABLE brandix_bts_uat.$view_set_1_snap ENGINE = MYISAM SELECT * FROM brandix_bts_uat.view_set_1;
index bundle_transactions_20_repeat_bundle_id

CREATE  TABLE brandix_bts_uat.$view_set_2_snap ENGINE = MYISAM SELECT * FROM brandix_bts_uat.view_set_2;
inde order id

CREATE  TABLE brandix_bts_uat.$view_set_3_snap ENGINE = MYISAM SELECT * FROM brandix_bts_uat.view_set_3;

tbl_miniorder_data_bundle_number, order_id

CREATE  TABLE brandix_bts_uat.$view_set_4_snap ENGINE = MYISAM SELECT * FROM brandix_bts_uat.view_set_4;

CREATE  TABLE brandix_bts_uat.$view_set_5_snap ENGINE = MYISAM SELECT * FROM brandix_bts_uat.view_set_5;

CREATE  TABLE brandix_bts_uat.$view_set_6_snap ENGINE = MYISAM SELECT * FROM brandix_bts_uat.view_set_6;

CREATE  TABLE brandix_bts_uat.$view_set_snap_1_tbl ENGINE = MYISAM SELECT * FROM brandix_bts_uat.view_set_snap_1;
 indie tbl_orders_master_product_schedule, tbl_orders_style_ref_product_style 
 
 */



//empty tables
$sql="truncate table $view_set_1_snap";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="truncate table $view_set_2_snap";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="truncate table $view_set_3_snap";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));


$sql="truncate table $view_set_4_snap";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));


$sql="truncate table $view_set_5_snap";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));


$sql="truncate table $view_set_6_snap";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));


$sql="truncate table $view_set_snap_1_tbl";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));


$sql="truncate table bundle_transactions_20_repeat_virtual_snap_ini_bundles";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

//Transfer data from views to table.


 
$sql="insert into $view_set_1_snap select * from view_set_1";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

//Virtual table to dumple bundle level info
//$sql="insert into bundle_transactions_20_repeat_virtual_snap_ini_bundles SELECT  @s:=@s+1 id,1 AS parent_id,bundle_number AS bundle_barcode,SUM(quantity) AS quantity,bundle_number AS bundle_id,5 AS operation_id,0 AS rejection_qty, 0 AS act_module FROM tbl_miniorder_data,(SELECT @s:=MAX(id) FROM `bundle_transactions_20_repeat`) AS s GROUP BY bundle_number";
$sql="insert into bundle_transactions_20_repeat_virtual_snap_ini_bundles SELECT  @s:=@s+1 id,1 AS parent_id,bundle_number AS bundle_barcode,quantity,bundle_number AS bundle_id,5 AS operation_id,0 AS rejection_qty, 0 AS act_module FROM tbl_miniorder_data,(SELECT @s:=MAX(id) FROM `bundle_transactions_20_repeat`) AS s";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="insert into $view_set_1_snap select * from view_set_1_virtual";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

//Virtual table to dumple bundle level info

$sql="insert into $view_set_2_snap select * from view_set_2";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="insert into $view_set_3_snap select * from view_set_3";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));


$sql="insert into $view_set_4_snap select * from view_set_4";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));


$sql="insert into $view_set_5_snap select * from view_set_5";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));


$sql="insert into $view_set_6_snap select * from view_set_6";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));


$sql="insert into $view_set_snap_1_tbl select * from view_set_snap_1";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));


$sql="update snap_session_track set session_status='off' where session_id=1";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

/*	
	$stringData = "<?php $"."current_session='off'; ?>";
	fwrite($fh, $stringData);
	fclose($fh);
*/

echo "Successfully Dumped";

//header("Location: production_daily_kpi.php?snap_ids=1");

echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
?>
