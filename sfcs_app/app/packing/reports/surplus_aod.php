<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');   ?>

<?php
$desnote=$_GET["desnote"];

$sql="SELECT mer_month_year,date(qms_des_date) as qms_date,mer_remarks FROM $bai_pro3.bai_qms_destroy_log where qms_des_note_no=$desnote";
$sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$mer_ref=$sql_row["mer_month_year"];
	$res_dat=$sql_row["qms_date"];
	$mer_remarks=$sql_row["mer_remarks"];
}

$sql1="SELECT COUNT(DISTINCT remarks) AS ctn,sum(qms_qty) as qty FROM $bai_pro3.bai_qms_db WHERE location_id=\"DESTROYED-DEST#$desnote\"";
$sql_result1=mysqli_query($link, $sql1) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$carton_count=$sql_row1["ctn"];
	$carton_qty=$sql_row1["qty"];
}


?>
<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 15">
<link rel=File-List href="Surplus_AOD_files/filelist.xml">
<!--[if !mso]>
<style>
v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
x\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]-->
<style id="Surplus AOD_23201_Styles"><!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl1523201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6323201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6423201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:right;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6523201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6623201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6723201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6823201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6923201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7023201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7123201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7223201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:underline;
	text-underline-style:single;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7323201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:14.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7423201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7523201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7623201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7723201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7823201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
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
.xl7923201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8023201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
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
.xl8123201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8223201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8323201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8423201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8523201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8623201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8723201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
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
	white-space:normal;}
.xl8823201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl8923201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
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
	white-space:normal;}
.xl9023201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:underline;
	text-underline-style:single;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9123201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9223201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\[ENG\]\[$-409\]d\\-mmm\\-yy\;\@";
	text-align:center;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9323201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9423201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:"mmm\/yy";
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9523201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9623201
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:"mmm\/yy";
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9723201
	{padding:0px;
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
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
--></style>
</head>
<script>
function printpr()
{
var OLECMDID = 7;
/* OLECMDID values:
* 6 - print
* 7 - print preview
* 1 - open window
* 4 - Save As
*/
var PROMPT = 1; // 2 DONTPROMPTUSER
var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
WebBrowser1.ExecWB(OLECMDID, PROMPT);
WebBrowser1.outerHTML = "";
}
</script>

<body onLoad="printpr();">
<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Excel's Publish as Web
Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<div id="Surplus AOD_23201" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=816 style='border-collapse:
 collapse;table-layout:fixed;width:612pt'>
 <col width=64 span=4 style='width:48pt'>
 <col width=77 style='mso-width-source:userset;mso-width-alt:2816;width:58pt'>
 <col width=119 style='mso-width-source:userset;mso-width-alt:4352;width:89pt'>
 <col width=99 style='mso-width-source:userset;mso-width-alt:3620;width:74pt'>
 <col width=64 style='width:48pt'>
 <col width=137 style='mso-width-source:userset;mso-width-alt:5010;width:103pt'>
 <col width=64 style='width:48pt'>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 width=64 style='height:16.5pt;width:48pt'></td>
  <td class=xl6323201 width=64 style='width:48pt'></td>
  <td class=xl6323201 width=64 style='width:48pt'></td>
  <td class=xl6323201 width=64 style='width:48pt'></td>
  <td class=xl6323201 width=77 style='width:58pt'></td>
  <td class=xl6323201 width=119 style='width:89pt'></td>
  <td class=xl6323201 width=99 style='width:74pt'></td>
  <td class=xl6323201 width=64 style='width:48pt'></td>
  <td class=xl6323201 width=137 style='width:103pt'></td>
  <td class=xl1523201 width=64 style='width:48pt'></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td colspan=2 rowspan=4 height=88 width=128 style='height:66.0pt;width:96pt'
  align=left valign=top><!--[if gte vml 1]><v:shapetype id="_x0000_t75"
   coordsize="21600,21600" o:spt="75" o:preferrelative="t" path="m@4@5l@4@11@9@11@9@5xe"
   filled="f" stroked="f">
   <v:stroke joinstyle="miter"/>
   <v:formulas>
    <v:f eqn="if lineDrawn pixelLineWidth 0"/>
    <v:f eqn="sum @0 1 0"/>
    <v:f eqn="sum 0 0 @1"/>
    <v:f eqn="prod @2 1 2"/>
    <v:f eqn="prod @3 21600 pixelWidth"/>
    <v:f eqn="prod @3 21600 pixelHeight"/>
    <v:f eqn="sum @0 0 1"/>
    <v:f eqn="prod @6 1 2"/>
    <v:f eqn="prod @7 21600 pixelWidth"/>
    <v:f eqn="sum @8 21600 0"/>
    <v:f eqn="prod @7 21600 pixelHeight"/>
    <v:f eqn="sum @10 21600 0"/>
   </v:formulas>
   <v:path o:extrusionok="f" gradientshapeok="t" o:connecttype="rect"/>
   <o:lock v:ext="edit" aspectratio="t"/>
   
  </v:shapetype><v:shape id="Picture_x0020_1" o:spid="_x0000_s1026" type="#_x0000_t75"
   alt="http://bainet:8080/projects/beta/packing/dispatch/bai_logo.jpg"
   style='position:absolute;margin-left:51pt;margin-top:7.5pt;width:37.5pt;
   height:52.5pt;z-index:1;visibility:visible' o:gfxdata="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
KD44gSIqkvfksHsabNhFavNg3/LthpDrK5vfATLMmvnxD72tCAQwreLWgMz1s30uylYqVO+Z7r5c
+bNfK8mRkuOkUSn7E+f0c11rZgjcxkHszuAmv0649D0P8BRq5BmN/kX9MAz/sLEfTZaD8VzpJOb7
Zd8AAAD//wMAUEsDBAoAAAAAAAAAIQCqlLYzXhYAAF4WAAAVAAAAZHJzL21lZGlhL2ltYWdlMS5q
cGVn/9j/4AAQSkZJRgABAQEA3ADcAAD/2wBDAAIBAQIBAQICAgICAgICAwUDAwMDAwYEBAMFBwYH
BwcGBwcICQsJCAgKCAcHCg0KCgsMDAwMBwkODw0MDgsMDAz/2wBDAQICAgMDAwYDAwYMCAcIDAwM
DAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAz/wAARCAChAHMD
ASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUF
BAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0
NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKj
pKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QA
HwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEE
BSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZH
SElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0
tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD9
+wBgcClwPQUDoKKADA9BRgegoooAMD0FeUftdfth+Bf2L/hlN4m8b6mLSBsx2dnDh7vUZccRwx/x
N7nCqOSQOa9C8a+K7LwL4W1LWtTuI7TTtJtZLu5mkOEijRSzMT6AAmv5tf2+P2zNd/bh/aF1Txbq
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
">
   <v:imagedata src="Surplus_AOD_files/Surplus%20AOD_23201_image001.png"
    o:title=""/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><![endif]-->

  <td colspan=6 rowspan=3 class=xl8217319x valign="top" align="left"><img src="<?= $logo ?>" width="200" height="60"></td>

  <span
  style='mso-ignore:vglayout2'>
  <table cellpadding=0 cellspacing=0>
   <tr>
    <td colspan=2 rowspan=4 height=88 class=xl7523201 width=128
    style='height:66.0pt;width:96pt'></td>
   </tr>
  </table>
  </span></td>
  <td colspan=4 class=xl7623201>Brandix Essentials Limited, <?= $plant_name ?></td>
  <td class=xl6323201></td>
  <td class=xl7223201>Surplus Copy</td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td colspan=4 class=xl6923201>Plot # 12, BEK SEZ,</td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td colspan=4 class=xl6923201><?= $plant_name ?>,</td>
  <td class=xl6323201></td>
  <td class=xl7123201>Destruction Note No</td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td colspan=4 class=xl6923201>Sri Lanka.</td>
  <td class=xl6323201></td>
  <td class=xl7023201>DEST#<?php echo $desnote; ?></td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6923201></td>
  <td class=xl6923201></td>
  <td class=xl6923201></td>
  <td class=xl6923201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
 </tr>
 <tr height=25 style='height:18.75pt'>
  <td height=25 class=xl6323201 style='height:18.75pt'></td>
  <td colspan=8 class=xl7323201>Advice of Destruction (Non - Returnable)</td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6823201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td class=xl6323201>To:</td>
  <td colspan=4 class=xl6623201>Shredding Zone</td>
  <td colspan=2 class=xl6423201>Date:</td>
  <td class=xl9223201><?php echo date($res_dat); ?></td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td class=xl6323201></td>
  <td colspan=4 class=xl7423201>BAI 1</td>
  <td colspan=2 class=xl6423201>Destruction Mode:</td>
  <td class=xl6623201>Shredding</td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td class=xl6323201></td>
  <td colspan=4 class=xl7423201>&nbsp;</td>
  <td class=xl1523201></td>
  <td class=xl6723201>Dept.:</td>
  <td class=xl6623201>Surplus</td>
  <td class=xl1523201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td class=xl6323201></td>
  <td colspan=4 class=xl7423201>&nbsp;</td>
  <td class=xl1523201></td>
  <td class=xl1523201></td>
  <td class=xl1523201></td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td rowspan=4 height=98 class=xl7723201 style='height:73.5pt'>&nbsp;</td>
  <td rowspan=4 class=xl7823201 style='border-bottom:.5pt solid black'>Sno.</td>
  <td colspan=2 rowspan=4 class=xl8123201 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black'>MER Month</td>
  <td rowspan=4 class=xl7823201 style='border-bottom:.5pt solid black'>Cartons</td>
  <td rowspan=4 class=xl8723201 width=119 style='border-bottom:.5pt solid black;
  width:89pt'>Qty Destructed</td>
  <td rowspan=4 class=xl7823201 style='border-bottom:.5pt solid black'>UOM</td>
  <td colspan=2 rowspan=4 class=xl8123201 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black'>Remarks</td>
  <td rowspan=4 class=xl9123201>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
 </tr>
 <tr height=20 style='height:15.0pt'>
 </tr>
 <tr height=38 style='mso-height-source:userset;height:28.5pt'>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td class=xl9523201 style='border-top:none'>1</td>
  <td colspan=2 class=xl9623201 style='border-left:none'><?php echo $mer_ref; ?></td>
  <td class=xl9523201 style='border-top:none;border-left:none'><?php echo $carton_count; ?></td>
  <td class=xl9523201 style='border-top:none;border-left:none'><?php echo $carton_qty; ?></td>
  <td class=xl9523201 style='border-top:none;border-left:none'>PCS</td>
  <td colspan=2 class=xl9523201 style='border-left:none'><?php echo $mer_remarks; ?></td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td class=xl6323201></td>
  <td class=xl9423201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td colspan=3 class=xl9023201>Dispatched By</td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td colspan=3 class=xl7223201>Security Stamp</td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td colspan=2 class=xl6423201>Name :</td>
  <td colspan=2 class=xl6623201>&nbsp;</td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td colspan=2 class=xl6423201>Sign :</td>
  <td colspan=2 class=xl7423201>&nbsp;</td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td colspan=3 class=xl9023201>Authorized by</td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td colspan=2 class=xl6423201>Name :</td>
  <td class=xl6523201>&nbsp;</td>
  <td class=xl6523201>&nbsp;</td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td colspan=2 class=xl6423201>Sign :</td>
  <td class=xl6623201>&nbsp;</td>
  <td class=xl6623201>&nbsp;</td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td colspan=3 class=xl9023201>Received By</td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
  <td class=xl6323201></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6323201 style='height:16.5pt'></td>
  <td colspan=2 class=xl6423201>Name :</td>
  <td class=xl6523201>&nbsp;</td>
  <td class=xl6523201>&nbsp;</td>
  <td class=xl6423201>Sign :</td>
  <td colspan=3 class=xl6623201>&nbsp;</td>
  <td class=xl6323201></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1523201 style='height:15.0pt'></td>
  <td class=xl1523201></td>
  <td class=xl1523201></td>
  <td class=xl1523201></td>
  <td class=xl1523201></td>
  <td class=xl1523201></td>
  <td class=xl1523201></td>
  <td class=xl1523201></td>
  <td class=xl1523201></td>
  <td class=xl1523201></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1523201 style='height:15.0pt'></td>
  <td class=xl1523201></td>
  <td class=xl1523201></td>
  <td class=xl1523201></td>
  <td class=xl1523201></td>
  <td class=xl1523201></td>
  <td class=xl1523201></td>
  <td class=xl1523201></td>
  <td class=xl1523201></td>
  <td class=xl1523201></td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=77 style='width:58pt'></td>
  <td width=119 style='width:89pt'></td>
  <td width=99 style='width:74pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=137 style='width:103pt'></td>
  <td width=64 style='width:48pt'></td>
 </tr>
 <![endif]>
</table>

</div>


<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
</body>

</html>

