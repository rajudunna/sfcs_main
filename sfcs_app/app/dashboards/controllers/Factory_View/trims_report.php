<?php
include ("../../../../common/config/config.php");
include ("../../../../common/config/functions.php");
//$table_name="fabric_priorities";
$table_name="trims_dashboard";
$section=$_GET["section"];
?>
<html>
<title>Trims Requestion Form</title>
<head>
<style type="text/css" media="screen">

/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
body{ 
	margin:15px; padding:15px; border:0px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:12px; 
}
a {
	margin:0px; padding:0px;
}
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable1{
	font-size:12px;
}
th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;}
</style>

<script type="text/javascript" src="datetimepicker_css.js"></script>

</head>
<body>

<h2 align="center">Trims Requestion Details</h2>
<hr>
<!--<?php echo "Docket No = ".$doc_no; ?>-->
<table class="mytable1" border=0 cellpadding=0 cellspacing=0>

<tr></th><th>Style</th><th>Schedule</th><th>Color</th><th>Docket No</th><th>Job No</th><th>Request Time</th><th>Issued Time</th><th>Status</th></tr>
<?php

$sql2x="select * from $bai_pro3.trims_dashboard where section=$section and DATE(plan_time)>=\"2013-01-09\"";
//echo $sql2x;
$result2x=mysqli_query($link, $sql2x) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));	
while($row2x=mysqli_fetch_array($result2x))
{
	echo "<tr>";
	$doc_no=$row2x["doc_ref"];
	$sql11x="select order_tid,acutno from $bai_pro3.plandoc_stat_log where doc_no=\"".$doc_no."\"";
	$sql_result11x=mysqli_query($link, $sql11x) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row11x=mysqli_fetch_array($sql_result11x))
	{
		$order_tidx=$row11x["order_tid"];
		$cut_nosx=$row11x["acutno"];
	}

	$sql21x="select order_style_no,order_del_no,order_col_des,order_div,color_code from $bai_pro3.bai_orders_db where order_tid=\"".$order_tidx."\"";
	$sql_result21x=mysqli_query($link, $sql21x) or die("Error2 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row21x=mysqli_fetch_array($sql_result21x))
	{
		$stylex=$row21x["order_style_no"];
		$schedulex=$row21x["order_del_no"];
		$colorx=$row21x["order_col_des"];
		$buyerx=$row21x["order_div"];
		$color_codex=$row21x["color_code"];
	}
	
	$zeros="00";
	
	if($cut_nosx > 9)
	{
		$zeros="0";
	}

	echo "<td>".$stylex."</td>";
	echo "<td>".$schedulex."</td>";
	echo "<td>".$colorx."</td>";
	echo "<td>".$doc_no."</td>";
	echo "<td>".chr($color_codex).$zeros.$cut_nosx."</td>";
	echo "<td>".$row2x["trims_req_time"]."</td>";
	echo "<td>".$row2x["trims_issued_time"]."</td>";
	$status=$row2x["trims_status"];
	
	$trims_status="";	
	
	if($status == 0)
	{
		$trims_status="Trims Applied";
	}
	
	if($status == 1)
	{
		$trims_status="Stock In Pool";
	}
	
	if($status == 2)
	{
		$trims_status="Trims Issued";
	}
	
	if($row2x["trims_req_time"] == "0000-00-00 00:00:00")
	{
		$trims_status="Need To Apply For Trims";
	}
	
	echo "<td>$trims_status</td>";
	
	echo "</tr>";
}
?>

</body>
</html>