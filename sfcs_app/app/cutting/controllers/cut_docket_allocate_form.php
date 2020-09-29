<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
include(getFullURLLevel($_GET['r'],'common/config/functions_v2.php',3,'R'));
include(getFullURLLevel($_GET['r'],'docket_allocation_functions.php',0,'R'));

$path="".getFullURLLevel($_GET['r'], "bundle_guide_print.php", "0", "r")."";

$plant_code=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
// $plant_code='AIP';
// $username='Mounika';
// L3NmY3NfYXBwL2FwcC9jdXR0aW5nL2NvbnRyb2xsZXJzL2N1dF9kb2NrZXRfYWxsb2NhdGVfZm9ybS5waHA=

?>

<script>

function firstbox()
{
	window.location.href ="<?= 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value
}

function secondbox()
{
	var uriVal = "<?= 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value;
	window.location.href = uriVal;
}

function thirdbox()
{
	var uriVal = "<?= 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+encodeURIComponent(document.test.color.value);
	window.location.href = uriVal;
}

function forthbox() 
{ 
	var uriVal = "<?= 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+encodeURIComponent(document.test.color.value)+"&mpo="+document.test.mpo.value;
	window.location.href = uriVal;
}
function fifthbox() 
{ 
	var uriVal = "<?= 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+encodeURIComponent(document.test.color.value)+"&mpo="+document.test.mpo.value+"&sub_po="+document.test.sub_po.value;
	window.location.href = uriVal;
}

$(document).ready(function() {
	$('#schedule').on('click',function(e){
		var style = $('#style').val();
		if(style == null){
			sweetAlert('Please Select Style','','warning');
		}
	});
	$('#color').on('click',function(e){
		var style = $('#style').val();
		var schedule = $('#schedule').val();
		if(style == null && schedule == null){
			sweetAlert('Please Select Style and Schedule','','warning');
		}
		else if(schedule == null){
			sweetAlert('Please Select Schedule','','warning');
			document.getElementById("submit").disabled = true;
		}
		else {
			document.getElementById("submit").disabled = false;
		}
	});
});

</script>


<?php
	$style=$_GET['style'];
	$schedule=$_GET['schedule']; 
    $color=$_GET['color'];
    $mpo=$_GET['mpo'];
    $sub_po=$_GET['sub_po'];
?>

<div class = "panel panel-primary">
<div class = "panel-heading">Cut Docket Allocation Form</div>
<div class = "panel-body">
<form name="test" method="post">
<?php
//function to get style from mp_color_details	
if($plant_code!=''){
	$result_mp_color_details=getMpColorDetail($plant_code);
	$get_style=$result_mp_color_details['style'];
}
echo "<div class=\"row\"><div class=\"col-sm-2\"><label>Select Style:</label><select class='form-control' name=\"style\"  id=\"style\" onchange=\"firstbox();\" id='style' required>";
echo "<option value='' disabled selected>Please Select</option>";
foreach ($get_style as $style_value) {
	if(str_replace(" ","",$style_value)==str_replace(" ","",$style)) 
	{ 
		echo '<option value=\''.$style_value.'\' selected>'.$style_value.'</option>'; 
	} 
	else 
	{ 
		echo '<option value=\''.$style_value.'\'>'.$style_value.'</option>'; 
	}
} 
echo "  </select>
	</div>";
?>

<?php
echo "<div class='col-sm-2'><label>Select Schedule:</label> 
	  <select class='form-control' name=\"schedule\" id=\"schedule\" onchange=\"secondbox();\" id='schedule' required>";
//qry to get schedules form mp_mo_qty based on master_po_details_id 
if($style!=''&& $plant_code!=''){
	$result_bulk_schedules=getBulkSchedules($style,$plant_code);
	$bulk_schedule=$result_bulk_schedules['bulk_schedule'];
}  
echo "<option value='' disabled selected>Please Select</option>";
foreach ($bulk_schedule as $bulk_schedule_value) {
	if(str_replace(" ","",$bulk_schedule_value)==str_replace(" ","",$schedule)) 
	{ 
		echo '<option value=\''.$bulk_schedule_value.'\' selected>'.$bulk_schedule_value.'</option>'; 
	} 
	else 
	{ 
		echo '<option value=\''.$bulk_schedule_value.'\'>'.$bulk_schedule_value.'</option>'; 
	}
} 

echo "	</select>
	 </div>";
?>

<?php
//function to get color form mp_mo_qty based on schedules and plant code from mp_mo_qty
if($schedule!='' && $plant_code!=''){
	$result_bulk_colors=getBulkColors($schedule,$plant_code);
	$bulk_color=$result_bulk_colors['color_bulk'];
}

echo "<div class='col-sm-2'><label>Select Color:</label><select class='form-control' name=\"color\" onchange=\"thirdbox();\" id='color' required>";
echo "<option value='' disabled selected>Please Select</option>";
foreach ($bulk_color as $bulk_color_value) {
	if(str_replace(" ","",$bulk_color_value)==str_replace(" ","",$color)) 
	{ 
		echo '<option value=\''.$bulk_color_value.'\' selected>'.$bulk_color_value.'</option>'; 
	} 
	else 
	{ 
		echo '<option value=\''.$bulk_color_value.'\'>'.$bulk_color_value.'</option>'; 
	}
} 
echo "</select>
	</div>";

	//function to get master po's from mp_mo_qty based on schedule and color
if($schedule!='' && $color!='' && $plant_code!=''){
	$result_bulk_MPO=getMpos($schedule,$color,$plant_code);
	$master_po_description=$result_bulk_MPO['master_po_description'];
}
	echo "<div class='col-sm-2'><label>Select Master PO: </label>";  
	echo "<select name=\"mpo\" onchange=\"forthbox();\" class='form-control' >
			<option value=\"NIL\" selected>NIL</option>";
				foreach ($master_po_description as $key=>$master_po_description_val) {
					if(str_replace(" ","",$master_po_description_val)==str_replace(" ","",$mpo)) 
					{ 
						echo '<option value=\''.$master_po_description_val.'\' selected>'.$key.'</option>'; 
					} 
					else 
					{ 
						echo '<option value=\''.$master_po_description_val.'\'>'.$key.'</option>'; 
					}
				} 
	echo "</select></div>";

	//function to get sub po's from mp_mo_qty based on master PO's
	if($mpo!='' && $plant_code!=''){
		$result_bulk_subPO=getBulkSubPo($mpo,$plant_code);
		$sub_po_description=$result_bulk_subPO['sub_po_description'];
	}
	echo "<div class='col-sm-2'><label>Select Sub PO: </label>";  
	echo "<select name=\"sub_po\" id=\"sub_po\"  class='form-control' >
			<option value=\"NIL\" selected>NIL</option>";
				foreach ($sub_po_description as $key=>$sub_po_description_val) {
					if(str_replace(" ","",$sub_po_description_val)==str_replace(" ","",$sub_po)) 
					{ 
						echo '<option value=\''.$sub_po_description_val.'\' selected>'.$key.'</option>'; 
					} 
					else 
					{ 
						echo '<option value=\''.$sub_po_description_val.'\'>'.$key.'</option>'; 
					}
				} 
	echo "</select></div>";

echo "<div class='col-sm-3' style='padding-top:23px;'>"; 
echo "<input class='btn btn-success' type=\"submit\" value=\"Submit\" name=\"submit\" id='submit'>
	 </div>";	
echo "</div>";
?>

</form>

<hr/>

<?php
if(isset($_POST['submit']))
{

	$style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];
	$mpo=$_POST['mpo'];
    $sub_po=$_POST['sub_po'];
	$sno=1;	
	if($sub_po!='' && $plant_code!='')
	{
		$result_get_doc_details=getJobsDetails($sub_po,$plant_code);
		$data=$result_get_doc_details['data'];
	}
	if(sizeof($data)>0)
	{
		echo "<div class='alert alert-info' style='text-align:center; font-size: 20px;'><b>Style Code : ".$data['cut']['style'][0]."</b>Schedule : <b>".$data['cut']['schedule'][0]."</b> VPO No : <b>".$data['cut']['po_description']."</b></div>";
		
		echo "<div class='col-sm-12 table-responsive'>
		<table width='100%' class='table table-bordered info'><thead>
		<tr><th>S No</th><th>Color</th><th>Sewing Job No</th><th>Cut Job No</th><th>Cut Docket No</th>";
		for($s=0;$s<sizeof($data['cut']['size']);$s++)
		{
			echo "<th>".$data['cut']['size'][$s]."</th>";
		}
		echo "<th>Plies</th><th>Quantity</th><th>Cumulative Quantity</th><th>".$fab_uom."</th></tr></thead>";
		for($i=0;$i<sizeof($data);$i++)
		{
			echo "<tr><td>".$sno."</td><td>".$data['cut']['color'][0]."</td><td>".$data['cut']['sewing_job']."</td><td>".$data['cut']['cutjob']."</td><td>".$data['cut']['doc_no']."</td>";
			foreach($data['cut']['size'] as $key =>$value){
				echo "<td>".$data['cut'][$value]."</td>";
			}
			echo "<td>".$data['cut']['plies']."</td>";
			echo "<td>".$data['cut']['qty']."</td>";
			echo "<td>".$data['cut']['cum_qty']."</td>";
			echo "<td>".$data['cut']['marker_length']."</td></tr>";
			$sno++;
		}
		echo "</table></div>";
	}
}

	
   ?> 
   </div>
   </div>
   </div>
   </div>
  