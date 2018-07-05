<?php include('../../../../common/config/config.php'); ?>
<?php //include("../".getFullURL($_GET['r'], "", "R").""); ?>
<?php include('../../../../common/config/functions.php'); ?>   
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>

<?php
$order_tid=$_GET['order_tid'];
$cat_ref=$_GET['cat_ref'];
$doc_id=$_GET['doc_id'];

$cut_table=array("0","T1","T1","T2","T2","T3","T3","T4","T4","T5","T5","T6","T6","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","T7","T7","T8","T8","T9","T9","T10","T10","T11","T11","T12","T12","","","","","","","","","","","","","","");
?>


<?php

$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
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

/* $sql="select * from plan_dashboard where doc_no=$doc_id";
mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
while($sql_row=mysql_fetch_array($sql_result))
{
	$plan_log_time=$sql_row['log_time'];
} */
	
$sql="select * from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and tid=$cat_ref";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
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

/* $sql="select sum(cuttable_s_xs) as \"cuttable_s_xs\", sum(cuttable_s_s) as \"cuttable_s_s\", sum(cuttable_s_m) as \"cuttable_s_m\", sum(cuttable_s_l) as \"cuttable_s_l\", sum(cuttable_s_xl) as \"cuttable_s_xl\", sum(cuttable_s_xxl) as \"cuttable_s_xxl\", sum(cuttable_s_xxxl) as \"cuttable_s_xxxl\" from cuttable_stat_log where order_tid=\"$order_tid\" and cat_id=$cat_ref";
mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_num_check=mysql_num_rows($sql_result);
while($sql_row=mysql_fetch_array($sql_result))
{
	$c_xs=$sql_row['cuttable_s_xs'];
	$c_s=$sql_row['cuttable_s_s'];
	$c_m=$sql_row['cuttable_s_m'];
	$c_l=$sql_row['cuttable_s_l'];
	$c_xl=$sql_row['cuttable_s_xl'];
	$c_xxl=$sql_row['cuttable_s_xxl'];
	$c_xxxl=$sql_row['cuttable_s_xxxl'];
	$cuttable_total=$c_xs+$c_s+$c_m+$c_l+$c_xl+$c_xxl+$c_xxxl;
} */


?>

<?php

$sql="select * from $bai_pro3.recut_v2 where order_tid=\"$order_tid\" and cat_ref=$cat_ref and doc_no=$doc_id";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$a_xs=$sql_row['a_xs'];
	$a_s=$sql_row['a_s'];
	$a_m=$sql_row['a_m'];
	$a_l=$sql_row['a_l'];
	$a_xl=$sql_row['a_xl'];
	$a_xxl=$sql_row['a_xxl'];
	$a_xxxl=$sql_row['a_xxxl'];
	
	$p_xs=$sql_row['p_xs'];
	$p_s=$sql_row['p_s'];
	$p_m=$sql_row['p_m'];
	$p_l=$sql_row['p_l'];
	$p_xl=$sql_row['p_xl'];
	$p_xxl=$sql_row['p_xxl'];
	$p_xxxl=$sql_row['p_xxxl'];
	
	$a_ratio_tot=$a_xs+$a_s+$a_m+$a_l+$a_xl+$a_xxl+$a_xxxl;
	$cutno=$sql_row['acutno'];
	$plies=$sql_row['p_plies']; //20110911
	$docketno=$sql_row['doc_no'];
	$docketdate=$sql_row['date'];
	$mk_ref=$sql_row['mk_ref'];
	$print_status=$sql_row['print_status'];
	$remarks=$sql_row['remarks'];
	$plan_module=$sql_row['plan_module'];
	$lot_ref=$sql_row['plan_lot_ref'];
}

	$sql2="select * from $bai_pro3.maker_stat_log where tid=$mk_ref";
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
        $mklength=$sql_row2['mklength'];
        $mk_remarks = $sql_row2['remarks'];
	}
//chr($color_code).leading_zeros($cutno, 3)	


//To allocate Lot Number for RM Issuing
/*
if($print_status==NULL)
{
	$req_qty=($mklength*$plies);
	//echo $req_qty;
	$temp=$req_qty;
	$lot_ref="";
	
	$sql1="select * from bai_rm_pj1.fabric_status where item=\"$compo_no\" and (rec_qty-allocated_qty)>0";
	mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
	$sql_result1=mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
	while($sql_row1=mysql_fetch_array($sql_result1))
	{
		$lot_no=$sql_row1['lot_no'];
		$location=$sql_row1['ref1'];
		$available=$sql_row1['rec_qty']-$sql_row1['allocated_qty'];
		//echo "available:".$available;
		if($available>0 and $temp>0)
		{
			if($available>=$temp and $temp>0)
			{
				$sql11="update bai_rm_pj1.sticker_report set allocated_qty=".($sql_row1['allocated_qty']+$temp)." where lot_no=\"$lot_no\"";
				//echo $sql11;
				$sql_result11=mysql_query($sql11,$link) or exit("Sql Error".mysql_error());
				$lot_ref.=$lot_no.">".$location.";";
				$temp=0;
			}
			else
			{
				$temp-=$available;
				$sql11="update bai_rm_pj1.sticker_report set allocated_qty=".($sql_row1['rec_qty'])." where lot_no=\"$lot_no\"";
				//echo $sql11;
				$sql_result11=mysql_query($sql11,$link) or exit("Sql Error".mysql_error());
				$lot_ref.=$lot_no.">".$location.";";
			}
		}
	}
}
*/
//To allocate Lot Number for RM Issuing
?>

<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<title>DOCKET PRINT</title>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 12">
<link rel=File-List href=<?= 'Book3_files/filelist.xml'?>

<!--[if !mso]>
<style>
v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
x\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]-->
<style id="Book1_15551_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl1515551
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
.xl6315551
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
.xl6415551
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
.xl6515551
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
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6615551
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
.xl6715551
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
	border-top:none;
	border-right:none;
	border-bottom:.5pt hairline windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6815551
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
.xl6915551
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
.xl7015551
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
.xl7115551
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
.xl7115551x
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
	vertical-align:top;
	border-top:0pt solid windowtext;
	border-right:0pt solid windowtext;
	border-bottom:0pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7215551
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
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7315551
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7415551
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
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7515551
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7615551
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
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7715551
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
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7815551
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7915551
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
.xl8015551
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
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8115551
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8215551
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8315551
	{padding:0px;
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
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8415551
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
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8515551
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
.xl8615551
	{padding:0px;
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
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8715551
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
.xl8815551
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
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8915551
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9015551
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9115551
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
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9215551
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
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9315551
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\@";
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9415551
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
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl9515551
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
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl9615551
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
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl9715551
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid black;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl9815551
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
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid black;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl9915551
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
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10015551
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
	text-align:left;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;
	overflow: hidden;}
.xl10115551
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"dd\/mmm";
	text-align:left;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10215551
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"Short Date";
	text-align:left;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10315551
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
	text-align:left;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
-->

body{
	zoom:95%;
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
@page narrow {size: 11in 9in}
@page rotated {size: potrait}
DIV {page: narrow}
TABLE {page: rotated}
#non-printable { display: none; }
#printable { display: block; }
#logo { display: block; }
body { zoom:95%;}
#ad{ display:none;}
#leftbar{ display:none;}
#Book2_14270{ width:95%;}
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

<script src=<?= '../../common/js/jquery-1.3.2.js' ?></script>
<script src=<?= '../../common/js/jquery-barcode-2.0.1.js' ?></script>

</head>

<body onload="printpr();">
<script language="JavaScript">
<!--

//Disable right mouse click Script
//By Maximus (maximus@nsimail.com) w/ mods by DynamicDrive
//For full source code, visit http://www.dynamicdrive.com

var message="Function Disabled!";

///////////////////////////////////
function clickIE4(){
if (event.button==2){
alert(message);
return false;
}
}

function clickNS4(e){
if (document.layers||document.getElementById&&!document.all){
if (e.which==2||e.which==3){
alert(message);
return false;
}
}
}

if (document.layers){
document.captureEvents(Event.MOUSEDOWN);
document.onmousedown=clickNS4;
}
else if (document.all&&!document.getElementById){
document.onmousedown=clickIE4;
}

document.oncontextmenu=new Function("alert(message);return false")

// --> 
</script>

<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Office Excel's Publish
as Web Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<div id="Book1_15551" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=758 style='border-collapse:
 collapse;table-layout:fixed;width:568pt'>
 <col width=24 style='mso-width-source:userset;mso-width-alt:877;width:18pt'>
 <col class=xl6315551 width=64 span=6 style='mso-width-source:userset;
 mso-width-alt:2340;width:48pt'>
 <col class=xl6315551 width=67 style='mso-width-source:userset;mso-width-alt:
 2450;width:50pt'>
 <col class=xl6315551 width=64 span=4 style='mso-width-source:userset;
 mso-width-alt:2340;width:48pt'>
 <col class=xl6315551 width=27 style='mso-width-source:userset;mso-width-alt:
 987;width:20pt'>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1515551 width=24 style='height:15.75pt;width:18pt' colspan=8><?php echo '<div id="bcTarget1" style="width:auto;"></div><script>$("#bcTarget1").barcode("R'.$doc_id.'", "code39",{barWidth:2,barHeight:15,moduleSize:5,fontSize:0});</script>'; ?></td>
  <!-- <td class=xl6315551 width=64 style='width:48pt'></td>
  <td class=xl6315551 width=64 style='width:48pt'></td>
  <td class=xl6315551 width=64 style='width:48pt'></td>
  <td class=xl6315551 width=64 style='width:48pt'></td>
  <td class=xl6315551 width=64 style='width:48pt'></td>
  <td class=xl6315551 width=64 style='width:48pt'></td>
  <td class=xl6315551 width=67 style='width:50pt'></td> -->
  <td class=xl6315551 width=64 style='width:48pt'></td>
  <td class=xl6315551 width=64 style='width:48pt'></td>
  <td class=xl6315551 width=64 style='width:48pt'><?php if($print_status!=NULL) {echo "COPY"; } else {echo "COPY";}?></td>
  <td class=xl6315551 width=64 style='width:48pt'></td>
  <td class=xl6315551 width=27 style='width:20pt'></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td align=left valign=top><!--The following information was generated by Microsoft Office Excel's Publish
as Web Page wizard.--><!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.--><!-----------------------------><!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD --><!-----------------------------><!--[if gte vml 1]><v:shapetype
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
  </v:shapetype><v:shape id="Text_x0020_Box_x0020_13" o:spid="_x0000_s1038"
   type="#_x0000_t75" style='position:absolute;margin-left:44.25pt;
   margin-top:2.25pt;width:209.25pt;height:41.25pt;z-index:5;visibility:visible'
   o:gfxdata="UEsDBBQABgAIAAAAIQBamK3CDAEAABgCAAATAAAAW0NvbnRlbnRfVHlwZXNdLnhtbJSRwU7DMAyG
70i8Q5QralM4IITW7kDhCBMaDxAlbhvROFGcle3tSdZNgokh7Rjb3+8vyWK5tSObIJBxWPPbsuIM
UDltsK/5x/qleOCMokQtR4dQ8x0QXzbXV4v1zgOxRCPVfIjRPwpBagArqXQeMHU6F6yM6Rh64aX6
lD2Iu6q6F8phBIxFzBm8WbTQyc0Y2fM2lWcTjz1nT/NcXlVzYzOf6+JPIsBIJ4j0fjRKxnQ3MaE+
8SoOTmUi9zM0GE83SfzMhtz57fRzwYF7S48ZjAa2kiG+SpvMhQ4kvFFxEyBNlf/nZFFLhes6o6Bs
A61m8ih2boF2XxhgujS9Tdg7TMd0sf/X5hsAAP//AwBQSwMEFAAGAAgAAAAhAAjDGKTUAAAAkwEA
AAsAAABfcmVscy8ucmVsc6SQwWrDMAyG74O+g9F9cdrDGKNOb4NeSwu7GltJzGLLSG7avv1M2WAZ
ve2oX+j7xL/dXeOkZmQJlAysmxYUJkc+pMHA6fj+/ApKik3eTpTQwA0Fdt3qaXvAyZZ6JGPIoiol
iYGxlPymtbgRo5WGMqa66YmjLXXkQWfrPu2AetO2L5p/M6BbMNXeG+C934A63nI1/2HH4JiE+tI4
ipr6PrhHVO3pkg44V4rlAYsBz3IPGeemPgf6sXf9T28OrpwZP6phof7Oq/nHrhdVdl8AAAD//wMA
UEsDBBQABgAIAAAAIQD7P7r5HwIAAJMFAAASAAAAZHJzL3BpY3R1cmV4bWwueG1srFTLbtswELwX
6D8QvDd6OLIdwVLgxkhRIG2NIv2ANUVZRCVSIBlb+fsuSUmGb0XdG8XdnRnuzmrzOHQtOXFthJIF
Te5iSrhkqhLyWNBfr8+f1pQYC7KCVkle0Hdu6GP58cNmqHQOkjVKE4SQJseLgjbW9nkUGdbwDsyd
6rnEaK10BxY/9TGqNJwRvGujNI6Xkek1h8o0nNtdiNDSY9uzeuJtuw0UvBJ2awqKGtztmFNr1YVs
ptoy2UROlDt6BDz8qOsyWyVZHM8xd+XDWp2nEnec7lw8XWerLFRgyFd46AufVTNHuZyx5ztXkiyT
h3REGaVMHOViBr/iTVbJfTZKvSKe6HrBQoE87QXb65Hw+2mviahwfnH6QImEDif1ygdLPquBJAsa
XRJDGeQI9aLYbzNOD/5hdh0IiWzqqQF55FuNkhs3TNThGMM0UFug9J9Xug+t6J9Fi+OC3J1vlhKM
+Fc2VHUtGN8p9tZxaYMXNW/B4h6YRvSGEp3z7sCxq/pr5R8EudHsJ2f2VqHYHMSymlvW3IrloGps
otPlmj4DjwO4NNkth+nRKYfzN1WhQ+DNKtwkyIdad/9DBzaVDAUNG0fJe0H9JjkzQO7syDCaLhfr
+zSjhGE8SxfrVebdEmS4zF4b+4WrmyURB4Tjw874Z8LpxYw9migcnVTOhLe+fzK86/DY+nlbWSvQ
ZDuwMGVd/d3G9PA3Lf8AAAD//wMAUEsDBBQABgAIAAAAIQCqJg6+vAAAACEBAAAdAAAAZHJzL19y
ZWxzL3BpY3R1cmV4bWwueG1sLnJlbHOEj0FqwzAQRfeF3EHMPpadRSjFsjeh4G1IDjBIY1nEGglJ
LfXtI8gmgUCX8z//PaYf//wqfillF1hB17QgiHUwjq2C6+V7/wkiF2SDa2BSsFGGcdh99GdasdRR
XlzMolI4K1hKiV9SZr2Qx9yESFybOSSPpZ7Jyoj6hpbkoW2PMj0zYHhhiskoSJPpQFy2WM3/s8M8
O02noH88cXmjkM5XdwVislQUeDIOH2HXRLYgh16+PDbcAQAA//8DAFBLAwQUAAYACAAAACEAIiPO
bxYBAACLAQAADwAAAGRycy9kb3ducmV2LnhtbFxQy27CMBC8V+o/WFupt+IkbUKgGIT6kBCHStBe
enOTDQnEdmS7kPbruwkgpJ52Z3ZnPN7JrFU126N1ldECwkEADHVm8kpvBHy8v96lwJyXOpe10Sjg
Bx3MptdXEznOzUGvcL/2G0Ym2o2lgNL7Zsy5y0pU0g1Mg5pmhbFKeoJ2w3MrD2Suah4FQcKVrDS9
UMoGn0rMdutvJaAJ0k++LF5S9ZXsnrfRPMHtYinE7U07fwTmsfWX5ZN6kVP8IBpB9xtqYUoR23qu
s9JYVqzQVb+U/8gX1ihmzaHDLDN1Xwm/FYVDLyBK42HcT85MnIQjonjn6s1Re3/SJtDh82Y4DB9i
OiPZ/qNIzC+ZenC54fQPAAD//wMAUEsDBAoAAAAAAAAAIQByAzI7Bg4AAAYOAAAUAAAAZHJzL21l
ZGlhL2ltYWdlMS5wbmeJUE5HDQoaCgAAAA1JSERSAAABsQAAAFYIBgAAAEHmqD8AAAABc1JHQgCu
zhzpAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAA
F3CculE8AAAACXBIWXMAABcRAAAXEQHKJvM/AAANb0lEQVR4Xu2dMY4UOxCGuSD34BAEHIATcADI
ISZEJASEkCAhAoREQIBEOG//3WfWU+PuKnuqh/bO19Jqd6e7y+XPNfWP3bbn0SMOCEAAAhCAwDUR
OHBAAAIQgAAE/jGBYd39x35TPAQgAAEIQOCAiBEEEIAABCAwLQFEbNqmw3EIQAACEEDEiAEIQAAC
EJiWACI2bdPhOAQgAAEIIGLEAAQgAAEITEsAEZu26XAcAhCAAAQQMWIAAhCAAASmJYCITdt0OA4B
CEAAAogYMQABCEAAAtMSQMSmbTochwAEIACBbUXs16/D4ePHw+HVq8PhyRNojxCA4Qg17jmTwK+b
uPt48959dfPeffLA37vXVNczw2KXt28rYo8eHW42trr/2SWCnTvlMPz9+/fh3bt3h2fPnt3+1v97
P378+KH9zm5/9DfH/giU9im/MzzcwuYl/FKMPn/+/DZe9ZuYzaCeZwMRy2O5jSVHxIqAScSKkG3j
SJ7V169f/xUx/c2xPwJbCM4WNjPIeX4VASvX6X+O/RBAxPbTFm1PHBEr4lX/3nuVHj9+/FfE9DfH
/gh4iX3E4y1sjvhh7/H8suf1P8d+CCBi+2mLIRGbrSf2+fPnvwJWkoNe49gXAS+xj3i7hc0RP3pF
jJ5YBuXtbCBi27HNsfzAnom9ePHiRMT0Gse+CGwhOFvYzKDm+cUzsQzK29lAxLZjm2P5gU2OaQ3N
MDyTEyqZVrzEPlLWFjZH/OjtiWWUgY3tCCBi27HNsfyAROz9+/cnvbCS2HSOYz8EthCcLWxmENur
Xxl1uwYblxWxr18PBw0d6WF+Sc5Pn96tI/OmWreSuezp3tqe1rTYGW+yrdc0q8jaKeXL1tpR36e1
W/qRTd1fn1MZWhsXPTw7KyLWmtSh1+zx4cOH25mL9c/3799PrtNr9jrdm3U8vWFVEob+tv9HyrEJ
R0M9WstUTxbRuiYNUWqd03qT3k3zLz/n2FI5ul+zLe0zFNlXXeXnVyfOWglV97TquDazUx8KrB9R
LqrLFonds1mf19ot/aiOdZzoGtXLa9u63T07a371jhxkxEDkfcA19wQuK2I2Idv/156N2Gvfvj0V
pHKNztWHhM0rW+fXps7W90u4auFs2dY13rFWhyV/K5tREdMtb968ORKoly9fHq0p0/oyvVbb1D1Z
R702TIlBSdb2zCLrb5aSytLrStxLwpFpS5xUVsTm2hRte//bmxhZsqlz9lByrwV9jcsab09wRuLC
s1mfl3B59dA13rHGLyJQkWuOU835MeDVifPHBPYlYkrcS4EZESFd05qyLXGM3r8kZNH7rdgtRZx6
kCM2B0VMn0at6NVJUH/b87on66jXhikx6JD9OklE1oxFRKJ1TUvIMm2pPq1JK0tlLAlZ1KfW0gT1
1qL3l+uiAp8RBz0iFq3HmpCN8CixWerbK2IZMZDB+pps7E/ElOBaPbJowm98Or35yN8nGK0hn2j5
9rrWkNZID6zYHRQx3fbly5cTofr06dNBP1bAdG3mUX+qrmcj1m/6yJqxaHKz17W2Tsq0JVZrz/yy
hdX2wnrLLv4sMfcEZyQ2PJuj7dEaWhzpgZXy67r1ilhvO3jDyyOcr+2ey4qYknf96b7sC9ga7rNC
sjRk5z3LUovqmZh6WK31SHrNPtdSL8ketnz1+Gx9WmJpe3aq85Kt+rmg/m711hoRagVoLYhbPa61
HlrGG8KuDavXhSkB1YnCWzNmk4o+bdc9xrIPnn2Oovtsssu0dRdmd9sTteqg16xP8v00zI6f08lH
3eclOzv0pl6tvUf+Kcm2rvX8yIiDXhGTn4rXun1bImF7tbaHr3KLrXoItTwD9fxS3SPXZMVAButr
snFZEVsj6wmJTfyB8fCuhqztt4YUbflLE1FsL8sOb1qh0/m1SS223DNFrPXsqxYx+6ysi+HCxV5v
a6mX1jIXTSa614qGXY+WaSvKqS6zNaRofYo897GJ3fsgYJ9PtsroYTNSdzts1xKKpWd2tpdle5OW
h86f+/wvk4cXA1GeXHdHYD8iph5RnbDtztk2mY/s8lB21G/NUvTEwjtfIqrV06qjzZbtzWQMlNvT
E5Mr3759Oxk+LDZ0Lvuo37St51722cVa+T3JxPYAbbLOtFX7XHZ/b81S9Mq05z1BUrmRcryhOsvc
83MkRjyb3vn7t9jxs1QriJaHN5MxUm7kmqwYGGF7zffsR8TuJHV51/tAMl9sSPWOvNmEnn3vfF14
Zj0C5faKmFy121VttXlwZAaihr3qJLG2Zqw3maxdn2lLTNVD8GbUeWV651sx7glU5PxMIvb/p++j
mDl++x0PyXoJPsI8ck1WDHj+cv6YwMMXsYRZgLfIAmLyF+3ORezPnz8n0+klYhpK1LnMo/Vsykuq
a0No0WRS6nApEcuYCecl56V28Xh65yPDmhkx4bWddz4qVD12oswjNrNiIIP1Ndl42CKmobrRWYWn
H03j3422cxFr9cK2+CoX++zFS6b1+aVnGJFkculkZyen9NQzowfUyySS4P6FzZ4yL/XhJPJhSNdk
xkCkfbjmnsB+RMwKjp1c0dMTKvWzk0X0v8ppTaTw7HvnjzPnsuDZmZjes71AuT3Dia1p9ltNr7dr
w3qS+9KasZ5EZ5+J2Wn2WbZsb1P/K6m1hNgr0zvfSl62fO8ZUCQBjvjh2fVseuejH07sonPvuWKk
XO+azBjwOHL+mMB+RMwmd7veK5DMTxo3eo83GeNuzCGnJ2YXXntf/R4oNypimpnYmk7fmnaf8Q3R
vc+H6kSRsX7Jm9LuJaY6ntZsRe20pn5n9MTsMJY3Gy+SBKN1itiK9mZ6yly71i44bq0RjApitu+R
GOhhyrWXnp1o11WpR6Qp5611Yna3iEAyd0XMlq8bWuvEVNZpdskRsdYQpyadiINdJ9ZaFN2I2qiI
LYnVkrid8waxvaDIbhw2Gbc+QdvkZdcRlXVirS2grL0sW56duzA7XSem+zJEzE6MkV0JWWutmPjI
F7FubVsVTdojseGJlHc+KjytoT3x0IQhu06stSi6VTfPt8wYGGF7zfdcticWfT7V+sr6ERGzw4nR
8nXdOSLq+Rrdy7Hl76CIebtyLO3mMfrmsJ+GI/si2mTc+p6xniHJ+trI5IWobWtrZPJKKctu7eUl
y6X26NnuqC5jaWsx64c3JBeJE69u3vmoiOm66D6WrTYfEbHMGIiw5Jp7AvsTsejehZFWPGdih12/
5QnT8TtsvdemHlfvlP9S/oCItfZN1OQOe7QmfIzun1gnB284p/bDJh+vpxIRHn0Kb9Ujcq+9pmXr
nIf63i4ikTAv14wk0qU9HO1QcGTRteerJ1Le+R4R04em0eHsERHLjAGPI+ePCVxOxCK9j1YP7H58
Iz6cV9cxMsVePTbrn90RJFPE5J+ELMIkUK43nNjawb41lb419X5kJ3u7NiwylFiazE4GsWvGeoVH
STra2/Bsr9mKTK+WEFiRPmcBdiuZ9UymUZJfmgTSqs+538DtiZR3vkfE7t5iP4Z6ZCMipnuyYgCR
6iNwGREre8TpuY/dsUL/S7y8HdMDyXyx6uV7x2rRUE9IkyxKj0vl177ZTYh7yu+5tjCx34mm8u0u
Jq1ndTeVXhOx1neJ/fz5cxGVzp37nWK2RxAZSiwOeVsi2UTX+t6s0e/uOseW/C/f+1ULlYSi/m4z
CWq9o8Q5W2EtNaLKKHVp9agi37Um22t+9qWZu6s9kfLO94pYub7Fony3mn12Kx9GRSwrBkbYXvM9
24rYNZOl7psQ6El0ngOZtryyOA8BCGxDABHbhitWNyKQKTyZtjaqLmYhAAGHACJGiExFIFN4Mm1N
BRFnIfCACCBiD6gxr6EqmcKTaesa2FNHCOyRACK2x1bBp0UCmcKTaYsmgwAE/g0BROzfcKfUQQKZ
wpNpa7A63AYBCJxJABE7EyC3X5ZApvBk2rosBUqDAAQKAUSMWIAABCAAgWkJIGLTNh2OQwACEIAA
IkYMQAACEIDAtAQQsWmbDschAAEIQAARIwYgAAEIQGBaAojYtE2H4xCAAAQggIgRAxCAAAQgMC0B
RGzapsNxCEAAAhBAxIgBCEAAAhCYlgAiNm3T4TgEIAABCCBixAAEIAABCExLABGbtulwHAIQgAAE
EDFiAAIQgAAEpiWAiE3bdDgOAQhAAAKIGDEAAQhAAALTEkDEpm06HIcABCAAAUSMGIAABCAAgWkJ
IGLTNh2OQwACEIAAIkYMQAACEIDAtAQQsWmbDschAAEIQAARIwYgAAEIQGBaAojYtE2H4xCAAAQg
gIgRAxCAAAQgMC0BRGzapsNxCEAAAhBAxIgBCEAAAhCYlgAiNm3T4TgEIAABCCBixAAEIAABCExL
ABGbtulwHAIQgAAEEDFiAAIQgAAEpiWAiE3bdDgOAQhAAAKIGDEAAQhAAALTEkDEpm06HIcABCAA
AUSMGIAABCAAgWkJIGLTNh2OQwACEIAAIkYMQAACEIDAtAQQsWmbDschAAEIQAARIwYgAAEIQGBa
AojYtE2H4xCAAAQggIgRAxCAAAQgMC0BRGzapsNxCEAAAhAYFjFuhAAEIAABCOyBwH9RGgWiZxMi
PgAAAABJRU5ErkJgglBLAQItABQABgAIAAAAIQBamK3CDAEAABgCAAATAAAAAAAAAAAAAAAAAAAA
AABbQ29udGVudF9UeXBlc10ueG1sUEsBAi0AFAAGAAgAAAAhAAjDGKTUAAAAkwEAAAsAAAAAAAAA
AAAAAAAAPQEAAF9yZWxzLy5yZWxzUEsBAi0AFAAGAAgAAAAhAPs/uvkfAgAAkwUAABIAAAAAAAAA
AAAAAAAAOgIAAGRycy9waWN0dXJleG1sLnhtbFBLAQItABQABgAIAAAAIQCqJg6+vAAAACEBAAAd
AAAAAAAAAAAAAAAAAIkEAABkcnMvX3JlbHMvcGljdHVyZXhtbC54bWwucmVsc1BLAQItABQABgAI
AAAAIQAiI85vFgEAAIsBAAAPAAAAAAAAAAAAAAAAAIAFAABkcnMvZG93bnJldi54bWxQSwECLQAK
AAAAAAAAACEAcgMyOwYOAAAGDgAAFAAAAAAAAAAAAAAAAADDBgAAZHJzL21lZGlhL2ltYWdlMS5w
bmdQSwUGAAAAAAYABgCEAQAA+xQAAAAA
">
   <v:imagedata src="Book3_files/Book1_15551_image001.png" o:title=""/>
   <o:lock v:ext="edit" aspectratio="f"/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><v:shape id="Picture_x0020_14" o:spid="_x0000_s1039" type="#_x0000_t75"
   alt="LOGO" style='position:absolute;margin-left:8.25pt;margin-top:.75pt;
   width:38.25pt;height:51pt;z-index:6;visibility:visible' o:gfxdata="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
SkZJRgABAQEAYABgAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4n
ICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIy
MjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCABCADMDASIAAhEBAxEB
/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQID
AAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RF
RkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKz
tLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEB
AQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdh
cRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldY
WVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPE
xcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD3+iiigDnvF3iF
tA0xGgVGup22RB+i4GSxHfHH4kV5Vd6pqF/KZLu+uJnJz80hwPoBwPwArtfidG2dLm/gHmofYnaR
/I/lXn9efiJPnt0Psslw9KOGjUS9531+djp/DfjG+0y8ihvbl57BmCv5zbmjB/iDHnA9OmOletV8
/bWf5FUszcBR1JPQV73aRPDZwRSvvkSNVZv7xAwTW2Gk2mmedn+Hp05QqQVm73+VtSaiiiuo+eCq
N7rGm6cwS8vreByMhXkAOPp1rL8Z61LouhF7c7bi4cQxv/cyCS35A/iRXkBJZmdmLMxyzE5JPqT3
rnq1+R2R7WW5T9ah7ScrR/M7Lx34hsdWNraWEnnLCxkeUfdyRgAevf8AT3xiaJ4a1LXizWkarChw
00pITPoMZJP0FZFe0eEzCfCmmeRjb5Chsf3/AOP/AMezWEF7abcj2MXU/szCxhRV9bXf3mX4e8C2
2kXSXt1P9quU5QbdqIfUDqT7/pXW0UV2xgoqyPlK+Iq4ifPVd2FFFFUYHK+P9NlvvDwmhBZ7STzm
UdSmCG/LOfwNeUZr6BrnL/wPod/OZvIe3djlvs77Qfw6fkK5q1BzfNE97K82hhqfsqq06NHkOcd6
09I8Q6nogcWNwFjc5aNxuQn1x2P0r1Ow8JaHp3MVhHI5GC8/7w/+PdPwrm/H3h20g09NTsrVIXjc
LMIl2qUPAJA7g4GffnpWLoTguZM9KGb4bFVFQlDR97fkcpeeKdcvmzLqUyD+7C3lgf8AfOP1rT8P
+N7/AE+7jj1G4a5smOHMpy8Y/vBupA7g1ytKsbyssUal5HIVVH8RPAH51kqk073PSqYLDzp+zcEl
6H0BRUNrCbezghZy7RxqhY/xEDGaK9Q/PnvoTUUUUCIrm4jtLWa5mbbFChkc4zhQMmvObz4jTXEz
xpplu9iwKtFOSWdT6kcDPpg/jXoGp2S6lpd1ZM20TxMm7GdpI4P4GvIpvCevQXf2Y6bNI5OA8eCh
993QD64rmryqK3Ke5k9HCVFJ12rra7tobtr4LsvEFquo6RfPbQSMQbeaPeYiDyuQw/DPbHNdHoPg
ix0adbqWVru6T7jsu1U9wvPPuSau+FNGl0PQ0tZ2BnZ2kk2nIBPYfQAfjmturp0opKTWphjMxryl
KlCo3C7S8167v9QooorY8oKKKKACiiigAooooAKKKKAP/9lQSwECLQAUAAYACAAAACEA9L5jXQ4B
AAAaAgAAEwAAAAAAAAAAAAAAAAAAAAAAW0NvbnRlbnRfVHlwZXNdLnhtbFBLAQItABQABgAIAAAA
IQAIwxik1AAAAJMBAAALAAAAAAAAAAAAAAAAAD8BAABfcmVscy8ucmVsc1BLAQItABQABgAIAAAA
IQBTW4C1SgIAACwGAAASAAAAAAAAAAAAAAAAADwCAABkcnMvcGljdHVyZXhtbC54bWxQSwECLQAU
AAYACAAAACEAWGCzG7oAAAAiAQAAHQAAAAAAAAAAAAAAAAC2BAAAZHJzL19yZWxzL3BpY3R1cmV4
bWwueG1sLnJlbHNQSwECLQAUAAYACAAAACEA0Hi7Hw8BAACGAQAADwAAAAAAAAAAAAAAAACrBQAA
ZHJzL2Rvd25yZXYueG1sUEsBAi0ACgAAAAAAAAAhADhzEd/zBQAA8wUAABUAAAAAAAAAAAAAAAAA
5wYAAGRycy9tZWRpYS9pbWFnZTEuanBlZ1BLBQYAAAAABgAGAIUBAAANDQAAAAA=
">
   <v:imagedata src="Book3_files/Book1_15551_image002.png" o:title=""/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><![endif]-->
  <![if !vml]><span style='mso-ignore:vglayout;
  position:absolute;z-index:5;margin-left:11px;margin-top:1px;width:327px;
  height:68px'><img width=327 height=68
  src=<?= '../../common/images/Book1_15551_image003.gif'?> alt=LOGO v:shapes="Text_x0020_Box_x0020_13 Picture_x0020_14"></span><![endif]><span
  style='mso-ignore:vglayout2'>
  <table cellpadding=0 cellspacing=0>
   <tr>
    <td height=20 class=xl6315551 width=64 style='height:15.0pt;width:48pt'></td>
   </tr>
  </table>
  </span></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td align=left valign=top><!--[if gte vml 1]><v:shape id="Text_x0020_Box_x0020_15"
   o:spid="_x0000_s1040" type="#_x0000_t75" style='position:absolute;
   margin-left:88.5pt;margin-top:9pt;width:106.5pt;height:17.25pt;z-index:7;
   visibility:visible' o:gfxdata="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
">
   <v:imagedata src="Book3_files/Book1_15551_image004.png" o:title=""/>
   <o:lock v:ext="edit" aspectratio="f"/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><v:shape id="AutoShape_x0020_17" o:spid="_x0000_s1041" type="#_x0000_t75"
   style='position:absolute;margin-left:93pt;margin-top:26.25pt;width:98.25pt;
   height:29.25pt;z-index:8;visibility:visible;mso-wrap-style:square;
   v-text-anchor:top' o:gfxdata="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
" o:insetmode="auto">
   <v:imagedata src="Book3_files/Book1_15551_image005.png" o:title=""/>
   <o:lock v:ext="edit" aspectratio="f"/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><v:shape id="Rectangle_x0020_18" o:spid="_x0000_s1042" type="#_x0000_t75"
   style='position:absolute;margin-left:30.75pt;margin-top:30pt;width:66pt;
   height:18.75pt;z-index:9;visibility:visible' o:gfxdata="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
">
   <v:imagedata src="Book3_files/Book1_15551_image006.png" o:title=""/>
   <o:lock v:ext="edit" aspectratio="f"/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><![endif]--><![if !vml]><span style='mso-ignore:vglayout;
  position:absolute;z-index:7;margin-left:41px;margin-top:12px;width:219px;
  height:62px'><img width=219 height=62
  src=<?='../../common/images/Book1_15551_image007.gif'?> v:shapes="Text_x0020_Box_x0020_15 AutoShape_x0020_17 Rectangle_x0020_18"></span><![endif]><span
  style='mso-ignore:vglayout2'>
  <table cellpadding=0 cellspacing=0>
   <tr>
    <td height=20 class=xl6315551 width=64 style='height:15.0pt;width:48pt'></td>
   </tr>
  </table>
  </span></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=26 style='mso-height-source:userset;height:19.5pt'>
  <td height=26 class=xl6315551 style='height:19.5pt'></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td colspan=6 class=xl9215551><?php if($_GET['type']==1){ echo "Sample"; } else { echo "Recut"; } ?> Docket</td>
  <td class=xl6515551></td>
  <td colspan=2 class=xl9315551><?php echo leading_zeros($docketno,9); ?></td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=23 style='mso-height-source:userset;height:17.25pt'>
  <td height=23 class=xl6315551 style='height:17.25pt'></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 style='height:15.0pt' align=left valign=top><!--[if gte vml 1]><v:shape
   id="AutoShape_x0020_4" o:spid="_x0000_s1034" type="#_x0000_t75" style='position:absolute;
   margin-left:14.25pt;margin-top:10.5pt;width:264pt;height:93pt;z-index:1;
   visibility:visible;mso-wrap-style:square;v-text-anchor:top' o:gfxdata="UEsDBBQABgAIAAAAIQBa4xFm/gAAAOIBAAATAAAAW0NvbnRlbnRfVHlwZXNdLnhtbJSRTU/EIBCG
7yb+BzJX01I9GGNK92D1qEbXHzCBaUu2BcJg3f330v24GNfEI8y8z/sE6tV2GsVMka13Cq7LCgQ5
7Y11vYKP9VNxB4ITOoOjd6RgRwyr5vKiXu8CschpxwqGlMK9lKwHmpBLH8jlSefjhCkfYy8D6g32
JG+q6lZq7xK5VKSFAU3dUoefYxKP23x9MIk0MoiHw+LSpQBDGK3GlE3l7MyPluLYUObkfocHG/gq
a4D8tWGZnC845l7y00RrSLxiTM84ZQ1pIkvjv1ykufwbslhOXPius5rKNnKbY280n6zO0XnAQBn9
X/z7kjvB5f6Hmm8AAAD//wMAUEsDBBQABgAIAAAAIQAx3V9h0gAAAI8BAAALAAAAX3JlbHMvLnJl
bHOkkMFqwzAMhu+DvYPRvXHaQxmjTm+FXksHuwpbSUxjy1gmbd++pjBYRm876hf6PvHv9rcwqZmy
eI4G1k0LiqJl5+Ng4Ot8WH2AkoLR4cSRDNxJYN+9v+1ONGGpRzL6JKpSohgYS0mfWosdKaA0nCjW
Tc85YKljHnRCe8GB9KZttzr/ZkC3YKqjM5CPbgPqfE/V/IcdvM0s3JfGctDc996+omrH13iiuVIw
D1QMuCzPMNPc1OdAv/au/+mVERN9V/5C/Eyr9cesFzV2DwAAAP//AwBQSwMEFAAGAAgAAAAhALsq
DatUAgAAEwYAABAAAABkcnMvc2hhcGV4bWwueG1srFTJbtswEL0X6D8QvCeS5SW2YClwnaYokLpG
3H7AWKQsNRQpkIyXv++QlOwmx7jwwcMZzntvFnF+f2wE2XNtaiUzOriNKeGyUKyWu4z+/vV4M6XE
WJAMhJI8oydu6H3++dP8yHQKsqiUJgghTYqOjFbWtmkUmaLiDZhb1XKJ0VLpBiwe9S5iGg4I3ogo
ieNJZFrNgZmKc/sQIjT32PagllyIhacIrlKrJliFEnk8j5wGZ/oENH6WZT6YxeP4EnMuH9bqkE9C
ijN7n08ZJdO78TnmUzz2hdCqM0mP8p44GU4HSYfSaelJ8kFyRn/LPE5GvVhUdWHu+UxLGii0yigl
lh+tqOUL2gFE7jftWnfCVvu1JjXLaEKJhAZHtXi1alNBy8mIRudbIQVS0z6p4sV0w4MPjK6BWiKX
WlYgd3yhsYDKzRLXyPGF6aw6jf70r2CD0sn28EMxlAooFYuC9Fjq5lpJDkeVJTmiEL8MlJzQHM7u
4jh2yiDFTpIC48NkOsGhUVK4G4Nxgj+vPShxV1tt7DeurlZFHFBGtXqV7JkX1pcL+ydjHcuOdUMD
9oeSshE4kD0IcpeMekHd3egiySVK9VgLcW3LfFOEvBaGHDI6cy10yowSNXPi/EHvtkuhCdaUURxD
Nwks5s013x0vxm3SV8m8baEWwcb7Qnar5RYobLU9flHs5Gi2+I9rFR6kD+906IaxG3sS/L+Atdei
uOK4ZGvQ8IwFCvziMsrlzfdVt65t15W+F/57M+j1b6SoubQPYAFL85F3r6v3hdc8/wsAAP//AwBQ
SwMEFAAGAAgAAAAhADSoLwAhAQAAnAEAAA8AAABkcnMvZG93bnJldi54bWxckEFPwzAMhe9I/IfI
SNxY2m5dx1g6TUgTOyG2InENbdJGNElJwtrx6zEbYojjs/09+3mxHHRL9sJ5ZQ2DeBQBEaa0lTI1
g+difTMD4gM3FW+tEQwOwsMyv7xY8Hlle7MV+12oCZoYP+cMmhC6OaW+bITmfmQ7YbAnrdM8oHQ1
rRzv0Vy3NImiKdVcGdzQ8E7cN6J8231oBtlGpU+rJDa14n1RvKyt7N4njF1fDas7IEEM4Tz8Q28q
BgkQ+XB4darach+EY4BxMBwGgxwvHtqVKRvriNwKrz4xzqkundXE2Z7BFEhp2yOH+lFKLwJOjcfj
FK2w9VuaRbdZCvTbNtgTHOP+I40uf+ksnvyjkzSLTzQ9X5UvUJyfmn8BAAD//wMAUEsBAi0AFAAG
AAgAAAAhAFrjEWb+AAAA4gEAABMAAAAAAAAAAAAAAAAAAAAAAFtDb250ZW50X1R5cGVzXS54bWxQ
SwECLQAUAAYACAAAACEAMd1fYdIAAACPAQAACwAAAAAAAAAAAAAAAAAvAQAAX3JlbHMvLnJlbHNQ
SwECLQAUAAYACAAAACEAuyoNq1QCAAATBgAAEAAAAAAAAAAAAAAAAAAqAgAAZHJzL3NoYXBleG1s
LnhtbFBLAQItABQABgAIAAAAIQA0qC8AIQEAAJwBAAAPAAAAAAAAAAAAAAAAAKwEAABkcnMvZG93
bnJldi54bWxQSwUGAAAAAAQABAD1AAAA+gUAAAAA
" o:insetmode="auto">
   <v:imagedata src="Book3_files/Book1_15551_image008.png" o:title=""/>
   <o:lock v:ext="edit" aspectratio="f"/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><v:shape id="AutoShape_x0020_5" o:spid="_x0000_s1035" type="#_x0000_t75"
   style='position:absolute;margin-left:283.5pt;margin-top:8.25pt;width:265.5pt;
   height:92.25pt;z-index:2;visibility:visible;mso-wrap-style:square;
   v-text-anchor:top' o:gfxdata="UEsDBBQABgAIAAAAIQBa4xFm/gAAAOIBAAATAAAAW0NvbnRlbnRfVHlwZXNdLnhtbJSRTU/EIBCG
7yb+BzJX01I9GGNK92D1qEbXHzCBaUu2BcJg3f330v24GNfEI8y8z/sE6tV2GsVMka13Cq7LCgQ5
7Y11vYKP9VNxB4ITOoOjd6RgRwyr5vKiXu8CschpxwqGlMK9lKwHmpBLH8jlSefjhCkfYy8D6g32
JG+q6lZq7xK5VKSFAU3dUoefYxKP23x9MIk0MoiHw+LSpQBDGK3GlE3l7MyPluLYUObkfocHG/gq
a4D8tWGZnC845l7y00RrSLxiTM84ZQ1pIkvjv1ykufwbslhOXPius5rKNnKbY280n6zO0XnAQBn9
X/z7kjvB5f6Hmm8AAAD//wMAUEsDBBQABgAIAAAAIQAx3V9h0gAAAI8BAAALAAAAX3JlbHMvLnJl
bHOkkMFqwzAMhu+DvYPRvXHaQxmjTm+FXksHuwpbSUxjy1gmbd++pjBYRm876hf6PvHv9rcwqZmy
eI4G1k0LiqJl5+Ng4Ot8WH2AkoLR4cSRDNxJYN+9v+1ONGGpRzL6JKpSohgYS0mfWosdKaA0nCjW
Tc85YKljHnRCe8GB9KZttzr/ZkC3YKqjM5CPbgPqfE/V/IcdvM0s3JfGctDc996+omrH13iiuVIw
D1QMuCzPMNPc1OdAv/au/+mVERN9V/5C/Eyr9cesFzV2DwAAAP//AwBQSwMEFAAGAAgAAAAhANPa
VSRVAgAAFQYAABAAAABkcnMvc2hhcGV4bWwueG1srFTJbtswEL0X6D8QvCfavFWwHLhOUxRIXSNu
P2AsUpYaihRIxsvfZ0jKTl2gl7jywcNZ3rxZyOndoRVkx7VplCxochtTwmWpWCO3Bf318+FmQomx
IBkIJXlBj9zQu9nHD9MD0znIslaaIIQ0OSoKWlvb5VFkypq3YG5VxyVaK6VbsHjU24hp2CN4K6I0
jkeR6TQHZmrO7X2w0JnHtnu14ELMfYqgqrRqg1QqMRtNI8fBiT4AhR9VNcvwGw/PNqfyZq32pxAn
nnTOniSDLI5DCNp8iMd+S2jVOQm6n9HPShcziuP4X5mT9Ax/mTrNJmnP9iL1KaHpSAulVgWlxPKD
FY18RjmAyN26W+mexHK30qRhBc0okdDirOYvVq1r6DgZ0ujsFUIgN92jKp9NPz14x+xaaCTmUosa
5JbPNRZQu2HiHrl8YTzLnqM//UnYIHWy2X9XDKkCUsWiID9Uur2WksNRVUUO2IvhOJmMh5QckVQ2
mgxS3wrIsZWkdA5ZMhjHuPWl80iGKf48+UDFQXXa2K9cXU2LOKCCavUi2RMvra8Xdo/Guixb1k8N
2G9KqlbgRHYgyDgdnAj1vtEbJRco1UMjxLU9w3lBLuS1MGRf0E+uhQ7OKNEwR84f9HazEJpgTQXF
m4Jf3+cLN98dT8at0hfJvGyhEUHG4oXsd8ttUFhre/is2NGl2eA/7lV4kt691KEbxq7tUfD/AtZd
i+KK45KtQMMTFijwyhWUy5tvy76NXd+VUy/8hTOo9a+kaLi092ABS/OWv95Xrwvv+ewVAAD//wMA
UEsDBBQABgAIAAAAIQBB+a2oJwEAAJsBAAAPAAAAZHJzL2Rvd25yZXYueG1sTJDLbsIwEEX3lfoP
1lTqpioOSQOUYhBU6kNdUEFZsDTx5NHGNrJdSPL1dXiIruw7M+d6rkeTSpZkh8YWWjHodgIgqBIt
CpUxWH293A+AWMeV4KVWyKBGC5Px9dWID4XeqwXuli4j3kTZIWeQO7cdUmqTHCW3Hb1F5XupNpI7
L01GheF7by5LGgZBj0peKP9Czrf4nGPys/yVDLLZWs+a+efHnRhsXtd1s8LvesXY7U01fQLisHKX
4RP9LhhEQNK3emMKseDWoWHg4/hwPhiM/cZVOVVJrg1JF2iLxsc51lOjJTF6z6AHJNHl4fR6nqYW
nZ8KHvr9+NA6l6IwGsQB0NbW6SPcDU90e/mPR1HkZ1vnM/4Yh3EL08tSB3H50/EfAAAA//8DAFBL
AQItABQABgAIAAAAIQBa4xFm/gAAAOIBAAATAAAAAAAAAAAAAAAAAAAAAABbQ29udGVudF9UeXBl
c10ueG1sUEsBAi0AFAAGAAgAAAAhADHdX2HSAAAAjwEAAAsAAAAAAAAAAAAAAAAALwEAAF9yZWxz
Ly5yZWxzUEsBAi0AFAAGAAgAAAAhANPaVSRVAgAAFQYAABAAAAAAAAAAAAAAAAAAKgIAAGRycy9z
aGFwZXhtbC54bWxQSwECLQAUAAYACAAAACEAQfmtqCcBAACbAQAADwAAAAAAAAAAAAAAAACtBAAA
ZHJzL2Rvd25yZXYueG1sUEsFBgAAAAAEAAQA9QAAAAEGAAAAAA==
" o:insetmode="auto">
   <v:imagedata src="Book3_files/Book1_15551_image009.png" o:title=""/>
   <o:lock v:ext="edit" aspectratio="f"/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><![endif]--><![if !vml]><span style='mso-ignore:vglayout;
  position:absolute;z-index:1;margin-left:19px;margin-top:11px;width:713px;
  height:127px'>
  <table cellpadding=0 cellspacing=0>
   <tr>
    <td width=0 height=0></td>
    <td width=352></td>
    <td width=7></td>
    <td width=354></td>
   </tr>
   <tr>
    <td height=3></td>
    <td colspan=2></td>
    <td rowspan=2 align=left valign=top><img width=354 height=123
    src=<?= '../../common/images/Book1_15551_image010.gif' ?> v:shapes="AutoShape_x0020_5"></td>
   </tr>
   <tr>
    <td height=120></td>
    <td rowspan=2 align=left valign=top><img width=352 height=124
    src=<?='../../common/images/Book1_15551_image011.gif'?> v:shapes="AutoShape_x0020_4"></td>
   </tr>
   <tr>
    <td height=4></td>
   </tr>
  </table>
  </span><![endif]><span style='mso-ignore:vglayout2'>
  <table cellpadding=0 cellspacing=0>
   <tr>
    <td height=20 class=xl6315551 width=24 style='height:15.0pt;width:18pt'></td>
   </tr>
  </table>
  </span></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6615551>Cut No :</td>
  <td colspan=2 class=xl10015551><?php echo "R".leading_zeros($cutno, 3); ?></td>
  <td class=xl6615551>Date: </td>
  <td class=xl10215551><?php echo $docketdate; ?></td>
  <td class=xl6315551></td>
  <td class=xl6615551>Category :</td>
  <td colspan=4 class=xl10015551><?php echo $category; ?></td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6615551>Style No :</td>
  <td colspan=2 class=xl10015551><?php echo $style; ?></td>
  <td class=xl6615551>Module: </td>
  <td class=xl10215551><?php echo $plan_module; echo " (".$cut_table[$plan_module].")"; ?></td>
  <td class=xl6315551></td>
  <td class=xl6615551>Fab Code :</td>
  <td colspan=4 class=xl10015551><?php echo $compo_no ?></td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6615551>Sch No :</td>
  <td colspan=2 class=xl10015551><?php echo $delivery.chr($color_code); ?></td>
  <td colspan=2 class=xl10015551 align=center><?php if($strip_match=="Y") { echo "<strong>STRIP MATCH</strong>";  } ?></td>
  <td colspan=2 class=xl6615551>Fab Descrip :</td>
  <td colspan=4 class=xl10015551><?php echo $fab_des; ?></td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6615551>Color :</td>
  <td colspan=4 class=xl10015551><?php echo $color." / ".$col_des; ?></td>
  <td colspan=2 class=xl6615551>Consumption :</td>
  <td colspan=4 class=xl10015551><?php echo $body_yy; ?></td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6615551>MK Name :</td>
  <td colspan=4 class=xl10315551><?php echo $mk_remarks; ?></td>
  <td colspan=2 class=xl6615551>Fab Direction :</td>
  <td colspan=4 class=xl10115551><?php if($gmtway=="Y") { echo "One Gmt One Way"; } else  { echo "All Gmt One Way"; }?></td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6615551>PO :</td>
  <td colspan=4 class=xl10315551><?php echo $pono; ?></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6415551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=11 style='mso-height-source:userset;height:8.25pt'>
  <td height=11 style='height:8.25pt' align=left valign=top><!--[if gte vml 1]><v:shape
   id="AutoShape_x0020_6" o:spid="_x0000_s1036" type="#_x0000_t75" style='position:absolute;
   margin-left:14.25pt;margin-top:.75pt;width:446.25pt;height:60pt;z-index:3;
   visibility:visible;mso-wrap-style:square;v-text-anchor:top' o:gfxdata="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
" o:insetmode="auto">
   <v:imagedata src="Book3_files/Book1_15551_image012.png" o:title=""/>
   <o:lock v:ext="edit" aspectratio="f"/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><v:shape id="AutoShape_x0020_8" o:spid="_x0000_s1037" type="#_x0000_t75"
   style='position:absolute;margin-left:467.25pt;margin-top:0;width:81.75pt;
   height:60.75pt;z-index:4;visibility:visible' o:gfxdata="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
ZTEucG5nUEsFBgAAAAAGAAYAhAEAAMMOAAAAAA==
">
   <v:imagedata src="Book3_files/Book1_15551_image013.png" o:title=""/>
   <o:lock v:ext="edit" aspectratio="f"/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><![endif]--><![if !vml]><span style='mso-ignore:vglayout;
  position:absolute;z-index:3;margin-left:19px;margin-top:0px;width:713px;
  height:81px'>
  <table cellpadding=0 cellspacing=0>
   <tr>
    <td width=0 height=0></td>
    <td width=595></td>
    <td width=9></td>
    <td width=109></td>
   </tr>
   <tr>
    <td height=1></td>
    <td colspan=2></td>
    <td rowspan=2 align=left valign=top><img width=109 height=81
    src=<?= '../../common/images/Book1_15551_image014.gif'?> v:shapes="AutoShape_x0020_8"></td>
   </tr>
   <tr>
    <td height=80></td>
    <td align=left valign=top><img width=595 height=80
    src=<?= '../../common/images/Book1_15551_image015.gif' ?> v:shapes="AutoShape_x0020_6"></td>
   </tr>
  </table>
  </span><![endif]><span style='mso-ignore:vglayout2'>
  <table cellpadding=0 cellspacing=0>
   <tr>
    <td height=11 class=xl6315551 width=24 style='height:8.25pt;width:18pt'></td>
   </tr>
  </table>
  </span></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6415551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6315551>Size</td>
  <td class=xl6915551>XS</td>
  <td class=xl7115551>S</td>
  <td class=xl7115551>M</td>
  <td class=xl7115551>L</td>
  <td class=xl7115551>XL</td>
  <td class=xl7115551>XXL</td>
  <td class=xl7115551>XXXL</td>
  <td class=xl7115551>Total</td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6315551>Ratio</td>
  <td class=xl7315551><?php echo $a_xs; ?></td>
  <td class=xl7515551><?php echo $a_s; ?></td>
  <td class=xl7515551><?php echo $a_m; ?></td>
  <td class=xl7515551><?php echo $a_l; ?></td>
  <td class=xl7515551><?php echo $a_xl; ?></td>
  <td class=xl7515551><?php echo $a_xxl; ?></td>
  <td class=xl7515551><?php echo $a_xxxl; ?></td>
  <td class=xl7515551><?php echo $a_ratio_tot; ?></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6315551>Quantity</td>
  <td class=xl7315551><?php echo ($a_xs*$plies); ?></td>
  <td class=xl7515551><?php echo ($a_s*$plies); ?></td>
  <td class=xl7515551><?php echo ($a_m*$plies); ?></td>
  <td class=xl7515551><?php echo ($a_l*$plies); ?></td>
  <td class=xl7515551><?php echo ($a_xl*$plies); ?></td>
  <td class=xl7515551><?php echo ($a_xxl*$plies); ?></td>
  <td class=xl7515551><?php echo ($a_xxxl*$plies); ?></td>
  <td class=xl7515551><?php echo ($a_ratio_tot*$plies); ?></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
 </tr>
 
  <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6315551 style="border:.5pt solid windowtext;">Excess </td>
  <td class=xl7315551 style="border:.5pt solid windowtext;"><?php echo ($a_xs*$plies)-$p_xs; ?></td>
  <td class=xl7515551 style="border:.5pt solid windowtext;"><?php echo ($a_s*$plies)-$p_s; ?></td>
  <td class=xl7515551 style="border:.5pt solid windowtext;"><?php echo ($a_m*$plies)-$p_m; ?></td>
  <td class=xl7515551 style="border:.5pt solid windowtext;"><?php echo ($a_l*$plies)-$p_l; ?></td>
  <td class=xl7515551 style="border:.5pt solid windowtext;"><?php echo ($a_xl*$plies)-$p_xl; ?></td>
  <td class=xl7515551 style="border:.5pt solid windowtext;"><?php echo ($a_xxl*$plies)-$p_xxl; ?></td>
  <td class=xl7515551 style="border:.5pt solid windowtext;"><?php echo ($a_xxxl*$plies)-$p_xxxl; ?></td>
  <td class=xl7515551 style="border:.5pt solid windowtext;"><?php echo ((($a_xs*$plies)-$p_xs) +(($a_s*$plies)-$p_s) +(($a_m*$plies)-$p_m) +(($a_l*$plies)-$p_l) +(($a_xl*$plies)-$p_xl) +(($a_xxl*$plies)-$p_xxl) +(($a_xxxl*$plies)-$p_xxxl)); ?></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
 </tr>
 
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6415551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6415551 style='height:15.0pt'></td>
  <td class=xl7615551>Rpt No</td>
  <td class=xl7715551>Batch No</td>
  <td rowspan=2 class=xl9415551 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Shrinkage Group</td>
  <td rowspan=2 class=xl9415551 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Color Group</td>
  <td class=xl7715551>Width</td>
  <td rowspan=2 class=xl9415551 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Marker Length</td>
  <td rowspan=2 class=xl9415551 width=67 style='border-bottom:.5pt solid black;
  width:50pt'>Pattern Version</td>
  <td rowspan=2 class=xl9415551 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>No of Plies</td>
  <td rowspan=2 class=xl9415551 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Required Qty (<?php echo $fab_uom; ?>)</td>
  <td rowspan=2 class=xl9415551 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Issued Qty (<?php echo $fab_uom; ?>)</td>
  <td rowspan=2 class=xl9415551 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Return Qty (<?php echo $fab_uom; ?>)</td>
  <td class=xl6415551></td>
 </tr>
 <tr class=xl6415551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6415551 style='height:15.0pt'></td>
  <td class=xl7215551>&nbsp;</td>
  <td class=xl7415551>&nbsp;</td>
  <td class=xl7415551>&nbsp;</td>
  <td class=xl6415551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td rowspan=2 class=xl9615551 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'>&nbsp;</td>
  <td rowspan=2 class=xl9615551 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><span style='mso-spacerun:yes'></span></td>
  <td rowspan=2 class=xl9615551 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'>&nbsp;</td>
  <td rowspan=2 class=xl9615551 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'>&nbsp;</td>
  <td rowspan=2 class=xl9615551 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php echo $purwidth; ?></td>
  <td rowspan=2 class=xl9615551 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php echo $mklength; ?></td>
  <td rowspan=2 class=xl9615551 width=67 style='border-bottom:.5pt solid black;
  border-top:none;width:50pt'><?php echo $patt_ver; ?></td>
  <td rowspan=2 class=xl9615551 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php echo $plies ?></td>
  <td rowspan=2 class=xl9615551 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php echo ($mklength*$plies); ?></td>
  <td rowspan=2 class=xl9615551 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'>&nbsp;</td>
  <td rowspan=2 class=xl9615551 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'>&nbsp;</td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
 </tr>
 
 <?php
 /*
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl7915551>Roll No</td>
  <td class=xl8015551>&nbsp;</td>
  <td class=xl8015551>&nbsp;</td>
  <td class=xl8015551>&nbsp;</td>
  <td class=xl8015551>&nbsp;</td>
  <td class=xl8015551>&nbsp;</td>
  <td class=xl8015551>&nbsp;</td>
  <td class=xl7115551x colspan=4 rowspan=5><?php echo $lot_ref; ?></td>
  <!-- <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td> -->
  <td class=xl6315551></td> 
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl7815551>Width</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
 <td class=xl8115551>&nbsp;</td>
  <!-- <td class=xl8215551></td>
  <td class=xl8315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>-->
  <td class=xl6315551></td> 
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl7815551>Length</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <!-- <td class=xl7115551></td>
  <td class=xl8315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td> -->
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl8415551>Batch No</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
 <!-- <td class=xl8515551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td> -->
  <td class=xl6315551></td>
 </tr>
 
  <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl8415551>Group</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8515551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl8415551>Loc No</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8615551>&nbsp;</td>
  <td class=xl8515551></td>
 <td class=xl8515551 colspan=4><u>Quality Approved Sign</u></td>
 </tr>
 */
 ?>
 
 
 
 <?php

echo "<tr class=xl6315551  style='mso-height-source:userset;'>";
 
echo "<td class=xl6315551 ></td><td colspan=12>";
$roll_det=array();
$width_det=array();
$leng_det=array();
$batch_det=array();
$shade_det=array();
$locan_det=array(); 
$lot_det=array();
$roll_id=array();
$sql="select * from $bai_rm_pj1.docket_ref where doc_no=$doc_id and doc_type='recut'";
//echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{

$roll_det[]=$sql_row['ref2'];
$width_det[]=(int)$sql_row['roll_width'];
$leng_det[]=$sql_row['allocated_qty'];
$batch_det[]=trim($sql_row['batch_no']);
$shade_det[]=$sql_row['ref4']."-".$sql_row['inv_no'];
$locan_det[]=$sql_row['ref1'];
$lot_det[]=$sql_row['lot_no'];
$roll_id[]=$sql_row['roll_id'];
} 
echo "<table style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'>";

echo "<tr><td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'> Roll No</td>";

for($i=0;$i<sizeof($roll_det);$i++)
{
	echo "<td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'>".$roll_det[$i]."</td>";
}
echo "</tr>";

//2012-06-12 New implementation to get fabric detail based on invoce/batch
echo "<tr><td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'> Lot No</td>";
//echo "<tr><td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>Label ID</td>";

for($i=0;$i<sizeof($roll_det);$i++)
{
	//2012-06-12 New implementation to get fabric detail based on invoce/batch
	echo "<td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'>".$lot_det[$i]."</td>";
	//echo "<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$roll_id[$i]."</td>";
}
echo "</tr>";


//2012-06-12 New implementation to get fabric detail based on invoce/batch
//echo "<tr><td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'> Lot No</td>";
echo "<tr><td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'>Label ID</td>";

for($i=0;$i<sizeof($roll_det);$i++)
{
	//2012-06-12 New implementation to get fabric detail based on invoce/batch
	//echo "<td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'>".$lot_det[$i]."</td>";
	echo "<td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'>".$roll_id[$i]."</td>";
}

echo "</tr>";



echo "<tr><td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'> Width</td>";

for($i=0;$i<sizeof($roll_det);$i++)
{
	echo "<td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'>".$width_det[$i]."</td>";
}
echo "</tr>";

echo "<tr><td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'> Length</td>";

for($i=0;$i<sizeof($roll_det);$i++)
{
	echo "<td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'>".$leng_det[$i]."</td>";
}
echo "</tr>";

echo "<tr><td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'> Batch</td>";

for($i=0;$i<sizeof($roll_det);$i++)
{
	echo "<td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'>".$batch_det[$i]."</td>";
}
echo "</tr>";

echo "<tr><td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'> Shade</td>";

for($i=0;$i<sizeof($roll_det);$i++)
{
	echo "<td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'>".$shade_det[$i]."</td>";
}
echo "</tr>";


echo "<tr><td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'> Location</td>";

for($i=0;$i<sizeof($roll_det);$i++)
{
	echo "<td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'>".$locan_det[$i]."</td>";
}
echo "</tr>";

echo "</table>";
echo $lot_ref; 

echo "</td>";
echo "</tr>";

 ?>

 
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551 colspan="3"><u><strong>Quality Authorisation</strong></u></td>
 </tr>
 <tr class=xl6415551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6415551 style='height:15.0pt'></td>
  <td class=xl7615551>Group</td>
  <td class=xl7715551>Roll No</td>
  <td rowspan=2 class=xl9415551 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Ticket Length</td>
  <td class=xl7715551>Plies</td>
  <td class=xl7715551>Damage</td>
  <td class=xl7715551>Joints</td>
  <td class=xl7715551>Ends</td>
  <td class=xl7715551>Shortages</td>
  <td rowspan=2 class=xl9415551 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Net Length</td>
  <td colspan=2 class=xl9915551 style='border-right:.5pt solid black;
  border-left:none'>Comments</td>
  <td class=xl6415551></td>
 </tr>
 <tr class=xl6415551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6415551 style='height:15.0pt'></td>
  <td class=xl7215551>&nbsp;</td>
  <td class=xl7415551>&nbsp;</td>
  <td class=xl7415551>&nbsp;</td>
  <td class=xl7415551>&nbsp;</td>
  <td class=xl7415551>&nbsp;</td>
  <td class=xl7415551>&nbsp;</td>
  <td class=xl7415551>Excess</td>
  <td class=xl8715551>&nbsp;</td>
  <td class=xl7415551>&nbsp;</td>
  <td class=xl6415551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl7815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl7815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl7815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl7815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl7815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl7815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl7815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl7815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl7815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl7815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl7815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl7815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl7815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl7815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl7815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl8915551>&nbsp;</td>
  <td class=xl9015551>&nbsp;</td>
  <td class=xl9015551>&nbsp;</td>
  <td class=xl9015551>&nbsp;</td>
  <td class=xl9015551>&nbsp;</td>
  <td class=xl9015551>&nbsp;</td>
  <td class=xl9015551>&nbsp;</td>
  <td class=xl9015551>&nbsp;</td>
  <td class=xl9015551>&nbsp;</td>
  <td class=xl9115551>&nbsp;</td>
  <td class=xl9015551>&nbsp;</td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6315551></td>
  <td class=xl6815551>Docket</td>
  <td class=xl7015551>Marker</td>
  <td class=xl7015551>Issuing</td>
  <td class=xl7015551>Laying</td>
  <td class=xl7015551>Cutting</td>
  <td class=xl7015551>Return</td>
  <td class=xl7015551>Bundling</td>
  <td class=xl7015551>Dispatch</td>
  <td class=xl6315551>Act Con</td>
  <td class=xl6715551>&nbsp;</td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6315551>Team</td>
  <td class=xl7815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl6315551>Saving %</td>
  <td class=xl6715551>&nbsp;</td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6315551>EMP No1</td>
  <td class=xl7815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl6315551>Reason</td>
  <td class=xl6715551>&nbsp;</td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6315551>Emp No2</td>
  <td class=xl7815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl6315551>Approved</td>
  <td class=xl6715551>&nbsp;</td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6315551>Emp No3</td>
  <td class=xl7815551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6315551>Date</td>
  <td class=xl7815551><?php echo date("y/m-d",strtotime($plan_log_time)); ?></td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
 </tr>
 <tr class=xl6315551 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6315551 style='height:15.0pt'></td>
  <td class=xl6315551>Time</td>
  <td class=xl7815551><?php echo date("H:i",strtotime($plan_log_time)); ?></td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl8115551>&nbsp;</td>
  <td class=xl6315551></td>
  <td class=xl6315551></td>
  <td class=xl6315551><!-----------------------------><!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD--><!-----------------------------></td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=24 style='width:18pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=67 style='width:50pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
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

<?php 

if($print_status=="0000-00-00" || $print_status == "")
{
	$sql="update $bai_pro3.recut_v2 set print_status=\"".date("Y-m-d")."\" where doc_no=$docketno";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
}
?>
