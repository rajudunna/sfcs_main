<?php 
$url1 =  $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R');
include("$url1");  
$url2 =  $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'); 
include("$url2");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',3,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',3,'R')); 
$plant_code=$_SESSION['plantCode'];
// $plant_code='Q01';
$username=$_SESSION['userName'];
?>


<style id="Book5_10971_Styles">
th{ color : black;}
td{ color : black;}
.black{
	text-align : right;
	font-weight : bold;
	color : #000;
}
</style>



<script type='text/javascript'>
function firstbox()
{
	window.location.href ="<?php echo 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value;
}
function secondbox()
{
	window.location.href ="<?php echo 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value
}
function thirdbox()
{
	window.location.href ="<?php echo 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value
}
function fourthbox()
{
	window.location.href ="<?php echo 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value
}
function fifthbox()
{
	window.location.href ="<?php echo 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value+"&sub_po="+document.test.sub_po.value
}
// function sixthbox()
// {
// 	window.location.href ="<?php echo 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value+"&sub_po="+document.test.sub_po.value+"&category="+document.test.category.value
// }

$(document).ready(function() {
	$('#schedule').on('mouseup',function(e){
		style = $('#style').val();
		if(style === 'NIL'){
			sweetAlert('Please Select Style','','warning');
		}
	});
	$('#color').on('mouseup',function(e){
		style = $('#style').val();
		schedule = $('#schedule').val();
		if(style === 'NIL' && schedule === 'NIL'){
			sweetAlert('Please Select Style and Schedule','','warning');
		}
		else if(style === 'NIL'){
			sweetAlert('Please Select Style','','warning');
		}
		else if(schedule === 'NIL'){
			sweetAlert('Please Select Schedule','','warning');
		}
	});
	// $('#category').on('mouseup',function(e){
	// 	style = $('#style').val();
	// 	schedule = $('#schedule').val();
	// 	color = $('#color').val();
	// 	if(style === 'NIL' && schedule === 'NIL' && color === 'NIL'){
	// 		sweetAlert('Please Select Style, Schedule and Color','','warning');
	// 	}
	// 	else if(schedule === 'NIL' && color === 'NIL'){
	// 		sweetAlert('Please Select Schedule and Color','','warning');
	// 	}
	// 	else if(color === 'NIL'){
	// 		sweetAlert('Please Select Color','','warning');
	// 	}
	// 	else {
	// 		document.getElementById("submit").disabled = false;
	// 	}
	// });
	// $('#submit').on('click',function(e){
	// 	category = $('#category').val();
	// 	if(category === 'NIL') {
	// 		sweetAlert('Please Select Category','','warning');
	// 		document.getElementById("submit").disabled = true;
	// 	}
	// 	else {
	// 		document.getElementById("submit").disabled = false;
	// 	}
	// });

});
</script>


<?php 
$url3 = $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R');
include("$url3"); 
// $url4 =  $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'menu_content.php',2,'R');
// include("$url4"); 
?>

<?php
$get_style=$_GET['style'];
$get_schedule=$_GET['schedule']; 
$get_color=$_GET['color'];
$get_mpo=$_GET['mpo']; 
$get_sub_po=$_GET['sub_po'];
// $category=$_GET['category'];

if(isset($_POST['style']))
{
	$get_style=$_POST['style'];
}
if(isset($_POST['schedule']))
{
	$get_schedule=$_POST['schedule'];
}
if(isset($_POST['color']))
{
	$get_color=$_POST['color'];
}
if(isset($_POST['mpo']))
{
	$get_mpo=$_POST['mpo'];
}
if(isset($_POST['sub_po']))
{
	$get_sub_po=$_POST['sub_po'];
}
// if(isset($_POST['category']))
// {
// 	$category=$_POST['category'];
// }
?>

<div class='panel panel-primary'>
	<div class="panel-heading">
	<b>Style Status Report - Cut Details</b>
	</div>
	<div class="panel-body">
		<form method="post" name="test" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>">
			<div class="col-sm-2 form-group">
				<label for='style'>Select Style</label>
				<select required class='form-control' name='style' onchange='firstbox()' id='style'>
				<?php
					echo "<option value=\"NIL\" selected>NIL</option>";
					if($plant_code!=''){
						$result_mp_color_details=getMpColorDetail($plant_code);
						$style=$result_mp_color_details['style'];
					}
					foreach ($style as $style_value) {
						if(str_replace(" ","",$style_value)==str_replace(" ","",$get_style)) 
						{ 
							echo '<option value=\''.$style_value.'\' selected>'.$style_value.'</option>'; 
						} 
						else 
						{ 
							echo '<option value=\''.$style_value.'\'>'.$style_value.'</option>'; 
						}
					}
				echo "</select>";
				?>	
			</div>
			<div class="col-sm-2 form-group">
				<label for='schedule'>Select Schedule</label>
				<select required class='form-control' name='schedule' onchange='secondbox();' id='schedule'>
				<?php
					echo "<option value=\"NIL\" selected>NIL</option>";	
					/*function to get schedule from getdata_bulk_schedules
					@params : plantcode,style
					@returns: schedule
					*/
					if($get_style!=''&& $plant_code!=''){
						$result_bulk_schedules=getBulkSchedules($get_style,$plant_code);
						$bulk_schedule=$result_bulk_schedules['bulk_schedule'];
					} 
					foreach ($bulk_schedule as $bulk_schedule_value) {
						if(str_replace(" ","",$bulk_schedule_value)==str_replace(" ","",$get_schedule)) 
						{ 
							echo '<option value=\''.$bulk_schedule_value.'\' selected>'.$bulk_schedule_value.'</option>'; 
						} 
						else 
						{ 
							echo '<option value=\''.$bulk_schedule_value.'\'>'.$bulk_schedule_value.'</option>'; 
						}
					}
					echo "</select>";
				?>
			</div>	
			<div class="col-sm-2 form-group">
				<label for='color'>Select Color:</label>
				<select required class='form-control' name='color' onchange='thirdbox();' id='color'>
				<?php
					echo "<option value=\"NIL\" selected>NIL</option>";
					/*function to get color from get_bulk_colors
					@params : plantcode,schedule
					@returns: color
					*/
					if($get_schedule!='' && $plant_code!=''){
						$result_bulk_colors=getBulkColors($get_schedule,$plant_code);
						$bulk_color=$result_bulk_colors['color_bulk'];
					}	
					foreach ($bulk_color as $bulk_color_value) {
						if(str_replace(" ","",$bulk_color_value)==str_replace(" ","",$get_color)) 
						{ 
							echo '<option value=\''.$bulk_color_value.'\' selected>'.$bulk_color_value.'</option>'; 
						} 
						else 
						{ 
							echo '<option value=\''.$bulk_color_value.'\'>'.$bulk_color_value.'</option>'; 
						}
					}
					echo "</select>";
				?>
			</div>
			<div class="col-sm-2 form-group">
				<label for='mpo'>Select Master PO:</label>
				<select required class='form-control' name='mpo' onchange='fourthbox();' id='mpo'>
				<?php
					echo "<option value=\"NIL\" selected>NIL</option>";
					/*function to get mpo from getdata_MPOs
					@params : plantcode,schedule,color
					@returns: mpo
					*/
					if($get_schedule!='' && $get_color!='' && $plant_code!=''){
						$result_bulk_MPO=getMpos($get_schedule,$get_color,$plant_code);
						$master_po_description=$result_bulk_MPO['master_po_description'];
					}	
					foreach ($master_po_description as $key=>$master_po_description_val) {
						if(str_replace(" ","",$master_po_description_val)==str_replace(" ","",$get_mpo)) 
						{ 
							echo '<option value=\''.$master_po_description_val.'\' selected>'.$key.'</option>'; 
						} 
						else 
						{ 
							echo '<option value=\''.$master_po_description_val.'\'>'.$key.'</option>'; 
						}
					} 
					echo "</select>";
				?>
			</div>
			<div class="col-sm-2 form-group">
				<label for='subpo'>Select Sub PO:</label>
				<select required class='form-control' name='sub_po' onchange='fifthbox();' id='sub_po'>
				<?php
					echo "<option value=\"NIL\" selected>NIL</option>";
					/*function to get subpo from getdata_bulk_subPO
						@params : plantcode,mpo
						@returns: subpo
						*/
					if($get_mpo!='' && $plant_code!=''){
						$result_bulk_subPO=getBulkSubPo($get_mpo,$plant_code);
						$sub_po_description=$result_bulk_subPO['sub_po_description'];
					}	
					foreach ($sub_po_description as $key=>$sub_po_description_val) {
						if(str_replace(" ","",$sub_po_description_val)==str_replace(" ","",$get_sub_po)) 
						{ 
							echo '<option value=\''.$sub_po_description_val.'\' selected>'.$key.'</option>'; 
						} 
						else 
						{ 
							echo '<option value=\''.$sub_po_description_val.'\'>'.$key.'</option>'; 
						}
					}
					echo "</select>";
				?>
			</div>

			
			<div class="col-sm-2 form-group">
			<?php
				echo "<input class='btn btn-success' type='submit' value='submit' name='submit' id='submit'>";	
			?>
			</div>
		</form>
</br>


<?php
if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];
	// $category=$_POST['category'];
	$mpo=$_POST['mpo'];
	$sub_po=$_POST['sub_po'];
	// get master po
	$qry_toget_podescri="SELECT master_po_description,master_po_number,mpo_serial FROM $pps.mp_order WHERE master_po_number ='$mpo' AND is_active=1";
    $toget_podescri_result=mysqli_query($link_new, $qry_toget_podescri) or exit("Sql Error at mp_order".mysqli_error($GLOBALS["___mysqli_ston"]));
    $toget_podescri_num=mysqli_num_rows($toget_podescri_result);
    if($toget_podescri_num>0){
        while($toget_podescri_row=mysqli_fetch_array($toget_podescri_result))
            {   
                $mpo_seq = getMasterPoSequence($toget_podescri_row['mpo_serial'],$plant_code);
                $masterr_po_seq = $mpo_seq."/".$toget_podescri_row["master_po_description"];
            }
	}

	// get sub po
	 /**Below query to get sub po's by using master po's */
	 $qry_toget_sub_order="SELECT po_description,po_number,mpo_serial,sub_po_serial FROM $pps.mp_sub_order LEFT JOIN $pps.mp_order ON mp_order.master_po_number = mp_sub_order.master_po_number WHERE mp_sub_order.master_po_number='$mpo' AND mp_sub_order.po_number='$sub_po'  AND mp_sub_order.plant_code='$plant_code' AND mp_sub_order.is_active=1";
	 $toget_sub_order_result=mysqli_query($link_new, $qry_toget_sub_order) or exit("Sql Error at mp_order".mysqli_error($GLOBALS["___mysqli_ston"]));

	 $toget_podescri_num=mysqli_num_rows($toget_sub_order_result);
	 if($toget_podescri_num>0){
		 while($toget_sub_order_row=mysqli_fetch_array($toget_sub_order_result))
			 {
				 $mpo_sequence = getMasterPoSequence($toget_sub_order_row['mpo_serial'],$plant_code);
				 $spo_sequnce = $mpo_sequence."-".$toget_sub_order_row['sub_po_serial'];
				 $spo_seq_desc = $spo_sequnce."/".$toget_sub_order_row['po_description'];
			 }
	 }
	
	
	

?>
	<div class="row">
		<div class="col-sm-12">
			<div class="col-sm-3">
				Style : <span class='text-danger'><b><?=$style?></b></span>
			</div>
			<div class="col-sm-3">
				Color : <span class='text-danger'><b><?=$color?></b></span>
			</div>
			<div class="col-sm-3">
				schedule : <span class='text-danger'><b><?=$schedule?></b></span>
			</div>
			<div class="col-sm-3">
				Master PO : <span class='text-danger'><b><?=$masterr_po_seq?></b></span>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="col-sm-3">
				Sub PO : <span class='text-danger'><b><?=$spo_seq_desc?></b></span>
			</div>
		</div>
	</div>
	</br>
	</br>
	<div class="row">
	  <div class="col-sm-12">
		<div class="col-sm-6">
			<?php

				$size_code=array();
				$excess_size_code=array();
				$quantitydetails = array();
				//To get sizes and qty
				$sql="SELECT SUM(quantity) AS quantity,size, percentage FROM $pps.`mp_mo_qty` left join $pps.mp_additional_qty on mp_additional_qty.mp_add_qty_id = mp_mo_qty.mp_add_qty_id WHERE SCHEDULE='$schedule' AND color='$color' AND mp_qty_type='ORIGINAL_QUANTITY' AND mp_mo_qty.plant_code='$plant_code' GROUP BY size order by size";
				$sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row=mysqli_fetch_array($sql_result))
				{
					$size_code[$row['size']]=$row['quantity'];
					$quantitydetails[$row['size']]['qty'] = $row['quantity'];
					$order_qty=$row['quantity'];
				}

				//To get excess qty
				$sql1="SELECT SUM(quantity) AS quantity,size, percentage FROM $pps.`mp_mo_qty` left join $pps.mp_additional_qty on mp_additional_qty.mp_add_qty_id = mp_mo_qty.mp_add_qty_id WHERE SCHEDULE='$schedule' AND color='$color' AND mp_qty_type='EXTRA_SHIPMENT' and size is not null AND mp_mo_qty.plant_code='$plant_code' GROUP BY size order by size";
				$sql_result1=mysqli_query($link, $sql1) or die("Error".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1=mysqli_fetch_array($sql_result1))
				{
					$excess_size_code[$row1['size']]=$row1['quantity'];
					$quantitydetails[$row1['size']]['exqty'] = $row1['quantity'];
					$quantitydetails[$row1['size']]['percentage'] = $row1['percentage'];
					$excess_order_qty=$row1['quantity'];
				}

				//To get Cutting wastage percentage
				$cuttingwastage="SELECT SUM(quantity) AS quantity,size, percentage FROM $pps.`mp_mo_qty` left join $pps.mp_additional_qty on mp_additional_qty.mp_add_qty_id = mp_mo_qty.mp_add_qty_id WHERE SCHEDULE='$schedule' AND color='$color' AND mp_qty_type='CUTTING_WASTAGE' and size is not null AND mp_mo_qty.plant_code='$plant_code' GROUP BY size order by size";
				$sql_result1=mysqli_query($link, $cuttingwastage) or die("Error".$cuttingwastage.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($cutting_wastage=mysqli_fetch_array($sql_result1))
				{
					$cut_percentage[$cutting_wastage['size']]=$cutting_wastage['percentage'];
				}
				//To get Total order qty
				$sql2="SELECT SUM(quantity) AS quantity FROM $pps.`mp_mo_qty` WHERE SCHEDULE='$schedule' AND color='$color' AND plant_code='$plant_code'";
				$sql_result2=mysqli_query($link, $sql2) or die("Error".$sql2.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row2=mysqli_fetch_array($sql_result2))
				{
					$total_order_qty=$row2['quantity'];
				}
				
				// To get planned cut qty 

				$cutqtyqry = "SELECT SUM(quantity) AS quantity, size FROM $pps.`mp_mo_qty` WHERE SCHEDULE='$schedule' AND color='$color' AND mp_qty_type='CUTTING_WASTAGE' AND plant_code='$plant_code' GROUP BY size order by size";



				$cutqtyqryresult = mysqli_query($link, $cutqtyqry) or die("Error".$cutqtyqry.mysqli_error($GLOBALS["___mysqli_ston"]));

				while($plannedcutqty=mysqli_fetch_array($cutqtyqryresult))
				{
					$cut_qty[$plannedcutqty['size']]=$plannedcutqty['quantity'];
				}


				// to get actual cut qty
				$qryGetcutqty ="SELECT sum(good_quantity) as good_quantity,style,schedule,color,size,parent_job,resource_id,DATE(created_at) as created_at,shift FROM $pts.transaction_log WHERE plant_code='$plant_code' AND `operation`=15 AND style ='$style' AND color ='$color' AND schedule ='$schedule' AND is_active=1 GROUP BY size ORDER BY size";

				$qryGetcutqtyresult = mysqli_query($link, $qryGetcutqty) or die("Error".$qryGetcutqty.mysqli_error($GLOBALS["___mysqli_ston"]));

				while($actualcutqty=mysqli_fetch_array($qryGetcutqtyresult))
				{
					$actual_cut_qty[$actualcutqty['size']]=$actualcutqty['good_quantity'];
				}


					// to get fabric not allocated qty
					$tot_qty=0;
					$Qry_get_cut_details="SELECT docket_number,jm_ad_id, jm_actual_docket.plies as actualplies, jm_dockets.created_at as docket_date, jm_actual_docket.created_at as cut_date, jm_actual_docket.cut_report_status, shift  FROM $pps.`jm_actual_docket` LEFT JOIN $pps.`jm_dockets` ON jm_dockets.`jm_docket_id` = jm_actual_docket.jm_docket_id WHERE po_number='$sub_po' AND jm_dockets.plant_code='$plant_code'";
					$sql_result6=mysqli_query($link, $Qry_get_cut_details) or die("Error".$Qry_get_cut_details.mysqli_error($GLOBALS["___mysqli_ston"]));
	
	
										while($fabnotallocated=mysqli_fetch_array($sql_result6))
										{
											$docket_no=$fabnotallocated['docket_number'];
											$actual_plies=$fabnotallocated['actualplies'];
												//To get docket_details
												$result_docket_qty=getDocketInformation($docket_no,$plant_code);
												$get_docket_qty=$result_docket_qty['docket_quantity'];
												$get_cut_no=$result_docket_qty['cut_no'];
												$doc_req=$total_order_qty*$consumption;
	
												 // get the docket info
												$docket_info_query = "SELECT doc.plies, doc.fg_color,doc.docket_number,
												doc.marker_version_id, doc.ratio_comp_group_id,
												cut.cut_number, cut.po_number,
												ratio_cg.component_group_id as cg_id, ratio_cg.ratio_id, ratio_cg.master_po_details_id
												FROM $pps.jm_dockets doc
												LEFT JOIN $pps.jm_cut_docket_map jcdm ON jcdm.jm_docket_id = doc.jm_docket_id
												LEFT JOIN $pps.jm_cut_job cut ON cut.jm_cut_job_id = jcdm.jm_cut_job_id
												LEFT JOIN $pps.lp_ratio_component_group ratio_cg ON ratio_cg.lp_ratio_cg_id = doc.ratio_comp_group_id
												WHERE doc.plant_code = '$plant_code' AND doc.docket_number='$docket_no' AND doc.is_active=true";
											$docket_info_result=mysqli_query($link_new, $docket_info_query) or exit("$docket_info_query".mysqli_error($GLOBALS["___mysqli_ston"]));
	
												while($row = mysqli_fetch_array($docket_info_result))
												{
													$plies =  $row['plies'];
													$po_number = $row['po_number'];
													$ratio_id = $row['ratio_id'];
												}
											 // get the docket qty
												$size_ratio_sum = 0;
												$size_ratios_query = "SELECT size, size_ratio FROM $pps.lp_ratio_size WHERE ratio_id = '$ratio_id' order by size";
												$size_ratios_result=mysqli_query($link_new, $size_ratios_query) or exit("Sql fabric_info_query".mysqli_error($GLOBALS["___mysqli_ston"]));
												$fabric_not_allocated_qty = array();
												$fabric_allocated_plies = 0;
												while($row = mysqli_fetch_array($size_ratios_result))
												{
													$planned_plies = $plies*$row['size_ratio'];
													$actul_plies = $actual_plies*$row['size_ratio'];
													$fabric_not_allocated_qty[$row['size']]+= $planned_plies - $actul_plies;
													$actual_cut[$row['size']]+= $actual_plies*$row['size_ratio'];
												}
										}
			?>

				<table class="table table-bordered table-responsive">
					<tr>
						<th class='danger'>Size</th>
						<?php
							foreach($size_code as $key => $value){
							echo "<td class='danger'><b>".$key."</b></td>";
							} 
							echo "<td class='danger'><b>Total</b></td>";
						?>
					</tr>
					<tr>
						<th class='danger'>Order Qty</th>
						<?php
							$sumqty = 0;
							$cnt =1;
							foreach($size_code as $key => $value){
								echo "<td class='success'>".$value."</td>";
								$sumqty+=$value;
								$cnt++;
							}
							echo "<td class='success'>".$sumqty."</td>";
						?>
					</tr>
					<tr>
						<th class='danger'>Order Quantity With Extra Shipment</th>
						<?php
							$esumqty = 0;
							$avgpercentage = 0;
							$excessduetosizeratio = array();
							foreach($quantitydetails as $key => $value){
								$percentage = ($value['percentage'])?$value['percentage']:0;
								$quantity = $value['qty'];
								$exqty = floor((($quantity/100)*$percentage)+$quantity);
								echo "<td class='success'>".$exqty."</td>";
								$esumqty+=$exqty;
								$totalcutplanqty[$key] = $exqty;
								$excessduetosizeratio[$key]['order_qty_with_extra_shipment'] = $exqty;
							}
							
							echo "<td class='success'>".$esumqty."</td>";
						?>
					</tr>
					<tr>
						<th class='danger'>Extra Shipment %</th>
						<?php
							foreach($quantitydetails as $key => $value){
								$percentage = ($value['percentage'])?$value['percentage']:0;
								echo "<td class='success'>".round($percentage,2)." %</td>";

							}
							$avgpercentage = (($sumqty/$esumqty));
							echo "<td class='success'>".round($percentage,2)." %</td>";
						?>
					</tr>
					<tr>
						<th class='danger'>Planned Excess Cut %</th>
						<?php
							$cnt =1;
							foreach($cut_percentage as $key => $value){
								$percentage = ($value['percentage'])?$value['percentage']:0;
								echo "<td class='success'>".$percentage." %</td>";
								$cnt++;
							}
							while($cnt<=count($size_code)){
								echo "<td class='success'>0</td>";
								$cnt++;
							}
							echo "<td class='success'>".$percentage." %</td>";
						?>
						
					</tr>
					<tr>
						<th class='danger'>Planned Excess Cut QTY</th>
						<?php
							$sumqty = 0;
							$cnt =1;
							foreach($cut_qty as $key => $value){
								echo "<td class='success'>".$value."</td>";
								$sumqty+=$value;
								$cnt++;
								$totalcutplanqty[$key]+= $value;
								$excessduetosizeratio[$key]['planned_excess_cut_qty'] = $value;
							}
							while($cnt<=count($size_code)){
								echo "<td class='success'>0</td>";
								$cnt++;
							}
							echo "<td class='success'>".$sumqty."</td>";
						?>
						
					</tr>
					<tr>
						<th class='danger'>Excess due to size ratio</th>
						<?php
							foreach($totalcutplanqty as $key => $value){
								$excessduetosizeratio[$key]['total_cut_plan_qty'] = $value;
							}
							$sumqty = 0;
							foreach($excessduetosizeratio as $key => $value){
								$excess_due_to_size_ratio = ($value['total_cut_plan_qty']-($value['order_qty_with_extra_shipment']+$value['planned_excess_cut_qty']));
								echo "<td class='success'>".$excess_due_to_size_ratio."</td>";
							}
							echo "<td class='success'>".$sumqty."</td>";
						?>
						
					</tr>
					<tr>
						<th class='danger'>Total Cut Plan Qty</th>
						<?php
							$sumqty = 0;
							$cnt =1;
							$actualpercentage = array();
							foreach($totalcutplanqty as $key => $value){
								echo "<td class='success'>".$value."</td>";
								$sumqty+=$value;
								$cnt++;
								$actualpercentage[$key]['total_cut_plan'] = $value;
							}
							while($cnt<count($size_code)){
								echo "<td class='success'>0</td>";
								$cnt++;
							}
							echo "<td class='success'>".$sumqty."</td>";
						?>
						
					</tr>
					<tr>
						<th class='danger'>Fabric not allocated qty</th>
						<?php
							$notallocatedsum = 0;
							if(count($fabric_not_allocated_qty)){
								foreach($fabric_not_allocated_qty as $key => $value){
									$notallocated = ($value)?$value:0;
									echo "<td class='success'>".$notallocated."</td>";
									$notallocatedsum+=$notallocated;
								}
							}else{
								foreach($size_code as $key => $value){
									echo "<td class='success'>0</td>";
								}	
							}
							
							echo "<td class='success'>".$notallocatedsum."</td>";
						?>
					</tr>
					<tr>
						<th class='danger'>Actual cut qty</th>
						<?php
							$sumqty = 0;
							$cnt =1;
							foreach($actual_cut as $key => $value){
								echo "<td class='success'>".$value."</td>";
								$sumqty+=$value;
								$cnt++;
								$actualpercentage[$key]['actual_cut'] = $value;
							}
							while($cnt<=count($size_code)){
								echo "<td class='success'>0</td>";
								$cnt++;
							}
							echo "<td class='success'>".$sumqty."</td>";
						?>
					</tr>
					<tr>
						<th class='danger'>Actual cut %</th>
						<?php
							$sumqty = 0;
							$cnt =1;
							foreach($actualpercentage as $key => $value){
								$actual_cut =  $value['actual_cut'];
								$total_cut_plan =  $value['total_cut_plan'];
								$actual_cut_percentage = round((($actual_cut/$total_cut_plan)*100),2);
								$totalactual+= $value['actual_cut'];
								$totalplanned+= $value['total_cut_plan'];
								echo "<td class='success'>".$actual_cut_percentage." %</td>";
							}
							$avgcutpercentage = round((($totalactual/$totalplanned)*100),2);
							echo "<td class='success'>".$avgcutpercentage." %</td>";
						?>
						
					</tr>
					<tr>
						<th class='danger'>Balance to Cut qty</th>
						<?php
							$sumqty = 0;
							$cnt =1;
							foreach($actualpercentage as $key => $value){
								$actual_cut =  $value['actual_cut'];
								$total_cut_plan =  $value['total_cut_plan'];
								$balance_to_cut_qty = $value['total_cut_plan'] - $value['actual_cut'];
								echo "<td class='success'>".$balance_to_cut_qty."</td>";
								$sumqty+=$balance_to_cut_qty;
							}
							echo "<td class='success'>".$sumqty."</td>";
						?>
					</tr>		
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
							<?php
									$tot_qty=0;
									$Qry_get_cut_details="SELECT docket_number,jm_ad_id, jm_actual_docket.plies as actualplies, jm_dockets.created_at as docket_date, jm_actual_docket.created_at as cut_date, jm_actual_docket.cut_report_status,shift  FROM $pps.`jm_actual_docket` LEFT JOIN $pps.`jm_dockets` ON jm_dockets.`jm_docket_id` = jm_actual_docket.jm_docket_id WHERE po_number='$sub_po' AND jm_dockets.plant_code='$plant_code' order by docket_number";
									$sql_result6=mysqli_query($link, $Qry_get_cut_details) or die("Error".$Qry_get_cut_details.mysqli_error($GLOBALS["___mysqli_ston"]));
									if(mysqli_num_rows($sql_result6))
									{
							?>
					<table class="table table-bordered table-responsive">
							<tr>
								<th colspan=2></th>
								<th colspan=<?=count($size_code)?>>Size Ratio</th>
								<th colspan=3></th>
								<th colspan=<?=count($size_code)?>>Actual Cut Details</th>
								<th colspan=7></th>
							</tr>
							<tr class="primary">
								<th>Docket No</th>
								<th>Cut No</th>
								<?php
									foreach($size_code as $key => $value){
									echo "<td class='danger'><b>".$key."</b></td>";
									} 
								?>
								<th>Total of the size ratio</th>
								<th>Plan plies</th>
								<!-- <th>Fabric Allocated plies</th> -->
								<th>Actual plies</th>
								<?php
									foreach($size_code as $key => $value){
									echo "<td class='danger'><b>".$key."</b></td>";
									} 
								?>
								<th>Total</th>
								<th>Cut Status</th>
								<th>Docket planned date</th>
								<th>Cut date</th>
								<!-- <th>Cut Table</th> -->
								<th>Shift</th>
								<!-- <th>Input Status</th> -->
								<th>Latest Input Date</th>
								<th>Module</th>
							</tr>
							<?php
									while($row6=mysqli_fetch_array($sql_result6))
									{
										$docket_no=$row6['docket_number'];
										$lay_id=$row6['jm_ad_id'];
										//$cut_status=$row6['lay_status'];
										$actual_plies=$row6['actualplies'];
										// $docket_date=$row6['docket_date'];
										$cut_date=$row6['cut_date'];
										$cut_report_status=$row6['cut_report_status'];
										//$lay_number=$row6['lay_number'];
										$shift=$row6['shift'];
								
											//To get docket_details
											$result_docket_qty=getDocketInformation($docket_no,$plant_code);
											$get_docket_qty=$result_docket_qty['docket_quantity'];
											$get_cut_no=$result_docket_qty['cut_no'];
											$doc_req=$total_order_qty*$consumption;

											 // get the docket info
											$docket_info_query = "SELECT doc.plies, doc.fg_color,doc.docket_number,
											doc.marker_version_id, doc.ratio_comp_group_id,
											cut.cut_number, cut.po_number,
											ratio_cg.component_group_id as cg_id, ratio_cg.ratio_id, ratio_cg.master_po_details_id
											FROM $pps.jm_dockets doc
											LEFT JOIN $pps.jm_cut_docket_map jcdm ON jcdm.jm_docket_id = doc.jm_docket_id
											LEFT JOIN $pps.jm_cut_job cut ON cut.jm_cut_job_id = jcdm.jm_cut_job_id
											LEFT JOIN $pps.lp_ratio_component_group ratio_cg ON ratio_cg.lp_ratio_cg_id = doc.ratio_comp_group_id
											WHERE doc.plant_code = '$plant_code' AND doc.docket_number='$docket_no' AND doc.is_active=true";
										$docket_info_result=mysqli_query($link_new, $docket_info_query) or exit("$docket_info_query".mysqli_error($GLOBALS["___mysqli_ston"]));

											while($row = mysqli_fetch_array($docket_info_result))
											{
												$fg_color = $row['fg_color'];
												$plies =  $row['plies'];
												$comp_group =  $row['cg_name'];
												$cut_no = $row['cut_number'];
												$ratio_comp_group_id = $row['ratio_comp_group_id'];
												$docket_number = $row['docket_number'];
												$po_number = $row['po_number'];
												$marker_version_id = $row['marker_version_id'];
												$ratio_id = $row['ratio_id'];
												$cg_id = $row['cg_id'];
												$mp_detail_id = $row['master_po_details_id'];
											}
											echo "<tr>";
											echo "<td>$docket_no</td>";
											echo "<td>$get_cut_no</td>";
										 // get the docket qty
											$size_ratio_sum = 0;
											$size_ratios_query = "SELECT size, size_ratio FROM $pps.lp_ratio_size WHERE ratio_id = '$ratio_id' order by size";
											$size_ratios_result=mysqli_query($link_new, $size_ratios_query) or exit("Sql fabric_info_query".mysqli_error($GLOBALS["___mysqli_ston"]));
											$actual_cut = array();
											$fabric_allocated_plies = 0;
											while($row = mysqli_fetch_array($size_ratios_result))
											{
												$size_ratio_sum += $row['size_ratio'];
												echo "<td>".$row['size_ratio']."</td>";
												$actual_cut[$row['size']] = $actual_plies*$row['size_ratio'];
												$fabric_allocated_plies+= $plies*$row['size_ratio'];
											}
											echo "<td>$size_ratio_sum</td>";
											echo "<td>$plies</td>";
											// echo "<td>$fabric_allocated_plies</td>";
											echo "<td>$actual_plies</td>";
											$sumqty = 0;
											foreach($actual_cut as $key => $value){
												echo "<td>".$value."</td>";
												$sumqty+=$value;
												$cnt++;
											}
											echo "<td>".$sumqty."</td>";
											if($actual_plies==$plies){
												echo "<td> Full Completed </td>";
											}else if($actual_plies<$plies){
												echo "<td> Partially Completed</td>";
											}else if($actual_plies==0){
												echo "<td> Not Started </td>";
											}
											
											// get docket date 
											$get_docket_date = "SELECT task_attributes.task_header_id, task_header.created_at as docket_date, task_header.updated_at as latest_updated_date, task_header.resource_id FROM $tms.task_attributes left join $tms.task_header on  task_header.task_header_id = task_attributes.task_header_id WHERE attribute_value = '$docket_no' and task_attributes.plant_code = '$plant_code' and task_attributes.task_header_id is not null";
											$get_docket_date_result=mysqli_query($link_new, $get_docket_date) or exit("Sql get docket date qry".mysqli_error($GLOBALS["___mysqli_ston"]));

											while($get_date = mysqli_fetch_array($get_docket_date_result))
											{
												$docket_date = date('Y-m-d',strtotime($get_date['docket_date']));
												$latest_updated_date = date('Y-m-d',strtotime($get_date['latest_updated_date']));
												$resource_id = $get_date['resource_id'];
											}
											$docket_date = ($docket_date)?$docket_date: ' - ';
											$latest_updated_date = ($latest_updated_date)?$latest_updated_date: ' - ';
											echo "<td>".$docket_date."</td>";
											echo "<td>".date('Y-m-d',strtotime($cut_date))."</td>";
											// echo "<td>".$lay_number."</td>";
											echo "<td>".$shift."</td>";
											echo "<td>".$latest_updated_date."</td>";
											//To get workstation description
											$query = "select workstation_description from $pms.workstation where plant_code='$plant_code' and workstation_id = '".$resource_id."' AND is_active=1";
											$query_result=mysqli_query($link_new, $query) or exit("Sql Error at workstation_description".mysqli_error($GLOBALS["___mysqli_ston"]));
											while($des_row=mysqli_fetch_array($query_result))
											{
												$workstation_description = $des_row['workstation_description'];
											}
											echo "<td>".$workstation_description."</td>";
											
										
											echo "</tr>";
									}		
							
							?>
					</table>
					<?php
					}else{
						echo "<div><h4 style='color:red; text-align:center;'>No Dockets</h4></div>";
					}
					?>
		</div>
	</div>
	

<?php
}//closing isset(POST) 
?>

</div><!-- panel body -->
</div><!--  panel -->
</div>

 