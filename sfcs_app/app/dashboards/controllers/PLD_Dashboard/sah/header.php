<?php

include($_SERVER['DOCUMENT_ROOT']."server/db_hosts.php");
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
//$dat="2011-12-17";
$dat=date("Y-m-d");
$present_time=date("H")-6;
$con = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect: " . mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($con, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

?>