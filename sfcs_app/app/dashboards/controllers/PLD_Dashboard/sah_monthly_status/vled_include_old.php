<html>
<head>
<style id="Book1_6519_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl636519
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl636518
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}	

-->
</style>
</head>
<body>
<?php

include"header.php";
include"data.php";
$start=date("Y-m-01");
$end=date("Y-m-31");

$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(act_sth),sum(plan_sth) FROM grand_rep where date between \"$start\" and \"$end\"");
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
$fac_ac="470000";

$plan_per=round($plan*100/$fac_ac,0);
$acu_fac=round($actual*100/$fac_ac,0);
$mtd=$plan_per+$acu_fac;
$fac_plan_fac=round($fac_plan*100/$fac_ac,0);
$act_per=$acu_fac-$plan_per;
$fac_per=$fac_plan_fac-$acu_fac;
$fac_cap_per=100-$plan_per-$act_per-$fac_per;


echo "<table border=0 height=\"100%\" width=\"8%\">";
echo "<tr>";
echo "<th class=xl636518 bgcolor=\"#FF0000\" height=\"$fac_cap_per%\">Fcactory Capacity</th>";
echo "<th class=xl636519>$fac_ac(100%)</th>";
echo "</tr>";
echo "<tr>";
echo "<th class=xl636518 bgcolor=\"#008000\" height=\"$fac_per%\">Monthly Plan</th>";
echo "<th class=xl636519>$fac_plan($fac_plan_fac%)</th>";
echo "</tr>";
echo "<tr>";
echo "<th class=xl636518 bgcolor=\"#00FF00\" height=\"$act_per%\">MTD Plan</th>";
echo "<th class=xl636519>$plan($plan_per%)</th>";
echo "</tr>";
echo "<tr>";
echo "<th class=xl636518 bgcolor=\"#FFA500\" height=\"$plan_per%\">MTD Actual</th>";
echo "<th class=xl636519>$actual($acu_fac%)</th>";
echo "</tr>";
echo "</table>";
echo "sah<br>report";

?>
</body>
</html>