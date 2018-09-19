<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));

$date=$_POST['date'];
$shift=$_POST['shift'];

for($i=0;$i<sizeof($mod_names);$i++)
{
	$attenid=$date."-".$mod_names[$i];
	$sql1="INSERT Ignore INTO $bai_pro.pro_atten (atten_id, date,module) VALUES ('$attenid','".$date."','$mod_names[$i]')";
	mysqli_query($link, $sql1) or exit("Sql Error88 $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql11="INSERT Ignore INTO $bai_pro.pro_atten_jumper (atten_id, date,module) VALUES ('$attenid','".$date."','$mod_names[$i]')";
	mysqli_query($link, $sql11) or exit("Sql Error88 $sql11".mysqli_error($GLOBALS["___mysqli_ston"]));

	$sql2="update $bai_pro.pro_atten_jumper set avail_$shift='".$_POST['pra'.$i]."',absent_$shift='".$_POST['aba'.$i]."' where atten_id='$attenid' and module='$mod_names[$i]'";
	mysqli_query($link, $sql2) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql222="Select jumper_$shift as jumper from $bai_pro.pro_atten_jumper where atten_id='$attenid' and module='$mod_names[$i]'";
	$sql_result222=mysqli_query($link, $sql222) or exit ("Sql Error222: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row222=mysqli_fetch_array($sql_result222))
	{
	$jumper_a=$sql_row222['jumper'];
	}
	
	$sql22="update $bai_pro.pro_atten set avail_$shift='".($_POST['pra'.$i]+$jumper_a)."',absent_$shift='".$_POST['aba'.$i]."' where atten_id='$attenid' and module='$mod_names[$i]'";
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

  echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
  		function Redirect() {
  			sweetAlert('Attandance Details Sucessfully Updated','','success');
  			location.href = \"".getFullURLLevel($_GET['r'], "update_emp_details_v2.php", "0", "N")."\";
  			}
  		</script>";
?>