<?php
include("../../../../../common/config/config_ajax.php");
include("../../../../../common/config/functions.php");
include("../../../../../common/config/m3Updations.php");
$post_data = $_POST['bulk_data'];
parse_str($post_data,$new_data);
$operation_code = $new_data['operation_id'];
$form = 'P';
$ops_dep='';
$post_ops_code='';
$qry_status='';
error_reporting(0);
if($operation_code >=130)
{
	$form = 'G';
}
$qery_rejection_resons = "select * from $bai_pro3.bai_qms_rejection_reason where form_type = '$form'";
$result_rejections = $link->query($qery_rejection_resons);
$bulk_insert_rej = "INSERT INTO $bai_pro3.bai_qms_db(`qms_style`, `qms_schedule`,`qms_color`,`log_user`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`,`remarks`, `ref1`, `doc_no`, `input_job_no`, `operation_id`, `qms_remarks`, `bundle_no`) VALUES";
$table_name = 'packing_summary_input';
$b_job_no = $new_data['job_number'];
$b_style= $new_data['style'];
$b_schedule=$new_data['schedule'];
$b_colors=$new_data['colors'];
$b_sizes = $new_data['sizes'];
$b_size_code = $new_data['old_size'];
$b_doc_num=$new_data['doc_no'];
$b_doc_num1=$new_data['doc_no'];
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
$r_reason=$new_data['reason_data'];
$r_qtys=$new_data['qty_data'];
$r_no_reasons = $new_data['tot_reasons'];
$mapped_color = $new_data['color'];
$type = $form;
$barcode_generation =  $new_data['barcode_generation'];
$emb_cut_check_flag = $new_data['emb_cut_check_flag'];
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
	$table_flag_checking = "SELECT send_qty,recevied_qty,rejected_qty FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = '$b_job_no' AND operation_id =$b_op_id";
	//echo $table_flag_checking;
	$result_select_send_qty = $link->query($table_flag_checking);
	if($result_select_send_qty->num_rows >0)
	{
		$table_name = 'bundle_creation_data';
	}
	$b_inp_job_ref = array();
	if($table_name == 'packing_summary_input')
	{
		// for positives
		foreach($b_tid as $key => $value)
		{
			$b_doc_num_exp = explode(',',$b_doc_num1[$key]);
			$to_add_doc_val = 0;
			$cumulative_qty = $b_rep_qty[$key];
			$module_cum = $b_module[$key];
			foreach($b_doc_num_exp as $doc_key => $doc_value)
			{
				// echo $doc_value.'-';
				$to_add = 0;
				//$fillup_qty[$doc_value][$b_sizes[$key]] = 0;
				$cumulative_qty = $to_add_doc_val + $cumulative_qty;
				$query_to_fetch_individual_bundles = "select tid,order_col_des,old_size,size_code,carton_act_qty,acutno,input_job_no,doc_no,barcode_sequence FROM $bai_pro3.packing_summary_input where order_col_des = '$b_colors[$key]' and size_code = '$b_sizes[$key]' and doc_no = $doc_value and input_job_no_random = '$b_job_no' order by barcode_sequence";
				//echo $query_to_fetch_individual_bundles.'</br>';
				$qry_nop_result=mysqli_query($link,$query_to_fetch_individual_bundles) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
				if($emb_cut_check_flag != 0)
				{
					$retreving_remaining_qty_qry = "SELECT sum(remaining_qty) as balance_to_report FROM $bai_pro3.cps_log WHERE doc_no in ($doc_value) AND size_title='$b_sizes[$key]' AND operation_code = $emb_cut_check_flag";
					// echo $retreving_remaining_qty_qry.'</br>';
					$result_retreving_remaining_qty_qry = $link->query($retreving_remaining_qty_qry);
					if($result_retreving_remaining_qty_qry->num_rows > 0)
					{
						while($row_remaining = $result_retreving_remaining_qty_qry->fetch_assoc()) 
						{
							$remaining_qty_doc = $row_remaining['balance_to_report'];
						}
						if($remaining_qty_doc <= $cumulative_qty)
						{
							$to_add_doc_val = $cumulative_qty - $remaining_qty_doc;
							$cumulative_qty = $remaining_qty_doc;
							//echo $cumulative_qty.'-'.$remaining_qty_doc.'</br>' ;
						}

					}
				}
				$remarks = $b_remarks[$key];
				while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
				{
					// echo $cumulative_qty.'</br>';
					//echo $b_rep_qty[$key].'</br>';
					$bundle_individual_number = $nop_qry_row['tid'];
					//echo $bundle_individual_number.'</br>';
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
					$b_module1[] = $module_cum;
					$barcode_sequence[] = $nop_qry_row['barcode_sequence'];
					if($cumulative_qty > 0)
					{
						$fetching_max_qty_to_insert_in_each_bundle = "select carton_act_qty from $bai_pro3.packing_summary_input where tid = $bundle_individual_number";
						//echo $fetching_max_qty_to_insert_in_each_bundle;
						$result_fetching_max_qty_to_insert_in_each_bundle = mysqli_query($link,$fetching_max_qty_to_insert_in_each_bundle) or exit("fetching_max_qty_to_insert_in_each_bundle error".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($row=mysqli_fetch_array($result_fetching_max_qty_to_insert_in_each_bundle))
						{
								$max_insertion_qty = $row['carton_act_qty'];
								$send_qty_array[$bundle_individual_number] = $row['carton_act_qty'];
								// echo $bundle_individual_number.'-'.$max_insertion_qty. '-' .$cumulative_qty.'</br>';
								if($max_insertion_qty <= $cumulative_qty)
								{
									$to_add += $max_insertion_qty;
									//$fillup_qty[$doc_value][$b_sizes[$key]] += $max_insertion_qty;
									$actual_rec_quantities[] = $max_insertion_qty;
									$rec_qtys_array[$bundle_individual_number] = $max_insertion_qty;
									$cumulative_qty = $cumulative_qty - $max_insertion_qty;
								}
								else if($max_insertion_qty > $cumulative_qty)
								{
									$to_add += $cumulative_qty;
									//$fillup_qty[$doc_value][$b_sizes[$key]] += $cumulative_qty;
									$actual_rec_quantities[] = $cumulative_qty;
									$rec_qtys_array[$bundle_individual_number] = $cumulative_qty;
									$cumulative_qty = 0;
								}
						}
					}
					else
					{
						$to_add += 0;
						$actual_rec_quantities[] =0;
						$rec_qtys_array[$bundle_individual_number] = 0;
					}	
				}
				//updating this to cps log
				$update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$to_add where doc_no = $doc_value and size_title='$b_sizes[$key]' AND operation_code = $emb_cut_check_flag";
				$update_qry_cps_log_res = $link->query($update_qry_cps_log);

			}
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
			$r_qty = explode(",", $r_qtys[$value]);
			$b_doc_num = explode(',',$b_doc_num1[$key]);
			$remaining_qty = 0;
			$remaining_qty_rej = 0;
			$cumulative_rej_qty = $b_rej_qty[$key];
			$to_add_doc_val = 0;
			foreach($b_doc_num as $doc_key => $doc_value)
			{
				$to_add = 0;
				$cumulative_rej_qty = $to_add_doc_val + $cumulative_rej_qty;
				$query_to_fetch_individual_bundles = "select tid,order_col_des,old_size,size_code,carton_act_qty,acutno,input_job_no,doc_no FROM $bai_pro3.packing_summary_input where order_col_des = '$b_colors[$key]' and size_code = '$b_sizes[$key]' and doc_no = $doc_value and input_job_no_random = '$b_job_no' order by barcode_sequence DESC";
				$qry_nop_result=mysqli_query($link,$query_to_fetch_individual_bundles) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
				if($emb_cut_check_flag != 0)
				{
					$retreving_remaining_qty_qry = "SELECT sum(remaining_qty) as balance_to_report FROM $bai_pro3.cps_log WHERE doc_no in ($doc_value) AND size_title='$b_sizes[$key]' AND operation_code = $emb_cut_check_flag";
					// echo $retreving_remaining_qty_qry.'</br>';
					$result_retreving_remaining_qty_qry = $link->query($retreving_remaining_qty_qry);
					if($result_retreving_remaining_qty_qry->num_rows > 0)
					{
						while($row_remaining = $result_retreving_remaining_qty_qry->fetch_assoc()) 
						{
							$remaining_qty_doc = $row_remaining['balance_to_report'];
						}
						if($remaining_qty_doc <= $cumulative_rej_qty)
						{
							$to_add_doc_val = $cumulative_rej_qty - $remaining_qty_doc;
							$cumulative_rej_qty = $remaining_qty_doc;
							//echo $cumulative_qty.'-'.$remaining_qty_doc.'</br>' ;
						}

					}
				}
				while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
				{
					$bundle_individual_number = $nop_qry_row['tid'];
					$fetching_max_qty_to_insert_in_each_bundle = "select carton_act_qty from $bai_pro3.packing_summary_input where tid = $bundle_individual_number";
					$result_fetching_max_qty_to_insert_in_each_bundle = mysqli_query($link,$fetching_max_qty_to_insert_in_each_bundle) or exit("fetching_max_qty_to_insert_in_each_bundle error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row=mysqli_fetch_array($result_fetching_max_qty_to_insert_in_each_bundle))
					{
						if($cumulative_rej_qty > 0)
						{
							$max_insertion_qty = $row['carton_act_qty'] - $rec_qtys_array[$bundle_individual_number];
							if($max_insertion_qty <= $cumulative_rej_qty)
							{
								$to_add = $max_insertion_qty;
								$actual_rej_quantities[$bundle_individual_number] = $max_insertion_qty;
								$cumulative_rej_qty =  $cumulative_rej_qty - $max_insertion_qty;
							}
							else if($max_insertion_qty > $cumulative_rej_qty)
							{
								$to_add = $cumulative_rej_qty;
								$actual_rej_quantities[$bundle_individual_number] = $cumulative_rej_qty;
								$cumulative_rej_qty = 0;
							}
							$remarks_code = $reason_code.'-'.$insertable_qty_rej;
							$remarks_var = $b_module[$key].'-'.$b_shift.'-'.$type;
							//updating this to cps log
							$update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$to_add where doc_no = $doc_value and size_title='$b_sizes[$key]' AND operation_code = $emb_cut_check_flag";
							$update_qry_cps_log_res = $link->query($update_qry_cps_log);
							$pre_insertion_qty = 0;
							$max_insertion_qty_rej = $max_insertion_qty;
							$actual_rejection_reason_array[$bundle_individual_number] = 0;
							if(sizeof($reason_remaining_qty)>0)
							{
								foreach($reason_remaining_qty as $remain_qty_key => $remain_qty_value)
								{
									$bundle_max_insertion_qty =  $actual_rej_quantities[$bundle_individual_number] - $actual_rejection_reason_array[$bundle_individual_number];
									$remain_qty_value = $reason_remaining_qty[$remain_qty_key];
									if($bundle_max_insertion_qty != 0)
									{
										if($bundle_max_insertion_qty <= $remain_qty_value)
										{
											$actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$remain_qty_key.'-'. $bundle_max_insertion_qty ;
											$insertable_qty_rej = $bundle_max_insertion_qty;
											$remainis = $remain_qty_value - $bundle_max_insertion_qty;
											$reason_remaining_qty[$remain_qty_key] = $remainis;
											$actual_rejection_reason_array[$bundle_individual_number] += $bundle_max_insertion_qty;
										}
										else
										{
											$actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$remain_qty_key.'-'. $remain_qty_value ;
											$insertable_qty_rej = $remain_qty_value;
											$reason_remaining_qty[$remain_qty_key] = 0;
											$actual_rejection_reason_array[$bundle_individual_number] += $remain_qty_value;
										}
										$rejection_code_fetech_qry = "select reason_code from $bai_pro3.bai_qms_rejection_reason where reason_code= '$remain_qty_key'";
										$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
										while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
										{
											$reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
										}
										$remarks_code = $reason_code.'-'.$insertable_qty_rej;
										$remarks_var = $b_module[$key].'-'.$b_shift.'-'.$type;
										if($insertable_qty_rej > 0)
										{
											$bulk_insert_rej .= '("'.$b_style.'","'.$b_schedule.'","'.$qms[$bundle_individual_number]['order_col_des'].'",user(),"'.date('Y-m-d').'","'.$qms[$bundle_individual_number]['old_size'].'","'.$insertable_qty_rej.'","3","'.$remarks_var.'","'.$remarks_code.'","'.$qms[$bundle_individual_number]['doc_no'].'","'.$b_job_no.'","'. $b_op_id.'","'. $qms[$bundle_individual_number]['remarks'].'","'.$bundle_individual_number.'"),';
										}
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
											$actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$r_reasons [$reason_key].'-'.$bundle_max_insertion_qty ;
											$insertable_qty_rej = $bundle_max_insertion_qty;
											$remaining_bundle_qty = $reson_max_qty-$bundle_max_insertion_qty;
											$remaining_bundle_reason = $r_reasons[$reason_key];
											if($remaining_bundle_qty > 0)
											{
												$reason_remaining_qty[$r_reasons[$reason_key]] = $remaining_bundle_qty;
											}
												
										}
										else
										{
											$actual_rejection_reason_array[$bundle_individual_number] += $reson_max_qty;
											$actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$r_reasons[$reason_key].'-'.$reson_max_qty ;
											$bundle_remaining_exces_qty = $bundle_max_insertion_qty - $reson_max_qty;
											$bundle_remaining_qty[$bundle_individual_number] = $bundle_remaining_exces_qty;
											$insertable_qty_rej = $reson_max_qty;
											$reason_remaining_qty[$r_reasons[$reason_key]] = 0;
										}
										$rejection_code_fetech_qry = "select reason_code from $bai_pro3.bai_qms_rejection_reason where reason_code= '$r_reasons[$reason_key]'";
										$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
										while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
										{
											$reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
										}
										$remarks_code = $reason_code.'-'.$insertable_qty_rej;
										$remarks_var = $b_module[$key].'-'.$b_shift.'-'.$type;
										if($insertable_qty_rej > 0)
										{
											$bulk_insert_rej .= '("'.$b_style.'","'.$b_schedule.'","'.$qms[$bundle_individual_number]['order_col_des'].'",user(),"'.date('Y-m-d').'","'.$qms[$bundle_individual_number]['old_size'].'","'.$insertable_qty_rej.'","3","'.$remarks_var.'","'.$remarks_code.'","'.$qms[$bundle_individual_number]['doc_no'].'","'.$b_job_no.'","'. $b_op_id.'","'. $qms[$bundle_individual_number]['remarks'].'","'.$bundle_individual_number.'"),';
										}
									}
									else 
									{
										$reason_remaining_qty[$r_reasons[$reason_key]] = $reson_max_qty;
									}
									
								}
								$remarks_code = $reason_code.'-'.$insertable_qty_rej;
								$remarks_var = $b_module[$key].'-'.$b_shift.'-'.$type;
							}
						}
						else 
						{
							$to_add += 0;
							$actual_rej_quantities[$bundle_individual_number] = 0;
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
		$b_module = array();
		$b_doc_num = array();
		$b_colors=$b_colors_1;
		$b_sizes = $b_sizes_1;
		$b_size_code = $b_size_code_1;
		$b_a_cut_no = $b_a_cut_no_1;
		$b_remarks = $b_remarks_1;
		$b_doc_num = $b_doc_num_1;
		$b_module = $b_module1;
		// var_dump($b_module);	
	}
	else
	{
		//for positive quantities 
		foreach($b_tid as $key => $value)
		{
			$module_cum = $b_module[$key];
			$r_reasons = explode(",", $r_reason[$value]);
			$r_qty = explode(",", $r_qtys[$value]);
			$remarks = $b_remarks[$key];
			$cumulative_qty = $b_rep_qty[$key];
			$to_add_doc_val = 0;
			$b_doc_num_exp = explode(',',$b_doc_num1[$key]);
			foreach($b_doc_num_exp as $doc_key => $doc_value)
			{
				$to_add = 0;
				// echo 'cum'.$cumulative_qty;
				//echo $doc_value.'up'.$to_add_doc_val.'</br>';
				$cumulative_qty = $to_add_doc_val + $cumulative_qty;
				$query_to_fetch_individual_bundles = "select bundle_number,(send_qty+recut_in+replace_in)as send_qty,recevied_qty,rejected_qty,color,size_title,size_id,original_qty,cut_number,docket_number,input_job_no,barcode_sequence FROM $brandix_bts.bundle_creation_data where color = '$b_colors[$key]' and size_title = '$b_sizes[$key]' and input_job_no_random_ref = '$b_job_no' AND operation_id = $b_op_id and docket_number = $doc_value and assigned_module='$module_cum' order by barcode_sequence";
				$qry_nop_result=mysqli_query($link,$query_to_fetch_individual_bundles) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
				$remaining_qty_rec = 0;
				if($emb_cut_check_flag != 0)
				{
					$retreving_remaining_qty_qry = "SELECT sum(remaining_qty) as balance_to_report FROM $bai_pro3.cps_log WHERE doc_no in ($doc_value) AND size_title='$b_sizes[$key]' AND operation_code = $emb_cut_check_flag";
					$result_retreving_remaining_qty_qry = $link->query($retreving_remaining_qty_qry);
					// if($result_retreving_remaining_qty_qry->num_rows > 0)
					// {
						while($row_remaining = $result_retreving_remaining_qty_qry->fetch_assoc()) 
						{
							$remaining_qty_doc = $row_remaining['balance_to_report'];
						}
						//echo $remaining_qty_doc.'-'.$cumulative_qty.'</br>';
						if($remaining_qty_doc <= $cumulative_qty)
						{
							$to_add_doc_val = $cumulative_qty - $remaining_qty_doc;
							$cumulative_qty = $remaining_qty_doc;
							//echo $doc_value.'down'.$to_add_doc_val.'</br>';
						}

				//	}
				}
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
					$barcode_sequence[] = $nop_qry_row['barcode_sequence'];
					$b_colors_1[] =  $nop_qry_row['color'];
					$b_sizes_1[] =  $nop_qry_row['size_title'];
					$b_size_code_1[] = $nop_qry_row['size_id'];
					$b_in_job_qty[] = $nop_qry_row['original_qty'];
					$b_a_cut_no_1[] = $nop_qry_row['cut_number'];
					$b_doc_num_1[] = $nop_qry_row['docket_number'];
					$b_inp_job_ref[] = $nop_qry_row['input_job_no'];
					$b_remarks_1[] = $remarks;
					$b_module1[] = $module_cum;
					$bundle_individual_number = $nop_qry_row['bundle_number'];
					//echo $doc_value.'-'.$bundle_individual_number.'-'.$cumulative_qty.'</br>';
					if($cumulative_qty > 0)
					{
						$bundle_pending_qty =  $nop_qry_row['send_qty'] - ($nop_qry_row['recevied_qty']+$nop_qry_row['rejected_qty']);
						if($bundle_pending_qty > 0 && $cumulative_qty > 0)
						{
							if($bundle_pending_qty <= $cumulative_qty)
							{
								$actual_rec_quantities[]=$bundle_pending_qty;
								$rec_qtys_array[$bundle_individual_number] = $bundle_pending_qty;
								//$fillup_qty[$doc_value][$b_sizes[$key]] = $bundle_pending_qty;
								$remaining_qty_rec = $cumulative_qty - $bundle_pending_qty;
								$cumulative_qty = $remaining_qty_rec;
								$to_add += $bundle_pending_qty;
								//$bundle_pending_qty = 0;
							}
							else
							{
								$actual_rec_quantities[]=$cumulative_qty;
								$rec_qtys_array[$bundle_individual_number] = $cumulative_qty;
								//$fillup_qty[$doc_value][$b_sizes[$key]] = $cumulative_qty;
								$cumulative_qty = 0;
								$to_add += $cumulative_qty;
							}
						}
						else if($bundle_pending_qty == 0)
						{
							$actual_rec_quantities[]=0;
							$rec_qtys_array[$bundle_individual_number] = 0;
							$to_add += 0;
						}
					}
					else
					{
						$actual_rec_quantities[] = 0;
						$rec_qtys_array[$bundle_individual_number] = 0;
						$to_add += 0;
					}
				}
				$update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$to_add where doc_no = $doc_value and size_title='$b_sizes[$key]' AND operation_code = $emb_cut_check_flag";
				$update_qry_cps_log_res = $link->query($update_qry_cps_log);
			}
			

		}
		//for negatives
		if(array_sum($r_qtys) > 0)
		{
			foreach($b_tid as $key => $value)
			{
				$r_reasons = explode(",", $r_reason[$value]);
				// var_dump($r_reasons);
				$r_qty = explode(",", $r_qtys[$value]);
				$reason_remaining_qty = array();
				$cumulative_rej_qty = $b_rej_qty[$key];
				$remaining_qty_rej = $b_rej_qty[$key];
				$b_doc_num = explode(',',$b_doc_num1[$key]);
				$remaining_qty = 0;
				$remaining_qty_rej = 0;
				$to_add_doc_val = 0;
				$module_cum = $b_module[$key];
				foreach($b_doc_num as $doc_key => $doc_value)
				{
					$to_add = 0;
					$cumulative_rej_qty = $to_add_doc_val + $cumulative_rej_qty;
					$remaining_qty_rej = $cumulative_rej_qty;
					$query_to_fetch_individual_bundles = "select bundle_number,(send_qty+recut_in+replace_in)as send_qty,recevied_qty,rejected_qty FROM $brandix_bts.bundle_creation_data where color = '$b_colors[$key]' and size_title = '$b_sizes[$key]' and input_job_no_random_ref = '$b_job_no' AND operation_id = $b_op_id AND docket_number = $doc_value AND assigned_module = '$module_cum' order by barcode_sequence DESC";
					// echo $query_to_fetch_individual_bundles.'-';
					$qry_nop_result=mysqli_query($link,$query_to_fetch_individual_bundles) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
					if($emb_cut_check_flag != 0)
					{
						$retreving_remaining_qty_qry = "SELECT sum(remaining_qty) as balance_to_report FROM $bai_pro3.cps_log WHERE doc_no in ($doc_value) AND size_title='$b_sizes[$key]' AND operation_code = $emb_cut_check_flag";
						$result_retreving_remaining_qty_qry = $link->query($retreving_remaining_qty_qry);
						if($result_retreving_remaining_qty_qry->num_rows > 0)
						{
							while($row_remaining = $result_retreving_remaining_qty_qry->fetch_assoc()) 
							{
								$remaining_qty_doc = $row_remaining['balance_to_report'];
							}
							if($remaining_qty_doc <= $cumulative_rej_qty)
							{
								$to_add_doc_val = $cumulative_rej_qty - $remaining_qty_doc;
								$cumulative_rej_qty = $remaining_qty_doc;
								$remaining_qty_rej = $remaining_qty_doc;
								//echo $cumulative_qty.'-'.$remaining_qty_doc.'</br>' ;
							}

						}
					}
					while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
					{
						$bundle_individual_number = $nop_qry_row['bundle_number'];
						if($cumulative_rej_qty > 0)
						{
							$bundle_pending_qty_rej =  $nop_qry_row['send_qty'] - ( $nop_qry_row['recevied_qty']+$rec_qtys_array[$bundle_individual_number]+$nop_qry_row['rejected_qty']);
							if($bundle_pending_qty_rej != 0)
							{
								if($bundle_pending_qty_rej <= $remaining_qty_rej)
								{
									$to_add += $bundle_pending_qty_rej;
									$actual_rej_quantities[$bundle_individual_number]=$bundle_pending_qty_rej;
									$remaining_qty_rej = $cumulative_rej_qty - $bundle_pending_qty_rej;
									$cumulative_rej_qty = $remaining_qty_rej;
								}
								else
								{
									$to_add += $cumulative_rej_qty;
									$actual_rej_quantities[$bundle_individual_number]=$cumulative_rej_qty;
									$cumulative_rej_qty = 0;
									$remaining_qty_rej = 0;
								}
							}
							else if($bundle_pending_qty_rej == 0)
							{
								$to_add += 0;
								$actual_rej_quantities[$bundle_individual_number]=0;
							}
							$remarks_code = $reason_code.'-'.$insertable_qty_rej;
							$remarks_var = $b_module[$key].'-'.$b_shift.'-'.$type;
						}
						else
						{
							$to_add += 0;
							$actual_rej_quantities[$bundle_individual_number]=0;
						}
						$update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$to_add where doc_no = $doc_value and size_title='$b_sizes[$key]' AND operation_code = $emb_cut_check_flag";
						$update_qry_cps_log_res = $link->query($update_qry_cps_log);
						//rejection resons
						$pre_insertion_qty = 0;
						// $max_insertion_qty_rej = $max_insertion_qty;
						$actual_rejection_reason_array[$bundle_individual_number] = 0;
						if(sizeof($reason_remaining_qty)>0)
						{
							foreach($reason_remaining_qty as $remain_qty_key => $remain_qty_value)
							{
								//echo "hII".$bundle_individual_number.'-'.$actual_rej_quantities[$bundle_individual_number].'-'.$actual_rejection_reason_array[$bundle_individual_number].'</br>';
								$bundle_max_insertion_qty =  $actual_rej_quantities[$bundle_individual_number] - $actual_rejection_reason_array[$bundle_individual_number];
								$remain_qty_value = $reason_remaining_qty[$remain_qty_key];
								// echo $bundle_individual_number.'-'.$bundle_max_insertion_qty.'</br>';
								if($bundle_max_insertion_qty != 0)
								{
									if($remain_qty_value > 0)
									{
										if($bundle_max_insertion_qty <= $remain_qty_value)
										{
											// echo '3 = '.$bundle_individual_number.'-'.$remain_qty_key.'-'. $bundle_max_insertion_qty.'</br>';
											$actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$remain_qty_key.'-'. $bundle_max_insertion_qty ;
											$insertable_qty_rej = $bundle_max_insertion_qty;
											$remainis = $remain_qty_value - $bundle_max_insertion_qty;
											$reason_remaining_qty[$remain_qty_key] = $remainis;
											$actual_rejection_reason_array[$bundle_individual_number] += $bundle_max_insertion_qty;
										}
										else
										{
											//$remain_qty_value = $reason_remaining_qty[$remain_qty_key];
											// echo '4 = '.$bundle_individual_number.'-'.$remain_qty_key.'-'. $remain_qty_value.'</br>';
											$actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$remain_qty_key.'-'. $remain_qty_value ;
											$insertable_qty_rej = $remain_qty_value;
											$reason_remaining_qty[$remain_qty_key] = 0;
											$actual_rejection_reason_array[$bundle_individual_number] += $remain_qty_value;
										}
										$rejection_code_fetech_qry = "select reason_code from $bai_pro3.bai_qms_rejection_reason where reason_code= '$remain_qty_key'";
										$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
										while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
										{
											$reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
										}
										$remarks_code = $reason_code.'-'.$insertable_qty_rej;
										$remarks_var = $b_module[$key].'-'.$b_shift.'-'.$type;
										if($insertable_qty_rej > 0)
										{
											$bulk_insert_rej .= '("'.$b_style.'","'.$b_schedule.'","'.$qms[$bundle_individual_number]['order_col_des'].'",user(),"'.date('Y-m-d').'","'.$qms[$bundle_individual_number]['old_size'].'","'.$insertable_qty_rej.'","3","'.$remarks_var.'","'.$remarks_code.'","'.$qms[$bundle_individual_number]['doc_no'].'","'.$b_job_no.'","'. $b_op_id.'","'. $qms[$bundle_individual_number]['remarks'].'","'.$bundle_individual_number.'"),';
										}

									}
								}
							}
						}
						else
						{
							// $r_reasons = array_filter($r_reasons);
							foreach($r_reasons as $reason_key => $reason_value)
							{
								$reson_max_qty = $r_qty[$reason_key];
								$bundle_max_insertion_qty =  $actual_rej_quantities[$bundle_individual_number] - $actual_rejection_reason_array[$bundle_individual_number];
								// echo $bundle_individual_number.'-'.$bundle_max_insertion_qty.'</br>';
								if($bundle_max_insertion_qty != 0)
								{

									if($bundle_max_insertion_qty <= $reson_max_qty)
									{
										$actual_rejection_reason_array[$bundle_individual_number] += $bundle_max_insertion_qty;
										// echo '1 = '.$bundle_individual_number.'-'.$r_reasons [$reason_key].'-'.$bundle_max_insertion_qty.'</br>';
										$actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$r_reasons [$reason_key].'-'.$bundle_max_insertion_qty ;
										$insertable_qty_rej = $bundle_max_insertion_qty;
										$remaining_bundle_qty = $reson_max_qty-$bundle_max_insertion_qty;
										$remaining_bundle_reason = $r_reasons[$reason_key];
										if($remaining_bundle_qty > 0)
										{
											$reason_remaining_qty[$r_reasons[$reason_key]] = $remaining_bundle_qty;
										}
											
									}
									else
									{
										$actual_rejection_reason_array[$bundle_individual_number] += $reson_max_qty;
										// echo '2 = '.$bundle_individual_number.'-'.$r_reasons[$reason_key].'-'.$reson_max_qty.'</br>';
										$actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$r_reasons[$reason_key].'-'.$reson_max_qty ;
										$bundle_remaining_exces_qty = $bundle_max_insertion_qty - $reson_max_qty;
										$bundle_remaining_qty[$bundle_individual_number] = $bundle_remaining_exces_qty;
										$insertable_qty_rej = $reson_max_qty;
										$reason_remaining_qty[$r_reasons[$reason_key]] = 0;
									}
									$rejection_code_fetech_qry = "select reason_code from $bai_pro3.bai_qms_rejection_reason where reason_code= '$r_reasons[$reason_key]'";
									$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
									while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
									{
										$reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
									}
									$remarks_code = $reason_code.'-'.$insertable_qty_rej;
									$remarks_var = $b_module[$key].'-'.$b_shift.'-'.$type;
									if($insertable_qty_rej > 0)
									{
										$bulk_insert_rej .= '("'.$b_style.'","'.$b_schedule.'","'.$qms[$bundle_individual_number]['order_col_des'].'",user(),"'.date('Y-m-d').'","'.$qms[$bundle_individual_number]['old_size'].'","'.$insertable_qty_rej.'","3","'.$remarks_var.'","'.$remarks_code.'","'.$qms[$bundle_individual_number]['doc_no'].'","'.$b_job_no.'","'. $b_op_id.'","'. $qms[$bundle_individual_number]['remarks'].'","'.$bundle_individual_number.'"),';
									}
								}
								else 
								{
									$reason_remaining_qty[$r_reasons[$reason_key]] = $reson_max_qty;
								}
								
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
		$b_module = array();
		$b_doc_num = array();
		$b_colors=$b_colors_1;
		$b_sizes = $b_sizes_1;
		$b_size_code = $b_size_code_1;
		$b_a_cut_no = $b_a_cut_no_1;
		$b_remarks = $b_remarks_1;
		$b_doc_num = $b_doc_num_1;
		$b_module = $b_module1;

	}
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
		$rej_insert_result = $link->query($final_query) or exit('data error');
	}
	$b_tid = array();
	$b_rep_qty = array();
	$b_rej_qty = array();
	foreach($actual_bundles as $key=>$value)
	{
		$b_tid[] = $actual_bundles[$key];
		$b_rep_qty[] = $actual_rec_quantities[$key];
		$b_rej_qty[] = $actual_rej_quantities[$value];
	}
}

//Before CR Logic
foreach ($b_tid as $key=>$value)
{
	$select_send_qty = "SELECT send_qty,recevied_qty,rejected_qty,recut_in,replace_in FROM $brandix_bts.bundle_creation_data WHERE bundle_number = $b_tid[$key] AND operation_id = $b_op_id";
	$result_select_send_qty = $link->query($select_send_qty);
	if($result_select_send_qty->num_rows >0)
	{
		$table_name = 'bundle_creation_data';
		while($row = $result_select_send_qty->fetch_assoc()) 
		{
			$send_qty = $row['send_qty']+$row['recut_in']+$row['replace_in'];
			$pre_recieved_qty = $row['recevied_qty'];
			$rejected_qty = $row['rejected_qty'];
			$recut_in = $row['recut_in'];
			$replace_in = $row['replace_in'];
			$act_reciving_qty = $b_rep_qty[$key]+$b_rej_qty[$key];
			$total_rec_qty = $pre_recieved_qty+$act_reciving_qty+$rejected_qty;
			if($total_rec_qty > $send_qty)
			{
				$concurrent_flag = 1;
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
		$fetching_job_number_from_bundle = "select input_job_no_random FROM $bai_pro3.packing_summary_input where tid=$b_job_no";
		$result_fetching_job_number_from_bundle = $link->query($fetching_job_number_from_bundle);
		while($row = $result_fetching_job_number_from_bundle->fetch_assoc()) 
		{
			$b_job_no = $row['input_job_no_random'];
		}
	}
	$remarks_var = $b_module[$key].'-'.$b_shift.'-'.$type;
	$reason_flag = false;
	$dep_ops_array_qry = "select operation_code,ops_sequence, default_operration,smv from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' and operation_code=$b_op_id";
	$result_dep_ops_array_qry = $link->query($dep_ops_array_qry);
	while($row = $result_dep_ops_array_qry->fetch_assoc()) 
	{
		$sequnce = $row['ops_sequence'];
		$is_m3 = $row['default_operration'];
		$sfcs_smv = $row['smv'];
	}
	$ops_dep_qry = "SELECT ops_dependency,operation_code,ops_sequence FROM $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' and ops_sequence='$sequnce' AND ops_dependency != 200 AND ops_dependency != 0 group by ops_dependency";
	$result_ops_dep_qry = $link->query($ops_dep_qry);
	while($row = $result_ops_dep_qry->fetch_assoc()) 
	{
		$ops_dep = $row['ops_dependency'];
	}
	if($ops_dep)
	{
		$dep_ops_array_qry_raw = "select operation_code from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' and ops_dependency=$ops_dep";
		$result_dep_ops_array_qry_raw = $link->query($dep_ops_array_qry_raw);
		while($row = $result_dep_ops_array_qry_raw->fetch_assoc()) 
		{
			$dep_ops_codes[] = $row['operation_code'];	
		}
	}
	$ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$mapped_color' and operation_code=$b_op_id";
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
	$pre_ops_check = "SELECT tm.operation_code as operation_code,ops_sequence FROM $brandix_bts.tbl_style_ops_master tm LEFT JOIN brandix_bts.`tbl_orders_ops_ref` tr ON tr.id=tm.operation_name WHERE style='".$b_style."' AND color = '".$mapped_color."' and (ops_sequence = ".$ops_seq." or ops_sequence in  (".implode(',',$ops_seq_dep).")) AND  tr.category NOT IN ('cutting','Send PF','Receive PF') AND tm.operation_code != 200";
	// echo $pre_ops_check;
	$result_pre_ops_check = $link->query($pre_ops_check);
	if($result_pre_ops_check->num_rows > 0)
	{
		while($row = $result_pre_ops_check->fetch_assoc()) 
		{
			$pre_ops_code[] = $row['operation_code'];
		}
	}
	$post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$mapped_color' and ops_sequence = $ops_seq  AND CAST(operation_order AS CHAR) > '$ops_order' AND operation_code not in (10,200,15) ORDER BY operation_order ASC LIMIT 1";
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
			$b_query[$op_code] = "INSERT  INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `mapped_color`,`barcode_sequence`,`barcode_number`) VALUES";

			// temp table data query

			$b_query_temp[$op_code] = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`) VALUES";
		}
	}
	if($table_name == 'packing_summary_input')
	{
		$bulk_insert = "INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`,`mapped_color`,`barcode_sequence`,`barcode_number`) VALUES";
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
						//$m3_bulk_bundle_insert .= '("'.date('Y-m-d').'","'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'. $b_size_code[$key].'","'. $b_sizes[$key].'","'.$b_doc_num[$key].'","'.$r_qty_array[$index].'","'.$r_reasons_array[$index].'","'.$b_remarks[$key].'",USER(),"'. $b_op_id.'","'.$b_inp_job_ref[$key].'","'.$b_module.'","'.$b_shift.'","'.$b_op_name.'","'.$b_tid[$key].'",""),';
						$rejection_code_fetech_qry = "select reason_code from $bai_pro3.bai_qms_rejection_reason where reason_code= '$r_reasons_array[$index]'";
						//echo $rejection_code_fetech_qry;
						$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
						while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
						{
							$reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
						}
						if($index == sizeof($r_qty_array)-1){
							$remarks_code .= $reason_code.'-'.$r_qnty;
						}else {
							$remarks_code .= $reason_code.'-'.$r_qnty ;
						}
					}
				}		
				// (`qms_style`, `qms_schedule`,`qms_color`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`, `remarks`, `doc_no`, `input_job_no`)
				$bulk_insert .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'","'.$b_remarks[$key].'","'.$mapped_color.'","'.$barcode_sequence[$key].'","'.$b_tid[$key].'"),';

				// temp table data insertion query.........
				if($b_rep_qty[$key] > 0 || $b_rej_qty[$key] > 0)
				{
					$bulk_insert_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'","'.$b_remarks[$key].'"),';
				}
				//m3 operations............. 
				if($b_rep_qty[$key] > 0) {
					//$m3_bulk_bundle_insert .= '("'.date('Y-m-d').'","'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'.$b_doc_num[$key].'","'.$b_rep_qty[$key].'","","'.$b_remarks[$key].'",USER(),"'. $b_op_id.'","'.$b_inp_job_ref[$key].'","'.$b_module.'","'.$b_shift.'","'.$b_op_name.'","'.$b_tid[$key].'",""),';
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
						    $send_qty =0;
							if($op_code == $post_ops_code)
							{
								$send_qty = $b_rep_qty[$key];
							}
							$rec_qty = 0;
							$rej_qty = 0;
							$b_query[$op_code] .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$send_qty.'","'.$rec_qty.'","'.$rej_qty.'","'.$left_over_qty.'","'. $op_code.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'","'.$b_remarks[$key].'","'.$mapped_color.'","'.$barcode_sequence[$key].'","'.$b_tid[$key].'"),';

							$b_query_temp[$op_code] .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$send_qty.'","'.$rec_qty.'","'.$rej_qty.'","'.$left_over_qty.'","'. $op_code.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'"),';
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
		//commenting to decrease the response time
		/* foreach ($b_tid as $key=>$value)
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
		}*/
		if($concurrent_flag == 0)
		{
			foreach($b_query as $index1 => $query){
				if(substr($query, -1) == ','){
					$final_query_001 = substr($query, 0, -1);
				}else{
					$final_query_001 = $query;
				}
				//echo $final_query_001.'</br>';
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
					//echo $final_query;
					//$rej_insert_result = $link->query($final_query) or exit('data error');
				}
			}
			
			//echo $m3_bulk_bundle_insert;
			
			// if(strtolower($is_m3) == 'yes' && $flag_decision){
			// 	if(substr($m3_bulk_bundle_insert, -1) == ','){
			// 		$final_query100 = substr($m3_bulk_bundle_insert, 0, -1);
			// 	}else{
			// 		$final_query100 = $m3_bulk_bundle_insert;
			// 	}
			// 	//echo $final_query100;
			// 	// die();
			// 	//$rej_insert_result100 = $link->query($final_query100) or exit('data error');
			// }
			$sql_message = 'Data inserted successfully';
		}
		foreach($b_tid as $key=>$value)
		{
			if($ops_dep)
			{
				$pre_send_qty_qry = "select min(recevied_qty)as recieved_qty from $brandix_bts.bundle_creation_data where bundle_number =$b_tid[$key] and operation_id in (".implode(',',$dep_ops_codes).")";
				//echo $pre_send_qty_qry;
				$result_pre_send_qty = $link->query($pre_send_qty_qry);
				while($row = $result_pre_send_qty->fetch_assoc()) 
				{
					$pre_recieved_qty = $row['recieved_qty'];
				}

				$query_post_dep = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$pre_recieved_qty."', `scanned_date`='". date('Y-m-d')."' where bundle_number =$b_tid[$key] and operation_id = ".$ops_dep;
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
			$smv_query = "select smv from $brandix_bts.tbl_style_ops_master where style='$b_style' and color='$mapped_color' and operation_code = $b_op_id";
			$result_smv_query = $link->query($smv_query);
			while($row_ops = $result_smv_query->fetch_assoc()) 
			{
				$sfcs_smv = $row_ops['smv'];
			}
			$bulk_insert_post_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`) VALUES";
			$schedule_count = true;
			$concurrent_flag = 0;
			foreach ($b_tid as $key => $tid) 
			{
				if($b_rep_qty[$key] > 0 || $b_rej_qty[$key] > 0)
				{
					$remarks_code = "";
					if($b_rep_qty[$key] == null){
						$b_rep_qty[$key] = 0;
					}
					if($b_rej_qty[$key] == null){
						$b_rej_qty[$key] = 0;
					}
					$left_over_qty = $b_in_job_qty[$key] - ($b_rep_qty[$key] + $b_rej_qty[$key]);
					// appending all values to query for bulk insert....
					$select_send_qty = "SELECT recevied_qty,rejected_qty FROM $brandix_bts.bundle_creation_data WHERE bundle_number = $b_tid[$key] AND operation_id =$b_op_id";
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
					$query = "UPDATE $brandix_bts.bundle_creation_data SET `recevied_qty`= '".$final_rep_qty."', `rejected_qty`='". $final_rej_qty."', `left_over`= '".$left_over_qty."' , `scanned_date`='". date('Y-m-d')."' where bundle_number =$b_tid[$key] and operation_id = ".$b_op_id;
					// echo $query.'</br>';
					$result_query = $link->query($query) or exit('query error in updating');
					}
					//m3 operations............. 
					if($b_rep_qty[$key] > 0){
						$flag_decision = true;
					}
					if($result_query)
					{
						if($b_rep_qty[$key] > 0 || $b_rej_qty[$key] >0)
						{
							$bulk_insert_post_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'","'.$b_remarks[$key].'"),';	
							//$result_query_001_temp = $link->query($bulk_insert_post_temp) or exit('bulk_insert_post query error in updating');
						}
					}	
					if($post_ops_code != null)
					{
						$query_post = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$final_rep_qty."', `scanned_date`='". date('Y-m-d')."' where bundle_number =$b_tid[$key] and operation_id = ".$post_ops_code;
						$result_query = $link->query($query_post) or exit('query error in updating');
					}
					if($ops_dep)
					{
						$pre_send_qty_qry = "select min(recevied_qty)as recieved_qty from $brandix_bts.bundle_creation_data where bundle_number =$b_tid[$key] and operation_id in (".implode(',',$dep_ops_codes).")";
						//echo $pre_send_qty_qry;
						$result_pre_send_qty = $link->query($pre_send_qty_qry);
						while($row = $result_pre_send_qty->fetch_assoc()) 
						{
							$pre_recieved_qty = $row['recieved_qty'];
						}

						$query_post_dep = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$pre_recieved_qty."', `scanned_date`='". date('Y-m-d')."' where bundle_number =$b_tid[$key] and operation_id = ".$ops_dep;
						// $query_post_dep.'</br>';
						$result_query = $link->query($query_post_dep) or exit('query error in updating');
				
					}
					if($barcode_generation != 1)
					{
						if($r_qtys[$tid] != null && $r_reason[$tid] != null){
							$bulk_insert_rej .= '("'.$b_style.'","'.$b_schedule.'","'.$b_colors[$key].'",user(),"'.date('Y-m-d').'","'.$b_sizes[$key].'","'.$b_rej_qty[$key].'","3","'.$remarks_var.'","'.$remarks_code.'","'.$b_doc_num[$key].'","'.$b_job_no.'","'. $b_op_id.'","'. $b_remarks[$key].'","'.$b_tid[$key].'"),';
							$reason_flag = true;
						}
					}
					
				}
				
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
			}
			if(substr($bulk_insert_post_temp, -1) == ','){
				$final_query_000_temp = substr($bulk_insert_post_temp, 0, -1);
			}else{
				$final_query_000_temp = $bulk_insert_post_temp;
			}
			//echo $bulk_insert.'<br>';
			$bundle_creation_result_temp = $link->query($final_query_000_temp);
		}	
	}
	if($concurrent_flag == 0)
	{
		$table_data = "<div class='container'><div class='row'><div id='no-more-tables'><table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Input Job</th><th>Bundle Number</th><th>Color</th><th>Size</th><th>Remarks</th><th>Reporting Qty</th><th>Rejecting Qty</th></tr></thead><tbody>";
		// $checking_output_ops_code = "SELECT operation_code FROM $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color='$mapped_color' AND ops_dependency >= 130 AND ops_dependency < 200";
		$appilication = 'IMS_OUT';
		$checking_output_ops_code = "SELECT operation_code from $brandix_bts.tbl_ims_ops where appilication='$appilication'";
		//echo $checking_output_ops_code;
		//$checking_output_ops_code = "SELECT operation_code from $brandix_bts.tbl_ims_ops where id=6";
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
			if($b_rep_qty[$i] > 0)
			{
				$hout_plant_timings_qry = "SELECT TIME(NOW()),start_time,end_time,time_id FROM $bai_pro3.tbl_plant_timings WHERE  start_time<=TIME(NOW()) AND end_time>=TIME(NOW())";
				$hout_plant_timings_result = $link->query($hout_plant_timings_qry);

				if($hout_plant_timings_result->num_rows > 0){
					while($hout_plant_timings_result_data = $hout_plant_timings_result->fetch_assoc()) 
					{
						$plant_start_timing = $hout_plant_timings_result_data['start_time'];
						$plant_end_timing = $hout_plant_timings_result_data['end_time'];
						$plant_time_id = $hout_plant_timings_result_data['time_id'];
					}
				}

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
						$hout_data_qry = "select id,out_date,out_time,team,qty from $bai_pro2.hout where out_date = '$tod_date' and team = '$b_module[$i]' and time_parent_id = $plant_time_id";
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
							$upd_qty = $qty + $b_rep_qty[$i];
							$hout_update_qry = "update $bai_pro2.hout set qty = '$upd_qty' where id= $row_id";
							$hout_update_result = $link->query($hout_update_qry);
							// update
						}else{
							$hout_insert_qry = "insert into $bai_pro2.hout(out_date, out_time, team, qty, status, remarks, rep_start_time, rep_end_time, time_parent_id) values('$tod_date','$cur_hour','$b_module[$i]','$b_rep_qty[$i]', '1', 'NA', '$plant_start_timing', '$plant_end_timing', '$plant_time_id')";
							$hout_insert_result = $link->query($hout_insert_qry);
							// insert
						}
					}
				}
				if($b_op_id == 100 || $b_op_id == 129)
				{
					$searching_query_in_imslog = "SELECT tid,ims_qty FROM $bai_pro3.ims_log_backup WHERE pac_tid = $b_tid[$i] AND ims_mod_no='$b_module[$i]' AND ims_style='$b_style' AND ims_schedule='$b_schedule' AND ims_color='$b_colors[$i]' AND input_job_rand_no_ref='$b_job_no' AND operation_id=$b_op_id AND ims_remarks = '$b_remarks[$i]'";
					$result_searching_query_in_imslog = $link->query($searching_query_in_imslog);
					if($result_searching_query_in_imslog->num_rows > 0)
					{
						while($row = $result_searching_query_in_imslog->fetch_assoc()) 
						{
							$updatable_id = $row['tid'];
							$pre_ims_qty = $row['ims_qty'];
							$act_ims_input_qty = $row['ims_qty'];
						}
						$act_ims_qty = $pre_ims_qty + $b_rep_qty[$i];
						//updating the ims_qty when it was there in ims_log
						$update_query = "update $bai_pro3.ims_log_backup set ims_qty = $act_ims_qty where tid = $updatable_id";
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
					else
					{
						//Searching whethere the operation was present in the ims log and ims buff
						$searching_query_in_imslog = "SELECT tid,ims_qty FROM $bai_pro3.ims_log WHERE pac_tid = '$b_tid[$i]' AND ims_mod_no='$b_module[$i]' AND ims_style='$b_style' AND ims_schedule='$b_schedule' AND ims_color='$b_colors[$i]' AND input_job_rand_no_ref='$b_job_no' AND operation_id=$b_op_id AND ims_remarks = '$b_remarks[$i]'";
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
							$catrefd_qry="select cat_ref FROM $bai_pro3.plandoc_stat_log WHERE order_tid in (select order_tid FROM bai_pro3.bai_orders_db WHERE order_style_no='$b_style' AND order_del_no='$b_schedule' AND order_col_des='$b_colors[$i]')";
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
								ims_size,ims_qty,ims_log_date,ims_style,ims_schedule,ims_color,rand_track,bai_pro_ref,input_job_rand_no_ref,input_job_no_ref,pac_tid,ims_remarks,operation_id) values ('".$ims_log_date."','".$cat_ref."','".$b_doc_num[$i]."','".$b_module[$i]."','".$b_shift."','".trim($sizevalue)."','".$b_rep_qty[$i]."',CURRENT_TIMESTAMP(),'".$b_style."','".$b_schedule."','".$b_colors[$i]."','$b_doc_num[$i]','$bundle_op_id','".$b_job_no."','".$b_inp_job_ref[$i]."','".$b_tid[$i]."','".$b_remarks[$i]."','".$b_op_id."')";
								//echo "Insert Ims log :".$insert_imslog."</br>";
								$qry_status=mysqli_query($link,$insert_imslog);
							}
							
						}
					}
					//Searching whethere the operation was present in the ims log and ims buff
					
				
				}
				else if($b_op_id == $output_ops_code)
				{
					//getting input ops code from output ops with operation sequence
					// $selecting_output_from_seq_query = "select operation_code from $brandix_bts.tbl_style_ops_master where ops_sequence = $ops_seq and operation_code != $b_op_id and style='$b_style' and color = '$mapped_color'";
					// //echo $selecting_output_from_seq_query;
					// $result_selecting_output_from_seq_query = $link->query($selecting_output_from_seq_query);
					// if($result_selecting_output_from_seq_query->num_rows > 0)
					// {
					// 	while($row = $result_selecting_output_from_seq_query->fetch_assoc()) 
					// 	{
					// 		$input_ops_code = $row['operation_code'];
					// 	}
					// }
					// else
					// {
						// $input_ops_code = 100;
						$input_ops_code=echo_title("$brandix_bts.tbl_ims_ops","operation_code","appilication",'IPS',$link);
					//}
					//echo 'input_ops_code'.$input_ops_code;
					if($input_ops_code == 100 || $input_ops_code == 129)
					{
						//updating ims_pro_qty against the input
						$searching_query_in_imslog = "SELECT tid,ims_pro_qty,ims_qty FROM $bai_pro3.ims_log WHERE pac_tid = '$b_tid[$i]' AND ims_mod_no='$b_module[$i]' AND ims_style='$b_style' AND ims_schedule='$b_schedule' AND ims_color='$b_colors[$i]' AND input_job_rand_no_ref='$b_job_no' AND operation_id=$input_ops_code AND ims_remarks = '$b_remarks[$i]'";
						// echo $searching_query_in_imslog.'</br>';
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
					$sizevalue="size_".$b_size_code[$i];
					$sections_qry="select section FROM $bai_pro3.module_master WHERE module_name='$b_module[$i]'";
					//echo $sections_qry;
					$sections_qry_result=mysqli_query($link,$sections_qry) or exit("Bundles Query Error15".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($buyer_qry_row=mysqli_fetch_array($sections_qry_result)){
							$sec_head=$buyer_qry_row['section'];
					}
					$ims_log_date=date("Y-m-d");
					$bac_dat=$ims_log_date;
					$log_time=date("Y-m-d");
					$buyer_qry="select order_div FROM $bai_pro3.bai_orders_db WHERE order_style_no='".$b_style."' AND order_del_no='".$b_schedule."' AND order_col_des='".$b_colors[$i]."'";
					$buyer_qry_result=mysqli_query($link,$buyer_qry) or exit("Bundles Query Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($buyer_qry_row=mysqli_fetch_array($buyer_qry_result)){
							$buyer_div=str_replace("'","",(str_replace('"',"",$buyer_qry_row['order_div'])));
						}
					$qry_nop="select ((present+jumper)-absent) as nop FROM $bai_pro.pro_attendance where module='".$b_module[$i]."' and date='".$bac_dat."' and shift='".$b_shift."'";
					// echo $qry_nop;
					$qry_nop_result=mysqli_query($link,$qry_nop) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
					{
							$avail=$nop_qry_row['nop'];
					}
					if(mysqli_num_rows($qry_nop_result)>0){
						$nop=$avail;
					}else{
						$nop=0;
					}
					$bundle_op_id=$b_tid[$i]."-".$b_op_id."-".$b_inp_job_ref[$i];
					$insert_bailog="insert into $bai_pro.bai_log (bac_no,bac_sec,bac_Qty,bac_lastup,bac_date,
					bac_shift,bac_style,bac_stat,log_time,buyer,delivery,color,loguser,ims_doc_no,smv,".$sizevalue.",ims_table_name,ims_tid,nop,ims_pro_ref,ope_code,jobno
					) values ('".$b_module[$i]."','".$sec_head."','".$b_rep_qty[$i]."',DATE_FORMAT(NOW(), '%Y-%m-%d %H'),'".$bac_dat."','".$b_shift."','".$b_style."','Active','".$log_time."','".$buyer_div."','".$b_schedule."','".$b_colors[$i]."',USER(),'".$b_doc_num[$i]."','".$sfcs_smv."','".$b_rep_qty[$i]."','ims_log','".$b_op_id."','".$nop."','".$bundle_op_id."','".$b_op_id."','".$b_inp_job_ref[$i]."')";
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
						) values ('".$b_module[$i]."','".$sec_head."','".$b_rep_qty[$i]."',DATE_FORMAT(NOW(), '%Y-%m-%d %H'),'".$bac_dat."','".$b_shift."','".$b_style."','Active','".$log_time."','".$buyer_div."','".$b_schedule."','".$b_colors[$i]."',USER(),'".$b_doc_num[$i]."','".$sfcs_smv."','".$b_rep_qty[$i]."','ims_log','".$b_op_id."','".$nop."','".$b_op_id."','".$b_op_id."','".$b_inp_job_ref[$i]."')";
						//echo "</br>Insert Bailog buf: ".$insert_bailogbuf."</br>";
						if($b_rep_qty[$i] > 0)
						{
							$qrybuf_status=mysqli_query($link,$insert_bailogbuf) or exit("BAI Log Buf Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
					}
				}			
				

			}
			if($b_rep_qty[$i] > 0 || $b_rej_qty[$i] > 0)
				{
					//echo $b_rej_qty[$i];
					$size = strtoupper($b_sizes[$i]);
					$table_data .= "<tr><td data-title='Job No'>$b_inp_job_ref[$i]</td><td data-title='Bundle No'>$b_tid[$i]</td><td data-title='Color'>$b_colors[$i]</td><td data-title='Size'>$size</td><td data-title='Remarks'>$barcode_sequence[$i]</td><td data-title='Reported Qty'>$b_rep_qty[$i]</td><td data-title='Rejected Qty'>$b_rej_qty[$i]</td></tr>";
				}
			
		}
		$table_data .= "</tbody></table></div></div></div>";
	
		//updating into  m3 transactions for positives		
		for($i=0;$i<sizeof($b_tid);$i++)
		{
			if($b_rep_qty[$i] > 0)
			{
				updateM3Transactions($b_tid[$i],$b_op_id,$b_rep_qty[$i]);
			}
			
		}
		// var_dump($actual_rejection_reason_array_string);
		if(sizeof($actual_rejection_reason_array_string) > 0)
		{
			for($i=0;$i<sizeof($actual_rejection_reason_array_string);$i++)
			{
				$r_qty = array();
				$r_reasons = array();
				$implode_next = explode('-',$actual_rejection_reason_array_string[$i]);
				$r_qty[] = $implode_next[2];
				$rejection_code_fetech_qry = "select m3_reason_code from $bai_pro3.bai_qms_rejection_reason where reason_code= $implode_next[1]";
				$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
				while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
				{
					$m3_reason_code = $rowresult_rejection_code_fetech_qry['m3_reason_code'];
				}
				$r_reasons[] = $m3_reason_code;
				$b_tid = $implode_next[0];
				//retreving bcd id from bundle_ceration_data and inserting into the rejection_log table and rejection_log_child
				$bcd_id_qry = "select id,style,schedule,color,docket_number,size_title,size_id,assigned_module,input_job_no_random_ref from $brandix_bts.bundle_creation_data where bundle_number=$b_tid and operation_id = $b_op_id";
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
					$inserting_into_rejection_log_child_qry = "INSERT INTO `bai_pro3`.`rejection_log_child` (`parent_id`,`bcd_id`,`doc_no`,`input_job_no_random_ref`,`size_id`,`size_title`,`assigned_module`,`rejected_qty`,`operation_id`) values($parent_id,$bcd_id,$doc_no,$input_job_random_ref,'$size_id','$size_title',$assigned_module,$implode_next[2],$b_op_id)";
					$insert_qry_rej_child = $link->query($inserting_into_rejection_log_child_qry);
				}
				//inserting into rejections_reason_track'
				if($implode_next[2] > 0)
				{
					$insert_into_rejections_reason_track = "INSERT INTO $bai_pro3.`rejections_reason_track` (`parent_id`,`date_time`,`bcd_id`,`rejected_qty`,`rejection_reason`,`username`,`form_type`) values ($parent_id,DATE_FORMAT(NOW(), '%Y-%m-%d %H'),$bcd_id,'$implode_next[2]','$implode_next[1]','$username','$form')";
					$insert_into_rejections_reason_track_res =$link->query($insert_into_rejections_reason_track);
				}
				updateM3TransactionsRejections($b_tid,$b_op_id,$r_qty,$r_reasons);
			}
		}	
	}
	echo $table_data;
}

?>
