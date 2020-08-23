
<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
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

function leading_zeros($value, $places)
{
    $leading='';
    
    if(is_numeric($value))
    {
        for($x = 1; $x <= $places; $x++)
        {
            $ceiling = pow(10, $x);
            if($value < $ceiling)
            {
                $zeros = $places - $x;
                for($y = 1; $y <= $zeros; $y++)
                {
                    $leading .= "0";
                }
            $x = $places + 1;
            }
        }
        $output = $leading . $value;
    }
    else{
        $output = $value;
    }
    
    return $output;
}


function get_details($module){
    $counter = 0;
    include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
    global $plant_code;    

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
    $check_module="SELECT task_header_id,resource_id FROM $tms.task_header where resource_id='$module' and task_type='$tasktype' and plan_code='$plant_code'";
    $result1 = mysqli_query($link_new, $check_module)or exit("Module missing".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row1 = mysqli_fetch_array($result1))
    {
        $task_header_id[] = $row1['task_header_id'];
        $module = $row1['resource_id'];
    }

    //To get IPS Routing Operation
    $application='Input Planning System';
    $to_get_map_id="SELECT operation_map_id FROM `pms`.`operation_routing` WHERE dashboard_name='$application'";
    //echo $scanning_query;
    $map_id_result=mysqli_query($link_new, $to_get_map_id)or exit("error in operation_routing".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row1=mysqli_fetch_array($map_id_result))
    {
        $operation_map_id=$sql_row1['operation_map_id'];
    }
    $to_get_ops_code="SELECT operation_code FROM `pms`.`operation_mapping` WHERE operation_map_id='$operation_map_id'";
    $get_ops_result=mysqli_query($link_new, $to_get_ops_code)or exit("error in operation_mapping".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row2=mysqli_fetch_array($get_ops_result))
    {
        $operation_code=$sql_row2['operation_code'];
    }

    $job_detail_attributes=[];

    //To get job,style,schedule details
    $get_details="SELECT * FROM $tms.task_attributes where task_jobs_id in ('" . implode ( "', '", $task_header_id ) . "') and plant_code='$plant_code'";
    $get_details_result=mysqli_query($link_new, $get_details)or exit("details_error".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row2=mysqli_fetch_array($get_details_result))
    {
       foreach($sewing_job_attributes as $key=> $val){
        if($val == $row2['attribute_name'])
        {
           $job_detail_attributes[$val] = $row2['attribute_value'];
        }
    }

      
     //Function to check whether sewing job is scanned or not
     //$check_status= random_function($jobno,$operation_code,$plant_code); 

     // To get Prefix
     $get_prefix="select * from $mdm.tbl_sewing_job_prefix where type_of_sewing ='$type_name'";
     //echo $get_prefix;
     $get_result=mysqli_query($link_new, $get_prefix)or exit("prefix error".mysqli_error($GLOBALS["___mysqli_ston"]));
     while($row3=mysqli_fetch_array($get_result))
     {
       $prefix=$row3['prefix'];
     }
     $jobno=$job_detail_attributes[$sewing_job_attributes['sewingjobno']];
     $display=$prefix.''.leading_zeros($jobno,3);
     $schedule=$job_detail_attributes[$sewing_job_attributes['schedule']];
     $schedules = implode(",",$schedule);
     // if ($check_status == 0)
     // {
        $counter++;
        $html_out.= "<tr>";
        $html_out.= "<td>
        <input type='hidden' value='$jobno' id='job_$counter'>
        <input type='checkbox' class='custom-control-input boxes' id='$counter' onchange='checkedMe(this)'></td>
        <td>$display</td>
        <td>$job_detail_attributes[$sewing_job_attributes['style']]</td>
        <td>$schedules</td>
        <td>$job_detail_attributes[$sewing_job_attributes['ponumber']]</td>";
        $html_out.= "</tr>";
     // }
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
    include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
    $counter = 0;
    global $plant_code;
    global $username;
    global $link_new;
    global $tms;
    global $pps;
    global $pts;
    foreach($data['jobs'] as $job){

        //To get task_header_id
        $get_task_header_id="SELECT job_header_id FROM $pps.job_group_header where jobno='$job' AND plant_code='$plant_code'";
        $result1 = mysqli_query($link_new, $check_module)or exit("Module missing".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($row1 = mysqli_fetch_array($result1))
        {
           $job_header_id = $row1['job_header_id'];
        }  

        $task_header_update="UPDATE $tms.`task_header` SET resource_id='$module' WHERE task_ref='$job_header_id' AND resource_id='$module1' AND plant_code='$plant_code' AND task_type='SEWING'";
        mysqli_query($link, $task_header_update)or exit("task_header_update error".mysqli_error($GLOBALS["___mysqli_ston"]));

        $insert_qry="insert into $pts.ips_job_transfer (job_no,module,transfered_module,user,plant_code,created_user,updated_user) values (".$job.",".$module1.",".$module.",'".$username.",'".$plant_code.",'".$username."','".$username."')";
        mysqli_query($link, $insert_qry)or exit("insert qty error".mysqli_error($GLOBALS["___mysqli_ston"]));

        $insert_qry1="insert into $pts.job_transfer_details (sewing_job_number,transfered_module,status,plant_code,created_user,updated_user) values (".$job.",".$module.",'P',".$plant_code.",".$username.",".$username.")";
        mysqli_query($link, $insert_qry1)or exit("insert qty error".mysqli_error($GLOBALS["___mysqli_ston"]));
        $counter++;
    }
    return 1;
}

?>