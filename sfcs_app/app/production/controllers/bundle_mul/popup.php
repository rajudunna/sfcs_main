<html>
<head>
<title>Module Scanning Report</title>
<style type="text/css" media="screen">

/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
body{ 
	margin:0px; padding:0px; border:0px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:12px; 
}

caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable1{
	font-size:12px;
}
th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;}
</style>
</head>
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>
<body>

<div id="page_heading"><span style="float: left"><h3>Bundle wise reconciliation Report</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>

<?php

include "dbconf.php";
$sch=$_GET['schedule'];
$mini_num=$_GET['mini_num'];
	$table_data="";
$table_data.="<h2>Bundle Wise Performance Report</h2>";
$table_data.="<table id='table_format'>";
$table_data.="<tr>";
$table_data.="<th>Style</th>";
$table_data.="<th>Schedule</th>";
$table_data.="<th>Mini-Order Number</th>";
$table_data.="<th>Color</th>";
$table_data.="<th>Size</th>";
$table_data.="<th>Bundle Number</th>";
$table_data.="<th>Module</th>";
$table_data.="<th>Bundle quantity</th>";
$table_data.="<th>Bundling</th>";
$table_data.="<th>Bundle Out</th>";
$table_data.="<th>Line In</th>";
$table_data.="<th>Line Out</th>";
$table_data.="<th>Rejection</th>";
$table_data.="<th>Production Status</th>";
$table_data.="</tr>";
$sql="
SELECT 
tbl_orders_master_product_schedule,size_disp,tbl_miniorder_data_color,tbl_orders_style_ref_product_style,tbl_miniorder_data_mini_order_num,tbl_miniorder_data_bundle_number,
SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
SUM(bundle_transactions_20_repeat_rejection_quantity) AS rejected,
max(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_module_id,0)) AS module
FROM $view_set_snap_1_tbl 
WHERE tbl_orders_master_product_schedule='".$sch."' and tbl_miniorder_data_mini_order_num='".$mini_num."' GROUP BY tbl_orders_master_product_schedule,tbl_miniorder_data_mini_order_num,tbl_miniorder_data_bundle_number,tbl_miniorder_data_color,size_disp order by tbl_orders_master_product_schedule,tbl_miniorder_data_mini_order_num,tbl_miniorder_data_bundle_number,tbl_miniorder_data_color,size_disp";
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
	$tbl_miniorder_data_mini_order_num=$sql_row['tbl_miniorder_data_mini_order_num'];
	$tbl_miniorder_data_bundle_number=$sql_row['tbl_miniorder_data_bundle_number'];
	$rejected=$sql_row['rejected'];
	
	$table_data.="<tr>";
	$table_data.="<td>$tbl_orders_style_ref_product_style</td>";
	$table_data.="<td>$tbl_orders_master_product_schedule</td>";
	$table_data.="<td>$tbl_miniorder_data_mini_order_num</td>";
	$table_data.="<td>$tbl_miniorder_data_color</td>";
	$table_data.="<td>$size_disp</td>";
	$table_data.="<td>$tbl_miniorder_data_bundle_number</td>";
	$table_data.="<td>$module</td>";
	$table_data.="<td>$order_qty</td>";
	$table_data.="<td >$bundling</td>";
	$table_data.="<td>$bundleout</td>";
	$table_data.="<td >$linein</td>";
	$table_data.="<td>$output</td>";
	$table_data.="<td>$rejected</td>";
		
	$table_data.="<td>".(($output+$rejected)>=$order_qty?"Completed":"Pending")."</td>";
	$table_data.="</tr>";

}

$table_data.="</table>";
echo $table_data;
//$export_rep_name="Bundle_Wise_Performance_Report_";
?>
<body>
</html>