<?php
include("../../../../../common/config/config_ajax.php");
$post_data = $_POST['bulk_data'];
parse_str($post_data,$new_data);
//var_dump($new_data['tid']);
$operation_code = $new_data['operation_id'];
$form = 'P';
$ops_dep='';
$post_ops_code='';
$qry_status='';
// error_reporting(0);
// $username = user();
if($operation_code >=130 && $operation_code < 300)
{
	$form = 'G';
}
$qery_rejection_resons = "select * from $bai_pro3.bai_qms_rejection_reason where form_type = '$form'";
//echo $qery_rejection_resons;
$result_rejections = $link->query($qery_rejection_resons);
$table_name = $new_data['flag'];
$b_job_no = $new_data['job_number'];
$b_style= $new_data['style'];
$b_schedule=$new_data['schedule'];
$b_colors=$new_data['colors'];
$b_sizes = $new_data['sizes'];
$b_size_code = $new_data['old_size'];
$b_doc_num=$new_data['doc_no'];
$b_in_job_qty=$new_data['job_qty'];
$b_rep_qty=$new_data['reporting_qty'];
$b_rej_qty=$new_data['rejection_qty'];
$b_op_id = $new_data['operation_id'];
$b_op_name = $new_data['operation_name'];
$b_tid = $new_data['tid'];
$b_inp_job_ref = $new_data['inp_job_ref'];
$b_a_cut_no = $new_data['a_cut_no'];
$b_module = $new_data['module'];
$b_remarks = $new_data['sampling'];
$b_shift = $new_data['shift'];
$b_old_rep_qty = $new_data['old_rep_qty'];
$b_old_rej_qty = $new_data['old_rej_qty'];
$flag_decision = false;
// RejectionS (bai_qms_db)
$r_reasons=$new_data['reason_data'];
$r_qty=$new_data['qty_data'];
$r_no_reasons = $new_data['tot_reasons'];
$mapped_color = $new_data['color'];
$type = $form;
$barcode_generation =  $new_data['barcode_generation'];
$concurrent_flag = 0;
//user concatnation issue resolving method
foreach ($b_tid as $key=>$value)
{
	$select_send_qty = "SELECT send_qty,recevied_qty FROM $brandix_bts.bundle_creation_data WHERE bundle_number = '$b_tid[$key]' AND operation_id = '$b_op_id'";
	//echo $select_send_qty;
	$result_select_send_qty = $link->query($select_send_qty);
	if($result_select_send_qty->num_rows >0)
	{
		while($row = $result_select_send_qty->fetch_assoc()) 
		{
			$send_qty = $row['send_qty'];
			$pre_recieved_qty = $row['recevied_qty'];
			$act_reciving_qty = $b_rep_qty[$key];
			$total_rec_qty = $pre_recieved_qty + $act_reciving_qty;
			if($total_rec_qty > $send_qty)
			{
				echo "<h1 style='color:red;'>You are Receiving More than eligible quantity.</h1>";
				$concurrent_flag = 1;
			}
		}
	}
} 


if($concurrent_flag == 0)
{
	if($barcode_generation == 0)
{
	$fetching_job_number_from_bundle = "select input_job_no_random FROM $bai_pro3.packing_summary_input where tid='$b_job_no'";
	$result_fetching_job_number_from_bundle = $link->query($fetching_job_number_from_bundle);
	while($row = $result_fetching_job_number_from_bundle->fetch_assoc()) 
	{
		$b_job_no = $row['input_job_no_random'];
	}
}
// $select_modudle_qry = "select input_module from $bai_pro3.plan_dashboard_input where input_job_no_random_ref = $b_job_no";
// echo $select_modudle_qry;
// die();
$remarks_var = $b_module.'-'.$b_shift.'-'.$type;
//echo $remarks_var;
$reason_flag = false;
$dep_ops_array_qry = "select operation_code,ops_sequence, default_operration,smv from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$b_colors[0]' and operation_code='$b_op_id'";
// echo $dep_ops_array_qry."<br>";
$result_dep_ops_array_qry = $link->query($dep_ops_array_qry);
while($row = $result_dep_ops_array_qry->fetch_assoc()) 
{
	//$dep_ops_codes[] = $row['operation_code'];
	$sequnce = $row['ops_sequence'];
	$is_m3 = $row['default_operration'];
	$sfcs_smv = $row['smv'];
	
}
$ops_dep_qry = "SELECT ops_dependency,operation_code,ops_sequence FROM $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$b_colors[0]' and ops_sequence='$sequnce' AND ops_dependency != 200 AND ops_dependency != 0 group by ops_dependency";
//echo $ops_dep_qry."<br>";
//die();
$result_ops_dep_qry = $link->query($ops_dep_qry);
while($row = $result_ops_dep_qry->fetch_assoc()) 
{
	$ops_dep = $row['ops_dependency'];
}
$dep_ops_array_qry_raw = "select operation_code from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$b_colors[0]' and ops_dependency='$ops_dep'";
$result_dep_ops_array_qry_raw = $link->query($dep_ops_array_qry_raw);
while($row = $result_dep_ops_array_qry_raw->fetch_assoc()) 
{
	$dep_ops_codes[] = $row['operation_code'];	
}
$ops_seq_check = "select id,ops_sequence from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$b_colors[0]' and operation_code='$b_op_id'";
$result_ops_seq_check = $link->query($ops_seq_check);
while($row = $result_ops_seq_check->fetch_assoc()) 
{
	$ops_seq = $row['ops_sequence'];
	$seq_id = $row['id'];
}
if($ops_dep)
{
	$dep_ops_array_qry_seq = "select ops_dependency,operation_code,ops_sequence from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$b_colors[0]' AND ops_dependency != 200 AND ops_dependency != 0 group by ops_dependency";
	//echo $dep_ops_array_qry_seq;
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
//var_dump($ops_dep_ary);
if($ops_dep_ary[0] != null)
{
	$ops_seq_qrs = "select ops_sequence from $brandix_bts.tbl_style_ops_master WHERE style='".$b_style."' AND color = '".$b_colors[0]."' AND operation_code in (".implode(',',$ops_dep_ary).")";
	//echo $ops_seq_qrs;
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

$pre_ops_check = "select operation_code,ops_sequence from $brandix_bts.tbl_style_ops_master where style='".$b_style."' and color = '".$b_colors[0]."' and (ops_sequence = ".$ops_seq." or ops_sequence in  (".implode(',',$ops_seq_dep)."))";
//echo $pre_ops_check;
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
$post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$b_colors[0]' and ops_sequence = $ops_seq and id > $seq_id order by id limit 1";
// echo $pre_ops_check;
$result_post_ops_check = $link->query($post_ops_check);
if($result_post_ops_check->num_rows > 0)
{
	while($row = $result_post_ops_check->fetch_assoc()) 
	{
		$post_ops_code = $row['operation_code'];
	}
}
foreach($pre_ops_code as $index => $op_code){
	if($op_code != $b_op_id){
		$b_query[$op_code] = "INSERT ingonre INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `mapped_color`) VALUES";

		// temp table data query

		$b_query_temp[$op_code] = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`) VALUES";
	}
}

// (`id`,`date_time`,`cut_number`,`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`missing_qty`,`rejected_qty`,`left_over`,`operation_id`,`operation_sequence`,`ops_dependency`,`docket_number`,`bundle_status`,`split_status`,`sewing_order_status`,`is_sewing_order`,`sewing_order`,`assigned_module`,`remarks`,`scanned_date`,`shift`,`scanned_user`,`sync_status`,`shade`)


//(`style`,`schedule`,`color`,`size_title`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`)
$m3_bulk_bundle_insert = "INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_reason,sfcs_remarks,sfcs_log_user,m3_op_code,sfcs_job_no,sfcs_mod_no,sfcs_shift,m3_op_des,sfcs_tid_ref,m3_error_code) VALUES";

if($table_name == 'packing_summary_input'){
	// (`qms_style`, `qms_schedule`,`qms_color`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`, `remarks`, `doc_no`, `input_job_no`)
	

	$bulk_insert = "INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`,`mapped_color`) VALUES";
	// temp table data insertion query.........
	$bulk_insert_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`) VALUES";

	// $bulk_insert_post = $bulk_insert;
	$bulk_insert_rej = "INSERT INTO $bai_pro3.bai_qms_db(`qms_style`, `qms_schedule`,`qms_color`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`,`remarks` ,`ref1`, `doc_no`,`input_job_no`,`operation_id`,`qms_remarks`) VALUES";

	
	foreach ($b_tid as $key => $tid) {
		
			$smv_query = "select smv from $brandix_bts.tbl_style_ops_master where style='$b_style' and color='$b_colors[$key]' and operation_code = $b_op_id";
			$result_smv_query = $link->query($smv_query);
			while($row_ops = $result_smv_query->fetch_assoc()) 
			{
				$sfcs_smv = $row_ops['smv'];
			}
		$remarks_code = "";

		if($b_rep_qty[$key] == null){
			$b_rep_qty[$key] = 0;
		}
		if($b_rej_qty[$key] == null){
			$b_rej_qty[$key] = 0;
		}
		$left_over_qty = $b_in_job_qty[$key] - ($b_rep_qty[$key] + $b_rej_qty[$key]);
		// appending all values to query for bulk insert....

		if($r_qty[$tid] != null && $r_reasons[$tid] != null){
			$r_qty_array = explode(',',$r_qty[$tid]);
			$r_reasons_array = explode(',',$r_reasons[$tid]);

			foreach ($r_qty_array as $index => $r_qnty) {
				//m3 operations............. 
				$m3_bulk_bundle_insert .= '("'.date('Y-m-d').'","'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'. $b_size_code[$key].'","'. $b_sizes[$key].'","'.$b_doc_num[$key].'","'.$r_qty_array[$index].'","'.$r_reasons_array[$index].'","'.$b_remarks[$key].'",USER(),"'. $b_op_id.'","'.$b_inp_job_ref[$key].'","'.$b_module.'","'.$b_shift.'","'.$b_op_name.'","'.$b_tid[$key].'",""),';
				$rejection_code_fetech_qry = "select reason_code from $bai_pro3.bai_qms_rejection_reason where m3_reason_code= '$r_reasons_array[$index]'";
				//echo $rejection_code_fetech_qry;
				$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
				while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
				{
					$reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
				}
				if($index == sizeof($r_qty_array)-1){
					$remarks_code .= $reason_code.'-'.$r_qnty;
				}else {
					$remarks_code .= $reason_code.'-'.$r_qnty.'$';
				}
			}
		}		
		// (`qms_style`, `qms_schedule`,`qms_color`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`, `remarks`, `doc_no`, `input_job_no`)
		$bulk_insert .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$b_remarks[$key].'","'.$mapped_color.'"),';

		// temp table data insertion query.........
		if($b_rep_qty[$key] > 0 || $b_rej_qty[$key] > 0)
		{
			$bulk_insert_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$b_remarks[$key].'"),';
		}
		//m3 operations............. 
		if($b_rep_qty[$key] > 0) {
			$m3_bulk_bundle_insert .= '("'.date('Y-m-d').'","'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'.$b_doc_num[$key].'","'.$b_rep_qty[$key].'","","'.$b_remarks[$key].'",USER(),"'. $b_op_id.'","'.$b_inp_job_ref[$key].'","'.$b_module.'","'.$b_shift.'","'.$b_op_name.'","'.$b_tid[$key].'",""),';
			$flag_decision = true;
		}
		//$bulk_insert_post .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'. $b_sizes[$key].'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","0","0","'.$left_over_qty.'","'. $ops_post.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'")';
		$count = 1;
		foreach($pre_ops_code as $index => $op_code){
			//echo $op_code."<br>";
			//echo $b_op_id;
			if($op_code != $b_op_id)
			{
				
				$dep_check_query = "SELECT * from $brandix_bts.bundle_creation_data where bundle_number = $b_tid[$key] and operation_id = $op_code";
				//echo $dep_check_query;
				$dep_check_result = $link->query($dep_check_query) or exit('dep_check_query error');
				if(mysqli_num_rows($dep_check_result) <= 0){
				//change values here in query....
					$send_qty = $b_rep_qty[$key];
					$rec_qty = 0;
					$rej_qty = 0;
					$b_query[$op_code] .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$send_qty.'","'.$rec_qty.'","'.$rej_qty.'","'.$left_over_qty.'","'. $op_code.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$b_remarks[$key].'","'.$mapped_color.'"),';

					$b_query_temp[$op_code] .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$send_qty.'","'.$rec_qty.'","'.$rej_qty.'","'.$left_over_qty.'","'. $op_code.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'"),';
					$count++;
				}
			}
		}

		if($r_qty[$tid] != null && $r_reasons[$tid] != null){
			$bulk_insert_rej .= '("'.$b_style.'","'.$b_schedule.'","'.$b_colors[$key].'","'.date('Y-m-d').'","'.$b_sizes[$key].'","'.$b_rej_qty[$key].'","3","'.$remarks_var.'","'.$remarks_code.'","'.$b_doc_num[$key].'","'.$b_job_no.'","'. $b_op_id.'","'. $b_remarks[$key].'"),';
			$reason_flag = true;
		}
	} 
	//all operation codes query.. (not tested)
	foreach($b_query as $index1 => $query){
		if(substr($query, -1) == ','){
			$final_query_001 = substr($query, 0, -1);
		}else{
			$final_query_001 = $query;
		}
		//echo $final_query_001;
		$bundle_creation_result_001 = $link->query($final_query_001);
	}

	// foreach($b_query_temp as $index1 => $query_temp){
	// 	if(substr($query_temp, -1) == ','){
	// 		$final_query_002 = substr($query_temp, 0, -1);
	// 	}else{
	// 		$final_query_002 = $query_temp;
	// 	}
	// 	$bundle_creation_result_002 = $link->query($final_query_002);
	// }
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
	if($reason_flag){
		if(substr($bulk_insert_rej, -1) == ','){
			$final_query = substr($bulk_insert_rej, 0, -1);
		}else{
			$final_query = $bulk_insert_rej;
		}
		$rej_insert_result = $link->query($final_query) or exit('data error');
	}
	//echo $m3_bulk_bundle_insert;
	
	if(strtolower($is_m3) == 'yes' && $flag_decision){
		if(substr($m3_bulk_bundle_insert, -1) == ','){
			$final_query100 = substr($m3_bulk_bundle_insert, 0, -1);
		}else{
			$final_query100 = $m3_bulk_bundle_insert;
		}
		//echo $final_query100;
		// die();
		$rej_insert_result100 = $link->query($final_query100) or exit('data error');
	}
	$sql_message = 'Data inserted successfully';
	
}
else{
	$query = '';
	
	if($table_name == 'bundle_creation_data'){
		
		
		
		
		$bulk_insert_rej = "INSERT INTO $bai_pro3.bai_qms_db(`qms_style`, `qms_schedule`,`qms_color`,`log_user`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`,`remarks`, `ref1`, `doc_no`, `input_job_no`, `operation_id`, `qms_remarks`) VALUES";

		$schedule_count_query = "SELECT input_job_no_random_ref FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = $b_job_no AND operation_id ='$b_op_id'";

		// echo $schedule_count_query.'<br>';
		$schedule_count_query = $link->query($schedule_count_query) or exit('query error');
		
		if($schedule_count_query->num_rows > 0)
		{
			$schedule_count = true;
		}else{
			$schedule_count = false;
		}
		foreach ($b_tid as $key => $tid) 
		{
			$smv_query = "select smv from $brandix_bts.tbl_style_ops_master where style='$b_style' and color='$b_colors[$key]' and operation_code = $b_op_id";
			$result_smv_query = $link->query($smv_query);
			while($row_ops = $result_smv_query->fetch_assoc()) 
			{
				$sfcs_smv = $row_ops['smv'];
			}
			$bulk_insert_post = "INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`) VALUES";

			$bulk_insert_post_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`) VALUES";

			$remarks_code = "";
			// echo $tid.'<br>';
			if($b_rep_qty[$key] == null){
				$b_rep_qty[$key] = 0;
			}
			if($b_rej_qty[$key] == null){
				$b_rej_qty[$key] = 0;
			}
			// $left_over_qty = $b_in_job_qty[$key] - ($b_rep_qty[$key] + $b_rej_qty[$key]);
			// appending all values to query for bulk insert....

			if($r_qty[$tid] != null && $r_reasons[$tid] != null){
				$r_qty_array = explode(',',$r_qty[$tid]);
				$r_reasons_array = explode(',',$r_reasons[$tid]);
				if(sizeof($r_qty_array)>0)
				{
					$flag_decision = true;
				}
				foreach ($r_qty_array as $index => $r_qnty) {
					//m3 operations............. 
					$m3_bulk_bundle_insert .= '("'.date('Y-m-d').'","'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'. $b_size_code[$key].'","'. $b_sizes[$key].'","'.$b_doc_num[$key].'","'.$r_qty_array[$index].'","'.$r_reasons_array[$index].'","'.$b_remarks[$key].'",USER(),"'. $b_op_id.'","'.$b_inp_job_ref[$key].'","'.$b_module.'","'.$b_shift.'","'.$b_op_name.'","'.$b_tid[$key].'",""),';
					$rejection_code_fetech_qry = "select reason_code from $bai_pro3.bai_qms_rejection_reason where m3_reason_code= '$r_reasons_array[$index]'";
				//echo $rejection_code_fetech_qry;
					$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
					while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
					{
						$reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
					}
					if($index == sizeof($r_qty_array)-1){
						$remarks_code .= $reason_code.'-'.$r_qnty;
					}else {
						$remarks_code .= $reason_code.'-'.$r_qnty.'$';
					}
				}
			}	
			// if($b_rep_qty[$key] > 0 || $b_rej_qty[$key] > 0) {
				$final_rep_qty = $b_old_rep_qty[$key] + $b_rep_qty[$key];
				$final_rej_qty = $b_old_rej_qty[$key] + $b_rej_qty[$key];
				$left_over_qty = $b_in_job_qty[$key] - $final_rep_qty - $final_rej_qty;
				if($schedule_count){
					$query = "UPDATE $brandix_bts.bundle_creation_data SET `recevied_qty`= '".$final_rep_qty."', `rejected_qty`='". $final_rej_qty."', `left_over`= '".$left_over_qty."' , `scanned_date`='". date('Y-m-d')."' where bundle_number ='".$b_tid[$key]."' and operation_id = ".$b_op_id;
					
					$result_query = $link->query($query) or exit('query error in updating');
				}else{
					
					$bulk_insert_post .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'")';	
					$result_query_001 = $link->query($bulk_insert_post) or exit('bulk_insert_post query error in updating');
				}
				//m3 operations............. 
				if($b_rep_qty[$key] > 0){
					$m3_bulk_bundle_insert .= '("'.date('Y-m-d').'","'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'. $b_size_code[$key].'","'. $b_sizes[$key].'","'.$b_doc_num[$key].'","'.$b_rep_qty[$key].'","","'.$b_remarks[$key].'",USER(),"'. $b_op_id.'","'.$b_inp_job_ref[$key].'","'.$b_module.'","'.$b_shift.'","'.$b_op_name.'","'.$b_tid[$key].'",""),';
					$flag_decision = true;
				}

					
					if($b_rep_qty[$key] > 0 || $b_rej_qty[$key] >0)
					{
						$bulk_insert_post_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$b_remarks[$key].'")';	
						$result_query_001_temp = $link->query($bulk_insert_post_temp) or exit('bulk_insert_post query error in updating');
					}
					
				
				if($post_ops_code != null)
				{
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

					$result_query = $link->query($query_post_dep) or exit('query error in updating');
			
				}
				 
			// }
			if($r_qty[$tid] != null && $r_reasons[$tid] != null){
				$bulk_insert_rej .= '("'.$b_style.'","'.$b_schedule.'","'.$b_colors[$key].'",user(),"'.date('Y-m-d').'","'.$b_sizes[$key].'","'.$b_rej_qty[$key].'","3","'.$remarks_var.'","'.$remarks_code.'","'.$b_doc_num[$key].'","'.$b_job_no.'","'. $b_op_id.'","'. $b_remarks[$key].'"),';
				$reason_flag = true;
			}
		}
		if($reason_flag){
			if(substr($bulk_insert_rej, -1) == ','){
				$final_query = substr($bulk_insert_rej, 0, -1);
			}else{
				$final_query = $bulk_insert_rej;
			}
			//echo $final_query;
			$rej_insert_result = $link->query($final_query) or exit('data error');
		}
		if(strtolower($is_m3) == 'yes' && $flag_decision){
			if(substr($m3_bulk_bundle_insert, -1) == ','){
				$final_query100 = substr($m3_bulk_bundle_insert, 0, -1);
			}else{
				$final_query100 = $m3_bulk_bundle_insert;
			}
			// echo $final_query100;;
			$rej_insert_result100 = $link->query($final_query100) or exit('data error');
		}
		// }
		// $sql_message = 'Data Updated Successfully';
	}
}
//echo "<script>$('#storingfomr').submit()</script>";
$table_data = "<table class='table table-bordered'><tr><th>Input Job</th><th>Bundle Number</th><th>Color</th><th>Size</th><th>Remarks</th><th>Reporting Qty</th><th>Rejecting Qty</th></tr>";
for($i=0;$i<sizeof($b_tid);$i++)
{
	
	if($b_op_id == 100 || $b_op_id == 129)
	{
		//Searching whethere the operation was present in the ims log and ims buff
		$searching_query_in_imslog = "SELECT * FROM $bai_pro3.ims_log WHERE pac_tid = '$b_tid[$i]' AND ims_mod_no='$b_module' AND ims_style='$b_style' AND ims_schedule='$b_schedule' AND ims_color='$b_colors[$i]' AND input_job_rand_no_ref='$b_job_no' AND operation_id='$b_op_id' AND ims_remarks = '$b_remarks[$i]'";
		//echo $searching_query_in_imslog;
		$result_searching_query_in_imslog = $link->query($searching_query_in_imslog);
		if($result_searching_query_in_imslog->num_rows > 0)
		{
			while($row = $result_searching_query_in_imslog->fetch_assoc()) 
			{
				$updatable_id = $row['tid'];
				$pre_ims_qty = $row['ims_qty'];
			}
			$act_ims_qty = $pre_ims_qty + $b_rep_qty[$i] ;
			//updating the ims_qty when it was there in ims_log
			$update_query = "update $bai_pro3.ims_log set ims_qty = $act_ims_qty where tid = $updatable_id";
			mysqli_query($link,$update_query) or exit("While updating ims_qty in ims_log".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		else
		{
			//$ims_date=date('Y-m-d', strtotime($ims_log_date);
			$cat_ref=0;
			$catrefd_qry="select * FROM $bai_pro3.plandoc_stat_log WHERE order_tid in (select order_tid FROM bai_pro3.bai_orders_db WHERE order_style_no='$b_style' AND order_del_no='$b_schedule' AND order_col_des='$b_colors[$i]')";
			// echo "<br>Cat Qry :".$catrefd_qry."</br>";
			$catrefd_qry_result=mysqli_query($link,$catrefd_qry);
			while($buyer_qry_row=mysqli_fetch_array($catrefd_qry_result))
			{
				$cat_ref=$buyer_qry_row['cat_ref'];
			}
			$sizevalue="a_".$b_size_code[$i];
			$bundle_op_id=$b_tid[$i]."-".$b_op_id."-".$b_inp_job_ref[$i].'-'.$b_remarks[$i];
			$ims_log_date=date("Y-m-d");
			$insert_imslog="insert into $bai_pro3.ims_log (ims_date,ims_cid,ims_doc_no,ims_mod_no,ims_shift,
			ims_size,ims_qty,ims_log_date,ims_style,ims_schedule,ims_color,rand_track,bai_pro_ref,input_job_rand_no_ref,input_job_no_ref,pac_tid,ims_remarks,operation_id) values ('".$ims_log_date."','".$cat_ref."','".$b_doc_num[$i]."','".$b_module."','".$b_shift."','".trim($sizevalue)."','".$b_rep_qty[$i]."',CURRENT_TIMESTAMP(),'".$b_style."','".$b_schedule."','".$b_colors[$i]."','$b_doc_num[$i]','$bundle_op_id','".$b_job_no."','".$b_inp_job_ref[$i]."','".$b_tid[$i]."','".$b_remarks[$i]."','".$b_op_id."')";
			//echo "Insert Ims log :".$insert_imslog."</br>";
			$qry_status=mysqli_query($link,$insert_imslog);
			
		}
	}
	else
	{
		//getting input ops code from output ops with operation sequence
		$selecting_output_from_seq_query = "select operation_code from $brandix_bts.tbl_style_ops_master where ops_sequence = $ops_seq and operation_code != $b_op_id and style='$b_style' and color = '$mapped_color'";
		$result_selecting_output_from_seq_query = $link->query($selecting_output_from_seq_query);
		while($row = $result_selecting_output_from_seq_query->fetch_assoc()) 
		{
			$input_ops_code = $row['operation_code'];
		}
		if($input_ops_code == 100 || $input_ops_code == 129)
		{
			//updating ims_pro_qty against the input
			$searching_query_in_imslog = "SELECT * FROM $bai_pro3.ims_log WHERE pac_tid = '$b_tid[$i]' AND ims_mod_no='$b_module' AND ims_style='$b_style' AND ims_schedule='$b_schedule' AND ims_color='$b_colors[$i]' AND input_job_rand_no_ref='$b_job_no' AND operation_id='$input_ops_code' AND ims_remarks = '$b_remarks[$i]'";
			$result_searching_query_in_imslog = $link->query($searching_query_in_imslog);
			if($result_searching_query_in_imslog->num_rows > 0)
			{
				while($row = $result_searching_query_in_imslog->fetch_assoc()) 
				{
					$updatable_id = $row['tid'];
					$pre_ims_qty = $row['ims_pro_qty'];
					$act_ims_input_qty = $row['ims_qty'];
				}
				$act_ims_qty = $pre_ims_qty + $b_rep_qty[$i] ;
				//updating the ims_qty when it was there in ims_log
				$update_query = "update $bai_pro3.ims_log set ims_pro_qty = $act_ims_qty where tid = $updatable_id";
				$ims_pro_qty_updating = mysqli_query($link,$update_query) or exit("While updating ims_pro_qty in ims_log".mysqli_error($GLOBALS["___mysqli_ston"]));
				if($ims_pro_qty_updating)
				{
					if($act_ims_input_qty == $act_ims_qty)
					{
						$update_status_query = "update $bai_pro3.ims_log set ims_status = 'DONE' where tid = $updatable_id";
						mysqli_query($link,$update_status_query) or exit("While updating status in ims_log".mysqli_error($GLOBALS["___mysqli_ston"]));
						$ims_backup="insert into $bai_pro3.ims_log_backup select * from bai_pro3.ims_log where tid=$updatable_id";
						mysqli_query($link,$ims_backup) or exit("Error while inserting into ims_backup".mysqli_error($GLOBALS["___mysqli_ston"]));
						$ims_delete="delete from $bai_pro3.ims_log where tid=$updatable_id";
						mysqli_query($link,$ims_delete) or exit("While De".mysqli_error($GLOBALS["___mysqli_ston"]));
	
					}
				}
			}
		}
	}
	//inserting bai_log and bai_log_buff
	$sizevalue="size_".$b_size_code[$i];
	$sections_qry="select sec_id,sec_head FROM $bai_pro3.sections_db WHERE sec_id>0 AND  sec_mods LIKE '%,".$b_module.",%' OR  sec_mods LIKE '".$b_module.",%' LIMIT 0,1";
	//echo $sections_qry;
	$sections_qry_result=mysqli_query($link,$sections_qry) or exit("Bundles Query Error15".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($buyer_qry_row=mysqli_fetch_array($sections_qry_result)){
			$sec_head=$buyer_qry_row['sec_id'];
	}
	$ims_log_date=date("Y-m-d");
	$bac_dat=$ims_log_date;
	$log_time=date("Y-m-d");
	$buyer_qry="select order_div FROM $bai_pro3.bai_orders_db WHERE order_style_no='".$b_style."' AND order_del_no='".$b_schedule."' AND order_col_des='".$b_colors[$i]."'";
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
	$bundle_op_id=$b_tid[$i]."-".$b_op_id."-".$b_inp_job_ref[$i];
	if($b_op_id == 130 || $b_op_id == 101)
	{
		$insert_bailog="insert into $bai_pro.bai_log (bac_no,bac_sec,bac_Qty,bac_lastup,bac_date,
		bac_shift,bac_style,bac_stat,log_time,buyer,delivery,color,loguser,ims_doc_no,smv,".$sizevalue.",ims_table_name,ims_tid,nop,ims_pro_ref,ope_code,jobno
		) values ('".$b_module."','".$sec_head."','".$b_rep_qty[$i]."',DATE_FORMAT(NOW(), '%Y-%m-%d %H'),'".$bac_dat."','".$b_shift."','".$b_style."','Active','".$log_time."','".$buyer_div."','".$b_schedule."','".$b_colors[$i]."',USER(),'".$b_doc_num[$i]."','".$sfcs_smv."','".$b_rep_qty[$i]."','ims_log','".$b_op_id."','".$nop."','".$bundle_op_id."','".$b_op_id."','".$b_inp_job_ref[$i]."')";
		//echo "Bai log : ".$insert_bailog."</br>";
		if($b_rep_qty[$i] > 0)
		{
			$qry_status=mysqli_query($link,$insert_bailog) or exit("BAI Log Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		if($qry_status)
		{
			//echo "Inserted into bai_log table successfully<br>";
			/*Insert same data into bai_pro.bai_log_buf table*/
			$insert_bailogbuf="insert into $bai_pro.bai_log_buf(bac_no,bac_sec,bac_Qty,bac_lastup,bac_date,
			bac_shift,bac_style,bac_stat,log_time,buyer,delivery,color,loguser,ims_doc_no,smv,".$sizevalue.",ims_table_name,ims_tid,nop,ims_pro_ref,ope_code,jobno
			) values ('".$b_module."','".$sec_head."','".$b_rep_qty[$i]."',DATE_FORMAT(NOW(), '%Y-%m-%d %H'),'".$bac_dat."','".$b_shift."','".$b_style."','Active','".$log_time."','".$buyer_div."','".$b_schedule."','".$b_colors[$i]."',USER(),'".$b_doc_num[$i]."','".$sfcs_smv."','".$b_rep_qty[$i]."','ims_log','".$b_op_id."','".$nop."','".$b_op_id."','".$b_op_id."','".$b_inp_job_ref[$i]."')";
			//echo "</br>Insert Bailog buf: ".$insert_bailogbuf."</br>";
			if($b_rep_qty[$i] > 0)
			{
				$qrybuf_status=mysqli_query($link,$insert_bailogbuf) or exit("BAI Log Buf Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	}
	

	
	if($b_rep_qty[$i] > 0 || $b_rej_qty[$i] > 0)
	{
		//echo $b_rej_qty[$i];
		$size = strtoupper($b_sizes[$i]);
		$table_data .= "<tr><td>$b_inp_job_ref[$i]</td><td>$b_tid[$i]</td><td>$b_colors[$i]</td><td>$size</td><td>$b_remarks[$i]</td><td>$b_rep_qty[$i]</td><td>$b_rej_qty[$i]</td></tr>";
	}
}
$table_data .= "</table>";
echo $table_data;
}


?>