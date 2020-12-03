<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include($_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/config.php', 3, 'R'));
include(getFullURLLevel($_GET['r'], 'common/config/functions.php', 3, 'R'));
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php");
// $view_access=user_acl("SFCS_0235",$username,1,$group_id_sfcs); 
$plantCode = $_SESSION['plantCode'];
?>

<html>

<head>
	<title>IPS Allocation status</title>
	<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'], 'common/js/TableFilter_EN/tablefilter.js', 3, 'R') ?>"></script>

	<!--<script language="javascript" type="text/javascript" src="TableFilter_EN/tablefilter.js"></script>-->

	<script type="text/javascript">
		function check_date() {
			var from_date = document.getElementById("sdate").value;
			var to_date = document.getElementById("edate").value;
			var today = document.getElementById("today").value;
			if (to_date < from_date) {
				sweetAlert("End date should be greater than Start date", '', 'warning');
				document.getElementById("edate").value = "<?php echo date("Y-m-d");  ?>";
				document.getElementById("sdate").value = "<?php echo date("Y-m-d");  ?>";
			}
			if (to_date > today) {
				sweetAlert("End date should not be greater than Today", '', 'warning');
				document.getElementById("edate").value = "<?php echo date("Y-m-d");  ?>";
			}
		}
	</script>

	<link href="<?= getFullURLLevel($_GET['r'], 'common/css/sfcs_styles.css', 4, 'R'); ?>" rel="stylesheet" type="text/css" />

</head>

<body>

	<div class="panel panel-primary">
		<div class="panel-heading">IPS Allocation Report</div>
		<div class="panel-body">
			<div class="form-group">
				<form name="input" method="post">
					<div class="row">
						<div class="col-sm-3">
							<?php
							$sadte = (isset($_POST['sdate'])) ? $_POST['sdate'] : date("Y-m-d"); // Start date
							$eadte = (isset($_POST['edate'])) ? $_POST['edate'] : date("Y-m-d"); // End date
							?>
							<input type="hidden" name="today" id="today" value="<?php echo date("Y-m-d"); ?>">
							Lay Plan Create Start Date: <input type="text" class="form-control" id="sdate" data-toggle='datepicker' onchange="check_date();" name="sdate" size="8" value="<?= $sadte; ?>" />
						</div>
						<div class="col-sm-3">
							Lay Plan Create End Date: <input type="text" class="form-control" id="edate" data-toggle='datepicker' onchange="check_date();" name="edate" size="8" value="<?= $eadte; ?>" />
						</div><br />
						<span id="error" style="color: Red; display: none"></span>
						<div class="col-sm-3">
							<input height="21 px" type="submit" name="show" class="btn btn-primary" value="Show" id="show" />
						</div>
					</div>
					<hr>
				</form>
			</div>


			<?php
			if (isset($_POST['show'])) {
				$s_date = $_POST['sdate'];
				$e_date = $_POST['edate'];

			?>
				<div class='table table-responsive'>
					<table border='1px' id='table1' class='table table-bordered'>
						<tr class='success'>
							<th>Style</th>
							<th>Schedule</th>
							<th>Color</th>
							<th>Total Jobs</th>
							<th>Planned Jobs(Completed)</th>
							<th>Planned Jobs(Pending)</th>
							<th>Cuts Completed</th>
						</tr>

						<?php

						// Get Sewing job ids (jm_jg_header_id)
						$sql_get_sewingJobs = "SELECT DISTINCT(jg_header.jm_jg_header_id) ,job_number from $pps.jm_cut_job AS cut_job
						LEFT JOIN $pps.jm_product_bundle AS jm_product_bundle ON jm_product_bundle.jm_cut_job_id = cut_job.jm_cut_job_id
						LEFT JOIN $pps.jm_product_logical_bundle As pplb ON pplb.jm_ppb_id = jm_product_bundle.jm_ppb_id
						LEFT JOIN $pps.jm_job_bundles AS job_bundles ON job_bundles.jm_pplb_id = pplb.jm_pplb_id
						LEFT JOIN $pps.jm_jg_header AS jg_header ON jg_header.jm_jg_header_id = job_bundles.jm_jg_header_id
						WHERE cut_job.plant_code='" . $plantCode . "' AND cut_job.created_at BETWEEN '" . $s_date . " 00:00:00' AND '" . $e_date . " 23:59:59' AND job_group_type='PSJ' ORDER BY job_number ASC";

						$result_get_sewingJobs = mysqli_query($link, $sql_get_sewingJobs) or exit("Sql Error1--1" . mysqli_error($GLOBALS["___mysqli_ston"]));

						$jobsArray = [];
						while ($row_sewingJobs = mysqli_fetch_array($result_get_sewingJobs)) {
							$sewingJobId = $row_sewingJobs['jm_jg_header_id'];
							$sewingJobNumber = $row_sewingJobs['job_number'];

							// ************************** Get completed jobs and pending jobs *************************************** //
							$sql_get_jobs = "SELECT task_header.task_status as task_header_task_status, task_header.resource_id,task_jobs.task_jobs_id,attribute_name,attribute_value FROM $tms.task_jobs 
				LEFT JOIN $tms.task_header ON task_header.task_header_id = task_jobs.task_header_id
				LEFT JOIN $tms.task_attributes ON task_attributes.task_jobs_id = task_jobs.task_jobs_id where task_jobs.task_job_reference = '" . $sewingJobId . "'";
							$res_jobs = mysqli_query($link, $sql_get_jobs) or exit("Sql Error1--2" . mysqli_error($GLOBALS["___mysqli_ston"]));
							$countOfAttributes = mysqli_num_rows($res_jobs);
							$style = '';
							$schedules = '';
							$colors = '';
							$completedJob = '';
							$pendingJob = '';
							$totalJobs = 0;
							$docketNos = '';
							$cutCompletedJob = '';
							while ($rowJobs = mysqli_fetch_array($res_jobs)) {
								$attributeName = $rowJobs['attribute_name'];
								$attributeValue = $rowJobs['attribute_value'];
								if ($attributeName == 'STYLE') { // Style
									$style = $attributeValue;
								}
								if ($attributeName == 'SCHEDULE') { // Schedule
									$schedules =  $attributeValue;
								}
								if ($attributeName == 'COLOR') { // Color
									$colors = $attributeValue;
								}
								if ($attributeName == 'DOCKETNO') { // Docket No
									$docketNos = $attributeValue;
								}
								if ($rowJobs['resource_id'] && $rowJobs['task_header_task_status'] == 'INPROGRESS') {
									$completedJob = $sewingJobNumber;
								} else {
									$pendingJob = $sewingJobNumber;
								}
							}
							if ($countOfAttributes) {

								$totalJobs =   $jobsArray[$style][$schedules][$colors]["totalJobs"] + 1;

								if ($jobsArray[$style][$schedules][$colors]["completedJob"]) {
									$completedJob = $jobsArray[$style][$schedules][$colors]["completedJob"] . "," . $completedJob;
								}

								if ($jobsArray[$style][$schedules][$colors]["pendingJob"]) {
									$pendingJob = $jobsArray[$style][$schedules][$colors]["pendingJob"] . "," . $pendingJob;
								}
								// Get count of lay status(open)
								$sql_get_cut_report_status = "SELECT COUNT(cut_report_status) AS lay_status_count FROM $pps.jm_actual_docket  where cut_report_status ='OPEN' AND actual_docket_number IN($docketNos) AND plant_code = '" . $plantCode . "'";
								$res_get_cuts = mysqli_query($link, $sql_get_cut_report_status) or exit("Sql Error1--3" . mysqli_error($GLOBALS["___mysqli_ston"]));

								$row_get_cuts_count = mysqli_fetch_row($res_get_cuts);
								//  if lay staus(open) count equal to zero then cut status consider as completed
								if (!($row_get_cuts_count[0])) {
									$cutCompletedJob = $sewingJobNumber;
									if ($jobsArray[$style][$schedules][$colors]["cutCompleted"]) {
										$cutCompletedJob =  $jobsArray[$style][$schedules][$colors]["cutCompleted"] . "," . $cutCompletedJob;
									}
								}

								$jobsArray[$style][$schedules][$colors] = array(
									"style" => $style,
									"schedules" => $schedules,
									"colors" => $colors,
									"completedJob" => $completedJob,
									"pendingJob" => $pendingJob,
									"cutCompleted" => $cutCompletedJob,
									"totalJobs" => $totalJobs
								);
							}
						}
						foreach ($jobsArray as $styleArray) {
							foreach ($styleArray as $scheduleArray) {
								foreach ($scheduleArray as $colorArray) {
						?>
									<tr>
										<td> <?= $colorArray['style']; ?></td>
										<td> <?= $colorArray['schedules']; ?></td>
										<td> <?= $colorArray['colors']; ?></td>
										<td> <?= $colorArray['totalJobs']; ?></td>
										<td> <?= $colorArray['completedJob']; ?></td>
										<td> <?= $colorArray['pendingJob']; ?></td>
										<td> <?= $colorArray['cutCompleted']; ?></td>
									</tr>
					<?php
								}
							}
						}
						echo "</table></div>";
						if (sizeof($jobsArray) == 0) {
							echo "<div class='alert alert-danger'><p>No Data Found</p></div>";
						}
					}

					?>
				</div>
				<script language="javascript" type="text/javascript">
					//<![CDATA[
					var MyTableFilter = {
						exact_match: false,
						display_all_text: "Show All",
						col_0: "select",
						col_1: "select"
					}
					setFilterGrid("table1", MyTableFilter);
					//]]>
				</script>


</body>
</div>
</div>

</html>