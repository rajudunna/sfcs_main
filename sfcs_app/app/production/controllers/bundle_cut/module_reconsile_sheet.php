<?php
include("dbconf.php");
//$style=$_POST['style'];
$mini_order_ref=$_GET['mini_order_ref'];
$mini_order_num=$_GET['mini_order_num'];
//$mini_order_ref=285;
//$color=$_POST['color'];
$color=$_GET['color'];
$date=date('Y-m-d');
$sizes=array();
$size_code=array();
$ratio=array();
$bundle_num=array();
$size=array();
$quantity=array();
$sql="select * from brandix_bts.tbl_min_ord_ref where id=$mini_order_ref";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$style_id=$sql_row['ref_product_style'];
	$sch_id=$sql_row['ref_crt_schedule'];
}
$doc_no = echo_title("brandix_bts.tbl_miniorder_data","docket_number","mini_order_num=".$mini_order_num." and mini_order_ref",$mini_order_ref,$link);
$c_id = echo_title("brandix_bts.tbl_carton_ref","id","ref_order_num",$sch_id,$link);
$location = echo_title("bai_pro3.act_cut_status","bundle_loc","doc_no",$doc_no,$link);
$sql11="SELECT * from tbl_orders_sizes_master where parent_id='".$sch_id."' and order_col_des='".$color."' order by ref_size_name";
//echo $sql1."<br>";
$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row11=mysqli_fetch_array($sql_result11))
{
	$sizes[$sql_row11['ref_size_name']]=$sql_row11['size_title'];
}

$sql1="SELECT * from tbl_carton_size_ref where parent_id='".$c_id."' and color='".$color."' order by ref_size_name";
//echo $sql1."<br>";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$size_val=$sql_row1['ref_size_name'];
	$size_code[]=$sizes[$size_val];
	$ratio[]=$sql_row1['quantity'];
}
//echo sizeof($size_code)."<br>";
$style = echo_title("brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link);
$schedule = echo_title("brandix_bts.tbl_orders_master","product_schedule","id",$sch_id,$link);
$c_block = echo_title("bai_pro3.bai_orders_db_confirm","zfeature","order_del_no",$schedule,$link);

$sql2="SELECT * from tbl_miniorder_data where mini_order_ref='".$mini_order_ref."' and mini_order_num=".$mini_order_num." and color='".$color."' order by bundle_number,size";
//echo $sql2."<br>";
$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row2=mysqli_fetch_array($sql_result2))
{
	$size_val2=$sql_row2['size'];
	$cut_num[]=echo_title("brandix_bts.tbl_cut_master","cut_num","doc_num",$sql_row2['docket_number'],$link);
	$bundle_num[]=$sql_row2['bundle_number'];
	$size[]=$sizes[$size_val2];
	$quantity[]=$sql_row2['quantity'];
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
  <td class=xl6632733></td>
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
  <td class=xl7232733 width=102 style='width:77pt'>Location:</td>
  <td class=xl7332733 width=166 style='width:125pt'><?php echo $location;?></td>
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
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'></td>
  <td class=xl6932733 width=88 style='border-top:none;width:66pt'>Printed Date</td>
  <td class=xl6932733 width=87 style='border-top:none;border-left:none;
  width:65pt'><?php echo $date;?></td>
  <td rowspan=2 class=xl7732733 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'>Line no</td>
  <td rowspan=2 class=xl7732733 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'></td>
  <td class=xl6932733 width=88 style='border-top:none;width:66pt'>MiniOrder no</td>
  <td class=xl7032733 width=87 style='border-top:none;border-left:none;
  width:65pt'><?php echo $mini_order_num; ?></td>
  <td class=xl1532733></td>
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
  <td class=xl7132733 width=37 style='border-left:none;width:28pt'>Line No.</td>
  <td class=xl6932733 width=66 style='border-left:none;width:50pt'>Date</td>
  <td class=xl6932733 width=99 style='border-left:none;width:74pt'>Rec. Sign</td>
  <td class=xl6932733 width=93 style='border-left:none;width:70pt'>PTS Sign.</td>
  <td class=xl6932733 width=58 style='border-left:none;width:44pt'>Out Qty</td>
  <td class=xl6932733 width=59 style='border-left:none;width:44pt'>Variance</td>
  <td class=xl6932733 width=57 style='border-left:none;width:43pt'>Reject</td>
  <td class=xl6932733 width=57 style='border-left:none;width:43pt'>Sample</td>
  <td class=xl6932733 width=102 style='border-left:none;width:77pt'>Packing
  Rec.</td>
  <td class=xl6932733 width=166 style='border-left:none;width:125pt'>Remarks</td>
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
  width:65pt'><?php echo $cut_num[$i]."-".$bundle_num[$i];?></td>
  <td class=xl7132733 width=64 style='border-top:none;border-left:none;
  width:48pt'><?php echo $size[$i];?></td>
  <td class=xl7132733 width=64 style='border-top:none;border-left:none;
  width:48pt'><?php echo $quantity[$i];?></td>
  <td class=xl6932733 width=37 style='border-top:none;border-left:none;
  width:28pt'>&nbsp;</td>
  <td class=xl6932733 width=66 style='border-top:none;border-left:none;
  width:50pt'>&nbsp;</td>
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
  <td class=xl6932733 width=102 style='border-top:none;border-left:none;
  width:77pt'>&nbsp;</td>
  <td class=xl6932733 width=166 style='border-top:none;border-left:none;
  width:125pt'>&nbsp;</td>
  <td class=xl6632733 width=40 style='width:30pt'></td>
 </tr>
  <?php
	$total+= $quantity[$i];
	}
  
  ?>
 <tr height=30 style='mso-height-source:userset;height:22.5pt'>
  <td height=30 class=xl6632733 width=35 style='height:22.5pt;width:26pt'></td>
  <td class=xl7132733 colspan=3 width=88 style='border-top:none;width:66pt'>Total</td>
  <td class=xl7132733 width=64 style='border-top:none;border-left:none;
  width:48pt'><?php echo $total;?></td>
  <td class=xl6932733 width=37 style='border-top:none;border-left:none;
  width:28pt'>&nbsp;</td>
  <td class=xl6932733 width=66 style='border-top:none;border-left:none;
  width:50pt'>&nbsp;</td>
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
  <td class=xl6932733 width=102 style='border-top:none;border-left:none;
  width:77pt'>&nbsp;</td>
  <td class=xl6932733 width=166 style='border-top:none;border-left:none;
  width:125pt'>&nbsp;</td>
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
