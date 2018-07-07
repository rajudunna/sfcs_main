<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
$sout=$_POST['sout'];
$pph=$_POST['pph'];
$team=$_POST['team'];

$dreason1=$_POST['dreason1'];
$dreason2=$_POST['dreason2'];
$dreason3=$_POST['dreason3'];

$dout1=$_POST['dout1'];
$dout2=$_POST['dout2'];
$dout3=$_POST['dout3'];

	$odate=$_POST['ddate'];
	$otime=$_POST['hour'].':30';
	$hour=$_POST['hour'];	
	//$remarks='NA';

if($dreason1 != ""){
				
		$sql="DELETE from $bai_pro2.hourly_downtime WHERE team='$team' AND date='$odate' AND dhour='$hour'";
		mysqli_query($link,$sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//echo $sql;
		
		$sql2="INSERT into $bai_pro2.hourly_downtime(date,time,team,dreason,output_qty,dhour) VALUES ('$odate','$otime','$team','$dreason1','$dout1','$hour')";
	    mysqli_query($link,$sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
			if($dreason2 != ""){
				$sql3="INSERT into $bai_pro2.hourly_downtime(date,time,team,dreason,output_qty,dhour) VALUES ('$odate','$otime','$team','$dreason2','$dout2','$hour')";
				mysqli_query($link,$sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			if($dreason3 != ""){
				$sql4="INSERT into $bai_pro2.hourly_downtime(date,time,team,dreason,output_qty,dhour) VALUES ('$odate','$otime','$team','$dreason3','$dout3','$hour')";
				mysqli_query($link,$sql4) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			echo "<h3 style='color:#5cb85c;'><b>Successfuly Updated Hourly Output</h3></b>";

			?>
			
<a href="<?= getFullURLLevel($_GET['r'],'lost_time_capture.php',0,'N'); ?>" class="btn btn-primary" style="width:30%;height:auto;">Click Here to Go Back</a>
<?php
}else{
echo "<h3 style='color:#5cb85c;'><b>Please Update Downtime Reason</h3></b>";?>
<a href="<?= getFullURLLevel($_GET['r'],'update_output.php',0,'N'); ?>"&secid="<?php  echo $section;  ?>" class="btn btn-primary" style="width:30%;height:auto;">Click Here to Go Back</a>

<?php } ?>
	
