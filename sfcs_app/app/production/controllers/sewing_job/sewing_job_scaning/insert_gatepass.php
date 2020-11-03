<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');

$bundleno=$_POST['bundleno'];
$operationCode=$_POST['operationCode'];
$style=$_POST['style'];
$schedule=$_POST['schedule'];
$fgColor=$_POST['fgColor'];
$size=$_POST['size'];
$actualQuantity=$_POST['actualQuantity'];
$gate_id=$_POST['gate_id'];
$plant_code=$_POST['plant_code'];
$username=$_POST['username'];

$insert_qry="Insert into $pps.gatepass_track(gate_id,bundle_no,bundle_qty,style,schedule,color,size,operation_id,plant_code,created_at,created_user,updated_at,updated_user) VALUES (".$gate_id.",'".$bundleno."','".$actualQuantity."','".$style."','".$schedule."','".$fgColor."','".$size."','".$operationCode."','".$plant_code."',NOW(),'".$username."',Now(),'".$username."')";
$sql_result=mysqli_query($link, $insert_qry) or exit($insert_qry."Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

?>