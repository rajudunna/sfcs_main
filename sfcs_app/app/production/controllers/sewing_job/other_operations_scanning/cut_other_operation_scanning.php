<head>
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
        //alert('hello');
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
</head>
<?php
	include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));  
	$has_permission=haspermission($_GET['r']);
	if ($_GET['operation_id'])
	{
        $shift = $_GET['shift'];
        $operation_code=$_GET['operation_id'];
        $operation_name = echo_title("$brandix_bts.tbl_orders_ops_ref","operation_name","operation_code",$operation_code,$link).- $operation_code;
        $read_only_job_no = '';

	} else {
        $doc_no=$_POST['doc_no'];
        $operation_code=$_POST['operation_id'];
        $style=$_POST['style'];
        $schedule=$_POST['schedule'];
        $module=$_POST['module'];
        $operation_name = $_POST['operation_name'];
        $color = $_POST['color'];
        $read_only_job_no = '';
	}	
	
	$qery_rejection_resons = "select * from $bai_pro3.bai_qms_rejection_reason where form_type = 'P'";
	$result_rejections = $link->query($qery_rejection_resons);
?>
<?php
$url = getFullURL($_GET['r'],'pre_other_ops_scanning.php','N');
$page_flag = $_GET['page_flag'];
?>
<button onclick="location.href = '<?php echo $url;?>'" class="btn btn-primary">Click here to go Back</button>

<div class="panel panel-primary">  
    <div class="panel-heading">Scan Cut Job</div>
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
                    <div class="form-group col-lg-6">
                    <center><label>Docket Number</label></center>
                        <input type="text" id="docket_number" onkeyup="validateQty1(event,this);" value='<?= $doc_no ?>' class="form-control" required placeholder="Scan the Cut Job..." <?php echo $read_only_job_no;?>/>
                    </div>
                    <div class="form-group col-md-3">
                    </div>
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
        <div class='panel panel-primary'  id="maindiv">
            <div class='panel-heading'>Cut Job Data</div>
            <div class="ajax-loader" id="loading-image" style="margin-left: 45%;margin-top: 35px;border-radius: -80px;width: 88px;">
                <img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
            </div>
            <form action="index.php?r=<?php echo $_GET['r']?>" name= "smartform" method="post" id="smartform">
                <div class='panel-body'>
                    <input type="hidden" name="style" id="style" value=<?=$style?>>
                    <input type="hidden" name="schedule" id="schedule" value=<?=$schedule?>>
                    <input type="hidden" name="color" id="mapped_color" value=<?=urlencode($color)?>>
                    <input type="hidden" name="docket_number" id="hid_job">
                    <input type="hidden" name="module" id="module" value="<?php echo $module;?>">
                    <input type="hidden" name="operation_name" id="op_name" value="<?php echo $operation_name;?>">
                    <input type="hidden" name="operation_id" id='operation_id' value="<?php echo $operation_code;?>">
                    <input type="hidden" name="shift" id='shift' value="<?php echo $shift;?>">
                    <input type="hidden" name="page_flag" id='page_flag' value="<?php echo $page_flag;?>">
                    <input type="hidden" name="response_flag" id='response_flag'>
                    <div id ="dynamic_table1">
                    </div>
                </div>
            </form>
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
                            <input type="text" onkeyup="validateQty(event,this);" name="no_reason" min=0 id="reason" class="form-control" onfocus='if($(this).val() == 0){$(this).val(``)}' onfocusout='if($(this).val() > 0){}else{$(this).val(0)}' placeholder="Enter no of reasons"/>
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


<script>
$(document).ready(function() 
{
    $('#docket_number').focus();
    $('#dynamic_table1').html('');
    $('#loading-image').hide();
    $("#docket_number").change(function()
    {
    $('#loading-image').show();
    var function_text = "<?php echo getFullURL($_GET['r'],'../sewing_job_scaning/functions_scanning_ij.php','R'); ?>";
    var docket_number = $('#docket_number').val();
    var operation_id = $('#operation_id').val();
    // var assign_module = $('#module').val();
    // var style = $('#style').val();
    // var schedule = $('#schedule').val();
    // var color = $('#mapped_color').val();
    var array = [docket_number,operation_id];
	$.ajax({
			type: "POST",
			url: function_text+"?docket_number="+array,
			dataType: "json",
			success: function (response) 
			{	
                s_no = 0;
				var data = response['table_data'];
                if(response['status']){
					sweetAlert('',response['status'],'error');
					$('#dynamic_table1').html('No Data Found');
					document.getElementById('docket_number').value = '';
				}else if(data){
					$('#dynamic_table1').html('');
					document.getElementById('style').value = response['style'];
                    document.getElementById('style_show').innerHTML = response['style'];
					document.getElementById('schedule').value = response['schedule'];
                    document.getElementById('schedule_show').innerHTML = response['schedule'];
					document.getElementById('mapped_color').value = response['color'];;
                    document.getElementById('color_show').innerHTML = response['color'];

                    var btn = '<div class="pull-right" id="smart_btn_arear"><input type="button" class="btn btn-primary submission" value="Submit" name="formSubmit" id="smartbtn" onclick="return check_pack();"><input type="hidden" id="count_of_data" value='+data.length+'></div>';
					$("#dynamic_table1").append(btn);

                    for(var i=0;i<data.length;i++){
                        if(i==0){
                            var markup = "<div class='container'><div class='row'><div id='no-more-tables'><table class = 'col-sm-12 table-bordered table-striped table-condensed cf' id='dynamic_table'><thead class='cf'><tr><th>S.No</th><th>Size</th><th>Cut Job Qty</th><th>Cumulative Reported Quantity</th><th>Eligibility To Report</th><th>Good Quantity</th><th>Rejected Qty.</th></tr></thead><tbody>";
                            $("#dynamic_table1").append(markup);
                            $("#dynamic_table1").append(btn);
                        }
                        var readonly ='';
                        var temp_var_bal = data[i].balance_to_report;
                        s_no++;
                        var markup1 = "<tr><td data-title='S.No'>"+s_no+"</td><td data-title='Size'>"+data[i].size_code.toUpperCase()+"</td><td data-title='Input Job Quantity'>"+data[i].carton_act_qty+"</td><input type='hidden' name='old_size[]' value = '"+data[i].old_size+"'><td  data-title='Cumulative Reported Quantity'>"+data[i].reported_qty+"</td><td id='"+i+"remarks_validate_html'  data-title='Eligibility To Report'>"+temp_var_bal+"</td><td data-title='Reporting Qty'><input type='text' onkeyup='validateQty(event,this)'  class='form-control input-md twotextboxes' id='"+i+"reporting' onfocus='if($(this).val() == 0){$(this).val(``)}' onfocusout='if($(this).val() > 0){}else{$(this).val(0)}' value='"+temp_var_bal+"' required name='reporting_qty[]' onchange = 'validate_reporting_report("+i+") '"+readonly+"></td><td><input type='text' onfocus='if($(this).val() == 0){$(this).val(``)}' onfocusout='if($(this).val() > 0){}else{$(this).val(0)}' onkeyup='validateQty(event,this)' required value='0' class='form-control input-md twotextboxes' id='"+i+"rejections' name='rejection_qty[]' onchange = 'rejections_capture("+i+")' "+readonly+"></td><td class='hide'><input type='hidden' name='qty_data["+data[i].tid+"]' id='"+i+"qty_data'></td><td class='hide'><input type='hidden' name='reason_data["+data[i].tid+"]' id='"+i+"reason_data'></td><td class='hide'><input type='hidden' name='tot_reasons[]' id='"+i+"tot_reasons'></td><td class='hide'><input type='hidden' name='doc_no[]' id='"+i+"doc_no' value='"+data[i].doc_no+"'></td><td class='hide'><input type='hidden' name='colors[]' id='"+i+"colors' value='"+data[i].order_col_des+"'></td><td class='hide'><input type='hidden' name='sizes[]' id='"+i+"sizes' value='"+data[i].size_code+"'></td><td class='hide'><input type='hidden' name='job_qty[]' id='"+i+"job_qty' value='"+data[i].carton_act_qty+"'></td><td class='hide'><input type='hidden' name='tid[]' id='"+i+"tid' value='"+data[i].tid+"'></td><td class='hide'><input type='hidden' name='inp_job_ref[]' id='"+i+"inp_job_no' value='"+data[i].input_job_no+"'></td><td class='hide'><input type='hidden' name='a_cut_no[]' id='"+i+"a_cut_no' value='"+data[i].acutno+"'></td><td class='hide'><input type='hidden' name='old_rep_qty[]' id='"+i+"old_rep_qty' value='"+data[i].reported_qty+"'></td><td class='hide'><input type='hidden' name='old_rej_qty[]' id='"+i+"old_rej_qty' value='"+data[i].rejected_qty+"'></td><input type='hidden' name='bundle_numbers[]' id='"+i+"bundle_number' value='"+data[i].tid+"'></td></tr>";
                        $("#dynamic_table").append(markup1);
                        $("#dynamic_table").hide();
					}
					var markup99 = "</tbody></table></div></div></div>";
					$("#dynamic_table").append(markup99);
					$("#dynamic_table").show();
					$('#hid_job').val(docket_number);
                }
                $('#loading-image').hide();	
            }
		});	
    });
});

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
			console.log(html_markup);
			$("#tablebody").append(html_markup);
		}
	}
	
});

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

function rejections_capture(val)
{       
	$('#docket_number').focus();
	$("#tablebody").html('');
	var rej = val+"rejections";
	var tot_rejections = document.getElementById(rej).value;
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
			if (operation_id == '129')
			{
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
		$('#progressbar').show();
		$('.progress-bar').css('width', 30+'%').attr('aria-valuenow', 20); 
		$('.progress-bar').css('width', 50+'%').attr('aria-valuenow', 30); 
		
		var bulk_data =  $("#smartform").serialize();  
		var function_text = "<?php echo getFullURL($_GET['r'],'other_operation_scanning_process.php','R'); ?>";
		$('.progress-bar').css('width', 80+'%').attr('aria-valuenow', 40); 
		document.getElementById('maindiv').style.display = 'none';
		document.getElementById('dynamic_table1').innerHTML = '';
		document.getElementById('docket_number').value = '';
        document.getElementById('style').innerHTML = '';
        document.getElementById('schedule').innerHTML = '';
        document.getElementById('mapped_color').innerHTML = '';
		document.getElementById('pre_data').innerHTML ='';
		$('#smart_btn_arear').hide();
        $.ajax
        ({
        	type: "POST",
        	url: function_text,
        	data : {bulk_data: bulk_data},
        	success: function (response) 
        	{	
        		$('#pre_pre_data').show();
        		document.getElementById('pre_data').innerHTML = response;
        		$('.progress-bar').css('width', 100+'%').attr('aria-valuenow', 80);
        		$('.progress').hide();
        		$('#smart_btn_arear').show();
        	}
            
        });
	}
}
</script>