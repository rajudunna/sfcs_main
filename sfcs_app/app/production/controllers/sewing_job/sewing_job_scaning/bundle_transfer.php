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
$url = getFullURLLEVEL($_GET['r'],'bundle_transfer_barcode_scaning.php',0,'N');
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
<select class="form-control select2" name="operation_code" id="operation" required>
<option value="">Select Operation</option>
<?php
foreach($ops_array1 as $key=>$value)
{
  if($_GET['opertion']==$key){
    echo "<option value='$ops_array[$key] - $key' selected>$ops_array[$key] - $key </option>"; 

  }else{
    echo "<option value='$ops_array[$key] - $key'>$ops_array[$key] - $key </option>"; 
   }
}
?>
</select>
</div>
<div class="col-md-4">
<label for="title">To Module:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
<select class="form-control select2" name="Module" id="Module" required>
<option value="">Select Module</option>
<?php
foreach($ops_array2 as $key=>$value)
{
  if($_GET['module_name']==$key){
    echo "<option value='$key' selected>$ops_array[$key]  $key </option>"; 

  }else{
    echo "<option value='$key'>$ops_array[$key]  $key </option>"; 
   }
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