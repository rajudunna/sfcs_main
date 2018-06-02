
<?php
include("dbconf.php");

include("session_check.php");

/*
$today=date("Y-m-d",strtotime("-1 day"));


$sql="SELECT DISTINCT bac_date FROM bai_pro.bai_log_buf WHERE bac_date<\"".date("Y-m-d")."\" ORDER BY bac_date DESC LIMIT 1";
mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
while($sql_row=mysql_fetch_array($sql_result))
{
	$today=$sql_row['bac_date'];
}
*/


?>

<html>
<head>
<style>
	<style>
body
{
	font-family:Arial;
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

table td.new
{
	background-color: BLUE;
	color: WHITE;
}

table{
	font-family:Arial;
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
}


h2
{
	font-family:Arial;
}
h1{
	font-family:Arial;
}
h3{
	font-family:Arial;
}
</style>

<style rel="stylesheet" type="text/css">
#div-1a {
 position:absolute;
 top:25px;
 right:0;
 width:auto;
float:right;
}
</style>
	

<script src="js/jquery.min1.7.1.js"></script>
<script src="ddtf.js"></script>



</head>
<body>

<?php


//UDFs

function know_bg_color($a,$b)
{
	$return="";
	if($b>=$a)
	{
		$return=" bgcolor=#90EE990 ";
	}
	else
	{
		
	}
	return $return;
}


//Filter Options
$filter_query="";
$title="Complete Factory Performance";
if(isset($_GET['style']))
{
	$filter_query.=' and tbl_orders_style_ref_product_style=\''.$_GET['style'].'\'';
	$title="Performance Report of Style : ".$_GET['style'];
}

if(isset($_GET['schedule']))
{
	$filter_query.=' and tbl_orders_master_product_schedule=\''.$_GET['schedule'].'\'';
	$title="Performance Report of Schedule : ".$_GET['schedule'];
}


echo "<span id=\"msg\"><center><br/><br/><br/><h1><font color=\"red\">Please wait while preparing report...</font></h1></center></span>";
	
	ob_end_flush();
	flush();
	usleep(10);
?>
<!-- <h1><?=$title;?></h1> -->



<?php
if($_GET['rep_format']==1)
{

$table_data="";
$table_data.="<h2>Color/Size Wise Performance Report</h2>";
$table_data.="<h3>$title</h3>";
$table_data.= "<table  id='table_format'>";
$table_data.= "<tr>";
$table_data.= "<th>Schedule</th>";
$table_data.= "<th>Color</th>";
$table_data.= "<th>Size</th>";
$table_data.= "<th>Order Quantity</th>";
$table_data.= "<th>Bundling</th>";
$table_data.="<th>Panel Send</th>";
$table_data.="<th>Panel Receive</th>";
$table_data.= "<th>Bundle Out</th>";
$table_data.= "<th>Line In</th>";
$table_data.= "<th>Line Out</th>";
$table_data.= "<th>Rejected</th>";
$table_data.= "<th>Line Out (A)</th>";
$table_data.= "<th>Line Out (B)</th>";
$table_data.= "<th>Production Status</th>";
$table_data.= "</tr>";
$sql="
SELECT 
tbl_orders_master_product_schedule,size_disp,tbl_miniorder_data_color,tbl_orders_style_ref_product_style,
AVG(tbl_orders_sizes_master_order_quantity) AS order_qty,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
SUM(IF(tbl_orders_ops_ref_operation_code='PS',bundle_transactions_20_repeat_quantity,0)) AS pan_send,
SUM(IF(tbl_orders_ops_ref_operation_code='PR',bundle_transactions_20_repeat_quantity,0)) AS pan_receive,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO' AND tbl_shifts_master_shift_name='A',bundle_transactions_20_repeat_quantity,0)) AS a_output,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_rejection_quantity,0)) AS rejected,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO' AND tbl_shifts_master_shift_name='B',bundle_transactions_20_repeat_quantity,0)) AS b_output
FROM $view_set_snap_1_tbl 
WHERE 1=1 AND tbl_orders_style_ref_product_style IS NOT NULL ".$filter_query." GROUP BY order_id order by tbl_orders_master_product_schedule,tbl_miniorder_data_color,size_disp";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$tbl_orders_master_product_schedule=$sql_row['tbl_orders_master_product_schedule'];	
	$size_disp=$sql_row['size_disp'];	
	$tbl_miniorder_data_color=$sql_row['tbl_miniorder_data_color'];	
	$tbl_orders_style_ref_product_style=$sql_row['tbl_orders_style_ref_product_style'];	
	$order_qty=$sql_row['order_qty'];	
	$output=$sql_row['output'];	
	$bundling=$sql_row['bundling'];	
	$bundleout=$sql_row['bundleout'];	
	$linein=$sql_row['linein'];	
	$a_output=$sql_row['a_output'];	
	$b_output=$sql_row['b_output'];
	$rejected=$sql_row['rejected'];
	$pan_send=$sql_row['pan_send'];
	$pan_receive=$sql_row['pan_receive'];
	$table_data.= "<tr>";
	$table_data.= "<td>$tbl_orders_master_product_schedule</td>";
	$table_data.= "<td>$tbl_miniorder_data_color</td>";
	$table_data.= "<td>$size_disp</td>";
	$table_data.= "<td>$order_qty</td>";
	$table_data.= "<td ".know_bg_color($order_qty,$bundling).">$bundling</td>";
	$table_data.= "<td ".know_bg_color($order_qty,$pan_send).">$pan_send</td>";
	$table_data.= "<td ".know_bg_color($order_qty,$pan_receive).">$pan_receive</td>";
	$table_data.= "<td ".know_bg_color($order_qty,$bundleout).">$bundleout</td>";
	$table_data.= "<td ".know_bg_color($order_qty,$linein).">$linein</td>";
	$table_data.= "<td ".know_bg_color($order_qty,$output).">$output</td>";
	$table_data.= "<td>$rejected</td>";
	$table_data.= "<td>$a_output</td>";
	$table_data.= "<td>$b_output</td>";
	
	$table_data.= "<td>".(($output+$rejected)>=$order_qty?"Completed":"Pending")."</td>";
	$table_data.= "</tr>";

}

$table_data.= "</table>";
echo $table_data;
$export_rep_name="Color_Size_Wise_Performance_Report_BAI_BTS_SFCS_REP_";
}
?>





<?php

if($_GET['rep_format']==2)
{
$table_data="";
$table_data.="<h2>Mini-Order Wise Performance Report</h2>";
$table_data.="<h3>$title</h3>";
$table_data.="<table id='table_format'>";
$table_data.="<tr>";
$table_data.="<th>Style</th>";
$table_data.="<th>Schedule</th>";
$table_data.="<th>Mini-Order Number</th>";
$table_data.="<th>Color</th>";
$table_data.="<th>Size</th>";
$table_data.="<th>Mini-Order Quantity</th>";
$table_data.="<th>Bundling</th>";
$table_data.="<th>Panel Send</th>";
$table_data.="<th>Panel Receive</th>";
$table_data.="<th>Bundle Out</th>";
$table_data.="<th>Line In</th>";
$table_data.="<th>Line Out</th>";
$table_data.="<th>Rejected</th>";
$table_data.="<th>Line Out (A)</th>";
$table_data.="<th>Line Out (B)</th>";
$table_data.="<th>Production Status</th>";
$table_data.="</tr>";
$sql="
SELECT 
tbl_orders_master_product_schedule,size_disp,tbl_miniorder_data_color,tbl_orders_style_ref_product_style,tbl_miniorder_data_mini_order_num,
SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
SUM(IF(tbl_orders_ops_ref_operation_code='PS',bundle_transactions_20_repeat_quantity,0)) AS pan_send,
SUM(IF(tbl_orders_ops_ref_operation_code='PR',bundle_transactions_20_repeat_quantity,0)) AS pan_receive,
SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO' AND tbl_shifts_master_shift_name='A',bundle_transactions_20_repeat_quantity,0)) AS a_output,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_rejection_quantity,0)) AS rejected,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO' AND tbl_shifts_master_shift_name='B',bundle_transactions_20_repeat_quantity,0)) AS b_output
FROM $view_set_snap_1_tbl 
WHERE 1=1 AND tbl_orders_style_ref_product_style IS NOT NULL ".$filter_query." GROUP BY tbl_orders_master_product_schedule,tbl_miniorder_data_mini_order_num,tbl_miniorder_data_color,size_disp order by tbl_miniorder_data_mini_order_num,tbl_miniorder_data_color,size_disp";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$tbl_orders_master_product_schedule=$sql_row['tbl_orders_master_product_schedule'];	
	$size_disp=$sql_row['size_disp'];	
	$tbl_miniorder_data_color=$sql_row['tbl_miniorder_data_color'];	
	$tbl_orders_style_ref_product_style=$sql_row['tbl_orders_style_ref_product_style'];	
	$order_qty=$sql_row['miniorderbundle'];	
	$output=$sql_row['output'];	
	$bundling=$sql_row['bundling'];	
	$bundleout=$sql_row['bundleout'];	
	$linein=$sql_row['linein'];	
	$a_output=$sql_row['a_output'];	
	$b_output=$sql_row['b_output'];
	$tbl_miniorder_data_mini_order_num=$sql_row['tbl_miniorder_data_mini_order_num'];
	$rejected=$sql_row['rejected'];
	$pan_send=$sql_row['pan_send'];
	$pan_receive=$sql_row['pan_receive'];


	$table_data.="<tr>";
	$table_data.="<td>$tbl_orders_style_ref_product_style</td>";
	$table_data.="<td>$tbl_orders_master_product_schedule</td>";
	$table_data.="<td>$tbl_miniorder_data_mini_order_num</td>";
	$table_data.="<td>$tbl_miniorder_data_color</td>";
	$table_data.="<td>$size_disp</td>";
	$table_data.="<td>$order_qty</td>";
	$table_data.="<td ".know_bg_color($order_qty,$bundling).">$bundling</td>";
	$table_data.="<td ".know_bg_color($order_qty,$pan_send).">$pan_send</td>";
	$table_data.="<td ".know_bg_color($order_qty,$pan_receive).">$pan_receive</td>";
	$table_data.="<td ".know_bg_color($order_qty,$bundleout).">$bundleout</td>";
	$table_data.="<td ".know_bg_color($order_qty,$linein).">$linein</td>";
	$table_data.="<td ".know_bg_color($order_qty,$output).">$output</td>";
	$table_data.="<td>$rejected</td>";
	$table_data.="<td>$a_output</td>";
	$table_data.="<td>$b_output</td>";
	
	$table_data.="<td>".(($output+$rejected)>=$order_qty?"Completed":"Pending")."</td>";
	$table_data.="</tr>";

}

$table_data.="</table>";
echo $table_data;
$export_rep_name="Mini-Order_Wise_Performance_Report_";
}
?>




<?php
if($_GET['rep_format']==3)
{
	$table_data="";
$table_data.="<h2>Bundle Wise Performance Report</h2>";
$table_data.="<h3>$title</h3>";
$table_data.="<table id='table_format'>";
$table_data.="<tr>";
$table_data.="<th>Schedule</th>";
$table_data.="<th>Mini-Order Number</th>";
$table_data.="<th>Bundle Number</th>";
$table_data.="<th>Color</th>";
$table_data.="<th>Size</th>";
$table_data.="<th>Module</th>";
$table_data.="<th>Bundle Quantity</th>";
$table_data.="<th>Bundling</th>";
$table_data.="<th>Panel Send</th>";
$table_data.="<th>Panel Receive</th>";
$table_data.="<th>Bundle Out</th>";
$table_data.="<th>Line In</th>";
$table_data.="<th>Line Out</th>";
$table_data.="<th>Rejected</th>";
$table_data.="<th>Line Out (A)</th>";
$table_data.="<th>Line Out (B)</th>";
$table_data.="<th>Production Status</th>";
$table_data.="</tr>";
$sql="
SELECT 
tbl_orders_master_product_schedule,size_disp,tbl_miniorder_data_color,tbl_orders_style_ref_product_style,tbl_miniorder_data_mini_order_num,tbl_miniorder_data_bundle_number,
SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
SUM(IF(tbl_orders_ops_ref_operation_code='PS',bundle_transactions_20_repeat_quantity,0)) AS pan_send,
SUM(IF(tbl_orders_ops_ref_operation_code='PR',bundle_transactions_20_repeat_quantity,0)) AS pan_receive,
SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO' AND tbl_shifts_master_shift_name='A',bundle_transactions_20_repeat_quantity,0)) AS a_output,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_rejection_quantity,0)) AS rejected,
max(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_module_id,0)) AS module,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO' AND tbl_shifts_master_shift_name='B',bundle_transactions_20_repeat_quantity,0)) AS b_output
FROM $view_set_snap_1_tbl 
WHERE 1=1 AND tbl_orders_style_ref_product_style IS NOT NULL ".$filter_query." GROUP BY tbl_orders_master_product_schedule,tbl_miniorder_data_mini_order_num,tbl_miniorder_data_bundle_number,
tbl_miniorder_data_color,size_disp order by tbl_orders_master_product_schedule,tbl_miniorder_data_mini_order_num,tbl_miniorder_data_bundle_number,tbl_miniorder_data_color,size_disp";
//echo $sql."<bR>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$tbl_orders_master_product_schedule=$sql_row['tbl_orders_master_product_schedule'];	
	$size_disp=$sql_row['size_disp'];	
	$tbl_miniorder_data_color=$sql_row['tbl_miniorder_data_color'];	
	$tbl_orders_style_ref_product_style=$sql_row['tbl_orders_style_ref_product_style'];	
	$order_qty=$sql_row['miniorderbundle'];	
	$module=$sql_row['module'];	
	$output=$sql_row['output'];	
	$bundling=$sql_row['bundling'];	
	$bundleout=$sql_row['bundleout'];	
	$linein=$sql_row['linein'];	
	$a_output=$sql_row['a_output'];	
	$b_output=$sql_row['b_output'];
	$tbl_miniorder_data_mini_order_num=$sql_row['tbl_miniorder_data_mini_order_num'];
	$tbl_miniorder_data_bundle_number=$sql_row['tbl_miniorder_data_bundle_number'];
	$rejected=$sql_row['rejected'];
	$pan_send=$sql_row['pan_send'];
	$pan_receive=$sql_row['pan_receive'];
	
	$table_data.="<tr>";
	$table_data.="<td>$tbl_orders_master_product_schedule</td>";
	$table_data.="<td>$tbl_miniorder_data_mini_order_num</td>";
	$table_data.="<td>$tbl_miniorder_data_bundle_number</td>";
	$table_data.="<td>$tbl_miniorder_data_color</td>";
	$table_data.="<td>$size_disp</td>";
	$table_data.="<td>$module</td>";
	$table_data.="<td>$order_qty</td>";
	$table_data.="<td ".know_bg_color($order_qty,$bundling).">$bundling</td>";
	$table_data.="<td ".know_bg_color($order_qty,$pan_send).">$pan_send</td>";
	$table_data.="<td ".know_bg_color($order_qty,$pan_receive).">$pan_receive</td>";
	$table_data.="<td ".know_bg_color($order_qty,$bundleout).">$bundleout</td>";
	$table_data.="<td ".know_bg_color($order_qty,$linein).">$linein</td>";
	$table_data.="<td ".know_bg_color($order_qty,$output).">$output</td>";
	$table_data.="<td>$rejected</td>";
	$table_data.="<td>$a_output</td>";
	$table_data.="<td>$b_output</td>";
	
	$table_data.="<td>".(($output+$rejected)>=$order_qty?"Completed":"Pending")."</td>";
	$table_data.="</tr>";

}

$table_data.="</table>";
echo $table_data;
$export_rep_name="Bundle_Wise_Performance_Report_";
}
?>




<?php
if($_GET['rep_format']==4)
{
		$table_data="";
$table_data.="<h2>Output Vs Carton Packing</h2>";	
$table_data.="<h3>$title</h3>";
$table_data.="<table id='table_format'>";
$table_data.="<tr>";
$table_data.="<th>Schedule</th>";
$table_data.="<th>Color</th>";
$table_data.="<th>Size</th>";
$table_data.="<th>Order Quantity</th>";
$table_data.="<th>Line Out</th>";
$table_data.="<th>Rejected</th>";
$table_data.="<th>Carton Packed (PCS)</th>";
$table_data.="<th>Status</th>";
$table_data.="</tr>";
$sql="
select * from (
SELECT $view_set_6_snap.style as tbl_orders_style_ref_product_style,$view_set_6_snap.schedule as tbl_orders_master_product_schedule,$view_set_6_snap.color,$view_set_6_snap.size,output,sum(cpk_qty) as cpk_qty,order_qty,rejected FROM (
SELECT
AVG(tbl_orders_sizes_master_order_quantity) AS order_qty, 
tbl_orders_master_product_schedule AS SCHEDULE,size_disp AS size,tbl_miniorder_data_color AS color,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_rejection_quantity,0)) AS rejected,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output
FROM $view_set_snap_1_tbl WHERE tbl_orders_master_product_schedule IS NOT NULL $filter_query GROUP BY order_id ) AS tmp LEFT JOIN $view_set_6_snap ON CONCAT(tmp.schedule,tmp.color,tmp.size)=CONCAT($view_set_6_snap.schedule,$view_set_6_snap.color,$view_set_6_snap.size) GROUP BY CONCAT(tmp.schedule,tmp.color,tmp.size)) as tmp2 where 1=1 and tbl_orders_master_product_schedule is not null $filter_query";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$tbl_orders_master_product_schedule=$sql_row['tbl_orders_master_product_schedule'];	
	$size_disp=$sql_row['size'];	
	$tbl_miniorder_data_color=$sql_row['color'];	
	$output=$sql_row['output'];
	$cpk_qty=$sql_row['cpk_qty'];
	$order_qty=$sql_row['order_qty'];
	$rejected=$sql_row['rejected'];
	
	$table_data.="<tr>";
	$table_data.="<td>$tbl_orders_master_product_schedule</td>";
	$table_data.="<td>$tbl_miniorder_data_color</td>";
	$table_data.="<td>$size_disp</td>";
	$table_data.="<td>$order_qty</td>";
	
	$table_data.="<td ".know_bg_color($order_qty,$cpk_qty).">$output</td>";
	$table_data.="<td>$rejected</td>";
	$table_data.="<td ".know_bg_color($order_qty,$cpk_qty).">$cpk_qty</td>";

	$table_data.="<td>".($cpk_qty>=$order_qty?"Completed":"Pending")."</td>";
	$table_data.="</tr>";

}

$table_data.="</table>";
echo $table_data;
$export_rep_name="Output_Vs_Carton_Packing_";
}
?>



<?php

if($_GET['rep_format']==5)
{
	$table_data="";
$table_data.="<h2>Day Wise Operations Performance Report</h2>";	
$table_data.="<h3>$title</h3>";
$table_data.="<table id='table_format'>";
$table_data.="<tr>";
$table_data.="<th>Date</th>";
$table_data.="<th>Schedule</th>";
$table_data.="<th>Color</th>";
$table_data.="<th>Operation</th>";
$table_data.="<th>Bundling</th>";
$table_data.="<th>Panel Send</th>";
$table_data.="<th>Panel Receive</th>";
$table_data.="<th>Bundle Out</th>";
$table_data.="<th>Line In</th>";
$table_data.="<th>Line Out</th>";
$table_data.="<th>Rejected</th>";
$table_data.="<th>Line Out (A)</th>";
$table_data.="<th>Line Out (B)</th>";
$table_data.="<th>SAH</th>";
$table_data.="</tr>";
$sql="
SELECT 
DATE(bundle_transactions_date_time) AS daten,LEFT(bundle_transactions_date_time,7) AS monthn,tbl_orders_ops_ref_operation_code,
tbl_orders_master_product_schedule,tbl_miniorder_data_color,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
SUM(IF(tbl_orders_ops_ref_operation_code='PS',bundle_transactions_20_repeat_quantity,0)) AS pan_send,
SUM(IF(tbl_orders_ops_ref_operation_code='PR',bundle_transactions_20_repeat_quantity,0)) AS pan_receive,
SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_rejection_quantity,0)) AS rejected,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO' AND tbl_shifts_master_shift_name='A',bundle_transactions_20_repeat_quantity,0)) AS a_output,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO' AND tbl_shifts_master_shift_name='B',bundle_transactions_20_repeat_quantity,0)) AS b_output,
ROUND(SUM(sah),2) AS sah

FROM $view_set_snap_1_tbl WHERE 1=1 and tbl_orders_ops_ref_operation_code<>'INI' and tbl_orders_master_product_schedule is not null and tbl_orders_master_product_schedule>0 ".$filter_query."

GROUP BY DATE(bundle_transactions_date_time),tbl_orders_master_product_schedule,tbl_miniorder_data_color,tbl_orders_ops_ref_operation_code ORDER BY DATE(bundle_transactions_date_time) DESC";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$tbl_orders_master_product_schedule=$sql_row['tbl_orders_master_product_schedule'];	
	$daten=$sql_row['daten'];
	$tbl_orders_ops_ref_operation_code=$sql_row['tbl_orders_ops_ref_operation_code'];
	$tbl_miniorder_data_color=$sql_row['tbl_miniorder_data_color'];	
	
	$output=$sql_row['output'];	
	$bundling=$sql_row['bundling'];	
	$bundleout=$sql_row['bundleout'];	
	$linein=$sql_row['linein'];	
	$a_output=$sql_row['a_output'];	
	$b_output=$sql_row['b_output'];
	$sah=$sql_row['sah'];
	$rejected=$sql_row['rejected'];
	$pan_send=$sql_row['pan_send'];
	$pan_receive=$sql_row['pan_receive'];
	
	$table_data.="<tr>";
	$table_data.="<td>$daten</td>";
	$table_data.="<td>$tbl_orders_master_product_schedule</td>";
	$table_data.="<td>$tbl_miniorder_data_color</td>";
	$table_data.="<td>$tbl_orders_ops_ref_operation_code</td>";
	$table_data.="<td>$bundling</td>";
	$table_data.="<td>$pan_send</td>";
	$table_data.="<td>$pan_receive</td>";
	$table_data.="<td>$bundleout</td>";
	$table_data.="<td>$linein</td>";
	$table_data.="<td>$output</td>";
	$table_data.="<td>$rejected</td>";
	$table_data.="<td>$a_output</td>";
	$table_data.="<td>$b_output</td>";
	
	$table_data.="<td>".$sah."</td>";
	$table_data.="</tr>";

}

$table_data.="</table>";
echo $table_data;
$export_rep_name="Day_Wise_Operations_Performance_Report_";
}
?>




<?php

if($_GET['rep_format']==6)
{
		$table_data="";
$table_data.="<h2>Day Wise Production Performance Report</h2>";
$table_data.="<h3>$title</h3>";
$table_data.="<table id='table_format'>";
$table_data.="<tr>";
$table_data.="<th>Date</th>";
$table_data.="<th>Schedule</th>";
$table_data.="<th>Color</th>";
$table_data.="<th>Shift</th>";
$table_data.="<th>Module</th>";
$table_data.="<th>Total Line Out</th>";
$table_data.="<th>Rejected</th>";
$table_data.="<th>Line Out (A)</th>";
$table_data.="<th>Line Out (B)</th>";
$table_data.="<th>Total SAH</th>";
$table_data.="<th>SAH (A)</th>";
$table_data.="<th>SAH (B)</th>";
$table_data.="</tr>";
$sql="
SELECT 
DATE(bundle_transactions_date_time) AS daten,LEFT(bundle_transactions_date_time,7) AS monthn,tbl_orders_ops_ref_operation_code,tbl_shifts_master_shift_name,bundle_transactions_20_repeat_act_module,
tbl_orders_master_product_schedule,tbl_miniorder_data_color,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO' AND tbl_shifts_master_shift_name='A',bundle_transactions_20_repeat_quantity,0)) AS a_output,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO' AND tbl_shifts_master_shift_name='B',bundle_transactions_20_repeat_quantity,0)) AS b_output,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO' AND tbl_shifts_master_shift_name='A',sah,0)) AS a_sah,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO' AND tbl_shifts_master_shift_name='B',sah,0)) AS b_sah,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_rejection_quantity,0)) AS rejected,
ROUND(SUM(sah),2) AS sah

FROM $view_set_snap_1_tbl WHERE 1=1 and tbl_orders_ops_ref_operation_code='LNO' and tbl_orders_master_product_schedule is not null and tbl_orders_master_product_schedule>0 ".$filter_query."

GROUP BY DATE(bundle_transactions_date_time),tbl_shifts_master_shift_name,bundle_transactions_20_repeat_act_module,tbl_orders_master_product_schedule,tbl_miniorder_data_color,tbl_orders_ops_ref_operation_code ORDER BY DATE(bundle_transactions_date_time),tbl_shifts_master_shift_name,bundle_transactions_20_repeat_act_module DESC";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$tbl_orders_master_product_schedule=$sql_row['tbl_orders_master_product_schedule'];	
	$daten=$sql_row['daten'];
	$tbl_miniorder_data_color=$sql_row['tbl_miniorder_data_color'];	
	
	$output=$sql_row['output'];	
	
	$a_output=$sql_row['a_output'];	
	$b_output=$sql_row['b_output'];
	$a_sah=$sql_row['a_sah'];	
	$b_sah=$sql_row['b_sah'];
	$sah=$sql_row['sah'];
	$tbl_shifts_master_shift_name=$sql_row['tbl_shifts_master_shift_name'];
	$bundle_transactions_20_repeat_act_module=$sql_row['bundle_transactions_20_repeat_act_module'];
	$rejected=$sql_row['rejected'];
	
	$table_data.="<tr>";
	$table_data.="<td>$daten</td>";
	$table_data.="<td>$tbl_orders_master_product_schedule</td>";
	$table_data.="<td>$tbl_miniorder_data_color</td>";
	$table_data.="<td>$tbl_shifts_master_shift_name</td>";
	$table_data.="<td>$bundle_transactions_20_repeat_act_module</td>";

	$table_data.="<td>$output</td>";
	$table_data.="<td>$rejected</td>";
	$table_data.="<td>$a_output</td>";
	$table_data.="<td>$b_output</td>";
	
	$table_data.="<td>".$sah."</td>";
	$table_data.="<td>".$a_sah."</td>";
	$table_data.="<td>".$b_sah."</td>";
	$table_data.="</tr>";

}

$table_data.="</table>";
echo $table_data;
$export_rep_name="Day_Wise_Production_Performance_Report_";
}
?>


<?php
if($_GET['rep_format']==7)
{
		$table_data="";
$table_data.="<h2>Mini-Order Output Vs Carton Packing</h2>";	
$table_data.="<h3>$title</h3>";
$table_data.="<table id='table_format'>";
$table_data.="<tr>";
$table_data.="<th>Mini-Order#</th>";
$table_data.="<th>Schedule</th>";
$table_data.="<th>Color</th>";
$table_data.="<th>Size</th>";
$table_data.="<th>Mini-Order Quantity</th>";
$table_data.="<th>Line Out</th>";
$table_data.="<th>Rejected</th>";
$table_data.="<th>Mini-Order_Cummulative</th>";
$table_data.="<th>Carton Packed (PCS)</th>";
$table_data.="<th>Status</th>";
$table_data.="</tr>";
$sql="
SELECT *,fn_bai_mini_cumulative(order_id,tbl_miniorder_data_mini_order_num) AS miniorder_cum  FROM (
SELECT $view_set_6_snap.style AS tbl_orders_style_ref_product_style,$view_set_6_snap.schedule AS tbl_orders_master_product_schedule,$view_set_6_snap.color,$view_set_6_snap.size,output,sum(cpk_qty) as cpk_qty,order_qty,miniorderbundle,tbl_miniorder_data_mini_order_num,order_id,rejected FROM (
SELECT
AVG(tbl_orders_sizes_master_order_quantity) AS order_qty, 
tbl_miniorder_data_mini_order_num,
SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_rejection_quantity,0)) AS rejected,
order_id,
tbl_orders_master_product_schedule AS SCHEDULE,size_disp AS size,tbl_miniorder_data_color AS color,order_tid_new,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output
FROM $view_set_snap_1_tbl WHERE tbl_orders_master_product_schedule IS NOT NULL $filter_query GROUP BY tbl_miniorder_data_mini_order_num,order_id ) AS tmp LEFT JOIN $view_set_6_snap ON tmp.order_tid_new=$view_set_6_snap.order_tid_new GROUP BY tbl_miniorder_data_mini_order_num,tmp.order_tid_new) AS tmp2 where 1=1 and tbl_orders_master_product_schedule is not null $filter_query ";
//echo $sql."<br>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$fil_min=array();$cpk_qty=0;
while($sql_row=mysqli_fetch_array($sql_result))
{
	$tbl_orders_master_product_schedule=$sql_row['tbl_orders_master_product_schedule'];	
	$size_disp=$sql_row['size'];	
	$tbl_miniorder_data_color=$sql_row['color'];	
	$output=$sql_row['output'];
	$code=$tbl_orders_master_product_schedule.$tbl_miniorder_data_color;
	$cpk_qtyt=0;
	if($fil_min[$code][$size_disp]==0 || $fil_min[$code][$size_disp]=='')
	{
		$fil_min[$code][$size_disp]=0;
	}
	
	// if($sql_row['cpk_qty'] == $fil_min[$tbl_miniorder_data_color][$size_disp])
	// {
		// $fil_min[$tbl_miniorder_data_color][$size_disp]=$fil_min[$tbl_miniorder_data_color][$size_disp]-$sql_row['cpk_qty'];
		// $cpk_qtyt=0;
	// }
	// else
	// {
		// $cpk_qtyt=$sql_row['cpk_qty']-($fil_min[$tbl_miniorder_data_color][$size_disp]);
	// }
	$cpk_qtyt=$sql_row['cpk_qty']-($fil_min[$code][$size_disp]);
	$order_qty=$sql_row['order_qty'];
	$miniorderbundle=$sql_row['miniorderbundle'];
	$tbl_miniorder_data_mini_order_num=$sql_row['tbl_miniorder_data_mini_order_num'];
	$miniorder_cum=$sql_row['miniorder_cum'];
	$rejected=$sql_row['rejected'];
	
	if($cpk_qtyt<$miniorderbundle)
	{
		$cpk_qty=$cpk_qtyt;
		$fil_min[$code][$size_disp]+=$cpk_qtyt;
	}
	else if($cpk_qtyt>0)
	{
		$cpk_qty=$miniorderbundle;
		$fil_min[$code][$size_disp]+=$miniorderbundle;
	}
	else
	{
		$cpk_qty=0;
	}
		
	$table_data.="<tr>";
	$table_data.="<td>$tbl_miniorder_data_mini_order_num</td>";
	$table_data.="<td>$tbl_orders_master_product_schedule</td>";
	$table_data.="<td>$tbl_miniorder_data_color</td>";
	$table_data.="<td>".$size_disp."</td>";
	$table_data.="<td>$miniorderbundle</td>";
	$table_data.="<td ".know_bg_color($miniorderbundle,$output).">".$output."</td>";
	$table_data.="<td>".$rejected."</td>";
	$table_data.="<td ".know_bg_color($miniorderbundle,$cpk_qty).">$miniorder_cum</td>";
	$table_data.="<td ".know_bg_color($miniorderbundle,$cpk_qty).">$cpk_qty</td>";

	$table_data.="<td>$cpk_qty-".($cpk_qty>=$miniorderbundle?"Completed":"Pending")."</td>";
	$table_data.="</tr>";

}

$table_data.="</table>";
echo $table_data;
$export_rep_name="Mini_Order_VS_Output_Vs_Carton_Packing_";
}
?>


<?php
if($_GET['rep_format']==8)
{
		$table_data="";
$table_data.="<h2>Bundle Wise Production WIP Report</h2>";	
$table_data.="<h3>$title</h3>";
$table_data.="<table id='table_format'>";
$table_data.="<tr>";
$table_data.="<th>Input Date</th>";
$table_data.="<th>Module</th>";
$table_data.="<th>Schedule</th>";
$table_data.="<th>Color</th>";
$table_data.="<th>Size</th>";
$table_data.="<th>Mini-Order#</th>";
$table_data.="<th>Bundle #</th>";
$table_data.="<th>Input Quantity</th>";
$table_data.="<th>Output Quantity</th>";
$table_data.="<th>Rejected Quantity</th>";
$table_data.="</tr>";
$sql="

SELECT * FROM 
(
SELECT 
MAX(IF(tbl_orders_ops_ref_operation_code='LNI',DATE(bundle_transactions_date_time),0)) AS daten,LEFT(bundle_transactions_date_time,7) AS monthn,MAX(bundle_transactions_20_repeat_act_module) AS module,
tbl_orders_master_product_schedule,tbl_miniorder_data_color,size_disp,tbl_miniorder_data_mini_order_num,tbl_miniorder_data_bundle_number,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS input,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_rejection_quantity,0)) AS rejected

FROM $view_set_snap_1_tbl WHERE 1=1 and tbl_orders_ops_ref_operation_code in ('LNO','LNI') AND (tbl_orders_master_product_schedule IS NOT NULL) AND tbl_orders_master_product_schedule>0 $filter_query

GROUP BY tbl_miniorder_data_bundle_number ORDER BY DATE(bundle_transactions_date_time) DESC
) AS tmp WHERE input>0 AND (output+rejected)<>input
";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$daten=$sql_row['daten'];	$monthn=$sql_row['monthn'];	$module=$sql_row['module'];	$tbl_orders_master_product_schedule=$sql_row['tbl_orders_master_product_schedule'];	$tbl_miniorder_data_color=$sql_row['tbl_miniorder_data_color'];	$size_disp=$sql_row['size_disp'];	$tbl_miniorder_data_mini_order_num=$sql_row['tbl_miniorder_data_mini_order_num'];	$tbl_miniorder_data_bundle_number=$sql_row['tbl_miniorder_data_bundle_number'];	$output=$sql_row['output'];	$input=$sql_row['input'];	$rejected=$sql_row['rejected'];

	
	$table_data.="<tr>";
	$table_data.="<td>$daten</td>";
	$table_data.="<td>$module</td>";
	$table_data.="<td>$tbl_orders_master_product_schedule</td>";
	$table_data.="<td>$tbl_miniorder_data_color</td>";
	$table_data.="<td>$size_disp</td>";
	
	$table_data.="<td>$tbl_miniorder_data_mini_order_num</td>";
	$table_data.="<td>$tbl_miniorder_data_bundle_number</td>";
	$table_data.="<td>$input</td>";
	$table_data.="<td>$output</td>";
	$table_data.="<td>$rejected</td>";
	
	$table_data.="</tr>";

}

$table_data.="</table>";
echo $table_data;
$export_rep_name="Bundle_Wise_Production_WIP_Report_";
}
?>


<?php
if($_GET['rep_format']==9)
{
		$table_data="";
$table_data.="<h2>Carton WIP Report</h2>";	
$table_data.="<h3>$title</h3>";
$table_data.="<table id='table_format'>";
$table_data.="<tr>";
$table_data.="<th>Schedule</th>";
$table_data.="<th>Color</th>";
$table_data.="<th>Size</th>";
$table_data.="<th>Order Quantity</th>";
$table_data.="<th>Line Out</th>";
$table_data.="<th>Rejected</th>";
$table_data.="<th>Carton Packed (PCS)</th>";
$table_data.="<th>Packing Ratio</th>";
$table_data.="<th>Order Cartons</th>";
$table_data.="<th>Packed Cartons</th>";
$table_data.="<th>Output Cartons</th>";
$table_data.="<th>Production Balances</th>";
$table_data.="<th>Packing Balances</th>";
$table_data.="<th>Status</th>";
$table_data.="</tr>";
$sql="SELECT *,view_set_7.quantity,
ROUND((order_qty/quantity),0) AS order_carts,
ROUND((cpk_qty)/quantity,0) AS cpk_carts,
ROUND((output)/quantity,0) AS prod_carts,
output-cpk_qty AS pack_balances,
order_qty-output AS prod_balances

 FROM (
SELECT order_id,$view_set_6_snap.style AS tbl_orders_style_ref_product_style,$view_set_6_snap.schedule AS tbl_orders_master_product_schedule,$view_set_6_snap.color,$view_set_6_snap.size,output,SUM(cpk_qty) AS cpk_qty,order_qty,rejected FROM (
SELECT
order_id,
AVG(tbl_orders_sizes_master_order_quantity) AS order_qty, 
tbl_orders_master_product_schedule AS SCHEDULE,size_disp AS size,tbl_miniorder_data_color AS color,
SUM(bundle_transactions_20_repeat_rejection_quantity) AS rejected,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output
FROM $view_set_snap_1_tbl WHERE tbl_orders_master_product_schedule IS NOT NULL $filter_query GROUP BY order_id ) AS tmp LEFT JOIN $view_set_6_snap ON CONCAT(tmp.schedule,tmp.color,tmp.size)=CONCAT($view_set_6_snap.schedule,$view_set_6_snap.color,$view_set_6_snap.size) GROUP BY CONCAT(tmp.schedule,tmp.color,tmp.size)
) AS tmp2 

LEFT JOIN 	

view_set_7 ON tmp2.order_id=view_set_7.ref_id

WHERE 1=1 AND tbl_orders_master_product_schedule IS NOT NULL  $filter_query";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

$cpk_carts_min=0;	
	$prod_carts_min=0;	
	
while($sql_row=mysqli_fetch_array($sql_result))
{
	$tbl_orders_master_product_schedule=$sql_row['tbl_orders_master_product_schedule'];	
	$size_disp=$sql_row['size'];	
	$tbl_miniorder_data_color=$sql_row['color'];	
	$output=$sql_row['output'];
	$cpk_qty=$sql_row['cpk_qty'];
	$order_qty=$sql_row['order_qty'];
	$rejected=$sql_row['rejected'];
	
	$quantity=$sql_row['quantity'];	
	$order_carts=$sql_row['order_carts'];	
	$cpk_carts=$sql_row['cpk_carts'];	
	$prod_carts=$sql_row['prod_carts'];	
	$pack_balances=$sql_row['pack_balances'];	
	$prod_balances=$sql_row['prod_balances'];

	
	$table_data.="<tr>";
	$table_data.="<td>$tbl_orders_master_product_schedule</td>";
	$table_data.="<td>$tbl_miniorder_data_color</td>";
	$table_data.="<td>$size_disp</td>";
	$table_data.="<td>$order_qty</td>";
	
	$table_data.="<td ".know_bg_color($order_qty,$cpk_qty).">$output</td>";
	$table_data.="<td>$rejected</td>";
	$table_data.="<td ".know_bg_color($order_qty,$cpk_qty).">$cpk_qty</td>";
$table_data.="<td>$quantity</td>";
$table_data.="<td>$order_carts</td>";
$table_data.="<td>$cpk_carts</td>";
$table_data.="<td>$prod_carts</td>";
$table_data.="<td>$prod_balances</td>";
$table_data.="<td>$pack_balances</td>";

	$table_data.="<td>".($cpk_qty>=$order_qty?"Completed":"Pending")."</td>";
	$table_data.="</tr>";

}

$table_data.="</table>";
echo $table_data;
$export_rep_name="Carton_WIP_Report_";
}
?>

<?php
if(mysqli_num_rows($sql_result)<=500)
{
	
?>
<script>
jQuery('#table_format').ddTableFilter();
</script>
<?php
}
?>
<div id="div-1a">
<form  name="input" action="export_to_excel.php" method="post">
<input type="hidden" name="table" value="<?php echo $table_data; ?>">
<input type="hidden" name="file_name" value="<?php echo $export_rep_name.date("Ymd");?>">
<input type="submit" name="submit" value="Export to Excel">
</form>
</div>
<script type="text/javascript">
 
       document.getElementById("msg").style.display = 'none';
</script>
</body>
</html>