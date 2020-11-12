
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',3,'R'));
$plantCode=$_SESSION['plantCode'];
// $plantCode='AIP';

?>


<html>
<head>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R')?>"></script>
<link href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R'); ?>" rel="stylesheet" type="text/css" />
<link href="<?= getFullURLLevel($_GET['r'],'common/css/sfcs_styles.css',3,'R'); ?>" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R')?>"></script>
<script type="text/javascript" src="../<?= getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R') ?>" ></script>
</head>

<body>
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
        throw $e;
    }
}

/**
 * Get shifts for a plant code
 */
function getShifts($plantCode){
    global $pms;
    global $link_new;
    try{
        $shiftsQuery = "select shift_id,shift_code,shift_description from $pms.shifts where plant_code='".$plantCode."' and is_active=1";
        $shiftQueryResult = mysqli_query($link_new,$shiftsQuery) or exit('Problem in getting shifts');
        if(mysqli_num_rows($shiftQueryResult)>0){
            $shifts = [];
            while($row = mysqli_fetch_array($shiftQueryResult)){
                $shiftRecord = [];
                $shiftRecord["shiftValue"] = $row['shift_code'];
                $shiftRecord["shiftLabel"] = $row["shift_code"]."-".$row["shift_description"];
                array_push($shifts, $shiftRecord);
            }
            return $shifts;
        } else {
            return "Shifts not found";
        }
    } catch(Exception $e) {
        throw $e;
    }
}

	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	$shift=$_POST['shift'];
	$module=$_POST['module'];
	$hour_from=$_POST['hour_from'];
	$hour_to=$_POST['hour_to'];


?>
<!--<div id="page_heading"><span style="float"><h3>Daily Production Status Report</h3></span><span style="float: right; margin-top: -20px"><b>?</b>&nbsp;</span></div>-->
<div class="panel panel-primary">
<div class="panel-heading">Production Status Report (Sewing Out)</div>
<div class="panel-body">
<div class="form-group">
<form name="text" method="post" action="index-no-navi.php?r=<?php echo $_GET['r']; ?>">
<div class="col-md-12">
<div class="col-md-2">
<label valign="top">Start: </label><input data-toggle="datepicker" class="form-control" type="text" id="demo1" name="sdate" value="<?php  if($sdate==""){ echo date("Y-m-d"); } else { echo $sdate; } ?>" size="10" required> 
</div>
<div class="col-md-2">
<label valign="top">End: </label> <input data-toggle="datepicker"  class="form-control" type="text" id="demo2" name="edate" value="<?php  if($edate==""){ echo date("Y-m-d"); } else { echo $edate; } ?>" size="10" required>
</div>
<div class="col-md-2">
<label valign="top">Section: </label> <select name="module" id="myModule" class="form-control">
<option value="0" <?php  if($module=="All")?>selected>All</option>
<?php	
	/**
	 * Get Setions for department type 'SEWING' and plant code
	 */
	$departments=getSectionByDeptTypeSewing($plantCode);
	foreach($departments as $department)    //section Loop -start
	{
		if($sql_mods[$i]==$module)
		{
			//echo "<option value=\"".$sql_mods[$i]."\" selected>".$sql_name[$i]."</option>";
			echo "<option value=\"".$department['sectionId']."\" selected>".$department['sectionName']."-".$department['sectionCode']."</option>";
		}
		else
		{
			echo "<option value=\"".$department['sectionId']."\">".$department['sectionName']."-".$department['sectionCode']."</option>";
		}
	}
?>
</select></div>
<div class="col-md-1">
<label valign="top">Shift </label> <select name="shift" id="myshift" class="form-control">
<option value='All' <?php if($shift=="All"){ echo "selected"; } ?> >All</option>
<?php

$shifts_array=getShifts($plantCode);
$shifts = (isset($_GET['shift']))?$_GET['shift']:'';
foreach($shifts_array as $shift){
  if($shifts == $shift){
	echo "<option value=".$shift['shiftValue']." selected>".$shift['shiftValue']."</option>";
  }else{
	echo "<option value=".$shift['shiftValue']." >".$shift['shiftValue']."</option>";
  }
}
?>
<!-- <option  value="<?= $sf ?>" selected><?php echo 'ALL'; ?></option> -->
</select></div>

<div class="col-md-2">
<label for="hour_filter" valign="top">From Hour: </label>
<?php
	$qryTiming="SELECT TIMESTAMPDIFF(HOUR,plant_start_time,plant_end_time) AS hours,plant_start_time,plant_end_time  FROM $pms.plant WHERE plant_code='$plantCode' AND is_active=1";
	$qryTimingResult=mysqli_query($link_new, $qryTiming) or exit("Error getting from hour".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($qryTimingResult)>0){
		while($timingRows=mysqli_fetch_array($qryTimingResult))
		{
			$workingHours=$timingRows['hours'];
			$plant_start_time=$timingRows['plant_start_time'];
			$plant_end_time=$timingRows['plant_end_time'];
		}
	}
	$startHour= explode(':', $plant_start_time);
	$endHour= explode(':', $plant_end_time);
	echo "<select name=\"hour_from\" id='hour_from' class=\"form-control\" >";
	for($i=$startHour[0];$i<=$endHour[0];$i++)
	{	
		$startingHour=str_pad($i, 2, '0', STR_PAD_LEFT);
		if($hour_from==$i)
		{
			echo "<option value=\"".$startingHour."\" selected>".$startingHour."</option>";
		}
		else
		{
			echo "<option value=\"".$startingHour."\" >".$startingHour."</option>";
		}		
	}  
    echo "</select>"; 
?>
</select>
</div>
<div class="col-md-2">
<label for="hour_filter" valign="top">To Hour: </label>
<?php
	echo "<select name=\"hour_to\" id='hour_to' class=\"form-control\" >";
	for($i=$startHour[0];$i<=$endHour[0];$i++)
	{	
		$startingHour=str_pad($i, 2, '0', STR_PAD_LEFT);
		if($hour_to==$i)
		{

			echo "<option value=\"".$startingHour."\" selected>".$startingHour."</option>";
		}
		else
		{
			echo "<option value=\"".$startingHour."\" >".$startingHour."</option>";
		}		
	}  
    echo "</select>";
?>
</select>
</div>
<input type="submit" value="submit" class="btn btn-info" name="submit" style="margin-top:18px" onclick="return verify_date()" >
</form>
</div>
<br>
<?php

/**
 * get workstations for plant code and section id
 */
function getWorkstationsForSectionId($plantCode, $sectionId) {
    global $pms;
    global $link_new;
    try{
		//echo $sectionId;
		if($sectionId!='0'){
			$sectionAppend="and section_id= '".$sectionId."'";
		}else{
			$sectionAppend=" ";
		}

		$workstationsQuery = "select workstation_id,workstation_code,workstation_description,workstation_label from $pms.workstation where plant_code='".$plantCode."' $sectionAppend and is_active=1";
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
            return "Workstations not found";
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
        $taskProgress = TaskProgressEnum::INPROGRESS;
		$jobsQuery = "select tj.task_jobs_id, tj.task_job_reference from $tms.task_header as th left join $tms.task_jobs as tj on th.task_header_id=tj.task_header_id where tj.plant_code='".$plantCode."' and th.resource_id='".$workstationId."' and tj.task_type='".$taskType."' and th.task_progress = '".$taskProgress."'";
		// echo "</br>JOBS : ".$jobsQuery."</br>";
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

if(isset($_POST['submit']))
{	
	echo '<form action="'.getFullURL($_GET["r"],"export_excel.php",'R').'" method ="post" > 
	<input type="hidden" id="csv_text" name="csv_text" >
	<input type="submit" id="exp_exc" class="btn btn-info" value="Export to Excel" onclick="getData()">
	</form><br>';
		$sdate=$_POST['sdate'];
		$edate=$_POST['edate'];
		$shift_new=$_POST['shift'];
		// echo "Shift : ".$shift_new;
		$section=$_POST['module'];
		// echo "section : ".$section;
		$hour_from=$_POST["hour_from"];
		$hour_to=$_POST["hour_to"];
		
		$workstationsArray=getWorkstationsForSectionId($plantCode,$section);
		$jmBundleIds=array();
		foreach($workstationsArray as $workStation)
		{
			$jobsArray = getJobsForWorkstationIdTypeSewing($plantCode,$workStation['workstationId']);
			if(sizeof($jobsArray)>0)
				{
					foreach($jobsArray as $job)     
					{
						// echo "</br>JOb :".$job['taskJobRef']."</br>";
						/**
                         * getting min and max operations
                         */
                        $qrytoGetMaxOperation="SELECT operation_code FROM $tms.`task_job_status` WHERE task_jobs_id='".$job['taskJobId']."' AND plant_code='$plantCode' AND is_active=1 ORDER BY operation_seq DESC LIMIT 0,1";
						$maxOperationResult = mysqli_query($link_new,$qrytoGetMaxOperation) or exit('Problem in getting operations data for job');
						// echo "</br>Get Max OP : ".$qrytoGetMaxOperation."</br>";
                        if(mysqli_num_rows($maxOperationResult)>0){
                            while($maxOperationResultRow = mysqli_fetch_array($maxOperationResult)){
                                $maxOperation=$maxOperationResultRow['operation_code'];
                            }
						}
						
						$bundlesQry = "select jm_pplb_id from $pps.jm_job_bundles where jm_jg_header_id ='".$job['taskJobRef']."'";
						$bundlesResult=mysqli_query($link_new, $bundlesQry) or exit("Bundles not found".mysqli_error($GLOBALS["___mysqli_ston"]));
						// echo "</br>Bundles : ".$bundlesQry."</br>";
						while($bundleRow=mysqli_fetch_array($bundlesResult))
                        {
							$jmBundleIds[]=$bundleRow['jm_pplb_id'];
						}

					}

				}
		}
		if(sizeof($jmBundleIds)>0){
			$barcodesQry = "select barcode,barcode_id from $pts.barcode where external_ref_id IN ('".implode("','" , $jmBundleIds)."') and barcode_type='PPLB' and plant_code='$plantCode' AND is_active=1";
			//echo "</br>barcode : ".$bundlesQry."</br>";
			$barcodeResult=mysqli_query($link_new, $barcodesQry) or exit("Barcodes not found".mysqli_error($GLOBALS["___mysqli_ston"]));
			$originalBarcode=array();
			$barcodeId=array();
			while($barcodeRow=mysqli_fetch_array($barcodeResult))
			{   
				$originalBarcode[]=$barcodeRow['barcode'];
				//$barcodeId[] = $barcodeRow['barcode_id'];

			}
		}
		// /**getting parent barcode from parentbarcode */
		// $qryGetParentBarcode="SELECT parent_barcode FROM $pts.parent_barcode WHERE child_barcode IN ('".implode("','" , $barcodeId)."') AND `parent_barcode_type`='PPLB' and plant_code='$plantCode' and is_active=1";
		// $parentBarcodeResult = $link_new->query($qryGetParentBarcode);
		// $parent_barcode=array();
		// while($parentRow = $parentBarcodeResult->fetch_assoc())
		// {
		// 	$parent_barcode[] = $parentRow['parent_barcode'];
		// }
		// /**get planned bacrcode*/
		// $qryPlannedbarcode="SELECT barcode FROM $pts.barcode WHERE barcode_id IN ('".implode("','" , $parent_barcode)."') AND plant_code='$plantCode' AND is_active=1";
		// $plannedBUndleResult = $link_new->query($qryPlannedbarcode);
		// $barcodePPLB=array();
		// while($pplbRow = $plannedBUndleResult->fetch_assoc())
		// {
		// 	$barcodePPLB[] = $pplbRow['barcode'];
		// }
		if(sizeof($originalBarcode)>0)
		{
			echo "<div>";
			echo "<div  class ='table-responsive'>";
			echo "<table id=\"table1\"  border=1 class=\"table\" cellpadding=\"0\" cellspacing=\"0\" style='margin-top:10pt;'><thead><tr class='tblheading' style='color:white;'><th>Operation Code</th><th>Operation Name</th><th>Date</th><th>Time<th>Module</th><th>Section</th><th>Shift</th><th>Style</th><th>Schedule</th><th>Color</th><th>Cut No</th><th>Input Job No</th><th>Size</th><th>SMV</th><th>Quantity</th><th>SAH</th></tr></thead><tbody>";
			$total_qty=0;
			do{
				for($ii=$hour_from;$ii<=$hour_to;$ii++)
				{
					/**getting shift and append this in query*/
					if($shift_new!='All'){
						$shiftValue="AND shift='$shift_new'";
					}else{
						$shiftValue=" ";
					}
					// operation='$maxOperation'
					$fromHour=$ii.":00:00";
					$to=$ii+1;
					$toHour=$to.":00:00";
					$time_display=$fromHour."-".$toHour;
					$qryGettransactions="SELECT operation, sum(good_quantity) as good_quantity,style,schedule,color,size,parent_job,resource_id,DATE(created_at) as created_at,shift FROM $pts.transaction_log WHERE plant_code='$plantCode' AND `parent_barcode_type`='PPLB' AND parent_barcode IN ('".implode("','" , $originalBarcode)."') $shiftValue AND DATE(created_at) BETWEEN ('".$sdate."') AND ('".$edate."') AND TIME(created_at) BETWEEN ('".$fromHour."') AND ('".$toHour."') 
					AND is_active=1 GROUP BY shift,style,size,parent_job, operation ORDER BY operation, style,shift,parent_job*1
					";

					// var_dump($qryGettransactions);
					//echo "</br>transaction : ".$qryGettransactions."</br>";
					$transactionResult=mysqli_query($link, $qryGettransactions) or exit("Error while getting transactions".mysqli_error($GLOBALS["___mysqli_ston"]));
					// var_dump(mysqli_num_rows($transactionResult));
					if(mysqli_num_rows($transactionResult)>0)
					{
						$count = mysqli_num_rows($transactionResult);
						while($transactionRow=mysqli_fetch_array($transactionResult))
						{
							$operation=$transactionRow['operation'];
							$style=$transactionRow['style'];
							$schedule=$transactionRow['schedule'];
							$color=$transactionRow['color'];
							$size=$transactionRow['size'];
							$good_qty=$transactionRow['good_quantity'];
							$sewingjobnumber=$transactionRow['parent_job'];
							// $docketnumber=$transactionRow['docketnumber'];
							// $cutnumber=$transactionRow['cutnumber'];
							$workstation_id=$transactionRow['resource_id'];
							$createDate=$transactionRow['created_at'];
							$shift=$transactionRow['shift'];

							/**getting jm_job_header from jm_jg_header*/
							$qryGetJobheader="SELECT jm_job_header FROM $pps.jm_jg_header WHERE job_number='$sewingjobnumber' AND plant_code='$plantCode' AND is_active=1";
							$jobHeaderResult=mysqli_query($link, $qryGetJobheader) or exit("Error while getting jm jg header".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($jmjgRow=mysqli_fetch_array($jobHeaderResult))
							{	
								$jm_job_header=$jmjgRow['jm_job_header'];
							}

							/**getting cut job id from jm job*/
							$qrygetjmJob="SELECT ref_id FROM $pps.jm_job_header WHERE jm_job_header_id='$jm_job_header' AND plant_code='$plantCode' AND is_active=1";
							$jmjobResult=mysqli_query($link, $qrygetjmJob) or exit("Error while getting jm job header".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($jmjobRow=mysqli_fetch_array($jmjobResult))
							{	
								$ref_id=$jmjobRow['ref_id'];
							}

							/**getting cut number based on ref_id */
							$qryGetCut="SELECT cut_number FROM $pps.jm_cut_job WHERE jm_cut_job_id='$ref_id' AND plant_code='$plantCode' AND is_active=1";
							$jmcutResult=mysqli_query($link, $qryGetCut) or exit("Error while getting jm cut job".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($jmcutRow=mysqli_fetch_array($jmcutResult))
							{	
								$cut_number=$jmcutRow['cut_number'];
							}

							/**getting moudle name  */
							$qryModule="SELECT workstation_code,section_id FROM $pms.workstation WHERE workstation_id='$workstation_id' AND plant_code='$plantCode' AND is_active=1";
							$monthlyResult=mysqli_query($link, $qryModule) or exit("Error while getting monthly production plan upload".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($moduleRow=mysqli_fetch_array($monthlyResult))
							{	
								$workstation_code=$moduleRow['workstation_code'];
								$section_id=$moduleRow['section_id'];
							}

							/**getting section name from moudle */
							$qrySection="SELECT section_name,section_code FROM $pms.sections WHERE section_id='$section_id' AND plant_code='$plantCode' AND is_active=1";
							$sectionResult=mysqli_query($link, $qrySection) or exit("Error while getting monthly production plan upload".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sectionRow=mysqli_fetch_array($sectionResult))
							{	
								$section_name=$sectionRow['section_name'];
								$section_code=$sectionRow['section_code'];
							}

								/* Getting Operation Name For Code*/
							$qryoperation= "SELECT operation_name FROM $mdm.operations where operation_code='$operation'";
							$operationResult=mysqli_query($link, $qryoperation) or exit("Error while getting operation name".mysqli_error($GLOBALS["___mysqli_ston"]));
	
							while($operationRow=mysqli_fetch_array($operationResult))
							{	
								$operation_name=$operationRow['operation_name'];
							}
							/* Getting smv from oms oms products info*/

							$qrysmv = "SELECT smv FROM $oms.oms_products_info AS opi LEFT JOIN $oms.oms_mo_operations AS omo ON opi.mo_number=omo.mo_number LEFT JOIN $oms.oms_mo_details AS omd ON omd.mo_number=omo.mo_number WHERE opi.style='".$style."' AND opi.color_desc='".$color."' AND omo.operation_code=".$operation." and omd.plant_code='".$plantCode."' LIMIT 1";
							// var_dump($qrysmv);
							$qrysmvresult = mysqli_query($link, $qrysmv) or exit("Error while getting smv".mysqli_error($GLOBALS["___mysqli_ston"]));

								while($smv_res=mysqli_fetch_array($qrysmvresult))
								{
									$smv=($smv_res['smv'])?round($smv_res['smv'],3):0;
								}
								if(mysqli_num_rows($qrysmvresult)>0)
								{
									if($smv){
										$sahs=round($good_qty*$smv/60,3);
										echo "<tr bgcolor=\"$bgcolor\"><td>$operation</td><td>$operation_name</td><td>$sdate</td><td>".$time_display." ".$day_part."</td><td>$workstation_code</td><td>".$section_name."-".$section_code."</td><td>$shift</td><td>$style</td><td>".$schedule."</td><td>$color</td><td>".$cut_number."</td><td>$sewingjobnumber</td><td>$size</td><td>$smv</td><td>".$good_qty."</td><td>".$sahs."</td></tr>";
										$total_qty=$total_qty+$good_qty;							
										$total_qty_sah=$total_qty_sah+$sahs;
									}
								}
							
							/**getting smv and nop form monthly upload*/
							// $qryMonthlyupload="SELECT mp.smv AS smv,mp.capacity_factor FROM $pps.monthly_production_plan_upload_log ml LEFT JOIN $pps.monthly_production_plan mp 
							// ON ml.monthly_pp_up_log_id=mp.pp_log_id WHERE ml.plant_code='$plantCode' AND 
							// DATE(mp.planned_date)='$createDate' AND mp.product_code='$style' AND mp.colour='$color'";
							// $qryMonthlyupload="SELECT smv,capacity_factor FROM $pps.monthly_production_plan WHERE DATE(planned_date)='$createDate' AND plant_code='$plantCode' AND product_code='$style' AND colour='$color' and smv>0";
							// echo "</br>monthly_production_plan_upload_log : ".$qryMonthlyupload."</br>";
							// $monthlyResult=mysqli_query($link, $qryMonthlyupload) or exit("Error while getting monthly production plan upload".mysqli_error($GLOBALS["___mysqli_ston"]));
							// if(mysqli_num_rows($monthlyResult)>0)
							// {
							// 	while($monthlyRow=mysqli_fetch_array($monthlyResult))
							// 	{
							// 		$smv=round($monthlyRow['smv'],3);	
							// 		$nop=$monthlyRow['capacity_factor'];
							// 	}
							// 	$bgcolor="";	
							// 	if($smv==0 and $nop==0)
							// 	{
							// 		$bgcolor="WHITE";
							// 	}else{
							// 		$sahs=round($good_qty*$smv/60,3);
									
							// 		echo "<tr bgcolor=\"$bgcolor\"><td>$operation</td><td>$operation_name</td><td>$sdate</td><td>".$time_display." ".$day_part."</td><td>$workstation_code</td><td>".$section_name."-".$section_code."</td><td>$shift</td><td>$style</td><td>".$schedule."</td><td>$color</td><td>".$cut_number."</td><td>$sewingjobnumber</td><td>$size</td><td>$smv</td><td>".$good_qty."</td><td>".$sahs."</td></tr>";
							// 		$total_qty=$total_qty+$good_qty;							
							// 		$total_qty_sah=$total_qty_sah+$sahs;
							// 	}
							// }else{
							// 		$smv=0;
							// 		$nop=0;
							// }							
																			
						}
					}
					//$time_query='';
				}			
				$sdate = date ("Y-m-d", strtotime("+1 days", strtotime($sdate)));			
			}
			while (strtotime($sdate) <= strtotime($edate)); 
			echo "<tr style='background-color:#FFFFCC;' class='total_excel' id='total_excel'><td colspan=14>Total</td><td id='table1Tot1'>$total_qty</td><td id='table1Tot2'>$total_qty_sah</td></tr></tbody></table></div></div>";
		}
		else
		{
			echo "<div class='alert alert-danger' style='width:1000px';>No Data Found</div>";
			echo "<script>$(document).ready(function(){
					$('#table1').css('display','none');
				});</script>";
		}
}
 
?>
<script>
var fnsFilters = {
	
	rows_counter: true,
	sort_select: true,
		on_change: true,
		display_all_text: " [ Select ] ",
		loader_text: "Filtering data...",  
	loader: true,
	loader_text: "Filtering data...",
	col_0: 'select',
	col_1: 'select',
	col_2: 'select',
	col_3: 'select',
	col_4: 'select',
	col_5: 'select',
	col_6: 'select',
	col_7: 'select',
	col_8: 'select',
	col_9: 'select',
	col_10: 'select',
	btn_reset: true,
		alternate_rows: true,
		btn_reset_text: "Clear",
	col_operation: {						
						id: ["table1Tot1","table1Tot2"],
						col: [12,13],  
						operation: ["sum","sum"],
						decimal_precision: [1,1],
						write_method: ["innerHTML","innerHTML"] 
					},
	rows_always_visible: [grabTag(grabEBI('table1'),"tr").length]
		
	};
	
	 <?php
	  if($count > 1)
	  echo 'setFilterGrid("table1",fnsFilters)';
	 ?>
	

</script>
<script language="javascript">

function getData(){
	var dummytable = $('.fltrow').html();
	var dummytotal = $('.total_excel').html();
	$('.fltrow').html('');
	$('.total_excel').html('');
	var csv_value= $("#table1").table2CSV({delivery:'value',excludeRows: '.fltrow .total_excel'});
	$("#csv_text").val(csv_value);	
	$('.fltrow').html(dummytable);
	$('.total_excel').html(dummytotal);
}
</script>
<script type="text/javascript">
	function verify_hour()
	{
		var val1 = $('#hour').val();
		var val2 = $('#hour1').val();

		
		if(val1 > val2){
			sweetAlert('Start Hour Should  be less than End Hour','','warning');
			return false;
		}
		else
		{
			return true;
		}
    }

</script>
<script type="text/javascript">
	function verify_date()
	{
		var val1 = $('#demo1').val();
		var val2 = $('#demo2').val();
		var h1 = $('#hour_from').val();
		var h2 = $('#hour_to').val();
		var h1_num = h1*1;
		var h2_num = h2*1;
		if(h1_num > h2_num){
			sweetAlert('To Hour must be greater than From Hour','','warning');
			return false;
			setTimeout(function(){
              location.href = "<?= getFullURL($_GET['r'],'transaction_log_new.php','N') ?>"
			},10000);
		}
		if(val1 > val2){
			sweetAlert('Start Date Should  be less than End Date','','warning');
			return false;
		}
		else
		{
			return true;
		}
    }

</script>
<style>
.flt{
	width:100%;
}
</style>
</div>
</div>
</body>
</html>
