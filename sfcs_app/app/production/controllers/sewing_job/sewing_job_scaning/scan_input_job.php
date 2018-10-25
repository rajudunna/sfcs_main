<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
    $url = getFullURLLEVEL($_GET['r'],'inputjob_reversal_scan.php',0,'N');
?>
<div class="panel panel-primary " id="inputjob_scanning">
    <div class="panel-heading">Input Job Scanning</div>
    <div class="panel-body">
    <form method ='POST' action='<?php echo $url ?>'>
        <div class="row">
            <div class="col-md-4">
                <label>Shift:<span style="color:red">*</span></label>
                <select class="form-control shift"  name="shift" id="shift" style="width:50%;" required>
                    <option value="">Select Shift</option>
                    <?php 
                        for ($i=0; $i < sizeof($shifts_array); $i++) {?>
                            <option  <?php echo 'value="'.$shifts_array[$i].'"'; if($_GET['shift']==$shifts_array[$i]){ echo "selected";}   ?>><?php echo $shifts_array[$i] ?></option>
                        <?php }
                    ?>
                </select>
            </div>
                    <input type="submit" id="continue" class="btn btn-primary" value="CONTINUE">
        </div>
    </form>
    </div>
</div>