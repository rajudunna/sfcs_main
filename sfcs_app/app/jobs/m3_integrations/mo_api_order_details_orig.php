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
print("\n mo_api_order_details_orig file start : ".$start_timestamp." milliseconds.")."\n";
$total_api_calls_duration=0;
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
set_time_limit(6000000);

$log="";
$log.='<table border=1><tr><th>SL no</th><th>Query</th><th>Start Time</th><th>End Time</th><th>Difference</th></tr>';   
$basic_auth = base64_encode($api_username.':'.$api_password);


$qry_to_chk_op = "SELECT group_concat(operation_code) as operation_code  FROM $brandix_bts.`tbl_orders_ops_ref` WHERE category='cutting' group by category";
$res_to_chk_op = mysqli_query($link, $qry_to_chk_op) or exit("Sql Error select bai_pro3.operation cutting".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_chk_op = explode(',',mysqli_fetch_array($res_to_chk_op)['operation_code']);
//var_dump($res_chk_op);die();

$qry_get_soap_data = "SELECT * FROM $bai_pro3.`mo_details` WHERE material_master_status=0";
$res_get_soap_data = mysqli_query($link, $qry_get_soap_data) or exit("Sql Error select bai_pro3.mo_details".mysqli_error($GLOBALS["___mysqli_ston"]));
$i=0; $call_count=0;
while($result_data = mysqli_fetch_array($res_get_soap_data)){
    $i++;
    $res_order_details = false;
    $mo_no = trim($result_data['mo_no']);
    $api_url = $api_hostname.":".$api_port_no."/m3api-rest/execute/PMS100MI/SelMaterials;returncols=MTNO,ITDS,CNQT,MSEQ,PRNO,MFNO,OPNO?CONO=$comp_no&FACI=$global_facility_code&MFNO=".$mo_no;
    //echo $api_url."<br/>";
    $call_count++;$call_sub_count=0;
    $moac1=microtime(true);
    print("response1 ".$call_count." API Call Start: ".$moac1." milliseconds. Parameters: ".$api_url."; ")."\n";
            
    $response1 = getCurlAuthRequestLocal1($api_url,$basic_auth);
    
    $moac2=microtime(true);
    print("response1 ".$call_count." API call End : ".$moac2."milliseconds")."\n";
    $total_api_calls_duration+=$moac2-$moac1;
    print("response1 ".$call_count." API call Duration : ".($moac2-$moac1)."milliseconds")."\n";

    if($response1['status'] && isset($response1['response'][0]['PRNO'])){
        $j=0;

        foreach($response1['response'] as $resp_resp){
            $j++;

            $response['response'] = $resp_resp;
            $item_code = urlencode($response['response']['MTNO']);
            $item_description = $response['response']['ITDS'];
            $order_yy = $response['response']['CNQT'];
            $sequence_no = $response['response']['MSEQ'];


            //============= call api for wastage =============
            $mfno = trim($response['response']['MFNO']);
            $prno = urlencode($response['response']['PRNO']);
            $url_wastage = $api_hostname.":".$api_port_no."/m3api-rest/execute/MDBREADMI/GetMWOMATX3;returncols=WAPC,PEUN?CONO=$comp_no&FACI=$global_facility_code&MFNO=$mfno&PRNO=$prno&MSEQ=$sequence_no";


            $log.="<tr><th>".$i."--".$j."</th><th>".$url_wastage."</th>";
            $msc10=microtime(true);
            $log.="<th>".$msc10."</th>";
        
            //echo $url_wastage;die();
            $call_sub_count++;
            $moac3=microtime(true);
            print("response_wastage ".$call_count*$call_sub_count." API Call Start: ".$moac3." milliseconds. Parameters: ".$url_wastage."; ")."\n";
							
            $response_wastage = getCurlAuthRequestLocal($url_wastage,$basic_auth);
            
            $moac4=microtime(true);
            print("response_wastage ".$call_count*$call_sub_count." API call End : ".$moac4."milliseconds")."\n";
            $total_api_calls_duration+=$moac4-$moac3;
            print("response_wastage ".$call_count*$call_sub_count." API call Duration : ".($moac4-$moac3)."milliseconds")."\n";


            $uom = '';
            $wastage = '';
            if($response_wastage['status'] && isset($response_wastage['response']['WAPC'])){
                $uom = $response_wastage['response']['PEUN'];
                $wastage = $response_wastage['response']['WAPC'];
            }
        
            $color_size_url = $api_hostname.":".$api_port_no."/m3api-rest/execute/MDBREADMI/GetMITMAHX1?CONO=$comp_no&ITNO=$item_code";
            $moac5=microtime(true);
            print("response_size_data ".$call_count*$call_sub_count." API Call Start: ".$moac5." milliseconds. Parameters: ".$color_size_url."; ")."\n";
            
            $response_size_data = getCurlAuthRequestLocal($color_size_url,$basic_auth);
            
            $moac6=microtime(true);
            print("response_size_data ".$call_count*$call_sub_count." API call End : ".$moac6."milliseconds")."\n";
            $total_api_calls_duration+=$moac6-$moac5;
            print("response_size_data ".$call_count*$call_sub_count." API call Duration : ".($moac6-$moac5)."milliseconds")."\n";

                $color_res = $response_size_data['status'] ? $response_size_data['response']['OPTY'] : '';
                $option_des_url_all =$api_hostname.":".$api_port_no."/m3api-rest/execute/PDS050MI/Get?CONO=$comp_no&OPTN=";
            
                $moac7=microtime(true);
                print("response_color_data ".$call_count*$call_sub_count." API Call Start: ".$moac7." milliseconds. Parameters: ".$option_des_url_all."".$color_res."; ")."\n";
            
                $response_color_data = getCurlAuthRequestLocal($option_des_url_all.$color_res,$basic_auth);

                $moac8=microtime(true);
                print("response_color_data ".$call_count*$call_sub_count." API call End : ".$moac8."milliseconds")."\n";
                $total_api_calls_duration+=$moac8-$moac7;
                print("response_color_data ".$call_count*$call_sub_count." API call Duration : ".($moac8-$moac7)."milliseconds")."\n";

                    $color_description = ($response_color_data['status']) ? $response_color_data['response']['TX30'] : '';
                    $optx = $response_size_data['status'] ? $response_size_data['response']['OPTX'] : '';
                    $optz = $response_size_data['status'] ? $response_size_data['response']['OPTZ'] : '';
            
                    $moac9=microtime(true);
                    print("size_description ".$call_count*$call_sub_count." API Call Start: ".$moac9." milliseconds. Parameters: ".$option_des_url_all."".$optx."; ")."\n";
            
                    $size_description = getCurlAuthRequestLocal($option_des_url_all.$optx,$basic_auth)['response']['TX30'] ?? '';
            
                    $moac10=microtime(true);
                    print("size_description ".$call_count*$call_sub_count." API call End : ".$moac10."milliseconds")."\n";
                    $total_api_calls_duration+=$moac10-$moac9;
                    print("size_description ".$call_count*$call_sub_count." API call Duration : ".($moac10-$moac9)."milliseconds")."\n";
                    
                    $moac11=microtime(true);
                    print("z_feature_description ".$call_count*$call_sub_count." API Call Start: ".$moac11." milliseconds. Parameters: ".$option_des_url_all."".$optz."; ")."\n";
            
                    $z_feature_description = getCurlAuthRequestLocal($option_des_url_all.$optz,$basic_auth)['response']['TX30'] ?? '';
                    $msc23=microtime(true);
                    $log.="<th>".$msc23."</th>";
                    $msc24=$msc23-$msc22;
                    $log.="<th>".$msc24."</th></tr>";

                    $moac12=microtime(true);
                    print("z_feature_description ".$call_count*$call_sub_count." API call End : ".$moac12."milliseconds")."\n";
                    $total_api_calls_duration+=$moac12-$moac11;
                    print("z_feature_description ".$call_count*$call_sub_count." API call Duration : ".($moac12-$moac11)."milliseconds")."\n";
                   //=========== save data ================
                $item_description=str_replace('"','""',$item_description);
                $color_description=str_replace('"','""',$color_description);

                $qry_save_bom = "INSERT INTO $m3_inputs.bom_details(date_time,mo_no,plant_code,
                item_code,item_description,color,color_description,size,z_code,per_piece_consumption,wastage,uom,material_sequence,product_no,operation_code) VALUES (now(),'".$mo_no."','".$global_facility_code."','".urldecode($item_code)."',\"".$item_description."\",'".$color_res."',\"".$color_description."\",'".$size_description."','".$z_feature_description."','".$order_yy."','".$wastage."','".$uom."','".$sequence_no."','".urldecode($prno)."','".$response['response']['OPNO']."')";
                    $res_save_bom = mysqli_query($link, $qry_save_bom) or exit("Sql Error Insert bom Details".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if(in_array(trim($response['response']['OPNO']),$res_chk_op)){
                        //================================================
                        $get_m3_trans_mo = "SELECT * FROM $m3_inputs.mo_details WHERE MONUMBER='$mo_no'";
                        $res_m3_trans_mo = mysqli_query($link, $get_m3_trans_mo) or exit("Sql Error select m3_transcation.mo_details".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $res_m3_trans_mo = mysqli_fetch_array($res_m3_trans_mo);
                        //================ insert order_details_original =========================
                        $Required_Qty=(($order_yy*$result_data['mo_quantity'])+($order_yy*$result_data['mo_quantity']*$wastage/100));
                        $moac13=microtime(true);
                        
                        $parm1=$api_hostname.":".$api_port_no.'/m3api-rest/execute/MDBREADMI/GetMITMASX1?CONO='.$comp_no.'&ITNO='.$item_code;
                        $parm2=$api_hostname.":".$api_port_no.'/m3api-rest/execute/MDBREADMI/GetMITMASX1?CONO='.$comp_no.'&ITNO=Parameter1 API response';

                        print("item_description1  ".$call_count*$call_sub_count." API Call Start: ".$moac13." milliseconds. two api calls in loop Parameter1: ".$parm1."; Parameter2:".$parm2."; ")."\n";
            
                        $item_description1 = getCurlAuthRequestLocal($api_hostname.":".$api_port_no.'/m3api-rest/execute/MDBREADMI/GetMITMASX1?CONO='.$comp_no.'&ITNO='.getCurlAuthRequestLocal($api_hostname.":".$api_port_no.'/m3api-rest/execute/MDBREADMI/GetMITMASX1?CONO='.$comp_no.'&ITNO='.$item_code,$basic_auth)['response']['HDPR'],$basic_auth)['response']['FUDS'];

                        $moac14=microtime(true);
                        print("item_description1  ".$call_count*$call_sub_count." API call End : ".$moac14."milliseconds")."\n";
                        $total_api_calls_duration+=$moac14-$moac13;
                        print("item_description1  ".$call_count*$call_sub_count." API call Duration : ".($moac14-$moac13)."milliseconds")."\n";
                        $item_description1=str_replace('"','""',$item_description1);

                        //To get Customer Style Number
                         $get_customer_style = $api_hostname.":".$api_port_no.'/m3api-rest/execute/OIS100MI/GetHead?CONO='.$comp_no.'&ORNO='.$res_m3_trans_mo['REFERENCEORDER'].'';
                         //echo $get_customer_style;
                        $moac15=microtime(true);
                        print("response_customer_style  ".$call_count*$call_sub_count." API Call Start: ".$moac15." milliseconds. Parameters: ".$get_customer_style."; ")."\n";
            
                        $response_customer_style = getCurlAuthRequestLocal($get_customer_style,$basic_auth);
                         
                        $moac16=microtime(true);
                        print("response_customer_style  ".$call_count*$call_sub_count." API call End : ".$moac16."milliseconds")."\n";
                        $total_api_calls_duration+=$moac16-$moac15;
                        print("response_customer_style  ".$call_count*$call_sub_count." API call Duration : ".($moac16-$moac15)."milliseconds")."\n";
                         $result_style = $response_customer_style['status'] ? $response_customer_style['response']['OREF'] : '';

                        $ins_order_details = "INSERT INTO $m3_inputs.order_details_original(`Facility`, `Customer_Style_No`, `CPO_NO`, `VPO_NO`, `CO_no`, `Style`, `Schedule`, `Manufacturing_Schedule_no`, `MO_Split_Method`, `MO_Released_Status_Y_N`, `GMT_Color`, `GMT_Size`, `GMT_Z_Feature`, `Graphic_Number`, `CO_Qty`, `MO_Qty`, `PCD`, `Plan_Delivery_Date`, `Destination`, `Packing_Method`, `Item_Code`, `Item_Description`, `RM_Color_Description`, `Order_YY_WO_Wastage`, `Wastage`, `Required_Qty`, `UOM`, `MO_NUMBER`, `SEQ_NUMBER`, `time_stamp`) VALUES ('".$global_facility_code."','".$result_style."','".$result_data['cpo']."','".$res_m3_trans_mo['VPO']."','','".$result_data['style']."','".$result_data['schedule']."','".$result_data['schedule']."','','Y','".$result_data['color']."','".$result_data['size']."','".$result_data['zfeature']."','','0','".$result_data['mo_quantity']."','".date('Ymd',strtotime($res_m3_trans_mo['STARTDATE']))."','".date('Ymd',strtotime($res_m3_trans_mo['COPLANDELDATE']))."','".$result_data['destination']."','".$result_data['packing_method']."','".urldecode($item_code)."',\"".$item_description1."\",\"".$color_description."\",'".$order_yy."','".$wastage."','".$Required_Qty."','".$uom."','".$mo_no."','".$sequence_no."','".date('Y-m-d H:i:s')."')";
                        $res_order_details = mysqli_query($link, $ins_order_details) or exit("Sql Error Insert Order Details".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                    }
        
        }
    }
    if($res_order_details){
        //=============== update mo_details status =========================
        $up_qry = "UPDATE $bai_pro3.mo_details SET material_master_status=1 WHERE id=".$result_data['id'];
        $up_res = mysqli_query($link, $up_qry) or exit("Error : update query".mysqli_error($GLOBALS["___mysqli_ston"]));
        $i++;
    }
}
// echo "Excuted Records : ".$i;
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

print("\n mo_api_order_details_orig file Total Api Calls Duration : ".$total_api_calls_duration." milliseconds.")."\n";
$end_timestamp = microtime(true);
$duration=$end_timestamp-$start_timestamp;
print("mo_api_order_details_orig file End : ".$end_timestamp." milliseconds.")."\n";
print("mo_api_order_details_orig file total Duration : ".$duration." milliseconds.")."\n";
?>
