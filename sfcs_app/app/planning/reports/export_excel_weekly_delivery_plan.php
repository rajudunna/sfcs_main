<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\""."Weekly_Delivery_plan".".csv\"");
$data=stripcslashes($_REQUEST['csv_weekly']);
echo $data; 
?>