<?php

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

$sql1="SELECT * FROM `bai_pro3`.`short_shipment_job_track` WHERE remove_type IN('1','2')";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1--".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$style=$sql_row1['style'];
	$schedule=$sql_row1['schedule'];
	$remove_type=$sql_row1['remove_type'];
	$sql11="SELECT order_tid FROM `bai_pro3`.`bai_orders_db` WHERE order_style_no='$style' AND order_del_no='$schedule' ";
    $sql_result11=mysqli_query($link, $sql11) or exit("Sql Error11--".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row11=mysqli_fetch_array($sql_result11))
	{
		$order_tid=$sql_row11['order_tid'];
		$sql14="SELECT distinct order_tid as order_tid FROM `bai_pro3`.plandoc_stat_log where order_tid='$order_tid' ";
	    $sql_result14=mysqli_query($link, $sql14) or exit("Sql Error14--".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row14=mysqli_fetch_array($sql_result14))
		{   
	        $order_tid1=$sql_row14['order_tid'];
			$sql15="update `bai_pro3`.`plandoc_stat_log` set `short_shipment_status` =$remove_type where order_tid='$order_tid1'";
			$sql_result15=mysqli_query($link, $sql15) or exit("Sql Error15--".mysqli_error($GLOBALS["___mysqli_ston"]));
		}

	}
	unset($style);
	unset($schedule);
	unset($remove_type);
}

?>