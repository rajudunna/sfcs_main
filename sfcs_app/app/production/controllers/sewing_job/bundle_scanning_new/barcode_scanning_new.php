<?php 
if(isset($_GET['id'])){
 echo "<script>
         $(document).ready(function(){
         $('#frm1').submit();
         });
      </script>";
	$gate_id= $_GET['id']; 
	$shift = $_POST['shift'];
}
?>
<?php
include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
$url = getFullURLLEVEL($_GET['r'],'scanning_barcode.php',0,'N');
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
<?php
$sql1="SELECT module_name FROM bai_pro3.module_master  ORDER BY module_name*1";
$result=mysqli_query($link, $sql1) ;
while($row=mysqli_fetch_array($result))
{
    $Modules_array[]=$row['module_name'];
}
?>
<div class="panel panel-primary " id="bundlewise_scanBarcode">
<div class="panel-heading">Bundle Barcode Scanning</div>
<div class="panel-body">
<form role="form" method ='POST' id='frm1' action='<?php echo $url ?>'>
<div class="row">
<div class="col-sm-3">
<div  class="form-group">
<input type='hidden' id='gate_id' name ='gate_id' value=<?php echo $gate_id; ?>>
<label>Module:<span style="color:red">*</span></label>
<select class="form-control Module" name="Module" id="module"  required>
<option value="">Select Module</option>
<?php 
for ($i=0; $i < sizeof($Modules_array); $i++) {?>
<option <?php echo 'value="'.$Modules_array[$i].'"'; if($_GET['Module']==$Modules_array[$i]){ echo "selected";} ?>><?php echo $Modules_array[$i] ?></option>
<?php }
?>
</select>
</div>
</div>
<div class="col-sm-3">
<div  class="form-group">
<label>Shift:<span style="color:red">*</span></label>
<select class='form-control' id='shift' name='shift' required>
<option value="">Select Shift</option>
<?php foreach($shifts_array as $shift)
      {
          echo "<option value='$shift'>$shift</option>";
      }
      
?>
</select>
</div>
</div>
<div class="col-sm-3">
<div class="form-group">
<label for="title">Select Operation:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
<select class="form-control select2" name="operation_code" id="operation" required>
<option value="">Select Operation</option> -->
<?php
foreach($ops_array1 as $key=>$value)
{
  if($_GET['opertion']==$key){
    echo "<option value='$key' selected>$ops_array[$key] - $key </option>"; 

  }else{
    echo "<option value='$key'>$ops_array[$key] - $key </option>"; 
   }
}
?>
</select>
</div>
</div>
<div class="col-sm-3">
<br/>
<input type="submit" id="continue" class="btn btn-success" value="CONTINUE">
</div>
</div>
</form>
</div>
</div>
