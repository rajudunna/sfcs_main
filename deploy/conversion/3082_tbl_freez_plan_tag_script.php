<?php

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

$sql1="SELECT plan_tag,date,mod_no,shift FROM bai_pro.`tbl_freez_plan_log` WHERE DATE between '2020-01-01' and '2020-01-09' order by date,mod_no*1,shift";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1--".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$plan_tag = $sql_row1['plan_tag'];
    $date = $sql_row1['date'];
    $mod_no = $sql_row1['mod_no'];
    $shift = $sql_row1['shift'];
	$plantag=$date."-".$mod_no."-".$shift;
    $sql15="update `bai_pro`.`tbl_freez_plan_log` set `plan_tag` ='$plantag' where plan_tag='$plan_tag'";
	echo $sql15."<br/>";
    $sql_result15=mysqli_query($link, $sql15) or exit("Sql Error15--".mysqli_error($GLOBALS["___mysqli_ston"]));
     if($sql_result15)
	{
		 echo "</br>successfully updated : ".$plantag."</br>";
	}
	 else
	{
		  echo "</br>Failed to updated : ".$plantag."</br>";
	}

unset($plan_tag);
unset($plantag);
}

?>