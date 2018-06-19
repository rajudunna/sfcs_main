<?php
// include("dbconf.php");
	include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
// error_reporting (0);

$url = getFullURL($_GET['r'],'pre_input_job_scanning.php','N');
$operation_code = $_POST['operation_id'];
// echo $operation_code;
$form = 'G';
if($operation_code >=130 && $operation_code < 300)
{
	$form = 'P';
}
$qery_rejection_resons = "select * from $bai_pro3.bai_qms_rejection_reason where form_type = '$form'";
//echo $qery_rejection_resons;
$result_rejections = $link->query($qery_rejection_resons);
if(isset($_POST['flag_validation']))
{
	//echo "<script>document.getElementById('main').hidden = true</script>";
	echo "<h1 style='color:red;'>Please Wait a while !!!</h1>";
	//echo "<script>document.getElementById('message').innerHTML='<b>Please wait a while</b>'</script>";
}
?>
<script type="text/javascript">
	function validateQty(event) 
	{
		event = (event) ? event : window.event;
		var charCode = (event.which) ? event.which : event.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}
</script>
<body>
	<form action="index.php?r=<?php echo $_GET['r']?>" method="post" id="storingfomr">
		<input type="hidden" name="operation_name" id="op_name" value="<?php echo $_POST['operation_name'];?>">
		<input type="hidden" name="shift" id="shift" value="<?php echo $_POST['shift'];?>">
		<input type="hidden" name="operation_id" id='operation_id' value="<?php echo $_POST['operation_id'];?>">
		<input type="hidden" name="next_form" id='next_form'>
	</form>

	
	</form>
	<button onclick="location.href = '<?php echo $url;?>&shift=<?php echo $_POST['shift'];?>&schedule=<?php echo $_POST['schedule'];?>&color=<?php echo $_POST['color'];?>&style=<?php echo $_POST['style'];?>&module=<?php echo $_POST['module'];?>'; return false;" class="btn btn-primary">Click here to go Back</button>

	<div class="panel panel-primary"> 
		<div class="panel-heading">Scan Input Jobs</div>
		<div class='panel-body'>
			<div class="alert alert-success" style="display:none;">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<strong>Info! </strong><span class="sql_message"></span>
			</div>
			<center style='color:red;'><h3>Operation You Are Scanning Is &nbsp;<span style='color:green;'><?php echo $_POST['operation_name'];?></span>&nbsp; On The Shift &nbsp;&nbsp;<span style='color:green;'><?php echo $_POST['shift'];?> <span style='color:red;'></h3></center>
			<div class='row'>
			<div class="form-group col-md-3">
			</div>
				<div class="form-group col-md-3">
					<label>Input Job Number:<span style="color:red"></span></label>
					<input type="text"  id="job_number" class="form-control integer" required placeholder="Scan the Job..."/>
				</div>
				<div class = "form-group col-md-3" id='module_div' hidden='true'>
					<label>Assigning To Module</label><br>
					<h3><label class='label label-info label-xs' id='module_show'></span><h3>
				</div>
				<div class="form-group col-md-3">
			</div>
			</div>
			<div class='row'>
				<input type='text' id='changed_rej' name='changed_rej' hidden='true'>
				<input type='text' id='changed_rej_id' name='changed_rej_id' hidden='true'>
				<table class="table table-bordered">
					<tr>
						<td>Style</td>
						<td id='style_show'></td>
					</tr>
					<tr>
						<td>Schedule</td>
						<td id='schedule_show'></td>
					</tr>
					<tr>
						<td>Mapped Color</td>
						<td id='color_show'></td>
					</tr>
				</table>
			</div>
		
		<div class='panel panel-primary'>
			<div class='panel-heading'>Job Data</div>
				<div class="ajax-loader" id="loading-image" style="margin-left: 486px;margin-top: 35px;border-radius: -80px;width: 88px;">
					<img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
				</div>
			<form action="index.php?r=<?php echo $_GET['r']?>" name= "smartform" method="post" id="smartform">
			
				<div class='panel-body'>
						<input type="hidden" name="style" id="style">
						<input type="hidden" name="schedule" id="schedule">
						<input type="hidden" name="color" id="mapped_color">
						<input type="hidden" name="job_number" id="hid_job">
						<input type="hidden" name="module" id="module">
						<input type="hidden" name="operation_name" id="op_name" value="<?php echo $_POST['operation_name'];?>">
						<input type="hidden" name="shift" id="shift" value="<?php echo $_POST['shift'];?>">
						<input type="hidden" name="operation_id" id='operation_id' value="<?php echo $_POST['operation_id'];?>">
						<input type="hidden" name="flag_validation" id='flag_validation'>
						<input type="hidden" name="response_flag" id='response_flag'>
						
						<div id ="dynamic_table1">
						</div>
				</div>
			</form>
			</div>
		</div>
		
		</div>
	</div>
	<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				  <!-- Modal content-->
				    <div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close"  id = "cancel" data-dismiss="modal" onclick='neglecting_function()'>&times;</button>
						<div class="form-group" id="rej">
						<input type="hidden" value="" id="reject_reasons_count">
                        	<div class="panel panel-primary"> 
				            	<div class="panel-heading"><strong>Rejection Reasons</strong></div>				            	
				                <div class="panel-body">
						           	<div class="form-group col-md-4" id="res">
			                            <label>No of Reasons:</label>
					                	<input type="text" onkeypress="return validateQty(event);" name="no_reason" min=0 id="reason" class="form-control"  onchange="validating_with_qty()" placeholder="Enter no of reasons"/>
					                </div>
		                            <table class="table table-bordered" id='reson_dynamic_table' width="100" style="height: 50px; overflow-y: scroll;">
		                            	<thead>
		                            		<tr>
		                            			<th style="width: 7%;">S.No</th>	                            			
		                            			<th>Reason</th>
		                            			<th style="width: 20%;">Quantity</th>
		                            		</tr>
		                            	</thead>
		                            	<tbody id="tablebody">
										</tbody>
											<tr id='repeat_tr' hidden='true'>
												<td>
												<select id="reason_drop" class="form-control" id="style" name="reason[]">
													<option value=''>Select Reason</option>
													<?php				    	
														if ($result_rejections->num_rows > 0) {
															while($row = $result_rejections->fetch_assoc()) {
																echo "<option value='".$row['m3_reason_code']."'>".$row['reason_desc']."</option>";
															}
														} else {
															echo "<option value=''>No Data Found..</option>";
														}
													?>
												</select>
												</td>
												<td><input class='form-control input-sm  integer' id='quantity'  name='quantity[]' onkeypress="return validateQty(event);" onchange='validating_cumulative()'></td>
											</tr>
		                            </table>
		                        </div>
								 <div class="panel-footer" hidden='true' id='footer'>
									<input type = 'button' id="rejec_reasons" class='btn btn-primary' value='Save' name='Save'>
								 </div>
                            </div>
                        </div>
						</div>
						<div class="modal-body">
						</div>
					</div>
			</div>
	</div>
	
</body>
<script>
$(document).ready(function() 
{
	//$('#rejec_reasons').select2();
	// $('#reason_drop').select2();
	
	$('#job_number').focus();
	$('#loading-image').hide();
	$("#job_number").change(function()
	{
		$('#loading-image').show();
		var function_text = "<?php echo getFullURL($_GET['r'],'functions_scanning_ij.php','R'); ?>";
		var job_number = $('#job_number').val();
		var operation_id = $('#operation_id').val();
		console.log(operation_id);
		var array = [job_number,operation_id];
	$.ajax({
			type: "POST",
			url: function_text+"?job_number="+array,
			dataType: "json",
			success: function (response) 
			{	
			
				
				
				s_no = 0;
				var data = response['table_data'];
				var flag = response['flag'];
				
				console.log(response['status']);
				if(response['status'])
				{
					sweetAlert('',response['status'],'error');
					$('#dynamic_table1').html('No Data Found');
				}
				// else if(response['module'] == undefined)
				// {
				// 	sweetAlert('',"Please Assign Module to this Input Job",'error');
				// 	$('#dynamic_table1').html('Please Assign Module to this Input Job');
				// }
				else if(data)
				{
					console.log(data);
					$('#dynamic_table1').html('');
					$('#module_div').show();
					document.getElementById('module_show').innerHTML = response['module'];
					document.getElementById('module').value = response['module'];
					console.log(response['color_dis']);
					document.getElementById('style_show').innerHTML = response['style'];
					document.getElementById('style').value = response['style'];
					document.getElementById('schedule_show').innerHTML = response['schedule'];
					document.getElementById('schedule').value = response['schedule'];
					document.getElementById('color_show').innerHTML = response['color_dis'];
					document.getElementById('mapped_color').value = response['color_dis'];
					// var form = '<form action="<?php echo $_GET['r']?>" method="post">';
					// $("#dynamic_table1").append(form);
					var btn = '<div class="pull-right"><input type="submit" class="btn btn-primary submission" value="Submit" name="formSubmit" id="smartbtn" onclick="return check_pack();"><input type="hidden" id="count_of_data" value='+data.length+'></div>';
					$("#dynamic_table1").append(btn);
					var markup = "<table class = 'table table-bordered' id='dynamic_table'><tbody><thead><tr><th>S.No</th><th>Status</th><th class='none'>Doc.No</th><th>Color</th><th>Size</th><th>Input Job Qty</th><th>Cumulative Reported Quantity</th><th>Eligibility To Report</th><th>Reporting Quantity</th><th>Remarks</th><th>Rejected Qty.</th><th>Rejection quantity</th></tr></thead><tbody>";
					var flagelem = "<input type='hidden' name='flag' id='flag' value='"+flag+"'>";
					$("#dynamic_table1").append(markup);
					$("#dynamic_table1").append(btn);
					$("#dynamic_table1").append(flagelem);
					
					// var endform = '</form>';
					for(var i=0;i<data.length;i++)
					{
						var readonly ='';
						var temp_var_bal = 0;
						if(data[i].balance_to_report == 0)
						{
							readonly = "readonly";
							status = '<font color="red">Already Scanned</font>';
							//$('#sampling').hide();
						}
						else if(data[i].reported_qty > 0)
						{
							status = '<font color="green">Partially Scanned</font>';
						}
						else
						{
							status = '<font color="green">Scanning Pending</font>';
						}
						var sampling_drop = "<select class='form-control sampling' name='sampling[]' id='"+i+"sampling' style='width:100%;' required onchange='validate_reporting("+i+")'><option value='Normal' selected>Normal</option><option value='Sample'>Sample</option><option value='Shipment_Sample'>Shipment_Sample</option></select>";
						var sampling = sampling_drop;
						if(data[i].flag == 'packing_summary_input')
						{
							temp_var_bal = data[i].balance_to_report;
							$('#flag_validation').val(1);
						}
						// var markup1 = "<tr><td>"+s_no+"</td><td class='none'>"+data[i].doc_no+"</td><td>"+data[i].order_col_des+"</td><td>"+data[i].size_code+"</td><td>"+data[i].carton_act_qty+"</td><td>0</td><td><input class='form-control input-md' id='"+i+"reporting' name='reporting_qty[]' onchange = 'validate_reporting("+i+") '></td><td><input class='form-control input-md' id='"+i+"rejections' name='rejection_qty[]' onchange = 'rejections_capture("+i+")'></td><td id='"+i+"balance'>"+data[i].balance_to_report+"</td><td class='hide'><input type='hidden' name='qty_data["+data[i].tid+"]' id='"+i+"qty_data'></td><td class='hide'><input type='hidden' name='reason_data["+data[i].tid+"]' id='"+i+"reason_data'></td><td class='hide'><input type='hidden' name='tot_reasons[]' id='"+i+"tot_reasons'></td><td class='hide'><input type='hidden' name='doc_no[]' id='"+i+"doc_no' value='"+data[i].doc_no+"'></td><td class='hide'><input type='hidden' name='colors[]' id='"+i+"colors' value='"+data[i].order_col_des+"'></td><td class='hide'><input type='hidden' name='sizes[]' id='"+i+"sizes' value='"+data[i].size_code+"'></td><td class='hide'><input type='hidden' name='job_qty[]' id='"+i+"job_qty' value='"+data[i].carton_act_qty+"'></td><td class='hide'><input type='hidden' name='tid[]' id='"+i+"tid' value='"+data[i].tid+"'></td><input type='hidden' name='inp_job_ref[]' id='"+i+"inp_job_no' value='"+data[i].input_job_no+"'></td><input type='hidden' name='a_cut_no[]' id='"+i+"a_cut_no' value='"+data[i].acutno+"'></td></tr>";
						s_no++;
						var markup1 = "<tr><td>"+s_no+"</td><td>"+status+"</td><td class='none'>"+data[i].doc_no+"</td><td>"+data[i].order_col_des+"</td><td>"+data[i].size_code.toUpperCase()+"</td><td>"+data[i].carton_act_qty+"</td><input type='hidden' name='old_size[]' value = '"+data[i].old_size+"'><td>"+data[i].reported_qty+"</td><td id='"+i+"remarks_validate_html'>"+temp_var_bal+"</td><td><input type='text' onkeypress='return validateQty(event);' class='form-control input-md twotextboxes' id='"+i+"reporting' value='0' required name='reporting_qty[]' onchange = 'validate_reporting_report("+i+") '"+readonly+"></td><td>"+sampling+"</td><td>"+data[i].rejected_qty+"</td><td><input type='text' onkeypress='return validateQty(event);' required value='0' class='form-control input-md twotextboxes' id='"+i+"rejections' name='rejection_qty[]' onchange = 'rejections_capture("+i+")' "+readonly+"></td><td class='hide'><input type='hidden' name='qty_data["+data[i].tid+"]' id='"+i+"qty_data'></td><td class='hide'><input type='hidden' name='reason_data["+data[i].tid+"]' id='"+i+"reason_data'></td><td class='hide'><input type='hidden' name='tot_reasons[]' id='"+i+"tot_reasons'></td><td class='hide'><input type='hidden' name='doc_no[]' id='"+i+"doc_no' value='"+data[i].doc_no+"'></td><td class='hide'><input type='hidden' name='colors[]' id='"+i+"colors' value='"+data[i].order_col_des+"'></td><td class='hide'><input type='hidden' name='sizes[]' id='"+i+"sizes' value='"+data[i].size_code+"'></td><td class='hide'><input type='hidden' name='job_qty[]' id='"+i+"job_qty' value='"+data[i].carton_act_qty+"'></td><td class='hide'><input type='hidden' name='tid[]' id='"+i+"tid' value='"+data[i].tid+"'></td><td class='hide'><input type='hidden' name='inp_job_ref[]' id='"+i+"inp_job_no' value='"+data[i].input_job_no+"'></td><td class='hide'><input type='hidden' name='a_cut_no[]' id='"+i+"a_cut_no' value='"+data[i].acutno+"'></td><td class='hide'><input type='hidden' name='old_rep_qty[]' id='"+i+"old_rep_qty' value='"+data[i].reported_qty+"'></td><td class='hide'><input type='hidden' name='old_rej_qty[]' id='"+i+"old_rej_qty' value='"+data[i].rejected_qty+"'></td></tr>";
						$("#dynamic_table").append(markup1);
						$("#dynamic_table").hide();
						if(data[i].flag != 'packing_summary_input')
						{
							remarks = 'Normal';
							val=i;
							$('#loading-image').show();
							validating_remarks_qty(val,remarks);
						}
					}
					$("#dynamic_table").show();
					$('#hid_job').val(job_number);
				}
				$('#loading-image').hide();
			}			    
		});
		
	});
		
	
});
function rejections_capture(val)
{
	$('#job_number').focus();
	$("#tablebody").html('');
	var rej = val+"rejections";
	// var balance =  val+"remarks_validate_html";
	// var reporting = val+"reporting";
	// var reporting = document.getElementById(reporting).value;
	// if(reporting == null)
	// {
		// reporting = 0;
	// }
	// var max = document.getElementById(balance).innerHTML;
	// console.log(max);
	var tot_rejections = document.getElementById(rej).value;
	var flag_validation = document.getElementById('flag_validation').value;
	var rej = val+"rejections";
	var balance =  val+"balance";
	var reporting_id = val+"reporting";
	var balance = val+'remarks_validate_html';
	var max = document.getElementById(balance).innerHTML;
	var reporting = document.getElementById(reporting_id).value;
	console.log(max);
	var tot_rejections = document.getElementById(rej).value;
	if(Number(max) < Number(tot_rejections)+Number(reporting))
	{
		sweetAlert('','You are rejecting more than balance to report quantity.','error');
		document.getElementById(rej).value = 0;
	}
    else
	{
		if(Number(tot_rejections) != 0)
		{
			document.getElementById('changed_rej').value=tot_rejections;
			document.getElementById('changed_rej_id').value=val;
			$('#reject_reasons_count').val(tot_rejections);
			$('#myModal').modal('toggle');
			document.getElementById('reason').value=0;
		}
	}		
}
$("#reason").change(function(){
	var tot = $('#changed_rej').val();
	var result = $('#reason').val();
	console.log(tot);
	console.log(result);
	if(result > tot)
	{
		sweetAlert("","No. Of reasons should not greater than rejection quantity","error");
		$('#reason').val(0);
	}
	else
	{
		$("#tablebody").html('');
		var res = $("#reason").val();
		for(var i=1;i<=res;i++)
		{
			html_markup = "<tr><td>"+i+"</td>"+$('#repeat_tr').html()+"</tr>";
			console.log(html_markup);
			$("#tablebody").append(html_markup);
		}
	}
	
});
function validating_cumulative()
{
	var result = 0;
	$('input[name="quantity[]"]').each(function(){
		result += Number($(this).val());
	});
	var  tot = $('#changed_rej').val();
	if(Number(tot) == Number(result))
	{
		$('#footer').show();
	}
	else
	{
		// sweetAlert('','Please Check Rejection Quantity','error');
		$('#footer').hide();
	}
}

function validating_remarks_qty(val,remarks)
{
	var function_text = "<?php echo getFullURL($_GET['r'],'functions_scanning_ij.php','R'); ?>";
	var bundle_number_var = val+"tid";
	var bundle_number = document.getElementById(bundle_number_var).value;
	console.log(bundle_number);
	var operation_id = document.getElementById('operation_id').value;
	var input_job_number = $('#job_number').val();
	var array_remarks_params = [input_job_number,bundle_number,operation_id,remarks,val];
	var flag = $('#flag_validation').val();
	if(flag != 1)
	{
		console.log(array_remarks_params);
		var count = 0;
		$('#loading-image').show();
		$.ajax({
		type: "POST",
		url: function_text+"?validating_remarks="+array_remarks_params,
		success: function(response) 
		{
			var array = response.split(',');
			max = array[0];
			var html_id = val+"remarks_validate_html";
			$('#'+html_id).html(array[0]);
			$('#response_flag').val(1);
			maximum_validate(max,val)
			$('#loading-image').hide();
		}
		});
	}
}	
function validate_reporting(val)
{
	console.log("working");
	var flag_validation = document.getElementById('flag_validation').value;
	var rej = val+"rejections";
	var balance =  val+"balance";
	var reporting_id = val+"reporting";
	var remarks = $('#'+val+'sampling option:selected').text();
	var balance = val+'remarks_validate_html';
	validating_remarks_qty(val,remarks);
	
}
function maximum_validate(max,val)
{
	var reporting_id = val+"reporting";
	var rej = val+"rejections";
	var reporting = document.getElementById(reporting_id).value;
	var tot_rejections = document.getElementById(rej).value;
	if(Number(max) < Number(tot_rejections)+Number(reporting))
	{
		sweetAlert('','You are Reporting more than balance to report quantity.','error');
		$('#'+reporting_id).val(0);
	}
	
	
}
function validate_reporting_report(val)
{
	var reporting_id = val+"reporting";
	var rej = val+"rejections";
	var reporting = document.getElementById(reporting_id).value;
	var tot_rejections = document.getElementById(rej).value;
	var max_var = val+"remarks_validate_html";
	var max = document.getElementById(max_var).innerHTML;
	if(Number(max) < Number(tot_rejections)+Number(reporting))
	{
		sweetAlert('','You are Reporting more than balance to report quantity.','error');
		$('#'+reporting_id).val(0);
	}
}
//function validate_reporting(val)
//{
			// var remarks_var = val+"sampling";
			// var bundle_number_var = val+"tid";
			// var function_text = "<?php echo getFullURL($_GET['r'],'functions_scanning_ij.php','R'); ?>";
			//var remarks_var = '#'+"";
			// var bundle_number = document.getElementById(bundle_number_var).value;
			// console.log(bundle_number);
			// var operation_id = document.getElementById('operation_id').value;
			// var remarks = $('#'+val+'sampling option:selected').text();
			// var input_job_number = $('#job_number').val();
			// var array_remarks_params = [input_job_number,bundle_number,operation_id,remarks];
			// console.log(array_remarks_params);
			// $.ajax({
			// type: "POST",
			// url: function_text+"?validating_remarks="+array_remarks_params,
			// dataType: "json",
			// success: function (response) 
			// {
				
			// }
			// });
	
//}
function neglecting_function()
{
	var val = document.getElementById('changed_rej_id').value;

	var rej = val+"rejections";
	
	document.getElementById(rej).value=0;
}
$('#rejec_reasons').on('click', function(){
	var qty_data = [];
	var reason_data = [];
	var id = $('#changed_rej_id').val();
	
	$('input[name="quantity[]"]').each(function(key, value){
		console.log($(this).val());
		if($(this).val() != '') {
			qty_data.push($(this).val());
		}
	});
	$('select[name="reason[]"]').each(function(key, value){
		if($(this).val() != '') {
			reason_data.push($(this).val());
		}
	});
	console.log($('input[name="no_reason"]').val());
	console.log(qty_data);
	console.log(reason_data);
	console.log($('#reason').val());
	if(qty_data.length == reason_data.length && $('#reason').val() > 0){
		$('#'+id+'qty_data').val(qty_data);
		$('#'+id+'reason_data').val(reason_data);
		$('#'+id+'tot_reasons').val($('input[name="no_reason"]').val());
		$('#myModal').modal('toggle');
		//$('#'+id+'rejections').prop('readonly', true);
	}else{
		sweetAlert('','Please Fill all details in form','error');
	}
	console.log($('#'+id+'qty_data').val());
	console.log($('#'+id+'reason_data').val());
	
})
// function formsubmit(){
// 	// alert();
// 	// var index = 1;
// 	// e.preventDefault();
// 	var formbool = false;
// 	$('.twotextboxes').each(function(){
// 		if($(this).val() > 0){
// 			console.log($(this).val());
// 			formbool = true;
// 			// $('#smartform').submit();
// 			return false;
// 		}else {
// 			formbool = false;
// 		}
		
// 	})
// 	console.log(formbool);
// 		if(formbool){
// 			$('#smartform').submit();
// 		} else{
// 			sweetAlert('','Please Fill details in form','error');
// 		}
// 	// $('#smartform').submit();
// }
$('input[type=submit]').click(function() {
    $(this).attr('disabled', 'disabled');
    $(this).parents('form').submit()
})

</script>	

<script>
function check_pack()
{
	var count = document.getElementById('count_of_data').value;
	// var qty = document.getElementById('pack').value;
	// var status = document.getElementById('status').value;
	var tot_qty = 0;
	var tot_rej_qty = 0;
	for(var i=0; i<count; i++)
	{
		var variable = i+"reporting";
		var qty_cnt = document.getElementById(variable).value;
		tot_qty += Number(qty_cnt);
	}
	for(var i=0; i<count; i++)
	{
		var variable_rej = i+"rejections";
		var qty_rej_cnt = document.getElementById(variable_rej).value;
		tot_rej_qty += Number(qty_rej_cnt);
	}
	if(Number(tot_qty) <= 0 && Number(tot_rej_qty) <= 0)
	{
		sweetAlert("Please enter atleast one size quantity","","warning");
		//swal('Please Enter Any size quantity','','warning');
		return false;
	}
	else
	{
		$('.submission').hide();
		return true;
	}
}
function validating()
{
	console.log("working");
	//document.getElementByClassName('submission').style.visibility = 'hidden';
	
}
</script>

<?php
// $_POST['colors'];
	if(isset($_POST['formSubmit'])){
		// echo "Hello";
		$table_name = $_POST['flag'];
		// bundle_creation_data
		$b_job_no = $_POST['job_number'];
		$b_style= $_POST['style'];
		$b_schedule=$_POST['schedule'];
		$b_colors=$_POST['colors'];
		$b_sizes = $_POST['sizes'];
		$b_size_code = $_POST['old_size'];
		$b_doc_num=$_POST['doc_no'];
		$b_in_job_qty=$_POST['job_qty'];
		$b_rep_qty=$_POST['reporting_qty'];
		$b_rej_qty=$_POST['rejection_qty'];
		$b_op_id = $_POST['operation_id'];
		$b_op_name = $_POST['operation_name'];
		$b_tid = $_POST['tid'];
		$b_inp_job_ref = $_POST['inp_job_ref'];
		$b_a_cut_no = $_POST['a_cut_no'];
		$b_module = $_POST['module'];
		$b_remarks = $_POST['sampling'];
		$b_shift = $_POST['shift'];
		$b_old_rep_qty = $_POST['old_rep_qty'];
		$b_old_rej_qty = $_POST['old_rej_qty'];
		$flag_decision = false;
		// RejectionS (bai_qms_db)
		$r_reasons=$_POST['reason_data'];
		$r_qty=$_POST['qty_data'];
		$r_no_reasons = $_POST['tot_reasons'];
		$mapped_color = $_POST['color'];
		$type = $form;
		// $select_modudle_qry = "select input_module from $bai_pro3.plan_dashboard_input where input_job_no_random_ref = $b_job_no";
		// echo $select_modudle_qry;
		// die();
		
		$remarks_var = $b_module.'-'.$b_shift.'-'.$type;
		//echo $remarks_var;
		$reason_flag = false;
		$dep_ops_array_qry = "select operation_code,ops_sequence, default_operration,smv from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$b_colors[0]' and operation_code='$b_op_id'";
		// echo $dep_ops_array_qry."<br>";
		$result_dep_ops_array_qry = $link->query($dep_ops_array_qry);
		while($row = $result_dep_ops_array_qry->fetch_assoc()) 
		{
			//$dep_ops_codes[] = $row['operation_code'];
			$sequnce = $row['ops_sequence'];
			$is_m3 = $row['default_operration'];
			$sfcs_smv = $row['smv'];
			
		}
		$ops_dep_qry = "SELECT ops_dependency,operation_code,ops_sequence FROM $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$b_colors[0]' and ops_sequence='$sequnce' AND ops_dependency != 200 AND ops_dependency != 0 group by ops_dependency";
		//echo $ops_dep_qry."<br>";
		//die();
		$result_ops_dep_qry = $link->query($ops_dep_qry);
		while($row = $result_ops_dep_qry->fetch_assoc()) 
		{
			$ops_dep = $row['ops_dependency'];
		}
		$dep_ops_array_qry_raw = "select operation_code from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$b_colors[0]' and ops_dependency='$ops_dep'";
		$result_dep_ops_array_qry_raw = $link->query($dep_ops_array_qry_raw);
		while($row = $result_dep_ops_array_qry_raw->fetch_assoc()) 
		{
			$dep_ops_codes[] = $row['operation_code'];	
		}
		$ops_seq_check = "select id,ops_sequence from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$b_colors[0]' and operation_code='$b_op_id'";
		$result_ops_seq_check = $link->query($ops_seq_check);
		while($row = $result_ops_seq_check->fetch_assoc()) 
		{
			$ops_seq = $row['ops_sequence'];
			$seq_id = $row['id'];
		}
		if($ops_dep)
		{
			$dep_ops_array_qry_seq = "select ops_dependency,operation_code,ops_sequence from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$b_colors[0]' AND ops_dependency != 200 AND ops_dependency != 0 group by ops_dependency";
			//echo $dep_ops_array_qry_seq;
			$result_dep_ops_array_qry_seq = $link->query($dep_ops_array_qry_seq);
			while($row = $result_dep_ops_array_qry_seq->fetch_assoc()) 
			{
				$ops_dep_ary[] = $row['ops_dependency'];
			}
		}
		else
		{
			$ops_dep_ary[] = null;
		}
		//var_dump($ops_dep_ary);
		if($ops_dep_ary[0] != null)
		{
			$ops_seq_qrs = "select ops_sequence from $brandix_bts.tbl_style_ops_master WHERE style='".$b_style."' AND color = '".$b_colors[0]."' AND operation_code in (".implode(',',$ops_dep_ary).")";
			//echo $ops_seq_qrs;
			$result_ops_seq_qrs = $link->query($ops_seq_qrs);
			while($row = $result_ops_seq_qrs->fetch_assoc()) 
			{
				$ops_seq_dep[] = $row['ops_sequence'];
			}
		}
		else
		{
			$ops_seq_dep[] = $ops_seq;
		}
		
		$pre_ops_check = "select operation_code,ops_sequence from $brandix_bts.tbl_style_ops_master where style='".$b_style."' and color = '".$b_colors[0]."' and (ops_sequence = ".$ops_seq." or ops_sequence in  (".implode(',',$ops_seq_dep)."))";
		//echo $pre_ops_check;
		$result_pre_ops_check = $link->query($pre_ops_check);
		if($result_pre_ops_check->num_rows > 0)
		{
			while($row = $result_pre_ops_check->fetch_assoc()) 
			{
				if($row['ops_sequence'] != 0)
				{
					$pre_ops_code[] = $row['operation_code'];
				}
			}
		}
		$post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$b_colors[0]' and ops_sequence = $ops_seq and id > $seq_id order by id limit 1";
		// echo $pre_ops_check;
		$result_post_ops_check = $link->query($post_ops_check);
		if($result_post_ops_check->num_rows > 0)
		{
			while($row = $result_post_ops_check->fetch_assoc()) 
			{
				$post_ops_code = $row['operation_code'];
			}
		}
		foreach($pre_ops_code as $index => $op_code){
			if($op_code != $b_op_id){
				$b_query[$op_code] = "INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `mapped_color`) VALUES";

				// temp table data query

				$b_query_temp[$op_code] = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`) VALUES";
			}
		}

		// (`id`,`date_time`,`cut_number`,`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`missing_qty`,`rejected_qty`,`left_over`,`operation_id`,`operation_sequence`,`ops_dependency`,`docket_number`,`bundle_status`,`split_status`,`sewing_order_status`,`is_sewing_order`,`sewing_order`,`assigned_module`,`remarks`,`scanned_date`,`shift`,`scanned_user`,`sync_status`,`shade`)


		//(`style`,`schedule`,`color`,`size_title`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`)
		$m3_bulk_bundle_insert = "INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_reason,sfcs_remarks,sfcs_log_user,m3_op_code,sfcs_job_no,sfcs_mod_no,sfcs_shift,m3_op_des,sfcs_tid_ref,m3_error_code) VALUES";

		if($table_name == 'packing_summary_input'){
			// (`qms_style`, `qms_schedule`,`qms_color`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`, `remarks`, `doc_no`, `input_job_no`)
			

			$bulk_insert = "INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`,`mapped_color`) VALUES";
			// temp table data insertion query.........
			$bulk_insert_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`) VALUES";

			// $bulk_insert_post = $bulk_insert;
			$bulk_insert_rej = "INSERT INTO $bai_pro3.bai_qms_db(`qms_style`, `qms_schedule`,`qms_color`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`,`remarks` ,`ref1`, `doc_no`,`input_job_no`,`operation_id`) VALUES";

			
			foreach ($b_tid as $key => $tid) {
				
					$smv_query = "select smv from $brandix_bts.tbl_style_ops_master where style='$b_style' and color='$b_colors[$key]' and operation_code = $b_op_id";
					$result_smv_query = $link->query($smv_query);
					while($row_ops = $result_smv_query->fetch_assoc()) 
					{
						$sfcs_smv = $row_ops['smv'];
					}
				$remarks_code = "";

				if($b_rep_qty[$key] == null){
					$b_rep_qty[$key] = 0;
				}
				if($b_rej_qty[$key] == null){
					$b_rej_qty[$key] = 0;
				}
				$left_over_qty = $b_in_job_qty[$key] - ($b_rep_qty[$key] + $b_rej_qty[$key]);
				// appending all values to query for bulk insert....

				if($r_qty[$tid] != null && $r_reasons[$tid] != null){
					$r_qty_array = explode(',',$r_qty[$tid]);
					$r_reasons_array = explode(',',$r_reasons[$tid]);

					foreach ($r_qty_array as $index => $r_qnty) {
						//m3 operations............. 
						$m3_bulk_bundle_insert .= '("'.date('Y-m-d').'","'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'. $b_size_code[$key].'","'. $b_sizes[$key].'","'.$b_doc_num[$key].'","'.$r_qty_array[$index].'","'.$r_reasons_array[$index].'","'.$b_remarks[$key].'","'.$username.'","'. $b_op_id.'","'.$b_job_no.'","'.$b_module.'","'.$b_shift.'","'.$b_op_name.'","'.$b_tid[$key].'",""),';
						$rejection_code_fetech_qry = "select reason_code from $bai_pro3.bai_qms_rejection_reason where m3_reason_code= '$r_reasons_array[$index]'";
						//echo $rejection_code_fetech_qry;
						$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
						while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
						{
							$reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
						}
						if($index == sizeof($r_qty_array)-1){
							$remarks_code .= $reason_code.'-'.$r_qnty;
						}else {
							$remarks_code .= $reason_code.'-'.$r_qnty.'$';
						}
					}
				}		
				// (`qms_style`, `qms_schedule`,`qms_color`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`, `remarks`, `doc_no`, `input_job_no`)
				$bulk_insert .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$b_remarks[$key].'","'.$mapped_color.'"),';

				// temp table data insertion query.........
				$bulk_insert_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$b_remarks[$key].'"),';


				//m3 operations............. 
				if($b_rep_qty[$key] > 0) {
					$m3_bulk_bundle_insert .= '("'.date('Y-m-d').'","'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'.$b_doc_num[$key].'","'.$b_rep_qty[$key].'","","'.$b_remarks[$key].'","'.$username.'","'. $b_op_id.'","'.$b_job_no.'","'.$b_module.'","'.$b_shift.'","'.$b_op_name.'","'.$b_tid[$key].'",""),';
					$flag_decision = true;
				}
				//$bulk_insert_post .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'. $b_sizes[$key].'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","0","0","'.$left_over_qty.'","'. $ops_post.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'")';
				$count = 1;
				foreach($pre_ops_code as $index => $op_code){
					//echo $op_code."<br>";
					//echo $b_op_id;
					if($op_code != $b_op_id)
					{
						
						$dep_check_query = "SELECT * from $brandix_bts.bundle_creation_data where bundle_number = $b_tid[$key] and operation_id = $op_code";
						//echo $dep_check_query;
						$dep_check_result = $link->query($dep_check_query) or exit('dep_check_query error');
						if(mysqli_num_rows($dep_check_result) <= 0){
						//change values here in query....
							$send_qty = $b_rep_qty[$key];
							$rec_qty = 0;
							$rej_qty = 0;
							$b_query[$op_code] .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$send_qty.'","'.$rec_qty.'","'.$rej_qty.'","'.$left_over_qty.'","'. $op_code.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$b_remarks[$key].'","'.$mapped_color.'"),';

							$b_query_temp[$op_code] .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$send_qty.'","'.$rec_qty.'","'.$rej_qty.'","'.$left_over_qty.'","'. $op_code.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'"),';
							$count++;
						}
					}
				}

				if($r_qty[$tid] != null && $r_reasons[$tid] != null){
					$bulk_insert_rej .= '("'.$b_style.'","'.$b_schedule.'","'.$b_colors[$key].'","'.date('Y-m-d').'","'.$b_sizes[$key].'","'.$b_rej_qty[$key].'","3","'.$remarks_var.'","'.$remarks_code.'","'.$b_doc_num[$key].'","'.$b_job_no.'","'. $b_op_id.'"),';
					$reason_flag = true;
				}
			} 
			//all operation codes query.. (not tested)
			foreach($b_query as $index1 => $query){
				if(substr($query, -1) == ','){
					$final_query_001 = substr($query, 0, -1);
				}else{
					$final_query_001 = $query;
				}
				//echo $final_query_001;
				$bundle_creation_result_001 = $link->query($final_query_001);
			}

			// foreach($b_query_temp as $index1 => $query_temp){
			// 	if(substr($query_temp, -1) == ','){
			// 		$final_query_002 = substr($query_temp, 0, -1);
			// 	}else{
			// 		$final_query_002 = $query_temp;
			// 	}
			// 	$bundle_creation_result_002 = $link->query($final_query_002);
			// }
			if(substr($bulk_insert, -1) == ','){
				$final_query_000 = substr($bulk_insert, 0, -1);
			}else{
				$final_query_000 = $bulk_insert;
			}
			// echo $bulk_insert.'<br>';
			$bundle_creation_result = $link->query($final_query_000);
			// temp tables data insertion query execution..........
			if(substr($bulk_insert_temp, -1) == ','){
				$final_query_000_temp = substr($bulk_insert_temp, 0, -1);
			}else{
				$final_query_000_temp = $bulk_insert_temp;
			}
			//echo $bulk_insert.'<br>';
			$bundle_creation_result_temp = $link->query($final_query_000_temp);
			//$bundle_creation_post_result = $link->query($bulk_insert_post);
			//echo $bulk_insert_rej;
			if($reason_flag){
				if(substr($bulk_insert_rej, -1) == ','){
					$final_query = substr($bulk_insert_rej, 0, -1);
				}else{
					$final_query = $bulk_insert_rej;
				}
				$rej_insert_result = $link->query($final_query) or exit('data error');
			}
			//echo $m3_bulk_bundle_insert;
			
			if(strtolower($is_m3) == 'yes' && $flag_decision){
				if(substr($m3_bulk_bundle_insert, -1) == ','){
					$final_query100 = substr($m3_bulk_bundle_insert, 0, -1);
				}else{
					$final_query100 = $m3_bulk_bundle_insert;
				}
				//echo $final_query100;
				// die();
				$rej_insert_result100 = $link->query($final_query100) or exit('data error');
			}
			$sql_message = 'Data inserted successfully';
			
		}
		else{
			$query = '';
			
			if($table_name == 'bundle_creation_data'){
				
				
				
				
				$bulk_insert_rej = "INSERT INTO $bai_pro3.bai_qms_db(`qms_style`, `qms_schedule`,`qms_color`,`log_user`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`,`remarks`, `ref1`, `doc_no`, `input_job_no`, `operation_id`) VALUES";

				$schedule_count_query = "SELECT input_job_no_random_ref FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = $b_job_no AND operation_id ='$b_op_id'";

				// echo $schedule_count_query.'<br>';
				$schedule_count_query = $link->query($schedule_count_query) or exit('query error');
				
				if($schedule_count_query->num_rows > 0)
				{
					$schedule_count = true;
				}else{
					$schedule_count = false;
				}
				foreach ($b_tid as $key => $tid) 
				{
					$smv_query = "select smv from $brandix_bts.tbl_style_ops_master where style='$b_style' and color='$b_colors[$key]' and operation_code = $b_op_id";
					$result_smv_query = $link->query($smv_query);
					while($row_ops = $result_smv_query->fetch_assoc()) 
					{
						$sfcs_smv = $row_ops['smv'];
					}
					$bulk_insert_post = "INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`) VALUES";

					$bulk_insert_post_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`) VALUES";

					$remarks_code = "";
					// echo $tid.'<br>';
					if($b_rep_qty[$key] == null){
						$b_rep_qty[$key] = 0;
					}
					if($b_rej_qty[$key] == null){
						$b_rej_qty[$key] = 0;
					}
					// $left_over_qty = $b_in_job_qty[$key] - ($b_rep_qty[$key] + $b_rej_qty[$key]);
					// appending all values to query for bulk insert....

					if($r_qty[$tid] != null && $r_reasons[$tid] != null){
						$r_qty_array = explode(',',$r_qty[$tid]);
						$r_reasons_array = explode(',',$r_reasons[$tid]);
						if(sizeof($r_qty_array)>0)
						{
							$flag_decision = true;
						}
						foreach ($r_qty_array as $index => $r_qnty) {
							//m3 operations............. 
							$m3_bulk_bundle_insert .= '("'.date('Y-m-d').'","'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'. $b_size_code[$key].'","'. $b_sizes[$key].'","'.$b_doc_num[$key].'","'.$r_qty_array[$index].'","'.$r_reasons_array[$index].'","'.$b_remarks[$key].'","'.$username.'","'. $b_op_id.'","'.$b_job_no.'","'.$b_module.'","'.$b_shift.'","'.$b_op_name.'","'.$b_tid[$key].'",""),';
							$rejection_code_fetech_qry = "select reason_code from $bai_pro3.bai_qms_rejection_reason where m3_reason_code= '$r_reasons_array[$index]'";
						//echo $rejection_code_fetech_qry;
							$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
							while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
							{
								$reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
							}
							if($index == sizeof($r_qty_array)-1){
								$remarks_code .= $reason_code.'-'.$r_qnty;
							}else {
								$remarks_code .= $reason_code.'-'.$r_qnty.'$';
							}
						}
					}	
					// if($b_rep_qty[$key] > 0 || $b_rej_qty[$key] > 0) {
						$final_rep_qty = $b_old_rep_qty[$key] + $b_rep_qty[$key];
						$final_rej_qty = $b_old_rej_qty[$key] + $b_rej_qty[$key];
						$left_over_qty = $b_in_job_qty[$key] - $final_rep_qty - $final_rej_qty;
						if($schedule_count){
							$query = "UPDATE $brandix_bts.bundle_creation_data SET `recevied_qty`= '".$final_rep_qty."', `rejected_qty`='". $final_rej_qty."', `left_over`= '".$left_over_qty."' , `scanned_date`='". date('Y-m-d')."' where bundle_number ='".$b_tid[$key]."' and operation_id = ".$b_op_id;
							
							$result_query = $link->query($query) or exit('query error in updating');
						}else{
							
							$bulk_insert_post .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'")';	
							$result_query_001 = $link->query($bulk_insert_post) or exit('bulk_insert_post query error in updating');
						}
						//m3 operations............. 
						if($b_rep_qty[$key] > 0){
							$m3_bulk_bundle_insert .= '("'.date('Y-m-d').'","'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'. $b_size_code[$key].'","'. $b_sizes[$key].'","'.$b_doc_num[$key].'","'.$b_rep_qty[$key].'","","'.$b_remarks[$key].'","'.$username.'","'. $b_op_id.'","'.$b_job_no.'","'.$b_module.'","'.$b_shift.'","'.$b_op_name.'","'.$b_tid[$key].'",""),';
							$flag_decision = true;
						}

						if($b_rep_qty[$key] > 0 || $b_rej_qty[$key] > 0){

							$bulk_insert_post_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$b_remarks[$key].'")';	

							$result_query_001_temp = $link->query($bulk_insert_post_temp) or exit('bulk_insert_post query error in updating');
						}

						if($post_ops_code != null)
						{
							$query_post = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$final_rep_qty."', `scanned_date`='". date('Y-m-d')."' where bundle_number ='".$b_tid[$key]."' and operation_id = ".$post_ops_code;
							$result_query = $link->query($query_post) or exit('query error in updating');
						}
						if($ops_dep)
						{
							$pre_send_qty_qry = "select min(recevied_qty)as recieved_qty from $brandix_bts.bundle_creation_data where bundle_number ='".$b_tid[$key]."' and operation_id in (".implode(',',$dep_ops_codes).")";
							//echo $pre_send_qty_qry;
							$result_pre_send_qty = $link->query($pre_send_qty_qry);
							while($row = $result_pre_send_qty->fetch_assoc()) 
							{
								$pre_recieved_qty = $row['recieved_qty'];
							}

							$query_post_dep = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$pre_recieved_qty."', `scanned_date`='". date('Y-m-d')."' where bundle_number ='".$b_tid[$key]."' and operation_id = ".$ops_dep;

							$result_query = $link->query($query_post_dep) or exit('query error in updating');
					
						}
						 
					// }
					if($r_qty[$tid] != null && $r_reasons[$tid] != null){
						$bulk_insert_rej .= '("'.$b_style.'","'.$b_schedule.'","'.$b_colors[$key].'","'.$username.'","'.date('Y-m-d').'","'.$b_sizes[$key].'","'.$b_rej_qty[$key].'","3","'.$remarks_var.'","'.$remarks_code.'","'.$b_doc_num[$key].'","'.$b_job_no.'","'. $b_op_id.'"),';
						$reason_flag = true;
					}
				}
				if($reason_flag){
					if(substr($bulk_insert_rej, -1) == ','){
						$final_query = substr($bulk_insert_rej, 0, -1);
					}else{
						$final_query = $bulk_insert_rej;
					}
					echo $final_query;
					$rej_insert_result = $link->query($final_query) or exit('data error');
				}
				if(strtolower($is_m3) == 'yes' && $flag_decision){
					if(substr($m3_bulk_bundle_insert, -1) == ','){
						$final_query100 = substr($m3_bulk_bundle_insert, 0, -1);
					}else{
						$final_query100 = $m3_bulk_bundle_insert;
					}
					// echo $final_query100;;
					$rej_insert_result100 = $link->query($final_query100) or exit('data error');
				}
				// }
				// $sql_message = 'Data Updated Successfully';
			}
		}
		//echo "<script>$('#storingfomr').submit()</script>";
	}
?>
	
