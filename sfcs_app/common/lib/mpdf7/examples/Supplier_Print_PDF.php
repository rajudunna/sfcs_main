<!--

Ticket #: #684040-kirang/2014-05-26 : To raise compalint for rejected RM material
Ticket #: #684040-kirang/2014-06-04 : 
1)	Need to directly mapped the length shortage percentage in the request form under ratings columns.
2)	Report no (140528/VSS/ OI/0292/225) in the log need to check.
3)	total replacement required in log need to enter.
4)	UOM need to update.
5)	Enter Purchase Width & Actual Width And similarly purchase Gsm and actual Gsm in the request form.

Ticket #: #684040-kirang/2015-06-18 // Changed the logic for count the number of rolls a batch.

-->
<?php //include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'], "dbconf2.php", "2", "R").""); ?>
<?php include("../../dbconf2.php")?>
<?php include("../../functions.php")?>
<?php //include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'], "functions.php", "2", "R")."");
include("../mpdf.php");

$mpdf=new mPDF('','A4',0,'',10,10,10,10,0,0,'P'); 
//echo $html;
$mpdf->AddPage();
$mpdf->WriteHTML($htmlstr); ?>

<?php

$htmlstr="";

$htmlstr.="<html xmlns:v=\"urn:schemas-microsoft-com:vml\"
xmlns:o=\"urn:schemas-microsoft-com:office:office\"
xmlns:x=\"urn:schemas-microsoft-com:office:excel\"
xmlns=\"http://www.w3.org/TR/REC-html40\">

<head>
<meta http-equiv=Content-Type content=\"text/html; charset=windows-1252\">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content=\"Microsoft Excel 15\">
<link rel=File-List href=\"Supplier_Claim_Print_Form_files/filelist.xml\">
<!--[if !mso]>
<style>
v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
x\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]-->
<style id=\"Supplier complint format_4315_Styles\">
<!--table
	{mso-displayed-decimal-separator:\".\";
	mso-displayed-thousand-separator:\",\";}
.xl644315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
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
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl654315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl664315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl674315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl684315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	background:#D9D9D9;
	mso-pattern:black none;
	white-space:nowrap;}
.xl694315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl704315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:14.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl714315
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:\"@\";
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl724315
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:\"@\";
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl734315
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:\"@\";
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl744315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl754315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
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
.xl764315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
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
.xl774315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl784315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl794315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#D9D9D9;
	mso-pattern:black none;
	white-space:nowrap;}
.xl804315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl814315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:right;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl824315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl834315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:right;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl844315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:right;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl854315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl864315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:\"\#\,\#\#0\";
	text-align:left;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl874315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl884315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl894315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl904315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	background:#E6B8B7;
	mso-pattern:black none;
	white-space:nowrap;}
.xl914315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:\"\#\,\#\#0\";
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	background:#E6B8B7;
	mso-pattern:black none;
	white-space:nowrap;}
.xl924315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
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
	background:#E6B8B7;
	mso-pattern:black none;
	white-space:nowrap;}
.xl934315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl944315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:Percent;
	text-align:general;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl954315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:Percent;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl964315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align: center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl974315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl984315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
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
.xl994315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:Percent;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1004315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:\"@\";
	text-align:left;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1014315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:\"@\";
	text-align:left;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1024315
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:\"\#\,\#\#0\";
	text-align:left;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1034315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:\"@\";
	text-align:left;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1044315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:\"\#\,\#\#0\";
	text-align:left;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1054315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1064315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1074315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1084315
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
	text-align:left;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1094315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#E6B8B7;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1104315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#E6B8B7;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1114315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#E6B8B7;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1124315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:14.0pt;
	font-weight:700;
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
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1134315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:14.0pt;
	font-weight:700;
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
	white-space:normal;}
.xl1144315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:14.0pt;
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
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1154315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:14.0pt;
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
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1164315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:14.0pt;
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
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1174315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:14.0pt;
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
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1184315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:14.0pt;
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
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1194315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:14.0pt;
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
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1204315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1214315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1224315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1234315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1244315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1254315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
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
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1264315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1274315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1284315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align: left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1294315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
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
	white-space:normal;}
.xl1304315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
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
	background:#D9D9D9;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1314315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
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
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1324315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	background:#D9D9D9;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1334315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	background:#D9D9D9;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1344315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#D9D9D9;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1354315
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#D9D9D9;
	mso-pattern:black none;
	white-space:nowrap;}
-->
</style>
</head>

<body>";

$comaplint_no=$_GET["sno"];
//include("dbconf2.php"); 
$sql="select * from inspection_complaint_db where complaint_no=\"".$comaplint_no."\"";	
$result=mysqli_query($link, $sql) or die("ErrorX=".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row=mysqli_fetch_array($result))
{
	$complaint_no=$row["complaint_no"];
	$ref_no=$row["ref_no"];
	$reuqest_user=$row["complaint_raised_by"];
	$product_categoy=$row["product_categoy"];
	$complaint_category=$row["complaint_category"];
	$req_date=$row["req_date"];
	$req_date_split=explode(" ",$req_date);
	$complaint_raised_by=$row["complaint_raised_by"];
	$supplier_name=$row["supplier_name"];
	$buyer_name=$row["buyer_name"];
	$reject_item_codes=$row["reject_item_codes"];
	$reject_item_color=$row["reject_item_color"];
	$reject_batch_no=$row["reject_batch_no"];
	$reject_po_no=$row["reject_po_no"];
	$reject_lot_no=$row["reject_lot_no"];
	$reject_roll_qty=$row["reject_roll_qty"];
	$reject_len_qty=$row["reject_len_qty"];
	$total_rej_qty=$reject_len_qty+$reject_roll_qty;
	$uom=$row["uom"];
	$supplier_approved_date=$row["supplier_approved_date"];
	$supplier_status=$row["supplier_status"];
	$supplier_remarks=$row["supplier_remarks"];
	$new_invoice_no=$row["new_invoice_no"];
	$supplier_replace_approved_qty=$row["supplier_replace_approved_qty"];
	$supplier_claim_approved_qty=$row["supplier_claim_approved_qty"];
	$complaint_status=$row["complaint_status"];
	$comaplint_remarks=$row["complaint_remarks"];
	$invoice_no=$row["reject_inv_no"];
	$item_desc=$row["reject_item_desc"];
	$purchase_width=$row["purchase_width"];
	$actual_width=$row["actual_width"];
	$purchase_gsm=$row["purchase_gsm"];
	$actual_gsm=$row["actual_gsm"];
	$inspqty_lot=$row["inspected_qty"];
}

$batch_lots=0;
$sql1="SELECT GROUP_CONCAT(DISTINCT lot_no) AS lots FROM sticker_report WHERE batch_no=\"".$reject_batch_no."\"";	
$result1=mysqli_query($link, $sql1) or die("ErrorX=".mysqli_error($GLOBALS["___mysqli_ston"]));
$rowsx=mysqli_num_rows($result1);
if($rowsx > 0)
{
	while($row1=mysqli_fetch_array($result1))
	{
		$batch_lots=$row1["lots"];
	}
}

$sql3="select unique_id as uid,log_date as upd from  inspection_db where batch_ref=\"".$reject_batch_no."\"";
$result3=mysqli_query($link, $sql3) or die("ErrorX=".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row3=mysqli_fetch_array($result3))
{
	$unique_id=$row3["uid"];
	$inspc_update=$row3["upd"];
	//echo $inspc_update;
}	

//$sql2="SELECT SUM(qty_rec) AS rec_qty,COUNT(tid) as rolls,COUNT(DISTINCT REPLACE(ref2,\"*\",\"\")),SUM(ref5) AS insp_qty FROM store_in WHERE lot_no IN (".$reject_lot_no.")";
$sql2="SELECT SUM(qty_rec) AS rec_qty,COUNT(DISTINCT REPLACE(ref2,\"*\",\"\")) as rolls,SUM(ref5) AS insp_qty FROM store_in WHERE lot_no IN (".$reject_lot_no.")";	
//echo $sql2."<br>";
$result2=mysqli_query($link, $sql2) or die("Error5=".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row2=mysqli_fetch_array($result2))
{
		$rec_qtys=$row2["rec_qty"];
		$rolls_count=$row2["rolls"];
		$inspc_qty=$row2["insp_qty"];
}

$htmlstr.="<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Excel's Publish as Web
Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<div id=\"Supplier complint format_4315\" align=center x:publishsource=\"Excel\">

<table border=0 cellpadding=0 cellspacing=0 width=981 class=xl655354315
 style='border-collapse:collapse;table-layout:fixed;width:736pt'>
 <col class=xl655354315 width=155 style='mso-width-source:userset;mso-width-alt:
 5668;width:116pt'>
 <col class=xl655354315 width=169 style='mso-width-source:userset;mso-width-alt:
 6180;width:127pt'>
 <col class=xl655354315 width=152 style='mso-width-source:userset;mso-width-alt:
 5558;width:114pt'>
 <col class=xl655354315 width=112 style='mso-width-source:userset;mso-width-alt:
 4096;width:84pt'>
 <col class=xl655354315 width=154 style='mso-width-source:userset;mso-width-alt:
 5632;width:116pt'>
 <col class=xl655354315 width=239 style='mso-width-source:userset;mso-width-alt:
 8740;width:179pt'>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
    <td colspan=4 rowspan=4 height=840 class=xl1124315 width=588
    style='border-right:.5pt solid black;border-bottom:.5pt solid black;
    height:63.0pt;width:441pt'>MATERIAL COMPLAINT SHEET - ".$product_categoy."</td>
  </td>
  <td class=xl814315 width=154 style='border-left:none;width:116pt'>COMPLAIN NO:</td>
  <td class=xl824315 width=239 style='border-left:none;width:179pt'>".$ref_no."</td>
  </tr>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl834315 style='height:15.75pt;border-top:none;
  border-left:none'>REPORT NO :</td>
  <td class=xl824315 width=239 style='border-top:none;border-left:none;
  width:179pt'>".date("ymd",strtotime($inspc_update))."/".substr($buyer_name,0,3)."/".$unique_id."</td>
 </tr>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl844315 width=154 style='height:15.75pt;border-top:none;
  border-left:none;width:116pt'>DATE :</td>
  <td class=xl824315 width=239 style='border-top:none;border-left:none;
  width:179pt'>".$req_date_split[0]."</td>
 </tr>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl844315 width=154 style='height:15.75pt;border-top:none;
  border-left:none;width:116pt'>TIME :</td>
  <td class=xl824315 width=239 style='border-top:none;border-left:none;
  width:179pt'>".$req_date_split[1]."</td>
 </tr>";
 $j=0;
 $k=0;
 $sql1="select * from inspection_complaint_reasons where complaint_category=\"$product_categoy\" ORDER BY complaint_category,sno,Complaint_clasification";
 $result1=mysqli_query($link, $sql1) or die("Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
 while($row1=mysqli_fetch_array($result1))
 {	
 	$sql2="select * from inspection_complaint_db_log where complaint_track_id=$comaplint_no and complaint_reason=\"".$row1["sno"]."\"";
	$result2=mysqli_query($link, $sql2) or die("Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rows=mysqli_num_rows($result2);
	
	if($rows > 0)
	{
		$src="wrong1.jpg";
		//$src="X";
	}
	else
	{
		$src="wrong2.jpg";
		//$src="";
	}
	
	$j=$j+1;
	if($j==1)
	{
		 $htmlstr.="<tr height=26 style='mso-height-source:userset;height:20.1pt'>";
		 $k=$k+1;
	}
	
	if($k==1)
	{
		$htmlstr.="<td rowspan=3 height=78 class=xl1284315 width=155 style='border-bottom:.5pt solid black;height:60.3pt;border-top:none;width:116pt'>COMPLAINT</td>";
	}
	
	if($j==3)
	{
		$colspan=2;
	}
	else
	{
		$colspan=1;
	}
	
	$htmlstr.="<td height=35 colspan=$colspan class=xl794315 style='height:37.1pt;border-left:none'><img align=\"left\" src=\"$src\">&nbsp;&nbsp;".$row1["complaint_reason"]."</td>";
	
	$k=$k+1;
	if($j==4)
	{
		$j=0;
		echo "</tr>";
	}	 		 
 }
 //echo $j;
 for($k=$j+1;$k<=4;$k++)
 {
 	$colspan=1;
	if($k==3)
	{
		$colspan=2;
	}
	$htmlstr.="<td height=26 colspan=$colspan class=xl794315 style='height:20.1pt;border-left:none'></td>";
 }
 
 $htmlstr.="<tr height=24 style='mso-height-source:userset;height:18.0pt'>
  <td height=24 class=xl664315 style='height:18.0pt;border-top:none'>SUPPLIER</td>
  <td class=xl1084315 style='border-top:none;border-left:none'>
  <form method=post action=\"Supplier_Claim_Log_Form.php\">".$supplier_name."</td>
  </form>
  <td class=xl654315 style='border-top:none;border-left:none'>PO#</td>
  <td class=xl1014315 width=112 style='border-top:none;border-left:none;
  width:84pt'>".$reject_po_no."</td>
  <td class=xl664315 style='border-top:none;border-left:none'>INVOICE #</td>
  <td class=xl1034315 width=239 style='border-top:none;border-left:none;
  width:179pt'>".$invoice_no."</td>
 </tr>
 <tr height=24 style='mso-height-source:userset;height:18.0pt'>
  <td height=24 class=xl804315 style='height:18.0pt;border-top:none'>BUYER</td>
  <td class=xl1084315 style='border-top:none;border-left:none'>
  <form method=post action=\"Supplier_Claim_Log_Form.php\">".$buyer_name."</td>
  </form>
  <td class=xl654315 style='border-top:none;border-left:none'>SKU #</td>
  <td class=xl1084315 width=112 style='border-top:none;border-left:none;
  width:84pt'>".$reject_item_codes."</td>
  <td class=xl664315 style='border-top:none;border-left:none'>COLOR</td>
  <td class=xl1044315 width=239 style='border-top:none;border-left:none;
  width:179pt'>".$reject_item_color."</td>
 </tr>
 <tr height=24 style='mso-height-source:userset;height:18.0pt'>
  <td height=24 class=xl654315 style='height:18.0pt;border-top:none'>BATCH #</td>
  <td class=xl1004315 width=169 style='border-top:none;border-left:none;
  width:127pt'>".$reject_batch_no."</td>
  <td class=xl664315 style='border-top:none;border-left:none'>MATERIAL
  DESCRIPTION</td>
  <td colspan=3 class=xl1054315 style='border-right:1.0pt solid black;
  border-left:none'>".$item_desc."</td>
 </tr>
 <tr height=24 style='mso-height-source:userset;height:18.0pt'>
  <td height=24 class=xl654315 style='height:18.0pt;border-top:none'>Purchase Width</td>
  <td class=xl1004315 width=169 style='border-top:none;border-left:none;
  width:127pt'>".$purchase_width."</td>
  <td class=xl664315 style='border-top:none;border-left:none'>Actual Width</td>
  <td colspan=3 class=xl1054315 style='border-right:1.0pt solid black;
  border-left:none'>".$actual_width."</td>
 </tr>
  <tr height=24 style='mso-height-source:userset;height:18.0pt'>
  <td height=24 class=xl654315 style='height:18.0pt;border-top:none'>Purchase GSM</td>
  <td class=xl1004315 width=169 style='border-top:none;border-left:none;
  width:127pt'>".$purchase_gsm."</td>
  <td class=xl664315 style='border-top:none;border-left:none'>Actual GSM</td>
  <td colspan=3 class=xl1054315 style='border-right:1.0pt solid black;
  border-left:none'>".$actual_gsm."</td>
 </tr>
 <tr height=24 style='mso-height-source:userset;height:18.0pt'>
  <td height=24 class=xl644315 style='height:18.0pt;border-top:none'>LOT#</td>
  <td colspan=5 class=xl714315 width=826 style='border-right:1.0pt solid black;
  border-left:none;width:620pt'>".$reject_lot_no."</td>
 </tr>
 <tr height=25 style='mso-height-source:userset;height:18.75pt'>
  <td height=25 class=xl854315 style='height:18.75pt;border-top:none'>QTY ($fab_uom)</td>
  <td class=xl864315 style='border-top:none;border-left:none'>".$rec_qtys."</td>
  <td class=xl874315 style='border-top:none'>QTY (ROLLS)</td>
  <td class=xl884315 style='border-top:none'>".$rolls_count."</td>
  <td class=xl874315 style='border-top:none'>QTY INSPECTED</td>
  <td class=xl894315 style='border-top:none'>".$inspqty_lot."</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl904315 style='height:15.0pt'>CATEGORY</td>
  <td class=xl914315 style='border-left:none'>RATING</td>
  <td class=xl924315 style='border-left:none'>EFFECTED $fab_uom</td>
  <td colspan=3 class=xl1094315 style='border-right:.5pt solid black;
  border-left:none'>COMMENT</td>
 </tr>";
 	$sql1="select * from inspection_complaint_reasons where complaint_category=\"$product_categoy\" GROUP BY Complaint_clasification ORDER BY complaint_category,sno,Complaint_clasification";
	//echo $sql1."<br>";
	$result1=mysqli_query($link, $sql1) or die("Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		$htmlstr.="<tr height=20 style='height:15.0pt'><td colspan=6 height=20 class=xl1204315 style='border-right:.5pt solid black;height:15.0pt'>".$row1["Complaint_clasification"]."</td></tr>";
		$sql2="select * from inspection_complaint_reasons where complaint_category=\"$product_categoy\" AND Complaint_clasification=\"".$row1["Complaint_clasification"]."\" ORDER BY complaint_category,sno,Complaint_clasification";
		//echo $sql2;
		$result2=mysqli_query($link, $sql2) or die("Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row2=mysqli_fetch_array($result2))
		{
			$sql3="select * from inspection_complaint_db_log where complaint_track_id=$comaplint_no and complaint_reason=\"".$row2["sno"]."\"";
			$result3=mysqli_query($link, $sql3) or die("Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rows=mysqli_num_rows($result3);
			if($rows > 0)
			{
				while($row3=mysqli_fetch_array($result3))
				{		
					$htmlstr.="<tr height=24 style='mso-height-source:userset;height:18.0pt'>
				  	<td height=24 class=xl664315 style='height:18.0pt;border-top:none'>".$row2["complaint_reason"]."</td>
				  	<td class=xl964315 style='border-top:none;border-left:none'>".$row3["complaint_rating"]."</td>
				  	<td class=xl964315 style='border-top:none;border-left:none'>".$row3["complaint_rej_qty"]."</td>
				  	<td colspan=3 class=xl1234315 style='border-right:.5pt solid black;border-left:none'>".$row3["complaint_commnets"]."</td>
				 	</tr>";	
				 }
			}
			else
			{
				$htmlstr.="<tr height=24 style='mso-height-source:userset;height:18.0pt'>
				  <td height=24 class=xl664315 style='height:18.0pt;border-top:none'>".$row2["complaint_reason"]."</td>
				  <td class=xl964315 style='border-top:none;border-left:none'>0</td>
				  <td class=xl964315 style='border-top:none;border-left:none'>0</td>
				  <td colspan=3 class=xl1234315 style='border-right:.5pt solid black;border-left:none'>Nil</td>
				 </tr>";
			}
		}		
	}	
 
 $htmlstr.="<tr height=20 style='height:15.0pt'>
  <td colspan=6 height=20 class=xl1204315 style='border-right:.5pt solid black;
  height:15.0pt'>OTHERS</td>
 </tr>
 <tr height=24 style='mso-height-source:userset;height:18.0pt'>
  <td height=24 class=xl664315 style='height:18.0pt;border-top:none'>&nbsp;</td>
  <td class=xl664315 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl664315 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl764315 style='border-left:none'>&nbsp;</td>
 </tr>
 <tr height=24 style='mso-height-source:userset;height:18.0pt'>
  <td height=24 class=xl934315 style='height:18.0pt;border-top:none'>&nbsp;</td>
  <td class=xl674315 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl674315 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl764315 style='border-left:none'>&nbsp;</td>
 </tr>
 <tr height=24 style='mso-height-source:userset;height:18.0pt'>
  <td height=24 class=xl934315 style='height:18.0pt;border-top:none'>&nbsp;</td>
  <td class=xl944315 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl944315 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl764315 style='border-left:none'>&nbsp;</td>
 </tr>
 <tr height=13 style='mso-height-source:userset;height:9.95pt'>
  <td rowspan=3 height=39 class=xl974315 style='height:29.85pt;border-top:none'>FINAL
  COMENT</td>
  <td colspan=5 rowspan=3 class=xl954315>".$comaplint_remarks."</td>
 </tr>
 <tr height=13 style='mso-height-source:userset;height:9.95pt'>
 </tr>
 <tr height=13 style='mso-height-source:userset;height:9.95pt'>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td rowspan=2 height=40 class=xl974315 style='height:30.0pt;border-top:none'>SUPPLIER
  COMMENT</td>
  <td colspan=5 rowspan=2 class=xl964315>".$supplier_remarks."</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
 </tr>
 <tr height=24 style='mso-height-source:userset;height:18.0pt'>
  <td height=24 class=xl694315 style='height:18.0pt;border-top:none'>TOTAL
  REPLACMENT</td>
  <td colspan=5 class=xl764315 style='border-left:none'>".$total_rej_qty."</td>
 </tr>
 <tr height=24 style='mso-height-source:userset;height:18.0pt'>
  <td height=24 class=xl694315 style='height:18.0pt;border-top:none'>PREPARED
  BY</td>
  <td class=xl804315 style='border-top:none;border-left:none'>".ucwords($reuqest_user)."</td>
  <td class=xl694315 style='border-top:none;border-left:none'>MERCHANT</td>
  <td class=xl804315 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl694315 style='border-top:none;border-left:none'>SOURCING</td>
  <td class=xl804315 style='border-top:none;border-left:none'>&nbsp;</td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=155 style='width:116pt'></td>
  <td width=169 style='width:127pt'></td>
  <td width=152 style='width:114pt'></td>
  <td width=112 style='width:84pt'></td>
  <td width=154 style='width:116pt'></td>
  <td width=239 style='width:179pt'></td>
 </tr>
 <![endif]>
</table>

</div>


<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
</body>
</html>";

echo $htmlstr;

//==============================================================
//==============================================================
//include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'], "mpdf.php", "1", "R")."");

//$mpdf->Output(); 
 
$file_name_pdf=$ref_no.".pdf";
ob_start(); //To capture temp
$mpdf->Output("Claim_PDF_Files/".$file_name_pdf,'F');
ob_end_clean();
//$mpdf->Output(); 
//exit;

//$mpdf->Output(); 
if($_GET["status"]==0)
{
include("Supplier_Claim_PDF_Mail.php");
}
exit;

?>