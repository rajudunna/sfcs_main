<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.min.js',4,'R')?>"></script>
	<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/datetimepicker_css.js',4,'R')?>"></script>
	<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/style.css',4,'R')?>">
	<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/table.css',4,'R')?>">

	<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',4,'R')?>"></script><!-- External script -->
	<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',4,'R')?>"></script>
	<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/filtergrid.css',4,'R')?>"></script>

	<script language="javascript" type="text/javascript">
		function check_val(){
			var bundle=document.getElementById('bundle').value;
			var emp_no=document.getElementById('emp_no').value;
			var remark=document.getElementById('remark').value;
			
			if(bundle=='' || emp_no=='' || remark=='0')
			{
				alert('Please select the values');
				return false;
			}
		}
	</script>
	<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<?php
		include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));  
		include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
		include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',4,'R'));
		include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',4,'R')); 
		$plant_code = $_SESSION['plantCode'];
		$username = $_SESSION['userName'];
		if(isset($_POST['show']))
		{
			$barcode_types = [BarcodeType::PPLB, BarcodeType::PSLB];
			$barcode = $_POST['bundle'];
			$emp_no = $_POST['emp_no'];
			$module = $_POST['module'];
			$shift = $_POST['shift'];
			$remark = $_POST['remark'];
		}
	?>
	<div class="panel panel-primary">	
		<div class="panel-heading">Bundle Re-print form</div>
		<div class="panel-body">
		<?php 
		
		// Report simple running errors
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		?>

		<form name="mini_order_report" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post" onsubmit=" return check_val();">
			<br>
			<div class='col-md-3 col-sm-3 col-xs-12'>
				Bundle Number&nbsp;&nbsp;
				<input type="text" size="8" name="bundle" class="form-control" id="bundle" value="<?php echo $_POST['bundle']?>"/required>
				</div>
				<div class='col-md-3 col-sm-3 col-xs-12'>
				Shift 
				<select name="shift" class="select2_single form-control" placeholder="Please Select">
				<?php
					$shiftsQuery = "SELECT shift_id,shift_code,shift_description from $pms.shifts where plant_code='$plant_code' and is_active=1";
					$shiftQueryResult = mysqli_query($link,$shiftsQuery) or exit('Problem in getting shifts');
					var_dump($shiftQueryResult);
					if(mysqli_num_rows($shiftQueryResult)>0){
						while($row = mysqli_fetch_array($shiftQueryResult)){
							$shift_code =  $row['shift_code'];
							$shift_id = $row['shift_id'];
							if ($hift_id == $shift) {
								echo "<option value='$shift_code' selected>$shift_code</option>";
							} else {
								echo "<option value='$shift_code'>$shift_code</option>";
							}
						}
					}
				?>
				</select>
			</div>
			<div class='col-md-3 col-sm-3 col-xs-12'>
				Module 
				<select name="module" class="select2_single form-control" placeholder="Please Select">
				<?php
					$workstations = getWorkstations(DepartmentTypeEnum::SEWING, $plant_code)['workstation'];
					foreach($workstations as $workstation_id => $workstation_code) {
						if($workstation_id == $module)
						{
							echo "<option value='$workstation_id' selected>$workstation_code</option>";
						}
						else
						{
							echo "<option value='$workstation_id'>$workstation_code</option>";
						}
					}
				?>
				</select>
			</div>
			<div class='col-md-3 col-sm-3 col-xs-12'>
				Employee Id : 
				<input type="textbox" class="form-control" name="emp_no" value="<?php echo $emp_no ?>" required />
			</div>
			<div class='col-md-3 col-sm-3 col-xs-12'>
				Remarks : 
				<select name='remark' id='remark' class='select2_single form-control' placeholder='Please Select'>
					<option value='Human Error' <?php if($_POST['remark']=='Human Error'){ echo "selected";} else{ echo "";}?>>Human error</option>
					<option value='Tag card miss in production' <?php if($_POST['remark']=='Tag card miss in embellishment area'){ echo "selected";} else{ echo "";}?>>Tag card miss in Embellishment Area</option>
					<option value='Sticker is not scanning' <?php if($_POST['remark']=='Sticker is not scanning'){ echo "selected";} else{ echo "";}?>>Sticker is not scanning</option>
					<option value='Tag card missed in production' <?php if($_POST['remark']=='Tag card miss in production'){ echo "selected";} else{ echo "";}?>>Tag card Miss in Production Area</option>
					<option value='Tag card missed in Cuttin Area' <?php if($_POST['remark']=='Tag card miss in Cuttin Area'){ echo "selected";} else{ echo "";}?>>Tag card Miss in Cutting Area</option>
					<option value='Tag card miss in production' <?php if($_POST['remark']=='Tag card miss in production'){ echo "selected";} else{ echo "";}?>>Others</option>
				</select>
			</div>
			<div class='col-md-2 col-sm-2 col-xs-12' style='margin-top: 18px;'>
				<input type="submit" value="Show" class="btn btn-primary" name="show">
			</div>
		</form>
		<div class='col-md-1 col-sm-1' style='margin-left:79%;margin-top:-4%;'>
		<?php
		$url = getFullURLLevel($_GET['r'],'reprint_report.php',0,'R');
		echo "<td><a class='btn btn-primary' href='$url' onclick=\"return popitup2('$url')\" target='_blank'><i aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Re-Printed Tags History</a></td>";
		?>
		</div>

		<?php
		if(isset($_POST['show']))
		{
			// check if the bundle is present in the barcode table
			$barcode_types_string = implode("','", $barcode_types);
			$barcode_query = "SELECT external_ref_id,barcode_type from $pts.barcode where barcode = $barcode and plant_code='$plant_code' and barcode_type IN ('$barcode_types_string')";
			$barcode_result = mysqli_query($link, $barcode_query);
			$row = mysqli_fetch_array($barcode_result);
			
			$ext_ref_id   = $row['external_ref_id'];
			$barcode_type = $row['barcode_type'];

			if($row)
			{
				$sql="insert into $pps.re_print_table(bundle_id,emp_id,module_id,shift,user_name,remark,plant_code,created_user,updated_user) values('".$barcode."','".$emp_no."','".$module."','".$shift."','".$username."','".$remark."','".$plant_code."','".$username."','".$username."')";
				//echo $sql."<br>";
				$sql_result=mysqli_query($link, $sql) or exit($sql."<br/> Error in section table ");
				echo "<table class='table table-bordered'><tr><th rospan=4>You are going to take bundle print</th>";
				$url1 = getFullURLLevel($_GET['r'],'reprint_tagwith_operation.php',0,'R');
				echo "<td><a class='btn btn-info btn-sm' href='$url1?bundle_id=$barcode&plant_code=$plant_code' onclick=\"return popitup2('$url1?bundle_id=$barcode&plant_code=$plant_code')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Print With Operation</a></td>";
				$url2 = getFullURLLevel($_GET['r'],'reprint_tagwithout_operation.php',0,'R');
				echo "<td><a class='btn btn-info btn-sm' href='$url2?bundle_id=$barcode&plant_code=$plant_code' onclick=\"return popitup2('$url2?bundle_id=$barcode&plant_code=$plant_code')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Print With Out Operation</a></td>";
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
</body> 