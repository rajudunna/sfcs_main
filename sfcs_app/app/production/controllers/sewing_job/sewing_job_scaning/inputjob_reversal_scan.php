
<?php
	include(getFullURLLevel($_GET['r'],'/common/config/config.php',5,'R'));
	include(getFullURLLevel($_GET['r'],'/common/config/server_urls.php',5,'R'));

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
	//API related data
	// $plant_code = $global_facility_code;
	$company_num = $company_no;
	$host= $api_hostname;
	$port= $api_port_no;
	$current_date = date('Y-m-d h:i:s');
	$shift=$_GET['shift'];
	
	echo '<input type="hidden" name="plant_code" id="plant_code" value="'.$plant_code.'">';
	if(isset($_POST['id']))
	{
		echo "<h1 style='color:red;'>Please Wait a while !!!</h1>";
	}
	$username=$_SESSION['userName'];
?>
<body id='main'> 
	<div class="panel panel-primary"> 
		<div class="panel-heading">Sewing Jobs Reversal Scanning</div>
		<div class='panel-body'>
			<style>
				table, th, td {
					text-align: center;
				}
				#loading-image{
					position:fixed;
					top:0px;
					right:0px;
					width:100%;
					height:100%;
					background-color:#666;
					/* background-image:url('ajax-loader.gif'); */
					background-repeat:no-repeat;
					background-position:center;
					z-index:10000000;
					opacity: 0.4;
					filter: alpha(opacity=40); /* For IE8 and earlier */
				}
			</style>
			<div class="ajax-loader" id="loading-image" style="display: none">
				<center><img src='<?= getFullURLLevel($_GET['r'],'common/images/ajax-loader.gif',3,'R'); ?>' class="img-responsive" style="padding-top: 250px"/></center>
			</div>
			<div class="alert alert-success" style="display:none;">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<strong>Info! </strong><span class="sql_message"></span>
			</div>
			<div class='row'>
				<div class="form-group col-md-3">
					<label>Sewing Job Number:<span style="color:red">*</span></label>
					<input type="text"  id="job_number" class="form-control" required placeholder="Scan the Job..."/>
				</div>
				<div class='form-group col-md-3'>
					<label>Remarks:<span style="color:red">*</span></label>
					<select class='form-control sampling' name='sampling' id='sampling' style='width:100%;' required>	
					<option value="" disabled>Select Remarks</option>			
					</select>
				</div>
				<div class="form-group col-md-3">
					<label for="title">Select Module:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
					<select class="form-control select2" required name="module" id="module">
						<option value="" disabled>Select Module</option>
					</select>
				</div>
				<div class="form-group col-md-3">
					<label for="title">Select Operation:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
						<select class="form-control select2" required name="operation" id="operation">
							<option value="0" disabled>Select Operation</option>
						</select>
				</div>
			</div>
		</div>
	</div>
	<div class='panel panel-primary'>
			<div class='panel-heading'>Job Data</div>
			<form action="index.php?r=<?php echo $_GET['r']?>" name= "smartform" method="post" id="smartform">
				<input type='hidden' value='<?= $shift ?>' id='shift_val' name='shift_val'>
				<div class='panel-body' id="dynamic_table_panel">	
						<div id ="dynamic_table1">
				</div>
				</div>
			</form>
			</div>
</body>

<script>
	$(document).ready(function() 
	{
		$('#job_number').focus();
		$('#loading-image').hide();
		var url = "<?php echo getFullURL($_GET['r'],'functions_scanning_ij.php','R'); ?>";
		$("#job_number").change(function()
		{
			$('#loading-image').show();
			var job_number = $("#job_number").val();
			var plant_code = $("#plant_code").val();
			$('#operation').empty();
			$('#module').empty();
			$('select[name="operation"]').append('<option value="0" selected="selected">Select Operation</option>');
			$('select[name="module"]').append('<option value="0">Select Module</option>');
			$('#dynamic_table1').html('');
			$.ajax({
				type: "POST",
				url: url+"?job_number="+job_number+"&plant_code="+plant_code,
				dataType: 'JSON',
				success: function (response) 
				{
					console.log(response);
					$('#loading-image').hide();

					// {	
					//	"workstation_id":"3add6c4a-fdde-4dfa-b665-17adc2723e55",
					// 	"sew_job_type":"Normal",
					// 	"workstaiton_desc":"cuttable1",
					// 	"operations":{"130":"SEWINGOUT - 130"},
					// 	"mp_number":"46e49155-547d-493a-bfa6-517855f5446f"
					// }
					if (!response['workstation_id'] || !response['sew_job_type'] || !response['workstaiton_desc']) {
						swal('','Sewing job info not found', 'error');
					}
					if (!response['operations']) {
						swal('','No operations found for the sewing job', 'error');
					}
					if(response['workstation_id']){
						$('select[name="module"]').append('<option value="'+ response['workstation_id'] +'" selected>'+ response['workstaiton_desc']  +'</option>');
					}
					
					if(response['sew_job_type']){
						$('select[name="sampling"]').append('<option value="'+ response['sew_job_type'] +'" selected>'+ response['sew_job_type']  +'</option>');
					}
					
					$.each(response['operations'], function (opCode, opDesc) {
						$('select[name="operation"]').append('<option value="'+ opCode +'">'+ opDesc  +'</option>');
					});
					
				},
				error: function(error) {
					$('#loading-image').hide();
					swal('','Unable to load sewing job info', 'error');
				}
			});
			
		});


		$('#operation').change(function()
		{
			$('#loading-image').show();
			$('#dynamic_table1').html('');
			var operation = $('#operation').val();
			var job_no = $('#job_number').val();
			var remarks = $('#sampling option:selected').text();
			var module1 = $('#module').val();
			if (module1 == 0){
				sweetAlert('Please Select Module','','warning');
				$('#operation option').prop('selected', function() {
					return this.defaultSelected;
				});
				$('#dynamic_table1').html('No Data Found');
			} else if (operation == 0) {
				sweetAlert('Please Select Valid Operation','','warning');
				$('#dynamic_table1').html('No Data Found');
			} else {
				var getReversalJobInfoUrl = '<?= $PTS_SERVER_IP.'/fg-retrieving/getJobDetailsForSewingJobReversal' ?>';
				var reverseObj = {sewingJobNo: job_no, plantCode: '<?= $plant_code ?>', operationCode: operation};
				// var reverseObj = [job_no,plant_code,ops,module1];
				$.ajax({
					type: "POST",
					url: getReversalJobInfoUrl,
					data: reverseObj,
					success: function (response) {
						if(response['status'])
						{
							$('#loading-image').hide();
							var data = response['data'];
							var s_no=0;
							var btn = '<div class="pull-right"><input type="button" class="btn btn-primary disable-btn smartbtn submission" value="Submit" name="formSubmit" id="smartbtn" onclick="check_pack();"><input type="hidden" id="count_of_data" value='+data['sizeQuantities'].length+'></div>';
							$("#dynamic_table1").append(btn);
							var markup = "<table class = 'table table-bordered' id='dynamic_table'>\
							<tbody><thead><tr class='info'><th>S.No</th><th>Style</th><th>Color</th><th>Module</th><th>Size</th>\
							<th>Sewing Job Qty</th><th>Reported Quantity</th><th>Eligible to reverse</th><th>Reversing Quantity</th></tr></thead><tbody>";
							$("#dynamic_table1").append(markup);
							$("#dynamic_table1").append(btn);
							for(var i=0;i<data['sizeQuantities'].length;i++)
							{
								s_no++;
								var markup1 = "<tr>\
								<input type='hidden' name='operation_id' value='"+data['sizeQuantities'][i]['operationCode']+"'>\
								<input type='hidden' name='remarks' value='"+data['sizeQuantities'][i]['status']+"'>\
								<input type='hidden' id='"+i+"fgColor' name='color[]' value='"+data['sizeQuantities'][i]['fgColor']+"'>\
								<input type='hidden' id='"+i+"size' name='size[]' value='"+data['sizeQuantities'][i]['size']+"'>\
								<input type='hidden' name='size_id[]' value='"+data['sizeQuantities'][i]['size']+"'>\
								<input type='hidden' name='input_job_no_random' value='"+job_no+"'>\
								<input type='hidden' name='style' value='"+data['style']+"'>\
								<input type='hidden' name='color[]' value='"+data['fgColors']+"'>\
								<input type='hidden' name='module[]' value='"+data['sizeQuantities'][i]['resourceId']+"'>\
								<input type='hidden' name='rep_qty[]' value='"+data['sizeQuantities'][i]['cumilativeReportedQty']+"'>\
								<td>"+s_no+"</td><td>"+data.style+"</td>\
								<td>"+data['sizeQuantities'][i]['fgColor']+"</td><td>"+data['sizeQuantities'][i]['resourceId']+"</td>\
								<td>"+data['sizeQuantities'][i]['size']+"</td><td>"+data['sizeQuantities'][i]['inputJobQty']+"</td>\
								<td>"+data['sizeQuantities'][i]['cumilativeReportedQty']+"</td>\
								<td id='"+i+"repor'>"+data['sizeQuantities'][i]['eligibleQty']+"</td>\
								<td><input class='form-control integer' onkeyup='validateQty(event,this)' name='reversalval[]' value='0' id='"+i+"rever' onchange = 'validation("+i+")'></td></tr>";
								$("#dynamic_table").append(markup1);
							}
						} else {
							sweetAlert(restrict_msg,'','error');
							$('#dynamic_table1').html('No Data Found');
							$('#loading-image').hide();
						}
					}
				});
			}
		});
	});

	$('#sampling').change(function()
	{
		$('#dynamic_table1').html('');
		$('#dynamic_table1').html('No Data Found');
		$('#operation').val(0);
		$('#module').val(0);
	});

	$('#module').change(function()
	{
		$('#dynamic_table1').html('');
		$('#operation').val(0);
	});

	function validation(id)
	{
		var rep = id+'repor';
		var rev = id+"rever";
		var reported_qty_validation = document.getElementById(rep).innerHTML;
		var reverting_qty = document.getElementById(rev).value;
		if(Number(reported_qty_validation) < Number(reverting_qty))
		{
			sweetAlert('','You are reversing more than Eligiblity.','error');
			document.getElementById(rev).value = 0;
		}
	}

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
		
	function check_pack()
	{
		$('#smartbtn').attr('disabled', 'disabled');
		
		var count = document.getElementById('count_of_data').value;
		var rejectReportData = new Object();
		// reportData.sewingJobNo = $('#job_number').val();
		rejectReportData.jobNo = $('#job_number').val();
		rejectReportData.plantCode = $('#plant_code').val();
		rejectReportData.shift = $('#shift_val').val();
		rejectReportData.operationCode = $('#operation').val();
		rejectReportData.createdUser = '<?= $username ?>';
		var sizeQuantities = new Array();
		for(var i=0; i<count; i++)
		{
			var sizeQuantitiesObject = new Object();
			sizeQuantitiesObject.size = $('#'+i+'size').val();
			sizeQuantitiesObject.module = $('#'+i+'module').val();
			// sizeQuantitiesObject.fgColor =$('#mapped_color').val();
			sizeQuantitiesObject.fgColor =$('#'+i+'fgColor').val();
			sizeQuantitiesObject.reportedQty = $('#'+i+'rever').val();
			sizeQuantities.push(sizeQuantitiesObject);
		}
		rejectReportData.sizeQuantities = sizeQuantities;
		var seveSewJobReversalUrl = '<?= $PTS_SERVER_IP.'/fg-reporting/reportSemiGmtOrGmtJobReversal' ?>';
		$.ajax({
			type: "POST",
			url: seveSewJobReversalUrl,
			data: rejectReportData,
			success: function(res) 
			{
				console.log('response came');
				if (res.status) {
					swal('',res.internalMessage,'success');
				} else {
					swal('',res.internalMessage,'error');
				}
				location.reload();	
			},
			error: function(response){
				swal('','Network Error','error');
			}
		});
		$('#smartbtn').attr('disabled', false);
		$('.submissiaon').hide();
	}

</script>



