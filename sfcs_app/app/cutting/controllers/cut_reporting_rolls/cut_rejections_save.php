

<?php


function save_rejections($doc_no,$rejection_details,$style,$schedule,$color){
    $op_code = 15;
    global $link;
    global $bai_pro3;
    global $brandix_bts;

    $rejection_log_query = "INSERT into $bai_pro3.rejections_log 
            (style,SCHEDULE,color,rejected_qty,replace_qty,recut_qty,remaining_qty,status) 
            values ('$style','$schedule','$color',0,0,0,$qty,'P')";
    $rejection_log_result = mysqli_query($link,$rejection_log_query);
    $parent_id = mysqli_insert_id($link);
    foreach($rejection_details as $size => $reason_wise){
        $total_sum = 0;
        foreach($reason_wise as $reason_code => $qty){
            $total_sum += $qty;
        }
        $total_rej += $total_sum;
        //total size wise qty sum
        $rejected[$size] = $total_sum;
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
            foreach($rejection_details[$size] as $reasons => $qtys){
                $qty_array[]     = $qtys;
                $reasons_array[] = $reasons;
            }
            
            $reject_report = updateM3TransactionsRejections($bno,$op_code,$qty_array,$reasons_array);
            unset($qty_array);
            unset($reasons_array);
        }
    }
    $rejection_log_uquery = "UPDATE $bai_pro3.rejections_log set rejected_qty = $total_rej where id=$parent_id";
    $rejection_log_uresult = mysqli_query($link,$rejection_log_uquery);

    return 1;
}

?>