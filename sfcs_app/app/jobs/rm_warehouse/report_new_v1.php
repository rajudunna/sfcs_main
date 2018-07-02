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
		var data = $('#table1').table2CSV({delivery: 'value',filename: 'report.csv'});
        downloadFile('report.csv', 'data:text/csv;charset=UTF-8,' + encodeURIComponent(data));

	}
</script>
 
</head>
<body>

<div class="panel panel-primary">
<div class="panel-heading">Stock Report</div>
<div class="panel-body">
<?php
echo "<h3><span class='label label-primary'>LU:".date("Y-m-d H-i-s")."</span></h3>";



// echo '<form action="report_new_excel_v2.php" method ="post" > 
// <input type="submit" value="Export to Excel">
// </form>';
echo "<form action='report_new_excel_v2.php' method ='post' > 
		<input type='hidden' id='csv_text' ><br/><br/>
      <input class='btn btn-xs btn-primary' value='Export to excel' type='button' onclick='getCSVData()'><br/>";
?>

<?php

$data='<div class="table-responsive"><table align="left" class="table table-bordered"><table id="table1" class="table table-bordered"><tr><th style="text-align:  center;">Location</th><th style="text-align:  center;">Lot No</th><th style="text-align:  center;">Batch No</th><th style="text-align:  center;">SKU</th><th style="text-align:  center;">Item Description</th><th style="text-align:  center;">Item Name</th><th style="text-align:  center;">Box/Roll No</th><th style="text-align:  center;">Measured Width</th>
<th style="text-align:  center;">Received Qty</th><th style="text-align:  center;">Issued Qty</th><th style="text-align:  center;">Return Qty</th>
<th style="text-align:  center;">Balance Qty</th><th style="text-align:  center;">Shade</th><th style="text-align:  center;">Invoice</th><th style="text-align:  center;">Status</th><th style="text-align:  center;">GRN Date</th><th style="text-align:  center;">Remarks</th><th style="text-align:  center;">Label Id</th><th style="text-align:  center;">Product Group</th><th style="text-align:  center;">Buyer</th><th style="text-align:  center;">Supplier</th></tr>';;


	$sql1="select * from $bai_rm_pj1.stock_report";
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
		$sql_result1x=mysqli_query($link, $sql1x) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($sql_result1x))
		{
			$shade=$row["ref4"];
			$invoice=$row["inv_no"];
		}
	
	$data.="<tr><td>$location</td><td>$lot_no</td><td>$batch_no</td><td>$item</td><td>$item_desc</td><td>$item_name</td><td>$boxno</td><td>$ref3</td><td>$qty_rec</td><td>$qty_issued</td><td>$qty_return</td><td>$qty_balance</td>";
	

	$data.="<td>$shade</td><td>$invoice</td><td>$status</td><td>$grn_date</td><td>$remarks</td><td>$tid</td><td>$product</td><td>$buyer</td><td>$supplier</td>";

	$data.="</tr>";

}
$data.='</table>';
echo $data;
?>

<?php
$cachefile = $path."/warehouse/reports/".$cache_date.'.html';
// $cachefile = $cache_date.".html";
// open the cache file "cache/home.html" for writing
$fp = fopen($cachefile, 'w');
// save the contents of output buffer to the file
fwrite($fp, ob_get_contents());
// close the file
fclose($fp);
// Send the output to the browser
ob_end_flush();
$myFile = $path."/warehouse/reports/stock_report_source.php";

$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = "<?php $"."data=\"".str_replace("'","\"",str_replace('"','\"',$data))."\"; ?>";
fwrite($fh, $stringData);
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
echo "Execution took ".$duration." Seconds.";
?>
</div></div>
</body>
</html>