<?php
//include("header.php");
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_jobs.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php'); 
$schedule=$_GET['schedule'];
ini_set('max_execution_time', 300); 
// $schedule='469623';
$style=$_GET['style'];
// $style='T152AB83       ';
$input_job_no=$_GET['input_job'];
// $input_job_no=1;
$connect = odbc_connect("$driver_name;Server=$server;Database=$database;", $userid,$password) or die("Not Connected To M3");
$cut=1;
$color=array();
$sql="select order_col_des from $bai_pro3.packing_summary_input where order_del_no='".$schedule."' group by order_col_des";	 
$sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
while($row=mysqli_fetch_array($sql_result))
{
	$color[]=$row['order_col_des'];
}
?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 15">
<link rel=File-List href="sheet_v1_files/filelist.xml">
<style id="trim_sheet_30411_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl1530411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6330411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6430411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:center;
	vertical-align:top;
	border-top:.5pt solid black;
	border-right:.5pt solid black;
	border-bottom:.5pt solid black;
	border-left:none;
	background:whitesmoke;
	mso-pattern:whitesmoke none;
	white-space:normal;}
.xl6530411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:center;
	vertical-align:top;
	border-top:none;
	border-right:.5pt solid black;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl6630411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:center;
	vertical-align:top;
	border-top:none;
	border-right:.5pt solid black;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl6730411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:center;
	vertical-align:top;
	border-top:none;
	border-right:.5pt solid black;
	border-bottom:.5pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl6830411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid black;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:none;
	background:whitesmoke;
	mso-pattern:whitesmoke none;
	white-space:normal;}
.xl6930411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:right;
	vertical-align:top;
	border-top:.5pt solid black;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:none;
	background:whitesmoke;
	mso-pattern:whitesmoke none;
	white-space:normal;}
.xl7030411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:center;
	vertical-align:top;
	border-top:.5pt solid black;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:none;
	background:whitesmoke;
	mso-pattern:whitesmoke none;
	white-space:normal;}
.xl7130411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:general;
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7230411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:general;
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7330411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:"\[$-10409\]\#\,\#\#0\.00\;\\-\#\,\#\#0\.00";
	text-align:right;
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7430411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:right;
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7530411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:right;
	vertical-align:top;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7630411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:right;
	vertical-align:top;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7730411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7830411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7930411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:left;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl8030411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:general;
	vertical-align:top;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl8130411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl8230411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8330411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl8430411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8530411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8630411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:navy;
	font-size:14.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma, sans-serif;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl8730411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:center;
	vertical-align:top;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl8830411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl8930411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:right;
	vertical-align:top;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:.5pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl9030411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:general;
	vertical-align:top;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl9130411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:general;
	vertical-align:top;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl9230411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:general;
	vertical-align:top;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid black;
	background:lightgrey;
	mso-pattern:lightgrey none;
	white-space:normal;}
.xl9330411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:general;
	vertical-align:top;
	background:lightgrey;
	mso-pattern:lightgrey none;
	white-space:normal;}
.xl9430411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid black;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:.5pt solid black;
	background:whitesmoke;
	mso-pattern:whitesmoke none;
	white-space:normal;}
.xl9530411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:general;
	vertical-align:top;
	border-top:.5pt solid black;
	border-right:none;
	border-bottom:.5pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl9630411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:general;
	vertical-align:top;
	border-top:.5pt solid black;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid black;
	background:lightgrey;
	mso-pattern:lightgrey none;
	white-space:normal;}
.xl9730411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:general;
	vertical-align:top;
	border-top:.5pt solid black;
	border-right:none;
	border-bottom:none;
	border-left:none;
	background:lightgrey;
	mso-pattern:lightgrey none;
	white-space:normal;}
.xl9830411
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Tahoma;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-fromat:General;
	text-align:general;
	vertical-align:top;
	border-top:.5pt solid black;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
</style>
</head>

<body>
<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following infromation was generated by Microsoft Excel's Publish as Web
Page wizard.-->
<!--If the same item is republished from Excel, all infromation between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<div id="trim_sheet_30411" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=997 style='border-collapse:
 collapse;table-layout:fixed;width:748pt'>
 <col width=39 style='mso-width-source:userset;mso-width-alt:1426;width:29pt'>
 <col width=85 style='mso-width-source:userset;mso-width-alt:3108;width:64pt'>
 <col width=64 span=13 style='width:48pt'>
 <col width=41 style='mso-width-source:userset;mso-width-alt:1499;width:31pt'>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1530411 width=39 style='height:15.0pt;width:29pt'></td>
  <td class=xl1530411 width=85 style='width:64pt'></td>
  <td class=xl1530411 width=64 style='width:48pt'></td>
  <td class=xl1530411 width=64 style='width:48pt'></td>
  <td class=xl1530411 width=64 style='width:48pt'></td>
  <td class=xl1530411 width=64 style='width:48pt'></td>
  <td class=xl1530411 width=64 style='width:48pt'></td>
  <td class=xl1530411 width=64 style='width:48pt'></td>
  <td class=xl1530411 width=64 style='width:48pt'></td>
  <td class=xl1530411 width=64 style='width:48pt'></td>
  <td class=xl1530411 width=64 style='width:48pt'></td>
  <td class=xl1530411 width=64 style='width:48pt'></td>
  <td class=xl1530411 width=64 style='width:48pt'></td>
  <td class=xl1530411 width=64 style='width:48pt'></td>
  <td class=xl1530411 width=64 style='width:48pt'></td>
  <td class=xl1530411 width=41 style='width:31pt'></td>
 </tr>
 <tr height=31 style='mso-height-source:userset;height:23.25pt'>
  <td height=31 class=xl6330411 style='height:23.25pt'></td>
  <td colspan=14 class=xl8630411 dir=LTR width=917 style='width:688pt'>Job Wise
  Sewing and Packing Trim Requirement Report - KOGGALA</td>
  <td class=xl8530411></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
 </tr>
  <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
 </tr>
 <?php
 for($ii=0;$ii<sizeof($color);$ii++)
 {
		
		$size_code=array();
		$size_code_qty=array();
		unset($size_code);
		unset($size_code_qty);
		$sql="select * from $bai_pro3.packing_summary_input where order_del_no='".$schedule."' and order_col_des='".$color[$ii]."' and input_job_no='".$input_job_no."'";
		//echo $sql."<br>";
		$sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($sql_result))
		{
			$size_code[]=strtoupper($row['size_code']);
			$size_code_qty[]=$row['carton_act_qty'];
		}
		$display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color[$ii],$input_job_no,$link);
	//	echo sizeof($size_code)."--".sizeof($size_code_qty)."<br>";
 ?>
 
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td class=xl7930411 dir=LTR width=85 style='width:64pt'>Style No :</td>
  <td colspan=3 class=xl8330411 dir=LTR width=192 style='border-left:none;width:144pt'><?php echo $style; ?></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td colspan=5 class=xl8730411 dir=LTR width=320 style='width:240pt'>Company
  :- Brandix Group of Companies<span
  style='mso-spacerun:yes'></span></td>
  <td class=xl6330411></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td class=xl7930411 dir=LTR width=85 style='border-top:none;width:64pt'>Schedule
  No :</td>
  <td colspan=3 class=xl8830411 dir=LTR width=192 style='border-left:none;width:144pt'><?php echo $schedule; ?></td>
  <td class=xl7830411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl8130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl8130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl8130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl7830411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl7830411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl6330411></td>
 </tr>
 <tr height=23 style='mso-height-source:userset;height:17.25pt'>
  <td height=23 class=xl6330411 style='height:17.25pt'></td>
  <td class=xl7930411 dir=LTR width=85 style='border-top:none;width:64pt'>Color</td>
  <td colspan=3 class=xl8330411 dir=LTR width=192 style='border-left:none;width:144pt'><?php echo $color[$ii]; ?></td>
  <td class=xl7830411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl8130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl8130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl8130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl7830411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl7830411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl6330411></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td class=xl7930411 dir=LTR width=85 style='border-top:none;width:64pt'>Job No :</td>
  <td colspan=3 class=xl8330411 dir=LTR width=192 style='border-left:none;width:144pt'><?php echo $display_prefix1;?></td>
  <td class=xl7830411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl8130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl8130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl8130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl7830411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl7830411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl6330411></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td class=xl1530411></td>
  <td class=xl1530411></td>
  <td class=xl1530411></td>
  <td class=xl7830411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl7830411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl7130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl7130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl7130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl7130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl7730411></td>
  <td class=xl6330411></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td class=xl8030411 dir=LTR width=85 style='width:64pt'>Size</td>
  <?php
  for($i=0;$i<sizeof($size_code);$i++)
  {
	  ?>
	  <td class=xl8330411 dir=LTR width=64 style='border-left:none;width:48pt' ><?php echo $size_code[$i];?></td>
	<?php
}
?>
  <td class=xl6330411></td>
 </tr>
 <tr height=19 style='mso-height-source:userset;height:14.25pt'>
  <td height=19 class=xl6330411 style='height:14.25pt'></td>
  <td class=xl8030411 dir=LTR width=85 style='border-top:none;width:64pt'>Quantity</td>
 <?php
  for($i=0;$i<sizeof($size_code_qty);$i++)
  {
	  ?>
	  <td class=xl8330411 dir=LTR width=64 style='border-top:none;border-left:none;width:48pt'><?php echo $size_code_qty[$i]; ?></td>
	<?php
 } 
  ?> 
  <td class=xl6330411></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
 </tr>
 <tr height=42 style='height:31.5pt;'>
  <td height=42 class=xl6330411 style='height:31.5pt'></td>
  <td colspan=2 class=xl9430411 dir=LTR width=149 style='width:112pt'>Item Code
  (SKU)</td>
  <td colspan=4 class=xl6830411 dir=LTR width=256 style='width:192pt'>Item
  Description</td>
  <td colspan=2 class=xl6830411 dir=LTR width=128 style='width:96pt'>Colour</td>
  <td class=xl6830411 dir=LTR width=64 style='width:48pt'>Size</td>
  <td class=xl6930411 dir=LTR width=64 style='width:48pt'>Per Piece
  Consumption<span style='mso-spacerun:yes'></span></td>
  <td class=xl7030411 dir=LTR width=64 style='width:48pt'>Wastage %</td>
  <td class=xl6930411 dir=LTR width=64 style='width:48pt'>Req - with Wastage</td>
  <td class=xl6930411 dir=LTR width=64 style='width:48pt'>Req - without<span
  style='mso-spacerun:yes'></span>Wastage</td>
  <td class=xl6430411 dir=LTR width=64 style='width:48pt'>UOM</td>
  <td class=xl6330411></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td colspan=2 class=xl9630411 dir=LTR width=149 style='width:112pt'>Sewing
  Trim</td>
  <td colspan=4 class=xl9830411 dir=LTR width=256 style='width:192pt'>&nbsp;</td>
  <td colspan=2 class=xl7130411 dir=LTR width=128 style='width:96pt'></td>
  <td class=xl7130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl7130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl7130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl7130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl7130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl6630411 dir=LTR width=64 style='width:48pt'>&nbsp;</td>
  <td class=xl6330411></td>
 </tr>
  <?php
  for($j=0;$j<sizeof($size_code);$j++)
  {
	$query = "TFR_BEL_BAI_STYLE_WISE_RM_INDIA_REQUIREMENT '$style', '$schedule', ''";
	$result = odbc_exec($connect, $query);
	while(odbc_fetch_row($result))
	{
		// $sql="select * from $bai_rm_pj1.cwh_to_rmwh_temp where schedule='".$schedule."' and color='".$color[$ii]."' and proc_grp='STRIM' and gmt_size='".$size_code[$j]."'";
		// $sql="select * from bai_rm_pj1.cwh_to_rmwh where schedule='416100' and color='NATBL : NAUTICAL BLUE' and proc_grp='STRIM' and gmt_size='L' limit 1";
		// $sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
		// while($row=mysqli_fetch_array($sql_result))
		// {
		if(odbc_result($result, 7) == "STRIM" AND odbc_result($result, 2)==$plant_m3_wh_code and odbc_result($result, 4)==$color[$ii])
		{
		$material_qty=0;
		$material_qty_wast=0;
		$material_qty=round($size_code_qty[$j]*odbc_result($result, 21),2);
		$material_qty_wast=round($size_code_qty[$j]*odbc_result($result, 24),2);
	?>
 
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td colspan=2 class=xl9130411 dir=LTR width=149 style='width:112pt'><?php echo odbc_result($result, 9); ?></td>
  <td colspan=4 class=xl7230411 dir=LTR width=256 style='width:192pt'><?php echo odbc_result($result, 10) ?></td>
  <td colspan=2 class=xl7230411 dir=LTR width=128 style='width:96pt'><?php odbc_result($result, 11); ?></td>
  <td class=xl7230411 dir=LTR width=64 style='width:48pt'><?php echo odbc_result($result, 12); ?></td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'><?php echo odbc_result($result, 21); ?></td>
  <td class=xl7430411 dir=LTR width=64 style='width:48pt'><?php echo odbc_result($result, 24); ?></td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'><?php echo $material_qty; ?></td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'><?php echo $material_qty_wast; ?></td>
  <td class=xl6530411 dir=LTR width=64 style='width:48pt'><?php echo odbc_result($result, 23); ?></td>
  <td class=xl6330411></td>
 </tr>
	 <?php
	 }
	}
  }	
	 ?>
<!-- <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td colspan=2 class=xl9130411 dir=LTR width=149 style='width:112pt'>LOGOHL17TH4
  002</td>
  <td colspan=4 class=xl7230411 dir=LTR width=256 style='width:192pt'>S/THRED
  SPUN T120 TTF PERMA<span
  style='mso-spacerun:yes'>???????????????????????</span></td>
  <td colspan=2 class=xl7230411 dir=LTR width=128 style='width:96pt'>Black093Q0001<span
  style='mso-spacerun:yes'>???????????????????????????????????????????????????????????????????????????????????????</span></td>
  <td class=xl7230411 dir=LTR width=64 style='width:48pt'><span
  style='mso-spacerun:yes'>????????????????????????????????????????????????????????????????????????????????????????????????????</span></td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>0.00</td>
  <td class=xl7430411 dir=LTR width=64 style='width:48pt'>0</td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>8.01</td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>8.01</td>
  <td class=xl6530411 dir=LTR width=64 style='width:48pt'>CNS</td>
  <td class=xl6330411></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td colspan=2 class=xl9130411 dir=LTR width=149 style='width:112pt'>LOGOHL17TH5
  002</td>
  <td colspan=4 class=xl7230411 dir=LTR width=256 style='width:192pt'>S/THRED
  SPUN T160 TTF PERMA<span
  style='mso-spacerun:yes'>???????????????????????</span></td>
  <td colspan=2 class=xl7230411 dir=LTR width=128 style='width:96pt'>Black093Q0001<span
  style='mso-spacerun:yes'>???????????????????????????????????????????????????????????????????????????????????????</span></td>
  <td class=xl7230411 dir=LTR width=64 style='width:48pt'><span
  style='mso-spacerun:yes'>????????????????????????????????????????????????????????????????????????????????????????????????????</span></td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>0.00</td>
  <td class=xl7430411 dir=LTR width=64 style='width:48pt'>0</td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>3.82</td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>3.82</td>
  <td class=xl6530411 dir=LTR width=64 style='width:48pt'>CNS</td>
  <td class=xl6330411></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td colspan=2 class=xl9130411 dir=LTR width=149 style='width:112pt'>LOGOHL17TH6
  002</td>
  <td colspan=4 class=xl7230411 dir=LTR width=256 style='width:192pt'>S/THRED
  STRC T160 TTF Wild Cat<span
  style='mso-spacerun:yes'>????????????????????</span></td>
  <td colspan=2 class=xl7230411 dir=LTR width=128 style='width:96pt'>Black093Q0001<span
  style='mso-spacerun:yes'>???????????????????????????????????????????????????????????????????????????????????????</span></td>
  <td class=xl7230411 dir=LTR width=64 style='width:48pt'><span
  style='mso-spacerun:yes'>????????????????????????????????????????????????????????????????????????????????????????????????????</span></td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>0.01</td>
  <td class=xl7430411 dir=LTR width=64 style='width:48pt'>0</td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>25.76</td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>25.76</td>
  <td class=xl6530411 dir=LTR width=64 style='width:48pt'>CNS</td>
  <td class=xl6330411></td>
 </tr>
 -->
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td colspan=2 class=xl9230411 dir=LTR width=149 style='width:112pt'>Packing
  Trim</td>
  <td colspan=4 class=xl7130411 dir=LTR width=256 style='width:192pt'></td>
  <td colspan=2 class=xl7130411 dir=LTR width=128 style='width:96pt'></td>
  <td class=xl7130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl7130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl7130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl7130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl7130411 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl6630411 dir=LTR width=64 style='width:48pt'>&nbsp;</td>
  <td class=xl6330411></td>
 </tr>
 <?php
  for($j=0;$j<sizeof($size_code);$j++)
  {
	$query = "TFR_BEL_BAI_STYLE_WISE_RM_INDIA_REQUIREMENT '$style', '', ''";
	$result = odbc_exec($connect, $query);
	while(odbc_fetch_row($result))
	{
		// $sql="select * from $bai_rm_pj1.cwh_to_rmwh_temp where schedule='".$schedule."' and color='".$color[$ii]."' and proc_grp='STRIM' and gmt_size='".$size_code[$j]."'";
		// $sql="select * from bai_rm_pj1.cwh_to_rmwh where schedule='416100' and color='NATBL : NAUTICAL BLUE' and proc_grp='STRIM' and gmt_size='L' limit 1";
		// $sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
		// while($row=mysqli_fetch_array($sql_result))
		// {
		if(odbc_result($result, 7) == "PTRIM" AND odbc_result($result, 2)==$plant_m3_wh_code and odbc_result($result, 4)==$color[$ii])
		{
		$material_qty=0;
		$material_qty_wast=0;
		$material_qty=round($size_code_qty[$j]*odbc_result($result, 21),2);
		$material_qty_wast=round($size_code_qty[$j]*odbc_result($result, 24),2);
	?>
 
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td colspan=2 class=xl9130411 dir=LTR width=149 style='width:112pt'><?php echo odbc_result($result, 9); ?></td>
  <td colspan=4 class=xl7230411 dir=LTR width=256 style='width:192pt'><?php echo odbc_result($result, 10) ?></td>
  <td colspan=2 class=xl7230411 dir=LTR width=128 style='width:96pt'><?php odbc_result($result, 11); ?></td>
  <td class=xl7230411 dir=LTR width=64 style='width:48pt'><?php echo odbc_result($result, 12); ?></td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'><?php echo odbc_result($result, 21); ?></td>
  <td class=xl7430411 dir=LTR width=64 style='width:48pt'><?php echo odbc_result($result, 24); ?></td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'><?php echo $material_qty; ?></td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'><?php echo $material_qty_wast; ?></td>
  <td class=xl6530411 dir=LTR width=64 style='width:48pt'><?php echo odbc_result($result, 23); ?></td>
  <td class=xl6330411></td>
 </tr>
	 <?php
	 }
	}
  }	
	 ?>
 <!--
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td colspan=2 class=xl9130411 dir=LTR width=149 style='width:112pt'>O08795Q7ST2
  021</td>
  <td colspan=4 class=xl7230411 dir=LTR width=256 style='width:192pt'>STICKER
  PAPER BAR CODE-VSD-NEW<span
  style='mso-spacerun:yes'>????????????????????</span></td>
  <td colspan=2 class=xl7230411 dir=LTR width=128 style='width:96pt'>DL382K6<span
  style='mso-spacerun:yes'>?????????????????????????????????????????????????????????????????????????????????????????????</span></td>
  <td class=xl7230411 dir=LTR width=64 style='width:48pt'>S<span
  style='mso-spacerun:yes'>???????????????????????????????????????????????????????????????????????????????????????????????????</span></td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>1.02</td>
  <td class=xl7430411 dir=LTR width=64 style='width:48pt'>2</td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>403.92</td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>396.00</td>
  <td class=xl6530411 dir=LTR width=64 style='width:48pt'>PCS</td>
  <td class=xl6330411></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td colspan=2 class=xl9130411 dir=LTR width=149 style='width:112pt'>O08795Q7ST2
  035</td>
  <td colspan=4 class=xl7230411 dir=LTR width=256 style='width:192pt'>STICKER
  PAPER BAR CODE-VSD-NEW<span
  style='mso-spacerun:yes'>????????????????????</span></td>
  <td colspan=2 class=xl7230411 dir=LTR width=128 style='width:96pt'>DL382K6<span
  style='mso-spacerun:yes'>?????????????????????????????????????????????????????????????????????????????????????????????</span></td>
  <td class=xl7230411 dir=LTR width=64 style='width:48pt'>XS<span
  style='mso-spacerun:yes'>??????????????????????????????????????????????????????????????????????????????????????????????????</span></td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>1.02</td>
  <td class=xl7430411 dir=LTR width=64 style='width:48pt'>2</td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>110.16</td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>108.00</td>
  <td class=xl6530411 dir=LTR width=64 style='width:48pt'>PCS</td>
  <td class=xl6330411></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td colspan=2 class=xl9130411 dir=LTR width=149 style='width:112pt'>O08795Q7TG2
  007</td>
  <td colspan=4 class=xl7230411 dir=LTR width=256 style='width:192pt'>TAG PNTCE
  TKT-VSD-LB2330<span
  style='mso-spacerun:yes'>??????????????????????????</span></td>
  <td colspan=2 class=xl7230411 dir=LTR width=128 style='width:96pt'>DL382K6<span
  style='mso-spacerun:yes'>?????????????????????????????????????????????????????????????????????????????????????????????</span></td>
  <td class=xl7230411 dir=LTR width=64 style='width:48pt'>L<span
  style='mso-spacerun:yes'>???????????????????????????????????????????????????????????????????????????????????????????????????</span></td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>1.02</td>
  <td class=xl7430411 dir=LTR width=64 style='width:48pt'>2</td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>1,432.08</td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>1,404.00</td>
  <td class=xl6530411 dir=LTR width=64 style='width:48pt'>PCS</td>
  <td class=xl6330411></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td colspan=2 class=xl9130411 dir=LTR width=149 style='width:112pt'>O08795Q7TG2
  021</td>
  <td colspan=4 class=xl7230411 dir=LTR width=256 style='width:192pt'>TAG PNTCE
  TKT-VSD-LB2330<span
  style='mso-spacerun:yes'>??????????????????????????</span></td>
  <td colspan=2 class=xl7230411 dir=LTR width=128 style='width:96pt'>DL382K6<span
  style='mso-spacerun:yes'>?????????????????????????????????????????????????????????????????????????????????????????????</span></td>
  <td class=xl7230411 dir=LTR width=64 style='width:48pt'>S<span
  style='mso-spacerun:yes'>???????????????????????????????????????????????????????????????????????????????????????????????????</span></td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>1.02</td>
  <td class=xl7430411 dir=LTR width=64 style='width:48pt'>2</td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>403.92</td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>396.00</td>
  <td class=xl6530411 dir=LTR width=64 style='width:48pt'>PCS</td>
  <td class=xl6330411></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td colspan=2 class=xl9130411 dir=LTR width=149 style='width:112pt'>O08795Q7TG2
  035</td>
  <td colspan=4 class=xl7230411 dir=LTR width=256 style='width:192pt'>TAG PNTCE
  TKT-VSD-LB2330<span
  style='mso-spacerun:yes'>??????????????????????????</span></td>
  <td colspan=2 class=xl7230411 dir=LTR width=128 style='width:96pt'>DL382K6<span
  style='mso-spacerun:yes'>?????????????????????????????????????????????????????????????????????????????????????????????</span></td>
  <td class=xl7230411 dir=LTR width=64 style='width:48pt'>XS<span
  style='mso-spacerun:yes'>??????????????????????????????????????????????????????????????????????????????????????????????????</span></td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>1.02</td>
  <td class=xl7430411 dir=LTR width=64 style='width:48pt'>2</td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>110.16</td>
  <td class=xl7330411 dir=LTR width=64 style='width:48pt'>108.00</td>
  <td class=xl6530411 dir=LTR width=64 style='width:48pt'>PCS</td>
  <td class=xl6330411></td>
 </tr>
  -->
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td colspan=2 class=xl8930411 dir=LTR width=149 style='width:112pt'>&nbsp;</td>
  <td colspan=4 class=xl7530411 dir=LTR width=256 style='width:192pt'>&nbsp;</td>
  <td colspan=2 class=xl7530411 dir=LTR width=128 style='width:96pt'>&nbsp;</td>
  <td class=xl7530411 dir=LTR width=64 style='width:48pt'>&nbsp;</td>
  <td class=xl7630411 dir=LTR width=64 style='width:48pt'>&nbsp;</td>
  <td class=xl7530411 dir=LTR width=64 style='width:48pt'>&nbsp;</td>
  <td class=xl7530411 dir=LTR width=64 style='width:48pt'>&nbsp;</td>
  <td class=xl7530411 dir=LTR width=64 style='width:48pt'>&nbsp;</td>
  <td class=xl6730411 dir=LTR width=64 style='width:48pt'>&nbsp;</td>
  <td class=xl6330411></td>
 </tr>

 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6330411 style='height:15.0pt'></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
  <td class=xl6330411></td>
 </tr>
 <?php
 
 }
 ?>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1530411 style='height:15.0pt'></td>
  <td class=xl1530411></td>
  <td class=xl1530411></td>
  <td class=xl1530411></td>
  <td class=xl1530411></td>
  <td class=xl1530411></td>
  <td class=xl1530411></td>
  <td class=xl1530411></td>
  <td class=xl1530411></td>
  <td class=xl1530411></td>
  <td class=xl1530411></td>
  <td class=xl1530411></td>
  <td class=xl1530411></td>
  <td class=xl1530411></td>
  <td class=xl1530411></td>
  <td class=xl1530411></td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=39 style='width:29pt'></td>
  <td width=85 style='width:64pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=41 style='width:31pt'></td>
 </tr>
 <![endif]>
</table>

</div>


<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
</body>

</html>
