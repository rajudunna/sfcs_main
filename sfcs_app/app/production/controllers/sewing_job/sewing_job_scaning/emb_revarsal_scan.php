<?php 
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/m3Updations.php',5,'R')); 
	$shift = $_POST['shift'];
	$op_code=$_POST['operation_code'];
	$gate_id=$_POST['gate_id'];	
	if($gate_id=='')
	{
		$gate_id=0;
	}
	//echo $gate_id."--".$op_code."--".$shift."<br>";
    $has_permission=haspermission($_GET['r']);
    if (in_array($override_sewing_limitation,$has_permission))
    {
        $value = 'authorized';
    } 
    else
    {
        $value = 'not_authorized';
    }
?>

<form  method="POST">
	<div class="panel panel-primary">
		<div class="panel-heading">Emblishment Reversal</div>
			<div class="panel-body">
				<div class='row'>
					<div class="form-group col-md-3">
						<label>Barcode Number - Operation:</label>
						<input type="text"  id="barcode" name="barcode" class="form-control" required placeholder="Scan the Barcode..."/>
					</div>
					<div class="form-group col-md-3">
						<input type="submit" name="reverse" id="reverse" class="btn btn-primary" value="Reverse" style="margin-top: 23px;">
					</div>
				</div>
			</div>
	</div>
</form>
<?php
if(isset($_POST['reverse']))
{
	$barcode=$_POST['barcode'];
	$barcodeno=explode('-', $barcode)[0];
	$operation=explode('-', $barcode)[1];
	
	//getting data from bundle_creation_data
	$getbundledata="Select * From $brandix_bts.bundle_creation_data where bundle_number = '$barcodeno' and operation_id='$operation'";
	$check_data_qry_result=mysqli_query($link,$getbundledata) or exit("while retriving data from bundle_creation_data".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($check_data_qry_result))
	{
		$b_style = $row['style'];
		$b_schedule = $row['schedule'];
		$b_op_id = $row['operation_id'];
		$b_job_no =  $row['input_job_no_random_ref'];
		$b_inp_job_ref = $row['input_job_no'];
		$size_id = $row['size_id'];
		$b_in_job_qty = $row['original_qty'];
		$b_a_cut_no = $row['cut_number'];
		$mapped_color = $row['mapped_color'];
		$color = $row['color'];
		$size_title = $row['size_title'];
		$recieved_qty = $row['recieved_qty'];
		$sfcs_smv = $row['sfcs_smv'];
		$b_tid = $row['bundle_number'];
		$b_doc_num = $row['docket_number'];
		$b_shift = $row['shift'];
		$b_module = $row['assigned_module'];
		$remarks = $row['remarks'];
		
		$negtive_rec_qty='-'.$row['recieved_qty'];
		
	}
	
	//getting next operation
	$ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$color' and operation_code=$b_op_id";
	$result_ops_seq_check = $link->query($ops_seq_check);
	while($row = $result_ops_seq_check->fetch_assoc()) 
	{
		$ops_seq = $row['ops_sequence'];
		$seq_id = $row['id'];
		$ops_order = $row['operation_order'];
	}
	$post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) > '$ops_order' and operation_code NOT IN (10,200,15) ORDER BY operation_order ASC LIMIT 1";
	$result_post_ops_check = $link->query($post_ops_check);
	if($result_post_ops_check->num_rows > 0)
	{
		while($row = $result_post_ops_check->fetch_assoc()) 
		{
			$post_ops_code = $row['operation_code'];
		}
	}
	
	//checking next operation having quantity or not
	$get_next_qty_qry="Select recieved_qty From $brandix_bts.bundle_creation_data where bundle_number = '$barcodeno' and operation_id='$post_ops_code'";
	$result_ops_qty = $link->query($get_next_qty_qry);
	while($row = $result_ops_qty->fetch_assoc()) 
	{
		$nextop_rec_qty = $row['recieved_qty'];
	}
	
	
	if($nextop_rec_qty==0)
	{
		//getting operation details
		$ops_name_qry = "select operation_name from $brandix_bts.tbl_orders_ops_ref where operation_code = $b_op_id";
		$result_ops_name_qry = $link->query($ops_name_qry) or exit('query error while retriving operation_name');
		while($row_ops = $result_ops_name_qry->fetch_assoc()) 
		{
			$b_op_name = $row_ops['operation_name'];
		}
		
		if($negtive_rec_qty!='' || $negtive_rec_qty!=0)
		{
			//inseting data into bundle_creation_data_temp
			$bulk_insert_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`scanned_user`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`) VALUES";
			$bulk_insert_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$color.'","'.$size_id.'","'. $size_title.'","'. $sfcs_smv.'","'.$b_tid.'","'.$b_in_job_qty.'","'.$b_in_job_qty.'","'.$negtive_rec_qty.'","0","0","'. $b_op_id.'","'.$b_doc_num.'","'.date('Y-m-d').'","'.$b_a_cut_no.'","'.$b_inp_job_ref.'","'.$username.'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$remarks.'"),';
			if(substr($bulk_insert_temp, -1) == ',')
			{
				$final_query_000_temp = substr($bulk_insert_temp, 0, -1);
			}
			else
			{
				$final_query_000_temp = $bulk_insert_temp;
			}
			$bundle_creation_result_temp = $link->query($final_query_000_temp) or exit('error while insert into bundle_creation_data_temp');
			
			//updating bundle_creation_data
			$query_post_dep = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$recieved_qty."',`recieved_qty`=0, `scanned_date`='". date('Y-m-d')."' where bundle_number ='".$barcodeno."' and operation_id = ".$operation;
			$result_query = $link->query($query_post_dep) or exit('error while updating bundle_creation_data');
			
			
		}
		
		
		//checking data exist in emb_bundles or not
		$check_data_qry="select * from $bai_pro3.emb_bundles where doc_no='$b_doc_num' and ops_code='$b_op_id' and size='$size_id'";
		$check_data_qry_result=mysqli_query($link,$check_data_qry) or exit("while retriving data from emb_bundles".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($check_data_qry_result->num_rows > 0)
		{
			while($qry_result_row=mysqli_fetch_array($check_data_qry_result))
			{
				$tid=$qry_result_row['tid'];
				$barcodeno=$qry_result_row['barcode'];
				$clubstatus=$qry_result_row['club_status'];
				$orgqty=$qry_result_row['quantity'];
				$goodqty=$qry_result_row['good_qty'];
				$rejectqty=$qry_result_row['reject_qty'];
				$tranid=$qry_result_row['tran_id'];
				$status=$qry_result_row['status'];
				
				$good_negetive_qty='-'.$qry_result_row['good_qty'];
				
				//insert data into emb_bundles_temp
				$insert_emb_bundles="INSERT INTO $bai_pro3.emb_bundles_temp(tid,  doc_no,  size,    ops_code,  barcode,  quantity,  good_qty,  reject_qty,  insert_time,  update_time,  club_status,  log_user,  tran_id,  status) VALUES ('".$tid."','".$b_doc_num."','".$size_id."','".$b_op_id."','".$barcodeno."','".$orgqty."','".$good_negetive_qty."','0','".date('Y-m-d')."','','".$clubstatus."','".$username."','".$tranid."','".$status."')";
				$result_emb_temp = $link->query($insert_emb_bundles) or exit('error while insert into emb_bundles_temp');
				
				//if data exists update emb_bundles
				$update_emb_bundles="UPDATE $bai_pro3.emb_bundles SET good_qty='0',reject_qty='0',update_time='". date('Y-m-d')."' where doc_no='$b_doc_num' and ops_code='$b_op_id' and size='$size_id'";
				$result_query = $link->query($update_emb_bundles) or exit('query error in updating emb_bundles');
			}
		}
		
		//update cps_log
		$update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=0 where doc_no = '".$b_doc_num."' and size_title='". $size_id."' AND operation_code = $b_op_id";
		$update_qry_cps_log_res = $link->query($update_qry_cps_log);
		
		$updating = updateM3TransactionsReversal($barcodeno,$recieved_qty,$b_op_id);
	}
	else
	{
		echo "<script>swal('Next Operation Already Scanned','','warning')</script>";
	}
}
?>	