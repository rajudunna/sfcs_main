<?php
set_time_limit(2000);
$cache_date="index_".date("Y_m_d_H_i");
$cachefile = "cached/".$cache_date."html";

/* if (file_exists($cachefile)) {

	include($cachefile);

	exit;

} */
ob_start();


?>

<html>
<head>
<script src="<?= getFullURLLevel($_GET['r'],'common/js/gs_sortable.js',1,'R'); ?>"></script>
<!-- <script src="../../js/jquery-1.4.2.min.js"></script> -->
<!-- <script src="../../js/jquery-ui-1.8.1.custom.min.js"></script> -->
<!-- <script src="../../js/cal.js"></script> -->

<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',1,'R'); ?>"></script>

<script type="text/javascript">
	$(function() {
		$("#from_date").simpleDatepicker({startdate: '2010-01-01', enddate: '2020' });
		$("#to_date").simpleDatepicker({startdate: '2010-01-01', enddate: '2020' });
	});
</script>

<script type="text/javascript">
<!--
var TSort_Data = new Array ('my_table', 'i', 's', 's', 'f', 'i', 's', 'i', 's','','', 'd', 's', 's', 'd', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i');
tsRegister();
// -->
</script>

<?php
/*


'i' - Column contains integer data. If the column data contains a number followed by text then the text will ignored. For example, "54note" will be interpreted as "54".

'n' - Column contains integer number in which all three-digit groups are optionally separated from each other by commas. For example, column data "100,000,000" is treated as "100000000" when type of data is set to 'n', or as "100" when type of data is set to 'i'.

'f' - Column contains floating point numbers in the form ###.###.

'g' - Column contains floating point numbers in the form ###.###. Three-digit groups in the floating-point number may be separated from each other by commas. For example, column data "65,432.1" is treated as "65432.1" when type of data is set to 'g', or as "65" when type of data is set to 'f'.

'h' - column contains HTML code. The script will strip all HTML code before sorting the data.

's' - column contains plain text data.

'd' - column contains a date.

'' - do not sort the column.
*/

?>
	

<SCRIPT>

function SetAllCheckBoxes(FormName, FieldName, CheckValue)
{
	if(!document.forms[FormName])
		return;
	var objCheckBoxes = document.forms[FormName].elements[FieldName];
	if(!objCheckBoxes)
		return;
	var countCheckBoxes = objCheckBoxes.length;
	if(!countCheckBoxes)
		objCheckBoxes.checked = CheckValue;
	else
		// set the check value for all check boxes
		for(var i = 0; i < countCheckBoxes; i++)
			objCheckBoxes[i].checked = CheckValue;
}
</SCRIPT>
<link href="<?= getFullURLLevel($_GET['r'],'common/css/sfcs_styles.css',3,'R'); ?>" rel="stylesheet" type="text/css" />
</head>


<body>

<?php
// include("../dbconf2.php");
include(getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

?>

<?php

if(isset($_GET['division']))
{
	$division=$_GET['division'];
}
else
{
	$division=$_POST['division'];
}
$pending=$_POST['pending'];
?>

<!--<h2>Delivery Status Report - <?php  echo date("Y-m-d H:i"); ?></h2>-->
<div class="panel panel-primary"><div class="panel-heading">Delivery Status Report - <?php  echo date("Y-m-d H:i"); ?></div><div class="panel-body">


<?php


{
	$division="All";
	$pending=$_POST['pending'];
	
	$query="";
	if($division!="All")
	{
		$query="where MID(buyer_division,1, 2)=\"$division\"";
	}
	

echo '<br/><br/><div style="overflow:scroll;max-height:800px;max-width:1200px;">
<table class="table table-bordered">
<thead>
<tr>
<th colspan=12>Shipment Details</th><th colspan=20> Sizes</th><th colspan=6>Shipment Details</th><th colspan=2>Sec1</th><th colspan=2>Sec2</th>		<th colspan=2>Sec3</th>		<th colspan=2>Sec4</th>		<th colspan=2>Sec5</th>		<th colspan=2>Sec6</th>	<th colspan=38></th>
</tr>';

echo '<tr class="tblheading">
<th>S. No</th>	<th>Buyer Division</th>	<th>MPO</th>	<th>CPO</th>	<th>Customer Order No</th>	<th>Z-Feature</th><th>Style No.</th>	<th>Schedule No.</th>	<th>Colour</th>	<th>Order Total</th><th>Plan Total</th><th>Total</th>	';

if($division=="All" )
{
echo '<th>XS</th>	<th>S</th>	<th>M</th>	<th>L</th>	<th>XL</th>	<th>XXL</th>	<th>XXXL</th>	<th>s01</th> <th>s02</th> <th>s03</th> <th>s04</th> <th>s05</th> <th>s06</th> <th>s07</th> <th>s08</th> <th>s09</th> <th>s10</th> <th>s11</th> <th>s12</th> <th>s13</th> <th>s14</th> <th>s15</th> <th>s16</th> <th>s17</th> <th>s18</th> <th>s19</th> <th>s20</th> <th>s21</th> <th>s22</th> <th>s23</th> <th>s24</th> <th>s25</th> <th>s26</th> <th>s27</th> <th>s28</th> <th>s29</th> <th>s30</th> <th>s31</th> <th>s32</th> <th>s33</th> <th>s34</th> <th>s35</th> <th>s36</th> <th>s37</th> <th>s38</th> <th>s39</th> <th>s40</th> <th>s41</th> <th>s42</th> <th>s43</th> <th>s44</th> <th>s45</th> <th>s46</th> <th>s47</th> <th>s48</th> <th>s49</th> <th>s50</th>';
}
else
{
	

if($division=="M&")
{
echo '<th>XS</th>	<th>S</th>	<th>M</th>	<th>L</th>	<th>XL</th>	<th>XXL</th>	<th>XXXL</th><th>s01</th> <th>s02</th> <th>s03</th> <th>s04</th> <th>s05</th> <th>s06</th> <th>s07</th> <th>s08</th> <th>s09</th> <th>s10</th> <th>s11</th> <th>s12</th> <th>s13</th> <th>s14</th> <th>s15</th> <th>s16</th> <th>s17</th> <th>s18</th> <th>s19</th> <th>s20</th> <th>s21</th> <th>s22</th> <th>s23</th> <th>s24</th> <th>s25</th> <th>s26</th> <th>s27</th> <th>s28</th> <th>s29</th> <th>s30</th> <th>s31</th> <th>s32</th> <th>s33</th> <th>s34</th> <th>s35</th> <th>s36</th> <th>s37</th> <th>s38</th> <th>s39</th> <th>s40</th> <th>s41</th> <th>s42</th> <th>s43</th> <th>s44</th> <th>s45</th> <th>s46</th> <th>s47</th> <th>s48</th> <th>s49</th> <th>s50</th>';
}
else
{
	echo '<th>XS</th>	<th>S</th>	<th>M</th>	<th>L</th>	<th>XL</th>	<th>XXL</th>	<th>XXXL</th>';
}
}

echo '<th>Ex Factory</th><th>Rev. Ex-Factory</th>	<th>Mode</th>	<th>Packing Method</th>	<th>Plan End Date</th>	<th>Embellishment</th><th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th><th>Remarks</th></tr></thead><tbody>';



$x=1;
$sql="select * from $bai_pro4.week_delivery_plan where shipment_plan_id in (select ship_tid from $bai_pro4.shipment_plan $query)";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
$shipment_plan_id=$sql_row['shipment_plan_id'];
$fastreact_plan_id=$sql_row['fastreact_plan_id'];
$size_xs=$sql_row['size_xs'];
$size_s=$sql_row['size_s'];
$size_m=$sql_row['size_m'];
$size_l=$sql_row['size_l'];
$size_xl=$sql_row['size_xl'];
$size_xxl=$sql_row['size_xxl'];
$size_xxxl=$sql_row['size_xxxl'];
$size_s01=$sql_row['size_s01'];
			$size_s02=$sql_row['size_s02'];
			$size_s03=$sql_row['size_s03'];
			$size_s04=$sql_row['size_s04'];
			$size_s05=$sql_row['size_s05'];
			$size_s06=$sql_row['size_s06'];
			$size_s07=$sql_row['size_s07'];
			$size_s08=$sql_row['size_s08'];
			$size_s09=$sql_row['size_s09'];
			$size_s10=$sql_row['size_s10'];
			$size_s11=$sql_row['size_s11'];
			$size_s12=$sql_row['size_s12'];
			$size_s13=$sql_row['size_s13'];
			$size_s14=$sql_row['size_s14'];
			$size_s15=$sql_row['size_s15'];
			$size_s16=$sql_row['size_s16'];
			$size_s17=$sql_row['size_s17'];
			$size_s18=$sql_row['size_s18'];
			$size_s19=$sql_row['size_s19'];
			$size_s20=$sql_row['size_s20'];
			$size_s21=$sql_row['size_s21'];
			$size_s22=$sql_row['size_s22'];
			$size_s23=$sql_row['size_s23'];
			$size_s24=$sql_row['size_s24'];
			$size_s25=$sql_row['size_s25'];
			$size_s26=$sql_row['size_s26'];
			$size_s27=$sql_row['size_s27'];
			$size_s28=$sql_row['size_s28'];
			$size_s29=$sql_row['size_s29'];
			$size_s30=$sql_row['size_s30'];
			$size_s31=$sql_row['size_s31'];
			$size_s32=$sql_row['size_s32'];
			$size_s33=$sql_row['size_s33'];
			$size_s34=$sql_row['size_s34'];
			$size_s35=$sql_row['size_s35'];
			$size_s36=$sql_row['size_s36'];
			$size_s37=$sql_row['size_s37'];
			$size_s38=$sql_row['size_s38'];
			$size_s39=$sql_row['size_s39'];
			$size_s40=$sql_row['size_s40'];
			$size_s41=$sql_row['size_s41'];
			$size_s42=$sql_row['size_s42'];
			$size_s43=$sql_row['size_s43'];
			$size_s44=$sql_row['size_s44'];
			$size_s45=$sql_row['size_s45'];
			$size_s46=$sql_row['size_s46'];
			$size_s47=$sql_row['size_s47'];
			$size_s48=$sql_row['size_s48'];
			$size_s49=$sql_row['size_s49'];
			$size_s50=$sql_row['size_s50'];
$plan_start_date=$sql_row['plan_start_date'];
$plan_comp_date=$sql_row['plan_comp_date'];
$size_comp_xs=$sql_row['size_comp_xs'];
$size_comp_s=$sql_row['size_comp_s'];
$size_comp_m=$sql_row['size_comp_m'];
$size_comp_l=$sql_row['size_comp_l'];
$size_comp_xl=$sql_row['size_comp_xl'];
$size_comp_xxl=$sql_row['size_comp_xxl'];
$size_comp_xxxl=$sql_row['size_comp_xxxl'];
$size_comp_s01=$sql_row['size_comp_s01'];
			$size_comp_s02=$sql_row['size_comp_s02'];
			$size_comp_s03=$sql_row['size_comp_s03'];
			$size_comp_s04=$sql_row['size_comp_s04'];
			$size_comp_s05=$sql_row['size_comp_s05'];
			$size_comp_s06=$sql_row['size_comp_s06'];
			$size_comp_s07=$sql_row['size_comp_s07'];
			$size_comp_s08=$sql_row['size_comp_s08'];
			$size_comp_s09=$sql_row['size_comp_s09'];
			$size_comp_s10=$sql_row['size_comp_s10'];
			$size_comp_s11=$sql_row['size_comp_s11'];
			$size_comp_s12=$sql_row['size_comp_s12'];
			$size_comp_s13=$sql_row['size_comp_s13'];
			$size_comp_s14=$sql_row['size_comp_s14'];
			$size_comp_s15=$sql_row['size_comp_s15'];
			$size_comp_s16=$sql_row['size_comp_s16'];
			$size_comp_s17=$sql_row['size_comp_s17'];
			$size_comp_s18=$sql_row['size_comp_s18'];
			$size_comp_s19=$sql_row['size_comp_s19'];
			$size_comp_s20=$sql_row['size_comp_s20'];
			$size_comp_s21=$sql_row['size_comp_s21'];
			$size_comp_s22=$sql_row['size_comp_s22'];
			$size_comp_s23=$sql_row['size_comp_s23'];
			$size_comp_s24=$sql_row['size_comp_s24'];
			$size_comp_s25=$sql_row['size_comp_s25'];
			$size_comp_s26=$sql_row['size_comp_s26'];
			$size_comp_s27=$sql_row['size_comp_s27'];
			$size_comp_s28=$sql_row['size_comp_s28'];
			$size_comp_s29=$sql_row['size_comp_s29'];
			$size_comp_s30=$sql_row['size_comp_s30'];
			$size_comp_s31=$sql_row['size_comp_s31'];
			$size_comp_s32=$sql_row['size_comp_s32'];
			$size_comp_s33=$sql_row['size_comp_s33'];
			$size_comp_s34=$sql_row['size_comp_s34'];
			$size_comp_s35=$sql_row['size_comp_s35'];
			$size_comp_s36=$sql_row['size_comp_s36'];
			$size_comp_s37=$sql_row['size_comp_s37'];
			$size_comp_s38=$sql_row['size_comp_s38'];
			$size_comp_s39=$sql_row['size_comp_s39'];
			$size_comp_s40=$sql_row['size_comp_s40'];
			$size_comp_s41=$sql_row['size_comp_s41'];
			$size_comp_s42=$sql_row['size_comp_s42'];
			$size_comp_s43=$sql_row['size_comp_s43'];
			$size_comp_s44=$sql_row['size_comp_s44'];
			$size_comp_s45=$sql_row['size_comp_s45'];
			$size_comp_s46=$sql_row['size_comp_s46'];
			$size_comp_s47=$sql_row['size_comp_s47'];
			$size_comp_s48=$sql_row['size_comp_s48'];
			$size_comp_s49=$sql_row['size_comp_s49'];
			$size_comp_s50=$sql_row['size_comp_s50'];
$plan_sec1=$sql_row['plan_sec1'];
$plan_sec2=$sql_row['plan_sec2'];
$plan_sec3=$sql_row['plan_sec3'];
$plan_sec4=$sql_row['plan_sec4'];
$plan_sec5=$sql_row['plan_sec5'];
$plan_sec6=$sql_row['plan_sec6'];
$plan_sec7=$sql_row['plan_sec7'];
$plan_sec8=$sql_row['plan_sec8'];
$plan_sec9=$sql_row['plan_sec9'];
$actu_sec1=$sql_row['actu_sec1'];
$actu_sec2=$sql_row['actu_sec2'];
$actu_sec3=$sql_row['actu_sec3'];
$actu_sec4=$sql_row['actu_sec4'];
$actu_sec5=$sql_row['actu_sec5'];
$actu_sec6=$sql_row['actu_sec6'];
$actu_sec7=$sql_row['actu_sec7'];
$actu_sec8=$sql_row['actu_sec8'];
$actu_sec9=$sql_row['actu_sec9'];
$tid=$sql_row['tid'];
$r_tid=$sql_row['ref_id'];
$remarks=$sql_row['remarks'];

//TEMP Enabled
$embl_tag=$sql_row['rev_emb_status'];
$rev_ex_factory_date=$sql_row['rev_exfactory']; 
if($rev_ex_factory_date=="0000-00-00")
{
	$rev_ex_factory_date="";
}

//$order_total=$size_xs+$size_s+$size_m+$size_l+$size_xl+$size_xxl+$size_xxxl+$size_s06+$size_s08+$size_s10+$size_s12+$size_s14+$size_s16+$size_s18+$size_s20+$size_s22+$size_s24+$size_s26+$size_s28+$size_s30;
$actu_total=$size_xs+$size_s+$size_m+$size_l+$size_xl+$size_xxl+$size_xxxl+$size_s01+$size_s02+$size_s03+$size_s04+$size_s05+$size_s06+$size_s07+$size_s08+$size_s09+$size_s10+$size_s11+$size_s12+$size_s13+$size_s14+$size_s15+$size_s16+$size_s17+$size_s18+$size_s19+$size_s20+$size_s21+$size_s22+$size_s23+$size_s24+$size_s25+$size_s26+$size_s27+$size_s28+$size_s29+$size_s30+$size_s31+$size_s32+$size_s33+$size_s34+$size_s35+$size_s36+$size_s37+$size_s38+$size_s39+$size_s40+$size_s41+$size_s42+$size_s43+$size_s44+$size_s45+$size_s46+$size_s47+$size_s48+$size_s49+$size_s50;
$plan_total=$actu_sec1+$actu_sec2+$actu_sec3+$actu_sec4+$actu_sec5+$actu_sec6+$actu_sec7+$actu_sec8+$actu_sec9;

$order_total=0;
$sql1="select * from $bai_pro4.shipment_plan_ref where ship_tid=$shipment_plan_id";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$order_no=$sql_row1['order_no'];
	$delivery_no=$sql_row1['delivery_no'];
	$del_status=$sql_row1['del_status'];
	$mpo=$sql_row1['mpo'];
	$cpo=$sql_row1['cpo'];
	$buyer=$sql_row1['buyer'];
	$product=$sql_row1['product'];
	$buyer_division=$sql_row1['buyer_division'];
	$style=$sql_row1['style'];
	$schedule_no=$sql_row1['schedule_no'];
	$color=$sql_row1['color'];
	$size=$sql_row1['size'];
	$z_feature=$sql_row1['z_feature'];
	$ord_qty=$sql_row1['ord_qty'];
	$order_total=$sql_row1['ord_qty_new'];
	$ex_factory_date=$sql_row1['ex_factory_date']; //TEMP Disabled due to M3 Issue
	$mode=$sql_row1['mode'];
	$destination=$sql_row1['destination'];
	$packing_method=$sql_row1['packing_method'];
	$fob_price_per_piece=$sql_row1['fob_price_per_piece'];
	$cm_value=$sql_row1['cm_value'];
	$ssc_code=$sql_row1['ssc_code'];
	$ship_tid=$sql_row1['ship_tid'];
	$week_code=$sql_row1['week_code'];
	$status=$sql_row1['status'];
	
	
	//TEMP Disabled due to M3 Issue
	//$embl_tag=embl_check($sql_row1['order_embl_a'].$sql_row1['order_embl_b'].$sql_row1['order_embl_c'].$sql_row1['order_embl_d'].$sql_row1['order_embl_e'].$sql_row1['order_embl_f'].$sql_row1['order_embl_g'].$sql_row1['order_embl_h']);
}
$order_total=$sql_row['original_order_qty'];
//NEW ORDER QTY TRACK
/*
$sql1="select * from shipfast_sum where shipment_plan_id=$shipment_plan_id";
$sql_result1=mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
while($sql_row1=mysql_fetch_array($sql_result1))
{
	$size_xs1=$sql_row1['size_xs'];
	$size_s1=$sql_row1['size_s'];
	$size_m1=$sql_row1['size_m'];
	$size_l1=$sql_row1['size_l'];
	$size_xl1=$sql_row1['size_xl'];
	$size_xxl1=$sql_row1['size_xxl'];
	$size_xxxl1=$sql_row1['size_xxxl'];
	$size_s061=$sql_row1['size_s06'];
	$size_s081=$sql_row1['size_s08'];
	$size_s101=$sql_row1['size_s10'];
	$size_s121=$sql_row1['size_s12'];
	$size_s141=$sql_row1['size_s14'];
	$size_s161=$sql_row1['size_s16'];
	$size_s181=$sql_row1['size_s18'];
	$size_s201=$sql_row1['size_s20'];
	$size_s221=$sql_row1['size_s22'];
	$size_s241=$sql_row1['size_s24'];
	$size_s261=$sql_row1['size_s26'];
	$size_s281=$sql_row1['size_s28'];
	$size_s301=$sql_row1['size_s30'];
	
}
$order_total=$size_xs1+$size_s1+$size_m1+$size_l1+$size_xl1+$size_xxl1+$size_xxxl1+$size_s061+$size_s081+$size_s101+$size_s121+$size_s141+$size_s161+$size_s181+$size_s201+$size_s221+$size_s241+$size_s261+$size_s281+$size_s301; */
//NEW ORDER QTY TRACK
$order_total=$sql_row['original_order_qty'];

if($pending==1)
{
	if($order_total>$actu_total)
	{


		if($division=="All" )
		{
			echo "<tr><td> $x  </td>	<td>$buyer_division</td>	<td>$mpo</td>	<td>$cpo</td>	<td>$order_no</td>	<td>$z_feature</td><td>$style</td>	<td>$schedule_no</td>	<td>$color</td>	<td>$order_total</td><td>$plan_total</td><td>$actu_total</td>	<td>$size_xs</td>	<td>$size_s</td>	<td>$size_m</td>	<td>$size_l</td>	<td>$size_xl</td>	<td>$size_xxl</td>	<td>$size_xxxl</td><td>$size_s01</td>  <td>$size_s02</td>  <td>$size_s03</td>  <td>$size_s04</td>  <td>$size_s05</td>  <td>$size_s06</td>  <td>$size_s07</td>  <td>$size_s08</td>  <td>$size_s09</td>  <td>$size_s10</td>  <td>$size_s11</td>  <td>$size_s12</td>  <td>$size_s13</td>  <td>$size_s14</td>  <td>$size_s15</td>  <td>$size_s16</td>  <td>$size_s17</td>  <td>$size_s18</td>  <td>$size_s19</td>  <td>$size_s20</td>  <td>$size_s21</td>  <td>$size_s22</td>  <td>$size_s23</td>  <td>$size_s24</td>  <td>$size_s25</td>  <td>$size_s26</td>  <td>$size_s27</td>  <td>$size_s28</td>  <td>$size_s29</td>  <td>$size_s30</td>  <td>$size_s31</td>  <td>$size_s32</td>  <td>$size_s33</td>  <td>$size_s34</td>  <td>$size_s35</td>  <td>$size_s36</td>  <td>$size_s37</td>  <td>$size_s38</td>  <td>$size_s39</td>  <td>$size_s40</td>  <td>$size_s41</td>  <td>$size_s42</td>  <td>$size_s43</td>  <td>$size_s44</td>  <td>$size_s45</td>  <td>$size_s46</td>  <td>$size_s47</td>  <td>$size_s48</td>  <td>$size_s49</td>  <td>$size_s50</td><td>$ex_factory_date</td><td>$rev_ex_factory_date</td>	<td>$mode</td>	<td>$packing_method</td>	<td>$plan_comp_date</td><td>$embl_tag</td>	<td>$plan_sec1</td>	<td>$actu_sec1</td>	<td>$plan_sec2</td>	<td>$actu_sec2</td>	<td>$plan_sec3</td>	<td>$actu_sec3</td>	<td>$plan_sec4</td>	<td>$actu_sec4</td>	<td>$plan_sec5</td>	<td>$actu_sec5</td>	<td>$plan_sec6</td>	<td>$actu_sec6</td>	<td>$remarks</td></tr>";
		}
		else
		{
			
		
		if($division=="M&" )
		{
		echo "<tr><td> $x  </td>	<td>$buyer_division</td>	<td>$mpo</td>	<td>$cpo</td>	<td>$order_no</td>	<td>$z_feature</td><td>$style</td>	<td>$schedule_no</td>	<td>$color</td>	<td>$order_total</td><td>$plan_total</td><td>$actu_total</td><td>$size_s01</td>  <td>$size_s02</td>  <td>$size_s03</td>  <td>$size_s04</td>  <td>$size_s05</td>  <td>$size_s06</td>  <td>$size_s07</td>  <td>$size_s08</td>  <td>$size_s09</td>  <td>$size_s10</td>  <td>$size_s11</td>  <td>$size_s12</td>  <td>$size_s13</td>  <td>$size_s14</td>  <td>$size_s15</td>  <td>$size_s16</td>  <td>$size_s17</td>  <td>$size_s18</td>  <td>$size_s19</td>  <td>$size_s20</td>  <td>$size_s21</td>  <td>$size_s22</td>  <td>$size_s23</td>  <td>$size_s24</td>  <td>$size_s25</td>  <td>$size_s26</td>  <td>$size_s27</td>  <td>$size_s28</td>  <td>$size_s29</td>  <td>$size_s30</td>  <td>$size_s31</td>  <td>$size_s32</td>  <td>$size_s33</td>  <td>$size_s34</td>  <td>$size_s35</td>  <td>$size_s36</td>  <td>$size_s37</td>  <td>$size_s38</td>  <td>$size_s39</td>  <td>$size_s40</td>  <td>$size_s41</td>  <td>$size_s42</td>  <td>$size_s43</td>  <td>$size_s44</td>  <td>$size_s45</td>  <td>$size_s46</td>  <td>$size_s47</td>  <td>$size_s48</td>  <td>$size_s49</td>  <td>$size_s50</td>	<td>$ex_factory_date</td><td>$rev_ex_factory_date</td>	<td>$mode</td>	<td>$packing_method</td>	<td>$plan_comp_date</td><td>$embl_tag</td>	<td>$plan_sec1</td>	<td>$actu_sec1</td>	<td>$plan_sec2</td>	<td>$actu_sec2</td>	<td>$plan_sec3</td>	<td>$actu_sec3</td>	<td>$plan_sec4</td>	<td>$actu_sec4</td>	<td>$plan_sec5</td>	<td>$actu_sec5</td>	<td>$plan_sec6</td>	<td>$actu_sec6</td>	<td>$remarks</td></tr>";
		}
		else
		{
			echo "<tr><td>  $x</td>	<td>$buyer_division</td>	<td>$mpo</td>	<td>$cpo</td>	<td>$order_no</td>	<td>$z_feature</td><td>$style</td>	<td>$schedule_no</td>	<td>$color</td>	<td>$order_total</td><td>$plan_total</td><td>$actu_total</td><td>$size_xs</td>	<td>$size_s</td>	<td>$size_m</td>	<td>$size_l</td>	<td>$size_xl</td>	<td>$size_xxl</td>	<td>$size_xxxl</td>	<td>$ex_factory_date</td><td>$rev_ex_factory_date</td>	<td>$mode</td>	<td>$packing_method</td>	<td>$plan_comp_date</td><td>$embl_tag</td>	<td>$plan_sec1</td>	<td>$actu_sec1</td>	<td>$plan_sec2</td>	<td>$actu_sec2</td>	<td>$plan_sec3</td>	<td>$actu_sec3</td>	<td>$plan_sec4</td>	<td>$actu_sec4</td>	<td>$plan_sec5</td>	<td>$actu_sec5</td>	<td>$plan_sec6</td>	<td>$actu_sec6</td>	<td>$remarks</td></tr>";
		}
		}
	}
}
else
{
		if($division=="All" )
		{
			echo "<tr><td> $x  </td>	<td>$buyer_division</td>	<td>$mpo</td>	<td>$cpo</td>	<td>$order_no</td>	<td>$z_feature</td><td>$style</td>	<td>$schedule_no</td>	<td>$color</td>	<td>$order_total</td><td>$plan_total</td><td>$actu_total</td><td>$size_xs</td>	<td>$size_s</td>	<td>$size_m</td>	<td>$size_l</td>	<td>$size_xl</td>	<td>$size_xxl</td>	<td>$size_xxxl</td><td>$size_s01</td>  <td>$size_s02</td>  <td>$size_s03</td>  <td>$size_s04</td>  <td>$size_s05</td>  <td>$size_s06</td>  <td>$size_s07</td>  <td>$size_s08</td>  <td>$size_s09</td>  <td>$size_s10</td>  <td>$size_s11</td>  <td>$size_s12</td>  <td>$size_s13</td>  <td>$size_s14</td>  <td>$size_s15</td>  <td>$size_s16</td>  <td>$size_s17</td>  <td>$size_s18</td>  <td>$size_s19</td>  <td>$size_s20</td>  <td>$size_s21</td>  <td>$size_s22</td>  <td>$size_s23</td>  <td>$size_s24</td>  <td>$size_s25</td>  <td>$size_s26</td>  <td>$size_s27</td>  <td>$size_s28</td>  <td>$size_s29</td>  <td>$size_s30</td>  <td>$size_s31</td>  <td>$size_s32</td>  <td>$size_s33</td>  <td>$size_s34</td>  <td>$size_s35</td>  <td>$size_s36</td>  <td>$size_s37</td>  <td>$size_s38</td>  <td>$size_s39</td>  <td>$size_s40</td>  <td>$size_s41</td>  <td>$size_s42</td>  <td>$size_s43</td>  <td>$size_s44</td>  <td>$size_s45</td>  <td>$size_s46</td>  <td>$size_s47</td>  <td>$size_s48</td>  <td>$size_s49</td>  <td>$size_s50</td>	<td>$ex_factory_date</td><td>$rev_ex_factory_date</td>	<td>$mode</td>	<td>$packing_method</td>	<td>$plan_comp_date</td><td>$embl_tag</td>	<td>$plan_sec1</td>	<td>$actu_sec1</td>	<td>$plan_sec2</td>	<td>$actu_sec2</td>	<td>$plan_sec3</td>	<td>$actu_sec3</td>	<td>$plan_sec4</td>	<td>$actu_sec4</td>	<td>$plan_sec5</td>	<td>$actu_sec5</td>	<td>$plan_sec6</td>	<td>$actu_sec6</td>	<td>$remarks</td></tr>";
		}
		else
		{
			
		
		if($division=="M&" )
		{
		echo "<tr><td> $x  </td>	<td>$buyer_division</td>	<td>$mpo</td>	<td>$cpo</td>	<td>$order_no</td>	<td>$z_feature</td><td>$style</td>	<td>$schedule_no</td>	<td>$color</td>	<td>$order_total</td><td>$plan_total</td><td>$actu_total</td>	<td>$ex_factory_date</td><td>$rev_ex_factory_date</td>	<td>$mode</td>	<td>$packing_method</td>	<td>$plan_comp_date</td><td>$embl_tag</td>	<td>$plan_sec1</td>	<td>$actu_sec1</td>	<td>$plan_sec2</td>	<td>$actu_sec2</td>	<td>$plan_sec3</td>	<td>$actu_sec3</td>	<td>$plan_sec4</td>	<td>$actu_sec4</td>	<td>$plan_sec5</td>	<td>$actu_sec5</td>	<td>$plan_sec6</td>	<td>$actu_sec6</td>	<td>$size_s01</td>  <td>$size_s02</td>  <td>$size_s03</td>  <td>$size_s04</td>  <td>$size_s05</td>  <td>$size_s06</td>  <td>$size_s07</td>  <td>$size_s08</td>  <td>$size_s09</td>  <td>$size_s10</td>  <td>$size_s11</td>  <td>$size_s12</td>  <td>$size_s13</td>  <td>$size_s14</td>  <td>$size_s15</td>  <td>$size_s16</td>  <td>$size_s17</td>  <td>$size_s18</td>  <td>$size_s19</td>  <td>$size_s20</td>  <td>$size_s21</td>  <td>$size_s22</td>  <td>$size_s23</td>  <td>$size_s24</td>  <td>$size_s25</td>  <td>$size_s26</td>  <td>$size_s27</td>  <td>$size_s28</td>  <td>$size_s29</td>  <td>$size_s30</td>  <td>$size_s31</td>  <td>$size_s32</td>  <td>$size_s33</td>  <td>$size_s34</td>  <td>$size_s35</td>  <td>$size_s36</td>  <td>$size_s37</td>  <td>$size_s38</td>  <td>$size_s39</td>  <td>$size_s40</td>  <td>$size_s41</td>  <td>$size_s42</td>  <td>$size_s43</td>  <td>$size_s44</td>  <td>$size_s45</td>  <td>$size_s46</td>  <td>$size_s47</td>  <td>$size_s48</td>  <td>$size_s49</td>  <td>$size_s50</td><td>$remarks</td></tr>";
		}
		else
		{
			echo "<tr><td> $x  </td>	<td>$buyer_division</td>	<td>$mpo</td>	<td>$cpo</td>	<td>$order_no</td>	<td>$z_feature</td><td>$style</td>	<td>$schedule_no</td>	<td>$color</td>	<td>$order_total</td><td>$plan_total</td><td>$actu_total</td><td>$size_xs</td>	<td>$size_s</td>	<td>$size_m</td>	<td>$size_l</td>	<td>$size_xl</td>	<td>$size_xxl</td>	<td>$size_xxxl</td>	<td>$ex_factory_date</td><td>$rev_ex_factory_date</td>	<td>$mode</td>	<td>$packing_method</td>	<td>$plan_comp_date</td><td>$embl_tag</td>	<td>$plan_sec1</td>	<td>$actu_sec1</td>	<td>$plan_sec2</td>	<td>$actu_sec2</td>	<td>$plan_sec3</td>	<td>$actu_sec3</td>	<td>$plan_sec4</td>	<td>$actu_sec4</td>	<td>$plan_sec5</td>	<td>$actu_sec5</td>	<td>$plan_sec6</td>	<td>$actu_sec6</td>	<td>$remarks</td></tr>";
		}
		}
}


$x+=1;


}

echo '</tbody></table>';

}
?>
</div>
</div>

<?php
// $cachefile = "cached/".$cache_date.".html";
// open the cache file "cache/home.html" for writing
// $fp = fopen($cachefile, 'w');
// save the contents of output buffer to the file
// fwrite($fp, ob_get_contents());
// close the file
// fclose($fp);
// Send the output to the browser
ob_end_flush();

//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"report.php\"; }</script>";
// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"week_delivery_plan_view3_cache.php\"; }</script>";
?>
<style>
table {
	text-align:center;
	text-weight:bold;
}
th {
	background-color:#286090;
	color:white;
}
td {
	color:black;
}
</style>