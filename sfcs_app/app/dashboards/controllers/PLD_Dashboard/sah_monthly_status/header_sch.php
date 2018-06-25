<?php


$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');	
// Turn off all error reporting
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$database="bai_pro";
$user=$user;
$password=$pass;
$host=$host;

//$table="week_delivery_plan";

//$dat="2011-12-12";
$dat=date("Y-m-d");

$date = $dat; 
$weekday = date('l', strtotime($date));
//$weekday="Saturday";
////echo $weekday."---".$date."<br>";
if($weekday == "Monday")
{
	$monday=date("Y-m-d",strtotime("-0 day"));
	$thuesday=date("Y-m-d",strtotime("1 day"));
	$wednesday=date("Y-m-d",strtotime("2 day"));
	$thursday=date("Y-m-d",strtotime("3 day"));
	$friday=date("Y-m-d",strtotime("4 day"));
	$saturday=date("Y-m-d",strtotime("5 day"));
	//echo $monday."---".$thuesday."---".$wednesday."---".$thursday."---".$friday."---".$saturday;
}
else if($weekday == "Tuesday")
{
	$monday=date("Y-m-d",strtotime("-1 day"));
	$thuesday=date("Y-m-d",strtotime("-0 day"));
	$wednesday=date("Y-m-d",strtotime("1 day"));
	$thursday=date("Y-m-d",strtotime("2 day"));
	$friday=date("Y-m-d",strtotime("3 day"));
	$saturday=date("Y-m-d",strtotime("4 day"));
	//echo $monday."---".$thuesday."---".$wednesday."---".$thursday."---".$friday."---".$saturday;
}
else if($weekday == "Wednesday")
{
	$monday=date("Y-m-d",strtotime("-2 day"));
	$thuesday=date("Y-m-d",strtotime("-1 day"));
	$wednesday=date("Y-m-d",strtotime("-0 day"));
	$thursday=date("Y-m-d",strtotime("+1 day"));
	$friday=date("Y-m-d",strtotime("+2 day"));
	$saturday=date("Y-m-d",strtotime("+3 day"));
	//echo $monday."---".$thuesday."---".$wednesday."---".$thursday."---".$friday."---".$saturday;
}
else if($weekday == "Thursday")
{
	$monday=date("Y-m-d",strtotime("-3 day"));
	$thuesday=date("Y-m-d",strtotime("-2 day"));
	$wednesday=date("Y-m-d",strtotime("-1 day"));
	$thursday=date("Y-m-d",strtotime("+0 day"));
	$friday=date("Y-m-d",strtotime("+1 day"));
	$saturday=date("Y-m-d",strtotime("+2 day"));
	//echo $monday."---".$thuesday."---".$wednesday."---".$thursday."---".$friday."---".$saturday;
}
else if($weekday == "Friday")
{
	$monday=date("Y-m-d",strtotime("-4 day"));
	$thuesday=date("Y-m-d",strtotime("-3 day"));
	$wednesday=date("Y-m-d",strtotime("-2 day"));
	$thursday=date("Y-m-d",strtotime("-1 day"));
	$friday=date("Y-m-d",strtotime("-0 day"));
	$saturday=date("Y-m-d",strtotime("1 day"));
	//echo $monday."---".$thuesday."---".$wednesday."---".$thursday."---".$friday."---".$saturday;
}
else if($weekday == "Saturday")
{
	$monday=date("Y-m-d",strtotime("-5 day"));
	$thuesday=date("Y-m-d",strtotime("-4 day"));
	$wednesday=date("Y-m-d",strtotime("-3 day"));
	$thursday=date("Y-m-d",strtotime("-2 day"));
	$friday=date("Y-m-d",strtotime("-1 day"));
	$saturday=date("Y-m-d",strtotime("-0 day"));
	//echo $monday."---".$thuesday."---".$wednesday."---".$thursday."---".$friday."---".$saturday;
}
else
{
	$monday=date("Y-m-d",strtotime("-1 day"));
	$thuesday=date("Y-m-d",strtotime("-1 day"));
	$wednesday=date("Y-m-d",strtotime("-1 day"));
	$thursday=date("Y-m-d",strtotime("-1 day"));
	$friday=date("Y-m-d",strtotime("-1 day"));
	$saturday=date("Y-m-d",strtotime("-1 day"));
	//echo $monday."---".$thuesday."---".$wednesday."---".$thursday."---".$friday."---".$saturday;
}

$con = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect: " . mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($con, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

?>
