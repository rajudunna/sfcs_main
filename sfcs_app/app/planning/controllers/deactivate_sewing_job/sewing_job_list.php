<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
$username = getrbac_user()['uname'];



if(isset($_POST['Save']))
{
    
    $status = 0;
    $module1 = array_unique($_POST['module']);
    $module = implode(",",$module1);
   
    foreach($_POST['style'] as $key => $value){
        if($_POST['remove_type'][$key] == '3'){
            $ims_date = $_POST['ims_date'][$key];
            $style = $_POST['style'][$key];
            $schedule = $_POST['schedule'][$key];
            $color = $_POST['color'][$key];
            $input_job_no = $_POST['input_job_no'][$key];
            $input_rand_ref = $_POST['input_rand_ref'][$key];
            $input_qty = $_POST['input_qty'][$key];
            $output_qty = $_POST['output_qty'][$key];
            $wip = $_POST['wip'][$key];
            $rejected_qty = $_POST['rejected_qty'][$key];
            $ims_remarks = $_POST['ims_remarks'][$key];
            // $module = $_POST['module'];
            $remove_type=$_POST['remove_type'][$key];
            $job_deacive = "SELECT * FROM $bai_pro3.`job_deactive_log` where schedule = '$schedule' and input_job_no='$input_job_no' and remove_type = '0'";
            $job_deacive_result=mysqli_query($link, $job_deacive) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
            $sql_num_check=mysqli_num_rows($job_deacive_result);
            if($sql_num_check>0){
                while($sql_row=mysqli_fetch_array($job_deacive_result))
                {
                    $reverse_deactive_job_id = $sql_row['id'];
                    $update_revers_qry = "update $bai_pro3.job_deactive_log set remove_type='$remove_type',input_qty='$input_qty',out_qty='$output_qty',rejected_qty='$rejected_qty',wip='$wip' where id=".$reverse_deactive_job_id;
                    $update_revers_qry_result = mysqli_query($link, $update_revers_qry) or exit("update error".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $deactive_job_id = $reverse_deactive_job_id;
                }
            } else {
                $job_deacive_hold = "SELECT * FROM $bai_pro3.`job_deactive_log` where schedule = '$schedule' and input_job_no='$input_job_no' and remove_type = '3'";
                $job_deacive_hold_result=mysqli_query($link, $job_deacive_hold) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                $sql_num_check_hold=mysqli_num_rows($job_deacive_hold_result);
                if($sql_num_check_hold == 0 ){
                    $insert_qry = "insert into $bai_pro3.job_deactive_log(input_date,style,schedule,color,module_no,input_job_no,input_job_no_random,input_qty,out_qty,rejected_qty,wip,remarks,remove_type,tran_user) values('$ims_date','$style','$schedule','$color','$module','$input_job_no','$input_rand_ref','$input_qty','$output_qty','$rejected_qty','$wip','$ims_remarks','$remove_type','$username')";
                    // echo $insert_qry;
                    $insert_qry_result=mysqli_query($link, $insert_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $deactive_job_id = mysqli_insert_id($link);
                }
            }
            if($deactive_job_id){
                
                $sql_ref_nums="select distinct input_job_no_random as job_numbers from $bai_pro3.packing_summary_input where order_style_no = '$style' and order_del_no = '$schedule' and input_job_no='$input_job_no'";
                $sql_ref_nums_res=mysqli_query($link, $sql_ref_nums) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($sql_rowx=mysqli_fetch_array($sql_ref_nums_res))
                {
                    $remove_ref_nums[]="'".$sql_rowx['job_numbers']."'";
                }

                $remarks = '';
                if(sizeof($remove_ref_nums)>0)
                {
                    //To remove Jobs in IPS and TMS
                    $ips_chck_qry = "select distinct input_job_no_random_ref as ips_tms_jobs  from $bai_pro3.plan_dashboard_input where input_job_no_random_ref in (".implode(",",$remove_ref_nums).")";
                    // echo $ips_chck_qry;
                    $ips_chck_qry_res = mysqli_query($link, $ips_chck_qry) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($ips_chck_row=mysqli_fetch_array($ips_chck_qry_res))
                    {
                        $ips_tms_jobs[]="'".$ips_chck_row['ips_tms_jobs']."'";
                    }
                    // echo $ips_chck_qry;
                    if(sizeof($ips_tms_jobs)>0){
                        $backup_ips_query="INSERT IGNORE INTO $bai_pro3.plan_dashboard_input_backup SELECT * FROM $bai_pro3.plan_dashboard_input WHERE input_job_no_random_ref in (".implode(",",$ips_tms_jobs).")";
                        $backup_ips_query_result = mysqli_query($link, $backup_ips_query) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $update_ips_qry = "update $bai_pro3.plan_dashboard_input_backup set short_shipment_status = '$remove_type' where input_job_no_random_ref in (".implode(",",$ips_tms_jobs).")";
                        $update_ips_qry_result = mysqli_query($link, $update_ips_qry) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $del_ips_sqlx="delete from $bai_pro3.plan_dashboard_input where input_job_no_random_ref in (".implode(",",$ips_tms_jobs).")";
                        $del_ips_sqlx_result = mysqli_query($link, $del_ips_sqlx) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
                        if($backup_ips_query_result && $update_ips_qry_result && $del_ips_sqlx_result) {
                            $remarks .="IPS,TMS,";
                        }
                    } 
                    $ips_chck_qry_bkp = "select distinct input_job_no_random_ref as ips_tms_jobs from $bai_pro3.plan_dashboard_input_backup where input_job_no_random_ref in (".implode(",",$remove_ref_nums).") and short_shipment_status=0";
                    // echo $ips_chck_qry_bkp;
                    $ips_chck_qry_bkp_res = mysqli_query($link, $ips_chck_qry_bkp) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($ips_chck_row_bkp=mysqli_fetch_array($ips_chck_qry_bkp_res))
                    {
                        $ips_tms_jobs1[]="'".$ips_chck_row_bkp['ips_tms_jobs']."'";
                    }
                    if(sizeof($ips_tms_jobs1)>0)
                    {
                        //MAINTAINING 4 STATUS FOR BACKUP ONLY
                        $update_ips_qry = "update $bai_pro3.plan_dashboard_input_backup set short_shipment_status = '4' where input_job_no_random_ref in (".implode(",",$remove_ref_nums).") and short_shipment_status=0";
                        $update_ips_qry_result = mysqli_query($link, $update_ips_qry) or exit("Sql Error113".mysqli_error($GLOBALS["___mysqli_ston"]));
                    }
                    // die();


                    //To remove Jobs in IMS
                    $ims_chck_qry = "select distinct input_job_rand_no_ref as ims_jobs from $bai_pro3.ims_log where input_job_rand_no_ref in (".implode(",",$remove_ref_nums).")";
                    $ims_chck_qry_res = mysqli_query($link, $ims_chck_qry) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($ims_chck_row=mysqli_fetch_array($ims_chck_qry_res))
                    {
                        $ims_jobs[]="'".$ims_chck_row['ims_jobs']."'";
                    }  
                   
                    if(sizeof($ims_jobs)>0){
                        $backup_ims_query="INSERT IGNORE INTO $bai_pro3.ims_log_backup SELECT * FROM $bai_pro3.ims_log WHERE input_job_rand_no_ref in (".implode(",",$ims_jobs).")";
                        mysqli_query($link, $backup_ims_query) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $update_ims_qry = "update $bai_pro3.ims_log_backup set short_shipment_status = '$remove_type' where input_job_rand_no_ref in (".implode(",",$ims_jobs).") and ims_status <> 'DONE'";
                        $update_ims_qry_res =mysqli_query($link, $update_ims_qry) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $del_ims_sqlx = "delete from $bai_pro3.ims_log where input_job_rand_no_ref in (".implode(",",$ims_jobs).")";
                        $del_ims_sqlx_res =mysqli_query($link, $del_ims_sqlx) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));
                        if($update_ims_qry_res && $del_ims_sqlx_res) {
                            $remarks .="IMS,";
                        }
                    }
                    $ims_chck_qry_bkp = "select distinct input_job_rand_no_ref as ims_jobs from $bai_pro3.ims_log_backup where input_job_rand_no_ref in (".implode(",",$remove_ref_nums).") and short_shipment_status=0";
                    $ims_chck_qry_bkp_res = mysqli_query($link, $ims_chck_qry_bkp) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($ims_chck_row_bkp=mysqli_fetch_array($ims_chck_qry_bkp_res))
                    {
                        $ims_jobs_bkp[]="'".$ims_chck_row_bkp['ims_jobs']."'";
                    }
                    if(sizeof($ims_jobs_bkp)>0) {
                        //MAINTAINING 4 STATUS FOR BACKUP ONLY
                        $update_ips_qry = "update $bai_pro3.ims_log_backup set short_shipment_status = '4' where input_job_rand_no_ref in (".implode(",",$remove_ref_nums).") and short_shipment_status=0";
                        $update_ips_qry_result = mysqli_query($link, $update_ips_qry) or exit("Sql Error113".mysqli_error($GLOBALS["___mysqli_ston"]));
                    }
                    unset($ims_jobs);
                    unset($ims_jobs_bkp);
                    unset($ips_tms_jobs);
                }

                //to remove jobs in WIP Dashboard
                $change_status = 4; // for bcd bundle_qty_status for sewing job deactivation
                $wip_chck_qry = "select id from $brandix_bts.bundle_creation_data where style='".$style."' and schedule='".$schedule."' and input_job_no='$input_job_no' and bundle_qty_status=0";
                $wip_chck_qry_res=mysqli_query($link, $wip_chck_qry) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($wip_chck_row=mysqli_fetch_array($wip_chck_qry_res))
                {
                    $wip_jobs[]="'".$wip_chck_row['id']."'";
                }
                if(sizeof($wip_jobs)>0){
                    $wip_dash_table_update="UPDATE $brandix_bts.bundle_creation_data SET bundle_qty_status=$change_status WHERE id in (".implode(",",$wip_jobs).")";
                    $wip_dash_table_update_resultx=mysqli_query($link, $wip_dash_table_update) or exit("Sql Error144".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if($wip_dash_table_update_resultx) {
                        $remarks .="WIP,";
                    }
                }
            }
           
        }
        else if($_POST['remove_type'][$key] == '0'){
            $style = $_POST['style'][$key];
            $schedule = $_POST['schedule'][$key];
            $input_job_no = $_POST['input_job_no'][$key];
            $input_rand_ref = $_POST['input_rand_ref'][$key];
            // $module = $_POST['module'];

            $remove_type=$_POST['remove_type'][$key];
            $job_deacive = "SELECT * FROM $bai_pro3.`job_deactive_log` where schedule = '$schedule' and input_job_no='$input_job_no' and remove_type = '3'";
            $job_deacive_result=mysqli_query($link, $job_deacive) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
            $sql_num_check=mysqli_num_rows($job_deacive_result);
            if($sql_num_check>0){
                while($sql_row=mysqli_fetch_array($job_deacive_result))
                {
                    $reverse_deactive_job_id = $sql_row['id'];
                    $update_revers_qry = "update $bai_pro3.job_deactive_log set remove_type=$remove_type where id=".$reverse_deactive_job_id;
                    $update_revers_qry_result = mysqli_query($link, $update_revers_qry) or exit("update error".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $deactive_job_ids = $reverse_deactive_job_id;
                    
                    if($deactive_job_ids){
                
                        $sql_ref_nums="select distinct input_job_no_random as job_numbers from $bai_pro3.packing_summary_input where order_style_no = '$style' and order_del_no = '$schedule' and input_job_no='$input_job_no'";
                        $sql_ref_nums_res=mysqli_query($link, $sql_ref_nums) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($sql_rowx=mysqli_fetch_array($sql_ref_nums_res))
                        {
                            $remove_ref_nums1[]="'".$sql_rowx['job_numbers']."'";
                        }
                        // echo $sql_ref_nums;
                        // var_dump($remove_ref_nums);
                        // die();
        
                        $remarks = '';
                        if(sizeof($remove_ref_nums1)>0)
                        {
                            //To remove Jobs in IPS and TMS
                            $ips_chck_qry = "select distinct input_job_no_random_ref as ips_tms_jobs  from $bai_pro3.plan_dashboard_input_backup where input_job_no_random_ref in (".implode(",",$remove_ref_nums1).") and short_shipment_status=3";
                            // echo $ips_chck_qry.'<br/>';
                            $ips_chck_qry_res = mysqli_query($link, $ips_chck_qry) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($ips_chck_row=mysqli_fetch_array($ips_chck_qry_res))
                            {
                                $ips_tms_jobss[]="'".$ips_chck_row['ips_tms_jobs']."'";
                            }
                            
                            if(sizeof($ips_tms_jobss)>0){
                                $backup_ips_query="INSERT IGNORE INTO $bai_pro3.plan_dashboard_input SELECT * FROM $bai_pro3.plan_dashboard_input_backup WHERE input_job_no_random_ref in (".implode(",",$ips_tms_jobss).")  and short_shipment_status=3";
                                $backup_ips_query_result = mysqli_query($link, $backup_ips_query) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
                                // echo $backup_ips_query.'<br/>';
                                $update_ips_qry = "update $bai_pro3.plan_dashboard_input set short_shipment_status = '$remove_type' where input_job_no_random_ref in (".implode(",",$ips_tms_jobss).")";
                                $update_ips_qry_result = mysqli_query($link, $update_ips_qry) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
                                // echo $update_ips_qry.'<br/>';

                                $del_ips_sqlx="delete from $bai_pro3.plan_dashboard_input_backup where input_job_no_random_ref in (".implode(",",$ips_tms_jobss).")  and short_shipment_status=3";
                                $del_ips_sqlx_result = mysqli_query($link, $del_ips_sqlx) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
                                // echo $del_ips_sqlx.'<br/>';

                                if($backup_ips_query_result && $update_ips_qry_result && $del_ips_sqlx_result) {
                                    $remarks .="IPS,TMS,";
                                }
                            }
                            $ips_chck_qry_bkp = "select distinct input_job_no_random_ref as ips_tms_jobs  from $bai_pro3.plan_dashboard_input_backup where input_job_no_random_ref in (".implode(",",$remove_ref_nums1).") and short_shipment_status=4";
                            // echo $ips_chck_qry_bkp.'<br/>';
                            $ips_chck_qry_bkp_res = mysqli_query($link, $ips_chck_qry_bkp) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($ips_chck_row_bkp=mysqli_fetch_array($ips_chck_qry_bkp_res))
                            {
                                $ips_tms_jobss1[]="'".$ips_chck_row_bkp['ips_tms_jobs']."'";
                            }
                            if(sizeof($ips_tms_jobss1)>0){
                                $update_ips_qry = "update $bai_pro3.plan_dashboard_input_backup set short_shipment_status = '$remove_type' where input_job_no_random_ref in (".implode(",",$ips_tms_jobss1).")  and short_shipment_status=4";
                                $update_ips_qry_result = mysqli_query($link, $update_ips_qry) or exit("Sql Error113".mysqli_error($GLOBALS["___mysqli_ston"]));
                            }
        
                            //To remove Jobs in IMS
                            $ims_chck_qry = "select distinct input_job_rand_no_ref as ims_jobs from $bai_pro3.ims_log_backup where input_job_rand_no_ref in (".implode(",",$remove_ref_nums1).") and short_shipment_status=3";
                            // echo $ims_chck_qry.'<br/>';
                            $ims_chck_qry_res = mysqli_query($link, $ims_chck_qry) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($ims_chck_row=mysqli_fetch_array($ims_chck_qry_res))
                            {
                                $ims_jobss[]="'".$ims_chck_row['ims_jobs']."'";
                            }
                            if(sizeof($ims_jobss)>0){
                                $backup_ims_query="INSERT IGNORE INTO $bai_pro3.ims_log SELECT * FROM $bai_pro3.ims_log_backup WHERE input_job_rand_no_ref in (".implode(",",$ims_jobss).") and short_shipment_status=3";
                                // echo $backup_ims_query.'<br/>';
                                mysqli_query($link, $backup_ims_query) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $update_ims_qry = "update $bai_pro3.ims_log set short_shipment_status = '$remove_type' where input_job_rand_no_ref in (".implode(",",$ims_jobss).") and ims_status <> 'DONE'";
                                // echo $update_ims_qry.'<br/>';
                                $update_ims_qry_res =mysqli_query($link, $update_ims_qry) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $del_ims_sqlx = "delete from $bai_pro3.ims_log_backup where input_job_rand_no_ref in (".implode(",",$ims_jobss).") and short_shipment_status=3";
                                // echo $del_ims_sqlx.'<br/>';
                                $del_ims_sqlx_res =mysqli_query($link, $del_ims_sqlx) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));
                                if($update_ims_qry_res && $del_ims_sqlx_res) {
                                    $remarks .="IMS,";
                                }
                            }

                            $ims_chck_qry_bkp = "select distinct input_job_rand_no_ref as ims_jobs from $bai_pro3.ims_log_backup where input_job_rand_no_ref in (".implode(",",$remove_ref_nums1).") and short_shipment_status=4";
                            // echo $ims_chck_qry_bkp.'<br/>';
                            $ims_chck_qry_bkp_res = mysqli_query($link, $ims_chck_qry_bkp) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($ims_chck_row_bkp=mysqli_fetch_array($ims_chck_qry_bkp_res))
                            {
                                $ims_jobs11[]="'".$ims_chck_row_bkp['ims_jobs']."'";
                            }
                            if(sizeof($ims_jobs11)>0) {
                                //MAINTAINING 4 STATUS FOR BACKUP ONLY
                                $update_ips_qry = "update $bai_pro3.ims_log_backup set short_shipment_status = '$remove_type' where input_job_rand_no_ref in (".implode(",",$ims_jobs11).") and short_shipment_status=4";
                                $update_ips_qry_result = mysqli_query($link, $update_ips_qry) or exit("Sql Error113".mysqli_error($GLOBALS["___mysqli_ston"]));
                            }
                        }
        
                        //to remove jobs in WIP Dashboard
                        //for sewing job activation in bcd make bundle_qty_status
                        $change_status = 0;
                        
                        $wip_chck_qry = "select id from $brandix_bts.bundle_creation_data where style='".$style."' and schedule='".$schedule."' and input_job_no='$input_job_no' and bundle_qty_status=4";
                        $wip_chck_qry_res=mysqli_query($link, $wip_chck_qry) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($wip_chck_row=mysqli_fetch_array($wip_chck_qry_res))
                        {
                            $wip_jobs1[]="'".$wip_chck_row['id']."'";
                        }
                        if(sizeof($wip_jobs1)>0){
                            $wip_dash_table_update="UPDATE $brandix_bts.bundle_creation_data SET bundle_qty_status=$change_status WHERE id in (".implode(",",$wip_jobs1).")";
                            $wip_dash_table_update_resultx=mysqli_query($link, $wip_dash_table_update) or exit("Sql Error144".mysqli_error($GLOBALS["___mysqli_ston"]));
                            if($wip_dash_table_update_resultx) {
                                $remarks .="WIP,";
                            }
                        }
        
                    }
                }
               
            }
        }
    }
    // echo $module;
    // die();
    echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",2000);
        function Redirect() {
            sweetAlert('success','','success');
            location.href = \"".getFullURLLevel($_GET['r'], "sewing_job_deactive.php", "0", "N")."&module=$module\";
            }
        </script>";
    // if($status == 1){
    //     $short_shipment = array_unique($short_shipment_schedules);
    //     $ss_list = implode(",",$short_shipment);
    //     // var_dump($ss_list);
    //     $non_short_shipment = array_unique($non_short_shipment_schedules);
    //     $nss_list = implode(",",$non_short_shipment);
    //     // var_dump($nss_list);
    //     if($nss_list=='' || $nss_list==NULL){
    //         echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
    //         function Redirect() {
    //             sweetAlert('Short Shipment Already performed for this schedule','','warning');
    //             location.href = \"".getFullURLLevel($_GET['r'], "sewing_job_deactive.php", "0", "N")."&module=$module\";
    //             }
    //         </script>";
    //         // exit();
    //     }
    // } else {
    //     var_dump('else');
    // }
    // die();
}

// if($_GET['schedule'] && $_GET['input_job_no']){
//     // var_dump($_GET['schedule']);
//     // var_dump($_GET['input_job_no']);
//     $schedule = $_GET['schedule'];
//     $input_job_no = $_GET['input_job_no'];
//     $job_deacive = "SELECT * FROM $bai_pro3.`job_deactive_log` where schedule = '$schedule' and input_job_no='$input_job_no' and remove_type = '3'";
//     $job_deacive_result=mysqli_query($link, $job_deacive) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
//     $sql_num_check=mysqli_num_rows($job_deacive_result);
//     if($sql_num_check>0){
//         while($sql_row=mysqli_fetch_array($job_deacive_result))
//         {
//             $reverse_deactive_job_id = $sql_row['id'];
//             $module = $sql_row['module_no'];
//             $update_revers_qry = "update $bai_pro3.job_deactive_log set remove_type='0' where id=".$reverse_deactive_job_id;
//             $update_revers_qry_result = mysqli_query($link, $update_revers_qry) or exit("update error".mysqli_error($GLOBALS["___mysqli_ston"]));
//         }
//         echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
//         function Redirect() {
//             sweetAlert('Sewing Job Deactivated Reversed','','success');
//             location.href = \"".getFullURLLevel($_GET['r'], "sewing_job_deactive.php", "0", "N")."&module=$module\";
//             }
//         </script>";
//     }
// }



// CREATE TABLE `job_deactive_log` (
//     `id` INT(11) NOT NULL AUTO_INCREMENT,
//     `date_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
//     `input_date` DATETIME DEFAULT NULL,
//     `style` VARCHAR(30) DEFAULT NULL,
//     `schedule` VARCHAR(30) DEFAULT NULL,
//     `color` VARCHAR(50) DEFAULT NULL,
//     `module_no` INT(11) DEFAULT NULL,
//     `input_job_no` INT(11) DEFAULT NULL,
//     `input_qty` INT(11) DEFAULT NULL,
//     `out_qty` INT(11) DEFAULT NULL,
//     `rejected_qty` INT(11) DEFAULT NULL,
//     `wip` INT(11) DEFAULT NULL,
//     `remarks` VARCHAR(20) DEFAULT NULL,
//     `remove_type` VARCHAR(20) DEFAULT NULL,
//     `tran_user` VARCHAR(20) DEFAULT NULL,
//     PRIMARY KEY (`id`)
//   ) ENGINE=INNODB DEFAULT CHARSET=latin1;


// INSERT INTO 
// central_administration_sfcs.tbl_menu_list

// (menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES
// ('','SFCS_0559', '8', '1', '157', '1', '1', '1', '/sfcs_app/app/planning/controllers/deactivate_sewing_job/sewing_job_deactive.php', 'Deactivate Sewing Jobs', '', '');

// INSERT INTO 
// central_administration_sfcs.rbac_role_menu

// (menu_pid, menu_description, roll_id) VALUES
// ('1683', 'Deactivate Sewing Jobs', '1');


?>