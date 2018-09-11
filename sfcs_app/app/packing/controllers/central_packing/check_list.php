<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');   ?>
<?php include('../../../../common/config/functions.php'); ?>
<?php ini_set('error_reporting', E_ALL); ?>
<?php
$style_id=$_GET['style_id'];
$schedule_id=$_GET['sch_id'];
$schedule=$_GET['schedule'];

$mpo ='';$cpo='';$cust_ord='';$module = '';
$leading = '';
$color = '';
$color_code = '';
$delivery=$schedule;
$sql="select * from $bai_pro3.bai_orders_db_confirm where order_del_no='$schedule'";
//mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error p".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$style=$sql_row['order_style_no'];
	$cpo=$sql_row['order_po_no'];
	$mpo=$sql_row['vpo'];
	$cust_ord=$sql_row['co_no'];
	$division=$sql_row['order_div'];
}
if($_GET['seq_no']==0)
{
	$filter="";
}
else
{
	$filter="and seq_no='".$_GET['seq_no']."'";
}
$seq_no=array();
$pack_method=array();
$pac_seq_no=array();
$pack_ref=echo_title("$bai_pro3.tbl_pack_ref","id","ref_order_num",$schedule_id,$link);	
$sql1="select seq_no,pack_method,pac_seq_no from $bai_pro3.pac_stat_log where schedule='$schedule' $filter group by seq_no*1";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error p".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$seq_no[]=$sql_row1['seq_no'];
	$pack_method[]=$sql_row1['pack_method'];
	$pac_seq_no[]=$sql_row1['pac_seq_no'];
}
 
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<title>Packing List</title>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 12">
<link rel=File-List href="packing_list_files/filelist.xml">
<style id="Book3_19400_Styles">

@media print {
   thead {display: table-header-group;}
}

<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
	
	.new
	{
		font-family:Calibri, sans-serif;
		font-size:12.0pt;
		border-collapse:collapse;
		border:1px solid black;
		white-space:nowrap;
	}
	

.xl6319400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6419400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6519400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
.xl6619400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:12.0pt;
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
.xl6719400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:12.0pt;
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
.xl6819400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:16.0pt;
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
	white-space:nowrap;}
.xl6919400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	/* border:.5pt solid windowtext;*/
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7019400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
	
	.xl7019400_new
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border-bottom:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
	
.xl7119400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7219400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7319400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
.xl7419400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7519400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7619400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7719400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
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
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7819400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
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
.xl7919400
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
.xl8019400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
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
	white-space:nowrap;}
	
	.xl8019400_new
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
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
	white-space:nowrap;
	line-height:2px;}
	
.xl8119400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
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
.xl8219400
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
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8319400
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
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8419400
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
.xl8519400
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
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8619400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
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
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
	.xl8619400_new
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:0.0pt;
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
	border-bottom:1px solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8719400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:right;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8819400
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
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8919400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
-->
</style>
</head>

<body>
<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Office Excel's Publish
as Web Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!--->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!---->

<div id="Book3_19400" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=1210 class=xl6619400
 style='border-collapse:collapse;table-layout:fixed;width:903pt'>
 <col class=xl6619400 width=74 style='mso-width-source:userset;mso-width-alt:
 2706;width:56pt'>
 <col class=xl6619400 width=47 span=19 style='mso-width-source:userset;
 mso-width-alt:1718;width:35pt'>
 <col class=xl6619400 width=51 style='mso-width-source:userset;mso-width-alt:
 1865;width:38pt'>
 <col class=xl6619400 width=64 style='width:48pt'>
 <col class=xl6619400 width=64 span=2 style='width:48pt'>
 <thead>
 <tr class=xl6419400 height=22 style='mso-height-source:userset;height:16.5pt'>
  <td colspan=21 height=22 class=xl6819400 width=1018 style='height:16.5pt;
  width:759pt'><?php if($_GET['p_status']==2){ echo "FG CHECK List"; } else { echo "Carton Track"; }?></td>
  <td class=xl6319400 width=64 style='width:48pt'></td>
  <td class=xl6319400 width=64 style='width:48pt'></td>
  <td class=xl6319400 width=64 style='width:48pt'></td>
 </tr>
 <tr class=xl6419400 height=13 style='mso-height-source:userset;height:9.75pt'>
  <td height=13 class=xl6319400 style='height:9.75pt'></td>
  <td class=xl6319400></td>
  <td class=xl6519400>&nbsp;</td>
  <td class=xl6519400>&nbsp;</td>
  <td class=xl6319400></td>
  <td class=xl6319400></td>
  <td class=xl6419400></td>
  <td class=xl6419400></td>
  <td class=xl6419400></td>
  <td class=xl6419400></td>
  <td class=xl6319400></td>
  <td class=xl6319400></td>
  <td class=xl6419400></td>
  <td class=xl6419400></td>
  <td class=xl6419400></td>
  <td class=xl6419400></td>
  <td class=xl6319400></td>
  <td class=xl6319400></td>
  <td class=xl6319400></td>
  <td class=xl6319400></td>
  <td class=xl6419400></td>
  <td class=xl6419400></td>
  <td class=xl6419400></td>
  <td class=xl6419400></td>
 </tr>
 <tr class=xl7219400 height=22 style='mso-height-source:userset;height:16.5pt'>
  <td height=22 class=xl6919400 style='height:16.5pt'>Style :</td>
  <td colspan=4 class=xl7019400_new style='border-left:none'><?php echo trim($style); ?></td>
  <td class=xl7119400></td>
  <td colspan=3 class=xl6919400>Buyer Division :</td>
  <td colspan=4 class=xl7019400_new style='border-left:none'><?php echo trim($division); ?></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td colspan=3 class=xl6919400>CPO :</td>
  <td colspan=3 class=xl7019400_new style='border-left:none'><?php echo trim($cpo); ?></td>
  
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
 </tr>
 <tr class=xl7219400 height=22 style='mso-height-source:userset;height:16.5pt'>
  <td height=22 class=xl6919400 style='height:16.5pt;border-top:none'>Sch No :</td>
  <td colspan=4 class=xl7019400_new style='border-left:none'><?php echo trim($delivery); ?></td>
  <td class=xl7119400></td>
  <td colspan=3 class=xl6919400>MPO :</td>
  <td colspan=4 class=xl7019400_new style='border-left:none'><?php echo trim($mpo); ?></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td colspan=3 class=xl6919400>Customer Order :</td>
  <td colspan=3 class=xl7019400_new style='border-left:none'><?php echo trim($cust_ord); ?></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
 </tr>
 <tr class=xl7219400 height=22 style='mso-height-source:userset;height:16.5pt'>
  
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
 </tr>
 <tr class=xl7219400 height=22 style='mso-height-source:userset;height:16.5pt'>
  <td height=22 class=xl7119400 style='height:16.5pt'></td>
  <td class=xl7119400></td>
  <td class=xl7319400>&nbsp;</td>
  <td class=xl7319400>&nbsp;</td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
 </tr>
 <?php
 /*
 ?>
 <tr class=xl7219400 height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl7419400 style='height:15.75pt'>Size:</td>
  
  
  
  <?php
  
  $count=0;
  for($i=0;$i<sizeof($order_qtys);$i++)
  {
  	if($order_qtys[$i]>0)
	{
		echo "<td class=xl7019400>".$size_titles[$i]."</td>";
		$count++;
	}
  }
  for($i=0;$i<13-$count-1;$i++)
  {
  	echo "<td class=xl7019400>&nbsp;</td>";
  }
  echo "<td class=xl7019400>Total</td>";
  ?>
  
  
 </tr>
 

			<tr class=xl7219400 height=21 style='mso-height-source:userset;height:15.75pt'>
				<td height=21 class=xl7419400 style='height:15.75pt'>Order Qty:</td>

				<?php

				$count=0;
				for($i=0;$i<sizeof($old_order_qtys);$i++)
				{
					if($old_order_qtys[$i]>0)
				{
					echo "<td class=xl7019400>".$old_order_qtys[$i]."</td>";
					$count++;
				}
				}
				for($i=0;$i<13-$count-1;$i++)
				{
					echo "<td class=xl7019400>&nbsp;</td>";
				}
				echo "<td class=xl7019400>$old_total</td>";

				?>
			</tr>

 <tr class=xl7219400 height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl7419400 style='height:15.75pt'>Plan Qty:</td>
  

  
  <?php
  
  $count=0;
  for($i=0;$i<sizeof($order_qtys);$i++)
  {
  	if($order_qtys[$i]>0)
	{
		echo "<td class=xl7019400>".$carton_qtys[$i]."</td>";
		$count++;
	}
  }
  for($i=0;$i<13-$count;$i++)
  {
  	echo "<td class=xl7019400>&nbsp;</td>";
  }
  
  ?>
  
  <td class=xl7119400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
 </tr>
 <?php
 */
 ?>
 <tr class=xl7219400 height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl7619400 style='height:15.75pt'></td>
   <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
 </tr>
 
 <?php 
 for($i=0;$i<sizeof($seq_no);$i++)
 {
	$query = "SELECT r.pack_method as pack,r.pack_description,GROUP_CONCAT(DISTINCT(trim(color))) as color,GROUP_CONCAT(DISTINCT(size_title)) as size FROM tbl_pack_size_ref AS r LEFT JOIN tbl_pack_ref p ON p.id = r.parent_id WHERE p.ref_order_num = '$schedule_id' AND r.seq_no = '$pac_seq_no[$i]' group by seq_no";
	$sql_result=mysqli_query($link, $query) or exit("Sql Error a".mysqli_error($GLOBALS["___mysqli_ston"]));
	$count = mysqli_num_rows($sql_result);
	//echo $count;
	while($sql_row=mysqli_fetch_array($sql_result))
	{
	?>
	  <tr class=xl6553519400 height=20 style='mso-height-source:userset;height:15.0pt'>
	  <td class=xl8319400 style='border-top:none' colspan=2><b>Packing Method <b>: </td>
	  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
	  <td class=xl8219400><?php echo $operation[$pack_method[$i]];?></td>
	  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
	  <td class=xl8219400>&nbsp;</td>
	  <td class=xl8219400>&nbsp;</td>
	  <td class=xl8319400 style='border-top:none' colspan=2><b>Description <b>: </td>
	  <td class=xl8219400  colspan=11 ><?php echo $sql_row['pack_description'];?></td>
	  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
	  </tr>
	  <tr class=xl6553519400 height=20 style='mso-height-source:userset;height:15.0pt'>
	  <td class=xl8319400 style='border-top:none' colspan=2><b>Colors <b>: </td>
	  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
	  <td class=xl8219400  colspan=17 ><?php echo $sql_row['color'];?></td>
	  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
	    
	  </tr>
	  <tr class=xl6553519400 height=20 style='mso-height-source:userset;height:15.0pt'>
	  <td class=xl8319400 style='border-top:none' colspan=2><b>Sizes <b>: </td>
	  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
	  <td class=xl8219400  colspan=17 ><?php echo $sql_row['size'];?></td>
	  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
	    
	  </tr>
	<?php
	}	
		$carton_nodes=array();
		$x=1;
		$sql="select carton_no,seq_no,MIN(STATUS) as status,min(tid) as \"tid\",sum(carton_act_qty) as \"carton_act_qty\" from $bai_pro3.packing_summary where order_del_no='$schedule' and seq_no = '".$seq_no[$i]."' group by carton_no order by carton_no";
		$sql_result4=mysqli_query($link, $sql) or exit("Sql Error b".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row4=mysqli_fetch_array($sql_result4))
		{
			$carton_act_qty=$sql_row4['carton_act_qty'];
			$status=$sql_row4['status'];
			$tid=$sql_row4['tid'];
			$carton_no=$sql_row4['carton_no'];
			if($_GET['p_status']==1)
			{
				$bgcolor="RED";
				if($status=="DONE")
				{
					$bgcolor="GREEN";
				}
			}
			else
			{
				$bgcolor='';
			}
			
			$carton_nodes[]=$x."-".$carton_no."-".$carton_act_qty."-".$bgcolor."-".$tid;
			$x++;
		}
		$cycle=0;
	?>	
	<tr class=xl6553519400 height=20 style='height:15.0pt'>
	  <td height=20 class=xl7719400 style='height:15.0pt'>Rows</td>
	  <td class=xl7819400 style='border-left:none'>Sno</td>
	  <td class=xl7819400 style='border-left:none'>C# No</td>
	  <td class=xl7819400 style='border-left:none'>Qty</td>
	  <td class=xl7819400 style='border-left:none' colspan=2>Carton ID</td>
	  <td class=xl7819400>Sno</td>
	  <td class=xl7819400 style='border-left:none'>C# No</td>
	  <td class=xl7819400 style='border-left:none'>Qty</td>
	 <td class=xl7819400 style='border-left:none' colspan=2>Carton ID</td>
	  <td class=xl7819400>Sno</td>
	  <td class=xl7819400 style='border-left:none'>C# No</td>
	  <td class=xl8119400 style='border-left:none'>Qty</td>
	 <td class=xl7819400 style='border-left:none' colspan=2>Carton ID</td>
	  <td class=xl7819400>Sno</td>
	  <td class=xl7819400 style='border-left:none'>C# No</td>
	  <td class=xl7819400 style='border-left:none'>Qty</td>
	 <td class=xl7819400 style='border-left:none' colspan=2>Carton ID</td>
	  <td class=xl6553519400></td>
	  <td class=xl6553519400></td>
	  <td class=xl6553519400></td>
	 </tr>
	 
	 <tr class=xl6553519400 height=20 style='mso-height-source:userset;height:15.0pt'>
	  <td height=20 class=xl7919400 style='height:15.0pt'></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl6553519400></td>
	  <td class=xl6553519400></td>
	  <td class=xl6553519400></td>
	 </tr>
	 </thead>
 <?php
	$cycle=0;$sno=1;$node_detail=array();$val=0;
	$val=sizeof($carton_nodes);
	for($j=0;$j<sizeof($carton_nodes);$j+=4)
	{
		echo "<tr class=xl6553519400 height=20 style='height:15.0pt'>";
		if($cycle==0)
		{
			echo " <td height=20 class=xl8019400 style='height:15.0pt'>".$sno."</td>";
			$sno++;
		}
		else
		{
			echo " <td height=20 class=xl8019400 style='height:15.0pt'>".$sno."</td>";
			$sno++;
		}
		for($m=$j;$m<$j+4;$m++)
		{		
			
			if($m<$val)
			{
				$node_detail=explode("-",$carton_nodes[$m]);
				$val1=$node_detail[2];
				if($val1>0)
				{
					echo "<td class=xl8419400>".$node_detail[0]."</td>
					<td class=xl8419400 style='border-left:none;background-color:$node_detail[3];'>".$node_detail[1]."</td>
					<td class=xl8419400 style='border-left:none;background-color:$node_detail[3];'>".$node_detail[2]."</td>
					<td class=xl8419400 style='border-left:none;background-color:$node_detail[3];' colspan=2>".$node_detail[4]."</td>";
				}
				else
				{
					echo "<td class=xl8419400_new></td>
					<td class=xl8419400_new style='border-left:none'></td>
					<td class=xl8419400_new style='border-left:none'></td>
					<td class=xl8419400_new style='border-left:none'>&nbsp;</td>
					<td class=xl7919400_new></td>";
				}			
			}
		}
		unset($node_detail);
		echo "<td class=xl6553519400></td>
			<td class=xl6553519400></td>
			<td class=xl6553519400></td>
			</tr>";
			$cycle++;
	}
	?>
	<tr class=xl6553519400 height=20 style='mso-height-source:userset;height:15.0pt'>
	  <td height=20 class=xl7919400 style='height:15.0pt'></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl6553519400></td>
	  <td class=xl6553519400></td>
	  <td class=xl6553519400></td>
	 </tr>
	 <tr class=xl6553519400 height=20 style='mso-height-source:userset;height:15.0pt'>
	  <td height=20 class=xl7919400 style='height:15.0pt'></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl6553519400></td>
	  <td class=xl6553519400></td>
	  <td class=xl6553519400></td>
	 </tr>
	 <tr class=xl6553519400 height=20 style='mso-height-source:userset;height:15.0pt'>
	  <td height=20 class=xl7919400 style='height:15.0pt'></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl7919400></td>
	  <td class=xl6553519400></td>
	  <td class=xl6553519400></td>
	  <td class=xl6553519400></td>
	 </tr>
	<?php
}
    
 ?>
 
  <tr class=xl6553519400 height=20 style='height:15.0pt'>
  <td height=20 class=xl7919400 style='height:15.0pt'></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
 </tr>
 <tr class=xl6553519400 height=20 style='height:15.0pt'>
  <td colspan=2 height=20 class=xl8719400 style='height:15.0pt'>Prepared By :</td>
  <td colspan=4 class=xl8819400>&nbsp;</td>
  <td class=xl7219400></td>
  <td colspan=3 class=xl8719400>Order Completed By :</td>
  <td colspan=4 class=xl8819400>&nbsp;</td>
  <td class=xl7919400></td>
  <td colspan=2 class=xl8719400>Approved By :</td>
  <td colspan=4 class=xl8919400>&nbsp;</td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
 </tr> 
 <tr class=xl6553519400 height=20 style='height:15.0pt'>
  <td height=20 class=xl7919400 style='height:15.0pt'></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
 </tr>
 <?php
	/*
  <tr class=xl6553519400 style='height:auto'>
  <td class=xl7919400 style='height: auto; width:400px;' colspan=21>

	
//FOR Carton (Mixed and Full Allocaiton)
$temp_doc_ref=array();
$max_size_qty=0;
$max_size_code="";
$count=0;
$sql="select packing_summary.*, sum(carton_act_qty) as \"carton_qty\" from $bai_pro3.packing_summary where order_style_no=\"$style\" and order_del_no=\"$schedule\" and container is null group by doc_no_ref";
//echo $sql;
//mysqli_query($link, $sql) or exit("Sql Error c".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error c".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$carton_qty=$sql_row['carton_qty'];
	
	if($carton_qty==$carton_qtys[array_search(strtoupper($sql_row['size_code']),$size_titles_qry)])
	{
		$temp_doc_ref[]=$sql_row['doc_no_ref'];
	}
	else
	{
		if($carton_qty>$max_size_qty)
		{
			$max_size_qty=$carton_qty;
			$max_size_code=strtoupper($sql_row['size_code']);
		}
		$count++;
	}
}

if(sizeof($temp_doc_ref)>0)
{
	$sql="update $bai_pro3.pac_stat_log set container=1 where doc_no_ref in (\"".implode('","',$temp_doc_ref)."\")";
	//echo $sql;
	mysqli_query($link, $sql) or exit("Sql Error d".mysqli_error($GLOBALS["___mysqli_ston"]));
}

//No partial Cartons for DIM/M&S and VSD 
$x=2;
$sql="select packing_summary.*, sum(carton_act_qty) as \"carton_qty\" from $bai_pro3.packing_summary where order_style_no=\"$style\" and order_del_no=\"$schedule\" and container is null group by doc_no_ref";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error g".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$sql1="update $bai_pro3.pac_stat_log set container=$x where doc_no_ref=\"".$sql_row['doc_no_ref']."\"";
	mysqli_query($link, $sql1) or exit("Sql Error h".mysqli_error($GLOBALS["___mysqli_ston"]));
	$x++;
}


$temp_1=array();
$temp_1=explode("*",$remarks);
$temp_2=array();
$temp_2=explode("$",$temp_1[0]);
$assort=array_sum($temp_2);

?>


<table class="new">
	  <tr class=new><th class=new>Cartons</th><th class=new>Label IDs (ALPHA VERSION V1)</th></tr>
	  <?php
	  	$total=0;
		$sql1="select container,group_concat(tid) as \"label_id\", count(*) as \"count\" from $bai_pro3.packing_summary where order_style_no=\"$style\" and order_del_no=\"$schedule\" group by container";
		//echo $sql1;
		//mysql_query($sql1,$link) or exit("Sql Error ".mysql_error());
		$sql_result1=mysqli_query($link, $sql) or exit("Sql Error g".mysqli_error($GLOBALS["___mysqli_ston"]));
		//$sql_result1=mysqli_query($sql1,$link) or exit("Sql Error g".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
	    	$container=$sql_row1['container'];
		$sql="select container,group_concat(label_id) as \"label_id\", count(*) as \"count\" from (select container,min(tid) as \"label_id\", count(*) as \"count\" from $bai_pro3.packing_summary where order_style_no=\"$style\" and order_del_no=\"$schedule\" and container=$container group by doc_no_ref) as t group by container";
		//mysql_query($sql,$link) or exit("Sql Error h".mysql_error());
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error g".mysqli_error($GLOBALS["___mysqli_ston"]));
		//$sql_result=mysqli_query($sql,$link) or exit("Sql Error h".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			//echo "<tr><td>".$sql_row['container']."</td><td>".$sql_row['count']."</td><td>".$sql_row['label_id']."</td></tr>";
			$count=$sql_row['count'];
			if($sql_row['container']!=1)
			{
				$count=1;
			}
			$description = str_replace(",",", ",$sql_row['label_id']);
			echo '<tr class=new><td class=new>'.$count."</td><td class=new>".wordwrap($description, 145, "<br>\n")."</td></tr>";
			$total+=$count;
		}
		}
		echo "<tr class=new><th colspan=2 class=new align=left>Total Cartons: $total</th></tr>";
	  ?>
</table>
<?php
*/
?>
  
  </td>

  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
 </tr>



 
</table>

</div>





</body>

</html>



