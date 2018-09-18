<!--
Change Log:  

1. kirang/ 2015-5-20/ Service Request: #355944 : add the embellishment column in M&S cut plan generation.  

-->


<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
	  include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
?>   
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>	

<?php
$order_tid=$_GET['order_tid']; 
$cat_ref=$_GET['cat_ref'];
?>

<?php
   $sql="select * from $bai_pro3.bai_orders_db_remarks where order_tid=\"$order_tid\"";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$remarks_x=$sql_row['remarks'];
		
	}
	
	// embellishment start
$sql="select order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
	
$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_confirm=mysqli_num_rows($sql_result);

if($sql_num_confirm>0)
{
	$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
}
else
{
	$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
}
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
	$order_amend=$sql_row['order_no'];
	
	
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
			
			if($orderno=="1")
			{	
			
			$old_s01=$sql_row['old_order_s_s01'];
			$old_s02=$sql_row['old_order_s_s02'];
			$old_s03=$sql_row['old_order_s_s03'];
			$old_s04=$sql_row['old_order_s_s04'];
			$old_s05=$sql_row['old_order_s_s05'];
			$old_s06=$sql_row['old_order_s_s06'];
			$old_s07=$sql_row['old_order_s_s07'];
			$old_s08=$sql_row['old_order_s_s08'];
			$old_s09=$sql_row['old_order_s_s09'];
			$old_s10=$sql_row['old_order_s_s10'];
			$old_s11=$sql_row['old_order_s_s11'];
			$old_s12=$sql_row['old_order_s_s12'];
			$old_s13=$sql_row['old_order_s_s13'];
			$old_s14=$sql_row['old_order_s_s14'];
			$old_s15=$sql_row['old_order_s_s15'];
			$old_s16=$sql_row['old_order_s_s16'];
			$old_s17=$sql_row['old_order_s_s17'];
			$old_s18=$sql_row['old_order_s_s18'];
			$old_s19=$sql_row['old_order_s_s19'];
			$old_s20=$sql_row['old_order_s_s20'];
			$old_s21=$sql_row['old_order_s_s21'];
			$old_s22=$sql_row['old_order_s_s22'];
			$old_s23=$sql_row['old_order_s_s23'];
			$old_s24=$sql_row['old_order_s_s24'];
			$old_s25=$sql_row['old_order_s_s25'];
			$old_s26=$sql_row['old_order_s_s26'];
			$old_s27=$sql_row['old_order_s_s27'];
			$old_s28=$sql_row['old_order_s_s28'];
			$old_s29=$sql_row['old_order_s_s29'];
			$old_s30=$sql_row['old_order_s_s30'];
			$old_s31=$sql_row['old_order_s_s31'];
			$old_s32=$sql_row['old_order_s_s32'];
			$old_s33=$sql_row['old_order_s_s33'];
			$old_s34=$sql_row['old_order_s_s34'];
			$old_s35=$sql_row['old_order_s_s35'];
			$old_s36=$sql_row['old_order_s_s36'];
			$old_s37=$sql_row['old_order_s_s37'];
			$old_s38=$sql_row['old_order_s_s38'];
			$old_s39=$sql_row['old_order_s_s39'];
			$old_s40=$sql_row['old_order_s_s40'];
			$old_s41=$sql_row['old_order_s_s41'];
			$old_s42=$sql_row['old_order_s_s42'];
			$old_s43=$sql_row['old_order_s_s43'];
			$old_s44=$sql_row['old_order_s_s44'];
			$old_s45=$sql_row['old_order_s_s45'];
			$old_s46=$sql_row['old_order_s_s46'];
			$old_s47=$sql_row['old_order_s_s47'];
			$old_s48=$sql_row['old_order_s_s48'];
			$old_s49=$sql_row['old_order_s_s49'];
			$old_s50=$sql_row['old_order_s_s50'];

			$old_order_total=$old_s01+$old_s02+$old_s03+$old_s04+$old_s05+$old_s06+$old_s07+$old_s08+$old_s09+$old_s10+$old_s11+$old_s12+$old_s13+$old_s14+$old_s15+$old_s16+$old_s17+$old_s18+$old_s19+$old_s20+$old_s21+$old_s22+$old_s23+$old_s24+$old_s25+$old_s26+$old_s27+$old_s28+$old_s29+$old_s30+$old_s31+$old_s32+$old_s33+$old_s34+$old_s35+$old_s36+$old_s37+$old_s38+$old_s39+$old_s40+$old_s41+$old_s42+$old_s43+$old_s44+$old_s45+$old_s46+$old_s47+$old_s48+$old_s49+$old_s50;
			}
			else
			{
			$old_s01=$sql_row['old_order_s_s01'];
			$old_s02=$sql_row['old_order_s_s02'];
			$old_s03=$sql_row['old_order_s_s03'];
			$old_s04=$sql_row['old_order_s_s04'];
			$old_s05=$sql_row['old_order_s_s05'];
			$old_s06=$sql_row['old_order_s_s06'];
			$old_s07=$sql_row['old_order_s_s07'];
			$old_s08=$sql_row['old_order_s_s08'];
			$old_s09=$sql_row['old_order_s_s09'];
			$old_s10=$sql_row['old_order_s_s10'];
			$old_s11=$sql_row['old_order_s_s11'];
			$old_s12=$sql_row['old_order_s_s12'];
			$old_s13=$sql_row['old_order_s_s13'];
			$old_s14=$sql_row['old_order_s_s14'];
			$old_s15=$sql_row['old_order_s_s15'];
			$old_s16=$sql_row['old_order_s_s16'];
			$old_s17=$sql_row['old_order_s_s17'];
			$old_s18=$sql_row['old_order_s_s18'];
			$old_s19=$sql_row['old_order_s_s19'];
			$old_s20=$sql_row['old_order_s_s20'];
			$old_s21=$sql_row['old_order_s_s21'];
			$old_s22=$sql_row['old_order_s_s22'];
			$old_s23=$sql_row['old_order_s_s23'];
			$old_s24=$sql_row['old_order_s_s24'];
			$old_s25=$sql_row['old_order_s_s25'];
			$old_s26=$sql_row['old_order_s_s26'];
			$old_s27=$sql_row['old_order_s_s27'];
			$old_s28=$sql_row['old_order_s_s28'];
			$old_s29=$sql_row['old_order_s_s29'];
			$old_s30=$sql_row['old_order_s_s30'];
			$old_s31=$sql_row['old_order_s_s31'];
			$old_s32=$sql_row['old_order_s_s32'];
			$old_s33=$sql_row['old_order_s_s33'];
			$old_s34=$sql_row['old_order_s_s34'];
			$old_s35=$sql_row['old_order_s_s35'];
			$old_s36=$sql_row['old_order_s_s36'];
			$old_s37=$sql_row['old_order_s_s37'];
			$old_s38=$sql_row['old_order_s_s38'];
			$old_s39=$sql_row['old_order_s_s39'];
			$old_s40=$sql_row['old_order_s_s40'];
			$old_s41=$sql_row['old_order_s_s41'];
			$old_s42=$sql_row['old_order_s_s42'];
			$old_s43=$sql_row['old_order_s_s43'];
			$old_s44=$sql_row['old_order_s_s44'];
			$old_s45=$sql_row['old_order_s_s45'];
			$old_s46=$sql_row['old_order_s_s46'];
			$old_s47=$sql_row['old_order_s_s47'];
			$old_s48=$sql_row['old_order_s_s48'];
			$old_s49=$sql_row['old_order_s_s49'];
			$old_s50=$sql_row['old_order_s_s50'];
			$old_order_total=$old_s01+$old_s02+$old_s03+$old_s04+$old_s05+$old_s06+$old_s07+$old_s08+$old_s09+$old_s10+$old_s11+$old_s12+$old_s13+$old_s14+$old_s15+$old_s16+$old_s17+$old_s18+$old_s19+$old_s20+$old_s21+$old_s22+$old_s23+$old_s24+$old_s25+$old_s26+$old_s27+$old_s28+$old_s29+$old_s30+$old_s31+$old_s32+$old_s33+$old_s34+$old_s35+$old_s36+$old_s37+$old_s38+$old_s39+$old_s40+$old_s41+$old_s42+$old_s43+$old_s44+$old_s45+$old_s46+$old_s47+$old_s48+$old_s49+$old_s50;
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
	
	
	
	$order_date=$sql_row['order_date'];
	$order_joins=$sql_row['order_joins'];
}

$join_s08=0;
$join_s10=0;
$join_schedule="";
$join_check=0;
if($order_joins!="0")
{
	$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_joins\"";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$join_s08=$sql_row['order_s_s08'];
		$join_s10=$sql_row['order_s_s10'];
		$join_schedule=$sql_row['order_del_no'].chr($sql_row['color_code']);
	}
	$join_check=1;
}

	
$sql="select * from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and tid=$cat_ref";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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

$sql="select * from $bai_pro3.cuttable_stat_log where cat_id=$cid and order_tid=\"$order_tid\"";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$excess=$sql_row['cuttable_percent'];
}

$sql="select sum(allocate_s01*plies) as \"cuttable_s_s01\",sum(allocate_s02*plies) as \"cuttable_s_s02\",sum(allocate_s03*plies) as \"cuttable_s_s03\",sum(allocate_s04*plies) as \"cuttable_s_s04\",sum(allocate_s05*plies) as \"cuttable_s_s05\",sum(allocate_s06*plies) as \"cuttable_s_s06\",sum(allocate_s07*plies) as \"cuttable_s_s07\",sum(allocate_s08*plies) as \"cuttable_s_s08\",sum(allocate_s09*plies) as \"cuttable_s_s09\",sum(allocate_s10*plies) as \"cuttable_s_s10\",sum(allocate_s11*plies) as \"cuttable_s_s11\",sum(allocate_s12*plies) as \"cuttable_s_s12\",sum(allocate_s13*plies) as \"cuttable_s_s13\",sum(allocate_s14*plies) as \"cuttable_s_s14\",sum(allocate_s15*plies) as \"cuttable_s_s15\",sum(allocate_s16*plies) as \"cuttable_s_s16\",sum(allocate_s17*plies) as \"cuttable_s_s17\",sum(allocate_s18*plies) as \"cuttable_s_s18\",sum(allocate_s19*plies) as \"cuttable_s_s19\",sum(allocate_s20*plies) as \"cuttable_s_s20\",sum(allocate_s21*plies) as \"cuttable_s_s21\",sum(allocate_s22*plies) as \"cuttable_s_s22\",sum(allocate_s23*plies) as \"cuttable_s_s23\",sum(allocate_s24*plies) as \"cuttable_s_s24\",sum(allocate_s25*plies) as \"cuttable_s_s25\",sum(allocate_s26*plies) as \"cuttable_s_s26\",sum(allocate_s27*plies) as \"cuttable_s_s27\",sum(allocate_s28*plies) as \"cuttable_s_s28\",sum(allocate_s29*plies) as \"cuttable_s_s29\",sum(allocate_s30*plies) as \"cuttable_s_s30\",sum(allocate_s31*plies) as \"cuttable_s_s31\",sum(allocate_s32*plies) as \"cuttable_s_s32\",sum(allocate_s33*plies) as \"cuttable_s_s33\",sum(allocate_s34*plies) as \"cuttable_s_s34\",sum(allocate_s35*plies) as \"cuttable_s_s35\",sum(allocate_s36*plies) as \"cuttable_s_s36\",sum(allocate_s37*plies) as \"cuttable_s_s37\",sum(allocate_s38*plies) as \"cuttable_s_s38\",sum(allocate_s39*plies) as \"cuttable_s_s39\",sum(allocate_s40*plies) as \"cuttable_s_s40\",sum(allocate_s41*plies) as \"cuttable_s_s41\",sum(allocate_s42*plies) as \"cuttable_s_s42\",sum(allocate_s43*plies) as \"cuttable_s_s43\",sum(allocate_s44*plies) as \"cuttable_s_s44\",sum(allocate_s45*plies) as \"cuttable_s_s45\",sum(allocate_s46*plies) as \"cuttable_s_s46\",sum(allocate_s47*plies) as \"cuttable_s_s47\",sum(allocate_s48*plies) as \"cuttable_s_s48\",sum(allocate_s49*plies) as \"cuttable_s_s49\",sum(allocate_s50*plies) as \"cuttable_s_s50\"
 from $bai_pro3.allocate_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
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

/* NEW 2010-05-22 */
//OLD Version 2012 (Changed due to calculate yy based on the marker lenght allocation as per dockets.)
/*
	
	$newyy=0;
	$new_order_qty=0;
	$sql2="select * from maker_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and allocate_ref>0";
	mysql_query($sql2,$link) or exit("Sql Error".mysql_error());
	$sql_result2=mysql_query($sql2,$link) or exit("Sql Error".mysql_error());
	while($sql_row2=mysql_fetch_array($sql_result2))
	{
		$mk_new_length=$sql_row2['mklength'];
		$new_allocate_ref=$sql_row2['allocate_ref'];
		
		$sql22="select * from allocate_stat_log where tid=$new_allocate_ref";
		mysql_query($sql22,$link) or exit("Sql Error".mysql_error());
		$sql_result22=mysql_query($sql22,$link) or exit("Sql Error".mysql_error());
		while($sql_row22=mysql_fetch_array($sql_result22))
		{
			$new_plies=$sql_row22['plies'];
		}
		$newyy=$newyy+($mk_new_length*$new_plies);
	}
	*/
	
	$newyy=0;
	$new_order_qty=0;
	$sql2="select mk_ref,p_plies,cat_ref,allocate_ref from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref  and allocate_ref>0";
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		
		$new_plies=$sql_row2['p_plies'];
		$mk_ref=$sql_row2['mk_ref'];
		//$sql22="select mklength from maker_stat_log where tid=$mk_ref";
		$sql22="select marker_length as mklength from $bai_pro3.marker_ref_matrix where marker_width=$purwidth and cat_ref=".$sql_row2['cat_ref']." and allocate_ref=".$sql_row2['allocate_ref'];
		//echo $sql22;
		mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row22=mysqli_fetch_array($sql_result22))
		{
			$mk_new_length=$sql_row22['mklength'];
		}
		$newyy=$newyy+($mk_new_length*$new_plies);
	}
	
	$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_confirm=mysqli_num_rows($sql_result);
	
	if($sql_num_confirm>0)
	{
		$sql2="select (order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50) as \"sum\" from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
	}
	else
	{
		$sql2="select (+order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50) as \"sum\" from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
	}
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$new_order_qty=$sql_row2['sum'];
		//$order_no=$sql_row2['order_no'];
	}
	
	//$newyy2=$newyy/$new_order_qty;
	//if added 1% to order_qty
	if($orderno=="1")
	{
		
		$newyy2=$newyy/$old_order_total;
	}
	else
	{
		
		$newyy2=$newyy/$new_order_qty;
	}
	$savings_new=round((($body_yy-$newyy2)/$body_yy)*100,1);
	//echo "<td>".$savings_new."%</td>";
	/* NEW 2010-05-22 */

?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 14">
<link rel=File-List href="CUT_PLAN_NEW_files/filelist.xml">
<style id="CUT_PLAN_NEW_13019_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl651301
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
	//border : .5pt solid black;
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
	border-right:.1pt solid windowtext;
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
.xl7732599
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
.xl6832599
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
 collapse;table-layout:fixed;width:3000pt'>
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
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl6432599></td>
 <td colspan=6 rowspan=3 class=xl8217319x valign="top" align="left"><img src="/sfcs_app/common/images/<?= $global_facility_code ?>_Logo.JPG" width="200" height="60"></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7832599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl1532599></td>
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
 </tr>
 
 <tr class=xl6513019 height=9 style='mso-height-source:userset;height:15.75pt'>
  <td colspan=2 class=xl7732599 style='border-right:.5pt solid black'>File No:</td>
  <td colspan=3 class=xl6832599 height=35></td>
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
  <td colspan=2 class=xl7732599 style='border-right:.5pt solid black'>Verified By:</td>
  <td colspan=3 class=xl6832599 height=35></td>

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
  <td colspan=28 class=xl9513019>Fabric Docket Issue Plan<span style='mso-spacerun:yes'>�</span></td>
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
  
<td class=xl6813019><?php echo $size01; ?></td>
<td class=xl6813019 style='border-left:none'><?php echo $size02; ?></td>
<td class=xl7013019><?php echo $size03; ?></td>
<td class=xl7013019><?php echo $size04; ?></td>
<td class=xl7013019><?php echo $size05; ?></td>
<td class=xl7013019><?php echo $size06; ?></td>
<td class=xl7013019><?php echo $size07; ?></td>
<td class=xl7013019><?php echo $size08; ?></td>
<td class=xl7013019><?php echo $size09; ?></td>
<td class=xl7013019><?php echo $size10; ?></td>
<td class=xl7013019><?php echo $size11; ?></td>
<td class=xl7013019><?php echo $size12; ?></td>
<td class=xl7013019><?php echo $size13; ?></td>
<td class=xl7013019><?php echo $size14; ?></td>
<td class=xl7013019><?php echo $size15; ?></td>
<td class=xl7013019><?php echo $size16; ?></td>
<td class=xl7013019><?php echo $size17; ?></td>
<td class=xl7013019><?php echo $size18; ?></td>
<td class=xl7013019><?php echo $size19; ?></td>
<td class=xl7013019><?php echo $size20; ?></td>
<td class=xl7013019><?php echo $size21; ?></td>
<td class=xl7013019><?php echo $size22; ?></td>
<td class=xl7013019><?php echo $size23; ?></td>
<td class=xl7013019><?php echo $size24; ?></td>
<td class=xl7013019><?php echo $size25; ?></td>
<td class=xl7013019><?php echo $size26; ?></td>
<td class=xl7013019><?php echo $size27; ?></td>
<td class=xl7013019><?php echo $size28; ?></td>
<td class=xl7013019><?php echo $size29; ?></td>
<td class=xl7013019><?php echo $size30; ?></td>
<td class=xl7013019><?php echo $size31; ?></td>
<td class=xl7013019><?php echo $size32; ?></td>
<td class=xl7013019><?php echo $size33; ?></td>
<td class=xl7013019><?php echo $size34; ?></td>
<td class=xl7013019><?php echo $size35; ?></td>
<td class=xl7013019><?php echo $size36; ?></td>
<td class=xl7013019><?php echo $size37; ?></td>
<td class=xl7013019><?php echo $size38; ?></td>
<td class=xl7013019><?php echo $size39; ?></td>
<td class=xl7013019><?php echo $size40; ?></td>
<td class=xl7013019><?php echo $size41; ?></td>
<td class=xl7013019><?php echo $size42; ?></td>
<td class=xl7013019><?php echo $size43; ?></td>
<td class=xl7013019><?php echo $size44; ?></td>
<td class=xl7013019><?php echo $size45; ?></td>
<td class=xl7013019><?php echo $size46; ?></td>
<td class=xl7013019><?php echo $size47; ?></td>
<td class=xl7013019><?php echo $size48; ?></td>
<td class=xl7013019><?php echo $size49; ?></td>
<td class=xl7013019><?php echo $size50; ?></td>
	<?php
  	}
	else
	{
	?>
	
<td class=xl6813019>01</td>
<td class=xl6813019 style='border-left:none'>02</td>
<td class=xl7013019>03</td>
<td class=xl7013019>04</td>
<td class=xl7013019>05</td>
<td class=xl7013019>06</td>
<td class=xl7013019>07</td>
<td class=xl7013019>08</td>
<td class=xl7013019>09</td>
<td class=xl7013019>10</td>
<td class=xl7013019>11</td>
<td class=xl7013019>12</td>
<td class=xl7013019>13</td>
<td class=xl7013019>14</td>
<td class=xl7013019>15</td>
<td class=xl7013019>16</td>
<td class=xl7013019>17</td>
<td class=xl7013019>18</td>
<td class=xl7013019>19</td>
<td class=xl7013019>20</td>
<td class=xl7013019>21</td>
<td class=xl7013019>22</td>
<td class=xl7013019>23</td>
<td class=xl7013019>24</td>
<td class=xl7013019>25</td>
<td class=xl7013019>26</td>
<td class=xl7013019>27</td>
<td class=xl7013019>28</td>
<td class=xl7013019>29</td>
<td class=xl7013019>30</td>
<td class=xl7013019>31</td>
<td class=xl7013019>32</td>
<td class=xl7013019>33</td>
<td class=xl7013019>34</td>
<td class=xl7013019>35</td>
<td class=xl7013019>36</td>
<td class=xl7013019>37</td>
<td class=xl7013019>38</td>
<td class=xl7013019>39</td>
<td class=xl7013019>40</td>
<td class=xl7013019>41</td>
<td class=xl7013019>42</td>
<td class=xl7013019>43</td>
<td class=xl7013019>44</td>
<td class=xl7013019>45</td>
<td class=xl7013019>46</td>
<td class=xl7013019>47</td>
<td class=xl7013019>48</td>
<td class=xl7013019>49</td>
<td class=xl7013019>50</td>
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
  echo "
   <td class=xl7413019> $old_s01</td>
 <td class=xl7513019> $old_s02</td>
 <td class=xl7513019> $old_s03</td>
 <td class=xl7513019> $old_s04</td>
 <td class=xl7513019> $old_s05</td>
 <td class=xl7513019> $old_s06</td>
 <td class=xl7513019> $old_s07</td>
 <td class=xl7513019> $old_s08</td>
 <td class=xl7513019> $old_s09</td>
 <td class=xl7513019> $old_s10</td>
 <td class=xl7513019> $old_s11</td>
 <td class=xl7513019> $old_s12</td>
 <td class=xl7513019> $old_s13</td>
 <td class=xl7513019> $old_s14</td>
 <td class=xl7513019> $old_s15</td>
 <td class=xl7513019> $old_s16</td>
 <td class=xl7513019> $old_s17</td>
 <td class=xl7513019> $old_s18</td>
 <td class=xl7513019> $old_s19</td>
 <td class=xl7513019> $old_s20</td>
 <td class=xl7513019> $old_s21</td>
 <td class=xl7513019> $old_s22</td>
 <td class=xl7513019> $old_s23</td>
 <td class=xl7513019> $old_s24</td>
 <td class=xl7513019> $old_s25</td>
 <td class=xl7513019> $old_s26</td>
 <td class=xl7513019> $old_s27</td>
 <td class=xl7513019> $old_s28</td>
 <td class=xl7513019> $old_s29</td>
 <td class=xl7513019> $old_s30</td>
 <td class=xl7513019> $old_s31</td>
 <td class=xl7513019> $old_s32</td>
 <td class=xl7513019> $old_s33</td>
 <td class=xl7513019> $old_s34</td>
 <td class=xl7513019> $old_s35</td>
 <td class=xl7513019> $old_s36</td>
 <td class=xl7513019> $old_s37</td>
 <td class=xl7513019> $old_s38</td>
 <td class=xl7513019> $old_s39</td>
 <td class=xl7513019> $old_s40</td>
 <td class=xl7513019> $old_s41</td>
 <td class=xl7513019> $old_s42</td>
 <td class=xl7513019> $old_s43</td>
 <td class=xl7513019> $old_s44</td>
 <td class=xl7513019> $old_s45</td>
 <td class=xl7513019> $old_s46</td>
 <td class=xl7513019> $old_s47</td>
 <td class=xl7513019> $old_s48</td>
 <td class=xl7513019> $old_s49</td>
 <td class=xl7513019> $old_s50</td>

  <td class=xl7513019> $old_order_total</td>";
  }
  else
  {
  echo " 
   <td class=xl7413019> $o_s01</td>
 <td class=xl7513019> $o_s02</td>
 <td class=xl7513019> $o_s03</td>
 <td class=xl7513019> $o_s04</td>
 <td class=xl7513019> $o_s05</td>
 <td class=xl7513019> $o_s06</td>
 <td class=xl7513019> $o_s07</td>
 <td class=xl7513019> $o_s08</td>
 <td class=xl7513019> $o_s09</td>
 <td class=xl7513019> $o_s10</td>
 <td class=xl7513019> $o_s11</td>
 <td class=xl7513019> $o_s12</td>
 <td class=xl7513019> $o_s13</td>
 <td class=xl7513019> $o_s14</td>
 <td class=xl7513019> $o_s15</td>
 <td class=xl7513019> $o_s16</td>
 <td class=xl7513019> $o_s17</td>
 <td class=xl7513019> $o_s18</td>
 <td class=xl7513019> $o_s19</td>
 <td class=xl7513019> $o_s20</td>
 <td class=xl7513019> $o_s21</td>
 <td class=xl7513019> $o_s22</td>
 <td class=xl7513019> $o_s23</td>
 <td class=xl7513019> $o_s24</td>
 <td class=xl7513019> $o_s25</td>
 <td class=xl7513019> $o_s26</td>
 <td class=xl7513019> $o_s27</td>
 <td class=xl7513019> $o_s28</td>
 <td class=xl7513019> $o_s29</td>
 <td class=xl7513019> $o_s30</td>
 <td class=xl7513019> $o_s31</td>
 <td class=xl7513019> $o_s32</td>
 <td class=xl7513019> $o_s33</td>
 <td class=xl7513019> $o_s34</td>
 <td class=xl7513019> $o_s35</td>
 <td class=xl7513019> $o_s36</td>
 <td class=xl7513019> $o_s37</td>
 <td class=xl7513019> $o_s38</td>
 <td class=xl7513019> $o_s39</td>
 <td class=xl7513019> $o_s40</td>
 <td class=xl7513019> $o_s41</td>
 <td class=xl7513019> $o_s42</td>
 <td class=xl7513019> $o_s43</td>
 <td class=xl7513019> $o_s44</td>
 <td class=xl7513019> $o_s45</td>
 <td class=xl7513019> $o_s46</td>
 <td class=xl7513019> $o_s47</td>
 <td class=xl7513019> $o_s48</td>
 <td class=xl7513019> $o_s49</td>
 <td class=xl7513019> $o_s50</td>

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
  echo "<td class=xl7313019> $o_s01</td>
 
  <td class=xl7513019> $o_s02</td>
 <td class=xl7513019> $o_s03</td>
 <td class=xl7513019> $o_s04</td>
 <td class=xl7513019> $o_s05</td>
 <td class=xl7513019> $o_s06</td>
 <td class=xl7513019> $o_s07</td>
 <td class=xl7513019> $o_s08</td>
 <td class=xl7513019> $o_s09</td>
 <td class=xl7513019> $o_s10</td>
 <td class=xl7513019> $o_s11</td>
 <td class=xl7513019> $o_s12</td>
 <td class=xl7513019> $o_s13</td>
 <td class=xl7513019> $o_s14</td>
 <td class=xl7513019> $o_s15</td>
 <td class=xl7513019> $o_s16</td>
 <td class=xl7513019> $o_s17</td>
 <td class=xl7513019> $o_s18</td>
 <td class=xl7513019> $o_s19</td>
 <td class=xl7513019> $o_s20</td>
 <td class=xl7513019> $o_s21</td>
 <td class=xl7513019> $o_s22</td>
 <td class=xl7513019> $o_s23</td>
 <td class=xl7513019> $o_s24</td>
 <td class=xl7513019> $o_s25</td>
 <td class=xl7513019> $o_s26</td>
 <td class=xl7513019> $o_s27</td>
 <td class=xl7513019> $o_s28</td>
 <td class=xl7513019> $o_s29</td>
 <td class=xl7513019> $o_s30</td>
 <td class=xl7513019> $o_s31</td>
 <td class=xl7513019> $o_s32</td>
 <td class=xl7513019> $o_s33</td>
 <td class=xl7513019> $o_s34</td>
 <td class=xl7513019> $o_s35</td>
 <td class=xl7513019> $o_s36</td>
 <td class=xl7513019> $o_s37</td>
 <td class=xl7513019> $o_s38</td>
 <td class=xl7513019> $o_s39</td>
 <td class=xl7513019> $o_s40</td>
 <td class=xl7513019> $o_s41</td>
 <td class=xl7513019> $o_s42</td>
 <td class=xl7513019> $o_s43</td>
 <td class=xl7513019> $o_s44</td>
 <td class=xl7513019> $o_s45</td>
 <td class=xl7513019> $o_s46</td>
 <td class=xl7513019> $o_s47</td>
 <td class=xl7513019> $o_s48</td>
 <td class=xl7513019> $o_s49</td>
 <td class=xl7513019> $o_s50</td>
  <td class=xl7513019> $order_total</td>";
  }
  else
  {
  echo "<td class=xl7213019 width=70 style='width:53pt'>( $excess%)</td>";
  echo "
   <td class=xl7313019> $c_s01</td>
 <td class=xl7513019> $c_s02</td>
 <td class=xl7513019> $c_s03</td>
 <td class=xl7513019> $c_s04</td>
 <td class=xl7513019> $c_s05</td>
 <td class=xl7513019> $c_s06</td>
 <td class=xl7513019> $c_s07</td>
 <td class=xl7513019> $c_s08</td>
 <td class=xl7513019> $c_s09</td>
 <td class=xl7513019> $c_s10</td>
 <td class=xl7513019> $c_s11</td>
 <td class=xl7513019> $c_s12</td>
 <td class=xl7513019> $c_s13</td>
 <td class=xl7513019> $c_s14</td>
 <td class=xl7513019> $c_s15</td>
 <td class=xl7513019> $c_s16</td>
 <td class=xl7513019> $c_s17</td>
 <td class=xl7513019> $c_s18</td>
 <td class=xl7513019> $c_s19</td>
 <td class=xl7513019> $c_s20</td>
 <td class=xl7513019> $c_s21</td>
 <td class=xl7513019> $c_s22</td>
 <td class=xl7513019> $c_s23</td>
 <td class=xl7513019> $c_s24</td>
 <td class=xl7513019> $c_s25</td>
 <td class=xl7513019> $c_s26</td>
 <td class=xl7513019> $c_s27</td>
 <td class=xl7513019> $c_s28</td>
 <td class=xl7513019> $c_s29</td>
 <td class=xl7513019> $c_s30</td>
 <td class=xl7513019> $c_s31</td>
 <td class=xl7513019> $c_s32</td>
 <td class=xl7513019> $c_s33</td>
 <td class=xl7513019> $c_s34</td>
 <td class=xl7513019> $c_s35</td>
 <td class=xl7513019> $c_s36</td>
 <td class=xl7513019> $c_s37</td>
 <td class=xl7513019> $c_s38</td>
 <td class=xl7513019> $c_s39</td>
 <td class=xl7513019> $c_s40</td>
 <td class=xl7513019> $c_s41</td>
 <td class=xl7513019> $c_s42</td>
 <td class=xl7513019> $c_s43</td>
 <td class=xl7513019> $c_s44</td>
 <td class=xl7513019> $c_s45</td>
 <td class=xl7513019> $c_s46</td>
 <td class=xl7513019> $c_s47</td>
 <td class=xl7513019> $c_s48</td>
 <td class=xl7513019> $c_s49</td>
 <td class=xl7513019> $c_s50</td>

  <td class=xl7513019> $cuttable_total</td>";
  }
  ?>
  <td colspan=3 class=xl9813019 style='border-right:.5pt solid black'>Material
  Allowed</td>
  <td class=xl7713019><?php echo round(($order_total*$body_yy),0); ?></td>
  <td class=xl6613019></td>
  <td class=xl6613019></td>
  <td colspan=3 class=xl9813019 style='border-right:.5pt solid black'>Used
  <?php $fab_uom ?></td>
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
  
 <td class=xl7313019><?php echo ($c_s01-$o_s01); ?></td>
<td class=xl7513019><?php echo ($c_s02-$o_s02); ?></td>
<td class=xl7513019><?php echo ($c_s03-$o_s03); ?></td>
<td class=xl7513019><?php echo ($c_s04-$o_s04); ?></td>
<td class=xl7513019><?php echo ($c_s05-$o_s05); ?></td>
<td class=xl7513019><?php echo ($c_s06-$o_s06); ?></td>
<td class=xl7513019><?php echo ($c_s07-$o_s07); ?></td>
<td class=xl7513019><?php echo ($c_s08-$o_s08); ?></td>
<td class=xl7513019><?php echo ($c_s09-$o_s09); ?></td>
<td class=xl7513019><?php echo ($c_s10-$o_s10); ?></td>
<td class=xl7513019><?php echo ($c_s11-$o_s11); ?></td>
<td class=xl7513019><?php echo ($c_s12-$o_s12); ?></td>
<td class=xl7513019><?php echo ($c_s13-$o_s13); ?></td>
<td class=xl7513019><?php echo ($c_s14-$o_s14); ?></td>
<td class=xl7513019><?php echo ($c_s15-$o_s15); ?></td>
<td class=xl7513019><?php echo ($c_s16-$o_s16); ?></td>
<td class=xl7513019><?php echo ($c_s17-$o_s17); ?></td>
<td class=xl7513019><?php echo ($c_s18-$o_s18); ?></td>
<td class=xl7513019><?php echo ($c_s19-$o_s19); ?></td>
<td class=xl7513019><?php echo ($c_s20-$o_s20); ?></td>
<td class=xl7513019><?php echo ($c_s21-$o_s21); ?></td>
<td class=xl7513019><?php echo ($c_s22-$o_s22); ?></td>
<td class=xl7513019><?php echo ($c_s23-$o_s23); ?></td>
<td class=xl7513019><?php echo ($c_s24-$o_s24); ?></td>
<td class=xl7513019><?php echo ($c_s25-$o_s25); ?></td>
<td class=xl7513019><?php echo ($c_s26-$o_s26); ?></td>
<td class=xl7513019><?php echo ($c_s27-$o_s27); ?></td>
<td class=xl7513019><?php echo ($c_s28-$o_s28); ?></td>
<td class=xl7513019><?php echo ($c_s29-$o_s29); ?></td>
<td class=xl7513019><?php echo ($c_s30-$o_s30); ?></td>
<td class=xl7513019><?php echo ($c_s31-$o_s31); ?></td>
<td class=xl7513019><?php echo ($c_s32-$o_s32); ?></td>
<td class=xl7513019><?php echo ($c_s33-$o_s33); ?></td>
<td class=xl7513019><?php echo ($c_s34-$o_s34); ?></td>
<td class=xl7513019><?php echo ($c_s35-$o_s35); ?></td>
<td class=xl7513019><?php echo ($c_s36-$o_s36); ?></td>
<td class=xl7513019><?php echo ($c_s37-$o_s37); ?></td>
<td class=xl7513019><?php echo ($c_s38-$o_s38); ?></td>
<td class=xl7513019><?php echo ($c_s39-$o_s39); ?></td>
<td class=xl7513019><?php echo ($c_s40-$o_s40); ?></td>
<td class=xl7513019><?php echo ($c_s41-$o_s41); ?></td>
<td class=xl7513019><?php echo ($c_s42-$o_s42); ?></td>
<td class=xl7513019><?php echo ($c_s43-$o_s43); ?></td>
<td class=xl7513019><?php echo ($c_s44-$o_s44); ?></td>
<td class=xl7513019><?php echo ($c_s45-$o_s45); ?></td>
<td class=xl7513019><?php echo ($c_s46-$o_s46); ?></td>
<td class=xl7513019><?php echo ($c_s47-$o_s47); ?></td>
<td class=xl7513019><?php echo ($c_s48-$o_s48); ?></td>
<td class=xl7513019><?php echo ($c_s49-$o_s49); ?></td>
<td class=xl7513019><?php echo ($c_s50-$o_s50); ?></td>
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
  
  <td colspan=26 class=xl10313019 style='border-right:.5pt solid black;
  border-left:none'>RM Details</td>
 
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
  <td height=18  class=xl6613019 style='height:15.0pt'></td>
  <?php
  	if($flag == 1)
	{
		
	?>
   <td class=xl8413019><?php echo $size01; ?></td>
 <td class=xl8413019><?php echo $size02; ?></td>
 <td class=xl8413019><?php echo $size03; ?></td>
 <td class=xl8413019><?php echo $size04; ?></td>
 <td class=xl8413019><?php echo $size05; ?></td>
 <td class=xl8413019><?php echo $size06; ?></td>
 <td class=xl8413019><?php echo $size07; ?></td>
 <td class=xl8413019><?php echo $size08; ?></td>
 <td class=xl8413019><?php echo $size09; ?></td>
 <td class=xl8413019><?php echo $size10; ?></td>
 <td class=xl8413019><?php echo $size11; ?></td>
 <td class=xl8413019><?php echo $size12; ?></td>
 <td class=xl8413019><?php echo $size13; ?></td>
 <td class=xl8413019><?php echo $size14; ?></td>
 <td class=xl8413019><?php echo $size15; ?></td>
 <td class=xl8413019><?php echo $size16; ?></td>
 <td class=xl8413019><?php echo $size17; ?></td>
 <td class=xl8413019><?php echo $size18; ?></td>
 <td class=xl8413019><?php echo $size19; ?></td>
 <td class=xl8413019><?php echo $size20; ?></td>
 <td class=xl8413019><?php echo $size21; ?></td>
 <td class=xl8413019><?php echo $size22; ?></td>
 <td class=xl8413019><?php echo $size23; ?></td>
 <td class=xl8413019><?php echo $size24; ?></td>
 <td class=xl8413019><?php echo $size25; ?></td>
 <td class=xl8413019><?php echo $size26; ?></td>
 <td class=xl8413019><?php echo $size27; ?></td>
 <td class=xl8413019><?php echo $size28; ?></td>
 <td class=xl8413019><?php echo $size29; ?></td>
 <td class=xl8413019><?php echo $size30; ?></td>
 <td class=xl8413019><?php echo $size31; ?></td>
 <td class=xl8413019><?php echo $size32; ?></td>
 <td class=xl8413019><?php echo $size33; ?></td>
 <td class=xl8413019><?php echo $size34; ?></td>
 <td class=xl8413019><?php echo $size35; ?></td>
 <td class=xl8413019><?php echo $size36; ?></td>
 <td class=xl8413019><?php echo $size37; ?></td>
 <td class=xl8413019><?php echo $size38; ?></td>
 <td class=xl8413019><?php echo $size39; ?></td>
 <td class=xl8413019><?php echo $size40; ?></td>
 <td class=xl8413019><?php echo $size41; ?></td>
 <td class=xl8413019><?php echo $size42; ?></td>
 <td class=xl8413019><?php echo $size43; ?></td>
 <td class=xl8413019><?php echo $size44; ?></td>
 <td class=xl8413019><?php echo $size45; ?></td>
 <td class=xl8413019><?php echo $size46; ?></td>
 <td class=xl8413019><?php echo $size47; ?></td>
 <td class=xl8413019><?php echo $size48; ?></td>
 <td class=xl8413019><?php echo $size49; ?></td>
 <td class=xl8413019><?php echo $size50; ?></td>

	<?php
  	}
	else
	{
	?>
	
<td class=xl8413019>01</td>
<td class=xl8413019>02</td>
<td class=xl8413019>03</td>
<td class=xl8413019>04</td>
<td class=xl8413019>05</td>
<td class=xl8413019>06</td>
<td class=xl8413019>07</td>
<td class=xl8413019>08</td>
<td class=xl8413019>09</td>
<td class=xl8413019>10</td>
<td class=xl8413019>11</td>
<td class=xl8413019>12</td>
<td class=xl8413019>13</td>
<td class=xl8413019>14</td>
<td class=xl8413019>15</td>
<td class=xl8413019>16</td>
<td class=xl8413019>17</td>
<td class=xl8413019>18</td>
<td class=xl8413019>19</td>
<td class=xl8413019>20</td>
<td class=xl8413019>21</td>
<td class=xl8413019>22</td>
<td class=xl8413019>23</td>
<td class=xl8413019>24</td>
<td class=xl8413019>25</td>
<td class=xl8413019>26</td>
<td class=xl8413019>27</td>
<td class=xl8413019>28</td>
<td class=xl8413019>29</td>
<td class=xl8413019>30</td>
<td class=xl8413019>31</td>
<td class=xl8413019>32</td>
<td class=xl8413019>33</td>
<td class=xl8413019>34</td>
<td class=xl8413019>35</td>
<td class=xl8413019>36</td>
<td class=xl8413019>37</td>
<td class=xl8413019>38</td>
<td class=xl8413019>39</td>
<td class=xl8413019>40</td>
<td class=xl8413019>41</td>
<td class=xl8413019>42</td>
<td class=xl8413019>43</td>
<td class=xl8413019>44</td>
<td class=xl8413019>45</td>
<td class=xl8413019>46</td>
<td class=xl8413019>47</td>
<td class=xl8413019>48</td>
<td class=xl8413019>49</td>
<td class=xl8413019>50</td>
	<?php
	}
	?>
  <td colspan=2 class=xl8413019>Requested QTY</td>
  <td colspan=2 class=xl8413019>Issued QTY</td>
  <td colspan=2 class=xl8413019>DATE</td>
  <td class=xl8413019>TIME</td>
  <td class=xl8413019>SEC</td>
  <td colspan=2 class=xl8413019>PICKING LIST NO</td>
  <td colspan=2 class=xl8413019>DEL NO</td>
  <td colspan=2 class=xl8413019>ISSUED BY</td>
  <td colspan=2 class=xl8413019>RECEIVED BY</td>
  <td colspan=5 class=xl8413019>REMARKS/Roll No's</td>
  <td></td>
 </tr>
 
 
 <?php  
 
$a_s01_tot=0;
$a_s02_tot=0;
$a_s03_tot=0;
$a_s04_tot=0;
$a_s05_tot=0;
$a_s06_tot=0;
$a_s07_tot=0;
$a_s08_tot=0;
$a_s09_tot=0;
$a_s10_tot=0;
$a_s11_tot=0;
$a_s12_tot=0;
$a_s13_tot=0;
$a_s14_tot=0;
$a_s15_tot=0;
$a_s16_tot=0;
$a_s17_tot=0;
$a_s18_tot=0;
$a_s19_tot=0;
$a_s20_tot=0;
$a_s21_tot=0;
$a_s22_tot=0;
$a_s23_tot=0;
$a_s24_tot=0;
$a_s25_tot=0;
$a_s26_tot=0;
$a_s27_tot=0;
$a_s28_tot=0;
$a_s29_tot=0;
$a_s30_tot=0;
$a_s31_tot=0;
$a_s32_tot=0;
$a_s33_tot=0;
$a_s34_tot=0;
$a_s35_tot=0;
$a_s36_tot=0;
$a_s37_tot=0;
$a_s38_tot=0;
$a_s39_tot=0;
$a_s40_tot=0;
$a_s41_tot=0;
$a_s42_tot=0;
$a_s43_tot=0;
$a_s44_tot=0;
$a_s45_tot=0;
$a_s46_tot=0;
$a_s47_tot=0;
$a_s48_tot=0;
$a_s49_tot=0;
$a_s50_tot=0;

	$plies_tot=0;
	
$sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Pilot\"  order by acutno";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
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

	$cutno=$sql_row['acutno'];
	$plies=$sql_row['p_plies'];
	$docketno=$sql_row['doc_no'];
	$docketdate=$sql_row['date'];
	$mk_ref=$sql_row['mk_ref'];
	
	 $a_s01_tot=$a_s01_tot+($a_s01*$plies);
 $a_s02_tot=$a_s02_tot+($a_s02*$plies);
 $a_s03_tot=$a_s03_tot+($a_s03*$plies);
 $a_s04_tot=$a_s04_tot+($a_s04*$plies);
 $a_s05_tot=$a_s05_tot+($a_s05*$plies);
 $a_s06_tot=$a_s06_tot+($a_s06*$plies);
 $a_s07_tot=$a_s07_tot+($a_s07*$plies);
 $a_s08_tot=$a_s08_tot+($a_s08*$plies);
 $a_s09_tot=$a_s09_tot+($a_s09*$plies);
 $a_s10_tot=$a_s10_tot+($a_s10*$plies);
 $a_s11_tot=$a_s11_tot+($a_s11*$plies);
 $a_s12_tot=$a_s12_tot+($a_s12*$plies);
 $a_s13_tot=$a_s13_tot+($a_s13*$plies);
 $a_s14_tot=$a_s14_tot+($a_s14*$plies);
 $a_s15_tot=$a_s15_tot+($a_s15*$plies);
 $a_s16_tot=$a_s16_tot+($a_s16*$plies);
 $a_s17_tot=$a_s17_tot+($a_s17*$plies);
 $a_s18_tot=$a_s18_tot+($a_s18*$plies);
 $a_s19_tot=$a_s19_tot+($a_s19*$plies);
 $a_s20_tot=$a_s20_tot+($a_s20*$plies);
 $a_s21_tot=$a_s21_tot+($a_s21*$plies);
 $a_s22_tot=$a_s22_tot+($a_s22*$plies);
 $a_s23_tot=$a_s23_tot+($a_s23*$plies);
 $a_s24_tot=$a_s24_tot+($a_s24*$plies);
 $a_s25_tot=$a_s25_tot+($a_s25*$plies);
 $a_s26_tot=$a_s26_tot+($a_s26*$plies);
 $a_s27_tot=$a_s27_tot+($a_s27*$plies);
 $a_s28_tot=$a_s28_tot+($a_s28*$plies);
 $a_s29_tot=$a_s29_tot+($a_s29*$plies);
 $a_s30_tot=$a_s30_tot+($a_s30*$plies);
 $a_s31_tot=$a_s31_tot+($a_s31*$plies);
 $a_s32_tot=$a_s32_tot+($a_s32*$plies);
 $a_s33_tot=$a_s33_tot+($a_s33*$plies);
 $a_s34_tot=$a_s34_tot+($a_s34*$plies);
 $a_s35_tot=$a_s35_tot+($a_s35*$plies);
 $a_s36_tot=$a_s36_tot+($a_s36*$plies);
 $a_s37_tot=$a_s37_tot+($a_s37*$plies);
 $a_s38_tot=$a_s38_tot+($a_s38*$plies);
 $a_s39_tot=$a_s39_tot+($a_s39*$plies);
 $a_s40_tot=$a_s40_tot+($a_s40*$plies);
 $a_s41_tot=$a_s41_tot+($a_s41*$plies);
 $a_s42_tot=$a_s42_tot+($a_s42*$plies);
 $a_s43_tot=$a_s43_tot+($a_s43*$plies);
 $a_s44_tot=$a_s44_tot+($a_s44*$plies);
 $a_s45_tot=$a_s45_tot+($a_s45*$plies);
 $a_s46_tot=$a_s46_tot+($a_s46*$plies);
 $a_s47_tot=$a_s47_tot+($a_s47*$plies);
 $a_s48_tot=$a_s48_tot+($a_s48*$plies);
 $a_s49_tot=$a_s49_tot+($a_s49*$plies);
 $a_s50_tot=$a_s50_tot+($a_s50*$plies);


	$plies_tot=$plies_tot+$plies;
	
	echo "<tr class=xl6613019 height='40' style='mso-height-source:userset;'>
  <td height=20 class=xl6613019 style='height:15.0pt' ></td>";
   echo "<td class=xl8613019>Pilot</td>";
  echo "<td class=xl8713019>".$a_s01."</td>";
 echo "<td class=xl8713019>".$a_s02."</td>";
 echo "<td class=xl8713019>".$a_s03."</td>";
 echo "<td class=xl8713019>".$a_s04."</td>";
 echo "<td class=xl8713019>".$a_s05."</td>";
 echo "<td class=xl8713019>".$a_s06."</td>";
 echo "<td class=xl8713019>".$a_s07."</td>";
 echo "<td class=xl8713019>".$a_s08."</td>";
 echo "<td class=xl8713019>".$a_s09."</td>";
 echo "<td class=xl8713019>".$a_s10."</td>";
 echo "<td class=xl8713019>".$a_s11."</td>";
 echo "<td class=xl8713019>".$a_s12."</td>";
 echo "<td class=xl8713019>".$a_s13."</td>";
 echo "<td class=xl8713019>".$a_s14."</td>";
 echo "<td class=xl8713019>".$a_s15."</td>";
 echo "<td class=xl8713019>".$a_s16."</td>";
 echo "<td class=xl8713019>".$a_s17."</td>";
 echo "<td class=xl8713019>".$a_s18."</td>";
 echo "<td class=xl8713019>".$a_s19."</td>";
 echo "<td class=xl8713019>".$a_s20."</td>";
 echo "<td class=xl8713019>".$a_s21."</td>";
 echo "<td class=xl8713019>".$a_s22."</td>";
 echo "<td class=xl8713019>".$a_s23."</td>";
 echo "<td class=xl8713019>".$a_s24."</td>";
 echo "<td class=xl8713019>".$a_s25."</td>";
 echo "<td class=xl8713019>".$a_s26."</td>";
 echo "<td class=xl8713019>".$a_s27."</td>";
 echo "<td class=xl8713019>".$a_s28."</td>";
 echo "<td class=xl8713019>".$a_s29."</td>";
 echo "<td class=xl8713019>".$a_s30."</td>";
 echo "<td class=xl8713019>".$a_s31."</td>";
 echo "<td class=xl8713019>".$a_s32."</td>";
 echo "<td class=xl8713019>".$a_s33."</td>";
 echo "<td class=xl8713019>".$a_s34."</td>";
 echo "<td class=xl8713019>".$a_s35."</td>";
 echo "<td class=xl8713019>".$a_s36."</td>";
 echo "<td class=xl8713019>".$a_s37."</td>";
 echo "<td class=xl8713019>".$a_s38."</td>";
 echo "<td class=xl8713019>".$a_s39."</td>";
 echo "<td class=xl8713019>".$a_s40."</td>";
 echo "<td class=xl8713019>".$a_s41."</td>";
 echo "<td class=xl8713019>".$a_s42."</td>";
 echo "<td class=xl8713019>".$a_s43."</td>";
 echo "<td class=xl8713019>".$a_s44."</td>";
 echo "<td class=xl8713019>".$a_s45."</td>";
 echo "<td class=xl8713019>".$a_s46."</td>";
 echo "<td class=xl8713019>".$a_s47."</td>";
 echo "<td class=xl8713019>".$a_s48."</td>";
 echo "<td class=xl8713019>".$a_s49."</td>";
 echo "<td class=xl8713019>".$a_s50."</td>";

 
  echo "<td colspan=2 class=xl8713019></td>";
  echo "<td colspan=2 class=xl8713019></td>";
   echo "<td colspan=2 class=xl8713019></td>";
   echo "<td class=xl8713019></td>";
  echo "<td class=xl8713019></td>";
  echo "<td colspan=2 class=xl8713019></td>";
  echo "<td colspan=2 class=xl8713019></td>";
  echo "<td colspan=2 class=xl8713019></td>";
  echo "<td colspan=2 class=xl8713019></td>";
  echo "<td colspan=5 class=xl8713019></td>";
  
  echo "</tr>";

}
 
 	$a_s01_tot=0;
$a_s02_tot=0;
$a_s03_tot=0;
$a_s04_tot=0;
$a_s05_tot=0;
$a_s06_tot=0;
$a_s07_tot=0;
$a_s08_tot=0;
$a_s09_tot=0;
$a_s10_tot=0;
$a_s11_tot=0;
$a_s12_tot=0;
$a_s13_tot=0;
$a_s14_tot=0;
$a_s15_tot=0;
$a_s16_tot=0;
$a_s17_tot=0;
$a_s18_tot=0;
$a_s19_tot=0;
$a_s20_tot=0;
$a_s21_tot=0;
$a_s22_tot=0;
$a_s23_tot=0;
$a_s24_tot=0;
$a_s25_tot=0;
$a_s26_tot=0;
$a_s27_tot=0;
$a_s28_tot=0;
$a_s29_tot=0;
$a_s30_tot=0;
$a_s31_tot=0;
$a_s32_tot=0;
$a_s33_tot=0;
$a_s34_tot=0;
$a_s35_tot=0;
$a_s36_tot=0;
$a_s37_tot=0;
$a_s38_tot=0;
$a_s39_tot=0;
$a_s40_tot=0;
$a_s41_tot=0;
$a_s42_tot=0;
$a_s43_tot=0;
$a_s44_tot=0;
$a_s45_tot=0;
$a_s46_tot=0;
$a_s47_tot=0;
$a_s48_tot=0;
$a_s49_tot=0;
$a_s50_tot=0;
	
	$plies_tot=0;
	
$ex_s01_tot=0;
$ex_s02_tot=0;
$ex_s03_tot=0;
$ex_s04_tot=0;
$ex_s05_tot=0;
$ex_s06_tot=0;
$ex_s07_tot=0;
$ex_s08_tot=0;
$ex_s09_tot=0;
$ex_s10_tot=0;
$ex_s11_tot=0;
$ex_s12_tot=0;
$ex_s13_tot=0;
$ex_s14_tot=0;
$ex_s15_tot=0;
$ex_s16_tot=0;
$ex_s17_tot=0;
$ex_s18_tot=0;
$ex_s19_tot=0;
$ex_s20_tot=0;
$ex_s21_tot=0;
$ex_s22_tot=0;
$ex_s23_tot=0;
$ex_s24_tot=0;
$ex_s25_tot=0;
$ex_s26_tot=0;
$ex_s27_tot=0;
$ex_s28_tot=0;
$ex_s29_tot=0;
$ex_s30_tot=0;
$ex_s31_tot=0;
$ex_s32_tot=0;
$ex_s33_tot=0;
$ex_s34_tot=0;
$ex_s35_tot=0;
$ex_s36_tot=0;
$ex_s37_tot=0;
$ex_s38_tot=0;
$ex_s39_tot=0;
$ex_s40_tot=0;
$ex_s41_tot=0;
$ex_s42_tot=0;
$ex_s43_tot=0;
$ex_s44_tot=0;
$ex_s45_tot=0;
$ex_s46_tot=0;
$ex_s47_tot=0;
$ex_s48_tot=0;
$ex_s49_tot=0;
$ex_s50_tot=0;

	
	
	
	//To identify the first cut no.	
$sql="select min(acutno) as firstcut from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{	
	$first_cut=$sql_row['firstcut'];
}

	
$sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Normal\" order by acutno";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
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
	$cutno=$sql_row['acutno'];
	$plies=$sql_row['p_plies']; //20110911
	$docketno=$sql_row['doc_no'];
	$docketdate=$sql_row['date'];
	$mk_ref=$sql_row['mk_ref'];
	
$a_s01_tot=$a_s01_tot+($a_s01*$plies);
$a_s02_tot=$a_s02_tot+($a_s02*$plies);
$a_s03_tot=$a_s03_tot+($a_s03*$plies);
$a_s04_tot=$a_s04_tot+($a_s04*$plies);
$a_s05_tot=$a_s05_tot+($a_s05*$plies);
$a_s06_tot=$a_s06_tot+($a_s06*$plies);
$a_s07_tot=$a_s07_tot+($a_s07*$plies);
$a_s08_tot=$a_s08_tot+($a_s08*$plies);
$a_s09_tot=$a_s09_tot+($a_s09*$plies);
$a_s10_tot=$a_s10_tot+($a_s10*$plies);
$a_s11_tot=$a_s11_tot+($a_s11*$plies);
$a_s12_tot=$a_s12_tot+($a_s12*$plies);
$a_s13_tot=$a_s13_tot+($a_s13*$plies);
$a_s14_tot=$a_s14_tot+($a_s14*$plies);
$a_s15_tot=$a_s15_tot+($a_s15*$plies);
$a_s16_tot=$a_s16_tot+($a_s16*$plies);
$a_s17_tot=$a_s17_tot+($a_s17*$plies);
$a_s18_tot=$a_s18_tot+($a_s18*$plies);
$a_s19_tot=$a_s19_tot+($a_s19*$plies);
$a_s20_tot=$a_s20_tot+($a_s20*$plies);
$a_s21_tot=$a_s21_tot+($a_s21*$plies);
$a_s22_tot=$a_s22_tot+($a_s22*$plies);
$a_s23_tot=$a_s23_tot+($a_s23*$plies);
$a_s24_tot=$a_s24_tot+($a_s24*$plies);
$a_s25_tot=$a_s25_tot+($a_s25*$plies);
$a_s26_tot=$a_s26_tot+($a_s26*$plies);
$a_s27_tot=$a_s27_tot+($a_s27*$plies);
$a_s28_tot=$a_s28_tot+($a_s28*$plies);
$a_s29_tot=$a_s29_tot+($a_s29*$plies);
$a_s30_tot=$a_s30_tot+($a_s30*$plies);
$a_s31_tot=$a_s31_tot+($a_s31*$plies);
$a_s32_tot=$a_s32_tot+($a_s32*$plies);
$a_s33_tot=$a_s33_tot+($a_s33*$plies);
$a_s34_tot=$a_s34_tot+($a_s34*$plies);
$a_s35_tot=$a_s35_tot+($a_s35*$plies);
$a_s36_tot=$a_s36_tot+($a_s36*$plies);
$a_s37_tot=$a_s37_tot+($a_s37*$plies);
$a_s38_tot=$a_s38_tot+($a_s38*$plies);
$a_s39_tot=$a_s39_tot+($a_s39*$plies);
$a_s40_tot=$a_s40_tot+($a_s40*$plies);
$a_s41_tot=$a_s41_tot+($a_s41*$plies);
$a_s42_tot=$a_s42_tot+($a_s42*$plies);
$a_s43_tot=$a_s43_tot+($a_s43*$plies);
$a_s44_tot=$a_s44_tot+($a_s44*$plies);
$a_s45_tot=$a_s45_tot+($a_s45*$plies);
$a_s46_tot=$a_s46_tot+($a_s46*$plies);
$a_s47_tot=$a_s47_tot+($a_s47*$plies);
$a_s48_tot=$a_s48_tot+($a_s48*$plies);
$a_s49_tot=$a_s49_tot+($a_s49*$plies);
$a_s50_tot=$a_s50_tot+($a_s50*$plies);

$plies_tot=$plies_tot+$plies;  // NEW
	
	if($cutno==$first_cut)
	{
	
$ex_s01=($c_s01-$o_s01);
$ex_s02=($c_s02-$o_s02);
$ex_s03=($c_s03-$o_s03);
$ex_s04=($c_s04-$o_s04);
$ex_s05=($c_s05-$o_s05);
$ex_s06=($c_s06-$o_s06);
$ex_s07=($c_s07-$o_s07);
$ex_s08=($c_s08-$o_s08);
$ex_s09=($c_s09-$o_s09);
$ex_s10=($c_s10-$o_s10);
$ex_s11=($c_s11-$o_s11);
$ex_s12=($c_s12-$o_s12);
$ex_s13=($c_s13-$o_s13);
$ex_s14=($c_s14-$o_s14);
$ex_s15=($c_s15-$o_s15);
$ex_s16=($c_s16-$o_s16);
$ex_s17=($c_s17-$o_s17);
$ex_s18=($c_s18-$o_s18);
$ex_s19=($c_s19-$o_s19);
$ex_s20=($c_s20-$o_s20);
$ex_s21=($c_s21-$o_s21);
$ex_s22=($c_s22-$o_s22);
$ex_s23=($c_s23-$o_s23);
$ex_s24=($c_s24-$o_s24);
$ex_s25=($c_s25-$o_s25);
$ex_s26=($c_s26-$o_s26);
$ex_s27=($c_s27-$o_s27);
$ex_s28=($c_s28-$o_s28);
$ex_s29=($c_s29-$o_s29);
$ex_s30=($c_s30-$o_s30);
$ex_s31=($c_s31-$o_s31);
$ex_s32=($c_s32-$o_s32);
$ex_s33=($c_s33-$o_s33);
$ex_s34=($c_s34-$o_s34);
$ex_s35=($c_s35-$o_s35);
$ex_s36=($c_s36-$o_s36);
$ex_s37=($c_s37-$o_s37);
$ex_s38=($c_s38-$o_s38);
$ex_s39=($c_s39-$o_s39);
$ex_s40=($c_s40-$o_s40);
$ex_s41=($c_s41-$o_s41);
$ex_s42=($c_s42-$o_s42);
$ex_s43=($c_s43-$o_s43);
$ex_s44=($c_s44-$o_s44);
$ex_s45=($c_s45-$o_s45);
$ex_s46=($c_s46-$o_s46);
$ex_s47=($c_s47-$o_s47);
$ex_s48=($c_s48-$o_s48);
$ex_s49=($c_s49-$o_s49);
$ex_s50=($c_s50-$o_s50);

	
	
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
		   echo "<td class=xl8713019>".$join_s01."</td>";
		   echo "<td class=xl8713019>".$join_s02."</td>";
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
		   echo "<td class=xl8713019>".($join_s01+$join_s02)."</td>";
		   echo "<td class=xl8513019>&nbsp;</td>";
		   echo "</tr>";
}

// embellishment start
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
			 
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s01/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s02/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s03/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s04/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s05/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s06/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s07/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s08/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s09/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s10/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s11/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s12/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s13/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s14/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s15/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s16/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s17/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s18/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s19/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s20/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s21/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s22/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s23/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s24/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s25/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s26/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s27/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s28/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s29/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s30/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s31/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s32/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s33/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s34/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s35/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s36/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s37/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s38/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s39/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s40/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s41/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s42/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s43/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s44/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s45/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s46/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s47/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s48/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s49/2))."</td>";
				 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(round($ex_s50/2))."</td>";

			  
			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((round($ex_s01/2))+(round($ex_s02/2))+(round($ex_s03/2))+(round($ex_s04/2))+(round($ex_s05/2))+(round($ex_s06/2))+(round($ex_s07/2))+(round($ex_s08/2))+(round($ex_s09/2))+(round($ex_s10/2))+(round($ex_s11/2))+(round($ex_s12/2))+(round($ex_s13/2))+(round($ex_s14/2))+(round($ex_s15/2))+(round($ex_s16/2))+(round($ex_s17/2))+(round($ex_s18/2))+(round($ex_s19/2))+(round($ex_s20/2))+(round($ex_s21/2))+(round($ex_s22/2))+(round($ex_s23/2))+(round($ex_s24/2))+(round($ex_s25/2))+(round($ex_s26/2))+(round($ex_s27/2))+(round($ex_s28/2))+(round($ex_s29/2))+(round($ex_s30/2))+(round($ex_s31/2))+(round($ex_s32/2))+(round($ex_s33/2))+(round($ex_s34/2))+(round($ex_s35/2))+(round($ex_s36/2))+(round($ex_s37/2))+(round($ex_s38/2))+(round($ex_s39/2))+(round($ex_s40/2))+(round($ex_s41/2))+(round($ex_s42/2))+(round($ex_s43/2))+(round($ex_s44/2))+(round($ex_s45/2))+(round($ex_s46/2))+(round($ex_s47/2))+(round($ex_s48/2))+(round($ex_s49/2))+(round($ex_s50/2)))."</td>";
		  
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
			   echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s01/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s02/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s03/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s04/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s05/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s06/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s07/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s08/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s09/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s10/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s11/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s12/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s13/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s14/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s15/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s16/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s17/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s18/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s19/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s20/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s21/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s22/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s23/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s24/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s25/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s26/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s27/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s28/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s29/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s30/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s31/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s32/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s33/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s34/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s35/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s36/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s37/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s38/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s39/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s40/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s41/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s42/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s43/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s44/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s45/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s46/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s47/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s48/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s49/2))."</td>";
			 echo "<td class=xl8713019 style='border-top:none;border-left:none'>".((int)($ex_s50/2))."</td>";

			  echo "<td class=xl8713019 style='border-top:none;border-left:none'>".(((int)($ex_s01/2))+((int)($ex_s02/2))+((int)($ex_s03/2))+((int)($ex_s04/2))+((int)($ex_s05/2))+((int)($ex_s06/2))+((int)($ex_s07/2))+((int)($ex_s08/2))+((int)($ex_s09/2))+((int)($ex_s10/2))+((int)($ex_s11/2))+((int)($ex_s12/2))+((int)($ex_s13/2))+((int)($ex_s14/2))+((int)($ex_s15/2))+((int)($ex_s16/2))+((int)($ex_s17/2))+((int)($ex_s18/2))+((int)($ex_s19/2))+((int)($ex_s20/2))+((int)($ex_s21/2))+((int)($ex_s22/2))+((int)($ex_s23/2))+((int)($ex_s24/2))+((int)($ex_s25/2))+((int)($ex_s26/2))+((int)($ex_s27/2))+((int)($ex_s28/2))+((int)($ex_s29/2))+((int)($ex_s30/2))+((int)($ex_s31/2))+((int)($ex_s32/2))+((int)($ex_s33/2))+((int)($ex_s34/2))+((int)($ex_s35/2))+((int)($ex_s36/2))+((int)($ex_s37/2))+((int)($ex_s38/2))+((int)($ex_s39/2))+((int)($ex_s40/2))+((int)($ex_s41/2))+((int)($ex_s42/2))+((int)($ex_s43/2))+((int)($ex_s44/2))+((int)($ex_s45/2))+((int)($ex_s46/2))+((int)($ex_s47/2))+((int)($ex_s48/2))+((int)($ex_s49/2))+((int)($ex_s50/2)))."</td>";
			  echo "</tr>";
	}
// embellishment end	
	else
	{
		
		/*echo "<tr class=xl6613019  style='mso-height-source:userset;' height='40'>
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
		echo "<td colspan=2 class=xl8713019></td>";
		echo "<td colspan=2 class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td class=xl8713019></td>";
		echo "<td colspan=2 class=xl8713019></td>";
		echo "<td colspan=2 class=xl8713019></td>";
		echo "<td colspan=2 class=xl8713019></td>";
		echo "<td colspan=2 class=xl8713019></td>";
		echo "<td colspan=4 class=xl8713019></td>";
		
		echo "<td class=xl8513019>&nbsp;</td>";
		echo "</tr>";*/

	}
	

echo "<tr class=xl6613019 style='mso-height-source:userset;height:15.0pt' height=40>
  <td height=20 class=xl6613019 style='height:15.0pt'></td>";
   echo "<td class=xl8613019>".chr($color_code).leading_zeros($cutno, 3)."</td>";
   echo "<td class=xl8713019>".$a_s01."</td>";
 echo "<td class=xl8713019>".$a_s02."</td>";
 echo "<td class=xl8713019>".$a_s03."</td>";
 echo "<td class=xl8713019>".$a_s04."</td>";
 echo "<td class=xl8713019>".$a_s05."</td>";
 echo "<td class=xl8713019>".$a_s06."</td>";
 echo "<td class=xl8713019>".$a_s07."</td>";
 echo "<td class=xl8713019>".$a_s08."</td>";
 echo "<td class=xl8713019>".$a_s09."</td>";
 echo "<td class=xl8713019>".$a_s10."</td>";
 echo "<td class=xl8713019>".$a_s11."</td>";
 echo "<td class=xl8713019>".$a_s12."</td>";
 echo "<td class=xl8713019>".$a_s13."</td>";
 echo "<td class=xl8713019>".$a_s14."</td>";
 echo "<td class=xl8713019>".$a_s15."</td>";
 echo "<td class=xl8713019>".$a_s16."</td>";
 echo "<td class=xl8713019>".$a_s17."</td>";
 echo "<td class=xl8713019>".$a_s18."</td>";
 echo "<td class=xl8713019>".$a_s19."</td>";
 echo "<td class=xl8713019>".$a_s20."</td>";
 echo "<td class=xl8713019>".$a_s21."</td>";
 echo "<td class=xl8713019>".$a_s22."</td>";
 echo "<td class=xl8713019>".$a_s23."</td>";
 echo "<td class=xl8713019>".$a_s24."</td>";
 echo "<td class=xl8713019>".$a_s25."</td>";
 echo "<td class=xl8713019>".$a_s26."</td>";
 echo "<td class=xl8713019>".$a_s27."</td>";
 echo "<td class=xl8713019>".$a_s28."</td>";
 echo "<td class=xl8713019>".$a_s29."</td>";
 echo "<td class=xl8713019>".$a_s30."</td>";
 echo "<td class=xl8713019>".$a_s31."</td>";
 echo "<td class=xl8713019>".$a_s32."</td>";
 echo "<td class=xl8713019>".$a_s33."</td>";
 echo "<td class=xl8713019>".$a_s34."</td>";
 echo "<td class=xl8713019>".$a_s35."</td>";
 echo "<td class=xl8713019>".$a_s36."</td>";
 echo "<td class=xl8713019>".$a_s37."</td>";
 echo "<td class=xl8713019>".$a_s38."</td>";
 echo "<td class=xl8713019>".$a_s39."</td>";
 echo "<td class=xl8713019>".$a_s40."</td>";
 echo "<td class=xl8713019>".$a_s41."</td>";
 echo "<td class=xl8713019>".$a_s42."</td>";
 echo "<td class=xl8713019>".$a_s43."</td>";
 echo "<td class=xl8713019>".$a_s44."</td>";
 echo "<td class=xl8713019>".$a_s45."</td>";
 echo "<td class=xl8713019>".$a_s46."</td>";
 echo "<td class=xl8713019>".$a_s47."</td>";
 echo "<td class=xl8713019>".$a_s48."</td>";
 echo "<td class=xl8713019>".$a_s49."</td>";
 echo "<td class=xl8713019>".$a_s50."</td>";

 
  echo "<td colspan=2 class=xl8713019 height=40></td>";
  echo "<td colspan=2 class=xl8713019 height=40></td>";
  echo "<td colspan=2 class=xl8713019></td>";
  $temp_sum=0;
  echo "<td class=xl8713019></td>"; echo "<td class=xl8713019></td>";echo "<td colspan=2 class=xl8713019></td>";echo "<td colspan=2 class=xl8713019></td>";echo "<td colspan=2 class=xl8713019></td>";echo "<td colspan=2 class=xl8713019></td>";
  
  
  echo "<td colspan=5 class=xl8713019></td>";
echo "<td class=xl8513019></td>";
echo "</tr>";
 }
	else
	{
	
echo "<tr class=xl6613019  style='mso-height-source:userset;height:15.0pt' height=40 >
  <td height=20 class=xl6613019 style='height:15.0pt'></td>";
   echo "<td class=xl8613019>".chr($color_code).leading_zeros($cutno, 3)."</td>";
   echo "<td class=xl8713019>".$a_s01."</td>";
 echo "<td class=xl8713019>".$a_s02."</td>";
 echo "<td class=xl8713019>".$a_s03."</td>";
 echo "<td class=xl8713019>".$a_s04."</td>";
 echo "<td class=xl8713019>".$a_s05."</td>";
 echo "<td class=xl8713019>".$a_s06."</td>";
 echo "<td class=xl8713019>".$a_s07."</td>";
 echo "<td class=xl8713019>".$a_s08."</td>";
 echo "<td class=xl8713019>".$a_s09."</td>";
 echo "<td class=xl8713019>".$a_s10."</td>";
 echo "<td class=xl8713019>".$a_s11."</td>";
 echo "<td class=xl8713019>".$a_s12."</td>";
 echo "<td class=xl8713019>".$a_s13."</td>";
 echo "<td class=xl8713019>".$a_s14."</td>";
 echo "<td class=xl8713019>".$a_s15."</td>";
 echo "<td class=xl8713019>".$a_s16."</td>";
 echo "<td class=xl8713019>".$a_s17."</td>";
 echo "<td class=xl8713019>".$a_s18."</td>";
 echo "<td class=xl8713019>".$a_s19."</td>";
 echo "<td class=xl8713019>".$a_s20."</td>";
 echo "<td class=xl8713019>".$a_s21."</td>";
 echo "<td class=xl8713019>".$a_s22."</td>";
 echo "<td class=xl8713019>".$a_s23."</td>";
 echo "<td class=xl8713019>".$a_s24."</td>";
 echo "<td class=xl8713019>".$a_s25."</td>";
 echo "<td class=xl8713019>".$a_s26."</td>";
 echo "<td class=xl8713019>".$a_s27."</td>";
 echo "<td class=xl8713019>".$a_s28."</td>";
 echo "<td class=xl8713019>".$a_s29."</td>";
 echo "<td class=xl8713019>".$a_s30."</td>";
 echo "<td class=xl8713019>".$a_s31."</td>";
 echo "<td class=xl8713019>".$a_s32."</td>";
 echo "<td class=xl8713019>".$a_s33."</td>";
 echo "<td class=xl8713019>".$a_s34."</td>";
 echo "<td class=xl8713019>".$a_s35."</td>";
 echo "<td class=xl8713019>".$a_s36."</td>";
 echo "<td class=xl8713019>".$a_s37."</td>";
 echo "<td class=xl8713019>".$a_s38."</td>";
 echo "<td class=xl8713019>".$a_s39."</td>";
 echo "<td class=xl8713019>".$a_s40."</td>";
 echo "<td class=xl8713019>".$a_s41."</td>";
 echo "<td class=xl8713019>".$a_s42."</td>";
 echo "<td class=xl8713019>".$a_s43."</td>";
 echo "<td class=xl8713019>".$a_s44."</td>";
 echo "<td class=xl8713019>".$a_s45."</td>";
 echo "<td class=xl8713019>".$a_s46."</td>";
 echo "<td class=xl8713019>".$a_s47."</td>";
 echo "<td class=xl8713019>".$a_s48."</td>";
 echo "<td class=xl8713019>".$a_s49."</td>";
 echo "<td class=xl8713019>".$a_s50."</td>";

  
  echo "<td colspan=2 class=xl8713019 height=40></td>";
  echo "<td colspan=2 class=xl8713019></td>";
  echo "<td colspan=2 class=xl8713019></td>";
  $temp_sum=0;
  echo "<td class=xl8713019></td>";echo "<td class=xl8713019></td>";echo "<td colspan=2 class=xl8713019></td>";echo "<td colspan=2 class=xl8713019></td>";echo "<td colspan=2 class=xl8713019></td>";echo "<td colspan=2 class=xl8713019></td>";
  
  
  echo "<td colspan=5 class=xl8713019></td>";
echo "<td class=xl8513019>&nbsp;</td>";
echo "</tr>";

}
 }
 
 echo "<tr class=xl6613019  style='mso-height-source:userset;height:15.0pt' height=40 ><td height=20 class=xl6613019 style='height:15.0pt'></td>";
  echo "<td colspan=14 class=xl8613019 height=40 align='center'> Total </td>";
  echo "<td colspan=2 class=xl8713019></td>";
  echo "<td colspan=2 class=xl8713019></td>";
  echo "<td colspan=2 class=xl8713019></td>";echo "<td class=xl8713019></td>";echo "<td class=xl8713019></td>";echo "<td colspan=2 class=xl8713019></td>";echo "<td colspan=2 class=xl8713019></td>";echo "<td colspan=2 class=xl8713019></td>";
  echo "<td colspan=2 class=xl8713019></td>";echo "<td colspan=5 class=xl8713019></td>"; 
echo "</tr>";

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
 

<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
</body>

</html>