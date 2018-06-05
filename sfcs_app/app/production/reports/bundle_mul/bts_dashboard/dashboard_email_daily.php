<?php
//Ticket #533543 KiranG 2014-05-18

//Changed alert mail with dynamic mode (for today and yesterday )
//Added Plan SAH Column and buyer division level breakup

//Dot ID: 104 /Kiran 2014-07-06
//Added new validation to sum up act_out quantity and the same has been used for alert validation.

include($_SERVER['DOCUMENT_ROOT']."server/db_hosts.php");
// Turn off all error reporting
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);


$database="bai_pro";
$user=$host_adr_un;
$password=$host_adr_pw;
$host=$host_adr;

if(isset($_GET['ystd']))
{
	$date=$_GET['ystd'];
	$heading=date('l', $date);
	//$heading="Yesterday";
}
else
{
	//$date=date("Y-m-d");
	$date=date("Y-m-d",strtotime("-1 day",strtotime(date("Y-m-d"))));
	//$heading="Today";
	$heading=date('l', $date);
	//echo date('l', $date)."<br>";
}


$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));


set_time_limit(20000);



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
	$message.="<tr><th colspan=5>SAH Report $date</th></tr>";
	$message.="<tr><th>Section</th><th>Plan SAH</th><th>Actual SAH</th><th>Output</th><th>EFF %</th></tr>";
	
	
$sql="SELECT CONCAT(bac_date,'-',bac_no,'-',bac_shift) AS tid, ROUND(SUM((bac_qty*smv)/60),2) AS sah, sum(bac_Qty) as outp FROM bai_log_buf WHERE bac_date between \"$date\" and \"$date\" GROUP BY CONCAT(bac_date,'-',bac_no,'-',bac_shift) ";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	
	$sql_new="update grand_rep set act_sth=".$sql_row['sah'].", act_out=".$sql_row['outp']." where tid='".$sql_row['tid']."'";
	mysqli_query($link, $sql_new) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
}
//New block create to flush data from the begginig of the month to till date  and refresh the data in SFCS - kiran 20150722

	
	$tot_plan_sth=0;
	$tot_plan_clh=0;
	$tot_act_sth=0;
	$tot_act_clh=0;
	$tot_plan_out=0;
	$tot_act_out=0;
	$sec_ids=array();
	$sql1="select sec_id from bai_pro3.sections_db where sec_id > 0 order by sec_id+0";
	$result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		$sec_ids[]=$row1["sec_id"];
	}
	
	for($i=0;$i<sizeof($sec_ids);$i++)
	{
		$sql="select sum(plan_sth) as \"plan_sth\", sum(plan_clh) as \"plan_clh\", sum(act_sth) as \"act_sth\", sum(act_clh) as \"act_clh\", sum(plan_out) as \"plan_out\", sum(act_out) as \"act_out\" from grand_rep where date =\"$date\" and section=".$sec_ids[$i]."";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
		{
			$plan_sth=$sql_row['plan_sth'];
			$plan_clh=$sql_row['plan_clh'];
			$act_sth=$sql_row['act_sth'];
			$act_clh=$sql_row['act_clh'];
			$plan_out=$sql_row['plan_out'];
			$act_out=$sql_row['act_out'];
			$act_out_check+=$act_out;
			
			$tot_plan_sth+=$plan_sth;
			$tot_plan_clh+=$plan_clh;
			$tot_act_sth+=$act_sth;
			$tot_act_clh+=$act_clh;
			$tot_plan_out+=$plan_out;
			$tot_act_out+=$act_out;
	
		}
		
		//$message.="<td>".round(($plan_sth/$plan_clh)*100,0)."%</td>";
		
		//$message.="<td>".round($plan_sth,0)."</td>";
		$message.="<tr><td align=center>".$sec_ids[$i]."</td><td align=right>".round($plan_sth,0)."</td><td align=right>".round($act_sth,0)."</td>";
		//$message.="<td>".round($plan_out,0)."</td>";
		$message.="<td align=right>".round($act_out,0)."</td>";
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
	
	$message.="<tr><td align=center>$heading Factory</td><td align=right>".round($tot_plan_sth,0)."</td><td align=right>".round($tot_act_sth,0)."</td>";
	//$message.="<td>".round($plan_out,0)."</td>";
	$message.="<td align=right>".round($tot_act_out,0)."</td>";
	if($tot_act_clh>0)
	{
		$message.="<td align=right>".round(($tot_act_sth/$tot_act_clh)*100,0)." %</td>";
	
	}
	else
	{
		$message.="<td align=right>0 %</td>";
	}
	$message.="</tr>";
	$message.="<tr><th colspan=5>Buyer wise Performance</th></tr>";
	
	//TO show buyer wise performance
	
	$sql="select bai_pro3.fn_buyer_division_sch(substring_index(max_style,'^',1)) as buyer,sum(plan_sth) as \"plan_sth\", sum(plan_clh) as \"plan_clh\", sum(act_sth) as \"act_sth\", sum(act_clh) as \"act_clh\", sum(plan_out) as \"plan_out\", sum(act_out) as \"act_out\" from bai_pro.grand_rep where date =\"$date\" GROUP BY bai_pro3.fn_buyer_division_sch(SUBSTRING_INDEX(max_style,'^',1)) order by bai_pro3.fn_buyer_division_sch(SUBSTRING_INDEX(max_style,'^',1))";
	echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
	{
		$plan_sth=$sql_row['plan_sth'];
		$plan_clh=$sql_row['plan_clh'];
		$act_sth=$sql_row['act_sth'];
		$act_clh=$sql_row['act_clh'];
		$plan_out=$sql_row['plan_out'];
		$act_out=$sql_row['act_out'];
		$act_out_check+=$act_out;

		$buyer=$sql_row['buyer'];
		
		$message.="<tr><td align=left>".$buyer."</td><td align=right>".round($plan_sth,0)."</td><td align=right>".round($act_sth,0)."</td>";
		//$message.="<td>".round($plan_out,0)."</td>";
		$message.="<td align=right>".round($act_out,0)."</td>";
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

//$sql="select sum(plan_sth) as \"plan_sth\", sum(plan_clh) as \"plan_clh\", sum(act_sth) as \"act_sth\", sum(act_clh) as \"act_clh\", sum(plan_out) as \"plan_out\", sum(act_out) as \"act_out\" from grand_rep where month(date) =".date("m",strtotime($date))." and year(date)=".date("Y",strtotime($date));
	if()
	$sql="select sum(plan_sth) as \"plan_sth\", sum(plan_clh) as \"plan_clh\", sum(act_sth) as \"act_sth\", sum(act_clh) as \"act_clh\", sum(plan_out) as \"plan_out\", sum(act_out) as \"act_out\" from grand_rep where date between \"".date("Y-m-01")."\" and \"".$date."\"";
echo "<br>".$sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
	{
		$mtd_plan_sth=$sql_row['plan_sth'];
		$mtd_plan_clh=$sql_row['plan_clh'];
		$mtd_act_sth=$sql_row['act_sth'];
		$mtd_act_clh=$sql_row['act_clh'];
		$mtd_plan_out=$sql_row['plan_out'];
		$mtd_act_out=$sql_row['act_out'];
	}
	
	$message.="<tr bgcolor=yellow><td align=center>Factory MTD</td><td align=right>".round($mtd_plan_sth,0)."</td><td align=right>".round($mtd_act_sth,0)."</td><td align=right>".round($mtd_act_out,0)."</td>";
	
	if($mtd_act_clh>0)
	{
		$message.="<td align=right>".round(($mtd_act_sth/$mtd_act_clh)*100,0)." %</td>";
	
	}
	else
	{
		$message.="<td align=right>0 %</td>";
	}
	$message.="</tr>";
	
	//$message.="</tr>";
	$message.="<tr><td colspan=5 align=center>L.U.: ".date("m/d H:i:s")."</td></tr>";
	$message.="</table>";
	
	//include("special_module_contribution_list_incl.php");
	
	if(sizeof($spl_selected)>0)
	{
		
	
		//To show special selected module performance.
		$message.="<tr><th colspan=5>".$special_title."</th></tr>";
		
		//TO show buyer wise performance
		
		$sql="select section,count(distinct module) as countm, sum(plan_sth) as \"plan_sth\", sum(plan_clh) as \"plan_clh\", sum(act_sth) as \"act_sth\", sum(act_clh) as \"act_clh\", sum(plan_out) as \"plan_out\", sum(act_out) as \"act_out\" from bai_pro.grand_rep where date =\"$date\" and module in (".implode(",",$spl_selected).") group by section";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
		{
			$plan_sth=$sql_row['plan_sth'];
			$plan_clh=$sql_row['plan_clh'];
			$act_sth=$sql_row['act_sth'];
			$act_clh=$sql_row['act_clh'];
			$plan_out=$sql_row['plan_out'];
			$act_out=$sql_row['act_out'];
			$act_out_check+=$act_out;

			$buyer=$sql_row['buyer'];
			
			$message.="<tr><td align=left>".$sql_row['section']." (".$sql_row['countm'].")"."</td><td align=right>".round($plan_sth,0)."</td><td align=right>".round($act_sth,0)."</td>";
			//$message.="<td>".round($plan_out,0)."</td>";
			$message.="<td align=right>".round($act_out,0)."</td>";
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
		
		$sql="select sum(plan_sth) as \"plan_sth\",count(distinct module) as countm, sum(plan_clh) as \"plan_clh\", sum(act_sth) as \"act_sth\", sum(act_clh) as \"act_clh\", sum(plan_out) as \"plan_out\", sum(act_out) as \"act_out\" from bai_pro.grand_rep where date =\"$date\" and module in (".implode(",",$spl_selected).")";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
		{
			$plan_sth=$sql_row['plan_sth'];
			$plan_clh=$sql_row['plan_clh'];
			$act_sth=$sql_row['act_sth'];
			$act_clh=$sql_row['act_clh'];
			$plan_out=$sql_row['plan_out'];
			$act_out=$sql_row['act_out'];
			$act_out_check+=$act_out;

			$buyer=$sql_row['buyer'];
			
			$message.="<tr><td align=left>Today (".$sql_row['countm'].")</td><td align=right>".round($plan_sth,0)."</td><td align=right>".round($act_sth,0)."</td>";
			//$message.="<td>".round($plan_out,0)."</td>";
			$message.="<td align=right>".round($act_out,0)."</td>";
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

$sql="select sum(plan_sth) as \"plan_sth\", sum(plan_clh) as \"plan_clh\", sum(act_sth) as \"act_sth\", sum(act_clh) as \"act_clh\", sum(plan_out) as \"plan_out\", sum(act_out) as \"act_out\" from bai_pro.grand_rep where month(date) =".date("m",strtotime($date))." and year(date)=".date("Y",strtotime($date))." and module in (".implode(",",$spl_selected).")";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
		{
			$plan_sth=$sql_row['plan_sth'];
			$plan_clh=$sql_row['plan_clh'];
			$act_sth=$sql_row['act_sth'];
			$act_clh=$sql_row['act_clh'];
			$plan_out=$sql_row['plan_out'];
			$act_out=$sql_row['act_out'];
			$act_out_check+=$act_out;

			$buyer=$sql_row['buyer'];
			
			$message.="<tr><td align=left>MTD</td><td align=right>".round($plan_sth,0)."</td><td align=right>".round($act_sth,0)."</td>";
			//$message.="<td>".round($plan_out,0)."</td>";
			$message.="<td align=right>".round($act_out,0)."</td>";
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
		
	}
	
	$message .='<br/>Message Sent Via: '.$dns_adr1.'';
	$message.="</body></html>";
echo $message;	
//mysql_close($link);


/*

//$to  = 'BAI2AllExecutives@brandix.com,isteamindia@brandix.com,SureshGo@brandix.com';
$to  ='KapilaWe@brandix.com,brandixalerts@schemaxtech.com,brandixalerts@schemaxtech.com,VinodR@brandix.com,ThakshilaN@brandix.com,arjunaj@brandix.com,SampathJay@brandix.com,RukmanD@brandix.com,DineshT@brandix.com,venkateshg@brandix.com,BAI3AllExecutives@brandix.com,BAI3LeadTeam@brandix.com,chiranjeeviko@brandix.com,VenkatadivyaH@brandix.com,BuddhikaW@brandix.com,NishanthaM@brandix.com,PriyanthaNa@brandix.com,nishantham@brandix.com,brandixalerts@schemaxtech.com';

//$to='brandixalerts@schemaxtech.com,brandixalerts@schemaxtech.com';

$subject = 'SAH Report';


// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: '.$to. "\r\n";
//$headers .= 'To: <brandixalerts@schemaxtech.com>'. "\r\n";
$headers .= 'From: Shop Floor System Alert <ictsysalert@brandix.com>'. "\r\n";
//$headers .= 'Cc: YasanthiN@brandix.com' . "\r\n";

// Mail it

$sql="insert into bai_ict.report_alert_track(report,date) values (\"Live_SAH_Run\",\"".date("Y-m-d H:i:s")."\")";
mysql_query($sql,$link) or exit("Sql Error5".mysql_error());
		
if($act_out_check>0)
{
	a:
	if(mail($to, $subject, $message, $headers))
	{
		$sql="insert into bai_ict.report_alert_track(report,date) values (\"Live_SAH\",\"".date("Y-m-d H:i:s")."\")";
		mysql_query($sql,$link) or exit("Sql Error6".mysql_error());
	}
	else
	{
		goto a;
	}
}
*/
//echo $message;
//echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";

?>