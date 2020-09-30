
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',3,'R'));
$plantCode=$_SESSION['plantCode'];
$plantCode="AIP";
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
<form name="text" method="post" action="index.php?r=<?php echo $_GET['r']; ?>">
<div class="col-md-12">
<div class="col-md-2">
<label valign="top">Start: </label><input data-toggle="datepicker" class="form-control" type="text" id="demo1" name="sdate" value="<?php  if($sdate==""){ echo date("Y-m-d"); } else { echo $sdate; } ?>" size="10" required> 
</div>
<div class="col-md-2">
<label valign="top">End: </label> <input data-toggle="datepicker"  class="form-control" type="text" id="demo2" name="edate" value="<?php  if($edate==""){ echo date("Y-m-d"); } else { echo $edate; } ?>" size="10" required>
</div>
<div class="col-md-1">
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
			echo "<option value=\"".$department['sectionId']."\" selected>".$department['sectionName']."</option>";
		}
		else
		{
			echo "<option value=\"".$department['sectionId']."\" selected>".$department['sectionName']."</option>";
		}
	}
?>
</select></div>
<div class="col-md-1">
<label valign="top">Shift Hour: </label> <select name="shift" id="myshift" class="form-control">
<option value='All' <?php if($shift=="All"){ echo "selected"; } ?> >All</option>
<?php

$shifts_array=getShifts($plantCode);
$shifts = (isset($_GET['shift']))?$_GET['shift']:'';
foreach($shifts_array as $shift){
  if($shifts == $shift){
	echo "<option value='".$shift['shiftValue']."' selected>'".$shift['shiftLabel']."'</option>";
  }else{
	echo "<option value='".$shift['shiftValue']."' >'".$shift['shiftLabel']."'</option>";
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
		//echo $workstationsQuery;
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
function getJobsForWorkstationIdTypeSewing($plantCode, $workstationId,$sdate,$edate) {
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

if(isset($_POST['submit']))
{	
	echo '<form action="'.getFullURL($_GET["r"],"export_excel.php",'R').'" method ="post" > 
	<input type="hidden" id="csv_text" name="csv_text" >
	<input type="submit" id="exp_exc" class="btn btn-info" value="Export to Excel" onclick="getData()">
	</form><br>';
		$sdate=$_POST['sdate'];
		$edate=$_POST['edate'];
		$shift_new=$_POST['shift'];
		$section=$_POST['module'];
		$hour_from=$_POST["hour_from"];
		$hour_to=$_POST["hour_to"];
		
		$workstationsArray=getWorkstationsForSectionId($plantCode,$section);
		foreach($workstationsArray as $workStation)
		{
			$jobsArray = getJobsForWorkstationIdTypeSewing($plantCode,$workStation['workstationId']);
			if(sizeof($jobsArray)>0)
				{
					foreach($jobsArray as $job)     
					{
						/**
                         * getting min and max operations
                         */
                        $qrytoGetMaxOperation="SELECT operation_code FROM $tms.`task_job_transaction` WHERE task_jobs_id='".$job['taskJobId']."' AND plant_code='$plantCode' AND is_active=1 ORDER BY operation_seq DESC LIMIT 0,1";
                        $maxOperationResult = mysqli_query($link_new,$qrytoGetMaxOperation) or exit('Problem in getting operations data for job');
                        if(mysqli_num_rows($maxOperationResult)>0){
                            while($maxOperationResultRow = mysqli_fetch_array($maxOperationResult)){
                                $maxOperation=$maxOperationResultRow['operation_code'];
                            }
						}
						
						$bundlesQry = "select GROUP_CONCAT(CONCAT('''', jm_job_bundle_id, '''' ))AS jmBundleIds,bundle_number,size,fg_color,quantity from $pps.jm_job_bundles where jm_jg_header_id ='".$job['taskJobRef']."'";
						$bundlesResult=mysqli_query($link_new, $bundlesQry) or exit("Bundles not found".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($bundleRow=mysqli_fetch_array($bundlesResult))
                        {
							$jmBundleIds=$bundleRow['jmBundleIds'];
							if($jmBundleIds!=''){
								$barcodesQry = "select barcode from $pts.barcode where external_ref_id in ($jmBundleIds) and barcode_type='PPLB' and plant_code='$plantCode' AND is_active=1";
								$barcodeResult=mysqli_query($link_new, $barcodesQry) or exit("Barcodes not found".mysqli_error($GLOBALS["___mysqli_ston"]));
								$originalBarcode=array();
                                while($barcodeRow=mysqli_fetch_array($barcodeResult))
                                {   
									$originalBarcode[]=$barcodeRow['barcode'];
								}
							}

						}

					}

				}
		}
		
		if(count($originalBarcode)>0)
		{
			echo "<div>";
			echo "<div  class ='table-responsive'>";
			echo "<table id=\"table1\"  border=1 class=\"table\" cellpadding=\"0\" cellspacing=\"0\" style='margin-top:10pt;'><thead><tr class='tblheading' style='color:white;'><th>Date</th><th>Time<th>Module</th><th>Section</th><th>Shift</th><th>Style</th><th>Schedule</th><th>Color</th><th>Cut No</th><th>Input Job No</th><th>Size</th><th>SMV</th><th>Quantity</th><th>SAH</th></tr></thead><tbody>";
			$total_qty=0;
			do{
				for($ii=$hour_from;$ii<=$hour_to;$ii++)
				{
					$fromHour=$ii.":00:00";
					$to=$ii+1;
					$toHour=$to.":00:00";
					$time_display=$fromHour."-".$toHour;
					$qryGettransactions="SELECT * FROM $pts.transaction_log WHERE IN plant_code='$plantCode' AND operation='$maxOperation' AND bundleNumber IN ('".implode("','" , $originalBarcode)."') 
					AND shift='' AND DATE(created_at) BETWEEN ('".$sdate."') AND ('".$edate."') AND TIME(created_at) BETWEEN ('".$rows12['start_time']."') AND ('".$rows12['end_time']."') 
					AND is_active=1 GROUP BY shift,docketnumber,style,size,sewingjobnumber, ORDER BY style,shift,sewingjobnumber*1
					";
					$transactionResult=mysqli_query($link, $qryGettransactions) or exit("Error while getting transactions".mysqli_error($GLOBALS["___mysqli_ston"]));
					if(mysqli_num_rows($transactionResult)>0)
					{
						$count = mysqli_num_rows($transactionResult);
						while($transactionRow=mysqli_fetch_array($transactionResult))
						{
							$style=$sql_row['style'];
							$schedule=$sql_row['schedule'];
							$color=$sql_row['color'];
							$size=$sql_row['size'];
							$good_qty=$sql_row['good_qty'];
							$sewingjobnumber=$sql_row['sewingjobnumber'];
							$docketnumber=$sql_row['docketnumber'];
							$cutnumber=$sql_row['cutnumber'];
							$workstation_id=$sql_row['workstation_id'];
							$createDate=$sql_row['created_at'];
							$shift=$sql_row['shift'];
							
							/**getting smv and nop form monthly upload*/
							$qryMonthlyupload="SELECT mp.smv AS smv,mp.capacity_factor FROM $pps.monthly_production_plan_upload_log ml LEFT JOIN monthly_production_plan mp 
							ON ml.monthly_production_plan_upload_log_id=mp.monthly_production_plan_upload_log_id WHERE ml.plant_code='$plantCode' AND 
							DATE(mp.planned_date)='$createDate' AND mp.product_code='$style' AND mp.colour='$color'";
							$monthlyResult=mysqli_query($link, $qryMonthlyupload) or exit("Error while getting transactions".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($monthlyRow=mysqli_fetch_array($monthlyResult))
							{
								$smv=round($monthlyRow['smv'],3);	
								$nop=$monthlyRow['capacity_factor'];
							}							
												
							$bgcolor="";	
							if($smv==0 and $nop==0)
							{
								$bgcolor="WHITE";
							} 
							
								
							echo "<tr bgcolor=\"$bgcolor\"><td>$sdate</td><td>".$time_display." ".$day_part."</td><td>$module</td><td>$section_name</td><td>$shift</td><td>$style</td><td>".$schedule."</td><td>$color</td><td>".$cutnumber."</td><td>$sewingjobnumber</td><td>$size</td><td>$smv</td><td>".$sizes[$sizes_val[$k]]."</td><td>".$sah[$sizes_val[$k]]."</td></tr>";
							$total_qty=$total_qty+$sizes[$sizes_val[$k]];							
							$total_qty_sah=$total_qty_sah+$sah[$sizes_val[$k]];										
							unset($sah);
							unset($sizes_val);
							unset($sizes);				
						}
					}
					//$time_query='';
				}			
				$sdate = date ("Y-m-d", strtotime("+1 days", strtotime($sdate)));			
			}
			while (strtotime($sdate) <= strtotime($edate)); 
			echo "<tr style='background-color:#FFFFCC;' class='total_excel' id='total_excel'><td colspan=12>Total</td><td id='table1Tot1'>$total_qty</td><td id='table1Tot2'>$total_qty_sah</td></tr></tbody></table></div></div>";
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
