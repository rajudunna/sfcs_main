<?php
	include('../../../../common/config/config_ajax.php');
	include("../../../../common/config/m3Updations.php");
	// include("../../../../common/config/functions.php");

	//API related data
	$plant_code = $global_facility_code;
	$company_num = $company_no;
	$host= $api_hostname;
	$port= $api_port_no;
	$current_date = date('Y-m-d h:i:s');
	// $b_op_id='200';
	// $b_op_id_query = "SELECT operation_code FROM brandix_bts.`tbl_orders_ops_ref` WHERE category='packing' AND default_operation='Yes'";
	// $sql_result=mysqli_query($link, $b_op_id_query) or exit("Error while fetching operation code");
	// while($sql_row=mysqli_fetch_array($sql_result))
	// {
		// $b_op_id=$sql_row['operation_code'];
	// }

	if (isset($_GET['carton_id']))
	{
		$b_op_id = $_GET['operation_id'];
		$emp_id = $_GET['emp_id'];
		$team_id = $_GET['team_id'];
		$pack_team = $_GET['pack_team'];
		$pack_method = $_GET['pack_method'];
		$data_val=explode("$",$pack_method);
		$carton_id = $_GET['carton_id'];
		$count_query = "SELECT * FROM $bai_pro3.pac_stat WHERE id='".$carton_id."';";
		$count_result = mysqli_query($link,$count_query);
		if(mysqli_num_rows($count_result)>0)
		{
			$b_tid = array();
			$get_all_tid = "SELECT group_concat(tid) as tid,min(status) as status FROM bai_pro3.`pac_stat_log` WHERE pac_stat_id = ".$carton_id."";
			$tid_result = mysqli_query($link,$get_all_tid);
			while($row12=mysqli_fetch_array($tid_result))
			{
				$b_tid=explode(",",$row12['tid']);  
				$status=$row12['status'];       
			}


			$final_details = "SELECT carton_no,order_style_no, order_del_no, GROUP_CONCAT(DISTINCT TRIM(order_col_des) SEPARATOR '<br>') AS colors, GROUP_CONCAT(DISTINCT size_tit) AS sizes, SUM(carton_act_qty) AS carton_qty FROM $bai_pro3.`packing_summary` WHERE pac_stat_id = ".$carton_id."";
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
			$short_ship_status=0;
			$short_shipment_qry=[];
			$short_shipment_qry = mysqli_fetch_array(mysqli_query($link, "select * from bai_pro3.short_shipment_job_track where remove_type in('1','2') and style='".$style."' and schedule ='".$schedule."'"));
			$short_ship_status =0;
			$query_short_shipment = "select * from bai_pro3.short_shipment_job_track where remove_type in('1','2') and style='".$style."' and schedule ='".$schedule."'";
			$shortship_res = mysqli_query($link,$query_short_shipment);
			$count_short_ship = mysqli_num_rows($shortship_res);
			if($count_short_ship >0) {
				while($row_set=mysqli_fetch_array($shortship_res))
				{
					if($row_set['remove_type']==1) {
						$short_ship_status=1;
					}else{
						$short_ship_status=2;
					}
				}
			}
		
			if($short_ship_status==1){
				$result_array['status'] = 5;
			}
			else if($short_ship_status==2){
				$result_array['status'] = 6;
			}
			else if ($status == 'DONE')
			{
				$result_array['status'] = 1;
			}
			else
			{
				$imploded_b_tid = implode(",",$b_tid);
				$reply = updateM3CartonScan($b_op_id,$imploded_b_tid,$team_id);
			
				if ($reply == 1)
				{
					// Carton Scan eligible
					$sql="update $bai_pro3.pac_stat_log set status=\"DONE\",scan_date=\"".date("Y-m-d H:i:s")."\",scan_user='$username' where pac_stat_id = ".$carton_id."";
					// echo $sql;
					$pac_stat_log_result = mysqli_query($link, $sql) or exit("Error while updating pac_stat_log");

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
					
					$sql211="INSERT INTO $bai_pro3.`carton_packing_details` (`carton_id`, `operation_id`, `pack_code`, `pack_desc`, `pack_smv`, `pack_team`,scan_time) VALUES ('".$carton_id."', '".$b_op_id."', '".$data_val[0]."', '".$data_val[1]."', '".$data_val[2]."', '".$pack_team."','".date('Y-m-d H:i:s')."')";
					mysqli_query($link, $sql211) or exit("Insert while updating pac_stat");

					$get_details_to_insert_bcd_temp = "SELECT * FROM $bai_pro3.`pac_stat_log` WHERE pac_stat_id = ".$carton_id;
					// echo $get_details_to_insert_bcd_temp.'<br><br>';
					$bcd_detail_result = mysqli_query($link,$get_details_to_insert_bcd_temp);
					while($row=mysqli_fetch_array($bcd_detail_result))
					{
						$date = date('Y-m-d H:i:s');
						$bundle_tid = $row['tid'];

						$check_for_duplicates_bcd_temp = "SELECT sum(original_qty) as quantity from $brandix_bts.bundle_creation_data_temp where bundle_number=$bundle_tid and operation_id=$b_op_id";
						$result = mysqli_query($link,$check_for_duplicates_bcd_temp) or exit("While checking for duplicate entries");
						while($res = mysqli_fetch_array($result))
						{
							$sum = $res['quantity'];
						}
						if ($sum > 0) {
							# code...
						} else {
							$bcd_temp_insert_query = "INSERT into $brandix_bts.bundle_creation_data_temp(date_time,style,schedule,color,size_id,size_title,bundle_number,original_qty,send_qty,recevied_qty,operation_id,bundle_status,assigned_module,remarks,scanned_date,scanned_user,input_job_no,input_job_no_random_ref) values ('$date', '".$row['style']."', '".$row['schedule']."', '".$row['color']."', '".$row['size_code']."', '".$row['size_tit']."', $bundle_tid, ".$row['carton_act_qty'].", ".$row['carton_act_qty'].", ".$row['carton_act_qty'].", $b_op_id, 'DONE', '$team_id', '$carton_type', '$date', '$username', $carton_id, '$carton_id')";
							// echo $bcd_temp_insert_query.'<br>';
							mysqli_query($link,$bcd_temp_insert_query);
						}
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
			// 1 = carton already scanned || 2 = carton scanned successfully || 3 = carton scanned failed || 4 =  carton not eligible for scanning || 5= Temporary short shipment already generated || 6= Permanent short shipment already generated
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