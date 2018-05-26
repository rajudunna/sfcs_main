
<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/db_hosts.php");
// Turn off all error reporting
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);


$database="bai_pro3";
$user=$host_adr_un;
$password=$host_adr_pw;
//$host=$host_adr;
$host=$host_adr;

// start for speed/ IU modules
$iustyle="OC";
// end for speed/ IU modules

$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

$database="bai_pro";
$user=$host_adr_un;
$password=$host_adr_pw;
//$host=$host_adr;
$host=$host_adr;

$link_new= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link_new, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

$database="bai_pro4";
$user=$host_adr_un;
$password=$host_adr_pw;
//$host=$host_adr;
$host=$host_adr;

$link_new2= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link_new2, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

set_time_limit(60000);

$bai_rm_pj1="bai_rm_pj1";

?>