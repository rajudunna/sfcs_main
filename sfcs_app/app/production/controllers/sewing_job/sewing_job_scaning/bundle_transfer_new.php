<?php 
if(isset($_GET['id'])){
 echo "<script>
         $(document).ready(function(){
         $('#frm1').submit();
         });
      </script>";

	
} 
?>
<?php
include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
$url = getFullURLLEVEL($_GET['r'],'bundle_transfer_barcode_scaning_new.php',0,'N');
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
$category="sewing";
    $query_get_schedule_data= "SELECT id,operation_code,operation_name FROM $brandix_bts.tbl_orders_ops_ref 
    WHERE category='".$category."' AND display_operations='yes' ORDER BY id";
    $result = $link->query($query_get_schedule_data);
    while($row = $result->fetch_assoc()){
        $ops_array[$row['operation_code']] = $row['operation_name'];
        $ops_array1[$row['operation_code']] = $row['id'];
        
}
// var_dump($ops_array1);
$modules= "SELECT id,module_name FROM $bai_pro3.module_master where status='active'";
$result1 = $link->query($modules);
    while($row = $result1->fetch_assoc()){
    
    $ops_array2[$row['module_name']] = $row['id'];
   
}
  
?>
<div class="panel panel-primary " id="module_scanBarcode">
<div class="panel-heading">Bundle Transfer </div>
<div class="panel-body">
<form method ='POST' id='frm1' action='<?php echo $url ?>'>
<div class="row">
<div class="col-md-4">
<label for="title">Operation:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
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
</div>
<div class="col-md-4">
<label for="title">To Module:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
<select class="form-control select2" name="Module" id="Module" required>
<option value="">Select Module</option>
<?php 
		$sqly="SELECT workstation_code,workstation_description FROM $pms.workstation where plant_code = '$plant_code' and is_active=1";
		$sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowy=mysqli_fetch_array($sql_resulty))
		{
			$workstation_code=$sql_rowy['workstation_code'];
			$workstation_description=$sql_rowy['workstation_description'];
			echo "<option value='".$workstation_code."' >".$workstation_description.' - '.$workstation_code."</option>"; 
		}
		?>
</select>
</div><br>
<input type="submit" id="Start Scanning" class="btn btn-success" value="Start Scanning">
</div>
</form>
</div>
</div>
</div>