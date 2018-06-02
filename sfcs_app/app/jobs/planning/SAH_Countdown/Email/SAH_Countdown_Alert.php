
<?php
include("C:/xampp/htdocs/sfcs/jobs/db_hosts.php");

$command ='webshotcmd /url "http://localhost/sfcs/jobs/planning/Plan_sah.php" /bwidth 1500 /bheight 700 /out echart.png /username baischtasksvc /password pass@123';

shell_exec($command);

sleep(120);

?>
<?php
include("header.php");
// Turn off all error reporting
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);


//MAIL CONFIRMATION
$date=date("Y-m-d");
//$date="2017-10-13";

$sql="SELECT CONCAT(bac_date,'-',bac_no,'-',bac_shift) AS tid, ROUND(SUM((bac_qty*smv)/60),2) AS sah FROM bai_pro.bai_log_buf WHERE bac_date between \"$date\" and \"$date\" GROUP BY CONCAT(bac_date,'-',bac_no,'-',bac_shift) ";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	
	$sql_new="update bai_pro.grand_rep set act_sth=".$sql_row['sah']." where tid='".$sql_row['tid']."'";
	mysqli_query($link, $sql_new) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
}
//New block create to flush data from the begginig of the month to till date  and refresh the data in SFCS - kiran 20150722


$sql="select sum(act_out) as \"act_out\" from bai_pro.grand_rep where date =\"$date\" ";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
		{
			
			$act_out=$sql_row['act_out'];
			$act_out_check+=$act_out;
		}

	include ("class.omime/class.omime.php");
	
	

		// $em=array("fazlulr@schemaxtech.com","brandixalerts@schemaxtech.com","bhargavg@schemaxtech.com","dharanid@schemaxtech.com");
		$em=array("yateesh603@gmail.com","saiyateesh@gmail.com","ravindranath.yrr@gmail.com");

    
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
if($act_out_check>0)
{		
	$successful = $email->send(implode(",",$em), 'QCI - SAH Countdown Report', 'from: Shop Floor System Alert <ictsysalert@brandix.com>');
	
	if($successful)
	{
		echo (implode(",",$em))."OK<br/>";
		// echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";	
	}
	else
	{
		echo (implode(",",$em))."NOT OK<br/>";
	}
}	
//echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";		
	?>
