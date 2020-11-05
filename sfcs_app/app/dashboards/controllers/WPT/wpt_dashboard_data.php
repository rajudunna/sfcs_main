<?php
error_reporting(0);
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/enums.php');
$url = base64_encode('/sfcs_app/app/dashboards/controllers/Cut_table_dashboard/fabric_requisition.php');
$section = $_GET['section'];
$blocks_per_sec = $_GET['blocks'];

$data = '';
$jquery_data = '';
$final_wip = array();
$line_breaker = 0;
if($section){
    $docket_cqty = array();
    //getting all modules against to the section
    $modules = getWorkstationsForSectionId($plant_code, $section);
    if(sizeof($modules) > 0){
        $data.= "<table><tbody>";
        foreach($modules as $module){
            $line_breaker = 0;
            $total_wip = 0;
            $docs_wip = '';
            $jobs_wip ='';
            $data.= "<tr rowspan=2>";
            $data.="<td rowspan=2 class='mod-td'><span class='mod-no'><b>".$module['workstationDesc']."</b></span></td>";

            
            /*  BLOCK - 1 */
            // Get task jobs ids for the workstation
            $taskJobIds = [];
            $minGoodQty = 0;
            $maxGoodQty = 0;
            $taskJobsResult = getJobsForWorkstationIdTypeSewing($plant_code, $module['workstationId']);
            if(sizeof($taskJobsResult) > 0) {
                foreach ($taskJobsResult as $taskJob) {
                    array_push($taskJobIds, $taskJob['taskJobId']);
                }
            }   
            if(sizeof($taskJobIds) > 0) {
                $minGoodQty = getMinOperationQty($plant_code,$taskJobIds);
                $maxGoodQty = getMaxOperationQty($plant_code,$taskJobIds);
            }

            $ims_wip = $minGoodQty - $maxGoodQty;
            
            $wip_color = '';
            if($ims_wip <= 0)
                $ims_wip = 0;
            if($ims_wip > 0 && $ims_wip <= 216)
                $wip_color = 'gloss-red';
            elseif($ims_wip >= 751)  
                $wip_color = 'gloss-black';
            else
                $wip_color = 'gloss-green';

            if($ims_wip == '')
                $ims_wip = 0;
            else{              
                $data.="<td rowspan=2 class='wip-td'>";    
                $data.="<span class='ims-wip $wip_color'><b>WIP : $ims_wip</b></span>";
                $data.="</td>";
            }

            /*  BLOCK - 2  */
            $data.="<td rowspan=2 class='wip-td' id='cut-wip-td-".$module['workstationId']."'>";
            $data.="    <span class='cut-wip blue'><b>CWIP : <span id='cut-wip-".$module['workstationId']."'></span></b></span>";
            $data.="</td>"; 
            
            /*  BLOCK - 3 */
            $docs_wip = getCutWipAndDocketsForModule($plant_code,$section,$module,$blocks_per_sec,$ims_wip);
            $data.="<td rowspan=1 class='cut-td'>";
            $data.= $docs_wip;
            $data.="&nbsp;</td>";

            $data.="</tr>";

        }//modules loop ending    
        $data.="</tbody></table>";
    }    
    
    $section_data['data'] = $data;
    $section_data['java_scripts'] = $jquery_data;
    echo json_encode($section_data);
}

?>


<?php
    /**
     * Get Setions for department type 'SEWING' and plant code
     */
    function getSectionByDeptTypeSewing($plantCode){
        global $pms;
        global $link_new;
        try{
            $departmentType = DepartmentTypeEnum::SEWING;
            $sectionsQuery = "select section_id,section_code,section_name from $pms.sections as sec left join $pms.departments as dept on sec.department_id = dept.department_id where sec.plant_code='".$plantCode."' and dept.plant_code='".$plantCode."' and dept.department_type= '".$departmentType."' and sec.is_active=1";
            $sectionsQueryResult = mysqli_query($link_new,$sectionsQuery) or exit('Problem in getting sections');
            if(mysqli_num_rows($sectionsQueryResult)>0){
                $sections = [];
                while($row = mysqli_fetch_array($sectionsQueryResult)){
                    $sectionRecord = [];
                    $sectionRecord["sectionId"] = $row['section_id'];
                    $sectionRecord["sectionCode"] = $row["section_code"];
                    $sectionRecord["sectionName"] = $row["section_name"];
                    array_push($sections, $sectionRecord);
                }
                return $sections;
            } else {
                return "Sections not found";
            }
        } catch(Exception $e) {
            throw $error;
        }
    }

    /**
     * get workstations for plant code and section id
     */
    function getWorkstationsForSectionId($plantCode, $sectionId) {
        global $pms;
        global $link_new;
        try{
            $workstationsQuery = "select workstation_id,workstation_code,workstation_description,workstation_label from $pms.workstation where plant_code='".$plantCode."' and section_id= '".$sectionId."' and is_active=1";
            $workstationsQueryResult = mysqli_query($link_new,$workstationsQuery) or exit('Problem in getting workstations');
            if(mysqli_num_rows($workstationsQueryResult)>0){
                $workstations= [];
                while($row = mysqli_fetch_array($workstationsQueryResult)){
                    $workstationRecord = [];
                    $workstationRecord["workstationId"] = $row['workstation_id'];
                    $workstationRecord["workstationCode"] = $row["workstation_code"];
                    $workstationRecord["workstationDesc"] = $row["workstation_description"];
                    $workstationRecord["workstationLabel"] = $row["workstation_label"];
                    array_push($workstations, $workstationRecord);
                }
                return $workstations;
            }
        } catch(Exception $e) {
            throw $error;
        }
    }

    /**
     * get planned sewing jobs(JG) for the workstation
     */
    function getJobsForWorkstationIdTypeSewing($plantCode, $workstationId) {
        global $tms;
        global $link_new;
        try{
            $taskType = TaskTypeEnum::SEWINGJOB;
            $taskStatus = TaskStatusEnum::INPROGRESS;
            $jobsQuery = "select tj.task_jobs_id, tj.task_job_reference from $tms.task_header as th left join $tms.task_jobs as tj on th.task_header_id=tj.task_header_id where tj.plant_code='".$plantCode."' and th.resource_id='".$workstationId."' and tj.task_type='".$taskType."' and th.task_status = '".$taskStatus."'";
            $jobsQueryResult = mysqli_query($link_new,$jobsQuery) or exit('Problem in getting jobs in workstation');
            if(mysqli_num_rows($jobsQueryResult)>0){
                $jobs= [];
                while($row = mysqli_fetch_array($jobsQueryResult)){
                    $jobRecord = [];
                    $jobRecord["taskJobId"] = $row['task_jobs_id'];
                    $jobRecord["taskJobRef"] = $row['task_job_reference'];
                    array_push($jobs, $jobRecord);
                }
                return $jobs;
            }
        } catch(Exception $e) {
            throw $error;
        }
    }

    /**
     * get min operation reported quantity
     */
     function getMinOperationQty($plantCode, $taskJobIds) {
        global $tms;
        global $link_new;
        try{
            $minGoodQty = 0;
            $qrytoGetMinOperation="SELECT 
            sum(good_quantity) as good_quantity FROM $tms.`task_job_status` WHERE task_jobs_id IN ('".implode("','" , $taskJobIds)."') AND plant_code='$plantCode' AND is_active=1 ORDER BY operation_seq ASC LIMIT 0,1";
            $minOperationResult = mysqli_query($link_new,$qrytoGetMinOperation) or exit('Problem in getting operations data for job');
            $goodQty = mysqli_fetch_assoc($minOperationResult);
            ($goodQty['good_quantity'])? $minGoodQty= $goodQty['good_quantity']: $minGoodQty = 0;
            return $minGoodQty;
        }  catch(Exception $e) {
            throw $error;
        }
     }

     /**
     * get max operation reported quantity
     */
    function getMaxOperationQty($plantCode, $taskJobIds) {
        global $tms;
        global $link_new;
        try{
            $maxGoodQty = 0;
            $qrytoGetMaxOperation="SELECT 
            sum(good_quantity) as good_quantity FROM $tms.`task_job_status` WHERE task_jobs_id IN ('".implode("','" , $taskJobIds)."')  AND plant_code='$plantCode' AND is_active=1 ORDER BY operation_seq DESC LIMIT 0,1";
            $maxOperationResult = mysqli_query($link_new,$qrytoGetMaxOperation) or exit('Problem in getting operations data for job');
            $goodQty = mysqli_fetch_assoc($maxOperationResult);
            ($goodQty['good_quantity'])? $minGoodQty= $goodQty['good_quantity']: $minGoodQty = 0;
            return $maxGoodQty;
        }  catch(Exception $e) {
            throw $error;
        }
    }

    /**
     * gets cut wip and dockets which are not reported for every module
     */
    function getCutWipAndDocketsForModule($plantCode,$section,$module,$blocks,$ims_wip) {
        global $link_new;
        global $tms;
        global $pps;
        global $pts;
        global $jquery_data;
        global $line_breaker;
        global $url;
        try {
            $cut_op_code = 15;
            $workstationId = $module['workstationId'];
            $cut_wip = 0; 
            $totalCutReportedQty = 0;
            $totalOpReportedQty = 0;
            $docs_data = '';
            $temp_line_breaker = 0;
            $break_me_at = 6;
            if($ims_wip == 0){
                $break_me_at = 11; 
            }
            $taskAttributeName = TaskAttributeNamesEnum::DOCKETNO;
            // Module wise sewing jobs. // task jobs
            $taskJobsResult = getJobsForWorkstationIdTypeSewing($plantCode, $workstationId);
            if(sizeof($taskJobsResult) > 0) {
                $allDockets = [];
                // get all the dockets for each Sewing job
                foreach ($taskJobsResult as $taskJob) {
                    $docketsQuery = "select attribute_value from $tms.task_attributes where attribute_name='".$taskAttributeName."' and task_jobs_id='".$taskJob['taskJobId']."' and plant_code='".$plantCode."'";
                    $docketsQueryResult = mysqli_query($link_new,$docketsQuery) or exit('Problem in getting dockets for sewing job');
                    $row = mysqli_fetch_assoc($docketsQueryResult);
                    ($row['attribute_value'])? $docketstring= $row['attribute_value']: $docketstring = '';
                    if($docketstring) {
                        $dockets = explode(",", $docketstring);
                    } else {
                        $dockets = [];
                    }
                    if(sizeof($dockets) > 1) {
                        foreach ($dockets as $docket) {
                            array_push($allDockets, $docket);
                        }
                    } else if(sizeof($dockets) == 1) {
                        array_push($allDockets, $dockets[0]);
                    }
                }
                $uniqueDockets = array_unique($allDockets);
                $docketLineIds = [];
                if(sizeof($uniqueDockets) > 0) {
                    // get dockets which are main component group
                    $jmDocketLineIdsQuery = "select doclines.jm_docket_line_id from $pps.jm_docket_lines as doclines left join $pps.jm_dockets as docs on doclines.jm_docket_id = docs.jm_docket_id left join $pps.lp_ratio_component_group as ratiocompgroups on docs.ratio_comp_group_id = ratiocompgroups.lp_ratio_cg_id left join $pps.lp_component_group as cg on ratiocompgroups.component_group_id = cg.lp_cg_id where doclines.docket_line_number IN ('".implode("','" , $uniqueDockets)."') and doclines.plant_code='".$plantCode."' and cg.is_main_component_group = 1";
                    $docketLineIdsResult = mysqli_query($link_new,$jmDocketLineIdsQuery) or exit('Problem in getting docket ids');
                    if(mysqli_num_rows($docketLineIdsResult)>0){
                        while($row = mysqli_fetch_array($docketLineIdsResult)){
                            array_push($docketLineIds, $row['jm_docket_line_id']); 
                        }
                    }
                }

                // Loop through dockets and check weather cut is reported or not check for fabric requested dockets
                if(sizeof($docketLineIds) > 0) {
                    foreach ($docketLineIds as $docketId) {
                        $reportedPlies = 0;
                        $docketPlies = 0;
                        $sizeRatioSum = 0;
                        // Get sum of size ratio for the docket
                        $getRatioQuery = "select jcj.ratio_id from $pps.jm_cut_job as jcj left join $pps.jm_dockets as jd on jcj.jm_cut_job_id = jd.jm_cut_job_id left join $pps.jm_docket_lines as jdl on jd.jm_docket_id = jdl.jm_docket_id where jdl.jm_docket_line_id='".$docketId."' and jdl.plant_code='".$plantCode."'";
                        $ratioResult = mysqli_query($link_new,$getRatioQuery) or exit('Problem in getting ratio for  docket');
                        $row = mysqli_fetch_assoc($ratioResult);
                        ($row['ratio_id'])? $ratioId= $row['ratio_id']: $ratioId = '';

                        if($ratioId) {
                            $ratioSizeQuery = "select sum(size_ratio) as size_ratio from $pps.lp_ratio_size where ratio_id = '".$ratioId."' and plant_code='".$plantCode."'";
                            $ratioSizeResult = mysqli_query($link_new,$ratioSizeQuery) or exit('Problem in getting ratio sizes for ratio');
                            $row = mysqli_fetch_assoc($ratioSizeResult);
                            ($row['size_ratio'])? $sizeRatioSum= $row['size_ratio']: $sizeRatioSum = 0;
                        } else {
                            $sizeRatioSum = 0;
                        }
                        

                        // Get actual reported plies for the docket
                        $cutReportedQuery = "select sum(plies) as plies from $pps.lp_lay where jm_docket_line_id = '".$docketId."' and plant_code='".$plantCode."'";
                        $cutReportedResult = mysqli_query($link_new,$cutReportedQuery) or exit('Problem in getting reported docket data');
                        $row = mysqli_fetch_assoc($cutReportedResult);
                        ($row['plies']) ? $reportedPlies = $row['plies'] * $sizeRatioSum: $reportedPlies = 0;
                       
                        // Get original plies for the docket
                        $docketLineQuery = "select plies from $pps.jm_docket_lines where jm_docket_line_id = '".$docketId."' and plant_code='".$plantCode."'";
                        $docketResult = mysqli_query($link_new,$docketLineQuery) or exit('Problem in getting docket data');                        
                        $row = mysqli_fetch_assoc($docketResult);
                        ($row['plies']) ? $docketPlies = $row['plies'] * $sizeRatioSum: $docketPlies = 0;

                        $status_color = '';
                        if($docketPlies > 0) {
                            if($docketPlies === $reportedPlies) {
                                //docket fully reported check for cutting wip
                                $totalCutReportedQty += $reportedPlies;
                            }else {
                                $remaingPlies = 0;
                                // docket is either partially reported or not at all reported
                                if($reportedPlies < $docketPlies && $reportedPlies > 0){
                                    $status_color = 'orange';
                                    $remaingPlies = $docketPlies - $reportedPlies;
                                }else {                         
                                    $fabric_status_query="SELECT fabric_status from $pps.requested_dockets where jm_docket_line_id = '".$docketId."' and plant_code='".$plantCode."'";
                                    $fabric_status_result=mysqli_query($link_new, $fabric_status_query) or exit('fabric status error');
                                    $row = mysqli_fetch_assoc($fabric_status_result);
                                    if($row['fabric_status']){
                                        $fabric_req = 5;
                                        $fabric_status = $row['fabric_status'];
                                    } else {
                                        $fabric_req = 0;
                                    }
                            
                                    if($cut_status == 5)
                                        $status_color = 'blue';
                                    elseif($fabric_status == 5)
                                        $status_color = 'yellow';
                                    elseif($fabric_status == 1)    
                                        $status_color = 'pink';
                                    elseif($fabric_req == 5)
                                        $status_color = 'green';
                                    elseif($fabric_status < 5){
                                        switch($ft_status){
                                            case "1":{ $status_color="lgreen"; break; }
                                            case "0":{ $status_color="red";    break; }
                                            case "2":{ $status_color="red";    break; }
                                            case "3":{ $status_color="red";    break; }
                                            case "4":{ $status_color="red";    break; }
                                            default :{ $status_color="yash";   break; }
                                        }
                                    }else{
                                        $status_color = 'yash';
                                    }
                                }
    
                                $line_breaker++;
                                $temp_line_breaker++; //remove for 4,8 divisions
                                if(($line_breaker-1) == $blocks)
                                    goto enough;
                                if($blocks <= 8){
                                    if($line_breaker == $break_me_at){
                                        $docs_data.='&nbsp;<br/>';
                                    }
                                }else if($blocks > 8){
                                    if($temp_line_breaker == $break_me_at){
                                        $temp_line_breaker = 1; //remove for 4,8 divisions
                                        $docs_data.='&nbsp;<br/>';
                                    }  
                                }
                                // Get docket data for display box from tms task jobs and attributes
                                $taskJobQuery = "select task_jobs_id from $tms.task_jobs where task_job_reference = '".$docketId."' and plant_code='".$plantCode."'";
                                $taskJobResult = mysqli_query($link_new,$taskJobQuery) or exit('Problem in getting task job for docket');
                                $row = mysqli_fetch_assoc($taskJobResult);
                                $taskJobId = $row['task_jobs_id']; 
    
                                $attributeData = [];
                                $taskAttributesQuery = "select attribute_name,attribute_value from $tms.task_attributes where task_jobs_id = '".$taskJobId."' and plant_code='".$plantCode."'";
                                $taskAttributesResult = mysqli_query($link_new,$taskAttributesQuery) or exit('Problem in getting task attributes for task job');
                                if(mysqli_num_rows($taskAttributesResult)>0){
                                    while($row = mysqli_fetch_array($taskAttributesResult)){
                                        $attributeData[$row['attribute_name']] = $row['attribute_value'];
                                    }
                                }
    
                                // Get Schedules for Po Number
                                $poNumber = $attributeData[TaskAttributeNamesEnum::PONUMBER];
                               
                                $schedulesQuery = "SELECT GROUP_CONCAT(DISTINCT mpo.schedule) AS schedules FROM $pps.`mp_mo_qty` AS mpo LEFT JOIN $pps.`mp_sub_mo_qty` AS mspo ON mpo.`mp_mo_qty_id` = mspo.`mp_mo_qty_id` WHERE mspo.po_number = '".$poNumber."' and mspo.plant_code='".$plantCode."'";
                                $schedulesResult = mysqli_query($link_new,$schedulesQuery) or exit('Problem in getting schedules');
                                $row = mysqli_fetch_assoc($schedulesResult);
                                $schedules = $row['schedules'];
                                $tool_tip_text = "<p style=\"width : 500px\">
                                        <v><c>Style</c> :".$attributeData[TaskAttributeNamesEnum::STYLE]."</v><v><c>Schedule No</c> : ".$schedules."</v>
                                        <v><c>Colors</c> : ".$attributeData[TaskAttributeNamesEnum::COLOR]."</v>
                                        <v><c>Dockets</c> : ".$attributeData[TaskAttributeNamesEnum::DOCKETNO]."</v>
                                        <v><c>Cut No : </c> ".$attributeData[TaskAttributeNamesEnum::CUTJOBNO]."</v>
                                        <v><c>Docket Qty : </c>$docketPlies</v>                                    
                                        <v><c>Cut Remaining Qty </c>:$remaingPlies</v>
                                    </p>";
                                $sidemenu=true;
                                $doc_no = $attributeData[TaskAttributeNamesEnum::DOCKETNO];
                                $href= "$url&module=$workstationId&section=$section&doc_no=$doc_no&sidemenu=$sidemenu&group_docs=$doc_no";
                                $docs_data.="<span class='block'>
                                                <span class='cut-block $status_color'>
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
                    }
                }
                $totalOpReportedQty = getOpReportedQty($taskJobsResult, $plantCode);
                $cut_wip = $totalCutReportedQty - $totalOpReportedQty;
            }            
            enough : NULL; 
            if($cut_wip == 0 || $cut_wip == '')
                $jquery_data.= "<script>$('#cut-wip-td-$workstationId').remove()</script>"; 
            else
                $jquery_data.= "<script>$('#cut-wip-$workstationId').html('$cut_wip')</script>"; 

            return $docs_data; 
        }  catch(Exception $e) {
            throw $error;
        }
    }

    /**
     * get sew/emb job related cut after operation related reported quantity
     */
    function getOpReportedQty($taskJobsResult, $plantCode) {
        global $link_new;
        global $tms;
        global $pps;
        global $pts;
        try{
            // get all the dockets for each Sewing job
            foreach ($taskJobsResult as $taskJob) {
                $attributeData = [];
                $taskAttributesQuery = "select attribute_name,attribute_value from $tms.task_attributes where task_jobs_id = '".$taskJob['taskJobId']."' and plant_code='".$plantCode."'";
                $taskAttributesResult = mysqli_query($link_new,$taskAttributesQuery) or exit('Problem in getting task attributes for task job');
                if(mysqli_num_rows($taskAttributesResult)>0){
                    while($row = mysqli_fetch_array($taskAttributesResult)){
                        $attributeData[$row['attribute_name']] = $row['attribute_value'];
                    }
                }

                // Get Schedules for Po Number
                $poNumber = $attributeData[TaskAttributeNamesEnum::PONUMBER];
                $style = $attributeData[TaskAttributeNamesEnum::STYLE];
                $color = explode(',',$attributeData[TaskAttributeNamesEnum::COLOR])[0];

                // get next operation for style color po number
                $nextOpQuery="SELECT fgop.operation_code from $pts.fg_operation  as fgop left join $pts.finished_good as fg on fgop.finished_good_id = fg.finished_good_id  where fg.style = '".$style."' and fg.color='".$color."' and fg.sub_po='".$poNumber."' and fg.plant_code='".$plantCode."' and fgop.previous_operation = '".$cut_op_code."' limit 0,1";
                $nexOpResult=mysqli_query($link_new, $nextOpQuery) or exit('probelm in getting next operation');
                $row = mysqli_fetch_assoc($nexOpResult);
                $nextOpCode = $row['operation_code'];

                // get reported quantity for job and operation code
                if($nextOpCode){
                    $getRepQtyQuery="SELECT SUM(good_quantity + rejected_quantity) as reported_qty FROM $tms.`task_job_status` WHERE task_jobs_id='".$taskJob['taskJobId']."' AND plant_code='$plantCode' AND   operation_code= '$nextOpCode'";
                    $repQtyResult = mysqli_query($link_new,$getRepQtyQuery) or exit('Problem in getting reported quantity');
                    $row = mysqli_fetch_assoc($repQtyResult);
                    ($row['reported_qty'])?$reportedQty = $row['reported_qty']: $reportedQty = 0;
                } else {
                    $reportedQty = 0;
                }                
                $totalOpReportedQty +=  $reportedQty;
            }        
            return $totalOpReportedQty;
        } catch(Exception $e) {
            throw $error;
        }
    }

?>

