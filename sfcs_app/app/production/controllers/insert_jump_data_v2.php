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
		
	$sql2="update $bai_pro.pro_atten_jumper set jumper_$shift='".$_POST['jpa'.$i]."' where atten_id='$attenid' and module='$mod_names[$i]'";
	mysqli_query($link, $sql2) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql222="Select avail_$shift as avail from $bai_pro.pro_atten_jumper where atten_id='$attenid' and module='$mod_names[$i]'";
	$sql_result222=mysqli_query($link, $sql222) or exit ("Sql Error: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row222=mysqli_fetch_array($sql_result222))
	{
	$avail_A=$sql_row222['avail'];
	}
	
	$sql22="update $bai_pro.pro_atten set avail_$shift='".($_POST['jpa'.$i]+$avail_A)."' where atten_id='$attenid' and module='$mod_names[$i]'";
	mysqli_query($link, $sql22) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	//update bai_pro.grand_rep
	// $updategrandrep="update $bai_pro.grand_rep set jumpers='".$_POST['jpa'.$i]."' where date='".$date."' and module='$mod_names[$i]' and shift='$shift'";
	// mysqli_query($link, $updategrandrep) or exit("Error while updating jumpers".mysqli_error($GLOBALS["___mysqli_ston"]));
}
echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
  		function Redirect() {
  			sweetAlert('Jumper Details Sucessfully Updated','','success');
  			location.href = \"".getFullURLLevel($_GET['r'], "update_jump_details_v2.php", "0", "N")."\";
  			}
  		</script>";
?>