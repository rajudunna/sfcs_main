<style>
	th {
		background-color: #003366;
		color: WHITE;
		border-bottom: 5px solid white;
		border-top: 5px solid white;
		padding: 5px;
		white-space: nowrap;
		border-collapse: collapse;
		text-align: center;
		font-family: Calibri;
		font-size: 110%;

	}

	table {
		white-space: nowrap;
		border-collapse: collapse;
		font-size: 12px;
		background-color: white;
	}

	td {
		color: black;
		font-size: 12px;
		font-weight: bold;
		text-align: center;
	}
</style>

<?php
error_reporting(0);
include($_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/config.php', 3, 'R'));
include($_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'exp_mod_main.php', 0, 'R'));
$plantcode = $_SESSION['plantCode'];
$username = $_SESSION['userName'];

$start = $_GET['dat1'];
$end = $_GET['dat2'];
$sec = $_GET['sec'];
$cat = $_GET['cat'];

 
$dates = [];
//Get modules for sections
$sql_workstations = "SELECT workstation_id,workstation_code FROM $pms.workstation where section_id ='" . $sec . "'";
$res_workstations = mysqli_query($link, $sql_workstations) or exit("sql workstation error" . mysqli_error($link));
while ($row_workstation = mysqli_fetch_array($res_workstations)) {
	$sql_date = "SELECT DISTINCT(DATE(created_at)) AS created_at FROM $pts.transaction_log WHERE resource_id='" . $row_workstation['workstation_id'] . "' AND plant_code='" . $plantcode . "' AND operation='130' AND created_at BETWEEN '" . $start . " 00:00:00' AND '" . $end  . " 23:59:59'";

	$res_date = mysqli_query($link, $sql_date) or exit("sql transactions error" . mysqli_errno($link));
	while ($row_date = mysqli_fetch_array($res_date)) {
		$dates[] = $row_date['created_at'];
	}
}
$dates_unique = array_unique($dates);
sort($dates_unique);



// $sql = "select distinct(date) from $pts.grand_rep where plant_code='$plantcode' and section='$sec' AND  date between '$start' and '$end' order by date";

// $sql_result = mysqli_query($link, $sql) or exit("Sql Error1=" . mysqli_error($GLOBALS["___mysqli_ston"]));
// while ($row = mysqli_fetch_array($sql_result)) {
// 	$date[] = $row['date'];
// 	//echo "<br>Date = ".$row['date'];//$weekday1 = date('l', strtotime($date));
// }

// $sql1 = mysqli_query($link, "select sec_mods from $bai_pro3.sections_db where sec_id='$sec'") or exit("sql1 Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
// while ($row1 = mysqli_fetch_array($sql1)) {
// 	$sections = $row1['sec_mods'];
// 	//echo "<br>Date = ".$row['date'];//$weekday1 = date('l', strtotime($date));
// }
// $secs = explode(",", $sections);
//echo sizeof($secs);
// for ($i = 0; $i < sizeof($date); $i++) {
// 	$date1 = $date[$i];
// 	$weekday1 = date('l', strtotime($date1));
// 	//echo "<br>week =".$weekday1." Date = ".$date[$i]."<br>";
// }


// $sql = mysqli_query($link, "select distinct(date) from $pts.grand_rep where plant_code='$plantcode' and section='$sec' AND  date between '$start' and '$end' order by date") or exit("sql Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
if (sizeof($dates_unique) > 0) {
	echo "<div class='table-responsive' style='max-height:600px;overflow-y:scroll;'><table class='table table-bordered'>";
	echo "<tr class='tblheading' style='color:white;' >";
	echo "<th style=\"background-color:#29759C;color:white;\">Module</th>";
	echo "<th style=\"background-color:#29759C;color:white;\">Style</th>";
	echo "<th style=\"background-color:#29759C;color:white;\">Details</th>";

	for ($i = 0; $i < sizeof($dates_unique); $i++) {
		$date = $dates_unique[$i];
		$weekday = date('l', strtotime($date));
		if ($weekday == "Saturday") {
			echo "<th style=\"background-color:#29759C; color:white;\">" . $date . "</th>";
			echo "<th style=\"background-color:#29759C; color:white;\">Week Avg</th>";
		} else {
			echo "<th style=\"background-color:#29759C; color:white;\">" . $date . "</th>";
		}
	}

	// while ($row = mysqli_fetch_array($sql)) {
	// 	$date = $row['date'];
	// 	$weekday = date('l', strtotime($date));
	// 	//$l=$k+$l;
	// 	if ($weekday == "Saturday") {
	// 		echo "<th style=\"background-color:#29759C; color:white;\">" . $row['date'] . "</th>";
	// 		echo "<th style=\"background-color:#29759C; color:white;\">Week Avg</th>";
	// 	} else {
	// 		echo "<th style=\"background-color:#29759C; color:white;\">" . $row['date'] . "</th>";
	// 	}
	// }

	$out = 0;
	$out1 = 0;
	$out3 = 0;
	$out5 = 0;
	$k = 0;
	$j = 0;
	$t = 1;
	$s = 1;
	$p = 0;
	$r = 1;
	$act_hoursx = 0;
	$act_hours = 0;


	/*$sql1=mysql_query("select distinct(module) from $database.$table1 where section='$sec' AND date between '$start' and '$end' order by module ");
while($row1=mysql_fetch_array($sql1))
{ */
	//TO caliculate act hours
	$get_acthours = "SELECT plant_start_time,plant_end_time FROM $pms.plant WHERE plant_code='$plant_code' AND is_active=1";
	$sql_get_acthours = mysqli_query($link_new, $get_acthours) or exit("Sql sql_get_acthours" . mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($actrows = mysqli_fetch_array($sql_get_acthours)) {
		$start_time = $actrows['plant_start_time'];
		$end_time = $actrows['plant_end_time'];
		$diff_time = $end_time - $start_time;
		$act_hrs = $diff_time - 0.5;
		$shif_hrs = $act_hrs/2;
	}
	 
	$res_workstations_2 = mysqli_query($link, $sql_workstations) or exit("sql workstation error" . mysqli_error($link));
	while ($row_workstation2 = mysqli_fetch_array($res_workstations_2)) {
		$workstation_id = $row_workstation2['workstation_id'];
		$workstation_code = $row_workstation2['workstation_code'];

		// $sql2 = mysqli_query($link, "select distinct(styles) from $pts.grand_rep where plant_code='$plantcode' and section='$sec' AND module='" . $secs[$i] . "' and date between '$start' and '$end' order by module ") or exit("sql2 Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo "select distinct(styles) from $database.$table1 where section='$sec' AND module='".$secs[$i]."' and date between '$start' and '$end' order by module";

		// Get Distinct Styles from transaction log
		$sql_get_styles = "SELECT DISTINCT(style) FROM $pts.transaction_log where plant_code='" . $plantcode . "' AND operation='130' AND created_at BETWEEN '" . $start . " 00:00:00' AND '" . $end  . " 23:59:59'";

		$res_get_styles = mysqli_query($link, $sql_get_styles) or exit("sql styles error - " . mysqli_error($link));
		$style_count = mysqli_num_rows($res_get_styles);


		while ($row_styles = mysqli_fetch_array($res_get_styles)) {
			$style = $row_styles['style'];
			echo "<tr>";
			echo "<td rowspan=2 style=\"background-color:#00ffff;\">" . $workstation_code . "</td>";
			echo "<td rowspan=2 style=\"background-color:#00ffff;\">" . $style . "</td>";

			echo "<td style=\"background-color:#C4BD97;\">A SHIFT</td>";

			// $sql3 = mysqli_query($link, "select distinct(date) from $pts.grand_rep where plant_code='$plantcode' and section='$sec' AND  date between '$start' and '$end' order by date") or exit("sql3 Error" . mysqli_error($GLOBALS["___mysqli_ston"]));

			// while ($row3 = mysqli_fetch_array($sql3)) {
				 
			for ($j = 0; $j < sizeof($dates_unique); $j++) {
				$date = $dates_unique[$j];
				 

				// $sql4 = mysqli_query($link, "select sum(act_out) from $pts.grand_rep where plant_code='$plantcode' and styles='" . $row2['styles'] . "' and module='" . $secs[$i] . "' and date='" . $row3['date'] . "' and section='$sec' AND shift=\"A\"") or exit("sql4 Error" . mysqli_error($GLOBALS["___mysqli_ston"]));

				$sql_good_qty = "SELECT sum(good_quantity) AS qty FROM $pts.transaction_log WHERE resource_id='" . $workstation_id . "' AND style='" . $style . "' AND plant_code='" . $plantcode . "' AND shift='A' AND operation='130' AND created_at BETWEEN '" . $date . " 00:00:00' AND '" . $date  . " 23:59:59'";
				// echo $sql_good_qty."<br>";
				$res_good_qty = mysqli_query($link, $sql_good_qty) or exit("sql transactions error" . mysqli_errno($link));
				$row_good_qty = mysqli_fetch_row($res_good_qty);
				$qty = $row_good_qty[0] ;
				// while ($row4 = mysqli_fetch_array($sql4)) {
				// $date1 = $row3['date'];
				$weekday1 = date('l', strtotime($date));
				// $sqlxx4 = mysqli_query($link, "select act_hours from $pts.pro_plan where plant_code='$plantcode' and mod_no='" . $secs[$i] . "' and date='" . $row3['date'] . "' and sec_no='$sec' AND shift=\"A\"") or exit("sqlxx4 Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
				// while ($rowxx4 = mysqli_fetch_array($sqlxx4)) {
				// 	$act_hoursx = $rowxx4["act_hours"];
				// }

				if ($weekday1 != "Saturday") {					 
					$k = $k + 1; 
					$tot = ($qty / $shif_hrs);
					$out = $out + ($qty / $shif_hrs);
					echo "<td style=\"background-color:#c0dcc0;\">" . round($tot, 0) . "</td>";
				} else {
					$t = $k + $t;					 
					$tot = ($qty / $shif_hrs);
					$out2 = $out + ($qty / $shif_hrs);
					echo "<td style=\"background-color:#c0dcc0;\">" . round($tot, 0) . "</td>";
					echo "<td style=\"background-color:#99AADD;\">" . round($out2 / $t, 0) . "</td>";
					$t = 0;
					$out = 0;
					$k = 1;
					//$out2=0;	
				}
				// }
			}
			echo "</tr>";

			echo "<tr>";
			echo "<td style=\"background-color:#C4BD97;\">B SHIFT</td>";

			// $sql3 = mysqli_query($link, "select distinct(date) from $pts.grand_rep where plant_code='$plantcode' and section='$sec' AND  date between '$start' and '$end' order by date") ;
			// or exit("sql3 Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
			// while ($row3 = mysqli_fetch_array($sql3)) {
				for ($l = 0; $l < sizeof($dates_unique); $l++) {
					$date = $dates_unique[$l];
				// $sql4 = mysqli_query($link, "select sum(act_out) from $pts.grand_rep where plant_code='$plantcode' and styles='" . $row2['styles'] . "' and module='" . $secs[$i] . "' and date='" . $row3['date'] . "' and section='$sec' AND shift=\"B\"") or exit("sql4 Error" . mysqli_error($GLOBALS["___mysqli_ston"]));

				// while ($row4 = mysqli_fetch_array($sql4)) {
					$sql_good_qty_b = "SELECT sum(good_quantity) AS qty FROM $pts.transaction_log WHERE resource_id='" . $workstation_id . "' AND style='" . $style . "' AND plant_code='" . $plantcode . "' AND shift='B' AND operation='130' AND created_at BETWEEN '" . $date . " 00:00:00' AND '" . $date  . " 23:59:59'";
				// echo $sql_good_qty_b."<br>";
				$res_good_qty_b = mysqli_query($link, $sql_good_qty_b) or exit("sql transactions error" . mysqli_errno($link));
				$row_good_qty_b = mysqli_fetch_row($res_good_qty_b);
				$qty = $row_good_qty_b[0];

					// $date1 = $row3['date'];
					$weekday1 = date('l', strtotime($date));
					// $sqlx4 = mysqli_query($link, "select act_hours from $pts.pro_plan where plant_code='$plantcode' and mod_no='" . $secs[$i] . "' and date='" . $row3['date'] . "' and sec_no='$sec' AND shift=\"B\"") or exit("sqlx4 Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
					// while ($rowx4 = mysqli_fetch_array($sqlx4)) {
					// 	$act_hours = $rowx4["act_hours"];
					// }
					if ($weekday1 != "Saturday") {
						$k = $k + 1;					 
						$tot = ($qty / $shif_hrs);
						$out = $out + ($qty / $shif_hrs);
						echo "<td style=\"background-color:#c0dcc0;\">" . round($tot, 0) . "</td>";
					} else {
						$t = $k + $t;						 
						$tot = ($qty / $shif_hrs);
						$out2 = $out + ($qty / $shif_hrs);
						echo "<td style=\"background-color:#c0dcc0;\">" . round($tot, 0) . "</td>";
						echo "<td style=\"background-color:#99AADD;\">" . round($out2 / $t, 0) . "</td>";
						$t = 0;
						$out = 0;
						$k = 1;
						//$out2=0;	
					}
				// }
			}
			echo "</tr>";
		}
	}

	echo "</tr>";

	echo "</table></div><br/></div>";
} else {
	echo "<div class='alert alert-danger' role='alert' style='text-align:center;text-weight:bold;' >No data found!</div>";
}
?>