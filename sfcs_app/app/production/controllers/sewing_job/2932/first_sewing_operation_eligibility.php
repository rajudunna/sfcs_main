

<?php
// get elgible to report qty for sewing job;
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");

// $sewing_job = '707673191217731';
// getEligibleReport($sewing_job,0);
// error_reporting(1);

function getEligibleReport($sewing_job , $bundle = 0, $isFirstOperation = false) {
    global $link;
    global $brandix_bts;
    global $bai_pro3;

    $plan_cut_bundle_ids = [];
    $cut_bundle_ids = '';
    $style = '';
    $color = '';
    $previous_operations_array = [];
    $previous_operations = '';
    $eligible_size_qtys = [];
    $bundles = [];

    if($bundle) {
        $cut_bundles_query = "Select tid, plan_cut_bundle_id, style, color from $bai_pro3.pac_stat_log_input_job  
            where tid = $bundle";
    } else {
        $cut_bundles_query = "Select tid,plan_cut_bundle_id, style, color  from $bai_pro3.pac_stat_log_input_job  
            where input_job_no_random = '$sewing_job'";
    }
    $cut_bundles_result = mysqli_query($link, $cut_bundles_query) or exit("error 1 - $cut_bundles_query");
    while($row = mysqli_fetch_array($cut_bundles_result)) {
        $bundles[] = $row['tid'];
        $plan_cut_bundle_ids[] = $row['plan_cut_bundle_id'];
        $style = $row['style'];
        $color = $row['color'];
    }
    // $style = 'V01740AA       ';
    // $color = 'PURE BLACK 2ZUO               ';
    $cut_bundle_ids = implode(',', $plan_cut_bundle_ids);

    if (!$isFirstOperation) {
        $first_sewing_operation = getFirstSewingOperation($style, $color);
    }
    $previous_operations_array = getPreviousOperations($style, $color, $first_sewing_operation['operation_code'],
            $first_sewing_operation['operation_order']);
    $previous_operations = implode(',', $previous_operations_array);
    
   //  echo $first_sewing_operation['operation_code']."---".$previous_operations;

    $cut_bundles_query = "Select style, size, color, SUM(act_good_qty - act_used_qty) as remaining_qty
        from $bai_pro3.act_cut_bundle where plan_cut_bundle_id IN ($cut_bundle_ids)
        group by size";
    $cut_bundles_result =  mysqli_query($link, $cut_bundles_query) or exit("error 2 - $cut_bundles_query");
    while($row = mysqli_fetch_array($cut_bundles_result)) {
        $size = $row['size'];
        if($row['remaining_qty'] > 0) {
            $eligible_size_qtys[$size] = $row['remaining_qty'];
        }
    }
    return $eligible_size_qtys;
}


// returns the first sewing operation of the style and color
function getFirstSewingOperation($style, $color) {
    global $link;
    global $brandix_bts;
    $first_sewing_operation = [];
    $first_sewing_operation_query = "Select som.operation_code , som.operation_order
        from $brandix_bts.tbl_style_ops_master som 
        left join $brandix_bts.tbl_orders_ops_ref tor On som.operation_code = tor.operation_code
        where category = 'sewing' and som.style = '$style' and som.color = '$color'
        and display_operations='yes' 
        order by operation_order ASC limit 1";
    $first_sewing_operation_result =  mysqli_query($link, $first_sewing_operation_query) or exit("error 3 - $first_sewing_operation_query");
    while($row = mysqli_fetch_array($first_sewing_operation_result)) {
        $first_sewing_operation['operation_code'] = $row['operation_code'];
        $first_sewing_operation['operation_order'] = $row['operation_order'];
    }
    return $first_sewing_operation;
}

//return the array of previous operations 1 or Many
function getPreviousOperations($style, $color, $current_operation, $current_operation_order) {
    global $link;
    global $brandix_bts;
    $previous_operations = [];
    $previous_operations_query1 = "Select operation_code from $brandix_bts.tbl_style_ops_master
        where style = '$style' and color = '$color' and ops_dependency = $current_operation";
    $previous_operations_result1 = mysqli_query($link, $previous_operations_query1) or exit("error 4 - $previous_operations_query1");
    if(mysqli_num_rows($previous_operations_result1) > 1) {
        while($row = mysqli_fetch_array($previous_operations_result1)) {
            $previous_operations[] = $row['operation_code'];
        }
    } else {
        $previous_operations_query2 = "Select operation_code from $brandix_bts.tbl_style_ops_master
        where style = '$style' and color = '$color' and CAST(operation_order AS CHAR) < '$current_operation_order' 
        order by operation_order DESC limit 1";
        $previous_operations_result2 = mysqli_query($link, $previous_operations_query2) or exit("error 5 - $previous_operations_query2");
        while($row = mysqli_fetch_array($previous_operations_result2)) {
            $previous_operations[] = $row['operation_code'];
        }
    }
    return $previous_operations;
}


// return array of [ actual_cut_bundle_id => remaining_qty]
function getActualCutBundles($sewing_job, $bundle = 0) {
    global $link;
    global $bai_pro3;

    $plan_cut_bundle_ids = [];
    $cut_bundle_qtys = [];

    if($bundle) {
        $plan_cut_bundles_query = "Select tid, plan_cut_bundle_id, style, color from $bai_pro3.pac_stat_log_input_job  
            where tid = $bundle";
    } else {
        $plan_cut_bundles_query = "Select tid,plan_cut_bundle_id, style, color  from $bai_pro3.pac_stat_log_input_job  
            where input_job_no_random = '$sewing_job'";
    }
    $plan_cut_bundle_ids_result = mysqli_query($link, $plan_cut_bundles_query);
    while($row = mysqli_fetch_array($plan_cut_bundle_ids_result) ) {
        $plan_cut_bundle_ids[] = $row['plan_cut_bundle_id'];
    }
    $plan_cut_bundles = implode(',', $plan_cut_bundle_ids_result);

    $act_cut_bundles_query = "Select id, (act_good_qty - act_used_qty) as remaining_qty 
            from $bai_pro3.act_cut_bundle where plan_cut_bundle_id IN ($plan_cut_bundles) 
            group by size order by docket ASC";
    $act_cut_bundles_result = mysqli_query($link, $act_cut_bundles_query) or exit("error 1 - $act_cut_bundles_query");
    while($row = mysqli_fetch_array($act_cut_bundles_result)) {
        $cut_bundle_id = $row['id'];
        $rem_qty = $row['remaining_qty'];
        $cut_bundle_qtys[$cut_bundle_id] = $rem_qty;
    }

    return $cut_bundle_qtys;
}


function updateActCutBundle($cut_bundle_qtys) {
    global $link;
    global $bai_pro3;

    foreach($cut_bundle_qtys as $cut_bundle_id => $used_qty) {
        $update_cut_bundle_query = "Update $bai_pro3.act_cut_bundle ";
    }
}

?>