<html>
<head>
<style>
iframe 
{
	height:100%;
	border: 0;
	overflow:auto;
}

body 
{
	zoom: 90%;
	overflow:auto;
	background-color:#eeeeee;
	color: #000000;
	font-family: Trebuchet MS;
}

table
{
	height:auto;
}
th
{
	font-size:35.55px;
	width:240px;
}

td
{
	height:770px;
	vertical-align:top;
	
}

</style>
</head>
<body>
<?php
include("../../../../common/config/config.php");
$sec_x=$_GET['sec_x'];

$start=date("Y-m-01");
$end=date("Y-m-31");
//echo $start."---".$end;

$full="470000";
$total="300000";

$sql=mysqli_query($link, "select sum(act_sth),sum(plan_sth) FROM $bai_pro.grand_rep where date between \"$start\" and \"$end\" and section=$sec_x");
//echo "<br>select sum(act_sth),sum(plan_sth) FROM grand_rep where date=\"$date[$i]\"<br><br>";
while($row=mysqli_fetch_array($sql))
{
	$plan_sth=round($row["sum(plan_sth)"],0);
	$act_sth=round($row["sum(act_sth)"],0);
	//echo "<br>".$plan_sth."---".$act_sth;
}

$sql1="select count(*) as cnt from $bai_pro3.sections_db where sec_id > 0";
$sql_result=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row1=mysqli_fetch_array($sql_result))
{
	$sec_count=$row1["cnt"];
}

$today_bal=$plan_sth-$act_sth;


		
		include"header.php";
		include"data.php";
		$start=date("Y-m-01");
		$end=date("Y-m-31");
		
		$sql=mysqli_query($link, "select sum(act_sth),sum(plan_sth) FROM $bai_pro.grand_rep where date between \"$start\" and \"$end\" and section=$sec_x");
		//echo "<br>select sum(act_sth),sum(plan_sth) FROM grand_rep where date=\"$date[$i]\"<br><br>";
		while($row=mysqli_fetch_array($sql))
		{
			$plan_sth=round($row["sum(plan_sth)"],0);
			$act_sth=round($row["sum(act_sth)"],0);
			//echo "<br>".$plan_sth."---".$act_sth;
		}
		
		$plan=$plan_sth;
		$actual=$act_sth;
		//$fac_plan="300000";
		$fac_ac=round($fac_plan_sah/$sec_count,0);
		$fac_plan=round($fac_plan/$sec_count,0);
		$plan_per=round($plan*100/$fac_ac,0);
		$acu_fac=round($actual*100/$fac_ac,0);
		$mtd=$plan_per+$acu_fac;
		$fac_plan_fac=round($fac_plan*100/$fac_ac,0);
		$act_per=$acu_fac-$plan_per;
		$fac_per=$fac_plan_fac-$acu_fac;
		$fac_cap_per=100-$plan_per-$act_per-$fac_per;
		
		
		$message= "<table align=\"center\" height=\"".(100+20)."px\">";
		$message.= "<tr>";
		$message.= "<th bgcolor=\"#FF0000\" height=\"".abs($fac_cap_per+20)."px\">Section Capacity</th>";
		$message.= "<th >$fac_ac<br/>(100%)</th>";
		$message.= "</tr>";
		$message.= "<tr>";
		$message.= "<th  bgcolor=\"#008000\" height=\"".abs($fac_per+20)."px\">Monthly Plan</th>";
		$message.= "<th >$fac_plan<br/>($fac_plan_fac%)</th>";
		$message.= "</tr>";
		$message.= "<tr>";
		$message.= "<th  bgcolor=\"#00FF00\" height=\"".abs($act_per+20)."px\">MTD Plan</th>";
		$message.= "<th >$plan<br/>($plan_per%)</th>";
		$message.= "</tr>";
		$message.= "<tr>";
		$message.= "<th  bgcolor=\"#FFA500\" height=\"".abs($plan_per+20)."px\">MTD Actual</th>";
		$message.= "<th >$actual<br/>($acu_fac%)</th>";
		$message.= "</tr>";
		$message.= "</table>";
		
		echo $message;
?>
</body>
</html>