<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));

$date=$_POST['date'];
$shift=$_POST['shift'];
$shift_start_time=$_POST['shift_start_time'];
$shift_end_time=$_POST['shift_end_time'];
$sql="select * from $bai_pro.pro_atten_hours where date='$date' and shift='$shift'";
$sql_res=mysqli_query($link, $sql) or exit("Sql Error88 $sql11".mysqli_error($GLOBALS["___mysqli_ston"]));
$count=mysqli_num_rows($sql_res);
if($count == 0){
	$sql1="insert ignore INTO $bai_pro.pro_atten_hours (date,shift,start_time,end_time) VALUES ('".$date."','".$shift."','".$shift_start_time."','".$shift_end_time."')";
	mysqli_query($link, $sql1) or exit("Sql Error88 $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
}else{
	$sql2="update $bai_pro.pro_atten_hours set start_time='".$shift_start_time."',end_time='".$shift_end_time."' where date='".$date."' and shift='".$shift."' ";
	mysqli_query($link, $sql2) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
}

for($i=0;$i<sizeof($mod_names);$i++)
{
	// $attenid=$date."-".$mod_names[$i];
	$sql1="INSERT Ignore INTO $bai_pro.pro_atten (atten_id, date,module) VALUES ('".$date."".$mod_names[$i]."','".$date."','$mod_names[$i]')";
	mysqli_query($link, $sql1) or exit("Sql Error88 $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
	// echo $sql1."</br>";
	
	$countattenjump="select count(*) as cnt from $bai_pro.pro_atten_jumper where atten_id='".$date."".$mod_names[$i]."' and module='$mod_names[$i]'";
	$rslt=mysqli_query($link, $countattenjump) or exit ("Error while getting count".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($row=mysqli_fetch_array($rslt))
	{
		$count=$row['cnt'];
	}
	if($count==0)
	{
		$sql11="INSERT Ignore INTO $bai_pro.pro_atten_jumper (atten_id, date,module) VALUES ('".$date."".$mod_names[$i]."','".$date."','$mod_names[$i]')";
		mysqli_query($link, $sql11) or exit("Sql Error88 $sql11".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	// echo $sql11."</br>";

	$sql2="update $bai_pro.pro_atten_jumper set avail_$shift='".$_POST['pra'.$i]."',absent_$shift='".$_POST['aba'.$i]."' where atten_id='".$date."".$mod_names[$i]."' and module='$mod_names[$i]'";
	mysqli_query($link, $sql2) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
	// echo $sql2."</br>";
	
	$sql222="Select jumper_$shift as jumper from $bai_pro.pro_atten_jumper where atten_id='".$date."".$mod_names[$i]."' and module='$mod_names[$i]'";
	$sql_result222=mysqli_query($link, $sql222) or exit ("Sql Error222: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row222=mysqli_fetch_array($sql_result222))
	{
	$jumper_a=$sql_row222['jumper'];
	}
	
	$sql22="update $bai_pro.pro_atten set avail_$shift='".($_POST['pra'.$i]+$jumper_a)."',absent_$shift='".$_POST['aba'.$i]."' where atten_id='".$date."".$mod_names[$i]."' and module='$mod_names[$i]'";
	// echo $sql22."</br>";
	mysqli_query($link, $sql22) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	//update bai_pro.bai_log
	// $updatebailog="update $bai_pro.bai_log set nop='".$_POST['pra'.$i]."' where bac_date='".$date."' and bac_no='$mod_names[$i]' and bac_shift='$shift'";
	// mysqli_query($link, $updatebailog) or exit("Error while updating in bai_log".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	//update bai_pro.bai_log_buf
	// $updatebailogbuf="update $bai_pro.bai_log_buf set nop='".$_POST['pra'.$i]."' where bac_date='".$date."' and bac_no='$mod_names[$i]' and bac_shift='$shift'";
	// mysqli_query($link, $updatebailogbuf) or exit("Error while updating in bai_log_buf".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	//update bai_pro.grand_rep
	// $updategrandrep="update $bai_pro.grand_rep set nop='".$_POST['pra'.$i]."',absents='".$_POST['aba'.$i]."' where date='".$date."' and module='$mod_names[$i]' and shift='$shift'";
	// mysqli_query($link, $updategrandrep) or exit("Error while updating in grand_rep".mysqli_error($GLOBALS["___mysqli_ston"]));
}
// die();
  echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
  		function Redirect() {
  			sweetAlert('Attandance Details Sucessfully Updated','','success');
  			location.href = \"".getFullURLLevel($_GET['r'], "update_emp_details_v2.php", "0", "N")."\";
  			}
  		</script>";
?>