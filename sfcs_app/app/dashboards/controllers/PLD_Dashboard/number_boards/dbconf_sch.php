<?php
// include($_SERVER['DOCUMENT_ROOT']."server/db_hosts.php");
include('C:\xampp\htdocs\sfcs_app\common\config\config_jobs.php');
// Turn off all error reporting
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);


$database="bai_pro3";
$user=$user;
$password=$pass;
$host=$host;

//$database="bainet33";
//$user=$host_adr_un;
//$password=$host_adr_un;
//$host="localhost";

$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

set_time_limit(60000);


?>