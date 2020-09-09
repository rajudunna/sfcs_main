<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',4,'R'));
$plant_code = $_SESSION['plantCode'];
$username = $_SESSION['userName'];

if(isset($_POST['Save']))
{
    $status = 0;
    $module1 = array_unique($_POST['module']);
    $module = implode(",",$module1);
   
    foreach($_POST['style'] as $key => $value){
        if($_POST['remove_type'][$key] == '3'){
            $planned_date = $_POST['planned_date'][$key];
            $style = $_POST['style'][$key];
            $schedule = $_POST['schedule'][$key];
            $color = $_POST['color'][$key];
            $input_job_no = $_POST['input_job_no'][$key];
            $po_number = $_POST['po_number'][$key];
            $input_qty = $_POST['input_qty'][$key];
            $jm_jg_header_id = $_POST['jm_jg_header_id'][$key];
            // $wip = $_POST['wip'][$key];
            // $rejected_qty = $_POST['rejected_qty'][$key];
            // $ims_remarks = $_POST['ims_remarks'][$key];
            // $module = $_POST['module'];
            $remove_type=3;
            $job_deacive = "SELECT * FROM $pts.`job_deactive_log` where po_number = '$po_number' and input_job_no='$input_job_no'  and plant_code='$plant_code' and remove_type = '0'";
            $job_deacive_result=mysqli_query($link, $job_deacive) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
            $sql_num_check=mysqli_num_rows($job_deacive_result);
            if($sql_num_check>0){
                while($sql_row=mysqli_fetch_array($job_deacive_result))
                {
                    $reverse_deactive_job_id = $sql_row['id'];
                    $update_revers_qry = "update $pts.job_deactive_log set remove_type='$remove_type',input_qty='$input_qty',updated_user='$username',updated_at=NOW() where plant_code='$plant_code' and id=".$reverse_deactive_job_id;
                    $update_revers_qry_result = mysqli_query($link, $update_revers_qry) or exit("update error".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $deactive_job_id = $reverse_deactive_job_id;
                }
            } else {
                $job_deacive_hold = "SELECT * FROM $pts.`job_deactive_log` where po_number = '$po_number' and input_job_no='$input_job_no' and plant_code='$plant_code' and remove_type = '3'";
                $job_deacive_hold_result=mysqli_query($link, $job_deacive_hold) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                $sql_num_check_hold=mysqli_num_rows($job_deacive_hold_result);
                if($sql_num_check_hold == 0 ){
                    $insert_qry = "insert into $pts.job_deactive_log(input_date,style,schedule,color,po_number,module_no,input_job_no,input_job_no_random,input_qty,remove_type,tran_user,plant_code,created_user,updated_user) values('$planned_date','$style','$schedule','$color','$po_number','$module','$input_job_no','$jm_jg_header_id','$input_qty','$remove_type','$username','$plant_code','$username','$username')";
                    // echo $insert_qry;
                    $insert_qry_result=mysqli_query($link, $insert_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $deactive_job_id = mysqli_insert_id($link);
                }
            }
            $tasktype=TaskTypeEnum::SEWINGJOB;
            if($deactive_job_id){
                //get task_header from task_jobs
                $qry_header_id="SELECT task_header_id $tms.task_jobs WHERE task_job_reference='$jm_jg_header_id' AND plant_code='$plant_code' AND task_type='$tasktype'";
                $result_qry_header_id=mysqli_query($link_new, $qry_header_id) or exit("Sql Error at qry_header_id".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($qry_header_id_row=mysqli_fetch_array($result_qry_header_id))
                {
                    $task_header_id=$qry_header_id_row['task_header_id'];
                }
                $update_qry_task_header = "UPDATE $tms.task_header set task_status='HOLD',updated_at=NOW() WHERE plant_code='$plant_code' AND task_header_id = '$task_header_id' AND task_type='$tasktype'";
                mysqli_query($link, $update_qry_task_header) or exit("update_qry_task_header".mysqli_error($GLOBALS["___mysqli_ston"]));   

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

if($_GET['input_job_no'] && $_GET['jm_jg_header_id']){
    // var_dump($_GET['schedule']);
    // var_dump($_GET['input_job_no']);
    $input_job_no = $_GET['input_job_no'];
    $jm_jg_header_id = $_GET['jm_jg_header_id'];
    $job_deacive = "SELECT * FROM $pts.`job_deactive_log` where input_job_no='$input_job_no' and remove_type = '3'";
    $job_deacive_result=mysqli_query($link, $job_deacive) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql_num_check=mysqli_num_rows($job_deacive_result);
    if($sql_num_check>0){
        while($sql_row=mysqli_fetch_array($job_deacive_result))
        {
            $reverse_deactive_job_id = $sql_row['id'];
            $module = $sql_row['module_no'];
            $update_revers_qry = "update $pts.job_deactive_log set remove_type='0' where id=".$reverse_deactive_job_id;
            $update_revers_qry_result = mysqli_query($link, $update_revers_qry) or exit("update error".mysqli_error($GLOBALS["___mysqli_ston"]));
            $tasktype=TaskTypeEnum::SEWINGJOB;
            
            //get task_header from task_jobs
            $qry_header_id="SELECT task_header_id $tms.task_jobs WHERE task_job_reference='$jm_jg_header_id' AND plant_code='$plant_code' AND task_type='$tasktype'";
            $result_qry_header_id=mysqli_query($link_new, $qry_header_id) or exit("Sql Error at qry_header_id".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($qry_header_id_row=mysqli_fetch_array($result_qry_header_id))
            {
                $task_header_id=$qry_header_id_row['task_header_id'];
            }
            $task_status=TaskStatusEnum::INPROGRESS;
            $update_qry_task_header = "UPDATE $tms.task_header set task_status='$task_status',updated_at=NOW() WHERE plant_code='$plant_code' AND task_header_id = '$task_header_id' AND task_type='$tasktype'";
            mysqli_query($link, $update_qry_task_header) or exit("update_qry_task_header".mysqli_error($GLOBALS["___mysqli_ston"]));   

            
        }
        echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
        function Redirect() {
            sweetAlert('Sewing Job Deactivated Reversed','','success');
            location.href = \"".getFullURLLevel($_GET['r'], "sewing_job_deactive.php", "0", "N")."&module=$module\";
            }
        </script>";
    }
}



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