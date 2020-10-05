<head>
	<script src="/sfcs_app/common/js/jquery-ui.js"></script>
</head>
<?php
	include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions_v2.php',5,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/enums.php',5,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/server_urls.php',5,'R'));
	$has_permission=haspermission($_GET['r']);


	if (in_array($override_sewing_limitation,$has_permission)) {
		$value = 'authorized';
	} else {
		$value = 'not_authorized';
	}
	
    echo '<input type="hidden" name="user_permission" id="user_permission" value="'.$value.'">';
    $dashboardRepFlag = 0;
    $menuRepFlag = 0;
    $scan_label = '';
    $job_type = '';
    $job_retrieval_url;
    $job_publish_url;
    // validate if the request is coming from manual reporting screen or from a dashboard
    if($_GET['manual_reporting']) {
        // manual reporting through menu either SEWING JOB or EMB JOB
        $operation_code = $_POST['operation_id'];
        $plant_code = $_POST['plant_code'];
        $username = $_POST['username'];
        $shift = $_POST['shift'];
        $job_type = $_POST['job_type'];
        $menuRepFlag = 1;
        $scan_mode = $_POST['scan_mode'];
    } else if($_GET['dashboard_reporting']) {
        // reporting from dashboard either IPS or EMB
        $operation_code = $_GET['operation_id'];
        $plant_code = $_GET['plant_code'];
        $username = $_GET['username'];
        $shift = $_GET['shift'];
        $job_no = $_GET['job_no'];
        $job_type = $_GET['job_type'];
        $dashboardRepFlag = 1;
        $scan_label = 'Sewing Job Number';
        $scan_mode = 1;
    }
    // var url = "sfcs_app/app/production/controllers/sewing_job/sewing_job_scaning/responses/res.json";
    if($job_type == OperationCategory::SEWING) {
        if($scan_mode == 0) {
            $scan_label = 'Scan Sewing bundle number';
            $job_retrieval_url = $PTS_SERVER_IP.'/fg-retrieving/getJobDetailsForBundleNumber';
            $job_publish_url = $PTS_SERVER_IP.'/fg-reporting/reportSemiGmtOrGmtBarcode';
        } else if($scan_mode == 1){
            $scan_label = 'Scan Sewing job number';
            $job_retrieval_url = $PTS_SERVER_IP.'/fg-retrieving/getJobDetailsForSewingJob';
            $job_publish_url = $PTS_SERVER_IP.'/fg-reporting/reportSemiGmtOrGmtJob';
        }
    } else if ($job_type == OperationCategory::EMBELLISHMENT){
        if($scan_mode == 0) {
            $scan_label = 'Scan Embellishment bundle number';
            $job_retrieval_url = $PTS_SERVER_IP.'/fg-retrieving/getJobDetailsForBundleNumber';
            $job_publish_url = $PTS_SERVER_IP.'/fg-reporting/reportPanelFormBarcode';
        } else if($scan_mode == 1){
            $scan_label = 'Scan Embellishment job number';
            $job_retrieval_url = $PTS_SERVER_IP.'/fg-retrieving/getJobDetailsForEmbJob';
            $job_publish_url = $PTS_SERVER_IP.'/fg-reporting/reportPanelFormJob';
        }
    } else {
		echo "<div style='color:red'><b>Only Embellishment and Sewing jobs are allowed to scan<b></div>";
		exit();
	}
    
    // get the operation name for the operation code
    $operation_query = "SELECT operation_name from $mdm.operations where operation_code = $operation_code and is_active=1";
    $operation_result = mysqli_query($link, $operation_query);
    while($row = mysqli_fetch_array($operation_result)) {
        $operation_name = $row['operation_name'];
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
?>


<body>
    <?php 
        // provide a go back button if the reporting is done through menu level
        if ($menuRepFlag) { 
            $revert_url = getFullURL($_GET['r'],'pre_input_job_scanning.php','N');
            echo "<button class='btn btn-sm btn-primary' onclick='location.href=\"$revert_url&job_type=$job_type\"' ><< Click here to go Back</button>";
        }
    ?>

	<div class="panel panel-primary"> 
		<input type="hidden" name="flag_validation" id='flag_validation'>
		<div class="panel-heading"><?= $scan_label ?></div>
		<div class='panel-body'>
			<div class="alert alert-success" style="display:none;">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<strong>Info! </strong><span class="sql_message"></span>
			</div>
			<center style='color:red;'><h3>Operation You Are Scanning Is &nbsp;<span style='color:green;'><?php echo $operation_code.'-'.$operation_name;?></span>&nbsp; On The Shift &nbsp;&nbsp;<span style='color:green;'><?php echo $shift;?> <span style='color:red;'></h3></center>
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
						<div class="form-group col-lg-6 col-sm-6">
							<label><?= $scan_label ?><span style="color:red"></span></label>
							<input type="text" id="job_number" value='<?= $input_job_no_random_ref ?>' class="form-control" required placeholder="Scan the Job..." <?php echo $read_only_job_no;?>/>
						</div>
						</br>
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
                <div class='panel-heading'>Job Info</div>
                <div class="ajax-loader" id="loading-image" style="margin-left: 45%;margin-top: 35px;border-radius: -80px;width: 88px;">
                    <img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
                </div>
                <div class='panel-body'>
                    <div id ="dynamic_table1">
                    </div>
                </div>
                </div>
            </div>
		
		</div>
	</div>
	<?php
		$reasons = getRejectionReasons($job_type);
	?>
	<div class="modal hideMe" tabindex="-1" role="dialog" id="rejections-modal">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Component Level Rejections</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body col-sm-12">
					<div class='col-sm-4'>
						<label for='rejection_code'>Reason</label> 
						<select class="form-control" palceholder='Please Select' name='rejection_code' id='rejection_code' style='width:100%'>
						<option disabled selected>Please Select</option>
						<?php
							foreach($reasons as $reason) {
								$reason_id = $reason['reason_id'];
								$reason_code = $reason['internal_reason_code'];
								$reason_desc = $reason['internal_reason_description'];
								echo "<option value='$reason_id'>$reason_code - $reason_desc</option>";
							}
						?>
						</select>
					</div>
					<div class='col-sm-4'>
						<label for='component'>Component</label> 
						<select class="form-control" palceholder='Please Select' name='component' id='component' style='width:100%'>
							<option disabled selected>Please Select</option>
							<option value='sleeve'>Sleeve</option>
							<option value='pocket'>Pocket</option>
							<option value='front'>Front</option>
							<option value='back'>Back</option>
						</select>
					</div>
					<div class='col-sm-2'>
						<label for='quantity' class='col-sm-4'>Quantity</label> 
						<input class="form-control" type='number' name='component_rej_qty' id='component_rej_qty' style='width:100%'/>
					</div>
					<div class='col-sm-2'>
						<label><br/></label>
						<button class='form-control btn btn-sm btn-info'  style='width:100%'
							onclick="pushRejReasonQty($('#rejection_code').val(), $('#rejection_code option:selected').text(), $('#component').val(), $('#component_rej_qty').val())">+ Add</button>
					</div>
				</div>
				<div class='col-sm-12'>
					<b>Summary</b>
					<table class='table table-bordered col-sm-10' id='rejection_summary_table'>
						<thead>
							<tr>
								<th>Component</th>
								<th>Reason</th>
								<th>quantity</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id='rejection_summary_table_body'>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" onclick="validateAndSaveRejections()">Save</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="cancelRejectionsModal()">Close</button>
				</div>
			</div>
		</div>
	</div>
</body>

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


<script>
	var currentSelectedRejIndex = -1;
	var globalRejectionQtysArray = [];
	const summaryRowKey = '_summary_record';
    var job_number = $('#job_number').val();
    var job_type = '<?= $job_type ?>';
    var operation_id = '<?= $operation_code ?>';
    var plant_code = '<?= $plant_code ?>';
    var username = '<?= $username ?>';
    var shift = '<? $shift ?>';
    var barcode_generation = <?= $scan_mode ?>;

	$(document).ready(function() {
        // if the reporting is done through dashboard then make the job no as readonly
        let isDashboardRep = Number(<?= $dashboardRepFlag ?>);

        $("#job_number").change(function(){
            $('#pre_pre_data').hide();
            $('#dynamic_table1').html('');
            $('#loading-image').show();
            job_number = $('#job_number').val();
            getJobInfo(job_number);
        });

        if (isDashboardRep) {
            let incomingJobNo = '<?= $job_no ?>';
            $('#job_number').val(incomingJobNo);
            $('#job_number').prop('readonly', true);
            $('#job_number').trigger('change');
        } else {
            $('#job_number').focus();
            $('#loading-image').hide();
        }
	});

    // gets the job info for the sewing or emb job 
    function getJobInfo(jobNo) {
        let inputObj;
        if(barcode_generation == 0) {
            inputObj = {"barcode":jobNo, "plantCode":plant_code, "operationCode":operation_id};
        } else if(barcode_generation == 1) {
            if (job_type == 'SEWING') {
                inputObj = {"sewingJobNo":jobNo, "plantCode":plant_code, "operationCode":operation_id};
            } else if (job_type == 'EMBELLISHMENT') {
                inputObj = {"embJobNo":jobNo, "plantCode":plant_code, "operationCode":operation_id};
            }	
        }
        $.ajax({
            type: "POST",
            url: '<?= $job_retrieval_url ?>',
            data: inputObj,
            success: function (res) {      
                $('#loading-image').hide();
                if (res.status) {
                    var data=res.data
                    tableConstruction(data);
                } else {
                    swal(res.internalMessage,'','error');
                    $('#loading-image').hide(); 
                }                       
            },
            error: function(res){
                $('#loading-image').hide();
                swal('Error','in getting job info','error');
            }
        });
    }

	function tableConstruction(data){
		var s_no = 0;
		if(data) {
			$('#dynamic_table1').html('');
			$('#module_div').hide();
			document.getElementById('style_show').innerHTML = data.style;
			document.getElementById('schedule_show').innerHTML = data.schedules;
			document.getElementById('color_show').innerHTML = data.fgColors.toString();
			var btn = '<div class="pull-right" id="smart_btn_arear"><input type="button" class="btn btn-primary submission" value="Submit" name="formSubmit" id="smartbtn" onclick="return reportJob();"><input type="hidden" id="count_of_data" value='+data.sizeQuantities.length+'></div>';
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
				var remarks_check_flag = 0;
				if(i==0)
				{
					var markup = "<div class='container'><div class='row'><div id='no-more-tables'><table class = 'col-sm-12 table-bordered table-striped table-condensed cf' id='dynamic_table'><thead class='cf'><tr><th>S.No</th><th class='none'>Doc.No</th><th>Color</th><th>Module</th><th>Size</th><th>Input Job Qty</th>"+op_codes_str+"<th>Cumulative Reported Quantity</th><th>Eligibility To Report</th><th>Reporting Quantity</th><th>Rejected Qty.</th><th>Recut In</th><th>Replace In</th><th>Rejection quantity</th></tr></thead><tbody>";
					$("#dynamic_table1").append(markup);
					$("#dynamic_table1").append(btn);
				}
				s_no++;
				var test = '1';
				var op_code_values = '';
				$.each(op_codes, function( index, value ) {
					op_code_values = op_code_values + '<td>'+data.sizeQuantities[i].operationWiseQuantity[index].quantity+'</td>';
				});
				var markup1 = "<tr><td data-title='S.No'>"+s_no+"</td><td class='none' data-title='Doc.No'>"+data.sizeQuantities[i].docketNo+"<input type='hidden' name='docketNo["+i+"]' id='"+i+"docketNo' value = '"+data.sizeQuantities[i].docketNo+"'></td><td data-title='Color'>"+data.sizeQuantities[i].fgColor+"<input type='hidden' name='fgColor["+i+"]' id='"+i+"fgColor' value = '"+data.sizeQuantities[i].fgColor+"'></td><td data-title='module'>"+data.sizeQuantities[i].resourceId+"<input type='hidden' name='module["+i+"]' id='"+i+"module' value = '"+data.sizeQuantities[i].resourceId+"'></td><td data-title='Size'>"+data.sizeQuantities[i].size+"<input type='hidden' name='size["+i+"]' id='"+i+"size' value = '"+data.sizeQuantities[i].size+"'></td><td data-title='Input Job Quantity'>"+data.sizeQuantities[i].inputJobQty+"<input type='hidden' name='inputJobQty["+i+"]' id='"+i+"inputJobQty' value = '"+data.sizeQuantities[i].inputJobQty+"'></td>"+op_code_values+"<td data-title='Cumulative Reported Quantity'>"+data.sizeQuantities[i].cumilativeReportedQty+"<input type='hidden' name='cumilativeReportedQty["+i+"]' id='"+i+"cumilativeReportedQty' value = '"+data.sizeQuantities[i].cumilativeReportedQty+"'></td><td id='"+i+"remarks_validate_html'  data-title='Eligibility To Report'>"+data.sizeQuantities[i].eligibleQty+"</td>\
				\<input type='hidden' id='"+i+"eligible_to_report' value='"+data.sizeQuantities[i].eligibleQty+"' /> \
				<td data-title='Reporting Qty'><input type='text' onkeyup='validateQty(event,this)' "+$('#good_report').val()+" class='form-control input-md twotextboxes' id='"+i+"reporting' name='reportedQty["+i+"] onfocus='if($(this).val() == 0){$(this).val(``)}' onfocusout='if($(this).val() > 0){}else{$(this).val(0)}' value='0' required name='reporting_qty["+i+"]' \
				onchange = 'validateEligibilityReportQty("+i+",\"reporting\") '></td><td>"+data.sizeQuantities[i].rejectedQty+"<input type='hidden' name='oldrejectedQty["+i+"]' id='"+i+"oldrejectedQty' value = '"+data.sizeQuantities[i].rejectedQty+"'></td><td>0</td><td>0</td>\
				<td>\
				\
				<input type='text' onfocus='if($(this).val() == 0){$(this).val(``)}' onfocusout='if($(this).val() > 0){}else{$(this).val(0)}' \
				onkeyup='validateQty(event,this)' required value='0' class='form-control input-md twotextboxes' id='"+i+"rejections' name='rejectedQty[]' \
				onchange = 'showRejectionsModalForIndex("+i+")' ></td>\
				\
				<td class='hide'><input type='hidden' name='qty_data["+i+"]' id='"+i+"qty_data'></td><td class='hide'><input type='hidden' name='reason_data["+i+"]' id='"+i+"reason_data'></td><td class='hide'><input type='hidden' name='tot_reasons[]' id='"+i+"tot_reasons'></td></tr>";
				$("#dynamic_table").append(markup1);
				$("#dynamic_table").hide();
			}
		}
		var markup99 = "</tbody></table></div></div></div>";
		$("#dynamic_table").append(markup99);
		$("#dynamic_table").show();
		$('#loading-image').hide();
	}
//////////////////////////////////////////////////////////////////////////

	// show the rejection modal for an index
	function showRejectionsModalForIndex(index) {
		// validate if the index is > -1 i.e enable rejections only when any of the size level rejected qtys are enetered
		if (index > -1) {
			let isQtyValid = validateEligibilityReportQty(index, 'rejections');
			if (!isQtyValid) {
				$(`#${index}rejections`).val(0);
				return;
			}
			currentSelectedRejIndex = index;
			globalRejectionQtysArray[currentSelectedRejIndex] = [];
			// ensure all the rejections captured under the current index are pushed appropriately to the savable object
			toggleModal(true);
		}
	}

	// close the rejection modal
	function cancelRejectionsModal() {
		// reset the value of the current rejection to 0
		resetCurrentRejQty(currentSelectedRejIndex);
		// reset the currentSelectedRejIndex to -1 again
		resetCurrentSelectedRejIndex(currentSelectedRejIndex);
		// remove all the stored rejections under the current index
		delete(globalRejectionQtysArray[currentSelectedRejIndex]);
		// close the modal
		toggleModal(false);
		removeSummaryTable();
	}

	// reset the current selected rejection index to -1
	function resetCurrentSelectedRejIndex() {
		currentSelectedRejIndex = -1;
	}

	// reset the current entered rejection qty of a size to 0
	function resetCurrentRejQty(index) {
		$(`#${index}rejections`).val(0);
	}

	// show or hide the modal
	function toggleModal(show) {
		if (show) {
			$('#rejections-modal').show();
		} else {
			$('#rejections-modal').hide();
		}
	}

	// validate the entered rejections and save if the info is valid
	function validateAndSaveRejections() {
		const rejQty = $(`#${currentSelectedRejIndex}rejections`).val();
		const isQtysValid = validateIfRejQtyFulfilled(rejQty, globalRejectionQtysArray[currentSelectedRejIndex], true);
		if (!isQtysValid) {
			getAlert('error', 'Component rejection quantity is not matching with actual rejection');
			return false;
		}
		// if rejections valid then close the modal
		toggleModal(false);
		// remove the table content
		removeSummaryTable();
	}

	// validates if the rejected qty against to the size is equal to the cumulative rej qtys of the any of the compnents 
	function validateIfRejQtyFulfilled(actualRejQty, compWiseRejectionsArray, equality = false) {
		let compLevelRej = new Map();
		for(let compRej of compWiseRejectionsArray) {
			if (compRej) {
				if (!compLevelRej.has(compRej.component)) {
					compLevelRej.set(compRej.component, 0);
				}
				let preQty = Number(compLevelRej.get(compRej.component));
				compLevelRej.set(compRej.component, preQty+compRej.reasonQty);
			}
		}
		// if the validaiton is done to verify whether the compnent level rejection didnt exceed the actual rej qty
		if (equality) {
			for (let compRej of compLevelRej) {
				if (compRej[1] == actualRejQty) {
					return true;
				}
			}
			return false;
		} else {
			for (let compRej of compLevelRej) {
				if (compRej[1] > actualRejQty) {
					return false;
				}
			}
			return true;
		}
		
	}

	// push the rejection ,reason and qty to the global rejections capturing object
	function pushRejReasonQty(rej_code, rej_text, component, quantity) {
		if (quantity <= 0 || !rej_code || !component) {
			getAlert('error', 'Select rejection reason, compnent and quantity');
			return false;
		}
		const rejQty = Number($(`#${currentSelectedRejIndex}rejections`).val());
		const lastIndexOfCurrSizeRejs = globalRejectionQtysArray[currentSelectedRejIndex].length;
		globalRejectionQtysArray[currentSelectedRejIndex][lastIndexOfCurrSizeRejs] = {
			reasonCode: rej_code,
			reasonQty: Number(quantity),
			component: component,
		}
		const isQtysValid = validateIfRejQtyFulfilled(rejQty, globalRejectionQtysArray[currentSelectedRejIndex], false);
		if (!isQtysValid) {
			getAlert('error', 'Component rejection quantity cannot exceed actual rejection');
			globalRejectionQtysArray[currentSelectedRejIndex].pop();
			return false;
		}
		// push the record into the array of rejections 
		const summaryRow = `<tr id='${lastIndexOfCurrSizeRejs+''+summaryRowKey}'><td>${component}</td><td>${rej_text}</td><td>${quantity}</td>
				<td><button onclick='popRejReasonQty(${lastIndexOfCurrSizeRejs})' class='btn btn-xs btn-danger'> X </button></td>
			</tr>`;
		$('#rejection_summary_table_body').append(summaryRow);
	}

	// remove the rejection, reason and qty from the table and also form the request object
	function popRejReasonQty(summaryTableRowIndex) {
		delete(globalRejectionQtysArray[currentSelectedRejIndex][summaryTableRowIndex]);
		// also remove the row from the table
		$(`#${summaryTableRowIndex+''+summaryRowKey}`).remove();
	}

	function removeSummaryTable() {
		$('#rejection_summary_table_body').html('');
	}


	// validtae if the sum(good + rej) is less than or equal to the eligible qty
	function validateEligibilityReportQty(index, key) {
		const goodQty = Number($(`#${index}reporting`).val());
		const rejQty = Number($(`#${index}rejections`).val());
		const eligibleQty = Number($(`#${index}eligible_to_report`).val());
		if ( (goodQty + rejQty) > eligibleQty) {
			getAlert('error', 'Good qty and rejection qty should not exceed eligible qty');
			$(`#${index}${key}`).val(0);
			return false;
		}
		return true;
	}

	function getAlert(mode, message) {
		sweetAlert('', message, mode);
	}


/////////////////////////////////////////////////////////////////////

</script>

<script>
	function reportJob(){
		$('#smartbtn').attr('disabled', 'disabled');
		$('#loading-image').show();
		var count = document.getElementById('count_of_data').value;
		var tot_qty = 0;
		var tot_rej_qty = 0;
		var reportData = new Object();
		reportData.plantCode = plant_code;
		reportData.shift = shift;
		reportData.operationCode = operation_id;
		reportData.createdUser = username;
        // bundle level reporting
		if(barcode_generation == 0) {
			let reportingQty = $('#0reporting').val();
			let rejectedQty = $('#0rejections').val();
			reportData.barcode = $('#job_number').val();
			reportData.quantity = reportingQty;
			reportData.reportAsFullGood = false;
			tot_qty += Number(reportData.quantity);
			if (rejectedQty > 0) {
				reportData.rejectedQuantity = rejectedQty;
				reportData.rejectionDetails = globalRejectionQtysArray[0];
			}
        // job level reporting
		} else {
			reportData.jobNo = $('#job_number').val();
			var sizeQuantities = new Array();
			for(var i=0; i<count; i++)
			{
				let reportingQty = $('#'+i+'reporting').val();
				let rejectedQty = $('#'+i+'rejections').val();
				tot_qty += Number(reportingQty);
				var sizeQuantitiesObject = new Object();
				sizeQuantitiesObject.size = $('#'+i+'size').val();
				sizeQuantitiesObject.module = $('#'+i+'module').val();
				sizeQuantitiesObject.fgColor =$('#'+i+'fgColor').val();
				sizeQuantitiesObject.reportedQty = reportingQty;
				if (rejectedQty > 0) {
					sizeQuantitiesObject.rejectedQty = rejectedQty;
					sizeQuantitiesObject.rejectionDetails = globalRejectionQtysArray[i];
				}
				sizeQuantities.push(sizeQuantitiesObject);
			}
			reportData.sizeQuantities = sizeQuantities;
		}
		for(var i=0; i<count; i++)
		{
			var variable_rej = i+"rejections";
			var qty_rej_cnt = document.getElementById(variable_rej).value;
			tot_rej_qty += Number(qty_rej_cnt);
		}
		if(Number(tot_qty) <= 0 && Number(tot_rej_qty) <= 0)
		{
			$('#smartbtn').attr('disabled', false);
			sweetAlert("Please enter atleast one size quantity","","warning");
			return false;
		}
		else {
			$('.submission').hide();
			$('#flag_validation').val(0);
			$('#smart_btn_arear').hide();
			$.ajax({
				type: "POST",
				url: '<?= $job_publish_url ?>',
				data:  JSON.stringify(reportData),
				contentType: "application/json; charset=utf-8",
				dataType: "json",
				success: function (res) {            
					if(res.status){
						$('#dynamic_table1').html('');
						$('#loading-image').hide();
						document.getElementById('dynamic_table1').innerHTML = '';
						document.getElementById('style_show').innerHTML = '';
						document.getElementById('schedule_show').innerHTML = '';
						document.getElementById('color_show').innerHTML = '';
						document.getElementById('job_number').value = '';
						document.getElementById('pre_data').innerHTML ='';
						swal('',res.internalMessage,'success');
						var data = res.data;
                        // if the job type is emb, then construct the response table by just using the input available data
                        if (job_type == '<?= OperationCategory::EMBELLISHMENT ?>' ) {
                            constructAndShowEMBResponseTable(reportData);
                        } else if (job_type == '<?= OperationCategory::SEWING ?>') {
                            constructAndShowSJResponseTable(data);
                        }
					}else{
						$('#smartbtn').attr('disabled', false);
						$('.submission').show();
						swal('',res.internalMessage,'error');
					}
				},
				error: function(res){
					$('.submission').show();
					$('#loading-image').hide(); 
					swal('','Network error','error');
				}
			});
			
		}
		
	}

    function constructAndShowSJResponseTable(responseData) {
        const data = responseData;
        var table_data = "<div class='container'><div class='row'><div id='no-more-tables'><table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Bundle Number</th><th>Color</th><th>Size</th><th>Reporting Qty</th></tr></thead><tbody>";
        if(barcode_generation == 0) {
            table_data += "<tr><td>"+data.bundleBrcdNumber+"</td><td>"+data.fgColor+"</td><td>"+data.size+"</td><td>"+data.reportedQuantity+"</td></tr>";
        } else{
            for(var z=0; z<data.length; z++){
                if(data[z].reportedQuantity > 0) {
                    table_data += "<tr><td>"+data[z].bundleBrcdNumber+"</td><td>"+data[z].fgColor+"</td><td>"+data[z].size+"</td><td>"+data[z].reportedQuantity+"</td></tr>";
                }
            }
        }
        table_data += "</tbody></table></div></div></div>";
        document.getElementById('pre_data').innerHTML = table_data;
        $('.progress-bar').css('width', 100+'%').attr('aria-valuenow', 80);
        $('.progress').hide();
        $('#smart_btn_arear').show();
        $('#pre_pre_data').show();
    }

    function constructAndShowEMBResponseTable(responseData) {

    }

</script>

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
	.hideMe {
		display: none;
	}
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
