<?php
error_reporting(0);
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions_dashboard.php");
include('../sewing_job_scaning/functions_scanning_ij.php');

if (isset($_POST["barcode_info"])){
    $op_code=$_POST['op_code'];
    $action_mod=$_POST['action_mod'];
    //getting barocde info to scanning screen
    $barcode_info=$_POST['barcode_info'];
    if($barcode_info!=''){
        //this is for splitting
        $barcode_split = explode("-",$barcode_info);

        if($barcode_split[0]!='')
        {
            $barcode_info="$barcode_split[0]";
        }
        else{
            $barcode_info="$barcode_split[1]";
        }
        //validation for barcode exist or not
        $qry_barcode="SELECT * FROM `$bai_pro3`.`packing_summary_input` WHERE tid=$barcode_info";
        $result_qry_barcode = $link->query($qry_barcode);
        if($result_qry_barcode->num_rows > 0){
            while($row = $result_qry_barcode->fetch_assoc()){
                $input_job_no= $row['input_job_no'];

                //getting operation name by using operation code
                $qry_operationname="SELECT * FROM $brandix_bts.tbl_orders_ops_ref WHERE operation_code='".$op_code."'";
                $result_qry_operationname = $link->query($qry_operationname);
                while($row_operationname = $result_qry_operationname->fetch_assoc()){
                    $json['operation_name']=$row_operationname['operation_name']; 
                }
                //getting po and zfeature
                $qry_orderdetails="SELECT * FROM $bai_pro3.`bai_orders_db_confirm` WHERE order_style_no='".$row['order_style_no']."' AND order_del_no='".$row['order_del_no']."' AND order_col_des='".$row['order_col_des']."'";
                $result_qry_orderdetails = $link->query($qry_orderdetails);
                while($row_orderdetails = $result_qry_orderdetails->fetch_assoc()){
                    $json['zfeature']=$row_orderdetails['zfeature'];
                    $json['vpo']=$row_orderdetails['vpo']; 
                }
                //getting elegible qty bundle wise
                $qry_eligible_qty="SELECT * FROM brandix_bts.`bundle_creation_data` WHERE bundle_number='".$barcode_info."' and operation_id='".$op_code."'";
                $result_qry_eligible_qty = $link->query($qry_eligible_qty);
                if($result_qry_eligible_qty->num_rows > 0){
                    while($row_eligible_qty = $result_qry_eligible_qty->fetch_assoc()){
                        $json['bundle_eligibl_qty']=$row_eligible_qty['send_qty']-($row_eligible_qty['recevied_qty']+$row_eligible_qty['rejected_qty']);
                        $recevied_qty=$row_eligible_qty['recevied_qty'];
                    }
                }else{
                    $json['bundle_eligibl_qty']=$row['carton_act_qty'];
                }

                $json['style']=$row['order_style_no'];
                $json['schedule']=$row['order_del_no'];
                $json['color']=$row['order_col_des'];
                $json['original_qty']=$row['carton_act_qty'];
                $json['size_title']=$row['m3_size_code'];
                $json['global_facility_code']=$global_facility_code;
                $json['validate_barcode'] = 1;
                //short shipment validation
                $short_ship_status=0;
                $query_short_shipment = "select * from bai_pro3.short_shipment_job_track where remove_type in('1','2') and style='".$row['order_style_no']."' and schedule ='".$row['order_del_no']."'";
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
                $query_jobs_deactive = "select * from bai_pro3.job_deactive_log where remove_type ='3' and style='".$row['order_style_no']."' and schedule ='".$row['order_del_no']."'  and input_job_no = '".$input_job_no."'";
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

                $json['short_shipment'] = $short_ship_status;
                
                    if($json['bundle_eligibl_qty']>0){
                        $json['color_code'] = "#45b645";
                        $json['status'] = "Proceed";
                        echo json_encode($json);
                    }else{
                        if($recevied_qty>0 && $action_mod=='reverse')
                        {
                          $json['color_code'] = "#45b645";
                          $json['status'] = "Proceed";
                          echo json_encode($json);
                        }
                        else
                        {
                          $json['color_code'] = "#f31c06";
                          $json['status'] = "No eligible qunatity for this bundle";
                          echo json_encode($json);
                          die();
                        }  
                        
                    }            
                
            }
        }else{
            $json['validate_barcode'] = 0;
            $json['color_code'] = "#f31c06";
            $json['status'] = "Please verify Barcode once";
            echo json_encode($json);
            die();            
        }
        
    }
}
   
    //logic for Saving good qunatities and rejections
if(isset($_POST["trans_action"])){
        $trans_action = $_POST['trans_action'];
        $barcode = $_POST['barcode_value'];
        $operation=$_POST['op_code'];
        $short_ship_validation=$_POST['scan_proceed'];
        //echo $short_ship_validation;
    // if($scan_proceed=='Proceed'){
        //validating barcode and operation
        if(($barcode!='') && ($operation!='')){

            if($short_ship_validation==1){
                $result_array['color_code'] = "#f31c06";
                $result_array['status'] = 'Short Shipment Done Temporarly';
                echo json_encode($result_array);                   
                die();
            }
            else if ($short_ship_validation==2) {
                $result_array['color_code'] = "#f31c06";
                $result_array['status'] = 'Short Shipment Done Permanently';
                echo json_encode($result_array);                  
                die();
            }
            else if ($short_ship_validation==3) {
                $result_array['color_code'] = "#f31c06";
                $result_array['status'] = 'Sewing Job Deactivated';
                echo json_encode($result_array);                  
                die();
            }else{

                //this is for good and rejection positive add
                if($trans_action=="add"){
                    $trans_mode=$_POST['trans_mode'];
                    //updating rejections
                    //this is for updating rejection qunatities
                    include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/m3Updations.php");
                    function updaterejectdetails($bundle_no, $op_no, $shift ,$rej_data,$selected_module,$ops_cps_updat)
                        {   
                            //var_dump($rej_data);exit;
                            //error_reporting(0);
                            global $result_array;   
                            include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
                                //getting data from packing sumary input
                                $qry_barcode="SELECT * FROM `$bai_pro3`.`packing_summary_input` WHERE tid=$bundle_no";
                                //echo $qry_barcode;
                                $result_qry_barcode = $link->query($qry_barcode);
                                    if($result_qry_barcode->num_rows > 0){
                                        while($row = $result_qry_barcode->fetch_assoc()){
                                            $b_style=$row['order_style_no'];
                                            $b_schedule=$row['order_del_no'];
                                            $b_colors=$row['order_col_des'];
                                            $b_size_code=$row['old_size'];
                                            $size_title=$row['size_code'];
                                            $b_in_job_qty=$row['carton_act_qty'];
                                            $b_doc_num=$row['doc_no'];
                                            $b_a_cut_no=$row['acutno'];
                                            $b_job_no=$row['input_job_no'];
                                            $input_job_no_random=$row['input_job_no_random'];
                                            $job_number_reference = $row['type_of_sewing'];
                                        }
                                    }
                                    $get_remark = "select prefix_name from $brandix_bts.tbl_sewing_job_prefix WHERE type_of_sewing= $job_number_reference";
                                    $get_remark_arry_req = $link->query($get_remark);
                                    while($row_remark = $get_remark_arry_req->fetch_assoc()) 
                                    {
                                        $b_remarks  = $row_remark['prefix_name'];
                                    }
                                $actual_rejection_reason_array_string = array();
                                foreach($rej_data as $reason_key=>$reason_value)
                                {   
                                    //to get form type
                                    $rejection_code_fetech_qry = "select reason_code,form_type from $bai_pro3.bai_qms_rejection_reason where sno= '$reason_key'";
                                    $result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
                                    while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
                                    {
                                        $reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
                                        $type = $rowresult_rejection_code_fetech_qry['form_type'];
                                    }
                                    $bundle_individual_number=$bundle_no;
                                    $remain_qty_key=$reason_key;
                                    $remain_qty_value=$reason_value;
                                    if($reason_value > 0)
                                    {   
                                        $actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$remain_qty_key.'-'. $remain_qty_value ;
                                        $remarks_code = $reason_code.'-'.$reason_value;
                                        $remarks_var = $selected_module.'-'.$shift.'-'.$type;
                                        $bulk_insert_rej = "INSERT INTO $bai_pro3.bai_qms_db(`qms_style`, `qms_schedule`,`qms_color`,`log_user`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`,`remarks`, `ref1`, `doc_no`, `input_job_no`, `operation_id`, `qms_remarks`, `bundle_no`) VALUES";
                                        $bulk_insert_rej .= '("'.$b_style.'","'.$b_schedule.'","'.$b_colors.'",user(),"'.date('Y-m-d').'","'.$b_size_code.'","'.$remain_qty_value.'","3","'.$remarks_var.'","'.$remarks_code.'","'.$b_doc_num.'","'.$input_job_no_random.'","'. $op_no.'","'. $b_remarks.'","'.$bundle_individual_number.'")';
                                        $rej_insert_result = $link->query($bulk_insert_rej) or exit('data error');
                                        //updating BCD
                                        if($rej_insert_result){
                                            //update query for bcd
                                            $query = "UPDATE $brandix_bts.bundle_creation_data SET `rejected_qty`= rejected_qty+$remain_qty_value ,`scanned_date`='". date('Y-m-d h:i:s')."' where bundle_number =$bundle_individual_number and operation_id = ".$op_no;
                                            $result_query = $link->query($query) or exit('query error in updating');
                                                if($result_query){
                                                    //bcd temp
                                                    $sfcs_smv=0;
                                                    $bulk_insert_post_temp = 'INSERT INTO brandix_bts.bundle_creation_data_temp (`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`,`scanned_user`,`sync_status`) VALUES ("'.$b_style.'","'. $b_schedule.'","'.$b_colors.'","'.$b_size_code.'","'. $size_title.'","'. $sfcs_smv.'","'.$bundle_individual_number.'","'.$b_in_job_qty.'","'.$b_in_job_qty.'",0,"'.$remain_qty_value.'",0,"'. $op_no.'","'.$b_doc_num.'","'.date('Y-m-d').'","'.$b_a_cut_no.'","'.$b_job_no.'","'.$input_job_no_random.'","'.$shift.'","'.$selected_module.'","'.$b_remarks.'","'.$username.'",1)';
                                                    //echo $bulk_insert_post_temp;
                                                    $result_query = $link->query($bulk_insert_post_temp) or exit('query error in updating1');
                                                }
                                        }
                                        
                                    }
                                }
                                //update rejections to M3 trasactions
                                if(sizeof($actual_rejection_reason_array_string) > 0)
                                    {
                                        for($i=0;$i<sizeof($actual_rejection_reason_array_string);$i++)
                                            {
                                                $r_qty = array();
                                                $r_reasons = array();
                                                $implode_next = explode('-',$actual_rejection_reason_array_string[$i]);
                                                $r_qty[] = $implode_next[2];
                                                $rejection_code_fetech_qry = "select m3_reason_code from $bai_pro3.bai_qms_rejection_reason where sno= $implode_next[1]";
                                                $result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
                                                    while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
                                                    {
                                                        $m3_reason_code = $rowresult_rejection_code_fetech_qry['m3_reason_code'];
                                                    }
                                                //$r_reasons[] = $m3_reason_code;
                                                $b_tid = $implode_next[0];
                                                //retreving bcd id from bundle_ceration_data and inserting into the rejection_log table and rejection_log_child
                                                $bcd_id_qry = "select id,style,schedule,color,docket_number,size_title,size_id,assigned_module,input_job_no_random_ref from $brandix_bts.bundle_creation_data where bundle_number=$bundle_no and operation_id = $op_no";
                                                $bcd_id_qry_result=mysqli_query($link,$bcd_id_qry) or exit("Bcd id qry".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                    while($bcd_id_row=mysqli_fetch_array($bcd_id_qry_result))
                                                    {
                                                        $bcd_id = $bcd_id_row['id'];
                                                        $style = $bcd_id_row['style'];
                                                        $schedule = $bcd_id_row['schedule'];
                                                        $color = $bcd_id_row['color'];
                                                        $doc_no = $bcd_id_row['docket_number'];
                                                        $size_title = $bcd_id_row['size_title'];
                                                        $size_id = $bcd_id_row['size_id'];
                                                        $assigned_module = $bcd_id_row['assigned_module'];
                                                        $input_job_random_ref = $bcd_id_row['input_job_no_random_ref'];
                                                        $doc_value = $bcd_id_row['docket_number'];
                                                    }
                                                //searching the bcd_id in rejection log child or not
                                                $bcd_id_searching_qry = "select id,parent_id from $bai_pro3.rejection_log_child where bcd_id = $bcd_id";
                                                $bcd_id_searching_qry_result=mysqli_query($link,$bcd_id_searching_qry) or exit("bcd_id_searching_qry_result".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                if($bcd_id_searching_qry_result->num_rows > 0)
                                                {
                                                    while($bcd_id_searching_qry_result_row=mysqli_fetch_array($bcd_id_searching_qry_result))
                                                    {
                                                        $parent_id = $bcd_id_searching_qry_result_row['parent_id'];
                                                    }
                                                    $update_rejection_log_child_qry = "update $bai_pro3.rejection_log_child set rejected_qty=rejected_qty+$implode_next[2] where bcd_id = $bcd_id";
                                                    mysqli_query($link,$update_rejection_log_child_qry) or exit("update_rejection_log_child_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                    $update_qry_rej_lg = "update $bai_pro3.rejections_log set rejected_qty = rejected_qty+$implode_next[2],remaining_qty=remaining_qty+$implode_next[2] where style='$style' and schedule='$schedule' and color='$color'";
                                                    $update_qry_rej_lg = $link->query($update_qry_rej_lg);
                                                }
                                                else
                                                {
                                                    $search_qry="SELECT id FROM $bai_pro3.rejections_log where style='$style' and schedule='$schedule' and color='$color'";
                                                    // echo $search_qry;
                                                    $result_search_qry = mysqli_query($link,$search_qry) or exit("rejections_log search query".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                    if($result_search_qry->num_rows > 0)
                                                    {
                                                        while($row_result_search_qry=mysqli_fetch_array($result_search_qry))
                                                        {
                                                            $rejection_log_id = $row_result_search_qry['id'];
                                                            $update_qry_rej_lg = "update $bai_pro3.rejections_log set rejected_qty = rejected_qty+$implode_next[2],remaining_qty=remaining_qty+$implode_next[2] where id = $rejection_log_id";
                                                            // echo $update_qry_rej_lg;
                                                            $update_qry_rej_lg = $link->query($update_qry_rej_lg);
                                                            $parent_id = $rejection_log_id;
                                                        }

                                                    }
                                                    else
                                                    {
                                                        $insert_qty_rej_log = "INSERT INTO bai_pro3.rejections_log (style,schedule,color,rejected_qty,recut_qty,remaining_qty) VALUES ('$style','$schedule','$color',$implode_next[2],'0',$implode_next[2])";
                                                        $res_insert_qty_rej_log = $link->query($insert_qty_rej_log);
                                                        $parent_id=mysqli_insert_id($link);
                                                    }
                                                    $inserting_into_rejection_log_child_qry = "INSERT INTO `bai_pro3`.`rejection_log_child` (`parent_id`,`bcd_id`,`doc_no`,`input_job_no_random_ref`,`size_id`,`size_title`,`assigned_module`,`rejected_qty`,`operation_id`) values($parent_id,$bcd_id,$b_doc_num,$input_job_random_ref,'$size_id','$size_title',$assigned_module,$implode_next[2],$op_no)";
                                                    $insert_qry_rej_child = $link->query($inserting_into_rejection_log_child_qry);
                                                }
                                                //inserting into rejections_reason_track'
                                                if($implode_next[2] > 0)
                                                {
                                                    $insert_into_rejections_reason_track = "INSERT INTO $bai_pro3.`rejections_reason_track` (`parent_id`,`date_time`,`bcd_id`,`rejected_qty`,`rejection_reason`,`username`,`form_type`) values ($parent_id,DATE_FORMAT(NOW(), '%Y-%m-%d %H'),$bcd_id,'$implode_next[2]','$implode_next[1]','$username','$type')";
                                                    $insert_into_rejections_reason_track_res =$link->query($insert_into_rejections_reason_track);
                                                    //updating this to cps log
                                                    if($op_no)
                                                    {
                                                        //getting dependency operation
                                                        $parellel_ops=array();
                                                        $qry_parellel_ops="select operation_code from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$b_colors' and ops_dependency='$op_no'";
                                                        $qry_parellel_ops_result=mysqli_query($link,$qry_parellel_ops);
                                                        if($qry_parellel_ops_result->num_rows > 0){
                                                            while ($row_prellel = mysqli_fetch_array($qry_parellel_ops_result))
                                                            { 
                                                                $parellel_ops[] = $row_prellel['operation_code'];
                                                            }
                                                        }
                                                        if($ops_cps_updat>0){
                                                            if(sizeof($parellel_ops)>0){
                                                                $update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$implode_next[2] where doc_no = $doc_value and size_title='$size_title' AND operation_code in (".implode(',',$parellel_ops).")";
                                                            }else{
                                                                $update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$implode_next[2] where doc_no = $doc_value and size_title='$size_title' AND operation_code = $ops_cps_updat";
                                                            }
                                                            $update_qry_cps_log_res = $link->query($update_qry_cps_log);
                                                        }	
                                                        
                                                    }
                                                }
                                                updateM3TransactionsRejections($b_tid,$op_no,$r_qty,$m3_reason_code);
                                            }
                                        $result_array['status'] = 'Bundle updated successfully !!!';
                                        $result_array['color_code'] = "#45b645";
                                        //echo json_encode($result_array);
                                    }
                        }
                    
                        //this is for updating good qunatities
                    function getjobdetails1($job_number, $bundle_no, $op_no, $shift ,$gate_id,$trans_mode,$rej_data,$selected_module)
                        {   
                            //error_reporting(0);
                            global $result_array;
                            if($rej_data!=''){
                                $total_rej_qty=array_sum($rej_data);   
                            }else{
                                $total_rej_qty=0;
                            }
                            // var_dump($rej_data);echo "</br>Bundle : ".$bundle_no."- Op no :".$op_no." Shift ".$shift." Gate : ".$gate_id." - trans mode : ".$trans_mode." - Tota Rej qty : ".$total_rej_qty."</br>";
                            // exit;
                            $job_number = explode(",",$job_number);
                            $job_number[4]=$job_number[1];
                            $gate_pass_no=$gate_id;
                            include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
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
                                $result_array['color_code'] = "#f31c06";
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
                                                    $result_array['color_code'] = "#f31c06";
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
                                        $result_array['color_code'] = "#f31c06";
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
                                        $emb_cut_check_flag=0;
                                        if(in_array($category_act,$category))
                                        {
                                            $emb_cut_check_flag = 1;
                                        }

                                        if($emb_cut_check_flag == 1){
                                            
                                            $ops_cps_updat=$pre_ops_code;
                                        }else{
                                            $ops_cps_updat=0;
                                        }

                                        if($emb_cut_check_flag != 1)
                                        {
                                            $pre_ops_validation = "SELECT sum(recevied_qty)as recevied_qty,send_qty,rejected_qty FROM  $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = '$column_to_search' AND operation_id = $pre_ops_code";
                                            $result_pre_ops_validation = $link->query($pre_ops_validation);
                                            while($row = $result_pre_ops_validation->fetch_assoc()) 
                                            {
                                                $recevied_qty_qty = $row['recevied_qty'];
                                                $result_array['prevops_sendqty'] = $row['send_qty'];
                                                $result_array['prevops_rejeqty'] = $row['rejected_qty'];
                                                $result_array['pre_ops_code'] =$pre_ops_code;
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
                                $result_array['status'] = 'Previous operation not yet done for this job.';
                                $result_array['color_code'] = "#f31c06";
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
                                        $result_array['color_code'] = "#f31c06";
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
                                                    $result_array['color_code'] = "#f31c06";
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
                                            
                                        $b_rep_qty[]=$parallel_balance_report-$total_rej_qty;
                                
                                        }
                                    }else{
                                        $b_rep_qty[]=$row['balance_to_report']-$total_rej_qty;
                                    }   
                                    
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
                                    $sfcs_smv = $row['manual_smv'];	
                                }
                            }
                            
                            $ops_dep_qry = "SELECT ops_dependency,operation_code,ops_sequence FROM $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' and ops_sequence='$sequnce' AND ops_dependency != 200 AND ops_dependency != 0 group by ops_dependency";
                            $result_ops_dep_qry = $link->query($ops_dep_qry);
                            $ops_dep=0;
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
                            }else{
                                $post_ops_code=0;
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
                                                
                                                //if any rejections updated
                                                if($total_rej_qty>0){
                                                    $final_rep_qty=$final_rep_qty-$total_rej_qty;
                                                }

                                                $final_rej_qty = $b_old_rej_qty_new;

                                                $left_over_qty = $b_in_job_qty[$key] - $final_rep_qty - $final_rej_qty;
                                                // LAST STEP MODIFIED
                                                $left_over_qty_update = $b_send_qty - $final_rep_qty;

                                                $left_over_qty="0";

                                                $previously_scanned = $parallel_balance_report;
                                                
                                                if($previously_scanned == 0){
                                                    if($b_send_qty == $b_old_rej_qty_new){
                                                        $result_array['status'] = 'This Bundle Qty Is Completely Rejected';
                                                        $result_array['color_code'] = "#f31c06";
                                                    }else{
                                                        $result_array['status'] = 'Already Scanned';
                                                        $result_array['color_code'] = "#f31c06";
                                                    }
                                                    echo json_encode($result_array);
                                                    die();
                                                }else{
                                                    $previously_scanned=$previously_scanned-$total_rej_qty;
                                                }
                                                
                                                if($schedule_count){
                                                    $query = "UPDATE $brandix_bts.bundle_creation_data SET `recevied_qty`= '".$final_rep_qty."', `left_over`= '".$left_over_qty."' , `scanned_date`='". date('Y-m-d')."' where bundle_number =$b_tid[$key] and operation_id = ".$b_op_id;
                                                    
                                                    $result_query = $link->query($query) or exit('query error in updating');
                                                }else{
                                                        
                                                    $bulk_insert_post .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'")';  
                                                    $result_query_001 = $link->query($bulk_insert_post) or exit('bulk_insert_post query error in updating');
                                                }
                                                
                                                if($result_query)
                                                {
                                                    if($b_rep_qty[$key] > 0)
                                                    {
                                                        $bulk_insert_post_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$previously_scanned .'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'","'.$b_remarks[$key].'","'.$username.'")';  
                                                        $result_query_001_temp = $link->query($bulk_insert_post_temp) or exit('bulk_insert_post query error in updating');
                                                        if($gate_pass_no>0)
                                                        {
                                                            $sql_gate="insert into $brandix_bts.`gatepass_track` (`gate_id`, `bundle_no`, `bundle_qty`, `style`, `schedule`, `color`, `size`,operation_id) values ('".$gate_pass_no."', ".$b_tid[$key].", '".$b_rep_qty[$key]."', '".$b_style."','".$b_schedule."','".$b_colors[$key]."','".$b_sizes[$key]."','".$b_op_id."-1')";
                                                            $result_sql_temp = $link->query($sql_gate) or exit('Gate_pass_child query error in updating');
                                                        
                                                        }
                                                        $update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$previously_scanned where doc_no = '".$b_doc_num[$key]."' and size_title='". $b_sizes[$key]."' AND operation_code in ($emb_operations)";
                                                        $update_qry_cps_log_res = $link->query($update_qry_cps_log);
                                                            
                                                    
                                                    }
                                                    $result_array['status'] = 'Bundle updated successfully !!!';
                                                    $result_array['color_code'] = "#45b645";
                                                    //echo json_encode($result_array);
                                                }
                                                

                                                                    
                                    }
                                    
                                }
                            }
                            if($table_name == 'packing_summary_input')
                            {     
                                $bulk_insert = "INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`,`mapped_color`,`barcode_sequence`,`barcode_number`) VALUES";
                                // temp table data insertion query.........
                                $bulk_insert_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `scanned_user`) VALUES";

                                    foreach ($b_tid as $key => $tid)
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

                                        if($tid == $bundle_no){
                                            $b_rep_qty[$key] = $b_in_job_qty[$key]-$total_rej_qty;
                                        }else{
                                            $b_rep_qty[$key] = 0;
                                        }

                                        $left_over_qty = $b_in_job_qty[$key] - ($b_rep_qty[$key] + $b_rej_qty[$key]);
                                        // appending all values to query for bulk insert....
                                        // if($flag == 'parallel_scanning')
                                        // {
                                        //     $b_rep_qty[$key] = $parallel_balance_report;
                                        // }else 
                                        $left_over_qty="0";
                                        $bulk_insert .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'","'.$b_remarks[$key].'","'.$mapped_color.'","'.$barcode_sequence[$key].'","'.$b_tid[$key].'"),';

                                        // temp table data insertion query.........
                                        if($b_rep_qty[$key] > 0 )
                                        {
                                            $bulk_insert_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'","'.$b_remarks[$key].'","'.$username.'"),';
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
                                // if(update_qry_cps_log_res){
                                //     //$sql_message = 'Data inserted successfully';
                                //     $result_array['status'] = 'Data inserted successfully !!!';
                                //     $result_array['color_code'] = "#45b645";
                                //     //echo json_encode($result_array);
                                // }else{
                                //     //$sql_message = 'Data Not inserted';
                                //     $result_array['status'] = 'Data Not inserted,Please verify once !!!';
                                //     $result_array['color_code'] = "#45b645";
                                //     //echo json_encode($result_array);
                                // }
                                        //all operation codes query.. (not tested)

                                        $result_array['status'] = 'Bundle updated successfully !!!';
                                        $result_array['color_code'] = "#45b645";
                                        //echo json_encode($result_array);
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
                                                    //if any rejections updated
                                                    if($total_rej_qty>0){
                                                        $final_rep_qty=$final_rep_qty-$total_rej_qty;
                                                    }

                                                    $left_over_qty = $b_in_job_qty[$key] - $final_rep_qty - $final_rej_qty;
                                                    // LAST STEP MODIFIED
                                                    $left_over_qty_update = $b_send_qty - $final_rep_qty;

                                                    $previously_scanned = $b_send_qty - ($b_old_rep_qty_new + $b_old_rej_qty_new);
                                                    
                                                    
                                                    $left_over_qty="0";
                                                    if($previously_scanned == 0){
                                                        if($b_send_qty == $b_old_rej_qty_new){
                                                            $result_array['status'] = 'This Bundle Qty Is Completely Rejected';
                                                            $result_array['color_code'] = "#f31c06";
                                                        }else{
                                                            $result_array['status'] = 'Already Scanned';
                                                            $result_array['color_code'] = "#f31c06";
                                                        }
                                                        echo json_encode($result_array);
                                                        die();
                                                    }else{
                                                        $previously_scanned=$previously_scanned-$total_rej_qty;
                                                    }
                                                    if($schedule_count){
                                                        
                                                        $query = "UPDATE $brandix_bts.bundle_creation_data SET `recevied_qty`= '".$final_rep_qty."', `left_over`= '".$left_over_qty."' , `scanned_date`='". date('Y-m-d')."' where bundle_number =$b_tid[$key] and operation_id = ".$b_op_id;
                                                        
                                                        $result_query = $link->query($query) or exit('query error in updating');
                                                    }else{
                                                            
                                                        $bulk_insert_post .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'")';	
                                                        $result_query_001 = $link->query($bulk_insert_post) or exit('bulk_insert_post query error in updating');
                                                    }
                                                
                                                    if($result_query)
                                                    {
                                                        if($b_rep_qty[$key] > 0)
                                                        {
                                                            $bulk_insert_post_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$previously_scanned .'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'","'.$b_remarks[$key].'","'.$username.'")';	
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
                                                    
                                                    if(($post_ops_code != null) && ($post_ops_code>0))
                                                    {
                                                        $query_post = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$final_rep_qty."', `scanned_date`='". date('Y-m-d')."' where bundle_number =$b_tid[$key] and operation_id = ".$post_ops_code;
                                                        $result_query = $link->query($query_post) or exit('query error in updating');
                                                    }
                                                    if(($ops_dep!=$b_op_id) && $ops_dep>0)
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
                                        //echo "<h1 style='color:red;'>You are Scanning More than eligible quantity.</h1>";
                                    $result_array['status'] = 'You are Scanning More than eligible quantity.';
                                    $result_array['color_code'] = "#f31c06";
                                    echo json_encode($result_array);
                                    die();
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
                                
                                
                                
                                $sql="SELECT COALESCE(SUM(recevied_qty),0) AS rec_qty,COALESCE(SUM(send_qty),0) AS s_qty,COALESCE(SUM(recut_in),0) AS rc_qty,COALESCE(SUM(replace_in),0) AS rp_qty,COALESCE(SUM(rejected_qty),0) AS rej_qty FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = '".$b_job_no."' AND operation_id = $operation_code";
                                $sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($sql_row=mysqli_fetch_array($sql_result))
                                {
                                        $rec_qty=$sql_row["rec_qty"];
                                        $s_qty=$sql_row["s_qty"];
                                        $rc_qty=$sql_row["rc_qty"];
                                        $rp_qty=$sql_row["rp_qty"];
                                        $rej_qty=$sql_row["rej_qty"];
                                }
                                $sql2="SELECT COALESCE(SUM(carton_act_qty),0) as job_qty FROM bai_pro3.pac_stat_log_input_job WHERE input_job_no_random='".$b_job_no."'";
                                $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($sql_row2=mysqli_fetch_array($sql_result2))
                                {
                                        $job_qty=$sql_row2["job_qty"];
                                }

                                if(($rec_qty >= $job_qty) AND ($s_qty+$rc_qty+$rp_qty=$rec_qty+$rej_qty)) 
                                {
                                    $backup_query="INSERT IGNORE INTO $bai_pro3.plan_dashboard_input_backup SELECT * FROM $bai_pro3.`plan_dashboard_input` WHERE input_job_no_random_ref='".$b_job_no."'";
                                    mysqli_query($link, $backup_query) or exit("Error while saving backup plan_dashboard_input_backup");

                                    $sqlx="delete from $bai_pro3.plan_dashboard_input where input_job_no_random_ref='".$b_job_no."'";
                                    mysqli_query($link, $sqlx) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));	
                                }
                                

                                for($i=0;$i<sizeof($b_tid);$i++)
                                {
                                    if($b_tid[$i] == $bundle_no){
                                        if($b_op_id == $operation_code)
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
                                        elseif($b_op_id == $output_ops_code)
                                        {
                                            if($b_op_id ==$operation_code)
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
                                $result_array['color_code'] = "#45b645";
                                $result_array['status'] = 'Bundle Updated successfully !!!';

                                
                                
                                //quantity count for screen
                                $result_array['counted_qty']=$result_array['reported_qty']+$total_rej_qty;

                                
                                //this is for alert message if any difference eligible and reported qty
                                if($result_array['flag']=='bundle_creation_data'){

                                    $result_array['present_eligibqty']=$result_array['prevops_sendqty']-$result_array['prevops_rejeqty'];
                                    
                                }
                                
                                //updating rejection qunatitis
                                if($total_rej_qty>0){
                                    updaterejectdetails($bundle_no, $op_no, $shift,$rej_data,$selected_module,$ops_cps_updat);
                                }else{
                                    //echo json_encode($result_array);
                                }
                                
                            }
                        
                        }
                        //echo json_encode($result_array);

                        //this is for good and rejection transmode
                        if(($trans_mode=='good') or ($trans_mode=='scrap')){
                                $barcode = $_POST['barcode_value'];
                                $selected_module=$_POST['module'];
                                $op_code=$_POST['op_code'];
                                $shift=$_POST['shift'];
                                $b_shift = $shift;
                                $rej_data= array();
                                if($trans_mode=='scrap'){
                                    $rej_data=$_POST['rej_data'];
                                }
                                $job_no=$barcode;
                                /*Below two parameters for gatepass and aunthentication due to that assigned satic values*/
                                //$gate_id = $_POST['gate_id'];
                                //$user_permission = $_POST['auth'];
                                $gate_id = "0";
                                $user_permission = "authorized";
                                //changing for #978 cr
                                $barcode_number = $barcode;
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
                                    $bundle_no = $barcode;
                                }
                                //ends on #978
                                $op_no = $op_code;
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
                                    $result_array['color_code'] = "#f31c06";
                                    echo json_encode($result_array);
                                    die();
                                }
                                else
                                {
                                    // [module,bundle_no,op_code,screen,scan_type]
                                    $stri = "0,$bundle_no,$op_no,wout_keystroke,0";
                                    
                                    //validating selected module with assigned module
                                    # bundle level
                                    $get_module_no = "SELECT input_module FROM $bai_pro3.plan_dashboard_input where input_job_no_random_ref in (select input_job_no_random from $bai_pro3.pac_stat_log_input_job where tid=$job_no)";
                                    $get_module_no_bcd = "SELECT assigned_module FROM $brandix_bts.bundle_creation_data WHERE bundle_number = '$job_no'";
                                    $module_rsult = $link->query($get_module_no);
                                    $module=0;
                                    if (mysqli_num_rows($module_rsult) > 0)
                                    {
                                        while($sql_row11 = $module_rsult->fetch_assoc()) 
                                        {
                                            $module = $sql_row11['input_module'];

                                        }
                                    }
                                    else
                                    {
                                        $module_rsult_bcd = $link->query($get_module_no_bcd);
                                        while($sql_row11_bcd = $module_rsult_bcd->fetch_assoc()) 
                                        {
                                            $module = $sql_row11_bcd['assigned_module'];
                                        }
                                    }
                                    if($module>0){
                                            if($selected_module!=$module){
                                                $result_array['status'] = 'Please verify slected module once..!';
                                                $result_array['color_code'] = "#f31c06";
                                                echo json_encode($result_array);
                                                die();
                                            }
                                    }else{
                                            $result_array['status'] = 'No module assigned for this Bundle...!';
                                            $result_array['color_code'] = "#f31c06";
                                            echo json_encode($result_array);
                                            die();
                                    }
                                    

                                    $ret = validating_with_module($stri);
                                    // 5 = Trims not issued to Module, 4 = No module for sewing job, 3 = No valid Block Priotities, 2 = check for user access (block priorities), 0 = allow for scanning
                                    if ($ret == 5) {
                                        $result_array['status'] = 'Trims Not Issued';
                                        $result_array['color_code'] = "#f31c06";
                                        echo json_encode($result_array);
                                        die();
                                    } else if ($ret == 4) {
                                        $result_array['status'] = 'No module for Bundle';
                                        $result_array['color_code'] = "#f31c06";
                                        echo json_encode($result_array);
                                        die();
                                    } else if ($ret == 3) {
                                        $result_array['status'] = 'No valid Block Priotities';
                                        $result_array['color_code'] = "#f31c06";
                                        echo json_encode($result_array);
                                        die();
                                    } else if ($ret == 2) {
                                        if ($user_permission == 'authorized') {
                                            getjobdetails1($string, $bundle_no, $op_no, $shift ,$gate_id,$trans_mode,$rej_data,$selected_module);
                                        } else {
                                            $result_array['status'] = 'You are Not Authorized to report more than Block Priorities';
                                            $result_array['color_code'] = "#f31c06";
                                            echo json_encode($result_array);
                                            die();
                                        }
                                    } else if ($ret == 0) {

                                        getjobdetails1($string, $bundle_no, $op_no, $shift ,$gate_id,$trans_mode,$rej_data,$selected_module);
                                    }        
                                }

                        }

                        //this is for rwork qunatity
                        if($trans_mode=='rework'){
                            //echo $trans_mode;
                            include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");

                            $barcode = $_POST['barcode_value'];
                            $selected_module=$_POST['module'];
                            $op_code=$_POST['op_code'];
                            $shift=$_POST['shift'];

                            $sql = "select * from $brandix_bts.bundle_creation_data where operation_id='$op_code' and bundle_number=$barcode";
                            $sql_result=mysqli_query($link, $sql) or exit("Sql Error111".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $rework_qty=0;
                            while($sql_row=mysqli_fetch_array($sql_result))
                            {
                                $original_qty = $sql_row['original_qty'];
                                $send_qty = $sql_row['send_qty'];
                                $recevied_qty = $sql_row['recevied_qty'];
                                $rejected_qty = $sql_row['rejected_qty'];
                                $shift= $sql_row['shift'];
                                $assigned_module=$sql_row['assigned_module'];
                                $date_time=$sql_row['date_time'];
                                $color=$sql_row['color'];
                                $style=$sql_row['style'];
                                $schedule=$sql_row['schedule'];
                                $remarks=$sql_row['remarks'];
                                // echo $remarks;  
                            
                                $sql1 = "SELECT section FROM bai_pro3.`module_master` where module_name='$assigned_module'";
                                $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($sql_row1=mysqli_fetch_array($sql_result1))
                                {
                                    $section = $sql_row1['section'];
                                }
                                $sql11 = "SELECT buyer_division FROM $bai_pro4.bai_cut_to_ship_ref where style='$style' and schedule_no='$schedule' and color='$color'"; 
                                $sql_result=mysqli_query($link, $sql11) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($sql_row=mysqli_fetch_array($sql_result))
                                {
                                    $buyer_division = $sql_row['buyer_division'];
                                }

                                $rework_qty =  $send_qty-($recevied_qty+$rejected_qty);
                            }
                            
                            if($rework_qty>0)
                            {
                                $sql2="insert into $bai_pro.bai_quality_log (bac_no, bac_sec, bac_qty, bac_lastup, bac_date, bac_shift, bac_style, bac_remarks,  log_time, color, buyer, delivery, loguser) values (\"$assigned_module\", \"$section\", \"$rework_qty\",NOW(),NOW(),\"$shift\", \"$style\", \"$remarks\",NOW(),\"$color\", \"$buyer_division\", \"$schedule\",USER())";
                                //echo $sql2;exit;
                                $sql_resultx = mysqli_query($link, $sql2) or exit("Sql Error2$sql2".mysqli_error($GLOBALS["___mysqli_ston"]));
                                if($sql_resultx){
                                    $result_array['status'] = 'Rework qunatity updated successfully..!';
                                    $result_array['color_code'] = "#45b645";
                                    // echo json_encode($result_array);
                                    // die();
                                }else{
                                    $result_array['status'] = 'Bundle not updated..!';
                                    $result_array['color_code'] = "#f31c06";
                                    echo json_encode($result_array);
                                    die();
                                } 
                            }
                            else{
                                //echo "<script>alert('orginal quatity must be less than are equl to rework quantity ');</script>";
                                $result_array['status'] = 'No qunatity for rework...!';
                                $result_array['color_code'] = "#f31c06";
                                echo json_encode($result_array);
                                die();
                            }
                        }
                                
                        }

                //this is for reverse transactions for both good and rejections
                if($trans_action=="reverse"){
                    //this is for good reversal
                    $trans_mode=$_POST['trans_mode'];
                    if($trans_mode=='good'){
                            //error_reporting(0);
                            $barcode_val = $_POST['barcode_value'];
                            $selected_module=$_POST['module'];
                            $op_code=$_POST['op_code'];
                            $shift=$_POST['shift'];
                            $b_shift = $shift;
                            //echo "Code : ".$barcode." - Module : ".$selected_module."  Op code : ".$op_code." - Shift :".$shift;
                            //validating for barcode existed/module assigned/remarks/qunatity
                            $qry_bundledetails="SELECT * FROM $brandix_bts.bundle_creation_data WHERE bundle_number = $barcode_val AND operation_id=$op_code";
                                //echo "$qry_bundledetails";
                                $result_qry_bundledetails = $link->query($qry_bundledetails);
                                if($result_qry_bundledetails->num_rows > 0){
                                    while($row_barcodedetails = $result_qry_bundledetails->fetch_assoc())
                                    {
                                        $recieved_qty=$row_barcodedetails['recevied_qty'];
                                        $assigned_module=$row_barcodedetails['assigned_module'];
                                        $remarks=$row_barcodedetails['remarks'];
                                        
                                    }
                                    //validating barcode
                                    if($recieved_qty>0)
                                    {
                                            if($assigned_module>0)
                                            {
                                                    if($remarks != null && $remarks != '')
                                                    {
                                                        //echo "Proceed";
                                                    }else{
                                                        $result_array['status'] = 'Remarks not updated for this bundle... !!!';
                                                        $result_array['color_code'] = "#f31c06";
                                                        echo json_encode($result_array);
                                                        die(); 
                                                    }
                                            }else{
                                                $result_array['status'] = 'No module assigned for this bundle... !!!';
                                                $result_array['color_code'] = "#f31c06";
                                                echo json_encode($result_array);
                                                die();  
                                            }
                                    }else{
                                        $result_array['status'] = 'No eligible qunatity for reversal... !!!';
                                        $result_array['color_code'] = "#f31c06";
                                        echo json_encode($result_array);
                                        die();
                                    }

                                    //echo"Yasss";
                                    //[ops,job_no,remarks,module1]
                                    function reversalupdate($job_number)
                                    {       
                                            global $result_array;                           
                                            $job_number = explode(",",$job_number);
                                            $module1 = $job_number[3];
                                            include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
                                            include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/m3Updations.php");
                                            //verifing next operation done are not
                                            $getting_style_qry ="select style,mapped_color as color from $brandix_bts.bundle_creation_data where bundle_number = $job_number[1] and assigned_module='$module1' group by style";
                                            $result_getting_style_qry = $link->query($getting_style_qry);
                                            while($row = $result_getting_style_qry->fetch_assoc()) 
                                            {
                                                $style = $row['style'];
                                                $color = $row['color'];
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
                                            $ops_seq_check = "select id,ops_sequence,ops_dependency,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code=$job_number[0]";
                                            $result_ops_seq_check = $link->query($ops_seq_check);
                                            while($row = $result_ops_seq_check->fetch_assoc()) 
                                            {
                                                $ops_seq = $row['ops_sequence'];
                                                $seq_id = $row['id'];
                                                $ops_order = $row['operation_order'];
                                                if($row['ops_dependency'] != null)
                                                {
                                                    $ops_dep = $row['ops_dependency'];
                                                    //$result_array['ops_dep'] = $ops_dep;
                                                }
                                                else
                                                {
                                                    //$result_array['ops_dep'] = 0;
                                                    $ops_dep=0;
                                                }
                                            }
                                            $checking_flag = 0;
                                            $ops_dep_check = "select ops_dependency from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_sequence = '$ops_seq' and ops_dependency != 0 and ops_dependency != '' and operation_code = $job_number[0]";
                                            $result_ops_dep_check = $link->query($ops_dep_check);
                                            if($result_ops_dep_check->num_rows > 0)
                                            {
                                                $checking_flag = 1;
                                                while($row = $result_ops_dep_check->fetch_assoc()) 
                                                {
                                                    $ops_dependency = $row['ops_dependency'];
                                                }
                                            }                                  
                                            $post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) > '$ops_order' and operation_code not in (10,200,15) ORDER BY operation_order ASC LIMIT 1";
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
                                            //$result_array['post_ops'][] = $post_ops_code;
                                            $post_ops=$post_ops_code;
                                            if($post_ops_code != 0)
                                            {
                                                $pre_ops_validation = "SELECT id,(sum(recevied_qty)+sum(rejected_qty)) as recevied_qty,send_qty,size_title,bundle_number,color,assigned_module FROM $brandix_bts.bundle_creation_data_temp WHERE bundle_number =$job_number[1] and assigned_module='$module1' AND operation_id = $job_number[0] GROUP BY size_title,color,assigned_module order by bundle_number";
                                                $result_pre_ops_validation = $link->query($pre_ops_validation);
                                                while($row = $result_pre_ops_validation->fetch_assoc()) 
                                                {                                            
                                                    $b_number = $row['bundle_number'];
                                                    $sizes = $row['size_title'];
                                                    $size_code = $row['size_title'];
                                                    $color = $row['color'];
                                                    $assigned_module = $row['assigned_module'];
                                                    $post_ops_qry_to_find_rec_qty = "select group_concat(bundle_number) as bundles,(SUM(recevied_qty)+SUM(rejected_qty)) AS recevied_qty,size_title from $brandix_bts.bundle_creation_data_temp WHERE bundle_number =$job_number[1] AND operation_id = $post_ops_code and remarks='$job_number[2]' and size_title='$size_code' and color='$color' and assigned_module = '$assigned_module' GROUP BY size_title,color,assigned_module order by bundle_number";
                                                    //echo "$post_ops_qry_to_find_rec_qty";
                                                    $result_post_ops_qry_to_find_rec_qty = $link->query($post_ops_qry_to_find_rec_qty);
                                                    if($result_post_ops_qry_to_find_rec_qty->num_rows > 0)
                                                        {
                                                            while($row3 = $result_post_ops_qry_to_find_rec_qty->fetch_assoc()) 
                                                            {   
                                                                $remaining_qty=0;
                                                                $eligible=0;
                                                                $mo_no_qty=array();
                                                                $mo_no=array();
                                                                $bundle_ids=array();
                                                                $bundle_ids=$row3['bundles'];
                                                                $qty=$row3['recevied_qty'];
                                                        $bundle_mo = "SELECT mo_no from $bai_pro3.mo_operation_quantites WHERE ref_no in (".$bundle_ids.") AND op_code = $post_ops_code group by mo_no order by mo_no*1";
                                                                $result_bundle_mo = $link->query($bundle_mo);
                                                                while($row1 = $result_bundle_mo->fetch_assoc()) 
                                                                {
                                                                    $mo_no[]=$row1['mo_no'];
                                                                }
                                                                //var_dump($mo_no);
                                                                $check_ops = "SELECT * from $bai_pro3.tbl_carton_ready WHERE mo_no in ('".implode("','",$mo_no)."') AND operation_id = $job_number[0] group by mo_no order by mo_no*1";
                                                                // echo $check_ops.'<br>';
                                                                $result_check_ops = $link->query($check_ops);
                                                                if($result_check_ops->num_rows > 0)
                                                                {
                                                                    while($row2 = $result_check_ops->fetch_assoc()) 
                                                                    {
                                                                        $remaining_qty=$row2['remaining_qty'];
                                                                        if($qty>0)
                                                                        {
                                                                            if($qty>=$remaining_qty)
                                                                            {
                                                                                if ($remaining_qty > 0)
                                                                                {
                                                                                    $eligible=$eligible+$remaining_qty;
                                                                                    $qty=$qty-$remaining_qty;
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                                $eligible=$eligible+$qty;
                                                                                $qty=0;
                                                                            }
                                                                        }                           
                                                                    }
                                                                    //$result_array['rec_qtys'][] = $eligible;
                                                                    $rec_qtys=$eligible;
                                                                    //$result_array['carton_ready_qty'][] = $eligible;
                                                                    $carton_ready_qty=$eligible;
                                                                    $conditional_flag=0;

                                                                }
                                                                else
                                                                {
                                                                    //$result_array['rec_qtys'][] = $qty;
                                                                    $rec_qtys=$qty;
                                                                    $conditional_flag=1;
                                                                }    
                                                            }
                                                    }
                                                    else
                                                    {
                                                        //$result_array['rec_qtys'][] = 0;
                                                        $rec_qtys=0;
                                                        $conditional_flag=1;
                                                    }
                                                }
                                            }
                                            else
                                            {
                                                $pre_ops_validation = "SELECT id,sum(recevied_qty) as recevied_qty,send_qty,size_title,bundle_number,color,assigned_module FROM $brandix_bts.bundle_creation_data_temp WHERE bundle_number ='$job_number[1]' and assigned_module='$module1' AND operation_id = $job_number[0] GROUP BY size_title,color,assigned_module order by bundle_number";
                                                $result_pre_ops_validation = $link->query($pre_ops_validation);
                                                while($row = $result_pre_ops_validation->fetch_assoc()) 
                                                {
                                                    $b_number = $row['bundle_number'];
                                                    $size_code = $row['size_title'];
                                                    $color = $row['color'];
                                                    $assigned_module = $row['assigned_module'];
                                                    //if($checking_flag == 1)
                                                    {
                                                        $post_ops_qry_to_find_rec_qty = "select group_concat(bundle_number) as bundles,(SUM(recevied_qty)) AS recevied_qty,size_title from $brandix_bts.bundle_creation_data_temp WHERE bundle_number ='$job_number[1]' AND operation_id = $job_number[0] and remarks='$job_number[2]' and size_title='$size_code' and color='$color' and assigned_module = '$assigned_module' GROUP BY size_title,color,assigned_module order by bundle_number";
                                                        $result_post_ops_qry_to_find_rec_qty = $link->query($post_ops_qry_to_find_rec_qty);
                                                        if($result_post_ops_qry_to_find_rec_qty->num_rows > 0)
                                                        {
                                                            while($row = $result_post_ops_qry_to_find_rec_qty->fetch_assoc()) 
                                                            {   
                                                                $remaining_qty=0;
                                                                $eligible=0;
                                                                $mo_no_qty=array();
                                                                $mo_no=array();
                                                                $bundle_ids=array();
                                                                $bundle_ids=$row['bundles'];
                                                                $qty=$row['recevied_qty'];
                                                                $bundle_mo = "SELECT mo_no from $bai_pro3.mo_operation_quantites WHERE ref_no in (".$bundle_ids.") AND op_code = $job_number[0] group by mo_no order by mo_no*1";
                                                                // echo $bundle_mo.'<br>';
                                                                $result_bundle_mo = $link->query($bundle_mo);
                                                                while($row1 = $result_bundle_mo->fetch_assoc()) 
                                                                {
                                                                    $mo_no[]=$row1['mo_no'];
                                                                }
                                                                // var_dump($mo_no);
                                                                $check_ops = "SELECT * from $bai_pro3.tbl_carton_ready WHERE mo_no in ('".implode("','",$mo_no)."') AND operation_id = $job_number[0] group by mo_no order by mo_no*1";
                                                                // echo $check_ops.'<br>';exit;
                                                                $result_check_ops = $link->query($check_ops);
                                                                if($result_check_ops->num_rows > 0)
                                                                {
                                                                    while($row2 = $result_check_ops->fetch_assoc()) 
                                                                    {
                                                                        $remaining_qty=$row2['remaining_qty'];
                                                                        if($qty>0)
                                                                        {
                                                                            if($qty>=$remaining_qty)
                                                                            {
                                                                                if ($remaining_qty > 0)
                                                                                {
                                                                                    $eligible=$eligible+$remaining_qty;
                                                                                    $qty=$qty-$remaining_qty;
                                                                                }                                           
                                                                            }
                                                                            else
                                                                            {
                                                                                $eligible=$eligible+$qty;
                                                                                $qty=0;
                                                                            }
                                                                        }                           
                                                                    }
                                                                    //$result_array['rec_qtys'][] = $eligible;
                                                                    //$result_array['carton_ready_qty'][] = $eligible;
                                                                    $rec_qtys = $eligible;
                                                                    $carton_ready_qty = $eligible;
                                                                    $conditional_flag=0;
                                                                }
                                                                else
                                                                {
                                                                    $rec_qtys = 0;
                                                                    $conditional_flag=1;
                                                                }    
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $rec_qtys = 0;
                                                            $conditional_flag=1;
                                                        }
                                                    }
                                                }
                                                
                                            }
                                            if($conditional_flag==0){
                                                $post_rec_qtys_array123 = $carton_ready_qty;
                                                $check_flag = 2;
                                            }else{
                                                if($conditional_flag==1){
                                                    $post_rec_qtys_array = $rec_qtys;
                                                    $check_flag = 1;  
                                                }
                                            }
                                            
                                            $job_details_qry = "SELECT id,style,`color` AS order_col_des,`size_title` AS size_code,`bundle_number` AS tid,`original_qty` AS carton_act_qty,SUM(`recevied_qty`) AS reported_qty,SUM(rejected_qty) AS rejected_qty,(SUM(send_qty)-SUM(recevied_qty)) AS balance_to_report,`docket_number` AS doc_no, `cut_number` AS acutno, `input_job_no`,`input_job_no_random_ref` AS input_job_no_random, 'bundle_creation_data' AS flag,operation_id,remarks,size_id,assigned_module,shift FROM $brandix_bts.bundle_creation_data_temp WHERE bundle_number = $job_number[1] and assigned_module='$module1' AND operation_id = $job_number[0] AND remarks = '$job_number[2]' GROUP BY size_title,color,assigned_module order by bundle_number";
                                            $job_details_qry_result = $link->query($job_details_qry);
                                            
                                            if($job_details_qry_result->num_rows > 0)
                                            {   
                                                while($row = $job_details_qry_result->fetch_assoc()) 
                                                {
                                                    $size_code = $row['size_code'];
                                                    $color = $row['order_col_des'];
                                                    $module = $row['assigned_module'];
                                                    $reported_qty = $row['reported_qty'];
                                                    $doc_no_post = $row['doc_no'];
                                                    $operation_id = $row['operation_id'];
                                                    $remarks = $row['remarks'];
                                                    $size_id_post = $row['size_id'];
                                                    $input_job_no_random = $row['input_job_no_random'];
                                                    $style = $row['style'];
                                                    $shift = $row['shift'];
                                                    $job_qty_qry = "select sum(original_qty) AS carton_act_qty,mapped_color FROM $brandix_bts.bundle_creation_data where bundle_number = $job_number[1] AND operation_id = $job_number[0] AND size_title ='$size_code' AND color='$color' and assigned_module ='$module' order by bundle_number";

                                                    $result_job_qty_qry = $link->query($job_qty_qry);
                                                    while($row_result_job_qty_qry = $result_job_qty_qry->fetch_assoc()) 
                                                    {
                                                        $carton_act_qty = $row_result_job_qty_qry['carton_act_qty'];
                                                        $mapped_color = $row_result_job_qty_qry['mapped_color'];
                                                    }
                                                    //$result_array['table_data'][] = $row;
                                                }
                                            }
                                            else
                                            {
                                                $result_array['status'] = 'Invalid Operation';
                                                $result_array['color_code'] = "#f31c06";  
                                                echo json_encode($result_array);
                                                die();
                                            }
                                            if ($check_flag == 2)
                                                    {
                                                        $post_rec_qtys =$post_rec_qtys_array123;
                                                    }
                                                    else
                                                    {
                                                        if($check_flag == 0)
                                                        {
                                                            $post_rec_qtys = $reported_qty;
                                                        }
                                                        else
                                                        {
                                                            $post_rec_qtys = $reported_qty - $post_rec_qtys_array;
                                                        }
                                                    }
                                        if($post_rec_qtys>0){
                                                //updates start here 
                                            mysqli_begin_transaction($link);
                                            try{
                                                    function message_sql()
                                                    {   
                                                        global $result_array;
                                                        $result_array['status'] = 'Reversing Quantity not updated......please update again !!!';
                                                        $result_array['color_code'] = "#f31c06";
                                                        //echo json_encode($result_array);
                                                        //echo "<script>swal('Reversing Quantity not updated......please update again','','warning');</script>";
                                                        //$url = '?r='.$_GET['r']."&shift=$b_shift";
                                                        //echo "<script>setTimeout(function() {window.location = '".$url."'},2000);</script>";
                                                    }
                                                //$ids = $_POST['id'];
                                                $bundle_no[] = $job_number[1];
                                                $reversalval[] = $post_rec_qtys;
                                                //$rep_qty = $_POST['rep_qty'];
                                                $ops_dep = $ops_dep;
                                                $style = $style;
                                                $order_col_des[] = $color;
                                                $size[] = $size_code;
                                                $doc_no[] = $doc_no_post;
                                                $operation_id = $operation_id;
                                                $remarks = $remarks;
                                                $size_id[] = $size_id_post;
                                                $input_job_no_random = $input_job_no_random;
                                                $mapped_color = $mapped_color;
                                                $b_module[] = $module;
                                                $b_shift  = $shift;
                                                //var_dump($ops_dep);
                                                //$post_code = array();
                                                $post_code[] = $post_ops;
                                                foreach($bundle_no as $key => $value)
                                                {
                                                    $module_cum = $b_module[$key];
                                                    $query_to_fetch_individual_bundles = "select * FROM $brandix_bts.bundle_creation_data where color = '$order_col_des[$key]' and size_title = '$size[$key]' and bundle_number = $job_number[1] AND operation_id = '$operation_id' AND assigned_module = '$module_cum' order by barcode_sequence";
                                                    $cumulative_reversal_qty = $reversalval[$key];
                                                    $qry_nop_result=mysqli_query($link,$query_to_fetch_individual_bundles) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                    $remaining_val_to_reverse = 0;
                                                    while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
                                                    {
                                                        $b_colors_1[] =  $nop_qry_row['color'];
                                                        $b_sizes_1[] =  $nop_qry_row['size_title'];
                                                        $b_size_code_1[] = $nop_qry_row['size_id'];
                                                        $b_in_job_qty[] = $nop_qry_row['original_qty'];
                                                        $b_a_cut_no_1[] = $nop_qry_row['cut_number'];
                                                        $b_doc_num_1[] = $nop_qry_row['docket_number'];
                                                        $b_inp_job_ref[] = $nop_qry_row['input_job_no_random_ref'];
                                                        $b_remarks_1 = $remarks;
                                                        $b_module1[] = $module_cum;
                                                        //$bundle_individual_number = $nop_qry_row['bundle_number'];
                                                        $bundle_individual_number = $nop_qry_row['bundle_number'];
                                                        // $bundle_individual_number = $nop_qry_row['tid'];
                                                        $actual_bundles[] = $nop_qry_row['bundle_number'];
                                                        if($post_code[0] != '0')
                                                        {
                                                            $query_to_fetch_individual_bundle_details = "select (send_qty-recevied_qty)as recevied_qty  FROM $brandix_bts.bundle_creation_data where bundle_number = '$bundle_individual_number' and operation_id='$post_code[0]'";
                                                        }
                                                        else
                                                        {
                                                            $query_to_fetch_individual_bundle_details = "select recevied_qty  FROM $brandix_bts.bundle_creation_data where bundle_number = '$bundle_individual_number' and operation_id='$operation_id'";
                                                        }
                                                        
                                                        // echo $query_to_fetch_individual_bundle_details;
                                                        $result_query_to_fetch_individual_bundle_details=mysqli_query($link,$query_to_fetch_individual_bundle_details) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                        if($remaining_val_to_reverse > 0)
                                                        {
                                                            $cumulative_reversal_qty = $remaining_val_to_reverse;
                                                        }
                                                        while($row_result_query_to_fetch_individual_bundle_details=mysqli_fetch_array($result_query_to_fetch_individual_bundle_details))
                                                        {

                                                            $rec_qty = $row_result_query_to_fetch_individual_bundle_details['recevied_qty'];
                                                            // echo $bundle_individual_number.'-'.$rec_qty.'-'.$cumulative_reversal_qty.'</br>';
                                                            if($rec_qty > 0)
                                                            {
                                                                if($cumulative_reversal_qty <= $rec_qty)
                                                                {
                                                                    $actual_reversal_val_array [] = $cumulative_reversal_qty;
                                                                    $cumulative_reversal_qty = 0;
                                                                }
                                                                else
                                                                {
                                                                    $actual_reversal_val_array [] = $rec_qty;
                                                                    $cumulative_reversal_qty = $cumulative_reversal_qty - $rec_qty;
                                                                }					
                                                            }
                                                            else
                                                            {
                                                                $actual_reversal_val_array [] = $rec_qty;
                                                            }
                                                        }			
                                                    }
                                                }
                                                $color =array();
                                                $bundle_no = array();
                                                $size = array();
                                                $doc_no = array();
                                                $size_id = array();
                                                $reversalval = array();
                                                $b_module = array();
                                                //$color = $b_colors_1;
                                                $size_id = $b_sizes_1;
                                                $size = $b_size_code_1;
                                                $doc_no = $b_doc_num_1;
                                                $remarks =$b_remarks_1;
                                                $bundle_no = $actual_bundles;
                                                $concurrent_flag = 0;
                                                $reversalval = $actual_reversal_val_array;
                                                $b_module = $b_module1;

                                                //getting sfcs_smv
                                                $smv_query = "select smv from $brandix_bts.tbl_style_ops_master where style='$style' and color='$mapped_color' 
                                                            and operation_code = $operation_id";
                                                $result_smv_query = $link->query($smv_query);
                                                while($row_ops = $result_smv_query->fetch_assoc()) 
                                                {
                                                    $sfcs_smv = $row_ops['smv'];
                                                }

                                                // echo "post code".$post_code;
                                                $ops_seq_check = "select id,ops_sequence,ops_dependency,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$mapped_color' and operation_code='$operation_id'";
                                                $result_ops_seq_check = $link->query($ops_seq_check);
                                                while($row = $result_ops_seq_check->fetch_assoc()) 
                                                {
                                                    $ops_seq = $row['ops_sequence'];
                                                    $seq_id = $row['id'];
                                                    $ops_dependency = $row['ops_dependency'];
                                                    $ops_order = $row['operation_order'];
                                                }
                                                $post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$mapped_color' AND ops_sequence = $ops_seq AND CAST(operation_order AS CHAR) < '$ops_order' and operation_code NOT IN  (10,200) ORDER BY operation_order DESC LIMIT 1";
                                                $result_post_ops_check = $link->query($post_ops_check);
                                                if($result_post_ops_check->num_rows > 0)
                                                {
                                                    while($row = $result_post_ops_check->fetch_assoc()) 
                                                    {
                                                        $post_ops_code = $row['operation_code'];
                                                    }
                                                }
                                                foreach ($bundle_no as $key=>$value)
                                                {
                                                    $act_reciving_qty = $reversalval[$key];
                                                    //echo "rep_qty_rep".$rep_qty[$key]."</br>";
                                                    //	echo "rep_qty".$act_reciving_qty."</br>";
                                                    $select_send_qty = "select (SUM(recevied_qty)) AS recevied_qty,size_title from  $brandix_bts.bundle_creation_data_temp WHERE operation_id = $operation_id and remarks='$remarks' and bundle_number='$bundle_no[$key]' group by bundle_number order by bundle_number";
                                                    $result_select_send_qty = $link->query($select_send_qty);
                                                    while($row = $result_select_send_qty->fetch_assoc()) 
                                                    {
                                                        //$send_qty = $row['send_qty'];
                                                        $pre_recieved_qty = $row['recevied_qty'];
                                                        $total_rec_qty = $pre_recieved_qty - $act_reciving_qty;
                                                    }
                                                    if($post_ops_code)
                                                    {
                                                        $post_ops_qry_to_find_rec_qty = "select (SUM(recevied_qty)) AS recevied_qty,size_title from  $brandix_bts.bundle_creation_data_temp WHERE operation_id = $post_ops_code and remarks='$remarks' and bundle_number='$bundle_no[$key]' group by bundle_number order by bundle_number";
                                                        //echo $post_ops_qry_to_find_rec_qty;
                                                        $result_post_ops_qry_to_find_rec_qty = $link->query($post_ops_qry_to_find_rec_qty);
                                                        if($result_post_ops_qry_to_find_rec_qty->num_rows > 0)
                                                        {
                                                            while($row = $result_post_ops_qry_to_find_rec_qty->fetch_assoc()) 
                                                            {	
                                                                $post_rec_qty = $row['recevied_qty'];
                                                                if(($pre_recieved_qty - $post_rec_qty) < $act_reciving_qty)
                                                                {
                                                                    //$concurrent_flag = 1;
                                                                }
                                                            }
                                                        }
                                                    }
                                                    else if($ops_dependency)
                                                    {
                                                        $post_ops_qry_to_find_rec_qty = "select (SUM(recevied_qty)) AS recevied_qty,size_title from  $brandix_bts.bundle_creation_data_temp WHERE operation_id = $ops_dep and remarks='$remarks' and bundle_number='$bundle_no[$key]' group by bundle_number order by bundle_number";
                                                        //echo $post_ops_qry_to_find_rec_qty;
                                                        $result_post_ops_qry_to_find_rec_qty = $link->query($post_ops_qry_to_find_rec_qty);
                                                        if($result_post_ops_qry_to_find_rec_qty->num_rows > 0)
                                                        {
                                                            while($row = $result_post_ops_qry_to_find_rec_qty->fetch_assoc()) 
                                                            {	
                                                                $post_rec_qty = $row['recevied_qty'];
                                                                if(($pre_recieved_qty - $post_rec_qty) < $act_reciving_qty)
                                                                {
                                                                    //$concurrent_flag = 1;
                                                                }
                                                            }
                                                        }
                                                    }
                                                    else if($total_rec_qty < 0)
                                                    {
                                                        
                                                        $concurrent_flag = 1;
                                                    }
                                                }
                                                if($concurrent_flag == 1)
                                                {
                                                    //echo "<h1 style='color:red;'>You are Reversing More than eligible quantity.</h1>";
                                                    $result_array['status'] = 'You are Reversing More than eligible quantity... !!!';
                                                    $result_array['color_code'] = "#f31c06";
                                                    echo json_encode($result_array);
                                                    die();
                                                }
                                                else if($concurrent_flag == 0)
                                                {   
                                                    foreach($bundle_no as $key=>$value)
                                                    {
                                                        $fetching_id_qry = "select id,recevied_qty from $brandix_bts.bundle_creation_data where bundle_number = $bundle_no[$key] and operation_id = $operation_id";
                                                        $result_fetching_id_qry = $link->query($fetching_id_qry)  or exit('query error in updating1');
                                                        while($row = $result_fetching_id_qry->fetch_assoc()) 
                                                        {
                                                            $id = $row['id'];
                                                            $rec_qty = $row['recevied_qty'];
                                                        }
                                                        $act_rec_qty = $rec_qty - $reversalval[$key];
                                                    
                                                        $update_present_qry = "update $brandix_bts.bundle_creation_data  set recevied_qty = $act_rec_qty where id = $id";
                                                        $result_query = $link->query($update_present_qry) or exit(message_sql());
                                                        if($post_code)
                                                        {
                                                            $query_post_dep = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$act_rec_qty."', `scanned_date`='". date('Y-m-d')."' where bundle_number ='".$bundle_no[$key]."' and operation_id = ".$post_code[0];
                                                            $result_query = $link->query($query_post_dep) or exit(message_sql());
                                                        }
                                                    }
                                                    $dep_ops_codes = array();
                                                    if($ops_dep != 0)
                                                    {
                                                        $dep_ops_array_qry_raw = "select operation_code from $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$mapped_color' and ops_dependency='$ops_dep'";
                                                        //echo $dep_ops_array_qry_raw;
                                                        $result_dep_ops_array_qry_raw = $link->query($dep_ops_array_qry_raw) or exit('query error in updating 4');
                                                        while($row = $result_dep_ops_array_qry_raw->fetch_assoc()) 
                                                        {
                                                            $dep_ops_codes[] = $row['operation_code'];	
                                                        }
                                                    }
                                                    //var_dump($dep_ops_codes);
                                                    if(count($dep_ops_codes)>0)
                                                    {
                                                        foreach($bundle_no as $key=>$value)
                                                        {
                                                            $pre_send_qty_qry = "select min(recevied_qty)as recieved_qty from $brandix_bts.bundle_creation_data where bundle_number ='".$bundle_no[$key]."' and operation_id in (".implode(',',$dep_ops_codes).")";
                                                            //echo $pre_send_qty_qry;
                                                            $result_pre_send_qty = $link->query($pre_send_qty_qry) or exit('query error in updating 5');
                                                            while($row = $result_pre_send_qty->fetch_assoc()) 
                                                            {
                                                                $pre_recieved_qty = $row['recieved_qty'];
                                                            }
                                                            $query_post_dep = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$pre_recieved_qty."', `scanned_date`='". date('Y-m-d')."' where bundle_number ='".$bundle_no[$key]."' and operation_id = ".$ops_dep;
                                                            // echo $query_post_dep;
                                                            $result_query = $link->query($query_post_dep) or exit(message_sql());
                                                        }
                                                    }
                                                    $b_tid = '';
                                                    foreach($bundle_no as $key=>$value)
                                                    {
                                                        $retriving_data = "select * from $brandix_bts.bundle_creation_data where bundle_number = $bundle_no[$key] and operation_id = $operation_id";
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
                                                        $b_sizes = $size_id[$key];
                                                        $b_doc_num = $doc_no[$key];
                                                        $b_tid = $value;
                                                        if($reversalval[$key] > 0)
                                                        {
                                                            $r_qty_array = '-'.$reversalval[$key];
                                                            $b_tid = $bundle_no[$key];
                                                                
                                                            $bulk_insert_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`scanned_user`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`) VALUES";
                                                            $bulk_insert_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors.'","'.$size_id.'","'. $size_title.'","'. $sfcs_smv.'","'.$b_tid.'","'.$b_in_job_qty.'","'.$b_in_job_qty.'","'.$r_qty_array.'","0","0","'. $b_op_id.'","'.$b_doc_num.'","'.date('Y-m-d').'","'.$b_a_cut_no.'","'.$b_inp_job_ref.'","'.$username.'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'","'.$remarks.'"),';
                                                            //echo $bulk_insert_temp;
                                                            if(substr($bulk_insert_temp, -1) == ',')
                                                            {
                                                                $final_query_000_temp = substr($bulk_insert_temp, 0, -1);
                                                            }
                                                            else
                                                            {
                                                                $final_query_000_temp = $bulk_insert_temp;
                                                            }
                                                            $bundle_creation_result_temp = $link->query($final_query_000_temp) or exit(message_sql($b_shift));
                                                            //Checking with ims_log 
                                                        }

                                                        $appilication = 'IMS_OUT';
                                                        $checking_output_ops_code = "SELECT operation_code from $brandix_bts.tbl_ims_ops where appilication='$appilication'";
                                                        // echo $checking_output_ops_code;
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
                                                        // echo 'b_op_id.'.$b_op_id;
                                                        // echo 'operation_code.'.$operation_code;
                                                        if($b_op_id == $operation_code)
                                                        {
                                                            $searching_query_in_imslog = "SELECT * FROM $bai_pro3.ims_log WHERE pac_tid = '$b_tid' AND ims_mod_no='$b_module[$key]' AND ims_style='$b_style' AND ims_schedule='$b_schedule' AND ims_color='$b_colors' AND input_job_rand_no_ref='$b_job_no' AND operation_id='$b_op_id' AND ims_remarks = '$remarks'";
                                                            //echo $searching_query_in_imslog;
                                                            $result_searching_query_in_imslog = $link->query($searching_query_in_imslog);
                                                            if($result_searching_query_in_imslog->num_rows > 0)
                                                            {
                                                                while($row = $result_searching_query_in_imslog->fetch_assoc()) 
                                                                {
                                                                    $updatable_id = $row['tid'];
                                                                    $pre_ims_qty = $row['ims_qty'];
                                                                    $pre_pro_ims_qty = $row['ims_pro_qty'];
                                                                }
                                                                $act_ims_qty = $pre_ims_qty - $reversalval[$key];
                                                                //updating the ims_qty when it was there in ims_log
                                                                $update_query = "update $bai_pro3.ims_log set ims_qty = $act_ims_qty where tid = $updatable_id";
                                                                mysqli_query($link,$update_query) or exit(message_sql($b_shift));
                                                                if($act_ims_qty == 0 && $pre_pro_ims_qty == 0)
                                                                {
                                                                    $ims_delete="delete from $bai_pro3.ims_log where tid=$updatable_id";
                                                                    mysqli_query($link,$ims_delete) or exit(message_sql($b_shift));
                                                                }
                                                            }
                                                        }
                                                        else if($b_op_id == $output_ops_code)
                                                        {
                                                            $ops_seq_check = "select id,ops_sequence from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$mapped_color' and operation_code='$b_op_id'";
                                                            // echo $ops_seq_check;
                                                            $result_ops_seq_check = $link->query($ops_seq_check);
                                                            while($row = $result_ops_seq_check->fetch_assoc()) 
                                                            {
                                                                $ops_seq = $row['ops_sequence'];
                                                                $seq_id = $row['id'];
                                                            }

                                                            
                                                            $input_ops_code =$operation_code;
                                                            // $application = 'IPS';
                                                            // $sewing_id_query = "select operation_code from $brandix_bts.tbl_ims_ops where appilication = '$application'";
                                                            // $sewing_id_query_result = mysqli_query($link,$sewing_id_query);
                                                            // if(mysqli_num_rows($sewing_id_query_result)>0)
                                                            // {
                                                            //     while($sewing_ops_id = $sewing_id_query_result->fetch_assoc()) 
                                                            //     {
                                                            //         $input_ops_code = $sewing_ops_id['operation_code'];
                                                            //     }
                                                            // }
                                                            // else
                                                            // {
                                                            //     $input_ops_code =100;
                                                            // }
                                                        
                                                        
                                                            //echo "PAC TID = $b_tid + $value";
                                                            if($b_op_id == $input_ops_code)
                                                            {
                                                                $searching_query_in_imslog = "SELECT * FROM $bai_pro3.ims_log WHERE pac_tid = '$b_tid' AND ims_mod_no='$b_module[$key]' AND ims_style='$b_style' AND ims_schedule='$b_schedule' AND ims_color='$b_colors' AND input_job_rand_no_ref='$b_job_no' AND operation_id='$input_ops_code' AND ims_remarks = '$remarks'";
                                                                $result_searching_query_in_imslog = $link->query($searching_query_in_imslog);
                                                                //echo $searching_query_in_imslog;
                                                                if($result_searching_query_in_imslog->num_rows > 0)
                                                                {
                                                                    while($row = $result_searching_query_in_imslog->fetch_assoc()) 
                                                                    {
                                                                        $updatable_id = $row['tid'];
                                                                        $pre_ims_qty = $row['ims_pro_qty'];
                                                                        //$act_ims_input_qty = $row['ims_qty'];
                                                                    }
                                                                    $actual_ims_pro_qty = $pre_ims_qty - $reversalval[$key];
                                                                    //updating ims_pro_qty in ims log table
                                                                    $update_ims_pro_qty = "update $bai_pro3.ims_log set ims_pro_qty = $actual_ims_pro_qty where tid=$updatable_id";
                                                                    $ims_pro_qty_updating = mysqli_query($link,$update_ims_pro_qty) or exit(message_sql());
                                                                    
                                                                }
                                                                else
                                                                {
                                                                    //if it was not there in ims log am checking that in ims log backup and updating the qty and reverting that into the ims log because ims_qty and ims_pro_qty not equal
                                                                    $searching_query_in_imslog = "SELECT * FROM $bai_pro3.ims_log_backup WHERE pac_tid = '$b_tid' AND ims_mod_no='$b_module[$key]'  AND ims_style='$b_style' AND ims_schedule='$b_schedule' AND ims_color='$b_colors' AND input_job_rand_no_ref='$b_job_no' AND operation_id='$input_ops_code' AND ims_remarks = '$remarks'";
                                                                    $result_searching_query_in_imslog = $link->query($searching_query_in_imslog);
                                                                    // echo '<br/>'.$searching_query_in_imslog;
                                                                    if($result_searching_query_in_imslog->num_rows > 0)
                                                                    {
                                                                        while($row = $result_searching_query_in_imslog->fetch_assoc()) 
                                                                        {
                                                                            $updatable_id = $row['tid'];
                                                                            $pre_ims_qty = $row['ims_pro_qty'];
                                                                            $act_ims_input_qty = $row['ims_qty'];
                                                                        }
                                                                        $act_ims_qty = $pre_ims_qty - $reversalval[$key];
                                                                        //updating the ims_qty when it was there in 
                                                                        if($reversalval[$key] > 0)
                                                                        {
                                                                            $update_query = "update $bai_pro3.ims_log_backup set ims_pro_qty = $act_ims_qty where tid = $updatable_id";
                                                                            $ims_pro_qty_updating = mysqli_query($link,$update_query) or exit(message_sql());
                                                                            if($ims_pro_qty_updating)
                                                                            {
                                                                                $update_status_query = "update $bai_pro3.ims_log_backup set ims_status = '' where tid = $updatable_id";
                                                                                mysqli_query($link,$update_status_query) or exit(message_sql());
                                                                                $ims_backup="insert ignore into $bai_pro3.ims_log select * from bai_pro3.ims_log_backup where tid=$updatable_id";
                                                                                mysqli_query($link,$ims_backup) or exit(message_sql());
                                                                                $ims_delete="delete from $bai_pro3.ims_log_backup where tid=$updatable_id";
                                                                                mysqli_query($link,$ims_delete) or exit(message_sql());
                                                                            }
                                                                        }						
                                                                    }
                                                                }				
                                                            }
                                                            //exit('force quitting 1  ');
                                                        }
                                                        //exit('force quitting');
                                                        //inserting into bai_log and bai_log buff
                                                        $sizevalue="size_".$size_id;

                                                        $sections_qry="SELECT section AS sec_id FROM `bai_pro3`.`module_master` WHERE module_name = '$b_module[$key]'";
                                                        $sections_qry_result=mysqli_query($link,$sections_qry) or exit("Bundles Query Error15".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                        while($buyer_qry_row=mysqli_fetch_array($sections_qry_result))
                                                        {
                                                            $sec_head=$buyer_qry_row['sec_id'];
                                                        }
                                                        $ims_log_date=date("Y-m-d");
                                                        $bac_dat=$ims_log_date;
                                                        $log_time=date("Y-m-d H:i:s");
                                                        $buyer_qry="select order_div FROM $bai_pro3.bai_orders_db WHERE order_style_no='".$b_style."' AND order_del_no='".$b_schedule."' AND order_col_des='".$b_colors."'";
                                                        $buyer_qry_result=mysqli_query($link,$buyer_qry) or exit("Bundles Query Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                        while($buyer_qry_row=mysqli_fetch_array($buyer_qry_result))
                                                        {
                                                            $buyer_div=str_replace("'","",(str_replace('"',"",$buyer_qry_row['order_div'])));
                                                        }
                                                        $qry_nop="select ((present+jumper)-absent) as nop FROM $bai_pro.pro_attendance WHERE module=".$b_module[$key]." and date='".$bac_dat."' and shift='".$b_shift."'";
                                                        $qry_nop_result=mysqli_query($link,$qry_nop) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                        while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
                                                        {
                                                            $avail=$nop_qry_row['nop'];
                                                        }
                                                        if(mysqli_num_rows($qry_nop_result)>0)
                                                        {
                                                            $nop=$avail;
                                                        }
                                                        else
                                                        {
                                                            $nop=0;
                                                        }
                                                        $b_rep_qty_ins = '-'.$reversalval[$key];
                                                        $bundle_op_id=$b_tid."-".$b_op_id."-".$b_inp_job_ref;
                                                        $appilication_out = 'IMS_OUT';
                                                        $checking_output_ops_code_out = "SELECT operation_code from $brandix_bts.tbl_ims_ops where appilication='$appilication_out'";
                                                        //echo $checking_output_ops_code;
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
                                                        if($b_op_id == $output_ops_code_out)
                                                        {
                                                            $insert_bailog="insert into $bai_pro.bai_log (bac_no,bac_sec,bac_Qty,bac_lastup,bac_date,
                                                            bac_shift,bac_style,bac_stat,log_time,buyer,delivery,color,loguser,ims_doc_no,smv,".$sizevalue.",ims_table_name,ims_tid,nop,ims_pro_ref,ope_code,jobno
                                                            ) values ('".$b_module[$key]."','".$sec_head."','".$b_rep_qty_ins."',DATE_FORMAT(NOW(), '%Y-%m-%d %H'),'".$bac_dat."','".$b_shift."','".$b_style."','Active','".$log_time."','".$buyer_div."','".$b_schedule."','".$b_colors."',USER(),'".$b_doc_num."','".$sfcs_smv."','".$b_rep_qty_ins."','ims_log','".$b_op_id."','".$nop."','".$bundle_op_id."','".$b_op_id."','".$b_inp_job_ref."')";
                                                            //echo "Bai log : ".$insert_bailog."</br>";
                                                            if($reversalval[$key] > 0)
                                                            {
                                                                $qry_status=mysqli_query($link,$insert_bailog) or exit(message_sql());
                                                            }
                                                            if($qry_status)
                                                            {
                                                                //echo "Inserted into bai_log table successfully<br>";
                                                                /*Insert same data into bai_pro.bai_log_buf table*/
                                                                $insert_bailog_buf="insert into $bai_pro.bai_log_buf (bac_no,bac_sec,bac_Qty,bac_lastup,bac_date,
                                                                bac_shift,bac_style,bac_stat,log_time,buyer,delivery,color,loguser,ims_doc_no,smv,".$sizevalue.",ims_table_name,ims_tid,nop,ims_pro_ref,ope_code,jobno
                                                                ) values ('".$b_module[$key]."','".$sec_head."','".$b_rep_qty_ins."',DATE_FORMAT(NOW(), '%Y-%m-%d %H'),'".$bac_dat."','".$b_shift."','".$b_style."','Active','".$log_time."','".$buyer_div."','".$b_schedule."','".$b_colors."',USER(),'".$b_doc_num."','".$sfcs_smv."','".$b_rep_qty_ins."','ims_log','".$b_op_id."','".$nop."','".$bundle_op_id."','".$b_op_id."','".$b_inp_job_ref."')";
                                                                //echo "Bai log Buff: ".$insert_bailog."</br>";
                                                                if($reversalval[$key] > 0)
                                                                {
                                                                    $qry_status=mysqli_query($link,$insert_bailog_buf) or exit(message_sql());
                                                                }
                                                            }
                                                            
                                                        }
                                                        //CODE FOR UPDATING CPS LOG
                                                        $category=['cutting','Send PF','Receive PF'];
                                                        $checking_qry = "SELECT category FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code = $post_ops_code";
                                                        // echo $checking_qry;
                                                        $result_checking_qry = $link->query($checking_qry);
                                                        while($row_cat = $result_checking_qry->fetch_assoc()) 
                                                        {
                                                            $category_act = $row_cat['category'];
                                                        }
                                                        $emb_cut_check_flag = 0;
                                                        if(in_array($category_act,$category))
                                                        {
                                                            $emb_cut_check_flag = 1;
                                                        }
                                                        $b_no = $bundle_no[$key];
                                                        $reversal_value = $reversalval[$key];
                                                        if($emb_cut_check_flag == 1)
                                                        {
                                                            $doc_query = "Select docket_number,size_title from $brandix_bts.bundle_creation_data where bundle_number='$b_no' and operation_id='$operation_id' limit 1";
                                                            $doc_result = mysqli_query($link,$doc_query) or exit("Error in getting the docket for the bundle");
                                                            while($row  = mysqli_fetch_array($doc_result))
                                                            {
                                                                $docket_n =  $row['docket_number']; 
                                                                $up_size = $row['size_title'];
                                                            }
                                                            // if((int)$docket_n > 0)
                                                            // {
                                                                //getting dependency and update cps remaining qty
                                                                $parellel_ops=array();
                                                                $qry_parellel_ops="select operation_code from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$mapped_color' and ops_dependency='$ops_dep'";
                                                                $qry_parellel_ops_result=mysqli_query($link,$qry_parellel_ops);
                                                                if($qry_parellel_ops_result->num_rows > 0){
                                                                    while ($row_prellel = mysqli_fetch_array($qry_parellel_ops_result))
                                                                    { 
                                                                        $parellel_ops[] = $row_prellel['operation_code'];
                                                                    }
                                                                }
                                                                if(sizeof($parellel_ops)>0){
                                                                    $update_query = "Update $bai_pro3.cps_log set remaining_qty = remaining_qty + $reversal_value 
                                                                    where doc_no = '$docket_n' and size_title = '$up_size' and operation_code in (".implode(',',$parellel_ops).")";
                                                                }else{
                                                                    $update_query = "Update $bai_pro3.cps_log set remaining_qty = remaining_qty + $reversal_value 
                                                                    where doc_no = '$docket_n' and size_title = '$up_size' and operation_code = '$post_ops_code'";
                                                                }
                                                                
                                                                // echo $update_query;
                                                                mysqli_query($link,$update_query) or exit(message_sql());
                                                            //}	
                                                        }
                                                        $updating = updateM3TransactionsReversal($bundle_no[$key],$reversalval[$key],$operation_id);
                                                    }
                                                    
                                                    // Check for sewing job existance in plan_dashboard_input
                                                    $checking_qry_plan_dashboard = "SELECT * FROM $bai_pro3.`plan_dashboard_input` WHERE input_job_no_random_ref = '$input_job_no_random'";
                                                    $result_checking_qry_plan_dashboard = $link->query($checking_qry_plan_dashboard);
                                                    if(mysqli_num_rows($result_checking_qry_plan_dashboard) == 0)
                                                    {
                                                        // insert into plan_dashboard_input if sewing job not exists
                                                        $insert_qry_ips = "INSERT IGNORE INTO $bai_pro3.`plan_dashboard_input` SELECT * FROM $bai_pro3.`plan_dashboard_input_backup` WHERE input_job_no_random_ref = '$input_job_no_random'";
                                                        mysqli_query($link, $insert_qry_ips) or exit(message_sql());
                                                    }

                                                    //$url = '?r='.$_GET['r']."&shift=$b_shift";
                                                    //echo "<script>window.location = '".$url."'</script>";
                                                    $result_array['status'] = 'Reversal Qunatity updated Successfully !!!';
                                                    $result_array['color_code'] = "#45b645";
                                                    //echo json_encode($result_array);
                                                }
                                                    mysqli_commit($link);
                                            }
                                            catch(Exception $e)
                                            {
                                                mysqli_rollback($link);
                                            }
                                        //if end for proc qty validation
                                        }else{
                                            $result_array['status'] = 'No quantity for reversal...Please Check And Try Again !!!';
                                            $result_array['color_code'] = "#f31c06";
                                            echo json_encode($result_array);
                                            die();
                                        }
                                            


                                    //function end            
                                    }

                                    $data_rev = "$op_code,$barcode_val,$remarks,$assigned_module";
                                    if($data_rev != '')
                                        {   
                                            reversalupdate($data_rev);
                                        }
                                
                                }else{
                                    $result_array['status'] = 'Bundle Not scanned..Please Check And Try Again !!!';
                                    $result_array['color_code'] = "#f31c06";
                                    echo json_encode($result_array);
                                    die();
                                }
                    }
                    //this is for rejection reversal
                    if($trans_mode=='scrap'){
                        include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
                        include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/m3Updations.php");
                        $barcode_val = $_POST['barcode_value'];
                        $selected_module=$_POST['module'];
                        $op_code=$_POST['op_code'];
                        $shift=$_POST['shift'];
                        if($barcode_val!=''){
                            $sql="SELECT rej.`parent_id`,rej.`bcd_id`,qms.qms_tid AS qms_tid,qms.`bundle_no` AS bundle_no,qms.`qms_qty` AS qms_qty,rej.`recut_qty`,
                            ref1,location_id,SUBSTRING_INDEX(qms.remarks,'-',-1) AS form,qms_style,qms_schedule,qms_color,qms_size,qms_remarks,qms.operation_id,qms.input_job_no,qms.log_date,log_time 
                            FROM bai_pro3.bai_qms_db qms 
                            LEFT JOIN brandix_bts.`bundle_creation_data` bts ON bts.`bundle_number` = qms.`bundle_no` AND bts.`operation_id` = qms.`operation_id` 
                            LEFT JOIN bai_pro3.`rejection_log_child` rej ON rej.`bcd_id` = bts.`id` WHERE qms_tran_type=3 AND bundle_number='$barcode_val' 
                            AND recut_qty = 0 AND replaced_qty = 0";
                            $result=mysqli_query($link, $sql) or die("Sql error".$sql.mysqli_errno($GLOBALS["___mysqli_ston"]));
                            if(mysqli_num_rows($result)>0)
                            {
                                while($row=mysqli_fetch_array($result))
                                    {
                                        $tid_ref=$row["qms_tid"];
                                        $locationid=$row["location_id"];
                                        $qms_qty=$row["qms_qty"];
                                        $bcd_id = $row['bcd_id'];
                                        $parent_id = $row['parent_id']; 
                                        $form = $row['form'];

                                        if($row['form']=="G")
                                        {
                                            $form="Garment";
                                        }else
                                        {
                                            $form="Panel";
                                        }   
                                            $sql1="select bundle_no,qms_style,qms_color,input_job_no,operation_id,qms_size,SUBSTRING_INDEX(remarks,'-',1) as module,SUBSTRING_INDEX(remarks,'-',-1) AS form,ref1,doc_no,qms_schedule from $bai_pro3.bai_qms_db where qms_tid='".$tid_ref."' ";
                                            $result1=mysqli_query($link, $sql1) or die("Sql error".$sql1.mysqli_errno($GLOBALS["___mysqli_ston"]));
                                            while($sql_row=mysqli_fetch_array($result1))
                                            {
                                                $input_job_no=$sql_row["input_job_no"];
                                                $operation_id=$sql_row["operation_id"];
                                                $qms_size=$sql_row["qms_size"];
                                                $module_ref=$sql_row["module"];
                                                $rejections_ref=$sql_row["ref1"];
                                                $style=$sql_row["qms_style"];
                                                $color=$sql_row["qms_color"];
                                                $bundle_no_ref=$sql_row["bundle_no"];
                                                $doc_no = $sql_row['doc_no'];
                                                $schedule = $sql_row['qms_schedule'];
                                                $form = $sql_row['form'];
                                            }
                                            
                                            $emb_cut_check_flag = 0;
                                            $ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code=$operation_id";
                                            // echo $ops_seq_check;
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
                                            $pre_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) < '$ops_order' and operation_code NOT IN  (10,200) ORDER BY operation_order DESC LIMIT 1";
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
                                            }

                                            if($emb_cut_check_flag == 1)
                                            {
                                                $cps_update = "update $bai_pro3.cps_log set remaining_qty=remaining_qty+$qms_qty where doc_no = $doc_no and operation_code = $pre_ops_code and size_code = '$qms_size'";
                                                mysqli_query($link, $cps_update) or die("Sql error".$cps_update.mysqli_errno($GLOBALS["___mysqli_ston"]));
                                            }
                                            
                                            $reason = array();	$r_reasons = array();	$reason_qty = array();
                                            $rejections_ref_explode=explode("$",$rejections_ref);
                                            for ($i=0; $i < sizeof($rejections_ref_explode); $i++)
                                            { 
                                                $rejections_ref_explode_ref=explode("-",$rejections_ref_explode[$i]);
                                                $reason[] = $rejections_ref_explode_ref[0];
                                                $reason_qty[] = $rejections_ref_explode_ref[1];
                                            }
                                            
                                        
                                            for ($z=0; $z < sizeof($reason); $z++)
                                            { 
                                                $rej_code="select m3_reason_code from $bai_pro3.bai_qms_rejection_reason where form_type='".$form."' and reason_code='".$reason[$z]."'";
                                                $rej_code_sql_result=mysqli_query($link,$rej_code) or exit("m3_reason_code Error".$ops_dependency.mysqli_error($GLOBALS["___mysqli_ston"]));
                                                while($rej_code_row = mysqli_fetch_array($rej_code_sql_result))
                                                {
                                                    $r_reasons[]=$rej_code_row["m3_reason_code"];
                                                }
                                            }
                                            // die();
                                            $bts_update="update $brandix_bts.bundle_creation_data set rejected_qty=rejected_qty-".$qms_qty." where bundle_number='".$bundle_no_ref."' and input_job_no_random_ref='".$input_job_no."' and operation_id='".$operation_id."' and assigned_module='".$module_ref."' and size_id='".$qms_size."'";
                                            //echo $bts_update."<br>";
                                            mysqli_query($link, $bts_update) or die("Sql error".$bts_update.mysqli_errno($GLOBALS["___mysqli_ston"]));
                                            //echo $bts_update.'</br>';
                                            $bts_insert="insert into $brandix_bts.bundle_creation_data_temp(cut_number,style,SCHEDULE,color,size_id,size_title,sfcs_smv,bundle_number,rejected_qty,docket_number,assigned_module,remarks,shift,input_job_no,input_job_no_random_ref,operation_id) select cut_number,style,SCHEDULE,color,size_id,size_title,sfcs_smv,bundle_number,'".(-1*$qms_qty)."',docket_number,assigned_module,remarks,shift,input_job_no,input_job_no_random_ref,operation_id from $brandix_bts.bundle_creation_data_temp where bundle_number='".$bundle_no_ref."' and input_job_no_random_ref='".$input_job_no."' and operation_id='".$operation_id."' and assigned_module='".$module_ref."' and size_id='".$qms_size."' limit 1";
                                            //echo $bts_insert;
                                            mysqli_query($link,$bts_insert) or die("Sql error".$sql1.mysqli_errno($GLOBALS["___mysqli_ston"]));
                                            
                                            $updated = updateM3TransactionsRejectionsReversal($bundle_no_ref,$operation_id,$reason_qty,$r_reasons);
                                        
                                            //Insert selected row into table deleted table
                                            $sql1="insert ignore into $bai_pro3.bai_qms_db_deleted select * from bai_pro3.bai_qms_db where qms_tid='".$tid_ref."' ";
                                            // echo $sql1."<br>";
                                            $result1=mysqli_query($link, $sql1) or die("Sql error".$sql1.mysqli_errno($GLOBALS["___mysqli_ston"]));
                                            //reduce qty from location table based on location
                                            if($locationid != null) {
                                                $sql3="update $bai_pro3.bai_qms_location_db set qms_cur_qty=(qms_cur_qty-$qms_qty) where qms_location_id='".$locationid."'";
                                                // echo $sql3."<br>";
                                                $result3=mysqli_query($link, $sql3) or die("Sql error".$sql3.mysqli_errno($GLOBALS["___mysqli_ston"]));
                                            }
                                            //delete selected row from bai_qms_db table
                                            $sql2="delete from $bai_pro3.bai_qms_db where qms_tid='".$tid_ref."'";
                                            // echo $sql2."<br>";
                                            $result2=mysqli_query($link, $sql2) or die("Sql error".$sql2.mysqli_errno($GLOBALS["___mysqli_ston"]));
                                            
                                            //updating rejection_log_chile
                                        
                                            $update_qry = "update $bai_pro3.rejection_log_child set rejected_qty = rejected_qty-$qms_qty where bcd_id = $bcd_id";
                                            // echo $update_qry.'</br>';
                                            mysqli_query($link, $update_qry) or die("update_qry".$sql2.mysqli_errno($GLOBALS["___mysqli_ston"]));
                                        
                                            $search_qry="SELECT id FROM $bai_pro3.rejections_log where style='$style' and schedule='$schedule' and color='$color'";
                                                            // echo $search_qry;
                                            $result_search_qry = mysqli_query($link,$search_qry) or exit("rejections_log search query".mysqli_error($GLOBALS["___mysqli_ston"]));
                                            if($result_search_qry->num_rows > 0)
                                            {
                                                while($row_result_search_qry=mysqli_fetch_array($result_search_qry))
                                                {
                                        
                                                    $rejection_log_id = $row_result_search_qry['id'];
                                                    $update_qry_rej_lg = "update $bai_pro3.rejections_log set rejected_qty = rejected_qty-$qms_qty,remaining_qty=remaining_qty-$qms_qty where id = $rejection_log_id";
                                                    // echo $update_qry_rej_lg;
                                                    $update_qry_rej_lg = $link->query($update_qry_rej_lg);
                                                    $parent_id = $rejection_log_id;
                                        
                                                }
                                        
                                            }
                                            
                                    }
                                    $result_array['status'] = 'Rejected qunatities deleted for this bundle..!';
                                    $result_array['color_code'] = "#45b645";
                                    // echo json_encode($result_array);
                                    // die();
                            }else{
                                $result_array['status'] = 'No rejected qty for this bundle..!';
                                $result_array['color_code'] = "#f31c06";
                                echo json_encode($result_array);
                                die();
                            }

                        }
                        

                    }

                    //No reversal for rework
                    if($trans_mode=='rework'){
                        $result_array['color_code'] = "#f31c06";
                        $result_array['status'] = "No Reversal for Rework !!!";
                        //echo json_encode($result_array);
                    }

                }

            }

        }else{
            $result_array['color_code'] = "#f31c06";
            $result_array['status'] = "Please verify Barcode and selected operation Once !!!";
            //echo json_encode($result_array);
        }
        //getting previous and current hr count
        date_default_timezone_set('Asia/Kolkata');
        $time=date('H:i:s');
        $time1 = explode(":", $time);
        $time2=$time1[0];
        $current_hr1 = $time2.":00:00";
        $current_hr2 =  $time2.":59:59";
        $date=date('Y-m-d');
        $current_time1 = $date." ".$current_hr1;
        $current_time2= $date." ".$current_hr2;
        //======previuos_time
        $prev_hr0=$time2-1;
        $prev_hr1=$prev_hr0.":00:00";
        $prev_hr2=$prev_hr0.":59:59";
        $previuos_time1=$date." ".$prev_hr1;
        $previuos_time2=$date." ".$prev_hr2;
 

        $qry_curr_sum = "SELECT COALESCE(SUM(recevied_qty), 0 ) AS positive,COALESCE(SUM(rejected_qty) , 0 ) AS negative FROM `$brandix_bts`.bundle_creation_data_temp where date_time BETWEEN ('$current_time1') and ('$current_time2') and operation_id=".$operation."";
        //echo "Curre Good".$qry_curr_sum."</br>";
        $resultqry_curr_sum = mysqli_query($link, $qry_curr_sum) or exit("Sql Error : sql".mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($resultqry_curr_sum)>0)
        {
            while($row_curr_sum = mysqli_fetch_array($resultqry_curr_sum))
            {
                $result_array['current_good'] = $row_curr_sum['positive'];
                $result_array['current_reject'] = $row_curr_sum['negative'];   
            }
        }
        
        $qry_curr_rework = "SELECT COALESCE(sum(bac_qty), 0)  AS bac_qty FROM $bai_pro.bai_quality_log WHERE bac_lastup BETWEEN ('$current_time1') AND ('$current_time2')";
        //echo "Curre rework".$qry_curr_rework."</br>";
        $result_qry_curr_rework = mysqli_query($link, $qry_curr_rework) or exit("Sql Error : sql".mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($result_qry_curr_rework)>0)
        {
            while($row_curr_rework = mysqli_fetch_array($result_qry_curr_rework))
            {
                $result_array['curr_rework'] = $row_curr_rework['bac_qty'];
            }  
        }

        $qry_prev_sum = "SELECT COALESCE(SUM(recevied_qty), 0 ) AS positive,COALESCE(SUM(rejected_qty) , 0 ) AS negative FROM `$brandix_bts`.bundle_creation_data_temp where date_time BETWEEN ('$previuos_time1') and ('$previuos_time2') and operation_id=".$operation."";
        //echo "Prev good".$qry_prev_sum."</br>";
        $result_qry_prev_sum = mysqli_query($link, $qry_prev_sum) or exit("Sql Error : sql".mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($result_qry_prev_sum)>0)
        {
            while($row_prev_sum = mysqli_fetch_array($result_qry_prev_sum))
            {
                $result_array['prev_good'] = $row_prev_sum['positive'];
                $result_array['prev_reject'] = $row_prev_sum['negative'];

            }
        }

        
        $qry_prev_rework = "SELECT COALESCE(sum(bac_qty), 0)  AS bac_qty FROM $bai_pro.bai_quality_log WHERE bac_lastup BETWEEN ('$previuos_time1') AND ('$previuos_time2')";
        //echo "Prev Rework".$qry_prev_rework."</br>";                        
        $result_qry_prev_rework = mysqli_query($link, $qry_prev_rework) or exit("Sql Error : sql".mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($result_qry_prev_rework)>0)
        {
            while($row_prev_rework = mysqli_fetch_array($result_qry_prev_rework))
            {
                $result_array['prev_rework'] = $row_prev_rework['bac_qty'];
            }  
        }
        echo json_encode($result_array);
        //echo "Cur good : ".$current_good." Cur reje : ".$current_reject." Cure rew : ".$curr_rework."prev good : ".$prev_good." Prev Reje : ".$prev_reject." Prev Rework :".$prev_rework."</br>";
        

    // }else{
    //         $json['color_code'] = "#f31c06";
    //         $json['status'] = "You cant proceed !!!";
    //         echo json_encode($json);
    //         die(); 
    // }
}

?>