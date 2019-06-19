<?php 
if(isset($_GET['gatepass'])){
echo "<button type='button' class='btn btn-primary'><a style='color:white;' href='http://localhost/?r=L3NmY3NfYXBwL2FwcC9nYXRlcGFzcy9jb250cm9sbGVycy9nYXRlcGFzcy5waHA='>Go Back</a></button>";
$pass=$_GET['gatepass'];
$shift=$_GET['shift'];
$operation=$_GET['opertion'];

}
?>
<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
    $url = getFullURLLEVEL($_GET['r'],'scan_barcode_wout_keystroke.php',0,'N');
    $category="'sewing'";
	$query_get_schedule_data= "SELECT tm.operation_code,tm.id,tm.operation_name FROM $brandix_bts.tbl_orders_ops_ref tm
	WHERE tm.operation_code NOT IN (10,200,15) 
	AND category IN ($category)  AND display_operations='yes'
    GROUP BY tm.operation_code ORDER BY tm.operation_code";
	$result = $link->query($query_get_schedule_data);
	while($row = $result->fetch_assoc()){
        $ops_array[$row['operation_code']] = $row['operation_name'];
        $ops_array1[$row['operation_code']] = $row['id'];
    }
    
    
?>
<div class="panel panel-primary " id="bundlewise_scanBarcode">
    <div class="panel-heading">Bundle Barcode Scanning Without Operation</div>
    <div class="panel-body">
    <form method ='POST' action='<?php echo $url ?>'>
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
            </div>
            <div class="col-md-4">
                <label for="title">Select Operation:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
                <select class="form-control select2"  name="operation_code" id="operation" required>
                    <option value="">Select Operation</option>
                    <?php
                   
                        foreach($ops_array1 as $key=>$value)
                        {
                          if($_GET['opertion']==$value){
                            echo "<option value='$key' selected>$ops_array[$key] - $key </option>"; 
                            
                          }else{
                            echo "<option value='$key'>$ops_array[$key] - $key </option>"; 
                           }
                        }
                    
                    ?>
                </select>
            </div><br/>
            
            <input type="submit" id="continue" class="btn btn-success" value="CONTINUE">
        </div>
    </form>
    </div>
</div>