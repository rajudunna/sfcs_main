<?php
$start_timestamp = microtime(true);
error_reporting(0);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
include($include_path.'\sfcs_app\common\config\rest_api_calls.php');
set_time_limit(1000000);

//details from config tool
//$facility_id = $global_facility_code;
$plant_code = $global_facility_code;
$company_num = $company_no;
$host= $api_hostname;
$port= $api_port_no;
$current_date = date('Y-m-d h:i:s');
$status ="'pending'" ;
//getting failure transactions from m3_transactions
 $get_operations="select operation_code from $brandix_bts.tbl_orders_ops_ref where operation_name='Laying'";
//echo $get_operations;
$sql_result111=mysqli_query($link, $get_operations) or exit("Operation ERROR".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row=mysqli_fetch_array($sql_result111))
{
  $operation=$row['operation_code'];
}

$transactions_query = "SELECT * from $bai_pro3.m3_bulk_transactions where response_status in ($status) and m3_trail_count < 4 ";
$transaction_result = mysqli_query($link, $transactions_query) or 
                    exit("Error at getting transactions".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row=mysqli_fetch_array($transaction_result))
{
    $flag='';
    $transaction_id = $row['id'];
    $mo_no = trim($row['mo_no']);
    $op_code = $row['m3_ops_code'];
    $workstation_id = $row['workstation_id'];
    $quantity = $row['quantity'];
    $reason = $row['reason'];
    $log_user = $row['log_user'];
    $api_type = $row['api_type'];
    $date_time = $row['date_time'];
    $cut_no = $row['remarks'];

    $api_date = date('Ymd',strtotime($date_time));
    $api_time = date('His',strtotime($date_time));

    //&RPDT=$api_date&RPTM=$api_time
    //based on reasons we identify rejections
   
    if($op_code == $operation)
    {
        $api_url = $host.":".$port."/m3api-rest/execute/PMS070MI/RptOperation?CONO=$company_num&FACI=$plant_code&MFNO=$mo_no&OPNO=$op_code&DPLG=$workstation_id&MAQA=$quantity&REMK=$transaction_id&RPDT=$api_date&RPTM=$api_time&DSP1=1&DSP2=1&DSP3=1&DSP4=1&EMNO=$cut_no";
      
        $api_data = $obj->getCurlAuthRequest1($api_url,$transaction_id);
        $decoded = json_decode($api_data,true);
        $type=$decoded['@type'];
        $code=$decoded['@code'];
        $message=$decoded['Message'];
       
        //validating response pass/fail and inserting log
        if($type!='ServerReturnedNOK')
        {
            //updating response status in m3_bulk_transactions
            $qry_m3_bulk_transactions="UPDATE $bai_pro3.m3_bulk_transactions SET response_status='pass' WHERE id=".$transaction_id;
            mysqli_query($link,$qry_m3_bulk_transactions) or exit("While updating into qry_m3_bulk_transactions".mysqli_error($GLOBALS["___mysqli_ston"]));
            $qry_m3_transactions="UPDATE $bai_pro3.m3_transactions SET response_status='pass' WHERE m3_bulk_tran_id=".$transaction_id;
            mysqli_query($link,$qry_m3_transactions) or exit("While updating into qry_m3_transactions".mysqli_error($GLOBALS["___mysqli_ston"]));
        }
        else
        {
            //incrementing the m3_trail_count in m3_bulk_transactions
            $update_query = "UPDATE $bai_pro3.m3_bulk_transactions set m3_trail_count = m3_trail_count + 1,response_status='fail' where id=$transaction_id ";
            mysqli_query($link,$update_query) or exit('Theres an Error while Updaitng m3_bulk_transactions');
            $update_query_m3_trans = "UPDATE $bai_pro3.m3_transactions set m3_trail_count = m3_trail_count + 1,response_status='fail' where m3_bulk_tran_id=$transaction_id";
            mysqli_query($link,$update_query_m3_trans) or exit('Theres an Error while update_query_m3_trans');
            //insert transactions details into transactions_log
            $qry_transactionslog="INSERT INTO $brandix_bts.`transactions_log` (`transaction_id`,`response_message`,`created_by`,`created_at`) VALUES ('$transaction_id','$message','$log_user','$current_date')"; 
            mysqli_query($link,$qry_transactionslog) or exit("While inserting into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
        }
    }else{
        if(strlen($reason)>0)
        {
            //api for rejection quantities
            //M3 Rest API Call
            if ($api_type == 'fg')
            {
                // fg rejected
                $api_url = $host.":".$port."/m3api-rest/execute/PMS050MI/RptReceipt?CONO=$company_num&FACI=$plant_code&MFNO=$mo_no&RPQA=$quantity&REMK=$transaction_id&RPDT=$api_date&RPTM=$api_time&DSP1=1&DSP2=1&DSP3=1&DSP4=1&DSP5=1";
            }
            else if ($api_type == 'opn')
            {
                $api_url = $host.":".$port."/m3api-rest/execute/PMS070MI/RptOperation?CONO=$company_num&FACI=$plant_code&MFNO=$mo_no&REMK=$transaction_id&OPNO=$op_code&DPLG=$workstation_id&SCQA=$quantity&MAQA=$quantity&SCRE=$reason&RPDT=$api_date&RPTM=$api_time&DSP1=1&DSP2=1&DSP3=1&DSP4=1";
            }

            else
            {
                $flag = 1;
            }

            if ($flag == 1)
            {
                echo "No api_type for transaction id = ".$transaction_id;
            }
            else
            {
                $api_data = $obj->getCurlAuthRequest1($api_url,$transaction_id);
                $decoded = json_decode($api_data,true);
                $type=$decoded['@type'];
                $code=$decoded['@code'];
                $message=$decoded['Message'];
              
                //validating response pass/fail and inserting log
                if($type!='ServerReturnedNOK')
                {
                    //updating response status in m3_bulk_transactions
                    $qry_m3_bulk_transactions="UPDATE $bai_pro3.m3_bulk_transactions SET response_status='pass' WHERE id=".$transaction_id;
                    mysqli_query($link,$qry_m3_bulk_transactions) or exit("While updating into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $qry_m3_transactions="UPDATE $bai_pro3.m3_transactions SET response_status='pass' WHERE m3_bulk_tran_id=".$transaction_id;
                    mysqli_query($link,$qry_m3_transactions) or exit("While updating into qry_m3_transactions".mysqli_error($GLOBALS["___mysqli_ston"]));

                }
                else
                {
                    //incrementing the m3_trail_count in m3_bulk_transactions
                    $update_query = "UPDATE $bai_pro3.m3_bulk_transactions set m3_trail_count = m3_trail_count + 1,response_status='fail' where id=$transaction_id ";
                    mysqli_query($link,$update_query) or exit('Theres an Error while Updaitng m3_trans');
                    $update_query_m3_trans = "UPDATE $bai_pro3.m3_transactions set m3_trail_count = m3_trail_count + 1,response_status='fail' where m3_bulk_tran_id=$transaction_id";
                    mysqli_query($link,$update_query_m3_trans) or exit('Theres an Error while update_query_m3_trans');
                    //insert transactions details into transactions_log
                    $qry_transactionslog="INSERT INTO $brandix_bts.`transactions_log` (`transaction_id`,`response_message`,`created_by`,`created_at`) VALUES ('$transaction_id','$message','$log_user','$current_date')"; 
                    mysqli_query($link,$qry_transactionslog) or exit("While inserting into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
                }
                
            }  
        }
        else
        {
            //api for good quantities        
            //M3 Rest API Call
            if ($api_type == 'fg')
            {
                // fg good report
                $api_url = $host.":".$port."/m3api-rest/execute/PMS050MI/RptReceipt?CONO=$company_num&FACI=$plant_code&MFNO=$mo_no&RPQA=$quantity&REMK=$transaction_id&RPDT=$api_date&RPTM=$api_time&DSP1=1&DSP2=1&DSP3=1&DSP4=1&DSP5=1";
            }
            else if ($api_type == 'opn')
            {
                $api_url = $host.":".$port."/m3api-rest/execute/PMS070MI/RptOperation?CONO=$company_num&FACI=$plant_code&MFNO=$mo_no&OPNO=$op_code&DPLG=$workstation_id&MAQA=$quantity&REMK=$transaction_id&RPDT=$api_date&RPTM=$api_time&DSP1=1&DSP2=1&DSP3=1&DSP4=1";
            }
            else
            {
                $flag = 1;
            }

            if ($flag == 1)
            {
                echo "No api_type for transaction id = ".$transaction_id;
            }
            else
            {
                $api_data = $obj->getCurlAuthRequest1($api_url,$transaction_id);
                $decoded = json_decode($api_data,true);
                $type=$decoded['@type'];
                $code=$decoded['@code'];
                $message=$decoded['Message'];
                
                //validating response pass/fail and inserting log
                if($type!='ServerReturnedNOK')
                {
                    //updating response status in m3_bulk_transactions
                    $qry_m3_bulk_transactions="UPDATE $bai_pro3.m3_bulk_transactions SET response_status='pass' WHERE id=".$transaction_id;
                    mysqli_query($link,$qry_m3_bulk_transactions) or exit("While updating into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));

                    $qry_m3_transactions="UPDATE $bai_pro3.m3_transactions SET response_status='pass' WHERE m3_bulk_tran_id=".$transaction_id;
                    mysqli_query($link,$qry_m3_transactions) or exit("While updating into qry_m3_transactions".mysqli_error($GLOBALS["___mysqli_ston"]));
                }
                else
                {
                    //incrementing the m3_trail_count in m3_bulk_transactions
                    $update_query = "UPDATE $bai_pro3.m3_bulk_transactions set m3_trail_count = m3_trail_count + 1,response_status='fail' where id=$transaction_id ";
                    mysqli_query($link,$update_query) or exit('Theres an Error while Updaitng m3_trans');
                    $update_query_m3_trans = "UPDATE $bai_pro3.m3_transactions set m3_trail_count = m3_trail_count + 1,response_status='fail' where m3_bulk_tran_id=$transaction_id";
                    mysqli_query($link,$update_query_m3_trans) or exit('Theres an Error while update_query_m3_trans');
                    //insert transactions details into transactions_log
                    $qry_transactionslog="INSERT INTO $brandix_bts.`transactions_log` (`transaction_id`,`response_message`,`created_by`,`created_at`) VALUES ('$transaction_id','$message','$log_user','$current_date')"; 
                    mysqli_query($link,$qry_transactionslog) or exit("While inserting into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
                }
            } 
        }
    }
}
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." seconds.");
?>

