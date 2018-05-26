<html>
<head>
 <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<?php
error_reporting (0);
include("dbconf.php");

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}else{
	//echo "Connection Success";
}
$qry_get_product_style = "SELECT id,product_style FROM tbl_orders_style_ref";
//echo $qry_get_product_style;
$result = $conn->query($qry_get_product_style);
?>
<div class='container'>
	<form action = "<?php $_PHP_SELF ?>" method="GET" >
		<div class="row">
		    <div class="form-group col-md-3">
		    	<label for="style">Product Style</label>		      
		    	<select class="form-control" id="style" name="style">
				   	<option value=''>Select Style No</option>
				    <?php				    	
						if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
								echo "<option value='".$row['id']."'>".$row['product_style']."</option>";
							}
						} else {
							echo "<option value=''>No Data Found..</option>";
						}
					?>
				</select>
		    </div>			   
		    <div class="form-group col-md-2" style="padding-top: 21px;">
		    	<label for="search"></label>
		    	<button type="submit" class="form-control btn btn-primary">Submit</button>
		    </div>
		    <div class="form-group col-md-2" style="padding-top: 21px;">
		    	<label for="clear"></label>
		    	<button type="reset" class="form-control btn btn-warning" id="clear">Clear</button>
		    </div>
	    </div>
	</form>
	<form id="table_form" action = "<?php $_PHP_SELF ?>" method="post">
		<table class="table table-striped">
		    <?php			
				if($_GET["style"]){
					echo '<thead>
						<tr><th colspan="8"></th><th><button type="submit" class="form-control btn btn-info">Save</button></th></tr>	    
						<tr>
							<th>S.No.</th>
							<th>Operation Name</th>
							<th>Operation Code</th>
							<th>Default Operation</th>
							<th>Prioity</th>
						</tr>
					</thead>
					<tbody>';
		     		$sql = "SELECT * FROM `tbl_orders_ops_ref`";
					
					$result = $conn->query($sql);
					if($result->num_rows > 0){
						// output data of each row
						$count = 0;
						while($row = $result->fetch_assoc()) {
							$count++;
							/*echo "<tr><td style='display:none;'><input type='hidden' name='id[".$count."]' value=".$row['id']."></td><td>".$count."</td><td>".$row['item_code']."</td><td>".$row['item_description']."</td><td>".$row['ref1']."</td>
							<td>".$row['lot_number']."</td><td>".$row['requested_quantity']."</td><td>".$row['allocated_quantity']."</td>
							<td><input type='text' name='approved[".$count."]'";?><?php if($row['approved_quantity']){ echo "value=".$row['approved_quantity'];}else{echo "value=".$row['allocated_quantity'];}?><?php echo"></td></tr>";
							*/
							$default_operation=$row['default_operation'];
							//echo $default_operation;
							echo "<tr>
							<td style='display:none;'><input type='hidden' name='id[".$count."]' value=".$row['id']."></td>
							<td>".$count."</td>
							<td>".$row['operation_name']."</td>
							<td>".$row['operation_code']."</td>";
							if($default_operation=='YES'){
								echo"<td><input type='checkbox' name='checkbox[".$count."]' id='checkbox' class='checkbox checkbox-success checkbox-inline' checked></td>";
							}else{
								echo"<td><input type='checkbox' name='checkbox[".$count."]' id='checkbox' class='checkbox checkbox-success checkbox-inline'></td>";
							}
							echo "<td><input type='text' name='priority[".$count."]'";?><?php echo"></td>";
							echo "</tr>";
						}
					} else {
						echo "<tr><td colspan='9'><center><strong>No Records Found</strong></center></td></tr>";
					}

					if($_POST){
						if(count($_POST['id'])>0){
							for($i=1;$i<=count($_POST['id']);$i++){
								$Operation_id=$_POST['id'][$i];
								$checkbox=$_POST['checkbox'][$i];
								$priority=$_POST['priority'][$i];
								$style_id = $_GET["style"];
								//echo "Its working-".$Operation_id."-".$style_id."-".$checkbox."</br>";
								if($checkbox=='on'){
								$qry_update_qty = "INSERT INTO tbl_style_ops_master (parent_id,operation_name,operation_order)VALUES ($style_id, $Operation_id, $priority)";
								//echo $qry_update_qty."</br>";
								$spdr = $conn->query($qry_update_qty);
								}								
							}
							//die();
							//header("Refresh:0");
							header('Location: /material_approval.php');
							die();
						}
					}
					$conn->close();	
				}else{
					echo "<tr><td colspan='9'><center><strong>Please Select Style Code and submit</strong></center></td></tr>";
					
				}
				
				?>
			</tbody>
		</table>
	</form>
</div>
</body>
</html>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
//var dono = "<?php echo isset($_GET['dono']) ? $_GET['dono'] : ''; ?>";
//$("#dono").val(dono);
$("#clear").click(function(){
    window.location.href="/material_approval.php";
});
</script>