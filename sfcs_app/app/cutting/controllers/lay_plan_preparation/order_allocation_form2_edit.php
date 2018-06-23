<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/php/functions.php',4,'R')); ?>

<style>
div.block
{
	float: left;	
	padding: 30 px;
}
</style>
<script type="text/javascript" src="<?= '../'.getFullURLLevel($_GET['r'],'/common/js/check_new.js',2,'R')?>"></script>
<script>

function verify_num(t,e){
		var p   = document.getElementById('pliesp');
		var pc  = document.getElementById('pliespercutp');
		var ratios = document.getElementsByClassName('ratios');

		if(Number(pc.value) > Number(p.value) ){
			sweetAlert('The plies per cut should not exceed total plies','','warning');
			return false;
		}

		var val = 0; 
		for(var i=0; i<ratios.length; i++) { 
			if(document.getElementById(ratios[i].name).value){ 
				val = parseInt(val) + parseInt(document.getElementById(ratios[i].name).value); 
			} 
		} 
		if(Number(val)<=0){
			//document.getElementById('update').style.display = "none";
			sweetAlert('Fill Ratio','','warning');
			return false;
		}else if(Number(val)>0){
			//document.getElementById('update').style.display = "block";
			return true;
		}
	
}

</script>
<!-- <link href="style.css" rel="stylesheet" type="text/css" />	
</head> -->


<body>

<div class="panel panel-primary">
<div class="panel-heading">Order Allocation Form edit</div>
<div class="panel-body"> 
<FORM method="post" name="input" onsubmit='return check()' action="<?php echo getFullURL($_GET['r'], "order_allocation_process_edit.php", "N"); ?>">
<?php

$check_id=$_GET['check_id'];
$tran_order_tid=$_GET['tran_order_tid'];
$cat_id=$_GET['cat_id'];
$ref_id=$_GET['ref_id'];

//echo "<div class=block>";
echo "<input class=\"form-control\" type\"text\" style=\"visibility:hidden\" name=\"tran_order_tid\" value=\"".$tran_order_tid."\">";

echo "<input type\"text\" name=\"check_id\" value=\"".$check_id."\" style=\"visibility:hidden\">";
echo "<input type\"text\" name=\"cat_id\" value=\"".$cat_id."\" style=\"visibility:hidden\">";



//echo "<br/>";

$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\"";
mysqli_query($link, $sql) or exit("Sql Error a".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error b".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

while($sql_row=mysqli_fetch_array($sql_result))
{
	
/*Echo "<table>
<tr><td>Order Ref</td><td>:</td><td>".$tran_order_tid."</td></tr>
<tr><td>Date</td><td>:</td><td>".$sql_row['order_date']."</td></tr>";

echo "<tr>";
echo "<td>Division</td><td>:</td><td>".$sql_row['order_div']."</td></tr>";

echo "<tr>";
echo "<td>Stye</td><td>:</td><td>".$sql_row['order_style_no']."</td></tr>";

echo "<tr><td>Delivery No</td><td>:</td><td>".$sql_row['order_del_no']."</td></tr>";

echo "<tr><td>Color</td><td>:</td><td> ".$sql_row['order_col_code']."</td></tr>";


echo "<tr><td>Color Description</td><td>:</td><td>".$sql_row['order_col_des']."</td></tr>";

echo "<tr><td>Order YY</td><td>:</td><td> ".$sql_row['order_yy']."</td></tr>";
echo "</table>";
echo "</td><td>";
echo "<table border=1>";

echo "<tr align=center bgcolor=yellow><td>Sizes</td><td>XS</td><td>S</td><td>M</td><td>L</td><td>XL</td><td>XXL</td><td>XXXl</td><td>Total</td></tr>";

echo "<tr><td bgcolor=#CCFF66>Quantity</td>";
echo "<td>".$sql_row['order_s_xs']."</td>";

echo "<td>".$sql_row['order_s_s']."</td>";

echo "<td>".$sql_row['order_s_m']."</td>";

echo "<td>".$sql_row['order_s_l']."</td>";

echo "<td>".$sql_row['order_s_xl']."</td>";

echo "<td>".$sql_row['order_s_xxl']."</td>";

echo "<td>".$sql_row['order_s_xxxl']."</td>";

echo "<td>".($sql_row['order_s_xs']+$sql_row['order_s_s']+$sql_row['order_s_m']+$sql_row['order_s_l']+$sql_row['order_s_xl']+$sql_row['order_s_xxl']+$sql_row['order_s_xxxl'])."</td></tr>";


echo "<tr>
<td bgcolor=#CCFF66>Remarks</td>
<td colspan=8>".$sql_row['Order_remarks']."</td>
</tr>";

echo "</table>"; */

}

/* NEW */

$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\"";
mysqli_query($link, $sql) or exit("Sql Error d".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error c".mysqli_error($GLOBALS["___mysqli_ston"]));

while($sql_row=mysqli_fetch_array($sql_result))
{
		$color_back=$sql_row['order_col_des'];
		$style_back=$sql_row['order_style_no'];
		$schedule_back=$sql_row['order_del_no'];
		$order_s01=$sql_row['order_s_s01'];
		$order_s02=$sql_row['order_s_s02'];
		$order_s03=$sql_row['order_s_s03'];
		$order_s04=$sql_row['order_s_s04'];
		$order_s05=$sql_row['order_s_s05'];
		$order_s06=$sql_row['order_s_s06'];
		$order_s07=$sql_row['order_s_s07'];
		$order_s08=$sql_row['order_s_s08'];
		$order_s09=$sql_row['order_s_s09'];
		$order_s10=$sql_row['order_s_s10'];
		$order_s11=$sql_row['order_s_s11'];
		$order_s12=$sql_row['order_s_s12'];
		$order_s13=$sql_row['order_s_s13'];
		$order_s14=$sql_row['order_s_s14'];
		$order_s15=$sql_row['order_s_s15'];
		$order_s16=$sql_row['order_s_s16'];
		$order_s17=$sql_row['order_s_s17'];
		$order_s18=$sql_row['order_s_s18'];
		$order_s19=$sql_row['order_s_s19'];
		$order_s20=$sql_row['order_s_s20'];
		$order_s21=$sql_row['order_s_s21'];
		$order_s22=$sql_row['order_s_s22'];
		$order_s23=$sql_row['order_s_s23'];
		$order_s24=$sql_row['order_s_s24'];
		$order_s25=$sql_row['order_s_s25'];
		$order_s26=$sql_row['order_s_s26'];
		$order_s27=$sql_row['order_s_s27'];
		$order_s28=$sql_row['order_s_s28'];
		$order_s29=$sql_row['order_s_s29'];
		$order_s30=$sql_row['order_s_s30'];
		$order_s31=$sql_row['order_s_s31'];
		$order_s32=$sql_row['order_s_s32'];
		$order_s33=$sql_row['order_s_s33'];
		$order_s34=$sql_row['order_s_s34'];
		$order_s35=$sql_row['order_s_s35'];
		$order_s36=$sql_row['order_s_s36'];
		$order_s37=$sql_row['order_s_s37'];
		$order_s38=$sql_row['order_s_s38'];
		$order_s39=$sql_row['order_s_s39'];
		$order_s40=$sql_row['order_s_s40'];
		$order_s41=$sql_row['order_s_s41'];
		$order_s42=$sql_row['order_s_s42'];
		$order_s43=$sql_row['order_s_s43'];
		$order_s44=$sql_row['order_s_s44'];
		$order_s45=$sql_row['order_s_s45'];
		$order_s46=$sql_row['order_s_s46'];
		$order_s47=$sql_row['order_s_s47'];
		$order_s48=$sql_row['order_s_s48'];
		$order_s49=$sql_row['order_s_s49'];
		$order_s50=$sql_row['order_s_s50'];
		for($s=0;$s<sizeof($sizes_code);$s++)
		{
			if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
			{
				$s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
				//echo $s_tit[$sizes_code[$s]]."<br>";
			}	
		}
		
		for($s=0;$s<sizeof($sizes_code);$s++)
		{
			$o_s[$sizes_code[$s]]=$sql_row["order_s_s".$sizes_code[$s].""];
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
		if($flag == 0)
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

}

$sql="select * from $bai_pro3.cat_stat_log where order_tid=\"$tran_order_tid\" and tid=$cat_id";
mysqli_query($link, $sql) or exit("Sql Error e".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error f".mysqli_error($GLOBALS["___mysqli_ston"]));

//echo "<table border=1><tr><td>TID</td><td>Date</td><td>Category</td><td>PurWidth</td><td>gmtway</td><td>STATUS</td><td>remarks</td></tr>";
while($sql_row=mysqli_fetch_array($sql_result))
{
	
$check=0;
$sql2="select sum(cuttable_s_s01) as \"s01\", sum(cuttable_s_s02) as \"s02\", sum(cuttable_s_s03) as \"s03\", sum(cuttable_s_s04) as \"s04\", sum(cuttable_s_s05) as \"s05\", sum(cuttable_s_s06) as \"s06\", sum(cuttable_s_s07) as \"s07\", sum(cuttable_s_s08) as \"s08\", sum(cuttable_s_s09) as \"s09\", sum(cuttable_s_s10) as \"s10\", sum(cuttable_s_s11) as \"s11\", sum(cuttable_s_s12) as \"s12\", sum(cuttable_s_s13) as \"s13\", sum(cuttable_s_s14) as \"s14\", sum(cuttable_s_s15) as \"s15\", sum(cuttable_s_s16) as \"s16\", sum(cuttable_s_s17) as \"s17\", sum(cuttable_s_s18) as \"s18\", sum(cuttable_s_s19) as \"s19\", sum(cuttable_s_s20) as \"s20\", sum(cuttable_s_s21) as \"s21\", sum(cuttable_s_s22) as \"s22\", sum(cuttable_s_s23) as \"s23\", sum(cuttable_s_s24) as \"s24\", sum(cuttable_s_s25) as \"s25\", sum(cuttable_s_s26) as \"s26\", sum(cuttable_s_s27) as \"s27\", sum(cuttable_s_s28) as \"s28\", sum(cuttable_s_s29) as \"s29\", sum(cuttable_s_s30) as \"s30\", sum(cuttable_s_s31) as \"s31\", sum(cuttable_s_s32) as \"s32\", sum(cuttable_s_s33) as \"s33\", sum(cuttable_s_s34) as \"s34\", sum(cuttable_s_s35) as \"s35\", sum(cuttable_s_s36) as \"s36\", sum(cuttable_s_s37) as \"s37\", sum(cuttable_s_s38) as \"s38\", sum(cuttable_s_s39) as \"s39\", sum(cuttable_s_s40) as \"s40\", sum(cuttable_s_s41) as \"s41\", sum(cuttable_s_s42) as \"s42\", sum(cuttable_s_s43) as \"s43\", sum(cuttable_s_s44) as \"s44\", sum(cuttable_s_s45) as \"s45\", sum(cuttable_s_s46) as \"s46\", sum(cuttable_s_s47) as \"s47\", sum(cuttable_s_s48) as \"s48\", sum(cuttable_s_s49) as \"s49\", sum(cuttable_s_s50) as \"s50\" from $bai_pro3.cuttable_stat_log where order_tid=\"$tran_order_tid\" and cat_id=".$sql_row['tid'];
mysqli_query($link, $sql2) or exit("Sql Error g".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error h".mysqli_error($GLOBALS["___mysqli_ston"]));

while($sql_row2=mysqli_fetch_array($sql_result2))
{
$s01=$sql_row2['s01'];
$s02=$sql_row2['s02'];
$s03=$sql_row2['s03'];
$s04=$sql_row2['s04'];
$s05=$sql_row2['s05'];
$s06=$sql_row2['s06'];
$s07=$sql_row2['s07'];
$s08=$sql_row2['s08'];
$s09=$sql_row2['s09'];
$s10=$sql_row2['s10'];
$s11=$sql_row2['s11'];
$s12=$sql_row2['s12'];
$s13=$sql_row2['s13'];
$s14=$sql_row2['s14'];
$s15=$sql_row2['s15'];
$s16=$sql_row2['s16'];
$s17=$sql_row2['s17'];
$s18=$sql_row2['s18'];
$s19=$sql_row2['s19'];
$s20=$sql_row2['s20'];
$s21=$sql_row2['s21'];
$s22=$sql_row2['s22'];
$s23=$sql_row2['s23'];
$s24=$sql_row2['s24'];
$s25=$sql_row2['s25'];
$s26=$sql_row2['s26'];
$s27=$sql_row2['s27'];
$s28=$sql_row2['s28'];
$s29=$sql_row2['s29'];
$s30=$sql_row2['s30'];
$s31=$sql_row2['s31'];
$s32=$sql_row2['s32'];
$s33=$sql_row2['s33'];
$s34=$sql_row2['s34'];
$s35=$sql_row2['s35'];
$s36=$sql_row2['s36'];
$s37=$sql_row2['s37'];
$s38=$sql_row2['s38'];
$s39=$sql_row2['s39'];
$s40=$sql_row2['s40'];
$s41=$sql_row2['s41'];
$s42=$sql_row2['s42'];
$s43=$sql_row2['s43'];
$s44=$sql_row2['s44'];
$s45=$sql_row2['s45'];
$s46=$sql_row2['s46'];
$s47=$sql_row2['s47'];
$s48=$sql_row2['s48'];
$s49=$sql_row2['s49'];
$s50=$sql_row2['s50'];


if($s01<$order_s01){$check=1;}
if($s02<$order_s02){$check=1;}
if($s03<$order_s03){$check=1;}
if($s04<$order_s04){$check=1;}
if($s05<$order_s05){$check=1;}
if($s06<$order_s06){$check=1;}
if($s07<$order_s07){$check=1;}
if($s08<$order_s08){$check=1;}
if($s09<$order_s09){$check=1;}
if($s10<$order_s10){$check=1;}
if($s11<$order_s11){$check=1;}
if($s12<$order_s12){$check=1;}
if($s13<$order_s13){$check=1;}
if($s14<$order_s14){$check=1;}
if($s15<$order_s15){$check=1;}
if($s16<$order_s16){$check=1;}
if($s17<$order_s17){$check=1;}
if($s18<$order_s18){$check=1;}
if($s19<$order_s19){$check=1;}
if($s20<$order_s20){$check=1;}
if($s21<$order_s21){$check=1;}
if($s22<$order_s22){$check=1;}
if($s23<$order_s23){$check=1;}
if($s24<$order_s24){$check=1;}
if($s25<$order_s25){$check=1;}
if($s26<$order_s26){$check=1;}
if($s27<$order_s27){$check=1;}
if($s28<$order_s28){$check=1;}
if($s29<$order_s29){$check=1;}
if($s30<$order_s30){$check=1;}
if($s31<$order_s31){$check=1;}
if($s32<$order_s32){$check=1;}
if($s33<$order_s33){$check=1;}
if($s34<$order_s34){$check=1;}
if($s35<$order_s35){$check=1;}
if($s36<$order_s36){$check=1;}
if($s37<$order_s37){$check=1;}
if($s38<$order_s38){$check=1;}
if($s39<$order_s39){$check=1;}
if($s40<$order_s40){$check=1;}
if($s41<$order_s41){$check=1;}
if($s42<$order_s42){$check=1;}
if($s43<$order_s43){$check=1;}
if($s44<$order_s44){$check=1;}
if($s45<$order_s45){$check=1;}
if($s46<$order_s46){$check=1;}
if($s47<$order_s47){$check=1;}
if($s48<$order_s48){$check=1;}
if($s49<$order_s49){$check=1;}
if($s50<$order_s50){$check=1;}
	
}

$color="GREEN";

if($check==1)
{
	$color="RED";
}
	

	/* $check_id=$sql_row['tid'];*/

/*	echo "<tr>";
	echo "<td>".$sql_row['tid']."</td>";
	echo "<td>".$sql_row['date']."</td>";
	echo "<td>".$sql_row['category']."</td>";
	echo "<td>".$sql_row['purwidth']."</td>";
	echo "<td>".$sql_row['gmtway']."</td>";

	echo "<td bgcolor=".$color.">STATUS</td>";
	echo "<td>".$sql_row['remarks']."</td>";
	echo "</tr>"; */
}
//echo "</table>";




/* NEW */
$aoq_s01=0;
$aoq_s02=0;
$aoq_s03=0;
$aoq_s04=0;
$aoq_s05=0;
$aoq_s06=0;
$aoq_s07=0;
$aoq_s08=0;
$aoq_s09=0;
$aoq_s10=0;
$aoq_s11=0;
$aoq_s12=0;
$aoq_s13=0;
$aoq_s14=0;
$aoq_s15=0;
$aoq_s16=0;
$aoq_s17=0;
$aoq_s18=0;
$aoq_s19=0;
$aoq_s20=0;
$aoq_s21=0;
$aoq_s22=0;
$aoq_s23=0;
$aoq_s24=0;
$aoq_s25=0;
$aoq_s26=0;
$aoq_s27=0;
$aoq_s28=0;
$aoq_s29=0;
$aoq_s30=0;
$aoq_s31=0;
$aoq_s32=0;
$aoq_s33=0;
$aoq_s34=0;
$aoq_s35=0;
$aoq_s36=0;
$aoq_s37=0;
$aoq_s38=0;
$aoq_s39=0;
$aoq_s40=0;
$aoq_s41=0;
$aoq_s42=0;
$aoq_s43=0;
$aoq_s44=0;
$aoq_s45=0;
$aoq_s46=0;
$aoq_s47=0;
$aoq_s48=0;
$aoq_s49=0;
$aoq_s50=0;



$sql2="select sum(allocate_s01 * plies) as \"s01\", sum(allocate_s02 * plies) as \"s02\", sum(allocate_s03 * plies) as \"s03\", sum(allocate_s04 * plies) as \"s04\", sum(allocate_s05 * plies) as \"s05\", sum(allocate_s06 * plies) as \"s06\", sum(allocate_s07 * plies) as \"s07\", sum(allocate_s08 * plies) as \"s08\", sum(allocate_s09 * plies) as \"s09\", sum(allocate_s10 * plies) as \"s10\", sum(allocate_s11 * plies) as \"s11\", sum(allocate_s12 * plies) as \"s12\", sum(allocate_s13 * plies) as \"s13\", sum(allocate_s14 * plies) as \"s14\", sum(allocate_s15 * plies) as \"s15\", sum(allocate_s16 * plies) as \"s16\", sum(allocate_s17 * plies) as \"s17\", sum(allocate_s18 * plies) as \"s18\", sum(allocate_s19 * plies) as \"s19\", sum(allocate_s20 * plies) as \"s20\", sum(allocate_s21 * plies) as \"s21\", sum(allocate_s22 * plies) as \"s22\", sum(allocate_s23 * plies) as \"s23\", sum(allocate_s24 * plies) as \"s24\", sum(allocate_s25 * plies) as \"s25\", sum(allocate_s26 * plies) as \"s26\", sum(allocate_s27 * plies) as \"s27\", sum(allocate_s28 * plies) as \"s28\", sum(allocate_s29 * plies) as \"s29\", sum(allocate_s30 * plies) as \"s30\", sum(allocate_s31 * plies) as \"s31\", sum(allocate_s32 * plies) as \"s32\", sum(allocate_s33 * plies) as \"s33\", sum(allocate_s34 * plies) as \"s34\", sum(allocate_s35 * plies) as \"s35\", sum(allocate_s36 * plies) as \"s36\", sum(allocate_s37 * plies) as \"s37\", sum(allocate_s38 * plies) as \"s38\", sum(allocate_s39 * plies) as \"s39\", sum(allocate_s40 * plies) as \"s40\", sum(allocate_s41 * plies) as \"s41\", sum(allocate_s42 * plies) as \"s42\", sum(allocate_s43 * plies) as \"s43\", sum(allocate_s44 * plies) as \"s44\", sum(allocate_s45 * plies) as \"s45\", sum(allocate_s46 * plies) as \"s46\", sum(allocate_s47 * plies) as \"s47\", sum(allocate_s48 * plies) as \"s48\", sum(allocate_s49 * plies) as \"s49\", sum(allocate_s50 * plies) as \"s50\" from $bai_pro3.allocate_stat_log where order_tid=\"$tran_order_tid\" and cuttable_ref=$check_id";
mysqli_query($link, $sql2) or exit("Sql Error i".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error j".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check2=mysqli_num_rows($sql_result2);
while($sql_row2=mysqli_fetch_array($sql_result2))
{
$aoq_s01=$sql_row2['s01'];
$aoq_s02=$sql_row2['s02'];
$aoq_s03=$sql_row2['s03'];
$aoq_s04=$sql_row2['s04'];
$aoq_s05=$sql_row2['s05'];
$aoq_s06=$sql_row2['s06'];
$aoq_s07=$sql_row2['s07'];
$aoq_s08=$sql_row2['s08'];
$aoq_s09=$sql_row2['s09'];
$aoq_s10=$sql_row2['s10'];
$aoq_s11=$sql_row2['s11'];
$aoq_s12=$sql_row2['s12'];
$aoq_s13=$sql_row2['s13'];
$aoq_s14=$sql_row2['s14'];
$aoq_s15=$sql_row2['s15'];
$aoq_s16=$sql_row2['s16'];
$aoq_s17=$sql_row2['s17'];
$aoq_s18=$sql_row2['s18'];
$aoq_s19=$sql_row2['s19'];
$aoq_s20=$sql_row2['s20'];
$aoq_s21=$sql_row2['s21'];
$aoq_s22=$sql_row2['s22'];
$aoq_s23=$sql_row2['s23'];
$aoq_s24=$sql_row2['s24'];
$aoq_s25=$sql_row2['s25'];
$aoq_s26=$sql_row2['s26'];
$aoq_s27=$sql_row2['s27'];
$aoq_s28=$sql_row2['s28'];
$aoq_s29=$sql_row2['s29'];
$aoq_s30=$sql_row2['s30'];
$aoq_s31=$sql_row2['s31'];
$aoq_s32=$sql_row2['s32'];
$aoq_s33=$sql_row2['s33'];
$aoq_s34=$sql_row2['s34'];
$aoq_s35=$sql_row2['s35'];
$aoq_s36=$sql_row2['s36'];
$aoq_s37=$sql_row2['s37'];
$aoq_s38=$sql_row2['s38'];
$aoq_s39=$sql_row2['s39'];
$aoq_s40=$sql_row2['s40'];
$aoq_s41=$sql_row2['s41'];
$aoq_s42=$sql_row2['s42'];
$aoq_s43=$sql_row2['s43'];
$aoq_s44=$sql_row2['s44'];
$aoq_s45=$sql_row2['s45'];
$aoq_s46=$sql_row2['s46'];
$aoq_s47=$sql_row2['s47'];
$aoq_s48=$sql_row2['s48'];
$aoq_s49=$sql_row2['s49'];
$aoq_s50=$sql_row2['s50'];

}

$coq_s01=0;
$coq_s02=0;
$coq_s03=0;
$coq_s04=0;
$coq_s05=0;
$coq_s06=0;
$coq_s07=0;
$coq_s08=0;
$coq_s09=0;
$coq_s10=0;
$coq_s11=0;
$coq_s12=0;
$coq_s13=0;
$coq_s14=0;
$coq_s15=0;
$coq_s16=0;
$coq_s17=0;
$coq_s18=0;
$coq_s19=0;
$coq_s20=0;
$coq_s21=0;
$coq_s22=0;
$coq_s23=0;
$coq_s24=0;
$coq_s25=0;
$coq_s26=0;
$coq_s27=0;
$coq_s28=0;
$coq_s29=0;
$coq_s30=0;
$coq_s31=0;
$coq_s32=0;
$coq_s33=0;
$coq_s34=0;
$coq_s35=0;
$coq_s36=0;
$coq_s37=0;
$coq_s38=0;
$coq_s39=0;
$coq_s40=0;
$coq_s41=0;
$coq_s42=0;
$coq_s43=0;
$coq_s44=0;
$coq_s45=0;
$coq_s46=0;
$coq_s47=0;
$coq_s48=0;
$coq_s49=0;
$coq_s50=0;

$sql="select sum(cuttable_s_s01) as \"s01\",sum(cuttable_s_s02) as \"s02\",sum(cuttable_s_s03) as \"s03\",sum(cuttable_s_s04) as \"s04\",sum(cuttable_s_s05) as \"s05\",sum(cuttable_s_s06) as \"s06\",sum(cuttable_s_s07) as \"s07\",sum(cuttable_s_s08) as \"s08\",sum(cuttable_s_s09) as \"s09\",sum(cuttable_s_s10) as \"s10\",sum(cuttable_s_s11) as \"s11\",sum(cuttable_s_s12) as \"s12\",sum(cuttable_s_s13) as \"s13\",sum(cuttable_s_s14) as \"s14\",sum(cuttable_s_s15) as \"s15\",sum(cuttable_s_s16) as \"s16\",sum(cuttable_s_s17) as \"s17\",sum(cuttable_s_s18) as \"s18\",sum(cuttable_s_s19) as \"s19\",sum(cuttable_s_s20) as \"s20\",sum(cuttable_s_s21) as \"s21\",sum(cuttable_s_s22) as \"s22\",sum(cuttable_s_s23) as \"s23\",sum(cuttable_s_s24) as \"s24\",sum(cuttable_s_s25) as \"s25\",sum(cuttable_s_s26) as \"s26\",sum(cuttable_s_s27) as \"s27\",sum(cuttable_s_s28) as \"s28\",sum(cuttable_s_s29) as \"s29\",sum(cuttable_s_s30) as \"s30\",sum(cuttable_s_s31) as \"s31\",sum(cuttable_s_s32) as \"s32\",sum(cuttable_s_s33) as \"s33\",sum(cuttable_s_s34) as \"s34\",sum(cuttable_s_s35) as \"s35\",sum(cuttable_s_s36) as \"s36\",sum(cuttable_s_s37) as \"s37\",sum(cuttable_s_s38) as \"s38\",sum(cuttable_s_s39) as \"s39\",sum(cuttable_s_s40) as \"s40\",sum(cuttable_s_s41) as \"s41\",sum(cuttable_s_s42) as \"s42\",sum(cuttable_s_s43) as \"s43\",sum(cuttable_s_s44) as \"s44\",sum(cuttable_s_s45) as \"s45\",sum(cuttable_s_s46) as \"s46\",sum(cuttable_s_s47) as \"s47\",sum(cuttable_s_s48) as \"s48\",sum(cuttable_s_s49) as \"s49\",sum(cuttable_s_s50) as \"s50\" from $bai_pro3.cuttable_stat_log where order_tid=\"$tran_order_tid\" and tid=$check_id";
mysqli_query($link, $sql) or exit("Sql Error k ".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error k ".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

while($sql_row=mysqli_fetch_array($sql_result))
{
$coq_s01=$sql_row['s01'];
	$coq_s02=$sql_row['s02'];
	$coq_s03=$sql_row['s03'];
	$coq_s04=$sql_row['s04'];
	$coq_s05=$sql_row['s05'];
	$coq_s06=$sql_row['s06'];
	$coq_s07=$sql_row['s07'];
	$coq_s08=$sql_row['s08'];
	$coq_s09=$sql_row['s09'];
	$coq_s10=$sql_row['s10'];
	$coq_s11=$sql_row['s11'];
	$coq_s12=$sql_row['s12'];
	$coq_s13=$sql_row['s13'];
	$coq_s14=$sql_row['s14'];
	$coq_s15=$sql_row['s15'];
	$coq_s16=$sql_row['s16'];
	$coq_s17=$sql_row['s17'];
	$coq_s18=$sql_row['s18'];
	$coq_s19=$sql_row['s19'];
	$coq_s20=$sql_row['s20'];
	$coq_s21=$sql_row['s21'];
	$coq_s22=$sql_row['s22'];
	$coq_s23=$sql_row['s23'];
	$coq_s24=$sql_row['s24'];
	$coq_s25=$sql_row['s25'];
	$coq_s26=$sql_row['s26'];
	$coq_s27=$sql_row['s27'];
	$coq_s28=$sql_row['s28'];
	$coq_s29=$sql_row['s29'];
	$coq_s30=$sql_row['s30'];
	$coq_s31=$sql_row['s31'];
	$coq_s32=$sql_row['s32'];
	$coq_s33=$sql_row['s33'];
	$coq_s34=$sql_row['s34'];
	$coq_s35=$sql_row['s35'];
	$coq_s36=$sql_row['s36'];
	$coq_s37=$sql_row['s37'];
	$coq_s38=$sql_row['s38'];
	$coq_s39=$sql_row['s39'];
	$coq_s40=$sql_row['s40'];
	$coq_s41=$sql_row['s41'];
	$coq_s42=$sql_row['s42'];
	$coq_s43=$sql_row['s43'];
	$coq_s44=$sql_row['s44'];
	$coq_s45=$sql_row['s45'];
	$coq_s46=$sql_row['s46'];
	$coq_s47=$sql_row['s47'];
	$coq_s48=$sql_row['s48'];
	$coq_s49=$sql_row['s49'];
	$coq_s50=$sql_row['s50'];
}

$sql="select * from $bai_pro3.allocate_stat_log where cat_ref=$cat_id";
mysqli_query($link, $sql) or exit("Sql Error l".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error l".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

//echo "<table border=1><tr><td>TID</td><td>Ratio</td><td>No.of Cuts</td><td>Plies</td><td>Max Plies/Cut</td><td>XS</td><td>S</td><td>M</td><td>L</td><td>XL</td><td>XXL</td><td>XXXL</td><td>Total</td></tr>";
while($sql_row=mysqli_fetch_array($sql_result))
{
//	echo "<tr><td>".$sql_row['tid']."</td><td>".$sql_row['ratio']."</td><td>".$sql_row['cut_count']."</td><td>".$sql_row['plies']."</td><td>".$sql_row['pliespercut']."</td>";
//echo "<td>".$sql_row['allocate_xs']."</td><td>".$sql_row['allocate_s']."</td><td>".$sql_row['allocate_m']."</td><td>".$sql_row['allocate_l']."</td><td>".$sql_row['allocate_xl']."</td><td>".$sql_row['allocate_xxl']."</td><td>".$sql_row['allocate_xxxl']."</td>";
//echo "<td>".($sql_row['allocate_xs']+$sql_row['allocate_s']+$sql_row['allocate_m']+$sql_row['allocate_l']+$sql_row['allocate_xl']+$sql_row['allocate_xxl']+$sql_row['allocate_xxxl'])."</td></td></tr>";
}
//echo "</table>";

// echo "</div>";
// echo "<div class=\"block\">";





$sql="select * from $bai_pro3.allocate_stat_log where tid='$ref_id'";
mysqli_query($link, $sql) or exit("Sql Error m".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error n".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

while($sql_row=mysqli_fetch_array($sql_result))
{
	$ratiocount=$sql_row['ratio'];
	$cut_count=$sql_row['cut_count'];
	$pliespercut=$sql_row['pliespercut'];
	$plies=$sql_row['plies'];
$allocate_s01=$sql_row['allocate_s01'];
$allocate_s02=$sql_row['allocate_s02'];
$allocate_s03=$sql_row['allocate_s03'];
$allocate_s04=$sql_row['allocate_s04'];
$allocate_s05=$sql_row['allocate_s05'];
$allocate_s06=$sql_row['allocate_s06'];
$allocate_s07=$sql_row['allocate_s07'];
$allocate_s08=$sql_row['allocate_s08'];
$allocate_s09=$sql_row['allocate_s09'];
$allocate_s10=$sql_row['allocate_s10'];
$allocate_s11=$sql_row['allocate_s11'];
$allocate_s12=$sql_row['allocate_s12'];
$allocate_s13=$sql_row['allocate_s13'];
$allocate_s14=$sql_row['allocate_s14'];
$allocate_s15=$sql_row['allocate_s15'];
$allocate_s16=$sql_row['allocate_s16'];
$allocate_s17=$sql_row['allocate_s17'];
$allocate_s18=$sql_row['allocate_s18'];
$allocate_s19=$sql_row['allocate_s19'];
$allocate_s20=$sql_row['allocate_s20'];
$allocate_s21=$sql_row['allocate_s21'];
$allocate_s22=$sql_row['allocate_s22'];
$allocate_s23=$sql_row['allocate_s23'];
$allocate_s24=$sql_row['allocate_s24'];
$allocate_s25=$sql_row['allocate_s25'];
$allocate_s26=$sql_row['allocate_s26'];
$allocate_s27=$sql_row['allocate_s27'];
$allocate_s28=$sql_row['allocate_s28'];
$allocate_s29=$sql_row['allocate_s29'];
$allocate_s30=$sql_row['allocate_s30'];
$allocate_s31=$sql_row['allocate_s31'];
$allocate_s32=$sql_row['allocate_s32'];
$allocate_s33=$sql_row['allocate_s33'];
$allocate_s34=$sql_row['allocate_s34'];
$allocate_s35=$sql_row['allocate_s35'];
$allocate_s36=$sql_row['allocate_s36'];
$allocate_s37=$sql_row['allocate_s37'];
$allocate_s38=$sql_row['allocate_s38'];
$allocate_s39=$sql_row['allocate_s39'];
$allocate_s40=$sql_row['allocate_s40'];
$allocate_s41=$sql_row['allocate_s41'];
$allocate_s42=$sql_row['allocate_s42'];
$allocate_s43=$sql_row['allocate_s43'];
$allocate_s44=$sql_row['allocate_s44'];
$allocate_s45=$sql_row['allocate_s45'];
$allocate_s46=$sql_row['allocate_s46'];
$allocate_s47=$sql_row['allocate_s47'];
$allocate_s48=$sql_row['allocate_s48'];
$allocate_s49=$sql_row['allocate_s49'];
$allocate_s50=$sql_row['allocate_s50'];


	$remarks=$sql_row['remarks'];
}

echo "<div class=\"block\">";
echo "<a class=\"btn btn-xs btn-warning\" href=\"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=$color_back&style=$style_back&schedule=$schedule_back\"><< Click here to Go Back</a>";
echo "<br><br>";
echo "<table class=\"table table-bordered\">";
echo "<tr><th>Ratio</th><td>:</td><td> ".$ratiocount."</td></tr>";
//echo "<tr><td>Cut Count</td><td>:</td><td> <INPUT type=\"text\" name=\"cutnos\" value=\"".$cut_count."\" size=\"10\"></td></tr>";
echo "<input type='hidden' value='$piles' id='plies_dummy'>";
echo "<tr style=\"color: #000000\"><td>Total No. Of Plies</td><td>:</td><td> <input class=\"form-control integer\" type=\"text\" name=\"plies\" min=1 id='pliesp'   value=\"".$plies."\" size=\"10\" required></td></tr>";
echo "<tr style=\"color: #000000\"><td>Max Plies per cut</td><td>:</td><td>  <input class=\"form-control integer\" type=\"text\" name=\"pliespercut\"  min=1 id='pliespercutp'   value=\"".$pliespercut."\" size=\"10\" required></td></tr>";
echo "</table>";

echo "<table class=\"table table-bordered\">";
echo "<thead><tr><td><center>Sizes</center></td><td><center>Requested Qty</center></td><td><center>Ratio Prepared Qty</center></td><td><center>Balance</center></td><td><center>Ratio</center></td></tr></thead>";
$count = sizeof($s_tit);
for($s=0;$s<sizeof($s_tit);$s++)
	{	
		//$flag = readonly
		$code= "aoq_s".$sizes_code[$s];
		$code1= "coq_s".$sizes_code[$s];
		$code3= "allocate_s".$sizes_code[$s];
		$flag = ($$code == 0)?'readonly':'';
		echo "<tr>
		<td><center>".$s_tit[$sizes_code[$s]]."</center></td>
		<td><center id='req_qty$s'>".$$code1."</center></td>
		<td><center  id='prepared_qty$s'>".$$code."</center></td>
		<td><center>".($$code-$$code1)."</center></td>
		<td><center><INPUT type=\"text\"  name=\"in_s".$sizes_code[$s]."\" id='ratioQty$s' class=\"ratios integer\"  required  value=\"".$$code3."\" size=\"10\"></center></td>
		</tr>";
		//id='in_s$sizes_code[$s]'
	}
/*
echo "<tr>
<td>".$size01."</td>
<td>".$coq_s01."</td>
<td>".$aoq_s01."</td>
<td>".($aoq_s01-$coq_s01)."</td>
<td><INPUT type=\"text\" name=\"in_s01\" value=\"".$allocate_s01."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size02."</td>
<td>".$coq_s02."</td>
<td>".$aoq_s02."</td>
<td>".($aoq_s02-$coq_s02)."</td>
<td><INPUT type=\"text\" name=\"in_s02\" value=\"".$allocate_s02."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size03."</td>
<td>".$coq_s03."</td>
<td>".$aoq_s03."</td>
<td>".($aoq_s03-$coq_s03)."</td>
<td><INPUT type=\"text\" name=\"in_s03\" value=\"".$allocate_s03."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size04."</td>
<td>".$coq_s04."</td>
<td>".$aoq_s04."</td>
<td>".($aoq_s04-$coq_s04)."</td>
<td><INPUT type=\"text\" name=\"in_s04\" value=\"".$allocate_s04."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size05."</td>
<td>".$coq_s05."</td>
<td>".$aoq_s05."</td>
<td>".($aoq_s05-$coq_s05)."</td>
<td><INPUT type=\"text\" name=\"in_s05\" value=\"".$allocate_s05."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size06."</td>
<td>".$coq_s06."</td>
<td>".$aoq_s06."</td>
<td>".($aoq_s06-$coq_s06)."</td>
<td><INPUT type=\"text\" name=\"in_s06\" value=\"".$allocate_s06."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size07."</td>
<td>".$coq_s07."</td>
<td>".$aoq_s07."</td>
<td>".($aoq_s07-$coq_s07)."</td>
<td><INPUT type=\"text\" name=\"in_s07\" value=\"".$allocate_s07."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size08."</td>
<td>".$coq_s08."</td>
<td>".$aoq_s08."</td>
<td>".($aoq_s08-$coq_s08)."</td>
<td><INPUT type=\"text\" name=\"in_s08\" value=\"".$allocate_s08."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size09."</td>
<td>".$coq_s09."</td>
<td>".$aoq_s09."</td>
<td>".($aoq_s09-$coq_s09)."</td>
<td><INPUT type=\"text\" name=\"in_s09\" value=\"".$allocate_s09."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size10."</td>
<td>".$coq_s10."</td>
<td>".$aoq_s10."</td>
<td>".($aoq_s10-$coq_s10)."</td>
<td><INPUT type=\"text\" name=\"in_s10\" value=\"".$allocate_s10."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size11."</td>
<td>".$coq_s11."</td>
<td>".$aoq_s11."</td>
<td>".($aoq_s11-$coq_s11)."</td>
<td><INPUT type=\"text\" name=\"in_s11\" value=\"".$allocate_s11."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size12."</td>
<td>".$coq_s12."</td>
<td>".$aoq_s12."</td>
<td>".($aoq_s12-$coq_s12)."</td>
<td><INPUT type=\"text\" name=\"in_s12\" value=\"".$allocate_s12."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size13."</td>
<td>".$coq_s13."</td>
<td>".$aoq_s13."</td>
<td>".($aoq_s13-$coq_s13)."</td>
<td><INPUT type=\"text\" name=\"in_s13\" value=\"".$allocate_s13."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size14."</td>
<td>".$coq_s14."</td>
<td>".$aoq_s14."</td>
<td>".($aoq_s14-$coq_s14)."</td>
<td><INPUT type=\"text\" name=\"in_s14\" value=\"".$allocate_s14."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size15."</td>
<td>".$coq_s15."</td>
<td>".$aoq_s15."</td>
<td>".($aoq_s15-$coq_s15)."</td>
<td><INPUT type=\"text\" name=\"in_s15\" value=\"".$allocate_s15."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size16."</td>
<td>".$coq_s16."</td>
<td>".$aoq_s16."</td>
<td>".($aoq_s16-$coq_s16)."</td>
<td><INPUT type=\"text\" name=\"in_s16\" value=\"".$allocate_s16."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size17."</td>
<td>".$coq_s17."</td>
<td>".$aoq_s17."</td>
<td>".($aoq_s17-$coq_s17)."</td>
<td><INPUT type=\"text\" name=\"in_s17\" value=\"".$allocate_s17."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size18."</td>
<td>".$coq_s18."</td>
<td>".$aoq_s18."</td>
<td>".($aoq_s18-$coq_s18)."</td>
<td><INPUT type=\"text\" name=\"in_s18\" value=\"".$allocate_s18."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size19."</td>
<td>".$coq_s19."</td>
<td>".$aoq_s19."</td>
<td>".($aoq_s19-$coq_s19)."</td>
<td><INPUT type=\"text\" name=\"in_s19\" value=\"".$allocate_s19."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size20."</td>
<td>".$coq_s20."</td>
<td>".$aoq_s20."</td>
<td>".($aoq_s20-$coq_s20)."</td>
<td><INPUT type=\"text\" name=\"in_s20\" value=\"".$allocate_s20."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size21."</td>
<td>".$coq_s21."</td>
<td>".$aoq_s21."</td>
<td>".($aoq_s21-$coq_s21)."</td>
<td><INPUT type=\"text\" name=\"in_s21\" value=\"".$allocate_s21."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size22."</td>
<td>".$coq_s22."</td>
<td>".$aoq_s22."</td>
<td>".($aoq_s22-$coq_s22)."</td>
<td><INPUT type=\"text\" name=\"in_s22\" value=\"".$allocate_s22."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size23."</td>
<td>".$coq_s23."</td>
<td>".$aoq_s23."</td>
<td>".($aoq_s23-$coq_s23)."</td>
<td><INPUT type=\"text\" name=\"in_s23\" value=\"".$allocate_s23."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size24."</td>
<td>".$coq_s24."</td>
<td>".$aoq_s24."</td>
<td>".($aoq_s24-$coq_s24)."</td>
<td><INPUT type=\"text\" name=\"in_s24\" value=\"".$allocate_s24."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size25."</td>
<td>".$coq_s25."</td>
<td>".$aoq_s25."</td>
<td>".($aoq_s25-$coq_s25)."</td>
<td><INPUT type=\"text\" name=\"in_s25\" value=\"".$allocate_s25."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size26."</td>
<td>".$coq_s26."</td>
<td>".$aoq_s26."</td>
<td>".($aoq_s26-$coq_s26)."</td>
<td><INPUT type=\"text\" name=\"in_s26\" value=\"".$allocate_s26."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size27."</td>
<td>".$coq_s27."</td>
<td>".$aoq_s27."</td>
<td>".($aoq_s27-$coq_s27)."</td>
<td><INPUT type=\"text\" name=\"in_s27\" value=\"".$allocate_s27."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size28."</td>
<td>".$coq_s28."</td>
<td>".$aoq_s28."</td>
<td>".($aoq_s28-$coq_s28)."</td>
<td><INPUT type=\"text\" name=\"in_s28\" value=\"".$allocate_s28."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size29."</td>
<td>".$coq_s29."</td>
<td>".$aoq_s29."</td>
<td>".($aoq_s29-$coq_s29)."</td>
<td><INPUT type=\"text\" name=\"in_s29\" value=\"".$allocate_s29."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size30."</td>
<td>".$coq_s30."</td>
<td>".$aoq_s30."</td>
<td>".($aoq_s30-$coq_s30)."</td>
<td><INPUT type=\"text\" name=\"in_s30\" value=\"".$allocate_s30."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size31."</td>
<td>".$coq_s31."</td>
<td>".$aoq_s31."</td>
<td>".($aoq_s31-$coq_s31)."</td>
<td><INPUT type=\"text\" name=\"in_s31\" value=\"".$allocate_s31."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size32."</td>
<td>".$coq_s32."</td>
<td>".$aoq_s32."</td>
<td>".($aoq_s32-$coq_s32)."</td>
<td><INPUT type=\"text\" name=\"in_s32\" value=\"".$allocate_s32."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size33."</td>
<td>".$coq_s33."</td>
<td>".$aoq_s33."</td>
<td>".($aoq_s33-$coq_s33)."</td>
<td><INPUT type=\"text\" name=\"in_s33\" value=\"".$allocate_s33."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size34."</td>
<td>".$coq_s34."</td>
<td>".$aoq_s34."</td>
<td>".($aoq_s34-$coq_s34)."</td>
<td><INPUT type=\"text\" name=\"in_s34\" value=\"".$allocate_s34."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size35."</td>
<td>".$coq_s35."</td>
<td>".$aoq_s35."</td>
<td>".($aoq_s35-$coq_s35)."</td>
<td><INPUT type=\"text\" name=\"in_s35\" value=\"".$allocate_s35."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size36."</td>
<td>".$coq_s36."</td>
<td>".$aoq_s36."</td>
<td>".($aoq_s36-$coq_s36)."</td>
<td><INPUT type=\"text\" name=\"in_s36\" value=\"".$allocate_s36."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size37."</td>
<td>".$coq_s37."</td>
<td>".$aoq_s37."</td>
<td>".($aoq_s37-$coq_s37)."</td>
<td><INPUT type=\"text\" name=\"in_s37\" value=\"".$allocate_s37."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size38."</td>
<td>".$coq_s38."</td>
<td>".$aoq_s38."</td>
<td>".($aoq_s38-$coq_s38)."</td>
<td><INPUT type=\"text\" name=\"in_s38\" value=\"".$allocate_s38."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size39."</td>
<td>".$coq_s39."</td>
<td>".$aoq_s39."</td>
<td>".($aoq_s39-$coq_s39)."</td>
<td><INPUT type=\"text\" name=\"in_s39\" value=\"".$allocate_s39."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size40."</td>
<td>".$coq_s40."</td>
<td>".$aoq_s40."</td>
<td>".($aoq_s40-$coq_s40)."</td>
<td><INPUT type=\"text\" name=\"in_s40\" value=\"".$allocate_s40."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size41."</td>
<td>".$coq_s41."</td>
<td>".$aoq_s41."</td>
<td>".($aoq_s41-$coq_s41)."</td>
<td><INPUT type=\"text\" name=\"in_s41\" value=\"".$allocate_s41."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size42."</td>
<td>".$coq_s42."</td>
<td>".$aoq_s42."</td>
<td>".($aoq_s42-$coq_s42)."</td>
<td><INPUT type=\"text\" name=\"in_s42\" value=\"".$allocate_s42."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size43."</td>
<td>".$coq_s43."</td>
<td>".$aoq_s43."</td>
<td>".($aoq_s43-$coq_s43)."</td>
<td><INPUT type=\"text\" name=\"in_s43\" value=\"".$allocate_s43."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size44."</td>
<td>".$coq_s44."</td>
<td>".$aoq_s44."</td>
<td>".($aoq_s44-$coq_s44)."</td>
<td><INPUT type=\"text\" name=\"in_s44\" value=\"".$allocate_s44."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size45."</td>
<td>".$coq_s45."</td>
<td>".$aoq_s45."</td>
<td>".($aoq_s45-$coq_s45)."</td>
<td><INPUT type=\"text\" name=\"in_s45\" value=\"".$allocate_s45."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size46."</td>
<td>".$coq_s46."</td>
<td>".$aoq_s46."</td>
<td>".($aoq_s46-$coq_s46)."</td>
<td><INPUT type=\"text\" name=\"in_s46\" value=\"".$allocate_s46."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size47."</td>
<td>".$coq_s47."</td>
<td>".$aoq_s47."</td>
<td>".($aoq_s47-$coq_s47)."</td>
<td><INPUT type=\"text\" name=\"in_s47\" value=\"".$allocate_s47."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size48."</td>
<td>".$coq_s48."</td>
<td>".$aoq_s48."</td>
<td>".($aoq_s48-$coq_s48)."</td>
<td><INPUT type=\"text\" name=\"in_s48\" value=\"".$allocate_s48."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size49."</td>
<td>".$coq_s49."</td>
<td>".$aoq_s49."</td>
<td>".($aoq_s49-$coq_s49)."</td>
<td><INPUT type=\"text\" name=\"in_s49\" value=\"".$allocate_s49."\" size=\"10\"></td>
</tr>";

echo "<tr>
<td>".$size50."</td>
<td>".$coq_s50."</td>
<td>".$aoq_s50."</td>
<td>".($aoq_s50-$coq_s50)."</td>
<td><INPUT type=\"text\" name=\"in_s50\" value=\"".$allocate_s50."\" size=\"10\"></td>
</tr>";
*/

echo "</table>";
//echo "Remarks: <INPUT type=\"text\" name=\"remarks\" value=\"".$remarks."\">";
echo "<div class=\"col-md-4\">";
echo "<label>Remarks:</label> <select class=\"form-control\" name=\"remarks\">";
if($remarks=="Normal") { echo "<option value=\"Normal\" selected >Normal</option>"; } else { echo "<option value=\"Normal\">Normal</option>"; }
if($remarks=="Pilot") {echo "<option value=\"Pilot\" selected >Pilot</option>"; } else { echo "<option value=\"Pilot\">Pilot</option>"; }
echo "</select></div>";

echo "<input type\"text\" name=\"ratio\" value=\"".$ratiocount."\" style=\"visibility:hidden\">";
echo "<input type\"text\" name=\"ref_id\" value=\"".$ref_id."\" style=\"visibility:hidden\">";
echo "<div class=\"col-md-4\">";
//echo "<input type=\"checkbox\" name=\"option\"  id=\"option\" onclick=\"javascript:enableButton();\">Enable&nbsp;&nbsp;&nbsp;";
echo "<INPUT class=\"btn btn-sm btn-primary \" onclick='return verify_num(this,event)' TYPE = \"submit\" id=\"update\" Name = \"Update\" VALUE = \"Update\"></div>";
echo "</form>";
echo "</div>";

?>

</div>
</div>
</div>
</body>
</html>


<script>
function check(){
	var count = '<?= $count; ?>';
	var j = 0;
	for(var i=0; i<count; i++){
		if($('#ratioQty'+i).val() != 0){
			j += 1;
			console.log($('#ratioQty'+i).val());
		}
		console.log($('#ratioQty'+i).val());
	}
	if(j == 0){
		sweetAlert('Error','Please fill atleast 1 ratio feild and that should be equal or more than 0','error');
		return false;
	}
}

function chec(){
	// for(var i=0; i<count; i++){
		// if($('#ratioQty'+i).val() != ""){
			// j += 1;
			//console.log($('#ratioQty'+i).val());
		// }
		//console.log($('#ratioQty'+i).val());
	// }
	// if(j == 0){
		// sweetAlert('Error','Please fill atleast 1 ratio feild and that should be equal or more than 0','error');
		
	// }
	var count = '<?= $count; ?>';
	var j = 0;
	for(var i=0; i<count; i++)
	{
		var id = i;
		var rep = 'req_qty'+id;
		var rev = 'prepared_qty'+id;
		console.log(rev);
		var present = 'ratioQty'+id;
		//console.log(rev);
		var reported_qty_validation = document.getElementById(rep).innerHTML;
		console.log(reported_qty_validation);
		var reverting_qty = document.getElementById(rev).innerHTML;
		console.log(reverting_qty);
		if(Number(document.getElementById(present).value) != 0)
		{
			if(Number(reported_qty_validation) <= Number(reverting_qty))
			{
				j = 1;
				document.getElementById(present).value = 0;
				break;
			}
		}
	}
	if(j == 1)
	{
		sweetAlert('','Ratio preparing quantity is more than requested quantity.','error');
		return false;
	}
	
	
	
}
</script>