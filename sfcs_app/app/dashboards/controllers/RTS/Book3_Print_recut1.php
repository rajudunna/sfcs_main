<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); ?>

<?php
$order_tid=$_GET['order_tid'];
$cat_ref=$_GET['cat_ref'];
$doc_id=$_GET['doc_id'];


$cut_table=array("0","T1","T1","T2","T2","T3","T3","T4","T4","T5","T5","T6","T6","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","T7","T7","T8","T8","T9","T9","T10","T10","T11","T11","T12","T12","","","","","","","","","","","","","","");
?>


<?php

$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
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
	$cono=$sql_row['co_no']; //co
	$color_code=$sql_row['color_code']; //Color Code
	$orderno=$sql_row['order_no']; 
	foreach($sizes_array as $key => $size_num){
		$o_sizes[$size_num] = $sql_row['order_s_'.$size_num];
		$all_sizes[$size_num] = $sql_row['title_size_'.$size_num];
	}
	// echo $o_s01;
	$order_total = array_sum($o_sizes);
	$o_sizes = array_filter($o_sizes);
	$all_sizes = array_filter($all_sizes);

// 	$o_s01=$sql_row['order_s_s01'];
// $o_s02=$sql_row['order_s_s02'];
// $o_s03=$sql_row['order_s_s03'];
// $o_s04=$sql_row['order_s_s04'];
// $o_s05=$sql_row['order_s_s05'];
// $o_s06=$sql_row['order_s_s06'];
// $o_s07=$sql_row['order_s_s07'];
// $o_s08=$sql_row['order_s_s08'];
// $o_s09=$sql_row['order_s_s09'];
// $o_s10=$sql_row['order_s_s10'];
// $o_s11=$sql_row['order_s_s11'];
// $o_s12=$sql_row['order_s_s12'];
// $o_s13=$sql_row['order_s_s13'];
// $o_s14=$sql_row['order_s_s14'];
// $o_s15=$sql_row['order_s_s15'];
// $o_s16=$sql_row['order_s_s16'];
// $o_s17=$sql_row['order_s_s17'];
// $o_s18=$sql_row['order_s_s18'];
// $o_s19=$sql_row['order_s_s19'];
// $o_s20=$sql_row['order_s_s20'];
// $o_s21=$sql_row['order_s_s21'];
// $o_s22=$sql_row['order_s_s22'];
// $o_s23=$sql_row['order_s_s23'];
// $o_s24=$sql_row['order_s_s24'];
// $o_s25=$sql_row['order_s_s25'];
// $o_s26=$sql_row['order_s_s26'];
// $o_s27=$sql_row['order_s_s27'];
// $o_s28=$sql_row['order_s_s28'];
// $o_s29=$sql_row['order_s_s29'];
// $o_s30=$sql_row['order_s_s30'];
// $o_s31=$sql_row['order_s_s31'];
// $o_s32=$sql_row['order_s_s32'];
// $o_s33=$sql_row['order_s_s33'];
// $o_s34=$sql_row['order_s_s34'];
// $o_s35=$sql_row['order_s_s35'];
// $o_s36=$sql_row['order_s_s36'];
// $o_s37=$sql_row['order_s_s37'];
// $o_s38=$sql_row['order_s_s38'];
// $o_s39=$sql_row['order_s_s39'];
// $o_s40=$sql_row['order_s_s40'];
// $o_s41=$sql_row['order_s_s41'];
// $o_s42=$sql_row['order_s_s42'];
// $o_s43=$sql_row['order_s_s43'];
// $o_s44=$sql_row['order_s_s44'];
// $o_s45=$sql_row['order_s_s45'];
// $o_s46=$sql_row['order_s_s46'];
// $o_s47=$sql_row['order_s_s47'];
// $o_s48=$sql_row['order_s_s48'];
// $o_s49=$sql_row['order_s_s49'];
// $o_s50=$sql_row['order_s_s50'];

			
// 			$size01 = $sql_row['title_size_s01'];
// 			$size02 = $sql_row['title_size_s02'];
// 			$size03 = $sql_row['title_size_s03'];
// 			$size04 = $sql_row['title_size_s04'];
// 			$size05 = $sql_row['title_size_s05'];
// 			$size06 = $sql_row['title_size_s06'];
// 			$size07 = $sql_row['title_size_s07'];
// 			$size08 = $sql_row['title_size_s08'];
// 			$size09 = $sql_row['title_size_s09'];
// 			$size10 = $sql_row['title_size_s10'];
// 			$size11 = $sql_row['title_size_s11'];
// 			$size12 = $sql_row['title_size_s12'];
// 			$size13 = $sql_row['title_size_s13'];
// 			$size14 = $sql_row['title_size_s14'];
// 			$size15 = $sql_row['title_size_s15'];
// 			$size16 = $sql_row['title_size_s16'];
// 			$size17 = $sql_row['title_size_s17'];
// 			$size18 = $sql_row['title_size_s18'];
// 			$size19 = $sql_row['title_size_s19'];
// 			$size20 = $sql_row['title_size_s20'];
// 			$size21 = $sql_row['title_size_s21'];
// 			$size22 = $sql_row['title_size_s22'];
// 			$size23 = $sql_row['title_size_s23'];
// 			$size24 = $sql_row['title_size_s24'];
// 			$size25 = $sql_row['title_size_s25'];
// 			$size26 = $sql_row['title_size_s26'];
// 			$size27 = $sql_row['title_size_s27'];
// 			$size28 = $sql_row['title_size_s28'];
// 			$size29 = $sql_row['title_size_s29'];
// 			$size30 = $sql_row['title_size_s30'];
// 			$size31 = $sql_row['title_size_s31'];
// 			$size32 = $sql_row['title_size_s32'];
// 			$size33 = $sql_row['title_size_s33'];
// 			$size34 = $sql_row['title_size_s34'];
// 			$size35 = $sql_row['title_size_s35'];
// 			$size36 = $sql_row['title_size_s36'];
// 			$size37 = $sql_row['title_size_s37'];
// 			$size38 = $sql_row['title_size_s38'];
// 			$size39 = $sql_row['title_size_s39'];
// 			$size40 = $sql_row['title_size_s40'];
// 			$size41 = $sql_row['title_size_s41'];
// 			$size42 = $sql_row['title_size_s42'];
// 			$size43 = $sql_row['title_size_s43'];
// 			$size44 = $sql_row['title_size_s44'];
// 			$size45 = $sql_row['title_size_s45'];
// 			$size46 = $sql_row['title_size_s46'];
// 			$size47 = $sql_row['title_size_s47'];
// 			$size48 = $sql_row['title_size_s48'];
// 			$size49 = $sql_row['title_size_s49'];
// 			$size50 = $sql_row['title_size_s50'];
			
			$flag = $sql_row['title_flag'];
			if($flag == 0)
			{
				$size01 = '01';
				$size02 = '02';
				$size03 = '03';
				$size04 = '04';
				$size05 = '05';
				$size06 = '06';
				$size07 = '07';
				$size08 = '08';
				$size09 = '09';
				$size10 = '10';
				$size11 = '11';
				$size12 = '12';
				$size13 = '13';
				$size14 = '14';
				$size15 = '15';
				$size16 = '16';
				$size17 = '17';
				$size18 = '18';
				$size19 = '19';
				$size20 = '20';
				$size21 = '21';
				$size22 = '22';
				$size23 = '23';
				$size24 = '24';
				$size25 = '25';
				$size26 = '26';
				$size27 = '27';
				$size28 = '28';
				$size29 = '29';
				$size30 = '30';
				$size31 = '31';
				$size32 = '32';
				$size33 = '33';
				$size34 = '34';
				$size35 = '35';
				$size36 = '36';
				$size37 = '37';
				$size38 = '38';
				$size39 = '39';
				$size40 = '40';
				$size41 = '41';
				$size42 = '42';
				$size43 = '43';
				$size44 = '44';
				$size45 = '45';
				$size46 = '46';
				$size47 = '47';
				$size48 = '48';
				$size49 = '49';
				$size50 = '50';
			}
// $order_total=$o_s01+$o_s02+$o_s03+$o_s04+$o_s05+$o_s06+$o_s07+$o_s08+$o_s09+$o_s10+$o_s11+$o_s12+$o_s13+$o_s14+$o_s15+$o_s16+$o_s17+$o_s18+$o_s19+$o_s20+$o_s21+$o_s22+$o_s23+$o_s24+$o_s25+$o_s26+$o_s27+$o_s28+$o_s29+$o_s30+$o_s31+$o_s32+$o_s33+$o_s34+$o_s35+$o_s36+$o_s37+$o_s38+$o_s39+$o_s40+$o_s41+$o_s42+$o_s43+$o_s44+$o_s45+$o_s46+$o_s47+$o_s48+$o_s49+$o_s50;
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
	$cuttable_total=$c_s06+$c_s08+$c_s10+$c_s12+$c_s14+$c_s16+$c_s18+$c_s20+$c_s22+$c_s24+$c_s26+$c_s28+$c_s30;
}
*/

?>

<?php

$sql="select * from $bai_pro3.recut_V2 where order_tid=\"$order_tid\" and cat_ref=$cat_ref and doc_no=$doc_id";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{

	foreach($sizes_array as $key => $size_num){
		$a_sizes[$size_num] = $sql_row['a_'.$size_num];
		$p_sizes[$size_num] = $sql_row['p_'.$size_num];
	}

	$a_ratio_tot= array_sum($a_sizes);
	$a_sizes= array_filter($a_sizes);
	$p_sizes= array_filter($p_sizes);
	$cutno=$sql_row['acutno'];
	$plies=$sql_row['a_plies']; //20110911
	$docketno=$sql_row['doc_no'];
	$docketdate=$sql_row['date'];
	$mk_ref=$sql_row['mk_ref'];
	$remarks=$sql_row['remarks'];
	$plan_module=$sql_row['plan_module'];
	$lot_ref=$sql_row['plan_lot_ref'];
	$print_status = $sql_row['print_status'];
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
		if($available>0 and $temp>0)
		{
			if($available>=$temp and $temp>0)
			{
				$sql11="update bai_rm_pj1.sticker_report set allocated_qty=".($sql_row1['allocated_qty']+$temp)." where lot_no=\"$lot_no\"";
				$sql_result11=mysql_query($sql11,$link) or exit("Sql Error".mysql_error());
				$lot_ref.=$lot_no.">".$location.";";
				$temp=0;
			}
			else
			{
				$temp-=$available;
				$sql11="update bai_rm_pj1.sticker_report set allocated_qty=".($sql_row1['rec_qty'])." where lot_no=\"$lot_no\"";
				$sql_result11=mysql_query($sql11,$link) or exit("Sql Error".mysql_error());
				$lot_ref.=$lot_no.">".$location.";";
			}
		}
	}
}
*/
if($category=='Body' || $category=='Front')
	{
		$sql2="select COALESCE(binding_con,0) as \"binding_con\" from $bai_pro3.bai_orders_db_remarks where order_tid=\"$order_tid\"";
		// echo $sql2;
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rows=mysqli_num_rows($sql_result2);
		if($rows > 0)
		{
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$binding_con = $sql_row2['binding_con'];
				$bind_con= $binding_con *($a_ratio_tot*$plies);
			}
		}
		else
		{
			$bind_con=0;
		}
	}
	else
	{
		$bind_con=0;
		
	}
//To allocate Lot Number for RM Issuing
?>


<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<title>DOCKET VIEW</title>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 14">
<link rel=File-List href="DOCKET_NEW_files/filelist.xml">
<style id="DOCKET_NEW_4118_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl154118
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
.xl654118
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
.xl664118
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
.xl674118
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
.xl684118
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
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl694118
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
.xl704118
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
.xl714118
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
.xl724118
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
.xl734118
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
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl744118
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
.xl754118
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
.xl764118
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
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl774118
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
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl784118
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
.xl794118
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
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl804118
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
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl814118
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
.xl824118
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
	mso-number-format:Fixed;
	text-align:left;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl834118
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
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl844118
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
.xl854118
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
.xl864118
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
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl874118
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
	border-left:.5pt solid windowtext;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl884118
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
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl894118
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl904118
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
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
	.xl904118x
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
	border-top:none;
	border-right:none;
	border-bottom:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl914118
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl924118
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl934118
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
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl944118
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
	mso-number-format:"Short Date";
	text-align:left;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl954118
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
	text-align:left;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl964118
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
	mso-number-format:"Short Date";
	text-align:left;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl974118
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
	mso-number-format:0;
	text-align:left;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl984118
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl994118
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
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1004118
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
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1014118
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
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1024118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\@";
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1034118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\@";
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1044118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\@";
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1054118
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
	border:.5pt solid windowtext;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1064118
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
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1074118
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
.xl1084118
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
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1094118
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
	text-align:left;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1104118
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
	mso-number-format:"dd\/mmm";
	text-align:left;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1114118
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
	mso-number-format:"dd\/mmm";
	text-align:left;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1124118
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
	border-top:.5pt solid black;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1134118
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
	border-bottom:.5pt solid black;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1144118
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
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1154118
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
	border-bottom:.5pt solid black;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1164118
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
.xl1174118
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
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1184118
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
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1194118
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
	mso-number-format:0;
	text-align:left;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1204118
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
	mso-number-format:0;
	text-align:left;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1214118
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
	text-align:left;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1224118
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
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1234118
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
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1244118
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
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1254118
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
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1264118
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
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1274118
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
	border-right:none;
	border-bottom:none;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1284118
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
	border-right:1.0pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1294118
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
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1304118
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
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1314118
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
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
-->
body{
	zoom:82%;
}

</style>

<style type="text/css">
@page
{
	size: potrait;
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
body { zoom:82%;}
#ad{ display:none;}
#leftbar{ display:none;}
#DOCKET_NEW_4118{ width:82%; margin-left:2px; margin-right:2px;}
}
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

<script src=<?= getFullURLLevel($_GET['r'],'common/js/jquery-1.3.2.js',2,'R'); ?>></script>
<script src=<?= getFullURLLevel($_GET['r'],'common/js/jquery-barcode-2.0.1.js',2,'R'); ?>></script>
</head>

<body onload="printpr();">

<script language="JavaScript">
<!--

//Disable right mouse click Script
//By Maximus (maximus@nsimail.com) w/ mods by DynamicDrive
//For full source code, visit http://www.dynamicdrive.com

var message="Function Disabled!";


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
<!--The following information was generated by Microsoft Excel's Publish as Web
Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<div id="DOCKET_NEW_4118" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=1008 style='border-collapse:
 collapse;width:756pt'>
 <col width=24 style='mso-width-source:userset;mso-width-alt:877;width:18pt'>
 <col class=xl654118 width=64 span=6 style='mso-width-source:userset;
 mso-width-alt:2340;width:48pt'>
 <col class=xl654118 width=67 style='mso-width-source:userset;mso-width-alt:
 2450;width:50pt'>
 <col class=xl654118 width=64 span=5 style='mso-width-source:userset;
 mso-width-alt:2340;width:48pt'>
 <col width=64 span=3 style='width:48pt'>
 <col width=21 style='mso-width-source:userset;mso-width-alt:768;width:16pt'>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl664118 width=24 style='height:15.75pt;width:18pt' colspan="8"><a
  name="RANGE!A1:Q57"></a><?php echo '<div id="bcTarget1" style="width:auto;"></div><script>$("#bcTarget1").barcode("R'.$doc_id.'", "code39",{barWidth:2,barHeight:15,moduleSize:5,fontSize:0});</script>'; ?></td>
  <!-- <td class=xl654118 width=64 style='width:48pt'></td>
  <td class=xl654118 width=64 style='width:48pt'></td>
  <td class=xl654118 width=64 style='width:48pt'></td>
  <td class=xl654118 width=64 style='width:48pt'></td>
  <td class=xl654118 width=64 style='width:48pt'></td>
  <td class=xl654118 width=64 style='width:48pt'></td>
  <td class=xl654118 width=67 style='width:50pt'></td> -->
  <td class=xl654118 width=64 style='width:48pt'></td>
  <td class=xl654118 width=64 style='width:48pt'></td>
  <td class=xl654118 width=64 style='width:48pt'></td>
  <td class=xl654118 width=64 style='width:48pt'></td>
  <td class=xl654118 width=64 style='width:48pt'></td>
  <td class=xl654118 width=64 style='width:48pt'></td>
  <td class=xl154118 width=64 style='width:48pt'></td>
  <td class=xl154118 width=64 style='width:48pt'></td>
  <td class=xl154118 width=21 style='width:16pt'></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td colspan=6 rowspan=3 class=xl674118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td colspan=3 class=xl844118>Cutting Department</td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=26 style='mso-height-source:userset;height:19.5pt'>
  <td height=26 class=xl654118 style='height:19.5pt'></td>
  <td class=xl654118></td>
  <td class=xl1014118></td>
  <td class=xl1014118></td>
  <td class=xl1014118></td>
  <td class=xl1014118></td>
  <td colspan=3 class=xl1224118><?php if($_GET['type']==1){ echo "Sample"; } else { echo "Recut"; } ?> Docket</td>
  <td class=xl1014118></td>
  <td class=xl1014118></td>
  <td colspan=2 class=xl1164118 style='border-right:.5pt solid black'>Docket
  Number</td>
  <td colspan=3 class=xl1024118 style='border-right:.5pt solid black;
  border-left:none'><?php echo leading_zeros($docketno,9); ?></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=23 style='mso-height-source:userset;height:17.25pt'>
  <td height=23 class=xl654118 style='height:17.25pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118 colspan=3 align=center><strong><?php if($print_status=="0000-00-00" || $print_status == '') {echo "ORIGINAL"; } else {echo "DUPLICATE";}?></strong></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl914118>Cut No :</td>
  <td colspan=2 class=xl1214118><?php echo "R".leading_zeros($cutno, 3); ?></td>
  <td class=xl924118>Date:</td>
  <td class=xl944118><?php echo $docketdate; ?></td>
  <td class=xl964118></td>
  <td colspan=2 class=xl914118>Category :</td>
  <td colspan=4 class=xl1214118><?php echo $category; ?></td>
  <td class=xl984118>&nbsp;</td>
  <td class=xl984118>&nbsp;</td>
  <td class=xl994118>&nbsp;</td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl904118>Style No :</td>
  <td colspan=2 class=xl954118 style='border-right:.5pt solid black'><?php echo $style; ?></td>
  <td class=xl904118x>Module:</td>
  <td class=xl954118><?php echo $plan_module; echo " (".$cut_table[$plan_module].")"; ?></td>
  <td class=xl904118></td>
  <td colspan=2 class=xl904118>Fab Code :</td>
  <td colspan=4 class=xl954118><?php echo $compo_no ?></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl1004118>&nbsp;</td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl904118>Sch No :</td>
  <td colspan=2 class=xl954118 style='border-right:.5pt solid black'><?php echo $delivery.chr($color_code); ?></td>
  <td colspan=1 class=xl904118>Consumption :</td>
  <td colspan=1 class=xl954118 style='border-right:1px solid'><?php echo $body_yy; ?></td>
  <td class=xl954118></td>	
  <td colspan=2 class=xl904118>Fab Descrip :</td>
  <td colspan=7 class=xl954118 style='border-right:.5pt solid black'><?php echo $fab_des; ?></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl904118>Color :</td>
  <td colspan=4 class=xl954118 style='border-right:.5pt solid black'><?php echo $color." / ".$col_des; ?></td>
  <td class=xl954118></td>
  <td colspan=2 class=xl904118>MK Name :</td>
  <td colspan=4 class=xl954118><?php echo $mk_remarks; ?></td>	
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl1004118>&nbsp;</td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl934118>PO :</td>
  <td class=xl1194118 style='border-right:.5pt solid black'><?php echo $pono; ?></td>
   <td class=xl934118>CO :</td>
  <td colspan=2 class=xl1194118 style='border-right:.5pt solid black'><?php echo $cono; ?></td>
  <td class=xl974118></td>
  <td colspan=2 class=xl934118>Fab Direction :</td>
  <td colspan=7 class=xl1104118 style='border-right:.5pt solid black'><?php if($gmtway=="Y") { echo "One Gmt One Way"; } else  { echo "All Gmt One Way"; }?></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl674118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=11 style='mso-height-source:userset;height:8.25pt'>
  <td height=11 class=xl654118 style='height:8.25pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl674118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118>Size</td>
<?php
	foreach ($all_sizes as $size_key => $size_value) {
		echo "<td class=xl694118>".$size_value."</td>";
	}
?>
  <td class=xl714118  >Total</td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118>Ratio</td>
<?php
	foreach ($a_sizes as $a_size_key => $a_size_value) {
		echo "<td class=xl734118>".$a_size_value."</td>";
	}
?>
  <td class=xl754118><?php echo $a_ratio_tot; ?></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118>Quantity</td>
<?php
	$excess_data = '';
	foreach ($a_sizes as $a_size_key => $a_size_value) {
		$sum_of_a_p_sizes[] = ($a_size_value*$plies)-$p_sizes[$a_size_key];
		echo "<td class=xl734118>".$a_size_value*$plies."</td>";
		$excess_data .= "<td class=xl734118 style='border:.5pt solid windowtext;'>".(($a_size_value*$plies)-$p_sizes[$a_size_key])."</td>";
	}
?>
  <td class=xl754118><?php echo ($a_ratio_tot*$plies); ?></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118 style="border:.5pt solid windowtext;">Excess</td>
<?php
	echo $excess_data;
?>
  <td class=xl754118 style="border:.5pt solid windowtext;"><?php echo array_sum($sum_of_a_p_sizes) ?></td>
  <td class=xl654118></td>
 </tr>
 
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl674118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl674118 style='height:15.0pt'></td>
  <td class=xl764118>Rpt No</td>
  <td class=xl774118>Batch No</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Shrinkage Group</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Color Group</td>
  <td class=xl774118>Width</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Marker Length</td>
  <td rowspan=2 class=xl1144118 width=67 style='border-bottom:.5pt solid black;
  width:50pt'>Pattern Version</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>No of Plies</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Required Qty (<?php echo $fab_uom; ?>)</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Issued Qty (<?php echo $fab_uom; ?>)</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Return Qty (<?php echo $fab_uom; ?>)</td>
  <td class=xl674118></td>
  <td class=xl674118></td>
  <td class=xl674118></td>
  <td class=xl674118></td>
  <td class=xl674118></td>
 </tr>
 <tr class=xl674118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl674118 style='height:15.0pt'></td>
  <td class=xl724118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl674118></td>
  <td class=xl674118></td>
  <td class=xl674118></td>
  <td class=xl674118></td>
  <td class=xl674118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td rowspan=2 class=xl1184118 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'>&nbsp;</td>
  <td rowspan=2 class=xl1184118 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><span style='mso-spacerun:yes'></span></td>
  <td rowspan=2 class=xl1124118 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'>&nbsp;</td>
  <td rowspan=2 class=xl1124118 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'>&nbsp;</td>
  <td rowspan=2 class=xl1184118 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php echo $purwidth; ?></td>
  <td rowspan=2 class=xl1124118 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php echo $mklength; ?></td>
  <td rowspan=2 class=xl1124118 width=67 style='border-bottom:.5pt solid black;
  border-top:none;width:50pt'><?php echo $patt_ver; ?></td>
  <td rowspan=2 class=xl1124118 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php echo $plies ?></td>
  <td rowspan=2 class=xl1124118 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php echo round((($mklength*$plies)+$bind_con),2); ?></td>
  <td rowspan=2 class=xl1124118 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'>&nbsp;</td>
  <td rowspan=2 class=xl1124118 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'>&nbsp;</td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 
 <?php
 /*
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl784118>Roll No</td>
  <td class=xl794118>&nbsp;</td>
  <td class=xl794118>&nbsp;</td>
  <td class=xl794118>&nbsp;</td>
  <td class=xl794118>&nbsp;</td>
  <td class=xl794118>&nbsp;</td>
  <td class=xl784118 style='border-left:none' ></td>
 <td class=xl844118 colspan=4 rowspan=5><?php echo $lot_ref; ?></td>
  <!-- <td class=xl654118></td>
  <td class=xl654118></td> 
  <td class=xl654118></td>-->
  <td class=xl654118></td>
  <td colspan=3 rowspan=5 class=xl1244118 style='border-right:1.0pt solid black;
  border-bottom:1.0pt solid black'>Fabric Swatch</td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl804118>Width</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl784118 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl844118></td>
  <!-- <td class=xl824118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td> -->
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl804118>Length</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl784118 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl844118></td>
  <!-- <td class=xl824118></td>
  <td class=xl654118></td>
  <td class=xl654118></td> 
  <td class=xl654118></td> -->
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl834118>Batch No</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl784118 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl844118></td>
  <!-- <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td> 
  <td class=xl654118></td>-->
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl834118>Loc No</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl854118>&nbsp;</td>
  <td class=xl844118></td>
  <td class=xl844118></td>
  <td class=xl844118></td>
  <td class=xl844118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 */
 ?>
 
 
 <?php

echo "<tr class=xl654118  style='mso-height-source:userset;'>";
 
echo "<td class=xl654118 ></td><td colspan=13>";
$roll_det=array();
$width_det=array();
$leng_det=array();
$batch_det=array();
$shade_det=array();
$locan_det=array();
$lot_det=array();
$roll_id=array();
$ctex_len=array();
$tkt_len=array();
$sql="select * from $bai_rm_pj1.docket_ref where doc_no=$doc_id and doc_type='recut'";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{

$roll_det[]=$sql_row['ref2'];
$width_det[]=round($sql_row['roll_width'],2);
$leng_det[]=$sql_row['allocated_qty'];
$batch_det[]=trim($sql_row['batch_no']);
$shade_det[]=$sql_row['ref4']."-".$sql_row['inv_no'];
$locan_det[]=$sql_row['ref1'];
$lot_det[]=$sql_row['lot_no'];
$roll_id[]=$sql_row['roll_id'];
$ctex_len[]=$sql_row['ref5'];
$tkt_len[]=$sql_row['qty_rec'];
} 

echo "<table style='font-size:16px; border:.5pt solid black; border-collapse: collapse;'>";

echo "<tr><td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> Roll No</td>";

for($i=0;$i<sizeof($roll_det);$i++)
{
	echo "<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$roll_det[$i]."</td>";
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
echo "<tr><td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>Label ID</td>";

for($i=0;$i<sizeof($roll_det);$i++)
{
	//2012-06-12 New implementation to get fabric detail based on invoce/batch
	//echo "<td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'>".$lot_det[$i]."</td>";
	echo "<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$roll_id[$i]."</td>";
}
echo "</tr>";





echo "<tr><td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> Width</td>";

for($i=0;$i<sizeof($roll_det);$i++)
{
	echo "<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$width_det[$i]."</td>";
}
echo "</tr>";

echo "<tr><td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>Allocated Length</td>";

for($i=0;$i<sizeof($roll_det);$i++)
{
	echo "<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$leng_det[$i]."</td>";
}
echo "</tr>";

echo "<tr><td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> Batch</td>";

for($i=0;$i<sizeof($roll_det);$i++)
{
	echo "<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$batch_det[$i]."</td>";
}
echo "</tr>";

echo "<tr><td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> Shade</td>";

for($i=0;$i<sizeof($roll_det);$i++)
{
	echo "<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$shade_det[$i]."</td>";
}
echo "</tr>";


echo "<tr><td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> Location</td>";

for($i=0;$i<sizeof($roll_det);$i++)
{
	echo "<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$locan_det[$i]."</td>";
}
echo "</tr>";

echo "<tr><td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> C-Tex Length</td>";

for($i=0;$i<sizeof($roll_det);$i++)
{
	echo "<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$ctex_len[$i]."</td>";
}
echo "</tr>";

echo "<tr><td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'> Ticket Length</td>";

for($i=0;$i<sizeof($roll_det);$i++)
{
	echo "<td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'>".$tkt_len[$i]."</td>";
}
echo "</tr>";


echo "<tr><td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> Length Variation</td>";

for($i=0;$i<sizeof($roll_det);$i++)
{
	echo "<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".round(($ctex_len[$i]-$tkt_len[$i]),2)."</td>";
}
echo "</tr>";

echo "</table>";
echo $lot_ref; 
echo "</td>";
echo "</tr>";

 ?>
 
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl6315551 colspan="3"><u><strong>Quality Authorisation</strong></u></td>
 </tr>
 <tr class=xl674118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl674118 style='height:15.0pt'></td>
  <td class=xl764118>Group</td>
  <td class=xl774118>Roll No</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Ticket Length</td>
  <td class=xl774118>Plies</td>
  <td class=xl774118>Damage</td>
  <td class=xl774118>Joints</td>
  <td class=xl774118>Ends</td>
  <td class=xl774118>Shortages</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Net Length</td>
  <td colspan=6 rowspan=2 class=xl1064118>Comments</td>
  <td class=xl674118></td>
 </tr>
 <tr class=xl674118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl674118 style='height:15.0pt'></td>
  <td class=xl724118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl744118>Excess</td>
  <td class=xl674118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td colspan=6 class=xl684118 style='border-left:none'>&nbsp;</td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td colspan=6 class=xl684118 style='border-left:none'>&nbsp;</td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td colspan=6 class=xl684118 style='border-left:none'>&nbsp;</td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td colspan=6 class=xl684118 style='border-left:none'>&nbsp;</td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td colspan=6 class=xl684118 style='border-left:none'>&nbsp;</td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td colspan=6 class=xl684118 style='border-left:none'>&nbsp;</td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td colspan=6 class=xl684118 style='border-left:none'>&nbsp;</td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td colspan=6 class=xl684118 style='border-left:none'>&nbsp;</td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td colspan=6 class=xl684118 style='border-left:none'>&nbsp;</td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td colspan=6 class=xl684118 style='border-left:none'>&nbsp;</td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td colspan=6 class=xl684118 style='border-left:none'>&nbsp;</td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td colspan=6 class=xl684118 style='border-left:none'>&nbsp;</td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td colspan=6 class=xl684118 style='border-left:none'>&nbsp;</td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td colspan=6 class=xl684118 style='border-left:none'>&nbsp;</td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td colspan=6 class=xl684118 style='border-left:none'>&nbsp;</td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl874118>&nbsp;</td>
  <td class=xl884118>&nbsp;</td>
  <td class=xl884118>&nbsp;</td>
  <td class=xl884118>&nbsp;</td>
  <td class=xl884118>&nbsp;</td>
  <td class=xl884118>&nbsp;</td>
  <td class=xl884118>&nbsp;</td>
  <td class=xl884118>&nbsp;</td>
  <td class=xl884118>&nbsp;</td>
  <td colspan=6 class=xl1054118 style='border-left:none'>&nbsp;</td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118></td>
  <td class=xl684118>Docket</td>
  <td class=xl704118>Marker</td>
  <td class=xl704118>Issuing</td>
  <td class=xl704118>Laying</td>
  <td class=xl704118>Cutting</td>
  <td class=xl704118>Return</td>
  <td class=xl704118>Bundling</td>
  <td class=xl704118>Dispatch</td>
  <td class=xl654118>Act Con</td>
  <td class=xl864118>&nbsp;</td>
  <td class=xl864118>&nbsp;</td>
  <td class=xl864118>&nbsp;</td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118>Team</td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl654118>Saving %</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118>EMP No1</td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl654118>Reason</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118>Emp No2</td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl654118>Approved</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118>Emp No3</td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118>Date</td>
  <td class=xl804118><?php echo date("y/m-d",strtotime($plan_log_time)); ?></td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118>Time</td>
  <td class=xl804118><?php echo date("H:i",strtotime($plan_log_time)); ?></td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl154118 style='height:15.75pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl154118></td>
  <td class=xl154118></td>
  <td class=xl154118></td>
  <td class=xl154118></td>
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
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=21 style='width:16pt'></td>
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

	if($print_status=="0000-00-00" || $print_status == '') {
		$sql="update $bai_pro3.recut_V2 set print_status=\"".date("Y-m-d")."\" where doc_no=$docketno";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
?>