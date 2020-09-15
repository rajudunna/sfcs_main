<?php
/**
 * Get Setions for department type 'SEWING' and plant code
 */
function getSectionByDeptTypeSewing($plant_code){
    global $pms;
    global $link_new;
    try{
        $departmentType = DepartmentTypeEnum::SEWING;
        $sectionsQuery = "select section_id,section_code,section_name from $pms.sections as sec left join $pms.departments as dept on sec.department_id = dept.department_id where sec.plant_code='".$plant_code."' and dept.plant_code='".$plant_code."' and dept.department_type= '".$departmentType."' and sec.is_active=1";
        $sectionsQueryResult = mysqli_query($link_new,$sectionsQuery) or exit('Problem in getting sections');
        if(mysqli_num_rows($sectionsQueryResult)>0){
            $sections = [];
            while($row = mysqli_fetch_array($sectionsQueryResult)){
                $sectionRecord = [];
                $sectionRecord["sectionId"] = $row['section_id'];
                $sectionRecord["sectionCode"] = $row["section_code"];
                $sectionRecord["sectionName"] = $row["section_name"];
                array_push($sections, $sectionRecord);
            }
            return $sections;
        } else {
            return "Sections not found";
        }
    } catch(Exception $e) {
        throw $error;
    }
}

/**
 * get workstations for plant code and section id
 */
// function getWorkstationsForSectionId($plant_code, $sectionId) {
//     global $pms;
//     global $link_new;
//     try{
//         $workstationsQuery = "select workstation_id,workstation_code,workstation_description,workstation_label from $pms.workstation where plant_code='".$plant_code."' and section_id= '".$sectionId."' and is_active=1";
//         $workstationsQueryResult = mysqli_query($link_new,$workstationsQuery) or exit('Problem in getting workstations');
//         if(mysqli_num_rows($workstationsQueryResult)>0){
//             $workstations= [];
//             while($row = mysqli_fetch_array($workstationsQueryResult)){
//                 $workstationRecord = [];
//                 $workstationRecord["workstationId"] = $row['workstation_id'];
//                 $workstationRecord["workstationCode"] = $row["workstation_code"];
//                 $workstationRecord["workstationDesc"] = $row["workstation_description"];
//                 $workstationRecord["workstationLabel"] = $row["workstation_label"];
//                 array_push($workstations, $workstationRecord);
//             }
//             return $workstations;
//         } else {
//             return "Workstations not found";
//         }
//     } catch(Exception $e) {
//         throw $error;
//     }
// }

/**
 * get planned sewing jobs(JG) for the workstation
 */
// function getJobsForWorkstationIdTypeSewing($plant_code, $workstationId) {
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',4,'R'));

//     global $tms;
//     global $link_new;
//     try{
//         $jobsQuery = "select tj.task_jobs_id,tj.task_job_reference from $tms.task_header as th left join $tms.task_jobs as tj on th.task_header_id=tj.task_header_id where tj.plant_code='".$plant_code."' and th.resource_id='".$workstationId."' and tj.task_type='".$taskType."' and th.task_status = '".$taskStatus."'";
//         $jobsQueryResult = mysqli_query($link_new,$jobsQuery) or exit('Problem in getting jobs in workstation');
//         if(mysqli_num_rows($jobsQueryResult)>0){
//             $jobs= [];
//             while($row = mysqli_fetch_array($jobsQueryResult)){
//                 $jobRecord = [];
//                 $jobRecord["taskJobId"] = $row['task_jobs_id'];
//                 $jobRecord["taskJobId"] = $row['task_jobs_id'];
//                 array_push($jobs, $jobRecord);
//             }
//             return $jobs;
//         } else {
//             return "Jobs not found for the workstation";
//         }
//     } catch(Exception $e) {
//         throw $error;
//     }
// }

/**
 * get planned jobs(JG) for the workstation
 */
function getPlannedJobsTms($work_id,$tasktype,$plant_code){
    global $link_new;
    global $pps;
    global $tms;
    global $TaskTypeEnum;
    global $TaskStatusEnum;
      
    $check_type=TaskTypeEnum::SEWINGJOB;
    $job_group_type=TaskTypeEnum::PLANNEDSEWINGJOB;
   
    //Qry to fetch task_header_id from task_header
    $task_header_id=array();
    $get_task_header_id="SELECT task_header_id FROM $tms.task_header WHERE resource_id='$work_id' AND task_status='".TaskStatusEnum::INPROGRESS."' AND task_type='$tasktype' AND plant_code='$plant_code'";
    $task_header_id_result=mysqli_query($link_new, $get_task_header_id) or exit("Sql Error at get_task_header_id".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($task_header_id_row=mysqli_fetch_array($task_header_id_result))
    {
       $task_header_id[] = $task_header_id_row['task_header_id'];
    }
    //To get taskrefrence from task_jobs based on resourceid 
    $task_job_reference=array(); 
    $get_refrence_no="SELECT task_job_reference FROM $tms.task_jobs WHERE task_header_id IN('".implode("','" , $task_header_id)."') AND plant_code='$plant_code'";
    $get_refrence_no_result=mysqli_query($link_new, $get_refrence_no) or exit("Sql Error at refrence_no".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($refrence_no_row=mysqli_fetch_array($get_refrence_no_result))
    {
      $task_job_reference[] = $refrence_no_row['task_job_reference'];
    }
    //Qry to get sewing jobs from jm_jobs_header
    $job_number=array();
    $qry_toget_sewing_jobs="SELECT job_number,jm_jg_header_id FROM $pps.jm_jg_header WHERE job_group_type='$job_group_type' AND plant_code='$plant_code' AND jm_jg_header_id IN ('".implode("','" , $task_job_reference)."')";
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

/**
 * get count for trim allocated jobs
 */
function calculateJobsCount($module){ 
	global $link_new;
	global $tms;
	global $pms;
	global $TaskTypeEnum;
	global $TrimStatusEnum;
 
	$tasktype=TaskTypeEnum::SEWINGJOB;
	$task_jobs_id=array();
	$qry_get_task_id="SELECT task_jobs_id FROM $tms.task_header LEFT JOIN $tms.task_jobs ON task_header.task_header_id=task_jobs.task_header_id WHERE resource_id='$module' and task_header.plant_code='$plant_code' and task_header.task_type='$tasktype'";
	$get_module_result=mysqli_query($link_new, $qry_get_task_id) or exit("Sql Error at qry_get_module".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($get_module_row=mysqli_fetch_array($get_module_result))
	{
	  $task_jobs_id[] = $get_module_row['task_jobs_id'];
	}
	$trim_status=TrimStatusEnum::ISSUED;
	$get_count="SELECT count(task_job_id) as task_job_id_count  FROM $pms.job_trims WHERE trim_status='$trim_status' AND plant_code='$plant_code' AND task_job_id IN ('".implode("','" , $task_jobs_id)."')";
	$get_count_result = mysqli_query($link_new,$get_count);
	while($row = mysqli_fetch_array($get_count_result)){
		  $jobs_count = $row['task_job_id_count'];
		}
	if($jobs_count == 0 || $jobs_count == '')
		return 0;
	else	
		return $jobs_count;
}

?>