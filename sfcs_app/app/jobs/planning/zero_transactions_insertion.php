<?php
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');

$sql_shift="select remarks from calendar where date=\"".date("Y-m-d")."\"";
$result_shift=mysql_query($sql_shift,$link_hrms) or die("Error".mysql_error());
while($row_shift=mysql_fetch_array($result_shift))
{
	$shift_ex=$row_shift["remarks"];
}

$shift_det=explode("$",$shift_ex);
$shift_1=substr($shift_det[0],0,1);
$shift_2=substr($shift_det[1],0,1);

$cur_h=date("H");
$hours=array();
if($cur_h<'14')
{
	$hours=array('06','07','08','09','10','11','12','13');
}
else
{
	$hours=array('06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21');
}


$sql="select mod_no,mod_sec from $bai_pro.pro_mod where date(mod_date)=\"".date("Y-m-d")."\" ORDER BY MOD_NO*1";
mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$i=1;
while($sql_row=mysql_fetch_array($sql_result))
{
	
	$style=0;
	$schedule=0;
	$color=0;
	$doc_no=0;
	$smv=0;
	$nop=0;
	
	for($j=0;$j<sizeof($hours);$j++)
	{
		$ims_tidtmp=rand(1000,9999);
		if($hours[$j]<'14')
		{
			$shift_final=$shift_1;
		}
		else
		{
			$shift_final=$shift_2;
		}
		//echo $hours[$j]."--".$shift_final."<br>";
		if($hours[$j]<=$cur_h)
		{
			$ims_tid=$ims_tidtmp.date("ymdhis").rand(10,99).$i;
			$sql2="select * from $bai_pro.bai_log_buf where bac_shift='".$shift_final."' and bac_no='".$sql_row["mod_no"]."' and bac_date='".date("Y-m-d")."' and hour(bac_lastup)='".$hours[$j]."' limit 1";
			$result2=mysql_query($sql2,$link) or exit("Sql Error--2".mysql_error());
		
			if(mysql_num_rows($result2)==0)
			{						
				$sql1="insert ignore into $bai_pro.bai_log(bac_no,bac_sec,bac_qty,bac_lastup,bac_date,log_time,bac_shift,bac_style,delivery,color,ims_tid,ims_doc_no,smv,nop) values(\"".$sql_row["mod_no"]."\",\"".$sql_row["mod_sec"]."\",0,\"".date("Y-m-d ".$hours[$j].":i:s")."\",\"".date("Y-m-d")."\",\"".date("Y-m-d ".$hours[$j].":i:s")."\",\"".$shift_final."\",\"".$style."\",\"".$schedule."\",\"".$color."\",\"".$ims_tid."\",\"".$doc_no."\",\"".$smv."\",\"".$nop."\")";
				// echo $sql1."<br><br>";
				mysql_query($sql1,$link) or exit("Sql Error--1".mysql_error());
				
				$sql3="insert ignore into $bai_pro.bai_log_buf(bac_no,bac_sec,bac_qty,bac_lastup,bac_date,log_time,bac_shift,bac_style,delivery,color,ims_tid,ims_doc_no,smv,nop) values(\"".$sql_row["mod_no"]."\",\"".$sql_row["mod_sec"]."\",0,\"".date("Y-m-d ".$hours[$j].":i:s")."\",\"".date("Y-m-d")."\",\"".date("Y-m-d ".$hours[$j].":i:s")."\",\"".$shift_final."\",\"".$style."\",\"".$schedule."\",\"".$color."\",\"".$ims_tid."\",\"".$doc_no."\",\"".$smv."\",\"".$nop."\")";
				// echo $sql3."<br><br>";
				mysql_query($sql3,$link) or exit("Sql Error--2".mysql_error());
			}
			$i++;
			$ims_tid=0;
			$ims_tidtmp=0;
		}
		
	}
	
}
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");	
?>

