
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<!--<title>Extra Shipment Details Report</title>-->
<meta name="" content="">
<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">

<!--<script type="text/javascript" src="<?= '..'.getFullURL($_GET['r'],'datetimepicker_css.js','R') ?>"></script>-->
<script type="text/javascript">
	function check_date()
    {
		var from_date = document.getElementById("sdate").value;
		var to_date = document.getElementById("edate").value;
		
		if(to_date < from_date){
			sweetAlert('Start date should be less than End date','','warning');
			return false;
		}
		return true;
	}</script>

<style type="text/css" media="screen">

/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
<!--@import "<?= '../'.getFullURLLevel($_GET['r'],'common/css/TableFilter_EN/filtergrid.css',3,'R') ?>";-->

/*====================================================
	- General html elements
=====================================================*/
a {
	margin:0px; padding:0px;
}
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable1{
	font-size:12px;
}
th{ background-color:#29759C; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;}
</style>
<script language="javascript" type="text/javascript" src="<?= '../'.getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R') ?>"></script>
<link href="<?= getFullURLLevel($_GET['r'],'common/css/sfcs_styles.css',3,'R'); ?>" rel="stylesheet" type="text/css" />
</head>
<div class='panel panel-primary'><div class='panel-heading'><h3 class='panel-title'>Extra Shipment Details Report</h3></div><div class='panel-body'>
<?php 
// include '../'.getFullURL($_GET['r'],"header1_extra_shipment_details.php",'R');
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

?>
<?php
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
$dat=$_POST["dat1"];
$dat1=$_POST["dat2"];
// echo $dat.'---'.$dat1;

  echo "<form class='row' action='".getFullURL($_GET['r'],'index_data_old_new.php','N')."' method=\"post\">
			
	<div class='col-sm-3'>
	<b>Ex-factory Start Date</b><input class='form-control'  type=\"text\" data-toggle=\"datepicker\" size=\"8\" name=\"dat1\" id=\"sdate\" value=\"$dat\"/ ></div>";
	
	echo "

<div class='col-sm-3'>
<b>Ex-factory End Date&nbsp;&nbsp;	</b><input class='form-control' type=\"text\" data-toggle=\"datepicker\" size=\"8\" name=\"dat2\" id=\"edate\" value=\"$dat1\"/ ></div>";

	echo "<br/><input type=\"submit\" onclick='return check_date()' name=\"submit\" class='btn btn-success' value=\"Filter\"/>
</form>";

$addon_headings="";
$sql2="SELECT section_id as section_id,GROUP_CONCAT(DISTINCT workstation_code ORDER BY workstation_code*1) AS sec_mods FROM $pms.workstation group by section_id";

	$sql_result2=mysqli_query($link,$sql2) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$section=$sql_row2['section_id'];
		$sql3="SELECT section_name FROM $pms.sections where plant_code='$plant_code' and section_id='$section'";
		$sql_result3=mysqli_query($link,$sql3) or exit("$sql3".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row3=mysqli_fetch_array($sql_result3))
		{
			$section_name=$sql_row3['section_name'];
		}
		$addon_headings.="<th>SEC-".$section_name."<br/>Pending PCS</th>";	
		$addon_headings.="<th>SEC-".$section_name."<br/>Lost Value</th>";	
	}

$week_del="select schedule,planned_delivery_date,po_number from $oms.oms_mo_details where plant_code='$plant_code' and planned_delivery_date between \"$dat\" and \"$dat1\"  GROUP BY schedule";
// echo $week_del."<br>";
$sql_result=mysqli_query($link,$week_del) or exit("Sql Error2=".mysqli_error($GLOBALS["___mysqli_ston"]));
$count_rows=mysqli_num_rows($sql_result);
// if($count_rows > 0){
	echo "<br><div class='table-responsive' style='overflow:scroll'>";
	echo "<table  class='table table-bordered'>
	<thead>
	<tr>
	<th rowspan=2>Sno</th> 
	<th rowspan=2>Customer</th>
	<th rowspan=2>Style</th>
	<th rowspan=2>Schedule</th>
	<th rowspan=2>Color</th>
	<th colspan=2>Order Qty as per M3</th>
	<th rowspan=2>Garment Ex Fac</th>
	<th rowspan=2>Purchase width</th>
	<th colspan=2>System</th>
	<th colspan=2>Cad</th>
	<th colspan=2>Saving</th>
	<th colspan=2>Possible Qty can be ship</th>
	<th colspan=2>Shipped Qty as per AOD</th>
	<th rowspan=2>Shipped Qty as per M3</th>
	<th rowspan=2>Extra Ship Qty</th>
	<th rowspan=2>FOB Per Piece</th>
	<th rowspan=2>Total FOB <br>For Extrashipment</th>
	<th rowspan=2>Status</th>
	<th colspan=".((mysqli_num_rows($sql_result2)*2)+2).">Production Balances</th>
	<th colspan=2>Shipment Balances</th>
	</tr>
	<tr>
	<th>Size</th><th>Total Quantity</th><th>YY</th><th>Yards</th><th>YY</th><th>Yards</th><th>%</th><th>Yards</th><th>Size</th><th>Total Quantity</th><th>Size</th><th>Total Quantity</th>";

		echo "$addon_headings<th>Total Production<br/>Pendings</th>";
		echo "<th>Lost Value</th>";
		
		echo "<th>Total Shipment<br/>Pendings</th>";
		echo "<th>Lost Value</th>";
			
	echo " </tr></thead>";
	$x=0;
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$schdules[]=$sql_row["schedule"];
		$po_number[]=$sql_row["po_number"];
		$ex_fac_date[]=$sql_row["planned_delivery_date"];
		
	}

	$total_cost=0;
	// if($count_rows > 0)
	// {
		$total_sch=implode(",",$schdules);

	$week_del="select schedule,planned_delivery_date,po_number from $oms.oms_mo_details where plant_code='$plant_code' and planned_delivery_date between \"$dat\" and \"$dat1\"  and po_number!='' GROUP BY po_number";
	//echo $week_del."<br>";
	$sql_result=mysqli_query($link, $week_del) or exit("Sql Error3 =".mysqli_error($GLOBALS["___mysqli_ston"]));
	$count_rows=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$schdules[]=$sql_row["schedule"];
		$ex_fac_date[]=$sql_row["planned_delivery_date"];
		$po_number[]=$sql_row["po_number"];
	}
	$po_number="'".implode("','",$po_number)."'";
	

	$mp_order="select po_number from $pps.mp_sub_order where plant_code='$plant_code' and master_po_number in ($po_number)";
	// echo $po_del."<br>";
	$po_sql_result=mysqli_query($link, $mp_order) or exit("Sql Error36 =".mysqli_error($GLOBALS["___mysqli_ston"]));
	$count_rows1=mysqli_num_rows($po_sql_result);
	while($sql_row4=mysqli_fetch_array($po_sql_result))
	{
		$po_number1[]=$sql_row4["po_number"];
		
		
	}
	$po_number1="'".implode("','",$po_number1)."'";
	$po_del="select master_po_details_mo_quantity_id from $pps.mp_sub_mo_qty where po_number in($po_number1) and plant_code='$plant_code'";
	//echo $po_del."<br>";
	$po_sql_result=mysqli_query($link, $po_del) or exit("Sql Error31 =".mysqli_error($GLOBALS["___mysqli_ston"]));
	$count_rows1=mysqli_num_rows($po_sql_result);
	while($sql_row4=mysqli_fetch_array($po_sql_result))
	{
		$master_po_details_mo_quantity_id[]=$sql_row4["master_po_details_mo_quantity_id"];
		
		
	}
	$master_po_details_mo_quantity_id="'".implode("','",$master_po_details_mo_quantity_id)."'";
	$po_del_num="select master_po_details_id from $pps.mp_mo_qty where master_po_details_mo_quantity_id in ($master_po_details_mo_quantity_id) and plant_code='$plant_code'";
	//echo $po_del_num."<br>";
	$po_sql_result45=mysqli_query($link, $po_del_num) or exit("Sql Error32 =".mysqli_error($GLOBALS["___mysqli_ston"]));
	$count_rows45=mysqli_num_rows($po_sql_result45);
	while($sql_row45=mysqli_fetch_array($po_sql_result45))
	{
		$master_po_details_id[]=$sql_row45["master_po_details_id"];
		
		
	}
	$master_po_details_id="'".implode("','",$master_po_details_id)."'";
	$po_del1="select size,schedule,color,master_po_details_mo_quantity_id,sum(quantity) as quantity,master_po_details_id from $pps.mp_mo_qty where plant_code='$plant_code' and master_po_details_id in ($master_po_details_id) and master_po_order_qty_type='ORIGINAL_QUANTITY' group by size,schedule,color ";
	//echo $po_del1."<br>";
	$po_sql_result1=mysqli_query($link, $po_del1) or exit("Sql Error33 =".mysqli_error($GLOBALS["___mysqli_ston"]));
	$count_rows2=mysqli_num_rows($po_sql_result1);
	$slnum = 1;
	while($sql_row5=mysqli_fetch_array($po_sql_result1))
	{
		$size=$sql_row5["size"];
		$schedule=$sql_row5["schedule"];
		$color=$sql_row5["color"];
		$master_po_details_mo_quantity_id2=$sql_row5["master_po_details_mo_quantity_id"];
		$quantity=$sql_row5["quantity"];
		$master_po_details_id1=$sql_row5["master_po_details_id"];
		$po_style="select style from $pps.mp_color_detail where plant_code='$plant_code' and master_po_details_id='$master_po_details_id1'";
		$style_sql_result=mysqli_query($link, $po_style) or exit("Sql Error4 =".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row10=mysqli_fetch_array($style_sql_result)){
			$style=$sql_row10['style'];
		}


		$po_ex_date="select planned_delivery_date,buyer_desc from $oms.oms_mo_details where plant_code='$plant_code' and schedule='$schedule'";
		$po_ex_date_sql_result=mysqli_query($link, $po_ex_date) or exit("Sql Error4 =".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row111=mysqli_fetch_array($po_ex_date_sql_result)){
			$ex_date=$sql_row111['planned_delivery_date'];
			$buyer_desc=$sql_row111['buyer_desc'];
		}

		$get_purch_width1="select ratio_id from $pps.lp_ratio where plant_code='$plant_code' and po_number='$master_po_details_id1'";
		$get_purch_width_sql_result1=mysqli_query($link, $get_purch_width1) or exit("Sql Error4 =".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row11122=mysqli_fetch_array($get_purch_width_sql_result1)){
			$ratio_id=$sql_row11122['ratio_id'];
		}
		$get_purch_width="select jm_cut_job_id from $pps.jm_cut_job where plant_code='$plant_code' and ratio_id='$ratio_id'";
		$get_purch_width_sql_result=mysqli_query($link, $get_purch_width) or exit("Sql Error4 =".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1112=mysqli_fetch_array($get_purch_width_sql_result)){
			$jm_cut_job_id=$sql_row1112['jm_cut_job_id'];
			
		}

		$get_marker_version="select jm_docket_id,marker_version_id from $pps.jm_dockets where plant_code='$plant_code' and jm_cut_job_id='$jm_cut_job_id'";
		$get_marker_version_result=mysqli_query($link, $get_marker_version) or exit("Sql Error43 =".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row111222=mysqli_fetch_array($get_marker_version_result)){
			$jm_docket_id=$sql_row111222['jm_docket_id'];
			$marker_version_no=$sql_row111222['marker_version_id'];
		}
	

		$get_marker_version11="select length from $pps.lp_markers where plant_code='$plant_code' and marker_version_id='$marker_version_no'";	
		$get_marker_version_result11=mysqli_query($link, $get_marker_version11) or exit("Sql Error41 =".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row11122211=mysqli_fetch_array($get_marker_version_result11)){
			$length=$sql_row11122211['length'];
		}


		$get_mo_number="select mo_number from $oms.oms_mo_details where plant_code='$plant_code' and schedule='$schedule'";
		$get_mo_number_result=mysqli_query($link, $get_mo_number) or exit("Sql Error41 =".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row1=mysqli_fetch_array($get_mo_number_result)){
			$mo_number=$row1['mo_number'];
		}

		$get_consumption="select consumption from $oms.oms_mo_items where  mo_number='$mo_number'  AND operation_code='15'";
		$get_consumption_result=mysqli_query($link, $get_consumption) or exit("Sql Error41 =".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row2=mysqli_fetch_array($get_consumption_result)){
			$consumption=$row2['consumption'];
		}
		

		
	// {

	// $sql="select * from $bai_pro3.bai_orders_db_confirm where order_del_no in ($total_sch) and order_no=\"1\" order by order_del_no";
	// //echo $sql."<br>";
	// $sql_result=mysqli_query($link, $sql) or exit("Sql Error4 =".mysqli_error($GLOBALS["___mysqli_ston"]));
	// $slnum = 1;
	// while($sql_row=mysqli_fetch_array($sql_result))
	// {
	// 	$x=$x+1; 
	// 	if($x%2==0)
	// 	{
	// 		//$id="#c0c0c0";
	// 		$id="#D0D0D0";
	// 	}
	// 	else
	// 	{
	// 		$id="#ffffff";
	// 	}
		// $s01_ord_quan=$sql_row['order_s_s01'];
		// $s02_ord_quan=$sql_row['order_s_s02'];
		// $s03_ord_quan=$sql_row['order_s_s03'];
		// $s04_ord_quan=$sql_row['order_s_s04'];
		// $s05_ord_quan=$sql_row['order_s_s05'];
		// $s06_ord_quan=$sql_row['order_s_s06'];
		// $s07_ord_quan=$sql_row['order_s_s07'];
		// $s08_ord_quan=$sql_row['order_s_s08'];
		// $s09_ord_quan=$sql_row['order_s_s09'];
		// $s10_ord_quan=$sql_row['order_s_s10'];
		// $s11_ord_quan=$sql_row['order_s_s11'];
		// $s12_ord_quan=$sql_row['order_s_s12'];
		// $s13_ord_quan=$sql_row['order_s_s13'];
		// $s14_ord_quan=$sql_row['order_s_s14'];
		// $s15_ord_quan=$sql_row['order_s_s15'];
		// $s16_ord_quan=$sql_row['order_s_s16'];
		// $s17_ord_quan=$sql_row['order_s_s17'];
		// $s18_ord_quan=$sql_row['order_s_s18'];
		// $s19_ord_quan=$sql_row['order_s_s19'];
		// $s20_ord_quan=$sql_row['order_s_s20'];
		// $s21_ord_quan=$sql_row['order_s_s21'];
		// $s22_ord_quan=$sql_row['order_s_s22'];
		// $s23_ord_quan=$sql_row['order_s_s23'];
		// $s24_ord_quan=$sql_row['order_s_s24'];
		// $s25_ord_quan=$sql_row['order_s_s25'];
		// $s26_ord_quan=$sql_row['order_s_s26'];
		// $s27_ord_quan=$sql_row['order_s_s27'];
		// $s28_ord_quan=$sql_row['order_s_s28'];
		// $s29_ord_quan=$sql_row['order_s_s29'];
		// $s30_ord_quan=$sql_row['order_s_s30'];
		// $s31_ord_quan=$sql_row['order_s_s31'];
		// $s32_ord_quan=$sql_row['order_s_s32'];
		// $s33_ord_quan=$sql_row['order_s_s33'];
		// $s34_ord_quan=$sql_row['order_s_s34'];
		// $s35_ord_quan=$sql_row['order_s_s35'];
		// $s36_ord_quan=$sql_row['order_s_s36'];
		// $s37_ord_quan=$sql_row['order_s_s37'];
		// $s38_ord_quan=$sql_row['order_s_s38'];
		// $s39_ord_quan=$sql_row['order_s_s39'];
		// $s40_ord_quan=$sql_row['order_s_s40'];
		// $s41_ord_quan=$sql_row['order_s_s41'];
		// $s42_ord_quan=$sql_row['order_s_s42'];
		// $s43_ord_quan=$sql_row['order_s_s43'];
		// $s44_ord_quan=$sql_row['order_s_s44'];
		// $s45_ord_quan=$sql_row['order_s_s45'];
		// $s46_ord_quan=$sql_row['order_s_s46'];
		// $s47_ord_quan=$sql_row['order_s_s47'];
		// $s48_ord_quan=$sql_row['order_s_s48'];
		// $s49_ord_quan=$sql_row['order_s_s49'];
		// $s50_ord_quan=$sql_row['order_s_s50'];
		// $sizes = array($s01_ord_quan,$s02_ord_quan,$s03_ord_quan,$s04_ord_quan,$s05_ord_quan,$s06_ord_quan,$s07_ord_quan,$s08_ord_quan,$s09_ord_quan,$s10_ord_quan,$s11_ord_quan,$s12_ord_quan,$s13_ord_quan,$s14_ord_quan,$s15_ord_quan,$s16_ord_quan,$s17_ord_quan,$s18_ord_quan,$s19_ord_quan,$s20_ord_quan,$s21_ord_quan,$s22_ord_quan,$s23_ord_quan, $s24_ord_quan, $s25_ord_quan, $s26_ord_quan, $s27_ord_quan, $s28_ord_quan, $s29_ord_quan, $s30_ord_quan, $s31_ord_quan, $s32_ord_quan, $s33_ord_quan, $s34_ord_quan, $s35_ord_quan, $s36_ord_quan, $s37_ord_quan, $s38_ord_quan, $s39_ord_quan, $s40_ord_quan, $s41_ord_quan, $s42_ord_quan, $s43_ord_quan, $s44_ord_quan, $s45_ord_quan, $s46_ord_quan, $s47_ord_quan, $s48_ord_quan, $s49_ord_quan, $s50_ord_quan);
		// //print_r($sizes);
		// $filtered_sizes = array_filter($sizes);
		
		// $old_order_quantity = array('old_order_s_s01','old_order_s_s02','old_order_s_s03', 'old_order_s_s04', 'old_order_s_s05', 'old_order_s_s06', 'old_order_s_s07', 'old_order_s_s08', 'old_order_s_s09', 'old_order_s_s10', 'old_order_s_s11', 'old_order_s_s12', 'old_order_s_s13', 'old_order_s_s14', 'old_order_s_s15','old_order_s_s16', 'old_order_s_s17', 'old_order_s_s18', 'old_order_s_s19', 'old_order_s_s20', 'old_order_s_s21', 'old_order_s_s22', 'old_order_s_s23', 'old_order_s_s24', 'old_order_s_s25', 'old_order_s_s26', 'old_order_s_s27', 'old_order_s_s28','old_order_s_s29', 'old_order_s_s30', 'old_order_s_s31',  'old_order_s_s32',  'old_order_s_s33', 'old_order_s_s34', 'old_order_s_s35', 'old_order_s_s36', 'old_order_s_s37', 'old_order_s_s38', 'old_order_s_s39', 'old_order_s_s40', 'old_order_s_s41',  'old_order_s_s42',  'old_order_s_s43', 'old_order_s_s44', 'old_order_s_s45', 'old_order_s_s46', 'old_order_s_s47', 'old_order_s_s48', 'old_order_s_s49', 'old_order_s_s50');
		
		// //$title_sizes = array('title_size_s01','title_size_s02','title_size_s06', 'title_size_s08', 'title_size_s10', 'title_size_s12', 'title_size_s14', 'title_size_s16', 'title_size_s18', 'title_size_s20', 'title_size_s22', 'title_size_s24', 'title_size_s26', 'title_size_s28', 'title_size_s30');
		// $title_sizes = array('title_size_s01','title_size_s02','title_size_s03', 'title_size_s04', 'title_size_s05', 'title_size_s06', 'title_size_s07', 'title_size_s08', 'title_size_s09', 'title_size_s10', 'title_size_s11', 'title_size_s12', 'title_size_s13', 'title_size_s14', 'title_size_s15','title_size_s16', 'title_size_s17', 'title_size_s18', 'title_size_s19', 'title_size_s20', 'title_size_s21', 'title_size_s22', 'title_size_s23', 'title_size_s24', 'title_size_s25', 'title_size_s26', 'title_size_s27', 'title_size_s28','title_size_s29', 'title_size_s30', 'title_size_s31',  'title_size_s32',  'title_size_s33', 'title_size_s34', 'title_size_s35', 'title_size_s36', 'title_size_s37', 'title_size_s38', 'title_size_s39', 'title_size_s40', 'title_size_s41',  'title_size_s42',  'title_size_s43', 'title_size_s44', 'title_size_s45', 'title_size_s46', 'title_size_s47', 'title_size_s48', 'title_size_s49', 'title_size_s50');
		// //$ship_title_sizes = array('ship_s_s01','ship_s_s02','ship_s_s06', 'ship_s_s08', 'ship_s_s10', 'ship_s_s12', 'ship_s_s14', 'ship_s_s16', 'ship_s_s18', 'ship_s_s20', 'ship_s_s22', 'ship_s_s24', 'ship_s_s26', 'ship_s_s28', 'ship_s_s30');
		// $ship_title_sizes = array('ship_s_s01','ship_s_s02','ship_s_s03', 'ship_s_s04', 'ship_s_s05', 'ship_s_s06', 'ship_s_s07', 'ship_s_s08', 'ship_s_s09', 'ship_s_s10', 'ship_s_s11', 'ship_s_s12', 'ship_s_s13', 'ship_s_s14', 'ship_s_s15','ship_s_s16', 'ship_s_s17', 'ship_s_s18', 'ship_s_s19', 'ship_s_s20', 'ship_s_s21', 'ship_s_s22', 'ship_s_s23', 'ship_s_s24', 'ship_s_s25', 'ship_s_s26', 'ship_s_s27', 'ship_s_s28','ship_s_s29', 'ship_s_s30', 'ship_s_s31',  'ship_s_s32',  'ship_s_s33', 'ship_s_s34', 'ship_s_s35', 'ship_s_s36', 'ship_s_s37', 'ship_s_s38', 'ship_s_s39', 'ship_s_s40', 'ship_s_s41',  'ship_s_s42',  'ship_s_s43', 'ship_s_s44', 'ship_s_s45', 'ship_s_s46', 'ship_s_s47', 'ship_s_s48', 'ship_s_s49', 'ship_s_s50');
		// $rowspan_for_shipqty = sizeof($filtered_sizes);
		// foreach($filtered_sizes as $key001 => $value001)
		// {
			
			// var_dump(sizeof($filtered_sizes));
			// echo $key001;
			//getting sizes using hardcoded array
			//$title_size = $sql_row[$title_sizes[$key001]];
			
			//getting Old Order Quantity using hardcoded array
			//$old_order_quan = $sql_row[$old_order_quantity[$key001]];
			
			//$order_quan = $value001;
		
			echo "<tr>";
			$order_tid=$sql_row["order_tid"];
			$sch=$sql_row["order_del_no"];
			echo "<td style=\"background:$id;\">$slnum</td>";
			echo "<td style=\"background:$id;\">".$buyer_desc."</td>"; 
			echo "<td style=\"background:$id;\">".$style."</td>"; 
			echo "<td style=\"background:$id;\">".$schedule."</td>";
			echo "<td style=\"background:$id;\">".$color."</td>";
			echo "<td style=\"background:$id;\">".$size."</td>";
			echo "<td style=\"background:$id;\">".$quantity."</td>";
			// $total=$sql_row["old_order_s_xs"]+$sql_row["old_order_s_s"]+$sql_row["old_order_s_m"]+$sql_row["old_order_s_l"]+$sql_row["old_order_s_xl"];
			$order_date="";
			
			//Exfactory date dispaly 	
			
			// $size=sizeof($order_date)-1;
			$order_date=$ex_fac_date[array_search($sch,$schdules)];
			
			echo "<td style=\"background:$id;\">".$ex_date."</td>";	
			
			// calculate system yards for 
			// $sql1="select tid,purwidth,catyy from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and category in ($in_categories) and mo_status=\"Y\" and purwidth > 0";
			// //echo $sql1."<br>";
			// $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
			// if(mysqli_num_rows($sql_result1) > 0){
			// 	while($sql_row1=mysqli_fetch_array($sql_result1))
			// 	{
					$cat_tid=$sql_row1["tid"];
					echo "<td style=\"background:$id;\">".$length."</td>";
					echo "<td style=\"background:$id;\">".$consumption."</td>"; 
					$sys_yrds=$length*$quantity;
					echo "<td style=\"background:$id;\">".$sys_yrds."</td>";
			// 	}
			// }else{
			// 	echo "<td></td>";
			// 	echo "<td></td>";
			// 	echo "<td></td>";
			// }
			
			
			//calculate yards for extar shipment
			// $plies="";
			// $allcate_tid="";
			// $sql2="SELECT tid,plies FROM $bai_pro3.allocate_stat_log WHERE cat_ref=\"$cat_tid\" order by tid";
			// // echo $sql2."<br>";
			// $sql_result2=mysqli_query($link,$sql2) or exit("Sql Error6=".mysqli_error($GLOBALS["___mysqli_ston"]));
			// while($sql_row2=mysqli_fetch_array($sql_result2))
			// {
			// 	$allcate_tid[]=$sql_row2["tid"];
			// 	$plies[]=$sql_row2["plies"];
			// }
			
			// //Calculating marker Length
			
			// // $markereff="";
			// if(sizeof($allcate_tid) > 0)
			// {
			// 	$allcate_tid_implode=implode(",",$allcate_tid);
				
			// }
			// else
			// {
			// 	$allcate_tid_implode=0;	
			// }
			
			// $sql3="SELECT mklength FROM $bai_pro3.maker_stat_log WHERE allocate_ref in ($allcate_tid_implode) ORDER BY allocate_ref";
			

			// $sql_result3=mysqli_query($link, $sql3) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
			// while($sql_row3=mysqli_fetch_array($sql_result3))
			// {
			// 	$markereff[]=$sql_row3["mklength"];
			// }
			
			// $total_cad_yrds=0;
			
			// for($i=0;$i<sizeof($plies);$i++)
			// {
			// 	$total_cad_yrds=$total_cad_yrds+($plies[$i]*$markereff[$i]);
			// 	if($total != 0)
			// 	{
			// 		$cad_yy=round($total_cad_yrds/$total,4);
			// 	}
			// 	else
			// 	{
			// 		$cad_yy=0;
			// 	}
				
			// }
			
			$total_cad_yrds_new=round($total_cad_yrds,0);
			echo "<td style=\"background:$id;\">".$consumption."</td>";
			echo "<td style=\"background:$id;\">".$sys_yrds."</td>";
			
			//savings calculation
			if($sys_yy != 0)
			{
				$savings=round(($sys_yy-$cad_yy)*100/$sys_yy,0);
			}
			else
			{
				$savings=0;
			}
			//$savings=round(($sys_yy-$cad_yy)*100/$sys_yy,0);
			echo "<td style=\"background:$id;\">".$savings."%</td>";
			$savings_yards=$sys_yrds-$total_cad_yrds_new;
			echo "<td style=\"background:$id;\">".round($savings_yards,0)."</td>";
			
			echo "<td style=\"background:$id;\">".$size."</td>";
			echo "<td style=\"background:$id;\">".$quantity."</td>";
		
			
			$ext_qty=$total_qty-$total;	
			
			$extra_ship_qty="select sum(quantity) as quantity,master_po_details_id from $pps.mp_mo_qty where plant_code='$plant_code' and master_po_details_id in ($master_po_details_id) and master_po_order_qty_type='EXTRA_SHIPMENT' group by size,schedule,color ";
			$extra_ship_qty_result4=mysqli_query($link, $extra_ship_qty) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
			// $total_rows=mysqli_num_rows($sql_result4);
			while($sql_row000111 = mysqli_fetch_array($extra_ship_qty_result4))
			{
				$extra_qty = $sql_row000111['quantity'];
			}
			//shipemet details
		
			// $sql4="SELECT SUM($ship_title_sizes[$key001]) as shipped_qty FROM $pps.ship_stat_log WHERE plant_code='$plantcode' and ship_schedule=\"$sch\" and ship_status=\"2\"";

			// $sql_result4=mysqli_query($link, $sql4) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
			// $total_rows=mysqli_num_rows($sql_result4);
			// while($sql_row00011 = mysqli_fetch_array($sql_result4))
			// {
			// 	$ship_qty = $sql_row00011['shipped_qty'];
			// }
			echo "<td style=\"background:$id;\">".$title_size."</td>";
			echo "<td style=\"background:$id;\">".$ship_qty."</td>";

			//M3 shipment quantity
			// if(($rowspan_for_shipqty-$key001) == $rowspan_for_shipqty)
			// {
				$sql5="SELECT SUM(ship_qty) FROM $pps.style_status_summ WHERE plant_code='$plantcode' and sch_no=\"$sch\"";
				// echo $sql5."<br>";
				$sql_result5=mysqli_query($link, $sql5) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
				$total_rows1=mysqli_num_rows($sql_result5);
				while($sql_row5=mysqli_fetch_array($sql_result5))
				{
			// 		$m3_total=$sql_row5["SUM(ship_qty)"];
					echo "<td>".round($sql_row5["SUM(ship_qty)"],0)."</td>";
				}
			
			
			echo "<td style=\"background:$id;\">".$extra_qty."</td>";
			
			$sql2="select distinct(fob_price_per_piece) from $bai_pro4.shipment_plan_ref where schedule_no=\"$sch\"";
			// echo $sql2;
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$fob=$sql_row2["fob_price_per_piece"];		
			}	
			
			echo "<td style=\"background:$id;\">".$fob."$</td>";
			
			$cost=$extra_qty*$fob;
			
			$cost1[]=$ext_qty*$fob;
			
			echo "<td style=\"background:$id;\">".$cost."$</td>";
			
			$total_cost=$total_cost+$cost;
			
			if($x%2==0)
			{
				$id1="#c0c0c0";
			}
			else
			{
				$id1="#ff0000";
			}
			
			if($total_rows1 > 0)
			{
				if($m3_total == $ship_total)
				{
					$id1="#00ff00";
				}		
				else
				{
					$id1="#ff0000";
				}
			}	
			
			//dispatch status
			if($total_rows > 0)
			{
				if($total < $ship_total)
				{
					echo "<td style=\"background:$id1;\">Extra Ship</td>";
				}
				else if($total == $ship_total)
				{
					echo "<td style=\"background:$id1;\">Order Ship</td>";
				}
				
				else if($ship_total == 0)
				{
					echo "<td style=\"background:$id1;\">Yet to Ship</td>";
				}
				
				else
				{
					echo "<td style=\"background:$id1;\">Short Ship</td>";
				}
			}	
			echo $total;
			
			$prod_balances=0;
			// $sql2="select * from $bai_pro3.sections_db where sec_id>0";
			$sql2="SELECT GROUP_CONCAT(DISTINCT workstation_code ORDER BY workstation_code*1) AS sec_mods FROM $pms.workstation where plant_code='$plant_code'";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql2_num=mysqli_num_rows($sql_result2);
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$sec_mods=$sql_row2['sec_mods'];
				
				// $sql2xy="select sum(balance) as balance from (select sum((ims_qty-ims_pro_qty)) as balance from bai_pro3.ims_log where ims_schedule=\"$sch\" and ims_mod_no in ($sec_mods) and ims_remarks not in ('EXCESS','SAMPLE','EMB') union select sum((ims_qty-ims_pro_qty)) as balance from $pms.ims_log_backup where plant_code='$plantcode' and ims_schedule=\"$sch\" and ims_mod_no in ($sec_mods) and ims_remarks not in ('EXCESS','SAMPLE','EMB')) as t";
				// // echo $sql2xy;
				// $sql_result2xy=mysqli_query($link, $sql2xy) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
				// while($sql_row2xy=mysqli_fetch_array($sql_result2xy))
				// {
				// 	echo "<td style=\"background:$id;\">".$sql_row2xy['balance']."</td>";
				// 	echo "<td style=\"background:$id;\">".round(($sql_row2xy['balance']*$fob),2)."$</td>";
				// 	$prod_balances+=$sql_row2xy['balance'];
				// }
					
					
					
			}	
			
			// echo "<td style=\"background:$id;\">$prod_balances</td>";
			// echo "<td style=\"background:$id;\">".round(($prod_balances*$fob),2)."$</td>";
			
			// echo "<td style=\"background:$id;\">".($total_qty-$ship_total)."</td>";
			// echo "<td style=\"background:$id;\">".round(($total_qty-$ship_total)*$fob,2)."$</td>";
			
			$slnum += 1;
		}
		
	//	}
	echo "<tr><td colspan=\"22\"></td><th>".$total_cost."$</th></tr>";
	echo "</table>";
// }else{
// 	echo "<div class='alert alert-info' align=\"center\">Selected period Don't have any schedules to shipment</div>";
// }
?>
 
<script language="javascript" type="text/javascript">
	var table3Filters = {
	col_35: "select",
	sort_select: true,
	display_all_text: "Display all"
	}
	setFilterGrid("table1",table3Filters);
</script> 


</div></div>
</html>