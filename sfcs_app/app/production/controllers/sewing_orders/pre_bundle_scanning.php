<!--- Developed by Srinivas Y --->
<!DOCTYPE html>
<html>
<head>
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
<link rel="stylesheet" href="cssjs/select2.min.css">
</head>
<body>
<?php
include("..".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
$url = getFullURL($_GET['r'],'scan_emb_bundles.php','N');
$has_permission=haspermission($_GET['r']);
$qry_get_product_style = "SELECT id,style FROM bundle_creation_data GROUP BY style";
//echo $qry_get_product_style;
$result = $link->query($qry_get_product_style);
?>
<form method ='GET' action='<?php echo $url ?>'>

	<div class="panel panel-primary">
		<div class="panel-heading"><strong>Bundle Scanning</strong></div>
		<div class="panel-body">
			<div class="row">
				<div class="form-group col-md-2">
					 <label>Schedule: </label>
						<select class="form-control select2" required name="schedule" id="schedule">
							<option value="">Select Schedule</option>
						</select>
				</div>
				<div class="form-group col-md-2">
					<label for="title">Select Color:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
						<select class="form-control select2" required name="color" id="color">
							<option value="">Select Color</option>
						</select>
				</div>
				<div class="form-group col-md-2">
					<label for="style">Select Style</label>		      
						<input class="form-control input-sm" id="style" type="text" name='style' readonly>
				</div>	
				<div class="form-group col-md-2">
					<label for="title">Select Operation:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
						<select class="form-control select2" required name="operation" id="operation">
							<option value="">Select Operation</option>
						</select>
				</div>
				<input type='hidden' id='operation_name' name='operation_name'>
				<div class="form-group col-md-2">
                        	<label>Shift:<span style="color:red">*</span></label>
                        	<select class="form-control shift"  name="shift" id="shift" style="width:100%;" required>
                        		<option value="">Select Shift</option>
								<?php
									$selecting_a = '';
									$selecting_b = '';
									if(isset($_GET['shift']))
									{
										if($_GET['shift'] == 'A')
										{
											$selecting_a = 'selected';
										}
										if($_GET['shift'] == 'B')
										{
											$selecting_b = 'selected';
										}
										
									}
									
									
								?>
                        		<option value="A" <?php echo $selecting_a;?>>A</option>
                        		<option value="B" <?php echo $selecting_b;?>>B</option>
                        	</select>
				</div>
				<div class='col-md-2' id='saving_tbl'>
					<br>
					<input type='SUBMIT' value='Continue' name='SUBMIT' class='btn btn-primary' style="margin-top: 4px;">
				</div>
			
</form>
<script type="text/javascript">
	

$(document).ready(function(){
	var function_text = "<?php echo getFullURL($_GET['r'],'functions_scanning.php','R'); ?>";
	$('#loading-image').hide();
	$('#schedule').select2();
	$('#color').select2();
	$('#operation').select2();
	$('#shift').select2();
	var variable = 1;
	$.ajax({
			type: "POST",
			url: function_text+"?variable="+variable,
			dataType: "json",
			success: function (response) {	
				console.log(response);
					$.each(response, function(key,value) {
						$('select[name="schedule"]').append('<option value="'+ key +'">'+value+'</option>');
					});		    					
				
															  
			}				    
		});	
	$("#schedule").change(function()
	{
		$('#color').empty();
		$('select[name="color"]').append('<option value="Select Color">Select Color</option>');
		$('#operation').empty();
		$('select[name="operation"]').append('<option value="Select Operation">Select Operation</option>');
		var schedule = $('#schedule option:selected').text();
		//alert(schedule);
		$.ajax
			({
					type: "POST",
					url:function_text+"?r=getdata&schedule="+schedule,
					dataType: 'Json',
					data: {schedule: $('#schedule').val()},
					success: function(response)
					{
						//console.log(response.drp);
						$('#style').val(response.style);
						var data_drp = response.drp;
						var count=0;
						$.each(data_drp, function(key, value) {
							count++;
						});
						if(count == 1)
						{
							$.each(data_drp, function(key, value) {
							$('select[name="color"]').append('<option value="'+ key +'" selected>'+ value +'</option>');
							});
							$('#operation').empty();
							$('select[name="operation"]').append('<option value="Select operation">Select Operation</option>');
							var color = $('#color option:selected').text();
							var style = $('#style').val();
							var schedule = $('#schedule option:selected').text();
							var params_cut = [style,color,schedule];
							//alert(schedule);
							$.ajax
								({
										type: "POST",
										url:function_text+"?r=getdata&color="+params_cut,
										dataType: 'Json',
										data: {schedule: $('#color').val()},
										success: function(response)
										{
											$.each(response, function(key, value) {
											$('select[name="operation"]').append('<option value="'+ key +'">'+ value +'</option>');
											});
										}
								});
						}
						else
						{
							$.each(data_drp, function(key, value) {
							$('select[name="color"]').append('<option value="'+ key +'">'+ value +'</option>');
							});
						}
						
					}
			});
	});
	$("#color").change(function()
	{
		$('#operation').empty();
		$('select[name="operation"]').append('<option value="Select operation">Select Operation</option>');
		var color = $('#color option:selected').text();
		var style = $('#pro_style option:selected').text();
		var schedule = $('#schedule option:selected').text();
		var params_cut = [style,color]
		//alert(schedule);
		$.ajax
			({
					type: "POST",
					url:function_text+"?r=getdata&color="+params_cut,
					dataType: 'Json',
					data: {schedule: $('#color').val()},
					success: function(response)
					{
						$.each(response, function(key, value) {
						$('select[name="operation"]').append('<option value="'+ key +'">'+ value +'</option>');
						});
					}
			});
	});
	$('#operation').change(function()
	{
		var opration_text = $('#operation option:selected').text();
		//alert(opration_text);
		$('#operation_name').val(opration_text);
	});
	
});



</script>
