<head>
<script src="/sfcs_app/common/js/jquery-ui.js"></script>
</head>
<?php
	include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',5,'R'));
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
		$plant_code=$_GET['plant_code'];
		$to_get_operation_name="SELECT operation_name FROM $pms.operation_mapping WHERE operation_code='$operation_code' AND plant_code='$plant_code'";
		$operation_result=mysqli_query($link, $to_get_operation_name)or exit("operation_error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($operation_result))
		{
			$operation_name=$sql_row['operation_name'].- $operation_code;
		}
		$shift=$_GET['shift'];
		$barcode_generation=1;
		$read_only_job_no = 'readonly';
		//To get IPS Routing Operation
		$application='Input Planning System';
		$to_get_map_id="SELECT operation_map_id FROM `pms`.`operation_routing` WHERE dashboard_name='$application' AND plant_code='$plant_code'";
		//echo $scanning_query;
		$map_id_result=mysqli_query($link_new, $to_get_map_id)or exit("error in operation_routing".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($map_id_result))
		{
			$operation_map_id=$sql_row1['operation_map_id'];
		}
		$to_get_ops_code="SELECT operation_code FROM `pms`.`operation_mapping` WHERE operation_map_id='$operation_map_id' AND plant_code='$plant_code'";
		$get_ops_result=mysqli_query($link_new, $to_get_ops_code)or exit("error in operation_mapping".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($get_ops_result))
		{
			$operation_code_routing=$sql_row2['operation_code'];
		}

		if($operation_code_routing == 'Auto'){
			$get_ips_op = get_ips_operation_code($link,$style,$color);
			$operation_code_routing=$get_ips_op['operation_code'];
		}

	} else {
		$schedule=$_POST['schedule'];
		$color=$_POST['color'];
		$style=$_POST['style'];
		$shift=$_POST['shift'];
		$module=0;
		$operation_name=$_POST['operation_name'];
		$operation_code=$_POST['operation_id'];
		$plant_code=$_POST['plant_code'];
		$barcode_generation=$_POST['barcode_generation'];
		$read_only_job_no = '';
		$operation_code_routing='';
	}

	$access_report = $operation_code.'-G';
	$access_reject = $operation_code.'-R';

	$access_qry=" select * from $central_administration_sfcs.rbac_permission where (permission_name = '$access_report' or permission_name = '$access_reject') and status='active'";
	$result = $link->query($access_qry);
	
	if($result->num_rows > 0){
		if (in_array($$access_report,$has_permission))
		{
			$good_report = '';
		}
		else
		{
			$good_report = 'readonly';
		}
		if (in_array($$access_reject,$has_permission))
		{
			$reject_report = '';
		}
		else
		{
			$reject_report = 'readonly';
		}
	} else {
		$good_report = '';
		$reject_report = '';
	}
	
	echo '<input type="hidden" name="good_report" id="good_report" value="'.$good_report.'">';
	echo '<input type="hidden" name="reject_report" id="reject_report" value="'.$reject_report.'">';

	
	

	echo '<input type="hidden" name="operation_code_routing" id="operation_code_routing" value="'.$operation_code_routing.'">';
	echo '<input type="hidden" name="sewing_rejection" id="sewing_rejection" value="'.$sewing_rejection.'">';
	echo '<input type="hidden" name="display_reporting_qty" id="display_reporting_qty" value="'.$display_reporting_qty.'">';
	echo '<input type="hidden" name="line-in" id="line-in" value="'.$line_in.'">';

	// $category = 'sewing';
	// $get_operations = "select operation_code from brandix_bts.tbl_orders_ops_ref where category='$category'";
	// $operations_result_out=mysqli_query($link, $get_operations)or exit("get_operations_error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// while($sql_row_out=mysqli_fetch_array($operations_result_out))
	// {
	// 	$sewing_operations[]=$sql_row_out['operation_code'];
	// }



	$url = getFullURL($_GET['r'],'pre_input_job_scanning.php','N');
// 	if(in_array($operation_code,$sewing_operations))
// 	{
// 	$form = "'G','P'";
// 	}else
// 	{
// 		$form = "'P'";
// 	}

	
// $qery_rejection_resons = "select * from $bai_pro3.bai_qms_rejection_reason where form_type in ($form)";
// $result_rejections = $link->query($qery_rejection_resons);
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
			var c = /^[0-9]*\.?[0-9]*\.?[0-9]*$/;
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
                        <input type="hidden" name="plant_code" id='plant_code' value="<?php echo $plant_code;?>">
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
	 <!--
	<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				 
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
																echo "<option value='".$row['sno']."'>".$row['form_type']."-".$row['reason_desc']."</option>";
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
	</div> -->
	
</body>
<script>
$(document).ready(function() 
{
	var display_reporting_qty = document.getElementById('display_reporting_qty').value;	
	var operation_code_routing = document.getElementById('operation_code_routing').value;
	$('#job_number').focus();
	$('#loading-image').hide();
	$("#job_number").change(function()
	{
		$('#dynamic_table1').html('');
		$('#loading-image').show();
		
		var barcode_generation = "<?php echo $barcode_generation?>";
		var job_number = $('#job_number').val();
		var operation_id = $('#operation_id').val();
		var plant_code = $('#plant_code').val();
		var module_flag = null;	var restrict_msg = '';
        if(barcode_generation == 0){
		    var inputObj = {"barcode":job_number, "plantCode":plant_code, "operationCode":operation_id};
			var url = "<?php echo $BackendServ_ip?>/fg-retrieving/getJobDetailsForBundleNumber";
        } else if(barcode_generation == 1){
		    var inputObj = {"sewingJobNo":job_number, "plantCode":plant_code, "operationCode":operation_id};
			var url = "<?php echo $BackendServ_ip?>/fg-retrieving/getJobDetailsForSewingJob";
        }		
		$.ajax({
			type: "POST",
			url: url,
			data: inputObj,
			success: function (res) {            
				//console.log(res.data);
				if(res.status)
				{
					var data=res.data
					tableConstruction(data);
				}
				else
				{
					swal(res.internalMessage);
				}                       
			},
			error: function(res){
				$('#loading-image').hide(); 
				// alert('failure');
				// console.log(response);
				swal('Error in getting docket');
			}
		});
	});
		
	
});

function tableConstruction(data){
    s_no = 0;
    if(data)
    {
        $('#dynamic_table1').html('');
        $('#module_div').hide();
        document.getElementById('style_show').innerHTML = data.style;
        document.getElementById('style').value = data.style;
        document.getElementById('schedule_show').innerHTML = data.schedules;
        document.getElementById('schedule').value = data.schedules;
        document.getElementById('color_show').innerHTML = data.fgColors;
        document.getElementById('mapped_color').value = data.fgColors;
        var btn = '<div class="pull-right" id="smart_btn_arear"><input type="button" class="btn btn-primary submission" value="Submit" name="formSubmit" id="smartbtn" onclick="return check_pack();"><input type="hidden" id="count_of_data" value='+data.sizeQuantities.length+'></div>';
        $("#dynamic_table1").append(markup);
        $("#dynamic_table1").append(btn);

        var op_codes=[];
        $.each(data.sizeQuantities, function( index, operation ) {
            $.each(operation.operationWiseQuantity, function( index1, value1 ) {
                op_codes.push(value1.operationCode);
            });
        });
        op_codes = $.grep(op_codes, function(v, k){
            return $.inArray(v ,op_codes) === k;
        });
        var op_codes_str='';
        $.each(op_codes, function( index, value ) {
            op_codes_str = op_codes_str + '<th>'+value+'</th>';
        });
    
        for(var i=0;i<data.sizeQuantities.length;i++)
        {
            var hidden_class='';
            var hidden_class_sewing_in='';

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
                $("#dynamic_table1").append(markup);
                $("#dynamic_table1").append(btn);
            }
            s_no++;
            var test = '1';
            var op_code_values = '';
                $.each(op_codes, function( index, value ) {
                    op_code_values = op_code_values + '<td>'+data.sizeQuantities[i].operationWiseQuantity[index].quantity+'</td>';
                });
				
            var markup1 = "<tr class="+hidden_class+"><td data-title='S.No'>"+s_no+"</td><td data-title='Status'>"+data.internalMessage+"</td><td class='none' data-title='Doc.No'>"+data.sizeQuantities[i].docketNo+"<input type='hidden' name='docketNo["+i+"]' id='"+i+"docketNo' value = '"+data.sizeQuantities[i].docketNo+"'></td><td data-title='Color'>"+data.sizeQuantities[i].fgColor+"<input type='hidden' name='fgColor["+i+"]' id='"+i+"fgColor' value = '"+data.sizeQuantities[i].fgColor+"'></td><td data-title='module'>"+data.sizeQuantities[i].resourceId+"<input type='hidden' name='module["+i+"]' id='"+i+"module' value = '"+data.sizeQuantities[i].resourceId+"'></td><td data-title='Size'>"+data.sizeQuantities[i].size+"<input type='hidden' name='size["+i+"]' id='"+i+"size' value = '"+data.sizeQuantities[i].size+"'></td><td data-title='Input Job Quantity'>"+data.sizeQuantities[i].inputJobQty+"<input type='hidden' name='inputJobQty["+i+"]' id='"+i+"inputJobQty' value = '"+data.sizeQuantities[i].inputJobQty+"'></td>"+op_code_values+"<td data-title='Cumulative Reported Quantity'>"+data.sizeQuantities[i].cumilativeReportedQty+"<input type='hidden' name='cumilativeReportedQty["+i+"]' id='"+i+"cumilativeReportedQty' value = '"+data.sizeQuantities[i].cumilativeReportedQty+"'></td><td id='"+i+"remarks_validate_html'  data-title='Eligibility To Report'>"+data.sizeQuantities[i].eligibleQuantity+"</td><td data-title='Reporting Qty'><input type='text' onkeyup='validateQty(event,this)' "+$('#good_report').val()+" class='form-control input-md twotextboxes' id='"+i+"reporting' name='reportedQty["+i+"] onfocus='if($(this).val() == 0){$(this).val(``)}' onfocusout='if($(this).val() > 0){}else{$(this).val(0)}' value='0' required name='reporting_qty["+i+"]' onchange = 'validate_reporting_report("+i+") '></td><td class='"+hidden_class_sewing_in+"'>"+data.sizeQuantities[i].rejectedQty+"<input type='hidden' name='oldrejectedQty["+i+"]' id='"+i+"oldrejectedQty' value = '"+data.sizeQuantities[i].rejectedQty+"'></td><td>0</td><td>0</td><td class='"+hidden_class_sewing_in+"'><input type='text' onfocus='if($(this).val() == 0){$(this).val(``)}' onfocusout='if($(this).val() > 0){}else{$(this).val(0)}' onkeyup='validateQty(event,this)' required value='0' class='form-control input-md twotextboxes' id='"+i+"rejections' name='rejectedQty[]' onchange = 'rejections_capture("+i+")' "+$('#reject_report').val()+"></td><td class='hide'><input type='hidden' name='qty_data["+i+"]' id='"+i+"qty_data'></td><td class='hide'><input type='hidden' name='reason_data["+i+"]' id='"+i+"reason_data'></td><td class='hide'><input type='hidden' name='tot_reasons[]' id='"+i+"tot_reasons'></td></tr>";
            $("#dynamic_table").append(markup1);
            $("#dynamic_table").hide();
        }
    }
    var markup99 = "</tbody></table></br></div></div></div>";
    $("#dynamic_table").append(markup99);
    $("#dynamic_table").show();
    $('#hid_job').val(job_number);
    $('#loading-image').hide();
}
function rejections_capture(val)
{
	$('#job_number').focus();
	$("#tablebody").html('');
	var rej = val+"rejections";
	var tot_rejections = document.getElementById(rej).value;
	var flag_validation = document.getElementById('flag_validation').value;
	var rej = val+"rejections";
	var reporting_id = val+"reporting";
	var balance = val+'remarks_validate_html';
	var max = document.getElementById(balance).innerHTML;
	var reporting = document.getElementById(reporting_id).value;
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
	var operation_id = document.getElementById('operation_id').value;
	var input_job_number = $('#job_number').val();
	var barcode_generation = "<?php echo $barcode_generation?>";
	var array_remarks_params = [input_job_number,bundle_number,operation_id,remarks,val,barcode_generation,module];
	var flag = $('#flag_validation').val();
	if(flag != 1)
	{
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
			var html_id = val+"remarks_validate_html";
			var html_id_reporting =val+"reporting";
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
		if($(this).val() != '') {
			qty_data.push($(this).val());
		}
	});
	$('select[name="reason[]"]').each(function(key, value){
		if($(this).val() != '') {
			reason_data.push($(this).val());
		}
	});
	if(qty_data.length == reason_data.length && $('#reason').val() > 0){
		$('#'+id+'qty_data').val(qty_data);
		$('#'+id+'reason_data').val(reason_data);
		$('#'+id+'tot_reasons').val($('input[name="no_reason"]').val());
		$('#myModal').modal('toggle');
	}else{
		sweetAlert('','Please Fill all details in form','error');
	}
	
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
	var reportData = new Object();
	reportData.jobNo = $('#job_number').val();
	reportData.plantCode = $('#plant_code').val();
	reportData.shift = $('#shift').val();
	reportData.operationCode = $('#operation_id').val();
	var sizeQuantities = new Array();
	for(var i=0; i<count; i++)
	{
		var variable = i+"reporting";
		var qty_cnt = document.getElementById(variable).value;
		tot_qty += Number(qty_cnt);
		var sizeQuantitiesObject = new Object();
		sizeQuantitiesObject.size = $('#'+i+'size').val();
		sizeQuantitiesObject.module = $('#'+i+'module').val();
		sizeQuantitiesObject.fgColor =$('#mapped_color').val();
		sizeQuantitiesObject.reportedQty = $('#'+i+'reporting').val();
		sizeQuantitiesObject.rejectedQty = $('#'+i+'rejections').val();
		if(sizeQuantitiesObject.rejectedQty > 0){
			var rejectionDetails = new Array();
			var reason_qty = $('#'+i+'qty_data').val();
			var reason_data = $('#'+i+'reason_data').val();
			var reason_qty_array = reason_qty.split(",")
			var reason_data_array = reason_data.split(",")
			
			for(var j=0; j<reason_qty_array.length; j++){
				var rejectionDetailsObject = new Object();
					rejectionDetailsObject.reasonCode = reason_data_array[j];
					rejectionDetailsObject.reasonQty = reason_qty_array[j];
					rejectionDetails.push(rejectionDetailsObject);
			}
			sizeQuantitiesObject.rejectionDetails = rejectionDetails;
		}
		sizeQuantities.push(sizeQuantitiesObject);
	}
	reportData.sizeQuantities = sizeQuantities;

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
	else {
		console.log(reportData);
		$('.submission').hide();
		$('#progressbar').show();
		$('.progress-bar').css('width', 30+'%').attr('aria-valuenow', 20); 
		$('.progress-bar').css('width', 50+'%').attr('aria-valuenow', 30); 
		document.getElementById('dynamic_table1').innerHTML = '';
		document.getElementById('style_show').innerHTML = '';
		document.getElementById('schedule_show').innerHTML = '';
		document.getElementById('color_show').innerHTML = '';
		document.getElementById('job_number').value = '';
		document.getElementById('module_show').innerHTML = '';
		document.getElementById('pre_data').innerHTML ='';
		$('#flag_validation').val(0);
		$('#smart_btn_arear').hide();
    
		$.ajax({
			type: "POST",
			url: "<?php echo $BackendServ_ip?>/fg-reporting/reportSemiGmtOrGmtJob",
			data:  JSON.stringify(reportData),
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function (res) {            
				//console.log(res.data);
				if(res.status)
				{
					var data = JSON.parse(response);
					$('#pre_pre_data').show();
					var table_data = "<div class='container'><div class='row'><div id='no-more-tables'><table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Input Job</th><th>Bundle Number</th><th>Color</th><th>Size</th><th>Reporting Qty</th><th>Rejecting Qty</th></tr></thead><tbody>";
					for(var z=0; z<data.transactionsData.length; z++){
						table_data += "<tr><td>"+data.transactionsData[z].jobNo+"</td><td>"+data.transactionsData[z].bundleNo+"</td><td>"+data.transactionsData[z].fgColor+"</td><td>"+data.transactionsData[z].size+"</td><td>"+data.transactionsData[z].reportedQty+"<td>"+data.transactionsData[z].rejectedQty+"</td>";
					}
					table_data += "</tbody></table></div></div></div>";
					document.getElementById('pre_data').innerHTML = table_data;
					$('.progress-bar').css('width', 100+'%').attr('aria-valuenow', 80);
					$('.progress').hide();
					$('#smart_btn_arear').show();
					swal(res.internalMessage);
				}
				else
				{
					swal(res.internalMessage);
				}                       
			},
			error: function(res){
				$('#loading-image').hide(); 
				// alert('failure');
				// console.log(response);
				swal('Error in getting docket');
			}
		});
		
	}
	
}

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
<style>
	@media only screen and (max-width: 800px) {
        #no-more-tables table,
        #no-more-tables thead,
        #no-more-tables tbody,
        #no-more-tables th,
        #no-more-tables td,
        #no-more-tables tr {
        display: block;
        }
         
        #no-more-tables thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
        }
         
        #no-more-tables tr { border: 1px solid #ccc; }
          
        #no-more-tables td {
        border: none;
        border-bottom: 1px solid #eee;
        position: relative;
        padding-left: 50%;
        white-space: normal;
        }
         
        #no-more-tables td:before {
        position: absolute;
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
        #no-more-tables td:before { content: attr(data-title); }
        }
</style>
