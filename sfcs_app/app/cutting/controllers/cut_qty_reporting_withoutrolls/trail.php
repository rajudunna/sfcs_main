<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'], "common/config/config.php", 4, 'R')); 
$doc_no_ref = $_GET['doc_no_ref'];
$go_back_to = $_GET['go_back_to'];
$bundle_no = array();
$cut_done_qty = array();
$qry_to_find_in_out = "select * from $brandix_bts.bundle_creation_data where docket_number='$doc_no_ref'";
$qry_to_find_in_out_result = $link->query($qry_to_find_in_out);
if(mysqli_num_rows($qry_to_find_in_out_result) > 0)
{
	$plies = $_GET['plies'];
	$b_op_id = 15;
	$get_docket_details = "SELECT * FROM bai_pro3.`packing_summary_input` WHERE doc_no = '$doc_no_ref';";
	$docket_details_result = $link->query($get_docket_details);
	while($row1 = $docket_details_result->fetch_assoc()) 
	{
		$input_job_no_random = $row1['input_job_no_random'];
		$b_inp_job_ref[] = $row1['input_job_no_random'];
		$b_style = $row1['order_style_no'];
		$b_tid[] = $row1['tid'];
		//$b_style = $row1['style'];
		$b_schedule=$row1['order_del_no'];
		$b_colors[]=$row1['order_col_des'];
		$b_sizes[] =$row1['size_code'];
		$b_size_code[] = $row1['old_size'];
		$b_doc_num[]=$doc_no_ref;
		$b_in_job_qty[]=$row1['carton_act_qty'];
		$b_a_cut_no[] = $row1['acutno'];
		$b_job_no = $row1['input_job_no'];
		$b_shift= 'G';
		$b_remarks[] = 'Normal';
		$b_module  = 0;
		$b_rej_qty[] = 0;
		//$b_rep_qty=$row1['reporting_qty'];
	}
	$b_rep_qty = array();
	$qry_cut_qty_check_qry = "SELECT * FROM $bai_pro3.plandoc_stat_log WHERE doc_no = '$doc_no_ref' ";
	$result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
	while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
	{
		// $doc_array[$row['doc_no']] = $row['act_cut_status'];
		for ($i=0; $i < sizeof($sizes_array); $i++)
		{ 
			if ($row['a_'.$sizes_array[$i]] > 0)
			{
				$cut_done_qty[$sizes_array[$i]] = $row['a_'.$sizes_array[$i]] * $plies;
			}
		}
	}
	foreach ($cut_done_qty as $key => $value)
	{
		$i=0;
		$cumulative_qty = $cut_done_qty[$key];
		$fetching_max_qty_to_insert_in_each_bundle = "select carton_act_qty,tid from $bai_pro3.packing_summary_input where doc_no = $doc_no_ref and old_size = '$key'";
		//echo $fetching_max_qty_to_insert_in_each_bundle;

		$result_fetching_max_qty_to_insert_in_each_bundle = mysqli_query($link,$fetching_max_qty_to_insert_in_each_bundle) or exit("fetching_max_qty_to_insert_in_each_bundle error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($result_fetching_max_qty_to_insert_in_each_bundle))
		{
				$bundle_individual_number = $row['tid'];
				$pre_rec_qty_qry = "select recevied_qty from $brandix_bts.bundle_creation_data where bundle_number = $bundle_individual_number and operation_id = '15'";
				$result_pre_rec_qty_qry = mysqli_query($link,$pre_rec_qty_qry) or exit("fetching_max_qty_to_insert_in_each_bundle error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row_result_pre_rec_qty_qry=mysqli_fetch_array($result_pre_rec_qty_qry))
					{
						$pre_rec_qty = $row_result_pre_rec_qty_qry['recevied_qty'];
					}
				$max_insertion_qty = $row['carton_act_qty']-$pre_rec_qty;
				// echo $max_insertion_qty;
				if($cumulative_qty > 0)
				{
					if($max_insertion_qty <= $cumulative_qty)
					{
						$actual_rec_quantities[] = $max_insertion_qty;
						$rec_qtys_array[$bundle_individual_number] = $max_insertion_qty;
						$cumulative_qty = $cumulative_qty - $max_insertion_qty;
					}
					else if($max_insertion_qty > $cumulative_qty)
					{
						$actual_rec_quantities[] = $cumulative_qty;
						$rec_qtys_array[$bundle_individual_number] = $cumulative_qty;
						$cumulative_qty = 0;
					}
				}
				else
				{
					$actual_rec_quantities[] =0;
					$rec_qtys_array[$bundle_individual_number] = 0;
				}
				
		}
		$i++;
	}
	$b_rep_qty = $actual_rec_quantities;
	$rec_qty =0 ;
	$left_over_qty = 0;
	$map_col_query = "select order_style_no,order_del_no,order_col_des from $bai_pro3.packing_summary_input WHERE input_job_no_random = '$input_job_no_random' order by tid";
		//echo $map_col_query;
	$result_map_col_query = $link->query($map_col_query);
	if($result_map_col_query->num_rows > 0)
	{
		while($row = $result_map_col_query->fetch_assoc()) 
		{
			$mapped_color = $row['order_col_des'];
		}
	}
	$dep_ops_array_qry = "select operation_code,ops_sequence, default_operration,smv from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' and operation_code='$b_op_id'";
	$result_dep_ops_array_qry = $link->query($dep_ops_array_qry);
	while($row = $result_dep_ops_array_qry->fetch_assoc()) 
	{
		//$dep_ops_codes[] = $row['operation_code'];
		$sequnce = $row['ops_sequence'];
		$is_m3 = $row['default_operration'];
		$sfcs_smv = $row['smv'];
	}
	$ops_dep_qry = "SELECT ops_dependency,operation_code,ops_sequence FROM $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' and ops_sequence='$sequnce' AND ops_dependency != 200 AND ops_dependency != 0 group by ops_dependency";
	// $ops_dep_qry.'</br>';
	$result_ops_dep_qry = $link->query($ops_dep_qry);
	while($row = $result_ops_dep_qry->fetch_assoc()) 
	{
		$ops_dep = $row['ops_dependency'];
	}
	$dep_ops_array_qry_raw = "select operation_code from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' and ops_dependency='$ops_dep'";
			$result_dep_ops_array_qry_raw = $link->query($dep_ops_array_qry_raw);
	while($row = $result_dep_ops_array_qry_raw->fetch_assoc()) 
	{
		$dep_ops_codes[] = $row['operation_code'];	
	}
	$ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$mapped_color' and operation_code='$b_op_id'";
	$result_ops_seq_check = $link->query($ops_seq_check);
	while($row = $result_ops_seq_check->fetch_assoc()) 
	{
		$ops_seq = $row['ops_sequence'];
		$seq_id = $row['id'];
		$ops_order = $row['operation_order'];
	}
	$post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$mapped_color' and ops_sequence = $ops_seq  AND operation_order > '$ops_order' ORDER BY operation_order ASC LIMIT 1";
	// echo $post_ops_check;
	$result_post_ops_check = $link->query($post_ops_check);
	if($result_post_ops_check->num_rows > 0)
	{
		while($row = $result_post_ops_check->fetch_assoc()) 
		{
			$post_ops_code = $row['operation_code'];
		}
	}

	// var_dump($b_tid);
	foreach ($b_tid as $key => $value) 
	{
		if($b_rep_qty[$key] > 0 || $b_rej_qty[$key] >0)
		{
			$bulk_insert_post_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`) VALUES";
			$sfcs_smv = 0.00;
			$bulk_insert_post_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$b_remarks[$key].'")';
			// echo $bulk_insert_post_temp;	
			$result_query_001_temp = $link->query($bulk_insert_post_temp) or exit('bulk_insert_post query error in updating');
		}
		if($post_ops_code != null)
		{
			$select_send_qty = "SELECT recevied_qty,rejected_qty FROM $brandix_bts.bundle_creation_data WHERE bundle_number = '$b_tid[$key]' AND operation_id = '$b_op_id'";
						//echo "sele".$select_send_qty;
			$result_select_send_qty = $link->query($select_send_qty);
			if($result_select_send_qty->num_rows >0)
			{
				while($row = $result_select_send_qty->fetch_assoc()) 
				{
					$b_old_rep_qty_new = $row['recevied_qty'];
					$b_old_rej_qty_new = $row['rejected_qty'];

				}
			}
			$final_rep_qty = $b_old_rep_qty_new + $b_rep_qty[$key];
			$final_rej_qty = $b_old_rej_qty_new + $b_rej_qty[$key];
			$query = "UPDATE $brandix_bts.bundle_creation_data SET `recevied_qty`= '".$final_rep_qty."', `rejected_qty`='". $final_rej_qty."', `left_over`= '".$left_over_qty."' , `scanned_date`='". date('Y-m-d')."' where bundle_number ='".$b_tid[$key]."' and operation_id = ".$b_op_id;
			$result_query = $link->query($query) or exit('query error in updating');
			$query_post = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$final_rep_qty."', `scanned_date`='". date('Y-m-d')."' where bundle_number ='".$b_tid[$key]."' and operation_id = ".$post_ops_code;
			$result_query = $link->query($query_post) or exit('query error in updating');
		}
		if($ops_dep)
		{
			$pre_send_qty_qry = "select min(recevied_qty)as recieved_qty from $brandix_bts.bundle_creation_data where bundle_number ='".$b_tid[$key]."' and operation_id in (".implode(',',$dep_ops_codes).")";
			//echo $pre_send_qty_qry;
			$result_pre_send_qty = $link->query($pre_send_qty_qry);
			while($row = $result_pre_send_qty->fetch_assoc()) 
			{
				$pre_recieved_qty = $row['recieved_qty'];
			}

			$query_post_dep = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$pre_recieved_qty."', `scanned_date`='". date('Y-m-d')."' where bundle_number ='".$b_tid[$key]."' and operation_id = ".$ops_dep;
			// $query_post_dep.'</br>';
			$result_query = $link->query($query_post_dep) or exit('query error in updating');

		}
	}
}
else
{

	$b_op_id = 15;
	$get_docket_details = "SELECT * FROM bai_pro3.`packing_summary_input` WHERE doc_no = '$doc_no_ref';";
	$docket_details_result = $link->query($get_docket_details);
	while($row1 = $docket_details_result->fetch_assoc()) 
	{
		$input_job_no_random = $row1['input_job_no_random'];
		$b_inp_job_ref[] = $row1['input_job_no'];
		$b_style = $row1['order_style_no'];
		$b_tid[] = $row1['tid'];
		//$b_style = $row1['style'];
		$b_schedule=$row1['order_del_no'];
		$b_colors[]=$row1['order_col_des'];
		$b_sizes[] =$row1['size_code'];
		$b_size_code[] = $row1['old_size'];
		$b_doc_num[]=$doc_no_ref;
		$b_in_job_qty[]=$row1['carton_act_qty'];
		$b_a_cut_no[] = $row1['acutno'];
		$b_job_no = $row1['input_job_no_random'];
		$b_shift= 'G';
		$b_remarks[] = 'Normal';
		$b_module  = 0;
		//$b_rep_qty=$row1['reporting_qty'];
	}
	$b_rep_qty = array();
	$qry_cut_qty_check_qry = "SELECT * FROM $bai_pro3.plandoc_stat_log WHERE doc_no = '$doc_no_ref' ";
	$result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
	while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
	{
		// $doc_array[$row['doc_no']] = $row['act_cut_status'];
		for ($i=0; $i < sizeof($sizes_array); $i++)
		{ 
			if ($row['a_'.$sizes_array[$i]] > 0)
			{
				$cut_done_qty[$sizes_array[$i]] = $row['a_'.$sizes_array[$i]] * $row['a_plies'];
			}
		}
	}
	foreach ($cut_done_qty as $key => $value)
	{
		$i=0;
		$cumulative_qty = $cut_done_qty[$key];
		$fetching_max_qty_to_insert_in_each_bundle = "select carton_act_qty,tid from $bai_pro3.packing_summary_input where doc_no = $doc_no_ref and old_size = '$key'";
		//echo $fetching_max_qty_to_insert_in_each_bundle;

		$result_fetching_max_qty_to_insert_in_each_bundle = mysqli_query($link,$fetching_max_qty_to_insert_in_each_bundle) or exit("fetching_max_qty_to_insert_in_each_bundle error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($result_fetching_max_qty_to_insert_in_each_bundle))
		{
				$max_insertion_qty = $row['carton_act_qty'];
				$bundle_individual_number = $row['tid'];
				if($cumulative_qty > 0)
				{
					if($max_insertion_qty <= $cumulative_qty)
					{
						$actual_rec_quantities[] = $max_insertion_qty;
						$rec_qtys_array[$bundle_individual_number] = $max_insertion_qty;
						$cumulative_qty = $cumulative_qty - $max_insertion_qty;
					}
					else if($max_insertion_qty > $cumulative_qty)
					{
						$actual_rec_quantities[] = $cumulative_qty;
						$rec_qtys_array[$bundle_individual_number] = $cumulative_qty;
						$cumulative_qty = 0;
					}
				}
				else
				{
					$actual_rec_quantities[] =0;
					$rec_qtys_array[$bundle_individual_number] = 0;
				}
				
		}
		$i++;
	}
	$b_rep_qty = $actual_rec_quantities;
	// var_dump($rec_qtys_array);
	// die();
	$bulk_insert = "INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`,`mapped_color`) VALUES";
			// temp table data insertion query.........
				$bulk_insert_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`) VALUES";
	$map_col_query = "select order_style_no,order_del_no,order_col_des from $bai_pro3.packing_summary_input WHERE input_job_no_random = '$input_job_no_random' order by tid";
		//echo $map_col_query;
	$result_map_col_query = $link->query($map_col_query);
	if($result_map_col_query->num_rows > 0)
	{
		while($row = $result_map_col_query->fetch_assoc()) 
		{
			$mapped_color = $row['order_col_des'];
		}
	}
	$dep_ops_array_qry = "select operation_code,ops_sequence, default_operration,smv from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' and operation_code='15'";
	// echo $dep_ops_array_qry;
	$result_dep_ops_array_qry = $link->query($dep_ops_array_qry);
	while($row = $result_dep_ops_array_qry->fetch_assoc()) 
	{
		//$dep_ops_codes[] = $row['operation_code'];
		$sequnce = $row['ops_sequence'];
		$is_m3 = $row['default_operration'];
		$sfcs_smv = $row['smv'];
	}
	$ops_dep_qry = "SELECT ops_dependency,operation_code,ops_sequence FROM $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' and ops_sequence='$sequnce' AND ops_dependency != 200 AND ops_dependency != 0 group by ops_dependency";
	// $ops_dep_qry.'</br>';
	$result_ops_dep_qry = $link->query($ops_dep_qry);
	while($row = $result_ops_dep_qry->fetch_assoc()) 
	{
		$ops_dep = $row['ops_dependency'];
	}
	$dep_ops_array_qry_raw = "select operation_code from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' and ops_dependency='$ops_dep'";
	$result_dep_ops_array_qry_raw = $link->query($dep_ops_array_qry_raw);
	while($row = $result_dep_ops_array_qry_raw->fetch_assoc()) 
	{
		$dep_ops_codes[] = $row['operation_code'];	
	}
	$ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$mapped_color' and operation_code='$b_op_id'";
	$result_ops_seq_check = $link->query($ops_seq_check);
	while($row = $result_ops_seq_check->fetch_assoc()) 
	{
		$ops_seq = $row['ops_sequence'];
		$seq_id = $row['id'];
		$ops_order = $row['operation_order'];
	}
	if($ops_dep)
	{
		$dep_ops_array_qry_seq = "select ops_dependency,operation_code,ops_sequence from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' AND ops_dependency != 200 AND ops_dependency != 0";
		// $dep_ops_array_qry_seq.'</br>';
		$result_dep_ops_array_qry_seq = $link->query($dep_ops_array_qry_seq);
		while($row = $result_dep_ops_array_qry_seq->fetch_assoc()) 
		{
			$ops_dep_ary[] = $row['ops_dependency'];
		}
	}
	else
	{
		$ops_dep_ary[] = null;
	}
	if($ops_dep_ary[0] != null)
	{
		$ops_seq_qrs = "select ops_sequence from $brandix_bts.tbl_style_ops_master WHERE style='".$b_style."' AND color = '".$mapped_color."' AND operation_code in (".implode(',',$ops_dep_ary).")";
		$result_ops_seq_qrs = $link->query($ops_seq_qrs);
		while($row = $result_ops_seq_qrs->fetch_assoc()) 
		{
			$ops_seq_dep[] = $row['ops_sequence'];
		}
	}
	else
	{
		$ops_seq_dep[] = $ops_seq;
	}
	$pre_ops_check = "select operation_code,ops_sequence from $brandix_bts.tbl_style_ops_master where style='".$b_style."' and color = '".$mapped_color."' and (ops_sequence = ".$ops_seq." or ops_sequence in  (".implode(',',$ops_seq_dep)."))";
	$result_pre_ops_check = $link->query($pre_ops_check);
	if($result_pre_ops_check->num_rows > 0)
	{
		while($row = $result_pre_ops_check->fetch_assoc()) 
		{
			if($row['ops_sequence'] != 0)
			{
				$pre_ops_code[] = $row['operation_code'];
			}
		}
	}
	// var_dump($pre_ops_code);
	foreach($pre_ops_code as $index => $op_code)
	{
		if($op_code != $b_op_id)
		{
			$b_query[$op_code] = "INSERT  INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `mapped_color`) VALUES";
			$b_query_temp[$op_code] = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`) VALUES";
		}
	}
	// var_dump($b_query);
	foreach ($b_tid as $key => $value) 
	{
		foreach($pre_ops_code as $index => $op_code)
		{
			$dep_check_query = "SELECT * from $brandix_bts.bundle_creation_data where bundle_number = $b_tid[$key] and operation_id = $op_code";
			//echo $dep_check_query;
			$dep_check_result = $link->query($dep_check_query) or exit('dep_check_query error');
			if(mysqli_num_rows($dep_check_result) <= 0)
			{
				//change values here in query....
				if($op_code != $b_op_id)
				{
					$send_qty = $b_rep_qty[$key];
					$rec_qty =0 ;
					$rej_qty = 0;
					$left_over_qty = 0;
					$b_query[$op_code] .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$send_qty.'","'.$rec_qty.'","'.$rej_qty.'","'.$left_over_qty.'","'. $op_code.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$b_remarks[$key].'","'.$mapped_color.'"),';

					$b_query_temp[$op_code] .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$send_qty.'","'.$rec_qty.'","'.$rej_qty.'","'.$left_over_qty.'","'. $op_code.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'"),';
				}
			}
		}
		if($ops_dep)
		{
			$pre_send_qty_qry = "select min(recevied_qty)as recieved_qty from $brandix_bts.bundle_creation_data where bundle_number ='".$b_tid[$key]."' and operation_id in (".implode(',',$dep_ops_codes).")";
			//echo $pre_send_qty_qry;
			$result_pre_send_qty = $link->query($pre_send_qty_qry);
			while($row = $result_pre_send_qty->fetch_assoc()) 
			{
				$pre_recieved_qty = $row['recieved_qty'];
			}
			$query_post_dep = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$pre_recieved_qty."', `scanned_date`='". date('Y-m-d')."' where bundle_number ='".$b_tid[$key]."' and operation_id = ".$ops_dep;
			//echo $query_post_dep.'</br>';
			$result_query = $link->query($query_post_dep) or exit('query error in updating');
		}
		// $b_rep_qty[$key] =10;
		$b_rej_qty[$key] = 0;
		$left_over_qty = 0;
		$bulk_insert .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$b_remarks[$key].'","'.$mapped_color.'"),';
			// temp table data insertion query.........
			if($b_rep_qty[$key] > 0 || $b_rej_qty[$key] > 0)
			{
				$bulk_insert_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$b_remarks[$key].'"),';
			}
	}

	foreach($b_query as $index1 => $query)
	{
			if(substr($query, -1) == ','){
				$final_query_001 = substr($query, 0, -1);
			}else{
				$final_query_001 = $query;
			}
			//echo $final_query_001;
			$bundle_creation_result_001 = $link->query($final_query_001);
		}
		if(substr($bulk_insert, -1) == ','){
			$final_query_000 = substr($bulk_insert, 0, -1);
		}else{
			$final_query_000 = $bulk_insert;
		}
		// echo $bulk_insert.'<br>';
		$bundle_creation_result = $link->query($final_query_000);
		// temp tables data insertion query execution..........
		if(substr($bulk_insert_temp, -1) == ','){
			$final_query_000_temp = substr($bulk_insert_temp, 0, -1);
		}else{
			$final_query_000_temp = $bulk_insert_temp;
		}
		//echo $bulk_insert.'<br>';
		$bundle_creation_result_temp = $link->query($final_query_000_temp);
		//$bundle_creation_post_result = $link->query($bulk_insert_post);
		//echo $bulk_insert_rej;
	
}
echo "<div class=\"alert alert-success\">
<strong>Successfully Cutting Reported.</strong>
</div>";
if ($go_back_to == 'doc_track_panel_cut')
{
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = '".getFullURLLevel($_GET['r'],'doc_track_panel_cut.php',0,'N')."'; }</script>";
}
else if ($go_back_to == 'doc_track_panel_withrolls')
{
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = '".getFullURLLevel($_GET['r'],'cut_qty_reporting_withrolls/doc_track_panel.php',1,'N')."'; }</script>";
}
else if ($go_back_to == 'doc_track_panel_withrolls_recut')
{
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = '".getFullURLLevel($_GET['r'],'cut_qty_reporting_withrolls/doc_track_panel_recut.php',1,'N')."'; }</script>";
}
else if ($go_back_to == 'doc_track_panel_without_recut')
{
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = '".getFullURLLevel($_GET['r'],'doc_track_panel.php',1,'N')."'; }</script>";
}


?>