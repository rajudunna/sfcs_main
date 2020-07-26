
<?php

set_time_limit(2000);
include ($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
$order_status_buffer="pps.order_status_buffer";
$style_status_summ="pps.style_status_summ";
$shipment_plan_summ="pps.shipment_plan_summ";

// $sql="create TEMPORARY table $order_status_buffer ENGINE = MyISAM select * from $pps.order_status_buffer";
// echo $sql."<br>";
// mysqli_query($link, $sql) or exit("Sql Error1z".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql1="delete from $order_status_buffer";
mysqli_query($link, $sql1) or exit("Sql Error2x1".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql1="insert into $order_status_buffer (cust_order,CPO,buyer_div,style,style_id,schedule,color,exf_date,ssc_code,order_qtyplant_code,created_user,created_at)
 select Cust_order,CPO,buyer_div,style_no,style_id,schedule_no,color,exfact_date,ssc_code,order_qty from $pps.shipment_plan_summ";
mysqli_query($link, $sql1) or exit("Sql Error2x1".mysqli_error($GLOBALS["___mysqli_ston"]));

?>	



	