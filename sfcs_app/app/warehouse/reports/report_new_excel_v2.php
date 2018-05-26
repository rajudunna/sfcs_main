<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
</head>
<body>
<?php
	set_time_limit(50000);
	//require_once('phplogin/auth.php');
?>

<?php
		include("stock_report_source.php");


		header("Content-type: application/x-msdownload"); 
		# replace excelfile.xls with whatever you want the filename to default to
		header("Content-Disposition: attachment; filename=RM_Stock_Report_".date("Y-m-d_H_i").".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $data;
?>

</body>
</html>