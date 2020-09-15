<?php ini_set('max_execution_time', 360);
// error_reporting(0);
?>
<!DOCTYPE html>
<?php
//load the database configuration file
//include("..".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'] . "/sfcs_app/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT'] . "/sfcs_app/common/config/functions.php");
$plantCode = 'AIP';
// Down time reasons
$master_resons = array();
$sql_mstr_resns = "SELECT id FROM $bai_pro2.downtime_reason WHERE id NOT IN (20,21,22) ";
$res_mstr = mysqli_query($link, $sql_mstr_resns) or exit('SQL Error:' . $sql_mstr_resns);
$z = 0;
while ($row_mstr = mysqli_fetch_array($res_mstr)) {
	$master_resons[$z] = $row_mstr['id'];
	$z++;
}
?>
<html lang="en">

<head>
	<meta http-equiv="refresh" content="120">
	<title>Hourly Production Report New</title>
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

		$plant_details_query = "SELECT GROUP_CONCAT(module_name) as plant_modules, mini_plant_name as plant_name FROM bai_pro3.`module_master` LEFT JOIN bai_pro3.`mini_plant_master` ON module_master.`mini_plant_id` = mini_plant_master.`id` GROUP BY mini_plant_id";
		$plant_details_result = mysqli_query($link, $plant_details_query);
		while ($row = mysqli_fetch_array($plant_details_result)) {
			if ($row['plant_name'] != null || $row['plant_name'] != '') {
				$plant_name[] = $row['plant_name'];
				$plant_modules[] = explode(',', $row['plant_modules']);
			}
		}

		// Team => section 
		// module => workstation
		$plant_details_query = "SELECT GROUP_CONCAT(module_name) AS plant_modules, 'Factory' AS plant_name FROM bai_pro3.`module_master`;";

		$plant_details_result = mysqli_query($link, $plant_details_query);
		while ($row = mysqli_fetch_array($plant_details_result)) {
			$plant_name[] = $row['plant_name'];
			$plant_modules[] = explode(',', $row['plant_modules']);
		}

		?>
		<div class="panel panel-primary">
			<div class="panel-heading">Hourly Production Report New</div>
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

					$plant_timings_query = "SELECT * FROM $bai_pro3.tbl_plant_timings";
					$plant_timings_result = mysqli_query($link, $plant_timings_query);
					while ($row = mysqli_fetch_array($plant_timings_result)) {
						$start_time[] = $row['start_time'];
						$ids[] = $row['time_id'];
						$end_time[] = $row['end_time'];
						$time_display[] = $row['time_display'] . '<br>' . $row['day_part'];
					}

					// $total_hours = $plant_end_time - $plant_start_time;
					// list($hour, $minutes, $seconds) = explode(':', $plant_start_time);
					// $minutes_29 = $minutes-1;

					// $sql = "SELECT * FROM $bai_pro2.`fr_data` WHERE DATE(frdate)='$frdate' GROUP BY team,style,smv ORDER BY team*1";
					// $res = mysqli_query($link, $sql);
					// Get production plan upload data for given date
					$sql = "SELECT * FROM $pps.monthly_production_plan LEFT JOIN $pps.monthly_production_plan_upload_log as upload_log ON upload_log.monthly_production_plan_upload_log_id = monthly_production_plan.monthly_production_plan_upload_log_id where  plant_code = '" . $plantCode . "'";
					$res = mysqli_query($link, $sql);

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
									<?php
									$tot_reported_plantWise = array();
									$tot_frqty_plantWise = array();
									$tot_forecast_qty_plantWise = array();
									$tot_scanned_plantWise = array();
									$tot_scanned_sah_plantWise = array();
									$tot_fr_sah_plantWise = array();
									$tot_forecast_sah_plantWise = array();
									$tot_act_sah_plantWise = array();
									$tot_sah_diff_plantWise = array();
									$tot_plan_eff_plantWise = array();
									$tot_act_eff_plantWise = array();
									$tot_balance_plantWise = array();
									$tot_hit_rate_plantWise = array();
									$grand_tot_qty_time_array1 = array();
									$avg_count = 0;
									while ($row = mysqli_fetch_array($res)) {
										// ============ Get Workstation id =======================//
										$workstationIdQuery  = "SELECT workstation_id FROM $pms.workstation WHERE workstation_code = '" . $row['row_name'] . "'";
										$workstationResult = mysqli_query($link, $workstationIdQuery);
										$workstationRow = mysqli_fetch_row(($workstationResult));
										$workstationId = $workstationRow[0];
										//============== Get reported quantity ==========================//
										$sqlReportedQty = "SELECT sum(good_quantity) as quantity FROM $pts.transaction_log WHERE resource_id='" . $workstationId . "'";
										$resultQty = mysqli_query($link, $sqlReportedQty);
										$rowQty = mysqli_fetch_row($resultQty);
										$goodQty = $rowQty[0];
										//============== Get No of operators ============================//
										$sqlNOP = "SELECT sum(present+jumper) as act_nop FROM $bai_pro.pro_attendance WHERE date='$frdate' and module='$workstationId'";
										$nopResult = mysqli_query($link, $sqlNOP);
										$rowNOP = mysqli_fetch_row($nopResult);
										$actNop = $rowNOP[0];
										// =============== Get fore cast quantity ===========================//
										$sqlForecastQty = "SELECT qty FROM $bai_pro3.line_forecast where date='$frdate' AND module='$workstationId'";
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
										// Planned NOP
										$plannedNop = $row['capacity_factor'];
									?>

										<tr>
											<td> <?= $row['row_name']; ?></td>
											<td> <?= $actNop; ?></td>
											<td> <?= $row['product_code']; ?></td>
											<td> <?= $frQty; ?></td>
											<td> <?= $forecastQty; ?></td>
											<td> <?= round($smv); ?></td>
											<td> <?= round($hours); ?></td>
											<!-- Round up -->
											<td> <?= round($tpcsPHR); ?></td>

											<?php
											$totalPcs = 0;
											$scnPcs = 0;
											for ($i = $startTime; $i < $endTime; $i += 3600) {
												$start = date("H:i:s", $i);
												$end = date("H:i:s", $i + 3600);
												$hourStartWithDate =  $frdate . " " . $start;
												$hourEndWithDate =  $frdate . " " . $end;

												//============== Get reported quantity ==========================//
												$sqlReportedQty = "SELECT sum(good_quantity) as quantity FROM $pts.transaction_log WHERE resource_id='" . $workstationId . "' AND created_at BETWEEN '" . $hourStartWithDate . "' AND '" . $hourEndWithDate . "'";
												$resultQty = mysqli_query($link, $sqlReportedQty);
												$rowQty = mysqli_fetch_row($resultQty);
												$goodQty = $rowQty[0];
												if (!$goodQty) {
													$goodQty = 0;
												}
												$totalPcs += $goodQty;
												$scnPcs += $goodQty;
												// Target < good qty => color change (!)
												echo "<td>$goodQty</td>";
											}
											?>
											<td><?= $totalPcs; ?></td>
											<td><?= $scnPcs; ?></td>
											<td> <?php
													$scannedSAH = round(($scnPcs * $smv) / 60);
													echo $scannedSAH; 	?>
											</td>
											<td> <?php
													$frSAH = round(($frQty * $smv) / 60);
													echo $frSAH; 	?>
											</td>
											<td>
												<?php
												$forecastSAH = round(($forecastQty * $smv) / 60);
												echo $forecastSAH;
												?>
											</td>
											<td>
												<?php
												$actSAH = round(($totalPcs * $smv) / 60);
												echo $actSAH;
												?>
											</td>
											<td>
												<?php
												$sahDiff = $frSAH - $actSAH;
												echo $sahDiff;
												?>
											</td>
											<td>
												<?php
												if ($plannedNop > 0 && $hours > 0) {
													$planEff = round((($frQty * $smv) / ($plannedNop * $hours * 60)) * 100);
												} else {
													$planEff = 0;
												}
												echo $planEff . '%';
												?>
											</td>
											<td>
												<?php
												if ($actNop > 0 && $hours > 0) {
													$actEff = round((($totalPcs * $smv) / ($actNop * $hours * 60)) * 100);
												} else {
													$actEff = 0;
												}
												echo $actEff . '%';
												?>
											</td>
											<td>
												<?php
												$balance = $frQty - $totalPcs;
												echo $balance;
												?>
											</td>
											<td>
												<?php
												if ($frQty > 0) {
													$hitrate = round(($totalPcs / $frQty) * 100);
												} else {
													$hitrate = 0;
												}
												echo $hitrate . '%';

												?>
											</td>
										</tr>

									<?php	}
									while ($row = mysqli_fetch_array($res)) {
										$module_count++;
										$total_qty = 0;
										$date = $row['frdate'];
										$newDate = date("Y-m-d", strtotime($date));
										$team = $row['team'];
										$style = trim($row['style']);
										$smv = round($row['smv'], 4);
										$frqty = $row['fr_qty'];
										$hours = $row['hours'];
										//$sumscqty=$row['out'];
										$sumscqty = 0;
										$sql3 = "SELECT time_parent_id,sum(qty) as outqty FROM $bai_pro2.hout2 where out_date='$frdate' AND team='$team' and trim(style)='" . $style . "' and smv='" . $row['smv'] . "' group by time_parent_id";
										//echo $sql3."<br>";
										$res3 = mysqli_query($link, $sql3);
										unset($out);
										while ($row3 = mysqli_fetch_array($res3)) {
											$out[$row3['time_parent_id']] = $row3['outqty'];
											$sumscqty = $sumscqty + $row3['outqty'];
										}
										$sql4 = "SELECT qty FROM $bai_pro3.line_forecast where date='$frdate' AND module='$team' group by module*1";
										//    echo $sql4."</br>";
										$res4 = mysqli_query($link, $sql4);

										$get_nop_query = "SELECT fix_nop FROM $bai_pro.pro_plan WHERE date='$frdate' and mod_no='$team'";
										//   echo $get_nop_query."<br>";
										$nop_result = mysqli_query($link, $get_nop_query);
										while ($result = mysqli_fetch_array($nop_result)) {
											$nop = $result['fix_nop'] . '<br>';
										}
										$get_nop_query1 = "SELECT sum(present+jumper) as act_nop FROM $bai_pro.pro_attendance WHERE date='$frdate' and module='$team'";
										// echo $get_nop_query;
										$nop_result1 = mysqli_query($link, $get_nop_query1);
										while ($result1 = mysqli_fetch_array($nop_result1)) {
											$act_nop = $result1['act_nop'] . '<br>';
										}
										$act_nop_tot = $act_nop_tot + $act_nop;
										for ($i = 0; $i < sizeof($plant_name); $i++) {
											if (in_array($team, $plant_modules[$i])) {
												$plan_nops[$i] = $plan_nops[$i] + $nop;
												$act_nops[$i] = $act_nops[$i] + $act_nop;
											}
										}
									?>


										<tbody>
											<tr>
												<?php $avg_count++; ?>
												<td>
													<center><?php echo $team;  ?></center>
												</td>
												<td>
													<center><?php echo $act_nop;  ?></center>
												</td>
												<td>
													<center><?php echo $style;  ?> </center>
												</td>
												<td>
													<center>
														<?php
														echo $frqty . '<br>';
														for ($i = 0; $i < sizeof($plant_name); $i++) {
															if (in_array($team, $plant_modules[$i])) {
																$tot_frqty_plantWise[$i] = $tot_frqty_plantWise[$i] + $frqty;
															}
														}
														?>
													</center>
												</td>
												<td>
													<center>
														<?php
														while ($row4 = mysqli_fetch_array($res4)) {
															$forecastqty = $row4['qty'];
															echo $row4['qty'] . '<br>';
															for ($i = 0; $i < sizeof($plant_name); $i++) {
																if (in_array($team, $plant_modules[$i])) {
																	$tot_forecast_qty_plantWise[$i] = $tot_forecast_qty_plantWise[$i] + $forecastqty;
																}
															}
														}
														?>
													</center>
												</td>
												<td>
													<center><?php echo $smv; ?></center>
												</td>
												<td>
													<center><?php echo $hours; ?></center>
												</td>
												<td style="background-color:#e1bee7;">
													<center>
														<?php
														if ($forecastqty == 0 || $hours == 0) {
															$pcsphr = 0;
														} else {
															$pcsphr = $forecastqty / $hours;
														}
														echo round($pcsphr);
														?>
													</center>
												</td>
												<?php
												for ($i = 0; $i < sizeof($time_display); $i++) {
													$row = 0;

													$row = $out[$ids[$i]];

													if ($row == '' || $row == NULL) {
														$row = 0;
													}


													//	echo $row."<br>";
													if (round($pcsphr) == 0) {
														if ($row > 0) {
															$total_qty = $total_qty + $row;
															for ($k = 0; $k < sizeof($plant_name); $k++) {
																if (in_array($team, $plant_modules[$k])) {
																	$grand_tot_qty_time_array1[$plant_name[$k]][$i] = $grand_tot_qty_time_array1[$plant_name[$k]][$i] + $row;
																}
															}
															echo "<td><center>" . $row . "</center></td>";
														} else {
															echo "<td><center>  </center></td>";
														}
													} else if ($row >= round($pcsphr)) {
														$total_qty = $total_qty + $row;
														for ($k = 0; $k < sizeof($plant_name); $k++) {
															// echo $total_qty.'-'.$i.'- '.$k.'- '.$row.'<br/>';
															if (in_array($team, $plant_modules[$k])) {
																// echo $plant_modules[$k][];
																$grand_tot_qty_time_array1[$plant_name[$k]][$i] = $grand_tot_qty_time_array1[$plant_name[$k]][$i] + $row;
															}
														}
														echo "<td><center>" . $row . "</center></td>";
													} else if ($row < round($pcsphr)) {
														if ($row == 0) {
															$reasons = array();
															$break_resons = array(20, 21, 22);

															$sql6_2x = "SELECT distinct(reason_id) FROM $bai_pro2.hourly_downtime WHERE DATE='$frdate' AND time BETWEEN TIME('" . $start_time[$i] . "') AND TIME('" . $end_time[$i] . "') AND team='$team';";
															$res6_12x = mysqli_query($link, $sql6_2x);
															$k = 0;
															while ($rows = mysqli_fetch_array($res6_12x)) {
																$reasons[$k] = $rows['reason_id'];
																$k++;
															}

															$only_others = sizeof(array_intersect($master_resons, $reasons));
															$only_breaks = sizeof(array_intersect($break_resons, $reasons));

															if ($only_breaks > 0 && $only_others > 0) {
																$color = '#D4AC0D';
															} else if ($only_breaks > 0 && $only_others == 0) {
																$color = '#D40D86';
															} else {
																$color = '#DD3636';
															}

															$sql6_2 = "SELECT * FROM $bai_pro2.hourly_downtime WHERE DATE='$frdate' AND time BETWEEN TIME('" . $start_time[$i] . "') AND TIME('" . $end_time[$i] . "') AND team='$team';";
															// echo $sql6_2.'<br><br>';
															$res6_12 = mysqli_query($link, $sql6_2);
															if (mysqli_num_rows($res6_12) > 0) {
																echo "<td style='background-color:$color; color:white;'><center> 0 </center></td>";
															} else {
																if (($start_time[$i] > date('H') and $frdate == date('Y-m-d'))) {
																	echo "<td><center> - </center></td>";
																} else {
																	echo "<td><center>  </center></td>";
																}
															}
														} else {

															$reasons = array();
															$break_resons = array(20, 21, 22);

															$sql6_2 = "SELECT distinct(reason_id) FROM $bai_pro2.hourly_downtime WHERE DATE='$frdate' AND time BETWEEN TIME('" . $start_time[$i] . "') AND TIME('" . $end_time[$i] . "') AND team='$team';";
															$res6_12 = mysqli_query($link, $sql6_2);
															$k = 0;
															while ($rows = mysqli_fetch_array($res6_12)) {
																$reasons[$k] = $rows['reason_id'];
																$k++;
															}

															$only_others = sizeof(array_intersect($master_resons, $reasons));
															$only_breaks = sizeof(array_intersect($break_resons, $reasons));

															if ($only_breaks > 0 && $only_others > 0) {
																$color = '#D4AC0D';
															} else if ($only_breaks > 0 && $only_others == 0) {
																$color = '#D40D86';
															} else {
																$color = '#DD3636';
															}

															$sql6_2 = "SELECT * FROM $bai_pro2.hourly_downtime WHERE DATE='$frdate' AND time BETWEEN TIME('" . $start_time[$i] . "') AND TIME('" . $end_time[$i] . "') AND team='$team';";
															// echo $sql6_2.'<br><br>';
															$res6_12 = mysqli_query($link, $sql6_2);
															if (mysqli_num_rows($res6_12) > 0) {
																$total_qty = $total_qty + $row;
																for ($k = 0; $k < sizeof($plant_name); $k++) {
																	if (in_array($team, $plant_modules[$k])) {
																		$grand_tot_qty_time_array1[$plant_name[$k]][$i] = $grand_tot_qty_time_array1[$plant_name[$k]][$i] + $row;
																	}
																}
																echo "<td style='background-color:$color; color:white;'><center>" . $row . "</center></td>";
																// echo "<td style='background-color:#dd3636; color:white;'><center>".$row."</center></td>";
															} else {
																//	$total_qty = $total_qty + $row;
																echo "<td><img src='$img_url' alt=\"Update Downtime\" height=\"42\" width=\"42\"></td>";
															}
														}
													}
												}
												?>
												<td style="background-color:#d7ccc8;">
													<center>
														<b>
															<?php
															echo $total_qty;
															for ($i = 0; $i < sizeof($plant_name); $i++) {
																if (in_array($team, $plant_modules[$i])) {
																	$tot_reported_plantWise[$i] = $tot_reported_plantWise[$i] + $total_qty;
																}
															}
															?>
														</b>
													</center>
												</td>
												<td style="background-color:#d7ccc8;">
													<center>
														<b>
															<?php
															echo $sumscqty;
															for ($i = 0; $i < sizeof($plant_name); $i++) {
																if (in_array($team, $plant_modules[$i])) {
																	$tot_scanned_plantWise[$i] = $tot_scanned_plantWise[$i] + $sumscqty;
																}
															}
															?>
														</b>
													</center>
												</td>
												<td style="background-color:#d7ccc8;">
													<center>
														<b>
															<?php
															$scanned_sah = round(($sumscqty * $smv) / 60);
															echo $scanned_sah;
															for ($i = 0; $i < sizeof($plant_name); $i++) {
																if (in_array($team, $plant_modules[$i])) {
																	$tot_scanned_sah_plantWise[$i] = $tot_scanned_sah_plantWise[$i] + $scanned_sah;
																}
															}
															?>
														</b>
													</center>
												</td>
												<td>
													<center>
														<?php
														$plan_sah = round(($frqty * $smv) / 60);
														echo $plan_sah;
														for ($i = 0; $i < sizeof($plant_name); $i++) {
															if (in_array($team, $plant_modules[$i])) {
																$tot_fr_sah_plantWise[$i] = $tot_fr_sah_plantWise[$i] + $plan_sah;
															}
														}
														?>
													</center>
												</td>
												<td>
													<center>
														<?php
														$forecast_sah = round(($forecastqty * $smv) / 60);
														echo $forecast_sah;
														for ($i = 0; $i < sizeof($plant_name); $i++) {
															if (in_array($team, $plant_modules[$i])) {
																$tot_forecast_sah_plantWise[$i] = $tot_forecast_sah_plantWise[$i] + $forecast_sah;
															}
														}
														?>
													</center>
												</td>
												<td>
													<center>
														<?php
														$act_sah = round(($total_qty * $smv) / 60);
														echo $act_sah;
														for ($i = 0; $i < sizeof($plant_name); $i++) {
															if (in_array($team, $plant_modules[$i])) {
																$tot_act_sah_plantWise[$i] = $tot_act_sah_plantWise[$i] + $act_sah;
															}
														}
														?>
													</center>
												</td>
												<td>
													<center>
														<?php
														$sah_diff = $plan_sah - $act_sah;
														echo $sah_diff;
														for ($i = 0; $i < sizeof($plant_name); $i++) {
															if (in_array($team, $plant_modules[$i])) {
																$tot_sah_diff_plantWise[$i] = $tot_sah_diff_plantWise[$i] + $sah_diff;
															}
														}
														?>
													</center>
												</td>
												<td>
													<center>
														<?php
														if ($nop > 0 && $hours > 0) {
															$plan_eff = round((($frqty * $smv) / ($nop * $hours * 60)) * 100);
														} else {
															$plan_eff = 0;
														}

														echo $plan_eff . '%';
														?>
													</center>
												</td>
												<td>
													<center>
														<?php
														if ($act_nop > 0 && $hours > 0) {
															$act_eff = round((($total_qty * $smv) / ($act_nop * $hours * 60)) * 100);
														} else {
															$act_eff = 0;
														}

														echo $act_eff . '%';
														?>
													</center>
												</td>
												<td style="display:none;">
													</center>
												</td>
												<td>
													<center>
														<?php
														$balance = $forecastqty - $total_qty;
														echo $balance;
														?>
													</center>
												</td>
												<td>
													<center>
														<?php
														if ($forecastqty > 0) {
															$hitrate = round(($total_qty / $forecastqty) * 100);
														} else {
															$hitrate = 0;
														}
														echo $hitrate . '%';
														for ($i = 0; $i < sizeof($plant_name); $i++) {
															if (in_array($team, $plant_modules[$i])) {
																$tot_balance_plantWise[$i] = $tot_balance_plantWise[$i] + $hitrate;
															}
														}
														?>
													</center>
												</td>
												<td style="display:none;">
													<center>
														<?php
														$noh = 18 - $ntime;
														if ($noh != 0) {
															$required = ($balance) / $noh;
															$grand_tot_required = $grand_tot_required + round($required);
														} else {
															$required = ($balance) / 1;
															$grand_tot_required = $grand_tot_required + round($required);
														}
														echo round($required);
														?>
													</center>
												</td>
											</tr>




										<?php

									}
									if ($avg_count == 0) {
										$avg_count = 1;
									}

									for ($j = 0; $j < sizeof($plant_name); $j++) {
										?>
											<tr style="background-color:green;color:white;font-weight: bold; border-bottom:2px solid black; border-top:2px solid black;">
												<td>
													<center><?php echo $plant_name[$j]; ?></center>
												</td>
												<td><?php echo $act_nops[$j]; ?></td>
												<td></td>
												<td>
													<center><?php echo $tot_frqty_plantWise[$j]; ?></center>
												</td>
												<td>
													<center><?php echo $tot_forecast_qty_plantWise[$j]; ?></center>
												</td>
												<td></td>
												<td></td>
												<td></td>
												<?php
												for ($i = 0; $i < sizeof($time_display); $i++) {
													if ($grand_tot_qty_time_array1[$plant_name[$j]][$i] > 0) {
														echo "<td><center>" .
															$grand_tot_qty_time_array1[$plant_name[$j]][$i]
															. "</center></td>";
													} else {
														echo "<td><center> 0 </center></td>";
													}
												}
												?>
												<td>
													<center><?php echo $tot_reported_plantWise[$j];  ?></center>
												</td>
												<td>
													<center><?php echo $tot_scanned_plantWise[$j];  ?></center>
												</td>
												<td>
													<center><?php echo $tot_scanned_sah_plantWise[$j];  ?></center>
												</td>
												<td>
													<center><?php echo $tot_fr_sah_plantWise[$j];  ?></center>
												</td>
												<td>
													<center><?php echo $tot_forecast_sah_plantWise[$j];  ?></center>
												</td>
												<td>
													<center><?php echo $tot_act_sah_plantWise[$j];  ?></center>
												</td>
												<td>
													<center><?php echo $tot_sah_diff_plantWise[$j];  ?></center>
												</td>
												<?php
												if ($hours > 0) {
													//act
													if ($act_nops[$j] > 0) {
														$tot_act_eff_plantWise[$j] = round((($tot_act_sah_plantWise[$j]) / ($act_nops[$j] * $hours)) * 100);
													} else {
														$tot_act_eff_plantWise[$j] = 0;
													}
													// Plan
													if ($plan_nops[$j] > 0) {
														$tot_plan_eff_plantWise[$j] = round((($tot_fr_sah_plantWise[$j]) / ($plan_nops[$j] * $hours)) * 100);
													} else {
														$tot_plan_eff_plantWise[$j] = 0;
													}
												} else {
													$tot_plan_eff_plantWise[$j] = 0;
													$tot_act_eff_plantWise[$j] = 0;
												}

												if ($tot_forecast_qty_plantWise[$j] > 0) {
													$tot_hit_rate_plantWise[$j] = round(($tot_reported_plantWise[$j] / $tot_forecast_qty_plantWise[$j]) * 100);
												} else {
													$tot_hit_rate_plantWise[$j] = 0;
												}
												?>
												<td>
													<center><?php echo $tot_plan_eff_plantWise[$j] . '%';  ?></center>
												</td>
												<td>
													<center><?php echo $tot_act_eff_plantWise[$j] . '%';  ?></center>
												</td>
												<td>
													<center><?php echo $tot_forecast_qty_plantWise[$j] - $tot_reported_plantWise[$j];  ?></center>
												</td>
												<td>
													<center><?php echo $tot_hit_rate_plantWise[$j] . '%';  ?></center>
												</td>
												<td style="display:none;">
													<center><?php echo $grand_tot_required;  ?></center>
												</td>
											</tr>
									<?php	}
								}
									?>

										</tbody>
								</table>
							</div>
						</div>
					</section>
					<br><br>
			</div>
		</div>
	</div>
</body>

</html>