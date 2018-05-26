<?php
error_reporting(0);
?>
<title>Weekly Delivery Dashboard - Packing</title>
<head>
<script type="text/javascript" src="datetimepicker_css.js"></script>
<script language="javascript" type="text/javascript" 
		src="<?= getFullURLLevel($_GET['r'],'common/js/tablefilter_en/table_filter.js', 3, 'R');?>" ></script>
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
table{
	float: left;
}
th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:1px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;}
</style>

</head>
<body>
<div class="panel panel-primary">
	<div class="panel-heading">Weekly Delivery Dashboard - Packing</div>
	<div class="panel-body">
<?php
$weeknumber=$_GET["weekno"];
include("../".getFullURLLevel($_GET['r'],'common/config/config.php', 3,'R'));
$year =date("Y");
$dates=array();
for($day=1; $day<=7; $day++)
{
    $dates[]=date('Y-m-d',strtotime($year."W".$weeknumber.$day))."\n";
}

$start_date=min($dates);
$end_date=max($dates);
$start_date = '2017-12-06';
$end_date = '2018-01-10';
$query1="where ex_factory_date_new between \"".trim($start_date)."\" and  \"".trim($end_date)."\" order by left(style,1)";
// echo $query1;
$sqly="select ref_id from $bai_pro4.week_delivery_plan_ref $query1";
//echo $sqly;
$resulty=mysqli_query($link,$sqly) or die("Error = ".mysqli_error().$sqly);
$ref_id_ver = array();
while($rowy=mysqli_fetch_array($resulty))
{
	$ref_id_ver[]=$rowy["ref_id"];
}
$status=array("Shipped","M3 Reported","FCA","FCA/P","FCA Fail","Offered","FG*");
$low_status=array("FG","Packing","Sewing","Cutting","RM");
$high_status=array("Shipped","M3 Reported","FCA","FCA/P","FCA Fail","Offered","FG*","FG","Packing","Sewing","Cutting","RM");
$sqly='SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code';					
mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
echo "<div class='table-responsive'>";
echo "<table class='table table-bordered'><tr><th>Status</th>";
while($sql_rowy=mysqli_fetch_array($sql_resulty))
{
	$buyer_name=$sql_rowy['buyer_name'];
	echo "<th>$buyer_name</th>";
}
echo "</tr>";
for($i=0;$i<sizeof($status);$i++)
{
	echo "<tr>";
	echo "<th>".$status[$i]."</th>";
	$status_implode='"'.implode('","',$status).'"';
	$low_status_implode='"'.implode('","',$low_status).'"';
	$sqly='SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code';					
	mysqli_query($link,$sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_rowy=mysqli_fetch_array($sql_resulty))
	{   
		$buyer_name=$sql_rowy['buyer_name'];
		if($ref_id_ver){
			$arr = implode(",",$ref_id_ver);
		}
		$sqla="SELECT COUNT(STATUS) as cou FROM $bai_pro4.weekly_delivery_status_finishing where buyer = \"$buyer_name\" and status in ($status_implode) and low_status not in ($low_status_implode) and status=\"".$status[$i]."\" and tid in ('".$arr."')";
		//echo $sqla;
		$resulta=mysqli_query($link,$sqla) or die("Errors = ".mysqli_error());
		while($rowa=mysqli_fetch_array($resulta))
		{	
			echo "<td>".$rowa["cou"]."</td>";		
		}
	}
}
echo "</tr>";
for($i=0;$i<sizeof($low_status);$i++)
{
	echo "<tr>";
	echo "<th>".$status[$i]."</th>";
	$status_implode='"'.implode('","',$status).'"';
	$low_status_implode='"'.implode('","',$low_status).'"';
	$sqly='SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code';					
	mysqli_query($link,$sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_rowy=mysqli_fetch_array($sql_resulty))
	{
		$buyer_name=$sql_rowy['buyer_name'];
		if($ref_id_ver){
			$arr = implode(",",$ref_id_ver);
		}
		$sqla="SELECT COUNT(STATUS) as cou FROM $bai_pro4.weekly_delivery_status_finishing where buyer = \"$buyer_name\" and low_status in ($low_status_implode) and low_status=\"".$low_status[$i]."\" and tid in ('".$arr."')";
		//echo $sqla;
		$resulta=mysqli_query($link,$sqla) or die("Errors = ".mysqli_error());
		while($rowa=mysqli_fetch_array($resulta))
		{	
			echo "<td>".$rowa["cou"]."</td>";		
		}
	}
}
echo "</tr>";
echo "<tr><th>Total</th>";
$sqly='SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code';					
mysqli_query($link,$sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowy=mysqli_fetch_array($sql_resulty))
{
	$buyer_name=$sql_rowy['buyer_name'];
	if($ref_id_ver){
			$arr = implode(",",$ref_id_ver);
		}

	$sqla="SELECT COUNT(STATUS) as cou FROM $bai_pro4.weekly_delivery_status_finishing where buyer = \"$buyer_name\" and tid in ('".$arr."')";
	//echo $sqla;
	$resulta=mysqli_query($link,$sqla) or die("Error = ".mysqli_error().$sqla);
	while($rowa=mysqli_fetch_array($resulta))
	{	
		echo "<th>".$rowa["cou"]."</th>";		
	}
}
echo "</tr></table></div>";
?>
</body>
</div>
</div>