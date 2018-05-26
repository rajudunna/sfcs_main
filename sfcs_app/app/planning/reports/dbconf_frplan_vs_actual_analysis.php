<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/db_hosts.php");
// Turn off all error reporting
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);


$database="bai_pro";
$user=$host_adr_un;
$password=$host_adr_pw;
$host=$host_adr;

$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

/* echo "<font color=\"RED\"><strong>Navigator : </strong></font>";
echo "<a href=\"final_rep.php\">Section</a> <font color=\"WHITE\">|</font> ";
echo "<a href=\"final_rep2.php\">Style</a> <font color=\"WHITE\">|</font> ";
echo "<a href=\"input_cpanel.php\">Current Update</a> <font color=\"WHITE\">|</font> ";
echo "<a href=\"final_rep5.php\">REP-1</a> <font color=\"WHITE\">|</font> ";
echo "<a href=\"final_rep6.php\">REP-2</a> <font color=\"WHITE\">|</font> ";
echo "<a href=\"final_rep7.php\">REP-7</a> <font color=\"WHITE\">|</font> ";
echo "<a href=\"temp\upload_ac.php\">Upload</a> <font color=\"WHITE\">|</font> ";
	 echo "<a href=\"input_cpanel2.php\">Delay Update</a> <font color=\"WHITE\">|</font> "; 
echo "<a href=\"section_bup_final.php\">Sec.Summary</a> <font color=\"WHITE\">|</font> ";

echo "<a href=\"final_rep77.php\">REP 77</a> <font color=\"WHITE\">|</font> ";
echo "<a href=\"final_rep55.php\">REP 55</a> <font color=\"WHITE\">|</font> ";
echo "<a href=\"final_rep56.php\">REP-56</a> <font color=\"WHITE\">|</font> ";

echo "<a href=\"eff_report.php\">Eff Report</a> <font color=\"WHITE\">|</font> ";
echo "<a href=\"generate.php\">Generate</a> <font color=\"WHITE\">|</font> "; */


set_time_limit(2000);
?>