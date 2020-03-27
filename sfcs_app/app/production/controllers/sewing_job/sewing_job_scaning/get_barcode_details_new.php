<?php 
    error_reporting(0);
    include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
    include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions_dashboard.php");
    include 'functions_scanning_ij.php';

    $barcode = $_POST['barcode'];
    $shift = $_POST['shift'];
    $gate_id = $_POST['gate_id'];
    $user_permission = $_POST['auth'];
    $has_permission = json_decode($_POST['has_permission'],true);
    $b_shift = $shift;

    //changing for #978 cr
    $barcode_number = explode('-', $barcode)[0];
    $op_no = explode('-', $barcode)[1];

    //auth
    $good_report = 0;

    if($op_no != '') {
        $access_report = $op_no.'-G';

        $access_qry=" select * from $central_administration_sfcs.rbac_permission where permission_name = '$access_report' and status='active'";

        // echo $access_qry;
        $result = $link->query($access_qry);
        
        if($result->num_rows > 0){
    
            if (in_array($$access_report,$has_permission))
            {
                $good_report = 0;
            }
            else
            {
                // good cant be report as it opcode-Good is assigned in user permission for this screen
                $good_report = 1;
            }
        } else {
            $good_report = 0;
        }
    } else {
        $good_report = 0;
    }
  


   
    
    //retriving original bundle_number from this barcode
    $selct_qry = "SELECT bundle_number FROM $brandix_bts.bundle_creation_data 
    WHERE barcode_number = $barcode_number";
    $selct_qry_result=mysqli_query($link,$selct_qry) or exit("while retriving bundle_number".mysqli_error($GLOBALS["___mysqli_ston"]));
    if($selct_qry_result->num_rows > 0)
    {
        while($selct_qry_result_row=mysqli_fetch_array($selct_qry_result))
        {
            $bundle_no = $selct_qry_result_row['bundle_number'];
        }
    }
    else
    {
        $bundle_no = explode('-', $barcode)[0];
    }

    $selecting_style_schedule_color_qry = "select order_style_no,order_del_no,input_job_no from $bai_pro3.packing_summary_input WHERE tid=$bundle_no ORDER BY tid";
    $result_selecting_style_schedule_color_qry = $link->query($selecting_style_schedule_color_qry);
    if($result_selecting_style_schedule_color_qry->num_rows > 0)
    {
        while($row = $result_selecting_style_schedule_color_qry->fetch_assoc()) 
        {
            $style= $row['order_style_no'];
            $schedule= $row['order_del_no'];
            $input_job_no= $row['input_job_no'];
        }
    }
    else
    {
        $result_array['status'] = 'Invalid Input. Please Check And Try Again !!!';
        echo json_encode($result_array);
        die();  
    }
    $short_ship_status=0;
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
    $query_jobs_deactive = "select * from bai_pro3.job_deactive_log where remove_type ='3' and style='".$style."' and schedule ='".$schedule."' and input_job_no='".$input_job_no."'";
    $jobs_deactive_res = mysqli_query($link,$query_jobs_deactive);
    $count_jobs_deactive = mysqli_num_rows($jobs_deactive_res);
    if($count_jobs_deactive >0) {
        while($row_set1=mysqli_fetch_array($jobs_deactive_res))
        {
            if($row_set1['remove_type']==3) {
                $short_ship_status=3;
            }
        }
    }
    
    //ends on #978
    $emb_cut_check_flag = 0;
    $msg = 'Scanned Successfully';

    $string = $bundle_no.','.$op_no.','.'0';
    //getting categry from operation_master 
    $checking_qry = "SELECT category FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code = '$op_no'";
    $result_checking_qry = $link->query($checking_qry);
    while($row_cat = $result_checking_qry->fetch_assoc()) 
    {
        $category_act = $row_cat['category'];
    }
    if($category_act != 'sewing')
    {
        $result_array['status'] = 'Invalid opeartion!!! You can only scan Sewing operatinos here';
        echo json_encode($result_array);
        die();
    }
    else
    {
        // [module,bundle_no,op_code,screen,scan_type]
        $stri = "0,$bundle_no,$op_no,wout_keystroke,0";
        $ret = validating_with_module($stri);
        // 5 = Trims not issued to Module, 4 = No module for sewing job, 3 = No valid Block Priotities, 2 = check for user access (block priorities), 0 = allow for scanning
        if($good_report == 1) {
            $result_array['status'] = 'You are Not Authorized to report Bundle';
            echo json_encode($result_array);
            die();
        }
        else if($short_ship_status==1){
             $result_array['status'] = 'Short Shipment Done Temporarly';
            echo json_encode($result_array);
            die();
        }
        else if ($short_ship_status==2) {
            $result_array['status'] = 'Short Shipment Done Permanently';
            echo json_encode($result_array);
            die();
        }
        else if ($short_ship_status==3) {
            $result_array['status'] = 'Sewing Job is Deactivated';
            echo json_encode($result_array);
            die();
        }
        else if ($ret == 5) {
            $result_array['status'] = 'Trims Not Issued';
            echo json_encode($result_array);
            die();
        } else if ($ret == 4) {
            $result_array['status'] = 'No module for Bundle';
            echo json_encode($result_array);
            die();
        } else if ($ret == 3) {
            $result_array['status'] = 'No valid Block Priotities';
            echo json_encode($result_array);
            die();
        } else if ($ret == 2) {
            if ($user_permission == 'authorized') {
                getjobdetails1($string, $bundle_no, $op_no, $shift ,$gate_id);
            } else {
                $result_array['status'] = 'You are Not Authorized to report more than Block Priorities';
                echo json_encode($result_array);
                die();
            }
        } else if ($ret == 0) {
            getjobdetails1($string, $bundle_no, $op_no, $shift ,$gate_id);
        }        
    }    
    function getjobdetails1($job_number, $bundle_no, $op_no, $shift ,$gate_id)
    {
        error_reporting(0);
        $job_number = explode(",",$job_number);
        $job_number[4]=$job_number[1];
        $gate_pass_no=$gate_id;
        include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
        include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/m3Updations.php");
        
        $column_to_search = $job_number[0];
        $column_in_where_condition = 'input_job_no_random_ref';
        $column_in_pack_summary = 'input_job_no_random';
        if($job_number[2] == 0)
        {
            $column_in_where_condition = 'bundle_number';
            $column_to_search = $job_number[0];
            $column_in_pack_summary = 'tid';
            $fetching_job_number_from_bundle = "select input_job_no_random FROM $bai_pro3.packing_summary_input where tid=$job_number[0]";
            $result_fetching_job_number_from_bundle = $link->query($fetching_job_number_from_bundle);
            while($row = $result_fetching_job_number_from_bundle->fetch_assoc()) 
            {
                $job_number[0] = $row['input_job_no_random'];
            }
            
           $map_col_query = "select order_style_no,order_del_no,order_col_des from $bai_pro3.packing_summary_input WHERE input_job_no_random = '$job_number[0]' order by tid";
            $result_map_col_query = $link->query($map_col_query);
            if($result_map_col_query->num_rows > 0)
            {
                while($row = $result_map_col_query->fetch_assoc()) 
                {
                    $maped_color = $row['order_col_des'];
                }
            }

        }

        $selecting_style_schedule_color_qry = "select order_style_no,order_del_no,order_col_des from $bai_pro3.packing_summary_input WHERE $column_in_pack_summary = '$column_to_search' order by tid";
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

        // $style = $job_number[1];
        // $schedule = $job_number[2];
        // $color = $maped_color;
        // $input_job = $job_number[0];
        // $operation_id = $job_number[4];

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
            if($next_operation == $job_number[4])
            {
               $flag = 'parallel_scanning';

               $get_ops_dep = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' and ops_dependency = $job_number[4]";
               $result_ops_dep = $link->query($get_ops_dep);
               while($row_dep = $result_ops_dep->fetch_assoc()) 
               {
                  $operations[] = $row_dep['operation_code'];
               }
               $emb_operations = implode(',',$operations);
               //parallel_scanning($style,$schedule,$color,$input_job,$operation_id);
            }
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
                        $schedule_count_query = "SELECT input_job_no_random_ref FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = '$job_number[0]' AND operation_id =$job_number[4]";
                        $schedule_count_query = $link->query($schedule_count_query);
                        if($schedule_count_query->num_rows > 0)
                        {
                            $schedule_query = "SELECT `style` as order_style_no,`schedule` as order_del_no,`send_qty`,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,`original_qty` as carton_act_qty,`recevied_qty` as reported_qty,`rejected_qty` as rejected_qty,((send_qty+recut_in+replace_in)-(recevied_qty+rejected_qty)) as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks, mapped_color,assigned_module FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = '$column_to_search' AND operation_id = $job_number[4] order by tid";
                            $flags=3;
                            $flag = 'bundle_creation_data';
                        }
                        else
                        {
                            $schedule_query = "SELECT *,carton_act_qty as balance_to_report, 0 as reported_qty, 0 as rejected_qty, 'packing_summary_input' as flag,tid as bundle_number,barcode_sequence FROM $bai_pro3.packing_summary_input WHERE input_job_no_random = '$job_number[0]' order by tid";
                            $flag = 'packing_summary_input';
                        }
                    } 
                }
                else
                {
                    $schedule_count_query = "SELECT input_job_no_random_ref FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = '$job_number[0]' AND operation_id =$job_number[4]";
                    $schedule_count_query = $link->query($schedule_count_query);
                    if($schedule_count_query->num_rows > 0)
                    {
                        $schedule_query = "SELECT `style` as order_style_no,`schedule` as order_del_no,`send_qty`,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,`original_qty` as carton_act_qty,`recevied_qty` as reported_qty,`rejected_qty` as rejected_qty,((send_qty+recut_in+replace_in)-(recevied_qty+rejected_qty)) as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks, mapped_color,assigned_module FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = '$column_to_search' AND operation_id = $job_number[4] order by tid";
                        $flags=3;
                        $flag = 'bundle_creation_data';
                    }
                    else
                    {
                        $schedule_query = "SELECT *,carton_act_qty as balance_to_report, 0 as reported_qty, 0 as rejected_qty, 'packing_summary_input' as flag,tid as bundle_number,barcode_sequence FROM $bai_pro3.packing_summary_input WHERE input_job_no_random = '$job_number[0]' order by tid";
                        $flag = 'packing_summary_input';
                    }
                }
           // }   

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
            $qry_min_prevops="SELECT MIN(recevied_qty) AS min_recieved_qty FROM $brandix_bts.bundle_creation_data WHERE docket_number = $main_dockets AND size_title = '$size' AND operation_id in ($emb_operations)";
            //echo $qry_min_prevops;
            $result_qry_min_prevops = $link->query($qry_min_prevops);
            while($row_result_min_prevops = $result_qry_min_prevops->fetch_assoc())
            {
                $previous_minqty=$row_result_min_prevops['min_recieved_qty'];
            }

          
            $schedule_query = "SELECT `style` as order_style_no,`schedule` as order_del_no,`send_qty`,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,`original_qty` as carton_act_qty,sum(recevied_qty) AS current_recieved_qty,`rejected_qty` as rejected_qty,((send_qty+recut_in+replace_in)-(recevied_qty+rejected_qty)) as balance_to_report`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'parallel_scanning' as flag,size_id as old_size,remarks, mapped_color,assigned_module FROM $brandix_bts.bundle_creation_data WHERE docket_number = $main_dockets AND operation_id = '$job_number[4]' order by tid";

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
             //echo $schedule_query;
            $result_style_data = $link->query($schedule_query);
            $select_modudle_qry = "select input_module from $bai_pro3.plan_dashboard_input where input_job_no_random_ref = '$job_number[0]'";
            $result_select_modudle_qry = $link->query($select_modudle_qry);
            while($row = $result_select_modudle_qry->fetch_assoc()) 
            {
                $module = $row['input_module'];
            }
            while($row = $result_style_data->fetch_assoc()) 
            {
                if($flag == 'parallel_scanning')
                {
                    //echo $flag;
                   // $doc_no = $row['doc_no'];
                   // $size = $row['old_size'];

                   $current_ops_qty = $row['balance_to_report'];
                   // echo $previous_minqty;

                   
                   $parallel_balance_report=($previous_minqty-$current_ops_qty);
                   //echo $parallel_balance_report;
                   if($parallel_balance_report<0)
                   {
                     $result_array['status'] = 'Previous operation not yet done.';
                      echo json_encode($result_array);
                      die();
                   }

                    $type_of_sewing_query = "SELECT *,carton_act_qty as balance_to_report, 0 as reported_qty, 0 as rejected_qty, 'packing_summary_input' as flag,tid as bundle_number,barcode_sequence FROM $bai_pro3.packing_summary_input WHERE input_job_no_random = '$job_number[0]' order by tid";
                     $result_sewing_query = $link->query($type_of_sewing_query);
                     while($row = $result_sewing_query->fetch_assoc()) 
                     {
                        $job_number_reference = $row['type_of_sewing'];
                     } 
                    if($job_number_reference == 2)
                    {
                        $selecting_sample_qtys = "SELECT input_qty FROM $bai_pro3.sp_sample_order_db WHERE order_tid = (SELECT order_tid FROM $bai_pro3.bai_orders_db WHERE order_style_no='$style' AND order_del_no='$schedule' AND order_col_des='$color' ) AND sizes_ref = '$size'";
                        $result_selecting_sample_qtys = $link->query($selecting_sample_qtys);
                        if($result_selecting_sample_qtys->num_rows > 0)
                        {
                            while($row_res = $result_selecting_sample_qtys->fetch_assoc()) 
                            {
                                $row['carton_act_qty'] = $row_res['input_qty'];
                            }
                        }
                        else
                        {
                            $result_array['status'] = 'Sample Quantities not updated!!!';
                        }
                    }  
   
                }
                else
                {
                      if($emb_cut_check_flag == 1 && $bundle_no == $row['tid'])
                      {
                        
                            $doc_no = $row['doc_no'];
                            $size = $row['old_size'];

                            $retreving_remaining_qty_qry = "SELECT sum(remaining_qty) as balance_to_report,doc_no FROM $bai_pro3.cps_log WHERE doc_no in ($doc_no) AND size_code='$size' AND operation_code = $pre_ops_code group by doc_no";
                           // echo $retreving_remaining_qty_qry;
                            $result_retreving_remaining_qty_qry = $link->query($retreving_remaining_qty_qry);
                            if($result_retreving_remaining_qty_qry->num_rows > 0)
                            {
                                while($row_remaining = $result_retreving_remaining_qty_qry->fetch_assoc()) 
                                {
                                    $sum_balance = $row_remaining['balance_to_report'];
                                }
                            }
                            if($sum_balance < $row['balance_to_report'])
                            {
                                $result_array['status'] = 'Previous operation not yet done for this jobs.';
                                echo json_encode($result_array);
                                die();

                            }
                      }
                }

               
                
              
                $style = $job_number[1];
                $schedule =  $job_number[2];
                $color = $row['order_col_des'];
                $size = $row['old_size'];
                if($flag == 'packing_summary_input')
                {
                    
                    $job_number_reference = $row['type_of_sewing'];
                    $get_remark = "select prefix_name from $brandix_bts.tbl_sewing_job_prefix WHERE type_of_sewing= $job_number_reference";
                    $get_remark_arry_req = $link->query($get_remark);
                    while($row_remark = $get_remark_arry_req->fetch_assoc()) 
                    {
                        $b_remarks[] = $row_remark['prefix_name'];
                    }
                    if($job_number_reference == 2)
                    {
                        $selecting_sample_qtys = "SELECT input_qty FROM $bai_pro3.sp_sample_order_db WHERE order_tid = (SELECT order_tid FROM $bai_pro3.bai_orders_db WHERE order_style_no='$style' AND order_del_no='$schedule' AND order_col_des='$color' ) AND sizes_ref = '$size'";
                        $result_selecting_sample_qtys = $link->query($selecting_sample_qtys);
                        if($result_selecting_sample_qtys->num_rows > 0)
                        {
                            while($row_res = $result_selecting_sample_qtys->fetch_assoc()) 
                            {
                                $row['carton_act_qty'] = $row_res['input_qty'];
                            }
                        }
                        else
                        {
                            $result_array['status'] = 'Sample Quantities not updated!!!';
                        }
                    }
                  
                    $barcode_sequence[] = $row['barcode_sequence'];
                }
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
   //          $sfcs_smv = $row['smv'];
            // if($sfcs_smv=='0.0000')
            // {
            //  $sfcs_smv = $row_ops['manual_smv']; 
            // }
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

            $schedule_count_query = "SELECT input_job_no_random_ref FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = '$b_job_no' AND operation_id =$b_op_id";

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
                  $smv_query = "select smv,manual_smv from $brandix_bts.tbl_style_ops_master where style='$b_style' and color='$b_colors[$key]' and operation_code = $b_op_id";
                        $result_smv_query = $link->query($smv_query);
                        while($row_ops = $result_smv_query->fetch_assoc()) 
                        {
                            $sfcs_smv = $row_ops['smv'];
                            if($sfcs_smv=='0.0000')
                            {
                                $sfcs_smv = $row_ops['manual_smv']; 
                            }
                        }
                        $bulk_insert_post = "INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`,`bundle_qty_status`) VALUES";

                        $bulk_insert_post_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `scanned_user`,`bundle_qty_status`) VALUES";
                        
                        $remarks_code = "";                             
                        $select_send_qty = "SELECT (send_qty+recut_in+replace_in)as send_qty, recevied_qty,rejected_qty,left_over,original_qty FROM $brandix_bts.bundle_creation_data WHERE bundle_number = $b_tid[$key] AND operation_id = $b_op_id";
                        $result_select_send_qty = $link->query($select_send_qty);
                        if($result_select_send_qty->num_rows >0)
                        {
                            while($row = $result_select_send_qty->fetch_assoc()) 
                            {
                                $b_old_rep_qty_new = $row['recevied_qty'];
                                $b_old_rej_qty_new = $row['rejected_qty'];
                                $b_left_over_qty = $row['left_over'];
                                $b_send_qty = $row['send_qty'];
                                $b_original_qty = $row['original_qty'];

                            }
                        }
                            $final_rep_qty = $parallel_balance_report; 

                            $final_rej_qty = $b_old_rej_qty_new;

                            $left_over_qty = $b_in_job_qty[$key] - $final_rep_qty - $final_rej_qty;
                            // LAST STEP MODIFIED
                            $left_over_qty_update = $b_send_qty - $final_rep_qty;

                            $previously_scanned = $parallel_balance_report;

                            //To check orginal_qty = send_qty + rejected_qty
                            $bundle_status = 0;
                            $send_qty = $b_in_job_qty[$key];
                            $reported_qty = $final_rep_qty + $final_rej_qty;
                            if($send_qty == $reported_qty)
                            {
                                $bundle_status = 1;
                            }
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
                                $query = "UPDATE $brandix_bts.bundle_creation_data SET `recevied_qty`= '".$final_rep_qty."', `left_over`= '".$left_over_qty_update."' , `scanned_date`='". date('Y-m-d')."' where bundle_number =$b_tid[$key] and operation_id = ".$b_op_id;
                                
                                $result_query = $link->query($query) or exit('query error in updating');
                            }else{
                                    
                                $bulk_insert_post .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'","'.$bundle_status.'")';  
                                $result_query_001 = $link->query($bulk_insert_post) or exit('bulk_insert_post query error in updating');
                            }

                            if($result_query)
                            {
                                if($b_rep_qty[$key] > 0)
                                {
                                    $bulk_insert_post_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$previously_scanned .'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'","'.$b_remarks[$key].'","'.$username.'","'.$bundle_status.'")';  
                                    $result_query_001_temp = $link->query($bulk_insert_post_temp) or exit('bulk_insert_post query error in updating');
                                    if($gate_pass_no>0)
                                    {
                                        $sql_gate="insert into $brandix_bts.`gatepass_track` (`gate_id`, `bundle_no`, `bundle_qty`, `style`, `schedule`, `color`, `size`,operation_id) values ('".$gate_pass_no."', ".$b_tid[$key].", '".$b_rep_qty[$key]."', '".$b_style."','".$b_schedule."','".$b_colors[$key]."','".$b_sizes[$key]."','".$b_op_id."-1')";
                                        $result_sql_temp = $link->query($sql_gate) or exit('Gate_pass_child query error in updating');
                                    
                                    }
                                    $update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$previously_scanned where doc_no = '".$b_doc_num[$key]."' and size_title='". $b_sizes[$key]."' AND operation_code in ($emb_operations)";
                                            $update_qry_cps_log_res = $link->query($update_qry_cps_log);
                                    
                                        
                                    
                                }
                            }
                            

                                                
                }
                
            }
        }
        if($table_name == 'packing_summary_input')
        {     
            $bulk_insert = "INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`,`mapped_color`,`barcode_sequence`,`barcode_number`,`bundle_qty_status`) VALUES";
            // temp table data insertion query.........
            $bulk_insert_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `scanned_user`,`bundle_qty_status`) VALUES";

                foreach ($b_tid as $key => $tid)
                {
                    $smv_query = "select smv,manual_smv from $brandix_bts.tbl_style_ops_master where style='$b_style' and color='$b_colors[$key]' and operation_code = $b_op_id";
                    $result_smv_query = $link->query($smv_query);
                    while($row_ops = $result_smv_query->fetch_assoc()) 
                    {
                        $sfcs_smv = $row_ops['smv'];
                        if($sfcs_smv=='0.0000')
                        {
                             $sfcs_smv = $row_ops['manual_smv'];
                        }
                    }
                    $left_over_qty = $b_in_job_qty[$key] - ($b_rep_qty[$key] + $b_rej_qty[$key]);
                   //To check orginal_qty = send_qty + rejected_qty
                    $bundle_status = 0;
                    $b_send_qty = $b_in_job_qty[$key];
                    $reported_qty = $b_rep_qty[$key] + $b_rej_qty[$key];
                    if($b_send_qty == $reported_qty)
                    {
                        $bundle_status = 1;
                    }
                    // $b_original_qty = $b_in_job_qty[$key];
                    // $reported_qty = $b_rep_qty[$key] + $b_rej_qty[$key];
                    // if($b_original_qty == $reported_qty)
                    // {
                    //     $bundle_status = 1;
                    // }

                    // appending all values to query for bulk insert....
                    if($tid == $bundle_no){
                        $b_rep_qty[$key] = $b_in_job_qty[$key];
                    }else{
                        $b_rep_qty[$key] = 0;
                    }
                    $bulk_insert .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'","'.$b_remarks[$key].'","'.$mapped_color.'","'.$barcode_sequence[$key].'","'.$b_tid[$key].'","'.$bundle_status.'"),';

                    // temp table data insertion query.........
                    if($b_rep_qty[$key] > 0 )
                    {
                        $bulk_insert_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'","'.$b_remarks[$key].'","'.$username.'","'.$bundle_status.'"),';
                        if($gate_pass_no>0)
                        {
                            $sql_gate="insert into $brandix_bts.`gatepass_track` (`gate_id`, `bundle_no`, `bundle_qty`, `style`, `schedule`, `color`, `size`,operation_id) values ('".$gate_pass_no."', ".$b_tid[$key].", '".$b_rep_qty[$key]."', '".$b_style."','".$b_schedule."','".$b_colors[$key]."','".$b_sizes[$key]."','".$b_op_id."-2')";
                            $result_sql_temp = $link->query($sql_gate) or exit('Gate_pass_child query error in updating');
                        
                        }
                        
                        
                        if($emb_cut_check_flag == 1)
                        {
                            $update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$b_rep_qty[$key] where doc_no = '".$b_doc_num[$key]."' and size_title='".$b_sizes[$key]."' AND operation_code = $pre_ops_code";
                            //echo "ram</br>".$update_qry_cps_log."</br>";
                            $updat_cps_qry_array[]=$update_qry_cps_log;
                            //$update_qry_cps_log_res = $link->query($update_qry_cps_log);
                        }
                        
                    }
                    $count = 1;
                    foreach($pre_ops_code_temp as $index => $op_code)
                    {
                        if($op_code != $b_op_id)
                        {
                            
                            $dep_check_query = "SELECT * from $brandix_bts.bundle_creation_data where bundle_number = $b_tid[$key] and operation_id = $op_code";
                            $dep_check_result = $link->query($dep_check_query) or exit('dep_check_query error');
                            if(mysqli_num_rows($dep_check_result) <= 0){
                            //change values here in query....
                                $send_qty = $b_rep_qty[$key];
                                $rec_qty = 0;
                                $rej_qty = 0;
                                $b_query[$op_code] .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$send_qty.'","'.$rec_qty.'","'.$rej_qty.'","'.$left_over_qty.'","'. $op_code.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'","'.$b_remarks[$key].'","'.$mapped_color.'","'.$barcode_sequence[$key].'","'.$b_tid[$key].'"),';

                                $b_query_temp[$op_code] .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$send_qty.'","'.$rec_qty.'","'.$rej_qty.'","'.$left_over_qty.'","'. $op_code.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'","'.$username.'"),';
                                
                                // if($gate_pass_no>0)
                                // {
                                    // $sql_gate="insert into $brandix_bts.`gatepass_track` (`gate_id`, `bundle_no`, `bundle_qty`, `style`, `schedule`, `color`, `size`,operation_id) values ('".$gate_pass_no."', ".$b_tid[$key].", '".$send_qty."', '".$b_style."','".$b_schedule."','".$b_colors[$key]."','".$b_sizes[$key]."','".$b_op_id."-3')";
                                    // $result_sql_temp = $link->query($sql_gate) or exit('Gate_pass_child query error in updating');                               
                                // }                                
                                
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
                $bundle_creation_result_001 = $link->query($final_query_001);
            }
            if(substr($bulk_insert, -1) == ','){
                $final_query_000 = substr($bulk_insert, 0, -1);
            }else{
                $final_query_000 = $bulk_insert;
            }
            $bundle_creation_result = $link->query($final_query_000);
            // temp tables data insertion query execution..........
            if(substr($bulk_insert_temp, -1) == ','){
                $final_query_000_temp = substr($bulk_insert_temp, 0, -1);
            }else{
                $final_query_000_temp = $bulk_insert_temp;
            }
            if($bundle_creation_result){
                $bundle_creation_result_temp = $link->query($final_query_000_temp);
                if($bundle_creation_result_temp){
                    if(count($updat_cps_qry_array)>0){
                        for($i=0;$i<count($updat_cps_qry_array);$i++){
                            $update_qry_cps_log_res = $link->query($updat_cps_qry_array[$i]);
                        }
                    }    
                }
            }
            if(update_qry_cps_log_res){
                $sql_message = 'Data inserted successfully';
            }else{
                $sql_message = 'Data Not inserted';
            }
                    //all operation codes query.. (not tested)
        }
        else
        {
            $query = '';

            if($table_name == 'bundle_creation_data')
            {
                $schedule_count_query = "SELECT input_job_no_random_ref FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = '$b_job_no' AND operation_id =$b_op_id";

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
                            $smv_query = "select smv,manual_smv from $brandix_bts.tbl_style_ops_master where style='$b_style' and color='$b_colors[$key]' and operation_code = $b_op_id";
                            $result_smv_query = $link->query($smv_query);
                            while($row_ops = $result_smv_query->fetch_assoc()) 
                            {
                                $sfcs_smv = $row_ops['smv'];
                                if($sfcs_smv=='0.0000')
                                {
                                    $sfcs_smv = $row_ops['manual_smv']; 
                                }
                            }
                            $bulk_insert_post = "INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`,`bundle_qty_status`) VALUES";

                            $bulk_insert_post_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `scanned_user`,`bundle_qty_status`) VALUES";

                            $remarks_code = "";                             
                            $select_send_qty = "SELECT (send_qty+recut_in+replace_in)as send_qty, recevied_qty,rejected_qty, left_over,original_qty FROM $brandix_bts.bundle_creation_data WHERE bundle_number = $b_tid[$key] AND operation_id = $b_op_id";
                            $result_select_send_qty = $link->query($select_send_qty);
                            if($result_select_send_qty->num_rows >0)
                            {
                                while($row = $result_select_send_qty->fetch_assoc()) 
                                {
                                    $b_old_rep_qty_new = $row['recevied_qty'];
                                    $b_old_rej_qty_new = $row['rejected_qty'];
                                    $b_left_over_qty = $row['left_over'];
                                    $b_send_qty = $row['send_qty'];
                                    $b_original_qty = $row['original_qty'];

                                }
                            }
                                $final_rep_qty = $b_old_rep_qty_new + $b_send_qty - ($b_old_rep_qty_new + $b_old_rej_qty_new); 

                                $final_rej_qty = $b_old_rej_qty_new;

                                $left_over_qty = $b_in_job_qty[$key] - $final_rep_qty - $final_rej_qty;
                                // LAST STEP MODIFIED
                                $left_over_qty_update = $b_send_qty - $final_rep_qty;

                                $previously_scanned = $b_send_qty - ($b_old_rep_qty_new + $b_old_rej_qty_new);

                                //To check orginal_qty = send_qty + rejected_qty
                                $bundle_status = 0;
                                $reported_qty = $final_rep_qty + $final_rej_qty;
                                if($b_send_qty == $reported_qty)
                                {
                                    $bundle_status = 1;
                                }
                                

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
                                    $query = "UPDATE $brandix_bts.bundle_creation_data SET `recevied_qty`= '".$final_rep_qty."', `left_over`= '".$left_over_qty_update."' , `scanned_date`='". date('Y-m-d')."' where bundle_number =$b_tid[$key] and operation_id = ".$b_op_id;
                                    
                                    $result_query = $link->query($query) or exit('query error in updating');
                                }else{
                                        
                                    $bulk_insert_post .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'","'.$bundle_status.'")'; 
                                    $result_query_001 = $link->query($bulk_insert_post) or exit('bulk_insert_post query error in updating');
                                }

                                if($bundle_status == 1)
                                {
                                    $status_update_query = "UPDATE $brandix_bts.bundle_creation_data SET `bundle_qty_status`= '".$bundle_status."' where bundle_number =$b_tid[$key] and operation_id = ".$b_op_id;
                                    
                                    $status_result_query = $link->query($status_update_query) or exit('query error in updating status');
                                }
                              
                                if($result_query)
                                {
                                    if($b_rep_qty[$key] > 0)
                                    {
                                        $bulk_insert_post_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$previously_scanned .'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'","'.$b_remarks[$key].'","'.$username.'","'.$bundle_status.'")'; 
                                        $result_query_001_temp = $link->query($bulk_insert_post_temp) or exit('bulk_insert_post query error in updating');
                                        
                                        if($gate_pass_no>0)
                                        {
                                            $sql_gate="insert into $brandix_bts.`gatepass_track` (`gate_id`, `bundle_no`, `bundle_qty`, `style`, `schedule`, `color`, `size`,operation_id) values ('".$gate_pass_no."', ".$b_tid[$key].", '".$previously_scanned."', '".$b_style."','".$b_schedule."','".$b_colors[$key]."','".$b_sizes[$key]."','".$b_op_id."-4')";
                                            $result_sql_temp = $link->query($sql_gate) or exit('Gate_pass_child query error in updating');
                                        
                                        }
                                        
                                        if($emb_cut_check_flag == 1)
                                        {
                                            $update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$previously_scanned where doc_no = '".$b_doc_num[$key]."' and size_title='". $b_sizes[$key]."' AND operation_code = $pre_ops_code";
                                            $update_qry_cps_log_res = $link->query($update_qry_cps_log);
                                        }
                                    }
                                }   
                                
                                if($post_ops_code != null)
                                {
                                    $query_post = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$final_rep_qty."', `scanned_date`='". date('Y-m-d')."',bundle_qty_status= 0 where bundle_number =$b_tid[$key] and operation_id = ".$post_ops_code;
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

                                    $query_post_dep = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$pre_recieved_qty."', `scanned_date`='". date('Y-m-d')."' where bundle_number =$b_tid[$key] and operation_id = ".$ops_dep;

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
        }
        if($concurrent_flag == 0)
        {
            $rep_sum_qty = array_sum($b_rep_qty);
            $tod_date = date('Y-m-d');
            $cur_hour = date('H:00');
            $cur_h = date('H');


            $hout_plant_timings_qry = "SELECT *,TIME(NOW()) FROM $bai_pro3.tbl_plant_timings WHERE  start_time<=TIME(NOW()) AND end_time>=TIME(NOW())";
            
            $hout_plant_timings_result = $link->query($hout_plant_timings_qry);

            if($hout_plant_timings_result->num_rows > 0){
                while($hout_plant_timings_result_data = $hout_plant_timings_result->fetch_assoc()) 
                {
                    $plant_start_timing = $hout_plant_timings_result_data['start_time'];
                    $plant_end_timing = $hout_plant_timings_result_data['end_time'];
                    $plant_time_id = $hout_plant_timings_result_data['time_id'];
                }
            }
            
            $hout_ops_qry = "SELECT operation_code from $brandix_bts.tbl_ims_ops where appilication='Down_Time'";

            $hout_ops_result = $link->query($hout_ops_qry);

            if($hout_ops_result->num_rows > 0)
            {
                while($hout_ops_result_data = $hout_ops_result->fetch_assoc()) 
                {
                    $hout_ops_code = $hout_ops_result_data['operation_code'];
                }

                
                if($b_op_id == $hout_ops_code){
                    $hout_data_qry = "select * from $bai_pro2.hout where out_date = '$tod_date' and team = '$b_module[0]' and time_parent_id = $plant_time_id";
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
                        $hout_insert_qry = "insert into $bai_pro2.hout(out_date, out_time, team, qty, status, remarks, rep_start_time, rep_end_time, time_parent_id) values('$tod_date','$cur_hour','$b_module[0]','$rep_sum_qty', '1', 'NA', '$plant_start_timing', '$plant_end_timing', '$plant_time_id')";
                        $hout_insert_result = $link->query($hout_insert_qry);
                        // insert
                    }
                }  
            }
            
            
            $appilication = 'IMS_OUT';
            $checking_output_ops_code = "SELECT operation_code from $brandix_bts.tbl_ims_ops where appilication='$appilication'";
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
            
            
            $application='IPS';
            $scanning_query="select operation_name,operation_code from $brandix_bts.tbl_ims_ops where appilication='$application'";
            //echo $scanning_query;
            $scanning_result=mysqli_query($link, $scanning_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($sql_row=mysqli_fetch_array($scanning_result))
            {
              $operation_name=$sql_row['operation_name'];
              $operation_code=$sql_row['operation_code'];
            }
            if($operation_code == 'Auto'){
                $get_ips_op = get_ips_operation_code($link,$style,$color);
                $operation_code=$get_ips_op['operation_code'];
                $operation_name=$get_ips_op['operation_name'];
            }
            $sql="SELECT COALESCE(SUM(recevied_qty),0) AS rec_qty,COALESCE(SUM(rejected_qty),0) AS rej_qty,COALESCE(SUM(original_qty),0) AS org_qty,COALESCE(SUM(replace_in),0) AS replace_qty FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = '".$b_job_no."' AND operation_id = $operation_code";
            $sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($sql_row=mysqli_fetch_array($sql_result))
            {
                $rec_qty=$sql_row["rec_qty"];
                $rej_qty=$sql_row["rej_qty"];
                $orginal_qty=$sql_row["org_qty"];
                $replace_in_qty=$sql_row["replace_qty"];
            }
            //commented due to #2390 CR(original_qty = recevied_qty + rejected_qty)
            // $sql2="SELECT COALESCE(SUM(carton_act_qty),0) as job_qty FROM $bai_pro3.pac_stat_log_input_job WHERE input_job_no_random='".$b_job_no."'";
            // $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
            // while($sql_row2=mysqli_fetch_array($sql_result2))
            // {
            //      $job_qty=$sql_row2["job_qty"];
            // }

            if(($orginal_qty+$replace_in_qty)==($rec_qty+$rej_qty)) 
            {
                $backup_query="INSERT IGNORE INTO $bai_pro3.plan_dashboard_input_backup SELECT * FROM $bai_pro3.`plan_dashboard_input` WHERE input_job_no_random_ref='".$b_job_no."'";
                mysqli_query($link, $backup_query) or exit("Error while saving backup plan_dashboard_input_backup");

                $sqlx="delete from $bai_pro3.plan_dashboard_input where input_job_no_random_ref='".$b_job_no."'";
                mysqli_query($link, $sqlx) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"])); 
            }
            if($b_rep_qty[$i] > 0 || $b_rej_qty[$i] > 0)
            {
                foreach ($b_tid as $key => $tid) 
                {
                   //To check orginal_qty = send_qty + rejected_qty
                    $bundle_status = 0;
                     $get_bundle_status = "select original_qty,recevied_qty,rejected_qty from $brandix_bts.bundle_creation_data where bundle_number=$b_tid[$key] and operation_id = $b_op_id";
                    $get_bundle_status_result=mysqli_query($link,$get_bundle_status) or exit("barcode status Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($status_row=mysqli_fetch_array($get_bundle_status_result))
                    {
                        $orginal_bundle_qty = $status_row['original_qty'];
                        $recevied_bundle_qty = $status_row['recevied_qty'];
                        $rejected_bundle_qty = $status_row['rejected_qty'];
                        $send_bundle_qty = $status_row['send_qty'];
                    }
                    $b_original_qty = $orginal_bundle_qty;
                    $b_send_qty = $send_bundle_qty;
                    $reported_qty = $recevied_bundle_qty + $rejected_bundle_qty;
                    if($b_send_qty == $reported_qty)
                    {
                        $bundle_status = 1;
                    }
                    
                    
                    if($bundle_status ==1)
                    {
                        $status_update_query = "UPDATE $brandix_bts.bundle_creation_data SET `bundle_qty_status`= '".$bundle_status."' where bundle_number =$b_tid[$key] and operation_id = ".$b_op_id;
                        $status_result_query = $link->query($status_update_query) or exit('query error in updating status');

                        $status_update_query = "UPDATE $brandix_bts.bundle_creation_data_temp SET `bundle_qty_status`= '".$bundle_status."' where bundle_number =$b_tid[$key] and operation_id = ".$b_op_id;
                        $status_result_query = $link->query($status_update_query) or exit('query error in updating status');
                    }
                    else
                    {
                        $status_update_query = "UPDATE $brandix_bts.bundle_creation_data SET `bundle_qty_status`= '".$bundle_status."' where bundle_number =$b_tid[$key] and operation_id = ".$b_op_id;
                        $status_result_query = $link->query($status_update_query) or exit('query error in updating status');

                        $status_update_query = "UPDATE $brandix_bts.bundle_creation_data_temp SET `bundle_qty_status`= '".$bundle_status."' where bundle_number =$b_tid[$key] and operation_id = ".$b_op_id;
                        $status_result_query = $link->query($status_update_query) or exit('query error in updating status');
                    }
                }
            }

            //To remove bundles from ims_log for fully rejected_qty
            if($b_op_id == $output_ops_code)
            {
                $ops_sequence_check = "select id,ops_sequence,ops_dependency,operation_order from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$mapped_color' and operation_code=$b_op_id";
                //echo $ops_sequence_check;
                $result_ops_sequence_check = $link->query($ops_sequence_check);
                while($row2 = $result_ops_sequence_check->fetch_assoc()) 
                {
                    $ops_seq = $row2['ops_sequence'];
                    $seq_id = $row2['id'];
                    $ops_order = $row2['operation_order'];

                }

                $pre_operation_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$mapped_color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) < '$ops_order' and operation_code NOT IN  (10,200) ORDER BY operation_order DESC LIMIT 1";
               // echo  $pre_operation_check;
                $result_pre_operation_check = $link->query($pre_operation_check);
                while($row23 = $result_pre_operation_check->fetch_assoc()) 
                {
                    $previous_operation = $row23['operation_code'];
                }

                $get_rejected_bundles= "select bundle_number from $brandix_bts.bundle_creation_data where input_job_no_random_ref='".$b_job_no."' and operation_id=$previous_operation and send_qty = rejected_qty and bundle_qty_status=1";
                $result_rejected_bundles = $link->query($get_rejected_bundles);
                if($result_rejected_bundles->num_rows > 0)
                {
                    while($row231 = $result_rejected_bundles->fetch_assoc()) 
                    {
                        $bundle_number = $row231['bundle_number'];

                        $update_status_query = "update $bai_pro3.ims_log set ims_status = 'DONE' where pac_tid = $bundle_number";
                        mysqli_query($link,$update_status_query) or exit("While updating status in ims_log".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $ims_backup="insert into $bai_pro3.ims_log_backup select * from bai_pro3.ims_log where pac_tid = $bundle_number";
                        mysqli_query($link,$ims_backup) or exit("Error while inserting into ims_backup".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $ims_delete="delete from $bai_pro3.ims_log where pac_tid = $bundle_number";
                        mysqli_query($link,$ims_delete) or exit("While De".mysqli_error($GLOBALS["___mysqli_ston"]));
                    }
                }
            }

              $application='IPS';
              $scanning_query="select operation_name,operation_code from $brandix_bts.tbl_ims_ops where appilication='$application'";
              $scanning_result=mysqli_query($link, $scanning_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
              while($sql_row1111=mysqli_fetch_array($scanning_result))
              {
                $operation_in_code=$sql_row1111['operation_code'];
              }
              if($operation_in_code == 'Auto'){
                $get_ips_op = get_ips_operation_code($link,$style,$color);
                $operation_in_code=$get_ips_op['operation_code'];
                $operation_name=$get_ips_op['operation_name'];
            }
            for($i=0;$i<sizeof($b_tid);$i++)
            {
                if($b_tid[$i] == $bundle_no)
                {
                  //  if($b_op_id == 100 || $b_op_id == 129)
                    if($b_op_id == $operation_in_code)
                    {
                        $searching_query_in_imslog = "SELECT tid,ims_qty FROM $bai_pro3.ims_log_backup WHERE pac_tid = $b_tid[$i] AND ims_mod_no='$b_module[$i]' AND ims_style='$b_style' AND ims_schedule='$b_schedule' AND ims_color='$b_colors[$i]' AND input_job_rand_no_ref='$b_job_no' AND operation_id=$b_op_id AND ims_remarks = '$b_remarks[$i]'";
                        $result_searching_query_in_imslog = $link->query($searching_query_in_imslog);
                        if($result_searching_query_in_imslog->num_rows > 0)
                        {
                            while($row = $result_searching_query_in_imslog->fetch_assoc()) 
                            {
                                $updatable_id = $row['tid'];
                                $pre_ims_qty = $row['ims_qty'];
                            }
                            $act_ims_qty = $pre_ims_qty + $b_rep_qty[$i];
                            $act_ims_qty = min($act_ims_qty,$b_in_job_qty[$i]);
                            //updating the ims_qty when it was there in ims_log
                            $update_query = "update $bai_pro3.ims_log_backup set ims_qty = $act_ims_qty where tid = $updatable_id";
                            $ims_pro_qty_updating = mysqli_query($link,$update_query) or exit("While updating ims_pro_qty in ims_log_log_backup".mysqli_error($GLOBALS["___mysqli_ston"]));
                            if($ims_pro_qty_updating)
                            {
                                $update_status_query = "update $bai_pro3.ims_log_backup set ims_status = '' where tid = $updatable_id";
                                mysqli_query($link,$update_status_query) or exit("While updating status in ims_log_backup".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $ims_backup="insert ignore into $bai_pro3.ims_log select * from bai_pro3.ims_log_backup where tid=$updatable_id";
                                mysqli_query($link,$ims_backup) or exit("Error while inserting into ims log".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $ims_delete="delete from $bai_pro3.ims_log_backup where tid=$updatable_id";
                                mysqli_query($link,$ims_delete) or exit("While Deleting ims log backup".mysqli_error($GLOBALS["___mysqli_ston"]));
                            }

                        }
                        else
                        {
                            //Searching whethere the operation was present in the ims log and ims buff
                            $searching_query_in_imslog = "SELECT * FROM $bai_pro3.ims_log WHERE pac_tid = $b_tid[$i] AND ims_mod_no='$b_module[$i]' AND ims_style='$b_style' AND ims_schedule='$b_schedule' AND ims_color='$b_colors[$i]' AND input_job_rand_no_ref=$b_job_no AND operation_id=$b_op_id AND ims_remarks = '$b_remarks[$i]'";
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
                                $cat_ref=0;
                                $catrefd_qry="select * FROM $bai_pro3.plandoc_stat_log WHERE order_tid in (select order_tid FROM bai_pro3.bai_orders_db WHERE order_style_no='$b_style' AND order_del_no='$b_schedule' AND order_col_des='$b_colors[$i]')";
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
                                    ims_size,ims_qty,ims_log_date,ims_style,ims_schedule,ims_color,rand_track,bai_pro_ref,input_job_rand_no_ref,input_job_no_ref,pac_tid,ims_remarks,operation_id) values ('".$ims_log_date."','".$cat_ref."','".$b_doc_num[$i]."','".$b_module[$i]."','".$b_shift."','".trim($sizevalue)."','".$b_rep_qty[$i]."',CURRENT_TIMESTAMP(),'".$b_style."','".$b_schedule."','".$b_colors[$i]."','$b_doc_num[$i]','$bundle_op_id','".$b_job_no."','".$b_inp_job_ref[$i]."','".$b_tid[$i]."','".$b_remarks[$i]."','".$b_op_id."')";
                                    $qry_status=mysqli_query($link,$insert_imslog);
                                }
                                
                                
                            }
                        }    
                    }
                    elseif($b_op_id == $output_ops_code)
                    {
                        //To gent Input Operation Code
                        $application='IPS';
                        $scanning_query="select operation_name,operation_code from $brandix_bts.tbl_ims_ops where appilication='$application'";
                        //echo $scanning_query;
                        $scanning_result=mysqli_query($link, $scanning_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($sql_row=mysqli_fetch_array($scanning_result))
                        {
                          $operation_name=$sql_row['operation_name'];
                          $operation_code=$sql_row['operation_code'];
                        }
                        if($operation_code == 'Auto'){
                            $get_ips_op = get_ips_operation_code($link,$style,$color);
                            $operation_code=$get_ips_op['operation_code'];
                            $operation_name=$get_ips_op['operation_name'];
                        }
                        //*To get previous Operation
                       $ops_sequence_check = "select id,ops_sequence,ops_dependency,operation_order from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$mapped_color' and operation_code=$b_op_id";
                        //echo $ops_sequence_check;
                       $result_ops_sequence_check = $link->query($ops_sequence_check);
                       while($row2 = $result_ops_sequence_check->fetch_assoc()) 
                       {
                            $ops_seq = $row2['ops_sequence'];
                            $seq_id = $row2['id'];
                            $ops_order = $row2['operation_order'];
                       }

                       $pre_operation_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$mapped_color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) < '$ops_order' and operation_code NOT IN  (10,200) ORDER BY operation_order DESC LIMIT 1";
                       // echo  $pre_operation_check;
                       $result_pre_operation_check = $link->query($pre_operation_check);
                       while($row23 = $result_pre_operation_check->fetch_assoc()) 
                       {
                           $previous_operation = $row23['operation_code'];
                       }
                        
                        if($b_op_id == $operation_code)
                        {
                            //updating ims_pro_qty against the input
                            $searching_query_in_imslog = "SELECT * FROM $bai_pro3.ims_log WHERE pac_tid = '$b_tid[$i]' AND ims_mod_no='$b_module[$i]' AND ims_style='$b_style' AND ims_schedule='$b_schedule' AND ims_color='$b_colors[$i]' AND input_job_rand_no_ref=$b_job_no AND operation_id=$operation_code AND ims_remarks = '$b_remarks[$i]'";
                            $result_searching_query_in_imslog = $link->query($searching_query_in_imslog);
                            if($result_searching_query_in_imslog->num_rows > 0)
                            {
                                while($row = $result_searching_query_in_imslog->fetch_assoc()) 
                                {
                                    $updatable_id = $row['tid'];
                                    $pre_ims_qty = $row['ims_pro_qty'];
                                }
                                $act_ims_qty = $pre_ims_qty + $b_rep_qty[$i] ;
                                //updating the ims_qty when it was there in ims_log
                                // $update_query = "update $bai_pro3.ims_log set ims_pro_qty = $act_ims_qty where tid = $updatable_id";
                                // $ims_pro_qty_updating = mysqli_query($link,$update_query) or exit("While updating ims_pro_qty in ims_log".mysqli_error($GLOBALS["___mysqli_ston"]));
                                // if($ims_pro_qty_updating)
                                // {
                                //     if($act_ims_input_qty == $act_ims_qty)
                                //     {
                                //         $update_status_query = "update $bai_pro3.ims_log set ims_status = 'DONE' where tid = $updatable_id";
                                //         mysqli_query($link,$update_status_query) or exit("While updating status in ims_log".mysqli_error($GLOBALS["___mysqli_ston"]));
                                //         $ims_backup="insert into $bai_pro3.ims_log_backup select * from bai_pro3.ims_log where tid=$updatable_id";
                                //         mysqli_query($link,$ims_backup) or exit("Error while inserting into ims_backup".mysqli_error($GLOBALS["___mysqli_ston"]));
                                //         $ims_delete="delete from $bai_pro3.ims_log where tid=$updatable_id";
                                //         mysqli_query($link,$ims_delete) or exit("While De".mysqli_error($GLOBALS["___mysqli_ston"]));
                    
                                //     }
                                // }
                               //get bundle qty status
                               $ims_removal_flag = 0;  
                               $get_qty_details="select sum(if(operation_id = $previous_operation,recevied_qty,0)) as input,sum(if(operation_id = $output_ops_code,recevied_qty,0)) as output,sum(if(operation_id = $output_ops_code,rejected_qty,0)) as output_rej From $brandix_bts.bundle_creation_data where  bundle_number=$b_tid[$i]";
                               $get_qty_result=mysqli_query($link,$get_qty_details) or exit("barcode status Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
                               while($qty_details=mysqli_fetch_array($get_qty_result))
                               {
                                 $input_qty = $qty_details['input'];
                                 $output_qty = $qty_details['output'] + $qty_details['output_rej'];
                               }
                               if($input_qty == $output_qty)
                               {
                                 $ims_removal_flag = 1;
                               }
                               
                               $get_bundle_status = "select bundle_qty_status from $brandix_bts.bundle_creation_data where 
                               bundle_number = $b_tid[$i] and operation_id=$b_op_id"; 
                               $result_get_bundle_status = $link->query($get_bundle_status);
                               while($bundle_row = $result_get_bundle_status->fetch_assoc())
                               {
                                   $bundle_status = $bundle_row['bundle_qty_status'];
                                   if($bundle_status == 1 && $ims_removal_flag == 1)
                                   {
                                        $update_status_query = "update $bai_pro3.ims_log set ims_pro_qty = $act_ims_qty,ims_status = 'DONE' where pac_tid = $b_tid[$i]";
                                        mysqli_query($link,$update_status_query) or exit("While updating status in ims_log".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $ims_backup="insert into $bai_pro3.ims_log_backup select * from bai_pro3.ims_log where pac_tid= $b_tid[$i]";
                                        mysqli_query($link,$ims_backup) or exit("Error while inserting into ims_backup".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        $ims_delete="delete from $bai_pro3.ims_log where pac_tid= $b_tid[$i]";
                                        mysqli_query($link,$ims_delete) or exit("While De".mysqli_error($GLOBALS["___mysqli_ston"]));
                                   }
                                   else
                                   {
                                        $update_status_query = "update $bai_pro3.ims_log set ims_pro_qty = $act_ims_qty where pac_tid = $b_tid[$i]";
                                        mysqli_query($link,$update_status_query) or exit("While updating status in ims_log".mysqli_error($GLOBALS["___mysqli_ston"]));
                                   }
                               }
                            }
                        }
                    }
                    
                    //3017 new 
                    $hout_ops_qry = "SELECT smv from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$b_colors[$i]' and operation_code=$b_op_id";
                    $hout_ops_result = $link->query($hout_ops_qry);
                    if($hout_ops_result->num_rows > 0)
                    {
                        while($hout_ops_result_data = $hout_ops_result->fetch_assoc()) 
                        {
                            $smv = $hout_ops_result_data['smv'];
                        }
                        
                        if($smv>0 && $b_rep_qty[$i] > 0)
                        {
                            $hout_insert_qry = "insert into $bai_pro2.hout2(out_date, out_time, team, qty, status, remarks, rep_start_time, rep_end_time, time_parent_id, style,color,smv,bcd_id) values('$tod_date','$cur_hour','$b_module[$i]','$b_rep_qty[$i]', '1', 'NA', '$plant_start_timing', '$plant_end_timing', '$plant_time_id','$b_style','$b_colors[$i]','$smv','$b_tid[$i]')";
                            $hout_insert_result = $link->query($hout_insert_qry);                       
                        }
                    }
                    //inserting bai_log and bai_log_buff
                    $sizevalue="size_".$b_size_code[$i];
                    $sections_qry="select section FROM $bai_pro3.module_master WHERE module_name='$b_module[$i]'";
                    //echo $sections_qry;
                    $sections_qry_result=mysqli_query($link,$sections_qry) or exit("Bundles Query Error15".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($buyer_qry_row=mysqli_fetch_array($sections_qry_result)){
                            $sec_head=$buyer_qry_row['section'];
                    }
                    $ims_log_date=date("Y-m-d");
                    $bac_dat=$ims_log_date;
                    $log_time=date("Y-m-d H:i:s");
                    $buyer_qry="select order_div FROM $bai_pro3.bai_orders_db WHERE order_style_no='".$b_style."' AND order_del_no='".$b_schedule."' AND order_col_des='".$b_colors[$i]."'";
                    $buyer_qry_result=mysqli_query($link,$buyer_qry) or exit("Bundles Query Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($buyer_qry_row=mysqli_fetch_array($buyer_qry_result)){
                            $buyer_div=str_replace("'","",(str_replace('"',"",$buyer_qry_row['order_div'])));
                        }
                    $qry_nop="select ((present+jumper)-absent) as nop FROM $bai_pro.pro_attendance where module='".$b_module[$i]."' and date='".$bac_dat."' and shift='".$shift."'";
                    $qry_nop_result=mysqli_query($link,$qry_nop) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
                    {
                                $avail=$nop_qry_row['nop'];
                    }

                    if(mysqli_num_rows($qry_nop_result)>0){
                        $nop=$avail;
                    }else{
                        $nop=0;
                    }
                    $bundle_op_id=$b_tid[$i]."-".$b_op_id."-".$b_inp_job_ref[$i];
                    $appilication_out = "IMS_OUT";
                    $checking_output_ops_code_out = "SELECT operation_code from $brandix_bts.tbl_ims_ops where appilication='$appilication_out'";
                    $result_checking_output_ops_code_out = $link->query($checking_output_ops_code_out);
                    if($result_checking_output_ops_code_out->num_rows > 0)
                    {
                        while($row_result_checking_output_ops_code_out = $result_checking_output_ops_code_out->fetch_assoc()) 
                    {
                        $output_ops_code_out = $row_result_checking_output_ops_code_out['operation_code'];
                    }
                    }
                    else
                    {
                    $output_ops_code_out = 130;
                    }
                    //To get SMV
                    $smv_query = "select smv,manual_smv from $brandix_bts.tbl_style_ops_master where style='$b_style' and color='$b_colors[$i]' and operation_code = $b_op_id";
                    $result_smv_query = $link->query($smv_query);
                    while($row_ops = $result_smv_query->fetch_assoc()) 
                    {
                        $sfcs_smv = $row_ops['smv'];
                        if($sfcs_smv=='0.0000')
                        {
                            $sfcs_smv = $row_ops['manual_smv']; 
                        }
                    }
                    if($b_op_id == $output_ops_code_out)
                    {
                        $insert_bailog="insert into $bai_pro.bai_log (bac_no,bac_sec,bac_Qty,bac_lastup,bac_date,
                        bac_shift,bac_style,bac_stat,log_time,buyer,delivery,color,loguser,ims_doc_no,smv,".$sizevalue.",ims_table_name,ims_tid,nop,ims_pro_ref,ope_code,jobno
                        ) values ('".$b_module[$i]."','".$sec_head."','".$b_rep_qty[$i]."','".$log_time."','".$bac_dat."','".$b_shift."','".$b_style."','Active','".$log_time."','".$buyer_div."','".$b_schedule."','".$b_colors[$i]."',USER(),'".$b_doc_num[$i]."','".$sfcs_smv."','".$b_rep_qty[$i]."','ims_log','".$b_op_id."','".$nop."','".$bundle_op_id."','".$b_op_id."','".$b_inp_job_ref[$i]."')";
                        if($b_rep_qty[$i] > 0)
                        {
                            $qry_status=mysqli_query($link,$insert_bailog) or exit("BAI Log Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                        }
                        if($qry_status)
                        {
                            /*Insert same data into bai_pro.bai_log_buf table*/
                            $insert_bailogbuf="insert into $bai_pro.bai_log_buf(bac_no,bac_sec,bac_Qty,bac_lastup,bac_date,
                            bac_shift,bac_style,bac_stat,log_time,buyer,delivery,color,loguser,ims_doc_no,smv,".$sizevalue.",ims_table_name,ims_tid,nop,ims_pro_ref,ope_code,jobno
                            ) values ('".$b_module[$i]."','".$sec_head."','".$b_rep_qty[$i]."','".$log_time."','".$bac_dat."','".$b_shift."','".$b_style."','Active','".$log_time."','".$buyer_div."','".$b_schedule."','".$b_colors[$i]."',USER(),'".$b_doc_num[$i]."','".$sfcs_smv."','".$b_rep_qty[$i]."','ims_log','".$b_op_id."','".$nop."','".$bundle_op_id."','".$b_op_id."','".$b_inp_job_ref[$i]."')";
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
                    }
                }
            }

            //updating into  m3 transactions for positives
            for($i=0;$i<sizeof($b_tid);$i++)
            {
                $updation_m3 = updateM3Transactions($b_tid[$i],$b_op_id,$b_rep_qty[$i]);
            }
            $result_array['bundle_no'] = $bundle_no;
            $result_array['op_no'] = $op_no;
            echo json_encode($result_array);
            die();
        }
       
    }
?>
