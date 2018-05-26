<?php
//as per fresh desk id 5102 we have remove the duplicated assigned variable// bhargav
include("dbconf.php");
//$doc_no='103';
$doc_no=$_GET['doc_no']; 
//echo implode(",",$doc_id);
$table="bai_pro3.plandoc_stat_log";
//$docket=echo_title("tbl_miniorder_data","docket_number","bundle_number",$barcode,$link);

$sql="select * from $table where org_doc_no='".$doc_no."'";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row1=mysqli_fetch_array($sql_result))
{
	$doc_id[]=$row1['doc_no'];
}
//echo sizeof($doc_id)."<br>";	
//$doc_id=array(103,112,125,117);
	
$style_id=echo_title("tbl_cut_master","style_id","doc_num",$doc_no,$link);
$style=echo_title("tbl_orders_style_ref","product_style","id",$style_id,$link);
$mini_order_num=echo_title("tbl_miniorder_data","mini_order_num","docket_number in (".implode(",",$doc_id).") and 1",1,$link);
$cut_code1=echo_title("tbl_cut_master","col_code","doc_num",$doc_no,$link);	
$cut_num1=echo_title("tbl_cut_master","cut_num","doc_num",$doc_no,$link);	
//$cut_code=;
$location = echo_title("bai_pro3.act_cut_status","bundle_loc","doc_no",$doc_no,$link);	
$cut_code=chr($cut_code1).leading_zeros($cut_num1,3);
/*
$mini_order_num=$_GET['min_num'];
//$mini_order_ref=843;
//$mini_order_num=15;
$style = $_GET['style'];
$schedule = $_GET['sch'];

$sql="select * from brandix_bts.tbl_min_ord_ref where id='".$mini_order_ref."'";
$sql_result=mysql_query($sql,$link) or exit("Sql Error2".mysql_error());
while($sql_row=mysql_fetch_array($sql_result))
{
	$style_id=$sql_row['ref_product_style'];
	$sch_id=$sql_row['ref_crt_schedule'];
}
*/

//$c_block = echo_title("bai_pro3.bai_orders_db_confirm","zfeature","order_del_no",$schedule,$link);
//$doc_no = echo_title("brandix_bts.tbl_miniorder_data","docket_number","mini_order_num=$mini_order_num and mini_order_ref",$mini_order_ref,$link);
$buyer_div = echo_title("bai_pro3.bai_orders_db_confirm","order_div","order_style_no",$style,$link);
//$quantity = echo_title("brandix_bts.tbl_miniorder_data","sum(quantity)","mini_order_num=".$mini_order_num." and mini_order_ref",$mini_order_ref,$link);

?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 15">
<link rel=File-List href="club_check_list_files/filelist.xml">
<style id="check_list_excel_26558_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.font026558
	{color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;}
.font526558
	{color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:underline;
	text-underline-style:single;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;}
.xl1526558
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
.xl6326558
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
.xl6426558
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
	white-space:nowrap;}
.xl6526558
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
.xl6626558
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6726558
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6826558
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
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6926558
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:20.0pt;
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
.xl7026558
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
.xl7126558
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
.xl7226558
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
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7326558
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
	white-space:nowrap;}
.xl7426558
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
.xl7526558
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
.xl7626558
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7726558
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7826558
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
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
-->
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
</script onload="printpr();">
</head>

<body>
<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Excel's Publish as Web
Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<div id="check_list_excel_26558" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=914 style='border-collapse:
 collapse;table-layout:fixed;width:685pt'>
 <col width=25 style='mso-width-source:userset;mso-width-alt:914;width:19pt'>
 <col width=41 style='mso-width-source:userset;mso-width-alt:1499;width:31pt'>
 <col width=75 style='mso-width-source:userset;mso-width-alt:2742;width:56pt'>
 <col width=64 style='width:48pt'>
 <col width=63 style='mso-width-source:userset;mso-width-alt:2304;width:47pt'>
 <col width=55 style='mso-width-source:userset;mso-width-alt:2011;width:41pt'>
 <col width=61 style='mso-width-source:userset;mso-width-alt:2230;width:46pt'>
 <col width=44 style='mso-width-source:userset;mso-width-alt:1609;width:33pt'>
 <col width=84 style='mso-width-source:userset;mso-width-alt:3072;width:63pt'>
 <col width=64 span=5 style='width:48pt'>
 <col width=55 style='mso-width-source:userset;mso-width-alt:2011;width:41pt'>
 <col width=27 style='mso-width-source:userset;mso-width-alt:987;width:20pt'>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1526558 width=25 style='height:15.0pt;width:19pt'></td>
  <td class=xl1526558 width=41 style='width:31pt'></td>
  <td class=xl1526558 width=75 style='width:56pt'></td>
  <td class=xl1526558 width=64 style='width:48pt'></td>
  <td class=xl1526558 width=63 style='width:47pt'></td>
  <td class=xl1526558 width=55 style='width:41pt'></td>
  <td class=xl1526558 width=61 style='width:46pt'></td>
  <td class=xl1526558 width=44 style='width:33pt'></td>
  <td class=xl1526558 width=84 style='width:63pt'></td>
  <td class=xl1526558 width=64 style='width:48pt'></td>
  <td class=xl1526558 width=64 style='width:48pt'></td>
  <td class=xl1526558 width=64 style='width:48pt'></td>
  <td class=xl1526558 width=64 style='width:48pt'></td>
  <td class=xl1526558 width=64 style='width:48pt'></td>
  <td class=xl1526558 width=55 style='width:41pt'></td>
  <td class=xl1526558 width=27 style='width:20pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1526558 style='height:15.0pt'></td>
  <td colspan=14 rowspan=2 class=xl6926558>Clubbed Schedule Working Document</td>
  <td class=xl1526558></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1526558 style='height:15.0pt'></td>
  <td class=xl1526558></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1526558 style='height:15.0pt'></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl7126558></td>
  <td class=xl7126558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1526558 style='height:15.0pt'></td>
  <td colspan=2 class=xl7326558>Style</td>
  <td colspan=3 class=xl6426558 style='border-left:none'><?php echo $style;?></td>
  <td class=xl1526558></td>
  <td class=xl7026558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td colspan=2 class=xl7326558>Username</td>
  <td colspan=3 class=xl7226558 style='border-left:none'><?php echo $username;?></td>
  <td class=xl1526558></td>
 </tr>
 <tr height=36 style='mso-height-source:userset;height:27.0pt'>
  <td height=36 class=xl1526558 style='height:27.0pt'></td>
  <td colspan=2 class=xl7326558>Schedule</td> <td colspan=3 class=xl7526558 width=182 style='border-left:none;width:136pt'>
  <?php 
 
 $tem_sch='';
  $sql="select product_schedule from brandix_bts.tbl_cut_master where doc_num in (".implode(",",$doc_id).") group by product_schedule";
//  echo $sql."<br>";
  $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($sql_result))
	{
		$sch_no[]=$row1['product_schedule'];
	}
	for($i=0;$i<sizeof($sch_no);$i++)
	{
		$tem_sch.= $sch_no[$i].",";
		if($i=='2')
		{
			$tem_sch.="<br>";
		}
	}
	echo substr($tem_sch,0,-1);
	////$val=sizeof($sch_no);
  ?>
  
</td>
  <td class=xl7026558></td>
  <td class=xl7026558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td colspan=2 class=xl7326558>Date / Location</td>
  <td colspan=3 class=xl7226558 style='border-left:none'><?php echo date("Y-d-h")."<br>";echo $location;?></td>
  <td class=xl1526558></td>
 </tr>
 <tr height=37 style='mso-height-source:userset;height:27.75pt'>
  <td height=37 class=xl1526558 style='height:27.75pt'></td>
  <td colspan=2 class=xl7326558>Mini order No</td>
  <td colspan=3 class=xl7526558 width=182 style='border-left:none;width:136pt'><font
  class="font526558"><?php echo $mini_order_num."-".$cut_code;?></font><font class="font026558"><br>
    <?php echo implode(",",$doc_id);?></font></td>
  <td class=xl1526558></td>
  <td class=xl7026558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td colspan=2 class=xl7326558>Product Category</td>
  <td colspan=3 class=xl7226558 style='border-left:none'><?php echo $buyer_div;?></td>
  <td class=xl1526558></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1526558 style='height:15.0pt'></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1526558 style='height:15.0pt'></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td height=17 class=xl1526558 style='height:12.75pt'></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
 </tr>
 <tr height=27 style='mso-height-source:userset;height:20.25pt'>
  <td height=27 class=xl1526558 style='height:20.25pt'></td>
  <td class=xl6526558>Sno</td>
  <td colspan=3 class=xl6526558 style='border-left:none'>Color Code</td>
  <td class=xl6526558 style='border-left:none'>Size</td>
  <td class=xl6526558 style='border-left:none'>Quantity</td>
  <td class=xl6526558 style='border-left:none'>Count</td>
  <td class=xl6526558 style='border-left:none'>Qty-Bundles</td>
  <td colspan=6 class=xl6526558 style='border-left:none'>Bundle Numbers</td>
  <td class=xl1526558></td>
 </tr>
 <?php
  $sno=1;
  $tot_cnt=0;$tot_qty=0;
 for($jj=0;$jj<sizeof($doc_id);$jj++)
 {
	 ?>
	 
	 

	   <?php
	   //$schedule ='471273';
	
	$sql2="SELECT color,size,count(*) as cnt,sum(quantity) as qty from brandix_bts.tbl_miniorder_data where docket_number='".$doc_id[$jj]."' group by color,size";

	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$schedule = echo_title("brandix_bts.tbl_cut_master","product_schedule","doc_num",$doc_id[$jj],$link);
		$sch_id = echo_title("brandix_bts.tbl_cut_master","ref_order_num","doc_num",$doc_id[$jj],$link);
		$size_tie = echo_title("brandix_bts.tbl_orders_sizes_master","size_title","order_col_des='".$sql_row2['color']."' and parent_id='".$sch_id."' and ref_size_name",$sql_row2['size'],$link);
		
		$tot_cnt+=$sql_row2['cnt'];
		$tot_qty+=$sql_row2['qty'];
		$rows_s=ceil($sql_row2['cnt']/10);
		$ii=0;$val1='';
		$sql211="SELECT quantity,COUNT(*) as cnt FROM brandix_bts.tbl_miniorder_data WHERE docket_number='".$doc_id[$jj]."' AND color='".$sql_row2['color']."'  AND size='".$sql_row2['size']."' GROUP BY quantity";
		$sql_result21=mysqli_query($link, $sql211) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row21=mysqli_fetch_array($sql_result21))
		{
			if($ii==2)
			{
				$val1.=$sql_row21["quantity"]."-".$sql_row21["cnt"]."<br>";
			}
			else
			{
				$val1.=$sql_row21["quantity"]."-".$sql_row21["cnt"].",";
			}
			$ii++;
		}
	   ?>
	   <tr height=41 style='mso-height-source:userset;height:30.75pt'>
	  <td height=41 class=xl1526558 style='height:30.75pt'></td>
		<td class=xl6526558 rowspan=<?php echo $rows_s;?> style='border-top:none'><?php echo $sno;?></td>
	  <td colspan=3 rowspan=<?php echo $rows_s;?> class=xl6526558 style='border-left:none'><?php echo substr($sql_row2["color"],0,20)."-".$schedule;?></td>
	  <td  rowspan=<?php echo $rows_s;?> class=xl6526558 style='border-top:none;border-left:none'><?php echo $size_tie;?></td>
	  <td  rowspan=<?php echo $rows_s;?> class=xl6526558 style='border-top:none;border-left:none'><?php echo $sql_row2['qty'];?></td>
	  <td  rowspan=<?php echo $rows_s;?> class=xl6526558 style='border-top:none;border-left:none'><?php echo $sql_row2['cnt'];?></td>
	  <td rowspan=<?php echo $rows_s;?> class=xl7426558 width=84 style='border-top:none;border-left:none;width:63pt'><?php echo substr($val1,0,-1); ?></td>
	  <td colspan=6 class=xl7626558 width=375 style='border-right:.5pt solid black;
	  border-left:none;width:281pt'>
		<?php	
		$sno++;
		$rows=1;$row=1; $rows2=1;
		$sql21="SELECT * from brandix_bts.tbl_miniorder_data where docket_number='".$doc_id[$jj]."' and color='".$sql_row2['color']."' and size='".$sql_row2['size']."' group by bundle_number order by bundle_number";
		//echo $sql2."<br>";
		$sql_result21=mysqli_query($link, $sql21) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row21=mysqli_fetch_array($sql_result21))
		{
			if($rows2==5 && $rows<>10)
			{
				$rows2=0;$rows++;$row++;
				echo $sql_row21['bundle_number']."-".$sql_row21['quantity']."<br>";
				//$rows2++;
			}
			else
			{
				if($sql_row2['cnt']==$row)
				{
					if($rows==1)
					{
						echo $sql_row21['bundle_number']."-".$sql_row21['quantity'];
					}
					else
					{
						echo $sql_row21['bundle_number']."-".$sql_row21['quantity'];
					}	
					
				}
				else if($rows==10)
				{
					$rows=0;$rows2=0;
					echo $sql_row21['bundle_number']."-".$sql_row21['quantity'];
					echo "</td>
					<td class=xl159295></td>
					</tr>
					 <tr height=41 style='mso-height-source:userset;height:30.75pt'><td height=41 class=xl1526558 style='height:30.75pt'></td>
					<td colspan=6 class=xl7626558 width=375 style='border-right:.5pt solid black;border-left:none;width:281pt'>";
					
					$rows++;$row++;
				}
				else
				{	
					echo $sql_row21['bundle_number']."-".$sql_row21['quantity'].",";
					$rows++;$row++;
				}
			}
			$rows2++;
		}
		$i++;
		$rows_s=0;
		
	 ?>
	   
	  </td>
	  <td class=xl1526558></td>
	 </tr>
	 <?php
	}

 }
 ?>
  <tr height=41 style='mso-height-source:userset;height:30.75pt'>
	  <td height=41 class=xl1526558 style='height:30.75pt'></td>
		<td class=xl6526558 colspan=5 style='border-top:none'>Total</td>
	    <td  class=xl6526558 style='border-top:none;border-left:none'><?php echo $tot_qty;?></td>
	  <td  class=xl6526558 style='border-top:none;border-left:none'><?php echo $tot_cnt;?></td>
	  <td class=xl7426558 width=84 style='border-top:none;border-left:none;width:63pt'></td>
	  <td class=xl7626558 colspan=6 width=375 style='border-right:.5pt solid black; border-left:none;width:281pt'>
	  </td><td class=xl159295></td>
					</tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1526558 style='height:15.0pt'></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1526558 style='height:15.0pt'></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
  <td class=xl1526558></td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=25 style='width:19pt'></td>
  <td width=41 style='width:31pt'></td>
  <td width=75 style='width:56pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=63 style='width:47pt'></td>
  <td width=55 style='width:41pt'></td>
  <td width=61 style='width:46pt'></td>
  <td width=44 style='width:33pt'></td>
  <td width=84 style='width:63pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=55 style='width:41pt'></td>
  <td width=27 style='width:20pt'></td>
 </tr>
 <![endif]>
</table>

</div>


<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
</body>

</html>
