<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
$username = getrbac_user()['uname'];

if(isset($_POST['submit']))
{
    var_dump($_POST);
    die();
    $module = $_POST['module'];

    $application2='IPS';

    $scanning_query12="select operation_code from $brandix_bts.tbl_ims_ops where appilication='$application2'";
    $scanning_result12=mysqli_query($link, $scanning_query12)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row123=mysqli_fetch_array($scanning_result12))
    {
        $operation_in_code=$sql_row123['operation_code'];
    }
    $application='IMS_OUT';

    $scanning_query="select operation_code from $brandix_bts.tbl_ims_ops where appilication='$application'";
    $scanning_result=mysqli_query($link, $scanning_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row=mysqli_fetch_array($scanning_result))
    {
      $operation_out_code=$sql_row['operation_code'];
    }

    if($module){
        $get_module_data = "SELECT * FROM $bai_pro3.`ims_log` where ims_mod_no = '$module' and ims_status<>'DONE' GROUP BY input_job_no_ref ORDER BY input_job_no_ref,ims_date";
        $get_module_data_result=mysqli_query($link, $get_module_data) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        $norows = mysqli_num_rows($get_module_data_result);
        $sno = 1;

        if ($norows > 0) {
            ?>
            <form name='list' method='post' action="<?php echo getFullURLLevel($_GET['r'],'sewing_job_list.php','0','N'); ?>">
            <?php
            echo "<div class='pull-right'><input type='hidden' name='module' value=$module>
            <input type='submit' class='btn btn-success btn-sm' name='Save' value='Save' >
            </div>";
            echo "<br/><table id='deactive_sewing_job' class='table'>";
            echo "<thead><tr><th>S.No</th><th>Input Date</th><th>Style</th><th>Schedule</th><th>Color</th><th>Sewing Job No</th><th>Job Qty</th><th>Output</th><th>Rejected</th><th>WIP</th><th>Remarks</th><th>Status</th></tr></thead><tbody>";
            while($row=mysqli_fetch_array($get_module_data_result)) {
                $ims_date = $row["ims_date"];
                $style = $row['ims_style'];
                $schedule = $row['ims_schedule'];
                $color = $row['ims_color'];
                $input_job_no = $row['input_job_no_ref'];
                $ims_remarks = $row['ims_remarks'];
                $ims_size = $row['ims_size'];
                $sizes_explode=array();
                $sizes_explode=explode(",",$ims_size);
                $sizes_implode1="'".implode("','",$sizes_explode)."'"; 

                $input_qty=0;
                $output_qty=0;
                $ip_op_qty="SELECT sum(if(operation_id = $operation_in_code,recevied_qty,0)) as input,sum(if(operation_id = $operation_out_code,recevied_qty,0)) as output FROM $brandix_bts.bundle_creation_data WHERE input_job_no = $input_job_no";
                $ip_op_qty_res=mysqli_query($link, $ip_op_qty) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($sql_row_ip_op=mysqli_fetch_array($ip_op_qty_res))
                {
                    $input_qty = $sql_row_ip_op['input'];
                    $output_qty = $sql_row_ip_op['output'];
                    $wip=$input_qty-$output_qty;
                }

                $rejected_qty=0;
                $rejected_qry="select COALESCE(SUM(IF(qms_tran_type=3,qms_qty,0)),0) AS rejected from $bai_pro3.bai_qms_db where  qms_schedule='".$schedule."' and qms_color in (".$color.") and qms_size in ($sizes_implode1) and input_job_no='".$input_job_no."' and qms_style='".$style."' and operation_id=$operation_out_code and SUBSTRING_INDEX(remarks,'-',1) = '$module' and qms_remarks in ('".$ims_remarks."')";
                $rejected_qry_result =mysqli_query($link, $rejected_qry) ;
                while($sql_row33=mysqli_fetch_array($rejected_qry_result))
                {
                    $rejected_qty=$sql_row33['rejected']; 
                } 
                echo "<tr>";
                echo "<input type='hidden' name='ims_date[]' value=$ims_date>";
                echo "<input type='hidden' name='style[]' value=$style>";
                echo "<input type='hidden' name='schedule[]' value=$schedule>";
                echo "<input type='hidden' name='color[]' value=$color>";
                echo "<input type='hidden' name='input_job_no[]' value=$input_job_no>";
                echo "<input type='hidden' name='input_qty[]' value=$input_qty>";
                echo "<input type='hidden' name='output_qty[]' value=$output_qty>";
                echo "<input type='hidden' name='rejected_qty[]' value=$rejected_qty>";
                echo "<input type='hidden' name='ims_remarks[]' value=$ims_remarks>";
                echo "<input type='hidden' name='wip[]' value=$wip>";
                echo "<input type='hidden' name='sizes_implode1[]' value=$sizes_implode1>";
                echo "<td>".$sno++."</td><td>".$ims_date." </td><td>".$style."</td><td>".$schedule."</td><td>".$color."</td><td>".$input_job_no."</td><td>".$input_qty."</td><td>".$output_qty."</td><td>".$rejected_qty."</td><td>".$wip."</td><td>".$ims_remarks."</td>";
                echo '<td><select id="remove_type" class="form-control" data-role="select" selected="selected" name="remove_type[]"  data-parsley-errors-container="#errId3" required><option value="0" selected>Active</option><option value="3">Hold</option></select></td>';
                echo "</tr>";

            }
            echo "<tr><td colspan='11' align='right'></td><td>
            <input type='submit' class='btn btn-success btn-sm pull-right' name='Save' value='Save' ></td>
            </tr>";
            echo "</form></tbody></table>";
        } else {
            echo "0 results";
        }

    }else {
        echo "<script>swal('Select Module','','error');</script>";
    }

}


// if(isset($_POST['Save']))
// {
//     foreach($_POST['style'] as $key=>$value){
//         if($_POST['remove_type'][$key] == '3'){
//             $ims_date = $_POST['ims_date'][$key];
//             $style = $_POST['style'][$key];
//             $schedule = $_POST['schedule'][$key];
//             $color = $_POST['color'][$key];
//             $input_job_no = $_POST['input_job_no'][$key];
//             $input_qty = $_POST['input_qty'][$key];
//             $output_qty = $_POST['output_qty'][$key];
//             $rejected_qty = $_POST['rejected_qty'][$key];
//             $ims_remarks = $_POST['ims_remarks'][$key];
//             $module = $_POST['module'];

//             $insert_qry = "insert into $bai_pro3.job_deactive_log(input_date,style,schedule,color,module_no,input_job_no,input_qty,out_qty,rejected_qty,wip,remarks,status,tran_user) values('$ims_date','$style','$schedule','$color','$module_no','$input_job_no','$input_qty','$output_qty','$rejected_qty','$ims_remarks','$username')";
//             echo $insert_qry;
//             // $insert_qry_result=mysqli_query($link, $insert_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
//             // $deactive_job_id = mysqli_insert_id($link);

//         //     if($insert_qry_result) {
//         // }
//     }
//     die();
   
// }
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
//     `status` VARCHAR(20) DEFAULT NULL,
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