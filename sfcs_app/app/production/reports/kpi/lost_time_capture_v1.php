<!DOCTYPE html>
<?php
//load the database configuration file
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
$has_perm=haspermission($_GET['r']);
// echo getFullURLLevel($_GET['r'],'lost_time_capture.php',0,'R');
?>
<html lang="en">
<head>
  <title>Lost Time Capturing Report</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'css/bootstrap.min.css',0,'R'); ?>">
  <script src="<?= getFullURLLevel($_GET['r'],'js/bootstrap.min.js',0,'R'); ?>"></script>
  <script src="<?= getFullURLLevel($_GET['r'],'js/jquery.js',0,'R'); ?>"></script>-->
  
<!-- <style type="text/css">
 table a:link {
	color: #666;
	font-weight: bold;
	text-decoration:none;
}
table a:visited {
	color: #999999;
	font-weight:bold;
	text-decoration:none;
}
table a:active,
table a:hover {
	color: #bd5a35;
	text-decoration:underline;
}
table {
	font-family:Arial, Helvetica, sans-serif;
	color:#666;
	font-size:12px;
	text-shadow: 1px 1px 0px #fff;
	background:#eaebec;
	margin:20px;
	border:#ccc 1px solid;

	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	border-radius:3px;

	-moz-box-shadow: 0 1px 2px #d1d1d1;
	-webkit-box-shadow: 0 1px 2px #d1d1d1;
	box-shadow: 0 1px 2px #d1d1d1;
}
table th {
	padding:21px 25px 22px 25px;
	border-top:1px solid #fafafa;
	border-bottom:1px solid #e0e0e0;

	background:#039be5;
	background: -webkit-gradient(linear, left top, left bottom, from(#ededed), to(#ebebeb));
	background: -moz-linear-gradient(top,  #ededed,  #ebebeb);
}
table th:first-child {
	text-align: left;
	padding-left:20px;
}
table tr:first-child th:first-child {
	-moz-border-radius-topleft:3px;
	-webkit-border-top-left-radius:3px;
	border-top-left-radius:3px;
}
table tr:first-child th:last-child {
	-moz-border-radius-topright:3px;
	-webkit-border-top-right-radius:3px;
	border-top-right-radius:3px;
}
table tr {
	text-align: center;
	padding-left:20px;
}
table td:first-child {
	text-align: left;
	padding-left:20px;
	border-left: 0;
}
table td {
	padding:18px;
	border-top: 1px solid #ffffff;
	border-bottom:1px solid #e0e0e0;
	border-left: 1px solid #e0e0e0;

	background: #fafafa;
	background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
	background: -moz-linear-gradient(top,  #fbfbfb,  #fafafa);
}
table tr.even td {
	background: #f6f6f6;
	background: -webkit-gradient(linear, left top, left bottom, from(#f8f8f8), to(#f6f6f6));
	background: -moz-linear-gradient(top,  #f8f8f8,  #f6f6f6);
}
table tr:last-child td {
	border-bottom:0;
}
table tr:last-child td:first-child {
	-moz-border-radius-bottomleft:3px;
	-webkit-border-bottom-left-radius:3px;
	border-bottom-left-radius:3px;
}
table tr:last-child td:last-child {
	-moz-border-radius-bottomright:3px;
	-webkit-border-bottom-right-radius:3px;
	border-bottom-right-radius:3px;
}
table tr:hover td {
	background: #f2f2f2;
	background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
	background: -moz-linear-gradient(top,  #f2f2f2,  #f0f0f0);	
}
 
 
</style>-->
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
<div class="panel-heading">Lost Hour Capturing Report <?php  echo $frdate;  ?></div>
<div class="panel-body">
				<form action="" method='GET'>
				<br>
				<input type='hidden' name='r' value="<?= base64_encode('/'.getFullURLLevel($_GET['r'],'lost_time_capture_v1.php',0,'R')) ?>">
				<div class="col-sm-3">
				Date : <input type='text' data-toggle='datepicker' class='form-control' width="40" value='<?php echo $frdate;  ?>' name='pro_date'>
				</div></br>
				<div class="col-sm-3">
				<input type='submit' class="btn btn-primary" value='Filter' name='submit'></div>
				</form>
  <!-- <center><h2 style="color:#4a148c;"><b><i>Lost Hour Capturing Report - <?php  //echo $frdate;  ?></i></b></h2></center> -->
  <hr>
   
   <?php
   if(isset($_GET['submit'])){
    $sql="SELECT * FROM $bai_pro2.fr_data where frdate='$frdate' GROUP BY team ORDER BY team*1";
    //echo $sql;
	$res=mysqli_query($link,$sql); 
	$i=0; 
	 
	//variables get for factory summary----------------------------------------
	$sumfrqty=$sumfrqty1=$sumfrqty2=$sumfrplanqty=0;
	$tout1=$tout2=$tout3=$tout4=$tout5=$tout6=$tout7=$tout8=$tout9=$tout10=$tout11="";
	
    $plant_timings_query="SELECT * FROM $bai_pro3.tbl_plant_timings order by time_id*1";
	// echo $plant_timings_query;
	$plant_timings_result=mysqli_query($link,$plant_timings_query);
	while ($row = mysqli_fetch_array($plant_timings_result))
	{
		$start_time[] = $row['start_time'];
		$end_time[] = $row['end_time'];
		$time_display[] = $row['time_display'].'<br>'.$row['day_part'];
		$time_value[]=$row['time_value'];
	}
 

   ?>
<div class="table-responsive">
  <table class="table table-bordered">
    	<thead>
	<tr style="background-color:#ec407a;display:none;">
        <th colspan="12"></th>
		<th style="border:1px solid #ec407a;">Time</th>
		<th colspan="17" style="border:1px solid #ec407a;"></th>
      </tr>
      <tr style="background-color:#6995d6;color:white">
        <th>Team</th>
        
        <th>Style</th>
		<th style="display:none;">Sch</th>
		<th>FR Plan</th>
		<th>Forecast</th>
		
		<th>Planned <br> Status</th>
		<th>Reason</th>
		<th>Pcs</th>
		
		<?php
			for ($i=0; $i < sizeof($time_display); $i++)
			{
				echo "<th><center>$time_display[$i]</center></th>";
				echo "<th><center>PCS</center></th>";
				
			}
		?>
		<th>Control</th>	
      </tr>
    </thead>
	<?php  
	while($row=mysqli_fetch_array($res))
	{ 
		
		// echo $frdate;
		$date=$row['frdate'];
		//echo $date;
		$newDate = date("Y-m-d", strtotime($date));
		//echo $newDate.'<br>';0
		
		$team=$row['team'];
		//get styles which run in lines
		$sql1="SELECT distinct style FROM $bai_pro2.fr_data where frdate='$frdate' AND team='$team'";
		$res1=mysqli_query($link,$sql1);
		
		$sql2="SELECT distinct schedule FROM $bai_pro2.fr_data where frdate='$frdate' AND team='$team'";
		$res2=mysqli_query($link,$sql2);
		
		$sql3="SELECT COALESCE(SUM(fr_qty),0) AS sumfrqty FROM $bai_pro2.fr_data where frdate='$frdate' AND team='$team'";
		// echo $sql3."<br>";
		$res3=mysqli_query($link,$sql3);
		
		$sql4="SELECT COALESCE(SUM(qty,0)) as qty,reason FROM $bai_pro3.line_forecast where date='$frdate' AND module='$team'";
		// echo $sql4."<br>";
		$res4=mysqli_query($link,$sql4);
		$res5=mysqli_query($link,$sql4);
	
		for ($i1=0; $i1 < sizeof($time_value); $i1++)
		{
			$sql6="SELECT * FROM $bai_pro2.hourly_downtime where date='$frdate' AND team='$team' and hour(time)='".$time_value[$i1]."' AND dreason!='N'";
			$res6=mysqli_query($link,$sql6);
			// echo $sql6."-".mysqli_num_rows($res6)."<br>";
			if(mysqli_num_rows($res6) > 0)
			{
				while($row6=mysqli_fetch_array($res6))
				{
					$sout_time=$row6['time'];
					$arr = explode(":", "$sout_time");
					$num = $arr[0];

					$out[$time_value[$i1]."".$team]=$row6['output_qty'];
					$tout[$time_value[$i1]."".$team]=$tout[$time_value[$i1]."".$team]+$row6['output_qty'];
					$total_out[$team]=$total_out[$team]+$row6['output_qty'];
					$dres[$time_value[$i1]."".$team][]=$row6['dreason'];					
				}
			}
			else
			{
				$out[$time_value[$i1]."".$team]=0;
				$tout[$time_value[$i1]."".$team]=$tout[$time_value[$i1]."".$team]+0;
				$total_out[$team]=$total_out[$team]+0;
				$dres[$time_value[$i1]."".$team][]="N/A";
			}
			
		}
		
			
	$nop='24';	
	?>

    <tbody>
	<?php
	echo '<tr style="border-bottom:2px solid black;">
		<td>'.$team.'</td>
			
			<td>';
				 while($row1=mysqli_fetch_array($res1)){
				echo $row1['style'].'<br>';

					}
			echo '</td>
			<td style="display:none;">';
			while($row2=mysqli_fetch_array($res2)){
					echo $row2['schedule'].'<br>';

					}
					echo '</td>
			<td>';
			while($row3=mysqli_fetch_array($res3)){
					$frqty=$row3['sumfrqty'];
					echo $row3['sumfrqty'].'<br>';

					}
			echo '</td>
			<td>';
			 while($row4=mysqli_fetch_array($res4)){
					$forecastqty=$row4['qty'];
					echo $row4['qty'].'<br>';

					}
			echo '</td>';
			
			
			if($frqty>$forecastqty){
				echo '<td style="background-color: #f5b1b1;color: #b91b1b;">No</td>';
			}else{
				echo '<td>Yes</td>';
			}	
			
			
			echo '<td>';
			$hours=$row['hours'];
			 while($row5=mysqli_fetch_array($res5)){
				
					echo $row5['reason'].'<br>';

					}
			
			echo '</td>'; 
			if($frqty>$forecastqty){
			$pcs=$frqty-$forecastqty;
				echo '<td style="background-color: #b6e4b0;color: #041f08;">'.$pcs.'</td>';
			}else{
				echo '<td></td>';
			}	
			 
			
			for ($i3=0; $i3 < sizeof($time_value); $i3++)
		    {
				echo '<td>';
				//for($i4=0;$i4<sizeof($dres[$time_value[$i3]."".$team]);$i4++)
				{
					echo implode(",",$dres[$time_value[$i3]."".$team]).'<br>';
				}
				echo '</td>';
				echo '<td><b>'.$tout[$time_value[$i3]."".$team].'</b></td>';
			}
							
			if (in_array($authorized, $has_perm)){
				$url=base64_encode('/sfcs_app/app/production/reports/kpi/edit_downtime.php');
					echo '<td><b><a href="index.php?r='.$url.'&team='.$team.'&dat='.$frdate.'">Edit</a></b></td>';
			}
			
		?>
				
	
	<?php  $out=0;  
	$i++;
	?>
	
	
	</tr>
	<?php 
		if($team%3==0 && $team<36){
		?>
	


	<?php   
		}
	$dres1=$dres2=$dres3=$dres4=$dres5=$dres6=$dres7=$dres8=$dres9=$dres10=$dres11="";
	$out1=$out2=$out3=$out4=$out5=$out6=$out7=$out8=$out9=$out10=$out11="";
	$tout1=$tout2=$tout3=$tout4=$tout5=$tout6=$tout7=$tout8=$tout9=$tout10=$tout11="";
	$forecastqty=0;
	$frqty=0;
	$plansah=0;
	$balance=0;
	$plan_eff=0;
	$act_eff=0;
	
	
	}
	// else
	// {
		// echo "<hr><div class='alert alert-danger'>No Data Found..</div>";
	// } 
	
}?>
      
    </tbody>
  </table></div>
  <br><br>
</div>
</div></div>
</body>
</html>
