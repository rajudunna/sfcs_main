<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');

if(isset($_GET['fetch'])){
    $doc_no = $_GET['doc_no'];

    if($doc_no > 0){
        //verifying for valid docket or not
        $doc_query = "SELECT doc_no from $bai_pro3.packing_summary_input where doc_no = $doc_no limit 1";
        if(mysqli_num_rows(mysqli_query($link,$doc_query)) > 0){
            $doc_details_query = "SELECT a_plies,order_style_no,order_del_no,order_col_des from $bai_pro3.plandoc_stat_log psl
                left join $bai_pro3.bai_orders_db bd ON bd.order_tid = psl.order_tid
                where doc_no = $doc_no";  
            $row = mysqli_fetch_array(mysqli_query($link,$doc_details_query));

            $a_plies  = $row['a_plies'];
            $style    = $row['order_style_no'];
            $schedule = $row['order_del_no'];
            $color    = $row['order_col_des'];
            
            $response_data['plies']  = $a_plies;
            $response_data['style']    = $style;
            $response_data['schedule'] = $schedule;
            $response_data['color']    = $color;
        }else{
            $response_data['found'] = 0;
        }
    }else{
        $response_data['found'] = 0;
    }
    echo JSON_ENCODE($response_data);
    exit();
}

?>