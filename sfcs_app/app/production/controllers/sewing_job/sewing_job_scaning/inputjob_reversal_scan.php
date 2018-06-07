<?php
include(getFullURLLevel($_GET['r'],'/common/config/config.php',5,'R'));

if(isset($_POST['id']))
{
	//echo "<script>document.getElementById('main').hidden = true</script>";
	echo "<h1 style='color:red;'>Please Wait a while !!!</h1>";
	//echo "<script>document.getElementById('message').innerHTML='<b>Please wait a while</b>'</script>";
}
?>
<body id='main'> 
	<div class="panel panel-primary"> 
		<div class="panel-heading">Input Jobs Reversal Scanning</div>
		<div class='panel-body'>
			<div class="alert alert-success" style="display:none;">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<strong>Info! </strong><span class="sql_message"></span>
			</div>
			<div class='row'>
				<div class="form-group col-md-3">
					<label>Input Job Number:<span style="color:red">*</span></label>
					<input type="text"  id="job_number" class="form-control" required placeholder="Scan the Job..."/>
				</div>
				<div class='form-group col-md-3'>
					<label>Remarks:<span style="color:red">*</span></label>
					<select class='form-control sampling' name='sampling' id='sampling' style='width:100%;' required><option value='Normal' selected>Normal</option><option value='sample'>Sample</option><option value='shipment_sample'>Shipment Sample</option></select>
				</div>
				<div class="form-group col-md-3">
						<label for="title">Select Operation:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
							<select class="form-control select2" required name="operation" id="operation">
								<option value="0">Select Operation</option>
							</select>
				</div>
			</div>
		</div>
	</div>
	<div class='panel panel-primary'>
			<div class='panel-heading'>Job Data</div>
			<form action="index.php?r=<?php echo $_GET['r']?>" name= "smartform" method="post" id="smartform">
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
	var function_text = "<?php echo getFullURL($_GET['r'],'functions_scanning_ij.php','R'); ?>";
	$("#job_number").change(function()
	{
		var job_rev_no = $("#job_number").val();
		
		//var job_rev_no = [job_rev_no,remarks];
		$.ajax
		({
			type: "POST",
			url: function_text+"?job_rev_no="+job_rev_no,
			dataType: 'Json',
			success: function (response) 
			{
				if(response['status'])
				{
					sweetAlert('',response['status'],'error');
				}
				else
				{
					$.each(response, function(key, value) {
					$('select[name="operation"]').append('<option value="'+ key +'">'+ value +'</option>');
					});
				}
				
			}
			
		});
	});
	$('#operation').change(function()
	{
		var ops = $('#operation').val();
		var job_no = $('#job_number').val();
		var remarks = $('#sampling option:selected').text();
		var data_rev = [ops,job_no,remarks];
		$.ajax
		({
			type: "POST",
			url: function_text+"?data_rev="+data_rev,
			dataType: "json",
			success: function (response) 
			{
				$('#dynamic_table1').html('');
				console.log(response);
				var data = response['table_data'];
				if(response['post_ops'])
				{
					var post_ops_data = response['post_ops'];
					var send_qty = response['send_qty'];
					for(var ops=0;ops<post_ops_data.length;ops++)
					{
						// console.log(response['post_ops'][ops]);
						var mark1 = "<input type='hidden' name='post_ops[]' value='"+response['post_ops'][ops]+"'>";
						var mark2 = "<input type='hidden' name='send_qty[]' value='"+response['send_qty'][ops]+"'>";
						$("#dynamic_table1").append(mark1);
						$("#dynamic_table1").append(mark2);
					}
				}
				if(response['ops_dep'])
				{
					var mark3="<input type='hidden' name='ops_dep' value='"+response['ops_dep']+"'>";
					$("#dynamic_table1").append(mark3);
				}
				var send_qty = response['send_qty'];
				if(response['status'])
				{
					sweetAlert('',response['status'],'error');
					$('#dynamic_table1').html('No Data Found');
				}
				else if(data)
				{
					var s_no=0;;
					var btn = '<div class="pull-right"><input type="submit" class="btn btn-primary disable-btn smartbtn submission" value="Submit" name="formSubmit" id="smartbtn" onclick="validating();"></div>';
					$("#dynamic_table1").append(btn);
					var markup = "<table class = 'table table-bordered' id='dynamic_table'><tbody><thead><tr><th>S.No</th><th class='none'>Doc.No</th><th>Color</th><th>Size</th><th>Input Job Qty</th><th>Reported Quantity</th><th>Reversing Quantity</th></tr></thead><tbody>";
					$("#dynamic_table1").append(markup);
					$("#dynamic_table1").append(btn);
					for(var i=0;i<data.length;i++)
					{
						s_no++;
				var markup1 = "<tr><input type='hidden' name='doc_no[]' value='"+data[i].doc_no+"'><input type='hidden' name='operation_id' value='"+data[i].operation_id+"'><input type='hidden' name='remarks' value='"+data[i].remarks+"'><input type='hidden' name='size[]' value='"+data[i].size_code+"'><input type='hidden' name='bundle_no[]' value='"+data[i].tid+"'><input type='hidden' name='style' value='"+data[i].style+"'><input type='hidden' name='color' value='"+data[i].order_col_des+"'><input type='hidden' name='rep_qty[]' value='"+data[i].reported_qty+"'><input type='hidden' name='id[]' value="+data[i].id+"><td>"+s_no+"</td><td class='none'>"+data[i].doc_no+"</td><td>"+data[i].order_col_des+"</td><td>"+data[i].size_code+"</td><td>"+data[i].carton_act_qty+"</td><td id='"+i+"repor'>"+data[i].reported_qty+"</td><td><input class='form-control integer' onkeyup='validateQty(event,this)' name='reversalval[]' id='"+i+"rever' onchange = 'validation("+i+")'></td></tr>";
						$("#dynamic_table").append(markup1);
					}
				}
				
			}
			
		});
		
	});
	
});

$('#sampling').change(function()
{
	$('#dynamic_table1').html('');
	$('#dynamic_table1').html('No Data Found');
	$('#operation').val(0);
})
</script>

<script>

function validation(id)
	{
		var rep = id+'repor';
		var rev = id+"rever";
		console.log(rev);
		var reported_qty_validation = document.getElementById(rep).innerHTML;
		var reverting_qty = document.getElementById(rev).value;
		if(Number(reported_qty_validation) < Number(reverting_qty))
		{
			sweetAlert('','You are reversing more than reported quantity.','error');
			document.getElementById(rev).value = 0;
		}
	}
</script>
<?php
if(isset($_POST['formSubmit']))
{
	$ids = $_POST['id'];
	$reversalval = $_POST['reversalval'];
	$rep_qty = $_POST['rep_qty'];
	$ops_dep = $_POST['ops_dep'];
	$style = $_POST['style'];
	$color = $_POST['color'];
	$bundle_no = $_POST['bundle_no'];
	$size = $_POST['size'];
	$doc_no = $_POST['doc_no'];
	$operation_id = $_POST['operation_id'];
	$remarks = $_POST['remarks'];
	//var_dump($ops_dep);
	if($_POST['post_ops'])
	{
		$post_code = $_POST['post_ops'];
	}
	//var_dump($bundle_no);
	foreach($ids as $key=>$value)
	{
		$fetching_id_qry = "select id,recevied_qty from $brandix_bts.bundle_creation_data where bundle_number = $bundle_no[$key] and operation_id = $operation_id";
		$result_fetching_id_qry = $link->query($fetching_id_qry)  or exit('query error in updating1');
		while($row = $result_fetching_id_qry->fetch_assoc()) 
		{
			$id = $row['id'];
			$rec_qty = $row['recevied_qty'];
		}
		$act_rec_qty = $rec_qty - $reversalval[$key];
		$update_present_qry = "update $brandix_bts.bundle_creation_data  set recevied_qty = $act_rec_qty where id = $id";
		$result_query = $link->query($update_present_qry) or exit('query error in updating2');
		if($post_code)
		{
			$update_post_ops_code_qry = "update $brandix_bts.bundle_creation_data set send_qty = $act_rec_qty where id=$post_code[$key]";
			//echo $update_post_ops_code_qry;
			$result_query_post = $link->query($update_post_ops_code_qry) or exit('query error in updating3');
		}
	}
	if($ops_dep != 0)
	{
		$dep_ops_array_qry_raw = "select operation_code from $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$color' and ops_dependency='$ops_dep'";
		//echo $dep_ops_array_qry_raw;
		$result_dep_ops_array_qry_raw = $link->query($dep_ops_array_qry_raw) or exit('query error in updating 4');
		while($row = $result_dep_ops_array_qry_raw->fetch_assoc()) 
		{
			$dep_ops_codes[] = $row['operation_code'];	
		}
	}
	//var_dump($dep_ops_codes);
	if($dep_ops_codes != null)
	{
		//echo "working";
		foreach($bundle_no as $key=>$value)
		{
			$pre_send_qty_qry = "select min(recevied_qty)as recieved_qty from $brandix_bts.bundle_creation_data where bundle_number ='".$bundle_no[$key]."' and operation_id in (".implode(',',$dep_ops_codes).")";
			//echo $pre_send_qty_qry;
			$result_pre_send_qty = $link->query($pre_send_qty_qry) or exit('query error in updating 5');
			while($row = $result_pre_send_qty->fetch_assoc()) 
			{
				$pre_recieved_qty = $row['recieved_qty'];
			}
			$query_post_dep = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$pre_recieved_qty."', `scanned_date`='". date('Y-m-d')."' where bundle_number ='".$bundle_no[$key]."' and operation_id = ".$ops_dep;
			//echo $query_post_dep;
			$result_query = $link->query($query_post_dep) or exit('query error in updating6');
			
		}
	}
	//echo "workings";
	foreach($ids as $key=>$value)
	{
		//echo "working";
		$retriving_data = "select * from $brandix_bts.bundle_creation_data where bundle_number = $bundle_no[$key] and operation_id = $operation_id";
	//	echo $retriving_data;
		$result_retriving_data = $link->query($retriving_data) or exit('query error in updating 7');
		while($row = $result_retriving_data->fetch_assoc()) 
		{
			$b_style = $row['style'];
			$b_schedule = $row['schedule'];
			$b_op_id = $row['operation_id'];
			$b_job_no =  $row['input_job_no_random_ref'];
			$b_module = $row['assigned_module'];
			$b_shift = $row['shift'];
			$sfcs_smv = $row['sfcs_smv'];
			//$b_op_name = $row['m3_ops_des'];
			$b_inp_job_ref = $row['input_job_no'];
			$size_id = $row['size_id'];
			$b_in_job_qty = $row['original_qty'];
			$b_a_cut_no = $row['cut_number'];
		}
		$ops_name_qry = "select operation_name from $brandix_bts.tbl_orders_ops_ref where operation_code = $b_op_id";
		$result_ops_name_qry = $link->query($ops_name_qry) or exit('query error in updating 8');
		//var_dump($result_ops_name_qry);
		while($row_ops = $result_ops_name_qry->fetch_assoc()) 
		{
			//var_dump()
			$b_op_name = $row_ops['operation_name'];
		}
		//echo $b_op_name;
		$b_colors = $color;
		$b_sizes = $size[$key];
		$b_doc_num = $doc_no[$key];
		$r_qty_array = '-'.$reversalval[$key];
		$b_tid = $bundle_no[$key];
		$m3_bulk_bundle_insert = "INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_reason,sfcs_remarks,sfcs_log_user,m3_op_code,sfcs_job_no,sfcs_mod_no,sfcs_shift,m3_op_des,sfcs_tid_ref,m3_error_code) VALUES";
		$m3_bulk_bundle_insert .= '("'.date('Y-m-d').'","'.$b_style.'","'. $b_schedule.'","'.$b_colors.'","'. $size_id.'","'. $b_sizes.'","'.$b_doc_num.'","'.$r_qty_array.'","","'.$remarks.'","'.$username.'","'. $b_op_id.'","'.$b_job_no.'","'.$b_module.'","'.$b_shift.'","'.$b_op_name.'","'.$b_tid.'",""),';
		//echo $m3_bulk_bundle_insert;
		if(substr($m3_bulk_bundle_insert, -1) == ',')
		{
			$final_query100 = substr($m3_bulk_bundle_insert, 0, -1);
		}
		else
		{
			$final_query100 = $m3_bulk_bundle_insert;
		}
		$dep_ops_array_qry = "select default_operration from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$b_colors' and operation_code='$b_op_id'";
		$result_dep_ops_array_qry = $link->query($dep_ops_array_qry);
		while($row = $result_dep_ops_array_qry->fetch_assoc()) 
		{
			$is_m3 = $row['default_operration'];
		}
		if($is_m3 == 'Yes')
		{
			$rej_insert_result100 = $link->query($final_query100) or exit('data error');
		}
		$bulk_insert_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`) VALUES";
		$bulk_insert_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors.'","'.$size_id.'","'. $b_sizes.'","'. $sfcs_smv.'","'.$b_tid.'","'.$b_in_job_qty.'","'.$b_in_job_qty.'","'.$r_qty_array.'","0","0","'. $b_op_id.'","'.$b_doc_num.'","'.date('Y-m-d').'","'.$b_a_cut_no.'","'.$b_inp_job_ref.'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$remarks.'"),';
		//echo $bulk_insert_temp;
		if(substr($bulk_insert_temp, -1) == ',')
		{
				$final_query_000_temp = substr($bulk_insert_temp, 0, -1);
		}
		else
		{
				$final_query_000_temp = $bulk_insert_temp;
		}
		$bundle_creation_result_temp = $link->query($final_query_000_temp) or exit('query error in updating 8');
	}
	$url = '?r='.$_GET['r'];
	echo "<script>window.location = '".$url."'</script>";
}

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
		
	function validating()
	{
		console.log("working");
		//document.getElementByClassName('submission').style.visibility = 'hidden';
		$('.submission').hide();
	}

    </script>
	
	
	