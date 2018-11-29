<?php

if(isset($_GET['variable']))
{
	$variable = $_GET['variable'];
	if($variable != '')
	{
		getscheduledata($variable);
	}
}
function getscheduledata($variable)
{
	// include("dbconf1.php");
	// include(getFullURLLevel($_GET['r'],'common/config/config_ajax.php',5,'R'));
	include("../../../../../common/config/config_ajax.php");

	$query_get_schedule_data= "SELECT tm.operation_code,tm.operation_name FROM brandix_bts.tbl_style_ops_master tr LEFT JOIN brandix_bts.tbl_orders_ops_ref tm ON tm.id=tr.operation_name WHERE tr.operation_code NOT IN (10,200,15) GROUP BY tr.operation_code ORDER BY tm.operation_code";
	//echo $query_get_schedule_data;
	$result = $link->query($query_get_schedule_data);
	//$json = [];
   while($row = $result->fetch_assoc()){
        $json[$row['operation_code']] = $row['operation_name'];
   }
   echo json_encode($json);
	
}
if(isset($_GET['schedule']))
{
	$schedule = $_GET['schedule'];
	if($schedule != '')
	{
		getcolor($schedule);
	}
}
function getcolor($schedule)
{
	include("../../../../../common/config/config_ajax.php");
	$schedule_query = "SELECT order_col_des as color,order_style_no as style FROM $bai_pro3.packing_summary_input where order_del_no = $schedule GROUP BY order_col_des";
	//echo $schedule_query;
	$result1 = $link->query($schedule_query);
    while($row1 = $result1->fetch_assoc()){
        $json1[$row1['color']] = $row1['color'];
		$json2 = $row1['style'];
   }
   $json['drp'] = $json1;
   $json['style'] =$json2;
   echo json_encode($json);
}
if(isset($_GET['color']))
{
	$color = $_GET['color'];
	if($color != '')
	{
		getcuts($color);
	}
}
function getcuts($color)
{
	//var_dump($color);
	$color = explode(",",$color);
	include("../../../../../common/config/config_ajax.php");
	$query_dep_ops = "SELECT tr.operation_code,tr.operation_name,ts.component FROM $brandix_bts.tbl_style_ops_master ts LEFT JOIN $brandix_bts.tbl_orders_ops_ref tr ON tr.id=ts.operation_name WHERE style='$color[0]'  AND color = '$color[1]'  and barcode='Yes' ORDER BY ts.ops_sequence";

	//echo $query_dep_ops;
	$result_query_dep_ops = $link->query($query_dep_ops);
	// var_dump($result_query_dep_ops);
	while($row_result_query_dep_ops = $result_query_dep_ops->fetch_assoc()) 
	{
		$value_to_show = $row_result_query_dep_ops['operation_name'];
		// echo $value_to_show;
		$json1[$row_result_query_dep_ops['operation_code']] = $value_to_show;
	}
	echo json_encode($json1);
}
if(isset($_GET['job_number']))
{
	$job_number = $_GET['job_number'];
	if($job_number != '')
	{
		getjobdetails($job_number);
	}
}
function getjobdetails($job_number)
{
	$job_number = explode(",",$job_number);
	// var_dump($job_number);
	$emb_cut_check_flag = 0;
	if($job_number[2] == 1)
	{
		$job_number[4]=$job_number[1];
		include("../../../../../common/config/config_ajax.php");
		$column_to_search = $job_number[0];
		$column_in_where_condition = 'input_job_no_random_ref';
		$column_in_pack_summary = 'input_job_no_random';
		$bg = $job_number[2];
		$module_no = $job_number[3];
		if($job_number[2] == 0)
		{
			$column_in_where_condition = 'bundle_number';
			$column_to_search = $job_number[0];
			$column_in_pack_summary = 'tid';
			$fetching_job_number_from_bundle = "select input_job_no_random FROM $bai_pro3.packing_summary_input where tid='$job_number[0]'";
			//echo $fetching_job_number_from_bundle;
			$result_fetching_job_number_from_bundle = $link->query($fetching_job_number_from_bundle);
			while($row = $result_fetching_job_number_from_bundle->fetch_assoc()) 
			{
				$job_number[0] = $row['input_job_no_random'];
			}
			$map_col_query = "select order_style_no,order_del_no,order_col_des from $bai_pro3.packing_summary_input WHERE input_job_no_random = '$job_number[0]' order by tid";
			//	echo $map_col_query;
			$result_map_col_query = $link->query($map_col_query);
			if($result_map_col_query->num_rows > 0)
			{
				while($row = $result_map_col_query->fetch_assoc()) 
				{
					$maped_color = $row['order_col_des'];
				}
			}
		}
		//echo $maped_color; 
		//echo $fetching_job_number_from_bundle;
		$selecting_style_schedule_color_qry = "select order_style_no,order_del_no,order_col_des from $bai_pro3.packing_summary_input WHERE $column_in_pack_summary = '$column_to_search' ORDER BY tid";
		//echo $selecting_style_schedule_color_qry;
		$result_selecting_style_schedule_color_qry = $link->query($selecting_style_schedule_color_qry);
		if($result_selecting_style_schedule_color_qry->num_rows > 0)
		{
			while($row = $result_selecting_style_schedule_color_qry->fetch_assoc()) 
			{
				$job_number[1]= $row['order_style_no'];
				$job_number[2]= $row['order_del_no'];
				$job_number[3]= $row['order_col_des'];
				if($bg == 1)
				{
					$maped_color = $row['order_col_des'];
				}
				
			}
		}
		else
		{
			$result_array['status'] = 'Invalid Input. Please Check And Try Again !!!';
			echo json_encode($result_array);
			die();
		}
		$result_array['style'] = $job_number[1];
		$result_array['schedule'] = $job_number[2];
		$result_array['color_dis'] = $job_number[3];
		$ops_dep_flag = 0;
		//echo $maped_color;
		// $qry_cut_qty_check_qry = "SELECT act_cut_status FROM $bai_pro3.plandoc_stat_log WHERE doc_no IN (SELECT doc_no FROM $bai_pro3.packing_summary_input WHERE input_job_no_random = '$job_number[0]')";
		// $result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
		// while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
		// {
		// 	if($row['act_cut_status'] == '')
		// 	{
		// 		$result_array['status'] = 'Cut quantity reporting is not yet done for this docket related to this input job.';
		// 		echo json_encode($result_array);
		// 		die();
		// 	}
			
		// }
		
		$ops_dep_qry = "SELECT ops_dependency,operation_code FROM $brandix_bts.tbl_style_ops_master WHERE style='$job_number[1]' AND color =  '$maped_color' AND ops_dependency != 200 AND ops_dependency != 0";
		//echo $ops_dep_qry;
		$result_ops_dep_qry = $link->query($ops_dep_qry);
		while($row = $result_ops_dep_qry->fetch_assoc()) 
		{
			if($row['ops_dependency'])
			{
				if($row['ops_dependency'] == $job_number[4])
				{
					$ops_dep_code = $row['operation_code'];
					$schedule_count_query = "SELECT sum(recevied_qty)as recevied_qty FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = $column_to_search AND operation_id ='$ops_dep_code'";
					//echo $schedule_count_query;
					$schedule_count_query = $link->query($schedule_count_query);
					if($schedule_count_query->num_rows > 0)
					{
						while($row = $schedule_count_query->fetch_assoc()) 
						{
							$recevied_qty = $row['recevied_qty'];
						}
						if($recevied_qty == 0)
						{
							$ops_dep_flag =1;
							$result_array['status'] = 'The dependency operations for this operation are not yet done.';
							echo json_encode($result_array);
							die();
						}
					}
				}
			}
		}
		$flags=0;
		// $job_number_checking_query = "SELECT input_job_no_random FROM $bai_pro3.packing_summary_input where order_del_no = $job_number[2] and order_style_no='$job_number[1]'";
		//echo $job_number_checking_query;
		// $result_style_data = $link->query($job_number_checking_query);
		// while($row = $result_style_data->fetch_assoc()) 
		// {
			// if($job_number[0] == $row['input_job_no_random'])
			// {
				// $flags = 100;
			// }
		// }
		//echo $flags;
		// if($flags != 100)
		// {
			// $result_array['status'] = 'Invalid Input Job Number';
			// echo json_encode($result_array);
			// die();
		// }
		$ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' and operation_code='$job_number[4]'";
		//echo $ops_seq_check;
		$result_ops_seq_check = $link->query($ops_seq_check);
		if($result_ops_seq_check->num_rows > 0)
		{
			while($row = $result_ops_seq_check->fetch_assoc()) 
			{
				$ops_seq = $row['ops_sequence'];
				$seq_id = $row['id'];
				$ops_order = $row['operation_order'];
			}
		}
		else
		{
			$result_array['status'] = 'Invalid Operation for this input job number.Plese verify Operation Mapping.';
			echo json_encode($result_array);
			die();
		}

		$get_ops_query = "SELECT DISTINCT tm.operation_code FROM $brandix_bts.tbl_style_ops_master tm LEFT JOIN $brandix_bts.tbl_orders_ops_ref tr ON tr.id=tm.operation_name WHERE tm.style ='$job_number[1]' AND tm.color='$maped_color' AND tr.category = 'sewing' ORDER BY operation_order";
		// echo $get_ops_query;
		$ops_query_result=mysqli_query($link,$get_ops_query);
		while ($row = mysqli_fetch_array($ops_query_result))
		{
		  
		  $ops_get_code[] = $row['operation_code'];
		  $result_array['ops_get_code'][] = $row['operation_code'];

		}
		$pre_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' AND ops_sequence = $ops_seq AND CAST(operation_order AS CHAR) < '$ops_order' and operation_code NOT IN  (10,200) ORDER BY operation_order DESC LIMIT 1";
		// echo $pre_ops_check.'<br/>';
		$result_pre_ops_check = $link->query($pre_ops_check);
		if($result_pre_ops_check->num_rows > 0)
		{
			while($row = $result_pre_ops_check->fetch_assoc()) 
			{
				$pre_ops_code = $row['operation_code'];
			}
			// echo $pre_ops_code;
			$category=['cutting','Send PF','Receive PF'];
			$checking_qry = "SELECT category FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code = $pre_ops_code";
			// echo $checking_qry;
			$result_checking_qry = $link->query($checking_qry);
			while($row_cat = $result_checking_qry->fetch_assoc()) 
			{
				$category_act = $row_cat['category'];
			}
			if(in_array($category_act,$category))
			{
				$emb_cut_check_flag = 1;
			}
			//echo "<br/>".$emb_cut_check_flag.'HI';
			if($emb_cut_check_flag != 1)
			{
				$pre_ops_validation = "SELECT sum(recevied_qty)as recevied_qty FROM  $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = $column_to_search AND operation_id = $pre_ops_code";
				// echo $pre_ops_validation;
				$result_pre_ops_validation = $link->query($pre_ops_validation);
				while($row = $result_pre_ops_validation->fetch_assoc()) 
				{
					$recevied_qty_qty = $row['recevied_qty'];
				}
				if($recevied_qty_qty == 0)
				{
					$flags = 2;
				}
			}
			$schedule_count_query = "SELECT input_job_no_random_ref FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = '$job_number[0]' AND operation_id ='$job_number[4]'";
			// echo $schedule_count_query;
			$schedule_count_query = $link->query($schedule_count_query);
			if($schedule_count_query->num_rows > 0)
			{
				if($module_no==0){
					$schedule_query = "SELECT sum(send_qty)as send_qty,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,sum(original_qty) as carton_act_qty,sum(recevied_qty) as reported_qty,sum(rejected_qty) as rejected_qty,(SUM(send_qty)-(SUM(recevied_qty))) as balance_to_report,GROUP_CONCAT(DISTINCT(docket_number)  order by docket_number) as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks,assigned_module FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = $column_to_search AND operation_id = '$job_number[4]' GROUP BY size_code,order_col_des,assigned_module order by tid";
					
				}else{
					$schedule_query = "SELECT sum(send_qty)as send_qty,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,sum(original_qty) as carton_act_qty,sum(recevied_qty) as reported_qty,sum(rejected_qty) as rejected_qty,(SUM(send_qty)-(SUM(recevied_qty))) as balance_to_report,GROUP_CONCAT(DISTINCT(docket_number)  order by docket_number) as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks,assigned_module FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = $column_to_search AND operation_id = '$job_number[4]' and assigned_module = '$module_no' GROUP BY size_code,order_col_des,assigned_module order by tid";
				}

				$flag = 'bundle_creation_data';
			}
			else
			{
				$schedule_query = "SELECT *,sum(carton_act_qty) as balance_to_report,sum(carton_act_qty) as carton_act_qty, 0 as reported_qty, 0 as rejected_qty,GROUP_CONCAT(DISTINCT(doc_no)  order by doc_no) as doc_no,'packing_summary_input' as flag FROM $bai_pro3.packing_summary_input WHERE input_job_no_random = $job_number[0] GROUP BY size_code,order_col_des order by tid";
				$flag = 'packing_summary_input';
				// $result_array['status'] = 'Cut Quantity reporting Not Yet Done!!!';
				// $flags = 100;
			}
			// echo $schedule_query;
				
		}
		else
		{
			$schedule_count_query = "SELECT input_job_no_random_ref FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = '$job_number[0]' AND operation_id ='$job_number[4]'";
			//echo $schedule_count_query;
			$schedule_count_query = $link->query($schedule_count_query);
			if($schedule_count_query->num_rows > 0)
			{
				if($module_no==0){
					$schedule_query = "SELECT sum(send_qty)as send_qty,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,sum(original_qty) as carton_act_qty,sum(recevied_qty) as reported_qty,sum(rejected_qty) as rejected_qty,(SUM(send_qty)-(SUM(recevied_qty))) as balance_to_report,GROUP_CONCAT(DISTINCT(docket_number)  order by docket_number) as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks,assigned_module FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = $column_to_search AND operation_id = '$job_number[4]' GROUP BY size_code,order_col_des,assigned_module order by tid";
				}else{
					$schedule_query = "SELECT sum(send_qty)as send_qty,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,sum(original_qty) as carton_act_qty,sum(recevied_qty) as reported_qty,sum(rejected_qty) as rejected_qty,(SUM(send_qty)-(SUM(recevied_qty))) as balance_to_report,GROUP_CONCAT(DISTINCT(docket_number) order by docket_number) as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks,assigned_module FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = $column_to_search AND operation_id = '$job_number[4]' and assigned_module = '$module_no' GROUP BY size_code,order_col_des,assigned_module order by tid";
				}
				$flag = 'bundle_creation_data';
			}
			else
			{
				$schedule_query = "SELECT *,sum(carton_act_qty) as balance_to_report,sum(carton_act_qty) as carton_act_qty, 0 as reported_qty, 0 as rejected_qty,GROUP_CONCAT(DISTINCT(doc_no) order by doc_no) as doc_no,'packing_summary_input' as flag FROM $bai_pro3.packing_summary_input WHERE input_job_no_random = $job_number[0] GROUP BY size_code,order_col_des order by tid";
				$flag = 'packing_summary_input';
				// $result_array['status'] = 'Cut Quantity reporting Not Yet Done!!!';
				// $flags = 100;
			}
		}
		// if($flags != 100)
		// {
			if($flags == 2)
			{
				$result_array['status'] = 'Previous operation not yet done for this job.';
			}
			else
			{
				// echo $schedule_query;
				$result_style_data = $link->query($schedule_query);
				while($row = $result_style_data->fetch_assoc()) 
				{
					// var_dump($row);	
					$style = $job_number[1];
					$schedule =  $job_number[2];
					$color = $row['order_col_des'];
					$size = $row['old_size'];
					if($flag == 'packing_summary_input')
					{
						$job_number_reference = $row['type_of_sewing'];
						if($job_number_reference == 3)
						{
						//	var_dump($row);
							$selecting_sample_qtys = "SELECT input_qty FROM $bai_pro3.sp_sample_order_db WHERE order_tid = (SELECT order_tid FROM $bai_pro3.bai_orders_db WHERE order_style_no='$style' AND order_del_no='$schedule' AND order_col_des='$color' ) AND sizes_ref = '$size'";
							$result_selecting_sample_qtys = $link->query($selecting_sample_qtys);
							if($result_selecting_sample_qtys->num_rows > 0)
							{
								while($row_res = $result_selecting_sample_qtys->fetch_assoc()) 
								{
									//$result_array['sample_qtys'][] = $row_res['input_qty'];
									$row['carton_act_qty'] = $row_res['input_qty'];
								}
							}
							else
							{
								$result_array['status'] = 'Sample Quantities not updated!!!';
							}
						}
						$select_modudle_qry = "select input_module from $bai_pro3.plan_dashboard_input where input_job_no_random_ref = '$job_number[0]'";
						// echo $select_modudle_qry;
						$result_select_modudle_qry = $link->query($select_modudle_qry);
						if($result_select_modudle_qry->num_rows > 0)
						{
							while($row1 = $result_select_modudle_qry->fetch_assoc()) 
							{
								$row['assigned_module'] = $row1['input_module'];
								// $row['assigned_module'] = 10;
							}
						}
						else
						{
							$result_array['status'] = 'Please assign module to this input job';
						}
						foreach ($ops_get_code as $key => $value)
						{
                                $row['recevied_pre_qty'][$value][] = 0;
                               // $result_array['ops_get_code'][] = $value;
                                //array_unique( $result_array['ops_get_code']);
                                 // $result_array['ops_get_code'][] = $value;
						}
						
					}
					else
					{
						foreach ($ops_get_code as $key => $value)
						{

						  $color_pre = $row['order_col_des'] ;
						  $size_pre = $row['size_code'];
						  $module_pre = $row['assigned_module'];
						  $get_quantities = "SELECT sum(recevied_qty) as recevied_qty FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition ='$column_to_search' AND operation_id ='$value' and color = '$color_pre' and size_title = '$size_pre' and assigned_module = '$module_pre'";
						 // echo $get_quantities.'</br>';
							 $result_ops_quantities = $link->query($get_quantities);
							 while($row3 = $result_ops_quantities->fetch_assoc()) 
							 {
							 	 $row['recevied_pre_qty'][$value][] = $row3['recevied_qty'];
							 } 

                            // $result_array['recevied_pre_qty'][$value][] = $recevied_pre_qty;
                           //  $result_array['ops_get_code'][] = $value;
                            // array_unique( $result_array['ops_get_code']);
                             //echo json_encode($result_array);
						}

					}
					// echo 'hi'.$emb_cut_check_flag;
					if($emb_cut_check_flag == 1)
					{
						$sum_balance = 0;
						$doc_no = $row['doc_no'];
						$size = $row['old_size'];
						$min_val_doc_wise = array();
						$row_bundle_wise_qty =0;
						$bundle_tot_qty =0;
						$retreving_remaining_qty_qry = "SELECT sum(remaining_qty) as balance_to_report,doc_no FROM $bai_pro3.cps_log WHERE doc_no in ($doc_no) AND size_code='$size' AND operation_code = '$pre_ops_code' group by doc_no";
						// echo $retreving_remaining_qty_qry.'</br>';
						$result_retreving_remaining_qty_qry = $link->query($retreving_remaining_qty_qry);
						if($result_retreving_remaining_qty_qry->num_rows > 0)
						{
							while($row_remaining = $result_retreving_remaining_qty_qry->fetch_assoc()) 
							{
								$doc_no = $row_remaining['doc_no'];
								if($flag == 'packing_summary_input')
								{
									$doc_wise_bundle_qty = "select sum(carton_act_qty)as carton_act_qty from $bai_pro3.packing_summary_input where doc_no = '$doc_no' and old_size ='$size' and input_job_no_random = $job_number[0]";
								}
								else
								{
									$doc_wise_bundle_qty = "SELECT SUM(original_qty)-(SUM(recevied_qty)) AS carton_act_qty FROM `brandix_bts`.`bundle_creation_data` WHERE docket_number = '$doc_no' AND size_id ='$size' AND input_job_no_random_ref = '$job_number[0]' AND operation_id = '$job_number[4]'";
								}
								// echo $doc_wise_bundle_qty;
								$result_doc_wise_bundle_qty = $link->query($doc_wise_bundle_qty);
								while($row_bundle = $result_doc_wise_bundle_qty->fetch_assoc()) 
								{
									$row_bundle_wise_qty = $row_bundle['carton_act_qty'];
									$bundle_tot_qty += $row_bundle_wise_qty;
								}
								$sum_balance = $row_remaining['balance_to_report'];
								//echo $row_remaining['balance_to_report'] .'-'.$row_bundle_wise_qty.'</br>';
								$min_val_doc_wise[] = min($row_remaining['balance_to_report'],$row_bundle_wise_qty);
								
							}
							// var_dump($min_val_doc_wise);
							// if($sum_balance <= $row['balance_to_report'])
							// {
								// echo array_sum($min_val_doc_wise).'</br>';
								if($bundle_tot_qty >= array_sum($min_val_doc_wise))
								{
									$act_bal_to_report = array_sum($min_val_doc_wise);
								}
								else
								{
									$act_bal_to_report = $bundle_tot_qty;
								}
								
							//}
						}
						else
						{
							$act_bal_to_report = 0;
						}
						$row['balance_to_report'] = $act_bal_to_report;
						$result_array['emb_cut_check_flag'] = $pre_ops_code;
					}
					$result_array['table_data'][] = $row;
				}
				$result_array['flag'] = $flag;
			//}
			// $select_modudle_qry = "select input_module from $bai_pro3.plan_dashboard_input where input_job_no_random_ref = '$job_number[0]'";
			// $result_select_modudle_qry = $link->query($select_modudle_qry);
			
			// if(mysqli_num_rows($result_select_modudle_qry)==0)
			// {
			// 	$select_modudle_qry1 = "select ims_mod_no as input_module from $bai_pro3.ims_log where input_job_rand_no_ref = $job_number[0] limit 1";
			// 	$result_select_modudle_qry = $link->query($select_modudle_qry1);
			// }
			// if(mysqli_num_rows($result_select_modudle_qry)==0)
			// {
			// 	$select_modudle_qry2 = "select ims_mod_no as input_module from $bai_pro3.ims_log_backup where input_job_rand_no_ref = $job_number[0] limit 1";
			// 	$result_select_modudle_qry = $link->query($select_modudle_qry2);
			// }
			
			// while($row = $result_select_modudle_qry->fetch_assoc()) 
			// {
			// 	$result_array['module'] = $row['input_module'];
			// }

		}
		
	//	echo $schedule_query;
		echo json_encode($result_array);
	}
	else
	{
		//$job_number = explode(",",$job_number);
		$job_number[4]=$job_number[1];
		include("../../../../../common/config/config_ajax.php");
		$column_to_search = $job_number[0];
		$column_in_where_condition = 'input_job_no_random_ref';
		$column_in_pack_summary = 'input_job_no_random';
		if($job_number[2] == 0)
		{
			$column_in_where_condition = 'bundle_number';
			$column_to_search = $job_number[0];
			$column_in_pack_summary = 'tid';
			$fetching_job_number_from_bundle = "select input_job_no_random FROM $bai_pro3.packing_summary_input where tid='$job_number[0]'";
			// echo $fetching_job_number_from_bundle;
			$result_fetching_job_number_from_bundle = $link->query($fetching_job_number_from_bundle);
			while($row = $result_fetching_job_number_from_bundle->fetch_assoc()) 
			{
				$job_number[0] = $row['input_job_no_random'];
			}
			$map_col_query = "select order_style_no,order_del_no,order_col_des from $bai_pro3.packing_summary_input WHERE input_job_no_random = '$job_number[0]' order by tid";
			//echo $map_col_query;
			$result_map_col_query = $link->query($map_col_query);
			if($result_map_col_query->num_rows > 0)
			{
				while($row = $result_map_col_query->fetch_assoc()) 
				{
					$maped_color = $row['order_col_des'];
				}
			}
		}
		//echo $fetching_job_number_from_bundle;
		$selecting_style_schedule_color_qry = "select order_style_no,order_del_no,order_col_des from $bai_pro3.packing_summary_input WHERE $column_in_pack_summary = $column_to_search order by tid";
		//echo $selecting_style_schedule_color_qry;
		$result_selecting_style_schedule_color_qry = $link->query($selecting_style_schedule_color_qry);
		if($result_selecting_style_schedule_color_qry->num_rows > 0)
		{
			while($row = $result_selecting_style_schedule_color_qry->fetch_assoc()) 
			{
				$job_number[1]= $row['order_style_no'];
				$job_number[2]= $row['order_del_no'];
				$job_number[3]= $row['order_col_des'];
			}
		}
		else
		{
			$result_array['status'] = 'Invalid Input. Please Check And Try Again !!!';
			echo json_encode($result_array);
			die();
		}
		$result_array['style'] = $job_number[1];
		$result_array['schedule'] = $job_number[2];
		$result_array['color_dis'] = $maped_color;
		$ops_dep_flag = 0;
		// $qry_cut_qty_check_qry = "SELECT act_cut_status FROM $bai_pro3.plandoc_stat_log WHERE doc_no IN (SELECT doc_no FROM $bai_pro3.packing_summary_input WHERE input_job_no_random = '$job_number[0]')";
		// $result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
		// while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
		// {
		// 	if($row['act_cut_status'] == '')
		// 	{
		// 		$result_array['status'] = 'Cut quantity reporting is not yet done for this docket related to this input job.';
		// 		echo json_encode($result_array);
		// 		die();
		// 	}			
		// }
		
		$ops_dep_qry = "SELECT ops_dependency,operation_code FROM $brandix_bts.tbl_style_ops_master WHERE style='$job_number[1]' AND color =  '$job_number[3]' AND ops_dependency != 200 AND ops_dependency != 0";
		//echo $ops_dep_qry;
		$result_ops_dep_qry = $link->query($ops_dep_qry);
		while($row = $result_ops_dep_qry->fetch_assoc()) 
		{
			if($row['ops_dependency'])
			{
				if($row['ops_dependency'] == $job_number[4])
				{
					$ops_dep_code = $row['operation_code'];
					$schedule_count_query = "SELECT sum(recevied_qty)as recevied_qty FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = $column_to_search AND operation_id ='$ops_dep_code'";
					//echo $schedule_count_query;
					$schedule_count_query = $link->query($schedule_count_query);
					if($schedule_count_query->num_rows > 0)
					{
						while($row = $schedule_count_query->fetch_assoc()) 
						{
							$recevied_qty = $row['recevied_qty'];
						}
						if($recevied_qty == 0)
						{
							$ops_dep_flag =1;
							$result_array['status'] = 'The dependency operations for this operation are not yet done.';
							echo json_encode($result_array);
							die();
						}
					}
				}
			}
		}
		$flags=0;
		// $job_number_checking_query = "SELECT input_job_no_random FROM $bai_pro3.packing_summary_input where order_del_no = $job_number[2] and order_style_no='$job_number[1]'";
		//echo $job_number_checking_query;
		// $result_style_data = $link->query($job_number_checking_query);
		// while($row = $result_style_data->fetch_assoc()) 
		// {
			// if($job_number[0] == $row['input_job_no_random'])
			// {
				// $flags = 100;
			// }
		// }
		//echo $flags;
		// if($flags != 100)
		// {
			// $result_array['status'] = 'Invalid Input Job Number';
			// echo json_encode($result_array);
			// die();
		// }
		$ops_seq_check = "select id,ops_sequence,operation_code from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' and operation_code='$job_number[4]'";
		//echo $ops_seq_check;
		$result_ops_seq_check = $link->query($ops_seq_check);
		if($result_ops_seq_check->num_rows > 0)
		{
			while($row = $result_ops_seq_check->fetch_assoc()) 
			{
				$ops_seq = $row['ops_sequence'];
				$seq_id = $row['id'];
				$ops_order = $row['operation_code'];
			}
		}
		else
		{
			$result_array['status'] = 'Invalid Operation for this input job number.Plese verify Operation Mapping.';
			echo json_encode($result_array);
			die();
		}
		
		$pre_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' AND ops_sequence = $ops_seq AND CAST(operation_order AS CHAR) < '$ops_order' and operation_code NOT IN (10,200,15) ORDER BY operation_order DESC LIMIT 1";
		$result_pre_ops_check = $link->query($pre_ops_check);
		if($result_pre_ops_check->num_rows > 0)
		{
			while($row = $result_pre_ops_check->fetch_assoc()) 
			{
				$pre_ops_code = $row['operation_code'];
			}
			$category=['cutting','Send PF','Receive PF'];
			$checking_qry = "SELECT category FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code = $pre_ops_code";
			// echo $checking_qry;
			$result_checking_qry = $link->query($checking_qry);
			while($row_cat = $result_checking_qry->fetch_assoc()) 
			{
				$category_act = $row_cat['category'];
			}
			if(in_array($category_act,$category))
			{
				$emb_cut_check_flag = 1;
			}
			// echo $emb_cut_check_flag.'HI';
			if($emb_cut_check_flag != 1)
			{
				$pre_ops_validation = "SELECT sum(recevied_qty)as recevied_qty FROM  $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = $column_to_search AND operation_id = $pre_ops_code";
				//echo $pre_ops_validation;
				$result_pre_ops_validation = $link->query($pre_ops_validation);
				while($row = $result_pre_ops_validation->fetch_assoc()) 
				{
					$recevied_qty_qty = $row['recevied_qty'];
				}
				if($recevied_qty_qty == 0)
				{
					$flags = 2;
				}
			}
			$schedule_count_query = "SELECT input_job_no_random_ref FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = '$job_number[0]' AND operation_id ='$job_number[4]'";
			// echo $schedule_count_query;
			$schedule_count_query = $link->query($schedule_count_query);
			if($schedule_count_query->num_rows > 0)
			{
				$schedule_query = "SELECT `send_qty`,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,`original_qty` as carton_act_qty,`recevied_qty` as reported_qty,`rejected_qty` as rejected_qty,(send_qty-(recevied_qty)) as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks,assigned_module FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = $column_to_search AND operation_id = '$job_number[4]' order by tid";
				$flag = 'bundle_creation_data';
			}
			else
			{
				$schedule_query = "SELECT *,carton_act_qty as balance_to_report, 0 as reported_qty, 0 as rejected_qty, 'packing_summary_input' as flag FROM $bai_pro3.packing_summary_input WHERE input_job_no_random = $job_number[0] order by tid";
				$flag = 'packing_summary_input';
				// $result_array['status'] = 'Cut Quantity reporting Not Yet Done!!!';
				// $flags = 100;
			}
			//echo $schedule_query;
				
		}
		else
		{
			$schedule_count_query = "SELECT input_job_no_random_ref FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = '$job_number[0]' AND operation_id ='$job_number[4]'";
			// echo $schedule_count_query;
			$schedule_count_query = $link->query($schedule_count_query);
			if($schedule_count_query->num_rows > 0)
			{
				$schedule_query = "SELECT `send_qty`,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,`original_qty` as carton_act_qty,`recevied_qty` as reported_qty,`rejected_qty` as rejected_qty,(send_qty-(recevied_qty)) as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks,assigned_module FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = $column_to_search AND operation_id = '$job_number[4]' order by tid";
				$flags=3;
				$flag = 'bundle_creation_data';
			}
			else
			{
				$schedule_query = "SELECT *,carton_act_qty as balance_to_report, 0 as reported_qty, 0 as rejected_qty, 'packing_summary_input' as flag FROM $bai_pro3.packing_summary_input WHERE input_job_no_random = $job_number[0] order by tid";
				$flag = 'packing_summary_input';
				// $result_array['status'] = 'Cut Quantity reporting Not Yet Done!!!';
				// $flags = 100;
			}
		}
		// if($flags != 100)
		// {
			if($flags == 2)
			{
				$result_array['status'] = 'Previous operation not yet done for this job.';
			}
			else
			{
				$result_style_data = $link->query($schedule_query);
				while($row = $result_style_data->fetch_assoc()) 
				{
					
					$style = $job_number[1];
					$schedule =  $job_number[2];
					$color = $row['order_col_des'];
					$size = $row['old_size'];
					if($flag == 'packing_summary_input')
					{
						$job_number_reference = $row['type_of_sewing'];
						if($job_number_reference == 3)
						{
						//	var_dump($row);
							$selecting_sample_qtys = "SELECT input_qty FROM $bai_pro3.sp_sample_order_db WHERE order_tid = (SELECT order_tid FROM $bai_pro3.bai_orders_db WHERE order_style_no='$style' AND order_del_no='$schedule' AND order_col_des='$color' ) AND sizes_ref = '$size'";
							$result_selecting_sample_qtys = $link->query($selecting_sample_qtys);
							if($result_selecting_sample_qtys->num_rows > 0)
							{
								while($row_res = $result_selecting_sample_qtys->fetch_assoc()) 
								{
									//$result_array['sample_qtys'][] = $row_res['input_qty'];
									$row['carton_act_qty'] = $row_res['input_qty'];
								}
							}
							else
							{
								$result_array['status'] = 'Sample Quantities not updated!!!';
							}
						}
						$select_modudle_qry = "select input_module from $bai_pro3.plan_dashboard_input where input_job_no_random_ref = $job_number[0]";
						$result_select_modudle_qry = $link->query($select_modudle_qry);
						if($result_select_modudle_qry->num_rows > 0)
						{
							while($row1 = $result_select_modudle_qry->fetch_assoc()) 
							{
								$row['assigned_module'] = $row1['input_module'];
								// $row['assigned_module'] = 10;
							}
						}
						else
						{
							$result_array['status'] = 'Please assign module to this input job';
						}

					}
					if($emb_cut_check_flag == 1)
					{
						$sum_balance = 0;
						$doc_no = $row['doc_no'];
						$size = $row['old_size'];
						$min_val_doc_wise = array();
						$row_bundle_wise_qty =0;
						$bundle_tot_qty =0;
						$retreving_remaining_qty_qry = "SELECT sum(remaining_qty) as balance_to_report,doc_no FROM $bai_pro3.cps_log WHERE doc_no in ($doc_no) AND size_code='$size' AND operation_code = '$pre_ops_code' group by doc_no";
						// echo $retreving_remaining_qty_qry.'</br>';
						$result_retreving_remaining_qty_qry = $link->query($retreving_remaining_qty_qry);
						if($result_retreving_remaining_qty_qry->num_rows > 0)
						{
							while($row_remaining = $result_retreving_remaining_qty_qry->fetch_assoc()) 
							{
								$doc_no = $row_remaining['doc_no'];
								if($flag == 'packing_summary_input')
								{
									$doc_wise_bundle_qty = "select sum(carton_act_qty)as carton_act_qty from $bai_pro3.packing_summary_input where doc_no = '$doc_no' and old_size ='$size' and input_job_no_random = $job_number[0]";
								}
								else
								{
									$doc_wise_bundle_qty = "SELECT SUM(original_qty)-(SUM(recevied_qty)) AS carton_act_qty FROM `brandix_bts`.`bundle_creation_data` WHERE docket_number = '$doc_no' AND size_id ='$size' AND input_job_no_random_ref = '$job_number[0]' AND operation_id = '$job_number[4]'";
								}
								// echo $doc_wise_bundle_qty;
								$result_doc_wise_bundle_qty = $link->query($doc_wise_bundle_qty);
								while($row_bundle = $result_doc_wise_bundle_qty->fetch_assoc()) 
								{
									$row_bundle_wise_qty = $row_bundle['carton_act_qty'];
									$bundle_tot_qty += $row_bundle_wise_qty;
								}
								$sum_balance = $row_remaining['balance_to_report'];
								//echo $row_remaining['balance_to_report'] .'-'.$row_bundle_wise_qty.'</br>';
								$min_val_doc_wise[] = min($row_remaining['balance_to_report'],$row_bundle_wise_qty);
								
							}
							// var_dump($min_val_doc_wise);
							// if($sum_balance <= $row['balance_to_report'])
							// {
								// echo array_sum($min_val_doc_wise).'</br>';
								if($bundle_tot_qty >= array_sum($min_val_doc_wise))
								{
									$act_bal_to_report = array_sum($min_val_doc_wise);
								}
								else
								{
									$act_bal_to_report = $bundle_tot_qty;
								}
								
							//}
							
							$result_array['emb_cut_check_flag'] = $pre_ops_code;
						}
						else
						{
							$act_bal_to_report = 0;
						}
						$row['balance_to_report'] = $act_bal_to_report;
					}
					
					$result_array['table_data'][] = $row;
				}
				$result_array['flag'] = $flag;
		//	}
			// $select_modudle_qry = "select input_module from $bai_pro3.plan_dashboard_input where input_job_no_random_ref = $job_number[0]";
			// $result_select_modudle_qry = $link->query($select_modudle_qry);
			
			// if(mysqli_num_rows($result_select_modudle_qry)==0)
			// {
			// 	$select_modudle_qry1 = "select ims_mod_no as input_module from $bai_pro3.ims_log where input_job_rand_no_ref = $job_number[0] limit 1";
			// 	$result_select_modudle_qry = $link->query($select_modudle_qry1);
			// }
			// if(mysqli_num_rows($result_select_modudle_qry)==0)
			// {
			// 	$select_modudle_qry2 = "select ims_mod_no as input_module from $bai_pro3.ims_log_backup where input_job_rand_no_ref = $job_number[0] limit 1";
			// 	$result_select_modudle_qry = $link->query($select_modudle_qry2);
			// }
			
			// while($row = $result_select_modudle_qry->fetch_assoc()) 
			// {
			// 	$result_array['module'] = $row['input_module'];
			// }

		}
	
//	echo $schedule_query;
	echo json_encode($result_array);
	}
		
}
if(isset($_GET['job_rev_no']))
{
	$job_rev_no = $_GET['job_rev_no'];
	if($job_rev_no != '')
	{
		getjobreversaldetails($job_rev_no);
	}
}
function getjobreversaldetails($job_rev_no)
{
	include("../../../../../common/config/config_ajax.php");
	
	$operations_qty = "SELECT operation_name,operation_id FROM $brandix_bts.bundle_creation_data bc LEFT JOIN $brandix_bts.tbl_orders_ops_ref os ON os.operation_code=bc.operation_id WHERE input_job_no_random_ref='$job_rev_no' GROUP BY operation_id";
	$result_operations_qty = $link->query($operations_qty);
	if($result_operations_qty->num_rows > 0)
	{
		while($row_result_operations_qty = $result_operations_qty->fetch_assoc()) 
		{
			
			$json1[$row_result_operations_qty['operation_id']] = $row_result_operations_qty['operation_name'];
		}
	}
	else
	{
		$json1['status'] = "No Operations Done for this job";
	}
   echo json_encode($json1);
}
if(isset($_GET['data_rev']))
{
	$data_rev = $_GET['data_rev'];
	if($data_rev != '')
	{
		getreversalscanningdetails($data_rev);
	}
}
function getreversalscanningdetails($job_number)
{
	$job_number = explode(",",$job_number);
	//var_dump($job_number);
	// include("dbconf1.php");
	include("../../../../../common/config/config_ajax.php");

	//verifing next operation done are not
	$getting_style_qry ="select style,mapped_color as color from $brandix_bts.bundle_creation_data where input_job_no_random_ref = '$job_number[1]' group by style";
	//echo $getting_style_qry;
	$result_getting_style_qry = $link->query($getting_style_qry);
	while($row = $result_getting_style_qry->fetch_assoc()) 
	{
		$style = $row['style'];
		$color = $row['color'];
	}

	$ops_seq_check = "select id,ops_sequence,ops_dependency,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code='$job_number[0]'";
	$result_ops_seq_check = $link->query($ops_seq_check);
	while($row = $result_ops_seq_check->fetch_assoc()) 
	{
		$ops_seq = $row['ops_sequence'];
		$seq_id = $row['id'];
		$ops_order = $row['operation_order'];
		if($row['ops_dependency'] != null)
		{
			$ops_dep = $row['ops_dependency'];
			$result_array['ops_dep'] = $ops_dep;
		}
		else
		{
			$result_array['ops_dep'] = 0;
		}
	}

	$checking_flag = 0;
	$ops_dep_check = "select ops_dependency from  $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_sequence = $ops_seq and ops_dependency != 0 and ops_dependency != '' and operation_code = '$job_number[0]'";
	// echo $ops_dep_check;
	$result_ops_dep_check = $link->query($ops_dep_check);
	if($result_ops_dep_check->num_rows > 0)
	{
		$checking_flag = 1;
		while($row = $result_ops_dep_check->fetch_assoc()) 
		{
			$ops_dependency = $row['ops_dependency'];
		}
	}

	$post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_sequence = $ops_seq  AND CAST(operation_order AS CHAR) > '$ops_order' and operation_code not in (10,200,15) ORDER BY operation_order ASC LIMIT 1";
	$result_post_ops_check = $link->query($post_ops_check);
	// echo $post_ops_check; 
	if($result_post_ops_check->num_rows > 0)
	{
		while($row = $result_post_ops_check->fetch_assoc()) 
		{
			$post_ops_code = $row['operation_code'];
		}
	}
	else
	{
		$post_ops_code = 0;
	}
	$result_array['post_ops'][] = $post_ops_code;
	//echo $post_ops_code;
	if($post_ops_code != 0)
	{
		// $pre_ops_validation = "SELECT id,sum(recevied_qty) as recevied_qty,send_qty,size_title,bundle_number FROM  $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref =$job_number[1] AND operation_id = $post_ops_code group by bundle_number order by bundle_number";
		// // echo $pre_ops_validation;
		// $result_pre_ops_validation = $link->query($pre_ops_validation);
		// while($row = $result_pre_ops_validation->fetch_assoc()) 
		// {
		// 	$b_number =  $row['bundle_number'];
		// 	$sizes[] =  $row['size_title'];
		// 	$post_id = $row['id'];
		// 	$send_qty = $row['send_qty'];
		// 	$result_array['send_qty'][] = $send_qty;

		// }
		$pre_ops_validation = "SELECT id,sum(recevied_qty) as recevied_qty,send_qty,size_title,bundle_number,color,assigned_module FROM  $brandix_bts.bundle_creation_data_temp WHERE input_job_no_random_ref ='$job_number[1]' AND operation_id = $job_number[0] GROUP BY size_title,color,assigned_module order by bundle_number";
		//echo $pre_ops_validation;
		$result_pre_ops_validation = $link->query($pre_ops_validation);
		while($row = $result_pre_ops_validation->fetch_assoc()) 
		{
			$b_number =  $row['bundle_number'];
			$sizes[] =  $row['size_title'];
			$size_code = $row['size_title'];
			$color = $row['color'];
			$module = $row['assigned_module'];
			$post_ops_qry_to_find_rec_qty = "select (SUM(recevied_qty)) AS recevied_qty,size_title from  $brandix_bts.bundle_creation_data_temp WHERE input_job_no_random_ref ='$job_number[1]' AND operation_id = $post_ops_code and remarks='$job_number[2]' and size_title='$size_code' and color='$color' and assigned_module = '$module' GROUP BY size_title,color,assigned_module order by bundle_number";
			// echo $post_ops_qry_to_find_rec_qty;
			$result_post_ops_qry_to_find_rec_qty = $link->query($post_ops_qry_to_find_rec_qty);
			if($result_post_ops_qry_to_find_rec_qty->num_rows > 0)
			{
				while($row = $result_post_ops_qry_to_find_rec_qty->fetch_assoc()) 
				{	
					$result_array['rec_qtys'][] = $row['recevied_qty'];
				}
			}
			else
			{
				$result_array['rec_qtys'][] = 0;
			}
		}
	}
	else
	{
		$pre_ops_validation = "SELECT id,sum(recevied_qty) as recevied_qty,send_qty,size_title,bundle_number,color,assigned_module FROM  $brandix_bts.bundle_creation_data_temp WHERE input_job_no_random_ref =$job_number[1] AND operation_id = $job_number[0] GROUP BY size_title,color,assigned_module order by bundle_number";
		// echo $pre_ops_validation;
		$result_pre_ops_validation = $link->query($pre_ops_validation);
		while($row = $result_pre_ops_validation->fetch_assoc()) 
		{
			$b_number =  $row['bundle_number'];
			$size_code = $row['size_title'];
			$color = $row['color'];
			$assigned_module = $row['assigned_module'];
			if($checking_flag == 1)
			{
				$post_ops_qry_to_find_rec_qty = "select (SUM(recevied_qty)) AS recevied_qty,size_title from  $brandix_bts.bundle_creation_data_temp WHERE input_job_no_random_ref ='$job_number[1]' AND operation_id = $ops_dependency and remarks='$job_number[2]' and size_title='$size_code' and color='$color' and assigned_module = '$assigned_module' GROUP BY size_title,color,assigned_module order by bundle_number";
				// echo $post_ops_qry_to_find_rec_qty;
				$result_post_ops_qry_to_find_rec_qty = $link->query($post_ops_qry_to_find_rec_qty);
				if($result_post_ops_qry_to_find_rec_qty->num_rows > 0)
				{
					while($row = $result_post_ops_qry_to_find_rec_qty->fetch_assoc()) 
					{	
						$result_array['rec_qtys'][] = $row['recevied_qty'];
					}
				}
				else
				{
					$result_array['rec_qtys'][] = 0;
				}
			}
		}
		
	}

	$job_details_qry = "SELECT id,style,`color` AS order_col_des,`size_title` AS size_code,`bundle_number` AS tid,`original_qty` AS carton_act_qty,SUM(`recevied_qty`) AS reported_qty,SUM(rejected_qty) AS rejected_qty,(SUM(send_qty)-SUM(recevied_qty)) AS balance_to_report,`docket_number` AS doc_no, `cut_number` AS acutno, `input_job_no`,`input_job_no_random_ref` AS input_job_no_random, 'bundle_creation_data' AS flag,operation_id,remarks,size_id,assigned_module FROM $brandix_bts.bundle_creation_data_temp WHERE input_job_no_random_ref = '$job_number[1]' AND operation_id = '$job_number[0]' AND remarks = '$job_number[2]' GROUP BY size_title,color,assigned_module order by bundle_number";
	// echo $job_details_qry;
	$job_details_qry = $link->query($job_details_qry);
	//echo $job_details_qry->num_rows;
	if($job_details_qry->num_rows > 0)
	{
		while($row = $job_details_qry->fetch_assoc()) 
		{
			$size_code = $row['size_code'];
			$color = $row['order_col_des'];
			$module = $row['assigned_module'];
			$job_qty_qry = "select sum(original_qty) AS carton_act_qty,mapped_color FROM $brandix_bts.bundle_creation_data where input_job_no_random_ref = '$job_number[1]' AND operation_id = '$job_number[0]' AND size_title ='$size_code'  AND color='$color' and assigned_module ='$module'  order by bundle_number";
			// echo $job_qty_qry;
			$result_job_qty_qry = $link->query($job_qty_qry);
			while($row_result_job_qty_qry = $result_job_qty_qry->fetch_assoc()) 
			{
				$row['carton_act_qty'] = $row_result_job_qty_qry['carton_act_qty'];
				$row['mapped_color'] = $row_result_job_qty_qry['mapped_color'];
			}
			$result_array['table_data'][] = $row;
		}
	}
	else
	{
		$result_array['status'] = 'Invalid Operation';
	}
	echo json_encode($result_array);
}

if(isset($_GET['validating_remarks']))
{
	$validating_remarks = $_GET['validating_remarks'];
	if($validating_remarks != '')
	{
		validating_remarks_with_qty($validating_remarks);
	}
}
function validating_remarks_with_qty($validating_remarks)
{
	$validating_remarks = explode(",",$validating_remarks);
	if($validating_remarks[5] == 0)
	{
		$flag = 0;
		$total = 0;
		$check_flag = 0;
		$ops_dependency = array();
		$count = $validating_remarks[4];
		$html_response = "";
		// include("dbconf1.php");
		//include("remarks_array.php");
		include("../../../../../common/config/config_ajax.php");
		// $validating_remarks = explode(",",$validating_remarks);
		//echo $validating_remarks[5];
		//var_dump($validating_remarks);
		if($validating_remarks[5] == 0)
		{
			$fetching_job_number_from_bundle = "select input_job_no_random FROM $bai_pro3.packing_summary_input where tid='$validating_remarks[0]'";
			//echo $fetching_job_number_from_bundle;
			$result_fetching_job_number_from_bundle = $link->query($fetching_job_number_from_bundle);
			while($row = $result_fetching_job_number_from_bundle->fetch_assoc()) 
			{
				$validating_remarks[0] = $row['input_job_no_random'];
				
			}
		}
		$getting_style_qry ="select style,mapped_color as color from $brandix_bts.bundle_creation_data where input_job_no_random_ref = '$validating_remarks[0]' group by style";
		$result_getting_style_qry = $link->query($getting_style_qry);
		while($row = $result_getting_style_qry->fetch_assoc()) 
		{
			$style = $row['style'];
			$color = $row['color'];
		}
		$ops_dep_array_qry = "select ops_dependency from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_dependency != 0 and ops_dependency != 'NULL' group by ops_dependency";
		$result_ops_dep_array_qry = $link->query($ops_dep_array_qry);
		// echo $ops_dep_array_qry;
		while($row = $result_ops_dep_array_qry->fetch_assoc()) 
		{
			$ops_dependency[] = $row['ops_dependency'];
		}
		$qry_for_fetching_bal_to_report_qty_pre = "select * from $brandix_bts.bundle_creation_data_temp where bundle_number = $validating_remarks[1] and operation_id = $validating_remarks[2] and remarks='$validating_remarks[3]' order by bundle_number";
		// echo $qry_for_fetching_bal_to_report_qty_pre;
		$result_qry_for_fetching_bal_to_report_qty_pre = $link->query($qry_for_fetching_bal_to_report_qty_pre);
		if($result_qry_for_fetching_bal_to_report_qty_pre->num_rows > 0 && in_array($validating_remarks[2],$ops_dependency))
		{
				$check_flag = 1;
		}
		else
		{
			$check_flag = 0;
		}
		// echo $check_flag;
		$fetching_dependency_ops_qry = "select operation_code from  $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_dependency = $validating_remarks[2]";
		$result_fetching_dependency_ops_qry = $link->query($fetching_dependency_ops_qry);
		while($row = $result_fetching_dependency_ops_qry->fetch_assoc()) 
		{
			$dependency_operation[] = $row['operation_code'];
		}
		if(in_array($validating_remarks[2],$ops_dependency) && $check_flag == 0)
		{
			$result_qry_for_fetching_bal_to_report_qty = "select sum(recevied_qty)as rec_qty from $brandix_bts.bundle_creation_data_temp where bundle_number ='".$validating_remarks[1]."'  AND remarks = '".$validating_remarks[3]."'  and operation_id in (".implode(',',$dependency_operation).") group by operation_id";
			//echo $result_qry_for_fetching_bal_to_report_qty;
			$result_qry_for_fetching_bal_to_report_qty = $link->query($result_qry_for_fetching_bal_to_report_qty);
			if($result_qry_for_fetching_bal_to_report_qty->num_rows>0)
			{
				while($row = $result_qry_for_fetching_bal_to_report_qty->fetch_assoc()) 
				{
					//$id_variable = $count.$row['remarks'];
					$qty[] = $row['rec_qty'];
				}
				// var_dump()
			}
			else
			{
				$qty[] = 0;
			}
			if(sizeof($qty) != sizeof($dependency_operation))
			{
				$qty = 0;
			}
			else
			{
				$qty = min($qty);
			}
			$html_response .= "$qty".","."1";
		}
		
		else
		{
			$ops_seq_check = "select id,ops_sequence,ops_dependency,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code='$validating_remarks[2]'";
			$result_ops_seq_check = $link->query($ops_seq_check);
			while($row = $result_ops_seq_check->fetch_assoc()) 
			{
				$ops_seq = $row['ops_sequence'];
				$seq_id = $row['id'];
				$ops_order = $row['operation_order'];
				if($row['ops_dependency'] != null)
				{
					$ops_dep = $row['ops_dependency'];
					$result_array['ops_dep'] = $ops_dep;
					
				}
				else
				{
					$result_array['ops_dep'] = 0;
				}
			}
			$post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_sequence = $ops_seq AND operation_order < $ops_order order by operation_order ASC ";
			// echo $post_ops_check.'<br/>';
			$result_post_ops_check = $link->query($post_ops_check);
			if($result_post_ops_check->num_rows > 0)
			{
				while($row = $result_post_ops_check->fetch_assoc()) 
				{
					$post_ops_code = $row['operation_code'];
				}
			}
			else
			{
				$post_ops_code = 0;
			}
			
			//echo $check_flag;
			if($check_flag == 1)
			{
				$result_qry_for_fetching_bal_to_report_qty = "select min(recevied_qty)as rec_qty from $brandix_bts.bundle_creation_data_temp where bundle_number ='".$validating_remarks[1]."'  AND remarks = '".$validating_remarks[3]."' and  recevied_qty > 0 and operation_id in (".implode(',',$dependency_operation).") group by operation_id";
				//echo $result_qry_for_fetching_bal_to_report_qty;
				$result_qry_for_fetching_bal_to_report_qty = $link->query($result_qry_for_fetching_bal_to_report_qty);
				if($result_qry_for_fetching_bal_to_report_qty->num_rows>0)
				{
					while($row = $result_qry_for_fetching_bal_to_report_qty->fetch_assoc()) 
					{
						$qty[] = $row['rec_qty'];
					}
				}
				else
				{
					$qty[] = 0;
				}
				if(sizeof($dependency_operation) != sizeof($qty))
				{
					$qty = 0;
				}
				$send_qty = min($qty);
				
			}
			else
			{
				$fetching_send_qty_from_main = "select send_qty from $brandix_bts.bundle_creation_data where bundle_number = $validating_remarks[1] and operation_id = $validating_remarks[2]";
				$result_fetching_send_qty_from_main = $link->query($fetching_send_qty_from_main);
				while($row = $result_fetching_send_qty_from_main->fetch_assoc()) 
				{
					$send_qty = $row['send_qty'];
					
				}
			}
			
			//echo $fetching_send_qty_from_main;
			$qry_for_fetching_bal_to_report_qty_pre = "select * from $brandix_bts.bundle_creation_data_temp where bundle_number = $validating_remarks[1] and operation_id = $validating_remarks[2] and remarks='$validating_remarks[3]' order by bundle_number";
			//echo $qry_for_fetching_bal_to_report_qty_pre;
			$result_qry_for_fetching_bal_to_report_qty_pre = $link->query($qry_for_fetching_bal_to_report_qty_pre);
			if($result_qry_for_fetching_bal_to_report_qty_pre->num_rows > 0)
			{
				$qry_for_fetching_bal_to_report_qty_post = "select $send_qty-(SUM(recevied_qty)) as rec_qty,remarks from $brandix_bts.bundle_creation_data_temp where bundle_number = $validating_remarks[1] and operation_id = $validating_remarks[2] and remarks = '$validating_remarks[3]' order by bundle_number";
				//echo $qry_for_fetching_bal_to_report_qty_post;
				$result_qry_for_fetching_bal_to_report_qty_post = $link->query($qry_for_fetching_bal_to_report_qty_post);
				while($row = $result_qry_for_fetching_bal_to_report_qty_post->fetch_assoc()) 
				{
					$remarks_post = $row['remarks'];
					$rec_qty = $row['rec_qty'];
					if($post_ops_code == 0)
					{
						$qry_for_fetching_bal_to_report_qty_post_post = "select sum(recevied_qty) as rec_qty,remarks from $brandix_bts.bundle_creation_data_temp where bundle_number = $validating_remarks[1] and operation_id =  $validating_remarks[2] and remarks <> '$remarks_post' order by bundle_number";
					}
					else
					{
						$qry_for_fetching_bal_to_report_qty_post_post = "select sum(recevied_qty) as rec_qty,remarks from $brandix_bts.bundle_creation_data_temp where bundle_number = $validating_remarks[1] and operation_id =  $post_ops_code and remarks <> '$remarks_post' order by bundle_number";
					}
					
					//echo $qry_for_fetching_bal_to_report_qty_post_post;
					$result_qry_for_fetching_bal_to_report_qty_post_post = $link->query($qry_for_fetching_bal_to_report_qty_post_post);
					while($row = $result_qry_for_fetching_bal_to_report_qty_post_post->fetch_assoc()) 
					{
						// echo "rec_qty".$rec_qty;
						// echo "row rec_qty".$row['rec_qty'];
						if($check_flag != 1)
						{
							$act_rec_qty = $rec_qty - $row['rec_qty'];
							if($act_rec_qty < 0)
							{
								$act_rec_qty = 0;
							}
						}
						else
						{
							$act_rec_qty = $rec_qty;
						}
						if($act_rec_qty == '')
						{
							$act_rec_qty = 0;
						}
						$html_response .= "$act_rec_qty".","."1";
					}
				}
			}
			else
			{
				// echo $post_ops_code;
				if($post_ops_code != 0)
				{
					$qry_for_fetching_bal_to_report_qty = "select (sum(recevied_qty))as rec_qty,remarks from $brandix_bts.bundle_creation_data_temp where bundle_number = $validating_remarks[1] and operation_id = $post_ops_code and remarks = '$validating_remarks[3]' order by bundle_number";
				}
				else
				{
					$qry_for_fetching_bal_to_report_qty = "select (send_qty-(recevied_qty))AS rec_qty,remarks from $brandix_bts.bundle_creation_data where bundle_number = $validating_remarks[1] and operation_id = $validating_remarks[2]";
				}
				// echo $qry_for_fetching_bal_to_report_qty;
				$result_qry_for_fetching_bal_to_report_qty = $link->query($qry_for_fetching_bal_to_report_qty);
				while($row = $result_qry_for_fetching_bal_to_report_qty->fetch_assoc()) 
				{
					//$id_variable = $count.$row['remarks'];
					$qty = $row['rec_qty'];
					if($qty == '')
					{
						$qty = 0;
					}
					$html_response .= "$qty".","."1";
					
				}
			}
			
		}
		
		echo $html_response;
	}
	else
	{
		$flag = 0;
		$total = 0;
		$check_flag = 0;
		$ops_dependency = array();
		$count = $validating_remarks[4];
		$module = $validating_remarks[6];
		$html_response = "";
		// include("dbconf1.php");
		//include("remarks_array.php");
		include("../../../../../common/config/config_ajax.php");
		//echo $validating_remarks[5];
		//var_dump($validating_remarks);
		$query_to_fetch_individual_bundles = "select tid,order_col_des,old_size,size_code,carton_act_qty,acutno,input_job_no  FROM $bai_pro3.packing_summary_input where tid=$validating_remarks[1]";
		//echo $query_to_fetch_individual_bundles;
		$qry_nop_result = $link->query($query_to_fetch_individual_bundles);
		while($nop_qry_row = $qry_nop_result->fetch_assoc()) 
		{
			$color_act = $nop_qry_row['order_col_des'];
			$size_act = $nop_qry_row['size_code'];

		}

		if($validating_remarks[5] == 0)
		{
			$fetching_job_number_from_bundle = "select input_job_no_random FROM $bai_pro3.packing_summary_input where tid='$validating_remarks[0]'";
			//echo $fetching_job_number_from_bundle;
			$result_fetching_job_number_from_bundle = $link->query($fetching_job_number_from_bundle);
			while($row = $result_fetching_job_number_from_bundle->fetch_assoc()) 
			{
				$validating_remarks[0] = $row['input_job_no_random'];
				
			}
		}
		$getting_style_qry ="select style,mapped_color as color from $brandix_bts.bundle_creation_data where input_job_no_random_ref = '$validating_remarks[0]' group by style";
		$result_getting_style_qry = $link->query($getting_style_qry);
		while($row = $result_getting_style_qry->fetch_assoc()) 
		{
			$style = $row['style'];
			$color = $row['color'];
		}
		$ops_dep_array_qry = "select ops_dependency from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_dependency != 0 and ops_dependency != 'NULL' group by ops_dependency";
		//echo $ops_dep_array_qry;
		$result_ops_dep_array_qry = $link->query($ops_dep_array_qry);
		while($row = $result_ops_dep_array_qry->fetch_assoc()) 
		{
			$ops_dependency[] = $row['ops_dependency'];
		}
		//var_dump($ops_dependency);
		$qry_for_fetching_bal_to_report_qty_pre = "select * from $brandix_bts.bundle_creation_data_temp where  operation_id = $validating_remarks[2] and remarks='$validating_remarks[3]' and color='$color_act' and size_title='$size_act' AND input_job_no_random_ref = '$validating_remarks[0]' and assigned_module = '$module' order by bundle_number";
		//echo $qry_for_fetching_bal_to_report_qty_pre;
		$result_qry_for_fetching_bal_to_report_qty_pre = $link->query($qry_for_fetching_bal_to_report_qty_pre);
		if($result_qry_for_fetching_bal_to_report_qty_pre->num_rows > 0 && in_array($validating_remarks[2],$ops_dependency))
		{
				$check_flag = 1;
		}
		else
		{
			$check_flag = 0;
		}
		//echo $check_flag;
		$fetching_dependency_ops_qry = "select operation_code from  $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_dependency = $validating_remarks[2]";
		$result_fetching_dependency_ops_qry = $link->query($fetching_dependency_ops_qry);
		while($row = $result_fetching_dependency_ops_qry->fetch_assoc()) 
		{
			$dependency_operation[] = $row['operation_code'];
		}
		if(in_array($validating_remarks[2],$ops_dependency) && $check_flag == 0)
		{
			$result_qry_for_fetching_bal_to_report_qty = "select sum(recevied_qty)as rec_qty from $brandix_bts.bundle_creation_data_temp where remarks = '".$validating_remarks[3]."'  and operation_id in (".implode(',',$dependency_operation).") and color='$color_act' and size_title='$size_act' AND input_job_no_random_ref = '$validating_remarks[0]' and assigned_module = '$module' group by operation_id";
			//echo $result_qry_for_fetching_bal_to_report_qty;
			$result_qry_for_fetching_bal_to_report_qty = $link->query($result_qry_for_fetching_bal_to_report_qty);
			if($result_qry_for_fetching_bal_to_report_qty->num_rows>0)
			{
				while($row = $result_qry_for_fetching_bal_to_report_qty->fetch_assoc()) 
				{
					//$id_variable = $count.$row['remarks'];
					$qty[] = $row['rec_qty'];
				}
				// var_dump()
			}
			else
			{
				$qty[] = 0;
			}
			if(sizeof($qty) != sizeof($dependency_operation))
			{
				$qty = 0;
			}
			else
			{
				$qty = min($qty);
			}
			
			$html_response .= "$qty".","."1";
		}
		
		else
		{
			$ops_seq_check = "select id,ops_sequence,ops_dependency,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code='$validating_remarks[2]'";
			//echo $ops_seq_check;
			$result_ops_seq_check = $link->query($ops_seq_check);
			while($row = $result_ops_seq_check->fetch_assoc()) 
			{
				$ops_seq = $row['ops_sequence'];
				$seq_id = $row['id'];
				$ops_order = $row['operation_order'];
				if($row['ops_dependency'] != null)
				{
					$ops_dep = $row['ops_dependency'];
					$result_array['ops_dep'] = $ops_dep;
					
				}
				else
				{
					$result_array['ops_dep'] = 0;
				}
			}
			$post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_sequence = $ops_seq AND operation_order < $ops_order order by operation_order ASC ";
			//echo $post_ops_check;
			$result_post_ops_check = $link->query($post_ops_check);
			if($result_post_ops_check->num_rows > 0)
			{
				while($row = $result_post_ops_check->fetch_assoc()) 
				{
					$post_ops_code = $row['operation_code'];
				}
			}
			else
			{
				$post_ops_code = 0;
			}
			//echo $check_flag;
			if($check_flag == 1)
			{
				$result_qry_for_fetching_bal_to_report_qty = "select sum(recevied_qty)as rec_qty from $brandix_bts.bundle_creation_data_temp where remarks = '".$validating_remarks[3]."'  and operation_id in (".implode(',',$dependency_operation).") and color='$color_act' and size_title='$size_act' AND input_job_no_random_ref = '$validating_remarks[0]' and assigned_module = '$module' group by operation_id";
				//echo $result_qry_for_fetching_bal_to_report_qty;
				$result_qry_for_fetching_bal_to_report_qty = $link->query($result_qry_for_fetching_bal_to_report_qty);
				if($result_qry_for_fetching_bal_to_report_qty->num_rows>0)
				{
					while($row = $result_qry_for_fetching_bal_to_report_qty->fetch_assoc()) 
					{
						$qty[] = $row['rec_qty'];
					}
				}
				else
				{
					$qty[] = 0;
				}
				if(sizeof($dependency_operation) != sizeof($qty))
				{
					$qty = 0;
				}
				$send_qty = min($qty);
				
			}
			else
			{
				$fetching_send_qty_from_main = "select sum(send_qty)as send_qty from $brandix_bts.bundle_creation_data where  operation_id = $validating_remarks[2] and color='$color_act' and size_title='$size_act' AND input_job_no_random_ref = '$validating_remarks[0]' and assigned_module = '$module'";
				//echo $fetching_send_qty_from_main;
				$result_fetching_send_qty_from_main = $link->query($fetching_send_qty_from_main);
				while($row = $result_fetching_send_qty_from_main->fetch_assoc()) 
				{
					$send_qty = $row['send_qty'];
					
				}
			}
			
			// echo $fetching_send_qty_from_main;
			$qry_for_fetching_bal_to_report_qty_pre = "select * from $brandix_bts.bundle_creation_data_temp where  operation_id = $validating_remarks[2] and remarks='$validating_remarks[3]' and color='$color_act' and size_title='$size_act' AND input_job_no_random_ref = '$validating_remarks[0]' and assigned_module = '$module' order by bundle_number ";
			//echo $qry_for_fetching_bal_to_report_qty_pre;
			$result_qry_for_fetching_bal_to_report_qty_pre = $link->query($qry_for_fetching_bal_to_report_qty_pre);
			if($result_qry_for_fetching_bal_to_report_qty_pre->num_rows > 0)
			{
				$qry_for_fetching_bal_to_report_qty_post = "select $send_qty-(SUM(recevied_qty)) as rec_qty,remarks from $brandix_bts.bundle_creation_data_temp where  operation_id = $validating_remarks[2] and remarks = '$validating_remarks[3]' and color='$color_act' and size_title='$size_act' AND input_job_no_random_ref = '$validating_remarks[0]' and assigned_module = '$module' order by bundle_number";
				//echo $qry_for_fetching_bal_to_report_qty_post;
				$result_qry_for_fetching_bal_to_report_qty_post = $link->query($qry_for_fetching_bal_to_report_qty_post);
				while($row = $result_qry_for_fetching_bal_to_report_qty_post->fetch_assoc()) 
				{
					$remarks_post = $row['remarks'];
					$rec_qty = $row['rec_qty'];
					if($post_ops_code == 0)
					{
						$qry_for_fetching_bal_to_report_qty_post_post = "select sum(recevied_qty) as rec_qty,remarks from $brandix_bts.bundle_creation_data_temp where  operation_id =  $validating_remarks[2] and remarks <> '$remarks_post' and color='$color_act' and size_title='$size_act' AND input_job_no_random_ref = '$validating_remarks[0]' and assigned_module = '$module' order by bundle_number";
					}
					else
					{
						$qry_for_fetching_bal_to_report_qty_post_post = "select sum(recevied_qty) as rec_qty,remarks from $brandix_bts.bundle_creation_data_temp where  operation_id =  $post_ops_code and remarks <> '$remarks_post' and color='$color_act' and size_title='$size_act' AND input_job_no_random_ref = '$validating_remarks[0]' and assigned_module = '$module' order by bundle_number";
					}
					
					//echo $qry_for_fetching_bal_to_report_qty_post_post;
					$result_qry_for_fetching_bal_to_report_qty_post_post = $link->query($qry_for_fetching_bal_to_report_qty_post_post);
					while($row = $result_qry_for_fetching_bal_to_report_qty_post_post->fetch_assoc()) 
					{
						// echo "rec_qty".$rec_qty;
						// echo "row rec_qty".$row['rec_qty'];
						if($check_flag != 1)
						{
							$act_rec_qty = $rec_qty - $row['rec_qty'];
							if($act_rec_qty < 0)
							{
								$act_rec_qty = 0;
							}
						}
						else
						{
							$act_rec_qty = $rec_qty;
						}
						if($act_rec_qty == '')
						{
							$act_rec_qty = 0;
						}
						$html_response .= "$act_rec_qty".","."1";
					}
				}
			}
			else
			{
				if($post_ops_code != 0)
				{
					$qry_for_fetching_bal_to_report_qty = "select (sum(recevied_qty))as rec_qty,remarks from $brandix_bts.bundle_creation_data_temp where operation_id = $post_ops_code and remarks = '$validating_remarks[3]' and color='$color_act' and size_title='$size_act' AND input_job_no_random_ref = '$validating_remarks[0]' and assigned_module = '$module' order by bundle_number";
				}
				else
				{
					$qry_for_fetching_bal_to_report_qty = "select (SUM(send_qty)-(SUM(recevied_qty)))AS rec_qty,remarks from $brandix_bts.bundle_creation_data where  operation_id = $validating_remarks[2] and color='$color_act' and size_title='$size_act' AND input_job_no_random_ref = '$validating_remarks[0]' and assigned_module = '$module'";
				}
				//echo $qry_for_fetching_bal_to_report_qty;
				$result_qry_for_fetching_bal_to_report_qty = $link->query($qry_for_fetching_bal_to_report_qty);
				while($row = $result_qry_for_fetching_bal_to_report_qty->fetch_assoc()) 
				{
					//$id_variable = $count.$row['remarks'];
					$qty = $row['rec_qty'];
					if($qty == '')
					{
						$qty = 0;
					}
					$html_response .= "$qty".","."1";
					
				}
			}
			
		}
		
			echo $html_response;

	}
	
}

if(isset($_GET['doc_number']))
{
	$doc_number = $_GET['doc_number'];
	if($doc_number != '')
	{
		getCutDetails($doc_number);
	}
}

function getCutDetails($doc_number){
	$doc_number = explode(",",$doc_number);
	$doc_no = $doc_number[0];
	$op_code = $doc_number[1];
	$module = $doc_number[2];
	$style = $doc_number[3];
	$schedule = $doc_number[4];
	$color = $doc_number[5];
	if($doc_no)
	{
		include("../../../../../common/config/config_ajax.php");
		
		$ops_dep_qry = "SELECT ops_dependency,operation_code FROM $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color =  '$color' AND ops_dependency != 200 AND ops_dependency != 0";
		//echo $ops_dep_qry;
		$result_ops_dep_qry = $link->query($ops_dep_qry);
		while($row = $result_ops_dep_qry->fetch_assoc()) 
		{
			if($row['ops_dependency'])
			{
				if($row['ops_dependency'] == $op_code)
				{
					$ops_dep_code = $row['operation_code'];
					$schedule_count_query = "SELECT sum(recevied_qty)as recevied_qty FROM $brandix_bts.bundle_creation_data WHERE docket_number=$doc_no AND operation_id ='$ops_dep_code'";
					echo $schedule_count_query;
					$schedule_count_query = $link->query($schedule_count_query);
					if($schedule_count_query->num_rows > 0)
					{
						while($row = $schedule_count_query->fetch_assoc()) 
						{
							$recevied_qty = $row['recevied_qty'];
						}
						if($recevied_qty == 0)
						{
							$ops_dep_flag =1;
							$result_array['status'] = 'The dependency operations for this operation are not yet done.';
							echo json_encode($result_array);
							die();
						}
					}
				}
			}
		}
		$flags=0;		
		$ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code='$op_code'";
		$result_ops_seq_check = $link->query($ops_seq_check);
		if($result_ops_seq_check->num_rows > 0)
		{
			while($row = $result_ops_seq_check->fetch_assoc()) 
			{
				$ops_seq = $row['ops_sequence'];
				$seq_id = $row['id'];
				$ops_order = $row['operation_order'];
			}
		}
		else
		{
			$result_array['status'] = 'Invalid Operation for this cut number.Plese verify Operation Mapping.';
			echo json_encode($result_array);
			die();
		}
		
		$pre_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND ops_sequence = $ops_seq AND CAST(operation_order AS CHAR) < '$ops_order' and operation_code != 10 ORDER BY operation_order DESC LIMIT 1";
		//echo $pre_ops_check;
		$result_pre_ops_check = $link->query($pre_ops_check);
		if($result_pre_ops_check->num_rows > 0)
		{
			while($row = $result_pre_ops_check->fetch_assoc()) 
			{
				$pre_ops_code = $row['operation_code'];
			}
			$pre_ops_validation = "SELECT sum(recevied_qty)as recevied_qty FROM  $brandix_bts.bundle_creation_data WHERE docket_number=$doc_no AND operation_id = $pre_ops_code";
			//echo $pre_ops_validation;
			$result_pre_ops_validation = $link->query($pre_ops_validation);
			while($row = $result_pre_ops_validation->fetch_assoc()) 
			{
				$recevied_qty_qty = $row['recevied_qty'];
			}
			if($recevied_qty_qty == 0)
			{
				$flags = 2;
			}
			else
			{
				$schedule_query = "SELECT sum(send_qty)as send_qty,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,sum(original_qty) as carton_act_qty,sum(recevied_qty) as reported_qty,sum(rejected_qty) as rejected_qty,(SUM(send_qty)-(SUM(recevied_qty)+SUM(rejected_qty))) as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks,assigned_module FROM $brandix_bts.bundle_creation_data WHERE docket_number=$doc_no AND operation_id = '$op_code' GROUP BY size_code,order_col_des,assigned_module order by tid";			
			}
		}
		else
		{
			$schedule_count_query = "SELECT docket_number FROM $brandix_bts.bundle_creation_data WHERE docket_number = '$doc_no' AND operation_id ='$op_code'";
			$schedule_count_query = $link->query($schedule_count_query);
			if($schedule_count_query->num_rows > 0)
			{
				$schedule_query = "SELECT sum(send_qty)as send_qty,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,sum(original_qty) as carton_act_qty,sum(recevied_qty) as reported_qty,sum(rejected_qty) as rejected_qty,(SUM(send_qty)-(SUM(recevied_qty)+SUM(rejected_qty)))  as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks,assigned_module FROM $brandix_bts.bundle_creation_data WHERE docket_number=$doc_no AND operation_id = '$op_code' GROUP BY size_code,order_col_des,assigned_module order by tid";
				$flags=3;
			}	
		}
		if($flags == 2)
		{
			$result_array['status'] = 'Previous operation not yet done for this cut job.';
		}
		else
		{
			$result_style_data = $link->query($schedule_query);
			while($row = $result_style_data->fetch_assoc()) 
			{
				$result_array['table_data'][] = $row;
			}
		}
		echo json_encode($result_array);
	}

}


?>