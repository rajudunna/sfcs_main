<!DOCTYPE html>
<?php
//load the database configuration file
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
$has_perm=haspermission($_GET['r']);
?>
<html lang="en">
<head>
  <title>Lost Time Capturing Report</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

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
  <hr>
   
<?php
if(isset($_GET['submit'])){
$sql="SELECT * FROM $bai_pro2.fr_data where frdate='$frdate' GROUP BY team ORDER BY team*1";
$res=mysqli_query($link,$sql); 
$i=0; 
	
//variables get for factory summary----------------------------------------
$sumfrqty=$sumfrqty1=$sumfrqty2=$sumfrplanqty=0;
$tout1=$tout2=$tout3=$tout4=$tout5=$tout6=$tout7=$tout8=$tout9=$tout10=$tout11="";

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
		
		<th rowspan="2">8.30 A.M.</th>
		<th>Pcs</th>
		<th>9.30 A.M.</th>
		<th>Pcs</th>
		<th>10.30 A.M</th>
		<th>Pcs</th>
		<th>11.30 A.M</th>
		<th>Pcs</th>
		<th>12.30 P.M.</th>
		<th>Pcs</th>
		<th>1.30 P.M.</th>
		<th>Pcs</th>
		<th>2.30 P.M.</th>
		<th>Pcs</th>
		<th>3.30 P.M.</th>
		<th>Pcs</th>
		<th>4.30 P.M.</th>
		<th>Pcs</th>
		<th>5.30 P.M.</th>
		<th>Pcs</th>
		<th>6.30 P.M.</th>
		<th>Pcs</th>
		<th></th>
		
		
      </tr>
    </thead>
	<?php  while($row=mysqli_fetch_array($res)){ 
		
    $date=$row['frdate'];
	$newDate = date("Y-m-d", strtotime($date));
	
	$team=$row['team'];
	
	//get styles which run in lines
	$sql1="SELECT distinct style FROM $bai_pro2.fr_data where frdate='$frdate' AND team='$team'";
	$res1=mysqli_query($link,$sql1);
	
	$sql2="SELECT distinct schedule FROM $bai_pro2.fr_data where frdate='$frdate' AND team='$team'";
	$res2=mysqli_query($link,$sql2);
	
	$sql3="SELECT SUM(fr_qty) AS sumfrqty FROM $bai_pro2.fr_data where frdate='$frdate' AND team='$team'";
	$res3=mysqli_query($link,$sql3);
	
	$sql4="SELECT qty,reason FROM $bai_pro3.line_forecast where date='$frdate' AND module='$team'";
	$res4=mysqli_query($link,$sql4);
	$res5=mysqli_query($link,$sql4);
	
	
	$sql6="SELECT time,dreason,output_qty FROM $bai_pro2.hourly_downtime where date='$frdate' AND team='$team' AND dreason!='N'";
	$res6=mysqli_query($link,$sql6);
		while($row6=mysqli_fetch_array($res6)){
			$sout_time=$row6['time'];
			$arr = explode(":", "$sout_time");
			$num = $arr[0];
			
			if($num=='8'){
				$out1=$row6['output_qty'];
				$tout1=$tout1+$out1;
				$dres1[]=$row6['dreason'];
			}else if($num=='9'){
				$out2=$row6['output_qty'];
				$tout2=$tout2+$out2;
				$dres2[]=$row6['dreason'];
			}else if($num=='10'){
				$out3=$row6['output_qty'];
				$tout3=$tout3+$out3;
				$dres3[]=$row6['dreason'];
			}else if($num=='11'){
				$out4=$row6['output_qty'];
				$tout4=$tout4+$out4;
				$dres4[]=$row6['dreason'];
			}else if($num=='12'){
				$out5=$row6['output_qty'];
				$tout5=$tout5+$out5;
				$dres5[]=$row6['dreason'];
				
				
			}else if($num=='13'){
				$out6=$row6['output_qty'];
				$tout6=$tout6+$out6;
				$dres6[]=$row6['dreason'];
				
			}else if($num=='14'){
				$out7=$row6['output_qty'];
				$tout7=$tout7+$out7;
				$dres7[]=$row6['dreason'];
				
			}else if($num=='15'){
				$out8=$row6['output_qty'];
				$tout8=$tout8+$out8;
				$dres8[]=$row6['dreason'];	
			}else if($num=='16'){
				$out9=$row6['output_qty'];
				$tout9=$tout9+$out9;
				$dres9[]=$row6['dreason'];	
			}else if($num=='17'){
				$out10=$row6['output_qty'];
				$tout10=$tout10+$out10;
				$dres10[]=$row6['dreason'];	
			}else if($num=='18'){
				$out11=$row6['output_qty'];
				$tout11=$tout11+$out11;
				$dres11[]=$row6['dreason'];	
			}
		$out=$out1+$out2+$out3+$out4+$out5+$out6+$out6+$out7+$out8+$out9+$out10+$out11;
		
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
			  
			echo '<td>';
			for($i=0;$i<sizeof($dres1);$i++)
			{
			echo $dres1[$i].'<br>';
			}
			echo '</td>';
			echo '<td><b>'.$tout1.'</b></td>';
			echo '<td>';
			for($i=0;$i<sizeof($dres2);$i++)
			{
			echo $dres2[$i].'<br>';
			}
			echo '</td>';
			echo '<td><b>'.$tout2.'</b></td>';
			echo '<td>';
			for($i=0;$i<sizeof($dres3);$i++)
			{
			echo $dres3[$i].'<br>';
			}
			echo '</td>';
			echo '<td><b>'.$tout3.'</b></td>';
			echo '<td>';
			for($i=0;$i<sizeof($dres4);$i++)
			{
			echo $dres4[$i].'<br>';
			}
			echo '</td>';
			echo '<td><b>'.$tout4.'</b></td>';
			echo '<td>';
			for($i=0;$i<sizeof($dres5);$i++)
			{
			echo $dres5[$i].'<br>';
			}
			echo '</td>';
			echo '<td><b>'.$tout5.'</b></td>';
			echo '<td>';
			for($i=0;$i<sizeof($dres6);$i++)
			{
			echo $dres6[$i].'<br>';
			}
			echo '</td>';
			echo '<td><b>'.$tout6.'</b></td>';
			echo '<td>';
			for($i=0;$i<sizeof($dres7);$i++)
			{
			echo $dres7[$i].'<br>';
			}
			echo '</td>';
			echo '<td><b>'.$tout7.'</b></td>';
			echo '<td>';
			for($i=0;$i<sizeof($dres8);$i++)
			{
			echo $dres8[$i].'<br>';
			}
			echo '</td>';
			echo '<td><b>'.$tout8.'</b></td>';
			echo '<td>';
			for($i=0;$i<sizeof($dres9);$i++)
			{
			echo $dres9[$i].'<br>';
			}
			echo '</td>';
			echo '<td><b>'.$tout9.'</b></td>';
			echo '<td>';
			for($i=0;$i<sizeof($dres10);$i++)
			{
			echo $dres10[$i].'<br>';
			}
			echo '</td>';
			echo '<td><b>'.$tout10.'</b></td>';
			echo '<td>';
			for($i=0;$i<sizeof($dres11);$i++)
			{
			echo $dres11[$i].'<br>';
			}
			echo '</td>';
			echo '<td><b>'.$tout11.'</b></td>';
	
						
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
	
	
}?>
      
    </tbody>
  </table></div>
  <br><br>
</div>
</div></div>
</body>
</html>
