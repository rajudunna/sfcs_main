<!DOCTYPE html>
<html>
<head>
	<title>Carton Reversal</title>
	<?php
		include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
		include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	?>
</head>
<body>
	<div class="panel panel-primary">
		<div class="panel-heading">Carton Reversal</div>
		<div class="panel-body">
			<form class="form-inline" action="<?php $_GET['r'] ?>" method="POST">
				<label>Carton Barcode ID: </label>
				<input type="text" name="carton_id" class="form-control" id="carton_id" value="" required>
				&nbsp;&nbsp;
				<input type="submit" name="submit" id="submit" class="btn btn-success confirm-submit">
			</form>
			<?php
				if (isset($_POST['submit']))
				{
					$carton_id = $_POST['carton_id'];
					$carton_query = "SELECT * FROM $bai_pro3.pac_stat WHERE id = $carton_id";
					// echo $carton_query;
					$carton_details=mysqli_query($link, $carton_query) or exit("Error while getting Carton Details");
					
					if (mysqli_num_rows($carton_details) > 0)
					{
						// while($row=mysqli_fetch_array($carton_details)) 
						// {
							// $status = $row['status'];
							// $doc_no_ref=$row['doc_no_ref'];
						// }
						$b_tid = array();
						$get_all_tid = "SELECT group_concat(tid) as tid,min(status) as status FROM $bai_pro3.`pac_stat_log` WHERE pac_stat_id = '".$carton_id."';";
						$tid_result = mysqli_query($link,$get_all_tid);
						while($row12=mysqli_fetch_array($tid_result))
						{
							$b_tid[]=$row12['tid'];	
							$status = $row['status'];		
						}

						$b_op_id_query = "SELECT operation_code FROM $brandix_bts.`tbl_orders_ops_ref` WHERE category='PACKING';";
						$sql_result=mysqli_query($link, $b_op_id_query) or exit("Error while fetching operation code");
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							$b_op_id=$sql_row['operation_code'];
						}

						if ($status == NULL || $status == '(NULL)')
						{
							echo "<script>sweetAlert('Carton Not Scanned','Reversal Not Possible','warning')</script>";
						}
						else
						{
							$update_pac_stat_log = "UPDATE $bai_pro3.pac_stat_log SET status=NULL WHERE pac_stat_id = '".$carton_id."'";
							mysqli_query($link, $update_pac_stat_log) or exit("Error while updating pac_stat_log");

							// $update_mo_oprns_qty = "UPDATE $bai_pro3.mo_operation_quantites SET good_quantity = 0 WHERE bundle_no = $carton_id";
							// mysqli_query($link, $update_mo_oprns_qty) or exit("Error while updating mo_operations_qty");

							// $update_m3_tran = "INSERT INTO bai_pro3.`m3_transactions` (date_time,mo_no,quantity,reason,remarks,log_user,tran_status_code,module_no,shift,op_code,op_des,ref_no) SELECT NOW(),mo_no,quantity*-1,'cpk_reversal',remarks,USER(),'0',module_no,shift,'200','CPK',$carton_id FROM bai_pro3.`m3_transactions` WHERE ref_no=$carton_id AND op_code=200 AND op_des='CPK';";
							// // echo $update_m3_tran;
							// mysqli_query($link, $update_m3_tran) or exit("Error while updating m3_transactions");

							for($i=0;$i<sizeof($b_tid);$i++)
							{
								//759 CR additions Started
								$qry_to_check_mo_numbers = "select * from $bai_pro3.mo_operation_quantites where ref_no = $b_tid[$i] and op_code = $b_op_id order by mo_no";
								$qry_nop_result=mysqli_query($link,$qry_to_check_mo_numbers) or exit("Bundles Query Error14");
								while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
								{
									$mo_number = $nop_qry_row['mo_no'];
									$mo_quantity = $nop_qry_row['bundle_quantity'];
									$good_quantity_past = $nop_qry_row['good_quantity'];
									$id = $nop_qry_row['id'];
									$negative_qty = $good_quantity_past * -1;

									$update_qry = "update $bai_pro3.mo_operation_quantites set good_quantity = '0' where id= $id";
									$updating_mo_oprn_qty = mysqli_query($link,$update_qry) or exit("While updating mo_operation_quantites");

									// $inserting_into_m3_tran_log = "INSERT INTO bai_pro3.`m3_transactions` (date_time,mo_no,quantity,reason,remarks,log_user,tran_status_code,module_no,shift,op_code,op_des,ref_no) SELECT NOW(),mo_no,quantity*-1,'cpk_reversal',remarks,USER(),'0',module_no,shift,'200','CPK',$carton_id FROM bai_pro3.`m3_transactions` WHERE ref_no=$carton_id AND op_code=200 AND op_des='CPK';";

									$inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_transactions` (`date_time`,`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`) VALUES ('".date('Y-m-d h:i:s')."','$mo_number','$negative_qty','','cpk_reversal',user(),'','$b_op_id','CPK','$id','$work_station_id','')";
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
							echo "<script>sweetAlert('Carton ".$carton_id." is Reversed','','success')</script>";
						}
					}
					else
					{
						echo "<script>sweetAlert('No Cartons available with this ID - ".$carton_id."','','warning')</script>";
					}					
				}
			?>
		</div>
	</div>
</body>
</html>