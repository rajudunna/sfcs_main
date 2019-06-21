<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
//$view_access=user_acl("SFCS_0060",$username,1,$group_id_sfcs);
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<meta http-equiv="content-type" content="text/plain; charset=UTF-8"/>
<title>Daily SAH</title>
<!-- <script type="text/javascript" src="jquery.min.js"></script> -->
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 14">
<link rel=File-List href="SAH%20-JUN_files/filelist.xml">
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/FileSaver.js',1,'R');?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/datetimepicker_css.js',3,'R');?>"></script>
<script language="JavaScript" src="<?= getFullURLLevel($_GET['r'],'common/js/FusionCharts.js',3,'R');?>"></script>
<script type="text/javascript" language="JavaScript" src="<?= getFullURLLevel($_GET['r'],'js/FusionChartsExportComponent.js',3,'R');?>"></script>
<style id="SAH -JUN_13441_Styles">

</style>
<script>
function abc(value,x)
{

var count=0;
if(value == "")
{
	document.getElementById("exp_sec").value=0;
}



var iChars = " `~_!@#$%^&*()+=-[]\\\';./{}|\":<>?abcdefghijklmnopqrstuvwxyzASDFGHJKLPOIUYTREWQZXCVBNM";
for (var i = 0; i < value.length; i++) {
    if (iChars.indexOf(value.charAt(i)) != -1) {
		count++;
		str=document.getElementById("exp_sec").value;
		//alert(str);
		document.getElementById("exp_sec").value=str.replace(value.charAt(i),"");
		if(str == "")
		{
			document.getElementById("exp_sec").value=0;
		}
        }
    }
}

</script>
<script type="text/javascript">
	function verify_date(){
		var val1 = $('#sdat').val();
		var val2 = $('#edat').val();
		var val3 = $('#exp_sec').val();

		// d1 = new Date(val1);
		// d2 = new Date(val2);
		if(val1 > val2){
			sweetAlert('Start Date Should  be less than End Date','','warning');
			return false;
		}
		else if(val3=='')
		{
			sweetAlert('Please Enter Excepted Sections','','warning');
			return false;				
		}
		else
		{
			return true;
		}
	}
</script>
<style>

</style>
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
	white-space:nowrap;
	border:0;}
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
	white-space:nowrap;
	border:0;}
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
	white-space:nowrap;
	border:0;}
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
	white-space:nowrap;
	border:0;}
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
	white-space:nowrap;
	border:0}
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
	white-space:nowrap;border:0;}
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
	white-space:nowrap;
	border:0;}
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
	white-space:nowrap;
	border:0;}
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
	white-space:nowrap;
	border:0;}
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
	white-space:nowrap;
	border:0;}
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
	border-right:1.0pt;
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
	border-right:1.0pt;
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

<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>
<div class="panel panel-primary">
<div class="panel-heading">Daily SAH Report</div>
<div class="panel-body">
<form action="<?= getFullURL($_GET['r'],'daily_sah_report_V5.php','N'); ?>" method="post">
<div class="row">
    <div class="col-md-2">
        <label>Start Date</label>
        <input type="text" name="sdat"  id="sdat"  class="form-control" data-toggle="datepicker" size=8 value="<?php  if(isset($_POST['sdat'])) { echo $_POST['sdat']; } else { echo date("Y-m-d"); } ?>"/>
    </div>
    <div class="col-md-2">	 
        <label>End Date</label>
        <input type="text" name="edat" id="edat" class="form-control" data-toggle="datepicker" size=8 onchange="return verify_date();" value="<?php  if(isset($_POST['edat'])) { echo $_POST['edat']; } else { echo date("Y-m-d"); } ?>"/>
    </div>
    <div class="col-md-2">
        <label>Excepted Sections</label>
        <input type="text" name="exp_sec" id="exp_sec"  class="form-control" value="<?php  if(isset($_POST['exp_sec'])) { echo $_POST['exp_sec']; } else { echo '0'; } ?>" size="6"  onblur="abc(this.value)" />
    </div>
    <input type="submit" value="Show" name="submit" id="submit" onclick="return verify_date();"  class="btn btn-info" style="margin-top:22px;">
    <a href="<?= getFullURL($_GET['r'],'daily_sah_report_v6.php','N'); ?>" class="btn btn-warning" style="margin-top:22px;">Buyer Wise SAH Report</a>
    
	           
						<input type="button" class="btn btn-success" id='excel1' value="Export to Excel" style="margin-top:22px;">
		
</div>
<!--<th style='background-color:#EEEEEE;'>Select Factory</th><td style='background-color:#EEEEEE;'><select name="fac">
	<option>Select</option>
	<option>BAI-1</option>
	<option>BAI-2</option>
</select></td>-->



</form>

<!-- <span id="msg" style="display:none;"><h4>Please Wait.. While Processing The Data..<h4></span> -->


<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Excel's Publish as Web
Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->

<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->


<?php
error_reporting(0);
if(isset($_POST["submit"]))
{
$expsec=$_POST["exp_sec"];
if($expsec!='')
{
//unlink("bar.php");
$c_dat=date('Y-m-01');

$dat=$_POST["sdat"];

$dat1=$_POST["edat"];

$expsec=$_POST["exp_sec"];

$exp_sec=explode(",",$expsec);

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

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'dashboards/controllers/PLD_Dashboard/sah_monthly_status/data.php',2,'R'));
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
$sql71256=mysqli_query($link, "SELECT COUNT(DISTINCT date) as days FROM $bai_pro.grand_rep WHERE (DATE between \"$c_dat\" and \"$dat1\")");
while($rows7123=mysqli_fetch_array($sql71256))
{
	//To calculate completed working shifts and days of a month
	$days=$rows7123["days"];
	//echo "<td rowspan=2 class=xl6527942 width=64 style='width:48pt'>".$rows7["COUNT(DISTINCT DATE)"]."</td>";
}

$sql7=mysqli_query($link, "SELECT SUM(act_sth) as sah,sum(plan_sth) as psah FROM $bai_pro.grand_rep  WHERE section in (1,2,3,4,5,6,7) and DATE=\"".$dat1."\"");
while($rows7=mysqli_fetch_array($sql7))
{
	$today_sah=$rows7["sah"];
	$today_plan_sah=$rows7["psah"];
}

$sql_sec="select * from $bai_pro3.sections_db where sec_id > 0 and sec_id not in (".implode(",",$exp_sec).") order by sec_id+0";
//echo $sql_sec."<br>";
$result_sec=mysqli_query($link, $sql_sec) or die("Error=".$sql_sec."-".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row_sec=mysqli_fetch_array($result_sec))
{
	$sec_array[]=$row_sec["sec_id"];
	$sql12="SELECT section_display_name FROM $bai_pro3.sections_master WHERE sec_name=".$row_sec["sec_id"];
	$result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row12=mysqli_fetch_array($result12))
	{
		$section_display_name=$sql_row12["section_display_name"];
	}
	$sec_list[]=$section_display_name;
	$lable[]=$row_sec["sec_head"];
	$pro_res_a[]=$row_sec["pro_res_a"];
	$pro_res_b[]=$row_sec["pro_res_b"];
	$ie_res_a[]=$row_sec["ie_res_a"];
	$ie_res_b[]=$row_sec["ie_res_b"];
}
$sec_list[]="Factory";

$section_list="'".implode("','",$sec_list)."'";

//echo sizeof($date1);	
echo "<hr/><div class='table-responsive' id=\"SAH -JUN_13441\">
<div id='print_content' align=center x:publishsource=\"Excel\" style='max-height: 800px;overflow-y: scroll;'>

<table cellpadding=0 cellspacing=0  style='border-collapse:
 collapse;border-right:1.0pt' max-width='auto'>
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
 mso-width-alt:2340;width:48pt;'>";
 
 //Changed as per the CR Dated: 2013-06-18 04:21 PM - Kirang
/* echo "<tr height=21 style='height:15.75pt'>  
<td colspan=2 height=21 class=xl10113441 width=147 style='height:15.75pt; width:110pt'>Unit HOD</td>  
  <td colspan=9 class=xl9313441 width=512 style='border-left:none;width:384pt'>Sandeepa</td>
  <td colspan=9 class=xl9313441 width=512 style='border-left:none;width:384pt'>Nihal</td>
  <td colspan=9 class=xl9313441 width=512 style='border-left:none;width:384pt'>Denaka</td>
  <td colspan=9 class=xl9313441 width=512 style='border-left:none;width:384pt'>Denaka</td>
  <td colspan=9 class=xl9313441 width=512 style='border-left:none;width:384pt'>Sandeepa</td>
  <td colspan=9 class=xl9313441 width=512 style='border-left:none;width:384pt'>Nihal</td>
  <td colspan=9 rowspan=4 class=xl9313441 width=520 style='width:390pt'>Factory</td>
 </tr>"; */
 // Section Hod , Section workstudy and Production Executives Names
  echo "<tr height=21  style='height:15.75pt;'>
  <td colspan=2 height=21 class=xl10113441 style='height:15.75pt;background: #1F497D;color:white;border:.5pt solid windowtext'>Section HOD</td>";
  for($i=0;$i<sizeof($sec_array);$i++)
  {
  		echo "<td colspan=9 class=xl9313441 style='border-left:none;background: gray;color:white;text-align: center;border:.5pt solid windowtext;'>".$sec_list[$i]."</td>";
  }
  echo "<td colspan=9 rowspan=3 class=xl9313441 width=520 style='width:390pt;background: gray;color:white;border:.5pt solid windowtext;'>Factory</td>
 </tr>
 
 <tr height=21 style='height:15.75pt'>
  <td colspan=2 height=21 class=xl10113441 style='height:15.75pt;background: #1F497D;color:white;border:.5pt solid windowtext'>Section Work
  Study</td>";
  for($i=0;$i<sizeof($sec_array);$i++)
  {
  		echo "<td colspan=9 class=xl9313441 style='border-left:none;background: gray;color:white;text-align: center;border:.5pt solid windowtext;'>".$ie_res_a[$i]."(Shift - A) / ".$ie_res_b[$i]."(Shift - B)</td>";
  }
  echo "
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td colspan=2 height=21 class=xl10113441 style='height:15.75pt;background: #1F497D;color:white;border:.5pt solid windowtext'>Production
  Executives</td>
  ";
  for($i=0;$i<sizeof($sec_array);$i++)
  {
  		echo "<td colspan=9 class=xl9313441 style='border-left:none;background: gray;color:white;text-align: center;border:.5pt solid windowtext;'>".$pro_res_a[$i]."(Shift - A) / ".$pro_res_b[$i]."(Shift - B)</td>";
  }
  echo "
 </tr>
 <tr height=36 style='mso-height-source:userset;height:27.0pt'>
 <td colspan=2 rowspan=2 height=57 class=xl10213441 style='height:42.75pt;background: #1F497D;color:white;border:.5pt solid windowtext;'>DATE</td>";
  for($h=0;$h<sizeof($sec_array)+1;$h++)
  {
	  echo   "
	  <td rowspan=2 class=xl9913441 style='border-top:none;background: #4F6228;color:white;border:.5pt solid windowtext;'><span
	  style='mso-spacerun:yes'> </span>PLAN SAH</td>
	  <td colspan=3 class=xl9913441 style='border-left:none;background: #4F6228;color:white;border:.5pt solid windowtext;'>ACTUAL SAH</td>
	  <td rowspan=2 class=xl9613441 width=64 style='border-top:none;width:48pt;background: #4F6228;color:white;border:.5pt solid windowtext;'>Actual
	  %</td>
	  <td rowspan=2 class=xl9613441 width=64 style='border-top:none;width:48pt;background: #4F6228;color:white;border:.5pt solid windowtext;'>EFF %</td>
	  <td rowspan=2 class=xl9613441 width=64 style='border-top:none;width:48pt;background: #4F6228;color:white;border:.5pt solid windowtext;'>External
	  SAH loss</td>
	  <td rowspan=2 class=xl9613441 width=64 style='border-top:none;width:48pt;background: #4F6228;color:white;border:.5pt solid windowtext;'>Internal
	  SAH loss</td>
	  <td rowspan=2 class=xl9613441 width=64 style='border-top:none;width:48pt;background: #4F6228;color:white;border:.5pt solid windowtext;'>Production loss</td>";
  }
  
 echo "</tr>
 <tr class=xl1513441 height=21 style='mso-height-source:userset;height:15.75pt'>";
 	
  for($h=0;$h<sizeof($sec_array)+1;$h++)
  {	
  echo "<td height=21 class=xl9913441 style='height:15.75pt;border-top:none;
  border-left:none;    background: #4F6228;color:white;border:.5pt solid windowtext;'>A</td>
  <td class=xl9913441 style='border-top:none;border-left:none; background: #4F6228;color:white;border:.5pt solid windowtext;'>B</td>
  <td class=xl9913441 style='border-top:none;border-left:none; background: #4F6228;color:white;border:.5pt solid windowtext;'>Total</td>";
  }
 echo "</tr>";

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
  $grandtotal_prod_loss=0;
 $ext_sah_array=array();
 $plan=array();
 $total_prod_loss_array=array();
// $vs_sah_plan=$vs_plan;
 //$ms_sah_plan=$ms_plan;
 

//$sec_array=array("1","2","3","4","5");
//$lable=array("Bhavani","Kapila","Nuwan","Dilan","Factory");
$vs_sah_plan=$vs_plan;

$decimal_factor=2;

$sql_vs="SELECT ROUND(SUM(plan_sth),$decimal_factor) as plan,ROUND(SUM(act_sth),$decimal_factor) as act from $bai_pro.grand_rep where section in (".implode(",",$sec_array).") and date between \"$c_dat\" and \"$dat1\"";
//echo $sql_vs;
$result_vs=mysqli_query($link, $sql_vs) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row_vs=mysqli_fetch_array($result_vs))
{
	$vs_act_sah=$row_vs["act"];
	$vs_plan_sah=$row_vs["plan"];
}

/*$sql_ms="SELECT SUM(plan_sth) as plan,SUM(act_sth) as act from $bai_pro.grand_rep where section in (2,6,8) and date between \"$dat\" and \"$dat1\"";
//echo $sql_ms;
$result_ms=mysql_query($sql_ms,$link) or die("Error = ".mysql_error());
while($row_ms=mysql_fetch_array($result_ms))
{
	$ms_act_sah=$row_ms["act"];
	$ms_plan_sah=$row_ms["plan"];
}*/

$sql_vs_today="SELECT ROUND(SUM(plan_sth),$decimal_factor) as plan,ROUND(SUM(act_sth),$decimal_factor) as act from $bai_pro.grand_rep where section in (".implode(",",$sec_array).") and date=\"$dat1\"";
//echo $sql_vs;
$result_vs_today=mysqli_query($link, $sql_vs_today) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row_vs_today=mysqli_fetch_array($result_vs_today))
{
	$vs_plan_sah_today=$row_vs_today["plan"];
	$vs_act_sah_today=$row_vs_today["act"];
}

/*$sql_ms_today="SELECT SUM(plan_sth) as plan,SUM(act_sth) as act from $bai_pro.grand_rep where section in (2,6,8) and date=\"$dat1\"";
//echo $sql_ms;
$result_ms_today=mysql_query($sql_ms_today,$link) or die("Error = ".mysql_error());
while($row_ms_today=mysql_fetch_array($result_ms_today))
{
	$ms_act_sah_today=$row_ms_today["act"];
	$ms_plan_sah_today=$row_ms_today["plan"];
}*/

 
  
$sql_dat=mysqli_query($link, "select distinct date from $bai_pro.grand_rep where date between \"$dat\" and \"$dat1\" order by date");
while($row=mysqli_fetch_array($sql_dat))
{
$date = $row['date']; 
$weekday = date('l', strtotime($date));
echo "<tr height=21 style='height:15.75pt'>
<td height=21 class=xl10313441 style='height:15.75pt;border-top:none;background: #1F497D;color:white;border:.5pt solid windowtext;'>".$weekday."</td>
<td class=xl10413441 style='border-top:none;border-left:none;background: #1F497D;color:white;border:.5pt solid windowtext;'>".$date."</td>";
	
//echo implode(",",$sec_array);
for($i=0;$i<sizeof($sec_array);$i++)
{
	 $sql=mysqli_query($link, "SELECT ROUND(SUM(plan_sth),$decimal_factor) as plan,ROUND(SUM(act_sth),$decimal_factor) as act,ROUND(SUM(act_clh),$decimal_factor) as clh,shift FROM $bai_pro.grand_rep WHERE DATE=\"".$row["date"]."\" AND section=\"".$sec_array[$i]."\" group by module,shift order by module");	 
      while($rows=mysqli_fetch_array($sql))
	  {
			$plan_sah=$plan_sah+round($rows["plan"],$decimal_factor);
			$act_sah=$act_sah+$rows["act"];
			$plan_clh=$plan_clh+$rows["clh"];
			if($rows["shift"] == "A")
			{
				$act_sah_a=$act_sah_a+$rows["act"];
				$plan_sah_a=$plan_sah_a+round($rows["plan"],$decimal_factor);
			}
			else if($rows["shift"] == "B")
			{
				$act_sah_b=$act_sah_b+$rows["act"];
				$plan_sah_b=$plan_sah_b+round($rows["plan"],$decimal_factor);
			}
			else
			{
				echo "No Shift";
			}
	  }
	  if(!in_array($sec_array[$i],$exp_sec))	  
	  {
		  echo "<td class=xl10513441 style='border-top:none;border-left:none;    background: #EBF1DE;border:.5pt solid windowtext;'>".number_format($plan_sah_a+$plan_sah_b,$decimal_factor)."</td>";
		  echo "<td class=xl10513441 style='border-top:none;border-left:none;    background: #EBF1DE;border:.5pt solid windowtext;'>".number_format($act_sah_a,$decimal_factor)."</td>";
		  echo "<td class=xl10613441 style='border-top:none;border-left:none;background: #EBF1DE;border:.5pt solid windowtext;'>".number_format($act_sah_b,$decimal_factor)."</td>";
		  echo "<td class=xl10613441 style='border-top:none;border-left:none;background: #EBF1DE;border:.5pt solid windowtext;'>".number_format($act_sah_a+$act_sah_b,$decimal_factor)."</td>";
		  echo "<td class=xl10713441 style='border-top:none;border-left:none;background: #EBF1DE;border:.5pt solid windowtext;'>".round((($act_sah_a+$act_sah_b)/div_by_zero($plan_sah,1))*100,1)."%</td>";
		  echo "<td class=xl10713441 style='border-top:none;border-left:none;background: #EBF1DE;border:.5pt solid windowtext;'>".round((($act_sah_a+$act_sah_b)/div_by_zero($plan_clh,1))*100,1)."%</td>";
		  //echo "<td class=xl10713441 style='border-top:none;border-left:none'></td>";
		  //echo "<td class=xl10713441 style='border-top:none;border-left:none'></td>";
		  //echo "<td class=xl10713441 style='border-top:none;border-left:none'></td>";
	  }
	 
	  $sql1="select mod_no,dtime,shift,plan_eff from $bai_pro.down_log where section=\"".$sec_array[$i]."\" and date=\"".$row["date"]."\" and source=1 and remarks!=\"Open capacity\"";
	  $result1=mysqli_query($link, $sql1) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	  while($row1=mysqli_fetch_array($result1))
	  {
	  		 $mod_no=$row1["mod_no"];
			 $dtime=$row1["dtime"]/60;
			 $shift=$row1["shift"];
			 $plan_eff_down=round($row1["plan_eff"],0);
			 if($plan_eff_down > 0)
			 {
			 	$sql2="select plan_eff from $bai_pro.down_log where section=\"".$sec_array[$i]."\" and date=\"".$row["date"]."\" and mod_no=\"".$mod_no."\" and shift=\"".$shift."\" ";
				 $result2=mysqli_query($link, $sql2) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while($row2=mysqli_fetch_array($result2))
				 {
				 	$plan_eff=$row2["plan_eff"];
				 } 
			 }
			 else
			 {
			 	 $sql2="select plan_eff from $bai_pro.pro_plan where sec_no=\"".$sec_array[$i]."\" and date=\"".$row["date"]."\" and mod_no=\"".$mod_no."\" and shift=\"".$shift."\" ";
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
	  if(!in_array($sec_array[$i],$exp_sec))	
	  {
	  echo "<td class=xl10813441 style='border-top:none;border-left:none;background: #EBF1DE;border:.5pt solid windowtext;'>".round($ext_sah_loss_total,2)."</td>";
	  }
	  $total_ext_sah=$total_ext_sah+round($ext_sah_loss_total,2);	 
	  
	  $sql1x="select mod_no,dtime,shift,plan_eff from $bai_pro.down_log where section=\"".$sec_array[$i]."\" and date=\"".$row["date"]."\" and source=1 and remarks=\"Open capacity\"";
	  //echo $sql1x."<br>";
	  $result1x=mysqli_query($link, $sql1x) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	  while($row1x=mysqli_fetch_array($result1x))
	  {
	  		 $mod_nox=$row1x["mod_no"];
			 $dtimex=$row1x["dtime"]/60;
			 $shiftx=$row1x["shift"];
			 $plan_eff_downx=round($row1x["plan_eff"],0);
			 if($plan_eff_downx > 0)
			 {
			 	$sql2x="select plan_eff from $bai_pro.down_log where section=\"".$sec_array[$i]."\" and date=\"".$row["date"]."\" and mod_no=\"".$mod_nox."\" and shift=\"".$shiftx."\" and remarks=\"Open capacity\"";
				 //echo $sql2x."<br>";
				 $result2x=mysqli_query($link, $sql2x) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while($row2x=mysqli_fetch_array($result2x))
				 {
				 	$plan_effx=$row2x["plan_eff"];
				 } 
			 }
			 else
			 {
			 	 $sql2x="select plan_eff from $bai_pro.pro_plan where sec_no=\"".$sec_array[$i]."\" and date=\"".$row["date"]."\" and mod_no=\"".$mod_nox."\" and shift=\"".$shiftx."\" ";
				 //echo $sql2x."<br>";
				 $result2x=mysqli_query($link, $sql2x) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while($row2x=mysqli_fetch_array($result2x))
				 {
				 	$plan_effx=$row2x["plan_eff"];
				 } 
				 if($plan_effx ==0)
				 {
				 	$sql2x="SELECT MAX(DATE) as max_date FROM $bai_pro.pro_plan WHERE plan_eff > 0 AND DATE <= \"".$row["date"]."\"  and mod_no=\"$mod_nox\" and shift=\"$shiftx\"";
					//echo $sql2."<br>";
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
			 //echo $ext_sah_loss_totalx."<br>";
	  }
	  
	  //echo "<td class=xl10813441 style='border-top:none;border-left:none'>".round($ext_sah_loss_total,2)."</td>";
	  $total_ext_sahx=$total_ext_sahx+round($ext_sah_loss_totalx,2);	  
	  
	  $sql11="select mod_no,dtime,shift,plan_eff from $bai_pro.down_log where section=\"".$sec_array[$i]."\" and date=\"".$row["date"]."\" and source=0 order by mod_no,shift";
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
			$sql21="select plan_eff from $bai_pro.pro_plan where sec_no=\"".$sec_array[$i]."\" and date=\"".$row["date"]."\" and mod_no=\"".$mod_no1."\" and shift=\"".$shift1."\" ";
			//echo $sql21."<br>";
			$result21=mysqli_query($link, $sql21) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row21=mysqli_fetch_array($result21))
			{
				$plan_eff1=$row21["plan_eff"];//echo "Mod =".$mod_no1."-".$plan_eff1;
			} 
		}
		
	    $int_sah_loss_total=$int_sah_loss_total+($dtime1*$plan_eff1/100);
	  }
	  if(!in_array($sec_array[$i],$exp_sec))	
	  {
	  echo "<td class=xl10813441 style='border-top:none;border-left:none;background: #EBF1DE;border:.5pt solid windowtext;'>".round($int_sah_loss_total,2)."</td>";
	  echo "<td class=xl10813441 style='border-top:none;border-left:none;background: #EBF1DE;border:.5pt solid windowtext;'>".number_format($plan_sah_a+$plan_sah_b-($act_sah_a+$act_sah_b)-$ext_sah_loss_total-$int_sah_loss_total,2)."</td>";
	  }
	  $total_int_sah=$total_int_sah+round($int_sah_loss_total,2);	  
	  
	  $plan_sah=0; $act_sah=0; $plan_clh=0; $act_sah_a=0; $act_sah_b=0; $int_sah_loss_total=0; $ext_sah_loss_total=0; $ext_sah_loss_totalx=0; $plan_sah_a=0; $plan_sah_b=0;
	  //echo "<td class=xl10713441 style='border-top:none;border-left:none'></td>";
	  //echo "<td class=xl10713441 style='border-top:none;border-left:none'></td>";
}

 $sql=mysqli_query($link, "SELECT ROUND(SUM(plan_sth),$decimal_factor) as plan,ROUND(SUM(act_sth),$decimal_factor) as act,ROUND(SUM(act_clh),$decimal_factor) as clh,shift FROM $bai_pro.grand_rep WHERE section in (".implode(",",$sec_array).") and DATE=\"".$row["date"]."\" group by module,shift order by module");
  while($rows=mysqli_fetch_array($sql))
  {
		$plan_sah_sec=$plan_sah_sec+$rows["plan"];
		$act_sah_sec=$act_sah_sec+$rows["act"];
		$plan_clh_sec=$plan_clh_sec+$rows["clh"];
		if($rows["shift"] == "A")
		{
			$act_sah_sec_a=$act_sah_sec_a+$rows["act"];
			$plan_sah_sec_a=$plan_sah_sec_a+round($rows["plan"],$decimal_factor);
		}
		else if($rows["shift"] == "B")
		{
			$act_sah_sec_b=$act_sah_sec_b+$rows["act"];
			$plan_sah_sec_b=$plan_sah_sec_b+round($rows["plan"],$decimal_factor);
		}
		else
		{
			echo "No Shift";
		}
  }	  
                      
$total_sah_first_tot= $plan_sah_sec_a+$plan_sah_sec_b-$act_sah_sec-($total_ext_sah+$total_ext_sahx)-$total_int_sah+$total_ext_sahx; 
if($total_sah_first_tot>0)
{
	
}
else
{
	$total_sah_first_tot=0;
}

$grandtotal_prod_loss=$grandtotal_prod_loss+$total_sah_first_tot;

//echo "individual sum=".$total_sah_first_tot."<br/>";

  echo "<td class=xl10513441 style='border-top:none;border-left:none;    background: #EBF1DE;border:.5pt solid windowtext;'>".number_format($plan_sah_sec_a+$plan_sah_sec_b,$decimal_factor)."</td>
  <td class=xl10513441 style='border-top:none;border-left:none;    background: #EBF1DE;border:.5pt solid windowtext;'>".number_format($act_sah_sec_a,$decimal_factor)."</td>
  <td class=xl10613441 style='border-top:none;border-left:none;background: #EBF1DE;border:.5pt solid windowtext;'>".number_format($act_sah_sec_b,$decimal_factor)."</td>
  <td class=xl10613441 style='border-top:none;border-left:none;background: #EBF1DE;border:.5pt solid windowtext;'>".number_format($act_sah_sec,$decimal_factor)."</td>
  <td class=xl10713441 style='border-top:none;border-left:none;background: #EBF1DE;border:.5pt solid windowtext;'>".round(($act_sah_sec/div_by_zero($plan_sah_sec,1))*100,1)."%</td>
  <td class=xl10713441 style='border-top:none;border-left:none;background: #EBF1DE;border:.5pt solid windowtext;'>".round(($act_sah_sec/div_by_zero($plan_clh_sec,1))*100,1)."%</td>
  <td class=xl10813441 style='border-top:none;border-left:none;background: #EBF1DE;border:.5pt solid windowtext;'>".round($total_ext_sah+$total_ext_sahx,2)."</td>
  <td class=xl10813441 style='border-top:none;border-left:none;background: #EBF1DE;border:.5pt solid windowtext;'>".round($total_int_sah,2)."</td>
  <td class=xl10813441 style='border-top:none;border-left:none;background: #EBF1DE;border:.5pt solid windowtext;'>".round($total_sah_first_tot,2)."</td>";
$today_plan_sah_x=$plan_sah_sec_a+$plan_sah_sec_b; 
 $plan_sah_sec=0; $act_sah_sec_a=0; $act_sah_sec_b=0;$act_sah_sec=0;$total_ext_sah=0;$total_ext_sahx=0;$total_int_sah=0;$plan_clh_sec=0;$plan_sah_sec_a=0;$plan_sah_sec_b=0;

echo "</tr>";	 
} 

$eff_array=array();

echo "<tr height=27 style='mso-height-source:userset;height:20.25pt'>
<td colspan=2 height=27 class=xl10013441 style='height:20.25pt;background: red;color:white;border:.5pt solid windowtext;'>Total</td>";
for($i2=0;$i2<sizeof($sec_array);$i2++)
{	

  $sql=mysqli_query($link, "SELECT ROUND(SUM(plan_sth),$decimal_factor) as plan,ROUND(SUM(act_sth),$decimal_factor) as act,ROUND(SUM(act_clh),$decimal_factor) as clh,shift FROM $bai_pro.grand_rep WHERE DATE between \"".$dat."\" and \"".$dat1."\" AND section=\"".$sec_array[$i2]."\" group by date,module,shift order by date,module");
  while($rows=mysqli_fetch_array($sql))
  {
		$plan_sah_fac=$plan_sah_fac+round($rows["plan"],$decimal_factor);
		//echo $plan_sah_fac;
		$act_sah_fac=$act_sah_fac+$rows["act"];
		$plan_clh_fac=$plan_clh_fac+$rows["clh"];	
		if($rows["shift"] == "A")
		{
			$act_sah_fac_a=$act_sah_fac_a+$rows["act"];
			$plan_sah_fac_a=$plan_sah_fac_a+round($rows["plan"],$decimal_factor);
		}
		else if($rows["shift"] == "B")
		{
			$act_sah_fac_b=$act_sah_fac_b+$rows["act"];
			$plan_sah_fac_b=$plan_sah_fac_b+round($rows["plan"],$decimal_factor);
		}
		else
		{
			echo "No Shift";
		}
  }
  
  
  if(!in_array($sec_array[$i2],$exp_sec))	
  {
  $plan[]=$plan_sah_fac;  
  $eff_array[]=round(($act_sah_fac/div_by_zero($plan_sah_fac,1))*100,1);
  echo "<td class=xl9713441 style='border-top:none;border-left:none;background: #00B050;border:.5pt solid windowtext;'>".number_format($plan_sah_fac_a+$plan_sah_fac_b,$decimal_factor)."</td>";
  echo "<td class=xl9713441 style='border-top:none;border-left:none;background: #00B050;border:.5pt solid windowtext;'>".number_format($act_sah_fac_a,$decimal_factor)."</td>";
  echo "<td class=xl9713441 style='border-top:none;border-left:none;background: #00B050;border:.5pt solid windowtext;'>".number_format($act_sah_fac_b,$decimal_factor)."</td>";
  echo "<td class=xl9713441 style='border-top:none;border-left:none;background: #00B050;border:.5pt solid windowtext;'>".number_format($act_sah_fac,$decimal_factor)."</td>";
  echo "<td class=xl9813441 style='border-top:none;border-left:none;background: #00B050;border:.5pt solid windowtext;'>".round(($act_sah_fac/div_by_zero($plan_sah_fac,1))*100,1)."%</td>";
  echo "<td class=xl9813441 style='border-top:none;border-left:none;background: #00B050;border:.5pt solid windowtext;'>".round(($act_sah_fac/div_by_zero($plan_clh_fac,1))*100,1)."%</td>";
  }
  $sql13="select mod_no,dtime,shift,date,plan_eff from $bai_pro.down_log where section=\"".$sec_array[$i2]."\" and DATE between \"".$dat."\" and \"".$dat1."\" and source=1 and remarks!=\"Open capacity\"";
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
		 	$sql23="select plan_eff from $bai_pro.down_log where section=\"".$sec_array[$i2]."\" and date=\"".$dates3."\" and mod_no=\"".$mod_no3."\" and shift=\"".$shift3."\" ";
			 $result23=mysqli_query($link, $sql23) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while($row23=mysqli_fetch_array($result23))
			 {
			 	$plan_eff3=$row23["plan_eff"];
			 } 
		 }
		 else
		 {
		 	 $sql23="select plan_eff from $bai_pro.pro_plan where sec_no=\"".$sec_array[$i2]."\" and date=\"".$dates3."\" and mod_no=\"".$mod_no3."\" and shift=\"".$shift3."\" ";	//echo $sql23."<br>";	
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
  if(!in_array($sec_array[$i2],$exp_sec))	  
  {
  echo "<td class=xl9713441 style='border-top:none;border-left:none;    background: #00B050;border:.5pt solid windowtext;'>".round($ext_sah_loss_total1,2)."</td>";
  $ext_sah_array[]=$ext_sah_loss_total1;
  }
  
  $total_ext_sah1=$total_ext_sah1+round($ext_sah_loss_total1,2);
  
  
  
 $sql13s="select mod_no,dtime,shift,date,plan_eff from $bai_pro.down_log where section=\"".$sec_array[$i2]."\" and DATE between \"".$dat."\" and \"".$dat1."\" and source=1 and remarks=\"Open capacity\" order by mod_no,shift";
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
		 	$sql23s="select plan_eff from $bai_pro.down_log where section=\"".$sec_array[$i2]."\" and date=\"".$dates3s."\" and mod_no=\"".$mod_no3s."\" and remarks=\"Open capacity\" and shift=\"".$shift3s."\" ";
			//echo $sql23s."<br>";
			 $result23s=mysqli_query($link, $sql23s) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while($row23s=mysqli_fetch_array($result23s))
			 {
			 	$plan_eff3s=$row23s["plan_eff"];
			 } 
		 }
		 else
		 {
		 	 $sql23s="select plan_eff from $bai_pro.pro_plan where sec_no=\"".$sec_array[$i2]."\" and date=\"".$dates3s."\" and mod_no=\"".$mod_no3s."\" and shift=\"".$shift3s."\" ";	//echo $sql23s."<br>";	
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
  
  
  
  
  $sql113="select mod_no,dtime,shift,date from $bai_pro.down_log where section=\"".$sec_array[$i2]."\" and DATE between \"".$dat."\" and \"".$dat1."\" and source=0 order by date,mod_no,shift";
  $result113=mysqli_query($link, $sql113) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
  $plan_eff13=0;
  while($row113=mysqli_fetch_array($result113))
  {
  		 $mod_no13=$row113["mod_no"];
		 $dtime13=$row113["dtime"]/60;
		 $shift13=$row113["shift"];
		 $dates13=$row113["date"];
		 $sql213="select plan_eff from $bai_pro.pro_plan where sec_no=\"".$sec_array[$i2]."\" and date=\"".$dates13."\" and mod_no=\"".$mod_no13."\" and shift=\"".$shift13."\" ";
		 //echo $sql213."-".$dtime13."<br>";
		 $result213=mysqli_query($link, $sql213) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		 while($row213=mysqli_fetch_array($result213))
		 {
		 	$plan_eff13=$row213["plan_eff"];
		 } 
		 
		 $int_sah_loss_total1=$int_sah_loss_total1+($dtime13*$plan_eff13/100);
//		 $int_sah_array[]=$int_sah_loss_total1;
  }
  if(!in_array($sec_array[$i2],$exp_sec))		  
  {
 
  if(($plan_sah_fac_a+$plan_sah_fac_b-$act_sah_fac-$ext_sah_loss_total1-$int_sah_loss_total1)<0)
  {
  	$total_prod_loss_array[]=0;
  }
  else{
  	$total_prod_loss_array[]=$plan_sah_fac_a+$plan_sah_fac_b-$act_sah_fac-$ext_sah_loss_total1-$int_sah_loss_total1;
    }
  
	
  $int_sah_array[]=$int_sah_loss_total1;
  echo "<td class=xl9713441 style='border-top:none;border-left:none;    background: #00B050;border:.5pt solid windowtext;'>".round($int_sah_loss_total1,2)."</td>";
  echo "<td class=xl9713441 style='border-top:none;border-left:none;    background: #00B050;border:.5pt solid windowtext;'>".round($plan_sah_fac_a+$plan_sah_fac_b-$act_sah_fac-$ext_sah_loss_total1-$int_sah_loss_total1,2)."</td>";
  }
  
  $total_int_sah1=$total_int_sah1+round($int_sah_loss_total1,2);
  $int_sah_loss_total1=0;
  $ext_sah_loss_total1=0;
  $ext_sah_loss_total1s=0;
  $plan_sah_fac=0; $act_sah_fac=0; $plan_clh_fac=0; $act_sah_fac_a=0; $act_sah_fac_b=0; $plan_sah_fac_a=0; $plan_sah_fac_b=0;
  
}
$sql=mysqli_query($link, "SELECT ROUND(SUM(plan_sth),$decimal_factor) as plan,ROUND(SUM(act_sth),$decimal_factor) as act,SUM(act_clh) as clh,shift FROM $bai_pro.grand_rep WHERE section in (".implode(",",$sec_array).") and DATE between \"".$dat."\" and \"".$dat1."\" group by date,module,shift order by date,module ");
while($rows=mysqli_fetch_array($sql))
{
	$total_plan_sah_fac=$total_plan_sah_fac+round($rows["plan"],$decimal_factor);
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
$eff_array[]=round(($total_act_sah_fac/div_by_zero($total_plan_sah_fac,1))*100,1);


$total_prod_loss=0;
//$total_prod_loss=$total_plan_sah_fac-$total_act_sah_fac-($total_ext_sah1+$total_ext_sah1s)-$total_int_sah1+$total_ext_sah1s;
//echo "new total grand sum=".$grandtotal_prod_loss."<br/>";
$total_prod_loss=$grandtotal_prod_loss;

  echo "<td class=xl9713441 style='border-top:none;border-left:none;background: #00B050;border:.5pt solid windowtext;'>".number_format($total_plan_sah_fac,$decimal_factor)."</td>
  <td class=xl9713441 style='border-top:none;border-left:none;background: #00B050;border:.5pt solid windowtext;'>".number_format($total_act_sah_fac_a,$decimal_factor)."</td>
  <td class=xl9713441 style='border-top:none;border-left:none;background: #00B050;border:.5pt solid windowtext;'>".number_format($total_act_sah_fac_b,$decimal_factor)."</td>
  <td class=xl9713441 style='border-top:none;border-left:none;background: #00B050;border:.5pt solid windowtext;'>".number_format($total_act_sah_fac,$decimal_factor)."</td>
  <td class=xl9813441 style='border-top:none;border-left:none;background: #00B050;border:.5pt solid windowtext;'>".round(($total_act_sah_fac/div_by_zero($total_plan_sah_fac,1))*100,1)."%</td>
  <td class=xl9813441 style='border-top:none;border-left:none;background: #00B050;border:.5pt solid windowtext;'>".round(($total_act_sah_fac/div_by_zero($total_plan_clh_fac,1))*100,1)."%</td>
  <td class=xl9713441 style='border-top:none;border-left:none;    background: #00B050;border:.5pt solid windowtext;'>".round($total_ext_sah1+$total_ext_sah1s,2)."</td>
  <td class=xl9713441 style='border-top:none;border-left:none;    background: #00B050;border:.5pt solid windowtext;'>".round($total_int_sah1,2)."</td>
  <td class=xl9713441 style='border-top:none;border-left:none;    background: #00B050;border:.5pt solid windowtext;'>".round($total_prod_loss,2)."</td>";
  echo "</tr>";


echo "<tr height=25 style='height:18.75pt'>
  <td colspan=2 height=25 class=xl9513441 style='height:18.75pt;background: black;color:red;border:.5pt solid windowtext;'>External SAH
  loss</td>";
 for($i3=0;$i3<sizeof($ext_sah_array);$i3++)
  {
  	  echo "<td class=xl1513441></td>
	  <td class=xl1513441></td>
	  <td class=xl1513441></td>
	  <td class=xl1513441></td>
	  <td class=xl1513441></td>
	  <td class=xl1513441></td>
	  <td class=xl8913441 style='background: black;color:red;border:.5pt solid windowtext;'>".round($ext_sah_array[$i3]*100/div_by_zero($plan[$i3],1),1)."%</td>
	  <td class=xl8913441 style='background: black;color:red;border:.5pt solid windowtext;'>".round($int_sah_array[$i3]*100/div_by_zero($plan[$i3],1),1)."%</td>
	  <td class=xl8913441 style='background: black;color:red;border:.5pt solid windowtext;'>".round($total_prod_loss_array[$i3]*100/div_by_zero($plan[$i3],1),1)."%</td>";
  } 
  
  echo "<td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl1513441></td>
  <td class=xl8913441 style='background: black;color:red;border:.5pt solid windowtext;'>".round((($total_ext_sah1+$total_ext_sah1s)/div_by_zero($total_plan_sah_fac,1))*100,1)."%</td>
  <td class=xl8913441 style='background: black;color:red;border:.5pt solid windowtext;'>".round(($total_int_sah1/div_by_zero($total_plan_sah_fac,1))*100,1)."%</td>
  <td class=xl8913441 style='background: black;color:red;border:.5pt solid windowtext;'>".round(($total_prod_loss/div_by_zero($total_plan_sah_fac,1))*100,1)."%</td>
 </tr>";
 echo"<div>";
 echo "<tr height=21 style='height:15.75pt;border:none'>
  <td height=21 class=xl8513441 style='height:15.75pt;border:none'></td>
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
 <tr height=21  style='height:15.75pt' class='flowchart'>
  <td height=21 border=0 class=xl85212 rowspan=10 colspan=8 style='height:15.75pt'>";
  
$eff_array_list=implode(",",$eff_array); 

for($f=0;$f<sizeof($sec_array);$f++)
{
	//echo $f."-".$plan[$f]."<br>";
 	$ext_sah_array_no[]=round($ext_sah_array[$f]*100/div_by_zero($plan[$f]),1);
	$int_sah_array_no[]=round($int_sah_array[$f]*100/div_by_zero($plan[$f]),1);
	$prod_loss[]=round($total_prod_loss_array[$f]*100/div_by_zero($plan[$f]),1);
}
 
$ext_sah_array_list=implode(",",$ext_sah_array_no);  
$int_sah_array_list=implode(",",$int_sah_array_no);
$prod_loss_list=implode(",",$prod_loss);  
  
echo "<script type=\"text/javascript\">
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
                categories: [".$section_list."]
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
                data: [".$eff_array_list."]
            },{
				name: 'External SAH Loss',
                data: [".$ext_sah_array_list.",".round(($total_ext_sah1+$total_ext_sah1s)*100/$total_plan_sah_fac,1)."]
			},{
				name: 'Internal SAH Loss',
                data: [".$int_sah_array_list.",".round($total_int_sah1*100/$total_plan_sah_fac,1)."]
			},{
				name: 'Production Loss',
                data: [".$prod_loss_list.",".round($total_prod_loss*100/$total_plan_sah_fac,1)."]
			}]
        });
    });
    
});
		</script>

<script type='text/javascript' src=\"".getFullURLLevel($_GET['r'],'common/js/highcharts.js',3,'R')."\"></script>	
<script type='text/javascript' src=\"".getFullURLLevel($_GET['r'],'common/js/exporting.js',3,'R')."\"></script>	

<div id=\"container\" style=\"width: 900px; height: 400px; margin: 0 auto\"></div>";


  echo "</td><td class=xl86212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>


  
  <td colspan=3 rowspan=2 class=xl95212 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black;  background: #CCC0DA;border:.5pt solid windowtext;'>No of Days</td>
  <td rowspan=2 class=xl101212 style='border-bottom:.5pt solid black;background: #B1A0C7;border:.5pt solid windowtext;'>".$days."</td></tr>";

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
  <td class=xl86212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>

  <td colspan=3 rowspan=2 class=xl93212 style='background: #CCC0DA;border:.5pt solid windowtext;'>Planned SAH / Month</td>
  <td rowspan=2 class=xl94212 style='border-top:none;background: #B1A0C7;border:.5pt solid windowtext;'><span
  style='mso-spacerun:yes'></span>".number_format($vs_sah_plan)." </td>
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
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl87212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  
  <td colspan=3 rowspan=2 class=xl95212 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black; background: #CCC0DA;border:.5pt solid windowtext;'>Today Plan SAH</td>
  <td rowspan=2 class=xl103212 style='border-bottom:.5pt solid black;
  border-top:none;background: #B1A0C7;border:.5pt solid windowtext;'>".number_format($today_plan_sah_x)."</td>
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
  <td class=xl86212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  
  <td colspan=3 rowspan=2 class=xl95212 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black; background: #CCC0DA;border:.5pt solid windowtext;'>Today Actual SAH</td>
  <td rowspan=2 class=xl103212 style='border-bottom:.5pt solid black;
  border-top:none;    background: #B1A0C7;border:.5pt solid windowtext;'>".number_format($vs_act_sah_today)."</td>
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
  <td class=xl88212></td>
  <td class=xl88212></td>
  <td class=xl87212></td>
  <td class=xl86212></td>
  <td class=xl88212></td>
  <td class=xl88212></td>
  
  <td colspan=3 rowspan=2 class=xl93212 style='background: #CCC0DA;border:.5pt solid windowtext;'>MTD Plan SAH<span
  style='mso-spacerun:yes;'></span></td>
  <td rowspan=2 class=xl94212 style='border-top:none;background: #B1A0C7;border:.5pt solid windowtext;'><span
  style='mso-spacerun:yes;background: #B1A0C7;'></span>".number_format($vs_plan_sah)."</td>
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
  <td class=xl88212></td>

  
  <td colspan=3 rowspan=2 class=xl93212 style='background: #CCC0DA;border:.5pt solid windowtext;'>MTD Actual SAH<span
  style='mso-spacerun:yes;'></span></td>
  <td rowspan=2 class=xl94212 style='border-top:none;background: #B1A0C7;border:.5pt solid windowtext;'><span
  style='mso-spacerun:yes;'></span>".number_format($vs_act_sah)."</td>
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
  <td class=xl88212></td>
  
  <td colspan=3 rowspan=2 class=xl93212 style='background: #CCC0DA;border:.5pt solid windowtext;'>Avg SAH achieved<span
  style='mso-spacerun:yes'></span></td>
  <td rowspan=2 class=xl94212 style='border-top:none;background: #B1A0C7;border:.5pt solid windowtext;'><span
  style='mso-spacerun:yes;'></span>".number_format(round($vs_act_sah/$days,0))."</td>
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
  <td class=xl88212></td>
  <td colspan=3 rowspan=2 class=xl93212 style='background: #CCC0DA;border:.5pt solid windowtext;'>SAH required</td>
   <td rowspan=2 class=xl94212 style='border-top:none;background: #B1A0C7;border:.5pt solid windowtext;'><span
  style='mso-spacerun:yes'></span>";
  /*if(($actual_working_days-$days) > 0)
  {
  	echo number_format(($vs_sah_plan-$vs_act_sah)/($actual_working_days-$days));
  } 
  else
  {*/ 
  	echo number_format(($vs_sah_plan-$vs_act_sah));
  //}
  echo "</td>
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
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
  <td class=xl15212></td>
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
//include("daily_sah_report_V5_Excel.php");
}
else
{
echo "<script>sweetAlert('Please enter sections','','warning')</script>";	
}
}

?>
</div>
</div>
</div>

<script>
	$('#excel1').click(function(){
		var graph = document.getElementById('container').innerHTML;
		$('#container').html('');
		var html = document.getElementById('print_content').innerHTML;
		html.replace('<div');
        var blob = new Blob([html], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
		});
		saveAs(blob,"daily_sah_report_v5.xls");
		$('#container').html(graph);
		//$('table').attr('border', '0');
		//document.getElementById('container').innerHTML = graph;
		return;
    })
</script>
