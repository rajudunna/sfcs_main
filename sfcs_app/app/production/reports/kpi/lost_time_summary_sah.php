<!DOCTYPE html>
<?php ini_set('max_execution_time', 360); ?>
<?php
//load the database configuration file
include("..".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
?>
  <title>Lost Time Summary Report</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--<link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.js"></script>-->
  
  <!--<style>
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
	
  </style>
  <style>
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
</style>-->

<body>

<div class="container">
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
<div class="panel-heading">Lost Hour Summary Report - SAH-<?php 
if($frdate==$frdate1){
  echo $frdate;
  }else{
echo $frdate.' - '.$frdate1;
}  ?></div>
<div class="panel-body">
				<form action='index.php' method='GET'>
				<br>
<input type='hidden' name='r' value='<?= $_GET["r"]; ?>'>
				<div class="col-sm-3">
				Date : <input type='text' data-toggle='datepicker' class="form-control" width="40" value='<?php echo $frdate;  ?>' name='pro_date'>
</div>				<br/>
<div class="col-sm-3">
<input type='text' width="40" class="form-control" data-toggle='datepicker' value='<?php echo $frdate1;  ?>' name='pro_date1'>
</div>
				<input type='submit' class="btn btn-primary" value='Filter'>
				</form>
  <!--<center><h2 style="color:#4a148c;"><b><i>Lost Hour Summary Report - SAH- <?php 
if($frdate==$frdate1){
  echo $frdate;
  }else{
echo $frdate.' - '.$frdate1;
}  ?></i></b></h2></center>-->
  <hr>
   
   <?php
   $sql="SELECT * FROM $bai_pro2.fr_data where frdate BETWEEN '$frdate' AND '$frdate1' GROUP BY team ORDER BY team*1";
    //echo $sql;
	$res=mysqli_query($link,$sql); 
	$i=0; 
	
	
	$query1="SELECT distinct rdept FROM $bai_pro2.downtime_reason WHERE code !='N'";
	$result1=mysqli_query($link,$query1);
	$resultx=mysqli_query($link,$query1);

   ?>
	<div class="table-responsive">
  <table class="table table-bordered">
    <thead>
	<tr  style="background:#6995d6;color:white;">
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
	<tr style="background: #53bb56;color:white;">
        <th>Team</th>
       
		<th>FR Plan</th>
		<th>Forecast</th>
		
		<th>Pcs</th>
		<?php  
		$query="SELECT distinct code FROM $bai_pro2.downtime_reason WHERE code !='N'";
	    $result=mysqli_query($link,$query); 

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
	
	$sql6="SELECT AVG(smv) AS smv FROM $bai_pro2.fr_data where frdate BETWEEN '$frdate' AND '$frdate1' AND team='$team'";
	$res6=mysqli_query($link,$sql6);
	$row6=mysqli_fetch_array($res6);
	$line_smv=$row6['smv'];
	
	
	
	?>
	<?php
	echo '<tr>
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
				echo '<td style="background-color: #b6e4b0;color: #041f08;">'.$pcs.'</td>';
			
			for($i=0;$i<sizeof($tidd);$i++){
				$tdx=$tidd[$i];
				
				$sql12="SELECT SUM(output_qty) AS sumout FROM $bai_pro2.hourly_downtime WHERE date BETWEEN '$frdate' AND '$frdate1' AND team='$team' AND dreason='$tdx'";
				//echo $sql12.'<br>';
				$res12=mysqli_query($link,$sql12);
				$row12=mysqli_fetch_array($res12);
				$sumout=$row12['sumout'];
				if($sumout != ""){
					$sah=round(($sumout*$line_smv)/60);
				}else{
					$sah="";
				}
				
				
				echo '<td><b>'.$sah.'</b></td>';
			}
			
	
	?>
	
	
	</tr>
	
	
	
	
	
	<?php    
	if($team%3==0 && $team<36){
	?>
	<thead>
	<tr style="background:#6995d6;color:white;">
        <th colspan='4'></th>
		<?php
		$query1="SELECT distinct rdept FROM $bai_pro2.downtime_reason WHERE code !='N'";
		$result1=mysqli_query($link,$query1);
		$resultx=mysqli_query($link,$query1);
		
		while($row1=mysqli_fetch_array($result1)){
		$dept=$row1['rdept'];
		$sql13="SELECT COUNT(code) AS rccount FROM $bai_pro2.downtime_reason WHERE rdept='$dept'";
		$res13=mysqli_query($link,$sql13);
		$row13=mysqli_fetch_array($res13);
		$i=$row13['rccount'];
		
		echo '<th colspan="'.$i.'">'.$row1['rdept'].'</th>';
		}

		?></tr>
	<tr style="background: #53bb56;color:white;">
        <th>Team</th>
       
		<th>FR Plan</th>
		<th>Forecast</th>
		
		<th>Pcs</th>
		<?php  
		

		$query="SELECT distinct code FROM $bai_pro2.downtime_reason WHERE code !='N'";
	    $result=mysqli_query($link,$query); 

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
	
	<?php
	}
	} ?>
      
    </tbody>
  </table></div><hr>
  <br><br>
  <div class='col-md-6'>
  <table class='table table-bordered'>
  <tr style="background-color:#6995d6;color:white;"><td>Department</td><td>Total Qty</td><td>Total SAH</td></tr>
  
  <?php  
  $query1="SELECT distinct rdept FROM $bai_pro2.downtime_reason WHERE code !='N'";
	$result1=mysqli_query($link,$query1);
     while($row=mysqli_fetch_array($resultx)){
	$dept=$row['rdept'];
    $dsah1=0;
	$query="SELECT * FROM  hourly_downtime_reason WHERE rdept='$dept' AND date BETWEEN '$frdate' AND '$frdate1'";
	//echo $query;
	$res=mysqli_query($link,$query);
	while($rout=mysqli_fetch_array($res)){
	$sout=$rout['output_qty'];
	$sdate=$rout['date'];
	$team=$rout['team'];
	
	$query1="select AVG(smv) AS smv from $bai_pro2.fr_data where frdate='$sdate' AND team='$team'";
	$res1=mysqli_query($link,$query1);
	$row1=mysqli_fetch_array($res1);
	
	$smv=$row1['smv'];
	$dsah=($smv*$sout)/60;
	$dsah1=$dsah1+$dsah;
	
	}
	$query2="SELECT SUM(output_qty) AS sout FROM hourly_downtime_reason WHERE rdept='$dept' AND date BETWEEN '$frdate' AND '$frdate1'";
	$res2=mysqli_query($link,$query2);
	$rout=mysqli_fetch_array($res2);
	$sout1=$rout['sout'];
	
  ?>
  <tr style="height : 20px;
margin: 0 0 0 0;"><td><?php  echo $dept;  ?></td><td><?php  echo $sout1;  ?></td><td><?php  echo round($dsah1);  ?></td></tr>
  <?php   }   ?>
  
  </table></div>
  <br><br>
  
  
  
</div></div></div>

</body>
