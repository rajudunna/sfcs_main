
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));	?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',2,'R') );  ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R') );  ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R') );  ?>

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

<script language="Javascript" type="text/javascript">
	function gotolink(x) { 
		input.cartonid.value=x; 
	}
</script>


<?php

//Deleting wrongly generated list

if($schedule>0)
{

	$sql="select * from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\"";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
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


		
	}
	
	$total_order_qtys=($o_xs+$o_s+$o_m+$o_l+$o_xl+$o_xxl+$o_xxxl+$o_s_s01+$o_s_s02+$o_s_s03+$o_s_s04+$o_s_s05+$o_s_s06+$o_s_s07+$o_s_s08+$o_s_s09+$o_s_s10+$o_s_s11+$o_s_s12+$o_s_s13+$o_s_s14+$o_s_s15+$o_s_s16+$o_s_s17+$o_s_s18+$o_s_s19+$o_s_s20+$o_s_s21+$o_s_s22+$o_s_s23+$o_s_s24+$o_s_s25+$o_s_s26+$o_s_s27+$o_s_s28+$o_s_s29+$o_s_s30+$o_s_s31+$o_s_s32+$o_s_s33+$o_s_s34+$o_s_s35+$o_s_s36+$o_s_s37+$o_s_s38+$o_s_s39+$o_s_s40+$o_s_s41+$o_s_s42+$o_s_s43+$o_s_s44+$o_s_s45+$o_s_s46+$o_s_s47+$o_s_s48+$o_s_s49+$o_s_s50);


	
	$sql="select group_concat(tid) as \"tid_db\", coalesce(sum(carton_act_qty),0) as \"tot_carton_qty\" from $bai_pro3.packing_summary where order_del_no in ($schedule)";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$count=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$tid_db=$sql_row['tid_db'];
		$tot_carton_qty=$sql_row['tot_carton_qty'];
	}
	
	$sql="select * from $bai_pro3.packing_summary where order_del_no in ($schedule) and status=\"DONE\"";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$done_count=mysqli_num_rows($sql_result);
	
	//echo "Carton Qty:".$tot_carton_qty."<br/>";
	//echo "Order Qty:".$total_order_qtys."<br/>";
	//echo "Scanned:".$done_count."<br/>";
	
	if(($total_order_qtys!=$tot_carton_qty) and $tot_carton_qty!=0 and $done_count==0)
	{
		$sql="insert into $bai_pro3.pac_stat_log_deleted select * from $bai_pro3.pac_stat_log where tid in ($tid_db)";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql="delete from $bai_pro3.pac_stat_log where tid in ($tid_db)";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql="update $bai_pro3.bai_orders_db_confirm set carton_id=0, carton_print_status=NULL where order_del_no in ($schedule)";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//echo "<h2><font color=green>Successfully Done</font></h2>";
	}
}
?>

<?php

$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
//echo $sql;
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
	
	$style_id=$sql_row['style_id'];
	$packing_method=$sql_row['packing_method'];
	$buyer_code=substr($style,0,1);
	$carton_id=$sql_row['carton_id'];
	$carton_print_status=$sql_row['carton_print_status'];
	
	$o_s_xs=$sql_row['order_s_xs'];
	$o_s_s=$sql_row['order_s_s'];
	$o_s_m=$sql_row['order_s_m'];
	$o_s_l=$sql_row['order_s_l'];
	$o_s_xl=$sql_row['order_s_xl'];
	$o_s_xxl=$sql_row['order_s_xxl'];
	$o_s_xxxl=$sql_row['order_s_xxxl'];
	
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

		
	$o_total=($o_s_xs+$o_s_s+$o_s_m+$o_s_l+$o_s_xl+$o_s_xxl+$o_s_xxxl+$o_s_s01+$o_s_s02+$o_s_s03+$o_s_s04+$o_s_s05+$o_s_s06+$o_s_s07+$o_s_s08+$o_s_s09+$o_s_s10+$o_s_s11+$o_s_s12+$o_s_s13+$o_s_s14+$o_s_s15+$o_s_s16+$o_s_s17+$o_s_s18+$o_s_s19+$o_s_s20+$o_s_s21+$o_s_s22+$o_s_s23+$o_s_s24+$o_s_s25+$o_s_s26+$o_s_s27+$o_s_s28+$o_s_s29+$o_s_s30+$o_s_s31+$o_s_s32+$o_s_s33+$o_s_s34+$o_s_s35+$o_s_s36+$o_s_s37+$o_s_s38+$o_s_s39+$o_s_s40+$o_s_s41+$o_s_s42+$o_s_s43+$o_s_s44+$o_s_s45+$o_s_s46+$o_s_s47+$o_s_s48+$o_s_s49+$o_s_s50);

echo "<table>";
echo "<tr>";

echo "<table class=\"all\">";
echo "<tr>";
echo "<td class=\"heading\">Date</td><td>:</td><td class=\"content\">$order_date</td><td class=\"heading\">Division</td><td>:</td><td class=\"content\">$order_div</td><td class=\"heading\">PO</td><td>:</td><td class=\"content\">$order_po</td><td class=\"heading\">Packing Method</td><td>:</td><td class=\"content\">$packing_method</td>";
echo "</tr>";
echo "<tr>";
echo "<td class=\"heading\">Style</td><td>:</td><td class=\"content\">$style</td><td class=\"heading\">Schedule</td><td>:</td><td class=\"content\">".$schedule.chr($color_code)."</td><td class=\"heading\">Color</td><td>:</td><td class=\"content\">$color</td><td class=\"heading\">User Style ID</td><td>:</td><td class=\"content\">$style_id</td>";
echo "</tr>";
echo "</table>";

echo "</tr>";
echo "<tr>";

echo "<table class=\"all\">";
echo "<tr align=center style='background-color:#29759C;color:white;'><td class=\"heading2\" style='background-color:#29759C;color:white;'>Sizes</td><td class=\"title\">XS</td><td class=\"title\">S</td><td class=\"title\">M</td><td class=\"title\">L</td><td class=\"title\">XL</td><td class=\"title\">XXL</td><td class=\"title\">XXXl</td><td class=\"title\">01</td>
<td class=\"title\">02</td>
<td class=\"title\">03</td>
<td class=\"title\">04</td>
<td class=\"title\">05</td>
<td class=\"title\">06</td>
<td class=\"title\">07</td>
<td class=\"title\">08</td>
<td class=\"title\">09</td>
<td class=\"title\">10</td>
<td class=\"title\">11</td>
<td class=\"title\">12</td>
<td class=\"title\">13</td>
<td class=\"title\">14</td>
<td class=\"title\">15</td>
<td class=\"title\">16</td>
<td class=\"title\">17</td>
<td class=\"title\">18</td>
<td class=\"title\">19</td>
<td class=\"title\">20</td>
<td class=\"title\">21</td>
<td class=\"title\">22</td>
<td class=\"title\">23</td>
<td class=\"title\">24</td>
<td class=\"title\">25</td>
<td class=\"title\">26</td>
<td class=\"title\">27</td>
<td class=\"title\">28</td>
<td class=\"title\">29</td>
<td class=\"title\">30</td>
<td class=\"title\">31</td>
<td class=\"title\">32</td>
<td class=\"title\">33</td>
<td class=\"title\">34</td>
<td class=\"title\">35</td>
<td class=\"title\">36</td>
<td class=\"title\">37</td>
<td class=\"title\">38</td>
<td class=\"title\">39</td>
<td class=\"title\">40</td>
<td class=\"title\">41</td>
<td class=\"title\">42</td>
<td class=\"title\">43</td>
<td class=\"title\">44</td>
<td class=\"title\">45</td>
<td class=\"title\">46</td>
<td class=\"title\">47</td>
<td class=\"title\">48</td>
<td class=\"title\">49</td>
<td class=\"title\">50</td>
<td class=\"title\">Total</td></tr>";
echo "<tr ><td class=\"heading2\" style='background-color:#29759C;color:white;'>Quantity</td>";
echo "<td class=\"sizes\">$o_s_xs</td>";
echo "<td class=\"sizes\">$o_s_s</td>";
echo "<td class=\"sizes\">$o_s_m</td>";
echo "<td class=\"sizes\">$o_s_l</td>";
echo "<td class=\"sizes\">$o_s_xl</td>";
echo "<td class=\"sizes\">$o_s_xxl</td>";
echo "<td class=\"sizes\">$o_s_xxxl</td>";
echo "<td class=\"sizes\">$o_s_s01</td>";
echo "<td class=\"sizes\">$o_s_s02</td>";
echo "<td class=\"sizes\">$o_s_s03</td>";
echo "<td class=\"sizes\">$o_s_s04</td>";
echo "<td class=\"sizes\">$o_s_s05</td>";
echo "<td class=\"sizes\">$o_s_s06</td>";
echo "<td class=\"sizes\">$o_s_s07</td>";
echo "<td class=\"sizes\">$o_s_s08</td>";
echo "<td class=\"sizes\">$o_s_s09</td>";
echo "<td class=\"sizes\">$o_s_s10</td>";
echo "<td class=\"sizes\">$o_s_s11</td>";
echo "<td class=\"sizes\">$o_s_s12</td>";
echo "<td class=\"sizes\">$o_s_s13</td>";
echo "<td class=\"sizes\">$o_s_s14</td>";
echo "<td class=\"sizes\">$o_s_s15</td>";
echo "<td class=\"sizes\">$o_s_s16</td>";
echo "<td class=\"sizes\">$o_s_s17</td>";
echo "<td class=\"sizes\">$o_s_s18</td>";
echo "<td class=\"sizes\">$o_s_s19</td>";
echo "<td class=\"sizes\">$o_s_s20</td>";
echo "<td class=\"sizes\">$o_s_s21</td>";
echo "<td class=\"sizes\">$o_s_s22</td>";
echo "<td class=\"sizes\">$o_s_s23</td>";
echo "<td class=\"sizes\">$o_s_s24</td>";
echo "<td class=\"sizes\">$o_s_s25</td>";
echo "<td class=\"sizes\">$o_s_s26</td>";
echo "<td class=\"sizes\">$o_s_s27</td>";
echo "<td class=\"sizes\">$o_s_s28</td>";
echo "<td class=\"sizes\">$o_s_s29</td>";
echo "<td class=\"sizes\">$o_s_s30</td>";
echo "<td class=\"sizes\">$o_s_s31</td>";
echo "<td class=\"sizes\">$o_s_s32</td>";
echo "<td class=\"sizes\">$o_s_s33</td>";
echo "<td class=\"sizes\">$o_s_s34</td>";
echo "<td class=\"sizes\">$o_s_s35</td>";
echo "<td class=\"sizes\">$o_s_s36</td>";
echo "<td class=\"sizes\">$o_s_s37</td>";
echo "<td class=\"sizes\">$o_s_s38</td>";
echo "<td class=\"sizes\">$o_s_s39</td>";
echo "<td class=\"sizes\">$o_s_s40</td>";
echo "<td class=\"sizes\">$o_s_s41</td>";
echo "<td class=\"sizes\">$o_s_s42</td>";
echo "<td class=\"sizes\">$o_s_s43</td>";
echo "<td class=\"sizes\">$o_s_s44</td>";
echo "<td class=\"sizes\">$o_s_s45</td>";
echo "<td class=\"sizes\">$o_s_s46</td>";
echo "<td class=\"sizes\">$o_s_s47</td>";
echo "<td class=\"sizes\">$o_s_s48</td>";
echo "<td class=\"sizes\">$o_s_s49</td>";
echo "<td class=\"sizes\">$o_s_s50</td>";

echo "<td class=\"sizes\">".$o_total."</td></tr>";
echo "</table>";

echo "</tr>";
echo "</table>";

//echo "<input type=\"checkbox\" name=\"option\"  id=\"option\" onclick=\"javascript:enableButton();\">Enable";
//echo "<INPUT TYPE = \"Submit\" Name = \"Update\" VALUE = \"Update\">";
//echo "</form>";


$sql="select * from $bai_pro3.cat_stat_log where order_tid=\"$tran_order_tid\" and length(category)>0";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$cat_ref=$sql_row['tid'];
}
}

if($_POST['submit'])
{
	echo "<h1><font color=\"red\">Please wait while processing data!</font></h1>";
}

	echo '<p><a href="#" onclick="showhide('."'div10'".');">Packing List</a></p><div id="div10" style="display: none;">';
	include("main_interface_10_rplg.php"); 
	echo '</div>'; 
?>
