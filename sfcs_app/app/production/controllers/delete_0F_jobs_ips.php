
<?php  
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');  
    $ips = 'IPS';    
    $status = "'0','F'";
?>
<div class='panel panel-primary'>
    <div class='panel-heading'>
        Delete Failed Sewing Jobs Manually 
    </div>
    <div class='panel-body'>
        <table class='table table-bordered'>
            <thead>
                <tr class='info'>
                    <th>Sno</th>
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
                    $op_code_query = "Select operation_code from $brandix_bts.tbl_ims_ops where appilication = '$ips' ";
                    $op_code_result = mysqli_query($link,$op_code);
                    while($row = mysqli_fetch_array($op_code_result)){
                        $op_code = $row['operation_code'];
                    }

                    //getting dockets with 0,F status
                    $fail_dockets_query = "select doc_no from $bai_pro3.cps_log where reported_status IN ($status)";
                    $fail_dockets_result = mysqli_query($link,$fail_dockets_query);
                    while($row = mysqli_fetch_array($fail_dockets_result)){
                        $dockets[] = $row['doc_no'];
                    }
                    $dockets = array_unique($dockets);
                    $dockets_str = implode(',',$dockets);
                    
                    //getting all jobs with the above dockets
                    $jobs_query = "Select input_job_no,input_job_no_random_ref,group_concat(docket_number) as doc_str,
                                   group_concat(bundle_number) as bun_str,SUM(original_qty) as oqty,
                                   SUM(recevied_qty) as rqty,assigned_module 
                                   from $brandix_bts.bundle_creation_data 
                                   where docket_number IN ('$dockets_str') 
                                   and operation_id = '$op_code'
                                   GROUP BY input_job_no_random_ref";
                    //echo $jobs_query;               
                    $jobs_result = mysqli_query($link,$jobs_query) or exit("No Jobs Found");
                    while($row = mysqli_fetch_array($jobs_result)){
                        $flag = 0;
                        $job_no_r= $row['input_job_no_random_ref'];
                        $job_no  = $row['input_job_no'];
                        $doc_str = $row['doc_str'];
                        $bun_str = $row['bun_str'];
                        $org_qty = $row['oqty'];
                        $rem_qty = $row['rqty'];
                        $module  = $row['assigned_module'];


                        $docs = explode(',',$doc_str);
                        $docs = array_unique($docs);
                        /*
                        $bundles = explode(',',$bun_str);
                        $bundles = array_unique($bundles);
                        $bundles = implode(',',$bun_str);
                        */
                        $comparision_query  = "Select original_qty as org,SUM(recevied_qty + rejected_qty) as total from 
                                               $brandix_bts.bundle_creation_data where bundle_number in ($bun_str)";
                        $comparision_result = mysqli_query($link,$comparision_query) or exit("Problem Encountered In Retreiving ");
                        while($row = mysqli_fetch_array($comparision_result)){
                            if( !($row['org'] == $row['total']) )
                                $flag = 1;
                        }
                        
                        if($flag == 0){
                            $vary = array_diff($dockets,$docs);
                            $url = 'index.php?r='.$_GET['r']."&job_no=$job_no_r";
                            if(!sizeof($vary) > 0){
                                $counter++;
                                echo "<tr>";
                                    echo "<td>$counter</td>"; 
                                    echo "<td>J$job_no</td>";
                                    echo "<td>$org_qty</td>";
                                    echo "<td>$module</td>";
                                    echo "<td>".implode(',',$doc_str)."</td>";
                                    echo "<td>$rem_qty</td>";
                                    echo "<td><a href='$url' onclick='return confirm_delete(event,this)' 
                                            class='btn btn-danger btn-sm'>Delete</a></td>";
                                echo "</tr>";
                            }
                        }
                    }
                    if($counter == 0){
                        echo "<td colspan=7><div class='alert alert-danger'>No Data Found</div></td>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>


<?php
if( isset($_GET['job_no']) && $_GET['job_no']!=''){
    $job = $_GET['job_no'];
    $delete_query = "Delete from $bai_pro3.plan_dash_doc_summ_input where input_job_no_random_ref='$job'" ;
    $delete_result = mysqli_query($link,$delete_query) or exit("Problem Encountered While Deleting The Job");
    if($delete_result){
        echo "<script>swal('Input Job Deleted Successfully','','success');</script>";
    }
}


?>

<script>
    function confirm_delete(e,t)
    {
        e.preventDefault();
        var v = sweetAlert({
            title: "Are you sure to Delete the Packing Ratio?",
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


