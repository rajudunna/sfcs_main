<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');   ?>
<?php include('../../../../common/config/functions.php'); ?>
<?php ini_set('error_reporting', E_ALL); ?>

<?php

//$order_tid=$_GET['order_tid'];
$style_id=$_GET['style_id'];
$schedule_id=$_GET['schedule_id'];
$style1=$_GET['style'];
$schedule=$_GET['schedule'];

		$mpo ='';$cpo='';$cust_ord='';$module = '';
		$leading = '';
		$color = '';
		$color_code = '';
		$old_s_s01=0;
		$old_s_s02=0;
		$old_s_s03=0;
		$old_s_s04=0;
		$old_s_s05=0;
		$old_s_s06=0;
		$old_s_s07=0;
		$old_s_s08=0;
		$old_s_s09=0;
		$old_s_s10=0;
		$old_s_s11=0;
		$old_s_s12=0;
		$old_s_s13=0;
		$old_s_s14=0;
		$old_s_s15=0;
		$old_s_s16=0;
		$old_s_s17=0;
		$old_s_s18=0;
		$old_s_s19=0;
		$old_s_s20=0;
		$old_s_s21=0;
		$old_s_s22=0;
		$old_s_s23=0;
		$old_s_s24=0;
		$old_s_s25=0;
		$old_s_s26=0;
		$old_s_s27=0;
		$old_s_s28=0;
		$old_s_s29=0;
		$old_s_s30=0;
		$old_s_s31=0;
		$old_s_s32=0;
		$old_s_s33=0;
		$old_s_s34=0;
		$old_s_s35=0;
		$old_s_s36=0;
		$old_s_s37=0;
		$old_s_s38=0;
		$old_s_s39=0;
		$old_s_s40=0;
		$old_s_s41=0;
		$old_s_s42=0;
		$old_s_s43=0;
		$old_s_s44=0;
		$old_s_s45=0;
		$old_s_s46=0;
		$old_s_s47=0;
		$old_s_s48=0;
		$old_s_s49=0;
		$old_s_s50=0;

		$o_s_s01=0;
		$o_s_s02=0;
		$o_s_s03=0;
		$o_s_s04=0;
		$o_s_s05=0;
		$o_s_s06=0;
		$o_s_s07=0;
		$o_s_s08=0;
		$o_s_s09=0;
		$o_s_s10=0;
		$o_s_s11=0;
		$o_s_s12=0;
		$o_s_s13=0;
		$o_s_s14=0;
		$o_s_s15=0;
		$o_s_s16=0;
		$o_s_s17=0;
		$o_s_s18=0;
		$o_s_s19=0;
		$o_s_s20=0;
		$o_s_s21=0;
		$o_s_s22=0;
		$o_s_s23=0;
		$o_s_s24=0;
		$o_s_s25=0;
		$o_s_s26=0;
		$o_s_s27=0;
		$o_s_s28=0;
		$o_s_s29=0;
		$o_s_s30=0;
		$o_s_s31=0;
		$o_s_s32=0;
		$o_s_s33=0;
		$o_s_s34=0;
		$o_s_s35=0;
		$o_s_s36=0;
		$o_s_s37=0;
		$o_s_s38=0;
		$o_s_s39=0;
		$o_s_s40=0;
		$o_s_s41=0;
		$o_s_s42=0;
		$o_s_s43=0;
		$o_s_s44=0;
		$o_s_s45=0;
		$o_s_s46=0;
		$o_s_s47=0;
		$o_s_s48=0;
		$o_s_s49=0;
		$o_s_s50=0;	
$old_xs=0;$old_s=0;$old_m=0;$old_l=0;$old_xl=0;$old_xxl=0;$old_xxxl=0;
$o_xs=0;$o_s=0;$o_m=0;$o_l=0;$o_xl=0;$o_xxl=0;$o_xxxl=0;
?>



<?php
$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style_id\" and order_del_no='$schedule_id'";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error k".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_confirm=mysqli_num_rows($sql_result);

$old = "select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style_id\" and order_del_no='$schedule_id'";
$old_result=mysqli_query($link, $old) or exit("Sql Error l".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($old_row=mysqli_fetch_array($old_result)) {
		$old_s_s01+=$old_row['old_order_s_s01'];
		$old_s_s02+=$old_row['old_order_s_s02'];
		$old_s_s03+=$old_row['old_order_s_s03'];
		$old_s_s04+=$old_row['old_order_s_s04'];
		$old_s_s05+=$old_row['old_order_s_s05'];
		$old_s_s06+=$old_row['old_order_s_s06'];
		$old_s_s07+=$old_row['old_order_s_s07'];
		$old_s_s08+=$old_row['old_order_s_s08'];
		$old_s_s09+=$old_row['old_order_s_s09'];
		$old_s_s10+=$old_row['old_order_s_s10'];
		$old_s_s11+=$old_row['old_order_s_s11'];
		$old_s_s12+=$old_row['old_order_s_s12'];
		$old_s_s13+=$old_row['old_order_s_s13'];
		$old_s_s14+=$old_row['old_order_s_s14'];
		$old_s_s15+=$old_row['old_order_s_s15'];
		$old_s_s16+=$old_row['old_order_s_s16'];
		$old_s_s17+=$old_row['old_order_s_s17'];
		$old_s_s18+=$old_row['old_order_s_s18'];
		$old_s_s19+=$old_row['old_order_s_s19'];
		$old_s_s20+=$old_row['old_order_s_s20'];
		$old_s_s21+=$old_row['old_order_s_s21'];
		$old_s_s22+=$old_row['old_order_s_s22'];
		$old_s_s23+=$old_row['old_order_s_s23'];
		$old_s_s24+=$old_row['old_order_s_s24'];
		$old_s_s25+=$old_row['old_order_s_s25'];
		$old_s_s26+=$old_row['old_order_s_s26'];
		$old_s_s27+=$old_row['old_order_s_s27'];
		$old_s_s28+=$old_row['old_order_s_s28'];
		$old_s_s29+=$old_row['old_order_s_s29'];
		$old_s_s30+=$old_row['old_order_s_s30'];
		$old_s_s31+=$old_row['old_order_s_s31'];
		$old_s_s32+=$old_row['old_order_s_s32'];
		$old_s_s33+=$old_row['old_order_s_s33'];
		$old_s_s34+=$old_row['old_order_s_s34'];
		$old_s_s35+=$old_row['old_order_s_s35'];
		$old_s_s36+=$old_row['old_order_s_s36'];
		$old_s_s37+=$old_row['old_order_s_s37'];
		$old_s_s38+=$old_row['old_order_s_s38'];
		$old_s_s39+=$old_row['old_order_s_s39'];
		$old_s_s40+=$old_row['old_order_s_s40'];
		$old_s_s41+=$old_row['old_order_s_s41'];
		$old_s_s42+=$old_row['old_order_s_s42'];
		$old_s_s43+=$old_row['old_order_s_s43'];
		$old_s_s44+=$old_row['old_order_s_s44'];
		$old_s_s45+=$old_row['old_order_s_s45'];
		$old_s_s46+=$old_row['old_order_s_s46'];
		$old_s_s47+=$old_row['old_order_s_s47'];
		$old_s_s48+=$old_row['old_order_s_s48'];
		$old_s_s49+=$old_row['old_order_s_s49'];
		$old_s_s50+=$old_row['old_order_s_s50'];

		$old_xs+=$old_row['old_order_s_xs'];
		$old_s+=$old_row['old_order_s_s'];
		$old_m+=$old_row['old_order_s_m'];
		$old_l+=$old_row['old_order_s_l'];
		$old_xl+=$old_row['old_order_s_xl'];
		$old_xxl+=$old_row['old_order_s_xxl'];
		$old_xxxl+=$old_row['old_order_s_xxxl'];

	$old_order_qtys=array($old_s_s01,$old_s_s02,$old_s_s03,$old_s_s04,$old_s_s05,$old_s_s06,$old_s_s07,$old_s_s08,$old_s_s09,$old_s_s10,$old_s_s11,$old_s_s12,$old_s_s13,$old_s_s14,$old_s_s15,$old_s_s16,$old_s_s17,$old_s_s18,$old_s_s19,$old_s_s20,$old_s_s21,$old_s_s22,$old_s_s23,$old_s_s24,$old_s_s25,$old_s_s26,$old_s_s27,$old_s_s28,$old_s_s29,$old_s_s30,$old_s_s31,$old_s_s32,$old_s_s33,$old_s_s34,$old_s_s35,$old_s_s36,$old_s_s37,$old_s_s38,$old_s_s39,$old_s_s40,$old_s_s41,$old_s_s42,$old_s_s43,$old_s_s44,$old_s_s45,$old_s_s46,$old_s_s47,$old_s_s48,$old_s_s49,$old_s_s50);
	$old_total=$old_xs+$old_s+$old_m+$old_l+$old_xl+$old_xxl+$old_xxxl+$old_s_s01+$old_s_s02+$old_s_s03+$old_s_s04+$old_s_s05+$old_s_s06+$old_s_s07+$old_s_s08+$old_s_s09+$old_s_s10+$old_s_s11+$old_s_s12+$old_s_s13+$old_s_s14+$old_s_s15+$old_s_s16+$old_s_s17+$old_s_s18+$old_s_s19+$old_s_s20+$old_s_s21+$old_s_s22+$old_s_s23+$old_s_s24+$old_s_s25+$old_s_s26+$old_s_s27+$old_s_s28+$old_s_s29+$old_s_s30+$old_s_s31+$old_s_s32+$old_s_s33+$old_s_s34+$old_s_s35+$old_s_s36+$old_s_s37+$old_s_s38+$old_s_s39+$old_s_s40+$old_s_s41+$old_s_s42+$old_s_s43+$old_s_s44+$old_s_s45+$old_s_s46+$old_s_s47+$old_s_s48+$old_s_s49+$old_s_s50;
}


if($sql_num_confirm>0)
{
	$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style_id\" and order_del_no='$schedule_id'";
}
else
{
	$sql="select * from $bai_pro3.bai_orders_db where order_style_no=\"$style_id\" and order_del_no='$schedule_id'";
}
//echo "query =".$sql."<br>";
// mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_result=mysqli_query($link, $sql) or exit("Sql Error m".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$style=$sql_row['order_style_no']; //Style
	$color.=$sql_row['order_col_des']."/"; //color
	$division=$sql_row['order_div'];
	$delivery=$sql_row['order_del_no']; //Schedule
	$pono=$sql_row['order_po_no']; //po
	$color_code.=chr($sql_row['color_code']); //Color Code
	$orderno=$sql_row['order_no']; 
	$o_xs+=$sql_row['order_s_xs'];
	$o_s+=$sql_row['order_s_s'];
	$o_m+=$sql_row['order_s_m'];
	$o_l+=$sql_row['order_s_l'];
	$o_xl+=$sql_row['order_s_xl'];
	$o_xxl+=$sql_row['order_s_xxl'];
	$o_xxxl+=$sql_row['order_s_xxxl'];
		$o_s_s01+=$sql_row['order_s_s01'];
		$o_s_s02+=$sql_row['order_s_s02'];
		$o_s_s03+=$sql_row['order_s_s03'];
		$o_s_s04+=$sql_row['order_s_s04'];
		$o_s_s05+=$sql_row['order_s_s05'];
		$o_s_s06+=$sql_row['order_s_s06'];
		$o_s_s07+=$sql_row['order_s_s07'];
		$o_s_s08+=$sql_row['order_s_s08'];
		$o_s_s09+=$sql_row['order_s_s09'];
		$o_s_s10+=$sql_row['order_s_s10'];
		$o_s_s11+=$sql_row['order_s_s11'];
		$o_s_s12+=$sql_row['order_s_s12'];
		$o_s_s13+=$sql_row['order_s_s13'];
		$o_s_s14+=$sql_row['order_s_s14'];
		$o_s_s15+=$sql_row['order_s_s15'];
		$o_s_s16+=$sql_row['order_s_s16'];
		$o_s_s17+=$sql_row['order_s_s17'];
		$o_s_s18+=$sql_row['order_s_s18'];
		$o_s_s19+=$sql_row['order_s_s19'];
		$o_s_s20+=$sql_row['order_s_s20'];
		$o_s_s21+=$sql_row['order_s_s21'];
		$o_s_s22+=$sql_row['order_s_s22'];
		$o_s_s23+=$sql_row['order_s_s23'];
		$o_s_s24+=$sql_row['order_s_s24'];
		$o_s_s25+=$sql_row['order_s_s25'];
		$o_s_s26+=$sql_row['order_s_s26'];
		$o_s_s27+=$sql_row['order_s_s27'];
		$o_s_s28+=$sql_row['order_s_s28'];
		$o_s_s29+=$sql_row['order_s_s29'];
		$o_s_s30+=$sql_row['order_s_s30'];
		$o_s_s31+=$sql_row['order_s_s31'];
		$o_s_s32+=$sql_row['order_s_s32'];
		$o_s_s33+=$sql_row['order_s_s33'];
		$o_s_s34+=$sql_row['order_s_s34'];
		$o_s_s35+=$sql_row['order_s_s35'];
		$o_s_s36+=$sql_row['order_s_s36'];
		$o_s_s37+=$sql_row['order_s_s37'];
		$o_s_s38+=$sql_row['order_s_s38'];
		$o_s_s39+=$sql_row['order_s_s39'];
		$o_s_s40+=$sql_row['order_s_s40'];
		$o_s_s41+=$sql_row['order_s_s41'];
		$o_s_s42+=$sql_row['order_s_s42'];
		$o_s_s43+=$sql_row['order_s_s43'];
		$o_s_s44+=$sql_row['order_s_s44'];
		$o_s_s45+=$sql_row['order_s_s45'];
		$o_s_s46+=$sql_row['order_s_s46'];
		$o_s_s47+=$sql_row['order_s_s47'];
		$o_s_s48+=$sql_row['order_s_s48'];
		$o_s_s49+=$sql_row['order_s_s49'];
		$o_s_s50+=$sql_row['order_s_s50'];
		
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
			
			if($flag==0)
			{
				$size01="01";
				$size02="02";
				$size03="03";
				$size04="04";
				$size05="05";
				$size06="06";
				$size07="07";
				$size08="08";
				$size09="09";
				$size10="10";
				$size11="11";
				$size12="12";
				$size13="13";
				$size14="14";
				$size15="15";
				$size16="16";
				$size17="17";
				$size18="18";
				$size19="19";
				$size20="20";
				$size21="21";
				$size22="22";
				$size23="23";
				$size24="24";
				$size25="25";
				$size26="26";
				$size27="27";
				$size28="28";
				$size29="29";
				$size30="30";
				$size31="31";
				$size32="32";
				$size33="33";
				$size34="34";
				$size35="35";
				$size36="36";
				$size37="37";
				$size38="38";
				$size39="39";
				$size40="40";
				$size41="41";
				$size42="42";
				$size43="43";
				$size44="44";
				$size45="45";
				$size46="46";
				$size47="47";
				$size48="48";
				$size49="49";
				$size50="50";
			}

	$order_total=$o_xs+$o_s+$o_m+$o_l+$o_xl+$o_xxl+$o_xxxl+$o_s_s01+$o_s_s02+$o_s_s03+$o_s_s04+$o_s_s05+$o_s_s06+$o_s_s07+$o_s_s08+$o_s_s09+$o_s_s10+$o_s_s11+$o_s_s12+$o_s_s13+$o_s_s14+$o_s_s15+$o_s_s16+$o_s_s17+$o_s_s18+$o_s_s19+$o_s_s20+$o_s_s21+$o_s_s22+$o_s_s23+$o_s_s24+$o_s_s25+$o_s_s26+$o_s_s27+$o_s_s28+$o_s_s29+$o_s_s30+$o_s_s31+$o_s_s32+$o_s_s33+$o_s_s34+$o_s_s35+$o_s_s36+$o_s_s37+$o_s_s38+$o_s_s39+$o_s_s40+$o_s_s41+$o_s_s42+$o_s_s43+$o_s_s44+$o_s_s45+$o_s_s46+$o_s_s47+$o_s_s48+$o_s_s49+$o_s_s50;
	$order_date=$sql_row['order_date'];
	$order_joins=$sql_row['order_joins'];
	$packing_method=$sql_row['packing_method'];
	$carton_id=$sql_row['carton_id'];
}

$sql="select * from $bai_pro3.plandoc_stat_log where order_tid in(select order_tid from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style_id\" and order_del_no='$schedule_id')";
// echo $sql;
// die();
//mysqli_query($link, $sql) or exit("Sql Error n".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error n".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$p_xs=$sql_row['p_xs'];
	$p_s=$sql_row['p_s'];
	$p_m=$sql_row['p_m'];
	$p_l=$sql_row['p_l'];
	$p_xl=$sql_row['p_xl'];
	$p_xxl=$sql_row['p_xxl'];
	$p_xxxl=$sql_row['p_xxxl'];
	$p_s01=$sql_row['p_s01'];
		$p_s02=$sql_row['p_s02'];
		$p_s03=$sql_row['p_s03'];
		$p_s04=$sql_row['p_s04'];
		$p_s05=$sql_row['p_s05'];
		$p_s06=$sql_row['p_s06'];
		$p_s07=$sql_row['p_s07'];
		$p_s08=$sql_row['p_s08'];
		$p_s09=$sql_row['p_s09'];
		$p_s10=$sql_row['p_s10'];
		$p_s11=$sql_row['p_s11'];
		$p_s12=$sql_row['p_s12'];
		$p_s13=$sql_row['p_s13'];
		$p_s14=$sql_row['p_s14'];
		$p_s15=$sql_row['p_s15'];
		$p_s16=$sql_row['p_s16'];
		$p_s17=$sql_row['p_s17'];
		$p_s18=$sql_row['p_s18'];
		$p_s19=$sql_row['p_s19'];
		$p_s20=$sql_row['p_s20'];
		$p_s21=$sql_row['p_s21'];
		$p_s22=$sql_row['p_s22'];
		$p_s23=$sql_row['p_s23'];
		$p_s24=$sql_row['p_s24'];
		$p_s25=$sql_row['p_s25'];
		$p_s26=$sql_row['p_s26'];
		$p_s27=$sql_row['p_s27'];
		$p_s28=$sql_row['p_s28'];
		$p_s29=$sql_row['p_s29'];
		$p_s30=$sql_row['p_s30'];
		$p_s31=$sql_row['p_s31'];
		$p_s32=$sql_row['p_s32'];
		$p_s33=$sql_row['p_s33'];
		$p_s34=$sql_row['p_s34'];
		$p_s35=$sql_row['p_s35'];
		$p_s36=$sql_row['p_s36'];
		$p_s37=$sql_row['p_s37'];
		$p_s38=$sql_row['p_s38'];
	    $p_s39=$sql_row['p_s39'];
		$p_s40=$sql_row['p_s40'];
		$p_s41=$sql_row['p_s41'];
		$p_s42=$sql_row['p_s42'];
		$p_s43=$sql_row['p_s43'];
		$p_s44=$sql_row['p_s44'];
		$p_s45=$sql_row['p_s45'];
		$p_s46=$sql_row['p_s46'];
		$p_s47=$sql_row['p_s47'];
		$p_s48=$sql_row['p_s48'];
		$p_s49=$sql_row['p_s49'];
		$p_s50=$sql_row['p_s50'];
}

$size_titles=array("XS","S","M","L","XL","XXL","XXXL",$size01,$size02,$size03,$size04,$size05,$size06,$size07,$size08,$size09,$size10,$size11,$size12,$size13,$size14,$size15,$size16,$size17,$size18,$size19,$size20,$size21,$size22,$size23,$size24,$size25,$size26,$size27,$size28,$size29,$size30,$size31,$size32,$size33,$size34,$size35,$size36,$size37,$size38,$size39,$size40,$size41,$size42,$size43,$size44,$size45,$size46,$size47,$size48,$size49,$size50);
$size_titles_qry=array("XS","S","M","L","XL","XXL","XXXL","s01","s02","s03","s04","s05","s06","s07","s08","s09","s10","s11","s12","s13","s14","s15","s16","s17","s18","s19","s20","s21","s22","s23","s24","s25","s26","s27","s28","s29","s30","s31","s32","s33","s34","s35","s36","s37","s38","s39","s40","s41","s42","s43","s44","s45","s46","s47","s48","s49","s50");
$order_qtys=array($o_xs,$o_s,$o_m,$o_l,$o_xl,$o_xxl,$o_xxxl,$o_s_s01,$o_s_s02,$o_s_s03,$o_s_s04,$o_s_s05,$o_s_s06,$o_s_s07,$o_s_s08,$o_s_s09,$o_s_s10,$o_s_s11,$o_s_s12,$o_s_s13,$o_s_s14,$o_s_s15,$o_s_s16,$o_s_s17,$o_s_s18,$o_s_s19,$o_s_s20,$o_s_s21,$o_s_s22,$o_s_s23,$o_s_s24,$o_s_s25,$o_s_s26,$o_s_s27,$o_s_s28,$o_s_s29
,$o_s_s30,$o_s_s31,$o_s_s32,$o_s_s33,$o_s_s34,$o_s_s35,$o_s_s36,$o_s_s37,$o_s_s38,$o_s_s39,$o_s_s40,$o_s_s41,$o_s_s42,$o_s_s43,$o_s_s44,$o_s_s45,$o_s_s46,$o_s_s47
,$o_s_s48,$o_s_s49,$o_s_s50);
$carton_qtys=array($p_xs,$p_s,$p_m,$p_l,$p_xl,$o_xxl,$p_xxxl,$p_s01,$p_s02,$p_s03,$p_s04,$p_s05,$p_s06,$p_s07,$p_s08,$p_s09,$p_s10,$p_s11,$p_s12,$p_s13,$p_s14,$p_s15,$p_s16,$p_s17,$p_s18,$p_s19,$p_s20,$p_s21,$p_s22,$p_s23,$p_s24,$p_s25,$p_s26,$p_s27,$p_s28,$p_s29,$p_s30,$p_s31,$p_s32,$p_s33,$p_s34,$p_s35,$p_s36,$p_s37,$p_s38,$p_s39,$p_s40,$p_s41,$p_s42,$p_s43,$p_s44,$p_s45,$p_s46,$p_s47,$p_s48,$p_s49,$p_s50);

//ERROR CHECK POINT

$sql="select sum(carton_act_qty) as \"carton_act_qty\" from $bai_pro3.packing_summary where order_del_no='$delivery'";
//mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error o".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	if(array_sum($order_qtys)!=$sql_row['carton_act_qty'])
	{
		$url = 'error.php';
		// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url\"; }</script>";
	}
}

//ERROR CHECK POINT
$order_tid_qry="SELECT order_tid FROM bai_orders_db_confirm WHERE order_del_no=$schedule_id AND order_style_no='$style_id'";
				// echo $order_tid_qry;
				$get_order_tid_res=mysqli_query($link, $order_tid_qry) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row1=mysqli_fetch_array($get_order_tid_res))
					{
						$order_tid=$sql_row1['order_tid'];
						// echo $order_tid;
						// $mpo=$sql_row['MPO'];
						// $cust_ord=$sql_row['Cust_order'];
					} 
$sql="select * from $bai_pro2.shipment_plan_summ where ssc_code=\"$order_tid\"";
// echo $sql;
// die();
//mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error p".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$cpo=$sql_row['CPO'];
	$mpo=$sql_row['MPO'];
	$cust_ord=$sql_row['Cust_order'];
} 
$cat_ref = '';
$sql="select ims_mod_no from $bai_pro3.ims_log where ims_cid='$cat_ref' and ims_date=(select min(ims_date) from $bai_pro3.ims_log where ims_cid='$cat_ref')";
//mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error q".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$module=$sql_row['ims_mod_no'];
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
  width:759pt'>FG CHECK List</td>
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
 $query = "SELECT r.pack_method as pack,r.pack_description,GROUP_CONCAT(DISTINCT(color)) as color,GROUP_CONCAT(DISTINCT(size_title)) as size FROM tbl_pack_size_ref AS r LEFT JOIN tbl_pack_ref p ON p.id = r.parent_id WHERE p.ref_order_num = $schedule AND p.style_code = $style1 group by r.pack_method";
 // echo $query;
 $sql_result=mysqli_query($link, $query) or exit("Sql Error a".mysqli_error($GLOBALS["___mysqli_ston"]));
 $count = mysqli_num_rows($sql_result);
 //echo $count;
 while($sql_row=mysqli_fetch_array($sql_result))
{
	try{
	$pack=$sql_row['pack'];
	// $pac_des=$sql_row['pack_description'];
	// $color=$sql_row['color'];
	// $size=$sql_row['size'];
	// echo "<div class='col-md-12'>";
			// echo "<div class='col-md-3'>Pack Method: ".$pack."</div>";
			// echo "<div class='col-md-3'>pack Description: ".$pac_des."</div>";
			// echo "<div class='col-md-3'>Color: ".$color."</div>";
			// echo "<div class='col-md-3'>Size: ".$size."</div>";
			// echo "</div>";
			 // echo "<tr>
			 // <td>Pack Method:</td>
			 // <td>Pack Description :</td>
			 // <td>Color :</td>
			 // <td>Sizes :</td></tr>";
        echo "<table class='table table-bordered'>
						  <thead>
							<tr>
							  <th>Pack Number</th>
							   <th>Pack Description</th>
							   <th>Color</th>
							    <th>Sizes</th>
							</tr>
							</thead>
							<tbody>";
						echo "<tr>
						  <td class=xl8419400>".$sql_row['pack']."</td>
						  <td class=xl8419400>".$sql_row['pack_description']."</td>
						  <td class=xl8419400>".$sql_row['color']."</td>
						  <td class=xl8419400>".$sql_row['size']."</td>
						  </tr>
						  </tbody>
						  </table>";
						  $docs_db=array();
	$cutno_db=array();
	$docs_db[]=-1;
	$cutno_db[]=-1;
	$sql="select * from $bai_pro3.packing_summary where order_style_no=\"$style_id\" and order_del_no='$schedule_id' and doc_no!=''";
    
	//mysqli_query($link, $sql) or exit("Sql Error a".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result1=mysqli_query($link, $sql) or exit("Sql Error a".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$docs_db[]=$sql_row1['doc_no'];
		// var_dump($docs_db);
		$cutno_db[]=$sql_row1['acutno'];
		
		$remarks=$sql_row1['remarks'];
	}

		// for($i=0;$i<sizeof($order_qtys);$i++)
  	// {	
		// if($order_qtys[$i]>0)
		// {
			
			$carton_nodes=array();
			$x=1;
			$sql="select carton_no,seq_no,status,min(tid) as \"tid\",doc_no,sum(carton_act_qty) as \"carton_act_qty\",input_job_number from $bai_pro3.pac_stat_log where doc_no in (".implode(",",$docs_db).")  and pack_method = '".$sql_row['pack']."' group by doc_no_ref order by doc_no,carton_mode,carton_act_qty desc";
			//echo $sql;
			//die();
			
			//mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result4=mysqli_query($link, $sql) or exit("Sql Error b".mysqli_error($GLOBALS["___mysqli_ston"]));
			//if()
			while($sql_row4=mysqli_fetch_array($sql_result4))
			{
				$doc_no=$sql_row4['doc_no'];
				$seq_no=$sql_row4['seq_no'];
				$carton_act_qty=$sql_row4['carton_act_qty'];
				$status=$sql_row4['status'];
				$tid=$sql_row4['tid'];
				$input_job=$sql_row4['input_job_number'];
				$carton_no=$sql_row4['carton_no'];
				$bgcolor="RED";
				if($status=="DONE")
				{
					$bgcolor="GREEN";
				}
				$carton_nodes[]=$carton_no."-".$carton_act_qty."-".$bgcolor."-".$tid."-".$input_job;
				$x++;
			}
			// echo "<tr class=xl6553519400 height=20 style='height:15.0pt'>
                     // <!--  <td height=20 class=xl7719400 style='height:15.0pt'>Size</td> -->
							  // <td class=xl7819400 style='border-left:none'>Carton<br> No</td>
							   // <td class=xl7819400 style='border-left:none' colspan=2>Label ID</td>
							  // <td class=xl7819400 style='border-left:none'>Qty</td>
							  // <td class=xl6553519400></td>
							  // <td class=xl6553519400></td>
							  // <td class=xl6553519400></td>";
			$cycle=0;
			for($j=0;$j<sizeof($carton_nodes);$j+=4)
			{
				    echo "<tr class=xl6553519400 height=20 style='height:15.0pt'>";
 				
				  for($m=$j;$m<$j+4;$m++)
				  {
					 
					  $node_detail=array();
					  $node_detail=explode("-",$carton_nodes[$m]);
					  //echo $node_detail[1];
					  //echo $node_detail[0];
					  // echo $node_detail[2];
					  //die();
		 if($node_detail[2] != '')
					  {
						  echo "<div class = 'col-md-3'>
						  <table class='table table-bordered'>
						  <thead>
							<tr>
							  <th>Carton No</th>
							   <th>Label Id</th>
							   <th>Qty</th>
							</tr>
							</thead>
							<tbody>";


					  	  echo "<tr>
						  <td>".$node_detail[0]."</td>
						  <td>".$node_detail[3]."</td>
						  <td>".$node_detail[1]."</td>
						  </tr>
						  </tbody></table></div>";
					  }
					  else
					  {
					  	  echo "<td class=xl8419400_new></td>
						 
						  <td class=xl8419400_new style='border-left:none'></td>
						  <td class=xl8419400_new style='border-left:none'>&nbsp;</td>
						  <td class=xl7919400_new></td>";
					  }
				  }
				  echo "<td class=xl6553519400></td>
  					<td class=xl6553519400></td>
					<td class=xl6553519400></td>
  					<td class=xl6553519400></td>
 					</tr>";
					$cycle++;
			}
			echo "<tr class=xl6553519400 height=21 style='height:15.75pt'>
			  <td height=21 class=xl8619400 style='height:15.75pt'>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			   <td class=xl8219400>&nbsp;</td>
			    <td class=xl8219400>&nbsp;</td>
				 <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl6553519400></td>
			  <td class=xl6553519400></td>
			  <td class=xl6553519400></td>
			 </tr><tr class=xl6553519400 height=20 style='height:15.75pt'>
			  <td height=20 class=xl8019400 style='height:15.75pt'></td>
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
			 </tr>";
			
 			/* echo "<tr class=xl6553519400 height=21 style='height:1.75pt'>
			  <td height=21 class=xl8619400 style='height:1.75pt'>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl6553519400></td>
			  <td class=xl6553519400></td>
			  <td class=xl6553519400></td>
			 </tr>";
			echo " <tr class=xl6553519400 height=20 style='height:6.0pt'>
			  <td height=20 class=xl8019400 style='height:6.0pt'></td>
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
			 </tr>"; */
		// }
	// }
							 
	

}catch(Exception $e){
	//var_dump($e);
}
			 
}
  

	


     
 ?>
 
 <tr class=xl6553519400 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl8219400 style='height:15.0pt'>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
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

 /*<!-- Example -->
 
 <tr class=xl6553519400 height=20 style='height:15.0pt'>
  <td height=20 class=xl8019400 style='height:15.0pt'>XS</td>
  <td class=xl8419400>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl7919400></td>
  <td class=xl8419400>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl7919400></td>
  <td class=xl8419400>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl7919400></td>
  <td class=xl8419400>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl7919400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
 </tr>
 
 
 <tr class=xl6553519400 height=8 style='mso-height-source:userset;height:6.0pt'>
  <td height=8 class=xl8019400 style='height:6.0pt'></td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl7919400></td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl7919400></td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl7919400></td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl7919400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
 </tr>
 
  <!-- Example -->
 
 
  <!-- Example - Break -->
  
 <tr class=xl6553519400 height=21 style='height:15.75pt'>
  <td height=21 class=xl8619400 style='height:15.75pt'>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
 </tr>
 
 
 <!-- Example - Break-->
 --> */
 ?>

 
 <?php
 /*
 <tr class=xl6553519400 height=20 style='height:15.0pt'>
  <td height=20 class=xl8019400 style='height:15.0pt'></td>
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
 </tr> */
 
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
 
  <tr class=xl6553519400 style='height:auto'>
  <td class=xl7919400 style='height: auto; width:400px;' colspan=21>

	<?php
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

/*
$max_carton_qty=$carton_qtys[array_search($max_size_code,$size_titles)];
//echo $count."<br/>";;
//echo $max_carton_qty;

$container=2;
if($count>0)
{
	do
	{
		$temp=$max_carton_qty;
		$temp_doc_ref=array();
		$completed=array();
		$completed[]="0";
		do
		{
			$sql="select * from (select packing_summary.*, sum(carton_act_qty) as \"carton_qty\" from $bai_pro3.packing_summary where order_style_no=\"$style\" and order_del_no=\"$schedule\" and container is null and doc_no_ref not in (\"".implode('","',$completed)."\") group by doc_no_ref) as t where carton_qty<=$temp order by carton_qty DESC";
//echo $sql;
			//mysql_query($sql,$link) or exit("Sql Error".mysql_error());
			$sql_result=mysql_query($sql,$link) or exit("Sql Error e".mysql_error());
			$check=mysql_num_rows($sql_result);
			
			while($sql_row=mysql_fetch_array($sql_result))
			{
				$x=$sql_row['carton_qty'];
				$y=$sql_row['doc_no_ref'];
				
			}
			
			if($check>0)
			{
				$temp-=$x;
				$count--;
				$temp_doc_ref[]=$y;
				$completed[]=$y;
			}
			else
			{
				$temp=0;
			}
			
		}while($temp>0 and $count>0);
		
		if(sizeof($temp_doc_ref)>0)
		{
			$sql="update pac_stat_log set container=$container where doc_no_ref in (\"".implode('","',$temp_doc_ref)."\")";
			//echo $sql;
			mysql_query($sql,$link) or exit("Sql Error f".mysql_error());
			$container++;
		}
		
	}while($count>0);
}*/



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

//No partial Cartons for DIM/M&S and VSD 

/*$sql="select packing_summary.*, sum(carton_act_qty) as \"carton_qty\", group_concat(tid) as \"label_id\", count(*) as \"count\" from $bai_pro3.packing_summary where order_style_no=\"$style\" and order_del_no=\"$schedule\" group by container";
mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
while($sql_row=mysql_fetch_array($sql_result))
{
	//echo $sql_row['container']."-".$sql_row['count']."-".$sql_row['label_id']."<br/>";
}*/


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



