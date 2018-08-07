<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));?>
		<style>
			.left_col,.top_nav{
			display:none !important;
			}
			.right_col{
			width: 100% !important;
			margin-left: 0 !important;
			}
		</style>
	</head>
	<body>
		<div class="panel panel-primary">
			<div class="panel-heading"><strong>Sewing Jobs Movement Track</strong></div>
			<div class="panel-body">
				<table id="example" class="table table-bordered">
					<thead>
						<tr>
							<th><center>Schedule No</center></th>
							<th><center>Docket No</center></th>
							<th><center>Sewing Job Number</center></th>
							<th><center>From Module</center></th>
							<th><center>To Module</center></th>
							<th><center>Moved On</center></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$get_data = "SELECT * FROM $bai_pro3.`jobs_movement_track` ORDER BY log_time DESC";
							$resultr1=mysqli_query($link, $get_data) or exit("Error while getting details ".$get_data);
							while($sql_rowr1=mysqli_fetch_array($resultr1))
							{
								echo"
									<tr><td><center>".$sql_rowr1["schedule_no"]."</center></td>
										<td><center>".$sql_rowr1["doc_no"]."</center></td>
										<td><center>".$sql_rowr1["input_job_no_random"]."</center></td>
										<td><center>".$sql_rowr1["from_module"]."</center></td>
										<td><center>".$sql_rowr1["to_module"]."</center></td>
										<td><center>".$sql_rowr1["log_time"]."</center></td>
									</tr>
								";
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
		<script>
		$(function(){
		$("#example").dataTable();
		})
		</script>
	</body>
</html>