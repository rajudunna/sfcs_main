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
    include(getFullURLLevel($_GET['r'],'common/js/jquery-1.12.4.js',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
    $url = getFullURLLEVEL($_GET['r'],'scan_barcode_wout_keystroke_new.php',0,'N');
	$plant_code=$_SESSION['plantCode'];
	$username=$_SESSION['userName'];
?>

<div class="panel panel-primary " id="bundlewise_scanBarcode">
    <div class="panel-heading">Bundle Barcode Scanning</div>
    <div class="panel-body">
    <form method ='POST' id="frm1" action='<?php echo $url ?>'>
        <div class="row">
            <div class="col-md-4">
                <label>Shifts:<span title='Its a Mandatory Field'><font color='red'>*</font></span></label>
				<select class='form-control' name = 'shift' id = 'shift' required>
					<option value="">Select Shift</option>
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
            </div><br/>
            <input type='hidden' id='plant_code' name='plant_code' value='<?php echo $plant_code ?>'>		
			<input type='hidden' id='username' name='username' value='<?php echo $username ?>'>	
            <input type="submit" id="continue" class="btn btn-success" value="CONTINUE">
        </div>
    </form>
    </div>
</div>
