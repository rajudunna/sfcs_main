<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/functions.php',4,'R')); ?>

<script type="text/javascript" src="<?= '../'.getFullURLLevel($_GET['r'],'common/js/check.js',4,'R')?>"></script>
<!-- <link href="style.css" rel="stylesheet" type="text/css" /> -->


<style>
div.block
{
	float: left;	
	padding: 30 px;
}

input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0; 
}
</style>

<script type="text/javascript">

function verify_num(t,e){
	var id = t.id;
	var qty = document.getElementById(id);
	$('#'+t.id).keyup(function(){

		if ($(this).val() > 100){
			$(this).val(0);
			sweetAlert("Error","Percentage shouldn't exceed 100","warning");
		}else{
			percent_cal();
		}
		
		
	});
	// console.log(t.id);
	// if( !(qty.value.match(c)) ){
	// 	sweetAlert('Please Enter Valid Percentage','','warning');
	// 	qty.value = 0;
	// 	return false;
	// }
	// alert(t);
	// if ($(this).val() > 100){
	// 	alert("No numbers above 100");
	// 	$(this).val('100');
	// }
	
}


function verify_con(e){
	var ce =  document.getElementById('excess');
	var cw =  document.getElementById('waste').value; 
	if(ce.value =='' || cw==''){
		e.preventDefault();
		ce.value = 0;
		sweetAlert('','Please fill out cutting-excess and cutting-less percentages','info');
		return false;
	}
	percent_cal();
	
}
function percent_cal()
{
    var x = document.getElementById("excess").value;
	if(isNaN(x)){
		var x = 0;
	}
    //if(x>=0)
	//{
		for(var i=1; i<=50; i++){
			if(i < 10){
				var val = 'in_s0'+i+'_source';
				var sample_qty = 'in_s0'+i+'_sample';
			}else{
				var val = 'in_s'+i+'_source';
				var sample_qty = 'in_s'+i+'_sample';
			}
			if(document.getElementsByName(sample_qty)[0]){
				sQty = document.getElementsByName(sample_qty)[0].value;
			}else{
				sQty = 0;
			}
			if(document.getElementsByName(val)[0] != undefined){
				// var val = 'in_s0'+i+'_source';
				document.getElementsByName('in_s0'+i)[0].value = Math.round(parseInt(document.getElementsByName(val)[0].value)+document.getElementsByName(val)[0].value*x/100)+parseInt(sQty);
			}			
		}		
	//}	
}

function ind_per_cal(x)
{
	
	var a="in_"+x;
	var b="in_"+x+"_source";
	var c="e_in_"+x;

	document.getElementsByName(a)[0].value=parseInt(document.getElementsByName(b)[0].value)+document.getElementsByName(b)[0].value*document.getElementsByName(c)[0].value/100;
}

</script>



<body onload="javascript:dodisable();">
<div class="panel panel-primary">
<div class="panel-heading">Cuttable Input Form</div>
<div class="panel-body">
<FORM method="post" name="input" action='<?php echo getFullURL($_GET["r"], "order_cut_process.php", "N")?>'>
<?php

$check_id=$_GET['check_id'];
$tran_order_tid=$_GET['tran_order_tid'];


echo "<input type=\"hidden\" name=\"tran_order_tid\" value=\"".$tran_order_tid."\">";
echo "<input type=\"hidden\" name=\"check_id\" value=\"".$check_id."\">";


$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

while($sql_row=mysqli_fetch_array($sql_result))
{
	
/*echo "<td>";
Echo "<table><tr><td>Order Ref</td><td>:</td><td>".$tran_order_tid ."</td></tr><tr><td>Date</td><td>:</td><td>".$sql_row['order_date']."</td></tr>";

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

//mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

while($sql_row=mysqli_fetch_array($sql_result))
{
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
		
		$color_back=$sql_row['order_col_des'];
		$style_back=$sql_row['order_style_no'];
		$schedule_back=$sql_row['order_del_no'];
		
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
			$size01='s01';
			$size02='s02';
			$size03='s03';
			$size04='s04';
			$size05='s05';
			$size06='s06';
			$size07='s07';
			$size08='s08';
			$size09='s09';
			$size10='s10';
			$size11='s11';
			$size12='s12';
			$size13='s13';
			$size14='s14';
			$size15='s15';
			$size16='s16';
			$size17='s17';
			$size18='s18';
			$size19='s19';
			$size20='s20';
			$size21='s21';
			$size22='s22';
			$size23='s23';
			$size24='s24';
			$size25='s25';
			$size26='s26';
			$size27='s27';
			$size28='s28';
			$size29='s29';
			$size30='s30';
			$size31='s31';
			$size32='s32';
			$size33='s33';
			$size34='s34';
			$size35='s35';
			$size36='s36';
			$size37='s37';
			$size38='s38';
			$size39='s39';
			$size40='s40';
			$size41='s41';
			$size42='s42';
			$size43='s43';
			$size44='s44';
			$size45='s45';
			$size46='s46';
			$size47='s47';
			$size48='s48';
			$size49='s49';
			$size50='s50';


		}
}

$sql="select * from $bai_pro3.cat_stat_log where order_tid=\"$tran_order_tid\" and tid=$check_id";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

//echo "<table border=1><tr><td>TID</td><td>Date</td><td>Category</td><td>Cat YY</td><td>Fab Des</td><td>PurWidth</td><td>gmtway</td><td>STATUS</td><td>remarks</td></tr>";
while($sql_row=mysqli_fetch_array($sql_result))
{
	
$check=0;
$sql2="select sum(cuttable_s_s01) as \"s01\", sum(cuttable_s_s02) as \"s02\", sum(cuttable_s_s03) as \"s03\", sum(cuttable_s_s04) as \"s04\", sum(cuttable_s_s05) as \"s05\", sum(cuttable_s_s06) as \"s06\", sum(cuttable_s_s07) as \"s07\", sum(cuttable_s_s08) as \"s08\", sum(cuttable_s_s09) as \"s09\", sum(cuttable_s_s10) as \"s10\", sum(cuttable_s_s11) as \"s11\", sum(cuttable_s_s12) as \"s12\", sum(cuttable_s_s13) as \"s13\", sum(cuttable_s_s14) as \"s14\", sum(cuttable_s_s15) as \"s15\", sum(cuttable_s_s16) as \"s16\", sum(cuttable_s_s17) as \"s17\", sum(cuttable_s_s18) as \"s18\", sum(cuttable_s_s19) as \"s19\", sum(cuttable_s_s20) as \"s20\", sum(cuttable_s_s21) as \"s21\", sum(cuttable_s_s22) as \"s22\", sum(cuttable_s_s23) as \"s23\", sum(cuttable_s_s24) as \"s24\", sum(cuttable_s_s25) as \"s25\", sum(cuttable_s_s26) as \"s26\", sum(cuttable_s_s27) as \"s27\", sum(cuttable_s_s28) as \"s28\", sum(cuttable_s_s29) as \"s29\", sum(cuttable_s_s30) as \"s30\", sum(cuttable_s_s31) as \"s31\", sum(cuttable_s_s32) as \"s32\", sum(cuttable_s_s33) as \"s33\", sum(cuttable_s_s34) as \"s34\", sum(cuttable_s_s35) as \"s35\", sum(cuttable_s_s36) as \"s36\", sum(cuttable_s_s37) as \"s37\", sum(cuttable_s_s38) as \"s38\", sum(cuttable_s_s39) as \"s39\", sum(cuttable_s_s40) as \"s40\", sum(cuttable_s_s41) as \"s41\", sum(cuttable_s_s42) as \"s42\", sum(cuttable_s_s43) as \"s43\", sum(cuttable_s_s44) as \"s44\", sum(cuttable_s_s45) as \"s45\", sum(cuttable_s_s46) as \"s46\", sum(cuttable_s_s47) as \"s47\", sum(cuttable_s_s48) as \"s48\", sum(cuttable_s_s49) as \"s49\", sum(cuttable_s_s50) as \"s50\" from $bai_pro3.cuttable_stat_log where order_tid=\"$tran_order_tid\" and cat_id=".$sql_row['tid'];
mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

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
	

	$check_id=$sql_row['tid'];

	/*echo "<tr>";
	echo "<td>".$sql_row['tid']."</td>";
	echo "<td>".$sql_row['date']."</td>";
	echo "<td>".$sql_row['category']."</td>";
	echo "<td>".$sql_row['catyy']."</td>";
	echo "<td>".$sql_row['fab_des']."</td>";
	echo "<td>".$sql_row['purwidth']."</td>";
	echo "<td>".$sql_row['gmtway']."</td>";

	echo "<td bgcolor=".$color.">STATUS</td>";
	echo "<td>".$sql_row['remarks']."</td>";

	echo "</tr>"; */
}
//echo "</table>";




/* NEW */

$oq_s01=0;
$oq_s02=0;
$oq_s03=0;
$oq_s04=0;
$oq_s05=0;
$oq_s06=0;
$oq_s07=0;
$oq_s08=0;
$oq_s09=0;
$oq_s10=0;
$oq_s11=0;
$oq_s12=0;
$oq_s13=0;
$oq_s14=0;
$oq_s15=0;
$oq_s16=0;
$oq_s17=0;
$oq_s18=0;
$oq_s19=0;
$oq_s20=0;
$oq_s21=0;
$oq_s22=0;
$oq_s23=0;
$oq_s24=0;
$oq_s25=0;
$oq_s26=0;
$oq_s27=0;
$oq_s28=0;
$oq_s29=0;
$oq_s30=0;
$oq_s31=0;
$oq_s32=0;
$oq_s33=0;
$oq_s34=0;
$oq_s35=0;
$oq_s36=0;
$oq_s37=0;
$oq_s38=0;
$oq_s39=0;
$oq_s40=0;
$oq_s41=0;
$oq_s42=0;
$oq_s43=0;
$oq_s44=0;
$oq_s45=0;
$oq_s46=0;
$oq_s47=0;
$oq_s48=0;
$oq_s49=0;
$oq_s50=0;



$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result)==0)
{
	$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid\"";
}

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

while($sql_row=mysqli_fetch_array($sql_result))
{
$oq_s01=$sql_row['order_s_s01'];
$oq_s02=$sql_row['order_s_s02'];
$oq_s03=$sql_row['order_s_s03'];
$oq_s04=$sql_row['order_s_s04'];
$oq_s05=$sql_row['order_s_s05'];
$oq_s06=$sql_row['order_s_s06'];
$oq_s07=$sql_row['order_s_s07'];
$oq_s08=$sql_row['order_s_s08'];
$oq_s09=$sql_row['order_s_s09'];
$oq_s10=$sql_row['order_s_s10'];
$oq_s11=$sql_row['order_s_s11'];
$oq_s12=$sql_row['order_s_s12'];
$oq_s13=$sql_row['order_s_s13'];
$oq_s14=$sql_row['order_s_s14'];
$oq_s15=$sql_row['order_s_s15'];
$oq_s16=$sql_row['order_s_s16'];
$oq_s17=$sql_row['order_s_s17'];
$oq_s18=$sql_row['order_s_s18'];
$oq_s19=$sql_row['order_s_s19'];
$oq_s20=$sql_row['order_s_s20'];
$oq_s21=$sql_row['order_s_s21'];
$oq_s22=$sql_row['order_s_s22'];
$oq_s23=$sql_row['order_s_s23'];
$oq_s24=$sql_row['order_s_s24'];
$oq_s25=$sql_row['order_s_s25'];
$oq_s26=$sql_row['order_s_s26'];
$oq_s27=$sql_row['order_s_s27'];
$oq_s28=$sql_row['order_s_s28'];
$oq_s29=$sql_row['order_s_s29'];
$oq_s30=$sql_row['order_s_s30'];
$oq_s31=$sql_row['order_s_s31'];
$oq_s32=$sql_row['order_s_s32'];
$oq_s33=$sql_row['order_s_s33'];
$oq_s34=$sql_row['order_s_s34'];
$oq_s35=$sql_row['order_s_s35'];
$oq_s36=$sql_row['order_s_s36'];
$oq_s37=$sql_row['order_s_s37'];
$oq_s38=$sql_row['order_s_s38'];
$oq_s39=$sql_row['order_s_s39'];
$oq_s40=$sql_row['order_s_s40'];
$oq_s41=$sql_row['order_s_s41'];
$oq_s42=$sql_row['order_s_s42'];
$oq_s43=$sql_row['order_s_s43'];
$oq_s44=$sql_row['order_s_s44'];
$oq_s45=$sql_row['order_s_s45'];
$oq_s46=$sql_row['order_s_s46'];
$oq_s47=$sql_row['order_s_s47'];
$oq_s48=$sql_row['order_s_s48'];
$oq_s49=$sql_row['order_s_s49'];
$oq_s50=$sql_row['order_s_s50'];


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



$sql="select sum(cuttable_s_s01) as \"s01\", sum(cuttable_s_s02) as \"s02\", sum(cuttable_s_s03) as \"s03\", sum(cuttable_s_s04) as \"s04\", sum(cuttable_s_s05) as \"s05\", sum(cuttable_s_s06) as \"s06\", sum(cuttable_s_s07) as \"s07\", sum(cuttable_s_s08) as \"s08\", sum(cuttable_s_s09) as \"s09\", sum(cuttable_s_s10) as \"s10\", sum(cuttable_s_s11) as \"s11\", sum(cuttable_s_s12) as \"s12\", sum(cuttable_s_s13) as \"s13\", sum(cuttable_s_s14) as \"s14\", sum(cuttable_s_s15) as \"s15\", sum(cuttable_s_s16) as \"s16\", sum(cuttable_s_s17) as \"s17\", sum(cuttable_s_s18) as \"s18\", sum(cuttable_s_s19) as \"s19\", sum(cuttable_s_s20) as \"s20\", sum(cuttable_s_s21) as \"s21\", sum(cuttable_s_s22) as \"s22\", sum(cuttable_s_s23) as \"s23\", sum(cuttable_s_s24) as \"s24\", sum(cuttable_s_s25) as \"s25\", sum(cuttable_s_s26) as \"s26\", sum(cuttable_s_s27) as \"s27\", sum(cuttable_s_s28) as \"s28\", sum(cuttable_s_s29) as \"s29\", sum(cuttable_s_s30) as \"s30\", sum(cuttable_s_s31) as \"s31\", sum(cuttable_s_s32) as \"s32\", sum(cuttable_s_s33) as \"s33\", sum(cuttable_s_s34) as \"s34\", sum(cuttable_s_s35) as \"s35\", sum(cuttable_s_s36) as \"s36\", sum(cuttable_s_s37) as \"s37\", sum(cuttable_s_s38) as \"s38\", sum(cuttable_s_s39) as \"s39\", sum(cuttable_s_s40) as \"s40\", sum(cuttable_s_s41) as \"s41\", sum(cuttable_s_s42) as \"s42\", sum(cuttable_s_s43) as \"s43\", sum(cuttable_s_s44) as \"s44\", sum(cuttable_s_s45) as \"s45\", sum(cuttable_s_s46) as \"s46\", sum(cuttable_s_s47) as \"s47\", sum(cuttable_s_s48) as \"s48\", sum(cuttable_s_s49) as \"s49\", sum(cuttable_s_s50) as \"s50\" from $bai_pro3.cuttable_stat_log where order_tid=\"$tran_order_tid\" and cat_id=$check_id";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

while($sql_row=mysqli_fetch_array($sql_result))
{
$coq_s01=$sql_row2['s01'];
$coq_s02=$sql_row2['s02'];
$coq_s03=$sql_row2['s03'];
$coq_s04=$sql_row2['s04'];
$coq_s05=$sql_row2['s05'];
$coq_s06=$sql_row2['s06'];
$coq_s07=$sql_row2['s07'];
$coq_s08=$sql_row2['s08'];
$coq_s09=$sql_row2['s09'];
$coq_s10=$sql_row2['s10'];
$coq_s11=$sql_row2['s11'];
$coq_s12=$sql_row2['s12'];
$coq_s13=$sql_row2['s13'];
$coq_s14=$sql_row2['s14'];
$coq_s15=$sql_row2['s15'];
$coq_s16=$sql_row2['s16'];
$coq_s17=$sql_row2['s17'];
$coq_s18=$sql_row2['s18'];
$coq_s19=$sql_row2['s19'];
$coq_s20=$sql_row2['s20'];
$coq_s21=$sql_row2['s21'];
$coq_s22=$sql_row2['s22'];
$coq_s23=$sql_row2['s23'];
$coq_s24=$sql_row2['s24'];
$coq_s25=$sql_row2['s25'];
$coq_s26=$sql_row2['s26'];
$coq_s27=$sql_row2['s27'];
$coq_s28=$sql_row2['s28'];
$coq_s29=$sql_row2['s29'];
$coq_s30=$sql_row2['s30'];
$coq_s31=$sql_row2['s31'];
$coq_s32=$sql_row2['s32'];
$coq_s33=$sql_row2['s33'];
$coq_s34=$sql_row2['s34'];
$coq_s35=$sql_row2['s35'];
$coq_s36=$sql_row2['s36'];
$coq_s37=$sql_row2['s37'];
$coq_s38=$sql_row2['s38'];
$coq_s39=$sql_row2['s39'];
$coq_s40=$sql_row2['s40'];
$coq_s41=$sql_row2['s41'];
$coq_s42=$sql_row2['s42'];
$coq_s43=$sql_row2['s43'];
$coq_s44=$sql_row2['s44'];
$coq_s45=$sql_row2['s45'];
$coq_s46=$sql_row2['s46'];
$coq_s47=$sql_row2['s47'];
$coq_s48=$sql_row2['s48'];
$coq_s49=$sql_row2['s49'];
$coq_s50=$sql_row2['s50'];

}


if($color_back == null){
	$color_back = $_GET['color'];
	// echo $color_back;
}
if($schedule_back == null){
	$schedule_back = $_GET['schedule'];
	// echo $schedule_back;
}
if($style_back == null){
	$style_back = $_GET['style'];
	// echo $style_back;
}

//Getting sample details here  By SK-05-07-2018 == Start
$samples_qry="select * from $bai_pro3.sp_sample_order_db where order_tid='$tran_order_tid' order by sizes_ref";
$samples_qry_result=mysqli_query($link, $samples_qry) or exit("Sample query details".mysqli_error($GLOBALS["___mysqli_ston"]));
$num_rows_samples = mysqli_num_rows($samples_qry_result);
if($num_rows_samples >0){
	$samples_total = 0;	
	while($samples_data=mysqli_fetch_array($samples_qry_result))
	{
		$samples_total+=$samples_data['input_qty'];
		$samples_size_arry[] =$samples_data['sizes_ref'];
		$samples_input_qty_arry[] =$samples_data['input_qty'];
	}		
}
// Samples End By SK-05-07-2018

echo "<a class=\"btn btn-xs btn-warning\" href=\"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=".$color_back."&style=".$style_back."&schedule=".$schedule_back."\"><<<< Click here to Go Back</a>";
echo "<br><br>";
$url = getFullURL($_GET['r'],'order_cut_process.php','N');
//echo $url;
echo "<form method=\"post\" name=\"input\" action=\"$url\">";
echo "<div class=\"row\"><div class=\"col-md-4\"><label>Cutting Excess:(%)</label>
	  <input class='form-control float' type='text'   
	  onkeyup='return verify_num(this,event)' required 
	  id='excess' name='cuttable_percent' size='2' onfocus=\"if(this.value==0){this.value=''}\" 
	  value='0' onKeydown='return verify_num(this,event)'></div>";
echo "<div class=\"col-md-4\"><label>Cutting Wastage:(%)</label>
	  <input class='form-control float' type='text' id='waste' 
	   onkeyup='return verify_num(this,event)' required name='cuttable_wastage' value='0' size='2'></div></div>";

echo "<hr/><table class=\"table table-bordered\">";
echo "<thead><tr class='success'><td class=\"\"><center>Sizes</center></td><td class=\"  \"><center>Order Qty</center></td>
<td class=\"  \"><center>Samples Qty</center></td><td class=\"  \"><center>Completed</center></td><td class=\"  \"><center>Balance</center></td><td style='display:none;' class=\"  \"><center>Excess %</center></td><td class=\"  \"><center>Cuttable Qty</center></td></tr></thead>";
for($s=0;$s<sizeof($s_tit);$s++)
	{	
		$code= "oq_s".$sizes_code[$s];
		$code1= "coq_s".$sizes_code[$s];
		//echo $$code1;
		$flag = ($$code == 0)?'readonly':'';
		//samples qty display SK 06-07-2018 == Start
		$size_code = 's'.$sizes_code[$s];
		$flg = 0;		
		//samples qty display SK 06-07-2018 == End
		echo "<tr>
		<td><center>".$s_tit[$sizes_code[$s]]."</center></td>
		<td><center>".$$code."</center></td>";
		//samples qty display SK 06-07-2018 == Start
		for($ss=0;$ss<sizeof($samples_size_arry);$ss++)
		{
			if($size_code == $samples_size_arry[$ss]){
				echo "<td><input type=\"hidden\" name=\"in_s".$sizes_code[$s]."_sample\" value=".$samples_input_qty_arry[$ss]."><center>".$samples_input_qty_arry[$ss]."</center></td>";
				$flg = 1;
			}			
		}	
		if($flg == 0){
			echo "<td class=\"sizes\"><strong>-</strong></td>";
		}
		//samples qty display SK 06-07-2018 == End
		echo "<td><center>".$$code1."</center></td>
		<td><center>".($$code1-$$code)."</center></td>
		<td style='display:none;'><center>
			<input class=\"form-control\" type=\"text\"  name=\"e_in_s".$sizes_code[$s]."\" onkeydown='return verify_num(event)'  required value=0 onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value=0;}\" onchange=\"ind_per_cal('".$sizes_code[$s]."')\"></center></td>
		<td align='center'><div class='row'><div class='col-md-offset-4 col-md-4'><input type=\"hidden\" name=\"in_s".$sizes_code[$s]."_source\" value=".(abs($$code1-$$code)).">
			<center><input class=\"form-control\" $flag type=\"text\"  name=\"in_s".$sizes_code[$s]."\" readonly value=".$$code." size=\"10\"></center></div></div></td>
		</tr>";
	}
if(count($s_tit) <= 0){
	$display = "display:none";
}
else{
	$display = "";
}
echo "<input class=\"btn btn-sm btn-primary\" type=\"submit\" name = \"Update\" value = \"Update\" onclick='return verify_con(event)' style=$display></div>";
echo "</form>";

?>

</div></div>
</div></div>
</body>

<script>
percent_cal();
</script>