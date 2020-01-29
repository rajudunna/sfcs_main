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

	$selected_date = $_GET['date'];
	$selected_hour = $_GET['hour'];

	$plant_timings_query="SELECT * FROM $bai_pro3.tbl_plant_timings where time_value = '$selected_hour'";
	// echo $plant_timings_query;
	$plant_timings_result11=mysqli_query($link,$plant_timings_query);
	while ($row = mysqli_fetch_array($plant_timings_result11))
	{
		$start_time = $row['start_time'];
		$end_time = $row['end_time'];
		$time_display = $row['time_display'].' '.$row['day_part'];
	}

	$bai_log_qry="SELECT * FROM $bai_pro.bai_log WHERE bac_date='$selected_date' AND TIME(bac_lastup) BETWEEN '$start_time' AND '$end_time'";
	// echo $bai_log_qry.';<br>';
	$bai_log_result=mysqli_query($link,$bai_log_qry);

?>
<div class="panel panel-primary">
	<div class="panel-heading">Scanned Bundles in <?= $time_display; ?> </div>
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
								$ims_pro_ref = $res1['ims_pro_ref'];
								$module = $res1['bac_no'];
								$qty = $res1['bac_Qty'];
								$user = $res1['loguser'];
								$shift = $res1['bac_shift'];
								$temp = explode('-', $ims_pro_ref);

								echo "
									<tr>
										<td>".$temp[0]."</td>
										<td>$module</td>
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
