<?php ini_set('max_execution_time', 360); 
// error_reporting(0);
?>
<!DOCTYPE html>
<?php
//load the database configuration file
//include("..".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
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
				   //Starting get process for hourly efficiency report through FR Plan.
				   
				   if($_GET['pro_date']){
					   $frdate=$_GET['pro_date'];
					   $ntime=18;				   
				   }else{
					   $frdate=date("Y-m-d");
					   $ntime=date('H');
				   }
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
			$total_hours = $plant_end_time - $plant_start_time;
			list($hour, $minutes, $seconds) = explode(':', $plant_start_time);
			$minutes_29 = $minutes-1;

			$sql="SELECT * FROM $bai_pro2.fr_data where frdate='$frdate' GROUP BY team ORDER BY team*1";
			// echo $sql.'<br>';
			$res=mysqli_query($link,$sql);
	
			$i=0; ?>
			<section class="content-area">
			<div class='table-responsive'>
			<div class="table-area">
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
							$hour_end = array();
							$from_hour = $hour.":".$minutes;
							$hour1=$hour++ + 1;
							$to_hour = $hour1.":".$minutes_29;
							$hour_end[] = $hour1;
							echo "<th><center>$from_hour<br>to<br>$to_hour</center></th>";
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
			$grand_tot_qty_time_array = array(); $grand_tot_plan_sah=0;
			$grand_tot_fr_qty = 0; $grand_tot_forecast_qty=0; $grand_tot_total_qty=0; $grand_tot_scanned_qty=0; 
			$grand_tot_scanned_sah=0; $grand_tot_forecast_sah=0; $grand_tot_act_sah=0; $grand_tot_sah_diff=0;
			$grand_tot_plan_eff=0; $grand_tot_act_eff=0; $grand_tot_hitrate=0; $grand_tot_required=0; $module_count=0;
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
								$grand_tot_fr_qty = $grand_tot_fr_qty+ $frqty;
							}
						?>
					</center></td>
					<td><center>
						<?php 
							while($row4=mysqli_fetch_array($res4))
							{
								$forecastqty=$row4['qty'];
								echo $row4['qty'].'<br>';
								$grand_tot_forecast_qty = $grand_tot_forecast_qty+ $forecastqty;
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
							$pcsphr=$forecastqty/10;
							echo round($pcsphr);
						?>
					</center></td>
					<?php
						for ($i=0; $i < sizeof($hours_array); $i++)
						{
							// echo $hours_array[$i].'<br>';
							$hour_iniate = $hours_array[$i];
							$hour_ending = $hour_end[$i];
							$sql6_1="SELECT qty,status FROM $bai_pro2.hout WHERE out_date='$frdate' AND team='$team' AND (TIME(out_time) BETWEEN TIME('".$hour_iniate.":00') AND TIME('".$hour_iniate.":59'));";
							// echo $sql6_1.'<br><br>';
							$res6_1=mysqli_query($link,$sql6_1);
							if (mysqli_num_rows($res6_1) > 0)
							{
								while($row6_1=mysqli_fetch_array($res6_1))
								{
									$row = $row6_1['qty'];
									$total_qty = $total_qty + $row;
									if ($row >= round($pcsphr))
									{
										$grand_tot_qty_time_array[$i] = $grand_tot_qty_time_array[$i] + $row6_1['qty'];
										echo "<td><center>".$row."</center></td>";
									} 
									else if ($row < round($pcsphr))
									{
										$sql6_2="SELECT * FROM `bai_pro2`.`hourly_downtime` WHERE DATE='$frdate' AND dhour = '$hour_iniate' AND team='$team';";
										// echo $sql6_2.'<br><br>';
										$res6_12=mysqli_query($link,$sql6_2);
										if (mysqli_num_rows($res6_12) > 0)
										{
											$grand_tot_qty_time_array[$i] = $grand_tot_qty_time_array[$i] + $row6_1['qty'];
											echo "<td style='background-color:#ff0000; color:white;'><center>".$row."</center></td>";
										}
										else
										{
											$img_url = getFullURLLevel($_GET['r'], 'common/images/sign.jpg', 2, 'R');
											// echo $img_url;
											// echo "<td style='background-color:#FFBF00;'><center><i class='fa fa-exclamation-circle ' aria-hidden='true'></i></center></td>";
											echo "<td><img src='$img_url' alt=\"Sign\" height=\"42\" width=\"42\"></td>";
										}
									}
								}
							}
							else
							{
								$total_qty = $total_qty + 0;
								if ($hour_iniate > date('H') and $frdate == date('Y-m-d'))
								{
									echo "<td><center> - </center></td>";
								}
								else
								{
									echo "<td><center> 0 </center></td>";
								}
							}				
						}
					?>
					<td style="background-color:#d7ccc8;"><center>
						<b>
						<?php  
							echo $total_qty; 
							$grand_tot_total_qty = $grand_tot_total_qty + $total_qty; 
						?>
						</b>
					</center></td>
					<td style="background-color:#d7ccc8;"><center>
						<b>
						<?php  
							echo $sumscqty; 
							$grand_tot_scanned_qty = $grand_tot_scanned_qty + $sumscqty;
						?>
						</b>
					</center></td>
					<td style="background-color:#d7ccc8;"><center>
						<b>
						<?php 
							$scanned_sah=round(($sumscqty*$smv)/60);
							echo $scanned_sah; 
							$grand_tot_scanned_sah = $grand_tot_scanned_sah + $scanned_sah; 
						?>
						</b>
					</center></td>
					<td><center>
						<?php 
							$plan_sah=round(($frqty*$smv)/60); 
							echo $plan_sah; 
							$grand_tot_plan_sah = $grand_tot_plan_sah + $plan_sah;	
						?>
					</center></td>
					<td><center>
						<?php
							$forecast_sah=round(($forecastqty*$smv)/60);
							echo $forecast_sah;	
							$grand_tot_forecast_sah = $grand_tot_forecast_sah + $forecast_sah;
						?>
					</center></td>
					<td><center>
						<?php  
							$act_sah=round(($total_qty*$smv)/60);
							echo $act_sah;
							$grand_tot_act_sah = $grand_tot_act_sah + $act_sah;
						?>
					</center></td>
					<td><center>
						<?php
							$sah_diff=$plan_sah-$act_sah;
							echo $sah_diff;
							$grand_tot_sah_diff = $grand_tot_sah_diff + $sah_diff;
						?>
					</center></td>
					<td><center>
						<?php
							$plan_eff=round((($frqty*$smv)/($nop*$hours*60))*100);
							echo $plan_eff.'%';
							$grand_tot_plan_eff = $grand_tot_plan_eff + $plan_eff;
						?>
					</center></td>
					<td><center>
						<?php
							$act_eff=round((($total_qty*$smv)/($nop*$hours*60))*100);
							$grand_tot_act_eff = $grand_tot_act_eff + $act_eff;
							// $act_eff_hour=$ntime-8;
							// if($act_eff_hour<=0)
							// {
							// 	$act_eff=round((($total_qty*$smv)/($nop*60))*100);
							// 	$grand_tot_act_eff = $grand_tot_act_eff + $act_eff;
							// }
							// else
							// {
							// 	$act_eff=round((($total_qty*$smv)/($nop*$act_eff_hour*60))*100);
							// 	$grand_tot_act_eff = $grand_tot_act_eff + $act_eff;
							// }
							echo $act_eff.'%';
						?>
					</center></td>
					<td style="display:none;"></center></td>
					<td><center>
						<?php
							$balance=$forecastqty-$total_qty;
							echo $balance;
							$grand_tot_balance = $grand_tot_balance + $balance;
						?>
					</center></td>
					<td><center>
						<?php
						if($forecastqty !=0)
						{
							$hitrate=round(($total_qty/$forecastqty)*100);
							$grand_tot_hitrate = $grand_tot_hitrate + $hitrate;
						}
						else
						{
							$hitrate=0;
							$grand_tot_hitrate = $grand_tot_hitrate + $hitrate;
						}
						echo $hitrate.'%';
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
				
			} ?>
				<tr style="background-color:green;color:white;font-weight: bold; border-bottom:2px solid black; border-top:2px solid black;">
					<td><center>Factory</center></td>
					<td></td>
					<td></td>
					<td><center><?php  echo $grand_tot_fr_qty; ?></center></td>
					<td><center><?php  echo $grand_tot_forecast_qty; ?></center></td>
					<td></td>
					<td></td>
					<td></td>
					<?php
						for ($i=0; $i < sizeof($hours_array); $i++)
						{
							if ($grand_tot_qty_time_array[$i] > 0)
							{
								echo "<td><center>$grand_tot_qty_time_array[$i]</center></td>";			
							} 
							else
							{
								echo "<td><center> 0 </center></td>";
							}
							
						}
					?>
					<td><center><?php echo $grand_tot_total_qty;  ?></center></td>
					<td><center><?php echo $grand_tot_scanned_qty;  ?></center></td>
					<td><center><?php echo $grand_tot_scanned_sah;  ?></center></td>
					<td><center><?php echo $grand_tot_plan_sah;  ?></center></td>
					<td><center><?php echo $grand_tot_forecast_sah;  ?></center></td>
					<td><center><?php echo $grand_tot_act_sah;  ?></center></td>
					<td><center><?php echo $grand_tot_sah_diff;  ?></center></td>
					<?php 
						$grand_plan_eff=round((($grand_tot_plan_sah)/($nop*$hours))*100);
						$grand_act_eff=round((($grand_tot_act_sah)/($nop*$hours))*100);
						$grand_hitrate=round(($grand_tot_total_qty/$grand_tot_forecast_qty)*100);
					?>
					<td><center><?php echo $grand_plan_eff.'%';  ?></center></td>
					<td><center><?php echo $grand_act_eff.'%';  ?></center></td>
					<td><center><?php echo $grand_tot_balance;  ?></center></td>
					<td><center><?php echo $grand_hitrate.'%';  ?></center></td>
					<td style="display:none;"><center><?php echo $grand_tot_required;  ?></center></td>
				</tr>
			
	<?php	}
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
