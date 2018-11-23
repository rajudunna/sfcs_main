<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));

$date=$_POST['date'];
$shift=$_POST['shift'];

for($i=0;$i<sizeof($mod_names);$i++)
{
	$sql2="update $bai_pro.pro_attendance set jumper='".$_POST['jpa'.$i]."' where date='".$date."' and module='$mod_names[$i]'";
	// echo $sql2."<br>";
	mysqli_query($link, $sql2) or exit("Sql Errora $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
	
}
echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
  		function Redirect() {
  			sweetAlert('Jumper Details Sucessfully Updated','','success');
  			location.href = \"".getFullURLLevel($_GET['r'], "update_jump_details_v2.php", "0", "N")."\";
  			}
  		</script>";
?>