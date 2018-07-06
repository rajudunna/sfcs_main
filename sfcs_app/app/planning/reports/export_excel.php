<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\""."Production Status Report".".csv\"");
$data=stripcslashes($_REQUEST['csv_text']);
echo $data; 
?>