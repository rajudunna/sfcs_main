<?php
    include(getFullURLLevel($_GET['r'],'common/js/jquery-1.12.4.js',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/config_ajax.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
    // $url = getFullURLLEVEL($_GET['r'],'emb_reprint.php',0,'N');
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
                    <option value="">Select Shift</option>
                    <?php 
                        for ($i=0; $i < sizeof($shifts_array); $i++) {?>
                            <option  <?php echo 'value="'.$shifts_array[$i].'"'; if($_GET['shift']==$shifts_array[$i]){ echo "selected";}   ?>><?php echo $shifts_array[$i] ?></option>
                        <?php }
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
	$sql_validating_barcode="select * from $bai_pro3.emb_bundles where barcode='$barcode'";
	$sql_result=mysqli_query($link, $sql_validating_barcode) or exit($sql_validating_barcode."<br/> Error in section table ");
	$no_rows=mysqli_num_rows($sql_result);
	if($no_rows>0)
	{
		$sql="insert into $bai_pro3.emb_reprint_track(barcode,shift,emp_id,remarks,username) values('".$barcode."','".$shift."','".$employeeid."','".$remarks."','".$username."')";
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