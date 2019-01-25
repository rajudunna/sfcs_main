<?php
	include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
	include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions.php");

	if (isset($_POST['selected_date'])) {
		$selected_date = $_POST['selected_date'];
	} else {
		$selected_date=date("Y-m-d");
	}
	if (isset($_POST['selected_hour'])) {
		$selected_hour = $_POST['selected_hour'];
	}
	if (isset($_POST['selected_section'])) {
		$selected_section = $_POST['selected_section'];
	}
?>
	<style type="text/css">
		table, th, td {
			text-align: center;
		}
	</style>
	
	<script src = "<?= getFullURLLevel($_GET['r'],'common/js/highcharts.js',2,'R'); ?>"></script>
	<div class="panel panel-primary">
		<div class="panel-heading">Day & Hour Report</div>
		<div class="panel-body">
			<form action="?r=<?=$_GET['r']?>" class='form-inline' name='form_name' method="POST">
				<label>Date: </label>
				<input type="text" name="selected_date" data-toggle="datepicker" value='<?php echo $selected_date;  ?>' id="selected_date" class="form-control" required>
				&nbsp;&nbsp;
				<label>Hour: </label>
				<select name="selected_hour" id="selected_hour" class="form-control" required>
					<option value="">Please Select</option>
					<?php
						$sql="SELECT DISTINCT time_value, day_part FROM $bai_pro3.tbl_plant_timings";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error2");
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							if(str_replace(" ","",$sql_row['time_value'])==str_replace(" ","",$selected_hour))
							{
								echo "<option value=\"".$sql_row['time_value']."\" selected>".$sql_row['time_value'].' '.$sql_row['day_part']."</option>";
							}
							else
							{
								echo "<option value=\"".$sql_row['time_value']."\">".$sql_row['time_value'].' '.$sql_row['day_part']."</option>";
							}
						}
					?>
				</select>
				&nbsp;&nbsp;
				<label>Section: </label>
				<select name="selected_section" id="selected_section" class="form-control" required>
					<option value="all">All</option>
					<?php
						$sql="SELECT DISTINCT sec_name FROM $bai_pro3.sections_master ORDER BY sec_name";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error2");
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							if(str_replace(" ","",$sql_row['sec_name'])==str_replace(" ","",$selected_section))
							{
								echo "<option value=\"".$sql_row['sec_name']."\" selected>".$sql_row['sec_name']."</option>";
							}
							else
							{
								echo "<option value=\"".$sql_row['sec_name']."\">".$sql_row['sec_name']."</option>";
							}
						}
					?>
				</select>
				&nbsp;&nbsp;
				<input type="submit" name="show" id="show" value="Get Data" class="btn btn-success">
			</form>
			<br>
			<?php
				if (isset($_POST['show']))
				{
					$url2 = getFullURLLevel($_GET['r'],'bundle_report.php',0,'N');
					$selected_date = $_POST['selected_date'];
					$selected_hour = $_POST['selected_hour'];
					$selected_section = $_POST['selected_section'];

					if ($selected_section == 'all')
					{
						$sec_add_variable_sec_master = "";
					}
					else
					{
						$sec_add_variable_sec_master = " where sec_name = '$selected_section'";
					}

					$time_display_sah = array();	$plan_sah = array();	$act_sah = array();
					$plant_timings_query_sah="SELECT * FROM $bai_pro3.tbl_plant_timings";
					// echo $plant_timings_query_sah;
					$plant_timings_result=mysqli_query($link,$plant_timings_query_sah);
					while ($timing = mysqli_fetch_array($plant_timings_result))
					{
						$time_display_sah[] = $timing['time_display'].' '.$timing['day_part'];
						$plan_sah_qry="SELECT round(SUM(plan_sah)/SUM(act_hours)) as plan_sah FROM $bai_pro.pro_plan WHERE DATE='$selected_date'";
						// echo $plan_sah_qry;
						$plan_sah_result=mysqli_query($link,$plan_sah_qry);
						while ($plan_row = mysqli_fetch_array($plan_sah_result))
						{
							$plan_sah[] = $plan_row['plan_sah'];
						}

						$act_sah_qry="SELECT SUM((bac_Qty*smv)/60) AS SAH FROM $bai_pro.bai_log WHERE bac_date='$selected_date' and TIME(bac_lastup) BETWEEN '".$timing['start_time']."' AND '".$timing['end_time']."'";
						// echo $act_sah_qry.';<br>';
						$act_sah_result=mysqli_query($link,$act_sah_qry);
						while ($act_row = mysqli_fetch_array($act_sah_result))
						{
							$act_sah[] = $act_row['SAH'];
						}
					}
					$x_axis_display="'".implode("','",$time_display_sah)."'";

					
					$y_axis_plan_display="".implode(",",$plan_sah)."";
					$y_axis_act_display="".implode(",",$act_sah)."";


					// echo $selected_date.' == '.$selected_hour.' == '.$selected_section.'<br><br>';
					$plant_timings_query="SELECT * FROM $bai_pro3.tbl_plant_timings where time_value = '$selected_hour'";
					// echo $plant_timings_query;
					$plant_timings_result11=mysqli_query($link,$plant_timings_query);
					while ($row = mysqli_fetch_array($plant_timings_result11))
					{
						$start_time = $row['start_time'];
						$end_time = $row['end_time'];
						$time_display = $row['time_display'].' '.$row['day_part'];
					}
					echo '
					<div class="panel panel-primary">
						<div class="panel-heading text-center">
							'.$time_display.'  Plan Vs Actual Performance

							<a class=\'btn btn-warning pull-right\' style=\'padding: 1px 16px\' href="'.$url2.'&hour='.$selected_hour.'&date='.$selected_date.'" onclick="return popitup2('.$url2.'&hour='.$selected_hour.'&date='.$selected_date.')" target=\'_blank\'>Click Here for Bundle details</a>
						</div>
						<div class="panel-body">
							<div class="col-md-12">
								<div class="col-md-5" id="mod_performance">
									<div class="panel panel-info">
										<div class="panel-heading text-center">Module Level Performance for '.$time_display.'</div>
										<div class="panel-body">
											<div class="table-responsive">
												<table class="table table-bordered">
													<thead>
														<tr>
														  <th>Team</th>
														  <th>Style</th>
														  <th>Plan Pcs</th>
														  <th>Actual Pcs</th>
														  <th>Variation</th>
														  <th>Acheivement (%)</th>
														</tr>
													</thead>
													<tbody>';
														$section_array = array();	$acheivement_array = array();
														$plan_pcs_fact1 = 0;	$act_pcs_fact1 = 0;	$variation_fact =0;	$acheivement_fact = 0;
														$section_query = "SELECT DISTINCT sec_name, section_display_name FROM $bai_pro3.`sections_master` $sec_add_variable_sec_master order by sec_name*1";
														$section_result=mysqli_query($link,$section_query);
														while($Sec=mysqli_fetch_array($section_result))
														{
															$plan_pcs_tot = 0;	$act_pcs_tot = 0;	$variation_tot =0;	$acheivement_tot = 0;
															$section = $Sec['sec_name'];
															$section_display_name = $Sec['section_display_name'];
															$section_array[] = $Sec['section_display_name'];
															$sql="SELECT module_name FROM $bai_pro3.`module_master` WHERE section='".$section."' ORDER BY module_name*1;";
															// echo $sql.'<br>';
															$res=mysqli_query($link,$sql);
															if (mysqli_num_rows($res) > 0) 
															{
																while($row=mysqli_fetch_array($res))
																{
																	$team = $row['module_name'];
																	$bai_log_qry="SELECT GROUP_CONCAT(DISTINCT bac_style) as bac_style, SUM(bac_Qty) as qty FROM $bai_pro.bai_log WHERE bac_sec='$section' AND bac_no='$team' AND bac_date='$selected_date' AND TIME(bac_lastup) BETWEEN '$start_time' AND '$end_time'";
																	// echo $bai_log_qry.';<br>';
																	$bai_log_result=mysqli_query($link,$bai_log_qry);
																	while($res1=mysqli_fetch_array($bai_log_result))
																	{
																		$style = $res1['bac_style'];
																		$act_pcs = $res1['qty'];
																	}
																	$plan_pcs_qry="SELECT round(SUM(plan_pro)/SUM(act_hours)) as PlanPcs FROM bai_pro.pro_plan WHERE DATE='$selected_date' and sec_no='$section' and mod_no='$team'";
																	// echo $plan_pcs_qry.';<br>';
																	$plan_pcs_result=mysqli_query($link,$plan_pcs_qry);
																	while($res12=mysqli_fetch_array($plan_pcs_result))
																	{
																		$plan_pcs = $res12['PlanPcs'];
																	}
																	if ($style == '' || $style == null) {	$style = ' - ';	}
																	if ($plan_pcs == '' || $plan_pcs == null) {	$plan_pcs = 0;	}
																	if ($act_pcs == '' || $act_pcs == null) {	$act_pcs = 0;	}
																	$variation=$act_pcs-$plan_pcs;
																	$acheivement = round($act_pcs*100/div_by_zero($plan_pcs),0);
																	echo "<tr>
																			<td>$team</td>
																			<td>$style</td>
																			<td>$plan_pcs</td>
																			<td>$act_pcs</td>
																			<td>$variation</td>
																			<td>$acheivement%</td>
																		</tr>";
																	$plan_pcs_tot = $plan_pcs_tot+$plan_pcs;
																	$act_pcs_tot = $act_pcs_tot+$act_pcs;
																}
															}
															$variation_tot=$act_pcs_tot-$plan_pcs_tot;
															$acheivement_tot = round($act_pcs_tot*100/div_by_zero($plan_pcs_tot),0);
															echo "<tr style=\"background-color:lightgreen;font-weight: bold; border-bottom:2px solid black; border-top:2px solid black;\">
																	<td colspan=2>$section_display_name</td>
																	<td>$plan_pcs_tot</td>
																	<td>$act_pcs_tot</td>
																	<td>$variation_tot</td>
																	<td>$acheivement_tot%</td>
																</tr>";
															$acheivement_array[] = $acheivement_tot;
														}
														$section_array[] = 'Factory';
														$bai_log_qry="SELECT SUM(bac_Qty) as qty FROM $bai_pro.bai_log WHERE bac_date='$selected_date'  AND TIME(bac_lastup) BETWEEN '$start_time' AND '$end_time'";
														// echo $bai_log_qry.';<br>';
														$bai_log_result=mysqli_query($link,$bai_log_qry);
														while($res1=mysqli_fetch_array($bai_log_result))
														{
															$act_pcs_fact1 = $res1['qty'];
														}
														$plan_pcs_qry="SELECT round(SUM(plan_pro)/SUM(act_hours)) as PlanPcs FROM bai_pro.pro_plan WHERE DATE='$selected_date'";
														// echo $plan_pcs_qry.';<br>';
														$plan_pcs_result=mysqli_query($link,$plan_pcs_qry);
														while($res12=mysqli_fetch_array($plan_pcs_result))
														{
															$plan_pcs_fact1 = $res12['PlanPcs'];
														}
														$variation_fact=$act_pcs_fact1-$plan_pcs_fact1;
														$acheivement_fact = round($act_pcs_fact1*100/div_by_zero($plan_pcs_fact1),0);
														echo "<tr style=\"background-color:green;color:white;font-weight: bold; border-bottom:2px solid black; border-top:2px solid black;\">
																	<td colspan=2>Total</td>
																	<td>$plan_pcs_fact1</td>
																	<td>$act_pcs_fact1</td>
																	<td>$variation_fact</td>
																	<td>$acheivement_fact%</td>
																</tr>";
														$acheivement_array[] = $acheivement_fact;
														$buyer_name_ref_implode="'".implode("','",$section_array)."'";
														$acheivement_per_implode="".implode(",",$acheivement_array)."";
													echo '</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-7">
									<div class="panel panel-info">
										<div class="panel-heading text-center">Hourly Production Graph for '.$time_display.'</div>
										<div class="panel-body">
											<div id = "container" style = "width: auto; height: 400px; margin: 0 auto"></div>';
												echo"<script language = \"JavaScript\">
											         $(document).ready(function() {  
											            var chart = {
											               type: 'column'
											            };
											            var title = {
											               text: '".$time_display."'
											            };
											            var xAxis = {
											               categories: [".$buyer_name_ref_implode."],
											               title: {
											                  text: null
											               }
											            };
											            var yAxis = {
											               min: 0,
											               title: {
											                  text: 'Acheivement (%)',
											                  align: 'high'
											               },
											               labels: {
											                  overflow: 'justify'
											               }
											            };
											            var tooltip = {
											               valueSuffix: ' %'
											            };
											            var plotOptions = {
											               bar: {
											                  dataLabels: {
											                     enabled: true
											                  }
											               }
											            };
											            var credits = {
											               enabled: false
											            };
											            var series = [ 
											               {
											               	  name: 'Achievement',
											                  data: [".$acheivement_per_implode."]      
											               }
											            ];
											      
											            var json = {};   
											            json.chart = chart; 
											            json.title = title;
											            json.tooltip = tooltip;
											            json.xAxis = xAxis;
											            json.yAxis = yAxis;  
											            json.series = series;
											            json.plotOptions = plotOptions;
											            json.credits = credits;
											            $('#container').highcharts(json);
											         });
											      </script>";
										echo '</div>
									</div>
								</div>
								<div class="col-md-7">
									<div class="panel panel-info">
										<div class="panel-heading text-center">Day Performance for '.$selected_date.'</div>
										<div class="panel-body">
											<div class="table-responsive"  id="day_report_table" style="overflow-y: auto; margin: 0 auto">
												<table class="table table-bordered">
													<thead>
														<tr>
														  <th>Team</th>
														  <th>Style</th>
														  <th>Plan Pcs</th>
														  <th>Actual Pcs</th>
														  <th>Variation</th>
														  <th>Acheivement (%)</th>
														</tr>
													</thead>
													<tbody>';
														$plan_pcs_fact2 = 0;	$act_pcs_fact2 = 0;	$variation_fact =0;	$acheivement_fact = 0;
														$section_query = "SELECT DISTINCT sec_name, section_display_name FROM $bai_pro3.`sections_master` $sec_add_variable_sec_master order by sec_name*1";
														$section_result=mysqli_query($link,$section_query);
														while($Sec=mysqli_fetch_array($section_result))
														{
															$plan_pcs_tot = 0;	$act_pcs_tot = 0;	$variation_tot =0;	$acheivement_tot = 0;
															$section = $Sec['sec_name'];
															$section_display_name = $Sec['section_display_name'];
															$sql="SELECT module_name FROM $bai_pro3.`module_master` WHERE section='".$section."' ORDER BY module_name*1;";
															// echo $sql.'<br>';
															$res=mysqli_query($link,$sql);
															if (mysqli_num_rows($res) > 0) 
															{
																while($row=mysqli_fetch_array($res))
																{
																	$team = $row['module_name'];
																	$bai_log_qry="SELECT GROUP_CONCAT(DISTINCT bac_style) as bac_style, SUM(bac_Qty) as qty FROM $bai_pro.bai_log WHERE bac_sec='$section' AND bac_no='$team' AND bac_date='$selected_date'";
																	// echo $bai_log_qry.';<br>';
																	$bai_log_result=mysqli_query($link,$bai_log_qry);
																	while($res1=mysqli_fetch_array($bai_log_result))
																	{
																		$style = $res1['bac_style'];
																		$act_pcs = $res1['qty'];
																	}
																	$plan_pcs_qry="SELECT round(SUM(plan_pro)/SUM(act_hours)) as PlanPcs FROM bai_pro.pro_plan WHERE DATE='$selected_date' and sec_no='$section' and mod_no='$team'";
																	// echo $plan_pcs_qry.';<br>';
																	$plan_pcs_result=mysqli_query($link,$plan_pcs_qry);
																	while($res12=mysqli_fetch_array($plan_pcs_result))
																	{
																		$plan_pcs = $res12['PlanPcs'];
																	}
																	if ($style == '' || $style == null) {	$style = ' - ';	}
																	if ($plan_pcs == '' || $plan_pcs == null) {	$plan_pcs = 0;	}
																	if ($act_pcs == '' || $act_pcs == null) {	$act_pcs = 0;	}
																	$variation=$act_pcs-$plan_pcs;
																	$acheivement = round($act_pcs*100/div_by_zero($plan_pcs),0);
																	echo "<tr>
																			<td>$team</td>
																			<td>$style</td>
																			<td>$plan_pcs</td>
																			<td>$act_pcs</td>
																			<td>$variation</td>
																			<td>$acheivement%</td>
																		</tr>";
																	$plan_pcs_tot = $plan_pcs_tot+$plan_pcs;
																	$act_pcs_tot = $act_pcs_tot+$act_pcs;
																}
															}
															$variation_tot=$act_pcs_tot-$plan_pcs_tot;
															$acheivement_tot = round($act_pcs_tot*100/div_by_zero($plan_pcs_tot),0);
															echo "<tr style=\"background-color:lightgreen;font-weight: bold; border-bottom:2px solid black; border-top:2px solid black;\">
																	<td colspan=2>$section_display_name</td>
																	<td>$plan_pcs_tot</td>
																	<td>$act_pcs_tot</td>
																	<td>$variation_tot</td>
																	<td>$acheivement_tot%</td>
																</tr>";
														}

														$bai_log_qry="SELECT SUM(bac_Qty) as qty FROM $bai_pro.bai_log WHERE bac_date='$selected_date'";
														// echo $bai_log_qry.';<br>';
														$bai_log_result=mysqli_query($link,$bai_log_qry);
														while($res1=mysqli_fetch_array($bai_log_result))
														{
															$act_pcs_fact2 = $res1['qty'];
														}
														$plan_pcs_qry="SELECT round(SUM(plan_pro)/SUM(act_hours)) as PlanPcs FROM bai_pro.pro_plan WHERE DATE='$selected_date'";
														// echo $plan_pcs_qry.';<br>';
														$plan_pcs_result=mysqli_query($link,$plan_pcs_qry);
														while($res12=mysqli_fetch_array($plan_pcs_result))
														{
															$plan_pcs_fact2 = $res12['PlanPcs'];
														}
														$variation_fact=$act_pcs_fact2-$plan_pcs_fact2;
														$acheivement_fact = round($act_pcs_fact2*100/div_by_zero($plan_pcs_fact2),0);
														echo "<tr style=\"background-color:green;color:white;font-weight: bold; border-bottom:2px solid black; border-top:2px solid black;\">
																	<td colspan=2>Total</td>
																	<td>$plan_pcs_fact2</td>
																	<td>$act_pcs_fact2</td>
																	<td>$variation_fact</td>
																	<td>$acheivement_fact%</td>
																</tr>";
													echo '</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-12">
								<div class="panel panel-info">
									<div class="panel-heading text-center">Hourly Plan Vs Actual SAH for '.$selected_date.'</div>
											<div class="panel-body">
												<div id = "sah_container" style = "height: 400px; width:auto;"></div>';
												echo"<script language = \"JavaScript\">
												         $(document).ready(function() {
												            var title = {
												               text: '".$selected_date."'   
												            };
												            var xAxis = {
												               categories: [".$x_axis_display."],
												               title: {
												                  text: 'Hours'
												               }
												            };
												            var yAxis = {
												               title: {
												                  text: 'SAH'
												               },
												               plotLines: [{
												                  value: 0,
												                  width: 1,
												                  color: '#808080'
												               }]
												            };   
												            var tooltip = {
												               valueSuffix: ''
												            }
												            var legend = {
												               layout: 'vertical',
												               align: 'right',
												               verticalAlign: 'middle',
												               borderWidth: 0
												            };
												            var credits = {
												               enabled: false
												            };
												            var series =  [{
												                  name: 'Plan SAH',
												                  data: [".$y_axis_plan_display."]
												               },
												               {
												                  name: 'Actual SAH',
												                  data: [".$y_axis_act_display."]
												               }, 
												               
												            ];

												            var json = {};
												            json.title = title;
												            json.xAxis = xAxis;
												            json.yAxis = yAxis;
												            json.tooltip = tooltip;
												            json.legend = legend;
												            json.credits = credits;
												            json.series = series;
												            
												            $('#sah_container').highcharts(json);
												         });
												      </script>";
									echo '</div>
								</div>
							</div>
						</div>
					</div>';
				}
			?>
		</div>
	</div>

	<script type="text/javascript">
		var myDiv = document.getElementById('mod_performance');
		var mod_performance_height =  myDiv.clientHeight;
		var temp = mod_performance_height-583;
		document.getElementById("day_report_table").style.height = temp+'px';
	</script>