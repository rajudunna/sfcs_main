<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\""."daily_rejection_report".".csv\"");
$data=stripcslashes($_REQUEST['csv_text']);
echo $data; 
?>