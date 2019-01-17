

<?php
$SEWIN = 100;
$SEWOUT = 130;

$data = $_POST;

$shades  = $data[''];
$plies   = $data[''];
$a_plies = $data['a_plies'];
$doc_no  = $data['doc_no'];
$schedule = $data['schedule'];

$response_data = [];


//Local Storables
$input_jobs = [];
$tids = [];
$ratios = [];

//Concurrent Verification
$bcd_verify = "SELECT * from $brandix_bts.bundle_creation_data where schedule = '$schedule' and operation_id IN ($SEWIN,$SEWOUT)";
if(mysqli_num_rows(mysqli_query($link,$bcd_verify)) > 0){
    $response_data['exist'] = 'yes';
}else{
    $jobs_query  = "SELECT input_job_no_random,carton_act_qty,size_code,old_size,sref_id,tid
                    from $bai_pro3.packing_summary_input where doc_no = $doc_no";
    $jobs_result = mysqli_query($link,$jobs_query);
    while($row=mysqli_fetch_array($jobs_result)){
        $ij = $row['input_job_no_random'];
        $size = $row['old_size'];
        $input_jobs[$ij][$size] += $row['carton_act_qty'];
        $tids = $row['tid'];
        $sref_id = $row['sref_id'];
    }

    $size_ratios_query = "SELECT * from $bai_pro3.plandoc_stat_log where doc_no = $doc_no";
    $size_ratio_result = mysqli_query($link,$size_ratios_query);
    while($row = mysqli_fetch_array($size_ratio_result)){
        foreach($sizes_array as $size)
        $ratios[$size] = $row['a_'.$size];
    }

    foreach($input_jobs as $ij => $size){

    }

}

return json_encode($response_data);
?>







