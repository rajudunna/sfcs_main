<style>

@media print {
    @page { margin: 0; }
@page narrow {size: 9in 11in}
@page rotated {size: landscape}
DIV {page: narrow}
TABLE {page: rotated}
#non-printable { display: none; }
#printable { display: block; }
#logo { display: block; }
body { zoom:72%;}
#ad{ display:none;}
#leftbar{ display:none;}
#CUT_PLAN_NEW_13019{ width:57%; margin-left:20px;}
}
</style>
<?php 
error_reporting(0);
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions.php");

 ?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 14">
<link rel=File-List href="C_Tex_Interface_files/filelist.xml">


<title>Fabric Inspection : C-Tex Report</title>



<style id="C_Tex_Interface_24082_Styles">

<!--table
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
	
.xl9324082x
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
	text-align:right;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
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
	
.xl12524082x
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:500;
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}

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
-->
</style>


<style type="text/css">
@page
{
	size: landscape;
	margin: 0cm;
}
</style>

<style>

@media print {
	thead
        {
            display: table-header-group;
        }
        tfoot
        {
            display: table-footer-group;
        }
	@page narrow {size: 15in 11in}
	@page rotated {size: PORTRAIT}
	DIV {page: narrow}
	TABLE {page: rotated}
	#non-printable { display: none; }
	#printable { display: block; }
	#logo { display: block; }
	body { zoom:75%;}
	#ad{ display:none;}
	#leftbar{ display:none;}
	#DOCKET_NEW_4118{ width:80%; margin-left:2px; margin-right:2px;}
}

</style>
</head>
<script>
function printpr()
{
	window.print();
	// var OLECMDID = 7;
	// /* OLECMDID values:
	// * 6 - print
	// * 7 - print preview
	// * 1 - open window
	// * 4 - Save As
	// */
	// var PROMPT = 1; // 2 DONTPROMPTUSER
	// var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
	// document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
	// WebBrowser1.ExecWB(OLECMDID, PROMPT);
	// WebBrowser1.outerHTML = "";
   
}
</script>
<body onload="printpr();">


<?php


	if(isset($_POST['submit']))
	{
		$lot_no=$_POST['lot_no'];
	}
	else
	{
		$parent_id=$_GET['parent_id'];
		$plantcode = $_GET['plant_code'];
		$username = $_GET['username'];

		$lot = array();
		$get_details = "select distinct(lot_no),supplier_batch from $wms.inspection_population where plant_code='$plantcode' and parent_id='$parent_id'";
	    //echo $get_details;
	    $sql_result=mysqli_query($link, $get_details) or exit("Sql Error41".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
		  $lot[] = $sql_row['lot_no'];
		  $batch[] = $sql_row['supplier_batch'];
		}

		$lot_no=implode(",",$batch);
		$lot_ref=implode(",",$lot);
	}
	
?>


<?php
if(strlen($lot_no)>0 and strlen($lot_ref)>0)
{

$sql="select *, SUBSTRING_INDEX(buyer,\"/\",1) as \"buyer_code\", group_concat(distinct item SEPARATOR ', ') as \"item_batch\",group_concat(distinct pkg_no) as \"pkg_no_batch\",group_concat(distinct po_no) as \"po_no_batch\",group_concat(distinct inv_no) as \"inv_no_batch\", group_concat(distinct lot_no SEPARATOR ',') as \"lot_ref_batch\", group_concat(distinct batch_no) as \"batch_no\", count(distinct lot_no) as \"lot_count\", sum(rec_qty) as \"rec_qty1\" from $wms.sticker_report where plant_code='$plantcode' and lot_no in ("."'".str_replace(",","','",$lot_ref)."'".") and right(lot_no,1)<> 'R' and batch_no in ("."'".str_replace(",","','",$lot_no)."'".")";
// echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Errorb".mysqli_error($GLOBALS["___mysqli_ston"]));
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
	$pkg_no=$sql_row['pkg_no'];
	$grn_date=$sql_row['grn_date'];
	$lot_ref_batch=$sql_row['lot_ref_batch'];
	$lot_count=$sql_row['lot_count'];
	$buyer_code=$sql_row['buyer_code'];
	$supplier_ref_name=$sql_row['supplier'];
	
	//NEW SYSTEM IMPLEMENTATION RESTRICTION
	$new_ref_date=substr($grn_date,0,4)."-".substr($grn_date,4,2)."-".substr($grn_date,6,2);
	// if($new_ref_date>"2011-05-12")
	// {
		
	// }
	// else
	// {

	// }
	//NEW SYSTEM IMPLEMENTATION RESTRICTION
}

$sql="select * from $wms.inspection_db where plant_code='$plantcode' and batch_ref in ("."'".str_replace(",","','",$lot_no)."'".") ";
$sql_result=mysqli_query($link, $sql) or exit("Sql Errora".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$act_gsm=$sql_row['act_gsm'];
	$pur_width=$sql_row['pur_width'];
	$act_width=$sql_row['act_width'];
	$sp_rem=$sql_row['sp_rem'];
	//$qty_insp=$sql_row['qty_insp'];
	$gmt_way=$sql_row['gmt_way'];
	$pts=$sql_row['pts'];
	$fallout=$sql_row['fallout'];
	$skew=$sql_row['skew'];
	$consumption=$sql_row['consumption'];
	$skew_cat=$sql_row['skew_cat'];
	$shrink_l=$sql_row['shrink_l'];
	$shrink_w=$sql_row['shrink_w'];
	$supplier=$sql_row['supplier'];
	$code=date("ymd",strtotime($sql_row['log_date']))."/$buyer_code/".$sql_row['unique_id'];
}

//Configuration 
// added South asia in suppliers list

include("../common/php/supplier_db.php"); 


$values=array();
$scount_temp=array();
$ctex_sum=0;
$avg_t_width=0;
$avg_c_width=0;

$get_roll_details = "select distinct(store_in_id) as roll_numbers,item_name,item_desc,item_code from $wms.inspection_population where plant_code='$plantcode' and parent_id=$parent_id and lot_no in ("."'".str_replace(",","','",$lot_ref_batch)."'".")";
// echo $get_roll_details;
$roll_details_result=mysqli_query($link, $get_roll_details) or exit("roll details error=".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rolls=mysqli_fetch_array($roll_details_result))
{
  $rolls[]=$sql_rolls['roll_numbers'];
  $item_name=$sql_rolls['item_name'];
  $item_desc=$sql_rolls['item_desc'];
  $item_code=$sql_rolls['item_code'];
}
$roll_num = implode(",",$rolls);
$sql="select * from $wms.store_in where plant_code='$plantcode' and lot_no in ("."'".str_replace(",","','",$lot_ref_batch)."'".") and tid in ("."'".str_replace(",","','",$roll_num)."'".") order by tid,ref2";
//echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Errorc".mysqli_error($GLOBALS["___mysqli_ston"]));
$num_rows=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$values[]=$sql_row['tid']."~".$sql_row['ref2']."~".$sql_row['ref4']."~".$sql_row['qty_rec']."~".$sql_row['ref5']."~".$sql_row['ref6']."~".$sql_row['ref3']."~".$sql_row['lot_no']."~".$sql_row["roll_joins"]."~".$sql_row["partial_appr_qty"]."~".$sql_row["roll_status"]."~".$sql_row["shrinkage_length"]."~".$sql_row["shrinkage_width"]."~".$sql_row["shrinkage_group"]."~".$sql_row["roll_remarks"]."~".$sql_row["rejection_reason"]."~".$sql_row["shade_grp"];
//tid,rollno,shade,tlenght,clenght,twidth,cwidth,lot_no
	
	$scount_temp[]=$sql_row['ref4'];
	$ctex_sum+=$sql_row['ref5'];
	$avg_t_width+=$sql_row['ref6'];
	$avg_c_width+=$sql_row['ref3'];
	$rec_qty1+= ($sql_row['qty_rec']);
}
sort($scount_temp); //to sort shade groups
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

//get inspected_qty
$get_inspected_qty = "select sum(inspected_qty) as reported_qty from $wms.roll_inspection_child where plant_code='$plantcode' and store_in_tid in ("."'".str_replace(",","','",$roll_num)."'".") and parent_id=$parent_id";
$inspected_qty_result=mysqli_query($link, $get_inspected_qty) or exit("Sql Errorqty=".mysqli_error($GLOBALS["___mysqli_ston"]));
while($qty_row=mysqli_fetch_array($inspected_qty_result))
{
   $qty_insp = $qty_row['reported_qty'];
}

$sql="select COUNT(ref2)  as \"count\" from $wms.store_in where plant_code='$plantcode' and lot_no in ("."'".str_replace(",","','",$lot_ref_batch)."'".") and tid in ("."'".str_replace(",","','",$roll_num)."'".") order by tid";
$sql_result=mysqli_query($link, $sql) or exit("Sql Errord".mysqli_error($GLOBALS["___mysqli_ston"]));
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
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->

<div id="C_Tex_Interface_24082" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=1126 class=xl11024082 style='border-collapse:collapse;table-layout:fixed;width:970pt'>
 <col class=xl11024082 width=80 style='mso-width-source:userset;mso-width-alt:
 2925;width:60pt'>
 <col class=xl11024082 width=65 span=2 style='mso-width-source:userset;
 mso-width-alt:2377;width:49pt'>
 <col class=xl12124082 width=68 style='mso-width-source:userset;mso-width-alt:
 2486;width:51pt'>
 <col class=xl11024082 width=68 style='mso-width-source:userset;mso-width-alt:
 2486;width:51pt'>
 <col class=xl11024082 width=64 span=2 style='mso-width-source:userset;
 mso-width-alt:2340;width:48pt'>
 <col class=xl11024082 width=99 style='mso-width-source:userset;mso-width-alt:
 3620;width:74pt'>
 <col class=xl11024082 width=77 style='mso-width-source:userset;mso-width-alt:
 2816;width:58pt'>
 <col class=xl11024082 width=68 span=7 style='mso-width-source:userset;
 mso-width-alt:2486;width:51pt'>
 <tr height=25 style='mso-height-source:userset;height:18.75pt'>
  <td colspan=10 height=25 class=xl12524082 dir=LTR width=1126
  style='height:18.75pt;width:845pt'><a name="RANGE!A1:P19">Color
  Classification Report - Roll Details</a></td>
  <td colspan=6 height=25 class=xl12524082x dir=LTR width=1126
  style='height:18.75pt;width:845pt'><?php echo $code; ?></td>
 </tr>
 <tr height=26 style='mso-height-source:userset;height:20.1pt'>
  <td height=26 class=xl9524082 dir=LTR width=80 style='height:20.1pt;
  width:60pt'>Item Code<span style='mso-spacerun:yes'></span></td>
  <td colspan=2 class=xl9624082 dir=LTR width=130 style='border-left:none;
  width:98pt'><?php echo $item; ?></td>
  <td colspan=2 rowspan=1 class=xl9624082 dir=LTR width=136 style='width:102pt'>Fabric
  Description</td>
  <td colspan=5 rowspan=1 class=xl9624082 dir=LTR width=372 style='width:279pt'><?php echo $item_name; ?></td>
  <td colspan=2 class=xl9624082 dir=LTR width=136 style='border-left:none;
  width:102pt'>Batch No</td>
  <td colspan=4 class=xl9624082 dir=LTR width=272 style='border-right:1.0pt solid black;
  border-left:none;width:204pt'><?php echo wordwrap($batch_no,30,"<br>\n",TRUE); ?></td>
 </tr>
 <tr height=26 style='mso-height-source:userset;height:20.1pt'>
  <td height=26 class=xl9724082 dir=LTR width=80 style='height:20.1pt;
  border-top:none;width:60pt'>Buyer</td>
  <td colspan=9 class=xl9324082 dir=LTR style='border-left:none;'><?php echo $buyer; ?></td>
  <td colspan=2 class=xl9324082 dir=LTR width=136 style='border-left:none;
  width:102pt'>Lot No</td>
  <td colspan=4 class=xl9624082 style='border-right:1.0pt solid black;
  border-bottom:.5pt solid black;border-left:none'><?php echo wordwrap($lot_ref_batch,30,"<br>\n",TRUE); ?></td>
 </tr>
 <tr height=26 style='mso-height-source:userset;height:20.1pt'>
  <td height=26 class=xl9724082 dir=LTR width=80 style='height:20.1pt;
  border-top:none;width:60pt'>Consumption<span style='mso-spacerun:yes'></span></td>
  <td colspan=2 class=xl9324082 dir=LTR width=130 style='border-left:none;
  width:98pt'><?php echo $consumption; ?></td>
  <td colspan=7 class=xl12224082 style='border-right:.5pt solid black;
  border-left:none'>Inspection Summary</td>
  <td colspan=2 class=xl9324082 dir=LTR width=136 style='border-left:none;
  width:102pt'>Supplier</td>
  <td colspan=2 class=xl9324082 dir=LTR width=272 style='border-right:1.0pt solid black;
  border-left:none;width:204pt'>
  <?php
 echo $supplier_ref_name;
//   for($i=0;$i<sizeof($suppliers);$i++)
//   {
//   	$x=array();
// 	$x=explode("$",$suppliers[$i]);
// 	if($supplier==$x[1])
// 	{
// 		echo $x[0];
// 	}
	
//   }

  ?>
  
  </td>
  <td colspan=2 rowspan=5 class=xl9324082x dir=LTR width=272 style='border-right:1.0pt solid black;
  border-left:none;width:204pt'>FABRIC SWATCH
  </td>
 </tr>
 <tr height=26 style='mso-height-source:userset;height:20.1pt'>
  <td height=26 class=xl9724082 dir=LTR width=80 style='height:20.1pt;
  border-top:none;width:60pt'>Color</td>
  <td colspan=2 class=xl9324082 dir=LTR width=130 style='border-left:none;
  width:98pt'><?php echo $item_desc; ?></td>
  <td colspan=2 class=xl9324082 dir=LTR width=136 style='border-left:none;
  width:102pt'>Qty In (<?php echo $fab_uom; ?>)</td>
  <td colspan=2 class=xl10324082 dir=LTR width=128 style='border-right:.5pt solid black;
  border-left:none;width:96pt'><?php echo round($rec_qty1,2); ?></td>
  <td class=xl9424082 dir=LTR width=99 style='border-top:none;border-left:none;
  width:74pt'>PTS/100 Sq.Yd.</td>
  <td colspan=2 class=xl10324082 dir=LTR width=145 style='border-right:.5pt solid black;
  width:109pt'><?php echo $pts; ?></td>
  <td colspan=2 class=xl9324082 dir=LTR width=136 style='border-left:none;
  width:102pt'>Package</td>
  <td colspan=2 class=xl9324082 dir=LTR width=272 style='border-right:1.0pt solid black;
  border-left:none;width:204pt'><?php echo $pkg_no; ?></td>
 </tr>
 <tr height=26 style='mso-height-source:userset;height:20.1pt'>
  <td height=26 class=xl9724082 dir=LTR width=80 style='height:20.1pt;
  border-top:none;width:60pt;'>PO Number</td>
  <td colspan=2 class=xl9324082 dir=LTR width=130 style='border-left:none;
  width:98pt;word-break: break-all;'><?php echo $po_no; ?></td>
  <td colspan=2 class=xl9324082 dir=LTR width=136 style='border-left:none;
  width:102pt'>Qty Inspected</td>
  <td colspan=2 class=xl10524082 dir=LTR width=128 style='border-right:.5pt solid black;
  border-left:none;width:96pt'><?php echo $qty_insp; ?></td>
  <td class=xl9424082 dir=LTR width=99 style='border-top:none;border-left:none;
  width:74pt'>Fallout</td>
  <td colspan=2 class=xl10324082 dir=LTR width=145 style='border-right:.5pt solid black;
  width:109pt'><?php echo $fallout; ?></td>
  <td colspan=2 class=xl9324082 dir=LTR width=136 style='border-left:none;
  width:102pt'>Act. GSM</td>
  <td colspan=2 class=xl9324082 dir=LTR width=272 style='border-right:1.0pt solid black;
  border-left:none;width:204pt'><?php echo $act_gsm; ?></td>
 </tr>
 <tr height=26 style='mso-height-source:userset;height:20.1pt'>
  <td height=26 class=xl9724082 dir=LTR width=80 style='height:20.1pt;
  border-top:none;width:60pt'>GRN Date</td>
  <td colspan=2 class=xl9324082 dir=LTR width=130 style='border-left:none;
  width:98pt'><?php echo $grn_date; ?></td>
  <td colspan=2 class=xl9324082 dir=LTR width=136 style='border-left:none;
  width:102pt'>Pct Inspected</td>
  <td colspan=2 class=xl10724082 dir=LTR width=128 style='border-right:.5pt solid black;
  border-left:none;width:96pt'><?php echo round(($qty_insp/$rec_qty)*100,2)."%"; ?></td>
  <td class=xl9424082 dir=LTR width=99 style='border-top:none;border-left:none;
  width:74pt'><?php 
 

 if($skew_cat==1)
 {
 	echo "Skewness";
 }
 
 if($skew_cat==2)
 {
 	echo "Bowing";
 }
 
 if($skew_cat=="" or $skew_cat==0)
 {
 	echo "";
 }
 
   
    ?></td>
  <td colspan=2 class=xl9424082 dir=LTR width=145 style='border-right:.5pt solid black;
  width:109pt'><?php echo $skew; ?></td>
  <td colspan=2 class=xl9324082 dir=LTR width=136 style='border-left:none;
  width:102pt'>Purchase Width</td>
  <td colspan=2 class=xl9324082 dir=LTR width=272 style='border-right:1.0pt solid black;
  border-left:none;width:204pt'><?php echo $pur_width; ?></td>
 </tr>
 <tr height=26 style='mso-height-source:userset;height:20.1pt'>
  <td height=26 class=xl9724082 dir=LTR width=80 style='height:20.1pt;
  border-top:none;width:60pt'>No of rolls</td>
  <td colspan=2 class=xl9324082 dir=LTR width=130 style='border-left:none;
  width:98pt'><?php echo $total_rolls; ?></td>
  <td colspan=2 class=xl9324082 dir=LTR width=136 style='border-left:none;
  width:102pt'>Length Short %</td>
  <td colspan=2 class=xl9424082 dir=LTR width=128 style='border-right:.5pt solid black;
  border-left:none;width:96pt'><?php echo round((($ctex_sum-$rec_qty)/$rec_qty)*100,2)."%";  ?></td>
  <td rowspan=2 class=xl11224082 width=99 style='border-bottom:1.0pt solid black;
  border-top:none;width:74pt'>Residual Shrinkage</td>
  <td class=xl9324082 dir=LTR width=77 style='border-top:none;border-left:none;
  width:58pt'>L%</td>
  <td class=xl9424082 dir=LTR width=68 style='border-top:none;border-left:none;
  width:51pt'>W%</td>
  <td colspan=2 class=xl9324082 dir=LTR width=136 style='width:102pt'>Actual
  Width</td>
  <td colspan=2 class=xl13524082 dir=LTR width=272 style='border-right:1.0pt solid black;
  border-left:none;width:204pt'><?php echo $act_width; ?></td>
 </tr>
 <tr height=26 style='mso-height-source:userset;height:20.1pt'>
  <td height=26 class=xl9824082 dir=LTR width=80 style='height:20.1pt;
  border-top:none;width:60pt'>Category</td>
  <td colspan=2 class=xl11324082 style='border-left:none'><?php echo $category; ?></td>
  <td colspan=2 class=xl9924082 dir=LTR width=136 style='border-left:none;
  width:102pt'>Fabric Way</td>
  <td colspan=2 class=xl11424082 style='border-right:.5pt solid black;
  border-left:none'><?php 
 
 
 if($gmt_way==1)
 {
 	echo "N/A";
 }
 
 if($gmt_way==2)
 {
 	echo "One Way";
 }
 
 if($gmt_way==3)
 {
 	echo "Two Way";
 }
 
 if($gmt_way=="" or $gmt_way==0)
 {
 	echo "";
 }
 
   
    ?></td>
  <td class=xl11324082 style='border-top:none;border-left:none'><?php echo $shrink_l; ?></td>
  <td class=xl11424082 style='border-top:none;border-left:none'><?php echo $shrink_w; ?></td>
  <td colspan=2 class=xl11324082>Invoice</td>
  <td colspan=4 class=xl9624082 style='border-right:1.0pt solid black;word-break: break-all;'><?php echo $inv_no; ?></td>
 </tr>
 
 
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl6324082 dir=LTR width=80 style='height:15.75pt;
  width:60pt'>&nbsp;</td>
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
 
 </table>

 <table border=1 cellpadding=0 cellspacing=0 width=1126 class=xl11024082 style='border-collapse:collapse;table-layout:fixed;width:1050pt'>

  <tr height=41 style='height:30.75pt'>
  <td height=41 class=xl12524082x dir=LTR width=80 style='height:30.75pt;
  width:60pt'>Item Name</td>
  <td class=xl12524082x dir=LTR width=65 style='border-left:none;width:49pt'>Item Description
  </td>
  <td class=xl12524082x dir=LTR width=65 style='border-left:none;width:49pt'>Item Code</td>
 </tr>
 <?php
  echo "
  <tr height=41 style='height:30.75pt'>
  <td class=xl12524082x style='border-left:none'>".$item_name."</td>
  <td class=xl12524082x style='border-left:none'>".$item_desc."</td>
  <td class=xl12524082x style='border-left:none'>".$item_code."</td>
  </tr>";
 ?>

 </table>

 <table border=0 cellpadding=0 cellspacing=0 width=1126 class=xl11024082 style='border-collapse:collapse;table-layout:fixed;width:1050pt'>
<tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl6324082 dir=LTR width=80 style='height:15.75pt;
  width:60pt'>&nbsp;</td>
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
 <tr height=41 style='height:30.75pt'>
  <td height=41 class=xl13224082 dir=LTR width=80 style='height:30.75pt;
  width:60pt'>Roll No</td>
  <td class=xl13324082 dir=LTR width=65 style='border-left:none;width:49pt'>Shade
  </td>
  <td class=xl13324082 dir=LTR width=65 style='border-left:none;width:49pt'>Shade
  Group</td>
  <td class=xl13324082 dir=LTR width=65 style='border-left:none;width:49pt'>Ticket
  Length</td>
  <td class=xl13324082 dir=LTR width=68 style='border-left:none;width:51pt'>C-TEX
  Length</td>
  <td class=xl13324082 dir=LTR width=68 style='border-left:none;width:51pt'>Length
  Deviation</td>
  <td class=xl13324082 dir=LTR width=64 style='border-left:none;width:48pt'>Ticket
  Width</td>
  <td class=xl13324082 dir=LTR width=64 style='border-left:none;width:48pt'>C-TEX
  Width</td>
  <td class=xl13324082 dir=LTR width=68 style='border-left:none;width:51pt'>No<br>of Joins</td>
  <td class=xl13324082 dir=LTR width=99 style='border-left:none;width:74pt'>Width  Deviation</td>
  <td class=xl13324082 dir=LTR colspan=2 width=77 style='border-left:none;width:58pt'>Lot  No</td>
  <?php
 // if($shrinkage_inspection == 'yes')
	  { ?>
  <td class=xl13324082 dir=LTR width=68 style='border-left:none;width:51pt'>Shrinkage  Length</td>
  <td class=xl13324082 dir=LTR width=68 style='border-left:none;width:51pt'>Shrinkage  Width</td>
  <td class=xl13324082 dir=LTR width=68 style='border-left:none;width:51pt'>Shrinkage  Group</td>
  <?php } ?>
  <td class=xl13324082 dir=LTR colspan=6 width=68 style='border-left:none;width:51pt'>Roll Remarks</td>
  <td class=xl13324082 dir=LTR colspan=14 width=68 style='border-left:none;width:130pt'>Rejection Reason</td>
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
	
	//For Showing Issued Details in Report
$doc_db=array();
$recut_doc_db=array();
$qty=array();
$sql="select cutno, round(sum(qty_issued),2) as material_req from $wms.store_out where plant_code='$plantcode' and tran_tid=\"".$temp[0]."\" and length(cutno)>0 group by cutno";
$sql_result=mysqli_query($link, $sql) or exit("Sql Errore".mysqli_error($GLOBALS["___mysqli_ston"]));
$num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{	

	if(strtolower(substr($sql_row['cutno'],0,1))=="d" or strtolower(substr($sql_row['cutno'],0,1))=="e")
	{
		$doc_db[]=substr($sql_row['cutno'],1);
		$qty[]=$sql_row['material_req'];
	}
	else
	{
		$recut_doc_db[]="'".substr($sql_row['cutno'],1)."'";
		$qty[]=$sql_row['material_req'];
	}
}

if($num_check>0)
{
	$schedule=array();
	$job=array();
	
	if(sizeof($doc_db)>0)
	{
		$sql="select material_req,order_del_no,color_code,acutno from $bai_pro3.order_cat_doc_mk_mix where doc_no in (".implode(",",$doc_db).")";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Errorf".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$schedule[]=$sql_row['order_del_no'];
			$job[]=chr($sql_row['color_code']).$sql_row['acutno'];
		}
	}
	
	if(sizeof($recut_doc_db)>0)
	{
		$sql="select material_req,order_del_no,color_code,acutno from $bai_pro3.order_cat_recut_doc_mk_mix where doc_no in (".implode(",",$recut_doc_db).")";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Errorg".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$schedule[]=$sql_row['order_del_no'];
			$job[]="R".$sql_row['acutno'];
		}
	}
		
}
	//For Showing Issued Details in Report
	
	  echo "<td height=20 class=xl12824082 style='height:25pt'>".$temp[1]."</td>
	  <td class=xl12824082 style='border-left:none'>".$temp[2]."</td>
	  <td class=xl12824082 style='border-left:none'>".$temp[16]."</td>
	  <td class=xl12824082 style='border-left:none'>".$temp[3]."</td>
	  <td class=xl12824082 style='border-left:none'>".$temp[4]."</td>
	  <td class=xl12824082 style='border-left:none'>".round(($temp[4]-$temp[3]),2)."</td>
	  <td class=xl12824082 style='border-left:none'>".$temp[5]."</td>
	  <td class=xl12824082 style='border-left:none'>".$temp[6]."</td>
	  <td class=xl12824082 style='border-left:none'>".$temp[8]."</td>
	  <td class=xl12824082 style='border-left:none'>".round(($temp[6]-$temp[5]),2)."</td>
	  <td class=xl12824082 colspan=2 align=right style='border-left:none'>".$temp[7]."</td>";
	 // if($shrinkage_inspection == 'yes')
	 // {
	  echo "<td class=xl12824082 style='border-left:none;'>".$temp[11]."</td>
	  <td class=xl12824082 style='border-left:none;'>".$temp[12]."</td>
	  <td class=xl12824082 style='border-left:none;'>".$temp[13]."</td>";
	//  }
	  echo "<td class=xl12824082 colspan=6 width=98 style='border-left:none;width:130pt'>".wordwrap($temp[14],10,"<br>\n")."</td>
	  <td class=xl9624082 colspan=14 width=98 style='border-left:none;width:130pt'>";
				//getting rejection reasons from mdm with category filter as inspection
	  			$reject_reason_query = "select * FROM $wms.reject_reasons";
				$reject_reasons=mysqli_query($link_new, $reject_reason_query) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
	    		while($row1=mysqli_fetch_array($reject_reasons))
	    		{
					if ($temp[15] == $row1['tid']) 
					{
						echo "<option value=".$row1['tid']." selected>".$row1["reject_desc"]."</option>";
					}
				}	
	 echo "</td>
	 </tr>";
	
	unset($doc_db,$recut_doc_db,$qty,$schedule,$job);
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
 </table>

 <table border=0 cellpadding=0 cellspacing=0 width=1126 class=xl11024082 style='border-collapse:collapse;table-layout:fixed;width:1050pt'>
 <tr class=xl11924082 height=40 style='height:30.0pt'>
  <td height=40 class=xl7324082 width=80 style='height:30.0pt;width:60pt'>Total
  Rolls</td>
  <td class=xl7424082 width=65 style='border-left:none;width:49pt'>No of Group</td>
  <td class=xl7524082 width=65 style='border-left:none;width:49pt'>Total Ticket Length</td>
  <td class=xl7524082 width=68 style='border-left:none;width:51pt'>Total<br>
    C-Tex Length</td>
  <td class=xl7524082 width=68 style='border-left:none;width:51pt'>Length Deviation<br>
    <span style='mso-spacerun:yes'></span></td>
  <td class=xl7524082 width=64 style='border-left:none;width:48pt'>Average<br>
    Ticket Width</td>
  <td class=xl7524082 width=64 style='border-left:none;width:48pt'><span
  style='mso-spacerun:yes'></span>Average<br>C-Tex Width</td>
  <td class=xl7524082 width=99 style='border-left:none;width:74pt'>Average Width<br>
    Deviation</td>
  <td class=xl7324082 width=77 style='border-left:none;width:58pt'>Lot<br>
    <span style='mso-spacerun:yes'></span>Numbers</td>
</tr>
 <tr height=31 style='mso-height-source:userset;height:23.25pt'>
  <td height=31 class=xl6824082 style='height:23.25pt;border-top:none'><?php echo $num_rows; ?></td>
  <td class=xl6924082 style='border-top:none;border-left:none'><?php  echo $shade_count; ?></td>
  <td class=xl7024082 style='border-top:none;border-left:none'><?php echo round($rec_qty1, 3); ?></td>
  <td class=xl7024082 style='border-top:none;border-left:none'><?php echo $ctex_sum; ?></td>
  <td class=xl7024082 style='border-top:none;border-left:none'><?php echo round($ctex_sum-$rec_qty1,2); ?></td>
  <td class=xl7024082 style='border-top:none;border-left:none'><?php echo $avg_t_width; ?></td>
  <td class=xl7024082 style='border-top:none;border-left:none'><?php echo $avg_c_width; ?></td>
  <td class=xl7024082 style='border-top:none;border-left:none'><?php echo round($avg_c_width-$avg_t_width,4); ?></td>
  <td class=xl7024082 style='border-top:none;border-left:none'><?php echo $lot_count; ?></td>
  <!-- <td class=xl7924082 dir=LTR width=68 style='border-top:none;width:51pt'>Qty</td> -->
  
 </tr>
</table>
</br>
<table border=0 cellpadding=0 cellspacing=0 width=1126 class=xl11024082 style='border-collapse:collapse;table-layout:fixed;width:500pt'>
  	 <?php
  /*echo "<td class=xl6624082 dir=LTR width=68 style='border-left:none;width:51pt'>&nbsp;</td>
  <td class=xl6624082 dir=LTR width=68 style='border-left:none;width:51pt'>&nbsp;</td>
  <td class=xl6624082 dir=LTR width=68 style='border-left:none;width:51pt'>&nbsp;</td>
  <td class=xl6624082 dir=LTR width=68 style='border-left:none;width:51pt'>&nbsp;</td>
  <td class=xl6624082 dir=LTR width=68 style='border-left:none;width:51pt'>&nbsp;</td>
  <td class=xl6724082 dir=LTR width=68 style='border-left:none;width:51pt'>&nbsp;</td>";*/
  // echo "<td class=xl6824082 style='height:23.25pt;border-top:1pt solid'></td>";
  
for($i=0;$i<$shade_count;$i++)
{ 
    $flag=$i;
  	$flag++;
	if($flag%5 ==1)
	{
		echo "<tr>";
	}
		echo "<td colspan=2 class=xl6824082 style='height:23.25pt;border-top:1pt solid;'>".$scount_temp2[$i]."</td>";
	if($flag%5 ==0)
	{
		echo "</tr>";
	}

	if($flag%5 ==0 )
	{
		echo "<tr>";
		for($j=0;$j<=4;$j++)
		{
			echo "<td colspan=1 class=xl6824082 style='height:23.25pt;border-top:none'>Rolls</td>";
			echo "<td colspan=1 class=xl6824082 dir=LTR width=68 style='border-left:none;width:51pt'>Qty</td>";
		}
		echo "</tr><tr>";

		for($j=$flag-5;$j<=$flag-1;$j++)
		{
			$sql_sc="select count(*) as cnt from $wms.store_in where plant_code='$plantcode' and lot_no in ("."'".str_replace(",","','",$lot_ref)."'".") and BINARY ref4=\"".$scount_temp2[$j]."\" and tid in ("."'".str_replace(",","','",$roll_num)."'".") order by tid";
		//echo $sql_sc;
			$result_sc=mysqli_query($link, $sql_sc) or die("Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row_sc=mysqli_fetch_array($result_sc))
			{
				$count_sc=$row_sc["cnt"];
			}
			echo "<td colspan=1 class=xl6824082 style='height:23.25pt;border-top:1pt solid;'>".$count_sc."</td>";
			echo "<td colspan=1 class=xl6824082 dir=LTR width=68 style='border-top:none;border-left:none;
		  width:51pt'>".$shade_group_total[$j]."</td>";
		}
		echo "</tr>";
	}
	if($flag==$shade_count)
	{
		echo "</tr><tr>";
		for($j=1;$j<=$flag%5;$j++)
		{
			echo "<td colspan=1 class=xl6824082 style='height:23.25pt;border-top:none'>Rolls</td>";
			echo "<td colspan=1 class=xl6824082 dir=LTR width=68 style='border-left:none;width:51pt'>Qty</td>";
		}

		echo "</tr><tr>";

		for($j=$shade_count-($shade_count%5);$j<=($shade_count)-1;$j++)
		{
			$sql_sc="select count(*) as cnt from $wms.store_in where plant_code='$plantcode' and lot_no in ("."'".str_replace(",","','",$lot_ref)."'".") and BINARY ref4=\"".$scount_temp2[$j]."\" and tid in ("."'".str_replace(",","','",$roll_num)."'".") order by tid";
		//echo $sql_sc;
			$result_sc=mysqli_query($link, $sql_sc) or die("Error112".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row_sc=mysqli_fetch_array($result_sc))
			{
				$count_sc=$row_sc["cnt"];
			}
			echo "<td colspan=1 class=xl6824082 style='height:23.25pt;border-top:1pt solid;'>".$count_sc."</td>";
			echo "<td colspan=1 class=xl6824082 dir=LTR width=68 style='border-top:none;border-left:none;
		  width:51pt'>".$shade_group_total[$j]."</td>";
		}
		echo "</tr>";
	}
} 
  ?>

  </tr>

</table>	
 <table>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
 
  <td class=xl8124082></td>
  <td class=xl8124082></td>
  <td class=xl8324082></td>
  
  <td class=xl7224082 dir=LTR width=64 style='width:48pt'></td>
   <td height=21 class=xl8224082 colspan=2 style='height:15.75pt'>Special
  Instruction</td>
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
 <tr height=28 style='mso-height-source:userset;height:21.0pt'>
  <td class=xl11024082>Prepared by:</td>
  <td class=xl11024082></td>
  <td class=xl11024082></td>
  <td class=xl11024082></td>
  
  <td colspan=12 rowspan=3 height=84 class=xl8424082 style='border-right:1.0pt solid black;text-align: left;border-bottom:1.0pt solid black;height:63.0pt'><?php
        $overall_message_length=strlen($sp_rem);
        $break_start=0;
        $break_length=150;
        while($break_start<$overall_message_length)
        {
            echo substr($sp_rem,$break_start,$break_length).'<br>';
            $break_start=$break_start+$break_length;
        }
		?>
	</td>
 </tr>
 <tr height=28 style='mso-height-source:userset;height:21.0pt'>
  <td height=28 class=xl11024082 style='height:21.0pt'>Color Chk. by:</td>
  <td class=xl11024082></td>
  <td class=xl11024082></td>
  <td class=xl11024082></td>
 </tr>

 <tr height=28 style='mso-height-source:userset;height:21.0pt'>
  <td height=28 class=xl11024082 style='height:21.0pt'>Appr. by:</td>
  <td class=xl11024082></td>
  <td class=xl11024082></td>
  <td class=xl11024082></td>
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


<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD
<!--  -->
</body>

</html>



