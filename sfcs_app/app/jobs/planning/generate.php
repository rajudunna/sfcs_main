<?php 
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
$start_timestamp = microtime(true);
error_reporting(0);
?>

<?php

$date=date("Y-m-d");

$sql="delete from $bai_pro.bai_bac";
mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));

//NEW2011
$sql="delete from $bai_pro.pro_mod_today";
mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql="delete from $bai_pro.pro_plan_today";
mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql="delete from $bai_pro.pro_style_today";
mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));

//NEW2011


if(mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "select * from $bai_pro.pro_mod where mod_date=\"$date\""))==0)
{

$sql="select * from $bai_pro.pro_mod where mod_date=(select max(mod_date) from bai_pro.pro_mod)";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$division=$sql_row['division'];
	$buyer=$sql_row['buyer'];
	$delivery=$sql_row['delivery'];
	$color=$sql_row['color'];
			
	$mod_number=$sql_row['mod_no'];
	$mod_section=$sql_row['mod_sec'];
	$mod_shifts=$sql_row['mod_shift'];
	$stat=$sql_row['mod_stat'];
	$mod_style=$sql_row['mod_style'];
	$remarks=$sql_row['mod_remarks'];
	$couple=$sql_row['couple'];


	$ref_code=$date."-".$mod_number;

	$sql="insert ignore into $bai_pro.pro_mod (ref_id) values (\"$ref_code\")";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql="update $bai_pro.pro_mod set mod_no=$mod_number, mod_date=\"$date\", mod_sec=$mod_section, mod_shift=\"$mod_shifts\", mod_stat=\"$stat\",  mod_style=\"$mod_style\",  mod_lqty=0, mod_remarks=\"$remarks\", division=\"$division\", buyer=\"$buyer\", delivery=\"$delivery\", color=\"$color\", mod_lupdate=\"$date\", couple=$couple where ref_id=\"$ref_code\"";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	//NEW2011
	$sql="insert ignore into $bai_pro.pro_mod_today (ref_id) values (\"$ref_code\")";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql="update $bai_pro.pro_mod_today set mod_no=$mod_number, mod_date=\"$date\", mod_sec=$mod_section, mod_shift=\"$mod_shifts\", mod_stat=\"$stat\",  mod_style=\"$mod_style\",  mod_lqty=0, mod_remarks=\"$remarks\", division=\"$division\", buyer=\"$buyer\", delivery=\"$delivery\", color=\"$color\", mod_lupdate=\"$date\", couple=$couple where ref_id=\"$ref_code\"";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	//NEW2011
	
}

}
else
{
	$sql="delete from $bai_pro.pro_mod where mod_date>=\"".$date."\"";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql="select * from $bai_pro.pro_mod where mod_date=(select max(mod_date) from bai_pro.pro_mod)";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$division=$sql_row['division'];
		$buyer=$sql_row['buyer'];
		$delivery=$sql_row['delivery'];
		$color=$sql_row['color'];
				
		$mod_number=$sql_row['mod_no'];
		$mod_section=$sql_row['mod_sec'];
		$mod_shifts=$sql_row['mod_shift'];
		$stat=$sql_row['mod_stat'];
		$mod_style=$sql_row['mod_style'];
		$remarks=$sql_row['mod_remarks'];
		$couple=$sql_row['couple'];
	
	
		$ref_code=$date."-".$mod_number;
	
		$sql="insert ignore into $bai_pro.pro_mod (ref_id) values (\"$ref_code\")";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql="update $bai_pro.pro_mod set mod_no=$mod_number, mod_date=\"$date\", mod_sec=$mod_section, mod_shift=\"$mod_shifts\", mod_stat=\"$stat\",  mod_style=\"$mod_style\",  mod_lqty=0, mod_remarks=\"$remarks\", division=\"$division\", buyer=\"$buyer\", delivery=\"$delivery\", color=\"$color\", mod_lupdate=\"$date\", couple=$couple where ref_id=\"$ref_code\"";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//NEW2011
		$sql="insert ignore into $bai_pro.pro_mod_today (ref_id) values (\"$ref_code\")";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql="update $bai_pro.pro_mod_today set mod_no=$mod_number, mod_date=\"$date\", mod_sec=$mod_section, mod_shift=\"$mod_shifts\", mod_stat=\"$stat\",  mod_style=\"$mod_style\",  mod_lqty=0, mod_remarks=\"$remarks\", division=\"$division\", buyer=\"$buyer\", delivery=\"$delivery\", color=\"$color\", mod_lupdate=\"$date\", couple=$couple where ref_id=\"$ref_code\"";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		//NEW2011
		
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
	$sql="delete from $bai_pro.pro_style where date>=\"".$date."\"";
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

if(mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "select * from $bai_pro.pro_plan where date=\"$date\""))==0)
{
$sql="select * from $bai_pro.tbl_freez_plan_log where date='".$date."'";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$mod_no=$sql_row['mod_no'];
	$shift=$sql_row['shift'];
	$plan_eff=$sql_row['plan_eff'];
	$plan_pro=$sql_row['plan_pro'];
	$remarks='';
	$sec_no=$sql_row['sec_no'];
	$couple=1;
	$fix_nop=16;
	
	$plan_clh=$sql_row['plan_clh'];
	$plan_sah=$sql_row['plan_sah'];
	
	$plan_eff_ex=0;

	$act_hrs=0;
	$ref_code=$date."-".$mod_no."-".$shift;
	$sql_hr="select * from $bai_pro.pro_atten_hours where date='$date' and shift='".$shift."'";
	// echo $sql_hr."<br>";
	$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"])); 
	if(mysqli_num_rows($sql_result_hr) >0)
	{
		while($sql_row_hr=mysqli_fetch_array($sql_result_hr)) 
		{ 
			$start_time=$sql_row_hr['start_time'];
			$end_time=$sql_row_hr['end_time'];
			$diff_time=$end_time-$start_time;
			$act_hrs=$diff_time-0.5;
		}
	}else{
		$act_hrs=7.5;
	}


	$sql="insert ignore into $bai_pro.pro_plan (plan_tag) values (\"$ref_code\")";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql="update $bai_pro.pro_plan set mod_no=$mod_no, date=\"$date\", remarks=\"$remarks\", shift=\"$shift\", plan_eff=$plan_eff, plan_pro=$plan_pro, sec_no=$sec_no, act_hours=\"$act_hrs\", couple=$couple, fix_nop=$fix_nop,plan_clh=$plan_clh,plan_sah=$plan_sah, plan_eff_ex=$plan_eff_ex where plan_tag=\"$ref_code\"";
	echo $sql."<br>";
	mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	//NEW2011
	$sql="insert ignore into $bai_pro.pro_plan_today (plan_tag) values (\"$ref_code\")";
	mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql="update $bai_pro.pro_plan_today set mod_no=$mod_no, date=\"$date\", remarks=\"$remarks\", shift=\"$shift\", plan_eff=$plan_eff, plan_pro=$plan_pro, sec_no=$sec_no, act_hours=\"$act_hrs\", couple=$couple, fix_nop=$fix_nop,plan_clh=$plan_clh,plan_sah=$plan_sah, plan_eff_ex=$plan_eff_ex where plan_tag=\"$ref_code\"";
	echo $sql."<br>";

	mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
	//NEW2011
	
}

}
else
{
	$sql="delete from $bai_pro.pro_plan where date>=\"".$date."\"";
	$res9=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($res9)
	{
		print("deleted from  pro_plan table successfully")."\n";
	}
	$sql="select * from $bai_pro.pro_plan where date=(select max(date) from bai_pro.pro_plan)";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$mod_no=$sql_row['mod_no'];
		$dat=$sql_row['date'];
		$shift=$sql_row['shift'];
		$plan_eff=$sql_row['plan_eff'];
		$plan_pro=$sql_row['plan_pro'];
		$remarks=$sql_row['remarks'];
		$sec_no=$sql_row['sec_no'];
		$couple=$sql_row['couple'];
		$fix_nop=$sql_row['fix_nop'];
		
		$plan_clh=$sql_row['plan_clh'];
		$plan_sah=$sql_row['plan_sah'];
		
		$plan_eff_ex=$sql_row['plan_eff_ex'];
	
		$sql_hr="select * from $bai_pro.pro_atten_hours where date='$dat' and shift='".$shift."'";
		// echo $sql_hr."<br>";
		$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"])); 
		if(mysqli_num_rows($sql_result_hr) >0)
		{
			while($sql_row_hr=mysqli_fetch_array($sql_result_hr)) 
			{ 
				$start_time=$sql_row_hr['start_time'];
				$end_time=$sql_row_hr['end_time'];
				$diff_time=$end_time-$start_time;
				$act_hrs=$diff_time-0.5;
			}
		}else{
			$act_hrs=7.5;
		}
		$ref_code=$date."-".$mod_no."-".$shift;
	
		$sql="insert ignore into $bai_pro.pro_plan (plan_tag) values (\"$ref_code\")";
		$res8=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($res8)
		{
			print("inserted into pro_plan table successfully")."\n";
		}
		$sql="update $bai_pro.pro_plan set mod_no=$mod_no, date=\"$date\",remarks=\"$remarks\", shift=\"$shift\", plan_eff=$plan_eff, plan_pro=$plan_pro, sec_no=$sec_no, act_hours=\"$act_hrs\" couple=$couple, fix_nop=$fix_nop,plan_clh=$plan_clh,plan_sah=$plan_sah, plan_eff_ex=$plan_eff_ex where plan_tag=\"$ref_code\"";
		echo $sql."<br>";

		$res7=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($res7)
		{
			print("updated pro_plan table successfully")."\n";
		}
		//NEW2011
		$sql="insert ignore into $bai_pro.pro_plan_today (plan_tag) values (\"$ref_code\")";
		$res6=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($res6)
		{
			print("updated pro_plan_today table successfully")."\n";
		}
		$sql="update $bai_pro.pro_plan_today set mod_no=$mod_no, date=\"$date\", remarks=\"$remarks\", shift=\"$shift\", plan_eff=$plan_eff,plan_pro=$plan_pro, sec_no=$sec_no, act_hours=\"$act_hrs\", couple=$couple, fix_nop=$fix_nop,plan_clh=$plan_clh,plan_sah=$plan_sah, plan_eff_ex=$plan_eff_ex where plan_tag=\"$ref_code\"";
		echo $sql."<br>";

		$res5=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($res5)
		{
			print("updated pro_plan_today table successfully")."\n";
		}
		//NEW2011
		
	}
	
}

//New 20160519 // KiranG to update based on freezed plan.
if(mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "select * from $bai_pro.tbl_freez_plan_log where date=\"$date\""))>1)
{
	
	$sql="select * from $bai_pro.tbl_freez_plan_log where date=\"$date\"";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$mod_no=$sql_row['mod_no'];
		$shift=$sql_row['shift'];
		$plan_eff=$sql_row['plan_eff'];
		$plan_pro=$sql_row['plan_pro'];
		$sec_no=$sql_row['sec_no'];
		
		$plan_clh=$sql_row['plan_clh'];
		$plan_sah=$sql_row['plan_sah'];
		
	
		$ref_code=$date."-".$mod_no."-".$shift;
	
		
		
		$sql="update $bai_pro.pro_plan set mod_no=$mod_no, date=\"$date\",shift=\"$shift\", plan_eff=$plan_eff,plan_pro=$plan_pro,plan_clh=$plan_clh,plan_sah=$plan_sah where plan_tag=\"$ref_code\"";
		$res4=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($res4)
		{
			print("updated pro_plan table successfully")."\n";
		}
		$sql="update $bai_pro.pro_plan_today set mod_no=$mod_no,date=\"$date\",shift=\"$shift\", plan_eff=$plan_eff, plan_pro=$plan_pro,plan_clh=$plan_clh,plan_sah=$plan_sah where plan_tag=\"$ref_code\"";
		$res3=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($res3)
		{
			print("updated pro_plan_today table successfully")."\n";
		}
		//NEW2011
	}
	
	//Reset Values
	
	$sql="select * from $bai_pro.pro_plan_today where plan_tag not in (select plan_tag from bai_pro.tbl_freez_plan_log where date=\"$date\")";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
 		$ref_code=$sql_row['ref_code'];
		
		$sql="update $bai_pro.pro_plan_today set plan_eff=0,plan_pro=0,plan_clh=0,plan_sah=0 where plan_tag=\"$ref_code\"";
		$res2=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($res2)
		{
			print("updated pro_plan_today table successfully")."\n";
		}
		
		$sql="update $bai_pro.pro_plan set plan_eff=0,plan_pro=0,plan_clh=0,plan_sah=0 where plan_tag=\"$ref_code\"";
		$res1=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($res1)
		{
			print("updated pro_plan table successfully")."\n";
		}
	}
	
}


//To track success of schedule

$sql="insert into $bai_ict.report_alert_track(report,date) values ('PRO_NEW_DB','".date("Y-m-d H:i:s")."')";
$res=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if($res)
{
	print("inserted report_alert_track table successfully")."\n";
}
//To track success of schedule
// $dir = 'cache/';
// foreach(glob($dir.'*.*') as $v){
// unlink($v);
// }
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");


?>

<?php ((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res); 



?>