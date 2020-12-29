<title>POP: Input Panel Availability Report</title>
<style>
	td,th{ color : #000;}
	b{ text-align:center;}
</style>	
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',3,'R'));
$cutting_mail = $conf1->get('cutting_mail');
$plantCode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
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
    } catch(Exception $error) {
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
        } else {
            //return "Workstations not found";
        }
    } catch(Exception $e) {
        throw $e;
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
        $taskStatus = TaskProgressEnum::INPROGRESS;
		$jobsQuery = "select tj.task_jobs_id, tj.task_job_reference from $tms.task_header as th left join $tms.task_jobs as tj on th.task_header_id=tj.task_header_id where tj.plant_code='".$plantCode."' and th.resource_id='".$workstationId."' and tj.task_type='".$taskType."' and th.task_status = '".$taskStatus."'";
        $jobsQueryResult = mysqli_query($link_new,$jobsQuery) or exit('Problem in getting jobs in workstation');
        if(mysqli_num_rows($jobsQueryResult)>0){
            $jobRecord = [];
            while($row = mysqli_fetch_array($jobsQueryResult)){
                
                $jobRecord[] = $row['task_jobs_id'];
                // $jobRecord["taskJobRef"] = $row['task_job_reference'];
                //array_push($jobs, $jobRecord);
            }
            return array(
				'jobs' => $jobRecord);
        } else {
            return "Jobs not found for the workstation";
        }
    } catch(Exception $e) {
        throw $e;
    }
}


$message= '';
function div_by_zero1($arg)
{
	$arg1=1;
	if($arg==0 or $arg=='0' or $arg=='')
	{
		$arg1=1;
	}
	else
	{
		$arg1=$arg;
	}
	return $arg1;
}

$date=date("Y-m-d H:i");
$date2=date("Y-m-d");
$message.= "<div class='panel panel-primary'>
			<div class='panel-heading'>
				<b>Input Availability Forecast Report</b>
			</div>
			<div class='panel-body'>";
$message.= "<div class='col-sm-12' style='overflow-y:scroll;max-height:600px;'>";
$message.= "<table class='table table-bordered table-responsive'>";
$message.= "<tr class='info'><th colspan=8><b class='text-danger'>Hourly Input Availability Report</b></th><th colspan=6><b class='text-danger'>".$date."</b></th></tr>";
$message.= "<tr class='danger'>
				<th>Section</th>
				<th>Mod#</th>
				<th>Style</th>
				<th>Schedule</th>
				<th>Color</th>
				<th>Jobs</th>
				<th>Available Qty<br> FAB(pcs)</th>
				<th>Available Qty<br> CUT</th>
				<th>Plan<br>Target/Hr</th>
				<th>Available <br>Hrs FAB</th>
				<th>Available<br> Hrs CUT</th>
				<th>Req. Time</th>
				<th>Sewing WIP</th>
				<th>Availble<br>Hrs WIP</th>
			</tr>";

// //To use this interface for both alert mail and user view.
$departments=getSectionByDeptTypeSewing($plantCode);
foreach($departments as $department)    //section Loop -start
{
	$sectionId=$department['sectionId'];
	/**Secton name by using section id*/
	$qryGetSecName="SELECT section_code FROM $pms.sections WHERE section_id='$sectionId' AND plant_code='$plantCode' AND is_active=1";
	$secNameresult = mysqli_query($link_new, $qryGetSecName) or exit("Section data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
	$secNumRows=mysqli_num_rows($secNameresult);
	if($secNumRows>0){
		while ($secRow = mysqli_fetch_array($secNameresult)) {
				$section_code = $secRow['section_code'];
		}
	}
	
	
	$workstationsArray=getWorkstationsForSectionId($plantCode, $sectionId);
	
	$total=0;
	$total1=0;
	$plan_tgt=0;
	$wip=0;
	$wip1=0;
	$total11=0;
	$total12=0;
	$total13=0;
	$total14=0;
	$total15=0;
	$total16=0;
	foreach($workstationsArray as $workstations)
    {	
		$workstation=$workstations['workstationId'];	
		/**Secton name by using section id*/
		$qryGetWorkstation="SELECT workstation_code FROM $pms.workstation WHERE workstation_id='$workstation' AND plant_code='$plantCode' AND is_active=1";
		$workStationresult = mysqli_query($link_new, $qryGetWorkstation) or exit("workstation data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
		$secNumRows=mysqli_num_rows($workStationresult);
		if($secNumRows>0){
			while ($workStationRow = mysqli_fetch_array($workStationresult)) {
					$workstation_code = $workStationRow['workstation_code'];
			}
		}

		$jobsArray=getJobsForWorkstationIdTypeSewing($plantCode, $workstations['workstationId']);
		$jobHeaders=implode("','" , $jobsArray['jobs']);
		
		/**
		 * getting cut jobs and dockets based on taskJobId
		 */
		//TO GET STYLE AND COLOR FROM TASK ATTRIBUTES USING TASK JOB ID
		$job_detail_attributes = [];
		// $qry_toget_style_sch = "SELECT * FROM $tms.task_attributes where task_jobs_id='$taskJobId' and plant_code='$plantCode' group by ";

		if(sizeof($jobsArray['jobs'])>0){
			$qry_toget_style_sch="SELECT GROUP_CONCAT(DISTINCT(IF(attribute_name='STYLE', attribute_VALUE, NULL)) SEPARATOR ',') AS STYLE,GROUP_CONCAT(DISTINCT(IF(attribute_name='SCHEDULE', attribute_VALUE, NULL)) SEPARATOR ',') AS SCHEDULE,GROUP_CONCAT(DISTINCT(IF(attribute_name='COLOR', attribute_VALUE, NULL)) SEPARATOR ',') AS COLOR,GROUP_CONCAT(DISTINCT(IF(attribute_name='DOCKETNO', attribute_VALUE, NULL)) SEPARATOR ',') AS DOCKETNO,GROUP_CONCAT(DISTINCT(IF(attribute_name='CUTJOBNO', attribute_VALUE, NULL)) SEPARATOR ',') AS CUTJOBNO FROM $tms.`task_attributes` WHERE  plant_code='$plantCode' AND task_jobs_id IN ('$jobHeaders') GROUP BY attribute_name";
			$qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) {
				if($row2['STYLE'] != NULL){
					$style = $row2['STYLE'];
				}
				if($row2['SCHEDULE'] != NULL){
					$schedule = $row2['SCHEDULE'];
				}
				if($row2['COLOR'] != NULL){
					$color = $row2['COLOR'];
				}
				if($row2['DOCKETNO'] != NULL){
					$dokcetno = $row2['DOCKETNO'];
				}
				if($row2['CUTJOBNO'] != NULL){
					$cutjobs = $row2['CUTJOBNO'];
				}
			}
		}

		$total=0;
		$total1=0;
		$plan_tgt=0;
		$wip=0;
		$wip1=0;
		$total11=0;
		$total12=0;
		$total13=0;
		$total14=0;
		$total15=0;
		$total16=0;
		$clubbing=0;

		if($dokcetno!=''){
			/**here we have condition that cut status done*/
			$qrylpLay="SELECT sum(jac.plies) as plies,GROUP_CONCAT(CONCAT('''', ratio_cg.ratio_id, '''' ))AS ratio_id FROM $pps.jm_dockets jd 
			LEFT JOIN $pps.jm_actual_docket jac ON jd.jm_docket_id=jac.jm_docket_id
			LEFT JOIN $pps.lp_ratio_component_group ratio_cg ON ratio_cg.lp_ratio_cg_id = jd.ratio_comp_group_id 
			WHERE jd.docket_number IN (".$dokcetno.") AND jac.cut_report_status != 'OPEN' AND jd.plant_code='$plantCode'";	
			$qrylpLayResult=mysqli_query($link_new, $qrylpLay) or exit("$qrylpLay".mysqli_error($GLOBALS["___mysqli_ston"]));
			$qrylpLayNum=mysqli_num_rows($qrylpLayResult);    
			if($qrylpLayNum>0){
				while($lpLayRow=mysqli_fetch_array($qrylpLayResult))
				{
					/**These plies are cut status done  */
					$plies=$lpLayRow['plies'];
					$ratio_id=$lpLayRow['ratio_id'];

					//get the docket qty
					if($ratio_id!=''){
						$size_ratio_sum = 0;
						$size_ratios_query = "SELECT size, size_ratio FROM $pps.lp_ratio_size WHERE ratio_id IN ($ratio_id)";
						$size_ratios_result=mysqli_query($link_new, $size_ratios_query) or exit("Sql fabric_info_query".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($row = mysqli_fetch_array($size_ratios_result))
						{
							$size_ratio_sum += $row['size_ratio'];
						}
					}
					

					/**
					 * Available fabric PCs based cut status done
					 */
					$total1=$plies*$size_ratio_sum;

					/**getting plant timings wrt plant*/
					$qryPlantTimings="SELECT TIMESTAMPDIFF(HOUR, plant_start_time,plant_end_time) AS 'Hours' FROM $pms.plant WHERE plant_code='$plantCode'";
					$PlantTimingsResult=mysqli_query($link_new, $qryPlantTimings) or exit("Error While getting total hours".mysqli_error($GLOBALS["___mysqli_ston"]));
					$hrsNum=mysqli_num_rows($PlantTimingsResult);
					if($hrsNum>0){
						while($PlantTimingsRow=mysqli_fetch_array($PlantTimingsResult))
						{
							$tot_hrs=$PlantTimingsRow['Hours'];
						}
					}

					/**getting plan quantity from monthly and */
					$qryPlannedQty="SELECT p.planned_qty FROM $pps.monthly_production_plan_upload_log pl LEFT JOIN $pps.monthly_production_plan p 
					ON pl.monthly_pp_up_log_id=p.pp_log_id WHERE pl.plant_code='$plantCode' AND DATE(p.planned_date)='$date2'";
					$plannedResult=mysqli_query($link_new, $qryPlannedQty) or exit("Error getting planned qty".mysqli_error($GLOBALS["___mysqli_ston"]));
					$plannedNum=mysqli_num_rows($plannedResult);
					if($plannedNum>0){
						while($plannedRow=mysqli_fetch_array($plannedResult))
						{
							$plannedQty=$plannedRow['planned_qty'];
						}
					}
					$plan_tgt=round((($plannedQty/$tot_hrs)*1.1),0);
					
							
					
					/**
					 * get MIN operation wrt jobs based on operation seq
					 */
					$qrytoGetMinOperation="SELECT sum(good_quantity) AS good_quantity FROM $tms.`task_job_status` WHERE task_jobs_id IN ('$jobHeaders') AND plant_code='$plantCode' AND is_active=1 GROUP BY operation_seq ORDER BY operation_seq ASC LIMIT 0,1";
					$minOperationResult = mysqli_query($link_new,$qrytoGetMinOperation) or exit('Problem in getting min operations data for job');
					if(mysqli_num_rows($minOperationResult)>0){
						while($minOperationResultRow = mysqli_fetch_array($minOperationResult)){
							$minGoodQty=$minOperationResultRow['good_quantity'];
						}
					}

					/**
					 * get MAX operation wrt jobs based on operation seq
					 */
					$qrytoGetMaxOperation="SELECT sum(good_quantity) AS good_quantity,
					sum(rejected_quantity) AS rejected_quantity FROM $tms.`task_job_status` WHERE task_jobs_id IN ('$jobHeaders') AND plant_code='$plantCode' AND is_active=1 GROUP BY operation_seq ORDER BY operation_seq DESC LIMIT 0,1";
					$maxOperationResult = mysqli_query($link_new,$qrytoGetMaxOperation) or exit('Problem in getting max operations data for job');
					if(mysqli_num_rows($maxOperationResult)>0){
						while($maxOperationResultRow = mysqli_fetch_array($maxOperationResult)){
							$maxGoodQty=$maxOperationResultRow['good_quantity'];
							$maxRejQty=$maxOperationResultRow['rejected_quantity'];
						}
					}
					$wip=$minGoodQty-($maxGoodQty+$maxRejQty);
					
					if($dokcetno!=''){
							/**here we have condition that cut status not done*/
							$qrylpLay="SELECT sum(jac.plies) as plies,GROUP_CONCAT(CONCAT('''', ratio_cg.ratio_id, '''' ))AS ratio_id FROM $pps.jm_dockets jd 
							LEFT JOIN $pps.jm_actual_docket jac ON jd.jm_docket_id=jac.jm_docket_id
							LEFT JOIN $pps.lp_ratio_component_group ratio_cg ON ratio_cg.lp_ratio_cg_id = jd.ratio_comp_group_id 
							WHERE jd.docket_number IN (".$dokcetno.") AND jac.cut_report_status = 'OPEN' AND jd.plant_code='$plantCode'";	
							$qrylpLayResult=mysqli_query($link_new, $qrylpLay) or exit("$qrylpLay".mysqli_error($GLOBALS["___mysqli_ston"]));
							$qrylpLayNum=mysqli_num_rows($qrylpLayResult);    
							if($qrylpLayNum>0){
								while($lpLayRow=mysqli_fetch_array($qrylpLayResult))
								{
									/**These plies are cut status done  */
									$plies=$lpLayRow['plies'];
									$ratio_id=$lpLayRow['ratio_id'];

									//get the docket qty
									$size_ratio_sum = 0;
									if($ratio_id!=''){
										$size_ratios_query = "SELECT size, size_ratio FROM $pps.lp_ratio_size WHERE ratio_id IN ($ratio_id)";
										$size_ratios_result=mysqli_query($link_new, $size_ratios_query) or exit("Sql fabric_info_query".mysqli_error($GLOBALS["___mysqli_ston"]));
										while($row = mysqli_fetch_array($size_ratios_result))
										{
											$size_ratio_sum += $row['size_ratio'];
										}
									}	
								}

								/**
									 * Available fabric PCs based cut status done
									 */
									$total=$plies*$size_ratio_sum;
							}else{
								$total=0;
							}
					}
					



					$add=0;
					if($plan_tgt>0)
					{
					
						if(date("Y-m-d",strtotime($date)+(60*60*round(($total/$plan_tgt),0)))!=date("Y-m-d") )
						{
							$add=8*(((strtotime(date("Y-m-d",(strtotime($date)+(60*60*round(($total/$plan_tgt),0))+(60*60*8))))-strtotime(date("Y-m-d")))/ (60 * 60 * 24))+0);
						}
					}
					else
					{
						$add=0;
					}
					$res=$wip/div_by_zero1($plan_tgt);
					$wip1=round(($res),0);
					
					if($plan_tgt>0)
					{
						$message.= "<tr><td>$section_code</td><td>$workstation_code</td><td>".$style."</td><td>".$schedule."</td><td>".$color."</td><td>".$cutjobs."</td><td>$total1</td><td >$total</td><td>$plan_tgt</td><td>".round(($total1/div_by_zero1($plan_tgt)),0)."</td><td>".round(($total/div_by_zero1($plan_tgt)),0)."</td><td>".date("Y-m-d H",strtotime($date)+(60*60*round(($total/$plan_tgt)+$add,0))).":00</td><td>$wip</td><td>$wip1</td></tr>";
					}
					else
					{
						$message.= "<tr><td>$section_code</td><td>$workstation_code</td><td>".$style."</td><td>".$schedule."</td><td>".$color."</td><td>".$cutjobs."</td><td>$total1</td><td>$total</td><td>$plan_tgt</td><td>".round(($total1/div_by_zero1($plan_tgt)),0)."</td><td>0</td><td>".date("Y-m-d H",strtotime($date)+(60*60*1)).":00</td><td>$wip</td><td>$wip1</td></tr>";
					}
				}
			}
			else
			{
				
				/**
				 * get MIN operation wrt jobs based on operation seq
				 */
				$qrytoGetMinOperation="SELECT sum(good_quantity) AS good_quantity FROM $tms.`task_job_status` WHERE task_jobs_id IN ('$jobHeaders') AND plant_code='$plantCode' AND is_active=1 GROUP BY operation_seq ORDER BY operation_seq ASC LIMIT 0,1";
				$minOperationResult = mysqli_query($link_new,$qrytoGetMinOperation) or exit('Problem in getting min operations data for job');
				if(mysqli_num_rows($minOperationResult)>0){
					while($minOperationResultRow = mysqli_fetch_array($minOperationResult)){
						$minGoodQty=$minOperationResultRow['good_quantity'];
					}
				}

				/**
				 * get MAX operation wrt jobs based on operation seq
				 */
				$qrytoGetMaxOperation="SELECT sum(good_quantity) AS good_quantity,
				sum(rejected_quantity) AS rejected_quantity FROM $tms.`task_job_status` WHERE task_jobs_id IN ('$jobHeaders') AND plant_code='$plantCode' AND is_active=1 GROUP BY operation_seq ORDER BY operation_seq DESC LIMIT 0,1";
				$maxOperationResult = mysqli_query($link_new,$qrytoGetMaxOperation) or exit('Problem in getting max operations data for job');
				if(mysqli_num_rows($maxOperationResult)>0){
					while($maxOperationResultRow = mysqli_fetch_array($maxOperationResult)){
						$maxGoodQty=$maxOperationResultRow['good_quantity'];
						$maxRejQty=$maxOperationResultRow['rejected_quantity'];
					}
				}
				$wip=$minGoodQty-($maxGoodQty+$maxRejQty);
				

				/**getting plant timings wrt plant*/
				$qryPlantTimings="SELECT TIMESTAMPDIFF(HOUR, plant_start_time,plant_end_time) AS 'Hours' FROM $pms.plant WHERE plant_code='$plantCode'";
				$PlantTimingsResult=mysqli_query($link_new, $qryPlantTimings) or exit("Error While getting hours".mysqli_error($GLOBALS["___mysqli_ston"]));
				$hrsNum=mysqli_num_rows($PlantTimingsResult);
				if($hrsNum>0){
					while($PlantTimingsRow=mysqli_fetch_array($PlantTimingsResult))
					{
						$tot_hrs=$PlantTimingsRow['Hours'];
					}
				}

				/**getting plan quantity from monthly and */
				$qryPlannedQty="SELECT p.planned_qty FROM $pps.monthly_production_plan_upload_log pl LEFT JOIN $pps.monthly_production_plan p 
				ON pl.monthly_pp_up_log_id=p.pp_log_id WHERE pl.plant_code='$plantCode' AND DATE(p.planned_date)='$date2'";
				$plannedResult=mysqli_query($link_new, $qryPlannedQty) or exit("Error While getting planned qty ".mysqli_error($GLOBALS["___mysqli_ston"]));
				$plannedNum=mysqli_num_rows($plannedResult);
				if($plannedNum>0){
					while($plannedRow=mysqli_fetch_array($plannedResult))
					{
						$plannedQty=$plannedRow['planned_qty'];
					}
				}
				$plan_tgt=round((($plannedQty/$tot_hrs)*1.1),0);
				if($dokcetno!=''){
					/**here we have condition that cut status not done*/
					$qrylpLay="SELECT sum(jac.plies) as plies,GROUP_CONCAT(CONCAT('''', ratio_cg.ratio_id, '''' ))AS ratio_id FROM $pps.jm_dockets jd 
					LEFT JOIN $pps.jm_actual_docket jac ON jd.jm_docket_id=jac.jm_docket_id
					LEFT JOIN $pps.lp_ratio_component_group ratio_cg ON ratio_cg.lp_ratio_cg_id = jd.ratio_comp_group_id 
					WHERE jd.docket_number IN (".$dokcetno.") AND jac.cut_report_status = 'OPEN' AND jd.plant_code='$plantCode'";	
					$qrylpLayResult=mysqli_query($link_new, $qrylpLay) or exit("$qrylpLay".mysqli_error($GLOBALS["___mysqli_ston"]));
					$qrylpLayNum=mysqli_num_rows($qrylpLayResult);    
					if($qrylpLayNum>0){
						while($lpLayRow=mysqli_fetch_array($qrylpLayResult))
						{
							/**These plies are cut status done  */
							$plies=$lpLayRow['plies'];
							$ratio_id=$lpLayRow['ratio_id'];

							//get the docket qty
							$size_ratio_sum = 0;
							if($ratio_id!=''){
								$size_ratios_query = "SELECT size, size_ratio FROM $pps.lp_ratio_size WHERE ratio_id IN ($ratio_id)";
								$size_ratios_result=mysqli_query($link_new, $size_ratios_query) or exit("Sql fabric_info_query".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($row = mysqli_fetch_array($size_ratios_result))
								{
									$size_ratio_sum += $row['size_ratio'];
								}
							}
							
						}

						/**
							 * Available fabric PCs based cut status done
							 */
							$total1=$plies*$size_ratio_sum;
					}else{
						$total1=0;
					}
				}
				

				$res=$wip/div_by_zero1($plan_tgt);
				$wip1=round(($res),0);			
				$message.= "<tr><th align=left>$section_code</th><th align=left>$workstation_code</th><td></td><td></td><td></td><td></td><td>$total1</td><td>0</td><td>$plan_tgt</td><td>".round(($total1/div_by_zero1($plan_tgt)),0)."</td><td>0</td><td>Critical</td><td>$wip</td><td>$wip1</td></tr>";
			}
			}
		
	}
}

$message.= "</table>
</div>";
$message.='
</html>';
// subject
$to = $cutting_mail;
$subject = 'Hourly Input Availability Report';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: '.$to. "\r\n";
$headers .= 'From: Shop Floor System Alert <ictsysalert@brandix.com>'. "\r\n";
echo $message;
?>
</div><!-- panel body -->
</div><!--  panel -->
</div>

