<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/enums.php');
/**
 * Get shifts for a plant code
 */
function getShifts($plantCode) {
    global $pms;
    global $link_new;
    try{
        $shiftsQuery = "select shift_id,shift_code,shift_description from $pms.shifts where plant_code='".$plantCode."' and is_active=1";
        $shiftQueryResult = mysqli_query($link_new,$shiftsQuery) or exit('Problem in getting shifts');
        if(mysqli_num_rows($shiftQueryResult)>0){
            $shifts = [];
            while($row = mysqli_fetch_array($shiftQueryResult)){
                $shiftRecord = [];
                $shiftRecord["shiftValue"] = $row['shift_id'];
                $shiftRecord["shiftLabel"] = $row["shift_code"]."-".$row["shift_description"];
                array_push($shifts, $shiftRecord);
            }
            return $shifts;
        } else {
            return "Shifts not found";
        }
    } catch(Exception $e) {
        throw $error;
    }
}

/**
 * Get Setions for department type 'SEWING' and plant code
 */
function getSectionByDeptTypeSewing($plantCode){
    global $pms;
    global $link_new;
    try{
        $departmentType = DepartmentTypeEnum::SEWING;
        $sectionsQuery = "select section_id,section_code,section_name from $pms.sections as sec left join $pms.departments as dept on sec.department_id = dept.department_id where sec.plant_code='".$plantCode."' and dept.plant_code='".$plantCode."' and dept.department_type= '".$departmentType."' and sec.is_active=1";
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
function getWorkstationsForSectionId($plantCode, $sectionId) {
    global $pms;
    global $link_new;
    try{
        $workstationsQuery = "select workstation_id,workstation_code,workstation_description,workstation_label from $pms.workstation where plant_code='".$plantCode."' and section_id= '".$sectionId."' and is_active=1";
        echo $wworkstationsQuery."<br/>";
        $workstationsQueryResult = mysqli_query($link_new,$workstationsQuery) or exit('Problem in getting workstations');
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
    global $tms;
    global $link_new;
    try{
        $taskType = TaskTypeEnum::SEWINGJOB;
        $taskStatus = TaskStatusEnum::INPROGRESS;
        $jobsQuery = "select tj.task_jobs_id, tj.task_job_reference from $tms.task_header as th left join $tms.task_jobs as tj on th.task_header_id=tj.task_header_id where tj.plant_code='".$plantCode."' and th.resource_id='".$workstationId."' and tj.task_type='".$taskType."' and th.task_status = '".$taskStatus."'";
        $jobsQueryResult = mysqli_query($link_new,$jobsQuery) or exit('Problem in getting jobs in workstation');
        if(mysqli_num_rows($jobsQueryResult)>0){
            $jobs= [];
            while($row = mysqli_fetch_array($jobsQueryResult)){
                $jobRecord = [];
                $jobRecord["taskJobId"] = $row['task_jobs_id'];
                $jobRecord["taskJobRef"] = $row['task_job_reference'];
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
 * get plant wise sewing operations
 */

function getOperationsTypeSewing($plantCode){
    global $pms;
    global $link_new;
    try{
        $departmentType = DepartmentTypeEnum::SEWING;
        $qryOperations="SELECT operation_code,operation_name FROM $pms.`operation_mapping` WHERE operation_category='$departmentType' AND plant_code='$plantCode' order by priority ASC";
        $qryOperationsResult = mysqli_query($link_new,$qryOperations) or exit('Problem in getting jobs in workstation');
        if(mysqli_num_rows($qryOperationsResult)>0){
            $operations= [];
            while($row = mysqli_fetch_array($qryOperationsResult)){
                $operation = [];
                $operation["operation_code"] = $row['operation_code'];
                $operation["operation_name"] = $row['operation_name'];
                array_push($operations, $operation);
            }
            return $operations;
        } else {
            return "Operations are not found";
        }


    }catch(Exception $e){
        throw $error;
    }

}





?>