<!-- 2013-12-09/kirang/Ticket:208365/ Add Actual Cut % in report
2014-01-28/KiranG/Ticket:913906 / Added initilaization set value for rej_per variable
2014-03-07/kirang/Ticket #222648 / Add the Actual Out% and Ext Ship%  and Modify the Act Cut% in weekly delivery report 
2015-03-28/kirang/CR#930/Need To Incorporate the Planning default comments in the Weekly delivery Report.
 -->

<?php
set_time_limit(9000);
$start_date_w=time();

while((date("N",$start_date_w))!=1) {
$start_date_w=$start_date_w-(60*60*24); // define monday
}
$end_date_w=$start_date_w+(60*60*24*6); // define sunday 

//$table.= date("Y-m-d",$end_date_w)."<br/>";
//$table.= date("Y-m-d",$start_date_w);
$start_date_w=date("Y-m-d",$start_date_w);
$end_date_w=date("Y-m-d",$end_date_w);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">



<style>

li{
	float:left;
	padding: 10px;
	
	margin:2px;
}
#tableone thead.Fixed
{
     position: absolute; 
}


</style>



<style>
body
{
	font-family:calibri;
	font-size:12px;
}

table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align: right;
white-space:nowrap; 
}

table th
{
	border: 1px solid black;
	text-align: center;
    	background-color: BLUE;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
	background: #29759C;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
}


}

}
</style>


</head>


<body>
<!-- <div id="ages"></div> -->
<?php
include("../dbconf2.php");
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
	//CR#930 //Fetching the Reasons List from database to displaying the reasons to Users for selecting the appropriate reason of the schedule status.
	$sql_res="select * from weekly_cap_reasons where category=1";
	//echo $sql_res."<br>";
	$sql_result_res=mysqli_query($link, $sql_res) or exit("Sql Error".$sql_res."-".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row_res=mysqli_fetch_array($sql_result_res))
	{
		$searial_no[]=$sql_row_res["sno"];
		$reason_ref[]=$sql_row_res["reason"];
		$color_code_ref[]=$sql_row_res["color_code"];
	}
?>


<?php


{


	$division="All";
	
	$query="where ex_factory_date_new between \"$start_date_w\" and  \"$end_date_w\" order by left(style,1)";
	if($division!="All")
	{
		$query="where MID(buyer_division,1, 2)=\"$division\" and ex_factory_date_new between \"$start_date_w\" and  \"$end_date_w\" order by left(style,1)";
	}

$table= '<table id="tableone"><thead>';



if($division=="All" )
{
//$table.= '<thead>';
//$table.= '<tr><td colspan=13>Shipment Details</td><td colspan=20> Sizes</td><td colspan=7>Shipment Details</td><td colspan=2>Sec1</td><td colspan=2>Sec2</td>	<td colspan=2>Sec3</td>		<td colspan=2>Sec4</td>		<td colspan=2>Sec5</td>		<td colspan=2>Sec6</td>	<td $highlight></td></tr>';

$table.= '<tr>
<th>S. No</th>	<th class="filter">Buyer Division</th>	<th class="filter">MPO</th>	<th class="filter">CPO</th>	<th>Customer Order No</th>	<th>Z-Feature</th><th class="filter">Style No.</th>	<th class="filter">Schedule No.</th>	<th>Colour</th>	<th>Actual Cut %</th><th>Ext Ship %</th><th>Order Total</th><th>Actual Total</th><th>Act Out %</th><th class="filter">Current Status</th><th>Rejection %</th><th>M3 Ship Qty</th><th>Total</th>	';

$table.= '<th>XS</th>	<th>S</th>	<th>M</th>	<th>L</th>	<th>XL</th>	<th>XXL</th>	<th>XXXL</th>	<th>s01</th> <th>s02</th> <th>s03</th> <th>s04</th> <th>s05</th> <th>s06</th> <th>s07</th> <th>s08</th> <th>s09</th> <th>s10</th> <th>s11</th> <th>s12</th> <th>s13</th> <th>s14</th> <th>s15</th> <th>s16</th> <th>s17</th> <th>s18</th> <th>s19</th> <th>s20</th> <th>s21</th> <th>s22</th> <th>s23</th> <th>s24</th> <th>s25</th> <th>s26</th> <th>s27</th> <th>s28</th> <th>s29</th> <th>s30</th> <th>s31</th> <th>s32</th> <th>s33</th> <th>s34</th> <th>s35</th> <th>s36</th> <th>s37</th> <th>s38</th> <th>s39</th> <th>s40</th> <th>s41</th> <th>s42</th> <th>s43</th> <th>s44</th> <th>s45</th> <th>s46</th> <th>s47</th> <th>s48</th> <th>s49</th> <th>s50</th>';
}
else
{
	

if($division=="M&" or $division=="CK")
{

//$table.= '<thead>';
//$table.= '<tr><td colspan=13>Shipment Details</td><td colspan=20> Sizes</td><td colspan=7>Shipment Details</td><td colspan=2>Sec1</td><td colspan=2>Sec2</td>	<td colspan=2>Sec3</td>		<td colspan=2>Sec4</td>		<td colspan=2>Sec5</td>		<td colspan=2>Sec6</td>	<td $highlight></td></tr>';

$table.= '<tr>
<th>S. No</th>	<th class="filter">Buyer Division</th>	<th class="filter">MPO</th>	<th class="filter">CPO</th>	<th>Customer Order No</th>	<th>Z-Feature</th><th class="filter">Style No.</th>	<th class="filter">Schedule No.</th>	<th>Colour</th>	<th>Actual Cut %</th><th>Ext Ship %</th><th>Order Total</th><th>Actual Total</th><th>Act Out %</th><th class="filter">Current Status</th><th>Rejection %</th><th>M3 Ship Qty</th><th>Total</th>	';

$table.= '<th>s01</th> <th>s02</th> <th>s03</th> <th>s04</th> <th>s05</th> <th>s06</th> <th>s07</th> <th>s08</th> <th>s09</th> <th>s10</th> <th>s11</th> <th>s12</th> <th>s13</th> <th>s14</th> <th>s15</th> <th>s16</th> <th>s17</th> <th>s18</th> <th>s19</th> <th>s20</th> <th>s21</th> <th>s22</th> <th>s23</th> <th>s24</th> <th>s25</th> <th>s26</th> <th>s27</th> <th>s28</th> <th>s29</th> <th>s30</th> <th>s31</th> <th>s32</th> <th>s33</th> <th>s34</th> <th>s35</th> <th>s36</th> <th>s37</th> <th>s38</th> <th>s39</th> <th>s40</th> <th>s41</th> <th>s42</th> <th>s43</th> <th>s44</th> <th>s45</th> <th>s46</th> <th>s47</th> <th>s48</th> <th>s49</th> <th>s50</th>';
}
else
{
//$table.= '<thead>';
//$table.= '<tr><td colspan=13>Shipment Details</td><td colspan=7> Sizes</td><td colspan=7>Shipment Details</td><td colspan=2>Sec1</td><td colspan=2>Sec2</td>		<td colspan=2>Sec3</td>		<td colspan=2>Sec4</td>		<td colspan=2>Sec5</td>		<td colspan=2>Sec6</td>	<td $highlight></td></tr>';

$table.= '<tr>
<th>S. No</th>	<th class="filter">Buyer Division</th>	<th class="filter">MPO</th>	<th class="filter">CPO</th>	<th>Customer Order No</th>	<th>Z-Feature</th><th class="filter">Style No.</th>	<th class="filter">Schedule No.</th>	<th>Colour</th>	<th>Actual Cut %</th><th>Ext Ship %</th><th>Order Total</th><th>Actual Total</th><th>Act Out %</th><th class="filter">Current Status</th><th>Rejection %</th><th>M3 Ship Qty</th><th>Total</th>	';
	$table.= '<th>XS</th>	<th>S</th>	<th>M</th>	<th>L</th>	<th>XL</th>	<th>XXL</th>	<th>XXXL</th>';
}
}

$table.= '<th class="filter">Ex Factory</th><th class="filter">Rev. Ex-Factory</th>	<th class="filter">Mode</th><th class="filter">Rev. Mode</th>	<th class="filter">Packing Method</th>	<th>Plan End Date</th>	<th class="filter">Exe. Sections</th><th>Embellishment</th><th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th><th>Plan Module</th><th>Actual Module</th><th>Planning Remarks</th><th>Production Remarks</th><th>Commitments</th></tr>';
$table.= '</thead><tbody>';

//TEMP Tables

$sql="Truncate week_delivery_plan_ref_temp";
//echo $sql;
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql="Truncate week_delivery_plan_temp";
//echo $sql;
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="insert into week_delivery_plan_ref_temp select * from bai_pro4.week_delivery_plan_ref $query";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="insert into week_delivery_plan_temp select * from week_delivery_plan where ref_id in (select ref_id from bai_pro4.week_delivery_plan_ref_temp $query)";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="insert into shipment_plan_ref_view select * from shipment_plan_ref where ship_tid in (select shipment_plan_id from week_delivery_plan_temp)";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

$table_ref3="shipment_plan_ref_view";

$table_ref="week_delivery_plan_ref_temp";
$table_ref2="week_delivery_plan_temp";

//TEMP Tables

$x=1;
//$sql="select * from week_delivery_plan where shipment_plan_id in (select ship_tid from week_delivery_plan_ref $query)";
$sql="select * from $table_ref2 where ref_id in (select ref_id from bai_pro4.$table_ref $query)";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
$edit_ref=$sql_row['ref_id'];
//$x=$edit_ref;
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
$act_rej=$sql_row['act_rej'];
$remarks=array();
$remarks=explode("^",$sql_row['remarks']);

//TEMP Enabled
$embl_tag=$sql_row['rev_emb_status'];
$rev_ex_factory_date=$sql_row['rev_exfactory']; 
$rev_mode=$sql_row['rev_mode']; 
if($rev_ex_factory_date=="0000-00-00")
{
	$rev_ex_factory_date="";
}

$executed_sec=array();
if($actu_sec1>0 or $plan_sec1>0){$executed_sec[]="1";}
if($actu_sec2>0 or $plan_sec2>0){$executed_sec[]="2";}
if($actu_sec3>0 or $plan_sec3>0){$executed_sec[]="3";}
if($actu_sec4>0 or $plan_sec4>0){$executed_sec[]="4";}
if($actu_sec5>0 or $plan_sec5>0){$executed_sec[]="5";}
if($actu_sec6>0 or $plan_sec6>0){$executed_sec[]="6";}

//$order_total=$size_xs+$size_s+$size_m+$size_l+$size_xl+$size_xxl+$size_xxxl+$size_s06+$size_s08+$size_s10+$size_s12+$size_s14+$size_s16+$size_s18+$size_s20+$size_s22+$size_s24+$size_s26+$size_s28+$size_s30;
$actu_total=$size_xs+$size_s+$size_m+$size_l+$size_xl+$size_xxl+$size_xxxl+$size_s01+$size_s02+$size_s03+$size_s04+$size_s05+$size_s06+$size_s07+$size_s08+$size_s09+$size_s10+$size_s11+$size_s12+$size_s13+$size_s14+$size_s15+$size_s16+$size_s17+$size_s18+$size_s19+$size_s20+$size_s21+$size_s22+$size_s23+$size_s24+$size_s25+$size_s26+$size_s27+$size_s28+$size_s29+$size_s30+$size_s31+$size_s32+$size_s33+$size_s34+$size_s35+$size_s36+$size_s37+$size_s38+$size_s39+$size_s40+$size_s41+$size_s42+$size_s43+$size_s44+$size_s45+$size_s46+$size_s47+$size_s48+$size_s49+$size_s50;
$plan_total=$actu_sec1+$actu_sec2+$actu_sec3+$actu_sec4+$actu_sec5+$actu_sec6+$actu_sec7+$actu_sec8+$actu_sec9;

$rej_per=0;




$order_total=0;

$sql1="select * from $table_ref3 where ship_tid=$shipment_plan_id";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$order_no=$sql_row1['order_no'];
	$delivery_no=$sql_row1['delivery_no'];
	$del_status=$sql_row1['del_status'];
	$mpo=trim($sql_row1['mpo']);
	$cpo=trim($sql_row1['cpo']);
	$buyer=trim($sql_row1['buyer']);
	$product=$sql_row1['product'];
	$buyer_division=trim($sql_row1['buyer_division']);
	$style=trim($sql_row1['style']);
	$schedule_no=$sql_row1['schedule_no'];
	$color=$sql_row1['color'];
	$size=$sql_row1['size'];
	$z_feature=$sql_row1['z_feature'];
	$ord_qty=$sql_row1['ord_qty'];
	//$order_total=$sql_row1['ord_qty_new'];
	
	//$ex_factory_date=$sql_row1['ex_factory_date']; //TEMP Disabled due to M3 Issue
	$mode=$sql_row1['mode'];
	$destination=$sql_row1['destination'];
	$packing_method=$sql_row1['packing_method'];
	$fob_price_per_piece=$sql_row1['fob_price_per_piece'];
	$cm_value=$sql_row1['cm_value'];
	$ssc_code=$sql_row1['ssc_code'];
	$order_tid=$sql_row1['ssc_code_new'];// for cut% variable
	$ship_tid=$sql_row1['ship_tid'];
	$week_code=$sql_row1['week_code'];
	$status=$sql_row1['status'];
	
	//Start Need to capture plan and actual module based on schedule number
	$sql12 = "select GROUP_CONCAT(DISTINCT plan_module) as module from bai_pro3.plandoc_stat_log where order_tid like '% $schedule_no%'";
	//$plan_mod = array();
	//echo $sql12;
	$query12 = mysqli_query($link, $sql12) or die("Sql Error 12".mysqli_error($GLOBALS["___mysqli_ston"]));
	
		while($row12 = mysqli_fetch_array($query12))
		{
			$plan_modu = $row12['module'];
		}
	if($plan_modu>0)
	{
		$plan_mod = $plan_modu;
	}
	else
	{
		$plan_mod = 0;
	}
	$sql13 = "SELECT GROUP_CONCAT(DISTINCT bac_no) as bac_no FROM bai_pro.bai_log_buf where delivery = '$schedule_no' and bac_qty>0";
	//$act_mod = array();
	$query13 = mysqli_query($link, $sql13) or die("Sql Error 13".mysqli_error($GLOBALS["___mysqli_ston"]));
	
		while($row13 = mysqli_fetch_array($query13))
		{
			$act_modu = $row13['bac_no'];
		}
	if($act_modu>0)
	{
		$act_mod = $act_modu;
	}
	else
	{
		$act_mod = 0;
	}
	
	//End Need to capture plan and actual module based on schedule number
	//TEMP Disabled due to M3 Issue
	//$embl_tag=embl_check($sql_row1['order_embl_a'].$sql_row1['order_embl_b'].$sql_row1['order_embl_c'].$sql_row1['order_embl_d'].$sql_row1['order_embl_e'].$sql_row1['order_embl_f'].$sql_row1['order_embl_g'].$sql_row1['order_embl_h']);
}

// open data from production review for cut%
for ($i=0; $i < sizeof($in_categories); $i++)
					{
						 $cat[]=$in_categories[$i];
					}
					$category = "'" .implode("','",$cat)."'" ;
$sql1z="select * from bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and category in ($category) and purwidth>0";
//echo $sql1z."<br>";
mysqli_query($link, $sql1z) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result1z=mysqli_query($link, $sql1z) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1z=mysqli_fetch_array($sql_result1z))
{
	$CID=$sql_row1z['tid'];
}

$sqlc="SELECT cuttable_percent as cutper from bai_pro3.cuttable_stat_log where cat_id=$CID";
//echo $sqlc;
$sql_resultc=mysqli_query($link, $sqlc) or exit("Sql Error41".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowc=mysqli_fetch_array($sql_resultc))
{
	$cut_per=$sql_rowc['cutper'];
	//echo "cut_per=".$cut_per;
}

$sqla="select * from bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
$sql_resulta=mysqli_query($link, $sqla) or exit("Sql Error51".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_confirma=mysqli_num_rows($sql_resulta);

if($sql_num_confirma>0)
{
	$sqlza="select * from bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
}
else
{
	$sqlza="select * from bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
}
mysqli_query($link, $sqlza) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_resultza=mysqli_query($link, $sqlza) or exit("Sql Error61".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowza=mysqli_fetch_array($sql_resultza))
{
	
	$o_xs=$sql_rowza['order_s_xs'];
	$o_s=$sql_rowza['order_s_s'];
	$o_m=$sql_rowza['order_s_m'];
	$o_l=$sql_rowza['order_s_l'];
	$o_xl=$sql_rowza['order_s_xl'];
	$o_xxl=$sql_rowza['order_s_xxl'];
	$o_xxxl=$sql_rowza['order_s_xxxl'];
	$act_cut_val=$sql_rowza['act_cut'];
	
	if($act_rej==0)
	{
		$act_rej=$sql_rowza["act_rej"];
	}
	
	$total_ord=$sql_rowza["old_order_s_xs"]+$sql_rowza["old_order_s_s"]+$sql_rowza["old_order_s_m"]+$sql_rowza["old_order_s_l"]+$sql_rowza["old_order_s_xl"]+$sql_rowza["old_order_s_xxl"]+$sql_rowza["old_order_s_xxxl"]+$sql_rowza["old_order_s_s01"]+$sql_rowza["old_order_s_s02"]+$sql_rowza["old_order_s_s03"]+$sql_rowza["old_order_s_s04"]+$sql_rowza["old_order_s_s05"]+$sql_rowza["old_order_s_s06"]+$sql_rowza["old_order_s_s07"]+$sql_rowza["old_order_s_s08"]+$sql_rowza["old_order_s_s09"]+$sql_rowza["old_order_s_s10"]+$sql_rowza["old_order_s_s11"]+$sql_rowza["old_order_s_s12"]+$sql_rowza["old_order_s_s13"]+$sql_rowza["old_order_s_s14"]+$sql_rowza["old_order_s_s15"]+$sql_rowza["old_order_s_s16"]+$sql_rowza["old_order_s_s17"]+$sql_rowza["old_order_s_s18"]+$sql_rowza["old_order_s_s19"]+$sql_rowza["old_order_s_s20"]+$sql_rowza["old_order_s_s21"]+$sql_rowza["old_order_s_s22"]+$sql_rowza["old_order_s_s23"]+$sql_rowza["old_order_s_s24"]+$sql_rowza["old_order_s_s25"]+$sql_rowza["old_order_s_s26"]+$sql_rowza["old_order_s_s27"]+$sql_rowza["old_order_s_s28"]+$sql_rowza["old_order_s_s29"]+$sql_rowza["old_order_s_s30"]+$sql_rowza["old_order_s_s31"]+$sql_rowza["old_order_s_s32"]+$sql_rowza["old_order_s_s33"]+$sql_rowza["old_order_s_s34"]+$sql_rowza["old_order_s_s35"]+$sql_rowza["old_order_s_s36"]+$sql_rowza["old_order_s_s37"]+$sql_rowza["old_order_s_s38"]+$sql_rowza["old_order_s_s39"]+$sql_rowza["old_order_s_s40"]+$sql_rowza["old_order_s_s41"]+$sql_rowza["old_order_s_s42"]+$sql_rowza["old_order_s_s43"]+$sql_rowza["old_order_s_s44"]+$sql_rowza["old_order_s_s45"]+$sql_rowza["old_order_s_s46"]+$sql_rowza["old_order_s_s47"]+$sql_rowza["old_order_s_s48"]+$sql_rowza["old_order_s_s49"]+$sql_rowza["old_order_s_s50"];
	
	$total_qty_ord=$sql_rowza["order_s_xs"]+$sql_rowza["order_s_s"]+$sql_rowza["order_s_m"]+$sql_rowza["order_s_l"]+$sql_rowza["order_s_xl"]+$sql_rowza["order_s_xxl"]+$sql_rowza["order_s_xxxl"]+$sql_rowza["order_s_s01"]+$sql_rowza["order_s_s02"]+$sql_rowza["order_s_s03"]+$sql_rowza["order_s_s04"]+$sql_rowza["order_s_s05"]+$sql_rowza["order_s_s06"]+$sql_rowza["order_s_s07"]+$sql_rowza["order_s_s08"]+$sql_rowza["order_s_s09"]+$sql_rowza["order_s_s10"]+$sql_rowza["order_s_s11"]+$sql_rowza["order_s_s12"]+$sql_rowza["order_s_s13"]+$sql_rowza["order_s_s14"]+$sql_rowza["order_s_s15"]+$sql_rowza["order_s_s16"]+$sql_rowza["order_s_s17"]+$sql_rowza["order_s_s18"]+$sql_rowza["order_s_s19"]+$sql_rowza["order_s_s20"]+$sql_rowza["order_s_s21"]+$sql_rowza["order_s_s22"]+$sql_rowza["order_s_s23"]+$sql_rowza["order_s_s24"]+$sql_rowza["order_s_s25"]+$sql_rowza["order_s_s26"]+$sql_rowza["order_s_s27"]+$sql_rowza["order_s_s28"]+$sql_rowza["order_s_s29"]+$sql_rowza["order_s_s30"]+$sql_rowza["order_s_s31"]+$sql_rowza["order_s_s32"]+$sql_rowza["order_s_s33"]+$sql_rowza["order_s_s34"]+$sql_rowza["order_s_s35"]+$sql_rowza["order_s_s36"]+$sql_rowza["order_s_s37"]+$sql_rowza["order_s_s38"]+$sql_rowza["order_s_s39"]+$sql_rowza["order_s_s40"]+$sql_rowza["order_s_s41"]+$sql_rowza["order_s_s42"]+$sql_rowza["order_s_s43"]+$sql_rowza["order_s_s44"]+$sql_rowza["order_s_s45"]+$sql_rowza["order_s_s46"]+$sql_rowza["order_s_s47"]+$sql_rowza["order_s_s48"]+$sql_rowza["order_s_s49"]+$sql_rowza["order_s_s50"];
	if($total_ord>0)
	{
		$extra_ship_ord=round(($total_qty_ord-$total_ord)*100/$total_ord,0);
	}
	else
	{
		$extra_ship_ord = 0;
	}
	
	$order_date=$sql_rowza["order_date"];
}

// Ticket #222648 / Add the Actual Out% and Ext Ship%  and Modify the Act Cut% in weekly delivery report
if($total_ord>0)
{
$act_cut_per=(100+round(($act_cut_val-$total_ord)*100/$total_ord,0))."%";
$ext_cut_per=round(($total_qty_ord-$total_ord)*100/$total_ord,0)."%";
}
else
{
	$act_cut_per=(0)."%";
	$ext_cut_per=(0)."%";
}

if($plan_total>0)
 {
$rej_per=round(($act_rej/$plan_total)*100,1)."%"."</br>";
}

$cutper=(100+$cut_per+$extra_ship_ord)."%";  //For Cut % as Production Review Sheet

// close data from production review 

//EMB stat 20111201

if(date("Y-m-d")>"2011-12-11")
{
	$embl_tag="";
	$sql1="select order_embl_a,order_embl_e from bai_pro3.bai_orders_db where order_del_no=\"$schedule_no\"";
	mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		if($sql_row1['order_embl_a']==1)
		{
			$embl_tag="Panle Form*";
		}
		if($sql_row1['order_embl_e']==1)
		{
			$embl_tag="Garment Form*";
		}
	}
}

//EMB stat

$order_total=$sql_row['original_order_qty'];



//Status
{

$sql1="select * from bai_pro4.$table_ref  where ship_tid=$shipment_plan_id";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
$priority=$sql_row1['priority'];
$cut=$sql_row1['act_cut'];
$in=$sql_row1['act_in'];
$out=$sql_row1['output'];
$pendingcarts=$sql_row1['cart_pending'];
$order=$sql_row1['ord_qty_new'];
$fcamca=$sql_row1['act_mca'];
$fgqty=$sql_row1['act_fg'];
$internal_audited=$sql_row1['act_fca'];

//date:2012-04-30
//changed code for exfactory date

//$ex_factory_date=$sql_row1['ex_factory_date_new'];
//$ex_factory_date=$sql_row1['m3_ship_plan_ex_fact']; //2012-08 based on Kiran (Plannind)) Feedbac
$ex_factory_date=$sql_row1['act_exfact'];
}
/*
// Open Actual Cut percent (LIVE)
if($order>0)
{
$act_cut_per=round(($cut/$order)*100,0)."%"; 
}
// close Actual Cut percent (LIVE)
*/

// Ticket #222648 / Add the Actual Out% and Ext Ship%  and Modify the Act Cut% in weekly delivery report
if($total_ord>0)
{
	$act_out_per=round(($out/$total_ord)*100,2)."%";
}	
else
{
	$act_out_per=(0)."%";
}

$status="NIL";
if($cut==0)
{
	$status="RM";
}
else
{
	if($cut>0 and $in==0)
	{
		$status="Cutting";
	}
	else
	{
		if($in>0)
		{
			$status="Sewing";
		}
	}
}
if($out>=$fgqty and $out>0 and $fgqty>=$order) //due to excess percentage of shipment over order qty
{
	$status="FG";
}
if($out>=$order and $out>0 and $fgqty<$order)
{
	$status="Packing";
}

if($status=="FG" and $internal_audited>=$fgqty)
{
	$status="FCA";
}

//DISPATCH

	$sql1="select ship_qty from bai_pro2.style_status_summ where sch_no=\"$schedule_no\"";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$ship_qty=$sql_row1['ship_qty'];
	}
	
	if($status=="FG" and $fgqty>=$ship_qty and $ship_qty>=$order)
	{
		$status="Dispatched";
	}
	if($priority==-1 and $status=="FG")
			{
				$status="Shipped";
			}
	
	//$table.= $ship_tid."-".$schedule_no."-".$status."-".$priority."-".$cut."-".$in."-".$out."-".$pendingcarts."-".$order."-".$fcamca."-".$fgqty."-".$$internal_audited."<br/>";
//DISPATCH
}

//Status

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


//Restricted Editing for Packing Team

$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=$username_list[1];
$authorized=array("muralim","kirang","sureshn","sasidharch","edwinr","lilanku"); //For Packing
$authorized2=array("muralim","kirang","baiuser");

/*if(strtolower($remarks[0])=="hold")
{
	$highlight=" bgcolor=\"#ff6f6f\" ";
}
else
{
	if(strtolower($remarks[0])=="$")
	{
		$highlight=" bgcolor=\"#79ee80\" ";
	}
	else
	{
		if(strtolower($remarks[0])=="short")
		{
			$highlight=" bgcolor=\"#def156\" ";
		}
		else
		{
			$highlight="";
		}
	}
}*/

//CR#930 //Fetching the color code of selected reason.
	$color_code_ref1="#FFFFFF";
	$sql_res1="select * from weekly_cap_reasons where sno=\"".$remarks[0]."\"";
	//echo $sql_res1."<br>";
	$sql_result_res1=mysqli_query($link, $sql_res1) or exit("Sql Error".$sql_res1."-".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row_res1=mysqli_fetch_array($sql_result_res1))
	{
		$color_code_ref1=$sql_row_res1["color_code"];		
	}
	
	$highlight=" bgcolor=\"".$color_code_ref1."\" ";

/*
if($order_total!=$actu_total)
{
	$highlight=" bgcolor=\"yellow\" ";
}
*/

//CR#930 //Displaying the Reasons List to Users for selecting the appropriate reason of the schedule.
$reason_ref2="";
$sql_res2="select * from weekly_cap_reasons where sno=\"".$remarks[0]."\"";
//echo $sql_res1."<br>";
$sql_result_res2=mysqli_query($link, $sql_res2) or exit("Sql Error".$sql_res2."-".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row_res2=mysqli_fetch_array($sql_result_res2))
{
	$reason_ref2=$sql_row_res2["reason"];		
}
//$edit_rem3="".$reason_ref2."";
$remarks[0]=$reason_ref2;

//Allowed only Packing team and timings to update between 8-10 and 4-6
if(in_array(strtolower($username),$authorized) and ((date("H")<=10 and date("H")>=8) or (date("H")<=18 and date("H")>=16)))
{
	
	$edit_rem="<td class=\"editable\" rel=\"B$edit_ref\">".$remarks[1]."</td>";
}
else
{
	//$edit_rem="<td $highlight>".$remarks[1]."</td>";
	$edit_rem="<td $highlight>".$remarks[1]."</td>";
}


if(!(in_array(strtolower($username),$authorized2)))
{
	$edit_rem2="<td $highlight>".$remarks[2]."</td>";
}
else
{
	//$edit_rem="<td $highlight>".$remarks[1]."</td>";
	$edit_rem2="<td class=\"editable\" rel=\"C$edit_ref\">".$remarks[2]."</td>";
}
//Restricted Editing for Packing Team

if($pending==1)
{
	if($order_total>$actu_total)
	{


		if($division=="All" )
		{
			$table.= "<tr><td $highlight> $x  </td>	<td $highlight>$buyer_division</td>	<td $highlight>$mpo</td>	<td $highlight>$cpo</td>	<td $highlight>$order_no</td>	<td $highlight>$z_feature</td><td $highlight>$style</td>	<td $highlight>$schedule_no</td>	<td $highlight>$color</td>	<td$highlight>$act_cut_per</td><td$highlight>$ext_cut_per</td><td $highlight>$order_total</td><td $highlight>$plan_total</td><td $highlight>$act_out_per</td><td $highlight>$status</td><td$highlight>$rej_per</td><td$highlight>$ship_qty</td><td $highlight>$actu_total</td>	<td $highlight>$size_xs</td>	<td $highlight>$size_s</td>	<td $highlight>$size_m</td>	<td $highlight>$size_l</td>	<td $highlight>$size_xl</td>	<td $highlight>$size_xxl</td>	<td $highlight>$size_xxxl</td><td $highlight>$size_s01</td><td $highlight>$size_s02</td><td $highlight>$size_s03</td><td $highlight>$size_s04</td><td $highlight>$size_s05</td><td $highlight>$size_s06</td><td $highlight>$size_s07</td><td $highlight>$size_s08</td><td $highlight>$size_s09</td><td $highlight>$size_s10</td><td $highlight>$size_s11</td><td $highlight>$size_s12</td><td $highlight>$size_s13</td><td $highlight>$size_s14</td><td $highlight>$size_s15</td><td $highlight>$size_s16</td><td $highlight>$size_s17</td><td $highlight>$size_s18</td><td $highlight>$size_s19</td><td $highlight>$size_s20</td><td $highlight>$size_s21</td><td $highlight>$size_s22</td><td $highlight>$size_s23</td><td $highlight>$size_s24</td><td $highlight>$size_s25</td><td $highlight>$size_s26</td><td $highlight>$size_s27</td><td $highlight>$size_s28</td><td $highlight>$size_s29</td><td $highlight>$size_s30</td><td $highlight>$size_s31</td><td $highlight>$size_s32</td><td $highlight>$size_s33</td><td $highlight>$size_s34</td><td $highlight>$size_s35</td><td $highlight>$size_s36</td><td $highlight>$size_s37</td><td $highlight>$size_s38</td><td $highlight>$size_s39</td><td $highlight>$size_s40</td><td $highlight>$size_s41</td><td $highlight>$size_s42</td><td $highlight>$size_s43</td><td $highlight>$size_s44</td><td $highlight>$size_s45</td><td $highlight>$size_s46</td><td $highlight>$size_s47</td><td $highlight>$size_s48</td><td $highlight>$size_s49</td><td $highlight>$size_s50</td><td $highlight>$ex_factory_date</td><td $highlight>$rev_ex_factory_date</td>	<td $highlight>$mode</td><td $highlight>$rev_mode</td>	<td $highlight>$packing_method</td>	<td $highlight>$plan_comp_date</td><td $highlight>".implode(",",$executed_sec)."</td><td $highlight>$embl_tag</td>	<td $highlight>$plan_sec1</td>	<td $highlight>$actu_sec1</td>	<td $highlight>$plan_sec2</td>	<td $highlight>$actu_sec2</td>	<td $highlight>$plan_sec3</td>	<td $highlight>$actu_sec3</td>	<td $highlight>$plan_sec4</td>	<td $highlight>$actu_sec4</td>	<td $highlight>$plan_sec5</td>	<td $highlight>$actu_sec5</td>	<td $highlight>$plan_sec6</td>	<td $highlight>$actu_sec6</td><td $highlight>".$plan_mod."</td>	<td $highlight>".$act_mod."</td>	<td $highlight>".$remarks[0]."</td>".$edit_rem.$edit_rem2."</tr>";
		}
		else
		{
			
		
		if($division=="M&" or $division=="CK")
		{
		$table.= "<tr><td $highlight> $x  </td>	<td $highlight>$buyer_division</td>	<td $highlight>$mpo</td>	<td $highlight>$cpo</td>	<td $highlight>$order_no</td>	<td $highlight>$z_feature</td><td $highlight>$style</td>	<td $highlight>$schedule_no</td>	<td $highlight>$color</td><td$highlight>$act_cut_per</td><td$highlight>$ext_cut_per</td>	<td $highlight>$order_total</td><td $highlight>$plan_total</td><td $highlight>$act_out_per</td><td $highlight>$status</td><td$highlight>$rej_per</td><td$highlight>$ship_qty</td><td $highlight>$actu_total</td><td $highlight>$size_s01</td><td $highlight>$size_s02</td><td $highlight>$size_s03</td><td $highlight>$size_s04</td><td $highlight>$size_s05</td><td $highlight>$size_s06</td><td $highlight>$size_s07</td><td $highlight>$size_s08</td><td $highlight>$size_s09</td><td $highlight>$size_s10</td><td $highlight>$size_s11</td><td $highlight>$size_s12</td><td $highlight>$size_s13</td><td $highlight>$size_s14</td><td $highlight>$size_s15</td><td $highlight>$size_s16</td><td $highlight>$size_s17</td><td $highlight>$size_s18</td><td $highlight>$size_s19</td><td $highlight>$size_s20</td><td $highlight>$size_s21</td><td $highlight>$size_s22</td><td $highlight>$size_s23</td><td $highlight>$size_s24</td><td $highlight>$size_s25</td><td $highlight>$size_s26</td><td $highlight>$size_s27</td><td $highlight>$size_s28</td><td $highlight>$size_s29</td><td $highlight>$size_s30</td><td $highlight>$size_s31</td><td $highlight>$size_s32</td><td $highlight>$size_s33</td><td $highlight>$size_s34</td><td $highlight>$size_s35</td><td $highlight>$size_s36</td><td $highlight>$size_s37</td><td $highlight>$size_s38</td><td $highlight>$size_s39</td><td $highlight>$size_s40</td><td $highlight>$size_s41</td><td $highlight>$size_s42</td><td $highlight>$size_s43</td><td $highlight>$size_s44</td><td $highlight>$size_s45</td><td $highlight>$size_s46</td><td $highlight>$size_s47</td><td $highlight>$size_s48</td><td $highlight>$size_s49</td><td $highlight>$size_s50</td>
	<td $highlight>$ex_factory_date</td><td $highlight>$rev_ex_factory_date</td>	<td $highlight>$mode</td><td $highlight>$rev_mode</td>	<td $highlight>$packing_method</td>	<td $highlight>$plan_comp_date</td><td $highlight>".implode(",",$executed_sec)."</td><td $highlight>$embl_tag</td>	<td $highlight>$plan_sec1</td>	<td $highlight>$actu_sec1</td>	<td $highlight>$plan_sec2</td>	<td $highlight>$actu_sec2</td>	<td $highlight>$plan_sec3</td>	<td $highlight>$actu_sec3</td>	<td $highlight>$plan_sec4</td>	<td $highlight>$actu_sec4</td>	<td $highlight>$plan_sec5</td>	<td $highlight>$actu_sec5</td>	<td $highlight>$plan_sec6</td>	<td $highlight>$actu_sec6</td><td $highlight>".$plan_mod."</td>	<td $highlight>".$act_mod."</td>	<td $highlight>".$remarks[0]."</td>".$edit_rem.$edit_rem2."</tr>";
		}
		else
		{
			$table.= "<tr><td $highlight>  $x</td>	<td $highlight>$buyer_division</td>	<td $highlight>$mpo</td>	<td $highlight>$cpo</td>	<td $highlight>$order_no</td>	<td $highlight>$z_feature</td><td $highlight>$style</td>	<td $highlight>$schedule_no</td>	<td $highlight>$color</td><td$highlight>$act_cut_per</td><td$highlight>$ext_cut_per</td>	<td $highlight>$order_total</td><td $highlight>$plan_total</td><td $highlight>$act_out_per</td><td $highlight>$status</td><td$highlight>$rej_per</td><td$highlight>$ship_qty</td><td $highlight>$actu_total</td><td $highlight>$size_xs</td>	<td $highlight>$size_s</td>	<td $highlight>$size_m</td>	<td $highlight>$size_l</td>	<td $highlight>$size_xl</td>	<td $highlight>$size_xxl</td>	<td $highlight>$size_xxxl</td>	<td $highlight>$ex_factory_date</td><td $highlight>$rev_ex_factory_date</td>	<td $highlight>$mode</td><td $highlight>$rev_mode</td>	<td $highlight>$packing_method</td>	<td $highlight>$plan_comp_date</td><td $highlight>".implode(",",$executed_sec)."</td><td $highlight>$embl_tag</td>	<td $highlight>$plan_sec1</td>	<td $highlight>$actu_sec1</td>	<td $highlight>$plan_sec2</td>	<td $highlight>$actu_sec2</td>	<td $highlight>$plan_sec3</td>	<td $highlight>$actu_sec3</td>	<td $highlight>$plan_sec4</td>	<td $highlight>$actu_sec4</td>	<td $highlight>$plan_sec5</td>	<td $highlight>$actu_sec5</td>	<td $highlight>$plan_sec6</td>	<td $highlight>$actu_sec6</td><td $highlight>".$plan_mod."</td>	<td $highlight>".$act_mod."</td>	<td $highlight>".$remarks[0]."</td>".$edit_rem.$edit_rem2."</tr>";
		}
		}
	}
}
else
{
		if($division=="All" )
		{
			$table.= "<tr ><td $highlight> $x  </td>	<td $highlight>$buyer_division</td>	<td $highlight>$mpo</td>	<td $highlight>$cpo</td>	<td $highlight>$order_no</td>	<td $highlight>$z_feature</td><td $highlight>$style</td>	<td $highlight>$schedule_no</td>	<td $highlight>$color</td><td$highlight>$act_cut_per</td><td$highlight>$ext_cut_per</td>	<td $highlight>$order_total</td><td $highlight>$plan_total</td><td $highlight>$act_out_per</td><td $highlight>$status</td><td$highlight>$rej_per</td><td$highlight>$ship_qty</td><td $highlight>$actu_total</td><td $highlight>$size_xs</td>	<td $highlight>$size_s</td>	<td $highlight>$size_m</td>	<td $highlight>$size_l</td>	<td $highlight>$size_xl</td>	<td $highlight>$size_xxl</td>	<td $highlight>$size_xxxl</td><td $highlight>$size_s01</td><td $highlight>$size_s02</td><td $highlight>$size_s03</td><td $highlight>$size_s04</td><td $highlight>$size_s05</td><td $highlight>$size_s06</td><td $highlight>$size_s07</td><td $highlight>$size_s08</td><td $highlight>$size_s09</td><td $highlight>$size_s10</td><td $highlight>$size_s11</td><td $highlight>$size_s12</td><td $highlight>$size_s13</td><td $highlight>$size_s14</td><td $highlight>$size_s15</td><td $highlight>$size_s16</td><td $highlight>$size_s17</td><td $highlight>$size_s18</td><td $highlight>$size_s19</td><td $highlight>$size_s20</td><td $highlight>$size_s21</td><td $highlight>$size_s22</td><td $highlight>$size_s23</td><td $highlight>$size_s24</td><td $highlight>$size_s25</td><td $highlight>$size_s26</td><td $highlight>$size_s27</td><td $highlight>$size_s28</td><td $highlight>$size_s29</td><td $highlight>$size_s30</td><td $highlight>$size_s31</td><td $highlight>$size_s32</td><td $highlight>$size_s33</td><td $highlight>$size_s34</td><td $highlight>$size_s35</td><td $highlight>$size_s36</td><td $highlight>$size_s37</td><td $highlight>$size_s38</td><td $highlight>$size_s39</td><td $highlight>$size_s40</td><td $highlight>$size_s41</td><td $highlight>$size_s42</td><td $highlight>$size_s43</td><td $highlight>$size_s44</td><td $highlight>$size_s45</td><td $highlight>$size_s46</td><td $highlight>$size_s47</td><td $highlight>$size_s48</td><td $highlight>$size_s49</td><td $highlight>$size_s50</td>
	<td $highlight>$ex_factory_date</td><td $highlight>$rev_ex_factory_date</td>	<td $highlight>$mode</td><td $highlight>$rev_mode</td>	<td $highlight>$packing_method</td>	<td $highlight>$plan_comp_date</td><td $highlight>".implode(",",$executed_sec)."</td><td $highlight>$embl_tag</td>	<td $highlight>$plan_sec1</td>	<td $highlight>$actu_sec1</td>	<td $highlight>$plan_sec2</td>	<td $highlight>$actu_sec2</td>	<td $highlight>$plan_sec3</td>	<td $highlight>$actu_sec3</td>	<td $highlight>$plan_sec4</td>	<td $highlight>$actu_sec4</td>	<td $highlight>$plan_sec5</td>	<td $highlight>$actu_sec5</td>	<td $highlight>$plan_sec6</td>	<td $highlight>$actu_sec6</td><td $highlight>".$plan_mod."</td>	<td $highlight>".$act_mod."</td>	<td $highlight>".$remarks[0]."</td>".$edit_rem.$edit_rem2."</tr>";
		}
		else
		{
			
		
		if($division=="M&" or $division=="CK")
		{
		$table.= "<tr><td $highlight> $x  </td>	<td $highlight>$buyer_division</td>	<td $highlight>$mpo</td>	<td $highlight>$cpo</td>	<td $highlight>$order_no</td>	<td $highlight>$z_feature</td><td $highlight>$style</td>	<td $highlight>$schedule_no</td>	<td $highlight>$color</td><td$highlight>$act_cut_per</td><td$highlight>$ext_cut_per</td>	<td $highlight>$order_total</td><td $highlight>$plan_total</td><td $highlight>$act_out_per</td><td $highlight>$status</td><td$highlight>$rej_per</td><td$highlight>$ship_qty</td><td $highlight>$actu_total</td>	<td $highlight>$ex_factory_date</td><td $highlight>$rev_ex_factory_date</td>	<td $highlight>$mode</td><td $highlight>$rev_mode</td>	<td $highlight>$packing_method</td>	<td $highlight>$plan_comp_date</td><td $highlight>".implode(",",$executed_sec)."</td><td $highlight>$embl_tag</td>	<td $highlight>$plan_sec1</td>	<td $highlight>$actu_sec1</td>	<td $highlight>$plan_sec2</td>	<td $highlight>$actu_sec2</td>	<td $highlight>$plan_sec3</td>	<td $highlight>$actu_sec3</td>	<td $highlight>$plan_sec4</td>	<td $highlight>$actu_sec4</td>	<td $highlight>$plan_sec5</td>	<td $highlight>$actu_sec5</td>	<td $highlight>$plan_sec6</td>	<td $highlight>$actu_sec6</td>	<td $highlight>$size_s01</td><td $highlight>$size_s02</td><td $highlight>$size_s03</td><td $highlight>$size_s04</td><td $highlight>$size_s05</td><td $highlight>$size_s06</td><td $highlight>$size_s07</td><td $highlight>$size_s08</td><td $highlight>$size_s09</td><td $highlight>$size_s10</td><td $highlight>$size_s11</td><td $highlight>$size_s12</td><td $highlight>$size_s13</td><td $highlight>$size_s14</td><td $highlight>$size_s15</td><td $highlight>$size_s16</td><td $highlight>$size_s17</td><td $highlight>$size_s18</td><td $highlight>$size_s19</td><td $highlight>$size_s20</td><td $highlight>$size_s21</td><td $highlight>$size_s22</td><td $highlight>$size_s23</td><td $highlight>$size_s24</td><td $highlight>$size_s25</td><td $highlight>$size_s26</td><td $highlight>$size_s27</td><td $highlight>$size_s28</td><td $highlight>$size_s29</td><td $highlight>$size_s30</td><td $highlight>$size_s31</td><td $highlight>$size_s32</td><td $highlight>$size_s33</td><td $highlight>$size_s34</td><td $highlight>$size_s35</td><td $highlight>$size_s36</td><td $highlight>$size_s37</td><td $highlight>$size_s38</td><td $highlight>$size_s39</td><td $highlight>$size_s40</td><td $highlight>$size_s41</td><td $highlight>$size_s42</td><td $highlight>$size_s43</td><td $highlight>$size_s44</td><td $highlight>$size_s45</td><td $highlight>$size_s46</td><td $highlight>$size_s47</td><td $highlight>$size_s48</td><td $highlight>$size_s49</td><td $highlight>$size_s50</td><td $highlight>".$plan_mod."</td>	<td $highlight>".$act_mod."</td><td $highlight>".$remarks[0]."</td>".$edit_rem.$edit_rem2."</tr>";
		}
		else
		{
			$table.= "<tr><td $highlight> $x  </td>	<td $highlight>$buyer_division</td>	<td $highlight>$mpo</td>	<td $highlight>$cpo</td>	<td $highlight>$order_no</td>	<td $highlight>$z_feature</td><td $highlight>$style</td>	<td $highlight>$schedule_no</td>	<td $highlight>$color</td><td$highlight>$act_cut_per</td><td$highlight>$ext_cut_per</td>	<td $highlight>$order_total</td><td $highlight>$plan_total</td><td $highlight>$act_out_per</td><td $highlight>$status</td><td$highlight>$rej_per</td><td$highlight>$ship_qty</td><td $highlight>$actu_total</td><td $highlight>$size_xs</td>	<td $highlight>$size_s</td>	<td $highlight>$size_m</td>	<td $highlight>$size_l</td>	<td $highlight>$size_xl</td>	<td $highlight>$size_xxl</td>	<td $highlight>$size_xxxl</td>	<td $highlight>$ex_factory_date</td><td $highlight>$rev_ex_factory_date</td>	<td $highlight>$mode</td><td $highlight>$rev_mode</td>	<td $highlight>$packing_method</td>	<td $highlight>$plan_comp_date</td><td $highlight>".implode(",",$executed_sec)."</td><td $highlight>$embl_tag</td>	<td $highlight>$plan_sec1</td>	<td $highlight>$actu_sec1</td>	<td $highlight>$plan_sec2</td>	<td $highlight>$actu_sec2</td>	<td $highlight>$plan_sec3</td>	<td $highlight>$actu_sec3</td>	<td $highlight>$plan_sec4</td>	<td $highlight>$actu_sec4</td>	<td $highlight>$plan_sec5</td>	<td $highlight>$actu_sec5</td>	<td $highlight>$plan_sec6</td>	<td $highlight>$actu_sec6</td><td $highlight>".$plan_mod."</td>	<td $highlight>".$act_mod."</td>	<td $highlight>".$remarks[0]."</td>".$edit_rem.$edit_rem2."</tr>";
		}
		}
}


$x+=1;


}

$table.= '</tbody>';
$table.= '</table>';

	header("Content-type: application/x-msdownload"); 
		# replace excelfile.xls with whatever you want the filename to default to
		header("Content-Disposition: attachment; filename=WK_DEL_Current.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $table;
}
?>



</body>
</html>

