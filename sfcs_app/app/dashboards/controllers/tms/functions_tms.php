<?php
/**
 * get workstations for plant code and section id
 */
function getWorkstationsForSectionId($plantCode, $sectionId) {
    try{
        $workstationsQuery = "select workstation_id,workstation_code,workstation_description,workstation_label from $pms.workstation where plant_code='".$plantCode."' and section_id= '".$sectionId."' and is_active=1";
        $workstationsQueryResult = mysqli_query($link,$workstationsQuery) or exit('Problem in getting workstations');
        if(mysqli_num_rows($workstationsQueryResult)>0){
            $workstations= [];
            while($row = mysqli_fetch_array($workstationsQueryResult)){
                $workstationRecord = [];
                $workstationRecord["workstationId"] = $row['workstation_id'];
                $workstationRecord["workstationCode"] = $row["workstation_code"];
                $workstationRecord["workstationDesc"] = $row["workstation_description"];
                $workstationRecord["workstationLabel"] = $row["workstation_label"];
                array_push($workstations, $workstationRecord);
            }
            return $workstations;
        } else {
            return "Workstations not found";
        }
    } catch(Exception $e) {
        throw $error;
    }
}

/**
 * get planned sewing jobs(JG) for the workstation
 */
function getJobsForWorkstationIdTypeSewing($plantCode, $workstationId) {
    try{
        $taskType = TaskTypeEnum::SEWINGJOB;
        $taskStatus = TaskStatusEnum::INPROGRESS;
        $jobsQuery = "select tj.task_job_reference from $tms.task_header as th left join $tms.task_jobs as tj on th.task_header_id=tj.task_header_id where tj.plant_code='".$plantCode."' and th.resource_id='".$workstationId."' and tj.task_type='".$taskType."' and th.task_status = '".$taskStatus."'";
        $jobsQueryResult = mysqli_query($link,$jobsQuery) or exit('Problem in getting jobs in workstation');
        if(mysqli_num_rows($jobsQueryResult)>0){
            $jobs= [];
            while($row = mysqli_fetch_array($jobsQueryResult)){
                $jobRecord = [];
                $jobRecord["jobRef"] = $row['task_job_reference'];
                array_push($jobs, $jobRecord);
            }
            return $jobs;
        } else {
            return "Jobs not found for the workstation";
        }
    } catch(Exception $e) {
        throw $error;
    }
}

/**
 * get planned jobs(JG) for the workstation
 */
function getPlannedJobsTms($work_id,$tasktype,$plantcode){
    global $link_new;
    global $pps;
    global $tms;
    global $TaskTypeEnum;
    global $TaskStatusEnum;
      
    $check_type=TaskTypeEnum::SEWINGJOB;
    $job_group_type=TaskTypeEnum::PLANNEDSEWINGJOB;
   
    //Qry to fetch task_header_id from task_header
    $task_header_id=array();
    $get_task_header_id="SELECT task_header_id FROM $tms.task_header WHERE resource_id='$work_id' AND task_status='".TaskStatusEnum::INPROGRESS."' AND task_type='$tasktype' AND plant_code='$plantcode'";
    $task_header_id_result=mysqli_query($link_new, $get_task_header_id) or exit("Sql Error at get_task_header_id".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($task_header_id_row=mysqli_fetch_array($task_header_id_result))
    {
       $task_header_id[] = $task_header_id_row['task_header_id'];
    }
    //To get taskrefrence from task_jobs based on resourceid 
    $task_job_reference=array(); 
    $get_refrence_no="SELECT task_job_reference FROM $tms.task_jobs WHERE task_header_id IN('".implode("','" , $task_header_id)."') AND plant_code='$plantcode'";
    $get_refrence_no_result=mysqli_query($link_new, $get_refrence_no) or exit("Sql Error at refrence_no".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($refrence_no_row=mysqli_fetch_array($get_refrence_no_result))
    {
      $task_job_reference[] = $refrence_no_row['task_job_reference'];
    }
    //Qry to get sewing jobs from jm_jobs_header
    $job_number=array();
    $qry_toget_sewing_jobs="SELECT job_number,jm_jg_header_id FROM $pps.jm_jg_header WHERE job_group_type='$job_group_type' AND plant_code='$plantcode' AND jm_jg_header_id IN ('".implode("','" , $task_job_reference)."')";
    $toget_sewing_jobs_result=mysqli_query($link_new, $qry_toget_sewing_jobs) or exit("Sql Error at toget_task_job".mysqli_error($GLOBALS["___mysqli_ston"]));
    $toget_sewing_jobs_num=mysqli_num_rows($toget_sewing_jobs_result);
    if($toget_sewing_jobs_num>0){
      while($toget_sewing_jobs_row=mysqli_fetch_array($toget_sewing_jobs_result))
      {
        $job_number[$toget_sewing_jobs_row['job_number']]=$toget_sewing_jobs_row['jm_jg_header_id'];
      }
    }
    return array(
        'job_number' => $job_number,
        'task_header_id' => $task_header_id
    );
} 

?>