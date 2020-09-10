
<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");

include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions_v2.php"); 
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/enums.php");
error_reporting(0);
$plant_code = $_SESSION['plantCode'];
$username = $_SESSION['userName'];

if(isset($_GET['get_data'])){
    $module = $_GET['module'];
    $plant_code = $_GET['plant_code'];
    get_details($module,$plant_code);
    exit();
}else if(isset($_GET['save_data'])){
    $module = $_GET['to_module'];
    $module1 = $_GET['module'];
    $data = $_POST;
    $plant_code = $_GET['plant_code'];
    $username = $_GET['username'];
    $res = save_details($data,$module,$module1,$plant_code,$username);
    $json['saved'] = $res;
    echo json_encode($json);
    exit();
}

// function leading_zeros($value, $places)
// {
//     $leading='';
    
//     if(is_numeric($value))
//     {
//         for($x = 1; $x <= $places; $x++)
//         {
//             $ceiling = pow(10, $x);
//             if($value < $ceiling)
//             {
//                 $zeros = $places - $x;
//                 for($y = 1; $y <= $zeros; $y++)
//                 {
//                     $leading .= "0";
//                 }
//             $x = $places + 1;
//             }
//         }
//         $output = $leading . $value;
//     }
//     else{
//         $output = $value;
//     }
    
//     return $output;
// }


function get_details($module,$plant_code){
    $counter = 0;
    global $link_new;
    global $tms;
    global $pms;
    global $pps;
    global $TaskTypeEnum; 
    //To get workstation description
    $query = "select workstation_description from $pms.workstation where plant_code='$plant_code' and workstation_id = '$module'";
    $query_result=mysqli_query($link_new, $query) or exit("Sql Error at workstation_description".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($des_row=mysqli_fetch_array($query_result))
    {
      $workstation_description = $des_row['workstation_description'];
    }
    $html_out = "<div class='panel panel-primary'>";
     $html_out.= "<div class='panel-heading'><h3>Module -$workstation_description</h3></div>";
       $html_out.= "<div class='panel-body'>";
       $html_out.= "";
         $html_out.= "<table class='table table-bordered'>
                 <thead>
                     <tr>
                         <td><input type='checkbox' class='btn btn-sm btn-warning' value='check all' onclick='toggle(this)'> Select All</td>
                         <td>Sewing Job Number</td>
                         <td>Style</td>
                         <td>Schedule</td>
                         <td>Po Number</td>
                     </tr>
                 </thead>
                 <tbody>";
    $tasktype = TaskTypeEnum::SEWINGJOB;             
    //To check module

     /*
        function to get planned jobs from workstation
        @params:work_id,plantcode,type(sewing,cutjob,embjob)
        @returns:job_number,task_header_id
    */
    // echo $module;
    $result_planned_jobs=getPlannedJobs($module,$tasktype,$plant_code);
    $job_number=$result_planned_jobs['job_number'];
    $task_header_id=$result_planned_jobs['task_header_id'];
    
 
    foreach($job_number as $sew_num=>$jm_sew_id)
    {
        //To get taskjobs_id
        $task_jobs_id = [];
        $qry_get_task_job="SELECT task_jobs_id FROM $tms.task_jobs WHERE task_job_reference='$jm_sew_id' AND plant_code='$plant_code' AND task_type='$tasktype'";
        $qry_get_task_job_result = mysqli_query($link_new, $qry_get_task_job) or exit("Sql Error at qry_get_task_job" . mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($row21 = mysqli_fetch_array($qry_get_task_job_result)) {
            $task_jobs_id[] = $row21['task_jobs_id'];
        }    
        //TO GET STYLE AND COLOR FROM TASK ATTRIBUTES USING TASK JOB ID
        $job_detail_attributes = [];
        $qry_toget_style_sch = "SELECT * FROM $tms.task_attributes where task_jobs_id in ('".implode("','" , $task_jobs_id)."') and plant_code='$plant_code'";
        //echo $qry_toget_style_sch;
        $qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("Sql Error at toget_style_sch" . mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) {
    
            $job_detail_attributes[$row2['attribute_name']] = $row2['attribute_value'];
        
        }
        //TaskAttributeNamesEnum
        $sewing_job_attributes=['style'=>'STYLE','schedule'=>'SCHEDULE','color'=>'COLOR','ponumber'=>'PONUMBER','masterponumber'=>'MASTERPONUMBER','cutjobno'=>'CUTJOBNO','docketno'=>'DOCKETNO','sewingjobno'=>'SEWINGJOBNO','bundleno'=>'BUNDLENO','packingjobno'=>'PACKINGJOBNO','cartonno'=>'CARTONNO','componentgroup'=>'COMPONENTGROUP'];
        $style = $job_detail_attributes[$sewing_job_attributes['style']];
        $schedule = $job_detail_attributes[$sewing_job_attributes['schedule']]; 
        $po_number = $job_detail_attributes[$sewing_job_attributes['ponumber']]; 
        //To get po number
        // $qry_get_podetails="SELECT po_number FROM $pps.jm_job_header LEFT JOIN $pps.jm_jg_header on jm_job_header.jm_job_header_id=jm_jg_header.jm_job_header WHERE jm_jg_header_id='".$jm_sew_id."' and jm_job_header.plant_code='$plant_code'";
        // $get_podetails_result=mysqli_query($link_new, $qry_get_podetails) or exit("Sql Error at qry_get_podetails".mysqli_error($GLOBALS["___mysqli_ston"]));
        // while($po_details_row=mysqli_fetch_array($get_podetails_result))
        // {
        //  $po_number=$po_details_row['po_number'];
        // }
        //To get PO Description
        $result_po_des=getPoDetaials($po_number,$plant_code);
        $po_des=$result_po_des['po_description']; 
        $jobno=$sew_num;
        $counter++;
        $html_out.= "<tr>";
        $html_out.= "<td>
        <input type='hidden' value='$jobno' id='job_$counter'>
        <input type='checkbox' class='custom-control-input boxes' id='$counter' onchange='checkedMe(this)'></td>
        <td>$sew_num</td>
        <td>$style</td>
        <td>$schedule</td>
        <td>$po_des</td>";
        $html_out.= "</tr>";
    }    
    if($counter == 0){
        $json['records'] = 0;
        echo json_encode($json);    
        exit();        
    }  

    $html_out.= "</tbody></table></div>";
    $json['table'] =$html_out;
    echo json_encode($json);    
    exit();                      
}

function save_details($data,$module,$module1,$plant_code,$username){
    global $link_new;
    global $tms;
    global $pps;
    global $pts;
    global $TaskTypeEnum;
    $counter = 0;
    $tasktype = TaskTypeEnum::SEWINGJOB; 
    // var_dump($data);
    foreach($data['jobs'] as $job){

        //To get task_header_id
        $get_task_header_id="SELECT jm_job_header,jm_jg_header_id  FROM $pps.jm_jg_header where job_number='$job' AND plant_code='$plant_code'";
        // echo $get_task_header_id;
        $result1 = mysqli_query($link_new, $get_task_header_id)or exit("Module missing".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($row1 = mysqli_fetch_array($result1))
        {
           $job_header_id = $row1['jm_job_header'];
           $jm_jg_header_id = $row1['jm_jg_header_id'];
        }  
        /**validate with work station mapping in task header*/
        $Qry_taskheader="SELECT resource_id,task_type,task_ref,task_progress,short_desc,priority,planned_date_time,delivery_date_time,sla,is_active,plant_code,created_at,created_user,updated_at,updated_user,version_flag FROM $tms.task_header WHERE task_ref='$job_header_id' AND plant_code='$plant_code' AND task_type='$tasktype'";
       // echo  $Qry_taskheader;
        $Qry_taskheader_result=mysqli_query($link_new, $Qry_taskheader) or exit("Sql Error at task_header".mysqli_error($GLOBALS["___mysqli_ston"]));
        $taskheader_num=mysqli_num_rows($Qry_taskheader_result);
        if($taskheader_num>0){
            while($taskheader_row=mysqli_fetch_array($Qry_taskheader_result))
            {
                $resource_id=$taskheader_row['resource_id']; 
                $task_type=$taskheader_row['task_type']; 
                $task_ref=$taskheader_row['task_ref'];  
                $task_progress=$taskheader_row['task_progress']; 
                $short_desc=$taskheader_row['short_desc']; 
                $priority=$taskheader_row['priority']; 
                $planned_date_time=$taskheader_row['planned_date_time']; 
                $delivery_date_time=$taskheader_row['delivery_date_time']; 
                $sla=$taskheader_row['sla']; 
                $is_active=$taskheader_row['is_active']; 
                $plant_code=$taskheader_row['plant_code']; 
                $created_at=$taskheader_row['created_at'];
                $created_user=$taskheader_row['created_user'];
                $updated_at=$taskheader_row['updated_at'];
                $updated_user=$taskheader_row['updated_user'];
                $version_flag=$taskheader_row['version_flag'];
            }
        }
         $taskStatus=TaskStatusEnum::INPROGRESS; 
         /**Insert new record in header for if new reource id alloacted with in cut job */
         $select_uuid="SELECT UUID() as uuid";
          //echo $select_uuid;
         $uuid_result=mysqli_query($link_new, $select_uuid) or exit("Sql Error at select_uuid".mysqli_error($GLOBALS["___mysqli_ston"]));
         while($uuid_row=mysqli_fetch_array($uuid_result))
         {
           $uuid=$uuid_row['uuid'];
        
         }
         $Qry_insert_taskheader="INSERT INTO $tms.task_header (task_header_id,`task_type`,`task_ref`,`task_status`,`task_progress`,`resource_id`,`short_desc`,`priority`,`planned_date_time`,`is_active`,`plant_code`,`created_user`,`updated_at`,`updated_user`,`version_flag`) VALUES ('".$uuid."','".$task_type."','".$task_ref."','".$taskStatus."','".$task_progress."','".$module."','".$short_desc."','".$priority."','".$planned_date_time."','".$is_active."','".$plant_code."','".$created_user."',NOW(),'".$updated_user."',1)";
        //  echo $Qry_insert_taskheader;
         $Qry_taskheader_result=mysqli_query($link_new, $Qry_insert_taskheader) or exit("Sql Error at insert task_header".mysqli_error($GLOBALS["___mysqli_ston"]));
        //  $last_id = mysqli_insert_id($link_new);
        //  echo $last_id; 
         /**update resource id tasks jobs with task_header*/
         $Qry_update_taskjobs="UPDATE $tms.task_jobs SET task_header_id='$uuid' WHERE task_job_reference='$jm_jg_header_id' AND task_type='$tasktype' AND plant_code='$plant_code'";
        // echo $Qry_update_taskjobs;
         $Qry_taskjobs_result=mysqli_query($link_new, $Qry_update_taskjobs) or exit("Sql Error at update task_jobs1".mysqli_error($GLOBALS["___mysqli_ston"]));

        // $task_header_update="UPDATE $tms.`task_header` SET resource_id='$module' WHERE task_ref='$job_header_id' AND resource_id='$module1' AND plant_code='$plant_code' AND task_type='$tasktype'";
        // mysqli_query($link_new, $task_header_update)or exit("task_header_update error".mysqli_error($GLOBALS["___mysqli_ston"]));

        $insert_qry="insert into $pts.ips_job_transfer (job_no,module,transfered_module,user,plant_code,created_user,updated_user) values ('".$job."','".$module1."','".$module."','".$username."','".$plant_code."','".$username."','".$username."')";
        // echo  $insert_qry;
        mysqli_query($link_new, $insert_qry)or exit("insert qty error".mysqli_error($GLOBALS["___mysqli_ston"]));

        $insert_qry1="insert into $pts.job_transfer_details (sewing_job_number,transfered_module,status,plant_code,created_user,updated_user) values ('".$job."','".$module."','P','".$plant_code."','".$username."','".$username."')";
        mysqli_query($link_new, $insert_qry1)or exit("insert qty error".mysqli_error($GLOBALS["___mysqli_ston"]));
        $counter++;
    }
    return 1;
}

?>