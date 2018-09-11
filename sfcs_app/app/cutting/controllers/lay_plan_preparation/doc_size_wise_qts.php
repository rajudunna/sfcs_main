<?php

// var_dump($sizes_array);
function doc_size_wise_bundle_insertion($doc_no_ref)
{
    include("../../../../common/config/config_ajax.php");
    include("../../../../common/config/mo_filling.php");
    $category=['cutting','Send PF','Receive PF'];
    $operation_codes = array();
    error_reporting(0);
    // $doc_no_ref = 2190;
    foreach($category as $key => $value)
    {
        $fetching_ops_with_cat = "SELECT operation_code,short_cut_code FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE category = '$category[$key]'";
    // echo $fetching_ops_with_cat;
        $result_fetching_ops_with_cat=mysqli_query($link,$fetching_ops_with_cat) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($row=mysqli_fetch_array($result_fetching_ops_with_cat))
        {
            $operation_codes[] = $row['operation_code'];
            $short_key_code[] = $row['short_cut_code'];

        }
    }
    // var_dump($operation_codes);
    // var_dump($short_key_code);
        $cut_done_qty = array();
        //logic to insert into bundle_creation_data with doc,size and operation_wise
        $qry_cut_qty_check_qry = "SELECT * FROM $bai_pro3.plandoc_stat_log WHERE doc_no = '$doc_no_ref' ";
        $result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
        // echo $qry_cut_qty_check_qry;
        while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
        {
            $order_tid = $row['order_tid'];
            for ($i=0; $i < sizeof($sizes_array); $i++)
            { 
                if ($row['a_'.$sizes_array[$i]] > 0)
                {
                    $cut_done_qty[$sizes_array[$i]] = $row['a_'.$sizes_array[$i]] * $row['a_plies'];
                }
            }
        }
        foreach($cut_done_qty as $key => $value)
        {
            $qty_to_fetch_size_title = "SELECT *,title_size_$key  FROM $bai_pro3.bai_orders_db_confirm WHERE order_tid ='$order_tid'";
            // echo $qty_to_fetch_size_title;
            $res_qty_to_fetch_size_title=mysqli_query($link,$qty_to_fetch_size_title) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($nop_res_qty_to_fetch_size_title=mysqli_fetch_array($res_qty_to_fetch_size_title))
            {
                $size_title = $nop_res_qty_to_fetch_size_title["title_size_$key"];
                $b_style =  $nop_res_qty_to_fetch_size_title['order_style_no'];
                $b_schedule =  $nop_res_qty_to_fetch_size_title['order_del_no'];
                $b_colors =  $nop_res_qty_to_fetch_size_title['order_col_des'];
            }
            $b_size_code = $key;
            $b_sizes = $size_title;
            $sfcs_smv = 0;
            $b_tid = $doc_no_ref;
            $b_in_job_qty = $value;
            $send_qty = $value;
            $rec_qty = 0;
            $rej_qty = 0;
            $left_over_qty = 0;
            $b_doc_num = $doc_no_ref;
            $b_a_cut_no = $doc_no_ref;
            $b_inp_job_ref = $doc_no_ref;
            $b_job_no = $doc_no_ref;
            $b_shift = 'G';
            $b_module = '0';
            $b_remarks = 'Normal';
            $mapped_color = $b_colors;
            foreach($operation_codes as $index => $op_code)
            {
                $b_cps_qty[$op_code] = "INSERT INTO $bai_pro3.cps_log(`operation_code`,`short_key_code`,`cut_quantity`,`remaining_qty`,`doc_no`,`size_code`,`size_title`) VALUES";
                $b_cps_qty[$op_code] .= '("'.$op_code.'","'. $short_key_code[$index].'","'.$b_in_job_qty.'","0","'. $b_job_no.'","'.$b_size_code.'","'. $b_sizes.'")';
                $bundle_creation_result_002 = $link->query($b_cps_qty[$op_code]);
                $last_id = mysqli_insert_id($link);
                $b_query[$op_code] = "INSERT  INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `mapped_color`) VALUES";
                $b_query[$op_code] .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors.'","'.$b_size_code.'","'. $b_sizes.'","'. $sfcs_smv.'","'.$last_id.'","'.$b_in_job_qty.'","'.$send_qty.'","'.$rec_qty.'","'.$rej_qty.'","'.$left_over_qty.'","'. $op_code.'","'.$b_doc_num.'","'.date('Y-m-d').'","'.$b_a_cut_no.'","'.$b_inp_job_ref.'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$b_remarks.'","'.$mapped_color.'")';
                $bundle_creation_result_001 = $link->query($b_query[$op_code]);
                $inserting_mo = insertMOQuantities($last_id,$op_code,$b_in_job_qty);
                //insertion_into_cps_log 
            }
        }
    return true;
}
?>