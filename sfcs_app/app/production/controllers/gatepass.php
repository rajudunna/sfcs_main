<html>
<head>
<?php  
    include(getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
   
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
              <label for='style'>Shift:<span style ='color:red'>*</span></label>  
              
			<select class='form-control' name="shift" id="shift" required>
                <option selected="selected" value=''>--Select Shift--</option>
                 <?php
                  foreach($shifts_array as $name) { ?>
                     <option value="<?php echo $name['name'] ?>"><?php echo $name['name'] ?></option>
                        <?php
                         } 
                        ?>
                </select> 
            </div>     
            <div class="col-sm-2 form-group" id="operation_sec" >
                        <label for='operation'>Select Operation:<span style ='color:red'>*</span></label>
						<?php
							echo "<select class='form-control' name='operation' id='operation'>";
                            $sql="SELECT * FROM $brandix_bts.`tbl_orders_ops_ref` WHERE category ='sewing' and display_operations='yes' group by operation_name";
                            $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                            echo "<option value='0' selected='selected'>--Select Operation--</option>";
                            while($sql_row=mysqli_fetch_array($sql_result))
                            {
                                if(str_replace(" ","",$sql_row['operation_code'])==str_replace(" ","",$operation_name))
                                {
                                    echo "<option value=\"".$sql_row['operation_code']."\" selected>".$sql_row['operation_name'].'-'.$sql_row['operation_code']."</option>";
                                }
                                else
                                {
                                    echo "<option value=\"".$sql_row['operation_code']."\">".$sql_row['operation_name'].'-'.$sql_row['operation_code']."</option>";
                                }
                            }
                            echo "</select>";
							?>
							</div>    
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
						$sql1="select * from $brandix_bts.gatepass_table where operation='".$operation_name."' and gatepass_status=1 and username='".$username."'";
						$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($sql_result1)>0)
						{			
							
							
							$url1 = getFullURLLEVEL($_GET['r'],'gatepass_summery_detail.php',0,'N');
							while($sql_row1=mysqli_fetch_array($sql_result1))
							{
								echo "<div class='col-sm-10'><br><div class='alert alert-info' style='font-size:13px;padding:5px'>Info! Still one gate pass is pending please close that and proceed. Click below to close.
								<a class='btn btn-warning' href='$url1&gatepassid=".$sql_row1['id']."' >Gate Pass No: ".$sql_row1['id']."</a>									
								</div>";
							}
						}
						else
						{
							if($_POST['operation']=='0')
							{
								$sql="INSERT INTO $brandix_bts.`gatepass_table` (`shift`, `gatepass_status`, `date`, `username`) VALUES ('".$shift."', '1', '".date("Y-m-d")."','".$username."')";
								$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							}
							else
							{
								$sql="INSERT INTO $brandix_bts.`gatepass_table` (`shift`, `gatepass_status`, `date`, `operation`,`username`) VALUES ('".$shift."', '1', '".date("Y-m-d")."', '".$operation."','".$username."')";
								$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							}
							$gate_id=mysqli_insert_id($link);
							$url = getFullURLLEVEL($_GET['r'],'scan_barcode_wout_keystroke.php',0,'N');
							echo "<script>window.location = '$url&gatepass=G&shift=$shift&opertion=$operation&id=$gate_id';</script>";		
						}
					}
					?>
	</div>	
</body>
</html>