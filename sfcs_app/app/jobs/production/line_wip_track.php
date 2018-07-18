
<?php 
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
$message= '<html><head><style type="text/css">

body
{
	font-family: arial;
	font-size:12px;
	color:black;
}
table
{
	border-collapse:collapse;
	white-space:nowrap; 
}
th
{
	color: white;
 	border: 1px solid #660000; 
	white-space:nowrap; 
	padding-left: 10px;
	padding-right: 10px;
	background-color:#29759C;
}

td
{
	color: BLACK;
 	border: 1px solid #660000; 
	padding: 1px;
	white-space:nowrap; 
}

.green
{
	border: 0;

}

.red
{
	border: 0;

}

.yash
{
	border: 0;

}
</style></head><body>';
$message.= '
<table><tr><th colspan=4 align=\"center\">Section Style wise WIP</th></tr>
<tr><th>Style</th><th>Bundles on Live</th><th>WIP</th><th>Running Module</th></tr>';

$sec_mods=array();
$sec_nos=array();
$sql="SELECT sec_id,group_concat(sec_mods order by sec_mods*1) as mods FROM $bai_pro3.sections_db WHERE sec_id NOT IN (0,-1,4) group by sec_id ORDER BY sec_id";

$result7=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($result7))
{
	$sec_nos[]=$sql_row["sec_id"];
	$sec_mods[]=$sql_row["mods"];	
}
for($i=0;$i<sizeof($sec_nos);$i++)
{
	$sql11="SELECT ims_style AS style,COUNT(DISTINCT rand_track) AS box, GROUP_CONCAT(DISTINCT ims_mod_no ORDER BY ims_mod_no*1) AS module, 
		SUM(ims_qty-ims_pro_qty) AS wip FROM $bai_pro3.ims_log WHERE ims_mod_no IN (".$sec_mods[$i].") AND ims_status!=\"DONE\" GROUP BY 
		style ORDER BY style";
	//echo $sql."<br>";
	$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error-11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row11=mysqli_fetch_array($sql_result11))
	{
		$message.= "<tr><td align=\"center\">".$sql_row11['style']."</td><td align=\"center\">".$sql_row11['box']."</td><td align=\"right\">".$sql_row11['wip']."</td><td align=\"left\">".$sql_row11['module']."</td></tr>";
	}
	
	$sql12="SELECT COUNT(DISTINCT rand_track) AS \"boxs\", ims_mod_no, SUM(ims_qty-ims_pro_qty) AS \"wip\" FROM $bai_pro3.ims_log where ims_mod_no in (".$sec_mods[$i].") and ims_status!=\"DONE\"";
	//echo $sql1."<br>";
	$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error-12".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row12=mysqli_fetch_array($sql_result12))
	{
		$message.= "<tr style='background-color:#29759C;'><td align=\"center\" style='color: WHITE;'>Section-".$sec_nos[$i]."</td><td align=\"center\" style='color: WHITE;'>".$sql_row12['boxs']."</td><td align=\"right\" style='color: WHITE;'>".$sql_row12['wip']."</td><td align=\"left\" style='color: WHITE;'></td></tr>";
	}
}
$sql13="SELECT COUNT(DISTINCT rand_track) AS \"boxs\", ims_mod_no, SUM(ims_qty-ims_pro_qty) AS \"wip\", GROUP_CONCAT(DISTINCT ims_schedule ORDER BY ims_schedule) AS \"schedules\"  FROM $bai_pro3.ims_log where ims_mod_no in (".implode(",",$sec_mods).") and ims_status!=\"DONE\" ";
//echo $sql1."<br>";
$sql_result13=mysqli_query($link, $sql13) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row13=mysqli_fetch_array($sql_result13))
{
	$message.= "<tr style='background-color:#29759C;'><td align=\"center\" style='color: WHITE;'>Total</td><td align=\"center\" style='color: WHITE;'>".$sql_row13['boxs']."</td><td align=\"right\" style='color: WHITE;'>".$sql_row13['wip']."</td><td align=\"left\" style='color: WHITE;'></td></tr>";
}
$message.='</table>';
$message.='</br>';
$message.='</br>';
//$message.="<h2 align=\"center\ >Section Module wise WIP</h2>";
$message.= '
<table><tr><th colspan=4 align=\"center\">Section Module wise WIP</th></tr>
<tr><th>Module</th><th>Bundles on Live</th><th>WIP</th><th>Running Schedules</th></tr>';

for($i=0;$i<sizeof($sec_nos);$i++)
{
	$sql="SELECT COUNT(DISTINCT rand_track) AS \"boxs\", ims_mod_no, SUM(ims_qty-ims_pro_qty) AS \"wip\", GROUP_CONCAT(DISTINCT ims_schedule ORDER BY ims_schedule) AS \"schedules\"  FROM $bai_pro3.ims_log where ims_mod_no in (".$sec_mods[$i].") and ims_status!=\"DONE\" GROUP BY ims_mod_no order by ims_mod_no*1";
	//echo $sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$message.= "<tr><td align=\"center\">".$sql_row['ims_mod_no']."</td><td align=\"center\">".$sql_row['boxs']."</td><td align=\"right\">".$sql_row['wip']."</td><td align=\"left\">".$sql_row['schedules']."</td></tr>";
	}
	
	$sql1="SELECT COUNT(DISTINCT rand_track) AS \"boxs\", ims_mod_no, SUM(ims_qty-ims_pro_qty) AS \"wip\", GROUP_CONCAT(DISTINCT ims_schedule ORDER BY ims_schedule) AS \"schedules\"  FROM $bai_pro3.ims_log where ims_mod_no in (".$sec_mods[$i].") and ims_status!=\"DONE\" ";
	//echo $sql1."<br>";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$message.= "<tr style='background-color:#29759C;'><td align=\"center\" style='color: WHITE;'>Section-".$sec_nos[$i]."</td><td align=\"center\" style='color: WHITE;'>".$sql_row1['boxs']."</td><td align=\"right\" style='color: WHITE;'>".$sql_row1['wip']."</td><td align=\"left\" style='color: WHITE;'></td></tr>";
	}
}

$sql1="SELECT COUNT(DISTINCT rand_track) AS \"boxs\", ims_mod_no, SUM(ims_qty-ims_pro_qty) AS \"wip\", GROUP_CONCAT(DISTINCT ims_schedule ORDER BY ims_schedule) AS \"schedules\"  FROM $bai_pro3.ims_log where ims_mod_no in (".implode(",",$sec_mods).") and ims_status!=\"DONE\" ";
//echo $sql1."<br>";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$message.= "<tr style='background-color:#29759C;'><td align=\"center\" style='color: WHITE;'>Total</td><td align=\"center\" style='color: WHITE;'>".$sql_row1['boxs']."</td><td align=\"right\" style='color: WHITE;'>".$sql_row1['wip']."</td><td align=\"left\" style='color: WHITE;'></td></tr>";
}
	
$message.="</table>";
$message.='<br/>Message Sent Via: '.$plant_name;
$message.="</body></html>";
// echo $message."<br>";

//To Track KPI

if(date("H")>18)
{
	$sb1=0; //boxes pending
	$sb2=0;
	$sb3=0;
	$sb4=0;
	$sb5=0;
	$sb6=0;
	
	$wip1=0; //WIP 
	$wip2=0;
	$wip3=0;
	$wip4=0;
	$wip5=0;
	$wip6=0;
	
	$cb1=0; // Carton WIP
	$cb2=0;
	$cb3=0;
	$cb4=0;
	$cb5=0;
	$cb6=0;
	
	$sql="SELECT COUNT(DISTINCT rand_track) AS \"boxs\", ims_mod_no, SUM(ims_qty-ims_pro_qty) AS \"wip\", GROUP_CONCAT(DISTINCT ims_schedule ORDER BY ims_schedule) AS \"schedules\"  FROM $bai_pro3.ims_log GROUP BY ims_mod_no and ims_status!=\"DONE\" ";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		
		$mod=$sql_row['ims_mod_no'];
		if($mod>0 and $mod<13)
		{
			$sb1+=$sql_row['boxs'];
			$wip1+=$sql_row['wip'];
		}
		
		
		if($mod>12 and $mod<25)
		{
			$sb2+=$sql_row['boxs'];
			$wip2+=$sql_row['wip'];
		}
		
		if($mod>24 and $mod<37)
		{
			$sb3+=$sql_row['boxs'];
			$wip3+=$sql_row['wip'];
		}
		
		if($mod>36 and $mod<49)
		{
			$sb4+=$sql_row['boxs'];
			$wip4+=$sql_row['wip'];
		}
		
		if($mod>48 and $mod<61)
		{
			$sb5+=$sql_row['boxs'];
			$wip5+=$sql_row['wip'];
		}
		
		if($mod>60 and $mod<72)
		{
			$sb6+=$sql_row['boxs'];
			$wip6+=$sql_row['wip'];
		}
	}	
	
	//To track carton WIP
	$sql="select SUM(IF(ims_mod_no BETWEEN 1 AND 12,1,0)) as sec1,SUM(IF(ims_mod_no BETWEEN 13 AND 24,1,0)) as sec2,SUM(IF(ims_mod_no BETWEEN 25 AND 36,1,0)) as sec3,SUM(IF(ims_mod_no BETWEEN 37 AND 48,1,0)) as sec4,SUM(IF(ims_mod_no BETWEEN 49 AND 60,1,0)) as sec5,SUM(IF(ims_mod_no BETWEEN 61 AND 72,1,0)) as sec6 FROM $bai_pro3.packing_dashboard_temp ORDER BY lastup";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$cb1=$sql_row['sec1'];
		$cb2=$sql_row['sec2'];
		$cb3=$sql_row['sec3'];
		$cb4=$sql_row['sec4'];
		$cb5=$sql_row['sec5'];
		$cb6=$sql_row['sec6'];	
	}
	
	$A1="('".date("Y-m-d")."','A2001','1','WIP',".$wip1.")";
	$A2="('".date("Y-m-d")."','A2001','2','WIP',".$wip2.")";
	$A3="('".date("Y-m-d")."','A2001','3','WIP',".$wip3.")";
	$A4="('".date("Y-m-d")."','A2001','4','WIP',".$wip4.")";
	$A5="('".date("Y-m-d")."','A2001','5','WIP',".$wip5.")";
	$A6="('".date("Y-m-d")."','A2001','6','WIP',".$wip6.")";
	
	$B1="('".date("Y-m-d")."','A2002','1','WIP',".$sb1.")";
	$B2="('".date("Y-m-d")."','A2002','2','WIP',".$sb2.")";
	$B3="('".date("Y-m-d")."','A2002','3','WIP',".$sb3.")";
	$B4="('".date("Y-m-d")."','A2002','4','WIP',".$sb4.")";
	$B5="('".date("Y-m-d")."','A2002','5','WIP',".$sb5.")";
	$B6="('".date("Y-m-d")."','A2002','6','WIP',".$sb6.")";
	
	$C1="('".date("Y-m-d")."','A2003','1','WIP','".$cb1."')";
	$C2="('".date("Y-m-d")."','A2003','2','WIP','".$cb2."')";
	$C3="('".date("Y-m-d")."','A2003','3','WIP','".$cb3."')";
	$C4="('".date("Y-m-d")."','A2003','4','WIP','".$cb4."')";
	$C5="('".date("Y-m-d")."','A2003','5','WIP','".$cb5."')";
	$C6="('".date("Y-m-d")."','A2003','6','WIP','".$cb6."')";
	
	//BAI KPI TRACK
	
	$sql="insert into $bai_kpi.kpi_tracking(rep_date,parameter,title,category,value) values $A1,$A2,$A3,$A4,$A5,$A6,$B1,$B2,$B3,$B4,$B5,$B6,$C1,$C2,$C3,$C4,$C5,$C6";
	
	$result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($result)
	{
		print("inserted Successfully")."\n";
	}
	
	//BAI KPI TRACK
	
}

//To Track KPI
?>
<?php


	$to  = $line_wip_track;

	$subject = 'BEK WIP (Production) Track';
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	

	$headers .= $header_from. "\r\n";
	
	if(mail($to, $subject, $message, $headers))
	{
		print("mail sent Successfully")."\n";
	}

    $end_timestamp = microtime(true);
    $duration = $end_timestamp - $start_timestamp;
   print("Execution took ".$duration." milliseconds.")."\n";
?>
