<?php
error_reporting(0);
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
set_time_limit(1000000);
if($_GET['plantCode']){
	$plant_code = $_GET['plantCode'];
}else{
	$plant_code = $argv[1];
}
$username=$_SESSION['userName'];
$sql39="truncate $wms.stock_report_inventory";
mysqli_query($link, $sql39) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));

//For #2711 ticket new column(roll_remarks) added in view bai_rm_pj1.stock_report.
//And one column(roll_remarks) altered in stock_report_innventory table.

// $stock_report="insert into $wms.stock_report_inventory (`ref1`, `lot_no`, `batch_no`, `item_desc`, `item_name`, `item`, `supplier`, `buyer`, `style_no`, `ref2`, `ref3`, `pkg_no`, `status`, `grn_date`, `remarks`, `tid`, `qty_rec`, `qty_issued`, `qty_ret`, `balance`, `product_group`,`roll_remarks`) select `ref1`, `lot_no`, `batch_no`, `item_desc`, `item_name`, `item`, `supplier`, `buyer`, `style_no`, `ref2`, `ref3`, `pkg_no`, `status`, `grn_date`, `remarks`, `tid`, `qty_rec`, `qty_issued`, `qty_ret`, `balance`, `product_group`, `roll_remarks` from $wms.stock_report";

$stock_report="SELECT store_in.ref1,store_in.lot_no,store_in.ref2,store_in.ref3,store_in.status,store_in.remarks,store_in.tid,store_in.qty_rec,store_in.qty_issued,store_in.qty_ret,store_in.qty_allocated,ROUND(ROUND(store_in.qty_rec,2)-ROUND(store_in.qty_issued,2)+ROUND(store_in.qty_ret,2)-ROUND(store_in.qty_allocated,2)) AS balance,store_in.log_stamp,store_in.roll_remarks,sticker_report.batch_no,sticker_report.item_desc,sticker_report.item_name,sticker_report.item,sticker_report.supplier,sticker_report.buyer,sticker_report.style_no,sticker_report.pkg_no,sticker_report.grn_date,sticker_report.product_group,store_in.plant_code FROM $wms.store_in LEFT JOIN $wms.sticker_report ON store_in.lot_no=sticker_report.lot_no WHERE (ROUND(store_in.qty_rec,2)-ROUND(store_in.qty_issued,2)+ROUND(store_in.qty_ret,2)) >0";
$stock_report_result =$link->query($stock_report);
while ($sql_row1 = $stock_report_result->fetch_assoc())
{
	$ref1=$sql_row1['ref1'];
	$lot_no=$sql_row1['lot_no'];
	$ref2=$sql_row1['ref2'];
	$ref3=$sql_row1['ref3'];
	$status=$sql_row1['status'];
	$remarks=$sql_row1['remarks'];
	$tid=$sql_row1['tid'];
	$qty_rec=$sql_row1['qty_rec'];
	$qty_issued=$sql_row1['qty_issued'];
	$qty_ret=$sql_row1['qty_ret'];
	$qty_allocated=$sql_row1['qty_allocated'];
	$balance=$sql_row1['balance'];
	$log_stamp=$sql_row1['log_stamp'];
	$roll_remarks=$sql_row1['roll_remarks'];
	$batch_no=$sql_row1['batch_no'];
	$qty_issued=$sql_row1['qty_issued'];
	$item_desc=$sql_row1['item_desc'];
	$item_name=$sql_row1['item_name'];
	$item=$sql_row1['item'];
	$supplier=$sql_row1['supplier'];
	$buyer=$sql_row1['buyer'];
	$style_no=$sql_row1['style_no'];
	$pkg_no=$sql_row1['pkg_no'];
	$grn_date=$sql_row1['grn_date'];
	$product_group=$sql_row1['product_group'];
	$plant_code=$sql_row1['plant_code'];

	if($balance!=''){
		$balance=$balance;
	}else{
		$balance='0';
	}

	$sql="insert into $wms.stock_report_inventory(`ref1`, `lot_no`, `batch_no`, `item_desc`, `item_name`, `item`, `supplier`, `buyer`, `style_no`, `ref2`, `ref3`, `pkg_no`, `status`, `grn_date`, `remarks`, `tid`, `qty_rec`, `qty_issued`, `qty_ret`, `balance`, `product_group`,`roll_remarks`,`plant_code`,created_at,created_user) values('".$ref1."','".$lot_no."','".$batch_no."','".$item_desc."','".$item_name."','".$item."','".$supplier."','".$buyer."','".$style_no."','".$ref2."','".$ref3."','".$pkg_no."','".$status."','".$grn_date."','".$remarks."','".$tid."','".$qty_rec."','".$qty_issued."','".$qty_ret."','".$balance."','".$product_group."','".$roll_remarks."','".$plant_code."',NOW(),'".$username."')";

	mysqli_query($link, $sql) or exit("Sql Error4: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));

}
// if($res)
// {
// 	print("Data Inserted into stock_report_inventory from stock_report ")."\n";
// }
print( memory_get_usage())."\n";
	
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>