<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));

$date=$_POST['date'];
$shift=$_POST['shift'];
$shift_start_time=$_POST['shift_start_time'];
$shift_end_time=$_POST['shift_end_time'];
$sql="select * from $bai_pro.pro_atten_hours where date='$date' and shift='$shift'";
$sql_res=mysqli_query($link, $sql) or exit("Sql Errora $sql11".mysqli_error($GLOBALS["___mysqli_ston"]));
$count=mysqli_num_rows($sql_res);
if($count == 0){
	$sql1="insert ignore INTO $bai_pro.pro_atten_hours (date,shift,start_time,end_time) VALUES ('".$date."','".$shift."','".$shift_start_time."','".$shift_end_time."')";
	mysqli_query($link, $sql1) or exit("Sql Errorb $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
}else{
	$sql2="update $bai_pro.pro_atten_hours set start_time='".$shift_start_time."',end_time='".$shift_end_time."' where date='".$date."' and shift='".$shift."' ";
	mysqli_query($link, $sql2) or exit("Sql Errorc $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
}

for($i=0;$i<sizeof($mod_names);$i++)
{
	// echo $i."--present---".$_POST['pra'.$i]."<br>";
	// echo $i."--Absent---".$_POST['aba'.$i]."<br>";
	// $attenid=$date."-".$mod_names[$i];
	$sqla="Select * from $bai_pro.pro_attendance where date=\"$date\" and module=\"$mod_names[$i]\" and shift='".$shift."'";
	// echo $sqla."</br>";
	$sqlresa=mysqli_query($link, $sqla) or exit("Sql Errord $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sqlresa)==0)
	{
		$sql1="INSERT INTO $bai_pro.pro_attendance (date,module,shift) VALUES ('".$date."','$mod_names[$i]','".$shift."')";
		// echo $sql1."</br>";
		mysqli_query($link, $sql1) or exit("Sql Errore $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql23="update $bai_pro.pro_attendance set present='".$_POST['pra'.$i]."',absent='".$_POST['aba'.$i]."' where date='".$date."' and module='$mod_names[$i]' and shift='".$shift."'";
		// echo $sql23."</br>";
		mysqli_query($link, $sql23) or exit("Sql Errorf".mysqli_error($GLOBALS["___mysqli_ston"]));
	}else{
		$sql22="update $bai_pro.pro_attendance set present='".$_POST['pra'.$i]."',absent='".$_POST['aba'.$i]."' where date='".$date."' and module='$mod_names[$i]' and shift='".$shift."'";
		// echo $sql22."</br>";
		mysqli_query($link, $sql22) or exit("Sql Errorf".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
}
  echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
  		function Redirect() {
  			sweetAlert('Attandance Details Sucessfully Updated','','success');
  			location.href = \"".getFullURLLevel($_GET['r'], "update_emp_details_v2.php", "0", "N")."\";
  			}
  		</script>";
?>