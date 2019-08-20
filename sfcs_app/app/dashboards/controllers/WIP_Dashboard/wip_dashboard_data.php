<?php
error_reporting(0);
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
$section = $_GET['section'];
$get_operation = $_GET['operations'];


$data = '';
$jquery_data = '';
$line_breaker = 0;
if($section > 0){
   
    //getting all modules against to the section
    $modules_query = "SELECT section_display_name,section_head AS sec_head,ims_priority_boxs,GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM $bai_pro3.`module_master` LEFT JOIN $bai_pro3.sections_master ON module_master.section=sections_master.sec_name WHERE section=$section GROUP BY section ORDER BY section + 0";
    //echo  $modules_query;
    $modules_result = mysqli_query($link,$modules_query) or exit($data.="No modules Found");
    while($row = mysqli_fetch_array($modules_result)){
        $modules_str = $row['sec_mods'];
    }
    if($modules_str != ''){

        $data.= "<table><tbody>";
        $moduleso = $modules = explode(',',$modules_str);

        foreach($modules as $module){
            $line_breaker = 0;
            $total_wip = 0;
            $sewing_wip = '';
            $jobs_wip ='';
            $data.= "<tr rowspan=2>";
            $data.="<td rowspan=2 class='mod-td'><span class='mod-no'><b>$module</b></span></td>";


             /*  BLOCK - 1 */
            $sewing_wip = getsewingJobsData($section,$module,$get_operation);
            $data.="<td rowspan=1 class='cut-td'>";
            $data.= $sewing_wip;
            $data.="&nbsp;</td>";


 
            $data.="</tr>";

        }//modules loop ending
        
    }else{
        //This Section Has No Modules
    }
}else{
    $data = "Section Data Not Found";
}

$data.="</tbody></table>";
$section_data['data'] = $data;
$section_data['java_scripts'] = $jquery_data;
echo json_encode($section_data);

?>

<?php

   function getsewingJobsData($section,$module,$get_operation)
   {
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');

    // $get_style_details = "select order_style_no,order_del_no,order_col_des from $bai_pro3.bai_orders_db_confirm";
    // $result_get_style_details = $link->query($get_style_details);
    // while($row = $result_get_style_details->fetch_assoc())
    // {
    //     $style = ['order_style_no'];
    //     $schedule= ['order_del_no'];
    //     $color= ['order_col_des'];
    // }
   

    

    $get_input_jobs = "select distinct(input_job_no_random_ref) from $bai_pro3.plan_dashboard_input where input_module =$module";
   // echo  $get_input_jobs;
    $result_get_input_jobs = $link->query($get_input_jobs);
    while($row = $result_get_input_jobs->fetch_assoc())
    {
      $input_job[] = $row['input_job_no_random_ref'];
    }  

        $get_style_details = "select distinct(schedule),style,mapped_color,input_job_no_random_ref From $brandix_bts.bundle_creation_data where input_job_no_random_ref in ('".implode("','",$input_job)."') and operation_id=$get_operation";
       // echo $get_style_details;
        $result_get_style_details = $link->query($get_style_details);
        while($row1 = $result_get_style_details->fetch_assoc()) 
        {
            $style = $row1['style'];
            $schedule = $row1['schedule'];
            $color = $row1['mapped_color'];
            $job_no = $row1['input_job_no_random_ref'];

            $ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code=$get_operation";
            $result_ops_seq_check = $link->query($ops_seq_check);
            while($row2 = $result_ops_seq_check->fetch_assoc()) 
            {
                $ops_seq = $row2['ops_sequence'];
                $seq_id = $row2['id'];
                $ops_order = $row2['operation_order'];
            }

            $pre_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_sequence = $ops_seq  AND CAST(operation_order AS CHAR) < '$ops_order' AND operation_code not in (10,200) ORDER BY operation_order DESC LIMIT 1";
             //echo $pre_ops_check;
            $result_pre_ops_check = $link->query($pre_ops_check);
            if($result_pre_ops_check->num_rows > 0)
            {
                while($row3 = $result_pre_ops_check->fetch_assoc()) 
                {
                    $pre_ops_code = $row3['operation_code'];
                }
            }
            $previous_operation = $pre_ops_code;
            $present_operation = $get_operation;

            $get_jobs = "select sum(if(operation_id = $previous_operation,recevied_qty,0)) as previous_output,sum(if(operation_id = $present_operation,recevied_qty,0)) as present_output From $brandix_bts.bundle_creation_data where assigned_module=$module and input_job_no_random_ref = '$job_no' and operation_id in ($previous_operation,$present_operation) GROUP BY input_job_no_random_ref,size_title HAVING SUM(IF(operation_id = $previous_operation,recevied_qty,0)) != SUM(IF(operation_id = $present_operation,recevied_qty,0))";
            //echo $get_jobs;
            $get_jobs_result = $link->query($get_jobs);
            while($row4 = mysqli_fetch_array($get_jobs_result))
            {
              $previous_output = $row4['previous_output'];
              $present_output = $row4['present_output'];   
            }

            $wip = $previous_output - $present_output;
        }
    }
?>