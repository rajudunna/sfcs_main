<style type="text/css">
	table, th, td {
		text-align: center;
	}

	.left_col,.top_nav{
		display:none !important;
	}
	.right_col{
		width: 100% !important;
		margin-left: 0 !important;
	}
</style>

<?php
	include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
	$plantcode=$_SESSION['plantCode'];
	$selected_date = $_GET['date'];
	$selected_hour = $_GET['hour'];

	$plant_timings_query="SELECT * FROM $pms.plant where plant_code='$plantcode'";
	$plant_timings_result11=mysqli_query($link,$plant_timings_query);
	while ($row = mysqli_fetch_array($plant_timings_result11))
	{
		$start_time = $row['plant_start_time'];
		$end_time = $row['plant_end_time'];
		// $time_display = $row['time_display'].' '.$row['day_part'];
	}

	$bai_log_qry="SELECT * FROM $pts.transaction_log WHERE plant_code='$plantcode' and DATE_FORMAT(created_at,'%Y-%m-%d')='$selected_date' AND TIME(updated_at) BETWEEN '$start_time' AND '$end_time'";
	//   echo $bai_log_qry.';<br>';
	$bai_log_result=mysqli_query($link,$bai_log_qry);

?>
<div class="panel panel-primary">
	<div class="panel-heading">Scanned Bundles </div>
	<div class="panel-body">
		<?php
			if (mysqli_num_rows($bai_log_result) > 0) {
				echo '
					<table class="table table-bordered"  id="table1">
						<thead>
							<tr class="info">
								<td>Bundle Number</td>
								<td>Module Number</td>
								<td>Quantity</td>
								<td>Employee</td>
								<td>Shift</td>
							</tr>
						</thead>
						<tbody>';
							while($res1=mysqli_fetch_array($bai_log_result))
							{
								$ims_pro_ref = $res1['bundle_number'];
								$module = $res1['resource_id'];
								$module_qry="SELECT workstation_code FROM $pms.workstation WHERE plant_code='$plantcode' and workstation_id='$module '";
								//  echo $module_qry.';<br>';
								$module_qry_result=mysqli_query($link,$module_qry);
								while($res11=mysqli_fetch_array($module_qry_result))
							{
								$workstation_code = $res11['workstation_code'];

							}

								$qty = $res1['good_quantity'];
								$user = $res1['created_user'];
								$shift = $res1['shift'];
								$barcode = $res1['barcode'];
								$temp = explode('-', $ims_pro_ref);

								echo "
									<tr>
										<td>".$barcode."</td>
										<td>$workstation_code</td>
										<td>$qty</td>
										<td>$user</td>
										<td>$shift</td>
									</tr>
								";
							}
					echo '</table>';
			} else {
				echo '<div class="alert alert-danger">
					  <strong>No Bundles were Scanned in time: '.$time_display.'</strong>
					</div>';
			}
		?>		
	</div>
</div>

<script language="javascript" type="text/javascript">
	$(document).ready(function() {
	    $('#table1').DataTable();
	});
</script>
