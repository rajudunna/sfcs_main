<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));

$date=$_POST['date'];
$shift=$_POST['shift'];
$modules_array = array();	$modules_id_array=array();
$get_modules = "SELECT DISTINCT module_name, id FROM $bai_pro3.`module_master` where status='Active' ORDER BY module_name*1;";
$modules_result=mysqli_query($link, $get_modules) or exit ("Error while fetching modules: $get_modules");
while($module_row=mysqli_fetch_array($modules_result))
{
	$modules_array[]=$module_row['module_name'];
	$modules_id_array[$module_row['module_name']]=$module_row['id'];
}

for($i=0;$i<sizeof($modules_array);$i++)
{
	$jpa_id = 'jpa_'.$modules_id_array[$modules_array[$i]];
	$sql2="update $bai_pro.pro_attendance set jumper='".$_POST[$jpa_id]."' where date='".$date."' and module='$modules_array[$i]' and shift = '$shift'";
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