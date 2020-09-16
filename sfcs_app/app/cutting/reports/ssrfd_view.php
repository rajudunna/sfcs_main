<?php 
$url1 =  $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R');
include("$url1");  
$url2 =  $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'); 
include("$url2");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',3,'R')); 
$plant_code=$_SESSION['plantCode'];
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
		<b>Style Status Report - Fabric Details</b>
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
				<label for='mpo'>Select PoNumber:</label>
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
				<label for='subpo'>Select PoNumber:</label>
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
					 $sql="SELECT fabric_category FROM $pps.`mp_color_detail` LEFT JOIN $pps.`mp_fabric` ON mp_fabric.master_po_details_id=mp_color_detail.master_po_details_id WHERE style='$get_style' AND color='$get_color' AND mp_fabric.master_po_number='$get_mpo' AND mp_fabric.plant_code='$plant_code'";		
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



<?php
if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];
	$category=$_POST['category'];
	$sub_po=$_POST['sub_po'];
	
	if($style!="NIL" && $color!="NIL" && $schedule!="NIL" && $category!="NIL"){
	}else{
	echo"Please Select All Filters</br>";
	}
	
	$size_code=array();
	$excess_size_code=array();
	//To get sizes and qty
	
	$sql="SELECT SUM(quantity) AS quantity,size FROM $pps.`mp_mo_qty` WHERE SCHEDULE='$schedule' AND color='$color' AND plant_code='$plant_code' AND master_po_order_qty_type='ORIGINAL_QUANTITY' GROUP BY size";
	$sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($sql_result))
	{
		$size_code[$row['size']]=$row['quantity'];
		$order_qty=$row['quantity'];
	}
	//To get excess qty
	$sql1="SELECT SUM(quantity) AS quantity,size FROM $pps.`mp_mo_qty` WHERE SCHEDULE='$schedule' AND color='$color' AND plant_code='$plant_code' AND master_po_order_qty_type='EXTRA_SHIPMENT' GROUP BY size";
	$sql_result1=mysqli_query($link, $sql1) or die("Error".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($sql_result1))
	{
		$excess_size_code[$row1['size']]=$row1['quantity'];
		$excess_order_qty=$row1['quantity'];
	}
	//To get Total order qty
	$sql2="SELECT SUM(quantity) AS quantity FROM $pps.`mp_mo_qty` WHERE SCHEDULE='$schedule' AND color='$color' AND plant_code='$plant_code'";
	$sql_result2=mysqli_query($link, $sql2) or die("Error".$sql2.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row2=mysqli_fetch_array($sql_result2))
	{
		$total_order_qty=$row2['quantity'];
	}
	
	//OrderConsumption
	//To get wastage and consumption
	$Qry_get_order_consumption="SELECT SUM(consumption) AS consumption,SUM(wastage_perc) AS wastage FROM $oms.`oms_mo_items` LEFT JOIN $oms.`oms_products_info` ON oms_mo_items.`mo_number`=oms_products_info.`mo_number` WHERE style='$style' AND color_desc='$color' AND operation_code=15";
	$sql_result3=mysqli_query($link, $Qry_get_order_consumption) or die("Error".$Qry_get_order_consumption.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row3=mysqli_fetch_array($sql_result3))
	{
		$consumption=$row3['consumption'];
		$cut_wastage=$row3['wastage'];
	}
	//To get mo qty aganist style,schedule,color
	$Qry_get_quantity="SELECT SUM(mo_quantity) as mo_qty FROM $oms.`oms_mo_details` LEFT JOIN $oms.`oms_products_info` ON oms_mo_details.`mo_number`=oms_products_info.`mo_number` WHERE style='$style' AND SCHEDULE='$schedule' AND color_desc='$color' AND oms_mo_details.plant_code='$plant_code'";
	$sql_result4=mysqli_query($link, $Qry_get_quantity) or die("Error".$Qry_get_quantity.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row4=mysqli_fetch_array($sql_result4))
	{
		$mo_qty=$row4['mo_qty'];
	}
	if($cut_wastage > 0)
	{
		$wastage=$cut_wastage;
	}else
	{
		$wastage=1;
	}

	$order_consumption=(($mo_qty*$consumption*$wastage)/100);
	$lay_id=array();
	$tot_cutable_qty=0;
	//Actual Consumption
	$Qry_get_cut_details="SELECT docket_line_number,lp_lay_id FROM $pps.`lp_lay` LEFT JOIN $pps.`jm_docket_lines` ON jm_docket_lines.`jm_docket_line_id` = lp_lay.jm_docket_line_id WHERE po_number='$sub_po' AND jm_docket_lines.plant_code='$plant_code'";
	$sql_result5=mysqli_query($link, $Qry_get_cut_details) or die("Error".$Qry_get_cut_details.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row5=mysqli_fetch_array($sql_result5))
	{
		$docket_no=$row5['docket_line_number'];
		$lay_id[]=$row5['lp_lay_id'];
		
		$result_docket_qty=getDocketInformation($docket_no,$plant_code);
		$get_docket_qty=$result_docket_qty['$docket_quantity'];

		$tot_cutable_qty +=$get_docket_qty;
	}
	//To get fabric attributes
	$fabric_attributes=array();
	$qrt_get_attributes="SELECT * FROM $pps.lp_lay_attribute WHERE lp_lay_id in ('".implode("','" , $lay_id)."') and plant_code='$plant_code'";
	$sql_result6=mysqli_query($link, $qrt_get_attributes) or die("Error".$qrt_get_attributes.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row6=mysqli_fetch_array($sql_result6))
	{
		$fabric_attributes[$row6['attribute_name']] = $row6['attribute_value'];
	}
	$fabric_recevied=  $fabric_attributes[$fabric_lay_attributes['fabricrecevied']];
	$fabric_returned=  $fabric_attributes[$fabric_lay_attributes['fabricreturned']];
	$shortages=  $fabric_attributes[$fabric_lay_attributes['shortages']];
	$damages=  $fabric_attributes[$fabric_lay_attributes['damages']];
	$endbits=  $fabric_attributes[$fabric_lay_attributes['endbits']];
	$joints=  $fabric_attributes[$fabric_lay_attributes['joints']];
	
	//CAD Consumption Caliculation
	$cad_consumption=(($tot_cutable_qty*$consumption*$wastage)/100);
	$cad_consumption_saving=((($order_consumption - $cad_consumption) * 100)/$order_consumption);
	//Actual Consumption Caliculation
	$actual_consumption=(($fabric_recevied - $fabric_returned)/$tot_cutable_qty);
	$actual_consumption_saving=((($order_consumption - $actual_consumption) * 100)/$order_consumption);
	//Net Consumption Caliculation
	$net_consumption=(($fabric_recevied - $fabric_returned - $damages - $shortages)/$tot_cutable_qty);
	$net_consumption_saving=((($order_consumption - $net_consumption) * 100)/$order_consumption);

?>
<hr>
<div class="col-sm-12 ">
	<div class="row">
			<h4>RMS Request Report</h4>
	</div><br>
	<div class="row">
		<div class="col-sm-3">
			<div class="col-sm-6 black"><b>Style : </b></div>
			<div class="col-sm-6 "><p class='text-danger'><?php echo $style ?></p></div>
		</div>
		<div class="col-sm-3">
			<div class="col-sm-6 black"><b>Schedule : </b></div>
			<div class="col-sm-6"><p class='text-danger'><?php echo $schedule ?></p></div>
		</div>
		<div class="col-sm-3">
			<div class="col-sm-6 black"><b>Color : </b></div>
			<div class="col-sm-6"><p class='text-danger'><?php echo $color ?></p></div>
		</div>
		<div class="col-sm-3">
			<div class="col-sm-6 black"><b>Category : </b></div>
			<div class="col-sm-6"><p class='text-danger'><?php echo $category ?></p></div>
		</div>
	</div>
</div>

<div class='col-sm-6' style='overflow-x:scroll'>
	<table class="table table-bordered table-responsive">
		<tr>
			<th class='danger'>Size</th>
			<?php
				foreach($size_code as $key => $value){
                  echo "<td class='danger'>".$key."</td>";
			    } 
			?>
		</tr>
		<tr>
			<th class='danger'>Order Qty</th>
			<?php
				foreach($size_code as $key => $value){
					echo "<td class='danger'>".$value."</td>";
				}
			?>
		</tr>
		<tr>
			<th class='danger'>Extra Cut</th>
			<?php
				foreach($excess_size_code as $key => $value){
					echo "<td class='danger'>".$value."</td>";
				}
			?>
		</tr>		
	</table>
</div>


 <div class='col-sm-3'>
	<table class="table table-bordered table-responsive">
			<tr>
				<th class='success'>Ordering Consumption:</th>
				<td><?php echo $order_consumption; ?></td>
				<td>Saving</td>
			</tr>
			<tr>
				<th class='success'>CAD Consumption:</th>
				<td><?php  echo round($cad_consumption,4);  ?></td>
				<td><?php  echo $cad_consumption_saving; ?>%</td>
			</tr>
			<tr>
				<th class='success'>Actual Consumption:</th>
				<td><?php echo round($actual_consumption,4);  ?></td>
				<td><?php echo $actual_consumption_saving; ?>% </td>
			</tr>	
			<tr>
				<th class='success'>Net Consumption:</th>
				<td><?php echo round($net_consumption,4);  ?></td>
				<td><?php echo $net_consumption_saving; ?>%</td>
			</tr>	
	</table>
</div>
<div class='col-sm-3'>
	<table class="table table-bordered table-responsive">
			<tr>
				<th class='success'>Ordered Fabric:</th>
				<td><?php echo round(($cat_yy*$o_total),0); ?></td>
			</tr> 
			<tr>
				<th class='success'>Allocated Fabric:</th>
				<td><?php echo round(($newyy2*$act_total_sum),0); ?></td>
			</tr>
			<tr>
				<th class='success'>Actual Utilization:</th>
				<td><?php echo round(($fabric_recevied - $fabric_returned),0); ?></td>
			</tr>
			<tr>
				<th class='success'>Net Utilization:</th>
				<td><?php echo round(($fabric_recevied - $fabric_returned - $damages - $shortages),0); ?></td>
			</tr>
			<tr>
				<th class='success'>Fabric Shortage:</th>
				<td><?php echo ($shortages); ?></td>
			</tr>
			<tr>
				<th class='success'>Fabric Damage:</th>
				<td><?php echo ($damages); ?></td>
			</tr>
	</table>
</div>


<?php 
	echo "<div class='col-sm-12' style='overflow-x:scroll'>
	<table class='table table-sm table-bordered table-responsive'>
	<tr class='info'>
	<th>DocketNo</th>
	<th>Cut No</th>
	<th>Total</th>
	<th>Cut Status</th>
	<th>Input Status</th>
	<th>Docket Requested</th>
	<th>Fabric Received</th>
	<th>Fabric Returned</th>
	<th>Damages</th>
	<th>Shortages</th>
	<th>Joints</th>
	<th>Endbits</th>
	<th>Net Utlization</th>
	<th>Ordering Consumption</th>
	<th>Actual Consumption</th>
	<th>Net Consumption</th>
	<th>Actual Saving</th>
	<th>Pct</th>
	<th>Net Saving</th>
	<th>Pct</th>
	</tr>";
	$tot_qty=0;
	$Qry_get_cut_details="SELECT docket_line_number,lp_lay_id,lay_status FROM $pps.`lp_lay` LEFT JOIN $pps.`jm_docket_lines` ON jm_docket_lines.`jm_docket_line_id` = lp_lay.jm_docket_line_id WHERE po_number='$sub_po' AND jm_docket_lines.plant_code='$plant_code'";
	$sql_result6=mysqli_query($link, $Qry_get_cut_details) or die("Error".$Qry_get_cut_details.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row6=mysqli_fetch_array($sql_result6))
	{
		$docket_no=$row6['docket_line_number'];
		$lay_id=$row6['lp_lay_id'];
		$cut_status=$row6['lay_status'];

			//To get docket_details
			$result_docket_qty=getDocketInformation($docket_no,$plant_code);
			$get_docket_qty=$result_docket_qty['$docket_quantity'];
			$get_cut_no=$result_docket_qty['$cut_no'];
			$doc_req=$total_order_qty*$consumption;
			
			//To get fabric attributes
			$fabricattributes=array();
			$qrt_get_attributes1="SELECT * FROM $pps.lp_lay_attribute WHERE lp_lay_id= '$lay_id' and plant_code='$plant_code'";
			$sql_result7=mysqli_query($link, $qrt_get_attributes1) or die("Error".$qrt_get_attributes1.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row7=mysqli_fetch_array($sql_result7))
			{
				$fabricattributes[$row7['attribute_name']] = $row7['attribute_value'];
			}
			$fabric_recevied1=  $fabricattributes[$fabric_lay_attributes['fabricrecevied']];
			$fabric_returned1=  $fabricattributes[$fabric_lay_attributes['fabricreturned']];
			$shortages1=  $fabricattributes[$fabric_lay_attributes['shortages']];
			$damages1=  $fabricattributes[$fabric_lay_attributes['damages']];
			$endbits1=  $fabricattributes[$fabric_lay_attributes['endbits']];
			$joints1=  $fabricattributes[$fabric_lay_attributes['joints']];
			$net_util= $fabric_recevied1 - $fabric_returned1 - $damages1 - $shortages1;
			$act_con=round((($fabric_recevied1 - $fabric_returned1)/$get_docket_qty));
			$net_con=round($net_util/$get_docket_qty,4);
            $act_saving=round(($order_consumption*$get_docket_qty)-($act_con*$order_consumption),1);
			$act_saving_pct=round((($order_consumption-$act_con)/$order_consumption)*100,0);
			$net_saving=round(($order_consumption*$get_docket_qty)-($net_con*$get_docket_qty),1);
			$net_saving_pct=round((($order_consumption-$net_con)/$order_consumption)*100,0);
			
			echo "<tr>";
			echo "<td>$docket_no</td>";
			echo "<td>$get_cut_no</td>";
			echo "<td>$get_docket_qty</td>";
			echo "<td>$cut_status</td>";
			echo "<td>$cut_status</td>";
			echo "<td>".($doc_req+round($doc_req*0.01,2))."</td>";
			echo "<td>$fabric_recevied1</td>";
			echo "<td>$fabric_returned1</td>";
			echo "<td>$damages1</td>";
			echo "<td>$shortages1</td>";
			echo "<td>$joints1</td>";
			echo "<td>".round($endbits1,4)."</td>";
			echo "<td>$net_util</td>";
			echo "<td>$order_consumption</td>";
			echo "<td>$act_con</td>";
			echo "<td>$net_con</td>";
			echo "<td>$act_saving</td>";
			echo "<td>$act_saving_pct%</td>";
			echo "<td>$net_saving</td>";
			echo "<td>$net_saving_pct%</td>";
			echo "</tr>";
	}		
	echo "	</table></div>";
}//closing isset(POST) 
?>

</div><!-- panel body -->
</div><!--  panel -->
</div>

 