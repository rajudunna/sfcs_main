<?php include ("dbconf2.php"); ?>
<?php

set_time_limit(2000);
include ("dbconf.php");


$order_status_buffer="temp_pool_db.".$username.date("YmdHis")."_"."order_status_buffer";
$style_status_summ="temp_pool_db.".$username.date("YmdHis")."_"."style_status_summ";
$shipment_plan_summ="temp_pool_db.".$username.date("YmdHis")."_"."shipment_plan_summ";

$sql="create TEMPORARY table $order_status_buffer ENGINE = MyISAM select * from bai_pro2.order_status_buffer";
mysqli_query($link, $sql) or exit("Sql Error1z".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql1="delete from $order_status_buffer";
mysqli_query($link, $sql1) or exit("Sql Error2x1".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql1="insert into $order_status_buffer (cust_order,CPO,buyer_div,style,style_id,schedule,color,exf_date,ssc_code,order_qty) select Cust_order,CPO,buyer_div,style_no,style_id,schedule_no,color,exfact_date,ssc_code,order_qty from shipment_plan_summ";
mysqli_query($link, $sql1) or exit("Sql Error2x1".mysqli_error($GLOBALS["___mysqli_ston"]));

?>	



	