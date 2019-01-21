

<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
$SEWIN = 100;
$SEWOUT = 130;
$CAT = 'sewing';

$data = $_POST;

$ashades  = $data['shades'];
$shades_plies   = $data['shades_plies'];
foreach($ashades as $key => $shade)
    $shades[$shade] = (int)$shades_plies[$key];
$a_plies = $data['a_plies'];
$doc_no  = $data['doc_no'];
$schedule = $data['schedule'];

$response_data = [];

var_dump($shades);
//Local Storables
$input_jobs = [];
$tids   = [];
$ratios = [];
$sizes  = [];
//Concurrent Verification
$bcd_verify = "SELECT * from $brandix_bts.bundle_creation_data where schedule = '$schedule' and operation_id IN ($SEWIN,$SEWOUT)";
if(mysqli_num_rows(mysqli_query($link,$bcd_verify)) > 0){
    $response_data['exist'] = 'yes';
// }else{
    $jobs_query  = "SELECT input_job_no,input_job_no_random,carton_act_qty,packing_mode,size_code,old_size,sref_id,tid,destination
                    from $bai_pro3.packing_summary_input where doc_no = $doc_no";
    $jobs_result = mysqli_query($link,$jobs_query) or exit('Error');
    while($row=mysqli_fetch_array($jobs_result)){
        $ij = $row['input_job_no_random'];
        $size = $row['old_size'];
        $input_jobs[$size][$ij] += $row['carton_act_qty'];
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
    var_dump($ratios);
    var_dump($input_jobs);
    var_dump($sizes);
    $shades1 = $shades;
    $to_insert_jobs = [];
    //Loop for each size 
    foreach($sizes as $size){
        $shades1 = $shades;//resetting the shades to original for every
        //loop for each job
    next_job : foreach($input_jobs[$size] as $ij => $qty){
            //loop for each ratio
            for($i=0 ; $i<$ratios[$size] ; $i++){
                if($qty == 0)
                    goto next_job;
                //now looping for each shade
    next_shade_group : foreach($shades1 as $key => $shade){
                    if($qty > 0){
                        if($qty >= $shade){
                            $to_insert_jobs[$key][$ij][$size][] = $shade;
                            $testing_purpose_splitted[$key][$ij][$size][] = $shade;
                            $qty -= $shade;
                            unset($shades1[$key]);
                        }else{
                            $to_insert_jobs[$key][$ij][$size][] = $qty;
                            $testing_purpose_splitted[$key][$ij][$size][] = $qty;
                            $qty = 0;
                            $shade -= $qty;
                            $shades1[$key] = $shade;
                            unset($input_jobs[$size][$ij]);
                        }
                    }else{
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
//error_reporting(0);
var_dump($testing_purpose_splitted);
// var_dump($to_insert_jobs);
foreach($to_insert_jobs as $shade => $ij){
        foreach($ij as $ijob => $size_qty){
            foreach($size_qty as $size => $qtys){
                foreach($qtys as $qty){
                    //echo "$ijob - $size - $shade - $qty<br/>";
                    $insert_query = "INSERT into $bai_pro3.pac_stat_log_input_job (doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,doc_type,type_of_sewing,sref_id,shade_group) 
                    values 
                    ($doc_no,'$size_map[$size]',$qty,'$job_map[$ijob]','$ijob','$destination','$packing_mode','$size','N',1,$sref_id,'$shade')";
                    //mysqli_query($link,$insert_query);
                    //echo $insert_query.'<br/>';
                }
            }
        }
}

//Deleting from pac_stat_log_input_job 
$delete_pacs = "DELETE from $bai_pro3.pac_stat_log_input_job where tid IN (".implode(',',$tids).")";
// mysqli_query($link,$delete_pacs);

//Deleting from moq
//sewing cat opcodes
$sewing_op_codes = "SELECT group_concat(operation_code) as op_codes FROM $brandix_bts.tbl_orders_ops_ref WHERE category = '$CAT'";
$row = mysqli_fetch_array(mysqli_query($link,$sewing_op_codes));
{
    $op_codes = $row['op_codes'];
}
$delete_moq = "DELETE from $bai_pro3.mo_operation_quantites where ref_no IN (".implode(',',$tids).") 
            AND operation_id IN ($op_codes)"; 
// mysqli_query($link,$delete_moq);
echo $delete_pacs.'<br/>';
echo $delete_moq;
return json_encode($response_data);
?>







