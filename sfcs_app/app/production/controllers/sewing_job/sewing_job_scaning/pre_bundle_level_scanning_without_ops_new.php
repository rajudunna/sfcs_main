<?php 
if(isset($_GET['id'])){
 echo "<script>
         $(document).ready(function(){
         $('#frm1').submit();
         });
      </script>";
	$gate_id= $_GET['id']; 
	
}
?>
<?php
include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
$url = getFullURLLEVEL($_GET['r'],'scan_barcode_wout_keystroke_new.php',0,'N');
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
$category="'sewing'";
    $query_get_schedule_data= "SELECT tm.operation_code,tm.id,tm.operation_name FROM $brandix_bts.tbl_orders_ops_ref tm
    WHERE category IN ($category) AND display_operations='yes'
GROUP BY tm.operation_code ORDER BY tm.operation_code";
    $result = $link->query($query_get_schedule_data);
    while($row = $result->fetch_assoc()){
        $ops_array[$row['operation_code']] = $row['operation_name'];
        $ops_array1[$row['operation_code']] = $row['id'];
}
// var_dump($ops_array1);

?>
<div class="panel panel-primary " id="bundlewise_scanBarcode">
<div class="panel-heading">Bundle Barcode Scanning Without Operation</div>
<div class="panel-body">
<form method ='POST' id='frm1' action='<?php echo $url ?>'>
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
</div>
<div class="col-md-4">
<label>Select Operation:<span title='Its a Mandatory Field'><font color='red'>*</font></span></label>
	<select class='form-control' name = 'operation_code'  id = 'operation' required>
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
</div><br>
<input type="submit" id="continue" class="btn btn-success" value="CONTINUE">
</div>
</form>
</div>
</div>
