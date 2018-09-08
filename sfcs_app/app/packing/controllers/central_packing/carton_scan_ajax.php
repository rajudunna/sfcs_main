<?php
	include('../../../../common/config/config_ajax.php');
	error_reporting(0);
	//API related data
	$plant_code = $global_facility_code;
	$company_num = $company_no;
	$host= $api_hostname;
	$port= $api_port_no;
	$current_date = date('Y-m-d h:i:s');

	$b_op_id_query = "SELECT operation_code FROM $brandix_bts.`tbl_orders_ops_ref` WHERE category='packing';";
	$sql_result=mysqli_query($link, $b_op_id_query) or exit("Error while fetching operation code");
	while($sql_row=mysqli_fetch_array($count_result))
	{
		$b_op_id=$sql_row['operation_code'];
	}

	if (isset($_GET['carton_id']))
	{
		$emp_id = $_GET['emp_id'];
		$carton_id = $_GET['carton_id'];
		$count_query = "SELECT * FROM $bai_pro3.pac_stat_log WHERE tid='".$carton_id."';";
		$count_result = mysqli_query($link,$count_query);
		if(mysqli_num_rows($count_result)>0)
		{
			while($sql_row=mysqli_fetch_array($count_result))
			{
				$doc_no_ref=$sql_row['doc_no_ref'];
				$status=$sql_row['status'];
			}

			$b_tid = array();
			$get_all_tid = "SELECT tid FROM bai_pro3.`pac_stat_log` WHERE doc_no_ref = '".$doc_no_ref."';";
			$tid_result = mysqli_query($link,$get_all_tid);
			while($row12=mysqli_fetch_array($tid_result))
			{
				$b_tid[]=$row12['tid'];				
			}


			$final_details = "SELECT carton_no,style, schedule, GROUP_CONCAT(DISTINCT TRIM(color) SEPARATOR '<br>') AS colors, GROUP_CONCAT(DISTINCT size_tit) AS sizes, SUM(carton_act_qty) AS carton_qty FROM bai_pro3.`pac_stat_log` WHERE doc_no_ref = '".$doc_no_ref."';";
			$final_result = mysqli_query($link,$final_details);
			while($row=mysqli_fetch_array($final_result))
			{
				$carton_no=$row['carton_no'];
				$style=$row['style'];
				$schedule=$row['schedule'];
				$colors=$row['colors'];
				$sizes=$row['sizes'];
				$carton_qty=$row['carton_qty'];
			}

			if ($status == 'DONE')
			{
				$result_array['status'] = 1;
			}
			else
			{
				$sql="update $bai_pro3.pac_stat_log set status=\"DONE\",audit_status=null, lastup=\"".date("Y-m-d H:i:s")."\",scan_date=\"".date("Y-m-d H:i:s")."\",scan_user=user() where doc_no_ref = '".$doc_no_ref."';";
				// echo $sql;
				$pac_stat_log_result = mysqli_query($link, $sql) or exit("Error while updating pac_stat_log");

				if (!$pac_stat_log_result)
				{
					$result_array['status'] = 3;
				}
				else
				{
					$result_array['status'] = 2;
					//getting workstation id
					$qry_to_get_work_station_id = "SELECT work_center_id,short_cut_code FROM $brandix_bts.`tbl_orders_ops_ref` WHERE operation_code = '$b_op_id'";
					$result_qry_to_get_work_station_id=mysqli_query($link,$qry_to_get_work_station_id) or exit("Error while getting workstation  id");
					while($row=mysqli_fetch_array($result_qry_to_get_work_station_id))
					{
						$work_station_id = $row['work_center_id'];
						$short_key_code = $row['short_cut_code'];
					}

					// echo $pac_stat_log_result;
					// die();
					for($i=0;$i<sizeof($b_tid);$i++)
					{
						//759 CR additions Started
						$qry_to_check_mo_numbers = "select * from $bai_pro3.mo_operation_quantites where bundle_no = $b_tid[$i] and op_code = $b_op_id order by mo_no";
						$qry_nop_result=mysqli_query($link,$qry_to_check_mo_numbers) or exit("Bundles Query Error14");
						while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
						{
							$mo_number = $nop_qry_row['mo_no'];
							$mo_quantity = $nop_qry_row['bundle_quantity'];
							$good_quantity_past = $nop_qry_row['good_quantity'];
							$id = $nop_qry_row['id'];

							$update_qry = "update $bai_pro3.mo_operation_quantites set good_quantity = $carton_qty where id= $id";
							$updating_mo_oprn_qty = mysqli_query($link,$update_qry) or exit("While updating mo_operation_quantites");

							$inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_transactions` (`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`) VALUES ('$mo_number','$carton_qty','','Normal',concat(user(),'-','$emp_id'),'','$b_shift','$b_op_id','','$id','$work_station_id','')";
							// echo $inserting_into_m3_tran_log;
							mysqli_query($link,$inserting_into_m3_tran_log) or exit("While inserting into m3_tranlog");

							//getting the last inserted record
							$insert_id=mysqli_insert_id($link);


							// //M3 Rest API Call START
							// $api_url = $host.":".$port."/m3api-rest/execute/PMS050MI/RptReceipt?CONO=$company_num&FACI=$plant_code&MFNO=$mo_number&RPQA=$carton_qty&DSP1=1&DSP2=1&DSP3=1&DSP4=1&DSP5=1";
							// $api_data = $obj->getCurlAuthRequest($api_url);
							// $decoded = json_decode($api_data,true);
							// $type=$decoded['@type'];
							// $code=$decoded['@code'];
							// $message=$decoded['Message'];

							// //validating response pass/fail and inserting log
							// if($type!='ServerReturnedNOK')
							// {
							// 	//updating response status in m3_transactions
							// 	$qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='pass' WHERE id=".$insert_id;
							// 	mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));

							// }
							// else
							// {
							// 	//updating response status in m3_transactions
							// 	$qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='fail' WHERE id=".$insert_id;
							// 	mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 Transactions".mysqli_error($GLOBALS["___mysqli_ston"]));

							// 	//insert transactions details into transactions_log
							// 	$qry_transactionslog="INSERT INTO $brandix_bts.`transactions_log` (`transaction_id`,`response_message`,`created_by`,`created_at`) VALUES ('$insert_id',$message,USER(),$current_date)"; 
							// 	mysqli_query($link,$qry_transactionslog) or exit("While inserting into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
							// }

							// //M3 Rest API Call END
						}						
					}
				}			
			}

			$result_array['carton_no'] = $carton_no;
			$result_array['style'] = $style;
			$result_array['schedule'] = $schedule;
			$result_array['color'] = $colors;
			$result_array['carton_act_qty'] = $carton_qty;
			$result_array['original_size'] = $sizes;
		}
		else
		{
			$result_array['status'] = 0;
		}
		echo json_encode($result_array);
	}
?>