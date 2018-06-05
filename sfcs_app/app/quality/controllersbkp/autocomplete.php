<?php

	include("../".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	
	$q=$_GET['q'];
	// echo $q;
	$my_data=mysqli_real_escape_string($link, $q);
	$sql="SELECT distinct qms_schedule FROM $bai_pro3.bai_qms_db WHERE qms_tran_type=3 and qms_schedule LIKE '%$my_data%' ORDER BY qms_schedule";
	// echo $sql;
	$result = mysqli_query($link, $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	if($result)
	{
		while($row=mysqli_fetch_array($result))
		{
			echo $row['qms_schedule']."\n";
		}
	}
?>