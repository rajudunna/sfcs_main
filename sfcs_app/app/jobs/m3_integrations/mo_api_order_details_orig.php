<?php
/*
	=========== Create By Chandu =============
	Created at : 09-10-2018
	Updated at : 11-10-2018
	Input : data from bai_pro3.mo_details with status 0.
    Output : populate the data in m3_inputs.order_details_original.
    V2 : save bom details.
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
    //echo $api_url."<br/>";
    $response1 = getCurlAuthRequestLocal1($api_url,$basic_auth);
    if($response1['status'] && isset($response1['response'][0]['PRNO'])){
        foreach($response1['response'] as $resp_resp){
            $response['response'] = $resp_resp;
            $item_code = urlencode($response['response']['MTNO']);
            $item_description = $response['response']['ITDS'];
            $order_yy = $response['response']['CNQT'];
            $sequence_no = $response['response']['MSEQ'];

            $qry_to_chk_op = "SELECT * FROM $brandix_bts.`tbl_orders_ops_ref` WHERE operation_code='".$response['response']['OPNO']."' AND category='cutting'";
            $res_to_chk_op = mysqli_query($link, $qry_to_chk_op) or exit("Sql Error select bai_pro3.operation cutting".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res_chk_op = mysqli_fetch_array($res_to_chk_op);
        
            $color_size_url = $api_hostname.":".$api_port_no."/m3api-rest/execute/MDBREADMI/GetMITMAHX1?CONO=$comp_no&ITNO=$item_code";
            $response_size_data = getCurlAuthRequestLocal($color_size_url,$basic_auth);
            if($response_size_data['status'] && isset($response_size_data['response']['CONO'])){
                $color_res = $response_size_data['response']['OPTY'];
                $option_des_url_all =$api_hostname.":".$api_port_no."/m3api-rest/execute/PDS050MI/Get?CONO=$comp_no&OPTN=";
                $response_color_data = getCurlAuthRequestLocal($option_des_url_all.$color_res,$basic_auth);

                    $color_description = ($response_color_data['status']) ? $response_color_data['response']['TX30'] : '';
                    //============= call api for wastage =============
                    $mfno = $response['response']['MFNO'];
                    $prno = urlencode($response['response']['PRNO']);
                    $url_wastage = $api_hostname.":".$api_port_no."/m3api-rest/execute/MDBREADMI/GetMWOMATX3;returncols=WAPC,PEUN?CONO=$comp_no&FACI=$global_facility_code&MFNO=$mfno&PRNO=$prno&MSEQ=$sequence_no";
                    //echo $url_wastage;die();
                    $response_wastage = getCurlAuthRequestLocal($url_wastage,$basic_auth);
                    $uom = '';
                    $wastage = '';
                    if($response_wastage['status'] && isset($response_wastage['response']['WAPC'])){
                        $uom = $response_wastage['response']['PEUN'];
                        $wastage = $response_wastage['response']['WAPC'];
                    }

                    $size_description = getCurlAuthRequestLocal($option_des_url_all.$result_data['size'],$basic_auth)['response']['TX30'] ?? '';
                    $z_feature_description = getCurlAuthRequestLocal($option_des_url_all.$result_data['zfeature'],$basic_auth)['response']['TX30'] ?? '';

                    //=========== save data ================
                    $qry_save_bom = "INSERT INTO $m3_inputs.bom_details(date_time,mo_no,plant_code,
                    item_code,item_description,color,color_description,size,z_code,per_piece_consumption,wastage,uom,material_sequence,product_no,operation_code) VALUES (now(),'".$mo_no."','".$global_facility_code."','".urldecode($item_code)."','".$item_description."','".$result_data['color']."','".$color_description."','".$size_description."','".$z_feature_description."','".$order_yy."','".$wastage."','".$uom."','".$sequence_no."','".urldecode($prno)."','".$response['response']['OPNO']."')";
                    $res_save_bom = mysqli_query($link, $qry_save_bom) or exit("Sql Error Insert bom Details".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if(isset($res_chk_op['id'])){
                        //================================================
                        $get_m3_trans_mo = "SELECT * FROM $m3_inputs.mo_details WHERE MONUMBER='".$mo_no."'";
                        $res_m3_trans_mo = mysqli_query($link, $get_m3_trans_mo) or exit("Sql Error select m3_transcation.mo_details".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $res_m3_trans_mo = mysqli_fetch_array($res_m3_trans_mo);
                        //================ insert order_details_original =========================
                        $Required_Qty=(($order_yy*$result_data['mo_quantity'])+($order_yy*$result_data['mo_quantity']*$wastage/100));
                        $item_description1 = getCurlAuthRequestLocal($api_hostname.":".$api_port_no.'/m3api-rest/execute/MDBREADMI/GetMITMASX1?CONO='.$comp_no.'&ITNO='.getCurlAuthRequestLocal($api_hostname.":".$api_port_no.'/m3api-rest/execute/MDBREADMI/GetMITMASX1?CONO='.$comp_no.'&ITNO='.$item_code,$basic_auth)['response']['HDPR'],$basic_auth)['response']['FUDS'];
                        $ins_order_details = "INSERT INTO $m3_inputs.order_details_original(`Facility`, `Customer_Style_No`, `CPO_NO`, `VPO_NO`, `CO_no`, `Style`, `Schedule`, `Manufacturing_Schedule_no`, `MO_Split_Method`, `MO_Released_Status_Y_N`, `GMT_Color`, `GMT_Size`, `GMT_Z_Feature`, `Graphic_Number`, `CO_Qty`, `MO_Qty`, `PCD`, `Plan_Delivery_Date`, `Destination`, `Packing_Method`, `Item_Code`, `Item_Description`, `RM_Color_Description`, `Order_YY_WO_Wastage`, `Wastage`, `Required_Qty`, `UOM`, `MO_NUMBER`, `SEQ_NUMBER`, `time_stamp`) VALUES ('".$global_facility_code."','','".$result_data['cpo']."','".$res_m3_trans_mo['VPO']."','','".$result_data['style']."','".$result_data['schedule']."','".$result_data['schedule']."','','Y','".$result_data['color']."','".$result_data['size']."','".$result_data['zfeature']."','','0','".$result_data['mo_quantity']."','".date('Ymd',strtotime($res_m3_trans_mo['STARTDATE']))."','".date('Ymd',strtotime($res_m3_trans_mo['COPLANDELDATE']))."','".$result_data['destination']."','".$result_data['packing_method']."','".urldecode($item_code)."','".$item_description1."','".$color_description."','".$order_yy."','".$wastage."','".$Required_Qty."','".$uom."','".$mo_no."','".$sequence_no."','".date('Y-m-d H:i:s')."')";
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
function getCurlAuthRequestLocal($url,$basic_auth){
    $include_path=getenv('config_job_path');
    include_once($include_path.'\sfcs_app\common\config\rest_api_calls.php'); 
    $obj1 = new rest_api_calls();
    try{ 
        $val = $obj1->getCurlAuthRequest($url);  
        $response = json_decode($val,true);
        $res = [];
        if(count($response)>0 && isset($response['MIRecord'][0]['NameValue']) && count($response['MIRecord'][0]['NameValue'])>0){
            foreach($response['MIRecord'][0]['NameValue'] as $fields){
                $res[$fields['Name']] = $fields['Value'];
            }
            return ['status'=>true,'response'=>$res];
        }else{
            return ['status'=>false,'response'=>'No data found.'];
        }
        
    }catch(Exception $err){
        return ['status'=>false,'response'=>'Error: '.$err];
    }
    
}

function getCurlAuthRequestLocal1($url,$basic_auth){
    $include_path=getenv('config_job_path');
    include_once($include_path.'\sfcs_app\common\config\rest_api_calls.php'); 
    $obj1 = new rest_api_calls();
    try{ 
        $val = $obj1->getCurlAuthRequest($url);  
        $response = json_decode($val,true);
        $res = [];
        if(count($response)>0 && isset($response['MIRecord'][0]['NameValue']) && count($response['MIRecord'][0]['NameValue'])>0){
            foreach($response['MIRecord'] as $fields1){
                $res1 = [];
                foreach($fields1['NameValue'] as $fields){
                    $res1[$fields['Name']] = $fields['Value'];
                }
                $res[] = $res1;
            }
            return ['status'=>true,'response'=>$res];
        }else{
            return ['status'=>false,'response'=>'No data found.'];
        }
        
    }catch(Exception $err){
        return ['status'=>false,'response'=>'Error: '.$err];
    }
    
}
?>