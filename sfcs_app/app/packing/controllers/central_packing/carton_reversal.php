<!DOCTYPE html>
<html>
<head>
	<title>Carton Reversal</title>
	<?php
		include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
		include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
		include(getFullURLLevel($_GET['r'],'common/config/m3Updations.php',4,'R'));
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

					$application='packing';

					$carton_query = "SELECT * FROM $bai_pro3.pac_stat WHERE id = $carton_id";
					// echo $carton_query;
					$carton_details=mysqli_query($link, $carton_query) or exit("Error while getting Carton Details");
					
					if (mysqli_num_rows($carton_details) > 0)
					{
						$get_carton_type=mysqli_fetch_array($carton_details);
						$opn_status = $get_carton_type['opn_status'];

						if ($opn_status == null)
						{
							echo "<script>sweetAlert('Carton Not Scanned','Reversal Not Possible','warning')</script>";
						}
						else
						{
							$b_tid = array();
							$get_all_tid = "SELECT group_concat(tid) as tid,min(status) as status, style, color FROM bai_pro3.`pac_stat_log` WHERE pac_stat_id = '".$carton_id."'";
							$tid_result = mysqli_query($link,$get_all_tid);
							while($row12=mysqli_fetch_array($tid_result))
							{
								$b_tid=explode(",",$row12['tid']);
								$status=$row12['status'];
								$style=$row12['style'];
								$color=$row12['color'];
							}

							// Get first opn in packing
						    $get_first_opn_packing = "SELECT tbl_style_ops_master.operation_code FROM $brandix_bts.tbl_style_ops_master LEFT JOIN $brandix_bts.`tbl_orders_ops_ref` ON tbl_orders_ops_ref.operation_code = tbl_style_ops_master.operation_code WHERE style='$style' AND color = '$color' AND category='$application' ORDER BY tbl_orders_ops_ref.operation_code*1 LIMIT 1;";
						    $result_first_opn_packing=mysqli_query($link, $get_first_opn_packing) or exit("1=error while fetching pre_op_code_b4_carton_ready");
						    if (mysqli_num_rows($result_first_opn_packing) > 0)
						    {
						        $final_op_code=mysqli_fetch_array($result_first_opn_packing);
						        $packing_first_opn = $final_op_code['operation_code'];
						    }

						    // Get last opn in packing
						    $get_last_opn_packing = "SELECT tbl_style_ops_master.operation_code FROM $brandix_bts.tbl_style_ops_master LEFT JOIN $brandix_bts.`tbl_orders_ops_ref` ON tbl_orders_ops_ref.operation_code = tbl_style_ops_master.operation_code WHERE style='$style' AND color = '$color' AND category='$application' ORDER BY tbl_orders_ops_ref.operation_code*1 DESC LIMIT 1;";
					        $result_last_opn_sewing=mysqli_query($link, $get_last_opn_packing) or exit("error while fetching pre_op_code_b4_carton_ready");
					        if (mysqli_num_rows($result_last_opn_sewing) > 0)
					        {
					            $final_op_code=mysqli_fetch_array($result_last_opn_sewing);
					            $packing_last_opn = $final_op_code['operation_code'];
					        }

					        if ($packing_first_opn == $b_op_id) {
					        	$deduct_from_carton_ready = true;
					        	$dont_check = false;
					        	// echo "scanned = first<br>";
					        } else {
					        	$deduct_from_carton_ready = false;
					        	$dont_check = true;
					        	// echo "scanned != first<br>";
					        }
					        
					        if ($dont_check)
				            {
				            	$get_details_b4_carton_ready = "SELECT ops_sequence,operation_order FROM $brandix_bts.tbl_style_ops_master LEFT JOIN $brandix_bts.`tbl_orders_ops_ref` ON tbl_orders_ops_ref.operation_code = tbl_style_ops_master.operation_code WHERE style='$style' AND color = '$color' AND category='$application' AND tbl_style_ops_master.operation_code=$b_op_id";
					            $result_details_b4_carton_ready=mysqli_query($link, $get_details_b4_carton_ready) or exit("2=error while fetching pre_op_code_b4_carton_ready".$get_details_b4_carton_ready);
					            if (mysqli_num_rows($result_details_b4_carton_ready) > 0)
					            {
					                $op_order=mysqli_fetch_array($result_details_b4_carton_ready);
					                $ops_sequence = $op_order['ops_sequence'];
					                $operation_order = $op_order['operation_order'];

					                $get_pre_op_code_b4_carton_ready = "SELECT tbl_style_ops_master.operation_code FROM $brandix_bts.tbl_style_ops_master LEFT JOIN $brandix_bts.`tbl_orders_ops_ref` ON tbl_orders_ops_ref.operation_code = tbl_style_ops_master.operation_code  WHERE style='$style' AND color = '$color' AND ops_sequence = '$ops_sequence' AND category='$application' AND CAST(operation_order AS CHAR) < '$operation_order' AND tbl_style_ops_master.operation_code NOT IN (10,15) ORDER BY operation_order DESC LIMIT 1";
					                $result_pre_op_b4_carton_ready=mysqli_query($link, $get_pre_op_code_b4_carton_ready) or exit("3=error while fetching pre_op_code_b4_carton_ready".$get_pre_op_code_b4_carton_ready);
					                if (mysqli_num_rows($result_pre_op_b4_carton_ready) > 0)
					                {
					                    $final_op_code=mysqli_fetch_array($result_pre_op_b4_carton_ready);
					                    $before_opn = $final_op_code['operation_code'];
					                }
					            }
					            while ($get_carton_type=mysqli_fetch_array($count_result))
					            {
					            	$opn_status = $get_carton_type['opn_status'];
					            }
					            // echo "$before_opn == $opn_status <br>";
					            if ($opn_status != $before_opn)
					            {
					            	$go_here = 0;
					            }
					            else
					            {
					            	$go_here = 1;
					            }
				            }
				            else
				            {
				            	$go_here = 1;
				            }

							if ($go_here == 0)
							{
								echo "<script>sweetAlert('Previous Operation Not Done','','warning')</script>";
							}
							else
							{
								if ($b_op_id == 200)
								{
									$update_pac_stat_log = "UPDATE $bai_pro3.pac_stat_log SET status=NULL,scan_user='',scan_date='' WHERE pac_stat_id = '".$carton_id."'";
									mysqli_query($link, $update_pac_stat_log) or exit("Error while updating pac_stat_log");
								}
								$imploded_b_tid = implode(",",$b_tid);
								updateM3CartonScanReversal($b_op_id,$imploded_b_tid, $deduct_from_carton_ready);
								
								if ($packing_last_opn == $b_op_id) {
				                	$update_carton_status = ", carton_status='DONE'";
				                } else {
				                	$update_carton_status = "";
				                }
				                
								$update_pac_stat_atble="update $bai_pro3.pac_stat set opn_status=".$b_op_id." ".$update_carton_status." where id = '".$carton_id."'";
								$pac_stat_log_result = mysqli_query($link, $update_pac_stat_atble) or exit("Error while updating pac_stat_log");

								$get_carton_type=mysqli_fetch_array($carton_details);
								$carton_type = $get_carton_type['carton_mode'];
								if ($get_carton_type['carton_mode'] == 'P')
								{
									$carton_type = 'Partial';
								}
								else if($get_carton_type['carton_mode'] == 'F')
								{
									$carton_type = 'Full';
								}

								
								$get_details_to_insert_bcd_temp = "SELECT * FROM $bai_pro3.`pac_stat_log` WHERE pac_stat_id = ".$carton_id;
								// echo $get_details_to_insert_bcd_temp.'<br><br>';
								$bcd_detail_result = mysqli_query($link,$get_details_to_insert_bcd_temp);
								while($row=mysqli_fetch_array($bcd_detail_result))
								{
									$date = date('Y-m-d H:i:s');
									$bundle_tid = $row['tid'];
									$negative_reveived = $row['carton_act_qty']*-1;

									$bcd_temp_insert_query = "INSERT into $brandix_bts.bundle_creation_data_temp(date_time,style,schedule,color,size_id,size_title,bundle_number,original_qty,send_qty,recevied_qty,operation_id,bundle_status,remarks,scanned_date,scanned_user,input_job_no,input_job_no_random_ref)
									values ('$date', '".$row['style']."', '".$row['schedule']."', '".$row['color']."', '".$row['size_code']."', '".$row['size_tit']."', $bundle_tid, ".$row['carton_act_qty'].", ".$row['carton_act_qty'].", $negative_reveived, $b_op_id, 'Carton Reversal', '$carton_type', '$date', '$username', $carton_id, '$carton_id')";
									// echo $bcd_temp_insert_query.'<br>';
									mysqli_query($link,$bcd_temp_insert_query);
								}
								echo "<script>sweetAlert('Carton ".$carton_id." is Reversed','','success')</script>";
							}
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