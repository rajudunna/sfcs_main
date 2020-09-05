<?php
if(isset($_GET['job_rev_no']))
{
    $job_rev_no = $_GET['job_rev_no'];
    $job_plant_code = $_GET['plant_code'];
    if($job_rev_no != '')
    {
        getjobreversaldetails($job_rev_no,$job_plant_code);
    }
}
function getjobreversaldetails($job_rev_no,$job_plant_code)
{
    include("../../../../../common/config/config_ajax.php");    
    //to get remarks
    $qry_to_header_id="SELECT jm_job_header FROM $pps.`jm_jg_header` WHERE job_number='$job_number' AND job_group_type=".TaskTypeEnum::PLANNEDSEWINGJOB." AND plant_code='$plant_code'";
    $header_id_result=mysqli_query($link_new, $qry_to_header_id) or exit("Sql Error at qry_to_header_id".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($header_row=mysqli_fetch_array($header_id_result))
    {
        $jm_job_header=$header_row['jm_job_header'];
    } 
       
    $qry_to_get_remarks="SELECT job_header_type FROM `pps`.`jm_job_header` WHERE jm_job_header_id='$jm_job_header' AND plant_code='$plant_code'";
    $remarks_result=mysqli_query($link_new, $qry_to_header_id) or exit("Sql Error at qry_to_get_remarks".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($remarks_row=mysqli_fetch_array($remarks_result))
    {
        $sampling=$remarks_row['job_header_type'];
    }  
     
    //To get Workstations for input job
    $qry_to_get_remarks="SELECT resource_id FROM $tms.`task_header` WHERE job_number='$job_number' AND job_group_type=".TaskTypeEnum::PLANNEDSEWINGJOB." AND plant_code='$plant_code'";
    $remarks_result=mysqli_query($link_new, $qry_to_header_id) or exit("Sql Error at qry_to_get_remarks".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($resource_row=mysqli_fetch_array($remarks_result))
    {
        $resource_id=$resource_row['resource_id'];
    }   
        
    echo json_encode($json1);
}

?>