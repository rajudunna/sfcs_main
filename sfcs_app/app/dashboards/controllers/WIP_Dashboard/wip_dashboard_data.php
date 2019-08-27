<?php
error_reporting(0);
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
$section = $_GET['section'];
$get_operation = $_GET['operations'];


$data = '';
$jquery_data = '';
$line_breaker = '';
if($section > 0)
{
   
    //getting all modules against to the section
    $modules_query = "SELECT section_display_name,section_head AS sec_head,ims_priority_boxs,GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM $bai_pro3.`module_master` LEFT JOIN $bai_pro3.sections_master ON module_master.section=sections_master.sec_name WHERE section=$section GROUP BY section ORDER BY section + 0";
    //echo  $modules_query;
    $modules_result = mysqli_query($link,$modules_query) or exit($data.="No modules Found");
    while($row = mysqli_fetch_array($modules_result)){
        $modules_str = $row['sec_mods'];
    }
    if($modules_str != '')
    {

        $data.= "<table><tbody>";
        $moduleso = $modules = explode(',',$modules_str);

        foreach($modules as $module)
        {
            $line_breaker = 0;
            $totalwip = '0';
            $sewing_wip = '';
            $jobs_wip ='';
            $data.= "<tr rowspan=2>";
            $data.="<td rowspan=2 class='mod-td'><span class='mod-no'><b>$module</b></span></td>";


             /*  BLOCK - 1 */
            $sewing_wip = getsewingJobsData($section,$module,$get_operation);
            $data.="<td rowspan=2 class='cut-td'>";
            $data.= $sewing_wip;
            $data.="&nbsp;</td>";

            /* BLOCK -2 */
            $get_input_jobs = "select distinct(input_job_no_random_ref) from $bai_pro3.plan_dashboard_input where input_module =$module";
            // echo  $get_input_jobs;
            $result_get_input_jobs = $link->query($get_input_jobs);
            $totalwip = '0';
            while($row = $result_get_input_jobs->fetch_assoc())
            {
            $input_job[] = $row['input_job_no_random_ref'];
            }  
            $job_no =implode(",",$input_job);
            $get_style_details = "select distinct(schedule),style,mapped_color,input_job_no_random_ref,docket_number From $brandix_bts.bundle_creation_data where input_job_no_random_ref in ('".implode("','",$input_job)."') and operation_id=$get_operation";
            //    echo $get_style_details;
            $result_get_style_details = $link->query($get_style_details);
              
            while($row1 = $result_get_style_details->fetch_assoc()) 
            {
                        $style = $row1['style'];
                        $schedule = $row1['schedule'];
                        $color = $row1['mapped_color'];
                        $job_no = $row1['input_job_no_random_ref'];
                        $docket_number = $row1['docket_number'];
            
                
                $ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code=$get_operation";
                $result_ops_seq_check = $link->query($ops_seq_check);
                while($row2 = $result_ops_seq_check->fetch_assoc()) 
                {
                    $ops_seq = $row2['ops_sequence'];
                    $seq_id = $row2['id'];
                    $ops_order = $row2['operation_order'];
                }

                $pre_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_sequence = $ops_seq  AND CAST(operation_order AS CHAR) < '$ops_order' AND operation_code not in (10,200) ORDER BY operation_order DESC LIMIT 1";
                //  echo $pre_ops_check;
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
                $get_jobs = "select input_job_no_random_ref,sum(if(operation_id = $previous_operation,recevied_qty,0)) as previous_output,sum(if(operation_id = $present_operation,recevied_qty,0)) as present_output, cut_number,remarks,input_job_no From $brandix_bts.bundle_creation_data where assigned_module=$module and input_job_no_random_ref in ($job_no) and operation_id in ($previous_operation,$present_operation) GROUP BY input_job_no_random_ref,size_title HAVING SUM(IF(operation_id = $previous_operation,recevied_qty,0)) != SUM(IF(operation_id = $present_operation,recevied_qty,0))";
                // echo $get_jobs;
                $get_jobs_result = $link->query($get_jobs);
                while($row4 = mysqli_fetch_array($get_jobs_result))
                {
                $previous_output = $row4['previous_output'];
                $present_output = $row4['present_output'];   
                $job_no1 = $row4['input_job_no_random_ref'];
                $input_job_no = $row['input_job_no'];
                $remarks = $remarks['remarks'];
                $cut_number = $cut_number['cut_number'];


                //   var_dump($job_no1);
                }
                $wip = $previous_output - $present_output;
                $totalwip = $totalwip+$wip;
        
            }
                  
                $data.="<td rowspan=2 class='wip-td'>";    
                $data.="<span class='ims-wip $wip_color'><b>WIP : $totalwip</b></span>";
                $data.="</td>";
            
        
            $data.="</tr>";
        }
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

   function getsewingJobsData($section,$module,$get_operation)
   {
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');

        $get_input_jobs = "select distinct(input_job_no_random_ref) from $bai_pro3.plan_dashboard_input where input_module =$module";
        // echo  $get_input_jobs;
        $result_get_input_jobs = $link->query($get_input_jobs);
        while($row = $result_get_input_jobs->fetch_assoc())
        {
        $input_job[] = $row['input_job_no_random_ref'];
        }  
        // $job_no =implode(" ",$input_job);

        $get_style_details = "select distinct(schedule),style,mapped_color,input_job_no_random_ref,docket_number From $brandix_bts.bundle_creation_data where input_job_no_random_ref in ('".implode("','",$input_job)."') and operation_id=$get_operation";
        // echo $get_style_details;
        $result_get_style_details = $link->query($get_style_details);
        $totwip=0;
        while($row1 = $result_get_style_details->fetch_assoc()) 
        {
            $style = $row1['style'];
            $schedule = $row1['schedule'];
            $color = $row1['mapped_color'];
            $job_no = $row1['input_job_no_random_ref'];
            $docket_number = $row1['docket_number'];
           

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
           
                while($row3 = $result_pre_ops_check->fetch_assoc()) 
                {
                    $pre_ops_code = $row3['operation_code'];
                }
            
            $previous_operation = $pre_ops_code;
            $present_operation = $get_operation;

            $get_jobs = "select input_job_no_random_ref,sum(if(operation_id = $previous_operation,recevied_qty,0)) as previous_output,sum(if(operation_id = $present_operation,recevied_qty,0)) as present_output, cut_number,remarks,input_job_no From $brandix_bts.bundle_creation_data where assigned_module=$module and input_job_no_random_ref =$job_no and operation_id in ($previous_operation,$present_operation) GROUP BY input_job_no_random_ref,size_title HAVING SUM(IF(operation_id = $previous_operation,recevied_qty,0)) != SUM(IF(operation_id = $present_operation,recevied_qty,0))";
                // echo $get_jobs;
                $get_jobs_result = $link->query($get_jobs);
                while($row4 = mysqli_fetch_array($get_jobs_result))
                {
                $previous_output = $row4['previous_output'];
                $present_output = $row4['present_output'];   
                $job_no1 = $row4['input_job_no_random_ref'];
                $input_job_no = $row4['input_job_no'];
                $remarks = $row4['remarks'];
                $cut_number = $row4['cut_number'];
            //   var_dump($job_no1);
            }
            $sql33="select COALESCE(SUM(IF(qms_tran_type=3,qms_qty,0)),0) AS rejected from $bai_pro3.bai_qms_db where input_job_no=$input_job_no";
            $sql333 =   $link->query($sql33);
            while($row5 = mysqli_fetch_array($sql333))
            {
              $rejected = $row5['rejected'];
            }
            $sql44="select ims_date from $bai_pro3.ims_log where input_job_no_ref=$input_job_no";
            $sql44 =   $link->query($sql44);
            while($row44 = mysqli_fetch_array($sql44))
            {
              $ims_date = $row44['ims_date'];
            }
             $wip = $previous_output - $present_output;
             // var_dump($wip);
            for($x=0;$x<sizeof($job_no1);$x++)
            {
            $tool_tip_text = "<p style=\"width=800,height=600 \" >
            <v><c>Style </c> : $style </v>
            <v><c>Schedule </c> : $schedule</v>
            <v><c>Color </c> : $color</v>
            <v><c>Docket No </c> : $docket_number</v>
            <v><c>Wip </c> : $wip</v>
            <v><c>input_job_no </c> : $input_job_no</v>
             <v><c>cut_number </c> : $cut_number</v>
             <v><c>remarks </c> : $remarks</v>
             <v><c>rejected </c> : $rejected</v>
             <v><c>ims_date </c> : $ims_date</v>

            
            </p>";
            $href= "$url&module=$module&section=$section&operations=$get_operation";
            $docs_data.="<span class='block' style=float:left;>
            <span class='cut-block blue' >
                <span class='mytooltip'>
                    <a rel='tooltip' data-toggle='tooltip' data-placement='top' data-title='$tool_tip_text'
                    onclick=\"window.open('index.php?r=$href','yourWindowName','width=800,height=600')\"
                    data-html='true'>
                        &nbsp;&nbsp;&nbsp;
                    </a>
                </span>
            </span>
            </span>"; 
            }
        }
      
            enough : NULL; 
            $module1 = str_replace(".","-",$module);
            if($totalwip == 0 || $totalwip == '')
                $jquery_data.= "<script>$('#cut-wip-td-$module1').remove()</script>"; 
            else
                $jquery_data.= "<script>$('#cut-wip-$module1').html('$totalwip')</script>"; 
        
            return $docs_data; 
    
    }
    ?>