<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
$SEWIN = 100;
$SEWOUT = 130;

if(isset($_GET['fetch'])){
    $doc_no = $_GET['doc_no'];

    if($doc_no > 0){
        //verifying for valid docket or not (sewing jobs has to be created) 
        $doc_query = "SELECT doc_no from $bai_pro3.packing_summary_input where doc_no = $doc_no limit 1";
        if(mysqli_num_rows(mysqli_query($link,$doc_query)) > 0){
            $doc_query1 = "SELECT doc_no from $bai_pro3.packing_summary_input where doc_no = $doc_no and mrn_status=1";
        	if(mysqli_num_rows(mysqli_query($link,$doc_query1)) > 0)
        	{
            	$response_data['mrn'] = 0;
            	 echo JSON_ENCODE($response_data);
   			 	exit();
        	}
        	$doc_query12 = "SELECT doc_no from $bai_pro3.packing_summary_input where doc_no = $doc_no and bundle_print_status=1";
        	if(mysqli_num_rows(mysqli_query($link,$doc_query12) > 0))
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
                $verify_scan_query = "SELECT id from $brandix_bts.bundle_creation_data where docket_number = $doc_no and operation_id IN ($SEWIN,$SEWOUT) limit 1";                    
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