<?php
// Turn off all error reporting
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once($_SERVER['DOCUMENT_ROOT']."/configuration/API/confr.php");
$conf_tool = new confr($_SERVER['DOCUMENT_ROOT']."/configuration/API/saved_fields/fields.json");
$db_obj = $conf_tool->getDBConfig();

$database="bai_pro3";

$user= $db_obj['db_user'];
$password=$db_obj['db_pass'];
$host= $db_obj['db_host'].":".$db_obj['db_port'];

// $user=$host_adr_un;
// $password=$host_adr_pw;
// $host=$host_adr;

$link= mysqli_connect('192.168.0.110:3326','baiall','baiall') or die("Could not connect: ".mysql_error());
set_time_limit(2000);
?>