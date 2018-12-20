<?php
	include('../../../../common/config/config_ajax.php');
	include('../../../../common/config/rest_api_calls.php');
	include("../../../../common/config/m3Updations.php");
	error_reporting(0);
	//API related data
	$plant_code = $global_facility_code;
	$company_num = $company_no;
	$host= $api_hostname;
	$port= $api_port_no;
	$current_date = date('Y-m-d h:i:s');
	// $b_op_id='200';
	$b_op_id_query = "SELECT operation_code FROM brandix_bts.`tbl_orders_ops_ref` WHERE category='packing' AND default_operation='Yes';";
	$sql_result=mysqli_query($link, $b_op_id_query) or exit("Error while fetching operation code");
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$b_op_id=$sql_row['operation_code'];
	}

	if (isset($_GET['carton_id']))
	{
		$emp_id = $_GET['emp_id'];
		$team_id = $_GET['team_id'];
		$carton_id = $_GET['carton_id'];
		$count_query = "SELECT * FROM $bai_pro3.pac_stat WHERE id='".$carton_id."';";
		$count_result = mysqli_query($link,$count_query);
		if(mysqli_num_rows($count_result)>0)
		{
			while($sql_row=mysqli_fetch_array($count_result))
			{
				$doc_no_ref=$sql_row['doc_no_ref'];
				$status=$sql_row['status'];
			}

			$b_tid = array();
			$get_all_tid = "SELECT group_concat(tid) as tid,min(status) as status FROM bai_pro3.`pac_stat_log` WHERE pac_stat_id = '".$carton_id."'";
			$tid_result = mysqli_query($link,$get_all_tid);
			while($row12=mysqli_fetch_array($tid_result))
			{
				$b_tid=explode(",",$row12['tid']);	
				$status=$row12['status'];		
			}


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
				$sql="update $bai_pro3.pac_stat_log set status=\"DONE\",scan_date=\"".date("Y-m-d H:i:s")."\",scan_user='$username' where pac_stat_id = '".$carton_id."'";
				// echo $sql;
				$pac_stat_log_result = mysqli_query($link, $sql) or exit("Error while updating pac_stat_log");

				if (!$pac_stat_log_result)
				{
					$result_array['status'] = 3;
				}
				else
				{
					$result_array['status'] = 2;
					$imploded_b_tid = implode(",",$b_tid);
					updateM3CartonScan($b_op_id,$imploded_b_tid,$team_id);
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