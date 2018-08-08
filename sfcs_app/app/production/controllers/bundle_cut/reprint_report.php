<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="js/style.css">
<link rel="stylesheet" type="text/css" href="table.css">
<style type="text/css">
#div-1a {
 position:absolute;
 top:65px;
 right:0;
 width:auto;
float:right;
table {
    float:left;
    width:33%;
}
</style>
<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
body{ 
	/* margin:15px; padding:15px; border:1px solid #666; */
	font-family:Arial, Helvetica, sans-serif; font-size:88%; 
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px;  padding:5px; background-color:#f4f4f4; solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; outset #f4f4f4; margin:2px; }
.mytable th{ background-color:#29759c; color:#FFF; padding:2px; solid #ccc; white-space: nowrap;}
td{ padding:2px; white-space: nowrap;}
</style>
<script language="javascript" type="text/javascript" src="TableFilter_EN/actb.js"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="TableFilter_EN/tablefilter.js"></script>



<script language="javascript" type="text/javascript">
function firstbox()
{
	//alert("report");
	var ajax_url ="../mini_order_report/mini_order_report.php?style="+document.mini_order_report.style.value;
	Ajaxify(ajax_url);

}

function secondbox()
{
	//alert('test');
	//window.location.href ="../mini-orders/excel-export?style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
}

function check_val()
{
	//alert('dfsds');
	var sdate=document.getElementById('demo1').value;
	var edate=document.getElementById('demo2').value;
	//alert(edate);
	//alert(c_block);
	//alert(schedule);
	if(sdate=>edate)
	{
		alert('Please select the values');
		return false;
	}
		
}

</script>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="page_heading"><span style="float: left"><h3>Day wise re-print Report</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>
<?php include("dbconf.php"); ?>

<?php
include($_SERVER['DOCUMENT_ROOT']."server/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."server/group_def.php");
$view_access=user_acl("SFCS_0252",$username,1,$group_id_sfcs); 
//$database="brandix_bts";
//$user="baiall";
//$password="baiall";
//$host="baidevsrv1:3307";

$link = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect: " . mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));
error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);


//echo $style.$schedule.$color;
?>

<form name="mini_order_report" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit=" return check_val();">
<br>
<table><tr><td>
Start Date: <input id="demo1" onclick="javascript:NewCssCal('demo1','yyyymmdd','dropdown')" type="text" name="sdate" size="8" value="<?php if(isset($_REQUEST['sdate'])) { echo $_REQUEST['sdate']; } else { echo date("Y-m-d"); } ?>"> End Date: <input id="demo2" onclick="javascript:NewCssCal('demo2','yyyymmdd','dropdown')" type="text" size="8" name="edate" value="<?php if(isset($_REQUEST['edate'])) { echo $_REQUEST['edate']; } else { echo date("Y-m-d"); } ?>"></td><td><input type="checkbox" name="check_list[]" value="1">Module <input type="checkbox" name="check_list[]" value="2">Employee <input type="checkbox" name="check_list[]" value="3">Shift</td> <td>


 <?php
	echo "<input type=\"submit\" value=\"submit\" name=\"submit\">";	
?>
</td></tr><table>

</form>


<?php
//$hours=array('6-7AM','7-8AM','8-9AM','9-10AM','10-11AM','11-12AM','12-13PM','13-14PM','14-15PM','15-16PM','16-17PM','17-18PM','18-19PM','19-20PM','20-21PM','21-22PM','22-23PM');
if(isset($_POST['submit']))
{
	$check_box=$_POST['check_list'];
	$filter='';
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	//echo sizeof($check_box)."<br>";
	//echo $_POST['sdate']."--".$_POST['edate']."--".$check_box[0]."--".$check_box[1]."--".$check_box[2]."<br>";
	if(sizeof($check_box)>0)
	{
		for($i=0;$i < sizeof($check_box);$i++)
		{
			//echo $check_box[$i]."<br>";
			if($check_box[$i]==1)
			{
				$filter.="module_id,";
			}
			else if($check_box[$i]==2)
			{
				$filter.="emp_id,";
			}
			else if($check_box[$i]==3)
			{
				$filter.="shift,";
			}
		}
	}
	else
	{
		//$filter.=",";
	}
	if(sizeof($check_box)>0)
	{
		$filter_n=",".substr($filter, 0, -1);  
	}
	else
	{
		$filter_n='';
	}
	
//echo $filter."<br>";
	$sql="SELECT date(date_time) as date_time,$filter bundle_id,user_name from brandix_bts.re_print_table where date(date_time)
BETWEEN '$sdate' AND '$edate' GROUP BY date_time $filter_n ORDER BY date_time";
//echo $sql."<br>";
	//$sets=explode(",",$filter_n);
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	echo "<br>";
	echo "<br>";
	echo "<table border='1px'><tr>";
	echo "<th>Date</th>";
	if(sizeof($check_box)>0)
	{
		for($i=0;$i < sizeof($check_box);$i++)
		{
			//echo $check_box[$i]."<br>";
			if($check_box[$i]==1)
			{
				echo "<th>Module</th>";
			}
			else if($check_box[$i]==2)
			{
				echo "<th>Employee</th>";
			}
			else if($check_box[$i]==3)
			{
				echo "<th>Shift</th>";
			}
			
		}
	}
	
	//echo "<th>Shift</th>";
	//for($i=0;$i<sizeof($hours);$i++)
	//{
	//	echo "<th>".$hours[$i]."</th>";
	//}
	echo "<th>Bundle Number</th>";
	echo "<th>Username</th></tr>";
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$date=$sql_row['date_time'];
		echo "<tr>";
		echo "<td>".$date."</td>";
		for($i=0;$i < sizeof($check_box);$i++)
		{
			//echo $check_box[$i]."<br>";
			if($check_box[$i]==1)
			{
				echo "<td>".$sql_row['module_id']."</td>";
			}
			else if($check_box[$i]==2)
			{
				echo "<td>".$sql_row['emp_id']."</td>";
			}
			else if($check_box[$i]==3)
			{
				echo "<td>".$sql_row['shift']."</td>";
			}
			
		}
		echo "<td>".$sql_row['bundle_id']."</td>";
		echo "<td>".$sql_row['user_name']."</td>";
		//for($i=0;$i<sizeof($hours);$i++)
		//{
		//	$val1=$hours[$i];
			//echo $sql_row[$val1]."<br>";
		//	echo "<td>".$sql_row[$val1]."</td>";
		//}
	//	$output=$sql_row['output'];
		//echo "<td>".$output."</td>";
		//$reject=$sql_row['rejection_bts'];
	//	echo "<td>".$reject."</td>";
		echo "</tr>";
	}
echo "</table>";
echo "<br>";
/*
//---------------------------------------------
echo "<h2>Style Schedule mini order summary details</h2>";
echo "<br>";
$sql="SELECT * FROM (
SELECT *, SUM(cpk_qty) AS cpk_qty_new, (output-SUM(cpk_qty)) AS cpkbalance, (order_qty-output) AS prodbalance  FROM (
SELECT DISTINCT tbl_orders_style_ref_product_style, SUM(output) AS output,SUM(order_qty) AS order_qty,COUNT(DISTINCT tbl_orders_master_product_schedule) AS schedulecount,order_div
,MIN(runningsince) AS runningsince
 FROM (
SELECT tbl_orders_style_ref_product_style, 
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
AVG(tbl_orders_sizes_master_order_quantity) AS order_qty,
tbl_orders_master_product_schedule,
MIN(DATE(bundle_transactions_date_time)) AS runningsince, order_div
FROM $view_set_snap_1_tbl GROUP BY order_id
) AS tmp GROUP BY tbl_orders_style_ref_product_style
) AS tmp2
LEFT JOIN $view_set_4_snap ON tbl_orders_style_ref_product_style=style 

 GROUP BY tbl_orders_style_ref_product_style ORDER BY order_div
) AS tmp3  WHERE (prodbalance>0 OR cpkbalance>0)  ORDER BY cpkbalance DESC";
$running_style=array();
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
while($sql_row=mysql_fetch_array($sql_result))
{
	$running_style[]=$sql_row['tbl_orders_style_ref_product_style'];
}
$sql2="SELECT *,SUM(view_set_4_snap.cpk_qty) AS cpk_quantity FROM (
SELECT tbl_orders_style_ref_product_style AS style,
tbl_orders_master_product_schedule AS schedule_no,tbl_miniorder_data_mini_order_num AS mini_order,
SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS input,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO' AND tbl_shifts_master_shift_name='A',bundle_transactions_20_repeat_quantity,0)) AS a_output,
SUM(bundle_transactions_20_repeat_rejection_quantity) AS rejected,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO' AND tbl_shifts_master_shift_name='B',bundle_transactions_20_repeat_quantity,0)) AS b_output
FROM $view_set_snap_1_tbl WHERE tbl_orders_style_ref_product_style IN ('".implode("','",$running_style)."')
 GROUP BY style,schedule_no,mini_order ORDER BY 
 style,schedule_no,mini_order ) AS tmp  LEFT JOIN $view_set_4_snap ON view_set_4_snap.schedule=tmp.schedule_no
  WHERE tmp.output>0 AND tmp.input>0 AND tmp.bundling AND tmp.bundleout>0 GROUP BY tmp.style,tmp.schedule_no,tmp.mini_order";
$sql_result2=mysql_query($sql2,$link) or exit("Sql Error".mysql_error());
$style=array();
echo "<table border=1px><tr><th>Product</th><th>style</th><th>schedule</th><th>Mini Order</th><th>Bundling</th><th>Bundling Out</th><th>Input</th><th>Output</th><th>Rejection</th></tr>";
while($sql_row2=mysql_fetch_array($sql_result2))
{
	echo "<tr><td></td><td>".$sql_row2['style']."</td><td>".$sql_row2['schedule_no']."</td><td>".$sql_row2['mini_order']."</td><td>".$sql_row2['bundling']."</td><td>".$sql_row2['bundleout']."</td><td>".$sql_row2['input']."</td><td>".$sql_row2['output']."</td><td>".$sql_row2['rejected']."</td>";
}
echo "</table>";

//-------------------------------------
$date_today=date('Y-m-d');
$prev_date = date('Y-m-d', strtotime($date_today .' -1 day'));
echo "<h2>Style Schedule mini order summary details (Reporting-$prev_date)-(Scanned-$date_today)</h2>";
echo "<br>";
$sql2="SELECT *,SUM(view_set_4_snap.cpk_qty) AS cpk_quantity FROM (
SELECT tbl_orders_style_ref_product_style AS style,
tbl_orders_master_product_schedule AS schedule_no,tbl_miniorder_data_mini_order_num AS mini_order,
SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS input,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO' AND tbl_shifts_master_shift_name='A',bundle_transactions_20_repeat_quantity,0)) AS a_output,
SUM(bundle_transactions_20_repeat_rejection_quantity) AS rejected,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO' AND tbl_shifts_master_shift_name='B',bundle_transactions_20_repeat_quantity,0)) AS b_output
FROM $view_set_snap_1_tbl WHERE date(bundle_transactions_date_time)='".$date_today."' and date(bundle_transactions_operation_time)='".$prev_date."' and tbl_orders_style_ref_product_style IN ('".implode("','",$running_style)."')
 GROUP BY style,schedule_no,mini_order ORDER BY 
 style,schedule_no,mini_order ) AS tmp  LEFT JOIN $view_set_4_snap ON view_set_4_snap.schedule=tmp.schedule_no
  WHERE tmp.output>0 AND tmp.input>0 AND tmp.bundling AND tmp.bundleout>0 GROUP BY tmp.style,tmp.schedule_no,tmp.mini_order";
$sql_result2=mysql_query($sql2,$link) or exit("Sql Error".mysql_error());
$style=array();
echo "<table border=1px><tr><th>Product</th><th>style</th><th>schedule</th><th>Mini Order</th><th>Bundling</th><th>Bundling Out</th><th>Input</th><th>Output</th><th>Rejection</th></tr>";
while($sql_row2=mysql_fetch_array($sql_result2))
{
	echo "<tr><td></td><td>".$sql_row2['style']."</td><td>".$sql_row2['schedule_no']."</td><td>".$sql_row2['mini_order']."</td><td>".$sql_row2['bundling']."</td><td>".$sql_row2['bundleout']."</td><td>".$sql_row2['input']."</td><td>".$sql_row2['output']."</td><td>".$sql_row2['rejected']."</td>";
}
echo "</table>";
*/
}

?> 
<style>

#table1 {
  display: inline-table;
  width: 100%;
}


div#table_div {
    width: 30%;
}
#test{
margin-left:8%;
margin-bottom:2%;
}
</style>