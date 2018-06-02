<!--
Changes Log:

1)2013-11-30/kirang/Ticket#668916
Factory KPI Dashboard Changes
"1) Individual section Plan SAH must come based on the Hours.
2) Factory KPI dashboard SAH should be equal to today only.
* Need to change Act SAH, CLH based on hours."

SAH live  - achievement  90% to 99%  yellow 
                     SAH achievement 100% and above Green
                    SAH achievement less than 90% is Red.
					
2)2014-03-27/kirang/Ticket #439900/ To avoid the division by Zero error at SAH Generation in Factory view 

-->
<?php
// include("dbconf.php");
include ("../../../../common/config/config.php");
include ("../../../../common/config/functions.php");
//$sec_x=$_GET['sec_x'];

if(isset($_GET['sec_x']))
{
	$sections_db=array($_GET['sec_x']);
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


		$sqlz="select count(distinct bac_lastup) as hrs, count(distinct bac_shift) as shifts from $bai_pro.bai_log_buf where bac_date=\"".$date."\" and bac_sec=$sec_x";
		$sql_resultz=mysqli_query($link, $sqlz) or die("Errorz".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowz=mysqli_fetch_array($sql_resultz))
		{
			$hrs_count=$sql_rowz["hrs"];
			$shifts=$sql_rowz["shifts"];
		}

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
		//$time_def=1;
		$sqly="SELECT bac_no,bac_style AS style, couple,nop,smv, SUM(bac_qty) AS qty,COUNT(DISTINCT bac_lastup)-$time_def AS hrs,ROUND(smv*SUM(bac_qty)/60) AS sth,(COUNT(DISTINCT bac_lastup)-$time_def)*nop AS clh FROM $bai_pro.bai_log_buf WHERE bac_sec=$sec_x AND bac_date=\"".$date."\" GROUP BY bac_no+0";
		//$sqly="SELECT bac_no,bac_style AS style, couple,nop,smv, SUM(bac_qty) AS qty,COUNT(DISTINCT bac_lastup)-0.5 AS hrs,ROUND(smv*SUM(bac_qty)/60) AS sth,(COUNT(DISTINCT bac_lastup)-0.5)*nop AS clh FROM bai_pro.bai_log_buf WHERE bac_sec=$sec_x AND bac_date=\"".date("Y-m-d")."\" GROUP BY bac_no+0";
		//echo $sqly;
		$hrs[]=0;
		//echo $sqly;
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
		if((7.5*$shifts)> 0)
		{
			$plan_val=round(($plan_sah/(7.5*$shifts))*($hrs_count-$time_def),0);	
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

//echo "percentage:".$complete_percent;	

		
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
		if($username=="kiran")
		{
			echo "<td><div id=\"$id_new\"><a href=\"#\">$complete_percent/$plan_val</a></div></td>";	
		}
		else
		{
			// $url_sah= getFullURLLevel($_GET['r'],'production_kpi/sah_live_dashboard_V2.php',1,'N');
			// echo "<td><div id=\"$id_new\"><a href=\"$url_sah&sec_x=$section_id&rand=".rand()."\"></a></div></td>";	
			echo "<td><div id=\"$id_new\"><a href=\"http://".$_SERVER['HTTP_HOST']."/sfcs_app/app/dashboards/controllers/Factory_View/sah_live_dashboard_V2.php?sec_x=$section_id&rand=".rand()."\" target='_blank'></a></div></td>";
		}
		

	
}
			

?>