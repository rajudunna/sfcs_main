<?php
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'] . '/sfcs_app/common/config/config_ajax.php');
include($_SERVER['DOCUMENT_ROOT'] . '/sfcs_app/common/config/functions_v2.php');
include($_SERVER['DOCUMENT_ROOT'] . '/sfcs_app/common/config/enums.php');
$section = $_POST['section'];
$get_operation = $_POST['operations'];
$session_plant_code = $_POST['plant_code'];
$session_username = $_POST['username'];
$authToken=$_POST['authToken'];
// var_dump($session_username);
// $session_plant_code='AIP';
$data = '';
$jquery_data = '';
$line_breaker = 0;
$v_r = explode('/',$_SERVER['REQUEST_URI']);
array_pop($v_r);
$popup_url = "http://".$_SERVER['HTTP_HOST'].implode('/',$v_r)."/modules_report.php";
if ($section) {

    //getting all workstations against to the section
    $workstations_data = getWorkstationsForSection($session_plant_code, $section)['workstation_data'];
    $data .= "<table><tbody>";
    $form_unique_id=1;
    foreach ($workstations_data as $wkstation) {
        $line_breaker = 0;
        $total_wip = 0;
        $sewing_wip = '';
        $jobs_wip = '';
        $module=$wkstation['workstation_code'];
        $module_id=$wkstation['workstation_id'];
        $data .= "<tr rowspan=2>";
        $data.='<td rowspan=2 class="mod-td">
        <form id="TheForm_' .$section.$form_unique_id . '" method="post" action="' . $popup_url . '" target="TheWindow">
        <input type="hidden" name="module_id" value="' . $module_id . '" />
        <input type="hidden" name="module_code" value="' . $module . '" />
        <input type="hidden" name="plantCode" value="' . $session_plant_code . '" />
        <input type="hidden" name="username" value="' . $session_username . '" />
        <input type="hidden" name="operation_code" value="'.$get_operation.'" />
        <input type="hidden" name="authToken" value="' . $authToken . '" />
        </form>';

       $data.="<span class='mod-no'><b>
       <a href='javascript:void(0)' onclick=\"window.open('', 'TheWindow');document.getElementById('TheForm_$section$form_unique_id').submit();\">$module</a></b></span>";

        /*  BLOCK - 1 */
        $sewing_wip = getsewingJobsData($section, $wkstation['workstation_id'], $get_operation, $session_plant_code);
        $data .= "<td rowspan=1 class='cut-td'>";
        $data .= $sewing_wip;
        $data .= "&nbsp;</td>";

        /* BLOCK -2 */
        $data .= "<td rowspan=2 class='wip-td'>";
        $data .= "<span class=''><b>".$totalwip."</b></span>";
        $data .= "</td>";


        $data .= "</tr>";
        $form_unique_id++;
    } 
} else {
    $data = "Section Data Not Found";
}

$data .= "</tbody></table>";
$section_data['data'] = $data;
$section_data['java_scripts'] = $jquery_data;
echo json_encode($section_data);
?>

<?php

function getsewingJobsData($section, $wkstation, $get_operation, $session_plant_code)
{
    // error_reporting(E_ALL);
    include_once($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/sfcs_app/common/config/functions_v2.php');
    // include($_SERVER['DOCUMENT_ROOT'] . '/sfcs_app/common/config/config.php');
    
    global $link_new;
    global $sewing_job_attributes;
    global $tms;
    global $pts;
    $totalwip=0;
 

    $check_type = 'SEWINGJOB';
    $jobsArray= getJobsForWorkstationIdTypeSewing($session_plant_code, $wkstation,'');
    // var_dump($jobsArray);
    // die();
    // $result_planned_jobs = getPlannedJobs($wkstation, $check_type, $session_plant_code);
    // $job_number = $result_planned_jobs['job_number'];
    // $task_header_id = $result_planned_jobs['task_header_id'];
    // $task_job_ids = $result_planned_jobs['task_job_ids'];
    // $task_job_header_log = $result_planned_jobs['task_header_log_time'];


    foreach ($jobsArray as $jobs) {
        // $log_time = $task_job_header_log[$task_header_id_j];
        $task_job_id=$jobs['taskJobId'];
        $masterponumber='';
        //TO GET STYLE AND COLOR FROM TASK ATTRIBUTES USING TASK HEADER ID
        $job_detail_attributes = [];
        $qry_toget_style_sch = "SELECT attribute_name,attribute_value FROM $tms.task_attributes where task_jobs_id ='$task_job_id' and plant_code='$session_plant_code'";
        // echo $qry_toget_style_sch."<br/>";
        $qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("Sql Error at toget_style_sch" . mysqli_error($GLOBALS["___mysqli_ston"]));
      
        while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) {

            $job_detail_attributes[$row2['attribute_name']] = $row2['attribute_value'];
        }
        $style = $job_detail_attributes[$sewing_job_attributes['style']];
        $color = $job_detail_attributes[$sewing_job_attributes['color']];
        $co_no = $job_detail_attributes[$sewing_job_attributes['conumber']];
        $schedule = $job_detail_attributes[$sewing_job_attributes['schedule']];
        $cut_no = $job_detail_attributes[$sewing_job_attributes['cutjobno']];
        $docket_number = $job_detail_attributes[$sewing_job_attributes['docketno']];
        $job_num = $job_detail_attributes[$sewing_job_attributes['sewingjobno']];
        $masterponumber = $job_detail_attributes[$sewing_job_attributes['masterponumber']];

        $task_job_trans = "SELECT original_quantity,good_quantity,rejected_quantity,operation_code,operation_seq FROM $tms.task_job_status where task_jobs_id ='$task_job_id' and operation_code='$get_operation'";
        // echo $task_job_trans."<br/>";
        $task_job_trans_result = mysqli_query($link_new, $task_job_trans) or exit("Sql Error at task_job_trans_result" . mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($row_res = mysqli_fetch_array($task_job_trans_result)) {
            $orginal_qty = $row_res['original_quantity'];
            $good_qty = $row_res['good_quantity'];
            $rej_qty = $row_res['rejected_quantity'];
            $operation_code = $row_res['operation_code'];
            $operation_seq = $row_res['operation_seq'];
        }
        $send_qty=0;
        $task_job_trans2 = "SELECT good_quantity FROM $tms.task_job_status where task_jobs_id ='$task_job_id' and operation_seq < $operation_seq order by operation_seq DESC limit 0,1";
        // echo $task_job_trans2."<br/>";
        $task_job_trans_result2 = mysqli_query($link_new, $task_job_trans2) or exit("Sql Error at task_job_trans_result2" . mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($task_job_trans_result2) > 0){
            while ($row_res2 = mysqli_fetch_array($task_job_trans_result2)) {
                $send_qty = $row_res2['good_quantity'];
            }
        }else{
            //To get finished_good_id
            if($masterponumber ==''){
                $get_details="SELECT finished_good_id FROM $pts.finished_good WHERE style='$style' AND schedule='$schedule' AND color='$color' AND plant_code='$session_plant_code' limit 1";
            }else{
                $get_details="SELECT finished_good_id FROM $pts.finished_good WHERE style='$style' AND schedule='$schedule' AND color='$color' AND master_po='$masterponumber' AND plant_code='$session_plant_code' limit 1";
            }
            // echo $get_details."<br/>";
            $sql_result11=mysqli_query($link_new, $get_details) or exit("Sql Error get_details123".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($row_main=mysqli_fetch_array($sql_result11))
            {
                $fg_good_id= $row_main['finished_good_id'];   
            }
           
            $previous_operation=[];
            $get_operations="SELECT previous_operation FROM $pts.fg_operation WHERE finished_good_id='$fg_good_id'  AND plant_code='$session_plant_code' and operation_code='$get_operation'";
            // echo $get_operations;
            $sql_result12=mysqli_query($link_new, $get_operations) or exit("Sql Error get_operations".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($row1=mysqli_fetch_array($sql_result12))
            {
              $previous_operation[]=$row1['previous_operation'];
            }
            if(sizeof($previous_operation) >0){
                $previous_op = "'" . implode( "','", $previous_operation) . "'";
            }
            // var_dump($previous_op);
            $task_job_trans2 = "SELECT sum(good_quantity) as good_quantity FROM $pts.transaction_log where style='$style' AND schedule='$schedule' AND color='$color' and operation in ($previous_op) and is_active=1 and plant_code='$session_plant_code'";
            // echo $task_job_trans2."<br/>";
            $task_job_trans2_result = mysqli_query($link_new, $task_job_trans2) or exit("Sql Error at task_job_trans2_result123" . mysqli_error($GLOBALS["___mysqli_ston"]));
            while ($row_res2 = mysqli_fetch_array($task_job_trans2_result)) {
              $send_qty = $row_res2['good_quantity'];
            }

        }
        $wip=0;
        $wip = $send_qty - $good_qty;
        
        $input_date = null;
        $remarks = null;
        if($wip > 0) {
            $totalwip = $totalwip + $wip;

            $tool_tip_text = "<p style=\"width : 500px \">
                <v><c>Style </c> : $style </v>
                <v><c>Schedule </c> : $schedule</v>
                <v><c>Color </c> : $color</v>
                <v><c>Co No </c> : $co_no</v>
                <v><c>Input_date </c> : $input_date</v>
                <v><c>Wip </c> : $wip</v>
                <v><c>Job No </c> : $job_num</v>
                <v><c>Cut No </c> :$cut_no</v>
                <v><c>Doc_no </c> : $docket_number</v>
                <v><c>Rejected </c> : $rej_qty</v>
                <v><c>Remarks </c> : $remarks</v>
               </p>";
            // var_dump($tool_tip_text, "<br/>");
            
            // $href = "$url&wkstation=$wkstation&section=$section&operations=$get_operation";
            $docs_data .= "<span class='block'>
                <span class='cut-block blue'>
                    <span class='mytooltip'>
                        <a rel='tooltip' data-toggle='tooltip' data-placement='top' data-title='$tool_tip_text'
                         
                        data-html='true'>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                        </a>
                    </span>
                </span>
              </span>";

        }

    }
    $docs_data .= "<span class='block'>
        <span class='red'>
            <span class='ims-wip'>
            Wip  : $totalwip
                <a  data-toggle='tooltip' data-placement='top' data-title='$tool_tip_text1'>
                    &nbsp;&nbsp;&nbsp;
                </a>
            </span>
          </span>
        </span>";


    enough:
    NULL;
    $wkstation = str_replace(".", "-", $wkstation);
    if ($job_num == 0 || $job_num == '')
        $jquery_data .= "<script>$('#cut-wip-td-$wkstation').remove()</script>";
    else
        $jquery_data .= "<script>$('#cut-wip-$wkstation').html('$job_num')</script>";

    return $docs_data;
}

?>