<?php
/*
	=========== Create By Chandu =============
	Created at : 11-10-2018
	Updated at : 11-10-2018
	Input : data from bai_pro3.mo_details with shipment status 0.
	Output : populate the data in m3_inputs.shipment_details_original.
*/
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
set_time_limit(6000000);
$qry_get_soap_data = "SELECT *,group_concat(id) as ids,sum(mo_quantity) as mo_tot_qty FROM $bai_pro3.`mo_details` WHERE shipment_master_status=0 group by style,SCHEDULE,color,size";
$res_get_soap_data = mysqli_query($link, $qry_get_soap_data) or exit("Sql Error select bai_pro3.mo_details".mysqli_error($GLOBALS["___mysqli_ston"]));
$i = 0;

while($result_data = mysqli_fetch_array($res_get_soap_data)){

    $shipment_plan_qry = "INSERT INTO `bai_pro3`.`shipment_plan` (
        `style_no`,
        `schedule_no`,
        `color`,
        `order_qty`,
        `exfact_date`,
        `CPO`,
        `buyer_div`,
        `size_code`,
        `packing_method`,
        `destination`,
        `zfeature`,
        `Customer_Order_No`,
      )
      VALUES
        (
            '".$result_data['style']."',
            '".$result_data['schedule']."',
            '".$result_data['color']."',
            '".$result_data['mo_tot_qty']."',
            '".date('Ymd',strtotime($result_data['coplandeldate']))."',
            '".$result_data['cpo']."',
            '".$result_data['cpo']."',
            '".$result_data['size']."',
            '".$result_data['packing_method']."',
            '".$result_data['destination']."',
            '".$result_data['zfeature']."',
            '".$result_data['referenceorder']."'
        )";

    $res_shipment_details = mysqli_query($link, $shipment_plan_qry) or exit("Sql Error Insert Shipment Details".mysqli_error($GLOBALS["___mysqli_ston"]));


    if($res_shipment_details){
        $up_qry = "UPDATE $bai_pro3.mo_details SET shipment_master_status=1 WHERE id in (".$result_data['ids'].")";
        $up_res = mysqli_query($link, $up_qry) or exit("Error : update query".mysqli_error($GLOBALS["___mysqli_ston"]));
        $i++;
    }
}
echo $i." Records Updated..";
?>