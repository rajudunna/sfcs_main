<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\""."Fabric_Savings_Report".".csv\"");
$data=stripcslashes($_REQUEST['csv_text']);
echo $data; 
?>
