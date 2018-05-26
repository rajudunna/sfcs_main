<?php
header("Content-type: application/octet-stream");
//header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\""."FSP_BOM_Details_".$_REQUEST['schedule'].".csv\"");
$data="FSP RM Forecast - BOM Details\nSchedule:".$_REQUEST['schedule']."\n\n".stripcslashes($_REQUEST['csv_text']);
echo $data; 
?>