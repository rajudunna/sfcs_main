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

			$sql="SELECT * FROM $bai_pro2.fr_data where frdate='$frdate' GROUP BY team ORDER BY team*1";
			// echo $sql.'<br>';
			$res=mysqli_query($link,$sql);
	
			$i=0; 

			//variables get for factory summary----------------------------------------
			$sumfrqty=$sumfrqty1=$sumfrqty2=$sumfrplanqty=0;
			$tout1=$tout2=$tout3=$tout4=$tout5=$tout6=$tout7=$tout8=$tout9=$tout10=$tout11=0;
			$sumpsah=$sumasah=$sumpeff=$sumaeff=$sumbpcs=0;
			$forecastsah=0;
			$sumscanpcs=$sumscansah=0;
			$sumhitrate=0;
			$sumpcshr=0;
			
			//variables get for Plant A summary----------------------------------------
			$sumfrqtyp1=$sumfrqty1p1=$sumfrqty2p1=$sumfrplanqtyp1=0;
			$tout1p1=$tout2p1=$tout3p1=$tout4p1=$tout5p1=$tout6p1=$tout7p1=$tout8p1=$tout9p1=$tout10p1=$tout11p1=0;
			$sumpsahp1=$sumasahp1=$sumpeffp1=$sumaeffp1=$sumbpcsp1=0;
			$forecastsaha=0;
			$sumscanpcs_a=$sumscansah_a=0;
			$sumhitratea=0;
			$sumpcshra=0;
			
			//variables get for Plant B summary----------------------------------------
			$sumfrqtyp2=$sumfrqty1p2=$sumfrqty2p2=$sumfrplanqtyp2=0;
			$tout1p2=$tout2p2=$tout3p2=$tout4p2=$tout5p2=$tout6p2=$tout7p2=$tout8p2=$tout9p2=$tout10p2=$tout11p2=0;
			$sumpsahp2=$sumasahp2=$sumpeffp2=$sumaeffp2=$sumbpcsp2=0;
			$forecastsahb=0;
			$sumscanpcs_b=$sumscansah_b=0;
			$sumhitrateb=0;
			$sumpcshrb=0;
			?>
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
			while($row=mysqli_fetch_array($res))
			{ 
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
				<tr style="border-bottom:2px solid black;">
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
							}
						?>
					</td>
					<td>
						<?php 
							while($row4=mysqli_fetch_array($res4))
							{
								$forecastqty=$row4['qty'];
								echo $row4['qty'].'<br>';
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
									$total_qty = $total_qty + $row;
									if ($row >= round($pcsphr))
									{
										echo "<td>".$row."</td>";
									} 
									else if ($row < round($pcsphr))
									{
										$sql6_2="SELECT * FROM `bai_pro2`.`hourly_downtime` WHERE DATE='$frdate' AND dhour = '$hour_iniate' AND team='$team';";
										// echo $sql6_2.'<br><br>';
										$res6_12=mysqli_query($link,$sql6_2);
										if (mysqli_num_rows($res6_12) > 0)
										{
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
					<td style="background-color:#d7ccc8;"><b><?php  echo $total_qty; ?></b></td>
					<td style="background-color:#d7ccc8;"><b><?php  echo $sumscqty;	?></b></td>
					<td style="background-color:#d7ccc8;"><b><?php  $scanned_sah=round(($sumscqty*$smv)/60);echo $scanned_sah;?></b></td>
					<td><?php $plan_sah=round(($frqty*$smv)/60); echo $plan_sah;	?></td>
					<td>
						<?php
							$forecast_sah=round(($forecastqty*$smv)/60);
							echo $forecast_sah;	
						?>
					</td>
					<td>
						<?php  
							$act_sah=round(($total_qty*$smv)/60);
							echo $act_sah;
						?>
					</td>
					<td>
						<?php
							$sah_diff=$plan_sah-$act_sah;
							echo $sah_diff;
						?>
					</td>
					<td>
						<?php
							$plan_eff=round((($forecastqty*$smv)/($nop*$hours*60))*100);
							echo $plan_eff.'%';
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
						?>
					</td>
					<td style="display:none;"></td>
					<td>
						<?php
							$balance=$forecastqty-$total_qty;
							echo $balance;
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
						?>
					</td>
					<?php
						$out=0;  
						$i++;
					?>
				</tr>
				
				
				
				
				<?php   
					//step one get total qty in plant
					$sumfrqty=$sumfrqty+$forecastqty;
					$sumfrplanqty=$sumfrplanqty+$frqty;
					$tout1=$tout1+(int)$out1;
					$tout2=$tout2+(int)$out2;
					$tout3=$tout3+(int)$out3;
					$tout4=$tout4+(int)$out4;
					$tout5=$tout5+(int)$out5;
					$tout6=$tout6+(int)$out6;
					$tout7=$tout7+(int)$out7;
					$tout8=$tout8+(int)$out8;
					$tout9=$tout9+(int)$out9;
					$tout10=$tout10+(int)$out10;
					$tout11=$tout11+(int)$out11;
					
					$toutf=$tout1+$tout2+$tout3+$tout4+$tout5+$tout6+$tout7+$tout8+$tout9+$tout10+$tout11;
					$sumpsah=$sumpsah+$plan_sah;
					$sumasah=$sumasah+$act_sah;
					$sahdiff=$sumpsah-$sumasah;
					$sumbpcs=$sumbpcs+$balance;
					$sumpeff=$sumpeff+$plan_eff;
					$sumaeff=$sumaeff+$act_eff;
					$forecastsah=$forecastsah+$forecast_sah;
					$sumscanpcs=$sumscanpcs+$sumscqty;
					$sumscansah=$sumscansah+$scanned_sah;
					$sumhitrate=$sumhitrate+$hitrate;
					$sumpcshr=$sumpcshr+$required;

					if($team<19)
					{
						$sumfrqtyp1=$sumfrqtyp1+$forecastqty;
						$sumfrplanqtyp1=$sumfrplanqtyp1+$frqty;
						$tout1p1=$tout1p1+(int)$out1;
						$tout2p1=$tout2p1+(int)$out2;
						$tout3p1=$tout3p1+(int)$out3;
						$tout4p1=$tout4p1+(int)$out4;
						$tout5p1=$tout5p1+(int)$out5;
						$tout6p1=$tout6p1+(int)$out6;
						$tout7p1=$tout7p1+(int)$out7;
						$tout8p1=$tout8p1+(int)$out8;
						$tout9p1=$tout9p1+(int)$out9;
						$tout10p1=$tout10p1+(int)$out10;
						$tout11p1=$tout11p1+(int)$out11;
						
						$toutfp1=$tout1p1+$tout2p1+$tout3p1+$tout4p1+$tout5p1+$tout6p1+$tout7p1+$tout8p1+$tout9p1+$tout10p1+$tout11p1;
						$sumpsahp1=$sumpsahp1+$plan_sah;
						$sumasahp1=$sumasahp1+$act_sah;
						$sahdiffp1=$sumpsahp1-$sumasahp1;
						$sumbpcsp1=$sumbpcsp1+$balance;
						$sumpeffp1=$sumpeffp1+$plan_eff;
						$sumaeffp1=$sumaeffp1+$act_eff;
						$forecastsaha=$forecastsaha+$forecast_sah;
						$sumscanpcs_a=$sumscanpcs_a+$sumscqty;
						$sumscansah_a=$sumscansah_a+$scanned_sah;
						$sumhitratea=$sumhitratea+$hitrate;
						$sumpcshra=$sumpcshra+$required;
					}
					
					if($team>18)
					{
						$sumfrqtyp2=$sumfrqtyp2+$forecastqty;
						
						$sumfrplanqtyp2=$sumfrplanqtyp2+$frqty;
						$tout1p2=$tout1p2+(int)$out1;
						$tout2p2=$tout2p2+(int)$out2;
						$tout3p2=$tout3p2+(int)$out3;
						$tout4p2=$tout4p2+(int)$out4;
						$tout5p2=$tout5p2+(int)$out5;
						$tout6p2=$tout6p2+(int)$out6;
						$tout7p2=$tout7p2+(int)$out7;
						$tout8p2=$tout8p2+(int)$out8;
						$tout9p2=$tout9p2+(int)$out9;
						$tout10p2=$tout10p2+(int)$out10;
						$tout11p2=$tout11p2+(int)$out11;
						
						$toutfp2=$tout1p2+$tout2p2+$tout3p2+$tout4p2+$tout5p2+$tout6p2+$tout7p2+$tout8p2+$tout9p2+$tout10p2+$tout11p2;
						$sumpsahp2=$sumpsahp2+$plan_sah;
						$sumasahp2=$sumasahp2+$act_sah;
						$sahdiffp2=$sumpsahp2-$sumasahp2;
						$sumbpcsp2=$sumbpcsp2+$balance;
						$sumpeffp2=$sumpeffp2+$plan_eff;
						$sumaeffp2=$sumaeffp2+$act_eff;
						$forecastsahb=$forecastsahb+$forecast_sah;	
						$sumscanpcs_b=$sumscanpcs_b+$sumscqty;	
						$sumscansah_b=$sumscansah_b+$scanned_sah;
						$sumhitrateb=$sumhitrateb+$hitrate;
						$sumpcshrb=$sumpcshrb+$required;
					}
				
				if($team==36)
				{
					?>
					<tr>
						<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
					</tr>
					
					<tr style="background-color:#c5e1a5;font-weight: bold;">
						<td>Plant A</td>
						<td></td>
						<td></td>
						<td><?php  echo $sumfrplanqtyp1; ?></td>
						<td><?php  echo $sumfrqtyp1; ?></td>
						<td></td>
						<td></td>
						<td></td>
						<td><?php echo $tout1p1;  ?> </td>
						<td><?php echo $tout2p1;  ?></td>
						<td><?php echo $tout3p1;  ?></td>
						<td><?php echo $tout4p1;  ?></td>
						<td><?php echo $tout5p1;  ?></td>
						<td><?php echo $tout6p1;  ?></td>
						<td><?php echo $tout7p1;  ?></td>
						<td><?php echo $tout8p1;  ?></td>
						<td><?php echo $tout9p1;  ?></td>
						<td><?php echo $tout10p1;  ?></td>
						<td><?php echo $tout11p1;  ?></td>
						<td><?php echo $toutfp1;  ?></td>
						<td><?php echo $sumscanpcs_a;  ?></td>
						<td><?php echo $sumscansah_a;  ?></td>
						<td><?php echo $sumpsahp1;  ?></td>
						<td><?php echo $forecastsaha;  ?></td>
						<td><?php echo $sumasahp1;  ?></td>
						<td><?php echo $sahdiffp1;  ?></td>
						<td><?php echo round($sumpeffp1/18).'%';  ?></td>
						<td><?php echo round($sumaeffp1/18).'%';  ?></td>
						<td><?php echo $sumbpcsp1;  ?></td>
						<td><?php echo round($sumhitratea/18);  ?>%</td>
						<td><?php echo $sumpcshra;  ?></td>
					</tr>

					<tr style="background-color:#c5e1a5;font-weight: bold;">
						<td>Plant B</td>
						<td></td>
						<td></td>
						<td><?php  echo $sumfrplanqtyp2; ?></td>
						<td><?php  echo $sumfrqtyp2; ?></td>
						<td></td>
						<td></td>
						<td></td>
						<td><?php echo $tout1p2;  ?> </td>
						<td><?php echo $tout2p2;  ?></td>
						<td><?php echo $tout3p2;  ?></td>
						<td><?php echo $tout4p2;  ?></td>
						<td><?php echo $tout5p2;  ?></td>
						<td><?php echo $tout6p2;  ?></td>
						<td><?php echo $tout7p2;  ?></td>
						<td><?php echo $tout8p2;  ?></td>
						<td><?php echo $tout9p2;  ?></td>
						<td><?php echo $tout10p2;  ?></td>
						<td><?php echo $tout11p2;  ?></td>
						<td><?php echo $toutfp2;  ?></td>
						<td><?php echo $sumscanpcs_b;  ?></td>
						<td><?php echo $sumscansah_b;  ?></td>
						<td><?php echo $sumpsahp2;  ?></td>
						<td><?php echo $forecastsahb;  ?></td>
						<td><?php echo $sumasahp2;  ?></td>
						<td><?php echo $sahdiffp2;  ?></td>
						<td><?php echo round($sumpeffp2/18).'%';  ?></td>
						<td><?php echo round($sumaeffp2/18).'%';  ?></td>
						<td><?php echo $sumbpcsp2;  ?></td>
						<td><?php echo round($sumhitrateb/18);  ?>%</td>
						<td><?php echo $sumpcshrb;  ?></td>
					</tr>
					<tr style="background-color:#1b5e20;color:white;font-weight: bold;">
						<td>Factory</td>
						<td></td>
						<td></td>
						<td><?php  echo $sumfrplanqty; ?></td>
						<td><?php  echo $sumfrqty; ?></td>
						<td></td>
						<td></td>
						<td></td>
						<td><?php echo $tout1;  ?></td>
						<td><?php echo $tout2;  ?></td>
						<td><?php echo $tout3;  ?></td>
						<td><?php echo $tout4;  ?></td>
						<td><?php echo $tout5;  ?></td>
						<td><?php echo $tout6;  ?></td>
						<td><?php echo $tout7;  ?></td>
						<td><?php echo $tout8;  ?></td>
						<td><?php echo $tout9;  ?></td>
						<td><?php echo $tout10;  ?></td>
						<td><?php echo $tout11;  ?></td>
						<td><?php echo $toutf;  ?></td>
						<td><?php echo $sumscanpcs;  ?></td>
						<td><?php echo $sumscansah;  ?></td>
						<td><?php echo $sumpsah;  ?></td>
						<td><?php echo $forecastsah;  ?></td>
						<td><?php echo $sumasah;  ?></td>
						<td><?php echo $sahdiff;  ?></td>
						<td><?php echo round($sumpeff/$i).'%';  ?></td>
						<td><?php echo round($sumaeff/$i).'%';  ?></td>
						<td><?php echo $sumbpcs;  ?></td>
						<td><?php echo round($sumhitrate/36);  ?>%</td>
						<td><?php echo $sumpcshr;  ?></td>
					</tr>
				
					<?php    
				}
				
				$out1=$out2=$out3=$out4=$out5=$out6=$out7=$out8=$out9=$out10=$out11="";
				$forecastqty=0;
				$frqty=0;
				$plansah=0;
				$balance=0;
				$plan_eff=0;
				$act_eff=0;
				$status="";
			}
			// else{
				// echo "<hr><div class='alert alert-danger'>No Data Found..</div>";
			// } 
			
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
