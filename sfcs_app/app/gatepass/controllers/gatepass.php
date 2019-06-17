<html>
<head>
<?php 
    include(getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    if(isset($_POST['submit']))
	{
		$operation_wo=$_POST['operation_wo'];
        $shift=$_POST['shift'];
        $operation=$_POST['operation'];
        $gatepass="G";

    if($operation_wo=="with"){
        
        getFullURL($_GET['r'], "/production/controllers/sewing_job/sewing_job_scaning/bundle_wise_scanning.php",3,"R");
    }else if($operation_wo=="without"){
        getFullURL($_GET['r'], "gatepass.php", "R");

    }else{
        getFullURL($_GET['r'], "gatepass.php", "R");
    }
}
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
     <b>Create Gate Pass</b>
   </div>
   	<div class="panel-body">
	    <form method="post" name="test">
        <div class="col-sm-2 form-group">
              <label for='style'>Operation Selection:<span style ='color:red'>*</span></label>  
              <select class='form-control' name="operation_wo" id="gatepass" required onchange="oper_display()">
                <option selected="selected" value='' id="selected_opr">----Select----</option>
                <option value="with">With Operation</option>
                <option value="without">WithOut Operation</option>
               </select>
               </div>
           <div class="col-sm-2 form-group">
              <label for='style'>Shift:<span style ='color:red'>*</span></label>  
              <select class='form-control' name="shift" id="per1" required>
                <option selected="selected" value=''>--Select Shift--</option>
                 <?php
                  foreach($shifts_array as $name) { ?>
                     <option value="<?php echo $name['name'] ?>"><?php echo $name['name'] ?></option>
                        <?php
                         } 
                        ?>
                </select> 
             </div>     
             <div class="col-sm-2 form-group" id="operation_sec" style="display:none">
                        <label for='operation'>Select Operation:<span style ='color:red'>*</span></label>
						<?php
							echo "<select class='form-control' name='operation' id='operation'>";
                            $sql="SELECT * FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE category ='sewing' group by operation_name";
                            $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

                            echo "<option value='' selected='selected'>--Select Operation--</option>";
                            while($sql_row=mysqli_fetch_array($sql_result))
                            {
                                if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$operation_name))
                                {
                                    echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['operation_name'].'-'.$sql_row['operation_code']."</option>";
                                }
                                else
                                {
                                    echo "<option value=\"".$sql_row['id']."\">".$sql_row['operation_name']."</option>";
                                }
                            }
                            echo "</select>";
							?>

                      
                    </div>	
                    <div class="col-sm-2 form-group" style="padding-top:20px;">
                        <?php
                          echo "<input class='btn btn-success' type=\"submit\" value=\"Submit\" name=\"submit\" id=\"submit_data\">";
                        ?>
                    </div> 
                    <br>  
                  
</body>
</html>