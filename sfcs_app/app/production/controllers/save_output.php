<html>
<head>
<script language="javascript" type="text/javascript" src="../styles/dropdowntabs.js"></script>
<link rel="stylesheet" href="../styles/ddcolortabs.css" type="text/css" media="all" />
<link rel="stylesheet" href="../table_style.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/bootstrap.min.css">

</head>
<body onload="startTime()">
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/config.php',3,'R'));	
 include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/functions.php',3,'R'));  ?>
<?php 
	$sout=$_POST['sout'];
	$pph=$_POST['pph'];
	$team=$_POST['team'];
	$section=$_POST['section'];
	
	$odate=date('Y-m-d');
	$otime=date('H:i');
	$pretime=$_POST['pretime'];
		
	$remarks='NA';
?>
<div class="container">
<div class="panel panel-primary">
 <div class="panel-heading">Update Downtime Reason</div>
  <div class="panel-body">
<?php
//echo $sout.' '.$pph.' '.$team.' '.$section;


	if($pretime=='1'){

		if($sout<$pph){
			echo "<h3 style='color:red;'><b>Output Quantity Less Than Target Quantity per Hour.Please Update Downtime Reason.</h3></b>";
			echo "<h4>Targer Quantity Per Hour :".$pph."</h4>";
			echo "<h4>Hourly Output :".$sout."</h4>";
			echo "<hr>";
			
				$sql2="SELECT * from $bai_pro2.downtime_reason";
				$res2=mysqli_query($link,$sql2);
				$res3=mysqli_query($link,$sql2);
				$res4=mysqli_query($link,$sql2);
			
			
			?>
				<form action="<?= getFullURLLevel($_GET['r'],'update_downtime_v1.php',0,'N'); ?>" method="POST">
				
				
				
					<table style='width:40%;' class='table table-bordered'>
				<tr><td>
					<b>Down Time Reason1</b><select class="form-control" name="dreason1" required="" style="width:60%;">
						<option value=""> Select </option>
						<?php   while($row2=mysqli_fetch_array($res2)){  ?>
						<option value="<?php echo $row2['code'];   ?>"><?php echo $row2['reason'].' : '.$row2['code'];   ?></option>	
						<?php   } ?>
					</select>
					</td><td>
					<b>Down Time Qty1 :</b> <input type="text" class="form-control" name="dout1" style="width:60%;">
					</td>
					</tr>
						<tr><td>
				   <b> Down Time Reason2</b><select class="form-control" name="dreason2" style="width:60%;">
						<option value=""> Select </option>
						<?php   while($row3=mysqli_fetch_array($res3)){  ?>
						<option value="<?php echo $row3['code'];   ?>"><?php echo $row3['reason'].' : '.$row3['code'];   ?></option>	
						<?php   } ?>
					</select></td><td>
					
					<b>Down Time Qty2 :</b> <input type="text" class="form-control" name="dout2" style="width:60%;"></td>
							</tr><tr><td>
				  <b>  Down Time Reason3</b><select class="form-control" name="dreason3"  style="width:60%;">
						<option value=""> Select </option>
						<?php   while($row4=mysqli_fetch_array($res4)){  ?>
						<option value="<?php echo $row4['code'];   ?>"><?php echo $row4['reason'].' : '.$row4['code'];   ?></option>	
						<?php   } ?>
					</select>
				</td><td>
				
			<b>	Down Time Qty3 : </b><input type="text" class="form-control" name="dout3" style="width:60%;"></td></tr>
				
				
				</table><br>
				<input type="hidden" name="sout" value="<?php echo $sout;  ?>">
				<input type="hidden" name="pph" value="<?php echo $pph;  ?>">
				<input type="hidden" name="team" value="<?php echo $team;  ?>">
				<input type="hidden" name="section" value="<?php echo $section;  ?>">
				<input type="submit" class="btn btn-info" value="Update Downtime">
				</form>
		
		
			<?php
		}
		else{
			$sql1="insert into $bai_pro2.hout(out_date,out_time,team,qty,status,remarks) VALUES ('$odate','$otime','$team','$sout','1','$remarks')";
			mysqli_query($link,$sql1);
			//echo $sql1;
			echo "<h3 style='color:#5cb85c;'><b>Successfuly Updated Hourly Output</h3></b>";
		}
		
	}else{
		
			echo "<script>swal('Not Update Output in Previous Hour','Please Update Downtime Reason with previous hour qty','warning');</script>";
				$sql2="SELECT * from $bai_pro2.downtime_reason";
				$res2=mysqli_query($link,$sql2);
				$res3=mysqli_query($link,$sql2);
				$res4=mysqli_query($link,$sql2);
				?>
				
				<form action="<?= getFullURLLevel($_GET['r'],'update_downtime_v2.php',0,'N'); ?>" method="POST">
				<table style='width:40%;' class='table table-bordered'>
				<tr>
				<td>
			<b>	Update Previous Hour Qty :</b> <input type="text" class="form-control" style="width:60%" name="sout"></td></tr>
		<tr>	<td>
					<b>Down Time Reason1</b><select class="form-control" name="dreason1" required="" style="width:60%;">
						<option value=""> Select </option>
						<?php   while($row2=mysqli_fetch_array($res2)){  ?>
						<option value="<?php echo $row2['code'];   ?>"><?php echo $row2['reason'].' : '.$row2['code'];   ?></option>	
						<?php   } ?>
					</select>
					</td><td>
					<b>Down Time Qty1 :</b> <input type="text" class="form-control" name="dout1" style="width:60%;">
					</td>
					</tr>
						<tr><td>
				   <b> Down Time Reason2</b><select class="form-control" name="dreason2" style="width:60%;">
						<option value=""> Select </option>
						<?php   while($row3=mysqli_fetch_array($res3)){  ?>
						<option value="<?php echo $row3['code'];   ?>"><?php echo $row3['reason'].' : '.$row3['code'];   ?></option>	
						<?php   } ?>
					</select></td><td>
					
					<b>Down Time Qty2 :</b> <input type="text" class="form-control" name="dout2" style="width:60%;"></td>
							</tr><tr><td>
				  <b>  Down Time Reason3</b><select class="form-control" name="dreason3"  style="width:60%;">
						<option value=""> Select </option>
						<?php   while($row4=mysqli_fetch_array($res4)){  ?>
						<option value="<?php echo $row4['code'];   ?>"><?php echo $row4['reason'].' : '.$row4['code'];   ?></option>	
						<?php   } ?>
					</select>
				</td><td>
				
			<b>	Down Time Qty3 : </b><input type="text" class="form-control" name="dout3" style="width:60%;"></td></tr>
				<tr></tr>
				
				</table><br>
				<input type="hidden" name="pretime" value="<?php echo $pretime;  ?>">
				<input type="hidden" name="pph" value="<?php echo $pph;  ?>">
				<input type="hidden" name="team" value="<?php echo $team;  ?>">
				<input type="hidden" name="section" value="<?php echo $section;  ?>"><br>
				<input type="submit" class="btn btn-info" value="Update Downtime">
				
				</form>
			
	
	<?php
	}
?>
<hr>
<a href="<?= getFullURLLevel($_GET['r'],'update_output.php',0,'N'); ?>&secid=<?php  echo $section;  ?>" class="btn btn-primary" style="width:30%;height:auto;">Click Here to Go Back</a>
 </div>
</div> 

</div>
</body>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.js"></script>


</html>