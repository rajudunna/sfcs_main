
<?php
// get elgible to report qty for sewing job;
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");


// docket - the scanning docket
// size   - the size
// good_qty - scanned good qty
// rej_qty  - scanned rej qty
// operation - current happening operation
// next_immediate_cut_operations - array of immediate next cutting category operations 1 / M
// last_cut_operations - array of the last cutting category operations
// is_last_cut_operation flag indicating if the current happening operation is the last of cutting category
function embDocketScan($docket, $size, $good_qty, $rej_qty, $operation, $next_immediate_cut_operations, $last_cut_operations, $is_last_cut_operation = false) {
    $act_cut_bundles_array = getActCutBundlesForCut($docket, $size);
    fillActualCutBundleGoodQty($act_cut_bundles_array, $good_qty, $operation, $next_immediate_cut_operations, $last_cut_operations, $is_last_cut_operation);
    fillActualCutBundleRejQty($act_cut_bundles_array, $rej_qty, $operation);
    return;
}


function getOperationsInfo($style, $color, $operation) {
    $is_last_cut_operation = false;
    $operations_info = [];
    $operation_order = getOperationOrder($style, $color, $operation);
    $first_sewing_operation_info = getFirstSewingOperation($style, $color);
    $first_sewing_operation = $first_sewing_operation_info;
    if($operation_order) {
        $next_immediate_cut_operations = getNextCuttingOperations($style, $color, $operation, $operation_order, $first_sewing_operation);
        $last_cut_operations = getLastCutOperations($style, $color, $operation, $operation_order, $first_sewing_operation);
        if(in_array($operation, $last_cut_operations)) {
            $is_last_cut_operation = true;
        }
    }
    $operations_info['next_immediate_cut_operations'] = $next_immediate_cut_operations;
    $operations_info['last_cut_operations'] = $last_cut_operations;
    $operations_info['is_last_cut_operation'] = $is_last_cut_operation;
    return $operations_info;
}

// returns the first sewing operation of the style and color
function getFirstSewingOperation($style, $color) {
    global $link;
    global $brandix_bts;
    $sewing_cat = 'sewing';
    $first_sewing_operation = 0;
    $first_sewing_operation_query = "Select som.operation_code , som.operation_order
        from $brandix_bts.tbl_style_ops_master som 
        left join $brandix_bts.tbl_orders_ops_ref tor On som.operation_code = tor.operation_code
        where category = '$sewing_cat' and som.style = '$style' and som.color = '$color'
        and display_operations='yes' 
        order by operation_order ASC limit 1";
    $first_sewing_operation_result =  mysqli_query($link, $first_sewing_operation_query) or exit("error first_sewing_operation_query $first_sewing_operation_query");
    while($row = mysqli_fetch_array($first_sewing_operation_result)) {
        $first_sewing_operation = $row['operation_code'];
    }
    return $first_sewing_operation;
}

function getOperationOrder($style, $color, $operation) {
    global $link;
    global $brandix_bts;
    $operation_order = 0;
    $operation_order_query = "Select operation_code, operation_order from $brandix_bts.tbl_style_ops_master 
        where operation_code = $operation and style = '$style' and color = '$color' ";
    $operation_order_result = mysqli_query($link, $operation_order_query) or exit("error operation_order_query $operation_order_query");
    while($row = mysqli_fetch_array($operation_order_result)){
        $operation_order = $row['operation_order'];
    }
    return $operation_order;
}

function getLastCutOperations($style, $color, $operation_order, $first_sewing_operation) {
    global $link;
    global $brandix_bts;
    $cutting_category = "'Send PF','Receive PF'";
    $last_operations = [];
    $last_cut_operations_query1 = "Select som.operation_code from $brandix_bts.tbl_style_ops_master som 
        left join $brandix_bts.tbl_orders_ops_ref tor On som.operation_code = tor.operation_code
        where category IN ($cutting_category) and style = '$style' and color = '$color'
        and ops_dependency = $first_sewing_operation";
    $last_cut_operations_result1 = mysqli_query($link, $last_cut_operations_query1) or exit("error last_cut_operations_query1 $last_cut_operations_query1");
    if(mysqli_num_rows($last_cut_operations_result1) > 1) {
        while($row = mysqli_fetch_array($last_cut_operations_result1)) {
            $last_operations[] = $row['operation_code'];
        }
    } else {
        $last_cut_operations_query2 = "Select som.operation_code from $brandix_bts.tbl_style_ops_master som
        left join $brandix_bts.tbl_orders_ops_ref tor On som.operation_code = tor.operation_code
        where category IN ($cutting_category) and style = '$style' and color = '$color'
        and operation_order > '$operation_order' order by operation_order DESC limit 1";
        $last_cut_operations_result2 = mysqli_query($link, $last_cut_operations_query2) or exit("error last_cut_operations_query2 $last_cut_operations_query2");
        while($row = mysqli_fetch_array($last_cut_operations_result2)) {
            $last_operations[] = $row['operation_code'];
        }
    }
    return $last_operations;
}

function getNextCuttingOperations($style, $color, $operation, $operation_order, $first_sew_operation = 0) {
    global $link;
    global $brandix_bts;
    $cutting_category = "'Send PF','Receive PF'";
    $next_operations = [];
    $next_cut_operations_query1 =  "Select som.operation_code from $brandix_bts.tbl_style_ops_master som 
        left join $brandix_bts.tbl_orders_ops_ref tor On som.operation_code = tor.operation_code
        where category IN ($cutting_category) and style = '$style' and color = '$color'
        and ops_dependency = $first_sew_operation
        and operation_code = $operation
        order by operation_order ASC";
    $next_cut_operations_result1 = mysqli_query($link, $next_cut_operations_query1) or exit("error next_cut_operations_query1 $next_cut_operations_query1");
    if(mysqli_num_rows($next_cut_operations_result1) > 0) {
        while($row = mysqli_fetch_array($next_cut_operations_result1)) {
            // $next_operations[] = $row['operation_code'];
            $next_operations = [];
        }
    } else {
        $next_cut_operations_query2 =  "Select som.operation_code from $brandix_bts.tbl_style_ops_master som 
        left join $brandix_bts.tbl_orders_ops_ref tor On som.operation_code = tor.operation_code
        where category IN ($cutting_category) and style = '$style' and color = '$color'
        and operation_order > '$operation_order'
        order by operation_order ASC limit 1";
        $next_cut_operations_result2 = mysqli_query($link, $next_cut_operations_query2) or exit("next_cut_operations_query2 $next_cut_operations_query2");
        while($row = mysqli_fetch_array($next_cut_operations_result2)) {
            $next_operations[] = $row['operation_code'];
        }
    }
    return $next_operations;
}


function fillActualCutBundleGoodQty($act_cut_bundles_array, $good_qty, $operation, $next_immediate_cut_operations, $last_cut_operations, $is_last_cut_operation = false)
{
    global $link;
    global $bai_pro3;
    $act_cut_bundles = implode(',', $act_cut_bundles_array);
    $actual_cut_bundle_trans_query = "select id, act_cut_bundle_id, ops_code, original_qty, send_qty - (good_qty + rejection_qty) as rem_qty 
        from $bai_pro3.act_cut_bundle_trn 
        where act_cut_bundle_id IN ($act_cut_bundles) and ops_code = $operation order by id ASC";
    $actual_cut_bundle_trans_result = mysqli_query($link, $actual_cut_bundle_trans_query) or exit("error actual_cut_bundle_trans_query $actual_cut_bundle_trans_query");
    while($row = mysqli_fetch_array($actual_cut_bundle_trans_result)) {
        if($good_qty > 0) {
            $rem_qty = 0;
            $act_cut_bundle_id = $row['act_cut_bundle_id'];
            $rem_bundle_qty = $row['rem_qty'];
            $rem_qty = min($good_qty, $rem_bundle_qty);
            if($rem_qty > 0) {
                updateActualCutBundleTrnGoodQty($act_cut_bundle_id, $operation, $rem_qty);
                foreach($next_immediate_cut_operations as $next_operation) {
                    updateActualCutBundleTrnRecQty($act_cut_bundle_id, $next_operation, $rem_qty);
                }
                if($is_last_cut_operation) {
                    $min_good_qty = getActCutBundleMinGoodQty($act_cut_bundle_id, $last_cut_operations);
                    if ($min_good_qty > 0) {
                        $actual_min_good_qty = 0;
                        $actual_min_good_qty = min($rem_qty, $min_good_qty);
                        updateActualCutBundleGoodQty($act_cut_bundle_id, $actual_min_good_qty);
                    }
                }
                $good_qty -= $rem_qty;
            }
        }
    }
    return $actual_cut_bundle_trans_result;
}

function fillActualCutBundleRejQty($act_cut_bundles_array, $rej_qty, $operation) {
    global $link;
    global $bai_pro3;
    $act_cut_bundles = implode(',', $act_cut_bundles_array);
    $actual_cut_bundle_trans_query = "select id, act_cut_bundle_id, ops_code, send_qty - (good_qty + rejection_qty) as rem_qty 
        from $bai_pro3.act_cut_bundle_trn 
        where act_cut_bundle_id IN ($act_cut_bundles) and ops_code = $operation order by id DESC";
    $actual_cut_bundle_trans_result = mysqli_query($link, $actual_cut_bundle_trans_query) or exit("error actual_cut_bundle_trans_query $actual_cut_bundle_trans_query");
    while($row = mysqli_fetch_array($actual_cut_bundle_trans_result)) {
        if($rej_qty > 0) {
            $rem_qty = 0;
            $act_cut_bundle_id = $row['act_cut_bundle_id'];
            $rem_bundle_qty = $row['rem_qty'];
            $rem_qty = min($rej_qty, $rem_bundle_qty);
            if($rem_qty > 0) {
                updateActualCutBundleTrnRejQty($act_cut_bundle_id, $operation, $rem_qty);
                $rej_qty -= $rem_qty;
            }
        }
    }
    return $actual_cut_bundle_trans_result;
}

// act_cut_bundle_id - string
// last_cut_operations - array of last cut operations before sewing
function getActCutBundleMinGoodQty($act_cut_bundle_id, $last_cut_operations) {
    global $link;
    global $bai_pro3;
    $operations = implode(',', $last_cut_operations);
    $min_good_qty = 0;
    $min_good_qty_query = "Select min(good_qty) as good_qty from $bai_pro3.act_cut_bundle_trn where act_cut_bundle_id = $act_cut_bundle_id 
        and ops_code IN ($operations) ";
    $min_good_qty_result = mysqli_query($link, $min_good_qty_query) or exit(" error min_good_qty_query $min_good_qty_query");
    while($row = mysqli_fetch_array($min_good_qty_result)) {
        $min_good_qty = $row['good_qty'];
    }
    return $min_good_qty;
}


function updateActualCutBundleGoodQty($act_cut_bundle_id, $good_qty) {
    global $link;
    global $bai_pro3;
    $update_act_cut_bundle_query = "Update $bai_pro3.act_cut_bundle set act_good_qty = act_good_qty + $good_qty
        where id = $act_cut_bundle_id";
    mysqli_query($link, $update_act_cut_bundle_query) or exit("error update_act_cut_bundle_query $update_act_cut_bundle_query");
    return;
}

function updateActualCutBundleTrnGoodQty($act_cut_bundle_id, $operation, $good_qty) {
    global $link;
    global $bai_pro3;
    $act_cut_bundle_trn_update_query = "Update $bai_pro3.act_cut_bundle_trn set good_qty = good_qty + $good_qty
        where act_cut_bundle_id = $act_cut_bundle_id and ops_code = $operation";
    mysqli_query($link,$act_cut_bundle_trn_update_query) or exit("error act_cut_bundle_trn_update_query $act_cut_bundle_trn_update_query");
    return;
}


function updateActualCutBundleTrnRecQty($act_cut_bundle_id, $operation,  $rec_qty) {
    global $link;
    global $bai_pro3;
    $act_cut_bundle_trn_update_query = "Update $bai_pro3.act_cut_bundle_trn set send_qty = send_qty + $rec_qty
        where act_cut_bundle_id = $act_cut_bundle_id and ops_code = $operation";
    mysqli_query($link,$act_cut_bundle_trn_update_query) or exit("error act_cut_bundle_trn_update_query $act_cut_bundle_trn_update_query");
    return;
}

function updateActualCutBundleTrnRejQty($act_cut_bundle_id, $operation, $rej_qty) {
    global $link;
    global $bai_pro3;
    $act_cut_bundle_update_query = "Update $bai_pro3.act_cut_bundle_trn set rejection_qty = rejection_qty + $rej_qty
        where act_cut_bundle_id = $act_cut_bundle_id and ops_code = $operation";
    mysqli_query($link,$act_cut_bundle_update_query) or exit("error act_cut_bundle_update_query $act_cut_bundle_update_query");
    return;
}

// returns array of plan_cut_bundles for the sewing job or sewing bundle
function getActCutBundlesForCut($doc_no, $size) {
    global $link;
    global $bai_pro3;
    $act_cut_bundle_ids = [];
    $act_cut_bundles_query = "Select id from $bai_pro3.act_cut_bundle where docket = $doc_no and size = '$size' ";
    $act_cut_bundle_ids_result = mysqli_query($link, $act_cut_bundles_query) or exit("error act_cut_bundles_query $act_cut_bundles_query");
    while($row = mysqli_fetch_array($act_cut_bundle_ids_result) ) {
        $act_cut_bundle_ids[] = $row['id'];
    }
    return $act_cut_bundle_ids;
}


?>