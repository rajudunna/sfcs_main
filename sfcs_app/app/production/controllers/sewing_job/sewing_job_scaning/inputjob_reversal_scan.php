<?php
include(getFullURLLevel($_GET['r'],'/common/config/config.php',5,'R'));
$has_permission=haspermission($_GET['r']);

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
					<select class='form-control sampling' name='sampling' id='sampling' style='width:100%;' required><option value='Normal' selected>Normal</option><option value='sample'>Sample</option><option value='Shipment_Sample'>Shipment_Sample</option></select>
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
				var check_flag = 0;
				if(response['post_ops'])
				{
					var post_ops_data = response['post_ops'];
					var send_qty = response['send_qty'];
					if(response['rec_qtys'])
					{
						var post_rec_qtys_array = response['rec_qtys'];
						var check_flag = 1;
					}
				  
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
					var markup = "<table class = 'table table-bordered' id='dynamic_table'><tbody><thead><tr><th>S.No</th><th class='none'>Doc.No</th><th>Color</th><th>Size</th><th>Input Job Qty</th><th>Reported Quantity</th><th>Eligible to reverse</th><th>Reversing Quantity</th></tr></thead><tbody>";
					$("#dynamic_table1").append(markup);
					$("#dynamic_table1").append(btn);
					for(var i=0;i<data.length;i++)
					{
						console.log(data[i].reported_qty);
							if(check_flag == 0)
							{
								var post_rec_qtys = data[i].reported_qty;
							}
							else{
								var post_rec_qtys = Number(data[i].reported_qty) - Number(post_rec_qtys_array[i]);
							}
							s_no++;
							var markup1 = "<tr><input type='hidden' name='doc_no[]' value='"+data[i].doc_no+"'><input type='hidden' name='operation_id' value='"+data[i].operation_id+"'><input type='hidden' name='remarks' value='"+data[i].remarks+"'><input type='hidden' name='size[]' value='"+data[i].size_code+"'><input type='hidden' name='bundle_no[]' value='"+data[i].tid+"'><input type='hidden' name='style' value='"+data[i].style+"'><input type='hidden' name='color' value='"+data[i].order_col_des+"'><input type='hidden' name='rep_qty[]' value='"+data[i].reported_qty+"'><input type='hidden' name='id[]' value="+data[i].id+"><td>"+s_no+"</td><td class='none'>"+data[i].doc_no+"</td><td>"+data[i].order_col_des+"</td><td>"+data[i].size_code+"</td><td>"+data[i].carton_act_qty+"</td><td>"+data[i].reported_qty+"</td><td id='"+i+"repor'>"+post_rec_qtys+"</td><td><input class='form-control integer' onkeyup='validateQty(event,this)' name='reversalval[]' value='0' id='"+i+"rever' onchange = 'validation("+i+")'></td></tr>";
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
			sweetAlert('','You are reversing more than Eligiblity.','error');
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
$concurrent_flag = 0;
// echo "post code".$post_code;
$ops_seq_check = "select id,ops_sequence,ops_dependency from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code='$operation_id'";
$result_ops_seq_check = $link->query($ops_seq_check);
while($row = $result_ops_seq_check->fetch_assoc()) 
{
	$ops_seq = $row['ops_sequence'];
	$seq_id = $row['id'];
	$ops_dependency = $row['ops_dependency'];
}
$post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_sequence = $ops_seq and id > $seq_id order by id limit 1";
$result_post_ops_check = $link->query($post_ops_check);
if($result_post_ops_check->num_rows > 0)
{
	while($row = $result_post_ops_check->fetch_assoc()) 
	{
		$post_ops_code = $row['operation_code'];
	}
}
	
foreach ($bundle_no as $key=>$value)
{
	$select_send_qty = "select (SUM(recevied_qty)+SUM(rejected_qty)) AS recevied_qty,size_title from  $brandix_bts.bundle_creation_data_temp WHERE operation_id = $operation_id and remarks='$remarks' and bundle_number='$bundle_no[$key]' group by bundle_number order by bundle_number";
	$result_select_send_qty = $link->query($select_send_qty);
	while($row = $result_select_send_qty->fetch_assoc()) 
	{
		//$send_qty = $row['send_qty'];
		$pre_recieved_qty = $row['recevied_qty'];
		$act_reciving_qty = $rep_qty[$key];
		$total_rec_qty = $pre_recieved_qty - $act_reciving_qty;
	}
	if($post_ops_code)
	{
		$post_ops_qry_to_find_rec_qty = "select (SUM(recevied_qty)+SUM(rejected_qty)) AS recevied_qty,size_title from  $brandix_bts.bundle_creation_data_temp WHERE operation_id = $post_ops_code and remarks='$remarks' and bundle_number='$bundle_no[$key]' group by bundle_number order by bundle_number";
			//echo $post_ops_qry_to_find_rec_qty;
			$result_post_ops_qry_to_find_rec_qty = $link->query($post_ops_qry_to_find_rec_qty);
			if($result_post_ops_qry_to_find_rec_qty->num_rows > 0)
			{
				while($row = $result_post_ops_qry_to_find_rec_qty->fetch_assoc()) 
				{	
					$post_rec_qty = $row['recevied_qty'];
					echo $pre_recieved_qty."-".$post_rec_qty."-".$rep_qty[$key]."</br>";
					if(($pre_recieved_qty - $post_rec_qty) < $rep_qty[$key])
					{
						$concurrent_flag = 1;
					}
	
				}
			}
	}
	else if($ops_dependency)
	{
		$post_ops_qry_to_find_rec_qty = "select (SUM(recevied_qty)+SUM(rejected_qty)) AS recevied_qty,size_title from  $brandix_bts.bundle_creation_data_temp WHERE operation_id = $ops_dep and remarks='$remarks' and bundle_number='$bundle_no[$key]' group by bundle_number order by bundle_number";
			//echo $post_ops_qry_to_find_rec_qty;
			$result_post_ops_qry_to_find_rec_qty = $link->query($post_ops_qry_to_find_rec_qty);
			if($result_post_ops_qry_to_find_rec_qty->num_rows > 0)
			{
				while($row = $result_post_ops_qry_to_find_rec_qty->fetch_assoc()) 
				{	
					$post_rec_qty = $row['recevied_qty'];
					if(($pre_recieved_qty - $post_rec_qty) < $rep_qty[$key])
					{
						$concurrent_flag = 1;
					}
	
				}
			}
	}
	else if($total_rec_qty < 0)
	{
		
		$concurrent_flag = 1;
	}

}
if($concurrent_flag == 1)
{
	echo "<h1 style='color:red;'>You are Reversing More than eligible quantity.</h1>";
}
else if($concurrent_flag == 0)
{
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
		//echo $retriving_data;
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
			$mapped_color = $row['mapped_color'];
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
		$m3_bulk_bundle_insert .= '("'.date('Y-m-d').'","'.$b_style.'","'. $b_schedule.'","'.$b_colors.'","'. $size_id.'","'. $b_sizes.'","'.$b_doc_num.'","'.$r_qty_array.'","","'.$remarks.'","'.$username.'","'. $b_op_id.'","'.$b_inp_job_ref.'","'.$b_module.'","'.$b_shift.'","'.$b_op_name.'","'.$b_tid.'",""),';
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
		//Checking with ims_log 
		if($b_op_id == 100 || $b_op_id == 129)
		{
			$searching_query_in_imslog = "SELECT * FROM $bai_pro3.ims_log WHERE pac_tid = '$b_tid' AND ims_mod_no='$b_module' AND ims_style='$b_style' AND ims_schedule='$b_schedule' AND ims_color='$b_colors' AND input_job_rand_no_ref='$b_job_no' AND operation_id='$b_op_id' AND ims_remarks = '$remarks'";
			//echo $searching_query_in_imslog;
			$result_searching_query_in_imslog = $link->query($searching_query_in_imslog);
			if($result_searching_query_in_imslog->num_rows > 0)
			{
				while($row = $result_searching_query_in_imslog->fetch_assoc()) 
				{
					$updatable_id = $row['tid'];
					$pre_ims_qty = $row['ims_qty'];
					$pre_pro_ims_qty = $row['ims_pro_qty'];
				}
				$act_ims_qty = $pre_ims_qty - $reversalval[$key];
				//updating the ims_qty when it was there in ims_log
				$update_query = "update $bai_pro3.ims_log set ims_qty = $act_ims_qty where tid = $updatable_id";
				mysqli_query($link,$update_query) or exit("While updating ims_qty in ims_log".mysqli_error($GLOBALS["___mysqli_ston"]));
				if($act_ims_qty == 0 && $pre_pro_ims_qty == 0)
				{
					$ims_delete="delete from $bai_pro3.ims_log where tid=$updatable_id";
					mysqli_query($link,$ims_delete) or exit("While De".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		}
		else
		{
			$ops_seq_check = "select id,ops_sequence from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$mapped_color' and operation_code='$b_op_id'";
			// echo $ops_seq_check;
			$result_ops_seq_check = $link->query($ops_seq_check);
			while($row = $result_ops_seq_check->fetch_assoc()) 
			{
				$ops_seq = $row['ops_sequence'];
				$seq_id = $row['id'];
			}
			$selecting_output_from_seq_query = "select operation_code from $brandix_bts.tbl_style_ops_master where ops_sequence = $ops_seq and operation_code != $b_op_id and style='$b_style' and color = '$mapped_color'";
			//echo $selecting_output_from_seq_query;
			$result_selecting_output_from_seq_query = $link->query($selecting_output_from_seq_query);
			while($row = $result_selecting_output_from_seq_query->fetch_assoc()) 
			{
				$input_ops_code = $row['operation_code'];
			}
			if($input_ops_code == 100 || $input_ops_code == 129)
			{
				$searching_query_in_imslog = "SELECT * FROM $bai_pro3.ims_log WHERE pac_tid = '$b_tid' AND ims_mod_no='$b_module' AND ims_style='$b_style' AND ims_schedule='$b_schedule' AND ims_color='$b_colors' AND input_job_rand_no_ref='$b_job_no' AND operation_id='$input_ops_code' AND ims_remarks = '$remarks'";
				$result_searching_query_in_imslog = $link->query($searching_query_in_imslog);
				//echo $searching_query_in_imslog;
				if($result_searching_query_in_imslog->num_rows > 0)
				{
					while($row = $result_searching_query_in_imslog->fetch_assoc()) 
					{
						$updatable_id = $row['tid'];
						$pre_ims_qty = $row['ims_pro_qty'];
						//$act_ims_input_qty = $row['ims_qty'];
					}
					$actual_ims_pro_qty = $pre_ims_qty - $reversalval[$key];
					//updating ims_pro_qty in ims log table
					$update_ims_pro_qty = "update $bai_pro3.ims_log set ims_pro_qty = $actual_ims_pro_qty where tid=$updatable_id";
					$ims_pro_qty_updating = mysqli_query($link,$update_ims_pro_qty) or exit("While updating ims_pro_qty in ims_log_".mysqli_error($GLOBALS["___mysqli_ston"]));
					
				}
				else
				{
					//if it was not there in ims log am checking that in ims log backup and updating the qty and reverting that into the ims log because ims_qty and ims_pro_qty not equal
					$searching_query_in_imslog = "SELECT * FROM $bai_pro3.ims_log_backup WHERE pac_tid = '$b_tid' AND ims_mod_no='$b_module' AND ims_shift = '$b_shift' AND ims_style='$b_style' AND ims_schedule='$b_schedule' AND ims_color='$b_colors' AND input_job_rand_no_ref='$b_job_no' AND operation_id='$input_ops_code' AND ims_remarks = '$remarks'";
					$result_searching_query_in_imslog = $link->query($searching_query_in_imslog);
					if($result_searching_query_in_imslog->num_rows > 0)
					{
						while($row = $result_searching_query_in_imslog->fetch_assoc()) 
						{
							$updatable_id = $row['tid'];
							$pre_ims_qty = $row['ims_pro_qty'];
							$act_ims_input_qty = $row['ims_qty'];
						}
						$act_ims_qty = $pre_ims_qty - $reversalval[$key];
						//updating the ims_qty when it was there in ims_log
						$update_query = "update $bai_pro3.ims_log_backup set ims_pro_qty = $act_ims_qty where tid = $updatable_id";
						$ims_pro_qty_updating = mysqli_query($link,$update_query) or exit("While updating ims_pro_qty in ims_log_log_backup".mysqli_error($GLOBALS["___mysqli_ston"]));
						if($ims_pro_qty_updating)
						{
							$update_status_query = "update $bai_pro3.ims_log_backup set ims_status = '' where tid = $updatable_id";
							mysqli_query($link,$update_status_query) or exit("While updating status in ims_log_backup".mysqli_error($GLOBALS["___mysqli_ston"]));
							$ims_backup="insert ignore into $bai_pro3.ims_log select * from bai_pro3.ims_log_backup where tid=$updatable_id";
							mysqli_query($link,$ims_backup) or exit("Error while inserting into ims log".mysqli_error($GLOBALS["___mysqli_ston"]));
							$ims_delete="delete from $bai_pro3.ims_log_backup where tid=$updatable_id";
							mysqli_query($link,$ims_delete) or exit("While Deleting ims log backup".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
					}
					
				}
				
			}
		}
		//inserting into bai_log and bai_log buff
			$sizevalue="size_".$size_id;
			$sections_qry="select sec_id,sec_head FROM $bai_pro3.sections_db WHERE sec_id>0 AND  sec_mods LIKE '%,".$b_module.",%' OR  sec_mods LIKE '".$b_module.",%' LIMIT 0,1";
			//echo $sections_qry;
			$sections_qry_result=mysqli_query($link,$sections_qry) or exit("Bundles Query Error15".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($buyer_qry_row=mysqli_fetch_array($sections_qry_result)){
					$sec_head=$buyer_qry_row['sec_id'];
			}
			$ims_log_date=date("Y-m-d");
			$bac_dat=$ims_log_date;
			$log_time=date("Y-m-d");
			$buyer_qry="select order_div FROM $bai_pro3.bai_orders_db WHERE order_style_no='".$b_style."' AND order_del_no='".$b_schedule."' AND order_col_des='".$b_colors."'";
			$buyer_qry_result=mysqli_query($link,$buyer_qry) or exit("Bundles Query Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($buyer_qry_row=mysqli_fetch_array($buyer_qry_result)){
					$buyer_div=str_replace("'","",(str_replace('"',"",$buyer_qry_row['order_div'])));
				}
			$qry_nop="select avail_A,avail_B FROM $bai_pro.pro_atten WHERE module=".$b_module." AND date='$bac_dat'";
				$qry_nop_result=mysqli_query($link,$qry_nop) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($nop_qry_row=mysqli_fetch_array($qry_nop_result)){
						$avail_A=$nop_qry_row['avail_A'];
						$avail_B=$nop_qry_row['avail_B'];
				}
				if(mysqli_num_rows($qry_nop_result)>0){
					if($row['shift']=='A'){
						$nop=$avail_A;
					}else{
						$nop=$avail_B;
					}
				}else{
					$nop=0;
				}
			$b_rep_qty_ins = '-'.$reversalval[$key];
			$bundle_op_id=$b_tid."-".$b_op_id."-".$b_inp_job_ref;
			if($b_op_id == 130 || $b_op_id == 101)
			{
				$insert_bailog="insert into $bai_pro.bai_log (bac_no,bac_sec,bac_Qty,bac_lastup,bac_date,
				bac_shift,bac_style,bac_stat,log_time,buyer,delivery,color,loguser,ims_doc_no,smv,".$sizevalue.",ims_table_name,ims_tid,nop,ims_pro_ref,ope_code,jobno
				) values ('".$b_module."','".$sec_head."','".$b_rep_qty_ins."',DATE_FORMAT(NOW(), '%Y-%m-%d %H'),'".$bac_dat."','".$b_shift."','".$b_style."','Active','".$log_time."','".$buyer_div."','".$b_schedule."','".$b_colors."',USER(),'".$b_doc_num[$i]."','".$sfcs_smv."','".$b_rep_qty_ins."','ims_log','".$b_op_id."','".$nop."','".$bundle_op_id."','".$b_op_id."','".$b_inp_job_ref."')";
				//echo "Bai log : ".$insert_bailog."</br>";
				if($reversalval[$key] > 0)
				{
					$qry_status=mysqli_query($link,$insert_bailog) or exit("BAI Log Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				if($qry_status)
				{
					//echo "Inserted into bai_log table successfully<br>";
					/*Insert same data into bai_pro.bai_log_buf table*/
					$insert_bailog_buf="insert into $bai_pro.bai_log_buf (bac_no,bac_sec,bac_Qty,bac_lastup,bac_date,
					bac_shift,bac_style,bac_stat,log_time,buyer,delivery,color,loguser,ims_doc_no,smv,".$sizevalue.",ims_table_name,ims_tid,nop,ims_pro_ref,ope_code,jobno
					) values ('".$b_module."','".$sec_head."','".$b_rep_qty_ins."',DATE_FORMAT(NOW(), '%Y-%m-%d %H'),'".$bac_dat."','".$b_shift."','".$b_style."','Active','".$log_time."','".$buyer_div."','".$b_schedule."','".$b_colors."',USER(),'".$b_doc_num[$i]."','".$sfcs_smv."','".$b_rep_qty_ins."','ims_log','".$b_op_id."','".$nop."','".$bundle_op_id."','".$b_op_id."','".$b_inp_job_ref."')";
					//echo "Bai log Buff: ".$insert_bailog."</br>";
					if($reversalval[$key] > 0)
					{
						$qry_status=mysqli_query($link,$insert_bailog_buf) or exit("BAI Log Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				}
			}			
		}
		
		
		
		
	}

$url = '?r='.$_GET['r'];
echo "<script>
		var ajax_url = '".$url."';
		Ajaxify(ajax_url);
	</script>";

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
	
	
	