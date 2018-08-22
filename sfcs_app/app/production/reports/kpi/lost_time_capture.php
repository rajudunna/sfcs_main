<!DOCTYPE html>
<?php
	//load the database configuration file
	include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
	$has_perm=haspermission($_GET['r']);
?>
  <title>Lost Time Capturing Report</title>
 
 <style type="text/css">
	td {
		color:black;
	}
</style>
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
<div class="panel-heading">Lost Hour Capturing Report-<?php  echo $frdate;  ?></div>
<div class="panel-body">
<div class="col-sm-12">
<form action='?r=<?= $_GET["r"]; ?>' method='GET'>
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
  <!--<center><h2 style="color:#4a148c;"><b><i>Lost Hour Capturing Report - <?php  echo $frdate;  ?></i></b></h2></center>-->
 
   
   <?php
   if(isset($_GET['submit'])){
   $sql="SELECT * FROM $bai_pro2.fr_data where frdate='$frdate' GROUP BY team ORDER BY team*1";
    // echo $sql;
	$res=mysqli_query($link,$sql); 
	$i=0; 

	//variables get for factory summary----------------------------------------
	$sumfrqty=$sumfrqty1=$sumfrqty2=$sumfrplanqty=0;
	$tout1=$tout2=$tout3=$tout4=$tout5=$tout6=$tout7=$tout8=$tout9=$tout10=$tout11="";
	
   ?>
<div style='overflow:scroll;max-height:800px;max-width:1200px;'>
  
	<?php  if($row=mysqli_fetch_array($res)){ 
		
	 // echo $frdate;
    $date=$row['frdate'];
	//echo $date;
	$newDate = date("Y-m-d", strtotime($date));
	//echo $newDate.'<br>';
	
	$team=$row['team'];
	
	//get styles which run in lines
	$sql1="SELECT distinct style FROM $bai_pro2.fr_data where frdate='$frdate' AND team='$team'";
	$res1=mysqli_query($link,$sql1);
	
	$sql2="SELECT distinct schedule FROM $bai_pro2.fr_data where frdate='$frdate' AND team='$team'";
	$res2=mysqli_query($link,$sql2);
	
	$sql3="SELECT SUM(fr_qty) AS sumfrqty FROM $bai_pro2.fr_data where frdate='$frdate' AND team='$team'";
	// echo $sql3;
	$res3=mysqli_query($link,$sql3);
	
	$sql4="SELECT qty,reason FROM $bai_pro3.line_forecast where date='$frdate' AND module='$team'";
	// echo $sql4;
	$res4=mysqli_query($link,$sql4);
	$res5=mysqli_query($link,$sql4);
	
	$sql6="SELECT time,dreason,output_qty FROM $bai_pro2.hourly_downtime where date='$frdate' AND team='$team' AND dreason!='N'";
	// echo $sql6;
	$res6=mysqli_query($link,$sql6) or exit('$sql6 error'. mysqli_error($link));
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
				//$dres5=array();
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
	<table class="table table-bordered table-responsive">
	<tr style="background-color:#ec407a;display:none;">
        <th colspan="12"></th>
		<th style="border:1px solid #ec407a;">Time</th>
		<th colspan="17" style="border:1px solid #ec407a;"></th>
      </tr>
      <tr style="background:#6995d6;color:white;">
        <th>Team</th>
        
        <th>Style</th>
		<th style="display:none;">Sch</th>
		<th>FR Plan</th>
		<th>Forecast</th>
		
		<th>Planned <br> Status</th>
		<th>Reason</th>
		<th>Pcs</th>
		
		<th>8.30 A.M.</th>
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
		<th>Action</th>
      </tr>
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
				echo '<td style="background-color:#ef9a9a;">No</td>';
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
				echo '<td style="background-color:#b2ff59;">'.$pcs.'</td>';
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
			
			// $username_list=explode('\\',$_SERVER['REMOTE_USER']);
			// $username=strtolower($username_list[1]);
			// $username="sfcsproject1";
			// $super_user=array("sfcsproject1","hasithada","thusharako","thilinana","chathurangad","dinushapre","diland","ranganak");
							
				if (in_array($authorized, $has_perm)){
						echo '<td><b><a href="'.getFullURLLevel($_GET['r'],'edit_downtime.php',0,'N').'"&team='.$team.'&dat='.$frdate.'">Edit</a></b></td>';
				}
			
				?>
				
	
	<?php  $out=0;  
	$i++;
	?>	
	</tr>
	

	<?php    
	$dres1=$dres2=$dres3=$dres4=$dres5=$dres6=$dres7=$dres8=$dres9=$dres10=$dres11="";
	$out1=$out2=$out3=$out4=$out5=$out6=$out7=$out8=$out9=$out10=$out11="";
	$tout1=$tout2=$tout3=$tout4=$tout5=$tout6=$tout7=$tout8=$tout9=$tout10=$tout11="";
	$forecastqty=0;
	$frqty=0;
	$plansah=0;
	$balance=0;
	$plan_eff=0;
	$act_eff=0;
	
	
	} else{
		echo "<hr><div class='alert alert-danger'>No Data Found..</div>";
	}
}
	
	?>
      
  </table>
</div>
</div>
</div>
</div>
</div>
</div>
