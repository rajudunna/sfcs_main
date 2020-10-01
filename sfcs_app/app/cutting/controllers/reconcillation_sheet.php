<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
$path="".getFullURLLevel($_GET['r'], "bundle_guide_print.php", "0", "r")."";
?>
<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',3,'R'));
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',3,'R')); 
?>

<script>

//<form name="test" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">

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
	var uriVal = "<?= 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&mpo="+document.test.mpo.value;
	window.location.href = uriVal;
}
function forthbox()
{
	var uriVal = "<?= 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&mpo="+document.test.mpo.value+"&sub_po="+document.test.sub_po.value;
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
<link href="style.css" rel="stylesheet" type="text/css" />
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<?php
	$plantcode = $_SESSION['plantCode'];
	$get_style=$_GET['style'];
	$get_schedule=$_GET['schedule']; 
	$get_mpo=$_GET['mpo']; 
	$get_sub_po=$_GET['sub_po']; 
    if(isset($_POST['submit']))
    {
        $style=$_POST['style'];
        $schedule=$_POST['schedule'];
        $mpo=$_POST['mpo'];
		$sub_po=$_POST['sub_po'];
    }
?>

<div class = "panel panel-primary">
<div class = "panel-heading">Module Reconcillaiton Form</div>
<div class = "panel-body">
<form name="test" action="?r=<?php echo $_GET['r']; ?>" method="post">
<?php
//function to get style from mp_color_details
if($plantcode!=''){
	$result_mp_color_details=getMpColorDetail($plantcode);
	$style=$result_mp_color_details['style'];
}
echo "<div class=\"row\"><div class=\"col-sm-2\"><label>Select Style:</label><select class='form-control' name=\"style\"  id=\"style\" onchange=\"firstbox();\" id='style' required>";
echo "<option value='' disabled selected>Please Select</option>";
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
?>

<?php
	//qry to get schedules form mp_mo_qty based on master_po_details_id 
	if($get_style!=''&& $plantcode!=''){
		$result_bulk_schedules=getBulkSchedules($get_style,$plantcode);
		$bulk_schedule=$result_bulk_schedules['bulk_schedule'];
	}
echo "<div class='col-sm-2'><label>Select Schedule:</label> 
	  <select class='form-control' name=\"schedule\" id=\"schedule\" onchange=\"secondbox();\" id='schedule' required>";
	echo "<option value='' disabled selected>Please Select</option>";
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
?>

<?php
	//qry to get master po's form mp_mo_qty based on master_po_details_id 
	if($get_schedule!=''&& $plantcode!=''){
		$resultMpSchedulewise=getMpSchedulewise($get_schedule,$plantcode);
		$master_po_description=$resultMpSchedulewise['master_po_des_sched'];
	}
	echo "<div class='col-sm-3'><label>Select Master PO: </label>";  
	echo "<select name=\"mpo\" onchange=\"thirdbox();\" class='form-control' >
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
?>

<?php
	//function to get sub po's from mp_mo_qty based on master PO's
	if($get_mpo!='' && $plantcode!=''){
		$result_bulk_subPO=getBulkSubPo($get_mpo,$plantcode);
		$sub_po_description=$result_bulk_subPO['sub_po_description'];
	}
	echo "<div class='col-sm-3'><label>Select Sub PO: </label>";  
	echo "<select name=\"sub_po\" onchange=\"forthbox();\" class='form-control' >
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

<?php

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
	$schedule=$_POST['schedule'];
	$mpo=$_POST['mpo'];
	$sub_po=$_POST['sub_po'];
	$sno=1;
	
	$taskType = TaskTypeEnum::PLANNEDSEWINGJOB;
	$taskTypeSej = TaskTypeEnum::PLANNEDSEWEMBELLISHMENTJOB;
		
	$sewing_job=array();
	$sewing_job_cols=array();
	$sewing_job_qty=array();
	$sewing_job_bundle=array();
	$cuts_sew=array();
	$sewing_job_rand=array();

	/**
	 * getting VPO number based on PO number
	 */
	$qryGetVPO="SELECT vpo FROM $oms.oms_mo_details WHERE po_number='$mpo' AND plant_code='$plantcode' AND is_active='1' LIMIT 0,1";
	$getVpoResult=mysqli_query($link_new, $qryGetVPO) or exit("Error while getting VPO number ".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($getVpoResult)>0){
		while($getVpoRow=mysqli_fetch_array($getVpoResult))
		{
			$vpo=$getVpoRow['vpo'];
		}
	}else{
		$vpo="-";
	}


	/**
	 * getting po description
	 */
	$qryGetPodescrip="SELECT po_description FROM $pps.mp_sub_order WHERE po_number='$sub_po' AND plant_code='$plantcode' AND is_active=1";
	$poDescripResult=mysqli_query($link_new, $qryGetPodescrip) or exit("Error while getting po description ".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($poDescripResult)>0){
		while($poDescripRow=mysqli_fetch_array($poDescripResult))
		{
			$po_description=$poDescripRow['po_description'];
		}
	}
	/**
	 * getting jm job header id based plant and po
	 */
	$qryGetJobHeaders="SELECT GROUP_CONCAT(CONCAT('''', jm_job_header_id, '''' )) AS jm_job_header_id FROM $pps.jm_job_header WHERE po_number='$sub_po' AND plant_code='$plantcode' AND is_active=1";
	$jobHeadersResult=mysqli_query($link_new, $qryGetJobHeaders) or exit("Error while getting JOb Header ids ".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($jobHeadersResult)>0){
		while($jobHeadersRow=mysqli_fetch_array($jobHeadersResult))
		{
			$jmJobheaderids=$jobHeadersRow['jm_job_header_id'];
		}
		/**getting sewing jobs based on job header ids*/
		if($jmJobheaderids!=""){
			$qryGetJobs="SELECT jm_jg_header_id,job_number FROM $pps.jm_jg_header WHERE jm_job_header IN ($jmJobheaderids) AND job_group_type='$taskType' OR job_group_type='$taskTypeSej' AND plant_code='$plantcode' AND is_active=1 ORDER BY job_number ASC";
			$jobsResult=mysqli_query($link_new, $qryGetJobs) or exit("Error while getting jm jg headers ".mysqli_error($GLOBALS["___mysqli_ston"]));
			$qryCount=mysqli_num_rows($jobsResult);
		}else{
			$qryCount=0;
		}
		
	}else{
		$qryCount=0;
	}
	
	if($qryCount>0)
	{
		
		echo "<div class='alert alert-info' style='text-align:center; font-size: 20px;'><b>Style Code : ".$style."  </b>Schedule : <b> ".$schedule."  </b> PO : <b> ".$po_description."  </b> VPO No : <b>".$vpo."</b></div>";
		
		echo "<div class='col-sm-12 table-responsive'>
		<table width='100%' class='table table-bordered info'><thead>
		<tr><th>S No</th><th>Sewing Job No</th><th>Cut Job No</th><th>No Of Bundles</th><th>Quantity</th><th>Color</th><th>Control</th></thead>";
		$url1 = getFullURLLevel($_GET['r'],'input_sheet_print.php',0,'R');
		while($jobsRow=mysqli_fetch_array($jobsResult))
		{
			$jm_jg_header_id=$jobsRow['jm_jg_header_id'];
			$job_number=$jobsRow['job_number'];
			$taskType = TaskTypeEnum::SEWINGJOB;
			//Qry to fetch taskrefrence from task_job  
			$qry_toget_taskrefrence="SELECT task_jobs_id FROM $tms.task_jobs WHERE task_type='$taskType' AND plant_code='$plantcode' AND task_job_reference='$jm_jg_header_id'";
			$toget_taskrefrence_result=mysqli_query($link_new, $qry_toget_taskrefrence) or exit("Sql Error at toget_task_job".mysqli_error($GLOBALS["___mysqli_ston"]));
			$toget_taskrefrence_num=mysqli_num_rows($toget_taskrefrence_result);
			if($toget_taskrefrence_num>0){
					while($toget_taskrefrence_row=mysqli_fetch_array($toget_taskrefrence_result))
					{  
						$task_jobs_id[]=$toget_taskrefrence_row['task_jobs_id'];
					}

					/**getting cut jobs based on task job id */
					$qry_toget_style_sch="SELECT GROUP_CONCAT(DISTINCT(IF(attribute_name='CUTJOBNO', attribute_VALUE, NULL)) SEPARATOR ',') AS CUTJOBNO FROM $tms.`task_attributes` WHERE  plant_code='AIP' AND task_jobs_id IN ('".implode("','" , $task_jobs_id)."') GROUP BY attribute_name";
					$qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) {
						if($row2['CUTJOBNO'] != NULL){
							$cutjobs = $row2['CUTJOBNO'];
						}
					}

			}

			/**
			 * getting cut jobs based on jm jg header 
			 */
			//Qry to check sewing job planned or not
			// $check_job_status="SELECT task_header_id FROM $tms.task_header WHERE task_ref='$jm_jg_header_id' AND plant_code='$plantcode' AND task_type='$taskType' AND (resource_id IS NOT NULL OR  resource_id!='')";
			// $job_status_result=mysqli_query($link_new, $check_job_status) or exit("Sql Error at check_job_status".mysqli_error($GLOBALS["___mysqli_ston"]));    
			// $job_status_num=mysqli_num_rows($job_status_result);
			// if($job_status_num>0){
			//    while($task_header_id_row=mysqli_fetch_array($job_status_result))
			// 	 {
			// 		 $task_header_id[]=$task_header_id_row['task_header_id'];
			// 	 }
				
			// }    
			 
			
			/**
			 * getting bundle count and quntity for each job
			 */
			$qryGetBundles="SELECT COUNT(bundle_number) AS bundles,SUM(quantity) AS qty,GROUP_CONCAT(DISTINCT(fg_color)) as color FROM $pps.jm_job_bundles WHERE jm_jg_header_id='$jm_jg_header_id' AND plant_code='$plantcode' AND is_active=1";
			$getBundlesResult=mysqli_query($link_new, $qryGetBundles) or exit("Error while getting bundles data ".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($getBundlesResult)>0){
				while($bundlesRow=mysqli_fetch_array($getBundlesResult))
				{
					$bundles=$bundlesRow['bundles'];
					$qty=$bundlesRow['qty'];
					$color=$bundlesRow['color'];
				}
			}
			$size = ($color)?count(explode(",",$color)):0;
			echo "<tr><td rowspan=".$size.">".$sno."</td><td rowspan=".$size.">".$job_number."</td><td rowspan=".$size.">".$cutjobs."</td>
			<td rowspan=".$size.">".$bundles."</td><td rowspan=".$size.">".$qty."</td>";
			
			$fg_color = explode(",",$color);
			foreach($fg_color as $color_fg){
				echo "<td>".$color_fg."</td>";					
					echo "<td><a class='btn btn-warning' href='$url1?color=$color_fg&input_job=$jm_jg_header_id' onclick=\"return popitup2('$url1?color=$color_fg&input_job=$jm_jg_header_id&inputJobNo=$job_number')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>Click Here to Print</td></tr>";
			}
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
  