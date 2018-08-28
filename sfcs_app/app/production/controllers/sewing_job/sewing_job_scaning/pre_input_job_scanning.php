<!--- Developed by Srinivas Y -->
<body>
<?php
	include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
	$has_permission=haspermission($_GET['r']);
// error_reporting (0);
if(isset($_GET['operation_id']))
	{
		$status='&sidemenu=true';
		$input_job_no_random_ref=$_GET['input_job_no_random_ref'];
		$operation_code=$_GET['operation_id'];
		$style=$_GET['style'];
		$schedule=$_GET['schedule'];
		$module=$_GET['module'];
		// $operation_name = echo_title("$brandix_bts.tbl_orders_ops_ref","operation_name","operation_code",$operation_code,$link).- $operation_code;
		// $color = echo_title("$bai_pro3.packing_summary_input","order_col_des","input_job_no_random",$input_job_no_random_ref,$link);
		$barcode_generation=$_GET['barcode_generation'];
	}		

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
$configuration_bundle_print_array = ['0'=>'Bundle Level','1'=>'Sewing Job Level'];
// if($scanning_methods == 'Bundle Level')
// $configuration_bundle_print_array = ['1'=>'Sewing Job Level'];
?>
<form method ='POST' action='<?php echo $url."$status" ?>'>
	<div class="panel panel-primary">
		<div class="panel-heading"><strong>Input Job Scanning</strong></div>
		<div class="panel-body">
			<div class="row">
				<input type='hidden' id='input_job_no_random_ref' name='input_job_no_random_ref1' value='<?php echo $input_job_no_random_ref  ?>'>
				<input type='hidden' id='operation_id' name='operation_id1' value='<?php echo $operation_code ?>'>
				<input type='hidden' id='style' name='style1' value='<?php echo $style ?>'>
				<input type='hidden' id='schedule' name='schedule1' value='<?php echo $schedule ?>'>
				<input type='hidden' id='module' name='module1' value='<?php echo $module ?>'>


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
				
				<div class='col-md-3'>
					<label>Barcode Generation:<span style="color:red">*</span></label>
                        	<select class="form-control shift"  name="barcode_generation" id="barcode_generation" style="width:100%;" required>
                        		<option value="">Select Method</option>
								<?php 
									$selected = '';
									foreach($configuration_bundle_print_array as $key=>$value)
									{
										if($scanning_methods == $value)
										{
											echo"<option value='$key' selected>$value</option>";
										}
										else
										{
											echo"<option value='$key'>$value</option>";
										}
										
									}
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
						
							$('select[name="operation"]').append('<option value="'+ key +'">'+value+' - '+key+'</option>');
					});
					$('#operation option[value=<?= $operation_code ?>]').prop('selected', true);
					$('#operation').prop('disabled', true);		    					
				
															  
			},
			error: function(response){
				$('#loading-image').hide();	
				// alert('failure');
				// console.log(response);
				swal('Error in getting schedule');
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
<style>
.hidden_class,hidden_class_for_remarks{
	display:none;
}

</style>
	
<?php
if(isset($_GET['sidemenu'])){

	echo "<style>
          .left_col,.top_nav{
          	display:none !important;
          }
          .right_col{
          	width: 100% !important;
    margin-left: 0 !important;
          }
	</style>";
}
?>
<script>
$(document).ready(function(){
	
	$('#barcode_generation option[value=<?= $barcode_generation ?>]').prop('selected', true);
	$('#barcode_generation').prop('disabled', true);
})
</script>	

