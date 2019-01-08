<head>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<?php
	include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
	$has_permission=haspermission($_GET['r']);


	if (in_array($override_sewing_limitation,$has_permission))
	{
		$value = 'authorized';
	}
	else
	{
		$value = 'not_authorized';
	}
	echo '<input type="hidden" name="user_permission" id="user_permission" value="'.$value.'">';

	if ($_GET['operation_id'])
	{
		$input_job_no_random_ref=$_GET['input_job_no_random_ref'];
		$operation_code=$_GET['operation_id'];
		$style=$_GET['style'];
		$schedule=$_GET['schedule'];
		$module=$_GET['module'];
		$operation_name = echo_title("$brandix_bts.tbl_orders_ops_ref","operation_name","operation_code",$operation_code,$link).- $operation_code;
		$color = echo_title("$bai_pro3.packing_summary_input","order_col_des","input_job_no_random",$input_job_no_random_ref,$link);
		$shift=$_GET['shift'];
		// $operation_name='Sewing In - 129'; 
		$barcode_generation=1;
		$read_only_job_no = 'readonly';
	} else {
		$schedule=$_POST['schedule'];
		$color=$_POST['color'];
		$style=$_POST['style'];
		$shift=$_POST['shift'];
		$module=0;
		$operation_name=$_POST['operation_name'];
		$operation_code=$_POST['operation_id'];
		$barcode_generation=$_POST['barcode_generation'];
		$read_only_job_no = '';
	}

	$application='IPS';
	$scanning_query=" select operation_code from $brandix_bts.tbl_ims_ops where appilication='$application'";
	//echo $scanning_query;
	$scanning_result=mysqli_query($link, $scanning_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($scanning_result))
	{
		$operation_code_routing=$sql_row['operation_code'];
	}
	echo '<input type="hidden" name="operation_code_routing" id="operation_code_routing" value="'.$operation_code_routing.'">';
	echo '<input type="hidden" name="sewing_rejection" id="sewing_rejection" value="'.$sewing_rejection.'">';
	echo '<input type="hidden" name="display_reporting_qty" id="display_reporting_qty" value="'.$display_reporting_qty.'">';
	echo '<input type="hidden" name="line-in" id="line-in" value="'.$line_in.'">';




$url = getFullURL($_GET['r'],'pre_input_job_scanning.php','N');
$form = 'P';
if($operation_code >=130)
{
	$form = 'G';
}
$qery_rejection_resons = "select * from $bai_pro3.bai_qms_rejection_reason where form_type = '$form'";
$result_rejections = $link->query($qery_rejection_resons);
if(isset($_POST['flag_validation']))
{
	echo "<h1 style='color:red;'>Please Wait a while !!!</h1>";
}
$configuration_bundle_print_array = ['0'=>'Bundle Number','1'=>'Sewing Job Number'];
$label_name_to_show = $configuration_bundle_print_array[$barcode_generation];

?>
<script type="text/javascript">
	function validateQty(e,t) 
	{
		console.log(e.Keycode);
		if(e.keyCode == 13)
				return;
			var p = String.fromCharCode(e.which);
			var c = /^[0-9]+$/;
			var v = document.getElementById(t.id);
			
			if( !(v.value.match(c)) && v.value!=null ){
				v.value = '';
				return false;
			}
			return true;
	}
	function validateQty1(e,t) 
	{
		if(e.keyCode == 13)
				return;
			var p = String.fromCharCode(e.which);
			var c = /^[0-9]*\.?[0-9]*$/;
			var v = document.getElementById(t.id);
			if( !(v.value.match(c)) && v.value!=null ){
				v.value = '';
				return false;
			}
			return true;
	}
</script>
<body>
    <?php if($_POST['operation_name']) {?>
	<button onclick="location.href = '<?php echo $url;?>&shift=<?php echo $shift;?>&schedule=<?php echo $schedule;?>&color=<?php echo $color;?>&style=<?php echo $style;?>&module=<?php echo $module;?>'; return false;" class="btn btn-primary">Click here to go Back</button>
	 <?php } ?>

	<div class="panel panel-primary"> 
		<input type="hidden" name="flag_validation" id='flag_validation'>
		<div class="panel-heading">Scan <?php echo $label_name_to_show ?></div>
		<div class='panel-body'>
			<div class="alert alert-success" style="display:none;">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<strong>Info! </strong><span class="sql_message"></span>
			</div>
			<center style='color:red;'><h3>Operation You Are Scanning Is &nbsp;<span style='color:green;'><?php echo $operation_name;?></span>&nbsp; On The Shift &nbsp;&nbsp;<span style='color:green;'><?php echo $shift;?> <span style='color:red;'></h3></center>
			<div class='col-sm-12'>
				<div class='col-lg-6 col-sm-12'>
					<input type='text' id='changed_rej' name='changed_rej' hidden='true'>
						<input type='text' id='changed_rej_id' name='changed_rej_id' hidden='true'>
						<table class="table table-bordered">
							<tr>
								<td>Style</td>
								<td id='style_show'><?= $style ?></td>
							</tr>
							<tr>
								<td>Schedule</td>
								<td id='schedule_show'><?= $schedule ?></td>
							</tr>
							<tr>
								<td>Mapped Color</td>
								<td id='color_show'><?= $color ?></td>
							</tr>
						</table>
						<center>
						<div class="form-group col-lg-6 col-sm-12">
							<label><?php echo $label_name_to_show ?><span style="color:red"></span></label>
							<input type="text" id="job_number" onkeyup="validateQty1(event,this);" value='<?= $input_job_no_random_ref ?>' class="form-control" required placeholder="Scan the Job..." <?php echo $read_only_job_no;?>/>
						</div>
						<div class = "form-group col-lg-6 col-sm-12" hidden='true'>
							<label>Assigning To Module</label><br>
							<div id='module_div' hidden='true'>
								<h3><label class='label label-info label-xs' id='module_show'></span><h3>
							</div>
						</div>
						</br>
						<!-- <div class = "form-group col-lg-6 col-sm-12" id='setresetfun' hidden='true'>
								<button type='button' class='btn btn-success' value='Set' style='float: right;' onclick='setfunction();' id='setreset'>Set</button>
						</div> -->
						<div class="form-group col-md-3">
						</div>
					</center>
				</div>
				<div class="form-group col-lg-6 col-sm-12">
					<div class="progress progress-striped active" hidden='true' id='progressbar'>
						<div class="progress-bar"  role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
						</div>
					</div>
					<div  class='panel panel-primary' id="pre_pre_data" hidden='true'>
						<div class='panel-heading'>Previous Transaction</div>
						<div style='overflow-x:scroll' class='panel-body' id="pre_data"></div>
					</div>
				</div>
			</div>
			<div class='row'>
				
			</div>
		
		<div class='panel panel-primary'>
			<div class='panel-heading'><?php echo $label_name_to_show;?> Data</div>
				<div class="ajax-loader" id="loading-image" style="margin-left: 45%;margin-top: 35px;border-radius: -80px;width: 88px;">
					<img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
				</div>
			<form action="index.php?r=<?php echo $_GET['r']?>" name= "smartform" method="post" id="smartform">
				<div class='panel-body'>
						<input type="hidden" name="style" id="style">
						<input type="hidden" name="schedule" id="schedule">
						<input type="hidden" name="color" id="mapped_color">
						<input type="hidden" name="job_number" id="hid_job">
						<input type="hidden" name="module" id="module" value="<?php echo $module;?>">
						<input type="hidden" name="operation_name" id="op_name" value="<?php echo $operation_name;?>">
						<input type="hidden" name="shift" id="shift" value="<?php echo $shift;?>">
						<input type="hidden" name="operation_id" id='operation_id' value="<?php echo $operation_code;?>">
						<input type="hidden" name="barcode_generation" id='barcode_generation' value="<?php echo $barcode_generation;?>">
						<input type="hidden" name="response_flag" id='response_flag'>
						<input type="hidden" name="emb_cut_check_flag" id='emb_cut_check_flag' value='0'>
						<input type="hidden" id="no_of_rows">
						
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
					                	<input type="text" onkeyup="validateQty(event,this);" name="no_reason" min=0 id="reason" class="form-control"  onchange="validating_with_qty()" onfocus='if($(this).val() == 0){$(this).val(``)}' onfocusout='if($(this).val() > 0){}else{$(this).val(0)}' placeholder="Enter no of reasons"/>
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
																echo "<option value='".$row['reason_code']."'>".$row['reason_desc']."</option>";
															}
														} else {
															echo "<option value=''>No Data Found..</option>";
														}
													?>
												</select>
												</td>
												<td><input type='text' class='form-control input-sm' id='quantity'  name='quantity[]' onkeyup='validateQty(event,this);' onchange='validating_cumulative(event,this)'></td>
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
	var display_reporting_qty = document.getElementById('display_reporting_qty').value;	
	var operation_code_routing = document.getElementById('operation_code_routing').value;
	$('#job_number').focus();
	$('#loading-image').hide();
	<?php if ($_POST['operation_name']) {?>
	$("#job_number").change(function()
	{
	<?php }?>
        $('#dynamic_table1').html('');
		$('#loading-image').show();
		var function_text = "<?php echo getFullURL($_GET['r'],'functions_scanning_ij.php','R'); ?>";
		var barcode_generation = "<?php echo $barcode_generation?>";
		var job_number = $('#job_number').val();
		var operation_id = $('#operation_id').val();
		var assign_module = $('#module').val();
		var current = "<?php echo $operation_name; ?>";
		var module_flag = null;	var restrict_msg = '';
		var pre_array_module = [assign_module,job_number,operation_id,'scan'];
		$.ajax({
			type: "POST",
			url: function_text+"?pre_array_module="+pre_array_module,
			dataType: "json",
			success: function (response) 
			{
				if (response == 4)
				{
					module_flag = 1; // block
					restrict_msg = 'No Module Assigned';
				}
				else if (response == 3)
				{
					module_flag = 1; // block
					restrict_msg = 'No Valid Block Priorities';
				}
				else if (response == 2)
				{
					var authorize_check = $('#user_permission').val();
					if (authorize_check == 'authorized')
					{
						module_flag = 0; // allow
					}
					else
					{
						module_flag = 1; // block
						restrict_msg = 'You are Not Authorized to report more than Block Priorities';
					}
				}
				else if (response == 0)
				{
					module_flag = 0; // allow
				}
				if(module_flag == 0)
				{
					var array = [job_number,operation_id,barcode_generation,assign_module];
					$.ajax({
							type: "POST",
							url: function_text+"?job_number="+array,
							dataType: "json",
							success: function (response) 
							{
								var sewing_rejection = document.getElementById('sewing_rejection').value;
								console.log(response);
								console.log(sewing_rejection);
								s_no = 0;
								var data = response['table_data'];
								var flag = response['flag'];
								var op_codes = response['ops_get_code'];
								//var sample_qtys = response[]]
								var emb_ops = response['emb_cut_check_flag'];
								if(response['status'])
								{
									sweetAlert('',response['status'],'error');
									$('#dynamic_table1').html('No Data Found');
									document.getElementById('job_number').value = '';

								}
								else if(data)
								{
									if(response['emb_cut_check_flag'])
									{
										$('#emb_cut_check_flag').val(emb_ops);
									}
									console.log(response['emb_cut_check_flag']);
									console.log(data);
									$('#dynamic_table1').html('');
									$('#module_div').hide();
									console.log(response['color_dis']);
									document.getElementById('style_show').innerHTML = response['style'];
									document.getElementById('style').value = response['style'];
									document.getElementById('schedule_show').innerHTML = response['schedule'];
									document.getElementById('schedule').value = response['schedule'];
									document.getElementById('color_show').innerHTML = response['color_dis'];
									document.getElementById('mapped_color').value = response['color_dis'];
									var btn = '<div class="pull-right" id="smart_btn_arear"><input type="button" class="btn btn-primary submission" value="Submit" name="formSubmit" id="smartbtn" onclick="return check_pack();"><input type="hidden" id="count_of_data" value='+data.length+'></div>';
									var flagelem = "<input type='hidden' name='flag' id='flag' value='"+flag+"'>";
									$("#dynamic_table1").append(markup);
									$("#dynamic_table1").append(btn);
									$("#dynamic_table1").append(flagelem);
									var op_codes_str='';
									$.each(op_codes, function( index, value ) {
										console.log( index + ": " + value );
										op_codes_str = op_codes_str + '<th>'+value+'</th>';
									});
									for(var i=0;i<data.length;i++)
									{
										var hidden_class='';
										var hidden_class_sewing_in='';
										var rec_qy_pre = response['recevied_pre_qty'];

										if (operation_id == 100 || operation_id == 130 || operation_id == 900)
										{
											if (sewing_rejection == 'no')
											{
												var hidden_class_sewing_in='hidden';
											}
											else
											{
												var hidden_class_sewing_in='';
											}							
										}
										var remarks_check_flag = 0;
										if(i==0)
										{
											var markup = "<div class='container'><div class='row'><div id='no-more-tables'><table class = 'col-sm-12 table-bordered table-striped table-condensed cf' id='dynamic_table'><thead class='cf'><tr><th>S.No</th><th>Status</th><th class='none'>Doc.No</th><th>Color</th><th>Module</th><th>Size</th><th>Input Job Qty</th>"+op_codes_str+"<th>Cumulative Reported Quantity</th><th>Eligibility To Report</th><th>Reporting Quantity</th><th class='"+hidden_class_sewing_in+"'>Rejected Qty.</th><th>Recut In</th><th>Replace In</th><th class='"+hidden_class_sewing_in+"'>Rejection quantity</th></tr></thead><tbody>";
											var flagelem = "<input type='hidden' name='flag' id='flag' value='"+flag+"'>";
											$("#dynamic_table1").append(markup);
											$("#dynamic_table1").append(btn);
											$("#dynamic_table1").append(flagelem);
										}
										var readonly ='';
										var temp_var_bal = 0;
										var er = Number(data[i].send_qty);
										var repq = Number(data[i].reported_qty)+Number(data[i].rejected_qty);
										
										if(er == 0 || er == null){
											if(response['emb_cut_check_flag'] && data[i].balance_to_report == 0)
											{
												status = '<font color="red">Cut Quantity not done</font>';
											}else{
												status = '<font color="red">Previous Operation Not Done</font>';
											}
										}else if(er == repq){
											status = '<font color="red">Fully Scanned</font>';
										}else if( (er != 0 || repq != 0) && er!=repq){
											status = '<font color="orange">Partially Scanned</font>';
										}

										/*	
										if(Number(data[i].reported_qty) > 0 && Number(data[i].balance_to_report) != 0)
										{
											status = '<font color="green">Partially Scanned</font>';
										}
										else if(data[i].send_qty != 0 && Number(data[i].reported_qty) == 0)
										{
											status = '<font color="green">Scanning Pending</font>';
										}
										else if(data[i].send_qty != 0 && Number(data[i].balance_to_report) ==0)
										{
											if(Number(data[i].send_qty) == Number(data[i].reported_qty)+Number(data[i].recut_in)+Number(data[i].replace_in)+Number(data[i].balance_to_report))
											{
												status = '<font color="red">Already Scanned</font>';
											}
										}
										else if(response['emb_cut_check_flag'] && data[i].balance_to_report == 0)
										{
											status = '<font color="red">Cut Quantity not done</font>';
										}
										else
										{
											status = '<font color="red">No Operation Reported</font>';
										}
										*/
										var temp_var_bal1 = 0;				
										if(operation_id == operation_code_routing)
										{
											if (display_reporting_qty == 'yes')
											{
												var temp_var_bal1 = data[i].balance_to_report;
											}
											else
											{
												var temp_var_bal1 = 0;
											}
										}
										temp_var_bal = data[i].balance_to_report;
										if(barcode_generation == 0)
										{
											if(Number(data[i].tid) != Number(job_number))
											{
												var hidden_class='hidden';
											}
										}
										s_no++;
										var test = '1';
										var op_code_values = '';
										$.each(op_codes, function( index, value ) {
											op_code_values = op_code_values + '<td>'+data[i].recevied_pre_qty[value]+'</td>';
										});
										var markup1 = "<tr class="+hidden_class+"><td data-title='S.No'>"+s_no+"</td><td data-title='Status'>"+status+"</td><td class='none' data-title='Doc.No'>"+data[i].doc_no+"</td><td data-title='Color'>"+data[i].order_col_des+"</td><td data-title='module' id='"+i+"module'>"+data[i].assigned_module+"</td><input type='hidden' name='module[]' value = '"+data[i].assigned_module+"'><td data-title='Size'>"+data[i].size_code.toUpperCase()+"</td><td data-title='Input Job Quantity'>"+data[i].carton_act_qty+"</td>"+op_code_values+"<input type='hidden' name='old_size[]' value = '"+data[i].old_size+"'><td  data-title='Cumulative Reported Quantity'>"+data[i].reported_qty+"</td><td id='"+i+"remarks_validate_html'  data-title='Eligibility To Report'>"+temp_var_bal+"</td><td data-title='Reporting Qty'><input type='text' onkeyup='validateQty(event,this)'  class='form-control input-md twotextboxes' id='"+i+"reporting' onfocus='if($(this).val() == 0){$(this).val(``)}' onfocusout='if($(this).val() > 0){}else{$(this).val(0)}' value='"+temp_var_bal1+"' required name='reporting_qty[]' onchange = 'validate_reporting_report("+i+") '"+readonly+"></td><td class='"+hidden_class_sewing_in+"'>"+data[i].rejected_qty+"</td><td>"+data[i].recut_in+"</td><td>"+data[i].replace_in+"</td><td class='"+hidden_class_sewing_in+"'><input type='text' onfocus='if($(this).val() == 0){$(this).val(``)}' onfocusout='if($(this).val() > 0){}else{$(this).val(0)}' onkeyup='validateQty(event,this)' required value='0' class='form-control input-md twotextboxes' id='"+i+"rejections' name='rejection_qty[]' onchange = 'rejections_capture("+i+")' "+readonly+"></td><td class='hide'><input type='hidden' name='qty_data["+data[i].tid+"]' id='"+i+"qty_data'></td><td class='hide'><input type='hidden' name='reason_data["+data[i].tid+"]' id='"+i+"reason_data'></td><td class='hide'><input type='hidden' name='tot_reasons[]' id='"+i+"tot_reasons'></td><td class='hide'><input type='hidden' name='doc_no[]' id='"+i+"doc_no' value='"+data[i].doc_no+"'></td><td class='hide'><input type='hidden' name='colors[]' id='"+i+"colors' value='"+data[i].order_col_des+"'></td><td class='hide'><input type='hidden' name='sizes[]' id='"+i+"sizes' value='"+data[i].size_code+"'></td><td class='hide'><input type='hidden' name='job_qty[]' id='"+i+"job_qty' value='"+data[i].carton_act_qty+"'></td><td class='hide'><input type='hidden' name='tid[]' id='"+i+"tid' value='"+data[i].tid+"'></td><td class='hide'><input type='hidden' name='inp_job_ref[]' id='"+i+"inp_job_no' value='"+data[i].input_job_no+"'></td><td class='hide'><input type='hidden' name='a_cut_no[]' id='"+i+"a_cut_no' value='"+data[i].acutno+"'></td><td class='hide'><input type='hidden' name='old_rep_qty[]' id='"+i+"old_rep_qty' value='"+data[i].reported_qty+"'></td><td class='hide'><input type='hidden' name='old_rej_qty[]' id='"+i+"old_rej_qty' value='"+data[i].rejected_qty+"'><input type='hidden' name='sampling[]' value='"+data[i].remarks+"'></td></tr>";
										$("#dynamic_table").append(markup1);
										$("#dynamic_table").hide();
									}
								}
								var markup99 = "</tbody></table></br></div></div></div>";
								$("#dynamic_table").append(markup99);
								$("#dynamic_table").show();
								$('#hid_job').val(job_number);
								$('#loading-image').hide();
								$('#loading-image').hide();
							}		    
						});
			}
			else
			{
				sweetAlert(restrict_msg,'','error');
				$('#loading-image').hide();
			}	
		}		
	});				
	<?php if ($_POST['operation_name']) {?>
	});
	<?php }?>
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
	if(Number(result) > Number(tot))
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
function validating_cumulative(e,t)
{
	var result = 0;
	$('input[name="quantity[]"]').each(function(){
		if(isNaN($(this).val()))
		{
			$(this).val('');
		}
		else
		{
			result += Number($(this).val());
		}
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
	var display_reporting_qty = document.getElementById('display_reporting_qty').value;
	var line_in = document.getElementById('line-in').value;
	var operation_code_routing = document.getElementById('operation_code_routing').value;
	var function_text = "<?php echo getFullURL($_GET['r'],'functions_scanning_ij.php','R'); ?>";
	var bundle_number_var = val+"tid";
	var module_var =val+"module";
	var bundle_number = document.getElementById(bundle_number_var).value;
	var module = document.getElementById(module_var).innerHTML;
	console.log(bundle_number);
	console.log(module);
	var operation_id = document.getElementById('operation_id').value;
	var input_job_number = $('#job_number').val();
	var barcode_generation = "<?php echo $barcode_generation?>";
	var array_remarks_params = [input_job_number,bundle_number,operation_id,remarks,val,barcode_generation,module];
	var flag = $('#flag_validation').val();
	console.log(flag);
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
			if(max == '')
			{
				array[0] = 0;
			}
			console.log(array[0]);
			var html_id = val+"remarks_validate_html";
			var html_id_reporting =val+"reporting";
			console.log(html_id_reporting);
			$('#'+html_id).html(array[0]);
			if (operation_id == operation_code_routing || operation_id == '900')
			{
				if (line_in == 'yes')
				{
					$('#'+html_id_reporting).val(array[0]);
				}
				if (display_reporting_qty == 'yes')
				{
					$('#'+html_id_reporting).val(array[0]);
				}
			}
			else
			{
				$('#'+html_id_reporting).val(array[0]);
			}	
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
$('input[type=submit]').click(function() {
    $(this).attr('disabled', 'disabled');
    $(this).parents('form').submit()
})
</script>	

<script>
function check_pack()
{
	var count = document.getElementById('count_of_data').value;
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
		return false;
	}
	else
	{
		$('.submission').hide();
		$('#progressbar').show();
		$('.progress-bar').css('width', 30+'%').attr('aria-valuenow', 20); 
		$('.progress-bar').css('width', 50+'%').attr('aria-valuenow', 30); 
		
		var bulk_data =  $("#smartform").serialize();  
		console.log(bulk_data);
		var function_text = "<?php echo getFullURL($_GET['r'],'scanning_functionality_ajax.php','R'); ?>";
		$('.progress-bar').css('width', 80+'%').attr('aria-valuenow', 40); 
		document.getElementById('dynamic_table1').innerHTML = '';
		document.getElementById('style_show').innerHTML = '';
		document.getElementById('schedule_show').innerHTML = '';
		document.getElementById('color_show').innerHTML = '';
		document.getElementById('job_number').value = '';
		document.getElementById('module_show').innerHTML = '';
		document.getElementById('pre_data').innerHTML ='';
		$('#flag_validation').val(0);
		$('#smart_btn_arear').hide();
		
			$.ajax
			({
				type: "POST",
				url: function_text,
				data : {bulk_data: bulk_data},
				success: function (response) 
				{	
					console.log(response);
					$('#pre_pre_data').show();
					document.getElementById('pre_data').innerHTML = response;
					$('.progress-bar').css('width', 100+'%').attr('aria-valuenow', 80);
					$('.progress').hide();
					$('#smart_btn_arear').show();
				}
				
			});
		
		//return true;
	}
}
function validating()
{
	console.log("working");
	//document.getElementByClassName('submission').style.visibility = 'hidden';
	
}
// function setfunction()
// {
// 	var noofrows = $('#no_of_rows').val();
//     if(document.getElementById('setreset').innerHTML == 'Set')
//     {
//         for(var i=0; i<Number(noofrows); i++)
//         {
//             var rem_var = i+'remarks_validate_html';
// 			var rem = i+'reporting';
//             console.log(rem_var);
//             var remaining_qty = document.getElementById(rem_var).innerHTML;
//             document.getElementById(rem).value = remaining_qty; 
//         }
//         document.getElementById('setreset').innerHTML = 'ReSet';
//     }
//     else
//     {
//         for(var i=0; i<Number(noofrows); i++)
//         {
// 			var rem = i+'reporting';
//             document.getElementById(rem).value = 0; 
//         }
//         document.getElementById('setreset').innerHTML = 'Set';

//     }
    
// }


</script>
<style>
.hidden_class,.hidden_class_for_remarks{
	display:none;
}

</style>
	
<?php
if(isset($_GET['sidemenu'])){
	//echo "hiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii";
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
<style>
	@media only screen and (max-width: 800px) {
        /* Force table to not be like tables anymore */
        #no-more-tables table,
        #no-more-tables thead,
        #no-more-tables tbody,
        #no-more-tables th,
        #no-more-tables td,
        #no-more-tables tr {
        display: block;
        }
         
        /* Hide table headers (but not display: none;, for accessibility) */
        #no-more-tables thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
        }
         
        #no-more-tables tr { border: 1px solid #ccc; }
          
        #no-more-tables td {
        /* Behave like a "row" */
        border: none;
        border-bottom: 1px solid #eee;
        position: relative;
        padding-left: 50%;
        white-space: normal;
        /*text-align:left;*/
        }
         
        #no-more-tables td:before {
        /* Now like a table header */
        position: absolute;
        /* Top/left values mimic padding */
        top: 6px;
        left: 6px;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;
        text-align:left;
        font-weight: bold;
        }
        td{
			text-align:right;
		}
        /*
        Label the data
        */
        #no-more-tables td:before { content: attr(data-title); }
        }
</style>