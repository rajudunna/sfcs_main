<?php
error_reporting(0);
  include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
  $sum ='';
  $asum ='';  
  foreach($sizes_array as $size)
  {
      $sum.= $size." + ";
      $asum.= "order_s_".$size." + ";
  }


   $operation_code = [];
   $opertion_names = [];
   $wip_quantity = [];
   $main_quantity = [];
   $wip = [];
   $operation = [];
   $style = '';
   $schedule = '';
   $color = '';
   $size = '';
   $order_qty = '';
   $cono = '';
   $ops_seq = '';
   $seq_id = '';
   $ops_order = '';
   $main_good_qty =[];
   $main_rejected_qty = [];
   $bcd_good_qty1 = [];
   $bcd_rejected_qty1 = [];
   $main_data = [];
   $pre_op_code = 0;
   //To get default Operations
    $get_operations_workflow= "SELECT DISTINCT(operation_code) FROM $brandix_bts.`tbl_style_ops_master` where operation_code not in ('10','1') order by operation_order*1";
   // echo $get_operations_workflow;
    $result1 = $link->query($get_operations_workflow);
    $op_count = mysqli_num_rows($result1);
    if($op_count>0)
    {
        while($row3 = $result1->fetch_assoc())
        {
            $operation_code[] = $row3['operation_code'];
        }
    }
// echo date("Y-m-d H:i:s")."-2st <br/>";
    $operation_codes_str = implode(',',$operation_code);
    //To get operation names
    $get_ops_query = "SELECT operation_name,operation_code FROM $brandix_bts.tbl_orders_ops_ref where operation_code in ($operation_codes_str) order by field(operation_code,$operation_codes_str) ";
   // echo $get_ops_query;
    $ops_query_result=$link->query($get_ops_query);
    $op_count = mysqli_num_rows($ops_query_result);
    if($op_count >0)
    {       
        while ($row4 = $ops_query_result->fetch_assoc())
        {
            $opertion_names[]= ['op_name'=>$row4['operation_name'],'op_code'=>$row4['operation_code']];
            $ops_get_code[$row4['operation_code']] = $row4['operation_name'];
        }
    }
    // echo date("Y-m-d H:i:s")."-3st <br/>";
      $today=date("Y-m-d");
        //$today='2019-04-27 12:00:00';
        

     $get_style_wip_data="select * FROM $brandix_bts.open_style_wip group by style,schedule,color,size";
     //echo  $get_style_wip_data;
     $get_style_data_result =$link->query($get_style_wip_data);
     // echo date("Y-m-d H:i:s")."-4st <br/>";
     while ($row1 = $get_style_data_result->fetch_assoc())
     {
        $style = $row1['style'];
        $schedule = $row1['schedule'];
        $color = $row1['color'];
        $size = $row1['size'];
        $operation[] = $row1['operation_code'];
        

        $get_size_title = "select size_id from $brandix_bts.bundle_creation_data_temp where style='$style' and schedule='$schedule' and color='$color' and size_title='$size'";
        //echo $get_size_title;
        $get_size_title_result =$link->query($get_size_title);
        while ($row110 = $get_size_title_result->fetch_assoc())
        {
           $size_code = $row110['size_id'];
        }

         $asum_str = rtrim($asum,' + ');
        //To get Order Qty
        $get_order_qty="select (order_s_$size_code) as order_qty,co_no from $bai_pro3.bai_orders_db_confirm where order_style_no='$style' and order_del_no='$schedule' and order_col_des='$color' ";
        //echo  $get_order_qty;
        $get_order_result =$link->query($get_order_qty);
        // echo date("Y-m-d H:i:s")."-5st ".$i++."<br/>";
        while ($row5 = $get_order_result->fetch_assoc())
        {
            $order_qty = $row5['order_qty'];
            $cono = $row5['co_no'];
        }
        foreach ($operation_code as $key => $value) 
        {
          $main_good_qty[$value] = 0;
          $main_rejected_qty[$value] = 0;
          $bcd_good_qty1[$value] = 0;
          $bcd_rejected_qty1[$value] = 0;
          $bcd_rec[$value] =0;
          $bcd_rej[$value] =0;
        }

        $single_data = ['style'=>$style,'schedule'=>$schedule,'color'=>$color,'size'=>$size,'cono'=>$cono,'orderqty'=>$order_qty];
        
        $operations = implode(',',$operation);

        $get_qty_data = "select COALESCE(SUM(good_qty),0) as good_qty,COALESCE(SUM(rejected_qty),0) as rejected_qty,operation_code From $brandix_bts.open_style_wip where style='$style' and schedule='$schedule' and color='$color' and size='$size' group by operation_code";
       // echo $get_qty_data;
        $get_qty_result =$link->query($get_qty_data);
          // echo date("Y-m-d H:i:s")."-6st  <br/>";
        while ($row2 = $get_qty_result->fetch_assoc())
        {
            $main_good_qty[$row2['operation_code']] = $row2['good_qty'];
            $main_rejected_qty[$row2['operation_code']] = $row2['rejected_qty'];
        }
        
        $get_temp_data ="select COALESCE(SUM(recevied_qty),0) as good_qty,COALESCE(SUM(rejected_qty),0) as rejected_qty,operation_id From $brandix_bts.bundle_creation_data_temp Where style='$style' and schedule='$schedule' and color='$color' and size_title='$size' and date(date_time) = '$today' group by operation_id";
       // echo $get_temp_data;
         $get_temp_data_result =$link->query($get_temp_data);
           // echo date("Y-m-d H:i:s")."-7st <br/>";
         while ($row = $get_temp_data_result->fetch_assoc())
         {
            $bcd_good_qty1[$row['operation_id']] = $row['good_qty'];
            $bcd_rejected_qty1[$row['operation_id']] = $row['rejected_qty'];
         }

         //To caliculate WIP
          $bcd_data_query = "SELECT COALESCE(SUM(recevied_qty),0) as recevied,operation_id,COALESCE(sum(rejected_qty),0) as rejection from $brandix_bts.bundle_creation_data_temp where style='$style' and schedule ='$schedule' and color='$color' and size_title='$size' group by operation_id";
          // echo $bcd_data_query;
          $bcd_get_result =$link->query($bcd_data_query);
          //echo $bcd_data_query.'<br/>';
            // echo date("Y-m-d H:i:s")."-8st <br/>";
          while ($row6 = $bcd_get_result->fetch_assoc())
          {
              $bcd_rec[$row6['operation_id']] = $row6['recevied'];
              $bcd_rej[$row6['operation_id']] = $row6['rejection'];
          }

            
             //To get default Operations for WIP
              $get_operations_workflow_wip= "SELECT DISTINCT(operation_code) FROM $brandix_bts.`tbl_style_ops_master` where display_operations='yes' and style='$style' and color='$color' order by operation_order*1";
             // echo $get_operations_workflow;
              $result123 = $link->query($get_operations_workflow_wip);
              $op_count1 = mysqli_num_rows($result123);
              if($op_count1>0)
              {
                  while($row345 = $result123->fetch_assoc())
                  {
                      $operation_code1[] = $row345['operation_code'];
                  }
              }

            foreach ($operation_code1 as $key => $value) 
            {
                $wip[$value] = 0;
                $diff = 0;
                if($value == 15)
                {
                    $wip[$value] = $order_qty -($bcd_rec[$value]+$bcd_rej[$value]);
                }
                else
                {   
                    $ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code='$value'";
                    //echo $ops_seq_check;
                    $result_ops_seq_check = $link->query($ops_seq_check);
                    while($row7 = $result_ops_seq_check->fetch_assoc()) 
                    {
                        $ops_seq = $row7['ops_sequence'];
                        $seq_id = $row7['id'];
                        $ops_order = $row7['operation_order'];
                    }
                    $post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_sequence = '$ops_seq'  AND CAST(operation_order AS CHAR) < '$ops_order' AND display_operations='yes' ORDER BY operation_order DESC LIMIT 1";
                    $result_post_ops_check = $link->query($post_ops_check);
                    //echo $post_ops_check.'<br/>';
                    $row8 = mysqli_fetch_array($result_post_ops_check);
                    $count= mysqli_num_rows($result_post_ops_check); 
                    $pre_op_code = $row8['operation_code'];
                    
                   
                     if($value == 200)
                     {
                         $diff= $bcd_rec[$pre_op_code] - ($bcd_rec[$value]+$bcd_rej[$value]);
                     }else
                    {
                      $diff= $bcd_rec[$pre_op_code] - ($bcd_rec[$value]+$bcd_rej[$value]);
                    }
                  
                    if($diff < 0)  
                    {
                        $diff = 0;
                    }

                    $wip[$value] = $diff;
                  
                }

               if(strlen($ops_get_code[$value]) > 0){
                      
                    $single_data['good'.$value] = $main_good_qty[$value]+$bcd_good_qty1[$value];

                    $single_data['rej'.$value] = $main_rejected_qty[$value]+$bcd_rejected_qty1[$value];

                    $single_data['wip'.$value]= $wip[$value];

               }
            }
            array_push($main_data,$single_data);
            unset($operation_code1);
            unset($single_data);
            unset($main_good_qty);
            unset($main_rejected_qty);
            unset($bcd_good_qty1);
            unset($bcd_rejected_qty1);
            unset($bcd_rec);
            unset($bcd_rej);
            unset($wip);
      //unset($ops_get_code);
     
        
      }   

        $result['main_data'] = $main_data;
        //$result['wip_data'] = $wip_quantity;
        $result['operations'] = $opertion_names;
        echo json_encode($result);
       
?>