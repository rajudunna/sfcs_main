<?php

include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions_v2.php");
error_reporting(0);


$plant = $_GET['plant'];
// echo $plant;

if(isset($_GET['style']) && isset($_GET['schedule'])){
 
  $colors = getBulkColors($_GET['schedule'], $plant);
  $color = $colors['color_bulk'];

} else if(isset($_GET['style'])){
  $styles = $_GET['style'];
  $schedules = getBulkSchedules($styles, $plant);
  $schedule = $schedules['bulk_schedule'];
 

} else{

  $get_style=getMpColorDetail($plant);

  $style = $get_style['style'];
}


$json['style'] = $style;
$json['schedule'] =$schedule;
$json['color'] =$color;
echo json_encode($json);


?>