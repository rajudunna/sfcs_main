<?php
    error_reporting(0);
    include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
    include 'functions_scanning_ij.php';
	
	$barcode = $_POST['barcode'];
	$rej_data=$_POST['rej_data'];
	
	if($rej_data!='')
	{
		$rejctedqty=array_sum($rej_data);		
	}
	else
	{
		$rejctedqty=0;
	}
		
	function updatechildtrans($bundle_no,$ops_code,$report_qty,$rejctedqty,$size,$barcode)
	{
		$docket_no = explode('-', $barcode)[1];
		$bun_no = explode('-', $barcode)[2];
		$operation = explode('-', $barcode)[3];

		include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");

		$diffqty=$report_qty-$rejctedqty;
		
		//getting operation code
		$get_curr_ops_code="select ops_code,send_qty,good_qty,rejection_qty,act_cut_bundle_id from $bai_pro3.act_cut_bundle_trn where barcode='".$barcode."'";
		$rslt_get_cur_ops = $link->query($get_curr_ops_code);
		while($row_rslt = $rslt_get_cur_ops->fetch_assoc())
		{
			$ops_code=$row_rslt['ops_code'];
			$rec_qty=$row_rslt['send_qty'];
			$report_qty=$row_rslt['send_qty'];
			$good_qty=$row_rslt['good_qty'];
			$rejection_qty=$row_rslt['rejection_qty'];
			$act_cut_bundle_id=$row_rslt['act_cut_bundle_id'];
		}
		
		//getting style and color
		$get_style_details="select style,color,size from $bai_pro3.act_cut_bundle where id=".$act_cut_bundle_id."";
		$result_selecting_style_color_qry = $link->query($get_style_details);
		while($row = $result_selecting_style_color_qry->fetch_assoc())
		{
			$style=$row['style'];
			$color=$row['color'];
			$size=$row['size'];
		}
		
		//getting bundle number from bundle_creation_data
		$selct_qry = "SELECT bundle_number,schedule,input_job_no_random_ref FROM $brandix_bts.bundle_creation_data  WHERE docket_number =$docket_no AND operation_id=$ops_code AND size_title='$size'";
		$selct_qry_res=mysqli_query($link,$selct_qry) or exit("while retriving bundle_number".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($selct_qry_res->num_rows > 0)
		{
	   
			while($selct_qry_result_rows=mysqli_fetch_array($selct_qry_res))
			{
				$bundle_no = $selct_qry_result_rows['bundle_number'];
				$b_tid[]= $selct_qry_result_rows['bundle_number'];
				$schedule = $selct_qry_result_rows['schedule'];
				$input_job_no_random = $selct_qry_result_rows['input_job_no_random_ref'];
			}
		}
		//getting previous operation
		$prev_ops_check = "select previous_operation from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND operation_code = $ops_code";
		$result_prev_ops_check = $link->query($prev_ops_check);
		if($result_prev_ops_check->num_rows > 0)
		{
			while($rows = $result_prev_ops_check->fetch_assoc())
			{
				$prev_operation = $rows['previous_operation'];
			}
		}
		else
		{
			$prev_operation = '';
		}
		
		//getting next operation
		$dep_ops_check = "select ops_dependency from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND operation_code =$ops_code";
		$result_dep_ops_check = $link->query($dep_ops_check);
		if($result_dep_ops_check->num_rows > 0)
		{
			while($row22 = $result_dep_ops_check->fetch_assoc())
			{
				$next_operation = $row22['ops_dependency'];
			}
		}
		else
		{
			$next_operation = '';
		}
		
		if($next_operation>0 || $prev_operation>0)
		{
			if($next_operation>0)
			{
				$get_ops_dep = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_dependency = $next_operation";
				$result_ops_dep = $link->query($get_ops_dep);
				while($row_dep = $result_ops_dep->fetch_assoc())
				{
					$operations[] = $row_dep['operation_code'];
				}
				$emb_operations = implode(',',$operations);
			}
			if($prev_operation>0)
			{
				$get_ops_dep = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and previous_operation = $prev_operation";
				$result_ops_dep = $link->query($get_ops_dep);
				   while($row_dep = $result_ops_dep->fetch_assoc())
				   {
					  $operations[] = $row_dep['operation_code'];
				   }
				   $emb_operations = implode(',',$operations);
			}
			$flag='parallel_scanning';
		}
		$category=['cutting','Send PF','Receive PF'];
		$ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code=$ops_code";
		$result_ops_seq_check = $link->query($ops_seq_check);
		while($row = $result_ops_seq_check->fetch_assoc())
		{
			$ops_seq = $row['ops_sequence'];
			$seq_id = $row['id'];
			$ops_order = $row['operation_order'];
		}
			
		
		$post_ops_check = "SELECT tsm.operation_code AS operation_code FROM $brandix_bts.tbl_style_ops_master tsm 
			LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE style='$style' AND color='$color' AND tor.display_operations='yes' and tsm.ops_sequence = '$ops_seq' AND CAST(tsm.operation_order AS CHAR) > '$ops_order' and tor.category in ('".implode("','",$category)."') GROUP BY tsm.operation_code ORDER BY tsm.operation_order ASC LIMIT 1";
		$result_post_ops_check = $link->query($post_ops_check);
		if($result_post_ops_check->num_rows > 0)
		{
			while($row = $result_post_ops_check->fetch_assoc())
			{
				$post_ops_code = $row['operation_code'];
			}
		}
		
		$pre_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) < '$ops_order' ORDER BY operation_order DESC LIMIT 1";
		$result_pre_ops_check = $link->query($pre_ops_check);
		if($result_pre_ops_check->num_rows > 0)
		{
			while($row = $result_pre_ops_check->fetch_assoc())
			{
				$pre_ops_code = $row['operation_code'];
			}
		}
		
		
		
		
		if($flag=='parallel_scanning')
		{			
			$checking_qry = "SELECT category FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code = $ops_code";
			$result_checking_qry = $link->query($checking_qry);
			while($row_cat = $result_checking_qry->fetch_assoc())
			{
				$category_act = $row_cat['category'];
			}
			
			//updating data in bundle_creation_data
			$query = "UPDATE $brandix_bts.bundle_creation_data SET `recevied_qty`= recevied_qty+".$diffqty.",`rejected_qty`=rejected_qty+".$rejctedqty.", `scanned_date`='". date('Y-m-d')."' where bundle_number =$bundle_no and operation_id = ".$ops_code;
			$result_query = $link->query($query) or exit('query error in updating bundle_creation_data');
			
			//insert into bundle_creation_data_temp
			$insert_bcd_temp="INSERT INTO $brandix_bts.bundle_creation_data_temp (cut_number,  style,            schedule,  color,                           size_id,  size_title,  sfcs_smv,  bundle_number,  original_qty,  send_qty,  missing_qty,    left_over,  operation_id,  operation_sequence,  ops_dependency,  docket_number,  bundle_status,  split_status,  sewing_order_status,  is_sewing_order,  sewing_order,  assigned_module,  remarks,    shift,    scanned_user,     sync_status,  shade,   input_job_no,  input_job_no_random_ref,  bundle_qty_status,recevied_qty,rejected_qty,scanned_date) SELECT cut_number,  style,            schedule,  color,                           size_id,  size_title,  sfcs_smv,  bundle_number,  original_qty,  send_qty,    missing_qty,    left_over,  operation_id,  operation_sequence,  ops_dependency,  docket_number,  bundle_status,  split_status,  sewing_order_status,  is_sewing_order,  sewing_order,  assigned_module,  remarks,     shift,    scanned_user,     sync_status,  shade,   input_job_no,  input_job_no_random_ref,  bundle_qty_status ,$diffqty,$rejctedqty,'".date('Y-m-d H:i:s')."' FROM $brandix_bts.bundle_creation_data where bundle_number =$bundle_no and operation_id = ".$ops_code;

			$result_query_bcd_temp = $link->query($insert_bcd_temp) or exit('error insert into bundle_creation_data_temp');
			// $last_id = $link->insert_id;
			
			//update bundle_creation_data_temp quantity
			// $query_update = "UPDATE $brandix_bts.bundle_creation_data_temp SET `recevied_qty`= ".$diffqty.",,rejected_qty=".$rejctedqty.", `scanned_date`='". date('Y-m-d')."' where id=$last_id ";
			// $result_query_update = $link->query($query_update) or exit('query error in updating bundle_creation_data');
			
			if($post_ops_code != null && $category_act=='Send PF')
			{
				$query_post = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = send_qty+".$diffqty.", `scanned_date`='". date('Y-m-d')."' where docket_number =$docket_no and size_title='$size' and operation_id = ".$post_ops_code;
				$result_query = $link->query($query_post) or exit('query error in updating');
			}
			
			//getting data form embellishment_plan_dashboard
			$quanforembdash=$diffqty+$rejctedqty;
			$get_data_embd_send_qry="select send_op_code from $bai_pro3.embellishment_plan_dashboard where doc_no=$docket_no and send_op_code=$ops_code";
			$check_qry_result=mysqli_query($link,$get_data_embd_send_qry) or exit("while retriving data from embellishment_plan_dashboard".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($qry_row=mysqli_fetch_array($check_qry_result))
			{
				$sendop_code=$qry_row['send_op_code'];
			}
			$get_data_embd_rec_qry="select receive_op_code from $bai_pro3.embellishment_plan_dashboard where doc_no=$docket_no and receive_op_code=$ops_code";
			$check_qry_rec_result=mysqli_query($link,$get_data_embd_rec_qry) or exit("while retriving data from embellishment_plan_dashboard".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($qry_rec_row=mysqli_fetch_array($check_qry_rec_result))
			{
				$recop_code=$qry_rec_row['receive_op_code'];
			}
			if($sendop_code==$ops_code)
			{
				//update in emblishment dashboard
				$embellishment_plan_dashboard_qry = "UPDATE $bai_pro3.embellishment_plan_dashboard SET `send_qty`= send_qty+$quanforembdash where doc_no =$docket_no and send_op_code=$ops_code";
				$embellishment_plan_dashboard_result = $link->query($embellishment_plan_dashboard_qry) or exit('Embellishment Plan Dashboard query receive error');
			}
			if($recop_code==$ops_code)
			{
				//update in emblishment dashboard
				$embellishment_plan_dashboard_qry = "UPDATE $bai_pro3.embellishment_plan_dashboard SET `receive_qty`= receive_qty+$quanforembdash where doc_no =$docket_no and receive_op_code=$ops_code";
				$embellishment_plan_dashboard_result = $link->query($embellishment_plan_dashboard_qry) or exit('Embellishment Plan Dashboard query receive error');
			}
			
			$qry_min_prevops="SELECT MIN(good_qty) AS min_recieved_qty FROM $bai_pro3.act_cut_bundle_trn WHERE act_cut_bundle_id=".$act_cut_bundle_id." and ops_code in ($emb_operations)";
			$result_qry_min_prevops = $link->query($qry_min_prevops);
			while($row_result_min_prevops = $result_qry_min_prevops->fetch_assoc())
			{
				$previous_minqty=$row_result_min_prevops['min_recieved_qty'];
			}
			
			$update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty+$previous_minqty where doc_no = ".$docket_no." and size_title='". $size."' AND operation_code = $ops_code";
			$update_qry_cps_log_res = $link->query($update_qry_cps_log);
		   if($category_act=='Send PF')
		   {
			  $update_pre_qty= "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$previous_minqty where doc_no = ".$docket_no." and size_title='". $size."' AND operation_code = $prev_operation";   
			  $update_cps_log_res = $link->query($update_pre_qty); 
		   }
		   else
		   {
			   $update_pre_qty= "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$previous_minqty where doc_no = ".$docket_no." and size_title='". $size."' AND operation_code = $pre_ops_code";   
			   $update_cps_log_res = $link->query($update_pre_qty); 
		   }
			
			
		}
		else
		{
			//updating data in bundle_creation_data
			$query = "UPDATE $brandix_bts.bundle_creation_data SET `recevied_qty`= recevied_qty+".$diffqty.",`rejected_qty`=rejected_qty+".$rejctedqty.", `scanned_date`='". date('Y-m-d')."' where bundle_number =$bundle_no and operation_id = ".$ops_code;
			$result_query = $link->query($query) or exit("".$query."---query error in updating bundle_creation_data");
			
			//insert into bundle_creation_data_temp
			$insert_bcd_temp="INSERT INTO $brandix_bts.bundle_creation_data_temp (cut_number,  style,            schedule,  color,                           size_id,  size_title,  sfcs_smv,  bundle_number,  original_qty,  send_qty,  missing_qty,    left_over,  operation_id,  operation_sequence,  ops_dependency,  docket_number,  bundle_status,  split_status,  sewing_order_status,  is_sewing_order,  sewing_order,  assigned_module,  remarks,    shift,    scanned_user,     sync_status,  shade,   input_job_no,  input_job_no_random_ref,  bundle_qty_status,recevied_qty,rejected_qty,scanned_date) SELECT cut_number,  style,            schedule,  color,                           size_id,  size_title,  sfcs_smv,  bundle_number,  original_qty,  send_qty,    missing_qty,    left_over,  operation_id,  operation_sequence,  ops_dependency,  docket_number,  bundle_status,  split_status,  sewing_order_status,  is_sewing_order,  sewing_order,  assigned_module,  remarks,     shift,    scanned_user,     sync_status,  shade,   input_job_no,  input_job_no_random_ref,  bundle_qty_status ,$diffqty,$rejctedqty,'".date('Y-m-d H:i:s')."' FROM $brandix_bts.bundle_creation_data where bundle_number =$bundle_no and operation_id = ".$ops_code;

			$result_query_bcd_temp = $link->query($insert_bcd_temp) or exit('error insert into bundle_creation_data_temp');
			// $last_id = $link->insert_id;
			
			//update bundle_creation_data_temp quantity
			//$query_update = "UPDATE $brandix_bts.bundle_creation_data_temp SET `recevied_qty`= ".$diffqty.",rejected_qty=".$rejctedqty.", `scanned_date`='". date('Y-m-d H:i:s')."' where id=$last_id ";
			//$result_query_update = $link->query($query_update) or exit("".$query_update."---query error in updating bundle_creation_data_temp");
			
			if($post_ops_code != null)
			{
				$query_post = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = send_qty+".$diffqty.", `scanned_date`='". date('Y-m-d H:i:s')."' where docket_number =$docket_no and size_title='$size' and operation_id = ".$post_ops_code;
				$result_query = $link->query($query_post) or exit('query error in updating');
			}
			
			//getting data form embellishment_plan_dashboard
			$quanforembdash=$diffqty+$rejctedqty;
			$get_data_embd_send_qry="select send_op_code from $bai_pro3.embellishment_plan_dashboard where doc_no=$docket_no and send_op_code=$ops_code";
			$check_qry_result=mysqli_query($link,$get_data_embd_send_qry) or exit("while retriving data from embellishment_plan_dashboard".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($qry_row=mysqli_fetch_array($check_qry_result))
			{
				$sendop_code=$qry_row['send_op_code'];
			}
			$get_data_embd_rec_qry="select receive_op_code from $bai_pro3.embellishment_plan_dashboard where doc_no=$docket_no and receive_op_code=$ops_code";
			$check_qry_rec_result=mysqli_query($link,$get_data_embd_rec_qry) or exit("while retriving data from embellishment_plan_dashboard".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($qry_rec_row=mysqli_fetch_array($check_qry_rec_result))
			{
				$recop_code=$qry_rec_row['receive_op_code'];
			}
			if($sendop_code==$ops_code)
			{
				//update in emblishment dashboard
				$embellishment_plan_dashboard_qry = "UPDATE $bai_pro3.embellishment_plan_dashboard SET `send_qty`= send_qty+$quanforembdash where doc_no =$docket_no and send_op_code=$ops_code";
				$embellishment_plan_dashboard_result = $link->query($embellishment_plan_dashboard_qry) or exit('Embellishment Plan Dashboard query receive error');
			}
			if($recop_code==$ops_code)
			{
				//update in emblishment dashboard
				$embellishment_plan_dashboard_qry = "UPDATE $bai_pro3.embellishment_plan_dashboard SET `receive_qty`= receive_qty+$quanforembdash where doc_no =$docket_no and receive_op_code=$ops_code";
				$embellishment_plan_dashboard_result = $link->query($embellishment_plan_dashboard_qry) or exit('Embellishment Plan Dashboard query receive error');
			}
			
			//update cps_log
			$update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty+$quanforembdash-$rejctedqty where doc_no = ".$docket_no." and size_title='". $size."' AND operation_code = $ops_code";
			// echo $update_qry_cps_log;
			$update_qry_cps_log_res = $link->query($update_qry_cps_log);
			
			$update_pre_qty= "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$quanforembdash where doc_no = ".$docket_no." and size_title='". $size."' AND operation_code = $pre_ops_code";   
			$update_cps_log_res = $link->query($update_pre_qty);
			
			
		}
		
		return true;
	}
	
	function scanningdetails($barcode,$rej_data,$rejctedqty)
	{
		if($rej_data!=''){
			$total_rej_qty=array_sum($rej_data);   
		}else{
			$total_rej_qty=0;
		}
		$docket_no = explode('-', $barcode)[1];
		$bun_no = explode('-', $barcode)[2];
		$operation = explode('-', $barcode)[3];

		include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
		include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/m3Updations.php");
		
		// checking for emblishment Planning done or not
		// $check_plan_qry="select doc_no from $bai_pro3.embellishment_plan_dashboard where doc_no in ($docket_no)";
		// $check_qry_result=mysqli_query($link,$check_plan_qry) or exit("error while retriving bundle_number".mysqli_error($GLOBALS["___mysqli_ston"]));
		// if($check_qry_result->num_rows > 0)
		// {	
			//getting operation code
			$get_curr_ops_code="select ops_code,send_qty,good_qty,rejection_qty,act_cut_bundle_id from $bai_pro3.act_cut_bundle_trn where barcode='".$barcode."'";
			$rslt_get_cur_ops = $link->query($get_curr_ops_code);
			while($row_rslt = $rslt_get_cur_ops->fetch_assoc())
			{
				$ops_code=$row_rslt['ops_code'];
				$rec_qty=$row_rslt['send_qty'];
				$report_qty=$row_rslt['send_qty'];
				$good_qty=$row_rslt['good_qty'];
				$rejection_qty=$row_rslt['rejection_qty'];
				$act_cut_bundle_id=$row_rslt['act_cut_bundle_id'];
			}
			
			if($ops_code!='')
			{
				//getting style and color
				$get_style_details="select style,color,size from $bai_pro3.act_cut_bundle where id=".$act_cut_bundle_id."";
				$result_selecting_style_color_qry = $link->query($get_style_details);
				while($row = $result_selecting_style_color_qry->fetch_assoc())
				{
					$style=$row['style'];
					$color=$row['color'];
					$size=$row['size'];
				}
			
			
				//getting bundle number from bundle_creation_data
				$selct_qry = "SELECT bundle_number,schedule,input_job_no_random_ref FROM $brandix_bts.bundle_creation_data  WHERE docket_number =$docket_no AND operation_id=$ops_code AND size_title='$size'";
				$selct_qry_res=mysqli_query($link,$selct_qry) or exit("while retriving bundle_number".mysqli_error($GLOBALS["___mysqli_ston"]));
				if($selct_qry_res->num_rows > 0)
				{
			   
					while($selct_qry_result_rows=mysqli_fetch_array($selct_qry_res))
					{
						$bundle_no = $selct_qry_result_rows['bundle_number'];
						$b_tid[]= $selct_qry_result_rows['bundle_number'];
						$schedule = $selct_qry_result_rows['schedule'];
						$input_job_no_random = $selct_qry_result_rows['input_job_no_random_ref'];
					}
				}

			
				if($rec_qty>0)
				{
					//getting previous operation
					$prev_ops_check = "select previous_operation from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND operation_code = $ops_code";
					$result_prev_ops_check = $link->query($prev_ops_check);
					if($result_prev_ops_check->num_rows > 0)
					{
						while($rows = $result_prev_ops_check->fetch_assoc())
						{
							$prev_operation = $rows['previous_operation'];
						}
					}
					else
					{
						$prev_operation = '';
					}
					
					//getting next operation
					$dep_ops_check = "select ops_dependency from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND operation_code =$ops_code";
					$result_dep_ops_check = $link->query($dep_ops_check);
					if($result_dep_ops_check->num_rows > 0)
					{
						while($row22 = $result_dep_ops_check->fetch_assoc())
						{
							$next_operation = $row22['ops_dependency'];
						}
					}
					else
					{
						$next_operation = '';
					}
					
					if($next_operation>0 || $prev_operation>0)
					{
						if($next_operation>0)
						{
							$get_ops_dep = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_dependency = $next_operation";
							$result_ops_dep = $link->query($get_ops_dep);
							while($row_dep = $result_ops_dep->fetch_assoc())
							{
								$operations[] = $row_dep['operation_code'];
							}
							$emb_operations = implode(',',$operations);
						}
						if($prev_operation>0)
						{
							$get_ops_dep = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and previous_operation = $prev_operation";
							$result_ops_dep = $link->query($get_ops_dep);
							   while($row_dep = $result_ops_dep->fetch_assoc())
							   {
								  $operations[] = $row_dep['operation_code'];
							   }
							   $emb_operations = implode(',',$operations);
						}
						$flag='parallel_scanning';
					}
					
					$ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code=$ops_code";
					$result_ops_seq_check = $link->query($ops_seq_check);
					while($row = $result_ops_seq_check->fetch_assoc())
					{
						$ops_seq = $row['ops_sequence'];
						$seq_id = $row['id'];
						$ops_order = $row['operation_order'];
					}
					$post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) > '$ops_order' ORDER BY operation_order ASC LIMIT 1";
					$result_post_ops_check = $link->query($post_ops_check);
					if($result_post_ops_check->num_rows > 0)
					{
						while($row = $result_post_ops_check->fetch_assoc())
						{
							$post_ops_code = $row['operation_code'];
						}
					}
					
					$pre_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) < '$ops_order' ORDER BY operation_order DESC LIMIT 1";
					$result_pre_ops_check = $link->query($pre_ops_check);
					if($result_pre_ops_check->num_rows > 0)
					{
						while($row = $result_pre_ops_check->fetch_assoc())
						{
							$pre_ops_code = $row['operation_code'];
						}
					}
					
					$checking_qry = "SELECT category FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code = $ops_code";
					$result_checking_qry = $link->query($checking_qry);
					while($row_cat = $result_checking_qry->fetch_assoc())
					{
						$category_act = $row_cat['category'];
					}
					
					
					$getting_send_ops_qry="select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and previous_operation = $ops_code";
					$result_send_ops_qry = $link->query($getting_send_ops_qry);
					while($rows = $result_send_ops_qry->fetch_assoc())
					{
						$parlops[] = $rows['operation_code'];
					}
					
					$send_operations = implode(',',$parlops);
					
					if($category_act=='cutting' && $send_operations!='')
					{									
						$update_qry_act_trn="update bai_pro3.act_cut_bundle_trn set send_qty=$report_qty-$rejctedqty where act_cut_bundle_id =".$act_cut_bundle_id." and ops_code in ($send_operations)";
						$result_acttrn_query = $link->query($update_qry_act_trn) or exit('query error in updating act_cut_bundle_trn');
						
					}
					else
					{
						$update_qry_act_trn="update bai_pro3.act_cut_bundle_trn set send_qty=$report_qty-$rejctedqty where act_cut_bundle_id =".$act_cut_bundle_id." and ops_code=".$post_ops_code."";
						$result_acttrn_query = $link->query($update_qry_act_trn) or exit('query error in updating act_cut_bundle_trn');
					}						

						
							
							if($flag=='parallel_scanning')
							{
								if($rec_qty=$good_qty+$rejection_qty)
								{
									$result_array['status'] = 'Already Scanned';
									echo json_encode($result_array);
									die();
								}
								else
								{
									//quantity filling in act_cut_bundle_trn
									$update_qnty_qry="Update $bai_pro3.act_cut_bundle_trn SET good_qty=$report_qty-$rejctedqty,rejection_qty=".$rejctedqty.",status=1 where barcode='".$barcode."'";
									$result_query = $link->query($update_qnty_qry) or exit('query error in updating');					
									// if($pre_ops_code)
									// {
										// $pre_ops_barcode="ACB-".$docket_no."-".$bun_no."-".$pre_ops_code;
										// $update_prev_ops_qry="update $bai_pro3.act_cut_bundle_trn SET remaining_qty=0 where barcode='".$pre_ops_barcode."'";
										// $result_update_query = $link->query($update_prev_ops_qry) or exit('query error in updating pre ops');
									// }
									if($post_ops_code)
									{
										$post_ops_barcode="ACB-".$docket_no."-".$bun_no."-".$post_ops_code;
										$update_post_ops_qry="update $bai_pro3.act_cut_bundle_trn SET send_qty=$report_qty-$rejctedqty where barcode='".$post_ops_barcode."'";
										$result_update_query = $link->query($update_post_ops_qry) or exit('query error in updating post ops');
									}
									
									$category=['cutting','Send PF','Receive PF'];
									$checking_qry = "SELECT category FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code = $ops_code";
									$result_checking_qry = $link->query($checking_qry);
									while($row_cat = $result_checking_qry->fetch_assoc())
									{
										$category_act = $row_cat['category'];
									}
									if($category_act=='Receive PF')
									{
										$qry_min_prevops="SELECT MIN(good_qty) AS min_recieved_qty FROM $bai_pro3.act_cut_bundle_trn WHERE act_cut_bundle_id=".$act_cut_bundle_id." and ops_code in ($emb_operations)";
										$result_qry_min_prevops = $link->query($qry_min_prevops);
										while($row_result_min_prevops = $result_qry_min_prevops->fetch_assoc())
										{
											$previous_minqty=$row_result_min_prevops['min_recieved_qty'];
										}
										
										$update_qnty_qry="Update $bai_pro3.act_cut_bundle SET act_good_qty=act_good_qty+$previous_minqty where id=".$act_cut_bundle_id."";
										$result_query = $link->query($update_qnty_qry) or exit('query error in updating');
									}
									
									$rep_m3_qty=$report_qty-$rejctedqty;
									if($rejctedqty>0)
									{
										$b_remarks  = '';
										$actual_rejection_reason_array_string = array();
											foreach($rej_data as $reason_key=>$reason_value)
											{   
												//to get form type
												$rejection_code_fetech_qry = "select reason_code,form_type from $bai_pro3.bai_qms_rejection_reason where sno= '$reason_key'";
												$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
												while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
												{
													$reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
													$type = $rowresult_rejection_code_fetech_qry['form_type'];
												}
												$bundle_individual_number=$bundle_no;
												$remain_qty_key=$reason_key;
												$remain_qty_value=$reason_value;
												if($reason_value > 0)
												{   
													$actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$remain_qty_key.'-'. $remain_qty_value ;
													$remarks_code = $reason_code.'-'.$reason_value;
													$remarks_var = $module.'-'.$shift.'-'.$type;
													$bulk_insert_rej = "INSERT INTO $bai_pro3.bai_qms_db(`qms_style`, `qms_schedule`,`qms_color`,`log_user`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`,`remarks`, `ref1`, `doc_no`, `input_job_no`, `operation_id`, `qms_remarks`, `bundle_no`) VALUES";
													$bulk_insert_rej .= '("'.$style.'","'.$schedule.'","'.$color.'","'.$username.'","'.date('Y-m-d').'","'.$size.'","'.$remain_qty_value.'","3","'.$remarks_var.'","'.$remarks_code.'","'.$docket_no.'","'.$input_job_no_random.'","'. $ops_code.'","'. $b_remarks.'","'.$bundle_individual_number.'")';
													$rej_insert_result = $link->query($bulk_insert_rej) or exit('data error');
													//updating BCD
													
													
												}
											}

											//update rejections to M3 trasactions
											if(sizeof($actual_rejection_reason_array_string) > 0)
											{
												for($i=0;$i<sizeof($actual_rejection_reason_array_string);$i++)
													{
														$r_qty = array();
														$r_reasons = array();
														$implode_next = explode('-',$actual_rejection_reason_array_string[$i]);
														$r_qty[] = $implode_next[2];
														$rejection_code_fetech_qry = "select m3_reason_code from $bai_pro3.bai_qms_rejection_reason where sno= $implode_next[1]";
														$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
															while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
															{
																$m3_reason_code = $rowresult_rejection_code_fetech_qry['m3_reason_code'];
															}
														//$r_reasons[] = $m3_reason_code;
														$b_tid = $implode_next[0];
														//retreving bcd id from bundle_ceration_data and inserting into the rejection_log table and rejection_log_child
														$bcd_id_qry = "select id,style,schedule,color,docket_number,size_title,size_id,assigned_module,input_job_no_random_ref from $brandix_bts.bundle_creation_data where bundle_number=$bundle_no and operation_id = $ops_code";
														$bcd_id_qry_result=mysqli_query($link,$bcd_id_qry) or exit("Bcd id qry".mysqli_error($GLOBALS["___mysqli_ston"]));
															while($bcd_id_row=mysqli_fetch_array($bcd_id_qry_result))
															{
																$bcd_id = $bcd_id_row['id'];
																$style = $bcd_id_row['style'];
																$schedule = $bcd_id_row['schedule'];
																$color = $bcd_id_row['color'];
																$doc_no = $bcd_id_row['docket_number'];
																$size_title = $bcd_id_row['size_title'];
																$size_id = $bcd_id_row['size_id'];
																$assigned_module = $bcd_id_row['assigned_module'];
																$input_job_random_ref = $bcd_id_row['input_job_no_random_ref'];
																$doc_value = $bcd_id_row['docket_number'];
															}
														//searching the bcd_id in rejection log child or not
														$bcd_id_searching_qry = "select id,parent_id from $bai_pro3.rejection_log_child where bcd_id = $bcd_id";
														$bcd_id_searching_qry_result=mysqli_query($link,$bcd_id_searching_qry) or exit("bcd_id_searching_qry_result".mysqli_error($GLOBALS["___mysqli_ston"]));
														if($bcd_id_searching_qry_result->num_rows > 0)
														{
															while($bcd_id_searching_qry_result_row=mysqli_fetch_array($bcd_id_searching_qry_result))
															{
																$parent_id = $bcd_id_searching_qry_result_row['parent_id'];
															}
															$update_rejection_log_child_qry = "update $bai_pro3.rejection_log_child set rejected_qty=rejected_qty+$implode_next[2] where bcd_id = $bcd_id";
															mysqli_query($link,$update_rejection_log_child_qry) or exit("update_rejection_log_child_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
															$update_qry_rej_lg = "update $bai_pro3.rejections_log set rejected_qty = rejected_qty+$implode_next[2],remaining_qty=remaining_qty+$implode_next[2] where style='$style' and schedule='$schedule' and color='$color'";
															$update_qry_rej_lg = $link->query($update_qry_rej_lg);
														}
														else
														{
															$search_qry="SELECT id FROM $bai_pro3.rejections_log where style='$style' and schedule='$schedule' and color='$color'";
															// echo $search_qry;
															$result_search_qry = mysqli_query($link,$search_qry) or exit("rejections_log search query".mysqli_error($GLOBALS["___mysqli_ston"]));
															if($result_search_qry->num_rows > 0)
															{
																while($row_result_search_qry=mysqli_fetch_array($result_search_qry))
																{
																	$rejection_log_id = $row_result_search_qry['id'];
																	$update_qry_rej_lg = "update $bai_pro3.rejections_log set rejected_qty = rejected_qty+$implode_next[2],remaining_qty=remaining_qty+$implode_next[2] where id = $rejection_log_id";
																	// echo $update_qry_rej_lg;
																	$update_qry_rej_lg = $link->query($update_qry_rej_lg);
																	$parent_id = $rejection_log_id;
																}

															}
															else
															{
																$insert_qty_rej_log = "INSERT INTO bai_pro3.rejections_log (style,schedule,color,rejected_qty,recut_qty,remaining_qty) VALUES ('$style','$schedule','$color',$implode_next[2],'0',$implode_next[2])";
																$res_insert_qty_rej_log = $link->query($insert_qty_rej_log);
																$parent_id=mysqli_insert_id($link);
															}
															$inserting_into_rejection_log_child_qry = "INSERT INTO `bai_pro3`.`rejection_log_child` (`parent_id`,`bcd_id`,`doc_no`,`input_job_no_random_ref`,`size_id`,`size_title`,`assigned_module`,`rejected_qty`,`operation_id`) values($parent_id,$bcd_id,$doc_no,$input_job_random_ref,'$size_id','$size_title',$assigned_module,$implode_next[2],$ops_code)";
															$insert_qry_rej_child = $link->query($inserting_into_rejection_log_child_qry);
														}
														//inserting into rejections_reason_track'
														if($implode_next[2] > 0)
														{
															$insert_into_rejections_reason_track = "INSERT INTO $bai_pro3.`rejections_reason_track` (`parent_id`,`date_time`,`bcd_id`,`rejected_qty`,`rejection_reason`,`username`,`form_type`) values ($parent_id,DATE_FORMAT(NOW(), '%Y-%m-%d %H'),$bcd_id,'$implode_next[2]','$implode_next[1]','$username','$type')";
															$insert_into_rejections_reason_track_res =$link->query($insert_into_rejections_reason_track);
														}
														updateM3TransactionsRejections($b_tid,$ops_code,$r_qty,$m3_reason_code);
														
														
														
													}
											}
											updateM3Transactions($b_tid,$ops_code,$rep_m3_qty);
											updatechildtrans($bundle_no,$ops_code,$report_qty,$rejctedqty,$size,$barcode);
											
									}
									else
									{
										updateM3Transactions($b_tid[0],$ops_code,$rep_m3_qty);
										updatechildtrans($bundle_no,$ops_code,$report_qty,$rejctedqty,$size,$barcode);
									}
									
									$result_array['bundle_no'] = $barcode;	
									$result_array['style'] = $style;	
									$result_array['schedule'] = $schedule;	
									$result_array['color_dis'] = $color;	
									$result_array['reported_qty'] = $report_qty-$rejctedqty;	
									$result_array['rejected_qty'] = $rejctedqty;	
									echo json_encode($result_array);
									die();
								}
							}
							else
							{
								if($rec_qty=$good_qty+$rejection_qty)
								{
									$result_array['status'] = 'Already Scanned';
									echo json_encode($result_array);
									die();
								}
								else
								{
									//quantity filling in act_cut_bundle_trn
									$update_qnty_qry="Update $bai_pro3.act_cut_bundle_trn SET good_qty=$report_qty-$rejctedqty,rejection_qty=".$rejctedqty.",status=1 where barcode='".$barcode."'";
									$result_query = $link->query($update_qnty_qry) or exit('query error in updating');					
									// if($pre_ops_code)
									// {
										// $pre_ops_barcode="ACB-".$docket_no."-".$bun_no."-".$pre_ops_code;
										// $update_prev_ops_qry="update $bai_pro3.act_cut_bundle_trn SET remaining_qty=0 where barcode='".$pre_ops_barcode."'";
										// $result_update_query = $link->query($update_prev_ops_qry) or exit('query error in updating pre ops');
									// }
									if($post_ops_code)
									{
										$post_ops_barcode="ACB-".$docket_no."-".$bun_no."-".$post_ops_code;
										$update_post_ops_qry="update $bai_pro3.act_cut_bundle_trn SET send_qty=$report_qty-$rejctedqty where barcode='".$post_ops_barcode."'";
										$result_update_query = $link->query($update_post_ops_qry) or exit('query error in updating post ops');
									}
									
									//updating good quantity in act_cut_bundle
									$post_ops_barcode="ACB-".$docket_no."-".$bun_no."-".$post_ops_code;
									$get_data_qry="select ops_code from $bai_pro3.act_cut_bundle_trn where barcode='".$post_ops_barcode."'";
									$result_data_qry = $link->query($get_data_qry);
									while($row = $result_data_qry->fetch_assoc())
									{
										$opcodeforupdate=$row['ops_code'];
									}
									if($opcodeforupdate=='')
									{
										$update_qnty_qry="Update $bai_pro3.act_cut_bundle SET act_good_qty=act_good_qty+($report_qty-$rejctedqty) where id=".$act_cut_bundle_id."";
										$result_query = $link->query($update_qnty_qry) or exit('query error updating into act_cut_bundle');	
									}
									
									$rep_m3_qty=$report_qty-$rejctedqty;
									if($rejctedqty>0)
									{
										$b_remarks  = '';
										$actual_rejection_reason_array_string = array();
											foreach($rej_data as $reason_key=>$reason_value)
											{   
												//to get form type
												$rejection_code_fetech_qry = "select reason_code,form_type from $bai_pro3.bai_qms_rejection_reason where sno= '$reason_key'";
												$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
												while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
												{
													$reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
													$type = $rowresult_rejection_code_fetech_qry['form_type'];
												}
												$bundle_individual_number=$bundle_no;
												$remain_qty_key=$reason_key;
												$remain_qty_value=$reason_value;
												if($reason_value > 0)
												{   
													$actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$remain_qty_key.'-'. $remain_qty_value ;
													$remarks_code = $reason_code.'-'.$reason_value;
													$remarks_var = $module.'-'.$shift.'-'.$type;
													$bulk_insert_rej = "INSERT INTO $bai_pro3.bai_qms_db(`qms_style`, `qms_schedule`,`qms_color`,`log_user`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`,`remarks`, `ref1`, `doc_no`, `input_job_no`, `operation_id`, `qms_remarks`, `bundle_no`) VALUES";
													$bulk_insert_rej .= '("'.$style.'","'.$schedule.'","'.$color.'","'.$username.'","'.date('Y-m-d').'","'.$size.'","'.$remain_qty_value.'","3","'.$remarks_var.'","'.$remarks_code.'","'.$docket_no.'","'.$input_job_no_random.'","'. $ops_code.'","'. $b_remarks.'","'.$bundle_individual_number.'")';
													$rej_insert_result = $link->query($bulk_insert_rej) or exit('data error');
													//updating BCD
													
													
												}
											}

											//update rejections to M3 trasactions
											if(sizeof($actual_rejection_reason_array_string) > 0)
											{
												for($i=0;$i<sizeof($actual_rejection_reason_array_string);$i++)
													{
														$r_qty = array();
														$r_reasons = array();
														$implode_next = explode('-',$actual_rejection_reason_array_string[$i]);
														$r_qty[] = $implode_next[2];
														$rejection_code_fetech_qry = "select m3_reason_code from $bai_pro3.bai_qms_rejection_reason where sno= $implode_next[1]";
														$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
															while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
															{
																$m3_reason_code = $rowresult_rejection_code_fetech_qry['m3_reason_code'];
															}
														//$r_reasons[] = $m3_reason_code;
														$b_tid = $implode_next[0];
														//retreving bcd id from bundle_ceration_data and inserting into the rejection_log table and rejection_log_child
														$bcd_id_qry = "select id,style,schedule,color,docket_number,size_title,size_id,assigned_module,input_job_no_random_ref from $brandix_bts.bundle_creation_data where bundle_number=$bundle_no and operation_id = $ops_code";
														$bcd_id_qry_result=mysqli_query($link,$bcd_id_qry) or exit("Bcd id qry".mysqli_error($GLOBALS["___mysqli_ston"]));
															while($bcd_id_row=mysqli_fetch_array($bcd_id_qry_result))
															{
																$bcd_id = $bcd_id_row['id'];
																$style = $bcd_id_row['style'];
																$schedule = $bcd_id_row['schedule'];
																$color = $bcd_id_row['color'];
																$doc_no = $bcd_id_row['docket_number'];
																$size_title = $bcd_id_row['size_title'];
																$size_id = $bcd_id_row['size_id'];
																$assigned_module = $bcd_id_row['assigned_module'];
																$input_job_random_ref = $bcd_id_row['input_job_no_random_ref'];
																$doc_value = $bcd_id_row['docket_number'];
															}
														//searching the bcd_id in rejection log child or not
														$bcd_id_searching_qry = "select id,parent_id from $bai_pro3.rejection_log_child where bcd_id = $bcd_id";
														$bcd_id_searching_qry_result=mysqli_query($link,$bcd_id_searching_qry) or exit("bcd_id_searching_qry_result".mysqli_error($GLOBALS["___mysqli_ston"]));
														if($bcd_id_searching_qry_result->num_rows > 0)
														{
															while($bcd_id_searching_qry_result_row=mysqli_fetch_array($bcd_id_searching_qry_result))
															{
																$parent_id = $bcd_id_searching_qry_result_row['parent_id'];
															}
															$update_rejection_log_child_qry = "update $bai_pro3.rejection_log_child set rejected_qty=rejected_qty+$implode_next[2] where bcd_id = $bcd_id";
															mysqli_query($link,$update_rejection_log_child_qry) or exit("update_rejection_log_child_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
															$update_qry_rej_lg = "update $bai_pro3.rejections_log set rejected_qty = rejected_qty+$implode_next[2],remaining_qty=remaining_qty+$implode_next[2] where style='$style' and schedule='$schedule' and color='$color'";
															$update_qry_rej_lg = $link->query($update_qry_rej_lg);
														}
														else
														{
															$search_qry="SELECT id FROM $bai_pro3.rejections_log where style='$style' and schedule='$schedule' and color='$color'";
															// echo $search_qry;
															$result_search_qry = mysqli_query($link,$search_qry) or exit("rejections_log search query".mysqli_error($GLOBALS["___mysqli_ston"]));
															if($result_search_qry->num_rows > 0)
															{
																while($row_result_search_qry=mysqli_fetch_array($result_search_qry))
																{
																	$rejection_log_id = $row_result_search_qry['id'];
																	$update_qry_rej_lg = "update $bai_pro3.rejections_log set rejected_qty = rejected_qty+$implode_next[2],remaining_qty=remaining_qty+$implode_next[2] where id = $rejection_log_id";
																	// echo $update_qry_rej_lg;
																	$update_qry_rej_lg = $link->query($update_qry_rej_lg);
																	$parent_id = $rejection_log_id;
																}

															}
															else
															{
																$insert_qty_rej_log = "INSERT INTO bai_pro3.rejections_log (style,schedule,color,rejected_qty,recut_qty,remaining_qty) VALUES ('$style','$schedule','$color',$implode_next[2],'0',$implode_next[2])";
																$res_insert_qty_rej_log = $link->query($insert_qty_rej_log);
																$parent_id=mysqli_insert_id($link);
															}
															$inserting_into_rejection_log_child_qry = "INSERT INTO `bai_pro3`.`rejection_log_child` (`parent_id`,`bcd_id`,`doc_no`,`input_job_no_random_ref`,`size_id`,`size_title`,`assigned_module`,`rejected_qty`,`operation_id`) values($parent_id,$bcd_id,$doc_no,$input_job_random_ref,'$size_id','$size_title',$assigned_module,$implode_next[2],$ops_code)";
															$insert_qry_rej_child = $link->query($inserting_into_rejection_log_child_qry);
														}
														//inserting into rejections_reason_track'
														if($implode_next[2] > 0)
														{
															$insert_into_rejections_reason_track = "INSERT INTO $bai_pro3.`rejections_reason_track` (`parent_id`,`date_time`,`bcd_id`,`rejected_qty`,`rejection_reason`,`username`,`form_type`) values ($parent_id,DATE_FORMAT(NOW(), '%Y-%m-%d %H'),$bcd_id,'$implode_next[2]','$implode_next[1]','$username','$type')";
															$insert_into_rejections_reason_track_res =$link->query($insert_into_rejections_reason_track);
														}
														updateM3TransactionsRejections($b_tid,$ops_code,$r_qty,$m3_reason_code);
														
													}
											}
											updateM3Transactions($b_tid,$ops_code,$rep_m3_qty);
											updatechildtrans($bundle_no,$ops_code,$report_qty,$rejctedqty,$size,$barcode);
											
									}
									else{
										updateM3Transactions($b_tid[0],$ops_code,$rep_m3_qty);
										updatechildtrans($bundle_no,$ops_code,$report_qty,$rejctedqty,$size,$barcode);
									}	
								}
								
								$result_array['bundle_no'] = $barcode;	
								$result_array['style'] = $style;	
								$result_array['schedule'] = $schedule;	
								$result_array['color_dis'] = $color;	
								$result_array['reported_qty'] = $report_qty-$rejctedqty;	
								$result_array['rejected_qty'] = $rejctedqty;	
								echo json_encode($result_array);
								die();
											
							}
					
				}
				else
				{
					$result_array['status'] = 'Previous Operation Not Yet Done';
					echo json_encode($result_array);
					die();
				}
			}
			else
			{
				$result_array['status'] = 'Please Check The Barcode You Have Scanned';
				echo json_encode($result_array);
				die();
			}
		// }
		// else
		// {
			// $result_array['status'] = 'Please Plan Embellishment For This Dockets';
			// echo json_encode($result_array);
			// die();
		// }
	}
	
	scanningdetails($barcode,$rej_data,$rejctedqty);	
?>	