<?php

include($_SERVER['DOCUMENT_ROOT']."server/db_hosts.php");
$database="bai_pro";
$user=$host_adr_un;
$password=$host_adr_pw;
$host=$host_adr;
$table="bai_log_buf";
$table1="bai_quality_log";


$con = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect: " . mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($con, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

/*$database1="bai_pro3";
$user1=$host_adr_un;
$password1=$host_adr_pw;
$host1=$host_adr;
$table2="sections_db";

$link = mysql_connect($host1,$user1,$password1) or die("Could not connect: " . mysql_error());
mysql_select_db("$database1",$link) or die("Error in selecting the database:".mysql_error());*/

?>
