<?php
//schedule Name - SFCS_ALR_IPS_Dashboard_Summary
//V1 - Buyer Division was binded based on user allocation
//V2 - Buyer division seperated from user binding, since one buyer division is handling by multiple planners. Ex: M&S .

?>

<?php
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');

$sql="select * from $bai_pro3.buyer_style";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$styles_list=array();
$style_auth=array();
$styles_names=array();
while($sql_row=mysqli_fetch_array($sql_result))
{
$styles_list[]=$sql_row["buyer_identity"];
$styles_names[]=$sql_row['buyer_name'];
$style_auth[]=$sql_row['user_list'];
}

$message= '<html>
<head>
<style>
body
{
	font-family: Trebuchet MS;
	font-size: 14px;
}



table
{
	border-collapse:collapse;
	white-space:nowrap;
	font-size: 12px; 
}


th
{
	background-color: #66EEFF;
	color: black;
	border: 1px solid #660000;
	padding-left: 5px;
	padding-right: 5px;
	white-space:nowrap; 
	text-align:center;

}

td
{
	background-color: WHITE;
	color: BLACK;
	border: 1px solid #660000;
	white-space:nowrap; 
	text-align:center;
	padding-left: 5px;
	padding-right: 5px;
}


</style>
</head>
<body>';



$message.= "<table>";
$message.= "<tr><th>Buyer Division</th><th>Modules</th><th>Capacity</th><th>Open</th><th>%</th><th>Critical</th></tr>";

$sqlx="SELECT buyer_div, COUNT(module_id) AS modules, COUNT(module_id)*14 AS capacity, GROUP_CONCAT(module_id) AS modules_ids FROM $bai_pro3.plan_modules GROUP BY buyer_div order by COUNT(module_id)";
//echo $sqlx;
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$sql1="SELECT count(module) as filled, sum(if((ft_status<>1 or st_status<>1),1,0)) as failed FROM $bai_pro3.plan_dash_doc_summ where module in (".$sql_rowx['modules_ids'].")";
	//echo $sql1;
	// mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$filled=$sql_row1['filled'];
		$failed=$sql_row1['failed'];
	}
	$message.= "<tr><td>".$sql_rowx['buyer_div']."</td><td>".$sql_rowx['modules']."</td><td>".$sql_rowx['capacity']."</td><td>".($sql_rowx['capacity']-$filled)."</td><td>".round(((($sql_rowx['capacity']-$filled)/$sql_rowx['capacity'])*100),0)."</td><td>$failed</td></tr>";
}

$message.= "</table>";

$message.= '<br/><br/>Message Sent via: '.$plant_name.'</body>

</html>';


$to  = $pps_board_summary;


// subject
$subject = 'BEK Planning Dashboard Summary';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "From: ".$header_name." <".$header_mail.">". "\r\n";
// $headers .= $header_from. "\r\n";


// Mail it
if(mail($to, $subject, $message, $headers))
{
	print("mail sent successfully")."\n";
}
else
{
	print("mail failed")."\n";
}


$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>
