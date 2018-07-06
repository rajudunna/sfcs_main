<!--
Change Log: 

kirang/ 2015-02-25/ Service Request #244611 :  Add Remarks Tab in Cut plan (for Sample pieces)
kirang/2016-12-27/ CR: 536: Adding MPO Number in Cut Plan
-->

<div class="panel panel-primary">
<div class="panel-heading">Cut Plan</div>
<div class="panel-body">
<?php
if(isset($_POST['style']))
{
	$style=$_POST['style'];
}
else
{
	$style=$_GET['style'];
}

if(isset($_POST['schedule']))
{
	$schedule=$_POST['schedule'];
}
else
{
	$schedule=$_GET['schedule'];
}

if(isset($_POST['color']))
{
	$color=$_POST['color'];
}
else
{
	$color=$_GET['color'];
}


?>


 <script language="javascript">


var state = 'none';
function showhide(layer_ref) {

if (state == 'block') {
state = 'none';
}
else {
state = 'block';
}
if (document.all) { //IS IE 4 or 5 (or 6 beta)
eval( "document.all." + layer_ref + ".style.display = state");
}
if (document.layers) { //IS NETSCAPE 4 or below
document.layers[layer_ref].display = state;
}
if (document.getElementById &&!document.all) {
hza = document.getElementById(layer_ref);
hza.style.display = state;
}
}

</script>  

<!-- <link href="style.css" rel="stylesheet" type="text/css" />   -->
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',2,'R'));  ?>
<?php //echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/master/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>	


<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/menu_content.php',4,'R')); ?>

<?php

$sql12="select packing_method,style_id from $bai_pro3.bai_orders_db where order_del_no=\"$schedule\"";
$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row12=mysqli_fetch_array($sql_result12))
{
	$packing_method_old=$sql_row12['packing_method'];
	$style_id_old=$sql_row12['style_id'];
}

$sql13="select packing_method,style_id from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and (packing_method='' or style_id='')";
$sql_result13=mysqli_query($link, $sql13) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result13)>0)
{
	while($sql_row13=mysqli_fetch_array($sql_result13))
	{ 
		$packing_method_new=$sql_row13['packing_method'];
		$style_id_new=$sql_row13['style_id'];

		if($packing_method_new=='')
		{
			$sql14="update bai_orders_db_confirm set packing_method=\"$packing_method_old\" where order_del_no=\"$schedule\"";
			mysqli_query($link, $sql14) or exit("Packing Method Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		if($style_id_new=='')
		{
			$sql15="update bai_orders_db_confirm set style_id=\"$style_id_old\" where order_del_no=\"$schedule\"";
			mysqli_query($link, $sql15) or exit("Style ID Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}
}

$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result)>0)
{
	$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";	
}
else
{
	$sql="select * from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";	
}

mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$tran_order_tid=$sql_row['order_tid'];
	$order_date=$sql_row['order_date'];
	$order_div=$sql_row['order_div'];
	$order_po=$sql_row['order_po_no'];
	$color_code=$sql_row['color_code'];
	
	//added this filed for getting carton qty 
	$style_id=$sql_row['style_id'];
	$packing_method=$sql_row['packing_method'];
	$buyer_code=substr($style,0,1);
	$carton_id=$sql_row['carton_id'];
    $destination=$sql_row['destination'];
	$order_del_no=$sql_row['order_del_no'];
	
	$o_s_s01=$sql_row['order_s_s01'];
	$o_s_s02=$sql_row['order_s_s02'];
	$o_s_s03=$sql_row['order_s_s03'];
	$o_s_s04=$sql_row['order_s_s04'];
	$o_s_s05=$sql_row['order_s_s05'];
	$o_s_s06=$sql_row['order_s_s06'];
	$o_s_s07=$sql_row['order_s_s07'];
	$o_s_s08=$sql_row['order_s_s08'];
	$o_s_s09=$sql_row['order_s_s09'];
	$o_s_s10=$sql_row['order_s_s10'];
	$o_s_s11=$sql_row['order_s_s11'];
	$o_s_s12=$sql_row['order_s_s12'];
	$o_s_s13=$sql_row['order_s_s13'];
	$o_s_s14=$sql_row['order_s_s14'];
	$o_s_s15=$sql_row['order_s_s15'];
	$o_s_s16=$sql_row['order_s_s16'];
	$o_s_s17=$sql_row['order_s_s17'];
	$o_s_s18=$sql_row['order_s_s18'];
	$o_s_s19=$sql_row['order_s_s19'];
	$o_s_s20=$sql_row['order_s_s20'];
	$o_s_s21=$sql_row['order_s_s21'];
	$o_s_s22=$sql_row['order_s_s22'];
	$o_s_s23=$sql_row['order_s_s23'];
	$o_s_s24=$sql_row['order_s_s24'];
	$o_s_s25=$sql_row['order_s_s25'];
	$o_s_s26=$sql_row['order_s_s26'];
	$o_s_s27=$sql_row['order_s_s27'];
	$o_s_s28=$sql_row['order_s_s28'];
	$o_s_s29=$sql_row['order_s_s29'];
	$o_s_s30=$sql_row['order_s_s30'];
	$o_s_s31=$sql_row['order_s_s31'];
	$o_s_s32=$sql_row['order_s_s32'];
	$o_s_s33=$sql_row['order_s_s33'];
	$o_s_s34=$sql_row['order_s_s34'];
	$o_s_s35=$sql_row['order_s_s35'];
	$o_s_s36=$sql_row['order_s_s36'];
	$o_s_s37=$sql_row['order_s_s37'];
	$o_s_s38=$sql_row['order_s_s38'];
	$o_s_s39=$sql_row['order_s_s39'];
	$o_s_s40=$sql_row['order_s_s40'];
	$o_s_s41=$sql_row['order_s_s41'];
	$o_s_s42=$sql_row['order_s_s42'];
	$o_s_s43=$sql_row['order_s_s43'];
	$o_s_s44=$sql_row['order_s_s44'];
	$o_s_s45=$sql_row['order_s_s45'];
	$o_s_s46=$sql_row['order_s_s46'];
	$o_s_s47=$sql_row['order_s_s47'];
	$o_s_s48=$sql_row['order_s_s48'];
	$o_s_s49=$sql_row['order_s_s49'];
	$o_s_s50=$sql_row['order_s_s50'];
	for($s=0;$s<sizeof($sizes_code);$s++)
	{
		$o_s[$sizes_code[$s]]=$sql_row["order_s_s".$sizes_code[$s].""];
	}

		$o_total=($o_s_s01+$o_s_s02+$o_s_s03+$o_s_s04+$o_s_s05+$o_s_s06+$o_s_s07+$o_s_s08+$o_s_s09+$o_s_s10+$o_s_s11+$o_s_s12+$o_s_s13+$o_s_s14+$o_s_s15+$o_s_s16+$o_s_s17+$o_s_s18+$o_s_s19+$o_s_s20+$o_s_s21+$o_s_s22+$o_s_s23+$o_s_s24+$o_s_s25+$o_s_s26+$o_s_s27+$o_s_s28+$o_s_s29+$o_s_s30+$o_s_s31+$o_s_s32+$o_s_s33+$o_s_s34+$o_s_s35+$o_s_s36+$o_s_s37+$o_s_s38+$o_s_s39+$o_s_s40+$o_s_s41+$o_s_s42+$o_s_s43+$o_s_s44+$o_s_s45+$o_s_s46+$o_s_s47+$o_s_s48+$o_s_s49+$o_s_s50);
		$order_no=$sql_row['order_no'];
	
		if($order_no>0)
		{
			$n_o_s_s01=$sql_row['old_order_s_s01'];
			$n_o_s_s02=$sql_row['old_order_s_s02'];
			$n_o_s_s03=$sql_row['old_order_s_s03'];
			$n_o_s_s04=$sql_row['old_order_s_s04'];
			$n_o_s_s05=$sql_row['old_order_s_s05'];
			$n_o_s_s06=$sql_row['old_order_s_s06'];
			$n_o_s_s07=$sql_row['old_order_s_s07'];
			$n_o_s_s08=$sql_row['old_order_s_s08'];
			$n_o_s_s09=$sql_row['old_order_s_s09'];
			$n_o_s_s10=$sql_row['old_order_s_s10'];
			$n_o_s_s11=$sql_row['old_order_s_s11'];
			$n_o_s_s12=$sql_row['old_order_s_s12'];
			$n_o_s_s13=$sql_row['old_order_s_s13'];
			$n_o_s_s14=$sql_row['old_order_s_s14'];
			$n_o_s_s15=$sql_row['old_order_s_s15'];
			$n_o_s_s16=$sql_row['old_order_s_s16'];
			$n_o_s_s17=$sql_row['old_order_s_s17'];
			$n_o_s_s18=$sql_row['old_order_s_s18'];
			$n_o_s_s19=$sql_row['old_order_s_s19'];
			$n_o_s_s20=$sql_row['old_order_s_s20'];
			$n_o_s_s21=$sql_row['old_order_s_s21'];
			$n_o_s_s22=$sql_row['old_order_s_s22'];
			$n_o_s_s23=$sql_row['old_order_s_s23'];
			$n_o_s_s24=$sql_row['old_order_s_s24'];
			$n_o_s_s25=$sql_row['old_order_s_s25'];
			$n_o_s_s26=$sql_row['old_order_s_s26'];
			$n_o_s_s27=$sql_row['old_order_s_s27'];
			$n_o_s_s28=$sql_row['old_order_s_s28'];
			$n_o_s_s29=$sql_row['old_order_s_s29'];
			$n_o_s_s30=$sql_row['old_order_s_s30'];
			$n_o_s_s31=$sql_row['old_order_s_s31'];
			$n_o_s_s32=$sql_row['old_order_s_s32'];
			$n_o_s_s33=$sql_row['old_order_s_s33'];
			$n_o_s_s34=$sql_row['old_order_s_s34'];
			$n_o_s_s35=$sql_row['old_order_s_s35'];
			$n_o_s_s36=$sql_row['old_order_s_s36'];
			$n_o_s_s37=$sql_row['old_order_s_s37'];
			$n_o_s_s38=$sql_row['old_order_s_s38'];
			$n_o_s_s39=$sql_row['old_order_s_s39'];
			$n_o_s_s40=$sql_row['old_order_s_s40'];
			$n_o_s_s41=$sql_row['old_order_s_s41'];
			$n_o_s_s42=$sql_row['old_order_s_s42'];
			$n_o_s_s43=$sql_row['old_order_s_s43'];
			$n_o_s_s44=$sql_row['old_order_s_s44'];
			$n_o_s_s45=$sql_row['old_order_s_s45'];
			$n_o_s_s46=$sql_row['old_order_s_s46'];
			$n_o_s_s47=$sql_row['old_order_s_s47'];
			$n_o_s_s48=$sql_row['old_order_s_s48'];
			$n_o_s_s49=$sql_row['old_order_s_s49'];
			$n_o_s_s50=$sql_row['old_order_s_s50'];
			for($s=0;$s<sizeof($sizes_code);$s++)
			{
				$n_s[$sizes_code[$s]]=$sql_row["old_order_s_s".$sizes_code[$s].""];
			}
					
					$n_o_total=($n_o_s_s01+$n_o_s_s02+$n_o_s_s03+$n_o_s_s04+$n_o_s_s05+$n_o_s_s06+$n_o_s_s07+$n_o_s_s08+$n_o_s_s09+$n_o_s_s10+$n_o_s_s11+$n_o_s_s12+$n_o_s_s13+$n_o_s_s14+$n_o_s_s15+$n_o_s_s16+$n_o_s_s17+$n_o_s_s18+$n_o_s_s19+$n_o_s_s20+$n_o_s_s21+$n_o_s_s22+$n_o_s_s23+$n_o_s_s24+$n_o_s_s25+$n_o_s_s26+$n_o_s_s27+$n_o_s_s28+$n_o_s_s29+$n_o_s_s30+$n_o_s_s31+$n_o_s_s32+$n_o_s_s33+$n_o_s_s34+$n_o_s_s35+$n_o_s_s36+$n_o_s_s37+$n_o_s_s38+$n_o_s_s39+$n_o_s_s40+$n_o_s_s41+$n_o_s_s42+$n_o_s_s43+$n_o_s_s44+$n_o_s_s45+$n_o_s_s46+$n_o_s_s47+$n_o_s_s48+$n_o_s_s49+$n_o_s_s50);
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
		
		
		for($s=0;$s<sizeof($sizes_code);$s++)
		{
			if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
			{
				$s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
			}	
		}
		
			
		$flag = $sql_row['title_flag'];
		/* Start  Adding MPO Number  */
		$sql="select MPO from $bai_pro2.shipment_plan_summ where schedule_no=\"$order_del_no\"";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$mp=str_replace("?","",utf8_decode($sql_row['MPO']));
			$mp1=explode("/",$mp);
			$mpo=$mp1[0];
			
		}
		/* end  Adding MPO Number  */

$color_code = chr($color_code);
echo "<div class='panel panel-default'>
<div class='panel-body' >
	<div class='row'>
		<div class='col-md-4'>
		<strong>Date : </strong>$order_date
		</div>
		<div class='col-md-4'>
		<strong>Division : </strong>$order_div
		</div>
		<div class='col-md-4'>
		<strong>PO : </strong>$order_po
		</div>
	</div>
	<br/>
	<div class='row'>
		<div class='col-md-4'>
		<strong>Style : </strong>$style
		</div>
		<div class='col-md-4'>
		<strong>Schedule : </strong>$schedule$color_code
		</div>
		<div class='col-md-4'>
		<strong>Color : </strong>$color
		</div>
	</div>
	<br/>
	<div class='row'>
		<div class='col-md-4'>
		<strong>Destination : </strong>$destination
		</div>
		<div class='col-md-4'>
		<strong>MPO : </strong>$mpo
		</div>
	</div>
	<br/>
	<div class='row'>
		
			<div class='col-md-4'>
			<strong>Binding Consumption : </strong>";
				include("main_interface_remarks.php");
				echo "</div><div class='col-md-4'><b>Remarks: </b>$remarks_y</div>
			    <div class='col-md-4'><b>Binding Consumption: </b>$bind_con</div>";
			echo "
		
	</div><hr/>
";
$order_qty_update_url = getFullUrlLevel($_GET['r'],'planning/controllers/orders_edit_form.php','3','N');
echo "<div class=\"table-responsive\">";

if($order_no == 0){
	echo "<b style='color:red'>Note :  Extra Shipment details were no not updated for the above 'STYLE-$style, SCHEDULE-$schedule, COLOR-$color'</b><br>
	<span>Go to </span><a href='$order_qty_update_url' class='btn btn-xs btn-info'> Order Quantity Update</a>";
}else if($order_no ==1){
	echo "<b style='color:#22dd10'>Note : Extra Shipment details are updated for the above 'STYLE-$style, SCHEDULE-$schedule, COLOR-$color'</b>";
}

echo "<table class=\"table table-bordered\">";

if($flag==1)
{
	
	echo "<thead><tr><th class=\"column-title\" style='width:190px;'>Sizes</th>";
	for($s=0;$s<sizeof($s_tit);$s++)
	{
		//$s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
			
		//if($s_tit[$sizes_code[$s]]<>'')
		//{
			echo "<th class=\"column-title\">".$s_tit[$sizes_code[$s]]."</th>";
		//}	
	}
	echo "<th class=\"title\">Total</th>";
	echo "</tr></thead>";
}

$label = 'Original Quantity';
if($order_no>0)
{
	echo "<tr ><th class=\"heading2\">Original Qty</th>";
	for($s=0;$s<sizeof($s_tit);$s++)
	{
		//$s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
		//if($n_s[$sizes_code[$s]]>0)
		//{
			echo "<td class=\"sizes\">".$n_s[$sizes_code[$s]]."</td>";
		//}	
	}
	$label = 'Revised Quantity';
	echo "<td class=\"sizes\">".$n_o_total."</td></tr>";
}

	echo "<tr ><th class=\"heading2\">$label</th>";
	for($s=0;$s<sizeof($s_tit);$s++)
	{
		//$s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
		//if($o_s[$sizes_code[$s]]>0)
		//{
			echo "<td class=\"sizes\">".$o_s[$sizes_code[$s]]."</td>";
		//}	
	}
	
	
echo "<td class=\"sizes\">".$o_total."</td></tr>";
echo "</table>";
echo "</div></div></div>";

//echo "<input type=\"checkbox\" name=\"option\"  id=\"option\" onclick=\"javascript:enableButton();\">Enable";
//echo "<INPUT TYPE = \"Submit\" Name = \"Update\" VALUE = \"Update\">";
//echo "</form>";
}

?>

<!--p><a href="#" onclick="showhide('div10');">Carton Qty</a></p>
<div id="div10" style="display: none;"> 
<?php include("carton_qty.php"); ?>
</div> 
-->
<!-- <p>Remarks: 
<?php //include("main_interface_remarks.php"); ?>
</p> -->

	<!-- <div class="col-sm-12">
		<div class = "panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" href="#remarks"><strong>Remarks</strong></a>
				</h4>
				<div id="remarks" class="panel-collapse collapse-in">
					<div class="panel-body">
					<?php //include("main_interface_remarks.php"); ?>
					</div>
				</div>
			</div>
		</div> -->

<!--
<p><a href="#" onclick="showhide('div1');">Join Orders</a></p>
<div id="div1" style="display: none;"> 
<?php //include("main_interface_1.php"); ?>
</div> 
-->
<!-- <p><a href="#" >Category</a></p> -->
<!--<div id="div2" style="display: none;">
<?php //include("main_interface_2.php"); ?>
</div> -->

<!-- carton quantities added -->
<div class='col-sm-12' class='table-responsive'>
	<div id='#carton' class='panel panel-default'>
		<div class='panel-heading' style='text-align:center;'>
			<a data-toggle="collapse"><strong><b>Carton Quantity</b></strong></a>
		</div>
		<div class='panel-body'>
			<table class='table table-bordered table-responsive'>
					<tr><th>User Def. Style</th>
						
						<th>Pack Method</th>
			<?php
			//var_dump($s_tit);
	//getting the dynamic sizes from top $s_tit array
			$sql="select * from $bai_pro3.carton_qty_chart where user_style='$style_id' and user_schedule='$schedule' and status=0";
			//echo $sql;
			$th_count = 0;
			$sql_result=mysqli_query($link,$sql) or exit("Sql Error getting carton quantities".mysql_error());
			while($row = mysqli_fetch_array($sql_result)){

				foreach($sizes_array as $key=>$value){
					if($row["$value"] > 0){
						$s = substr($value,1);
						if($th_count == 0)
							echo "<th>$s_tit[$s]</th>";
						$csizes[$value] = $row[$value]; 
					}
				}
				$cstyle = $row['user_style'];
				//$cbuyer = $row['buyer'];
				$cpakcmethod = $row['packing_method'];
				$cremarks = $row['remarks'];
				if($th_count==0){
					echo "<th>Remarks</th>
					</tr>";
					$th_count++;
				}
				echo "<tr><td>$cstyle</td>
						
						<td>$cpakcmethod</td>";
				foreach($sizes_array as $key=>$value){
					if($csizes[$value] > 0){
						echo "<td>$csizes[$value]</td>";
					}
				}//or the below
				// foreach($csizes as $key=>$value){
				// 	echo "<td>$value</td>";
				// }
				echo "	  <td>$remarks</td>
					</tr>";
			}
			?>
			</table>
		</div>
	</div>
</div>

<div class="col-md-12 row">
<div class = "panel panel-default">
	<div class="panel-heading" style='text-align:center;'>
		
		<a data-toggle="collapse" href="#Category"><strong><b>Category</b></strong></a>
		</div>
		<div id="Category" class="panel-collapse collapse-in collapse in" aria-expanded="true">
			<div class="panel-body">
			<div class="table-responsive">
<?php

/*
Change log: 

2017-06-11/Dharani: enable the validation to avoid the category change after docket generation 


*/
//echo $tran_order_tid;
//$tran_order_tid1=str_replace(' ', '', $tran_order_tid);
$sql="select * from $bai_pro3.cat_stat_log where order_tid=trim('$tran_order_tid') order by catyy DESC";
//echo $sql."</br>test";

//$sql="select * from cat_stat_log where order_tid like \"% ".$schedule."%\" order by catyy DESC";
//echo $host;
//mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
if ($sql_result) {
     if (mysqli_num_rows($sql_result) == 0) {
        //echo "// do one thing";
     }
     else {
        //echo mysql_num_rows($sql_result);
		//          <th class=\"column-title\"><center>Strip Match</th>
		//			<th class=\"column-title\"><center>Gusset Seperation</th>
		//			<th class=\"column-title\"><center>One GMT One Way</th>
				echo "<table class=\"table table-bordered\"><thead><tr class=\"\">
					<th class=\"column-title\"><center>Date</th>
					<th class=\"column-title\"><center>Category</th>
					<th class=\"column-title\"><center>CAT YY</th>
					<th class=\"column-title\"><center>Color Code</th>
					<th class=\"column-title\"><center>Fabric Code</th>
					<th class=\"column-title\" style='word-wrap: break-word;'><center>Fabric Description</th>
					<th class=\"column-title\"><center>Pur Width</th>
				
					
					<th class=\"column-title\"><center>Pattern Version</th>
					<th class=\"column-title\"><center>MO status</th>
					<th class=\"column-title\"><center>Controls</th>
				</tr></thead>";
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$date_cat = $sql_row['date'];
			if($date_cat == '0000-00-00'){
				$date_cat = '-';
			}
			echo "<tr class=\"  \">";
			//echo "<td class=\"  \"><center>".$sql_row['tid']."</center></td>";
			echo "<td class=\"  \"><center>".$date_cat."</center></td>";
			echo "<td class=\"  \"><center>".$sql_row['category']."</center></td>";
			echo "<td class=\"  \"><center>".$sql_row['catyy']."</center></td>";
			echo "<td class=\"  \"><center>".$sql_row['col_des']."</center></td>";
			echo "<td class=\"  \"><center>".$sql_row['compo_no']."</center></td>";
			echo "<td class=\"  \" style='word-wrap: break-word;'><center>".$sql_row['fab_des']."</center></td>";
			echo "<td class=\"  \"><center>".$sql_row['purwidth']."</center></td>";
			//echo $sql_row['tid']."</br>";
	//		if($sql_row['gmtway']=="Y") { echo "<td class=\"  \" align='center'><span class='label label-success'>YES</span></td>"; } else { echo "<td class=\"  \" align='center'><span class='label label-danger'>NO</span></td>";	}

	//		if($sql_row['strip_match']=="Y") { echo "<td class=\"  \"  align='center'><span class='label label-success'>YES</span></td>"; } else { echo "<td class=\"  \" align='center'><span class='label label-danger'>NO</span></td>";	}

	//		if($sql_row['gusset_sep']=="Y") { echo "<td class=\"  \"  align='center'><span class='label label-success'>YES</span></td>"; } else { echo "<td class=\"  \" align='center'><span class='label label-danger'>NO</span></td>";	}

			echo "<td class=\"  \"><center>".$sql_row['patt_ver']."</center></td>";
			
				if($sql_row['mo_status']=="Y") { echo "<td class=\"b1\" align='center'><span class='label label-success'>YES</span></td>"; } else { echo "<td class=\"b1\" align='center'><span class='label label-danger'>NO</span></td>";	}


			//	echo "<td class=\"b1\">".$sql_row['remarks']."</td>";
			// start enable the validation to avoid the category change after docket generation
			$sql5="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$tran_order_tid\"";
			//echo $sql;
			$sql_result5=mysqli_query($link, $sql5) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result5);

			if($sql_num_check==0)
			{
				//echo "<td class=\"  \"><center><a class=\"btn btn-sm btn-primary\" href=\"".getFullURL($_GET['r'], "dumindu/order_cat_edit_form.php", "N")."&cat_tid=".$sql_row['tid']."&style=".$style."&schedule=".$schedule."&color=".$color."\">c</a></center></td>";
				echo "<td><center><a class='btn btn-info btn-xs' href='".getFullURL($_GET['r'], "order_cat_edit_form.php", "N")."&cat_tid=".$sql_row['tid']."&style=".$style."&schedule=".$schedule."&color=".$color."'>Edit</a></center>";
			}
			else
			{
				echo "<td class=\"  \"><center>N/A</center></td>";
			}
			// end enable the validation to avoid the category change after docket generation
			echo "</tr>";
		}
     }
}
//echo "<table class=\"b1\"><tr class=\"b1\"><th class=\"heading2\">TID</th><th class=\"b1\">Date</th><th class=\"b1\">Category</th><th class=\"b1\">CAT YY</th><th class=\"b1\">Color Code</th><th class=\"b1\">Fab Code</th><th class=\"b1\">Fabric Description</th><th class=\"b1\">Pur Width</th><th class=\"b1\">One GMT One Way</th><th class=\"b1\">Strip Match</th><th class=\"b1\">Gusset Sep</th><th class=\"b1\">Pat. Ver.</th><th class=\"b1\">MO stat</th><th class=\"b1\">Controls</th></tr>";
/* if($sql_num_check>0){
	//echo $sql."</br>";
	while($sql_row=mysql_fetch_array($sql_result))
	{
		echo "<tr class=\"b1\">";
		echo "<td class=\"b1\">".$sql_row['tid']."</td>";
		echo "<td class=\"b1\">".$sql_row['date']."</td>";
		echo "<td class=\"b1\">".$sql_row['category']."</td>";
		echo "<td class=\"b1\">".$sql_row['catyy']."</td>";
		echo "<td class=\"b1\">".$sql_row['col_des']."</td>";
		echo "<td class=\"b1\">".$sql_row['compo_no']."</td>";
		echo "<td class=\"b1\">".$sql_row['fab_des']."</td>";
		echo "<td class=\"b1\">".$sql_row['purwidth']."</td>";
		//echo $sql_row['tid']."</br>";
		if($sql_row['gmtway']=="Y") { echo "<td class=\"b1\"><font color=GREEN><strong>YES</strong></td>"; } else { echo "<td class=\"b1\"><font color=RED><strong>NO</strong></td>";	}

		if($sql_row['strip_match']=="Y") { echo "<td class=\"b1\"><font color=GREEN><strong>YES</strong></td>"; } else { echo "<td class=\"b1\"><font color=RED><strong>NO</strong></td>";	}

		if($sql_row['gusset_sep']=="Y") { echo "<td class=\"b1\"><font color=GREEN><strong>YES</strong></td>"; } else { echo "<td class=\"b1\"><font color=RED><strong>NO</strong></td>";	}



		echo "<td class=\"b1\">".$sql_row['patt_ver']."</td>";
		
			if($sql_row['mo_status']=="Y") { echo "<td class=\"b1\"><font color=GREEN><strong>YES</strong></td>"; } else { echo "<td class=\"b1\"><font color=RED><strong>NO</strong></td>";	}


		//	echo "<td class=\"b1\">".$sql_row['remarks']."</td>";
		// start enable the validation to avoid the category change after docket generation
		$sql5="select * from plandoc_stat_log where order_tid=\"$tran_order_tid\"";
		//echo $sql;
		$sql_result5=mysql_query($sql5,$link) or exit("Sql Error".mysql_error());
		$sql_num_check=mysql_num_rows($sql_result5);

		if($sql_num_check==0)
		{
			echo "<td class=\"b1\"><a href=\"dumindu/order_cat_edit_form.php?cat_tid=".$sql_row['tid']."&style=".$style."&schedule=".$schedule."&color=".$color."\">Edit</a></td>";
		}
		else
		{
			echo "<td class=\"b1\">N/A</td>";
		}
		// end enable the validation to avoid the category change after docket generation
		echo "</tr>";

	}
	echo "<table class=\"b1\"><tr class=\"heading2\"><th class=\"heading2\" style='background-color:#29759C;color:white;'>TID</th><th class=\"heading2\" style='background-color:#29759C;color:white;'>Date</th><th class=\"heading2\" style='background-color:#29759C;color:white;'>Category</th><th class=\"heading2\" style='background-color:#29759C;color:white;'>Order YY</th><th class=\"heading2\" style='background-color:#29759C;color:white;'>Color Code</th><th class=\"heading2\" style='background-color:#29759C;color:white;'>Fab Code</th><th class=\"heading2\" style='background-color:#29759C;color:white;'>Fabric Description</th><th class=\"heading2\" style='background-color:#29759C;color:white;'>Pur Width</th><th class=\"heading2\" style='background-color:#29759C;color:white;'>One GMT One Way</th><th class=\"heading2\" style='background-color:#29759C;color:white;'>Strip Match</th><th class=\"heading2\" style='background-color:#29759C;color:white;'>Gusset Sep</th><th class=\"heading2\" style='background-color:#29759C;color:white;'>Pat. Ver.</th><th class=\"heading2\" style='background-color:#29759C;color:white;'>MO stat</th><th class=\"heading2\" style='background-color:#29759C;color:white;'>Controls</th></tr>";
}else{
	echo "</br>Catogory not found";
}


 */
echo "</table></div>
</div>
</div></div></div>";

?>
<!-- <p><a href="#" >Cuttable</a></p> -->
<!--<div id="div3" style="display: none;">
<?php //include("main_interface_3.php"); ?>
</div>-->
		<div class="col-md-12 row"><div class="panel panel-default">
			<div class="panel-heading" style="text-align:center;">
				
					<a data-toggle="collapse" href="#Cuttable"><strong><b>Cuttable</b></strong></a>
				</div>
				<div id="Cuttable" class="panel-collapse collapse-in collapse in" aria-expanded="true">
					<div class="panel-body">
						
<?php

$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\"";
//echo $sql."</br>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result)>0)
{
	$ord_tbl_name="$bai_pro3.bai_orders_db_confirm";	
}
else
{
	$ord_tbl_name="$bai_pro3.bai_orders_db";		
}

$sql="select * from $ord_tbl_name where order_tid=\"$tran_order_tid\"";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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

	
}
$sql="select * from $bai_pro3.cat_stat_log where order_tid=trim('$tran_order_tid') order by catyy DESC";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

echo "<div class=\"table-responsive\"><table class=\"table table-bordered\">
<thead><tr><th class=\"column-title\"><center>Date</center></th><th class=\"column-title\"><center>Category</center></th><th class=\"column-title\"><center>One GMT One Way</center></th><th class=\"column-title\"><center>STATUS</center></th><th class=\"column-title\"><center>Controls</center></th></tr></thead>";
while($sql_row=mysqli_fetch_array($sql_result))
{
	
$check2=0;
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
	
if($s01<$order_s01){$check2=1;}
if($s02<$order_s02){$check2=1;}
if($s03<$order_s03){$check2=1;}
if($s04<$order_s04){$check2=1;}
if($s05<$order_s05){$check2=1;}
if($s06<$order_s06){$check2=1;}
if($s07<$order_s07){$check2=1;}
if($s08<$order_s08){$check2=1;}
if($s09<$order_s09){$check2=1;}
if($s10<$order_s10){$check2=1;}
if($s11<$order_s11){$check2=1;}
if($s12<$order_s12){$check2=1;}
if($s13<$order_s13){$check2=1;}
if($s14<$order_s14){$check2=1;}
if($s15<$order_s15){$check2=1;}
if($s16<$order_s16){$check2=1;}
if($s17<$order_s17){$check2=1;}
if($s18<$order_s18){$check2=1;}
if($s19<$order_s19){$check2=1;}
if($s20<$order_s20){$check2=1;}
if($s21<$order_s21){$check2=1;}
if($s22<$order_s22){$check2=1;}
if($s23<$order_s23){$check2=1;}
if($s24<$order_s24){$check2=1;}
if($s25<$order_s25){$check2=1;}
if($s26<$order_s26){$check2=1;}
if($s27<$order_s27){$check2=1;}
if($s28<$order_s28){$check2=1;}
if($s29<$order_s29){$check2=1;}
if($s30<$order_s30){$check2=1;}
if($s31<$order_s31){$check2=1;}
if($s32<$order_s32){$check2=1;}
if($s33<$order_s33){$check2=1;}
if($s34<$order_s34){$check2=1;}
if($s35<$order_s35){$check2=1;}
if($s36<$order_s36){$check2=1;}
if($s37<$order_s37){$check2=1;}
if($s38<$order_s38){$check2=1;}
if($s39<$order_s39){$check2=1;}
if($s40<$order_s40){$check2=1;}
if($s41<$order_s41){$check2=1;}
if($s42<$order_s42){$check2=1;}
if($s43<$order_s43){$check2=1;}
if($s44<$order_s44){$check2=1;}
if($s45<$order_s45){$check2=1;}
if($s46<$order_s46){$check2=1;}
if($s47<$order_s47){$check2=1;}
if($s48<$order_s48){$check2=1;}
if($s49<$order_s49){$check2=1;}
if($s50<$order_s50){$check2=1;}


	
}

//$color="correct.png";
$icon = '<i class="fa fa-check-circle"></i>';
$color1 = "success";

if($check2==1)
{
	//$color="wrong.png";
	$icon = '<i class="fa fa-times-circle"></i>';
	$color1 = "danger";
}
	

	$check_id=$sql_row['tid'];

	echo "<tr class=\"  \">";
//	echo "<td class=\"  \"><center>".$sql_row['tid']."</center></td>";
	echo "<td class=\"  \"><center>".$sql_row['date']."</center></td>";
	
	echo "<td class=\"  \"><center>".$sql_row['category']."</center></td>";
	//echo "<td>".$sql_row['catyy']."</td>";
	//echo "<td>".$sql_row['fab_des']."</td>";
	//echo "<td>".$sql_row['purwidth']."</td>";
	if($sql_row['gmtway']=="Y") 
	{ echo "<td class=\"  \"  align='center'><span class='label label-success'>YES</span></td>"; 
    } 
	else 
	{ 
    echo "<td class=\"  \"  align='center'><span class='label label-danger'>NO</span></td>";	
	}
	//echo "<td class=\"b1\">".$sql_row['gmtway']."</td>";

	echo "<td class=\"  \" align='center'><span class='label label-$color1'>".$icon."</span></td>";
	//echo "<td>".$sql_row['remarks']."</td>";
	if($color1 == "success"){
		echo "<td class=\"  \" align='center'><span class='label label-success'>Updated</span></td>";
	}
	else{
	
		echo "<td class=\"  \"><center><a class=\"btn btn-xs btn-info\" href=\"".getFullURL($_GET['r'], "order_cut_form2.php", "N")."&tran_order_tid=$tran_order_tid&check_id=$check_id&style=$style&schedule=$schedule&color=$color\">Update</a></center></td>";
	}
	//echo "<td class=\"b1\"><a href=\"dumindu/order_cut_form2.php?tran_order_tid=$tran_order_tid&check_id=$check_id\">Update</a></td>";
	echo "</tr>";
}
echo "</table></div>
</div>
</div>
</div>
</div>";

?>

<!-- <p><a href="#" >Allocation</a></p> -->

<div class="row col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading" style="text-align:center;">
				
					<a data-toggle="collapse" href="#Allocation"><strong><b>Allocation</b></strong></a>
				</div>
				<div id="Allocation" class="panel-collapse collapse-in collapse in" aria-expanded="true">
					<div class="panel-body">

	<?php


/* NEW */

$sql="select * from $bai_pro3.cuttable_stat_log where order_tid=\"$tran_order_tid\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<div class=\"table-responsive\"><table class=\"table table-bordered\">
	  <thead><tr>
			<th class=\"column-title\"><center>Category</center></th><th class=\"column-title\"><center>Cuttable</center></th>
			<th class=\"column-title\"><center>Allocated</center></center></th><th class=\"column-title\"><center>Excess /Shortage </center></th>
			
			<th class=\"column-title\"><center>Controls</center></th></tr></thead>";

while($sql_row=mysqli_fetch_array($sql_result))
{
	$cuttable_sum=0;
	$total_allocated=0;
	$tid=$sql_row['tid'];
	$cat_id=$sql_row['cat_id'];
		$cuttable_s01=$sql_row['cuttable_s_s01'];
		$cuttable_s02=$sql_row['cuttable_s_s02'];
		$cuttable_s03=$sql_row['cuttable_s_s03'];
		$cuttable_s04=$sql_row['cuttable_s_s04'];
		$cuttable_s05=$sql_row['cuttable_s_s05'];
		$cuttable_s06=$sql_row['cuttable_s_s06'];
		$cuttable_s07=$sql_row['cuttable_s_s07'];
		$cuttable_s08=$sql_row['cuttable_s_s08'];
		$cuttable_s09=$sql_row['cuttable_s_s09'];
		$cuttable_s10=$sql_row['cuttable_s_s10'];
		$cuttable_s11=$sql_row['cuttable_s_s11'];
		$cuttable_s12=$sql_row['cuttable_s_s12'];
		$cuttable_s13=$sql_row['cuttable_s_s13'];
		$cuttable_s14=$sql_row['cuttable_s_s14'];
		$cuttable_s15=$sql_row['cuttable_s_s15'];
		$cuttable_s16=$sql_row['cuttable_s_s16'];
		$cuttable_s17=$sql_row['cuttable_s_s17'];
		$cuttable_s18=$sql_row['cuttable_s_s18'];
		$cuttable_s19=$sql_row['cuttable_s_s19'];
		$cuttable_s20=$sql_row['cuttable_s_s20'];
		$cuttable_s21=$sql_row['cuttable_s_s21'];
		$cuttable_s22=$sql_row['cuttable_s_s22'];
		$cuttable_s23=$sql_row['cuttable_s_s23'];
		$cuttable_s24=$sql_row['cuttable_s_s24'];
		$cuttable_s25=$sql_row['cuttable_s_s25'];
		$cuttable_s26=$sql_row['cuttable_s_s26'];
		$cuttable_s27=$sql_row['cuttable_s_s27'];
		$cuttable_s28=$sql_row['cuttable_s_s28'];
		$cuttable_s29=$sql_row['cuttable_s_s29'];
		$cuttable_s30=$sql_row['cuttable_s_s30'];
		$cuttable_s31=$sql_row['cuttable_s_s31'];
		$cuttable_s32=$sql_row['cuttable_s_s32'];
		$cuttable_s33=$sql_row['cuttable_s_s33'];
		$cuttable_s34=$sql_row['cuttable_s_s34'];
		$cuttable_s35=$sql_row['cuttable_s_s35'];
		$cuttable_s36=$sql_row['cuttable_s_s36'];
		$cuttable_s37=$sql_row['cuttable_s_s37'];
		$cuttable_s38=$sql_row['cuttable_s_s38'];
		$cuttable_s39=$sql_row['cuttable_s_s39'];
		$cuttable_s40=$sql_row['cuttable_s_s40'];
		$cuttable_s41=$sql_row['cuttable_s_s41'];
		$cuttable_s42=$sql_row['cuttable_s_s42'];
		$cuttable_s43=$sql_row['cuttable_s_s43'];
		$cuttable_s44=$sql_row['cuttable_s_s44'];
		$cuttable_s45=$sql_row['cuttable_s_s45'];
		$cuttable_s46=$sql_row['cuttable_s_s46'];
		$cuttable_s47=$sql_row['cuttable_s_s47'];
		$cuttable_s48=$sql_row['cuttable_s_s48'];
		$cuttable_s49=$sql_row['cuttable_s_s49'];
		$cuttable_s50=$sql_row['cuttable_s_s50'];

	
	
	$cuttable_ref=$sql_row['tid'];
	
	$cuttable_sum=$cuttable_s01+$cuttable_s02+$cuttable_s03+$cuttable_s04+$cuttable_s05+$cuttable_s06+$cuttable_s07+$cuttable_s08+$cuttable_s09+$cuttable_s10+$cuttable_s11+$cuttable_s12+$cuttable_s13+$cuttable_s14+$cuttable_s15+$cuttable_s16+$cuttable_s17+$cuttable_s18+$cuttable_s19+$cuttable_s20+$cuttable_s21+$cuttable_s22+$cuttable_s23+$cuttable_s24+$cuttable_s25+$cuttable_s26+$cuttable_s27+$cuttable_s28+$cuttable_s29+$cuttable_s30+$cuttable_s31+$cuttable_s32+$cuttable_s33+$cuttable_s34+$cuttable_s35+$cuttable_s36+$cuttable_s37+$cuttable_s38+$cuttable_s39+$cuttable_s40+$cuttable_s41+$cuttable_s42+$cuttable_s43+$cuttable_s44+$cuttable_s45+$cuttable_s46+$cuttable_s47+$cuttable_s48+$cuttable_s49+$cuttable_s50;

	$sql2="select ((allocate_s01+allocate_s02+allocate_s03+allocate_s04+allocate_s05+allocate_s06+allocate_s07+allocate_s08+allocate_s09+allocate_s10+allocate_s11+allocate_s12+allocate_s13+allocate_s14+allocate_s15+allocate_s16+allocate_s17+allocate_s18+allocate_s19+allocate_s20+allocate_s21+allocate_s22+allocate_s23+allocate_s24+allocate_s25+allocate_s26+allocate_s27+allocate_s28+allocate_s29+allocate_s30+allocate_s31+allocate_s32+allocate_s33+allocate_s34+allocate_s35+allocate_s36+allocate_s37+allocate_s38+allocate_s39+allocate_s40+allocate_s41+allocate_s42+allocate_s43+allocate_s44+allocate_s45+allocate_s46+allocate_s47+allocate_s48+allocate_s49+allocate_s50)*plies) as \"total\" from $bai_pro3.allocate_stat_log left join cat_stat_log on  allocate_stat_log.order_tid=cat_stat_log.order_tid where allocate_stat_log.order_tid=\"$tran_order_tid\" and allocate_stat_log.cuttable_ref='$cuttable_ref' and cat_stat_log.category in ($in_categories)";
	//echo $sql2."<br>";	
	// mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check2=mysqli_num_rows($sql_result2);
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$total_allocated=$total_allocated+$sql_row2['total'];
	}

	echo "<tr>";
	//echo "<td class=\"  \"><center>".$sql_row['tid']."</center></td>";
	//echo "<td class=\"  \"><center>".$sql_row['cat_id']."</center></td>";
	
	$cat_id_new=$sql_row['cat_id'];
	
	$sql2="select * from $bai_pro3.cat_stat_log where tid=$cat_id order by catyy DESC";
	// mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$category_new=$sql_row2['category'];
	}
	
	echo "<td class=\"  \"><center>".$category_new."</center></td>";
	echo "<td class=\"  \"><center>".$cuttable_sum."</center></td>";
	echo "<td class=\"  \"><center>".$total_allocated."</center></td>";
	$total_cuttable_qty=$total_allocated-$cuttable_sum;
	if(($total_allocated-$cuttable_sum)<0)
	{
		echo "<td class=\"  \" style='background-color:#f8d7da'><center>".($total_allocated-$cuttable_sum)."</center></td>";
	}
	else
	{
		echo "<td class=\"b1\" style='background-color:#4cff4c'><center>".($total_allocated-$cuttable_sum)."</center></td>";

	}
	/* STATUS FIELD COMMENTED
	if(($total_allocated-$cuttable_sum)<0)
	{
		echo "<td class=\"  \"><center><span class='label label-danger'>Not Updated</i></span></center></td>";
	}
	else
	{
		echo "<td class=\"  \"><center><span class='label label-success'><i class=\"fa fa-check-circle\"></i></span></center></td>";
	}
	*/
	/* if(($total_allocated-$cuttable_sum)<0)
	{
		echo "<td class=\"b1\"><a href=\"dumindu/order_allocation_form2.php?tran_order_tid=$tran_order_tid&check_id=$cuttable_ref&cat_id=$cat_id\">Update</a></td>";
	}
	else
	{
		echo "<td class=\"b1\"><a href=\"dumindu/order_allocation_form2.php?tran_order_tid=$tran_order_tid&check_id=$cuttable_ref&cat_id=$cat_id\"  onclick='".'alert("Cuttable Quantity Fullfilled")'."'>Update</a></td>";
	} */
	echo "<td class=\"  \"><center><a class=\"btn btn-xs btn-info\" href=\"".getFullURL($_GET['r'], "order_allocation_form2.php", "N")."&tran_order_tid=$tran_order_tid&check_id=$cuttable_ref&cat_id=$cat_id&total_cuttable_qty=$total_cuttable_qty\">Add Ratios</a></center></td>";
	echo "</tr>";
}
echo "</table></div></div>
</div>
</div>
</div>";
?>



<!-- <p><a href="#" >Ratios</a></p> -->

	<div class="row col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading" style="text-align:center;">
				
					<a data-toggle="collapse" href="#Ratios"><strong><b>Ratios</b></strong></a>
				</div>
				<div id="Ratios" class="panel-collapse collapse-in collapse in" aria-expanded="true">
					<div class="panel-body">
<?php

$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result)>0)
{
	$ord_tbl_name="$bai_pro3.bai_orders_db_confirm";	
}
else{
	$ord_tbl_name="$bai_pro3.bai_orders_db";		
}

$sql1="select * from $ord_tbl_name where order_tid=\"$tran_order_tid\"";
$sql_result=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result))
{
	
for($s=0;$s<sizeof($sizes_code);$s++)
{
	if($sql_row1["title_size_s".$sizes_code[$s].""]<>'')
	{
		$s_tit[$sizes_code[$s]]=$sql_row1["title_size_s".$sizes_code[$s].""];
		//echo $s_tit[$sizes_code[$s]]."<br>";
	}	
}
for($s=0;$s<sizeof($sizes_code);$s++)
{
	//if($sql_row["order_s".$sizes_code[$s].""]<>'')
	//{
		$s_ord[$s]=$sql_row1["order_s_s".$sizes_code[$s].""];
		//echo $s_tit[$sizes_code[$s]]."<br>";
	//}	
}
$size01 = $sql_row1['title_size_s01'];
$size02 = $sql_row1['title_size_s02'];
$size03 = $sql_row1['title_size_s03'];
$size04 = $sql_row1['title_size_s04'];
$size05 = $sql_row1['title_size_s05'];
$size06 = $sql_row1['title_size_s06'];
$size07 = $sql_row1['title_size_s07'];
$size08 = $sql_row1['title_size_s08'];
$size09 = $sql_row1['title_size_s09'];
$size10 = $sql_row1['title_size_s10'];
$size11 = $sql_row1['title_size_s11'];
$size12 = $sql_row1['title_size_s12'];
$size13 = $sql_row1['title_size_s13'];
$size14 = $sql_row1['title_size_s14'];
$size15 = $sql_row1['title_size_s15'];
$size16 = $sql_row1['title_size_s16'];
$size17 = $sql_row1['title_size_s17'];
$size18 = $sql_row1['title_size_s18'];
$size19 = $sql_row1['title_size_s19'];
$size20 = $sql_row1['title_size_s20'];
$size21 = $sql_row1['title_size_s21'];
$size22 = $sql_row1['title_size_s22'];
$size23 = $sql_row1['title_size_s23'];
$size24 = $sql_row1['title_size_s24'];
$size25 = $sql_row1['title_size_s25'];
$size26 = $sql_row1['title_size_s26'];
$size27 = $sql_row1['title_size_s27'];
$size28 = $sql_row1['title_size_s28'];
$size29 = $sql_row1['title_size_s29'];
$size30 = $sql_row1['title_size_s30'];
$size31 = $sql_row1['title_size_s31'];
$size32 = $sql_row1['title_size_s32'];
$size33 = $sql_row1['title_size_s33'];
$size34 = $sql_row1['title_size_s34'];
$size35 = $sql_row1['title_size_s35'];
$size36 = $sql_row1['title_size_s36'];
$size37 = $sql_row1['title_size_s37'];
$size38 = $sql_row1['title_size_s38'];
$size39 = $sql_row1['title_size_s39'];
$size40 = $sql_row1['title_size_s40'];
$size41 = $sql_row1['title_size_s41'];
$size42 = $sql_row1['title_size_s42'];
$size43 = $sql_row1['title_size_s43'];
$size44 = $sql_row1['title_size_s44'];
$size45 = $sql_row1['title_size_s45'];
$size46 = $sql_row1['title_size_s46'];
$size47 = $sql_row1['title_size_s47'];
$size48 = $sql_row1['title_size_s48'];
$size49 = $sql_row1['title_size_s49'];
$size50 = $sql_row1['title_size_s50'];

		$flag = $sql_row1['title_flag'];
}


$sql="select * from $bai_pro3.allocate_stat_log where order_tid=\"$tran_order_tid\" order by tid";
//echo $sql;
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

if($flag== 1)
{
	echo "<div class=\"table-responsive\"><table class=\"table table-bordered\"><thead><tr><th class=\"column-title\"><center>Ratio</center></th><th class=\"column-title\"><center>Category</center></th><th class=\"column-title\"><center>Total Plies</center></th><th class=\"column-title\"><center>Max Plies/Cut</center></th>";
	for($s=0;$s<sizeof($s_tit);$s++)
	{
		echo " <th class=\"column-title\"><center>".$s_tit[$sizes_code[$s]]."</center></th>";
	}
	echo "<th class=\"column-title\"><center>Ratio Total</center></th><th class=\"column-title\"><center>Controls</center></th><th class=\"column-title\"><center>Current Status</center></th><th class=\"column-title\"><center>Remarks</center></th></tr></thead>";
}
else
{
	echo "<div class=\"table-responsive\"><table class=\"table table-bordered\"><center><thead><tr><th class=\"column-title\"><center>Ratio#</center></th><th class=\"column-title\"><center>Category</center></th><th class=\"column-title\"><center>Total Plies</center></th>
	<th class=\"column-title\"><center>01</center></th><th class=\"column-title\"><center>02</center></th><th class=\"column-title\"><center>03</center></th><th class=\"column-title\"><center>04</center></th><th class=\"column-title\"><center>05</center></th><th class=\"column-title\"><center>06</center></th><th class=\"column-title\"><center>07</center></th><th class=\"column-title\"><center>08</center></th><th class=\"column-title\"><center>09</center></th><th class=\"column-title\"><center>10</center></th><th class=\"column-title\"><center>11</center></th><th class=\"column-title\"><center>12</center></th><th class=\"column-title\"><center>13</center></th><th class=\"column-title\"><center>14</center></th><th class=\"column-title\"><center>15</center></th><th class=\"column-title\"><center>16</center></th><th class=\"column-title\"><center>17</center></th><th class=\"column-title\"><center>18</center></th><th class=\"column-title\"><center>19</center></th><th class=\"column-title\"><center>20</center></th><th class=\"column-title\"><center>21</center></th><th class=\"column-title\"><center>22</center></th><th class=\"column-title\"><center>23</center></th><th class=\"column-title\"><center>24</center></th><th class=\"column-title\"><center>25</center></th><th class=\"column-title\"><center>26</center></th><th class=\"column-title\"><center>27</center></th><th class=\"column-title\"><center>28</center></th><th class=\"column-title\"><center>29</center></th><th class=\"column-title\"><center>30</center></th><th class=\"column-title\"><center>31</center></th><th class=\"column-title\"><center>32</center></th><th class=\"column-title\"><center>33</center></th><th class=\"column-title\"><center>34</center></th><th class=\"column-title\"><center>35</center></th><th class=\"column-title\"><center>36</center></th><th class=\"column-title\"><center>37</center></th><th class=\"column-title\"><center>38</center></th><th class=\"column-title\"><center>39</center></th><th class=\"column-title\"><center>40</center></th><th class=\"column-title\"><center>41</center></th><th class=\"column-title\"><center>42</center></th><th class=\"column-title\"><center>43</center></th><th class=\"column-title\"><center>44</center></th><th class=\"column-title\"><center>45</center></th><th class=\"column-title\"><center>46</center></th><th class=\"column-title\"><center>47</center></th><th class=\"column-title\"><center>48</center></th><th class=\"column-title\"><center>49</center></th><th class=\"column-title\"><center>50</center></th>
	<th class=\"column-title\"><center>Ratio Total</center></th><th class=\"column-title\"><center>Controls</center></th><th class=\"column-title\"><center>Current Status</center></th><th class=\"column-title\"><center>Remarks</center></th></tr></thead>";
}
while($sql_row=mysqli_fetch_array($sql_result))
{

	$mk_status=$sql_row['mk_status'];
	
	$check_id=$sql_row['cuttable_ref'];
	echo "<tr>";
	// echo "<td class=\"  \"><center>".$sql_row['tid']."</center></td>";
	//echo "<td class=\" \"><center>".$check_id."</center></td>";
	echo "<td class=\"  \"><center>".$sql_row['ratio']."</center></td>";
	
	$cat_ref=$sql_row['cat_ref'];
	$sql2="select * from $bai_pro3.cat_stat_log where tid=$cat_ref order by catyy DESC";
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
			$cat_yy=$sql_row2['catyy'];
			$category=$sql_row2['category'];
			$mo_status=$sql_row2['mo_status'];
	}
	
	echo "<td class=\"  \"><center>".$category."</center></td>";
	echo "<td class=\"  \"><center>".$sql_row['plies']."</td><td class=\"  \"><center>".$sql_row['pliespercut']."</center></td>";
	$tot=0;
	for($s=0;$s<sizeof($s_tit);$s++)
	{
		echo "<td class=\"  \"><center>".$sql_row["allocate_s".$sizes_code[$s].""]."</center></td>";
		$tot+=$sql_row["allocate_s".$sizes_code[$s].""];
		if($category=='Body' || $category=='Front')
		{
			$tot_size[$s] = (int)$tot_size[$s]+((int)$sql_row['plies']*(int)$sql_row["allocate_s".$sizes_code[$s].""]);
		}
		//echo " <th class=\"heading2\" style='background-color:#29759C;color:white;'>".$s_tit[$sizes_code[$s]]."</th>";
	}
	echo "<td class=\"  \"><center>".$tot."</center></td>";

if($sql_row['mk_status']==9)
{
	echo "<td class=\"  \"><center>Lay Plan Prepared</center></td>";
}
else{
	echo "<td class=\"  \"><center>";
	
	$sql21="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$tran_order_tid\" and allocate_ref='".$sql_row['tid']."'";
	$sql_result21=mysqli_query($link, $sql21) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result21)==0)
	{
		echo "<a class=\"btn btn-xs btn-info\" href=\"".getFullURL($_GET['r'], "order_allocation_form2_edit.php", "N")."&check_id=".$check_id."&tran_order_tid=".$tran_order_tid."&cat_id=".$cat_id."&ref_id=".$sql_row['tid']."\">Edit</a>";
	}
else
{
	$mk_status=9;
	echo "Lay Plan Prepared";

}
			echo "</center></td>";
}



	switch ($mk_status)
	{
		case 1:
		{
			echo "<td class=\"  \"><center>NEW</center></td>";
			break;
		}
			
		case 2:
		{
			echo "<td class=\"  \"><center>VERIFIED</center></td>";
			break;
		}
			
		case 3:
		{
			echo "<td class=\"  \"><center>REVISE</center></td>";
			break;
		}
		case 9:
		{
			echo "<td class=\"  \"><center>Docket Generated</center></td>";
			break;
		}
		default:
		{
			echo "<td class=\"  \"><center>NEW</center></td>";
			break;
		}
			
	}
echo "<td class=\"  \"><center>".$sql_row['remarks']."</center></td>";
echo "</tr>";
}
echo "<tr><td colspan=3> Total Planned Quantity</center><td>";
for($s=0;$s<sizeof($s_tit);$s++)
{
	echo "<td class=\"  \"><center>$tot_size[$s]</center></td>";
}	
echo "<td class=\"  \"><center></center></td><td class=\"  \"><center></center></td><tdclass=\"  \"><center></center></td><td class=\"  \"><center></center></td><td class=\"  \"><center></center></td></tr>";
echo "<tr><td colspan=3>Excess / Less <td>";
for($s=0;$s<sizeof($s_tit);$s++)
{
	//$temp="cuttable_".$sizes_array[$s];
	echo "<td class=\"  \"><center>".($tot_size[$s]-$s_ord[$s])."</center></td>";
}	
echo "<td class=\"  \"><center></center></td><td class=\"  \"><center></center></td><td class=\"  \"><center></center></td><td class=\"  \"><center></center></td></tr>";
echo "</table></div>
</div></div></div></div>";

?>

<!--<div id="div7" style="display: none;">
<?php //include("main_interface_7.php"); ?>
</div>-->

<!-- <p><a href="#" >Marker</a></p>
<div id="div5">
<?php //include("main_interface_5.php"); ?>
</div> -->

<div class="col-sm-12 row">
	<div class = "panel panel-default">
		<div class="panel-heading" style="text-align:center;">
			
				<a data-toggle="collapse" href="#Marker"><strong><b>Marker</b></strong></a>
		</div>
		<div id="Marker" class="panel-collapse collapse-in collapse in" aria-expanded="true">
			<div class="panel-body">
				<?php include("main_interface_5.php"); ?>
			</div>
		</div>
	</div>
</div>


<?php


?>

<!-- <p><a href="#" >Docket Creation / Edit</a></p> -->
<!--<div id="div6" style="display: none;">
<?php //include("main_interface_6.php"); ?>
</div>-->

<div class="col-sm-12 row">
	<div class = "panel panel-default">
		<div class="panel-heading" style="text-align:center;">
		<span class="label label-default pull-left">Available Slots</span>
				<a data-toggle="collapse" href="#docket_creation"><strong><b>Docket Creation / Edit</b></strong></a>
			</div>
			<div id="docket_creation" class="panel-collapse collapse-in collapse in" aria-expanded="true">
				<div class="panel-body">
					

<?php

$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result)>0)
{
	$ord_tbl_name="bai_orders_db_confirm";	
}
else{
	$ord_tbl_name="bai_orders_db";		
}


echo "<div class=\"table-responsive\"><table class=\"table table-bordered\">";
//<th class=\"column-title \"><center>Ref</center></th>
echo "<thead><tr><th class=\"column-title \"><center>Category</center></th><th class=\"column-title \"><center>Total Cut</center></th><th class=\"column-title \"><center>Ratio Ref</center></th><th class=\"column-title \"><center>MO Status</center></th><th class=\"column-title \"><center>Control</center></th><th class=\"column-title \"><center>Overall Savings%</center></th><th class=\"column-title \"><center>Proceed</center></th><th class=\"column-title \"><center>Remarks</center></th></tr></thead>";

$sql="select * from $bai_pro3.maker_stat_log where order_tid=\"$tran_order_tid\" and allocate_ref > 0 order by allocate_ref";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$mkref=$sql_row['tid'];
	echo "<tr>";
	// <td class=\"  \"><center>".$mkref."</center></td>";
	$allocate_ref=$sql_row['allocate_ref'];
	$cutcount=0;
	$mklength=$sql_row['mklength'];
	$cat_ref=$sql_row['cat_ref'];
	
	$sql2="select * from $bai_pro3.cat_stat_log where tid=$cat_ref order by catyy DESC";
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
			$cat_yy=$sql_row2['catyy'];
			$category=$sql_row2['category'];
			$mo_status=$sql_row2['mo_status'];
	}

	echo "<td class=\"  \"><center>".$category."</center></td>";
	
	$sql2="select * from $bai_pro3.allocate_stat_log where order_tid=\"$tran_order_tid\" and tid=$allocate_ref";
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$ratio=$sql_row2['ratio'];
		if($sql_row2['pliespercut']>0)
		{			
			$cutcount=ceil($sql_row2['plies']/$sql_row2['pliespercut']);
		}
		echo "<td class=\"  \"><center>".$cutcount."</center></td>";
		echo "<td class=\"  \"><center>".$ratio."</center></td>";
		
		$totalplies=$sql_row2['allocate_s01']+$sql_row2['allocate_s02']+$sql_row2['allocate_s03']+$sql_row2['allocate_s04']+$sql_row2['allocate_s05']+$sql_row2['allocate_s06']+$sql_row2['allocate_s07']+$sql_row2['allocate_s08']+$sql_row2['allocate_s09']+$sql_row2['allocate_s10']+$sql_row2['allocate_s11']+$sql_row2['allocate_s12']+$sql_row2['allocate_s13']+$sql_row2['allocate_s14']+$sql_row2['allocate_s15']+$sql_row2['allocate_s16']+$sql_row2['allocate_s17']+$sql_row2['allocate_s18']+$sql_row2['allocate_s19']+$sql_row2['allocate_s20']+$sql_row2['allocate_s21']+$sql_row2['allocate_s22']+$sql_row2['allocate_s23']+$sql_row2['allocate_s24']+$sql_row2['allocate_s25']+$sql_row2['allocate_s26']+$sql_row2['allocate_s27']+$sql_row2['allocate_s28']+$sql_row2['allocate_s29']+$sql_row2['allocate_s30']+$sql_row2['allocate_s31']+$sql_row2['allocate_s32']+$sql_row2['allocate_s33']+$sql_row2['allocate_s34']+$sql_row2['allocate_s35']+$sql_row2['allocate_s36']+$sql_row2['allocate_s37']+$sql_row2['allocate_s38']+$sql_row2['allocate_s39']+$sql_row2['allocate_s40']+$sql_row2['allocate_s41']+$sql_row2['allocate_s42']+$sql_row2['allocate_s43']+$sql_row2['allocate_s44']+$sql_row2['allocate_s45']+$sql_row2['allocate_s46']+$sql_row2['allocate_s47']+$sql_row2['allocate_s48']+$sql_row2['allocate_s49']+$sql_row2['allocate_s50'];
		$remarks=$sql_row2['remarks'];

	}

	if($mo_status=="Y")
	{
		echo "<td class=\"  \" align='center'><span class='label label-success'>YES</span></td>";
	}
	else
	{
		echo "<td class=\"  \" align='center'><span class='label label-danger'>NO</span></td>";
	}
	
	
	$sql2="select count(pcutdocid) as \"count\" from $bai_pro3.plandoc_stat_log where order_tid=\"$tran_order_tid\" and allocate_ref=$allocate_ref ";
	//echo $sql2;
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		//echo $sql_row2['count']."===".$mo_status."--".$cutcount."--".$totalplies."<br>";
		if($sql_row2['count']==0 && $mo_status=="Y" && $cutcount>0 && $totalplies>0)
		{
			echo "<td class=\"  \"><center><a class=\"btn btn-xs btn-primary\" href=\"".getFullURL($_GET['r'], "doc_gen_form.php", "N")."&tran_order_tid=$tran_order_tid&mkref=$mkref&allocate_ref=$allocate_ref&cat_ref=$cat_ref\">Generate</a></center></td>";
		}
		else
		{
			echo "<td class=\"  \"><center><a class=\"btn btn-xs btn-info\" href=\"".getFullURL($_GET['r'], "doc_view_admin.php", "N")."&order_tid=$tran_order_tid&cat_ref=$cat_ref\">View</a></center></td>";	
		}

	}
	
	if($totalplies>0 and $cat_yy>0)
	{
			$savings=round((($cat_yy-($mklength/$totalplies))/$cat_yy)*100,0);
	}

	//echo "<td class=\"b1\">".$savings."%</td>";
	
	
	
	
	/* NEW 2010-05-22 */
	
	$newyy=0;
	$new_order_qty=0;
	$sql2="select * from $bai_pro3.maker_stat_log where order_tid=\"$tran_order_tid\" and cat_ref=$cat_ref and cuttable_ref > 0";
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$mk_new_length=$sql_row2['mklength'];
		$new_allocate_ref=$sql_row2['allocate_ref'];
		
		$sql22="select * from $bai_pro3.allocate_stat_log where tid=$new_allocate_ref";
		mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row22=mysqli_fetch_array($sql_result22))
		{
			$new_plies=$sql_row22['plies'];
		}
		$newyy=$newyy+($mk_new_length*$new_plies);
	}
	//With Binding Consumption logic - SK - Starts
	$newyy21=$newyy;
	
	$sql21="select order_no from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid1\"";
	mysqli_query($link, $sql21) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result21=mysqli_query($link, $sql21) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row21=mysqli_fetch_array($sql_result21))
	{
		$order_no1=$sql_row21['order_no'];
	}
	
	//if excess 1% 
	
	if($order_no1 == "1")
	{
		$sql2="select (old_order_s_s01+old_order_s_s02+old_order_s_s03+old_order_s_s04+old_order_s_s05+old_order_s_s06+old_order_s_s07+old_order_s_s08+old_order_s_s09+old_order_s_s10+old_order_s_s11+old_order_s_s12+old_order_s_s13+old_order_s_s14+old_order_s_s15+old_order_s_s16+old_order_s_s17+old_order_s_s18+old_order_s_s19+old_order_s_s20+old_order_s_s21+old_order_s_s22+old_order_s_s23+old_order_s_s24+old_order_s_s25+old_order_s_s26+old_order_s_s27+old_order_s_s28+old_order_s_s29+old_order_s_s30+old_order_s_s31+old_order_s_s32+old_order_s_s33+old_order_s_s34+old_order_s_s35+old_order_s_s36+old_order_s_s37+old_order_s_s38+old_order_s_s39+old_order_s_s40+old_order_s_s41+old_order_s_s42+old_order_s_s43+old_order_s_s44+old_order_s_s45+old_order_s_s46+old_order_s_s47+old_order_s_s48+old_order_s_s49+old_order_s_s50) as \"sum\" from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid1\"";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$new_order_qty1=$sql_row2['sum'];
		}
	}
	
	else
	{
		$sql2="select (old_order_s_s01+old_order_s_s02+old_order_s_s03+old_order_s_s04+old_order_s_s05+old_order_s_s06+old_order_s_s07+old_order_s_s08+old_order_s_s09+old_order_s_s10+old_order_s_s11+old_order_s_s12+old_order_s_s13+old_order_s_s14+old_order_s_s15+old_order_s_s16+old_order_s_s17+old_order_s_s18+old_order_s_s19+old_order_s_s20+old_order_s_s21+old_order_s_s22+old_order_s_s23+old_order_s_s24+old_order_s_s25+old_order_s_s26+old_order_s_s27+old_order_s_s28+old_order_s_s29+old_order_s_s30+old_order_s_s31+old_order_s_s32+old_order_s_s33+old_order_s_s34+old_order_s_s35+old_order_s_s36+old_order_s_s37+old_order_s_s38+old_order_s_s39+old_order_s_s40+old_order_s_s41+old_order_s_s42+old_order_s_s43+old_order_s_s44+old_order_s_s45+old_order_s_s46+old_order_s_s47+old_order_s_s48+old_order_s_s49+old_order_s_s50) as \"sum\" from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid1\"";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$new_order_qty1=$sql_row2['sum'];
		}
	}
	
	//Binding Consumption / YY Calculation //20151016-KIRANG-Imported Binding inclusive concept.
	
	$sql2="select COALESCE(binding_con,0) as \"binding_con\" from $bai_pro3.bai_orders_db_remarks where order_tid=\"$tran_order_tid1\"";
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$bind_con1=$sql_row2['binding_con'];
	}
	
	$newyy+=($new_order_qty1*$bind_con1);

	//Binding Consumption / YY Calculation //20151016-KIRANG-Imported Binding inclusive concept.
	if($new_order_qty1 >0){
		$newyy=$newyy/$new_order_qty1;
	}
	
	//Binding Consumption logic - SK - Ends
	
	$sql2="select (order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50) as \"sum\" from $ord_tbl_name where order_tid=\"$tran_order_tid\"";
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$new_order_qty=$sql_row2['sum'];
	}
	
	//$newyy=$newyy/$new_order_qty;
	$savings_new=round((($cat_yy-$newyy)/$cat_yy)*100,2);
	echo "<td class=\"  \"><center>".$savings_new."%</center></td>";
	/* NEW 2010-05-22 */
	

	
	echo "<td class=\"  \"><center>"; if($savings_new>=2){echo "<span class='label label-success'>Yes</span>"; } else {echo "<span class='label label-danger'>No</span>"; } echo "</center></td>";
	
	echo "<td class=\"  \"><center>".$remarks."</center></td>";
	echo "</tr>";
}
echo "</table></div>				</div>
</div>
</div>
</div>";
$sql="select distinct tid from $bai_pro3.cat_stat_log where order_tid=\"$tran_order_tid\" order by catyy DESC";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	
	//echo "View Cut Plan <a href=\"new_doc_gen/Book2.php?order_tid=$tran_order_tid&cat_ref=$sql_row[tid]\">Download</a>";
	//echo "View DOCS <a href=\"dumindu/doc_view_form.php?order_tid=$tran_order_tid&cat_ref=$sql_row[tid]\">Download</a><br/>";

}

?>

<!-- <p>Cut Plan / Docket View</p> -->
<!--<div id="div8" style="display: none;">
<?php //include("main_interface_8.php"); ?>
</div>-->

<div class="col-sm-12 row">
		<div class = "panel panel-default">
			<div class="panel-heading" style="text-align:center;">
				<span class="label label-default pull-left">Quick Status</span>
					<a data-toggle="collapse" href="#cut_plan"><strong><b>Cut Plan / Docket View</b></strong></a>
				</div>
				<div id="cut_plan" class="panel-collapse collapse-in collapse in" aria-expanded="true">
					<div class="panel-body">
<?php

$permission = haspermission($_GET['r']);

$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error1: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result)>0)
{
	$ord_tbl_name="$bai_pro3.bai_orders_db_confirm";	
}
else{
	$ord_tbl_name="$bai_pro3.bai_orders_db";		
}


	echo "<div class=\"table-responsive\"><table class=\"table table-bordered\">";
	echo "<thead><tr>";
	echo "<th class=\"column-title\"><center>Category</center></th>";
	echo "<th class=\"column-title\"><center>Cuttable</center></th>";
	echo "<th class=\"column-title\"><center>Allocation</center></th>";
	echo "<th class=\"column-title\"><center>Marker</center></th>";
	echo "<th class=\"column-title\"><center>Docs</center></th>";
	//echo "<th class=\"column-title\"><center>Cut Plan Print</center></th>";
	echo "<th class=\"column-title\"><center>Cut Plan View</center></th>";
	if(in_array($authorized,$permission))
	{
	echo "<th class=\"column-title\"><center>Fabric Cut Plan</center></th>";
	}
	//echo "<th class=\"column-title\"><center>Docket Print</center></th>";
	echo "</tr></thead>";

	$sql="select * from $bai_pro3.cat_stat_log where order_tid='".$tran_order_tid."' order by catyy DESC";
	//echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$cat_tid_new=$sql_row['tid'];
	$category_new=$sql_row['category'];
	$order_qty_new=0;
	$cuttable_qty_new=0;
	$allocation_qty_new=0;
	$mk_count=0;
	$ratio_sum_new=0;
	$doc_sum=0;
	$clubbing=$sql_row['clubbing'];
	
	//echo $cat_tid_new;
		
	$sql2="select sum(order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50) as \"order_qty_new\" from $ord_tbl_name where order_tid=\"$tran_order_tid\"";
	mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$order_qty_new=$sql_row2['order_qty_new'];
	}
	
	
	$sql2="select sum(cuttable_s_s01+cuttable_s_s02+cuttable_s_s03+cuttable_s_s04+cuttable_s_s05+cuttable_s_s06+cuttable_s_s07+cuttable_s_s08+cuttable_s_s09+cuttable_s_s10+cuttable_s_s11+cuttable_s_s12+cuttable_s_s13+cuttable_s_s14+cuttable_s_s15+cuttable_s_s16+cuttable_s_s17+cuttable_s_s18+cuttable_s_s19+cuttable_s_s20+cuttable_s_s21+cuttable_s_s22+cuttable_s_s23+cuttable_s_s24+cuttable_s_s25+cuttable_s_s26+cuttable_s_s27+cuttable_s_s28+cuttable_s_s29+cuttable_s_s30+cuttable_s_s31+cuttable_s_s32+cuttable_s_s33+cuttable_s_s34+cuttable_s_s35+cuttable_s_s36+cuttable_s_s37+cuttable_s_s38+cuttable_s_s39+cuttable_s_s40+cuttable_s_s41+cuttable_s_s42+cuttable_s_s43+cuttable_s_s44+cuttable_s_s45+cuttable_s_s46+cuttable_s_s47+cuttable_s_s48+cuttable_s_s49+cuttable_s_s50) as \"cuttable_qty_new\"from $bai_pro3.cuttable_stat_log where order_tid=\"$tran_order_tid\" and cat_id=$cat_tid_new";
	mysqli_query($link, $sql2) or exit("Sql Error3: $sql2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error3: $sql2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$cuttable_qty_new=$sql_row2['cuttable_qty_new'];
	}
	
		
	$sql2="select sum((allocate_s01+allocate_s02+allocate_s03+allocate_s04+allocate_s05+allocate_s06+allocate_s07+allocate_s08+allocate_s09+allocate_s10+allocate_s11+allocate_s12+allocate_s13+allocate_s14+allocate_s15+allocate_s16+allocate_s17+allocate_s18+allocate_s19+allocate_s20+allocate_s21+allocate_s22+allocate_s23+allocate_s24+allocate_s25+allocate_s26+allocate_s27+allocate_s28+allocate_s29+allocate_s30+allocate_s31+allocate_s32+allocate_s33+allocate_s34+allocate_s35+allocate_s36+allocate_s37+allocate_s38+allocate_s39+allocate_s40+allocate_s41+allocate_s42+allocate_s43+allocate_s44+allocate_s45+allocate_s46+allocate_s47+allocate_s48+allocate_s49+allocate_s50)*plies) as \"total\" from $bai_pro3.allocate_stat_log where order_tid=\"$tran_order_tid\" and cat_ref=$cat_tid_new";

	mysqli_query($link, $sql2) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$allocation_qty_new=$sql_row2['total'];
	}

		
	$sql2="select count(tid) as \"count\" from $bai_pro3.maker_stat_log where order_tid=\"$tran_order_tid\" and cat_ref=$cat_tid_new";
	//echo $sql2;
	mysqli_query($link, $sql2) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$mk_count=$sql_row2['count'];
	}
	
	
	$sql2="select sum((a_s01+a_s02+a_s03+a_s04+a_s05+a_s06+a_s07+a_s08+a_s09+a_s10+a_s11+a_s12+a_s13+a_s14+a_s15+a_s16+a_s17+a_s18+a_s19+a_s20+a_s21+a_s22+a_s23+a_s24+a_s25+a_s26+a_s27+a_s28+a_s29+a_s30+a_s31+a_s32+a_s33+a_s34+a_s35+a_s36+a_s37+a_s38+a_s39+a_s40+a_s41+a_s42+a_s43+a_s44+a_s45+a_s46+a_s47+a_s48+a_s49+a_s50)*p_plies) as \"doc_sum\" from $bai_pro3.plandoc_stat_log where order_tid=\"$tran_order_tid\" and cat_ref=$cat_tid_new"; //20110911
	//echo $sql2;
	mysqli_query($link, $sql2) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$doc_sum=$sql_row2['doc_sum'];
	}
	
//echo $cat_tid_new;
	$sql2="select count(*) as \"ratio_sum\" from $bai_pro3.allocate_stat_log where cat_ref=$cat_tid_new";
	//echo $sql2;
	mysqli_query($link, $sql2) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$ratio_sum_new=$sql_row2['ratio_sum'];
	}


	$check_new4=0;
	$check_new3=0;
	$check_new1=0;
	$check_new2=0;
	
	if($cuttable_qty_new>=$order_qty_new)
	{
		$check_new1=1;
	}
	
//	echo $cuttable_qty_new."-".$order_qty_new."<br/>";
	
	if($allocation_qty_new>=$order_qty_new) // changed on 2010-12-02 on dumindu request
	{
		$check_new2=1;
	}
	
//	echo $allocation_qty_new."-".$order_qty_new."<br/>";
	if($mk_count>=$ratio_sum_new && $mk_count!=0)
	{
		$check_new3=1;
	}
		
	//echo $mk_count."-".$ratio_sum_new."<br/>";
	if(($doc_sum>=$order_qty_new)) // changed on 2010-12-02 on dumindu request
	{
		$check_new4=1;
	}		
	//echo $doc_sum."-".$order_qty_new;
	
	echo "<tr class=\"  \">";
	echo "<td class=\"  \"><center>".$category_new."</center></td>";
	
/*	echo "<td"; if($check_new1==1){echo " bgcolor=\"GREEN\" ";} else {echo " bgcolor=\"RED\" ";} echo "></td>";
	echo "<td"; if($check_new2==1){echo " bgcolor=\"GREEN\" ";} else {echo " bgcolor=\"RED\" ";} echo "></td>";
	echo "<td"; if($check_new3==1){echo " bgcolor=\"GREEN\" ";} else {echo " bgcolor=\"RED\" ";} echo "></td>";
	echo "<td"; if($check_new4==1){echo " bgcolor=\"GREEN\" ";} else {echo " bgcolor=\"RED\" ";} echo "></td>"; */
	$correct_icon = "<span class='label label-success'><i class=\"fa fa-check-circle\"></i></span>";
	$wrong_icon = "<span class='label label-danger'><i class=\"fa fa-times-circle\"></i></span>";
	echo "<td class=\"  \"><center>"; if($check_new1==1){echo $correct_icon;} else {echo $wrong_icon;} echo "</center></td>";
	echo "<td class=\"  \"><center>"; if($check_new2==1){echo $correct_icon;} else {echo $wrong_icon;} echo "</center></td>";
	echo "<td class=\"  \"><center>"; if($check_new3==1){echo $correct_icon;} else {echo $wrong_icon;} echo "</center></td>";
	echo "<td class=\"  \"><center>"; if($check_new4==1){echo $correct_icon;} else {echo $wrong_icon;} echo "</center></td>";
	
	 $path="".getFullURL($_GET['r'], "Book1_print.php", "R")."?order_tid=$tran_order_tid&cat_ref=$cat_tid_new&cat_title=$category_new&clubbing=$clubbing";
	//$path="http://localhost/sfcs/projects/Beta/cut_plan_new_ms/new_doc_gen/Book1_print.php";

	$path3="".getFullURL($_GET['r'], "Book2_pdf.php", "R")."?order_tid=$tran_order_tid&cat_ref=$cat_tid_new&cat_title=$category_new&clubbing=$clubbing&color=$color&schedule=$schedule&style=$style";
	$path1="".getFullURL($_GET['r'], "Book1_print_fabric.php", "R")."?order_tid=$tran_order_tid&cat_ref=$cat_tid_new&cat_title=$category_new&clubbing=$clubbing";
	if($clubbing>0)
	{
		// $path="".getFullURLLevel($_GET['r'], "color_club_layplan_print.php", "0", "N")."&order_tid=$tran_order_tid&cat_ref=$cat_tid_new&cat_title=$category_new&clubbing=$clubbing";
		// $path1="".getFullURLLevel($_GET['r'], "color_club_layplan_print.php", "0", "N")."&order_tid=$tran_order_tid&cat_ref=$cat_tid_new&cat_title=$category_new&clubbing=$clubbing";

		$path= getFullURLLevel($_GET['r'], "color_club_layplan_print.php", "0", "R")."?order_tid=$tran_order_tid&cat_ref=$cat_tid_new&cat_title=$category_new&clubbing=$clubbing";
		$path1="".getFullURLLevel($_GET['r'], "color_club_layplan_print.php", "0", "R")."?order_tid=$tran_order_tid&cat_ref=$cat_tid_new&cat_title=$category_new&clubbing=$clubbing";
	}
	
		//echo "<td class=\"  \"><center>";if($check_new1==1 && $check_new2==1 && $check_new3==1 && $check_new4==1){echo "<a class=\"btn btn-xs btn-warning\" href=\"$path\" onclick=\"return popitup("."'".$path."'".")\">Print Cut Plan</a>";} else {echo $wrong_icon;} "</center></td>";

	echo "<td class=\"  \"><center>";
	if($check_new1==1 && $check_new2==1 && $check_new3==1 && $check_new4==1){
		echo "<a class=\"btn btn-xs btn-info\" href=\"$path\" onclick=\"return popitup("."'".$path."'".")\">View Cut Plan</a>";
	} 
	else{
		echo $wrong_icon;
	} 
	echo "</center></td>";
	if(in_array($authorized,$permission))
	{
	echo "<td class=\"  \"><center>";if($check_new1==1 && $check_new2==1 && $check_new3==1 && $check_new4==1){echo "<a class=\"btn btn-xs btn-info\" href=\"$path1\" onclick=\"return popitup("."'".$path1."'".")\">View Fabric Cut Plan</a>";} else {echo $wrong_icon;} echo "</center></td>";
	}
	//$red_url = getFullURL($_GET['r'], "doc_view_form.php","N")."&order_tid=$tran_order_tid&cat_ref=$cat_tid_new";
	//$pop_url = getFullURL($_GET['r'],"doc_view_form.php","R")."?order_tid=$tran_order_tid&cat_ref=$cat_tid_new";
	// echo "<td class=\"  \"><center>";if($check_new1==1 && $check_new2==1 && $check_new3==1 && $check_new4==1){ 
	// 		echo "<a class=\"btn btn-xs btn-warning\" href='$red_url'  
	// 		       onclick=\"return popitup('$pop_url')\">Cut Docket Prints</a>";} else {echo $wrong_icon;} "</center></td>";
	echo "</tr>";
	

	
//	echo "View Cut Plan <a href=\"new_doc_gen/Book2.php?order_tid=$tran_order_tid&cat_ref=$cat_tid\">Download</a>";
//	echo "View DOCS <a href=\"dumindu/doc_view_form.php?order_tid=$tran_order_tid&cat_ref=$cat_tid\">Download</a><br/>";

}
	echo "</table></div></div>
	</div>
</div>
</div>";

?>

<!--<p><a href="#" onclick="showhide('div9');">Docket Flow</a></p>
<div id="div9" style="display: none;">
<?php //include("main_interface_9.php"); ?>
</div> -->
<!-- <p><a href="#" >Docket Flow</a></p> -->

	<!-- <div class="col-sm-12">
		<div class = "panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" href="#Docket_Flow"><strong>Docket Flow</strong></a>
				</h4>
				<div id="Docket_Flow" class="panel-collapse collapse-in">
					<div class="panel-body">
					<?php
						echo "<a class=\"btn btn-xs btn-info\" href=\"".getFullURL($_GET['r'], "dumindu/orders_cut_issue_status_list.php", "N")."&tran_order_tid=$tran_order_tid\">Control Panel >>>> Go</a>";
					?>
					</div>
				</div>
			</div>
		</div>
	</div> -->

<!-- <p><a href="#" onclick="showhide('div12');">Recut Details</a></p>
<div id="div12" style="display: none;">
<?php //include("../cut_plan_new/dumindu/recut_stat_v3.php"); ?>
</div>  -->

<div class="col-sm-12 row">
	<div class = "panel panel-default">
		<div class="panel-heading" style="text-align:center;">
			
				<a data-toggle="collapse" href="#recut_details"><strong><b>Recut Details</b></strong></a>
		</div>
		<div id="recut_details" class="panel-collapse collapse-in collapse in" aria-expanded="true">
			<div class="panel-body">
				<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'], "recut_stat_v3.php", "0", "R")); ?>
			</div>
		</div>
	</div>
</div>

</div>
</div>
