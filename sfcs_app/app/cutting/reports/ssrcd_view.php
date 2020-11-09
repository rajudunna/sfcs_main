<?php 
$url1 =  $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R');
include("$url1");  
$url2 =  $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'); 
include("$url2");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',3,'R')); 
// $plant_code=$_SESSION['plantCode'];
$plant_code='AIP';
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
function sixthbox()
{
	window.location.href ="<?php echo 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value+"&sub_po="+document.test.sub_po.value+"&category="+document.test.category.value
}

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
	$('#category').on('mouseup',function(e){
		style = $('#style').val();
		schedule = $('#schedule').val();
		color = $('#color').val();
		if(style === 'NIL' && schedule === 'NIL' && color === 'NIL'){
			sweetAlert('Please Select Style, Schedule and Color','','warning');
		}
		else if(schedule === 'NIL' && color === 'NIL'){
			sweetAlert('Please Select Schedule and Color','','warning');
		}
		else if(color === 'NIL'){
			sweetAlert('Please Select Color','','warning');
		}
		else {
			document.getElementById("submit").disabled = false;
		}
	});
	$('#submit').on('click',function(e){
		category = $('#category').val();
		if(category === 'NIL') {
			sweetAlert('Please Select Category','','warning');
			document.getElementById("submit").disabled = true;
		}
		else {
			document.getElementById("submit").disabled = false;
		}
	});

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
$category=$_GET['category'];

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
if(isset($_POST['category']))
{
	$category=$_POST['category'];
}
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
				<label for='category'>Select Category:</label>
				<select required class='form-control' name='category' onchange='sixthbox();'  id='category'>
				<?php				
					 $sql="SELECT fabric_category FROM $pps.`mp_color_detail` LEFT JOIN $pps.`mp_fabric` ON mp_fabric.master_po_details_id=mp_color_detail.master_po_details_id WHERE style='$get_style' AND color='$get_color' AND mp_fabric.plant_code='$plant_code'";		
					 $sql_result=mysqli_query($link, $sql) or exit();
					 $sql_num_check=mysqli_num_rows($sql_result);
 
					 echo "<option value=\"NIL\" selected>NIL</option>";
						 
					 while($sql_row=mysqli_fetch_array($sql_result))
					 {
						 if(str_replace(" ","",$sql_row['fabric_category'])==str_replace(" ","",$category)){
							 echo "<option value=\"".$sql_row['fabric_category']."\" selected>".$sql_row['fabric_category']."</option>";
						 }else{
							 echo "<option value=\"".$sql_row['fabric_category']."\">".$sql_row['fabric_category']."</option>";
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
	$category=$_POST['category'];
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
				Category : <span class='text-danger'><b><?=$category?></b></span>
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
				$sql="SELECT SUM(quantity) AS quantity,size, percentage FROM $pps.`mp_mo_qty` left join $pps.mp_additional_qty on mp_additional_qty.mp_add_qty_id = mp_mo_qty.mp_add_qty_id WHERE SCHEDULE='$schedule' AND color='$color' AND mp_qty_type='ORIGINAL_QUANTITY' AND mp_mo_qty.plant_code='$plant_code' GROUP BY size";
				$sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row=mysqli_fetch_array($sql_result))
				{
					$size_code[$row['size']]=$row['quantity'];
					$quantitydetails[$row['size']]['qty'] = $row['quantity'];
					$quantitydetails[$row['size']]['percentage'] = $row['percentage'];
					$order_qty=$row['quantity'];
				}

				//To get excess qty
				$sql1="SELECT SUM(quantity) AS quantity,size FROM $pps.`mp_mo_qty` WHERE SCHEDULE='$schedule' AND color='$color' AND mp_qty_type='EXTRA_SHIPMENT' AND plant_code='$plant_code' GROUP BY size";
				$sql_result1=mysqli_query($link, $sql1) or die("Error".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1=mysqli_fetch_array($sql_result1))
				{
					$excess_size_code[$row1['size']]=$row1['quantity'];
					$quantitydetails[$row['size']]['exqty'] = $row['quantity'];
					$excess_order_qty=$row1['quantity'];
				}
				//To get Total order qty
				$sql2="SELECT SUM(quantity) AS quantity FROM $pps.`mp_mo_qty` WHERE SCHEDULE='$schedule' AND color='$color' AND plant_code='$plant_code'";
				$sql_result2=mysqli_query($link, $sql2) or die("Error".$sql2.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row2=mysqli_fetch_array($sql_result2))
				{
					$total_order_qty=$row2['quantity'];
				}
				
				// To get planned cut qty 

				$cutqtyqry = "SELECT SUM(quantity) AS quantity, size FROM $pps.`mp_mo_qty` WHERE SCHEDULE='$schedule' AND color='$color' AND mp_qty_type='CUTTING_WASTAGE' AND plant_code='$plant_code' GROUP BY size";



				$cutqtyqryresult = mysqli_query($link, $cutqtyqry) or die("Error".$cutqtyqry.mysqli_error($GLOBALS["___mysqli_ston"]));

				while($plannedcutqty=mysqli_fetch_array($cutqtyqryresult))
				{
					$cut_qty['size']=$plannedcutqty['quantity'];
				}





				// to get actual cut qty
				$qryGetcutqty ="SELECT sum(good_quantity) as good_quantity,style,schedule,color,size,parent_job,resource_id,DATE(created_at) as created_at,shift FROM $pts.transaction_log WHERE plant_code='$plant_code' AND `operation`=15 AND style ='$style' AND color ='$color' AND schedule ='$schedule' AND is_active=1 GROUP BY size ORDER BY operation, style,shift,parent_job*1
					";

				$qryGetcutqtyresult = mysqli_query($link, $qryGetcutqty) or die("Error".$qryGetcutqty.mysqli_error($GLOBALS["___mysqli_ston"]));

				while($actualcutqty=mysqli_fetch_array($qryGetcutqtyresult))
				{
					$actual_cut_qty['size']=$actualcutqty['good_quantity'];
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
							foreach($quantitydetails as $key => $value){
								$percentage = ($value['percentage'])?$value['percentage']:0;
								$quantity = $value['qty'];
								$exqty = ((($quantity/100)*$percentage)+$quantity);
								echo "<td class='success'>".$exqty."</td>";
								$esumqty+=$exqty;
								$totalcutplanqty[$key] = $exqty;
							}
							echo "<td class='success'>".$esumqty."</td>";
							// var_dump($totalcutplanqty);
						?>
					</tr>
					<tr>
						<th class='danger'>Extra Shipment %</th>
						<?php
							foreach($quantitydetails as $key => $value){
								$percentage = ($value['percentage'])?$value['percentage']:0;
								echo "<td class='success'>".$percentage."</td>";

							}
							$avgpercentage = (($sumqty/$esumqty));
							echo "<td class='success'>".$percentage."</td>";
						?>
					</tr>
					<tr>
						<th class='danger'>Planned Excess Cut %</th>
						
					</tr>
					<tr>
						<th class='danger'>Planned Excess Cut QTY</th>
						<?php
							$sumqty = 0;
							$cnt =1;
							// var_dump(count($size_code));
							foreach($cut_qty as $key => $value){
								echo "<td class='success'>".$value."</td>";
								$sumqty+=$value;
								$cnt++;
								$totalcutplanqty[$key]+= $value;
							}
							while($cnt<=count($size_code)){
								echo "<td class='success'>0</td>";
								$cnt++;
								$totalcutplanqty[$key]+= 0;
							}
							echo "<td class='success'>".$sumqty."</td>";
						?>
						
					</tr>
					<tr>
						<th class='danger'>Excess due to size ratio</th>
						
					</tr>
					<tr>
						<th class='danger'>Total Cut Plan Qty</th>
						<?php
							$sumqty = 0;
							$cnt =1;
							// var_dump(count($size_code));
							foreach($totalcutplanqty as $key => $value){
								echo "<td class='success'>".$value."</td>";
								$sumqty+=$value;
								$cnt++;
							var_dump($cnt, ", ",count($size_code));
							echo "</br>";
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
						
					</tr>
					<tr>
						<th class='danger'>Actual cut qty</th>
						<?php
							$sumqty = 0;
							$cnt =1;
							// var_dump(count($size_code));
							foreach($actual_cut_qty as $key => $value){
								echo "<td class='success'>".$value."</td>";
								$sumqty+=$value;
								$cnt++;
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
						
					</tr>
					<tr>
						<th class='danger'>Balance to Cut qty</th>
						
					</tr>		
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
					<table class="table table-bordered table-responsive">
							<tr>
								<th colspan=2></th>
								<th colspan=<?=count($size_code)?>>Size Ratio</th>
								<th colspan=4></th>
								<th colspan=<?=count($size_code)?>>Actual Cut Details</th>
								<th colspan=9></th>
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
								<th>Fabric Allocated plies</th>
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
								<th>Cut Table</th>
								<th>Shift</th>
								<th>Input Status</th>
								<th>Latest Input Date</th>
								<th>Module</th>
							</tr>
					</table>
		</div>
	</div>
	

<?php
}//closing isset(POST) 
?>

</div><!-- panel body -->
</div><!--  panel -->
</div>

 