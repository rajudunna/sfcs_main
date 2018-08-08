<html>
<head>
  <title>Add New Operation</title>
  <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
  <link rel="stylesheet" href="cssjs/bootstrap.min.css">
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<body>
<!--Added 	(1)Delete button for every operation 
			(2)semi-garment form
	by Theja on 07-02-2018
-->
<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			 Add Bundle Operation
		</div>
		<div class="panel-body">
			<div class="form-group">
				<form name="test" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
					<div class="row">
						<div class="col-sm-2">
							<b>Operation Name</b><input type="text" class="form-control" id="opn" name="opn" required>
						</div> 
						<div class="col-sm-2">
							<b>Operation code</b><input type="Number" min="400" class="form-control" id="opc" name="opc" required>
						</div>
						<div class='col-sm-2'>
							 <div class="dropdown">
								<b>Type</b>
								<select class="form-control" id="sel" name="sel" required>
									<option value='Panel' selected>Panel</option>
									<option value='SGarment' >Semi Garment</option>
									<option value='Garment' >Garment</option>
								</select>	
							</div>
						</div>
						<div class="col-sm-2">
							<b>Sewing Order Code</b><input type="text" class="form-control" id="sw_cod" name="sw_cod">
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-primary" style="margin-top:18px;">Save</button>
						</div>
						<div class="col-sm-2">
							 <div class="dropdown" hidden='true'>
								<b>Default Operation</b>
								<select class="form-control" id="sel1" name="sel1" required>
								<option value="">Please Select</option><option value='yes'>Yes</option><option value='No' selected>No</option></select>	
							</div>
						</div>
						 
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
	// include("dbconf.php");
    include("..".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	$operation_name = "";
	$default_operation = "";
	$operation_code = "";
	$sw_cod="";

	if(isset($_POST["opn"])){
		$operation_name= $_POST["opn"];
	}
	if(isset($_POST["sel1"])){
		$default_operation= $_POST["sel1"];
	}
	if(isset($_POST["opc"])){
		$operation_code= $_POST["opc"];
	}
	if(isset($_POST["sel"])){
		$type = $_POST["sel"];
	}
	if(isset($_POST["sw_cod"])){
		$sw_cod = $_POST["sw_cod"];
	}
	
	/* $servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "brandix";
	// $conn = new mysqli($servername, $username, $password, $dbname);
	$conn = mysql_connect($servername, $username, $password);
	mysql_select_db($dbname,$conn);
	if (!$conn) {
		die("Connection failed: " . mysql_error());
	} */
	if($operation_name!="" && $operation_code!="" ){
		
	$qry_insert = "INSERT INTO $brandix_bts.tbl_orders_ops_ref ( operation_name, default_operation,operation_code, type, operation_description)VALUES('$operation_name','$default_operation','$operation_code', '$type', '$sw_cod')";
	$res_do_num = mysqli_query($link,$qry_insert);
	}
	$query_select = "select * from $brandix_bts.tbl_orders_ops_ref";
	$res_do_num=mysqli_query($link,$query_select);
	echo "<div class='container'><div class='panel panel-default'><div class='panel-heading'>Operations List</div><div class='panel-body'>";
	echo "<table class='table table-bordered'>";
	echo "<thead><tr><th>S.No</th><th>Operation Name</th><th>Default Operation</th><th>Operation Code</th><th>Form</th><th>Action</th></tr></thead><tbody>";
	$i=1;
	while($res_result = mysqli_fetch_array($res_do_num)){
		//var_dump($res_result);
		
		echo "<tr>
			<td>".$i++."</td>
			<td>".$res_result['operation_name']."</td>
			<td>".$res_result['default_operation']."</td>
			<td>".$res_result['operation_code']."</td>
			<td>".$res_result['type']."</td>
			<td><a href='operations_master_edit.php?id=".$res_result['id']."' class='btn btn-info'>Edit</a>";?> 
				<a onclick="return confirm('Are you sure to delete the Operation???')" href='operations_creation.php?del_id=<?php echo $res_result['id']?>' class='btn btn-danger'>Delete</a>
	<?php echo "</td>
		</tr>";
		
	}
	echo "</tbody></table></div></div></div>";
	
	if (isset($_GET['del_id'])) 
	{
		$id = $_GET['del_id'];
		$deleteQuery = "DELETE FROM $brandix_bts.tbl_orders_ops_ref WHERE id=".$id;
		// echo $deleteQuery;
		$deleteReply = mysqli_query($link,$deleteQuery);
		// mysql_query($deleteQuery, $link) or exit("Problem Deleting the Operation/".mysql_error());
		if ($deleteReply) {?>
			<script type="text/javascript">
				alert("Sucessfully Deleted the Operation");
				var ajax_url ="operations_creation.php";Ajaxify(ajax_url);

			</script>
		<?php	}else{	?>
			<script type="text/javascript">
				alert("Falied to delete the Operation");
				var ajax_url ="operations_creation.php";Ajaxify(ajax_url);
						
			</script>
		<?php }
	}
?>
</body>
</html>