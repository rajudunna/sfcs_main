<html>
<head>
<style>

</style>

<script language="javascript" type="text/javascript" src="../styles/dropdowntabs.js"></script>
<link rel="stylesheet" href="../styles/ddcolortabs.css" type="text/css" media="all" />
<link rel="stylesheet" href="../table_style.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/bootstrap.min.css">

</head>
<body onload="startTime()">
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/config.php',3,'R'));	
 include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/functions.php',3,'R'));   ?>


<?php 
	$section="1";
	$section=$_GET['secid'];
	//echo $section;

	$sql="SELECT * FROM $bai_pro3.sections_db where sec_id='$section'";
	$res= mysqli_query($link,$sql);
	$row=mysqli_fetch_array($res);
	
	$mods=array();
	$mods=$row['sec_mods'];
	$mods=explode(',',$mods);
	$mod1=strtolower($mods[1]);
	$today=date('Y-m-d');
	//echo $mod1;
	
		
			//echo "$value <br>";
		

?>
<div class="container">
 <?php
            $date = date("Y/m/d");
			$date1=date("Y-m-d");
        //    echo "<h4 style='text-align:right;margin-right:10%;'>" . $date . "</h4>";
            ?>

<!--
			<div id="txt" style="text-align: center;font-size: 20px;"></div>
           
			<br>
			-->
<div class="panel panel-primary">
 <div class="panel-heading">Update Hourly Production Output - <?php echo $date;  ?> </div>
  <div class="panel-body">
  <table class="table table-bordered">
   <tr><th>Team</th><th>Style</th><th>Schedule</th><th>Target Pcs/Per Hr</th><th>Output</th><th></th></tr>
   <?php   foreach ($mods as $module) {
		//get styles which run in lines
		$sql1="SELECT distinct style FROM $bai_pro2.fr_data where frdate='$today' AND team='$module'";
		//echo $sql1;
		$res1=mysqli_query($link,$sql1);
		
		$sql2="SELECT distinct schedule FROM $bai_pro2.fr_data where frdate='$today' AND team='$module'";
		//echo $sql1;
		$res2=mysqli_query($link,$sql2);
		$today1="2017-05-23";
		$sql3="SELECT qty FROM $bai_pro3.line_forecast where date='$today' AND module='$module'";
		$res3=mysqli_query($link,$sql3);
	
		$sql4="SELECT hours FROM $bai_pro2.fr_data where frdate='$today' AND team='$module'";
		$res4=mysqli_query($link,$sql4);
		
		$row3=mysqli_fetch_array($res3);
		$row4=mysqli_fetch_array($res4);
		
		$pqty=$row3['qty'];
		
		$hours=$row4['hours'];
		if(!$row4['hours']){
			$hours=10;
		}
		
		$pph=$pqty/$hours;
		
			$otime=date('H');
			$query="SELECT * FROM $bai_pro2.hout where id=(
			SELECT max(id) FROM $bai_pro2.hout WHERE out_date='$date1' AND team='$module')";
				
			$result=mysqli_query($link,$query);
			$query_row=mysqli_fetch_array($result);
			$out_time=$query_row['out_time'];
			$arr = explode(":", "$out_time");
			$last = $arr[0];
			$notime=$otime-1;
			
			if($last!=$otime){
		

   ?>
   <form action="<?= getFullURLLevel($_GET['r'],'save_output.php',0,'N'); ?>" method="post" id="importFrm"> 
 
		<tr>
			<td><?php  echo $module;   ?>
			<input type="hidden" value="<?php  echo $module;   ?>" name="team">
			</td>
			<td><?php  while($row1=mysqli_fetch_array($res1)){
				echo $row1['style'].'<br>';
			
			}   ?></td>
			<td><?php  while($row2=mysqli_fetch_array($res2)){
				echo $row2['schedule'].'<br>';
			
			}   ?>          </td>
				<td><?php echo $pph;   ?>
				<input type="hidden" value="<?php  echo $pph;   ?>" name="pph">
				<input type="hidden" value="<?php  echo $section;   ?>" name="section">
				</td>
			<td><input type="text" class="form-control integer" name="sout" style="width: 120px;"></td>
			<td><input type="submit" class="btn btn-success" value="Update Output" ></td>
			<?php  
				//echo $otime;
			if($otime ==7 or $otime ==8) {?>
			<td><p style="color:red;"></p></td>
			<input type="hidden" name='pretime' value="1">
			<?php  }else{
				
				if($notime!=$last){
					//echo $notime;
					?>
						<td><p style="color:red;"><b>Not Update Output in Previous Hour</b></p></td>		
							<input type="hidden" name='pretime' value="<?php echo $notime;   ?>">
				<?php	}else{ ?>
						<input type="hidden" name='pretime' value="1">	
				<?php   }
				?>
			
			
			<?php
			}
			?>
			
		</tr></form>
			<?php   }else{?>
			
		<tr><td colspan='7'><h4 style='color:#5cb85c;'><b>Team No <?php  echo $module;   ?> This hour output updated</h4></b></td></tr>	
			
	<?php		} }?>
 
	</table>

<hr>
<a href="<?= getFullURLLevel($_GET['r'],'update_production_qty.php',0,'N'); ?>" class="btn btn-primary" style="width:30%;height:auto;">Click Here to Go Back</a>

   </div>
  </div>	

</div>
</body>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.js"></script>
<script>
        function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('txt').innerHTML =
                    "<h1 style='font-size:30px;'>" + h + ":" + m + "</h1>";
            var t = setTimeout(startTime, 500);
        }
        function checkTime(i) {
            if (i < 10) {
                i = "0" + i
            }
            ;  // add zero in front of numbers < 10
            return i;
        }
    </script>


</html>