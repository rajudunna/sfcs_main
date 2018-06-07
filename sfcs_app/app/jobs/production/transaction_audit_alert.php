<?php
$start_timestamp = microtime(true);
$message= "<html>
<head>


<style>
body
{
	font-family:calibri;
	font-size:12px;
}

table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align: right;
white-space:nowrap; 
}

table th
{
	border: 1px solid black;
	text-align: center;
    	background-color: #29759c;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
}


}

}
</style>


<style type=\"text/css\">

.ds_box {
	background-color: #FFF;
	border: 1px solid #000;
	position: absolute;
	z-index: 32767;
}

.ds_tbl {
	background-color: #FFF;
}

.ds_head {
	background-color: #333;
	color: #FFF;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	font-weight: bold;
	text-align: center;
	letter-spacing: 2px;
}

.ds_subhead {
	background-color: #CCC;
	color: #000;
	font-size: 12px;
	font-weight: bold;
	text-align: center;
	font-family: Arial, Helvetica, sans-serif;
	width: 32px;
}

.ds_cell {
	background-color: #EEE;
	color: #000;
	font-size: 13px;
	text-align: center;
	font-family: Arial, Helvetica, sans-serif;
	padding: 5px;
	cursor: pointer;
}

.ds_cell:hover {
	background-color: #F3F3F3;
} 

</style>

</head>


<body>";
?>
<?php 
include('C:\xampp\htdocs\sfcs_main\sfcs_app\common\config\config_jobs.php');


$message.='<div id="page_heading"><span style="float: left"><h3>M3 Bulk Operation Failed Entries</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>';


$sdate=date("Y-m-d");

//$message.= "<h2>Transaction Audit Log</h2>";
//$message.= "<br/><u>Status Legend:</u> 0-Created, 10-Validated, 15-Confirmed, 16-Reconfirmed, 20-M3 Log Created,  30- Success, 40-Failed, 50-Manually Updated, 60-Success Archived, 70-Failed Archived, 90-Ignored<br/><u>M3 Operation Description:</u> LAY-Laying, CUT-Cutting, SIN-Sewing In, SOT-Sewing Out, CPK-Carton Packing, <b>Embellishment:</b> PS-Panel Form Sent , PR-Panel Form Received, ASPS-Garment Form Sent, ASPR-Garment Form Received ";

$message.= "<table id=\"table111\" border=1 class=\"mytable\">";
$message.= "<tr><th>Transaction ID</th><th>Date</th><th>Style</th><th>Schedule</th><th>Color</th><th>SFCS Size Code</th><th>M3 Size Code</th><th>Status</th><th>MO Number</th><th>M3 Operation Code</th><th>SFCS Job #</th><th>Docket #</th><th>Reported Qty</th><th>Rejection Reasons</th><th>Remarks</th><th>Log User</th><th>Log Time</th><th>Module #</th><th>Shift</th><th>M3 Operation Des.</th><th>SFCS Tran. Ref. ID</th><th>M3 Error Code</th>
</tr>";

$result_count=0;
$sql="select * from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_date='$sdate' and sfcs_status in (40)";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$result_count+=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
$sfcs_tid=$sql_row['sfcs_tid'];
$sfcs_date=$sql_row['sfcs_date'];
$sfcs_style=$sql_row['sfcs_style'];
$sfcs_schedule=$sql_row['sfcs_schedule'];
$sfcs_color=$sql_row['sfcs_color'];
$sfcs_size=$sql_row['sfcs_size'];
$m3_size=$sql_row['m3_size'];
$sfcs_doc_no=$sql_row['sfcs_doc_no'];
$sfcs_qty=$sql_row['sfcs_qty'];
$sfcs_reason=$sql_row['sfcs_reason'];
$sfcs_remarks=$sql_row['sfcs_remarks'];
$sfcs_log_user=$sql_row['sfcs_log_user'];
$sfcs_log_time=$sql_row['sfcs_log_time'];
$sfcs_status=$sql_row['sfcs_status'];
$m3_mo_no=$sql_row['m3_mo_no'];
$m3_op_code=$sql_row['m3_op_code'];
$sfcs_job_no=$sql_row['sfcs_job_no'];
$sfcs_mod_no=$sql_row['sfcs_mod_no'];
$sfcs_shift=$sql_row['sfcs_shift'];
$m3_op_des=$sql_row['m3_op_des'];
$sfcs_tid_ref=$sql_row['sfcs_tid_ref'];
$m3_error_code=$sql_row['m3_error_code'];


$message.= "<tr><td>$sfcs_tid</td><td>$sfcs_date</td><td>$sfcs_style</td><td>$sfcs_schedule</td><td>$sfcs_color</td><td>$sfcs_size</td><td>$m3_size</td><td>$sfcs_status</td><td>$m3_mo_no</td><td>$m3_op_code</td><td>$sfcs_job_no</td><td>$sfcs_doc_no</td><td>$sfcs_qty</td><td>".(strlen($sfcs_reason)==0?'GOOD':$sfcs_reason)."</td><td>$sfcs_remarks</td><td>$sfcs_log_user</td><td>$sfcs_log_time</td><td>$sfcs_mod_no</td><td>$sfcs_shift</td><td>$m3_op_des</td><td>$sfcs_tid_ref</td><td>$m3_error_code</td></tr>";

}

$message.= "</table>";


$message.= "<h3>M3 Bulk Operation WIP Entries</h3>";
$message.= "<table id=\"table111\" border=1 class=\"mytable\">";
$message.= "<tr><th>Transaction ID</th><th>Date</th><th>Style</th><th>Schedule</th><th>Color</th><th>SFCS Size Code</th><th>M3 Size Code</th><th>Status</th><th>MO Number</th><th>M3 Operation Code</th><th>SFCS Job #</th><th>Docket #</th><th>Reported Qty</th><th>Rejection Reasons</th><th>Remarks</th><th>Log User</th><th>Log Time</th><th>Module #</th><th>Shift</th><th>M3 Operation Des.</th><th>SFCS Tran. Ref. ID</th><th>M3 Error Code</th>
</tr>";

$sql="select * from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_date='$sdate' and sfcs_status in (0,20)";
//$message.= $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$result_count+=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
$sfcs_tid=$sql_row['sfcs_tid'];
$sfcs_date=$sql_row['sfcs_date'];
$sfcs_style=$sql_row['sfcs_style'];
$sfcs_schedule=$sql_row['sfcs_schedule'];
$sfcs_color=$sql_row['sfcs_color'];
$sfcs_size=$sql_row['sfcs_size'];
$m3_size=$sql_row['m3_size'];
$sfcs_doc_no=$sql_row['sfcs_doc_no'];
$sfcs_qty=$sql_row['sfcs_qty'];
$sfcs_reason=$sql_row['sfcs_reason'];
$sfcs_remarks=$sql_row['sfcs_remarks'];
$sfcs_log_user=$sql_row['sfcs_log_user'];
$sfcs_log_time=$sql_row['sfcs_log_time'];
$sfcs_status=$sql_row['sfcs_status'];
$m3_mo_no=$sql_row['m3_mo_no'];
$m3_op_code=$sql_row['m3_op_code'];
$sfcs_job_no=$sql_row['sfcs_job_no'];
$sfcs_mod_no=$sql_row['sfcs_mod_no'];
$sfcs_shift=$sql_row['sfcs_shift'];
$m3_op_des=$sql_row['m3_op_des'];
$sfcs_tid_ref=$sql_row['sfcs_tid_ref'];
$m3_error_code=$sql_row['m3_error_code'];


$message.= "<tr><td>$sfcs_tid</td><td>$sfcs_date</td><td>$sfcs_style</td><td>$sfcs_schedule</td><td>$sfcs_color</td><td>$sfcs_size</td><td>$m3_size</td><td>$sfcs_status</td><td>$m3_mo_no</td><td>$m3_op_code</td><td>$sfcs_job_no</td><td>$sfcs_doc_no</td><td>$sfcs_qty</td><td>".(strlen($sfcs_reason)==0?'GOOD':$sfcs_reason)."</td><td>$sfcs_remarks</td><td>$sfcs_log_user</td><td>$sfcs_log_time</td><td>$sfcs_mod_no</td><td>$sfcs_shift</td><td>$m3_op_des</td><td>$sfcs_tid_ref</td><td>$m3_error_code</td></tr>";

}

$message.= "</table>";


$message.= "<h3>M3 Bulk Operation Overdue WIP Entries</h3>";
$message.= "<table id=\"table111\" border=1 class=\"mytable\">";
$message.= "<tr><th>Transaction ID</th><th>Date</th><th>Style</th><th>Schedule</th><th>Color</th><th>SFCS Size Code</th><th>M3 Size Code</th><th>Status</th><th>MO Number</th><th>M3 Operation Code</th><th>SFCS Job #</th><th>Docket #</th><th>Reported Qty</th><th>Rejection Reasons</th><th>Remarks</th><th>Log User</th><th>Log Time</th><th>Module #</th><th>Shift</th><th>M3 Operation Des.</th><th>SFCS Tran. Ref. ID</th><th>M3 Error Code</th>
</tr>";

$sql="select * from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_date<'$sdate' and sfcs_status in (0,10,15,16,20)";
//$message.= $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$result_count+=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
$sfcs_tid=$sql_row['sfcs_tid'];
$sfcs_date=$sql_row['sfcs_date'];
$sfcs_style=$sql_row['sfcs_style'];
$sfcs_schedule=$sql_row['sfcs_schedule'];
$sfcs_color=$sql_row['sfcs_color'];
$sfcs_size=$sql_row['sfcs_size'];
$m3_size=$sql_row['m3_size'];
$sfcs_doc_no=$sql_row['sfcs_doc_no'];
$sfcs_qty=$sql_row['sfcs_qty'];
$sfcs_reason=$sql_row['sfcs_reason'];
$sfcs_remarks=$sql_row['sfcs_remarks'];
$sfcs_log_user=$sql_row['sfcs_log_user'];
$sfcs_log_time=$sql_row['sfcs_log_time'];
$sfcs_status=$sql_row['sfcs_status'];
$m3_mo_no=$sql_row['m3_mo_no'];
$m3_op_code=$sql_row['m3_op_code'];
$sfcs_job_no=$sql_row['sfcs_job_no'];
$sfcs_mod_no=$sql_row['sfcs_mod_no'];
$sfcs_shift=$sql_row['sfcs_shift'];
$m3_op_des=$sql_row['m3_op_des'];
$sfcs_tid_ref=$sql_row['sfcs_tid_ref'];
$m3_error_code=$sql_row['m3_error_code'];


$message.= "<tr><td>$sfcs_tid</td><td>$sfcs_date</td><td>$sfcs_style</td><td>$sfcs_schedule</td><td>$sfcs_color</td><td>$sfcs_size</td><td>$m3_size</td><td>$sfcs_status</td><td>$m3_mo_no</td><td>$m3_op_code</td><td>$sfcs_job_no</td><td>$sfcs_doc_no</td><td>$sfcs_qty</td><td>".(strlen($sfcs_reason)==0?'GOOD':$sfcs_reason)."</td><td>$sfcs_remarks</td><td>$sfcs_log_user</td><td>$sfcs_log_time</td><td>$sfcs_mod_no</td><td>$sfcs_shift</td><td>$m3_op_des</td><td>$sfcs_tid_ref</td><td>$m3_error_code</td></tr>";

}

$message.= "</table></body>
</html>";

$to  =$transaction_audit_alert;



$subject = 'M3 Bulk Operation Pending Reporting Status';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
//$headers .= 'To: '.$to. "\r\n";
//$headers .= 'To: <brandixalerts@schemaxtech.com>'. "\r\n";
$headers .= $header_from. "\r\n";

if($result_count>0)
{
	if(mail($to, $subject, $message, $headers))
	{
		print("mail sent successfully")."\n";

	}
	else
	{
		print("mail not sent")."\n";
	}

}


?>
<?php
	$end_timestamp = microtime(true);
	$duration = $end_timestamp - $start_timestamp;
	print("Execution took ".$duration." milliseconds.");
?>
</body>
</html>