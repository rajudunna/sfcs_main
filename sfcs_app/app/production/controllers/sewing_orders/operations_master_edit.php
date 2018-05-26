<html lang="en">
<head>
	<title>Edit Bundle Operation</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
	<link rel="stylesheet" href="cssjs/bootstrap.min.css">
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<style>
		.pull{    
			float: right!important;
			margin-top: -7px;
		}
	</style>
</head>
<?php
	include("dbconf.php");	
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
		$qry_insert = "select * from tbl_orders_ops_ref where id=".$id;	
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
						<a href='operations_creation.php' class='pull btn btn-warning'>Back</a>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<form name="test" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
								<div>
									<b></b><input type='hidden' class='form-control' id='id' name='id' required value = <?php echo $_GET['id'] ?> />
								</div>
								<div class="row">
									<div class="col-sm-2">
										<b>Operation Name</b>
										<input type="text" class="form-control" id="opn" name="opn" value= "<?php echo $row[0]['operation_name']?>" required>
									</div> 
									<div class="col-sm-2">
										 <div class="dropdown">
											<b>Default Operation</b>
											<select class="form-control" id="sel1" name="sel1" required>
												<option value="">Please Select</option>
												<option value='Yes' <?php echo $row[0]['default_operation']== 'Yes'? 'selected' : ''?>>Yes</option>
												<option value='No' <?php echo $row[0]['default_operation']== 'No'? 'selected' : ''?>>No</option>
											</select>	
										</div>
									</div>
									<div class="col-sm-2">
										<b>Operation code</b><input type="text" class="form-control" id="opc" name="opc" value= "<?php echo $row[0]['operation_code']?>" required>
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
										<b>Sewing Order Code</b><input type="text" class="form-control" id="sw_cod" name="sw_cod" value= "<?php echo $row[0]['operation_description']?>">
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
		if($operation_name!="" && $default_operation!="" && $operation_code!=""){
			
			$qry_insert1 = "update tbl_orders_ops_ref set operation_description='".$sw_cod."', type='".$type."', operation_name='$operation_name',default_operation='".$default_operation."',operation_code='$operation_code' where id='$id'";
			$res_do_num1 = mysqli_query($link,$qry_insert1);
			header('location:operations_creation.php');
		}
	}else{
			// header('location:view.php');
		}
 ?>