<!--
Change Log:
1. CR: 193 / kirang / 2014-2-19 : modify the user_style_id>0 as user_style_id not in (0,'') in marker_ref_matrix_view condition for displaying the 'MV' styles.
2. Service Request #716897/ kirang / 2015-5-16:  Add the User Style ID and Packing Method validations at Cut Plan generation 
-->

<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/php/functions.php',4,'R')); ?>
<?php //echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<style>
div.block
{
	float: left;	
	padding: 30 px;
}
</style>

<script type="text/javascript" src="<?= '../'.getFullURLLevel($_GET['r'],'common/js/check.js',2,'R')?>"></script>
<!-- <link href="style.css" rel="stylesheet" type="text/css" /> -->
<script type="text/javascript">
	function validateQty(event) 
	{
		event = (event) ? event : window.event;
		var charCode = (event.which) ? event.which : event.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}


function verify_null(){
	var ver = document.getElementById('d16').value;
	var eff =  document.getElementById('d15').value;
	var mklen = document.getElementById('d1').value;
	if(eff == '' || (eff>100 || eff<=0)){
		sweetAlert('Please enter valid Marker Efficiency','','warning');
		return false;
	}
	if(ver <=0 || ver ==''){
		sweetAlert('Please enter valid Marker Version','','warning');
		return false;
	}
	if(mklen == ''|| mklen <=0){
		sweetAlert('Please enter valid Marker Length','','warning');
		return false;
	}
	return true;
}

</script>


<?php	
$tran_order_tid=$_GET['tran_order_tid'];
$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid\"";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

while($sql_row=mysqli_fetch_array($sql_result))
{
	$color=$sql_row['order_col_des'];
	$style=$sql_row['order_style_no'];
	$schedule=$sql_row['order_del_no'];
	

}
?>

<div class="panel panel-primary">
<div class="panel-heading">Maker Form</div>
<div class="panel-body">
<?php echo "<a class=\"btn btn-xs btn-warning\" href=\"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=$color&style=$style&schedule=$schedule\"><<<< Click here to Go Back</a>";?>	
<FORM method="post" name="input" action="<?php echo getFullURL($_GET['r'], "order_maker_process.php", "N"); ?>">
<?php

$cat_ref=$_GET['cat_ref'];
$tran_order_tid=$_GET['tran_order_tid'];
$cuttable_ref=$_GET['cuttable_ref'];
$allocate_ref=$_GET['allocate_ref'];

echo "<input type='hidden' name='cat_ref' value='$cat_ref'>";
echo "<input type='hidden' name='tran_order_tid' value='$tran_order_tid'>";
echo "<input type='hidden' name='cuttable_ref' value='$cuttable_ref'>";
echo "<input type='hidden' name='allocate_ref' value='$allocate_ref'>";


echo "<div class=block>";
echo "<input type=\"hidden\" name=\"tran_order_tid\" value=\"".$tran_order_tid."\">";
echo "<br/>";

$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid\"";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

while($sql_row=mysqli_fetch_array($sql_result))
{
	
/*echo "<td>";
Echo "<table><tr><td>Order Ref</td><td>:</td><td>".$tran_order_tid."</td></tr><tr><td>Date</td><td>:</td><td>".$sql_row['order_date']."</td></tr>";

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
<td colspan=\"11\">".$sql_row['Order_remarks']."</td>
</tr>";

echo "</table>"; */

}

/* NEW */

$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

while($sql_row=mysqli_fetch_array($sql_result))
{
	$order_xs=$sql_row['order_s_xs'];
	$order_s=$sql_row['order_s_s'];
	$order_m=$sql_row['order_s_m'];
	$order_l=$sql_row['order_s_l'];
	$order_xl=$sql_row['order_s_xl'];
	$order_xxl=$sql_row['order_s_xxl'];
	$order_xxxl=$sql_row['order_s_xxxl'];
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
	$style_code=$sql_row['style_id'];
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
		$title_flag = $sql_row['title_flag'];
	$buyer_code=substr($sql_row['order_style_no'],0,1);

}

$sql="select * from $bai_pro3.cat_stat_log where order_tid=\"$tran_order_tid\" and tid=$cat_ref";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

//echo "<table border=1><tr><td>TID</td><td>Date</td><td>Category</td><td>PurWidth</td><td>gmtway</td><td>STATUS</td><td>remarks</td></tr>";
while($sql_row=mysqli_fetch_array($sql_result))
{

$pur_width=$sql_row['purwidth'];
$patt_ver=$sql_row['patt_ver'];

$strip_match=$sql_row['strip_match'];
$gmtway=$sql_row['gmtway'];

$category=$sql_row['category'];
	
$check=0;
$sql2="select sum(cuttable_s_xs) as \"cxs\", sum(cuttable_s_s) as \"cs\", sum(cuttable_s_m) as \"cm\", sum(cuttable_s_l) as \"cl\", sum(cuttable_s_xl) as \"cxl\", sum(cuttable_s_xxl) as \"cxxl\", sum(cuttable_s_xxxl) as \"cxxxl\" from $bai_pro3.cuttable_stat_log where order_tid=\"$tran_order_tid\" and cat_id=".$sql_row['tid'];
$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

while($sql_row2=mysqli_fetch_array($sql_result2))
{
	$cxs=$sql_row2['cxs'];
	$cs=$sql_row2['cs'];
	$cm=$sql_row2['cm'];
	$cl=$sql_row2['cl'];
	$cxl=$sql_row2['cxl'];
	$cxxl=$sql_row2['cxxl'];
	$cxxxl=$sql_row2['cxxxl'];

	if($cxs<$order_xs){$check=1;}
	if($cs<$order_s){$check=1;}
	if($cm<$order_m){$check=1;}
	if($cl<$order_l){$check=1;}
	if($cxl<$order_xl){$check=1;}
	if($cxxl<$order_xxl){$check=1;}
	if($cxxxl<$order_xxxl){$check=1;}
	
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



//echo "</div>";
//echo "<div class=block>";

/* update */


$sql2="select * from $bai_pro3.allocate_stat_log where order_tid=\"$tran_order_tid\" and tid=$allocate_ref";
$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

while($sql_row2=mysqli_fetch_array($sql_result2))
{


/*echo "</table>";
echo "</td><td>";
echo "<table border=1>";

echo "<tr align=center bgcolor=yellow><td>Sizes</td><td>XS</td><td>S</td><td>M</td><td>L</td><td>XL</td><td>XXL</td><td>XXXl</td><td>Total</td><td>ration</td><td>cuts</td><td>plies</td><td>Max Plies / Cut</td></tr>";

echo "<tr><td bgcolor=#CCFF66>Quantity</td>";

echo "<td>".$sql_row2['allocate_xs']."</td>";

echo "<td>".$sql_row2['allocate_s']."</td>";

echo "<td>".$sql_row2['allocate_m']."</td>";

echo "<td>".$sql_row2['allocate_l']."</td>";

echo "<td>".$sql_row2['allocate_xl']."</td>";

echo "<td>".$sql_row2['allocate_xxl']."</td>";

echo "<td>".$sql_row2['allocate_xxxl']."</td>";

echo "<td>".($sql_row2['allocate_xs']+$sql_row2['allocate_s']+$sql_row2['allocate_m']+$sql_row2['allocate_l']+$sql_row2['allocate_xl']+$sql_row2['allocate_xxl']+$sql_row2['allocate_xxxl'])."</td>";

echo "<td>".$sql_row2['ratio']."</td>";
echo "<td>".$sql_row2['cut_count']."</td>";
echo "<td>".$sql_row2['plies']."</td>";
echo "<td>".$sql_row2['pliespercut']."</td></tr>";
echo "<tr>
<td bgcolor=#CCFF66>Remarks</td>
<td colspan=12>".$sql_row2['remarks']."</td>
</tr>";

echo "</table>"; */


}



/* update*/


echo "<div class=\"table-responsive\"><table class=\"table table-bordered\">";
echo "<tr>
		<td>Marker LENGTH 1</td><td>:</td>
		<input type=\"hidden\" name=\"in_pwidth[]\" value=\"$pur_width\">
		<td>
			<INPUT class=\"form-control float\" type=\"text\" title='Please enter numbers and decimals' required name=\"in_mklength[]\" value=\"0\" onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value=0;}\" size=\"10\" ><font color=red>This is mandatory field</font>
		</td>
		<td><b>Pur Width:</b> <label class='label label-primary'>$pur_width</label></td>
	</tr>";
echo "<tr><td>Marker LENGTH 2</td><td>:</td><td><input class=\"form-control float\" pattern='^[0-9]+\.?[0-9]*$' title='Please enter numbers and decimals'  type=\"text\" name=\"in_pwidth[]\" value=\"0\" ></td><td><INPUT class=\"form-control float\" pattern='^[0-9]+\.?[0-9]*$' title='Please enter numbers and decimals'  type=\"text\"  name=\"in_mklength[]\" value=\"0\" onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value=0;}\" size=\"10\" ></td></tr>";
echo "<tr><td>Marker LENGTH 3</td><td>:</td><td><input class=\"form-control float\" pattern='^[0-9]+\.?[0-9]*$' title='Please enter numbers and decimals'  type=\"text\" name=\"in_pwidth[]\" value=\"0\" ></td><td><INPUT class=\"form-control float\" pattern='^[0-9]+\.?[0-9]*$' title='Please enter numbers and decimals'  type=\"text\"  name=\"in_mklength[]\" value=\"0\" onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value=0;}\" size=\"10\" ></td></tr>";
echo "<tr><td>Marker LENGTH 4</td><td>:</td><td><input class=\"form-control float\" pattern='^[0-9]+\.?[0-9]*$' title='Please enter numbers and decimals'  type=\"text\" name=\"in_pwidth[]\" value=\"0\" ></td><td><INPUT class=\"form-control float\" pattern='^[0-9]+\.?[0-9]*$' title='Please enter numbers and decimals'  type=\"text\"  name=\"in_mklength[]\" value=\"0\" onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value=0;}\" size=\"10\" ></td></tr>";
echo "<tr><td>Marker LENGTH 5</td><td>:</td><td><input class=\"form-control float\" pattern='^[0-9]+\.?[0-9]*$' title='Please enter numbers and decimals'  type=\"text\"  name=\"in_pwidth[]\" value=\"0\" ></td><td><INPUT class=\"form-control float\" pattern='^[0-9]+\.?[0-9]*$' title='Please enter numbers and decimals'  type=\"text\"  name=\"in_mklength[]\" value=\"0\" onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value=0;}\" size=\"10\" ></td></tr>";
echo "<tr><td>Marker LENGTH 6</td><td>:</td><td><input class=\"form-control float\" pattern='^[0-9]+\.?[0-9]*$' title='Please enter numbers and decimals'  type=\"text\"  name=\"in_pwidth[]\" value=\"0\" ></td><td><INPUT class=\"form-control float\" pattern='^[0-9]+\.?[0-9]*$' title='Please enter numbers and decimals'  type=\"text\"  name=\"in_mklength[]\" value=\"0\" onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value=0;}\" size=\"10\" ></td></tr>";

echo "<tr><td>Marker Efficiency</td>
		  <td>:</td>
		  <td colspan='2'><INPUT class=\"form-control float\" type=\"text\"  id='mk_eff' onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value=0;}\" name=\"in_mkeff\" value=\"0\" size=\"10\" required> 
		  <font color=red>This is mandatory field</font>
		  </td>
	 </tr>";
echo "<tr><td>Marker Version</td><td>:</td>
	  <td colspan='2'><INPUT class=\"form-control alpha\" type=\"text\" name=\"in_mkver\" id='mk_ver' value=\"$patt_ver\" size=\"10\" required>
	  <font color=red>This is mandatory field</font></td>
	  </tr>";

echo "<tr><td>Remarks (Marker File Name): </td><td>:</td><td colspan='2'><INPUT class=\"form-control alpha\" type=\"text\" name=\"remarks\" id='remarks' value=\"Nil\"></td></tr>";
echo "</table></div>";

echo "<input class=\"form-control\" type=\"hidden\" name=\"cat_ref\"  size=2 value=\"".$cat_ref."\">";
echo "<input class=\"form-control\" type=\"hidden\" name=\"cuttable_ref\" size=2 value=\"".$cuttable_ref."\">";
echo "<input class=\"form-control\" type=\"hidden\" name=\"allocate_ref\"  size=2 value=\"".$allocate_ref."\">";
echo "</table>";
//echo "<div class=\"col-md-offset-8\"><input type=\"checkbox\" name=\"option\"  id=\"option\" onclick=\"javascript:enableButton();\">Enable&nbsp;&nbsp;&nbsp;";
echo "<INPUT class=\"btn btn-sm btn-success\" onclick='return verify_null()' type = \"submit\" name = \"update\" value = \"Update\"></div>";
echo "</form>";
echo "</div>";
?> 


<?php

echo "<br/>";

echo "<h2 style=\"padding-left:10px;\"><span class=\"label label-default\" >Reference of Existing Workouts:</span></h2>";


$allo_c=array();
$sql="select * from $bai_pro3.allocate_stat_log where tid=$allocate_ref";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$allo_c[]="xs=".$sql_row['allocate_xs'];
	$allo_c[]="s=".$sql_row['allocate_s'];
	$allo_c[]="m=".$sql_row['allocate_m'];
	$allo_c[]="l=".$sql_row['allocate_l'];
	$allo_c[]="xl=".$sql_row['allocate_xl'];
	$allo_c[]="xxl=".$sql_row['allocate_xxl'];
	$allo_c[]="xxxl=".$sql_row['allocate_xxxl'];
	$allo_c[]="s01=".$sql_row['allocate_s01'];
	$allo_c[]="s02=".$sql_row['allocate_s02'];
	$allo_c[]="s03=".$sql_row['allocate_s03'];
	$allo_c[]="s04=".$sql_row['allocate_s04'];
	$allo_c[]="s05=".$sql_row['allocate_s05'];
	$allo_c[]="s06=".$sql_row['allocate_s06'];
	$allo_c[]="s07=".$sql_row['allocate_s07'];
	$allo_c[]="s08=".$sql_row['allocate_s08'];
	$allo_c[]="s09=".$sql_row['allocate_s09'];
	$allo_c[]="s10=".$sql_row['allocate_s10'];
	$allo_c[]="s11=".$sql_row['allocate_s11'];
	$allo_c[]="s12=".$sql_row['allocate_s12'];
	$allo_c[]="s13=".$sql_row['allocate_s13'];
	$allo_c[]="s14=".$sql_row['allocate_s14'];
	$allo_c[]="s15=".$sql_row['allocate_s15'];
	$allo_c[]="s16=".$sql_row['allocate_s16'];
	$allo_c[]="s17=".$sql_row['allocate_s17'];
	$allo_c[]="s18=".$sql_row['allocate_s18'];
	$allo_c[]="s19=".$sql_row['allocate_s19'];
	$allo_c[]="s20=".$sql_row['allocate_s20'];
	$allo_c[]="s21=".$sql_row['allocate_s21'];
	$allo_c[]="s22=".$sql_row['allocate_s22'];
	$allo_c[]="s23=".$sql_row['allocate_s23'];
	$allo_c[]="s24=".$sql_row['allocate_s24'];
	$allo_c[]="s25=".$sql_row['allocate_s25'];
	$allo_c[]="s26=".$sql_row['allocate_s26'];
	$allo_c[]="s27=".$sql_row['allocate_s27'];
	$allo_c[]="s28=".$sql_row['allocate_s28'];
	$allo_c[]="s29=".$sql_row['allocate_s29'];
	$allo_c[]="s30=".$sql_row['allocate_s30'];
	$allo_c[]="s31=".$sql_row['allocate_s31'];
	$allo_c[]="s32=".$sql_row['allocate_s32'];
	$allo_c[]="s33=".$sql_row['allocate_s33'];
	$allo_c[]="s34=".$sql_row['allocate_s34'];
	$allo_c[]="s35=".$sql_row['allocate_s35'];
	$allo_c[]="s36=".$sql_row['allocate_s36'];
	$allo_c[]="s37=".$sql_row['allocate_s37'];
	$allo_c[]="s38=".$sql_row['allocate_s38'];
	$allo_c[]="s39=".$sql_row['allocate_s39'];
	$allo_c[]="s40=".$sql_row['allocate_s40'];
	$allo_c[]="s41=".$sql_row['allocate_s41'];
	$allo_c[]="s42=".$sql_row['allocate_s42'];
	$allo_c[]="s43=".$sql_row['allocate_s43'];
	$allo_c[]="s44=".$sql_row['allocate_s44'];
	$allo_c[]="s45=".$sql_row['allocate_s45'];
	$allo_c[]="s46=".$sql_row['allocate_s46'];
	$allo_c[]="s47=".$sql_row['allocate_s47'];
	$allo_c[]="s48=".$sql_row['allocate_s48'];
	$allo_c[]="s49=".$sql_row['allocate_s49'];
	$allo_c[]="s50=".$sql_row['allocate_s50'];

}

/*$sql="select max(lastup) as date from bai_pro3.marker_ref_matrix_view where allocate_ref=$allocate_ref";
echo $sql ."<br/>";
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
while($sql_row2=mysql_fetch_array($sql_result))
{
$date1=$sql_row2['date'];
$date2=date("Y-m-d",strtotime($date1));
}*/
//echo "date".$date2;
$table="<div class=\"table-responsive\" style=\"padding-left: 10px;padding-right: 10px;\">
		<table class='table table-bordered'>";
$table.="<thead><tr class='danger'>";
$table.="<th class='column-title' ><center>Marker Width</center></th>";
$table.="<th class='column-title' ><center>Marker Length</center></th>";
$table.="<th class='column-title' ><center>Pattern Version</center></th>";
$table.="<th class='column-title' ><center>Strip Match</center></th>";
$table.="<th class='column-title' ><center>One Gmt One Way</center></th>";
$table.="<th class='column-title' ><center>Marker File Name</center></th>";
$table.="</tr></thead>";


$sql="select * from $bai_pro3.marker_ref_matrix_view where category='$category' and style_code not in('0','') and strip_match=\"$strip_match\" and gmtway=\"$gmtway\" and style_code=\"$style_code\" and date(lastup)>=\"2016-07-01\" and buyer_code=\"$buyer_code\" and title_size_s01=\"$size01\" and title_size_s02=\"$size02\" and title_size_s03=\"$size03\" and title_size_s04=\"$size04\" and title_size_s05=\"$size05\" and title_size_s06=\"$size06\" and title_size_s07=\"$size07\" and title_size_s08=\"$size08\" and title_size_s09=\"$size09\" and title_size_s10=\"$size10\" and title_size_s11=\"$size11\" and title_size_s12=\"$size12\" and title_size_s13=\"$size13\" and title_size_s14=\"$size14\" and title_size_s15=\"$size15\" and title_size_s16=\"$size16\" and title_size_s17=\"$size17\" and title_size_s18=\"$size18\" and title_size_s19=\"$size19\" and title_size_s20=\"$size20\" and title_size_s21=\"$size21\" and title_size_s22=\"$size22\" and title_size_s23=\"$size23\" and title_size_s24=\"$size24\" and title_size_s25=\"$size25\" and title_size_s26=\"$size26\" and title_size_s27=\"$size27\" and title_size_s28=\"$size28\" and title_size_s29=\"$size29\" and title_size_s30=\"$size30\" and title_size_s31=\"$size31\" and title_size_s32=\"$size32\" and title_size_s33=\"$size33\" and title_size_s34=\"$size34\" and title_size_s35=\"$size35\" and title_size_s36=\"$size36\" and title_size_s37=\"$size37\" and title_size_s38=\"$size38\" and title_size_s39=\"$size39\" and title_size_s40=\"$size40\" and title_size_s41=\"$size41\" and title_size_s42=\"$size42\" and title_size_s43=\"$size43\" and title_size_s44=\"$size44\" and title_size_s45=\"$size45\" and title_size_s46=\"$size46\" and title_size_s47=\"$size47\" and title_size_s48=\"$size48\" and title_size_s49=\"$size49\" and title_size_s50=\"$size50\" and title_flag=\"$title_flag\" and ".implode(" and ",$allo_c)." group by concat(marker_width,marker_length,pat_ver,strip_match,gmtway,remarks)";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

if($sql_num_check>0)
{
$sql1="select * from $bai_pro3.marker_ref_matrix_view where category='$category' and style_code not in('0','') and strip_match=\"$strip_match\" and gmtway=\"$gmtway\" and style_code=\"$style_code\" and buyer_code=\"$buyer_code\" and title_size_s01=\"$size01\" and title_size_s02=\"$size02\" and title_size_s03=\"$size03\" and title_size_s04=\"$size04\" and title_size_s05=\"$size05\" and title_size_s06=\"$size06\" and title_size_s07=\"$size07\" and title_size_s08=\"$size08\" and title_size_s09=\"$size09\" and title_size_s10=\"$size10\" and title_size_s11=\"$size11\" and title_size_s12=\"$size12\" and title_size_s13=\"$size13\" and title_size_s14=\"$size14\" and title_size_s15=\"$size15\" and title_size_s16=\"$size16\" and title_size_s17=\"$size17\" and title_size_s18=\"$size18\" and title_size_s19=\"$size19\" and title_size_s20=\"$size20\" and title_size_s21=\"$size21\" and title_size_s22=\"$size22\" and title_size_s23=\"$size23\" and title_size_s24=\"$size24\" and title_size_s25=\"$size25\" and title_size_s26=\"$size26\" and title_size_s27=\"$size27\" and title_size_s28=\"$size28\" and title_size_s29=\"$size29\" and title_size_s30=\"$size30\" and title_size_s31=\"$size31\" and title_size_s32=\"$size32\" and title_size_s33=\"$size33\" and title_size_s34=\"$size34\" and title_size_s35=\"$size35\" and title_size_s36=\"$size36\" and title_size_s37=\"$size37\" and title_size_s38=\"$size38\" and title_size_s39=\"$size39\" and title_size_s40=\"$size40\" and title_size_s41=\"$size41\" and title_size_s42=\"$size42\" and title_size_s43=\"$size43\" and title_size_s44=\"$size44\" and title_size_s45=\"$size45\" and title_size_s46=\"$size46\" and title_size_s47=\"$size47\" and title_size_s48=\"$size48\" and title_size_s49=\"$size49\" and title_size_s50=\"$size50\" and title_flag=\"$title_flag\" and ".implode(" and ",$allo_c)." group by concat(marker_width,marker_length,pat_ver,strip_match,gmtway,remarks)";
}
else
{
$sql1="select * from $bai_pro3.marker_ref_matrix_view where category='$category' and style_code not in('0','') and strip_match=\"$strip_match\" and gmtway=\"$gmtway\" and style_code=\"$style_code\" and buyer_code=\"$buyer_code\" and ".implode(" and ",$allo_c)." group by concat(marker_width,marker_length,pat_ver,strip_match,gmtway,remarks)";
}
//echo $sql1;
$sql_result=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$num_rows=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$table.="<tr><td>".$sql_row['marker_width']."</td><td>".$sql_row['marker_length']."</td><td>".$sql_row['pat_ver']."</td><td>".$sql_row['strip_match']."</td><td>".$sql_row['gmtway']."</td><td>".$sql_row['remarks']."</td></tr>";
}

$table.="</table></div>";

if($num_rows>0)
{
	echo $table;
}else{
	echo "<b style='color:red;padding-left:20px'>None</b>";
}

?>
</div></div>
