<?php
header("Content-type: application/octet-stream");
//$filename=$_POST['csvname'];
header("Content-Disposition: attachment; filename=\""."Mo Production Report".".csv\"");
$data=stripcslashes($_REQUEST['csv_text']);
echo $data; 
?>