<?php
include("dbconf_sch.php");

include("session_check.php");

//Caching File

// if(isset($_REQUEST['snap_ids']))
// {
	$cachefile = "cpk_report_5.html";
	ob_start();
// }
// if(isset($_REQUEST['snap_ids1']))
// {
	// $cachefile = "cpk_report_6.html";
	// ob_start();
// }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
	<title>BAI BTS -POPUP :: Master Performance Reports</title>
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


<link rel="stylesheet" type="text/css" media="all" href="jsdatepick-calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="jsdatepick-calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="datetimepicker_css.js"></script>

</head>
<body>


<?php
//"http://baitestsrv:8080/projects/beta/bai3_bts_kpi_uat2/master_performance_report.php?report_type=5&snap_ids=1&submit=1"

?>


<?php


// if(isset($_REQUEST['submit']))
// {
	// $sdate=$_REQUEST['sdate'];
	// $edate=$_REQUEST['edate'];
	// $report_type=$_REQUEST['report_type'];
	$sdate=date("Y-m-d");
	$edate=date("Y-m-d");
	$report_type=5;
	
	$filter_query=" and (daten between '$sdate' and '$edate') ";
	
	// if($report_type==1)
	// {
		// $table_data="";
	// $table_data.="<h2>Day wise Style/Schedule/Color Performance</h2>";	
	// $table_data.="<h3>$title</h3>";
	// $table_data.="<table id='table_format'>";
	// $table_data.="<tr>";
	// $table_data.="<th>Date</th>";
	// $table_data.="<th>Style</th>";
	// $table_data.="<th>Schedule</th>";
	// $table_data.="<th>Color</th>";
	// $table_data.="<th>Bundling</th>";
	// $table_data.="<th>Panel Send</th>";
	// $table_data.="<th>Panel Receive</th>";
	// $table_data.="<th>Bundle Out</th>";
	// $table_data.="<th>Line In</th>";
	// $table_data.="<th>Line Out</th>";
	// $table_data.="<th>Rejected</th>";
	// $table_data.="<th>Carton Pack</th>";
	// $table_data.="<th>SAH</th>";
	// $table_data.="</tr>";
	
	// $table_data_export="";
	// $table_data_export.="<h2>Day wise Style/Schedule/Color Performance</h2>";	
	// $table_data_export.="<h3>$title</h3>";
	// $table_data_export.="<table id='table_format'>";
	// $table_data_export.="<tr>";
	// $table_data_export.="<th>Date</th>";
	// $table_data_export.="<th>Style</th>";
	// $table_data_export.="<th>Schedule</th>";
	// $table_data_export.="<th>Color</th>";
	// $table_data_export.="<th>Bundling</th>";
	// $table_data_export.="<th>Panel Send</th>";
	// $table_data_export.="<th>Panel Receive</th>";
	// $table_data_export.="<th>Bundle Out</th>";
	// $table_data_export.="<th>Line In</th>";
	// $table_data_export.="<th>Line Out</th>";
	// $table_data_export.="<th>Rejected</th>";
	// $table_data_export.="<th>Carton Pack</th>";
	// $table_data_export.="<th>SAH</th>";
	// $table_data_export.="</tr>";
	// $sql="
	// select 
	// style,schedule,	color,	daten,	sum(output) as output, sum(pan_send) as pan_send, sum(pan_receive) as pan_receive,	sum(bundling) as bundling,	sum(bundleout) as bundleout,	sum(linein) as linein,	sum(rejected) as rejected,	sum(sah) as sah,	sum(cpk_qty) as cpk_qty
	// from 
	// (
	// SELECT  tbl_orders_style_ref_product_style AS style,tbl_orders_master_product_schedule AS SCHEDULE,tbl_miniorder_data_color AS color,DATE(bundle_transactions_date_time)  AS daten,
// SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
	// SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
	// SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
	// SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
	// SUM(IF(tbl_orders_ops_ref_operation_code='PS',bundle_transactions_20_repeat_quantity,0)) AS pan_send,
	// SUM(IF(tbl_orders_ops_ref_operation_code='PR',bundle_transactions_20_repeat_quantity,0)) AS pan_receive,
	// SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_rejection_quantity,0)) AS rejected,
	
	// 0 AS cpk_qty,
	// ROUND(SUM(ROUND(sah,2)),2) AS sah
// FROM `$view_set_snap_1_tbl` 
// WHERE 1=1 and bundle_transactions_20_repeat_operation_id<>'5' and (DATE(bundle_transactions_date_time) between '$sdate' and '$edate' )  AND tbl_orders_master_product_schedule>0 
// GROUP BY tbl_orders_style_ref_product_style,tbl_orders_master_product_schedule,tbl_miniorder_data_color,DATE(bundle_transactions_date_time) 

// UNION 
// SELECT style,SCHEDULE,color,DATE AS daten,0 AS output, 0 AS pan_send, 0 AS pan_receive, 0 AS bundling, 0 AS bundleout, 0 AS linein, 0 AS rejected,SUM(cpk_qty) AS cpk_qty , 0 AS sah FROM `$view_set_6_snap` where 1=1  GROUP BY style,SCHEDULE,color,DATE
// ) as tmp where 1=1 ".$filter_query." group by daten,style,schedule,color,daten order by daten";

	// $sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	// while($sql_row=mysql_fetch_array($sql_result))
	// {
		
		// $style=$sql_row['style'];	$schedule=$sql_row['schedule'];	$color=$sql_row['color'];	$daten=$sql_row['daten'];	$output=$sql_row['output'];	
		// $pan_send=$sql_row['pan_send'];$pan_receive=$sql_row['pan_receive'];
		// $bundling=$sql_row['bundling'];	$bundleout=$sql_row['bundleout'];	$linein=$sql_row['linein'];	$rejected=$sql_row['rejected'];	$sah=$sql_row['sah'];	$cpk_qty=$sql_row['cpk_qty'];


		// $table_data.="<tr>";
		// $table_data.="<td>$daten</td>";
		// $table_data.="<td><span style=\"cursor: pointer; cursor: hand; color:blue;\" onclick=\"Popup=window.open('popup.php?style=$style','Popup2','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$style</span></td>";
		// $table_data.="<td><span style=\"cursor: pointer; cursor: hand; color:blue;\" onclick=\"Popup=window.open('popup.php?schedule=$schedule','Popup2','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$schedule</span></td>";
		// $table_data.="<td>$color</td>";
		// $table_data.="<td>$bundling</td>";
		// $table_data.="<td>$pan_send</td>";
		// $table_data.="<td>$pan_receive</td>";
		// $table_data.="<td>$bundleout</td>";
		// $table_data.="<td>$linein</td>";
		// $table_data.="<td>$output</td>";
		// $table_data.="<td>$rejected</td>";
		// $table_data.="<td>$cpk_qty</td>";
		// $table_data.="<td>".$sah."</td>";
		// $table_data.="</tr>";
		
		// $style=$sql_row['style'];	$schedule=$sql_row['schedule'];	$color=$sql_row['color'];	$daten=$sql_row['daten'];	
		// $output=$sql_row['output'];		$pan_send=$sql_row['pan_send'];$pan_receive=$sql_row['pan_receive'];$bundling=$sql_row['bundling'];	$bundleout=$sql_row['bundleout'];	$linein=$sql_row['linein'];	$rejected=$sql_row['rejected'];	$sah=$sql_row['sah'];	$cpk_qty=$sql_row['cpk_qty'];


		// $table_data_export.="<tr>";
		// $table_data_export.="<td>$daten</td>";
		// $table_data_export.="<td>$style</td>";
		// $table_data_export.="<td>$schedule</td>";
		// $table_data_export.="<td>$color</td>";
		// $table_data_export.="<td>$bundling</td>";
		// $table_data_export.="<td>$pan_send</td>";
		// $table_data_export.="<td>$pan_receive</td>";
		// $table_data_export.="<td>$bundleout</td>";
		// $table_data_export.="<td>$linein</td>";
		// $table_data_export.="<td>$output</td>";
		// $table_data_export.="<td>$rejected</td>";
		// $table_data_export.="<td>$cpk_qty</td>";
		// $table_data_export.="<td>".$sah."</td>";
		// $table_data_export.="</tr>";

	// }

	// $table_data.="</table>";
	// $table_data_export.="</table>";
	// echo $table_data;
	// $export_rep_name="Day_wise_Style_Schedule_Color_Performance_";
	// }

	// if($report_type==2)
	// {
		// $table_data="";
	// $table_data.="<h2>Day wise Style/Schedule/Color/Module/Shift Performance</h2>";	
	// $table_data.="<h3>$title</h3>";
	// $table_data.="<table id='table_format'>";
	// $table_data.="<tr>";
	// $table_data.="<th>Date</th>";
	// $table_data.="<th>Module</th>";
	// $table_data.="<th>Shift</th>";
	// $table_data.="<th>Operation</th>";
	// $table_data.="<th>Style</th>";
	// $table_data.="<th>Schedule</th>";
	// $table_data.="<th>Color</th>";
	// $table_data.="<th>Bundling</th>";
	// $table_data.="<th>Panel Send</th>";
	// $table_data.="<th>Panel Receive</th>";
	// $table_data.="<th>Bundle Out</th>";
	// $table_data.="<th>Line In</th>";
	// $table_data.="<th>Line Out</th>";
	// $table_data.="<th>Rejected</th>";
	// $table_data.="<th>Carton Pack</th>";
	// $table_data.="<th>SAH</th>";
	// $table_data.="</tr>";
	
	// $table_data_export="";
	// $table_data_export.="<h2>Day wise Style/Schedule/Color/Module/Shift Performance</h2>";	
	// $table_data_export.="<h3>$title</h3>";
	// $table_data_export.="<table id='table_format'>";
	// $table_data_export.="<tr>";
	// $table_data_export.="<th>Date</th>";
	// $table_data_export.="<th>Module</th>";
	// $table_data_export.="<th>Shift</th>";
	// $table_data_export.="<th>Operation</th>";
	// $table_data_export.="<th>Style</th>";
	// $table_data_export.="<th>Schedule</th>";
	// $table_data_export.="<th>Color</th>";
	// $table_data_export.="<th>Bundling</th>";
	// $table_data_export.="<th>Panel Send</th>";
	// $table_data_export.="<th>Panel Receive</th>";
	// $table_data_export.="<th>Bundle Out</th>";
	// $table_data_export.="<th>Line In</th>";
	// $table_data_export.="<th>Line Out</th>";
	// $table_data_export.="<th>Rejected</th>";
	// $table_data_export.="<th>Carton Pack</th>";
	// $table_data_export.="<th>SAH</th>";
	// $table_data_export.="</tr>";
	
	// $sql="
	// select 
	// style,schedule,	color,	daten,	sum(output) as output,	sum(pan_send) as pan_send, sum(pan_receive) as pan_receive,	sum(bundling) as bundling,	sum(bundleout) as bundleout,	sum(linein) as linein,	sum(rejected) as rejected,	sum(sah) as sah,	sum(cpk_qty) as cpk_qty, shift,module, operation
	// from 
	// (
	// SELECT  tbl_orders_style_ref_product_style AS style,tbl_orders_master_product_schedule AS SCHEDULE,tbl_miniorder_data_color AS color,DATE(bundle_transactions_date_time)  AS daten,
// SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
	// SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
	// SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
	// SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
	// SUM(IF(tbl_orders_ops_ref_operation_code='PS',bundle_transactions_20_repeat_quantity,0)) AS pan_send,
	// SUM(IF(tbl_orders_ops_ref_operation_code='PR',bundle_transactions_20_repeat_quantity,0)) AS pan_receive,
	// SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_rejection_quantity,0)) AS rejected,
	
	// 0 AS cpk_qty,
	// ROUND(SUM(ROUND(sah,2)),2) AS sah,
	// tbl_shifts_master_shift_name as shift,bundle_transactions_20_repeat_act_module as module,
	// tbl_orders_ops_ref_operation_code as operation
// FROM `$view_set_snap_1_tbl` 
// WHERE 1=1 and bundle_transactions_20_repeat_operation_id<>'5' and (DATE(bundle_transactions_date_time) between '$sdate' and '$edate' )  AND tbl_orders_master_product_schedule>0 
// GROUP BY DATE(bundle_transactions_date_time),tbl_orders_style_ref_product_style,tbl_orders_master_product_schedule,tbl_miniorder_data_color,bundle_transactions_20_repeat_act_module,tbl_shifts_master_shift_name,tbl_orders_ops_ref_operation_code

// UNION 
// SELECT style,SCHEDULE,color,DATE AS daten,0 AS output, 0 AS pan_send, 0 AS pan_receive, 0 AS bundling, 0 AS bundleout, 0 AS linein, 0 AS rejected,SUM(cpk_qty) AS cpk_qty , 0 AS sah, shift,'' as module,'CPK' as operation FROM `$view_set_6_snap` where 1=1  GROUP BY style,SCHEDULE,color,DATE
// ) as tmp where 1=1 ".$filter_query." group by daten,style,schedule,color,module,shift,operation order by daten";
echo $sql;
	// $sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	// while($sql_row=mysql_fetch_array($sql_result))
	// {
		
		// $pan_send=$sql_row['pan_send'];$pan_receive=$sql_row['pan_receive'];$style=$sql_row['style'];	$schedule=$sql_row['schedule'];	$color=$sql_row['color'];	$daten=$sql_row['daten'];	$output=$sql_row['output'];	$bundling=$sql_row['bundling'];	$bundleout=$sql_row['bundleout'];	$linein=$sql_row['linein'];	$rejected=$sql_row['rejected'];	$sah=$sql_row['sah'];	$cpk_qty=$sql_row['cpk_qty']; $module=$sql_row['module']; $shift=$sql_row['shift']; $operation=$sql_row['operation'];


		// $table_data.="<tr>";
		// $table_data.="<td>$daten</td>";
		// $table_data.="<td>$module</td>";
		// $table_data.="<td>$shift</td>";
		// $table_data.="<td>$operation</td>";
		// $table_data.="<td><span style=\"cursor: pointer; cursor: hand; color:blue;\" onclick=\"Popup=window.open('popup.php?style=$style','Popup2','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$style</span></td>";
		// $table_data.="<td><span style=\"cursor: pointer; cursor: hand; color:blue;\" onclick=\"Popup=window.open('popup.php?schedule=$schedule','Popup2','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$schedule</span></td>";
		// $table_data.="<td>$color</td>";
		// $table_data.="<td>$bundling</td>";
		// $table_data.="<td>$pan_send</td>";
		// $table_data.="<td>$pan_receive</td>";
		// $table_data.="<td>$bundleout</td>";
		// $table_data.="<td>$linein</td>";
		// $table_data.="<td>$output</td>";
		// $table_data.="<td>$rejected</td>";
		// $table_data.="<td>$cpk_qty</td>";
		// $table_data.="<td>".$sah."</td>";
		// $table_data.="</tr>";
		
		// $table_data_export.="<tr>";
		// $table_data_export.="<td>$daten</td>";
		// $table_data_export.="<td>$module</td>";
		// $table_data_export.="<td>$shift</td>";
		// $table_data_export.="<td>$operation</td>";
		// $table_data_export.="<td>$style</td>";
		// $table_data_export.="<td>$schedule</td>";
		// $table_data_export.="<td>$color</td>";
		// $table_data_export.="<td>$bundling</td>";
		// $table_data_export.="<td>$pan_send</td>";
		// $table_data_export.="<td>$pan_receive</td>";
		// $table_data_export.="<td>$bundleout</td>";
		// $table_data_export.="<td>$linein</td>";
		// $table_data_export.="<td>$output</td>";
		// $table_data_export.="<td>$rejected</td>";
		// $table_data_export.="<td>$cpk_qty</td>";
		// $table_data_export.="<td>".$sah."</td>";
		// $table_data_export.="</tr>";

	// }

	// $table_data.="</table>";
	// $table_data_export.="</table>";
	// echo $table_data;
	// $export_rep_name="Day_wise_Style_Schedule_Color_Module_Shift_Performance_";
	// }


	// if($report_type==3)
	// {
		// $table_data="";
	// $table_data.="<h2>Day wise Bundle Performance</h2>";	
	// $table_data.="<h3>$title</h3>";
	// $table_data.="<table id='table_format'>";
	// $table_data.="<tr>";
	// $table_data.="<th>Date</th>";
	// $table_data.="<th>Module</th>";
	// $table_data.="<th>Shift</th>";
	// $table_data.="<th>Operation</th>";
	// $table_data.="<th>Style</th>";
	// $table_data.="<th>Schedule</th>";
	// $table_data.="<th>Color</th>";
	// $table_data.="<th>Size</th>";
	// $table_data.="<th>Bundle #</th>";
	// $table_data.="<th>Bundling</th>";
	// $table_data.="<th>Panel Send</th>";
	// $table_data.="<th>Panel Receive</th>";
	// $table_data.="<th>Bundle Out</th>";
	// $table_data.="<th>Line In</th>";
	// $table_data.="<th>Line Out</th>";
	// $table_data.="<th>Rejected</th>";
	// $table_data.="<th>Carton Pack</th>";
	// $table_data.="<th>SAH</th>";
	// $table_data.="</tr>";
	
	// $table_data_export="";
	// $table_data_export.="<h2>Day wise Bundle Performance</h2>";	
	// $table_data_export.="<h3>$title</h3>";
	// $table_data_export.="<table id='table_format'>";
	// $table_data_export.="<tr>";
	// $table_data_export.="<th>Date</th>";
	// $table_data_export.="<th>Module</th>";
	// $table_data_export.="<th>Shift</th>";
	// $table_data_export.="<th>Operation</th>";
	// $table_data_export.="<th>Style</th>";
	// $table_data_export.="<th>Schedule</th>";
	// $table_data_export.="<th>Color</th>";
	// $table_data_export.="<th>Size</th>";
	// $table_data_export.="<th>Bundle #</th>";
	// $table_data_export.="<th>Bundling</th>";
	// $table_data_export.="<th>Panel Send</th>";
	// $table_data_export.="<th>Panel Receive</th>";
	// $table_data_export.="<th>Bundle Out</th>";
	// $table_data_export.="<th>Line In</th>";
	// $table_data_export.="<th>Line Out</th>";
	// $table_data_export.="<th>Rejected</th>";
	// $table_data_export.="<th>Carton Pack</th>";
	// $table_data_export.="<th>SAH</th>";
	// $table_data_export.="</tr>";
	
	// $sql="
	// select 
	// style,schedule,	color,	daten,	sum(output) as output,	sum(pan_send) as pan_send, sum(pan_receive) as pan_receive, sum(bundling) as bundling,	sum(bundleout) as bundleout,	sum(linein) as linein,	sum(rejected) as rejected,	sum(sah) as sah,	sum(cpk_qty) as cpk_qty, shift,module, operation,bundle_number, size
	// from 
	// (
	// SELECT  tbl_orders_style_ref_product_style AS style,tbl_orders_master_product_schedule AS SCHEDULE,tbl_miniorder_data_color AS color,DATE(bundle_transactions_date_time)  AS daten,
// SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
	// SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
	// SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
	// SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
	// SUM(IF(tbl_orders_ops_ref_operation_code='PS',bundle_transactions_20_repeat_quantity,0)) AS pan_send,
	// SUM(IF(tbl_orders_ops_ref_operation_code='PR',bundle_transactions_20_repeat_quantity,0)) AS pan_receive,
	// SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_rejection_quantity,0)) AS rejected,
	
	// 0 AS cpk_qty,
	// ROUND(SUM(ROUND(sah,2)),2) AS sah,
	// tbl_shifts_master_shift_name as shift,bundle_transactions_20_repeat_act_module as module,
	// tbl_orders_ops_ref_operation_code as operation,
	// tbl_miniorder_data_bundle_number as bundle_number,
	// size_disp as size
// FROM `$view_set_snap_1_tbl` 
// WHERE 1=1 and bundle_transactions_20_repeat_operation_id<>'5' and (DATE(bundle_transactions_date_time) between '$sdate' and '$edate' ) AND tbl_orders_master_product_schedule>0 
// GROUP BY tbl_miniorder_data_bundle_number,tbl_orders_ops_ref_operation_code,DATE(bundle_transactions_date_time),bundle_transactions_20_repeat_act_module,tbl_shifts_master_shift_name
// ) as tmp where 1=1 ".$filter_query." group by bundle_number,operation,daten,module,shift order by daten";
echo $sql;
	// $sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	echo mysqli_num_rows($sql_result)."<br>";
	// while($sql_row=mysql_fetch_array($sql_result))
	// {
		
		// $style=$sql_row['style'];	$schedule=$sql_row['schedule'];	$color=$sql_row['color'];	$daten=$sql_row['daten'];	$output=$sql_row['output'];	$bundling=$sql_row['bundling'];	$bundleout=$sql_row['bundleout'];	$linein=$sql_row['linein'];	$rejected=$sql_row['rejected'];	$sah=$sql_row['sah'];	$cpk_qty=$sql_row['cpk_qty']; $module=$sql_row['module']; $shift=$sql_row['shift']; $operation=$sql_row['operation']; $bundle_number=$sql_row['bundle_number']; $bundle_number=$sql_row['bundle_number']; $size=$sql_row['size'];
		// $pan_send=$sql_row['pan_send'];$pan_receive=$sql_row['pan_receive'];
		// $table_data.="<tr>";
		// $table_data.="<td>$daten</td>";
		// $table_data.="<td>$module</td>";
		// $table_data.="<td>$shift</td>";
		// $table_data.="<td>$operation</td>";
		// $table_data.="<td><span style=\"cursor: pointer; cursor: hand; color:blue;\" onclick=\"Popup=window.open('popup.php?style=$style','Popup2','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$style</span></td>";
		// $table_data.="<td><span style=\"cursor: pointer; cursor: hand; color:blue;\" onclick=\"Popup=window.open('popup.php?schedule=$schedule','Popup2','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$schedule</span></td>";
		// $table_data.="<td>$color</td>";
		// $table_data.="<td>$size</td>";
		// $table_data.="<td>$bundle_number</td>";
		// $table_data.="<td>$bundling</td>";
		// $table_data.="<td>$pan_send</td>";
		// $table_data.="<td>$pan_receive</td>";
		// $table_data.="<td>$bundleout</td>";
		// $table_data.="<td>$linein</td>";
		// $table_data.="<td>$output</td>";
		// $table_data.="<td>$rejected</td>";
		// $table_data.="<td>$cpk_qty</td>";
		// $table_data.="<td>".$sah."</td>";
		// $table_data.="</tr>";
		
		// $table_data_export.="<tr>";
		// $table_data_export.="<td>$daten</td>";
		// $table_data_export.="<td>$module</td>";
		// $table_data_export.="<td>$shift</td>";
		// $table_data_export.="<td>$operation</td>";
		// $table_data_export.="<td>$style</td>";
		// $table_data_export.="<td>$schedule</td>";
		// $table_data_export.="<td>$color</td>";
		// $table_data_export.="<td>$size</td>";
		// $table_data_export.="<td>$bundle_number</td>";
		// $table_data_export.="<td>$bundling</td>";
		// $table_data_export.="<td>$pan_send</td>";
		// $table_data_export.="<td>$pan_receive</td>";
		// $table_data_export.="<td>$bundleout</td>";
		// $table_data_export.="<td>$linein</td>";
		// $table_data_export.="<td>$output</td>";
		// $table_data_export.="<td>$rejected</td>";
		// $table_data_export.="<td>$cpk_qty</td>";
		// $table_data_export.="<td>".$sah."</td>";
		// $table_data_export.="</tr>";

	// }

	// $table_data.="</table>";
	// $table_data_export.="</table>";
	// echo $table_data;
	// $export_rep_name="Day_wise_Bundle_Performance_";
	// }


// if($report_type==4)
	// {
	// $table_data="";
	// $table_data.="<h2>Module wise Production WIP</h2>";	
	// $table_data.="<h3>$title</h3>";
	// $table_data.="<table id='table_format'>";
	// $table_data.="<tr>";
	// $table_data.="<th>Date</th>";
	// $table_data.="<th>Module</th>";
	// $table_data.="<th>Style</th>";
	// $table_data.="<th>Schedule</th>";
	// $table_data.="<th>Color</th>";
	// $table_data.="<th>Size</th>";
	// $table_data.="<th>Mini-Order Number</th>";
	// $table_data.="<th>Bundle Number</th>";
	// $table_data.="<th>Line In</th>";
	
	// $table_data.="<th>Age</th>";
	// $table_data.="</tr>";
	
	// $table_data_export="";
	// $table_data_export.="<h2>Module wise Production WIP</h2>";	
	// $table_data_export.="<h3>$title</h3>";
	// $table_data_export.="<table id='table_format'>";
	// $table_data_export.="<tr>";
	// $table_data_export.="<th>Date</th>";
	// $table_data_export.="<th>Module</th>";
	// $table_data_export.="<th>Style</th>";
	// $table_data_export.="<th>Schedule</th>";
	// $table_data_export.="<th>Color</th>";
	// $table_data_export.="<th>Size</th>";
	// $table_data_export.="<th>Mini-Order Number</th>";
	// $table_data_export.="<th>Bundle Number</th>";
	// $table_data_export.="<th>Line In</th>";
	
	// $table_data_export.="<th>Age</th>";
	// $table_data_export.="</tr>";
	
	// $sql="
	// SELECT *,DATEDIFF(NOW(),daten) AS age FROM 
// (
// SELECT 
// MAX(IF(tbl_orders_ops_ref_operation_code='LNI',DATE(bundle_transactions_date_time),0)) AS daten,LEFT(bundle_transactions_date_time,7) AS monthn,MAX(bundle_transactions_20_repeat_act_module) AS module,
// tbl_orders_master_product_schedule,tbl_orders_style_ref_product_style,tbl_miniorder_data_color,size_disp,tbl_miniorder_data_mini_order_num,tbl_miniorder_data_bundle_number,
// SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
// SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS input,
// SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_rejection_quantity,0)) AS rejected

// FROM $view_set_snap_1_tbl WHERE 1=1 and bundle_transactions_20_repeat_operation_id<>'5' and tbl_orders_ops_ref_operation_code in ('LNO','LNI') AND (tbl_orders_master_product_schedule IS NOT NULL) AND tbl_orders_master_product_schedule>0 

// GROUP BY tbl_miniorder_data_bundle_number ORDER BY DATE(bundle_transactions_date_time) DESC
// ) AS tmp WHERE input>0 AND (output+rejected)<>input ORDER BY module,daten";
echo $sql;
	// $sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	// while($sql_row=mysql_fetch_array($sql_result))
	// {
		
		// $daten=$sql_row['daten'];	$monthn=$sql_row['monthn'];	$module=$sql_row['module'];	$schedule=$sql_row['tbl_orders_master_product_schedule']; $style=$sql_row['tbl_orders_style_ref_product_style'];	$color=$sql_row['tbl_miniorder_data_color'];	$size=$sql_row['size_disp'];	$tbl_miniorder_data_mini_order_num=$sql_row['tbl_miniorder_data_mini_order_num'];	$tbl_miniorder_data_bundle_number=$sql_row['tbl_miniorder_data_bundle_number'];	$output=$sql_row['output'];	$linein=$sql_row['input'];	$rejected=$sql_row['rejected'];	$age=$sql_row['age'];



		// $table_data.="<tr>";
		// $table_data.="<td>$daten</td>";
		// $table_data.="<td>$module</td>";
		// $table_data.="<td><span style=\"cursor: pointer; cursor: hand; color:blue;\" onclick=\"Popup=window.open('popup.php?style=$style','Popup2','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$style</span></td>";
		// $table_data.="<td><span style=\"cursor: pointer; cursor: hand; color:blue;\" onclick=\"Popup=window.open('popup.php?schedule=$schedule','Popup2','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$schedule</span></td>";
		// $table_data.="<td>$color</td>";
		// $table_data.="<td>$size</td>";
		// $table_data.="<td>$tbl_miniorder_data_mini_order_num</td>";
		// $table_data.="<td>$tbl_miniorder_data_bundle_number</td>";
		// $table_data.="<td>$linein</td>";
		
		// $table_data.="<td>".$age."</td>";
		// $table_data.="</tr>";
		
		// $table_data_export.="<tr>";
		// $table_data_export.="<td>$daten</td>";
		// $table_data_export.="<td>$module</td>";
		// $table_data_export.="<td>$style</td>";
		// $table_data_export.="<td>$schedule</td>";
		// $table_data_export.="<td>$color</td>";
		// $table_data_export.="<td>$size</td>";
		// $table_data_export.="<td>$tbl_miniorder_data_mini_order_num</td>";
		// $table_data_export.="<td>$tbl_miniorder_data_bundle_number</td>";
		// $table_data_export.="<td>$linein</td>";
		
		// $table_data_export.="<td>".$age."</td>";
		// $table_data_export.="</tr>";

	// }

	// $table_data.="</table>";
	// $table_data_export.="</table>";
	// echo $table_data;
	// $export_rep_name="Module_wise_Production_WIP_";
	// }


// if($report_type==5)
	// {
	
	// if(isset($_REQUEST['snap_ids']))
	// {
		
	
	$table_data="";
	$table_data.="<h2>Schedule wise Carton Pack WIP </h2>";	
	$table_data.="<h4>LU: ".date("Y-d-m H:i:s")." </h4>";	
	$table_data.="<h3>$title</h3>";
	$table_data.="<table id='table_format'>";
	$table_data.="<tr>";
	$table_data.="<th>Style</th>";
	$table_data.="<th>Schedule</th>";
	$table_data.="<th>Country Block</th>";
	$table_data.="<th>Ratio</th>";
	$table_data.="<th>Order Cartons</th>";
	$table_data.="<th>Produced Cartons</th>";
	$table_data.="<th>FG Cartons</th>";
	$table_data.="<th>Packing Balances (PCS)</th>";
	$table_data.="<th>Packing Balances (Cartons)</th>";
	$table_data.="</tr>";
	
	$table_data_export="";
	$table_data_export.="<h2>Schedule wise Carton Pack WIP</h2>";	
	$table_data_export.="<h4>LU: ".date("Y-d-m H:i:s")." </h4>";	
	$table_data_export.="<h3>$title</h3>";
	$table_data_export.="<table id='table_format'>";
	$table_data_export.="<tr>";
	$table_data_export.="<th>Style</th>";
	$table_data_export.="<th>Schedule</th>";
	$table_data_export.="<th>Country Block</th>";
	$table_data_export.="<th>Ratio</th>";
	$table_data_export.="<th>Order Cartons</th>";
	$table_data_export.="<th>Produced Cartons</th>";
	$table_data_export.="<th>FG Cartons</th>";
	$table_data_export.="<th>Packing Balances (PCS)</th>";
	$table_data_export.="<th>Packing Balances (Cartons)</th>";
	$table_data_export.="</tr>";
	
	
	//old version
/*	$sql="
	SELECT tbl_orders_style_ref_product_style,tbl_orders_master_product_schedule,MAX(order_carts) AS order_carts,MIN(cpk_carts) AS fg_carts,
MIN(prod_carts) AS prod_carts,SUM(pack_balances) AS pac_bal_pcs, MIN(prod_carts)-MIN(cpk_carts) AS pack_cart_balance FROM 
(
SELECT *,view_set_7.quantity AS quantity2,
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
FROM $view_set_snap_1_tbl WHERE tbl_orders_master_product_schedule IS NOT NULL GROUP BY order_id ) AS tmp LEFT JOIN $view_set_6_snap ON CONCAT(TRIM(BOTH FROM tmp.schedule),TRIM(BOTH FROM tmp.color),TRIM(BOTH FROM tmp.size))=CONCAT(TRIM(BOTH FROM $view_set_6_snap.schedule),TRIM(BOTH FROM $view_set_6_snap.color),TRIM(BOTH FROM $view_set_6_snap.size)) GROUP BY CONCAT(tmp.schedule,tmp.color,tmp.size)
) AS tmp2 

LEFT JOIN 

view_set_7 ON tmp2.order_id=view_set_7.ref_id

WHERE 1=1 AND tbl_orders_master_product_schedule IS NOT NULL
) AS chk GROUP BY tbl_orders_master_product_schedule  HAVING MAX(order_carts)>MIN(cpk_carts) AND MIN(prod_carts)-MIN(cpk_carts)>0"; */
//echo $sql;

//New version to show cb8, ratio, country blog.


$sql="SELECT * 
FROM
(	
	SELECT style as tbl_orders_style_ref_product_style,SCHEDULE as tbl_orders_master_product_schedule,c_block,IF(SUBSTRING(c_block,1,3)='CB8' ,MAX(ratio),SUM(ratio)) AS ratio,SUM(order_cart) AS order_carts,SUM(prod_cart) AS prod_carts,SUM(fg_carton) AS fg_carts,
	SUM(packing_bal) AS pac_bal_pcs,SUM(pack_carton) AS pack_cart_balance
	FROM
	(
		SELECT style,SCHEDULE,c_block,barcode,SUM(ratio) AS ratio,MIN(order_carton) AS order_cart,MIN(prod_carton) AS prod_cart,MIN(fg_carton) AS fg_carton,
		SUM(pack_balances) AS packing_bal,MIN(prod_carton)-MIN(fg_carton) AS pack_carton,prod_bal AS prod_bal
		FROM 
		(
			SELECT *,
			ROUND((cpk_qty)/ratio,0) AS fg_carton,
			output-cpk_qty AS pack_balances,
			order_qty-output AS prod_bal 
			FROM 
			(
				SELECT tmp.style,tmp.schedule,tmp.color,tmp.size_disp,tmp.quantity AS order_qty,tmp.output,tmp.barcode,tmp.ims_qty AS ratio,
				tmp.c_block,
				ROUND((tmp.quantity)/tmp.ims_qty,0) AS order_carton,
				ROUND((tmp.output)/tmp.ims_qty,0) AS prod_carton,
				IF(($view_set_6_snap.cpk_qty<>'' && $view_set_6_snap.cpk_qty<>'0'),SUM($view_set_6_snap.cpk_qty),0) AS cpk_qty,tmp.smv
				FROM 
				(
					SELECT `tbl_orders_style_ref_product_style` AS style,
					`tbl_orders_master_product_schedule` AS SCHEDULE,`tbl_miniorder_data_color` AS color,`size_disp`,
					tbl_orders_sizes_master_order_quantity AS quantity,
					SUM(bundle_transactions_20_repeat_rejection_quantity) AS rejected,
					SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,view_set_2_snap_smv AS smv,
					iu.barcode,iu.ims_qty,iu.c_block
					FROM $view_set_snap_1_tbl 
					LEFT JOIN  
					bai3_finishing.input_update AS iu 
					ON iu.schedule=tbl_orders_master_product_schedule AND 
					iu.color=tbl_miniorder_data_color AND iu.size=size_disp 
					WHERE iu.ims_qty!='0' GROUP BY 
					`tbl_orders_master_product_schedule`,`tbl_miniorder_data_color`,`size_disp`
				) AS tmp LEFT JOIN `$view_set_6_snap` ON $view_set_6_snap.schedule=tmp.schedule AND
				$view_set_6_snap.color=tmp.color AND $view_set_6_snap.size=tmp.size_disp
				GROUP BY tmp.schedule,tmp.color,tmp.size_disp
			) AS tmp2
		) AS tmp3 GROUP BY tmp3.schedule,tmp3.barcode
	) AS tmp4 GROUP BY tmp4.schedule
) AS tmp5 WHERE order_carts>fg_carts AND prod_carts-fg_carts>0	";

	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		
		$style=$sql_row['tbl_orders_style_ref_product_style'];	$schedule=$sql_row['tbl_orders_master_product_schedule'];	$order_carts=$sql_row['order_carts'];	$fg_carts=$sql_row['fg_carts'];	$prod_carts=$sql_row['prod_carts'];	$pac_bal_pcs=$sql_row['pac_bal_pcs'];	$pack_cart_balance=$sql_row['pack_cart_balance']; $ratio=$sql_row['ratio']; $c_block=$sql_row['c_block'];


		$table_data.="<tr>";

		$table_data.="<td><span style=\"cursor: pointer; cursor: hand; color:blue;\" onclick=\"Popup=window.open('popup.php?style=$style','Popup2','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$style</span></td>";
		$table_data.="<td><span style=\"cursor: pointer; cursor: hand; color:blue;\" onclick=\"Popup=window.open('popup.php?schedule=$schedule','Popup2','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$schedule</span></td>";
		$table_data.="<td>$c_block</td>";
		$table_data.="<td>$ratio</td>";
		$table_data.="<td>$order_carts</td>";
		$table_data.="<td>$prod_carts</td>";
		$table_data.="<td>$fg_carts</td>";
		$table_data.="<td>$pac_bal_pcs</td>";
		$table_data.="<td>".$pack_cart_balance."</td>";
		$table_data.="</tr>";
		
		$table_data_export.="<tr>";

		$table_data_export.="<td>$style</td>";
		$table_data_export.="<td>$schedule</td>";
		$table_data_export.="<td>$c_block</td>";
		$table_data_export.="<td>$ratio</td>";
		$table_data_export.="<td>$order_carts</td>";
		$table_data_export.="<td>$prod_carts</td>";
		$table_data_export.="<td>$fg_carts</td>";
		$table_data_export.="<td>$pac_bal_pcs</td>";
		$table_data_export.="<td>".$pack_cart_balance."</td>";
		$table_data_export.="</tr>";

	}

	$table_data.="</table>";
	$table_data_export.="</table>";
	echo $table_data;
	$export_rep_name="Schedule_wise_Carton_Pack_WIP_";
	// }
	// else
	// {
		// echo '	<script type="text/javascript">            function Redirect() {
               // window.location="cpk_report_5.html";
            // }
// Redirect();
      // </script>';
	// }
	
	// }
	
	// if($report_type==6)
	// {
	// if(isset($_REQUEST['snap_ids1']))
	// {
	
	// $table_data="";
	// $table_data.="<h2>Style & Color wise Inlay WIP </h2>";	
	// $table_data.="<h4>LU: ".date("Y-d-m H:i:s")." </h4>";	
	// $table_data.="<h3>$title</h3>";
	// $table_data.="<table id='table_format'>";
	// $table_data.="<tr>";
	// $table_data.="<th>Style</th>";
	// $table_data.="<th>Color</th>";
	// $table_data.="<th>Size</th>";
	// $table_data.="<th>Order Quantity</th>";
	// $table_data.="<th>Bundling In</th>";
	// $table_data.="<th>Bundle Out</th>";
	// $table_data.="<th>Line In</th>";
	// $table_data.="<th>Line Out</th>";
	// $table_data.="<th>Rejection BTS</th>";
	// $table_data.="<th>Carton Packed</th>";
	// $table_data.="<th>Inlay WIP</th>";
	// $table_data.="</tr>";
	
	// $table_data_export="";
	// $table_data_export.="<h2>Style & Color wise Inlay WIP </h2>";	
	// $table_data_export.="<h4>LU: ".date("Y-d-m H:i:s")." </h4>";	
	// $table_data_export.="<h3>$title</h3>";
	// $table_data_export.="<table id='table_format'>";
	// $table_data_export.="<tr>";
	// $table_data_export.="<th>Style</th>";
	// $table_data_export.="<th>Color</th>";
	// $table_data_export.="<th>Size</th>";
	// $table_data_export.="<th>Order Quantity</th>";
	// $table_data_export.="<th>Bundling In</th>";
	// $table_data_export.="<th>Bundle Out</th>";
	// $table_data_export.="<th>Line In</th>";
	// $table_data_export.="<th>Line Out</th>";
	// $table_data_export.="<th>Rejection BTS</th>";
	// $table_data_export.="<th>Carton Packed</th>";
	// $table_data_export.="<th>Inlay WIP</th>";
	// $table_data_export.="</tr>";
	// $sql="SELECT tmp.style,tmp.color,tmp.size_disp,tmp.bun,tmp.bno,tmp.input,
	// tmp.output,tmp.reject_bts,sum(view_set_6_snap.cpk_qty) as cpk_qty
	// FROM 
	// (
	// SELECT `tbl_orders_style_ref_product_style` AS style,
	// `tbl_miniorder_data_color` AS color,`size_disp`,
	// SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bun,
	// SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bno,
	// SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS input,
	// SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
	// SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_rejection_quantity,0)) AS reject_bts
	// FROM view_set_snap_1_tbl where tbl_orders_style_ref_product_style <>''
	 // GROUP BY `tbl_orders_style_ref_product_style`,`tbl_miniorder_data_color`,`size_disp` 
	// ORDER BY color,tbl_orders_size_ref_size_name
	// ) AS tmp LEFT JOIN `view_set_6_snap` ON TRIM(view_set_6_snap.style)=TRIM(tmp.style) AND
	// view_set_6_snap.color=tmp.color AND view_set_6_snap.size=tmp.size_disp GROUP BY tmp.style,tmp.color,tmp.size_disp";

	// $sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	// while($sql_row=mysql_fetch_array($sql_result))
	// {
		
		// $style=$sql_row['style'];
	// $color=$sql_row['color'];		$size_disp=$sql_row['size_disp'];	$order_qty=$sql_row['order_qty'];	$bun=$sql_row['bun'];	$bno=$sql_row['bno'];	$input=$sql_row['input']; $output=$sql_row['output']; $cpk_qty=$sql_row['cpk_qty']; $rejected=$sql_row['reject_bts']; 
	// if($cpk_qty=='')
	// {
		// $cpk_qty=0;
	// }
	// $order_qty=echo_title("brandix_bts_uat.view_set_2_snap","sum(distinct tbl_orders_sizes_master_order_quantity)","tbl_orders_sizes_master_order_col_des='".$color."' and tbl_orders_sizes_master_size_title='".$size_disp."' and tbl_orders_style_ref_product_style",$style,$link);


		// $table_data.="<tr>";
		// $table_data.="<td>$style</td>";
		// $table_data.="<td>$color</td>";
		// $table_data.="<td>$size_disp</td>";
		// $table_data.="<td>$order_qty</td>";
		// $table_data.="<td>$bun</td>";
		// $table_data.="<td>$bno</td>";
		// $table_data.="<td>$input</td>";
		// $table_data.="<td>$output</td>";
		// $table_data.="<td>$rejected</td>";
		// $table_data.="<td>$cpk_qty</td>";
		// $table_data.="<td>".($output-$cpk_qty)."</td>";
		// $table_data.="</tr>";
		
		// $table_data_export.="<tr>";

		// $table_data_export.="<td>$style</td>";
		// $table_data_export.="<td>$color</td>";
		// $table_data_export.="<td>$size_disp</td>";
		// $table_data_export.="<td>$order_qty</td>";
		// $table_data_export.="<td>$bun</td>";
		// $table_data_export.="<td>$bno</td>";
		// $table_data_export.="<td>$input</td>";
		// $table_data_export.="<td>$output</td>";
		// $table_data_export.="<td>$rejected</td>";
		// $table_data_export.="<td>$cpk_qty</td>";
		// $table_data_export.="<td>".($output-$cpk_qty)."</td>";
		// $table_data_export.="</tr>";

	// }
	

	// $table_data.="</table>";
	// $table_data_export.="</table>";
	// echo $table_data;
	// $export_rep_name="Style_color_Inlay_Pack_WIP_";
	// }
	// else
	// {
		// echo '	<script type="text/javascript">            function Redirect() {
               // window.location="cpk_report_6.html";
            // }
// Redirect();
      // </script>';
	// }
	// }
	
	// if($report_type==7)
	// {
		// $table_data="";
	// $table_data.="<h2>Style & Color wise Embellishment</h2>";	
	// $table_data.="<h3>$title</h3>";
	// $table_data.="<table id='table_format'>";
	// $table_data.="<tr>";
	// $table_data.="<th>Date</th>";
	// $table_data.="<th>Style</th>";
	// $table_data.="<th>Schedule</th>";
	// $table_data.="<th>Color</th>";
	// $table_data.="<th>Size</th>";
	// $table_data.="<th>Mini-Order Number</th>";
	// $table_data.="<th>Panel Sent</th>";
	// $table_data.="<th>Panel Receive</th>";
	// $table_data.="<th>Bundle Out</th>";
	// $table_data.="<th>WIP</th>";
	// $table_data.="<th>Rejections</th>";
	// $table_data.="<th>Reason</th>";
	// $table_data.="</tr>";
	
	// $table_data_export="";
	// $table_data_export.="<h2>Style & Color wise Embellishment</h2>";	
	// $table_data_export.="<h3>$title</h3>";
	// $table_data_export.="<table id='table_format'>";
	// $table_data_export.="<tr>";
	// $table_data_export.="<th>Date</th>";
	// $table_data_export.="<th>Style</th>";
	// $table_data_export.="<th>Schedule</th>";
	// $table_data_export.="<th>Color</th>";
	// $table_data_export.="<th>Size</th>";
	// $table_data_export.="<th>Mini-Order Number</th>";
	// $table_data_export.="<th>Panel Sent</th>";
	// $table_data_export.="<th>Panel Receive</th>";
	// $table_data_export.="<th>Bundle Out</th>";
	// $table_data_export.="<th>WIP</th>";
	// $table_data_export.="<th>Print Before Rejections</th>";
	// $table_data_export.="<th>Print After Rejections</th>";
	// $table_data_export.="<th>Rejections</th>";
	// $table_data_export.="</tr>";
	// $schedule_no=array();
	// $sql="SELECT * FROM brandix_bts.tbl_orders_master where emb_status='1'";
	// $sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	// while($sql_row=mysql_fetch_array($sql_result))
	// {
		// $schedule_no[]=$sql_row['product_schedule'];
	// }
	// $sql="
// SELECT 
// tbl_orders_master_product_schedule,tbl_orders_style_ref_product_style,tbl_miniorder_data_color,size_disp,tbl_miniorder_data_mini_order_num,
// SUM(IF(tbl_orders_ops_ref_operation_code='PS',bundle_transactions_20_repeat_quantity,0)) AS panel_sent,
// SUM(IF(tbl_orders_ops_ref_operation_code='PR',bundle_transactions_20_repeat_quantity,0)) AS panel_receive,
// SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundle_out
// FROM $view_set_snap_1_tbl WHERE 1=1 and tbl_orders_ops_ref_operation_code in ('PS','PR','BUO') AND tbl_orders_master_product_schedule in (".implode(",",$schedule_no).") 
// GROUP BY tbl_orders_master_product_schedule,tbl_orders_style_ref_product_style,tbl_miniorder_data_color,size_disp,tbl_miniorder_data_mini_order_num ORDER BY tbl_orders_style_ref_product_style,tbl_orders_master_product_schedule,tbl_miniorder_data_color,size_disp,tbl_miniorder_data_mini_order_num DESC
// ";
// echo $sql;
	// $sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	// while($sql_row=mysql_fetch_array($sql_result))
	// {
		
		// $schedule=$sql_row['tbl_orders_master_product_schedule']; 
		// $style=$sql_row['tbl_orders_style_ref_product_style'];	
		// $color=$sql_row['tbl_miniorder_data_color'];	
		// $size=$sql_row['size_disp'];	
		// $tbl_miniorder_data_mini_order_num=$sql_row['tbl_miniorder_data_mini_order_num'];	
		
		// $panel_receive=$sql_row['panel_receive'];	
		// $panel_sent=$sql_row['panel_sent'];	
		// $bundle_out=$sql_row['bundle_out'];	
		
		// $rejected_ps=$sql_row['reject_ps'];
		// $rejected_pr=$sql_row['reject_pr'];
		// $daten=$sql_row['daten'];



		// $table_data.="<tr>";
		// $table_data.="<td>$daten</td>";
		// $table_data.="<td><span style=\"cursor: pointer; cursor: hand; color:blue;\" onclick=\"Popup=window.open('popup.php?style=$style','Popup2','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$style</span></td>";
		// $table_data.="<td><span style=\"cursor: pointer; cursor: hand; color:blue;\" onclick=\"Popup=window.open('popup.php?schedule=$schedule','Popup2','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$schedule</span></td>";
		// $table_data.="<td>$color</td>";
		// $table_data.="<td>$size</td>";
		// $table_data.="<td>$tbl_miniorder_data_mini_order_num</td>";
		// $table_data.="<td>$panel_sent</td>";
		// $table_data.="<td>$panel_receive</td>";
		// $table_data.="<td>$bundle_out</td>";
		// $table_data.="<td>".($panel_receive-$bundle_out)."</td>";
		// $table_data.="<td>0</td>";
		// $table_data.="<td>$rejected_pr</td>";
		// $table_data.="</tr>";
		
		
		// $table_data_export.="<tr>";
		// $table_data_export.="<td>$daten</td>";
		// $table_data_export.="<td>$style</td>";
		// $table_data_export.="<td>$schedule</td>";
		// $table_data_export.="<td>$color</td>";
		// $table_data_export.="<td>$size</td>";
		// $table_data_export.="<td>$tbl_miniorder_data_mini_order_num</td>";
		// $table_data_export.="<td>$panel_sent</td>";
		// $table_data_export.="<td>$panel_receive</td>";
		// $table_data_export.="<td>$bundle_out</td>";
		// $table_data_export.="<td>".($panel_receive-$bundle_out)."</td>";
		// $table_data_export.="<td>0</td>";		
		// $table_data_export.="<td>$rejected_ps</td>";
		// $table_data_export.="<td>$rejected_pr</td>";
		// $table_data_export.="</tr>";

	// }

	// $table_data.="</table>";
	// $table_data_export.="</table>";
	// echo $table_data;
	// $export_rep_name="Style & Color wise Embellishment_";
	// }
?>
<?php
if(mysqli_num_rows($sql_result)<=1000)
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
<input type="hidden" name="table" value="<?php echo $table_data_export; ?>">
<input type="hidden" name="file_name" value="<?php echo $export_rep_name.date("Ymd");?>">
<input type="submit" name="submit" value="Export to Excel">
</form>
</div>

<script type="text/javascript">
 
       document.getElementById("msg").style.display = 'none';
</script>
<?php
// }
?>
</body>
</html>

<?php
// if(isset($_REQUEST['snap_ids']))
// {
//$cachefile = $cache_date.".html";
// open the cache file "cache/home.html" for writing
$fp = fopen($cachefile, 'w');
// save the contents of output buffer to the file
fwrite($fp, ob_get_contents());
// close the file
fclose($fp);
// Send the output to the browser
ob_end_flush();

// echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
// }
// if(isset($_REQUEST['snap_ids1']))
// {
// $cachefile = $cache_date.".html";
// open the cache file "cache/home.html" for writing
// $fp = fopen($cachefile, 'w');
// save the contents of output buffer to the file
// fwrite($fp, ob_get_contents());
// close the file
// fclose($fp);
// Send the output to the browser
// ob_end_flush();

// echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
// }
?>
