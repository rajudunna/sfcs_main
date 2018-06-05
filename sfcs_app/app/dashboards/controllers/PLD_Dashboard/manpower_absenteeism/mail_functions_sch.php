<?php
// include($_SERVER['DOCUMENT_ROOT']."server/db_hosts_open.php");
include("C:/xampp/htdocs/sfcs/Jobs/db_hosts.php")

function mail_alert($recep,$to,$cc,$msg,$subject)
{
	
	ini_set("10.227.19.18","25");
	$message= '<html>
<head>
<style>
body
{
	font-family: Trebuchet MS;
	font-size: 14px;
}

table tr
{
	border: 1px solid black;
	text-align: left;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	white-space:nowrap;
	text-align: left;
	padding-left: 5px;
	padding-right: 5px;
}

table th
{
	border: 1px solid black;
	text-align: center;
    background-color: BLUE;
	color: WHITE;
	white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
}

</style>
</head>
<body>';

$message.=$msg;

$message.= '<br/><br/>Message Sent via: '.$dns_adr1.'</body>

</html>';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: '.$to. "\r\n";
if(strlen($cc)>0)
{
	$headers .= 'CC: '.$cc. "\r\n";
}

$headers .= 'From: HRMS Alert <ictsysalert@brandix.com>'. "\r\n";
//$headers .= 'Cc: YasanthiN@brandix.com' . "\r\n";

// Mail it
if(mail($recep, $subject, $message, $headers))
{
	return TRUE;
}
else
{
	return FALSE;
}
//mail($recep, $subject, $message, $headers);
	
}



?>