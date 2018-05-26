
<!DOCTYPE html>
<html>
<head>
	<title>Add Good and Rejected Panels</title>
<!--<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="js/style.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
 <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<!-- Latest compiled and minified CSS -->
<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" href="cssjs/bootstrap.min.css">
<link rel="stylesheet" href="cssjs/select2.min.css">
<link rel="stylesheet" href="cssjs/font-awesome.min.css">
<script type="text/javascript" src="cssjs/jquery.min.js"></script>
<script type="text/javascript" src="cssjs/select2.min.js"></script>
<script src="cssjs/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<?php
	include("dbconf.php");
?>
	<br>
	<form name="bundle" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
		<div class="panel panel-primary">
			<div class="panel-heading">Add Good and Rejected Panels</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-2">
						<label>Bundle Number:</label>
						<input type="text" class="form-control" name="bundle_number" id="bundle_number" placeholder="Scan here..." required>
					</div>
					<div class="form-group col-md-3">

						<label>Operation Code:</label>
						<select id="op_code" name="op_code" class="form-control"  required>
							<option value="">Please Select</option>
							<?php 
								$sql = "select operation_name, operation_code from bundle_creation_data LEFT JOIN tbl_orders_ops_ref ON tbl_orders_ops_ref.operation_code = bundle_creation_data.operation_id WHERE bundle_number= '".$bundle_number."'";
								$op_code_res =mysqli_query($link,$sql);
								if (mysqli_num_rows($op_code_res) > 0){
									while ($sql_row = mysqli_fetch_array($op_code_res)) {

										echo  "<option value='".$sql_row['operation_code']."'>".trim($sql_row['operation_name'])."</option>";
									}
								}
							?>
							
						</select>
					</div>


					<div class="col-md-2">

						<label>Good Panel:</label>
						<input type="number" name="good_panel" id="good_panel" class="form-control"  required>
					</div>

					<div class="col-md-2">

						<label>Rejected Panel:</label>
						<input type="number" name="rejected_panel" id="rejected_panel" class="form-control" required>
					</div>
					<div class="col-md-2">

						<label>Total Panels:</label>
						<input type="number" readonly name="total_panels" id="total_panels" class="form-control"  required>
					</div>

					<div class="col-md-1">
						<label></label><br>
						<input type="submit" name="Submit" value="Submit" class="btn btn-info btn-xl">
					</div>
				</div>
			</div>
		</div>

	</form>
</body>
</html>
<?php
	if (isset($_POST['Submit'])) {

		$bundle_code= $_POST['bundle_number'];
		$op_code = $_POST['op_code'];
		$good_panel = $_POST['good_panel'];
		$rejected_panel = $_POST['rejected_panel'];
		// echo $bundle;
		$bundle_num=explode("-",$bundle_code);
		$bundle=$bundle_num[0];
		$sql = "select * from bundle_creation_data  WHERE bundle_number= '".$bundle."' and operation_id = '".$op_code."'";
		// echo $sql;
		$op_code_res =mysqli_query($link,$sql);
		if (mysqli_num_rows($op_code_res) > 0){
			while ($sql_row = mysqli_fetch_array($op_code_res)) {
				$date = date('Y/m/d h:i:s');
				$style = $sql_row['style'];
				$schedule = $sql_row['schedule'];
				$color = $sql_row['color'];
				$cut_no = $sql_row['cut_number'];
				$size = $sql_row['size_title'];
				$missing_qty = $sql_row['missing_qty'];
				$bundle_id = $sql_row['id'];
				// var_dump($)
			}

			$sql1 = "INSERT INTO tbl_emblishment_recover_panels(date_time, bundle_number, operation_code, style, schedule, color, good_panels, rejected_panels, cut_no, size) values('".$date."', '".$bundle."', '".$op_code."', '".$style."', '".$schedule."', '".$color."', '".$good_panel."', '".$rejected_panel."', '".$cut_no."', '".$size."')";

			// echo $sql1;

			$data_save =mysqli_query($link,$sql1);

			// var_dump($data_save);
			if($data_save){
				// echo $bundle_id; 
				$total = $missing_qty - $good_panel + $rejected_panel;
				$update_bundle_query = "UPDATE bundle_creation_data SET missing_qty=".$total." WHERE id=".$bundle_id;

				// echo $update_bundle_query;
				$data_update =mysqli_query($link,$update_bundle_query);
				if($data_update){
					header("Location:adding_bundle_recovery_panels.php?Message=true");
				}else {
					header("Location:adding_bundle_recovery_panels.php?Message=false");
				}
				// echo "Data Saved Successfully.....";
			}else {
				header("Location:adding_bundle_recovery_panels.php?Message=false");

				// echo "Error! Data Not Saved";
			}
		}
	}

?>
<?php
	if (isset($_GET['Message'])) {
		// echo $_GET['Message'];
		if($_GET['Message'] == 'true'){
			// echo "<p>Data Saved Successfully.....</p>";
			echo '<div class="alert alert-success">
			  <strong>Success!</strong> Data Saved Successfully.....
			</div>';
		}elseif($_GET['Message'] == 'false') {
			// echo "Error! Data Not Saved, Contact IT Team..";
			echo '<div class="alert alert-danger">
			  <strong>Error!</strong> Data Not Saved, Contact IT Team..
			</div>';
		}
	}
?>
<script type="text/javascript">
$(document).ready(function(){

	$("#bundle_number").change(function()
	{
		// alert();
	var bundle_number = $('#bundle_number').val();
	var op_code = $('#op_code').val();
		$('select[name="op_code"]').html('<option value="">Please Select</option>');
		$.ajax
			({
					type: "POST",
					url:"get_op_codes.php?r=getdata&bundle_number="+bundle_number,
					dataType: 'Json',
					data: {bundle_number: $('#bundle_number').val()},
					success: function(response)
					{
						console.log(response);
						if(response != null){
							$.each(response, function(key, value) {
							$('select[name="op_code"]').append('<option value="'+ key +'">'+ key + ' - '+ value +'</option>');
							});
						}else {
							alert('No operation Codes...');
						}
					}
			});
	});

	$("#good_panel, #rejected_panel").on('change', function(){

		// function validation(){
			var good_panel = $("#good_panel").val();
			var rej_panel = $("#rejected_panel").val();
			var bundle_number = $('#bundle_number').val();
			var op_code = $('#op_code').val();
			// alert(rej_panel);
			var total = Number(good_panel)+Number(rej_panel);
			// console.log(bundle_number);

			$.ajax
				({
						type: "POST",
						url:"get_op_codes.php?r=getdata&total_quantity="+total+"&bundle_number="+bundle_number+"&op_code="+op_code,
						dataType: 'Json',
						data: {total_quantity: total, bundle_number: bundle_number, op_code: op_code},
						success: function(response)
						{
							console.log(response.status);

							if(response.status == 'true'){
								$("#total_panels").val(total);

							}else{
								$("#total_panels").val(0);
								$("#good_panel").val(0);
								$("#rejected_panel").val(0);
								alert('Given quantity is more than your data. Available qty is ' + response.data);
							}
							// if(response != null){
							// 	$.each(response, function(key, value) {
							// 	$('select[name="op_code"]').append('<option value="'+ key +'">'+ value +'</option>');
							// 	});
							// }else {
							// 	alert('No operation Codes...');
							// }
						}
			});
		// }
	});

	// $("#rejected_panel").change(function(){
	// 	var good_panel = $("#good_panel").val();
	// 	var rej_panel = $("#rejected_panel").val();

	// 	var total = good_panel+rej_panel;
	// 	$("#total_panels").val(total);
	// });
});
</script>

