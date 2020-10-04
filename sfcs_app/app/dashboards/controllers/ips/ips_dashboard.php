<?php
// error_reporting(0);
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_dashboard.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_v2.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/enums.php');

$data=array();

$sectionId=$_GET["sec_id"];
$sectionName=$_GET["sec_name"];
$plantCode=$_GET["plant_code"];
$username=$_GET["username"];
$priorityLimit=$_GET["priority_limit"];
$getModuleDetails = getWorkstationsForSectionId($plantCode,$sectionId);
$v_r = explode('/',$_SERVER['REQUEST_URI']);
array_pop($v_r);
$popup_url = "http://".$_SERVER['HTTP_HOST'].implode('/',$v_r)."/board_update_V2_input.php";
$ips_data='<div style="margin-left:15%">';
$ips_data.="<p>";
$ips_data.="<table>";
$ips_data.="<tr><th colspan=2><h2><a href=\"javascript:void(0)\" onclick=\"Popup=window.open('$popup_url?section_no=$sectionId"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=880,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$sectionName</a></h2></th></th></tr>";
foreach($getModuleDetails as $moduleKey =>$moduleRecord)
{
    //HardCoded
    $module=$moduleRecord['workstationId'];
    $workstationID =$moduleRecord['workstationId'];
    $workstationCode =$moduleRecord['workstationCode'];
    //hardcode 
    $wip = 0;
    $ips_data.="<tr class=\"bottom\">";
    $ips_data.="<td class=\"bottom\"><strong><a href=\"javascript:void(0)\" title=\"WIP : $wip\"><font class=\"fontnn\" color=black >$workstationCode</font></a></strong></td><td>";
    
    $getJobDetails = getJobsForWorkstationIdTypeSewing($plantCode,$workstationID, $priorityLimit);
    // foreach($getJobDetails as $jobKey =>$jobRecord)
    $count = 0;
    for ($i=0; $i < sizeOf($getJobDetails); $i++) 
    {
        if($count  === (int)$priorityLimit){
            break;
        }
        
        $jobRecord = $getJobDetails[$i];
        $taskJobId = $jobRecord['taskJobId'];
        $id="yash";
        $y=0;

        $qry_toget_first_ops_qry = "SELECT operation_code,original_quantity,good_quantity,rejected_quantity FROM $tms.task_job_transaction where task_jobs_id = '$taskJobId' and plant_code='$plantCode' and is_active=1 order by operation_seq asc limit 1";
        $qry_toget_first_ops_qry_result = mysqli_query($link_new, $qry_toget_first_ops_qry) or exit("Sql Error at toget_style_sch" . mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($row3 = mysqli_fetch_array($qry_toget_first_ops_qry_result)) {
            $input_ops_code = $row3['operation_code'];
            $input = $row3['good_quantity'];
            $rejection = $row3['rejected_quantity'];
            $carton_qty=$row3["original_quantity"];
            $balance = $carton_qty - ($input+$rejection);
        }
        if($balance > 0)
        {
            $count++;
        $sql="SELECT task_job_id as input_job_no_random_ref,trim_status FROM $tms.job_trims WHERE task_job_id='$taskJobId' and plant_code='$plantCode'";
        $result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($row=mysqli_fetch_array($result))
        {                       
            $input_job_no_random_ref=$row["input_job_no_random_ref"];
            $input_trims_status=$row["trim_status"];
        }
        $add_css="behavior: url(border-radius-ie8.htc);  border-radius: 10px;";
        $job_detail_attributes = [];
        $qry_toget_style_sch = "SELECT attribute_name,attribute_value FROM $tms.task_attributes where task_jobs_id = '$taskJobId' and plant_code='$plantCode' and is_active=1";
        $qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("Sql Error at toget_style_sch" . mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) {
            $job_detail_attributes[$row2['attribute_name']] = $row2['attribute_value'];
        }
        $doc_no_ref = $job_detail_attributes[$sewing_job_attributes['docketno']];
        $doc_no_ref1 = $job_detail_attributes[$sewing_job_attributes['docketno']];
        $doc_no_ref_input = $job_detail_attributes[$sewing_job_attributes['docketno']];
        $style = $job_detail_attributes[$sewing_job_attributes['style']];
        $schedule = $job_detail_attributes[$sewing_job_attributes['schedule']];
        $schedule_no = $job_detail_attributes[$sewing_job_attributes['schedule']];
        $order_col = $job_detail_attributes[$sewing_job_attributes['color']];
        $color_info = $job_detail_attributes[$sewing_job_attributes['color']];
        $cols_de = str_pad("Color:".trim($color_info),80)."\n";
        $input_job_no = $job_detail_attributes[$sewing_job_attributes['sewingjobno']];
        $type_of_sewing = $job_detail_attributes[$sewing_job_attributes['remarks']];
        $co_no = $job_detail_attributes[$sewing_job_attributes['conumber']];
        $cut_job_no = $job_detail_attributes[$sewing_job_attributes['CUTJOBNO']];
        
            $scanning_query12="SELECT operation_name FROM `$pms`.`operation_mapping` WHERE operation_code = '$input_ops_code' AND plant_code = '$plantCode'";
            $scanning_result12=mysqli_query($link, $scanning_query12)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($sql_row123=mysqli_fetch_array($scanning_result12))
            {
                $operation_name=$get_ips_op['operation_name'];
            }
            // For Recut Cut Process IPS NEED to change these queries
            $rej_qty=0; // SELECT sum(carton_act_qty) as qty FROM $bai_pro3.pac_stat_log_input_job WHERE input_job_no_random ='$input_job_no_random_ref' and doc_type='R'
            $rej_qty1=0;//recut sum(recut_in) as qty for tas_job and input_ops_code
            $replce_qty=0;// replace qty sum(replace_in) as qty for tas_job and input_ops_code
            if($rej_qty > 0 or $rej_qty1>0 or $replce_qty)
            {
                $rejection_border = "border-style: solid;border-color: Magenta ;border-width: 3px;";
            }
            else
            {
                $rejection_border = "";
            }           
            //FOR SCHEDULE CLUBBING ensuring for parent docket (V2.0 there is no parent docket scenario always one docket can have multiple schedules)
            $ft_status='1'; // after ffsp integration need to get status against to style,schedules(multiples) and color for the input job random ref(taskJobId) // Currently default 1 assuming that material available in ffsp
            $trims_status=$sql_row33x112['st_status'];
            if($input_trims_status == TrimStatusEnum::PREPARINGMATERIAL)
            {
                $tstatus='Preparing Material';
            }
            elseif($input_trims_status == TrimStatusEnum::MATERIALREADYFORPRODUCTION)
            {
                $tstatus='Material Ready for Production(in Pool)';
            }
            elseif($input_trims_status == TrimStatusEnum::PARTIALISSUED)
            {
                $tstatus='Partial Issued';
                $add_css="";
            }
            else if($input_trims_status == TrimStatusEnum::ISSUED)
            {
                $tstatus='Issued to Module';
                $add_css="";
            }
            else
            {
                $tstatus='Status Not update';
            }   
            $get_color = $order_col;    
            //hardcode
            $display_prefix1 = 'J'; // currently no prefix table in v2.0 after integration should change
            $display_prefix1 = $input_job_no;
            if($schedule!="")
            {
                $doc_no_ref_explode=explode(",",$doc_no_ref);
                $num_docs=sizeof($doc_no_ref_explode);
                $sqlDocketLineIds="SELECT GROUP_CONCAT(CONCAT('''', jm_docket_line_id, '''' ))AS docket_line_ids FROM $pps.`jm_docket_lines` WHERE docket_line_number IN ($doc_no_ref)";
                $sql_resultsqlDocketLineIds=mysqli_query($link, $sqlDocketLineIds) or exit("Sql Error1000".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($docket_row123=mysqli_fetch_array($sql_resultsqlDocketLineIds))
                {
                    $docket_line_ids=$docket_row123['docket_line_ids'];
                }
                if($docket_line_ids)
                {
                    $sql1x1="select * from $pps.jm_docket_lines where lay_status<>'DONE' and docket_line_number in ($doc_no_ref)";
                    $sql_result1x1=mysqli_query($link, $sql1x1) or exit("Sql Error81".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if(mysqli_num_rows($sql_result1x1)>0)
                    {
                        $cut_status="0";
                    }
                    else
                    {
                        $cut_status="5";
                    }
                    // fabric request logic
                    $sql1x115="SELECT *  FROM  `$pps`.`fabric_prorities` WHERE `jm_docket_line_id` IN ($docket_line_ids)";
                    $sql_result1x115=mysqli_query($link, $sql1x115) or exit("Sql Error82".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if(mysqli_num_rows($sql_result1x115)>0)
                    {
                        if(sizeof($doc_no_ref_explode)<>mysqli_num_rows($sql_result1x115))
                        {
                            $fabric_req="0";
                        }
                        else
                        {
                            $fabric_req="5";
                        }   
                    }
                    else
                    {
                        $fabric_req="0";
                    }
                    // fabric status logic
                    $fabric_status="";
                    $sql1x12="SELECT *  FROM  `$pps`.`requested_dockets` WHERE `jm_docket_line_id` IN ($docket_line_ids) and fabric_status='1'";
                    $sql_result1x12=mysqli_query($link, $sql1x12) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if(mysqli_num_rows($sql_result1x12)>0)
                    {
                        if(sizeof($doc_no_ref_explode) == mysqli_num_rows($sql_result1x12))
                        {
                            $fabric_status="1";
                        }
                    }
                    $sql1x11="SELECT *  FROM  `$pps`.`requested_dockets` WHERE `jm_docket_line_id` IN ($docket_line_ids) and fabric_status = '5'";
                    $sql_result1x11=mysqli_query($link, $sql1x11) or exit("Sql Error83".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if(mysqli_num_rows($sql_result1x11)>0)
                    {
                        if(sizeof($doc_no_ref_explode) == mysqli_num_rows($sql_result1x11))
                        {
                            $fabric_status="5";
                        }
                    }
                    if ($fabric_status == "")
                    {
                        $fabric_status="0";
                    }
                    // assigning colors for status based on fabric
                    if($cut_status=="5")
                    {
                        $id="blue";                 
                        $rem="Cut Completed";
                    }
                    elseif($fabric_status=='5')
                    {
                        $id="yellow";                   
                        $rem="Fabric Issued";   
                    }
                    elseif($fabric_status=='1')
                    {
                        $id="pink";                 
                        $rem="Ready To Issue";  
                    }
                    elseif($fabric_req=="5")
                    {
                        $id="green";                    
                        $rem="Fabric Requested";
                    }
                    elseif($fabric_status<"5")
                    {
                        switch ($ft_status)
                        {
                            case "1":
                            {
                                $id="lgreen";                   
                                $rem="Available";
                                break;
                            }
                            case "0":
                            {
                                $id="red";
                                $rem="Not Available";
                                break;
                            }
                            case "2":
                            {
                                $id="red";
                                $rem="In House Issue";
                                break;
                            }
                            case "3":
                            {
                                $id="red";
                                $rem="GRN issue";
                                break;
                            }
                            case "4":
                            {
                                $id="red";
                                $rem="Put Away Issue";
                                break;
                            }                                   
                            default:
                            {
                                $id="yash";
                                $rem="Not Update";
                                break;
                            }
                        }
                    }
                    else
                    {
                        $id="yash";
                        $rem="Not Update";
                    }               
                    $title=str_pad("Style:".$style,50)."\n".str_pad("Co No:".$co_no,50)."\n".str_pad("Schedule:".$schedule,50)."\n". $cols_de.str_pad("Sewing Job No:".$display_prefix1,50)."\n".str_pad("Total Qty:".$carton_qty,50)."\n".str_pad("Balance to Issue:".($balance),50)."\n".str_pad("Cut Job No:".$cut_job_no)."\n".str_pad("Remarks :".$rem,50)."\n".str_pad("Trim Status :".$tstatus,50);
                    //$ui_url='input_status_update_input.php';  
                    $ui_url = "http://".$_SERVER['HTTP_HOST'].implode('/',$v_r)."/input_status_update_input.php";
                    $ui_url1 ='?r='.base64_encode('/sfcs_app/app/production/controllers/sewing_job/sewing_job_scaning/scan_input_jobs.php');
                    $application='IPS';
                    $cols_de='';
                    $sidemenu=true;
                    if($id=="blue" || $id=="yellow")
                    {
                        // SELECT original_quantity 
                        $cut_input_report_query="SELECT original_quantity AS cut_qty, (good_quantity + rejected_quantity) AS report_qty, good_quantity AS recevied_qty FROM tms_prod.`task_job_transaction`
                            WHERE `task_jobs_id` = '$input_job_no_random_ref' AND `operation_code` = '$input_ops_code'";
                        $cut_input_report_result=mysqli_query($link, $cut_input_report_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($sql_row=mysqli_fetch_array($cut_input_report_result))
                        {
                            $cut_origional_qty=$sql_row['cut_qty'];
                            $report_origional_qty=$sql_row['report_qty'];
                            $recevied_qty=$sql_row['recevied_qty'];                                 
                        }
                        
                        if(($cut_origional_qty > $report_origional_qty) && $recevied_qty>0){
                            $id='orange';
                        }
                        /*else{
                            $id='blue';
                        }*/
                        if($id=="yellow")
                        {                                   
                            if($add_css == ""){             
                                $ips_data.="<div id=\"S$schedule\" style=\"float:left;\">
                                    <div id=\"SJ$input_job_no\" style=\"float:left;\">
                                        <div id=\"$input_job_no_random_ref\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id;$add_css.$rejection_border\" title=\"$title\" ><a href=\"javascript:void(0);\" onclick=\"viewPopupCenter('$style','$schedule','$module','$input_job_no','$input_ops_code','$sidemenu','$plantCode','$username');\"><font style=\"color:black;\"></font></a>
                                        </div>
                                    </div>
                                </div>";
                            }
                            else
                            {
                                $ips_data.="<div id=\"S$schedule\" style=\"float:left;\">
                                    <div id=\"SJ$input_job_no\" style=\"float:left;\">
                                        <div id=\"$input_job_no_random_ref\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id;$add_css.$rejection_border\" title=\"$title\" ><a href=\"$ui_url?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no&job_status=$id\" onclick=\"Popup=window.open('$ui_url?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no&job_status=$id','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=auto, top=23'); if (window.focus) {Popup.focus()} return false;\"><font style=\"color:black;\"></font></a>
                                        </div>
                                    </div>
                                </div>";
                            }
                        }
                        else
                        {
                            if($add_css == "")
                            {                                   
                                $ips_data.="<div id=\"S$schedule\" style=\"float:left;\">
                                    <div id=\"SJ$input_job_no\" style=\"float:left;\">
                                        <div id=\"$input_job_no_random_ref\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id;$add_css.$rejection_border\" title=\"$title\" ><a href=\"javascript:void(0);\" onclick=\"viewPopupCenter('$style','$schedule','$module','$input_job_no','$input_ops_code','$sidemenu','$plantCode','$username');\"><font style=\"color:black;\"></font></a>
                                        </div>
                                    </div>
                                </div>";
                            }
                            else
                            {
                                $ips_data.="<div id=\"S$schedule\" style=\"float:left;\">
                                    <div id=\"SJ$input_job_no\" style=\"float:left;\">
                                        <div id=\"$input_job_no_random_ref\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id;$add_css.$rejection_border\" title=\"$title\" ><a href=\"$ui_url?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no&job_status=$id\" onclick=\"Popup=window.open('$ui_url?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no&job_status=$id','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=auto, top=23'); if (window.focus) {Popup.focus()} return false;\"><font style=\"color:black;\"></font></a>
                                        </div>
                                    </div>
                                </div>";
                            }
                        }
                    }
                    else
                    {
                        
                        $ips_data.="<div id=\"S$schedule\" style=\"float:left;\"><div id=\"SJ$input_job_no\" style=\"float:left;\"><div id=\"$input_job_no_random_ref\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id;$add_css.$rejection_border\" title=\"$title\" ><a href=\"$ui_url?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no&job_status=$id\" onclick=\"Popup=window.open('$ui_url?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no&job_status=$id','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><font style=\"color:black;\"></font></a></div></div></div>";
                    }
                    $y++;   
                } 
            }
            $buyer_div = ''; // select buyer_div from $bai_pro3.plan_modules where module_id=$module
        }
    }
    $ips_data.="</tr>";

}
    $ips_data.="</table>";
    $ips_data.="</p>";
    $ips_data.="</div>";

$data['data']=$ips_data;
$data['sec']=$sectionId;
echo json_encode($data);

?>