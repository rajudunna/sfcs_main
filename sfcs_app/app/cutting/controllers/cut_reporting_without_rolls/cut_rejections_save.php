

<?php

/*  Return 
    1 - if everything is success
    2 - if m3 upating is failed and others went good
    3 - Rejections Completely updated with Errors
*/    
// include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/m3Updations.php');

function save_rejections($doc_no,$rejection_details,$style,$schedule,$color,$shift,$cut_remarks=0){
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');

    $op_code = 15;
    $date = date('Y-m-d');
    $date_time = date('Y-m-d H:i:s');
    $time = date('H:i:s');
    $update_counter = 0;
    $remarks = 'CUT-'.$shift.'-P';
    $total_rej = 0;
    $form_type = 'P';
    if(!strtolower($cut_remarks == 'recut'))
        $cut_remarks = 'normal';
        
    $verify_query = "SELECT * from $bai_pro3.rejections_log where style='$style' and schedule='$schedule' 
                    and color='$color'";                
    $result = mysqli_query($link,$verify_query) or exit('Rejections Log Error 1');  
    while($row = mysqli_fetch_array($result))   
           $id = $row['id'];
    
    if($id > 0)
        $parent_id = $id;
    else{
        $rejection_log_query = "INSERT into $bai_pro3.rejections_log 
            (style,SCHEDULE,color,rejected_qty,replaced_qty,recut_qty,remaining_qty,status) 
            values ('$style','$schedule','$color',0,0,0,0,'P')";    
        $rejection_log_result = mysqli_query($link,$rejection_log_query) or exit('Rejections Log Error 2');
        $parent_id = mysqli_insert_id($link);
    }
    foreach($rejection_details as $size => $reason_wise){
        $total_sum = 0;
        $reason_qty_string = '';
        foreach($reason_wise as $reason_code => $qty){
            if($qty > 0){
                $total_sum   += $qty;
                $qms_m3_code =  explode('-',$reason_code);
                $qms_code = $qms_m3_code[0];
                $m3_code  = $qms_m3_code[1]; 

                $reason_codes[$size][] = $qms_code;
                $m3_reasons[$size][] = $m3_code; //THE $m3_reasons,$m3_qtys are for passing to m3 updations function
                $m3_qtys[$size][] = $qty;

                $reason_qty_string = $reason_qty_string.''.$qms_code.'-'.$qty.'$';
            }
        }
        $total_rej += $total_sum;
        $qms_ref1[$size] = $reason_qty_string; //qms ref1 sie wise into an array 
        $rejected[$size] = $total_sum;//total size wise qty sum into an array
    }
    
    foreach($rejected as $size => $qty){
        $bcd_data_query = "SELECT id,bundle_number,assigned_module,size_title from 
        $brandix_bts.bundle_creation_data where docket_number = $doc_no and  size_id = '$size' and operation_id = $op_code ";
        $bcd_data_reuslt = mysqli_query($link,$bcd_data_query) or exit('BCD Error 1');
        if(mysqli_num_rows($bcd_data_reuslt) > 0){
            $row = mysqli_fetch_array($bcd_data_reuslt);
            $id = $row['id'];
            $bno = $row['bundle_number'];
            $assigned_module = $row['assigned_module'];
            $size_title = $row['size_title'];  
            $module = $row['assigned_module'];  
            $bundle_numbers[$size] = $bno; 

            
            $bcd_id_qry = "SELECT bcd_id from $bai_pro3.rejection_log_child where bcd_id = $id";
            $bcd_id_result=mysqli_query($link,$bcd_id_qry) or exit("bcd_id_searching_qry_result");
            if($bcd_id_result->num_rows > 0)
			{
                if($qty == '')
                    $qty = 0;
                $update_rejection_log_child_qry = "UPDATE $bai_pro3.rejection_log_child set rejected_qty=rejected_qty+$qty 
                            where bcd_id = $id";
				mysqli_query($link,$update_rejection_log_child_qry) or exit('Updating Error 1');
            }else{
                $rejection_log_child_query  =  "INSERT INTO $bai_pro3.rejection_log_child (parent_id,bcd_id,doc_no,size_id,size_title,assigned_module,rejected_qty,recut_qty,replaced_qty,issued_qty,operation_id)
                values
                ($parent_id,$id,$doc_no,'$size','$size_title','$assigned_module',$qty,0,0,0,$op_code)";
                $rejection_log_child_result =  mysqli_query($link,$rejection_log_child_query) or exit('Rejections Child Error');
            }

            //inserting resaon wise into the new table - rejections_reason_track
            foreach($reason_codes[$size] as $key => $reason){
                $rejections_reson_track_query = "INSERT INTO $bai_pro3.rejections_reason_track 
                            (date_time,parent_id,bcd_id,rejection_reason,rejected_qty,form_type,username) 
                            VALUES('$date_time',$parent_id,$id,'$reason',".$m3_qtys[$size][$key].",
                                    '$form_type','$username')";
                mysqli_query($link,$rejections_reson_track_query);            
            }
            /*
            $update_cps_query = "UPDATE $bai_pro3.cps_log set remaining_qty = remaining_qty-$qty where doc_no = $doc_no 
                                and size_code = '$size' and operation_code = $op_code";                 
            $update_cps_result = mysqli_query($link,$update_cps_query) or exit('CPS Error 1');
            
            $update_bcd_query = "UPDATE $brandix_bts.bundle_creation_data set rejected_qty = rejected_qty + $qty 
                                where docket_number = $doc_no and size_id='$size' and operation_id = $op_code ";
            $update_bcd_result = mysqli_query($link,$update_bcd_query);

            
            $update_moq_query = "UPDATE $bai_pro3.mo_operation_quantites set good_quantity = good_quantity-$qty where ref_no = $bno 
                                and op_code = $op_code";                 
            $update_moq_result = mysqli_query($link,$update_moq_query) or exit('MOQ Error 1');
            */
            //foreach($rejection_details[$size] as $reasons => $qtys){
                //$qty_array[]     = $qtys;
                // $qms_m3_code =  explode('-',$reasons);
                // //$qms_code = $qms_m3_code[0];
                // $m3_code  = $qms_m3_code[1]; 
                // $reasons_array[] = $m3_code;
            //}

            $ref1 = $qms_ref1[$size];
            $ref1 = rtrim($ref1,'$');
            $qms_insert_query = "INSERT INTO $bai_pro3.bai_qms_db 
            (qms_style,qms_schedule,qms_color,qms_remarks,bundle_no,log_user,log_date,log_time,issued_by,qms_size,qms_qty,qms_tran_type,remarks,ref1,doc_no,location_id,input_job_no,operation_id)
            values
            ('$style','$schedule','$color','$cut_remarks',$bno,'$username','$date','$time','$username','$size',$qty,3,'$remarks',
             '$ref1',$doc_no,'','',$op_code)";
            mysqli_query($link,$qms_insert_query) or exit('QMS DB Error ');  
            
            if($update_cps_result && $update_bcd_result)
                $update_counter++;
        }
    }
    $sent = 0;
    //Again Seperating M3 Updations from basic operation flow to maintain consistency
    foreach($rejected as $size => $ignore){
        $sent++;
        $reject_report = updateM3TransactionsRejections($bundle_numbers[$size],$op_code,$m3_qtys[$size],$m3_reasons[$size]);
        if($reject_report == true){
            $confirmed++;
        }
    }
    
    $rejection_log_uquery = "UPDATE $bai_pro3.rejections_log set rejected_qty = rejected_qty+$total_rej,
                            remaining_qty = remaining_qty + $total_rej where id=$parent_id";
    $rejection_log_uresult = mysqli_query($link,$rejection_log_uquery) or exit('Rejection Log Error 3');
    if($sent == $confirmed)
        return 1;
    else    
        return 3;    
}

?>