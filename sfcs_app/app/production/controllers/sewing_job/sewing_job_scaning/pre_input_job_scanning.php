<?php 
include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
$url = getFullURL($_GET['r'],'scan_input_jobs.php','N');

$plant_code = $_SESSION['plantCode'];
$username=$_SESSION['userName'];
$configuration_bundle_print_array = ['0'=>'Bundle Level','1'=>'Sewing Job Level'];
?>
<form method ='POST' action='<?php echo $url."$status" ?>'>
	<div class="panel panel-primary">
		<div class="panel-heading"><strong>Input Job Scanning</strong></div>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-2">
					<label>Select Operation:<span title='Its a Mandatory Field'><font color='red'>*</font></span></label>
                    <select class='form-control' name = 'operation'  id = 'operation' required>
                        <option value="">Select Operation</option>
                        <?php 
                        $sqly="SELECT operation_code,operation_name FROM $pms.operation_mapping where plant_code = '$plant_code' and is_active=1 and operation_category='sewing'";
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
                    <label>Shifts:<span title='Its a Mandatory Field'><font color='red'>*</font></span></label>
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
                        <select class='form-control' name = 'barcode_generation' required>
                            <option value="">Select Method</option>
                            <?php 
                            foreach($configuration_bundle_print_array as $key => $method){
                                echo "<option value='".$key."' >".$method."</option>"; 
                            }
                            ?>
                        </select>
                </div>
                <input type='hidden' id='input_job_no_random_ref' name='input_job_no_random_ref1' value='<?php echo $input_job_no_random_ref  ?>'>
				<input type='hidden' id='operation_id1' name='operation_id1' value='<?php echo $operation_code ?>'>
				<input type='hidden' id='style1' name='style1' value='<?php echo $style ?>'>
				<input type='hidden' id='schedule1' name='schedule1' value='<?php echo $schedule ?>'>
				<input type='hidden' id='module1' name='module1' value='<?php echo $module ?>'>
                <input type='hidden' id='operation_name' name='operation_name' required>
				<input type='hidden' id='operation_id' name='operation_id' required>		
				<input type='hidden' id='plant_code' name='plant_code' value='<?php echo $plant_code ?>'>		
				<input type='hidden' id='username' name='username' value='<?php echo $username ?>'>		
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