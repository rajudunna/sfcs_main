<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/m3Updations.php');
//error_reporting(0);

$response_data = array();
$data = $_POST;

$target = $data['doc_target_type'];
$doc_no = $data['doc_no'];
$plies  = $data['c_plies'];
$f_ret  = $data['fab_returned'];
$f_rec  = $data['fab_received'];
$shift  = $data['shift'];
$cut_table = $data['cut_table'];
$team_leader = $data['team_leader'];
$bundle_location = $data['bundle_location'];
$returned_to = $data['returned_to'];
$damages = $data['damages'];
$shortages = $data['shortages'];
$style   = $data['style'];
$schedule= $data['schedule'];
$color   = $data['color'];

$date      = date('Y-m-d');
$date_time = date('Y-m-d H:i:s'); 

//Recut Docket Saving
if($target == 'recut'){

}

//Normal Docket Saving
if($target == 'normal'){
    //inserting to act_cutstatus
    $remarks = "$date^$cut_table^$shift^$f_rec^$f_ret^$damages^$shortages^$returned_to^$plies";
    $insert_query = "INSERT into $bai_pro3.act_cut_status (doc_no,date,section,shift,fab_received,fab_returned, 
                    damages,shortages,remarks,log_date,bundle_loc,leader_name) 
                    values ($doc_no,'$date','$cut_table','$shift','$f_rec','$f_ret','$damages','$shortages','$remarks','$date_time','$bundle_location','$team_leader')
                    ON DUPLICATE KEY 
                    UPDATE date='$date',section='$cut_table',shift='$shift',fab_received=fab_received + $f_rec,fab_returned='$f_ret',damages='$damages',shortages='$shortages',
                    remarks=CONCAT(remarks,'$','$remarks'),
                    log_date='$date_time',bundle_loc='$bundle_location',leader_name='$team_leader' ";

    $update_query = "UPDATE $bai_pro3.plandoc_stat_log set a_plies = a_plies + $plies,act_cut_status='DONE',
                    fabric_status=5 where doc_no = $doc_no ";
    $insert_result = mysqli_query($link,$insert_query) or exit('Query Error Cut 1');   
    
    mysqli_begin_transaction($link);
    if($insert_result > 0){
        $update_result = mysqli_query($link,$update_query) or exit('Query Error Cut 2');
        if($update_result){
            $response_data['saved'] = 1;
            mysqli_commit($link);
        }else{   
            $response_data['saved'] = 0;
            mysqli_rollback($link);    
        } 
    }else{
        $response_data['saved'] = 0;
    }
    mysqli_close($link);

    $status = update_cps_bcd($doc_no,$plies,$style,$schedule,$color);
    if($status == 'fail'){
        $response_data['pass'] = 0;
        echo json_encode($response_data);
        exit();
    }else{
        $response_data['pass'] = 1;
        $response_data['m3_updated'] = $status;
        echo json_encode($response_data);
        exit();
    } 
}

$target = 'schedule_club';
$plies = 100;
$doc_no = 524879; 
//Schedule Clubbing Docket Saving
if($target == 'schedule_club'){
    echo "IN";
    foreach($sizes_array as $size)
        $sizes_str .= 'p_'.$size.',';
    $sizes_str = rtrim($sizes_str,',');

    $remarks = "$date^$cut_table^$shift^$f_rec^$f_ret^$damages^$shortages^$returned_to^$plies";
    $insert_query = "INSERT into $bai_pro3.act_cut_status (doc_no,date,section,shift,fab_received,fab_returned, 
                    damages,shortages,remarks,log_date,bundle_loc,leader_name) 
                    values ($doc_no,'$date','$cut_table','$shift','$f_rec','$f_ret','$damages','$shortages','$remarks','$date_time','$bundle_location','$team_leader')
                    ON DUPLICATE KEY 
                    UPDATE date='$date',section='$cut_table',shift='$shift',fab_received=fab_received + $f_rec,fab_returned='$f_ret',damages='$damages',shortages='$shortages',
                    remarks=CONCAT(remarks,'$','$remarks'),
                    log_date='$date_time',bundle_loc='$bundle_location',leader_name='$team_leader' ";

    $update_query = "UPDATE $bai_pro3.plandoc_stat_log set a_plies = a_plies + $plies,act_cut_status='DONE',
                    fabric_status=5 where doc_no = $doc_no ";
    //$insert_result = mysqli_query($link,$insert_query) or exit('Query Error Cut 1');   
    
    mysqli_begin_transaction($link);
    if($insert_result > 0){
        $update_result = mysqli_query($link,$update_query) or exit('Query Error Cut 2');
        if($update_result){
            $response_data['saved'] = 1;
            mysqli_commit($link);
        }else{   
            $response_data['saved'] = 0;
            mysqli_rollback($link);    
        } 
    }else{
        $response_data['saved'] = 0;
    }

    //getting all child dockets
    $child_docs_query = "SELECT doc_no from $bai_pro3.plandoc_stat_log where org_doc_no = '$doc_no' ";
    $child_docs_result = mysqli_query($link,$child_docs_query);
    while($row = mysqli_fetch_array($child_docs_result)){
        $child_docs[] = $row['doc_no'];
    }
    //getting size wise qty of parent docket
    $doc_qty_query = "SELECT $sizes_str,doc_no from $bai_pro3.plandoc_stat_log where doc_no = '$doc_no' ";
    $doc_qty_result = mysqli_query($link,$doc_qty_query);
    while($row = mysqli_fetch_array($doc_qty_result)){
        foreach($sizes_array as $size){
            if($row['p_'.$size] > 0)
                $reporting[$size] = $row['p_'.$size] * $plies;
        }
    }
    
    //for each child docket calculating a_s01,a_s02,..
    foreach($child_docs as $child_doc){
        $size_qty_query = "SELECT $sizes_str from $bai_pro3.plandoc_stat_log where doc_no = '$child_doc' ";
        $sizes_qty_result = mysqli_query($link,$size_qty_query); 
        while($row = mysqli_fetch_array($sizes_qty_result)){
            //getting all the planned sizes for child dockets
            foreach($sizes_array as $size){
                if($row['p_'.$size] > 0)
                    $planned[$child_doc][$size]    = $row['p_'.$size];
            }
        }

        foreach($planned[$child_doc] as $size=>$qty){
            if($reporting[$size] > $qty){
                $new_qty = $qty;
                $reporting[$size] -= $qty;
            }else{
                $new_qty =  $reporting[$size];
                $reporting[$size] = 0;
            }
            if($new_qty > 0){
                $size_update_string .= "a_$size = a_$size + $new_qty,";
                $reported[$child_doc][$size] = $new_qty;
            }
        }
        // var_dump($planned);
        // echo "<br/>";
        //  var_dump($reporting);
        //  echo "<br/>";
        // $size_update_string = rtrim($size_update_string,',');
        //Updating plandoc_stat_log for child dockets
        if(strlen($size_update_string) > 0){
            $update_childs_query = "UPDATE $bai_pro3.plandoc_stat_log set $size_update_string act_cut_status = 'DONE'
                                    where doc_no ='$child_doc' ";
            //$update_childs_result = mysqli_query($link,$update_childs_query) or exit('Child Docket Update Error');
            echo '<br/>'.$update_childs_query; 
        }
        unset($size_update_string);
        unset($planned);
    }
    mysqli_close($link);
    update_cps_bcd_schedule_club($reported);
}


//Style clubbing docket saving
if($target == 'style_club'){

}

function get_me_emb_check_flag($style,$color,$op_code,$link){
    //getting post operation code
    $ops_seq_query = "SELECT id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master 
                    where style='$style' and color = '$color' and operation_code='$op_code'";
    $ops_seq_result = mysqli_query($link,$ops_seq_query) or exit('Query Error 1');
    while($row = mysqli_fetch_array($ops_seq_result)) 
    {
        $ops_seq    = $row['ops_sequence'];
        $seq_id     = $row['id'];
        $ops_order  = $row['operation_order'];
    }
    if(mysqli_num_rows($ops_seq_result) > 0){
        $post_ops_query = "SELECT operation_code from $brandix_bts.tbl_style_ops_master where style='$style' 
                    and color = '$color' and ops_sequence = $ops_seq  
                    AND CAST(operation_order AS CHAR) > '$ops_order' 
                    AND operation_code not in (10,200) ORDER BY operation_order ASC LIMIT 1";
        $post_ops_result = mysqli_query($link,$post_ops_query) or exit('Query Error 2');
        while($row = mysqli_fetch_array($post_ops_result)) 
        {
            $post_ops_code = $row['operation_code'];
        }
    }else{
        // return 'fail';
    }
    //post operation code logic ends

    //if post operation is emb then updating send qty of emb operation in BCD
    $category_qry = "SELECT category FROM $brandix_bts.tbl_orders_ops_ref WHERE operation_code = '$post_ops_code'";
    $category_result = mysqli_query($link,$category_qry) or exit('Query Error 3');
    while($row = mysqli_fetch_array($category_result)) 
    {
        $category_act = $row['category'];
    }
    if(in_array($category_act,$category))
        return 1;
    else
        return 0;
    
    return 0;
    //emb checking ends
}

function update_cps_bcd($doc_no,$plies,$style,$schedule,$color){
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    error_reporting(0);
    $update_counter = 0;
    $category=['cutting','Send PF','Receive PF'];
    $op_code = 15;

    $emb_cut_check_flag = get_me_emb_check_flag($style,$color,$op_code,$link);

    //Updaitng to cps,bcd,moq,m3_transactions
    $doc_details_query = "SELECT * from $bai_pro3.plandoc_stat_log where doc_no = '$doc_no' ";
    $doc_details_result = mysqli_query($link,$doc_details_query) or exit('Query Error 4');
    while($row = mysqli_fetch_array($doc_details_result)){
        $a_plies = $row['a_plies'];
        $p_plies = $row['p_plies'];
        if($a_plies == $p_plies)
            $reported_status = 'F';
        else    
            $reported_status = 'P' ;
        
        //Updating CPS log
        foreach($sizes_array as $size)
        {
            if($row['a_'.$size] > 0)
                $cut_qty[$size] = $row['a_'.$size]*$plies;
        }

        mysqli_begin_transaction($link);
        foreach($cut_qty as $size=>$qty){
            //Updating CPS
            $update_cps_query = "UPDATE $bai_pro3.cps_log set remaining_qty = remaining_qty + $qty
                            where doc_no = '$doc_no' and size_code='$size' and operation_code = $op_code and 
                            reported_status = '$reported_status' ";
            $update_cps_result = mysqli_query($link,$update_cps_query) or exit('Query Error 5');   
            
            //Updating BCD
            $update_bcd_query = "UPDATE $brandix_bts.bundle_creation_data set recevied_qty = recevied_qty + $qty 
                            where docket_number = $doc_no and size_id = '$size' and operation_id = $op_code";
            $update_bcd_result = mysqli_query($link,$update_bcd_query) or exit('Query Error 6');

            if($emb_cut_check_flag)
            {
                $update_bcd_query2 = "UPDATE $brandix_bts.bundle_creation_data set send_qty = send_qty+$qty
                                    WHERE docket_number = '$doc_no' AND size_id = '$size' 
                                    AND operation_id = '$post_ops_code' and reported_status = '$reported_status' ";
                $update_bcd_result2 = mysqli_query($link,$update_bcd_query2) or exit('Query Error 7');
            }   

            if($update_cps_result && $update_bcd_result)
                $counter++;
        }
        if($counter == sizeof($cut_qty) && $counter > 0)
            mysqli_commit($link);
        else{    
            mysqli_rollback($link);
            return 'fail';
        }
        $counter = 0;

        //Maintaining seperate loop for reporting to moq,m3 inorder to prevail the cut qty reporting for cps,bcd
        foreach($cut_qty as $size=>$qty){
            $bundle_id_query = "SELECT bundle_number from $brandix_bts.bundle_creation_data 
                            where docket_number='$doc_no' and size_id='$size' and operation_id = $op_code";
            $bundle_id_result = mysqli_query($link,$bundle_id_query) or exit('Query Error 8');
            if(mysqli_num_rows($bundle_id_result) > 0){
                $row = mysqli_fetch_array($bundle_id_result);
                $bundle_number = $row['bundle_number'];
            }
            $updated = updateM3Transactions($bundle_number,$op_code,$qty);
            if($updated == true)
                $counter++;
        }
        mysqli_close($link);
        //the $counter returns the no:of rows affected to moq,m3_transactions
        if($counter == sizeof($cut_qty))
            return $counter;
        else    
            return 0;     
    }
}

function update_cps_bcd_schedule_club($reported,$style,$schedule,$color){
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    error_reporting(0);
    $op_code = 15;
    $emb_cut_check_flag = get_me_emb_check_flag($style,$color,$op_code,$link);

    foreach($reported as $doc_no=>$size_qty){
        foreach($size_qty as $size => $qty){
            //Updating CPS
            $update_cps_query = "UPDATE $bai_pro3.cps_log set remaining_qty = remaining_qty + $qty
                            where doc_no = '$doc_no' and size_code='$size' and operation_code = $op_code ";
            $update_cps_result = mysqli_query($link,$update_cps_query) or exit('CPS Error CLUB');   
            
            //Updating BCD
            $update_bcd_query = "UPDATE $brandix_bts.bundle_creation_data set recevied_qty = recevied_qty + $qty 
                            where docket_number = $doc_no and size_id = '$size' and operation_id = $op_code";
            $update_bcd_result = mysqli_query($link,$update_bcd_query) or exit('BCD Error CLUB');

            if($emb_cut_check_flag)
            {
                $update_bcd_query2 = "UPDATE $brandix_bts.bundle_creation_data set send_qty = send_qty+$qty
                                    WHERE docket_number = '$doc_no' AND size_id = '$size' 
                                    AND operation_id = '$post_ops_code'";
                $update_bcd_result2 = mysqli_query($link,$update_bcd_query2) or exit('BCD Error CLUB EMB');
            }   
        }
    }

    //Maintaining seperate loop for reporting to moq,m3 inorder to prevail the cut qty reporting for cps,bcd
    foreach($reported as $doc_no=>$size_qty){
        foreach($size_qty as $size => $qty){
            $bundle_id_query = "SELECT bundle_number from $brandix_bts.bundle_creation_data 
                            where docket_number='$doc_no' and size_id='$size' and operation_id = $op_code";
            $bundle_id_result = mysqli_query($link,$bundle_id_query) or exit('Query Error 8');
            if(mysqli_num_rows($bundle_id_result) > 0){
                $row = mysqli_fetch_array($bundle_id_result);
                $bundle_number = $row['bundle_number'];
            }
            $updated = updateM3Transactions($bundle_number,$op_code,$qty);
            if($updated == true)
                $counter++;
        }
    }
}





?>