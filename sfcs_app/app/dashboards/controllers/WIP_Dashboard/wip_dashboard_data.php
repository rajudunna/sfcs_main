<?php
error_reporting(0);
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
$section = $_GET['section'];
$get_operation = $_GET['operations'];
$session_plant_code = $_GET['plant_code'];
function leading_zeros($value, $places)
{
    $leading='';
    
    if(is_numeric($value))
    {
        for($x = 1; $x <= $places; $x++)
        {
            $ceiling = pow(10, $x);
            if($value < $ceiling)
            {
                $zeros = $places - $x;
                for($y = 1; $y <= $zeros; $y++)
                {
                    $leading .= "0";
                }
            $x = $places + 1;
            }
        }
        $output = $leading . $value;
    }
    else{
        $output = $value;
    }
    
    return $output;
}
function echo_title($table_name,$field,$compare,$key,$link)
{
    //GLOBAL $menu_table_name;
    //GLOBAL $link;
    $sql="select $field as result from $table_name where $compare='$key'";
    // echo $sql."<br>";
    $sql_result=mysqli_query($link, $sql) or exit($sql."Sql Error-echo_1<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row=mysqli_fetch_array($sql_result))
    {
        return $sql_row['result'];
    }
    ((mysqli_free_result($sql_result) || (is_object($sql_result) && (get_class($sql_result) == "mysqli_result"))) ? true : false);
}


$data = '';
$jquery_data = '';
$line_breaker = 0;
if($section > 0){

    //getting all modules against to the section
    $workstations_data = getWorkstationsForSection($session_plant_code, $section)['workstation_data'];
    // $modules_query = "SELECT section_display_name,section_head AS sec_head,ims_priority_boxs,GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM $bai_pro3.`module_master` LEFT JOIN $bai_pro3.sections_master ON module_master.section=sections_master.sec_name WHERE module_master.status='active' and section=$section GROUP BY section ORDER BY section + 0";
    //echo  $modules_query;
    // $modules_result = mysqli_query($link,$modules_query) or exit($data.="No modules Found");
        $data.= "<table><tbody>";

        foreach($workstations_data as $wkstation){
            $line_breaker = 0;
            $total_wip = 0;
            $sewing_wip = '';
            $jobs_wip ='';
            $data.= "<tr rowspan=2>";
            $data.="<td rowspan=2 class='mod-td'><span class='mod-no'><b>". $wkstation['workstation_code']."</b></span></td>";


             /*  BLOCK - 1 */
            $sewing_wip = getsewingJobsData($section, $wkstation['workstation_code'],$get_operation, $session_plant_code);
            $data.="<td rowspan=1 class='cut-td'>";
            $data.= $sewing_wip;
            $data.="&nbsp;</td>";

          /* BLOCK -2 */
                $data.="<td rowspan=2 class='wip-td'>";    
                $data.="<span class=''><b>$totalwip</b></span>";
                $data.="</td>";

 
            $data.="</tr>";

        }//modules loop ending
}else{
    $data = "Section Data Not Found";
}

$data.="</tbody></table>";
$section_data['data'] = $data;
$section_data['java_scripts'] = $jquery_data;
echo json_encode($section_data);

?>

<?php

function getsewingJobsData($section,$wkstation,$get_operation, $session_plant_code)
{
  include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/sfcs_app/common/config/functions_v2.php');


    $result_planned_jobs = getPlannedJobs($wkstation, TaskTypeEnum::SEWINGJOB, $session_plant_code);

    $job_number = $result_planned_jobs['job_number'];
    $task_header_id = $result_planned_jobs['task_header_id'];
    $task_job_ids = $result_planned_jobs['task_job_ids'];
    $task_job_header_log = $result_planned_jobs['task_header_log_time'];

    foreach ($task_job_ids as $task_job_id => $task_header_id_j) {
        $log_time = $task_job_header_log[$task_header_id_j];

        //TO GET STYLE AND COLOR FROM TASK ATTRIBUTES USING TASK HEADER ID
        $job_detail_attributes = [];
        $qry_toget_style_sch = "SELECT * FROM $tms.task_attributes where task_jobs_id =' $task_job_id' and plant_code='$session_plant_code'";
        $qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("Sql Error at toget_style_sch" . mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($row2 = mysqli_fetch_array($get_details_result)) {

            $job_detail_attributes[$row2['attribute_name']] = $row2['attribute_value'];
        }
        $style = $job_detail_attributes[$sewing_job_attributes['style']];
        $color = $job_detail_attributes[$sewing_job_attributes['color']];
        $co_no = $job_detail_attributes[$sewing_job_attributes['cono']];
        $schedule = $job_detail_attributes[$sewing_job_attributes['schedule']];
        $cut_no = $job_detail_attributes[$sewing_job_attributes['cutjobno']];
        $docket_number = $job_detail_attributes[$sewing_job_attributes['docketno']];
        $job_num = $job_detail_attributes[$sewing_job_attributes['sewingjobno']];


        $task_job_trans = "SELECT * FROM $tms.task_job_transactions where task_jobs_id ='$task_job_id' and operation='$get_operation'";
        $task_job_trans_result = mysqli_query($link_new, $task_job_trans) or exit("Sql Error at task_job_trans_result" . mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($row_res = mysqli_fetch_array($task_job_trans_result)) {
            $orginal_qty = $row_res['original_qunatity'];
            $good_qty = $row_res['good_quantity'];
            $rej_qty = $row_res['rejected_quantity'];
            $operation_code = $row_res['operation'];
            $operation_seq = $row_res['operation_seq'];
        }

        $task_job_trans = "SELECT * FROM $tms.task_job_transactions where task_jobs_id ='$task_job_id' and operation_seq < $operation_seq order by operation_seq DESC limit 0,1";
        $task_job_trans_result = mysqli_query($link_new, $task_job_trans) or exit("Sql Error at task_job_trans_result" . mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($row_res = mysqli_fetch_array($task_job_trans_result)) {
            $send_qty = $row_res['good_quantity'];
        }
        $wip=$send_qty-$good_qty;
        $totalwip = $totalwip + $wip;
        $input_date=null;
        $remarks=null;

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
        // $href = "$url&module=$module&section=$section&operations=$get_operation";
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
        $docs_data.="<span class='block'>
        <span class='red'>
            <span class='ims-wip'>
            Wip  : $totalwip
                <a  data-toggle='tooltip' data-placement='top' data-title='$tool_tip_text1'>
                    &nbsp;&nbsp;&nbsp;
                </a>
            </span>
          </span>
        </span>"; 


        enough : NULL; 
        $wkstation = str_replace(".","-",$wkstation);
        if($job_num == 0 || $job_num == '')
            $jquery_data.= "<script>$('#cut-wip-td-$wkstation').remove()</script>"; 
        else
            $jquery_data.= "<script>$('#cut-wip-$wkstation').html('$job_num')</script>"; 
    
        return $docs_data; 
}
   
?>