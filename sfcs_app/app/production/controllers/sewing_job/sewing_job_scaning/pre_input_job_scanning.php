<!--- Developed by Srinivas Y -->
<body>
<?php
// include("dbconf.php");
	include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
	$has_permission=haspermission($_GET['r']);
// error_reporting (0);

$url = getFullURL($_GET['r'],'scan_input_jobs.php','N');
//echo $url;

	$sec_query = "SELECT sec_mods FROM bai_pro3.sections_db WHERE sec_id > 0";
	
	$result_sec = $link->query($sec_query)or exit('Error in section');
	$all_modules = $result_sec->fetch_all();
	$exp_module = [];
	foreach ($all_modules as $key => $value) {
		$exp_module[$key] = explode(',', $value[0]);
	}
	foreach ($exp_module as $key => $module) {
		foreach ($module as $key => $mod) {
			$final[] = $mod;
		}
	}
	//var_dump($final);
?>
<form method ='POST' action='<?php echo $url ?>'>
	<div class="panel panel-primary">
		<div class="panel-heading"><strong>Input Job Scanning</strong></div>
		<div class="panel-body">
			<div class="row">
				<div class="form-group col-md-2">
					 <label>Schedule:<span style="color:red">*</span> </label>
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
						
						<?php if(isset($_GET['style']))
						{
							$style = $_GET['style'];
						}else{$style='';}?>
						
						<input class="form-control" id="style" type="text" name='style' value='<?php echo $style; ?>' readonly>
				</div>	
				<div class="form-group col-md-2">
					<label for="title">Select Operation:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
						<select class="form-control select2"  name="operation" id="operation" required>
							<option value="">Select Operation</option>
						</select>
				</div>
				<input type='hidden' id='operation_name' name='operation_name' required>
				<input type='hidden' id='operation_id' name='operation_id' required>				
				<div class="form-group col-md-2">
                        	<label>Shift:<span style="color:red">*</span></label>
                        	<select class="form-control shift"  name="shift" id="shift" style="width:100%;" required>
                        		<option value="">Select Shift</option>
								<!-- <?php
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
								?> -->
								<?php 
									for ($i=0; $i < sizeof($shifts_array); $i++) {?>
										<option  <?php echo 'value="'.$shifts_array[$i].'"'; if($_GET['shift']==$shifts_array[$i]){ echo "selected";}   ?>><?php echo $shifts_array[$i] ?></option>
									<?php }
								?>
                        	</select>
				</div>
				<!--
				<div class="form-group col-md-2">
                        	<label>Module:<span style="color:red">*</span></label>
                        	<select class="form-control shift"  name="module" id="module" style="width:100%;" required>
                        		<option value="">Select Module</option>
								// <?php
									// foreach ($final as $key => $module) {
										// if($_GET['module'] == $module)
										// {
											// echo '<option value="'.$module.'" selected>'.$module.'</option>';
										// }else{
											// echo '<option value="'.$module.'" >'.$module.'</option>';
										// }
									// }
								// ?>
                        	</select>
				</div> -->
				<div class='col-md-1' id='saving_tbl'>
					<br>
					<input type='SUBMIT' value='Continue' name='SUBMIT' class='btn btn-primary' style="margin-top: 4px;">
				</div>
			</div>
		</div>
	</div>			
</form>
<div class="ajax-loader" id="loading-image" style="margin-left: 486px;margin-top: 35px;border-radius: -80px;width: 88px;">
		<img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
	</div>
</body>
<script type="text/javascript">
$(document).ready(function(){
	$('#loading-image').show();
	
	//$('#loading-image').show();
	$('#schedule').select2();
	$('#color').select2();
	$('#operation').select2();
	$('#shift').select2();
	$('#module').select2();
	var variable = 1;
	var function_text = "<?php echo getFullURL($_GET['r'],'functions_scanning_ij.php','R'); ?>";
	$.ajax({
			type: "POST",
			url: function_text+"?variable="+variable,
			dataType: "json",
			success: function (response) {
				$('#loading-image').hide();				
				console.log(response);
					<?php if(isset($_GET['schedule'])){?>
						var schedule = <?php echo $_GET['schedule'];
					}else{?>var schedule=<?php echo 0 ;} ?>;
					
					$.each(response, function(key,value) {
						if(schedule == value)
						{
							$('select[name="schedule"]').append('<option value="'+ key +'" selected>'+value+'</option>');
							$('#loading-image').show();
							getcolor();
						}
						else
						{
							$('select[name="schedule"]').append('<option value="'+ key +'">'+value+'</option>');
						}
					});		    					
				
															  
			}				    
		});	
	
	$("#schedule").change(function()
	{
		var sc = $("#schedule").val();
		if(sc)
		{
			getcolor();
			$('#loading-image').show();
		}
		else
		{
			$('#color').empty();
			$('select[name="color"]').append('<option value="">Select Color</option>');
			$('#style').val('');
		}
		
	});
	function getcolor()
	{
		$('#color').empty();
		$('select[name="color"]').append('<option value="">Select Color</option>');
		$('#operation').empty();
		$('select[name="operation"]').append('<option value="">Select Operation</option>');
		var schedule = $('#schedule option:selected').text();
		//console.log(schedule);
		var function_text = "<?php echo getFullURL($_GET['r'],'functions_scanning_ij.php','R'); ?>";
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
						$('#loading-image').hide();
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
							$('select[name="operation"]').append('<option value="">Select Operation</option>');
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
											console.log(response);
											$.each(response, function(key, value) {
											$('select[name="operation"]').append('<option value="'+ key +'">'+ value +'</option>');
											});
										}
								});
						}
						else
						{
							<?php if(isset($_GET['color'])){?>
						var color = <?php echo "'".$_GET['color']."'";
					}else{?>var color=<?php echo 0 ;} ?>;
							$.each(data_drp, function(key, value) {
								if(color == value)
								{
										$('select[name="color"]').append('<option value="'+ key +'" selected>'+ value +'</option>');
										getops();
										$('#loading-image').show();
								}
								else
								{
									$('select[name="color"]').append('<option value="'+ key +'">'+value+'</option>');
								}
							});
						}
						
					}
			});
	}
	$("#color").change(function()
	{
		getops();
		
	});
	function getops()
	{
		$('#operation').empty();
		$('select[name="operation"]').append('<option value="">Select Operation</option>');
		var color = $('#color option:selected').text();
		var style = $('#style').val();
		var schedule = $('#schedule option:selected').text();
		var params_cut = [style,color];
		console.log(style);
		console.log(color);
		if(style != '' && color != 'Select Color')
		{
			$('#loading-image').show();
			console.log("workingops");
			var function_text = "<?php echo getFullURL($_GET['r'],'functions_scanning_ij.php','R'); ?>";
			//alert(schedule);
			$.ajax
				({
						type: "POST",
						url:function_text+"?r=getdata&color="+params_cut,
						dataType: 'Json',
						data: {schedule: $('#color').val()},
						success: function(response)
						{
							$('#loading-image').hide();
							console.log(response);
							$.each(response, function(key, value) {
							console.log(key);
							console.log(value);
							$('select[name="operation"]').append('<option value="'+ key +'">'+ value +'</option>');
							});
						}
				});
		}
		else
		{
			console.log("work");
			//$('#loading-image').hide();
		}
		
	}
	$('#operation').change(function()
	{
		var opration_text = $('#operation option:selected').text();

		$('#operation_name').val(opration_text);
		$('#operation_id').val($('#operation').val());
		
	});
	
});



</script>
