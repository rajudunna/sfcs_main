<?php

ini_set('max_execution_time', '50000');

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

$sql1="SELECT DISTINCT SCHEDULE as schedule_no FROM `bai_pro3`.`pac_stat` WHERE carton_status IS NULL AND id IN (SELECT pac_stat_id FROM `bai_pro3`.`pac_stat_log` WHERE STATUS = 'DONE')  ";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1--".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
    $schedule_number = $sql_row1['schedule_no'];
	$sql2="SELECT pac_stat_id FROM `bai_pro3`.`pac_stat_log` WHERE SCHEDULE = '".$schedule_number."' AND STATUS = 'DONE' ";
	echo $sql2."<br/>";
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2--".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$pacstatid[]=$sql_row2['pac_stat_id'];
	}
	
    $pacstatids=implode(",",$pacstatid);
	
    $sql3="UPDATE `bai_pro3`.`pac_stat` SET `opn_status` = '200' , `carton_status` = 'DONE' WHERE `id` IN ($pacstatids) ";
	echo $sql3."<br/>";	
    $sql_result3=mysqli_query($link, $sql3) or exit("Sql Error3--".mysqli_error($GLOBALS["___mysqli_ston"]));
     if($sql_result3)
	{
		 echo "</br>successfully updated : ".$schedule_number."</br>";
	}
	 else
	{
		  echo "</br>Failed to updated : ".$schedule_number."</br>";
	}

unset($schedule_number);
unset($pacstatid);
unset($pacstatids);
}

?>