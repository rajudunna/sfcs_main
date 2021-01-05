<?php
set_time_limit(9000);
$start_date_w=time();
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
$out_operation=130;
$cut_operation=15;
$in_operation=100;
while((date("N",$start_date_w))!=1) {
$start_date_w=$start_date_w-(60*60*24); // define monday
}
$end_date_w=$start_date_w+(60*60*24*6); // define sunday 

$start_date_w=date("Y-m-d",$start_date_w);
$end_date_w=date("Y-m-d",$end_date_w);

?>


<style>

.toggleview li{
	float:left;
	padding: 10px;
	
	margin:2px;
}

</style>

<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R')?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURL($_GET['r'],'common/css/TableFilter_EN/filtergrid.css',3,'R')?>"></script>
<script type="text/javascript" src="<?= '../'.getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R') ?>" ></script>
<script>
	function dodisablenew()
	{
		document.getElementById('update').disabled='true';
	}


	function enableButton() 
	{
		if(document.getElementById('option').checked)
		{
			document.getElementById('update').disabled=false;
		} 
		else 
		{
			document.getElementById('update').disabled=true;
		}
	}
	$(document).ready(function(){

		$('#click_me').css({'display':'block'});
		$('#tableone').css({'border':'1px solid black'});
		$('td').css({'border':'1px solid black'});
		$('th').css({'border':'1px solid black'});
		var table3Filters = {
			status_bar: true,
			sort_select: true,
			alternate_rows: false,
			loader_text: "Filtering data...",
			loader: true,
			rows_counter: true,
			display_all_text: "Display all",
			btn_reset : true,
		};
		setFilterGrid("tableone",table3Filters);
		$('#reset_tableone').addClass('btn btn-warning');
	});
	
	function get_excel(){
		var csv_value=$('#tableone').table2CSV({delivery:'value'});
		$("#csv_weekly").val(csv_value);
	}	

		// jQuery(function() {
	// 	var table = jQuery("#tableone");

	// 	jQuery(window).scroll(function() {
	// 		var windowTop = jQuery(window).scrollTop();
	// 		if (windowTop > table.offset().top) {
	// 			jQuery("thead", table).addClass("Fixed").css("top", windowTop);
	// 		}
	// 		else {
	// 			jQuery("thead", table).removeClass("Fixed");
	// 		}
	// 	});
	// });


	// $('.fltrow').remove();
	// var tableID = 'tableone';
	// var filename = 'weekly_delivery_report.xls';
    // var downloadLink;
    // var dataType = 'application/vnd.ms-excel';
    // var tableSelect = document.getElementById(tableID);
    // var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    // // Create download link element
    // downloadLink = document.createElement("a");

    // document.body.appendChild(downloadLink);
    
    // if(navigator.msSaveOrOpenBlob){
    //     var blob = new Blob(['\ufeff', tableHTML], {
    //         type: dataType
    //     });
    //     navigator.msSaveOrOpenBlob( blob, filename);
    // }else{
    //     // Create a link to the file
    //     downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
    //     // Setting the file name
    //     downloadLink.download = filename;
        
    //     //triggering the function
    //     downloadLink.click();
    // }
	// //location.reload();


</script>

<div class="panel panel-primary">
<div class="panel-heading">Weekly Delivery Report</div>
<div class="panel-body">
<?php
	// include("../dbconf3.php");
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
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



<form method="post" name="input" action="?r=<?php echo $_GET['r']; ?>">

<div class="row">
<div class='col-md-3'>
<label>Buyer Division: </label><select name="division" class="select2_single form-control">
<option value='All' <?php if($division=="All"){ echo "selected"; } ?> >All</option>
<?php 

$sqly="SELECT (buyer_desc) as buyer_name FROM $oms.oms_mo_details where plant_code='$plantcode' GROUP BY buyer_desc ORDER BY buyer_desc";

mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowy=mysqli_fetch_array($sql_resulty))
{
	// $buyer_div=$sql_rowy['buyer_div'];
	$buyer_name=$sql_rowy['buyer_name'];
	$buyer_name1[]=$sql_rowy['buyer_name'];

	if(($_GET["view_div"])=="$buyer_name") 
	{
		echo "<option value=\"".$buyer_name."\" selected>".$buyer_name."</option>";  
	} 
	else 
	{
		echo "<option value=\"".$buyer_name."\" >".$buyer_name."</option>"; 
	}
}

?>
</select>
</div>

<!-- <div class='col-md-2' style="margin-top: 23px;"> -->
<!-- <input type="checkbox" name="custom" value="1" <?php if(isset($_POST['custom'])) { echo "checked"; } ?>> Custom View  -->
<!-- Pending Deliveries (Yes) : <input type="checkbox" name="pending" value="1" <?php if($pending==1){ echo "checked";} ?>> -->
<!-- </div> -->
<input type="submit" class="btn btn-success" value="Show" name="submit" onclick="document.getElementById('submit').style.display='none'; document.getElementById('msg').style.display='';" style="margin-top: 22px;">  <!--11-21-2013 by dharani-->
</div>
</form>

<!---<span id="msg" style="display:none;"><h4>Please Wait.. While Processing The Data..<h4></span>--->   <!--11-21-2013 by dharani-->
<?php
$start_date_w_new=time();

while((date("N",$start_date_w_new))!=1) {
$start_date_w_new=$start_date_w_new-(60*60*24); // define monday
}
$end_date_w_new=$start_date_w_new+(60*60*24*6); // define sunday 

$start_date_w_new=date("Y-m-d",$start_date_w_new);
$end_date_w_new=date("Y-m-d",$end_date_w_new);

$start_date_w_new=date("Y-m-d",strtotime("-7 days", strtotime($start_date_w_new)));
$end_date_w_new=date("Y-m-d",strtotime("-7 days", strtotime($end_date_w_new)));

// echo '<div align="right"><h3><a href="week_delivery_plan_view3_next_wk.php?start_date_w_new='.$start_date_w_new.'&end_date_w_new='.$end_date_w_new.'&title=Previous"><< Prev. Week</a>';

$start_date_w_new=time();

while((date("N",$start_date_w_new))!=1) {
$start_date_w_new=$start_date_w_new-(60*60*24); // define monday
}
$end_date_w_new=$start_date_w_new+(60*60*24*6); // define sunday 

$start_date_w_new=date("Y-m-d",$start_date_w_new);
$end_date_w_new=date("Y-m-d",$end_date_w_new);

$start_date_w_new=date("Y-m-d",strtotime("+7 days", strtotime($start_date_w_new)));
$end_date_w_new=date("Y-m-d",strtotime("+7 days", strtotime($end_date_w_new)));

// echo '<a href="week_delivery_plan_view3_next_wk.php?start_date_w_new='.$start_date_w_new.'&end_date_w_new='.$end_date_w_new.'&title=Next"><h3>Next Week >></a></h3></div>';

?>
</form>

<?php

//$sizes_array=array('s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50');


if(isset($_POST['submit']) || isset($_GET['division']))
{


	$date = str_replace('-', '', $start_date_w);
	 $start_date_w1=date('Ymd', strtotime($date));
	 $date1 = str_replace('-', '', $end_date_w);
	 $end_date_w1=date('Ymd', strtotime($date1));
	 
	echo "<hr/>";
	// echo '<a href="week_delivery_plan_view3_excel.php">Export to Excel</a> | <a href="week_cache/">Archive</a>';
	if(isset($_GET['division']))
	{
		$division=$_GET['division'];
	}
	else
	{
		$division=$_POST['division'];
	}

	$pending=$_POST['pending'];
	$custom=$_POST['custom'];
	if($division=='All')
	{	
		$buyer_division_ref="'".implode("','",$buyer_name1)."'";
		
		//$order_div_ref="and buyer_division in (".$buyer_division_ref.")";
	}else{
		$buyer_division=$division;
		$buyer_division_ref='"'.str_replace(",",'","',$buyer_division).'"';
	
	}
	
	// $sql_res="select * from $bai_pro4.weekly_cap_reasons where category=1";
	// // echo $sql_res."<br>";
	// $sql_result_res=mysqli_query($link, $sql_res) or exit("Sql Error".$sql_res."-".mysqli_error($GLOBALS["___mysqli_ston"]));
	// while($sql_row_res=mysqli_fetch_array($sql_result_res))
	// {
	// 	$searial_no[]=$sql_row_res["sno"];
	// 	$reason_ref[]=$sql_row_res["reason"];
	// 	$color_code_ref[]=$sql_row_res["color_code"];
	// }
	//	for($j=0;$j<sizeof($searial_no);$j++)
	//	{
	//		echo $searial_no[$j]."<br>";
	//	}
	// $query="where ex_factory_date_new between \"$start_date_w\" and  \"$end_date_w\" order by left(style,1),schedule_no+0";
	// if($division!="All")
	// {
	// 	$query="where ex_factory_date_new between \"$start_date_w\" and  \"$end_date_w\" ".$order_div_ref." order by left(style,1),schedule_no+0";
	// }
	
	echo '<div class="table-responsive" style="max-height:600px">';
	//echo '<div id="targetone" name="targetone" class="target col-sm-12 toggleview">toggle columns:</div>'
	
	//TEMP Tables

	// $sql="Truncate $bai_pro4.week_delivery_plan_ref_temp";
	// // echo $sql;
	// mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));

	// $sql="Truncate $bai_pro4.week_delivery_plan_temp";
	// //echo $sql;
	// mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));

	// $sql="Truncate $bai_pro4.shipment_plan_ref_view";
	// //echo $sql;
	// mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));

	// $sql="insert into $bai_pro4.week_delivery_plan_ref_temp select * from $bai_pro4.week_delivery_plan_ref $query";
	// echo $sql."<br>";
	// mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));

	// $sql="insert into $bai_pro4.week_delivery_plan_temp select * from $bai_pro4.week_delivery_plan where ref_id in (select ref_id from $bai_pro4.week_delivery_plan_ref_temp $query)";
	// // echo $sql."<br>";
	// mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));

	// $sql="insert into $bai_pro4.shipment_plan_ref_view select * from $bai_pro4.shipment_plan_ref where ship_tid in (select shipment_plan_id from $bai_pro4.week_delivery_plan_temp)";
	// mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));



	// $table_ref3="shipment_plan_ref_view";
	// $table_ref="week_delivery_plan_ref_temp";
	// $table_ref2="week_delivery_plan_temp";
	//TEMP Tables

	$x=1;
	// if($division=='ALL'){
	// 	$sql="select * from $oms.oms_mo_details where buyer_desc in  ($buyer_name_ref) and plant_code='$plantcode'";
	// }else{
		$sql="select * from $oms.oms_mo_details where buyer_desc in  ($buyer_division_ref) and plant_code='$plantcode' and DATE(planned_delivery_date) between \"$start_date_w1\" and  \"$end_date_w1\" and po_number!='' group by schedule,buyer_desc";
//	}
	//  echo $sql."<br>";
	// mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result1=mysqli_num_rows($sql_result);
	if(mysqli_num_rows($sql_result) > 0)
	{
		$excel_link = getFullURLLevel($_GET['r'],'export_excel_weekly_delivery_plan.php',0,'R');
		echo '<form action="'.$excel_link.'" method="POST">
				<input type="hidden" name="csv_weekly" id="csv_weekly">
				<input type="submit" value="Export to Excel" id="click_me" onclick="get_excel()" class="btn btn-primary btn-sm" >
		</form>';
		
		echo '<form method="post" name="test" action='.getFullURL($_GET['r'],'week_delivery_plan_edit_process.php','N').'>
			
			<p style="float:right">
				<input type="checkbox" name="option"  id="option" height= "21px" onclick="javascript:enableButton();">Enable
				<input type="submit" name="update" id="update" class="btn btn-success" disabled value="Update">
			</p>';
		
		echo '<table id="tableone" name="tableone" cellspacing="0" class="table table-bordered"><thead>';
		echo '
				<tr class="danger">
				<th>S. No</th>
				<th class=" filter">Buyer Division</th>
				<th class=" filter">MPO</th>	
				<th class=" filter">CPO</th>	
				<th>Customer Order No</th>	
				<th>Z-Feature</th>
				<th class="filter">Ex Factory</th>
				<th class="filter">Rev. Ex-Factory</th>
				<th class="filter" >Style No.</th>	
				<th class="filter" >Schedule No.</th>

				<th>Colour</th>
				<th>Order Total</th>
				<th>Ext Ship %</th>
				<th>Size</th>
				<th>Quantity</th>
				<th>Actual Cut Total</th>
				<th>Actual Cut %</th>
				<th>Actual Out Total</th>
				<th>Act Out %</th>
				<th>Rejection %</th>

				<th>Embellishment</th>
				<th class="filter">Packing Method</th>
				<th>M3 Ship Qty</th>
				<th class="filter">Current Status</th>
				<th>Plan End Date</th>
				<th>Mode</th>
				<th class="filter" >Rev. Mode</th>
				<th class="filter">Exe. Sections</th>';
		// if(!isset($_POST['custom']))
		// {
		// 	echo   '<th>Plan</th>
		// 			<th>Actual</th>
		// 			<th>Plan</th>
		// 			<th>Actual</th>
		// 			<th>Plan</th>
		// 			<th>Actual</th>	
		// 			<th>Plan</th>
		// 			<th>Actual</th>
		// 			<th>Plan</th>
		// 			<th>Actual</th>
		// 			<th>Plan</th>
		// 			<th>Actual</th>';
		// }

		echo '<th>Plan Module</th>
				<th>Actual Module</th>
				<th>Planning Remarks</th>
				<th>Production Remarks</th>
				<th>Commitments</th>
				<th>Remarks</th>';
	
		echo '</tr>';
		echo '</thead><tbody>';
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		//
		$po_number=$sql_row['po_number'];
		$mo_number=$sql_row['mo_number'];
		$sql1="select zfeature_name from $oms.oms_products_info where mo_number='$mo_number'";
		//  echo "<br>2=".$sql1."<br>";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2x".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$zfeature_name=$sql_row1['zfeature_name'];
		}
		$vpo=$sql_row['vpo'];
		$customer_order_no=$sql_row['customer_order_no'];
		$cpo=$sql_row['cpo'];
		$buyer_desc=$sql_row['buyer_desc'];
		$schedule=$sql_row['schedule'];
		// //$x=$edit_ref;
		$planned_delivery_date=$sql_row['planned_delivery_date'];
		
		

		//TEMP Enabled

		$embl_tag=$sql_row['rev_emb_status'];
		$rev_ex_factory_date=$sql_row['planned_delivery_date']; 
		$rev_mode=$sql_row['rev_mode']; 
		if($rev_ex_factory_date=="0000-00-00")
		{
			$rev_ex_factory_date="";
		}



		//$order_total=$size_xs+$size_s+$size_m+$size_l+$size_xl+$size_xxl+$size_xxxl+$size_s06+$size_s08+$size_s10+$size_s12+$size_s14+$size_s16+$size_s18+$size_s20+$size_s22+$size_s24+$size_s26+$size_s28+$size_s30;
		// $actu_total=$size_xs+$size_s+$size_m+$size_l+$size_xl+$size_xxl+$size_xxxl+$size_s06+$size_s08+$size_s10+$size_s12+$size_s14+$size_s16+$size_s18+$size_s20+$size_s22+$size_s24+$size_s26+$size_s28+$size_s30;
		// $plan_total=$actu_sec1+$actu_sec2+$actu_sec3+$actu_sec4+$actu_sec5+$actu_sec6+$actu_sec7+$actu_sec8+$actu_sec9;

		$rej_per=0;	 

		$order_total=0;

		$sql1="select master_po_details_id,style from $pps.mp_color_detail where master_po_number='$po_number' and plant_code='$plantcode'";
		// echo "<br>2=".$sql1."<br>";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2x".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$master_po_details_id=$sql_row1['master_po_details_id'];
			$style=$sql_row1['style'];
			$sql7="select schedule,color,size,z_feature from $pps.mp_mo_qty where plant_code='$plantcode' and master_po_details_id='$master_po_details_id'  group by schedule,color,size";
			//echo "<br>2=".$sql7."<br>";
			$sql_result7=mysqli_query($link, $sql7) or exit("Sql Error2x".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row7=mysqli_fetch_array($sql_result7))
			{
				$size=$sql_row7['size'];
				$color=$sql_row7['color'];
				$schedule_no=$sql_row7['schedule'];
				
				$extra_ship_qty="select sum(quantity) as quantity,master_po_details_id from $pps.mp_mo_qty where schedule='$schedule_no' and color='$color' and plant_code='$plantcode' and size='$size'  and mp_qty_type='EXTRA_SHIPMENT' group by schedule,color,size";
				
				$extra_ship_qty_result4=mysqli_query($link, $extra_ship_qty) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
				$extra_ship_rows=mysqli_num_rows($extra_ship_qty_result4);
				// $total_rows=mysqli_num_rows($sql_result4);
				if($extra_ship_rows>0){
				while($sql_row000111 = mysqli_fetch_array($extra_ship_qty_result4))
				{
					$extra_qty = $sql_row000111['quantity'];
				}
				}else{
					$extra_qty=0;
				}
				
				$original_qty="select sum(quantity) as quantity,master_po_details_id from $pps.mp_mo_qty where schedule='$schedule_no' and color='$color' and plant_code='$plantcode' and size='$size'  and mp_qty_type='ORIGINAL_QUANTITY' group by schedule,color,size";
				
				$extra_ship_qty_result44=mysqli_query($link, $original_qty) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
				// $total_rows=mysqli_num_rows($sql_result4);
				while($sql_row0001111 = mysqli_fetch_array($extra_ship_qty_result44))
				{
					$total_ord = $sql_row0001111['quantity'];
				}
			
			$get_po_details1="select sum(quantity) as orginal_quantity from $pps.mp_mo_qty where schedule='$schedule_no' and color='$color' and plant_code='$plantcode' and mp_qty_type='ORIGINAL_QUANTITY' group by schedule,color";
			$get_po_details_result1 = mysqli_query($link, $get_po_details1) or die("Sql Error 12".mysqli_error($GLOBALS["___mysqli_ston"]));
			
				while($row1221 = mysqli_fetch_array($get_po_details_result1))
				{
					$order_total = $row1221['orginal_quantity'];
				}

			$get_po_details="select sum(quantity) as quantity from $pps.mp_mo_qty where schedule='$schedule_no' and color='$color' and plant_code='$plantcode' and size='$size' and mp_qty_type='ORIGINAL_QUANTITY' group by schedule,color,size";
		
			$get_po_details_result = mysqli_query($link, $get_po_details) or die("Sql Error 12".mysqli_error($GLOBALS["___mysqli_ston"]));
			
				while($row122 = mysqli_fetch_array($get_po_details_result))
				{
					$size_val = $row122['quantity'];
				}

				$get_out_qty_details="select sum(good_quantity+rejected_quantity) as cut_qty from $pts.transaction_log where schedule='$schedule_no' and color='$color' and style='$style' and size='$size' and plant_code='$plantcode' and operation=".$cut_operation." group by schedule,color";
				$get_out_qty_details_result = mysqli_query($link, $get_out_qty_details) or die("Sql Error 12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$get_out_qty__rows=mysqli_num_rows($get_out_qty_details_result);
				if($get_out_qty__rows){
				while($row12222= mysqli_fetch_array($get_out_qty_details_result))
					{
						$actu_total = $row12222['cut_qty'];
					}
				}else{
					$actu_total=0;
				}
				$get_in_qty_details="select sum(good_quantity+rejected_quantity) as cut_qty from $pts.transaction_log where schedule='$schedule_no' and color='$color' and style='$style' and size='$size' and plant_code='$plantcode' and operation=".$in_operation." group by schedule,color";
				
				$get_in_qty_details_result = mysqli_query($link, $get_in_qty_details) or die("Sql Error 12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$get_in_qty__rows=mysqli_num_rows($get_in_qty_details_result);
				if($get_in_qty__rows){
				while($row122221= mysqli_fetch_array($get_in_qty_details_result))
					{
						$in = $row122221['cut_qty'];
					}
				}else{
					$in=0;
				}
			
				$get_out_qty_details="select sum(good_quantity+rejected_quantity) as out_qty from $pts.transaction_log where schedule='$schedule_no' and color='$color' and style='$style' and size='$size' and plant_code='$plantcode' and operation=".$out_operation." group by schedule,color,size";
				
				$get_out_qty_details_result1 = mysqli_query($link, $get_out_qty_details) or die("Sql Error 12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$get_out_rows=mysqli_num_rows($get_out_qty_details_result1);
				if($get_out_rows){	
				while($row12222= mysqli_fetch_array($get_out_qty_details_result1))
					{
						$plan_total = $row12222['out_qty'];
					}
				}else{
					$plan_total=0;
				}
				$get_rej_qty_details="select sum(rejected_quantity) as rej_qty from $pts.transaction_log where schedule='$schedule_no' and color='$color' and style='$style' and size='$size' and plant_code='$plantcode' and operation=".$out_operation." group by schedule,color,size";
				
				$get_rej_qty_details_result = mysqli_query($link, $get_rej_qty_details) or die("Sql Error 12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$get_rej_rows=mysqli_num_rows($get_rej_qty_details_result);
				if($get_rej_rows){	
				while($row1222211= mysqli_fetch_array($get_rej_qty_details_result))
					{
						$act_rej = $row1222211['rej_qty'];
					}
				}else{
					$act_rej=0;
				}
					$get_workstations_details="select resource_id from $pts.transaction_log where schedule='$schedule_no' and color='$color' and style='$style' and size='$size' and plant_code='$plantcode' group by resource_id";
				$get_workstations_details_result = mysqli_query($link, $get_workstations_details) or die("Sql Error 12".mysqli_error($GLOBALS["___mysqli_ston"]));
					
				while($row122221= mysqli_fetch_array($get_workstations_details_result))
					{
						$workstations = $row122221['resource_id'];

						$get_sections_query="select GROUP_CONCAT(workstation.workstation_code SEPARATOR ',') as workstation,
						GROUP_CONCAT(sections.section_name SEPARATOR ',') as section from $pms.workstation left join $pms.sections on sections.section_id=workstation.section_id where workstation_id ='$workstations' and workstation.plant_code='$plantcode'";
						$get_sections_query_result = mysqli_query($link, $get_sections_query) or die("Sql Error 12".mysqli_error($GLOBALS["___mysqli_ston"]));
					
				     while($row1222211= mysqli_fetch_array($get_sections_query_result))
					{
						$act_modu = $row1222211['workstation'];
						$section = $row1222211['section'];
					}
						
					}
			

					
				$get_planned_module_details="select GROUP_CONCAT(row_name SEPARATOR ',') as row_name from $pps.monthly_production_plan where order_code='$schedule_no' and colour='$color' and product_code='$style'  and plant_code='$plantcode' and planned_date between \"$start_date_w\" and  \"$end_date_w\"";
				$get_planned_module_details_result = mysqli_query($link, $get_planned_module_details) or die("Sql Error 121".mysqli_error($GLOBALS["___mysqli_ston"]));
					
				while($row123= mysqli_fetch_array($get_planned_module_details_result))
					{
						$plan_mod = $row123['row_name'];
					}
					
			//$ex_factory_date=$sql_row1['ex_factory_date']; //TEMP Disabled due to M3 Issue
			
			
			
			//Start Need to capture plan and actual modules based on schedule number
			$sql12 = "select packing_method from $oms.oms_mo_details where schedule = '$schedule_no'";
			//$plan_mod = array();
			// echo $sql12;
			$query12 = mysqli_query($link, $sql12) or die("Sql Error 12".mysqli_error($GLOBALS["___mysqli_ston"]));
			
				while($row12 = mysqli_fetch_array($query12))
				{
					$packing_method = $row12['packing_method'];
				}
			// if($plan_modu>0)
			// {
			// 	$plan_mod = $plan_modu;
			// }
			// else
			// {
			// 	$plan_mod = 0;
			// }
			$get_planned_module_details="select max(production_end_date) as production_end_date from $pps.monthly_production_plan where order_code='$schedule_no' and colour='$color' and product_code='$style'  and plant_code='$plantcode' and planned_date between \"$start_date_w\" and  \"$end_date_w\"";
			$get_planned_module_details_result = mysqli_query($link, $get_planned_module_details) or die("Sql Error 121".mysqli_error($GLOBALS["___mysqli_ston"]));
				
			while($row123= mysqli_fetch_array($get_planned_module_details_result))
				{
					$plan_mod = $row123['row_name'];
				}
			$sql13 = "select max(production_end_date) as production_end_date from $pps.monthly_production_plan where order_code='$schedule_no' and colour='$color' and product_code='$style'  and plant_code='$plantcode' and planned_date between \"$start_date_w\" and  \"$end_date_w\"";
			// //$act_mod = array();
			$query13 = mysqli_query($link, $sql13) or die("Sql Error 13".mysqli_error($GLOBALS["___mysqli_ston"]));
			
				while($row13 = mysqli_fetch_array($query13))
				{
					$production_end_date = $row13['production_end_date'];
				}
			if(sizeof($act_modu)>0)
			{
				$act_mod = $act_modu;
			}
			else
			{
				$act_mod = 0;
			}
		
	// open data from production review for cut%
					
		// $CID=0;
		// $sql1z="select * from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and category in ($in_categories) and purwidth>0";
		// // echo "<br>".$sql1z."<br>";
		// mysqli_query($link, $sql1z) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		// $sql_result1z=mysqli_query($link, $sql1z) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		// while($sql_row1z=mysqli_fetch_array($sql_result1z))
		// {
		// 	$CID=$sql_row1z['tid'];
		// }

		// $sqlc="SELECT cuttable_percent as cutper from $bai_pro3.cuttable_stat_log where cat_id=$CID";
		// //echo $sqlc;
		// $sql_resultc=mysqli_query($link, $sqlc) or exit("Sql Error41".mysqli_error($GLOBALS["___mysqli_ston"]));
		// while($sql_rowc=mysqli_fetch_array($sql_resultc))
		// {
		// 	$cut_per=$sql_rowc['cutper'];
		// 	//echo "cut_per=".$cut_per;
		// }

		// $sqla="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
		// $sql_resulta=mysqli_query($link, $sqla) or exit("Sql Error51".mysqli_error($GLOBALS["___mysqli_ston"]));
		// $sql_num_confirma=mysqli_num_rows($sql_resulta);

		// if($sql_num_confirma>0)
		// {
		// 	$sqlza="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
		// }
		// else
		// {
		// 	$sqlza="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
		// }
		// // echo "<br>4=".$sqlza."<br>";
		// mysqli_query($link, $sqlza) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		// $sql_resultza=mysqli_query($link, $sqlza) or exit("Sql Error61".mysqli_error($GLOBALS["___mysqli_ston"]));
		// while($sql_rowza=mysqli_fetch_array($sql_resultza))
		// {			
		// 	$o_xs=$sql_rowza['order_s_xs'];
		// 	$o_s=$sql_rowza['order_s_s'];
		// 	$o_m=$sql_rowza['order_s_m'];
		// 	$o_l=$sql_rowza['order_s_l'];
		// 	$o_xl=$sql_rowza['order_s_xl'];
		// 	$o_xxl=$sql_rowza['order_s_xxl'];
		// 	$o_xxxl=$sql_rowza['order_s_xxxl'];
		// 	$act_cut_val=$sql_rowza['act_cut'];
		// 	$act_out_val=$sql_rowza['output'];
		// 	foreach($sizes_array as $key => $value)
		// 	{
		// 		if($sql_rowza['order_s_'.$value.''] > 0)
		// 		{
		// 			$size_value[$value]=$sql_rowza['order_s_'.$value.''];
		// 			$title_size_value[$value]=$sql_rowza['title_size_'.$value.''];
		// 		}
		// 	}	
			
		// 	$total_ord=$sql_rowza['old_order_s_s01']+$sql_rowza['old_order_s_s02']+$sql_rowza['old_order_s_s03']+$sql_rowza['old_order_s_s04']+$sql_rowza['old_order_s_s05']+$sql_rowza['old_order_s_s06']+$sql_rowza['old_order_s_s07']+$sql_rowza['old_order_s_s08']+$sql_rowza['old_order_s_s09']+$sql_rowza['old_order_s_s10']+$sql_rowza['old_order_s_s11']+$sql_rowza['old_order_s_s12']+$sql_rowza['old_order_s_s13']+$sql_rowza['old_order_s_s14']+$sql_rowza['old_order_s_s15']+$sql_rowza['old_order_s_s16']+$sql_rowza['old_order_s_s17']+$sql_rowza['old_order_s_s18']+$sql_rowza['old_order_s_s19']+$sql_rowza['old_order_s_s20']+$sql_rowza['old_order_s_s21']+$sql_rowza['old_order_s_s22']+$sql_rowza['old_order_s_s23']+$sql_rowza['old_order_s_s24']+$sql_rowza['old_order_s_s25']+$sql_rowza['old_order_s_s26']+$sql_rowza['old_order_s_s27']+$sql_rowza['old_order_s_s28']+$sql_rowza['old_order_s_s29']+$sql_rowza['old_order_s_s30']+$sql_rowza['old_order_s_s31']+$sql_rowza['old_order_s_s32']+$sql_rowza['old_order_s_s33']+$sql_rowza['old_order_s_s34']+$sql_rowza['old_order_s_s35']+$sql_rowza['old_order_s_s36']+$sql_rowza['old_order_s_s37']+$sql_rowza['old_order_s_s38']+$sql_rowza['old_order_s_s39']+$sql_rowza['old_order_s_s40']+$sql_rowza['old_order_s_s41']+$sql_rowza['old_order_s_s42']+$sql_rowza['old_order_s_s43']+$sql_rowza['old_order_s_s44']+$sql_rowza['old_order_s_s45']+$sql_rowza['old_order_s_s46']+$sql_rowza['old_order_s_s47']+$sql_rowza['old_order_s_s48']+$sql_rowza['old_order_s_s49']+$sql_rowza['old_order_s_s50'];

			
		// 	$total_qty_ord=$sql_rowza['order_s_s01']+$sql_rowza['order_s_s02']+$sql_rowza['order_s_s03']+$sql_rowza['order_s_s04']+$sql_rowza['order_s_s05']+$sql_rowza['order_s_s06']+$sql_rowza['order_s_s07']+$sql_rowza['order_s_s08']+$sql_rowza['order_s_s09']+$sql_rowza['order_s_s10']+$sql_rowza['order_s_s11']+$sql_rowza['order_s_s12']+$sql_rowza['order_s_s13']+$sql_rowza['order_s_s14']+$sql_rowza['order_s_s15']+$sql_rowza['order_s_s16']+$sql_rowza['order_s_s17']+$sql_rowza['order_s_s18']+$sql_rowza['order_s_s19']+$sql_rowza['order_s_s20']+$sql_rowza['order_s_s21']+$sql_rowza['order_s_s22']+$sql_rowza['order_s_s23']+$sql_rowza['order_s_s24']+$sql_rowza['order_s_s25']+$sql_rowza['order_s_s26']+$sql_rowza['order_s_s27']+$sql_rowza['order_s_s28']+$sql_rowza['order_s_s29']+$sql_rowza['order_s_s30']+$sql_rowza['order_s_s31']+$sql_rowza['order_s_s32']+$sql_rowza['order_s_s33']+$sql_rowza['order_s_s34']+$sql_rowza['order_s_s35']+$sql_rowza['order_s_s36']+$sql_rowza['order_s_s37']+$sql_rowza['order_s_s38']+$sql_rowza['order_s_s39']+$sql_rowza['order_s_s40']+$sql_rowza['order_s_s41']+$sql_rowza['order_s_s42']+$sql_rowza['order_s_s43']+$sql_rowza['order_s_s44']+$sql_rowza['order_s_s45']+$sql_rowza['order_s_s46']+$sql_rowza['order_s_s47']+$sql_rowza['order_s_s48']+$sql_rowza['order_s_s49']+$sql_rowza['order_s_s50'];

			
		// 	if($act_rej==0)
		// 	{
		// 		$act_rej=$sql_rowza["act_rej"];
		// 	}
			
		// 	//$extra_ship_ord=round(($total_qty_ord-$total_ord)*100/$total_ord,0);
		// 	if($total_ord > 0)
		// 	{
		// 		$extra_ship_ord=round(($total_qty_ord-$total_ord)*100/$total_ord,0);		
		// 	}
		// 	else
		// 	{
		// 		$extra_ship_ord=0;
		// 	}
		// 	$order_date=$sql_rowza["order_date"];
		// }

		// Ticket #222648 / Add the Actual Out% and Ext Ship%  and Modify the Act Cut% in weekly delivery report
		
		//echo "old ord qty ->".$total_ord."&nbsp;&nbsp; new ord qty ->".$total_qty_ord."&nbsp;&nbsp; Act_cut ->".$act_cut_val."&nbsp;&nbsp; Act cut% ->".$act_cut_per."&nbsp;&nbsp; Ext cut% ->".$ext_cut_per."&nbsp;&nbsp; Act Out% ->".$act_out_per."<br/>";

		if($plan_total>0)
		{
		$rej_per=round(($act_rej/$plan_total)*100,1)."%"."</br>";
		}

		$cutper=(100+$cut_per+$extra_ship_ord)."%"; //For Cut % as Production Review Sheet

		// close data from production review 
		//EMB stat 20111201

		// if(date("Y-m-d")>"2011-12-11")
		// {
		// 	$embl_tag="";
		// 	$sql1="select order_embl_a,order_embl_e from $bai_pro3.bai_orders_db where order_del_no=\"$schedule_no\"";
		// 	mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		// 	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		// 	while($sql_row1=mysqli_fetch_array($sql_result1))
		// 	{
		// 		if($sql_row1['order_embl_a']==1)
		// 		{
		// 			$embl_tag="Panle Form*";
		// 		}
		// 		if($sql_row1['order_embl_e']==1)
		// 		{
		// 			$embl_tag="Garment Form*";
		// 		}
		// 	}
		// }

		//EMB stat

		// $order_total=$sql_row['original_order_qty'];
		$act_cut=$sql_row['act_cut'];


		{

		// $sql1="select * from $pps.week_delivery_plan  where shipment_plan_id=$shipment_plan_id and size_code='$size'";
		// $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		// while($sql_row1=mysqli_fetch_array($sql_result1))
		// {
		// 	$priority=$sql_row1['priority'];
		// 	$cut=$sql_row1['act_cut'];
		// 	$in=$sql_row1['act_in'];
		// 	$out=$sql_row1['output'];
		// 	$pendingcarts=$sql_row1['cart_pending'];
		// 	$total_ord=$sql_row1['original_order_qty'];
		// 	$order_qty_new_old=$sql_row1['ord_qty_new_old'];
		// 	$fcamca=$sql_row1['act_mca'];
		// 	$fgqty=$sql_row1['act_fg'];
		// 	$internal_audited=$sql_row1['act_fca'];
		// 	$act_ship=$sql_row1['act_ship'];
		// 	$ex_factory_date=$sql_row1['act_exfact'];
		// 	$sizes_array1=$sql_row1['size_code'];
		// }

		if($total_ord>0)
		{
			$act_out_per=round(($plan_total/$total_ord)*100,2)."%";
		}	
		else
		{
			$act_out_per=(0)."%";
		}
		
	
		if($total_ord>0)
		{
			// $act_cut_per=(100+round(($act_cut_val-$total_ord)*100/$total_ord,0))."%";
			$act_cut_per=round(($actu_total/$total_ord)*100,2)."%";
			$ext_cut_per=round(($extra_qty/$total_ord)*100,2)."%";
		}
		else
		{
			$act_cut_per=(0)."%";
			$ext_cut_per=(0)."%";
		}
		$cut=$actu_total;
		$out=$plan_total;
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

			// $sql1="select ship_qty from $bai_pro2.style_status_summ where sch_no=\"$schedule_no\"";
			// //echo $sql1."<br>";
			// $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			// while($sql_row1=mysqli_fetch_array($sql_result1))
			// {
			// 	$ship_qty=$sql_row1['ship_qty'];
			// }
			// if($actu_total > 0)
			// {
			// 	if($plan_total>0)
			// 	{
			// 		$ext_ship_per=round((($plan_total-$ship_qty)/$actu_total)*100,0)."%";
			// 	}
			// 	else
			// 	{
			// 		$ext_ship_per=0;
			// 	}
			// }
			// else
			// {
			// 	$ext_ship_per=0;
			// }
			// //echo "act ship% ->".$ext_ship_per."<br/>";
			// if($status=="FG" and $fgqty>=$ship_qty and $ship_qty>=$order)
			// {
			// 	$status="M3 Dispatched";
			// }
			
			if($priority==-1 and $status=="FG")
			{
				$status="Shipped";
			}
			//echo $ship_tid."-".$schedule_no."-".$status."-".$priority."-".$cut."-".$in."-".$out."-".$pendingcarts."-".$order."-".$fcamca."-".$fgqty."-".$$internal_audited."<br/>";
		//DISPATCH
		}

			//CR#930 //Fetching the color code of selected reason.
			$color_code_ref1="#FFFFFF";
			// $sql_res1="select * from $bai_pro4.weekly_cap_reasons where sno=\"".$remarks[0]."\"";
			// //echo $sql_res1."<br>";
			// $sql_result_res1=mysqli_query($link, $sql_res1) or exit("Sql Error".$sql_res1."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			// while($sql_row_res1=mysqli_fetch_array($sql_result_res1))
			// {
			// 	$color_code_ref1=$sql_row_res1["color_code"];		
			// }
			
			// $highlight=" bgcolor=\"".$color_code_ref1."\" ";

		// if(in_array(strtolower($username),$authorized))
		// {
			
			$edit_rem="<td class=\"editable\" rel=\"B$edit_ref\">".$remarks[1]."</td>";
			$edit_rem="<td><input type=\"text\" name=\"B[]\" value=\"".$remarks[1]."\"><input type=\"hidden\" name=\"REF[]\" value=\"".$edit_ref."\"><input type=\"hidden\" name=\"REM_REF[]\" value=\"".implode("^",$remarks)."\"><input type=\"hidden\" name=\"C[]\" value=\"".$remarks[2]."\"><input type=\"hidden\" name=\"A[]\" value=\"".$remarks[0]."\"><input type=\"hidden\" name=\"code[]\" value=\"B\"><input type=\"hidden\" name=\"rev_exfa[]\" value=\"".$rev_ex_factory_date."\"><input type=\"hidden\" name=\"style[]\" value=\"".$style."\"><input type=\"hidden\" name=\"schedule_no[]\" value=\"".$schedule_no."\"><input type=\"hidden\" name=\"color[]\" value=\"".$color."\"><input type=\"hidden\" name=\"size[]\" value=\"".$size."\"></td>";
		// }
		// else
		// {
			// $edit_rem="<td $highlight>".$remarks[1]."</td>";
			// $edit_rem="<td $highlight>".$remarks[1]."</td>";
		// }


		// if(!(in_array(strtolower($username),$authorized2)))
		// {
		// 	$edit_rem2="<td $highlight>".$remarks[2]."</td>";
		// }
		// else
		// {
			//$edit_rem="<td $highlight>".$remarks[1]."</td>";
			$edit_rem2="<td class=\"editable\" rel=\"C$edit_ref\">".$remarks[2]."</td>";
			$edit_rem2="<td><input type=\"text\" name=\"C[]\" value=\"".$remarks[2]."\">";
			$edit_rem2.="<input type=\"hidden\" name=\"REF[]\" value=\"".$edit_ref."\"><input type=\"hidden\" name=\"REM_REF[]\" value=\"".implode("^",$remarks)."\"><input type=\"hidden\" name=\"B[]\" value=\"".$remarks[1]."\"><input type=\"hidden\" name=\"A[]\" value=\"".$remarks[0]."\"><input type=\"hidden\" name=\"code[]\" value=\"C\"><input type=\"hidden\" name=\"rev_exfa[]\" value=\"".$rev_ex_factory_date."\"><input type=\"hidden\" name=\"style[]\" value=\"".$style."\"><input type=\"hidden\" name=\"schedule_no[]\" value=\"".$schedule_no."\"><input type=\"hidden\" name=\"color[]\" value=\"".$color."\"><input type=\"hidden\" name=\"size[]\" value=\"".$size."\"></td>";
		// }

		// if(!(in_array(strtolower($username),$authorized3)))
		// {
			//CR#930 //Displaying the Reasons List to Users for selecting the appropriate reason of the schedule.
			// $reason_ref2="";
			// $sql_res2="select * from $bai_pro4.weekly_cap_reasons where sno=\"".$remarks[0]."\"";
			// //echo $sql_res1."<br>";
			// $sql_result_res2=mysqli_query($link, $sql_res2) or exit("Sql Error".$sql_res2."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			// while($sql_row_res2=mysqli_fetch_array($sql_result_res2))
			// {
			// 	$reason_ref2=$sql_row_res2["reason"];		
			// }
			// $edit_rem3="".$reason_ref2."";
		// }
		// else
		// {
			$edit_rem3="<input type=\"text\" name=\"A[]\" value=\"".$remarks[0]."\">";
			//CR#930 //Displaying the Reasons List to Users for selecting the appropriate reason of the schedule.
			$edit_rem3="<select name=\"A[]\">";
			$option_sta1="";	
			if($remarks[0] == 0)
			{
				$option_sta1="selected";
			}
			$edit_rem3.="<option value=\"0\" $option_sta1>Select</option>";
				
			// for($i1=0;$i1<sizeof($reason_ref);$i1++)
			// {
			// 	//echo "Re=".$remarks[0]."==".$searial_no[$i1]."<br>";
			// 	$option_sta="";
			// 	if($remarks[0] == $searial_no[$i1])
			// 	{    
			// 		$option_sta="selected";
			// 	}		
			// 	$edit_rem3.="<option value=\"".$searial_no[$i1]."\" $option_sta>".$reason_ref[$i1]."</option>";
			// }
			$edit_rem3.="</select>";
			$edit_rem3.="<input type=\"hidden\" name=\"REF[]\" value=\"".$edit_ref."\"><input type=\"hidden\" name=\"REM_REF[]\" value=\"".implode("^",$remarks)."\"><input type=\"hidden\" name=\"B[]\" value=\"".$remarks[1]."\"><input type=\"hidden\" name=\"C[]\" value=\"".$remarks[2]."\"><input type=\"hidden\" name=\"code[]\" value=\"A\"><input type=\"hidden\" name=\"style[]\" value=\"".$style."\"><input type=\"hidden\" name=\"schedule_no[]\" value=\"".$schedule_no."\"><input type=\"hidden\" name=\"color[]\" value=\"".$color."\"><input type=\"hidden\" name=\"size[]\" value=\"".$size."\">";
			// $rev_ex_factory_date="<input type=\"text\" name=\"rev_exfa[]\" value=\"".$rev_ex_factory_date."\">";
		// }
		//Restricted Editing for Packing Team
		// if($custom==1)
			//{
			
				//  for($i=0;$i<sizeof($sizes_array);$i++){
					// $size_val= $size_value[$size[$i]];
					//echo '<br>size_'.$sizes_array[$i]."<br>";
					
					// echo "<br>".$size_val."<br>";
					// if($size_val>0){
						// $row_count++;
						echo "
							<tr>
							<td $highlight> $x  </td>	
							<td $highlight>$buyer_desc</td>
							<td $highlight>$mpo</td>	
							<td $highlight>$cpo</td>	
							<td $highlight>$customer_order_no</td>	
							<td $highlight>$zfeature_name</td>
							<td $highlight>$planned_delivery_date</td>
							<td $highlight><input type=\"text\" name=\"rev_exfa[]\" value=\"".$rev_ex_factory_date."\"></td>
							<td $highlight name='style[]' value='$style'>$style</td>	
							<td $highlight name='schedule_no[]' value='$schedule_no'>$schedule_no</td>
							
							<td $highlight name='color[]' value='$color'>$color</td>
							<td $highlight>$order_total</td>
							<td $highlight>$ext_cut_per</td>
							<td $highlight name='size[]' value='$size'>".strtoupper($size)."</td>
							<td>$size_val</td> 
							<td $highlight>$actu_total</td>
							<td $highlight>$act_cut_per</td>
							<td $highlight>$plan_total</td>
							<td $highlight>$act_out_per</td>
							<td $highlight>$rej_per</td>
							
							<td $highlight>$embl_tag</td>
							<td $highlight>$packing_method</td>
							<td $highlight>$ship_qty</td>	
							<td $highlight>$status</td>
							<td $highlight>$production_end_date</td>
							<td $highlight>$mode</td>
							<td $highlight>$rev_mode</td>
							<td $highlight>$section</td>
							";

						// if(!isset($_POST['custom'])){

						// 	echo "
						// 		<td $highlight>$plan_sec1</td>	
						// 		<td $highlight>$actu_sec1</td>	
						// 		<td $highlight>$plan_sec2</td>	
						// 		<td $highlight>$actu_sec2</td>	
						// 		<td $highlight>$plan_sec3</td>	
						// 		<td $highlight>$actu_sec3</td>	
						// 		<td $highlight>$plan_sec4</td>	
						// 		<td $highlight>$actu_sec4</td>	
						// 		<td $highlight>$plan_sec5</td>	
						// 		<td $highlight>$actu_sec5</td>	
						// 		<td $highlight>$plan_sec6</td>	
						// 		<td $highlight>$actu_sec6</td>
						// 		";
						// }	
						echo "
						    <td $highlight>$plan_mod</td>	
							<td $highlight>$act_mod</td>
							<td $highlight>$edit_rem3</td>
							<td>$edit_rem$edit_rem2</td>
							</tr>";

						$x+=1;
					// }
					
				} 
			}
	}
}
	//echo $i;
	// if($row_count==0){
	// 	echo "<font size='11px' color='#ff0000'>NO Data Found</font>";
	// 	echo "<script>
	// 		$(document).ready(function(){
	// 			$('#click_me').css({'display':'none');
	// 			$('#update').css({'display':'none');
	// 		});
	// 	</script>";
	// }
	echo '</form>';
	echo '</tbody>';
	echo '</table>';
	echo '</form>';
	echo '</div>';
	//}
	// else
	// {
	// 	echo "<div class='alert alert-info'>There are no deliveries in this week.</div>";
	// }
	if(mysqli_num_rows($sql_result) == 0){
		echo "<div class='alert alert-info'>There are no deliveries in this week.</div>";
	  }
}

?>




</div>
</div>
</div>
</div>



