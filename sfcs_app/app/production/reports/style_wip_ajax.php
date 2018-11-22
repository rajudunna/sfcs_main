<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
error_reporting(0);

$counter = 0;
$style = $_GET['style'];
$schedule = $_GET['schedule'];
$color = $_GET['color'];
$size_get = $_GET['size'];

if($schedule == 'all')
{
    $get_operations= "select DISTINCT(operation_code) from $brandix_bts.tbl_style_ops_master where style='$style' ";

    $bcd_root_query = "SELECT * from $brandix_bts.bundle_creation_data where style='$style' group by schedule,color";

}

else if ($schedule == 'all' && $color != 'all')
{
	$get_operations= "select DISTINCT(operation_code) from $brandix_bts.tbl_style_ops_master where style='$style' and color='$color'";

	$bcd_root_query = "SELECT * from $brandix_bts.bundle_creation_data where style='$style' and color ='$color' 
	                   group by schedule";                  

}

else if ($schedule != 'all' && $color == 'all')
{
	$get_operations= "select DISTINCT(operation_code) from $brandix_bts.tbl_style_ops_master where style='$style'";

	$bcd_root_query = "SELECT * from $brandix_bts.bundle_creation_data where style='$style' and schedule ='$schedule' 
	                   group by color";                  

}
else
{	
	$get_operations= "select DISTINCT(operation_code) from $brandix_bts.tbl_style_ops_master where style='$style' and color='$color'";

	$bcd_root_query = "SELECT * from $brandix_bts.bundle_creation_data where style='$style' and schedule ='$schedule' and color='$color'";
	if($_GET['size']!='')
    {
   	   $bcd_root_query =  $bcd_root_query.' group by size_title';  
    }
    else
    {
    	$bcd_root_query =  $bcd_root_query.' limit 1';
    }
}	



	$result1 = $link->query($get_operations);
	while($row2 = $result1->fetch_assoc())
	{
		// if( $operation_code == 10)
		// 	continue;
	  $operation_code[] = $row2['operation_code'];
	}
	//var_dump($operation_code);
	//echo $get_operations;
	$opertions = implode(',',$operation_code);

	$bcd_data_query .= " and operation_id in ($opertions)";

	$get_ops_query = "SELECT operation_name,operation_code FROM $brandix_bts.tbl_orders_ops_ref where operation_code in ($opertions)  ";
	//echo $get_ops_query;
	$ops_query_result=$link->query($get_ops_query);
	while ($row1 = $ops_query_result->fetch_assoc())
	{
	  $ops_get_code[$row1['operation_code']] = $row1['operation_name'];
	}

	// echo $get_ops_query;
    $col_span = count($ops_get_code);
	$table_data = "<table id='excel_table' class = 'col-sm-12 table-bordered table-striped table-condensed cf'>
   <thead class='cf'>
   <tr>
	   <th rowspan=2>S.NO</th>
	   <th rowspan=2>Schedule</th>
	   <th rowspan=2>Color</th>";
	if($size_get != '')
	{
	    $table_data .="<th rowspan=2>Size</th>";
	}

    $table_data .="
	   <th rowspan=2>Order Qty</th>
	   <th colspan = $col_span>Operation Reported Qty</th>
	   <th colspan = $col_span>Wip</th>
	</tr>
	<tr>";
			
		foreach ($operation_code as $op_code) 
		{
			$table_data .= "<th>$ops_get_code[$op_code]</th>";
		}
		
	    foreach ($operation_code as $op_code) 
	    {
	   	    $table_data .= "<th>$ops_get_code[$op_code]</th>";
	    }

    $table_data .= "</tr></thead><tbody>";
    

    if($_GET['size']!='' && ($color == 'all' || $schedule == 'all') )
    {
   	   $bcd_root_query =  $bcd_root_query.',size_title';  
    }
//echo $bcd_root_query;
    //To get order Qty
    foreach($sizes_array as $size)
    {
	    $sum.= $size." + ";
	    $asum.= "order_s_".$size." + ";
    }
	//$sum_str = rtrim($sum,' + ');
	$asum_str = rtrim($asum,' + ');
    $bcd_root_result = mysqli_query($link,$bcd_root_query);
    
    while($row_main = mysqli_fetch_array($bcd_root_result)){
    	
        $style = $row_main['style'];
	   	$schedule = $row_main['schedule'];
	   	$color = $row_main['color'];
        $size = $row_main['size_title'];
        $size_code =  $row_main['size_id'];


        $get_order_qty="select sum($asum_str) as order_qty from $bai_pro3.bai_orders_db_confirm where order_style_no='$style' and order_del_no='$schedule' and order_col_des='$color' ";
			
        $bcd_data_query = "SELECT SUM(recevied_qty) as recevied,operation_id from $brandix_bts.bundle_creation_data 
                           where style='$style' and schedule ='$schedule' and color='$color'";
       // echo $get_order_qty;
        if($_GET['size'] != '')
	    {
	   	   $bcd_data_query .= " and size_title='$size' group by operation_id";
	   	   $get_order_qty.= " and title_size_$size_code = '$size'";
	    }else{
	   	   
	       $bcd_data_query .= " group by operation_id";
	    }
       // echo "$get_order_qty";

	    $get_order_result =$link->query($get_order_qty);
		while ($row2 = $get_order_result->fetch_assoc())
		{
			$order_qty = $row2['order_qty'];
		}

	    $bcd_get_result =$link->query($bcd_data_query);
	    //echo $bcd_data_query.'<br/>';
	    while ($row3 = $bcd_get_result->fetch_assoc())
	    {
		    $bcd_rec[$row3['operation_id']] = $row3['recevied'];
	    }

	    $counter++;
	    $table_data .= "<tr><td>$counter</td><td>$schedule</td><td>$color</td>";
        if($size_get != '')
        {
	       $table_data .="<td>$size</td>";
        }

	    $table_data .="<td>$order_qty</td>";

	    foreach ($operation_code as $key => $value) 
	    {
	    	if($bcd_rec[$value] == '')
	    		$table_data .= "<td>0</td>";
	    	else	
			   $table_data .= "<td>".$bcd_rec[$value]."</td>";
		} 
        
		foreach ($operation_code as $key => $value) 
	    {
	    	// if($value == 10)
	    	// 	continue;
	    	if($value == 15)
	    	{
                $wip[$value] = $order_qty - $bcd_rec[$value];
	    	}
	    	else
	    	{	
                $ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master 
                                where style='$style' and color = '$color' and operation_code='$value'";
                //echo $ops_seq_check;
				$result_ops_seq_check = $link->query($ops_seq_check);
				while($row = $result_ops_seq_check->fetch_assoc()) 
				{
					$ops_seq = $row['ops_sequence'];
					$seq_id = $row['id'];
					$ops_order = $row['operation_order'];
				}
				$post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_sequence = $ops_seq  AND CAST(operation_order AS CHAR) < '$ops_order' AND operation_code not in (10) ORDER BY operation_order DESC LIMIT 1";
				$result_post_ops_check = $link->query($post_ops_check);
                //echo $post_ops_check.'<br/>';
				$row = mysqli_fetch_array($result_post_ops_check);
                $pre_op_code = $row['operation_code'];
                $diff= $bcd_rec[$pre_op_code] - $bcd_rec[$value];

                if($diff < 0)
                	$diff = 0;

				$wip[$value] = $diff;
			}

			$table_data .= "<td>".$wip[$value]."</td>";
		} 

	   	$table_data .= "</tr>";
    }
	  
    echo $table_data."</tbody></table>";

   





?>