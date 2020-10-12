<?php
include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
$data = json_decode($_POST['data']);
$bundleno=$data['bundleno'];
$operationCode=$data['operationCode'];
$style=$data['style'];
$schedule=$data['schedule'];
$fgColor=$data['fgColor'];
$size=$data['size'];
$actualQuantity=$data['actualQuantity'];
$gate_id=$data['gate_id'];
$plant_code=$data['plant_code'];
$username=$data['username'];

$insert_qry="Insert into $pps.gatepass_track(gate_id,bundle_no,bundle_qty,style,schedule,color,size,operation_id,plant_code,created_at,created_user,updated_at,updated_user) VALUES ('".$gate_id."','".$bundleno."','".$actualQuantity."','".$style."','".$schedule."','".$fgColor."','".$size."','".$operationCode."','".$plant_code."',NOW(),'".$username."',Now(),'".$username."')";
$sql_result=mysqli_query($link, $insert_qry) or exit($insert_qry."Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

$url="/sfcs_app/app/production/controllers/gatepass_summery_detail.php?&gatepassid=".$gate_id."&status=2&plant_code=".$plant_code."&username=".$username;
echo "<script>
	window.open('$url');
	</script>";
?>