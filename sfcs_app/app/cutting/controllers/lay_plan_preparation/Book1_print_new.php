<!--
Change Log:  

1. DharaniD/ 2015-5-20/ Service Request: #355944 : add the embellishment column in M&S cut plan generation.  

-->



<?php include('../../../../common/config/config.php'); ?>
<?php //include("../".getFullURL($_GET['r'], "", "R").""); ?>
<?php include('../../../../common/config/functions.php'); ?> 
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>

<?php
$order_tid=$_GET['order_tid']; 
$cat_ref=$_GET['cat_ref'];
?>

<?php
   $sql="select * from bai_orders_db_remarks where order_tid=\"$order_tid\"";
	$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$remarks_x=$sql_row['remarks'];
		
	}
	
	// embellishment start
$sql="select order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f from bai_orders_db_confirm where order_tid=\"$order_tid\"";
	$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$emb_a=$sql_row['order_embl_a'];
		$emb_b=$sql_row['order_embl_b'];
		$emb_c=$sql_row['order_embl_c'];
		$emb_d=$sql_row['order_embl_d'];
		$emb_e=$sql_row['order_embl_e'];
		$emb_f=$sql_row['order_embl_f'];
	}
	// embellishment end
	
$sql="select * from bai_orders_db_confirm where order_tid=\"$order_tid\"";
$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
$sql_num_confirm=mysqli_num_rows($sql_result);

if($sql_num_confirm>0)
{
	$sql="select * from bai_orders_db_confirm where order_tid=\"$order_tid\"";
}
else
{
	$sql="select * from bai_orders_db where order_tid=\"$order_tid\"";
}
mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
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
	$order_amend=$sql_row['order_no'];
	
	
			$o_s06=$sql_row['order_s_s06'];
			$o_s08=$sql_row['order_s_s08'];
			$o_s10=$sql_row['order_s_s10'];
			$o_s12=$sql_row['order_s_s12'];
			$o_s14=$sql_row['order_s_s14'];
			$o_s16=$sql_row['order_s_s16'];
			$o_s18=$sql_row['order_s_s18'];
			$o_s20=$sql_row['order_s_s20'];
			$o_s22=$sql_row['order_s_s22'];
			$o_s24=$sql_row['order_s_s24'];
			$o_s26=$sql_row['order_s_s26'];
			$o_s28=$sql_row['order_s_s28'];
			$o_s30=$sql_row['order_s_s30'];
			$order_total=$o_s06+$o_s08+$o_s10+$o_s12+$o_s14+$o_s16+$o_s18+$o_s20+$o_s22+$o_s24+$o_s26+$o_s28+$o_s30;
			
			if($orderno=="1")
			{	
			$old_s06=$sql_row['old_order_s_s06'];
			$old_s08=$sql_row['old_order_s_s08'];
			$old_s10=$sql_row['old_order_s_s10'];
			$old_s12=$sql_row['old_order_s_s12'];
			$old_s14=$sql_row['old_order_s_s14'];
			$old_s16=$sql_row['old_order_s_s16'];
			$old_s18=$sql_row['old_order_s_s18'];
			$old_s20=$sql_row['old_order_s_s20'];
			$old_s22=$sql_row['old_order_s_s22'];
			$old_s24=$sql_row['old_order_s_s24'];
			$old_s26=$sql_row['old_order_s_s26'];
			$old_s28=$sql_row['old_order_s_s28'];
			$old_s30=$sql_row['old_order_s_s30'];
			$old_order_total=$old_s06+$old_s08+$old_s10+$old_s12+$old_s14+$old_s16+$old_s18+$old_s20+$old_s22+$old_s24+$old_s26+$old_s28+$old_s30;
			}
			else
			{
			$old_s06=$sql_row['old_order_s_s06'];
			$old_s08=$sql_row['old_order_s_s08'];
			$old_s10=$sql_row['old_order_s_s10'];
			$old_s12=$sql_row['old_order_s_s12'];
			$old_s14=$sql_row['old_order_s_s14'];
			$old_s16=$sql_row['old_order_s_s16'];
			$old_s18=$sql_row['old_order_s_s18'];
			$old_s20=$sql_row['old_order_s_s20'];
			$old_s22=$sql_row['old_order_s_s22'];
			$old_s24=$sql_row['old_order_s_s24'];
			$old_s26=$sql_row['old_order_s_s26'];
			$old_s28=$sql_row['old_order_s_s28'];
			$old_s30=$sql_row['old_order_s_s30'];
			$old_order_total=$old_s06+$old_s08+$old_s10+$old_s12+$old_s14+$old_s16+$old_s18+$old_s20+$old_s22+$old_s24+$old_s26+$old_s28+$old_s30;
			}
			
	$size6 = $sql_row['title_size_s06'];
	$size8 = $sql_row['title_size_s08'];
	$size10 = $sql_row['title_size_s10'];
	$size12 = $sql_row['title_size_s12'];
	$size14 = $sql_row['title_size_s14'];
	$size16 = $sql_row['title_size_s16'];
	$size18 = $sql_row['title_size_s18'];
	$size20 = $sql_row['title_size_s20'];
	$size22 = $sql_row['title_size_s22'];
	$size24 = $sql_row['title_size_s24'];
	$size26 = $sql_row['title_size_s26'];
	$size28 = $sql_row['title_size_s28'];
	$size30 = $sql_row['title_size_s30'];
	$flag = $sql_row['title_flag'];
	
	
	
	$order_date=$sql_row['order_date'];
	$order_joins=$sql_row['order_joins'];
}

$join_s08=0;
$join_s10=0;
$join_schedule="";
$join_check=0;
if($order_joins!="0")
{
	$sql="select * from bai_orders_db where order_tid=\"$order_joins\"";
	mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
	$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$join_s08=$sql_row['order_s_s08'];
		$join_s10=$sql_row['order_s_s10'];
		$join_schedule=$sql_row['order_del_no'].chr($sql_row['color_code']);
	}
	$join_check=1;
}

	
$sql="select * from cat_stat_log where order_tid=\"$order_tid\" and tid=$cat_ref";
mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$cid=$sql_row['tid'];
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

$sql="select * from cuttable_stat_log where cat_id=$cid and order_tid=\"$order_tid\"";
mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
while($sql_row=mysqli_fetch_array($sql_result))
{
	$excess=$sql_row['cuttable_percent'];
}

$sql="select sum(allocate_s06*plies) as \"cuttable_s_s06\", sum(allocate_s08*plies) as \"cuttable_s_s08\", sum(allocate_s10*plies) as \"cuttable_s_s10\", sum(allocate_s12*plies) as \"cuttable_s_s12\", sum(allocate_s14*plies) as \"cuttable_s_s14\", sum(allocate_s16*plies) as \"cuttable_s_s16\", sum(allocate_s18*plies) as \"cuttable_s_s18\", sum(allocate_s20*plies) as \"cuttable_s_s20\", sum(allocate_s22*plies) as \"cuttable_s_s22\", sum(allocate_s24*plies) as \"cuttable_s_s24\", sum(allocate_s26*plies) as \"cuttable_s_s26\", sum(allocate_s28*plies) as \"cuttable_s_s28\", sum(allocate_s30*plies) as \"cuttable_s_s30\",max(extra_plies) as extra_plies from allocate_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref";
mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$c_s06=$sql_row['cuttable_s_s06'];
	$c_s08=$sql_row['cuttable_s_s08'];
	$c_s10=$sql_row['cuttable_s_s10'];
	$c_s12=$sql_row['cuttable_s_s12'];
	$c_s14=$sql_row['cuttable_s_s14'];
	$c_s16=$sql_row['cuttable_s_s16'];
	$c_s18=$sql_row['cuttable_s_s18'];
	$c_s20=$sql_row['cuttable_s_s20'];
	$c_s22=$sql_row['cuttable_s_s22'];
	$c_s24=$sql_row['cuttable_s_s24'];
	$c_s26=$sql_row['cuttable_s_s26'];
	$c_s28=$sql_row['cuttable_s_s28'];
	$c_s30=$sql_row['cuttable_s_s30'];
	$extra_plies=$sql_row['extra_plies'];

	$cuttable_total=$c_s06+$c_s08+$c_s10+$c_s12+$c_s14+$c_s16+$c_s18+$c_s20+$c_s22+$c_s24+$c_s26+$c_s28+$c_s30;
}

/* NEW 2010-05-22 */
//OLD Version 2012 (Changed due to calculate yy based on the marker lenght allocation as per dockets.)
/*
	
	$newyy=0;
	$new_order_qty=0;
	$sql2="select * from maker_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and allocate_ref>0";
	mysqli_query($link,$sql2) or exit("Sql Error".mysql_error());
	$sql_result2=mysqli_query($link,$sql2) or exit("Sql Error".mysql_error());
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$mk_new_length=$sql_row2['mklength'];
		$new_allocate_ref=$sql_row2['allocate_ref'];
		
		$sql22="select * from allocate_stat_log where tid=$new_allocate_ref";
		mysqli_query($link,$sql22) or exit("Sql Error".mysql_error());
		$sql_result22=mysqli_query($link,$sql22) or exit("Sql Error".mysql_error());
		while($sql_row22=mysqli_fetch_array($sql_result22))
		{
			$new_plies=$sql_row22['plies'];
		}
		$newyy=$newyy+($mk_new_length*$new_plies);
	}
	*/
	
	$newyy=0;
	$new_order_qty=0;
	$sql2="select mk_ref,p_plies,cat_ref,allocate_ref from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref  and allocate_ref>0";
	mysqli_query($link,$sql2) or exit("Sql Error".mysql_error());
	$sql_result2=mysqli_query($link,$sql2) or exit("Sql Error".mysql_error());
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		
		$new_plies=$sql_row2['p_plies'];
		$mk_ref=$sql_row2['mk_ref'];
		//$sql22="select mklength from maker_stat_log where tid=$mk_ref";
		$sql22="select marker_length as mklength from marker_ref_matrix where marker_width=$purwidth and cat_ref=".$sql_row2['cat_ref']." and allocate_ref=".$sql_row2['allocate_ref'];
		//echo $sql22;
		mysqli_query($link,$sql22) or exit("Sql Error".mysql_error());
		$sql_result22=mysqli_query($link,$sql22) or exit("Sql Error".mysql_error());
		while($sql_row22=mysqli_fetch_array($sql_result22))
		{
			$mk_new_length=$sql_row22['mklength'];
		}
		$newyy=$newyy+($mk_new_length*$new_plies);
	}
	
	$sql="select * from bai_orders_db_confirm where order_tid=\"$order_tid\"";
	$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
	$sql_num_confirm=mysqli_num_rows($sql_result);
	
	if($sql_num_confirm>0)
	{
		$sql2="select (order_s_s06+order_s_s08+order_s_s10+order_s_s12+order_s_s14+order_s_s16+order_s_s18+order_s_s20+order_s_s22+order_s_s24+order_s_s26+order_s_s28+order_s_s30) as \"sum\" from bai_orders_db_confirm where order_tid=\"$order_tid\"";
	}
	else
	{
		$sql2="select (order_s_s06+order_s_s08+order_s_s10+order_s_s12+order_s_s14+order_s_s16+order_s_s18+order_s_s20+order_s_s22+order_s_s24+order_s_s26+order_s_s28+order_s_s30) as \"sum\" from bai_orders_db where order_tid=\"$order_tid\"";
	}
	mysqli_query($link,$sql2) or exit("Sql Error".mysql_error());
	$sql_result2=mysqli_query($link,$sql2) or exit("Sql Error".mysql_error());
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$new_order_qty=$sql_row2['sum'];
		//$order_no=$sql_row2['order_no'];
	}
	
	//$newyy2=$newyy/$new_order_qty;
    //if added 1% to order_qty
    $newyy2=$newyy/$new_order_qty;
	// if($orderno=="1")
	// {
	// 	//$newyy2=$newyy/$old_order_total;
		
	// }
	// else
	// {
		
	// 	$newyy2=$newyy/$new_order_qty;
    // }
    $res = ( ($body_yy-$newyy2) / $body_yy) * 100;
	$savings_new=round( $res,1);
	//echo "<td>".$savings_new."%</td>";
	/* NEW 2010-05-22 */

?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<title>CUT PLAN VIEW</title>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 14">
<link rel=File-List href="CUT_PLAN_NEW_files/filelist.xml">
<style id="CUT_PLAN_NEW_13019_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl6513019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl6613019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl6713019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl6813019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl6913019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl7013019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl7113019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl7213019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl7313019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7413019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7513019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7613019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl7713019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7813019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl7913019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl8013019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl8113019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8213019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl8313019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl8413019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl8513019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl8613019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
.xl8713019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
.xl8813019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl8913019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl9013019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:2.0pt double windowtext;
	border-left:none;
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9113019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl9213019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9313019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl9413019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl9513019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl9613019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl9713019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl9813019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl9913019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border-right:.5pt solid black;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10013019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl10113019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border-bottom:.5pt solid black;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10213019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl10313019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl10413019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border-right:.5pt solid black;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10513019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl10613019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border-bottom:.5pt solid black;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl10713019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10813019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border-right:.5pt solid black;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10913019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11013019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11113019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border-right:.5pt solid black;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11213019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
	border-left:.5pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11313019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
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
.xl11413019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11513019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11613019
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid black;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
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
body { zoom:57%;}
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

<div id="CUT_PLAN_NEW_13019" align=center x:publishsource="Excel"><!--The following information was generated by Microsoft Office Excel's Publish
as Web Page wizard.--><!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.--><!-----------------------------><!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD --><!----------------------------->

<table border=0 cellpadding=0 cellspacing=0 width=1757 style='border-collapse:
 collapse;table-layout:fixed;width:1321pt'>
 <col class=xl6513019 width=13 style='mso-width-source:userset;mso-width-alt:
 475;width:10pt'>
 <col class=xl6613019 width=70 style='mso-width-source:userset;mso-width-alt:
 2560;width:53pt'>
 <col class=xl6613019 width=53 span=7 style='mso-width-source:userset;
 mso-width-alt:1938;width:40pt'>
 <col class=xl6613019 width=52 span=3 style='mso-width-source:userset;
 mso-width-alt:1901;width:39pt'>
 <col class=xl6613019 width=51 span=2 style='mso-width-source:userset;
 mso-width-alt:1865;width:38pt'>
 <col class=xl6613019 width=61 style='mso-width-source:userset;mso-width-alt:
 2230;width:46pt'>
 <col class=xl6613019 width=67 style='mso-width-source:userset;mso-width-alt:
 2450;width:50pt'>
 <col class=xl6613019 width=51 style='mso-width-source:userset;mso-width-alt:
 1865;width:38pt'>
 <col class=xl6613019 width=48 style='mso-width-source:userset;mso-width-alt:
 1755;width:36pt'>
 <col class=xl6613019 width=58 style='mso-width-source:userset;mso-width-alt:
 2121;width:44pt'>
 <col class=xl6613019 width=48 style='mso-width-source:userset;mso-width-alt:
 1755;width:36pt'>
 <col class=xl6613019 width=58 style='mso-width-source:userset;mso-width-alt:
 2121;width:44pt'>
 <col class=xl6613019 width=61 style='mso-width-source:userset;mso-width-alt:
 2230;width:46pt'>
 <col class=xl6613019 width=48 style='mso-width-source:userset;mso-width-alt:
 1755;width:36pt'>
 <col class=xl6513019 width=48 span=2 style='mso-width-source:userset;
 mso-width-alt:1755;width:36pt'>
 <col class=xl6513019 width=45 span=2 style='mso-width-source:userset;
 mso-width-alt:1645;width:34pt'>
 <col class=xl6513019 width=51 style='mso-width-source:userset;mso-width-alt:
 1865;width:38pt'>
 <col class=xl6513019 width=55 style='mso-width-source:userset;mso-width-alt:
 2011;width:41pt'>
 <col class=xl6513019 width=45 style='mso-width-source:userset;mso-width-alt:
 1645;width:34pt'>
 <col class=xl6513019 width=64 span=3 style='mso-width-source:userset;
 mso-width-alt:2340;width:48pt'>
 <col class=xl6513019 width=16 style='mso-width-source:userset;mso-width-alt:
 585;width:12pt'>
 <tr class=xl6513019 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6513019 width=13 style='height:15.0pt;width:10pt'><!--The following information was generated by Microsoft Office Excel's Publish
as Web Page wizard.--><!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.--><!-----------------------------><!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD --><!-----------------------------><a
  name="RANGE!A1:AH31"></a></td>
  <td class=xl6613019 width=70 style='width:53pt'></td>
  <td class=xl6613019 width=53 style='width:40pt'></td>
  <td class=xl6613019 width=53 style='width:40pt'></td>
  <td class=xl6613019 width=53 style='width:40pt'></td>
  <td class=xl6613019 width=53 style='width:40pt'></td>
  <td class=xl6613019 width=53 style='width:40pt'></td>
  <td class=xl6613019 width=53 style='width:40pt'></td>
  <td class=xl6613019 width=53 style='width:40pt'></td>
  <td class=xl6613019 width=52 style='width:39pt'></td>
  <td class=xl6613019 width=52 style='width:39pt'></td>
  <td class=xl6613019 width=52 style='width:39pt'></td>
  <td class=xl6613019 width=51 style='width:38pt'></td>
  <td class=xl6613019 width=51 style='width:38pt'></td>
  <td class=xl6613019 width=61 style='width:46pt'></td>
  <td class=xl6613019 width=67 style='width:50pt'></td>
  <td class=xl6613019 width=51 style='width:38pt'></td>
  <td class=xl6613019 width=48 style='width:36pt'></td>
  <td class=xl6613019 width=58 style='width:44pt'></td>
  <td class=xl6613019 width=48 style='width:36pt'></td>
  <td class=xl6613019 width=58 style='width:44pt'></td>
  <td class=xl6613019 width=61 style='width:46pt'></td>
  <td class=xl6613019 width=48 style='width:36pt'></td>
  <td class=xl6513019 width=48 style='width:36pt'></td>
  <td class=xl6513019 width=48 style='width:36pt'></td>
  <td class=xl6513019 width=45 style='width:34pt'></td>
  <td class=xl6513019 width=45 style='width:34pt'></td>
  <td class=xl6513019 width=51 style='width:38pt'></td>
  <td class=xl6513019 width=55 style='width:41pt'></td>
  <td class=xl6513019 width=45 style='width:34pt'></td>
  <td class=xl6513019 width=64 style='width:48pt'></td>
  <td class=xl6513019 width=64 style='width:48pt'></td>
  <td class=xl6513019 width=64 style='width:48pt'></td>
  <td class=xl6513019 width=16 style='width:12pt'></td>
 </tr>
 <tr class=xl6513019 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6513019 style='height:15.0pt'></td>
  <td colspan=8 rowspan=3 class=xl6613019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6713019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
 </tr>
 <tr class=xl6513019 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6513019 style='height:15.0pt'></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td colspan=8 class=xl9413019>Cutting Department | LID: <?php echo $cid; ?></td>
  <td class=xl6713019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
 </tr>
 <tr class=xl6513019 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6513019 style='height:15.0pt'></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6713019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
 </tr>
 <tr class=xl6513019 height=9 style='mso-height-source:userset;height:6.75pt'>
  <td height=9 class=xl6513019 style='height:6.75pt'></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6713019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
 </tr>
 <tr class=xl6513019 height=33 style='mso-height-source:userset;height:24.75pt'>
  <td height=33 class=xl6513019 style='height:24.75pt'></td>
  <td colspan=32 class=xl9513019>Cut Distribution Plan/Production
  Input&amp;Output<span style='mso-spacerun:yes'>�</span></td>
  <td class=xl6513019></td>
 </tr>
 <tr class=xl6513019 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6513019 style='height:15.0pt'></td>
  <td class=xl6713019>Style :</td>
  <td colspan=3 class=xl9613019><?php echo $style; ?></td>
  <td class=xl6613019></td>
  <td colspan=3 class=xl6713019>Category :</td>
  <td colspan=12 class=xl9613019><?php echo $category; ?></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td colspan=2 class=xl6713019>Date :</td>
  <td colspan=3 class=xl9613019><?php echo $order_date; ?></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6713019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
 </tr>
 <tr class=xl6513019 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6513019 style='height:15.0pt'></td>
  <td class=xl6713019>Sch No :</td>
  <td colspan=3 class=xl9713019><?php echo $delivery.chr($color_code); ?></td>
  <td class=xl6613019></td>
  <td colspan=3 class=xl6713019>Fab Description :</td>
  <td colspan=12 class=xl9713019><?php echo $fab_des; ?></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td colspan=2 class=xl6713019>PO :</td>
  <td colspan=3 class=xl9713019><?php echo $pono; ?></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6713019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
 </tr>
 <tr class=xl6513019 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6513019 style='height:15.0pt'></td>
  <!--
  <td class=xl6713019>Color :</td>
  <td colspan=3 class=xl9713019><?php echo $color." / ".$col_des; ?></td>
  <td class=xl6613019></td>
  <td colspan=3 class=xl6713019><span style='mso-spacerun:yes'>�</span>Fab
  Code:</td>
  -->
  <td class=xl6713019>Color :</td>
  <td colspan=6 class=xl9713019><?php echo $color." / ".$col_des; ?></td>
  <td colspan=1 class=xl6713019><span style='mso-spacerun:yes'>�</span>Fab
  Code:</td>
  <td colspan=12 class=xl9713019><?php echo $compo_no; ?></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td colspan=2 class=xl6713019>Assortment<span style='mso-spacerun:yes'>�
  </span>:</td>
  <td colspan=3 class=xl9713019>&nbsp;</td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6713019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
 </tr>
 <tr class=xl6513019 height=11 style='mso-height-source:userset;height:8.25pt'>
  <td height=11 class=xl6513019 style='height:8.25pt'></td>
  <td class=xl6713019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6713019></td>
  <td class=xl6713019></td>
  <td class=xl6713019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6713019></td>
  <td class=xl6713019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6713019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
 </tr>
 <tr class=xl6513019 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6513019 style='height:15.0pt'></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6613019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6713019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
 </tr>
 <tr class=xl6613019 height=23 style='mso-height-source:userset;height:17.25pt'>
  <td height=23 class=xl6613019 style='height:17.25pt'></td>
  <td class=xl6613019></td>
 <?php
  	if($flag == 1)
	{
		
	?>
  <td class=xl6813019><?php echo $size6; ?></td>
  <td class=xl6813019 style='border-left:none'><?php echo $size8; ?></td>
  <td class=xl7013019><?php echo $size10; ?></td>
  <td class=xl7013019><?php echo $size12; ?></td>
  <td class=xl7013019><?php echo $size14; ?></td>
  <td class=xl7013019><?php echo $size16; ?></td>
  <td class=xl7013019><?php echo $size18; ?></td>
  <td class=xl7013019><?php echo $size20; ?></td>
  <td class=xl7013019><?php echo $size22; ?></td>
  <td class=xl7013019><?php echo $size24; ?></td>
  <td class=xl7013019><?php echo $size26; ?></td>
  <td class=xl7013019><?php echo $size28; ?></td>
  <td class=xl7013019><?php echo $size30; ?></td>
	<?php
  	}
	else
	{
	?>
	<td class=xl6813019>6</td>
  <td class=xl6813019 style='border-left:none'>8</td>
  <td class=xl7013019>10</td>
  <td class=xl7013019>12</td>
  <td class=xl7013019>14</td>
  <td class=xl7013019>16</td>
  <td class=xl7013019>18</td>
  <td class=xl7013019>20</td>
  <td class=xl7013019>22</td>
  <td class=xl7013019>24</td>
  <td class=xl7013019>26</td>
  <td class=xl7013019>28</td>
  <td class=xl7013019>30</td>
	<?php
	}
	?>
  <td class=xl7013019>Total</td>
  <td class=xl6613019></td>
  <td class=xl6513019></td>
  <td class=xl6613019></td>
  <td class=xl6813019><?php echo $category; ?></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td colspan=3 class=xl9813019 style='border-right:.5pt solid black'>Savings %</td>
  <td class=xl7013019><?php echo $savings_new; ?>%</td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td colspan=3 class=xl9813019 style='border-right:.5pt solid black'>One Gmt
  One Way</td>
  <td class=xl6913019><?php echo $gmtway; ?></td>
  <td class=xl7113019></td>
  <td class=xl6613019></td>
 </tr>
 <tr class=xl6513019 height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl6513019 style='height:15.75pt'></td>
  <td class=xl7213019 width=70 style='width:53pt'>Order Qty<span
  style='mso-spacerun:yes'>�</span></td>
  <?php
  if($order_amend=="1")
  {
  echo "<td class=xl7413019>$old_s06</td>
  <td class=xl7513019> $old_s08</td>
  <td class=xl7513019> $old_s10</td>
  <td class=xl7513019> $old_s12</td>
  <td class=xl7513019> $old_s14</td>
  <td class=xl7513019> $old_s16</td>
  <td class=xl7513019> $old_s18</td>
  <td class=xl7513019> $old_s20</td>
  <td class=xl7513019> $old_s22</td>
  <td class=xl7513019> $old_s24</td>
  <td class=xl7513019> $old_s26</td>
  <td class=xl7513019> $old_s28</td>
  <td class=xl7513019> $old_s30</td>
  <td class=xl7513019> $old_order_total</td>";
  }
  else
  {
  echo "<td class=xl7413019> $o_s06</td>
  <td class=xl7513019> $o_s08</td>
  <td class=xl7513019> $o_s10</td>
  <td class=xl7513019> $o_s12</td>
  <td class=xl7513019> $o_s14</td>
  <td class=xl7513019> $o_s16</td>
  <td class=xl7513019> $o_s18</td>
  <td class=xl7513019> $o_s20</td>
  <td class=xl7513019> $o_s22</td>
  <td class=xl7513019> $o_s24</td>
  <td class=xl7513019> $o_s26</td>
  <td class=xl7513019> $o_s28</td>
  <td class=xl7513019> $o_s30</td>
  <td class=xl7513019> $order_total</td>";
  }
  ?>
  <td colspan=3 class=xl9813019 style='border-right:.5pt solid black'>Consumption</td>
  <td class=xl7613019><?php echo $body_yy; ?></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td colspan=3 class=xl9813019 style='border-right:.5pt solid black'>CAD
  Consumption</td>
  <td class=xl7613019><?php echo round($newyy2,4); ?></td>
  <td class=xl6513019></td>
  <td class=xl6613019></td>
  <td colspan=3 class=xl9813019 style='border-right:.5pt solid black'>Strip
  Matching</td>
  <td class=xl7613019><?php echo $strip_match; ?></td>
  <td class=xl6613019></td>
  <td class=xl6513019></td>
 </tr>
 <tr class=xl6513019 height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl6513019 style='height:15.75pt'></td>
 <?php
  if($order_amend=="1")
  {
  echo "<td class=xl7213019 width=70 style='width:53pt'>Extra Ship</td>";
  echo "<td class=xl7313019> $o_s06</td>
  <td class=xl7513019> $o_s08</td>
  <td class=xl7513019> $o_s10</td>
  <td class=xl7513019> $o_s12</td>
  <td class=xl7513019> $o_s14</td>
  <td class=xl7513019> $o_s16</td>
  <td class=xl7513019> $o_s18</td>
  <td class=xl7513019> $o_s20</td>
  <td class=xl7513019> $o_s22</td>
  <td class=xl7513019> $o_s24</td>
  <td class=xl7513019> $o_s26</td>
  <td class=xl7513019> $o_s28</td>
  <td class=xl7513019> $o_s30</td>
  <td class=xl7513019> $order_total</td>";
  }
  else
  {
  echo "<td class=xl7213019 width=70 style='width:53pt'>( $excess%)</td>";
  echo "<td class=xl7313019> $c_s06</td>
  <td class=xl7513019> $c_s08</td>
  <td class=xl7513019> $c_s10</td>
  <td class=xl7513019> $c_s12</td>
  <td class=xl7513019> $c_s14</td>
  <td class=xl7513019> $c_s16</td>
  <td class=xl7513019> $c_s18</td>
  <td class=xl7513019> $c_s20</td>
  <td class=xl7513019> $c_s22</td>
  <td class=xl7513019> $c_s24</td>
  <td class=xl7513019> $c_s26</td>
  <td class=xl7513019> $c_s28</td>
  <td class=xl7513019> $c_s30</td>
  <td class=xl7513019> $cuttable_total</td>";
  }
  ?>
  <td colspan=3 class=xl9813019 style='border-right:.5pt solid black'>Material
  Allowed</td>
  <td class=xl7713019><?php echo round(($order_total*$body_yy),0); ?></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td colspan=3 class=xl9813019 style='border-right:.5pt solid black'>Used
  Yards</td>
  <td class=xl7713019><?php echo round($newyy,0); ?></td>
  <td class=xl6513019></td>
  <td class=xl6613019></td>
  <td colspan=3 class=xl9813019 style='border-right:.5pt solid black'>Gusset
  Sep</td>
  <td class=xl7713019><?php echo $gusset_sep; ?></td>
  <td class=xl7813019></td>
  <td class=xl6513019></td>
 </tr>
 <tr class=xl6513019 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6513019 style='height:15.0pt'></td>
  <td class=xl7213019 width=70 style='width:53pt'>(<?php echo "Excess ".$excess; ?>%)</td>
  <td class=xl7313019><?php echo ($c_s06-$o_s06); ?></td>
  <td class=xl7513019><?php echo ($c_s08-$o_s08-$join_s08); ?></td>
  <td class=xl7513019><?php echo ($c_s10-$o_s10-$join_s10); ?></td>
  <td class=xl7513019><?php echo ($c_s12-$o_s12); ?></td>
  <td class=xl7513019><?php echo ($c_s14-$o_s14); ?></td>
  <td class=xl7513019><?php echo ($c_s16-$o_s16); ?></td>
  <td class=xl7513019><?php echo ($c_s18-$o_s18); ?></td>
  <td class=xl7513019><?php echo ($c_s20-$o_s20); ?></td>
  <td class=xl7513019><?php echo ($c_s22-$o_s22); ?></td>
  <td class=xl7513019><?php echo ($c_s24-$o_s24); ?></td>
  <td class=xl7513019><?php echo ($c_s26-$o_s26); ?></td>
  <td class=xl7513019><?php echo ($c_s28-$o_s28); ?></td>
  <td class=xl7513019><?php echo ($c_s30-$o_s30); ?></td>
  <td class=xl7513019><?php echo ($cuttable_total-$order_total) ?></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6613019></td>
  <td colspan=3 class=xl9813019 style='border-right:.5pt solid black'>Pattern
  Version</td>
  <td class=xl7713019><?php echo $patt_ver; ?></td>
  <td class=xl6613019></td>
  <td class=xl6513019></td>
 </tr>
 <tr class=xl6513019 height=12 style='mso-height-source:userset;height:9.0pt'>
  <td height=12 class=xl6513019 style='height:9.0pt'></td>
  <td class=xl7213019 width=70 style='width:53pt'></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl7113019></td>
  <td class=xl7113019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
 </tr>
 <tr class=xl6513019 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6513019 style='height:15.0pt'></td>
  <td class=xl7913019 width=70 style='width:53pt'>Floorsets</td>
  <td class=xl8013019>&nbsp;</td>
  <?php
  if($join_check==1)
  {
  	echo "<td class=xl8113019>$join_s08</td>";
  	echo "<td class=xl8113019 style='border-left:none'>$join_s10</td>";
  	echo "<td class=xl8113019 style='border-left:none'>SCH#</td>";
 	echo "<td class=xl8113019 style='border-left:none'>$join_schedule</td>";
  }
  else
  {
  	echo "<td class=xl8113019>&nbsp;</td>";
  	echo "<td class=xl8113019 style='border-left:none'>&nbsp;</td>";
  	echo "<td class=xl8113019 style='border-left:none'>&nbsp;</td>";
 	echo "<td class=xl8113019 style='border-left:none'>&nbsp;</td>";
  }
  
  ?>
  <td class=xl8113019>&nbsp;</td>
  <td class=xl8113019>&nbsp;</td>
  <td class=xl8113019>&nbsp;</td>
  <td class=xl8113019>&nbsp;</td>
  <td class=xl8113019>&nbsp;</td>
  <td class=xl8113019>&nbsp;</td>
  <td class=xl8113019>&nbsp;</td>
  <td class=xl11313019 style='border-left:none'>&nbsp;</td>
  <td class=xl11313019 style='border-left:none'>&nbsp;</td>
  <td class=xl6613019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl7113019></td>
  <td class=xl7113019></td>
  <td class=xl7113019></td>
  <td class=xl7113019></td>
  <td class=xl7113019></td>
  <td class=xl6613019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6613019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
 </tr>
 <tr class=xl6513019 height=10 style='mso-height-source:userset;height:7.5pt'>
  <td height=10 class=xl6513019 style='height:7.5pt'></td>
  <td class=xl7913019 width=70 style='width:53pt'></td>
  <td class=xl8213019></td>
  <td class=xl8213019></td>
  <td class=xl8213019></td>
  <td class=xl8213019></td>
  <td class=xl8213019></td>
  <td class=xl8213019></td>
  <td class=xl8213019></td>
  <td class=xl8213019></td>
  <td class=xl8213019></td>
  <td class=xl8213019></td>
  <td class=xl8213019></td>
  <td class=xl8213019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6613019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl7113019></td>
  <td class=xl7113019></td>
  <td class=xl7113019></td>
  <td class=xl7113019></td>
  <td class=xl7113019></td>
  <td class=xl6613019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6613019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
 </tr>
 <tr class=xl6513019 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6513019 style='height:15.0pt'></td>
  <td class=xl7913019 width=70 style='width:53pt'>Catoon</td>
  <td class=xl8013019>&nbsp;</td>
  <td class=xl8113019>&nbsp;</td>
  <td class=xl8113019>&nbsp;</td>
  <td class=xl8113019>&nbsp;</td>
  <td class=xl8113019>&nbsp;</td>
  <td class=xl8113019>&nbsp;</td>
  <td class=xl8113019>&nbsp;</td>
  <td class=xl8113019>&nbsp;</td>
  <td class=xl8113019>&nbsp;</td>
  <td class=xl8113019>&nbsp;</td>
  <td class=xl8113019>&nbsp;</td>
  <td class=xl8113019>&nbsp;</td>
  <td class=xl8113019>&nbsp;</td>
  <td class=xl8113019>&nbsp;</td>
  
  <td class=xl6513019></td>
  
  <?php
  
   
  if(strlen($remarks_x)>0)
  {
  	echo "<td class=xl6513019 colspan=15 align=left><strong>Remarks: $remarks_x</strong></td>";
  }
  else
  {
  	echo "<td class=xl6513019 colspan=2 align=left></td>";
  }
 
   if(($emb_a+$emb_b+$emb_c+$emb_d+$emb_e+$emb_f)>0) 
  {
    
  	$emb_stat=0;
	$emb_title="";
	if($emb_a>0 or $emb_b>0)
	{
		$emb_title="Panel Form";
		$emb_stat=1;
	}
	if($emb_c>0 or $emb_d>0)
	{
		$emb_title="Semi Garment Form";
		$emb_stat=1;
	}
	if($emb_e>0 or $emb_f>0)
	{
		$emb_title="Garment Form";
		$emb_stat=1;
	}
	
	echo "<td class=xl6513019 colspan=5><strong>EMB: $emb_title</strong></td>";
  }
  else
  {
  	echo "<td class=xl6513019></td>";
  }
  
  ?> 	
 </tr>
 <tr class=xl6513019 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6513019 style='height:15.0pt'></td>
  <td class=xl7913019 width=70 style='width:53pt'></td>
  <td class=xl8213019></td>
  <td class=xl8213019></td>
  <td class=xl8213019></td>
  <td class=xl8213019></td>
  <td class=xl8213019></td>
  <td class=xl8213019></td>
  <td class=xl8213019></td>
  <td class=xl8213019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6613019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl7113019></td>
  <td class=xl7113019></td>
  <td class=xl7113019></td>
  <td class=xl7113019></td>
  <td class=xl7113019></td>
  <td class=xl6613019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6613019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6713019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
 </tr>
 <tr class=xl6613019 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6613019 style='height:15.0pt'></td>
  <td rowspan=2 class=xl10013019 style='border-bottom:.5pt solid black'>Cut No</td>
  <td colspan=13 class=xl10313019 style='border-right:.5pt solid black;
  border-left:none'>Ratio</td>
  <td rowspan=2 class=xl10013019 style='border-bottom:.5pt solid black'>Plies</td>
  <td colspan=3 class=xl10313019 style='border-right:.5pt solid black;
  border-left:none'>Verification</td>
  <td class=xl11613019 style='border-left:none' colspan=14>INPUT</td>
 <!-- <td class=xl11413019>&nbsp;</td>
  <td class=xl11413019>&nbsp;</td>
  <td class=xl11413019>&nbsp;</td>
  <td class=xl11413019>&nbsp;</td>
  <td class=xl11413019>&nbsp;</td>
  <td class=xl11413019>&nbsp;</td>
  <td class=xl11413019>&nbsp;</td>
  <td class=xl11413019>&nbsp;</td>
  <td class=xl11413019>&nbsp;</td>
  <td class=xl11413019>&nbsp;</td>
  <td class=xl11413019>&nbsp;</td>
  <td class=xl11413019>&nbsp;</td>
  <td class=xl11613019>&nbsp;</td> -->
  <td class=xl8313019>&nbsp;</td>
 </tr>
 <tr class=xl6613019 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6613019 style='height:15.0pt'></td>
  <?php
  	if($flag == 1)
	{
		
	?>
  <td class=xl8413019><?php echo $size6; ?></td>
  <td class=xl8413019><?php echo $size8; ?></td>
  <td class=xl8413019><?php echo $size10; ?></td>
  <td class=xl8413019><?php echo $size12; ?></td>
  <td class=xl8413019><?php echo $size14; ?></td>
  <td class=xl8413019><?php echo $size16; ?></td>
  <td class=xl8413019><?php echo $size18; ?></td>
  <td class=xl8413019><?php echo $size20; ?></td>
  <td class=xl8413019><?php echo $size22; ?></td>
  <td class=xl8413019><?php echo $size24; ?></td>
  <td class=xl8413019><?php echo $size26; ?></td>
  <td class=xl8413019><?php echo $size28; ?></td>
  <td class=xl8413019><?php echo $size30; ?></td>
	<?php
  	}
	else
	{
	?>
	<td class=xl8413019>6</td>
  <td class=xl8413019>8</td>
  <td class=xl8413019>10</td>
  <td class=xl8413019>12</td>
  <td class=xl8413019>14</td>
  <td class=xl8413019>16</td>
  <td class=xl8413019>18</td>
  <td class=xl8413019>20</td>
  <td class=xl8413019>22</td>
  <td class=xl8413019>24</td>
  <td class=xl8413019>26</td>
  <td class=xl8413019>28</td>
  <td class=xl8413019>30</td>
	<?php
	}
	?>
  <td class=xl8413019>Mod#</td>
  <td class=xl8413019>Date</td>
  <td class=xl8413019>Sign</td>
	<?php
  	if($flag == 1)
	{
		
	?>
  <td class=xl8413019><?php echo $size6; ?></td>
  <td class=xl8413019><?php echo $size8; ?></td>
  <td class=xl8413019><?php echo $size10; ?></td>
  <td class=xl8413019><?php echo $size12; ?></td>
  <td class=xl8413019><?php echo $size14; ?></td>
  <td class=xl8413019><?php echo $size16; ?></td>
  <td class=xl8413019><?php echo $size18; ?></td>
  <td class=xl8413019><?php echo $size20; ?></td>
  <td class=xl8413019><?php echo $size22; ?></td>
  <td class=xl8413019><?php echo $size24; ?></td>
  <td class=xl8413019><?php echo $size26; ?></td>
  <td class=xl8413019><?php echo $size28; ?></td>
  <td class=xl8413019><?php echo $size30; ?></td>
	<?php
  	}
	else
	{
	?>
	<td class=xl8413019>6</td>
  <td class=xl8413019>8</td>
  <td class=xl8413019>10</td>
  <td class=xl8413019>12</td>
  <td class=xl8413019>14</td>
  <td class=xl8413019>16</td>
  <td class=xl8413019>18</td>
  <td class=xl8413019>20</td>
  <td class=xl8413019>22</td>
  <td class=xl8413019>24</td>
  <td class=xl8413019>26</td>
  <td class=xl8413019>28</td>
  <td class=xl8413019>30</td>
	<?php
	}
	?>
  <td class=xl8413019>TTL</td>
  <td class=xl8513019>&nbsp;</td>
 </tr>
 
 
 <?php  
 
 $a_s06_tot=0;
 	$a_s08_tot=0;
	$a_s10_tot=0;
	$a_s12_tot=0;
	$a_s14_tot=0;
	$a_s16_tot=0;
	$a_s18_tot=0;
	$a_s20_tot=0;
	$a_s22_tot=0;
	$a_s24_tot=0;
	$a_s26_tot=0;
	$a_s28_tot=0;
	$a_s30_tot=0;
	$plies_tot=0;
	
$sql="select * from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Pilot\"  order by acutno";
mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$a_s06=$sql_row['a_s06'];
$a_s08=$sql_row['a_s08'];
$a_s10=$sql_row['a_s10'];
$a_s12=$sql_row['a_s12'];
$a_s14=$sql_row['a_s14'];
$a_s16=$sql_row['a_s16'];
$a_s18=$sql_row['a_s18'];
$a_s20=$sql_row['a_s20'];
$a_s22=$sql_row['a_s22'];
$a_s24=$sql_row['a_s24'];
$a_s26=$sql_row['a_s26'];
$a_s28=$sql_row['a_s28'];
$a_s30=$sql_row['a_s30'];

	$cutno=$sql_row['acutno'];
	$plies=$sql_row['p_plies'];
	$docketno=$sql_row['doc_no'];
	$docketdate=$sql_row['date'];
	$mk_ref=$sql_row['mk_ref'];
	
	$a_s06_tot=$a_s06_tot+($a_s06*$plies);
$a_s08_tot=$a_s08_tot+($a_s08*$plies);
$a_s10_tot=$a_s10_tot+($a_s10*$plies);
$a_s12_tot=$a_s12_tot+($a_s12*$plies);
$a_s14_tot=$a_s14_tot+($a_s14*$plies);
$a_s16_tot=$a_s16_tot+($a_s16*$plies);
$a_s18_tot=$a_s18_tot+($a_s18*$plies);
$a_s20_tot=$a_s20_tot+($a_s20*$plies);
$a_s22_tot=$a_s22_tot+($a_s22*$plies);
$a_s24_tot=$a_s24_tot+($a_s24*$plies);
$a_s26_tot=$a_s26_tot+($a_s26*$plies);
$a_s28_tot=$a_s28_tot+($a_s28*$plies);
$a_s30_tot=$a_s30_tot+($a_s30*$plies);

	$plies_tot=$plies_tot+$plies;
	
	echo "<tr class=xl6613019 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6613019 style='height:15.0pt'></td>";
   echo "<td class=xl8613019>Pilot</td>";
  echo "<td class=xl8713019>".$a_s06."</td>";
   echo "<td class=xl8713019>".$a_s08."</td>";
   echo "<td class=xl8713019>".$a_s10."</td>";
   echo "<td class=xl8713019>".$a_s12."</td>";
   echo "<td class=xl8713019>".$a_s14."</td>";
   echo "<td class=xl8713019>".$a_s16."</td>";
   echo "<td class=xl8713019>".$a_s18."</td>";
   echo "<td class=xl8713019>".$a_s20."</td>";
   echo "<td class=xl8713019>".$a_s22."</td>";
   echo "<td class=xl8713019>".$a_s24."</td>";
   echo "<td class=xl8713019>".$a_s26."</td>";
   echo "<td class=xl8713019>".$a_s28."</td>";
   echo "<td class=xl8713019>".$a_s30."</td>";
  echo "<td class=xl8713019>".$plies."</td>";
  echo "<td class=xl8713019></td>";
  echo "<td class=xl8713019></td>";
   echo "<td class=xl8713019></td>";
   echo "<td class=xl8713019>".($a_s06*$plies)."</td>";
  echo "<td class=xl8713019>".($a_s08*$plies)."</td>";
  echo "<td class=xl8713019>".($a_s10*$plies)."</td>";
  echo "<td class=xl8713019>".($a_s12*$plies)."</td>";
  echo "<td class=xl8713019>".($a_s14*$plies)."</td>";
  echo "<td class=xl8713019>".($a_s16*$plies)."</td>";
  echo "<td class=xl8713019>".($a_s18*$plies)."</td>";
  echo "<td class=xl8713019>".($a_s20*$plies)."</td>";
  echo "<td class=xl8713019>".($a_s22*$plies)."</td>";
  echo "<td class=xl8713019>".($a_s24*$plies)."</td>";
  echo "<td class=xl8713019>".($a_s26*$plies)."</td>";
  echo "<td class=xl8713019>".($a_s28*$plies)."</td>";
  echo "<td class=xl8713019>".($a_s30*$plies)."</td>";
  echo "<td class=xl8713019>".(($a_s06*$plies)+($a_s08*$plies)+($a_s10*$plies)+($a_s12*$plies)+($a_s14*$plies)+($a_s16*$plies)+($a_s18*$plies)+($a_s20*$plies)+($a_s22*$plies)+($a_s24*$plies)+($a_s26*$plies)+($a_s28*$plies)+($a_s30*$plies))."</td>";
echo "<td class=xl8513019>&nbsp;</td>";
echo "</tr>";

}
 
 	$a_s06_tot=0;
 	$a_s08_tot=0;
	$a_s10_tot=0;
	$a_s12_tot=0;
	$a_s14_tot=0;
	$a_s16_tot=0;
	$a_s18_tot=0;
	$a_s20_tot=0;
	$a_s22_tot=0;
	$a_s24_tot=0;
	$a_s26_tot=0;
	$a_s28_tot=0;
	$a_s30_tot=0;
	$plies_tot=0;
	
	$ex_s06_tot=0;
	$ex_s08_tot=0;
	$ex_s10_tot=0;
	$ex_s12_tot=0;
	$ex_s14_tot=0;
	$ex_s16_tot=0;
	$ex_s18_tot=0;
	$ex_s20_tot=0;
	$ex_s22_tot=0;
	$ex_s24_tot=0;
	$ex_s26_tot=0;
	$ex_s28_tot=0;
	$ex_s30_tot=0;
	
	
	
	//To identify the first cut no.	
$sql="select min(acutno) as firstcut from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\"";
$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
while($sql_row=mysqli_fetch_array($sql_result))
{	
	$int_first_cut=$sql_row['firstcut'];
}

$sql11="select * from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\"";
$sql_result11=mysqli_query($link,$sql11) or exit("Sql Error".mysql_error());
$cut_total_no=mysqli_num_rows($sql_result11);

	
$sql="select * from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\" order by acutno";
mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{

$a_s06=$sql_row['a_s06'];
$a_s08=$sql_row['a_s08'];
$a_s10=$sql_row['a_s10'];
$a_s12=$sql_row['a_s12'];
$a_s14=$sql_row['a_s14'];
$a_s16=$sql_row['a_s16'];
$a_s18=$sql_row['a_s18'];
$a_s20=$sql_row['a_s20'];
$a_s22=$sql_row['a_s22'];
$a_s24=$sql_row['a_s24'];
$a_s26=$sql_row['a_s26'];
$a_s28=$sql_row['a_s28'];
$a_s30=$sql_row['a_s30'];
	$cutno=$sql_row['acutno'];
	$plies=$sql_row['p_plies']; //20110911
	$docketno=$sql_row['doc_no'];
	$docketdate=$sql_row['date'];
	$mk_ref=$sql_row['mk_ref'];
	
$a_s06_tot=$a_s06_tot+($a_s06*$plies);
$a_s08_tot=$a_s08_tot+($a_s08*$plies);
$a_s10_tot=$a_s10_tot+($a_s10*$plies);
$a_s12_tot=$a_s12_tot+($a_s12*$plies);
$a_s14_tot=$a_s14_tot+($a_s14*$plies);
$a_s16_tot=$a_s16_tot+($a_s16*$plies);
$a_s18_tot=$a_s18_tot+($a_s18*$plies);
$a_s20_tot=$a_s20_tot+($a_s20*$plies);
$a_s22_tot=$a_s22_tot+($a_s22*$plies);
$a_s24_tot=$a_s24_tot+($a_s24*$plies);
$a_s26_tot=$a_s26_tot+($a_s26*$plies);
$a_s28_tot=$a_s28_tot+($a_s28*$plies);
$a_s30_tot=$a_s30_tot+($a_s30*$plies);
$plies_tot=$plies_tot+$plies;  // NEW

$ex_s06=($c_s06-$o_s06);
$ex_s08=($c_s08-$o_s08-$join_s08);
$ex_s10=($c_s10-$o_s10-$join_s10);
$ex_s12=($c_s12-$o_s12);
$ex_s14=($c_s14-$o_s14);
$ex_s16=($c_s16-$o_s16);
$ex_s18=($c_s18-$o_s18);
$ex_s20=($c_s20-$o_s20);
$ex_s22=($c_s22-$o_s22);
$ex_s24=($c_s24-$o_s24);
$ex_s26=($c_s26-$o_s26);
$ex_s28=($c_s28-$o_s28);
$ex_s30=($c_s30-$o_s30);
	
if($cutno==1)
{
	
	
	
	
	// NEW CODE
	if($join_check==1)
	{


		   echo "<tr class=xl6613019 height=20 style='mso-height-source:userset;height:15.0pt'>
		   <td height=20 class=xl6613019 style='height:15.0pt'></td>";
		   echo "<td class=xl8613019>Floorset</td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019>".$join_s08."</td>";
		   echo "<td class=xl8713019>".$join_s10."</td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019></td>";
		   echo "<td class=xl8713019>".($join_s08+$join_s10)."</td>";
		   echo "<td class=xl8513019>&nbsp;</td>";
		   echo "</tr>";
	}

    //embellishment start
	if($emb_stat==1)
	{
		
			  echo "<tr class=xl6613019 height=20 style='height:15.0pt'>";
			  echo "<td height=20 class=xl6613019 style='height:15.0pt'></td>";
			  echo "<td class=xl8613019>".chr($color_code)."000"."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round(($ex_s06-($a_s06*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round(($ex_s08-($a_s08*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round(($ex_s10-($a_s10*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round(($ex_s12-($a_s12*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round(($ex_s14-($a_s14*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round(($ex_s16-($a_s16*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round(($ex_s18-($a_s18*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round(($ex_s20-($a_s20*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round(($ex_s22-($a_s22*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round(($ex_s24-($a_s24*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round(($ex_s26-($a_s26*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round(($ex_s28-($a_s28*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round(($ex_s30-($a_s30*$extra_plies))/2))."</td>";
		    
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((round(($ex_s06-($a_s06*$extra_plies))/2))+(round(($ex_s08-($a_s08*$extra_plies))/2))+(round(($ex_s10-($a_s10*$extra_plies))/2))+(round(($ex_s12-($a_s12*$extra_plies))/2))+(round(($ex_s14-($a_s14*$extra_plies))/2))+(round(($ex_s16-($a_s16*$extra_plies))/2))+(round(($ex_s18-($a_s18*$extra_plies))/2))+(round(($ex_s20-($a_s20*$extra_plies))/2))+(round(($ex_s22-($a_s22*$extra_plies))/2))+(round(($ex_s24-($a_s24*$extra_plies))/2))+(round(($ex_s26-($a_s26*$extra_plies))/2))+(round(($ex_s28-($a_s28*$extra_plies))/2))+(round(($ex_s30-($a_s30*$extra_plies))/2)))."</td>";
		  
			  echo "</tr>";
			 
			  echo "<tr class=xl6613019 height=20 style='height:15.0pt'>";
			  echo "<td height=20 class=xl6613019 style='height:15.0pt'></td>";
			  echo "<td class=xl8613019 >EMB</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			   echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'></td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)(($ex_s06-($a_s06*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)(($ex_s08-($a_s08*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)(($ex_s10-($a_s10*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)(($ex_s12-($a_s12*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)(($ex_s14-($a_s14*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)(($ex_s16-($a_s16*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)(($ex_s18-($a_s18*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)(($ex_s20-($a_s20*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)(($ex_s22-($a_s22*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)(($ex_s24-($a_s24*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)(($ex_s26-($a_s26*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)(($ex_s28-($a_s28*$extra_plies))/2))."</td>";
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)(($ex_s30-($a_s30*$extra_plies))/2))."</td>";
			  //echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(((int)($ex_s06/2))+((int)($ex_s08/2))+((int)($ex_s10/2))+((int)($ex_s12/2))+((int)($ex_s14/2))+((int)($ex_s16/2))+((int)($ex_s18/2))+((int)($ex_s20/2))+((int)($ex_s22/2))+((int)($ex_s24/2))+((int)($ex_s26/2))+((int)($ex_s28/2))+((int)($ex_s30/2)))."</td>";
			   echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(((int)(($ex_s06-($a_s06*$extra_plies))/2))+((int)(($ex_s08-($a_s08*$extra_plies))/2))+((int)(($ex_s10-($a_s10*$extra_plies))/2))+((int)(($ex_s12-($a_s12*$extra_plies))/2))+((int)(($ex_s14-($a_s14*$extra_plies))/2))+((int)(($ex_s16-($a_s16*$extra_plies))/2))+((int)(($ex_s18-($a_s18*$extra_plies))/2))+((int)(($ex_s20-($a_s20*$extra_plies))/2))+((int)(($ex_s22-($a_s22*$extra_plies))/2))+((int)(($ex_s24-($a_s24*$extra_plies))/2))+((int)(($ex_s26-($a_s26*$extra_plies))/2))+((int)(($ex_s28-($a_s28*$extra_plies))/2))+((int)(($ex_s30-($a_s30*$extra_plies))/2)))."</td>";
			  echo "</tr>";
			  
			 echo "<tr class=xl6613019 height=20 style='mso-height-source:userset;height:15.0pt'>
			<td height=20 class=xl6613019 style='height:15.0pt'></td>";
			echo "<td class=xl8613019>Excess Quantity</td>";
			echo "<td class=xl8713019></td>";
			echo "<td class=xl8713019></td>";
			echo "<td class=xl8713019></td>";
			echo "<td class=xl8713019></td>";
			echo "<td class=xl8713019></td>";
			echo "<td class=xl8713019></td>";
			echo "<td class=xl8713019></td>";
			echo "<td class=xl8713019></td>";
			echo "<td class=xl8713019></td>";
			echo "<td class=xl8713019></td>";
			echo "<td class=xl8713019></td>";
			echo "<td class=xl8713019></td>";
			echo "<td class=xl8713019></td>";
			echo "<td class=xl8713019></td>";
			echo "<td class=xl8713019></td>";
			echo "<td class=xl8713019></td>";
			echo "<td class=xl8713019></td>";
			echo "<td class=xl8713019>".$a_s06*$extra_plies."</td>";
			echo "<td class=xl8713019>".$a_s08*$extra_plies."</td>";
			echo "<td class=xl8713019>".$a_s10*$extra_plies."</td>";
			echo "<td class=xl8713019>".$a_s12*$extra_plies."</td>";
			echo "<td class=xl8713019>".$a_s14*$extra_plies."</td>";
			echo "<td class=xl8713019>".$a_s16*$extra_plies."</td>";
			echo "<td class=xl8713019>".$a_s18*$extra_plies."</td>";
			echo "<td class=xl8713019>".$a_s20*$extra_plies."</td>";
			echo "<td class=xl8713019>".$a_s22*$extra_plies."</td>";
			echo "<td class=xl8713019>".$a_s24*$extra_plies."</td>";
			echo "<td class=xl8713019>".$a_s26*$extra_plies."</td>";
			echo "<td class=xl8713019>".$a_s28*$extra_plies."</td>";
			echo "<td class=xl8713019>".$a_s30*$extra_plies."</td>";
			echo "<td class=xl8713019>".($a_s06+$a_s08+$a_s10+$a_s12+$a_s14+$a_s16+$a_s18+$a_s20+$a_s22+$a_s24+$a_s26+$a_s28+$a_s30)*$extra_plies."</td>";
			echo "<td class=xl8513019>&nbsp;</td>";
			echo "</tr>";
			echo "A1=".$a_s06."-".$extra_plies;
			$a_s06_ex_qty=$a_s06*$extra_plies;
			$a_s08_ex_qty=$a_s08*$extra_plies;
			$a_s10_ex_qty=$a_s10*$extra_plies;
			$a_s12_ex_qty=$a_s12*$extra_plies;
			$a_s14_ex_qty=$a_s14*$extra_plies;
			$a_s16_ex_qty=$a_s16*$extra_plies;
			$a_s18_ex_qty=$a_s18*$extra_plies;
			$a_s20_ex_qty=$a_s20*$extra_plies;
			$a_s22_ex_qty=$a_s22*$extra_plies;
			$a_s24_ex_qty=$a_s24*$extra_plies;
			$a_s26_ex_qty=$a_s26*$extra_plies;
			$a_s28_ex_qty=$a_s28*$extra_plies;
			$a_s30_ex_qty=$a_s30*$extra_plies;
			$ex_s06=$ex_s06+($a_s06*$extra_plies);
			$ex_s08=$ex_s08+($a_s08*$extra_plies);
			$ex_s10=$ex_s10+($a_s10*$extra_plies);
			$ex_s12=$ex_s12+($a_s12*$extra_plies);
			$ex_s14=$ex_s14+($a_s14*$extra_plies);
			$ex_s16=$ex_s16+($a_s16*$extra_plies);
			$ex_s18=$ex_s18+($a_s18*$extra_plies);
			$ex_s20=$ex_s20+($a_s20*$extra_plies);
			$ex_s22=$ex_s22+($a_s22*$extra_plies);
			$ex_s24=$ex_s24+($a_s24*$extra_plies);
			$ex_s26=$ex_s26+($a_s26*$extra_plies);
			$ex_s28=$ex_s28+($a_s28*$extra_plies);
			$ex_s30=$ex_s30+($a_s30*$extra_plies);
	}
// embellishment end	
	else
	{
		echo "<tr class=xl6613019 height=20 style='mso-height-source:userset;height:15.0pt'>
		<td height=20 class=xl6613019 style='height:15.0pt'></td>";
		echo "<td class=xl8613019>".chr($color_code)."000"."</td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019>".($ex_s06-($a_s06*$extra_plies))."</td>";
		echo "<td class=xl8713019>".($ex_s08-($a_s08*$extra_plies))."</td>";
		echo "<td class=xl8713019>".($ex_s10-($a_s10*$extra_plies))."</td>";
		echo "<td class=xl8713019>".($ex_s12-($a_s12*$extra_plies))."</td>";
		echo "<td class=xl8713019>".($ex_s14-($a_s14*$extra_plies))."</td>";
		echo "<td class=xl8713019>".($ex_s16-($a_s16*$extra_plies))."</td>";
		echo "<td class=xl8713019>".($ex_s18-($a_s18*$extra_plies))."</td>";
		echo "<td class=xl8713019>".($ex_s20-($a_s20*$extra_plies))."</td>";
		echo "<td class=xl8713019>".($ex_s22-($a_s22*$extra_plies))."</td>";
		echo "<td class=xl8713019>".($ex_s24-($a_s24*$extra_plies))."</td>";
		echo "<td class=xl8713019>".($ex_s26-($a_s26*$extra_plies))."</td>";
		echo "<td class=xl8713019>".($ex_s28-($a_s28*$extra_plies))."</td>";
		echo "<td class=xl8713019>".($ex_s30-($a_s30*$extra_plies))."</td>";
		
		
		
		//echo "<td class=xl8713019>".($ex_s06+$ex_s08+$ex_s10+$ex_s12+$ex_s14+$ex_s16+$ex_s18+$ex_s20+$ex_s22+$ex_s24+$ex_s26+$ex_s28+$ex_s30)."</td>";
		echo "<td class=xl8713019>".(($ex_s06-($a_s06*$extra_plies))+($ex_s08-($a_s08*$extra_plies))+($ex_s10-($a_s10*$extra_plies))+($ex_s12-($a_s12*$extra_plies))+($ex_s14-($a_s14*$extra_plies))+($ex_s16-($a_s16*$extra_plies))+($ex_s18-($a_s18*$extra_plies))+($ex_s20-($a_s20*$extra_plies))+($ex_s22-($a_s22*$extra_plies))+($ex_s24-($a_s24*$extra_plies))+($ex_s26-($a_s26*$extra_plies))+($ex_s28-($a_s28*$extra_plies))+($ex_s30-($a_s30*$extra_plies)))."</td>";
		echo "<td class=xl8513019>&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr class=xl6613019 height=20 style='mso-height-source:userset;height:15.0pt'>
		<td height=20 class=xl6613019 style='height:15.0pt'></td>";
		echo "<td class=xl8613019>Excess Quantity</td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019>".$a_s06*$extra_plies."</td>";
		echo "<td class=xl8713019>".$a_s08*$extra_plies."</td>";
		echo "<td class=xl8713019>".$a_s10*$extra_plies."</td>";
		echo "<td class=xl8713019>".$a_s12*$extra_plies."</td>";
		echo "<td class=xl8713019>".$a_s14*$extra_plies."</td>";
		echo "<td class=xl8713019>".$a_s16*$extra_plies."</td>";
		echo "<td class=xl8713019>".$a_s18*$extra_plies."</td>";
		echo "<td class=xl8713019>".$a_s20*$extra_plies."</td>";
		echo "<td class=xl8713019>".$a_s22*$extra_plies."</td>";
		echo "<td class=xl8713019>".$a_s24*$extra_plies."</td>";
		echo "<td class=xl8713019>".$a_s26*$extra_plies."</td>";
		echo "<td class=xl8713019>".$a_s28*$extra_plies."</td>";
		echo "<td class=xl8713019>".$a_s30*$extra_plies."</td>";
		echo "<td class=xl8713019>".($a_s06+$a_s08+$a_s10+$a_s12+$a_s14+$a_s16+$a_s18+$a_s20+$a_s22+$a_s24+$a_s26+$a_s28+$a_s30)*$extra_plies."</td>";
		echo "<td class=xl8513019>&nbsp;</td>";
		echo "</tr>";
		//echo "A1=".$a_s06."-".$extra_plies;
		$a_s06_ex_qty=$a_s06*$extra_plies;
		$a_s08_ex_qty=$a_s08*$extra_plies;
		$a_s10_ex_qty=$a_s10*$extra_plies;
		$a_s12_ex_qty=$a_s12*$extra_plies;
		$a_s14_ex_qty=$a_s14*$extra_plies;
		$a_s16_ex_qty=$a_s16*$extra_plies;
		$a_s18_ex_qty=$a_s18*$extra_plies;
		$a_s20_ex_qty=$a_s20*$extra_plies;
		$a_s22_ex_qty=$a_s22*$extra_plies;
		$a_s24_ex_qty=$a_s24*$extra_plies;
		$a_s26_ex_qty=$a_s26*$extra_plies;
		$a_s28_ex_qty=$a_s28*$extra_plies;
		$a_s30_ex_qty=$a_s30*$extra_plies;
		$ex_s06=$ex_s06+($a_s06*$extra_plies);
		$ex_s08=$ex_s08+($a_s08*$extra_plies);
		$ex_s10=$ex_s10+($a_s10*$extra_plies);
		$ex_s12=$ex_s12+($a_s12*$extra_plies);
		$ex_s14=$ex_s14+($a_s14*$extra_plies);
		$ex_s16=$ex_s16+($a_s16*$extra_plies);
		$ex_s18=$ex_s18+($a_s18*$extra_plies);
		$ex_s20=$ex_s20+($a_s20*$extra_plies);
		$ex_s22=$ex_s22+($a_s22*$extra_plies);
		$ex_s24=$ex_s24+($a_s24*$extra_plies);
		$ex_s26=$ex_s26+($a_s26*$extra_plies);
		$ex_s28=$ex_s28+($a_s28*$extra_plies);
		$ex_s30=$ex_s30+($a_s30*$extra_plies);
	}
}
//echo $cutno."-".$first_cut."<br>";	
//if($cutno==$first_cut)
{
	
	
	$first_cut=0;
	$sqls="select max(acutno) as firstcut from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\" and a_s06>0";
	$sql_results=mysqli_query($link,$sqls) or exit("Sql Error".mysql_error());
	while($sql_rows=mysqli_fetch_array($sql_results))
	{	
		$first_cut=$sql_rows['firstcut'];	
	}
	
	if($cutno==$first_cut)
	{
		//echo "<BR>r12=".$cutno."/".$first_cut."/".$int_first_cut."/".$ex_s06."-".$a_s06."-".$extra_plies."<br>";
		$ex_s06=$ex_s06-$a_s06_ex_qty;
	}
	else
	{
		$ex_s06=0;
		//echo "s22=".$a_s06."<br>";
		//echo "<BR>r1=".$cutno."/".$int_first_cut."/".$a_s06."-".$extra_plies."<br>";
		if($cutno==$int_first_cut)
		{
			//echo "<BR>r=".$a_s06."-".$extra_plies."<br>";
			$ex_s06=$a_s06*$extra_plies;
		}		
	}
	//echo "a_s06=".$cutno."-".$first_cut."-".$ex_s06."<br>";	
	$first_cut=0;
	
	$sqls="select max(acutno) as firstcut from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\" and a_s08>0";
	//echo $sqls."<br>";
	$sql_results=mysqli_query($link,$sqls) or exit("Sql Error".mysql_error());
	while($sql_rows=mysqli_fetch_array($sql_results))
	{	
		$first_cut=$sql_rows['firstcut'];	
	}
	
	if($cutno==$first_cut)
	{
		//echo "<BR>s28=".$a_s08."-".$a_s08_ex_qty."-".$ex_s08."<br>";
		$ex_s08=$ex_s08-$a_s08_ex_qty;
	}
	else
	{
		$ex_s08=0;
		if($cutno==$int_first_cut)
		{
			$ex_s08=$a_s08*$extra_plies;
		}	
	}
	
	$first_cut=0;
	$sqls="select max(acutno) as firstcut from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\" and a_s10>0";
	$sql_results=mysqli_query($link,$sqls) or exit("Sql Error".mysql_error());
	while($sql_rows=mysqli_fetch_array($sql_results))
	{	
		$first_cut=$sql_rows['firstcut'];	
	}
	
	if($cutno==$first_cut)
	{
		//$ex_s10=($c_s10-$o_s10);
		$ex_s10=$ex_s10-$a_s10_ex_qty;
	}
	else
	{
		$ex_s10=0;
		if($cutno==$int_first_cut)
		{
			$ex_s10=$a_s10*$extra_plies;
		}	
	}
	$first_cut=0;
	$sqls="select max(acutno) as firstcut from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\" and a_s12>0";
	$sql_results=mysqli_query($link,$sqls) or exit("Sql Error".mysql_error());
	while($sql_rows=mysqli_fetch_array($sql_results))
	{	
		$first_cut=$sql_rows['firstcut'];	
	}
	
	if($cutno==$first_cut)
	{
		//$ex_s12=($c_s12-$o_s12);
		$ex_s12=$ex_s12-$a_s12_ex_qty;
	}
	else
	{
		$ex_s12=0;
		if($cutno==$int_first_cut)
		{
			$ex_s12=$a_s12*$extra_plies;
		}	
	}
	$first_cut=0;
	$sqls="select max(acutno) as firstcut from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\" and a_s14>0";
	$sql_results=mysqli_query($link,$sqls) or exit("Sql Error".mysql_error());
	while($sql_rows=mysqli_fetch_array($sql_results))
	{	
		$first_cut=$sql_rows['firstcut'];	
	}
	
	if($cutno==$first_cut)
	{
		//$ex_s14=($c_s14-$o_s14);
		$ex_s14=$ex_s14-$a_s14_ex_qty;
	}
	else
	{
		$ex_s14=0;
		if($cutno==$int_first_cut)
		{
			$ex_s14=$a_s14*$extra_plies;
		}	
	}
	$first_cut=0;
	$sqls="select max(acutno) as firstcut from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\" and a_s16>0";
	$sql_results=mysqli_query($link,$sqls) or exit("Sql Error".mysql_error());
	while($sql_rows=mysqli_fetch_array($sql_results))
	{	
		$first_cut=$sql_rows['firstcut'];	
	}
	
	if($cutno==$first_cut)
	{
		//$ex_s16=($c_s16-$o_s16);
		$ex_s16=$ex_s16-$a_s16_ex_qty;
	}
	else
	{
		$ex_s16=0;
		if($cutno==$int_first_cut)
		{
			$ex_s16=$a_s16*$extra_plies;
		}	
	}
	$first_cut=0;
	$sqls="select max(acutno) as firstcut from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\" and a_s18>0";
	$sql_results=mysqli_query($link,$sqls) or exit("Sql Error".mysql_error());
	while($sql_rows=mysqli_fetch_array($sql_results))
	{	
		$first_cut=$sql_rows['firstcut'];	
	}
	
	if($cutno==$first_cut)
	{
		//$ex_s18=($c_s18-$o_s18);
		$ex_s18=$ex_s18-$a_s18_ex_qty;
	}
	else
	{
		$ex_s18=0;
		if($cutno==$int_first_cut)
		{
			$ex_s18=$a_s18*$extra_plies;
		}	
	}
	$first_cut=0;
	$sqls="select max(acutno) as firstcut from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\" and a_s20>0";
	$sql_results=mysqli_query($link,$sqls) or exit("Sql Error".mysql_error());
	while($sql_rows=mysqli_fetch_array($sql_results))
	{	
		$first_cut=$sql_rows['firstcut'];	
	}
	
	if($cutno==$first_cut)
	{
		$ex_s20=($c_s20-$o_s20);
	}
	else
	{
		$ex_s20=0;
		if($cutno==$int_first_cut)
		{
			$ex_s20=$a_s20*$extra_plies;
		}	
	}
	$first_cut=0;
	$sqls="select max(acutno) as firstcut from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\" and a_s22>0";
	$sql_results=mysqli_query($link,$sqls) or exit("Sql Error".mysql_error());
	while($sql_rows=mysqli_fetch_array($sql_results))
	{	
		$first_cut=$sql_rows['firstcut'];	
	}
	
	if($cutno==$first_cut)
	{
		$ex_s22=($c_s22-$o_s22);
	}
	else
	{
		$ex_s22=0;
		if($cutno==$int_first_cut)
		{
			$ex_s22=$a_s22*$extra_plies;
		}	
	}
	$first_cut=0;
	$sqls="select max(acutno) as firstcut from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\" and a_s24>0";
	$sql_results=mysqli_query($link,$sqls) or exit("Sql Error".mysql_error());
	while($sql_rows=mysqli_fetch_array($sql_results))
	{	
		$first_cut=$sql_rows['firstcut'];	
	}
	
	if($cutno==$first_cut)
	{
		$ex_s24=($c_s24-$o_s24);
	}
	else
	{
		$ex_s24=0;
		if($cutno==$int_first_cut)
		{
			$ex_s24=$a_s24*$extra_plies;
		}	
	}
	$first_cut=0;
	$sqls="select max(acutno) as firstcut from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\" and a_s26>0";
	$sql_results=mysqli_query($link,$sqls) or exit("Sql Error".mysql_error());
	while($sql_rows=mysqli_fetch_array($sql_results))
	{	
		$first_cut=$sql_rows['firstcut'];	
	}
	
	if($cutno==$first_cut)
	{
		$ex_s26=($c_s26-$o_s26);
	}
	else
	{
		$ex_s26=0;
		if($cutno==$int_first_cut)
		{
			$ex_s26=$a_s26*$extra_plies;
		}	
	}
	$first_cut=0;
	$sqls="select max(acutno) as firstcut from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\" and a_s28>0";
	$sql_results=mysqli_query($link,$sqls) or exit("Sql Error".mysql_error());
	while($sql_rows=mysqli_fetch_array($sql_results))
	{	
		$first_cut=$sql_rows['firstcut'];	
	}
	
	if($cutno==$first_cut)
	{
		$ex_s28=($c_s28-$o_s28);
	}
	else
	{
		$ex_s28=0;
		if($cutno==$int_first_cut)
		{
			$ex_s28=$a_s28*$extra_plies;
		}	
	}
	$first_cut=0;
	$sqls="select max(acutno) as firstcut from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\" and a_s30>0";
	$sql_results=mysqli_query($link,$sqls) or exit("Sql Error".mysql_error());
	while($sql_rows=mysqli_fetch_array($sql_results))
	{	
		$first_cut=$sql_rows['firstcut'];	
	}
	
	if($cutno==$first_cut)
	{
		$ex_s30=($c_s30-$o_s30);
	}
	else
	{
		$ex_s30=0;
		if($cutno==$int_first_cut)
		{
			$ex_s30=$a_s30*$extra_plies;
		}	
	}
	
	echo "<tr class=xl6613019 height=20 style='mso-height-source:userset;height:15.0pt'>
	<td height=20 class=xl6613019 style='height:15.0pt'></td>";
	echo "<td class=xl8613019>".chr($color_code).leading_zeros($cutno, 3)."</td>";
	echo "<td class=xl8713019>".$a_s06."</td>";
	echo "<td class=xl8713019>".$a_s08."</td>";
	echo "<td class=xl8713019>".$a_s10."</td>";
	echo "<td class=xl8713019>".$a_s12."</td>";
	echo "<td class=xl8713019>".$a_s14."</td>";
	echo "<td class=xl8713019>".$a_s16."</td>";
	echo "<td class=xl8713019>".$a_s18."</td>";
	echo "<td class=xl8713019>".$a_s20."</td>";
	echo "<td class=xl8713019>".$a_s22."</td>";
	echo "<td class=xl8713019>".$a_s24."</td>";
	echo "<td class=xl8713019>".$a_s26."</td>";
	echo "<td class=xl8713019>".$a_s28."</td>";
    echo "<td class=xl8713019>".$a_s30."</td>";
	echo "<td class=xl8713019>".$plies."</td>";
	echo "<td class=xl8713019></td>";
	echo "<td class=xl8713019></td>";
	echo "<td class=xl8713019></td>";
	$temp_sum=0;
	echo "<td class=xl8713019>"; if(($a_s06*$plies)<$ex_s06){ echo "0"; $ex_s06=$ex_s06-($a_s06*$plies);} else {echo ($a_s06*$plies)-$ex_s06; $temp_sum=$temp_sum+($a_s06*$plies)-$ex_s06; $ex_s06=0; } echo "</td>";
	echo "<td class=xl8713019>"; if(($a_s08*$plies)<$ex_s08){ echo "0"; $ex_s08=$ex_s08-($a_s08*$plies);} else {echo ($a_s08*$plies)-$ex_s08; $temp_sum=$temp_sum+($a_s08*$plies)-$ex_s08; $ex_s08=0; } echo "</td>";
	echo "<td class=xl8713019>"; if(($a_s10*$plies)<$ex_s10){ echo "0"; $ex_s10=$ex_s10-($a_s10*$plies);} else {echo ($a_s10*$plies)-$ex_s10; $temp_sum=$temp_sum+($a_s10*$plies)-$ex_s10; $ex_s10=0; } echo "</td>";
	echo "<td class=xl8713019>"; if(($a_s12*$plies)<$ex_s12){ echo "0"; $ex_s12=$ex_s12-($a_s12*$plies);} else {echo ($a_s12*$plies)-$ex_s12; $temp_sum=$temp_sum+($a_s12*$plies)-$ex_s12; $ex_s12=0; } echo "</td>";
	echo "<td class=xl8713019>"; if(($a_s14*$plies)<$ex_s14){ echo "0"; $ex_s14=$ex_s14-($a_s14*$plies);} else {echo ($a_s14*$plies)-$ex_s14; $temp_sum=$temp_sum+($a_s14*$plies)-$ex_s14; $ex_s14=0; } echo "</td>";
	echo "<td class=xl8713019>"; if(($a_s16*$plies)<$ex_s16){ echo "0"; $ex_s16=$ex_s16-($a_s16*$plies);} else {echo ($a_s16*$plies)-$ex_s16; $temp_sum=$temp_sum+($a_s16*$plies)-$ex_s16; $ex_s16=0; } echo "</td>";
	echo "<td class=xl8713019>"; if(($a_s18*$plies)<$ex_s18){ echo "0"; $ex_s18=$ex_s18-($a_s18*$plies);} else {echo ($a_s18*$plies)-$ex_s18; $temp_sum=$temp_sum+($a_s18*$plies)-$ex_s18; $ex_s18=0; } echo "</td>";
	echo "<td class=xl8713019>"; if(($a_s20*$plies)<$ex_s20){ echo "0"; $ex_s20=$ex_s20-($a_s20*$plies);} else {echo ($a_s20*$plies)-$ex_s20; $temp_sum=$temp_sum+($a_s20*$plies)-$ex_s20; $ex_s20=0; } echo "</td>";
	echo "<td class=xl8713019>"; if(($a_s22*$plies)<$ex_s22){ echo "0"; $ex_s22=$ex_s22-($a_s22*$plies);} else {echo ($a_s22*$plies)-$ex_s22; $temp_sum=$temp_sum+($a_s22*$plies)-$ex_s22; $ex_s22=0; } echo "</td>";
	echo "<td class=xl8713019>"; if(($a_s24*$plies)<$ex_s24){ echo "0"; $ex_s24=$ex_s24-($a_s24*$plies);} else {echo ($a_s24*$plies)-$ex_s24; $temp_sum=$temp_sum+($a_s24*$plies)-$ex_s24; $ex_s24=0; } echo "</td>";
	echo "<td class=xl8713019>"; if(($a_s26*$plies)<$ex_s26){ echo "0"; $ex_s26=$ex_s26-($a_s26*$plies);} else {echo ($a_s26*$plies)-$ex_s26; $temp_sum=$temp_sum+($a_s26*$plies)-$ex_s26; $ex_s26=0; } echo "</td>";
	echo "<td class=xl8713019>"; if(($a_s28*$plies)<$ex_s28){ echo "0"; $ex_s28=$ex_s28-($a_s28*$plies);} else {echo ($a_s28*$plies)-$ex_s28; $temp_sum=$temp_sum+($a_s28*$plies)-$ex_s28; $ex_s28=0; } echo "</td>";
	echo "<td class=xl8713019>"; if(($a_s30*$plies)<$ex_s30){ echo "0"; $ex_s30=$ex_s30-($a_s30*$plies);} else {echo ($a_s30*$plies)-$ex_s30; $temp_sum=$temp_sum+($a_s30*$plies)-$ex_s30; $ex_s30=0; } echo "</td>";
  
	echo "<td class=xl8713019>".($temp_sum)."</td>";
	echo "<td class=xl8513019>&nbsp;</td>";
	echo "</tr>";
 }
	/*else
	{
	$ex_s06=0;
	$ex_s08=0;
	$ex_s10=0;
	$ex_s12=0;
	$ex_s14=0;
	$ex_s16=0;
	$ex_s18=0;
	$ex_s20=0;
	$ex_s22=0;
	$ex_s24=0;
	$ex_s26=0;
	$ex_s28=0;
	$ex_s30=0;
echo "<tr class=xl6613019 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6613019 style='height:15.0pt'></td>";
   echo "<td class=xl8613019>".chr($color_code).leading_zeros($cutno, 3)."</td>";
   echo "<td class=xl8713019>".$a_s06."</td>";
   echo "<td class=xl8713019>".$a_s08."</td>";
   echo "<td class=xl8713019>".$a_s10."</td>";
   echo "<td class=xl8713019>".$a_s12."</td>";
   echo "<td class=xl8713019>".$a_s14."</td>";
   echo "<td class=xl8713019>".$a_s16."</td>";
   echo "<td class=xl8713019>".$a_s18."</td>";
   echo "<td class=xl8713019>".$a_s20."</td>";
   echo "<td class=xl8713019>".$a_s22."</td>";
   echo "<td class=xl8713019>".$a_s24."</td>";
   echo "<td class=xl8713019>".$a_s26."</td>";
   echo "<td class=xl8713019>".$a_s28."</td>";
    echo "<td class=xl8713019>".$a_s30."</td>";
  echo "<td class=xl8713019>".$plies."</td>";
  echo "<td class=xl8713019></td>";
  echo "<td class=xl8713019></td>";
  echo "<td class=xl8713019></td>";
  $temp_sum=0;
  echo "<td class=xl8713019>"; if(($a_s06*$plies)<$ex_s06){ echo "0"; $ex_s06=$ex_s06-($a_s06*$plies);} else {echo ($a_s06*$plies)-$ex_s06; $temp_sum=$temp_sum+($a_s06*$plies)-$ex_s06; $ex_s06=0; } echo "</td>";
echo "<td class=xl8713019>"; if(($a_s08*$plies)<$ex_s08){ echo "0"; $ex_s08=$ex_s08-($a_s08*$plies);} else {echo ($a_s08*$plies)-$ex_s08; $temp_sum=$temp_sum+($a_s08*$plies)-$ex_s08; $ex_s08=0; } echo "</td>";
echo "<td class=xl8713019>"; if(($a_s10*$plies)<$ex_s10){ echo "0"; $ex_s10=$ex_s10-($a_s10*$plies);} else {echo ($a_s10*$plies)-$ex_s10; $temp_sum=$temp_sum+($a_s10*$plies)-$ex_s10; $ex_s10=0; } echo "</td>";
echo "<td class=xl8713019>"; if(($a_s12*$plies)<$ex_s12){ echo "0"; $ex_s12=$ex_s12-($a_s12*$plies);} else {echo ($a_s12*$plies)-$ex_s12; $temp_sum=$temp_sum+($a_s12*$plies)-$ex_s12; $ex_s12=0; } echo "</td>";
echo "<td class=xl8713019>"; if(($a_s14*$plies)<$ex_s14){ echo "0"; $ex_s14=$ex_s14-($a_s14*$plies);} else {echo ($a_s14*$plies)-$ex_s14; $temp_sum=$temp_sum+($a_s14*$plies)-$ex_s14; $ex_s14=0; } echo "</td>";
echo "<td class=xl8713019>"; if(($a_s16*$plies)<$ex_s16){ echo "0"; $ex_s16=$ex_s16-($a_s16*$plies);} else {echo ($a_s16*$plies)-$ex_s16; $temp_sum=$temp_sum+($a_s16*$plies)-$ex_s16; $ex_s16=0; } echo "</td>";
echo "<td class=xl8713019>"; if(($a_s18*$plies)<$ex_s18){ echo "0"; $ex_s18=$ex_s18-($a_s18*$plies);} else {echo ($a_s18*$plies)-$ex_s18; $temp_sum=$temp_sum+($a_s18*$plies)-$ex_s18; $ex_s18=0; } echo "</td>";
echo "<td class=xl8713019>"; if(($a_s20*$plies)<$ex_s20){ echo "0"; $ex_s20=$ex_s20-($a_s20*$plies);} else {echo ($a_s20*$plies)-$ex_s20; $temp_sum=$temp_sum+($a_s20*$plies)-$ex_s20; $ex_s20=0; } echo "</td>";
echo "<td class=xl8713019>"; if(($a_s22*$plies)<$ex_s22){ echo "0"; $ex_s22=$ex_s22-($a_s22*$plies);} else {echo ($a_s22*$plies)-$ex_s22; $temp_sum=$temp_sum+($a_s22*$plies)-$ex_s22; $ex_s22=0; } echo "</td>";
echo "<td class=xl8713019>"; if(($a_s24*$plies)<$ex_s24){ echo "0"; $ex_s24=$ex_s24-($a_s24*$plies);} else {echo ($a_s24*$plies)-$ex_s24; $temp_sum=$temp_sum+($a_s24*$plies)-$ex_s24; $ex_s24=0; } echo "</td>";
echo "<td class=xl8713019>"; if(($a_s26*$plies)<$ex_s26){ echo "0"; $ex_s26=$ex_s26-($a_s26*$plies);} else {echo ($a_s26*$plies)-$ex_s26; $temp_sum=$temp_sum+($a_s26*$plies)-$ex_s26; $ex_s26=0; } echo "</td>";
echo "<td class=xl8713019>"; if(($a_s28*$plies)<$ex_s28){ echo "0"; $ex_s28=$ex_s28-($a_s28*$plies);} else {echo ($a_s28*$plies)-$ex_s28; $temp_sum=$temp_sum+($a_s28*$plies)-$ex_s28; $ex_s28=0; } echo "</td>";
echo "<td class=xl8713019>"; if(($a_s30*$plies)<$ex_s30){ echo "0"; $ex_s30=$ex_s30-($a_s30*$plies);} else {echo ($a_s30*$plies)-$ex_s30; $temp_sum=$temp_sum+($a_s30*$plies)-$ex_s30; $ex_s30=0; } echo "</td>";
  
  
  echo "<td class=xl8713019>".($temp_sum)."</td>";
echo "<td class=xl8513019>&nbsp;</td>";
echo "</tr>";

}*/
 }
 ?>
 
	<!--
	
	
 <tr class=xl6613019 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6613019 style='height:15.0pt'></td>
  <td class=xl8613019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>&nbsp;</td>
  <td class=xl8713019>&nbsp;</td>
  <td class=xl8713019>&nbsp;</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8713019>CHECK</td>
  <td class=xl8513019>&nbsp;</td>
 </tr>
 
 -->
 
 <tr class=xl6513019 height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl6513019 style='height:15.75pt'></td>
  <td class=xl8913019>&nbsp;</td>
  <td class=xl7613019>&nbsp;</td>
  <td class=xl7613019>&nbsp;</td>
  <td class=xl7613019>&nbsp;</td>
  <td class=xl7613019>&nbsp;</td>
  <td class=xl7613019>&nbsp;</td>
  <td class=xl7613019>&nbsp;</td>
  <td class=xl7613019>&nbsp;</td>
  <td class=xl7613019>&nbsp;</td>
  <td class=xl7613019>&nbsp;</td>
  <td class=xl7613019>&nbsp;</td>
  <td class=xl7613019>&nbsp;</td>
  <td class=xl7613019>&nbsp;</td>
  <td class=xl7613019>&nbsp;</td>
  <td class=xl7613019>&nbsp;</td>
  <td class=xl7613019>&nbsp;</td>
  <td class=xl7613019>&nbsp;</td>
  <td class=xl7613019>&nbsp;</td>
  <td class=xl9013019><?php echo $c_s06; ?></td>
  <td class=xl9013019><?php echo $c_s08; ?></td>
  <td class=xl9013019><?php echo $c_s10; ?></td>
  <td class=xl9013019><?php echo $c_s12; ?></td>
  <td class=xl9013019><?php echo $c_s14; ?></td>
  <td class=xl9013019><?php echo $c_s16; ?></td>
  <td class=xl9013019><?php echo $c_s18; ?></td>
  <td class=xl9013019><?php echo $c_s20; ?></td>
  <td class=xl9013019><?php echo $c_s22; ?></td>
  <td class=xl9013019><?php echo $c_s24; ?></td>
  <td class=xl9013019><?php echo $c_s26; ?></td>
  <td class=xl9013019><?php echo $c_s28; ?></td>
  <td class=xl9013019><?php echo $c_s30; ?></td>
  <td class=xl9013019><?php echo ($c_s06)+($c_s08)+($c_s10)+($c_s12)+($c_s14)+($c_s16)+($c_s18)+($c_s20)+($c_s22)+($c_s24)+($c_s26)+($c_s28)+($c_s30); ?></td>
  <td class=xl8513019>&nbsp;</td>
 </tr>
 <tr class=xl6513019 height=22 style='mso-height-source:userset;height:16.5pt'>
  <td height=22 class=xl6513019 style='height:16.5pt'></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6513019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl9113019><?php if($o_s06>0) {echo round((abs($c_s06-$o_s06)/$o_s06),2)."%";} ?></td>
  <td class=xl9113019><?php if($o_s08>0) {echo round((abs($c_s08-$o_s08)/$o_s08),2)."%";} ?></td>
  <td class=xl9113019><?php if($o_s10>0) {echo round((abs($c_s10-$o_s10)/$o_s10),2)."%";} ?></td>
  <td class=xl9113019><?php if($o_s12>0) {echo round((abs($c_s12-$o_s12)/$o_s12),2)."%";} ?></td>
  <td class=xl9113019><?php if($o_s14>0) {echo round((abs($c_s14-$o_s14)/$o_s14),2)."%";} ?></td>
  <td class=xl9113019><?php if($o_s16>0) {echo round((abs($c_s16-$o_s16)/$o_s16),2)."%";} ?></td>
  <td class=xl9113019><?php if($o_s18>0) {echo round((abs($c_s18-$o_s18)/$o_s18),2)."%";} ?></td>
  <td class=xl9113019><?php if($o_s20>0) {echo round((abs($c_s20-$o_s20)/$o_s20),2)."%";} ?></td>
  <td class=xl9113019><?php if($o_s22>0) {echo round((abs($c_s22-$o_s22)/$o_s22),2)."%";} ?></td>
  <td class=xl9113019><?php if($o_s24>0) {echo round((abs($c_s24-$o_s24)/$o_s24),2)."%";} ?></td>
  <td class=xl9113019><?php if($o_s26>0) {echo round((abs($c_s26-$o_s26)/$o_s26),2)."%";} ?></td>
  <td class=xl9113019><?php if($o_s28>0) {echo round((abs($c_s28-$o_s28)/$o_s28),2)."%";} ?></td>
  <td class=xl9113019><?php if($o_s30>0) {echo round((abs($c_s30-$o_s30)/$o_s30),2)."%";} ?></td>
  <td class=xl9113019>0%</td>
  <td class=xl6513019></td>
 </tr>
 <tr class=xl6513019 height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl6513019 style='height:15.75pt'></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl8513019>&nbsp;</td>
  <td class=xl6513019></td>
 </tr>
 <tr class=xl6513019 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6513019 style='height:15.0pt'></td>
  <td rowspan=2 class=xl10513019 width=70 style='border-bottom:.5pt solid black;
  width:53pt'>Recon.</td>
  <td colspan=2 class=xl10713019 style='border-right:.5pt solid black;
  border-left:none'>Section</td>
  <td colspan=2 class=xl10913019 style='border-right:.5pt solid black;
  border-left:none'>Date Completed</td>
  <td colspan=2 class=xl10913019 style='border-right:.5pt solid black;
  border-left:none'>Fabric Recived</td>
  <td colspan=2 class=xl10913019 style='border-right:.5pt solid black;
  border-left:none'>Cut Qty</td>
  <td colspan=2 class=xl10913019 style='border-right:.5pt solid black;
  border-left:none'>Re-Cut Qty</td>
  <td colspan=2 class=xl10913019 style='border-right:.5pt solid black;
  border-left:none'>Act YY</td>
  <td class=xl9213019>CAD YY</td>
  <td colspan=2 class=xl10713019 style='border-right:.5pt solid black;
  border-left:none'>Act Saving</td>
  <td colspan=2 class=xl10913019 style='border-right:.5pt solid black;
  border-left:none'>Shortage</td>
  <td colspan=2 class=xl10913019 style='border-right:.5pt solid black;
  border-left:none'>Deficit / Surplus</td>
  <td colspan=2 class=xl10913019 style='border-right:.5pt solid black;
  border-left:none'>Reconsilation</td>
  <td class=xl9213019>Sign</td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
 </tr>
 <tr class=xl6513019 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6513019 style='height:15.0pt'></td>
  <td colspan=2 class=xl11013019 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl11213019 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl11213019 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl11213019 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl11213019 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl11213019 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl7613019>&nbsp;</td>
  <td colspan=2 class=xl11013019 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl11213019 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl11213019 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl11213019 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl9313019>&nbsp;</td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6513019 style='height:15.75pt'></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
  <td class=xl6513019></td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=13 style='width:10pt'></td>
  <td width=70 style='width:53pt'></td>
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
  <td width=67 style='width:50pt'></td>
  <td width=51 style='width:38pt'></td>
  <td width=48 style='width:36pt'></td>
  <td width=58 style='width:44pt'></td>
  <td width=48 style='width:36pt'></td>
  <td width=58 style='width:44pt'></td>
  <td width=61 style='width:46pt'></td>
  <td width=48 style='width:36pt'></td>
  <td width=48 style='width:36pt'></td>
  <td width=48 style='width:36pt'></td>
  <td width=45 style='width:34pt'></td>
  <td width=45 style='width:34pt'></td>
  <td width=51 style='width:38pt'></td>
  <td width=55 style='width:41pt'></td>
  <td width=45 style='width:34pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=16 style='width:12pt'></td>
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

$sql="select * from bai_orders_db_confirm where order_tid=\"$order_tid\"";
$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
$sql_num_check=mysqli_num_rows($sql_result);

if($sql_num_check==0)
{
	$sql="insert ignore into bai_orders_db_confirm select * from bai_orders_db where order_tid=\"$order_tid\"";
	$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysql_error());
	//$sql_num_confirm=mysqli_num_rows($sql_result);
}

?>