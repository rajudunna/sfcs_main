<html lang="en">
<head>
	<title>Edit Bundle Operation</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
	<!--<link rel="stylesheet" href="cssjs/bootstrap.min.css">
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>-->
	<style>
		.pull{    
			float: right!important;
			margin-top: -7px;
		}
	</style>
	 <script>
function validateQty(event) 
{
	event = (event) ? event : window.event;
	var charCode = (event.which) ? event.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}
</script>
</head>
<?php
	// include("dbconf.php");
	include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));	
	$qry_short_codes = "SELECT * from $brandix_bts.ops_short_cuts";
	$result_oper = $link->query($qry_short_codes);
	if(isset($_GET['id'])){
		
		$operation_name = "";
		$default_operation = "";
		$operation_code = "";
		$type = "";
		$sw_cod ="";
		$id = $_GET['id'];
		/* 
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "brandix";
		$conn = mysql_connect($servername, $username, $password);
		mysql_select_db($dbname,$conn);
		if (!$conn) {
			die("Connection failed: " . mysql_error());
		}else{
			// echo "Connected successfully";
		} */
		$qry_insert = "select * from $brandix_bts.tbl_orders_ops_ref where id=".$id;
		//echo $qry_insert;
		$res_do_num = mysqli_query($link,$qry_insert);
		//$row=[];
		while($res_result = mysqli_fetch_array($res_do_num)){
			$row[] = $res_result;
		}
		//var_dump($row);
		?>
			<!--Added 	(1)Back Button in panel heading 
						(2)semi-garment form
				by Theja on 07-02-2018
			-->
			<div class="container">
				<div class="panel panel-primary">
					<div class="panel-heading">Update Operation <?php echo "<b>".$row[0]['operation_name']."</b>"; ?>
						<a href='<?= getFullURLLevel($_GET['r'],'operations_creation.php',0,'N'); ?>' class='pull btn btn-warning'>Back</a>
					</div>
					<div class="panel-body">
						<div class="alert alert-danger" style="display:none;">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<strong>Info! </strong><span class="sql_message"></span>
			</div>
						<div class="form-group">
							<form name="test" action="index.php" method="GET">
							
								<input type="hidden" id="r" name="r" value= "<?= $_GET['r']; ?>">
								<div>
									<b></b><input type='hidden' class='form-control' id='id' name='id' required value = <?php echo $_GET['id'] ?> />
								</div>
								<div class="row">
									<div class="col-sm-2">
										<b>Operation Name<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></b>
										<input type="text" class="form-control" id="opn" name="opn" value= "<?php echo $row[0]['operation_name']?>" required>
									</div> 
									<div class="col-sm-2">
										<b>Operation code<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></b><input type="number" onkeypress="return validateQty(event);" class="form-control" id="opc" name="opc" value= "<?php echo $row[0]['operation_code']?>" required>
									</div>
									<div class="col-sm-2">
										 <div class="dropdown">
											<b>Type</b>
											<select class="form-control" id="sel" name="sel" required>
												<option value='Panel' <?php echo $row[0]['type']== 'Panel'? 'selected' : ''?>>Panel</option>
												<option value='SGarment' <?php echo $row[0]['type']== 'SGarment'? 'selected' : ''?>>Semi Garment</option>
												<option value='Garment' <?php echo $row[0]['type']== 'Garment'? 'selected' : ''?>>Garment</option>
											</select>	
										</div>
									</div>
									<div class="col-sm-2">
									 <div class="dropdown">
										<b>Report To ERP<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'></font></span></b>
										<select class="form-control" id="sel1" name="sel1" required>
										<option value="">Please Select</option>
										<option value='yes' <?php echo $row[0]['default_operation']== 'yes'? 'selected' : ''?>>Yes</option>
										<option value='No' <?php echo $row[0]['default_operation']== 'No'? 'selected' : ''?>>No</option></select>	
									</div>
								</div>
									<div class="col-sm-2" hidden="true">
										<b>Sewing Order Code</b><input type="text" class="form-control" id="sw_cod" name="sw_cod" value= "<?php echo $row[0]['operation_description']?>">
									</div> 
									<div class = "col-sm-2">
								<label for="style">Short Key Code<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>			
									<select id="short_key_code" name = "short_cut_code" style="width:100%;" class="form-control" required>
									<option value='0'>Select Short Code</option>
									<?php				    	
										if ($result_oper->num_rows > 0) {
											while($row_short = $result_oper->fetch_assoc()) {
											$row_value = $row_short['short_key_code'];
												if($row_short['short_key_code'] == $row[0]['short_cut_code'])
												{
													$selected = 'selected';
												}
												else
												{
													$selected = '';
												}
												echo "<option value='".$row_short['short_key_code']."' $selected>".$row_value."</option>";
											}
										} else {
											echo "<option value=''>No Data Found..</option>";
										}
									?>
								</select>

								</div>
									<div class="col-sm-3">
										<b>Work Center</b><input type="text" class="form-control" id="work_center_id" name="work_center_id" value= "<?php echo $row[0]['work_center_id']?>">
									</div> 
									<div class="col-sm-3">
										<b>Category</b>
										<select class="form-control" id="category" name="category" required>
											<option value='' <?php echo $row[0]['category']== 'please select'? 'selected' : ''?>>Please Select</option>
											<option value='cutting' <?php echo $row[0]['category']== 'cutting'? 'selected' : ''?>>Cutting</option>
											<option value='sewing' <?php echo $row[0]['category']== 'sewing'? 'selected' : ''?>>Sewing</option>
											<option value='packing' <?php echo $row[0]['category']== 'packing'? 'selected' : ''?>>Packing</option>
										</select>
									</div>
									<div class="col-sm-2">
										<button type="submit" class="btn btn-info" style="margin-top:18px;">Update</button>
									</div>
								</div>
								
							</form>
						</div>
					</div>
				</div>
			</div>
		<?php
		
		$operation_name = "";
		$default_operation = "";
		$operation_code = "";	
		$type = "";
		$sw_cod = "";
		$id = $_GET['id'];
		if(isset($_GET["opn"])){
			$operation_name= $_GET["opn"];
		}
		if(isset($_GET["sel1"])){
			$default_operation= $_GET["sel1"];
		}
		if(isset($_GET["opc"])){
			$operation_code= $_GET["opc"];
		}
		if(isset($_GET["sel"])){
			$type= $_GET["sel"];
		}
		if(isset($_GET["sw_cod"])){
			$sw_cod= $_GET["sw_cod"];
		}
		if(isset($_GET["short_cut_code"])){
			$short_cut_code= $_GET["short_cut_code"];
		}
		if(isset($_GET["work_center_id"])){
			$work_center_id= $_GET["work_center_id"];
		}
		if(isset($_GET["category"])){
			$category= $_GET["category"];
		}
		if($operation_name!="" && $operation_code!="" && $short_cut_code != ""){
			
			$checking_qry = "select count(*)as cnt from $brandix_bts.tbl_orders_ops_ref where operation_code = $operation_code and id <> $id";
			//echo $checking_qry;
			$res_checking_qry = mysqli_query($link,$checking_qry);
		//$row=[];
			while($res_res_checking_qry = mysqli_fetch_array($res_checking_qry))
			{
				$cnt = $res_res_checking_qry['cnt'];
			}
			// echo $cnt;
			$short_key_code_check_qry = "select count(*) as cnt from $brandix_bts.tbl_orders_ops_ref where short_cut_code = '$short_cut_code' and id <> $id";
			$res_short_key_code_check_qry = mysqli_query($link,$short_key_code_check_qry);
			while($res_res_res_short_key_code_check_qry = mysqli_fetch_array($res_short_key_code_check_qry))
			{
				$cnt_short = $res_res_res_short_key_code_check_qry['cnt'];
			}
			if($cnt == 0 && $cnt_short == 0)
			{
				$qry_insert1 = "update $brandix_bts.tbl_orders_ops_ref set operation_description='".$sw_cod."', type='".$type."', operation_name='$operation_name',operation_code='$operation_code',short_cut_code='$short_cut_code',default_operation='$default_operation',work_center_id='$work_center_id',category='$category' where id='$id'";
				$res_do_num1 = mysqli_query($link,$qry_insert1);
				echo "<h3 style='color:red;text-align:center;'>Please Wait!!!  While Redirecting to page !!!</h3>";
				//$sql_message = 'Operation Updated Successfully...';
				//echo '<script>$(".sql_message").html("'.$sql_message.'");$(".alert").show();</script>';
				// echo "<script>sweetAlert('Operation Updated Successfully','','success')</script>";
				$hurl = getFullURLLevel($_GET['r'],'operations_creation.php',0,'N');
				// header('location:'.$hurl);
				echo "<script type=\"text/javascript\"> 
					setTimeout(\"Redirect()\",0); 
					function Redirect() {  
						sweetAlert('Operation Updated Successfully','','success');
						location.href = '$hurl'; 
					}
				</script>";
			}
			else if($cnt != 0)
			{
				$sql_message = 'Operation Code Already in use. Please give other.';
				echo '<script>$(".sql_message").html("'.$sql_message.'");$(".alert").show();</script>';
				die();
			}
			else if($cnt_short != 0)
			{
				$sql_message = 'Short Key Code Already in use. Please give other.';
				echo '<script>$(".sql_message").html("'.$sql_message.'");$(".alert").show();</script>';
				die();
			}
			else if($cnt_short != 0 && $cnt != 0)
			{
				$sql_message = 'Short Key Code and Operation Code Already in use. Please give other.';
				echo '<script>$(".sql_message").html("'.$sql_message.'");$(".alert").show();</script>';
				die();
			}
	
		}
	}else{
			// header('location:view.php');
		}
 ?>
