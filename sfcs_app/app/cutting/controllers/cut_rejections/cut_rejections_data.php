<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
error_reporting(0);


$response_data = array();
$op_code = 15;

foreach($sizes_array as $size){
    $a_sizes_sum .= 'a_'.$size.'+';
    $a_sizes_str .= 'a_'.$size.',';
}
$a_sizes_sum = rtrim($a_sizes_sum,'+');
$a_sizes_str = rtrim($a_sizes_str,',');

$doc_no = $_GET['doc_no'];

if($_GET['rejection_docket']!=''){
    getRejectionDetails($_GET['rejection_docket']);
    exit();
}

if($_GET['roll_status'] == 1){
    getRollsData($doc_no);
    exit();
}

$doc_status_query  = "SELECT a_plies,p_plies,act_cut_status,acutno,org_doc_no
                    from $bai_pro3.plandoc_stat_log where doc_no = $doc_no";
$doc_status_result = mysqli_query($link,$doc_status_query);
if(mysqli_num_rows($doc_status_result)>0){
    $row = mysqli_fetch_array($doc_status_result);
    $a_plies = $row['a_plies'];
    $p_plies = $row['p_plies'];
    $act_cut_status = $row['act_cut_status'];
    $org_doc_no = $row['org_doc_no'];
    $cut_no = $row['acutno'];
}else{
    $response_data['error'] = '1';
    echo json_encode($response_data);
    exit();
}
//IF this is a child docket restrict Cut Reporting
if($org_doc_no > 1 ){
    $response_data['child_docket'] = '1';
    echo json_encode($response_data);
    exit();
}

$acut_no = 'A00'.$cut_no;
//getting the target doc type 
$target_query  = "SELECT order_del_no,order_joins from $bai_pro3.bai_orders_db_confirm 
                where order_tid = '$order_tid' and order_joins IN (1,2) limit 1";               
$target_result = mysqli_query($link,$target_query);
if(mysqli_num_rows($target_result) > 0){
    $row = mysqli_fetch_array($target_result);
    $schedule = $row['order_del_no'];
    if(strlen($schedule) > 7)
        $target_doc_type = 'style_clubbed';
    else
        $target_doc_type = 'schedule_clubbed';
}else{
    $target_doc_type = 'normal';
}
if(strtolower($remarks) == 'recut'){
    $target_doc_type = 'recut'; 
    $acut_no = 'R00'.$cut_no;
}



$doc_details_query = "SELECT SUM(send_qty) as send,SUM(recevied_qty) as good,SUM(rejected_qty) as rej,
                    style,GROUP_CONCAT(distinct schedule) as schedule,
                    GROUP_CONCAT(distinct mapped_color) as mapped_color 
                    from $brandix_bts.bundle_creation_data 
                    where docket_number IN ($doc_no) and operation_id = $op_code";
$doc_details_result = mysqli_query($link,$doc_details_query);
//echo $doc_details_query;
if(mysqli_num_rows($doc_details_result)>0){
    $row = mysqli_fetch_array($doc_details_result);
    $response_data['styles']   = $row['style'];
    $response_data['schedules']= $row['schedule'];
    $response_data['colors']   = $row['mapped_color'];
    $response_data['good_pieces'] = $row['good'];
    $response_data['rej_pieces']  = $row['rej'];
}

$doc_no = $_GET['doc_no'];
if($act_cut_status == 'DONE'){
    $fab_details_query = "SELECT * from $bai_pro3.act_cut_status where doc_no=$doc_no";
    $fab_details_result = mysqli_query($link,$fab_details_query);
    if(mysqli_num_rows($fab_details_result)>0){
        $fab_row = mysqli_fetch_array($fab_details_result);
        $fab_rec = $fab_row['fab_received'];
        $fab_ret = $fab_row['fab_returned'];
        $shortages= $fab_row['shortages'];
        $damages = $fab_row['damages'];
        $shift   = $fab_row['shift'];
        $section = $fab_row['section'];
        $date = $fab_row['date'];
    }
}

//getting size wise qtys
$cps_remaining_query = "SELECT size_code,size_title,cut_quantity,remaining_qty 
                        from $bai_pro3.cps_log where doc_no = $doc_no and operation_code = $op_code";
$cps_remaining_result = mysqli_query($link,$cps_remaining_query);
while($row = mysqli_fetch_array($cps_remaining_result)){
    $size = $row['size_code'];
    $cut_qty = $row['cut_quantity'];
    $rem_qty = $row['remaining_qty'];
    $cps_rem[$size] = $rem_qty;
    $old_new_sizes[$size] = $row['size_title'];
    $avl_to_reject += $rem_qty;
    $data_str.= "<tr><td>".$row['size_title']."</td><td>$cut_qty</td><td>$rem_qty</td></tr>";
}     




if($a_plies == $p_plies && $act_cut_status == 'DONE'){
    $response_data['cut_done']  = 1;
    $response_data['avl_plies'] = 0;
    $response_data['a_plies']  = $p_plies;
}else{
    $response_data['cut_done'] = 0;
    $response_data['avl_plies']= $p_plies;
    $response_data['a_plies']  = 0;
}

if($a_plies != $p_plies && $act_cut_status == 'DONE'){
    $response_data['avl_plies'] = $p_plies - $a_plies;
    $response_data['partial'] = 1;
    $response_data['a_plies']  = $a_plies;
}

$response_data['doc_no'] = $doc_no;
$response_data['doc_qty'] = $doc_no;
$response_data['ratio']      = $ratio;
$response_data['size_ratio'] = $size_ratio;
$response_data['p_plies'] = $p_plies;
$response_data['act_cut_status'] = $act_cut_status;
$response_data['acut_no'] = $acut_no;
$response_data['fab_status']  = $fabric_status;
$response_data['fab_received'] = $fab_rec;
$response_data['fab_returned'] = $fab_ret;
$response_data['shortages'] = $shortages;
$response_data['damages']   = $damages;
$response_data['shift']     = $shift;
$response_data['section']   = $section;
$response_data['date']      = $date;
$response_data['doc_target_type']      = $target_doc_type;
$response_data['size_wise_data'] = $data_str;
$response_data['avl_to_reject'] = $avl_to_reject;

echo json_encode($response_data);


function getRejectionDetails($doc_no){
    $op_code = 15;
    global $link;
    global $bai_pro3;
    global $sizes_array;
    global $a_sizes_str;

    $sizes_ratio = array();
    $ratio_query = "SELECT $a_sizes_str,a_plies from $bai_pro3.plandoc_stat_log where doc_no = $doc_no and act_cut_status='DONE'";
    $ratio_result = mysqli_query($link,$ratio_query) or exit('Problem in getting rejections');
    while($row = mysqli_fetch_array($ratio_result)){
        foreach($sizes_array as $size){
            if($row["a_$size"] > 0)
                $old_sizes_ratio[$size] = $row["a_$size"] * $row['a_plies'];
        }
    }

    $cps_remaining_query = "SELECT size_code,size_title,cut_quantity,remaining_qty from $bai_pro3.cps_log 
                            where doc_no = $doc_no and operation_code = $op_code";
    $cps_remaining_result = mysqli_query($link,$cps_remaining_query);
    while($row = mysqli_fetch_array($cps_remaining_result)){
        $size = $row['size_code'];
        $cps_rem[$size] = $row['remaining_qty'];
        $old_new_sizes[$size] = $row['size_title'];
    }

    $response_data['old_size_ratio'] = $old_sizes_ratio;
    $response_data['old_new_size']   = $old_new_sizes;
    $response_data['remaining_qty']  = $cps_rem;
    echo json_encode($response_data);
    exit();
}


?>