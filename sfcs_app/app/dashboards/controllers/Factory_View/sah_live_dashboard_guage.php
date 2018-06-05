<?php
include("../../../../common/config/config.php");
set_time_limit(2000);
$sec_x=$_GET['sec_x'];
include("../../../../common/js/Charts/FusionCharts.php");
?>

<html>
<head>
<script type="text/javascript" src="../../../../common/js/jquery.min.js"></script>
<script type="text/javascript" src="../../../../common/js/Charts/FusionCharts.js"></script>

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
	color: #040000;
	font-family: Trebuchet MS;
}

table
{
	height:auto;
}
th
{
	font-size:100px;
	width:100px;
}

td
{
	
	vertical-align:top;
	
}

</style>
</head>
<body>

<?php

$plan_sah_a=0;
$act_sah_a=0;
$plan_sah_b=0;
$act_sah_b=0;
$mtd_plan=0;
$mtd_act=0;
$plan_cla_a=0;
$act_cla_a=0;
$plan_cla_b=0;
$act_cla_b=0;

$eff=0;
$k=0;

$br_time=date("H");
$time_def=0;

if($sec_x==1 || $sec_x==2 || $sec_x==5 || $sec_x==6)
{
	if($br_time>=9 && $br_time<=17)
	{
		$time_def=0.5;
	}
	if($br_time>17 && $br_time<=23)
	{
		$time_def=1;
	}
}

if($sec_x == 4 || $sec_x == 3)
{
	if($br_time>=10 && $br_time<=18)
	{
		$time_def=0.5;
	}
	if($br_time>18 && $br_time<=23)
	{
		$time_def=1;
	}
}

$sqly="SELECT bac_no,bac_style AS style, couple,nop,smv, SUM(bac_qty) AS qty,COUNT(DISTINCT bac_lastup)-$time_def AS hrs,ROUND(smv*SUM(bac_qty)/60) AS sth,(COUNT(DISTINCT bac_lastup)-$time_def)*nop AS clh FROM $bai_pro.bai_log_buf WHERE bac_sec=$sec_x AND bac_date=\"".date("Y-m-d")."\" GROUP BY bac_no+0";
//$sqly="SELECT bac_no,bac_style AS style, couple,nop,smv, SUM(bac_qty) AS qty,COUNT(DISTINCT bac_lastup)-0.5 AS hrs,ROUND(smv*SUM(bac_qty)/60) AS sth,(COUNT(DISTINCT bac_lastup)-0.5)*nop AS clh FROM bai_pro.bai_log_buf WHERE bac_sec=$sec_x AND bac_date=\"".date("Y-m-d")."\" GROUP BY bac_no+0";

//echo $sqly;
$sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowy=mysqli_fetch_array($sql_resulty))
{
		$sth_mod=$sql_rowy["sth"];
		$clh_mod=$sql_rowy["clh"];
		$hrs[]=$sql_rowy["hrs"];
		if($clh_mod > 0)
		{
			$eff=$eff+round($sth_mod*100/$clh_mod,0);
		}
		else
		{
			$eff=$eff+0;	
		}
		//$eff=$eff+round($sth_mod*100/$clh_mod,0);
		$k=$k+1;
}

if($k>0)
{
	$eff=round($eff/$k,0);
}
else
{
	$eff=0;
}


$sqlx="select date,plan_sth,act_sth,shift,plan_clh,act_clh from $bai_pro.grand_rep where section=$sec_x and left(date,7)='".date("Y-m")."'";
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	if($sql_rowx['date']==date("Y-m-d") and $sql_rowx['shift']=="A")
	{
		$plan_sah_a+=$sql_rowx['plan_sth'];
		$act_sah_a+=$sql_rowx['act_sth'];
		$plan_cla_a+=$sql_rowx['plan_clh'];
		$act_cla_a+=$sql_rowx['act_clh'];
	}
	
	if($sql_rowx['date']==date("Y-m-d") and $sql_rowx['shift']=="B")
	{
		$plan_sah_b+=$sql_rowx['plan_sth'];
		$act_sah_b+=$sql_rowx['act_sth'];
		$plan_cla_b+=$sql_rowx['plan_clh'];
		$act_cla_b+=$sql_rowx['act_clh'];
	}
	
	$mtd_plan+=$sql_rowx['plan_sth'];
	$mtd_act+=$sql_rowx['act_sth'];
}

if($act_cla_a+$act_cla_b > 0)
{
	$act_eff=round((($act_sah_a+$act_sah_b)/($act_cla_a+$act_cla_b))*100,0);
}
else
{
	$act_eff=0;
}

if($plan_cla_a+$plan_cla_b > 0)
{
	$plan_eff=round((($plan_sah_a+$plan_sah_b)/($plan_cla_a+$plan_cla_b))*100,0);
}
else
{
	$plan_eff=0;
}




$message = "<chart lowerLimit='0' upperLimit='100' gaugeStartAngle='180' gaugeEndAngle='0' palette='1' numberSuffix='%' tickValueDistance='20' showValue='1' decimals='0' dataStreamURL='CPUData.asp' refreshInterval='3' preSuffix='%'>
   <colorRange>
      <color minValue='0' maxValue='50' code='FF654F'/>
      <color minValue='50' maxValue='75' code='F6BD0F'/>		
      <color minValue='75' maxValue='100' code='8BBA00'/>
   </colorRange>
   <dials>
      
	  <dial value='$eff' rearExtension='15' bgcolor='33ff00' valueY='150'/>
	  <dial value='$plan_eff' rearExtension='25' bgcolor='ff0000' valueY='160'/>
   </dials>
   <styles>
      <definition>
         <style type='font' name='myValueFont' bgColor='ffffff' borderColor='999999' />
      </definition>
      <application>
         <apply toObject='Value' styles='myValueFont' />
      </application>
   </styles>
</chart>";

//To Write File
	$myFile = "Eff_guage_include".$_GET['sec_x'].".php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "<?php echo \" ".$message."\"; ?>";
	fwrite($fh, $stringData);
	fclose($fh);
	//To Write File

?>

<table>
<tr>
<td>

<div style="float:left;">
<div id="chart1div2c1"></div>
  <?php
  echo '<script type="text/javascript">
   var chart1 = new FusionCharts("../../../../common/js/Charts/AngularGauge.swf", "ChId1", "500", "345", "0", "0");
   //chart1.setDataURL("Eff/eff_guage_include_temp.php");
   chart1.setDataURL("$dns_adr3/projects/dashboards/production_kpi/eff_guage_include'.$_GET['sec_x'].'.php?rand='.rand().'");
   chart1.render("chart1div2c1");
   </script>';
   ?>

</div>
</td>
</tr>

</table>
<div style="clear: both;"> </div>

</body>
</html>
