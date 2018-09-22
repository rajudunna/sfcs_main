
<?php  
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');  
    $start_timestamp = microtime(true);
    $include_path=getenv('config_job_path');
	include( $include_path.'/sfcs_app/common/config/config_jobs.php');
    include( $include_path.'/sfcs_app/common/config/rest_api_calls.php');
    $ips = 'IPS';    

$append.="<table border=1>
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
            <tbody>";
        
            //getting the operation code from the masters table
            $counter = 0;
            $op_code_query = "Select operation_code from $brandix_bts.tbl_ims_ops where appilication = '$ips' ";
            $op_code_result = mysqli_query($link,$op_code);
            while($row = mysqli_fetch_array($op_code_result)){
                $op_code = $row['operation_code'];
            }

            //getting dockets with 0,F status
            $fail_dockets_query = "select doc_no from $bai_pro3.cps_log where reported_status IN (0,F)";
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
                        $append.= "<tr>";
                        $append.= "<td>$counter</td>"; 
                        $append.= "<td>J$job_no</td>";
                        $append.= "<td>$org_qty</td>";
                        $append.= "<td>$module</td>";
                        $append.= "<td>".implode(',',$doc_str)."</td>";
                        $append.= "<td>$rem_qty</td>";
                        $append.= "</tr>";
                    }
                }
            }
            if($counter == 0){
                echo "<td colspan=4><div class='alert alert-danger'>No Data Found</div></td>";
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
    $message.= "<h2>Sewing Jobs Details</h2>"; 
    $message.= $append;
    $message.= "<br/><br/>Message Sent Via:".$plant_name."</body> 
    </html>";
    echo $message;
    $to  ="nalamrajesh@gmail.com"; 
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