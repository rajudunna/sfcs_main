<?php
	
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
error_reporting(0);
$plantcode = $_SESSION['plantCode'];
if(isset($_GET['submit']))
{
  $row_count = 0;
  $counter = 0;
    $style = $_GET['style'];
    $schedule = $_GET['schedule'];
    $schedule = $_GET['color'];
    $po = $_GET['po'];
    $subpo = $_GET['subpo'];
	// $get_mo_details="select * from bai_pro3.mo_details where style='".$style."' and schedule='". $schedule."'";
	// $result1 = $link->query($get_mo_details);
	// while($row2 = $result1->fetch_assoc())
	// {
  //   $row_count++;
	// 	$mo_details[]= $row2['mo_no'];
	// 	$mo_qty[]= $row2['mo_quantity'];
	// 	$color1[]= $row2['color'];
  //   $colors[]= $row2['color'];
	// 	$size[]= $row2['size'];
	// }
  //  $color = implode('","',$color1);
  //  $color = '"'.$color.'"';
  // $get_operations= "select DISTINCT(operation_code) from $brandix_bts.tbl_style_ops_master where style='$style' and color IN ($color)";
  // $result2 = $link->query($get_operations);
  // while($row2 = $result2->fetch_assoc())
  // {
  //   $operation_code[] = $row2['operation_code'];
  // }
  // $opertions = implode(',',$operation_code);

  // $get_ops_query = "SELECT operation_name,operation_code FROM $brandix_bts.tbl_orders_ops_ref where operation_code in ($opertions)";
	// $ops_query_result=$link->query($get_ops_query);
	// while ($row3 = $ops_query_result->fetch_assoc())
	// {
	//   $ops_get_code[$row3['operation_code']] = $row3['operation_name'];
  // }
  
    $qryGetOps="SELECT DISTINCT(operation) as ops FROM $pts.fg_m3_transaction WHERE sub_po='$subpo' AND plant_code='$plantcode' AND is_active=1 order by operation";
    $toget_sub_order_result=mysqli_query($link_new, $qryGetOps) or exit("Sql Error at getting operations".mysqli_error($GLOBALS["___mysqli_ston"]));
    $toget_podescri_num=mysqli_num_rows($toget_sub_order_result);
  if($toget_podescri_num == 0)
  {
      echo "<div><font color='red' size='5'>No Data Found</font></div>";
  }
  else
  {  
   $table_data = "<table id='excel_table' class = 'col-sm-12 table-bordered table-striped table-condensed cf'>
   <thead class='cf'>
   <tr><th>S.NO</th><th>Size</th>
   <th>Color</th><th>MO Number</th><th>Mo Quantity</th>";
   while($opsRow=mysqli_fetch_array($toget_sub_order_result))
    { 
      //$spo_sequnce = $mpo_sequence."-".$toget_sub_order_row['sub_po_serial'];
      $table_data .= "<th>".$opsRow['ops']."</th>";
    }
  // foreach ($operation_code as $op_code) 
  // {
  //     $table_data .= "<th>".$ops_get_code[$op_code]."</th>";
  // }
   $table_data .= "</tr></thead><tbody>";

   $qryMoquantities="SELECT DISTINCT(mo_number) AS mo,SUM(quantity) AS qty FROM $pts.fg_m3_transaction WHERE sub_po='$subpo' AND plant_code='$plantcode' AND is_active=1";
   $resultMoQant=mysqli_query($link_new, $qryMoquantities) or exit("Sql Error at getting operations".mysqli_error($GLOBALS["___mysqli_ston"]));
    $toget_podescri_num=mysqli_num_rows($resultMoQant);
    while($moRow=mysqli_fetch_array($resultMoQant))
   {  
        $mos=$moRow['mo'];
        $qty=$moRow['qty'];
         $counter++;
      /**getting mo quantiy,color,size */
      $qryGetMoSize="SELECT color_name,size_name FROM $oms.oms_products_info WHERE mo_numebr='$mos'";
      $resultqryGetMoSize=mysqli_query($link_new, $qryGetMoSize) or exit("Sql Error at getting operations".mysqli_error($GLOBALS["___mysqli_ston"]));
      $toget_podescri_num=mysqli_num_rows($resultqryGetMoSize);
      while($sizeRow=mysqli_fetch_array($resultqryGetMoSize))
      { 
        $color_name=$moRow['color_name'];
        $size_name=$moRow['size_name'];
      }

      /**getting mo quantiy,color,size */
      $qryGetMoQty="SELECT mo_quantity FROM $oms.oms_mo_details WHERE mo_numebr='$mos'";
      $resultqryGetMoQty=mysqli_query($link_new, $qryGetMoSize) or exit("Sql Error at getting operations".mysqli_error($GLOBALS["___mysqli_ston"]));
      $toget_podescri_num=mysqli_num_rows($resultqryGetMoQty);
      while($moQtyRow=mysqli_fetch_array($resultqryGetMoQty))
      { 
        $mo_quantity=$moQtyRow['mo_quantity'];
      }
   	  $table_data .= "<tr><td>$counter</td><td>$size_name</td><td>$color_name</td><td>$mos</td><td>$mo_quantity</td>";
       while($opsRow=mysqli_fetch_array($toget_sub_order_result))
       { 
         //$spo_sequnce = $mpo_sequence."-".$toget_sub_order_row['sub_po_serial'];
         //$table_data .= "<th>".$opsRow['ops']."</th>";
	       $good_qty = 0;
	       $get_m3_quantities="select SUM(quantity) AS qty FROM $pts.fg_m3_transaction 
	                           where mo_number = '$mos' and op_code='".$opsRow['ops']."'";
                             //echo $get_m3_quantities;
	       $get_m3__result=$link->query($get_m3_quantities);
         while($row=mysqli_fetch_array($toget_sub_order_result))
	       {
	       	   $good_qty = $row['qty'];
	       }
	       if($good_qty == ''){
               $good_qty = 0;
	       }
	       $table_data .= "<td>".$good_qty."</td>";
	    }
	    $table_data .= "</tr>";

   }
    echo $table_data."</tbody></table>";

    
 }
    
}

?>