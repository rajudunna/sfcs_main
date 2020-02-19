<?php
header("Content-type: application/octet-stream");
//$filename=$_POST['csvname'];
header("Content-Disposition: attachment; filename=\""."M3 Bulk Opration Reconfirm Interface".".csv\"");
$data=stripcslashes($_REQUEST['csv_text']);
echo $data; 
?>