<?php 

//SFCS Db Configurations
$host="192.168.0.110:3326";
$user="baiall";
$pass="baiall";
$bai_pro3="bai_pro3";

$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $pass)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link, $bai_pro3) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

?>