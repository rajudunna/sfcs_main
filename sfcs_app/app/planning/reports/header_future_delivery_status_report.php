<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/db_hosts.php");
// Turn off all error reporting
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$database="bai_pro3";
$database1="bai_pro";
$user=$host_adr_un;
$password=$host_adr_pw;
$host=$host_adr;

$link = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect21: " . mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

$link1 = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect21: " . mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link1, $database1) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));
$table1 = "wip_write_off_db";

?>