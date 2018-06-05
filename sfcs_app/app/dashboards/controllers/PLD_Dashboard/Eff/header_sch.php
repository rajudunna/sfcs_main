<?php

// include($_SERVER['DOCUMENT_ROOT']."server/db_hosts.php");
include('C:\xampp\htdocs\sfcs_app\common\config\config_jobs.php');
// Turn off all error reporting
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$database="bai_pro";
$user=$host;
$password=$pass;
$host=$host;


$table="down_deps";
$table1="down_log";
$table2="grand_rep";
//$dat="2011-12-17";
//$dat=date("Y-m-d");

$con = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect: " . mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($con, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT MAX(DATE) as date FROM bai_pro.grand_rep");
while($row=mysqli_fetch_array($sql))
{
	$date=$row["date"];
}

$dat_explode=explode("-",$date);
$y=$dat_explode[0];
$m=$dat_explode[1];
$d=$dat_explode[2];
//echo $y."-".$m."-".$d;
$yesterday = date("Y-m-d",mktime(0, 0, 0, date("$m")  , date("$d")-1, date("$y")));
//echo $yesterday;
$dat=$yesterday;
$dat_tmp="2012-11-23"; //For Visit Purpose
$dat_tmp=$yesterday;
//$dat="2012-06-16";
$present_time=date("H")-6;

?>
