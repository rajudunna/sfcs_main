<?php

if(isset($_POST['export']))
{
	include("../".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	
	$location=$_POST['loc'];
	$filename ="$location"."_StockRecon2012.xls";
	$contents = "<h2>Stock Report: $location</h2>";
	$contents.="<table border=1><tr><th>Label ID</th><th>Roll No</th><th>Qty</th><th>Lot #</th><th>Item Description</th><th>Item Name</th><th>Supplier</th></tr>";
	$sql1="select * from $bai_rm_pj1.stock_report where ref1='$location'";
	mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check1=mysqli_num_rows($sql_result1);
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$lot_no=trim($sql_row1['lot_no']);
		$qty_rec=$sql_row1['qty_rec'];
		$qty_issued=$sql_row1['qty_issued'];
		$qty_return=$sql_row1['qty_ret'];
		$qty_balance=$sql_row1['balance'];
		$status=trim($sql_row1['status']);
		$location=trim($sql_row1['ref1']);
		$boxno=trim($sql_row1['ref2']);
		$tid=$sql_row1['tid'];
		$item=trim($sql_row1['item']);
		$ref3=trim($sql_row1['ref3']);
		$item_name=trim($sql_row1['item_name']);
		$item_desc=trim($sql_row1['item_desc']);
		$batch_no=trim($sql_row1['batch_no']);
		$pkg_no=trim($sql_row1['pkg_no']);
		$remarks=trim($sql_row1['remarks']);
		$grn_date=$sql_row1['grn_date'];
		$tid=$sql_row1['tid'];
		$product=$sql_row1['product_group'];
		$supplier=$sql_row1['supplier'];
		$buyer=$sql_row1['buyer'];
		$contents.="<tr><td>$tid</td><td>$boxno</td><td>$qty_balance</td><td>$lot_no</td><td>$item_desc</td><td>$item_name</td><td>$supplier</td>";
		$contents.="</tr>";
	}
	$contents.='</table>';
	header("Content-type: application/x-msdownload"); 
	//header("Content-type: application/x-msexcel"); 
	# replace excelfile.xls with whatever you want the filename to default to
	header("Content-Disposition: attachment; filename=Stock_Recon_2012_".$location.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	echo $contents;
}
else
{
	if($_GET['file_name'] != '') {
		$file_name = $_GET['file_name'];
	}
	else {
		$file_name = 'GRN_TO_Production_Pending_Report';
	}
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=\"".$file_name.".csv\"");
	$data=stripcslashes($_REQUEST['csv_text']);
	echo $data; 
}
?>