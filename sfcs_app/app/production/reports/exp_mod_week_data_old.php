<!-- <style type="text/css" media="screen">
body{ 
	margin:15px; padding:15px; border:1px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:12px; 
}
a {
	margin:0px; padding:0px;
}
th
{
    background-color: #003366;
    color: WHITE;
    border-bottom: 5px solid white;
    border-top: 5px solid white;
    padding: 5px;
    white-space:nowrap;
    border-collapse:collapse;
    font-family:Calibri;
    font-size:110%;
	text-align:center;
}
table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
	background-color: white;
}
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable1{
	font-size:12px;
	border:1px;
}
th{ background-color:#003366; color:#000000; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;}
</style> -->

<?php

include($_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/config.php', 3, 'R'));
error_reporting(0);
$start = $_GET['dat1'];
$end = $_GET['dat2'];
$sec = $_GET['sec'];
$cat = $_GET['cat'];
$plantcode = $_SESSION['plantCode'];
$username = $_SESSION['userName'];
// echo $start."---".$end;
include("../" . getFullURL($_GET['r'], 'exp_mod_main.php', 0, 'R'));

 
// Get section_code
$sql_get_section_code = "SELECT section_code FROM $pms.sections  where section_id='" . $sec . "'";
$res_sec_code = mysqli_query($link, $sql_get_section_code) or exit("sql section code error" . mysqli_error($link));
$row_sec_code = mysqli_fetch_row($res_sec_code);
$section_code = $row_sec_code[0];
 
//Get modules for sections
$sql_workstations = "SELECT workstation_id,workstation_code FROM $pms.workstation where section_id ='" . $sec . "'";
$res_workstations = mysqli_query($link, $sql_workstations) or exit("sql workstation error" . mysqli_error($link));

// $sql1_query = "select sec_mods from $bai_pro3.sections_db where sec_id='$sec'";
// $sql1 = mysqli_query($link, $sql1_query) or exit("sql1_query Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
// //var_dump($sql1_query);
// while ($row1 = mysqli_fetch_array($sql1)) {
// 	$sections = $row1['sec_mods'];
// }

// $secs = explode(",", $sections);
//print_r($secs);
$i = 1;
if (mysqli_num_rows($res_workstations) < 100) {
	echo "<div class='table-responsive' style='max-height:600px;overflow-y:scroll;'><table class='table table-bordered'>";
	echo "<tr>";
	echo "<th style=\"background-color:#29759C; color:white;\">Module</th>";
	echo "<th style=\"background-color:#29759C; color:white;\">Style</th>";
	echo "<th style=\"background-color:#29759C; color:white;\">Details</th>";

	$pre_date = "";

	$start_date = $start;
	$pre_date = date("Y-m-d", strtotime("-1 day", strtotime($start_date)));
	$check_date = $pre_date;
	$end_date = $end;

	$i = 0;
	while ($check_date != $end_date) {

		$check_date = date("Y-m-d", strtotime("+1 day", strtotime($check_date)));
		$weekday = date('l', strtotime($check_date));

		// $sql_op = mysqli_query($link, "select sum(act_out) from $pts.grand_rep where plant_code='$plantcode' and date='$check_date' and section='$sec'") ;

		// while ($row_op = mysqli_fetch_array($sql_op)) {
		// 	// $output1 = $row_op["sum(act_out)"];
		// 	// echo $check_date."-".$weekday."-".$output1."<br>";
		// }


		if ($weekday == "Saturday") {

			echo "<th style=\"background-color:#29759C; color:white;\">" . $check_date . "</th>";
			echo "<th style=\"background-color:#29759C; color:white;\">Week Avg</th>";
			$dates[] = $check_date;
		} else {

			// $sql = mysqli_query($link, "select sum(act_out) from $pts.grand_rep where plant_code='$plantcode' and date='$check_date' and section='$sec'") ;
			// Total good quantity for workstation and date
			$total_good_qty = 0;
			// Get workstations for section
			while ($row_workstation = mysqli_fetch_array($res_workstations)) {
				$sql_good_qty = "SELECT sum(good_quantity) AS qty FROM $pts.transaction_log WHERE resource_id='" . $row_workstation['workstation_id'] . "' AND plant_code='" . $plantcode . "' AND operation='130' AND created_at BETWEEN '" . $check_date . " 00:00:00' AND '" . $check_date  . " 23:59:59'";
				$res_good_qty = mysqli_query($link, $sql_good_qty) or exit("sql transactions error" . mysqli_errno($link));
				$row_good_qty = mysqli_fetch_row($res_good_qty);
				$total_good_qty += $row_good_qty[0];
			}

			//echo "select sum(act_out) from $pts.grand_rep where date='$check_date' and section='$sec'<br>";

			// while ($row = mysqli_fetch_array($sql)) {
			// 	$output = $row["sum(act_out)"];
			// }

			if ($weekday == "Sunday") {
				if ($total_good_qty > 0) {
					echo "<th style=\"background-color:#29759C; color:white;\">" . $check_date . "</th>";
					$dates[] = $check_date;
				}
			} else {

				echo "<th style=\"background-color:#29759C; color:white;\">" . $check_date . "</th>";

				$dates[] = $check_date;
			}
		}
	}
	$day_avgs = 0;
	$day_output = 0;
	$day_dtime_total = 0;
	$p = 0;
	$r = 0;
	$x = 0;

	echo "</tr>";

	$res_workstations_2 = mysqli_query($link, $sql_workstations) or exit("sql workstation error" . mysqli_error($link));
	while ($row_workstation2 = mysqli_fetch_array($res_workstations_2)) {
		$workstation_id = $row_workstation2['workstation_id'];
		$workstation_code = $row_workstation2['workstation_code'];
		 
		// $sql2 = mysqli_query($link, "select distinct(styles) from $pts.grand_rep where plant_code='$plantcode' and section='$sec' AND module='" . $secs[$i] . "' and date between '$start' and '$end' order by module ");


		// Get Distinct Styles from transaction log
		$sql_get_styles = "SELECT DISTINCT(style) FROM $pts.transaction_log where plant_code='" . $plantcode . "' AND operation='130' AND created_at BETWEEN '" . $start . " 00:00:00' AND '" . $end  . " 23:59:59'";
		 
		$res_get_styles = mysqli_query($link, $sql_get_styles) or exit("sql styles error - " . mysqli_error($link));
		$style_count = mysqli_num_rows($res_get_styles);
	 
		while ($row_styles = mysqli_fetch_array($res_get_styles)) {
			$style = $row_styles['style'];
	 
			echo "<tr>";
			echo "<th rowspan='3' style=\"background-color:#00ffff;\">" . $workstation_code . "</th>";
			echo "<th rowspan='3' style=\"background-color:#00ffff;\">" . $row_styles['style'] . "</th>";
			echo "<th style=\"background-color:#C4BD97;\">Eff</th>";

			for ($k = 0; $k < sizeof($dates); $k++) {
				$weekday1 = date('l', strtotime($dates[$k]));

				$workstations_count = 0;
				// Get count of workstations for section from transaction log
				$res_workstations_3 = mysqli_query($link, $sql_workstations) or exit("sql workstation error" . mysqli_error($link));
				while ($row_workstation_3 = mysqli_fetch_array($res_workstations_3)) {
					$sql_good_qty = "SELECT sum(good_quantity) AS qty FROM $pts.transaction_log WHERE resource_id='" . $row_workstation_3['workstation_id'] . "' AND style='".$style."' AND plant_code='" . $plantcode . "' AND operation='130' AND created_at BETWEEN '" . $dates[$k] . " 00:00:00' AND '" . $dates[$k]  . " 23:59:59'";
					$res_good_qty = mysqli_query($link, $sql_good_qty) or exit("sql transactions error" . mysqli_errno($link));
					$workstations_count += mysqli_num_rows($res_good_qty);
				}
				// $sql17 = mysqli_query($link, "select count(module) from $pts.grand_rep where plant_code='$plantcode' and section='$sec' and module='" . $secs[$i] . "' AND date='" . $dates[$k] . "' and styles='" . $row2['styles'] . "'")  or exit("sql17 Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
				// while ($row17 = mysqli_fetch_array($sql17)) {
				// 	$count = $row17["count(module)"];
				// 	//echo "count = ".$count;
				// }

				if ($workstations_count > 0) {

					$sql_smv_nop = "SELECT smv,capacity_factor FROM $pps.monthly_production_plan LEFT JOIN $pps.monthly_production_plan_upload_log AS upload_log ON upload_log.monthly_production_plan_upload_log_id = monthly_production_plan.monthly_production_plan_upload_log_id WHERE  plant_code = '" . $plantcode . "'  AND planned_date ='" . $dates[$k] . "' AND `group`='" . $section_code . "' AND row_name='" . $workstation_code . "' limit 1";
					 
					$res_smv_nop = mysqli_query($link, $sql_smv_nop) or exit("Sql smv nop error" . mysqli_errno($link));
					$row_smv_nop = mysqli_fetch_row($res_smv_nop);

					$smv = $row_smv_nop[0]?$row_smv_nop[0]: 0; // SMV
					$nop = $row_smv_nop[1]?$row_smv_nop[1]: 0; // NOP

					// $sql15 = mysqli_query($link, "select distinct(nop) from $pts.grand_rep where plant_code='$plantcode' and section='$sec' and module='" . $secs[$i] . "' AND date='" . $dates[$k] . "' and styles='" . $row2['styles'] . "'") or exit("sql15 Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
					// while ($row15 = mysqli_fetch_array($sql15)) {
					// 	$nop = $row15['nop'];
					// }

					// $sql16 = mysqli_query($link, "select distinct(smv) from $pts.grand_rep where plant_code='$plantcode' and section='$sec' and module='" . $secs[$i] . "' AND date='" . $dates[$k] . "' and styles='" . $row2['styles'] . "' order by module ") or exit("sql16 Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
					// while ($row16 = mysqli_fetch_array($sql16)) {
					// 	$smv = $row16['smv'];
					// }
				} else {
					$nop = 0;
					$smv = 0;
				}


				if ($weekday1 == "Saturday") {
					// Get good quantity
					$sql_good_qty_1 = "SELECT sum(good_quantity) AS qty FROM $pts.transaction_log WHERE resource_id='" . $workstation_id . "' AND plant_code='" . $plantcode . "' AND operation='130' AND style='" . $style . "' AND created_at BETWEEN '" . $dates[$k] . " 00:00:00' AND '" . $dates[$k]  . " 23:59:59'";
					$res_good_qty_1 = mysqli_query($link, $sql_good_qty_1) or exit("sql transactions error" . mysqli_errno($link));
					$row_good_qty_1 = mysqli_fetch_row($res_good_qty_1);
					$total_good_qty = $row_good_qty_1[0];
					// Day avg
					$day_avg = round(($total_good_qty * $smv * 100) / (60 * 15 * $nop), 0);
					echo "<th style=\"background-color:#c0dcc0;\">" . round($day_avg, 0) . "</th>";
					// $sql4 = mysqli_query($link, "select sum(act_out) from $pts.grand_rep where plant_code='$plantcode' and styles='" . $row2['styles'] . "' and module='" . $secs[$i] . "' and date='" . $dates[$k] . "' and section='$sec'") or exit("sql14 Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
					// while ($row4 = mysqli_fetch_array($sql4)) {
					// 	$output = $row4['sum(act_out)'];
					// 	$day_avg = round(($output * $smv * 100) / (60 * 15 * $nop), 0);
					// 	echo "<th style=\"background-color:#c0dcc0;\">" . round($day_avg, 0) . "</th>";
					// }

					$avg = 0;
					$rlimit = $r + 1;
					$avg = round(($day_avgs + $day_avg) / $rlimit, 0);

					/*for($i=0;$i<sizeof($day_avgs);$i++)
				{
					$avg=$avg+$day_avgs[$i];
				}*/

					echo "<th style=\"background-color:#99AADD;\">" . round($avg) . "</th>";
					$day_avgs = 0;
					$avg = 0;
					$r = 0;
					$rlimit = 0;
				} else {
					// Get good quantity
					$sql_good_qty_2 = "SELECT sum(good_quantity) AS qty FROM $pts.transaction_log WHERE resource_id='" . $workstation_id . "' AND plant_code='" . $plantcode . "' AND operation='130' AND style='" . $style . "' AND created_at BETWEEN '" . $dates[$k] . " 00:00:00' AND '" . $dates[$k]  . " 23:59:59'";
					$res_good_qty_2 = mysqli_query($link, $sql_good_qty_2) or exit("sql transactions error" . mysqli_errno($link));
					$row_good_qty_2 = mysqli_fetch_row($res_good_qty_2);
					$total_good_qty = $row_good_qty_2[0];

					$day_avg1 = round(($total_good_qty * $smv * 100) / (60 * 15 * $nop), 0);
					if ($dates[$k] != $end_date) {
						$day_avgs = $day_avgs + $day_avg1;
						$r = $r + 1;
					} else {
						$day_avgs = 0;
						$r = 0;
					}

					echo "<th style=\"background-color:#c0dcc0;\">" . round($day_avg1, 0) . "</th>";

					// $sql41 = mysqli_query($link, "select sum(act_out) from $pts.grand_rep where plant_code='$plantcode' and styles='" . $row2['styles'] . "' and module='" . $secs[$i] . "' and date='" . $dates[$k] . "' and section='$sec'") or exit("sql41 Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
					// while ($row41 = mysqli_fetch_array($sql41)) {
					// 	$output1 = $row41['sum(act_out)'];
					// 	$day_avg1 = round(($output1 * $smv * 100) / (60 * 15 * $nop), 0);
					// 	if ($dates[$k] != $end_date) {
					// 		$day_avgs = $day_avgs + $day_avg1;
					// 		$r = $r + 1;
					// 	} else {
					// 		$day_avgs = 0;
					// 		$r = 0;
					// 	}

					// 	echo "<th style=\"background-color:#c0dcc0;\">" . round($day_avg1, 0) . "</th>";
					//echo "<th>".$dates[$k]."</th>";
				}
			}

			echo "</tr>";

			echo "<tr>";


			echo "<th style=\"background-color:#C4BD97;\">Avg</th>";
			for ($l = 0; $l < sizeof($dates); $l++) {
				$weekday2 = date('l', strtotime($dates[$l]));

				if ($weekday2 == "Saturday") {
					// Get good quantity
					$sql_good_qty_3 = "SELECT sum(good_quantity) AS qty FROM $pts.transaction_log WHERE resource_id='" . $workstation_id . "' AND plant_code='" . $plantcode . "' AND operation='130' AND style='" . $style . "' AND created_at BETWEEN '" . $dates[$k] . " 00:00:00' AND '" . $dates[$k]  . " 23:59:59'";
					$res_good_qty_3 = mysqli_query($link, $sql_good_qty_3) or exit("sql transactions error" . mysqli_errno($link));
					$row_good_qty_3 = mysqli_fetch_row($res_good_qty_3);
					$total_good_qty = $row_good_qty_3[0] ? $row_good_qty_3[0] : 0;

					$output = round($total_good_qty / 15, 0);
					echo "<th style=\"background-color:#c0dcc0;\">" . round($output, 0) . "</th>";

					// $sql42 = mysqli_query($link, "select sum(act_out) from $pts.grand_rep where plant_code='$plantcode' and styles='" . $row2['styles'] . "' and module='" . $secs[$i] . "' and date='" . $dates[$l] . "' and section='$sec'") or exit("sql42 Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
					// while ($row42 = mysqli_fetch_array($sql42)) {
					// 	$output = round($row42['sum(act_out)'] / 15, 0);
					// 	echo "<th style=\"background-color:#c0dcc0;\">" . round($output, 0) . "</th>";
					// }

					$limit = $p + 1;
					//echo $limit;

					$week_output = round(($day_output + $output) / $limit, 0);;

					echo "<th style=\"background-color:#99AADD;\">" . $week_output . "</th>";

					$day_output = 0;
					$week_output = 0;
					$p = 0;
					$limit = 0;
				} else {

					$sql_good_qty_4 = "SELECT sum(good_quantity) AS qty FROM $pts.transaction_log WHERE resource_id='" . $workstation_id . "' AND plant_code='" . $plantcode . "' AND operation='130' AND style='" . $style . "' AND created_at BETWEEN '" . $dates[$k] . " 00:00:00' AND '" . $dates[$k]  . " 23:59:59'";
					$res_good_qty_4 = mysqli_query($link, $sql_good_qty_4) or exit("sql transactions error" . mysqli_errno($link));
					$row_good_qty_4 = mysqli_fetch_row($res_good_qty_4);
					$total_good_qty_4 = $row_good_qty_4[0] ? $row_good_qty_4[0] : 0;

					$output1 = round($total_good_qty_4 / 15, 0);
					if ($dates[$l] != $end_date) {
						$day_output = $day_output + $output1;
						$p = $p + 1;
						//echo $p;
					} else {
						$day_output = 0;
						$p = 0;
					}

					echo "<th style=\"background-color:#c0dcc0;\">" . round($output1, 0) . "</th>";

					// $sql43 = mysqli_query($link, "select sum(act_out) from $pts.grand_rep where plant_code='$plantcode' and styles='" . $row2['styles'] . "' and module='" . $secs[$i] . "' and date='" . $dates[$l] . "' and section='$sec'") or exit("sql43 Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
					// while ($row43 = mysqli_fetch_array($sql43)) {
					// 	$output1 = round($row43['sum(act_out)'] / 15, 0);
					// 	if ($dates[$l] != $end_date) {
					// 		$day_output = $day_output + $output1;
					// 		$p = $p + 1;
					// 		//echo $p;
					// 	} else {
					// 		$day_output = 0;
					// 		$p = 0;
					// 	}
					// 	//$day_output=$day_output+$output1;
					// 	echo "<th style=\"background-color:#c0dcc0;\">" . round($output1, 0) . "</th>";
					// }
				}
			}
			echo "</tr>";
			echo "<tr>";
			echo "<th style=\"background-color:#C4BD97;\">LostHrs</th>";
			for ($l = 0; $l < sizeof($dates); $l++) {
				$weekday3 = date('l', strtotime($dates[$l]));
				if ($weekday3 == "Saturday") {
				echo "<th style=\"background-color:#c0dcc0;\">0</th>";
				echo "<th style=\"background-color:#99AADD;\">0</th>";
				}else{
					echo "<th style=\"background-color:#c0dcc0;\">0</th>";
				}
				// ****************** down_log descoped  ***************************//
				// $sql44 = mysqli_query($link, "select sum(dtime) from $bai_pro.down_log where style='" . $style . "' and mod_no='" . $workstation_id . "' and date='" . $dates[$l] . "' and section='$sec'") or exit("sql44 Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
				// while ($row44 = mysqli_fetch_array($sql44)) {
				// 	if ($weekday3 == "Saturday") {
				// 		$day_dtime = $row44['sum(dtime)'] / 60;
				// 		$week_dtime_total = $day_dtime_total + $day_dtime;
				// 		$xlimit = $x + 1;
				// 		echo "<th style=\"background-color:#c0dcc0;\">" . round($day_dtime, 0) . "</th>";
				// 		echo "<th style=\"background-color:#99AADD;\">" . round($week_dtime_total / $xlimit, 0) . "</th>";
				// 		$x = 0;
				// 		$xlimit = 0;
				// 		$day_dtime_total = 0;
				// 	} else {
				// 		$day_dtime1 = $row44['sum(dtime)'] / 60;

				// 		if ($dates[$l] != $end_date) {
				// 			$day_dtime_total = $day_dtime_total + $day_dtime1;
				// 			$x = $x + 1;
				// 		} else {
				// 			$day_dtime_total = 0;
				// 			$x = 0;
				// 		}

				// 		echo "<th style=\"background-color:#c0dcc0;\">" . round($day_dtime1, 0) . "</th>";
				// 	}
				// }
			}

			echo "</tr>";
		}
	}

	echo "</table></div>";
} else {
	echo "<div class='alert alert-danger' role='alert' style='text-align:center;text-weight:bold;' >No data found!</div>";
}

?>