<?php include('../../../common/config/config.php'); 
	include('../../../common/config/functions.php');  
$gate_id=$_GET['pass_id'];
$sql12="select * from $brandix_bts.gatepass_table where id=".$gate_id."";
$sql_result123=mysqli_query($link, $sql12) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));	
while($sql_row12=mysqli_fetch_array($sql_result123))
{
	$date=$sql_row12['date'];
	$user=$sql_row12['username'];
	$vehicle_no=$sql_row12['vehicle_no'];	
	$operation=$sql_row12['operation'];	
}
$sql1122="select operation_name from $brandix_bts.tbl_orders_ops_ref where operation_code=".$operation."";
$sql_result1w23=mysqli_query($link, $sql1122) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));	
while($sql_row1212=mysqli_fetch_array($sql_result1w23))
{
	$ops_name=$sql_row1212['operation_name'];
}
?>


<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 15">
<link rel=File-List href="gate_pass_print_files/filelist.xml">
<style id="Gatepass_new_32160_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl1532160
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
.xl6332160
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6432160
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6532160
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
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6632160
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
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6732160
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6832160
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
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6932160
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
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7032160
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7132160
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
	text-align:general;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7232160
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
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7332160
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
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7432160
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
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7532160
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
	background:#FFE699;
	mso-pattern:black none;
	white-space:nowrap;}
.xl7632160
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
	vertical-align:top;
	background:#9BC2E6;
	mso-pattern:black none;
	white-space:nowrap;}
.xl7732160
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
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7832160
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:underline;
	text-underline-style:single;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7932160
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
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8032160
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
	vertical-align:top;
	background:#FFE699;
	mso-pattern:black none;
	white-space:nowrap;}
.xl8132160
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
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8232160
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
	text-align:left;
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8332160
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
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8432160
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:underline;
	text-underline-style:single;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:right;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
-->
</style>
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

<script src="../../cutting/common/js/jquery-1.3.2.js"></script>
<script src="../../cutting/common/js/jquery-barcode-2.0.1.js"></script>

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

<div id="Gatepass_new_32160" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=722 style='border-collapse:
 collapse;table-layout:fixed;width:541pt'>
 <col width=43 style='mso-width-source:userset;mso-width-alt:1536;width:32pt'>
 <col width=40 style='mso-width-source:userset;mso-width-alt:1422;width:30pt'>
 <col width=64 span=3 style='width:48pt'>
 <col width=76 style='mso-width-source:userset;mso-width-alt:2702;width:57pt'>
 <col width=84 style='mso-width-source:userset;mso-width-alt:2986;width:63pt'>
 <col width=72 span=2 style='mso-width-source:userset;mso-width-alt:2560;
 width:54pt'>
 <col width=58 style='mso-width-source:userset;mso-width-alt:2076;width:44pt'>
 <col width=31 style='mso-width-source:userset;mso-width-alt:1109;width:23pt'>
 <col width=54 style='mso-width-source:userset;mso-width-alt:1905;width:40pt'>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 width=43 style='height:14.4pt;width:32pt'></td>
  <td class=xl1532160 width=40 style='width:30pt'></td>
  <td class=xl1532160 width=64 style='width:48pt'></td>
  <td class=xl1532160 width=64 style='width:48pt'></td>
  <td class=xl1532160 width=64 style='width:48pt'></td>
  <td class=xl1532160 width=76 style='width:57pt'></td>
  <td class=xl1532160 width=84 style='width:63pt'></td>
  <td class=xl1532160 width=72 style='width:54pt'></td>
  <td class=xl1532160 width=72 style='width:54pt'></td>
  <td class=xl1532160 width=58 style='width:44pt'></td>
  <td class=xl1532160 width=31 style='width:23pt'></td>
  <td class=xl1532160 width=54 style='width:40pt'></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6332160>&nbsp;</td>
  <td class=xl6432160>&nbsp;</td>
  <td class=xl6432160>&nbsp;</td>
  <td class=xl6432160>&nbsp;</td>
  <td class=xl6432160>&nbsp;</td>
  <td class=xl6432160>&nbsp;</td>
  <td class=xl6432160>&nbsp;</td>
  <td class=xl6432160>&nbsp;</td>
  <td class=xl6432160>&nbsp;</td>
  <td class=xl6532160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='mso-height-source:userset;height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl7132160>&nbsp;</td>
  <td colspan=6 rowspan=2 class=xl8232160><?php echo $plant_head;?></td>
  <td class=xl7232160></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='mso-height-source:userset;height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl7132160>&nbsp;</td>
  <td class=xl7232160></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=22 style='mso-height-source:userset;height:16.2pt'>
  <td height=22 class=xl1532160 style='height:16.2pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td colspan=3 class=xl8332160><?php echo '<div id="bcTarget1" style="width:auto;"></div><script>$("#bcTarget1").barcode("'.$gate_id.'", "code39",{barWidth:2,barHeight:30,moduleSize:5,fontSize:5});</script>'; ?></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160>Gate Pass:</td>
  <td colspan=2 class=xl7932160><?php echo leading_zeros($gate_id,10);?></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td colspan=3 class=xl7732160><?php echo $plant_address; ?></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160>Operation:</td>
  <td colspan=2 class=xl7932160><?php echo $ops_name;?></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td colspan=3 class=xl7732160><?php echo $plant_location;?></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160>Date:</td>
  <td colspan=2 class=xl7932160><?php echo $date;?></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td colspan=3 class=xl7732160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160>Time:</td>
  <td colspan=2 class=xl7932160><?php echo date('h:m a');?></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td colspan=3 class=xl7732160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160>Vehicle No:</td>
  <td colspan=2 class=xl7932160><?php echo $vehicle_no;?></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=48 style='mso-height-source:userset;height:36.0pt'>
  <td height=48 class=xl1532160 style='height:36.0pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl7332160>Style</td>
  <td class=xl7332160>Schedule</td>
  <td colspan=2 class=xl8132160>Color</td>
  <td class=xl7332160>Size</td>
  <td class=xl7332160>Qty</td>
  <td class=xl7432160 width=72 style='width:54pt'>Number Of <br>
   Bundles</td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <?php
 $sql="select style,schedule,color,size from $brandix_bts.gatepass_track where gate_id=".$gate_id." group by style,schedule,color,size";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));	
    $sql_num_check=mysqli_num_rows($sql_result);
    while($sql_row=mysqli_fetch_array($sql_result))
    {
		$styles[]=$sql_row['style'];
		$schedule[]=$sql_row['schedule'];
		$color[]=$sql_row['color'];	
		$size[]=$sql_row['size'];	
	}
	$styles=array_values(array_unique($styles));
	$schedule=array_values(array_unique($schedule));
	$color=array_values(array_unique($color));
	$size=array_values(array_unique($size));
	$tot_qty=0;
	$tot_bds=0;
	$sql1="select style,schedule,color,size,sum(bundle_qty) as qty,count(bundle_no) as cnts from $brandix_bts.gatepass_track where gate_id=".$gate_id." group by style,schedule,color,size";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));	
    while($sql_row1=mysqli_fetch_array($sql_result1))
    {
		$quantity[$sql_row1['schedule']][$sql_row1['color']][$sql_row1['size']]=$sql_row1['qty'];
		$bundles[$sql_row1['schedule']][$sql_row1['color']][$sql_row1['size']]=$sql_row1['cnts'];
		$tot_qty=$tot_qty+$sql_row1['qty'];
		$tot_bds=$tot_bds+$sql_row1['cnts'];
	}
	$sql12="select schedule,color,sum(bundle_qty) as qty,count(bundle_no) as cnts from $brandix_bts.gatepass_track where gate_id=".$gate_id." group by schedule,color";
	$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));	
    while($sql_row12=mysqli_fetch_array($sql_result12))
    {
		$quantity_val[$sql_row12['schedule']][$sql_row12['color']]=$sql_row12['qty'];
		$bundles_val[$sql_row12['schedule']][$sql_row12['color']]=$sql_row12['cnts'];
	}
	// var_dump($styles)."<br>";
	// var_dump($color)."<br>";
	// var_dump($size)."<br>";
 ?> 
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td colspan=5 class=xl8032160>Grand Total</td>
  <td class=xl7532160 align=right><?php echo $tot_qty;?></td>
  <td class=xl7532160 align=right><?php echo $tot_bds;?></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <?php	
 for($i=0;$i<sizeof($styles);$i++)
 {
	for($ii=0;$ii<sizeof($schedule);$ii++)
	{
		for($iii=0;$iii<sizeof($color);$iii++)
		{
			if($bundles_val[$schedule[$ii]][$color[$iii]]<>'')
			{
				echo "<tr height=19 style='height:14.4pt'>
				<td height=19 class=xl1532160 style='height:14.4pt'></td>
				<td class=xl6632160>&nbsp;</td>
				<td class=xl7632160>".$styles[$i]."</td>
				<td class=xl7632160>".$schedule[$ii]."</td>
				<td colspan=2 class=xl7632160>".$color[$iii]."</td>
				<td class=xl7632160>&nbsp;</td>
				<td class=xl7632160>".$quantity_val[$schedule[$ii]][$color[$iii]]."</td>
				<td class=xl7632160>".$bundles_val[$schedule[$ii]][$color[$iii]]."</td>
				<td class=xl1532160></td>
				<td class=xl6732160>&nbsp;</td>
				<td class=xl1532160></td>
				</tr>";
			}
			for($iiii=0;$iiii<sizeof($size);$iiii++)
			{
				if($bundles[$schedule[$ii]][$color[$iii]][$size[$iiii]]<>'')
				{				
					echo "<tr height=19 style='height:14.4pt'>
					<td height=19 class=xl1532160 style='height:14.4pt'></td>
					<td class=xl6632160>&nbsp;</td>
					<td class=xl7732160>".$styles[$i]."</td>
					<td class=xl7732160>".$schedule[$ii]."</td>
					<td colspan=2 class=xl7732160>".$color[$iii]."</td>
					<td class=xl7732160>".$size[$iiii]."</td>
					<td class=xl7732160>".$quantity[$schedule[$ii]][$color[$iii]][$size[$iiii]]."</td>
					<td class=xl7732160>".$bundles[$schedule[$ii]][$color[$iii]][$size[$iiii]]."</td>
					<td class=xl1532160></td>
					<td class=xl6732160>&nbsp;</td>
					<td class=xl1532160></td>
					</tr>";
				}
			}
		}
	}
 }
 ?>

 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td colspan=4 class=xl8432160>Received the goods in good condition</td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td colspan=4 class=xl7732160>Gate Pass Generated User: ......................</td>
  <td class=xl1532160>Name -</td>
  <td colspan=3 class=xl7832160>___________________________</td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td colspan=2 class=xl7932160><?php echo $user;?></td>
  <td class=xl1532160>Designation -</td>
  <td colspan=3 class=xl7832160>___________________________</td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160>ID -</td>
  <td colspan=3 class=xl7832160>___________________________</td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td colspan=3 class=xl7932160>__________________________</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td colspan=3 class=xl7932160>___________________________</td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td colspan=3 class=xl7932160>Authorized Signature</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td colspan=3 class=xl7932160>Signature of Receiver</td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6632160>&nbsp;</td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl6732160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl6832160>&nbsp;</td>
  <td class=xl6932160>&nbsp;</td>
  <td class=xl6932160>&nbsp;</td>
  <td class=xl6932160>&nbsp;</td>
  <td class=xl6932160>&nbsp;</td>
  <td class=xl6932160>&nbsp;</td>
  <td class=xl6932160>&nbsp;</td>
  <td class=xl6932160>&nbsp;</td>
  <td class=xl6932160>&nbsp;</td>
  <td class=xl7032160>&nbsp;</td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1532160 style='height:14.4pt'></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
  <td class=xl1532160></td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=43 style='width:32pt'></td>
  <td width=40 style='width:30pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=76 style='width:57pt'></td>
  <td width=84 style='width:63pt'></td>
  <td width=72 style='width:54pt'></td>
  <td width=72 style='width:54pt'></td>
  <td width=58 style='width:44pt'></td>
  <td width=31 style='width:23pt'></td>
  <td width=54 style='width:40pt'></td>
 </tr>
 <![endif]>
</table>

</div>


<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
</body>

</html>
