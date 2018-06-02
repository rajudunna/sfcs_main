<html>
<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions.php");

//$view_access=user_acl("SFCS_0242",$username,1,$group_id_sfcs); 
?>
<head>
<title>Product Wise Summary Report</title>
<script type="text/javascript" src="jquery.min.js"></script>
<script language="JavaScript" src="FusionCharts.js"></script>
<script type="text/javascript" language="JavaScript" src="FusionChartsExportComponent.js"></script>
<script type="text/javascript" src="datetimepicker_css.js"></script>
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
<?php
	$date=$_GET["dat"];
	$hours=$_GET["hour"];
	$hour=$hours+1;
	echo"<h2 style='background-color: MidnightBlue ;text-align: center;color:White; ' >".$var." Scanned Bundles Performance</h2>";
	//echo "<a href=\"hour_bundles?hour=$hours&dat=$date\">Click Here See the Bundles</a>";
	echo "<table border =1px>";
	echo"<tr><th>Bundle Number</th><th>Module Number</th><th>Quantity</th><th>Rejection Quantity</th><th>Employee Number</th></tr>";
	if($hours=='6')
	{
		$sql="SELECT bundle_transactions_20_repeat_bundle_id as bundle,bundle_transactions_20_repeat_act_module as module,
		bundle_transactions_20_repeat_quantity as act_out,bundle_transactions_20_repeat_rejection_quantity as rejec,bundle_transactions_employee_id as emp FROM $brandix_bts.view_set_1 WHERE DATE(bundle_transactions_date_time)='".$date."' AND TIME(bundle_transactions_date_time) < TIME('$hour:15:00') AND bundle_transactions_20_repeat_operation_id='4' GROUP BY bundle order by bundle";
	}
	else
	{
		$sql="SELECT bundle_transactions_20_repeat_bundle_id as bundle,bundle_transactions_20_repeat_act_module as module,
		bundle_transactions_20_repeat_quantity as act_out,bundle_transactions_20_repeat_rejection_quantity as rejec,bundle_transactions_employee_id as emp FROM $brandix_bts.view_set_1 WHERE DATE(bundle_transactions_date_time)='".$date."' AND TIME(bundle_transactions_date_time) >= TIME('$hours:15:00') AND TIME(bundle_transactions_date_time) < TIME('$hour:15:00') AND bundle_transactions_20_repeat_operation_id='4' GROUP BY bundle order by bundle";
	}
// echo $sql."<br>";
 	$sql_result=mysqli_query($link, $sql) or exit("Sql Errordd==3".mysqli_error($GLOBALS["___mysqli_ston"]));
	//$act_out=array();
	while($sql_row1=mysqli_fetch_array($sql_result))
	{
		echo "<tr>";
		echo "<td>".$sql_row1['bundle']."</td>";
		echo "<td>".$sql_row1['module']."</td>";
		echo "<td>".$sql_row1['act_out']."</td>";
		echo "<td>".$sql_row1['rejec']."</td>";
		echo "<td>".$sql_row1['emp']."</td>";
		echo "</tr>";
	}
	
	echo "</table>";

?>
<body>
</html>
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