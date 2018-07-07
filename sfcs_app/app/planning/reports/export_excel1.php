<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\""."Order Status Report".".csv\"");
$data=stripcslashes($_REQUEST['csv_123']);
echo $data; 
?>