<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
error_reporting(0);
if($_GET['some'] == 'bundle_no')
{
	    //Bundle Wise Report Code
		$bundle_number = $_GET['bundle'];
		$CAT = 'sewing';

		$get_details="select order_style_no,order_del_no,order_col_des,size_code,carton_act_qty From $bai_pro3.packing_summary_input where tid='$bundle_number'";
		//echo $get_details;
		$sql_result1 = $link->query($get_details);
		while($sql_row = $sql_result1->fetch_assoc())
		{
			$style = $sql_row['order_style_no'];
			$schedule = $sql_row['order_del_no'];
			$color = $sql_row['order_col_des'];
			$size = $sql_row['size_code'];
			$bundle_qty = $sql_row['carton_act_qty'];
		}
	    
			

			$sewing_op_codes = "SELECT group_concat(operation_code) as op_codes FROM $brandix_bts.tbl_orders_ops_ref WHERE category = '$CAT' and display_operations='yes'";
			$row = mysqli_fetch_array(mysqli_query($link,$sewing_op_codes));
			{
			  $op_codes = $row['op_codes'];
			}

			$get_operations= "select DISTINCT(operation_code) from $brandix_bts.tbl_style_ops_master where style='$style' and color='$color' and operation_code in ($op_codes) order by operation_order";

			$bcd_root_query = "SELECT * from $brandix_bts.bundle_creation_data where style='$style' and schedule ='$schedule' and color='$color' and bundle_number= '$bundle_number' limit 1";
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

			$get_ops_query = "SELECT operation_name,operation_code FROM $brandix_bts.tbl_orders_ops_ref where operation_code in ($opertions) ";
			//echo $get_ops_query;
			$ops_query_result=$link->query($get_ops_query);
			while ($row1 = $ops_query_result->fetch_assoc())
			{
			
			  $ops_get_code[$row1['operation_code']] = $row1['operation_name'];
			}

			// echo $get_ops_query;
		    $col_span = count($ops_get_code);
			$table_data = "
			<table id='excel_table' class = 'table-bordered table-condensed'>
			    <thead>
				    <tr class='info'>
					   <th rowspan=2>Style</th>
					   <th rowspan=2>Schedule</th>
					   <th rowspan=2>Color</th>
					   <th rowspan=2>Size</th>
					   <th colspan = ".($col_span*2).">Operation Reported Qty</th>
					</tr>
					<tr class='info'>";					
						foreach ($operation_code as $op_code) 
						{
							if(strlen($ops_get_code[$op_code]) > 0)
							$table_data .= "<th>".$ops_get_code[$op_code]."";
							//$table_data .= "<th>".$ops_get_code[$op_code]."<br>(Rejection)</th>";
						}
					    $table_data .= "
				    </tr>
			    </thead>
			    <tbody>";
		    

		//echo $bcd_root_query;
		    
		    $bcd_root_result = mysqli_query($link,$bcd_root_query);
		    
		    while($row_main = mysqli_fetch_array($bcd_root_result)){
		    	
		        $style = $row_main['style'];
			   	$schedule = $row_main['schedule'];
			   	$color = $row_main['color'];
		        $size = $row_main['size_title'];
		        $size_code =  $row_main['size_id'];

                //To get Bundle Qty
		        $get_bundle_qty="select sum(carton_act_qty) as bundle_qty from $bai_pro3.pac_stat_log_input_job where tid='$bundle_number'";
					
		        $bcd_data_query = "SELECT COALESCE(SUM(recevied_qty),0) as recevied,operation_id,COALESCE(sum(rejected_qty),0) as rejection,group_concat(distinct scanned_user) as scanned_user,shift,max(date_time) as max,assigned_module  from $brandix_bts.bundle_creation_data_temp where style='$style' and schedule ='$schedule' and color='$color' and size_title='$size' and bundle_number='$bundle_number'  group by operation_id";
		      
		        // echo $bcd_data_query;
			    $get_bundle_result =$link->query($get_bundle_qty);
				while ($row2 = $get_bundle_result->fetch_assoc())
				{
					$bundle_qty = $row2['bundle_qty'];
				}

			    $bcd_get_result =$link->query($bcd_data_query);
			    //echo $bcd_data_query.'<br/>';
			    while ($row3 = $bcd_get_result->fetch_assoc())
			    {
					$bcd_rec[$row3['operation_id']] = $row3['recevied'];
					$bcd_rej[$row3['operation_id']] = $row3['rejection'];
					// $user = $row3['scanned_user'];
					$user_name[$row3['operation_id']] = $row3['scanned_user'];
					$shift = $row3['shift'];
					$scanned_time[$row3['operation_id']] = $row3['max'];
					$module = $row3['assigned_module'];
			    }

			    
			    $table_data .= "<tr><td>$style</td><td>$schedule</td><td>$color</td><td>$size</td>";
		       
			    foreach ($operation_code as $key => $value) 
			    {
					if(strlen($ops_get_code[$value]) > 0)
					{
					 if($bcd_rec[$value] > 0 || $bcd_rej[$value] > 0)
					 {
						   $table_data .= "<td>
						   <table class='table table-bordered'>

								<tr>
								   <th>Shift</th>
								   <td>$shift</td>
								</tr>
								<tr>
								   <th>Module</th>
								   <td>$module</td>
								</tr>
								<tr>
								   <th>Scanned User</th>
								   <td>$user_name[$value]</td>
								</tr>
								<tr>
								   <th>Scanned Time</th>
								   <td>".$scanned_time[$value]."</td>
								</tr>
                                <tr>
								   <th>Total Qty</th>
								   <td>$bundle_qty</td>
								</tr>
								<tr>
								   <th>Good Qty</th>
								   <td>".$bcd_rec[$value]."</td>
								</tr>
								<tr>
								   <th>Rejection Qty</th>
								   <td>".$bcd_rej[$value]."</td>
								</tr>

						   </table></td>";
					 }
					 else{
						$table_data .="<td>No Quantity Reported</td>";
					 }
					}
				} 
		         

			   	$table_data .= "</tr>";
		    }
			  
		    echo $table_data."</tbody></table>";
}
else
{
	//Style Wip Report Code
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

        $get_operations .=" order by operation_order"; 

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

		$get_ops_query = "SELECT operation_name,operation_code FROM $brandix_bts.tbl_orders_ops_ref where operation_code in ($opertions) and display_operations='yes'";
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
		   <th colspan = ".($col_span*2)." style=text-align:center>Operation Reported Qty</th>
		   <th colspan = $col_span style=text-align:center>Wip</th>
		</tr>
		<tr>";
				
			foreach ($operation_code as $op_code) 
			{
				if(strlen($ops_get_code[$op_code]) > 0){
					$table_data .= "<th>".$ops_get_code[$op_code]."<br>(Good)</th>";
					$table_data .= "<th>".$ops_get_code[$op_code]."<br>(Rejection)</th>";
				}
			}
			
		    foreach ($operation_code as $op_code) 
		    {
		    	if(strlen($ops_get_code[$op_code]) > 0)
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
		    $cpk_main_qty = 0;

		    $get_order_qty="select sum($asum_str) as order_qty from $bai_pro3.bai_orders_db_confirm where order_style_no='$style' and order_del_no='$schedule' and order_col_des='$color' ";
				
		    $bcd_data_query = "SELECT COALESCE(SUM(recevied_qty),0) as recevied,operation_id,COALESCE(sum(rejected_qty),0) as rejection from $brandix_bts.bundle_creation_data where style='$style' and schedule ='$schedule' and color='$color'";
		   // echo $get_order_qty;
		    if($_GET['size'] != '')
		    {

		   	   $bcd_data_query .= " and size_title='$size' group by operation_id";
		   	   //$get_order_qty.= " and title_size_$size_code = '$size'";
		   	    $get_order_qty="select (order_s_$size_code) as order_qty from $bai_pro3.bai_orders_db_confirm where order_style_no='$style' and order_del_no='$schedule' and order_col_des='$color' ";
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
				$bcd_rej[$row3['operation_id']] = $row3['rejection'];
		    }

    

		    $to_get_cpk="select sum(carton_act_qty) as  carton_qty from $bai_pro3.pac_stat_log where style='$style' and schedule='$schedule' and color='$color' and status='DONE'";
            if($_GET['size'] != '')
		    {
		       $to_get_cpk .= " and size_code='$size_code'";
		    }
		    else
		    {
               $to_get_cpk .= " group by color";
		    }
		    $to_get_cpk_result= $link->query($to_get_cpk);
		    while ($row3 = $to_get_cpk_result->fetch_assoc())
		    {
		    	$cpk_main_qty = $row3['carton_qty'];
		    }

		    if($cpk_main_qty >0)
		    {
              $cpk_qty = $cpk_main_qty;
		    }else
		    {
              $cpk_qty = 0;
		    }	
			$bcd_rec[200] = $cpk_qty;
			$bcd_rej[200] = 0;
		    //echo $cpk_qty;

		    $counter++;
		    $table_data .= "<tr><td>$counter</td><td>$schedule</td><td>$color</td>";
		    if($size_get != '')
		    {
		       $table_data .="<td>$size</td>";
		    }

		    $table_data .="<td>$order_qty</td>";

		    foreach ($operation_code as $key => $value) 
		    {
		    	if(strlen($ops_get_code[$value]) > 0){
			    		
					   $table_data .= "<td>".$bcd_rec[$value]."</td>";
					   $table_data .= "<td>".$bcd_rej[$value]."</td>";
				}
			} 
		    
			foreach ($operation_code as $key => $value) 
		    {
		    	// if($value == 10)
		    	// 	continue;

		    	if($value == 15)
		    	{
		            $wip[$value] = $order_qty -($bcd_rec[$value]+$bcd_rej[$value]);
		    	}
		    	else
		    	{	
		            $ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code='$value'";
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

		            if($value == 200)
		            {
		            	//echo $pre_op_code;
		            	$diff= $bcd_rec[$pre_op_code] - ($bcd_rec[$value]+$bcd_rej[$value]);
		            }else
		            {
		              $diff= $bcd_rec[$pre_op_code] - ($bcd_rec[$value]+$bcd_rej[$value]);
		            }
		            if($diff < 0)
		            	$diff = 0;

					$wip[$value] = $diff;
				}
		        if(strlen($ops_get_code[$value]) > 0)
					$table_data .= "<td>".$wip[$value]."</td>";
			} 

		   	$table_data .= "</tr>";
		   	unset($bcd_rec);
		   	unset($bcd_rej);
		   	unset($cpk_main_qty);
		}
		  
		echo $table_data."</tbody></table>";
}

?>
