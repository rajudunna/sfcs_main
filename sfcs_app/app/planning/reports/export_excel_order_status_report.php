<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\""."cut_to_ship".".csv\"");
$data=stripcslashes($_REQUEST['csv123']);
echo $data; 
?>