<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
    $url = getFullURL($_GET['r'],'inputjob_reversal_scan.php','N');
    $plant_code = $plant_code;
?>
<div class="panel panel-primary " id="inputjob_scanning">
    <div class="panel-heading">Input Job Scanning</div>
    <div class="panel-body">
   
        <div class="row">
            <div class="col-md-2">
                <label>Shift:<span style="color:red">*</span></label>
                <select class='form-control' name = 'shift' id='shift' required>
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
            <div class='col-sm-1'>
                <label><br/></label>
                <input type='button' onclick='verify_shift()' id="continue" class="btn btn-success" value="Continue">
            </div>
        </div>
   
    </div>
</div>

<script>
    function verify_shift(){
        var shift = $('#shift').val();
        if( shift == ''){
            swal('Please Select Shift','','error');
            return false;
        }else{
            window.location = '<?= $url  ?>&shift='+shift;
        }
    }
</script>