
<?php  
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');  
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/enums.php');
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_v2.php');
    $status = 'F';
    $plant_code = $_SESSION['plantCode'];
    $username = $_SESSION['userName'];
    $tasktype=TaskTypeEnum::SEWINGJOB;
    if( isset($_GET['job_no']) && $_GET['job_no']!=''){
        $job_r = $_GET['job_no'];
        $job = $_GET['job'];

        //Back up jobs
        $insert_log = "Insert into $pms.delete_jobs_log values (`input_job_no_random`,`username`,`date_time`,`plant_code`,`created_user`,`updated_user`) 
                    values('$job','$username','".date('Y-m-d H:i:s')."','".$plant_code."','".$username."','".$username."')";
        mysqli_query($link,$insert_log);
        
        //get task_header from task_jobs
        $qry_header_id="SELECT task_header_id FROM $tms.task_jobs WHERE task_job_reference='$job_r' AND plant_code='$plant_code' AND task_type='$tasktype'";
        $result_qry_header_id=mysqli_query($link_new, $qry_header_id) or exit("Sql Error at qry_header_id".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($qry_header_id_row=mysqli_fetch_array($result_qry_header_id))
        {
            $task_header_id=$qry_header_id_row['task_header_id'];
        }
        $progress_hold=TaskProgressEnum::HOLD;
        $update_qry_task_header = "UPDATE $tms.task_header set task_progress='$progress_hold',updated_at=NOW() WHERE plant_code='$plant_code' AND task_header_id = '$task_header_id' AND task_type='$tasktype'";
        mysqli_query($link, $update_qry_task_header) or exit("update_qry_task_header".mysqli_error($GLOBALS["___mysqli_ston"]));
       
        echo "<script>$(document).ready(function(){
                    swal('Input Job Deleted Successfully','','success');
                });
                </script>";
        
    }

?>
<div class='panel panel-primary'>
    <div class='panel-heading'>
        Remove Sewing Jobs - IPS
    </div>
    <div class='panel-body'>
        <table class='table table-bordered'>
            <thead>
                <tr class='info'>
                    <th>Sno</th>
                    <th>Style</th>
                    <th>Schedule</th>
                    <th>Color</th>
                    <th>PO Description</th>
                    <th>Job No</th>
                    <th>Original Qty</th>
                    <th>Module</th>
                    <th>Docket No's</th>
                    <!-- <th>Received Qty</th> -->
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php

                    $counter = 0;

                    $tasktype=TaskTypeEnum::SEWINGJOB;
                    $taskProgress = TaskProgressEnum::INPROGRESS;
                    $task_header_id=array();
                    $resource_id=array();
                    $get_task_header_id="SELECT task_header_id,resource_id,task_ref FROM $tms.task_header WHERE task_progress='$taskProgress' AND task_type='$tasktype' AND plant_code='$plant_code'";
                    $task_header_id_result=mysqli_query($link_new, $get_task_header_id) or exit("Sql Error at get_task_header_id".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($task_header_id_row=mysqli_fetch_array($task_header_id_result))
                    {
                       $task_header_id[] = $task_header_id_row['task_header_id'];
                       $resource_id[$task_header_id_row['task_ref']]=$task_header_id_row['resource_id'];
                    }

                    //To get taskrefrence from task_jobs based on resourceid 
                    $task_job_reference=array(); 
                    $get_refrence_no="SELECT task_job_reference FROM $tms.task_jobs WHERE task_header_id IN('".implode("','" , $task_header_id)."') AND plant_code='$plant_code' AND task_type='$tasktype'";
                    $get_refrence_no_result=mysqli_query($link_new, $get_refrence_no) or exit("Sql Error at refrence_no".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($refrence_no_row=mysqli_fetch_array($get_refrence_no_result))
                    {
                      $task_job_reference[] = $refrence_no_row['task_job_reference'];
                    }
                    //Qry to get sewing jobs from jm_jobs_header
                    $job_group_type=TaskTypeEnum::PLANNEDSEWINGJOB;
                    $job_number=array();
                    $ponumber=array();
                    $masterponumber=array();
                    $qry_toget_sewing_jobs="SELECT job_number,jm_jg_header_id,po_number,master_po_number FROM $pps.jm_jg_header LEFT JOIN $pps.jm_job_header on jm_job_header.jm_job_header_id=jm_jg_header.jm_job_header  WHERE job_group_type='$job_group_type' AND jm_jg_header.plant_code='$plant_code' AND jm_jg_header_id IN('".implode("','" , $task_job_reference)."')";
                    $toget_sewing_jobs_result=mysqli_query($link_new, $qry_toget_sewing_jobs) or exit("Sql Error at toget_task_job".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $toget_sewing_jobs_num=mysqli_num_rows($toget_sewing_jobs_result);
                    if($toget_sewing_jobs_num>0){
                        while($toget_sewing_jobs_row=mysqli_fetch_array($toget_sewing_jobs_result))
                        {
                          $job_number[$toget_sewing_jobs_row['jm_jg_header_id']]=$toget_sewing_jobs_row['job_number'];
                          $ponumber[$toget_sewing_jobs_row['jm_jg_header_id']]=$toget_sewing_jobs_row['po_number'];
                          $masterponumber[$toget_sewing_jobs_row['jm_jg_header_id']]=$toget_sewing_jobs_row['master_po_number'];
                        }
                    }



                    // //Function to check whether previous operation qty fully scanned or not
                    // $check_status= random_function($jobno,$operation_code,$plant_code);
                    
                    
                    foreach($job_number as $key=>$value)
                    {
                        //To get taskjobs_id
                        $task_jobs_id = [];
                        $qry_get_task_job="SELECT task_jobs_id FROM $tms.task_jobs WHERE task_job_reference='$key' AND plant_code='$plant_code' AND task_type='$tasktype'";
                        //echo $qry_get_task_job;
                        $qry_get_task_job_result = mysqli_query($link_new, $qry_get_task_job) or exit("Sql Error at qry_get_task_job" . mysqli_error($GLOBALS["___mysqli_ston"]));
                        while ($row21 = mysqli_fetch_array($qry_get_task_job_result)) {
                            $task_jobs_id[] = $row21['task_jobs_id'];
                        }
                        //TO GET STYLE AND COLOR FROM TASK ATTRIBUTES USING TASK JOB ID
                        $job_detail_attributes = [];
                        $qry_toget_style_sch = "SELECT attribute_name,attribute_value FROM $tms.task_attributes where task_jobs_id in ('".implode("','" , $task_jobs_id)."') and plant_code='$plant_code'";
                        $qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("Sql Error at toget_style_sch" . mysqli_error($GLOBALS["___mysqli_ston"]));
                        while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) {
                    
                            $job_detail_attributes[$row2['attribute_name']] = $row2['attribute_value'];
                        
                        }
                        $style = $job_detail_attributes[$sewing_job_attributes['style']];
                        $color = $job_detail_attributes[$sewing_job_attributes['color']];
                        $schedule = $job_detail_attributes[$sewing_job_attributes['schedule']];
                        $docketno = $job_detail_attributes[$sewing_job_attributes['docketno']];

                        //to get qty from jm job lines
                        $toget_qty_qry="SELECT sum(quantity) as qty from $pps.jm_job_bundles where jm_jg_header_id ='$key' and plant_code='$plant_code'";
                        $toget_qty_qry_result=mysqli_query($link_new, $toget_qty_qry) or exit("Sql Error at toget_style_sch".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $toget_qty=mysqli_num_rows($toget_qty_qry_result);
                        if($toget_qty>0){
                            while($toget_qty_det=mysqli_fetch_array($toget_qty_qry_result))
                            {
                              $sew_qty = $toget_qty_det['qty'];
                            }
                        }
                        //get_module
                        $qry_get_module="SELECT resource_id FROM $tms.task_header LEFT JOIN $tms.task_jobs ON task_header.task_header_id=task_jobs.task_header_id WHERE task_job_reference='$key'";
                        $get_module_result=mysqli_query($link_new, $qry_get_module) or exit("Sql Error at qry_get_module".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($get_module_row=mysqli_fetch_array($get_module_result))
                        {
                            $resource_id = $get_module_row['resource_id'];
                        }
                       //To get workstation_code
                        $query = "select workstation_code from $pms.workstation where plant_code='$plant_code' and workstation_id = '$resource_id'";
                        $query_result=mysqli_query($link_new, $query) or exit("Sql Error at workstation_description".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($des_row=mysqli_fetch_array($query_result))
                        {
                            $workstation_description = $des_row['workstation_code'];
                        }
                        $jg_header_id=$key;
                        $job_number=$value;
                        $po_number=$ponumber[$key];
                        //To get PO Description
                        $result_po_des=getPoDetaials($po_number,$plant_code);
                        $po_des=$result_po_des['po_description'];
                        if($check_status == 0){
                            $url = 'index-no-navi.php?r='.$_GET['r']."&job_no=$jg_header_id&job=$job_number";
                            $counter++;
                            echo "<tr>";
                                echo "<td>$counter</td>"; 
                                echo "<td>$style</td>"; 
                                echo "<td>$schedule</td>";
                                echo "<td>$color</td>";
                                echo "<td>$po_des</td>"; 
                                echo "<td>$job_number</td>";                   
                                echo "<td>$sew_qty</td>";
                                echo "<td>$workstation_description</td>";
                                echo "<td>$docketno</td>";
                                // echo "<td>$rem_qty</td>";
                                echo "<td><a href='$url' onclick='return confirm_delete(event,this)' 
                                        class='btn btn-danger btn-sm'>Remove From IPS</a></td>";
                            echo "</tr>";
                            }
                            else
                            {
                            if($counter == 0){
                                echo "<tr><td colspan=9><div class='alert alert-danger'>No Data Found</div></td></tr>";
                            }
                            }
                    }    
                ?>
            </tbody>
        </table>
    </div>
</div>




<script>
    function confirm_delete(e,t)
    {
        e.preventDefault();
        var v = sweetAlert({
            title: "Are you sure to Delete the JOB ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["No, Cancel It!", "Yes, I am Sure!"],
        }).then(function(isConfirm){
            if (isConfirm) {
                window.location = $(t).attr('href');
                return true;
            } else {
                sweetAlert("Request Cancelled",'','error');
                return false;
            }
        });
    }
</script>


