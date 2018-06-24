
<?php
$start_timestamp = microtime(true);
include('C:\xampp\htdocs\sfcs_main\sfcs_app\common\config\config_jobs.php');

set_time_limit(90000000);

// $command ='webshotcmd /url "http://localhost/sfcs_main/sfcs_app/app/jobs/planning/SAH_Countdown/Plan_sah.php" /bwidth 1500 /bheight 700 /out echart.png /username baischtasksvc /password pass@123';

shell_exec($command);

sleep(120);

?>
<?php
// include("header.php");
// Turn off all error reporting
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);


//MAIL CONFIRMATION
$date=date("Y-m-d");
// $date="2018-06-02";


$sql="SELECT CONCAT(bac_date,'-',bac_no,'-',bac_shift) AS tid, ROUND(SUM((bac_qty*smv)/60),2) AS sah FROM $bai_pro.bai_log_buf WHERE bac_date between \"$date\" and \"$date\" GROUP BY CONCAT(bac_date,'-',bac_no,'-',bac_shift) ";
// echo $sql."<br>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$sql_new="update $bai_pro.grand_rep set act_sth=".$sql_row['sah']." where tid='".$sql_row['tid']."'";
	mysqli_query($link, $sql_new) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
}
//New block create to flush data from the begginig of the month to till date  and refresh the data in SFCS - kiran 20150722


$sql="select sum(act_out) as \"act_out\" from $bai_pro.grand_rep where date =\"$date\" ";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
		{
			
			$act_out=$sql_row['act_out'];
			$act_out_check+=$act_out;
		}

	include ("class.omime/class.omime.php");
	
	

		$em=$SAH_Countdown_alert;

	

    
		$email = omime::create('related');
				$contentID = $email->addURL('echart.png', 'echart.png');
				// $tag='<img src="cid:'.$contentID.'" alt="echart.png" />';
		
		// Create text message
		$message = new omime('alternative');
		//$email->attachFile('iPirates_P2.html', 'iPirates_P2.html');
		//$message->attachText('This email has an email image [image: mimay.jpg] Ain\'t that neat?');
		$message->attachHTML('<html><head><style> body { font-family:calibri; font-size:12; } table td{border:1px solid black;} table th{border:1px solid black;  background-color: #29759C; color: white;} table tr{border:1px solid black;} table{	border-collapse: collapse;}</style></head><body>&nbsp;Dear All, <br/><br/>&nbsp;Please find the below details. <br/> '.$tag.'</body></html>');
		
		// Add message to email
		$email->addMultipart($message);
		
		// Send email
		// echo $act_out_check."<br>";
if($act_out_check>0)
{		
	// $successful = $email->send(implode(",",$em), 'QCI - SAH Countdown Report', 'from: Shop Floor System Alert <ictsysalert@brandix.com>');
	$successful = $email->send(implode(",",$em), 'SAH Countdown Report');

	
	if($successful)
	{
		echo (implode(",",$em))."OK<br/>";
	
	}
	else
	{
		echo (implode(",",$em))."NOT OK<br/>";
	}
}	
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>
