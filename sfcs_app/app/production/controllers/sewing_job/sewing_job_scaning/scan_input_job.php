<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
    $url = getFullURL($_GET['r'],'inputjob_reversal_scan.php','N');
?>
<div class="panel panel-primary " id="inputjob_scanning">
    <div class="panel-heading">Input Job Scanning</div>
    <div class="panel-body">
   
        <div class="row">
            <div class="col-md-2">
                <label>Shift:<span style="color:red">*</span></label>
                <select class="form-control shift"  name="shift" id="shift" required>
                    <option value="">Select Shift</option>
                    <?php 
                        for ($i=0; $i < sizeof($shifts_array); $i++) {?>
                            <option  <?php echo 'value="'.$shifts_array[$i].'"'; if($_GET['shift']==$shifts_array[$i]){ echo "selected";}   ?>><?php echo $shifts_array[$i] ?></option>
                        <?php }
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