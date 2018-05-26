<?php include('../../../../common/config/config.php'); ?>
<?php //include("../".getFullURL($_GET['r'], "", "R").""); ?>
<?php include('../../../../common/php/functions.php'); ?>   
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>


<?php
$order_tid=$_GET['order_tid'];
$cat_ref=$_GET['cat_ref'];
?>

<?php

$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$style=$sql_row['order_style_no']; //Style
	$color=$sql_row['order_col_des']; //color
	$division=$sql_row['order_div'];
	$delivery=$sql_row['order_del_no']; //Schedule
	$pono=$sql_row['order_po_no']; //po
	$color_code=$sql_row['color_code']; //Color Code
	$orderno=$sql_row['order_no']; 
	$o_xs=$sql_row['order_s_xs'];
	$o_s=$sql_row['order_s_s'];
	$o_m=$sql_row['order_s_m'];
	$o_l=$sql_row['order_s_l'];
	$o_xl=$sql_row['order_s_xl'];
	$o_xxl=$sql_row['order_s_xxl'];
	$o_xxxl=$sql_row['order_s_xxxl'];
	$order_total=$o_xs+$o_s+$o_m+$o_l+$o_xl+$o_xxl+$o_xxxl;
	$order_date=$sql_row['order_date'];
}
	
$sql="select * from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and tid=$cat_ref";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$category=$sql_row['category'];
	$gmtway=$sql_row['gmtway'];
	$fab_des=$sql_row['fab_des'];
	$body_yy=$sql_row['catyy'];
	$waist_yy=$sql_row['waist_yy'];
	$leg_yy=$sql_row['leg_yy'];
	$purwidth=$sql_row['purwidth'];
	$compo_no=$sql_row['compo_no'];
	$strip_match=$sql_row['strip_match'];
	$gusset_sep=$sql_row['gusset_sep'];
	$patt_ver=$sql_row['patt_ver'];
	$col_des=$sql_row['col_des'];
}

$sql="select sum(allocate_xs*plies) as \"cuttable_s_xs\", sum(allocate_s*plies) as \"cuttable_s_s\", sum(allocate_m*plies) as \"cuttable_s_m\", sum(allocate_l*plies) as \"cuttable_s_l\", sum(allocate_xl*plies) as \"cuttable_s_xl\", sum(allocate_xxl*plies) as \"cuttable_s_xxl\", sum(allocate_xxxl*plies) as \"cuttable_s_xxxl\" from $bai_pro3.allocate_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$c_xs=$sql_row['cuttable_s_xs'];
	$c_s=$sql_row['cuttable_s_s'];
	$c_m=$sql_row['cuttable_s_m'];
	$c_l=$sql_row['cuttable_s_l'];
	$c_xl=$sql_row['cuttable_s_xl'];
	$c_xxl=$sql_row['cuttable_s_xxl'];
	$c_xxxl=$sql_row['cuttable_s_xxxl'];
	$cuttable_total=$c_xs+$c_s+$c_m+$c_l+$c_xl+$c_xxl+$c_xxxl;
}


?>

<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 12">
<link rel=File-List href="../../js/filelist.xml">
<!--[if !mso]>
<style>
v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
x\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]-->
<style id="Book2_14270_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl7014270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
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
	white-space:nowrap;}
.xl7114270
	{padding:0px;
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
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7214270
	{padding:0px;
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
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7314270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7414270
	{padding:0px;
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
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7514270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
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
.xl7614270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7714270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:0;
	text-align:general;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7814270
	{padding:0px;
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
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7914270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\#\,\#\#0";
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8014270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
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
.xl8114270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:8.0pt;
	font-weight:700;
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
.xl8214270
	{padding:0px;
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
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8314270
	{padding:0px;
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
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8414270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
.xl8514270
	{padding:0px;
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
	vertical-align:bottom;
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
.xl8614270
	{padding:0px;
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
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8714270
	{padding:0px;
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
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8814270
	{padding:0px;
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
	vertical-align:bottom;
	border:.5pt solid windowtext;
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
.xl8914270
	{padding:0px;
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
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt hairline windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9014270
	{padding:0px;
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
	white-space:nowrap;}
.xl9114270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9214270
	{padding:0px;
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
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9314270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\#\,\#\#0";
	text-align:general;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9414270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:0;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9514270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9614270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:0%;
	text-align:center;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:2.0pt double windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9714270
	{padding:0px;
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
	border-bottom:2.0pt double windowtext;
	border-left:.5pt solid windowtext;
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9814270
	{padding:0px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9914270
	{padding:0px;
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
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10014270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:14.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:underline;
	text-underline-style:single;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10114270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
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
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl10214270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
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
.xl10314270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
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
.xl10414270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:right;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10514270
	{padding:0px;
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
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10614270
	{padding:0px;
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
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10714270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
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
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10814270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
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
	white-space:nowrap;}
.xl10914270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
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
.xl11014270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
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
.xl11114270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
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
.xl11214270
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
-->
body{
	zoom:75%;
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
body { zoom:75%;}
#ad{ display:none;}
#leftbar{ display:none;}
#Book2_14270{ width:75%; margin-left:30px;}
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
<!--The following information was generated by Microsoft Office Excel's Publish
as Web Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<div id="Book2_14270" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=5061 class=xl7014270
 style='border-collapse:collapse;table-layout:fixed;width:3798pt'>
 <col class=xl7014270 width=13 style='mso-width-source:userset;mso-width-alt:
 475;width:10pt'>
 <col class=xl7214270 width=61 style='mso-width-source:userset;mso-width-alt:
 2230;width:46pt'>
 <col class=xl7214270 width=53 span=7 style='mso-width-source:userset;
 mso-width-alt:1938;width:40pt'>
 <col class=xl7214270 width=52 span=3 style='mso-width-source:userset;
 mso-width-alt:1901;width:39pt'>
 <col class=xl7214270 width=51 span=2 style='mso-width-source:userset;
 mso-width-alt:1865;width:38pt'>
 <col class=xl7214270 width=61 style='mso-width-source:userset;mso-width-alt:
 2230;width:46pt'>
 <col class=xl7214270 width=51 span=2 style='mso-width-source:userset;
 mso-width-alt:1865;width:38pt'>
 <col class=xl7214270 width=48 style='mso-width-source:userset;mso-width-alt:
 1755;width:36pt'>
 <col class=xl7214270 width=58 style='mso-width-source:userset;mso-width-alt:
 2121;width:44pt'>
 <col class=xl7214270 width=48 style='mso-width-source:userset;mso-width-alt:
 1755;width:36pt'>
 <col class=xl7214270 width=59 style='mso-width-source:userset;mso-width-alt:
 2157;width:44pt'>
 <col class=xl7214270 width=48 span=2 style='mso-width-source:userset;
 mso-width-alt:1755;width:36pt'>
 <col class=xl7014270 width=48 span=2 style='mso-width-source:userset;
 mso-width-alt:1755;width:36pt'>
 <col class=xl7014270 width=45 span=2 style='mso-width-source:userset;
 mso-width-alt:1645;width:34pt'>
 <col class=xl7014270 width=51 style='mso-width-source:userset;mso-width-alt:
 1865;width:38pt'>
 <col class=xl7014270 width=20 style='mso-width-source:userset;mso-width-alt:
 731;width:15pt'>
 <col class=xl7014270 width=45 style='mso-width-source:userset;mso-width-alt:
 1645;width:34pt'>
 <col class=xl7014270 width=64 span=56 style='width:48pt'>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl7014270 width=13 style='height:15.0pt;width:10pt'></td>
  <td class=xl7214270 width=61 style='width:46pt'></td>
  <td class=xl7214270 width=53 style='width:40pt'></td>
  <td class=xl7214270 width=53 style='width:40pt'></td>
  <td class=xl7214270 width=53 style='width:40pt'></td>
  <td class=xl7214270 width=53 style='width:40pt'></td>
  <td class=xl7214270 width=53 style='width:40pt'></td>
  <td class=xl7214270 width=53 style='width:40pt'></td>
  <td class=xl7214270 width=53 style='width:40pt'></td>
  <td class=xl7214270 width=52 style='width:39pt'></td>
  <td class=xl7214270 width=52 style='width:39pt'></td>
  <td class=xl7214270 width=52 style='width:39pt'></td>
  <td class=xl7214270 width=51 style='width:38pt'></td>
  <td class=xl7214270 width=51 style='width:38pt'></td>
  <td class=xl7214270 width=61 style='width:46pt'></td>
  <td class=xl7214270 width=51 style='width:38pt'></td>
  <td class=xl7214270 width=51 style='width:38pt'></td>
  <td class=xl7214270 width=48 style='width:36pt'></td>
  <td class=xl7214270 width=58 style='width:44pt'></td>
  <td class=xl7214270 width=48 style='width:36pt'></td>
  <td class=xl7214270 width=59 style='width:44pt'></td>
  <td class=xl7214270 width=48 style='width:36pt'></td>
  <td class=xl7214270 width=48 style='width:36pt'></td>
  <td class=xl7014270 width=48 style='width:36pt'></td>
  <td class=xl7014270 width=48 style='width:36pt'></td>
  <td class=xl7014270 width=45 style='width:34pt'></td>
  <td class=xl7014270 width=45 style='width:34pt'></td>
  <td class=xl7014270 width=51 style='width:38pt'></td>
  <td class=xl7014270 width=20 style='width:15pt'></td>
  <td class=xl7014270 width=45 style='width:34pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
  <td class=xl7014270 width=64 style='width:48pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl7014270 style='height:15.0pt'></td>
  <td colspan=8 rowspan=3 height=60 class=xl7014270 width=432 style='mso-ignore:
  colspan-rowspan;height:45.0pt;width:326pt'><!--[if gte vml 1]><v:shapetype
   id="_x0000_t75" coordsize="21600,21600" o:spt="75" o:preferrelative="t"
   path="m@4@5l@4@11@9@11@9@5xe" filled="f" stroked="f">
   <v:stroke joinstyle="miter"/>
   <v:formulas>
    <v:f eqn="if lineDrawn pixelLineWidth 0"/>
    <v:f eqn="sum @0 1 0"/>
    <v:f eqn="sum 0 0 @1"/>
    <v:f eqn="prod @2 1 2"/>
    <v:f eqn="prod @3 21600 pixelWidth"/>
    <v:f eqn="prod @3 21600 pixelHeight"/>
    <v:f eqn="sum @0 0 1"/>
    <v:f eqn="prod @6 1 2"/>
    <v:f eqn="prod @7 21600 pixelWidth"/>
    <v:f eqn="sum @8 21600 0"/>
    <v:f eqn="prod @7 21600 pixelHeight"/>
    <v:f eqn="sum @10 21600 0"/>
   </v:formulas>
   <v:path o:extrusionok="f" gradientshapeok="t" o:connecttype="rect"/>
   <o:lock v:ext="edit" aspectratio="t"/>
  </v:shapetype><v:shape id="Text_x0020_Box_x0020_1" o:spid="_x0000_s1025"
   type="#_x0000_t75" style='position:absolute;margin-left:39.75pt;
   margin-top:18pt;width:273.75pt;height:23.25pt;z-index:1;visibility:visible'
   o:gfxdata="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
bFBLBQYAAAAABAAEAPUAAADXBgAAAAA=
">
   <v:imagedata src="Book2_files/Book2_14270_image001.png" o:title=""/>
   <o:lock v:ext="edit" aspectratio="f"/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><v:shape id="Picture_x0020_4" o:spid="_x0000_s1026" type="#_x0000_t75"
   alt="LOGO" style='position:absolute;margin-left:11.25pt;margin-top:6pt;
   width:33pt;height:36.75pt;z-index:2;visibility:visible' o:gfxdata="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
RklGAAEBAQBgAGAAAP/bAEMACAYGBwYFCAcHBwkJCAoMFA0MCwsMGRITDxQdGh8eHRocHCAkLicg
IiwjHBwoNyksMDE0NDQfJzk9ODI8LjM0Mv/bAEMBCQkJDAsMGA0NGDIhHCEyMjIyMjIyMjIyMjIy
MjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMv/AABEIAEIAMwMBIgACEQEDEQH/
xAAfAAABBQEBAQEBAQAAAAAAAAAAAQIDBAUGBwgJCgv/xAC1EAACAQMDAgQDBQUEBAAAAX0BAgMA
BBEFEiExQQYTUWEHInEUMoGRoQgjQrHBFVLR8CQzYnKCCQoWFxgZGiUmJygpKjQ1Njc4OTpDREVG
R0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0
tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4eLj5OXm5+jp6vHy8/T19vf4+fr/xAAfAQADAQEBAQEB
AQEBAAAAAAAAAQIDBAUGBwgJCgv/xAC1EQACAQIEBAMEBwUEBAABAncAAQIDEQQFITEGEkFRB2Fx
EyIygQgUQpGhscEJIzNS8BVictEKFiQ04SXxFxgZGiYnKCkqNTY3ODk6Q0RFRkdISUpTVFVWV1hZ
WmNkZWZnaGlqc3R1dnd4eXqCg4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TF
xsfIycrS09TV1tfY2dri4+Tl5ufo6ery8/T19vf4+fr/2gAMAwEAAhEDEQA/APf6KKKAOe8XeIW0
DTEaBUa6nbZEH6LgZLEd8cfiRXlV3qmoX8pku764mcnPzSHA+gHA/ACu1+J0bZ0ub+Aeah9idpH8
j+Vef15+Ik+e3Q+yyXD0o4aNRL3nfX52On8N+Mb7TLyKG9uXnsGYK/nNuaMH+IMecD06Y6V61Xz9
tZ/kVSzNwFHUk9BXvdpE8NnBFK++RI1Vm/vEDBNbYaTaaZ52f4enTlCpBWbvf5W1JqKKK6j54Ko3
usabpzBLy+t4HIyFeQA4+nWsvxnrUui6EXtztuLhxDG/9zIJLfkD+JFeQElmZ2YszHLMTkk+pPeu
erX5HZHtZblP1qHtJytH8zsvHfiGx1Y2tpYSecsLGR5R93JGAB69/wBPfGJonhrUteLNaRqsKHDT
SkhM+gxkk/QVkV7R4TMJ8KaZ5GNvkKGx/f8A4/8Ax7NYQXtptyPYxdT+zMLGFFX1td/eZfh7wLba
RdJe3U/2q5TlBt2oh9QOpPv+ldbRRXbGCirI+Ur4iriJ89V3YUUUVRgcr4/02W+8PCaEFntJPOZR
1KYIb8s5/A15RmvoGucv/A+h385m8h7d2OW+zvtB/Dp+QrmrUHN80T3srzaGGp+yqrTo0eQ5x3rT
0jxDqeiBxY3AWNzlo3G5CfXHY/SvU7DwloencxWEcjkYLz/vD/490/Cub8feHbSDT01OytUheNws
wiXapQ8AkDuDgZ9+elYuhOC5kz0oZvhsVUVCUNH3t+Ryl54p1y+bMupTIP7sLeWB/wB84/WtPw/4
3v8AT7uOPUbhrmyY4cynLxj+8G6kDuDXK0qxvKyxRqXkchVUfxE8AfnWSqTTvc9KpgsPOn7NwSXo
fQFFQ2sJt7OCFnLtHGqFj/EQMZor1D8+e+hNRRRQIiubiO0tZrmZtsUKGRzjOFAya85vPiNNcTPG
mmW72LAq0U5JZ1PqRwM+mD+NeganZLqWl3VkzbRPEybsZ2kjg/ga8im8J69Bd/Zjps0jk4Dx4KH3
3dAPriuavKorcp7mT0cJUUnXautru2hu2vguy8QWq6jpF89tBIxBt5o95iIPK5DD8M9sc10eg+CL
HRp1upZWu7pPuOy7VT3C88+5Jq74U0aXQ9DS1nYGdnaSTacgE9h9AB+Oa26unSikpNamGMzGvKUq
UKjcLtLzXru/1CiiitjygooooAKKKKACiiigAooooA//2VBLAQItABQABgAIAAAAIQD0vmNdDgEA
ABoCAAATAAAAAAAAAAAAAAAAAAAAAABbQ29udGVudF9UeXBlc10ueG1sUEsBAi0AFAAGAAgAAAAh
AAjDGKTUAAAAkwEAAAsAAAAAAAAAAAAAAAAAPwEAAF9yZWxzLy5yZWxzUEsBAi0AFAAGAAgAAAAh
AKrdBV5DAgAALAYAABIAAAAAAAAAAAAAAAAAPAIAAGRycy9waWN0dXJleG1sLnhtbFBLAQItABQA
BgAIAAAAIQBYYLMbugAAACIBAAAdAAAAAAAAAAAAAAAAAK8EAABkcnMvX3JlbHMvcGljdHVyZXht
bC54bWwucmVsc1BLAQItABQABgAIAAAAIQDqs/MIFQEAAIgBAAAPAAAAAAAAAAAAAAAAAKQFAABk
cnMvZG93bnJldi54bWxQSwECLQAKAAAAAAAAACEAOHMR3/MFAADzBQAAFQAAAAAAAAAAAAAAAADm
BgAAZHJzL21lZGlhL2ltYWdlMS5qcGVnUEsFBgAAAAAGAAYAhQEAAAwNAAAAAA==
">
   <v:imagedata src="Book2_files/Book2_14270_image002.png" o:title=""/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><![endif]--><![if !vml]><span style='mso-ignore:vglayout'>
  <table cellpadding=0 cellspacing=0>
   <tr>
    <td width=15 height=8></td>
   </tr>
   <tr>
    <td></td>
    <td><img width=403 height=49 src="../../common/images/Book2_14270_image003.png"
    alt=LOGO v:shapes="Text_x0020_Box_x0020_1 Picture_x0020_4"></td>
    <td width=14></td>
   </tr>
   <tr>
    <td height=3></td>
   </tr>
  </table>
  </span><![endif]><!--[if !mso & vml]><span style='width:324.0pt;height:45.0pt'></span><![endif]--></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7114270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl7014270 style='height:15.0pt'></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td colspan=6 class=xl9814270>Cutting Department</td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7114270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl7014270 style='height:15.0pt'></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7114270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
 </tr>
 <tr height=9 style='mso-height-source:userset;height:6.75pt'>
  <td height=9 class=xl7014270 style='height:6.75pt'></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7114270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
 </tr>
 <tr height=33 style='mso-height-source:userset;height:24.75pt'>
  <td height=33 class=xl7014270 style='height:24.75pt'></td>
  <td colspan=27 class=xl10014270>Cut Distribution Plan/Production
  Input&amp;Output<span style='mso-spacerun:yes'> </span></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7114270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl7014270 style='height:15.0pt'></td>
  <td class=xl7114270>Style :</td>
  <td colspan=3 class=xl10614270><?php echo $style; ?></td>
  <td class=xl7214270></td>
  <td colspan=3 class=xl7114270>Category :</td>
  <td colspan=12 class=xl10614270><?php echo $category; ?></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td colspan=2 class=xl9914270>Date :</td>
  <td colspan=3 class=xl10614270><?php echo $order_date; ?></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7114270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl7014270 style='height:15.0pt'></td>
  <td class=xl7114270>Sch No :</td>
  <td colspan=3 class=xl10614270><?php echo $delivery.chr($color_code); ?></td>
  <td class=xl7214270></td>
  <td colspan=3 class=xl7114270>Fab Description :</td>
  <td colspan=12 class=xl10514270><?php echo $fab_des; ?></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td colspan=2 class=xl7114270>PO :</td>
  <td colspan=3 class=xl10614270><?php echo $pono; ?></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7114270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl7014270 style='height:15.0pt'></td>
  <td class=xl7114270>Color :</td>
  <td colspan=3 class=xl10614270><?php echo $col_des; ?></td>
  <td class=xl7214270></td>
  <td colspan=3 class=xl7114270><span style='mso-spacerun:yes'> </span>Fab
  Code:</td>
  <td colspan=12 class=xl10514270><?php echo $compo_no; ?></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td colspan=2 class=xl7114270>Assortment<span style='mso-spacerun:yes'> 
  </span>:</td>
  <td colspan=3 class=xl10514270>&nbsp;</td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7114270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
 </tr>
 <tr height=11 style='mso-height-source:userset;height:8.25pt'>
  <td height=11 class=xl7014270 style='height:8.25pt'></td>
  <td class=xl7114270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7114270></td>
  <td class=xl7114270></td>
  <td class=xl7114270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7114270></td>
  <td class=xl7114270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7114270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 style='height:15.0pt' align=left valign=top><!--[if gte vml 1]><v:shape
   id="Rounded_x0020_Rectangle_x0020_6" o:spid="_x0000_s1027" type="#_x0000_t75"
   style='position:absolute;margin-left:4.5pt;margin-top:8.25pt;width:376.5pt;
   height:129pt;z-index:3;visibility:visible;mso-wrap-style:square;
   v-text-anchor:top' o:gfxdata="UEsDBBQABgAIAAAAIQBa4xFm/gAAAOIBAAATAAAAW0NvbnRlbnRfVHlwZXNdLnhtbJSRTU/EIBCG
7yb+BzJX01I9GGNK92D1qEbXHzCBaUu2BcJg3f330v24GNfEI8y8z/sE6tV2GsVMka13Cq7LCgQ5
7Y11vYKP9VNxB4ITOoOjd6RgRwyr5vKiXu8CschpxwqGlMK9lKwHmpBLH8jlSefjhCkfYy8D6g32
JG+q6lZq7xK5VKSFAU3dUoefYxKP23x9MIk0MoiHw+LSpQBDGK3GlE3l7MyPluLYUObkfocHG/gq
a4D8tWGZnC845l7y00RrSLxiTM84ZQ1pIkvjv1ykufwbslhOXPius5rKNnKbY280n6zO0XnAQBn9
X/z7kjvB5f6Hmm8AAAD//wMAUEsDBBQABgAIAAAAIQAx3V9h0gAAAI8BAAALAAAAX3JlbHMvLnJl
bHOkkMFqwzAMhu+DvYPRvXHaQxmjTm+FXksHuwpbSUxjy1gmbd++pjBYRm876hf6PvHv9rcwqZmy
eI4G1k0LiqJl5+Ng4Ot8WH2AkoLR4cSRDNxJYN+9v+1ONGGpRzL6JKpSohgYS0mfWosdKaA0nCjW
Tc85YKljHnRCe8GB9KZttzr/ZkC3YKqjM5CPbgPqfE/V/IcdvM0s3JfGctDc996+omrH13iiuVIw
D1QMuCzPMNPc1OdAv/au/+mVERN9V/5C/Eyr9cesFzV2DwAAAP//AwBQSwMEFAAGAAgAAAAhAIKT
zR26AgAA6AcAABAAAABkcnMvc2hhcGV4bWwueG1srFVRb9owEH6ftP9g+b1NAoQE1FBtVJ0mTS2i
3Q/wYgeyOXZkexD263dnh9BO1R4KfaCO73zfd3efzze3XSPJThhba1XQ5DqmRKhS81ptCvr9+f4q
p8Q6pjiTWomCHoSlt4uPH246buZMlVttCIRQdg4bBd06186jyJZb0TB7rVuhwFpp0zAHn2YTccP2
ELyR0SiOp5FtjWDcboVwd8FCFz622+ulkPKThwhbldFNWJVaLuKbCDng0h+AxWNVLaZ5PJ4OJtzx
VqP3i6Q/guvjJjokcZ6nWTgDNn/Gxz4BOj2ADGH+RZ6lo/RE6jXybIj+Gnk8jbPRYDshH/FsSxpW
Gl1QSpzonKzVL1iHIGr31K5MT+xhtzKk5gXNKFGsgVat9W/FBSdrUUIDN1KQKY0GbzwKXz7Pl4Gs
D8nmXWWavrPsHX1tWK2AJpvrqiJdQX1bKDmAxmaTNB8lSIXNISVSgnmSTfJ8NqakRI90nE3jHD2i
QARdW2PdF6HPJkUwUEENVgdL41my3TfrEGXD++ox/pOSqpGQ/I5JMhllR0K9L1A7UsKDSt/XUp5b
MV8Uqc4NQ/YFHSdZ6nOzWtYcySFNfzPFUhoCWRXUdb4RkMsLL/iSqpdGkANeNOsOUmAIqdYCeuov
/bulAVKFto8CQZwWJ06sLIVySTBtGReBahrDX6+JIQuvEE8ImVWQ5MW49QTe5hak2eMhtKgq0NLF
wOP/FSaAD4g+c60uB97USpu3CEjoSp95wDuKJEgDVeK6z5ofkNIP+A8j6VydwNvkHuGnkhpEXcq6
pcQ4udSgXniswhMEBmfCRJHWPSGdc4H9TWzPjYKFgIFKmNzA8zqQFIqvmGFrsEgYzQUV6urrA7y0
f2D6JYPM276+x6L6YW1h1z98soZrcsccw5b42r9+Mv1eqM/iLwAAAP//AwBQSwMEFAAGAAgAAAAh
AJIjGfIdAQAAnQEAAA8AAABkcnMvZG93bnJldi54bWxMkEtvwjAQhO+V+h+srdRbcUBJ01IMipDo
41IpKVKvJtk8RGxHtguhv74LBNHjzO433vFs0auW7dC6xmgB41EADHVuikZXAtZfq4cnYM5LXcjW
aBRwQAeL+e3NTE4Ls9cp7jJfMQrRbioF1N53U85dXqOSbmQ61DQrjVXSk7QVL6zcU7hq+SQIHrmS
jaYXatnhssZ8m/0oAR9OVWsZZmiTVbZJv8Pstd0uhbi/65MXYB57f10e6PdCQAysfDtsbFOk0nm0
AqgOlaNiMKeL+zbReW0sK1N0zS/VOfulNYpZsydNQG7aE0jGZ1k69Ec7jOPoNLpYUTyOAuDHWG8G
+HmAjyn/6WgSBufgCz0EEs6vZ53E9VfnfwAAAP//AwBQSwECLQAUAAYACAAAACEAWuMRZv4AAADi
AQAAEwAAAAAAAAAAAAAAAAAAAAAAW0NvbnRlbnRfVHlwZXNdLnhtbFBLAQItABQABgAIAAAAIQAx
3V9h0gAAAI8BAAALAAAAAAAAAAAAAAAAAC8BAABfcmVscy8ucmVsc1BLAQItABQABgAIAAAAIQCC
k80dugIAAOgHAAAQAAAAAAAAAAAAAAAAACoCAABkcnMvc2hhcGV4bWwueG1sUEsBAi0AFAAGAAgA
AAAhAJIjGfIdAQAAnQEAAA8AAAAAAAAAAAAAAAAAEgUAAGRycy9kb3ducmV2LnhtbFBLBQYAAAAA
BAAEAPUAAABcBgAAAAA=
" o:insetmode="auto">
   <v:imagedata src="Book2_files/Book2_14270_image004.png" o:title=""/>
   <o:lock v:ext="edit" aspectratio="f"/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><![endif]--><![if !vml]><span style='mso-ignore:vglayout;
  position:absolute;z-index:3;margin-left:6px;margin-top:11px;width:502px;
  height:172px'><img width=502 height=172
  src="../../common/images/Book2_14270_image005.png" v:shapes="Rounded_x0020_Rectangle_x0020_6"></span><![endif]><span
  style='mso-ignore:vglayout2'>
  <table cellpadding=0 cellspacing=0>
   <tr>
    <td height=20 class=xl7014270 width=13 style='height:15.0pt;width:10pt'></td>
   </tr>
  </table>
  </span></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td align=left valign=top><!--[if gte vml 1]><v:shape id="Rounded_x0020_Rectangle_x0020_9"
   o:spid="_x0000_s1028" type="#_x0000_t75" style='position:absolute;
   margin-left:11.25pt;margin-top:9pt;width:152.25pt;height:71.25pt;z-index:4;
   visibility:visible;mso-wrap-style:square;v-text-anchor:top' o:gfxdata="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
BQYAAAAABAAEAPUAAABiBgAAAAA=
" o:insetmode="auto">
   <v:imagedata src="Book2_files/Book2_14270_image006.png" o:title=""/>
   <o:lock v:ext="edit" aspectratio="f"/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><![endif]--><![if !vml]><span style='mso-ignore:vglayout;
  position:absolute;z-index:4;margin-left:15px;margin-top:12px;width:203px;
  height:95px'><img width=203 height=95
  src="../../common/images/Book2_14270_image007.png" v:shapes="Rounded_x0020_Rectangle_x0020_9"></span><![endif]><span
  style='mso-ignore:vglayout2'>
  <table cellpadding=0 cellspacing=0>
   <tr>
    <td height=20 class=xl7014270 width=51 style='height:15.0pt;width:38pt'></td>
   </tr>
  </table>
  </span></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td align=left valign=top><!--[if gte vml 1]><v:shape id="Rounded_x0020_Rectangle_x0020_10"
   o:spid="_x0000_s1029" type="#_x0000_t75" style='position:absolute;
   margin-left:33pt;margin-top:9pt;width:153pt;height:85.5pt;z-index:5;
   visibility:visible;mso-wrap-style:square;v-text-anchor:top' o:gfxdata="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
di54bWxQSwUGAAAAAAQABAD1AAAAaQYAAAAA
" o:insetmode="auto">
   <v:imagedata src="Book2_files/Book2_14270_image008.png" o:title=""/>
   <o:lock v:ext="edit" aspectratio="f"/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><![endif]--><![if !vml]><span style='mso-ignore:vglayout;
  position:absolute;z-index:5;margin-left:44px;margin-top:12px;width:204px;
  height:114px'><img width=204 height=114
  src="../../common/images/Book2_14270_image009.png" v:shapes="Rounded_x0020_Rectangle_x0020_10"></span><![endif]><span
  style='mso-ignore:vglayout2'>
  <table cellpadding=0 cellspacing=0>
   <tr>
    <td height=20 class=xl7014270 width=48 style='height:15.0pt;width:36pt'></td>
   </tr>
  </table>
  </span></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7114270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
 </tr>
 <tr class=xl7214270 height=23 style='mso-height-source:userset;height:17.25pt'>
  <td height=23 class=xl7214270 style='height:17.25pt'></td>
  <td class=xl7214270></td>
  <td class=xl7314270>XS(1)</td>
  <td class=xl7314270 style='border-left:none'>S(2)</td>
  <td class=xl7314270 style='border-left:none'>M(3)</td>
  <td class=xl7314270 style='border-left:none'>L(4)</td>
  <td class=xl7314270 style='border-left:none'>XL(5)</td>
  <td class=xl7314270 style='border-left:none'>XXL</td>
  <td class=xl7314270 style='border-left:none'>XXXL</td>
  <td class=xl7314270 style='border-left:none'>Total</td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7214270></td>
  <td class=xl7314270><?php echo $category; ?></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td colspan=3 class=xl10314270 style='border-right:.5pt solid black'>One Gmt
  One Way</td>
  <td class=xl7414270 style='border-left:none'><?php echo $gmtway; ?></td>
  <td class=xl7514270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7114270></td>
  <td class=xl7214270></td>
  <td class=xl7214270><span style='mso-spacerun:yes'>  </span></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
 </tr>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl7014270 style='height:15.75pt'></td>
  <td class=xl7614270 width=61 style='width:46pt'>Order Qty<span
  style='mso-spacerun:yes'> </span></td>
  <td class=xl7714270 style='border-top:none'><?php echo $o_xs; ?></td>
  <td class=xl7714270 style='border-top:none;border-left:none'><?php echo $o_s; ?></td>
  <td class=xl7714270 style='border-top:none;border-left:none'><?php echo $o_m; ?></td>
  <td class=xl7714270 style='border-top:none;border-left:none'><?php echo $o_l; ?></td>
  <td class=xl7714270 style='border-top:none;border-left:none'><?php echo $o_xl; ?></td>
  <td class=xl7714270 style='border-top:none;border-left:none'><?php echo $o_xxl; ?></td>
  <td class=xl7714270 style='border-top:none;border-left:none'><?php echo $o_xxxl; ?></td>
  <td class=xl7714270 style='border-top:none;border-left:none'><?php echo $order_total; ?></td>
  <td class=xl7014270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td colspan=3 class=xl10314270 style='border-right:.5pt solid black'>Consumption</td>
  <td class=xl7414270 style='border-top:none;border-left:none'><?php echo $body_yy; ?></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7214270></td>
  <td colspan=3 class=xl10314270 style='border-right:.5pt solid black'>Strip
  Matching</td>
  <td class=xl7414270 style='border-top:none;border-left:none'><?php echo $strip_match; ?></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7114270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
 </tr>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl7014270 style='height:15.75pt'></td>
  <td class=xl7614270 width=61 style='width:46pt'>(<?php echo round(($cuttable_total/$order_total),0); ?>%)</td>
  <td class=xl7814270 style='border-top:none'><?php echo $c_xs; ?></td>
  <td class=xl7714270 style='border-top:none;border-left:none'><?php echo $c_s; ?></td>
  <td class=xl7714270 style='border-top:none;border-left:none'><?php echo $c_m; ?></td>
  <td class=xl7714270 style='border-top:none;border-left:none'><?php echo $c_l; ?></td>
  <td class=xl7714270 style='border-top:none;border-left:none'><?php echo $c_xl; ?></td>
  <td class=xl7714270 style='border-top:none;border-left:none'><?php echo $c_xxl; ?></td>
  <td class=xl7714270 style='border-top:none;border-left:none'><?php echo $c_xxxl; ?></td>
  <td class=xl7714270 style='border-top:none;border-left:none'><?php echo $cuttable_total; ?></td>
  <td class=xl7014270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td colspan=3 class=xl10314270 style='border-right:.5pt solid black'>Material
  Allowed</td>
  <td class=xl7914270 style='border-top:none;border-left:none'><?php echo round(($order_total*$body_yy),0); ?></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7214270></td>
  <td colspan=3 class=xl10314270 style='border-right:.5pt solid black'>Gusset
  Sep</td>
  <td class=xl7914270 style='border-top:none;border-left:none'><?php echo $gusset_sep; ?></td>
  <td class=xl8014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7114270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl7014270 style='height:15.0pt'></td>
  <td class=xl7614270 width=61 style='width:46pt'>Excess 1%</td>
  <td class=xl7814270 style='border-top:none'><?php echo ($c_xs-$o_xs); ?></td>
  <td class=xl7714270 style='border-top:none;border-left:none'><?php echo ($c_s-$o_s); ?></td>
  <td class=xl7714270 style='border-top:none;border-left:none'><?php echo ($c_m-$o_m); ?></td>
  <td class=xl7714270 style='border-top:none;border-left:none'><?php echo ($c_l-$o_l); ?></td>
  <td class=xl7714270 style='border-top:none;border-left:none'><?php echo ($c_xl-$o_xl); ?></td>
  <td class=xl7714270 style='border-top:none;border-left:none'><?php echo ($c_xxl-$o_xxl); ?></td>
  <td class=xl7714270 style='border-top:none;border-left:none'><?php echo ($c_xxxl-$o_xxxl); ?></td>
  <td class=xl7714270 style='border-top:none;border-left:none'><?php echo ($cuttable_total-$order_total) ?></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7214270></td>
  <td colspan=3 class=xl10314270 style='border-right:.5pt solid black'>Pattern
  Version</td>
  <td class=xl7914270 style='border-top:none;border-left:none'><?php echo $patt_ver; ?></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7114270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
 </tr>
 <tr height=12 style='mso-height-source:userset;height:9.0pt'>
  <td height=12 class=xl7014270 style='height:9.0pt'></td>
  <td class=xl7614270 width=61 style='width:46pt'></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7514270></td>
  <td class=xl7514270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7114270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl7014270 style='height:15.0pt'></td>
  <td class=xl8114270 width=61 style='width:46pt'>Floorsets</td>
  <td class=xl8214270>&nbsp;</td>
  <td class=xl8214270 style='border-left:none'>&nbsp;</td>
  <td class=xl8214270 style='border-left:none'>&nbsp;</td>
  <td class=xl8214270 style='border-left:none'>&nbsp;</td>
  <td class=xl8214270 style='border-left:none'>&nbsp;</td>
  <td class=xl8214270 style='border-left:none'>&nbsp;</td>
  <td class=xl8214270 style='border-left:none'>&nbsp;</td>
  <td class=xl8214270 style='border-left:none'>&nbsp;</td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7514270></td>
  <td class=xl7514270></td>
  <td class=xl7514270></td>
  <td class=xl7514270></td>
  <td class=xl7514270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7114270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
 </tr>
 <tr height=10 style='mso-height-source:userset;height:7.5pt'>
  <td height=10 class=xl7014270 style='height:7.5pt'></td>
  <td class=xl8114270 width=61 style='width:46pt'></td>
  <td class=xl8314270></td>
  <td class=xl8314270></td>
  <td class=xl8314270></td>
  <td class=xl8314270></td>
  <td class=xl8314270></td>
  <td class=xl8314270></td>
  <td class=xl8314270></td>
  <td class=xl8314270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7514270></td>
  <td class=xl7514270></td>
  <td class=xl7514270></td>
  <td class=xl7514270></td>
  <td class=xl7514270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7114270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl7014270 style='height:15.0pt'></td>
  <td class=xl8114270 width=61 style='width:46pt'>Catoon</td>
  <td class=xl8214270></td>
  <td class=xl8214270 style='border-left:none'></td>
  <td class=xl8214270 style='border-left:none'></td>
  <td class=xl8214270 style='border-left:none'></td>
  <td class=xl8214270 style='border-left:none'></td>
  <td class=xl8214270 style='border-left:none'></td>
  <td class=xl8214270 style='border-left:none'></td>
  <td class=xl8214270 style='border-left:none'></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7514270></td>
  <td class=xl7514270></td>
  <td class=xl7514270></td>
  <td class=xl7514270></td>
  <td class=xl7514270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7114270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl7014270 style='height:15.0pt'></td>
  <td class=xl8114270 width=61 style='width:46pt'></td>
  <td class=xl8314270></td>
  <td class=xl8314270></td>
  <td class=xl8314270></td>
  <td class=xl8314270></td>
  <td class=xl8314270></td>
  <td class=xl8314270></td>
  <td class=xl8314270></td>
  <td class=xl8314270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7514270></td>
  <td class=xl7514270></td>
  <td class=xl7514270></td>
  <td class=xl7514270></td>
  <td class=xl7514270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7114270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
 </tr>
 <tr class=xl7214270 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl7214270 style='height:15.0pt'></td>
  <td rowspan=2 class=xl10714270 style='border-bottom:.5pt solid black'>Cut No</td>
  <td colspan=7 class=xl10914270 style='border-right:.5pt solid black;
  border-left:none'>Ratio</td>
  <td rowspan=2 class=xl10714270 style='border-bottom:.5pt solid black'>Plies</td>
  <td colspan=3 class=xl10914270 style='border-right:.5pt solid black;
  border-left:none'>Verification</td>
  <td colspan=8 class=xl10914270 style='border-right:.5pt solid black;
  border-left:none'>INPUT</td>
  <td colspan=7 class=xl11214270 style='border-left:none'>Cartoon Qty</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl8514270>&nbsp;</td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
 </tr>
 <tr class=xl7214270 height=20 style='height:15.0pt'>
  <td height=20 class=xl7214270 style='height:15.0pt'></td>
  <td class=xl7414270 style='border-top:none;border-left:none'>XS</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>S</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>M</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>L</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>XL</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>XXL</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>XXXL</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>Mod#</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>Date</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>Sign</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>XS</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>S</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>M</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>L</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>XL</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>XXL</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>XXXL</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>TTL</td>
  <td class=xl8614270 style='border-top:none'>XS</td>
  <td class=xl8714270 style='border-top:none;border-left:none'>S</td>
  <td class=xl8714270 style='border-top:none;border-left:none'>M</td>
  <td class=xl8714270 style='border-top:none;border-left:none'>L</td>
  <td class=xl8814270 style='border-top:none;border-left:none'>XL</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>XXL</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>XXXL</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
 </tr>
 
 <?php  

 $a_xs_tot=0;
	$a_s_tot=0;
	$a_m_tot=0;
	$a_l_tot=0;
	$a_xl_tot=0;
	$a_xxl_tot=0;
	$a_xxxl_tot=0;
	$plies_tot=0;
	
$sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Pilot\"";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$a_xs=$sql_row['a_xs'];
	$a_s=$sql_row['a_s'];
	$a_m=$sql_row['a_m'];
	$a_l=$sql_row['a_l'];
	$a_xl=$sql_row['a_xl'];
	$a_xxl=$sql_row['a_xxl'];
	$a_xxxl=$sql_row['a_xxxl'];
	$cutno=$sql_row['acutno'];
	$plies=$sql_row['a_plies'];
	$docketno=$sql_row['doc_no'];
	$docketdate=$sql_row['date'];
	$mk_ref=$sql_row['mk_ref'];
	
	$a_xs_tot=$a_xs_tot+($a_xs*$plies);
	$a_s_tot=$a_s_tot+($a_s*$plies);
	$a_m_tot=$a_m_tot+($a_m*$plies);
	$a_l_tot=$a_l_tot+($a_l*$plies);
	$a_xl_tot=$a_xl_tot+($a_xl*$plies);
	$a_xxl_tot=$a_xxl_tot+($a_xxl*$plies);
	$a_xxxl_tot=$a_xxxl_tot+($a_xxxl*$plies);
	$plies_tot=$plies_tot+$plies;
	
	echo "<tr class=xl7214270 height=20 style='height:15.0pt'>";
  echo "<td height=20 class=xl7214270 style='height:15.0pt'></td>";
  echo "<td class=xl9214270 style='border-top:none'>Pilot</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$a_xs."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$a_s."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$a_m."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$a_l."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$a_xl."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$a_xxl."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$a_xxxl."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$plies."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".($a_xs*$plies)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".($a_s*$plies)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".($a_m*$plies)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".($a_l*$plies)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".($a_xl*$plies)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".($a_xxl*$plies)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".($a_xxxl*$plies)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".(($a_xs*$plies)+($a_s*$plies)+($a_m*$plies)+($a_l*$plies)+($a_xl*$plies)+($a_xxl*$plies)+($a_xxxl*$plies))."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
 echo "</tr>";
	
 }
	$a_xs_tot=0;
	$a_s_tot=0;
	$a_m_tot=0;
	$a_l_tot=0;
	$a_xl_tot=0;
	$a_xxl_tot=0;
	$a_xxxl_tot=0;
	$plies_tot=0;
	
$sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\"";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$a_xs=$sql_row['a_xs'];
	$a_s=$sql_row['a_s'];
	$a_m=$sql_row['a_m'];
	$a_l=$sql_row['a_l'];
	$a_xl=$sql_row['a_xl'];
	$a_xxl=$sql_row['a_xxl'];
	$a_xxxl=$sql_row['a_xxxl'];
	$cutno=$sql_row['acutno'];
	$plies=$sql_row['a_plies'];
	$docketno=$sql_row['doc_no'];
	$docketdate=$sql_row['date'];
	$mk_ref=$sql_row['mk_ref'];
	
	$a_xs_tot=$a_xs_tot+($a_xs*$plies);
	$a_s_tot=$a_s_tot+($a_s*$plies);
	$a_m_tot=$a_m_tot+($a_m*$plies);
	$a_l_tot=$a_l_tot+($a_l*$plies);
	$a_xl_tot=$a_xl_tot+($a_xl*$plies);
	$a_xxl_tot=$a_xxl_tot+($a_xxl*$plies);
	$a_xxxl_tot=$a_xxxl_tot+($a_xxxl*$plies);
	$plies_tot=$plies_tot+$plies;
	
	if($cutno==1)
	{
 echo "<tr class=xl7214270 height=20 style='height:15.0pt'>";
  echo "<td height=20 class=xl7214270 style='height:15.0pt'></td>";
  echo "<td class=xl9214270 style='border-top:none'>".chr($color_code)."000"."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".($c_xs-$o_xs)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".($c_s-$o_s)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".($c_m-$o_m)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".($c_l-$o_l)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".($c_xl-$o_xl)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".($c_xxl-$o_xxl)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".($c_xxxl-$o_xxxl)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".(($c_xs-$o_xs)+($c_s-$o_s)+($c_m-$o_m)+($c_l-$o_l)+($c_xl-$o_xl)+($c_xxl-$o_xxl)+($c_xxxl-$o_xxxl))."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
 echo "</tr>";
 echo "<tr class=xl8914270 height=20 style='height:15.0pt'>";
  echo "<td height=20 class=xl7214270 style='height:15.0pt'></td>";
  echo "<td class=xl9214270 style='border-top:none'>".chr($color_code).leading_zeros($cutno, 3)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$a_xs."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$a_s."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$a_m."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$a_l."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$a_xl."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$a_xxl."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$a_xxxl."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$plies."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".(($a_xs*$plies)-($c_xs-$o_xs))."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".(($a_s*$plies)-($c_s-$o_s))."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".(($a_m*$plies)-($c_m-$o_m))."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".(($a_l*$plies)-($c_l-$o_l))."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".(($a_xl*$plies)-($c_xl-$o_xl))."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".(($a_xxl*$plies)-($c_xxl-$o_xxl))."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".(($a_xxxl*$plies)-($c_xxxl-$o_xxxl))."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".((($a_xs*$plies)-($c_xs-$o_xs))+(($a_s*$plies)-($c_s-$o_s))+(($a_m*$plies)-($c_m-$o_m))+(($a_l*$plies)-($c_l-$o_l))+(($a_xl*$plies)-($c_xl-$o_xl))+(($a_xxl*$plies)-($c_xxl-$o_xxl))+(($a_xxxl*$plies)-($c_xxxl-$o_xxxl)))."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
 echo "</tr>";
 
 }
	else
	{
	
 echo "<tr class=xl7214270 height=20 style='height:15.0pt'>";
  echo "<td height=20 class=xl7214270 style='height:15.0pt'></td>";
  echo "<td class=xl9214270 style='border-top:none'>".chr($color_code).leading_zeros($cutno, 3)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$a_xs."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$a_s."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$a_m."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$a_l."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$a_xl."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$a_xxl."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$a_xxxl."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".$plies."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".($a_xs*$plies)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".($a_s*$plies)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".($a_m*$plies)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".($a_l*$plies)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".($a_xl*$plies)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".($a_xxl*$plies)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".($a_xxxl*$plies)."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'>".(($a_xs*$plies)+($a_s*$plies)+($a_m*$plies)+($a_l*$plies)+($a_xl*$plies)+($a_xxl*$plies)+($a_xxxl*$plies))."</td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl9214270 style='border-top:none;border-left:none'></td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
  echo "<td class=xl8414270>&nbsp;</td>";
 echo "</tr>";
 
 }
 }
 ?>
  <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl7014270 style='height:15.75pt'></td>
  <td class=xl7414270 style='border-top:none'>&nbsp;</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7414270 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9714270 style='border-top:none;border-left:none'><?php echo $a_xs_tot; ?></td>
  <td class=xl9714270 style='border-top:none;border-left:none'><?php echo $a_s_tot; ?></td>
  <td class=xl9714270 style='border-top:none;border-left:none'><?php echo $a_m_tot; ?></td>
  <td class=xl9714270 style='border-top:none;border-left:none'><?php echo $a_l_tot; ?></td>
  <td class=xl9714270 style='border-top:none;border-left:none'><?php echo $a_xl_tot; ?></td>
  <td class=xl9714270 style='border-top:none;border-left:none'><?php echo $a_xxl_tot; ?></td>
  <td class=xl9714270 style='border-top:none;border-left:none'><?php echo $a_xxxl_tot; ?></td>
  <td class=xl9714270 style='border-top:none;border-left:none'><?php echo ($a_xs_tot)+($a_s_tot)+($a_m_tot)+($a_l_tot)+($a_xl_tot)+($a_xxl_tot)+($a_xxxl_tot); ?></td>
  <td class=xl9414270 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9414270 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9414270 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9414270 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9314270 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9314270 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl9514270 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl8414270>&nbsp;</td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl7014270 style='height:16.5pt'></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl9614270><?php if($o_xs>0) {echo round((abs($a_xs_tot-$o_xs)/$o_xs),2)."%";} ?></td>
  <td class=xl9614270><?php if($o_s>0) {echo round((abs($a_s_tot-$o_s)/$o_s),2)."%";} ?></td>
  <td class=xl9614270><?php if($o_m>0) {echo round((abs($a_m_tot-$o_m)/$o_m),2)."%";} ?></td>
  <td class=xl9614270><?php if($o_l>0) {echo round((abs($a_l_tot-$o_l)/$o_l),2)."%";} ?></td>
  <td class=xl9614270><?php if($o_xl>0) {echo round((abs($a_xl_tot-$o_xl)/$o_xl),2)."%";} ?></td>
  <td class=xl9614270><?php if($o_xxl>0) {echo round((abs($a_xxl_tot-$o_xxl)/$o_xxl),2)."%";} ?></td>
  <td class=xl9614270><?php if($o_xxxl>0) {echo round((abs($a_xxxl_tot-$o_xxxl)/$o_xxxl),2)."%";} ?></td>
  <td class=xl9614270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl7014270 style='height:15.75pt'></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7214270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl8414270>&nbsp;</td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl7014270 style='height:15.0pt'></td>
  <td rowspan=2 class=xl10114270 width=61 style='border-bottom:.5pt solid black;
  width:46pt'>Recon.</td>
  <td colspan=2 class=xl9014270 style='border-left:none'>Section</td>
  <td colspan=2 class=xl9014270 style='border-left:none'>Date Completed</td>
  <td colspan=2 class=xl9014270 style='border-left:none'>Fabric Recived</td>
  <td colspan=2 class=xl9014270 style='border-left:none'>Cut Qty</td>
  <td colspan=2 class=xl9014270 style='border-left:none'>Re-Cut Qty</td>
  <td colspan=2 class=xl9014270 style='border-left:none'>Act YY</td>
  <td class=xl9014270 style='border-left:none'>CAD YY</td>
  <td colspan=2 class=xl9014270 style='border-left:none'>Act Saving</td>
  <td colspan=2 class=xl9014270 style='border-left:none'>Shortage</td>
  <td colspan=2 class=xl9014270 style='border-left:none'>Deficit / Surplus</td>
  <td colspan=2 class=xl9014270 style='border-left:none'>Reconsilation</td>
  <td class=xl9014270 style='border-left:none'>Sign</td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl7014270 style='height:15.0pt'></td>
  <td colspan=2 class=xl8714270 style='border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl8714270 style='border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl8714270 style='border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl8714270 style='border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl8714270 style='border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl8714270 style='border-left:none'>&nbsp;</td>
  <td class=xl8714270 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl8714270 style='border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl8714270 style='border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl8714270 style='border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl8714270 style='border-left:none'>&nbsp;</td>
  <td class=xl9114270 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
  <td class=xl7014270></td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=13 style='width:10pt'></td>
  <td width=61 style='width:46pt'></td>
  <td width=53 style='width:40pt'></td>
  <td width=53 style='width:40pt'></td>
  <td width=53 style='width:40pt'></td>
  <td width=53 style='width:40pt'></td>
  <td width=53 style='width:40pt'></td>
  <td width=53 style='width:40pt'></td>
  <td width=53 style='width:40pt'></td>
  <td width=52 style='width:39pt'></td>
  <td width=52 style='width:39pt'></td>
  <td width=52 style='width:39pt'></td>
  <td width=51 style='width:38pt'></td>
  <td width=51 style='width:38pt'></td>
  <td width=61 style='width:46pt'></td>
  <td width=51 style='width:38pt'></td>
  <td width=51 style='width:38pt'></td>
  <td width=48 style='width:36pt'></td>
  <td width=58 style='width:44pt'></td>
  <td width=48 style='width:36pt'></td>
  <td width=59 style='width:44pt'></td>
  <td width=48 style='width:36pt'></td>
  <td width=48 style='width:36pt'></td>
  <td width=48 style='width:36pt'></td>
  <td width=48 style='width:36pt'></td>
  <td width=45 style='width:34pt'></td>
  <td width=45 style='width:34pt'></td>
  <td width=51 style='width:38pt'></td>
  <td width=20 style='width:15pt'></td>
  <td width=45 style='width:34pt'></td>
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
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
 </tr>
 <![endif]>
</table>

</div>


<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
</body>

</html>
