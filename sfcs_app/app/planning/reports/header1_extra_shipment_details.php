<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/db_hosts.php");
// Turn off all error reporting
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);


$database="bai_pro3";
$user=$host_adr_un;
$password=$host_adr_pw;
$host=$host_adr;
$table="bai_orders_db_confirm";

$con = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect21: " . mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($con, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

$database2="bai_pro4";
$user2=$host_adr_un;
$password2=$host_adr_pw;
$host2=$host_adr;
$table4="week_delivery_plan_ref";

$con2 = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host2, $user2, $password2)) or die("Could not connect21: " . mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($con2, $database2) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

$database1="bai_pro2";
$user1=$host_adr_un;
$password1=$host_adr_pw;
$host1=$host_adr;
$table3="shipment_plan_summ";

$con1 = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host1, $user1, $password1)) or die("Could not connect21: " . mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($con1, $database1) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

set_time_limit(10000000);

?>
