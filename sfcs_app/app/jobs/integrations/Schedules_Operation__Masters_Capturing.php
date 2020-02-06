<?php
$start_timestamp = microtime(true);

$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
include($include_path.'\sfcs_app\common\config\rest_api_calls.php');
set_time_limit(1000000);

$log="";
$log.='<table border=1><tr><th>SL no</th><th>Query</th><th>Start Time</th><th>End Time</th><th>Difference</th></tr>';	
$basic_auth = base64_encode($api_username.':'.$api_password);


//getting mo numbers from mo_details table
$qry_modetails="SELECT mo_no AS mo_num,item_code,style,SCHEDULE,color,size,zfeature,product_sku  FROM $bai_pro3.mo_details WHERE ops_master_status=0 group by mo_num,product_sku";
echo "</br>".$qry_modetails."<br>";
$result_qry_modetails=mysqli_query($link, $qry_modetails) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
print("job started\n");
$i=0;
while($sql_row=mysqli_fetch_array($result_qry_modetails))
{
    $i++;

    $mo_num=trim($sql_row['mo_num']);
    $FG_code=rawurlencode($sql_row['product_sku']);

    //getting all work center id in sfcs
    $qry_getworkcenters="SELECT * FROM brandix_bts.tbl_orders_ops_ref";
    $result_qry_getworkcenters=mysqli_query($link, $qry_getworkcenters) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    $result_allcenters=mysqli_fetch_all($result_qry_getworkcenters,MYSQLI_ASSOC);
    $m3_operation_type_array=array_column($result_allcenters,'m3_operation_type');
    var_dump($m3_operation_type_array);
    
    $url=$api_hostname.":".$api_port_no."/m3api-rest/execute/PMS100MI/SelOperations?CONO=".$company_no."&FACI=".$facility_code."&MFNO=".$mo_num."&PRNO=".$FG_code;
    //$url = str_replace(' ', '%20', $url);
    // echo "</br>".$url."</br>";

    $log.="<tr><th>".$i."</th><th>".$url."</th>";
    $msc7=microtime(true);
    $log.="<th>".$msc7."</th>";

    $result = $obj->getCurlAuthRequest($url);
    $decoded = json_decode($result,true);

    $msc8=microtime(true);
    $log.="<th>".$msc8."</th>";
    $msc9=$msc8-$msc7;
    $log.="<th>".$msc9."</th></tr>";
    
    if($decoded['@type'])
    {
        continue;
    }
    $vals = (conctruct_array($decoded['MIRecord']));
    //For bulk insertion in  schedule master
    $sql1 = "insert into $bai_pro3.schedule_oprations_master(Style, ScheduleNumber, ColorId, Description, SizeId, ZFeature, ZFeatureId, MONumber,SMV, OperationDescription, OperationNumber,WorkCenterId,Main_OperationNumber,Main_WorkCenterId,m3_operation_type) values";
    $values = array();
    $workcenter_status_valid=true;
    $j=0;
    foreach ($vals as $value) 
    {
        $j++;
        //getting values from api call
        $MONumber=$value['MFNO'];
        $SMV=$value['PITI'];
        $CTCD=$value['CTCD'];
        if($CTCD>0)
        {
        $SMV = $SMV/$CTCD;
        }
        $operation_desc=$value['OPDS'];
        $operation_code=$value['OPNO'];
        $WorkCenterId=trim($value['PLGR'],' ');
        $WorkCenterId_parent=trim($value['PLG1'],' ');

        // echo "</br>PLGR : ".$WorkCenterId."</br>";

        //==========call api for INTO value for validating =========
        $url_INTO = $api_hostname.":".$api_port_no."/m3api-rest/execute/MDBREADMI/GetMPDWCT00?CONO=$comp_no&FACI=$facility_code&PLGR=$WorkCenterId";


        $log.="<tr><th>".$i."--".$j."</th><th>".$url_INTO."</th>";
        $msc10=microtime(true);
        $log.="<th>".$msc10."</th>";

        // echo "</br>".$url_INTO."</br>";
            $response_INTO = getCurlAuthRequestLocal($url_INTO,$basic_auth);

            $msc11=microtime(true);
            $log.="<th>".$msc11."</th>";
            $msc12=$msc11-$msc10;
            $log.="<th>".$msc12."</th></tr>";

            $into_value = '';
            if($response_INTO['status'] && isset($response_INTO['response']['INTO'])){
                $into_value = trim($response_INTO['response']['INTO'],' ');
            }
            // echo "</br> INTO value : ".$into_value."</br>";
         
        //validating m3 workcenter with sfcs
        if (!in_array($into_value,$m3_operation_type_array,true)) {
            $workcenter_status_valid=false;
            echo "</br>M3 API validation failed for ".$into_value."</br>";
            echo "</br>***********************************************************************</br>";
            break;
        }else{
            echo "</br>M3 API Validation Success for ".$into_value."</br>";
        }

        
        //getting values from MO details
        $Style=$sql_row['style'];
        $ScheduleNumber=$sql_row['SCHEDULE'];
        $ColorId=$sql_row['color'];
        $Description=$sql_row['color'];
        $SizeId=$sql_row['size'];
        $ZFeature=$sql_row['zfeature'];
        $ZFeatureId=$sql_row['zfeature'];
        //GETTING SFCS OPERATION ID FROM OPERATION MASTER BASED ON M3 Operation Type
        $selecting_qry = "select operation_code from $brandix_bts.tbl_orders_ops_ref where m3_operation_type = '$into_value'";
        echo "</br>Getting sfcs OPS ID".$selecting_qry."</br>";
        $res_selecting_qry = mysqli_query($link,$selecting_qry);
        while($rew_res_selecting_qry = mysqli_fetch_array($res_selecting_qry))
        {
            $sfcs_operation_id = $rew_res_selecting_qry['operation_code'];
        }

        //insertion query for schedule_oprations_master table
        // $sql1="insert into $bai_pro3.schedule_oprations_master(Style, ScheduleNumber, ColorId, Description, SizeId, ZFeature, ZFeatureId, MONumber,SMV, OperationDescription, OperationNumber,WorkCenterId,Main_OperationNumber,Main_WorkCenterId) values('".$Style."','".$ScheduleNumber."','".$ColorId."','".$Description."','".$SizeId."','".$ZFeature."','".$ZFeatureId."','".$MONumber."','".$SMV."','".$operation_desc."','".$sfcs_operation_id."','".$WorkCenterId."','".$operation_code."','".$WorkCenterId_parent."')";

        array_push($values, "('" . $Style . "','" . $ScheduleNumber . "','" . $ColorId . "','" . $Description . "','" . $SizeId . "','".$ZFeature."','".$ZFeatureId."','".$MONumber."','".$SMV."','".$operation_desc."','".$sfcs_operation_id."','".$WorkCenterId."','".$operation_code."','".$WorkCenterId_parent."','".$into_value."')");
    }

    if($workcenter_status_valid){
        // echo $sql1 . implode(', ', $values);
        // var_dump($values);
        //insertion query for schedule_oprations_master table
        $sql_result1=mysqli_query($link, $sql1 . implode(', ', $values));
        if($sql_result1){
            
            // echo "</br>successfully Inserted : ".$mo_num."</br>";   
            //Update status for updated mo's and FG_codes
            $update_mo_details="UPDATE $bai_pro3.mo_details SET ops_master_status=1 WHERE mo_no='$mo_num'";
            $result = mysqli_query($link, $update_mo_details);

       }else{

            echo "</br>Failed to Insert : ".$mo_num."</br>";

       }
    }  
    echo "</br>***********************************************************************</br>";    
}
print("job successfully completed\n");
//construct key values and 
function conctruct_array($req){
    $return_ar = [];
    foreach($req as $ar1){
        $temp = [];
        foreach($ar1['NameValue'] as $ar2){
            $temp[$ar2['Name']] = $ar2['Value'];
        }
        $return_ar[] = $temp;
    }
    return $return_ar;
}

function getCurlAuthRequestLocal($url,$basic_auth){
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

$log.="<tr><th>".$i."</th><th>Total Job execution Time</th>";

$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
$log.="<th>".$start_timestamp."</th>";
$log.="<th>".$end_timestamp."</th>";
$log.="<th>".$duration."</th></tr>";

//$include_path=getenv('config_job_path');
//$directory = $include_path.'\sfcs_app\app\jobs\log\\'.'log_schedule_operation_master';
$directory = $include_path.'\sfcs_app\app\jobs\\'.'log';
if (!file_exists($directory)) {
    mkdir($directory, 0777, true);
}
$fileName="schedule_operation_master_capturing";
$file_name_string = $fileName.'_'.date("Y-m-d-H-i-s").'.html';
//$my_file=$include_path.'\sfcs_app\app\jobs\log\\'.'log_schedule_operation_master\\'.$file_name_string;
$my_file=$include_path.'\sfcs_app\app\jobs\\'.'log\\'.$file_name_string;
$handle = fopen($my_file, 'a') or die('Cannot open file:  '.$my_file);
$file_data_request = $log;
fwrite($handle,"\n".$file_data_request); 

fclose($handle); 
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
 print("Schedules_Operation_Masters_Capturing file Execution took ".$duration." seconds.");
?>
