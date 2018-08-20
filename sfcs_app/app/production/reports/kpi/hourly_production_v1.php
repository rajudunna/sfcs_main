<?php ini_set('max_execution_time', 360); 
// error_reporting(E_WARNING);
?>
<!DOCTYPE html>
<?php
	//load the database configuration file
	include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
?>
<body>

<?php   
	//Starting get process for hourly efficiency report through FR Plan.
	
	if($_GET['pro_date'])
	{
		$frdate=$_GET['pro_date'];
		$ntime=18;	
	}else{
		$frdate=date("Y-m-d");
		$ntime=date('H');
	}
?>
<div class="panel panel-primary">
<div class="panel-heading">Hourly Production Report- Section Wise <?php  echo $frdate;  ?></div>
<div class="panel-body">
	<form action='index.php' method='GET'>
		<input type='hidden' name='r' value='<?= $_GET["r"]; ?>'>
		<br>
		<div class="col-sm-3">
		<label>Date :</label>
		<input type='text' data-toggle="datepicker" class="form-control" value='<?php echo $frdate;  ?>' name='pro_date' id='pro_date' readonly>
		</div><br/>
		<div class="col-sm-1">
		<input type='submit' class="btn btn-primary" value='Filter' name='submit'>
		</div>
	</form>
  <hr>
   
   <?php
if(isset($_GET['submit']))
{
	$total_hours = $plant_end_time - $plant_start_time;
	list($hour, $minutes, $seconds) = explode(':', $plant_start_time);

   	// $sql="SELECT * FROM $bai_pro2.fr_data where frdate='$frdate' GROUP BY team ORDER BY team*1";
	// // echo $sql;
	// $res=mysqli_query($link,$sql);	
   	?>
 
    <div class="table-area">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr style="background:#6995d6;color:white;">
					  <th>Team</th>
					  <th>NOP</th>
					  <th>Style</th>
					  <th style='display:none;'>Sch</th>
					  <th>FR Plan</th>
					  <th>Forecast</th>
					  <th>SMV</th>
					  <th>Hours</th>
					  <th>Target <br>PCS/Hr</th>
					  <?php 
							$query='';
							$hours_array = array();
						   	for ($i=0; $i < $total_hours; $i++)
							{
								$hours_array[] = $hour;
								$hour1=$hour++ + 1;
								$to_hour = $hour1.":00";
								echo "<th>$to_hour</th>";
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
					  <th>Balance Pcs</th>
					  <th>Hit rate</th>
					  <th>Request Pcs/Hr</th>
					</tr>
				</thead>
	    
				<?php 
				$section_query = "SELECT DISTINCT(section_id) FROM $bai_pro3.`plan_modules`";
				$section_result=mysqli_query($link,$section_query);
				while($Sec=mysqli_fetch_array($section_result))
				{
					$sec_tot_fr_qty = 0; $sec_tot_forecast_qty=0; $sec_tot_total_qty=0; $sec_tot_scanned_qty=0; 
					$sec_tot_scanned_sah=0; $sec_tot_forecast_sah=0; $sec_tot_act_sah=0; $sec_tot_sah_diff=0;
					$sec_tot_plan_eff=0; $sec_tot_act_eff=0; $sec_tot_hitrate=0; $sec_tot_required=0; $module_count=0;
					$section = $Sec['section_id'];
					// $sql="SELECT * FROM $bai_pro2.fr_data where frdate='$frdate' GROUP BY team ORDER BY team*1";
					$sql="SELECT fr_data.*, plan_modules.section_id FROM $bai_pro2.fr_data  LEFT JOIN $bai_pro3.`plan_modules` ON fr_data.`team` = plan_modules. module_id WHERE fr_data.frdate='$frdate' AND plan_modules.section_id='$section' GROUP BY fr_data.team ORDER BY fr_data.team*1;";
					// echo $sql.'<br>';
					$res=mysqli_query($link,$sql);
					if (mysqli_num_rows($res) > 0) 
					{
						while($row=mysqli_fetch_array($res))
						{ 
							$total_qty = 0;
							$module_count++;
							// echo $frdate;
						    $date=$row['frdate'];
							// echo $date;
							$newDate = date("Y-m-d", strtotime($date));
							// echo $newDate.'<br>';
							$team=$row['team'];
							
							//get styles which run in lines
							$sql1="SELECT distinct style FROM $bai_pro2.fr_data where frdate='$frdate' AND team='$team'";
							$res1=mysqli_query($link,$sql1);
							
							$sql2="SELECT distinct schedule FROM $bai_pro2.fr_data where frdate='$frdate' AND team='$team'";
							$res2=mysqli_query($link,$sql2);
							
							$sql3="SELECT SUM(fr_qty) AS sumfrqty FROM $bai_pro2.fr_data where frdate='$frdate' AND team='$team'";
							$res3=mysqli_query($link,$sql3);
							
							$sql4="SELECT qty FROM $bai_pro3.line_forecast where date='$frdate' AND module='$team'";
							$res4=mysqli_query($link,$sql4);
							
							$sql5="SELECT AVG(smv) AS smv FROM $bai_pro2.fr_data where frdate='$frdate' AND team='$team'";
							$res5=mysqli_query($link,$sql5);

							$sqlsc="SELECT SUM(bac_Qty) AS sumqty FROM $bai_pro.bai_log where bac_no='$team' AND bac_date='$frdate'";
							// echo $sqlsc;
							$resc=mysqli_query($link,$sqlsc);
							if($rowc=mysqli_fetch_array($resc))
							{
								$sumscqty=$rowc['sumqty'];
							}
							else
							{
								$sumcty="";
							}
							$nop='24';
							?>

					  
							<tbody>
								<tr>
									<td><?php  echo $team;  ?></td>
									<td><?php  echo $nop;  ?></td>
									<td>
										<?php 
											while($row1=mysqli_fetch_array($res1))
											{
												echo $row1['style'].'<br>';
											}
										?>
									</td>
									<td style='display:none;'>	
										<?php 
											while($row2=mysqli_fetch_array($res2))
											{
												echo $row2['schedule'].'<br>';
											}
										?>
									</td>
									<td>
										<?php 
											while($row3=mysqli_fetch_array($res3))
											{
												$frqty=$row3['sumfrqty'];
												echo $row3['sumfrqty'].'<br>';
												$sec_tot_fr_qty = $sec_tot_fr_qty + $frqty;
											}
										?>
									</td>
									<td>
										<?php 
											while($row4=mysqli_fetch_array($res4))
											{
												$forecastqty=$row4['qty'];
												echo $row4['qty'].'<br>';
												$sec_tot_forecast_qty = $sec_tot_forecast_qty + $forecastqty;
											}
										?>
									</td>
									<td>
										<?php
											while($row5=mysqli_fetch_array($res5))
											{
												$smv=round($row5['smv'],2);
												echo round($row5['smv'],2).'<br>';
											}
										?>
									</td>
									<td>
										<?php 
											$hours=$row['hours'];
											echo $row['hours'];  
										?>
									</td>
									<td style="background-color:#e1bee7;">
										<?php  
											$pcsphr=$forecastqty/10;
											echo round($pcsphr);
										?>
									</td>
									<?php
										for ($i=0; $i < sizeof($hours_array); $i++)
										{
											// echo $hours_array[$i].'<br>';
											$hour_iniate = $hours_array[$i];
											$sql6_1="SELECT qty FROM `bai_pro2`.hout WHERE out_date='$frdate' AND team='$team' AND (TIME(out_time) BETWEEN TIME('".$hour_iniate.":00') AND TIME('".$hour_iniate.":59'));";
											// echo $sql6_1.'<br><br>';
											$res6_1=mysqli_query($link,$sql6_1);
											if (mysqli_num_rows($res6_1) > 0)
											{
												while($row6_1=mysqli_fetch_array($res6_1))
												{
													$row = $row6_1['qty'];
													if ($row >= round($pcsphr))
													{
														$total_qty = $total_qty + $row;
														echo "<td>".$row."</td>";
													} 
													else if ($row < round($pcsphr))
													{
														$sql6_2="SELECT * FROM `bai_pro2`.`hourly_downtime` WHERE DATE='$frdate' AND dhour = '$hour_iniate' AND team='$team';";
														// echo $sql6_2.'<br><br>';
														$res6_12=mysqli_query($link,$sql6_2);
														if (mysqli_num_rows($res6_12) > 0)
														{
															$total_qty = $total_qty + $row;
															echo "<td>".$row."</td>";
														}
														else
														{
															echo "<td><a class='btn btn-danger'><i class='fa fa-exclamation-circle' aria-hidden='true'></i></a></td>";
														}
													}
												}
											}
											else
											{
												$total_qty = $total_qty + 0;
												echo "<td> - </td>";
											}				
										}
									?>
									<td style="background-color:#d7ccc8;">
										<b>
										<?php  
											echo $total_qty; 
											$sec_tot_total_qty = $sec_tot_total_qty + $total_qty;
										?>
										</b>
									</td>
									<td style="background-color:#d7ccc8;">
										<b><?php  
											echo $sumscqty; 
											$sec_tot_scanned_qty = $sec_tot_scanned_qty + $sumscqty;
										?>
										</b>
									</td>
									<td style="background-color:#d7ccc8;">
										<b><?php  
											$scanned_sah=round(($sumscqty*$smv)/60);
											echo $scanned_sah; 
											$sec_tot_scanned_sah = $sec_tot_scanned_sah + $scanned_sah; 
										?></b>
									</td>
									<td>
										<?php 
											$plan_sah=round(($frqty*$smv)/60); 
											echo $plan_sah; 
											$sec_tot_plan_sah = $sec_tot_plan_sah + $plan_sah;
										?>
									</td>
									<td>
										<?php
											$forecast_sah=round(($forecastqty*$smv)/60);
											echo $forecast_sah;	
											$sec_tot_forecast_sah = $sec_tot_forecast_sah + $forecast_sah;
										?>
									</td>
									<td>
										<?php  
											$act_sah=round(($total_qty*$smv)/60);
											echo $act_sah;
											$sec_tot_act_sah = $sec_tot_act_sah + $act_sah;
										?>
									</td>
									<td>
										<?php
											$sah_diff=$plan_sah-$act_sah;
											echo $sah_diff;
											$sec_tot_sah_diff = $sec_tot_sah_diff + $sah_diff;
										?>
									</td>
									<td>
										<?php
											$plan_eff=round((($forecastqty*$smv)/($nop*$hours*60))*100);
											echo $plan_eff.'%';
											$sec_tot_plan_eff = $sec_tot_plan_eff+ $plan_eff;
										?>
									</td>
									<td>
										<?php
											$act_eff_hour=$ntime-8;
											if($act_eff_hour<=0)
											{
												$act_eff=round((($total_qty*$smv)/($nop*60))*100);
											}
											else
											{
												$act_eff=round((($total_qty*$smv)/($nop*$act_eff_hour*60))*100);
											}
											echo $act_eff.'%';
											$sec_tot_act_eff = $sec_tot_act_eff + $act_eff;
										?>
									</td>
									<td style="display:none;"></td>
									<td>
										<?php
											$balance=$forecastqty-$total_qty;
											echo $balance;
											$sec_tot_balance = $sec_tot_balance + $balance;
										?>
									</td>
									<td>
										<?php
											if($forecastqty !=0)
											{
												$hitrate=round(($total_qty/$forecastqty)*100);
											}
											else
											{
												$hitrate=0;
											}
											echo $hitrate.'%';
											$sec_tot_hitrate = $sec_tot_hitrate + $hitrate;
										?>
									</td>
									<td>
										<?php
											$noh=18-$ntime;
											if($noh!=0)
											{
												$required=($balance)/$noh;
											}
											else
											{
												$required=($balance)/1;
											}
											echo round($required);
											$sec_tot_required = $sec_tot_required + round($required);
										?>
									</td>
									<?php
										$out=0;  
										$i++;
									?>
								</tr>
									<?php
						}
							?>
							<tr style="background-color:lightgreen;font-weight: bold; border-bottom:2px solid black; border-top:2px solid black;">
								<td>Section - <?php  echo $section; ?></td>
								<td></td>
								<td></td>
								<td><?php  echo $sec_tot_fr_qty; ?></td>
								<td><?php  echo $sec_tot_forecast_qty; ?></td>
								<td></td>
								<td></td>
								<td></td>
								<?php
									for ($i=0; $i < sizeof($hours_array); $i++)
									{
										// echo $hours_array[$i].'<br>';
										$hour_iniate = $hours_array[$i];
										$sql6_1="SELECT qty FROM `bai_pro2`.hout WHERE out_date='$frdate' AND team='$team' AND (TIME(out_time) BETWEEN TIME('".$hour_iniate.":00') AND TIME('".$hour_iniate.":59'));";
										// echo $sql6_1.'<br><br>';
										$res6_1=mysqli_query($link,$sql6_1);
										if (mysqli_num_rows($res6_1) > 0)
										{
											while($row6_1=mysqli_fetch_array($res6_1))
											{
												$row = $row6_1['qty'];
												echo "<td>".$row."</td>";
											}
										}
										else
										{
											echo "<td> 0 </td>";
										}				
									}
								?>
								<td><?php echo $sec_tot_total_qty;  ?></td>
								<td><?php echo $sec_tot_scanned_qty;  ?></td>
								<td><?php echo $sec_tot_scanned_sah;  ?></td>
								<td><?php echo $sec_tot_plan_sah;  ?></td>
								<td><?php echo $sec_tot_forecast_sah;  ?></td>
								<td><?php echo $sec_tot_act_sah;  ?></td>
								<td><?php echo $sec_tot_sah_diff;  ?></td>
								<td><?php echo $sec_tot_plan_eff/$module_count.'%';  ?></td>
								<td><?php echo $sec_tot_act_eff/$module_count.'%';  ?></td>
								<td><?php echo $sec_tot_balance;  ?></td>
								<td><?php echo $sec_tot_hitrate/$module_count.'%';  ?></td>
								<td><?php echo $sec_tot_required;  ?></td>
							</tr>
						</tbody>
						<?php
					}
				}
}?>
	      
				
			</table>
		</div>
	</div>
</div>
</div>
