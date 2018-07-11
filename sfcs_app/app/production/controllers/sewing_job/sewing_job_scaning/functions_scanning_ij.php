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

	$query_get_schedule_data= "SELECT operation_code,operation_name FROM $brandix_bts.tbl_orders_ops_ref where operation_code not in (10,15,200) group by operation_code order by operation_code";
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
	//var_dump($job_number);
		$job_number = explode(",",$job_number);
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
		}
		//echo $fetching_job_number_from_bundle;
		$selecting_style_schedule_color_qry = "select order_style_no,order_del_no,order_col_des from $bai_pro3.packing_summary_input WHERE $column_in_pack_summary = $column_to_search";
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
		$result_array['color_dis'] = $job_number[3];
		$ops_dep_flag = 0;
		$qry_cut_qty_check_qry = "SELECT act_cut_status FROM $bai_pro3.plandoc_stat_log WHERE doc_no IN (SELECT doc_no FROM $bai_pro3.packing_summary_input WHERE input_job_no_random = '$job_number[0]')";
		$result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
		while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
		// {
			// if($row['act_cut_status'] == '')
			// {
				// $result_array['status'] = 'Cut quantity reporting is not yet done for this docket related to this input job.';
				// echo json_encode($result_array);
				// die();
			// }
			
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
		$ops_seq_check = "select id,ops_sequence from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$job_number[3]' and operation_code='$job_number[4]'";
		//echo $ops_seq_check;
		$result_ops_seq_check = $link->query($ops_seq_check);
		if($result_ops_seq_check->num_rows > 0)
		{
			while($row = $result_ops_seq_check->fetch_assoc()) 
			{
				$ops_seq = $row['ops_sequence'];
				$seq_id = $row['id'];
			}
		}
		else
		{
			$result_array['status'] = 'Invalid Operation for this input job number.Plese verify Operation Mapping.';
			echo json_encode($result_array);
			die();
		}
		
		$pre_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$job_number[3]' and id < $seq_id and ops_sequence = $ops_seq";
		$result_pre_ops_check = $link->query($pre_ops_check);
		if($result_pre_ops_check->num_rows > 0)
		{
			while($row = $result_pre_ops_check->fetch_assoc()) 
			{
				$pre_ops_code = $row['operation_code'];
			}
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
			else
			{
				$schedule_query = "SELECT `color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,`original_qty` as carton_act_qty,`recevied_qty` as reported_qty,`rejected_qty` as rejected_qty,(send_qty-(recevied_qty+rejected_qty)) as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = $column_to_search AND operation_id = '$job_number[4]' order by tid";
				$flag = 'bundle_creation_data';
			}
			
		}
		else
		{
			$schedule_count_query = "SELECT input_job_no_random_ref FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = $job_number[0] AND operation_id ='$job_number[4]'";
			// echo $schedule_count_query;
			$schedule_count_query = $link->query($schedule_count_query);
			if($schedule_count_query->num_rows > 0)
			{
				$schedule_query = "SELECT `color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,`original_qty` as carton_act_qty,`recevied_qty` as reported_qty,`rejected_qty` as rejected_qty,(send_qty-(recevied_qty+rejected_qty)) as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = $column_to_search AND operation_id = '$job_number[4]' order by tid";
				$flags=3;
				$flag = 'bundle_creation_data';
			}
			else
			{
				$schedule_query = "SELECT *,carton_act_qty as balance_to_report, 0 as reported_qty, 0 as rejected_qty, 'packing_summary_input' as flag FROM $bai_pro3.packing_summary_input WHERE input_job_no_random = $job_number[0] order by tid";
				$flag = 'packing_summary_input';
			}
			//echo $schedule_query;
				
		}
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
				if($job_number_reference == 2)
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
			}
			
			$result_array['table_data'][] = $row;
		}
		$result_array['flag'] = $flag;
	}
	$select_modudle_qry = "select input_module from $bai_pro3.plan_dashboard_input where input_job_no_random_ref = $job_number[0]";
	$result_select_modudle_qry = $link->query($select_modudle_qry);
	
	if(mysqli_num_rows($result_select_modudle_qry)==0)
	{
		$select_modudle_qry1 = "select ims_mod_no as input_module from $bai_pro3.ims_log where input_job_rand_no_ref = $job_number[0] limit 1";
		$result_select_modudle_qry = $link->query($select_modudle_qry1);
	}
	else if(mysqli_num_rows($result_select_modudle_qry)==0)
	{	
		$select_modudle_qry2 = "select ims_mod_no as input_module from $bai_pro3.ims_log_backup where input_job_rand_no_ref = $job_number[0] limit 1";
		$result_select_modudle_qry = $link->query($select_modudle_qry2);
	}
	
	while($row = $result_select_modudle_qry->fetch_assoc()) 
	{
		$result_array['module'] = $row['input_module'];
	}
	echo json_encode($result_array);
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
	$ops_seq_check = "select id,ops_sequence,ops_dependency from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code='$job_number[0]'";
	$result_ops_seq_check = $link->query($ops_seq_check);
	while($row = $result_ops_seq_check->fetch_assoc()) 
	{
		$ops_seq = $row['ops_sequence'];
		$seq_id = $row['id'];
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
//	echo $ops_dep_check;
	$result_ops_dep_check = $link->query($ops_dep_check);
	if($result_ops_dep_check->num_rows > 0)
	{
		$checking_flag = 1;
		while($row = $result_ops_dep_check->fetch_assoc()) 
		{
			$ops_dependency = $row['ops_dependency'];
		}
		//if($recevied_qty_qty > 0)
		{
			// $result_array['status'] = 'Dependency Operation scanning Already done for this input job number';
			// echo json_encode($result_array);
			// die();
		}
	}
	$post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_sequence = $ops_seq and id > $seq_id order by id limit 1";
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
	//echo $post_ops_code;
	if($post_ops_code != 0)
	{
		$pre_ops_validation = "SELECT id,recevied_qty as recevied_qty,send_qty,size_title,bundle_number FROM  $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref =$job_number[1] AND operation_id = $post_ops_code order by bundle_number";
		//echo $pre_ops_validation;
		$result_pre_ops_validation = $link->query($pre_ops_validation);
		while($row = $result_pre_ops_validation->fetch_assoc()) 
		{
			$b_number =  $row['bundle_number'];
			$sizes[] =  $row['size_title'];
			$post_id = $row['id'];
			$send_qty = $row['send_qty'];
			$result_array['post_ops'][] = $post_id;
			$result_array['send_qty'][] = $send_qty;
			if($checking_flag == 0)
			{
				$post_ops_qry_to_find_rec_qty = "select SUM(recevied_qty)AS recevied_qty,size_title from  $brandix_bts.bundle_creation_data_temp WHERE input_job_no_random_ref =$job_number[1] AND operation_id = $post_ops_code and remarks='$job_number[2]' and bundle_number='$b_number' group by bundle_number order by bundle_number";
			   //echo $post_ops_qry_to_find_rec_qty;
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
		// var_dump($recevied_qty_qty);
		//if($recevied_qty_qty > 0)
		{
			// $result_array['status'] = 'Next Operation Already done for this input job number';
			// echo json_encode($result_array);
			// die();
		}
		
	}
	else
	{
		$pre_ops_validation = "SELECT id,sum(recevied_qty) as recevied_qty,send_qty,size_title,bundle_number FROM  $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref =$job_number[1] AND operation_id = '$job_number[0]' order by bundle_number";
		//echo $pre_ops_validation;
		$result_pre_ops_validation = $link->query($pre_ops_validation);
		while($row = $result_pre_ops_validation->fetch_assoc()) 
		{
			$b_number =  $row['bundle_number'];
			if($checking_flag == 1)
			{
				$post_ops_qry_to_find_rec_qty = "select SUM(recevied_qty)AS recevied_qty,size_title from  $brandix_bts.bundle_creation_data_temp WHERE input_job_no_random_ref =$job_number[1] AND operation_id = $ops_dependency and remarks='$job_number[2]' and bundle_number='$b_number' group by bundle_number order by bundle_number";
				//echo $post_ops_qry_to_find_rec_qty;
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
	
	$job_details_qry = "SELECT id,style,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,`original_qty` as carton_act_qty,sum(`recevied_qty`) as reported_qty,`rejected_qty` as rejected_qty,(send_qty-recevied_qty) as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,operation_id,remarks from $brandix_bts.bundle_creation_data_temp where input_job_no_random_ref = '$job_number[1]' and operation_id = '$job_number[0]' and remarks = '$job_number[2]' group by bundle_number order by bundle_number";
	// echo $job_details_qry;
	$job_details_qry = $link->query($job_details_qry);
	//echo $job_details_qry->num_rows;
	if($job_details_qry->num_rows > 0)
	{
		while($row = $job_details_qry->fetch_assoc()) 
		{
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
	$flag = 0;
	$total = 0;
	$check_flag = 0;
	$ops_dependency = array();
	$count = $validating_remarks[4];
	$html_response = "";
	// include("dbconf1.php");
	//include("remarks_array.php");
	include("../../../../../common/config/config_ajax.php");
	$validating_remarks = explode(",",$validating_remarks);
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
	while($row = $result_ops_dep_array_qry->fetch_assoc()) 
	{
		$ops_dependency[] = $row['ops_dependency'];
	}
	$qry_for_fetching_bal_to_report_qty_pre = "select * from $brandix_bts.bundle_creation_data_temp where bundle_number = $validating_remarks[1] and operation_id = $validating_remarks[2] and remarks='$validating_remarks[3]' order by bundle_number";
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
	$fetching_dependency_ops_qry = "select operation_code from  $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_dependency = $validating_remarks[2]";
	$result_fetching_dependency_ops_qry = $link->query($fetching_dependency_ops_qry);
	while($row = $result_fetching_dependency_ops_qry->fetch_assoc()) 
	{
		$dependency_operation[] = $row['operation_code'];
	}
	if(in_array($validating_remarks[2],$ops_dependency) && $check_flag == 0)
	{
		$result_qry_for_fetching_bal_to_report_qty = "select sum(recevied_qty)as rec_qty from $brandix_bts.bundle_creation_data_temp where bundle_number ='".$validating_remarks[1]."'  AND remarks = '".$validating_remarks[3]."'  and operation_id in (".implode(',',$dependency_operation).")";
	//	echo $result_qry_for_fetching_bal_to_report_qty;
		$result_qry_for_fetching_bal_to_report_qty = $link->query($result_qry_for_fetching_bal_to_report_qty);
		while($row = $result_qry_for_fetching_bal_to_report_qty->fetch_assoc()) 
		{
			//$id_variable = $count.$row['remarks'];
			$qty[] = $row['rec_qty'];
		}
		// var_dump()
		if(sizeof($qty) == 0)
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
		$ops_seq_check = "select id,ops_sequence,ops_dependency from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code='$validating_remarks[2]'";
		$result_ops_seq_check = $link->query($ops_seq_check);
		while($row = $result_ops_seq_check->fetch_assoc()) 
		{
			$ops_seq = $row['ops_sequence'];
			$seq_id = $row['id'];
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
		$post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_sequence = $ops_seq and id < $seq_id order by id limit 1";
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
			$result_qry_for_fetching_bal_to_report_qty = "select min(recevied_qty)as rec_qty from $brandix_bts.bundle_creation_data_temp where bundle_number ='".$validating_remarks[1]."'  AND remarks = '".$validating_remarks[3]."' and  recevied_qty > 0 and operation_id in (".implode(',',$dependency_operation).")";
			//echo $result_qry_for_fetching_bal_to_report_qty;
			$result_qry_for_fetching_bal_to_report_qty = $link->query($result_qry_for_fetching_bal_to_report_qty);
			while($row = $result_qry_for_fetching_bal_to_report_qty->fetch_assoc()) 
			{
				$send_qty = $row['rec_qty'];
			}
			
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
			$qry_for_fetching_bal_to_report_qty_post = "select $send_qty-(SUM(recevied_qty)+SUM(rejected_qty)) as rec_qty,remarks from $brandix_bts.bundle_creation_data_temp where bundle_number = $validating_remarks[1] and operation_id = $validating_remarks[2] and remarks = '$validating_remarks[3]' order by bundle_number";
			//echo $qry_for_fetching_bal_to_report_qty_post;
			$result_qry_for_fetching_bal_to_report_qty_post = $link->query($qry_for_fetching_bal_to_report_qty_post);
			while($row = $result_qry_for_fetching_bal_to_report_qty_post->fetch_assoc()) 
			{
				$remarks_post = $row['remarks'];
				$rec_qty = $row['rec_qty'];
				if($post_ops_code == 0)
				{
					$qry_for_fetching_bal_to_report_qty_post_post = "select sum(recevied_qty)+sum(rejected_qty) as rec_qty,remarks from $brandix_bts.bundle_creation_data_temp where bundle_number = $validating_remarks[1] and operation_id =  $validating_remarks[2] and remarks <> '$remarks_post' order by bundle_number";
				}
				else
				{
					$qry_for_fetching_bal_to_report_qty_post_post = "select sum(recevied_qty)+sum(rejected_qty) as rec_qty,remarks from $brandix_bts.bundle_creation_data_temp where bundle_number = $validating_remarks[1] and operation_id =  $post_ops_code and remarks <> '$remarks_post' order by bundle_number";
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
				$qry_for_fetching_bal_to_report_qty = "select (sum(recevied_qty))as rec_qty,remarks from $brandix_bts.bundle_creation_data_temp where bundle_number = $validating_remarks[1] and operation_id = $post_ops_code and remarks = '$validating_remarks[3]' order by bundle_number";
			}
			else
			{
				$qry_for_fetching_bal_to_report_qty = "select (send_qty-(recevied_qty+rejected_qty))AS rec_qty,remarks from $brandix_bts.bundle_creation_data where bundle_number = $validating_remarks[1] and operation_id = $validating_remarks[2]";
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

?>