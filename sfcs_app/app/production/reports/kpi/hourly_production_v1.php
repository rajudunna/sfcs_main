<?php ini_set('max_execution_time', 360); 
// error_reporting(E_WARNING);
?>
<!DOCTYPE html>
<?php
//load the database configuration file
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
?>

  <!-- <title>Hourly Production Report</title> -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="refresh" content="120"/>
  <!--<link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.js"></script>-->
  
  
 <style type="text/css">
 /* table a:link {
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
	border-top:1px solid #286090;
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
} */
</style>
<script>
// $(document).ready(function() {
// 	$('#pro_date').on('keypress',function(e){
// 		var date = $('#pro_date').val();
// 		if(preg_match("([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))",$date)) {
// 			return true;
// 		} else {
// 			return false;
// 		}
// 	});
// });
</script>
<body>

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
<div class="panel-heading">Hourly Production Report- Section Wise <?php  echo $frdate;  ?></div>
<div class="panel-body">
	<form action='index.php' method='GET'>
		<input type='hidden' name='r' value='<?= $_GET["r"]; ?>'>
		<br>
		<div class="col-sm-3">
		<label>Date :</label>
		<input type='text' data-toggle="datepicker" class="form-control" value='<?php echo $frdate;  ?>' name='pro_date' id='pro_date' readonly>
		</div><br/>
		<div class="col-sm-1">
		<input type='submit' class="btn btn-primary" value='Filter'>
		</div>
	</form>
  <!--<center><h2 style="color:#880e4f;"><b><i>Hourly Production Report - <?php  echo $frdate;  ?></i></b></h2></center>-->
  <hr>
   
   <?php
   $sql="SELECT * FROM $bai_pro2.fr_data where frdate='$frdate' GROUP BY team ORDER BY team*1";
	// echo $sql;
	$res=mysqli_query($link,$sql); 
	$i=0; 
	
	//variables get for factory summary----------------------------------------
	$sumfrqty=$sumfrqty1=$sumfrqty2=$sumfrplanqty=0;
	$tout1=$tout2=$tout3=$tout4=$tout5=$tout6=$tout7=$tout8=$tout9=$tout10=$tout11=0;
	$sumpsah=$sumasah=$sumpeff=$sumaeff=$sumbpcs=0;
	$sumpsc=$sumpcsah=0;
	$sumforecastsah=0;
	$sumhitrate=0;
	$sumrequiredqty=0;
	
	
	
	//variables get for Plant A summary----------------------------------------
	$sumfrqtyp1=$sumfrqty1p1=$sumfrqty2p1=$sumfrplanqtyp1=0;
	$tout1p1=$tout2p1=$tout3p1=$tout4p1=$tout5p1=$tout6p1=$tout7p1=$tout8p1=$tout9p1=$tout10p1=$tout11p1=0;
	$sumpsahp1=$sumasahp1=$sumpeffp1=$sumaeffp1=$sumbpcsp1=0;
	$sumpsa=$sumpsaha=0;
	$sumforecastsaha=0;
	$sumhitratea=0;
	$sumrequiredqtya=0;
	
	//variables get for Plant B summary----------------------------------------
	$sumfrqtyp2=$sumfrqty1p2=$sumfrqty2p2=$sumfrplanqtyp2=0;
	$tout1p2=$tout2p2=$tout3p2=$tout4p2=$tout5p2=$tout6p2=$tout7p2=$tout8p2=$tout9p2=$tout10p2=$tout11p2=0;
	$sumpsahp2=$sumasahp2=$sumpeffp2=$sumaeffp2=$sumbpcsp2=0;
	$sumpsb=$sumpsahb=0;
	$sumforecastsahb=0;
	$sumhitrateb=0;
	$sumrequiredqtyb=0;
	
	
	//variables get for Section 1 summary----------------------------------------
	$sumfrqtyp3=$sumfrqty1p3=$sumfrqty3p3=$sumfrplanqtyp3=0;
	$tout1p3=$tout2p3=$tout3p3=$tout4p3=$tout5p3=$tout6p3=$tout7p3=$tout8p3=$tout9p3=$tout10p3=$tout11p3=0;
	$sumpsahp3=$sumasahp3=$sumpeffp3=$sumaeffp3=$sumbpcsp3=0;
	$sumps1=$sumpsah1=0;
	$sumforecastsah1=0;
	$sumhitrate1=0;
	$sumrequiredqty1=0;
	// section 2
	$sumfrqtyp4=$sumfrqty1p4=$sumfrqty4p4=$sumfrplanqtyp4=0;
	$tout1p4=$tout2p4=$tout4p4=$tout4p4=$tout5p4=$tout6p4=$tout7p4=$tout8p4=$tout9p4=$tout10p4=$tout11p4=0;
	$sumpsahp4=$sumasahp4=$sumpeffp4=$sumaeffp4=$sumbpcsp4=0;
	$sumps2=$sumpsah2=0;
	$sumforecastsah2=0;
	$sumhitrate2=0;
	$sumrequiredqty2=0;
	
	// section 3
	$sumfrqtyp5=$sumfrqty1p5=$sumfrqty4p5=$sumfrplanqtyp5=0;
	$tout1p5=$tout2p5=$tout4p5=$tout4p5=$tout5p5=$tout6p5=$tout7p5=$tout8p5=$tout9p5=$tout10p5=$tout11p5=0;
	$sumpsahp5=$sumasahp5=$sumpeffp5=$sumaeffp5=$sumbpcsp5=0;
	$sumps3=$sumpsah3=0;
	$sumforecastsah3=0;
	$sumhitrate3=0;
	$sumrequiredqty3=0;
	// section 4
	$sumfrqtyp6=$sumfrqty1p6=$sumfrqty4p6=$sumfrplanqtyp6=0;
	$tout1p6=$tout2p6=$tout4p6=$tout4p6=$tout5p6=$tout6p6=$tout7p6=$tout8p6=$tout9p6=$tout10p6=$tout11p6=0;
	$sumpsahp6=$sumasahp6=$sumpeffp6=$sumaeffp6=$sumbpcsp6=0;
	$sumps4=$sumpsah4=0;
	$sumforecastsah4=0;
	$sumhitrate4=0;
	$sumrequiredqty4=0;
	// section 5
	$sumfrqtyp7=$sumfrqty1p7=$sumfrqty4p7=$sumfrplanqtyp7=0;
	$tout1p7=$tout2p7=$tout4p7=$tout4p7=$tout5p7=$tout6p7=$tout7p7=$tout8p7=$tout9p7=$tout10p7=$tout11p7=0;
	$sumpsahp7=$sumasahp7=$sumpeffp7=$sumaeffp7=$sumbpcsp7=0;
	$sumps5=$sumpsah5=0;
	$sumforecastsah5=0;
	$sumhitrate5=0;
	$sumrequiredqty5=0;
	// section 6
	$sumfrqtyp8=$sumfrqty1p8=$sumfrqty4p8=$sumfrplanqtyp8=0;
	$tout1p8=$tout2p8=$tout4p8=$tout4p8=$tout5p8=$tout6p8=$tout7p8=$tout8p8=$tout9p8=$tout10p8=$tout11p8=0;
	$sumpsahp8=$sumasahp8=$sumpeffp8=$sumaeffp8=$sumbpcsp8=0;
	$sumps6=$sumpsah6=0;
	$sumforecastsah6=0;
	$sumhitrate6=0;
	$sumrequiredqty6=0;
	// section 7
	$sumfrqtyp9=$sumfrqty1p9=$sumfrqty4p9=$sumfrplanqtyp9=0;
	$tout1p9=$tout2p9=$tout4p9=$tout4p9=$tout5p9=$tout6p9=$tout7p9=$tout8p9=$tout9p9=$tout10p9=$tout11p9=0;
	$sumpsahp9=$sumasahp9=$sumpeffp9=$sumaeffp9=$sumbpcsp9=0;
	$sumps7=$sumpsah7=0;
	$sumforecastsah7=0;
	$sumhitrate7=0;
	$sumrequiredqty7=0;
	// section 8
	$sumfrqtyp10=$sumfrqty1p10=$sumfrqty4p10=$sumfrplanqtyp10=0;
	$tout1p10=$tout2p10=$tout4p10=$tout4p10=$tout5p10=$tout6p10=$tout7p10=$tout8p10=$tout9p10=$tout10p10=$tout11p10=0;
	$sumpsahp10=$sumasahp10=$sumpeffp10=$sumaeffp10=$sumbpcsp10=0;
	$sumps8=$sumpsah8=0;
	$sumforecastsah8=0;
	$sumhitrate8=0;
	$sumrequiredqty8=0;
	// section 9
	$sumfrqtyp11=$sumfrqty1p11=$sumfrqty4p11=$sumfrplanqtyp11=0;
	$tout1p11=$tout2p11=$tout4p11=$tout4p11=$tout5p11=$tout6p11=$tout7p11=$tout8p11=$tout9p11=$tout10p11=$tout11p11=0;
	$sumpsahp11=$sumasahp11=$sumpeffp11=$sumaeffp11=$sumbpcsp11=0;
	$sumps9=$sumpsah9=0;
	$sumforecastsah9=0;
	$sumhitrate9=0;
	$sumrequiredqty9=0;
	// section 10
	$sumfrqtyp12=$sumfrqty1p12=$sumfrqty4p12=$sumfrplanqtyp12=0;
	$tout1p12=$tout2p12=$tout4p12=$tout4p12=$tout5p12=$tout6p12=$tout7p12=$tout8p12=$tout9p12=$tout10p12=$tout11p12=0;
	$sumpsahp12=$sumasahp12=$sumpeffp12=$sumaeffp12=$sumbpcsp12=0;
	$sumps10=$sumpsah10=0;
	$sumforecastsah10=0;
	$sumhitrate10=0;
	$sumrequiredqty10=0;
	// section 11
	$sumfrqtyp13=$sumfrqty1p13=$sumfrqty4p13=$sumfrplanqtyp13=0;
	$tout1p13=$tout2p13=$tout4p13=$tout4p13=$tout5p13=$tout6p13=$tout7p13=$tout8p13=$tout9p13=$tout10p13=$tout11p13=0;
	$sumpsahp13=$sumasahp13=$sumpeffp13=$sumaeffp13=$sumbpcsp13=0;
	$sumps11=$sumpsah11=0;
	$sumforecastsah11=0;
	$sumhitrate11=0;
	$sumrequiredqty11=0;
	// section 12
	$sumfrqtyp14=$sumfrqty1p14=$sumfrqty4p14=$sumfrplanqtyp14=0;
	$tout1p14=$tout2p14=$tout4p14=$tout4p14=$tout5p14=$tout6p14=$tout7p14=$tout8p14=$tout9p14=$tout10p14=$tout11p14=0;
	$sumpsahp14=$sumasahp14=$sumpeffp14=$sumaeffp14=$sumbpcsp14=0;
	$sumps12=$sumpsah12=0;
	$sumforecastsah12=0;
	$sumhitrate12=0;
	$sumrequiredqty12=0;
	
   ?>
 
    <div class="table-area">
	<div class="table-responsive">
  <table class="table table-bordered">
 
    
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
	$res3=mysqli_query($link,$sql3);
	
	$sql4="SELECT qty FROM $bai_pro3.line_forecast where date='$frdate' AND module='$team'";
	$res4=mysqli_query($link,$sql4);
	
	$sql5="SELECT AVG(smv) AS smv FROM $bai_pro2.fr_data where frdate='$frdate' AND team='$team'";
	$res5=mysqli_query($link,$sql5);
	
	$sql6="SELECT status,out_time,qty FROM $bai_pro2.hout where out_date='$frdate' AND team='$team'";
	$res6=mysqli_query($link,$sql6);
		while($row6=mysqli_fetch_array($res6))
		{
			$sout_time=$row6['out_time'];
			$arr = explode(":", "$sout_time");
			$num = $arr[0];
		if($num=='8'){
				$out1=$row6['qty'];
				$status1=$row6['status'];
			}else if($num=='9'){
				$out2=$row6['qty'];
				$status2=$row6['status'];
			}else if($num=='10'){
				$out3=$row6['qty'];
				$status3=$row6['status'];
			}else if($num=='11'){
				$out4=$row6['qty'];
				$status4=$row6['status'];
			}else if($num=='12'){
				$out5=$row6['qty'];
				$status5=$row6['status'];
			}else if($num=='13'){
				$out6=$row6['qty'];
				$status6=$row6['status'];
			}else if($num=='14'){
				$out7=$row6['qty'];
				$status7=$row6['status'];
			}else if($num=='15'){
				$out8=$row6['qty'];
				$status8=$row6['status'];
			}else if($num=='16'){
				$out9=$row6['qty'];
				$status9=$row6['status'];
			}else if($num=='17'){
				$out10=$row6['qty'];
				$status10=$row6['status'];
			}else if($num=='18'){
				$out11=$row6['qty'];
				$status11=$row6['status'];
			}
			// $sub_total += ((int)$item['quantity'] * (int)$product['price']);
		$out=((int)$out1+(int)$out2+(int)$out3+(int)$out4+(int)$out5+(int)$out6+(int)$out7+(int)$out8+(int)$out9+(int)$out10+(int)$out11);
		
		}
		$sqlsc="SELECT SUM(bac_Qty) AS sumqty FROM $bai_pro.bai_log where bac_no='$team' AND bac_date='$frdate'";
	//	echo $sqlsc;
		$resc=mysqli_query($link,$sqlsc);
		if($rowc=mysqli_fetch_array($resc)){
		$sumscqty=$rowc['sumqty'];
		}else{
		$sumcty="";
		}
		
		$nop='24';
	
	
	
	?>
	<thead>
	
	<!-- <tr style="background-color:#286090;color:white;"> -->
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
	  
	  <th rowspan="2">8.30</th>
	  <th>9.30</th>
	  <th>10.30</th>
	  <th>11.30</th>
	  <th>12.30</th>
	  <th>1.30</th>
	  <th>2.30</th>
	  <th>3.30</th>
	  <th>4.30</th>
	  <th>5.30</th>
	  <th>6.30</th>
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
	  <th>Team</th>
	  
	</tr>
  </thead>
  
  <tbody>
	<tr style="border-bottom:2px solid black;">
			<td><?php  echo $team;  ?></td>
			<td><?php  echo $nop;  ?></td>
			<td>
				<?php while($row1=mysqli_fetch_array($res1)){
					echo $row1['style'].'<br>';

					}?>
			</td>
			<td style='display:none;'>	<?php while($row2=mysqli_fetch_array($res2)){
					echo $row2['schedule'].'<br>';

					}?></td>
			<td>
			<?php while($row3=mysqli_fetch_array($res3)){
					$frqty=$row3['sumfrqty'];
					echo $row3['sumfrqty'].'<br>';

					}?>
			</td>
			<td>
			<?php while($row4=mysqli_fetch_array($res4)){
					$forecastqty=$row4['qty'];
					echo $row4['qty'].'<br>';

					}?>
			</td>
			<td>
			<?php while($row5=mysqli_fetch_array($res5)){
					$smv=round($row5['smv'],2);
					echo round($row5['smv'],2).'<br>';

					}?>
			</td>
			<td><?php 
			$hours=$row['hours'];
			echo $row['hours'];  ?></td>
			<td style="background-color:#e1bee7;"><?php  
						$pcsphr=$forecastqty/$hours;
						echo round($pcsphr);
			?></td><?php  if($out1<$pcsphr AND $out1!=""){
							if($status1=="f"){?>
					 <td  style="background-color:#ef9a9a;">  <?php  echo $out1;
							
				  ?>
				  </td>		
							
			<?php				}else{
				 ?>
				  <td  style="background-color:#ff5252;">  <?php  echo $out1;  ?>  </td>
				 <?php } }else{   ?>
				  
				  <td><?php  echo $out1;  ?></td>
				  
				  <?php }
				////////////////////////////////////////////////////////////////////////
				  ?>
				 
				 <?php  if($out2<$pcsphr AND $out2!=""){
							if($status2=="f"){?>
					 <td  style="background-color:#ef9a9a;">  <?php  echo $out2; ?>  </td>		
							
			<?php	}else{
				 ?>
				  <td  style="background-color:#ff5252;">  <?php  echo $out2;  ?>  </td>
				 <?php } }else{ ?>
				  <td> 
				  <?php echo $out2;
							 
				  ?>
				  </td>
				  <?php  }
				//////////////////////////////////////////////////////////////////////////////////////
				  ?>
				 <?php  if($out3<$pcsphr AND $out3!=""){
				 if($status3=="f"){?>
					 <td  style="background-color:#ef9a9a;">  <?php  echo $out3;
							
				  ?>
				  </td>		
							
			     <?php				}else{
				 ?>
				  <td  style="background-color:#ff5252;">  <?php  echo $out3;
							
				  ?>
				  </td>
				 <?php } }else{ ?>
				  <td> 
				  <?php echo $out3;
							 
				  ?>
				  </td>
				  <?php  }
				//////////////////////////////////////////////////////////////////////////////////////
				  ?>
				<?php  if($out4<$pcsphr AND $out4!=""){
				 if($status4=="f"){?>
					 <td  style="background-color:#ef9a9a;">  <?php  echo $out4;
							
				  ?>
				  </td>		
							
			     <?php				}else{
				 ?>
				  <td  style="background-color:#ff5252;">  <?php  echo $out4;
							
				  ?>
				  </td>
				 <?php } }else{ ?>
				  <td> 
				  <?php echo $out4;
							
				  ?>
				  </td>
				  <?php  }
				//////////////////////////////////////////////////////////////////////////////////////
				  ?>
			    <?php  if($out5<$pcsphr AND $out5!=""){
				 if($status5=="f"){?>
					 <td  style="background-color:#ef9a9a;">  <?php  echo $out5;
							
				  ?>
				  </td>		
							
			     <?php				}else{
				 ?>
				  <td  style="background-color:#ff5252;">  <?php  echo $out5;
							
				  ?>
				  </td>
				 <?php }}else{ ?>
				  <td> 
				  <?php echo $out5;
							
				  ?>
				  </td>
				  <?php  }
				//////////////////////////////////////////////////////////////////////////////////////
				  ?>
				<?php  if($out6<$pcsphr AND $out6!=""){
				 if($status6=="f"){?>
					 <td  style="background-color:#ef9a9a;">  <?php  echo $out6;
							
				  ?>
				  </td>		
							
			     <?php				}else{
				 ?>
				  <td  style="background-color:#ff5252;">  <?php  echo $out6;
							
				  ?>
				  </td>
				 <?php } }else{ ?>
				  <td> 
				  <?php echo $out6;
							   
				  ?>
				  </td>
				  <?php  }
				//////////////////////////////////////////////////////////////////////////////////////
				  ?>
			   <?php  if($out7<$pcsphr AND $out7!=""){
				 if($status7=="f"){?>
					 <td  style="background-color:#ef9a9a;">  <?php  echo $out7;
							
				  ?>
				  </td>		
							
			     <?php				}else{
				 ?>
				  <td  style="background-color:#ff5252;">  <?php  echo $out7;
							
				  ?>
				  </td>
				 <?php } }else{ ?>
				  <td> 
				  <?php echo $out7;
							
				  ?>
				  </td>
				  <?php  }
				//////////////////////////////////////////////////////////////////////////////////////
				  ?>
			    <?php  if($out8<$pcsphr AND $out8!=""){
				 if($status8=="f"){?>
					 <td  style="background-color:#ef9a9a;">  <?php  echo $out8;
							
				  ?>
				  </td>		
							
			     <?php				}else{
				 ?>
				  <td  style="background-color:#ff5252;">  <?php  echo $out8;
							
				  ?>
				  </td>
				 <?php } }else{ ?>
				  <td> 
				  <?php echo $out8;
							  
				  ?>
				  </td>
				  <?php  }
				//////////////////////////////////////////////////////////////////////////////////////
				  ?>
			<?php  if($out9<$pcsphr AND $out9!=""){
				 if($status9=="f"){?>
					 <td  style="background-color:#ef9a9a;">  <?php  echo $out9;
							
				  ?>
				  </td>		
							
			     <?php				}else{
				 ?>
				  <td  style="background-color:#ff5252;">  <?php  echo $out9;
							
				  ?>
				  </td>
				 <?php }}else{ ?>
				  <td> 
				  <?php echo $out9;
							  
				  ?>
				  </td>
				  <?php  }
				//////////////////////////////////////////////////////////////////////////////////////
				  ?>
			<?php  if($out10<$pcsphr AND $out10!=""){
				 if($status10=="f"){?>
					 <td  style="background-color:#ef9a9a;">  <?php  echo $out10;
							
				  ?>
				  </td>		
							
			     <?php				}else{
				 ?>
				  <td  style="background-color:#ff5252;">  <?php  echo $out10;
							
				  ?>
				  </td>
				 <?php } }else{ ?>
				  <td> 
				  <?php echo $out10;
							 
				  ?>
				  </td>
				  <?php  }
				//////////////////////////////////////////////////////////////////////////////////////
				  ?>
			    <?php  if($out11<$pcsphr AND $out11!=""){
				 if($status11=="f"){?>
					 <td  style="background-color:#ef9a9a;">  <?php  echo $out11;
							
				  ?>
				  </td>		
							
			     <?php				}else{
				 ?>
				  <td  style="background-color:#ff5252;">  <?php  echo $out11;
							
				  ?>
				  </td>
				 <?php }}else{ ?>
				  <td> 
				  <?php echo $out11;
						
				  ?>
				  </td>
				  <?php  }
				//////////////////////////////////////////////////////////////////////////////////////
				  ?>
	<td style="background-color:#d7ccc8;"><b><?php  echo $out;
			?></b></td>
			<td style="background-color:#d7ccc8;"><b><?php  echo $sumscqty;
			?></b></td>
		<td style="background-color:#d7ccc8;"><b><?php  
		$scanned_sah=round(($sumscqty*$smv)/60);
		echo $scanned_sah;
			?></b></td>
	<td>
		<?php
		$plan_sah=round(($frqty*$smv)/60);
		echo $plan_sah;	
		?>
	</td>
	<td>
		<?php
		$forecast_sah=round(($forecastqty*$smv)/60);
		echo $forecast_sah;	
		?>
	</td>
	<td>
	 <?php  
		$act_sah=round(($out*$smv)/60);
		echo $act_sah;
     ?>
	</td>
	<td>
	<?php
		$sah_diff=$plan_sah-$act_sah;
		echo $sah_diff;
	
	?>
	</td>
	<td><?php
		$plan_eff=round((($forecastqty*$smv)/($nop*$hours*60))*100);
		echo $plan_eff.'%';
		
	?>
	</td>
	<td>
	<?php
		$act_eff_hour=$ntime-8;
	
		if($act_eff_hour<=0){
		$act_eff=round((($out*$smv)/($nop*60))*100);
		}else{
		$act_eff=round((($out*$smv)/($nop*$act_eff_hour*60))*100);
		}
		echo $act_eff.'%';
		
	?></td>
	<td style="display:none;"></td>
	<td>
	<?php
	$balance=$forecastqty-$out;
	echo $balance;
	?>
	</td>
	<td>
	<?php
	if($forecastqty !=0){
	$hitrate=round(($out/$forecastqty)*100);
	}else{
	$hitrate=0;
	}
	echo $hitrate.'%';
	?>
	</td>
	<td>
	<?php
    
	$noh=18-$ntime;
	if($noh!=0){
	$required=($balance)/$noh;
	}else{
	$required=($balance)/1;
	}
	echo round($required);
	?>
	</td>
	<?php  $out=0;  
	$i++;
	?>
	<td><?php  echo $team;  ?></td>
	
	</tr>
	
	
	
	
	<?php   
	//step one get total qty in plant
	$sumfrqty=(int)$sumfrqty+(int)$forecastqty;
	$sumfrplanqty=(int)$sumfrplanqty+(int)$frqty;
	$tout1=(int)$tout1+(int)$out1;
	$tout2=(int)$tout2+(int)$out2;
	$tout3=(int)$tout3+(int)$out3;
	$tout4=(int)$tout4+(int)$out4;
	$tout5=(int)$tout5+(int)$out5;
	$tout6=(int)$tout6+(int)$out6;
	$tout7=(int)$tout7+(int)$out7;
	$tout8=(int)$tout8+(int)$out8;
	$tout9=(int)$tout9+(int)$out9;
	$tout10=(int)$tout10+(int)$out10;
	$tout11=(int)$tout11+(int)$out11;
	
	$toutf=(int)$tout1+(int)$tout2+(int)$tout3+(int)$tout4+(int)$tout5+(int)$tout6+(int)$tout7+(int)$tout8+(int)$tout9+(int)$tout10+(int)$tout11;
	$sumpsah=(int)$sumpsah+(int)$plan_sah;
	$sumasah=(int)$sumasah+(int)$act_sah;
	$sahdiff=(int)$sumpsah-(int)$sumasah;
	$sumbpcs=(int)$sumbpcs+(int)$balance;
	$sumpeff=(int)$sumpeff+(int)$plan_eff;
	$sumaeff=(int)$sumaeff+(int)$act_eff;
	$sumpsc=(int)$sumpsc+(int)$sumscqty;
	$sumpcsah=(int)$sumpcsah+(int)$scanned_sah;
	$sumforecastsah=(int)$sumforecastsah+(int)$forecast_sah;
	$sumhitrate=(int)$sumhitrate+(int)$hitrate;
	$sumrequiredqty=(int)$sumrequiredqty+(int)$required;
	
	//end factory details----------------------------------------------------------
	
	//Start Plant A details--------------------------------------------------------
		if($team<19){
				$sumfrqtyp1=(int)$sumfrqtyp1+(int)$forecastqty;
				$sumfrplanqtyp1=(int)$sumfrplanqtyp1+(int)$frqty;
				$tout1p1=(int)$tout1p1+(int)$out1;
				$tout2p1=(int)$tout2p1+(int)$out2;
				$tout3p1=(int)$tout3p1+(int)$out3;
				$tout4p1=(int)$tout4p1+(int)$out4;
				$tout5p1=(int)$tout5p1+(int)$out5;
				$tout6p1=(int)$tout6p1+(int)$out6;
				$tout7p1=(int)$tout7p1+(int)$out7;
				$tout8p1=(int)$tout8p1+(int)$out8;
				$tout9p1=(int)$tout9p1+(int)$out9;
				$tout10p1=(int)$tout10p1+(int)$out10;
				$tout11p1=(int)$tout11p1+(int)$out11;
				
				$toutfp1=$tout1p1+$tout2p1+$tout3p1+$tout4p1+$tout5p1+$tout6p1+$tout7p1+$tout8p1+$tout9p1+$tout10p1+$tout11p1;
				$sumpsahp1=$sumpsahp1+$plan_sah;
				$sumasahp1=$sumasahp1+$act_sah;
				$sahdiffp1=$sumpsahp1-$sumasahp1;
				$sumbpcsp1=$sumbpcsp1+$balance;
				$sumpeffp1=$sumpeffp1+$plan_eff;
				$sumaeffp1=$sumaeffp1+$act_eff;
				$sumpsa=$sumpsa+$sumscqty;
				$sumpsaha=$sumpsaha+$scanned_sah;
				$sumforecastsaha=$sumforecastsaha+$forecast_sah;
				$sumhitratea=$sumhitratea+$hitrate;
				$sumrequiredqtya=$sumrequiredqtya+$required;
	
			
		}
		if($team<4){     
		$sumfrqtyp3=$sumfrqtyp3+$forecastqty;
				
				$sumfrplanqtyp3=(int)$sumfrplanqtyp2+(int)$frqty;
				$tout1p3=(int)$tout1p3+(int)$out1;
				$tout2p3=(int)$tout2p3+(int)$out2;
				$tout3p3=(int)$tout3p3+(int)$out3;
				$tout4p3=(int)$tout4p3+(int)$out4;
				$tout5p3=(int)$tout5p3+(int)$out5;
				$tout6p3=(int)$tout6p3+(int)$out6;
				$tout7p3=(int)$tout7p3+(int)$out7;
				$tout8p3=(int)$tout8p3+(int)$out8;
				$tout10p3=(int)$tout10p3+(int)$out10;
				$tout11p3=(int)$tout11p3+(int)$out11;
				$sumpsah1=(int)$sumpsah1+(int)$scanned_sah;
				
				$toutfp3=$tout1p3+$tout2p3+$tout3p3+$tout4p3+$tout5p3+$tout6p3+$tout7p3+$tout8p3+$tout9p3+$tout10p3+$tout11p3;
				$sumpsahp3=$sumpsahp3+$plan_sah;
				$sumasahp3=$sumasahp3+$act_sah;
				$sahdiffp3=$sumpsahp3-$sumasahp3;
				$sumbpcsp3=$sumbpcsp3+$balance;
				$sumpeffp3=$sumpeffp3+$plan_eff;
				$sumaeffp3=$sumaeffp3+$act_eff;
				$sumps1=$sumps1+$sumscqty;
				$sumforecastsah1=$sumforecastsah1+$forecast_sah;
				$sumhitrate1=$sumhitrate1+$hitrate;
				$sumrequiredqty1=$sumrequiredqty1+$required;
		
		} //sec2
		if($team>3 && $team <7){
				$sumfrqtyp4=(int)$sumfrqtyp4+(int)$forecastqty;	
				$sumfrplanqtyp4=(int)$sumfrplanqtyp4+(int)$frqty;
				$tout1p4=(int)$tout1p4+(int)$out1;
				$tout2p4=(int)$tout2p4+(int)$out2;
				$tout3p4=(int)$tout3p4+(int)$out3;
				$tout4p4=(int)$tout4p4+(int)$out4;
				$tout5p4=(int)$tout5p4+(int)$out5;
				$tout6p4=(int)$tout6p4+(int)$out6;
				$tout7p4=(int)$tout7p4+(int)$out7;
				$tout8p4=(int)$tout8p4+(int)$out8;
				$tout9p4=(int)$tout9p4+(int)$out9;
				$tout10p4=(int)$tout10p4+(int)$out10;
				$tout11p4=(int)$tout11p4+(int)$out11;
				$sumpsah2=(int)$sumpsah2+(int)$scanned_sah;
				
				$toutfp4=$tout1p4+$tout2p4+$tout3p4+$tout4p4+$tout5p4+$tout6p4+$tout7p4+$tout8p4+$tout9p4+$tout10p4+$tout11p4;
				$sumpsahp4=$sumpsahp4+$plan_sah;
				$sumasahp4=$sumasahp4+$act_sah;
				$sahdiffp4=$sumpsahp4-$sumasahp4;
				$sumbpcsp4=$sumbpcsp4+$balance;
				$sumpeffp4=$sumpeffp4+$plan_eff;
				$sumaeffp4=$sumaeffp4+$act_eff;
				$sumps2=$sumps2+$sumscqty;
				$sumforecastsah2=$sumforecastsah2+$forecast_sah;
				$sumhitrate2=$sumhitrate2+$hitrate;
				$sumrequiredqty2=$sumrequiredqty2+$required;
		//sec3
		}if($team>6 && $team <10){
				$sumfrqtyp5=(int)$sumfrqtyp5+(int)$forecastqty;	
				$sumfrplanqtyp5=(int)$sumfrplanqtyp5+(int)$frqty;
				$tout1p5=(int)$tout1p5+(int)$out1;
				$tout2p5=(int)$tout2p5+(int)$out2;
				$tout3p5=(int)$tout3p5+(int)$out3;
				$tout4p5=(int)$tout4p5+(int)$out4;
				$tout5p5=(int)$tout5p5+(int)$out5;
				$tout6p5=(int)$tout6p5+(int)$out6;
				$tout7p5=(int)$tout7p5+(int)$out7;
				$tout8p5=(int)$tout8p5+(int)$out8;
				$tout9p5=(int)$tout9p5+(int)$out9;
				$tout10p5=(int)$tout10p5+(int)$out10;
				$tout11p5=(int)$tout11p5+(int)$out11;
				$sumpsah3=(int)$sumpsah3+(int)$scanned_sah;
				
				$toutfp5=$tout1p5+$tout2p5+$tout3p5+$tout4p5+$tout5p5+$tout6p5+$tout7p5+$tout8p5+$tout9p5+$tout10p5+$tout11p5;
				$sumpsahp5=$sumpsahp5+$plan_sah;
				$sumasahp5=$sumasahp5+$act_sah;
				$sahdiffp5=$sumpsahp5-$sumasahp5;
				$sumbpcsp5=$sumbpcsp5+$balance;
				$sumpeffp5=$sumpeffp5+$plan_eff;
				$sumaeffp5=$sumaeffp5+$act_eff;
				$sumps3=$sumps3+$sumscqty;
				$sumforecastsah3=$sumforecastsah3+$forecast_sah;
				$sumhitrate3=$sumhitrate3+$hitrate;
				$sumrequiredqty3=$sumrequiredqty3+$required;
		//sec4
		}if($team>9 && $team <13){
				$sumfrqtyp6=(int)$sumfrqtyp6+(int)$forecastqty;	
				$sumfrplanqtyp6=(int)$sumfrplanqtyp6+(int)$frqty;
				$tout1p6=(int)$tout1p6+(int)$out1;
				$tout2p6=(int)$tout2p6+(int)$out2;
				$tout3p6=(int)$tout3p6+(int)$out3;
				$tout4p6=(int)$tout4p6+(int)$out4;
				$tout5p6=(int)$tout5p6+(int)$out5;
				$tout6p6=(int)$tout6p6+(int)$out6;
				$tout7p6=(int)$tout7p6+(int)$out7;
				$tout8p6=(int)$tout8p6+(int)$out8;
				$tout9p6=(int)$tout9p6+(int)$out9;
				$tout10p6=(int)$tout10p6+(int)$out10;
				$tout11p6=(int)$tout11p6+(int)$out11;
				$sumpsah4=(int)$sumpsah4+(int)$scanned_sah;
				
				$toutfp6=$tout1p6+$tout2p6+$tout3p6+$tout4p6+$tout5p6+$tout6p6+$tout7p6+$tout8p6+$tout9p6+$tout10p6+$tout11p6;
				$sumpsahp6=$sumpsahp6+$plan_sah;
				$sumasahp6=$sumasahp6+$act_sah;
				$sahdiffp6=$sumpsahp6-$sumasahp6;
				$sumbpcsp6=$sumbpcsp6+$balance;
				$sumpeffp6=$sumpeffp6+$plan_eff;
				$sumaeffp6=$sumaeffp6+$act_eff;
				$sumps4=$sumps4+$sumscqty;
				$sumforecastsah4=$sumforecastsah4+$forecast_sah;
				$sumhitrate4=$sumhitrate4+$hitrate;
				$sumrequiredqty4=$sumrequiredqty4+$required;
				
				
		//sec5
		}if($team>12 && $team <16){
				$sumfrqtyp7=$sumfrqtyp7+$forecastqty;	
				$sumfrplanqtyp7=$sumfrplanqtyp7+$frqty;
				$tout1p7=$tout1p7+(int)$out1;
				$tout2p7=$tout2p7+(int)$out2;
				$tout3p7=$tout3p7+(int)$out3;
				$tout4p7=$tout4p7+(int)$out4;
				$tout5p7=$tout5p7+(int)$out5;
				$tout6p7=$tout6p7+(int)$out6;
				$tout7p7=$tout7p7+(int)$out7;
				$tout8p7=$tout8p7+(int)$out8;
				$tout9p7=$tout9p7+(int)$out9;
				$tout10p7=$tout10p7+(int)$out10;
				$tout11p7=$tout11p7+(int)$out11;
				$sumpsah5=$sumpsah5+$scanned_sah;
				
				$toutfp7=$tout1p7+$tout2p7+$tout3p7+$tout4p7+$tout5p7+$tout6p7+$tout7p7+$tout8p7+$tout9p7+$tout10p7+$tout11p7;
				$sumpsahp7=$sumpsahp7+$plan_sah;
				$sumasahp7=$sumasahp7+$act_sah;
				$sahdiffp7=$sumpsahp7-$sumasahp7;
				$sumbpcsp7=$sumbpcsp7+$balance;
				$sumpeffp7=$sumpeffp7+$plan_eff;
				$sumaeffp7=$sumaeffp7+$act_eff;
				$sumps5=$sumps5+$sumscqty;
				$sumforecastsah5=$sumforecastsah5+$forecast_sah;
				$sumhitrate5=$sumhitrate5+$hitrate;
				$sumrequiredqty5=$sumrequiredqty5+$required;
		//sec6
		}if($team>15 && $team <19){
		        $sumfrqtyp8=(int)$sumfrqtyp8+(int)$forecastqty;	
				$sumfrplanqtyp8=(int)$sumfrplanqtyp8+(int)$frqty;
				$tout1p8=(int)$tout1p8+(int)$out1;
				$tout2p8=(int)$tout2p8+(int)$out2;
				$tout3p8=(int)$tout3p8+(int)$out3;
				$tout4p8=(int)$tout4p8+(int)$out4;
				$tout5p8=(int)$tout5p8+(int)$out5;
				$tout6p8=(int)$tout6p8+(int)$out6;
				$tout7p8=(int)$tout7p8+(int)$out7;
				$tout8p8=(int)$tout8p8+(int)$out8;
				$tout9p8=(int)$tout9p8+(int)$out9;
				$tout10p8=(int)$tout10p8+(int)$out10;
				$tout11p8=(int)$tout11p8+(int)$out11;
				$sumpsah6=(int)$sumpsah6+(int)$scanned_sah;
				
				$toutfp8=$tout1p8+$tout2p8+$tout3p8+$tout4p8+$tout5p8+$tout6p8+$tout7p8+$tout8p8+$tout9p8+$tout10p8+$tout11p8;
				$sumpsahp8=$sumpsahp8+$plan_sah;
				$sumasahp8=$sumasahp8+$act_sah;
				$sahdiffp8=$sumpsahp8-$sumasahp8;
				$sumbpcsp8=$sumbpcsp8+$balance;
				$sumpeffp8=$sumpeffp8+$plan_eff;
				$sumaeffp8=$sumaeffp8+$act_eff;
				$sumps6=$sumps6+$sumscqty;
				$sumforecastsah6=$sumforecastsah6+$forecast_sah;
				$sumhitrate6=$sumhitrate6+$hitrate;
				$sumrequiredqty6=$sumrequiredqty6+$required;
		//sec7
		}if($team>18 && $team <22){
		        $sumfrqtyp9=$sumfrqtyp9+$forecastqty;	
				$sumfrplanqtyp9=$sumfrplanqtyp9+$frqty;
				$tout1p9=$tout1p9+(int)$out1;
				$tout2p9=$tout2p9+(int)$out2;
				$tout3p9=$tout3p9+(int)$out3;
				$tout4p9=$tout4p9+(int)$out4;
				$tout5p9=$tout5p9+(int)$out5;
				$tout6p9=$tout6p9+(int)$out6;
				$tout7p9=$tout7p9+(int)$out7;
				$tout8p9=$tout8p9+(int)$out8;
				$tout9p9=$tout9p9+(int)$out9;
				$tout10p9=$tout10p9+(int)$out10;
				$tout11p9=$tout11p9+(int)$out11;
				$sumpsah7=$sumpsah7+(int)$scanned_sah;
				
				$toutfp9=$tout1p9+$tout2p9+$tout3p9+$tout4p9+$tout5p9+$tout6p9+$tout7p9+$tout8p9+$tout9p9+$tout10p9+$tout11p9;
				$sumpsahp9=$sumpsahp9+$plan_sah;
				$sumasahp9=$sumasahp9+$act_sah;
				$sahdiffp9=$sumpsahp9-$sumasahp9;
				$sumbpcsp9=$sumbpcsp9+$balance;
				$sumpeffp9=$sumpeffp9+$plan_eff;
				$sumaeffp9=$sumaeffp9+$act_eff;
				$sumps7=$sumps7+$sumscqty;
				$sumforecastsah7=$sumforecastsah7+$forecast_sah;
				$sumhitrate7=$sumhitrate7+$hitrate;
				$sumrequiredqty7=$sumrequiredqty7+$required;
		//sec8
		}if($team>21 && $team <25){
		        $sumfrqtyp10=$sumfrqtyp10+$forecastqty;	
				$sumfrplanqtyp10=$sumfrplanqtyp10+$frqty;
				$tout1p10=$tout1p10+(int)$out1;
				$tout2p10=$tout2p10+(int)$out2;
				$tout3p10=$tout3p10+(int)$out3;
				$tout4p10=$tout4p10+(int)$out4;
				$tout5p10=$tout5p10+(int)$out5;
				$tout6p10=$tout6p10+(int)$out6;
				$tout7p10=$tout7p10+(int)$out7;
				$tout8p10=$tout8p10+(int)$out8;
				$tout9p10=$tout9p10+(int)$out9;
				$tout10p10=$tout10p10+(int)$out10;
				$tout11p10=$tout11p10+(int)$out11;
				$sumpsah8=$sumpsah8+$scanned_sah;
				
				$toutfp10=$tout1p10+$tout2p10+$tout3p10+$tout4p10+$tout5p10+$tout6p10+$tout7p10+$tout8p10+$tout9p10+$tout10p10+$tout11p10;
				$sumpsahp10=$sumpsahp10+$plan_sah;
				$sumasahp10=$sumasahp10+$act_sah;
				$sahdiffp10=$sumpsahp10-$sumasahp10;
				$sumbpcsp10=$sumbpcsp10+$balance;
				$sumpeffp10=$sumpeffp10+$plan_eff;
				$sumaeffp10=$sumaeffp10+$act_eff;
				$sumps8=$sumps8+$sumscqty;
			
				$sumforecastsah8=$sumforecastsah8+$forecast_sah;
				$sumhitrate8=$sumhitrate8+$hitrate;
				$sumrequiredqty8=$sumrequiredqty8+$required;
		
		}
		//sec9
		if($team>24 && $team <28){
		      	$sumfrqtyp11=$sumfrqtyp11+$forecastqty;	
				$sumfrplanqtyp11=$sumfrplanqtyp11+$frqty;
				$tout1p11=$tout1p11+(int)$out1;
				$tout2p11=$tout2p11+(int)$out2;
				$tout3p11=$tout3p11+(int)$out3;
				$tout4p11=$tout4p11+(int)$out4;
				$tout5p11=$tout5p11+(int)$out5;
				$tout6p11=$tout6p11+(int)$out6;
				$tout7p11=$tout7p11+(int)$out7;
				$tout8p11=$tout8p11+(int)$out8;
				$tout9p11=$tout9p11+(int)$out9;
				$tout10p11=$tout10p11+(int)$out10;
				$tout11p11=$tout11p11+(int)$out11;
				$sumpsah9=$sumpsah9+$scanned_sah;
				
				$toutfp11=$tout1p11+$tout2p11+$tout3p11+$tout4p11+$tout5p11+$tout6p11+$tout7p11+$tout8p11+$tout9p11+$tout10p11+$tout11p11;
				$sumpsahp11=$sumpsahp11+$plan_sah;
				$sumasahp11=$sumasahp11+$act_sah;
				$sahdiffp11=$sumpsahp11-$sumasahp11;
				$sumbpcsp11=$sumbpcsp11+$balance;
				$sumpeffp11=$sumpeffp11+$plan_eff;
				$sumaeffp11=$sumaeffp11+$act_eff;
				$sumps9=$sumps9+$sumscqty;
				$sumforecastsah9=$sumforecastsah9+$forecast_sah;
				$sumhitrate9=$sumhitrate9+$hitrate;
				$sumrequiredqty9=$sumrequiredqty9+$required;
		
		//sec 10
		}if($team>27 && $team <31){
		        				$sumfrqtyp12=$sumfrqtyp12+$forecastqty;	
				$sumfrplanqtyp12=$sumfrplanqtyp12+$frqty;
				$tout1p12=$tout1p12+(int)$out1;
				$tout2p12=$tout2p12+(int)$out2;
				$tout3p12=$tout3p12+(int)$out3;
				$tout4p12=$tout4p12+(int)$out4;
				$tout5p12=$tout5p12+(int)$out5;
				$tout6p12=$tout6p12+(int)$out6;
				$tout7p12=$tout7p12+(int)$out7;
				$tout8p12=$tout8p12+(int)$out8;
				$tout9p12=$tout9p12+(int)$out9;
				$tout10p12=$tout10p12+(int)$out10;
				$tout11p12=$tout11p12+(int)$out11;
				$sumpsah10=$sumpsah10+$scanned_sah;
				
				$toutfp12=$tout1p12+$tout2p12+$tout3p12+$tout4p12+$tout5p12+$tout6p12+$tout7p12+$tout8p12+$tout9p12+$tout10p12+$tout11p12;
				$sumpsahp12=$sumpsahp12+$plan_sah;
				$sumasahp12=$sumasahp12+$act_sah;
				$sahdiffp12=$sumpsahp12-$sumasahp12;
				$sumbpcsp12=$sumbpcsp12+$balance;
				$sumpeffp12=$sumpeffp12+$plan_eff;
				$sumaeffp12=$sumaeffp12+$act_eff;
				$sumps10=$sumps10+$sumscqty;
				$sumforecastsah10=$sumforecastsah10+$forecast_sah;
				$sumhitrate10=$sumhitrate10+$hitrate;
				$sumrequiredqty10=$sumrequiredqty10+$required;
		
		}
		//sec 11
		if($team>30 && $team <34){
		       				$sumfrqtyp13=$sumfrqtyp13+$forecastqty;	
				$sumfrplanqtyp13=$sumfrplanqtyp13+$frqty;
				$tout1p13=$tout1p13+(int)$out1;
				$tout2p13=$tout2p13+(int)$out2;
				$tout3p13=$tout3p13+(int)$out3;
				$tout4p13=$tout4p13+(int)$out4;
				$tout5p13=$tout5p13+(int)$out5;
				$tout6p13=$tout6p13+(int)$out6;
				$tout7p13=$tout7p13+(int)$out7;
				$tout8p13=$tout8p13+(int)$out8;
				$tout9p13=$tout9p13+(int)$out9;
				$tout10p13=$tout10p13+(int)$out10;
				$tout11p13=$tout11p13+(int)$out11;
				$sumpsah11=$sumpsah11+$scanned_sah;
				
				$toutfp13=$tout1p13+$tout2p13+$tout3p13+$tout4p13+$tout5p13+$tout6p13+$tout7p13+$tout8p13+$tout9p13+$tout10p13+$tout11p13;
				$sumpsahp13=$sumpsahp13+$plan_sah;
				$sumasahp13=$sumasahp13+$act_sah;
				$sahdiffp13=$sumpsahp13-$sumasahp13;
				$sumbpcsp13=$sumbpcsp13+$balance;
				$sumpeffp13=$sumpeffp13+$plan_eff;
				$sumaeffp13=$sumaeffp13+$act_eff;
				$sumps11=$sumps11+$sumscqty;
				
				$sumforecastsah11=$sumforecastsah11+$forecast_sah;
				$sumhitrate11=$sumhitrate11+$hitrate;
				$sumrequiredqty11=$sumrequiredqty111+$required;
		
		}
		//sec 12
		if($team>33 && $team<37){
                $sumfrqtyp14=$sumfrqtyp14+$forecastqty;	
				$sumfrplanqtyp14=$sumfrplanqtyp14+$frqty;
				$tout1p14=$tout1p14+(int)$out1;
				$tout2p14=$tout2p14+(int)$out2;
				$tout3p14=$tout3p14+(int)$out3;
				$tout4p14=$tout4p14+(int)$out4;
				$tout5p14=$tout5p14+(int)$out5;
				$tout6p14=$tout6p14+(int)$out6;
				$tout7p14=$tout7p14+(int)$out7;
				$tout8p14=$tout8p14+(int)$out8;
				$tout9p14=$tout9p14+(int)$out9;
				$tout10p14=$tout10p14+(int)$out10;
				$tout11p14=$tout11p14+(int)$out11;
				$sumpsah12=$sumpsah12+$scanned_sah;
				
				$toutfp14=$tout1p14+$tout2p14+$tout3p14+$tout4p14+$tout5p14+$tout6p14+$tout7p14+$tout8p14+$tout9p14+$tout10p14+$tout11p14;
				$sumpsahp14=$sumpsahp14+$plan_sah;
				$sumasahp14=$sumasahp14+$act_sah;
				$sahdiffp14=$sumpsahp14-$sumasahp14;
				$sumbpcsp14=$sumbpcsp14+$balance;
				$sumpeffp14=$sumpeffp14+$plan_eff;
				$sumaeffp14=$sumaeffp14+$act_eff;
				$sumps12=$sumps12+$sumscqty;
		
				$sumforecastsah12=$sumforecastsah12+$forecast_sah;
				$sumhitrate12=$sumhitrate12+$hitrate;
				$sumrequiredqty12=$sumrequiredqty12+$required;
		
		}
		if($team>=19){
			//	echo $out1.' : '.$tout1p2.'<br>';
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
				$sumpsb=$sumpsb+$sumscqty;
				$sumpsahb=$sumpsahb+$scanned_sah;
			   // echo $out1.' : '.$tout1p2.'<br>';
			   $sumforecastsahb=$sumforecastsahb+$forecast_sah;
				$sumhitrateb=$sumhitrateb+$hitrate;
				$sumrequiredqtyb=$sumrequiredqtyb+$required;
			
			//sec1
		}
		
	
	
	
	
	
	
	
  if($team==3){ ?>
	<tr style="background-color:#c5e1a5;font-weight: bold;"><td style="font-size:x-small;">Section 1</td><td></td><td></td><td><?php  echo $sumfrplanqtyp3; ?></td><td><?php  echo $sumfrqtyp3; ?></td><td></td><td></td><td></td><td><?php echo $tout1p3;  ?> </td><td><?php echo $tout2p3;  ?></td><td><?php echo $tout3p3;  ?></td><td><?php echo $tout4p3;  ?></td><td><?php echo $tout5p3;  ?></td><td><?php echo $tout6p3;  ?></td><td><?php echo $tout7p3;  ?></td><td><?php echo $tout8p3;  ?></td><td><?php echo $tout9p3;  ?></td><td><?php echo $tout10p3;  ?></td><td><?php echo $tout11p3;  ?></td><td><?php echo $toutfp3;  ?></td><td><?php echo $sumps1;  ?></td><td><?php echo $sumpsah1;  ?></td><td><?php echo $sumpsahp3;  ?></td><td><?php echo $sumforecastsah1;  ?></td><td><?php echo $sumasahp3;  ?></td><td><?php echo $sahdiffp3;  ?></td><td><?php echo round($sumpeffp3/$i).'%';  ?></td><td><?php echo round($sumaeffp3/$i).'%';  ?></td><td><?php echo $sumbpcsp3;  ?></td><td><?php echo round($sumhitrate1/3);  ?>%</td><td><?php echo $sumrequiredqty1;  ?></td></tr>
	
	
	<?php
 } 
 if($team==6){?>
	<tr style="background-color:#c5e1a5;font-weight: bold;" id='sec'><td style="font-size:x-small;">Section 2</td><td></td><td></td><td><?php  echo $sumfrplanqtyp4; ?></td><td><?php  echo $sumfrqtyp4; ?></td><td></td><td></td><td></td><td><?php echo $tout1p4;  ?> </td><td><?php echo $tout2p4;  ?></td><td><?php echo $tout3p4;  ?></td><td><?php echo $tout4p4;  ?></td><td><?php echo $tout5p4;  ?></td><td><?php echo $tout6p4;  ?></td><td><?php echo $tout7p4;  ?></td><td><?php echo $tout8p4;  ?></td><td><?php echo $tout9p4;  ?></td><td><?php echo $tout10p4;  ?></td><td><?php echo $tout11p4;  ?></td><td><?php echo $toutfp4;  ?></td><td><?php echo $sumps2;  ?></td><td><?php echo $sumpsah2;  ?></td><td><?php echo $sumpsahp4;  ?></td><td><?php echo $sumforecastsah2;  ?></td><td><?php echo $sumasahp4;  ?></td><td><?php echo $sahdiffp4;  ?></td><td><?php echo round($sumpeffp4/$i).'%';  ?></td><td><?php echo round($sumaeffp4/$i).'%';  ?></td><td><?php echo $sumbpcsp4;  ?></td><td><?php echo round($sumhitrate2/3);  ?>%</td><td><?php echo $sumrequiredqty2;  ?></td></tr>
	
	
 <?php
 }
 if($team==9){?>
	<tr style="background-color:#c5e1a5;font-weight: bold;"><td style="font-size:x-small;">Section 3</td><td></td><td></td><td><?php  echo $sumfrplanqtyp5; ?></td><td><?php  echo $sumfrqtyp5; ?></td><td></td><td></td><td></td><td><?php echo $tout1p5;  ?> </td><td><?php echo $tout2p5;  ?></td><td><?php echo $tout3p5;  ?></td><td><?php echo $tout4p5;  ?></td><td><?php echo $tout5p5;  ?></td><td><?php echo $tout6p5;  ?></td><td><?php echo $tout7p5;  ?></td><td><?php echo $tout8p5;  ?></td><td><?php echo $tout9p5;  ?></td><td><?php echo $tout10p5;  ?></td><td><?php echo $tout11p5;  ?></td><td><?php echo $toutfp5;  ?></td><td><?php echo $sumps3;  ?></td><td><?php echo $sumpsah3;  ?></td><td><?php echo $sumpsahp5;  ?></td><td><?php echo $sumforecastsah3;  ?></td><td><?php echo $sumasahp5;  ?></td><td><?php echo $sahdiffp5;  ?></td><td><?php echo round($sumpeffp5/$i).'%';  ?></td><td><?php echo round($sumaeffp5/$i).'%';  ?></td><td><?php echo $sumbpcsp5;  ?></td><td><?php echo round($sumhitrate3/3);  ?>%</td><td><?php echo $sumrequiredqty3;  ?></td></tr>
	
	
 <?php
 }
 if($team==12){?>
		<tr style="background-color:#c5e1a5;font-weight: bold;"><td style="font-size:x-small;">Section 4</td><td></td><td></td><td><?php  echo $sumfrplanqtyp6; ?></td><td><?php  echo $sumfrqtyp6; ?></td><td></td><td></td><td></td><td><?php echo $tout1p6;  ?> </td><td><?php echo $tout2p6;  ?></td><td><?php echo $tout3p6;  ?></td><td><?php echo $tout4p6;  ?></td><td><?php echo $tout5p6;  ?></td><td><?php echo $tout6p6;  ?></td><td><?php echo $tout7p6;  ?></td><td><?php echo $tout8p6;  ?></td><td><?php echo $tout9p6;  ?></td><td><?php echo $tout10p6;  ?></td><td><?php echo $tout11p6;  ?></td><td><?php echo $toutfp6;  ?></td><td><?php echo $sumps4;  ?></td><td><?php echo $sumpsah4;  ?></td><td><?php echo $sumpsahp6;  ?></td><td><?php echo $sumforecastsah4;  ?></td><td><?php echo $sumasahp6;  ?></td><td><?php echo $sahdiffp6;  ?></td><td><?php echo round($sumpeffp6/$i).'%';  ?></td><td><?php echo round($sumaeffp6/$i).'%';  ?></td><td><?php echo $sumbpcsp6;  ?></td><td><?php echo round($sumhitrate4/3);  ?>%</td><td><?php echo $sumrequiredqty4;  ?></td></tr>
	
 <?php
 }
 if($team==15){?>
		<tr style="background-color:#c5e1a5;font-weight: bold;"><td style="font-size:x-small;">Section 5</td><td></td><td></td><td><?php  echo $sumfrplanqtyp7; ?></td><td><?php  echo $sumfrqtyp7; ?></td><td></td><td></td><td></td><td><?php echo $tout1p7;  ?> </td><td><?php echo $tout2p7;  ?></td><td><?php echo $tout3p7;  ?></td><td><?php echo $tout4p7;  ?></td><td><?php echo $tout5p7;  ?></td><td><?php echo $tout6p7;  ?></td><td><?php echo $tout7p7;  ?></td><td><?php echo $tout8p7;  ?></td><td><?php echo $tout9p7;  ?></td><td><?php echo $tout10p7;  ?></td><td><?php echo $tout11p7;  ?></td><td><?php echo $toutfp7;  ?></td><td><?php echo $sumps5;  ?></td><td><?php echo $sumpsah5;  ?></td><td><?php echo $sumpsahp7;  ?></td><td><?php echo $sumforecastsah5;  ?></td><td><?php echo $sumasahp7;  ?></td><td><?php echo $sahdiffp7;  ?></td><td><?php echo round($sumpeffp7/$i).'%';  ?></td><td><?php echo round($sumaeffp7/$i).'%';  ?></td><td><?php echo $sumbpcsp7;  ?></td><td><?php echo round($sumhitrate5/3);  ?>%</td><td><?php echo $sumrequiredqty5;  ?></td></tr>
	
 <?php
 }
 if($team==18){?>
		<tr style="background-color:#c5e1a5;font-weight: bold;"><td style="font-size:x-small;">Section 6</td><td></td><td></td><td><?php  echo $sumfrplanqtyp8; ?></td><td><?php  echo $sumfrqtyp8; ?></td><td></td><td></td><td></td><td><?php echo $tout1p8;  ?> </td><td><?php echo $tout2p8;  ?></td><td><?php echo $tout3p8;  ?></td><td><?php echo $tout4p8;  ?></td><td><?php echo $tout5p8;  ?></td><td><?php echo $tout6p8;  ?></td><td><?php echo $tout7p8;  ?></td><td><?php echo $tout8p8;  ?></td><td><?php echo $tout9p8;  ?></td><td><?php echo $tout10p8;  ?></td><td><?php echo $tout11p8;  ?></td><td><?php echo $toutfp8;  ?></td><td><?php echo $sumps6;  ?></td><td><?php echo $sumpsah6;  ?></td><td><?php echo $sumpsahp8;  ?></td><td><?php echo $sumforecastsah6;  ?></td><td><?php echo $sumasahp8;  ?></td><td><?php echo $sahdiffp8;  ?></td><td><?php echo round($sumpeffp8/$i).'%';  ?></td><td><?php echo round($sumaeffp8/$i).'%';  ?></td><td><?php echo $sumbpcsp8;  ?></td><td><?php echo round($sumhitrate6/3);  ?>%</td><td><?php echo $sumrequiredqty6;  ?></td></tr>
	
 <?php
 }
 if($team==21){?>
	<tr style="background-color:#c5e1a5;font-weight: bold;"><td style="font-size:x-small;">Section 7</td><td></td><td></td><td><?php  echo $sumfrplanqtyp9; ?></td><td><?php  echo $sumfrqtyp9; ?></td><td></td><td></td><td></td><td><?php echo $tout1p9;  ?> </td><td><?php echo $tout2p9;  ?></td><td><?php echo $tout3p9;  ?></td><td><?php echo $tout4p9;  ?></td><td><?php echo $tout5p9;  ?></td><td><?php echo $tout6p9;  ?></td><td><?php echo $tout7p9;  ?></td><td><?php echo $tout8p9;  ?></td><td><?php echo $tout9p9;  ?></td><td><?php echo $tout10p9;  ?></td><td><?php echo $tout11p9;  ?></td><td><?php echo $toutfp9;  ?></td><td><?php echo $sumps7;  ?></td><td><?php echo $sumpsah7;  ?></td><td><?php echo $sumpsahp9;  ?></td><td><?php echo $sumforecastsah7;  ?></td><td><?php echo $sumasahp9;  ?></td><td><?php echo $sahdiffp9;  ?></td><td><?php echo round($sumpeffp9/$i).'%';  ?></td><td><?php echo round($sumaeffp9/$i).'%';  ?></td><td><?php echo $sumbpcsp9;  ?></td><td><?php echo round($sumhitrate7/3);  ?>%</td><td><?php echo $sumrequiredqty7;  ?></td></tr>
	
 <?php
 }
 if($team==24){?>
	<tr style="background-color:#c5e1a5;font-weight: bold;"><td style="font-size:x-small;">Section 8</td><td></td><td></td><td><?php  echo $sumfrplanqtyp10; ?></td><td><?php  echo $sumfrqtyp10; ?></td><td></td><td></td><td></td><td><?php echo $tout1p10;  ?> </td><td><?php echo $tout2p10;  ?></td><td><?php echo $tout3p10;  ?></td><td><?php echo $tout4p10;  ?></td><td><?php echo $tout5p10;  ?></td><td><?php echo $tout6p10;  ?></td><td><?php echo $tout7p10;  ?></td><td><?php echo $tout8p10;  ?></td><td><?php echo $tout9p10;  ?></td><td><?php echo $tout10p10;  ?></td><td><?php echo $tout11p10;  ?></td><td><?php echo $toutfp10;  ?></td><td><?php echo $sumps8;  ?></td><td><?php echo $sumpsah8;  ?></td><td><?php echo $sumpsahp10;  ?></td><td><?php echo $sumforecastsah8;  ?></td><td><?php echo $sumasahp10;  ?></td><td><?php echo $sahdiffp10;  ?></td><td><?php echo round($sumpeffp10/$i).'%';  ?></td><td><?php echo round($sumaeffp10/$i).'%';  ?></td><td><?php echo $sumbpcsp10;  ?></td><td><?php echo round($sumhitrate8/3);  ?>%</td><td><?php echo $sumrequiredqty8;  ?></td></tr>
	
 <?php
 }
 if($team==27){?>
	<tr style="background-color:#c5e1a5;font-weight: bold;"><td style="font-size:x-small;">Section 9</td><td></td><td></td><td><?php  echo $sumfrplanqtyp11; ?></td><td><?php  echo $sumfrqtyp11; ?></td><td></td><td></td><td></td><td><?php echo $tout1p11;  ?> </td><td><?php echo $tout2p11;  ?></td><td><?php echo $tout3p11;  ?></td><td><?php echo $tout4p11;  ?></td><td><?php echo $tout5p11;  ?></td><td><?php echo $tout6p11;  ?></td><td><?php echo $tout7p11;  ?></td><td><?php echo $tout8p11;  ?></td><td><?php echo $tout9p11;  ?></td><td><?php echo $tout10p11;  ?></td><td><?php echo $tout11p11;  ?></td><td><?php echo $toutfp11;  ?></td><td><?php echo $sumps9;  ?></td><td><?php echo $sumpsah9;  ?></td><td><?php echo $sumpsahp11;  ?></td><td><?php echo $sumforecastsah9;  ?></td><td><?php echo $sumasahp11;  ?></td><td><?php echo $sahdiffp11;  ?></td><td><?php echo round($sumpeffp11/$i).'%';  ?></td><td><?php echo round($sumaeffp11/$i).'%';  ?></td><td><?php echo $sumbpcsp11;  ?></td><td><?php echo round($sumhitrate9/3);  ?>%</td><td><?php echo $sumrequiredqty9;  ?></td></tr>
	
 <?php
 }
 if($team==30){?>
	<tr style="background-color:#c5e1a5;font-weight: bold;"><td style="font-size:x-small;">Section 10</td><td></td><td></td><td><?php  echo $sumfrplanqtyp12; ?></td><td><?php  echo $sumfrqtyp12; ?></td><td></td><td></td><td></td><td><?php echo $tout1p12;  ?> </td><td><?php echo $tout2p12;  ?></td><td><?php echo $tout3p12;  ?></td><td><?php echo $tout4p12;  ?></td><td><?php echo $tout5p12;  ?></td><td><?php echo $tout6p12;  ?></td><td><?php echo $tout7p12;  ?></td><td><?php echo $tout8p12;  ?></td><td><?php echo $tout9p12;  ?></td><td><?php echo $tout10p12;  ?></td><td><?php echo $tout11p12;  ?></td><td><?php echo $toutfp12;  ?></td><td><?php echo $sumps10;  ?></td><td><?php echo $sumpsah10;  ?></td><td><?php echo $sumpsahp12;  ?></td><td><?php echo $sumforecastsah10;  ?></td><td><?php echo $sumasahp12;  ?></td><td><?php echo $sahdiffp12;  ?></td><td><?php echo round($sumpeffp12/$i).'%';  ?></td><td><?php echo round($sumaeffp12/$i).'%';  ?></td><td><?php echo $sumbpcsp12;  ?></td><td><?php echo round($sumhitrate10/3);  ?>%</td><td><?php echo $sumrequiredqty10;  ?></td></tr>
	
 <?php
 }
 if($team==33){?>
	<tr style="background-color:#c5e1a5;font-weight: bold;"><td style="font-size:x-small;">Section 11</td><td></td><td></td><td><?php  echo $sumfrplanqtyp13; ?></td><td><?php  echo $sumfrqtyp13; ?></td><td></td><td></td><td></td><td><?php echo $tout1p13;  ?> </td><td><?php echo $tout2p13;  ?></td><td><?php echo $tout3p13;  ?></td><td><?php echo $tout4p13;  ?></td><td><?php echo $tout5p13;  ?></td><td><?php echo $tout6p13;  ?></td><td><?php echo $tout7p13;  ?></td><td><?php echo $tout8p13;  ?></td><td><?php echo $tout9p13;  ?></td><td><?php echo $tout10p13;  ?></td><td><?php echo $tout11p13;  ?></td><td><?php echo $toutfp13;  ?></td><td><?php echo $sumps11;  ?></td><td><?php echo $sumpsah11;  ?></td><td><?php echo $sumpsahp13;  ?></td><td><?php echo $sumforecastsah11;  ?></td><td><?php echo $sumasahp13;  ?></td><td><?php echo $sahdiffp13;  ?></td><td><?php echo round($sumpeffp13/$i).'%';  ?></td><td><?php echo round($sumaeffp13/$i).'%';  ?></td><td><?php echo $sumbpcsp13;  ?></td><td><?php echo round($sumhitrate11/3);  ?>%</td><td><?php echo $sumrequiredqty11;  ?></td></tr>
	
 <?php
 }
 
	
	
	if($team==36){
	
	?>
	<tr style="background-color:#c5e1a5;font-weight: bold;"><td style="font-size:x-small;">Section 12</td><td></td><td></td><td><?php  echo $sumfrplanqtyp14; ?></td><td><?php  echo $sumfrqtyp14; ?></td><td></td><td></td><td></td><td><?php echo $tout1p14;  ?> </td><td><?php echo $tout2p14;  ?></td><td><?php echo $tout3p14;  ?></td><td><?php echo $tout4p14;  ?></td><td><?php echo $tout5p14;  ?></td><td><?php echo $tout6p14;  ?></td><td><?php echo $tout7p14;  ?></td><td><?php echo $tout8p14;  ?></td><td><?php echo $tout9p14;  ?></td><td><?php echo $tout10p14;  ?></td><td><?php echo $tout11p14;  ?></td><td><?php echo $toutfp14;  ?></td><td><?php echo $sumps12;  ?></td><td><?php echo $sumpsah12;  ?></td><td><?php echo $sumpsahp14;  ?></td><td><?php echo $sumforecastsah12;  ?></td><td><?php echo $sumasahp14;  ?></td><td><?php echo $sahdiffp14;  ?></td><td><?php echo round($sumpeffp14/$i).'%';  ?></td><td><?php echo round($sumaeffp14/$i).'%';  ?></td><td><?php echo $sumbpcsp14;  ?></td><td><?php echo round($sumhitrate12/3);  ?>%</td><td><?php echo $sumrequiredqty12;  ?></td></tr>
	
	<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
	
	<tr style="background-color:#c5e1a5;font-weight: bold;"><td>Plant A</td><td></td><td></td><td><?php  echo $sumfrplanqtyp1; ?></td><td><?php  echo $sumfrqtyp1; ?></td><td></td><td></td><td></td><td><?php echo $tout1p1;  ?> </td><td><?php echo $tout2p1;  ?></td><td><?php echo $tout3p1;  ?></td><td><?php echo $tout4p1;  ?></td><td><?php echo $tout5p1;  ?></td><td><?php echo $tout6p1;  ?></td><td><?php echo $tout7p1;  ?></td><td><?php echo $tout8p1;  ?></td><td><?php echo $tout9p1;  ?></td><td><?php echo $tout10p1;  ?></td><td><?php echo $tout11p1;  ?></td><td><?php echo $toutfp1;  ?></td><td><?php echo $sumpsa;  ?></td><td><?php echo $sumpsaha;  ?></td><td><?php echo $sumpsahp1;  ?></td><td><?php echo $sumforecastsaha;   ?></td><td><?php echo $sumasahp1;  ?></td><td><?php echo $sahdiffp1;  ?></td><td><?php echo round($sumpeffp1/18).'%';  ?></td><td><?php echo round($sumaeffp1/18).'%';  ?></td><td><?php echo $sumbpcsp1;  ?></td><td><?php echo round($sumhitratea/18);  ?>%</td><td><?php  echo $sumrequiredqtya; ?></td></tr>
	<tr style="background-color:#c5e1a5;font-weight: bold;"><td>Plant B</td><td></td><td></td><td><?php  echo $sumfrplanqtyp2; ?></td><td><?php  echo $sumfrqtyp2; ?></td><td></td><td></td><td></td><td><?php echo $tout1p2;  ?> </td><td><?php echo $tout2p2;  ?></td><td><?php echo $tout3p2;  ?></td><td><?php echo $tout4p2;  ?></td><td><?php echo $tout5p2;  ?></td><td><?php echo $tout6p2;  ?></td><td><?php echo $tout7p2;  ?></td><td><?php echo $tout8p2;  ?></td><td><?php echo $tout9p2;  ?></td><td><?php echo $tout10p2;  ?></td><td><?php echo $tout11p2;  ?></td><td><?php echo $toutfp2;  ?></td><td><?php echo $sumpsb;  ?></td><td><?php echo $sumpsahb;  ?></td><td><?php echo $sumpsahp2;  ?></td><td><?php echo $sumforecastsahb;   ?></td><td><?php echo $sumasahp2;  ?></td><td><?php echo $sahdiffp2;  ?></td><td><?php echo round($sumpeffp2/18).'%';  ?></td><td><?php echo round($sumaeffp2/18).'%';  ?></td><td><?php echo $sumbpcsp2;  ?></td><td><?php echo round($sumhitrateb/18);  ?>%</td><td><?php  echo $sumrequiredqtyb; ?></td></tr>
	<tr style="background-color:#1b5e20;color:white;font-weight: bold;"><td>Factory</td><td></td><td></td><td><?php  echo $sumfrplanqty; ?></td><td><?php  echo $sumfrqty; ?></td><td></td><td></td><td></td><td><?php echo $tout1;  ?></td><td><?php echo $tout2;  ?></td><td><?php echo $tout3;  ?></td><td><?php echo $tout4;  ?></td><td><?php echo $tout5;  ?></td><td><?php echo $tout6;  ?></td><td><?php echo $tout7;  ?></td><td><?php echo $tout8;  ?></td><td><?php echo $tout9;  ?></td><td><?php echo $tout10;  ?></td><td><?php echo $tout11;  ?></td><td><?php echo $toutf;  ?></td><td><?php echo $sumpsc;  ?></td><td><?php echo ($sumpsaha+$sumpsahb);  ?></td><td><?php echo $sumpsah;  ?></td><td><?php echo $sumforecastsah;   ?></td><td><?php echo $sumasah;  ?></td><td><?php echo $sahdiff;  ?></td><td><?php echo round($sumpeff/$i).'%';  ?></td><td><?php echo round($sumaeff/$i).'%';  ?></td><td><?php echo $sumbpcs;  ?></td><td><?php echo round($sumhitrate/36);  ?>%</td><td><?php  echo $sumrequiredqty; ?></td></tr>
	
	
	
	
	
	
	<?php    }if($team%3==0 && $team<36){?>
	<!-- <tr style="border:0px solid white;"><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr> -->
<!-- <tr style="background-color:#ec407a;"> -->
<!-- <tr> -->
        <!-- <th>Team</th> -->
        <!-- <th>NOP</th>
        <th>Style</th>
		<th style='display:none;'>Sch</th>
		<th>FR Plan</th>
		<th>Forecast</th>
		<th>SMV</th>
		<th>Hours</th>
		<th>Target <br>PCS/Hr</th> -->
		
		<!-- <th>8.30</th>
		<th>9.30</th>
		<th>10.30</th>
		<th>11.30</th>
		<th>12.30</th>
		<th>1.30</th>
		<th>2.30</th>
		<th>3.30</th>
		<th>4.30</th>
		<th>5.30</th>
		<th>6.30</th>
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
		<td>Team</td> -->
		
      <!-- </tr> -->
	
	
	<?php
	}
	
	$out1=$out2=$out3=$out4=$out5=$out6=$out7=$out8=$out9=$out10=$out11="";
	$forecastqty=0;
	$frqty=0;
	$plansah=0;
	$balance=0;
	$plan_eff=0;
	$act_eff=0;
	
	
	}else{
		echo "<hr><div class='alert alert-danger'>No Data Found..</div>";
	} ?>
      
			</tbody>
			</table>
	</div></div>
	</section>
  <br><br>
</div></div>
</div>
