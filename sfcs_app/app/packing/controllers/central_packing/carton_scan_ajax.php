<?php
	include('../../../../common/config/config_ajax.php');
	include("../../../../common/config/m3Updations.php");
	//API related data
	$plant_code = $global_facility_code;
	$company_num = $company_no;
	$host= $api_hostname;
	$port= $api_port_no;
	$current_date = date('Y-m-d h:i:s');
	// $b_op_id='200';
	// $b_op_id_query = "SELECT operation_code FROM brandix_bts.`tbl_orders_ops_ref` WHERE category='packing' AND default_operation='Yes';";
	// $sql_result=mysqli_query($link, $b_op_id_query) or exit("Error while fetching operation code");
	// while($sql_row=mysqli_fetch_array($sql_result))
	// {
	// 	$b_op_id=$sql_row['operation_code'];
	// }

	if (isset($_GET['carton_id']))
	{
		$emp_id = $_GET['emp_id'];
		$team_id = $_GET['team_id'];
		$carton_id = $_GET['carton_id'];
		$b_op_id = $_GET['operation_id'];
		$shift = $_GET['shift'];

		$count_query = "SELECT * FROM $bai_pro3.pac_stat WHERE id='".$carton_id."';";
		$count_result = mysqli_query($link,$count_query);
		if(mysqli_num_rows($count_result)>0)
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

			$application='packing';
            $get_first_opn_packing = "SELECT tbl_style_ops_master.operation_code FROM $brandix_bts.tbl_style_ops_master LEFT JOIN $brandix_bts.`tbl_orders_ops_ref` ON tbl_orders_ops_ref.operation_code = tbl_style_ops_master.operation_code WHERE style='$style' AND color = '$color' AND category='$application' ORDER BY tbl_orders_ops_ref.operation_code*1 LIMIT 1;";
            $result_first_opn_packing=mysqli_query($link, $get_first_opn_packing) or exit("1=error while fetching pre_op_code_b4_carton_ready");
            if (mysqli_num_rows($result_first_opn_packing) > 0)
            {
                $final_op_code=mysqli_fetch_array($result_first_opn_packing);
                $packing_first_opn = $final_op_code['operation_code'];
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
            // echo $go_here;
            // die();
			$final_details = "SELECT carton_no,order_style_no, order_del_no, GROUP_CONCAT(DISTINCT TRIM(order_col_des) SEPARATOR '<br>') AS colors, GROUP_CONCAT(DISTINCT size_tit) AS sizes, SUM(carton_act_qty) AS carton_qty FROM $bai_pro3.`packing_summary` WHERE pac_stat_id = '".$carton_id."'";
			$final_result = mysqli_query($link,$final_details);
			while($row=mysqli_fetch_array($final_result))
			{
				$carton_no=$row['carton_no'];
				$style=$row['order_style_no'];
				$schedule=$row['order_del_no'];
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
				if ($go_here == 1)
				{
					$imploded_b_tid = implode(",",$b_tid);
					$reply = updateM3CartonScan($b_op_id,$imploded_b_tid,$team_id, $deduct_from_carton_ready);

					if ($reply == 1)
					{
						// Carton Scan eligible
						if ($b_op_id == 200)
						{
							$sql="update $bai_pro3.pac_stat_log set status=\"DONE\",scan_date=\"".date("Y-m-d H:i:s")."\",scan_user='$username' where pac_stat_id = '".$carton_id."'";
							// echo $sql;
							$pac_stat_log_result = mysqli_query($link, $sql) or exit("Error while updating pac_stat_log");
						}

	                    $get_last_opn_packing = "SELECT tbl_style_ops_master.operation_code FROM $brandix_bts.tbl_style_ops_master LEFT JOIN $brandix_bts.`tbl_orders_ops_ref` ON tbl_orders_ops_ref.operation_code = tbl_style_ops_master.operation_code WHERE style='$style' AND color = '$color' AND category='$application' ORDER BY tbl_orders_ops_ref.operation_code*1 DESC LIMIT 1;";
	                    $result_last_opn_sewing=mysqli_query($link, $get_last_opn_packing) or exit("error while fetching pre_op_code_b4_carton_ready");
	                    if (mysqli_num_rows($result_last_opn_sewing) > 0)
	                    {
	                        $final_op_code=mysqli_fetch_array($result_last_opn_sewing);
	                        $packing_last_opn = $final_op_code['operation_code'];
	                    }

	                    if ($packing_last_opn == $b_op_id) {
	                    	$update_carton_status = ", carton_status='DONE'";
	                    } else {
	                    	$update_carton_status = "";
	                    }
	                    
						$update_pac_stat_atble="update $bai_pro3.pac_stat set opn_status=".$b_op_id." ".$update_carton_status." where id = '".$carton_id."'";
						$pac_stat_log_result = mysqli_query($link, $update_pac_stat_atble) or exit("Error while updating pac_stat_log");

						$get_carton_type=mysqli_fetch_array($count_result);
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
							$bundle_tid = $row['tid'];
							$bcd_temp_insert_query = "INSERT into $brandix_bts.bundle_creation_data_temp(date_time,style,schedule,color,size_id,size_title,bundle_number,original_qty,send_qty,recevied_qty,operation_id,bundle_status,assigned_module,remarks,scanned_date,scanned_user,input_job_no,input_job_no_random_ref) values ('".date('Y-m-d H:i:s')."', '".$row['style']."', '".$row['schedule']."', '".$row['color']."', '".$row['size_code']."', '".$row['size_tit']."', $bundle_tid, ".$row['carton_act_qty'].", ".$row['carton_act_qty'].", ".$row['carton_act_qty'].", $b_op_id, 'DONE', '$team_id', '$carton_type', '".date('Y-m-d H:i:s')."', '$username', $carton_id, '$carton_id')";
							// echo $bcd_temp_insert_query.'<br>';
							mysqli_query($link,$bcd_temp_insert_query);
						}

						if (!$pac_stat_log_result)
						{
							// Carton scan Failed
							$result_array['status'] = 3;
						}
						else
						{
							// carton scanned successfully
							$result_array['status'] = 2;
						}
					}
					else
					{
						// not eligible for scan carton
						$result_array['status'] = 4;
					}
				}
				else
				{
					// previous opn not done
					$result_array['status'] = 5;
				}           
			}
			// 1 = carton already scanned || 2 = carton scanned successfully || 3 = carton scanned failed || 4 =  carton not eligible for scanning || 5 = previous opn not done
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