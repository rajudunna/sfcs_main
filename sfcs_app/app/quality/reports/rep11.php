<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',3,'R'));

$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];

 ?>


<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R'); ?>" ></script>

<script>
function verify_date(e){
	var from = document.getElementById('demo1').value;
	var to =   document.getElementById('demo2').value;
	if(from > to){
		sweetAlert('From date should not be greater than To Date','','warning');
		e.preventDefault();
		return false;
	}
	return true;
}
</script>


<div class="panel panel-primary">
	<div class="panel-heading">Sample Room Transaction Log
	</div>
	<div class="panel-body">
		<form name="input" method="post" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>">
		<div class='col-sm-3'>
			<label>Start Date</label> 
			<input id="demo1" type="text" class='form-control' data-toggle='datepicker' name="sdate" size="8" value="<?php if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>"> 
		</div>
		<div class='col-sm-3'>
			<label>End Date</label>
			<input class='form-control' id="demo2" type="text" data-toggle='datepicker' size="8" name="edate" value="<?php if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>">
		</div>
		<div class='col-sm-3'>
			<label></label><br/>
			<input type="submit" name="filter" value="Filter" class="btn btn-success" onclick='return verify_date(event)'>
		</div>
		</form><br>

<?php

if(isset($_POST['filter']))
{
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];	
	
	$job_type=TaskTypeEnum::PLANNEDSEWINGJOB;
	//get jobs for selected dates
    $get_jobsfor_selectedates="SELECT parent_job FROM $pts.transaction_log WHERE plant_code='$plantcode' AND parent_job_type='$job_type' AND  date(created_at) between '$sdate' AND '$edate' AND is_active=1";
    $sql_result=mysqli_query($link, $get_jobsfor_selectedates) or exit("Sql Error get_jobsfor_selectedates".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($sql_result))
	{
		$sewing_jobs[]=$row['parent_job'];
	}

	//To check wheter job is sample or not
	$check_jobs="SELECT job_number FROM $pps.`jm_jg_header` LEFT JOIN $pps.`jm_job_header` ON jm_job_header.`jm_job_header_id` = jm_jg_header.`jm_job_header` WHERE job_group_type='$job_type' AND job_header_type='Sample' AND job_number IN ('".implode("','" , $sewing_jobs)."') AND jm_job_header.`plant_code`='$plantcode' AND jm_job_header.is_active=1";
    $sql_result1=mysqli_query($link, $check_jobs) or exit("Sql Error check_jobs".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($sql_result1))
	{
		$sample_jobs[]=$row1['job_number'];
	}

	//Get sample jobs rejection details
	$get_rejection_details="SELECT style,schedule,color,size,sum(rejected_quantity) as quantity,resource_id,shift,date(created_at) as log_date FROM $pts.transaction_log WHERE plant_code='$plantcode' AND parent_job IN ('".implode("','" , $sample_jobs)."') AND date(created_at) between '$sdate' AND '$edate' AND is_active=1 group by style,schedule,color,size,resource_id";
    $sql_result2=mysqli_query($link, $get_rejection_details) or exit("Sql Error get_rejection_details".mysqli_error($GLOBALS["___mysqli_ston"]));
    if(mysqli_num_rows($sql_result2) > 0) {
		echo '<div class="row">
		<div class="col-sm-2">
			<form action='.getFullURL($_GET['r'],'export_excel.php','R').' method ="post" > 
			<input type="hidden" name="csv_text" id="csv_text">
			<input type="submit" value="Export to Excel" class="btn btn-warning" onclick="getTableData()">
			</form>
		</div>
	 </div><br/>';

	echo '<div class="row" style="overflow-x:scroll;overflow-y:scroll;max-height:600px;">';
	echo "<table id='example1' class=\"table table-bordered\">";
	echo "<tr class='danger'>
			<th>Date</th>
			<th>Module</th>
			<th>Section</th>
			<th>Shift</th>
			<th>Style</th>
			<th>Schedule</th>
			<th>Color</th>
			<th>Size</th>
			<th>Qty</th>
			<th>Ex Factory Date</th>
		</tr>";
		while($row2=mysqli_fetch_array($sql_result2))
		{
			//To get workstation description
			$query = "select workstation_description,workstation_code,section_id from $pms.workstation where plant_code='$plantcode' and workstation_id = '".$row2['resource_id']."' AND is_active=1";
			$query_result=mysqli_query($link_new, $query) or exit("Sql Error at workstation_description".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($des_row=mysqli_fetch_array($query_result))
			{
				$workstation_description = $des_row['workstation_description'];
				$workstation_code = $des_row['workstation_code'];
				$section_id = $des_row['section_id'];
			}
			//To get section
			$get_sections="SELECT section_name FROM $pms.sections WHERE section_id='$section_id' AND plant_code='$plantcode' AND is_active=1";
			$sections_result=mysqli_query($link_new, $get_sections) or exit("Sql Error at get_sections".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sec_row=mysqli_fetch_array($sections_result))
			{
			  $section_name=$sec_row['section_name'];
			}
            echo "<tr>";
			echo "<td>".$row2['log_date']."</td>";
			echo "<td>".$workstation_description."</td>";
			echo "<td>".$section_name."</td>";
			echo "<td>".$row2['shift']."</td>";
			echo "<td>".$row2['style']."</td>";
			echo "<td>".$row2['schedule']."</td>";
			echo "<td class=\"lef\">".$row2['color']."</td>";
			echo "<td>".strtoupper($row2['size'])."</td>";
			echo "<td>".$row2['quantity']."</td>";
			//getexfactory date
			$schedule=$row2['schedule'];
			$get_exfactorydate="SELECT planned_delivery_date FROM $oms.oms_mo_details where plant_code='$plantcode' AND schedule='$schedule' AND is_active=1";
			$sql_result3=mysqli_query($link, $get_exfactorydate) or exit("Sql Error get_exfactorydate".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row3=mysqli_fetch_array($sql_result3)){
				$planned_date=$row3['planned_delivery_date'];
			}
			echo "<td>".$planned_date."</td>";
		}
		echo "</table>
			</div>";
	} else
	{
		echo "<script>sweetAlert('Oops!','No Data Found','error')</script>";
	}
}
?>

<script language="javascript">
function getTableData(){
	var csv_value=$('#example1').table2CSV({delivery:'value'}); 
	$("#csv_text").val(csv_value);
}
</script>

</div>
</div>
</div>
</div>