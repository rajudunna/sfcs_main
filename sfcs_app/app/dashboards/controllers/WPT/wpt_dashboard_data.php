<?php
error_reporting(0);
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/enums.php');
$url = '/sfcs_app/app/dashboards/controllers/rms/fabric_requisition.php';
$url = base64_encode($url);
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
            if(sizeof($taskJobsResult) > 0) {
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
            $docs_wip = getCutDoneJobsData($section,$module,$blocks_per_sec,$ims_wip);
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
            sum(good_quantity) as good_quantity FROM $tms.`task_job_transaction` WHERE task_jobs_id IN ('".implode("','" , $taskJobIds)."') AND plant_code='$plantCode' AND is_active=1 ORDER BY operation_seq ASC LIMIT 0,1";
            $minOperationResult = mysqli_query($link_new,$qrytoGetMinOperation) or exit('Problem in getting operations data for job');
            if(mysqli_num_rows($minOperationResult)>0){
              while($minOperationResultRow = mysqli_fetch_array($minOperationResult)){
                  $minGoodQty=$minOperationResultRow['good_quantity'];
                }
            }
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
            sum(good_quantity) as good_quantity FROM $tms.`task_job_transaction` WHERE task_jobs_id IN ('".implode("','" , $taskJobIds)."')  AND plant_code='$plantCode' AND is_active=1 ORDER BY operation_seq DESC LIMIT 0,1";
            $maxOperationResult = mysqli_query($link_new,$qrytoGetMaxOperation) or exit('Problem in getting operations data for job');
            if(mysqli_num_rows($maxOperationResult)>0){
              while($maxOperationResultRow = mysqli_fetch_array($maxOperationResult)){
                  $maxGoodQty=$maxOperationResultRow['good_quantity'];
              }
            } 
            return $maxGoodQty;
        }  catch(Exception $e) {
            throw $error;
        }
    }

    /**
     * get cut job wip status and dockets display
     */
    function  getCutDoneJobsData($section,$module,$blocks,$ims_wip){
        $scanned_jobs = [];
        global $link_new; 
        global $line_breaker;
        global $sum_str; 
        global $url;
        global $bai_pro3,$brandix_bts;
        global $jquery_data;
        $dockets = array();
        $cutting_op_code = 15;
        $temp_line_breaker = 0;
        // global $ips_op_code;
        $docs_data = '';
        $break_me_at = 6;
        $cut_wip = 0; 
        $org_doc_no = 0;
        //adjusting line breaker
        if($ims_wip == 0){
            $break_me_at = 11; 
        }
        
        $dockets_cqty_query = "SELECT GROUP_CONCAT(DISTINCT '\"',pdi.input_job_no_random_ref,'\"') AS jobs,pslij.doc_no AS doc_no,psl.act_cut_status AS act_cut_status,bodc.order_style_no AS style,psl.acutno AS acutno,bodc.color_code AS color_code,bodc.order_del_no AS schedule,bodc.order_col_des AS color,bodc.ft_status AS ft_status FROM bai_pro3.plan_dashboard_input AS pdi,bai_pro3.pac_stat_log_input_job AS pslij,bai_pro3.plandoc_stat_log AS psl,bai_pro3.bai_orders_db_confirm AS bodc 
        WHERE input_module='$module' AND pdi.input_job_no_random_ref=pslij.input_job_no_random AND psl.doc_no=pslij.doc_no AND psl.order_tid=bodc.order_tid AND psl.a_plies = psl.p_plies AND psl.act_cut_status='DONE' and psl.short_shipment_status=0";
        $dockets_qty_job_qty_query = "SELECT GROUP_CONCAT(DISTINCT '\"',pdi.input_job_no_random_ref,'\"') AS jobs,pslij.doc_no AS doc_no,psl.a_plies AS a_plies,psl.manual_flag as manual_reported,psl.p_plies AS p_plies,psl.act_cut_status AS act_cut_status,bodc.order_style_no AS style,psl.acutno AS acutno,bodc.color_code AS color_code,bodc.order_del_no AS schedule,bodc.order_col_des AS color,bodc.ft_status AS ft_status FROM bai_pro3.plan_dashboard_input AS pdi,bai_pro3.pac_stat_log_input_job AS pslij,bai_pro3.plandoc_stat_log AS psl,bai_pro3.bai_orders_db_confirm AS bodc 
        WHERE input_module='$module' AND pdi.input_job_no_random_ref=pslij.input_job_no_random AND psl.doc_no=pslij.doc_no AND psl.order_tid=bodc.order_tid AND ((psl.a_plies = psl.p_plies AND psl.act_cut_status='') OR (psl.a_plies < psl.p_plies AND psl.act_cut_status='DONE')) and psl.short_shipment_status=0 GROUP BY doc_no ORDER BY input_priority ASC";  
        $dockets_qty_job_qty_query2 = "SELECT GROUP_CONCAT(DISTINCT '\"',pdi.input_job_no_random_ref,'\"') AS jobs,pslij.doc_no AS doc_no,psl.a_plies AS a_plies,psl.manual_flag as manual_reported,psl.p_plies AS p_plies,psl.act_cut_status AS act_cut_status,bodc.order_style_no AS style,psl.acutno AS acutno,bodc.color_code AS color_code,bodc.order_del_no AS schedule,bodc.order_col_des AS color,bodc.ft_status AS ft_status FROM bai_pro3.plan_dashboard_input_backup AS pdi,bai_pro3.pac_stat_log_input_job AS pslij,bai_pro3.plandoc_stat_log AS psl,bai_pro3.bai_orders_db_confirm AS bodc 
        WHERE input_module='$module' AND pdi.input_job_no_random_ref=pslij.input_job_no_random AND psl.doc_no=pslij.doc_no AND psl.order_tid=bodc.order_tid AND ((psl.a_plies < psl.p_plies AND psl.act_cut_status='DONE')) and psl.short_shipment_status=0 GROUP BY doc_no ORDER BY input_priority ASC";  
    

        $dockets_cqty_result        = mysqli_query($link,$dockets_cqty_query);
        $dockets_qty_job_qty_result = mysqli_query($link,$dockets_qty_job_qty_query);
        $dockets_qty_job_qty_result2 = mysqli_query($link,$dockets_qty_job_qty_query2);

        $dockets_result_array = array();
        $dockets_result_array = [$dockets_cqty_result,$dockets_qty_job_qty_result,$dockets_qty_job_qty_result2];
        foreach($dockets_result_array as $order=>$dockets_result){  
            if($cut_wip == 0 && $ims_wip == 0)
                $break_me_at = 13;
            else if($cut_wip == 0)   
                $break_me_at = 10; 
            else 
                $break_me_at = 6;       

            while($row = mysqli_fetch_assoc($dockets_result)){     
                $style   = $row['style']; 
                $schedule= $row['schedule'];
                $color   = $row['color'];
                $doc_no  = $row['doc_no'];   
                $color_code= $row['color_code']; 
                $cut_no  = $row['acutno'];
                $cut_str = chr($color_code).'0'.$cut_no;
                $jobs    = $row['jobs'];
                $cut_status    = $row['act_cut_status'];
                $fabric_status = $row['fabric_status'];
                $ft_status     = $row['ft_status'];
                $aplies = $row['a_plies'];
                $pplies = $row['p_plies'];
                $manual_reported = $row['manual_reported'];

                //getting ips op code
                $ips_op_code_query = "SELECT operation_code FROM $brandix_bts.tbl_ims_ops WHERE appilication = 'IPS'";
                $ips_op_code_result = mysqli_query($link,$ips_op_code_query);
                $ips_op_code = mysqli_fetch_array($ips_op_code_result)['operation_code'];
                if($ips_op_code == 'Auto'){
                    $get_ips_op = get_ips_operation_code($link,$style,$color);
                    $ips_op_code=$get_ips_op['operation_code'];
                }


                $job_qty_query = "SELECT SUM(carton_act_qty) as job_qty from $bai_pro3.pac_stat_log_input_job 
                                where input_job_no_random IN ($jobs)";              
                $job_qty_result = mysqli_query($link,$job_qty_query);  
                $cut_qty_query = "SELECT SUM(cut_quantity) as cut_qty,SUM(remaining_qty) as rem_qty 
                                from $bai_pro3.cps_log where doc_no IN ($doc_no) and operation_code = $cutting_op_code ";
                $cut_qty_result = mysqli_query($link,$cut_qty_query);

                if($order == 0){
                    $all_jobs = explode(',',$jobs);

                    //filtering scanned and unscanned jobs
                    $scanned_jobs_query = "SELECT input_job_no_random_ref as ij from $brandix_bts.bundle_creation_data where 
                        input_job_no_random_ref IN ($jobs) and  operation_id = $ips_op_code group by input_job_no_random_ref";
                        // echo $scanned_jobs_query;
                    $scanned_jobs_result = mysqli_query($link,$scanned_jobs_query);
                    while($jobs_row = mysqli_fetch_array($scanned_jobs_result)){
                        $scanned_jobs[] = '"'.$jobs_row['ij'].'"'; 
                    }
                    $unscanned_jobs = array_diff($all_jobs,$scanned_jobs);
                    $unscanned_jobs_string = implode(',',$unscanned_jobs);
                    $scanned_jobs_string = implode(',',$scanned_jobs);

                    //for unscanned_jobs
                    $un_scanned_qty_query = "SELECT SUM(carton_act_qty) as job_qty,group_concat(distinct doc_no) as docs,old_size 
                            from $bai_pro3.pac_stat_log_input_job  
                            where input_job_no_random IN ($unscanned_jobs_string) group by input_job_no_random,old_size";      
                    $un_scanned_qty_result = mysqli_query($link,$un_scanned_qty_query); 
                    if(mysqli_num_rows($un_scanned_qty_result)>0){
                        while($uscrow = mysqli_fetch_array($un_scanned_qty_result)){
                            $docs = $uscrow['docs'];
                            $size = $uscrow['old_size'];
                            $eligible = $uscrow['job_qty'];
                            $rem_qty_query = "SELECT SUM(remaining_qty) as rem_qty from $bai_pro3.cps_log where doc_no IN ($docs) and size_code = '$size' and operation_code = $cutting_op_code ";     
                            $rem_qty_result = mysqli_query($link,$rem_qty_query);
                            $rrow = mysqli_fetch_array($rem_qty_result);
                            $cut_wip += min($eligible,$rrow['rem_qty']);
                            $eligible = 0;
                        }
                    }
                    //for scanned jobs   
                    $scanned_qty_query = "SELECT SUM((send_qty+replace_in+recut_in)-(recevied_qty+rejected_qty)) as eligible,
                                    group_concat(distinct docket_number) as docs,size_id from $brandix_bts.bundle_creation_data  
                                    where input_job_no_random_ref IN ($scanned_jobs_string) and operation_id = $ips_op_code group by input_job_no_random_ref,size_id";
                    $scanned_qty_result = mysqli_query($link,$scanned_qty_query); 
                    if(mysqli_num_rows($scanned_qty_result)>0){
                        while($scrow = mysqli_fetch_array($scanned_qty_result)){
                            $docs = $scrow['docs'];
                            $size = $scrow['size_id'];
                            $eligible = $scrow['eligible'];
                            $rem_qty_query = "SELECT SUM(remaining_qty) as rem_qty 
                                from $bai_pro3.cps_log where doc_no IN ($docs) and size_code = '$size' and operation_code = $cutting_op_code ";
                            $rem_qty_result = mysqli_query($link,$rem_qty_query);
                            $rrow = mysqli_fetch_array($rem_qty_result);
                            $cut_wip += min($eligible,$rrow['rem_qty']);
                            $eligible = 0;
                        }
                    }
                    unset($scanned_jobs);
                    unset($unscanned_jobs);
                    continue;
                }
        
                $jrow  = mysqli_fetch_array($job_qty_result);
                $crow  = mysqli_fetch_array($cut_qty_result);
                
                $job_qty  = $jrow['job_qty'];
                $doc_qty = $crow['cut_qty'];
                $rem_qty = $crow['rem_qty'];
                $status_color = '';
                
                if($order == 1 || $order == 2 ){
                    $actual_doc = 0;
                    $actual_doc = $doc_no;
                    //checking for clubbing dockets
                    $club_docket_query = "SELECT org_doc_no from $bai_pro3.plandoc_stat_log where doc_no in ($doc_no) and org_doc_no > 1";
                    $club_docket_result = mysqli_query($link,$club_docket_query);
                    if( mysqli_num_rows( $club_docket_result ) > 0 ){
                        $row = mysqli_fetch_array($club_docket_result);
                        $doc_no  = $org_doc_no = $row['org_doc_no']; // overriding the incoming docket with the clubbed original docket.
                    }
                    
                    if($aplies < $pplies && $cut_status == 'DONE'){
                        $status_color = 'orange';
                    }else if($order == 1 || $order == 3){
                        if($cut_status == '') $cut_status = 0; else $cut_status = 5;

                        $fabric_status_query="SELECT doc_no from $bai_pro3.plandoc_stat_log where fabric_status<>'5' 
                                            and doc_no in ($doc_no)";
                        $fabric_status_query_result  =mysqli_query($link, $fabric_status_query) or exit($docs_data.='Fabric Status error');
                        if(mysqli_num_rows($fabric_status_query_result) > 0) $fabric_status = 0; else $fabric_status = 5;
                        
                        $fabric_query ="SELECT doc_no from $bai_pro3.plan_dashboard where fabric_status='1' and doc_no in ($doc_no)";
                        $fabric_result=mysqli_query($link, $fabric_query) or exit($docs_data.='Fabric Status Error');
                        if(mysqli_num_rows($fabric_result)>0)
                            $fabric_status = 1;
                                                    
                        $priorities_query="SELECT doc_ref from $bai_pro3.fabric_priorities where doc_ref in ($doc_no)";
                        $priorities_result=mysqli_query($link, $priorities_query) or exit($docs_data.='Fabric Priorities Error');
                        if(mysqli_num_rows($priorities_result)>0) $fabric_req = 5;  else $fabric_req = 0;
                
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

                    if ($manual_reported == 1) {
                        continue;
                    }

                    $doc_str = '';
                    if($org_doc_no != '' || $org_doc_no > 0)
                        $doc_str = "<v><c>Org Doc no</c> : $org_doc_no</v>
                                    <v><c>Doc no</c> : $actual_doc</v>";
                    else 
                        $doc_str = "<v><c>Doc no</c> : $actual_doc</v>";   

                    $tool_tip_text = "<p style=\"width : 500px\">
                                        <v><c>Style</c> : $style</v><v><c>Schedule No</c> : $schedule</v>
                                        <v><c>Colors</c> : $color</v>$doc_str
                                        <v><c>Cut No : </c> $cut_str</v>
                                        <v><c>Docket Qty : </c>$doc_qty</v>
                                        <v><c>Sewing  Job Qty</c> : $job_qty</v>
                                        <v><c>Cut Remaining Qty </c>: $rem_qty</v>
                                    </p>";
                    $href= "$url&module=$module&section=$section&doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=$doc_no";
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
        enough : NULL; 
        $module1 = str_replace(".","-",$module);
        if($cut_wip == 0 || $cut_wip == '')
            $jquery_data.= "<script>$('#cut-wip-td-$module1').remove()</script>"; 
        else
            $jquery_data.= "<script>$('#cut-wip-$module1').html('$cut_wip')</script>"; 

        return $docs_data; 
    }
?>

