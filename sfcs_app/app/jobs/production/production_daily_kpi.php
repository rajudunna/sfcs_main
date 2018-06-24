
<?php
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
$today=date("Y-m-d",strtotime("-1 day"));


$sql="SELECT DISTINCT bac_date FROM $bai_pro.bai_log_buf WHERE bac_date<\"".date("Y-m-d")."\" ORDER BY bac_date DESC LIMIT 1";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$today=$sql_row['bac_date'];
}

//$today="2012-05-21";
$sql="select 
sum(plan_clh) as peff, 
sum(plan_clh) as aeff,
sum(plan_sth) as psah,
sum(act_sth) as asah,
sum(rework_qty) as rework,section
 from $bai_pro.grand_rep where date=\"$today\" group by section";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$peff=$sql_row['peff'];
	$aeff=$sql_row['aeff'];
	$psah=round($sql_row['psah'],2);
	$asah=round($sql_row['asah'],2);
	$rework=$sql_row['rework'];
	$section=$sql_row['section'];
	
	$first_hr_clh=0;
	$first_hr_sah=0;
		
	$sql1="SELECT bac_date,bac_sec,bac_no,bac_shift,nop,SUM(bac_qty) AS bac_qty, GROUP_CONCAT(DISTINCT bac_style) AS bac_style, ROUND(SUM((bac_qty*smv)/60),2) AS sah, (nop*2) AS clh  FROM $bai_pro.bai_log_buf WHERE bac_qty>0 AND HOUR(bac_lastup) IN (6,14) AND bac_date BETWEEN \"$today\" AND \"$today\" and bac_sec=$section GROUP BY bac_date,bac_no,bac_shift ORDER BY bac_date,bac_shift,bac_no";
//echo $sql1;
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$first_hr_sah+=$sql_row1['sah'];
		$first_hr_clh+=$sql_row1['clh'];
	}
	
	$sah_fall=0;
	$sql1="SELECT COALESCE(ROUND(SUM((bac_qty*smv)/60),2),0) AS sah FROM $bai_pro.bai_log_buf WHERE bac_date=\"$today\" and bac_sec=$section and date(log_time)=\"".date("Y-m-d")."\"GROUP BY bac_sec";
	//echo $sql1;
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$sah_fall=$sql_row1['sah'];
	}

	//recorded SAH
	
	$A3001="('".$today."','A3001','$section','PCLA',".$peff.")";
	$A3002="('".$today."','A3002','$section','ACLA',".$aeff.")";
	$A4001="('".$today."','A4001','$section','PSAH',".$psah.")";
	$A4002="('".$today."','A4002','$section','ASAH',".$asah.")";
	$A5001="('".$today."','A5001','$section','REW',".$rework.")";
	$A6001="('".$today."','A6001','$section','FIRSTSAH',".$first_hr_sah.")";
	$A6002="('".$today."','A6002','$section','FALL',".$sah_fall.")";
	$A6003="('".$today."','A6003','$section','FIRSTCLA',".$first_hr_clh.")";
	
	
	//BAI KPI TRACK
	$sql1="insert into $bai_kpi.kpi_tracking(rep_date,parameter,title,category,value) values $A3001,$A3002,$A4001,$A4002,$A5001,$A6001,$A6002,$A6003";
	//echo $sql1."<Br/>";
	$res1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($res1)
	{
		print("Inserted Successfully")."\n";
	}
	
}

$rej1=0;
$rej2=0;
$rej3=0;
$rej4=0;
$rej5=0;
$rej6=0;

$sql="SELECT qms_qty,SUBSTRING_INDEX(remarks,\"-\",1) as mod_no from $bai_pro3.bai_qms_db where log_date='$today' and qms_tran_type=3";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	
	$mod=$sql_row['mod_no'];
	if($mod>0 and $mod<13)
	{
		$rej1+=$sql_row['qms_qty'];
	}
	
	if($mod>12 and $mod<25)
	{
		$rej2+=$sql_row['qms_qty'];
	}
	
	if($mod>24 and $mod<37)
	{
		$rej3+=$sql_row['qms_qty'];
	}
	
	if($mod>36 and $mod<49)
	{
		$rej4+=$sql_row['qms_qty'];
	}
	
	if($mod>48 and $mod<61)
	{
		$rej5+=$sql_row['qms_qty'];
	}
	
	if($mod>60 and $mod<72)
	{
		$rej6+=$sql_row['qms_qty'];
	}
}

$A1="('".$today."','A5002','1','REJ',".$rej1.")";
$A2="('".$today."','A5002','2','REJ',".$rej2.")";
$A3="('".$today."','A5002','3','REJ',".$rej3.")";
$A4="('".$today."','A5002','4','REJ',".$rej4.")";
$A5="('".$today."','A5002','5','REJ',".$rej5.")";
$A6="('".$today."','A5002','6','REJ',".$rej6.")";

	//BAI KPI TRACK
	$sql="insert into $bai_kpi.kpi_tracking(rep_date,parameter,title,category,value) values $A1,$A2,$A3,$A4,$A5,$A6";
	//echo $sql."<Br/>";
	$res=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($res)
	{
	 print("inserted successfully")."\n";
	}
	
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>
