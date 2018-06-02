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


$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

$database="bai_pro";

$user=$user;
$password=$pass;
$host=$host;

$link1= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link1, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));


?>

<?php

$sections_db=array(1,2,3,4,5,6);
set_time_limit(6000000);

?>