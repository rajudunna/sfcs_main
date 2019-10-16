<?php
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
set_time_limit(1000000);
$sql39="truncate $bai_rm_pj1.stock_report_inventory";
mysqli_query($link, $sql39) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));

//For #2711 ticket new column(roll_remarks) added in view bai_rm_pj1.stock_report.
//And one column(roll_remarks) altered in stock_report_innventory table.

$stock_report="insert into $bai_rm_pj1.stock_report_inventory (`ref1`, `lot_no`, `batch_no`, `item_desc`, `item_name`, `item`, `supplier`, `buyer`, `style_no`, `ref2`, `ref3`, `pkg_no`, `status`, `grn_date`, `remarks`, `tid`, `qty_rec`, `qty_issued`, `qty_ret`, `balance`, `product_group`,`roll_remarks`) select `ref1`, `lot_no`, `batch_no`, `item_desc`, `item_name`, `item`, `supplier`, `buyer`, `style_no`, `ref2`, `ref3`, `pkg_no`, `status`, `grn_date`, `remarks`, `tid`, `qty_rec`, `qty_issued`, `qty_ret`, `balance`, `product_group`, `roll_remarks` from $bai_rm_pj1.stock_report";
$res=mysqli_query($link, $stock_report) or exit("Sql Errorb".mysqli_error($GLOBALS["___mysqli_ston"]));
if($res)
{
	print("Data Inserted into stock_report_inventory from stock_report ")."\n";
}
print( memory_get_usage())."\n";
	
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>