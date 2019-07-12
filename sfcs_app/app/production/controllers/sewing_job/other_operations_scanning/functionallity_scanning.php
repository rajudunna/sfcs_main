<?php

if(isset($_GET['reversal']))
{
	$data = $_GET['reversal'];
	$type = $_GET['type'];

	if($data != '')
	{
		if ($type == 'Carton') {
			packingReversal($data);
		} else {
			getreversal($data);
		}
	}
}

function getreversal($data)
{
	$main_data = explode(",",$data);
	$doc_no = $main_data[0];
	$op_code = $main_data[1];
	$shift = $main_data[2];
 
    include("../../../../../common/config/config_ajax.php");

    $flag = '';
    //To check Clubbing
    $get_child_docs = "select doc_no from $bai_pro3.plandoc_stat_log where org_doc_no = $doc_no";
	$result_get_child_docs_check = $link->query($get_child_docs);
	if($result_get_child_docs_check->num_rows > 0)
	{
	     while($row_club = $result_get_child_docs_check->fetch_assoc()) 
	    {
	        $doc[] = $row_club['doc_no'];
	    }
	    $flag = 'clubbing';
	}
	else
	{
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

		$get_sewing_operation = "SELECT tor.operation_code AS operation_code FROM $brandix_bts.tbl_style_ops_master tsm LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.id=tsm.operation_name  WHERE category='sewing' and style ='$style' and color ='$color' ORDER BY operation_order LIMIT 1";
		$result_sewing_operation = $link->query($get_sewing_operation);
	    while($sewing_row = $result_sewing_operation->fetch_assoc()) 
	    {
	        $sewing_code = $sewing_row['operation_code'];
	    }

		if($flag == 'clubbing')
		{
            $dockets = implode(',',$doc);
			if($post_ops_code == $sewing_code)
			{
			  $get_bundles = "select distinct(tid) as bundle_no from $bai_pro3.packing_summary_input where doc_no = $doc_no";
			  //echo $get_bundles;
			  $result_bundles = $link->query($get_bundles);
			  $module_result = $result_bundles->num_rows;
			  while($bundle_row = $result_bundles->fetch_assoc()) 
			  {
			     $bundle_numbers[] = $bundle_row['bundle_no'];
			  }
			  
			    if($module_result > 0)
			    {
			      $post_ops_validation = "SELECT sum(recevied_qty)as recevied_qty,size_title as size FROM $brandix_bts.bundle_creation_data WHERE bundle_number in (".implode(',',$bundle_numbers).") AND operation_id = $post_ops_code";
			        $result_pre_ops_validation = $link->query($post_ops_validation);
			        while($row = $result_pre_ops_validation->fetch_assoc()) 
			        {
			            $recevied_qty_qty = $row['recevied_qty'];
			            $size = $row['size'];
			        
				        if($recevied_qty_qty > 0)
				        {
				        	$job_details_qry = "SELECT id,`size_title` AS size_code,size_id as old_size,`color` as order_col_des,`bundle_number` AS tid,sum(original_qty) AS carton_act_qty,SUM(`recevied_qty`) AS reported_qty,SUM(recevied_qty)-$recevied_qty_qty AS balance_to_report,`docket_number` AS doc_no, `cut_number` AS acutno, `input_job_no`,`input_job_no_random_ref` AS input_job_no_random, 'bundle_creation_data' AS flag,operation_id,remarks,size_id FROM $brandix_bts.bundle_creation_data WHERE docket_number in ($dockets)  AND size_title = '$size' AND operation_id = $op_code GROUP BY size_title,color order by bundle_number";
				        	$result_style_data = $link->query($job_details_qry);
				            while($row = $result_style_data->fetch_assoc()) 
				            {
				                $result_array['table_data'][] = $row;
				            }
				        }
				        else
				        {
			               $job_details_qry = "SELECT id,`size_title` AS size_code,size_id as old_size,`color` as order_col_des,`bundle_number` AS tid,sum(original_qty) AS carton_act_qty,SUM(`recevied_qty`) AS reported_qty,SUM(recevied_qty) AS balance_to_report,`docket_number` AS doc_no, `cut_number` AS acutno, `input_job_no`,`input_job_no_random_ref` AS input_job_no_random, 'bundle_creation_data' AS flag,operation_id,remarks,size_id FROM $brandix_bts.bundle_creation_data WHERE docket_number in ($dockets) AND operation_id = $op_code GROUP BY size_title,color order by bundle_number";
				        	$result_style_data = $link->query($job_details_qry);
				            while($row = $result_style_data->fetch_assoc()) 
				            {
				                $result_array['table_data'][] = $row;
				            }
				        }
			              
				        
			        }
			         echo json_encode($result_array);
				}
			    else
			    {
			    	$job_details_qry = "SELECT id,`size_title` AS size_code,size_id as old_size,`color` as order_col_des,`bundle_number` AS tid,sum(original_qty) AS carton_act_qty,SUM(`recevied_qty`) AS reported_qty,SUM(recevied_qty) AS balance_to_report,`docket_number` AS doc_no, `cut_number` AS acutno, `input_job_no`,`input_job_no_random_ref` AS input_job_no_random, 'bundle_creation_data' AS flag,operation_id,remarks,size_id FROM $brandix_bts.bundle_creation_data WHERE docket_number in ($dockets) AND operation_id = $op_code GROUP BY size_title,color order by bundle_number";
			    	$result_style_data = $link->query($job_details_qry);
			        while($row = $result_style_data->fetch_assoc()) 
			        {
			            $result_array['table_data'][] = $row;
			        }
			        echo json_encode($result_array); 
			    }	

			}
			else
			{
				$post_ops_validation = "SELECT sum(recevied_qty)as recevied_qty,size_title as size,docket_number FROM $brandix_bts.bundle_creation_data WHERE docket_number in ($dockets) AND operation_id = $post_ops_code group by size_title";
				//echo $post_ops_validation;
			    $result_pre_ops_validation = $link->query($post_ops_validation);
			    while($row = $result_pre_ops_validation->fetch_assoc()) 
			    {
			        $recevied_qty_qty = $row['recevied_qty'];
			        $size = $row['size'];
			        $docket_number = $row['docket_number'];


			        $job_details_qry = "SELECT id,`size_title` AS size_code,size_id as old_size,`color` as order_col_des,`bundle_number` AS tid,sum(original_qty) AS carton_act_qty,SUM(`recevied_qty`) AS reported_qty,SUM(recevied_qty)-$recevied_qty_qty AS balance_to_report,`docket_number` AS doc_no, `cut_number` AS acutno, `input_job_no`,`input_job_no_random_ref` AS input_job_no_random, 'bundle_creation_data' AS flag,operation_id,remarks,size_id FROM $brandix_bts.bundle_creation_data WHERE docket_number in ($dockets) AND size_title = '$size' AND operation_id = $op_code GROUP BY size_title order by bundle_number";
			       // echo $job_details_qry;
			        $result_style_data = $link->query($job_details_qry);
			        while($row = $result_style_data->fetch_assoc()) 
			        {
			            $result_array['table_data'][] = $row;
			        }
			  
			    }
			    echo json_encode($result_array); 
			   
			}
		}
		else
		{
			
            if($post_ops_code == $sewing_code)
	        {
	          $get_bundles = "select distinct(tid) as bundle_no from $bai_pro3.packing_summary_input where doc_no = $doc_no";
	          //echo $get_bundles;
	          $result_bundles = $link->query($get_bundles);
	          $module_result = $result_bundles->num_rows;
	          while($bundle_row = $result_bundles->fetch_assoc()) 
		      {
	             $bundle_numbers[] = $bundle_row['bundle_no'];
		      }
	          
	            if($module_result > 0)
	            {
	              $post_ops_validation = "SELECT sum(recevied_qty)as recevied_qty,size_title as size FROM $brandix_bts.bundle_creation_data WHERE bundle_number in (".implode(',',$bundle_numbers).") AND operation_id = $post_ops_code";
			        $result_pre_ops_validation = $link->query($post_ops_validation);
			        while($row = $result_pre_ops_validation->fetch_assoc()) 
			        {
			            $recevied_qty_qty = $row['recevied_qty'];
			            $size = $row['size'];
			        
				        if($recevied_qty_qty > 0)
				        {
				        	$job_details_qry = "SELECT id,`size_title` AS size_code,size_id as old_size,`color` as order_col_des,`bundle_number` AS tid,sum(original_qty) AS carton_act_qty,SUM(`recevied_qty`) AS reported_qty,SUM(recevied_qty)-$recevied_qty_qty AS balance_to_report,`docket_number` AS doc_no, `cut_number` AS acutno, `input_job_no`,`input_job_no_random_ref` AS input_job_no_random, 'bundle_creation_data' AS flag,operation_id,remarks,size_id FROM $brandix_bts.bundle_creation_data WHERE docket_number = '$doc_no'  AND size_title = '$size' AND operation_id = $op_code GROUP BY size_title,color order by bundle_number";
				        	$result_style_data = $link->query($job_details_qry);
				            while($row = $result_style_data->fetch_assoc()) 
				            {
				                $result_array['table_data'][] = $row;
				            }
				        }
				        else
				        {
	                       $job_details_qry = "SELECT id,`size_title` AS size_code,size_id as old_size,`color` as order_col_des,`bundle_number` AS tid,sum(original_qty) AS carton_act_qty,SUM(`recevied_qty`) AS reported_qty,SUM(recevied_qty) AS balance_to_report,`docket_number` AS doc_no, `cut_number` AS acutno, `input_job_no`,`input_job_no_random_ref` AS input_job_no_random, 'bundle_creation_data' AS flag,operation_id,remarks,size_id FROM $brandix_bts.bundle_creation_data WHERE docket_number = '$doc_no' AND operation_id = $op_code GROUP BY size_title,color order by bundle_number";
				        	$result_style_data = $link->query($job_details_qry);
				            while($row = $result_style_data->fetch_assoc()) 
				            {
				                $result_array['table_data'][] = $row;
				            }
				        }
			              
				        
			        }
			         echo json_encode($result_array);
				}
	            else
			    {
		        	$job_details_qry = "SELECT id,`size_title` AS size_code,size_id as old_size,`color` as order_col_des,`bundle_number` AS tid,sum(original_qty) AS carton_act_qty,SUM(`recevied_qty`) AS reported_qty,SUM(recevied_qty) AS balance_to_report,`docket_number` AS doc_no, `cut_number` AS acutno, `input_job_no`,`input_job_no_random_ref` AS input_job_no_random, 'bundle_creation_data' AS flag,operation_id,remarks,size_id FROM $brandix_bts.bundle_creation_data WHERE docket_number = '$doc_no' AND operation_id = $op_code GROUP BY size_title,color order by bundle_number";
		        	$result_style_data = $link->query($job_details_qry);
		            while($row = $result_style_data->fetch_assoc()) 
		            {
		                $result_array['table_data'][] = $row;
		            }
			        echo json_encode($result_array); 
			    }	

	        }
	        else
	        {
	        	$post_ops_validation = "SELECT sum(recevied_qty)as recevied_qty,size_title as size FROM $brandix_bts.bundle_creation_data WHERE docket_number=$doc_no AND operation_id = $post_ops_code group by size_title";
	        	//echo $post_ops_validation;
		        $result_pre_ops_validation = $link->query($post_ops_validation);
		        while($row = $result_pre_ops_validation->fetch_assoc()) 
		        {
		            $recevied_qty_qty = $row['recevied_qty'];
		            $size = $row['size'];


		            $job_details_qry = "SELECT id,`size_title` AS size_code,size_id as old_size,`color` as order_col_des,`bundle_number` AS tid,sum(original_qty) AS carton_act_qty,SUM(`recevied_qty`) AS reported_qty,SUM(recevied_qty)-$recevied_qty_qty AS balance_to_report,`docket_number` AS doc_no, `cut_number` AS acutno, `input_job_no`,`input_job_no_random_ref` AS input_job_no_random, 'bundle_creation_data' AS flag,operation_id,remarks,size_id FROM $brandix_bts.bundle_creation_data WHERE docket_number = '$doc_no' AND size_title = '$size' AND operation_id = $op_code GROUP BY size_title order by bundle_number";
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

    error_reporting(0);   
    include("../../../../../common/config/config_ajax.php");
    include("../../../../../common/config/m3Updations.php");
 	parse_str($post_data,$new_data);
    $b_style= $new_data['style'];
    $b_schedule=$new_data['schedule'];
	$b_colors=$new_data['colors'];
	$b_sizes = $new_data['sizes'];
	$b_size_code = $new_data['old_size'];
	$b_doc_no = $new_data['doc_no'];
	$main_doc_no = $new_data['docket_number'];
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
	$main_bundle =[];
	$concurrent_flag = 0;
	if($b_op_id >=130 && $b_op_id < 300)
	{
		$form = 'G';
	}
	$type = $form;

	//Total reproted quantity for the docket
	$tot_report_qty_doc = $rep_sum_qty;
 
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

        $size_wise_good_qtys = [];
		foreach($b_sizes as $key=>$size)
		{
		    $size_wise_good_qtys[$size] = $b_rep_qty[$key];
		}  

        //var_dump($main_doc_no);
        $flag = '';
	    //To check Clubbing
	    $get_child_docs = "select doc_no from $bai_pro3.plandoc_stat_log where org_doc_no = $main_doc_no";
	    // echo $get_child_docs;
	    // die();
		$result_get_child_docs_check = $link->query($get_child_docs);
		if($result_get_child_docs_check->num_rows > 0)
		{
		     while($row_club = $result_get_child_docs_check->fetch_assoc()) 
		    {
		        $doc[] = $row_club['doc_no'];
		    }
		    $flag = 'clubbing';
		}
		else
		{
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
		}	
	   			
		$bulk_insert_post_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`) VALUES";	
		
		if($concurrent_flag == 0)
		{
			if($flag == 'clubbing')
			{
				$bal_qty = [];
                $rec_qty = [];
                //Good Qty Logic
                $dockets = implode(',',$doc);
		        $get_bcd_qty ="select recevied_qty as balance_qty,rejected_qty,original_qty,send_qty,recevied_qty,docket_number,size_title,bundle_number,size_id,cut_number From $brandix_bts.bundle_creation_data where docket_number in ($dockets) and operation_id = '$b_op_id'";
                // echo  $get_bcd_qty;
		        $result_get_bcd_qty = $link->query($get_bcd_qty);
		        while($row_bcd_qry = $result_get_bcd_qty->fetch_assoc()) 
		        {

		            $docket_number =  $row_bcd_qry['docket_number'];
		            $size =  $row_bcd_qry['size_title'];
		            $original_qty = $row_bcd_qry['original_qty'];
		            $bundle_no = $row_bcd_qry['bundle_number'];
		            $size_id = $row_bcd_qry['size_id'];
		            $send_qty = $row_bcd_qry['send_qty'];
		            $cut_no = $row_bcd_qry['cut_number'];
		            

		            if($size_wise_good_qtys[$size] > 0)
		            {
		                // $bal_qty[$size] = $row_bcd_qry['balance_qty'] - $post_scanned_qty;
		                $bal_qty[$size] = $row_bcd_qry['balance_qty'];
		                
		                if($bal_qty[$size] > $size_wise_good_qtys[$size])
		                {
		                // 100                  200

		                    $final_reversal_qty = $size_wise_good_qtys[$size];
		                    

		                    $size_wise_good_qtys[$size] = 0;
		                    
		                }         
		                else
		                {

		                    $final_reversal_qty = $bal_qty[$size];
		                    

		                    $size_wise_good_qtys[$size] -= $bal_qty[$size];
		                    
		                }

		               $m3[$bundle_no] = $final_reversal_qty;
		                //Updating CPS Log
		                $cps_log_qry_pre = "UPDATE $bai_pro3.cps_log SET `remaining_qty`= remaining_qty-$final_reversal_qty WHERE doc_no = '".$docket_number."' AND operation_code = '$b_op_id' AND size_title='".$size."'"; 
		                //echo $cps_log_qry_pre;
	                    $cps_log_result_pre = $link->query($cps_log_qry_pre) or exit('CPS LOG query pre error');

		                //Updating BCD
		                $query = "UPDATE $brandix_bts.bundle_creation_data SET `recevied_qty`= recevied_qty-$final_reversal_qty where docket_number ='".$docket_number."' and size_title='$size' and operation_id = ".$b_op_id;
		                //echo $query;
		                $result_query = $link->query($query) or exit('query error in updating');
		                if($post_ops_code)
				        {
				            $query_post_dep = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = send_qty-$final_reversal_qty, `scanned_date`='". date('Y-m-d')."' where docket_number ='".$docket_number."' and size_title ='".$size."' and operation_id = $post_ops_code";
				            // echo $query_post_dep;
				            $result_query = $link->query($query_post_dep) or exit('query error in updating6');
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
								$pre_send_qty_qry = "select min(recevied_qty)as recieved_qty from $brandix_bts.bundle_creation_data where docket_number = '". $docket_number."' and size_title ='". $size."' and operation_id in (".implode(',',$dep_ops_codes).")";
								//echo $pre_send_qty_qry;
								$result_pre_send_qty = $link->query($pre_send_qty_qry) or exit('query error in updating 5');
								while($row = $result_pre_send_qty->fetch_assoc()) 
								{
									$pre_recieved_qty = $row['recieved_qty'];
								}
								$query_post_dep = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$pre_recieved_qty."', `scanned_date`='". date('Y-m-d')."' where docket_number = '". $docket_number."' nd size_title ='". $size."' and operation_id = ".$ops_dependency;
								// echo $query_post_dep;
								$result_query = $link->query($query_post_dep) or exit('query error in updating6');
							}
						}         

		            }
		           
		            $smv_query = "select smv from $brandix_bts.tbl_style_ops_master where style='$b_style' and color='$mapped_color' and operation_code = $b_op_id";
		            //echo $smv_query;
		            $result_smv_query = $link->query($smv_query);
		            while($row_ops = $result_smv_query->fetch_assoc()) 
		            {
		               $sfcs_smv = $row_ops['smv'];
		            }
		            
		            if($result_query)
		            {
		            
		                
		                $bulk_insert_post_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$mapped_color.'","'.$size_id.'","'. $size.'","'. $sfcs_smv.'","'.$bundle_no.'","'.$original_qty.'","'.$send_qty.'",'-'"'.$final_reversal_qty.'","0","0","'. $b_op_id.'","'.$docket_number.'","'.date('Y-m-d').'","'.$cut_no.'","'.$docket_number.'","'.$docket_number.'","'.$b_shift.'","'.$b_module.'","Normal"),';   
		                //echo  $bulk_insert_post_temp;            
		               
		                
		            }

		            $bal_qty[$size] = 0;
		            $final_reversal_qty = 0;
		        
		        }

		        $result_query_001_temp = $link->query(rtrim($bulk_insert_post_temp,',') ) or exit('bulk_insert_post query error in updating11111');

		        foreach($m3 as $bundle => $rev_qty)
		        {
		        	
		        	//M3 API Call and operation quantites updatation and M3 Transactions and log tables for good quantity
		            updateM3Transactions($bundle,$b_op_id,$rev_qty);

		        	
		        }
			}
			else
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
						$main_bundle[$value] = $row['bundle_number'];
						//var_dump($main_bundle);
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
	    }
        //var_dump($main_bundle);
        foreach($b_sizes as $key=>$value)
		{

			$bundle_no = $main_bundle[$value];

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

function packingReversal($data)
{
	include("../../../../../common/config/config_ajax.php");
	include("../../../../../common/config/m3Updations.php");
	$main_data = explode(",",$data);
	$carton_id = $main_data[0];
	$b_op_id = $main_data[1];
	$shift = $main_data[2];

	$application='packing';
	// echo "in func";
	// die();

	$carton_query = "SELECT * FROM $bai_pro3.pac_stat WHERE id = $carton_id";
	// echo $carton_query;
	$carton_details=mysqli_query($link, $carton_query) or exit("Error while getting Carton Details");
	
	if (mysqli_num_rows($carton_details) > 0)
	{
		$get_carton_type=mysqli_fetch_array($carton_details);
		$opn_status = $get_carton_type['opn_status'];

		if ($opn_status == null)
		{
			$result_array['status'] = 'Carton Not Scanned';
	        echo json_encode($result_array);
	        die();
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
	            	if ($packing_last_opn == $b_op_id)
	            	{
	            		$go_here = 1;
	            	}
	            	else
	            	{
	            		$go_here = 0;
	            	}
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
				$result_array['status'] = 'Previous Operation Not Done';
		        echo json_encode($result_array);
		        die();
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
				
				
                $update_carton_status = "";
                
                if ($packing_first_opn == $b_op_id) {
		        	$set_opn = '';
		        } else {
		        	$set_opn = $before_opn;
		        }
				$update_pac_stat_atble="update $bai_pro3.pac_stat set opn_status='".$set_opn."' ".$update_carton_status." where id = '".$carton_id."'";
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
				$result_array['success'] = 'Carton '.$carton_id.' is Reversed';
		        echo json_encode($result_array);
		        die();
			}
		}
	}
	else
	{
		$result_array['status'] = 'No Cartons available with this ID - '.$carton_id;
        echo json_encode($result_array);
        die();
	}
}

?>