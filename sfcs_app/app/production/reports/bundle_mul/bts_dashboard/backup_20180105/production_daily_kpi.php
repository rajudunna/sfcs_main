
<?php
include("dbconf.php");
include("session_check.php");

//Caching File

if(isset($_GET['snap_ids']))
{
	$cachefile = "bai_bts_ids_snap.html";
	ob_start();
}
else
{
	if(!isset($_GET['filterstyle']))
	{
		header("location: index.php");
	}
	else
	{
		



/*
$today=date("Y-m-d",strtotime("-1 day"));


$sql="SELECT DISTINCT bac_date FROM bai_pro.bai_log_buf WHERE bac_date<\"".date("Y-m-d")."\" ORDER BY bac_date DESC LIMIT 1";
mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
while($sql_row=mysql_fetch_array($sql_result))
{
	$today=$sql_row['bac_date'];
}
*/

/*
echo "<span id=\"msg\"><center><br/><br/><br/><h1><font color=\"red\">Please wait while preparing report...</font></h1></center></span>";
	
	ob_end_flush();
	flush();
	usleep(10);
*/	
?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 15">
<link rel=File-List href="dashboar_layout_files/filelist.xml">
<style id="dashboar_layout_27816_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl6327816
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
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6427816
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
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6527816
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
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6627816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#FFE699;
	mso-pattern:black none;
	white-space:nowrap;}
.xl6727816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#BDD7EE;
	mso-pattern:black none;
	white-space:nowrap;}
.xl6827816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#FFE699;
	mso-pattern:black none;
	white-space:nowrap;}
.xl6927816
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
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	background:#731400;
	mso-pattern:black none;
	white-space:nowrap;}
.xl7027816
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
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	background:#731400;
	mso-pattern:black none;
	white-space:nowrap;}
.xl7127816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	background:#731400;
	mso-pattern:black none;
	white-space:nowrap;}
.xl7227816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#FFF2CC;
	mso-pattern:black none;
	white-space:nowrap;}
.xl7327816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7427816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#E2EFDA;
	mso-pattern:black none;
	white-space:nowrap;}
.xl7527816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#E2EFDA;
	mso-pattern:black none;
	white-space:nowrap;}
.xl7627816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:18.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:0%;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#E2EFDA;
	mso-pattern:black none;
	white-space:nowrap;}
.xl7727816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:18.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:0%;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#E2EFDA;
	mso-pattern:black none;
	white-space:nowrap;}
.xl7827816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:18.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7927816
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
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	background:#FCE4D6;
	mso-pattern:black none;
	white-space:nowrap;}
.xl8027816
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
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	background:#FCE4D6;
	mso-pattern:black none;
	white-space:nowrap;}
.xl8127816
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
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#FCE4D6;
	mso-pattern:black none;
	white-space:nowrap;}
.xl8227816
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
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#FCE4D6;
	mso-pattern:black none;
	white-space:nowrap;}
.xl8327816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:18.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8427816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:18.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8527816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:16.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:0%;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8627816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:16.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8727816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:24.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#FFC000;
	mso-pattern:black none;
	white-space:nowrap;}
.xl8827816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#00B0F0;
	mso-pattern:black none;
	white-space:nowrap;}
.xl8927816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:26.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9027816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:16.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#FFE699;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9127816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:20.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9227816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:20.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9327816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:20.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9427816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:15.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:0%;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9527816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:18.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#00B0F0;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9627816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:white;
	font-size:26.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:1.0pt solid windowtext;
	background:#731400;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9727816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:26.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	background:#FFFF99;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9827816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:26.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;
	background:#FFFF99;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9927816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:26.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	background:#FFFF99;
	mso-pattern:black none;
	white-space:nowrap;}
.xl10027816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	background:#E2EFDA;
	mso-pattern:black none;
	white-space:nowrap;}
.xl10127816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#E2EFDA;
	mso-pattern:black none;
	white-space:nowrap;}
.xl10227816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#E2EFDA;
	mso-pattern:black none;
	white-space:nowrap;}
.xl10327816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#E2EFDA;
	mso-pattern:black none;
	white-space:nowrap;}
.xl10427816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#E2EFDA;
	mso-pattern:black none;
	white-space:nowrap;}
.xl10527816
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#E2EFDA;
	mso-pattern:black none;
	white-space:nowrap;}
.xl10627816
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
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
-->

h2
{
	font-family:Arial;
}
h1{
	font-family:Arial;
}
h3{
	font-family:Arial;
}
</style>

 <script src="js/jquery.min1.7.1.js"></script>
        <script src="js/highcharts.js"></script>
		<script src="js/modules/exporting.js"></script>
	
			
		
</head>


<body>


<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Excel's Publish as Web
Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<div id="dashboar_layout_27816" align=center x:publishsource="Excel">

<?php
$sql="select time_stamp from snap_session_track  where session_id=1";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$lu=$sql_row['time_stamp'];
}
	
/* old version 
$sql="SELECT DISTINCT tbl_orders_style_ref_product_style, SUM(output) AS output,SUM(order_qty) AS order_qty,COUNT(DISTINCT tbl_orders_master_product_schedule) AS schedulecount,order_div
,MIN(runningsince) AS runningsince
 FROM (
SELECT tbl_orders_style_ref_product_style, 
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
AVG(tbl_orders_sizes_master_order_quantity) AS order_qty,
tbl_orders_master_product_schedule,
MIN(DATE(bundle_transactions_date_time)) AS runningsince, order_div
FROM $view_set_snap_1_tbl WHERE tbl_orders_style_ref_product_style IS NOT NULL GROUP BY order_id
) AS tmp where trim(both from tbl_orders_style_ref_product_style) not in ('Y74686S5','Y73938S5','Y73877S5') GROUP BY tbl_orders_style_ref_product_style order by order_div";
*/

/* version 1.1 */
/*WHERE tbl_orders_style_ref_product_style IS NOT NULL */

if(isset($_GET['filterstyle']))
{
	
	
$sql="SELECT * FROM (
SELECT *, SUM(cpk_qty) AS cpk_qty_new, (output-SUM(cpk_qty)) AS cpkbalance, (order_qty-output) AS prodbalance  FROM (
SELECT DISTINCT tbl_orders_style_ref_product_style, SUM(output) AS output,SUM(order_qty) AS order_qty,COUNT(DISTINCT tbl_orders_master_product_schedule) AS schedulecount,order_div
,MIN(runningsince) AS runningsince
 FROM (
SELECT tbl_orders_style_ref_product_style, 
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
AVG(tbl_orders_sizes_master_order_quantity) AS order_qty,
tbl_orders_master_product_schedule,
MIN(DATE(bundle_transactions_date_time)) AS runningsince, order_div
FROM $view_set_snap_1_tbl where TRIM(BOTH FROM tbl_orders_style_ref_product_style)='".$_GET['filterstyle']."' GROUP BY order_id
) AS tmp GROUP BY tbl_orders_style_ref_product_style
) AS tmp2
LEFT JOIN $view_set_4_snap ON tbl_orders_style_ref_product_style=style 

 GROUP BY tbl_orders_style_ref_product_style ORDER BY order_div
) AS tmp3  WHERE TRIM(BOTH FROM tbl_orders_style_ref_product_style)='".$_GET['filterstyle']."' ORDER BY cpkbalance DESC";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

echo "<center><h1>Bundle Tracking System Dashboard</h1>";
$sch=echo_title("bai_pro3.bai_orders_db","count(distinct order_del_no)","zfeature not in ('TC') and order_style_no",$_GET['filterstyle'],$link);
$sch_con=echo_title("bai_pro3.bai_orders_db_confirm","count(distinct order_del_no)","zfeature not in ('TC') and order_style_no",$_GET['filterstyle'],$link);
//echo $sch."--".$sch_con."<br>";
if($sch>$sch_con)
{
	$schedules=$sch;
}
else
{
	$schedules=$sch_con;
}
//echo $schedules."--<br>";
$sql1="select order_tid from bai_pro3.bai_orders_db where order_tid like '%".$_GET['filterstyle']."%' and zfeature not in ('TC') group by order_tid";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$schedule_order=0;
while($row1=mysqli_fetch_array($sql_result1))
{
	$sql2="select * from bai_pro3.bai_orders_db_confirm where order_tid='".$row1['order_tid']."'";
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result2)>0)
	{
		$schedule_order+=echo_title("bai_pro3.bai_orders_db_confirm","sum(order_s_s06+order_s_s08+order_s_s10+order_s_s12+order_s_s14+order_s_s16+order_s_s18+order_s_s20+order_s_s22+order_s_s24+order_s_s26+order_s_s28+order_s_s30)","order_tid",$row1['order_tid'],$link);
	}
	else
	{
		$schedule_order+=echo_title("bai_pro3.bai_orders_db","sum(order_s_s06+order_s_s08+order_s_s10+order_s_s12+order_s_s14+order_s_s16+order_s_s18+order_s_s20+order_s_s22+order_s_s24+order_s_s26+order_s_s28+order_s_s30)","order_tid",$row1['order_tid'],$link);

	}
}

}
else
{
	
$sql="SELECT * FROM (
SELECT *, SUM(cpk_qty) AS cpk_qty_new, (output-SUM(cpk_qty)) AS cpkbalance, (order_qty-output) AS prodbalance  FROM (
SELECT DISTINCT tbl_orders_style_ref_product_style, SUM(output) AS output,SUM(order_qty) AS order_qty,COUNT(DISTINCT tbl_orders_master_product_schedule) AS schedulecount,order_div
,MIN(runningsince) AS runningsince
 FROM (
SELECT tbl_orders_style_ref_product_style, 
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
AVG(tbl_orders_sizes_master_order_quantity) AS order_qty,
tbl_orders_master_product_schedule,
MIN(DATE(bundle_transactions_date_time)) AS runningsince, order_div
FROM $view_set_snap_1_tbl where TRIM(BOTH FROM tbl_orders_style_ref_product_style) NOT IN ('Y74686S5','Y73938S5','Y73877S5','Y76246D5','Y76244D5','Y76194D5','Y75919D5','Y79718D5','Y76655D5','Y76014D5','Y76195D5','Y27238D5','Y74027S5','Y74029S5','Y76193D5','Y76991D5','Y76192D5','Y76885D5','Y74026S5') GROUP BY order_id
) AS tmp GROUP BY tbl_orders_style_ref_product_style
) AS tmp2
LEFT JOIN $view_set_4_snap ON tbl_orders_style_ref_product_style=style 

 GROUP BY tbl_orders_style_ref_product_style ORDER BY order_div
) AS tmp3  WHERE TRIM(BOTH FROM tbl_orders_style_ref_product_style) NOT IN ('Y74686S5','Y73938S5','Y73877S5','Y76246D5','Y76244D5','Y76194D5','Y75919D5','Y79718D5','Y76655D5','Y76014D5','Y76195D5','Y27238D5','Y74027S5','Y74029S5','Y76193D5','Y76991D5','Y76192D5','Y76885D5','Y74026S5') AND (prodbalance>0 OR cpkbalance>0)  ORDER BY cpkbalance DESC";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

echo "<center><h1>Bundle Tracking System Dashboard</h1><h3>Total Running Styles: ".mysqli_num_rows($sql_result)."<br/><font color=\"red\">Last Updated on : $lu</font><br/><span style=\"cursor: pointer; cursor: hand; color:blue;\" onclick=\"Popup=window.open('master_performance_report.php','Popup','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">Day wise Performance Reports</span></h3></center>";
}

if(in_array(date("H"),array(15,23,07)))
{
	echo "<span id=\"msg\"><center><br/><br/><br/><h3><font color=\"blue\">We are currently taking database backups. You may experience slow performance while generating reports...</font></h3></center></span>";
}

echo "<span id=\"msg\"><center><br/><br/><br/><h2><font color=\"red\">Please wait while preparing report...</font></h2></center></span>";
	
	ob_end_flush();
	flush();
	usleep(10);
	
while($sql_row=mysqli_fetch_array($sql_result))
{
	$style=$sql_row['tbl_orders_style_ref_product_style'];
	$style_ach=round(($sql_row['output']/$sql_row['order_qty'])*100,1);
	$running_since=$sql_row['runningsince'];
	$number_of_schedules=$sql_row['schedulecount'];
	$order_div=$sql_row['order_div'];
	
	
	//Miniorder Level Details 
	
	
	$mini_ord_number=array();
	$mini_ord_ach=array();
	$mini_ord_running_since=array();
	$sql="SELECT * FROM (
	SELECT  DISTINCT tbl_miniorder_data_mini_order_num,SUM(IF(tbl_orders_ops_ref_operation_code='INI',tbl_miniorder_data_quantity,0)) AS mini_order_qty,
	SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
	SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
	ROUND((SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) /SUM(IF(tbl_orders_ops_ref_operation_code='INI',tbl_miniorder_data_quantity,0)))*100,2)  AS achiv,
	MIN(IF(tbl_orders_ops_ref_operation_code='LNI',DATE(bundle_transactions_date_time),NOW())) AS runningsince,
	SUM(bundle_transactions_20_repeat_rejection_quantity) AS rejected
	FROM $view_set_snap_1_tbl WHERE  tbl_orders_style_ref_product_style='$style' GROUP BY tbl_miniorder_data_mini_order_num
	) AS tmp WHERE (output+rejected)<>mini_order_qty AND (output+rejected)<linein   ORDER BY achiv DESC";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$mini_ord_number[]=$sql_row2['tbl_miniorder_data_mini_order_num'];
		$mini_ord_ach[]=$sql_row2['achiv'];
		$mini_ord_running_since[]=floor((strtotime(date("Y-m-d"))-strtotime($sql_row2['runningsince']))/(60*60*24));
	}
	$numberof_mini_wip=mysqli_num_rows($sql_result2);
	
	if($numberof_mini_wip<4)
	{
		for($i=1;$i<=(4-$numberof_mini_wip);$i++)
		{
			$mini_ord_number[]="";
			$mini_ord_ach[]="";
			$mini_ord_running_since[]="";
		}
	}
	
	/* Scheudle/mim/bundle WIP Details */
	/* old version
	$sql="SELECT COUNT(*) AS totsch, SUM(IF((output)<(order_qty),1,0)) AS wip, SUM(IF((output)>=(order_qty),1,0)) AS completed, COUNT(*)-(SUM(IF((output)>=(order_qty),1,0))) AS balance
	,SUM(order_qty) AS order_qty,SUM(output) AS output,SUM(bundling) AS bundling,SUM(bundleout) AS bundleout,SUM(linein) AS linein,SUM(miniorderbundle) AS miniorderbundle
	 FROM
	(
	SELECT tbl_orders_master_product_schedule,SUM(order_qty) AS order_qty,SUM(output) AS output,SUM(bundling) AS bundling,SUM(bundleout) AS bundleout,SUM(linein) AS linein,SUM(miniorderbundle) AS miniorderbundle

	FROM 
	(
	SELECT 
	tbl_orders_master_product_schedule,
	AVG(tbl_orders_sizes_master_order_quantity) AS order_qty,
	SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
	SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
	SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
	SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
	SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle

	FROM $view_set_snap_1_tbl WHERE  tbl_orders_style_ref_product_style='$style' 

	GROUP BY order_id
	) AS tmp GROUP BY tbl_orders_master_product_schedule
	) AS tmp2";
	*/
	/* New version to consider cpk qtys */
	$sql="SELECT COUNT(*) AS totsch, SUM(IF((output)<(order_qty) OR cpk_qty_new<order_qty,1,0)) AS wip, SUM(IF((output)>=(order_qty) AND cpk_qty_new>=order_qty,1,0)) AS completed, COUNT(*)-(SUM(IF((output)>=(order_qty)  and cpk_qty_new>=order_qty,1,0))) AS balance
	,SUM(order_qty) AS order_qty,SUM(output) AS output,SUM(bundling) AS bundling,SUM(bundleout) AS bundleout,SUM(linein) AS linein,SUM(miniorderbundle) AS miniorderbundle, SUM(cpk_qty_new) AS cpk_qty_new
	 FROM (
SELECT *, SUM(cpk_qty) AS cpk_qty_new FROM (
SELECT tbl_orders_master_product_schedule,SUM(order_qty) AS order_qty,SUM(output) AS output,SUM(bundling) AS bundling,SUM(bundleout) AS bundleout,SUM(linein) AS linein,SUM(miniorderbundle) AS miniorderbundle,SUM(rejected) AS rejected
,MIN(first_out_date) AS first_out_date,order_date
FROM 
(
SELECT 
tbl_orders_master_product_schedule,MIN(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_date_time,bundle_transactions_date_time)) AS first_out_date,
AVG(tbl_orders_sizes_master_order_quantity) AS order_qty,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle,order_date,
SUM(bundle_transactions_20_repeat_rejection_quantity) AS rejected

FROM $view_set_snap_1_tbl WHERE  tbl_orders_style_ref_product_style='$style' 

GROUP BY order_id
) AS tmp  GROUP BY tbl_orders_master_product_schedule
)AS tmp2 LEFT JOIN `$view_set_4_snap` ON tbl_orders_master_product_schedule=SCHEDULE  GROUP BY tbl_orders_master_product_schedule  
) AS tmp3";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$totsch=$sql_row2['totsch'];	$wip=$sql_row2['wip'];	$completed=$sql_row2['completed'];	$balance=$sql_row2['balance'];	$order_qty=(int)$sql_row2['order_qty'];	$output_sty=$sql_row2['output'];	$bundling=$sql_row2['bundling'];	$bundleout=$sql_row2['bundleout'];	$linein=$sql_row2['linein'];	$miniorderbundle=$sql_row2['miniorderbundle'];$plan_qty=$sql_row2['miniorderbundle'];

	}
	
	$wip_qty=($linein-$output_sty);
	$balanceout=($order_qty-$output_sty);
	$wip_per=round((($linein-$output_sty)/$order_qty)*100,1);
	$complete_per=round(($output_sty/$order_qty)*100,1);
	$balance_per=round((($order_qty-$output_sty)/$order_qty)*100,1);
	
	//miniorder
	/* old version
	$sql="SELECT COUNT(*) AS totmini, SUM(IF((output+rejected)<(linein) AND output<>miniorderbundle,1,0)) AS wipmini, SUM(IF((output+rejected)>=(miniorderbundle),1,0)) AS completedmini, COUNT(*)-(SUM(IF((output+rejected)>=(miniorderbundle),1,0))) AS balancemini FROM
	(
	SELECT tbl_orders_master_product_schedule,SUM(order_qty) AS order_qty,SUM(output) AS output,SUM(bundling) AS bundling,SUM(bundleout) AS bundleout,SUM(linein) AS linein,SUM(miniorderbundle) AS miniorderbundle, SUM(rejected) AS rejected

	FROM 
	(
	SELECT 
	tbl_orders_master_product_schedule,tbl_miniorder_data_mini_order_num,
	AVG(tbl_orders_sizes_master_order_quantity) AS order_qty,
	SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
	SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
	SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
	SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
	SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle,
SUM(bundle_transactions_20_repeat_rejection_quantity) AS rejected
	FROM $view_set_snap_1_tbl WHERE  tbl_orders_style_ref_product_style='$style' 

	GROUP BY tbl_orders_master_product_schedule,tbl_miniorder_data_mini_order_num
	) AS tmp GROUP BY tbl_orders_master_product_schedule,tbl_miniorder_data_mini_order_num
	) AS tmp2";
		
	*/	
	/*  new version 1.1 */
	$sql="SELECT SUM(totmini) AS totmini,SUM(wipmini) AS wipmini, SUM(completedmini) AS completedmini,SUM(balancemini) AS balancemini FROM 
(
SELECT  *,1 AS totmini, (IF((output+rejected)=0 and linein>0,1,0)) AS wipmini, (IF((output+rejected)>=(miniorderbundle),1,0)) AS completedmini, 1-((IF((output+rejected)>=(miniorderbundle),1,0))) AS balancemini FROM	
	
	(
	SELECT tbl_orders_master_product_schedule,SUM(order_qty) AS order_qty,SUM(output) AS output,SUM(bundling) AS bundling,SUM(bundleout) AS bundleout,SUM(linein) AS linein,SUM(miniorderbundle) AS miniorderbundle, SUM(rejected) AS rejected

	FROM 
	(
	SELECT 
	tbl_orders_master_product_schedule,tbl_miniorder_data_mini_order_num,
	AVG(tbl_orders_sizes_master_order_quantity) AS order_qty,
	SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
	SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
	SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
	SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
	SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle,
SUM(bundle_transactions_20_repeat_rejection_quantity) AS rejected
	FROM $view_set_snap_1_tbl WHERE  tbl_orders_style_ref_product_style='$style' 

	GROUP BY tbl_orders_master_product_schedule,tbl_miniorder_data_mini_order_num
	) AS tmp GROUP BY tbl_orders_master_product_schedule,tbl_miniorder_data_mini_order_num
	) AS tmp2 
) AS tmp3";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$totmini=$sql_row2['totmini'];	$wipmini=$sql_row2['wipmini'];	$completedmini=$sql_row2['completedmini'];	$balancemini=$sql_row2['balancemini'];

	}
	
	//bundles
	
	$sql="SELECT COUNT(*) AS totbundles, SUM(IF((output+rejected)=0 and linein>0,1,0)) AS wipbundles, SUM(IF((output+rejected)>=(miniorderbundle),1,0)) AS completedbundles, COUNT(*)-(SUM(IF((output+rejected)>=(miniorderbundle),1,0))) AS balancebundles FROM
	(
	SELECT tbl_orders_master_product_schedule,SUM(order_qty) AS order_qty,SUM(output) AS output,SUM(bundling) AS bundling,SUM(bundleout) AS bundleout,SUM(linein) AS linein,SUM(miniorderbundle) AS miniorderbundle, sum(rejected) as rejected

	FROM 
	(
	SELECT 
	tbl_orders_master_product_schedule,tbl_miniorder_data_mini_order_num,tbl_miniorder_data_bundle_number,
	AVG(tbl_orders_sizes_master_order_quantity) AS order_qty,
	SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
	SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
	SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
	SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
	SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle,
SUM(bundle_transactions_20_repeat_rejection_quantity) AS rejected
	FROM $view_set_snap_1_tbl WHERE  tbl_orders_style_ref_product_style='$style' 

	GROUP BY tbl_orders_master_product_schedule,tbl_miniorder_data_mini_order_num,tbl_miniorder_data_bundle_number
	) AS tmp GROUP BY tbl_orders_master_product_schedule,tbl_miniorder_data_mini_order_num,tbl_miniorder_data_bundle_number

	) AS tmp2";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$totbundles=$sql_row2['totbundles'];	$wipbundles=$sql_row2['wipbundles'];	$completedbundles=$sql_row2['completedbundles'];	$balancebundles=$sql_row2['balancebundles'];


	}
	
	//style performance
	
	$sql="SELECT 
DATE(bundle_transactions_date_time) AS daten,LEFT(bundle_transactions_date_time,7) AS monthn,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO' AND tbl_shifts_master_shift_name='A',bundle_transactions_20_repeat_quantity,0)) AS a_output,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO' AND tbl_shifts_master_shift_name='B',bundle_transactions_20_repeat_quantity,0)) AS b_output,
ROUND(SUM(sah),0) AS sah,
SUM(bundle_transactions_20_repeat_rejection_quantity) AS rejected
FROM $view_set_snap_1_tbl WHERE  tbl_orders_style_ref_product_style='$style' 

GROUP BY DATE(bundle_transactions_date_time) ORDER BY DATE(bundle_transactions_date_time) DESC
";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	
	$daten=array();	$monthn=array();	$output=array();	$bundling=array();	$bundleout=array();	$linein=array();	$miniorderbundle=array();	$a_output=array();	$b_output=array();	$sah=array(); $rejected_bts=array();
$daten_mtd=array();	$monthn_mtd=array();	$output_mtd=array();	$bundling_mtd=array();	$bundleout_mtd=array();	$linein_mtd=array();	$miniorderbundle_mtd=array();	$a_output_mtd=array();	$b_output_mtd=array();	$sah_mtd=array(); $rejected_bts_mtd=array();



	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		
		$daten[]=$sql_row2['daten'];	$monthn[]=$sql_row2['monthn'];	$output[]=$sql_row2['output'];	$bundling[]=$sql_row2['bundling'];	$bundleout[]=$sql_row2['bundleout'];	$linein[]=$sql_row2['linein'];	$miniorderbundle[]=$sql_row2['miniorderbundle'];	$a_output[]=$sql_row2['a_output'];	$b_output[]=$sql_row2['b_output'];	$sah[]=$sql_row2['sah']; $rejected_bts[]=$sql_row2['rejected'];
		
		if($sql_row2['monthn']==date("Y-m"))
		{
			$daten_mtd[]=$sql_row2['daten'];	$monthn_mtd[]=$sql_row2['monthn'];	$output_mtd[]=$sql_row2['output'];	$bundling_mtd[]=$sql_row2['bundling'];	$bundleout_mtd[]=$sql_row2['bundleout'];	$linein_mtd[]=$sql_row2['linein'];	$miniorderbundle_mtd[]=$sql_row2['miniorderbundle'];	$a_output_mtd[]=$sql_row2['a_output'];	$b_output_mtd[]=$sql_row2['b_output'];	$sah_mtd[]=$sql_row2['sah']; $rejected_bts_mtd[]=$sql_row2['rejected'];
		}


	}
	
	if(mysqli_num_rows($sql_result2)<5)
	{
		for($i=1;$i<=(5-mysqli_num_rows($sql_result2));$i++)
		{
			$daten[]=0;	$monthn[]=0;	$output[]=0;	$bundling[]=0;	$bundleout[]=0;	$linein[]=0;	$miniorderbundle[]=0;	$a_output[]=0;	$b_output[]=0;	$sah[]=0; $rejected_bts[]=0;

		}
	}
	
	//rejectison
	
	$sql="SELECT log_date,qms_style,qms_schedule,sum(rejected_qty) as rejected_qty,LEFT(log_date,7) AS monthn FROM $view_set_5_snap WHERE qms_style='$style' group by log_date  ORDER BY log_date DESC
";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	
	$log_date=array();	$qms_style=array();	$qms_schedule=array();	$rejected_qty=array();	$monthn=array();
$log_date_mtd=array();	$qms_style_mtd=array();	$qms_schedule_mtd=array();	$rejected_qty_mtd=array();	$monthn_mtd=array();



	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		
		$log_date[]=$sql_row2['log_date'];	$qms_style[]=$sql_row2['qms_style'];	$qms_schedule[]=$sql_row2['qms_schedule'];	$rejected_qty[]=$sql_row2['rejected_qty'];	$monthn[]=$sql_row2['monthn'];

		
		if($sql_row2['monthn']==date("Y-m"))
		{
			$log_date_mtd[]=$sql_row2['log_date'];	$qms_style_mtd[]=$sql_row2['qms_style'];	$qms_schedule_mtd[]=$sql_row2['qms_schedule'];	$rejected_qty_mtd[]=$sql_row2['rejected_qty'];	$monthn_mtd[]=$sql_row2['monthn'];

		}


	}
	
	if(mysqli_num_rows($sql_result2)<5)
	{
		for($i=1;$i<=(5-mysqli_num_rows($sql_result2));$i++)
		{
			$log_date[]=0;	$qms_style[]=0;	$qms_schedule[]=0;	$rejected_qty[]=0;	$monthn[]=0;


		}
	}
	
	
	
	//cpk
	
	$sql="SELECT DATE,style,SCHEDULE,sum(cpk_qty) as cpk_qty,LEFT(DATE,7) AS monthn FROM $view_set_4_snap WHERE style='$style' group by date ORDER BY DATE DESC
";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	
	$date=array();	$style_cpk=array();	$schedule=array();	$cpk_qty=array();	$monthn=array();
$date_mtd=array();	$style_cpk_mtd=array();	$schedule_mtd=array();	$cpk_qty_mtd=array();	$monthn_mtd=array();




	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		
		$date[]=$sql_row2['date'];	$style_cpk[]=$sql_row2['style'];	$schedule[]=$sql_row2['schedule'];	$cpk_qty[]=$sql_row2['cpk_qty'];	$monthn[]=$sql_row2['monthn'];


		
		if($sql_row2['monthn']==date("Y-m"))
		{
			$date_mtd[]=$sql_row2['date'];	$style_cpk_mtd[]=$sql_row2['style'];	$schedule_mtd[]=$sql_row2['schedule'];	$cpk_qty_mtd[]=$sql_row2['cpk_qty'];	$monthn_mtd[]=$sql_row2['monthn'];


		}


	}
	
	if(mysqli_num_rows($sql_result2)<5)
	{
		for($i=1;$i<=(5-mysqli_num_rows($sql_result2));$i++)
		{
			$date[]=0;	$style_cpk[]=0;	$schedule[]=0;	$cpk_qty[]=0;	$monthn[]=0;

		}
	}
	
	
	
?>	


<table border=0 cellpadding=0 cellspacing=0 width=1280 class=xl6327816
 style='border-collapse:collapse;table-layout:fixed;width:960pt'>
 <col class=xl6327816 width=64 span=20 style='width:48pt'>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6327816 width=64 style='height:15.75pt;width:48pt'><a
  name="RANGE!A1:T50"></a></td>
  <td class=xl6327816 width=64 style='width:48pt'></td>
  <td class=xl6327816 width=64 style='width:48pt'></td>
  <td class=xl6327816 width=64 style='width:48pt'></td>
  <td class=xl6327816 width=64 style='width:48pt'></td>
  <td class=xl6327816 width=64 style='width:48pt'></td>
  <td class=xl6327816 width=64 style='width:48pt'></td>
  <td class=xl6327816 width=64 style='width:48pt'></td>
  <td class=xl6327816 width=64 style='width:48pt'></td>
  <td class=xl6327816 width=64 style='width:48pt'></td>
  <td class=xl6327816 width=64 style='width:48pt'></td>
  <td class=xl6327816 width=64 style='width:48pt'></td>
  <td class=xl6327816 width=64 style='width:48pt'></td>
  <td class=xl6327816 width=64 style='width:48pt'></td>
  <td class=xl6327816 width=64 style='width:48pt'></td>
  <td class=xl6327816 width=64 style='width:48pt'></td>
  <td class=xl6327816 width=64 style='width:48pt'></td>
  <td class=xl6327816 width=64 style='width:48pt'></td>
  <td class=xl6327816 width=64 style='width:48pt'></td>
  <td class=xl6327816 width=64 style='width:48pt'></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td colspan=3 rowspan=2 class=xl9627816 style='border-bottom:1.0pt solid black'><span style="cursor: pointer; cursor: hand;" onclick="Popup=window.open('popup.php?style=<?=$style; ?>','Popup','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;"><?=$style; ?></span></td>
  <td class=xl6927816>&nbsp;</td>
  <td class=xl6927816>&nbsp;</td>
  <td class=xl6927816>&nbsp;</td>
  <td class=xl6927816>&nbsp;</td>
  <td class=xl6927816>&nbsp;</td>
  <td class=xl6927816>&nbsp;</td>
  <td colspan=3 rowspan=2 class=xl7427816 style='border-bottom:1.0pt solid black'>PROD.
  COMP %</td>
  <td rowspan=2 class=xl7627816 style='border-bottom:1.0pt solid black'><?=$style_ach; ?>%</td>
  <td colspan=5 class=xl10327816 style='border-right:1.0pt solid black'>Running
  Since :<?= $running_since; ?></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl6327816 style='height:15.75pt'></td>
  <td class=xl7027816>&nbsp;</td>
  <td class=xl7027816>&nbsp;</td>
  <td class=xl7027816>&nbsp;</td>
  <td class=xl7027816>&nbsp;</td>
  <td class=xl7027816>&nbsp;</td>
  <td class=xl7127816>&nbsp;</td>
  <td colspan=5 class=xl10027816 style='border-right:1.0pt solid black'>Buyer:<?=$order_div;?></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6827816>MOS WIP</td>
  <td class=xl6327816></td>
  <td class=xl6627816>MO #</td>
  <td class=xl6627816 style='border-left:none'>%</td>
  <td class=xl6627816 style='border-left:none'>Age</td>
  <td class=xl6327816></td>
  <td class=xl6627816>MO #</td>
  <td class=xl6627816 style='border-left:none'>%</td>
  <td class=xl6627816 style='border-left:none'>Age</td>
  <td class=xl6327816></td>
  <td class=xl6627816>MO #</td>
  <td class=xl6627816 style='border-left:none'>%</td>
  <td class=xl6627816 style='border-left:none'>Age</td>
  <td class=xl6327816></td>
  <td class=xl6627816>MO #</td>
  <td class=xl6627816 style='border-left:none'>%</td>
  <td class=xl6627816 style='border-left:none'>Age</td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td rowspan=2 class=xl9127816 style='border-top:none'><?=$numberof_mini_wip ?></td>
  <td class=xl6327816></td>
  <td rowspan=2 class=xl9227816 style='border-bottom:.5pt solid black;
  border-top:none'><?=$mini_ord_number[0];?></td>
  <td rowspan=2 class=xl9427816 style='border-bottom:.5pt solid black;
  border-top:none'><?=$mini_ord_ach[0];?>%</td>
  <td rowspan=2 class=xl9227816 style='border-bottom:.5pt solid black;
  border-top:none'><?=$mini_ord_running_since[0];?></td>
  <td class=xl6327816></td>
  <td rowspan=2 class=xl9227816 style='border-bottom:.5pt solid black;
  border-top:none'><?=$mini_ord_number[1];?></td>
  <td rowspan=2 class=xl9427816 style='border-bottom:.5pt solid black;
  border-top:none'><?=$mini_ord_ach[1];?>%</td>
  <td rowspan=2 class=xl9227816 style='border-bottom:.5pt solid black;
  border-top:none'><?=$mini_ord_running_since[1];?></td>
  <td class=xl6327816></td>
  <td rowspan=2 class=xl9227816 style='border-bottom:.5pt solid black;
  border-top:none'><?=$mini_ord_number[2];?></td>
  <td rowspan=2 class=xl9427816 style='border-bottom:.5pt solid black;
  border-top:none'><?=$mini_ord_ach[2];?>%</td>
  <td rowspan=2 class=xl9227816 style='border-bottom:.5pt solid black;
  border-top:none'><?=$mini_ord_running_since[2];?></td>
  <td class=xl6327816></td>
  <td rowspan=2 class=xl9227816 style='border-bottom:.5pt solid black;
  border-top:none'><?=$mini_ord_number[3];?></td>
  <td rowspan=2 class=xl9427816 style='border-bottom:.5pt solid black;
  border-top:none'><?=$mini_ord_ach[3];?>%</td>
  <td rowspan=2 class=xl9227816 style='border-bottom:.5pt solid black;
  border-top:none'><?=$mini_ord_running_since[3];?></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td rowspan=2 class=xl9027816>ACH%</td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl9027816>Schedules</td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl9027816>Mini-Orders</td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl9027816>Bundles</td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl9027816>Achievement</td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td colspan=3 rowspan=2 class=xl9527816>Orders</td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl8927816><?=$schedules; ?></td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl8927816>-</td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl8927816>-</td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl8927816><?=$schedule_order;?></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
  </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td colspan=2 rowspan=2 class=xl9527816>Planned</td>
  <td rowspan=2 class=xl8527816><?php echo round($totsch/$schedules*100,2)?>%</td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl8927816><?=$totsch; ?></td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl8927816><?=$totmini;?></td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl8927816><?=$totbundles;?></td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl8927816><?=$plan_qty;?></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td colspan=2 rowspan=2 class=xl9527816>WIP</td>
  <td rowspan=2 class=xl8527816><?=$wip_per; ?>%</td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl8927816><?=$wip; ?></td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl8927816><?=$wipmini;?></td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl8927816><?=$wipbundles;?></td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl8927816><?=$wip_qty;?></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td colspan=2 rowspan=2 class=xl9527816>Completed</td>
  <td rowspan=2 class=xl8527816><?=$complete_per; ?>%</td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl8927816><?=$completed; ?></td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl8927816><?=$completedmini;?></td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl8927816><?=$completedbundles;?></td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl8927816><?=$output_sty;?></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td colspan=2 rowspan=2 class=xl9527816>Balance</td>
  <td rowspan=2 class=xl8527816><?=$balance_per; ?>%</td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl8927816><?=$balance; ?></td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl8927816><?=$balancemini;?></td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl8927816><?=$balancebundles;?></td>
  <td class=xl6327816></td>
  <td colspan=2 rowspan=2 class=xl8927816><?=$balanceout;?></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7227816>Day</td>
  <td class=xl7227816 style='border-left:none'>BUN</td>
  <td class=xl7227816 style='border-left:none'>BUO</td>
  <td class=xl7227816 style='border-left:none'>SIN</td>
  <td class=xl7227816 style='border-left:none'>SOT</td>
  <td class=xl7227816 style='border-left:none'>Conf.REJ.</td>
  <td class=xl7227816 style='border-left:none'>CPK</td>
  <td class=xl7227816 style='border-left:none'>SAH</td>
  <td class=xl7227816 style='border-left:none'>T- A SOT</td>
  <td class=xl7227816 style='border-left:none'>T - B SOT</td>
  <td class=xl7227816 style='border-left:none'>BTS REJ.</td>
  <td colspan=7 rowspan=10 class=xl10627816>
  
  
  <?php
  echo "<script>
$(function () {
       		container".trim($style)."();
    });
	function container".trim($style)."(){
		
    $('#container1".trim($style)."').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '".trim($style)." Style Performance'
        },
      
        xAxis: {
            categories: [
                'Order',
                'BUN',
                'BUO',
                'SIN',
                'SOT',
                'REJ',
                'CPK',
                'Team-A',
                'Team-B'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Quantity'
            }
        },
       
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            column: {colorByPoint: true}
        },
        series: [{
        	 showInLegend: false,
        		name:'Production',
               data: [".$order_qty.", ".array_sum($bundling).", ".array_sum($bundleout).", ".array_sum($linein).", ".array_sum($output).", ".array_sum($rejected_qty).", ".array_sum($cpk_qty).", ".array_sum($a_output).", ".array_sum($b_output)."]

        }]
    });
}
</script>";
?>  
  
  
  <div class='img' id='container1<?=trim($style);?>' style="width:450px; height:200px;"></div>
  
  
  
  
  </td>
  <td class=xl6327816></td>
 </tr>
 
 <?php
 $day=5;
 for($j=0;$j<5;$j++)
 {
 	
?> 	
 
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'><?=date("d-m-y", strtotime($daten[$j]));?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=$bundling[$j];?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=$bundleout[$j];?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=$linein[$j];?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=$output[$j];?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=$rejected_qty[$j]; ?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=$cpk_qty[$j]; ?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=$sah[$j];?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=$a_output[$j];?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=$b_output[$j];?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=$rejected_bts[$j];?></td>
  <td class=xl6327816></td>
 </tr>
 <?php
 $day--;
 }
 ?>
 <?php
 {
 	
/* <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>4</td>
  <td class=xl6327816></td>
  <td class=xl6427816 style='border-top:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>3</td>
  <td class=xl6427816 style='border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>2</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>1</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr> -->
  <!--<tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>MTD</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>TD Total</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr> */
 }
 ?>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>MTD</td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($bundling_mtd);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($bundleout_mtd);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($linein_mtd);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($output_mtd);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($rejected_qty_mtd); ?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($cpk_qty_mtd); ?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($sah_mtd);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($a_output_mtd);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($b_output_mtd);?></td>
   <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($rejected_bts_mtd);?></td>
  <td class=xl6327816></td>
 </tr>
 
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>TD Total</td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($bundling);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($bundleout);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($linein);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($output);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($rejected_qty); ?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($cpk_qty); ?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($sah);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($a_output);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($b_output);?></td>
   <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($rejected_bts);?></td>
  <td class=xl6327816></td>
 </tr>
 
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>Com. %</td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=round((array_sum($bundling)/$order_qty)*100,2);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=round((array_sum($bundleout)/$order_qty)*100,2);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=round((array_sum($linein)/$order_qty)*100,2);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=round((array_sum($output)/$order_qty)*100,2);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=round((array_sum($rejected_qty)/$order_qty)*100,2); ?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=round((array_sum($cpk_qty)/$order_qty)*100,2); ?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=round((array_sum($a_output)/$order_qty)*100,2);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=round((array_sum($b_output)/$order_qty)*100,2);?></td>
   <td class=xl6427816 style='border-top:none;border-left:none'><?=round((array_sum($rejected_bts)/$order_qty)*100,2); ?></td>
  <td class=xl6327816></td>
 </tr>
 
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>WIP</td>
  <td class=xl6427816 style='border-top:none;border-left:none'></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($bundling)-array_sum($bundleout);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($bundleout)-array_sum($linein);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($linein)-array_sum($output);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($output)-array_sum($cpk_qty); ?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'></td>
  <td class=xl6427816 style='border-top:none;border-left:none'></td>
  <td class=xl6427816 style='border-top:none;border-left:none'></td>
 <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($rejected_qty)-array_sum($rejected_bts); ?></td>
  <td class=xl6327816></td>
 </tr>
 
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td colspan=18 class=xl8827816>Work In Progress</td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>

<?php

//Scheudle Level Details
/* Version 1 $sql="SELECT * FROM (
SELECT tbl_orders_master_product_schedule,SUM(order_qty) AS order_qty,SUM(output) AS output,SUM(bundling) AS bundling,SUM(bundleout) AS bundleout,SUM(linein) AS linein,SUM(miniorderbundle) AS miniorderbundle,sum(rejected) as rejected
,MIN(first_out_date) AS first_out_date,order_date
FROM 
(
SELECT 
tbl_orders_master_product_schedule,MIN(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_date_time,bundle_transactions_date_time)) AS first_out_date,
AVG(tbl_orders_sizes_master_order_quantity) AS order_qty,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle,order_date,
SUM(bundle_transactions_20_repeat_rejection_quantity) AS rejected

FROM $view_set_snap_1_tbl WHERE  tbl_orders_style_ref_product_style='$style' 

GROUP BY order_id
) AS tmp GROUP BY tbl_orders_master_product_schedule
)AS tmp2 WHERE output<order_qty
"; */

/* version 2 to check carton pack qty also */
$sql="SELECT * FROM (
SELECT *, SUM(cpk_qty) AS cpk_qty_new FROM (
SELECT tbl_orders_master_product_schedule,SUM(order_qty) AS order_qty,SUM(output) AS output,SUM(bundling) AS bundling,SUM(bundleout) AS bundleout,SUM(linein) AS linein,SUM(miniorderbundle) AS miniorderbundle,SUM(rejected) AS rejected
,MIN(first_out_date) AS first_out_date,order_date
FROM 
(
SELECT 
tbl_orders_master_product_schedule,MIN(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_date_time,now())) AS first_out_date,
AVG(tbl_orders_sizes_master_order_quantity) AS order_qty,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle,order_date,
SUM(bundle_transactions_20_repeat_rejection_quantity) AS rejected

FROM $view_set_snap_1_tbl WHERE  tbl_orders_style_ref_product_style='$style' 

GROUP BY order_id
) AS tmp  GROUP BY tbl_orders_master_product_schedule
)AS tmp2 LEFT JOIN `$view_set_4_snap` ON tbl_orders_master_product_schedule=SCHEDULE  GROUP BY tbl_orders_master_product_schedule  
) AS tmp3
WHERE (output<order_qty OR cpk_qty_new<order_qty ) 

";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result3=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row3=mysqli_fetch_array($sql_result3))
	{
		
			$tbl_orders_master_product_schedule=$sql_row3['tbl_orders_master_product_schedule'];	$order_qty=$sql_row3['order_qty'];	$output=$sql_row3['output'];	$bundling=$sql_row3['bundling'];	$bundleout=$sql_row3['bundleout'];	$linein=$sql_row3['linein'];	$miniorderbundle=$sql_row3['miniorderbundle'];	$first_out_date=$sql_row3['first_out_date'];
			$order_date=($sql_row3['order_date']>0?$sql_row3['order_date']:""); $rejected=$sql_row3['rejected'];
			
		$sch_swip=$linein-($output+$rejected);
		$sch_swip_per=round(($sch_swip/$order_qty)*100,1);
		$sch_balance=$order_qty-$output;
		$sch_balance_per=round(($sch_balance/$order_qty)*100,1);
		$sch_age=floor((strtotime(date("Y-m-d"))-strtotime($first_out_date))/(60*60*24));
		
		
		//Next Mini Order
		
				$next_mini_order=0;
			$sql="SELECT tbl_miniorder_data_mini_order_num FROM (
		SELECT DISTINCT tbl_miniorder_data_mini_order_num,
		SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle,
		SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
		SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
		SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output FROM $view_set_snap_1_tbl WHERE tbl_orders_master_product_schedule=$tbl_orders_master_product_schedule  GROUP BY tbl_miniorder_data_mini_order_num
		) AS tmp WHERE linein=0 ORDER BY tbl_miniorder_data_mini_order_num LIMIT 1";
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$next_mini_order=$sql_row2['tbl_miniorder_data_mini_order_num'];
			}
			
			
			
			
			 
  //style performance
	
	$sql="SELECT 
DATE(bundle_transactions_date_time) AS daten,LEFT(bundle_transactions_date_time,7) AS monthn,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO' AND tbl_shifts_master_shift_name='A',bundle_transactions_20_repeat_quantity,0)) AS a_output,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO' AND tbl_shifts_master_shift_name='B',bundle_transactions_20_repeat_quantity,0)) AS b_output,
ROUND(SUM(sah),0) AS sah,
SUM(bundle_transactions_20_repeat_rejection_quantity) AS rejected


FROM $view_set_snap_1_tbl WHERE  tbl_orders_style_ref_product_style='$style'  and tbl_orders_master_product_schedule=$tbl_orders_master_product_schedule

GROUP BY DATE(bundle_transactions_date_time) ORDER BY DATE(bundle_transactions_date_time) DESC
";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	
		
	$daten=array();	$monthn=array();	$output=array();	$bundling=array();	$bundleout=array();	$linein=array();	$miniorderbundle=array();	$a_output=array();	$b_output=array();	$sah=array(); $rejected_bts=array();
$daten_mtd=array();	$monthn_mtd=array();	$output_mtd=array();	$bundling_mtd=array();	$bundleout_mtd=array();	$linein_mtd=array();	$miniorderbundle_mtd=array();	$a_output_mtd=array();	$b_output_mtd=array();	$sah_mtd=array(); $rejected_bts_mtd=array();

/* unset($daten);
unset($monthn);
unset($output);
unset($bundling);
unset($bundleout);
unset($linein);
unset($miniorderbundle);
unset($a_output);
unset($b_output);
unset($sah);
unset($daten_mtd);
unset($monthn_mtd);
unset($output_mtd);
unset($bundling_mtd);
unset($bundleout_mtd);
unset($linein_mtd);
unset($miniorderbundle_mtd);
unset($a_output_mtd);
unset($b_output_mtd);
unset($sah_mtd);
*/



	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		
		$daten[]=$sql_row2['daten'];	$monthn[]=$sql_row2['monthn'];	$output[]=$sql_row2['output'];	$bundling[]=$sql_row2['bundling'];	$bundleout[]=$sql_row2['bundleout'];	$linein[]=$sql_row2['linein'];	$miniorderbundle[]=$sql_row2['miniorderbundle'];	$a_output[]=$sql_row2['a_output'];	$b_output[]=$sql_row2['b_output'];	$sah[]=$sql_row2['sah']; $rejected_bts[]=$sql_row2['rejected'];
		
		if($sql_row2['monthn']==date("Y-m"))
		{
			$daten_mtd[]=$sql_row2['daten'];	$monthn_mtd[]=$sql_row2['monthn'];	$output_mtd[]=$sql_row2['output'];	$bundling_mtd[]=$sql_row2['bundling'];	$bundleout_mtd[]=$sql_row2['bundleout'];	$linein_mtd[]=$sql_row2['linein'];	$miniorderbundle_mtd[]=$sql_row2['miniorderbundle'];	$a_output_mtd[]=$sql_row2['a_output'];	$b_output_mtd[]=$sql_row2['b_output'];	$sah_mtd[]=$sql_row2['sah']; $rejected_bts_mtd[]=$sql_row2['rejected'];
		}


	}
	
	if(mysqli_num_rows($sql_result2)<5)
	{
		for($i=1;$i<=(5-mysqli_num_rows($sql_result2));$i++)
		{
			$daten[]=0;	$monthn[]=0;	$output[]=0;	$bundling[]=0;	$bundleout[]=0;	$linein[]=0;	$miniorderbundle[]=0;	$a_output[]=0;	$b_output[]=0;	$sah[]=0; 
			$rejected_bts[]=0;

		}
	}
	
	//rejectison
	
	$sql="SELECT log_date,qms_style,qms_schedule,sum(rejected_qty) as rejected_qty,LEFT(log_date,7) AS monthn FROM $view_set_5_snap WHERE qms_style='$style' and qms_schedule=$tbl_orders_master_product_schedule group by log_date  ORDER BY log_date DESC
";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	
	$log_date=array();	$qms_style=array();	$qms_schedule=array();	$rejected_qty=array();	$monthn=array();
$log_date_mtd=array();	$qms_style_mtd=array();	$qms_schedule_mtd=array();	$rejected_qty_mtd=array();	$monthn_mtd=array();


/*
unset($log_date);
unset($qms_style);
unset($qms_schedule);
unset($rejected_qty);
unset($monthn);
unset($log_date_mtd);
unset($qms_style_mtd);
unset($qms_schedule_mtd);
unset($rejected_qty_mtd);
unset($monthn_mtd);
*/

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		
		$log_date[]=$sql_row2['log_date'];	$qms_style[]=$sql_row2['qms_style'];	$qms_schedule[]=$sql_row2['qms_schedule'];	$rejected_qty[]=$sql_row2['rejected_qty'];	$monthn[]=$sql_row2['monthn'];

		
		if($sql_row2['monthn']==date("Y-m"))
		{
			$log_date_mtd[]=$sql_row2['log_date'];	$qms_style_mtd[]=$sql_row2['qms_style'];	$qms_schedule_mtd[]=$sql_row2['qms_schedule'];	$rejected_qty_mtd[]=$sql_row2['rejected_qty'];	$monthn_mtd[]=$sql_row2['monthn'];

		}


	}
	
	if(mysqli_num_rows($sql_result2)<5)
	{
		for($i=1;$i<=(5-mysqli_num_rows($sql_result2));$i++)
		{
			$log_date[]=0;	$qms_style[]=0;	$qms_schedule[]=0;	$rejected_qty[]=0;	$monthn[]=0;


		}
	}
	
	//cpk
	
	$sql="SELECT DATE,style,SCHEDULE,sum(cpk_qty) as cpk_qty,LEFT(DATE,7) AS monthn FROM $view_set_4_snap WHERE style='$style' and schedule=$tbl_orders_master_product_schedule group by date ORDER BY DATE DESC
";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	
	 $date=array();	$style_cpk=array();	$schedule=array();	$cpk_qty=array();	$monthn=array();
$date_mtd=array();	$style_cpk_mtd=array();	$schedule_mtd=array();	$cpk_qty_mtd=array();	$monthn_mtd=array();

/*
unset($date);
unset($style_cpk);
unset($schedule);
unset($cpk_qty);
unset($monthn);
unset($date_mtd);
unset($style_cpk_mtd);
unset($schedule_mtd);
unset($cpk_qty_mtd);
unset($monthn_mtd);
*/



	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		
		$date[]=$sql_row2['date'];	$style_cpk[]=$sql_row2['style'];	$schedule[]=$sql_row2['schedule'];	$cpk_qty[]=$sql_row2['cpk_qty'];	$monthn[]=$sql_row2['monthn'];


		
		if($sql_row2['monthn']==date("Y-m"))
		{
			$date_mtd[]=$sql_row2['date'];	$style_cpk_mtd[]=$sql_row2['style'];	$schedule_mtd[]=$sql_row2['schedule'];	$cpk_qty_mtd[]=$sql_row2['cpk_qty'];	$monthn_mtd[]=$sql_row2['monthn'];


		}


	}
	
	if(mysqli_num_rows($sql_result2)<5)
	{
		for($i=1;$i<=(5-mysqli_num_rows($sql_result2));$i++)
		{
			//$date[]=0;	$style[]=0;	$schedule[]=0;	$cpk_qty[]=0;	$monthn[]=0;

		}
	}
	
$c_block = echo_title("bai_pro3.bai_orders_db_confirm","zfeature","order_del_no",$tbl_orders_master_product_schedule,$link);
$sch_id = echo_title("brandix_bts.tbl_orders_master","id","product_schedule",$tbl_orders_master_product_schedule,$link);
$sch_qty = echo_title("brandix_bts.tbl_orders_sizes_master","sum(order_quantity)","parent_id",$sch_id,$link);

?>

 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td colspan=5 rowspan=2 class=xl8727816><span style="cursor: pointer; cursor: hand;" onclick="Popup=window.open('popup.php?schedule=<?=$tbl_orders_master_product_schedule; ?>','Popup','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;"><?=$tbl_orders_master_product_schedule."|".$c_block."|".$sch_qty; ?></span></td>
  <td class=xl6327816></td>
  <td rowspan=2 class=xl6727816>SWIP</td>
  <td rowspan=2 class=xl7827816><?=$sch_swip;?></td>
  <td rowspan=2 class=xl7827816><?=$sch_swip_per;?>%</td>
  <td class=xl6327816></td>
  <td rowspan=2 class=xl6727816>Balance</td>
  <td rowspan=2 class=xl7827816><?=$sch_balance;?></td>
  <td rowspan=2 class=xl7827816><?=$sch_balance_per;?>%</td>
  <td class=xl6327816></td>
  <td class=xl6727816>Age</td>
  <td colspan=2 rowspan=2 class=xl7927816 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black'>Next Mini Order<br/>Ex-Fa:<?=$order_date;?></td>
  <td rowspan=2 class=xl8327816 style='border-bottom:.5pt solid black'><?=$next_mini_order;?></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6427816 style='border-top:none'><?=$sch_age;?></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6527816 style='border-top:none'>&nbsp;</td>
  <td class=xl6527816 style='border-top:none'>&nbsp;</td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7227816>Day</td>
  <td class=xl7227816 style='border-left:none'>BUN</td>
  <td class=xl7227816 style='border-left:none'>BUO</td>
  <td class=xl7227816 style='border-left:none'>SIN</td>
  <td class=xl7227816 style='border-left:none'>SOT</td>
  <td class=xl7227816 style='border-left:none'>Conf. REJ.</td>
  <td class=xl7227816 style='border-left:none'>CPK</td>
  <td class=xl7227816 style='border-left:none'>SAH</td>
  <td class=xl7227816 style='border-left:none'>T- A SOT</td>
  <td class=xl7227816 style='border-left:none'>T - B SOT</td>
  <td class=xl7227816 style='border-left:none'>BTS REJ.</td>
  <td colspan=7 rowspan=10 class=xl10627816>
  	
  	
  	
  	
  	
  	
  	
  	 <?php
  echo "<script>
$(function () {
       		container".trim($tbl_orders_master_product_schedule)."();
    });
	function container".trim($tbl_orders_master_product_schedule)."(){
		
    $('#container1".trim($tbl_orders_master_product_schedule)."').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '".trim($tbl_orders_master_product_schedule)." Schedule Performance'
        },
      
        xAxis: {
            categories: [
                'Order',
                'BUN',
                'BUO',
                'SIN',
                'SOT',
                'REJ',
                'CPK',
                'Team-A',
                'Team-B'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Quantity'
            }
        },
       
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            column: {colorByPoint: true}
        },
        series: [{
        	 showInLegend: false,
        		name:'Production',
               data: [".$order_qty.", ".array_sum($bundling).", ".array_sum($bundleout).", ".array_sum($linein).", ".array_sum($output).", ".array_sum($rejected_qty).", ".array_sum($cpk_qty).", ".array_sum($a_output).", ".array_sum($b_output)."]

        }]
    });
}
</script>";
?>  
  
  
  <div class='img' id='container1<?=trim($tbl_orders_master_product_schedule);?>' style="width:450px; height:200px;"></div>
  	
  	
  	
  	
  	
  	
  	
  	
  	
  	
  </td>
  <td class=xl6327816></td>
 </tr>
 <?php
 {
 	

 /*<tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>5</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>4</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>3</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>2</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>1</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>MTD</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>TD Total</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr> */
 }
 ?>
 
 <!-- Start Schedule Detail -->
 
  <?php
  
 
 $day=5;
 for($j=0;$j<5;$j++)
 {
 	
?> 	
 
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'><?=date("d-m-y", strtotime($daten[$j]));?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=$bundling[$j];?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=$bundleout[$j];?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=$linein[$j];?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=$output[$j];?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=$rejected_qty[$j]; ?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=$cpk_qty[$j]; ?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=$sah[$j];?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=$a_output[$j];?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=$b_output[$j];?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=$rejected_bts[$j];?></td>
  <td class=xl6327816></td>
 </tr>
 
 
 <?php
 $day--;
 }
 ?>
 <?php
 {
 	
/* <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>4</td>
  <td class=xl6327816></td>
  <td class=xl6427816 style='border-top:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>3</td>
  <td class=xl6427816 style='border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>2</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>1</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr> -->
  <!--<tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>MTD</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>TD Total</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6427816 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr> */
 }
 ?>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>MTD</td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($bundling_mtd);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($bundleout_mtd);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($linein_mtd);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($output_mtd);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($rejected_qty_mtd); ?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($cpk_qty_mtd); ?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($sah_mtd);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($a_output_mtd);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($b_output_mtd);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($rejected_bts_mtd);?></td>
  <td class=xl6327816></td>
 </tr>
 
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>TD Total</td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($bundling);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($bundleout);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($linein);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($output);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($rejected_qty); ?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($cpk_qty); ?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($sah);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($a_output);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($b_output);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($rejected_bts);?></td>
  <td class=xl6327816></td>
 </tr>
 
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>Com. %</td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=round((array_sum($bundling)/$order_qty)*100,2);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=round((array_sum($bundleout)/$order_qty)*100,2);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=round((array_sum($linein)/$order_qty)*100,2);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=round((array_sum($output)/$order_qty)*100,2);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=round((array_sum($rejected_qty)/$order_qty)*100,2); ?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=round((array_sum($cpk_qty)/$order_qty)*100,2); ?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=round((array_sum($a_output)/$order_qty)*100,2);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=round((array_sum($b_output)/$order_qty)*100,2);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=round((array_sum($rejected_bts)/$order_qty)*100,2); ?></td>
  <td class=xl6327816></td>
 </tr>
 
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl7327816 style='border-top:none'>WIP</td>
  <td class=xl6427816 style='border-top:none;border-left:none'></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($bundling)-array_sum($bundleout);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($bundleout)-array_sum($linein);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($linein)-array_sum($output);?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'></td>
  <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($output)-array_sum($cpk_qty); ?></td>
  <td class=xl6427816 style='border-top:none;border-left:none'></td>
  <td class=xl6427816 style='border-top:none;border-left:none'></td>
  <td class=xl6427816 style='border-top:none;border-left:none'></td>
 <td class=xl6427816 style='border-top:none;border-left:none'><?=array_sum($rejected_qty)-array_sum($rejected_bts);?></td>
  <td class=xl6327816></td>
 </tr>
 
 <!-- End Scheudle Details -->
 
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6327816 style='height:15.0pt'></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
  <td class=xl6327816></td>
 </tr>
 <?php
//Schedule End
}
?>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
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
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
 </tr>
 <![endif]>
</table>

<?php
//Style End
}
?>
</div>


<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->


<script type="text/javascript">
 
       document.getElementById("msg").style.display = 'none';
</script>
</body>

</html>
<?php
	}
}
if(isset($_GET['snap_ids']))
{
//$cachefile = $cache_date.".html";
// open the cache file "cache/home.html" for writing
$fp = fopen($cachefile, 'w');
// save the contents of output buffer to the file
fwrite($fp, ob_get_contents());
// close the file
fclose($fp);
// Send the output to the browser
ob_end_flush();

echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
}
?>