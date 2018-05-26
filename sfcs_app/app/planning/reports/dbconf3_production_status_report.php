<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/db_hosts.php");
// Turn off all error reporting
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);


$database11="bai_pro3";
$user11=$host_adr_un;
$password11=$host_adr_pw;
$host11=$host_adr;

$link11= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host11, $user11, $password11)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link11, $database11) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));


?>
