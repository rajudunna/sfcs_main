<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
$SEWIN = 100;
$SEWOUT = 130;

if(isset($_GET['fetch'])){
    $doc_no = $_GET['doc_no'];

    if($doc_no > 0){
        //verifying for bundles printing
        $print_query = "SELECT tid from $bai_pro3.pac_stat_log_input_job where doc_no = $doc_no and bundle_print_status > 0";
        if(mysqli_num_rows(mysqli_query($link,$print_query)) > 0){
            $response_data['printed'] = 1;
            echo JSON_ENCODE($response_data);
            exit();
        }
        //verifying for valid docket or not (sewing jobs has to be created) 
        $doc_query = "SELECT doc_no,order_style_no,order_col_des from $bai_pro3.packing_summary_input where doc_no = $doc_no limit 1";
        if(mysqli_num_rows(mysqli_query($link,$doc_query)) > 0){
            // $doc_query1 = "SELECT doc_no from $bai_pro3.packing_summary_input where doc_no = $doc_no and mrn_status=1";
            // if(mysqli_num_rows(mysqli_query($link,$doc_query1)) > 0)
            // {
            //  $response_data['mrn'] = 0;
            //   echo JSON_ENCODE($response_data);
            //      exit();
            // }
             $row_data = mysqli_fetch_array(mysqli_query($link,$doc_query));
             $main_style = $row_data['order_style_no'];
             $main_color = $row_data['order_col_des'];

             $op_codes_query = "SELECT tor.operation_code,tor.operation_name FROM brandix_bts.tbl_orders_ops_ref AS tor LEFT JOIN `brandix_bts`.`tbl_style_ops_master` AS tosm ON tor.operation_code=tosm.operation_code WHERE category = 'sewing' AND display_operations='yes' AND style='$main_style' AND color='$main_color' ORDER BY operation_order*1 ";
             $op_codes_result = mysqli_query($link,$op_codes_query) or exit('Problem in getting the op codes for sewing');
             while($row = mysqli_fetch_array($op_codes_result))
             {
                $ops[]=$row['operation_code'];
             }

            $doc_query12 = "SELECT doc_no from $bai_pro3.packing_summary_input where doc_no = $doc_no and bundle_print_status=1";
            if(mysqli_num_rows(mysqli_query($link,$doc_query12)) > 0)
            {
                $response_data['print_status'] = 0;
                 echo JSON_ENCODE($response_data);
                exit();
            }       
            $doc_details_query = "SELECT a_plies,order_style_no,order_del_no,order_col_des,org_doc_no from $bai_pro3.plandoc_stat_log psl
                left join $bai_pro3.bai_orders_db bd ON bd.order_tid = psl.order_tid
                where doc_no = $doc_no";  
            $row = mysqli_fetch_array(mysqli_query($link,$doc_details_query));

            if($row['org_doc_no'] > 0)
                $response_data['clubbed'] = 1;
            else{    
                $a_plies  = $row['a_plies'];
                $style    = $row['order_style_no'];
                $schedule = $row['order_del_no'];
                $color    = $row['order_col_des'];
                
                //verifying if any job related to the schedule is scanned or not
                $verify_scan_query = "SELECT id from $brandix_bts.bundle_creation_data where docket_number = $doc_no and recevied_qty > 0 and rejected_qty = 0 and operation_id IN (".implode(",",$ops).") limit 1";                    
                if(mysqli_num_rows(mysqli_query($link,$verify_scan_query)) > 0){
                    $response_data['scanned'] = 1;
                }else{
                    $response_data['plies']    = $a_plies;
                    $response_data['style']    = $style;
                    $response_data['schedule'] = $schedule;
                    $response_data['color']    = $color;
                    //checking if the doc in slaready splitted or not
                    // $split_check_query = "SELECT id from $bai_pro3.shade_split where doc_no = $doc_no";
                    // if(mysqli_num_rows(mysqli_query($link,$split_check_query)) > 0){
                    //     $response_data['already_split'] = 1;
                    // }
                }          
            }
        }
        else
        {
            $response_data['found'] = 0;
        }
    }
    else
    {
        $response_data['found'] = 0;
    }
    echo JSON_ENCODE($response_data);
    exit();
}

?>