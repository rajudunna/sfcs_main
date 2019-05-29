<?php
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
error_reporting(0);

 //$to_date = '2019-05-22 01:00:00';
 //$from_date = '2019-05-21 01:00:00';

if(isset($_GET["to_date"]))
{
    $to_date=$_GET["to_date"];
}
else
{
    $to_date = date("Y-m-d H:i:s");
}
 
// $from_date = date('Y-m-d H:i:s',strtotime("-1 days"));
$today = $to_date;

$get_last_date = "SELECT updated_time FROM $brandix_bts.open_style_wip ORDER BY updated_time DESC LIMIT 1";
$get_last_date_result =$link->query($get_last_date);
while ($row111 = $get_last_date_result->fetch_assoc())
{
  $updated_date = $row111['updated_time'];
}

if($updated_date > 0)
{
  $from_date = $updated_date;
}else
{
  if(isset($_GET["from_date"]))
  {
      $from_date=$_GET["from_date"];
  }
  else
  {
     $from_date = date('Y-m-d H:i:s',strtotime("-1 days"));
  }
  
}

$get_temp_data ="select style,schedule,color,size_title,operation_id From $brandix_bts.bundle_creation_data_temp Where date_time between '$from_date' And '$to_date' group by style,schedule,color,size_title,operation_id";
//echo $get_temp_data.'<br>hii';
// die();
$get_temp_data_result =$link->query($get_temp_data);
while ($row = $get_temp_data_result->fetch_assoc())
{
   $main_style = $row['style'];
   $main_schedule = $row['schedule'];
   $main_color = $row['color'];
   $main_size = $row['size_title'];
   $main_operation = $row['operation_id'];


   $check_data ="select * FROM $brandix_bts.open_style_wip where style = '$main_style' and schedule ='$main_schedule' and color ='$main_color' and size ='$main_size' and operation_code = $main_operation";
   //echo $check_data.'<br>hii1';
   //$check_data_result =$link->query($check_data);
   $check_data_result = mysqli_query($link,$check_data) or exit('checking  Error');
   if(mysqli_num_rows($check_data_result) > 0)
   {
      while ($row1 = $check_data_result->fetch_assoc())
      {
        // $updated_date = $row1['updated_time'];


        $get_qty_data="select sum(recevied_qty) as good_qty,sum(rejected_qty) as rejected_qty From $brandix_bts.bundle_creation_data_temp where style = '$main_style' and schedule ='$main_schedule' and color ='$main_color' and size_title ='$main_size' and operation_id = $main_operation and date_time between '$from_date' And '$to_date'";
       // echo $get_qty_data.'</br><br>hii2';
        $get_qty_data_result =$link->query($get_qty_data);
        while ($row2 = $get_qty_data_result->fetch_assoc())
        {
          $good_quantity = $row2['good_qty'];
          $rejected_quantity = $row2['rejected_qty'];
       
           
            $get_previous_data ="select sum(good_qty) as previous_good_qty,sum(rejected_qty) as previous_rejected_qty FROM $brandix_bts.open_style_wip where style = '$main_style' and schedule ='$main_schedule' and color ='$main_color' and size ='$main_size' and operation_code = $main_operation";
            // echo $get_previous_data.'</br>';
            $get_previous_qty_data_result =$link->query($get_previous_data);
            while ($row4 = $get_previous_qty_data_result->fetch_assoc())
            {
               $previous_good_qty = $row4['previous_good_qty'];
               $previous_rejected_qty = $row4['previous_rejected_qty'];

               $main_good_qty = $good_quantity + $previous_good_qty;
               $main_rejected_qty =  $rejected_quantity + $previous_rejected_qty;

               $insert_query="INSERT ignore INTO $brandix_bts.open_style_wip (style, schedule, color, operation_code, size, created_time) values ('$style','$schedule','$color','$operation_code','$size_id','$today')";
               //echo $insert_query .'<br>';
               $insert_log_result = mysqli_query($link,$insert_query) or exit('Insert  Error');

               $update_log="UPDATE $brandix_bts.open_style_wip SET good_qty = '$main_good_qty',rejected_qty = '$main_rejected_qty',updated_time = '$today' where style = '$main_style' and schedule ='$main_schedule' and color ='$main_color' and size ='$main_size' and operation_code = $main_operation";
             //  echo  $update_log.'<br>updated';
               $update_qry_log_res = mysqli_query($link,$update_log) or exit('Update  Error');
            }

        }
        unset($main_good_qty);
        unset($main_rejected_qty);
      } 

   }
   else
   {
     $get_main_data ="select style,schedule,color,size_title,operation_id,sum(recevied_qty) as good_qty,sum(rejected_qty) as rejected_qty From $brandix_bts.bundle_creation_data_temp GROUP BY style,SCHEDULE,color,size_title,operation_id";
     //echo $get_main_data .'<br>hii3';
      $get_main_data_result =$link->query($get_main_data);
      while ($row3 = $get_main_data_result->fetch_assoc())
      {
         $style = $row3['style'];
         $schedule = $row3['schedule'];
         $color = $row3['color'];
         $size_id = $row3['size_title'];
         $operation_code = $row3['operation_id'];
         $good_quantity = $row3['good_qty'];
         $rejected_quantity = $row3['rejected_qty'];

         $insert_query1="INSERT ignore INTO $brandix_bts.open_style_wip (style, schedule, color, operation_code, size, created_time) values ('$style','$schedule','$color','$operation_code','$size_id','$today')";
         //echo $insert_query .'<br>';
         $insert_log_result1 = mysqli_query($link,$insert_query1) or exit('Insert  Error1');

         $update_query_log="UPDATE $brandix_bts.open_style_wip SET good_qty = '$good_quantity',rejected_qty = '$rejected_quantity',updated_time = '$today' where style = '$style' and schedule ='$schedule' and color ='$color' and size ='$size_id' and operation_code = $operation_code";
             //  echo  $update_log.'<br>updated';
          $update_log_res = mysqli_query($link,$update_query_log) or exit('Update  Error1');
      }

   }  

}
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");

?>