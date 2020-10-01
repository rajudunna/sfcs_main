<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
include(getFullURLLevel($_GET['r'],'common/config/functions_v2.php',3,'R'));

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
		$qry_cut_numbers="SELECT jm_cut_job_id FROM $pps.jm_cut_job WHERE po_number='$sub_po' AND plant_code='$plant_code' GROUP BY cut_number";
		// echo $qry_cut_numbers;
		$toget_cut_result=mysqli_query($link_new, $qry_cut_numbers) or exit("Sql Error at cutnumbers".mysqli_error($GLOBALS["___mysqli_ston"]));
		$toget_cut_num=mysqli_num_rows($toget_cut_result);
		$count = 0;
		if($toget_cut_num>0){
		while($toget_cut_row=mysqli_fetch_array($toget_cut_result))
		{
			$cut_job_id[]=$toget_cut_row['jm_cut_job_id'];
		}
		
			foreach($cut_job_id as $key1 => $cut_job){
				//qry to get dockets using cut_job_id
				$qry_get_dockets="SELECT jm_docket_id From $pps.jm_dockets WHERE jm_cut_job_id in ('$cut_job') AND plant_code='$plant_code' order by docket_number ASC";
				$toget_dockets_result=mysqli_query($link_new, $qry_get_dockets) or exit("Sql Error at dockets".mysqli_error($GLOBALS["___mysqli_ston"]));
				$toget_dockets_num=mysqli_num_rows($toget_dockets_result);
				if($toget_dockets_num>0)
				{
					while($toget_docket_row=mysqli_fetch_array($toget_dockets_result))
					{
						$jm_docketss[]=$toget_docket_row['jm_docket_id']; 
					}
					$jm_dockets = implode("','", $jm_docketss);
				}
				//qry to get dockets in through dockets id
				$qry_get_docketlines="SELECT jm_docket_line_id,docket_line_number FROM $pps.jm_docket_lines WHERE jm_docket_id IN ('$jm_dockets') AND plant_code='$plant_code' order by docket_line_number";
				// echo $qry_get_docketlines;
				$qry_get_docketlines_result=mysqli_query($link_new, $qry_get_docketlines) or exit("Sql Error at docket lines".mysqli_error($GLOBALS["___mysqli_ston"]));
				$docketlines_num=mysqli_num_rows($qry_get_docketlines_result);
				if($docketlines_num>0){
					while($docketline_row=mysqli_fetch_array($qry_get_docketlines_result))
					{
						$docket_nos[] = $docketline_row['docket_line_number']; 
					}
					$doc = implode(",", $docket_nos);
					$data['cut']['doc_no'] = $doc;
					$docket_no = implode("','", $docket_nos);
				}
		
				$marker_length=0;
				$cum_qty=0;
				$docket_info_query = "SELECT doc_line.plies,doc_line.fg_color,doc.marker_version_id,doc.ratio_comp_group_id,cut.cut_number,cut.po_number,ratio_cg.ratio_id,mso.po_description FROM $pps.jm_docket_lines doc_line LEFT JOIN $pps.jm_dockets doc ON doc.jm_docket_id = doc_line.jm_docket_id LEFT JOIN $pps.jm_cut_job cut ON cut.jm_cut_job_id = doc.jm_cut_job_id LEFT JOIN $pps.mp_sub_order mso ON mso.po_number = cut.po_number LEFT JOIN $pps.lp_ratio_component_group ratio_cg ON ratio_cg.ratio_wise_component_group_id = doc.ratio_comp_group_id WHERE doc_line.plant_code = '$plant_code' AND doc_line.docket_line_number in ('$docket_no') AND cut.jm_cut_job_id = '$cut_job' AND doc_line.is_active=true";
				// var_dump($docket_info_query);
				$docket_info_result=mysqli_query($link_new,$docket_info_query) or exit("$docket_info_query".mysqli_error($GLOBALS["___mysqli_ston"]));
				if($docket_info_result>0){
					while($row = mysqli_fetch_array($docket_info_result))
					{
						$data['cut']['color'] = $row['fg_color'];
						$data['cut']['cutjob'] = $row['cut_number'];
						$data['cut']['plies'] =  $row['plies'];
						$data['cut']['po_number'] = $row['po_number'];
						$data['cut']['po_description'] = $row['po_description'];
		
						$ratio_id = $row['ratio_id'];
						$marker_id = $row['marker_version_id'];
						
						$size_ratios='';
						$qry_ratio_size="SELECT size,size_ratio FROM $pps.lp_ratio_size WHERE ratio_id='$ratio_id' AND plant_code='$plant_code'";
						$qry_ratio_size_result=mysqli_query($link_new, $qry_ratio_size) or exit("Sql Errorat_size_ratios".mysqli_error($GLOBALS["___mysqli_ston"]));
						$qry_ratio_size_num=mysqli_num_rows($qry_ratio_size_result);
						if($qry_ratio_size_num>0){
							$s=0;
							$ratio_sum=0;
							while($sql_row1=mysqli_fetch_array($qry_ratio_size_result))
							{   
								$data['cut']['size'][$s] = $sql_row1['size'];
								$data['cut'][$data['cut']['size'][$s]] = $sql_row1['size_ratio'];
								$ratio_sum += $sql_row1['size_ratio'];
								$s++;
							}
						}
						$data['cut']['qty'] = ($ratio_sum * $data['cut']['plies']);
						$cum_qty += $data['cut']['qty'];
						$data['cut']['cum_qty'] = $cum_qty;
		
						$get_marker_details="SELECT length From $pps.lp_markers WHERE marker_version_id in ('$marker_id') AND plant_code='$plant_code' and default_marker_version=1";
						// echo $get_marker_details;
						$get_marker_details_result=mysqli_query($link_new, $get_marker_details) or exit("Sql Error at dockets".mysqli_error($GLOBALS["___mysqli_ston"]));
						$get_marker_details_num=mysqli_num_rows($get_marker_details_result);
						if($get_marker_details_num>0)
						{
							while($get_marker_details_row=mysqli_fetch_array($get_marker_details_result))
							{
								$length=$get_marker_details_row['length']; 
								$marker_length = $length * $data['cut']['plies'];
							}
						}
						$data['cut']['marker_length'] =  $marker_length;
					}
				}
		
		
				$style=array();
				$color=array();
				$schedule=array();
				//To get schedule,color
				$qry_get_sch_col="SELECT schedule,color FROM $pps.`mp_sub_mo_qty` LEFT JOIN $pps.`mp_mo_qty` ON mp_sub_mo_qty.`master_po_details_mo_quantity_id`= mp_mo_qty.`master_po_details_mo_quantity_id`
				WHERE po_number='$sub_po' AND mp_sub_mo_qty.plant_code='$plant_code'";
				$qry_get_sch_col_result=mysqli_query($link_new, $qry_get_sch_col) or exit("Sql Error at qry_get_sch_col".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row=mysqli_fetch_array($qry_get_sch_col_result))
				{
					$schedule[]=$row['schedule'];
					$color[]=$row['color'];
				}
				$color_bulk=array_unique($color);
				$data['cut']['color']=array_unique($color);
		
				//To get style
				$qry_get_style="SELECT style FROM $pps.`mp_mo_qty` LEFT JOIN $pps.`mp_color_detail` ON mp_color_detail.`master_po_details_id`=mp_mo_qty.`master_po_details_id` WHERE mp_mo_qty.color in ('".implode("','" , $color_bulk)."') and mp_color_detail.plant_code='$plant_code'";
				$qry_get_style_result=mysqli_query($link_new, $qry_get_style) or exit("Sql Error at qry_get_style".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1=mysqli_fetch_array($qry_get_style_result))
				{
					$style[]=$row1['style'];
				}    
				$data['cut']['style']=array_unique($style);
				$data['cut']['schedule']=array_unique($schedule);

				//Qry to fetch jm_job_header_id from jm_jobs_header
				$get_jm_job_header_id="SELECT jm_job_header_id FROM $pps.jm_job_header WHERE ref_id='$cut_job' AND plant_code='$plant_code'";
				$jm_job_header_id_result=mysqli_query($link_new, $get_jm_job_header_id) or exit("Sql Error at get_jm_job_header_id".mysqli_error($GLOBALS["___mysqli_ston"]));
				$jm_job_header_id_result_num=mysqli_num_rows($jm_job_header_id_result);
				if($jm_job_header_id_result_num>0){
					while($jm_job_header_id_row=mysqli_fetch_array($jm_job_header_id_result))
					{
						$jm_job_header_id[]=$jm_job_header_id_row['jm_job_header_id'];
					}
				}
				
				$get_job_details = "SELECT jg.job_number as job_number FROM $pps.jm_jg_header jg LEFT JOIN $pps.jm_job_bundles bun ON bun.jm_jg_header_id = jg.jm_jg_header_id WHERE jg.plant_code = '$plant_code' AND job_group=3 AND jg.jm_job_header IN ('".implode("','" , $jm_job_header_id)."') AND jg.is_active=1";
				// echo $get_job_details.'<br/>';
				$get_job_details_result=mysqli_query($link_new, $get_job_details) or exit("$get_job_details".mysqli_error($GLOBALS["___mysqli_ston"]));
				if($get_job_details_result>0){
					while($get_job_details_row=mysqli_fetch_array($get_job_details_result))
					{
						$job_numbers[] = $get_job_details_row['job_number'];
					}
					$job_numbers = implode(",", array_unique($job_numbers));
				
					$data['cut']['sewing_job'] = trim($job_numbers,"'");
			
				}
				if($count == 0){
					echo "<div class='alert alert-info' style='text-align:center; font-size: 20px;'><b>Style Code : ".implode(",",array_unique($data['cut']['style']))."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Schedule : <b>".implode(",",array_unique($data['cut']['schedule']))."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sub PO: <b>".$data['cut']['po_description']."</b></div>";
					echo "<div class='col-sm-12 table-responsive'>
					<table width='100%' class='table table-bordered info'><thead>
					<tr><th>S No</th><th>Color</th><th>Sewing Job No</th><th>Cut Job No</th><th>Cut Docket No</th>";
					for($s=0;$s<sizeof($data['cut']['size']);$s++)
					{
						echo "<th>".$data['cut']['size'][$s]."</th>";
					}
					echo "<th>Plies</th><th>Quantity</th><th>Cumulative Quantity</th><th>".$fab_uom."</th></tr></thead>";
					$count++;
				}
				echo "<tr><td>".$count."</td><td>".implode(",",array_unique($data['cut']['color']))."</td><td>".$data['cut']['sewing_job']."</td><td>".$data['cut']['cutjob']."</td><td>".$data['cut']['doc_no']."</td>";
				foreach($data['cut']['size'] as $key =>$value){
					echo "<td>".$data['cut'][$value]."</td>";
				}
				echo "<td>".$data['cut']['plies']."</td>";
				echo "<td>".$data['cut']['qty']."</td>";
				echo "<td>".$data['cut']['cum_qty']."</td>";
				echo "<td>".$data['cut']['marker_length']."</td></tr>";
				$count++;
				unset($jm_docketss);
				unset($docket_nos);
				unset($schedule);
				unset($color);
				unset($style);
				unset($jm_job_header_id);
				unset($job_numbers);
			}
			echo "</table></div>";
		}
	}
}

	
   ?> 
   </div>
   </div>
   </div>
   </div>
  