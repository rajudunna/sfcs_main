<?php 
include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include(getFullURLLevel($_GET['r'],'common/config/server_urls.php',4,'R'));
include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
include(getFullURLLevel($_GET['r'],'common/config/functions_v2.php',4,'R'));
$path="".getFullURLLevel($_GET['r'], "bundle_guide_print.php", "0", "r")."";
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
?>
<script>
var url = '<?= getFullURLLevel($_GET['r'],'generate_bundle_guide_report.php',0,'N'); ?>';
function firstbox() 
{ 
    window.location.href =url+"&style="+document.test.style.value 
} 

function secondbox() 
{ 
    window.location.href =url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value 
} 

function thirdbox() 
{ 
    window.location.href =url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value 
}
function forthbox() 
{ 
    window.location.href =url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value 
}
function fifthbox() 
{ 
    window.location.href =url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value+"&sub_po="+document.test.sub_po.value 
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

//use this function for check all the boxes
function checkAll()
{
     var checkboxes = document.getElementsByTagName('input'), val = null;    
     for (var i = 0; i < checkboxes.length; i++)
     {
         if (checkboxes[i].type == 'checkbox')
         {
             if (val === null) val = checkboxes[i].checked;
             checkboxes[i].checked = val;
         }
     }
}
</script>
<head>
<?php
	$get_style=$_GET['style'];
	$get_schedule=$_GET['schedule']; 
	$get_color=$_GET['color'];
	$get_mpo=$_GET['mpo'];
	$get_sub_po=$_GET['sub_po'];

?>

<div class = "panel panel-primary">
<div class = "panel-heading">Generate Bundle Guide</div>
<div class = "panel-body">
<form name="test" action="<?php echo getFullURLLevel($_GET['r'],'generate_bundle_guide_report.php','0','N'); ?>" method="post">
<?php

//function to get style from mp_color_details
if($plantcode!=''){
	$result_mp_color_details=getMpColorDetail($plantcode);
	$style=$result_mp_color_details['style'];
}
echo "<div class='row'>"; 
echo "<div class='col-sm-3'><label>Select Style: </label><select name=\"style\" onchange=\"firstbox();\" class='form-control' required>"; 
echo "<option value=\"\" selected>NIL</option>";
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
echo "</select></div>";
//qry to get schedules form mp_mo_qty based on master_po_details_id 
if($get_style!=''&& $plantcode!=''){
	$result_bulk_schedules=getBulkSchedules($get_style,$plantcode);
	$bulk_schedule=$result_bulk_schedules['bulk_schedule'];
}  
echo "<div class='col-sm-3'><label>Select Schedule: </label><select name=\"schedule\" onchange=\"secondbox();\" class='form-control' required>";  
echo "<option value=\"\" selected>NIL</option>";
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
echo "</select></div>";

//function to get color form mp_mo_qty based on schedules and plant code from mp_mo_qty
if($get_schedule!='' && $plantcode!=''){
	$result_bulk_colors=getBulkColors($get_schedule,$plantcode);
	$bulk_color=$result_bulk_colors['color_bulk'];
}
echo "<div class='col-sm-3'><label>Select Color: </label>";  
echo "<select name=\"color\" onchange=\"thirdbox();\" class='form-control' >
		<option value=\"NIL\" selected>NIL</option>";
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
echo "</select></div>";

//function to get master po's from mp_mo_qty based on schedule and color
if($get_schedule!='' && $get_color!='' && $plantcode!=''){
	$result_bulk_MPO=getMpos($get_schedule,$get_color,$plantcode);
	$master_po_description=$result_bulk_MPO['master_po_description'];
}
	echo "<div class='col-sm-3'><label>Select Master PO: </label>";  
	echo "<select name=\"mpo\" onchange=\"forthbox();\" class='form-control' >
			<option value=\"NIL\" selected>NIL</option>";
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
	echo "</select></div>";

	//function to get sub po's from mp_mo_qty based on master PO's
	if($get_mpo!='' && $plantcode!=''){
		$result_bulk_subPO=getBulkSubPo($get_mpo,$plantcode);
		$sub_po_description=$result_bulk_subPO['sub_po_description'];
	}
	echo "<div class='col-sm-3'><label>Select Sub PO: </label>";  
	echo "<select name=\"sub_po\" id=\"sub_po\"  class='form-control' >
			<option value=\"NIL\" selected>NIL</option>";
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
	echo "</select></div>";

?>
		<input type="hidden" id="plant_code" name="plant_code" value='<?= $plantcode; ?>'>
		<input type="hidden" id="username" name="username" value='<?= $username; ?>'>
		
		<div class='col-sm-3' style='padding-top:23px;'>
			<input class='btn btn-success' type="submit" value="Submit" name="submit" id='submit'>
		</div>	
</div>
	</form>
</br>

<hr/>

<?php
if(isset($_POST['submit']))
{
	$ponum=$_POST['sub_po'];
	$mpo=$_POST['mpo'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];
	$style=$_POST['style'];
	$plant_code=$_POST['plant_code'];
	$username=$_POST['username'];
	
	//getting cut number based on po number
	$get_cut_number_qry="SELECT cut_number,jm_cut_job_id FROM $pps.`jm_cut_job` WHERE po_number='$ponum' AND plant_code='$plant_code'";
	$get_cut_number_qry_result=mysqli_query($link, $get_cut_number_qry) or exit("Sql Error while getting cutno".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row_cut=mysqli_fetch_array($get_cut_number_qry_result))
	{
		$cut_number=$sql_row_cut['cut_number'];
		$jm_cut_job_id=$sql_row_cut['jm_cut_job_id'];
		
		//getting docket id
		$get_docid_qry="SELECT jm_docket_id FROM $pps.`jm_dockets` WHERE plant_code='$plant_code' AND jm_cut_job_id='$jm_cut_job_id'";
		$get_docid_qry_result=mysqli_query($link, $get_docid_qry) or exit("Sql Error while getting docket id".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row_docid=mysqli_fetch_array($get_docid_qry_result))
		{
			$jm_docket_id=$sql_row_docid['jm_docket_id'];
			
			//getting jm docket line id
			$get_docline_qry="SELECT jm_docket_id FROM $pps.`jm_dockets` WHERE plant_code='$plant_code' AND jm_docket_id='$jm_docket_id'";
			$get_docline_qry_result=mysqli_query($link, $get_docline_qry) or exit("Sql Error while getting doclineid".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row_doclineid=mysqli_fetch_array($get_docline_qry_result))
			{
				$jm_docket_line_id=$sql_row_doclineid['jm_docket_id'];
				
				//getting details from jm_docket_cg_bundle
				$get_det_qry="SELECT size FROM $pps.`jm_docket_cg_bundle` WHERE plant_code='$plant_code' AND jm_docket_line_id='$jm_docket_line_id'";
				$get_det_qry_result=mysqli_query($link, $get_det_qry) or exit("Sql Error while getting details".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row_det=mysqli_fetch_array($get_det_qry_result))
				{
					$sizesarr[]=$sql_row_det['size'];
				}
			}
		}
	}
	echo "<div class='col-sm-12 table-responsive'><table width='100%' class='table table-bordered info'><thead><tr><th>Cut No</th><th>Docket No</th>";
	for($j=0;$j<sizeof(array_unique($sizesarr));$j++)
	{
		echo "<th>".$sizesarr[$j]."</th>";
	}
    echo "<th>Control</th></tr></thead>";
	
	
			//getting cut number based on po number
			$get_cut_number_qry="SELECT cut_number,jm_cut_job_id FROM $pps.`jm_cut_job` WHERE po_number='$ponum' AND plant_code='$plant_code'";
			$get_cut_number_qry_result=mysqli_query($link, $get_cut_number_qry) or exit("Sql Error while getting cutno".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row_cut=mysqli_fetch_array($get_cut_number_qry_result))
			{
				$cut_number=$sql_row_cut['cut_number'];
				$jm_cut_job_id=$sql_row_cut['jm_cut_job_id'];
				
				//getting docket id
				$get_docid_qry="SELECT jm_docket_id FROM $pps.`jm_dockets` WHERE plant_code='$plant_code' AND jm_cut_job_id='$jm_cut_job_id'";
				$get_docid_qry_result=mysqli_query($link, $get_docid_qry) or exit("Sql Error while getting docket id".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row_docid=mysqli_fetch_array($get_docid_qry_result))
				{
					$jm_docket_id=$sql_row_docid['jm_docket_id'];
					
					//getting jm docket line id
					$get_docline_qry="SELECT jm_docket_id,docket_number FROM $pps.`jm_dockets` WHERE plant_code='$plant_code' AND jm_docket_id='$jm_docket_id'";
					$get_docline_qry_result=mysqli_query($link, $get_docline_qry) or exit("Sql Error while getting doclineid".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row_doclineid=mysqli_fetch_array($get_docline_qry_result))
					{
						$jm_docket_line_id=$sql_row_doclineid['jm_docket_id'];
						$docket_line_number=$sql_row_doclineid['docket_number'];
						
						echo "<tr>";
						echo "<td>".$cut_number."</td>";
						echo "<td>".$docket_line_number."</td>";
						for($i=0;$i<sizeof(array_unique($sizesarr));$i++)
						{
							//getting details from jm_docket_cg_bundle
							$get_det_qry="SELECT sum(quantity) as quantity FROM $pps.`jm_docket_cg_bundle` WHERE plant_code='$plant_code' AND jm_docket_line_id='$jm_docket_line_id' and size='".$sizesarr[$i]."'";
							$get_det_qry_result=mysqli_query($link, $get_det_qry) or exit("Sql Error while getting details".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row_det=mysqli_fetch_array($get_det_qry_result))
							{
								$quantity=$sql_row_det['quantity'];
							}
							echo "<td>".$quantity."</td>";
						}
						echo "<td><a href=\"$path?doc_no=".$docket_line_number."&plant_code=".$plant_code."&style=".$style."&schedule=".$schedule."&color=".$color."&mpo=".$mpo."&ponum=".$ponum."&cut_number=".$cut_number."\" onclick=\"Popup1=window.open('$path?doc_no=".$docket_line_number."&plant_code=".$plant_code."&style=".$style."&schedule=".$schedule."&color=".$color."&mpo=".$mpo."&ponum=".$ponum."&cut_number=".$cut_number."','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\" class='btn btn-sm btn-primary'>Print</a></td>";
						echo "</tr>";
					}
				}
			}
	
	echo "</div>";
}

	
?> 
</div>
</div>

  