<!--- Developed by Srinivas Y --->
<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<!-- Latest compiled and minified CSS -->
	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="js/style.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php
include("dbconf.php");
error_reporting (0);
$servername = $host_adr;
$username = $host_adr_un;
$password = $host_adr_pw;
$dbname = $database;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) { 
	die("Connection failed: " . $conn->connect_error);
}else{
	//echo "Connection Success";
}
$qry_get_product_style = "SELECT id,style FROM bundle_creation_data GROUP BY style";
$result = $conn->query($qry_get_product_style);
?>
<form method ='POST' action='<?php $_SERVER["PHP_SELF"]?>'>
<div class='container'>
			<div class="panel panel-default">
				<div class="panel-body">
						<div class="row">
							<div class="form-group col-md-2">
								<label for="style">Select Style<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>		      
								<select class="form-control" id="style" name="style">
									<option value=''>Select Style No</option>
									<?php				    	
										if ($result->num_rows > 0) {
											while($row = $result->fetch_assoc()) {
												echo "<option value='".$row['style']."'>".$row['style']."</option>";
											}
										} else {
											echo "<option value=''>No Data Found..</option>";
										}
									?>
								</select>
							</div>
							<div class ='col-md-2'>
								<label for="title">Select Schedule:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
								<select name="schedule" class="form-control" id='schedule' style="style">
								<option value=''>Select Schedule</option>
								</select>
							</div>
							<div class ='col-md-2'>
								<label for="title">Select Color:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
								<select name="color" class="form-control" id='color' style="style">
								<option value=''>Select Color</option>
								</select>
							</div>
							<div class ='col-md-2'>
								<label for="title">Select Cut:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
								<select name="cut_no" class="form-control" id='cut_no' style="cut_no">
								<option value=''>Select Cut No.</option>
								</select>
							</div>
							<div class='col-md-2'>
								<label for="title">Select Operation:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
								<select name="operation" class="form-control" id='operation' style="style" required>
								<option value=''>Select Operation</option>
								</select>
							</div>
							<div class='col-md-1'>
							<br>
								<button type = 'button' class='btn btn-primary' id='get_details' name='get_details' value='Get Details' style="margin-top: 4px;">Get Details</button>
							</div>
							<div class='col-md-1' hidden='true' id='operations_div_save'>
							<br>
									<input type='SUBMIT' value='SAVE' name='SUBMIT' class='btn btn-primary' style="margin-top: 4px;">
							</div>
							
						</div>
			</div>
		</div>
			<hr>
<div class='row'>
</div><br>
	<div id ="dynamic_table1">
	</div>
</form>

<script type="text/javascript">
$(document).ready(function(){
	$("#style").change(function()
	{
		$("#dynamic_table1").html(" ");
		$('#schedule').empty();
		$('select[name="schedule"]').append('<option value="Select Schedule">Select Schedule</option>');
		$('#color').empty();
		$('select[name="color"]').append('<option value="Select Color">Select Color</option>');
		$('#cut_no').empty();
		$('select[name="cut_no"]').append('<option value="Select Color">Select Cut No.</option>');
		var style = $('#style option:selected').text();
		$.ajax
			({
					type: "POST",
					url:"functions_send.php?r=getdata&style="+style,
					dataType: 'Json',
					data: {style: $('#style').val()},
					success: function(response)
					{
						// console.log(response);
						$.each(response, function(key, value) {
						$('select[name="schedule"]').append('<option value="'+ key +'">'+ value +'</option>');
						});
					}
			});
	});
	$("#schedule").change(function()
	{
		$("#dynamic_table1").html(" ");
		$('#color').empty();
		$('select[name="color"]').append('<option value="Select Color">Select Color</option>');
		$('#cut_no').empty();
		$('select[name="cut_no"]').append('<option value="Select Color">Select Cut No.</option>');
		var schedule = $('#schedule option:selected').text();
		//alert(schedule);
		$.ajax
			({
					type: "POST",
					url:"functions_send.php?r=getdata&schedule="+schedule,
					dataType: 'Json',
					data: {schedule: $('#schedule').val()},
					success: function(response)
					{
						//alert(response);
						$.each(response, function(key, value) {
						$('select[name="color"]').append('<option value="'+ key +'">'+ value +'</option>');
						});
					}
			});
	});
	$("#color").change(function()
	{
		$("#dynamic_table1").html(" ");
		$('#cut_no').empty();
		$('select[name="cut_no"]').append('<option value="Select Color">Select Cut No.</option>');
		var color = $('#color option:selected').text();
		var style = $('#style option:selected').text();
		var schedule = $('#schedule option:selected').text();
		var params_cut = [style,schedule,color]
		//alert(schedule);
		$.ajax
			({
					type: "POST",
					url:"functions_send.php?r=getdata&color="+params_cut,
					dataType: 'Json',
					data: {schedule: $('#color').val()},
					success: function(response)
					{
						console.log(response);
						var data = response;
						ops_data = data.data_ops;
						cut_data = data.data_cut;
						data = data.data_tbl;
						$.each(ops_data, function(key, value) {
						$('select[name="operation"]').append('<option value="'+ key +'">'+ value +'</option>');
						});
						$.each(cut_data, function(key, value) {
						$('select[name="cut_no"]').append('<option value="'+ key +'">'+ value +'</option>');
						});
					}
			});
	});
	
});

</script>