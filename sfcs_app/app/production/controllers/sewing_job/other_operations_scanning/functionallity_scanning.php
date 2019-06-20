<?php

if(isset($_GET['reversal']))
{
	$data = $_GET['reversal'];
	if($data != '')
	{
		getreversal($data);
	}
}

function getreversal($data)
{
	$main_data = explode(",",$data);
	$doc_no = $main_data[0];
	$op_code = $main_data[1];
	$shift = $main_data[2];
 
    include("../../../../../common/config/config_ajax.php");
	$operations_qty = "SELECT operation_name,operation_id FROM $brandix_bts.bundle_creation_data bc LEFT JOIN $brandix_bts.tbl_orders_ops_ref os ON os.operation_code=bc.operation_id WHERE docket_number = '$doc_no' AND os.display_operations='yes' GROUP BY operation_id";
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
		$result_array['status'] = "No Operations Done for this job";
	}

	$get_docket_details = "SELECT order_style_no,order_del_no,order_col_des FROM $bai_pro3.`bai_orders_db_confirm` bdc LEFT JOIN $bai_pro3.plandoc_stat_log psl ON  psl.order_tid = bdc.order_tid WHERE psl.doc_no=$doc_no";
	$result_selecting_style_schedule_color_qry = $link->query($get_docket_details);
	if($result_selecting_style_schedule_color_qry->num_rows > 0)
	{
		while($row = $result_selecting_style_schedule_color_qry->fetch_assoc()) 
		{
			$style= $row['order_style_no'];
			$schedule= $row['order_del_no'];
			$color= $row['order_col_des'];
		}
	}
	else
	{
		$result_array['status'] = 'Invalid Input. Please Check And Try Again !!!';
		echo json_encode($result_array);
		die();
	}

	$result_array['style'] = $style;
	$result_array['schedule'] = $schedule;
	$result_array['color'] = $color;

    if($doc_no)
    {
    	$ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code=$op_code";
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
	  $ops_dep_qry = "SELECT ops_dependency,operation_code FROM $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$color' AND ops_dependency != 200 AND ops_dependency != 0";
	        //echo $ops_dep_qry;
	        $result_ops_dep_qry = $link->query($ops_dep_qry);
	        while($row = $result_ops_dep_qry->fetch_assoc()) 
	        {
	            if($row['ops_dependency'])
	            {
	                if($row['ops_dependency'] == $op_code)
	                {
	                    $ops_dep_code = $row['operation_code'];
	                    $schedule_count_query = "SELECT sum(recevied_qty)as recevied_qty FROM $brandix_bts.bundle_creation_data WHERE docket_number=$doc_no AND operation_id =$ops_dep_code";
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
        $post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_sequence = '$ops_seq'  AND CAST(operation_order AS CHAR) > '$ops_order' and operation_code not in (10,200,15) ORDER BY operation_order ASC LIMIT 1";
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
		$result_array['post_ops'][] = $post_ops_code;

		$get_sewing_operation = "SELECT tor.operation_code AS operation_code FROM $brandix_bts.tbl_style_ops_master tsm LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.id=tsm.operation_name  WHERE category='sewing' ORDER BY operation_order LIMIT 1";
		$result_sewing_operation = $link->query($get_sewing_operation);
        while($sewing_row = $result_sewing_operation->fetch_assoc()) 
        {
           $sewing_code = $sewing_row['operation_code'];
        }

        if($post_ops_code == $sewing_code)
        {
          $get_bundles = "select distinct(tid) as bundle_no from $bai_pro3.packing_summary_input where doc_no = $doc_no";
          //echo $get_bundles;
          $result_bundles = $link->query($get_bundles);
          while($bundle_row = $result_pre_ops_validation->fetch_assoc()) 
	      {
             $bundle_numbers[] = $bundle_row['bundle_no'];
	      }

	      $post_ops_validation = "SELECT sum(recevied_qty)as recevied_qty FROM $brandix_bts.bundle_creation_data WHERE bundle_number in (".implode(',',$bundle_numbers).") AND operation_id = $post_ops_code";
	        $result_pre_ops_validation = $link->query($post_ops_validation);
	        while($row = $result_pre_ops_validation->fetch_assoc()) 
	        {
	            $recevied_qty_qty = $row['recevied_qty'];
	        }
	        if($recevied_qty_qty > 0)
	        {
	            $flags = 1;
	        }
	        else
	        {
	        	$job_details_qry = "SELECT id,`size_title` AS size_code,size_id as old_size,`color` as order_col_des,`bundle_number` AS tid,`original_qty` AS carton_act_qty,SUM(`recevied_qty`) AS reported_qty,SUM(recevied_qty) AS balance_to_report,`docket_number` AS doc_no, `cut_number` AS acutno, `input_job_no`,`input_job_no_random_ref` AS input_job_no_random, 'bundle_creation_data' AS flag,operation_id,remarks,size_id FROM $brandix_bts.bundle_creation_data WHERE docket_number = '$doc_no' AND operation_id = $op_code GROUP BY size_title,color order by bundle_number";

	        }
        }
        else
        {
        	$post_ops_validation = "SELECT sum(recevied_qty)as recevied_qty FROM $brandix_bts.bundle_creation_data WHERE docket_number=$doc_no AND operation_id = $post_ops_code";
	        $result_pre_ops_validation = $link->query($post_ops_validation);
	        while($row = $result_pre_ops_validation->fetch_assoc()) 
	        {
	            $recevied_qty_qty = $row['recevied_qty'];
	        }
	        if($recevied_qty_qty > 0)
	        {
	            $flags = 2;
	        }
	        else
	        {

				$job_details_qry = "SELECT id,`size_title` AS size_code,size_id as old_size,`color` as order_col_des,`bundle_number` AS tid,`original_qty` AS carton_act_qty,SUM(`recevied_qty`) AS reported_qty,SUM(recevied_qty) AS balance_to_report,`docket_number` AS doc_no, `cut_number` AS acutno, `input_job_no`,`input_job_no_random_ref` AS input_job_no_random, 'bundle_creation_data' AS flag,operation_id,remarks,size_id FROM $brandix_bts.bundle_creation_data WHERE docket_number = '$doc_no' AND operation_id = $op_code GROUP BY size_title,color order by bundle_number";
			}
        }

            if($flags == 1)
	        {
                $result_array['status'] = 'Next Operation Reversal was not completely done for docket related bundles.';
	        }
			else if($flags == 2)
	        {
	            $result_array['status'] = 'Next Operation Reversal was not done for this cut job.';
	        }
	        else
	        {
	        	//echo $job_details_qry;
	            $result_style_data = $link->query($job_details_qry);
	            while($row = $result_style_data->fetch_assoc()) 
	            {
	                $result_array['table_data'][] = $row;
	            }
	        }
	        echo json_encode($result_array);   
    }
}

if(isset($_GET['get_details']))
{
	 $post_data = $_POST['bulk_data'];

	 if($post_data != '')
	 {
	 	updatereversal($post_data);
	 }

    
} 

 function updatereversal($post_data)
{
    
 	parse_str($post_data,$new_data);
    $b_style= $new_data['style'];
    $b_schedule=$new_data['schedule'];
	$b_colors=$new_data['colors'];
	$b_sizes = $new_data['sizes'];
	$b_size_code = $new_data['old_size'];
	$b_doc_no = $new_data['doc_no'];
	$b_shift = $new_data['shifts'];
	$b_tid = $new_data['tid'];
	$b_op_id = $new_data['operation_id'];
	$b_in_job_qty=$new_data['job_qty'];
	$b_rep_qty=$new_data['reporting_qty'];
	$rep_sum_qty = array_sum($b_rep_qty);
	$r_qtys=$new_data['qty_data'];
	$b_a_cut_no = $new_data['a_cut_no'];
	$b_old_rep_qty = $new_data['old_rep_qty'];
	$post_ops_code=$new_data['post_code'];
	$form = 'P';
	$ops_dep='';
	$qry_status='';
	$concurrent_flag = 0;
	if($b_op_id >=130 && $b_op_id < 300)
	{
		$form = 'G';
	}
	$type = $form;

	//Total reproted quantity for the docket
	$tot_report_qty_doc = $rep_sum_qty;
    
    include("../../../../../common/config/config_ajax.php");
	$ops_seq_check = "select id,ops_sequence,ops_dependency,operation_order from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$b_colors' and operation_code='$b_op_id'";
	$result_ops_seq_check = $link->query($ops_seq_check);
	while($row = $result_ops_seq_check->fetch_assoc()) 
	{
		$ops_seq = $row['ops_sequence'];
		$seq_id = $row['id'];
		$ops_dependency = $row['ops_dependency'];
		$ops_order = $row['operation_order'];
	}
	$post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$b_colors' AND ops_sequence = $ops_seq AND CAST(operation_order AS CHAR) < '$ops_order' and operation_code NOT IN  (10,200) ORDER BY operation_order DESC LIMIT 1";
	$result_post_ops_check = $link->query($post_ops_check);
	if($result_post_ops_check->num_rows > 0)
	{
	   while($row = $result_post_ops_check->fetch_assoc()) 
	   {
		 $post_ops_code = $row['operation_code'];
	   }
	}

	 $pre_operation_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$b_colors' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) < '$ops_order' and operation_code NOT IN  (10,200) ORDER BY operation_order DESC LIMIT 1";
        $result_pre_operation_check = $link->query($pre_operation_check);
        if($result_pre_operation_check->num_rows > 0)
        {
            while($row23 = $result_pre_operation_check->fetch_assoc()) 
            {
                $pre_ops_code = $row23['operation_code'];
            }
        }   

        // $dep_ops_check = "select ops_dependency from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$b_colors' AND operation_code = '$pre_ops_code'";
        // //echo $dep_ops_check;
        // $result_dep_ops_check = $link->query($dep_ops_check);
        // if($result_dep_ops_check->num_rows > 0)
        // {
        //     while($row22 = $result_dep_ops_check->fetch_assoc()) 
        //     {
        //         $next_operation = $row22['ops_dependency'];
        //     }
        // }
        // else
        // {
        //     $next_operation = '';
        // }

        // if($next_operation > 0)
        // {
        //    if($next_operation == $b_op_id)
        //    {
        //        $flag = 'parallel_scanning';

	       //     $get_ops_dep = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$b_colors' and ops_dependency =$b_op_id";
	       //     $result_ops_dep = $link->query($get_ops_dep);
	       //     while($row_dep = $result_ops_dep->fetch_assoc()) 
	       //     {
	       //        $operations[] = $row_dep['operation_code'];
	       //     }
	       //     $emb_operations = implode(',',$operations);
        //    }
           
        // }

   
 
	   foreach($b_sizes as $key => $value)
	   {
	      
		  
		  $act_reciving_qty = $b_rep_qty[$key];

	      $select_send_qty = "select (SUM(recevied_qty)) AS recevied_qty from  $brandix_bts.bundle_creation_data WHERE docket_number = '". $b_doc_no[$key]."' and size_title ='". $b_sizes[$key]."' and operation_id = $b_op_id";
	      // echo $select_send_qty;
	      // echo $act_reciving_qty;
			$result_select_send_qty = $link->query($select_send_qty);
			while($row = $result_select_send_qty->fetch_assoc()) 
			{
				$pre_recieved_qty = $row['recevied_qty'];
				$total_rec_qty = $pre_recieved_qty - $act_reciving_qty;
			}
			
		     if($total_rec_qty < 0)
			{
				
				$concurrent_flag = 1;
			}
	   }		
			
		
		if($concurrent_flag == 0)
		{
			foreach($b_sizes as $key => $value)
			{
				   $reversalval = $b_rep_qty[$key];
				   $fetching_id_qry = "select id,recevied_qty from $brandix_bts.bundle_creation_data where docket_number = '". $b_doc_no[$key]."' and size_title ='". $b_sizes[$key]."' and operation_id = $b_op_id";
			        $result_fetching_id_qry = $link->query($fetching_id_qry)  or exit('query error in updating1');
			        while($row = $result_fetching_id_qry->fetch_assoc()) 
			        {
			            $id = $row['id'];
			            $rec_qty = $row['recevied_qty'];
			        }
			        $act_rec_qty = $rec_qty - $reversalval;
			        $update_present_qry = "update $brandix_bts.bundle_creation_data  set recevied_qty = $act_rec_qty where id = $id";
			        $result_query = $link->query($update_present_qry) or exit('query error in updating2');
			        if($post_ops_code)
			        {
			            $query_post_dep = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$act_rec_qty."', `scanned_date`='". date('Y-m-d')."' where docket_number ='". $b_doc_no[$key]."' and size_title ='". $b_sizes[$key]."' and operation_id = $post_ops_code";
			            // echo $query_post_dep;
			            $result_query = $link->query($query_post_dep) or exit('query error in updating6');
			        }
			}
			if($ops_dependency != 0)
			{
				$dep_ops_array_qry_raw = "select operation_code from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$b_colors' and ops_dependency='$ops_dependency'";
				//echo $dep_ops_array_qry_raw;
				$result_dep_ops_array_qry_raw = $link->query($dep_ops_array_qry_raw) or exit('query error in updating 4');
				while($row = $result_dep_ops_array_qry_raw->fetch_assoc()) 
				{
					$dep_ops_codes[] = $row['operation_code'];	
				}
			}
			//var_dump($dep_ops_codes);
			if($dep_ops_codes != null)
			{
				foreach($b_sizes as $key => $value)
				{
					$pre_send_qty_qry = "select min(recevied_qty)as recieved_qty from $brandix_bts.bundle_creation_data where docket_number = '". $b_doc_no[$key]."' and size_title ='". $b_sizes[$key]."' and operation_id in (".implode(',',$dep_ops_codes).")";
					//echo $pre_send_qty_qry;
					$result_pre_send_qty = $link->query($pre_send_qty_qry) or exit('query error in updating 5');
					while($row = $result_pre_send_qty->fetch_assoc()) 
					{
						$pre_recieved_qty = $row['recieved_qty'];
					}
					$query_post_dep = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$pre_recieved_qty."', `scanned_date`='". date('Y-m-d')."' where docket_number = '". $b_doc_no[$key]."' nd size_title ='". $b_sizes[$key]."' and operation_id = ".$ops_dependency;
					// echo $query_post_dep;
					$result_query = $link->query($query_post_dep) or exit('query error in updating6');
				}
			}

			foreach($b_sizes as $key=>$value)
			{
				$reversalval = $b_rep_qty[$key];

				$cps_log_qry_pre = "UPDATE $bai_pro3.cps_log SET `remaining_qty`= remaining_qty-$reversalval WHERE doc_no = '". $b_doc_no[$key]."' AND operation_code = '$b_op_id' AND size_title='". $b_sizes[$key]."'"; 
                $cps_log_result_pre = $link->query($cps_log_qry_pre) or exit('CPS LOG query pre error');

				$retriving_data = "select * from $brandix_bts.bundle_creation_data where docket_number = '". $b_doc_no[$key]."' and size_title ='". $b_sizes[$key]."' and operation_id = $b_op_id";
				//echo $retriving_data;
				$result_retriving_data = $link->query($retriving_data) or exit('query error in updating 7');
				while($row = $result_retriving_data->fetch_assoc()) 
				{
					$b_style = $row['style'];
					$b_schedule = $row['schedule'];
					$b_op_id = $row['operation_id'];
					$b_job_no =  $row['input_job_no_random_ref'];
					$b_inp_job_ref = $row['input_job_no'];
					$size_id = $row['size_id'];
					$b_in_job_qty = $row['original_qty'];
					$b_a_cut_no = $row['cut_number'];
					$mapped_color = $row['mapped_color'];
					$color = $row['color'];
					$size_title = $row['size_title'];
					$bundle_no = $row['bundle_number'];
					$module = $row['assigned_module'];
					$remarks = $row['remarks'];
					$sfcs_smv = $row['sfcs_smv'];
				}
				$ops_name_qry = "select operation_name from $brandix_bts.tbl_orders_ops_ref where operation_code = $b_op_id";
				$result_ops_name_qry = $link->query($ops_name_qry) or exit('query error in updating 8');
				//var_dump($result_ops_name_qry);
				while($row_ops = $result_ops_name_qry->fetch_assoc()) 
				{
					//var_dump()
					$b_op_name = $row_ops['operation_name'];
				}
				//echo $b_op_name;
				$b_colors = $color;
				$b_tid = $bundle_no;
				// $b_sizes = $value;
				$b_doc_num = $b_doc_no[$key];
				
				if($reversalval > 0)
				{
					$r_qty_array = '-'.$reversalval;
						
					$bulk_insert_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`scanned_user`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`) VALUES";
					$bulk_insert_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors.'","'.$size_id.'","'. $size_title.'","'. $sfcs_smv.'","'.$b_tid.'","'.$b_in_job_qty.'","'.$b_in_job_qty.'","'.$r_qty_array.'","0","0","'. $b_op_id.'","'.$b_doc_num.'","'.date('Y-m-d').'","'.$b_a_cut_no.'","'.$b_inp_job_ref.'","'.$username.'","'.$b_job_no.'","'.$b_shift.'","'.$module.'","'.$remarks.'")';
					//echo $bulk_insert_temp;
					$bundle_creation_result_temp = $link->query($bulk_insert_temp) or exit('query error in updating 9');
					
				}

			}
        }
        foreach($b_sizes as $key=>$value)
		{
			$bubdle_no = $b_doc_no[$key];
			$reversalval = $b_rep_qty[$key];
			$op_code = $b_op_id;
            updateM3TransactionsReversal($bundle_no,$reversalval,$op_code);
		}

        if($concurrent_flag == 1)
		{
			$result_array['status'] = 'You are Reversing More than eligible quantity.';
			echo json_encode($result_array);
			die();
		}
		if($concurrent_flag == 0)
		{
			 $table_data = "<div class='container'><div class='row'><div id='no-more-tables'><table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Docket Number</th><th>Color</th><th>Size</th><th>Reversal Qty</th></tr></thead><tbody>";

			    for($i=0;$i<sizeof($b_sizes);$i++)
			    {
			        if($b_rep_qty[$i] > 0)
			        {
			            $size = strtoupper($b_sizes[$i]);
			            $table_data .= "<tr><td data-title='Bundle No'>$b_doc_no[$i]</td><td data-title='Color'>$b_colors</td><td data-title='Size'>$size</td><td data-title='Reported Qty'>$b_rep_qty[$i]</td></tr>";
			        }
			    }
			    $table_data .= "</tbody></table></div></div></div>";
			    echo $table_data;
		}
}
?>