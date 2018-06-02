<!--
Ticket #347818/2014-06-02/Getting the Efficiency variation between eff report and sah report
EFF%=act_sah/act_clh
-->
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<title>Daily SAH</title>
<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> -->
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
	mso-number-format:0.0%;
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

</style>

<div class="panel panel-primary">
<div class="panel-heading">Daily Standard Hours Report</div>

<div class="panel-body">

<form action="<?php echo getFullURL($_GET['r'],'daily_sah_report_V5_Excel.php','N'); ?>" method="post">

<div class="row">
	<div class="col-md-3">
<label>Start Date</label>
<input type="text" data-toggle="datepicker" name="sdat"  id="sdat" class="form-control" size=8 value="<?php  if(isset($_POST['sdat'])) { echo $_POST['sdat']; } else { echo date("Y-m-d"); } ?>"/>
			  <?php 
	          $sHTML_Content.="<a href="."\"javascript:NewCssCal('sdat','yyyymmdd','dropdown')\">";
	          $sHTML_Content.="<img src='images/cal.gif' width='16' height='16' alt='Pick a date'></a>";
	          ?>
</div>	
<div class="col-md-3">		 
<label>End Date</label>
<input type="text" data-toggle="datepicker" class="form-control" name="edat" id="edat"  size=8 onchange="return verify_date();"  value="<?php  if(isset($_POST['edat'])) { echo $_POST['edat']; } else { echo date("Y-m-d"); } ?>"/>
			  <?php 
	          $sHTML_Content.="<a href="."\"javascript:NewCssCal('edat','yyyymmdd','dropdown')\">";
	          $sHTML_Content.="<img src='images/cal.gif' width='16' height='16' alt='Pick a date'></a>";
	          ?>
	</div>		 
<input type="submit" value="submit" name="submit" style="margin-top:22px;" onclick="return verify_date();"  class="btn btn-primary">

</div>

</form>


<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Excel's Publish as Web
Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!--->
<!START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->


<?php

if(isset($_POST["submit"]))
{
	echo "<hr/>";
include"header.php";

$sHTML_Content='<html><head><style id="SAH -JUN_13441_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
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
</style></head><body>';

//unlink("bar.php");
error_reporting(0);

$dat=$_POST["sdat"];

$dat1=$_POST["edat"];

$date_explode=explode("-",$dat);
$month=$date_explode[1];

function div_by_zero($arg)
{
	$arg1=1;
	if($arg==0 or $arg=='0' or $arg=='')
	{
		$arg1=1;
	}
	else
	{
		$arg1=$arg;
	}
	return $arg1;
}


include("../".getFullURLLevel($_GET['r'],'Production_Live_Chart/Control_Room_Charts/sah_monthly_status/data.php',1,'R')); 
//include("../Production_Live_Chart/Control_Room_Charts/sah_monthly_status/data.php");

$sql7=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(DISTINCT DATE) as days FROM grand_rep WHERE (DATE between \"$dat\" and \"$dat1\") and dayname(date)<>'Sunday'");
while($rows7=mysqli_fetch_array($sql7))
{
	$days=$rows7["days"];
	//$sHTML_Content.="<td rowspan=2 class=xl6527942 width=64 style='width:48pt'>".$rows7["COUNT(DISTINCT DATE)"]."</td>";
}

$sql7=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(act_sth) as sah FROM grand_rep WHERE DATE=\"".$dat1."\"");
while($rows7=mysqli_fetch_array($sql7))
{
	$today_sah=$rows7["sah"];
	//$sHTML_Content.="<td rowspan=2 class=xl6527942 width=64 style='width:48pt'>".$rows7["COUNT(DISTINCT DATE)"]."</td>";
}

//echo sizeof($date1);	
$sHTML_Content.="<div id=\"SAH -JUN_13441\" align=center x:publishsource=\"Excel\" class='table-responsive'>

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
  <td colspan=2 height=21 class=xl10113441 width=147 style='height:15.75pt;
  width:110pt'>Unit HOD</td>
  <td colspan=9 class=xl9313441 width=512 style='border-left:none;width:384pt'>Sandeepa</td>
  <td colspan=9 class=xl9313441 width=512 style='border-left:none;width:384pt'>Nihal</td>
  <td colspan=9 class=xl9313441 width=512 style='border-left:none;width:384pt'>Denaka</td>
  <td colspan=9 class=xl9313441 width=512 style='border-left:none;width:384pt'>Denaka</td>
  <td colspan=9 class=xl9313441 width=512 style='border-left:none;width:384pt'>Sandeepa</td>
  <td colspan=9 class=xl9313441 width=512 style='border-left:none;width:384pt'>Nihal</td>
  <td colspan=9 rowspan=4 class=xl9313441 width=520 style='width:390pt'>Factory</td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td colspan=2 height=21 class=xl10113441 style='height:15.75pt'>Section HOD</td>
  <td colspan=9 class=xl9313441 style='border-left:none'>Bhavani</td>
  <td colspan=9 class=xl9313441 style='border-left:none'>Nihal</td>
  <td colspan=9 class=xl9313441 style='border-left:none'>Dilan</td>
  <td colspan=9 class=xl9313441 style='border-left:none'>Pasan</td>
  <td colspan=9 class=xl9313441 style='border-left:none'>Kapila</td>
  <td colspan=9 class=xl9313441 style='border-left:none'></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td colspan=2 height=21 class=xl10113441 style='height:15.75pt'>Section Work
  Study</td>
  <td colspan=9 class=xl9313441 style='border-left:none'>Udara</td>
  <td colspan=9 class=xl9313441 style='border-left:none'>Indika</td>
  <td colspan=9 class=xl9313441 style='border-left:none'>Sankha</td>
  <td colspan=9 class=xl9313441 style='border-left:none'>Sankha</td>
  <td colspan=9 class=xl9313441 style='border-left:none'>Udara</td>
  <td colspan=9 class=xl9313441 style='border-left:none'>Indika</td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td colspan=2 height=21 class=xl10113441 style='height:15.75pt'>Production
  Executives</td>
  <td colspan=9 class=xl9313441 style='border-left:none'>Purnima(Shift
  A) / Nalaka (Shift - B)</td>
  <td colspan=9 class=xl9313441 style='border-left:none'>Chintaka (Shift A) /
  Budhika (Shift - B)</td>
  <td colspan=9 class=xl9313441 style='border-left:none'>Asela(Shift A) / Nuwan
  (Shift - B)</td>
  <td colspan=9 class=xl9313441 style='border-left:none'>Kasun (Shift A)
  /Mahesh (Shift - B)</td>
  <td colspan=9 class=xl9313441 style='border-left:none'>Keerthi (Shift A) /
  Channa (Shift - B)</td>
  <td colspan=9 class=xl9313441 style='border-left:none'>Ajith (Shift A) /
  Santhosh (Shift - B)</td>
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
  <td rowspan=2 class=xl9913441 style='border-top:none'><span
  style='mso-spacerun:yes'>�</span>PLAN SAH</td>
  <td colspan=3 class=xl9913441 style='border-left:none'>ACTUAL SAH</td>
  <td rowspan=2 class=xl9613441 width=64 style='border-top:none;width:48pt'>Actual
  %</td>
  <td rowspan=2 class=xl9613441 width=72 style='border-top:none;width:54pt'>EFF %</td>
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
  <td class=xl9913441 style='border-top:none;border-left:none'>A</td>
  <td class=xl9913441 style='border-top:none;border-left:none'>B</td>
  <td class=xl9913441 style='border-top:none;border-left:none'>Total</td>
  <td class=xl9913441 style='border-top:none;border-left:none'>A</td>
  <td class=xl9913441 style='border-top:none;border-left:none'>B</td>
  <td class=xl9913441 style='border-top:none;border-left:none'>Total</td>
  <td class=xl9913441 style='border-top:none;border-left:none'>A</td>
  <td class=xl9913441 style='border-top:none;border-left:none'>B</td>
  <td class=xl9913441 style='border-top:none;border-left:none'>Total</td>
  <td class=xl9913441 style='border-top:none;border-left:none'>A</td>
  <td class=xl9913441 style='border-top:none;border-left:none'>B</td>
  <td class=xl9913441 style='border-top:none;border-left:none'>Total</td>
 </tr>";
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
 $vs_sah_plan="246163";
 $ms_sah_plan="91610";
 
$sql_vs="SELECT SUM(plan_sth) as plan,SUM(act_sth) as act from grand_rep where (buyer like \"%VS Logo%\" or buyer like \"%VS Pink%\" or buyer like \"%Glamour%\") and date between \"$dat\" and \"$dat1\"";
//echo $sql_vs;
$result_vs=mysqli_query($link, $sql_vs) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row_vs=mysqli_fetch_array($result_vs))
{
	$vs_act_sah=$row_vs["act"];
}

$sql_ms="SELECT SUM(plan_sth) as plan,SUM(act_sth) as act from grand_rep where (buyer like \"%M&S%\") and date between \"$dat\" and \"$dat1\"";
//echo $sql_ms;
$result_ms=mysqli_query($link, $sql_ms) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row_ms=mysqli_fetch_array($result_ms))
{
	$ms_act_sah=$row_ms["act"];
}

$sql_vs_today="SELECT SUM(plan_sth) as plan,SUM(act_sth) as act from grand_rep where (buyer like \"%VS Logo%\" or buyer like \"%VS Pink%\" or buyer like \"%Glamour%\") and date=\"$dat1\"";
//echo $sql_vs;
$result_vs_today=mysqli_query($link, $sql_vs_today) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row_vs_today=mysqli_fetch_array($result_vs_today))
{
	$vs_act_sah_today=$row_vs_today["act"];
}

$sql_ms_today="SELECT SUM(plan_sth) as plan,SUM(act_sth) as act from grand_rep where (buyer like \"%M&S%\") and date=\"$dat1\"";
//echo $sql_ms;
$result_ms_today=mysqli_query($link, $sql_ms_today) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row_ms_today=mysqli_fetch_array($result_ms_today))
{
	$ms_act_sah_today=$row_ms_today["act"];
}
 
 
$sql_dat=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct date from grand_rep where date between \"$dat\" and \"$dat1\" order by date");
while($row=mysqli_fetch_array($sql_dat))
{
  $date = $row['date']; 
  $weekday = date('l', strtotime($date));
  $sHTML_Content.="<tr height=21 style='height:15.75pt'>
  <td height=21 class=xl10313441 style='height:15.75pt;border-top:none'>".$weekday."</td>
  <td class=xl10413441 style='border-top:none;border-left:none'>".$date."</td>";
  
  for($i=1;$i<=7;$i++)
  {	
	
	  $sql=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(plan_sth) as plan,SUM(act_sth) as act,SUM(act_clh) as clh,shift FROM grand_rep WHERE DATE=\"".$row["date"]."\" AND section=\"$i\" group by module,shift order by module");	 
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
				$sHTML_Content.="No Shift";
			}
	  }
	  if($i!=7 and $plan_sah!=0)	  
	  {
	  $sHTML_Content.="<td class=xl10513441 style='border-top:none;border-left:none'>".number_format($plan_sah_a+$plan_sah_b,0)."</td>";
	  $sHTML_Content.="<td class=xl10513441 style='border-top:none;border-left:none'>".number_format($act_sah_a,0)."</td>";
	  $sHTML_Content.="<td class=xl10613441 style='border-top:none;border-left:none'>".number_format($act_sah_b,0)."</td>";
	  $sHTML_Content.="<td class=xl10613441 style='border-top:none;border-left:none'>".number_format($act_sah_a+$act_sah_b,0)."</td>";
	  $sHTML_Content.="<td class=xl10713441 style='border-top:none;border-left:none'>".round((($act_sah_a+$act_sah_b)/$plan_sah)*100,1)."%</td>";
	  $sHTML_Content.="<td class=xl10713441 style='border-top:none;border-left:none'>".round((($act_sah_a+$act_sah_b)/$plan_clh)*100,1)."%</td>";
	  }
	  $sql1="select mod_no,dtime,shift,plan_eff from down_log where section=\"".$i."\" and date=\"".$row["date"]."\" and source=1 and remarks!=\"Open capacity\"";
	  $result1=mysqli_query($link, $sql1) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	  while($row1=mysqli_fetch_array($result1))
	  {
	  		 $mod_no=$row1["mod_no"];
			 $dtime=$row1["dtime"]/60;
			 $shift=$row1["shift"];
			 $plan_eff_down=round($row1["plan_eff"],0);
			 if($plan_eff_down > 0)
			 {
			 	$sql2="select plan_eff from down_log where section=\"".$i."\" and date=\"".$row["date"]."\" and mod_no=\"".$mod_no."\" and shift=\"".$shift."\" ";
				 $result2=mysqli_query($link, $sql2) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while($row2=mysqli_fetch_array($result2))
				 {
				 	$plan_eff=$row2["plan_eff"];
				 } 
			 }
			 else
			 {
			 	 $sql2="select plan_eff from pro_plan where sec_no=\"".$i."\" and date=\"".$row["date"]."\" and mod_no=\"".$mod_no."\" and shift=\"".$shift."\" ";
				 $result2=mysqli_query($link, $sql2) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while($row2=mysqli_fetch_array($result2))
				 {
				 	$plan_eff=$row2["plan_eff"];
				 } 
				 if($plan_eff ==0)
				 {
				 	$sql2="SELECT MAX(DATE) as max_date FROM pro_plan WHERE plan_eff > 0 AND DATE <= \"".$row["date"]."\"  and mod_no=\"$mod_no\" and shift=\"$shift\"";
		//echo $sql2;
					$sql_result2=mysqli_query($link, $sql2) or die("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row2=mysqli_fetch_array($sql_result2))
					{
						$max_date=$sql_row2["max_date"];
						$sql21="SELECT plan_eff FROM pro_plan WHERE plan_eff > 0 AND DATE=\"".$max_date."\"  and mod_no=\"$mod_no\" and shift=\"$shift\"";
						//echo $sql2;
						$sql_result21=mysqli_query($link, $sql21) or die("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row21=mysqli_fetch_array($sql_result21))
						{
							$plan_eff=$sql_row21["plan_eff"];
							//$sHTML_Content.="<td>".$plan_eff."%</td>";
						}
					}	
				 }
			 }
			 
			 
			 $ext_sah_loss_total=$ext_sah_loss_total+($dtime*$plan_eff/100);
	  }
	  if($i!=7)	  
	  {
	  $sHTML_Content.="<td class=xl10813441 style='border-top:none;border-left:none'>".round($ext_sah_loss_total,2)."</td>";
	  }
	  $total_ext_sah=$total_ext_sah+round($ext_sah_loss_total,2);	 
	  
	  $sql1x="select mod_no,dtime,shift,plan_eff from down_log where section=\"".$i."\" and date=\"".$row["date"]."\" and source=1 and remarks=\"Open capacity\"";
	  $result1x=mysqli_query($link, $sql1x) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	  while($row1x=mysqli_fetch_array($result1x))
	  {
	  		 $mod_nox=$row1x["mod_no"];
			 $dtimex=$row1x["dtime"]/60;
			 $shiftx=$row1x["shift"];
			 $plan_eff_downx=round($row1x["plan_eff"],0);
			 if($plan_eff_downx > 0)
			 {
			 	$sql2x="select plan_eff from down_log where section=\"".$i."\" and date=\"".$row["date"]."\" and mod_no=\"".$mod_nox."\" and shift=\"".$shiftx."\" ";
				 $result2x=mysqli_query($link, $sql2x) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while($row2x=mysqli_fetch_array($result2x))
				 {
				 	$plan_effx=$row2x["plan_eff"];
				 } 
			 }
			 else
			 {
			 	 $sql2x="select plan_eff from pro_plan where sec_no=\"".$i."\" and date=\"".$row["date"]."\" and mod_no=\"".$mod_nox."\" and shift=\"".$shiftx."\" ";
				 $result2x=mysqli_query($link, $sql2x) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while($row2x=mysqli_fetch_array($result2x))
				 {
				 	$plan_effx=$row2x["plan_eff"];
				 } 
				 if($plan_effx ==0)
				 {
				 	$sql2x="SELECT MAX(DATE) as max_date FROM pro_plan WHERE plan_eff > 0 AND DATE <= \"".$row["date"]."\"  and mod_no=\"$mod_nox\" and shift=\"$shiftx\"";
		//echo $sql2;
					$sql_result2x=mysqli_query($link, $sql2x) or die("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row2x=mysqli_fetch_array($sql_result2x))
					{
						$max_datex=$sql_row2x["max_date"];
						$sql21x="SELECT plan_eff FROM pro_plan WHERE plan_eff > 0 AND DATE=\"".$max_datex."\"  and mod_no=\"$mod_nox\" and shift=\"$shiftx\"";
						//echo $sql2;
						$sql_result21x=mysqli_query($link, $sql21x) or die("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row21x=mysqli_fetch_array($sql_result21x))
						{
							$plan_effx=$sql_row21x["plan_eff"];
							//$sHTML_Content.="<td>".$plan_eff."%</td>";
						}
					}	
				 }
			 }
			 
			 
			 $ext_sah_loss_totalx=$ext_sah_loss_totalx+($dtimex*$plan_effx/100);
	  }
	  
	  //$sHTML_Content.="<td class=xl10813441 style='border-top:none;border-left:none'>".round($ext_sah_loss_total,2)."</td>";
	  $total_ext_sahx=$total_ext_sahx+round($ext_sah_loss_totalx,2);	  
	  
	  $sql11="select mod_no,dtime,shift,plan_eff from down_log where section=\"".$i."\" and date=\"".$row["date"]."\" and source=0 order by mod_no,shift";
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
			$sql21="select plan_eff from pro_plan where sec_no=\"".$i."\" and date=\"".$row["date"]."\" and mod_no=\"".$mod_no1."\" and shift=\"".$shift1."\" ";
			//echo $sql21."<br>";
			$result21=mysqli_query($link, $sql21) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row21=mysqli_fetch_array($result21))
			{
				$plan_eff1=$row21["plan_eff"];//$sHTML_Content.="Mod =".$mod_no1."-".$plan_eff1;
			} 
		}
		
	    $int_sah_loss_total=$int_sah_loss_total+($dtime1*$plan_eff1/100);
	  }
	  if($i!=7)	  
	  {
	  $sHTML_Content.="<td class=xl10813441 style='border-top:none;border-left:none'>".round($int_sah_loss_total,2)."</td>";
	  $sHTML_Content.="<td class=xl10813441 style='border-top:none;border-left:none'>".number_format($plan_sah_a+$plan_sah_b-($act_sah_a+$act_sah_b)-$ext_sah_loss_total-$int_sah_loss_total,2)."</td>";
	  }
	  $total_int_sah=$total_int_sah+round($int_sah_loss_total,2);	  
	  
	  $plan_sah=0; $act_sah=0; $plan_clh=0; $act_sah_a=0; $act_sah_b=0; $int_sah_loss_total=0; $ext_sah_loss_total=0; $ext_sah_loss_totalx=0; $plan_sah_a=0; $plan_sah_b=0;
  }	
  
  $sql=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(plan_sth) as plan,SUM(act_sth) as act,SUM(act_clh) as clh,shift FROM grand_rep WHERE DATE=\"".$row["date"]."\" group by module,shift order by module");
  while($rows=mysqli_fetch_array($sql))
  {
		$plan_sah_sec=$plan_sah_sec+$rows["plan"];
		$act_sah_sec=$act_sah_sec+$rows["act"];
		$plan_clh_sec=$plan_clh_sec+$rows["clh"];
		if($rows["shift"] == "A")
		{
			$act_sah_sec_a=$act_sah_sec_a+$rows["act"];
			$plan_sah_sec_a=$plan_sah_sec_a+round($rows["plan"],0);
		}
		else if($rows["shift"] == "B")
		{
			$act_sah_sec_b=$act_sah_sec_b+$rows["act"];
			$plan_sah_sec_b=$plan_sah_sec_b+round($rows["plan"],0);
		}
		else
		{
			$sHTML_Content.="No Shift";
		}
  }	  
  

  $sHTML_Content.="<td class=xl10513441 style='border-top:none;border-left:none'>".number_format($plan_sah_sec_a+$plan_sah_sec_b,0)."</td>
  <td class=xl10513441 style='border-top:none;border-left:none'>".number_format($act_sah_sec_a,0)."</td>
  <td class=xl10613441 style='border-top:none;border-left:none'>".number_format($act_sah_sec_b,0)."</td>
  <td class=xl10613441 style='border-top:none;border-left:none'>".number_format($act_sah_sec,0)."</td>
  <td class=xl10713441 style='border-top:none;border-left:none'>".round(($act_sah_sec/$plan_sah_sec)*100,1)."%</td>
  <td class=xl10713441 style='border-top:none;border-left:none'>".round(($act_sah_sec/$plan_clh_sec)*100,1)."%</td>
  <td class=xl10813441 style='border-top:none;border-left:none'>".round($total_ext_sah+$total_ext_sahx,2)."</td>
  <td class=xl10813441 style='border-top:none;border-left:none'>".round($total_int_sah,2)."</td>
  <td class=xl10813441 style='border-top:none;border-left:none'>".round($plan_sah_sec_a+$plan_sah_sec_b-$act_sah_sec-($total_ext_sah+$total_ext_sahx)-$total_int_sah,2)."</td>
 </tr>";
 
 $plan_sah_sec=0; $act_sah_sec_a=0; $act_sah_sec_b=0;$act_sah_sec=0;$total_ext_sah=0;$total_ext_sahx=0;$total_int_sah=0;$plan_clh_sec=0;$plan_sah_sec_a=0;$plan_sah_sec_b=0;
 
} 

$eff_array=array();

$sHTML_Content.="<tr height=27 style='mso-height-source:userset;height:20.25pt'>
<td colspan=2 height=27 class=xl10013441 style='height:20.25pt'>Total</td>";

for($i2=1;$i2<=7;$i2++)
{	

  $sql=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(plan_sth) as plan,SUM(act_sth) as act,SUM(act_clh) as clh,shift FROM grand_rep WHERE DATE between \"".$dat."\" and \"".$dat1."\" AND section=\"".$i2."\" group by date,module,shift order by date,module");
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
			$sHTML_Content.="No Shift";
		}
  }
  
  
  if($i2!=7)	  
  {

  $plan[]=$plan_sah_fac;  
  $eff_array[]=round(($act_sah_fac/$plan_sah_fac)*100,1);
  $sHTML_Content.="<td class=xl9713441 style='border-top:none;border-left:none'>".number_format($plan_sah_fac_a+$plan_sah_fac_b,0)."</td>";
  $sHTML_Content.="<td class=xl9713441 style='border-top:none;border-left:none'>".number_format($act_sah_fac_a,0)."</td>";
  $sHTML_Content.="<td class=xl9713441 style='border-top:none;border-left:none'>".number_format($act_sah_fac_b,0)."</td>";
  $sHTML_Content.="<td class=xl9713441 style='border-top:none;border-left:none'>".number_format($act_sah_fac,0)."</td>";
  $sHTML_Content.="<td class=xl9813441 style='border-top:none;border-left:none'>".round(($act_sah_fac/$plan_sah_fac)*100,1)."%</td>";
  $sHTML_Content.="<td class=xl9813441 style='border-top:none;border-left:none'>".round(($act_sah_fac/$plan_clh_fac)*100,1)."%</td>";
  }
   $sql13="select mod_no,dtime,shift,date,plan_eff from down_log where section=\"".$i2."\" and DATE between \"".$dat."\" and \"".$dat1."\" and source=1 and remarks!=\"Open capacity\"";
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
		 	$sql23="select plan_eff from down_log where section=\"".$i2."\" and date=\"".$dates3."\" and mod_no=\"".$mod_no3."\" and shift=\"".$shift3."\" ";
			 $result23=mysqli_query($link, $sql23) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while($row23=mysqli_fetch_array($result23))
			 {
			 	$plan_eff3=$row23["plan_eff"];
			 } 
		 }
		 else
		 {
		 	 $sql23="select plan_eff from pro_plan where sec_no=\"".$i2."\" and date=\"".$dates3."\" and mod_no=\"".$mod_no3."\" and shift=\"".$shift3."\" ";	//echo $sql23."<br>";	
			 $result23=mysqli_query($link, $sql23) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while($row23=mysqli_fetch_array($result23))
			 {
			 	$plan_eff3=$row23["plan_eff"];
			 } 
			 if($plan_eff3 ==0)
			 {
			 	$sql23="SELECT MAX(DATE) as max_date FROM pro_plan WHERE plan_eff > 0 AND DATE <= \"".$dates3."\"  and mod_no=\"$mod_no3\" and shift=\"$shift3\"";
	//echo $sql2;
				$sql_result23=mysqli_query($link, $sql23) or die("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row23=mysqli_fetch_array($sql_result23))
				{
					$max_date1=$sql_row23["max_date"];
					$sql213="SELECT plan_eff FROM pro_plan WHERE plan_eff > 0 AND DATE=\"".$max_date1."\"  and mod_no=\"$mod_no3\" and shift=\"$shift3\"";
					//echo $sql2;
					$sql_result213=mysqli_query($link, $sql213) or die("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row213=mysqli_fetch_array($sql_result213))
					{
						$plan_eff3=$sql_row213["plan_eff"];
						//$sHTML_Content.="<td>".$plan_eff3."%</td>";
					}
				}	
			 }
		 }
		 /*$sql23="select plan_eff from pro_plan where sec_no=\"".$i2."\" and date=\"".$dates3."\" and mod_no=\"".$mod_no3."\" and shift=\"".$shift3."\" ";	 //echo $sql23;	
		 $result23=mysql_query($sql23,$link) or die("Error = ".mysql_error());
		 while($row23=mysql_fetch_array($result23))
		 {
		 	$plan_eff3=$row23["plan_eff"];
		 } */
		 
		 $ext_sah_loss_total1=$ext_sah_loss_total1+($dtime3*$plan_eff3/100);
  }
  if($i2!=7)	  
  {
  $sHTML_Content.="<td class=xl9713441 style='border-top:none;border-left:none'>".round($ext_sah_loss_total1,2)."</td>";
  }
  $ext_sah_array[]=$ext_sah_loss_total1;
  $total_ext_sah1=$total_ext_sah1+round($ext_sah_loss_total1,2);
  
  
  
 $sql13s="select mod_no,dtime,shift,date,plan_eff from down_log where section=\"".$i2."\" and DATE between \"".$dat."\" and \"".$dat1."\" and source=1 and remarks=\"Open capacity\" order by mod_no,shift";
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
		 	$sql23s="select plan_eff from down_log where section=\"".$i2."\" and date=\"".$dates3s."\" and mod_no=\"".$mod_no3s."\" and shift=\"".$shift3s."\" ";
			//echo $sql23s."<br>";
			 $result23s=mysqli_query($link, $sql23s) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while($row23s=mysqli_fetch_array($result23s))
			 {
			 	$plan_eff3s=$row23s["plan_eff"];
			 } 
		 }
		 else
		 {
		 	 $sql23s="select plan_eff from pro_plan where sec_no=\"".$i2."\" and date=\"".$dates3s."\" and mod_no=\"".$mod_no3s."\" and shift=\"".$shift3s."\" ";	//echo $sql23s."<br>";	
			 $result23s=mysqli_query($link, $sql23s) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while($row23s=mysqli_fetch_array($result23s))
			 {
			 	$plan_eff3s=$row23s["plan_eff"];
			 } 
			 if($plan_eff3s == 0)
			 {
			 	$sql23s="SELECT MAX(DATE) as max_date FROM pro_plan WHERE plan_eff > 0 AND DATE <= \"".$dates3s."\"  and mod_no=\"$mod_no3s\" and shift=\"$shift3s\"";
				//echo $sql2;
				$sql_result23s=mysqli_query($link, $sql23s) or die("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row23s=mysqli_fetch_array($sql_result23s))
				{
					$max_date1s=$sql_row23s["max_date"];
					$sql213s="SELECT plan_eff FROM pro_plan WHERE plan_eff > 0 AND DATE=\"".$max_date1s."\"  and mod_no=\"$mod_no3s\" and shift=\"$shift3s\"";		//echo $sql2;
					$sql_result213s=mysqli_query($link, $sql213s) or die("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row213s=mysqli_fetch_array($sql_result213s))
					{
						$plan_eff3s=$sql_row213s["plan_eff"];
						//$sHTML_Content.="<td>".$plan_eff3."%</td>";
					}
				}	
			 }
		 }
		/* $sql23="select plan_eff from pro_plan where sec_no=\"".$i2."\" and date=\"".$dates3."\" and mod_no=\"".$mod_no3."\" and shift=\"".$shift3."\" ";	 //echo $sql23;	
		 $result23=mysql_query($sql23,$link) or die("Error = ".mysql_error());
		 while($row23=mysql_fetch_array($result23))
		 {
		 	$plan_eff3=$row23["plan_eff"];
		 } */
		 
		 $ext_sah_loss_total1s=$ext_sah_loss_total1s+($dtime3s*$plan_eff3s/100);
		 //echo $ext_sah_loss_total1s."-".$dtime3s."-".$plan_eff3s."-".$mod_no3s."-".$shift3s."-".$dates3s."<br>";
  }
  
  //$sHTML_Content.="<td class=xl9713441 style='border-top:none;border-left:none'>".round($ext_sah_loss_total1,2)."</td>";
  //$ext_sah_array[]=$ext_sah_loss_total1s;
  $total_ext_sah1s=$total_ext_sah1s+round($ext_sah_loss_total1s,2);
  //$sHTML_Content.="sah = ".$total_ext_sah1s;
  
  
  
  
  $sql113="select mod_no,dtime,shift,date from down_log where section=\"".$i2."\" and DATE between \"".$dat."\" and \"".$dat1."\" and source=0 order by date,mod_no,shift";
  $result113=mysqli_query($link, $sql113) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
  while($row113=mysqli_fetch_array($result113))
  {
  		 $mod_no13=$row113["mod_no"];
		 $dtime13=$row113["dtime"]/60;
		 $shift13=$row113["shift"];
		 $dates13=$row113["date"];
		 $sql213="select plan_eff from pro_plan where sec_no=\"".$i2."\" and date=\"".$dates13."\" and mod_no=\"".$mod_no13."\" and shift=\"".$shift13."\" ";
		 //echo $sql213."-".$dtime13."<br>";
		 $result213=mysqli_query($link, $sql213) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		 while($row213=mysqli_fetch_array($result213))
		 {
		 	$plan_eff13=$row213["plan_eff"];
		 } 
		 
		 $int_sah_loss_total1=$int_sah_loss_total1+($dtime13*$plan_eff13/100);
  }
  if($i2!=7)	  
  {
  $sHTML_Content.="<td class=xl9713441 style='border-top:none;border-left:none'>".round($int_sah_loss_total1,2)."</td>";
  $sHTML_Content.="<td class=xl9713441 style='border-top:none;border-left:none'>".round($plan_sah_fac_a+$plan_sah_fac_b-$act_sah_fac-$ext_sah_loss_total1-$int_sah_loss_total1,2)."</td>";
  }
  $total_int_sah1=$total_int_sah1+round($int_sah_loss_total1,2);
  $int_sah_loss_total1=0;
  $ext_sah_loss_total1=0;
  $ext_sah_loss_total1s=0;
  $plan_sah_fac=0; $act_sah_fac=0; $plan_clh_fac=0; $act_sah_fac_a=0; $act_sah_fac_b=0; $plan_sah_fac_a=0; $plan_sah_fac_b=0;
  
}

$sql=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(plan_sth) as plan,SUM(act_sth) as act,SUM(act_clh) as clh,shift FROM grand_rep WHERE DATE between \"".$dat."\" and \"".$dat1."\" group by date,module,shift order by date,module ");
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
		$sHTML_Content.="No Shift";
	}
} 

$total_act_sah=$total_act_sah_fac;
$eff_array[]=round(($total_act_sah_fac/$total_plan_sah_fac)*100,1);

  $sHTML_Content.="<td class=xl9713441 style='border-top:none;border-left:none'>".number_format($total_plan_sah_fac,0)."</td>
  <td class=xl9713441 style='border-top:none;border-left:none'>".number_format($total_act_sah_fac_a,0)."</td>
  <td class=xl9713441 style='border-top:none;border-left:none'>".number_format($total_act_sah_fac_b,0)."</td>
  <td class=xl9713441 style='border-top:none;border-left:none'>".number_format($total_act_sah_fac,0)."</td>
  <td class=xl9813441 style='border-top:none;border-left:none'>".round(($total_act_sah_fac/$total_plan_sah_fac)*100,1)."%</td>
  <td class=xl9813441 style='border-top:none;border-left:none'>".round(($total_act_sah_fac/$total_plan_clh_fac)*100,1)."%</td>
  <td class=xl9713441 style='border-top:none;border-left:none'>".round($total_ext_sah1+$total_ext_sah1s,2)."</td>
  <td class=xl9713441 style='border-top:none;border-left:none'>".round($total_int_sah1,2)."</td>
  <td class=xl9713441 style='border-top:none;border-left:none'>".round($total_plan_sah_fac-$total_act_sah_fac-($total_ext_sah1+$total_ext_sah1s)-$total_int_sah1,2)."</td>
  </tr>";
 
  
  $lable=array("Bhavani","Nihal","Dilan","Pasan","Channa","Ruwan","Factory");
	
 $sHTML_Content.="<tr height=25 style='height:18.75pt'>
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
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl8913441>".round($ext_sah_array[1]*100/$plan[1],1)."%</td>
  <td class=xl8913441>".round($int_sah_array[1]*100/$plan[1],1)."%</td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl8913441>".round($ext_sah_array[2]*100/$plan[2],1)."%</td>
  <td class=xl8913441>".round($int_sah_array[2]*100/$plan[2],1)."%</td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl8913441>".round($ext_sah_array[3]*100/$plan[3],1)."%</td>
  <td class=xl8913441>".round($int_sah_array[3]*100/$plan[3],1)."%</td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl8913441>".round($ext_sah_array[4]*100/$plan[4],1)."%</td>
  <td class=xl8913441>".round($int_sah_array[4]*100/$plan[4],1)."%</td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl8913441>".round($ext_sah_array[5]*100/$plan[5],1)."%</td>
  <td class=xl8913441>".round($int_sah_array[5]*100/$plan[5],1)."%</td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl8913441>".round(($total_ext_sah1+$total_ext_sah1s)*100/$total_plan_sah_fac,1)."%</td>
  <td class=xl8913441>".round($total_int_sah1*100/$total_plan_sah_fac,1)."%</td>
 </tr>
 <tr height=21 style='height:15.75pt'>
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
 <tr style='height:14.75pt'>
  <td rowspan=5 colspan=9 class=xl8513441 style='height:12.75pt'>"; 
 $sHTML_Content.="</td>
  <td class=xl8813441>
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
                text: 'Section Wise Eff% Graph'
            },
            xAxis: {
                categories: ['Section-1', 'Section-2', 'Section-3', 'Section-4', 'Section-5','Section-6','Factory']
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Efficiency %'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            legend: {
                align: 'right',
                x: -100,
                verticalAlign: 'top',
                y: 20,
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
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },
            series: [{
                name: 'Show/Hide',
                data: [".$eff_array[0].", ".$eff_array[1].",".$eff_array[2].", ".$eff_array[3].", ".$eff_array[4].", ".$eff_array[5].", ".$eff_array[6]."]
            }]
        });
    });
    
});

		</script>
	
<script src=".getFullURL($_GET['r'],'highcharts.js','R')."></script>
<script src=".getFullURL($_GET['r'],'exporting.js','R')."></script>
  </td>";
  $total_ext_sah1=0; $total_ext_sah1s=0;  $total_int_sah1=0;
  $sHTML_Content.="
  
 
  <td colspan=3 rowspan=1 class=xl9413441>No of Days</td>
  <td rowspan=1 class=xl9113441>".$days."</td>
 <td rowspan=1 class=xl9113441>VS</td>
  <td rowspan=1 class=xl9113441>M&S</td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
 </tr>
 <tr height=21 style='height:14.75pt'>
  <td height=21 class=xl8513441 style='height:2.75pt'></td>
  
  <td colspan=3 rowspan=1 class=xl9413441>Budgeted SAH / Month</td>
  <td rowspan=1 class=xl9013441 style='border-top:none'>".number_format($fac_plan)."</td>
 <td rowspan=1 class=xl9013441 style='border-top:none'>".number_format($vs_sah_plan)."</td>
  <td rowspan=1 class=xl9013441 style='border-top:none'>".number_format($ms_sah_plan)."</td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
 </tr>
 <tr height=21 style='height:14.75pt'>
  <td height=21 class=xl8513441 style='height:2.75pt'></td>

  <td colspan=3 rowspan=1 class=xl9413441>Today SAH</td>
  <td rowspan=1 class=xl9213441 style='border-top:none'>".number_format($today_sah)."</td>
  <td rowspan=1 class=xl9213441 style='border-top:none'>".number_format($vs_act_sah_today)."</td>
   <td rowspan=1 class=xl9213441 style='border-top:none'>".number_format($ms_act_sah_today)."</td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
 </tr>
 <tr height=21 style='height:14.75pt'>
  <td height=21 class=xl8513441 style='height:2.75pt'></td>

  <td colspan=3 rowspan=1 class=xl9413441>Avg SAH achieved<span
  style='mso-spacerun:yes'>�</span></td>
  <td rowspan=1 class=xl9013441 style='border-top:none'>".number_format(round($total_act_sah/$days,0))."</td>
   <td rowspan=1 class=xl9013441 style='border-top:none'>".number_format(round($vs_act_sah/$days,0))."</td>
   <td rowspan=1 class=xl9013441 style='border-top:none'>".number_format(round($ms_act_sah/$days,0))."</td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
 </tr>
 <tr height=20 style='height:14.75pt'>
  <td height=20 class=xl1513441 style='height:4.0pt'></td>

  <td colspan=3 rowspan=1 class=xl9413441>SAH required</td>
  <td rowspan=1 class=xl9013441 style='border-top:none'>".number_format(($fac_plan-$total_act_sah)/(sizeof($date1)-$days))." </td>
  <td rowspan=1 class=xl9013441 style='border-top:none'>".number_format(($vs_sah_plan-$vs_act_sah)/(sizeof($date1)-$days))." </td>
  <td rowspan=1 class=xl9013441 style='border-top:none'>".number_format(($ms_sah_plan-$ms_act_sah)/(sizeof($date1)-$days))." </td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
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
 </tr>
 <![endif]>
</table>

</div>";
$sHTML_Content.="</body></html>";

echo $sHTML_Content;


$myFile = "daily_sah_report_v5.xls";

$path_new="../".getFullURL($_GET['r'],"$myFile","R");

unlink($myFile);

$fh = fopen($path_new, 'w') or die("can't open file");
$stringData=$sHTML_Content;
fwrite($fh, $stringData);

fclose($fh);

}
?>
</div>
</div>
</html>

<!--->
<!END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!--->



