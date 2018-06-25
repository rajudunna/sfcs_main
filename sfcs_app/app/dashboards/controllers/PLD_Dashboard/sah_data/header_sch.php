<?php

// include($_SERVER['DOCUMENT_ROOT']."server/db_hosts.php");
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

$table="down_deps";
$table1="down_log";
$table2="grand_rep";
//$dat="2011-08-25";
$dat=date("Y-m-d");
$present_time=date("H")-6;
//$present_time=16;
$con = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect: " . mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($con, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

?>
