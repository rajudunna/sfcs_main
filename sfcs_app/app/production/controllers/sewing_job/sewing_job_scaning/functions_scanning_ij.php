<?php
/*
    function to get jobnumber details for reversal scanning
    @params:job_number,plantcode
    @returns:workstation_id,workstation_description,sewingjobtype,operations,master_po_number
*/
if(isset($_GET['job_number']))
{
    $job_number = $_GET['job_number'];
    $plant_code = $_GET['plant_code'];
    if($job_number){
        $sewing_job_data = getjobreversaldetails($job_number,$plant_code);
        echo json_encode($sewing_job_data);
    }
}

function getjobreversaldetails($job_number,$plant_code)
{
    include("../../../../../common/config/config_ajax.php");    
    include("../../../../../common/config/sms_api_calls.php");   
    include("../../../../../common/config/server_urls.php");  
    include("../../../../../common/config/enums.php"); 


    //to get remarks
    $qry_to_header_id="SELECT jm_job_header FROM $pps.`jm_jg_header` WHERE job_number='$job_number' AND job_group_type='".TaskTypeEnum::PLANNEDSEWINGJOB."' AND plant_code='$plant_code'";
    $header_id_result=mysqli_query($link_new, $qry_to_header_id) or exit("Sql Error at qry_to_header_id $qry_to_header_id".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($header_row=mysqli_fetch_array($header_id_result))
    {
        $jm_job_header_id=$header_row['jm_job_header'];
    } 
       
    $sew_job_type_query="SELECT job_header_type, master_po_number FROM $pps.`jm_job_header` WHERE jm_job_header_id='$jm_job_header_id' AND plant_code='$plant_code'";
    $sew_job_type_result=mysqli_query($link_new, $sew_job_type_query) or exit("Sql Error at sew_job_type_query".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sew_job_type_row=mysqli_fetch_array($sew_job_type_result))
    {
        $sew_job_type = $sew_job_type_row['job_header_type'];
        $mp_number = $sew_job_type_row['master_po_number'];
    }  
     
    //To get Workstations for input job
    $workstation_query="SELECT resource_id FROM $tms.`task_header` WHERE task_ref='$jm_job_header_id' AND task_type='".TaskTypeEnum::SEWINGJOB."' AND plant_code='$plant_code' ";
    $workstation_result=mysqli_query($link_new, $workstation_query) or exit("Sql Error at workstation_query".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($workstation_row=mysqli_fetch_array($workstation_result))
    {
        $resource_id=$workstation_row['resource_id'];
    }

    // get the wotkstation desc
    $workstation_desc_query = "SELECT workstation_id, workstation_description FROM $pms.workstation WHERE workstation_id = '$resource_id' and plant_code='$plant_code'";
    $workstation_desc_result=mysqli_query($link_new, $workstation_desc_query) or exit("Sql Error at workstation_desc_query".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($workstation_desc_row=mysqli_fetch_array($workstation_desc_result))
    {
        $workstation_desc=$workstation_desc_row['workstation_description'];
        $workstation_id=$workstation_desc_row['workstation_id'];
    }

    // get all the Style color related Operaitons for sewing category
    $style_color_query="SELECT style,color,operations_version_id FROM $pps.`mp_color_detail` WHERE  plant_code='$plant_code' AND master_po_number='$mp_number'";
    $style_color_result=mysqli_query($link_new, $style_color_query) or exit("Sql Error at style_color_query".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row3=mysqli_fetch_array($style_color_result))
    {
        $style = $row3['style'];
        $color = $row3['color'];
        $op_version_id = $row3['operations_version_id'];
    } 
    
    $form_type=OperationType::GARMENTFORM;
    $category_sewing=OperationCategory::SEWING;
    $category_emb=OperationCategory::EMBELLISHMENT;
    // now make an API cal for SMS
    $smsData = getJobOpertions($style, $color, $plant_code, $op_version_id);
    $operations = [];
    foreach ($smsData as $key=>$operation) {
        $op_code = $operation['operationCode'];
        $op_desc = $operation['operationName'].' - '.$op_code;
        if ($operation['operationCategory'] == $category_sewing || ( $operation['operationForm'] == $form_type && $operation['operationCategory'] == $category_emb) ) {
            $operations[$op_code] = $op_desc;
        }
    }
    
    $sewing_job_data = [
        'workstation_id' => $workstation_id,
        'sew_job_type' => $sew_job_type,
        'workstaiton_desc' => $workstation_desc,
        'operations' => $operations,
        'mp_number' => $mp_number,
    ];

    return $sewing_job_data;
    
}

?>