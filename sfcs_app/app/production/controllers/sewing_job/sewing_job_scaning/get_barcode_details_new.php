<?php
    // include("../../../../../common/config/config_ajax.php");
    error_reporting(0);
    $barcode = $_POST['barcode'];
    $shift = $_POST['shift'];
    $bundle_no = explode('-', $barcode)[0];
    $op_no = explode('-', $barcode)[1];
    $emb_cut_check_flag = 0;
    // $status = true;
    $msg = 'Scanned Successfully';


    // $result_array['msg'] = $msg;

    $string = $bundle_no.','.$op_no.','.'0';
    // echo json_encode($result_array);
    // die();
    getjobdetails($string, $bundle_no, $op_no);
    function getjobdetails($job_number, $bundle_no, $op_no)
    {
            error_reporting(0);
            $job_number = explode(",",$job_number);
            //var_dump($job_number);
            $job_number[4]=$job_number[1];
            include("../../../../../common/config/config_ajax.php");
            $column_to_search = $job_number[0];
            $column_in_where_condition = 'input_job_no_random_ref';
            $column_in_pack_summary = 'input_job_no_random';
            // $maped_color = $job_number[3];
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
                
               $map_col_query = "select order_style_no,order_del_no,order_col_des from $bai_pro3.packing_summary_input WHERE input_job_no_random = $job_number[0] order by tid";
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
            $result_array['color_dis'] = $job_number[3];

            $ops_dep_flag = 0;
            // $qry_cut_qty_check_qry = "SELECT act_cut_status FROM $bai_pro3.plandoc_stat_log WHERE doc_no IN (SELECT doc_no FROM $bai_pro3.packing_summary_input WHERE input_job_no_random = '$job_number[0]')";
            // $result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
            //while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
            // {
                // if($row['act_cut_status'] == '')
                // {
                    // $result_array['status'] = 'Cut quantity reporting is not yet done for this docket related to this input job.';
                    // echo json_encode($result_array);
                    // die();
                // }
                
            // }
        $ops_dep_qry = "SELECT ops_dependency,operation_code FROM $brandix_bts.tbl_style_ops_master WHERE style='$job_number[1]' AND color =  '$maped_color' AND ops_dependency != 200 AND ops_dependency != 0";
        // echo json_encode($ops_dep_qry);
        // die();
        $result_ops_dep_qry = $link->query($ops_dep_qry);
        while($row = $result_ops_dep_qry->fetch_assoc()) 
        {
            // echo $ops_dep_qry;
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

            $pre_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' AND ops_sequence = $ops_seq AND CAST(operation_order AS CHAR) < $ops_order and operation_code NOT IN  (10,200) ORDER BY operation_order DESC LIMIT 1";
          //  $result_array['status'] = $pre_ops_check;
            // die();
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
                    else
                    {
                        $schedule_query = "SELECT `style` as order_style_no,`schedule` as order_del_no,`send_qty`,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,`original_qty` as carton_act_qty,`recevied_qty` as reported_qty,`rejected_qty` as rejected_qty,(send_qty-(recevied_qty+rejected_qty)) as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks, mapped_color FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = $column_to_search AND operation_id = '$job_number[4]' order by tid";
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
                        $schedule_query = "SELECT `style` as order_style_no,`schedule` as order_del_no,`send_qty`,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,`original_qty` as carton_act_qty,`recevied_qty` as reported_qty,`rejected_qty` as rejected_qty,(send_qty-(recevied_qty+rejected_qty)) as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks, mapped_color FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = $column_to_search AND operation_id = '$job_number[4]' order by tid";
                        $flags=3;
                        $flag = 'bundle_creation_data';
                    }
                    else
                    {
                        $schedule_query = "SELECT *,carton_act_qty as balance_to_report, 0 as reported_qty, 0 as rejected_qty, 'packing_summary_input' as flag,tid as bundle_number FROM $bai_pro3.packing_summary_input WHERE input_job_no_random = '$job_number[0]' order by tid";
                        $flag = 'packing_summary_input';
                    }
                    // echo $schedule_query;

                } 
            }
            else
            {
                $schedule_count_query = "SELECT input_job_no_random_ref FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = $job_number[0] AND operation_id ='$job_number[4]'";
                // echo $schedule_count_query;
                $schedule_count_query = $link->query($schedule_count_query);
                if($schedule_count_query->num_rows > 0)
                {
                    $schedule_query = "SELECT `style` as order_style_no,`schedule` as order_del_no,`send_qty`,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,`original_qty` as carton_act_qty,`recevied_qty` as reported_qty,`rejected_qty` as rejected_qty,(send_qty-(recevied_qty+rejected_qty)) as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks, mapped_color FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = $column_to_search AND operation_id = '$job_number[4]' order by tid";
                    $flags=3;
                    $flag = 'bundle_creation_data';
                }
                else
                {
                    $schedule_query = "SELECT *,carton_act_qty as balance_to_report, 0 as reported_qty, 0 as rejected_qty, 'packing_summary_input' as flag,tid as bundle_number FROM $bai_pro3.packing_summary_input WHERE input_job_no_random = '$job_number[0]' order by tid";
                    $flag = 'packing_summary_input';
                }
                //echo $schedule_query;
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

            while($row = $result_style_data->fetch_assoc()) 
            {
                if($emb_cut_check_flag == 1 && $bundle_no == $row['bundle_number'])
                {
                    $doc_no = $row['doc_no'];
                    $size = $row['old_size'];
                    $retreving_remaining_qty_qry = "SELECT sum(remaining_qty) as balance_to_report,doc_no FROM $bai_pro3.cps_log WHERE doc_no in ($doc_no) AND size_code='$size' AND operation_code = '$pre_ops_code' group by doc_no";
                    // echo $retreving_remaining_qty_qry.'</br>';
                    // $result_array['status'] = "$retreving_remaining_qty_qry";
                    // die();
                    $result_retreving_remaining_qty_qry = $link->query($retreving_remaining_qty_qry);
                    if($result_retreving_remaining_qty_qry->num_rows > 0)
                    {
                        while($row_remaining = $result_retreving_remaining_qty_qry->fetch_assoc()) 
                        {
                            $sum_balance = $row_remaining['balance_to_report'];
                        }
                    }
                //    echo $sum_balance.'-'.$row['balance_to_report'].'</br>';
                    if($sum_balance < $row['balance_to_report'])
                    {
                        $result_array['status'] = 'Previous operation not yet done for this jobs.';
                        echo json_encode($result_array);
                        die();

                    }
                }
                //echo "worig";
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
                $b_job_no = $row['input_job_no_random'];
                $b_style= $row['order_style_no'];
                $b_schedule=$row['order_del_no'];
                // if($flag == 'bundle_creation_data'){
                //     $b_colors[$key]=$row['mapped_color'];
                // }elseif($flag == 'packing_summary_input'){
                $b_colors[]=$row['order_col_des'];
                // }
                $b_sizes[] = $row['size_code'];
                $b_size_code[] = $row['old_size'];
                $size_ims = $row['size_code'];
                $b_doc_num[]=$row['doc_no'];
                $doc_value = $row['doc_no'];
                $b_in_job_qty[]=$row['carton_act_qty'];
                // if($row['tid'] == $bundle_no){
                $b_rep_qty[]=$row['balance_to_report'];
                // }else{
                //     $b_rep_qty[] = 0;
                // }
                // $b_in_job_qty[]=0;
                $b_rej_qty[]=0;
                $b_op_id = $op_no;
                // $b_op_name = $row['operation_name'];
                $b_tid[] = $row['tid'];
                $b_inp_job_ref[] = $row['input_job_no'];
                $b_a_cut_no[] = $row['acutno'];
                $b_module = '1';
                $b_remarks[] = 'Normal';
                $b_shift = $shift;
                if($flag == 'bundle_creation_data'){
                    $mapped_color = $row['mapped_color'];
                }else{
                    $mapped_color = $row['order_col_des'];
                }
                // $b_old_rep_qty = $row['old_rep_qty'];
                // $b_old_rej_qty = $row['old_rej_qty'];
                $result_array['table_data'][] = $row;
            }
        }
        $result_array['flag'] = $flag;
        // echo json_encode($mapped_color);
        // die();
        // $result_array['tid']    = $b_tid;
        // $result_array['rep_qty']    = $b_rep_qty;
                      
        $select_modudle_qry = "select input_module from $bai_pro3.plan_dashboard_input where input_job_no_random_ref = '$job_number[0]'";
        $result_select_modudle_qry = $link->query($select_modudle_qry);
        
        if(mysqli_num_rows($result_select_modudle_qry)==0)
        {
            $select_modudle_qry1 = "select ims_mod_no as input_module from $bai_pro3.ims_log where input_job_rand_no_ref = '$job_number[0]' limit 1";
            $result_select_modudle_qry = $link->query($select_modudle_qry1);
        }
        if(mysqli_num_rows($result_select_modudle_qry)==0)
        {
            $select_modudle_qry2 = "select ims_mod_no as input_module from $bai_pro3.ims_log_backup where input_job_rand_no_ref = '$job_number[0]' limit 1";
            $result_select_modudle_qry = $link->query($select_modudle_qry2);
        }
        
        while($row = $result_select_modudle_qry->fetch_assoc()) 
        {
            $result_array['module'] = $row['input_module'];
        }
        $b_module = $result_array['module'];
        // echo json_encode($select_modudle_qry1);
        // die();
        // echo $result_array['flag'];
        $table_name = $result_array['flag'];
        
        $style = $result_array['style'];
        $schedule = $result_array['schedule'];
        $color = $result_array['color_dis'];
        $table_data = $result_array['table_data'];

        // var_dump($b_tid);
        // checking ops ..............................................

        $dep_ops_array_qry = "select operation_code,ops_sequence, default_operration,smv from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' and operation_code='$b_op_id'";
        $result_dep_ops_array_qry = $link->query($dep_ops_array_qry);
        while($row = $result_dep_ops_array_qry->fetch_assoc()) 
        {
            //$dep_ops_codes[] = $row['operation_code'];
            $sequnce = $row['ops_sequence'];
            $is_m3 = $row['default_operration'];
            $sfcs_smv = $row['smv'];
        }
        
        $ops_dep_qry = "SELECT ops_dependency,operation_code,ops_sequence FROM $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' and ops_sequence='$sequnce' AND ops_dependency != 200 AND ops_dependency != 0 group by ops_dependency";
        $result_ops_dep_qry = $link->query($ops_dep_qry);
        while($row = $result_ops_dep_qry->fetch_assoc()) 
        {
            $ops_dep = $row['ops_dependency'];
        }
        $dep_ops_array_qry_raw = "select operation_code from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' and ops_dependency='$ops_dep'";
        
        $result_dep_ops_array_qry_raw = $link->query($dep_ops_array_qry_raw);
        while($row = $result_dep_ops_array_qry_raw->fetch_assoc()) 
        {
            $dep_ops_codes[] = $row['operation_code'];	
        }
       
        $ops_seq_check = "select id,ops_sequence from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$mapped_color' and operation_code='$b_op_id'";
        $result_ops_seq_check = $link->query($ops_seq_check);
        while($row = $result_ops_seq_check->fetch_assoc()) 
        {
            $ops_seq = $row['ops_sequence'];
            $seq_id = $row['id'];
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
            $ops_seq_qrs = "select ops_sequence from $brandix_bts.tbl_style_ops_master WHERE style='".$b_style."' AND color = '".$mapped_color."' AND operation_code in (".implode(',',$ops_dep_ary).")";
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
       // echo '1'.$table_name;
        $pre_ops_check = "select operation_code,ops_sequence from $brandix_bts.tbl_style_ops_master where style='".$b_style."' and color = '".$mapped_color."' and (ops_sequence = ".$ops_seq." or ops_sequence in  (".implode(',',$ops_seq_dep)."))";
        // echo $pre_ops_check;
        $result_pre_ops_check = $link->query($pre_ops_check);
        if($result_pre_ops_check->num_rows > 0)
            {
            while($row_ops = $result_pre_ops_check->fetch_assoc()) 
             {
                // if($row['ops_sequence'] != 0)
                // {
                    $pre_ops_code_temp[] = $row_ops['operation_code'];
               // }
            }
        }
    //    echo '2'.$table_name;
        $post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$mapped_color' and ops_sequence = $ops_seq and id > $seq_id order by id limit 1";

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
                $b_query[$op_code] = "INSERT  INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `mapped_color`) VALUES";

                // temp table data query

                $b_query_temp[$op_code] = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`) VALUES";
            }
        }

        $m3_bulk_bundle_insert = "INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_reason,sfcs_remarks,sfcs_log_user,m3_op_code,sfcs_job_no,sfcs_mod_no,sfcs_shift,m3_op_des,sfcs_tid_ref,m3_error_code) VALUES";
        // echo $table_name;
        // insert or update based on table
        if($table_name == 'packing_summary_input')
        {
            // echo "working";
            // (`qms_style`, `qms_schedule`,`qms_color`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`, `remarks`, `doc_no`, `input_job_no`)
            // $result_array['status'] = 'Cut Quantity Reporting Not Yet Done';
            // echo json_encode($result_array);
            // die();        
            $bulk_insert = "INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`,`mapped_color`) VALUES";
            // temp table data insertion query.........
            $bulk_insert_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`) VALUES";


                foreach ($b_tid as $key => $tid)
                {

                    // echo $tid;
                    $smv_query = "select smv from $brandix_bts.tbl_style_ops_master where style='$b_style' and color='$mapped_color' and operation_code = $b_op_id";
                    $result_smv_query = $link->query($smv_query);
                    while($row_ops = $result_smv_query->fetch_assoc()) 
                    {
                        $sfcs_smv = $row_ops['smv'];
                    }
                    // $remarks_code = "";

                    // if($b_rep_qty[$key] == null){
                    //     $b_rep_qty[$key] = 0;
                    // }
                    // if($b_rej_qty[$key] == null){
                    //     $b_rej_qty[$key] = 0;
                    // }
                    $left_over_qty = $b_in_job_qty[$key] - ($b_rep_qty[$key] + $b_rej_qty[$key]);
                    // // appending all values to query for bulk insert....

                    // if($r_qty[$tid] != null && $r_reasons[$tid] != null)
                    // {
                    //     $r_qty_array = explode(',',$r_qty[$tid]);
                    //     $r_reasons_array = explode(',',$r_reasons[$tid]);

                    //     foreach ($r_qty_array as $index => $r_qnty) 
                    //     {
                    //         //m3 operations............. 
                    //         $m3_bulk_bundle_insert .= '("'.date('Y-m-d').'","'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'. $b_size_code[$key].'","'. $b_sizes[$key].'","'.$b_doc_num[$key].'","'.$r_qty_array[$index].'","'.$r_reasons_array[$index].'","'.$b_remarks[$key].'",USER(),"'. $b_op_id.'","'.$b_inp_job_ref[$key].'","'.$b_module.'","'.$b_shift.'","'.$b_op_name.'","'.$b_tid[$key].'",""),';
                    //         $rejection_code_fetech_qry = "select reason_code from $bai_pro3.bai_qms_rejection_reason where m3_reason_code= '$r_reasons_array[$index]'";
                    //         //echo $rejection_code_fetech_qry;
                    //         $result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
                    //         while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
                    //         {
                    //             $reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
                    //         }
                    //         if($index == sizeof($r_qty_array)-1){
                    //             $remarks_code .= $reason_code.'-'.$r_qnty;
                    //         }else {
                    //             $remarks_code .= $reason_code.'-'.$r_qnty.'$';
                    //         }
                    //     }
                    // }		
                    // // (`qms_style`, `qms_schedule`,`qms_color`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`, `remarks`, `doc_no`, `input_job_no`)
                    if($tid == $bundle_no){
                        $b_rep_qty[$key] = $b_in_job_qty[$key];
                    }else{
                        $b_rep_qty[$key] = 0;
                    }
                    $bulk_insert .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$b_remarks[$key].'","'.$mapped_color.'"),';

                    // // temp table data insertion query.........
                    if($b_rep_qty[$key] > 0 )
                    {
                        $bulk_insert_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$b_remarks[$key].'"),';
                    }
                    // //m3 operations............. 
                    if($b_rep_qty[$key] > 0) {
                        $m3_bulk_bundle_insert .= '("'.date('Y-m-d').'","'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'.$b_doc_num[$key].'","'.$b_rep_qty[$key].'","","'.$b_remarks[$key].'",USER(),"'. $b_op_id.'","'.$b_inp_job_ref[$key].'","'.$b_module.'","'.$b_shift.'","'.$b_op_name.'","'.$b_tid[$key].'",""),';
                        $flag_decision = true;
                    }
                    $count = 1;
                    foreach($pre_ops_code_temp as $index => $op_code)
                    {
                        //echo $op_code."<br>";
                        //echo $b_op_id;
                        if($op_code != $b_op_id)
                        {
                            
                            $dep_check_query = "SELECT * from $brandix_bts.bundle_creation_data where bundle_number = $b_tid[$key] and operation_id = $op_code";
                            //echo $dep_check_query;
                            $dep_check_result = $link->query($dep_check_query) or exit('dep_check_query error');
                            if(mysqli_num_rows($dep_check_result) <= 0){
                            //change values here in query....
                                $send_qty = $b_rep_qty[$key];
                                $rec_qty = 0;
                                $rej_qty = 0;
                                $b_query[$op_code] .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$send_qty.'","'.$rec_qty.'","'.$rej_qty.'","'.$left_over_qty.'","'. $op_code.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$b_remarks[$key].'","'.$mapped_color.'"),';

                                $b_query_temp[$op_code] .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$send_qty.'","'.$rec_qty.'","'.$rej_qty.'","'.$left_over_qty.'","'. $op_code.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'"),';
                                $count++;
                            }
                        }
                    }
                }

            foreach($b_query as $index1 => $query){
                if(substr($query, -1) == ','){
                    $final_query_001 = substr($query, 0, -1);
                }else{
                    $final_query_001 = $query;
                }
                //echo $final_query_001;
                $bundle_creation_result_001 = $link->query($final_query_001);
            }
            if(substr($bulk_insert, -1) == ','){
                $final_query_000 = substr($bulk_insert, 0, -1);
            }else{
                $final_query_000 = $bulk_insert;
            }
            // echo $bulk_insert.'<br>';
            $bundle_creation_result = $link->query($final_query_000);
            // temp tables data insertion query execution..........
            if(substr($bulk_insert_temp, -1) == ','){
                $final_query_000_temp = substr($bulk_insert_temp, 0, -1);
            }else{
                $final_query_000_temp = $bulk_insert_temp;
            }
            //echo $bulk_insert.'<br>';
            $bundle_creation_result_temp = $link->query($final_query_000_temp);
            //$bundle_creation_post_result = $link->query($bulk_insert_post);
            //echo $m3_bulk_bundle_insert;
            
            if(strtolower($is_m3) == 'yes' && $flag_decision){
                if(substr($m3_bulk_bundle_insert, -1) == ','){
                    $final_query100 = substr($m3_bulk_bundle_insert, 0, -1);
                }else{
                    $final_query100 = $m3_bulk_bundle_insert;
                }
                //echo $final_query100;
                // die();
                $rej_insert_result100 = $link->query($final_query100) or exit('data error');
            }
            $sql_message = 'Data inserted successfully';
                    //all operation codes query.. (not tested)
        }else{
            $query = '';

            if($table_name == 'bundle_creation_data')
            {
                $bulk_insert_rej = "INSERT INTO $bai_pro3.bai_qms_db(`qms_style`, `qms_schedule`,`qms_color`,`log_user`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`,`remarks`, `ref1`, `doc_no`, `input_job_no`, `operation_id`, `qms_remarks`, `bundle_no`) VALUES";

                $schedule_count_query = "SELECT input_job_no_random_ref FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = $b_job_no AND operation_id ='$b_op_id'";

                // echo $schedule_count_query.'<br>';
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
                        // $select_send_qty = "SELECT send_qty,recevied_qty,rejected_qty FROM $brandix_bts.bundle_creation_data WHERE bundle_number = '$b_tid[$key]' AND operation_id = '$b_op_id'";
                        // $result_select_send_qty = $link->query($select_send_qty);
                        // if($result_select_send_qty->num_rows >0)
                        // {
                        //     while($row = $result_select_send_qty->fetch_assoc()) 
                        //     {
                        //         $send_qty = $row['send_qty'];
                        //         $pre_recieved_qty = $row['recevied_qty'];
                        //         $rejected_qty = $row['rejected_qty'];
                        //         $act_reciving_qty = $b_rep_qty[$key]+$b_rej_qty[$key];
                        //         $total_rec_qty = $pre_recieved_qty + $act_reciving_qty+$rejected_qty;
                        //         //echo "bcd=".$total_rec_qty."-".$send_qty."</br>";
                        //         if($total_rec_qty > $send_qty)
                        //         {
                        //             $concurrent_flag = 1;
                        //         }
                        //         else
                        //         {
                        //             $rec_qty_from_temp = "select (sum(recevied_qty)+sum(rejected_qty))as recevied_qty FROM $brandix_bts.bundle_creation_data_temp WHERE bundle_number = '$b_tid[$key]' AND operation_id = '$b_op_id'";
                        //             //echo $rec_qty_from_temp;
                        //             $result_rec_qty_from_temp = $link->query($rec_qty_from_temp);
                        //             while($row_temp = $result_rec_qty_from_temp->fetch_assoc()) 
                        //             {
                        //                 $pre_recieved_qty_temp = $row_temp['recevied_qty'];
                        //                 $act_reciving_qty_temp = $b_rep_qty[$key]+$b_rej_qty[$key];
                        //             //	echo "bcdtemp=".$act_reciving_qty_temp."-".$send_qty."</br>";
                        //                 if($act_reciving_qty_temp > $send_qty)
                        //                 {
                        //                     $concurrent_flag = 1;
                        //                 }
                        //             }

                        //         }
                        //     }
                        // }
                        if($concurrent_flag == 0)
                        {
                            $smv_query = "select smv from $brandix_bts.tbl_style_ops_master where style='$b_style' and color='$mapped_color' and operation_code = $b_op_id";
                            $result_smv_query = $link->query($smv_query);
                            while($row_ops = $result_smv_query->fetch_assoc()) 
                            {
                                $sfcs_smv = $row_ops['smv'];
                            }
                            $bulk_insert_post = "INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`) VALUES";

                            $bulk_insert_post_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`) VALUES";

                            $remarks_code = "";
                            // echo $tid.'<br>';
                            // if($b_rep_qty[$key] == null){
                            //     $b_rep_qty[$key] = 0;
                            // }
                            // if($b_rej_qty[$key] == null){
                            //     $b_rej_qty[$key] = 0;
                            // }
                            // $left_over_qty = $b_in_job_qty[$key] - ($b_rep_qty[$key] + $b_rej_qty[$key]);
                            // appending all values to query for bulk insert....

                            // if($r_qty[$tid] != null && $r_reasons[$tid] != null){
                            //     $r_qty_array = explode(',',$r_qty[$tid]);
                            //     $r_reasons_array = explode(',',$r_reasons[$tid]);
                            //     if(sizeof($r_qty_array)>0)
                            //     {
                            //         $flag_decision = true;
                            //     }
                            //     foreach ($r_qty_array as $index => $r_qnty) {
                            //         //m3 operations............. 
                            //         $m3_bulk_bundle_insert .= '("'.date('Y-m-d').'","'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'. $b_size_code[$key].'","'. $b_sizes[$key].'","'.$b_doc_num[$key].'","'.$r_qty_array[$index].'","'.$r_reasons_array[$index].'","'.$b_remarks[$key].'",USER(),"'. $b_op_id.'","'.$b_inp_job_ref[$key].'","'.$b_module.'","'.$b_shift.'","'.$b_op_name.'","'.$b_tid[$key].'",""),';
                            //         $rejection_code_fetech_qry = "select reason_code from $bai_pro3.bai_qms_rejection_reason where m3_reason_code= '$r_reasons_array[$index]'";
                            //     //echo $rejection_code_fetech_qry;
                            //         $result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
                            //         while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
                            //         {
                            //             $reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
                            //         }
                            //         if($index == sizeof($r_qty_array)-1){
                            //             $remarks_code .= $reason_code.'-'.$r_qnty;
                            //         }else {
                            //             $remarks_code .= $reason_code.'-'.$r_qnty.'$';
                            //         }
                            //     }
                            // }	
                            $select_send_qty = "SELECT send_qty, recevied_qty,rejected_qty, left_over FROM $brandix_bts.bundle_creation_data WHERE bundle_number = '$b_tid[$key]' AND operation_id = '$b_op_id'";
                            //echo "sele".$select_send_qty;
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
                                    $query = "UPDATE $brandix_bts.bundle_creation_data SET `recevied_qty`= '".$final_rep_qty."', `left_over`= '".$left_over_qty_update."' , `scanned_date`='". date('Y-m-d')."' where bundle_number ='".$b_tid[$key]."' and operation_id = ".$b_op_id;
                                    
                                    $result_query = $link->query($query) or exit('query error in updating');
                                }else{
                                     
                                    $bulk_insert_post .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'")';	
                                    $result_query_001 = $link->query($bulk_insert_post) or exit('bulk_insert_post query error in updating');
                                }
                                //m3 operations............. 
                                if($b_rep_qty[$key] > 0){
                                    $m3_bulk_bundle_insert .= '("'.date('Y-m-d').'","'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'. $b_size_code[$key].'","'. $b_sizes[$key].'","'.$b_doc_num[$key].'","'.$previously_scanned.'","","'.$b_remarks[$key].'",USER(),"'. $b_op_id.'","'.$b_inp_job_ref[$key].'","'.$b_module.'","'.$b_shift.'","'.$b_op_name.'","'.$b_tid[$key].'",""),';
                                    $flag_decision = true;
                                }
                                if($result_query)
                                {
                                    if($b_rep_qty[$key] > 0)
                                    {
                                        $bulk_insert_post_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$previously_scanned .'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$b_remarks[$key].'")';	
                                        $result_query_001_temp = $link->query($bulk_insert_post_temp) or exit('bulk_insert_post query error in updating');
                                    }
                                }	
                                
                                if($post_ops_code != null)
                                {
                                    $query_post = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$final_rep_qty."', `scanned_date`='". date('Y-m-d')."' where bundle_number ='".$b_tid[$key]."' and operation_id = ".$post_ops_code;
                                    $result_query = $link->query($query_post) or exit('query error in updating');
                                }
                                if($ops_dep)
                                {
                                    $pre_send_qty_qry = "select min(recevied_qty)as recieved_qty from $brandix_bts.bundle_creation_data where bundle_number ='".$b_tid[$key]."' and operation_id in (".implode(',',$dep_ops_codes).")";
                                    //echo $pre_send_qty_qry;
                                    $result_pre_send_qty = $link->query($pre_send_qty_qry);
                                    while($row = $result_pre_send_qty->fetch_assoc()) 
                                    {
                                        $pre_recieved_qty = $row['recieved_qty'];
                                    }

                                    $query_post_dep = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$pre_recieved_qty."', `scanned_date`='". date('Y-m-d')."' where bundle_number ='".$b_tid[$key]."' and operation_id = ".$ops_dep;

                                    $result_query = $link->query($query_post_dep) or exit('query error in updating');
                            
                                }
                        // }				 
                                
                            // }
                            // if($r_qty[$tid] != null && $r_reasons[$tid] != null){
                            //     $bulk_insert_rej .= '("'.$b_style.'","'.$b_schedule.'","'.$b_colors[$key].'",user(),"'.date('Y-m-d').'","'.$b_sizes[$key].'","'.$b_rej_qty[$key].'","3","'.$remarks_var.'","'.$remarks_code.'","'.$b_doc_num[$key].'","'.$b_job_no.'","'. $b_op_id.'","'. $b_remarks[$key].'","'.$b_tid[$key].'"),';
                            //     $reason_flag = true;
                            // }
                        }
                    }
                    
                }
                if($concurrent_flag == 1)
                {
                    echo "<h1 style='color:red;'>You are Scanning More than eligible quantity.</h1>";
                }
                if($concurrent_flag == 0)
                {
                    if($reason_flag)
                    {
                        if(substr($bulk_insert_rej, -1) == ',')
                        {
                            $final_query = substr($bulk_insert_rej, 0, -1);
                        }
                        else
                        {
                            $final_query = $bulk_insert_rej;
                        }
                        //echo $final_query;
                        $rej_insert_result = $link->query($final_query) or exit('data error');
                    }
                    if(strtolower($is_m3) == 'yes' && $flag_decision)
                    {
                        if(substr($m3_bulk_bundle_insert, -1) == ',')
                        {
                            $final_query100 = substr($m3_bulk_bundle_insert, 0, -1);
                        }
                        else
                        {
                            $final_query100 = $m3_bulk_bundle_insert;
                        }
                        // echo $final_query100;;
                        $rej_insert_result100 = $link->query($final_query100) or exit('data error');
                    }
                }
                    // $sql_message = 'Data Updated Successfully';
            }	
        }
        if($concurrent_flag == 0)
        {
            $rep_sum_qty = array_sum($b_rep_qty);
            $tod_date = date('Y-m-d');
            $cur_hour = date('H:00');
            $cur_h = date('H');
            $hout_ops_qry = "SELECT operation_code from $brandix_bts.tbl_ims_ops where appilication='Down_Time'";

            $hout_ops_result = $link->query($hout_ops_qry);

			if($hout_ops_result->num_rows > 0)
			{
				while($hout_ops_result_data = $hout_ops_result->fetch_assoc()) 
				{
					$hout_ops_code = $hout_ops_result_data['operation_code'];
				}

				
				if($b_op_id == $hout_ops_code){
					$hout_data_qry = "select * from $bai_pro2.hout where out_date = '$tod_date' and left(out_time,2) = '$cur_h' and team = '$b_module'";
					// echo $hout_data_qry;
					$hout_data_result = $link->query($hout_data_qry);

					if($hout_data_result->num_rows > 0)
					{
						while($hout_result_data = $hout_data_result->fetch_assoc()) 
						{
							$row_id = $hout_result_data['id'];
							$hout_date = $hout_result_data['out_date'];
							$out_time = $hout_result_data['out_time'];
							$team = $hout_result_data['team'];
							$qty = $hout_result_data['qty'];
						}
						$upd_qty = $qty + $rep_sum_qty;
						$hout_update_qry = "update $bai_pro2.hout set qty = '$upd_qty' where id= $row_id";
						$hout_update_result = $link->query($hout_update_qry);
						// update
					}else{
						$hout_insert_qry = "insert into $bai_pro2.hout(out_date, out_time, team, qty, status, remarks) values('$tod_date','$cur_hour','$b_module','$rep_sum_qty', '1', 'NA')";
						$hout_insert_result = $link->query($hout_insert_qry);
						// insert
					}
				}
			}
            // $table_data = "<table class='table table-bordered'><tr><th>Input Job</th><th>Bundle Number</th><th>Color</th><th>Size</th><th>Remarks</th><th>Reporting Qty</th><th>Rejecting Qty</th></tr>";
            $checking_output_ops_code = "SELECT operation_code FROM $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color='$mapped_color' AND ops_dependency >= 130 AND ops_dependency < 200";
            //echo $checking_output_ops_code;
            $result_checking_output_ops_code = $link->query($checking_output_ops_code);
            if($result_checking_output_ops_code->num_rows > 0)
            {
                while($row_result_checking_output_ops_code = $result_checking_output_ops_code->fetch_assoc()) 
                {
                   $output_ops_code = $row_result_checking_output_ops_code['operation_code'];
                }
            }
            else
            {
                $output_ops_code = 130;
            }
            for($i=0;$i<sizeof($b_tid);$i++)
            {
                if($emb_cut_check_flag != 1)
                {
                    $update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty-($b_rep_qty[$i] + $b_rej_qty[$i]) where doc_no = $doc_value and size_title='$size_ims' AND operation_code = '$pre_ops_code'";
                    $update_qry_cps_log_res = $link->query($update_qry_cps_log);
                }
                if($b_tid[$i] == $bundle_no){
                    if($b_op_id == 100 || $b_op_id == 129)
                    {
                        //Searching whethere the operation was present in the ims log and ims buff
                        $searching_query_in_imslog = "SELECT * FROM $bai_pro3.ims_log WHERE pac_tid = '$b_tid[$i]' AND ims_mod_no='$b_module' AND ims_style='$b_style' AND ims_schedule='$b_schedule' AND ims_color='$b_colors[$key]' AND input_job_rand_no_ref='$b_job_no' AND operation_id='$b_op_id' AND ims_remarks = '$b_remarks[$i]'";
                        //echo $searching_query_in_imslog;
                        $result_searching_query_in_imslog = $link->query($searching_query_in_imslog);
                        if($result_searching_query_in_imslog->num_rows > 0)
                        {
                            while($row = $result_searching_query_in_imslog->fetch_assoc()) 
                            {
                                $updatable_id = $row['tid'];
                                $pre_ims_qty = $row['ims_qty'];
                            }
                            $act_ims_qty = $pre_ims_qty + $b_rep_qty[$i];
                            //updating the ims_qty when it was there in ims_log
                            $update_query = "update $bai_pro3.ims_log set ims_qty = $act_ims_qty where tid = $updatable_id";
                            mysqli_query($link,$update_query) or exit("While updating ims_qty in ims_log".mysqli_error($GLOBALS["___mysqli_ston"]));
                        }
                        else
                        {
                            //$ims_date=date('Y-m-d', strtotime($ims_log_date);
                            $cat_ref=0;
                            $catrefd_qry="select * FROM $bai_pro3.plandoc_stat_log WHERE order_tid in (select order_tid FROM bai_pro3.bai_orders_db WHERE order_style_no='$b_style' AND order_del_no='$b_schedule' AND order_col_des='$b_colors[$key]')";
                            // echo "<br>Cat Qry :".$catrefd_qry."</br>";
                            $catrefd_qry_result=mysqli_query($link,$catrefd_qry);
                            while($buyer_qry_row=mysqli_fetch_array($catrefd_qry_result))
                            {
                                $cat_ref=$buyer_qry_row['cat_ref'];
                            }
                            $sizevalue="a_".$b_size_code[$i];
                            $bundle_op_id=$b_tid[$i]."-".$b_op_id."-".$b_inp_job_ref[$i].'-'.$b_remarks[$i];
                            $ims_log_date=date("Y-m-d");
                            if($b_rep_qty[$i] > 0)
                            {
                                $insert_imslog="insert into $bai_pro3.ims_log (ims_date,ims_cid,ims_doc_no,ims_mod_no,ims_shift,
                                ims_size,ims_qty,ims_log_date,ims_style,ims_schedule,ims_color,rand_track,bai_pro_ref,input_job_rand_no_ref,input_job_no_ref,pac_tid,ims_remarks,operation_id) values ('".$ims_log_date."','".$cat_ref."','".$b_doc_num[$i]."','".$b_module."','".$b_shift."','".trim($sizevalue)."','".$b_rep_qty[$i]."',CURRENT_TIMESTAMP(),'".$b_style."','".$b_schedule."','".$b_colors[$key]."','$b_doc_num[$i]','$bundle_op_id','".$b_job_no."','".$b_inp_job_ref[$i]."','".$b_tid[$i]."','".$b_remarks[$i]."','".$b_op_id."')";
                                //echo "Insert Ims log :".$insert_imslog."</br>";
                                $qry_status=mysqli_query($link,$insert_imslog);
                            }
                            
                            
                        }
                    
                    }
                    elseif($b_op_id == $output_ops_code)
                    {
                        //getting input ops code from output ops with operation sequence
                        $selecting_output_from_seq_query = "select operation_code from $brandix_bts.tbl_style_ops_master where ops_sequence = $ops_seq and operation_code != $b_op_id and style='$b_style' and color = '$mapped_color'";
                        $result_selecting_output_from_seq_query = $link->query($selecting_output_from_seq_query);
                        if($result_selecting_output_from_seq_query->num_rows > 0)
                        {
                            while($row = $result_selecting_output_from_seq_query->fetch_assoc()) 
                            {
                                $input_ops_code = $row['operation_code'];
                            }
                        }
                        else
                        {
                            $input_ops_code = 129;
                        }
                        if($input_ops_code == 100 || $input_ops_code == 129)
                        {
                            //updating ims_pro_qty against the input
                            $searching_query_in_imslog = "SELECT * FROM $bai_pro3.ims_log WHERE pac_tid = '$b_tid[$i]' AND ims_mod_no='$b_module' AND ims_style='$b_style' AND ims_schedule='$b_schedule' AND ims_color='$b_colors[$key]' AND input_job_rand_no_ref='$b_job_no' AND operation_id='$input_ops_code' AND ims_remarks = '$b_remarks[$i]'";
                            $result_searching_query_in_imslog = $link->query($searching_query_in_imslog);
                            if($result_searching_query_in_imslog->num_rows > 0)
                            {
                                while($row = $result_searching_query_in_imslog->fetch_assoc()) 
                                {
                                    $updatable_id = $row['tid'];
                                    $pre_ims_qty = $row['ims_pro_qty'];
                                    $act_ims_input_qty = $row['ims_qty'];
                                }
                                $act_ims_qty = $pre_ims_qty + $b_rep_qty[$i] ;
                                //updating the ims_qty when it was there in ims_log
                                $update_query = "update $bai_pro3.ims_log set ims_pro_qty = $act_ims_qty where tid = $updatable_id";
                                $ims_pro_qty_updating = mysqli_query($link,$update_query) or exit("While updating ims_pro_qty in ims_log".mysqli_error($GLOBALS["___mysqli_ston"]));
                                if($ims_pro_qty_updating)
                                {
                                    if($act_ims_input_qty == $act_ims_qty)
                                    {
                                        $update_status_query = "update $bai_pro3.ims_log set ims_status = 'DONE' where tid = $updatable_id";
                                        mysqli_query($link,$update_status_query) or exit("While updating status in ims_log".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $ims_backup="insert into $bai_pro3.ims_log_backup select * from bai_pro3.ims_log where tid=$updatable_id";
                                        mysqli_query($link,$ims_backup) or exit("Error while inserting into ims_backup".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $ims_delete="delete from $bai_pro3.ims_log where tid=$updatable_id";
                                        mysqli_query($link,$ims_delete) or exit("While De".mysqli_error($GLOBALS["___mysqli_ston"]));
                    
                                    }
                                }
                            }
                        }
                    }
                    //inserting bai_log and bai_log_buff
                    $sizevalue="size_".$b_size_code[$i];
                    $sections_qry="select sec_id,sec_head FROM $bai_pro3.sections_db WHERE sec_id>0 AND  sec_mods LIKE '%,".$b_module.",%' OR  sec_mods LIKE '".$b_module.",%' LIMIT 0,1";
                    //echo $sections_qry;
                    $sections_qry_result=mysqli_query($link,$sections_qry) or exit("Bundles Query Error15".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($buyer_qry_row=mysqli_fetch_array($sections_qry_result)){
                            $sec_head=$buyer_qry_row['sec_id'];
                    }
                    $ims_log_date=date("Y-m-d");
                    $bac_dat=$ims_log_date;
                    $log_time=date("Y-m-d");
                    $buyer_qry="select order_div FROM $bai_pro3.bai_orders_db WHERE order_style_no='".$b_style."' AND order_del_no='".$b_schedule."' AND order_col_des='".$b_colors[$key]."'";
                    $buyer_qry_result=mysqli_query($link,$buyer_qry) or exit("Bundles Query Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($buyer_qry_row=mysqli_fetch_array($buyer_qry_result)){
                            $buyer_div=str_replace("'","",(str_replace('"',"",$buyer_qry_row['order_div'])));
                        }
                    $qry_nop="select avail_A,avail_B FROM $bai_pro.pro_atten WHERE module='".$b_module."' AND date='$bac_dat'";
                        $qry_nop_result=mysqli_query($link,$qry_nop) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($nop_qry_row=mysqli_fetch_array($qry_nop_result)){
                                $avail_A=$nop_qry_row['avail_A'];
                                $avail_B=$nop_qry_row['avail_B'];
                        }
                        if(mysqli_num_rows($qry_nop_result)>0){
                            if($row['shift']=='A'){
                                $nop=$avail_A;
                            }else{
                                $nop=$avail_B;
                            }
                        }else{
                            $nop=0;
                        }
                    $bundle_op_id=$b_tid[$i]."-".$b_op_id."-".$b_inp_job_ref[$i];
                    if($b_op_id == 130 || $b_op_id == 101)
                    {
                        $insert_bailog="insert into $bai_pro.bai_log (bac_no,bac_sec,bac_Qty,bac_lastup,bac_date,
                        bac_shift,bac_style,bac_stat,log_time,buyer,delivery,color,loguser,ims_doc_no,smv,".$sizevalue.",ims_table_name,ims_tid,nop,ims_pro_ref,ope_code,jobno
                        ) values ('".$b_module."','".$sec_head."','".$b_rep_qty[$i]."',DATE_FORMAT(NOW(), '%Y-%m-%d %H'),'".$bac_dat."','".$b_shift."','".$b_style."','Active','".$log_time."','".$buyer_div."','".$b_schedule."','".$b_colors[$key]."',USER(),'".$b_doc_num[$i]."','".$sfcs_smv."','".$b_rep_qty[$i]."','ims_log','".$b_op_id."','".$nop."','".$bundle_op_id."','".$b_op_id."','".$b_inp_job_ref[$i]."')";
                        //echo "Bai log : ".$insert_bailog."</br>";
                        if($b_rep_qty[$i] > 0)
                        {
                            $qry_status=mysqli_query($link,$insert_bailog) or exit("BAI Log Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                        }
                        if($qry_status)
                        {
                            //echo "Inserted into bai_log table successfully<br>";
                            /*Insert same data into bai_pro.bai_log_buf table*/
                            $insert_bailogbuf="insert into $bai_pro.bai_log_buf(bac_no,bac_sec,bac_Qty,bac_lastup,bac_date,
                            bac_shift,bac_style,bac_stat,log_time,buyer,delivery,color,loguser,ims_doc_no,smv,".$sizevalue.",ims_table_name,ims_tid,nop,ims_pro_ref,ope_code,jobno
                            ) values ('".$b_module."','".$sec_head."','".$b_rep_qty[$i]."',DATE_FORMAT(NOW(), '%Y-%m-%d %H'),'".$bac_dat."','".$b_shift."','".$b_style."','Active','".$log_time."','".$buyer_div."','".$b_schedule."','".$b_colors[$key]."',USER(),'".$b_doc_num[$i]."','".$sfcs_smv."','".$b_rep_qty[$i]."','ims_log','".$b_op_id."','".$nop."','".$b_op_id."','".$b_op_id."','".$b_inp_job_ref[$i]."')";
                            //echo "</br>Insert Bailog buf: ".$insert_bailogbuf."</br>";
                            if($b_rep_qty[$i] > 0)
                            {
                                $qrybuf_status=mysqli_query($link,$insert_bailogbuf) or exit("BAI Log Buf Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                            }
                        }
                    }			
                    if($b_rep_qty[$i] > 0 || $b_rej_qty[$i] > 0)
                    {
                        $size = strtoupper($b_sizes[$i]);
                        $result_array['reported_qty'] = $b_rep_qty[$i];
                        $result_array['size'] = $size;

                        // $table_data .= "<tr><td>$b_inp_job_ref[$i]</td><td>$b_tid[$i]</td><td>$b_colors[$key]</td><td>$size</td><td>$b_remarks[$i]</td><td>$b_rep_qty[$i]</td><td>$b_rej_qty[$i]</td></tr>";
                    }
                }
            }
            // $table_data .= "</table>";
            $result_array['bundle_no'] = $bundle_no;
            $result_array['op_no'] = $op_no;
            echo json_encode($result_array);
            die();
        }
    }
?>