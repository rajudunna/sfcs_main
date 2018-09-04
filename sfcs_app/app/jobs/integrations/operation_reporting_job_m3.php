<?php
$start_timestamp = microtime(true);
error_reporting(0);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
//include($include_path.'\sfcs_app\common\config\rest_api_calls.php');
set_time_limit(1000000);

//details from config tool
$facility_id = $global_facility_code;
$company_num = $company_no;
$host= $api_hostname;
$port= $api_port_no;
$current_date = date('Y-m-d h:i:s');

//getting failure transactions from m3_transactions
$transctions = "SELECT id FROM bai_pro3.m3_transactions LEFT JOIN brandix_bts.transactions_log ON brandix_bts.transactions_log.transaction_id=bai_pro3.m3_transactions.id WHERE response_status='fail' GROUP BY transaction_id";
$transaction_result = mysqli_query($link, $transctions) or exit("Error at getting transactions".mysqli_error($GLOBALS["___mysqli_ston"]));
while($records=mysqli_fetch_array($transaction_result))
{
    $transaction_id = $records['id'];  
    //based on transaction id we will get the transaction details 
    $transactions_details = "SELECT mo_no,op_code,workstation_id,quantity,reason,log_user FROM $bai_pro3.m3_transactions where id=".$transaction_id;
    $transactions_details_result = mysqli_query($link, $transactions_details) or exit("Error at getting m3 transactions".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row=mysqli_fetch_array($transactions_details_result))
    {
        $mo_no = $row['mo_no'];
        $op_code = $row['op_code'];
        $workstation_id = $row['workstation_id'];
        $quantity = $row['quantity'];
        $reason = $row['reason'];
        $log_user = $row['log_user'];
    }
    //getting transactions from m3 transaction table which are not 
    $transactions_log_details = "SELECT transaction_id FROM $brandix_bts.transactions_log where transaction_id=".$transaction_id;
    $transactions_log_details_result = mysqli_query($link, $transactions_log_details) or exit("Error at getting transaction logs".mysqli_error($GLOBALS["___mysqli_ston"]));
    $rowscount = mysqli_num_rows($transactions_log_details_result);
    //if rowscount is <=3 then we are calling the API
    if($rowscount<=3){
        //based on reasons we identify rejections
        if(strlen($reason)>0){
            //api for rejection quantities
            //M3 Rest API Call
            $api_url = $host.":".$port."/m3api-rest/execute/PMS070MI/RptOperation?CONO=$company_num&FACI=$plant_code&MFNO=$mo_no&OPNO=$op_code&DPLG=$workstation_id&MAQA=''&SCQA=$quantity&SCRE='$reason'&DSP1=1&DSP2=1&DSP3=1&DSP4=1";
            $api_data = $obj->getCurlAuthRequest($api_url);
            $decoded = json_decode($api_data,true);
            $type=$decoded['@type'];
            $code=$decoded['@code'];
            $message=$decoded['Message'];

            //validating response pass/fail and inserting log
            if($type!='ServerReturnedNOK'){
                //updating response status in m3_transactions
                $qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='pass' WHERE id=".$transaction_id;
                mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));

            }else{          
                //insert transactions details into transactions_log
                $qry_transactionslog="INSERT INTO $brandix_bts.`transactions_log` (`transaction_id`,`response_message`,`created_by`,`created_at`) VALUES ('$transaction_id',$message,$log_user,$current_date)"; 
                mysqli_query($link,$qry_transactionslog) or exit("While inserting into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
            }

        }else{
            //api for good quantities        
            //M3 Rest API Call
            $api_url = $host.":".$port."/m3api-rest/execute/PMS070MI/RptOperation?CONO=$company_num&FACI=$plant_code&MFNO=$mo_no&OPNO=$op_code&DPLG=$workstation_id&MAQA=$quantity&SCQA=''&SCRE=''&DSP1=1&DSP2=1&DSP3=1&DSP4=1";
            $api_data = $obj->getCurlAuthRequest($api_url);
            $decoded = json_decode($api_data,true);
            $type=$decoded['@type'];
            $code=$decoded['@code'];
            $message=$decoded['Message'];

            //validating response pass/fail and inserting log
            if($type!='ServerReturnedNOK'){
                //updating response status in m3_transactions
                $qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='pass' WHERE id=".$transaction_id;
                mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));

            }else{          
                //insert transactions details into transactions_log
                $qry_transactionslog="INSERT INTO $brandix_bts.`transactions_log` (`transaction_id`,`response_message`,`created_by`,`created_at`) VALUES ('$transaction_id',$message,$log_user,$current_date)"; 
                mysqli_query($link,$qry_transactionslog) or exit("While inserting into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
            }
        }
    }
}
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." seconds.");
?>