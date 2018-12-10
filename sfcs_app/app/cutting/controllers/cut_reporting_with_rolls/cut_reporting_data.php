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

$doc_status_query  = "SELECT a_plies,p_plies,acutno,act_cut_status,order_tid,org_doc_no,remarks,($a_sizes_sum) as ratio 
                    from $bai_pro3.plandoc_stat_log where doc_no = '$doc_no'";
$doc_status_result = mysqli_query($link,$doc_status_query);
if(mysqli_num_rows($doc_status_result)>0){
    $row = mysqli_fetch_array($doc_status_result);
    $a_plies = $row['a_plies'];
    $p_plies = $row['p_plies'];
    $act_cut_status = $row['act_cut_status'];
    $acutno = $row['acutno'];
    $fabric_status = $row['fabric_status'];
    $order_tid = $row['order_tid'];
    $org_doc_no = $row['org_doc_no'];
    $ratio = $row['ratio'];
    $remarks = $row['remarks'];
    if($fabric_status == 5)
        $fabric_status = 'Issued To Cutting';
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
/*
$validation_query = "SELECT cat_ref,fabric_status,category from $bai_pro3.order_cat_doc_mk_mix 
                    where doc_no=$doc_no";
$validation_result = mysqli_query($link,$validation_query);
if(mysqli_num_rows($validation_result)>0){
    $row = mysqli_fetch_array($validation_result);
    $cat_ref  = $row['cat_ref'];
    $category = strtolower($row['category']);
   
    if(in_array($category,$fabric_categories_array) && $cat_ref > 0)
        $response_data['can_report']   = 1;
    else    
        $response_data['can_report']   = 2;
    
    echo json_encode($response_data);
    exit();
}else{
    $response_data['can_report']   = 0;
    
    echo json_encode($response_data);
    exit();
}*/

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
if(strtolower($remarks) == 'recut')
    $target_doc_type = 'recut'; 

//if clubbed docket then getting all child dockets
$child_docs_query = "SELECT GROUP_CONCAT(doc_no) as doc_no 
                from $bai_pro3.plandoc_stat_log where org_doc_no = '$doc_no' ";
$child_docs_result = mysqli_query($link,$child_docs_query);
while($row = mysqli_fetch_array($child_docs_result)){
    $doc_no = $row['doc_no'];
}
if($doc_no == '')
    $doc_no = $_GET['doc_no'];

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

//getting good and rejected pieces
$good_rej_query = "SELECT SUM(recevied_qty) as good,SUM(rejected_qty) as rej 
                from $brandix_bts.bundle_creation_data where docket_number='$doc_no' and operation_code = 15";


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


function getRejectionDetails($doc_no){
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

    $get_sizes = "SELECT size_code,size_title from $bai_pro3.cps_log where doc_no = $doc_no 
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


function getRollsData($doc_no){
    global $link;
    global $bai_pro3;
    global $bai_rm_pj1;

    $rollwisedata = array(); 
    $rolltabeldata = array();  
    $lot_details_query="select * from $bai_rm_pj1.fabric_cad_allocation where doc_no=$doc_no"; 
    //echo $sql."<br>"; 
    $lot_details_result=mysqli_query($link,$lot_details_query); 
    while($row=mysqli_fetch_array($lot_details_result)) 
    { 
        $rollwisedata['roll_id']    = $row['roll_id']; 
        $rollwisedata['roll_width'] = $row['roll_width']; 
        $rollwisedata['doc_type']   = $row['doc_type']; 
        $rollwisedata['allocated_qty'] = $row['allocated_qty']; 
        $allocated_quantity_fabric =  $row['allocated_qty']; 
        $rollwisedata['tran_pin']  = $row['tran_pin'];     
        
        $lot_no_query = "select lot_no,ref4 from $bai_rm_pj1.store_in where tid=".$row['roll_id'];  
        $lot_no_result = mysqli_query($link,$lot_no_query); 
        while($row1=mysqli_fetch_array($lot_no_result)) 
        { 
            $rollwisedata['lot_no'] = ($row1['lot_no']) ? $row1['lot_no'] : 'No Data'; 
            $rollwisedata['ref4']   = ($row1['ref4'])   ? $row1['ref4']   : 'No Data'; 
            array_push($rolltabeldata, $rollwisedata);     
        }     
    } 

    if(sizeof($rolltabeldata) > 0)
    { 
        $response_data = "<u><h2 align='center'>Update RolL Information</h2></u> 
        <div class='row'> 
        <div class='col-md-12 table-responsive'><table class='table table-bordered'> 
            <thead><tr>
                <th>Roll No</th><th>Roll Width</th><th>Doc Type</th><th>Allocated Quantity</th>
                <th>Lot No</th><th>Shade</th><th>Roll Plies</th><th>End Bits</th></tr></thead> 
            <tbody>";
                    
                foreach ($rolltabeldata as $key => $value) { 
                    echo "<tr><td>".$value['roll_id']."</td>
                        <td>".$value['roll_width']."</td>
                        <td>".$value['doc_type']."</td>
                        <td>".$value['allocated_qty']."</td><td>".$value['lot_no']."</td>
                        <td>".$value['ref4']."<input type='hidden' name='inputdata[$key][shade]' value=".$value['ref4']."></td>
                        <td><input class='form-control roleplies integer' type='text' name='inputdata[$key][roleplies]' id='inputdata[$key][roleplies]' onchange='validatePlies(this.id)'></td>
                        <td><input class='form-control integer' type='text' name=\"inputdata[$key][nbits]\" onkeypress='return isNumber(event)'></td>
                        <input type='hidden' name='inputdata[$key][tran_pin]' value=".$value['tran_pin']."></tr>";
                }
        $response_data .= "</tbody> 
        </table></div></div>";
        echo $response_data; 
    }else{
        echo "0";
    }
    
}

?>