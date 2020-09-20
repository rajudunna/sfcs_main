<?php ini_set('max_execution_time', 360);
// error_reporting(0);
?>
<!DOCTYPE html>
<?php
//load the database configuration file
//include("..".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'] . "/sfcs_app/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT'] . "/sfcs_app/common/config/functions.php");
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_v2.php');

$plantCode = $_SESSION['plantCode'];
// Down time reasons
$master_resons = array();
$sql_mstr_resns = "SELECT id FROM $pps.downtime_reason WHERE plant_code='$plantCode' AND id NOT IN (20,21,22)";
$res_mstr = mysqli_query($link, $sql_mstr_resns) or exit('SQL Error:' . $sql_mstr_resns);
$z = 0;
while ($row_mstr = mysqli_fetch_array($res_mstr)) 
{
	$master_resons[$z] = $row_mstr['id'];
	$z++;
}
?>
<html lang="en">

<head>
	<meta http-equiv="refresh" content="120">
	<title>Hourly Production Report- Section Wise</title>
	<style>
		.text-right {
			text-align: right;
		}

		.text-center {
			text-align: center;
		}
	</style>
</head>

<body>
	<div class="container">
		<?php
		$img_url = getFullURLLevel($_GET['r'], 'common/images/sign.jpg', 2, 'R');
		$grand_tot_qty_time_array1 = array();
		$plant_modules = array();
		$plant_name = array();

		if ($_GET['pro_date']) {
			$frdate = $_GET['pro_date'];
			$ntime = 18;
		} else {
			$frdate = date("Y-m-d");
			$ntime = date('H');
		} 

		?>
		<div class="panel panel-primary">
			<div class="panel-heading">Hourly Production Report - Section Wise</div>
			<div class="panel-body">
				<form action="index.php" method='GET' class="form-inline">
					<div class='row'>
						<input type="hidden" value="<?= $_GET['r']; ?>" name="r">
						<label>Date : </label>
						<input type='text' data-toggle="datepicker" value='<?php echo $frdate;  ?>' name='pro_date' class='form-control' readonly>
						<input type='submit' value='Filter' class='btn btn-primary' name='submit'>
					</div>
				</form>
				<hr>

				<?php
				if (isset($_GET['submit'])) {
					// Get plant start time and end time 
					$plantTimingsQuery = "SELECT plant_start_time,plant_end_time FROm $pms.plant where plant_code = '" . $plantCode . "'";
					$plantTimingResult = mysqli_query($link, $plantTimingsQuery);
					$rowData = mysqli_fetch_row($plantTimingResult);
					$startTime = strtotime($rowData[0]); // Plant start time
					$endTime = strtotime($rowData[1]); // Plant end time							 
					$hours =  (($endTime - $startTime) / 3600); // Plant hours
					// Get production plan upload data for given date
					// getting sections and under section work stations and getting cumulative results
					$i = 0; ?>
					<section class="content-area">
						<div class='table-responsive'>
							<div class="table-area">
								<table class="table table-bordered">
									<thead>
										<tr style="background:#337ab7;color:white;">
											<th>Team</th>
											<th>Act NOP</th>
											<th>Style</th>
											<th style='display:none;'>Sch</th>
											<th>FR Plan</th>
											<th>Forecast</th>
											<th>SMV</th>
											<th>Hours</th>
											<th>Target <br>PCS/Hr</th>
											<?php
											for ($i = $startTime; $i < $endTime; $i += 3600) {
												$hourlyTime = date("H:i", $i) . "-";
												if (($i + 3600) > $endTime) {
													$hourlyTime .= date("H:i A", $endTime);
												} else {
													$hourlyTime .= date("H:i A", $i + 3600);
												}
												echo "<th><center>$hourlyTime</center></th>";
											}
											?>
											<th>Total Pcs</th>
											<th>Scanned Pcs</th>
											<th>Scanned SAH</th>
											<th>FR SAH</th>
											<th>Forecast SAH</th>
											<th>Actual SAH</th>
											<th>SAH Diff</th>
											<th>Plan Eff</th>
											<th>Act Eff</th>
											<th style="display:none;">Act Pcs</th>
											<th>Balance pcs against Forecast</th>
											<th>Forecast Hit rate</th>
											<th style="display:none;">Request Pcs/Hr</th>
										</tr>
									</thead>
									<tbody>
									<?php
										$ttlActNop = 0;
										$ttlFrPlanQty = 0;
										$ttlForecastQty = 0;
										$ttlSmv = 0;
										$ttlHours = 0;
										$ttlTargetPcs = 0;
										$ttlQtyForHourly = array();
										$sumOfTtlPcs = 0;
										$sumOfTtlScnPcs = 0;
										$ttlScnSAH = 0;
										$ttlFrSAH = 0;
										$ttlForecastSAH = 0;
										$ttlActualSAH = 0;
										$ttlSAHDiff = 0;
										$ttlPlanEff = 0;
										$ttlActEff = 0;
										$ttlBalPcs = 0;
										$ttlForeCastHitRate = 0;
										$groupedSecQry = "SELECT distinct group FROM $pps.monthly_production_plan LEFT JOIN $pps.monthly_production_plan_upload_log as upload_log ON upload_log.monthly_production_plan_upload_log_id = monthly_production_plan.monthly_production_plan_upload_log_id where  plant_code = '" . $plantCode . "' and planned_date ='".$frdate."'";
										$res_groupedSecQry = mysqli_query($link, $groupedSecQry);
										while ($row_groupedSecQry = mysqli_fetch_array($res_groupedSecQry)) {
											$sql = "SELECT * FROM $pps.monthly_production_plan LEFT JOIN $pps.monthly_production_plan_upload_log as upload_log ON upload_log.monthly_production_plan_upload_log_id = monthly_production_plan.monthly_production_plan_upload_log_id where  plant_code = '" . $plantCode . "' and planned_date ='".$frdate."' and group = '".$row_groupedSecQry['group']."' ";
											$res = mysqli_query($link, $sql);
											$ttlActNop_sec = 0;
											$ttlFrPlanQty_sec = 0;
											$ttlForecastQty_sec = 0;
											$ttlSmv_sec = 0;
											$ttlHours_sec = 0;
											$ttlTargetPcs_sec = 0;
											$ttlQtyForHourly_sec = array();
											$sumOfTtlPcs_sec = 0;
											$sumOfTtlScnPcs_sec = 0;
											$ttlScnSAH_sec = 0;
											$ttlFrSAH_sec = 0;
											$ttlForecastSAH_sec = 0;
											$ttlActualSAH_sec = 0;
											$ttlSAHDiff_sec = 0;
											$ttlPlanEff_sec = 0;
											$ttlActEff_sec = 0;
											$ttlBalPcs_sec = 0;
											$ttlForeCastHitRate_sec = 0;
											while ($row = mysqli_fetch_array($res)) {
												// ============ Get Workstation id =======================//
												$workstationIdQuery  = "SELECT workstation_id FROM $pms.workstation WHERE workstation_code = '" . $row['row_name'] . "' and plant_code = '". $plantCode ."'";
												$workstationResult = mysqli_query($link, $workstationIdQuery);
												$workstationRow = mysqli_fetch_row(($workstationResult));
												$workstationId = $workstationRow[0];
												
												//============== Get No of operators ============================//
												$sqlNOP = "SELECT sum(present+jumper) as act_nop FROM $pps.pro_attendance WHERE date='$frdate' and module='$workstationId'";
												$nopResult = mysqli_query($link, $sqlNOP);
												$rowNOP = mysqli_fetch_row($nopResult);
												$actNop = $rowNOP[0];
												// =============== Get fore cast quantity ===========================//
												$sqlForecastQty = "SELECT qty FROM $pps.line_forecast where date='$frdate' AND module='$workstationId'";
												//    echo $sql4."</br>";
												$resForecastQty = mysqli_query($link, $sqlForecastQty);
												$rowForecastQty = mysqli_fetch_row($resForecastQty);
												$forecastQty = $rowForecastQty[0];
												// Target PCS per hour = forecast quantity / hours
												if ($forecastQty == 0 || $hours == 0) {
													$tpcsPHR = 0;
												} else {
													$tpcsPHR = $forecastQty / $hours;
												}
												// Smv
												$smv = $row['smv'];
												// FR Plan
												$frQty = $row['planned_qty'];
												$ttlActNop += $actNop;
												$ttlActNop_sec += $actNop;
												$ttlFrPlanQty += $frQty;
												$ttlFrPlanQty_sec += $frQty;
												$ttlForecastQty += $forecastQty;
												$ttlForecastQty_sec += $forecastQty;
												$ttlSmv += $smv;
												$ttlHours += $hours;
												$ttlTargetPcs += round($tpcsPHR);
												// Planned NOP
												$plannedNop = $row['capacity_factor'];
											?>
												<tr>
													<td> <?= $row['row_name']; ?></td>
													<td class="text-right"> <?= $actNop; ?></td>
													<td> <?= $row['product_code']; ?></td>
													<td class="text-right"> <?= $frQty; ?></td>
													<td class="text-right"> <?= $forecastQty; ?></td>
													<td class="text-right"> <?= round($smv); ?></td>
													<td class="text-right"> <?= round($hours); ?></td>
													<!-- Round up -->
													<td class="text-right" style="background-color:#e1bee7;"> <?= round($tpcsPHR); ?></td>

													<?php
													$totalPcs = 0;
													$scnPcs = 0;
													$j = 0;
													for ($i = $startTime; $i < $endTime; $i += 3600) {
														$start = date("H:i:s", $i);
														$end = date("H:i:s", $i + 3600);
														$hourStartWithDate =  $frdate . " " . $start;
														$hourEndWithDate =  $frdate . " " . $end;

														//============== Get reported quantity ==========================//
														$sqlReportedQty = "SELECT sum(good_quantity) as quantity FROM $pts.transaction_log WHERE resource_id='" . $workstationId . "' AND created_at BETWEEN '" . $hourStartWithDate . "' AND '" . $hourEndWithDate . "' AND plant_code ='".$plantCode."' AND operation='130'";
														$resultQty = mysqli_query($link, $sqlReportedQty);
														$rowQty = mysqli_fetch_row($resultQty);
														$goodQty = $rowQty[0];
														// display quantity based on conditions
														$displayQty;
														// Display down time reason image
														$displayDownTimeImg = false;
														// Color
														$color = 'inherit';
														$bgColor = 'inherit';
														if (!$goodQty) {
															$goodQty = 0;
														}
														$ttlQtyForHourly[$j] = 0;
														$ttlQtyForHourly_sec[$j] = 0;
														if (round($tpcsPHR) == 0) { // if target pcs == 0
															if ($goodQty > 0) {
																$ttlQtyForHourly[$j] = $ttlQtyForHourly[$j] + $goodQty;
																$ttlQtyForHourly_sec[$j] = $ttlQtyForHourly_sec[$j] + $goodQty;
																$totalPcs += $goodQty;
																$displayQty = $goodQty;
															}
														} else if ($goodQty >= round($tpcsPHR)) { // if target pcs less than or equal to reported good quantity
															$ttlQtyForHourly[$j] = $ttlQtyForHourly[$j] + $goodQty;
															$ttlQtyForHourly_sec[$j] = $ttlQtyForHourly_sec[$j] + $goodQty;
															$totalPcs += $goodQty;
															$displayQty = $goodQty;
														} else if ($goodQty < round($tpcsPHR)) {
															if ($goodQty == 0) {
																$reasons = array();
																// Break reasons 
																$breakResons = array(20, 21, 22);
																// Get distinct reason id's form hourlly downtime for every hour
																$sqlReasons = "SELECT distinct(reason_id) FROM $pps.hourly_downtime WHERE DATE='$frdate' AND time BETWEEN TIME('" . $start . "') AND TIME('" . $end . "') AND team='$workstationId' AND plant_code='$plantCode' ";
																$resReasons = mysqli_query($link, $sqlReasons);
																$k = 0;
																while ($rowsReason = mysqli_fetch_array($resReasons)) {
																	$reasons[$k] = $rowsReason['reason_id'];
																	$k++;
																}

																$only_others = sizeof(array_intersect($master_resons, $reasons));
																$only_breaks = sizeof(array_intersect($break_resons, $reasons));
																$color = 'white';
																if ($only_breaks > 0 && $only_others > 0) {
																	$bgColor = '#D4AC0D';
																} else if ($only_breaks > 0 && $only_others == 0) {
																	$bgColor = '#D40D86';
																} else {
																	$bgColor = '#DD3636';
																}
																// Get reason count for hour
																$sqlReasonsCount = "SELECT count(reason_id) as reasons_count FROM $pps.hourly_downtime WHERE DATE='$frdate' AND time BETWEEN TIME('" . $start . "') AND TIME('" . $end . "') AND team='$workstationId' AND plant_code='$plantCode' ";
																// echo $sql6_2.'<br><br>';
																$resReasonsCount = mysqli_query($link, $sqlReasonsCount);
																$rowCount = mysqli_fetch_row($resReasonsCount);
																if ($rowCount[0] > 0) {
																	$displayQty = 0;
																} else {
																	if (($start > date('H') && $frdate == date('Y-m-d'))) {
																		$displayQty = '-';
																	}
																}
															} else {
																$reasons = array();
																// Break reasons 
																$breakResons = array(20, 21, 22);
																// Get distinct reason id's form hourlly downtime for every hour
																$sqlReasons = "SELECT distinct(reason_id) FROM $pps.hourly_downtime WHERE DATE='$frdate' AND time BETWEEN TIME('" . $start . "') AND TIME('" . $end . "') AND team='$workstationId' AND plant_code='$plantCode' ";
																$resReasons = mysqli_query($link, $sqlReasons);
																$k = 0;
																while ($rowsReason = mysqli_fetch_array($resReasons)) {
																	$reasons[$k] = $rowsReason['reason_id'];
																	$k++;
																}

																$only_others = sizeof(array_intersect($master_resons, $reasons));
																$only_breaks = sizeof(array_intersect($break_resons, $reasons));
																$color = 'white';
																if ($only_breaks > 0 && $only_others > 0) {
																	$bgColor = '#D4AC0D';
																} else if ($only_breaks > 0 && $only_others == 0) {
																	$bgColor = '#D40D86';
																} else {
																	$bgColor = '#DD3636';
																}
																// Get reason count for hour
																$sqlReasonsCount = "SELECT count(reason_id) as reasons_count FROM $pps.hourly_downtime WHERE DATE='$frdate' AND time BETWEEN TIME('" . $start . "') AND TIME('" . $end . "') AND team='$workstationId' AND plant_code='$plantCode' ";
																// echo $sql6_2.'<br><br>';
																$resReasonsCount = mysqli_query($link, $sqlReasonsCount);
																$rowCount = mysqli_fetch_row($resReasonsCount);
																if ($rowCount[0] > 0) {
																	$displayQty = $goodQty;
																	$ttlQtyForHourly[$j] = $ttlQtyForHourly[$j] + $goodQty;
																	$totalPcs += $goodQty;
																} else {
																	$displayDownTimeImg = true;
																}
															}
														}

														$j++;
														$scnPcs += $goodQty;

														// Target < good qty => color change (!)
														if ($displayDownTimeImg) {
															echo "<td><img src='$img_url' alt=\"Update Downtime\" height=\"42\" width=\"42\"></td>";
														} else {
															echo "<td class='text-right' style='background-color:$bgColor; color:$color;'>$goodQty </td>";
														}
													}
													$sumOfTtlPcs += $totalPcs;
													$$sumOfTtlPcs_sec += $totalPcs;
													$sumOfTtlScnPcs += $scnPcs;
													$sumOfTtlScnPcs_sec += $scnPcs;
													?>
													<td class="text-right" style="background-color:#d7ccc8;"><?= $totalPcs; ?></td>
													<td class="text-right" style="background-color:#d7ccc8;"><?= $scnPcs; ?></td>
													<td class="text-right" style="background-color:#d7ccc8;">
														<?php
														$scannedSAH = round(($scnPcs * $smv) / 60);
														$ttlScnSAH += $scannedSAH;
														$ttlScnSAH_sec += $scannedSAH;
														echo $scannedSAH; 	?>
													</td>
													<td class="text-right">
														<?php
														$frSAH = round(($frQty * $smv) / 60);
														$ttlFrSAH += $frSAH;
														$ttlFrSAH_sec += $frSAH;
														echo $frSAH; 	?>
													</td>
													<td class="text-right">
														<?php
														$forecastSAH = round(($forecastQty * $smv) / 60);
														$ttlForecastSAH += $forecastSAH;
														$ttlForecastSAH_sec += $forecastSAH;
														echo $forecastSAH;
														?>
													</td>
													<td class="text-right">
														<?php
														$actSAH = round(($totalPcs * $smv) / 60);
														$ttlActualSAH += $actSAH;
														$ttlActualSAH_sec += $actSAH;
														echo $actSAH;
														?>
													</td>
													<td class="text-right">
														<?php
														$sahDiff = $frSAH - $actSAH;
														$ttlSAHDiff += $sahDiff;
														$ttlSAHDiff_sec += $sahDiff;
														echo $sahDiff;
														?>
													</td>
													<td class="text-right">
														<?php
														if ($plannedNop > 0 && $hours > 0) {
															$planEff = round((($frQty * $smv) / ($plannedNop * $hours * 60)) * 100);
														} else {
															$planEff = 0;
														}
														$ttlPlanEff += $planEff;
														$ttlPlanEff_sec += $planEff;
														echo $planEff . '%';
														?>
													</td>
													<td class="text-right">
														<?php
														if ($actNop > 0 && $hours > 0) {
															$actEff = round((($totalPcs * $smv) / ($actNop * $hours * 60)) * 100);
														} else {
															$actEff = 0;
														}
														$ttlActEff += $actEff;
														$ttlActEff_sec += $actEff;
														echo $actEff . '%';
														?>
													</td>
													<td class="text-right">
														<?php
														$balance = $frQty - $totalPcs;
														$ttlBalPcs += $balance;
														$ttlBalPcs_sec += $balance;
														echo $balance;
														?>
													</td>
													<td class="text-right">
														<?php
														if ($frQty > 0) {
															$hitrate = round(($totalPcs / $frQty) * 100);
														} else {
															$hitrate = 0;
														}
														$ttlForeCastHitRate += $hitrate;
														$ttlForeCastHitRate_sec += $hitrate;
														echo $hitrate . '%';
														?>
													</td>
												</tr>
										<?php } ?>
												<tr style="background-color:yellow;color:white;font-weight: bold; border-bottom:2px solid black; border-top:2px solid black;">
												<td>Factory</td>
												<td class="text-right"><?= $ttlActNop_sec; ?></td>
												<td></td>
												<td class="text-right"><?= $ttlFrPlanQty_sec; ?></td>
												<td class="text-right"><?= $ttlForecastQty_sec; ?></td>
												<td class="text-right"> </td>
												<td class="text-right"> </td>
												<td class="text-right"> </td>
												<?php
												for ($k = 0; $k < $hours; $k++) {
													$ttlQty = $ttlQtyForHourly_sec[$k]  ? $ttlQtyForHourly_sec[$k] : 0;
													echo "<td class='text-right'>" . $ttlQty . "</td>";
												}
												?>
												<td class="text-right"><?= $sumOfTtlPcs_sec; ?></td>
												<td class="text-right"><?= $sumOfTtlScnPcs_sec; ?></td>
												<td class="text-right"><?= $ttlScnSAH_sec; ?></td>
												<td class="text-right"><?= $ttlFrSAH_sec; ?></td>
												<td class="text-right"><?= $ttlForecastSAH_sec; ?></td>
												<td class="text-right"><?= $ttlActualSAH_sec; ?></td>
												<td class="text-right"><?= $ttlSAHDiff_sec; ?></td>
												<td class="text-right"><?= $ttlPlanEff_sec; ?>%</td>
												<td class="text-right"><?= $ttlActEff_sec; ?>%</td>
												<td class="text-right"><?= $ttlBalPcs_sec; ?></td>
												<td class="text-right"><?= $ttlForeCastHitRate_sec; ?>%</td>
												</tr>
										 <?php } ?>
										<tr style="background-color:green;color:white;font-weight: bold; border-bottom:2px solid black; border-top:2px solid black;">
											<td>Factory</td>
											<td class="text-right"><?= $ttlActNop; ?></td>
											<td></td>
											<td class="text-right"><?= $ttlFrPlanQty; ?></td>
											<td class="text-right"><?= $ttlForecastQty; ?></td>
											<td class="text-right"> </td>
											<td class="text-right"> </td>
											<td class="text-right"> </td>
											<?php
											for ($k = 0; $k < $hours; $k++) {
												$ttlQty = $ttlQtyForHourly[$k]  ? $ttlQtyForHourly[$k] : 0;
												echo "<td class='text-right'>" . $ttlQty . "</td>";
											}
											?>
											<td class="text-right"><?= $sumOfTtlPcs; ?></td>
											<td class="text-right"><?= $sumOfTtlScnPcs; ?></td>
											<td class="text-right"><?= $ttlScnSAH; ?></td>
											<td class="text-right"><?= $ttlFrSAH; ?></td>
											<td class="text-right"><?= $ttlForecastSAH; ?></td>
											<td class="text-right"><?= $ttlActualSAH; ?></td>
											<td class="text-right"><?= $ttlSAHDiff; ?></td>
											<td class="text-right"><?= $ttlPlanEff; ?>%</td>
											<td class="text-right"><?= $ttlActEff; ?>%</td>
											<td class="text-right"><?= $ttlBalPcs; ?></td>
											<td class="text-right"><?= $ttlForeCastHitRate; ?>%</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</section>
				<?php } ?>
				<br><br>
			</div>
		</div>
	</div>
</body>

</html>