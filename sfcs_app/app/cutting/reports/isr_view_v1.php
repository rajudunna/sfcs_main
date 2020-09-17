<?php
ini_set('max_execution_time', 0); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/menu_content.php',1,'R'));
$table_csv = getFullURLLevel($_GET['r'],'common/js/table2CSV.js',1,'R');
$excel_form_action = getFullURL($_GET['r'],'export_excel1.php','R');

$plant_code=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
?>
<!-- <script src="js/jquery-1.4.2.min.js"></script>
<script src="js/jquery-ui-1.8.1.custom.min.js"></script>
<script src="js/cal.js"></script>
<link href="js/calendar.css" rel="stylesheet" type="text/css" /> -->

<script type="text/javascript">

		function verify_date(){
		var val1 = $('#from_date').val();
		var val2 = $('#to_date').val();
	
		if(val1 > val2){
			sweetAlert('Start Date Should  be less than End Date','','warning');
			return false;
		}
		else
		{
			return true;
		}
}

	</script>


<script type="text/javascript" src="<?php echo $table_csv ?>" ></script>	

<?php 
$from_date=$_POST['from_date'];
$to_date=$_POST['to_date'];
$section=$_POST['section'];
$shift=$_POST['shift'];
$reptype=$_POST['reptype'];
?>
<div class="panel panel-primary">
	<div class="panel-heading">Input Status Report</div>
	<div class="panel-body">
		<form class="form-inline" method="post" name="input" action="<?php echo "index.php?r=".$_GET['r']; ?>">
			<div class="form-group">
				<label>From Date:</label>
				<input type="text" class="form-control" data-toggle="datepicker" id="from_date" name="from_date" value="<?php if($from_date=="") {echo  date("Y-m-d"); } else {echo $from_date;}?>">
			</div>
			<div class="form-group">
				<label for="to">To Date:</label>
				<input type="text" class="form-control" data-toggle="datepicker" id="to_date" name="to_date" onchange="return verify_date();" value="<?php if($to_date=="") {echo  date("Y-m-d"); } else {echo $to_date;}?>">
			</div>

			<div class="form-group">Shift: 
			     <select class='form-control' name = 'shift' id = 'shift' required>
					<option value="ALL">ALL</option>
					<?php 
					$shift_sql="SELECT shift_code FROM $pms.shifts where plant_code = '$plant_code' and is_active=1";
					echo $shift_sql;
					$shift_sql_res=mysqli_query($link, $shift_sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($shift_row = mysqli_fetch_array($shift_sql_res))
					{
						$shift_code=$shift_row['shift_code'];
						echo "<option value='".$shift_code."' >".$shift_code."</option>"; 
					}
					?>
				</select>   
			</div>
			<input type='hidden' id='plant_code' name='plant_code' value='<?php echo $plant_code ?>'>

			<button type="submit" id="submit" class="btn btn-primary" name="submit" onclick='return verify_date()'>Show</button>
		</form>
<?php
if(isset($_POST['submit']))
{
	
	$from_date=$_POST['from_date'];
	$to_date=$_POST['to_date'];
    $to_shift=$_POST['shift'];
    $plant_code=$_POST['plant_code'];

	echo '<span class="pull-right">
			<form action="'.$excel_form_action.'" method ="post" > 
				<input type="hidden" name="csv_text" id="csv_text">
				<input class="btn btn-info btn-sm" type="submit" value="Export to Excel" onclick="getCSVData()">
			</form></span>
		';	
    echo "<div class='col-sm-12' style='overflow-y:scroll;max-height:600px;'>";
	echo "<table class='table table-hover table-bordered'  id='report'>";
	echo "<tr class='danger'>";
	echo "<th>Date</th>";
	echo "<th>Style</th>";
	echo "<th>Schedule</th>";
	echo "<th>Color</th>";
	echo "<th>Docket</th>";
	echo "<th>Shift</th>";
	echo "<th>Cut Job</th>";
	echo "<th>Input Job</th>";
	echo "<th>Size</th>";
	echo "<th>Quantity</th>";
	echo "</tr>";
	//getting barcode_id,shift,parent_ext_ref_id
	If($to_shift == 'ALL')
	{
       $sql="SELECT barcode_id,parent_ext_ref_id,shift,date(created_at) as date FROM $pts.`transaction_log` WHERE plant_code='$plant_code' AND DATE(created_at) BETWEEN '$from_date' AND '$to_date' AND parent_type='sewing job'";
	}
	else
	{
		$sql="SELECT barcode_id,parent_ext_ref_id,shift,date(created_at) as date FROM $pts.`transaction_log` WHERE plant_code='$plant_code' AND shift='$to_shift' AND DATE(created_at) BETWEEN '$from_date' AND '$to_date' AND parent_type='sewing job' ";
	}	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$barcode_id=$sql_row['barcode_id'];
		$parent_ext_ref_id=$sql_row['parent_ext_ref_id'];
		$shift=$sql_row['shift'];
		$date=$sql_row['date'];
		//getting finished good id
		$get_finshgood_qry="SELECT finished_good_id FROM $pts.`fg_barcode` WHERE barcode_id='$barcode_id' AND plant_code='$plant_code'";
		$get_finshgood_qry_result=mysqli_query($link, $get_finshgood_qry) or exit("Sql Error finished_good_id".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($get_finshgood_qry_row=mysqli_fetch_array($get_finshgood_qry_result))
		{
			$finished_good_id=$get_finshgood_qry_row['finished_good_id'];
			//getting style,schedule,color,size
			$get_det_qry="SELECT style,schedule,color,size FROM $pts.`finished_good` WHERE finished_good_id='$finished_good_id' AND plant_code='$plant_code'";
			$get_det_qry_result=mysqli_query($link, $get_det_qry) or exit("Sql Error getting details".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($get_det_qry_row=mysqli_fetch_array($get_det_qry_result))
			{
				$style=$get_det_qry_row['style'];
				$schedule=$get_det_qry_row['schedule'];
				$color=$get_det_qry_row['color'];
				$size=$get_det_qry_row['size'];
				//getting task job id
				$get_taskjobid_qry="SELECT task_jobs_id FROM $tms.`task_jobs` WHERE task_job_reference='$parent_ext_ref_id' AND plant_code='$plant_code'";
				$get_taskjobid_qry_result=mysqli_query($link, $get_taskjobid_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($get_taskjobid_qry_result_row=mysqli_fetch_array($get_taskjobid_qry_result))
				{
					$task_jobs_id=$get_taskjobid_qry_result_row['task_jobs_id'];
				}
				//getting min operation
				$qrytoGetMinOperation="SELECT operation_code FROM $tms.`task_job_transaction` WHERE task_jobs_id='".$task_jobs_id."' AND plant_code='$plant_code' AND is_active=1 ORDER BY operation_seq ASC LIMIT 0,1";
				$minOperationResult = mysqli_query($link_new,$qrytoGetMinOperation) or exit('Problem in getting operations data for job');
				if(mysqli_num_rows($minOperationResult)>0)
				{
					while($minOperationResultRow = mysqli_fetch_array($minOperationResult))
					{
						$minOperation=$minOperationResultRow['operation_code'];
					}
				}
				
				//getting quantity 
				$get_quant_qry="select sum(good_quantity) as quantity from $tms.`task_job_transaction` WHERE task_jobs_id='".$task_jobs_id."' AND plant_code='$plant_code' AND is_active=1 and operation_code=$minOperation";
				$get_quant_qry_result = mysqli_query($link_new, $get_quant_qry) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($get_quant_qry_row = mysqli_fetch_array($get_quant_qry_result)) 
				{
					$quantity=$get_quant_qry_row['quantity'];
				}
				//getting cutjobno and inputjob no
				$job_detail_attributes = [];
				$qry_toget_style_sch = "SELECT * FROM $tms.task_attributes where task_jobs_id='".$task_jobs_id."' and plant_code='$plant_code'";
				$qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) 
				{
					$job_detail_attributes[$row2['attribute_name']] = $row2['attribute_value'];
				}
					$sewingjobno = $job_detail_attributes[$sewing_job_attributes['sewingjobno']];
					$cutjobno = $job_detail_attributes[$sewing_job_attributes['cutjobno']];
					$docket = $job_detail_attributes[$sewing_job_attributes['docketno']];
				
				echo "<tr>";
				echo "<td>".$date."</td>";
				echo "<td>".$style."</td>";
				echo "<td>".$schedule."</td>";
				echo "<td>".$color."</td>";
				echo "<td>".$docket."</td>";
				echo "<td>".$shift."</td>";
				echo "<td>".$cutjobno."</td>";
				echo "<td>".$sewingjobno."</td>";
				echo "<td>".$size."</td>";
				echo "<td>".$quantity."</td>";
				echo "</tr>";				
					
			}
		}
	}

		
	echo "</table>
	</div>";
}
?>
</div>
</div>
<script>
function getCSVData(){
 var csv_value=$('#report').table2CSV({delivery:'value'});
 $("#csv_text").val(csv_value);	
}
</script>