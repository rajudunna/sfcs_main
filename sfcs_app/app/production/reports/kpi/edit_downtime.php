<!-- <html> -->
<!-- <head> -->
<style>
body{
	font-family: "calibri";
}
</style>
<style>
table th{
 background-color:#d8d8d8;
}
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 20px;
    text-align: left;
}
</style>
<!-- <script language="javascript" type="text/javascript" src="../styles/dropdowntabs.js"></script> -->
<!-- <link rel="stylesheet" href="../styles/ddcolortabs.css" type="text/css" media="all" /> -->
<!-- <link rel="stylesheet" href="../table_style.css" type="text/css" media="all" /> -->
<!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->

<!-- </head> -->
<body onload="startTime()">
<?php include("..".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>
<?php 
	
	$team=$_GET['team'];
	$odate=$_GET['dat'];
	
?>
<div class="container">
<?php
//echo $sout.' '.$pph.' '.$team.' '.$section;



	
				$sql2="SELECT * from $bai_pro2.downtime_reason";
				$res2=mysqli_query($link,$sql2);
				$res3=mysqli_query($link,$sql2);
				$res4=mysqli_query($link,$sql2);		
			
			?><div class='panel panel-primary'>
			<div class='panel-heading'>Update DownTime</div>
			<div class='panel-body'>
			<!-- <h2><b>Update Downtime</b></h2><hr> -->
				<form action="<?= getFullURLLevel($_GET['r'],'update_downtime_vx.php',0,'N'); ?>" method="POST">
				<div class='row'>
				<div class='col-sm-3'>
					<label>Hour</label><select class="form-control"  name='hour'>
					
					<option value='08'>8:30</option>
					<option value='09'>9:30</option>
					<option value='10'>10:30</option>
					<option value='11'>11:30</option>
					<option value='12'>12:30</option>
					<option value='13'>1:30</option>
					<option value='14'>2:30</option>
					<option value='15'>3:30</option>
					<option value='16'>4:30</option>
					<option value='17'>5:30</option>
					<option value='18'>6:30</option>
				
					</select>
				</div>
				<div class='col-sm-9'>
					<table class='table table-bordered'>
				<tr>
				
				<td>
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
				
				
				</table><br></div></div>
				<div class='col-md-offset-6'>
				<input type="hidden" name="sout" value="<?php echo $sout;  ?>">
				<input type="hidden" name="pph" value="<?php echo $pph;  ?>">
				<input type="hidden" name="team" value="<?php echo $team;  ?>">
				<input type="hidden" name="ddate" value="<?php echo $odate;  ?>">
				<input type="submit" class="btn btn-info" value="Update Downtime"></div>
				</form>
		</div></div>
		
<hr>



</div>
</body>
<!-- <script src="js/bootstrap.min.js"></script> -->
<!-- <script src="js/jquery.js"></script> -->


<!-- </html> -->