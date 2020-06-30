<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_dashboard.php');

$color=color_decode($_GET['color']);
$input_job=$_GET['input_job'];

$date=date('Y-m-d');
$acut_no=array();
$bundle_num=array();
$size=array();
$quantity=array();
$status=0;
$sql2="SELECT * from $bai_pro3.packing_summary_input where input_job_no_random='".$input_job."' and order_col_des='".$color."' order by tid,m3_size_code";
$sql_result41=mysqli_query($link, $sql2) or exit("Sql Error31".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row41=mysqli_fetch_array($sql_result41))
{
	if($status==0)
	{
		
		$sql322="select prefix from $brandix_bts.tbl_sewing_job_prefix where id=".$sql_row41['type_of_sewing']."";
		$sql_result12321=mysqli_query($link, $sql322) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row12213=mysqli_fetch_array($sql_result12321))
		{				
			$sewing_job  = $sql_row12213['prefix'].leading_zeros($sql_row41['input_job_no'],3);				
		}
	
		$sql41="select vpo from $bai_pro3.bai_orders_db_confirm where order_del_no='".$sql_row41['order_del_no']."'";
		$sql_result412=mysqli_query($link, $sql41) or exit("Sql Error32".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row413=mysqli_fetch_array($sql_result412))
		{
			$vpo=$sql_row413["vpo"];
		}
		$status=1;
		$c_block=$sql_row41['destination'];
		$style=$sql_row41['order_style_no'];
		$schedule=$sql_row41['order_del_no'];
	}

	$acut_no[$sql_row41['tid']]=$sql_row41['acutno'];
	$bundle_num[]=$sql_row41['tid'];
	$size[$sql_row41['tid']]=$sql_row41['m3_size_code'];
	$quantity[$sql_row41['tid']]=$sql_row41['carton_act_qty'];
	
}

$sql76="SELECT input_module,log_time  FROM $bai_pro3.plan_dashboard_input WHERE  input_job_no_random_ref='$input_job'";
$sql_result76=mysqli_query($link, $sql76) or exit("Sql Error013".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result76)>0)
{
	while($sql_row76=mysqli_fetch_array($sql_result76))
	{
		$input_module=$sql_row76['input_module'];
	}
}
else
{
	$sql76="SELECT input_module,log_time  FROM $bai_pro3.plan_dashboard_input_backup WHERE  input_job_no_random_ref='$input_job'";
	$sql_result76=mysqli_query($link, $sql76) or exit("Sql Error014".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row76=mysqli_fetch_array($sql_result76))
	{
		$input_module=$sql_row76['input_module'];
	}
}

?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 15">
<link rel=File-List href="line_reconsile_files/filelist.xml">
<style id="Book2_32733_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl1532733
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
.xl6332733
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
.xl6432733
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
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6532733
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
.xl6632733
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
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl6732733
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
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6832733
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
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl6932733
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
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7032733
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
	text-align:left;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7132733
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
	white-space:normal;}
.xl7232733
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
	white-space:normal;}
.xl7332733
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
	mso-number-format:"Short Date";
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7432733
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
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7532733
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
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7632733
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
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7732733
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
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7832733
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
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
-->
body{
	zoom:100%;
}

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
@page narrow {size: 9in 11in}
@page rotated {size: landscape}
DIV {page: narrow}
TABLE {page: rotated}
#non-printable { display: none; }
#printable { display: block; }
#logo { display: block; }
body { zoom:100%;}
#ad{ display:none;}
#leftbar{ display:none;}
#CUT_PLAN_NEW_13019{ width:57%; margin-left:20px;}
}
</style>

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
</head>

<body onload="printpr();">
<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Excel's Publish as Web
Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<div id="Book2_32733" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=1172 style='border-collapse:
 collapse;table-layout:fixed;width:881pt'>
 <col width=35 style='mso-width-source:userset;mso-width-alt:1280;width:26pt'>
 <col width=88 style='mso-width-source:userset;mso-width-alt:3218;width:66pt'>
 <col width=87 style='mso-width-source:userset;mso-width-alt:3181;width:65pt'>
 <col width=64 span=2 style='width:48pt'>
 <col width=37 style='mso-width-source:userset;mso-width-alt:1353;width:28pt'>
 <col width=66 style='mso-width-source:userset;mso-width-alt:2413;width:50pt'>
 <col width=99 style='mso-width-source:userset;mso-width-alt:3620;width:74pt'>
 <col width=93 style='mso-width-source:userset;mso-width-alt:3401;width:70pt'>
 <col width=58 style='mso-width-source:userset;mso-width-alt:2121;width:44pt'>
 <col width=59 style='mso-width-source:userset;mso-width-alt:2157;width:44pt'>
 <col width=57 span=2 style='mso-width-source:userset;mso-width-alt:2084;
 width:43pt'>
 <col width=102 style='mso-width-source:userset;mso-width-alt:3730;width:77pt'>
 <col width=166 style='mso-width-source:userset;mso-width-alt:6070;width:125pt'>
 <col width=40 style='mso-width-source:userset;mso-width-alt:1462;width:30pt'>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'><a
  name="RANGE!A1"></a></td>
  <td class=xl6632733 width=88 style='width:66pt'></td>
  <td class=xl6632733 width=87 style='width:65pt'></td>
  <td class=xl6632733 width=64 style='width:48pt'></td>
  <td class=xl6632733 width=64 style='width:48pt'></td>
  <td class=xl6632733 width=37 style='width:28pt'></td>
  <td class=xl6632733 width=66 style='width:50pt'></td>
  <td class=xl6632733 width=99 style='width:74pt'></td>
  <td class=xl6632733 width=93 style='width:70pt'></td>
  <td class=xl6632733 width=58 style='width:44pt'></td>
  <td class=xl6632733 width=59 style='width:44pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl6632733 width=102 style='width:77pt'></td>
  <td class=xl6632733 width=166 style='width:125pt'></td>
  <td class=xl6632733 width=40 style='width:30pt'></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'></td>
  <td colspan=14 class=xl7132733 width=1097 style='width:825pt'>Line
  Reconciliation sheet &amp; Line input sheet</td>
  <td class=xl6632733 width=40 style='width:30pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'></td>
  <td class=xl6632733 width=88 style='width:66pt'></td>
  <td class=xl6632733 width=87 style='width:65pt'></td>
  <td class=xl6632733 width=64 style='width:48pt'></td>
  <td class=xl6632733 width=64 style='width:48pt'></td>
  <td class=xl6632733 width=37 style='width:28pt'></td>
  <td class=xl6632733 width=66 style='width:50pt'></td>
  <td class=xl6632733 width=99 style='width:74pt'></td>
  <td class=xl6632733 width=93 style='width:70pt'></td>
  <td class=xl6632733 width=58 style='width:44pt'></td>
  <td class=xl6632733 width=59 style='width:44pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl7232733 width=102 style='width:77pt'></td>
  <td class=xl1532733></td>
  <td class=xl6632733 width=40 style='width:30pt'></td>
 </tr>
  <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'></td>
  <td class=xl6632733 width=88 style='width:66pt'></td>
  <td class=xl6632733 width=87 style='width:65pt'></td>
  <td class=xl6632733 width=64 style='width:48pt'></td>
  <td class=xl6632733 width=64 style='width:48pt'></td>
  <td class=xl6632733 width=37 style='width:28pt'></td>
  <td class=xl6632733 width=66 style='width:50pt'></td>
  <td class=xl6632733 width=99 style='width:74pt'></td>
  <td class=xl6632733 width=93 style='width:70pt'></td>
  <td class=xl6632733 width=58 style='width:44pt'></td>
  <td class=xl6632733 width=59 style='width:44pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl7232733 width=102 style='width:77pt'>Date:</td>
  <td class=xl7332733 width=166 style='width:125pt'><?php echo $date;?></td>
  <td class=xl6632733 width=40 style='width:30pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'></td>
  <td class=xl6932733 width=88 style='width:66pt'>Style</td>
  <td class=xl7032733 width=87 style='border-left:none;width:65pt'><?php echo $style;?></td>
  <td class=xl6932733 width=64 style='border-left:none;width:48pt'>Schedule</td>
  <td class=xl7032733 width=64 style='border-left:none;width:48pt'><?php echo $schedule;?></td>
  <td class=xl6632733 width=37 style='width:28pt'></td>
  <td class=xl6632733 width=66 style='width:50pt'></td>
  <td class=xl6632733 width=99 style='width:74pt'></td>
  <td class=xl6632733 width=93 style='width:70pt'></td>
  <td class=xl6632733 width=58 style='width:44pt'></td>
  <td class=xl6632733 width=59 style='width:44pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl6632733 width=102 style='width:77pt'></td>
  <td class=xl7232733 width=166 style='width:125pt'></td>
  <td class=xl6632733 width=40 style='width:30pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'></td>
  <td class=xl6932733 width=88 style='border-top:none;width:66pt'>Color</td>
  <td colspan=3 class=xl7432733 width=215 style='border-right:.5pt solid black;
  border-left:none;width:161pt'><?php echo $color;?></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl6532733>VPO</td>
  <td  colspan=4 class=xl6532733><?php echo $vpo;?></td>
 
  <td class=xl1532733></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'></td>
  <td class=xl6932733 width=88 style='border-top:none;width:66pt'>Country code</td>
  <td class=xl6932733 width=87 style='border-top:none;border-left:none;
  width:65pt'><?php echo $c_block;?></td>
  <td rowspan=2 class=xl7732733 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'>Line no</td>
  <td rowspan=2 class=xl7732733 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php echo $input_module; ?></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
 
  
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'></td>
  <td class=xl6932733 width=88 style='border-top:none;width:66pt'>Sewing Job no</td>
  <td class=xl7032733 width=87 style='border-top:none;border-left:none;
  width:65pt'><?php echo $sewing_job; ?></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
   
  
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl6632733 width=37 style='width:28pt'></td>
  <td class=xl6632733 width=66 style='width:50pt'></td>
  <td class=xl6632733 width=99 style='width:74pt'></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl6632733 width=102 style='width:77pt'></td>
  <td class=xl6632733 width=166 style='width:125pt'></td>
  <td class=xl6632733 width=40 style='width:30pt'></td>
 </tr>
  <tr height=40 style='mso-height-source:userset;height:30.0pt'>
  <td height=40 class=xl6632733 width=35 style='height:30.0pt;width:26pt'></td>
  <td class=xl6932733 width=88 style='width:66pt'>S. No.</td>
  <td class=xl6932733 width=87 style='border-left:none;width:65pt'>Bundle #</td>
  <td class=xl6932733 width=64 style='border-left:none;width:48pt'>Size</td>
  <td class=xl6932733 width=64 style='border-left:none;width:48pt'>In Qty</td>
  <td class=xl6932733 colspan=2 width=93 style='border-left:none;width:80pt'>Date</td>
  <td class=xl6932733 width=99 style='border-left:none;width:74pt'>Rec. Sign</td>
   <td class=xl6932733 width=58 style='border-left:none;width:44pt'>Out Qty</td>
  <td class=xl6932733 width=59 style='border-left:none;width:44pt'>Variance</td>
  <td class=xl6932733 width=57 style='border-left:none;width:43pt'>Reject</td>
  <td class=xl6932733 width=57 style='border-left:none;width:43pt'>Sample</td>
  <td class=xl6932733 width=102 style='border-left:none;width:77pt'>Packing
  Rec.</td>
  <td class=xl6932733 colspan=2  width=166 style='border-left:none;width:125pt'>Remarks</td>
  <td class=xl6632733 width=40 style='width:30pt'></td>
 </tr>
  <?php
  $total=0;
  
	for($i=0;$i<sizeof($bundle_num);$i++)
	{
		?>
 <tr height=30 style='mso-height-source:userset;height:22.5pt'>
  <td height=30 class=xl6632733 width=35 style='height:22.5pt;width:26pt'></td>
  <td class=xl7132733 width=88 style='border-top:none;width:66pt'><?php echo ($i+1);?></td>
  <td class=xl7132733 width=87 style='border-top:none;border-left:none;
  width:65pt'><?php echo $acut_no[$bundle_num[$i]]."-".$bundle_num[$i];?></td>
  <td class=xl7132733 width=93 style='border-top:none;border-left:none;
  width:48pt'><?php echo $size[$bundle_num[$i]];?></td>
  <td class=xl7132733 width=64 style='border-top:none;border-left:none;
  width:48pt'><?php echo $quantity[$bundle_num[$i]];?></td>
  <td class=xl6932733 colspan=2 width=37 style='border-top:none;border-left:none;
  width:80pt'>&nbsp;</td>

  <td class=xl6932733 width=99 style='border-top:none;border-left:none;
  width:74pt'>&nbsp;</td>
  
  <td class=xl6932733 width=58 style='border-top:none;border-left:none;
  width:44pt'>&nbsp;</td>
  <td class=xl6932733 width=59 style='border-top:none;border-left:none;
  width:44pt'>&nbsp;</td>
  <td class=xl6932733 width=57 style='border-top:none;border-left:none;
  width:43pt'>&nbsp;</td>
  <td class=xl6932733 width=57 style='border-top:none;border-left:none;
  width:43pt'>&nbsp;</td>
  <td class=xl6932733 width=102 style='border-top:none;border-left:none;
  width:77pt'>&nbsp;</td>
  <td class=xl6932733 colspan=2 width=166 style='border-top:none;border-left:none;
  width:125pt'>&nbsp;</td>
  <td class=xl6632733 width=40 style='width:30pt'></td>
 </tr>
  <?php
	$total+= $quantity[$bundle_num[$i]];
	}
  
  ?>
 <tr height=30 style='mso-height-source:userset;height:22.5pt'>
  <td height=30 class=xl6632733 width=35 style='height:22.5pt;width:26pt'></td>
  <td class=xl7132733 colspan=3 width=88 style='border-top:none;width:66pt'>Total</td>
  <td class=xl7132733 width=64 style='border-top:none;border-left:none;
  width:48pt'><?php echo $total;?></td>
  <td class=xl6932733 colspan=2 width=37 style='border-top:none;border-left:none;
  width:28pt'>&nbsp;</td>
  <td class=xl6932733 width=99 style='border-top:none;border-left:none;
  width:74pt'>&nbsp;</td>
  <td class=xl6932733 width=93 style='border-top:none;border-left:none;
  width:70pt'>&nbsp;</td>
  <td class=xl6932733 width=58 style='border-top:none;border-left:none;
  width:44pt'>&nbsp;</td>
  <td class=xl6932733 width=59 style='border-top:none;border-left:none;
  width:44pt'>&nbsp;</td>
  <td class=xl6932733 width=57 style='border-top:none;border-left:none;
  width:43pt'>&nbsp;</td>
  <td class=xl6932733 width=57 style='border-top:none;border-left:none;
  width:43pt'>&nbsp;</td>
  <td class=xl6932733 colspan=2 width=102 style='border-top:none;border-left:none;
  width:77pt'>&nbsp;</td>
   <td class=xl6632733 width=40 style='width:30pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'></td>
  <td class=xl6632733 width=88 style='width:66pt'></td>
  <td class=xl6632733 width=87 style='width:65pt'></td>
  <td class=xl6632733 width=64 style='width:48pt'></td>
  <td class=xl6632733 width=64 style='width:48pt'></td>
  <td class=xl6632733 width=37 style='width:28pt'></td>
  <td class=xl6632733 width=66 style='width:50pt'></td>
  <td class=xl6632733 width=99 style='width:74pt'></td>
  <td class=xl6632733 width=93 style='width:70pt'></td>
  <td class=xl6632733 width=58 style='width:44pt'></td>
  <td class=xl6632733 width=59 style='width:44pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl6632733 width=102 style='width:77pt'></td>
  <td class=xl6632733 width=166 style='width:125pt'></td>
  <td class=xl6632733 width=40 style='width:30pt'></td>
 </tr>
 <tr class=xl1532733 height=20 style='height:15.0pt'>
  <td height=20 class=xl6732733 style='height:15.0pt'></td>
  <td class=xl6732733 colspan=2>-----------------</td>
  <td class=xl6732733></td>
  <td colspan=3 class=xl6332733>--------------------------</td>
  <td class=xl6732733></td>
  <td colspan=2 class=xl6332733>-------------------</td>
  <td class=xl6732733></td>
  <td colspan=2 class=xl6332733>-------------------</td>
  <td class=xl6732733></td>
  <td class=xl6732733>-----------------</td>
  <td class=xl6732733></td>
 </tr>
 <tr class=xl1532733 height=20 style='height:15.0pt'>
  <td height=20 class=xl6732733 style='height:15.0pt'></td>
  <td class=xl6332733>Recorder</td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td colspan=3 class=xl6332733>Production Co-Ordinator</td>
  <td class=xl1532733></td>
  <td colspan=2 class=xl6332733>Line Leader</td>
  <td class=xl1532733></td>
  <td colspan=2 class=xl6332733>Supervisor</td>
  <td class=xl1532733></td>
  <td class=xl6732733>QC supervisor</td>
  <td class=xl6732733></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'></td>
  <td class=xl6632733 width=88 style='width:66pt'></td>
  <td class=xl6632733 width=87 style='width:65pt'></td>
  <td class=xl6632733 width=64 style='width:48pt'></td>
  <td class=xl6632733 width=64 style='width:48pt'></td>
  <td class=xl6632733 width=37 style='width:28pt'></td>
  <td class=xl6632733 width=66 style='width:50pt'></td>
  <td class=xl6632733 width=99 style='width:74pt'></td>
  <td class=xl6632733 width=93 style='width:70pt'></td>
  <td class=xl6632733 width=58 style='width:44pt'></td>
  <td class=xl6632733 width=59 style='width:44pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl6632733 width=102 style='width:77pt'></td>
  <td class=xl6632733 width=166 style='width:125pt'></td>
  <td class=xl6632733 width=40 style='width:30pt'></td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=35 style='width:26pt'></td>
  <td width=88 style='width:66pt'></td>
  <td width=87 style='width:65pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=37 style='width:28pt'></td>
  <td width=66 style='width:50pt'></td>
  <td width=99 style='width:74pt'></td>
  <td width=93 style='width:70pt'></td>
  <td width=58 style='width:44pt'></td>
  <td width=59 style='width:44pt'></td>
  <td width=57 style='width:43pt'></td>
  <td width=57 style='width:43pt'></td>
  <td width=102 style='width:77pt'></td>
  <td width=166 style='width:125pt'></td>
  <td width=40 style='width:30pt'></td>
 </tr>
 <![endif]>
</table>

</div>


<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
</body>

</html>
