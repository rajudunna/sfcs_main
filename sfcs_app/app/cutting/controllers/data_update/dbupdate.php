<!--
Code Module:M3 to SFS data upload

Description:uploading converted text file to database and then root the process flow to nwxt level.

Changes Log:
-->
<?php
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/db_hosts.php");
include('../'.getFullURLLevel($_GET['r'],'/common/config/db_hosts.php',4,'R'));
set_time_limit(2000);
?>

<style>
body{
	font-family: "calibri";
}
</style>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',4,'R');?>"></script>
<body>
<?php 
include('../'.getFullURLLevel($_GET['r'],'/common/config/config.php',4,'R'));
include("../".getFullURLLevel($_GET['r'],'/common/config/menu_content.php',4,'R')); ?>
<?php 
error_reporting(E_ALL ^ E_NOTICE);
?>

<?php
// Name of the file
//$filename = 'core_sql.txt';
$filename = $_POST['id'];

// mysql host
$mysql_host = $host_adr;
// mysql username
$mysql_username = $host_adr_un;
// mysql password
$mysql_password = $host_adr_pw;
// Database name
$mysql_database = 'bai_pro3';

//////////////////////////////////////////////////////////////////////////////////////////////

// Connect to mysql server
($GLOBALS["___mysqli_ston"] = mysqli_connect($mysql_host,  $mysql_username,  $mysql_password)) or die('Error connecting to mysql server: ' . mysqli_error($GLOBALS["___mysqli_ston"]));
// Select database
mysqli_select_db($GLOBALS["___mysqli_ston"], $mysql_database) or die('Error selecting mysql database: ' . mysqli_error($GLOBALS["___mysqli_ston"]));

mysqli_query($GLOBALS["___mysqli_ston"], "truncate shipment_plan");
mysqli_query($GLOBALS["___mysqli_ston"], "truncate order_plan");

// Temporary variable, used to store current query
$templine = '';
// Read in entire file
$lines = file($filename);
// Loop through each line
foreach ($lines as $line_num => $line) {
// Only continue if it's not a comment
if (substr($line, 0, 2) != '--' && $line != '') {
// Add this line to the current segment
$templine .= $line;
// If it has a semicolon at the end, it's the end of the query
if (substr(trim($line), -1, 1) == ';') {
// Perform the query
mysqli_query($GLOBALS["___mysqli_ston"], $templine) or print('Error performing query \'<b>' . $templine . '</b>\': ' . mysqli_error($GLOBALS["___mysqli_ston"]) . '<br /><br />');
// Reset temp variable to empty
$templine = '';

}
}

}

$dir = '../cache/';
foreach(glob($dir.'*.*') as $v){
unlink($v);
}
echo "<div class='alert alert-info alert-dismissible'>
<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
<strong>Database UPDATED Successfully.</strong></div>";
// echo "<br/>Database UPDATED";
echo '<div class="panel panel-primary" style="height:150px;"><div class="panel-heading">Data Upload</div><div class="panel-body">';

if(substr($filename,0,2)=="SP")
{
	$url = getFullURLLevel($_GET['r'],'/DB_MSSQL_Conn_TEST/CMS/ssc_plan_process.php',2,'N');
	echo "<br/><br/><a href=$url  class='btn btn-primary' >Click here to process</a>";
}
else
{
	// echo getFullURLLevel($_GET['r'],'/DB_MSSQL_Conn_TEST/CMS/ssc_plan_process.php',2,'N');
	$url=getFullURLLevel($_GET['r'],'/DB_MSSQL_Conn_TEST/CMS/ssc_porcess4.php',2,'N');
	echo "<br/><br/><a href=$url class='btn btn-primary'>click me to check Analysis Report</a>";
}
echo '</div></div>';


?>
</body>




