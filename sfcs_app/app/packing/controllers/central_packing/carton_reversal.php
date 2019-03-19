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
					$carton_query = "SELECT * FROM $bai_pro3.pac_stat WHERE id = $carton_id";
					$carton_details=mysqli_query($link, $carton_query) or exit("Error while getting Carton Details");
					
					if (mysqli_num_rows($carton_details) > 0)
					{
						$b_tid = array();
						$get_all_tid = "SELECT group_concat(tid) as tid,min(status) as status FROM $bai_pro3.`pac_stat_log` WHERE pac_stat_id = $carton_id";
						$tid_result = mysqli_query($link,$get_all_tid);
						while($row12=mysqli_fetch_array($tid_result))
						{
							$b_tid=explode(",",$row12['tid']);	
							$status = $row12['status'];		
						}

						$b_op_id_query = "SELECT operation_code,work_center_id,short_cut_code FROM $brandix_bts.`tbl_orders_ops_ref` WHERE category='packing' AND default_operation='Yes'";
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
							$update_pac_stat_log = "UPDATE $bai_pro3.pac_stat_log SET status=NULL,scan_user='',scan_date='' WHERE pac_stat_id = $carton_id";
							mysqli_query($link, $update_pac_stat_log) or exit("Error while updating pac_stat_log");
							$imploded_b_tid = implode(",",$b_tid);
							updateM3CartonScanReversal($b_op_id,$imploded_b_tid);
							
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