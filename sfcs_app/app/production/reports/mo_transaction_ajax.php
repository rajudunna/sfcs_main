<?php
	
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
error_reporting(0);

if(isset($_GET['submit']))
{

  $counter = 0;
    $style = $_GET['style'];
    $schedule = $_GET['schedule'];
    $color = $_GET['color'];
	$get_mo_details="select * from bai_pro3.mo_details where style='".$style."' and schedule='". $schedule."' and color='".$color."'";
	//echo $get_mo_details;
	$result1 = $link->query($get_mo_details);
	while($row2 = $result1->fetch_assoc())
	{
		$mo_details[]= $row2['mo_no'];
		$mo_qty[]= $row2['mo_quantity'];
		//$color[]= $row2['color'];
		$size[]= $row2['size'];
	}
  // var_dump($mo_details);

  $get_operations= "select DISTINCT(operation_code) from $brandix_bts.tbl_style_ops_master where style='$style' and color='$color'";
  //echo $get_operations;
  $result2 = $link->query($get_operations);
  while($row2 = $result2->fetch_assoc())
  {
    $operation_code[] = $row2['operation_code'];
  }
  $opertions = implode(',',$operation_code);

  $get_ops_query = "SELECT operation_name,operation_code FROM $brandix_bts.tbl_orders_ops_ref where operation_code in ($opertions)";
	 //echo $get_ops_query;
	$ops_query_result=$link->query($get_ops_query);
	while ($row3 = $ops_query_result->fetch_assoc())
	{
	  $ops_get_code[$row3['operation_code']] = $row3['operation_name'];
  }
   // var_dump($ops_get_code);
   $table_data = "<table id='excel_table' class = 'col-sm-12 table-bordered table-striped table-condensed cf'>
   <thead class='cf'>
   <tr><th>S.NO</th><th>Size</th>
   <th>Color</th><th>MO Number</th><th>Mo Quantity</th>";
  foreach ($operation_code as $op_code) 
  {
      $table_data .= "<th>".$ops_get_code[$op_code]."</th>";
  }
   $table_data .= "</tr></thead><tbody>";
   // die();
   foreach ($mo_details as $key => $mos)
   {
   	    $counter++;
   	    $table_data .= "<tr><td>$counter</td><td>$size[$key]</td><td>$color[$key]</td><td>$mos</td><td>$mo_qty[$key]</td>";
	   	foreach ($operation_code as $key_op => $value)
	    {
	       $good_qty = 0;
	       $get_m3_quantities="select sum(good_quantity) as good_quantity from $bai_pro3.mo_operation_quantites 
	                           where mo_no = $mos and op_code='".$value."'";
                             //echo $get_m3_quantities;
	       $get_m3__result=$link->query($get_m3_quantities);
	       while ($row = $get_m3__result->fetch_assoc())
	       {
	       	   $good_qty = $row['good_quantity'];
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


if( isset($_GET['style']) && isset($_GET['schedule']) )
{
  $style1 = $_GET['style'];
  $schedule1 = $_GET['schedule'];
  $get_color="select distinct(color) from $bai_pro3.mo_details where style ='$style1' and schedule='$schedule1'";
  $result1 = $link->query($get_color);
  while($row1 = $result1->fetch_assoc())
  {
      $color[] = $row1['color'];
  }
  $json['color'] =$color;
  echo json_encode($json);

  
}
else if(isset($_GET['style']))
{
  $style1 = $_GET['style'];
  $get_schedule="select distinct(schedule) from $bai_pro3.mo_details where style ='$style1' ";
  //echo $get_schedule;
  $result2 = $link->query($get_schedule);
  while($row1 = $result2->fetch_assoc())
  {
      $schedule[] = $row1['schedule'];
  }
  $json['schedule'] =$schedule; 
  echo json_encode($json);
}
else
{
    $get_style="select distinct(style) from $bai_pro3.mo_details";
    $result3 = $link->query($get_style);
    while($row1 = $result3->fetch_assoc())
    {
        $style[] = $row1['style'];
    }

   $json['style'] = $style;
   echo json_encode($json);
}




?>