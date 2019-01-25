

<?php

/*  Return 
    1 - if everything is success
    2 - if m3 upating is failed and others went good
    3 - Rejections Completely updated with Errors
*/    
function save_rejections($doc_no,$rejection_details,$style,$schedule,$color){
    $op_code = 15;
    global $link;
    global $bai_pro3;
    global $brandix_bts;
    $date = date('Y-m-d');
    $date_time = date('Y-m-d H:i:s');
    $time = date('H:i:s');
    $update_counter = 0;
    
    $rejection_log_query = "INSERT into $bai_pro3.rejections_log 
            (style,SCHEDULE,color,rejected_qty,replaced_qty,recut_qty,remaining_qty,status) 
            values ('$style','$schedule','$color',0,0,0,0,'P')";
    echo $rejection_log_query;        
    var_dump($link);
    $rejection_log_result = mysqli_query($link,$rejection_log_query);
    $parent_id = mysqli_insert_id($link);
    foreach($rejection_details as $size => $reason_wise){
        $total_sum = 0;
        $reason_qty_string = '';
        foreach($reason_wise as $reason_code => $qty){
            $total_sum   += $qty;
            $qms_m3_code =  explode('-',$reason_code);
            $qms_code = $qms_m3_code[0];
            $m3_code  = $qms_m3_code[1]; 

            $m3_reasons[$size] = $m3_code; //THE $m3_reasons,$m3_qtys are for passing to m3 updations function
            $m3_qtys[$size] = $qty;

            $reason_qty_string = $qms_code.'-'.$qty.'$';
        }
        $total_rej += $total_sum;
        $qms_ref1[$size] = $reason_qty_string; //qms ref1 sie wise into an array 
        $rejected[$size] = $total_sum;//total size wise qty sum into an array
    }
    
    foreach($rejected as $size => $qty){
        var_dump($rejection_details[$size]);
        $bcd_data_query = "SELECT id,bundle_number,assigned_module,size_title from $brandix_bts.bundle_creation_data 
                    where docket_number = $doc_no and  size_id = '$size' and operation_id = $op_code ";
        $bcd_data_reuslt = mysqli_query($link,$bcd_data);
        if(mysqli_num_rows($bcd_data_reuslt) > 0){
            $row = mysqli_fetch_array($bcd_data_reuslt);
            $id = $row['id'];
            $bno = $row['bundle_number'];
            $assigned_module = $row['assigned_module'];
            $size_title = $row['size_title'];    
            $bundle_numbers[$size] = $bno; 
            $rejection_log_child_query  =  "INSERT INTO $bai_pro3.rejection_log_child (parent_id,bcd_id,doc_no,size_id,size_title,assigned_module,rejected_qty,recut_qty,replaced_qty,issued_qty,operation_id)
            values
            ($parent_id,$id,$doc_no,'$size','$size_title','$assigned_module',$qty,0,0,0,$op_code)";
            $rejection_log_child_result =  mysqli_query($link,$rejection_log_child_query);

            $update_cps_result = "UPDATE $bai_pro3.cps_log set remaining_qty = remaining_qty-$qty where doc_no = $doc_no 
                                and size_code = $size and operation_code = $op_code";
            $update_cps_result = mysqli_query($link,$update_cps_query);

            $update_bcd_query = "UPDATE $brandix_bts.bundle_creation_data set rejected_qty = $qty 
                                where docket_number = $doc_no and size_id='$size' and operation_id = $op_code ";
            $update_bcd_result = mysqli_query($link,$update_bcd_query);
            //foreach($rejection_details[$size] as $reasons => $qtys){
                //$qty_array[]     = $qtys;
                // $qms_m3_code =  explode('-',$reasons);
                // //$qms_code = $qms_m3_code[0];
                // $m3_code  = $qms_m3_code[1]; 
                // $reasons_array[] = $m3_code;
            //}
            $ref1 = $qms_ref1[$size];
            $qms_insert_query = "INSERT INTO $bai_pro3.bai_qms_db 
            (qms_style,qms_schedule,qms_color,qms_remarks,bundle_no,log_user,log_date,log_time,issued_by,qms_size,qms_qty,qms_tran_type,remarks,ref1,doc_no,location_id,input_job_no,operation_id)
            values
            ('$style','$schedule','$color','remarks',$bno,$username,$date,$time,$username,$size,$qty,3,'remarks',
             '$ref1',$doc_no,'','',$op_code)";
            mysqli_query($link,$qms_insert_query);  
            
            if($update_cps_result && $update_bcd_result)
                $update_counter++;
        }
    }
    $sent = 0;
    foreach($rejected as $size => $ignore){
        $sent++;
        $reject_report = updateM3TransactionsRejections($bundle_numbers[$size],$op_code,$m3_qtys[$size],$m3_reasons[$size]);
        if($reject_report == true){
            $confirmed++;
        }
    }
    //Again Seperating M3 Updations from basic operation flow to maintain consistency

    $rejection_log_uquery = "UPDATE $bai_pro3.rejections_log set rejected_qty = $total_rej,rejected_qty = $total_rej 
                        where id=$parent_id";
    $rejection_log_uresult = mysqli_query($link,$rejection_log_uquery);
    if($sent == $confirmed && $size == $update_counter)
        return 1;
    else  if($size == $update_counter)  
        return 2;
    else    
        return 3;    
}

?>