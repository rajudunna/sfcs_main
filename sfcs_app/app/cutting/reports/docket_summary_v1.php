<?php 
include($_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/functions.php', 3, 'R'));
include($_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/enums.php', 3, 'R'));
$excel_form_action = getFullURL($_GET['r'], 'export_excel.php', 'R');
$table_csv = getFullURLLevel($_GET['r'], 'common/js/table2CSV.js', 1, 'R');
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
?>
<style>
	th {
		white-space: nowrap;
	}
</style>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'], 'common/js/TableFilter_EN/tablefilter.js', 3, 'R') ?>"></script>

<script type="text/javascript">
	function verify_date() {
		var val1 = $('#sdate').val();
		var val2 = $('#edate').val();

		if (val1 > val2) {
			sweetAlert('Start Date Should  be less than End Date', '', 'warning');
			return false;
		} else {
			return true;
		}
	}
</script>
<script type="text/javascript" src="<?php echo $table_csv ?>"></script>

<div class="panel panel-primary">

	<?php
	include($_SERVER['DOCUMENT_ROOT'] .'/'.getFullURLLevel($_GET['r'], 'common/config/config.php', 3,'R'));
	$sdate = $_POST['sdate'];
	$edate = $_POST['edate'];
	?>

	<div class="panel-heading">Docket Summary - Report</div>
	<div class="panel-body">
		<form name="text" method="post" action="<?php echo getFullURL($_GET['r'], "docket_summary_v1.php", "N"); ?>">

			<div class="row">
				<div class="col-md-3">
					<label>Start Date:</label>
					<input type="text" data-toggle="datepicker" class="form-control" name="sdate" id="sdate" value="<?php if ($sdate == "") {
																														echo date("Y-m-d");
																													} else {
																														echo $sdate;
																													} ?>" size="10">
				</div>
				<div class="col-md-3"><label>End Date:</label>
					<input type="text" data-toggle="datepicker" class="form-control" name="edate" id="edate" onchange='return verify_date()' value="<?php if ($edate == "") {
																																						echo date("Y-m-d");
																																					} else {
																																						echo $edate;																																	} ?>" size="10">
				</div>
				<input type="submit" class="btn btn-primary btn-sm" value="Submit" onclick='return verify_date()' name="submit" style="margin-top:25px;">
			</div>

		</form>

		<?php

		if (isset($_POST['submit'])) {
			$sdate = $_POST['sdate'];
			$edate = $_POST['edate'];
			$taskType=TaskTypeEnum::CUTJOB;
			/**
			 * getting task headers based on planned date from task header
			 */
			// $headersArray=array();
			// $qrytaskHeader="SELECT task_header_id FROM $tms.task_header WHERE plant_code='$plantcode' AND resource_id IS NOT NULL AND task_type='$taskType' AND DATE(updated_at) BETWEEN '$sdate' AND '$edate'";
			// $qrytaskHeaderResult=mysqli_query($link_new, $qrytaskHeader) or exit("Sql Error at getting taskHeaders".mysqli_error($GLOBALS["___mysqli_ston"]));
            // $taskHeaderNum=mysqli_num_rows($qrytaskHeaderResult);
            // if($taskHeaderNum>0){
            //     while($taskHeader_row=mysqli_fetch_array($qrytaskHeaderResult))
            //     {
            //         $headersArray[]=$taskHeader_row['task_header_id']; 
            //     }
			// }
			// $taskHeaders = implode("','", $headersArray);

			/**
			 * getting task jobs wrt  task headers
			 */
			// $taskJObsArray=array();
			// $taskType=TaskTypeEnum::DOCKET;
			// $qrytaskJobs="SELECT task_header_id FROM $tms.task_jobs WHERE plant_code='$plantcode' AND task_type='$taskType' AND task_header_id IN ('$taskHeaders')";
			// $qrytaskJobsResult=mysqli_query($link_new, $qrytaskJobs) or exit("Sql Error at getting taskJobs".mysqli_error($GLOBALS["___mysqli_ston"]));
            // $taskJobsNum=mysqli_num_rows($qrytaskJobsResult);
            // if($taskJobsNum>0){
            //     while($taskJobsRow=mysqli_fetch_array($qrytaskJobsResult))
            //     {
            //         $taskJObsArray[]=$taskJobsRow['task_header_id']; 
            //     }
			// }
			// $taskJobs = implode("','", $taskJObsArray);

			/**
			 * getting dockets wrt taskjobs
			 */
			$qrydocketLines="SELECT docLine.jm_docket_line_id,docLine.fg_color,docLine.docket_line_number,docLine.is_binding,docLine.jm_docket_id,ratio_cg.component_group_id as cg_id,docLine.plies, ratio_cg.ratio_id,ratio_cg.fabric_saving,docLine.lay_status,l.date_n_time AS fab_ready_time,cut.cut_number,cut.po_number ,doc.ratio_comp_group_id
			FROM $pps.jm_docket_lines docLine 
			LEFT JOIN $pps.jm_dockets doc ON doc.jm_docket_id = docLine.jm_docket_id
			LEFT JOIN $pps.jm_cut_job cut ON cut.jm_cut_job_id = doc.jm_cut_job_id
			LEFT JOIN $pps.lp_ratio_component_group ratio_cg ON ratio_cg.lp_ratio_cg_id = doc.ratio_comp_group_id
			LEFT JOIN $pps.log_rm_ready_in_pool l ON docLine.jm_docket_id=l.jm_docket_line_id
			WHERE docLine.plant_code='$plantcode' AND DATE(docLine.created_at) BETWEEN '$sdate' AND '$edate'";
			//echo $qrydocketLines;
			$docketLinesResult=mysqli_query($link_new, $qrydocketLines) or exit("Sql Error at getting taskJobs".mysqli_error($GLOBALS["___mysqli_ston"]));
            $docketLinesNum=mysqli_num_rows($docketLinesResult);
			if ($docketLinesNum > 0) {
				echo "<div class=\"table-responsive\">";
				echo '<span class="pull-right">
				<form action="' . $excel_form_action . '" method ="post" > 
					<input type="hidden" name="csv_123" id="csv_123">
					<input class="btn btn-info btn-sm" type="submit" value="Export to Excel" onclick="getCSVData()">
				</form></span>';

				echo "<table class=\"table table-bordered\" id=\"table_one\" >";
				echo "<thead><tr class=\"info\"><th>Style</th><th>Schedule</th><th>Color</th><th>Fabric Category</th><th>Docket#</th>
				<th>Fabric Requirement</th><th>UOM</th>
				<th>Cut#</th><th>Fabric requested user</th>
				<th>CPS status</th><th>CPS status log time</th>
				<th>User log time</th><th>Fab. requested time</th><th>Fab. Ready time</th><th>Fab. Issued time</th><th>Docket print status</th><th>Docket printed user</th><th>Actual cut status</th></tr></thead>";
				while($taskJobsRow=mysqli_fetch_array($docketLinesResult))
                {
                    $jm_docket_line_id=$taskJobsRow['jm_docket_line_id']; 
                    $doc_no=$taskJobsRow['docket_line_number']; 
					$is_binding=$taskJobsRow['is_binding'];
					$doc_no = $taskJobsRow['docket_line_number'];
					$jm_docket_id = $taskJobsRow['jm_docket_id'];
					$cg_id = $taskJobsRow['cg_id'];
					$plies =  $taskJobsRow['plies'];
					$ratio_id = $taskJobsRow['ratio_id'];
					$fabric_saving = $taskJobsRow['fabric_saving'];
					$act_cut_status = $taskJobsRow['lay_status'];
					$fab_ready_time = $taskJobsRow['fab_ready_time'];
					$fg_color = $taskJobsRow['fg_color'];
					$pcutno = $taskJobsRow['cut_number'];
					$po_number = $taskJobsRow['po_number'];
					$ratio_comp_group_id = $taskJobsRow['ratio_comp_group_id'];

					$qry_lp_markers="SELECT length FROM $pps.`lp_markers` WHERE `lp_ratio_cg_id`='$ratio_comp_group_id' AND default_marker_version=1 AND `plant_code`='$plantcode'";
					$lp_markers_result=mysqli_query($link_new, $qry_lp_markers) or exit("Sql Errorat_lp_markers".mysqli_error($GLOBALS["___mysqli_ston"]));
					$lp_markers_num=mysqli_num_rows($lp_markers_result);
					if($lp_markers_num>0){
						while($sql_row1=mysqli_fetch_array($lp_markers_result))
						{
							$length = $sql_row1['length'];
						}
					}else{
						$length=0;
					}
					
					//To get schedule,color
					$qry_get_sch_col="SELECT schedule,color FROM $pps.`mp_sub_mo_qty` LEFT JOIN $pps.`mp_mo_qty` ON mp_sub_mo_qty.`mp_mo_qty_id`= mp_mo_qty.`mp_mo_qty_id`
					WHERE po_number='$po_number' AND mp_sub_mo_qty.plant_code='$plantcode'";
					$qry_get_sch_col_result=mysqli_query($link_new, $qry_get_sch_col) or exit("Sql Error at qry_get_sch_col".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row=mysqli_fetch_array($qry_get_sch_col_result))
					{
						$schedule[]=$row['schedule'];
						$color[]=$row['color'];
					}
					$order_col_des=array_unique($color);
					//To get style
					$qry_get_style="SELECT style FROM $pps.`mp_mo_qty` LEFT JOIN $pps.`mp_color_detail` ON mp_color_detail.`master_po_details_id`=mp_mo_qty.`master_po_details_id` WHERE mp_mo_qty.color in ('".implode("','" , $order_col_des)."') and mp_mo_qty.schedule in ('".implode("','" , $schedule)."') and mp_color_detail.plant_code='$plantcode'";
					//echo "</br>Qry :".implode(',', array_unique($schedule)).$qry_get_style;
					$qry_get_style_result=mysqli_query($link_new, $qry_get_style) or exit("Sql Error at qry_get_style".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row1=mysqli_fetch_array($qry_get_style_result))
					{
						$style[]=$row1['style'];
					}    
					$order_style_no=array_unique($style);
					$order_del_no=array_unique($schedule);
					
					/**
					 * getting print_status,fabric_status info 
					 */
					$qryrequestedDockets="SELECT print_status,fabric_status,updated_user,created_at FROM $pps.requested_dockets WHERE jm_docket_line_id='$jm_docket_line_id' AND plant_code='$plantcode'";
					$requestedDocketsResult=mysqli_query($link_new, $qryrequestedDockets) or exit("Sql Error at getting requested Dockets".mysqli_error($GLOBALS["___mysqli_ston"]));
					$requestedDockets=mysqli_num_rows($requestedDocketsResult);
					if($requestedDockets>0){
						while($rDocketsRow=mysqli_fetch_array($requestedDocketsResult))
						{
							$print_status=$rDocketsRow['print_status']; 
							$fabric_status=$rDocketsRow['fabric_status'];
							$docket_printed_person = $rDocketsRow['updated_user'];
							$log_update = $sql_row['created_at']; 
						}
					}

					/**
					 * getting fabric priorities 
					 */
					$qryfabricPriorities="SELECT created_user,created_at,req_time,issued_time FROM $pps.fabric_prorities WHERE jm_docket_line_id='$jm_docket_line_id' AND plant_code='$plantcode'";
					$fabricPrioritiesResult=mysqli_query($link_new, $qryfabricPriorities) or exit("Sql Error at getting requested Dockets".mysqli_error($GLOBALS["___mysqli_ston"]));
					$fabricPriorities=mysqli_num_rows($fabricPrioritiesResult);
					if($fabricPriorities>0){
						while($fabricPrioritiesRow=mysqli_fetch_array($fabricPrioritiesResult))
						{
							$req_user=$fabricPrioritiesRow['created_user']; 
							$log_time = $fabricPrioritiesRow['created_at']; 
							$req_time = $fabricPrioritiesRow['req_time']; 
							$issued_time = $fabricPrioritiesRow['issued_time']; 
						}
					}

					// get the rm sku, fabric catrgory
					$fabric_info_query = "SELECT fabric_category, material_item_code FROM $pps.lp_component_group where lp_cg_id = '$cg_id' ";
					$fabric_info_result=mysqli_query($link_new, $fabric_info_query) or exit("Sql fabric_info_query".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row = mysqli_fetch_array($fabric_info_result))
					{
						$category = $row['fabric_category'];
						$rm_sku = $row['material_item_code'];
					}
					
					// get the docket qty
					// $size_ratio_sum = 0;
					// $size_ratios_query = "SELECT size, size_ratio FROM $pps.lp_ratio_size WHERE ratio_id = '$ratio_id' ";
					// $size_ratios_result=mysqli_query($link_new, $size_ratios_query) or exit("Sql fabric_info_query".mysqli_error($GLOBALS["___mysqli_ston"]));
					// while($row = mysqli_fetch_array($size_ratios_result))
					// {
					// 	$size_ratio_sum += $row['size_ratio'];
					// }
					//echo "</br>Size : ".$size_ratio_sum."- plies".$plies;
					$material_requirement_orig = ($length * $plies);
				
					$extra = 0; {
						$extra = round(($material_requirement_orig * $fabric_saving), 2);
					}
					
					if ($fab_ready_time == "") {
						$fab_ready_time = "NULL";
					}
					
					if ($issued_time == "0000-00-00 00:00:00") {
						$issued_time = "NULL";
					}
					echo "<tr style=\"color: #000000\">";
					echo "<td>".implode(',', $order_style_no)."</td>";
					echo "<td>".implode(',', $order_del_no)."</td>";
					echo "<td>".implode(',', $order_col_des)."</td>";
					echo "<td>$category</td>";
					echo "<td>$doc_no</td>";
					echo "<td>" . ($material_requirement_orig + $extra) . "</td>";
					echo "<td>" . $fab_uom . "</td>";
					//echo "<td>" . chr($color_code) . leading_zeros($pcutno, 3) . "</td>";
					echo "<td>". leading_zeros($pcutno, 3) . "</td>";
					echo "<td>$req_user</td>";
					if ($fabric_status == "5") {
						echo "<td>Fab. Issued</td>";
					} else if ($fabric_status == "8") {
						echo "<td>Fab. Ready in Pool</td>";
					} else {
						echo "<td> - </td>";
					}
					echo "<td>$log_update</td>";
					echo "<td>$log_time</td>";
					echo "<td>$req_time</td>";
					echo "<td>" . $fab_ready_time . "</td>";
					echo "<td>$issued_time</td>";
					echo "<td>$print_status</td>";
					echo "<td>$docket_printed_person</td>";
					echo "<td>$act_cut_status</td>";
					echo "</tr>";
					unset($schedule);
					unset($color);
					unset($style);
				}
				echo "</table></div>";
			
			}else {
				echo "<div class='alert alert-danger'>No Data Found...</div>";
			}
		}
		?>
		<script language="javascript" type="text/javascript">
			$('#reset_table_one').addClass('btn btn-warning');

			var MyTableFilter = {
				exact_match: false,
				alternate_rows: true,
				// display_all_text: "Show All",
				// col_0: "select",
				// col_1: "select",
				rows_counter: true,
				rows_counter_text: "Total rows: ",
				btn_reset: true,

				bnt_reset_text: "Clear all "
			}
			setFilterGrid("table_one", MyTableFilter);
			$(document).ready(function() {
				$('#reset_table_one').addClass('btn btn-warning btn-xs');
			});
		</script>
		<script>
			function getCSVData() {
				var csv_value = $('#table_one').table2CSV({
					delivery: 'value'
				});
				$("#csv_123").val(csv_value);
			}
		</script>
		<style>
			#reset_table_one {
				width: 80px;
				color: #fff;
				margin: 10px;
			}

			th,
			td {
				text-align: center;
			}
		</style>
	</div>
</div>