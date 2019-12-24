<?php
// get elgible to report qty for sewing job;
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
include("first_sewing_operation_eligibility.php");
error_reporting(1);

/*
    $--SizeQtys : 
    [ size(string) => qty(int)]; // size wise qtys of the bundle or sewing job need to be pushed in
*/

scanActualJobOrBundle('707673191217731',0, 100, ['32D' => 40], null ,null, 'test');

function scanActualJobOrBundle($sewing_job, $operation, $goodSizeQtys,
        $revSizeQtys, $rejSizeQtys, $scan_user) {
    global $link;
    global $bai_pro3;
    global $brandix_bts;

    $bundle_size_array = [];   // bundle_number => size
    $bundle_qty_array  =  [];  // bundle_number => bundle_qty
    $plan_cut_bundle_ids = []; // size => plan_cut_bundle_ids
    $bundle_cut_bundle_array = []; // bundle_number => plan_cut_bundle_id

    // if($bundle) {
    //     $bundles_query = "Select tid, size_code, plan_cut_bundle_id, style, color,
    //         carton_act_qty from $bai_pro3.pac_stat_log_input_job where tid = $bundle";
    // } else {
    //     $bundles_query = "Select tid, size_code, plan_cut_bundle_id, style, color, 
    //         carton_act_qty from $bai_pro3.pac_stat_log_input_job  
    //         where input_job_no_random = '$sewing_job'";
    // }
    $bundles_query = "select id, size, style, color, qty, plan_cut_bundle_id
        from $bai_pro3.plan_log_bundle_trn
        where sewing_job_no = '$sewing_job' and ops_code = $operation";
    $bundles_result = mysqli_query($link, $bundles_query) or exit("error 1 - $bundles_query");
    echo $bundles_query;
    while($row = mysqli_fetch_array($bundles_result)) {
        $tid = $row['id'];
        $size = $row['size'];
        $qty = $row['qty'];
        $bundle_qty_array[$tid] = $qty;
        $bundle_size_array[$tid] = $size;
        $bundle_cut_bundle_array[$tid] = $row['plan_cut_bundle_id'];
        $plan_cut_bundle_ids[$size][] = $row['plan_cut_bundle_id'];
        $style = $row['style'];
        $color = $row['color'];
    }
    // $style = 'V01740AA       ';
    // $color = 'PURE BLACK 2ZUO               ';

    $first_sewing_operation = getFirstSewingOperation($style, $color);
    $previous_operations_array = getPreviousOperations($style, $color, $first_sewing_operation['operation_code'],
            $first_sewing_operation['operation_order']);
    $previous_operations = implode(',', $previous_operations_array);

    foreach($bundle_size_array as $bundle_number => $size) {
        $cut_bundle_ids = $bundle_cut_bundle_array[$bundle_number];
        if( $goodSizeQtys[$size] > 0) {
            do {
                $reported_size_qty = $goodSizeQtys[$size];
                $bundle_qty = $bundle_qty_array[$bundle_number];
                $good_qty = min($reported_size_qty , $bundle_qty);
                while($good_qty > 0) {
                    // remainig qtys of previous operation in act_cut_bundle_trn
                    $cut_bundles_query = "Select acbt.act_cut_bundle_id, size, Min(remaining_qty) as remaining_qty
                        from $bai_pro3.act_cut_bundle acb
                        left join $bai_pro3.act_cut_bundle_trn acbt ON acbt.act_cut_bundle_id = acb.id
                        where acb.plan_cut_bundle_id IN (".$cut_bundle_ids.") 
                        and ops_code in ($previous_operations)";
                    $cut_bundles_result =  mysqli_query($link, $cut_bundles_query) or exit("error 2 - $cut_bundles_query");
                    while($row = mysqli_fetch_array($cut_bundles_result)) {
                        $remainig_qty = $row['remaining_qty'];
                        $cut_bundle_id = $row['act_cut_bundle_id'];
                        if ($good_qty >= $remainig_qty) {
                            $goodQty -= $remainig_qty;
                            $bundle_qty -= $remainig_qty;
                            $reported_size_qty-= $remainig_qty;
                            $goodSizeQtys[$size] -= $remainig_qty;

                            updateActualLogBundleTrans($bundle_number, $cut_bundle_id, $operation, $remainig_qty, $scan_user);
                            reduceCutBundleRemainingQty($id, $remainig_qty);
                        } else {
                            $bundle_qty -= $goodQty;
                            $reported_size_qty-= $goodQty;
                            $goodSizeQtys[$size] -= $goodQty;

                            updateActualLogBundleTrans($bundle_number, $cut_bundle_id, $operation, $goodQty, $scan_user);
                            reduceCutBundleRemainingQty($id, $goodQty);
                            $goodQty = 0;
                        }
                    }
                }
            } while($reported_size_qty > 0 && $bundle_qty > 0);
        }
    }
}


function updateActualLogBundleTrans($bundle_id, $cut_bundle_id, $op_code, $rec_qty, $tran_user) {
    global $link;
    global $bai_pro3;
    $actual_log_bundle_trans_query = "Insert into $bai_pro3.act_log_bundle_trn
        (plan_log_bundle_trn_id, act_log_bundle_id, ops_code, rec_qty, tran_user)
        VALUES 
        ($bundle_id, $cut_bundle_id, $op_code, $rec_qty, $tran_user);";
    mysqli_query($link, $actual_log_bundle_trans_query) 
        or exit("Error Inserting act_log_bundle_trn $actual_log_bundle_trans_query");
    return;
}

function reduceCutBundleRemainingQty($id, $reduced_qty) {
    global $link;
    global $bai_pro3;
    $reduce_remaining_qty_query = "update $bai_pro3.act_cut_bundle_trn set 
        remaining_qty = remaining_qty - $reduced_qty where ";
    mysqli_query($link, $reduce_remaining_qty_query)
        or exit("Error Updating act_cut_bundle_trn $reduce_remaining_qty_query");
    return;
}


function updateActualCutBundle($cut_bundle_id, $rec_qty) {
    global $link;
    global $bai_pro3;
    $actual_cut_bundle_query = "Update $bai_pro3.act_cut_bundle set act_used_qty = act_used_qty + $rec_qty where id = $cut_bundle_id ";
    msyqli_query($link, $actual_cut_bundle_query) or exit("error 1 - $actual_cut_bundle_query");
    return;
}

function insertActualBundleLogTran($bundle_id, $cut_bundle_id, $rec_qty, $scan_user) {
    global $link;
    global $bai_pro3;
    $actual_log_bundle_insert_query = "Insert into $bai_pro3.act_log_bundle_trn (plan_log_bundle_id, act_cut_bundle_id, rec_qty, tran_user) 
        values ($bundle_id, $cut_bundle_id, $rec_qty, $scan_user)";
    mysqli_query($link, $actual_log_bundle_insert_query) or exit("error 1 - $actual_log_bundle_insert_query");
    return;
}

?>