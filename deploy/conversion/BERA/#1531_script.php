<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/m3Updations.php');
$details_query_bcd = "SELECT bundle_number,original_qty,SUM(recevied_qty),input_job_no_random_ref FROM brandix_bts.bundle_creation_data_temp  WHERE bundle_number IN (
SELECT DISTINCT(bundle_number) FROM brandix_bts.bundle_creation_data_temp WHERE date_time > '2019-02-11 16:00:00' AND recevied_qty < 0 AND operation_id = 100
) AND operation_id = 100
GROUP BY bundle_number";
$details_result_bcd = mysqli_query($link,$details_query_bcd) or exit("Problem in getting details from the BCD");
echo "running".'</br>';
while($row_bcd = mysqli_fetch_array($details_result_bcd))
{
    $bundle_no = $row_bcd['bundle_number'];
    $reversalval = $row_bcd['original_qty'];
    $op_code = 100;
    updateM3TransactionsReversal($bundle_no,$reversalval,$op_code);

}
echo "success".'</br>';
?>