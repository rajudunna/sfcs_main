<?php 
include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
include(getFullURLLevel($_GET['r'],'common/config/enums.php',5,'R'));

$url = getFullURL($_GET['r'],'scan_job.php','N');

$plant_code = $_SESSION['plantCode'];
$username=$_SESSION['userName'];
$configuration_bundle_print_array = [0=>'Bundle Level',1=>'Job Level'];
// the job_type is OperationCategory enum 
$job_type = $_GET['job_type'];
if($job_type == OperationCategory::EMBELLISHMENT){
    $lable = 'Embellishment';
} else {
    $lable = 'Sewing';
}
$configuration_bundle_print_array = [0=> $lable.' Bundle Level',1=> $lable.' Job Level'];

if ($job_type !== OperationCategory::SEWING && $job_type !== OperationCategory::EMBELLISHMENT) {
    echo "<div style='color: red' class='col-sm-12'>Only Sewing or Embellishement job types are allowed </div>";
    exit();
}

?>
<form method ='POST' action='<?= $url ?>&manual_reporting=1'>
	<div class="panel panel-primary">
		<div class="panel-heading"><strong><?= $lable; ?> Job Scanning</strong></div>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-2">
					<label>Select Operation:<span title='Its a Mandatory Field'><font color='red'>*</font></span></label>
                    <select class='form-control' name = 'operation_id'  id = 'operation_id' required>
                        <option value="">Select Operation</option>
                        <?php 
                        $sqly="SELECT operation_code,operation_name FROM $pms.operation_mapping where plant_code = '$plant_code' and is_active=1 and operation_category='$job_type'";
                        $sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($sql_rowy=mysqli_fetch_array($sql_resulty))
                        {
                            $operation_code=$sql_rowy['operation_code'];
                            $operation_name=$sql_rowy['operation_name'];
                            echo "<option value='".$operation_code."' >".$operation_name.' - '.$operation_code."</option>"; 
                        }
                        ?>
                    </select>
				</div>
                <div class="col-md-2">
                    <label>Shift:<span title='Its a Mandatory Field'><font color='red'>*</font></span></label>
                        <select class='form-control' name = 'shift' required>
                            <option value="">Select Shift</option>
                            <?php 
                            $shift_sql="SELECT shift_code FROM $pms.shifts where plant_code = '$plant_code' and is_active=1";
                            $shift_sql_res=mysqli_query($link, $shift_sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($shift_row = mysqli_fetch_array($shift_sql_res))
                            {
                                $shift_code=$shift_row['shift_code'];
                                echo "<option value='".$shift_code."' >".$shift_code."</option>"; 
                            }
                            ?>
                        </select>
                </div>
                <div class="col-md-3">
                    <label>Barcode Generation:<span title='Its a Mandatory Field'><font color='red'>*</font></span></label>
                        <select class='form-control' name = 'scan_mode' required>
                            <option value="">Select Method</option>
                            <?php 
                            foreach($configuration_bundle_print_array as $key => $method){
                                echo "<option value=$key>".$method."</option>"; 
                            }
                            ?>
                        </select>
                </div>
				<input type='hidden' id='plant_code' name='plant_code' value='<?php echo $plant_code ?>'>		
				<input type='hidden' id='username' name='username' value='<?php echo $username ?>'>		
                <input type='hidden' id='job_type' name='job_type' value='<?php echo $job_type ?>'>		
                <div class="col-md-1">
                    <br>
                    <input type='submit' value='Continue' name='SUBMIT' class='btn btn-primary' style="margin-top: 4px;">
                </div>
			</div>
		</div>
	</div>
</form>

<script>
$('#operation').change(function()
	{
		var operation_text = $('#operation option:selected').text();
		$('#operation_name').val(operation_text);
		$('#operation_id').val($('#operation').val());
	});
</script>
