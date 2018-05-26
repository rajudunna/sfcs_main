<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\""."module_wise_production_output".".csv\"");
$data=stripcslashes($_REQUEST['csv123']);
echo $data; 
?>