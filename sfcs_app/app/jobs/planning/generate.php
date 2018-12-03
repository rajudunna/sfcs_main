<?php 
$include_path=getenv('config_job_path');

include($include_path.'\sfcs_app\common\config\config_jobs.php');
$start_timestamp = microtime(true);
error_reporting(0);
?>

<?php

$shifts_array = $conf->get('shifts');
$date=date("Y-m-d");

$sql="delete from $bai_pro.bai_bac";
mysqli_query($link, $sql) or exit("Sql Error1-$sql".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="delete from $bai_pro.pro_mod_today";
mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="delete from $bai_pro.pro_plan_today";
mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="delete from $bai_pro.pro_style_today";
mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="select * from $bai_pro3.module_master";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$mod_number=$sql_row['module_name'];
	$mod_section=$sql_row['section'];
	$stat=$sql_row['status'];
	$remarks=$sql_row['module_description'];
	$couple=count($shifts_array);
	$ref_code=$date."-".$mod_number;
	for($i=0;$i<sizeof($shifts_array);$i++)
	{
		$sql="insert ignore into $bai_pro.pro_mod (ref_id) values (\"$ref_code\")";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql="update $bai_pro.pro_mod set mod_no=$mod_number, mod_date=\"$date\", mod_sec=$mod_section, mod_shift='$shifts_array[$i], mod_stat=\"$stat\", mod_remarks=\"$remarks\", mod_lupdate=\"$date\", couple=$couple where ref_id=\"$ref_code\"";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//NEW2011
		$sql="insert ignore into $bai_pro.pro_mod_today (ref_id) values (\"$ref_code\")";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql="update $bai_pro.pro_mod_today set mod_no=$mod_number, mod_date=\"$date\", mod_sec=$mod_section, mod_shift='$shifts_array[$i], mod_stat=\"$stat\", mod_remarks=\"$remarks\", mod_lupdate=\"$date\", couple=$couple where ref_id=\"$ref_code\"";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}	
}


if(mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "select * from $bai_pro.pro_style where date=\"$date\""))==0)
{

$sql="select * from $bai_pro.pro_style where date=(select max(date) from bai_pro.pro_style)";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$style=$sql_row['style'];
	$smv=$sql_row['smv'];
	$nop=$sql_row['nop'];
	$remarks=$sql_row['remarks'];
	$buyer=$sql_row['buyer'];
	
	$nop1=$sql_row['nop1'];
	$nop2=$sql_row['nop2'];
	$nop3=$sql_row['nop3'];
	$nop4=$sql_row['nop4'];
	$nop5=$sql_row['nop5'];
	
	$smv1=$sql_row['smv1'];
	$smv2=$sql_row['smv2'];
	$smv3=$sql_row['smv3'];
	$smv4=$sql_row['smv4'];
	$smv5=$sql_row['smv5'];
	
	$movex_styles_db=$sql_row['movex_styles_db'];
	


	$ref_code=$date."-".$style;

	$sql="insert ignore into $bai_pro.pro_style (sno) values (\"$ref_code\")";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql="update $bai_pro.pro_style set style=\"$style\", date=\"$date\", smv=$smv, nop=$nop,  remarks=\"$remarks\", buyer=\"$buyer\", nop1=$nop1, nop2=$nop2, nop3=$nop3, nop4=$nop4, nop5=$nop5, smv1=$smv1, smv2=$smv2, smv3=$smv3, smv4=$smv4, smv5=$smv5, movex_styles_db=\"$movex_styles_db\"  where sno=\"$ref_code\"";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	//NEW2011
	$sql="insert ignore into $bai_pro.pro_style_today (sno) values (\"$ref_code\")";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql="update $bai_pro.pro_style_today set style=\"$style\", date=\"$date\", smv=$smv, nop=$nop,  remarks=\"$remarks\", buyer=\"$buyer\", nop1=$nop1, nop2=$nop2, nop3=$nop3, nop4=$nop4, nop5=$nop5, smv1=$smv1, smv2=$smv2, smv3=$smv3, smv4=$smv4, smv5=$smv5, movex_styles_db=\"$movex_styles_db\"  where sno=\"$ref_code\"";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	//NEW2011
	
}
}
else
{
	$sql="delete from $bai_pro.pro_style where date>=\"".date("Y-m-d")."\"";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql="select * from $bai_pro.pro_style where date=(select max(date) from bai_pro.pro_style)";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$style=$sql_row['style'];
		$smv=$sql_row['smv'];
		$nop=$sql_row['nop'];
		$remarks=$sql_row['remarks'];
		$buyer=$sql_row['buyer'];
		
		$nop1=$sql_row['nop1'];
		$nop2=$sql_row['nop2'];
		$nop3=$sql_row['nop3'];
		$nop4=$sql_row['nop4'];
		$nop5=$sql_row['nop5'];
		
		$smv1=$sql_row['smv1'];
		$smv2=$sql_row['smv2'];
		$smv3=$sql_row['smv3'];
		$smv4=$sql_row['smv4'];
		$smv5=$sql_row['smv5'];
		
		$movex_styles_db=$sql_row['movex_styles_db'];
		
	
	
		$ref_code=$date."-".$style;
	
		$sql="insert ignore into $bai_pro.pro_style (sno) values (\"$ref_code\")";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql="update $bai_pro.pro_style set style=\"$style\", date=\"$date\", smv=$smv, nop=$nop,  remarks=\"$remarks\", buyer=\"$buyer\", nop1=$nop1, nop2=$nop2, nop3=$nop3, nop4=$nop4, nop5=$nop5, smv1=$smv1, smv2=$smv2, smv3=$smv3, smv4=$smv4, smv5=$smv5, movex_styles_db=\"$movex_styles_db\"  where sno=\"$ref_code\"";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//NEW2011
		$sql="insert ignore into $bai_pro.pro_style_today (sno) values (\"$ref_code\")";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql="update $bai_pro.pro_style_today set style=\"$style\", date=\"$date\", smv=$smv, nop=$nop,  remarks=\"$remarks\", buyer=\"$buyer\", nop1=$nop1, nop2=$nop2, nop3=$nop3, nop4=$nop4, nop5=$nop5, smv1=$smv1, smv2=$smv2, smv3=$smv3, smv4=$smv4, smv5=$smv5, movex_styles_db=\"$movex_styles_db\"  where sno=\"$ref_code\"";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		//NEW2011
		
	}
}

$sql1="select * from $bai_pro.tbl_freez_plan_log where date='".$date."'";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result1))
{
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$mod_no=$sql_row['mod_no'];
		$shift=$sql_row['shift'];
		$plan_eff=$sql_row['plan_eff'];
		$plan_pro=$sql_row['plan_pro'];
		$remarks='';
		$sec_no=$sql_row['sec_no'];
		$couple=count($shifts_array);
		$fix_nop=$sql_row['nop'];	
		$plan_clh=$sql_row['plan_clh'];
		$plan_sah=$sql_row['plan_sah'];	
		$plan_eff_ex=0;
		$ref_code=$date."-".$mod_no."-".$shift;

		$sql="insert ignore into $bai_pro.pro_plan (plan_tag) values (\"$ref_code\")";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql="update $bai_pro.pro_plan set mod_no=$mod_no, date=\"$date\", remarks=\"$remarks\", shift=\"$shift\", plan_eff=$plan_eff, plan_pro=$plan_pro, sec_no=$sec_no, act_hours=7.5, couple=$couple, fix_nop=$fix_nop,plan_clh=$plan_clh,plan_sah=$plan_sah, plan_eff_ex=$plan_eff_ex where plan_tag=\"$ref_code\"";
		mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//NEW2011
		$sql="insert ignore into $bai_pro.pro_plan_today (plan_tag) values (\"$ref_code\")";
		mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql="update $bai_pro.pro_plan_today set mod_no=$mod_no, date=\"$date\", remarks=\"$remarks\", shift=\"$shift\", plan_eff=$plan_eff, plan_pro=$plan_pro, sec_no=$sec_no, act_hours=7.5, couple=$couple, fix_nop=$fix_nop,plan_clh=$plan_clh,plan_sah=$plan_sah, plan_eff_ex=$plan_eff_ex where plan_tag=\"$ref_code\"";
		mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
		//NEW2011		
	}
}
else
{
	$sql1="select * from $bai_pro.tbl_freez_plan_log where date=(select max(date) from $bai_pro.tbl_freez_plan_log)";
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$mod_no=$sql_row['mod_no'];
		$shift=$sql_row['shift'];
		$plan_eff=$sql_row['plan_eff'];
		$plan_pro=$sql_row['plan_pro'];
		$remarks='';
		$sec_no=$sql_row['sec_no'];
		$couple=count($shifts_array);
		$fix_nop=$sql_row['nop'];	
		$plan_clh=$sql_row['plan_clh'];
		$plan_sah=$sql_row['plan_sah'];	
		$plan_eff_ex=0;
		$ref_code=$date."-".$mod_no."-".$shift;

		$sql="insert ignore into $bai_pro.pro_plan (plan_tag) values (\"$ref_code\")";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql="update $bai_pro.pro_plan set mod_no=$mod_no, date=\"$date\", remarks=\"$remarks\", shift=\"$shift\", plan_eff=$plan_eff, plan_pro=$plan_pro, sec_no=$sec_no, act_hours=7.5, couple=$couple, fix_nop=$fix_nop,plan_clh=$plan_clh,plan_sah=$plan_sah, plan_eff_ex=$plan_eff_ex where plan_tag=\"$ref_code\"";
		mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//NEW2011
		$sql="insert ignore into $bai_pro.pro_plan_today (plan_tag) values (\"$ref_code\")";
		mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql="update $bai_pro.pro_plan_today set mod_no=$mod_no, date=\"$date\", remarks=\"$remarks\", shift=\"$shift\", plan_eff=$plan_eff, plan_pro=$plan_pro, sec_no=$sec_no, act_hours=7.5, couple=$couple, fix_nop=$fix_nop,plan_clh=$plan_clh,plan_sah=$plan_sah, plan_eff_ex=$plan_eff_ex where plan_tag=\"$ref_code\"";
		mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
		//NEW2011		
	}
}	
$sql="insert into $bai_ict.report_alert_track(report,date) values ('PRO_NEW_DB','".date("Y-m-d H:i:s")."')";
$res=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if($res)
{
	print("inserted report_alert_track table successfully")."\n";
}

$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");


?>

<?php ((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res); 



?>