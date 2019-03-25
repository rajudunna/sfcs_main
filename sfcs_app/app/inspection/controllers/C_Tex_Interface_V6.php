<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R')); 
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/headers.php',1,'R'));
$has_permission=haspermission($_GET['r']);
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 14">
<link rel=File-List href="C_Tex_Interface_files/filelist.xml">

<style>
.textbox{
	background-color:#99ff88;
	width:100%;
	border:none;
	color:black;
	height:100%;
}

.Text_B{
	background-color:white;
	width:100%;
	border:none;
	color:black;
	height:100%;
}

.listbox{
	background-color:#99ff88;
	width:100%;
	border:none;
	color:black;
	height:100%;
}
.textspace{
	background-color:#99ff88;
	width:100%;
	border:none;
	color:black;
	height:100%;
}
</style>

<style id="C_Tex_Interface_24082_Styles">
table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl6324082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl6424082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl6524082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl6624082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl6724082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl6824082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6924082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7024082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:Fixed;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7124082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7224082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7324082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7424082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7524082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:Fixed;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7624082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:0;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7724082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7824082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:0;
	text-align:general;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7924082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl8024082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8124082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:Fixed;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8224082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:Fixed;
	text-align:left;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8324082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:0;
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8424082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:Fixed;
	text-align:center;
	vertical-align:top;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8524082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:Fixed;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8624082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:Fixed;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8724082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:Fixed;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8824082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:Fixed;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8924082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:Fixed;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:1.0pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9024082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:Fixed;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9124082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:Fixed;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9224082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:Fixed;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9324082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl9424082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl9524082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl9624082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl9724082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl9824082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl9924082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl10024082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10124082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10224082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10324082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:Fixed;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl10424082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:Fixed;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl10524082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:Percent;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl10624082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:Percent;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl10724082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\@";
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl10824082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\@";
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl10924082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl11024082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;
}
.xl11124082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl11224082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl11324082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11424082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11524082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11624082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl11724082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:right;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl11824082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11924082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl12024082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:right;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl12124082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl12224082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#95B3D7;
	mso-pattern:black none;
	white-space:nowrap;}
.xl12324082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#95B3D7;
	mso-pattern:black none;
	white-space:nowrap;}
.xl12424082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#95B3D7;
	mso-pattern:black none;
	white-space:nowrap;}
.xl12524082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl12624082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl12724082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:7.0pt;
	font-weight:200;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl12824082
	{
		padding-top:1px;
		padding-right:1px;
		padding-left:1px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:Fixed;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:.5pt solid windowtext;
		border-bottom:.5pt solid windowtext;
		border-left:.5pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;
		word-wrap: break-word;
	}
.xl12924082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:0;
	text-align:general;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl13024082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
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
.xl13124082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:right;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl13224082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl13324082
	{
		padding-top:1px;
		padding-right:1px;
		padding-left:1px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:1.0pt solid windowtext;
		border-right:.5pt solid windowtext;
		border-bottom:1.0pt solid windowtext;
		border-left:.5pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:normal;}
.xl13424082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl13524082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl13624082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl13724082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl13824082
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}

</style>

</head>

<body >
<?php 
?>
<div style="float:left;">
<h5 style='color:red;'><b>*All Green Fields are mandatory to confirm*</b></h5>
</div>
<div style="float:right;">
	<?php
	$url = getURL(getBASE($_GET['r'])['base'].'/c_Tex_index.php')['url'];
	?>
	<a href="<?php echo $url; ?>" class="btn btn-primary">Back</a>
</div>




<?php


	if(isset($_POST['submit']))
	{
		$lot_no=$_POST['lot_no'];
	}
	else
	{
		$lot_no=urldecode($_GET['batch_no']);
		$lot_ref=urldecode($_GET['lot_ref']);
	}
?>


<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/supplier_db.php',1,'R')); 
//Configuration
if(strlen($lot_no)>0 and strlen($lot_ref)>0)
{
?>
<form id="myForm" name="input" action="?r=<?php echo $_GET['r']?>" method="post">
	<?php
echo "<input type='hidden' id='head_check' name='head_check' value=''>";
echo "<input type='hidden' id='lot_ref' name='lot_ref' value='".$lot_ref."'>";
$sql="select *, SUBSTRING_INDEX(buyer,\"/\",1) as \"buyer_code\", group_concat(distinct item) as \"item_batch\", group_concat(distinct pkg_no) as \"pkg_no_batch\", group_concat(distinct po_no) as \"po_no_batch\",group_concat(distinct inv_no) as \"inv_no_batch\", group_concat(distinct lot_no) as \"lot_ref_batch\", count(distinct lot_no) as \"lot_count\", sum(rec_qty) as \"rec_qty1\",group_concat(distinct supplier) as \"supplier\" from $bai_rm_pj1.sticker_report where lot_no in ("."'".str_replace(",","','",$lot_ref)."'".") and batch_no=\"".trim($lot_no)."\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error1=".$sql."-".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$product_group=$sql_row['product_group'];
	$item=$sql_row['item_batch'];
	$item_name=$sql_row['item_name'];
	$item_desc=$sql_row['item_desc'];
	$inv_no=$sql_row['inv_no_batch'];
	$po_no=$sql_row['po_no_batch'];
	$rec_no=$sql_row['rec_no'];
	$rec_qty=$sql_row['rec_qty1'];
	$batch_no=$sql_row['batch_no'];
	$buyer=$sql_row['buyer'];
	$pkg_no=$sql_row['pkg_no_batch'];
	$grn_date=$sql_row['grn_date'];
	$lot_ref_batch=$sql_row['lot_ref_batch'];
	$lot_count=$sql_row['lot_count'];
	$buyer_code=$sql_row['buyer_code'];
	$supplier_ref_name=$sql_row['supplier'];
	
	//NEW SYSTEM IMPLEMENTATION RESTRICTION
	$new_ref_date=substr($grn_date,0,4)."-".substr($grn_date,4,2)."-".substr($grn_date,6,2);
	if($new_ref_date>"2011-05-12")
	{
		
	}
	else
	{
	}
	//NEW SYSTEM IMPLEMENTATION RESTRICTION
}

$sql="select * from $bai_rm_pj1.inspection_db where batch_ref=\"".trim($lot_no)."\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2=".mysqli_error($GLOBALS["___mysqli_ston"]));
$inspection_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$act_gsm=$sql_row['act_gsm'];
	$pur_gsm=$sql_row['pur_gsm'];
	$pur_width=$sql_row['pur_width'];
	$act_width=$sql_row['act_width'];
	$sp_rem=$sql_row['sp_rem'];
	$qty_insp=$sql_row['qty_insp'];
	$gmt_way=$sql_row['gmt_way'];
	$pts=$sql_row['pts'];
	$fallout=$sql_row['fallout'];
	$skew=$sql_row['skew'];
	$skew_cat=$sql_row['skew_cat'];
	$shrink_l=$sql_row['shrink_l'];
	$shrink_w=$sql_row['shrink_w'];
	$supplier=$sql_row['supplier'];
	$status=$sql_row['status'];
	$consumption=$sql_row['consumption'];
}

//Configuration 
$values=array();
$scount_temp=array();
$ctex_sum=0;
$avg_t_width=0;
$avg_c_width=0;
$print_check=0;
//removed validation of print button
// $sql="select *, if((ref5=0 or length(ref6)<=1 or ref6=0 or length(ref3)<=1 or ref3=0 or length(ref4)=0),1,0) as \"print_check\" from $bai_rm_pj1.store_in where lot_no in ("."'".str_replace(",","','",$lot_ref_batch)."'".") order by ref2+0";
$sql="select *, if((length(ref4)=0 and qty_allocated <=0),1,0) as \"print_check\" from $bai_rm_pj1.store_in where lot_no in ("."'".str_replace(",","','",$lot_ref_batch)."'".") order by ref2+0";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error3=".mysqli_error($GLOBALS["___mysqli_ston"]));
$num_rows=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$values[]=$sql_row['tid']."~".$sql_row['ref2']."~".$sql_row['ref4']."~".$sql_row['qty_rec']."~".$sql_row['ref5']."~".$sql_row['ref6']."~".$sql_row['ref3']."~".$sql_row['lot_no']."~".$sql_row["roll_joins"]."~".$sql_row["partial_appr_qty"]."~".$sql_row["roll_status"]."~".$sql_row["shrinkage_length"]."~".$sql_row["shrinkage_width"]."~".$sql_row["shrinkage_group"]."~".$sql_row["roll_remarks"]."~".$sql_row["rejection_reason"]."~".$sql_row["qty_allocated"];
//tid,rollno,shade,tlenght,clenght,twidth,cwidth,lot_no
	
	$scount_temp[]=$sql_row['ref4'];

	$ctex_sum+= ($sql_row['ref5']);
		$avg_t_width+= ($sql_row['ref6']);
		$avg_c_width+= ($sql_row['ref3']);
	
	if($sql_row['print_check']==1)
	{
		$print_check=1;
	}
}

//Added Backup Lots for visibility in Inspection Report
//removed validation of print button
// $sql1="select *, if((ref5=0 or length(ref6)<=1 or ref6=0 or length(ref3)<=1 or ref3=0 or length(ref4)=0),1,0) as \"print_check\" from $bai_rm_pj1.store_in_backup where lot_no in ("."'".str_replace(",","','",$lot_ref_batch)."'".") order by ref2+0";
$sql1="select *, if((length(ref4)=0 and qty_allocated <= 0),1,0) as \"print_check\" from $bai_rm_pj1.store_in_backup where lot_no in ("."'".str_replace(",","','",$lot_ref_batch)."'".") order by ref2+0";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error3=".mysqli_error($GLOBALS["___mysqli_ston"]));
$num_rows=$num_rows+mysqli_num_rows($sql_result1);
if(mysqli_num_rows($sql_result1) > 0)
{
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$values[]=$sql_row['tid']."~".$sql_row['ref2']."~".$sql_row['ref4']."~".$sql_row['qty_rec']."~".$sql_row['ref5']."~".$sql_row['ref6']."~".$sql_row['ref3']."~".$sql_row['lot_no']."~".$sql_row["roll_joins"]."~".$sql_row["partial_appr_qty"]."~".$sql_row["roll_status"]."~".$sql_row["shrinkage_length"]."~".$sql_row["shrinkage_width"]."~".$sql_row["shrinkage_group"]."~".$sql_row["roll_remarks"]."~".$sql_row["rejection_reason"]."~".$sql_row["qty_allocated"];
	//tid,rollno,shade,tlenght,clenght,twidth,cwidth,lot_no
		
		$scount_temp[]=$sql_row1['ref4'];
		// $ctex_sum+=$sql_row['ref5'];
		$ctex_sum+= ((int)$sql_row['ref5']);
		// $avg_t_width+=$sql_row['ref6'];
		$avg_t_width+= ((int)$sql_row['ref6']);
		// $avg_c_width+=$sql_row['ref3'];
		$avg_c_width+= ((int)$sql_row['ref3']);
			
		if($sql_row1['print_check']==1)
		{
			$print_check=1;
		}
	}
}

sort($scount_temp);  //to sort shade groups
if($num_rows>0)
{
	$avg_t_width=round($avg_t_width/$num_rows,2);
	$avg_c_width=round($avg_c_width/$num_rows,2);
}
else
{
	$avg_t_width=0;
	$avg_c_width=0;
}
$scount_temp2=array();
$scount_temp2=array_values(array_unique($scount_temp));
$shade_count=sizeof($scount_temp2);
//Configuration 


$sql="select  COUNT(DISTINCT REPLACE(ref2,\"*\",\"\"))  as \"count\" from $bai_rm_pj1.store_in where lot_no in ("."'".str_replace(",","','",$lot_ref_batch)."'".")";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error4=".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$total_rolls=$sql_row['count'];
}

	if(stristr($item,"BF"))
	{
		$category="BF";
	}
	
	if(stristr($item,"GF"))
	{
		$category="GF";
	}

}
?>
<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Excel's Publish as Web
Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<div class="row">
<div class="col-sm-12">
<div id="C_Tex_Interface_24082" align=center x:publishsource="Excel">
<div class="table-responsive">

<table border=0 cellpadding=0 cellspacing=0 width=1126 class=xl11024082 style='border-collapse:collapse;table-layout:fixed;width:1050pt'>
 <col class=xl11024082 width=80 style='mso-width-source:userset;mso-width-alt: 2925;width:60pt'>
 <col class=xl11024082 width=65 span=2 style='mso-width-source:userset; mso-width-alt:2377;width:49pt'>
 <col class=xl12124082 width=68 style='mso-width-source:userset;mso-width-alt: 2486;width:51pt'>
 <col class=xl11024082 width=68 style='mso-width-source:userset;mso-width-alt: 2486;width:51pt'>
 <col class=xl11024082 width=64 span=2 style='mso-width-source:userset; mso-width-alt:2340;width:48pt'>
 <col class=xl11024082 width=99 style='mso-width-source:userset;mso-width-alt: 3620;width:74pt'>
 <col class=xl11024082 width=77 style='mso-width-source:userset;mso-width-alt: 2816;width:58pt'>
 <col class=xl11024082 width=68 span=7 style='mso-width-source:userset; mso-width-alt:2486;width:51pt'>
 <tr height=25 style='mso-height-source:userset;height:18.75pt'>
  <td colspan=16 height=25 class=xl12524082 dir=LTR width=1126  style='height:18.75pt;width:845pt'><a name="RANGE!A1:P19">Fabric Inspection Report - Roll Details</a></td>
 </tr>
 <tr height=26 style='mso-height-source:userset;height:20.1pt'>
  <td height=26 class=xl9524082 dir=LTR width=80 style='height:20.1pt;  width:60pt'>Item Code</td>
  <td colspan=2 class=xl9624082 dir=LTR width=130 style='border-left:none;  width:98pt'><?php echo $item; ?></td>
  <td colspan=2 rowspan=1 class=xl9624082 dir=LTR width=136 style='width:102pt'>Fabric  Description</td>
  <td colspan=5 rowspan=1 class=xl9624082 dir=LTR width=372 style='width:279pt'><?php echo $item_name; ?></td>  <td colspan=2 class=xl9624082 dir=LTR width=136 style='border-left:none;  width:102pt'>Batch No</td>
  <td colspan=4 class=xl9624082 dir=LTR width=272 style='border-right:1.0pt solid black;  border-left:none;width:204pt'><?php echo $batch_no; ?></td>
 </tr>
 <tr height=26 style='mso-height-source:userset;height:20.1pt'>
  <td height=26 class=xl9724082 dir=LTR width=80 style='height:20.1pt;
  border-top:none;width:60pt'>Buyer</td>
  <td colspan=9 class=xl9324082 dir=LTR  style='border-left:none;'><?php echo $buyer; ?></td>
  <td colspan=2 class=xl9324082 dir=LTR width=136 style='border-left:none;  width:102pt'>Lot No</td>
  <td colspan=4 class=xl10024082 style='border-right:1.0pt solid black;  border-bottom:.5pt solid black;border-left:none'><?php echo $lot_ref_batch; ?></td>
 </tr>
 <tr height=26 style='mso-height-source:userset;height:20.1pt'>
  <td height=26 class=xl9724082 dir=LTR width=80 style='height:20.1pt;  border-top:none;width:60pt'>Consumption<span style='mso-spacerun:yes'></span></td>
  <td colspan=2 class=xl9324082 dir=LTR width=130 style='border-left:none;  width:98pt'><?php if(in_array($authorized,$has_permission)) { echo "<input onchange=\"change_head(1,this.name)\" type=\"text\" class=\"textbox float req_man\"    id=\"consumption\" name=\"consumption\" value='".$consumption."' />"; } else { echo $consumption; }?></td>
  <td colspan=7 class=xl12224082 style='border-right:.5pt solid black;  border-left:none'>Inspection Summary</td>
  <td colspan=2 class=xl9324082 dir=LTR width=136 style='border-left:none;  width:102pt'>Supplier</td>
  <td colspan=4 class=xl9324082 dir=LTR width=272 style='border-right:1.0pt solid black;  border-left:none;width:204pt'>
  <?php
	  echo $supplier_ref_name;
  ?>

  </td>
 </tr>
 <tr height=26 style='mso-height-source:userset;height:20.1pt'>
  <td height=26 class=xl9724082 dir=LTR width=80 style='height:20.1pt;  border-top:none;width:60pt'>Color</td>
  <td colspan=2 class=xl9324082 dir=LTR width=130 style='border-left:none;  width:98pt'><?php echo $item_desc; ?></td>
  <td colspan=2 class=xl9324082 dir=LTR width=136 style='border-left:none;  width:102pt'>Qty In (<?php echo $fab_uom; ?>)</td>
  <td colspan=2 class=xl10324082 dir=LTR width=128 style='border-right:.5pt solid black;  border-left:none;width:96pt'><?php echo $rec_qty; ?></td>
  <td class=xl9424082 dir=LTR width=99 style='border-top:none;border-left:none;  width:74pt'>PTS/100 Sq.Yd.</td>
  <td colspan=2 class=xl10324082 dir=LTR width=145 style='border-right:.5pt solid black;  width:109pt'><?php if(in_array($authorized,$has_permission)) { echo "<input onchange=\"change_head(1,this.name)\" type=\"text\" class=\"textbox float req_man\"  id=\"pts\" name=\"pts\" value='".$pts."' />"; } else { echo $pts; }?></td>
  <td colspan=2 class=xl9324082 dir=LTR width=136 style='border-left:none;  width:102pt'>Package</td>
  <td colspan=4 class=xl9324082 dir=LTR width=272 style='border-right:1.0pt solid black;  border-left:none;width:204pt'><?php echo $pkg_no; ?></td>
 </tr>
 <tr height=26 style='mso-height-source:userset;height:20.1pt'>
  <td height=26 class=xl9724082 dir=LTR width=80 style='height:20.1pt;  border-top:none;width:60pt'>PO Number</td>
  <td colspan=2 class=xl9324082 dir=LTR width=130 style='border-left:none;  width:98pt'><?php echo $po_no; ?></td>
  <td colspan=2 class=xl9324082 dir=LTR width=136 style='border-left:none;  width:102pt'>Qty Inspected</td>
  <td colspan=2 class=xl10524082 dir=LTR width=128 style='border-right:.5pt solid black;  border-left:none;width:96pt'><?php if(in_array($authorized,$has_permission)) { echo '<input onchange="change_head(1,this.name)"  type="text" class="textbox float req_man"  id="qty_insp" name="qty_insp" value="'.$qty_insp.'" >'; } else { echo $qty_insp; }?></td>
  <td class=xl9424082 dir=LTR width=99 style='border-top:none;border-left:none;  width:74pt'>Fallout</td>
  <td colspan=2 class=xl10324082 dir=LTR width=145 style='border-right:.5pt solid black;  width:109pt'><?php if(in_array($authorized,$has_permission)) { echo '<input onchange="change_head(1,this.name)"  type="text" class="textbox float req_man"  id="fallout" name="fallout" value="'.$fallout.'" >'; } else { echo $fallout; }?></td>
  
  <td colspan=2 class=xl9324082 dir=LTR width=136 style='border-left:none;width:102pt'>Pur. GSM</td>
  <td class=xl9324082 dir=LTR style='border-left:none; width:102pt'><?php if(in_array($authorized,$has_permission)) { echo '<input onchange="change_head(1,this.name)" size=4  type="text" class="textbox float req_man"   id="pur_gsm" name="pur_gsm"  value="'.$pur_gsm.'" >'; } else { echo $pur_gsm; }?></td>
  <td colspan=2 class=xl9324082 dir=LTR width=136 style='border-left:none; style="align:center;" width:102pt'>Act. GSM</td>
  <td colspan=1 class=xl9324082 dir=LTR width=136 style='border-left:none; width:102pt'><?php if(in_array($authorized,$has_permission)) { echo '<input onchange="change_head(1,this.name)" size=4 type="text" class="textbox float req_man" id="act_gsm" name="act_gsm"  value="'.$act_gsm.'" >'; } else { echo $act_gsm; }?></td>
 </tr>
 <tr height=26 style='mso-height-source:userset;height:20.1pt'>
  <td height=26 class=xl9724082 dir=LTR width=80 style='height:20.1pt;  border-top:none;width:60pt'>GRN Date</td>
  <td colspan=2 class=xl9324082 dir=LTR width=130 style='border-left:none;  width:98pt'><?php echo $grn_date; ?></td>
  <td colspan=2 class=xl9324082 dir=LTR width=136 style='border-left:none;  width:102pt'>Pct Inspected</td>
  <td colspan=2 class=xl10724082 dir=LTR width=128 style='border-right:.5pt solid black;  border-left:none;width:96pt'><?php if($rec_qty>0) { echo round(($qty_insp/$rec_qty)*100,2)."%";} ?></td>
  <td class=xl9424082 dir=LTR width=99 style='border-top:none;border-left:none;  width:74pt'>




  <?php 
 if(in_array($authorized,$has_permission))
 {
 	 echo "<select onchange='change_head(1,this.name)'  id='skew_cat' name='skew_cat' class='listbox req_man'>";
	 if($skew_cat==1)
	 {
	 	echo "<option value='1' selected>Skewness</option>";
	 }
	 else
	 {
	 	echo "<option value='1'>Skewness</option>";
	 }
	 if($skew_cat==2)
	 {
	 	echo "<option value='2' selected>Bowing</option>";
	 }
	 else
	 {
	 	echo "<option value='2'>Bowing</option>";
	 }
	 
	 if($skew_cat=="" or $skew_cat==0)
	 {
	 	echo "<option value='0' selected></option>";
	 }
	 else
	 {
	 	echo "<option value='0'></option>";
	 }
	 
	 echo "</select>"; 
 }
 else
 {
     if($skew_cat==1)
	 {
	 	echo "Skewness";
	 }
	 else if($skew_cat==2)
	 {
	 	echo "Bowing";
	 }	 
	 else if($skew_cat=="" or $skew_cat==0)
	 {
	 	echo "NIL";
	 }
	 else
	 {
	 	echo "NIL";
	 }
 	
 }  
    ?></td>
  <td colspan=2 class=xl9424082 dir=LTR width=145 style='border-right:.5pt solid black;
  width:109pt'><?php if(in_array($authorized,$has_permission)) { echo '<input onchange="change_head(1,this.name)"  type="text"  class="textbox float req_man" id="skew" name="skew" value="'.$skew.'" />'; } else { echo $skew; } ?></td>
  <td colspan=2 class=xl9324082 dir=LTR width=136 style='border-left:none;
  width:102pt'>Purchase Width</td>
  <td colspan=4 class=xl9324082 dir=LTR width=272 style='border-right:1.0pt solid black;
  border-left:none;width:204pt'><?php if(in_array($authorized,$has_permission)) { echo '<input onchange="change_head(1,this.name)"  type="text" class="textbox float req_man"  id="pur_width" name="pur_width" value="'.$pur_width.'" />';} else { echo $pur_width; } ?></td>
 </tr>
 <tr height=26 style='mso-height-source:userset;height:20.1pt'>
  <td height=26 class=xl9724082 dir=LTR width=80 style='height:20.1pt;  border-top:none;width:60pt'>No of rolls</td>
  <td colspan=2 class=xl9324082 dir=LTR width=130 style='border-left:none;  width:98pt'><?php echo $total_rolls; ?></td>
  <td colspan=2 class=xl9324082 dir=LTR width=136 style='border-left:none;  width:102pt'>Length Short %</td>
  <td colspan=2 class=xl9424082 dir=LTR width=128 style='border-right:.5pt solid black;  border-left:none;width:96pt'><?php if($rec_qty>0) {echo round((($ctex_sum-$rec_qty)/$rec_qty)*100,2)."%";}  ?></td>
  <td rowspan=2 class=xl11224082 width=99 style='border-bottom:1.0pt solid black;  border-top:none;width:74pt'>Residual Shrinkage</td>
  <td class=xl9324082 dir=LTR width=77 style='border-top:none;border-left:none;  width:58pt'>L%</td>
  <td class=xl9424082 dir=LTR width=68 style='border-top:none;border-left:none;  width:51pt'>W%</td>
  <td colspan=2 class=xl9324082 dir=LTR width=136 style='width:102pt'>Actual  Width</td>
  <td colspan=4 class=xl13524082 dir=LTR width=272 style='border-right:1.0pt solid black;  border-left:none;width:204pt'><?php if(in_array($authorized,$has_permission)) { echo '<input onchange="change_head(1,this.name)"  type="text" class="textbox float req_man"  id="act_width" name="act_width" value="'.$act_width.'" />';} else { echo $act_width; } ?> </td>
 </tr>
 <tr height=26 style='mso-height-source:userset;height:20.1pt'>
  <td height=26 class=xl9824082 dir=LTR width=80 style='height:20.1pt;
  border-top:none;width:60pt'>Category</td>
  <td colspan=2 class=xl11324082 style='border-left:none'><?php echo $category; ?></td>
  <td colspan=2 class=xl9924082 dir=LTR width=136 style='border-left:none;
  width:102pt'>Fabric Way</td>
  <td colspan=2 class=xl11424082 style='border-right:.5pt solid black;
  border-left:none'><?php 
 if(in_array($authorized,$has_permission))
 {
	 echo "<select onchange='change_head(1,this.name)' id='gmt_way'  name='gmt_way' class='listbox req_man'>";
	 
	  if($gmt_way=="" or $gmt_way==0)
	 {
	 	echo "<option value='' selected></option>";
	 }
	 else
	 {
	 	echo "<option value='0'></option>";
	 }
	 
	 if($gmt_way==1)
	 {
	 	echo "<option value='1' selected>N/A</option>";
	 }
	 else
	 {
	 	echo "<option value='1'>N/A</option>";
	 }
	 if($gmt_way==2)
	 {
	 	echo "<option value='2' selected>One Way</option>";
	 }
	 else
	 {
	 	echo "<option value='2'>One Way</option>";
	 }
	 if($gmt_way==3)
	 {
	 	echo "<option value='3' selected>Two Way</option>";
	 }
	 else
	 {
	 	echo "<option value='3'>Two Way</option>";
	 }

	 echo "</select>"; 
 }
 else
 {
 	 if($gmt_way=="" or $gmt_way==0)
	 {
	 	echo "";
	 }
	 else if($gmt_way==1)
	 {
	 	echo "N/A";
	 }
	 else if($gmt_way==2)
	 {
	 	echo "One Way";
	 }
	 else if($gmt_way==3)
	 {
	 	echo "Two Way";
	 }
	 else
	 {
	 	echo "";
	 }
 }  
    ?></td>
  <td class=xl11324082 style='border-top:none;border-left:none'><?php if(in_array($authorized,$has_permission)) { echo '<input onchange="change_head(1,this.name)"  type="text" class="textbox float req_man"  id="shrink_l" name="shrink_l" value="'.$shrink_l.'" />';  } else { echo $shrink_l; } ?> </td>
  <td class=xl11424082 style='border-top:none;border-left:none'><?php if(in_array($authorized,$has_permission)) { echo '<input onchange="change_head(1,this.name)"  type="text" class="textbox float req_man"  id="shrink_w" name="shrink_w" value="'.$shrink_w.'" />';  } else { echo $shrink_w; } ?> </td>
  <td colspan=2 class=xl11324082>Invoice</td>
  <td colspan=4 class=xl11324082 style='border-right:1.0pt solid black'><?php echo $inv_no; ?></td>
 </tr>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl8224082 colspan=2 style='height:15.75pt'>Special  Instruction</td>
  <td class=xl8124082></td>
  <td class=xl8124082></td>
  <td class=xl8324082></td>
  <td class=xl7224082 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl7224082 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl7224082 dir=LTR width=99 style='width:74pt'></td>
  <td class=xl7224082 dir=LTR width=77 style='width:58pt'></td>
  <td class=xl7224082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl7224082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl11724082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl11824082></td>
  <td class=xl11824082></td>
  <td class=xl11824082></td>
  <td class=xl11824082></td>
 </tr>
 <?php 
 
 if($num_rows>0 and $print_check==0 and $inspection_check==1) 
 {
 	$print_report=1;
 }
 else
 {
 	$print_report=0;
 }
 
 ?>
 <tr height=28 style='mso-height-source:userset;height:21.0pt'>
  <td colspan=12 rowspan=3 height=84 class=xl8424082 style='border-right:1.0pt solid black;
  border-bottom:1.0pt solid black;height:63.0pt'><textarea onchange="change_head(1,this.name)" class="textspace req_man" id="sp_rem"  name="sp_rem"><?php echo $sp_rem; ?></textarea></td>
  <td class=xl11024082></td>
   <td class=xl11024082 colspan=2 rowspan=2><?php
   echo '<input type="hidden" id="print_report"  name="print_report" value="'.$print_report.'">';
    if($print_report>0) 
   	{ echo '<h3><center><a class="btn btn-warning" href="'.getFullURLLevel($_GET['r'],'C_Tex_Report_Print.php',0,'R').'?lot_no='.$lot_no.'&lot_ref='.$lot_ref.'" target="_new" style="text-decoration:none;">Print Report</a></center></h3>'; } else { echo '<h3>Please update values to Print.</h3>'; }?></td>
  
 <td class=xl11024082></td> 
 </tr>
 <tr height=28 style='mso-height-source:userset;height:21.0pt'>
  <td height=28 class=xl11024082 style='height:21.0pt'></td>
 <td class=xl11024082></td>
  <td class=xl11024082></td>
  <td class=xl11024082></td>
 </tr>
 <tr height=28 style='mso-height-source:userset;height:21.0pt'>
  <td height=28 class=xl11024082 style='height:40.0pt'></td>
  <td class=xl11024082 colspan=3>
  <?php
if($num_rows>0 or $inspection_check==0 or $status==0)
  {
  	
  	echo '<input type="hidden" id="lot_no"  name="lot_no" value="'.$lot_no.'">';
	if(in_array($authorized,$has_permission) or in_array($update,$has_permission))
	{
	//$update_access
	
		echo '<input type="checkbox" name="option"  id="option"  onclick="javascript:enableButton();">Enable <input type="submit" value="Save" class="btn btn-primary confirm-submit" disabled="true"  id="put" name="put" /><br>';		
		echo '<input type="checkbox" name="option1"  id="option1" onclick="javascript:enableButton1();">Enable <input type="submit" value="Confirm" id="confirm" name="confirm"  class="btn btn-primary confirm-submit" disabled="true" /><br>';		
	}

  }
 
  ?>
  </td>
 
 </tr>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl6324082 dir=LTR width=80 style='height:15.75pt;  width:60pt'>&nbsp;</td>
  <td class=xl6424082 dir=LTR width=65 style='width:49pt'></td>
  <td class=xl6424082 dir=LTR width=65 style='width:49pt'></td>
  <td class=xl6524082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl6424082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl6424082 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl6424082 dir=LTR width=64 style='width:48pt'></td>
  <td class=xl6424082 dir=LTR width=99 style='width:74pt'></td>
  <td class=xl6424082 dir=LTR width=77 style='width:58pt'></td>
  <td class=xl6424082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl6424082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl6424082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl6424082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl6424082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl6424082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl6424082 dir=LTR width=68 style='width:51pt'></td>
 </tr>
 
  <tr>
 	<td class=xl6424082 dir=LTR width=68 style='width:51pt'>Note: </td>
 	<td colspan="2" class=xl6424082 dir=LTR width=68 style='width:80pt;background-color:red;color:white'>Inspection Not Done</td>
 	 <td colspan="2" class=xl6424082 dir=LTR width=68 style='width:80pt;background-color:green;color:white'>Inspection Done</td>
 </tr>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'></tr>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
 <td class=xl6424082 dir=LTR width=65 style='width:49pt' colspan=1>Auto Fill</td>
  <!-- <td height=21 class=xl6324082 dir=LTR width=80 style='height:15.75pt;  width:60pt'>&nbsp;</td> -->

   <td class=xl6524082 dir=LTR width=68 style='width:51pt'><input type="text"  class="alpha" id="fill_shade_grp" name="fill_shade_grp"  maxlength="8"   value="" size="6">&nbsp;<a class="btn btn-success btn-xs" onclick="fill(4)">Fill</a></td>	
  <td class=xl6424082 dir=LTR width=65 style='width:49pt' colspan=1></td>
  <td class=xl6524082 dir=LTR width=68 style='width:51pt'><input type="text"  class="float" id="fill_c_length" name="fill_c_length"   value="" size="3">&nbsp;<a class="btn btn-success btn-xs" onclick="fill(1)">Fill</a></td>	
  <td class=xl6424082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl6424082 dir=LTR width=64 style='width:48pt'><input type="text" id="fill_t_width" class="float" name="fill_t_width"  value="" size="3"><a class="btn btn-success btn-xs" onclick="fill(2)">Fill</a></td>
  <td class=xl6424082 dir=LTR width=64 style='width:48pt'><input type="text" id="fill_c_width" class="float" name="fill_c_width" value="" size="3"><a class="btn btn-success btn-xs" onclick="fill(3)">Fill</a></td>
  <td class=xl6424082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl6424082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl6424082 dir=LTR width=68 style='width:51pt'></td>
  <td colspan="2" class=xl6424082 dir=LTR width=68 style='width:70pt;'></td>`
  <td class=xl6424082 dir=LTR width=68 style='width:51pt'></td>
  <td colspan="2" class=xl6424082 dir=LTR width=68 style='width:60pt;'></td>
  <td class=xl6424082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl6424082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl6424082 dir=LTR width=68 style='width:51pt'></td>
 </tr>
 <tr height=41 style='height:32pt'>
  <td class=xl13224082 dir=LTR width=68 style='width:51pt'>Roll No</td>
  <td class=xl13324082 dir=LTR width=20 style='border-left:none;width:19pt'>Shade Group</td>
  <td class=xl13324082 dir=LTR width=65 style='border-left:none;width:49pt'>Ticket  Length</td>
  <td class=xl13324082 dir=LTR width=68 style='border-left:none;width:51pt'>C-TEX  Length</td>
  <td class=xl13324082 dir=LTR width=68 style='border-left:none;width:51pt'>Length  Deviation</td>
  <td class=xl13324082 dir=LTR width=64 style='border-left:none;width:48pt'>Ticket  Width</td>
  <td class=xl13324082 dir=LTR width=64 style='border-left:none;width:48pt'>C-TEX  Width</td>
  <td class=xl13324082 dir=LTR width=99 style='border-left:none;width:74pt'>No of Joins</td>
  <td class=xl13324082 dir=LTR width=99 style='border-left:none;width:74pt'>Width  Deviation</td>
  <td class=xl13324082 colspan=2 dir=LTR width=99 style='border-left:none;width:100px'>Lot No</td>
  <td class=xl13324082 dir=LTR colspan=2 width=68 style='border-left:none;width:51pt'>Roll Status</td>
  <td class=xl13324082 dir=LTR colspan=2 width=68 style='border-left:none;width:51pt'>Rejection reason</td>
  <td class=xl13324082 dir=LTR width=68 style='border-left:none;width:51pt'>Partial Rej Qty</td>
  <?php
  if($shrinkage_inspection == 'yes')
	  { ?>
  <td class=xl13324082 dir=LTR colspan=2 width=68 style='border-left:none;width:51pt'>Shrinkage  Length</td>
  <td class=xl13324082 dir=LTR  colspan=2 width=68 style='border-left:none;width:51pt'>Shrinkage  Width</td>
  <td class=xl13324082 dir=LTR colspan=2 width=68 style='border-left:none;width:51pt'>Shrinkage  Group</td>
	 <?php } ?>
  <td class=xl13324082 dir=LTR colspan=3 width=68 style='border-left:none;width:51pt'>Roll Remarks</td>
 </tr>
 
 <?php
 /*echo "<tr height=20 style='height:15.0pt'>
  <td height=20 class=xl12724082 style='height:15.0pt'>1</td>
  <td class=xl12724082 style='border-left:none'>A</td>
  <td class=xl12824082 style='border-left:none'>87.00</td>
  <td class=xl12824082 style='border-left:none'>88.68</td>
  <td class=xl12824082 style='border-left:none'>1.68</td>
  <td class=xl12824082 style='border-left:none'>63.00</td>
  <td class=xl12824082 style='border-left:none'>64.00</td>
  <td class=xl12824082 style='border-left:none'>1.00</td>
  <td class=xl12924082 align=right style='border-left:none'>1108270199</td>
  <td class=xl13024082 dir=LTR width=68 style='border-left:none;width:51pt'>&nbsp;</td>
  <td class=xl13024082 dir=LTR width=68 style='border-left:none;width:51pt'>&nbsp;</td>
  <td class=xl13024082 dir=LTR width=68 style='border-left:none;width:51pt'>&nbsp;</td>
  <td class=xl13024082 dir=LTR width=68 style='border-left:none;width:51pt'>&nbsp;</td>
  <td class=xl13024082 dir=LTR width=68 style='border-left:none;width:51pt'>&nbsp;</td>
  <td class=xl13024082 dir=LTR width=68 style='border-left:none;width:51pt'>&nbsp;</td>
  <td class=xl13124082 dir=LTR width=68 style='border-left:none;width:51pt'>&nbsp;</td>
 </tr>"; */
 $shade_group_total=array();
 echo "<input type=\"hidden\" id=\"rowcount\" value=\"".sizeof($values)."\" />";

 for($i=0;$i<sizeof($values);$i++)
 {
 	$temp=array();
	$temp=explode("~",$values[$i]);
	//for shade wise category
	if(in_array($temp[2],$scount_temp2))
	{
		$shade_group_total[array_search($temp[2],$scount_temp2)]+=$temp[3];
	}
	
	//for shade wise category
	if(in_array($authorized,$has_permission))
	{
		if ($temp[16] > 0) 
		{
			$readonly = 'readonly';
			$dropdown_read = 'disabled';
		}else
		{
			$readonly = '';
			$dropdown_read = '';
		}
	
		echo "<input type='hidden' name=\"qty_allocated[$i]\" id=\"qty_allocated[$i]\" value='".$temp[16]."'>";
		if(!in_array($authorized,$has_permission))
		{
			$temp_shade_tag.=$temp[2]."<input type=\"hidden\" ".$readonly." class='textbox alpha unique_shade_".$temp[1]."' id=\"ele_shade[$i]\" name=\"ele_shade[$i]\" maxlength=\"8\" onchange='change_body(2,this.name,$i); validate_unique_shade(\"".trim($temp[2])."\", \"".$temp[1]."\", $i)' value=\"".trim($temp[2])."\" />";
		}
		else
		{
			$temp_shade_tag.="<input type=\"text\" class='textbox alpha shade_grp unique_shade_".$temp[1]."' ".$readonly." id=\"ele_shade[$i]\"  name=\"ele_shade[$i]\" maxlength=\"8\" onchange='change_body(2,this.name,$i); validate_unique_shade(\"".trim($temp[2])."\", \"".$temp[1]."\", $i)' value=\"".trim($temp[2])."\" />";
		}		
	}
	else
	{
		$temp_shade_tag.=$temp[2];
	}
	if($temp[1]=="")
	{
		$temp[1]="N/A";
	}
	if(($temp[2]!='') or ($temp[4]!='') or ($temp[5]!='') or ($temp[6]!=''))
	{
		$insp_status="Green";	
	}
	else
	{
		$insp_status="Red";		
	}
	 echo "<input type='hidden' class='roll_no_".$temp[1]."' value='".$temp[1]."'>";
	  echo "
	  <td height=50 class='xl12824082' style='height:15.0pt;background-color: ".$insp_status.";color:white'>".$temp[1]."<input type='hidden' id='ele_tid[$i]' name='ele_tid[$i]' value='".$temp[0]."'><input type='hidden' name='ele_check[$i]' value=''><input type='hidden' name='tot_elements' id='tot_elements' value='".sizeof($values)."'></td>";
	  
	  echo "<td class=xl12824082 style='border-left:none'>".$temp_shade_tag."<input type='hidden' id='ele_shades[$i]'  name='ele_shades[$i]' value='".trim($temp[2])."'></td>

	  <td class=xl12824082 style='border-left:none'>".$temp[3]."<input class='hidden' type='hidden' id='ele_t_length".$i."' name='ele_t_length[$i]' value='".$temp[3]."' onchange='change_body(2,this.name,$i)'></td>
	  <td class=xl12824082 style='border-left:none'><input class='textbox ctex_len float' ".$readonly." type='text'  min='0'  id='ele_c_length".$i."'  onkeyup='Subtract(".$i.");' name='ele_c_length[$i]' value='".$temp[4]."' onchange='change_body(2,this.name,$i)' ></td>

	  <td class=xl12824082 style='border-left:none'><input class='Text_B' type='text' name='subt".$i."' id='subt".$i."' readonly value='".round(($temp[4] - $temp[3]),2)."' ></td>

	  <td class=xl12824082 style='border-left:none'><input class='textbox ticket_wid float' ".$readonly." type='text' min='0'  name='ele_t_width[$i]' id='ele_t_width".$i."' onkeyup='minus(".$i.");' value='".$temp[5]."' onchange='change_body(2,this.name,$i)'></td>
	  <td class=xl12824082 style='border-left:none'><input class='textbox ctex_wid float' ".$readonly." type='text' min='0'  name='ele_c_width[$i]' id='ele_c_width".$i."' onkeyup='minus(".$i.");' value='".$temp[6]."' onchange='change_body(2,this.name,$i)'></td>


	  <td class=xl12824082 style='border-left:none'><input class='textbox el_joins integer' ".$readonly." type='text' id='ele_c_joins[$i]'  name='ele_c_joins[$i]'  value='".$temp[8]."' onchange='change_body(2,this.name,$i)' ></td>

	  <td class=xl12824082 style='border-left:none'><input class='Text_B' type='text' name='min".$i."' id='min".$i."' readonly value='".round(($temp[6] - $temp[5]),2)."'></td>

	  <td class=xl12824082 colspan='2' style='border-left:none;width:100px'>".$temp[7]."</td>";
	  
	  if(in_array($authorized,$has_permission))
	  {	  
	    echo "<td class=xl13024082 dir=LTR width=99 colspan=2 style='border-left:none;width:95pt'>
	    	<select name=\"roll_status[$i]\" id='roll_status[$i]'  onchange='change_body(2,this.name,$i)' ".$dropdown_read." class='listbox' id='roll_status[$i]'>";
	    for($iq=0;$iq<sizeof($roll_status);$iq++)
	    {
	  	 	if($iq==$temp[10])
			{
				echo "<option value='".$iq."' selected>".$roll_status[$iq]."</option>";
			}	  	
			else
			{
				echo "<option value='".$iq."'>".$roll_status[$iq]."</option>";	
			}
	  	}
		echo "</select></td>";
	  } 	
	  else
	  {
	  	echo "<td class=xl13024082 dir=LTR width=99 colspan=2 style='border-left:none;width:95pt'>".$roll_status[$temp[10]]."<input type=\"hidden\" class='textbox' id=\"roll_status[$i]\"  name=\"roll_status[$i]\" maxlength=\"3\" onchange='change_body(2,this.name,$i)' value=\"".$temp[10]."\" /></td>";	
	  }
	  
	  	
	  echo " <td class=xl13024082 colspan=2 dir=LTR width=99 colspan=2 style='border-left:none;width:95pt'>";
	  		$reject_reason_query="select * FROM $bai_rm_pj1.reject_reasons ";
			// $reject_reasons=mysqli_query($link, $reject_reason_query) or die("Error10=".mysqli_error($GLOBALS["___mysqli_ston"]));
			// while($row1=mysqli_fetch_array($reject_reasons))
			// {
			// 	if ($temp[15] == $row1['tid']) 
			// 	{
			// 		echo $row1["reject_desc"];
			// 	}
			// }

	if($temp[10] == 1 || $temp[10] == 2){
		$style = '';
	}else{
		$style = 'style=display:none'; 
	}
	  echo "
	  	<select name=\"rejection_reason[$i]\"  class='listbox rej_reason rej_reason_select2' id='rejection_reason[$i]' onchange='change_body(2,this.name,$i)' ".$style.">
	  			<option value='' selected >NIL</option>";
				$reject_reasons2=mysqli_query($link, $reject_reason_query) or die("Error10=".mysqli_error($GLOBALS["___mysqli_ston"]));
	    		while($row1=mysqli_fetch_array($reject_reasons2))
	    		{
					if ($temp[15] == $row1['tid']) 
					{
						echo "<option value=".$row1['tid']." selected>".$row1["reject_desc"]."</option>";
					} 
					else 
					{
						echo "<option value=".$row1['tid'].">".$row1["reject_desc"]."</option>";
					}
				}
				$sgroup = $temp[13];
				if($sgroup=='')
				{
					$sgroup=0;
				}
		echo "</select>
	  </td>

	  <td class=xl12824082 style='border-left:none'><input class='textbox float par_rej' ".$readonly."  type='text' min='0' name='ele_par_length[$i]' id='ele_par_length[$i]' value='".$temp[9]."' onchange='change_body(2,this.name,$i)'></td>";
	  if($shrinkage_inspection == 'yes')
	  {
	  echo "<td class=xl12824082  colspan=2 style='border-left:none'><input class='textbox float shr_len' ".$readonly."  type='text' min='0' id='shrinkage_length[$i]' name='shrinkage_length[$i]' value='".$temp[11]."' onchange='change_body(2,this.name,$i)'></td>
	  <td class=xl12824082  colspan=2 style='border-left:none'><input class='textbox float shr_wid' ".$readonly."  type='text' min='0' id='shrinkage_width[$i]' name='shrinkage_width[$i]' value='".$temp[12]."' onchange='change_body(2,this.name,$i)'></td>
	  <td class=xl12824082  colspan=2 style='border-left:none'><input class='textbox alpha shr_grp' ".$readonly." type='text' min='0' id='shrinkage_group[$i]'  name='shrinkage_group[$i]' value='".$sgroup."' onchange='change_body(2,this.name,$i)'></td>";
	  }
	  else
	  {
		echo "<td class=xl12824082  colspan=2 style='border-left:none;display: none;'><input class='textbox float shr_len' ".$readonly."  type='text' min='0' id='shrinkage_length[$i]' name='shrinkage_length[$i]' value='".$temp[11]."' onchange='change_body(2,this.name,$i)'></td>
		<td class=xl12824082  colspan=2 style='border-left:none;display: none;'><input class='textbox float shr_wid' ".$readonly."  type='text' min='0' id='shrinkage_width[$i]' name='shrinkage_width[$i]' value='".$temp[12]."' onchange='change_body(2,this.name,$i)'></td>
		<td class=xl12824082  colspan=2 style='border-left:none; display: none;'><input class='textbox alpha shr_grp' ".$readonly." type='text' min='0' id='shrinkage_group[$i]'  name='shrinkage_group[$i]' value='".$sgroup."' onchange='change_body(2,this.name,$i)'></td>";
	  }
	 echo "<td class=xl12824082 colspan=3 style='border-left:none'><input class='textbox' ".$readonly." type='text' id='roll_remarks[$i]' name='roll_remarks[$i]' value='".$temp[14]."' onchange='change_body(2,this.name,$i)'></td>
	 
	 </tr>";
	 $temp_shade_tag="";
	
 }
 
 if(strlen($lot_no)>0)
{
echo '</form>';
}
 
 ?>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl8024082 style='height:15.75pt'></td>
  <td class=xl8024082></td>
  <td class=xl8124082></td>
  <td class=xl8124082></td>
  <td class=xl8124082></td>
  <td class=xl8124082></td>
  <td class=xl8124082></td>
  <td class=xl8124082></td>
  <td class=xl8324082></td>
  <td class=xl7224082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl7224082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl7224082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl7224082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl11024082></td>
  <td class=xl11024082></td>
  <td class=xl11024082></td>
 </tr>
 <tr class=xl11924082 height=40 style='height:30.0pt'>
  <td  height=40 class=xl7324082 width=80 style='height:30.0pt;width:60pt'>Total  Rolls</td>
  <td class=xl7424082 width=65 style='border-left:none;width:49pt'>No of Group</td>
  <td class=xl7524082 width=65 style='border-left:none;width:49pt'>Total  Ticket Length</td>
  <td class=xl7524082 width=68 style='border-left:none;width:51pt'>Total  C-Tex Length</td>
  <td class=xl7524082 width=68 style='border-left:none;width:51pt'>Length  Deviation</td>
  <td class=xl7524082 width=64 style='border-left:none;width:48pt'>Average  Ticket Width</td>
  <td class=xl7524082 width=64 style='border-left:none;width:48pt'>Average  C-Tex Width</td>
  <td class=xl7524082 width=99 style='border-left:none;width:74pt'>Average Width  Deviation</td>
  <td class=xl7624082 width=77 style='border-left:none;width:58pt;border-right:1pt solid'>Lot  Numbers</td>
  <!-- <td class=xl7724082 dir=LTR width=68 style='width:51pt'>Group</td> -->
  
 </tr>
 <tr height=31 style='mso-height-source:userset;height:23.25pt'>
  <td height=31 class=xl6824082 style='height:23.25pt;border-top:none'><?php echo $num_rows; ?></td>
  <td class=xl6924082 style='border-top:none;border-left:none'><?php  echo $shade_count; ?></td>
  <td class=xl7024082 style='border-top:none;border-left:none'><?php echo round($rec_qty,2); ?></td>
  <td class=xl7024082 style='border-top:none;border-left:none'><?php echo round($ctex_sum,2); ?></td>
  <td class=xl7024082 style='border-top:none;border-left:none'><?php echo round(($ctex_sum-$rec_qty),2); ?></td>
  <td class=xl7024082 style='border-top:none;border-left:none'><?php echo round($avg_t_width,2); ?></td>
  <td class=xl7024082 style='border-top:none;border-left:none'><?php echo round($avg_c_width,2); ?></td>
  <td class=xl7024082 style='border-top:none;border-left:none'><?php echo round(($avg_c_width-$avg_t_width),4); ?></td>
  <td class=xl7024082 style='border-top:none;border-left:none'><?php echo $lot_count; ?></td>
  <!-- <td class=xl7924082 dir=LTR width=68 style='border-top:none;width:51pt'>Qty</td> -->
  </tr>
   <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl8024082 style='height:15.75pt'></td>
  <td class=xl8024082></td>
  <td class=xl8124082></td>
  <td class=xl8124082></td>
  <td class=xl8124082></td>
  <td class=xl8124082></td>
  <td class=xl8124082></td>
  <td class=xl8124082></td>
  <td class=xl8324082></td>
  <td class=xl7224082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl7224082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl7224082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl7224082 dir=LTR width=68 style='width:51pt'></td>
  <td class=xl11024082></td>
  <td class=xl11024082></td>
  <td class=xl11024082></td>
 </tr>
</table>
 
 <table border=0 cellpadding=0 cellspacing=0 width=1126 class=xl11024082 style='border-collapse:collapse;table-layout:fixed;width:1050pt'>
  	 <?php
  /*echo "<td class=xl6624082 dir=LTR width=68 style='border-left:none;width:51pt'>&nbsp;</td>
  <td class=xl6624082 dir=LTR width=68 style='border-left:none;width:51pt'>&nbsp;</td>
  <td class=xl6624082 dir=LTR width=68 style='border-left:none;width:51pt'>&nbsp;</td>
  <td class=xl6624082 dir=LTR width=68 style='border-left:none;width:51pt'>&nbsp;</td>
  <td class=xl6624082 dir=LTR width=68 style='border-left:none;width:51pt'>&nbsp;</td>
  <td class=xl6724082 dir=LTR width=68 style='border-left:none;width:51pt'>&nbsp;</td>";*/
  echo "<td class=xl6824082 style='height:23.25pt;border-top:1pt solid'></td>";
  
  for($i=0;$i<$shade_count;$i++)
  { 
	echo "<td colspan=2 class=xl6824082 style='height:23.25pt;border-top:1pt solid;'>".$scount_temp2[$i]."</td>";
	
  }
  
  ?>
  <tr>
  	<td colspan=1 class=xl6824082 style='height:23.25pt;border-top:none'>Group</td>
 	<?php
	  for($i=0;$i<$shade_count;$i++)
	  { 
		echo "<td colspan=1 class=xl6824082 style='height:23.25pt;border-top:none'>Rolls</td>";
		echo "<td colspan=1 class=xl6824082 dir=LTR width=68 style='border-left:none;width:51pt'>Qty</td>";
	  }
	?>
 </tr>
  <tr>
  	<td colspan=1 class=xl6824082 style='height:23.25pt;border-top:none'>Qty</td>
  	<?php
  
  /* echo " <td class=xl7124082 dir=LTR width=68 style='border-top:none;border-left:none;
  width:51pt'>&nbsp;</td>
  <td class=xl7124082 dir=LTR width=68 style='border-top:none;border-left:none;
  width:51pt'>&nbsp;</td>
  <td class=xl7124082 dir=LTR width=68 style='border-top:none;border-left:none;
  width:51pt'>&nbsp;</td>
  <td class=xl7124082 dir=LTR width=68 style='border-top:none;border-left:none;
  width:51pt'>&nbsp;</td>
  <td class=xl7124082 dir=LTR width=68 style='border-top:none;border-left:none;
  width:51pt'>&nbsp;</td>
  <td class=xl12024082 dir=LTR width=68 style='border-top:none;border-left:
  none;width:51pt'>&nbsp;</td>"; */
  
for($i=0;$i<$shade_count;$i++)
 {
  	$sql_sc="select count(*) as cnt from $bai_rm_pj1.store_in where lot_no in ($lot_ref) and ref4=\"".$scount_temp2[$i]."\"";
	$result_sc=mysqli_query($link, $sql_sc) or die("Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row_sc=mysqli_fetch_array($result_sc))
	{
		$count_sc=$row_sc["cnt"];
	}
	echo "<td colspan=1 class=xl6824082 style='height:23.25pt;border-top:1pt solid;'>".$count_sc."</td>";
	echo "<td colspan=1 class=xl6824082 dir=LTR width=68 style='border-top:none;border-left:none;
  width:51pt'>".$shade_group_total[$i]."</td>";
  
 }  
  ?>

  </tr>

 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=80 style='width:60pt'></td>
  <td width=65 style='width:49pt'></td>
  <td width=65 style='width:49pt'></td>
  <td width=68 style='width:51pt'></td>
  <td width=68 style='width:51pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=99 style='width:74pt'></td>
  <td width=77 style='width:58pt'></td>
  <td width=68 style='width:51pt'></td>
  <td width=68 style='width:51pt'></td>
  <td width=68 style='width:51pt'></td>
  <td width=68 style='width:51pt'></td>
  <td width=68 style='width:51pt'></td>
  <td width=68 style='width:51pt'></td>
  <td width=68 style='width:51pt'></td>
 </tr>
 <![endif]>
</table>
</div>
</div>
</div>
</div>

</body>

</html>



<?php

if(isset($_POST['put']) || isset($_POST['confirm']))
{

	$head_check=$_POST['head_check']; // Header Check
	$act_gsm=$_POST['act_gsm'];
	$pur_gsm=$_POST['pur_gsm'];
	$pur_width=$_POST['pur_width'];
	$act_width=$_POST['act_width'];
	$sp_rem=$_POST['sp_rem'];
	$qty_insp=$_POST['qty_insp'];
	$gmt_way=$_POST['gmt_way'];
	$pts=$_POST['pts'];
	$fallout=$_POST['fallout'];
	$skew=$_POST['skew'];
	$skew_cat=$_POST['skew_cat'];
	$shrink_l=$_POST['shrink_l'];
	$shrink_w=$_POST['shrink_w'];
	$supplier=$_POST['supplier'];
	$lot_no_new=trim($_POST['lot_no']); //Batch Number
	$lot_ref=$_POST['lot_ref'];	
	$consumption_ref=$_POST["consumption"];
	
	if($head_check>0)
	{
		$sql="insert ignore into $bai_rm_pj1.inspection_db(batch_ref) values (\"$lot_no_new\")";
		mysqli_query($link, $sql) or exit("Sql Error5=".mysqli_error($GLOBALS["___mysqli_ston"]));
			
		if(mysqli_affected_rows($link))
		{
			//For Total batched inspeciton done in current month.
			$sql="select log_date from $bai_rm_pj1.inspection_db where month(log_date)=".date("m")." and year(log_date)=".date("Y");
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error6=".mysqli_error($GLOBALS["___mysqli_ston"]));
			$count=mysqli_num_rows($sql_result);
		  	  for($i=0;$i<sizeof($suppliers);$i++)
			  {
			  	$x=array();
				$x=explode("$",$suppliers[$i]);
				if($supplier==$x[1] and $x[1]!=0)
				{
					$words = explode(" ", $x[0]);
					$letters = " ";
					foreach ($words as $value) 
					{
						$letters .= substr($value, 0, 1);
					}
					
					//For Total batched inspeciton done in current month for current supplier.
					$sql="select log_date from $bai_rm_pj1.inspection_db where month(log_date)=".date("m")." and year(log_date)=".date("Y")." and unique_id like \"%".strtoupper($letters)."%\"";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error6=".mysqli_error($GLOBALS["___mysqli_ston"]));
					$count2=mysqli_num_rows($sql_result);
					$count=strtoupper($letters)."/".str_pad($count,4,"0",STR_PAD_LEFT)."/".str_pad($count2,3,"0",STR_PAD_LEFT);
				}
				
			  }
		  	$sql="update $bai_rm_pj1.inspection_db set unique_id=\"$count\" where batch_ref=\"$lot_no_new\"";
			mysqli_query($link, $sql) or exit("Sql Error7=".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
		$sql="update $bai_rm_pj1.inspection_db set pur_gsm=\"$pur_gsm\",consumption=\"".$consumption_ref."\",act_gsm=\"$act_gsm\",pur_width=\"$pur_width\",act_width=\"$act_width\",sp_rem=\"$sp_rem\",qty_insp=\"$qty_insp\",gmt_way=\"$gmt_way\",pts=\"$pts\",fallout=\"$fallout\",skew=\"$skew\",skew_cat=\"$skew_cat\",shrink_l=\"$shrink_l\",shrink_w=\"$shrink_w\",supplier=\"$supplier\" where batch_ref=\"$lot_no_new\"";
		// echo "Upadte Qry :".$sql;
		// exit;
		mysqli_query($link, $sql) or exit("Sql Error8=".mysqli_error($GLOBALS["___mysqli_ston"]));
		
	}
	//Update status as 0 to save the Batch details and consider as pending batch at supplier performance report
	$sql="update $bai_rm_pj1.inspection_db set status=0 where batch_ref=\"$lot_no_new\"";
	mysqli_query($link, $sql) or exit("Sql Error7=".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(isset($_POST['confirm']))
	{
		$lot_no_new=trim($_POST['lot_no']); //Batch Number
		//Update status as 1 to confirm the Batch details and the confirmed batch will consider as pass or fail at supplier performance report
		$sql1="update $bai_rm_pj1.inspection_db set status=1 where batch_ref=\"$lot_no_new\"";
		mysqli_query($link, $sql1) or exit("Sql Error8=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	//Status will be 0 either reset or by default, if user update this form. (0- To track as not confirmed by super user and not communicated to front end teams.)
	//Roll updation data
	$ele_tid=$_POST['ele_tid'];
	$ele_check=$_POST['ele_check'];
	$tot_elements=$_POST['tot_elements'];
	$ele_t_length=$_POST['ele_t_length'];
	$ele_c_length=$_POST['ele_c_length'];
	$ele_t_width=$_POST['ele_t_width'];
	$ele_c_width=$_POST['ele_c_width'];	
	$ele_shade=$_POST['ele_shades'];
	$roll_joins=$_POST['ele_c_joins'];
	$roll_status_ref=$_POST["roll_status"];
	$rejection_reason=$_POST['rejection_reason'];
	$partial_rej_qty=$_POST["ele_par_length"];
	$shrinkage_length = $_POST["shrinkage_length"];
	$shrinkage_width = $_POST["shrinkage_width"];
	$shrinkage_group = $_POST["shrinkage_group"];
	$roll_remarks = $_POST["roll_remarks"];

	if(in_array($authorized,$has_permission))
	{
		$ele_shade=$_POST['ele_shade'];
	}
	
	for($i=0;$i<$tot_elements;$i++)
	{	
		if($ele_check[$i]>0)
		{
			$add_query="";
			if(in_array($authorized,$has_permission))
			{
				$add_query=", ref4=\"".$ele_shade[$i]."\"";
			}
			if($partial_rej_qty[$i]>0 and $partial_rej_qty[$i]>$ele_t_length[$i] )// when partial qty rejected then new row is inserted with rejected qty and remaning with approved qty updated
			{
				 $sql= "insert INTO $bai_rm_pj1.store_in ( ref1,lot_no, ref2, qty_issued, qty_ret, DATE, log_user, remarks, log_stamp, STATUS, allotment_status, qty_allocated, upload_file, m3_call_status, split_roll, qty_rec,ref3,ref4, ref5, ref6, shrinkage_length, shrinkage_width,shrinkage_group,roll_joins, roll_status,partial_appr_qty,rejection_reason)
				    select ref1,lot_no, ref2, qty_issued, qty_ret, DATE, log_user, remarks, log_stamp, STATUS, allotment_status, qty_allocated, upload_file, m3_call_status, split_roll,\"".$partial_rej_qty[$i]."\",\"".$ele_c_width[$i]."\",\"".$ele_shade[$i]."\",\"".$ele_c_length[$i]."\",\"".$ele_t_width[$i]."\",\"".$shrinkage_length[$i]."\",\"".$shrinkage_width[$i]."\",\"".$shrinkage_group[$i]."\",\"".$roll_joins[$i]."\",1,0,\"".$rejection_reason[$i]."\"
				  FROM $bai_rm_pj1.store_in WHERE tid=".$ele_tid[$i];
				   mysqli_query($link, $sql) or exit("Sql Error25=".mysqli_error($GLOBALS["___mysqli_ston"]));
					   //
				  	   
				  $qty_rec=$ele_t_length[$i]-$partial_rej_qty[$i];
				  $sql1="update $bai_rm_pj1.store_in set rejection_reason='', qty_rec=\"".$qty_rec."\",shrinkage_length=\"".$shrinkage_length[$i]."\",shrinkage_width=\"".$shrinkage_width[$i]."\",shrinkage_group=\"".$shrinkage_group[$i]."\",roll_remarks='', roll_status=0,partial_appr_qty=0,roll_joins=\"".$roll_joins[$i]."\",ref5=\"".$ele_c_length[$i]."\", ref6=\"".$ele_t_width[$i]."\", ref3=\"".$ele_c_width[$i]."\"$add_query where tid=".$ele_tid[$i];
				 mysqli_query($link, $sql1) or exit("Sql Error9=".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			}
			else
			{
				$sql="update $bai_rm_pj1.store_in set rejection_reason=\"".$rejection_reason[$i]."\", shrinkage_length=\"".$shrinkage_length[$i]."\",shrinkage_width=\"".$shrinkage_width[$i]."\",shrinkage_group=\"".$shrinkage_group[$i]."\",roll_remarks=\"".$roll_remarks[$i]."\", roll_status=\"".$roll_status_ref[$i]."\",partial_appr_qty=\"".$partial_rej_qty[$i]."\",roll_joins=\"".$roll_joins[$i]."\",ref5=\"".$ele_c_length[$i]."\", ref6=\"".$ele_t_width[$i]."\", ref3=\"".$ele_c_width[$i]."\"$add_query where tid=".$ele_tid[$i];
				mysqli_query($link, $sql) or exit("Sql Error9=".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	}

	echo "<h2>Please Wait While Updating Data.</h2>";
	$url = getURL(getBASE($_GET['r'])['base'].'/C_Tex_Interface_V6.php')['url'];
	echo "<script type='text/javascript'>";
	echo "setTimeout('Redirect()',0);";
	echo "var url='".$url."&batch_no=".$lot_no_new."&lot_ref=".$lot_ref."';";
	echo "function Redirect(){location.href=url;}</script>";	
}
?>




<style>
@keyframes blink { 
   50% { border-color: #ff0000; } 
}
.mandate{ /*or other element you want*/
    animation: blink .5s step-end infinite alternate;
	border : 3px solid red;
	border-radius : 2px;
}
</style>
<script>

function enableButton() 
{

	var ele;
	var counter_man = 0;
		ele = document.getElementsByClassName('rej_reason');
		for(var i=0;i<ele.length;i++){
			var v = $('#rejection_reason\\['+i+'\\]');
			v.removeClass('mandate');
			if($('#roll_status\\['+i+'\\]').val() == 1 || $('#roll_status\\['+i+'\\]').val() == 2)
			{
				if(v.val() == '' || v.val().length < 1 )
				{
					v.addClass('mandate');
					counter_man++;
				}
				if($('#roll_status\\['+i+'\\]').val() == 2){
					var v = $('#ele_par_length\\['+i+'\\]');

				
					if(v.val() == 0){
					v.addClass('mandate');
						
						counter_man++;
					}
				}
			}

		}

		if(counter_man > 0)
		{
			counter_man = 0;
			sweetAlert('Please Fill below fields having red box','','warning');
			document.getElementById('put').disabled = 'true';
			document.getElementById('option').checked = false;
			return;
		}

	if(document.getElementById('option').checked)
	{
		document.getElementById('put').disabled='';
		
	} 
	else 
	{
		document.getElementById('put').disabled='true';
	}
}

function enableButton1() 
{
    var rowcount = document.getElementById("rowcount").value;
 
	    if (document.getElementById('option1').checked)
	    {
	        document.getElementById('confirm').disabled = '';

	    } 
	    else 
	    {
	        document.getElementById('confirm').disabled = 'true';
	    }
	    var j = 0;

	    for (var i = 0; i < rowcount; i++) 
	    {
			//removed this validation on the request of chathurangad 
	        // if (parseFloat(document.input["ele_c_length[" + i + "]"].value) > 0) 
	        // {
	        //     j = j + 0;
	        // }
	        // else 
	        // {
	        //     j = j + 1;
	        // }

	        if (parseInt((document.input["ele_shade[" + i + "]"].value).length) > 0) 
	        {
	            j = j + 0;
	        } 
	        else
	        {
	        	if($('input[name="ele_shade[' + i + ']"]').is('[readonly]'))
	        	{
	    		 	j = j + 0;
	    		}
	    		 else
	        	{
	        		j = j + 1;
	        	}
	        }
	       
	        // if (parseFloat(document.input["ele_c_width[" + i + "]"].value) > 0) 
	        // {
	        //     j = j + 0;
	        // } 
	        // else 
	        // {
	        //     j = j + 1;
	        // }
	        var roll_status = document.input["roll_status[" + i + "]"].value;
	        if ((Number(roll_status)==1 || Number(roll_status)==2) )
	        {
	        	var rejection_reason = document.input["rejection_reason[" + i + "]"].value;
	        	if(rejection_reason!='NIL')
	        	{
	            	j = j + 0;
		        } 
		        else 
		        {
		            j = j + 1;
		        }
	        }
	    }
	    if (parseInt(j) > 0) 
	    {
	        document.getElementById('confirm').disabled = 'true';
	        sweetAlert('Please Fill All The Required Fields Before You Confirm','','warning');
	        document.getElementById('option1').checked = false;
	    }
		
		var counter_man = 0;
		//removed this validation on the request of chathurangad ctex_len,ticket_wid,ctex_wid
		var classes = ['req_man','par_rej','shr_len','shr_wid','shr_grp','el_joins'];
		var ele;
		for(var j=0;j<classes.length;j++){
			var ele = document.getElementsByClassName(classes[j]);
			for(var i=0;i<ele.length;i++)
			{
				ele[i].classList.remove('mandate');
				if(ele[i].value == '' || ele[i].value.length < 1 )
				{
				    ele[i].classList.add('mandate');
					counter_man++;
				}
			}
		}
		ele = document.getElementsByClassName('rej_reason');
		for(var i=0;i<ele.length;i++){
			var v = $('#rejection_reason\\['+i+'\\]');
			v.removeClass('mandate');
			if($('#roll_status\\['+i+'\\]').val() == 1 )
			{
				if(v.val() == '' || v.val().length < 1 )
				{
					v.addClass('mandate');
					counter_man++;
				}
			}
		}
		shade_grp = document.getElementsByClassName('shade_grp');
		for(var i=0;i<shade_grp.length;i++){
			var v = $('#ele_shade\\['+i+'\\]');

			v.removeClass('mandate');
			if($.trim($('#ele_shade\\['+i+'\\]').val()) == '')
			{
				if($('input[name="ele_shade[' + i + ']"]').is('[readonly]'))
				{
					v.removeClass('mandate');
				}
				else
				{
					v.addClass('mandate');
					counter_man++;
				}
			}
		}

		if(counter_man > 0)
		{
			counter_man = 0;
			sweetAlert('Please Fill All The Required Fields box Before You Confirm!','','warning');
			document.getElementById('confirm').disabled = 'true';
			document.getElementById('option1').checked = false;
		}
	// }

}



function Subtract(qnty) 
{
	var ele_c_length = document.getElementById('ele_c_length'+qnty).value;
	var ele_t_length = document.getElementById('ele_t_length'+qnty).value;
	var result1 = (ele_c_length) - (ele_t_length);
	if(isNaN(result1))
	{
		result1=0;
	}
	document.getElementById('subt'+qnty).value = result1.toFixed(2);
}

function minus(qnty) 
{
	var ele_c_width = document.getElementById('ele_c_width'+qnty).value;
	var ele_t_width = document.getElementById('ele_t_width'+qnty).value;
	var result1 = (ele_c_width) - (ele_t_width);
	if(isNaN(result1))
	{
		result1=0;
	}
	document.getElementById('min'+qnty).value = result1.toFixed(2);
}

function fill(x,t,e)
{

	var tot_elements=document.getElementById('tot_elements').value;

	if(x==1)
	{
		var y=document.getElementById('fill_c_length').value;
		if(y!= ''){
			var name="ele_c_length[";
			var name2="qty_allocated[";
			for (var i=0; i < tot_elements; i++)
			{
				if(document.input[name2+i+"]"].value > 0)
				{

				}
				else
				{
					document.input[name+i+"]"].value=y;
					document.input["ele_check["+i+"]"].value=1;
					document.input[name+i+"]"].style.background="#FFCCFF";

					var ele_t_length = document.getElementById('ele_t_length'+i).value;
					var result1 = parseInt(y) - parseInt(ele_t_length);
					if(isNaN(result1))
					{
						result1=0;
					}
					document.getElementById('subt'+i).value = result1;
				}
				
			}
		}else {
			swal('Please enter c-tex length to auto fill.');
		}
	}
	if(x==2)
	{
		var y=document.getElementById('fill_t_width').value;
		if(y!= ''){
			var name="ele_t_width[";
			var name2="qty_allocated[";
			for (var i=0; i < tot_elements; i++)
			{
				if(document.input[name2+i+"]"].value > 0)
				{

				}
				else
				{
					document.input[name+i+"]"].value=y;
					document.input["ele_check["+i+"]"].value=1;
					document.input[name+i+"]"].style.background="#FFCCFF";

					var ele_c_width = document.getElementById('ele_c_width'+i).value;
					var result1 = parseInt(ele_c_width) - parseInt(y);
					if(isNaN(result1))
					{
						result1=0;
					}
					document.getElementById('min'+i).value = result1;
				}
			}
		}else{
			swal('Please enter ticket width to auto fill.');
		}
	}
	if(x==3)
	{
		var y=document.getElementById('fill_c_width').value;
		if(y!= ''){
			var name="ele_c_width[";
			var name2="qty_allocated[";
			for (var i=0; i < tot_elements; i++)
			{
				if(document.input[name2+i+"]"].value > 0)
				{

				}
				else
				{
					document.input[name+i+"]"].value=y;
					document.input["ele_check["+i+"]"].value=1;
					document.input[name+i+"]"].style.background="#FFCCFF";

					var ele_t_width = document.getElementById('ele_t_width'+i).value;
					var result1 = parseInt(y) - parseInt(ele_t_width);
					if(isNaN(result1))
					{
						result1=0;
					}
					document.getElementById('min'+i).value = result1;
				}
			}
		}else{
			swal('Please enter c-tex width to auto fill.');
		}	
	}
	if(x==4)
	{
		var y=document.getElementById('fill_shade_grp').value;
		if(y != ''){
			var name1="ele_shade[";
			var name2="qty_allocated[";

			for (var i=0; i < tot_elements; i++)
			{
				if(document.input[name2+i+"]"].value > 0){

				}
				else
				{
					document.input[name1+i+"]"].value=y;
					document.input["ele_check["+i+"]"].value=1;
					document.input[name1+i+"]"].style.background="#FFCCFF";
				}
			

				// var fill_shade_grp = document.getElementById('ele_t_width'+i).value;
				// var result1 = parseInt(y) - parseInt(ele_t_width);
				// if(isNaN(result1))
				// {
				// 	result1=0;
				// }
				// document.getElementById('min'+i).value = result1;
			}	
		}else{
			swal('Please enter shade group to auto fill.');
		}
	}		
}

function change_body(x,y,z)
{
	if(document.getElementById('roll_status['+z+']').value == 1){
		document.getElementById('ele_par_length['+z+']').readOnly = true;
	}
	if(document.getElementById('roll_status['+z+']').value != 1){
		document.getElementById('ele_par_length['+z+']').readOnly = false;
	}
	
	document.input["ele_check["+z+"]"].value=1;
	document.getElementById(y).style.background="#FFCCFF";

	if(!isNaN(document.input["ele_c_length["+z+"]"].value))
	{
		document.input["ele_c_length["+z+"]"].value=document.input["ele_c_length["+z+"]"].value;	
	}
	else
	{
		
		sweetAlert('Please Enter Correct Value','','warning');
		document.input["ele_c_length["+z+"]"].value=0;
	}

	if (document.input["roll_status["+z+"]"].value == 2)
	{
		
		if(parseFloat(document.input["ele_t_length["+z+"]"].value) > parseFloat(document.input["ele_par_length["+z+"]"].value))
		{
			document.input["ele_par_length["+z+"]"].value=document.input["ele_par_length["+z+"]"].value;
		}
		else
		{
			sweetAlert('Rejected Quantity Exceeded The Ticket Length Quantity',' Please Enter Correct Qty','warning');
			document.input["ele_par_length["+z+"]"].value="0.00";
		}
	}else
	{
		if(parseFloat(document.input["ele_par_length["+z+"]"].value) > 0)
		{	
			sweetAlert('You Cant Provide Partial Quantity','','warning');
			document.input["ele_par_length["+z+"]"].value="0.00";
		}
	}

	if(document.input["roll_status["+z+"]"].value )
	{
		var dropdown = document.getElementById("roll_status["+z+"]");
		var current_value = dropdown.options[dropdown.selectedIndex].value;


		if (current_value == '1' || current_value == '2') 
		{
			document.getElementById("rejection_reason["+z+"]").style.display = "block";
		}
		else 
		{
			document.getElementById("rejection_reason["+z+"]").style.display = "none";
		}
	}
}
function validate_unique_shade(shde, roll, index)
{
	var ele_shade = $('#ele_shade\\['+index+'\\]');
	var ele_shade1 = document.input["ele_shade["+index+"]"].value;
	if($.trim($('#ele_shade\\['+index+'\\]').val()) == ''){
		sweetAlert('Please Enter Shade Group','','warning');
		document.input["ele_shade["+index+"]"].style.background="#99ff88";
		
	}
	console.log('ele_shade['+index+']');
	var arr = new Array();
	$('.unique_shade_'+roll).each(function(){
		if($(this).val() != ''){
			arr.push($(this).val().toUpperCase());
		}
	});
	if(arr.length > 0){
		var unique_elem = $.unique(arr);
		if(unique_elem.length > 1){
			ele_shade.val('');
			swal('Roll Number and shade group should be unique.');
		}else{
			return true;
		}
		console.log(arr);
		console.log($.unique(arr));
	}
	
	// alert();
}
function change_head(x,y)
{
	document.getElementById('head_check').value=1;
	document.getElementById(y).style.background="#FFCCFF";

}

</script>