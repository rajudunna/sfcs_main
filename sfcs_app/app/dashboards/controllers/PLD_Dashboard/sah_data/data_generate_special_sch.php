
<?php

//Collecting the dates dynamically
$today=date("Y-m-d");
$start=date("Y-m-01");
$end=date("Y-m-31");
$yest=date("Y-m-d",strtotime('- 1 day'));

if(date("F",strtotime($yest))!=date("F",strtotime($today)))
{
	$yest=$today;
}

include("header_sch.php");

//chnage the module details
//$sections=array("1","2","3","4");

//Collecting the sections dynamically
$sqlq=mysqli_query($GLOBALS["___mysqli_ston"], "select DISTINCT section as sec FROM bai_pro.grand_rep WHERE DATE BETWEEN \"".$start."\" AND \"".$end."\" order by section+0");
while($rowq=mysqli_fetch_array($sqlq))
{
	$sections[]=$rowq["sec"];
}

//added section hod names 
//$hods=array("Bhavani","Nuwan","Kapila","Dilan");
//$plan_sah_mod=array("56324","57567","60026","61496");

$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select SUM(act_sth) FROM bai_pro.grand_rep WHERE DATE BETWEEN \"".$start."\" AND \"".$end."\"");
while($row=mysqli_fetch_array($sql))
{
	$act=ROUND($row["SUM(act_sth)"],0);
}


$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select SUM(act_sth),count(distinct date) as dat FROM bai_pro.grand_rep WHERE DATE BETWEEN \"".$start."\" AND \"".$yest."\"");
//echo "select SUM(act_sth),count(distinct date) as dat FROM grand_rep WHERE DATE BETWEEN \"".$start."\" AND \"".$yest."\"";
while($row=mysqli_fetch_array($sql))
{
	$act_ysd=ROUND($row["SUM(act_sth)"],0);
	$date_count=$row["dat"];
}

for($i=0;$i<sizeof($sections);$i++)
{	
	
	$sql_hods="select sec_head from bai_pro3.sections_db where sec_id=\"".$sections[$i]."\"";
	$sql_result_hod=mysqli_query($con, $sql_hods) or die("Error".$sql_hods."-".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row_hods=mysqli_fetch_array($sql_result_hod))
	{
		$hods[]=$row_hods["sec_head"];
	}
	
	$sql_mod=mysqli_query($GLOBALS["___mysqli_ston"], "select SUM(plan_sth),SUM(act_sth) FROM bai_pro.grand_rep WHERE section=\"".$sections[$i]."\" and DATE BETWEEN \"".$start."\" AND \"".$yest."\"");
	//echo "select SUM(plan_sth),SUM(act_sth) FROM grand_rep WHERE section=\"".$sections[$i]."\" and DATE BETWEEN \"".$start."\" AND \"".$yest."\""."<br>";
	while($row_mod=mysqli_fetch_array($sql_mod))
	{
		$plan_ysd_mod[]=ROUND($row_mod["SUM(plan_sth)"],0);
		$act_ysd_mod[]=ROUND($row_mod["SUM(act_sth)"],0);
		if($plan_ysd_mod[$i] > 0)
		{
			$achieved_per[]=round($act_ysd_mod[$i]*100/$plan_ysd_mod[$i],0);
		}
		else
		{
			$achieved_per[]=0;
		}
	}	
	
	$sql_mod1=mysqli_query($GLOBALS["___mysqli_ston"], "select SUM(plan_sth),SUM(act_sth) FROM bai_pro.grand_rep WHERE section=\"".$sections[$i]."\" and DATE BETWEEN \"".$start."\" AND \"".$today."\"");
	//echo "select SUM(act_sth) FROM grand_rep WHERE section=\"".$sections[$i]."\" and DATE BETWEEN \"".$start."\" AND \"".$today."\""."<br>";
	while($row_mod1=mysqli_fetch_array($sql_mod1))
	{
		$plan_till_mod[]=ROUND($row_mod1["SUM(plan_sth)"],0);
		$act_till_mod[]=ROUND($row_mod1["SUM(act_sth)"],0);
		if($plan_till_mod[$i] > 0)
		{
			$achieved_per_till[]=round($act_till_mod[$i]*100/$plan_till_mod[$i],0);
		}
		else
		{
			$achieved_per_till[]=0;
		}
	}
}

$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select SUM(act_sth) FROM bai_pro.grand_rep WHERE DATE=\"$today\"");
while($row=mysqli_fetch_array($sql))
{
	$today_act=round($row["SUM(act_sth)"],0);
}

$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select count(DISTINCT(date)) as date FROM bai_pro.grand_rep WHERE DATE BETWEEN \"".$start."\" AND \"".$end."\"");
while($row=mysqli_fetch_array($sql))
{
	$dates=$row["date"];
}

// include"../sah_monthly_status/data.php";
include("C:/xampp/htdocs/sfcs_app/app/dashboards/controllers/PLD_Dashboard/sah_monthly_status/data.php");
//$target=$fac_plan;
//Target set as default
$target=array_sum($plan_sah_mod);
//$wor_days="27";
$wor_days=sizeof($date1);
//$wor_days=22;
$sah_dif=$target-$act;
$stnd_hrs=round($act,0);

$sms_sec_act=array();
$sms_sec_plan=array();
$sms_last_hour_sah=array();

if($date_count == 0)
{
	$date_count=1;
}
$achievment_per_array=array();
$table1="<table border=1 height='250' align='center' style='border-collapse: collapse;text-align:center;border: 1px solid black;'>";
$table1.="<tr><th>Sections</th><th>Hod</th><th>Plan SAH</th><th>Actual SAH</th><th>Remaining SAH</th><th>Plan</br>/Day</th><th>Plan SAH(YSD)</th><th>Actual SAH(YSD)</th><th>Achievement % (YSD)</th><th>Achieved</br>/Day</th><th>Required</br>/Day</th></tr>";
for($i=0;$i<sizeof($sections);$i++)
{
	$today_act_sec=0;
	$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select SUM(act_sth) FROM bai_pro.grand_rep WHERE DATE=\"$today\" and section=".$sections[$i]);
	while($row=mysqli_fetch_array($sql))
	{
		$today_act_sec=round($row["SUM(act_sth)"],0);		
	}
	$sms_sec_act[]=$today_act_sec;
	
	$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select round(SUM(bac_qty*smv)/60,0) as sah FROM bai_pro.bai_log_buf WHERE bac_date=\"$today\" and hour(bac_lastup)=".(date("H")-1)." and bac_sec=".$sections[$i]);
	while($row=mysqli_fetch_array($sql))
	{
		$sms_last_hour_sah[]=round($row["sah"],0);		
	}

	$per_day_plan=round($plan_sah_mod[$i]/$wor_days,0);
	$req_day=round((($plan_sah_mod[$i]-$act_ysd_mod[$i])/($wor_days-$date_count)),0);
	$table1.="<tr>";
	$table1.="<td>".($i+1)."</td>";
	$table1.="<td>".$hods[$i]."</td>";
	$table1.="<td>".$plan_sah_mod[$i]."</td>";
	$table1.="<td>".$act_till_mod[$i]."</td>";
	$table1.="<td>".($plan_sah_mod[$i]-$act_ysd_mod[$i])."</td>";
	$table1.="<td>".$per_day_plan."</td>";
	$table1.="<td>".round($per_day_plan*$date_count,0)."</td>";
	
	//capturing the achievement % and section hod details based on section performance
	$sql_mod11=mysqli_query($GLOBALS["___mysqli_ston"], "select ROUND(SUM(act_sth)*100/".round($per_day_plan*$date_count,0).",0)AS per,section FROM bai_pro.grand_rep WHERE DATE BETWEEN \"".$start."\" AND \"".$yest."\" and section=\"".$sections[$i]."\" GROUP BY section ORDER BY ROUND(SUM(act_sth)*100/".round($per_day_plan*$date_count).",0) desc");
	//echo "select ROUND(SUM(act_sth)*100/".round($per_day_plan*$date_count,0).",0)AS per,section FROM grand_rep WHERE DATE BETWEEN \"".$start."\" AND \"".$yest."\" and section=\"".$sections[$i]."\" ORDER BY ROUND(SUM(act_sth)*100/".round($per_day_plan*$date_count).",0) desc"."<br>";
	if(mysqli_num_rows($sql_mod11) > 0)
	{
		while($row_mod11=mysqli_fetch_array($sql_mod11))
		{
			$achieved_per_array[]=ROUND($row_mod11["per"],0);
		}
	}
	else
	{
		$achieved_per_array[]=0;
	}
	
	$section_array[]=$hods[$i];

	$table1.="<td>".round($act_ysd_mod[$i],0)."</td>";
	$table1.="<td>".(round((round($act_ysd_mod[$i],0)*100/round($per_day_plan*$date_count,0)),0))."%</td>";
	$table1.="<td>".round($act_ysd_mod[$i]/$date_count,0)."</td>";
	if($per_day_plan >= $req_day)
	{
		$table1.="<td bgcolor='#008000'>".$req_day."</td>";
		$sms_sec_plan[]=$req_day;
	}
	else
	{
		$table1.="<td bgcolor='#FF4500'>".$req_day."</td>";
		$sms_sec_plan[]=$req_day;
	}
	$table1.="</tr>";
	if($i!=4)
	{
		$per_day_plan_tot=$per_day_plan_tot+$per_day_plan;
		$plan_till_mod_ref=$plan_till_mod_ref+round($per_day_plan*$date_count,0);
	}
	$actual_till_mod_ref=$actual_till_mod_ref+round($act_ysd_mod[$i],0);
}
/*$table1.="<tr><td style='text-align=center;' colspan=2>Factory</td><td>".(array_sum($plan_sah_mod)-$plan_sah_mod[4])."</td><td>".array_sum($act_till_mod)."</td><td>".((array_sum($plan_sah_mod)-$plan_sah_mod[4])-array_sum($act_till_mod))."</td>";
$table1.="<td>".$per_day_plan_tot."</td><td>".$plan_till_mod_ref."</td><td>".$actual_till_mod_ref."</td><td>".round($actual_till_mod_ref*100/$plan_till_mod_ref,0)."%</td>";
$table1.="<td>".round($actual_till_mod_ref/$date_count,0)."</td>";
if(round(((array_sum($plan_sah_mod)-array_sum($act_ysd_mod))/($wor_days-$date_count)),0) <= round(array_sum($plan_sah_mod)/30,0))
{
	$table1.="<td bgcolor='#008000'>".round((((array_sum($plan_sah_mod)-$plan_sah_mod[4])-$actual_till_mod_ref)/($wor_days-$date_count)),0)."</td>";
	
}
else
{
	$table1.="<td bgcolor='#FF4500'>".round((((array_sum($plan_sah_mod)-$plan_sah_mod[4])-$actual_till_mod_ref)/($wor_days-$date_count)),0)."</td>";
	
}
$table1.="</tr>";*/
$table1.="<tr><td style='text-align=center;' colspan=2>Factory</td><td>".(array_sum($plan_sah_mod))."</td><td>".array_sum($act_till_mod)."</td><td>".((array_sum($plan_sah_mod))-array_sum($act_till_mod))."</td>";
$table1.="<td>".$per_day_plan_tot."</td><td>".$plan_till_mod_ref."</td><td>".$actual_till_mod_ref."</td><td>".round($actual_till_mod_ref*100/$plan_till_mod_ref,0)."%</td>";
$table1.="<td>".round($actual_till_mod_ref/$date_count,0)."</td>";
if(round(((array_sum($plan_sah_mod)-array_sum($act_ysd_mod))/($wor_days-$date_count)),0) <= round(array_sum($plan_sah_mod)/30,0))
{
	$table1.="<td bgcolor='#008000'>".round((((array_sum($plan_sah_mod))-$actual_till_mod_ref)/($wor_days-$date_count)),0)."</td>";
	
}
else
{
	$table1.="<td bgcolor='#FF4500'>".round((((array_sum($plan_sah_mod))-$actual_till_mod_ref)/($wor_days-$date_count)),0)."</td>";
	
}
$table1.="</tr>";
$table1.="</table>";
echo $table1;

//Sorting of Sections according to section achievment %
for($x=0;$x<sizeof($achieved_per_array);$x++)
{
	for($y=0;$y<sizeof($achieved_per_array);$y++)
	{
		if($achieved_per_array[$x]>$achieved_per_array[$y])
		{
			$temp_val=$achieved_per_array[$x];
			$achieved_per_array[$x]=$achieved_per_array[$y];
			$achieved_per_array[$y]=$temp_val;
			
			$temp_sec=$section_array[$x];
			$section_array[$x]=$section_array[$y];
			$section_array[$y]=$temp_sec;
		}
	}
}

$achieved_per_array[]=round($actual_till_mod_ref*100/$plan_till_mod_ref,0);
$section_array[]="Factory";

//Taken array of achiement percentage and section hod details based achivemnet %
$ach_per=implode(",",$achieved_per_array);
$sec_arr="'".implode("','",$section_array)."'";

$diff=$wor_days-$dates+1;

echo $diff."--".$wor_days."--".$dates;

if($today=="2012-06-01")
{
	$act_ysd=0;
}

if($diff<=0)
{
	$div=1;
}
else
{
	if($today=="2012-06-01")
	{
		$div=$wor_days;
	}
	else
	{
		$div=$diff;
	}
}
//$avg=round((($target-$act_ysd)/($div)),0);
$avg=round($target-$act);
$data_sym="$";
$File = "data.php";
$fh = fopen($File, 'w') or die("can't open file");
$stringData = "<?php ".$data_sym."target=".$target."; ".$data_sym."sah_today=".$act."; ".$data_sym."sha_yesterday=".$act_ysd."; ".$data_sym."days=".$diff."; ".$data_sym."avg=".$avg."; ".$data_sym."table1=\"".$table1."\"; ".$data_sym."ach_per=\"".$ach_per."\"; ".$data_sym."sec_arr=\"".$sec_arr."\"; ?>";
fwrite($fh, $stringData);
fclose($fh);

//Hourly SMS - V1
$sms_txt="270K Updates\r\nS-P-A-A%\r\n";

for($i=0;$i<sizeof($sections);$i++)
{
	$sms_txt.=$sections[$i]."-".$sms_sec_plan[$i]."-".$sms_sec_act[$i]."-".round(($sms_sec_act[$i]/$sms_sec_plan[$i])*100,0)."\r\n";
}
$sms_txt.="F-".array_sum($sms_sec_plan)."-".array_sum($sms_sec_act)."-".round((array_sum($sms_sec_act)/array_sum($sms_sec_plan))*100,0);

$File = "hourly_sms.txt";
$fh = fopen($File, 'w') or die("can't open file");
$stringData = $sms_txt;
fwrite($fh, $stringData);
fclose($fh);

//Hourly SMS - V1
$sms_txt="270K Updates\r\nS-LHS-CS\r\n";

for($i=0;$i<sizeof($sections);$i++)
{
	$sms_txt.=$sections[$i]."-".$sms_last_hour_sah[$i]."-".$sms_sec_act[$i]."\r\n";
}
$sms_txt.="F-".array_sum($sms_last_hour_sah)."-".array_sum($sms_sec_act);

$File = "hourly_sms_hourly.txt";
$fh = fopen($File, 'w') or die("can't open file");
$stringData = $sms_txt;
fwrite($fh, $stringData);
fclose($fh);
	
	

//To run only december dhamaka schedule
// if(isset($_GET['special']))
// {
	// echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
// }
// else
// {
	// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../IU_Clock/speed_clock.php\"; }</script>";
// }

?>
