<head>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<?php
	include(getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
	$has_permission=haspermission($_GET['r']);
	if ($_GET['operation_id'])
	{
        $doc_no=$_GET['doc_no'];
        $operation_code=$_GET['operation_id'];
		$style=$_GET['style'];
		$schedule=$_GET['schedule'];
		$module=$_GET['tablename'];
        //$operation_name = echo_title("$brandix_bts.tbl_orders_ops_ref","operation_name","operation_code",$operation_code,$link).- $operation_code;
        $operation_name = "Na-Istam".-$operation_code;
        $color = $_GET['color'];

	} else {
        echo '<script> swal({
            title: "Invalid operation code", 
            text: "If you click OK, It will close the window ", 
            type: "error",
            showCancelButton: false
          }).then(function() {
            window.close();
          });</script>';
    }
?>


<div class="panel panel-primary">  
    <div class="panel-heading">Scan EMB Cut Job</div>
    <div class='panel-body'>
        <div class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Info! </strong><span class="sql_message"></span>
        </div>
        <center style='color:red;'><h3>Operation You Are Scanning Is &nbsp;<span style='color:green;'><?php echo $operation_name;?></h3></center>
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
                    <center><label>Cut Job Number</label></center>
                        <input type="text" id="doc_number" onkeyup="validateQty1(event,this);" value='<?= $doc_no ?>' class="form-control" required placeholder="Scan the Emb Cut Job..." readonly/>
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
        <div class='panel panel-primary'>
            <div class='panel-heading'>Cut Job Data</div>
            <div class="ajax-loader" id="loading-image" style="margin-left: 45%;margin-top: 35px;border-radius: -80px;width: 88px;">
                <img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
            </div>
            <form action="index.php?r=<?php echo $_GET['r']?>" name= "smartform" method="post" id="smartform">
                <div class='panel-body'>
                    <input type="hidden" name="style" id="style" value=<?=$style?>>
                    <input type="hidden" name="schedule" id="schedule" value=<?=$schedule?>>
                    <input type="hidden" name="color" id="mapped_color" value=<?=urlencode($color)?>>
                    <input type="hidden" name="doc_number" id="hid_job">
                    <input type="hidden" name="module" id="module" value="<?php echo $module;?>">
                    <input type="hidden" name="operation_name" id="op_name" value="<?php echo $operation_name;?>">
                    <input type="hidden" name="operation_id" id='operation_id' value="<?php echo $operation_code;?>">
                    <input type="hidden" name="response_flag" id='response_flag'>
                    <div id ="dynamic_table1">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
$(document).ready(function() 
{
    $('#dynamic_table1').html('');
    $('#loading-image').show();
    var function_text = "<?php echo getFullURL($_GET['r'],'../../../production/controllers/sewing_job/sewing_job_scaning/functions_scanning_ij.php','R'); ?>";
    var doc_number = $('#doc_number').val();
    var operation_id = $('#operation_id').val();
    var assign_module = $('#module').val();
    var style = $('#style').val();
    var schedule = $('#schedule').val();
    var color = $('#mapped_color').val();
    var array = [doc_number,operation_id,assign_module,style,schedule,color];
    console.log(array);
	$.ajax({
			type: "POST",
			url: function_text+"?doc_number="+array,
			dataType: "json",
			success: function (response) 
			{	
                s_no = 0;
				var data = response['table_data'];
                if(response['status']){
					sweetAlert('',response['status'],'error');
					$('#dynamic_table1').html('No Data Found');
					document.getElementById('doc_number').value = '';
				}else if(data){
                    console.log(data);
				// 	$('#dynamic_table1').html('');
                //     document.getElementById('style_show').innerHTML = response['style'];
				// 	document.getElementById('style').value = response['style'];
				// 	document.getElementById('schedule_show').innerHTML = response['schedule'];
				// 	document.getElementById('schedule').value = response['schedule'];
				// 	document.getElementById('color_show').innerHTML = response['color_dis'];
				// 	document.getElementById('mapped_color').value = response['color_dis'];

                //     var btn = '<div class="pull-right" id="smart_btn_arear"><input type="button" class="btn btn-primary submission" value="Submit" name="formSubmit" id="smartbtn" onclick="return check_pack();"><input type="hidden" id="count_of_data" value='+data.length+'></div>';

                //     var flagelem = "<input type='hidden' name='flag' id='flag' value='"+flag+"'>";
				// 	$("#dynamic_table1").append(markup);
				// 	$("#dynamic_table1").append(btn);
				// 	$("#dynamic_table1").append(flagelem);
                //     for(var i=0;i<data.length;i++){
                //         if(i==0){
                //             var markup = "<div class='container'><div class='row'><div id='no-more-tables'><table class = 'col-sm-12 table-bordered table-striped table-condensed cf' id='dynamic_table'><thead class='cf'><tr><th>S.No</th><th>Status</th><th class='none'>Doc.No</th><th>Color</th><th>Module</th><th>Size</th><th>Input Job Qty</th><th>Cumulative Reported Quantity</th><th>Eligibility To Report</th><th>Reporting Quantity</th><th class="+hidden_class_for_remarks+">Remarks</th><th class='"+hidden_class_sewing_in+"'>Rejected Qty.</th><th class='"+hidden_class_sewing_in+"'>Rejection quantity</th></tr></thead><tbody>";
                //             var flagelem = "<input type='hidden' name='flag' id='flag' value='"+flag+"'>";
                //             $("#dynamic_table1").append(markup);
                //             $("#dynamic_table1").append(btn);
                //             $("#dynamic_table1").append(flagelem);
                //         }
                //         var readonly ='';
                //         var temp_var_bal = 0;
                //         if(Number(data[i].reported_qty) > 0)
                //         {
                //             status = '<font color="green">Partially Scanned</font>';
                //         }
                //         if(data[i].send_qty != 0 && Number(data[i].reported_qty) == 0)
                //         {
                //             status = '<font color="green">Scanning Pending</font>';
                //         }
                //         if(data[i].send_qty == 0)
                //         {
                //             status = '<font color="red">Previous Operation not done</font>';
                //         }
                //         if(data[i].send_qty != 0)
                //         {
                //             if(Number(data[i].reported_qty)+Number(data[i].rejected_qty) == data[i].send_qty)
                //             {
                //                 status = '<font color="red">Already Scanned</font>';
                //             }
                //         }
                        
                //         if(data[i].flag == 'packing_summary_input')
                //         {
                //             temp_var_bal = data[i].balance_to_report;
                //             $('#flag_validation').val(1);
                //         }
                //         s_no++;
                //         var test = '1';
                //         var markup1 = "<tr class="+hidden_class+"><td data-title='S.No'>"+s_no+"</td><td data-title='Status'>"+status+"</td><td class='none' data-title='Doc.No'>"+data[i].doc_no+"</td><td data-title='Color'>"+data[i].order_col_des+"</td><td data-title='module' id='"+i+"module'>"+data[i].assigned_module+"</td><input type='hidden' name='module[]' value = '"+data[i].assigned_module+"'><td data-title='Size'>"+data[i].size_code.toUpperCase()+"</td><td data-title='Input Job Quantity'>"+data[i].carton_act_qty+"</td><input type='hidden' name='old_size[]' value = '"+data[i].old_size+"'><td  data-title='Cumulative Reported Quantity'>"+data[i].reported_qty+"</td><td id='"+i+"remarks_validate_html'  data-title='Eligibility To Report'>"+temp_var_bal+"</td><td data-title='Reporting Qty'><input type='text' onkeyup='validateQty(event,this)'  class='form-control input-md twotextboxes' id='"+i+"reporting' onfocus='if($(this).val() == 0){$(this).val(``)}' onfocusout='if($(this).val() > 0){}else{$(this).val(0)}' value='"+temp_var_bal+"' required name='reporting_qty[]' onchange = 'validate_reporting_report("+i+") '"+readonly+"></td><td class="+hidden_class_for_remarks+">"+sampling+"</td><td class='"+hidden_class_sewing_in+"'>"+data[i].rejected_qty+"</td><td class='"+hidden_class_sewing_in+"'><input type='text' onfocus='if($(this).val() == 0){$(this).val(``)}' onfocusout='if($(this).val() > 0){}else{$(this).val(0)}' onkeyup='validateQty(event,this)' required value='0' class='form-control input-md twotextboxes' id='"+i+"rejections' name='rejection_qty[]' onchange = 'rejections_capture("+i+")' "+readonly+"></td><td class='hide'><input type='hidden' name='qty_data["+data[i].tid+"]' id='"+i+"qty_data'></td><td class='hide'><input type='hidden' name='reason_data["+data[i].tid+"]' id='"+i+"reason_data'></td><td class='hide'><input type='hidden' name='tot_reasons[]' id='"+i+"tot_reasons'></td><td class='hide'><input type='hidden' name='doc_no[]' id='"+i+"doc_no' value='"+data[i].doc_no+"'></td><td class='hide'><input type='hidden' name='colors[]' id='"+i+"colors' value='"+data[i].order_col_des+"'></td><td class='hide'><input type='hidden' name='sizes[]' id='"+i+"sizes' value='"+data[i].size_code+"'></td><td class='hide'><input type='hidden' name='job_qty[]' id='"+i+"job_qty' value='"+data[i].carton_act_qty+"'></td><td class='hide'><input type='hidden' name='tid[]' id='"+i+"tid' value='"+data[i].tid+"'></td><td class='hide'><input type='hidden' name='inp_job_ref[]' id='"+i+"inp_job_no' value='"+data[i].input_job_no+"'></td><td class='hide'><input type='hidden' name='a_cut_no[]' id='"+i+"a_cut_no' value='"+data[i].acutno+"'></td><td class='hide'><input type='hidden' name='old_rep_qty[]' id='"+i+"old_rep_qty' value='"+data[i].reported_qty+"'></td><td class='hide'><input type='hidden' name='old_rej_qty[]' id='"+i+"old_rej_qty' value='"+data[i].rejected_qty+"'></td></tr>";
                //         $("#dynamic_table1").append(markup1);
                //         $("#dynamic_table1").hide();
                //         if(data[i].flag != 'packing_summary_input')
                //         {
                //             if(remarks_check_flag == 1)
                //             {
                //                 remarks = 'Normal';
                //             }
                //             else
                //             {
                //                 remarks = 'Sample';
                //             }
                //             val=i;
                //             $('#loading-image').show();
                //             $('#flag_validation').val(0);
                //             validating_remarks_qty(val,remarks);
                //         }
				// 	}
				// 	var markup99 = "</tbody></table></div></div></div>";
				// 	$("#dynamic_table1").append(markup99);
				// 	$("#dynamic_table1").show();
				// 	$('#hid_job').val(doc_number);
                }
                $('#loading-image').hide();	
            }
		});	
});
</script>