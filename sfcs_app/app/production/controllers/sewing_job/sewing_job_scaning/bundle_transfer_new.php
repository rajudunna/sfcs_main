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
$plant_code=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
  
?>
<div class="panel panel-primary " id="module_scanBarcode">
<div class="panel-heading">Bundle Transfer </div>
<div class="panel-body">
<form method ='POST' id='frm1' action='<?php echo $url ?>'>
<div class="row">
<div class="col-md-4">
<label for="title">To Module:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
<select class="form-control select2" name="Module" id="Module" required onchange="changeWorkstationCode(this)">
<option value="">Select Module</option>
<?php 

        $sqly="SELECT workstation_id,workstation_code,workstation_description FROM $pms.departments d 
		LEFT JOIN $pms.workstation_type wt ON wt.department_id=d.department_id
		LEFT JOIN $pms.workstation w ON w.workstation_type_id=wt.workstation_type_id
		WHERE d.department_type='SEWING' AND w.plant_code = '$plant_code' AND w.is_active=1";
        $sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($sql_rowy=mysqli_fetch_array($sql_resulty))
        {
            $workstation_code=$sql_rowy['workstation_code'];
            $workstation_id = $sql_rowy['workstation_id'];
            $workstation_description=$sql_rowy['workstation_description'];
            echo "<option value='".$workstation_id."' >".$workstation_description.' - '.$workstation_code."</option>"; 
        }
	
        ?>
</select>
</div><br>
<input type='hidden' id='plant_code' name='plant_code' value='<?php echo $plant_code ?>'>		
<input type='hidden' id='username' name='username' value='<?php echo $username ?>'>	
<input type='hidden' name='workstation_code' value='' id='workstation_code'/>
<input type="submit" id="Start Scanning" class="btn btn-success" value="Start Scanning">
</div>
</form>
</div>
</div>
</div>

<script>
    function changeWorkstationCode(t){
        const workstation_code = $("#Module option:selected").text();
        $('#workstation_code').val(workstation_code);
    }
</script>