<html>
	<head>
		<?php 
		  include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
		  include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',4,'R'));
		  $plant_code = $_SESSION['plantCode'];
		?>
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
							<th style="display: none;">
							<center>SNO</center></th>
							<th><center>Schedule No</center></th>
							<th><center>Sewing Job Number</center></th>
							<!-- <th><center>Barcode Number</center></th> -->
							<th><center>From Module</center></th>
							<th><center>To Module</center></th>
							<th><center>UserName</center></th>
							<th><center>Moved On</center></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$sno=0;
							$tasktype = TaskTypeEnum::SEWINGJOB;
							$get_data = "SELECT id,task_job_id,from_module,to_module,created_user,updated_at FROM $tms.`jobs_movement_track` WHERE plant_code='$plant_code' ORDER BY updated_at";
							$resultr1=mysqli_query($link, $get_data) or exit("Error while getting details ".$get_data);
							while($sql_rowr1=mysqli_fetch_array($resultr1))
							{
								$qry_get_task_job="SELECT task_jobs_id FROM $tms.task_jobs WHERE task_job_reference='".$sql_rowr1["task_job_id"]."' AND plant_code='$plant_code' AND task_type='$tasktype'";
								$qry_get_task_job_result = mysqli_query($link_new, $qry_get_task_job) or exit("Sql Error at qry_get_task_job" . mysqli_error($GLOBALS["___mysqli_ston"]));
								while ($row21 = mysqli_fetch_array($qry_get_task_job_result)) {
									$task_jobs_id = $row21['task_jobs_id'];
								}
                                //TO GET STYLE AND COLOR FROM TASK ATTRIBUTES USING TASK JOB ID
								$job_detail_attributes = [];
								$qry_toget_style_sch = "SELECT * FROM $tms.task_attributes where task_jobs_id ='".$task_jobs_id."' and plant_code='$plant_code'";
								$qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("Sql Error at toget_style_sch" . mysqli_error($GLOBALS["___mysqli_ston"]));
								while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) {
							
								  $job_detail_attributes[$row2['attribute_name']] = $row2['attribute_value'];
								
								}
								$schedule = $job_detail_attributes[$sewing_job_attributes['schedule']];
								$jobno = $job_detail_attributes[$sewing_job_attributes['sewingjobno']]; 
								if($sql_rowr1['from_module'] !='No Module')
								{
                                    //To get workstation description for from module
									$query_get_workdes_from_mod = "select workstation_code from $pms.workstation where plant_code='$plant_code' and workstation_id = '".$sql_rowr1['from_module']."' AND is_active=1";
									$result3 = $link->query($query_get_workdes_from_mod);
									while($des_from_row = $result3->fetch_assoc())
									{
										$work_code_from_mod = $des_from_row['workstation_code'];
									}
								}
								else
								{
									$work_code_from_mod=$sql_rowr1['from_module'];
								}
								if($sql_rowr1['to_module'] !='No Module')
								{
                                    //To get workstation description for to module
									$query_get_workdes_to_mod = "select workstation_code from $pms.workstation where plant_code='$plant_code' and workstation_id = '".$sql_rowr1['to_module']."' AND is_active=1";
									$result4 = $link->query($query_get_workdes_to_mod);
									while($des_to_row = $result4->fetch_assoc())
									{
										$work_code_to_mod = $des_to_row['workstation_code'];
									}
								}
								else
								{
									$work_code_to_mod=$sql_rowr1['to_module'];
								}
								
								echo"
									<tr>
										<td style='display: none;'><center>".$sno++."</center></td>
										<td><center>".$schedule."</center></td>
										<td><center>".$jobno."</center></td>
										<td><center>".$work_code_from_mod."</center></td>
										<td><center>".$work_code_to_mod."</center></td>
										<td><center>".$sql_rowr1["created_user"]."</center></td>
										<td><center>".$sql_rowr1["updated_at"]."</center></td>
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