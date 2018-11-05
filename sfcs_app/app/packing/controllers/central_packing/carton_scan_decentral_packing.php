<!DOCTYPE html>
<html>
<head>
	<title>Carton Scanning</title>
	<?php
		include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
		include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions.php");
		$emp_id = $_GET['emp_id'];
		$team_id = $_GET['team_id'];
	?>
	<link rel="stylesheet" type="text/css" href="../../common/css/bootstrap.css">
	<script src="../../common/js/jquery.min.js"></script>
	<script src="../../common/js/sweetalert.min.js"></script>
	<script>
		function focus_box()
		{
			document.getElementById("carton_id").focus();
		}

		function AcceptOnlyNumbers(event) 
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
<body onload="focus_box()">
	<div class="container-fluid">
		<div class="panel panel-primary">
			<div class="panel-heading">Carton Scanning - Decentralized Packing </div>
			<div class="panel-body">
				<input type="hidden" name="emp_id" id="emp_id" value="<?php echo $emp_id; ?>">
				<input type="hidden" name="team_id" id="team_id" value="<?php echo $team_id; ?>">
				<div class="form-inline col-sm-5">
					<label><font size="5">Carton ID: </font></label>
					<input type="text" name="carton_id" class="form-control" id="carton_id" onkeypress="return AcceptOnlyNumbers(event);" placeholder="Enter Carton ID here">
					<br><br>
					<label><font size="3">(OR)</font></label>
					<br><br>
					<label><font size="5">Manual Entry: </font></label>
					<input type="text" name="manual_carton_id" class="form-control" onkeypress="return AcceptOnlyNumbers(event);" id="manual_carton_id" placeholder="Manual Entry">
					<input type="button" name="submit_btn" id="submit_btn" class="btn btn-success" value="Submit">
				</div>
				<div id="display_result" name='display_result' class="col-sm-7">
					<table class="table table-bordered">
						<tr>
							<th>Style</th><td id="style"></td>
							<th>Sizes</th><td id="original_size"></td>
						</tr>
						<tr>
							<th>Schedule</th><td id="schedule"></td>
							<th>Carton Qty</th><td id="carton_act_qty"></td>
						</tr>
						<tr>
							<th>Colors</th><td id="color"></td>
							<th>Carton No</th><td id="carton_no"></td>
						</tr>
						<tr>
							<th>Status</th><td id="status" colspan="3"></td>
						</tr>
					</table>
				</div>
				<div class="alert alert-danger col-sm-4" id="error_msg" name='error_msg'>
					<strong>Error!</strong> <br><span id="error"></span>
				</div>
				<div id="loading_img" name='loading_img' class="col-sm-7 pull right">
					<img src="../../common/images/pleasewait.gif" alt="Please Wait...">
				</div>
			</div>
		</div>
	</div>
		
</body>
<script type="text/javascript">
	$(document).ready(function() 
	{
		$("#display_result").hide();
		$("#error_msg").hide();
		$("#loading_img").hide();

		$("#carton_id").change(function()
		{
			var carton_id = $('#carton_id').val();
			callajax(carton_id,'carton_id');
		});
		

		$("#submit_btn").click(function()
		{
			var manual_carton_id = $('#manual_carton_id').val();
			callajax(manual_carton_id,'manual_carton_id');
		});

		function callajax(carton_id,id)
		{
			$("#display_result").hide();
			var emp_id = $("#emp_id").val();
			var team_id = $("#team_id").val();
			if (carton_id != '')
			{
				$("#loading_img").show();
				var function_text = "carton_scan_ajax.php";
				$.ajax({
					url: function_text,
					dataType: "json", 
					type: "GET",
					data: {carton_id:carton_id,emp_id:emp_id,team_id:team_id},    
					cache: false,
					success: function (response) 
					{
						// status: 0-invaild carton no; 1-already scanned; 2-newly scanned; 3-scanning failed
						console.log(response);
						if(response['status']==1)
						{ 
							$("#loading_img").hide();
							$("#display_result").show();
							$("#error_msg").hide();
							document.getElementById('carton_no').innerHTML = response['carton_no'];
							document.getElementById('style').innerHTML = response['style'];
							document.getElementById('schedule').innerHTML = response['schedule'];
							document.getElementById('color').innerHTML = response['color'];
							document.getElementById('carton_act_qty').innerHTML = response['carton_act_qty'];
							document.getElementById('original_size').innerHTML = response['original_size'];
							document.getElementById('status').innerHTML = "<center style='color: #ffffff; font-weight: bold;'> Carton Already Scanned</center>";
							$('#status').css("background-color", "limegreen");
							$('#'+id).val('');
							$('#carton_id').focus();
						}
						else if(response['status']==0 || response['status']==3)
						{
							$("#loading_img").hide();
							if (response['status']==0)
							{
								var msg = "Enter a Valid Carton Number";
							}
							else if (response['status']==3)
							{
								var msg = "Scanning Failed";
							}
							
							$("#error_msg").show();
							document.getElementById('error').innerHTML = msg;
							$('#'+id).val('');
							$('#carton_id').focus();
							$("#display_result").hide();
						}
						else if(response['status']==2)
						{
							$("#loading_img").hide();
							$("#error_msg").hide();
							$("#display_result").show();
							document.getElementById('carton_no').innerHTML = response['carton_no'];
							document.getElementById('style').innerHTML = response['style'];
							document.getElementById('schedule').innerHTML = response['schedule'];
							document.getElementById('color').innerHTML = response['color'];
							document.getElementById('carton_act_qty').innerHTML = response['carton_act_qty'];
							document.getElementById('original_size').innerHTML = response['original_size'];
							document.getElementById('status').innerHTML = "<center style='color: #ffffff; font-weight: bold;'>Carton Scanned Succesfully</center>";
							$('#status').css("background-color", "limegreen");						
							$('#'+id).val('');
							$('#carton_id').focus();
						}
					}
				});
			}
		}
		
	});
</script>
</html>