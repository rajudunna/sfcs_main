<?php

include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
error_reporting(0);

if(isset($_GET['style']))
    $styles = $_GET['style'];
else
{
    $get_style="SELECT DISTINCT(order_style_no) FROM $bai_pro3.bai_orders_db_confirm WHERE order_tid IN(SELECT order_tid FROM $bai_pro3.plandoc_stat_log )";
    $result1 = $link->query($get_style);
      while($row1 = $result1->fetch_assoc())
      {
          $style[] = $row1['order_style_no'];
      }
    $styles = implode('","',$style);
   
}

 $styles = '"'.$styles.'"';
  $get_schedule="SELECT DISTINCT(order_del_no) FROM $bai_pro3.bai_orders_db_confirm WHERE order_style_no IN ($styles)";
  $result2 = $link->query($get_schedule);
  while($row1 = $result2->fetch_assoc())
    {
    $schedule[] = $row1['order_del_no'];
    }
  $schedules = implode(',',$schedule);

  if(isset($_GET['style']) && isset($_GET['schedule']))
  {
    $style1=$_GET['style'];
    $schedule1=$_GET['schedule'];
    $get_color="select order_col_des from $bai_pro3.bai_orders_db_confirm where order_style_no='$style1' and order_del_no='$schedule1'";
  }
  else
  {
   $get_color="select order_col_des from $bai_pro3.bai_orders_db_confirm where order_style_no IN ($styles) and order_del_no IN ($schedules) ";
  }
    $result3 = $link->query($get_color);
    while($row1 = $result3->fetch_assoc())
    {
      $color[] = $row1['order_col_des'];
    }
  
   $json['style'] = $style;
   $json['schedule'] =$schedule;
   $json['color'] =$color;
   echo json_encode($json);


?>