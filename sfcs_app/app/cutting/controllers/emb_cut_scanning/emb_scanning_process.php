<?php
include("../../../../common/config/config_ajax.php");
$post_data = $_POST['bulk_data'];
parse_str($post_data,$new_data);

$b_doc_no = $new_data['doc_number'];
$b_module = $new_data['module'];
$b_shift = $new_data['shift'];
$b_tid = $new_data['tid'];
$b_op_id = $new_data['operation_id'];
$b_op_name = $new_data['operation_name'];
$b_rej_qty=$new_data['rejection_qty'];
$b_rep_qty=$new_data['reporting_qty'];
$rep_sum_qty = array_sum($b_rep_qty);
$rej_sum_qty = array_sum($b_rep_qty);
$r_reason=$new_data['reason_data'];
$r_qtys=$new_data['qty_data'];
$r_no_reasons = $new_data['tot_reasons'];
$b_a_cut_no = $new_data['a_cut_no'];
$b_old_rep_qty = $new_data['old_rep_qty'];
$b_old_rej_qty = $new_data['old_rej_qty'];
$page_flag = $new_data['page_flag'];

//Total reproted quantity for the docket
$tot_report_qty_doc = $rep_sum_qty+$rej_sum_qty;

//update send and receive quantity in emblishement plan dashboard table
if($page_flag == 'send'){
    $embellishment_plan_dashboard_qry = "UPDATE $bai_pro3.embellishment_plan_dashboard SET `send_qty`= send_qty+$tot_report_qty_doc where doc_no =$b_doc_no and send_op_code=$b_op_id";
    echo $embellishment_plan_dashboard_qry;
   // $cps_log_result = $link->query($cps_log_qry) or exit('Embellishment Plan Dashboard query send error');
}else if($page_flag == 'receive'){
    $embellishment_plan_dashboard_qry = "UPDATE $bai_pro3.embellishment_plan_dashboard SET `receive_qty`= receive_qty+$tot_report_qty_doc where doc_no =$b_doc_no and receive_op_code=$b_op_id";
    $cps_log_result = $link->query($cps_log_qry) or exit('Embellishment Plan Dashboard query receive error');
}

/*looping bundle number in BCD 
    1) to update shift and module number and good qty,rejected qty and reasons in BCD
    2) to update remaing quantity in CPS log
*/
foreach($b_tid as $key => $value){

    //Total reproted quantity for the size
    $tot_report_qty = $b_rep_qty[$key]+$b_rej_qty[$key];

    //update remaining quantity in cps_log table
    $cps_log_qry = "UPDATE $bai_pro3.cps_log SET `remaining_qty`= remaining_qty+$tot_report_qty where id =$b_tid[$key]";    
    //$cps_log_result = $link->query($cps_log_qry) or exit('CPS LOG query error');
        
    //update shift and module against to each bundle number in BCD insert rejection in qms_db




}


?>

