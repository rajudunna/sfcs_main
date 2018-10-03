<?php
	
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
error_reporting(0);

if(isset($_GET['schedule']))
{

$counter = 0;
    $style = $_GET['style'];
    $schedule = $_GET['schedule'];
	$get_mo_details="select * from bai_pro3.mo_details where style='".$style."' and schedule='". $schedule."'";
	//echo $get_mo_details;
	$result2 = $link->query($get_mo_details);
	while($row2 = $result2->fetch_assoc())
	{
		$mo_details[]= $row2['mo_no'];
		$mo_qty[]= $row2['mo_quantity'];
		$color[]= $row2['color'];
		$size[]= $row2['size'];
	}
  // var_dump($mo_details);
    $get_ops_query = "SELECT operation_code FROM $brandix_bts.tbl_orders_ops_ref where default_operation = 'Yes'";
	 //echo $get_ops_query;
	$ops_query_result=$link->query($get_ops_query);
	while ($row3 = $ops_query_result->fetch_assoc())
	{
	  $ops_get_code[] = $row3['operation_code'];
    }
   // var_dump($ops_get_code);
   $table_data = "<table id='excel_table' class = 'col-sm-12 table-bordered table-striped table-condensed cf'>
   <thead class='cf'>
   <tr><th>S.NO</th><th>Size</th>
   <th>Color</th><th>MO Number</th><th>Mo Quantity</th>";
   foreach($ops_get_code as $key => $value)
   {
   	  $table_data .= "<th>$value</th>";
   }
   $table_data .= "</tr></thead><tbody>";
   // die();
   foreach ($mo_details as $key => $mos)
   {
   	$counter++;
   	    $table_data .= "<tr><td>$counter</td><td>$size[$key]</td><td>$color[$key]</td><td>$mos</td><td>$mo_qty[$key]</td>";
	   	foreach ($ops_get_code as $key_op => $value)
	    {
	       $get_m3_quantities="select sum(good_quantity)as good_quantity from $bai_pro3.mo_operation_quantites where mo_no in ($mos) and op_code='".$value."' group by mo_no";
	       $get_m3__result=$link->query($get_m3_quantities);
	       while ($row = $get_m3__result->fetch_assoc())
	       {
	       	   $good_qty = $row['good_quantity'];
	       }
	        if($good_qty == '')
            $good_qty = 0;
	       $table_data .= "<td>$good_qty</td>";
	    }
	    $table_data .= "</tr>";

   }
    echo $table_data."</tbody></table>";
 
    
}
else
{

    $get_style="select distinct(style) from $bai_pro3.mo_details";
    $result1 = $link->query($get_style);
    while($row1 = $result1->fetch_assoc())
    {
        $style[] = $row1['style'];
    }

    $get_schedule="select distinct(schedule) from $bai_pro3.mo_details";
    $result2 = $link->query($get_schedule);
    while($row1 = $result2->fetch_assoc())
    {
		$schedule[] = $row1['schedule'];
    }
   $json['style'] = $style;
   $json['schedule'] =$schedule;
   echo json_encode($json);
}


?>