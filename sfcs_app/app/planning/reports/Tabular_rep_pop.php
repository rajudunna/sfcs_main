<?php

set_time_limit(2000);
$start_week=$_GET['week_start'];
$end_week=$_GET['week_end'];
$style_id=$_GET['style_id'];
//echo $color_code;
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
?>

<html>
<head>
<TITLE>Movex Analytica - POPUP REPORT</TITLE>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R'); ?>"></script>
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R'); ?>" type="text/css" media="all" />
<link href="table_style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php 
// include ("dbconf_pop.php"); ?>

<span><h2>Order Status - POP REPORT</h2></span>

<?php

//Table Name Spaces
//To Identify shipment plan table
$sql="select distinct style_id from $bai_pro2.shipment_plan order by style_id";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_rows=mysqli_num_rows($sql_result);
//echo $sql_num_rows;
$shipment_plan="shipment_plan_summ";

if($sql_num_rows > 0)
{
	$shipment_plan="shipment_plan";
}

$ssc_code_temp="temp_pool_db.".$username.date("His")."_"."ssc_code_temp";
$style_status_summ="style_status_summ";

//Create Temp Table

$sql="create TEMPORARY table $ssc_code_temp select * from bai_pro2.ssc_code_temp";
mysqli_query($link, $sql) or exit("Sql Error1z".mysqli_error($GLOBALS["___mysqli_ston"]));

echo "<table>";
echo "<tr>";
echo "<th>Style</th>";
echo "<th>Schedule</th>";
echo "<th>Color</th>";
echo "<th>Ex-Factory Date</th>";
echo "<th>Order Qty</th>";
echo "<th>Cut Qty</th>";
echo "<th>%</th>";
echo "<th>Sewing In Qty</th>";
echo "<th>%</th>";
echo "<th>Sewing Out Qty</th>";
echo "<th>%</th>";
echo "<th>Pack Qty</th>";
echo "<th>%</th>";
echo "<th>Ship Qty</th>";
echo "<th>%</th>";
echo "</tr>";

$ssc_code_base=array();
$i=0;

$sql11="delete from $ssc_code_temp";
mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));


$sql11="select distinct ssc_code from $shipment_plan where exfact_date between \"".$start_week."\" and \"".$end_week."\" and style_id=\"$style_id\"";
mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row11=mysqli_fetch_array($sql_result11))
{
	$sql111="insert ignore into $ssc_code_temp(ssc_code) values (\"".$sql_row11['ssc_code']."\")";
	mysqli_query($link, $sql111) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
}


$sql111="select distinct ssc_code from $ssc_code_temp";
mysqli_query($link, $sql111) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row111=mysqli_fetch_array($sql_result111))
{
	$cut_qty=0;
	$sewing_in=0;
	$sewing_out=0;
	$pack_qty=0;
	$ship_qty=0;
	$ssc_code=$sql_row111['ssc_code'];

	$cut_qty_today=0;
	$sewing_in_today=0;
	$sewing_out_today=0;
	$pack_qty_today=0;
	$ship_qty_today=0;

	$cust_order="";
	$cpo="";
	$buyer_div="";
	$style_no="";
	$schedule_no="";
	$color="";
	$exfact_date="";
	$order_qty=0;
	$style_id="";

	$sql="select * from $style_status_summ where ssc_code=\"$ssc_code\"";
	//echo $sql;
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$sql1="select act_cut,act_in,output,act_fg,act_ship from $bai_pro3.bai_orders_db_confirm where order_style_no=\"".$sql_row['style']."\" and order_del_no=\"".$sql_row['sch_no']."\" and order_col_des=\"".$sql_row['color']."\"";
		//echo $sql1."<br>";
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$cut_qty=$sql_row1['act_cut'];
			$sewing_in=$sql_row1['act_in'];
			$sewing_out=$sql_row1['output'];
			$pack_qty=$sql_row1['act_fg'];
			$ship_qty=$sql_row1['act_ship'];
		}
	}	

	$sql1="select * from $bai_pro2.shipment_plan where ssc_code=\"$ssc_code\"";
	//echo $sql1."<br>";
	mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$cust_order=$sql_row1['Cust_order'];
		$cpo=$sql_row1['CPO'];
		$buyer_div=$sql_row1['buyer_div'];
		$exfact_date=$sql_row1['exfact_date'];
		$order_qty=$sql_row1['order_qty'];
		$style_id=$sql_row1['style_id'];
		$style_no=$sql_row1['style_no'];
		$schedule_no=$sql_row1['schedule_no'];
		$color=$sql_row1['color'];
	}

	$sql1="select sum(order_qty) as \"order_qty\" from $shipment_plan where ssc_code=\"$ssc_code\"";
	mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$order_qty=$sql_row1['order_qty'];
	}
	echo "<tr>";
	echo "<td>$style_no</td>";
	echo "<td>$schedule_no</td>";
	echo "<td>$color</td>";
	echo "<td>$exfact_date</td>";
	echo "<td>$order_qty</td>";
	echo "<td>$cut_qty</td>";
	if($order_qty>0)
	{
		echo "<td>".round(($cut_qty/$order_qty)*100,0)."%</td>";
	}
	else
	{
		echo "<td>0%</td>";
	}

	echo  "<td>$sewing_in</td>";

	if($order_qty>0)
	{
		echo "<td>".round(($sewing_in/$order_qty)*100,0)."%</td>";
	}
	else
	{
		echo "<td>0%</td>";
	}

	echo  "<td>$sewing_out</td>";

	if($order_qty>0)
	{
	echo "<td>".round(($sewing_out/$order_qty)*100,0)."%</td>";
	}
	else
	{
	echo "<td>0%</td>";
	}

	echo  "<td>$pack_qty</td>";

	if($order_qty>0)
	{
	echo "<td>".round(($pack_qty/$order_qty)*100,0)."%</td>";
	}
	else
	{
	echo "<td>0%</td>";
	}

	echo  "<td>$ship_qty</td>";

	if($order_qty>0)
	{
	echo "<td>".round(($ship_qty/$order_qty)*100,0)."%</td>";
	}
	else
	{
	echo "<td>0%</td>";
	}
	


	echo "</tr>";
}

echo "</table>";
?>	




</body>
</html>


	