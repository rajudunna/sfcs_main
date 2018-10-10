<?php
/*
	=========== Create By Chandu =============
	Created at : 09-10-2018
	Updated at : 09-10-2018
	Input : data from bai_pro3.mo_details with status 0.
	Output : populate the data in m3_inputs.order_details_original.
*/
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
set_time_limit(6000000);
$basic_auth = base64_encode($api_username.':'.$api_password);

$qry_get_soap_data = "SELECT * FROM $bai_pro3.`mo_details` WHERE material_master_status=0";
$res_get_soap_data = mysqli_query($link, $qry_get_soap_data) or exit("Sql Error select bai_pro3.mo_details".mysqli_error($GLOBALS["___mysqli_ston"]));
$i=0;
while($result_data = mysqli_fetch_array($res_get_soap_data)){
    $mo_no = $result_data['mo_no'];
    $api_url = $api_hostname.":".$api_port_no."/m3api-rest/execute/PMS100MI/SelMaterials;returncols=MTNO,ITDS,CNQT,MSEQ,PRNO,MFNO,OPNO?CONO=$comp_no&FACI=$global_facility_code&MFNO=".$mo_no;
    $response = getCurlAuthRequest($api_url,$basic_auth);
    if($response['status'] && isset($response['response']['PRNO'])){
        $item_code = urlencode($response['response']['MTNO']);
        $item_description = $response['response']['ITDS'];
        $order_yy = $response['response']['CNQT'];
        $sequence_no = $response['response']['MSEQ'];
        $qry_to_chk_op = "SELECT * FROM $brandix_bts.`tbl_orders_ops_ref` WHERE operation_code='".$response['response']['OPNO']."' AND category='cutting'";
        $res_to_chk_op = mysqli_query($link, $qry_to_chk_op) or exit("Sql Error select bai_pro3.operation cutting".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res_chk_op = mysqli_fetch_array($res_to_chk_op);
        if(isset($res_chk_op['id'])){
            $color_size_url = $api_hostname.":".$api_port_no."/m3api-rest/execute/MDBREADMI/GetMITMAHX1?CONO=$comp_no&ITNO=$item_code";
            $response_size_data = getCurlAuthRequest($color_size_url,$basic_auth);
            if($response_size_data['status'] && isset($response_size_data['response']['CONO'])){
                $color_res = $response_size_data['response']['OPTY'];
                $option_des_url_col =$api_hostname.":".$api_port_no."/m3api-rest/execute/PDS050MI/Get?CONO=$comp_no&OPTN=$color_res";
                $response_color_data = getCurlAuthRequest($option_des_url_col,$basic_auth);
                if($response_color_data['status'] && isset($response_color_data['response']['TX30'])){
                    $color_description = $response_color_data['response']['TX30'];
                    $get_m3_trans_mo = "SELECT * FROM $m3_inputs.mo_details WHERE MONUMBER='".$mo_no."'";
                    $res_m3_trans_mo = mysqli_query($link, $get_m3_trans_mo) or exit("Sql Error select m3_transcation.mo_details".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res_m3_trans_mo = mysqli_fetch_array($res_m3_trans_mo);
                    //================ insert order_details_original =========================
                    $ins_order_details = "INSERT INTO $m3_inputs.order_details_original(`Facility`, `Customer_Style_No`, `CPO_NO`, `VPO_NO`, `CO_no`, `Style`, `Schedule`, `Manufacturing_Schedule_no`, `MO_Split_Method`, `MO_Released_Status_Y_N`, `GMT_Color`, `GMT_Size`, `GMT_Z_Feature`, `Graphic_Number`, `CO_Qty`, `MO_Qty`, `PCD`, `Plan_Delivery_Date`, `Destination`, `Packing_Method`, `Item_Code`, `Item_Description`, `RM_Color_Description`, `Order_YY_WO_Wastage`, `Wastage`, `Required_Qty`, `UOM`, `MO_NUMBER`, `SEQ_NUMBER`, `time_stamp`) VALUES ('".$global_facility_code."','','".$res_m3_trans_mo['cpo']."','".$res_m3_trans_mo['VPO']."','','".$result_data['style']."','".$result_data['schedule']."','".$result_data['schedule']."','','Y','".$result_data['color']."','".$result_data['size']."','".$result_data['zfeature']."','','0','".$result_data['mo_quantity']."','".date('Ymd',strtotime($res_m3_trans_mo['STARTDATE']))."','".date('Ymd',strtotime($res_m3_trans_mo['COPLANDELDATE']))."','".$result_data['destination']."','".$result_data['packing_method']."','".urldecode($item_code)."','".$item_description."','".$color_description."','".$order_yy."','','','','".$mo_no."','".$sequence_no."','".date('Y-m-d H:i:s')."')";
                    $res_order_details = mysqli_query($link, $ins_order_details) or exit("Sql Error Insert Order Details".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if($res_order_details){
                        //=============== update mo_details status =========================
                        $up_qry = "UPDATE $bai_pro3.mo_details SET material_master_status=1 WHERE id='".$result_data['id']."'";
                        $up_res = mysqli_query($link, $up_qry) or exit("Error : update query".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $i++;
                    }

                }
            }
        }
    }
}
echo "Excuted Records : ".$i;
function getCurlAuthRequest($url,$basic_auth){
    $include_path=getenv('config_job_path');
    include($include_path.'\sfcs_app\common\config\m3_api_const.php');
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
    CURLOPT_PORT =>$api_port_no,
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
    "accept: application/json",
    "authorization: Basic ".$basic_auth,
    "cache-control: no-cache",
    //"postman-token: fe9d938e-ff9e-0a12-b3b6-92e55251aa2e"
    ),
    ));

    $response = json_decode(curl_exec($curl),true);
    $err = curl_error($curl);

    curl_close($curl);
    $res = [];
    foreach($response['MIRecord'][0]['NameValue'] as $fields){
        $res[$fields['Name']] = $fields['Value'];
    }

    if ($err) {
        return ['status'=>false,'response'=>$err];
    } else {
        return ['status'=>true,'response'=>$res];
    }
}
?>