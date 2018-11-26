<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
error_reporting(0);

$doc_no = $_GET['doc_no'];
$response_data = array();
$op_code = 15;

$doc_status_query  = "SELECT a_plies,p_plies,acutno,act_cut_status,order_tid from $bai_pro3.plandoc_stat_log 
                    where doc_no = '$doc_no'";
$doc_status_result = mysqli_query($link,$doc_status_query);
if(mysqli_num_rows($doc_status_result)>0){
    $row = mysqli_fetch_array($doc_status_result);
    $a_plies = $row['a_plies'];
    $p_plies = $row['p_plies'];
    $act_cut_status = $row['act_cut_status'];
    $acutno = $row['acutno'];
    $fabric_status = $row['fabric_status'];
    $order_tid = $row['order_tid'];
    if($fabric_status == 5)
        $fabric_status = 'Issued To Cutting';
}else{
    $response_data['error'] = '1';
    echo json_encode($response_data);
    exit();
}

//Validation for fabric status

$validation_query = "SELECT cat_ref,fabric_status,category from $bai_pro3.order_cat_doc_mk_mix 
                    where doc_no=$doc_no";
$validation_result = mysqli_query($link,$validation_query);
if(mysqli_num_rows($validation_result)>0){
    $row = mysqli_fetch_array($validation_result);
    $cat_ref  = $row['cat_ref'];
    $category = $row['category'];
    
    if(in_array($category,$categories_array) && $cat_ref > 0)
        $response_data['can_report']   = 1;
    else    
        $response_data['can_report']   = 2;
    
    echo json_encode($response_data);
    exit();
}else{
    $response_data['can_report']   = 0;
    
    echo json_encode($response_data);
    exit();
}

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

//if clubbed docket then getting all child dockets
$child_docs_query = "SELECT GROUP_CONCAT(doc_no) as doc_no 
                from $bai_pro3.plandoc_stat_log where org_doc_no = '$doc_no' ";
$child_docs_result = mysqli_query($link,$child_docs_query);
while($row = mysqli_fetch_array($child_docs_result)){
    $doc_no = $row['doc_no'];
}

$doc_details_query = "SELECT SUM(send_qty) as send,SUM(recevied_qty) as good,SUM(rejected_qty) as rej,
                    style,schedule,mapped_color 
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

//getting good and rejected pieces
$good_rej_query = "SELECT SUM(recevied_qty) as good,SUM(rejected_qty) as rej 
                from $brandix_bts.bundle_creation_data where docket_number='$doc_no' and operation_code = 15";


if($a_plies == $p_plies && $act_cut_status == 'DONE'){
    $response_data['cut_done'] = 1;
    $response_data['avl_plies'] = 0;
}else{
    $response_data['cut_done'] = 0;
    $response_data['avl_plies'] = $p_plies;
   
}

if($a_plies != $p_plies && $act_cut_status == 'DONE'){
    $response_data['avl_plies'] = $p_plies - $a_plies;
    $response_data['partial'] = 1;
}

$response_data['doc_no'] = $doc_no;
$response_data['doc_qty'] = $doc_no;
$response_data['a_plies'] = $a_plies;
$response_data['p_plies'] = $p_plies;
$response_data['act_cut_status'] = $act_cut_status;
$response_data['acut_no'] = $acutno;
$response_data['fab_status']  = $fabric_status;
$response_data['fab_received'] = $fab_rec;
$response_data['fab_returned'] = $fab_ret;
$response_data['shortages'] = $shortages;
$response_data['damages']   = $damages;
$response_data['shift']     = $shift;
$response_data['section']   = $section;
$response_data['date']      = $date;
$response_data['doc_target_type']      = $target_doc_type;

echo json_encode($response_data);

?>