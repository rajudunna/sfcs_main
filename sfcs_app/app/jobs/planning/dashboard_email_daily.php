<?php
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');

// Turn off all error reporting
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$date=date("Y-m-d");
$heading="Today";



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

tr .highlight
{
	background-color:yellow;
}
th
{
	color: black;
 border: 1px solid #660000; 
white-space:nowrap; 
padding-left: 10px;
padding-right: 10px;
}

td
{
	background-color: WHITE;
	color: BLACK;
 border: 1px solid #660000; 
	padding: 1px;
white-space:nowrap; 
}

</style></head><body><table>';
$sms="";
	$message.="<tr><th colspan=6>SAH Report $date</th></tr>";
	$message.="<tr><th>Section</th><th>Plan SAH</th><th>Actual SAH</th><th>Output</th><th>Rework</th><th>EFF %</th></tr>";
	$sms.="S-P-A-O-E%\r\n";
	
	$sql="SELECT CONCAT(bac_date,'-',bac_no,'-',bac_shift) AS tid, ROUND(SUM((bac_qty*smv)/60),2) AS sah, sum(bac_Qty) as outp FROM $bai_pro.bai_log_buf WHERE bac_date between \"$date\" and \"$date\" GROUP BY CONCAT(bac_date,'-',bac_no,'-',bac_shift) ";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	
	$sql_new="update $bai_pro.grand_rep set act_sth=".$sql_row['sah'].",act_out=".$sql_row['outp']." where tid='".$sql_row['tid']."'";
	mysqli_query($link, $sql_new) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
}
//New block create to flush data from the begginig of the month to till date  and refresh the data in SFCS - kiran 20150722
	
	$tot_plan_sth=0;
	$tot_plan_clh=0;
	$tot_act_sth=0;
	$tot_act_clh=0;
	$tot_plan_out=0;
	$tot_act_out=0;
	$tot_rework=0;
	$act_out_check=0;
	$sec_ids=array();
	$sql1="select sec_id from $bai_pro3.sections_db where sec_id > 0 order by sec_id+0";
	$result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		$sec_ids[]=$row1["sec_id"];
	}
	
	for($i=0;$i<sizeof($sec_ids);$i++)
	{
		$sql="select sum(plan_sth) as \"plan_sth\", sum(plan_clh) as \"plan_clh\", sum(act_sth) as \"act_sth\", sum(act_clh) as \"act_clh\", sum(plan_out) as \"plan_out\", sum(act_out) as \"act_out\", sum(rework_qty) as rework from bai_pro.grand_rep where date =\"$date\" and section=".$sec_ids[$i]."";
		// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
		{
			$plan_sth=$sql_row['plan_sth'];
			$plan_clh=$sql_row['plan_clh'];
			$act_sth=$sql_row['act_sth'];
			$act_clh=$sql_row['act_clh'];
			$plan_out=$sql_row['plan_out'];
			$act_out=$sql_row['act_out'];
			$rework=$sql_row['rework'];
			$act_out_check+=$act_out;
			
			$tot_plan_sth+=$plan_sth;
			$tot_plan_clh+=$plan_clh;
			$tot_act_sth+=$act_sth;
			$tot_act_clh+=$act_clh;
			$tot_plan_out+=$plan_out;
			$tot_act_out+=$act_out;
			$tot_rework+=$rework;
	
		}

		$message.="<tr><td align=center>".$sec_ids[$i]."</td><td align=right>".round($plan_sth,0)."</td><td align=right>".round($act_sth,0)."</td>";
		$sms.=$sec_ids[$i]."-".round($plan_sth,0)."-".round($act_sth,0)."-".round($act_out,0);

		$message.="<td align=right>".round($act_out,0)."</td>";
		$message.="<td align=right>".round($rework,0)."</td>";
		
		if($act_clh>0)
		{
			$message.="<td align=right>".round(($act_sth/$act_clh)*100,0)." %</td>";
			$sms.="-".round(($act_sth/$act_clh)*100,0);
		
		}
		else
		{
			$message.="<td align=right>0 %</td>";
			$sms."-0";
		}
		$message.="</tr>";
		$sms.="\r\n";
	
	}
	
	$message.="<tr><td align=center>$heading Factory</td><td align=right>".round($tot_plan_sth,0)."</td><td align=right>".round($tot_act_sth,0)."</td>";
	$sms.="F-".round($tot_plan_sth,0)."-".round($tot_act_sth,0)."-".round($tot_act_out,0);

	$message.="<td align=right>".round($tot_act_out,0)."</td>";
	$message.="<td align=right>".round($tot_rework,0)."</td>";
	if($tot_act_clh>0)
	{
		$message.="<td align=right>".round(($tot_act_sth/$tot_act_clh)*100,0)." %</td>";
		$sms.="-".round(($tot_act_sth/$tot_act_clh)*100,0);
	}
	else
	{
		$message.="<td align=right>0 %</td>";
		$sms."-0";
	}
	$message.="</tr>";
	$sms.="\r\n";
	$message.="<tr><th colspan=6>Buyer wise Performance</th></tr>";
	
	//TO show buyer wise performance
	
	$sql="select bai_pro3.fn_buyer_division_sch(substring_index(max_style,'^',1)) as buyer,sum(plan_sth) as \"plan_sth\", sum(plan_clh) as \"plan_clh\", sum(act_sth) as \"act_sth\", sum(act_clh) as \"act_clh\", sum(plan_out) as \"plan_out\", sum(act_out) as \"act_out\", sum(rework_qty) as rework from $bai_pro.grand_rep where date =\"$date\" GROUP BY bai_pro3.fn_buyer_division_sch(SUBSTRING_INDEX(max_style,'^',1)) order by bai_pro3.fn_buyer_division_sch(SUBSTRING_INDEX(max_style,'^',1))";
	// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
	{
		$plan_sth=$sql_row['plan_sth'];
		$plan_clh=$sql_row['plan_clh'];
		$act_sth=$sql_row['act_sth'];
		$act_clh=$sql_row['act_clh'];
		$plan_out=$sql_row['plan_out'];
		$act_out=$sql_row['act_out'];
		$rework=$sql_row['rework'];
		//$act_out_check+=$act_out;

		$buyer=$sql_row['buyer'];
		
		$message.="<tr><td align=left>".$buyer."</td><td align=right>".round($plan_sth,0)."</td><td align=right>".round($act_sth,0)."</td>";
		//$message.="<td>".round($plan_out,0)."</td>";
		$message.="<td align=right>".round($act_out,0)."</td>";
		$message.="<td align=right>".round($rework,0)."</td>";
		if($act_clh>0)
		{
			$message.="<td align=right>".round(($act_sth/$act_clh)*100,0)." %</td>";
		
		}
		else
		{
			$message.="<td align=right>0 %</td>";
		}
		$message.="</tr>";

	}
	
	//To show buyer wise performance

$sql="select sum(plan_sth) as \"plan_sth\", sum(plan_clh) as \"plan_clh\", sum(act_sth) as \"act_sth\", sum(act_clh) as \"act_clh\", sum(plan_out) as \"plan_out\", sum(act_out) as \"act_out\", sum(rework_qty) as rework from $bai_pro.grand_rep where month(date) =".date("m",strtotime($date))." and year(date)=".date("Y",strtotime($date));
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
	{
		$mtd_plan_sth=$sql_row['plan_sth'];
		$mtd_plan_clh=$sql_row['plan_clh'];
		$mtd_act_sth=$sql_row['act_sth'];
		$mtd_act_clh=$sql_row['act_clh'];
		$mtd_plan_out=$sql_row['plan_out'];
		$mtd_act_out=$sql_row['act_out'];
		$rework=$sql_row['rework'];
	}
	
	$message.="<tr bgcolor=yellow><td align=center>Factory MTD</td><td align=right>".round($mtd_plan_sth,0)."</td><td align=right>".round($mtd_act_sth,0)."</td><td align=right>".round($mtd_act_out,0)."</td><td align=right>".round($rework,0)."</td>";
	
	if($mtd_act_clh>0)
	{
		$message.="<td align=right>".round(($mtd_act_sth/$mtd_act_clh)*100,0)." %</td>";
	
	}
	else
	{
		$message.="<td align=right>0 %</td>";
	}
	$message.="</tr>";
	

	$message.="<tr><td colspan=6 align=center>L.U.: ".date("m/d H:i:s")."</td></tr>";

	
	
	
	$message.="</table>";
	$message .='<br/>Message Sent Via: '.$plant_name.'';
	$message.="</body></html>";




if(date("H")=="14")
{
	// $to  = 'gayanl@brandix.com,kasinac@brandix.com,brandixalerts@schemaxtech.com,brandixalerts@schemaxtech.com,brandixalerts@schemaxtech.com,bhavanik@brandix.com,bai1leadteam@brandix.com,bai1planningteam@brandix.com,JoeH@brandix.com,ShiranB@brandix.com,BAI1AllExecutives@brandix.com';
	 $to = $dashboard_email_dialy_H_14;
	
}
else
{
	// $to  = 'BAI1AllExecutives@brandix.com,isteamindia@brandix.com,lalithb@brandix.com,govil@brandix.com,lilanthaw@brandix.com,harshal@brandix.com,rangar@brandix.com,duminduw@brandix.com,PriyanthaNa@brandix.com,UdayaD@brandix.com,JoeH@brandix.com,ShiranB@brandix.com,lakshithas@brandix.com,kaushalap@brandix.com,GayaneeW@brandix.com,NishanthaM@brandix.com,brandixalerts@schemaxtech.com';	//removed minura on 2018-01-06 mail from kirang
	 $to = $dashboard_email_dialy;
}


//$to  = 'brandixalerts@schemaxtech.com';
$subject = 'SAH Report';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: '.$to. "\r\n";
//$headers .= 'To: <brandixalerts@schemaxtech.com>'. "\r\n";
$headers .= $header_from. "\r\n";
//$headers .= 'Cc: YasanthiN@brandix.com' . "\r\n";

// Mail it

$sql="insert into bai_ict.report_alert_track(report,date) values (\"Live_SAH_Run\",\"".date("Y-m-d H:i:s")."\")";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if($sql_result)
{
	print('Live SAH Run Inserted successfully')."\n";
}

	if($act_out_check>0)
	{
		a:
		if(mail($to, $subject, $message, $headers))
		{
			$sql="insert into bai_ict.report_alert_track(report,date) values (\"Live_SAH\",\"".date("Y-m-d H:i:s")."\")";
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			print("Live SAH Inserted And mail sent successfully")."\n";
		
		}
		else
		{
			goto a;
		}
	}
	
	
    $end_timestamp = microtime(true);
    $duration = $end_timestamp - $start_timestamp;
    print("Execution took ".$duration." milliseconds.");


?>

