<?php
    include(getFullURLLevel($_GET['r'],'common/js/jquery-1.12.4.js',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/config_ajax.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
	// $url = getFullURLLEVEL($_GET['r'],'emb_reprint.php',0,'N');
	$plant_code = $_SESSION['plantCode'];
	// $plant_code = 'Q01';
	$username = $_SESSION['userName'];
	// var_dump($shifts_array);
?>

<div class="panel panel-primary " id="bundlewise_scanBarcode">
    <div class="panel-heading">Emblishment Barcode Reprint</div>
    <div class="panel-body">
    <form method ='POST' id="frm1" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>">
        <div class="row">
			<div class="col-md-3">
				<label>Barcode Number:</label>
				<input type="text"  id="barcode" name="barcode" class="form-control" required />
			</div>
            <div class="col-md-3">
                <label>Shift:<span style="color:red">*</span></label>
                <select class="form-control shift"  name="shift" id="shift" style="width:100%;" required>
                    <option value='' disabled selected>Select Shift</option>
                <?php
                $shift_sql="SELECT shift_code FROM $pms.shifts where plant_code = '$plant_code' and is_active=1";
                $shift_sql_res=mysqli_query($link, $shift_sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($shift_row = mysqli_fetch_array($shift_sql_res))
                {
                    $shift_code=$shift_row['shift_code'];
                    echo "<option value='".$shift_code."' >".$shift_code."</option>"; 
                }
                ?>

                ?>
                </select>
            </div>
			<div class="col-md-3">
				<label>Employee Id:</label>
				<input type="textbox" class="form-control" name="emp_no" id="emp_no" required />
			</div>
			<div class="col-md-3">
				Remarks:<textarea rows="2" cols="30" name="remarks" id="remarks" class="form-control" required></textarea>
			</div>
			
            <div class="col-md-3" style="margin-top: 18px;">
				<input type="submit" name="continue" id="continue" class="btn btn-success" value="Reprint">
			</div>
        </div>
<div class='col-md-1 col-sm-1' style='margin-left:79%;margin-top:-4%;'>
   <?php
   $url = getFullURLLevel($_GET['r'],'emb_reprint_report.php',0,'R');
   echo "<td><a class='btn btn-primary' href='$url' onclick=\"return popitup2('$url')\" target='_blank'><i aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Re-Printed Tags History</a></td>";
   ?>
</div>
    </form>


<?php
if(isset($_POST['continue']))
{
	$barcode=$_POST['barcode'];
	$shift=$_POST['shift'];
	$employeeid=$_POST['emp_no'];
	$remarks=$_POST['remarks'];
	$val=explode("-",$barcode);
	//validating bundlebarcode existing or not
	$sql_validating_barcode="select * from $pps.emb_bundles where plant_code='$plant_code' and barcode='$barcode' ";
	$sql_result=mysqli_query($link, $sql_validating_barcode) or exit($sql_validating_barcode."<br/> Error in section table ");
	$no_rows=mysqli_num_rows($sql_result);
	if($no_rows>0)
	{
		$sql="insert into $pps.emb_reprint_track(barcode,shift,emp_id,remarks,username,plant_code,created_user,updated_user) values('".$barcode."','".$shift."','".$employeeid."','".$remarks."','".$username."','".$plant_code."','".$username."','".$username."')";
		$sql_result=mysqli_query($link, $sql) or exit($sql."<br/> Error while insert into emb_reprint_track");
		echo "<table class='table table-bordered'><tr><th rospan=4>You are going to take bundle print</th>";
		$url1 = getFullURLLevel($_GET['r'],'barcode_new.php',0,'R');
		echo "<td><a class='btn btn-info btn-sm' href='$url1?doc_no=".$val[0]."&id=".$val[2]."' onclick=\"return popitup2('$url1?doc_no=".$val[0]."&id=".$val[2]."')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Emb Barcode</a></td>";
		$url2 = getFullURLLevel($_GET['r'],'barcode2_1.php',0,'R');
		echo "<td><a class='btn btn-info btn-sm' href='$url2?doc_no=".$val[0]."&id=".$val[2]."' onclick=\"return popitup2('$url2?doc_no=".$val[0]."&id=".$val[2]."')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Emb Barcode 2*1</a></td>";
		echo "</tr>";
		echo "</table>";
	}
	else
	{
		echo "<script>swal('Bundle Does not exists','','warning');</script>";
	}	
}
?>

    </div>
</div>