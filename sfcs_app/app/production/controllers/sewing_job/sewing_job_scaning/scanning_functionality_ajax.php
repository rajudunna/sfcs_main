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
error_reporting(0);
// $username = user();
if($operation_code >=130 && $operation_code < 300)
{
	$form = 'G';
}
$qery_rejection_resons = "select * from $bai_pro3.bai_qms_rejection_reason where form_type = '$form'";
//echo $qery_rejection_resons;
$result_rejections = $link->query($qery_rejection_resons);

$bulk_insert_rej = "INSERT INTO $bai_pro3.bai_qms_db(`qms_style`, `qms_schedule`,`qms_color`,`log_user`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`,`remarks`, `ref1`, `doc_no`, `input_job_no`, `operation_id`, `qms_remarks`, `bundle_no`) VALUES";

$m3_bulk_bundle_insert_0 = "INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_reason,sfcs_remarks,sfcs_log_user,m3_op_code,sfcs_job_no,sfcs_mod_no,sfcs_shift,m3_op_des,sfcs_tid_ref,m3_error_code) VALUES";

$table_name = 'packing_summary_input';
$b_job_no = $new_data['job_number'];
$b_style= $new_data['style'];
$b_schedule=$new_data['schedule'];
$b_colors=$new_data['colors'];
$b_sizes = $new_data['sizes'];
$b_size_code = $new_data['old_size'];
$b_doc_num=$new_data['doc_no'];
$b_in_job_qty=$new_data['job_qty'];
$b_rep_qty=$new_data['reporting_qty'];
$rep_sum_qty = array_sum($b_rep_qty);
$tod_date = date('Y-m-d');
$cur_hour = date('H:00');
$cur_h = date('H');



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
$r_reason=$new_data['reason_data'];
// var_dump($r_reasons);
$r_qtys=$new_data['qty_data'];
$r_no_reasons = $new_data['tot_reasons'];
$mapped_color = $new_data['color'];
$type = $form;
$barcode_generation =  $new_data['barcode_generation'];
// Hout
// $hout_data_qry = "select * from $bai_pro2.hout where out_date = '$tod_date' and out_time = '$cur_hour' and team = '$b_module'";
// echo $hout_data_qry;
if($barcode_generation == 1)
{
	$concurrent_flag = 0;
	$actual_bundles = array();
	$actual_rec_quantities = array();
	$actual_rejection_reason_array = array();
	$actual_rejection_reason_array_string = array();
	//For positive quantities 
	$send_qty_array = array();
	$rec_qtys_array = array();
	$bundle_remaining_qty = array();
	$reason_remaining_qty = array();
	$b_in_job_qty = array();
	$actual_bundles_cumulative = array();
	//var_dump($b_tid);

	$table_flag_checking = "SELECT send_qty,recevied_qty,rejected_qty FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = '$b_job_no' AND operation_id = '$b_op_id'";
	//echo $table_flag_checking;
	$result_select_send_qty = $link->query($table_flag_checking);
	if($result_select_send_qty->num_rows >0)
	{
		$table_name = 'bundle_creation_data';
	}
	$b_inp_job_ref = array();
	// echo $table_name;
	if($table_name == 'packing_summary_input')
	{
		//var_dump($b_tid).'</br>';
		foreach($b_tid as $key => $value)
		{
			$query_to_fetch_individual_bundles = "select tid,order_col_des,old_size,size_code,carton_act_qty,acutno,input_job_no,doc_no FROM $bai_pro3.packing_summary_input where order_col_des = '$b_colors[$key]' and size_code = '$b_sizes[$key]' and input_job_no_random = $b_job_no order by tid ASC";
		//	echo $query_to_fetch_individual_bundles;
			$qry_nop_result=mysqli_query($link,$query_to_fetch_individual_bundles) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
			$cumulative_qty = $b_rep_qty[$key];
			$remarks = $b_remarks[$key];
			while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
			{
				//echo $cumulative_qty.'</br>';
				//echo $b_rep_qty[$key].'</br>';
				$bundle_individual_number = $nop_qry_row['tid'];
				$actual_bundles[] = $nop_qry_row['tid'];
				$b_colors_1[] =  $nop_qry_row['order_col_des'];
				$qms[$nop_qry_row['tid']]['order_col_des'] = $nop_qry_row['order_col_des'];
				$qms[$nop_qry_row['tid']]['size_code'] = $nop_qry_row['size_code'];
				$qms[$nop_qry_row['tid']]['old_size'] = $nop_qry_row['old_size'];
				$qms[$nop_qry_row['tid']]['doc_no'] = $nop_qry_row['doc_no'];
				$qms[$nop_qry_row['tid']]['acutno'] = $nop_qry_row['acutno'];
				$qms[$nop_qry_row['tid']]['input_job_no'] = $nop_qry_row['input_job_no'];
				$qms[$nop_qry_row['tid']]['bundle_no'] = $nop_qry_row['tid'];
				$qms[$nop_qry_row['tid']]['remarks'] = $remarks;
				$b_sizes_1[] =  $nop_qry_row['size_code'];
				$b_size_code_1[] = $nop_qry_row['old_size'];
				$b_in_job_qty[] = $nop_qry_row['carton_act_qty'];
				$b_a_cut_no_1[] = $nop_qry_row['acutno'];
				$b_doc_num_1[] = $nop_qry_row['doc_no'];
				$actual_bundles_cumulative[] = $nop_qry_row['tid'];
				$b_inp_job_ref[] = $nop_qry_row['input_job_no'];
				$b_remarks_1[] = $remarks;
				if($b_rep_qty[$key] > 0)
				{
					$fetching_max_qty_to_insert_in_each_bundle = "select carton_act_qty from $bai_pro3.packing_summary_input where tid = $bundle_individual_number";
					//echo $fetching_max_qty_to_insert_in_each_bundle;
					$result_fetching_max_qty_to_insert_in_each_bundle = mysqli_query($link,$fetching_max_qty_to_insert_in_each_bundle) or exit("fetching_max_qty_to_insert_in_each_bundle error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row=mysqli_fetch_array($result_fetching_max_qty_to_insert_in_each_bundle))
					{
							$max_insertion_qty = $row['carton_act_qty'];
							$send_qty_array[$bundle_individual_number] = $row['carton_act_qty'];
							//echo $bundle_individual_number.'-'.$max_insertion_qty. '-' .$cumulative_qty.'</br>';
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
				}
				else
				{
					$actual_rec_quantities[] =0;
					$rec_qtys_array[$bundle_individual_number] = 0;
				}	
			}
			//var_dump($actual_rec_quantities);

			// echo $query_to_fetch_individual_bundles;
			
		}

		//for rejections
		$remaining_qty = 0;
		$actual_remaining_flag = 1;
		$pre_remaining_check_flag = 0;
		$remaining_bundle_qty=0;
		

		foreach($b_tid as $key => $value)
		{
			$reason_remaining_qty = array();
			$r_reasons = explode(",", $r_reason[$value]);
			// var_dump($r_reasons);
			$r_qty = explode(",", $r_qtys[$value]);
			// var_dump($r_qty);

			$query_to_fetch_individual_bundles = "select tid  FROM $bai_pro3.packing_summary_input where order_col_des = '$b_colors[$key]' and size_code = '$b_sizes[$key]' and input_job_no_random = $b_job_no order by tid DESC";
			$qry_nop_result=mysqli_query($link,$query_to_fetch_individual_bundles) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
			$cumulative_rej_qty = $b_rej_qty[$key];
			while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
			{
				$bundle_individual_number = $nop_qry_row['tid'];
				$fetching_max_qty_to_insert_in_each_bundle = "select carton_act_qty from $bai_pro3.packing_summary_input where tid = $bundle_individual_number";
				$result_fetching_max_qty_to_insert_in_each_bundle = mysqli_query($link,$fetching_max_qty_to_insert_in_each_bundle) or exit("fetching_max_qty_to_insert_in_each_bundle error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row=mysqli_fetch_array($result_fetching_max_qty_to_insert_in_each_bundle))
				{
					if($cumulative_rej_qty > 0)
					{
						$max_insertion_qty = $row['carton_act_qty'] - $rec_qtys_array[$bundle_individual_number[$key]];
						//echo $bundle_individual_number.'-'.$max_insertion_qty.'-'.$cumulative_rej_qty;
						if($max_insertion_qty <= $cumulative_rej_qty)
						{
							$actual_rej_quantities[$bundle_individual_number] = $max_insertion_qty;
							$cumulative_rej_qty =  $cumulative_rej_qty - $max_insertion_qty;
						}
						else if($max_insertion_qty > $cumulative_rej_qty)
						{
							$actual_rej_quantities[$bundle_individual_number] = $cumulative_rej_qty;
							$cumulative_rej_qty = 0;
						}

					}
					else 
					{
						$actual_rej_quantities[$bundle_individual_number] = 0;
					}
					$pre_insertion_qty = 0;
					$max_insertion_qty_rej = $max_insertion_qty;
					$actual_rejection_reason_array[$bundle_individual_number] = 0;
					if(sizeof($reason_remaining_qty)>0)
					{
					    //var_dump($reason_remaining_qty);
						foreach($reason_remaining_qty as $remain_qty_key => $remain_qty_value)
						{
							//echo "hII".$bundle_individual_number.'-'.$actual_rej_quantities[$bundle_individual_number].'-'.$actual_rejection_reason_array[$bundle_individual_number].'</br>';
							$bundle_max_insertion_qty =  $actual_rej_quantities[$bundle_individual_number] - $actual_rejection_reason_array[$bundle_individual_number];
							$remain_qty_value = $reason_remaining_qty[$remain_qty_key];
							if($bundle_max_insertion_qty != 0)
							{
								if($bundle_max_insertion_qty <= $remain_qty_value)
								{
									$actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$remain_qty_key.'-'. $bundle_max_insertion_qty.'$';
									$insertable_qty_rej = $bundle_max_insertion_qty;
									$remainis = $remain_qty_value - $bundle_max_insertion_qty;
									$reason_remaining_qty[$remain_qty_key] = $remainis;
									$actual_rejection_reason_array[$bundle_individual_number] += $bundle_max_insertion_qty;
								}
								else
								{
									//$remain_qty_value = $reason_remaining_qty[$remain_qty_key];
									$actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$remain_qty_key.'-'. $remain_qty_value.'$';
									$insertable_qty_rej = $remain_qty_value;
									$reason_remaining_qty[$remain_qty_key] = 0;
									$actual_rejection_reason_array[$bundle_individual_number] += 0;
								}
								$rejection_code_fetech_qry = "select reason_code from $bai_pro3.bai_qms_rejection_reason where m3_reason_code= '$r_reasons[$reason_key]'";
							$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
							while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
							{
								$reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
							}
							$remarks_code = $reason_code.'-'.$insertable_qty_rej;
							$remarks_var = $b_module.'-'.$b_shift.'-'.$type;
							$bulk_insert_rej .= '("'.$b_style.'","'.$b_schedule.'","'.$qms[$bundle_individual_number]['order_col_des'].'",user(),"'.date('Y-m-d').'","'.$qms[$bundle_individual_number]['size_code'].'","'.$insertable_qty_rej.'","3","'.$remarks_var.'","'.$remarks_code.'","'.$qms[$bundle_individual_number]['doc_no'].'","'.$b_job_no.'","'. $b_op_id.'","'. $qms[$bundle_individual_number]['remarks'].'","'.$bundle_individual_number.'"),';

							$m3_bulk_bundle_insert_0 .= '("'.date('Y-m-d').'","'.$b_style.'","'. $b_schedule.'","'.$qms[$bundle_individual_number]['order_col_des'].'","'. $qms[$bundle_individual_number]['old_size'].'","'. $qms[$bundle_individual_number]['size_code'].'","'.$qms[$bundle_individual_number]['doc_no'].'","'.$insertable_qty_rej.'","'.$r_reasons[$reason_key].'","'.$qms[$bundle_individual_number]['remarks'].'",USER(),"'. $b_op_id.'","'.$b_job_no.'","'.$b_module.'","'.$b_shift.'","'.$b_op_name.'","'.$bundle_individual_number.'",""),';

							}
							
						}
					}
					else
					{
					
						$r_reasons = array_filter($r_reasons);
						foreach($r_reasons as $reason_key => $reason_value)
						{
							$reson_max_qty = $r_qty[$reason_key];
							$bundle_max_insertion_qty =  $actual_rej_quantities[$bundle_individual_number] - $actual_rejection_reason_array[$bundle_individual_number];
							if($bundle_max_insertion_qty != 0)
							{

								if($bundle_max_insertion_qty <= $reson_max_qty)
								{
									$actual_rejection_reason_array[$bundle_individual_number] += $bundle_max_insertion_qty;
									// $actual_rejection_reason_array_string[$bundle_individual_number][] =  $bundle_individual_number.'-'.$r_reasons [$reason_key].'-'.$bundle_max_insertion_qty.'$';
									$actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$r_reasons [$reason_key].'-'.$bundle_max_insertion_qty.'$';
									$insertable_qty_rej = $bundle_max_insertion_qty;
									$remaining_bundle_qty = $reson_max_qty-$bundle_max_insertion_qty;
									$remaining_bundle_reason = $r_reasons[$reason_key];
								//	echo '1'.$r_reasons[$key].'-'.$remaining_bundle_qty.'</br>';
									if($remaining_bundle_qty > 0)
									{
										$reason_remaining_qty[$r_reasons[$reason_key]] = $remaining_bundle_qty;
										//$insertable_qty_rej = $remaining_bundle_qty;
									}
										
								}
								else
								{
									$actual_rejection_reason_array[$bundle_individual_number] += $reson_max_qty;
									$actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$r_reasons[$reason_key].'-'.$reson_max_qty.'$';
									$bundle_remaining_exces_qty = $bundle_max_insertion_qty - $reson_max_qty;
									$bundle_remaining_qty[$bundle_individual_number] = $bundle_remaining_exces_qty;
									$insertable_qty_rej = $reson_max_qty;
								}

								// $bulk_insert_rej = "INSERT INTO $bai_pro3.bai_qms_db(`qms_style`, `qms_schedule`,`qms_color`,`log_user`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`,`remarks`, `ref1`, `doc_no`, `input_job_no`, `operation_id`, `qms_remarks`, `bundle_no`) VALUES";
								// $qms[$bundle_individual_number]['order_col_des'];
								
								$rejection_code_fetech_qry = "select reason_code from $bai_pro3.bai_qms_rejection_reason where m3_reason_code= '$r_reasons[$reason_key]'";
								$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
								while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
								{
									$reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
								}
								$remarks_code = $reason_code.'-'.$insertable_qty_rej;
								$remarks_var = $b_module.'-'.$b_shift.'-'.$type;
								$bulk_insert_rej .= '("'.$b_style.'","'.$b_schedule.'","'.$qms[$bundle_individual_number]['order_col_des'].'",user(),"'.date('Y-m-d').'","'.$qms[$bundle_individual_number]['size_code'].'","'.$insertable_qty_rej.'","3","'.$remarks_var.'","'.$remarks_code.'","'.$qms[$bundle_individual_number]['doc_no'].'","'.$b_job_no.'","'. $b_op_id.'","'. $qms[$bundle_individual_number]['remarks'].'","'.$bundle_individual_number.'"),';

								$m3_bulk_bundle_insert_0 .= '("'.date('Y-m-d').'","'.$b_style.'","'. $b_schedule.'","'.$qms[$bundle_individual_number]['order_col_des'].'","'. $qms[$bundle_individual_number]['old_size'].'","'. $qms[$bundle_individual_number]['size_code'].'","'.$qms[$bundle_individual_number]['doc_no'].'","'.$insertable_qty_rej.'","'.$r_reasons[$reason_key].'","'.$qms[$bundle_individual_number]['remarks'].'",USER(),"'. $b_op_id.'","'.$b_job_no.'","'.$b_module.'","'.$b_shift.'","'.$b_op_name.'","'.$bundle_individual_number.'",""),';
							}
							else 
							{
							//	echo '2'.$r_reasons[$key].'-'.$reson_max_qty.'</br>';
								$reason_remaining_qty[$r_reasons[$reason_key]] = $reson_max_qty;
							}
							
						}
					}
					
						
				}

			}

		}
	$b_colors=array();
	$b_sizes = array();
	$b_size_code = array();
	$b_a_cut_no = array();
	$b_remarks = array();
	$b_doc_num = array();
	$b_colors=$b_colors_1;
	$b_sizes = $b_sizes_1;
	$b_size_code = $b_size_code_1;
	$b_a_cut_no = $b_a_cut_no_1;
	$b_remarks = $b_remarks_1;
	$b_doc_num = $b_doc_num_1;
	}

	else
	{
	//for positive quantities 
		foreach($b_tid as $key => $value)
		{
			$r_reasons = explode(",", $r_reason[$value]);
			// var_dump($r_reasons);
			$r_qty = explode(",", $r_qtys[$value]);
			$remarks = $b_remarks[$key];
			$query_to_fetch_individual_bundles = "select bundle_number,send_qty,recevied_qty,rejected_qty,color,size_title,size_id,original_qty,cut_number,docket_number,input_job_no FROM $brandix_bts.bundle_creation_data where color = '$b_colors[$key]' and size_title = '$b_sizes[$key]' and input_job_no_random_ref = $b_job_no AND operation_id = '$b_op_id' order by bundle_number ASC";
			// $query_to_fetch_individual_bundles;
			$qry_nop_result=mysqli_query($link,$query_to_fetch_individual_bundles) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
			// var_dump($b_rep_qty);
			$cumulative_qty = $b_rep_qty[$key];
			$remaining_qty_rec = 0;
			// echo $query_to_fetch_individual_bundles;
				while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
				{
					$qms[$nop_qry_row['bundle_number']]['order_col_des'] = $nop_qry_row['color'];
					$qms[$nop_qry_row['bundle_number']]['size_code'] = $nop_qry_row['size_title'];
					$qms[$nop_qry_row['bundle_number']]['old_size'] = $nop_qry_row['size_id'];
					$qms[$nop_qry_row['bundle_number']]['doc_no'] = $nop_qry_row['docket_number'];
					$qms[$nop_qry_row['bundle_number']]['acutno'] = $nop_qry_row['cut_number'];
					$qms[$nop_qry_row['bundle_number']]['input_job_no'] = $nop_qry_row['input_job_no'];
					$qms[$nop_qry_row['bundle_number']]['bundle_no'] = $nop_qry_row['bundle_number'];
					$qms[$nop_qry_row['bundle_number']]['remarks'] = $remarks;
					$actual_bundles[] = $nop_qry_row['bundle_number'];
					$b_colors_1[] =  $nop_qry_row['color'];
					$b_sizes_1[] =  $nop_qry_row['size_title'];
					$b_size_code_1[] = $nop_qry_row['size_id'];
					$b_in_job_qty[] = $nop_qry_row['original_qty'];
					$b_a_cut_no_1[] = $nop_qry_row['cut_number'];
					$b_doc_num_1[] = $nop_qry_row['docket_number'];
					$b_inp_job_ref[] = $nop_qry_row['input_job_no'];
					$b_remarks_1[] = $remarks;
					$bundle_individual_number = $nop_qry_row['bundle_number'];
					if($cumulative_qty > 0)
					{
						$bundle_pending_qty =  $nop_qry_row['send_qty'] - ($nop_qry_row['recevied_qty']+ $nop_qry_row['rejected_qty']);
						//echo "pending_qty:".$bundle_individual_number.'-'.$bundle_pending_qty.'</br>';
						// if($remaining_qty_rec != 0)
						// {
						// 	$bundle_pending_qty = $remaining_qty_rec;
						// }
						if($bundle_pending_qty > 0 && $cumulative_qty > 0)
						{
							if($bundle_pending_qty <= $cumulative_qty)
							{
								$actual_rec_quantities[]=$bundle_pending_qty;
								$rec_qtys_array[$bundle_individual_number] = $bundle_pending_qty;
								$remaining_qty_rec = $cumulative_qty - $bundle_pending_qty;
								$cumulative_qty = $remaining_qty_rec;
								//$bundle_pending_qty = 0;
							}
							else
							{
								$actual_rec_quantities[]=$cumulative_qty;
								$rec_qtys_array[$bundle_individual_number] = $cumulative_qty;
								$cumulative_qty = 0;
							}
						}
						else if($bundle_pending_qty == 0)
						{
							$actual_rec_quantities[]=0;
							$rec_qtys_array[$bundle_individual_number] = 0;
						}
					}
					else
					{
						$actual_rec_quantities[] = 0;
						$rec_qtys_array[$bundle_individual_number] = 0;
					}
			}

		}
		//for negatives
		//var_dump($rec_qtys_array);
		foreach($b_tid as $key => $value)
		{
			$r_reasons = explode(",", $r_reason[$value]);
			// var_dump($r_reasons);
			$r_qty = explode(",", $r_qtys[$value]);
			$reason_remaining_qty = array();
			$query_to_fetch_individual_bundles = "select bundle_number,send_qty,recevied_qty,rejected_qty FROM $brandix_bts.bundle_creation_data where color = '$b_colors[$key]' and size_title = '$b_sizes[$key]' and input_job_no_random_ref = $b_job_no AND operation_id = '$b_op_id' order by bundle_number DESC";
			//echo $query_to_fetch_individual_bundles;
			$qry_nop_result=mysqli_query($link,$query_to_fetch_individual_bundles) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
			$cumulative_rej_qty = $b_rej_qty[$key];
			$remaining_qty_rej = $b_rej_qty[$key];
			while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
			{
				$bundle_individual_number = $nop_qry_row['bundle_number'];
				if($cumulative_rej_qty > 0)
				{
					$bundle_pending_qty_rej =  $nop_qry_row['send_qty'] - ( $nop_qry_row['recevied_qty']+$rec_qtys_array[$bundle_individual_number]+$nop_qry_row['rejected_qty']);
					//echo $bundle_individual_number.'-'.$bundle_pending_qty_rej.'-'.$remaining_qty_rej;
					if($bundle_pending_qty_rej != 0)
					{
						if($bundle_pending_qty_rej <= $remaining_qty_rej)
						{
							$actual_rej_quantities[$bundle_individual_number]=$bundle_pending_qty_rej;
							$remaining_qty_rej = $cumulative_rej_qty - $bundle_pending_qty_rej;
						}
						else
						{
							$actual_rej_quantities[$bundle_individual_number]=$cumulative_rej_qty;
							$cumulative_rej_qty = 0;
							$remaining_qty_rej = 0;
						}
					}
					else if($bundle_pending_qty_rej == 0)
					{
						$actual_rej_quantities[$bundle_individual_number]=0;
					}

				}
				else
				{
					$actual_rej_quantities[$bundle_individual_number]=0;
				}
				//rejection resons
					$pre_insertion_qty = 0;
					$max_insertion_qty_rej = $max_insertion_qty;
					$actual_rejection_reason_array[$bundle_individual_number] = 0;
					if(sizeof($reason_remaining_qty)>0)
					{
						//var_dump($reason_remaining_qty);
						foreach($reason_remaining_qty as $remain_qty_key => $remain_qty_value)
						{
							//echo "hII".$bundle_individual_number.'-'.$actual_rej_quantities[$bundle_individual_number].'-'.$actual_rejection_reason_array[$bundle_individual_number].'</br>';
							$bundle_max_insertion_qty =  $actual_rej_quantities[$bundle_individual_number] - $actual_rejection_reason_array[$bundle_individual_number];
							$remain_qty_value = $reason_remaining_qty[$remain_qty_key];
							if($bundle_max_insertion_qty != 0)
							{
								if($bundle_max_insertion_qty <= $remain_qty_value)
								{
									$actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$remain_qty_key.'-'. $bundle_max_insertion_qty.'$';
									$insertable_qty_rej = $bundle_max_insertion_qty;
									$remainis = $remain_qty_value - $bundle_max_insertion_qty;
									$reason_remaining_qty[$remain_qty_key] = $remainis;
									$actual_rejection_reason_array[$bundle_individual_number] += $bundle_max_insertion_qty;
								}
								else
								{
									//$remain_qty_value = $reason_remaining_qty[$remain_qty_key];
									$actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$remain_qty_key.'-'. $remain_qty_value.'$';
									$insertable_qty_rej = $remain_qty_value;
									$reason_remaining_qty[$remain_qty_key] = 0;
									$actual_rejection_reason_array[$bundle_individual_number] += 0;
								}
								$rejection_code_fetech_qry = "select reason_code from $bai_pro3.bai_qms_rejection_reason where m3_reason_code= '$r_reasons[$reason_key]'";
							$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
							while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
							{
								$reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
							}
							$remarks_code = $reason_code.'-'.$insertable_qty_rej;
							$remarks_var = $b_module.'-'.$b_shift.'-'.$type;
							$bulk_insert_rej .= '("'.$b_style.'","'.$b_schedule.'","'.$qms[$bundle_individual_number]['order_col_des'].'",user(),"'.date('Y-m-d').'","'.$qms[$bundle_individual_number]['size_code'].'","'.$insertable_qty_rej.'","3","'.$remarks_var.'","'.$remarks_code.'","'.$qms[$bundle_individual_number]['doc_no'].'","'.$b_job_no.'","'. $b_op_id.'","'. $qms[$bundle_individual_number]['remarks'].'","'.$bundle_individual_number.'"),';

							$m3_bulk_bundle_insert_0 .= '("'.date('Y-m-d').'","'.$b_style.'","'. $b_schedule.'","'.$qms[$bundle_individual_number]['order_col_des'].'","'. $qms[$bundle_individual_number]['old_size'].'","'. $qms[$bundle_individual_number]['size_code'].'","'.$qms[$bundle_individual_number]['doc_no'].'","'.$insertable_qty_rej.'","'.$r_reasons[$reason_key].'","'.$qms[$bundle_individual_number]['remarks'].'",USER(),"'. $b_op_id.'","'.$b_job_no.'","'.$b_module.'","'.$b_shift.'","'.$b_op_name.'","'.$bundle_individual_number.'",""),';

							}
							
						}
					}
					else
					{
					
						$r_reasons = array_filter($r_reasons);
						foreach($r_reasons as $reason_key => $reason_value)
						{
							$reson_max_qty = $r_qty[$reason_key];
							$bundle_max_insertion_qty =  $actual_rej_quantities[$bundle_individual_number] - $actual_rejection_reason_array[$bundle_individual_number];
							if($bundle_max_insertion_qty != 0)
							{

								if($bundle_max_insertion_qty <= $reson_max_qty)
								{
									$actual_rejection_reason_array[$bundle_individual_number] += $bundle_max_insertion_qty;
									// $actual_rejection_reason_array_string[$bundle_individual_number][] =  $bundle_individual_number.'-'.$r_reasons [$reason_key].'-'.$bundle_max_insertion_qty.'$';
									$actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$r_reasons [$reason_key].'-'.$bundle_max_insertion_qty.'$';
									$insertable_qty_rej = $bundle_max_insertion_qty;
									$remaining_bundle_qty = $reson_max_qty-$bundle_max_insertion_qty;
									$remaining_bundle_reason = $r_reasons[$reason_key];
								//	echo '1'.$r_reasons[$key].'-'.$remaining_bundle_qty.'</br>';
									if($remaining_bundle_qty > 0)
									{
										$reason_remaining_qty[$r_reasons[$reason_key]] = $remaining_bundle_qty;
										//$insertable_qty_rej = $remaining_bundle_qty;
									}
										
								}
								else
								{
									$actual_rejection_reason_array[$bundle_individual_number] += $reson_max_qty;
									$actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$r_reasons[$reason_key].'-'.$reson_max_qty.'$';
									$bundle_remaining_exces_qty = $bundle_max_insertion_qty - $reson_max_qty;
									$bundle_remaining_qty[$bundle_individual_number] = $bundle_remaining_exces_qty;
									$insertable_qty_rej = $reson_max_qty;
								}

								// $bulk_insert_rej = "INSERT INTO $bai_pro3.bai_qms_db(`qms_style`, `qms_schedule`,`qms_color`,`log_user`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`,`remarks`, `ref1`, `doc_no`, `input_job_no`, `operation_id`, `qms_remarks`, `bundle_no`) VALUES";
								// $qms[$bundle_individual_number]['order_col_des'];
								
								$rejection_code_fetech_qry = "select reason_code from $bai_pro3.bai_qms_rejection_reason where m3_reason_code= '$r_reasons[$reason_key]'";
								$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
								while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
								{
									$reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
								}
								$remarks_code = $reason_code.'-'.$insertable_qty_rej;
								$remarks_var = $b_module.'-'.$b_shift.'-'.$type;
								$bulk_insert_rej .= '("'.$b_style.'","'.$b_schedule.'","'.$qms[$bundle_individual_number]['order_col_des'].'",user(),"'.date('Y-m-d').'","'.$qms[$bundle_individual_number]['size_code'].'","'.$insertable_qty_rej.'","3","'.$remarks_var.'","'.$remarks_code.'","'.$qms[$bundle_individual_number]['doc_no'].'","'.$b_job_no.'","'. $b_op_id.'","'. $qms[$bundle_individual_number]['remarks'].'","'.$bundle_individual_number.'"),';

								$m3_bulk_bundle_insert_0 .= '("'.date('Y-m-d').'","'.$b_style.'","'. $b_schedule.'","'.$qms[$bundle_individual_number]['order_col_des'].'","'. $qms[$bundle_individual_number]['old_size'].'","'. $qms[$bundle_individual_number]['size_code'].'","'.$qms[$bundle_individual_number]['doc_no'].'","'.$insertable_qty_rej.'","'.$r_reasons[$reason_key].'","'.$qms[$bundle_individual_number]['remarks'].'",USER(),"'. $b_op_id.'","'.$b_job_no.'","'.$b_module.'","'.$b_shift.'","'.$b_op_name.'","'.$bundle_individual_number.'",""),';
							}
							else 
							{
							//	echo '2'.$r_reasons[$key].'-'.$reson_max_qty.'</br>';
								$reason_remaining_qty[$r_reasons[$reason_key]] = $reson_max_qty;
							}
							
						}
					}
			}
		}
		$b_colors=array();
		$b_sizes = array();
		$b_size_code = array();
		$b_a_cut_no = array();
		$b_remarks = array();
		$b_doc_num = array();
		$b_colors=$b_colors_1;
		$b_sizes = $b_sizes_1;
		$b_size_code = $b_size_code_1;
		$b_a_cut_no = $b_a_cut_no_1;
		$b_remarks = $b_remarks_1;
		$b_doc_num = $b_doc_num_1;

	}
	//rejections updation in qms_db
	//var_dump($actual_rejection_reason_array_string);
	//echo $bulk_insert_rej;
	if(sizeof($actual_rejection_reason_array_string)>0)
	{
		if(substr($bulk_insert_rej, -1) == ',')
		{
			$final_query = substr($bulk_insert_rej, 0, -1);
		}
		else
		{
			$final_query = $bulk_insert_rej;
		}
		// echo $final_query;
		$rej_insert_result = $link->query($final_query) or exit('data error');

		if(substr($m3_bulk_bundle_insert_0, -1) == ',')
		{
			$final_query_m3 = substr($m3_bulk_bundle_insert_0, 0, -1);
		}
		else
		{
			$final_query_m3 = $m3_bulk_bundle_insert_0;
		}
		// echo $final_query_m3;
		$rej_insert_result_m3 = $link->query($final_query_m3) or exit('data error');
	}
	$b_tid = array();
	$b_rep_qty = array();
	$b_rej_qty = array();
	foreach($actual_bundles as $key=>$value)
	{
		//echo $actual_bundles[$key].'-'.$actual_rec_quantities[$key].'-'.$actual_rej_quantities[$value].'</br>';
		$b_tid[] = $actual_bundles[$key];
		$b_rep_qty[] = $actual_rec_quantities[$key];
		$b_rej_qty[] = $actual_rej_quantities[$value];

	}

}
// var_dump($r_reason);
// var_dump($r_qtys);
//Before CR Logic
	foreach ($b_tid as $key=>$value)
	{
		$select_send_qty = "SELECT send_qty,recevied_qty,rejected_qty FROM $brandix_bts.bundle_creation_data WHERE bundle_number = '$b_tid[$key]' AND operation_id = '$b_op_id'";
	// echo $select_send_qty;
		$result_select_send_qty = $link->query($select_send_qty);
		if($result_select_send_qty->num_rows >0)
		{
			$table_name = 'bundle_creation_data';
			while($row = $result_select_send_qty->fetch_assoc()) 
			{
				$send_qty = $row['send_qty'];
				$pre_recieved_qty = $row['recevied_qty'];
				$rejected_qty = $row['rejected_qty'];
				$act_reciving_qty = $b_rep_qty[$key]+$b_rej_qty[$key];
				$total_rec_qty = $pre_recieved_qty + $act_reciving_qty+$rejected_qty;
				//echo "bcd=".$total_rec_qty."-".$send_qty."</br>";
				if($total_rec_qty > $send_qty)
				{
					$concurrent_flag = 1;
				}
				else
				{
					$rec_qty_from_temp = "select (sum(recevied_qty)+sum(rejected_qty))as recevied_qty FROM $brandix_bts.bundle_creation_data_temp WHERE bundle_number = '$b_tid[$key]' AND operation_id = '$b_op_id'";
				//	echo $rec_qty_from_temp;
					$result_rec_qty_from_temp = $link->query($rec_qty_from_temp);
					while($row_temp = $result_rec_qty_from_temp->fetch_assoc()) 
					{
						$pre_recieved_qty_temp = $row_temp['recevied_qty'];
						$act_reciving_qty_temp = $b_rep_qty[$key]+$b_rej_qty[$key];
					//	echo "bcdtemp=".$act_reciving_qty_temp."-".$send_qty."</br>";
						if($act_reciving_qty_temp > $send_qty)
						{
							$concurrent_flag = 1;
						}
					}

				}
			}
		}
	}
	if($concurrent_flag == 1)
	{
		echo "<h1 style='color:red;'>You are Scanning More than eligible quantity.</h1>";
	}
	else if($concurrent_flag == 0)
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
		$remarks_var = $b_module.'-'.$b_shift.'-'.$type;
		$reason_flag = false;
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
		$post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$mapped_color' and ops_sequence = $ops_seq  AND CAST(operation_order AS CHAR) > '$ops_order' ORDER BY operation_order ASC LIMIT 1";
		$result_post_ops_check = $link->query($post_ops_check);
		if($result_post_ops_check->num_rows > 0)
		{
			while($row = $result_post_ops_check->fetch_assoc()) 
			{
				$post_ops_code = $row['operation_code'];
			}
		}
		foreach($pre_ops_code as $index => $op_code)
		{
			if($op_code != $b_op_id)
			{
				$b_query[$op_code] = "INSERT  INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `mapped_color`) VALUES";

				// temp table data query

				$b_query_temp[$op_code] = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`) VALUES";
			}
		}

	// (`id`,`date_time`,`cut_number`,`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`missing_qty`,`rejected_qty`,`left_over`,`operation_id`,`operation_sequence`,`ops_dependency`,`docket_number`,`bundle_status`,`split_status`,`sewing_order_status`,`is_sewing_order`,`sewing_order`,`assigned_module`,`remarks`,`scanned_date`,`shift`,`scanned_user`,`sync_status`,`shade`)


	//(`style`,`schedule`,`color`,`size_title`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`)
		$m3_bulk_bundle_insert = "INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_reason,sfcs_remarks,sfcs_log_user,m3_op_code,sfcs_job_no,sfcs_mod_no,sfcs_shift,m3_op_des,sfcs_tid_ref,m3_error_code) VALUES";

	if($table_name == 'packing_summary_input')
	{
		// (`qms_style`, `qms_schedule`,`qms_color`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`, `remarks`, `doc_no`, `input_job_no`)
		

			$bulk_insert = "INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`,`mapped_color`) VALUES";
		// temp table data insertion query.........
			$bulk_insert_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`) VALUES";

		// $bulk_insert_post = $bulk_insert;mapped_color
			if($barcode_generation != 1)
			{
				$bulk_insert_rej = "INSERT INTO $bai_pro3.bai_qms_db(`qms_style`, `qms_schedule`,`qms_color`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`,`remarks` ,`ref1`, `doc_no`,`input_job_no`,`operation_id`,`qms_remarks`,`bundle_no`) VALUES";
			}
			foreach ($b_tid as $key => $tid)
			{
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

				if($r_qty[$tid] != null && $r_reasons[$tid] != null)
				{
					$r_qty_array = explode(',',$r_qtys[$tid]);
					$r_reasons_array = explode(',',$r_reason[$tid]);

					foreach ($r_qty_array as $index => $r_qnty) 
					{
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
				foreach($pre_ops_code as $index => $op_code)
				{
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
				if($barcode_generation != 1)
				{
					if($r_qty[$tid] != null && $r_reasons[$tid] != null)
					{
						$bulk_insert_rej .= '("'.$b_style.'","'.$b_schedule.'","'.$b_colors[$key].'","'.date('Y-m-d').'","'.$b_sizes[$key].'","'.$b_rej_qty[$key].'","3","'.$remarks_var.'","'.$remarks_code.'","'.$b_doc_num[$key].'","'.$b_job_no.'","'. $b_op_id.'","'. $b_remarks[$key].'","'.$b_tid[$key].'"),';
						$reason_flag = true;
					}

				}
				
			}
		$concurrent_flag = 0;
		foreach ($b_tid as $key=>$value)
		{
			$select_send_qty = "SELECT send_qty,recevied_qty,rejected_qty FROM $brandix_bts.bundle_creation_data WHERE bundle_number = '$b_tid[$key]' AND operation_id = '$b_op_id'";
		//  echo $select_send_qty;
			$result_select_send_qty = $link->query($select_send_qty);
			if($result_select_send_qty->num_rows >0)
			{
				while($row = $result_select_send_qty->fetch_assoc()) 
				{
					$send_qty = $row['send_qty'];
					$pre_recieved_qty = $row['recevied_qty'];
					$rejected_qty = $row['rejected_qty'];
					$act_reciving_qty = $b_rep_qty[$key]+$b_rej_qty[$key];
					$total_rec_qty = $pre_recieved_qty + $act_reciving_qty+$rejected_qty;
					//echo "bcd=".$total_rec_qty."-".$send_qty."</br>";
					if($total_rec_qty > $send_qty)
					{
						$concurrent_flag = 1;
					}
					else
					{
						$rec_qty_from_temp = "select (sum(recevied_qty)+sum(rejected_qty))as recevied_qty FROM $brandix_bts.bundle_creation_data_temp WHERE bundle_number = '$b_tid[$key]' AND operation_id = '$b_op_id'";
						//echo $rec_qty_from_temp;
						$result_rec_qty_from_temp = $link->query($rec_qty_from_temp);
						while($row_temp = $result_rec_qty_from_temp->fetch_assoc()) 
						{
							$pre_recieved_qty_temp = $row_temp['recevied_qty'];
							$act_reciving_qty_temp = $b_rep_qty[$key]+$b_rej_qty[$key];
							//echo "bcdtemp=".$act_reciving_qty_temp."-".$send_qty."</br>";
							if($act_reciving_qty_temp > $send_qty)
							{
								$concurrent_flag = 1;
							}
						}

					}
				}
			}
		}
		if($concurrent_flag == 1)
		{
			echo "<h1 style='color:red;'>You are Scanning More than eligible quantity.</h1>";
		}
		if($concurrent_flag == 0)
		{
			foreach($b_query as $index1 => $query){
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
			if($barcode_generation != 1)
			{
				if($reason_flag){
					if(substr($bulk_insert_rej, -1) == ','){
						$final_query = substr($bulk_insert_rej, 0, -1);
					}else{
						$final_query = $bulk_insert_rej;
					}
					$rej_insert_result = $link->query($final_query) or exit('data error');
				}
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
		foreach($b_tid as $key=>$value)
		{
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
		}
			//all operation codes query.. (not tested)
	}
	else
	{
		$query = '';
		if($table_name == 'bundle_creation_data')
		{
			if($barcode_generation != 1)
			{
				$bulk_insert_rej = "INSERT INTO $bai_pro3.bai_qms_db(`qms_style`, `qms_schedule`,`qms_color`,`log_user`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`,`remarks`, `ref1`, `doc_no`, `input_job_no`, `operation_id`, `qms_remarks`, `bundle_no`) VALUES";
			}
			$schedule_count_query = "SELECT input_job_no_random_ref FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = $b_job_no AND operation_id ='$b_op_id'";

			// echo $schedule_count_query.'<br>';
			$schedule_count_query = $link->query($schedule_count_query) or exit('query error');
			
			if($schedule_count_query->num_rows > 0)
			{
				$schedule_count = true;
			}else{
				$schedule_count = false;
			}
			$concurrent_flag = 0;
			foreach ($b_tid as $key => $tid) 
			{
				$select_send_qty = "SELECT send_qty,recevied_qty,rejected_qty FROM $brandix_bts.bundle_creation_data WHERE bundle_number = '$b_tid[$key]' AND operation_id = '$b_op_id'";
				$result_select_send_qty = $link->query($select_send_qty);
				if($result_select_send_qty->num_rows >0)
				{
					while($row = $result_select_send_qty->fetch_assoc()) 
					{
						$send_qty = $row['send_qty'];
						$pre_recieved_qty = $row['recevied_qty'];
						$rejected_qty = $row['rejected_qty'];
						$act_reciving_qty = $b_rep_qty[$key]+$b_rej_qty[$key];
						$total_rec_qty = $pre_recieved_qty + $act_reciving_qty+$rejected_qty;
						//echo "bcd=".$total_rec_qty."-".$send_qty."</br>";
						if($total_rec_qty > $send_qty)
						{
							$concurrent_flag = 1;
						}
						else
						{
							$rec_qty_from_temp = "select (sum(recevied_qty)+sum(rejected_qty))as recevied_qty FROM $brandix_bts.bundle_creation_data_temp WHERE bundle_number = '$b_tid[$key]' AND operation_id = '$b_op_id'";
							//echo $rec_qty_from_temp;
							$result_rec_qty_from_temp = $link->query($rec_qty_from_temp);
							while($row_temp = $result_rec_qty_from_temp->fetch_assoc()) 
							{
								$pre_recieved_qty_temp = $row_temp['recevied_qty'];
								$act_reciving_qty_temp = $b_rep_qty[$key]+$b_rej_qty[$key];
							//	echo "bcdtemp=".$act_reciving_qty_temp."-".$send_qty."</br>";
								if($act_reciving_qty_temp > $send_qty)
								{
									$concurrent_flag = 1;
								}
							}

						}
					}
				}
				if($concurrent_flag == 0)
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

					if($r_qtys[$tid] != null && $r_reason[$tid] != null){
						$r_qty_array = explode(',',$r_qtys[$tid]);
						$r_reasons_array = explode(',',$r_reason[$tid]);
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
						if($result_query)
						{
							if($b_rep_qty[$key] > 0 || $b_rej_qty[$key] >0)
							{
								$bulk_insert_post_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$b_remarks[$key].'")';	
								$result_query_001_temp = $link->query($bulk_insert_post_temp) or exit('bulk_insert_post query error in updating');
							}
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
							// $query_post_dep.'</br>';
							$result_query = $link->query($query_post_dep) or exit('query error in updating');
					
						}
				// }				 
						
					// }
					//echo $barcode_generation;
					if($barcode_generation != 1)
					{
						//echo $tid; 
						// var_dump($r_qty);
						// var_dump($r_reasons);
						// var_dump($r_reason);
						// var_dump($r_qtys);
						if($r_qtys[$tid] != null && $r_reason[$tid] != null){
							$bulk_insert_rej .= '("'.$b_style.'","'.$b_schedule.'","'.$b_colors[$key].'",user(),"'.date('Y-m-d').'","'.$b_sizes[$key].'","'.$b_rej_qty[$key].'","3","'.$remarks_var.'","'.$remarks_code.'","'.$b_doc_num[$key].'","'.$b_job_no.'","'. $b_op_id.'","'. $b_remarks[$key].'","'.$b_tid[$key].'"),';
							$reason_flag = true;
						}
					}
					//echo $bulk_insert_rej;
					
				}
				
			}
			if($concurrent_flag == 1)
			{
				echo "<h1 style='color:red;'>You are Scanning More than eligible quantity.</h1>";
			}
			if($concurrent_flag == 0)
			{
				if($barcode_generation != 1)
				{
					if($reason_flag)
					{
						if(substr($bulk_insert_rej, -1) == ',')
						{
							$final_query = substr($bulk_insert_rej, 0, -1);
						}
						else
						{
							$final_query = $bulk_insert_rej;
						}
						//echo $final_query;
						$rej_insert_result = $link->query($final_query) or exit('data error');
					}
				}
				if(strtolower($is_m3) == 'yes' && $flag_decision)
				{
					if(substr($m3_bulk_bundle_insert, -1) == ',')
					{
						$final_query100 = substr($m3_bulk_bundle_insert, 0, -1);
					}
					else
					{
						$final_query100 = $m3_bulk_bundle_insert;
					}
					// echo $final_query100;;
					$rej_insert_result100 = $link->query($final_query100) or exit('data error');
				}
			}
				// $sql_message = 'Data Updated Successfully';
		}	
	}
	//echo "<script>$('#storingfomr').submit()</script>";
		if($concurrent_flag == 0)
		{
			$hout_ops_qry = "SELECT operation_code from $brandix_bts.tbl_ims_ops where appilication='Down_Time'";
			// echo $hout_ops_qry;
			$hout_ops_result = $link->query($hout_ops_qry);

			if($hout_ops_result->num_rows > 0)
			{
				while($hout_ops_result_data = $hout_ops_result->fetch_assoc()) 
				{
					$hout_ops_code = $hout_ops_result_data['operation_code'];
				}

				
				if($b_op_id == $hout_ops_code){
					$hout_data_qry = "select * from $bai_pro2.hout where out_date = '$tod_date' and left(out_time,2) = '$cur_h' and team = '$b_module'";
					// echo $hout_data_qry;
					$hout_data_result = $link->query($hout_data_qry);

					if($hout_data_result->num_rows > 0)
					{
						while($hout_result_data = $hout_data_result->fetch_assoc()) 
						{
							$row_id = $hout_result_data['id'];
							$hout_date = $hout_result_data['out_date'];
							$out_time = $hout_result_data['out_time'];
							$team = $hout_result_data['team'];
							$qty = $hout_result_data['qty'];
						}
						$upd_qty = $qty + $rep_sum_qty;
						$hout_update_qry = "update $bai_pro2.hout set qty = '$upd_qty' where id= $row_id";
						$hout_update_result = $link->query($hout_update_qry);
						// update
					}else{
						$hout_insert_qry = "insert into $bai_pro2.hout(out_date, out_time, team, qty, status, remarks) values('$tod_date','$cur_hour','$b_module','$rep_sum_qty', '1', 'NA')";
						$hout_insert_result = $link->query($hout_insert_qry);
						// insert
					}
				}
			}
			$table_data = "<div class='container'><div class='row'><div id='no-more-tables'><table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Input Job</th><th>Bundle Number</th><th>Color</th><th>Size</th><th>Remarks</th><th>Reporting Qty</th><th>Rejecting Qty</th></tr></thead><tbody>";
			// $checking_output_ops_code = "SELECT operation_code FROM $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color='$mapped_color' AND ops_dependency >= 130 AND ops_dependency < 200";
			$appilication = 'IMS_OUT';
			$checking_output_ops_code = "SELECT operation_code from $brandix_bts.tbl_ims_ops where appilication='$appilication'";
			//echo $checking_output_ops_code;
			// $checking_output_ops_code = "SELECT operation_code from $brandix_bts.tbl_ims_ops where id=6";
			$result_checking_output_ops_code = $link->query($checking_output_ops_code);
			if($result_checking_output_ops_code->num_rows > 0)
			{
			    while($row_result_checking_output_ops_code = $result_checking_output_ops_code->fetch_assoc()) 
			    {
                   $output_ops_code = $row_result_checking_output_ops_code['operation_code'];
			    }
			}
			else
			{
				$output_ops_code = 130;
			}
			//echo $output_ops_code;
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
						if($b_rep_qty[$i] > 0)
						{
							$insert_imslog="insert into $bai_pro3.ims_log (ims_date,ims_cid,ims_doc_no,ims_mod_no,ims_shift,
							ims_size,ims_qty,ims_log_date,ims_style,ims_schedule,ims_color,rand_track,bai_pro_ref,input_job_rand_no_ref,input_job_no_ref,pac_tid,ims_remarks,operation_id) values ('".$ims_log_date."','".$cat_ref."','".$b_doc_num[$i]."','".$b_module."','".$b_shift."','".trim($sizevalue)."','".$b_rep_qty[$i]."',CURRENT_TIMESTAMP(),'".$b_style."','".$b_schedule."','".$b_colors[$i]."','$b_doc_num[$i]','$bundle_op_id','".$b_job_no."','".$b_inp_job_ref[$i]."','".$b_tid[$i]."','".$b_remarks[$i]."','".$b_op_id."')";
							//echo "Insert Ims log :".$insert_imslog."</br>";
							$qry_status=mysqli_query($link,$insert_imslog);
						}
						
					}
				
				}
				else if($b_op_id == $output_ops_code)
				{
					//getting input ops code from output ops with operation sequence
					$selecting_output_from_seq_query = "select operation_code from $brandix_bts.tbl_style_ops_master where ops_sequence = $ops_seq and operation_code != $b_op_id and style='$b_style' and color = '$mapped_color'";
					//echo $selecting_output_from_seq_query;
					$result_selecting_output_from_seq_query = $link->query($selecting_output_from_seq_query);
					if($result_selecting_output_from_seq_query->num_rows > 0)
					{
						while($row = $result_selecting_output_from_seq_query->fetch_assoc()) 
						{
							$input_ops_code = $row['operation_code'];
						}
					}
					else
					{
						$input_ops_code = 129;
					}
					//echo 'input_ops_code'.$input_ops_code;
					if($input_ops_code == 100 || $input_ops_code == 129)
					{
						//updating ims_pro_qty against the input
						$searching_query_in_imslog = "SELECT * FROM $bai_pro3.ims_log WHERE pac_tid = '$b_tid[$i]' AND ims_mod_no='$b_module' AND ims_style='$b_style' AND ims_schedule='$b_schedule' AND ims_color='$b_colors[$i]' AND input_job_rand_no_ref='$b_job_no' AND operation_id='$input_ops_code' AND ims_remarks = '$b_remarks[$i]'";
						//echo $searching_query_in_imslog.'</br>';
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
							//echo $act_ims_qty.'-'.$pre_ims_qty.'-'.$b_rep_qty[$i].'</br>';
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
				$appilication_out = "IMS_OUT";
			    $checking_output_ops_code_out = "SELECT operation_code from $brandix_bts.tbl_ims_ops where appilication='$appilication_out'";
			   // echo $checking_output_ops_code_out;
			    $result_checking_output_ops_code_out = $link->query($checking_output_ops_code_out);
			    if($result_checking_output_ops_code_out->num_rows > 0)
			    {
			        while($row_result_checking_output_ops_code_out = $result_checking_output_ops_code_out->fetch_assoc()) 
			       {
                      $output_ops_code_out = $row_result_checking_output_ops_code_out['operation_code'];
			       }
			    }
			    else
			    {
				 $output_ops_code_out = 130;
			    }
				if($b_op_id == $output_ops_code_out)
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
					$table_data .= "<tr><td data-title='Job No'>$b_inp_job_ref[$i]</td><td data-title='Bundle No'>$b_tid[$i]</td><td data-title='Color'>$b_colors[$i]</td><td data-title='Size'>$size</td><td data-title='Remarks'>$b_remarks[$i]</td><td data-title='Reported Qty'>$b_rep_qty[$i]</td><td data-title='Rejected Qty'>$b_rej_qty[$i]</td></tr>";
				}
			}
			$table_data .= "</tbody></table></div></div></div>";
			echo $table_data;
		}
	}

?>