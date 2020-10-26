<?php 
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
include($include_path.'\sfcs_app\common\config\functions_v2.php');
include($include_path.'\sfcs_app\common\config\enums.php');

$plant_code = $argv[1];
$username =  $_session['userName'];

/**
 * get planned sewing jobs(JG) for the workstation
 */
function getSewingJobsForWorkstationIdsType($plantCode, $workstationId) {
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
        } else {
            return "Jobs not found for the workstation";
        }
    } catch(Exception $e) {
        throw $e;
    }
}
$message= '<html><head><style type="text/css">

body
{
    font-family: arial;
    font-size:12px;
    color:black;
}
table
{
    border-collapse:collapse;
    white-space:nowrap; 
}
th
{
    color: white;
    border: 1px solid #660000; 
    white-space:nowrap; 
    padding-left: 10px;
    padding-right: 10px;
    background-color:#29759C;
}

td
{
    color: BLACK;
    border: 1px solid #660000; 
    padding: 1px;
    white-space:nowrap; 
}

.green
{
    border: 0;

}

.red
{
    border: 0;

}

.yash
{
    border: 0;

}
</style></head><body>';
$message.= '
<table><tr><th colspan=4 align=\"center\">Section Style wise WIP</th></tr>
<tr><th>Style</th><th>Bundles on Live</th><th>WIP</th><th>Running Module</th></tr>';
/**
 * Get Setions for department type 'SEWING' and plant code
 */
$total_section_qty=0;
$total_boxes_count=0;
$sections=getSectionByDeptTypeSewing($plant_code);
foreach($sections as $section)   
{
    $section_qty=0;
    $section_boxes=0;
    $workstationsArray=getWorkstationsForSectionId($plant_code,$section['sectionId']);
    foreach($workstationsArray as $workStation)
    {
        $workstations[]=$workStation['workstationId'];
        $jobsArray = getSewingJobsForWorkstationIdsType($plant_code,$workStation['workstationId']);

            foreach($jobsArray as $job)     
            {
                /**
                 * getting min operations
                */
                $qrytoGetMinOperation="SELECT operation_code FROM $tms.`task_job_transaction` WHERE task_jobs_id='".$job['taskJobId']."' AND plant_code='$plant_code' AND is_active=1 ORDER BY operation_seq ASC LIMIT 0,1";
                $minOperationResult = mysqli_query($link_new,$qrytoGetMinOperation) or exit('Problem in getting operations data for job');
                if(mysqli_num_rows($minOperationResult)>0){
                    while($minOperationResultRow = mysqli_fetch_array($minOperationResult)){
                        $minOperation=$minOperationResultRow['operation_code'];
                    }
                }
                /**
                 * getting max operations
                 */
                $qrytoGetMaxOperation="SELECT operation_code FROM $tms.`task_job_transaction` WHERE task_jobs_id='".$job['taskJobId']."' AND plant_code='$plant_code' AND is_active=1 ORDER BY operation_seq DESC LIMIT 0,1";
                $maxOperationResult = mysqli_query($link_new,$qrytoGetMaxOperation) or exit('Problem in getting operations data for job');
                if(mysqli_num_rows($maxOperationResult)>0){
                    while($maxOperationResultRow = mysqli_fetch_array($maxOperationResult)){
                        $maxOperation=$maxOperationResultRow['operation_code'];
                    }
                }
                //echo $qrytoGetMaxOperation;

                //worksation=>job_ids=>min max operations=>
                $get_data_transaction="SELECT style,sum(if(operation_id=".$minOperation.",good_quantity,0)) as input_quantity,sum(if(operation_id=".$maxOperation.",good_quantity,0)) as output_quantity,resource_id,count(parent_barcode) AS bundles_count,GROUP_CONCAT(DISTINCT(schedule)) as schedule FROM $pts.transaction_log WHERE resource_id in ('".implode("','" , $workstations)."') AND plant_code='$plant_code' AND is_active=1 ORDER BY style,schedule GROUP BY style,schedule,resource_id";
                $result = $link->query($get_data_transaction);
                while($row = $result->fetch_assoc()){                   
                    //style wise data (A)
                    $style=$row['style'];
                    $schedule=$row['schedule'];
                    $resource_id=$row['resource_id'];
                    $bundles_count=$row['bundles_count'];
                    $wip_qty=$row['input_quantity'] - $row['output_quantity'];
                    //To get workstation description
                    $query = "select workstation_description from $pms.workstation where plant_code='$plant_code' and workstation_id = '$resource_id' AND is_active=1";
                    $query_result=mysqli_query($link_new, $query) or exit("Sql Error at workstation_description".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($des_row=mysqli_fetch_array($query_result))
                    {
                      $workstation_description = $des_row['workstation_description'];
                    }
                    $data=['style'=>$row['style'],'wip_qty'=>$wip_qty,'resource_id'=>['workstation_description'],'bundles_count'=>['bundles_count']];
                    
                    //To get module wise data
                    $modulewise_data= "<tr><td align=\"center\">".$workstation_description."</td><td align=\"center\">".$bundles_count."</td><td align=\"right\">".$wip_qty."</td><td align=\"left\">".$schedule."</td></tr>";
                    $main_data[$style][] = $data;
                    $section_qty += $wip_qty;
                    $section_boxes += $bundles_count;
                }
            }           
    }
    //Section wise total qty
    $sections_data= "<tr style='background-color:#29759C;'><td align=\"center\" style='color: WHITE;'>Section-".$section['sectionName']."</td><td align=\"center\" style='color: WHITE;'>".$section_boxes."</td><td align=\"right\" style='color: WHITE;'>".$section_qty."</td><td align=\"left\" style='color: WHITE;'></td></tr>";
    $total_section_qty +=$section_qty;
    $total_boxes_count +=$section_boxes;
}
foreach($main_data as $key => $value){
    $data[$key]['wip_qty'] +=$value['wip_qty'];
	$data[$key]['bundles_count'] +=$value['bundles_count'];
	$data[$key]['workstation_description'] = $value['workstation_description'];

	$message.= "<tr><td align=\"center\">".$key."</td><td align=\"center\">".$data[$key]['bundles_count']."</td><td align=\"right\">".$data[$key]['wip_qty']."</td><td align=\"left\"></td></tr>";
	$message.= $sections_data;
	$message.= $totals_data;

}   
$totals_data= "<tr style='background-color:#29759C;'><td align=\"center\" style='color: WHITE;'>Total</td><td align=\"center\" style='color: WHITE;'>".$total_boxes_count."</td><td align=\"right\" style='color: WHITE;'>".$total_section_qty."</td><td align=\"left\" style='color: WHITE;'></td></tr>";
$message.='</table>';
$message.='</br>';
$message.='</br>';

$message.= '
<table><tr><th colspan=4 align=\"center\">Section Module wise WIP</th></tr>
<tr><th>Module</th><th>Bundles on Live</th><th>WIP</th><th>Running Schedules</th></tr>';
$message.=$modulewise_data;
$message.=$sections_data;
$message.=$totals_data;
$message.="</table>";
$message.='<br/>Message Sent Via: '.$plant_name;
$message.="</body></html>";
?>
<?php

    //echo $message;
    $to  = $line_wip_track;

    $subject = $plant_name.' WIP (Production) Track';
    
    // To send HTML mail, the Content-type header must be set
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: ".$header_name." <".$header_mail.">". "\r\n";

    // $headers .= $header_from. "\r\n";
    
    if(mail($to, $subject, $message, $headers))
    {
     print("mail sent Successfully")."\n";
    }

    $end_timestamp = microtime(true);
    $duration = $end_timestamp - $start_timestamp;
   print("Execution took ".$duration." milliseconds.")."\n";
?>
