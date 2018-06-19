<!--
Change Request # 138 / 2014-07-29/Working Days & SAH Required Calculation Formulas Changes in SAH Report 
-->
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<title>Daily SAH</title>
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 14">
<link rel=File-List href="SAH%20-JUN_files/filelist.xml">
<script type="text/javascript" src="<?= getFullURL($_GET['r'],'datetimepicker_css.js','R');?>"></script>
<script language="JavaScript" src="<?= getFullURL($_GET['r'],'FusionCharts.js','R');?>"></script>
<script type="text/javascript" language="JavaScript" src="<?= getFullURL($_GET['r'],'FusionChartsExportComponent.js','R');?>"></script>
<script type="text/javascript">
function verify_date(){
		var val1 = $('#sdat').val();
		var val2 = $('#edat').val();

		
		if(val1 > val2){
			sweetAlert('Start Date Should  be less than End Date','','warning');
			return false;
		}
		else
		{
			return true;
		}
	}
</script>
<style id="SAH -JUN_13441_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl15212
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
.xl84212
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
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
	white-space:nowrap;}
.xl85212
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
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
	white-space:nowrap;}
.xl86212
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\#\,\#\#0";
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl87212
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\#\,\#\#0";
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl88212
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:0%;
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl89212
	{padding:0px;
	mso-ignore:padding;
	color:white;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\#\,\#\#0";
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#4F6228;
	mso-pattern:black none;
	white-space:normal;}
.xl90212
	{padding:0px;
	mso-ignore:padding;
	color:white;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:0%;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#4F6228;
	mso-pattern:black none;
	white-space:normal;}
.xl91212
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:"\#\,\#\#0";
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl92212
	{padding:0px;
	mso-ignore:padding;
	color:white;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\#\,\#\#0";
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:gray;
	mso-pattern:black none;
	white-space:nowrap;}
.xl93212
	{padding:0px;
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
	border:.5pt solid windowtext;
	background:#CCC0DA;
	mso-pattern:black none;
	white-space:nowrap;}
.xl94212
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"_\(* \#\,\#\#0_\)\;_\(* \\\(\#\,\#\#0\\\)\;_\(* \0022-\0022??_\)\;_\(\@_\)";
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#B1A0C7;
	mso-pattern:black none;
	white-space:nowrap;}
.xl95212
	{padding:0px;
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	background:#CCC0DA;
	mso-pattern:black none;
	white-space:nowrap;}
.xl96212
	{padding:0px;
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	background:#CCC0DA;
	mso-pattern:black none;
	white-space:nowrap;}
.xl97212
	{padding:0px;
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
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	background:#CCC0DA;
	mso-pattern:black none;
	white-space:nowrap;}
.xl98212
	{padding:0px;
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
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#CCC0DA;
	mso-pattern:black none;
	white-space:nowrap;}
.xl99212
	{padding:0px;
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
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#CCC0DA;
	mso-pattern:black none;
	white-space:nowrap;}
.xl100212
	{padding:0px;
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
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#CCC0DA;
	mso-pattern:black none;
	white-space:nowrap;}
.xl101212
	{padding:0px;
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
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	background:#B1A0C7;
	mso-pattern:black none;
	white-space:nowrap;}
.xl102212
	{padding:0px;
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
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#B1A0C7;
	mso-pattern:black none;
	white-space:nowrap;}
.xl103212
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\#\,\#\#0";
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	background:#B1A0C7;
	mso-pattern:black none;
	white-space:nowrap;}
.xl104212
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\#\,\#\#0";
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#B1A0C7;
	mso-pattern:black none;
	white-space:nowrap;}
.xl105212
	{padding:0px;
	mso-ignore:padding;
	color:white;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\#\,\#\#0";
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#4F6228;
	mso-pattern:black none;
	white-space:nowrap;}
.xl106212
	{padding:0px;
	mso-ignore:padding;
	color:white;
	font-size:12.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	background:red;
	mso-pattern:black none;
	white-space:nowrap;}
.xl107212
	{padding:0px;
	mso-ignore:padding;
	color:white;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	background:#366092;
	mso-pattern:black none;
	white-space:nowrap;}
.xl108212
	{padding:0px;
	mso-ignore:padding;
	color:white;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#366092;
	mso-pattern:black none;
	white-space:nowrap;}
.xl109212
	{padding:0px;
	mso-ignore:padding;
	color:white;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	background:#366092;
	mso-pattern:black none;
	white-space:nowrap;}
.xl110212
	{padding:0px;
	mso-ignore:padding;
	color:white;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\[ENG\]\[$-409\]d\\-mmm\\-yyyy\;\@";
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	background:#366092;
	mso-pattern:black none;
	white-space:nowrap;}
.xl111212
	{padding:0px;
	mso-ignore:padding;
	color:white;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	background:black;
	mso-pattern:black none;
	white-space:nowrap;}
.xl112212
	{padding:0px;
	mso-ignore:padding;
	color:white;
	font-size:14.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:0%;
	text-align:center;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:black;
	mso-pattern:black none;
	white-space:nowrap;}
.xl113212
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\#\,\#\#0";
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#EBF1DE;
	mso-pattern:black none;
	white-space:nowrap;}
.xl114212
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\#\,\#\#0";
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	background:#EBF1DE;
	mso-pattern:black none;
	white-space:nowrap;}
.xl115212
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:0%;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	background:#EBF1DE;
	mso-pattern:black none;
	white-space:nowrap;}
.xl116212
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	background:#EBF1DE;
	mso-pattern:black none;
	white-space:nowrap;}
.xl117212
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\#\,\#\#0";
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#00B050;
	mso-pattern:black none;
	white-space:nowrap;}
.xl118212
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:0%;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	background:#00B050;
	mso-pattern:black none;
	white-space:nowrap;}	
.xl1513441
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
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8413441
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
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
	white-space:nowrap;}
.xl8513441
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
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
	white-space:nowrap;}
.xl8613441
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\#\,\#\#0";
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8713441
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\#\,\#\#0";
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8813441
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:0%;
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8913441
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:red;
	font-size:14.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:0%;
	text-align:center;
	vertical-align:bottom;
	background:black;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9013441
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
	mso-number-format:"_\(* \#\,\#\#0_\)\;_\(* \\\(\#\,\#\#0\\\)\;_\(* \0022-\0022??_\)\;_\(\@_\)";
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#B1A0C7;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9113441
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
	border:.5pt solid windowtext;
	background:#B1A0C7;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9213441
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
	mso-number-format:"\#\,\#\#0";
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#B1A0C7;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9313441
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:white;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\#\,\#\#0";
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:gray;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9413441
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
	border:.5pt solid windowtext;
	background:#CCC0DA;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9513441
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:red;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	background:black;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9613441
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:white;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:0%;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#4F6228;
	mso-pattern:black none;
	white-space:normal;}
.xl9713441
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\#\,\#\#0";
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#00B050;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9813441
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
	mso-number-format:0%;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	background:#00B050;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9913441
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:white;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\#\,\#\#0";
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#4F6228;
	mso-pattern:black none;
	white-space:nowrap;}
.xl10013441
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:white;
	font-size:12.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	background:red;
	mso-pattern:black none;
	white-space:nowrap;}
.xl10113441
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:white;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	background:#1F497D;
	mso-pattern:black none;
	white-space:nowrap;}
.xl10213441
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:white;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#1F497D;
	mso-pattern:black none;
	white-space:nowrap;}
.xl10313441
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:white;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	background:#1F497D;
	mso-pattern:black none;
	white-space:nowrap;}
.xl10413441
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:white;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\[ENG\]\[$-409\]d\\-mmm\\-yyyy\;\@";
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	background:#1F497D;
	mso-pattern:black none;
	white-space:nowrap;}
.xl10513441
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\#\,\#\#0";
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:#EBF1DE;
	mso-pattern:black none;
	white-space:nowrap;}
.xl10613441
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\#\,\#\#0";
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	background:#EBF1DE;
	mso-pattern:black none;
	white-space:nowrap;}
.xl10713441
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:0%;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	background:#EBF1DE;
	mso-pattern:black none;
	white-space:nowrap;}
.xl10813441
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	background:#EBF1DE;
	mso-pattern:black none;
	white-space:nowrap;}
-->
</style>
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>	
</head>

<!--<h2 align="center" style="font-family:Century Gothic;">Daily Standard Hours Report</h2>-->
<div class="panel panel-primary">
<div class="panel-heading">Daily Standard Hours Report</div>

<div class="panel-body">

<form action="<?= getFullURL($_GET['r'],'daily_sah_report_V6.php','N'); ?>" method="post">

<div class="col-md-3">
<label>Start Date</label>
<input type="text" name="sdat" id="sdat" class="form-control" data-toggle="datepicker" size=8 value="<?php  if(isset($_POST['sdat'])) { echo $_POST['sdat']; } else { echo date("Y-m-d"); } ?>"/>
</div>
<div class="col-md-3">		
<label>End Date</label><input type="text" data-toggle="datepicker" class="form-control" name="edat" id="edat"  size=8 value="<?php  if(isset($_POST['edat'])) { echo $_POST['edat']; } else { echo date("Y-m-d"); } ?>"/>
</div>			 
<input type="submit" value="submit" name="submit" class="btn btn-success" onchange="return verify_date();" style="margin-top:22px;">
<a href="<?= getFullURL($_GET['r'],'daily_sah_report_V5.php','N'); ?>" style="margin-top:22px;" class="btn btn-warning">Section Wise SAH Report</a>


</form>


<?php
error_reporting(0);
if(isset($_POST["submit"]))
{
    include("..".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include("..".getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));

if(file_exists("bar.php")){
    unlink("bar.php");
}
$dat=$_POST["sdat"];

$dat1=$_POST["edat"];

$date_explode=explode("-",$dat);
$month=$date_explode[1];

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/Production_Live_Chart/Control_Room_Charts/sah_monthly_status/data.php',1,'R'));
/* include("../Production_Live_Chart/Control_Room_Charts/sah_monthly_status/data.php"); */

$days_fac=2;
$days=0;
$half_days=0;
$working_days=sizeof($date);

//To calculate Halfdays of a month
for($ik=0;$ik<sizeof($half_date1);$ik++)
{
	if($half_date1[$ik] > 0)
	{
		$half_days=$half_days+1;		
	}
}
//echo $half_days;

//To calculate no of working days of a month
$actual_working_days=$working_days-$half_days+($half_days/2);

//echo $working_days."-".$half_days."-".($working_days-$half_days+($half_days/2));

//$sql7=mysql_query("SELECT COUNT(DISTINCT DATE) as days FROM $bai_pro.grand_rep WHERE (DATE between \"$dat\" and \"$dat1\")");
$sql7=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(DISTINCT shift) as days FROM $bai_pro.grand_rep WHERE (DATE between \"$dat\" and \"$dat1\") GROUP BY date");
while($rows7=mysqli_fetch_array($sql7))
{
	//To calculate completed working shifts and days of a month
	$days=$days+($rows7["days"]/$days_fac);
	//echo "<td rowspan=2 class=xl6527942 width=64 style='width:48pt'>".$rows7["COUNT(DISTINCT DATE)"]."</td>";
}

$sql7=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(act_sth) as sah,sum(plan_sth) as psah FROM $bai_pro.grand_rep  WHERE section in (1,2,3,4,5,6,7) and DATE=\"".$dat1."\"");
while($rows7=mysqli_fetch_array($sql7))
{
	$today_sah=$rows7["sah"];
	$today_plan_sah=$rows7["psah"];
}

echo "<hr><div class='table-responsive' style='max-height: 800px;overflow-y: scroll;' id=\"SAH -JUN_13441\" align=center x:publishsource=\"Excel\">

<table border=0 cellpadding=0 cellspacing=0 width=3739 style='border-collapse:
collapse;table-layout:fixed;width:3204pt'>
<col width=64 style='width:48pt'>
<col width=83 style='mso-width-source:userset;mso-width-alt:3035;width:62pt'>
<col width=64 style='width:48pt'>
<col class=xl1513441 width=64 style='width:48pt'>
<col width=64 style='width:48pt'>
<col class=xl1513441 width=64 style='width:48pt'>
<col width=64 span=5 style='width:48pt'>
<col class=xl1513441 width=64 style='width:48pt'>
<col width=64 style='width:48pt'>
<col class=xl1513441 width=64 style='width:48pt'>
<col width=64 span=5 style='width:48pt'>
<col class=xl1513441 width=64 style='width:48pt'>
<col width=64 style='width:48pt'>
<col class=xl1513441 width=64 style='width:48pt'>
<col width=64 span=5 style='width:48pt'>
<col class=xl1513441 width=64 style='width:48pt'>
<col width=64 style='width:48pt'>
<col class=xl1513441 width=64 style='width:48pt'>
<col width=64 span=5 style='width:48pt'>
<col class=xl1513441 width=64 style='width:48pt'>
<col width=64 style='width:48pt'>
<col class=xl1513441 width=64 style='width:48pt'>
<col width=64 span=5 style='width:48pt'>
<col class=xl1513441 width=64 style='width:48pt'>
<col width=64 style='width:48pt'>
<col class=xl1513441 width=64 style='width:48pt'>
<col width=64 span=4 style='width:48pt'>
<col class=xl1513441 width=64 span=5 style='width:48pt'>
<col class=xl1513441 width=72 style='mso-width-source:userset;mso-width-alt:
2633;width:54pt'>
<col class=xl1513441 width=64 span=2 style='mso-width-source:userset;
mso-width-alt:2340;width:48pt'>
<tr height=21 style='height:15.75pt'>
<td colspan=2 height=21 class=xl10113441 style='height:15.75pt'>Buyer Name</td>
<td colspan=9 class=xl9313441 style='border-left:none'>VS</td>
<td colspan=9 class=xl9313441 style='border-left:none'>M&S</td>
<td colspan=9 class=xl9313441 style='border-left:none'>Factory</td>
</tr>
<tr height=36 style='mso-height-source:userset;height:27.0pt'>
<td colspan=2 rowspan=2 height=57 class=xl10213441 style='height:42.75pt'>DATE</td>
<td rowspan=2 class=xl9913441 style='border-top:none'><span
style='mso-spacerun:yes'>�</span>PLAN SAH</td>
<td colspan=3 class=xl9913441 style='border-left:none'>ACTUAL SAH</td>
<td rowspan=2 class=xl9613441 width=64 style='border-top:none;width:48pt'>Actual
%</td>
<td rowspan=2 class=xl9613441 width=64 style='border-top:none;width:48pt'>EFF %</td>
<td rowspan=2 class=xl9613441 width=64 style='border-top:none;width:48pt'>External
SAH loss</td>
<td rowspan=2 class=xl9613441 width=64 style='border-top:none;width:48pt'>Internal
SAH loss</td>
<td rowspan=2 class=xl9613441 width=64 style='border-top:none;width:48pt'>Production loss</td>
<td rowspan=2 class=xl9913441 style='border-top:none'><span
style='mso-spacerun:yes'>�</span>PLAN SAH</td>
<td colspan=3 class=xl9913441 style='border-left:none'>ACTUAL SAH</td>
<td rowspan=2 class=xl9613441 width=64 style='border-top:none;width:48pt'>Actual
%</td>
<td rowspan=2 class=xl9613441 width=64 style='border-top:none;width:48pt'>EFF %</td>
<td rowspan=2 class=xl9613441 width=64 style='border-top:none;width:48pt'>External
SAH loss</td>
<td rowspan=2 class=xl9613441 width=64 style='border-top:none;width:48pt'>Internal
SAH loss</td>
<td rowspan=2 class=xl9613441 width=64 style='border-top:none;width:48pt'>Production loss</td>
<td rowspan=2 class=xl9913441 style='border-top:none'><span
style='mso-spacerun:yes'>�</span>PLAN SAH</td>
<td colspan=3 class=xl9913441 style='border-left:none'>ACTUAL SAH</td>
<td rowspan=2 class=xl9613441 width=64 style='border-top:none;width:48pt'>Actual
%</td>
<td rowspan=2 class=xl9613441 width=64 style='border-top:none;width:48pt'>EFF %</td>
<td rowspan=2 class=xl9613441 width=64 style='border-top:none;width:48pt'>External
SAH loss</td>
<td rowspan=2 class=xl9613441 width=64 style='border-top:none;width:48pt'>Internal
SAH loss</td>
<td rowspan=2 class=xl9613441 width=64 style='border-top:none;width:48pt'>Production loss</td>
</tr>
<tr class=xl1513441 height=21 style='mso-height-source:userset;height:15.75pt'>
<td height=21 class=xl9913441 style='height:15.75pt;border-top:none;
border-left:none'>A</td>
<td class=xl9913441 style='border-top:none;border-left:none'>B</td>
<td class=xl9913441 style='border-top:none;border-left:none'>Total</td>
<td class=xl9913441 style='border-top:none;border-left:none'>A</td>
<td class=xl9913441 style='border-top:none;border-left:none'>B</td>
<td class=xl9913441 style='border-top:none;border-left:none'>Total</td>
<td class=xl9913441 style='border-top:none;border-left:none'>A</td>
<td class=xl9913441 style='border-top:none;border-left:none'>B</td>
<td class=xl9913441 style='border-top:none;border-left:none'>Total</td>
</tr>";

$plan_clh=0;
$act_sah=0;
$plan_sah=0;
$act_sah_a=0;
$plan_sah_a=0;
$act_sah_b=0;
$plan_sah_b=0;
$plan_clh_fac=0;
$act_sah_fac=0;
$plan_sah_fac=0;
$act_sah_a_fac=0;
$plan_sah_a_fac=0;
$act_sah_b_fac=0;
$plan_sah_b_fac=0;
$total_ext_sah=0; 
$ext_sah_loss_total=0;
$ext_sah_loss_totalx=0;
$total_ext_sahx=0;
$int_sah_loss_total=0;
$total_int_sah=0; 
$plan_sah=0;
$plan_sah_a=0;
$plan_sah_b=0;
$act_sah=0;
$act_sah_a=0;
$act_sah_b=0;
$plan_clh=0;
$plan_sah_sec=0;
$plan_sah_sec_a=0;
$plan_sah_sec_b=0;
$act_sah_sec=0;
$act_sah_sec_a=0;
$act_sah_sec_b=0;
$plan_clh_sec=0;
$plan_sah_fac=0;
$plan_sah_fac_a=0;
$plan_sah_fac_b=0;
$act_sah_fac=0;
$act_sah_fac_a=0;
$act_sah_fac_b=0;
$plan_clh_fac=0;
$total_plan_sah_fac=0;
$total_act_sah_fac=0;
$total_act_sah_fac_a=0;
$total_act_sah_fac_b=0;
$total_plan_clh_fac=0;
$int_sah_loss=array();
$ext_sah_loss=array();
$ext_sah_loss_total=0;
$ext_sah_loss_totalx=0;
$int_sah_loss_total=0;
$total_ext_sah=0;
$total_ext_sahx=0;
$total_int_sah=0;
$ext_sah_loss_total1=0;
$ext_sah_loss_total1s=0;
$int_sah_loss_total1=0;
$total_ext_sah1=0;
$total_ext_sah1s=0;
$total_int_sah1=0;
$vs_fac_sah=0;
$vs_today_sah=0;
$vs_avg_sah=0;
$vs_sah_req=0;
$vs_act_sah=0;
$ms_fac_sah=0;
$ms_today_sah=0;
$ms_avg_sah=0;
$ms_sah_req=0;
$ms_act_sah=0;
$ext_sah_array=array();
$plan=array();
$total_prod_loss_array=array();
$vs_sah_plan=$vs_plan;
$ms_sah_plan=$ms_plan;
 
$sql_vs="SELECT SUM(plan_sth) as plan,SUM(act_sth) as act from $bai_pro.grand_rep where section in (1,3,4,5,7) and date between \"$dat\" and \"$dat1\"";
//echo $sql_vs;
$result_vs=mysqli_query($link, $sql_vs) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row_vs=mysqli_fetch_array($result_vs))
{
	$vs_act_sah=$row_vs["act"];
	$vs_plan_sah=$row_vs["plan"];
}

$sql_ms="SELECT SUM(plan_sth) as plan,SUM(act_sth) as act from $bai_pro.grand_rep where section in (2,6) and date between \"$dat\" and \"$dat1\"";
//echo $sql_ms;
$result_ms=mysqli_query($link, $sql_ms) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row_ms=mysqli_fetch_array($result_ms))
{
	$ms_act_sah=$row_ms["act"];
	$ms_plan_sah=$row_ms["plan"];
}

$sql_vs_today="SELECT SUM(plan_sth) as plan,SUM(act_sth) as act from $bai_pro.grand_rep where section in (1,3,4,5,7) and date=\"$dat1\"";
//echo $sql_vs;
$result_vs_today=mysqli_query($link, $sql_vs_today) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row_vs_today=mysqli_fetch_array($result_vs_today))
{
	$vs_plan_sah_today=$row_vs_today["plan"];
	$vs_act_sah_today=$row_vs_today["act"];
}

$sql_ms_today="SELECT SUM(plan_sth) as plan,SUM(act_sth) as act from $bai_pro.grand_rep where section in (2,6) and date=\"$dat1\"";
//echo $sql_ms;
$result_ms_today=mysqli_query($link, $sql_ms_today) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row_ms_today=mysqli_fetch_array($result_ms_today))
{
	$ms_act_sah_today=$row_ms_today["act"];
	$ms_plan_sah_today=$row_ms_today["plan"];
}

 
$sql_dat=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct date from $bai_pro.grand_rep where date between \"$dat\" and \"$dat1\" order by date");
while($row=mysqli_fetch_array($sql_dat))
{
  $date = $row['date']; 
  $weekday = date('l', strtotime($date));
  echo "<tr height=21 style='height:15.75pt'>
  <td height=21 class=xl10313441 style='height:15.75pt;border-top:none'>".$weekday."</td>
  <td class=xl10413441 style='border-top:none;border-left:none'>".$date."</td>";
  
  $buyer=array("VS","M&S");
  
  for($i=0;$i<sizeof($buyer);$i++)
  {
  		if($buyer[$i]=="VS")
		{
			$query_add="(buyer like '%VS Pink%' or buyer like '%VS Logo%' or buyer like '%Glamour%')";
			$sections_in="section in (1,3,4,5,7)";
			$sec_in="sec_no in (1,3,4,5,7)";
		}
		
		if($buyer[$i]=="M&S")
		{
			$query_add="(buyer like '%M&S%')";
			$sections_in="section in (2,6)";
			$sec_in="sec_no in (2,6)";
		}
		
		$total_sec_in="section in (1,2,3,4,5,6,7)";
		
	   $sql=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(plan_sth) as plan,SUM(act_sth) as act,SUM(plan_clh) as clh,shift FROM $bai_pro.grand_rep WHERE DATE=\"".$row["date"]."\" AND $sections_in group by module,shift order by module");	 
       while($rows=mysqli_fetch_array($sql))
	   {
			$plan_sah=$plan_sah+round($rows["plan"],0);
			$act_sah=$act_sah+$rows["act"];
			$plan_clh=$plan_clh+$rows["clh"];
			if($rows["shift"] == "A")
			{
				$act_sah_a=$act_sah_a+$rows["act"];
				$plan_sah_a=$plan_sah_a+round($rows["plan"],0);
			}
			else if($rows["shift"] == "B")
			{
				$act_sah_b=$act_sah_b+$rows["act"];
				$plan_sah_b=$plan_sah_b+round($rows["plan"],0);
			}
			else
			{
				echo "No Shift";
			}
	   } 
	   
	  echo "<td class=xl10513441 style='border-top:none;border-left:none'>".number_format($plan_sah_a+$plan_sah_b,0)."</td>";
	  echo "<td class=xl10513441 style='border-top:none;border-left:none'>".number_format($act_sah_a,0)."</td>";
	  echo "<td class=xl10613441 style='border-top:none;border-left:none'>".number_format($act_sah_b,0)."</td>";
	  echo "<td class=xl10613441 style='border-top:none;border-left:none'>".number_format($act_sah_a+$act_sah_b,0)."</td>";
	  echo "<td class=xl10713441 style='border-top:none;border-left:none'>".round((($act_sah_a+$act_sah_b)/$plan_sah)*100,1)."%</td>";
	  echo "<td class=xl10713441 style='border-top:none;border-left:none'>".round((($act_sah_a+$act_sah_b)/$plan_clh)*100,1)."%</td>";	
	  
	  $sql1="select mod_no,dtime,shift,plan_eff from $bai_pro.down_log where $sections_in and date=\"".$row["date"]."\" and source=1 and remarks!=\"Open capacity\"";
	  $result1=mysqli_query($link, $sql1) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	  while($row1=mysqli_fetch_array($result1))
	  {
	  		 $mod_no=$row1["mod_no"];
			 $dtime=$row1["dtime"]/60;
			 $shift=$row1["shift"];
			 $plan_eff_down=round($row1["plan_eff"],0);
			 if($plan_eff_down > 0)
			 {
			 	$sql2="select plan_eff from $bai_pro.down_log where $sections_in and date=\"".$row["date"]."\" and mod_no=\"".$mod_no."\" and shift=\"".$shift."\" ";
				 $result2=mysqli_query($link, $sql2) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while($row2=mysqli_fetch_array($result2))
				 {
				 	$plan_eff=$row2["plan_eff"];
				 } 
			 }
			 else
			 {
			 	 $sql2="select plan_eff from $bai_pro.pro_plan where $sec_in and date=\"".$row["date"]."\" and mod_no=\"".$mod_no."\" and shift=\"".$shift."\" ";
				 $result2=mysqli_query($link, $sql2) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while($row2=mysqli_fetch_array($result2))
				 {
				 	$plan_eff=$row2["plan_eff"];
				 } 
				 if($plan_eff ==0)
				 {
				 	$sql2="SELECT MAX(DATE) as max_date FROM $bai_pro.pro_plan WHERE plan_eff > 0 AND DATE <= \"".$row["date"]."\"  and mod_no=\"$mod_no\" and shift=\"$shift\"";
		//echo $sql2;
					$sql_result2=mysqli_query($link, $sql2) or die("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row2=mysqli_fetch_array($sql_result2))
					{
						$max_date=$sql_row2["max_date"];
						$sql21="SELECT plan_eff FROM $bai_pro.pro_plan WHERE plan_eff > 0 AND DATE=\"".$max_date."\"  and mod_no=\"$mod_no\" and shift=\"$shift\"";
						//echo $sql2;
						$sql_result21=mysqli_query($link, $sql21) or die("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row21=mysqli_fetch_array($sql_result21))
						{
							$plan_eff=$sql_row21["plan_eff"];
							//echo "<td>".$plan_eff."%</td>";
						}
					}	
				 }
			 }		 
			 $ext_sah_loss_total=$ext_sah_loss_total+($dtime*$plan_eff/100);
	  }
	  
	  echo "<td class=xl10813441 style='border-top:none;border-left:none'>".round($ext_sah_loss_total,2)."</td>";
	
	  $total_ext_sah=$total_ext_sah+round($ext_sah_loss_total,2);
	  
	  $sql1x="select mod_no,dtime,shift,plan_eff from $bai_pro.down_log where $sections_in and date=\"".$row["date"]."\" and source=1 and remarks=\"Open capacity\"";
	  $result1x=mysqli_query($link, $sql1x) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	  while($row1x=mysqli_fetch_array($result1x))
	  {
	  		 $mod_nox=$row1x["mod_no"];
			 $dtimex=$row1x["dtime"]/60;
			 $shiftx=$row1x["shift"];
			 $plan_eff_downx=round($row1x["plan_eff"],0);
			 if($plan_eff_downx > 0)
			 {
			 	$sql2x="select plan_eff from $bai_pro.down_log where $sections_in and date=\"".$row["date"]."\" and mod_no=\"".$mod_nox."\" and shift=\"".$shiftx."\" ";
				 $result2x=mysqli_query($link, $sql2x) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while($row2x=mysqli_fetch_array($result2x))
				 {
				 	$plan_effx=$row2x["plan_eff"];
				 } 
			 }
			 else
			 {
			 	 $sql2x="select plan_eff from $bai_pro.pro_plan where $sec_in and date=\"".$row["date"]."\" and mod_no=\"".$mod_nox."\" and shift=\"".$shiftx."\" ";
				 $result2x=mysqli_query($link, $sql2x) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while($row2x=mysqli_fetch_array($result2x))
				 {
				 	$plan_effx=$row2x["plan_eff"];
				 } 
				 if($plan_effx ==0)
				 {
				 	$sql2x="SELECT MAX(DATE) as max_date FROM $bai_pro.pro_plan WHERE plan_eff > 0 AND DATE <= \"".$row["date"]."\"  and mod_no=\"$mod_nox\" and shift=\"$shiftx\"";
		//echo $sql2;
					$sql_result2x=mysqli_query($link, $sql2x) or die("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row2x=mysqli_fetch_array($sql_result2x))
					{
						$max_datex=$sql_row2x["max_date"];
						$sql21x="SELECT plan_eff FROM $bai_pro.pro_plan WHERE plan_eff > 0 AND DATE=\"".$max_datex."\"  and mod_no=\"$mod_nox\" and shift=\"$shiftx\"";
						//echo $sql2;
						$sql_result21x=mysqli_query($link, $sql21x) or die("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row21x=mysqli_fetch_array($sql_result21x))
						{
							$plan_effx=$sql_row21x["plan_eff"];
							//echo "<td>".$plan_eff."%</td>";
						}
					}	
				 }
			 }			 
			 $ext_sah_loss_totalx=$ext_sah_loss_totalx+($dtimex*$plan_effx/100);
	  }
	  $total_ext_sahx=$total_ext_sahx+round($ext_sah_loss_totalx,2);	  
	  
	  $sql11="select mod_no,dtime,shift,plan_eff from $bai_pro.down_log where $sections_in and date=\"".$row["date"]."\" and source=0 order by mod_no,shift";
	  //echo $sql11."<br>";
	  $result11=mysqli_query($link, $sql11) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	  while($row11=mysqli_fetch_array($result11))
	  {
	  	$mod_no1=$row11["mod_no"];
		$dtime1=$row11["dtime"]/60;
		$shift1=$row11["shift"];
		$plan_eff1=$row11["plan_eff"];
		if($plan_eff1 == 0)
		{
			$sql21="select plan_eff from $bai_pro.pro_plan where $sec_in and date=\"".$row["date"]."\" and mod_no=\"".$mod_no1."\" and shift=\"".$shift1."\" ";
			//echo $sql21."<br>";
			$result21=mysqli_query($link, $sql21) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row21=mysqli_fetch_array($result21))
			{
				$plan_eff1=$row21["plan_eff"];//echo "Mod =".$mod_no1."-".$plan_eff1;
			} 
		}
		
	    $int_sah_loss_total=$int_sah_loss_total+($dtime1*$plan_eff1/100);
	  }
	  
	  echo "<td class=xl10813441 style='border-top:none;border-left:none'>".round($int_sah_loss_total,2)."</td>";
	  echo "<td class=xl10813441 style='border-top:none;border-left:none'>".number_format($plan_sah_a+$plan_sah_b-($act_sah_a+$act_sah_b)-$ext_sah_loss_total-$int_sah_loss_total,2)."</td>";
	  $total_int_sah=$total_int_sah+round($int_sah_loss_total,2);	  
	  
	  $int_sah_loss_total=0; $ext_sah_loss_total=0; $ext_sah_loss_totalx =0;  

$plan_clh=0;
$act_sah=0;
$plan_sah=0;
$act_sah_a=0;
$plan_sah_a=0;
$act_sah_b=0;
$plan_sah_b=0;

}
  
$sql_fac=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(plan_sth) as plan,SUM(act_sth) as act,SUM(plan_clh) as clh,shift FROM $bai_pro.grand_rep WHERE DATE=\"".$row["date"]."\" AND $total_sec_in group by module,shift order by module");	 
while($rows_fac=mysqli_fetch_array($sql_fac))
{
	$plan_sah_fac=$plan_sah_fac+round($rows_fac["plan"],0);
	$act_sah_fac=$act_sah_fac+$rows_fac["act"];
	$plan_clh_fac=$plan_clh_fac+$rows_fac["clh"];
	if($rows_fac["shift"] == "A")
	{
		$act_sah_a_fac=$act_sah_a_fac+$rows_fac["act"];
		$plan_sah_a_fac=$plan_sah_a_fac+round($rows_fac["plan"],0);
	}
	else if($rows_fac["shift"] == "B")
	{
		$act_sah_b_fac=$act_sah_b_fac+$rows_fac["act"];
		$plan_sah_b_fac=$plan_sah_b_fac+round($rows_fac["plan"],0);
	}
	else
	{
		echo "No Shift";
	}
} 
	   
echo "<td class=xl10513441 style='border-top:none;border-left:none'>".number_format($plan_sah_a_fac+$plan_sah_b_fac,0)."</td>";
echo "<td class=xl10513441 style='border-top:none;border-left:none'>".number_format($act_sah_a_fac,0)."</td>";
echo "<td class=xl10613441 style='border-top:none;border-left:none'>".number_format($act_sah_b_fac,0)."</td>";
echo "<td class=xl10613441 style='border-top:none;border-left:none'>".number_format($act_sah_a_fac+$act_sah_b_fac,0)."</td>";
echo "<td class=xl10713441 style='border-top:none;border-left:none'>".round((($act_sah_a_fac+$act_sah_b_fac)/$plan_sah_fac)*100,1)."%</td>";
echo "<td class=xl10713441 style='border-top:none;border-left:none'>".round((($act_sah_a_fac+$act_sah_b_fac)/$plan_clh_fac)*100,1)."%</td>";	  
echo "<td class=xl10813441 style='border-top:none;border-left:none'>".round($total_ext_sah+$total_ext_sahx,2)."</td>
<td class=xl10813441 style='border-top:none;border-left:none'>".round($total_int_sah,2)."</td>
<td class=xl10813441 style='border-top:none;border-left:none'>".round($plan_sah_a_fac+$plan_sah_b_fac-$act_sah_fac-($total_ext_sah+$total_ext_sahx)-$total_int_sah,2)."</td></tr>";
echo "</tr>";

$plan_clh_fac=0;
$act_sah_fac=0;
$plan_sah_fac=0;
$act_sah_a_fac=0;
$plan_sah_a_fac=0;
$act_sah_b_fac=0;
$plan_sah_b_fac=0;
$total_ext_sah=0;
$total_ext_sahx=0;
$total_int_sah=0;

}


echo "<tr height=27 style='mso-height-source:userset;height:20.25pt'>
<td colspan=2 height=27 class=xl10013441 style='height:20.25pt'>Total</td>";

$buyer=array("VS","M&S");
  
for($i=0;$i<sizeof($buyer);$i++)
{
  		if($buyer[$i]=="VS")
		{
			$query_add="(buyer like '%VS Pink%' or buyer like '%VS Logo%' or buyer like '%Glamour%')";
			$sections_in="section in (1,3,4,5,7)";
			$sec_in="sec_no in (1,3,4,5,7)";
		}
		
		if($buyer[$i]=="M&S")
		{
			$query_add="(buyer like '%M&S%')";
			$sections_in="section in (2,6)";
			$sec_in="sec_no in (2,6)";
		}
		
		$total_sec_in="section in (1,2,3,4,5,6,7)";	

  $sql=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(plan_sth) as plan,SUM(act_sth) as act,SUM(plan_clh) as clh,shift FROM $bai_pro.grand_rep WHERE DATE between \"".$dat."\" and \"".$dat1."\" AND $sections_in group by date,module,shift order by date,module");
  while($rows=mysqli_fetch_array($sql))
  {
		$plan_sah_fac=$plan_sah_fac+round($rows["plan"],0);
		//echo $plan_sah_fac;
		$act_sah_fac=$act_sah_fac+$rows["act"];
		$plan_clh_fac=$plan_clh_fac+$rows["clh"];	
		if($rows["shift"] == "A")
		{
			$act_sah_fac_a=$act_sah_fac_a+$rows["act"];
			$plan_sah_fac_a=$plan_sah_fac_a+round($rows["plan"],0);
		}
		else if($rows["shift"] == "B")
		{
			$act_sah_fac_b=$act_sah_fac_b+$rows["act"];
			$plan_sah_fac_b=$plan_sah_fac_b+round($rows["plan"],0);
		}
		else
		{
			echo "No Shift";
		}
  }

  $plan[]=$plan_sah_fac; 
  if($plan_sah_fac != 0){
    $eff_array[]=round(($act_sah_fac/$plan_sah_fac)*100,1);
  } 
  echo "<td class=xl9713441 style='border-top:none;border-left:none'>".number_format($plan_sah_fac_a+$plan_sah_fac_b,0)."</td>";
  echo "<td class=xl9713441 style='border-top:none;border-left:none'>".number_format($act_sah_fac_a,0)."</td>";
  echo "<td class=xl9713441 style='border-top:none;border-left:none'>".number_format($act_sah_fac_b,0)."</td>";
  echo "<td class=xl9713441 style='border-top:none;border-left:none'>".number_format($act_sah_fac,0)."</td>";
  echo "<td class=xl9813441 style='border-top:none;border-left:none'>".round(($act_sah_fac/$plan_sah_fac)*100,1)."%</td>";
  echo "<td class=xl9813441 style='border-top:none;border-left:none'>".round(($act_sah_fac/$plan_clh_fac)*100,1)."%</td>";
  
   $sql13="select mod_no,dtime,shift,date,plan_eff from $bai_pro.down_log where $sections_in and DATE between \"".$dat."\" and \"".$dat1."\" and source=1 and remarks!=\"Open capacity\"";
 // echo $sql13;
  $result13=mysqli_query($link, $sql13) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
  while($row13=mysqli_fetch_array($result13))
  {
  		 $mod_no3=$row13["mod_no"];
		 $dtime3=$row13["dtime"]/60;
		 $shift3=$row13["shift"];
		 $dates3=$row13["date"];
		 $plan_eff_down1=round($row13["plan_eff"],0);
		 if($plan_eff_down1 > 0)
		 {
		 	$sql23="select plan_eff from $bai_pro.down_log where $sections_in and date=\"".$dates3."\" and mod_no=\"".$mod_no3."\" and shift=\"".$shift3."\" ";
			 $result23=mysqli_query($link, $sql23) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while($row23=mysqli_fetch_array($result23))
			 {
			 	$plan_eff3=$row23["plan_eff"];
			 } 
		 }
		 else
		 {
		 	 $sql23="select plan_eff from $bai_pro.pro_plan where $sec_in and date=\"".$dates3."\" and mod_no=\"".$mod_no3."\" and shift=\"".$shift3."\" ";	//echo $sql23."<br>";	
			 $result23=mysqli_query($link, $sql23) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while($row23=mysqli_fetch_array($result23))
			 {
			 	$plan_eff3=$row23["plan_eff"];
			 } 
			 if($plan_eff3 ==0)
			 {
			 	$sql23="SELECT MAX(DATE) as max_date FROM $bai_pro.pro_plan WHERE plan_eff > 0 AND DATE <= \"".$dates3."\"  and mod_no=\"$mod_no3\" and shift=\"$shift3\"";
	//echo $sql2;
				$sql_result23=mysqli_query($link, $sql23) or die("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row23=mysqli_fetch_array($sql_result23))
				{
					$max_date1=$sql_row23["max_date"];
					$sql213="SELECT plan_eff FROM $bai_pro.pro_plan WHERE plan_eff > 0 AND DATE=\"".$max_date1."\"  and mod_no=\"$mod_no3\" and shift=\"$shift3\"";
					//echo $sql2;
					$sql_result213=mysqli_query($link, $sql213) or die("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row213=mysqli_fetch_array($sql_result213))
					{
						$plan_eff3=$sql_row213["plan_eff"];
						//echo "<td>".$plan_eff3."%</td>";
					}
				}	
			 }
		 }
		 /*$sql23="select plan_eff from $bai_pro.pro_plan where sec_no=\"".$i2."\" and date=\"".$dates3."\" and mod_no=\"".$mod_no3."\" and shift=\"".$shift3."\" ";	 //echo $sql23;	
		 $result23=mysql_query($sql23,$link) or die("Error = ".mysql_error());
		 while($row23=mysql_fetch_array($result23))
		 {
		 	$plan_eff3=$row23["plan_eff"];
		 } */
		 
		 $ext_sah_loss_total1=$ext_sah_loss_total1+($dtime3*$plan_eff3/100);
  }
  
  echo "<td class=xl9713441 style='border-top:none;border-left:none'>".round($ext_sah_loss_total1,2)."</td>";

  $ext_sah_array[]=$ext_sah_loss_total1;
  $total_ext_sah1=$total_ext_sah1+round($ext_sah_loss_total1,2);
  
  
  
 $sql13s="select mod_no,dtime,shift,date,plan_eff from $bai_pro.down_log where $sections_in and DATE between \"".$dat."\" and \"".$dat1."\" and source=1 and remarks=\"Open capacity\" order by mod_no,shift";
 // echo $sql13;
  $result13s=mysqli_query($link, $sql13s) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
  while($row13s=mysqli_fetch_array($result13s))
  {
  		 $mod_no3s=$row13s["mod_no"];
		 $dtime3s=$row13s["dtime"]/60;
		 $shift3s=$row13s["shift"];
		 $dates3s=$row13s["date"];
		 $plan_eff_down1s=round($row13s["plan_eff"],0);
		 if($plan_eff_down1s > 0)
		 {
		 	$sql23s="select plan_eff from $bai_pro.down_log where $sections_in and date=\"".$dates3s."\" and mod_no=\"".$mod_no3s."\" and shift=\"".$shift3s."\" ";
			//echo $sql23s."<br>";
			 $result23s=mysqli_query($link, $sql23s) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while($row23s=mysqli_fetch_array($result23s))
			 {
			 	$plan_eff3s=$row23s["plan_eff"];
			 } 
		 }
		 else
		 {
		 	 $sql23s="select plan_eff from $bai_pro.pro_plan where $sec_in and date=\"".$dates3s."\" and mod_no=\"".$mod_no3s."\" and shift=\"".$shift3s."\" ";	//echo $sql23s."<br>";	
			 $result23s=mysqli_query($link, $sql23s) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while($row23s=mysqli_fetch_array($result23s))
			 {
			 	$plan_eff3s=$row23s["plan_eff"];
			 } 
			 if($plan_eff3s == 0)
			 {
			 	$sql23s="SELECT MAX(DATE) as max_date FROM $bai_pro.pro_plan WHERE plan_eff > 0 AND DATE <= \"".$dates3s."\"  and mod_no=\"$mod_no3s\" and shift=\"$shift3s\"";
				//echo $sql2;
				$sql_result23s=mysqli_query($link, $sql23s) or die("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row23s=mysqli_fetch_array($sql_result23s))
				{
					$max_date1s=$sql_row23s["max_date"];
					$sql213s="SELECT plan_eff FROM $bai_pro.pro_plan WHERE plan_eff > 0 AND DATE=\"".$max_date1s."\"  and mod_no=\"$mod_no3s\" and shift=\"$shift3s\"";		//echo $sql2;
					$sql_result213s=mysqli_query($link, $sql213s) or die("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row213s=mysqli_fetch_array($sql_result213s))
					{
						$plan_eff3s=$sql_row213s["plan_eff"];
						//echo "<td>".$plan_eff3."%</td>";
					}
				}	
			 }
		 }
		/* $sql23="select plan_eff from $bai_pro.pro_plan where sec_no=\"".$i2."\" and date=\"".$dates3."\" and mod_no=\"".$mod_no3."\" and shift=\"".$shift3."\" ";	 //echo $sql23;	
		 $result23=mysql_query($sql23,$link) or die("Error = ".mysql_error());
		 while($row23=mysql_fetch_array($result23))
		 {
		 	$plan_eff3=$row23["plan_eff"];
		 } */
		 
		 $ext_sah_loss_total1s=$ext_sah_loss_total1s+($dtime3s*$plan_eff3s/100);
		 //echo $ext_sah_loss_total1s."-".$dtime3s."-".$plan_eff3s."-".$mod_no3s."-".$shift3s."-".$dates3s."<br>";
  }
  
  //echo "<td class=xl9713441 style='border-top:none;border-left:none'>".round($ext_sah_loss_total1,2)."</td>";
  //$ext_sah_array[]=$ext_sah_loss_total1s;
  $total_ext_sah1s=$total_ext_sah1s+round($ext_sah_loss_total1s,2);
  //echo "sah = ".$total_ext_sah1s;
  
  
  
  
  $sql113="select mod_no,dtime,shift,date from $bai_pro.down_log where $sections_in and DATE between \"".$dat."\" and \"".$dat1."\" and source=0 order by date,mod_no,shift";
  $result113=mysqli_query($link, $sql113) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
  while($row113=mysqli_fetch_array($result113))
  {
  		 $mod_no13=$row113["mod_no"];
		 $dtime13=$row113["dtime"]/60;
		 $shift13=$row113["shift"];
		 $dates13=$row113["date"];
		 $sql213="select plan_eff from $bai_pro.pro_plan where $sec_in and date=\"".$dates13."\" and mod_no=\"".$mod_no13."\" and shift=\"".$shift13."\" ";
		 //echo $sql213."-".$dtime13."<br>";
		 $result213=mysqli_query($link, $sql213) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		 while($row213=mysqli_fetch_array($result213))
		 {
		 	$plan_eff13=$row213["plan_eff"];
		 } 
		 
		 $int_sah_loss_total1=$int_sah_loss_total1+($dtime13*$plan_eff13/100);
//		 $int_sah_array[]=$int_sah_loss_total1;
  }
  
 
  if(($plan_sah_fac_a+$plan_sah_fac_b-$act_sah_fac-$ext_sah_loss_total1-$int_sah_loss_total1)<0)
  {
  	$total_prod_loss_array[]=0;
  }
  else{
  	$total_prod_loss_array[]=$plan_sah_fac_a+$plan_sah_fac_b-$act_sah_fac-$ext_sah_loss_total1-$int_sah_loss_total1;
  
  }
  $int_sah_array[]=$int_sah_loss_total1;
  echo "<td class=xl9713441 style='border-top:none;border-left:none'>".round($int_sah_loss_total1,2)."</td>";
  echo "<td class=xl9713441 style='border-top:none;border-left:none'>".round($plan_sah_fac_a+$plan_sah_fac_b-$act_sah_fac-$ext_sah_loss_total1-$int_sah_loss_total1,2)."</td>";
  
  $total_int_sah1=$total_int_sah1+round($int_sah_loss_total1,2);
  $int_sah_loss_total1=0;
  $ext_sah_loss_total1=0;
  $ext_sah_loss_total1s=0;
  $plan_sah_fac=0; $act_sah_fac=0; $plan_clh_fac=0; $act_sah_fac_a=0; $act_sah_fac_b=0; $plan_sah_fac_a=0; $plan_sah_fac_b=0;
  
}

$sql=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(plan_sth) as plan,SUM(act_sth) as act,SUM(plan_clh) as clh,shift FROM $bai_pro.grand_rep WHERE $total_sec_in and DATE between \"".$dat."\" and \"".$dat1."\" group by date,module,shift order by date,module ");
while($rows=mysqli_fetch_array($sql))
{
	$total_plan_sah_fac=$total_plan_sah_fac+round($rows["plan"],0);
	$total_act_sah_fac=$total_act_sah_fac+$rows["act"];
	$total_plan_clh_fac=$total_plan_clh_fac+$rows["clh"];
	if($rows["shift"] == "A")
	{
		$total_act_sah_fac_a=$total_act_sah_fac_a+$rows["act"];
	}
	else if($rows["shift"] == "B")
	{
		$total_act_sah_fac_b=$total_act_sah_fac_b+$rows["act"];
	}
	else
	{
		echo "No Shift";
	}
} 

$total_act_sah=$total_act_sah_fac;
$eff_array[]=round(($total_act_sah_fac/$total_plan_sah_fac)*100,1);

$total_prod_loss=0;
$total_prod_loss=$total_plan_sah_fac-$total_act_sah_fac-($total_ext_sah1+$total_ext_sah1s)-$total_int_sah1;


  echo "<td class=xl9713441 style='border-top:none;border-left:none'>".number_format($total_plan_sah_fac,0)."</td>
  <td class=xl9713441 style='border-top:none;border-left:none'>".number_format($total_act_sah_fac_a,0)."</td>
  <td class=xl9713441 style='border-top:none;border-left:none'>".number_format($total_act_sah_fac_b,0)."</td>
  <td class=xl9713441 style='border-top:none;border-left:none'>".number_format($total_act_sah_fac,0)."</td>
  <td class=xl9813441 style='border-top:none;border-left:none'>".round(($total_act_sah_fac/$total_plan_sah_fac)*100,1)."%</td>
  <td class=xl9813441 style='border-top:none;border-left:none'>".round(($total_act_sah_fac/$total_plan_clh_fac)*100,1)."%</td>
  <td class=xl9713441 style='border-top:none;border-left:none'>".round($total_ext_sah1+$total_ext_sah1s,2)."</td>
  <td class=xl9713441 style='border-top:none;border-left:none'>".round($total_int_sah1,2)."</td>
  <td class=xl9713441 style='border-top:none;border-left:none'>".round($total_plan_sah_fac-$total_act_sah_fac-($total_ext_sah1+$total_ext_sah1s)-$total_int_sah1,2)."</td>
  </tr>";  
  
 $lable=array("VS","M&S","Factory");
	
 echo "<tr height=25 style='height:18.75pt'>
  <td colspan=2 height=25 class=xl9513441 style='height:18.75pt'>External SAH
  loss</td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl8913441>".round($ext_sah_array[0]*100/$plan[0],1)."%</td>
  <td class=xl8913441>".round($int_sah_array[0]*100/$plan[0],1)."%</td>
   <td class=xl8913441>".round($total_prod_loss_array[0]*100/$plan[0],1)."%</td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl8913441>".round($ext_sah_array[1]*100/$plan[1],1)."%</td>
  <td class=xl8913441>".round($int_sah_array[1]*100/$plan[1],1)."%</td>
  <td class=xl8913441>".round($total_prod_loss_array[1]*100/$plan[1],1)."%</td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl8913441>".round((($total_ext_sah1+$total_ext_sah1s)/$total_plan_sah_fac)*100,1)."%</td>
  <td class=xl8913441>".round(($total_int_sah1/$total_plan_sah_fac)*100,1)."%</td>
  <td class=xl8913441>".round(($total_prod_loss/$total_plan_sah_fac)*100,1)."%</td>
 </tr>";  

 echo "<tr height=21 style='height:15.75pt'>
  <td height=21 class=xl8513441 style='height:15.75pt'></td>
  <td class=xl8413441></td>
  <td class=xl8713441></td>
  <td class=xl8713441></td>
  <td class=xl8613441></td>
  <td class=xl8613441></td>
  <td class=xl8813441></td>
  <td class=xl8813441></td>
  <td class=xl8813441></td>
  <td class=xl8813441></td>
  <td class=xl8713441></td>
  <td class=xl8713441></td>
  <td class=xl8613441></td>
  <td class=xl8613441></td>
  <td class=xl8813441></td>
  <td class=xl8813441></td>
  <td class=xl8813441></td>
  <td class=xl8813441></td>
  <td class=xl8713441></td>
  <td class=xl8713441></td>
  <td class=xl8613441></td>
  <td class=xl8613441></td>
  <td class=xl8813441></td>
  <td class=xl8813441></td>
  <td class=xl8813441></td>
  <td class=xl8813441></td>
  <td class=xl8713441></td>
  <td class=xl8713441></td>
  <td class=xl8613441></td>
  <td class=xl8613441></td>
  <td class=xl8813441></td>
  <td class=xl8813441></td>
  <td class=xl8813441></td>
  <td class=xl8813441></td>
  <td class=xl8713441></td>
  <td class=xl8713441></td>
  <td class=xl8613441></td>
  <td class=xl8613441></td>
  <td class=xl8813441></td>
  <td class=xl8813441></td>
  <td class=xl8813441></td>
  <td class=xl8813441></td>
  <td class=xl8713441></td>
  <td class=xl8713441></td>
  <td class=xl8613441></td>
  <td class=xl8613441></td>
  <td class=xl8813441></td>
  <td class=xl8813441></td>
  <td class=xl8813441></td>
  <td class=xl8813441></td>
  <td class=xl8713441></td>
  <td class=xl8713441></td>
  <td class=xl8613441></td>
  <td class=xl8613441></td>
  <td class=xl8813441></td>
  <td class=xl8813441></td>
  <td class=xl8813441></td>
  <td class=xl8813441></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl85212 rowspan=10 colspan=8 style='height:15.75pt'>
  <script type=\"text/javascript\">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'column'
            },
            title: {
			    align: 'left',
                text: 'Plan Vs Actual%'
            },
            xAxis: {
                categories: ['VS', 'MS','Factory']
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Achievement %'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
			exporting: {
            enabled: false
       		},
            legend: {
                align: 'left',
				layout: 'horizontal',
                x: 305,
                verticalAlign: 'top',
                y: -10,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +'<br/>'+
                        'Total: '+ this.point.stackTotal;
                }
            },
			plotOptions: {			
               column: {
			   pointPadding: 0.0,
			   borderWidth: 2,
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [{
                name: 'Plan Vs Act SAH',
                data: [".$eff_array[0].", ".$eff_array[1].",".$eff_array[2]."]
            },{
				name: 'External SAH Loss',
                data: [".round($ext_sah_array[0]*100/$plan[0],1).", ".round($ext_sah_array[1]*100/$plan[1],1).", ".round(($total_ext_sah1+$total_ext_sah1s)*100/$total_plan_sah_fac,1)."]
			},{
				name: 'Internal SAH Loss',
                data: [".round($int_sah_array[0]*100/$plan[0],1).", ".round($int_sah_array[1]*100/$plan[1],1).",".round($total_int_sah1*100/$total_plan_sah_fac,1)."]
			},{
				name: 'Production Loss',
                data: [".round($total_prod_loss_array[0]*100/$plan[0],1).", ".round($total_prod_loss_array[1]*100/$plan[1],1).",".round($total_prod_loss*100/$total_plan_sah_fac,1)."]
			}]
        });
    });
    
});
		</script>
	
<script src=".getFullURL($_GET['r'],'highcharts.js','R')."></script>
<script src=".getFullURL($_GET['r'],'exporting.js','R')."></script>

<div id=\"container\" style=\"width: 900px; height: 400px; margin: 0 auto\"></div>

  </td>
  
  
  <td colspan=3 rowspan=2 class=xl95212 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black'>No of Days</td>
  <td rowspan=2 class=xl101212 style='border-bottom:.5pt solid black'>".$days."</td>
  <td rowspan=2 class=xl101212 style='border-bottom:.5pt solid black'>VS</td>
  <td rowspan=2 class=xl101212 style='border-bottom:.5pt solid black'>M&S</td>
 </tr>";
$total_ext_sah1=0; $total_ext_sah1s=0;  $total_int_sah1=0;
 echo "<tr height=21 style='height:15.75pt'>
  <td class=xl86212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl87212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl87212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl87212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl87212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
 </tr>
 <tr height=21 style='height:15.75pt'>

  <td colspan=3 rowspan=2 class=xl93212>Planned SAH / Month</td>
  <td rowspan=2 class=xl94212 style='border-top:none'><span
  style='mso-spacerun:yes'></span>".number_format($fac_plan)." </td>
  <td rowspan=2 class=xl94212 style='border-top:none'><span
  style='mso-spacerun:yes'></span>".number_format($vs_sah_plan)." </td>
  <td rowspan=2 class=xl94212 style='border-top:none'><span
  style='mso-spacerun:yes'></span>".number_format($ms_sah_plan)." </td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl85212 style='height:15.75pt'></td>
  <td class=xl86212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl87212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl87212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl87212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl87212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
 </tr>
 <tr height=21 style='height:15.75pt'>

  <td colspan=3 rowspan=2 class=xl95212 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black'>Today Plan SAH</td>
  <td rowspan=2 class=xl103212 style='border-bottom:.5pt solid black;
  border-top:none'>".number_format($today_plan_sah)."</td>
  <td rowspan=2 class=xl103212 style='border-bottom:.5pt solid black;
  border-top:none'>".number_format($vs_plan_sah_today)."</td>
   <td rowspan=2 class=xl103212 style='border-bottom:.5pt solid black;
  border-top:none'>".number_format($ms_plan_sah_today)."</td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl85212 style='height:15.75pt'></td>
  <td class=xl86212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl87212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl87212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl87212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl87212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
 </tr>
 <tr height=21 style='height:15.75pt'>

  <td colspan=3 rowspan=2 class=xl95212 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black'>Today Actual SAH</td>
  <td rowspan=2 class=xl103212 style='border-bottom:.5pt solid black;
  border-top:none'>".number_format($today_sah)."</td>
  <td rowspan=2 class=xl103212 style='border-bottom:.5pt solid black;
  border-top:none'>".number_format($vs_act_sah_today)."</td>
   <td rowspan=2 class=xl103212 style='border-bottom:.5pt solid black;
  border-top:none'>".number_format($ms_act_sah_today)."</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl15212 style='height:15.0pt'></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
 </tr>
 <tr height=21 style='height:15.75pt'>


  <td colspan=3 rowspan=2 class=xl93212>MTD Plan SAH<span
  style='mso-spacerun:yes'></span></td>
  <td rowspan=2 class=xl94212 style='border-top:none'><span
  style='mso-spacerun:yes'></span>".number_format($vs_plan_sah+$ms_plan_sah)."</td>
  <td rowspan=2 class=xl94212 style='border-top:none'><span
  style='mso-spacerun:yes'></span>".number_format($vs_plan_sah)."</td>
  <td rowspan=2 class=xl94212 style='border-top:none'><span
  style='mso-spacerun:yes'></span>".number_format($ms_plan_sah)."</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl15212 style='height:15.0pt'></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl85212 style='height:15.75pt'></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td colspan=3 rowspan=2 class=xl93212>MTD Actual SAH<span
  style='mso-spacerun:yes'></span></td>
  <td rowspan=2 class=xl94212 style='border-top:none'><span
  style='mso-spacerun:yes'></span>".number_format($vs_act_sah+$ms_act_sah)."</td>
  <td rowspan=2 class=xl94212 style='border-top:none'><span
  style='mso-spacerun:yes'></span>".number_format($vs_act_sah)."</td>
  <td rowspan=2 class=xl94212 style='border-top:none'><span
  style='mso-spacerun:yes'></span>".number_format($ms_act_sah)."</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl15212 style='height:15.0pt'></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl85212 style='height:15.75pt'></td>
   <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td colspan=3 rowspan=2 class=xl93212>Avg SAH achieved<span
  style='mso-spacerun:yes'></span></td>
  <td rowspan=2 class=xl94212 style='border-top:none'><span
  style='mso-spacerun:yes'></span>".number_format(round($total_act_sah/$days,0))."</td>
  <td rowspan=2 class=xl94212 style='border-top:none'><span
  style='mso-spacerun:yes'></span>".number_format(round($vs_act_sah/$days,0))."</td>
  <td rowspan=2 class=xl94212 style='border-top:none'><span
  style='mso-spacerun:yes'></span>".number_format(round($ms_act_sah/$days,0))."</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl15212 style='height:15.0pt'></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl15212 style='height:15.0pt'></td>
   <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td colspan=3 rowspan=2 class=xl93212>SAH required</td>
  <td rowspan=2 class=xl94212 style='border-top:none'><span
  style='mso-spacerun:yes'></span>".number_format(($fac_plan-$total_act_sah)/(sizeof($date1)-$days))."</td>
   <td rowspan=2 class=xl94212 style='border-top:none'><span
  style='mso-spacerun:yes'></span>".number_format(($vs_sah_plan-$vs_act_sah)/(sizeof($date1)-$days))."</td>
   <td rowspan=2 class=xl94212 style='border-top:none'><span
  style='mso-spacerun:yes'></span>".number_format(($ms_sah_plan-$ms_act_sah)/(sizeof($date1)-$days))."</td>
 </tr>
 
  
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl15212 style='height:15.75pt'></td>
  <td class=xl84212></td>
  <td class=xl87212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl87212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl87212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl87212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl87212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl87212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl87212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=64 style='width:48pt'></td>
  <td width=83 style='width:62pt'></td>
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
  <td width=72 style='width:54pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=0></td>
  <td width=64 style='width:48pt'></td>
 </tr>
 <![endif]>
</table>

</div>";


}
?>

</div>
</div>