<?php include('../../../../common/config/config.php'); ?>
<?php include('../../../../common/config/functions.php'); ?>
<?php
$order_tid=$_GET['order_tid'];
$cat_ref=$_GET['cat_ref'];	
$doc_id=$_GET['doc_id'];
?>
<?php

$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";

$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
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
	$o_s01=$sql_row['order_s_s01'];
	$o_s02=$sql_row['order_s_s02'];
	$o_s03=$sql_row['order_s_s03'];
	$o_s04=$sql_row['order_s_s04'];
	$o_s05=$sql_row['order_s_s05'];
	$o_s06=$sql_row['order_s_s06'];
	$o_s07=$sql_row['order_s_s07'];
	$o_s08=$sql_row['order_s_s08'];
	$o_s09=$sql_row['order_s_s09'];
	$o_s10=$sql_row['order_s_s10'];
	$o_s11=$sql_row['order_s_s11'];
	$o_s12=$sql_row['order_s_s12'];
	$o_s13=$sql_row['order_s_s13'];
	$o_s14=$sql_row['order_s_s14'];
	$o_s15=$sql_row['order_s_s15'];
	$o_s16=$sql_row['order_s_s16'];
	$o_s17=$sql_row['order_s_s17'];
	$o_s18=$sql_row['order_s_s18'];
	$o_s19=$sql_row['order_s_s19'];
	$o_s20=$sql_row['order_s_s20'];
	$o_s21=$sql_row['order_s_s21'];
	$o_s22=$sql_row['order_s_s22'];
	$o_s23=$sql_row['order_s_s23'];
	$o_s24=$sql_row['order_s_s24'];
	$o_s25=$sql_row['order_s_s25'];
	$o_s26=$sql_row['order_s_s26'];
	$o_s27=$sql_row['order_s_s27'];
	$o_s28=$sql_row['order_s_s28'];
	$o_s29=$sql_row['order_s_s29'];
	$o_s30=$sql_row['order_s_s30'];
	$o_s31=$sql_row['order_s_s31'];
	$o_s32=$sql_row['order_s_s32'];
	$o_s33=$sql_row['order_s_s33'];
	$o_s34=$sql_row['order_s_s34'];
	$o_s35=$sql_row['order_s_s35'];
	$o_s36=$sql_row['order_s_s36'];
	$o_s37=$sql_row['order_s_s37'];
	$o_s38=$sql_row['order_s_s38'];
	$o_s39=$sql_row['order_s_s39'];
	$o_s40=$sql_row['order_s_s40'];
	$o_s41=$sql_row['order_s_s41'];
	$o_s42=$sql_row['order_s_s42'];
	$o_s43=$sql_row['order_s_s43'];
	$o_s44=$sql_row['order_s_s44'];
	$o_s45=$sql_row['order_s_s45'];
	$o_s46=$sql_row['order_s_s46'];
	$o_s47=$sql_row['order_s_s47'];
	$o_s48=$sql_row['order_s_s48'];
	$o_s49=$sql_row['order_s_s49'];
	$o_s50=$sql_row['order_s_s50'];

	$order_total=$o_s01+$o_s02+$o_s03+$o_s04+$o_s05+$o_s06+$o_s07+$o_s08+$o_s09+$o_s10+$o_s11+$o_s12+$o_s13+$o_s14+$o_s15+$o_s16+$o_s17+$o_s18+$o_s19+$o_s20+$o_s21+$o_s22+$o_s23+$o_s24+$o_s25+$o_s26+$o_s27+$o_s28+$o_s29+$o_s30+$o_s31+$o_s32+$o_s33+$o_s34+$o_s35+$o_s36+$o_s37+$o_s38+$o_s39+$o_s40+$o_s41+$o_s42+$o_s43+$o_s44+$o_s45+$o_s46+$o_s47+$o_s48+$o_s49+$o_s50;

		for($s=0;$s<sizeof($sizes_code);$s++)
		{
		
			$o_s[$sizes_code[$s]]=$sql_row["order_s_s".$sizes_code[$s].""];
			//}
		}
		for($s=0;$s<sizeof($sizes_code);$s++)
		{
			if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
			{
				$s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
			}
		}	

			$size01 = $sql_row['title_size_s01'];
			$size02 = $sql_row['title_size_s02'];
			$size03 = $sql_row['title_size_s03'];
			$size04 = $sql_row['title_size_s04'];
			$size05 = $sql_row['title_size_s05'];
			$size06 = $sql_row['title_size_s06'];
			$size07 = $sql_row['title_size_s07'];
			$size08 = $sql_row['title_size_s08'];
			$size09 = $sql_row['title_size_s09'];
			$size10 = $sql_row['title_size_s10'];
			$size11 = $sql_row['title_size_s11'];
			$size12 = $sql_row['title_size_s12'];
			$size13 = $sql_row['title_size_s13'];
			$size14 = $sql_row['title_size_s14'];
			$size15 = $sql_row['title_size_s15'];
			$size16 = $sql_row['title_size_s16'];
			$size17 = $sql_row['title_size_s17'];
			$size18 = $sql_row['title_size_s18'];
			$size19 = $sql_row['title_size_s19'];
			$size20 = $sql_row['title_size_s20'];
			$size21 = $sql_row['title_size_s21'];
			$size22 = $sql_row['title_size_s22'];
			$size23 = $sql_row['title_size_s23'];
			$size24 = $sql_row['title_size_s24'];
			$size25 = $sql_row['title_size_s25'];
			$size26 = $sql_row['title_size_s26'];
			$size27 = $sql_row['title_size_s27'];
			$size28 = $sql_row['title_size_s28'];
			$size29 = $sql_row['title_size_s29'];
			$size30 = $sql_row['title_size_s30'];
			$size31 = $sql_row['title_size_s31'];
			$size32 = $sql_row['title_size_s32'];
			$size33 = $sql_row['title_size_s33'];
			$size34 = $sql_row['title_size_s34'];
			$size35 = $sql_row['title_size_s35'];
			$size36 = $sql_row['title_size_s36'];
			$size37 = $sql_row['title_size_s37'];
			$size38 = $sql_row['title_size_s38'];
			$size39 = $sql_row['title_size_s39'];
			$size40 = $sql_row['title_size_s40'];
			$size41 = $sql_row['title_size_s41'];
			$size42 = $sql_row['title_size_s42'];
			$size43 = $sql_row['title_size_s43'];
			$size44 = $sql_row['title_size_s44'];
			$size45 = $sql_row['title_size_s45'];
			$size46 = $sql_row['title_size_s46'];
			$size47 = $sql_row['title_size_s47'];
			$size48 = $sql_row['title_size_s48'];
			$size49 = $sql_row['title_size_s49'];
			$size50 = $sql_row['title_size_s50'];
			$flag = $sql_row['title_flag'];
}

$sql="select * from $bai_pro3.plan_dashboard where doc_no='$doc_id'";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$plan_log_time=$sql_row['log_time'];
}
	
$sql="select * from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and tid=$cat_ref";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$category=$sql_row['category'];
	$plies=$sql_row['plies'];
	$gmtway=$sql_row['gmtway'];
	$fab_des=$sql_row['fab_des'];
	$body_yy=$sql_row['catyy'];
	$waist_yy=$sql_row['Waist_yy'];
	$leg_yy=$sql_row['Leg_yy'];
	$purwidth=$sql_row['purwidth'];
	$compo_no=$sql_row['compo_no'];
	$strip_match=$sql_row['strip_match'];
	$gusset_sep=$sql_row['gusset_sep'];
	$patt_ver=$sql_row['patt_ver'];
	$col_des=$sql_row['col_des'];
}
$sql="select *,cuttable_wastage, sum(cuttable_s_xs) as \"cuttable_s_xs\", sum(cuttable_s_s) as \"cuttable_s_s\", sum(cuttable_s_m) as \"cuttable_s_m\", sum(cuttable_s_l) as \"cuttable_s_l\", sum(cuttable_s_xl) as \"cuttable_s_xl\", sum(cuttable_s_xxl) as \"cuttable_s_xxl\", sum(cuttable_s_xxxl) as \"cuttable_s_xxxl\" from $bai_pro3.cuttable_stat_log where order_tid=\"$order_tid\" and cat_id=$cat_ref";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
		for($s=0;$s<sizeof($sizes_code);$s++)
		{
			if($sql_row["cuttable_s_s".$sizes_code[$s].""]>0)
			{
				$c_o[$sizes_code[$s]]=$sql_row["cuttable_s_s".$sizes_code[$s]];
			}
		}
	$cuttable_wastage = $sql_row['cuttable_wastage'];
	$c_s01=$sql_row['cuttable_s_s01'];
	$c_s02=$sql_row['cuttable_s_s02'];
	$c_s03=$sql_row['cuttable_s_s03'];
	$c_s04=$sql_row['cuttable_s_s04'];
	$c_s05=$sql_row['cuttable_s_s05'];
	$c_s06=$sql_row['cuttable_s_s06'];
	$c_s07=$sql_row['cuttable_s_s07'];
	$c_s08=$sql_row['cuttable_s_s08'];
	$c_s09=$sql_row['cuttable_s_s09'];
	$c_s10=$sql_row['cuttable_s_s10'];
	$c_s11=$sql_row['cuttable_s_s11'];
	$c_s12=$sql_row['cuttable_s_s12'];
	$c_s13=$sql_row['cuttable_s_s13'];
	$c_s14=$sql_row['cuttable_s_s14'];
	$c_s15=$sql_row['cuttable_s_s15'];
	$c_s16=$sql_row['cuttable_s_s16'];
	$c_s17=$sql_row['cuttable_s_s17'];
	$c_s18=$sql_row['cuttable_s_s18'];
	$c_s19=$sql_row['cuttable_s_s19'];
	$c_s20=$sql_row['cuttable_s_s20'];
	$c_s21=$sql_row['cuttable_s_s21'];
	$c_s22=$sql_row['cuttable_s_s22'];
	$c_s23=$sql_row['cuttable_s_s23'];
	$c_s24=$sql_row['cuttable_s_s24'];
	$c_s25=$sql_row['cuttable_s_s25'];
	$c_s26=$sql_row['cuttable_s_s26'];
	$c_s27=$sql_row['cuttable_s_s27'];
	$c_s28=$sql_row['cuttable_s_s28'];
	$c_s29=$sql_row['cuttable_s_s29'];
	$c_s30=$sql_row['cuttable_s_s30'];
	$c_s31=$sql_row['cuttable_s_s31'];
	$c_s32=$sql_row['cuttable_s_s32'];
	$c_s33=$sql_row['cuttable_s_s33'];
	$c_s34=$sql_row['cuttable_s_s34'];
	$c_s35=$sql_row['cuttable_s_s35'];
	$c_s36=$sql_row['cuttable_s_s36'];
	$c_s37=$sql_row['cuttable_s_s37'];
	$c_s38=$sql_row['cuttable_s_s38'];
	$c_s39=$sql_row['cuttable_s_s39'];
	$c_s40=$sql_row['cuttable_s_s40'];
	$c_s41=$sql_row['cuttable_s_s41'];
	$c_s42=$sql_row['cuttable_s_s42'];
	$c_s43=$sql_row['cuttable_s_s43'];
	$c_s44=$sql_row['cuttable_s_s44'];
	$c_s45=$sql_row['cuttable_s_s45'];
	$c_s46=$sql_row['cuttable_s_s46'];
	$c_s47=$sql_row['cuttable_s_s47'];
	$c_s48=$sql_row['cuttable_s_s48'];
	$c_s49=$sql_row['cuttable_s_s49'];
	$c_s50=$sql_row['cuttable_s_s50'];

	$cuttable_total=$c_s01+$c_s02+$c_s03+$c_s04+$c_s05+$c_s06+$c_s07+$c_s08+$c_s09+$c_s10+$c_s11+$c_s12+$c_s13+$c_s14+$c_s15+$c_s16+$c_s17+$c_s18+$c_s19+$c_s20+$c_s21+$c_s22+$c_s23+$c_s24+$c_s25+$c_s26+$c_s27+$c_s28+$c_s29+$c_s30+$c_s31+$c_s32+$c_s33+$c_s34+$c_s35+$c_s36+$c_s37+$c_s38+$c_s39+$c_s40+$c_s41+$c_s42+$c_s43+$c_s44+$c_s45+$c_s46+$c_s47+$c_s48+$c_s49+$c_s50;

}


?>

<?php

$sql="select *,fn_savings_per_cal(DATE,cat_ref,'$delivery','$color') as savings from $bai_pro3.recut_v2 where order_tid=\"$order_tid\" and cat_ref=$cat_ref and doc_no=$doc_id";
// mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$mk_ref=$sql_row['mk_ref'];

for($s=0;$s<sizeof($sizes_code);$s++)
{
	//if($sql_row["a_s".$sizes_code[$s].""]>0)
	//{
	$a_s[$sizes_code[$s]]=$sql_row["a_s".$sizes_code[$s].""];
	//}
}
$a_s01=$sql_row['a_s01'];
$a_s02=$sql_row['a_s02'];
$a_s03=$sql_row['a_s03'];
$a_s04=$sql_row['a_s04'];
$a_s05=$sql_row['a_s05'];
$a_s06=$sql_row['a_s06'];
$a_s07=$sql_row['a_s07'];
$a_s08=$sql_row['a_s08'];
$a_s09=$sql_row['a_s09'];
$a_s10=$sql_row['a_s10'];
$a_s11=$sql_row['a_s11'];
$a_s12=$sql_row['a_s12'];
$a_s13=$sql_row['a_s13'];
$a_s14=$sql_row['a_s14'];
$a_s15=$sql_row['a_s15'];
$a_s16=$sql_row['a_s16'];
$a_s17=$sql_row['a_s17'];
$a_s18=$sql_row['a_s18'];
$a_s19=$sql_row['a_s19'];
$a_s20=$sql_row['a_s20'];
$a_s21=$sql_row['a_s21'];
$a_s22=$sql_row['a_s22'];
$a_s23=$sql_row['a_s23'];
$a_s24=$sql_row['a_s24'];
$a_s25=$sql_row['a_s25'];
$a_s26=$sql_row['a_s26'];
$a_s27=$sql_row['a_s27'];
$a_s28=$sql_row['a_s28'];
$a_s29=$sql_row['a_s29'];
$a_s30=$sql_row['a_s30'];
$a_s31=$sql_row['a_s31'];
$a_s32=$sql_row['a_s32'];
$a_s33=$sql_row['a_s33'];
$a_s34=$sql_row['a_s34'];
$a_s35=$sql_row['a_s35'];
$a_s36=$sql_row['a_s36'];
$a_s37=$sql_row['a_s37'];
$a_s38=$sql_row['a_s38'];
$a_s39=$sql_row['a_s39'];
$a_s40=$sql_row['a_s40'];
$a_s41=$sql_row['a_s41'];
$a_s42=$sql_row['a_s42'];
$a_s43=$sql_row['a_s43'];
$a_s44=$sql_row['a_s44'];
$a_s45=$sql_row['a_s45'];
$a_s46=$sql_row['a_s46'];
$a_s47=$sql_row['a_s47'];
$a_s48=$sql_row['a_s48'];
$a_s49=$sql_row['a_s49'];
$a_s50=$sql_row['a_s50'];

	// $a_ratio_tot=$a_s01+$a_s02+$a_s03+$a_s04+$a_s05+$a_s06+$a_s07+$a_s08+$a_s09+$a_s10+$a_s11+$a_s12+$a_s13+$a_s14+$a_s15+$a_s16+$a_s17+$a_s18+$a_s19+$a_s20+$a_s21+$a_s22+$a_s23+$a_s24+$a_s25+$a_s26+$a_s27+$a_s28+$a_s29+$a_s30+$a_s31+$a_s32+$a_s33+$a_s34+$a_s35+$a_s36+$a_s37+$a_s38+$a_s39+$a_s40+$a_s41+$a_s42+$a_s43+$a_s44+$a_s45+$a_s46+$a_s47+$a_s48+$a_s49+$a_s50;
	$a_ratio_tot=array_sum($a_s);
	$cutno=$sql_row['acutno'];
	$plies=$sql_row['p_plies']; //20110911
	$docketno=$sql_row['doc_no'];
	$docketdate=$sql_row['date'];
	$mk_ref=$sql_row['mk_ref'];
	$print_status=$sql_row['print_status'];
	$remarks=$sql_row['remarks'];
	$plan_module=$sql_row['plan_module'];
	$lot_ref=$sql_row['plan_lot_ref'];
	$allocate_ref=$sql_row['allocate_ref'];
	$savings=$sql_row['savings'];
}
$sql2="select * from $bai_pro3.maker_stat_log where tid=$mk_ref";
// echo $sql2;
mysqli_query($link,$sql2) or exit("Sql Error".mysql_error());
$sql_result2=mysqli_query($link,$sql2) or exit("Sql Error".mysql_error());

while($sql_row2=mysqli_fetch_array($sql_result2))
{
	$mklength=$sql_row2['mklength'];
	$mk_remarks=$sql_row2['remarks'];
}
	$sql="select min(roll_width) as width from $bai_rm_pj1.fabric_cad_allocation where doc_no=".$doc_id." and doc_type=\"normal\"";
 //echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1x=mysqli_fetch_array($sql_result))
	{
		$system_width=round($sql_row1x['width'],2);
	}
	$actwidth=$system_width;
	// $ctexlength=$sql_row1x['allocated_qty'];
	
	$sql2="select * from $bai_pro3.maker_stat_log where tid=$mk_ref";
	//echo $sql2;
	// mysqli_query($link, $sql2) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$mklength=$sql_row2['mklength'];
		$mk_file=$sql_row2['remarks'];
		
		$sql22="select * from $bai_pro3.marker_ref_matrix where cat_ref=\"".$sql_row2['cat_ref']."\" and allocate_ref=\"$allocate_ref\" and marker_width=$system_width";
		$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row22=mysqli_fetch_array($sql_result22))
		{
			$actwidth=$sql_row22['marker_width'];
			$act_mk_length=$sql_row22['marker_length'];
		}
		
		$sql22="select * from $bai_pro3.marker_ref_matrix where cat_ref=\"".$sql_row2['cat_ref']."\" and allocate_ref=\"$allocate_ref\" and marker_width=\"$purwidth\"";
		//echo $sql22;
		$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row22=mysqli_fetch_array($sql_result22))
		{
			$purlength=$sql_row22['marker_length'];
		}
		if(mysqli_num_rows($sql_result22)==0)
		{
			$purlength=$mklength;
		}
	}
	
	//Binding Consumption / YY Calculation
	$sql="select COALESCE(binding_consumption,0) as \"binding_consumption\" from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and tid=$cat_ref";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);
	if($sql_num_check > 0)
	{
		while($sql_row2=mysqli_fetch_array($sql_result))
		{
			$binding_con = $sql_row2['binding_consumption'];
			$bind_con= $binding_con *($a_ratio_tot*$plies);
		}
	}
	else
	{
		$bind_con=0;
	}
	

$child_dockets_query="SELECT doc_no AS doc_no FROM $bai_pro3.recut_v2 WHERE doc_no='$docketno'";
$child_dockets_result=mysqli_query($link, $child_dockets_query) or exit("error while getting original doc nos");
while($sql_row=mysqli_fetch_array($child_dockets_result))
{
	$original_docs[]=$sql_row['doc_no'];
}

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
	{padding-top:2px;
	padding-right:2px;
	padding-left:2px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
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
	
.xl7742018
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
	mso-pattern:auto;}	
	
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
	font-size:10.0pt;
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
	
@page { margin: 0; }
@page narrow {size: 9in 11in}
@page rotated {size: landscape}
DIV {page: narrow}
TABLE {page: rotated}
#non-printable { display: none; }
#printable { display: block; }
#logo { display: block; }
body { zoom:72%;}
#ad{ display:none;}
#leftbar{ display:none;}
#CUT_PLAN_NEW_13019{ width:57%; margin-left:20px;}
}
</style>

<script>
function printpr()
{
	window.print();
}
</script>

<script src="../../common/js/jquery-1.3.2.js"></script>
<script src="../../common/js/jquery-barcode-2.0.1.js"></script>

</head>

<body onload="printpr();">

<script language="JavaScript">

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


</script>

<div style='height:50px'><br/><br/></div>
<div id="DOCKET_NEW_4118" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 style='border-collapse: collapse;width:1000px'>
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
  name="RANGE!A1:Q57"></a><?php echo '<div id="bcTarget1" style="width:auto;"></div><script>$("#bcTarget1").barcode("R'.$doc_id.'", "code39",{barWidth:2,barHeight:30,moduleSize:5,fontSize:5});</script>'; ?></td>
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

 </tr>

 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
<td colspan=6 rowspan=3 class=xl8217319x valign="top" align="left"><img src="<?= $logo ?>" width="200" height="60"></td>
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
  <td colspan=3 >Cutting Department</td>
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
  <td colspan=3 style='font-size:24px;font-weight:bold'>Recut Docket</td>
  <td class=xl1014118></td>
  <td class=xl1014118></td>
  <td colspan=2 style='border-right:1px solid black;font-size:20px;font-weight:bold;text-align:right' style='border-right:.5pt solid black'>Docket
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
  <td class=xl654118 colspan=3 align=center><strong><?php if($print_status=='0000-00-00' || $print_status == "") {echo "Original"; } else {echo "Duplicate";}?></strong></td>
  <td class=xl654118></td>
 </tr>
 <!-- <tr class=xl654118 height=20 style='mso-height-source:userset;height:5.0pt'>
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
 </tr> -->
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:5.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl914118>Cut No :</td>
  <td colspan=2 class=xl1214118><?php if($remarks=="Normal") { echo chr($color_code).leading_zeros($cutno, 3); } else {if($remarks=="Pilot") { echo "Pilot";}}?></td>
  <td class=xl924118>Date:</td>
  <td class=xl944118><?php echo $docketdate; ?></td>
  <td class=xl964118></td>
  <td colspan=2 class=xl914118>Category :</td>
  <td colspan=2 class=xl1214118><?php echo $category; ?></td>
  <td  colspan=2 class=xl984118></td>
  <td colspan=2 class='xl984118 right'></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl904118>Style No :</td>
  <td colspan=2 class=xl954118 style='border-right:.5pt solid black'><?php echo $style; ?></td>
  <td class=xl904118x>Module:</td>
  <td class=xl954118><?php echo $plan_module; ?></td>	
  <td class=xl904118></td>
  <td colspan=2 class=xl904118>Fab Code :</td>
  <td colspan=4 class=xl954118><?php echo $compo_no ?></td>
  <td class=xl654118></td>
  <td class='xl654118 right'></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl904118>Sch No :</td>
  <td colspan=2 class=xl954118 style='border-right:.5pt solid black'><?php echo $delivery.chr($color_code); ?></td>
  <td class=xl904118x>Consumption:</td>
  <td class=xl954118><?php echo $body_yy; ?></td>
  <td class=xl904118></td>
  <td colspan=2 class=xl904118>Fab Descrip :</td>
  <td colspan=6 style='padding-top : 12px;border-right:.5pt solid black'><?php echo $fab_des; ?></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl904118>Color :</td>
  <td colspan=4 style='padding-top : 12px;border-right:.5pt solid black;font-size:18px'><?php echo $color." / ".$col_des; ?></td>
  <td class=xl954118></td>
  <td colspan=2 class=xl904118>MK Name :</td>
  <td colspan=4 class=xl954118><?php echo $mk_remarks; ?></td>
  <td class=xl654118></td>
  <td class='xl654118 right'></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl934118>CO :</td>
  <td colspan=4 class=xl1194118 style='border-right:.5pt solid black'><?php echo $pono; ?></td>
  <td class=xl974118></td>
  <td colspan=2 class=xl934118>Fab Direction :</td>
  <td colspan=5 class=xl1104118 ><?php if($gmtway=="Y") { echo "One Gmt One Way"; } else  { echo "All Gmt One Way"; }?></td>
  <td class='xl1104118 right'></td>
 </tr>
 

 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:5.0pt'></td>
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
 </table>


 <table border=0 cellpadding=0 cellspacing=0 align='left' style='border-collapse: collapse;width:parent'>
 <tr class=xl674118 height=20 style='mso-height-source:userset;height:5.0pt'>
  <td rowspan=2 class=xl764118 style='border-bottom:1px solid black'>Rpt No</td>
  <td rowspan=2 class=xl774118  width=64 style='border-bottom:.5pt solid black;  width:48pt'>Pattern Version</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:70pt'>No of Plies</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Pur Width</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Marker Length</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Binding Cons.</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:90pt'>Fab. Requirement for lay</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:90pt'>Fab. Requirement for Binding</td>
  <td rowspan=2 class=xl1144118 width=67 style='border-bottom:.5pt solid black;  width:70pt'>Act. Width</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Total Fab. Requirement</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Issued Qty (Yds)</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Return Qty (Yds)</td>
  <td rowspan=4 colspan=10 class=xl1144118 width=64 style='border-bottom:.6pt solid black'></td>
  <td class=xl674118></td>
  <td class=xl674118></td>
  <td class=xl674118></td>
  <td class=xl674118></td>
  <td class=xl674118></td>
  <td class=xl674118></td>
 </tr>
 <tr class=xl674118 height=20 style='mso-height-source:userset;height:10.0pt'>

 </tr>
  <td rowspan=2 class=xl1184118 width=64 style='border-bottom:.5pt solid black;  border-top:none;width:48pt'>&nbsp;</td>
  <td rowspan=2 class=xl1184118 width=64 style='border-bottom:.5pt solid black;  border-top:none;width:48pt'><?php echo $patt_ver; ?></td>
  <td rowspan=2 class=xl1124118 width=64 style='border-bottom:.5pt solid black;  border-top:none;width:70pt'><?php echo $plies; ?></td>
  <td rowspan=2 class=xl1124118 width=64 style='border-bottom:.5pt solid black;  border-top:none;width:48pt'><?php echo $purwidth; ?></td>
  <td rowspan=2 class=xl1184118 width=64 style='border-bottom:.5pt solid black;  border-top:none;width:48pt'><?php echo $purlength; ?></td>
  <td rowspan=2 class=xl1184118 width=64 style='border-bottom:.5pt solid black;  border-top:none;width:48pt'><?php echo $binding_con; ?></td>
  <td rowspan=2 class=xl1124118 width=64 style='border-bottom:.5pt solid black;  border-top:none;width:48pt'><?php $fab_lay = $purlength*(1+$cuttable_wastage)*$plies; echo round($fab_lay,2).'<br/>('.$fab_uom.')';?></td>
  <td rowspan=2 class=xl1124118 width=64 style='border-bottom:.5pt solid black;  border-top:none;width:48pt'><?php echo round($bind_con,2).'<br/>('.$fab_uom.')'; ?></td>
  <td rowspan=2 class=xl1124118 width=67 style='border-bottom:.5pt solid black;  border-top:none;width:50pt'><?php echo $actwidth; ?></td>
  <td rowspan=2 class=xl1124118 width=64 style='border-bottom:.5pt solid black;  border-top:none;width:48pt'><?php echo round($bind_con+$fab_lay,2).'<br/>('.$fab_uom.')'; ?></td>
<!--<td rowspan=2 class=xl1124118 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php //if(substr($style,0,1)=="M") 
{ $extra=round((($act_mk_length*$plies)*$savings),2); }  echo round((($act_mk_length*$plies)+$extra+$bind_con),2); //Extra 1% added to avoid cad saving manual mrn claims. ?></td>-->
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
 <!-- <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr> -->
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
 </table>
 </table>
 <table border=0 cellpadding=0 cellspacing=0 align=left style='border-collapse: collapse;'>

 <?php
	 $fab_uom = 'Yds';
	 $temp = 0;
	 $temp_len1 = 0;
	 $temp_len = 0;
	 $divide=15;
 ?>
	<tr class=xl654118 height=20 style='mso-height-source:userset;height:10.0pt'>
	  <td height=20 class=xl654118 style='height:10.0pt'></td>
	  <?php
		if($flag == 1)
		{
			//number of sizes-which excludes null
			$total_size = sizeof($s_tit);
			// $total_size = 50;
			for($s=0;$s<$total_size;$s++)
			{
				if($temp == 0){
					echo "<td class=xl654118>Size</td>";
					$temp = 1;
				}
				echo  "<td class=xl694118>".$s_tit[$sizes_code[$s]]."</td>";
				if(($s+1) % $divide == 0){
					$temp_len = $s+1;
					echo "</tr>";
					echo "<tr class=xl654118 height=20 style='mso-height-source:userset;height:10.0pt'>
						<td height=20 class=xl654118 style='height:10.0pt'></td>
						<td class=xl654118>Ratio</td>";
					for($i=$temp_len1;$i<$temp_len;$i++) {
							echo "<td class=xl734118>".$a_s[$sizes_code[$i]]."</td>";
						}
					echo "</tr>";
					echo "<tr class=xl654118 height=20 style='mso-height-source:userset;height:10.0pt'>
					<td height=20 class=xl654118 style='height:10.0pt'></td>
					<td class=xl654118>Quantity</td>";
					for($i=$temp_len1;$i<$temp_len;$i++) {
						echo "<td class=xl734118 >".($a_s[$sizes_code[$i]]*$plies)."</td>";
					}
					echo "</tr>";
					echo "<tr class=xl654118 height=20 style='mso-height-source:userset;height:10.0pt'></tr><td></td>";
					$temp = 0;
					$temp_len1=$temp_len;
				}
				// echo $s.'=='.$total_size;
				if($s+1==$total_size) {
					echo "<td class=xl714118>Total</td></tr><tr class=xl654118 height=20 style='mso-height-source:userset;height:10.0pt'><td height=20 class=xl654118 style='height:10.0pt'></td><td class=xl654118>Ratio</td>";
					for($i=$temp_len1;$i<$total_size;$i++) {
						echo "<td class=xl734118>".$a_s[$sizes_code[$i]]."</td>";
					}
					echo "<td class=xl754118>".$a_ratio_tot."</td>";
					echo "</tr>";
					echo "<tr class=xl654118 height=20 style='mso-height-source:userset;height:10.0pt'>
					<td height=20 class=xl654118 style='height:10.0pt'></td>
					<td class=xl654118>Quantity</td>";
					for($i=$temp_len1;$i<$total_size;$i++) {
						echo "<td class=xl734118 >".($a_s[$sizes_code[$i]]*$plies)."</td>";
					}
					echo "<td class=xl754118>".($a_ratio_tot*$plies)."</td>";
					echo "</tr>";
				}
			}
		}
	  ?>
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
 </table>

<table border=0 cellpadding=0 cellspacing=0 align='left' style='border-collapse: collapse;width:auto'>
 <tr class=xl674118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl674118 style='height:15.0pt'></td>
  <td rowspan="2" colspan="12" class=xl764118 style='border-bottom:.5pt solid black;' >Inspection Comments:
  
  <?php
  $sql="select * from $bai_rm_pj1.docket_ref where doc_no=$doc_id and doc_type='recut'  group by roll_id";
//echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{

$roll_det[]=$sql_row['ref2'];
$width_det[]=round($sql_row['roll_width'],2);
$leng_det[]=$sql_row['allocated_qty'];
$batch_det[]=trim($sql_row['batch_no']);
$shade_det[]=$sql_row['ref4'];
$location_det[]=$sql_row['ref1'];
$invoice_no[]=$sql_row['inv_no'];
$plies1[]=$sql_row['plies'];
$locan_det[]=$sql_row['ref1'];
$lot_det[]=$sql_row['lot_no'];
$roll_id[]=$sql_row['roll_id'];
$ctex_len[]=$sql_row['ref5'];
$tkt_len[]=$sql_row['qty_rec'];
$ctex_width[]=$sql_row['ref3'];
$tkt_width[]=$sql_row['ref6'];
$item_name[] = $sql_row['item'];
} 
  //echo ($bind_con>0)?"Binding/Rib Quantity: $bind_con YDS":"";
   if(sizeof($batch_det) > 0)
   {
	   	$rem="";
		$batchs=array();
	   	for($i=0;$i<sizeof($batch_det);$i++)
		{
			$batchs[]="'".$batch_det[$i]."'";
		}
	   
	    $batchs=array_unique($batchs);
	    $sql="select group_concat(sp_rem) as rem from $bai_rm_pj1.inspection_db where batch_ref in (".implode(",",$batchs).")";
   	    //echo $sql;
	    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	    while($sql_row=mysqli_fetch_array($sql_result))
	    {
	    	$rem=$sql_row["rem"];
	    }
	    echo $rem;
   }

?>
  </td>
 
  <td class=xl654118></td>
  <td class=xl654118 colspan="6"><u><strong>Quality Authorisation</strong></u></td>
 </tr>
<tr class=xl674118 height=20 style='mso-height-source:userset;height:15.0pt'></tr>
 <tr class=xl674118 height=20 style='mso-height-source:userset;height:15.0pt'>
 <td height=20 class=xl674118 style='height:15.0pt'></td>
 <!--<td rowspan="2" colspan="15" class=xl764118 style='border-bottom:.5pt solid black;'>-->
 <?php
 $roll_length = array();
//  $roll_det = array();
 $sql123="SELECT ref2,ref4,SUM(allocated_qty) AS shade_lengt FROM $bai_rm_pj1.docket_ref WHERE doc_no=$doc_id AND doc_type='normal' GROUP BY ref4";
 $sql_result123=mysqli_query($link, $sql123) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
 while($sql_row123=mysqli_fetch_array($sql_result123))
{
	$roll_length[]=$sql_row123['ref2'];
	$shade_lengt[]=$sql_row123['shade_lengt'];
	$shade[]=$sql_row123['ref4'];
}
 ?>
 <!--</td>-->
 </tr>
<tr class=xl674118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl674118 style='height:15.0pt'></td>
  <td class=xl764118 style='border-bottom:.5pt solid black;'>Shade</td>
  <td class=xl764118 colspan=3 style='border-bottom:.5pt solid black;'>Shade Wise Total Fab (Yds)</td>
  <td class=xl764118 colspan=3 style='border-bottom:.5pt solid black;'>No of Plies from Shade</td>
  <td class=xl764118 colspan=4 style='border-bottom:.5pt solid black;'>Fabric from shade for Binding (Yds)</td>
  <td class=xl654118 colspan="3" style='text-align:right'><u><strong>Cutting Supervisor Authorization</strong></u></td>
</tr>

 <?php
  if(sizeof($roll_length)>0)
 {
	for($i=0;$i<sizeof($roll_length);$i++)
	{
	 ?>
		<tr class=xl654118 height=20 style='mso-height-source:userset;height:18.0pt'>
		  <td height=20 class=xl654118 style='height:18.0pt'></td>
		  <td class=xl804118 style='border-bottom:.5pt solid black;  width:48pt'><?php echo $shade[$i]; ?></td>
		  <td class=xl814118 colspan=3 style='border-bottom:.5pt solid black;  width:48pt'><?php echo round($shade_lengt[$i],2); ?></td>
		  <td class=xl814118 colspan=3 style='border-bottom:.5pt solid black;  width:48pt'><?php echo round(($shade_lengt[$i]/($purlength*(1+$cuttable_wastage)+($binding_con*$a_ratio_tot))),0); ?></td>
		  <td class=xl804118 colspan=4><?php echo round((($shade_lengt[$i]/($purlength*(1+$cuttable_wastage)+($binding_con*$a_ratio_tot)))*$binding_con*$a_ratio_tot),2); ?></td>
		</tr>
	  <?php
	}
 }else{?> 
 	<tr class=xl654118 height=20 style='mso-height-source:userset;height:18.0pt'>
	  <td height=20 class=xl654118 style='height:18.0pt'></td>
	  <td class=xl804118 style='border-bottom:.5pt solid black;  width:48pt'>&nbsp;</td>
	  <td class=xl814118 colspan=3 style='border-bottom:.5pt solid black;  width:48pt'>&nbsp;</td>
	  <td class=xl814118 colspan=3 style='border-bottom:.5pt solid black;  width:48pt'>&nbsp;</td>
	  <td class=xl804118 colspan=4 style='border-bottom:.5pt solid black;  width:48pt'>&nbsp;</td>
	</tr>
 <?php }
 ?>
 
 
<tr class=xl674118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl674118 style='height:15.0pt'></td>
</tr>


<table border=0 cellpadding=0 cellspacing=0 align='left' style='border-collapse: collapse;width:auto'>
<tr class=xl674118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl674118 style='height:15.0pt'></td>
  <td class=xl764118>Batch</td>
  <td class='xl764118'>Fabric Name</td>
  <td class=xl764118>Lot No</td>
  
  <td class=xl764118>Shade</td>
  <td class=xl764118>Location</td>
  <td class=xl7742018>Roll</br>No</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Ticket Length</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>C-tex<br/>Length</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>C-tex<br/>Width</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Allocated Qty</td>
  <td class=xl774118>Plies</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:150pt'>Net<br/>Length</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Damage<br/>Excess</td>
  <td class=xl7742018 style="width: 85px;">Joints</td>
  <td class=xl7742018 style="width: 85px;">Ends</td>

  <td colspan=2 class=xl1064118 style="width: 122px;">Shortages</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Binding Length</td>  
  <td colspan=3 rowspan=2 class=xl1064118>Comments</td>
 </tr> <tr class=xl674118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl674118 style='height:15.0pt'></td>
  <td class=xl724118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
 
  <td class=xl744118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl744118>+</td>
  <td class=xl744118>-</td>
  <!--<td class=xl744118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl674118></td>-->
 </tr>

 <?php
 //$count=sizeof($roll_det);
 //echo $count."<br>";
 $total='';
 
$tot_tick_len=0;
$tot_ctex_len=0;
$tot_alloc_qty=0;
$tot_bind_len=0;
 
 if(sizeof($roll_det)>0)
 {
	 for($i=0;$i<sizeof($roll_det);$i++)
	 {
	 ?>
	  <tr class=xl654118 height=30 style='mso-height-source:userset;height:30pt'>
	  <td height=20 class=xl654118 style='height:30pt'></td>
	  <td class=xl804118><?php echo $batch_det[$i]; ?></td>
	  <td class=xl804118><?php echo $item_name[$i]; ?></td>
	  <td class=xl814118 style='font-size: 100%;'><?php echo $lot_det[$i]; ?></td>
	 
	  <td class=xl814118><?php echo $shade_det[$i]; ?></td>
	  <td class=xl814118><?php echo $location_det[$i]; ?></td>
	  <td class=xl814118><?php echo $roll_det[$i]; ?></td>
	  <td class=xl814118 style='text-align:right;padding-bottom:5pt;'><?php echo $tkt_len[$i]; $tot_tick_len=$tot_tick_len+$tkt_len[$i];?></td>
	  <td class=xl814118 style='text-align:right;padding-bottom:5pt;'><?php echo $ctex_len[$i]; $tot_ctex_len=$tot_ctex_len+$ctex_len[$i];?></td>
	  <td class=xl814118 style='text-align:right;padding-bottom:5pt;'><?php echo $ctex_width[$i]; ?></td>
	  <td class=xl814118 style='text-align:right;padding-bottom:5pt;'><?php echo $leng_det[$i]; $tot_alloc_qty=$tot_alloc_qty+$leng_det[$i];?></td>
	  <td class=xl814118 style='text-align:right;padding-bottom:5pt;'><?php // echo $plies1[$i]; ?></td>
	  <td class=xl814118 style='text-align:right;padding-bottom:5pt;'>&nbsp;</td>
	  <td class=xl814118>&nbsp;</td>
	  <td class=xl814118>&nbsp;</td>
	  <td class=xl814118>&nbsp;</td>
	  <td class=xl814118>&nbsp;</td>
	  <td class=xl814118>&nbsp;</td>
	  <td colspan=1 class=xl684118 style='text-align:right;padding-bottom:5pt;'><?php echo round(($leng_det[$i]*$binding_con*$a_ratio_tot),2); $tot_bind_len=$tot_bind_len+($leng_det[$i]*$binding_con*$a_ratio_tot);?></td>
	  <td colspan=3 class=xl684118 style='border-left:none'></td>
	  <td class=xl654118></td>
	  </tr>
	  <?php
	  		// $total=0;
	  		// $total+=$leng_det[$i];
	  		// $leng_det[$i];	
	   }
	 for($i =0; $i<16-sizeof($roll_det); $i++){
	?>
		<tr class=xl654118 height=30 style='mso-height-source:userset;height:30pt'>
	  <td height=20 class=xl654118 style='height:30pt'></td>
	  <td class=xl804118></td>
	  <td class=xl804118></td>
	  <td class=xl814118 style='font-size: 100%;'></td>
	  
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td colspan=1 class=xl684118></td>
	  <td colspan=3 class=xl684118 style='border-left:none'></td>
	  <td class=xl654118></td>
	  </tr>
	<?php
	 }
 ?>
 			 <tr>
	<td colspan=7 class=xl684118>Total </td>
	<?php
	// for($i=0;$i<sizeof($roll_det);$i++)
	// {
		echo "<td class=xl814118 style='text-align:right;padding-bottom:5pt;'>".$tot_tick_len."</td>
			  <td class=xl814118 style='text-align:right;padding-bottom:5pt;'>".$tot_ctex_len."</td>
			  <td class=xl814118></td>
			  <td class=xl814118 style='text-align:right;padding-bottom:5pt;'>".$tot_alloc_qty."</td>
			  <td class=xl814118></td>
			  <td class=xl814118></td>
			  <td class=xl814118></td>
			  <td class=xl814118></td>
			  <td class=xl814118></td>
			  <td class=xl814118></td>
			  <td class=xl814118></td>
			  <td class=xl814118 style='text-align:right;padding-bottom:5pt;'>".$tot_bind_len."</td>
			  <td class=xl814118></td>";
	// }
	?>
	</tr>
<?php
 }
 else {
	 for($i =0; $i<16; $i++){
	?>
		<tr class=xl654118 height=30 style='mso-height-source:userset;height:30pt'>
	  <td height=20 class=xl654118 style='height:30pt'></td>
	  <td class=xl804118></td>
	  <td class=xl804118></td>
	  <td class=xl814118 style='font-size: 100%;'></td>
	 
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td colspan=1 class=xl684118></td>
	  <td colspan=3 class=xl684118 style='border-left:none'></td>
	  <td class=xl654118></td>
	  </tr>
	<?php
	 }	
 }
?>	

		
 <tr class=xl654118 height=10 style='mso-height-source:userset;height:5pt'>
  <td height=20 class=xl654118 style='height:5.0pt'></td>
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

 <tr class=xl654118 height=20 style='mso-height-source:userset;height:5.0pt'>
  <td height=20 class=xl654118 style='height:30pt'></td>
  <th class=xl654118></th>
  <th class=xl684118>Docket</th>
  <th class=xl704118>Marker</th>
  <th class=xl704118 style='width:100px'>Issuing</th>
  <th class=xl704118>Laying</th>
  <th class=xl704118>Cutting</th>
  <th class=xl704118>Return</th>
  <th class=xl704118>Bundling</th>
  <th class=xl704118>Dispatch</th>
  <th></th>
  <th class=xl654118>Act Con</th>
  <th class=xl864118>&nbsp;</th>
  <th class=xl864118>&nbsp;</th>
  <th class=xl864118>&nbsp;</th>
  <th class=xl654118></th>
  <th class=xl654118></th>
  <th class=xl654118></th>
 </tr>
 <tr class=xl654118 height=30 style='mso-height-source:userset;height:30pt'>
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
  <td></td>
  <td class=xl654118>Saving %</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:30pt'>
  <td height=20 class=xl654118 style='height:30pt'></td>
  <td class=xl654118>EMP No1</td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td></td>
  <td class=xl654118>Reason</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=30 style='mso-height-source:userset;height:30pt'>
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
  <td></td>
  <td class=xl654118>Approved</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=30 style='mso-height-source:userset;height:30pt'>
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
 <tr class=xl654118 height=30 style='mso-height-source:userset;height:30pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118>Date</td>
  <td class=xl804118><?php //echo date("y/m/d",strtotime($plan_log_time)); ?></td>
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
 <tr class=xl654118 height=30 style='mso-height-source:userset;height:30pt'>
  <td height=20 class=xl654118 style='height:30pt'></td>
  <td class=xl654118>Time</td>
  <td class=xl804118><?php //echo date("H:i",strtotime($plan_log_time)); ?></td>
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
 <tr height=21 style='height:30pt'>
  <td height=21 class=xl154118 style='height:30pt'></td>
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

if($print_status=="0000-00-00" || $print_status == "")
{
	
	$sql12="update $bai_pro3.recut_v2 set print_status=\"".date("Y-m-d")."\" where doc_no=$docketno";
	//echo $sql;
	mysqli_query($link,$sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
}



//Refresh Parent Page After this Print Out 
echo"<script>
window.onunload = refreshParent;
function refreshParent() {
	window.opener.location.reload();
}
</script>"; 
?>
<style>
.xl744118,.xl694118,.xl774118,.xl684118,.xl704118,.xl724118,.xl1064118,.xl764118,.xl7742018,.xl814118,.xl804118,.xl674118,.xl654118,.xl1124118,.xl1144118,.xl714118{
	font-size : 22px;
	font-wight : bold;
}
.xl754118,.xl914118,.xl694118,.xl734118,.xl734118,.xl934118,.xl1104118,.xl1194118,.xl1214118,.xl924118,.xl944118,.xl654118,.xl904118,.xl954118,.xl904118x,.xl904118,.xl1144118,.xl774118,.xl1184118{
	font-size : 22px;
	font-weight : bold;
}
.xl804118,.xl814118,.xl684118,.xl764118,.xl7742018,.xl774118,.xl1064118,.xl704118,.xl654118,.xl1024118{
	font-size : 22px;
	font-weight : bold;
}
.xl664118{
	font-size : 24px;
	//font-weight : bold;
}
*{
	font-size : 20px;
}
tr{
	height : 40pt;
}
.xl734118{
	width : 50px;
}
td{
	vertical-align:top;
	height : 25pt;
}
.right{
	border-right : 1px solid black;
}
</style>
