<?php
error_reporting(0);
// include("../../../../common/config/config_ajax.php");
include("../../../../../common/config/config_ajax.php");
include("../../../../../common/config/m3Updations.php");
$post_data = $_POST['bulk_data'];
//var_dump($post_data);
parse_str($post_data,$new_data);
$b_style= $new_data['style'];
//var_dump($b_style);
$b_schedule=$new_data['schedule'];
$b_colors=$new_data['colors'];
$colors=$new_data['colors'][0];

$b_sizes = $new_data['sizes'];
$b_size_code = $new_data['old_size'];
$b_doc_no = $new_data['docket_number'];
$b_module = $new_data['module'];
$b_shift = $new_data['shift'];
$b_tid = $new_data['tid'];
$b_op_id = $new_data['operation_id'];
$b_op_name = $new_data['operation_name'];
$b_in_job_qty=$new_data['job_qty'];
$b_rej_qty=$new_data['rejection_qty'];
$b_rep_qty=$new_data['reporting_qty'];
$rep_sum_qty = array_sum($b_rep_qty);
$rej_sum_qty = array_sum($b_rej_qty);
$r_reason=$new_data['reason_data'];
$r_qtys=$new_data['qty_data'];
$r_no_reasons = $new_data['tot_reasons'];
$b_a_cut_no = $new_data['a_cut_no'];
$b_old_rep_qty = $new_data['old_rep_qty'];
$b_old_rej_qty = $new_data['old_rej_qty'];
$post_ops_code='';
$page_flag = $new_data['page_flag'];
$child_doc = $new_data['child_docket'];
$form = 'P';
$ops_dep='';
$qry_status='';
if($b_op_id >=130 && $b_op_id < 300)
{
	$form = 'G';
}
$type = $form;

//Total reproted quantity for the docket
$tot_report_qty_doc = $rep_sum_qty+$rej_sum_qty;
if($b_module == '')
{
    $b_module = 0;
}




/*looping bundle number in BCD 
    1) to update shift and module number and good qty,rejected qty and reasons in BCD
    2) to update remaing quantity in CPS log
*/
//To check clubbing dockets
$flag = '';
$get_child_docs = "select doc_no from $bai_pro3.plandoc_stat_log where org_doc_no = $b_doc_no";
$result_get_child_docs_check = $link->query($get_child_docs);
if($result_get_child_docs_check->num_rows > 0)
{
     while($row_club = $result_get_child_docs_check->fetch_assoc()) 
    {
        $doc[] = $row_club['doc_no'];
    }
    $flag = 'clubbing';
   // $schedule_count = true;

}
else
{
    //Start:-- Size/Bundle level logic for Cut*/
    $schedule_count_query = "SELECT cut_number FROM $brandix_bts.bundle_creation_data WHERE cut_number = $b_doc_no AND operation_id ='$b_op_id'";
    $schedule_count_query = $link->query($schedule_count_query) or exit('No data in bundle creation data for the opeartion');
        
    if($schedule_count_query->num_rows > 0)
    {
        $schedule_count = true;
    }else{
        $schedule_count = false;
    }

}

$mapped_color_query = "SELECT mapped_color FROM $brandix_bts.bundle_creation_data WHERE cut_number = $b_doc_no AND operation_id ='$b_op_id' group by cut_number";
//echo $mapped_color_query;
$mapped_color_result = $link->query($mapped_color_query) or exit('No data in bundle creation data for the Cut Job');
if($mapped_color_result->num_rows > 0)
{
    while($row0 = $mapped_color_result->fetch_assoc()) 
    {
        $mapped_color = $row0['mapped_color'];
    }
}    
else
{
   $mapped_color = $colors;
}
/* START:--operation dependency and previous operation validation code*/
$remarks_var = $b_module.'-'.$b_shift.'-'.$type;
$reason_flag = false;
$dep_ops_array_qry = "select operation_code,ops_sequence, default_operration,smv from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' and operation_code='$b_op_id'";
//echo $dep_ops_array_qry;
$result_dep_ops_array_qry = $link->query($dep_ops_array_qry);
while($row1 = $result_dep_ops_array_qry->fetch_assoc()) 
{
    $sequnce = $row1['ops_sequence'];
    $is_m3 = $row1['default_operration'];
    $sfcs_smv = $row1['smv'];
}

$ops_dep_qry = "SELECT ops_dependency,operation_code,ops_sequence FROM $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' and ops_sequence='$sequnce' AND ops_dependency != 200 AND ops_dependency != 0 group by ops_dependency";
//echo $ops_dep_qry;
$result_ops_dep_qry = $link->query($ops_dep_qry);
while($row2 = $result_ops_dep_qry->fetch_assoc()) 
{
    $ops_dep = $row2['ops_dependency'];
}
$dep_ops_array_qry_raw = "select operation_code from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' and ops_dependency='$ops_dep'";
//echo $dep_ops_array_qry_raw;
$result_dep_ops_array_qry_raw = $link->query($dep_ops_array_qry_raw);
while($row3 = $result_dep_ops_array_qry_raw->fetch_assoc()) 
{
    $dep_ops_codes[] = $row3['operation_code'];	
}
$ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$mapped_color' and operation_code='$b_op_id'";
$result_ops_seq_check = $link->query($ops_seq_check);
while($row4 = $result_ops_seq_check->fetch_assoc()) 
{
    $ops_seq = $row4['ops_sequence'];
    $seq_id = $row4['id'];
    $ops_order = $row4['operation_order'];
}

if($ops_dep)
{
    $dep_ops_array_qry_seq = "select ops_dependency,operation_code,ops_sequence from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' AND ops_dependency != 200 AND ops_dependency != 0";
    $result_dep_ops_array_qry_seq = $link->query($dep_ops_array_qry_seq);
    while($row5 = $result_dep_ops_array_qry_seq->fetch_assoc()) 
    {
        $ops_dep_ary[] = $row5['ops_dependency'];
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
    while($row6 = $result_ops_seq_qrs->fetch_assoc()) 
    {
        $ops_seq_dep[] = $row6['ops_sequence'];
    }
}
else
{
    $ops_seq_dep[] = $ops_seq;
}
$pre_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$mapped_color' and ops_sequence = $ops_seq  AND CAST(operation_order AS CHAR) < '$ops_order' AND operation_code not in (10,200) ORDER BY operation_order DESC LIMIT 1";
//echo $pre_ops_check;
$result_pre_ops_check = $link->query($pre_ops_check);
if($result_pre_ops_check->num_rows > 0)
{
    while($row7 = $result_pre_ops_check->fetch_assoc()) 
    {
        $pre_ops_code = $row7['operation_code'];
    }
}
$post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$mapped_color' and ops_sequence = '".$ops_seq."'  AND CAST(operation_order AS CHAR) > '$ops_order' ORDER BY operation_order ASC LIMIT 1";
//echo $post_ops_check;
$result_post_ops_check = $link->query($post_ops_check);
if($result_post_ops_check->num_rows > 0)
{
    while($row8 = $result_post_ops_check->fetch_assoc()) 
    {
        $post_ops_code = $row8['operation_code'];
    }
}
$emb_cut_check_flag = 0;
$category=['cutting','Send PF','Receive PF'];
$checking_qry = "SELECT category FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code = '$post_ops_code'";
$result_checking_qry = $link->query($checking_qry);
while($row_cat = $result_checking_qry->fetch_assoc()) 
{
    $category_act = $row_cat['category'];
}
if(in_array($category_act,$category))
{
    $emb_cut_check_flag = 1;
}
/* END:--operation dependency and previous operation validation*/

 
$size_wise_good_qtys = [];
$size_wise_rej_qtys = [];
foreach($b_sizes as $key=>$size)
{
    $size_wise_good_qtys[$size] = $b_rep_qty[$key];
    $size_wise_rej_qtys[$size] = $b_rej_qty[$key];
}




$concurrent_flag = 0;

//Bulk insertions into QMS_DB
$bulk_insert_rej = "INSERT INTO $bai_pro3.bai_qms_db(`qms_style`, `qms_schedule`,`qms_color`,`log_user`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`,`remarks`, `ref1`, `doc_no`, `input_job_no`, `operation_id`, `qms_remarks`, `bundle_no`) VALUES";

if($flag == 'clubbing')
{
   $dockets = implode(',',$doc);
   $bal_qty = [];
   $rej_qty = [];
   $bundle_numbers = [];
  //Bulk insertions into Bundle creation data temp
  $bulk_insert_post_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`) VALUES";

    if($concurrent_flag == 0)
    {
      
        //To Update Rejections

        $get_bcd_qty ="select (original_qty - (recevied_qty + rejected_qty)) as balance_qty,rejected_qty,original_qty,docket_number,size_title,bundle_number,id,input_job_no_random_ref,size_id From $brandix_bts.bundle_creation_data where docket_number in ($dockets) and operation_id = '$b_op_id'";
        //echo  $get_bcd_qty;
        $result_get_bcd_qty = $link->query($get_bcd_qty);
        while($row_bcd_qry = $result_get_bcd_qty->fetch_assoc()) 
        {

            $docket_number =  $row_bcd_qry['docket_number'];
            $size =  $row_bcd_qry['size_title'];
            $original_qty = $row_bcd_qry['original_qty'];
            $bundle_no = $row_bcd_qry['bundle_number'];
            $bcd_id = $row_bcd_qry['id'];
            $input_job_random_ref = $row_bcd_qry['input_job_no_random_ref'];
            $size_id = $row_bcd_qry['size_id'];

            if($size_wise_rej_qtys[$size] > 0)
            {

                $rej_qty[$size] = $row_bcd_qry['balance_qty'];

                if($rej_qty[$size] > $size_wise_rej_qtys[$size])
                {
                // 100                  200

                $final_rejected_qty = $size_wise_rej_qtys[$size];

                $size_wise_rej_qtys[$size] = 0;
                }         
                else
                {

                $final_rejected_qty = $rej_qty[$size];


                $size_wise_rej_qtys[$size]  -= $rej_qty[$size];
                }


                //Updating BCD
                $query = "UPDATE $brandix_bts.bundle_creation_data SET  `rejected_qty`='". $final_rejected_qty."' where bundle_number ='".$bundle_no."' and operation_id = ".$b_op_id;
                //echo $query;
                $result_query = $link->query($query) or exit('query error in updating');

                $remarks_code = "";
                //var_dump($r_qtys);
                foreach ($r_qtys as $key => $value)
                {
                    if($r_qtys[$key] != null && $r_reason[$key] != null)
                    {
                      $r_qty_array = explode(',',$r_qtys[$key]);
                      $r_reasons_array = explode(',',$r_reason[$key]);
                       //var_dump($r_reasons_array);

                        if(sizeof($r_qty_array)>0)
                        {
                          $flag_decision = true;
                        }
                        foreach ($r_qty_array as $index => $r_qnty) 
                        {                      
                            $rejection_code_fetech_qry = "select reason_code from $bai_pro3.bai_qms_rejection_reason where m3_reason_code= '$r_reasons_array[$index]'";
                            //echo $rejection_code_fetech_qry;
                            $result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
                            while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
                            {
                               $reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
                            }
                            if($index == sizeof($r_qty_array)-1){
                               $remarks_code .= $reason_code.'-'.$r_qnty;
                            }else {
                               $remarks_code .= $reason_code.'-'.$r_qnty.'$';
                            }

                        }
                    }
                }
                $bcd_id_searching_qry = "select id from $bai_pro3.rejection_log_child where bcd_id = $bcd_id";
                $bcd_id_searching_qry_result=mysqli_query($link,$bcd_id_searching_qry) or exit("bcd_id_searching_qry_result".mysqli_error($GLOBALS["___mysqli_ston"]));
                if($bcd_id_searching_qry_result->num_rows > 0)
                {
                    $update_rejection_log_child_qry = "update $bai_pro3.rejection_log_child set rejected_qty=rejected_qty+$final_rejected_qty where bcd_id = $bcd_id";
                    //echo $update_rejection_log_child_qry;
                    mysqli_query($link,$update_rejection_log_child_qry) or exit("update_rejection_log_child_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $update_qry_rej_lg = "update $bai_pro3.rejections_log set rejected_qty = rejected_qty+$final_rejected_qty,remaining_qty=remaining_qty+$final_rejected_qty where style='$b_style' and schedule='$b_schedule' and color='$mapped_color'";
                    $update_qry_rej_lg = $link->query($update_qry_rej_lg);
                }
                else
                {
                    $search_qry="SELECT id FROM $bai_pro3.rejections_log where style='$b_style' and schedule='$b_schedule' and color='$mapped_color'";
                    // echo $search_qry;
                    $result_search_qry = mysqli_query($link,$search_qry) or exit("rejections_log search query".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if($result_search_qry->num_rows > 0)
                    {
                       while($row_result_search_qry=mysqli_fetch_array($result_search_qry))
                       {   

                        $rejection_log_id = $row_result_search_qry['id'];
                        $update_qry_rej_lg = "update $bai_pro3.rejections_log set rejected_qty = rejected_qty+$final_rejected_qty,remaining_qty=remaining_qty+$final_rejected_qty where id = $rejection_log_id";
                        // echo $update_qry_rej_lg;
                        $update_qry_rej_lg = $link->query($update_qry_rej_lg);
                        $parent_id = $rejection_log_id;

                       }

                    }
                    else
                    {
                        $insert_qty_rej_log = "INSERT INTO $bai_pro3.rejections_log (style,schedule,color,rejected_qty,recut_qty,remaining_qty) VALUES ('$b_style','$b_schedule','$mapped_color',$final_rejected_qty,'0',$final_rejected_qty)";
                        $res_insert_qty_rej_log = $link->query($insert_qty_rej_log);
                        $parent_id=mysqli_insert_id($link);

                    }
                    $inserting_into_rejection_log_child_qry = "INSERT INTO `bai_pro3`.`rejection_log_child` (`parent_id`,`bcd_id`,`doc_no`,`input_job_no_random_ref`,`size_id`,`size_title`,`assigned_module`,`rejected_qty`,`operation_id`) values($parent_id,$bcd_id,$docket_number,$input_job_random_ref,'$size_id','$size','$b_module',$final_rejected_qty,$b_op_id)";
                    // echo  $inserting_into_rejection_log_child_qry;
                    $insert_qry_rej_child = $link->query($inserting_into_rejection_log_child_qry);
                }
                
                    $bulk_insert_rej .= '("'.$b_style.'","'.$b_schedule.'","'.$mapped_color.'",user(),"'.date('Y-m-d').'","'.$size.'","'.$final_rejected_qty.'","3","'.$remarks_var.'","'.$remarks_code.'","'.$docket_number.'","'.$docket_number.'","'. $b_op_id.'","Normal","'.$bundle_no.'"),';
                    $reason_flag = true;
            }

            $bal_qty[$size] = 0;
            $rej_qty[$size] = 0;
            //$final_reported_qty = 0;
            $final_rejected_qty = 0;
            $left_over_qty = 0;
        }

        //Good Qty Logic
        $get_bcd_qty ="select (original_qty - (recevied_qty + rejected_qty)) as balance_qty,rejected_qty,original_qty,send_qty,docket_number,size_title,bundle_number,size_id,cut_number From $brandix_bts.bundle_creation_data where docket_number in ($dockets) and operation_id = '$b_op_id'";
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
                $bal_qty[$size] = $row_bcd_qry['balance_qty'];
                $rej_qty[$size] = $row_bcd_qry['rejected_qty'];

                if($bal_qty[$size] > $size_wise_good_qtys[$size])
                {
                // 100                  200

                    $final_reported_qty = $size_wise_good_qtys[$size];
                    $final_rejected_qty = $size_wise_rej_qtys[$size];

                    $left_over_qty = $original_qty - $final_reported_qty - $final_rejected_qty;

                    $size_wise_good_qtys[$size] = 0;
                    $size_wise_rej_qtys[$size] = 0;
                }         
                else
                {

                    $final_reported_qty = $bal_qty[$size];
                    $final_rejected_qty = $rej_qty[$size];

                    $left_over_qty = $original_qty - $final_reported_qty - $final_rejected_qty;

                    $size_wise_good_qtys[$size] -= $bal_qty[$size];
                    $size_wise_rej_qtys[$size]  -= $rej_qty[$size];
                }

                //For prev operation updating remaining quantity in cps log
                $cps_log_qry_pre = "UPDATE $bai_pro3.cps_log SET `remaining_qty`= remaining_qty-'$final_reported_qty' WHERE doc_no = '$docket_number' AND operation_code = '$pre_ops_code' AND size_title='$size'"; 
                //echo $cps_log_qry_pre;
                $cps_log_result_pre = $link->query($cps_log_qry_pre) or exit('CPS LOG query pre error');

                //Updating BCD
                $query = "UPDATE $brandix_bts.bundle_creation_data SET `recevied_qty`= recevied_qty+$final_reported_qty, `left_over`= '".$left_over_qty."' , `scanned_date`='". date('Y-m-d')."',`shift`= '".$b_shift."',`assigned_module`= '".$b_module."' where docket_number ='".$docket_number."' and size_title='$size' and operation_id = ".$b_op_id;
                //echo $query;
                $result_query = $link->query($query) or exit('query error in updating');

                //based on the bundle creation data current operation quantites we are changing reported status
                $get_cumi_qtys = "SELECT (sum(send_qty)-sum(recevied_qty+rejected_qty)) as bal_report  FROM $brandix_bts.bundle_creation_data WHERE docket_number ='".$docket_number."' AND size_title='$size' AND operation_id = '$b_op_id'";
                $result_get_cumi_qtys = $link->query($get_cumi_qtys) or exit('Error getting data from Bundle creation data for cumilative');

                if($result_get_cumi_qtys->num_rows >0)
                {
                    while($row = $result_get_cumi_qtys->fetch_assoc()) 
                    {
                      $bal_report = $row['bal_report'];

                    }
                    if($bal_report == 0){
                      $reported_status = 'F';
                    }else{
                      $reported_status = 'P';
                    }
                    //update remaining quantity in cps_log table
                    $cps_log_qry = "UPDATE $bai_pro3.cps_log SET `remaining_qty`= remaining_qty+$final_reported_qty,`reported_status`='$reported_status' where doc_no = '$docket_number' and size_title='$size' and operation_code='$b_op_id'";
                    // echo $cps_log_qry;
                    $cps_log_result = $link->query($cps_log_qry) or exit('CPS LOG query error');

                }
                if($post_ops_code != null && $emb_cut_check_flag == 1)
                {
                    $query_post = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$final_reported_qty."', `scanned_date`='". date('Y-m-d')."' where docket_number ='".$docket_number."' and size_title='$size' and operation_id = ".$post_ops_code;
                    //echo $query_post;
                    $result_query = $link->query($query_post) or exit('query error in updating');
                }
                if($ops_dep)
                {
                    $pre_send_qty_qry = "select min(recevied_qty)as recieved_qty from $brandix_bts.bundle_creation_data where docket_number ='".$docket_number."' and size_title='$size' and operation_id in (".implode(',',$dep_ops_codes).")";
                    $result_pre_send_qty = $link->query($pre_send_qty_qry);
                    while($row = $result_pre_send_qty->fetch_assoc()) 
                    {
                        $pre_recieved_qty = $row['recieved_qty'];
                    }

                    $query_post_dep = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$pre_recieved_qty."', `scanned_date`='". date('Y-m-d')."' where docket_number ='".$docket_number."' and size_title='$size' and operation_id = ".$ops_dep;
                    $result_query = $link->query($query_post_dep) or exit('query error in updating');    
                }         

            }
            //M3 API Call and operation quantites updatation and M3 Transactions and log tables for good quantity
            //updateM3Transactions($b_tid[$key],$b_op_id,$b_rep_qty[$key]);
            $smv_query = "select smv from $brandix_bts.tbl_style_ops_master where style='$b_style' and color='$mapped_color' and operation_code = $b_op_id";
            //echo $smv_query;
            $result_smv_query = $link->query($smv_query);
            while($row_ops = $result_smv_query->fetch_assoc()) 
            {
               $sfcs_smv = $row_ops['smv'];
            }
            
            if($result_query)
            {
                
                $bulk_insert_post_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$mapped_color.'","'.$size_id.'","'. $size.'","'. $sfcs_smv.'","'.$bundle_no.'","'.$original_qty.'","'.$send_qty.'","'.$final_reported_qty.'","'.$final_rejected_qty.'","'.$left_over_qty.'","'. $b_op_id.'","'.$docket_number.'","'.date('Y-m-d').'","'.$cut_no.'","'.$docket_number.'","'.$docket_number.'","'.$b_shift.'","'.$b_module.'","Normal"),';   
                //echo  $bulk_insert_post_temp;            
               
                
            }

            $bal_qty[$size] = 0;
            $rej_qty[$size] = 0;
            $final_reported_qty = 0;
            $final_rejected_qty = 0;
            $left_over_qty = 0;
        }

        $result_query_001_temp = $link->query(rtrim($bulk_insert_post_temp,',') ) or exit('bulk_insert_post query error in updating11111');
    }
}
else
{
    foreach($b_tid as $key => $value)
    {

        //Bulk insertions into Bundle creation data temp
        $bulk_insert_post_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`) VALUES";
        
        //Total reproted quantity for the size
        $tot_report_qty = $b_rep_qty[$key];
        
        //for prev operation updating remaining quantity in cps log
        $cps_log_qry_pre = "UPDATE $bai_pro3.cps_log SET `remaining_qty`= remaining_qty-$tot_report_qty WHERE doc_no = '$b_doc_no' AND operation_code = '$pre_ops_code' AND size_title='". $b_sizes[$key]."'"; 
        $cps_log_result_pre = $link->query($cps_log_qry_pre) or exit('CPS LOG query pre error');

            
        //update shift and module against to each bundle number in BCD insert rejection in qms_db
        $select_send_qty = "SELECT (send_qty+recut_in+replace_in)as send_qty,recevied_qty,rejected_qty FROM $brandix_bts.bundle_creation_data WHERE bundle_number = '$b_tid[$key]' AND operation_id = '$b_op_id'";
        //echo $select_send_qty;
        $result_select_send_qty = $link->query($select_send_qty) or exit('Error getting data from Bundle creation data');
        if($result_select_send_qty->num_rows >0)
        {
            while($row = $result_select_send_qty->fetch_assoc()) 
            {
                $send_qty = $row['send_qty'];
                $pre_recieved_qty = $row['recevied_qty'];
                $rejected_qty = $row['rejected_qty'];
                $act_reciving_qty = $b_rep_qty[$key]+$b_rej_qty[$key];
                $total_rec_qty = $pre_recieved_qty + $act_reciving_qty+$rejected_qty;
                if($total_rec_qty > $send_qty)
                {
                    $concurrent_flag = 1;
                }
                else
                {
                    $rec_qty_from_temp = "select (sum(recevied_qty)+sum(rejected_qty))as recevied_qty FROM $brandix_bts.bundle_creation_data_temp WHERE bundle_number = '$b_tid[$key]' AND operation_id = '$b_op_id'";
                    $result_rec_qty_from_temp = $link->query($rec_qty_from_temp);
                    while($row_temp = $result_rec_qty_from_temp->fetch_assoc()) 
                    {
                        $pre_recieved_qty_temp = $row_temp['recevied_qty'];
                        $act_reciving_qty_temp = $b_rep_qty[$key]+$b_rej_qty[$key];
                        if($act_reciving_qty_temp > $send_qty)
                        {
                            // $concurrent_flag = 1;
                        }
                    }

                }
            }
        }
        if($concurrent_flag == 0)
        {       

            $smv_query = "select smv from $brandix_bts.tbl_style_ops_master where style='$b_style' and color='$b_colors[$key]' and operation_code = $b_op_id";
            $result_smv_query = $link->query($smv_query);
            while($row_ops = $result_smv_query->fetch_assoc()) 
            {
                $sfcs_smv = $row_ops['smv'];
            }
            $remarks_code = "";
            if($b_rep_qty[$key] == null){
                $b_rep_qty[$key] = 0;
            }
            if($b_rej_qty[$key] == null){
                $b_rej_qty[$key] = 0;
            }
            if($r_qtys[$value] != null && $r_reason[$value] != null){
                $r_qty_array = explode(',',$r_qtys[$value]);
                $r_reasons_array = explode(',',$r_reason[$value]);
                if(sizeof($r_qty_array)>0)
                {
                    $flag_decision = true;
                }
                foreach ($r_qty_array as $index => $r_qnty) {                      
                    $rejection_code_fetech_qry = "select reason_code from $bai_pro3.bai_qms_rejection_reason where m3_reason_code= '$r_reasons_array[$index]'";
                    $result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
                    while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
                    {
                        $reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
                    }
                    if($index == sizeof($r_qty_array)-1){
                        $remarks_code .= $reason_code.'-'.$r_qnty;
                    }else {
                        $remarks_code .= $reason_code.'-'.$r_qnty.'$';
                    }
                }
            }   
            $select_send_qty = "SELECT recevied_qty,rejected_qty FROM $brandix_bts.bundle_creation_data WHERE bundle_number = '$b_tid[$key]' AND operation_id = '$b_op_id'";
            $result_select_send_qty = $link->query($select_send_qty);
            if($result_select_send_qty->num_rows >0)
            {
                while($row = $result_select_send_qty->fetch_assoc()) 
                {
                    $b_old_rep_qty_new = $row['recevied_qty'];
                    $b_old_rej_qty_new = $row['rejected_qty'];

                }
            }
            $final_rep_qty = $b_old_rep_qty_new + $b_rep_qty[$key];
            $final_rej_qty = $b_old_rej_qty_new + $b_rej_qty[$key];
            $left_over_qty = $b_in_job_qty[$key] - $final_rep_qty - $final_rej_qty;
            if($schedule_count){
                $query = "UPDATE $brandix_bts.bundle_creation_data SET `recevied_qty`= '".$final_rep_qty."', `rejected_qty`='". $final_rej_qty."', `left_over`= '".$left_over_qty."' , `scanned_date`='". date('Y-m-d')."',`shift`= '".$b_shift."',`assigned_module`= '".$b_module."' where bundle_number ='".$b_tid[$key]."' and operation_id = ".$b_op_id;
                
                $result_query = $link->query($query) or exit('query error in updating');


                //based on the bundle creation data current operation quantites we are changing reported status
                $get_cumi_qtys = "SELECT (sum(send_qty)-sum(recevied_qty+rejected_qty)) as bal_report  FROM $brandix_bts.bundle_creation_data WHERE bundle_number ='".$b_tid[$key]."' AND operation_id = '$b_op_id'";
                $result_get_cumi_qtys = $link->query($get_cumi_qtys) or exit('Error getting data from Bundle creation data for cumilative');

                if($result_get_cumi_qtys->num_rows >0)
                {
                    while($row = $result_get_cumi_qtys->fetch_assoc()) 
                    {
                        $bal_report = $row['bal_report'];
        
                    }
                    if($bal_report == 0){
                        $reported_status = 'F';
                    }else{
                        $reported_status = 'P';
                    }
                    //update remaining quantity in cps_log table
                    $cps_log_qry = "UPDATE $bai_pro3.cps_log SET `remaining_qty`= remaining_qty+$tot_report_qty,`reported_status`='$reported_status' where id = '".$b_tid[$key]."' and operation_code='$b_op_id'";
                    // echo $cps_log_qry;
                    $cps_log_result = $link->query($cps_log_qry) or exit('CPS LOG query error');

                }         

                //M3 API Call and operation quantites updatation and M3 Transactions and log tables for good quantity
                updateM3Transactions($b_tid[$key],$b_op_id,$b_rep_qty[$key]);

                //To send rejections qunatities and reasons array to M3 API Function
                if($r_qtys[$value] != null && $r_reason[$value] != null){
                    $r_qty_array = explode(',',$r_qtys[$value]);
                    $r_reasons_array = explode(',',$r_reason[$value]);
                    // foreach($r_qty_array as $qty_key => $qty_value)
                    // {
                        $r_qty = array();
                        $r_reasons = array();
                        $r_qty[] = $r_qty_array;
                        $r_reasons[] = $r_reasons_array;
                        //$b_tid = $b_tid[$key];
                        $implode_next[2] = array_sum($r_qty_array);
                        //retreving bcd id from bundle_ceration_data and inserting into the rejection_log table and rejection_log_child
                        $bcd_id_qry = "select id,style,schedule,color,docket_number,size_title,size_id,assigned_module,input_job_no_random_ref,bundle_number from $brandix_bts.bundle_creation_data where bundle_number=$b_tid[$key] and operation_id = $b_op_id";
                       // echo $bcd_id_qry;
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
                            $bundle_number = $bcd_id_row['bundle_number'];
                        }
                        //searching the bcd_id in rejection log child or not
                        $bcd_id_searching_qry = "select id from $bai_pro3.rejection_log_child where bcd_id = $bcd_id";
                        $bcd_id_searching_qry_result=mysqli_query($link,$bcd_id_searching_qry) or exit("bcd_id_searching_qry_result".mysqli_error($GLOBALS["___mysqli_ston"]));
                        if($bcd_id_searching_qry_result->num_rows > 0)
                        {
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
                            $inserting_into_rejection_log_child_qry = "INSERT INTO `bai_pro3`.`rejection_log_child` (`parent_id`,`bcd_id`,`doc_no`,`input_job_no_random_ref`,`size_id`,`size_title`,`assigned_module`,`rejected_qty`,`operation_id`) values($parent_id,$bcd_id,$doc_no,$input_job_random_ref,'$size_id','$size_title','$assigned_module',$implode_next[2],$b_op_id)";
                           // echo  $inserting_into_rejection_log_child_qry;
                            $insert_qry_rej_child = $link->query($inserting_into_rejection_log_child_qry);
                        }
                        // echo $bundle_number.','.$b_op_id.','.$r_qty_array.','.$r_reasons_array.'</br>';
                        updateM3TransactionsRejections($bundle_number,$b_op_id,$r_qty_array,$r_reasons_array);
                    // }
                }            
            }
                   
            if($result_query)
            {
                if($b_rep_qty[$key] > 0 || $b_rej_qty[$key] >0)
                {
                    $bulk_insert_post_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$b_rep_qty[$key].'","'.$b_rej_qty[$key].'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_no.'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_doc_no.'","'.$b_doc_no.'","'.$b_shift.'","'.$b_module.'","Normal")';               
                    $result_query_001_temp = $link->query($bulk_insert_post_temp) or exit('bulk_insert_post query error in updating');
                }
            }   
            if($post_ops_code != null && $emb_cut_check_flag == 1)
            {
                $query_post = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$final_rep_qty."', `scanned_date`='". date('Y-m-d')."' where docket_number =$b_doc_no and size_title='". $b_sizes[$key]."' and operation_id = ".$post_ops_code;
                $result_query = $link->query($query_post) or exit('query error in updating');
            }
            if($ops_dep)
            {
                $pre_send_qty_qry = "select min(recevied_qty)as recieved_qty from $brandix_bts.bundle_creation_data where bundle_number ='".$b_tid[$key]."' and operation_id in (".implode(',',$dep_ops_codes).")";
                $result_pre_send_qty = $link->query($pre_send_qty_qry);
                while($row = $result_pre_send_qty->fetch_assoc()) 
                {
                    $pre_recieved_qty = $row['recieved_qty'];
                }

                $query_post_dep = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = '".$pre_recieved_qty."', `scanned_date`='". date('Y-m-d')."' where bundle_number ='".$b_tid[$key]."' and operation_id = ".$ops_dep;
                $result_query = $link->query($query_post_dep) or exit('query error in updating');    
            }
                   
            if($r_qtys[$value] != null && $r_reason[$value] != null){
                $bulk_insert_rej .= '("'.$b_style.'","'.$b_schedule.'","'.$b_colors[$key].'",user(),"'.date('Y-m-d').'","'.$b_sizes[$key].'","'.$b_rej_qty[$key].'","3","'.$remarks_var.'","'.$remarks_code.'","'.$b_doc_no.'","'.$b_doc_no.'","'. $b_op_id.'","Normal","'.$b_tid[$key].'"),';
                $reason_flag = true;
            }   
        }    
    }
}


if($concurrent_flag == 1)
{
    echo "<h1 style='color:red;'>You are Scanning More than eligible quantity.</h1>";
}
if($concurrent_flag == 0)
{   
    $table_data = "<div class='container'><div class='row'><div id='no-more-tables'><table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Docket Number</th><th>Color</th><th>Size</th><th>Reporting Qty</th><th>Rejecting Qty</th></tr></thead><tbody>";
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
        $rej_insert_result = $link->query($final_query) or exit('data error');

   
    }
    for($i=0;$i<sizeof($b_tid);$i++)
    {
        if($b_rep_qty[$i] > 0 || $b_rej_qty[$i] > 0)
        {
            $size = strtoupper($b_sizes[$i]);
            $table_data .= "<tr><td data-title='Bundle No'>$b_doc_no</td><td data-title='Color'>$b_colors[$i]</td><td data-title='Size'>$size</td><td data-title='Reported Qty'>$b_rep_qty[$i]</td><td data-title='Rejected Qty'>$b_rej_qty[$i]</td></tr>";
        }
    }
    $table_data .= "</tbody></table></div></div></div>";
    echo $table_data;
}



?>

