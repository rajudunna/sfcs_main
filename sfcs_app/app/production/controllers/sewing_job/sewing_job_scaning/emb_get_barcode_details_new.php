<?php
    error_reporting(0);
    include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
    include 'functions_scanning_ij.php';
    $barcode = $_POST['barcode'];
    $shift = $_POST['shift'];
    $gate_id = $_POST['gate_id'];
	$user_permission = $_POST['auth'];
    $b_shift = $shift;
    //changing for #978 cr
    $docket_no = explode('-', $barcode)[0];
	
	//getting details from emb_bundles
	$get_data_qry="select size,club_status,quantity,status from $bai_pro3.emb_bundles where barcode='$barcode'";	
	$selct_qry_result=mysqli_query($link,$get_data_qry) or exit("error while retriving bundle_number".mysqli_error($GLOBALS["___mysqli_ston"]));
    if($selct_qry_result->num_rows > 0)
	{
		while($selct_qry_result_row=mysqli_fetch_array($selct_qry_result))
        {
            $sizes = $selct_qry_result_row['size'];
			$clubstatus=$selct_qry_result_row['club_status'];
			$embquantity=$selct_qry_result_row['quantity'];
			$docstatus=$selct_qry_result_row['status'];
        }
	}
	$embquantity=$embquantity;

	if($clubstatus==1)
	{
		//getting original dockets from plandoc_stat_log
		$get_doc_no_qry="select doc_no from bai_pro3.plandoc_stat_log where org_doc_no=$docket_no";
		$docno_qry_result=mysqli_query($link,$get_doc_no_qry) or exit("error while retriving bundle_number".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($docno_qry_result_row=mysqli_fetch_array($docno_qry_result))
        {
			$clubdocno[]=$docno_qry_result_row['doc_no'];
		}		
	}
	if($clubstatus==1)
	{
		$doc_no=implode(',',$clubdocno);
	}
	else
	{
		$doc_no=explode('-', $barcode)[0];
	}

    $op_no = explode('-', $barcode)[1];
	$seqno = explode('-', $barcode)[2];
	
	//getting bundle number from bundle_creation_data
	$selct_qry = "SELECT bundle_number FROM $brandix_bts.bundle_creation_data  WHERE docket_number =$doc_no AND operation_id='$op_no' AND size_title='$sizes'";
    $selct_qry_res=mysqli_query($link,$selct_qry) or exit("while retriving bundle_number".mysqli_error($GLOBALS["___mysqli_ston"]));
    if($selct_qry_res->num_rows > 0)
	{
   
        while($selct_qry_result_rows=mysqli_fetch_array($selct_qry_res))
        {
            $bundle_no = $selct_qry_result_rows['bundle_number'];
        }
    }
	
	
    $emb_cut_check_flag = 0;
    $msg = 'Scanned Successfully';

    $string = $bundle_no.','.$op_no.','.'0';
    getjobdetails1($string, $bundle_no, $op_no, $shift ,$gate_id, $embquantity, $seqno, $doc_no, $sizes, $docstatus);
   
    function getjobdetails1($job_number, $bundle_no, $op_no, $shift ,$gate_id, $embquantity, $seqno,$doc_no,$sizes,$docstatus)
    {
        $job_number = explode(",",$job_number);
        $job_number[4]=$job_number[1];
		$gate_pass_no=$gate_id;
        include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
        include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/m3Updations.php");
       
        $column_to_search = $job_number[0];
        $column_in_where_condition = 'bundle_number';
       
        $selecting_style_schedule_color_qry = "select style,schedule,color from $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = '$column_to_search' order by bundle_number";
        $result_selecting_style_schedule_color_qry = $link->query($selecting_style_schedule_color_qry);
        if($result_selecting_style_schedule_color_qry->num_rows > 0)
        {
            while($row = $result_selecting_style_schedule_color_qry->fetch_assoc())
            {
                $job_number[1]= $row['style'];
                $job_number[2]= $row['schedule'];
                $job_number[3]= $row['color'];
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

          $maped_color = $job_number[3];
       

        //*To check Parallel Operations
        $ops_sequence_check = "select id,ops_sequence,ops_dependency,operation_order from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' and operation_code=$job_number[4]";
        //echo $ops_sequence_check;
        $result_ops_sequence_check = $link->query($ops_sequence_check);
        while($row2 = $result_ops_sequence_check->fetch_assoc())
        {
            $ops_seq = $row2['ops_sequence'];
            $seq_id = $row2['id'];
            $ops_order = $row2['operation_order'];

        }

        $pre_operation_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) < '$ops_order' and operation_code NOT IN  (10,200) ORDER BY operation_order DESC LIMIT 1";
        //echo $pre_operation_check;
        $result_pre_operation_check = $link->query($pre_operation_check);
        if($result_pre_operation_check->num_rows > 0)
        {
            while($row23 = $result_pre_operation_check->fetch_assoc())
            {
                $pre_ops_code = $row23['operation_code'];
            }
        }  

        $dep_ops_check = "select ops_dependency from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' AND operation_code = '$pre_ops_code'";
        //echo $dep_ops_check;
        $result_dep_ops_check = $link->query($dep_ops_check);
        if($result_dep_ops_check->num_rows > 0)
        {
            while($row22 = $result_dep_ops_check->fetch_assoc())
            {
                $next_operation = $row22['ops_dependency'];
            }
        }
        else
        {
            $next_operation = '';
        }

        if($next_operation > 0)
        {
               $flag = 'parallel_scanning';

               $get_ops_dep = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' and ops_dependency = $next_operation";
               $result_ops_dep = $link->query($get_ops_dep);
               while($row_dep = $result_ops_dep->fetch_assoc())
               {
                  $operations[] = $row_dep['operation_code'];
               }
               $emb_operations = implode(',',$operations);
               //parallel_scanning($style,$schedule,$color,$input_job,$operation_id);
        }
   
        //End Here
        else
        {
          $ops_dep_flag = 0;
            $ops_dep_qry = "SELECT ops_dependency,operation_code FROM $brandix_bts.tbl_style_ops_master WHERE style='$job_number[1]' AND color =  '$maped_color' AND ops_dependency != 200 AND ops_dependency != 0";
            $result_ops_dep_qry = $link->query($ops_dep_qry);
            while($row = $result_ops_dep_qry->fetch_assoc())
            {
                if($row['ops_dependency'])
                {
                    if($row['ops_dependency'] == $job_number[4])
                    {
                        $ops_dep_code = $row['operation_code'];
                        $schedule_count_query = "SELECT sum(recevied_qty)as recevied_qty FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = '$column_to_search' AND operation_id =$ops_dep_code";
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
        }


       
        //  if($next_operation < 0)
        // {
       if($flag == 'parallel_scanning')
	   {
		   $flag = 'parallel_scanning';
	   }
	   else
	   {
                $flags=0;
                $ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' and operation_code=$job_number[4]";
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

                $pre_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) < '$ops_order' and operation_code NOT IN  (10,200) ORDER BY operation_order DESC LIMIT 1";
                //echo $pre_ops_check;
                $result_pre_ops_check = $link->query($pre_ops_check);
                if($result_pre_ops_check->num_rows > 0)
                {
                    while($row = $result_pre_ops_check->fetch_assoc())
                    {
                        $pre_ops_code = $row['operation_code'];
                    }
                    $category=['cutting','Send PF','Receive PF'];
                    $checking_qry = "SELECT category FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code = '$pre_ops_code'";
                    $result_checking_qry = $link->query($checking_qry);
                    while($row_cat = $result_checking_qry->fetch_assoc())
                    {
                        $category_act = $row_cat['category'];
                    }
                    if(in_array($category_act,$category))
                    {
                        $emb_cut_check_flag = 1;
                    }
                    if($emb_cut_check_flag != 1)
                    {
                        $pre_ops_validation = "SELECT sum(recevied_qty)as recevied_qty FROM  $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = '$column_to_search' AND operation_id = $pre_ops_code";
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
                            $schedule_query = "SELECT `style` as order_style_no,`schedule` as order_del_no,`send_qty`,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,`original_qty` as carton_act_qty,`recevied_qty` as reported_qty,`rejected_qty` as rejected_qty,((send_qty+recut_in+replace_in)-(recevied_qty+rejected_qty)) as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks, mapped_color,assigned_module FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = '$column_to_search' AND operation_id = $job_number[4] order by tid";
                            $flag = 'bundle_creation_data';
                        }
                    }
                    else
                    {
                        $schedule_count_query = "SELECT bundle_number FROM $brandix_bts.bundle_creation_data WHERE bundle_number = '$job_number[0]' AND operation_id =$job_number[4]";
                        $schedule_count_query = $link->query($schedule_count_query);
                        if($schedule_count_query->num_rows > 0)
                        {
                            $schedule_query = "SELECT `style` as order_style_no,`schedule` as order_del_no,`send_qty`,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,`original_qty` as carton_act_qty,`recevied_qty` as reported_qty,`rejected_qty` as rejected_qty,((send_qty+recut_in+replace_in)-(recevied_qty+rejected_qty)) as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks, mapped_color,assigned_module FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = '$column_to_search' AND operation_id = $job_number[4] order by tid";
                            $flags=3;
                            $flag = 'bundle_creation_data';
                        }
                       
                    }
                }
                else
                {
                    $schedule_count_query = "SELECT bundle_number FROM $brandix_bts.bundle_creation_data WHERE bundle_number = '$job_number[0]' AND operation_id =$job_number[4]";
                    $schedule_count_query = $link->query($schedule_count_query);
                    if($schedule_count_query->num_rows > 0)
                    {
                        $schedule_query = "SELECT `style` as order_style_no,`schedule` as order_del_no,`send_qty`,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,`original_qty` as carton_act_qty,`recevied_qty` as reported_qty,`rejected_qty` as rejected_qty,((send_qty+recut_in+replace_in)-(recevied_qty+rejected_qty)) as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks, mapped_color,assigned_module FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = '$column_to_search' AND operation_id = $job_number[4] order by tid";
                        $flags=3;
                        $flag = 'bundle_creation_data';
                    }
               
                }
      }  
         if($flag == 'parallel_scanning')
         {

            $get_doc = "select DISTINCT(doc_no) as docket_number,size_code FROM $bai_pro3.packing_summary_input WHERE tid = $bundle_no";
           // echo $get_doc ;
            $result_get_doc_qry = $link->query($get_doc);
            while($row_doc_pack = $result_get_doc_qry->fetch_assoc())
            {
                $main_dockets = $row_doc_pack['docket_number'];
                $size =  $row_doc_pack['size_code'];
            }

             //get min qty of previous operations
            $qry_min_prevops="SELECT MIN(recevied_qty) AS min_recieved_qty FROM $brandix_bts.bundle_creation_data WHERE docket_number = $doc_no AND size_title = '$sizes' AND operation_id in ($emb_operations)";
            //echo $qry_min_prevops;
            $result_qry_min_prevops = $link->query($qry_min_prevops);
            while($row_result_min_prevops = $result_qry_min_prevops->fetch_assoc())
            {
                $previous_minqty=$row_result_min_prevops['min_recieved_qty'];
            }

         
            $schedule_query = "SELECT `style` as order_style_no,`schedule` as order_del_no,`send_qty`,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,`original_qty` as carton_act_qty,sum(recevied_qty) AS current_recieved_qty,`rejected_qty` as rejected_qty,((send_qty+recut_in+replace_in)-(recevied_qty+rejected_qty)) as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'parallel_scanning' as flag,size_id as old_size,remarks, mapped_color,assigned_module FROM $brandix_bts.bundle_creation_data WHERE docket_number = $doc_no AND operation_id = '$job_number[4]' and size_title='$sizes' order by tid";

            $flags=3;
            $flag = 'parallel_scanning';
               
         }
        if($flags == 2)
        {
            $result_array['status'] .= 'Previous operation not yet done for this job.';
            echo json_encode($result_array);
            die();
        }
       
        else
        {
            // echo $schedule_query;
            $result_style_data = $link->query($schedule_query);
            $select_modudle_qry = "select input_module from $bai_pro3.plan_dashboard_input where input_job_no_random_ref = '$job_number[0]'";
            $result_select_modudle_qry = $link->query($select_modudle_qry);
            while($row = $result_select_modudle_qry->fetch_assoc())
            {
                $module = $row['input_module'];
            }
            while($row = $result_style_data->fetch_assoc())
            {       
             
                $style = $job_number[1];
                $schedule =  $job_number[2];
                $color = $job_number[3];
                $size = $sizes;
               
                $b_job_no = $row['input_job_no_random'];
                $b_style= $row['order_style_no'];
                $b_schedule=$row['order_del_no'];
                $b_colors[]=$row['order_col_des'];
                $b_sizes[] = $row['size_code'];
                $b_size_code[] = $row['old_size'];
                $size_ims = $row['size_code'];
                $b_doc_num[]=$row['doc_no'];
                $doc_value = $row['doc_no'];
                $b_in_job_qty[]=$row['carton_act_qty'];

                if($flag == 'parallel_scanning')
                {
					$current_ops_qty=$row['balance_to_report'];
					$parallel_balance_report=($previous_minqty-$current_ops_qty);
					
                    if($parallel_balance_report>0)
                    {
                       
                      $b_rep_qty[]=$parallel_balance_report;
               
                    }
                }  
                $b_rep_qty[]=$row['balance_to_report'];
                $b_rej_qty[]=0;
                $b_op_id = $op_no;
                $b_tid[] = $row['tid'];
                $b_inp_job_ref[] = $row['input_job_no'];
                $b_a_cut_no[] = $row['acutno'];
                if($flag == 'bundle_creation_data')
				{
				$b_remarks[] = $row['remarks'];
				}
                $b_shift = $shift;
                if($flag == 'bundle_creation_data'){
                    $mapped_color = $row['mapped_color'];
                    $b_module[] = $row['assigned_module'];
                }else{
                    $mapped_color = $row['order_col_des'];
                    $b_module[] = $module;
                }
                $result_array['table_data'][] = $row;
            }
        }
        $result_array['flag'] = $flag;
        $table_name = $result_array['flag'];
        $style = $result_array['style'];
        $schedule = $result_array['schedule'];
        $color = $result_array['color_dis'];
        $table_data = $result_array['table_data'];

        // checking ops ..............................................

        $dep_ops_array_qry = "select operation_code,ops_sequence, default_operration,smv,manual_smv from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' and operation_code=$b_op_id";
        $result_dep_ops_array_qry = $link->query($dep_ops_array_qry);
        while($row = $result_dep_ops_array_qry->fetch_assoc())
        {
            $sequnce = $row['ops_sequence'];
            $is_m3 = $row['default_operration'];
            $sfcs_smv = $row['smv'];
			if($sfcs_smv=='0.0000')
			{
			$sfcs_smv = $row_ops['manual_smv'];
			}
        }
       
        $ops_dep_qry = "SELECT ops_dependency,operation_code,ops_sequence FROM $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' and ops_sequence='$sequnce' AND ops_dependency != 200 AND ops_dependency != 0 group by ops_dependency";
        $result_ops_dep_qry = $link->query($ops_dep_qry);
        while($row = $result_ops_dep_qry->fetch_assoc())
        {
            $ops_dep = $row['ops_dependency'];
        }
        if($ops_dep){
            $dep_ops_array_qry_raw = "select operation_code from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' and ops_dependency=$ops_dep";
           
            $result_dep_ops_array_qry_raw = $link->query($dep_ops_array_qry_raw);
            while($row = $result_dep_ops_array_qry_raw->fetch_assoc())
            {
                $dep_ops_codes[] = $row['operation_code'];
            }
        }
       
        $ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$mapped_color' and operation_code=$b_op_id";
        $result_ops_seq_check = $link->query($ops_seq_check);
        while($row = $result_ops_seq_check->fetch_assoc())
        {
            $ops_seq = $row['ops_sequence'];
            $seq_id = $row['id'];
            $ops_order = $row['operation_order'];
        }
       
        if($ops_dep)
        {
            $dep_ops_array_qry_seq = "select ops_dependency,operation_code,ops_sequence from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' AND ops_dependency != 200 AND ops_dependency != 0 group by ops_dependency";
            $result_dep_ops_array_qry_seq = $link->query($dep_ops_array_qry_seq);
            while($row = $result_dep_ops_array_qry_seq->fetch_assoc())
            {
                $ops_dep_ary[] = $row['ops_dependency'];
            }
        }
        else
        {
            $ops_dep_ary[] = null;
        }
        if($ops_dep_ary[0] != null)
        {
            $ops_seq_qrs = "select ops_sequence from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' AND operation_code in (".implode(',',$ops_dep_ary).")";
            $result_ops_seq_qrs = $link->query($ops_seq_qrs);
            while($row = $result_ops_seq_qrs->fetch_assoc())
            {
                $ops_seq_dep[] = $row['ops_sequence'];
            }
        }
        else
        {
            $ops_seq_dep[] = $ops_seq;
        }
        $pre_ops_check = "SELECT tm.operation_code as operation_code,ops_sequence FROM $brandix_bts.tbl_style_ops_master tm LEFT JOIN brandix_bts.`tbl_orders_ops_ref` tr ON tr.id=tm.operation_name WHERE style='$b_style' AND color = '$mapped_color' and (ops_sequence = '$ops_seq' or ops_sequence in  (".implode(',',$ops_seq_dep).")) AND  tr.category  IN ('sewing') AND tm.operation_code != 200";
        //echo $pre_ops_check;
        $result_pre_ops_check = $link->query($pre_ops_check);
        if($result_pre_ops_check->num_rows > 0)
            {
            while($row_ops = $result_pre_ops_check->fetch_assoc())
             {
                $pre_ops_code_temp[] = $row_ops['operation_code'];
            }
        }
        $post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) > '$ops_order' and operation_code NOT IN (10,200,15) ORDER BY operation_order ASC LIMIT 1";
        $result_post_ops_check = $link->query($post_ops_check);
        if($result_post_ops_check->num_rows > 0)
        {
            while($row = $result_post_ops_check->fetch_assoc())
            {
                $post_ops_code = $row['operation_code'];
            }
        }
        foreach($pre_ops_code_temp as $index => $op_code)
        {
            if($op_code != $b_op_id)
            {
                $b_query[$op_code] = "INSERT  INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `mapped_color`,`barcode_sequence`,`barcode_number`) VALUES";

                // temp table data query

                $b_query_temp[$op_code] = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `scanned_user`) VALUES";
            }
        }
        // insert or update based on table
        if($table_name == 'parallel_scanning')
        {
			if($docstatus==0 || $docstatus=='')
			{
					$schedule_count_query = "SELECT input_job_no_random_ref FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = $b_job_no AND operation_id =$b_op_id";
					$schedule_count_query = $link->query($schedule_count_query) or exit('query error');
				   
					if($schedule_count_query->num_rows > 0)
					{
						$schedule_count = true;
					}else{
						$schedule_count = false;
					}
				   
					 foreach ($b_tid as $key => $tid)
					{
						if($b_tid[$key] == $bundle_no)
						{
							
						  $smv_query = "select smv,manual_smv from $brandix_bts.tbl_style_ops_master where style='$b_style' and color='$mapped_color' and operation_code = $b_op_id";
								$result_smv_query = $link->query($smv_query);
								while($row_ops = $result_smv_query->fetch_assoc())
								{
									$sfcs_smv = $row_ops['smv'];
									if($sfcs_smv=='0.0000')
									{
									$sfcs_smv = $row_ops['manual_smv'];
									}
								}
								$bulk_insert_post = "INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`) VALUES";

								$bulk_insert_post_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `scanned_user`) VALUES";
							   
								$remarks_code = "";                            
								$select_send_qty = "SELECT (send_qty+recut_in+replace_in)as send_qty, recevied_qty,rejected_qty, left_over FROM $brandix_bts.bundle_creation_data WHERE bundle_number = $b_tid[$key] AND operation_id = $b_op_id";
								$result_select_send_qty = $link->query($select_send_qty);
								if($result_select_send_qty->num_rows >0)
								{
									while($row = $result_select_send_qty->fetch_assoc())
									{
										$b_old_rep_qty_new = $row['recevied_qty'];
										$b_old_rej_qty_new = $row['rejected_qty'];
										$b_left_over_qty = $row['left_over'];
										$b_send_qty = $row['send_qty'];

									}
								}
									$final_rep_qty = $parallel_balance_report;

									$final_rej_qty = $b_old_rej_qty_new;

									$left_over_qty = $b_in_job_qty[$key] - $final_rep_qty - $final_rej_qty;
									// LAST STEP MODIFIED
									$left_over_qty_update = $b_send_qty - $final_rep_qty;

									$previously_scanned = $parallel_balance_report;
															  
									if($schedule_count){
										$query = "UPDATE $brandix_bts.bundle_creation_data SET `recevied_qty`= recevied_qty+'".$embquantity."', `left_over`= '".$left_over_qty_update."' , `scanned_date`='". date('Y-m-d')."' where bundle_number =$b_tid[$key] and operation_id = ".$b_op_id;
									   
										$result_query = $link->query($query) or exit('query error in updating');
									}else{
										   
										$bulk_insert_post .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$embquantity.'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'")';  
										$result_query_001 = $link->query($bulk_insert_post) or exit('bulk_insert_post query error in updating');
									}
									
									//getting data form embellishment_plan_dashboard
									$get_data_embd_send_qry="select send_op_code from $bai_pro3.embellishment_plan_dashboard where doc_no=$b_doc_num[$key] and send_op_code=$b_op_id";
									$check_qry_result=mysqli_query($link,$get_data_embd_send_qry) or exit("while retriving data from embellishment_plan_dashboard".mysqli_error($GLOBALS["___mysqli_ston"]));
									while($qry_row=mysqli_fetch_array($check_qry_result))
									{
										$sendop_code=$qry_row['send_op_code'];
									}
									$get_data_embd_rec_qry="select receive_op_code from $bai_pro3.embellishment_plan_dashboard where doc_no=$b_doc_num[$key] and receive_op_code=$b_op_id";
									$check_qry_rec_result=mysqli_query($link,$get_data_embd_rec_qry) or exit("while retriving data from embellishment_plan_dashboard".mysqli_error($GLOBALS["___mysqli_ston"]));
									while($qry_rec_row=mysqli_fetch_array($check_qry_rec_result))
									{
										$recop_code=$qry_rec_row['receive_op_code'];
									}
									if($sendop_code==$b_op_id)
									{
										//update in emblishment dashboard
										$embellishment_plan_dashboard_qry = "UPDATE $bai_pro3.embellishment_plan_dashboard SET `send_qty`= send_qty+$embquantity where doc_no =$b_doc_num[$key] and send_op_code=$b_op_id";
										$embellishment_plan_dashboard_result = $link->query($embellishment_plan_dashboard_qry) or exit('Embellishment Plan Dashboard query receive error');
									}
									if($recop_code==$b_op_id)
									{
										//update in emblishment dashboard
										$embellishment_plan_dashboard_qry = "UPDATE $bai_pro3.embellishment_plan_dashboard SET `receive_qty`= receive_qty+$embquantity where doc_no =$b_doc_num[$key] and receive_op_code=$b_op_id";
										$embellishment_plan_dashboard_result = $link->query($embellishment_plan_dashboard_qry) or exit('Embellishment Plan Dashboard query receive error');
									}
									//checking data exist in emb_bundles or not
									$check_data_qry="select * from $bai_pro3.emb_bundles where doc_no='$b_doc_num[$key]' and ops_code='$b_op_id' and size='$b_sizes[$key]' and tran_id=$seqno";
									$check_data_qry_result=mysqli_query($link,$check_data_qry) or exit("while retriving data from emb_bundles".mysqli_error($GLOBALS["___mysqli_ston"]));
									if($check_data_qry_result->num_rows > 0)
									{
										while($qry_result_row=mysqli_fetch_array($check_data_qry_result))
										{
										$tid=$qry_result_row['tid'];
										$barcodeno=$qry_result_row['barcode'];
										$clubstatus=$qry_result_row['club_status'];
										$orgqty=$qry_result_row['quantity'];
										$goodqty=$qry_result_row['good_qty'];
										$rejectqty=$qry_result_row['reject_qty'];
										$tranid=$qry_result_row['tran_id'];
										$status=$qry_result_row['status'];

										//if data exists update emb_bundles
										$update_emb_bundles="UPDATE $bai_pro3.emb_bundles SET good_qty='$orgqty',status=1,reject_qty='$b_rej_qty[$key]',update_time='". date('Y-m-d')."' where doc_no='$b_doc_num[$key]' and ops_code='$b_op_id' and size='$b_sizes[$key]' and tran_id=$seqno";
										$result_query = $link->query($update_emb_bundles) or exit('query error in updating emb_bundles');

										//insert data into emb_bundles_temp
										$insert_emb_bundles="INSERT INTO $bai_pro3.emb_bundles_temp(tid,  doc_no,  size,    ops_code,  barcode,  quantity,  good_qty,  reject_qty,  insert_time,  update_time,  club_status,  log_user,  tran_id,  status) VALUES ('".$tid."','".$b_doc_num[$key]."','".$b_sizes[$key]."','".$b_op_id."','".$barcodeno."','".$orgqty."','".$orgqty."','".$rejectqty."','".date('Y-m-d')."','','".$clubstatus."','".$username."','".$tranid."','".$status."')";
										$result_emb_temp = $link->query($insert_emb_bundles) or exit('error while insert into emb_bundles_temp');
										}
									}
									// else
									// {
									// insert data into emb_bundles

									// }

									if($result_query)
									{
										if($b_rep_qty[$key] > 0)
										{
											$bulk_insert_post_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$embquantity .'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'","'.$b_remarks[$key].'","'.$username.'")';  
											$result_query_001_temp = $link->query($bulk_insert_post_temp) or exit('bulk_insert_post query error in updating');
											if($gate_pass_no>0)
											{
											$sql_gate="insert into $brandix_bts.`gatepass_track` (`gate_id`, `bundle_no`, `bundle_qty`, `style`, `schedule`, `color`, `size`,operation_id) values ('".$gate_pass_no."', ".$b_tid[$key].", '".$b_rep_qty[$key]."', '".$b_style."','".$b_schedule."','".$b_colors[$key]."','".$b_sizes[$key]."','".$b_op_id."-1')";
											$result_sql_temp = $link->query($sql_gate) or exit('Gate_pass_child query error in updating');

											}
											$update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty+$embquantity where doc_no = '".$b_doc_num[$key]."' and size_title='". $b_sizes[$key]."' AND operation_code=$b_op_id";
													$update_qry_cps_log_res = $link->query($update_qry_cps_log);
										   
											   
										   
										}
									}
									
										if($post_ops_code != null)
										{
											$query_post = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = send_qty+'".$embquantity."', `scanned_date`='". date('Y-m-d')."' where docket_number =$b_doc_num[$key] and size_title='$sizes' and operation_id = ".$post_ops_code;
											$result_query = $link->query($query_post) or exit('query error in updating');
										}
										if($ops_dep)
										{
											$pre_send_qty_qry = "select min(recevied_qty)as recieved_qty from $brandix_bts.bundle_creation_data where bundle_number =$b_tid[$key] and operation_id in (".implode(',',$dep_ops_codes).")";
											$result_pre_send_qty = $link->query($pre_send_qty_qry);
											while($row = $result_pre_send_qty->fetch_assoc())
											{
												$pre_recieved_qty = $row['recieved_qty'];
											}

											$query_post_dep = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` =send_qty+ '".$pre_recieved_qty."', `scanned_date`='". date('Y-m-d')."' where docket_number =$b_doc_num[$key] and size_title='$sizes' and operation_id = ".$ops_dep;

											$result_query = $link->query($query_post_dep) or exit('query error in updating');
								   
										}                
								   

													   
						}
					   
					}
			}
			else
			{
				$result_array['status'] = 'Already Scanned';
			}
        }
       
        else
        {
            $query = '';
       
            if($table_name == 'bundle_creation_data')
            {
					if($docstatus==0 || $docstatus=='')
					{
				   
						$schedule_count_query = "SELECT input_job_no_random_ref FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = $b_job_no AND operation_id =$b_op_id";

						$schedule_count_query = $link->query($schedule_count_query) or exit('query error');
					   
						if($schedule_count_query->num_rows > 0)
						{
							$schedule_count = true;
						}else{
							$schedule_count = false;
						}
						$concurrent_flag = 0;
						foreach ($b_tid as $key => $tid)
						{
							if($b_tid[$key] == $bundle_no){
								if($concurrent_flag == 0)
								{
									$smv_query = "select smv,manual_smv from $brandix_bts.tbl_style_ops_master where style='$b_style' and color='$mapped_color' and operation_code = $b_op_id";
									$result_smv_query = $link->query($smv_query);
									while($row_ops = $result_smv_query->fetch_assoc())
									{
										$sfcs_smv = $row_ops['smv'];
										if($sfcs_smv=='0.0000')
										{
										$sfcs_smv = $row_ops['manual_smv'];
										}
									}
									$bulk_insert_post = "INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`) VALUES";

									$bulk_insert_post_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `scanned_user`) VALUES";

									$remarks_code = "";                            
									$select_send_qty = "SELECT (send_qty+recut_in+replace_in)as send_qty, recevied_qty,rejected_qty, left_over FROM $brandix_bts.bundle_creation_data WHERE bundle_number = $b_tid[$key] AND operation_id = $b_op_id";
						   
									$result_select_send_qty = $link->query($select_send_qty);
									if($result_select_send_qty->num_rows >0)
									{
										while($row = $result_select_send_qty->fetch_assoc())
										{
											$b_old_rep_qty_new = $row['recevied_qty'];
											$b_old_rej_qty_new = $row['rejected_qty'];
											$b_left_over_qty = $row['left_over'];
											$b_send_qty = $row['send_qty'];

										}
									}
										$final_rep_qty = $b_old_rep_qty_new + $b_send_qty - ($b_old_rep_qty_new + $b_old_rej_qty_new);

										$final_rej_qty = $b_old_rej_qty_new;

										$left_over_qty = $b_in_job_qty[$key] - $final_rep_qty - $final_rej_qty;
										// LAST STEP MODIFIED
										$left_over_qty_update = $b_send_qty - $final_rep_qty;

										$previously_scanned = $b_send_qty - ($b_old_rep_qty_new + $b_old_rej_qty_new);
									   

										if($previously_scanned == 0){
											if($b_send_qty == $b_old_rej_qty_new){
												$result_array['status'] = 'This Bundle Qty Is Completely Rejected';
											}else{
												$result_array['status'] = 'Already Scanned';
											}
											echo json_encode($result_array);
											die();
										}
										if($schedule_count){
											$query = "UPDATE $brandix_bts.bundle_creation_data SET `recevied_qty`= recevied_qty+'".$embquantity."', `left_over`= '".$left_over_qty_update."' , `scanned_date`='". date('Y-m-d')."' where bundle_number =$b_tid[$key] and operation_id = ".$b_op_id;
										   
											$result_query = $link->query($query) or exit('query error in updating');
										}else{
											   
											$bulk_insert_post .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$embquantity.'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'")';
											$result_query_001 = $link->query($bulk_insert_post) or exit('bulk_insert_post query error in updating');
										}
										
										//getting data form embellishment_plan_dashboard
										$get_data_embd_send_qry="select send_op_code from $bai_pro3.embellishment_plan_dashboard where doc_no=$b_doc_num[$key] and send_op_code=$b_op_id";
										$check_qry_result=mysqli_query($link,$get_data_embd_send_qry) or exit("while retriving data from embellishment_plan_dashboard".mysqli_error($GLOBALS["___mysqli_ston"]));
										while($qry_row=mysqli_fetch_array($check_qry_result))
										{
											$sendop_code=$qry_row['send_op_code'];
										}
										$get_data_embd_rec_qry="select receive_op_code from $bai_pro3.embellishment_plan_dashboard where doc_no=$b_doc_num[$key] and receive_op_code=$b_op_id";
										$check_qry_rec_result=mysqli_query($link,$get_data_embd_rec_qry) or exit("while retriving data from embellishment_plan_dashboard".mysqli_error($GLOBALS["___mysqli_ston"]));
										while($qry_rec_row=mysqli_fetch_array($check_qry_rec_result))
										{
											$recop_code=$qry_rec_row['receive_op_code'];
										}
										if($sendop_code==$b_op_id)
										{
											//update in emblishment dashboard
											$embellishment_plan_dashboard_qry = "UPDATE $bai_pro3.embellishment_plan_dashboard SET `send_qty`= send_qty+$embquantity where doc_no =$b_doc_num[$key] and send_op_code=$b_op_id";
											$embellishment_plan_dashboard_result = $link->query($embellishment_plan_dashboard_qry) or exit('Embellishment Plan Dashboard query receive error');
										}
										if($recop_code==$b_op_id)
										{
											//update in emblishment dashboard
											$embellishment_plan_dashboard_qry = "UPDATE $bai_pro3.embellishment_plan_dashboard SET `receive_qty`= receive_qty+$embquantity where doc_no =$b_doc_num[$key] and receive_op_code=$b_op_id";
											$embellishment_plan_dashboard_result = $link->query($embellishment_plan_dashboard_qry) or exit('Embellishment Plan Dashboard query receive error');
										}
										
										//checking data exist in emb_bundles or not
										$check_data_qry="select * from $bai_pro3.emb_bundles where doc_no='$b_doc_num[$key]' and ops_code='$b_op_id' and size='$b_sizes[$key]' and tran_id=$seqno";
										//echo $check_data_qry;
										$check_data_qry_result=mysqli_query($link,$check_data_qry) or exit("while retriving data from emb_bundles".mysqli_error($GLOBALS["___mysqli_ston"]));
										if($check_data_qry_result->num_rows > 0)
										{
										while($qry_result_row=mysqli_fetch_array($check_data_qry_result))
										{
										$tid=$qry_result_row['tid'];
										$barcodeno=$qry_result_row['barcode'];
										$clubstatus=$qry_result_row['club_status'];
										$orgqty=$qry_result_row['quantity'];
										$goodqty=$qry_result_row['good_qty'];
										$rejectqty=$qry_result_row['reject_qty'];
										$tranid=$qry_result_row['tran_id'];
										$status=$qry_result_row['status'];

										//if data exists update emb_bundles
										$update_emb_bundles="UPDATE $bai_pro3.emb_bundles SET good_qty=$orgqty,status=1,reject_qty='$b_rej_qty[$key]',update_time='". date('Y-m-d')."' where doc_no='$b_doc_num[$key]' and ops_code='$b_op_id' and size='$b_sizes[$key]' and tran_id=$seqno";
																				//echo $update_emb_bundles;
										$result_query = $link->query($update_emb_bundles) or exit('query error in updating emb_bundles');

										//insert data into emb_bundles_temp
										$insert_emb_bundles="INSERT INTO $bai_pro3.emb_bundles_temp(tid,  doc_no,  size,    ops_code,  barcode,  quantity,  good_qty,  reject_qty,  insert_time,  update_time,  club_status,  log_user,  tran_id,  status) VALUES ('".$tid."','".$b_doc_num[$key]."','".$b_sizes[$key]."','".$b_op_id."','".$barcodeno."','".$orgqty."','".$orgqty."','".$rejectqty."','".date('Y-m-d')."','','".$clubstatus."','".$username."','".$tranid."','".$status."')";
										$result_emb_temp = $link->query($insert_emb_bundles) or exit('error while insert into emb_bundles_temp');
										}
										}
										// else
										// {
										// insert data into emb_bundles

										// }
										if($result_query)
										{
											if($b_rep_qty[$key] > 0)
											{
												$bulk_insert_post_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$embquantity .'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'","'.$b_remarks[$key].'","'.$username.'")';
												$result_query_001_temp = $link->query($bulk_insert_post_temp) or exit('bulk_insert_post query error in updating');

											if($gate_pass_no>0)
											{
											$sql_gate="insert into $brandix_bts.`gatepass_track` (`gate_id`, `bundle_no`, `bundle_qty`, `style`, `schedule`, `color`, `size`,operation_id) values ('".$gate_pass_no."', ".$b_tid[$key].", '".$previously_scanned."', '".$b_style."','".$b_schedule."','".$b_colors[$key]."','".$b_sizes[$key]."','".$b_op_id."-4')";
											$result_sql_temp = $link->query($sql_gate) or exit('Gate_pass_child query error in updating');

											}

												if($emb_cut_check_flag == 1)
												{
													$update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty+$embquantity where doc_no = '".$b_doc_num[$key]."' and size_title='". $b_sizes[$key]."' AND operation_code = $b_op_id";
													$update_qry_cps_log_res = $link->query($update_qry_cps_log);
												}
											}
										}
									   
										if($post_ops_code != null)
										{
											$query_post = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = send_qty+'".$embquantity."', `scanned_date`='". date('Y-m-d')."' where docket_number =$b_doc_num[$key] and size_title='$sizes' and operation_id = ".$post_ops_code;
											$result_query = $link->query($query_post) or exit('query error in updating');
										}
										if($ops_dep)
										{
											$pre_send_qty_qry = "select min(recevied_qty)as recieved_qty from $brandix_bts.bundle_creation_data where bundle_number =$b_tid[$key] and operation_id in (".implode(',',$dep_ops_codes).")";
											$result_pre_send_qty = $link->query($pre_send_qty_qry);
											while($row = $result_pre_send_qty->fetch_assoc())
											{
												$pre_recieved_qty = $row['recieved_qty'];
											}

											$query_post_dep = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` =send_qty+ '".$pre_recieved_qty."', `scanned_date`='". date('Y-m-d')."' where docket_number =$b_doc_num[$key] and size_title='$sizes' and operation_id = ".$ops_dep;

											$result_query = $link->query($query_post_dep) or exit('query error in updating');
								   
										}                
								}
							}
						   
						}
						if($concurrent_flag == 1)
						{
							echo "<h1 style='color:red;'>You are Scanning More than eligible quantity.</h1>";
						}
				}
				else
				{
					$result_array['status'] = 'Already Scanned';
				}
			
			}
        }
       
			//updating into  m3 transactions for positives
			for($i=0;$i<sizeof($b_tid);$i++)
			{
			$updation_m3 = updateM3Transactions($b_tid[$i],$b_op_id,$embquantity);
			}
            $result_array['bundle_no'] = $bundle_no;
            $result_array['op_no'] = $op_no;
            echo json_encode($result_array);
            die();
       
    }
?>