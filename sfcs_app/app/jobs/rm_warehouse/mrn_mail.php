<?php
$start_timestamp = microtime(true);

error_reporting(0);
$message="<html>
<head>
<style type=\"text/css\">

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
text-align:right;
}

.highlight td
{
	background-color: green;
	color: BLACK;
 border: 1px solid #660000; 
	padding: 1px;
white-space:nowrap; 
text-align:right;
}

</style>
</head>
<body>";
$include_path=getenv('config_job_path');

include($include_path.'\sfcs_app\common\config\config_jobs.php');

$start_date_w=time();
while((date("N",$start_date_w))!=1) {
$start_date_w=$start_date_w-(60*60*24); // define monday
}
$end_date_w=$start_date_w+(60*60*24*6); // define sunday 
$start_date_w=date("Y-m-d",$start_date_w);
$end_date_w=date("Y-m-d",$end_date_w);
$start_date_w=date("Y-m-d l",strtotime("-7 days", strtotime($start_date_w)));
$end_date_w=date("Y-m-d l",strtotime("-7 days", strtotime($end_date_w)));

$j=0;
$message.= "Dear All,<br><br>Please find the Additional Material Requests of ".trim($start_date_w)." to ".trim($end_date_w).".<br><br>";
$message.="<table><tr bgcolor=\"yellow\"><th>Section</th><th>PTRIMS</th><th>STRIMS</th><th>FTRIMS</th><th>Recuts</th></tr>";

$sql="SELECT section,SUM(IF(product='PTRIM',1,0)) AS PTRIM,SUM(IF(product='STRIM',1,0)) AS STRIM,SUM(IF(product='FAB',1,0)) AS FAB FROM $bai_rm_pj2.mrn_track WHERE DATE(req_date) BETWEEN \"".trim($start_date_w)."\" AND \"".trim($end_date_w)."\" GROUP BY section";
//echo $sql;
$result=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row=mysqli_fetch_array($result))
{
	$message.="<tr>";
	$message.="<td>".$row["section"]."</td>";
	$message.="<td>".$row["PTRIM"]."</td>";
	$message.="<td>".$row["STRIM"]."</td>";
	$message.="<td>".$row["FAB"]."</td>";
	$sql1="select sec_mods from $bai_pro3.sections_db where sec_id=".$row["section"]."";
	//echo $sql1;
	$result1=mysqli_query($link, $sql1) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		$mods=$row1["sec_mods"];
	}
	$recut_count=0;
	$sql2="SELECT COUNT(DISTINCT qms_schedule) AS sch FROM $bai_pro3.bai_qms_db WHERE log_date BETWEEN \"".trim($start_date_w)."\" AND \"".trim($end_date_w)."\" AND qms_tran_type=6 AND SUBSTRING_INDEX(remarks,'-',1) IN ($mods) GROUP BY log_time";
	//echo $sql2;
	$result2=mysqli_query($link, $sql2) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row2=mysqli_fetch_array($result2))
	{
		$recut_count=$recut_count+$row2["sch"];
	}
	
	$message.="<td>".$recut_count."</td>";
	
	$message.="</tr>";	
	$j++;
}

$message.="</table>";
$message.='<br/>Message Sent Via:'.$plant_name;
$message.="</body></html>";

// echo $message;

$to  = $mrn_mail;
$subject = 'Additional Material Requests of Last Week.';
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$headers .= $header_from. "\r\n";

if($j>0)
{
	a:
	if(mail($to, $subject, $message, $headers))
	{
		print("Mail Successfully Sent")."\n";
	}
	else
	{
		goto a;
	}
}
else
{
		print("Mail not send because no data")."\n";

}

$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." Seconds.")."\n";
?>
