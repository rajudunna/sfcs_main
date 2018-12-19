<?php
// include("dbconf.php");
include ("../../../../common/config/config.php");
include ("../../../../common/config/functions.php");
//$sec_x=$_GET['sec_x'];
$date=date("Y-m-d");
if(isset($_GET['sec_x']))
{
	$sections_db=array($_GET['sec_x']);
}
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


for($i=0;$i<sizeof($sections_db);$i++)
{
	$section_id=$sections_db[$i];
	$sec=$section_id;
	$sec_x=$section_id;
	
	
	$date_yst=date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));
	$date=date("Y-m-d");
	//echo $date;
	$id_new="green";
	$act_sth_day=0;
	$plan_sth_day=0;
	$smv_day=0;
	$module_day=0;
	$complete_percent=0;
	$smo_a=0;
	$smo_b=0;
	$act_clh_day=0;


	$sqlx="select sum(plan_sth) as plan_sth,sum(act_sth) as act_sth,sum(plan_clh) as plan_clh,sum(act_clh) as act_clh from $bai_pro.grand_rep where section=$sec_x and date between \"".date("Y-m-01")."\" and \"".$date."\"";
	$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_rowx=mysqli_fetch_array($sql_resultx))
	{	
		$plan_sah_mtd=round($sql_rowx['plan_sth'],0);
		$act_sah_mtd=round($sql_rowx['act_sth'],0);
		$plan_cla_mtd=round($sql_rowx['plan_clh'],0);
		$act_cla_mtd=round($sql_rowx['act_clh'],0);
	}

		$sqlx="select sum(plan_sth) as plan_sth,sum(act_sth) as act_sth,sum(plan_clh) as plan_clh,sum(act_clh) as act_clh from $bai_pro.grand_rep where section=$sec_x and date=\"".$date."\"";
		$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowx=mysqli_fetch_array($sql_resultx))
		{	
			$plan_sah=round($sql_rowx['plan_sth'],0);
			$act_sah=round($sql_rowx['act_sth'],0);
			$plan_cla=round($sql_rowx['plan_clh'],0);
			$act_cla=round($sql_rowx['act_clh'],0);
		}

		$eff=0;
		$k=0;

		$br_time=date("H");

		$time_def=$time_def_total;
		$sqly="SELECT bac_no,bac_style AS style, couple,nop,smv, SUM(bac_qty) AS qty,COUNT(DISTINCT bac_lastup)-$time_def AS hrs,ROUND(smv*SUM(bac_qty)/60) AS sth,(COUNT(DISTINCT bac_lastup)-$time_def)*nop AS clh FROM $bai_pro.bai_log_buf WHERE bac_sec=$sec_x AND bac_date=\"".$date."\" GROUP BY bac_no+0";
		//$sqly="SELECT bac_no,bac_style AS style, couple,nop,smv, SUM(bac_qty) AS qty,COUNT(DISTINCT bac_lastup)-0.5 AS hrs,ROUND(smv*SUM(bac_qty)/60) AS sth,(COUNT(DISTINCT bac_lastup)-0.5)*nop AS clh FROM bai_pro.bai_log_buf WHERE bac_sec=$sec_x AND bac_date=\"".date("Y-m-d")."\" GROUP BY bac_no+0";
		//echo $sqly;
		$hrs[]=0;
		// echo $sqly;
		$sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error111".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowy=mysqli_fetch_array($sql_resulty))
		{
				$sth_mod=$sql_rowy["sth"];
				$clh_mod=$sql_rowy["clh"];
				$hrs[]=$sql_rowy["hrs"];
				// Ticket #439900/ To avoid the division by Zero  error at SAH Generation in Factory view 
				//$eff=$eff+round($sth_mod*100/$clh_mod,0);
				$k=$k+1;
		}

		
		//echo $hrs_count."-".$time_def."<br>";
		if($work_hours> 0)
		{
			$plan_val=round(($plan_sah/$work_hours)*($hoursa_shift),0);	
		}
		else
		{
			$plan_val=0;
		}
		$act_val=$act_sah; 
		//echo "<br/>";
		//echo "plan=".$plan_val;
		//echo "actval=".$act_val;
		//$complete_percent=round($act_sth_day/($act_clh_day)*100,2);	
		if($plan_val>0)
		{
			$complete_percent=round($act_val/($plan_val)*100,2);	
		}


		
		if($complete_percent>=100)
		{
			$id_new="green";
		}
		else
		{
			if($complete_percent>=90 && $complete_percent<=99)
			{
				$id_new="yellow";
			}
			else
			{
				$id_new="red";
			}
		}
			
		echo "<td><div id=\"$id_new\"><a href=\"http://".$_SERVER['HTTP_HOST']."/sfcs_app/app/dashboards/controllers/Factory_View/sah_live_dashboard_V2.php?sec_x=$section_id&rand=".rand()."\" target='_blank'></a></div></td>";
}
			

?>