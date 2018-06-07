<html>
<head>

<script language="javascript" type="text/javascript" src='<?= getFullURLLevel($_GET['r'], "common/js/dropdowntabs.js", 3, "R"); ?>'></script>
<link rel="stylesheet" href='<?php echo getFullURLLevel($_GET['r'], "common/css/ddcolortabs.css", 3, "R"); ?>' type="text/css" media="all" />
<link rel="stylesheet" href="<?=  getFullURLLevel($_GET['r'], "common/css/table_style.css", 3, "R"); ?>" type="text/css" media="all" />

</head>
<body>
<?php 
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/db_hosts.php");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));?>

<?php 
	error_reporting(E_ALL ^ E_NOTICE);
?>

<?php
// Name of the file
//$filename = 'core_sql.txt';
$filename = $_POST['id'];

// mysql host
// $mysql_host = $host_adr;
// mysql username
// $mysql_username = $host_adr_un;
// mysql password
// $mysql_password = $host_adr_pw;
// Database name
// $mysql_database = 'bai_pro4';

//////////////////////////////////////////////////////////////////////////////////////////////

// Connect to mysql server

($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $user,  $pass,$bai_pro4)) or die('Error connecting to mysql server: ' . mysqli_error($GLOBALS["___mysqli_ston"]));
// Select database
mysqli_select_db($link, $bai_pro4) or die('Error selecting mysql database: ' . mysqli_error($GLOBALS["___mysqli_ston"]));

// Temporary variable, used to store current query
$templine = '';
// Read in entire file
$file_path  = $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'weekly_delivery_plan/'.$filename,0,'R');
$lines = file($file_path);
// require $file_path;
// $lines = fopen($file_path,"r");

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
echo "<br/>Database UPDATED";   

echo "<br/>Pleae wait while processing data!";

if(substr($filename,0,2)=="SP")
{
	$url1=getFullURLLevel($_GET['r'],'shipment_plan_week_manual.php',0,'N');
	// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$dns_adr3/projects/beta/visionair/shipment_plan_week_manual.php\"; }</script>";
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url1\"; }</script>";

}
else
{

//MAIL UPDATE
{
	$message= '<html><head><style type="text/css">

body
{
	font-family: arial;
	font-size:12px;
	color:black;
}
table
{
	border-collapse:collapse;
	white-space:nowrap; 
}
th
{
	color: black;
 	border: 1px solid #660000; 
	white-space:nowrap; 
	padding-left: 10px;
	padding-right: 10px;
}

td
{
	color: BLACK;
 	border: 1px solid #660000; 
	padding: 1px;
	white-space:nowrap; 
	text-align:right;
}

.green
{
	border: 0;

}

.red
{
	border: 0;

}

.yash
{
	border: 0;

}
</style></head><body>';

$message.="Dear All,<br/><br/>
The 2 Weeks Plan Schedules had been updated in FSP Status in BAINet.<br/><br/>";

$message.='<br/>Message Sent Via: http://bainet';
$message.="</body></html>";

  //$to  = 'BAIPlanningTeam@brandix.com,BAIManufacturingTeam@brandix.com,BAISupplyChainTeam@brandix.com,brandixalerts@schemaxtech.com,brandixalerts@schemaxtech.com';
    $to  = 'brandixalerts@schemaxtech.com';
	$subject = 'BAI 2 Weeks Plan Update';
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Additional headers
	//$headers .= 'To: <BAIPlanningTeam@brandix.com>; <BAIManufacturingTeam@brandix.com>; <BAISupplyChainTeam@brandix.com>'. "\r\n";
	$headers .= 'To: <brandixalerts@schemaxtech.com>;'. "\r\n";
	$headers .= 'From: Shop Floor System Alert <ictsysalert@brandix.com>'. "\r\n";
	
	//mail($to, $subject, $message, $headers);
}


//MAIL UPDATE
$url2=getFullURLLevel($_GET['r'],'plan_process_week.php',0,'N');
// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$dns_adr3/projects/beta/visionair/plan_process_week.php\"; }</script>";
echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url2\"; }</script>";


}


?>
</body>
</html>




