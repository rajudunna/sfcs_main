<!--- Developed by Srinivas Y --->
<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<!-- Latest compiled and minified CSS 
	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="js/style.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
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
	<div class="panel panel-primary">
				<div class="panel-heading">Garment Sending</div>
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
							</div>
							
						</div>
				</div>
	</div>
			<hr>
<div class="panel panel-primary">
				<div class="panel-heading">Garment Sending</div>
				<div class="panel-body">
					<div class='row'>
						<div class='col-md-2' hidden='true'>
							<label for="title">Search Size:</label>
							<select name="sizes" class="form-control" id='sizes' style="style" onchange='searchfunction()'>
								<option value=''>Select Size</option>
							</select>
						</div>
						<div class='col-md-6'>

						</div>
						<div class="form-group col-md-2">
                        	<label>Shift:<span style="color:red">*</span></label>
                        	<select class="form-control shift"  name="shift" id="shift" style="width:100%;" required>
                        		<option value="">Select Shift</option>
                        		<option value="A">A</option>
                        		<option value="B">B</option>
                        	</select>
						</div>
						<div class='col-md-2' id='saving_tbl'>
							<br>
							<input type='SUBMIT' value='SAVE' name='SUBMIT' class='btn btn-primary' style="margin-top: 4px;">
						</div>

					</div>
<br>
						<div id ="dynamic_table1">
						</div>
				</div>
</div>
</div>
</form>
<div class="ajax-loader" id="loading-image" style="margin-left: 688px;margin-top: 35px;border-radius: -80px;width: 150px;">
		<img src='ajax-loader.gif' class="img-responsive" />
</div>
<?php
if(isset($_POST['SUBMIT']))
{
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
	$username_qry = strtoupper($_SERVER['PHP_AUTH_USER']);
	$style = $_POST['style'];
	$schedule = $_POST['schedule'];
	$color = $_POST['color'];
	$cut_no = $_POST['cut_no'];
	$size = $_POST['size'];
	$qty = $_POST['qty'];
	$pre_qty = $_POST['pre_qty'];
	$sending_qty = $_POST['oper_seq2'];
	$operation = $_POST['operation'];
	$shift = $_POST['shift'];
	$length = sizeof($size);
	foreach ($size as $key => $value)
	{
			$query_check = "select id,count(*) as cnt from tbl_garmet_ops_track where style ='$style' and schedule ='$schedule' and color ='$color' and cut_number =$cut_no and operation_id=$operation and size_title='$size[$key]'";
			//echo $query_check;
			$result1 = $conn->query($query_check);
			while($row1 = $result1->fetch_assoc())
			{
				$updatable_id = $row1['id'];
				$count = $row1['cnt'];
			}
			if($count <= 0)
			{
				$execution_query = "insert into tbl_garmet_ops_track (style,schedule,color,cut_number,received_qty,rejected_qty,sew_out_qty,sendig_qty,operation_id,size_title,shift) values ('$style','$schedule','$color','$cut_no',0,0,'$qty[$key]','$sending_qty[$key]',$operation,'$size[$key]','$shift')";
			}
			else
			{
				$update_value = $pre_qty[$key]+$sending_qty[$key];
				$execution_query = "update tbl_garmet_ops_track set sendig_qty =$update_value where id = $updatable_id";
			}
			$data_insert = $conn->query($execution_query);
			if($sending_qty[$key] != 0)
			{
				$ops_desc_qry = "select * from tbl_orders_ops_ref where operation_code=$operation";
				$result_ops_desc_qry = $conn->query($ops_desc_qry);
				while($row_ops= $result_ops_desc_qry->fetch_assoc())
				{
					$ops_desc = $row_ops['operation_name'];
					$is_m3 = $row_ops['default_operation'];
				}
				$query_bundle_cre_data = "select * from bundle_creation_data where style ='$style' and schedule ='$schedule' and color='$color' and cut_number=$cut_no and size_title='$size[$key]'";
				//echo $query_bundle_cre_data;
				$result_query_bundle_cre_data = $conn->query($query_bundle_cre_data);
				if ($result_query_bundle_cre_data->num_rows > 0) 
				{
					while($row_result_query_bundle_cre_data = $result_query_bundle_cre_data->fetch_assoc())
					{
						$docket_number = $row_result_query_bundle_cre_data['docket_number'];
						$main_id = $row_result_query_bundle_cre_data['id'];
					}
				}
				$remarks = "0-".$shift."-G";
				if($is_m3 == 'Yes')
				{
					$insert_m3_bulk_ops = "insert into m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_reason,sfcs_remarks,sfcs_log_user,m3_op_code,sfcs_job_no,sfcs_mod_no,sfcs_shift,m3_op_des,sfcs_tid_ref,m3_error_code) values (NOW(),'$style','$schedule','$color','$size[$key]','$size[$key]','$docket_number',$sending_qty[$key],'','$remarks','$username_qry',$operation,'','','$shift','$ops_desc','$main_id','srinivas')";
					$conn->query($insert_m3_bulk_ops);
				}
				
			}
	}
	if($data_insert){
		header("Location:send_quantity_report.php?Message=true");
	}else {
		header("Location:send_quantity_report.php?Message=false");
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
	$('#loading-image').hide();
	$('#saving_tbl').hide();
	$("#style").change(function()
	{
		$('#saving_tbl').hide();
		$("#dynamic_table1").html(" ");
		$('#schedule').empty();
		$('select[name="schedule"]').append('<option value="Select Schedule">Select Schedule</option>');
		$('#color').empty();
		$('select[name="color"]').append('<option value="Select Color">Select Color</option>');
		$('#cut_no').empty();
		$('select[name="cut_no"]').append('<option value="Select Color">Select Cut No.</option>');
		$('#sizes').empty();
		$('select[name="sizes"]').append('<option value="Select size">Select Size.</option>');
		var style = $('#style option:selected').text();
		$('#loading-image').show();
		$.ajax
			({
					type: "POST",
					url:"functions_send.php?r=getdata&style="+style,
					dataType: 'Json',
					data: {style: $('#style').val()},
					success: function(response)
					{
						// console.log(response);
						$('#loading-image').hide();
						$.each(response, function(key, value) {
						$('select[name="schedule"]').append('<option value="'+ key +'">'+ value +'</option>');
						});
					}
			});
	});
	$("#schedule").change(function()
	{
		$('#saving_tbl').hide();
		$("#dynamic_table1").html(" ");
		$('#color').empty();
		$('select[name="color"]').append('<option value="Select Color">Select Color</option>');
		$('#cut_no').empty();
		$('select[name="cut_no"]').append('<option value="Select Color">Select Cut No.</option>');
		$('#sizes').empty();
		$('select[name="sizes"]').append('<option value="Select size">Select Size.</option>');
		var schedule = $('#schedule option:selected').text();
		$('#loading-image').show();
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
						$('#loading-image').hide();
						$.each(response, function(key, value) {
						$('select[name="color"]').append('<option value="'+ key +'">'+ value +'</option>');
						});
					}
			});
	});
	$("#color").change(function()
	{
		$('#saving_tbl').hide();
		$("#dynamic_table1").html(" ");
		$('#cut_no').empty();
		$('select[name="cut_no"]').append('<option value="Select Color">Select Cut No.</option>');
		$('#sizes').empty();
		$('select[name="sizes"]').append('<option value="Select size">Select Size.</option>');
		$('#operation').empty();
		$('select[name="operation"]').append('<option value="Select operation">Select operation.</option>');
		var color = $('#color option:selected').text();
		var style = $('#style option:selected').text();
		var schedule = $('#schedule option:selected').text();
		var params_cut = [style,schedule,color];
		$('#loading-image').show();
		//alert(schedule);
		$.ajax
			({
					type: "POST",
					url:"functions_send.php?r=getdata&color="+params_cut,
					dataType: 'Json',
					data: {schedule: $('#color').val()},
					success: function(response)
					{
						$('#loading-image').hide();
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
	$("#get_details").click(function()
	{
		$('#sizes').empty();
		$('select[name="sizes"]').append('<option value="Select size">Select Size.</option>');
		var flag=0;
		$("#dynamic_table1").html(" ");
		var operation = $('#operation').val();
		if(operation == '')
		{
			alert("Please select operation you have to send");
			flag = 1;
		}
		if(flag==0)
		{
			$("#dynamic_table1").html(" ");
			var color = $('#color option:selected').text();
			var style = $('#style option:selected').text();
			var schedule = $('#schedule option:selected').text();
			var cut_no = $('#cut_no option:selected').text();
			color = "'"+color+"'";
			var params = [style,schedule,color,cut_no,operation];
			$('#loading-image').show();
			//alert(schedule);
			$.ajax
				({
						type: "POST",
						url:"functions_send.php?r=getdata&params="+params,
						dataType: 'Json',
						data: {params: $('#params').val()},
						success: function(response)
						{
							$('#loading-image').hide();
							$('#operations_div_save').show();
							//console.log(response);
							var data = response.table_data;
							var sizes_data = response.sizes_data;
							$.each(sizes_data, function(key, value) {
							$('select[name="sizes"]').append('<option value="'+ key +'">'+ value +'</option>');
							});
							if(data != null)
							{
								var markup = "<table class = 'table table-striped' id='dynamic_table'><tbody><thead><tr><th>Sizes</th><th class='none'>Sewing Out Quantity</th><th>Total Quantity</th><th>Previous send quantity</th><th>To Be send</th><th>Sending Qty</th></tr></thead><tbody>";
								$("#dynamic_table1").append(markup);
								for(var i=0;i<data.length;i++)
								{
									if(data[i]['to_be_send'] != 'undefined')
									{
										var text_box_value = data[i]['to_be_send'];
									}
									else
									{
										var text_box_value = 0;
									}
									if(data[i]['received_qty'] == data[i]['pre_send_qty'])
									{
										var readonly = 'readonly';
									}
									
									else
									{
										readonly = 0;
									}
									if(data[i]['pre_send_qty'] == 'undefined')
									{
										var pre_sending_qty = 0;
									}
									else
									{
										var pre_sending_qty = data[i]['pre_send_qty'];
									}
									if(data[i]['received_qty'] != 0)
									{
										var class_visable = 'none1';
									}
									else
									{
										var class_visable='none';
									}
									var markup1 = "<tr class='"+class_visable+"'><td class='none'><input type='hidden' name='size["+i+"]' id='size["+i+"]' value='"+data[i]['size_title']+"'></td><td>"+data[i]['size_title']+"</td><td class='none'><input type='hidden' name='qty["+i+"]' id='qty["+i+"]' value='"+data[i]['received_qty']+"'></td><td class='none'>"+data[i]['received_qty']+"</td><td>"+data[i]['received_qty']+"</td><td class='none'><input type='hidden' name='pre_qty["+i+"]' id='pre_qty["+i+"]' value='"+pre_sending_qty+"'></td><td>"+pre_sending_qty+"</td><td>"+text_box_value+"</td><td><center><input class='form-control input-sm' id='"+i+"oper_seq2' name = 'oper_seq2["+i+"]' value='"+0+"' type='Number' style='width: 23%;' onchange='myfunction("+text_box_value+","+i+")' "+readonly+"></center></td></tr>";
									$("#dynamic_table").append(markup1);
									$('#saving_tbl').show();
									
								}
								
							}
							else
							{
								var markupus = "<h1 style='color:red;'>Sorry!!! No data Found<h1>";
								$("#dynamic_table1").append(markupus);
							}
						}
				});
		}
	});
	$('#operation').change(function()
	{
		$("#dynamic_table1").html(" ");
		$('#saving_tbl').hide();
	});
	$('#cut_no').change(function()
	{
		$("#dynamic_table1").html(" ");
		$('#saving_tbl').hide();
	});
	
});

</script>

<style>	
.table
{
	text-align:center;
}
.none
{
	display:none;
}
</style>
<script>
function myfunction(btn,id)
{
		seq = id+"oper_seq2";
		var present_value = document.getElementById(seq).value;
		if(Number(btn) < Number(present_value))
		{
			alert("You Sending Exceeded Quantity.");
			document.getElementById(seq).value = 0;
		}
		
}
function searchfunction()
{
	var input, filter, table, tr, td, i;
	input = document.getElementById("sizes");
	filter = input.value.toUpperCase();
	//alert(filter);
	table = document.getElementById("dynamic_table1");
	tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>
		
		
		