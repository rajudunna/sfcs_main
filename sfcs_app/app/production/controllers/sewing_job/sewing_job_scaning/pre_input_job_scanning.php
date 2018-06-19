<!--- Developed by Srinivas Y -->
<body>
<?php
// include("dbconf.php");
	include(getFullURLLevel($_GET['r'],'common/config/config_ajax.php',5,'R'));
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
	$('#operation').select2();
	$('#shift').select2();
	var variable = 1;
	var function_text = "<?php echo getFullURL($_GET['r'],'functions_scanning_ij.php','R'); ?>";
	$.ajax({
			type: "POST",
			url: function_text+"?variable="+variable,
			dataType: "json",
			success: function (response) {
				$('#loading-image').hide();				
				console.log(response);
					$.each(response, function(key,value) {
						
							$('select[name="operation"]').append('<option value="'+ key +'">'+value+'</option>');
					});		    					
				
															  
			}				    
		});

		$('#operation').change(function()
	{
		var opration_text = $('#operation option:selected').text();

		$('#operation_name').val(opration_text);
		$('#operation_id').val($('#operation').val());
		
	});
});





</script>
