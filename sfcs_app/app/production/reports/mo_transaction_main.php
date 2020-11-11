<?php

include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
error_reporting(0);
$plantcode = $_SESSION['plantCode'];
if(isset($_GET['style']))
  	$styles = $_GET['style'];
else
{
    //function to get style from mp_color_details
    if($plantcode!=''){
      // $result_mp_color_details=getMpColorDetail($plantcode);
      // $style=$result_mp_color_details['style'];

      $qry_mp_color_detail="SELECT style FROM $pps.mp_color_detail WHERE plant_code='$plantcode' AND is_active=1";
      $mp_color_detail_result=mysqli_query($link_new, $qry_mp_color_detail) or exit("Sql Error at getting ".mysqli_error($GLOBALS["___mysqli_ston"]));
      $mp_color_detail_num=mysqli_num_rows($mp_color_detail_result);
      if($mp_color_detail_num>0){
          while($mp_color_detail_row=mysqli_fetch_array($mp_color_detail_result))
              {
                  
                  $style[]=$mp_color_detail_row["style"];
              }
              
              $style=array_unique($style);
      }
    }  
  // $get_style="SELECT DISTINCT(order_style_no) FROM $bai_pro3.bai_orders_db_confirm WHERE order_tid IN(SELECT order_tid FROM $bai_pro3.plandoc_stat_log )";
	//   $result1 = $link->query($get_style);
	//     while($row1 = $result1->fetch_assoc())
	//     {
	//         $style[] = $row1['order_style_no'];
	//     }
	  $styles = implode('","',$style);
	 
}

  $styles = '"'.$styles.'"';
  // $get_schedule="SELECT DISTINCT(order_del_no) FROM $bai_pro3.bai_orders_db_confirm WHERE order_style_no IN ($styles)";
  // $result2 = $link->query($get_schedule);
  // while($row1 = $result2->fetch_assoc())
  // {
  //   $schedule[] = $row1['order_del_no'];
  // }
  /**getting schedules */
  $master_po_details_id=array();
  $qry_mp_color_detail="SELECT master_po_details_id FROM $pps.mp_color_detail WHERE plant_code='$plantcode' AND style IN ($styles) AND is_active=1";
  $mp_color_detail_result=mysqli_query($link_new, $qry_mp_color_detail) or exit("Sql Error at master po details id".mysqli_error($GLOBALS["___mysqli_ston"]));
  $mp_color_detail_num=mysqli_num_rows($mp_color_detail_result);
  if($mp_color_detail_num>0){
      while($mp_color_detail_row=mysqli_fetch_array($mp_color_detail_result))
          {
              
              $master_po_details_id[]=$mp_color_detail_row["master_po_details_id"];
          }

      $schedule=array();
      $qry_mp_mo_qty="SELECT schedule FROM $pps.mp_mo_qty WHERE plant_code='$plantcode' AND master_po_details_id IN ('".implode("','" , $master_po_details_id)."') AND is_active=1";
      $mp_mo_qty_result=mysqli_query($link_new, $qry_mp_mo_qty) or exit("Sql Error at getting schedules".mysqli_error($GLOBALS["___mysqli_ston"]));
      $mp_mo_qty_num=mysqli_num_rows($mp_mo_qty_result);
      if($mp_mo_qty_num>0){
          while($mp_mo_qty_row=mysqli_fetch_array($mp_mo_qty_result))
              {
                  
                  $schedule[]=$mp_mo_qty_row["schedule"];
              }
              
              $bulk_schedule=array_unique($schedule);
      }
  }
  $schedules = implode(',',$bulk_schedule);
  
  /**getting color details */
  $color=array();
  $qry_mp_mo_qty="SELECT color FROM $pps.mp_mo_qty WHERE plant_code='$plantcode' AND schedule IN ($schedules) AND is_active=1";
  $mp_color_detail_result=mysqli_query($link_new, $qry_mp_mo_qty) or exit("Sql Error at getting colors".mysqli_error($GLOBALS["___mysqli_ston"]));
  $mp_color_detail_num=mysqli_num_rows($mp_color_detail_result);
  if($mp_color_detail_num>0){
      while($mp_color_detail_row=mysqli_fetch_array($mp_color_detail_result))
          {
              
              $color[]=$mp_color_detail_row["color"];
          }
      }
      $color_bulk=array_unique($color);

    $color_bulk = implode(',',$color_bulk);
    $color_bulk = '"'.$color_bulk.'"';

    /**getting MPO's */
    $master_po_details_id=array();
    $qry_mmp_mo_qty="SELECT master_po_details_id FROM $pps.`mp_mo_qty` WHERE plant_code='$plantcode' AND color IN ($color_bulk) AND is_active=1";
    //echo $qry_mmp_mo_qty;
    $mp_mo_qty_result=mysqli_query($link_new, $qry_mmp_mo_qty) or exit("Sql Error at master po details".mysqli_error($GLOBALS["___mysqli_ston"]));
    $mp_mo_qty_num=mysqli_num_rows($mp_mo_qty_result);
    /**From above query we get master po details id */
    if($mp_mo_qty_num>0){
        while($mp_mo_qty_row=mysqli_fetch_array($mp_mo_qty_result))
            {
                
                $master_po_details_id[]=$mp_mo_qty_row["master_po_details_id"];
            }

            $master_po_details_id=array_unique($master_po_details_id);
            /**Based master po details id we can get masetr po number */    
            $master_po_number=array();
            $qry_mp_color_details="SELECT master_po_number FROM $pps.mp_color_detail WHERE master_po_details_id IN ('".implode("','" , $master_po_details_id)."')";
            $mp_color_details_result=mysqli_query($link_new, $qry_mp_color_details) or exit("Sql Error at master PO number".mysqli_error($GLOBALS["___mysqli_ston"]));
            $mp_color_details_num=mysqli_num_rows($mp_color_details_result);
            if($mp_color_details_num>0){
                while($mp_color_details_row=mysqli_fetch_array($mp_color_details_result))
                    {
                        
                        $master_po_number[]=$mp_color_details_row["master_po_number"];
                    }
            }


            /**So we will show master description based on masetr po number */
            $master_po_description=array();
            $qry_toget_podescri="SELECT master_po_description,master_po_number,mpo_serial FROM $pps.mp_order WHERE master_po_number IN ('".implode("','" , $master_po_number)."') AND is_active=1";
            $toget_podescri_result=mysqli_query($link_new, $qry_toget_podescri) or exit("Sql Error at mp_order".mysqli_error($GLOBALS["___mysqli_ston"]));
            $toget_podescri_num=mysqli_num_rows($toget_podescri_result);
            if($mp_color_details_num>0){
            while($toget_podescri_row=mysqli_fetch_array($toget_podescri_result))
              {   
                  $mpo_seq = getMasterPoSequence($toget_podescri_row['mpo_serial'],$plantcode);
                  $masterr_po_seq = $mpo_seq."/".$toget_podescri_row["master_po_description"];
                  $master_po_description[$masterr_po_seq]=$toget_podescri_row["master_po_number"];
              }
            }
            $po=array_unique($master_po_description);
    }


    $sub_po_description=array();
    /**Below query to get sub po's by using master po's */
    $qry_toget_sub_order="SELECT po_description,po_number,mpo_serial,sub_po_serial FROM $pps.mp_sub_order LEFT JOIN $pps.mp_order ON mp_order.master_po_number = mp_sub_order.master_po_number WHERE mp_sub_order.master_po_number='$get_mpo' AND mp_sub_order.plant_code='$plantcode' AND mp_sub_order.is_active=1";
    $toget_sub_order_result=mysqli_query($link_new, $qry_toget_sub_order) or exit("Sql Error at mp_order".mysqli_error($GLOBALS["___mysqli_ston"]));
    $toget_podescri_num=mysqli_num_rows($toget_sub_order_result);
    if($toget_podescri_num>0){
        while($toget_sub_order_row=mysqli_fetch_array($toget_sub_order_result))
            {
                $mpo_sequence = getMasterPoSequence($toget_sub_order_row['mpo_serial'],$plantcode);
                $spo_sequnce = $mpo_sequence."-".$toget_sub_order_row['sub_po_serial'];
                $spo_seq_desc = $spo_sequnce."/".$toget_sub_order_row['po_description'];
                $sub_po_description[$spo_seq_desc]=$toget_sub_order_row["po_number"];
            }
    }
    


   $json['style'] = $style;
   $json['schedule'] =$bulk_schedule;
   $json['color'] =$color_bulk;
   $json['po'] =$po;
   $json['subpo'] =$sub_po_description;
   echo json_encode($json);


?>