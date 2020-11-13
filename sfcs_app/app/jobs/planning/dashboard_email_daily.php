<?php
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
include($include_path.'\sfcs_app\common\config\enums.php');


// Turn off all error reporting
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$date=date("Y-m-d");
$heading="Today";

if($_GET['plantCode']){
	$plant_code = $_GET['plantCode'];
}else{
	$plant_code = $argv[1];
}

$username=$_SESSION['userName'];
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
$decimal_factor=2;
	$message.="<tr><th colspan=6>SAH Report $date</th></tr>";
	$message.="<tr><th>Section</th><th>Plan SAH</th><th>Actual SAH</th><th>Output</th><th>EFF %</th></tr>";
	$sms.="S-P-A-O-E%\r\n";
	
// 	$sql="SELECT CONCAT(bac_date,'-',bac_no,'-',bac_shift) AS tid, ROUND(SUM((bac_qty*smv)/60),2) AS sah, sum(bac_Qty) as outp FROM $pts.bai_log_buf WHERE plant_code='$plant_code' and bac_date between \"$date\" and \"$date\" GROUP BY CONCAT(bac_date,'-',bac_no,'-',bac_shift) ";
// $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
// while($sql_row=mysqli_fetch_array($sql_result))
// {
	
// 	$sql_new="update $pts.grand_rep set act_sth=".$sql_row['sah'].",act_out=".$sql_row['outp'].",updated_user='$username',updated_at='".date('Y-m-d')."' where plant_code='$plant_code' and tid='".$sql_row['tid']."'";
// 	mysqli_query($link, $sql_new) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
// }
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
	$sql1="select section_id from $pms.sections where section_id > 0 order by section_id+0";
	$result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		$sec_ids[]=$row1["section_id"];
	}
	
	for($i=0;$i<sizeof($sec_ids);$i++)
	{
		$sql="select sum(plan_sth) as \"plan_sth\", sum(plan_clh) as \"plan_clh\", sum(act_sth) as \"act_sth\", sum(act_clh) as \"act_clh\", sum(plan_out) as \"plan_out\", sum(act_out) as \"act_out\" from $pts.grand_rep where plant_code='$plant_code' and date =\"$date\" and section='".$sec_ids[$i]."'";
		// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	    while($sql_row=mysqli_fetch_array($sql_result))
		{
			$plan_sth=round($sql_row["plan_sth"],$decimal_factor);
			$plan_clh=round($sql_row["plan_clh"],$decimal_factor);
			$act_sth=round($sql_row["act_sth"],$decimal_factor);
			$act_clh=round($sql_row["act_clh"],$decimal_factor);
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
		//To get section description
		$get_sections="SELECT section_name FROM $pms.sections WHERE section_id='".$sec_ids[$i]."' AND plant_code='$plant_code'";
		$sections_result=mysqli_query($link, $get_sections) or exit("Sql Error555".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($section_row=mysqli_fetch_array($sections_result))
		{
            $section_name=$section_row['section_name'];
		}
		$message.="<tr><td align=center>".$section_name."</td><td align=right>".round($plan_sth,$decimal_factor)."</td><td align=right>".round($act_sth,$decimal_factor)."</td>";
		$sms.=$sec_ids[$i]."-".round($plan_sth,$decimal_factor)."-".round($act_sth,$decimal_factor)."-".round($act_out,$decimal_factor);

		$message.="<td align=right>".round($act_out,$decimal_factor)."</td>";
		// $message.="<td align=right>".round($rework,$decimal_factor)."</td>";
		
		if($act_clh>0)
		{
			$message.="<td align=right>".round(($act_sth/$act_clh)*100,$decimal_factor)." %</td>";
			$sms.="-".round(($act_sth/$act_clh)*100,$decimal_factor);
		
		}
		else
		{
			$message.="<td align=right>0 %</td>";
			$sms."-0";
		}
		$message.="</tr>";
		$sms.="\r\n";
	
	}
	
	$message.="<tr><td align=center>$heading Factory</td><td align=right>".round($tot_plan_sth,$decimal_factor)."</td><td align=right>".round($tot_act_sth,$decimal_factor)."</td>";
	$sms.="F-".round($tot_plan_sth,$decimal_factor)."-".round($tot_act_sth,$decimal_factor)."-".round($tot_act_out,$decimal_factor);

	$message.="<td align=right>".round($tot_act_out,$decimal_factor)."</td>";
	$message.="<td align=right>".round($tot_rework,$decimal_factor)."</td>";
	if($tot_act_clh>0)
	{
		$message.="<td align=right>".round(($tot_act_sth/$tot_act_clh)*100,$decimal_factor)." %</td>";
		$sms.="-".round(($tot_act_sth/$tot_act_clh)*100,$decimal_factor);
	}
	else
	{
		$message.="<td align=right>0 %</td>";
		$sms."-0";
	}
	$message.="</tr>";
	$sms.="\r\n";
	$message.="<tr><th colspan=6>Buyer wise Performance</th></tr>";
	
	$teams=$shifts_array;
	//TO show buyer wise performance
	$get_buyerdetails="SELECT GROUP_CONCAT(DISTINCT(mo_number)) AS monumbers,buyer_desc FROM $oms.`oms_mo_details` WHERE plant_code='$plant_code' GROUP BY buyer_desc";	
	$buyers_result=mysqli_query($link, $get_buyerdetails) or exit("Sql Error556".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($buyers_row=mysqli_fetch_array($buyers_result))
	{
	   $buyers=$buyers_row['buyer_desc'];
	   $monumbers=$buyers_row['monumbers'];
	   
	   $jobtype=TaskTypeEnum::SEWINGJOB;
	   //get details from fg_m3_transaction
	   $get_fg_m3_transactiondetails="SELECT job_ref,DISTINCT(workstation_id) AS workstations_id FROM $pts.fg_m3_transaction WHERE job_type='$jobtype' AND plant_code='$plant_code' AND mo_number IN ('".$monumbers."')";
	   $transactions_result=mysqli_query($link, $get_fg_m3_transactiondetails) or exit("Sql Error557".mysqli_error($GLOBALS["___mysqli_ston"]));
	   while($transaction_row=mysqli_fetch_array($transactions_result))
	   {
		 $jobnumber[]=$transaction_row['job_ref'];
		 $workstations_id[]=$transaction_row['workstations_id'];
	   }
	   //Get workstation code
	   $getworkstationcode="SELECT workstation_code FROM $pms.`workstation` WHERE workstation_id IN ('".implode("','" , $workstations_id)."')";
	   $workstations_result=mysqli_query($link, $getworkstationcode) or exit("Sql Error789".mysqli_error($GLOBALS["___mysqli_ston"]));
	   while($workstation_row=mysqli_fetch_array($workstations_result))
	   { 
         $workstationcode[]=$workstation_row['workstation_code'];
	   }

	   //To get planned SAH
	   // Getting Plan Information
	   $sql_month_plan="select sum(planned_qty) as qty,sum(planned_sah) as sah,planned_eff,capacity_factor from $pps.monthly_production_plan where plant_code='$plant_code' and row_name in ('".implode("','" , $workstationcode)."')";
	   $sql_month_plan_res=mysqli_query($link, $sql_month_plan) or exit("Fetching Monthly Plan information".mysqli_error($GLOBALS["___mysqli_ston"]));
	   while($monthlyRow=mysqli_fetch_array($sql_month_plan_res))
	   {
			if($monthlyRow['sah']>0)
			{
				$plan_sah=$monthlyRow['sah']/sizeof($teams);
			}
			else
			{
				$plan_sah=0;
			}
	   }
	   $actoutqty=0;
	   foreach($jobnumber as $job)
	   {
         //To get taskjob reference from jm_jg_header
		 $get_jmjgheader_details="SELECT jm_jg_header_id FROM pps.`jm_jg_header` WHERE job_number='$job' AND plant_code='$plant_code' AND is_active=1";
		 $jgheader_result=mysqli_query($link, $get_jmjgheader_details) or exit("Sql Error558".mysqli_error($GLOBALS["___mysqli_ston"]));
		 while($header_row=mysqli_fetch_array($jgheader_result))
		 {
           $jm_jg_header_id=$header_row['jm_jg_header_id']; 
		 }
		 //To get tsakjobid from taskjobs
		 $get_taskjobsid="SELECT task_jobs_id FROM $tms.`task_jobs` WHERE task_job_reference='$jm_jg_header_id' AND plant_code='$plant_code' AND is_active=1";
		 $taskjob_result=mysqli_query($link, $get_taskjobsid) or exit("Sql Error559".mysqli_error($GLOBALS["___mysqli_ston"]));
		 while($taskjob_row=mysqli_fetch_array($taskjob_result))
		 {
           $taskjobid=$taskjob_row['task_jobs_id'];
		 }
		 /**
		 * getting min and max operations
		 */
		 $qrytoGetMaxOperation="SELECT operation_code FROM $tms.`task_job_status` WHERE task_jobs_id='".$taskjobid."' AND plant_code='$plant_code' AND is_active=1 ORDER BY operation_seq DESC LIMIT 0,1";
		 $maxOperationResult = mysqli_query($link,$qrytoGetMaxOperation) or exit('Problem in getting operations data for job');
		 if(mysqli_num_rows($maxOperationResult)>0){
			while($maxOperationResultRow = mysqli_fetch_array($maxOperationResult)){
				$maxOperation=$maxOperationResultRow['operation_code'];
			}
		 }
		 
		 $get_qtys="SELECT SUM(good_quantity) AS quantity FROM $tms.`task_job_status` WHERE plant_code='$plant_code' AND operation_code='$maxOperation'";
		 $qtys_result=mysqli_query($link, $get_qtys) or exit("Sql Error560".mysqli_error($GLOBALS["___mysqli_ston"]));
		 while($qty_row=mysqli_fetch_array($qtys_result))
		 {
           $actoutqty +=$qty_row['quantity'];
		 }
		}

		 
	}
	
// 	$sql="select bai_pro3.fn_buyer_division_sch(substring_index(max_style,'^',1)) as buyer,sum(plan_sth) as \"plan_sth\", sum(plan_clh) as \"plan_clh\", sum(act_sth) as \"act_sth\", sum(act_clh) as \"act_clh\", sum(plan_out) as \"plan_out\", sum(act_out) as \"act_out\" from $pts.grand_rep where plant_code='$plant_code' and date =\"$date\" GROUP BY bai_pro3.fn_buyer_division_sch(SUBSTRING_INDEX(max_style,'^',1)) order by bai_pro3.fn_buyer_division_sch(SUBSTRING_INDEX(max_style,'^',1))";
// 	// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
// 	$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
// while($sql_row=mysqli_fetch_array($sql_result))
// 	{
// 		$plan_sth=round($sql_row["plan_sth"],$decimal_factor);
// 		$plan_clh=round($sql_row["plan_clh"],$decimal_factor);
// 		$act_sth=round($sql_row["act_sth"],$decimal_factor);
// 		$act_clh=round($sql_row["act_clh"],$decimal_factor);
// 		$plan_out=$sql_row['plan_out'];
// 		$act_out=$sql_row['act_out'];
// 		//$act_out_check+=$act_out;

// 		$buyer=$sql_row['buyer'];
		
// 		$message.="<tr><td align=left>".$buyer."</td><td align=right>".round($plan_sth,$decimal_factor)."</td><td align=right>".round($act_sth,$decimal_factor)."</td>";
// 		//$message.="<td>".round($plan_out,0)."</td>";
// 		$message.="<td align=right>".round($act_out,$decimal_factor)."</td>";
// 		// $message.="<td align=right>".round($rework,$decimal_factor)."</td>";
// 		if($act_clh>0)
// 		{
// 			$message.="<td align=right>".round(($act_sth/$act_clh)*100,$decimal_factor)." %</td>";
		
// 		}
// 		else
// 		{
// 			$message.="<td align=right>0 %</td>";
// 		}
// 		$message.="</tr>";

// 	}
	
// 	//To show buyer wise performance

// $sql="select sum(plan_sth) as \"plan_sth\", sum(plan_clh) as \"plan_clh\", sum(act_sth) as \"act_sth\", sum(act_clh) as \"act_clh\", sum(plan_out) as \"plan_out\", sum(act_out) as \"act_out\" from $pts.grand_rep where plant_code='$plant_code' and month(date) =".date("m",strtotime($date))." and year(date)=".date("Y",strtotime($date));
// 	$sql_result=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
// while($sql_row=mysqli_fetch_array($sql_result))
// 	{
// 		$mtd_plan_sth=round($sql_row["plan_sth"],$decimal_factor);
// 		$mtd_plan_clh=round($sql_row["plan_clh"],$decimal_factor);
// 		$mtd_act_sth=round($sql_row["act_sth"],$decimal_factor);
// 		$mtd_act_clh=round($sql_row["act_clh"],$decimal_factor);
// 		$mtd_plan_out=$sql_row['plan_out'];
// 		$mtd_act_out=$sql_row['act_out'];
// 	}
	
// 	$message.="<tr bgcolor=yellow><td align=center>Factory MTD</td><td align=right>".round($mtd_plan_sth,$decimal_factor)."</td><td align=right>".round($mtd_act_sth,$decimal_factor)."</td><td align=right>".round($mtd_act_out,$decimal_factor)."</td>";
	
// 	if($mtd_act_clh>0)
// 	{
// 		$message.="<td align=right>".round(($mtd_act_sth/$mtd_act_clh)*100,$decimal_factor)." %</td>";
	
// 	}
// 	else
// 	{
// 		$message.="<td align=right>0 %</td>";
// 	}
// 	$message.="</tr>";
	

	$message.="<tr><td colspan=6 align=center>L.U.: ".date("m/d H:i:s")."</td></tr>";

	
	
	
	$message.="</table>";
	$message .='<br/>Message Sent Via: '.$plant_name.'';
	$message.="</body></html>";




if(date("H")=="14")
{
	
	 $to = $dashboard_email_dialy_H_14;
	
}
else
{

	 $to = $dashboard_email_dialy;
}

 
$subject = 'SAH Report';


// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$headers .= "From: ".$header_name." <".$header_mail.">". "\r\n";
// echo $headers;
// $headers .= $header_from. "\r\n";


// Mail it

// $sql="insert into $bai_ict.report_alert_track(report,date) values (\"Live_SAH_Run\",\"".date("Y-m-d H:i:s")."\")";
// $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
// if($sql_result)
// {
	// print('Live SAH Run Inserted successfully')."\n";
// }

	if($act_out_check>0)
	{
		a:
		if(mail($to, $subject, $message, $headers))
		{
			// $sql="insert into $bai_ict.report_alert_track(report,date) values (\"Live_SAH\",\"".date("Y-m-d H:i:s")."\")";
			// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			print("Live SAH Inserted And mail sent successfully")."\n";
		
		}
		else
		{
			goto a;
		}
	}
	else
	{
		print("mail Not Send Due to data not found")."\n";
	}
	
	
    $end_timestamp = microtime(true);
    $duration = $end_timestamp - $start_timestamp;
    print("Execution took ".$duration." milliseconds.");


?>

