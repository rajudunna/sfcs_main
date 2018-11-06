<?php
$start_timestamp = microtime(true);

$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
include($include_path.'\sfcs_app\common\config\rest_api_calls.php');
set_time_limit(1000000);


//getting mo numbers from mo_details table
$qry_modetails="SELECT mo_no AS mo_num,item_code,style,SCHEDULE,color,size,zfeature,product_sku  FROM $bai_pro3.mo_details WHERE ops_master_status='0' group by mo_num,product_sku";
echo "</br>".$qry_modetails."<br>";
$result_qry_modetails=mysqli_query($link, $qry_modetails) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
print("job started\n");
while($sql_row=mysqli_fetch_array($result_qry_modetails))
{

    $mo_num=$sql_row['mo_num'];
    $FG_code=rawurlencode($sql_row['product_sku']);

    //getting all work center id in sfcs
    $qry_getworkcenters="SELECT * FROM brandix_bts.tbl_orders_ops_ref";
    $result_qry_getworkcenters=mysqli_query($link, $qry_getworkcenters) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    $result_allcenters=mysqli_fetch_all($result_qry_getworkcenters,MYSQLI_ASSOC);
    $workcenters_array=array_column($result_allcenters,'parent_work_center_id');
    var_dump($workcenters_array);
    
    $url=$api_hostname.":".$api_port_no."/m3api-rest/execute/PMS100MI/SelOperations?CONO=".$company_no."&FACI=".$facility_code."&MFNO=".$mo_num."&PRNO=".$FG_code;
    //$url = str_replace(' ', '%20', $url);
    echo "</br>".$url."</br>";

    $result = $obj->getCurlAuthRequest($url);
    $decoded = json_decode($result,true);
    
    if($decoded['@type'])
    {
        continue;
    }
    $vals = (conctruct_array($decoded['MIRecord']));
    //For bulk insertion in  schedule master
    $sql1 = "insert into $bai_pro3.schedule_oprations_master(Style, ScheduleNumber, ColorId, Description, SizeId, ZFeature, ZFeatureId, MONumber,SMV, OperationDescription, OperationNumber,WorkCenterId,Main_OperationNumber,Main_WorkCenterId) values";
    $values = array();
    $workcenter_status_valid=true;
    foreach ($vals as $value) 
    {
        
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
        $WorkCenterId=$value['PLGR'];
        $WorkCenterId_parent=trim($value['PLG1'],' ');
         
        //validating m3 workcenter with sfcs
        if (!in_array($WorkCenterId_parent,$workcenters_array)) {
            $workcenter_status_valid=false;
            echo "</br>M3 API validation failed</br>";
            break;
        }

        
        //getting values from MO details
        $Style=$sql_row['style'];
        $ScheduleNumber=$sql_row['SCHEDULE'];
        $ColorId=$sql_row['color'];
        $Description=$sql_row['color'];
        $SizeId=$sql_row['size'];
        $ZFeature=$sql_row['zfeature'];
        $ZFeatureId=$sql_row['zfeature'];
        //GETTING SFCS OPERATION ID FROM OPERATION MASTER BASED ON WORK CENTER ID
        $selecting_qry = "select operation_code from $brandix_bts.tbl_orders_ops_ref where parent_work_center_id = '$WorkCenterId_parent'";
        $res_selecting_qry = mysqli_query($link,$selecting_qry);
        while($rew_res_selecting_qry = mysqli_fetch_array($res_selecting_qry))
        {
            $sfcs_operation_id = $rew_res_selecting_qry['operation_code'];
        }

        //insertion query for schedule_oprations_master table
        // $sql1="insert into $bai_pro3.schedule_oprations_master(Style, ScheduleNumber, ColorId, Description, SizeId, ZFeature, ZFeatureId, MONumber,SMV, OperationDescription, OperationNumber,WorkCenterId,Main_OperationNumber,Main_WorkCenterId) values('".$Style."','".$ScheduleNumber."','".$ColorId."','".$Description."','".$SizeId."','".$ZFeature."','".$ZFeatureId."','".$MONumber."','".$SMV."','".$operation_desc."','".$sfcs_operation_id."','".$WorkCenterId."','".$operation_code."','".$WorkCenterId_parent."')";

        array_push($values, "('" . $Style . "','" . $ScheduleNumber . "','" . $ColorId . "','" . $Description . "','" . $SizeId . "','".$ZFeature."','".$ZFeatureId."','".$MONumber."','".$SMV."','".$operation_desc."','".$sfcs_operation_id."','".$WorkCenterId."','".$operation_code."','".$WorkCenterId_parent."')");
    }

    if($workcenter_status_valid){
        echo "</br>".$sql1."</br>";
        var_dump($values);
        //insertion query for schedule_oprations_master table
        $sql_result1=mysqli_query($link, $sql1 . implode(', ', $values)) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        if($sql_result1){
                echo "</br>successfully Inserted".$mo_num."</br>";
                //Update status for updated mo's and FG_codes
            $update_mo_details="UPDATE $bai_pro3.mo_details SET ops_master_status=1 WHERE mo_no='$mo_num'";
            $result = mysqli_query($link, $update_mo_details)or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));

       }else{

            echo "</br>Failed Insertion".$mo_num."</br>";

       }
    }  
    
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
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." seconds.");
?>
