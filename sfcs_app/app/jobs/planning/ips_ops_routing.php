<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
ini_set('max_execution_time', '500000');
// error_reporting(E_ALL);

$application='IPS';
$scanning_query=" select operation_code from $brandix_bts.tbl_ims_ops where appilication='$application'";
$scanning_result=mysqli_query($link, $scanning_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($scanning_result))
{
    $ips_ops_routing=$sql_row['operation_code'];
}
$appilication_out = "IMS_OUT";
$checking_output_ops_code_out = "SELECT operation_code from $brandix_bts.tbl_ims_ops where appilication='$appilication_out'";
$result_checking_output_ops_code_out = $link->query($checking_output_ops_code_out);
if($result_checking_output_ops_code_out->num_rows > 0)
{
    while($row_result_checking_output_ops_code_out = $result_checking_output_ops_code_out->fetch_assoc()) 
    {
        $output_ops_code_out = $row_result_checking_output_ops_code_out['operation_code'];
    }
}
else
{
    $output_ops_code_out = 130;
}
//uncomment this for developer testing
// $style = 'CNB1396G';
// $color = '026JKZ-HICKORY PLAID BLACK';
// $schedule = '667111';

// $get_style_color_query="SELECT order_style_no as style,order_col_des as color,order_del_no as schedule FROM $bai_pro3.packing_summary_input where order_style_no='$style' and order_col_des='$color' and order_del_no='$schedule' limit 1";

//uncomment this query during developer testing
$get_style_color_query="SELECT order_style_no as style,order_col_des as color,order_del_no as schedule FROM $bai_pro3.packing_summary_input GROUP BY order_style_no,order_col_des,order_del_no";
echo $get_style_color_query.'<br/>';
$get_style_color_query_result=mysqli_query($link, $get_style_color_query) or exit("Sql Error212".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row=mysqli_fetch_array($get_style_color_query_result))
{
    $style=$row['style'];
    $color=$row['color'];
    $schedule=$row['schedule'];
    if($ips_ops_routing == 'Auto') {
        $qry_ips_ops_mapping = "SELECT tsm.operation_code AS operation_code FROM brandix_bts.tbl_style_ops_master tsm LEFT JOIN brandix_bts.tbl_orders_ops_ref tor ON tor.id=tsm.operation_name WHERE style='$style' AND color='$color' AND tor.display_operations='yes' AND tor.category='sewing' GROUP BY tsm.operation_code ORDER BY tsm.operation_order LIMIT 1";
        $result_qry_ips_ops_mapping = $link->query($qry_ips_ops_mapping);
        while($sql_row1=mysqli_fetch_array($result_qry_ips_ops_mapping))
        {
            $operation_code_routing=$sql_row1['operation_code'];
        }
    } else{
        $operation_code_routing = $ips_ops_routing;
    }
     //*To get previous Operation
    $ops_sequence_check = "select id,ops_sequence,ops_dependency,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code=$output_ops_code_out";
    //echo $ops_sequence_check;b_op_id
    $result_ops_sequence_check = $link->query($ops_sequence_check);
    while($row2 = $result_ops_sequence_check->fetch_assoc()) 
    {
        $ops_seq = $row2['ops_sequence'];
        $seq_id = $row2['id'];
        $ops_order = $row2['operation_order'];
    }

    $pre_operation_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) < '$ops_order' and operation_code NOT IN  (10,200) ORDER BY operation_order DESC LIMIT 1";
    // echo  $pre_operation_check;
    $result_pre_operation_check = $link->query($pre_operation_check);
    while($row23 = $result_pre_operation_check->fetch_assoc()) 
    {
        $previous_operation = $row23['operation_code'];
    }

    $get_ims="SELECT operation_id FROM $bai_pro3.ims_log where ims_style='$style' and ims_color='$color' and ims_schedule='$schedule' limit 1";
    // echo $get_ims.'<br/>';
    $get_ims_result=mysqli_query($link, $get_ims) or exit("Sql Error222".mysqli_error($GLOBALS["___mysqli_ston"]));
    if(mysqli_num_rows($get_ims_result) > 0) {
        while($ims_row=mysqli_fetch_array($get_ims_result))
        {
            $ims_operation =$ims_row['operation_id'];
        }
    } else {
        $get_ims_bkp="SELECT operation_id FROM $bai_pro3.ims_log_backup where ims_style='$style' and ims_color='$color' and ims_schedule='$schedule' limit 1";
        $get_ims_bkp_result=mysqli_query($link, $get_ims_bkp) or exit("Sql Error223".mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($get_ims_bkp_result) > 0) {
            while($ims_row=mysqli_fetch_array($get_ims_bkp_result))
            {
                $ims_operation =$ims_row['operation_id'];
            }
        } else {
            $ims_operation = 0;
        }
    }
    echo $ims_operation.'ims_operation<br/>';
    echo $operation_code_routing.'operation_code_routing<br/>';

    if($ims_operation != $operation_code_routing){
        $get_bcd="SELECT * FROM $brandix_bts.bundle_creation_data where style='$style' and color='$color' and schedule='$schedule' and operation_id=$operation_code_routing AND send_qty>0 AND (recevied_qty+rejected_qty) > 0";
        
        echo $get_bcd."<br>";
        $get_bcd_result=mysqli_query($link, $get_bcd) or exit("Sql Error242".mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($get_bcd_result) > 0) {
            while($bcd_row=mysqli_fetch_array($get_bcd_result))
            {
                $bundle_number =$bcd_row['bundle_number'];
                $original_qty =$bcd_row['original_qty'];
                $send_qty =$bcd_row['send_qty'];
                $recevied_qty =$bcd_row['recevied_qty'];
                $rejected_qty =$bcd_row['rejected_qty'];
                $operation_id =$bcd_row['operation_id'];
                $size_id = 'a_'.$bcd_row['size_id'];
                $schedule =$bcd_row['schedule'];
                $scanned_date = $bcd_row['scanned_date'];
                $docket_number =$bcd_row['docket_number'];
                $assigned_module =$bcd_row['assigned_module'];
                $shift =$bcd_row['shift'];
                $input_job_no =$bcd_row['input_job_no'];
                $input_job_no_random_ref =$bcd_row['input_job_no_random_ref'];
                $schedule =$bcd_row['schedule'];
                $remarks =$bcd_row['remarks'];
                echo $bundle_number.'bundle_number<br/>';

                
                $get_qty_details1="select sum(if(operation_id = $previous_operation,send_qty,0)) as input,sum(if(operation_id = $previous_operation,replace_in,0)) as replace_in,sum(if(operation_id = $previous_operation,recut_in,0)) as recut_in,sum(if(operation_id = $previous_operation,rejected_qty,0)) as input_rej,sum(if(operation_id = $output_ops_code_out,recevied_qty,0)) as output,sum(if(operation_id = $output_ops_code_out,rejected_qty,0)) as output_rej From $brandix_bts.bundle_creation_data where  bundle_number=$bundle_number";
                //echo $get_qty_details1;
                $get_qty_result1=mysqli_query($link,$get_qty_details1) or exit("barcode status Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($qty_details1=mysqli_fetch_array($get_qty_result1))
                {
                    $previous_ops_send_qty = $qty_details1['input']+$qty_details1['replace_in']+$qty_details1['recut_in'];
                    $previous_ops_rej_qty = $qty_details1['input_rej'];
                    $recevied_qty_out =$qty_details1['output'];
                    $ims_operation_out_qty = $qty_details1['output'] + $qty_details1['output_rej'];
                }
                
                if($previous_ops_rej_qty > 0)
                {
                    $input_final_qty = $previous_ops_send_qty - $previous_ops_rej_qty;
                }
                else
                {
                    $input_final_qty = $previous_ops_send_qty;
                } 

                $ims_status = '';
                if($ims_operation_out_qty > 0) {
                    if($input_final_qty == $ims_operation_out_qty)
                    {
                        $ims_status = 'DONE';
                    }
                } 
           
                $bundle_op_id=$bundle_number."-".$operation_id."-".$input_job_no.'-'.$remarks;

                $cat_ref=0;
                $catrefd_qry="select cat_ref FROM $bai_pro3.plandoc_stat_log WHERE order_tid in (select order_tid FROM bai_pro3.bai_orders_db WHERE order_style_no='$style' AND order_del_no='$schedule' AND order_col_des='$color')";
                // echo $catrefd_qry.'<br/>';
                $catrefd_qry_result=mysqli_query($link,$catrefd_qry);
                while($buyer_qry_row=mysqli_fetch_array($catrefd_qry_result))
                {
                    $cat_ref=$buyer_qry_row['cat_ref'];
                }

                $get_rep_ims="SELECT * FROM $bai_pro3.ims_log where pac_tid=".$bundle_number;
                // echo $get_rep_ims.'<br/>';
                $get_rep_ims_result=mysqli_query($link, $get_rep_ims) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
                if(mysqli_num_rows($get_rep_ims_result) > 0) {
                    $update_status_query = "update $bai_pro3.ims_log set ims_qty = $recevied_qty,ims_pro_qty = $recevied_qty_out,operation_id = $operation_id,ims_status = '$ims_status',bai_pro_ref='".$bundle_op_id."' where pac_tid = ".$bundle_number;
                    // echo $update_status_query.'<br/>';
                        mysqli_query($link,$update_status_query) or exit("While updating status in ims_log5".mysqli_error($GLOBALS["___mysqli_ston"]));
                } else {
                    $get_rep_ims_bkp="SELECT * FROM $bai_pro3.ims_log_backup where pac_tid=".$bundle_number;
                    // echo $get_rep_ims_bkp.'<br/>';
                    $get_rep_ims_bkp_result=mysqli_query($link, $get_rep_ims_bkp) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if(mysqli_num_rows($get_rep_ims_bkp_result) == 0) {
                        if($recevied_qty > 0) {
                            $insert_imslog="insert into $bai_pro3.ims_log (ims_date,ims_cid,ims_doc_no,ims_mod_no,ims_shift,ims_size,ims_qty,ims_pro_qty,ims_log_date,ims_style,ims_schedule,ims_color,rand_track,bai_pro_ref,input_job_rand_no_ref,input_job_no_ref,pac_tid,ims_remarks,operation_id,ims_status) values ('".$scanned_date."','".$cat_ref."','".$docket_number."','".$assigned_module."','".$shift."','".$size_id."','".$recevied_qty."','".$recevied_qty_out."','".$scanned_date."','".$style."','".$schedule."','".$color."','".$docket_number."','".$bundle_op_id."','".$input_job_no_random_ref."','".$input_job_no."','".$bundle_number."','".$remarks."','".$operation_id."','".$ims_status."')";
                            // echo $insert_imslog.'<br/>';
                            mysqli_query($link,$insert_imslog) or exit("While updating status in ims_log3".mysqli_error($GLOBALS["___mysqli_ston"]));
                        }
                    }
                }
                $get_rep_ims_bkp="SELECT * FROM $bai_pro3.ims_log_backup where pac_tid=".$bundle_number;
                // echo $get_rep_ims_bkp.'<br/>';
                $get_rep_ims_bkp_result=mysqli_query($link, $get_rep_ims_bkp) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
                if(mysqli_num_rows($get_rep_ims_bkp_result) > 0) {
                    if($recevied_qty > 0){
                        $update_ims_bkp = "update $bai_pro3.ims_log_backup set ims_qty = $recevied_qty,ims_pro_qty = $recevied_qty_out,operation_id = $operation_id,bai_pro_ref='".$bundle_op_id."' where pac_tid = $bundle_number";
                        // echo $update_ims_bkp.'<br/>';
                        mysqli_query($link,$update_ims_bkp) or exit("While updating status in ims_log_backup1".mysqli_error($GLOBALS["___mysqli_ston"]));
                    } else {
                        $ims_log_delete="delete from $bai_pro3.ims_log_backup where operation_id=$ims_operation and pac_tid=$bundle_number";
                        // echo $ims_log_delete.'<br/>';
                        mysqli_query($link,$ims_log_delete) or exit("While Delete".mysqli_error($GLOBALS["___mysqli_ston"]));
                    }
                    
                }
            }
            $ims_backup_up="insert into $bai_pro3.ims_log_backup select * from $bai_pro3.ims_log where ims_style='$style' and ims_color='$color' and ims_schedule='$schedule' and ims_status='DONE' and operation_id=$operation_code_routing";
            // echo $ims_backup_up.'<br/>';
            mysqli_query($link,$ims_backup_up) or exit("Error while inserting into ims_backup".mysqli_error($GLOBALS["___mysqli_ston"]));

            $ims_delete="delete from $bai_pro3.ims_log where ims_style='$style' and ims_color='$color' and ims_schedule='$schedule' and ims_status='DONE' and operation_id=$operation_code_routing";
            // echo $ims_delete.'<br/>';
            mysqli_query($link,$ims_delete) or exit("While De".mysqli_error($GLOBALS["___mysqli_ston"]));
        }
        
        $get_bcd_del="SELECT * FROM $brandix_bts.bundle_creation_data where style='$style' and color='$color' and schedule='$schedule' and operation_id=$operation_code_routing AND (recevied_qty+rejected_qty) = 0";
        // echo $get_bcd_del."<br>";
        $get_bcd_del_result=mysqli_query($link, $get_bcd_del) or exit("Sql Error242".mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($get_bcd_del_result) > 0) {
            while($bcd_del_row=mysqli_fetch_array($get_bcd_del_result))
            {
                $pac_tid=$bcd_del_row['bundle_number'];
                $ims_log_delete="delete from $bai_pro3.ims_log where operation_id=$ims_operation and pac_tid=$pac_tid";
                // echo $ims_log_delete.'<br/>';
                mysqli_query($link,$ims_log_delete) or exit("While Delete".mysqli_error($GLOBALS["___mysqli_ston"]));
            }
        }


        //plan dashboard input
        $get_job_query="SELECT input_job_no_random FROM $bai_pro3.packing_summary_input WHERE order_style_no='$style' AND order_col_des='$color' AND order_del_no='$schedule' GROUP BY input_job_no_random";
        $get_job_query_result=mysqli_query($link, $get_job_query) or exit("Sql Error212".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($job_row=mysqli_fetch_array($get_job_query_result))
        {
            $input_job_num = $job_row['input_job_no_random'];
            echo $input_job_num.'input_job_num<br/>';
            $sql="SELECT COALESCE(SUM(recevied_qty),0) AS rec_qty,COALESCE(SUM(rejected_qty),0) AS rej_qty,COALESCE(SUM(original_qty),0) AS org_qty,COALESCE(SUM(replace_in),0) AS replace_qty FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = '".$input_job_num."' AND operation_id = $operation_code_routing";
            $sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
            //if planned
            if(mysqli_num_rows($sql_result) > 0)
            {
                while($sql_row=mysqli_fetch_array($sql_result))
                {
                    $rec_qty1=$sql_row["rec_qty"];
                    $rej_qty1=$sql_row["rej_qty"];
                    $orginal_qty=$sql_row["org_qty"];
                    $replace_in_qty=$sql_row["replace_qty"];
                }
                if($orginal_qty > 0)
                {
                    if(($orginal_qty+$replace_in_qty)==($rec_qty1+$rej_qty1)) 
                    {
                        $sql_check="select input_job_no_random_ref from $bai_pro3.plan_dashboard_input_backup where input_job_no_random_ref='".$input_job_num."'";
                        $sql_check_res=mysqli_query($link, $sql_check) or exit("Sql Error11212".mysqli_error($GLOBALS["___mysqli_ston"]));
                        if(mysqli_num_rows($sql_check_res)==0)
                        {
                            $backup_query="INSERT INTO $bai_pro3.plan_dashboard_input_backup SELECT * FROM $bai_pro3.`plan_dashboard_input` WHERE input_job_no_random_ref='".$input_job_num."'";
                            mysqli_query($link, $backup_query) or exit("Error while saving backup plan_dashboard_input_backup");
                        }
                        $sqlx="delete from $bai_pro3.plan_dashboard_input where input_job_no_random_ref='".$input_job_num."'";
                        mysqli_query($link, $sqlx) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));	
                    } else {
                        $sql_check="select input_job_no_random_ref from $bai_pro3.plan_dashboard_input where input_job_no_random_ref='".$input_job_num."'";
                        $sql_check_res=mysqli_query($link, $sql_check) or exit("Sql Error11212".mysqli_error($GLOBALS["___mysqli_ston"]));
                        if(mysqli_num_rows($sql_check_res)==0)
                        {
                            $backup_query="INSERT INTO $bai_pro3.plan_dashboard_input SELECT * FROM $bai_pro3.`plan_dashboard_input_backup` WHERE input_job_no_random_ref='".$input_job_num."' order by input_trims_status desc limit 1";
                            mysqli_query($link, $backup_query) or exit("Error while saving backup plan_dashboard_input_backup");
                        }
                        $sqlx="delete from $bai_pro3.plan_dashboard_input_backup where input_job_no_random_ref='".$input_job_num."'";
                        mysqli_query($link, $sqlx) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));	
                    }
                }
            }

        }

    }
}

?>