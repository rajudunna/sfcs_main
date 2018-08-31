<?php ini_set('max_execution_time', 360); 
// error_reporting(0);
?>
<!DOCTYPE html>
<?php
//load the database configuration file
//include("..".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions.php");
?>
<html lang="en">
<head>
  <title>Hourly Production Report</title>
  <!-- <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="refresh" content="120" /> -->
  
  </head>
<body>

<div class="container">
				<?php
					$img_url = getFullURLLevel($_GET['r'], 'common/images/sign.jpg', 2, 'R');
					$grand_tot_qty_time_array1 = array();
				   	$plant_modules=array();
					$plant_name=array();

					if($_GET['pro_date'])
					{
						$frdate=$_GET['pro_date'];
						$ntime=18;				   
					}
					else
					{
						$frdate=date("Y-m-d");
						$ntime=date('H');
					}

					$plant_details_query="SELECT * FROM $bai_pro2.tbl_mini_plant_master;";
					$plant_details_result=mysqli_query($link,$plant_details_query);
					while ($row = mysqli_fetch_array($plant_details_result))
					{
						$plant_name[] = $row['plant_name'];
						$plant_modules[] = explode(',', $row['plant_modules']);
					}

					// for ($i=0; $i < sizeof($plant_name); $i++)
					// { 
					// 	echo $plant_name[$i].' == ';
					// 	var_dump($plant_modules[$i]);
					// 	echo '<br><br>';
					// }
					// die();
				?>
<div class="panel panel-primary">
	<div class="panel-heading">Hourly Production Report</div>
	<div class="panel-body">
		<form  action="index.php"  method='GET' class="form-inline">
			<div class='row'>
				<input type="hidden" value="<?= $_GET['r']; ?>" name="r" >
				<label>Date : </label>
				<input type='text' data-toggle="datepicker" value='<?php echo $frdate;  ?>' name='pro_date' class='form-control' readonly>
				<input type='submit' value='Filter' class='btn btn-primary' name='submit'>
			</div>
		</form>
		<hr>
   
<?php
		if(isset($_GET['submit']))
		{
			$plant_timings_query="SELECT * FROM $bai_pro3.tbl_plant_timings";
			// echo $plant_timings_query;
			$plant_timings_result=mysqli_query($link,$plant_timings_query);
			while ($row = mysqli_fetch_array($plant_timings_result))
			{
				$start_time[] = $row['start_time'];
				$end_time[] = $row['end_time'];
				$time_display[] = $row['time_display'].'<br>'.$row['day_part'];
			}
			
			// $total_hours = $plant_end_time - $plant_start_time;
			// list($hour, $minutes, $seconds) = explode(':', $plant_start_time);
			// $minutes_29 = $minutes-1;

			$sql="SELECT * FROM $bai_pro2.fr_data where frdate='$frdate' GROUP BY team ORDER BY team*1";
			// echo $sql.'<br>';
			$res=mysqli_query($link,$sql);
	
			$i=0; ?>
			<section class="content-area">
			<div class='table-responsive'>
			<div class="table-area">
			<table class="table table-bordered">

			<thead>
				<tr style="background:#337ab7;color:white;"> 
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
						for ($i=0; $i < sizeof($time_display); $i++)
						{
							echo "<th><center>$time_display[$i]</center></th>";
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
					<th>Hit rate</th>
					<th style="display:none;">Request Pcs/Hr</th>
				</tr>
			</thead>
			<?php 
				$tot_reported_plantWise=array(); $tot_frqty_plantWise=array(); $tot_forecast_qty_plantWise=array();
				$tot_scanned_plantWise=array(); $tot_scanned_sah_plantWise=array(); $tot_fr_sah_plantWise=array();
				$tot_forecast_sah_plantWise=array(); $tot_act_sah_plantWise=array(); $tot_sah_diff_plantWise=array();
				$tot_plan_eff_plantWise=array(); $tot_act_eff_plantWise=array(); $tot_balance_plantWise=array();
				$tot_hit_rate_plantWise=array();	$grand_tot_qty_time_array1 = array(); 
			
			while($row=mysqli_fetch_array($res))
			{
				$module_count++;

				$total_qty = 0;

				// echo $frdate;
				$date=$row['frdate'];
				//echo $date;
				$newDate = date("Y-m-d", strtotime($date));
				//echo $newDate.'<br>';
				$team=$row['team'];
				// echo $team;
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

				// $sql6="SELECT out_time,qty,status FROM $bai_pro2.hout where out_date='$frdate' AND team='$team'";
				// $res6=mysqli_query($link,$sql6);
				
				// $sql6="SELECT $query remarks FROM $bai_pro2.hout where out_date='$frdate' AND team='$team'";
				// echo $sql6.'<br><br>';
				// $res6=mysqli_query($link,$sql6);

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
					<td><center><?php  echo $team;  ?></center></td>
					<td><center><?php  echo $nop;  ?></center></td>
					<td><center>
						<?php 
							while($row1=mysqli_fetch_array($res1))
							{
								echo $row1['style'].'<br>';
							}
						?>
					</center></td>
					<td style='display:none;'>	
						<?php 
							while($row2=mysqli_fetch_array($res2))
							{
								echo $row2['schedule'].'<br>';
							}
						?>
					</center></td>
					<td><center>
						<?php 
							while($row3=mysqli_fetch_array($res3))
							{
								$frqty=$row3['sumfrqty'];
								echo $row3['sumfrqty'].'<br>';
								for ($i=0; $i < sizeof($plant_name); $i++) 
								{
									if (in_array($team, $plant_modules[$i]))
									{
										$tot_frqty_plantWise[$i] = $tot_frqty_plantWise[$i] + $frqty;
									}							 	
								}
							}
						?>
					</center></td>
					<td><center>
						<?php 
							while($row4=mysqli_fetch_array($res4))
							{
								$forecastqty=$row4['qty'];
								echo $row4['qty'].'<br>';
								for ($i=0; $i < sizeof($plant_name); $i++) 
								{
									if (in_array($team, $plant_modules[$i]))
									{
										$tot_forecast_qty_plantWise[$i] = $tot_forecast_qty_plantWise[$i] + $forecastqty;
									}							 	
								}
							}
						?>
					</center></td>
					<td><center>
						<?php
							while($row5=mysqli_fetch_array($res5))
							{
								$smv=round($row5['smv'],2);
								echo round($row5['smv'],2).'<br>';
							}
						?>
					</center></td>
					<td><center>
						<?php 
							$hours=$row['hours'];
							echo $row['hours'];  
						?>
					</center></td>
					<td style="background-color:#e1bee7;"><center>
						<?php  
							$pcsphr=$forecastqty/$hours;
							echo round($pcsphr);
						?>
					</center></td>
					<?php
						for ($i=0; $i < sizeof($time_display); $i++)
						{
							// $row=echo_title("$bai_pro2.hout","SUM(qty)","team='$team' AND (TIME(out_time) BETWEEN TIME('".$start_time[$i]."') AND TIME('".$end_time[$i]."')) and out_date",$frdate,$link);
							$row=echo_title("$bai_pro2.hout","SUM(qty)","out_date='$frdate' AND rep_start_time = TIME('".$start_time[$i]."') AND rep_end_time = TIME('".$end_time[$i]."') and team",$team,$link);

							if ($row == '' || $row == NULL )
							{
								$row=0;
							}
							
							if (round($pcsphr) == 0)
							{
								if ($row > 0)
								{
									echo "<td><center>".$row."</center></td>";
								}
								else
								{
									echo "<td><center>  </center></td>";
								}
							}
							else if ($row >= round($pcsphr))
							{
								$total_qty = $total_qty + $row;
								for ($k=0; $k < sizeof($plant_name); $k++) 
								{
								// echo $total_qty.'-'.$i.'- '.$k.'- '.$row.'<br/>';
									if (in_array($team, $plant_modules[$k]))
									{
										$grand_tot_qty_time_array1[$plant_name[$k]][$i] = $grand_tot_qty_time_array1[$plant_name[$k]][$i] + $row;
									}
								}		
								echo "<td><center>".$row."</center></td>";

							} 
							else if ($row < round($pcsphr))
							{
								if ($row == 0)
								{									
									$sql6_2="SELECT * FROM `bai_pro2`.`hourly_downtime` WHERE DATE='$frdate' AND time BETWEEN TIME('".$start_time[$i]."') AND TIME('".$end_time[$i]."') AND team='$team';";
									// echo $sql6_2.'<br><br>';
									$res6_12=mysqli_query($link,$sql6_2);
									if (mysqli_num_rows($res6_12) > 0)
									{
										echo "<td><center> 0 </center></td>";
									}
									else
									{
										if (($start_time[$i] > date('H') and $frdate == date('Y-m-d')))
										{
											echo "<td><center> - </center></td>";
										}
										else
										{
											echo "<td><center>  </center></td>";
										}
									}
								}
								else
								{
									$sql6_2="SELECT * FROM `bai_pro2`.`hourly_downtime` WHERE DATE='$frdate' AND time BETWEEN TIME('".$start_time[$i]."') AND TIME('".$end_time[$i]."') AND team='$team';";
									// echo $sql6_2.'<br><br>';
									$res6_12=mysqli_query($link,$sql6_2);
									if (mysqli_num_rows($res6_12) > 0)
									{
										$total_qty = $total_qty + $row;
										for ($k=0; $k < sizeof($plant_name); $k++) 
										{
											if (in_array($team, $plant_modules[$k]))
											{
												$grand_tot_qty_time_array1[$plant_name[$k]][$i] = $grand_tot_qty_time_array1[$plant_name[$k]][$i] + $row;
											}
										}												
										echo "<td style='background-color:#dd3636; color:white;'><center>".$row."</center></td>";
									}
									else
									{
										echo "<td><img src='$img_url' alt=\"Update Downtime\" height=\"42\" width=\"42\"></td>";
									}
								}
							}
						}
					?>
					<td style="background-color:#d7ccc8;"><center>
						<b>
						<?php  
							echo $total_qty;
							for ($i=0; $i < sizeof($plant_name); $i++) 
							{
								if (in_array($team, $plant_modules[$i]))
								{
									$tot_reported_plantWise[$i] = $tot_reported_plantWise[$i] + $total_qty;
								}
							} 
						?>
						</b>
					</center></td>
					<td style="background-color:#d7ccc8;"><center>
						<b>
						<?php  
							echo $sumscqty;
							for ($i=0; $i < sizeof($plant_name); $i++) 
							{
								if (in_array($team, $plant_modules[$i]))
								{
									$tot_scanned_plantWise[$i] = $tot_scanned_plantWise[$i] + $sumscqty;
								}							 	
							}
						?>
						</b>
					</center></td>
					<td style="background-color:#d7ccc8;"><center>
						<b>
						<?php 
							$scanned_sah=round(($sumscqty*$smv)/60);
							echo $scanned_sah;
							for ($i=0; $i < sizeof($plant_name); $i++) 
							{
								if (in_array($team, $plant_modules[$i]))
								{
									$tot_scanned_sah_plantWise[$i] = $tot_scanned_sah_plantWise[$i] + $scanned_sah;
								}							 	
							}
						?>
						</b>
					</center></td>
					<td><center>
						<?php 
							$plan_sah=round(($frqty*$smv)/60); 
							echo $plan_sah;
							for ($i=0; $i < sizeof($plant_name); $i++) 
							{
								if (in_array($team, $plant_modules[$i]))
								{
									$tot_fr_sah_plantWise[$i] = $tot_fr_sah_plantWise[$i] + $plan_sah;
								}							 	
							}	
						?>
					</center></td>
					<td><center>
						<?php
							$forecast_sah=round(($forecastqty*$smv)/60);
							echo $forecast_sah;
							for ($i=0; $i < sizeof($plant_name); $i++) 
							{
								if (in_array($team, $plant_modules[$i]))
								{
									$tot_forecast_sah_plantWise[$i] = $tot_forecast_sah_plantWise[$i] + $forecast_sah;
								}							 	
							}
						?>
					</center></td>
					<td><center>
						<?php  
							$act_sah=round(($total_qty*$smv)/60);
							echo $act_sah;
							for ($i=0; $i < sizeof($plant_name); $i++) 
							{
								if (in_array($team, $plant_modules[$i]))
								{
									$tot_act_sah_plantWise[$i] = $tot_act_sah_plantWise[$i] + $act_sah;
								}							 	
							}
						?>
					</center></td>
					<td><center>
						<?php
							$sah_diff=$plan_sah-$act_sah;
							echo $sah_diff;
							for ($i=0; $i < sizeof($plant_name); $i++) 
							{
								if (in_array($team, $plant_modules[$i]))
								{
									$tot_sah_diff_plantWise[$i] = $tot_sah_diff_plantWise[$i] + $sah_diff;
								}							 	
							}
						?>
					</center></td>
					<td><center>
						<?php
							if ($nop >0 && $hours >0) {
								$plan_eff=round((($frqty*$smv)/($nop*$hours*60))*100);
							} else {
								$plan_eff=0;
							}
							
							echo $plan_eff.'%';
						?>
					</center></td>
					<td><center>
						<?php
							if ($nop >0 && $hours >0) {
								$act_eff=round((($total_qty*$smv)/($nop*$hours*60))*100);
							} else {
								$act_eff=0;
							}
							
							echo $act_eff.'%';
						?>
					</center></td>
					<td style="display:none;"></center></td>
					<td><center>
						<?php
							$balance=$forecastqty-$total_qty;
							echo $balance;
						?>
					</center></td>
					<td><center>
						<?php
						if($forecastqty > 0)
						{
							$hitrate=round(($total_qty/$forecastqty)*100);
						}
						else
						{
							$hitrate=0;
						}
						echo $hitrate.'%';
						for ($i=0; $i < sizeof($plant_name); $i++) 
						{
							if (in_array($team, $plant_modules[$i]))
							{
								$tot_balance_plantWise[$i] = $tot_balance_plantWise[$i] + $hitrate;
							}							 	
						}
						?>
					</center></td>
					<td style="display:none;"><center>
						<?php
							$noh=18-$ntime;
							if($noh!=0)
							{
								$required=($balance)/$noh;
								$grand_tot_required = $grand_tot_required + round($required);
							}
							else
							{
								$required=($balance)/1;
								$grand_tot_required = $grand_tot_required + round($required);
							}
							echo round($required);
						?>
					</center></td>
				</tr>
				
				
				
				
				<?php
				
			} 
				for ($j=0; $j < sizeof($plant_name); $j++)
				{
					?>
					<tr style="background-color:green;color:white;font-weight: bold; border-bottom:2px solid black; border-top:2px solid black;">
						<td><center><?php  echo $plant_name[$j]; ?></center></td>
						<td></td>
						<td></td>
						<td><center><?php  echo $tot_frqty_plantWise[$j]; ?></center></td>
						<td><center><?php  echo $tot_forecast_qty_plantWise[$j]; ?></center></td>
						<td></td>
						<td></td>
						<td></td>
						<?php
							for ($i=0; $i < sizeof($time_display); $i++)
							{
								if ($grand_tot_qty_time_array1[$plant_name[$j]][$i] > 0)
								{
									echo "<td><center>".
									$grand_tot_qty_time_array1[$plant_name[$j]][$i]
									."</center></td>";			
								} 
								else
								{
									echo "<td><center> 0 </center></td>";
								}
								
							}
						?>
						<td><center><?php echo $tot_reported_plantWise[$j];  ?></center></td>
						<td><center><?php echo $tot_scanned_plantWise[$j];  ?></center></td>
						<td><center><?php echo $tot_scanned_sah_plantWise[$j];  ?></center></td>
						<td><center><?php echo $tot_fr_sah_plantWise[$j];  ?></center></td>
						<td><center><?php echo $tot_forecast_sah_plantWise[$j];  ?></center></td>
						<td><center><?php echo $tot_act_sah_plantWise[$j];  ?></center></td>
						<td><center><?php echo $tot_sah_diff_plantWise[$j];  ?></center></td>
						<?php 
							if ($nop>0 && $hours>0)
							{
								$tot_plan_eff_plantWise[$j]=round((($tot_fr_sah_plantWise[$j])/($nop*$hours))*100);
								$tot_act_eff_plantWise[$j]=round((($tot_act_sah_plantWise[$j])/($nop*$hours))*100);
							}
							else
							{
								$tot_plan_eff_plantWise[$j]=0;
								$tot_act_eff_plantWise[$j]=0;
							}
							
							if ($tot_forecast_qty_plantWise[$j] > 0)
							{
								$tot_hit_rate_plantWise[$j]=round(($tot_reported_plantWise[$j]/$tot_forecast_qty_plantWise[$j])*100);
							}
							else
							{
								$tot_hit_rate_plantWise[$j]=0;
							}
						?>
						<td><center><?php echo $tot_plan_eff_plantWise[$j].'%';  ?></center></td>
						<td><center><?php echo $tot_act_eff_plantWise[$j].'%';  ?></center></td>
						<td><center><?php echo $tot_forecast_qty_plantWise[$j]-$tot_reported_plantWise[$j];  ?></center></td>
						<td><center><?php echo $tot_hit_rate_plantWise[$j].'%';  ?></center></td>
						<td style="display:none;"><center><?php echo $grand_tot_required;  ?></center></td>
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
