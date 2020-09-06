
<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions_v2.php"); 
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/enums.php");
error_reporting(0);
$plant_code = $_SESSION['plantCode'];
$username = $_SESSION['userName'];

if(isset($_GET['get_data'])){
    $module = $_GET['module'];
    get_details($module);
    exit();
}else if(isset($_GET['save_data'])){
    $module = $_GET['to_module'];
    $module1 = $_GET['module'];
    $data = $_POST;
    $res = save_details($data,$module,$module1);
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


function get_details($module){
    $counter = 0;
    global $link_new;
    global $tms;
    global $TaskTypeEnum;
    $plant_code = $_SESSION['plantCode']; 
    $html_out = "<div class='panel panel-primary'>";
     $html_out.= "<div class='panel-heading'><h3>Module -$module</h3></div>";
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
        $qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("Sql Error at toget_style_sch" . mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) {
    
            $job_detail_attributes[$row2['attribute_name']] = $row2['attribute_value'];
        
        }
        $style = $job_detail_attributes[$sewing_job_attributes['style']];
        $schedule = $job_detail_attributes[$sewing_job_attributes['schedule']]; 
        $po_number = $job_detail_attributes[$sewing_job_attributes['ponumber']]; 
        $schedule1=implode("," , $schedule); 
        $jobno=$sew_num;
        $counter++;
        $html_out.= "<tr>";
        $html_out.= "<td>
        <input type='hidden' value='$jobno' id='job_$counter'>
        <input type='checkbox' class='custom-control-input boxes' id='$counter' onchange='checkedMe(this)'></td>
        <td>$sew_num</td>
        <td>$style</td>
        <td>$schedule1</td>
        <td>$po_number</td>";
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

function save_details($data,$module,$module1){
    global $link_new;
    global $tms;
    global $pps;
    global $pts;
    global $TaskTypeEnum;
    $counter = 0;
    $plant_code = $_SESSION['plantCode'];
    $username = $_SESSION['userName'];
    $tasktype = TaskTypeEnum::SEWINGJOB; 
    // var_dump($data);
    foreach($data['jobs'] as $job){

        //To get task_header_id
        $get_task_header_id="SELECT jm_job_header FROM $pps.jm_jg_header where job_number='$job' AND plant_code='$plant_code'";
        // echo $get_task_header_id;
        $result1 = mysqli_query($link_new, $get_task_header_id)or exit("Module missing".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($row1 = mysqli_fetch_array($result1))
        {
           $job_header_id = $row1['jm_job_header'];
        }  

        $task_header_update="UPDATE $tms.`task_header` SET resource_id='$module' WHERE task_ref='$job_header_id' AND resource_id='$module1' AND plant_code='$plant_code' AND task_type='$tasktype'";
        mysqli_query($link_new, $task_header_update)or exit("task_header_update error".mysqli_error($GLOBALS["___mysqli_ston"]));

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