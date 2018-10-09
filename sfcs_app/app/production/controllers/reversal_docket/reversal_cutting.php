<?php
include(getFullURLLevel($_GET['r'],'/common/config/config.php',4,'R'));
include(getFullURLLevel($_GET['r'],'functions.php',0,'R'));
$doc_no_ref = $_GET['doc_no_ref'];
$plies_post = $_GET['plies'];
// $go_back_to = $_GET['go_back_to'];
$bundle_no = array();
$op_code = '15';
$cut_done_qty = array();
$qry_to_find_in_out = "select * from $brandix_bts.bundle_creation_data where docket_number='$doc_no_ref'";
$qry_to_find_in_out_result = $link->query($qry_to_find_in_out) or exit('Error');
// var_dump($qry_to_find_in_out_result);
error_reporting(0);
if(mysqli_num_rows($qry_to_find_in_out_result) > 0)
{
    $plies = $_GET['plies'];
    $qry_cut_qty_check_qry = "SELECT * FROM $bai_pro3.plandoc_stat_log WHERE doc_no = '$doc_no_ref' ";
    // echo $qry_cut_qty_check_qry;
    $result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
    while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
    {
        // $doc_array[$row['doc_no']] = $row['act_cut_status'];
        for ($i=0; $i < sizeof($sizes_array); $i++)
        { 
            if ($row['a_'.$sizes_array[$i]] > 0)
            {
                $cut_done_qty[$sizes_array[$i]] = $row['a_'.$sizes_array[$i]] * $plies;
            }
        }
    }
    $rec_qty =0 ;
    $left_over_qty = 0;
    foreach ($cut_done_qty as $key => $value)
    {
        //updating cut qty into bundle_creation_data and cps log
        $selecting_qry = "SELECT * FROM $brandix_bts.bundle_creation_data WHERE docket_number = '$doc_no_ref' AND size_id = '$key' AND operation_id = '$op_code'";
        // echo $selecting_qry.'<br/>';
        $result_selecting_qry = $link->query($selecting_qry);
        while($row_result_selecting_qry = $result_selecting_qry->fetch_assoc()) 
        {
            $id_to_update = $row_result_selecting_qry['id'];
            $mapped_color = $row_result_selecting_qry['mapped_color'];
            $ref_no = $row_result_selecting_qry['bundle_number'];
            $b_style = $row_result_selecting_qry['style'];
        }
        $update_qry = "update $brandix_bts.bundle_creation_data set recevied_qty = recevied_qty-$value where id = $id_to_update";
        // echo $update_qry.'<br/>';
        $updating_bundle_data = mysqli_query($link,$update_qry) or exit("While updating budle_creation_data".mysqli_error($GLOBALS["___mysqli_ston"]));
        // updating cut qty into  cps log
        $selecting_cps_qry = "SELECT * FROM $bai_pro3.cps_log WHERE `doc_no`='$doc_no_ref' AND `size_code`=  '$key' AND operation_code = '$op_code'";
        $result_selecting_cps_qry = $link->query($selecting_cps_qry);
        while($row_result_selecting_cps_qry = $result_selecting_cps_qry->fetch_assoc()) 
        {
            $id_to_update_cps = $row_result_selecting_cps_qry['id'];
        }
        $update_qry_cps = "update $bai_pro3.cps_log set remaining_qty = remaining_qty-$value where id = $id_to_update_cps";
        // echo $update_qry_cps.'<br/>';
        $updating_cps = mysqli_query($link,$update_qry_cps) or exit("While updating cps".mysqli_error($GLOBALS["___mysqli_ston"]));

        //updating for next operation send_qty
        $ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$mapped_color' and operation_code='$op_code'";
        $result_ops_seq_check = $link->query($ops_seq_check);
        while($row = $result_ops_seq_check->fetch_assoc()) 
        {
            $ops_seq = $row['ops_sequence'];
            $seq_id = $row['id'];
            $ops_order = $row['operation_order'];
        }

        $reversal_docket_log= "insert into $brandix_bts.reversal_docket_log(docket_number,parent_bundle_creation_id,bundle_number,size_title,cutting_reversal,act_cut_status)values(".$doc_no_ref.",".$id_to_update.",".$ref_no.",'".$key."',".$value.",'Reversal')";
        // echo $reversal_docket_log.'<br/>';
        $reversal_docket_log_qry = mysqli_query($link,$reversal_docket_log) or exit(" Error7".mysqli_error ($GLOBALS["___mysqli_ston"]));


        $post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$mapped_color' and ops_sequence = $ops_seq  AND CAST(operation_order AS CHAR) > '$ops_order' AND operation_code not in (10,200) ORDER BY operation_order ASC LIMIT 1";
        $result_post_ops_check = $link->query($post_ops_check);
        if($result_post_ops_check->num_rows > 0)
        {
            while($row = $result_post_ops_check->fetch_assoc()) 
            {
                $post_ops_code = $row['operation_code'];
            }
        }
        $update_qry_post = "update $brandix_bts.bundle_creation_data set send_qty = send_qty-$value WHERE docket_number = '$doc_no_ref' AND size_id = '$key' AND operation_id = '$op_code'";
        // echo $update_qry_post.'<br/>';
        $updating_post_ops = mysqli_query($link,$update_qry_post) or exit("While updating cps".mysqli_error($GLOBALS["___mysqli_ston"]));
        // echo '<br/>'.$ref_no.','.$value.','.$op_code.'<br/>';
        $updation_m3 = updateM3TransactionsReversal($ref_no,$value,$op_code);  
    }
    $update_plies_qry = "UPDATE $bai_pro3.plandoc_stat_log SET a_plies=a_plies-$plies_post WHERE doc_no=$doc_no_ref";
    // echo $update_plies_qry.'<br/>';
    $update_plies_qry_result = mysqli_query($link,$update_plies_qry) or exit(" Error4".mysqli_error ($GLOBALS["___mysqli_ston"]));
}
echo "<script>sweetAlert('Reversal Docket','Updated Successfully','success');</script>";
$url = getFullURLLevel($_GET['r'],'reversal_docket_form.php',0,'N');
echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",100); function Redirect() {  location.href = \"$url\"; }</script>";