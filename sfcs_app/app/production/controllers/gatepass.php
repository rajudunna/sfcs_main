<html>
<head>
<?php  
    include(getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
	$plant_code = $_SESSION['plantCode'];
	$username = $_SESSION['userName'];
	//$username='sfcsprwojessct1';
	
    ?>
<script>
    console.log(<?php echo json_encode($_POST); ?>);
</script>
<script>
function oper_display(){
  
    var oper_sel=document.getElementById("gatepass").value;
    // alert(oper_sel);
    if(oper_sel=="without"){
      document.getElementById("operation_sec").style.display = "block";
    }else{
        document.getElementById("operation_sec").style.display = "none";
    }
  
}

</script>

</head>
<body>
<div class='panel panel-primary'>
  <div class="panel-heading">
     <b>Gate Pass Interface</b>
   </div>
   	<div class="panel-body">
	    <form method="post" name="test">
		    <div class="col-sm-2 form-group">
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
            <div class="col-sm-2 form-group" id="operation_sec" >
                    <label>Select Operation:<span title='Its a Mandatory Field'><font color='red'>*</font></span></label>
                    <select class='form-control' name = 'operation'  id = 'operation' required>
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
					<input type="hidden" name="plant_code" id="plant_code" value="<?php echo $plant_code; ?>">
					<input type="hidden" name="username" id="username" value="<?php echo $username; ?>">			
                            <div class="col-sm-2 form-group" style="padding-top:20px;">
                        <?php
                          echo "<input class='btn btn-success' type=\"submit\" value=\"Start\" name=\"submit\" id=\"submit_data\">";
                        ?>
                    </div> 
					
					<?php
                    
					if(isset($_POST['submit']))
					{        
						$shift=$_POST['shift'];
						$operation=$_POST['operation'];
						$operation_name=$_POST['operation'];
						$plant_code=$_POST['plant_code'];
						$username=$_POST['username'];
						$sql1="select * from $pps.gatepass_table where operation='".$operation_name."' and gatepass_status=1 and username='".$username."' and plant_code='".$plant_code."'";
						$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($sql_result1)>0)
						{			
							
							
							$url1 = getFullURLLEVEL($_GET['r'],'gatepass_summery_detail.php',0,'N');
							while($sql_row1=mysqli_fetch_array($sql_result1))
							{
								echo "<div class='col-sm-10'><br><div class='alert alert-info' style='font-size:13px;padding:5px'>Info! Still one gate pass is pending please close that and proceed. Click below to close.
								<a class='btn btn-warning' href='$url1&gatepassid=".$sql_row1['id']."&plant_code=".$plant_code."&username=".$username."' >Gate Pass No: ".$sql_row1['id']."</a>									
								</div>";
							}
						}
						else
						{
							if($_POST['operation']=='0')
							{
								$sql="INSERT INTO $pps.`gatepass_table` (`shift`, `gatepass_status`, `date`, `username`,`plant_code`,`created_user`,`updated_user`) VALUES ('".$shift."', '1', '".date("Y-m-d")."','".$username."','".$plant_code."','".$username."','".$username."')";
								$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							}
							else
							{
								$sql="INSERT INTO $pps.`gatepass_table` (`shift`, `gatepass_status`, `date`, `operation`,`username`,`plant_code`,`created_user`,`updated_user`) VALUES ('".$shift."', '1', '".date("Y-m-d")."', '".$operation."','".$username."','".$plant_code."','".$username."','".$username."')";
								$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							}
							$gate_id=mysqli_insert_id($link);
							$url = getFullURLLEVEL($_GET['r'],'sewing_job/sewing_job_scaning/pre_bundle_level_scanning_without_ops_new.php',0,'N');
							echo "<script>window.location = '$url&shift=$shift&opertion=$operation&id=$gate_id&plant_code=$plant_code&username=$username';</script>";		
						}
					}
					?>
	</div>	
</body>
</html>