<?php 
if(isset($_GET['gatepass'])){
    echo "<script>
    $(document).ready(function(){
         $('#frm1').submit();
    });
    </script>";
}
?>
<?php
    include(getFullURLLevel($_GET['r'],'common/js/jquery-1.12.4.js',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
    $url = getFullURLLEVEL($_GET['r'],'scan_barcode_wout_keystroke.php',0,'N');
?>

<div class="panel panel-primary " id="bundlewise_scanBarcode">
    <div class="panel-heading">Bundle Barcode Scanning</div>
    <div class="panel-body">
    <form method ='POST' id="frm1" action='<?php echo $url ?>'>
        <div class="row">
            <div class="col-md-4">
                <label>Shift:<span style="color:red">*</span></label>
                <select class="form-control shift"  name="shift" id="shift" style="width:100%;" required>
                    <option value="">Select Shift</option>
                    <?php 
                        for ($i=0; $i < sizeof($shifts_array); $i++) {?>
                            <option  <?php echo 'value="'.$shifts_array[$i].'"'; if($_GET['shift']==$shifts_array[$i]){ echo "selected";}   ?>><?php echo $shifts_array[$i] ?></option>
                        <?php }
                    ?>
                </select>
            </div><br/>
            
            <input type="submit" id="continue" class="btn btn-success" value="CONTINUE">
        </div>
    </form>
    </div>
</div>
