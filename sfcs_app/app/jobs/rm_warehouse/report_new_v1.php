<!DOCTYPE html>
<html>

<head>
<?php
$start_timestamp = microtime(true);
set_time_limit(90000);
error_reporting(0);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');

$cache_date="report_new";

ob_start();

?>


 <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  
  
  <title>BEK RM Stock Report</title>
  
<style>
/* body
{
	font-family:calibri;
	font-size:12px;
}

table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align: right;
white-space:nowrap; 
}

table td.lef
{
	border: 1px solid black;
	text-align: left;
white-space:nowrap; 
}
table th
{
	border: 1px solid black;
	text-align: center;
    	background-color: BLUE;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
}


}

} */
th
{
	white-space: nowrap;
}
</style>

<script type="text/javascript" src="/sfcs_app/common/js/jquery.min.js" ></script>

<script type="text/javascript" src="/sfcs_app/common/js/table2CSV.js" ></script>

<script>
	function downloadFile(fileName, urlData) {
	    var aLink = document.createElement('a');
	    aLink.download = fileName;
	    aLink.href = urlData;
	    var event = new MouseEvent('click');
	    aLink.dispatchEvent(event);
	   }
	function getCSVData() {
		var data = $('#table1').table2CSV({delivery: 'value',filename: 'stock_report.csv'});
        downloadFile('stock_report.csv', 'data:text/csv;charset=UTF-8,' + encodeURIComponent(data));

	}
</script>
 
</head>
<body>

<div class="panel panel-primary">
<div class="panel-heading">Stock Report</div>
<div class="panel-body">
<?php
echo "<h3><span class='label label-primary'>LU:".date("Y-m-d H-i-s")."</span></h3>";
?>

<?php

$data="LU:".date("Y-m-d H-i-s");

$title_list = array("Location","Lot No","Style No","Batch No","SKU","Item Description","Item Name","Box/Roll No","Measured Width","Received Qty","Issued Qty","Return Qty","Balance Qty","Shade","Invoice","Status","GRN Date","Remarks","Label Id","Product Group","Buyer","Supplier");

$file_name="stock_report.csv";
$file = fopen($file_name,"w");

fputcsv($file,$title_list);

$sql1="select * from $bai_rm_pj1.stock_report";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check1=mysqli_num_rows($sql_result1);
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$values=array();
	$lot_no=trim($sql_row1['lot_no']);
	$qty_rec=$sql_row1['qty_rec'];
	$qty_issued=$sql_row1['qty_issued'];
	$qty_return=$sql_row1['qty_ret'];
	$style_no=$sql_row1['style_no'];
	$qty_balance=$sql_row1['balance'];
	$status=trim($sql_row1['status']);
	$location=trim($sql_row1['ref1']);
	$boxno=trim($sql_row1['ref2']);
	$tid=$sql_row1['tid'];
	
	$item=trim($sql_row1['item']);
	$ref3=trim($sql_row1['ref3']);


	$item_name=trim(str_replace('"',"",$sql_row1['item_name']));
	$item_name=trim(str_replace("'","",$item_name));
	$item_desc=trim(str_replace('"',"",$sql_row1['item_desc']));

	$batch_no=trim($sql_row1['batch_no']);

	$pkg_no=trim($sql_row1['pkg_no']);
	$remarks=trim($sql_row1['remarks']);
	$grn_date=$sql_row1['grn_date'];
	$tid=$sql_row1['tid'];
	$product=$sql_row1['product_group'];
	$supplier=$sql_row1['supplier'];
	$buyer=$sql_row1['buyer'];
	
	$sql1x="select ref4,inv_no from $bai_rm_pj1.sticker_ref where tid=$tid";
	$sql_result1x=mysqli_query($link, $sql1x) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($sql_result1x))
	{
		$shade=$row["ref4"];
		$invoice=$row["inv_no"];
	}
	
	$values[]=$location;
	$values[]=$lot_no;
	$values[]=$style_no;
	$values[]=$batch_no;
	$values[]=$item;
	$values[]=$item_desc;
	$values[]=$item_name;
	$values[]=$boxno;
	$values[]=$ref3;
	$values[]=$qty_rec;
	$values[]=$qty_issued;
	$values[]=$qty_return;
	$values[]=$qty_balance;
	$values[]=$shade;
	$values[]=$invoice;
	$values[]=$status;
	$values[]=$grn_date;
	$values[]=$remarks;
	$values[]=$tid;
	$values[]=$product;
	$values[]=$buyer;
	$values[]=$supplier;

	fputcsv($file,$values);
	unset($values);

}
fclose($file);	
// echo $data;

$myFile = "stock_report_source.php";
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = "<?php $"."data=\"".str_replace("'","\"",str_replace('"','\"',$data))."\"; ?>";
fwrite($fh, $stringData);

?>
</div></div>
</body>
</html>