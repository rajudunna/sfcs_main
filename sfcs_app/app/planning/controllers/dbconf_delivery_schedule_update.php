<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/db_hosts.php");
// Turn off all error reporting
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);


$database="bai_pro4";

$user=$host_adr_un;
$password=$host_adr_pw;
$host=$host_adr;

//$database="bainet33";
//$user="bainet";
//$password="bainet";
//$host="localhost";

$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));



$database1="bai_pro";

$user1=$host_adr_un;
$password1=$host_adr_pw;
$host1=$host_adr;

//$database="bainet33";
//$user="bainet";
//$password="bainet";
//$host="localhost";

$link1= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host1, $user1, $password1)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link1, $database1) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

$database2="bai_pro3";
$user2=$host_adr_un;
$password2=$host_adr_pw;
$host2=$host_adr;

//$database="bainet33";
//$user="bainet";
//$password="bainet";
//$host="localhost";

$link2= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host2, $user2, $password2)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link2, $database2) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));


//include("menu_content.php"); 

?>


<?php

function embl_check($x)
{
	switch($x)
	{
		case "10000000":
		{
			return "Panel Form Print";
			break;
		}
		case "01000000":
		{
			return "Panel Form Embroidery";
			break;
		}
		case "00100000":
		{
			return "Print After Sew in &  Before Sew Out";
			break;
		}
		case "00010000":
		{
			return "Print After Sew in &  Before Sew Out";
			break;
		}
		case "00001000":
		{
			return "Print After Sewing Out";
			break;
		}
		case "00000100":
		{
			return "Embroidery After Sewing Out";
			break;
		}
		case "00000010":
		{
			return "Washing";
			break;
		}
		case "00000001":
		{
			return "Dyeing";
			break;
		}
		default:
		{
			return "";
		}
		
	}
}

?>