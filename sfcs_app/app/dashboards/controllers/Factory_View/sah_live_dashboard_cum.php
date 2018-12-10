<?php
include("../../../../common/config/config.php");
set_time_limit(2000);
$sec_x=$_GET['sec_x'];
include("../../../../common/js/Charts/FusionCharts.php");
?>

<html>
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
	color: #000000;
	font-family: Trebuchet MS;
}

table
{
	height:auto;
}
th
{
	font-size:135px;
	width:140px;
}

td
{
	height:770px;
	vertical-align:top;
	
}

</style>
<body>

<?php

$plan_sah=0;
$act_sah=0;
$plan_cla=0;
$act_cla=0;
$plan_sah_mtd=0;
$act_sah_mtd=0;
$plan_cla_mtd=0;
$act_cla_mtd=0;
$date=date("Y-m-d");
$teams=$shifts_array;
$team_array=implode(",",$shifts_array);
$team = "'".str_replace(",","','",$team_array)."'"; 	
$work_hrs=0;
$sql_hr="select * from $bai_pro.pro_atten_hours where date='$date' and shift in ($team)";
// echo $sql_hr."<br>";
$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"])); 
if(mysqli_num_rows($sql_result_hr) >0)
{
	while($sql_row_hr=mysqli_fetch_array($sql_result_hr)) 
	{ 
		$work_hrs=$work_hrs+($sql_row_hr['end_time']-$sql_row_hr['start_time']);

	}
	$break_time=sizeof($teams)*0.5;
	$work_hours=$work_hrs-$break_time;
}else{
	if(sizeof($teams) > 1) 
	{ 
		$work_hours=15;
	} 
	else 
	{ 
		$work_hours=7.5; 

	}
}                           

$current_hr=date('H');
$current_date=date("Y-m-d");

if($current_date==$date)
{
	$time_def_total=0;
	$hour_dur=0;
	for($i=0;$i<sizeof($teams);$i++)
	{
		$sql_hr="select * from $bai_pro.pro_atten_hours where date='$date' and shift='".$teams[$i]."' and  $current_hr between start_time and end_time";
		// echo $sql_hr."<br>";
		$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"])); 
		if(mysqli_num_rows($sql_result_hr) >0)
		{
			while($sql_row_hr=mysqli_fetch_array($sql_result_hr)) 
			{ 
				$start_time=$sql_row_hr['start_time'];
				$end_time=$sql_row_hr['end_time'];
				$diff_time=$current_hr-$start_time;
				if($diff_time>3)
				{
					$time_def=0.5;
					$diff_time=$diff_time-0.5;
				}
				$hour_dur=$hour_dur+$diff_time;
				$time_def_total=$time_def_total+$time_def;
			}
		}
		else
		{
			$sql_hr="select * from $bai_pro.pro_atten_hours where date='$date' and shift='".$teams[$i]."' and $current_hr > end_time";
			// echo $sql_hr."<br>";
			$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"])); 
			// $hour_dur=$hour_dur+0;
			while($sql_row_hr=mysqli_fetch_array($sql_result_hr)) 
			{ 
				$start_time=$sql_row_hr['start_time'];
				$end_time=$sql_row_hr['end_time'];
				if($end_time > $start_time){
					$diff_time=$end_time-$start_time;
				}
				else
				{
					$start=24-$start_time;
					$diff_time=$start+$end_time;
				}
				if($diff_time>3){
					$time_def=0.5;
					$diff_time=$diff_time-0.5;
				}
				$hour_dur=$hour_dur+$diff_time;
				$time_def_total=$time_def_total+$time_def;

			}
		}
		
	}
	$hoursa_shift=$hour_dur;
}
else
{
	$time_def_total=$break_time;
	$hoursa_shift=$work_hours;
}

$sqlx="select sum(plan_sth) as plan_sth,sum(act_sth) as act_sth,sum(plan_clh) as plan_clh,sum(act_clh) as act_clh from $bai_pro.grand_rep where section=$sec_x and date between \"".date("Y-m-01")."\" and \"".$date."\"";
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error1---".$sqlx.mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{	
	$plan_sah_mtd=round($sql_rowx['plan_sth'],0);
	$act_sah_mtd=round($sql_rowx['act_sth'],0);
	$plan_cla_mtd=round($sql_rowx['plan_clh'],0);
	$act_cla_mtd=round($sql_rowx['act_clh'],0);
}

$sqlx="select sum(plan_sth) as plan_sth,sum(act_sth) as act_sth,sum(plan_clh) as plan_clh,sum(act_clh) as act_clh from $bai_pro.grand_rep where section=$sec_x and date=\"".$date."\"";
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{	
	$plan_sah=round($sql_rowx['plan_sth'],0);
	$act_sah=round($sql_rowx['act_sth'],0);
	$plan_cla=round($sql_rowx['plan_clh'],0);
	$act_cla=round($sql_rowx['act_clh'],0);
}


$eff=0;
$k=0;

$time_def=$time_def_total;
$sqly="SELECT bac_no,bac_style AS style, couple,nop,smv, SUM(bac_qty) AS qty,COUNT(DISTINCT bac_lastup)-$time_def AS hrs,ROUND(smv*SUM(bac_qty)/60) AS sth,(COUNT(DISTINCT bac_lastup)-$time_def)*nop AS clh FROM $bai_pro.bai_log_buf WHERE bac_sec=$sec_x AND bac_date=\"".$date."\" GROUP BY bac_no+0";
//$sqly="SELECT bac_no,bac_style AS style, couple,nop,smv, SUM(bac_qty) AS qty,COUNT(DISTINCT bac_lastup)-0.5 AS hrs,ROUND(smv*SUM(bac_qty)/60) AS sth,(COUNT(DISTINCT bac_lastup)-0.5)*nop AS clh FROM bai_pro.bai_log_buf WHERE bac_sec=$sec_x AND bac_date=\"".date("Y-m-d")."\" GROUP BY bac_no+0";
//echo $sqly;
$hrs[]=0;
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


if($act_cla > 0)
{
	$act_eff=round(($act_sah/$act_cla)*100,0);
}
else
{
	$act_eff=0;
}

if($plan_cla > 0)
{
	$plan_eff=round(($plan_sah/$plan_cla)*100,0);
}
else
{
	$plan_eff=0;
}

$color="#ffffff";
if(round(($plan_sah*max($hrs)/7.5),0) > $act_sah)
{
	$color="#fd0404";
}
else
{
	$color="#23fd04";
}

$color1="#ffffff";
if($plan_sah_mtd > $act_sah_mtd)
{
	$color1="#fd0404";
}
else
{
	$color1="#23fd04";
}

$color2="#ffffff";
if($plan_eff > $act_eff)
{
	$color2="#fd0404";
}
else
{
	$color2="#23fd04";
}

$suffix="";
if($act_eff < 10)
{
	$suffix="0";
}

if($eff < 10)
{
	$suffix="0";
}

echo "<table>";
echo "<tr>";
echo "<th>Plan</th><th></th><th>".round(($plan_sah/$work_hours)*($hoursa_shift),0)."</th><th></th><th>$plan_sah_mtd</th><th></th><th style=\"font-size=150px;\" bgcolor=\"$color2\" rowspan=2>".$eff."%</th>";
echo "</tr>";

echo "<tr>";
echo "<th>Actual</th><th></th><th style=\"color=$color;\">$act_sah</th><th></th><th style=\"color=$color1;\">$act_sah_mtd</th>";
echo "</tr>";

?>



</body>
</html>
