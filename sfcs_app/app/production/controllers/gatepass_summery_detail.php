<?php 

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
if(isset($_GET['gatepassid']) && isset($_GET['vehicle_no']) ){
    $test=1;
    $gatepassid=$_GET['gatepassid'];
    $vehicle_no=$_GET['vehicle_no'];

}else {
    $test=2;
    $gatepassid=$_GET['gatepassid'];
}

// $gatepassid=$_GET['gatepassid'];

// $sql="select * from $brandix_bts.gatepass_table where id='$gatepassid' ";
// $sql_res = mysqli_query($link,$sql) or exit('error in gate pass');
// while($res1 = mysqli_fetch_array($sql_res)){
//     $vehicle_number = $res1['vehicle_no'];
// }
?>
<div class="panel panel-primary">
    <div class="panel-heading">Gate Pass
    </div>
    <div class="panel-body">
    <?php
        if($test==2){
            ?>
            <form method="post" name="input" action="<?php echo '?r='.$_GET['r']; ?>">
                <div class="row">
                    <div class="col-md-2">
                        <label>Enter Vehice Number: </label>
                        <input type="text"  id="vehicle_no"  name="vehicle_no" class="form-control"  value="<?php  if(isset($_POST['vehicle_no'])) { echo $_POST['vehicle_no']; } else { echo ""; } ?>" />
                            <input type="hidden"  id="gatepassno"  name="gatepassno" class="form-control"  value="<?=$gatepassid; ?>" />
                    </div>
                    <div class="col-md-2">
                        <input type="submit" value="Generate Gate Pass" name="submit" class="btn btn-success"  style="margin-top:22px;">
                    </div>
                </div>
            </form>
          <?php
        }else{
            $sql="select style,schedule,color, from $brandix_bts.gatepass_track where gate_id='$gatepassid'";
            $sql_res = mysqli_query($link,$sql) or exit('error in gate pass');
            echo "<div class='table-responsive'>
					<table class='table table-bordered'>";
  			echo "<tr class='warning'>
					  <th class='tblheading'>Date</th><th  class='tblheading'>Shift</th>
					  <th class='tblheading' >Table</th><th class='tblheading'>Docket No</th>
					  <th class='tblheading'>Style</th><th class='tblheading'>Schedule</th>
					  <th class='tblheading'>Color</th><th class='tblheading'>Category</th>
                      <th class='tblheading'>Cut No</th><th class='tblheading'>Cut Plies</th><th>Size</th><th>Qty</th></tr>";
            while($res1 = mysqli_fetch_array($sql_res)){
                $vehicle_number = $res1['vehicle_no'];
                $doc_no=$res1['doc_no'];
				$date=$res1['date'];
				$act_shift=$res1['shift'];
				$act_section=$res1['section'];
				$cut_remarks=$res1["remarks"];
            }
        }
        ?>
    </div>
</div>
<?php
if(isset($_POST['submit'])){
    $vehicle_number=$_POST['vehicle_no'];
    $gatepassno=$_POST['gatepassno'];

    $sql33="update $brandix_bts.gatepass_table set vehicle_no='$vehicle_number' where id=\"$gatepassno\"";
    echo $sql33."<br/>";
    mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    
}

?>
