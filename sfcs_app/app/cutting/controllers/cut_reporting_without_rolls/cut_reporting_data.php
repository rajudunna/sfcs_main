<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
error_reporting(1);

$response_data = array();
$op_code = 15;

foreach($sizes_array as $size){
    $a_sizes_sum .= 'a_'.$size.'+';
    $a_sizes_str .= 'a_'.$size.',';
}
$a_sizes_sum = rtrim($a_sizes_sum,'+');
$a_sizes_str = rtrim($a_sizes_str,',');


if($_GET['rejection_docket']!=''){
    $r_doc = $_GET['rejection_docket'];
    //if clubbed docket then getting all child dockets
    $child_docs_query = "SELECT GROUP_CONCAT(doc_no) as doc_no from $bai_pro3.plandoc_stat_log where org_doc_no = $r_doc ";
    $child_docs_result = mysqli_query($link,$child_docs_query);
    while($row = mysqli_fetch_array($child_docs_result)){
        $doc_no = $row['doc_no'];
        $child_docs = $doc_no;
    }
    getRejectionDetails($r_doc,$child_docs);
    exit();
}else{
    $doc_no = $_GET['doc_no'];
}

$doc_status_query  = "SELECT a_plies,p_plies,acutno,act_cut_status,order_tid,org_doc_no,remarks,($a_sizes_sum) as ratio 
                    from $bai_pro3.plandoc_stat_log where doc_no = $doc_no";
$doc_status_result = mysqli_query($link,$doc_status_query);
if(mysqli_num_rows($doc_status_result)>0){
    $row = mysqli_fetch_array($doc_status_result);
    $a_plies = $row['a_plies'];
    $p_plies = $row['p_plies'];
    $act_cut_status = $row['act_cut_status'];
   
    $order_tid = $row['order_tid'];
    $org_doc_no = $row['org_doc_no'];
    $ratio   = $row['ratio'];
    $remarks = $row['remarks'];
    $cut_no  = $row['acutno'];
    $doc_qty =  $p_plies * $ratio;
    
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

//Validation for fabric status

$validation_query = "SELECT cat_ref,fabric_status,category,material_req,plan_module from $bai_pro3.order_cat_doc_mk_mix 
                    where doc_no=$doc_no";
$validation_result = mysqli_query($link,$validation_query);
if(mysqli_num_rows($validation_result)>0){
    $row = mysqli_fetch_array($validation_result);
    $cat_ref  = $row['cat_ref'];
    $category = strtolower($row['category']);
    $fab_required = $row['material_req'];
    $module = $row['plan_module'];
    $fabric_status = $row['fabric_status'];
    if($cat_ref > 0 && $fabric_status == 5)
        $response_data['can_report']   = 1;
    else{    
        $response_data['can_report']   = 2;
        echo json_encode($response_data);
        exit();
    }
    if($fabric_status == 5)
        $fabric_status = 'Issued To Cutting';
}else{
    $response_data['can_report']   = 0;
    echo json_encode($response_data);
    exit();
}

$acut_no = '00'.$cut_no;
//getting the target doc type 
$target_query  = "SELECT color_code,order_del_no,order_joins from $bai_pro3.bai_orders_db_confirm 
                where order_tid = '$order_tid' and order_joins IN (1,2) limit 1";               
$target_result = mysqli_query($link,$target_query);
if(mysqli_num_rows($target_result) > 0){
    $row = mysqli_fetch_array($target_result);
    $acut_no = chr($row['color_code']).$acut_no;
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

//if clubbed docket then getting all child dockets
$child_docs_query = "SELECT GROUP_CONCAT(doc_no) as doc_no 
                from $bai_pro3.plandoc_stat_log where org_doc_no = $doc_no ";
$child_docs_result = mysqli_query($link,$child_docs_query);
while($row = mysqli_fetch_array($child_docs_result)){
    $doc_no = $row['doc_no'];
    $child_docs = $doc_no;
}
if($doc_no == ''){
    $doc_no = $_GET['doc_no'];
    $child_docs = $doc_no;
}


//getting good and rejected pieces
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
    $response_data['rej_pieces']  = $row['rej'];
    $response_data['good_pieces'] = $row['good'];
}

//Getting the reason wise rejections reported for displaying in front end  -- DONOT misplace this function below
if($response_data['rej_pieces'] > 0){
    $response_data['rej_size_wise_details'] = getReasonWiseDetails($doc_no);
}

//The docket number till above may be a single docket / all the child dockets of a parent docket

//The docket number below is always the main/parent docket
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

//Verifying for the 'F' forcefully reported docket
$nfully_report = 0;
$cps_full_status_query = "SELECT reported_status from $bai_pro3.cps_log where doc_no IN ($child_docs) 
                    and operation_code = $op_code ";                                        
$cps_full_status_result = mysqli_query($link,$cps_full_status_query);
while($row=mysqli_fetch_array($cps_full_status_result)){
    if($row['reported_status'] == 'P' || $row['reported_status'] == ''){
        $response_data['cut_done'] = 0;
        $nfully_report++;
    }else if($row['reported_status'] == 'F'){
        $response_data['cut_done'] = 1;
    }    
}            
if($response_data['cut_done'] == 1 && $fully_report =0 )
    $response_data['partial']  = 0;        

if(!in_array($category,$fabric_categories_array) ){
    $target_doc_type = 'dummy';
    $details = "SELECT order_del_no,order_col_des,order_style_no from bai_pro3.bai_orders_db_confirm where order_tid='$order_tid'";
    $details_r = mysqli_query($link,$details);
    $row1 = mysqli_fetch_array($details_r);
    $response_data['styles']   = $row1['order_style_no'];
    $response_data['schedules']= $row1['order_del_no'];
    $response_data['colors']   = $row1['order_col_des'];
    $response_data['good_pieces'] = $a_plies * $ratio;
    if($a_plies == $p_plies){
        $response_data['cut_done']  = 1;
    }
}
    
$response_data['doc_no'] = $doc_no;
$response_data['fab_required'] = $fab_required; 
$response_data['doc_qty']    = $doc_qty;
$response_data['ratio']      = $ratio;
$response_data['size_ratio'] = $size_ratio;
$response_data['p_plies']    = $p_plies;
$response_data['act_cut_status'] = $act_cut_status;
$response_data['acut_no'] = $acut_no;
$response_data['module']  = $module;
$response_data['fab_status']   = $fabric_status;
$response_data['fab_received'] = $fab_rec;
$response_data['fab_returned'] = $fab_ret;
$response_data['shortages'] = $shortages;
$response_data['damages']   = $damages;
$response_data['shift']     = $shift;
$response_data['section']   = $section;
$response_data['date']      = $date;
$response_data['doc_target_type'] = $target_doc_type;
$response_data['ratio_data']      = getSizesRatio($doc_no,$child_docs);


echo json_encode($response_data);
exit();

function getRejectionDetails($doc_no,$all_docs){
    global $link;
    global $bai_pro3;
    global $sizes_array;
    global $a_sizes_str;
    if($all_docs == '')
        $all_docs = $doc_no;
    $sizes_ratio = array();
    $ratio_query = "SELECT $a_sizes_str from $bai_pro3.plandoc_stat_log where doc_no = $doc_no ";
    $ratio_result = mysqli_query($link,$ratio_query) or exit('Problem in getting rejections');
    while($row = mysqli_fetch_array($ratio_result)){
        foreach($sizes_array as $size){
            if($row["a_$size"] > 0)
                $old_sizes_ratio[$size] = $row["a_$size"];
        }
    }

    $get_sizes = "SELECT distinct(size_code),size_title from $bai_pro3.cps_log where doc_no IN ($all_docs) 
            and operation_code = 15";
    $get_sizes_result = mysqli_query($link,$get_sizes) or exit('Problem in getting ol - new sizes map');
    while($row = mysqli_fetch_array($get_sizes_result)){
        $old_new_sizes[$row['size_code']] = $row['size_title'];
    }        

    $response_data['old_size_ratio'] = $old_sizes_ratio;
    $response_data['old_new_size']  = $old_new_sizes;
    
    echo json_encode($response_data);
    exit();
}


function getSizesRatio($doc_no,$all_docs){
    global $link;
    global $bai_pro3;
    global $sizes_array;
    global $a_sizes_str;

    $sizes_ratio = array();
    $ratio_query = "SELECT $a_sizes_str from $bai_pro3.plandoc_stat_log where doc_no = $doc_no ";
    $ratio_result = mysqli_query($link,$ratio_query) or exit('Problem in getting rejections');
    while($row = mysqli_fetch_array($ratio_result)){
        foreach($sizes_array as $size){
            if($row["a_$size"] > 0)
                $old_sizes_ratio[$size] = $row["a_$size"];
        }
    }

    $get_sizes = "SELECT distinct(size_code),size_title from $bai_pro3.cps_log where doc_no IN ($all_docs) 
            and operation_code = 15";
    $get_sizes_result = mysqli_query($link,$get_sizes) or exit('Problem in getting ol - new sizes map');
    while($row = mysqli_fetch_array($get_sizes_result)){
        $old_new_sizes[$row['size_code']] = $row['size_title'];
    }        

    foreach($old_sizes_ratio as $size => $qty){
        $sizes[]  = $old_new_sizes[$size];
        $ratios[] = $qty;
    } 

    $html_append = "<b>Size Wise Ratios</b><table class='table table-bordered'><thead><tr class='danger'>";
    foreach($sizes as $size){
        $html_append.="<th><b>$size</b></th>";
    }
    $html_append .= "</tr></thead><tbody><tr>";
    foreach($ratios as $ratio){
        $html_append.="<td>$ratio</td>";
    }
    $html_append .= "</tr></tbody><table>";

    return $html_append;
}


function getReasonWiseDetails($doc_no){
    global $style,$color,$schedule,$op_code;
    global $link;
    global $bai_pro3,$brandix_bts;
    $docs = implode(',',$doc_no);
    $sno = 0;
    
    $bcd_ids_query = "SELECT id,size_title from $brandix_bts.bundle_creation_data where docket_number IN ($doc_no) 
                and operation_id = $op_code";
    $bcd_ids_result = mysqli_query($link,$bcd_ids_query);
    while($row = mysqli_fetch_array($bcd_ids_result)){
        $ids[]   = $row['id'];
        $sizes[$row['id']] = $row['size_title'];
    }
    $ids = implode(',',$ids);

    $html_data = "<table class='table table-bordered'><thead><tr class='info'>
                    <th>Sno</th><th>Size</th><th>Reason</th><th>Quantity</th></tr></thead><tbody>";
    $rej_wise_details_query = "SELECT bcd_id,SUM(rejected_qty) AS rejected_qty,bqr.reason_desc AS reason
                        FROM $bai_pro3.rejections_reason_track rrt
                        LEFT JOIN $bai_pro3.bai_qms_rejection_reason bqr ON rrt.rejection_reason =  bqr.reason_code 
                        AND rrt.form_type = bqr.form_type 
                        WHERE  bcd_id IN  ($ids) 
                        GROUP BY bcd_id,rejection_reason";                 
    $rej_wise_details_result = mysqli_query($link,$rej_wise_details_query);
    while($row = mysqli_fetch_array($rej_wise_details_result)){
        $sno++;
        $qty    = $row['rejected_qty'];
        $id     = $row['bcd_id'];
        $reason = $row['reason'];
        $html_data .= "<tr><td>$sno</td><td>".$sizes[$id]."</td><td>$reason</td><td>$qty</td></tr>";
    }
    $html_data .= "</tbody></table>";

    return $html_data;
}
?>