
<?php  
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');  
    $application = 'IPS';    
    $status = 'F';

    if( isset($_GET['job_no']) && $_GET['job_no']!=''){
        $job_r = $_GET['job_no'];
        $job = $_GET['job'];

        //Back up jobs
        $insert_log = "Insert into $bai_pro3.delete_jobs_log values (`input_job_no_random`,`username`,`date_time`) 
                    values('$job_r','$username','".date('Y-m-d H:i:s')."')";
        mysqli_query($link,$insert_log);

        $delete_query = "Delete from $bai_pro3.plan_dashboard_input where input_job_no_random_ref='$job_r'" ;
        $delete_result = mysqli_query($link,$delete_query) or exit("Problem Encountered While Deleting The Job");
       
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
                    <th>Job No</th>
                    <th>Original Qty</th>
                    <th>Module</th>
                    <th>Docket No's</th>
                    <th>Received Qty</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    //getting the operation code from the masters table
                    $counter = 0;
                    $op_code_query = "Select operation_code from $brandix_bts.tbl_ims_ops where appilication = '$application' ";
                    $op_code_result = mysqli_query($link,$op_code_query);
                    while($row = mysqli_fetch_array($op_code_result)){
                        $op_code = $row['operation_code'];
                    }

                    //getting dockets with 0,F status
                    /*
                    $fail_dockets_query = "select doc_no from $bai_pro3.cps_log where remaining_qty = 0
                                           and reported_status = '$status'";
                    $fail_dockets_result = mysqli_query($link,$fail_dockets_query);
                    while($row = mysqli_fetch_array($fail_dockets_result)){
                        $dockets[] = $row['doc_no'];
                    }
                    $dockets = array_unique($dockets);
                    $dockets_str = implode(',',$dockets);
                    */
                
                    if($dockets_str == '')
                        $dockets_str = '""';
                    //getting all jobs with the above dockets
                    $jobs_query = "Select style,color,schedule,input_job_no,bcd.input_job_no_random_ref,
                                   group_concat(distinct docket_number) as doc_str,
                                   group_concat(bundle_number) as bun_str,SUM(original_qty) as oqty,
                                   SUM(recevied_qty) as rqty,assigned_module 
                                   from $bai_pro3.plan_dashboard_input pdi 
                                   LEFT JOIN $brandix_bts.bundle_creation_data bcd ON pdi.input_job_no_random_ref  =  bcd.input_job_no_random_ref
                                   where operation_id = '$op_code'
                                   GROUP BY pdi.input_job_no_random_ref";   
                    //echo $jobs_query;          
                    $jobs_result = mysqli_query($link,$jobs_query) or exit("No Jobs Found");
                    while($row = mysqli_fetch_array($jobs_result)){
                        $flag = 1;
                        $job_no_r= $row['input_job_no_random_ref'];
                        $job_no  = $row['input_job_no'];
                        $doc_str = rtrim($row['doc_str'],',');
                        //$bun_str = $row['bun_str'];
                        $org_qty = $row['oqty'];
                        $rem_qty = $row['rqty'];
                        $module  = $row['assigned_module'];
                        $style   = $row['style'];
                        $schedule= $row['schedule'];
                        $color   = $row['color'];
                        $pre_opcode_query = "SELECT operation_code as op_code FROM $brandix_bts.tbl_style_ops_master 
                                             WHERE style='$style' and color='$color' 
                                             and operation_code < $op_code ORDER BY operation_order DESC LIMIT 1 ";
                        $pre_opcode_result = mysqli_query($link,$pre_opcode_query) or exit("Pre Operation not found");
                        while($row = mysqli_fetch_array($pre_opcode_result)){
                            $pre_op_code = $row['op_code'];
                        }
                        //getting the status of dockets with the pre ops code
                        $fail_dockets_query = "Select reported_status,remaining_qty from $bai_pro3.cps_log 
                                               Where doc_no in ($doc_str) and operation_code='$pre_op_code'";
                        //echo $fail_dockets_query;
                        $fail_dockets_result = mysqli_query($link,$fail_dockets_query) or exit("Cannot Get Reported Status");
                        while($row = mysqli_fetch_array($fail_dockets_result)){
                            if( $row['remaining_qty'] == 0 && $row['reported_status']=='F' ){
                                $flag = 0;
                            }else{
                                $flag = 1;
                                break;
                            }
                        }

                        if($flag == 0){
                            $url = 'index.php?r='.$_GET['r']."&job_no=$job_no_r&job=$job_no";
                            $counter++;
                            echo "<tr>";
                                echo "<td>$counter</td>"; 
                                echo "<td>$style</td>"; 
                                echo "<td>$schedule</td>";
                                echo "<td>J$job_no</td>";                   
                                echo "<td>$org_qty</td>";
                                echo "<td>$module</td>";
                                echo "<td>$doc_str</td>";
                                echo "<td>$rem_qty</td>";
                                echo "<td><a href='$url' onclick='return confirm_delete(event,this)' 
                                        class='btn btn-danger btn-sm'>Remove From IPS</a></td>";
                            echo "</tr>";
                        }
                    }
                    if($counter == 0){
                        echo "<tr><td colspan=9><div class='alert alert-danger'>No Data Found</div></td></tr>";
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


