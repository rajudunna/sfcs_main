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
$qry_get_soap_data = "SELECT *,group_concat(id) as ids,sum(mo_quantity) as mo_qty FROM $bai_pro3.`mo_details` WHERE shipment_master_status=0 group by style,SCHEDULE,color,size";
$res_get_soap_data = mysqli_query($link, $qry_get_soap_data) or exit("Sql Error select bai_pro3.mo_details".mysqli_error($GLOBALS["___mysqli_ston"]));
$i = 0;

while($result_data = mysqli_fetch_array($res_get_soap_data)){
    $get_data_m3inp_data = "select * from $m3_inputs.mo_details WHERE MONUMBER=$result_data['mo_no'] AND STYLE='".$result_data['style']."' AND SCHEDULE='".$result_data['schedule']."' AND SIZENAME='".$result_data['size']."' AND COLOURDESC='".$result_data['color']."'";
    $res_data_m3inp_data = mysqli_query($link, $get_data_m3inp_data) or exit("Sql Error select m3_inputs.mo_details".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res_new_data = mysqli_fetch_array($res_data_m3inp_data);

    $ins_shipment_details = "INSERT INTO `m3_inputs`.`shipment_plan_original`(`Customer_Order_No`, `CO_Line_Status`, `Ex_Factory`, `Order_Qty`, `Mode`, `Destination`, `Packing_Method`, `FOB_Price_per_piece`, `MPO`, `CPO`, `DBFDST`, `Size`, `HMTY15`, `ZFeature`, `MMBUAR`, `Style_No`, `Product`, `Buyer_Division`, `Buyer`, `CM_Value`, `Schedule_No`, `Colour`, `Alloc_Qty`, `Dsptched_Qty`, `BTS_vs_Ord_Qty`, `BTS_vs_FG_Qty`, `time_stamp`) VALUES ('".$res_new_data['REFERENCEORDER']."','','".date('Ymd',strtotime($res_new_data['STARTDATE']))."','".$result_data['mo_qty']."','','".$result_data['destination']."','".$result_data['packing_method']."','','','".$result_data['cpo']."','','".$result_data['size']."','','".$result_data['zfeature']."','','".$result_data['style']."','','".$result_data['buyer_id']."','','','".$result_data['schedule']."','".$result_data['color']."','','','','',now())";
    $res_shipment_details = mysqli_query($link, $ins_shipment_details) or exit("Sql Error Insert Shipment Details".mysqli_error($GLOBALS["___mysqli_ston"]));
    if($res_shipment_details){
        $up_qry = "UPDATE $bai_pro3.mo_details SET shipment_master_status=1 WHERE id in (".$result_data['ids'].")";
        $up_res = mysqli_query($link, $up_qry) or exit("Error : update query".mysqli_error($GLOBALS["___mysqli_ston"]));
        $i++;
    }
}
echo $i." Records Updated..";
?>