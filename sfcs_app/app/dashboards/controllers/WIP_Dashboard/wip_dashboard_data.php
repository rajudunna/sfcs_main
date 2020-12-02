<?php
error_reporting(0);
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
$section = $_GET['section'];
$get_operation = $_GET['operations'];
 $v_r = explode('/',$_SERVER['REQUEST_URI']);
array_pop($v_r);
$popup_url = "http://".$_SERVER['HTTP_HOST'].implode('/',$v_r)."/modules_report.php";

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
    $modules_query = "SELECT section_display_name,section_head AS sec_head,ims_priority_boxs,GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM $bai_pro3.`module_master` LEFT JOIN $bai_pro3.sections_master ON module_master.section=sections_master.sec_name WHERE module_master.status='active' and section=$section GROUP BY section ORDER BY section + 0";
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
            $data.="<td rowspan=2 class='mod-td'><span class='mod-no'><b>
            <a href='javascript:void(0)' onclick='window.open(\"$popup_url?module=$module&operation_code=$get_operation\",\"Popup\");'>
                            $module</a>
        
            </b></span></td>";


             /*  BLOCK - 1 */
            $sewing_wip = getsewingJobsData($section,$module,$get_operation);
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

   $get_style_details = "select distinct(schedule),style,mapped_color,input_job_no_random_ref From $brandix_bts.bundle_creation_data where operation_id=$get_operation and assigned_module='$module' and bundle_qty_status = 0";
    $result_get_style_details = $link->query($get_style_details);
    while($row1 = $result_get_style_details->fetch_assoc()) 
    {
        $style = $row1['style'];
        $schedule = $row1['schedule'];
        $color = $row1['mapped_color'];
        $job_no = $row1['input_job_no_random_ref'];
        $color_ref="'".str_replace(",","','",$color)."'"; 


      
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
        $checking_qry = "SELECT category FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code = '$pre_ops_code'";
        $result_checking_qry = $link->query($checking_qry);
        while($row_cat = $result_checking_qry->fetch_assoc()) 
        {
            $category_act = $row_cat['category'];
        }
        if($category_act == 'sewing')
        {
            $previous_operation = $pre_ops_code;
            $present_operation = $get_operation;
            $inputno ="";
            $previous_output=0;
            $present_output=0;
            $rejected=0;
            $get_jobs = "select cut_number,docket_number,remarks,input_job_no_random_ref,input_job_no,SUM(if(operation_id = $present_operation,rejected_qty,0)) as rejected_qty,sum(if(operation_id = $previous_operation,recevied_qty,0)) as previous_output,sum(if(operation_id = $present_operation,recevied_qty,0)) as present_output From $brandix_bts.bundle_creation_data where assigned_module='$module' and input_job_no_random_ref = '$job_no' and operation_id in ($previous_operation,$present_operation) and (recevied_qty >0 or rejected_qty >0) GROUP BY input_job_no_random_ref HAVING SUM(IF(operation_id = $previous_operation,recevied_qty,0)) !=SUM(IF(operation_id = $present_operation,recevied_qty+rejected_qty,0))";
            // echo $get_jobs;
            $get_jobs_result = $link->query($get_jobs);
            while($row4 = mysqli_fetch_array($get_jobs_result))
            {
              $previous_output = $previous_output+$row4['previous_output'];
              $present_output = $present_output+$row4['present_output'];   
              $job_no1 = $row4['input_job_no_random_ref'];
              $docket_number = $row4['docket_number'];
              $remarks = $row4['remarks'];
              $cut_no = $row4['cut_number'];
              $rejected = $rejected+$row4['rejected_qty'];
              $inputno = $row4['input_job_no'];

            //   var_dump($job_no1);
            }
            // $get_rejected_qty="select sum(rejected_qty) as rejected from $brandix_bts.bundle_creation_data where assigned_module='$module' and input_job_no_random_ref = '$job_no' and operation_id=$present_operation";
            // //echo  $get_rejected_qty;
            // $sql_result33=mysqli_query($link, $get_rejected_qty) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
            // while($sql_row33=mysqli_fetch_array($sql_result33))
            // {
            //      $rejected = $rejected+$sql_row33['rejected'];
            // }
            $sql331="select type_of_sewing from $bai_pro3.pac_stat_log_input_job where input_job_no_random='$job_no'";
            //echo $sql331;
            $sql_result331=mysqli_query($link, $sql331) or exit("Sql Error1111".mysqli_error($GLOBALS["___mysqli_ston"]));      
            while($sql_row331=mysqli_fetch_array($sql_result331))
            {
                $type_of_sewing=$sql_row331['type_of_sewing'];
            }

            $prefix="";
            $sql="SELECT prefix as result FROM $brandix_bts.tbl_sewing_job_prefix WHERE type_of_sewing=$type_of_sewing";
            // echo $sql."<br>";
            $sql_result=mysqli_query($link, $sql) or exit($sql."Sql Error-echo_1<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($sql_row=mysqli_fetch_array($sql_result))
            {
                $prefix = $sql_row['result'];
            }
            $display_prefix1=$prefix.leading_zeros($inputno,3);

            // $sewing_prefi=echo_title("$brandix_bts.tbl_sewing_job_prefix","prefix","id",$type_of_sewing,$link);
            // $display = $sewing_prefi.leading_zeros($inputno,3);

            $color_code=echo_title("$bai_pro3.bai_orders_db_confirm","color_code","order_col_des in (".$color_ref.") and order_del_no",$schedule,$link);
            $display1=chr($color_code).leading_zeros($cut_no,3); 
             $co_no=echo_title("$bai_pro3.bai_orders_db_confirm","co_no","order_del_no",$schedule,$link);


            $sql44="select ims_date from $bai_pro3.ims_log where ims_schedule='$schedule'";
            $sql_result =   $link->query($sql44);
            while($row44 = mysqli_fetch_array($sql_result))
            {
                $input_date = $row44['ims_date'];
            }
            $wip = $previous_output - $present_output;
            
            $totalwip = $totalwip+$wip;
        
         
            for($x=0;$x<sizeof($job_no1);$x++)
            {
                $tool_tip_text = "<p style=\"width : 500px \">
                <v><c>Style </c> : $style </v>
                <v><c>Schedule </c> : $schedule</v>
                <v><c>Color </c> : $color</v>
                <v><c>Co No </c> : $co_no</v>
                <v><c>Input_date </c> : $input_date</v>
                <v><c>Wip </c> : $wip</v>
                <v><c>Job No </c> : $display_prefix1</v>
                <v><c>Cut No </c> :$cut_no</v>
                <v><c>Doc_no </c> : $docket_number</v>
                <v><c>Rejected </c> : $rejected</v>
                <v><c>Remarks </c> : $remarks</v>
              
               </p>";
               $href= "$url&module=$module&section=$section&operations=$get_operation";
                $docs_data.="<span class='block'>
                <span class='cut-block blue'>
                    <span class='mytooltip'>
                        <a rel='tooltip' data-toggle='tooltip' data-placement='top' data-title='$tool_tip_text'
                        onclick=\"window.open('index.php?r=$href','yourWindowName','width=800,height=600')\"
                        data-html='true'>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                        </a>
                    </span>
                </span>
              </span>"; 
            }
            unset($job_no1);
        }
		unset($job_no1);
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
        $module = str_replace(".","-",$module);
        if($job_no == 0 || $job_no == '')
            $jquery_data.= "<script>$('#cut-wip-td-$module').remove()</script>"; 
        else
            $jquery_data.= "<script>$('#cut-wip-$module').html('$job_no')</script>"; 
    
        return $docs_data; 
}
   
?>
