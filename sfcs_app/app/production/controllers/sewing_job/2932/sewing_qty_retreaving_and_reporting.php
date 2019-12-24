<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app\app\production\controllers\sewing_job\2932\sewing_qty_retreaving_and_reporting.php");
error_reporting(0);
function getElegiblereportFromACB($sewing_job_number, $bundle) {
    if ($bundle) {
       $eleibile_report = getEligibleReport($sewing_job_number, $bundle);
    } else {
        $eleibile_report = getEligibleReport($sewing_job_number);
    }
    return $eleibile_report;
}

function sewingBundleReporting($sewing_job_number = '', $bundle, $qty) {
    $actual_acb_fillable_qty = [];
    $cut_bundle_qtys['ACB1'] = 3;
    $cut_bundle_qtys['ACB2'] = 7;
    $totalelegible_qty = array_sum($cut_bundle_qtys);
    if ($qty > $totalelegible_qty) {
        return false;
    } else {
        $fillable_qty = $qty;
        foreach ($cut_bundle_qtys as $key => $value) {
            if ($fillable_qty > 0) {
                if ($fillable_qty <= $value){
                    $actual_acb_fillable_qty[$key] = $fillable_qty;
                    $fillable_qty = 0 ;
                } else {
                    $actual_acb_fillable_qty[$key] = $value;
                    $fillable_qty = $fillable_qty - $value;
                }
            }
        }
        return $actual_acb_fillable_qty;
    }
}
?>