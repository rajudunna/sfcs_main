<?php

// LOGIC TO INSERT TRANSACTIONS IN M3_TRANSACTIONS TABLE

function updateM3Transactions($input_doc_no,$op_code,$b_op_id,$input_shift,$plan_module){
    include('config.php');
    $current_date = date("Y-m-d H:i:s");
	$doc_no_ref = $input_doc_no;
	// $op_code  = '15';
	// $b_op_id  = '15';
	$b_shift  = $input_shift;
	$b_module = $plan_module;

	//getting work_station_id
	$qry_to_get_work_station_id = "SELECT work_center_id,short_cut_code FROM $brandix_bts.`tbl_orders_ops_ref` WHERE operation_code = '$b_op_id'";
	// echo $qry_to_get_work_station_id;
	$result_qry_to_get_work_station_id=mysqli_query($link,$qry_to_get_work_station_id) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($result_qry_to_get_work_station_id))
	{
		$work_station_id = $row['work_center_id'];
		$short_key_code = $row['short_cut_code'];
	}
	if(!$work_station_id)
	{
		$qry_to_get_work_station_id = "SELECT work_station_id FROM bai_pro3.`work_stations_mapping` WHERE operation_code = '$short_key_code' AND module = '$b_module'";
		//echo $qry_to_get_work_station_id;
		$result_qry_to_get_work_station_id=mysqli_query($link,$qry_to_get_work_station_id) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($result_qry_to_get_work_station_id))
		{
			$work_station_id = $row['work_station_id'];
		} 
	}
	//getting mos and filling up
	$qry_cut_qty_check_qry = "SELECT * FROM $bai_pro3.plandoc_stat_log WHERE doc_no = '$doc_no_ref' ";
	$result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
	while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
	{
		// $doc_array[$row['doc_no']] = $row['act_cut_status'];
		$plan_module = $row['plan_module'];
		$order_tid = $row['order_tid'];
		for ($i=0; $i < sizeof($sizes_array); $i++)
		{ 
			if ($row['a_'.$sizes_array[$i]] > 0)
			{
				$cut_done_qty[$sizes_array[$i]] = $row['a_'.$sizes_array[$i]] * $plies;
			}
		}
	}

	//var_dump($cut_done_qty);

	// INSERTING INTO M3_TRANSACTOINS TABLE AND UPDATING INTO M3_OPS_DETAILS
	foreach($cut_done_qty as $key => $value)
	{
		//759 CR additions Started
		//fetching size_title
		$qty_to_fetch_size_title = "SELECT title_size_$key  FROM $bai_pro3.bai_orders_db_confirm WHERE order_tid ='$order_tid'";
		// echo $qty_to_fetch_size_title;
		$res_qty_to_fetch_size_title=mysqli_query($link,$qty_to_fetch_size_title) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($nop_res_qty_to_fetch_size_title=mysqli_fetch_array($res_qty_to_fetch_size_title))
		{
			// echo "hi";
			$size_title = $nop_res_qty_to_fetch_size_title["title_size_$key"];
			//echo 'ore'.$size_title;
		}
		$qry_to_check_mo_numbers = "SELECT *,mq.id as mq_id FROM $bai_pro3.`mo_operation_quantites`  mq LEFT JOIN bai_pro3.mo_details md ON md.mo_no=mq.`mo_no` WHERE ref_no = '$doc_no_ref' AND op_code = '$op_code' and size = '$size_title' order by mq.mo_no";
		// echo $qry_to_check_mo_numbers;
		$qry_nop_result=mysqli_query($link,$qry_to_check_mo_numbers) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
		$total_bundle_present_qty = $value;
		$total_bundle_rec_present_qty = $value;
		while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
		{
			$total_bundle_present_qty = $total_bundle_rec_present_qty;
			// echo $total_bundle_present_qty;
			if($total_bundle_present_qty > 0)
			{
				$mo_number = $nop_qry_row['mo_no'];
				$mo_quantity = $nop_qry_row['bundle_quantity'];
				$good_quantity_past = $nop_qry_row['good_quantity'];
				$rejected_quantity_past = $nop_qry_row['rejected_quantity'];
				$id = $nop_qry_row['mq_id'];
				$ops_des = $nop_qry_row ['op_desc'];
				$balance_max_updatable_qty = $mo_quantity - ($good_quantity_past + $rejected_quantity_past);
				// echo $balance_max_updatable_qty .'-'. $total_bundle_rec_present_qty;
				if($balance_max_updatable_qty > 0)
				{
					if($balance_max_updatable_qty >= $total_bundle_rec_present_qty)
					{
						$to_update_qty = $total_bundle_rec_present_qty; 
						$actual_rep_qty = $good_quantity_past+$total_bundle_rec_present_qty;
						$update_qry = "update $bai_pro3.mo_operation_quantites set good_quantity = $actual_rep_qty where id= $id";
						$total_bundle_rec_present_qty = 0;
					}
					else
					{
						$to_update_qty = $balance_max_updatable_qty; 
						$actual_rep_qty = $good_quantity_past+$balance_max_updatable_qty;
						$update_qry = "update $bai_pro3.mo_operation_quantites set good_quantity = $actual_rep_qty where id= $id";
						$total_bundle_rec_present_qty = $total_bundle_rec_present_qty - $balance_max_updatable_qty;
					}
					//echo $update_qry.'</br>';
					$ims_pro_qty_updating = mysqli_query($link,$update_qry) or exit("While updating mo_operation_quantites".mysqli_error($GLOBALS["___mysqli_ston"]));
					// if($is_m3 == 'yes')
					// {
					$inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_transactions` (`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`) VALUES ('$mo_number',$to_update_qty,'','Normal',user(),'',$b_module,'$b_shift',$b_op_id,'$ops_des',$id,'$work_station_id','')";
				//echo $inserting_into_m3_tran_log.'</br>';
					mysqli_query($link,$inserting_into_m3_tran_log) or exit("While inserting into m3_tranlog".mysqli_error($GLOBALS["___mysqli_ston"]));
				// }

					$insert_id=mysqli_insert_id($link);

					// //M3 Rest API Call
					$api_url = $host.":".$port."/m3api-rest/execute/PMS070MI/RptOperation?CONO=$company_num&FACI=$plant_code&MFNO=$mo_number&OPNO=$b_op_id&DPLG=$work_station_id&MAQA=$to_update_qty&SCQA=''&SCRE=''&DSP1=1&DSP2=1&DSP3=1&DSP4=1";
					$api_data = $obj->getCurlAuthRequest($api_url);
					$decoded = json_decode($api_data,true);
					$type=$decoded['@type'];
					$code=$decoded['@code'];
					$message=$decoded['Message'];

					//validating response pass/fail and inserting log
					if($type!='ServerReturnedNOK'){
						//updating response status in m3_transactions
						$qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='pass' WHERE id=".$insert_id;
						mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));

					}else{
						//updating response status in m3_transactions
						$qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='fail' WHERE id=".$insert_id;
						mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 Transactions".mysqli_error($GLOBALS["___mysqli_ston"]));

						//insert transactions details into transactions_log
						$qry_transactionslog="INSERT INTO $brandix_bts.`transactions_log` (`transaction_id`,`response_message`,`created_by`,`created_at`) VALUES ('$insert_id',$message,USER(),$current_date)"; 
						mysqli_query($link,$qry_transactionslog) or exit("While inserting into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				}
			}
		}
	}
	return true;
}



function updateM3TransactionsReversal($bundle_no,$reversalval,$b_op_id,$b_module,$b_shift,$b_style,$b_colors,$key){
    include('config.php');
    $current_date = date("Y-m-d H:i:s");
	$b_tid = $bundle_no;
	$b_rep_qty = $reversalval;
	// var_dump($b_tid)
	for($i=0;$i<sizeof($b_tid);$i++)
	{
		$qry_to_get_work_station_id = "SELECT work_center_id,short_cut_code FROM $brandix_bts.`tbl_orders_ops_ref` WHERE operation_code = '$b_op_id'";
		// echo $qry_to_get_work_station_id;
		$result_qry_to_get_work_station_id=mysqli_query($link,$qry_to_get_work_station_id) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($result_qry_to_get_work_station_id))
		{
			$work_station_id = $row['work_center_id'];
			$short_key_code = $row['short_cut_code'];
		}
		if(!$work_station_id)
		{
			$qry_to_get_work_station_id = "SELECT work_station_id FROM bai_pro3.`work_stations_mapping` WHERE operation_code = '$short_key_code' AND module = '$b_module'";
			//echo $qry_to_get_work_station_id;
			$result_qry_to_get_work_station_id=mysqli_query($link,$qry_to_get_work_station_id) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row=mysqli_fetch_array($result_qry_to_get_work_station_id))
			{
				$work_station_id = $row['work_station_id'];
			} 
		}
		$qry_to_check_mo_numbers = "select * from $bai_pro3.mo_operation_quantites where ref_no = $b_tid[$i] and op_code = $b_op_id order by mo_no";
		// echo $qry_to_check_mo_numbers.'-';
		$qry_nop_result=mysqli_query($link,$qry_to_check_mo_numbers) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
		$total_bundle_rec_present_qty = $b_rep_qty[$i];
		while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
		{
			$total_bundle_present_qty = $total_bundle_rec_present_qty;
			// echo $total_bundle_present_qty;
			if($total_bundle_present_qty > 0)
			{
				$mo_number = $nop_qry_row['mo_no'];
				$mo_quantity = $nop_qry_row['bundle_quantity'];
				$good_quantity_past = $nop_qry_row['good_quantity'];
				$rejected_quantity_past = $nop_qry_row['rejected_quantity'];
				$id = $nop_qry_row['id'];
				$balance_max_updatable_qty = $good_quantity_past ;
				// echo $balance_max_updatable_qty .'-'. $total_bundle_rec_present_qty;
				if($balance_max_updatable_qty > 0)
				{
					if($balance_max_updatable_qty >= $total_bundle_rec_present_qty)
					{
						$to_update_qty = $total_bundle_rec_present_qty; 
						$actual_rep_qty = $good_quantity_past-$total_bundle_rec_present_qty;
						$update_qry = "update $bai_pro3.mo_operation_quantites set good_quantity = $actual_rep_qty where id= $id";
						$total_bundle_rec_present_qty = 0;
					}
					else
					{
						$to_update_qty = $balance_max_updatable_qty; 
						$actual_rep_qty = $good_quantity_past-$balance_max_updatable_qty;
						$update_qry = "update $bai_pro3.mo_operation_quantites set good_quantity = $actual_rep_qty where id= $id";
						$total_bundle_rec_present_qty = $total_bundle_rec_present_qty - $balance_max_updatable_qty;
					}
					// echo $update_qry.'</br>';
				$ims_pro_qty_updating = mysqli_query($link,$update_qry) or exit("While updating mo_operation_quantites".mysqli_error($GLOBALS["___mysqli_ston"]));
				$dep_ops_array_qry = "select default_operration from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$b_colors' and operation_code='$b_op_id'";
				$result_dep_ops_array_qry = $link->query($dep_ops_array_qry);
				while($row = $result_dep_ops_array_qry->fetch_assoc()) 
				{
					$is_m3 = $row['default_operration'];
				}
					if($is_m3 == 'Yes')
					{                    
						$to_update_qty = '-'.$b_rep_qty[$key];
						$inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_transactions` (`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`) VALUES ('$mo_number','$to_update_qty','','Normal',user(),'',$b_module,'$b_shift',$b_op_id,'',$id,'$work_station_id','')";
						// echo $inserting_into_m3_tran_log;
						mysqli_query($link,$inserting_into_m3_tran_log) or exit("While inserting into m3_tranlog".mysqli_error($GLOBALS["___mysqli_ston"]));
						$insert_id=mysqli_insert_id($link);

						// //M3 Rest API Call
							$api_url = $host.":".$port."/m3api-rest/execute/PMS070MI/RptOperation?CONO=$company_num&FACI=$plant_code&MFNO=$mo_number&OPNO=$b_op_id&DPLG=$work_station_id&MAQA=$to_update_qty&SCQA=''&SCRE=''&DSP1=1&DSP2=1&DSP3=1&DSP4=1";
							$api_data = $obj->getCurlAuthRequest($api_url);
							$decoded = json_decode($api_data,true);
							$type=$decoded['@type'];
							$code=$decoded['@code'];
							$message=$decoded['Message'];

							//validating response pass/fail and inserting log
							if($type!='ServerReturnedNOK'){
								//updating response status in m3_transactions
								$qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='pass' WHERE id=".$insert_id;
								mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));

							}else{
								//updating response status in m3_transactions
								$qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='fail' WHERE id=".$insert_id;
								mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 Transactions".mysqli_error($GLOBALS["___mysqli_ston"]));

								//insert transactions details into transactions_log
								$qry_transactionslog="INSERT INTO $brandix_bts.`transactions_log` (`transaction_id`,`response_message`,`created_by`,`created_at`) VALUES ('$insert_id',$message,USER(),$current_date)"; 
								mysqli_query($link,$qry_transactionslog) or exit("While inserting into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
							}
					}
					
				}
			}
		}
	}
}//Function ends


function updateM3TransactionsRejections($doc_no_ref,$size_title,$b_module,$op_code,$b_op_id,$b_shift,$work_station_id,$r_qty,$r_reasons)
{
    include('config.php');
    $current_date = date("Y-m-d H:i:s");
	foreach($r_qty as $key=>$value)
	{
		$qry_to_check_mo_numbers = "SELECT *,mq.id AS id FROM $bai_pro3.`mo_operation_quantites`  mq LEFT JOIN bai_pro3.mo_details md ON md.mo_no=mq.`mo_no` WHERE ref_no = '$doc_no_ref' AND op_code = '$op_code' and size = '$size_title'";
		//echo $qry_to_check_mo_numbers;
		$qry_nop_result=mysqli_query($link,$qry_to_check_mo_numbers) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
		$total_bundle_rej_present_qty = $r_qty[$key];
		while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
		{
			$total_bundle_present_qty = $total_bundle_rej_present_qty;
			$mo_number = $nop_qry_row['mo_no'];
			$mo_quantity = $nop_qry_row['bundle_quantity'];
			$good_quantity_past = $nop_qry_row['good_quantity'];
			$rejected_quantity_past = $nop_qry_row['rejected_quantity'];
			$id = $nop_qry_row['id'];
			//$mo_no = $nop_qry_row['id'];
			$balance_max_updatable_qty = $mo_quantity - ($good_quantity_past + $rejected_quantity_past);
			// echo $total_bundle_present_qty;
			if($total_bundle_present_qty > 0)
			{
				if($balance_max_updatable_qty > 0)
				{
					if($balance_max_updatable_qty >= $total_bundle_rej_present_qty)
					{
						$to_update_qty = $total_bundle_rej_present_qty;
						$actual_rej_qty = $rejected_quantity_past+$total_bundle_rej_present_qty;
						$update_qry = "update $bai_pro3.mo_operation_quantites set rejected_quantity = $actual_rej_qty where id= $id";
						$total_bundle_rej_present_qty = 0;
					}
					else
					{
						$to_update_qty = $balance_max_updatable_qty;
						$actual_rej_qty = $rejected_quantity_past+$balance_max_updatable_qty;
						$update_qry = "update $bai_pro3.mo_operation_quantites set rejected_quantity = $actual_rej_qty where id= $id";
						$total_bundle_rej_present_qty = $total_bundle_rej_present_qty - $balance_max_updatable_qty;
					}
					//echo $update_qry.'</br>';
					$ims_pro_qty_updating = mysqli_query($link,$update_qry) or exit("While updating mo_operation_quantites".mysqli_error($GLOBALS["___mysqli_ston"]));
					//echo $update_qry.'</br>';
					// echo $r_reasons[$key];
				
					$inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_transactions` (`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`) VALUES ('$mo_number',$to_update_qty,'$r_reasons[$key]','Normal',user(),'',$b_module,'$b_shift',$b_op_id,'',$id,'$work_station_id','')";
					// echo $inserting_into_m3_tran_log.'</br>';
					mysqli_query($link,$inserting_into_m3_tran_log) or exit("While inserting into the m3_transactions".mysqli_error($GLOBALS["___mysqli_ston"]));

					//getting the last inserted record
					$insert_id=mysqli_insert_id($link);

					//M3 Rest API Call
					$api_url = $host.":".$port."/m3api-rest/execute/PMS070MI/RptOperation?CONO=$company_num&FACI=$plant_code&MFNO=$mo_number&OPNO=$b_op_id&DPLG=$work_station_id&MAQA=''&SCQA=$to_update_qty&SCRE='$r_reasons[$key]'&DSP1=1&DSP2=1&DSP3=1&DSP4=1";
					$api_data = $obj->getCurlAuthRequest($api_url);
					$decoded = json_decode($api_data,true);
					$type=$decoded['@type'];
					$code=$decoded['@code'];
					$message=$decoded['Message'];

					//validating response pass/fail and inserting log
					if($type!='ServerReturnedNOK')
					{
						//updating response status in m3_transactions
						$qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='pass' WHERE id=".$insert_id;
						mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));

					}
					else
					{
						//updating response status in m3_transactions
						$qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='fail' WHERE id=".$insert_id;
						mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 Transactions".mysqli_error($GLOBALS["___mysqli_ston"]));

						//insert transactions details into transactions_log
						$qry_transactionslog="INSERT INTO $brandix_bts.`transactions_log` (`transaction_id`,`response_message`,`created_by`,`created_at`,`updated_at`) VALUES ('$insert_id',$message,USER(),$current_date)"; 
						mysqli_query($link,$qry_transactionslog) or exit("While inserting into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				}
			}
		}
    }
    return true;
}
?>




