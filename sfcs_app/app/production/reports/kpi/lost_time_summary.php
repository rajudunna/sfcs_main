<!DOCTYPE html>
<?php ini_set('max_execution_time', 360); ?>
<?php
//load the database configuration file

include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");

?>
<!-- <html lang="en"> -->
<!-- <head> -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
  <!-- <script src="js/bootstrap.min.js"></script> -->
  <!-- <script src="js/jquery.js"></script> -->
  
  <!-- <style>
	tr th{
	max-width:100px !important;
	width:100px !important;
	
	
	}
	tr td {
       border-bottom:2px solid #00e5ff !important;
	   padding: 1px !important;
	   
    }
	tr {
      max-height: 35px !important;
      height: 35px !important;
    }
	
  </style> -->
  <!-- <style>
.table1 th{
 background-color:#d8d8d8;
}
.table1 tr{
	   max-height: 20px !important;
      height: 20px !important;

}
.table1, th, td {
    border: 1px solid black;
    border-collapse: collapse;
	margin:0 0 0 0px;
	height:40% !important;
}
</style> -->
<!-- </head> -->
<body>
				<?php   
				   //Starting get process for hourly efficiency report through FR Plan.
				   
				   if($_GET['pro_date']){
				   $frdate=$_GET['pro_date'];
				   $frdate1=$_GET['pro_date1'];
				   
				   $ntime=18;
				   
				   }else{
				   $frdate=date("Y-m-d");
				   $frdate1=date("Y-m-d");
				   $ntime=date('H');
				   }
				?>
<div class="panel panel-primary">
<div class="panel-heading">Lost Hour Summary Report - <?php 
if($frdate==$frdate1){
  echo $frdate;
  }else{
echo $frdate.' - '.$frdate1;
}  ?></div>
<div class="panel-body">

<div class="container">
				
				<form action="index.php" method='GET'>
				<input type='hidden' name='r' value='<?= $_GET["r"]; ?>'>
				<br>
				<div class='col-md-3'>
			From Date:		<input type='text' width="40" data-toggle='datepicker' class="form-control" value='<?php echo $frdate;  ?>' name='pro_date' id='demo1'>
				</div>
				<div class='col-md-3'>
			To Date:	<input type='text' width="40" data-toggle='datepicker' class="form-control" value='<?php echo $frdate1;  ?>' name='pro_date1' id='demo2'>
				</div>
				<div class='col-md-3'>
					<input type='submit' class="btn btn-success" style='margin-top: 16px;' onclick='return verify_date()' value='Filter' name='submit'>
				</div>
				</form>

  <hr>
   
   <?php
   $sql="SELECT * FROM $bai_pro2.fr_data where frdate BETWEEN '$frdate' AND '$frdate1' GROUP BY team ORDER BY team*1";
    //echo $sql;
	$res=mysqli_query($link,$sql); 
	$i=0; 
	
	$query="SELECT distinct code FROM $bai_pro2.downtime_reason WHERE code !='N'";
	$result=mysqli_query($link,$query); 

	$query1="SELECT distinct rdept FROM $bai_pro2.downtime_reason WHERE code !='N'";
	$result1=mysqli_query($link,$query1);
	$resultx=mysqli_query($link,$query1);

   ?>
<div class="table-responsive">
  <table class="table table-bordered">
    <thead>
	<tr style="background-color:#039be5;color:white;">
        <th colspan='4'></th>
		<?php   
		while($row1=mysqli_fetch_array($result1)){
		$dept=$row1['rdept'];
		$sql13="SELECT COUNT(code) AS rccount FROM $bai_pro2.downtime_reason WHERE rdept='$dept'";
		$res13=mysqli_query($link,$sql13);
		$row13=mysqli_fetch_array($res13);
		$i=$row13['rccount'];
		
		echo '<th colspan="'.$i.'">'.$row1['rdept'].'</th>';
		}

		?></tr>
	<tr style="background-color:#039be5;color:white;">
        <th>Team</th>
       
		<th>FR Plan</th>
		<th>Forecast</th>
		
		<th>Pcs</th>
		<?php  
		$tidd=array();
		while($row=mysqli_fetch_array($result)){
			
			$code=$row['code'];
			$tidd[]=$code;
			
		?>
		<th><span style="white-space:nowrap"><?php 
		echo $code;
		

		?></span></th>
		
		<?php   }  ?>
		
      </tr>
   
    </thead>
    <tbody>
	<?php  while($row=mysqli_fetch_array($res)){ 
		
	 // echo $frdate;
    $date=$row['frdate'];
	//echo $date;
	$newDate = date("Y-m-d", strtotime($date));
	//echo $newDate.'<br>';
	
	$team=$row['team'];
	
	
	$sql3="SELECT SUM(fr_qty) AS sumfrqty FROM $bai_pro2.fr_data WHERE frdate BETWEEN '$frdate' AND '$frdate1' AND team='$team'";
	$res3=mysqli_query($link,$sql3);
	
	$sql4="SELECT SUM(qty) AS qty FROM $bai_pro3.line_forecast where date BETWEEN '$frdate' AND '$frdate1' AND module='$team'";
	$res4=mysqli_query($link,$sql4);
	$res5=mysqli_query($link,$sql4);
	
	
	
	
	?>
	<?php
	echo '<tr style="border-bottom:2px solid black;">
		<td>'.$team.'</td>
			
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
			$pcs=$frqty-$forecastqty;
				echo '<td style="background-color:#b2ff59;">'.$pcs.'</td>';
			
			for($i=0;$i<sizeof($tidd);$i++){
				$tdx=$tidd[$i];
				
				$sql12="SELECT SUM(output_qty) AS sumout FROM $bai_pro2.hourly_downtime WHERE date BETWEEN '$frdate' AND '$frdate1' AND team='$team' AND dreason='$tdx'";
				$res12=mysqli_query($link,$sql12);
				if($row12=mysqli_fetch_array($res12)){
				echo '<td><b>'.$row12['sumout'].'</b></td>';
				}
			}
			
	
	?>
	
	
	</tr>
	
	
	
	
	
	<?php    
	
	
	} ?>
      
    </tbody>
  </table>
</div>  
  <br><br>
  
  <table class="table table-bordered" style="width: 400px;">
  <tr style="background-color:#8e24aa;color:white;"><td>Department</td><td>Total Qty</td></tr>
  
  <?php  while($row=mysqli_fetch_array($resultx)){
	$dept=$row['rdept'];

	$query="SELECT SUM(output_qty) AS sout FROM $bai_pro2.hourly_downtime_reason WHERE rdept='$dept' AND date BETWEEN '$frdate' AND '$frdate1'";
	// echo $query;
	$res=mysqli_query($link,$query);
	$rout=mysqli_fetch_array($res);
	$sout=$rout['sout'];
	
  ?>
  <tr style="height : 20px;
margin: 0 0 0 0;"><td><?php  echo $dept;  ?></td><td><?php  echo $sout;  ?></td></tr>
  <?php   }   ?>
  
  
  </table>
  <br><br>
  
  
  
</div>
</div></div>
</body>
</html>
