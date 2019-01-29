

<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
//turning the notices off
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$SEWIN = 100;
$SEWOUT = 130;
$CAT = 'sewing';
$QUIT_COUNTER = 1000;

$data = $_POST;

$ashades  = $data['shades'];
$shades_plies   = $data['shades_plies'];
foreach($ashades as $key => $shade)
    $shades[$shade] = (int)$shades_plies[$key];
$a_plies = $data['a_plies'];
$doc_no  = $data['doc_no'];
$schedule = $data['schedule'];

$response_data = [];


// $response_data['save'] = 'success';
// echo json_encode($response_data);
// exit();

// var_dump($shades);
//Local Storables
//$input_jobs = array([]);
$tids   = [];
$ratios = [];
$sizes  = [];
$inserted_tids = [];
//Concurrent Verification
$bcd_verify = "SELECT * from $brandix_bts.bundle_creation_data where docket_number = '$doc_no' 
            and operation_id IN ($SEWIN,$SEWOUT)";
if(mysqli_num_rows(mysqli_query($link,$bcd_verify)) > 0){
    $response_data['exist'] = 'yes';
    echo json_encode($response_data);
    exit();
}else{
    $jobs_query  = "SELECT pac_seq_no,order_style_no,order_col_des,input_job_no,input_job_no_random,carton_act_qty,packing_mode,
                    size_code,old_size,sref_id,tid,destination,type_of_sewing 
                    from $bai_pro3.packing_summary_input where doc_no = $doc_no";
    $jobs_result = mysqli_query($link,$jobs_query) or exit('Error');
    while($row=mysqli_fetch_array($jobs_result)){
        $style = $row['order_style_no'];  
        $color = $row['order_col_des'];
        $ij = $row['input_job_no_random'];
        $size = $row['old_size'];
        $pac_seq[$ij] = $row['pac_seq_no'];
        $input_jobs[$size][$ij] += $row['carton_act_qty'];
        $type_of_sewing[$ij] = $row['type_of_sewing']; // for figuring out the excess job
        // if($row['type_of_sewing'] == '1')
        //     $job_wise_qty[$size][$ij] += $row['carton_act_qty']; 
        $tids[] = $row['tid']; //need to delete these from pac_stat_log_input_job
        $sref_id = $row['sref_id'];
        $size_map[$size] = $row['size_code'];
        $job_map[$ij] = $row['input_job_no'];
        $destination  = $row['destination'];
        $packing_mode = $row['packing_mode'];
    }
    
    $size_ratios_query = "SELECT * from $bai_pro3.plandoc_stat_log where doc_no = $doc_no";
    $size_ratio_result = mysqli_query($link,$size_ratios_query);
    while($row = mysqli_fetch_array($size_ratio_result)){
        foreach($sizes_array as $size){
            if($row['a_'.$size] > 0){
                $ratios[$size] = $row['a_'.$size];
                $sizes[$size] = $size;
            }
        }
    }
    $shades1 = $shades;
    $to_insert_jobs = [];
    //Loop for each size 
    $counter_1 = 0;
    foreach($sizes as $size){
        $shades1 = $shades;//resetting the shades to original for every size
        //loop for each job
    next_job : foreach($input_jobs[$size] as $ij => $qty){
            //loop for each ratio
            for($i=0 ; $i<$ratios[$size] ; $i++){
                if($qty == 0){
                    unset($input_jobs[$size][$ij]);
                    goto next_job;
                }
                //now looping for each shade
    next_shade_group : foreach($shades1 as $key => $shade){
                    $counter_1++;
                    if($qty > 0){
                        if($qty >= $shade){
                            $to_insert_jobs[$key][$ij][$size][] = $shade;
                            $testing_purpose_splitted[$key][$ij][$size][] = $shade;
                            $qty -= $shade;
                            if($counter_1 > $QUIT_COUNTER)//FORCE QUIT if loops more than 1000 iterations
                                exit('Infinte Loop Stuck');
                            unset($shades1[$key]);
                        }else{
                            $to_insert_jobs[$key][$ij][$size][] = $qty;
                            $testing_purpose_splitted[$key][$ij][$size][] = $qty;
                            $shade -= $qty;
                            $qty = 0;
                            $shades1[$key] = $shade;
                            if($counter_1 > $QUIT_COUNTER)//FORCE QUIT if loops more than 1000 iterations
                                exit('Infinte Loop Stuck');
                            unset($input_jobs[$size][$ij]);
                        }
                        if($shade <= 0)
                            unset($shades1[$key]);
                    }else{
                        if($qty == 0)
                            unset($input_jobs[$size][$ij]);
                        goto next_job;
                    }
                }
                if(sizeof($shades1) == 0){
                    $shades1 = $shades;
                    goto next_shade_group;
                }      
            }
        }
    }
}
//inserting to shade splitting table
$insert_query = "INSERT into $bai_pro3.shade_split(date_time,username,doc_no,schedule,shades,plies) 
                values('".date('y-m-d H:i:s')."','$username',$doc_no,'$schedule','".implode($ashades,',')."','".implode($shades_plies,",")."')";
mysqli_query($link,$insert_query) or exit('Problem in inserting into shade split');   

//inserting deleted jobs into the deleted job track
$jobs_query1 = "SELECT * from $bai_pro3.pac_stat_log_input_job where tid IN (".implode(',',$tids).")";
$jobs_result1 = mysqli_query($link,$jobs_query1) or exit('Problem in getting jobs');
while($row = mysqli_fetch_array($jobs_result1)){
    $i_ij  = $row['input_job_no_random'];
    $i_qty = $row['carton_act_qty'];
    $i_size= $row['old_size'];
    $i_sew = $row['type_of_sewing'];
    $i_tid = $row['tid'];
    $insert_track_query = "INSERT into 
            $bai_pro3.deleted_sewing_jobs(date_time,schedule,input_job_no_random,size_id,qty,tid,type_of_sewing) 
            VALUES ('".date('Y-m-d H:i:s')."',$schedule,'$i_ij','$i_size',$i_qty,$i_tid,$i_sew)";
    mysqli_query($link,$insert_track_query) or exit('Problem in inserting the deleted jobs');
}

//echo $insert_query;                
// var_dump($to_insert_jobs);
foreach($to_insert_jobs as $shade => $ij){
    foreach($ij as $ijob => $size_qty){
        foreach($size_qty as $size => $qtys){
            foreach($qtys as $qty){
                $type_of_sew = $type_of_sewing[$ijob];    
                $seq_no = $pac_seq[$ijob] != '' ? $pac_seq[$ijob] : 0;
                $insert_query = "INSERT into $bai_pro3.pac_stat_log_input_job (doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,doc_type,pac_seq_no,type_of_sewing,sref_id,shade_group) 
                values 
                ($doc_no,'$size_map[$size]',$qty,'$job_map[$ijob]','$ijob','$destination','$packing_mode','$size','N',$seq_no,$type_of_sew,$sref_id,'$shade')";
                mysqli_query($link,$insert_query) or exit("Problem while inserting new jobs job - $ijob - $size_map[$size] - $size - $qty - $type_of_sew");
                $inserted_tids[] = mysqli_insert_id($link);
                //echo "$ijob - $size_map[$size] - $size - $qty - $type_of_sew <br/>";
            }
        }
    }
}
array_unique($inserted_tids);
//Deleting from pac_stat_log_input_job 
$delete_pacs = "DELETE from $bai_pro3.pac_stat_log_input_job where tid IN (".implode(',',$tids).")";
mysqli_query($link,$delete_pacs);

//Deleting from moq
//sewing cat opcodes
$sewing_op_codes = "SELECT group_concat(operation_code) as op_codes FROM $brandix_bts.tbl_orders_ops_ref WHERE category = '$CAT'";
$row = mysqli_fetch_array(mysqli_query($link,$sewing_op_codes));
{
    $op_codes = $row['op_codes'];
}
$delete_moq = "DELETE from $bai_pro3.mo_operation_quantites where ref_no IN (".implode(',',$tids).") 
            AND op_code IN ($op_codes)";             
mysqli_query($link,$delete_moq) or exit('Deleting from MOQ Error');

//Insert to moq Logic
//getting mo_no,size,qtys ids
$mo_details_query = "SELECT mo_no,old_size,carton_act_qty
            from $bai_pro3.mo_operation_quantites moq
            left join $bai_pro3.pac_stat_log_input_job psl ON psl.tid = moq.ref_no
            where tid IN (".implode(',',$tids).")
            and op_code = $SEWIN";           
$mo_details_result = mysqli_query($link,$mo_details_query) or exit('Getting MO Details Error');             
while($row=mysqli_fetch_array($mo_details_result)){
    $mo_no = $row['mo_no'];
    $size = $row['old_size'];
    $mo_details[$size][$mo_no] += $row['carton_act_qty'];
}            

//op_codes related to that style and color
$sewing_op_codes = "SELECT operation_code as op_code FROM $brandix_bts.tbl_style_ops_master 
                    WHERE style='$style' and color = '$color' and operation_code IN ($op_codes)";
$sewing_op_codes_result = mysqli_query($link,$sewing_op_codes) or exit('Operations Error');
while($row = mysqli_fetch_array($sewing_op_codes_result))
{
    $op_codes_style[] = $row['op_code'];
}

$barcode_seq = 0;
$barcode_seq = sizeof($inserted_tids);
foreach($inserted_tids as $id){
    $update_query = "Update $bai_pro3.pac_stat_log_input_job set barcode_sequence = $barcode_seq where tid=$id";
    mysqli_query($link,$update_query) or exit('Unable to update');
    $barcode_seq--;
}
       

$inserted_rescords_query = "SELECT tid,carton_act_qty from $bai_pro3.pac_stat_log_input_job where tid In (".implode($inserted_tids,',').")";
$inserted_rescords_result = mysqli_query($link,$inserted_rescords_query) or exit('Problem in getting new inserted jobs');             
while($row=mysqli_fetch_array($inserted_rescords_result)){
    $ref_id = $row['tid'];
    $qty    = $row['carton_act_qty'];
    foreach($op_codes_style as $op_code)
        insert_into_moq($ref_id,$op_code,$qty);
}

$response_data['save'] = 'success';
echo json_encode($response_data);
exit();


function insert_into_moq($ref_id,$op_code,$qty){
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');

    //getting style,color,schedule,size
    $order_details = "Select order_style_no,order_col_des,order_del_no,size_code from $bai_pro3.packing_summary_input 
                      where tid = $ref_id";                 
    $order_result = mysqli_query($link,$order_details) or exit('Unable to get info from BCD');
    while($row = mysqli_fetch_array($order_result)){
        $style = $row['order_style_no'];
        $schedule = $row['order_del_no'];
        $color = $row['order_col_des'];
        $size  = $row['size_code'];
    }

    $mo_details = "SELECT * FROM $bai_pro3.mo_details WHERE TRIM(size)='$size' 
                   and TRIM(style)='$style' and TRIM(schedule)=$schedule and TRIM(color)='$color' order by mo_no";
    $mos_result = mysqli_query($link,$mo_details);		
    while($row = mysqli_fetch_array($mos_result)){
        $mos[$row['mo_no']] = $row['mo_quantity'];
    }	   
    //returning back if has no mo's at all
    if(sizeof($mos) == 0)
        return false;

    //getting the operations and op_codes  for that mo if exists
    foreach($mos as $mo=>$mo_qty){
        $mo_op_query ="SELECT OperationNumber,OperationDescription FROM $bai_pro3.schedule_oprations_master 
                       WHERE OperationNumber=$op_code and MONumber=$mo limit 1";             
        $mo_ops_result = mysqli_query($link,$mo_op_query) or exit('No Operations Exists for MO '.$mo);
        while($row = mysqli_fetch_array($mo_ops_result)){
            $op_desc[$mo] = $row['OperationDescription'];
            $op_codes[$mo] = $row['OperationNumber'];
        }	
    }
    
    if(sizeof($mos) == 1){
        foreach($mos as $mo=>$mo_qty){			   
            $insert_query = "Insert into $bai_pro3.mo_operation_quantites 
                            (`date_time`, `mo_no`,`ref_no`,`bundle_quantity`, `op_code`, `op_desc`)
                            values ('".date('Y-m-d H:i:s')."','$mo','$ref_id','$qty','$op_code','$op_desc[$mo]')";                
            mysqli_query($link,$insert_query) or exit("Error 0 In Inserting to MO Qtys for mo : ".$mo);	
            $qty = 0;			
        }
    }else{	
        foreach($mos as $mo=>$mo_qty){
            $last_mo = $mo;
            if($qty <= 0)
                continue;

            $filled_qty = 0;
            //getting already filled quantities 
            $filled_qty_query = "Select SUM(bundle_quantity) as filled from $bai_pro3.mo_operation_quantites where 
                                 mo_no = $mo and op_code = $op_code";
            $filled_qty_result = mysqli_query($link,$filled_qty_query);	
            while($row = mysqli_fetch_array($filled_qty_result)){
                $filled_qty = $row['filled'];
            }		
            $available = $mo_qty - $filled_qty;	 

            if($available <= 0)
                continue;
            if($qty > $available && $available > 0){
                $qty = $qty-$available;
                $insert_query = "Insert into $bai_pro3.mo_operation_quantites 
                                (`date_time`, `mo_no`,`ref_no`,`bundle_quantity`, `op_code`, `op_desc`)
                                values 
                                ('".date('Y-m-d H:i:s')."','$mo','$ref_id','$available','$op_code','$op_desc[$mo]')"; 
                mysqli_query($link,$insert_query) or exit("Error 1 In Inserting to MO Qtys for mo : ".$mo);	
            }else{
                $insert_query = "Insert into $bai_pro3.mo_operation_quantites 
                                (`date_time`, `mo_no`,`ref_no`,`bundle_quantity`, `op_code`, `op_desc`)
                                values 
                                ('".date('Y-m-d H:i:s')."','$mo','$ref_id','$qty','$op_code','$op_desc[$mo]')"; 
                mysqli_query($link,$insert_query) or exit("Error 2 In Inserting to MO Qtys for mo : ".$mo);
                $qty = 0;
            }
        }
        //Updating all excess to last mo 
        if($qty > 0){
            $update_query = "Update $bai_pro3.mo_operation_quantites set bundle_quantity = bundle_quantity + $qty 
                             where mo_no = $last_mo and ref_no = $ref_id and op_code = $op_code";
            mysqli_query($link,$update_query) or exit("Error 3 In Updating excess qty to MO Qtys for mo : ".$mo);
        }
    }

    return true;
}
?>









