<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
		
<style>
body
{
	font-family:calibri;
	font-size:12px;
}

table tr
{
	border: solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: solid black;
	text-align: right;
white-space:nowrap; 
text-align:left;
}

table th
{
	border: solid black;
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


}

}
</style>

</head>
<body>

<?php 
include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/db_hosts.php");
$database="bai_pro";
$user=$host_adr_un;
$password=$host_adr_pw;
$host=$host_adr;

$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));


set_time_limit(2000); 

if(isset($_POST['submit1']))
{
		$table=$_POST['table'];
		header("Content-type: application/x-msdownload"); 
		# replace excelfile.xls with whatever you want the filename to default to
		header("Content-Disposition: attachment; filename=Daily_Plan_Achievement_Report.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $table;
	
}

?>





</body>
</html>
<?php ((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res); ?>