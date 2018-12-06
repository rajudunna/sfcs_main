
<?php  
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');  
    $start_timestamp = microtime(true);
    $include_path=getenv('config_job_path');
	include( $include_path.'/sfcs_app/common/config/config_jobs.php');
    include( $include_path.'/sfcs_app/common/config/rest_api_calls.php');   
    $application = 'IPS';
    $status = 'F';
    $append = '';
    $append.="<table border=1>
            <thead>
                <tr class='info'>
                    <th>Sno</th>
                    <th>Job No</th>
                    <th>Original Qty</th>
                    <th>Module</th>
                    <th>Docket No's</th>
                    <th>Received Qty</th>
                </tr>
            </thead>
            <tbody>";
    
            //getting the operation code from the masters table
            $counter = 0;
            $op_code_query = "Select operation_code from $brandix_bts.tbl_ims_ops where appilication = '$application' ";
            $op_code_result = mysqli_query($link,$op_code_query);
            while($row = mysqli_fetch_array($op_code_result)){
                $op_code = $row['operation_code'];
            }

            //getting dockets with 0,F status
            $fail_dockets_query = "select doc_no from $bai_pro3.cps_log where remaining_qty = 0
                                    and reported_status = '$status'";
            $fail_dockets_result = mysqli_query($link,$fail_dockets_query);
            while($row = mysqli_fetch_array($fail_dockets_result)){
                $dockets[] = $row['doc_no'];
            }
          
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
                $flag = 0;
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
                                        and operation_code < $op_code ORDER BY operation_order DESC LIMIT 1";
                $pre_opcode_result = mysqli_query($link,$pre_opcode_query);
                while($row = mysqli_fetch_array($pre_opcode_result)){
                    $pre_op_code = $row['op_code'];
                }
                //getting the status of dockets with the pre ops code
                $fail_dockets_query = "Select reported_status,remaining_qty from $bai_pro3.cps_log 
                                        Where doc_no in ($doc_str) and operation_code='$pre_op_code'"; 
                $fail_dockets_result = mysqli_query($link,$fail_dockets_query);
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
                    $append.= "<tr>";
                    $append.= "<td>$counter</td>"; 
                    $append.= "<td>J$job_no</td>";
                    $append.= "<td>$org_qty</td>";
                    $append.= "<td>$module</td>";
                    $append.= "<td>$doc_str</td>";
                    $append.= "<td>$rem_qty</td>";
                    // $append.= "<td><a href='$url' onclick='return confirm_delete(event,this)' 
                    //             class='btn btn-danger btn-sm'>Delete</a></td>";
                    $append.= "</tr>";
                }
            }
            if($counter == 0){
                $append.= "<tr><td colspan=7><div class='alert alert-danger'>No Data Found</div></td></tr>";
            }
    $append.= "</tbody>
        </table>";
?>



<?php
 $message='<html> 
    <head> 
    <style type="text/css"> 
    body 
    { 
        background-color: WHITE; 
        font-size: 10pt; 
        color: BLACK; 
        font-style: normal; 
        font-family: Trebuchet MS; 
        text-decoration: none; 
    } 
    
    th 
    { 
        color: black; 
        border: 1px solid #660000; 
        padding: 5px; 
        white-space:nowrap;  
    } 
    
    td 
    { 
        background-color: WHITE; 
        color: BLACK; 
        border: 1px solid #660000; 
        padding: 1px; 
        white-space:nowrap;  
    } 
    table 
    { 
        border-collapse:collapse; 
        white-space:nowrap;  
    } 
    </style> 
    </head> 
    <body>'; 
    $message .="Dear User,";
    $message.= "<h2>Deleted Sewing Jobs Details</h2>"; 
    $message.= $append;
    $message.= "<br/><br/>Message Sent Via:".$plant_name."</body> 
    </html>";
    echo $message;
    $to  ="rajesh.nalam@schemaxtech.com"; 
    // subject 
    $subject = 'Jobs details whose status is F'; 
    // To send HTML mail, the Content-type header must be set 
    $headers  = 'MIME-Version: 1.0' . "\r\n"; 
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
    // $headers .= 'From: BEKSFCS Alert <yateesh603@gmail.com>'. "\r\n";
    $headers .= "From: ".$header_name." <".$header_mail.">". "\r\n";
  
    // Mail it 
    if(count($overall_details)>0){
        if(mail($to, $subject, $message, $headers)) 
        { 
            print("Email Sent Successfully")."\n"; 
        }else{
            print("Email Sent Failed")."\n"; 
        }
    }
    
    $end_timestamp = microtime(true);
    $duration = $end_timestamp - $start_timestamp;
    print("Execution took ".$duration." seconds.");


?>