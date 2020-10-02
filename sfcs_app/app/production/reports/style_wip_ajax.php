<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
error_reporting(0);
if($_GET['some'] == 'bundle_no')
{
	     //Bundle Wise Report C
		$bundle_number = $_GET['bundle'];
		$plantCode = $_GET['plantCode'];

		$qryGetBundleDetails="SELECT external_ref_id FROM $pts.barcode WHERE barcode='$bundle_number' AND plant_code='$plantCode' AND barcode_type='PSLB' AND is_active=1";
		$bundleResult = $link_new->query($get_details);
		while($bundleRow = $bundleResult->fetch_assoc())
		{
			$external_ref_id = $bundleRow['external_ref_id'];
		}

		/**getting jm jg header id based on external ref id */
		if($external_ref_id!=''){
			$qryGetjobbundles="SELECT jm_jg_header_id,fg_color,size,quantity FROM $pps.jm_job_bundles WHERE jm_job_bundle_id='$external_ref_id' AND plant_code='$plantCode' AND is_active=1";
			$jobbundlesResult = $link_new->query($qryGetjobbundles);
			while($jobRow = $jobbundlesResult->fetch_assoc())
			{
				$jm_jg_header_id = $jobRow['jm_jg_header_id'];	
				$color = $jobRow['fg_color'];	
				$size = $jobRow['size'];	
				$bundle_qty = $jobRow['quantity'];	
			}
		}

		/**getting style and schedule with  jm jg header id*/
		if($jm_jg_header_id!=""){
			$qrygetTaskjobs="SELECT task_job_id FROM $tms.task_jobs WHERE task_job_reference='$jm_jg_header_id' AND plant_code='$plantCode' AND is_active=1";
			$taskjobsResult = $link_new->query($qrygetTaskjobs);
			while($jobRow = $taskjobsResult->fetch_assoc())
			{
				$task_job_id = $jobRow['task_job_id'];	

			}
			/**getting style and schedule from attributes */
			if($task_job_id!=''){
				$job_detail_attributes = [];
				$qry_toget_style_sch = "SELECT * FROM $tms.task_attributes where task_jobs_id='".$task_job_id."' and plant_code='$plantCode' and is_active=1";
				$qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) {
					$job_detail_attributes[$row2['attribute_name']] = $row2['attribute_value'];
				}
					$style = $job_detail_attributes[$sewing_job_attributes['style']];
					$schedule = $job_detail_attributes[$sewing_job_attributes['schedule']];
			}
			
		}

		/**getting operations*/
		$departmentType = DepartmentTypeEnum::SEWING;
        $qryOperations="SELECT operation_code,operation_name FROM $pms.`operation_mapping` WHERE operation_category='$departmentType' AND plant_code='$plantCode' order by priority ASC";
        $qryOperationsResult = mysqli_query($link_new,$qryOperations) or exit('Problem in getting jobs in workstation');
        if(mysqli_num_rows($qryOperationsResult)>0){
            $operations= [];
            while($row = mysqli_fetch_array($qryOperationsResult)){
                $operation = [];
                $operation["operation_code"] = $row['operation_code'];
                $operation["operation_name"] = $row['operation_name'];
                array_push($operations, $operation);
            }
		}
		
		// echo $get_ops_query;
		$col_span = count($operations);
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
					foreach ($operations as $op_code) 
					{
						if(strlen($op_code['operation_name']) > 0)
						{
							$table_data .= "<th>".$op_code['operation_name']."";
						}
					}					
					// foreach ($operation_code as $op_code) 
					// {
					// 	if(strlen($ops_get_code[$op_code]) > 0)
					// 	$table_data .= "<th>".$ops_get_code[$op_code]."";
					// 	//$table_data .= "<th>".$ops_get_code[$op_code]."<br>(Rejection)</th>";
					// }
					$table_data .= "
				</tr>
			</thead>
			<tbody>";

		$qryGetoperation="SELECT operation,good_quantity,rejected_quantity FROM $pts.transaction_log WHERE bundlenumber='$bundle_number' AND style='$style' AND SCHEDULE='$schedule' AND color='$color' AND size='$size' AND plant_code='$plantCode' AND is_active=1 GROUP BY operation";
		$bcd_get_result =$link_new->query($qryGetoperation);
		//echo $bcd_data_query.'<br/>';
		while ($row3 = $bcd_get_result->fetch_assoc())
		{
			$bcd_rec[$row3['operation']] = $row3['goodqty'];
			$bcd_rej[$row3['operation']] = $row3['rejectedqty'];
			$user_name[$row3['operation']] = $row3['created_user'];
			$shift[$row3['operation']] = $row3['shift'];
			$scanned_time[$row3['operation']] = $row3['created_at'];
			$module[$row3['operation']] = $row3['workstation_id'];
		}

		
		$table_data .= "<tr><td>$style</td><td>$schedule</td><td>$color</td><td>$size</td>";
	   
		foreach ($operations as $op_code)
		{
			if($op_code['operation_code'] > 0)
			{	
				$value=$op_code['operation_code'];
				if($bcd_rec[$value] > 0 || $bcd_rej[$value] > 0)
				{
					$table_data .= "<td>
					<table class='table table-bordered'>

							<tr>
							<th>Shift</th>
							<td>$shift[$value]</td>
							</tr>
							<tr>
							<th>Module</th>
							<td>$module[$value]</td>
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
			echo $table_data."</tbody></table>";
}
// else
// {
// 	//Style Wip Report Code
// 	$counter = 0;
// 	$style = $_GET['style'];
// 	$schedule = $_GET['schedule'];
// 	$color = $_GET['color'];
// 	$size_get = $_GET['size'];
// 	if($schedule == 'all')
// 	{
// 		$get_operations= "SELECT operation_code FROM brandix_bts.tbl_style_ops_master WHERE style='$style' GROUP BY operation_code ORDER BY operation_order*1";			
// 		$bcd_root_query = "SELECT * from $brandix_bts.bundle_creation_data where style='$style' group by schedule,color";
// 	}
// 	else if ($schedule == 'all' && $color != 'all')
// 	{
// 		$get_operations= "SELECT operation_code FROM brandix_bts.tbl_style_ops_master WHERE style='$style' AND color='$color' GROUP BY operation_code ORDER BY operation_order*1";
// 		$bcd_root_query = "SELECT * from $brandix_bts.bundle_creation_data where style='$style' and color ='$color' group by schedule";                  
// 	}
// 	else if ($schedule != 'all' && $color == 'all')
// 	{
// 		$get_operations= "SELECT operation_code FROM brandix_bts.tbl_style_ops_master WHERE style='$style' GROUP BY operation_code ORDER BY operation_order*1";
// 		$bcd_root_query = "SELECT * from $brandix_bts.bundle_creation_data where style='$style' and schedule ='$schedule' group by color";                  
// 	}
// 	else
// 	{	
// 		$get_operations= "SELECT operation_code FROM brandix_bts.tbl_style_ops_master WHERE style='$style' AND color='$color' GROUP BY operation_code ORDER BY operation_order*1";
// 		$bcd_root_query = "SELECT * from $brandix_bts.bundle_creation_data where style='$style' and schedule ='$schedule' and color='$color'";
// 		if($_GET['size']!='')
// 		{
// 		   $bcd_root_query =  $bcd_root_query.' group by size_title';  
// 		}
// 		else
// 		{
// 			$bcd_root_query =  $bcd_root_query.' limit 1';
// 		}
// 	}	
// 	//echo $get_operations."<bR>";
// 	$result1 = $link->query($get_operations);
// 	while($row2 = $result1->fetch_assoc())
// 	{
// 		$operation_code1[] = $row2['operation_code'];		
// 	}
// 	$opertions = implode(',',$operation_code1);
	
// 	$get_ops_query = "SELECT operation_name,operation_code FROM $brandix_bts.tbl_orders_ops_ref where operation_code in ($opertions) and display_operations='yes'";
// 	//echo $get_ops_query;
// 	$ops_query_result=$link->query($get_ops_query);
// 	while ($row1 = $ops_query_result->fetch_assoc())
// 	{
// 		$ops_get_code[$row1['operation_code']] = $row1['operation_name'];
// 		$operation_code[]=$row1['operation_code'];
// 	}

// 	$bcd_data_query .= " and operation_id in ($opertions)";
// 	$col_span = count($ops_get_code);
// 	$table_data = "<table id='excel_table' class = 'col-sm-12 table-bordered table-striped table-condensed cf'>
// 	<thead class='cf'>
// 	<tr>
// 	   <th rowspan=2>S.NO</th>
// 	   <th rowspan=2>Schedule</th>
// 	   <th rowspan=2>Color</th>";
// 	if($size_get != '')
// 	{
// 		$table_data .="<th rowspan=2>Size</th>";
// 	}

// 	$table_data .="
// 	   <th rowspan=2>Order Qty</th>
// 	   <th colspan = ".($col_span*2)." style=text-align:center>Operation Reported Qty</th>
// 	   <th colspan = $col_span style=text-align:center>Wip</th>
// 	</tr>
// 	<tr>";				
// 	foreach ($operation_code as $op_code) 
// 	{
// 		if(strlen($ops_get_code[$op_code]) > 0){
// 			$table_data .= "<th>".$ops_get_code[$op_code]."<br>(Good)</th>";
// 			$table_data .= "<th>".$ops_get_code[$op_code]."<br>(Rejection)</th>";
// 		}
// 	}		
// 	foreach ($operation_code as $op_code) 
// 	{
// 		if(strlen($ops_get_code[$op_code]) > 0)
// 			$table_data .= "<th>$ops_get_code[$op_code]</th>";
// 	}
// 	$table_data .= "</tr></thead><tbody>";
// 	if($_GET['size']!='' && ($color == 'all' || $schedule == 'all') )
// 	{
// 		   $bcd_root_query =  $bcd_root_query.',size_title';  
// 	}
// 	foreach($sizes_array as $size)
// 	{
// 		$sum.= $size." + ";
// 		$asum.= "order_s_".$size." + ";
// 	}
// 	$asum_str = rtrim($asum,' + ');
// 	$bcd_root_result = mysqli_query($link,$bcd_root_query);
// 	while($row_main = mysqli_fetch_array($bcd_root_result))
// 	{			
// 		$style = $row_main['style'];
// 		$schedule = $row_main['schedule'];
// 		$color = $row_main['color'];
// 		$size = $row_main['size_title'];
// 		$size_code =  $row_main['size_id'];
// 		// $cpk_main_qty = 0;
// 		foreach ($operation_code as $key => $value) 
//         {
// 			$wip[$value] = 0;
// 			$bcd_rec[$value] =0;
// 			$bcd_rej[$value] =0;
//         }		
			
// 		$bcd_data_query = "SELECT COALESCE(SUM(recevied_qty),0) as recevied,operation_id,COALESCE(sum(rejected_qty),0) as rejection from $brandix_bts.bundle_creation_data_temp where style='$style' and schedule ='$schedule' and color='$color'";
// 		if($_GET['size'] != '')
// 		{			  
// 			$bcd_data_query .= " and size_title='$size' group by operation_id";
// 			$get_size_title = "SELECT order_quantity FROM $brandix_bts.`tbl_orders_sizes_master` AS ch LEFT JOIN $brandix_bts.`tbl_orders_master` AS p ON p.id=ch.parent_id 
// 			WHERE p.product_schedule='$schedule' AND ch.order_col_des='$color' AND ch.size_title='$size' limit 1";
// 			//echo $get_size_title."<br>";
// 			$get_size_title_result =$link->query($get_size_title);
// 			while ($row110 = $get_size_title_result->fetch_assoc())
// 			{
// 				$order_qty = $row110['order_quantity'];
// 			}

// 		}
// 		else{
		   
// 			$bcd_data_query .= " group by operation_id";
// 			$get_size_title = "SELECT sum(order_quantity) as order_qty FROM $brandix_bts.`tbl_orders_sizes_master` AS ch LEFT JOIN $brandix_bts.`tbl_orders_master` AS p ON p.id=ch.parent_id 
// 			WHERE p.product_schedule='$schedule' AND ch.order_col_des='$color'";
// 			//echo $get_size_title."<br>";
// 			$get_size_title_result =$link->query($get_size_title);
// 			while ($row110 = $get_size_title_result->fetch_assoc())
// 			{
// 				$order_qty = $row110['order_qty'];
// 			}
// 		}
		
// 		$bcd_get_result =$link->query($bcd_data_query);
// 		while ($row3 = $bcd_get_result->fetch_assoc())
// 		{
// 			$bcd_rec[$row3['operation_id']] = $row3['recevied'];
// 			$bcd_rej[$row3['operation_id']] = $row3['rejection'];
// 		}

// 		$counter++;
// 		$table_data .= "<tr><td>$counter</td><td>$schedule</td><td>$color</td>";
// 		if($size_get != '')
// 		{
// 		   $table_data .="<td>$size</td>";
// 		}
// 		$table_data .="<td>$order_qty</td>";

// 		foreach ($operation_code as $key => $value) 
// 		{
// 			if(strlen($ops_get_code[$value]) > 0){
					
// 				   $table_data .= "<td>".$bcd_rec[$value]."</td>";
// 				   $table_data .= "<td>".$bcd_rej[$value]."</td>";
// 			}
// 		} 
// 		$ii=1;
// 		foreach ($operation_code as $key => $value) 
// 		{ 
// 			if($ii==1)
// 			{
// 				$diff = $order_qty -($bcd_rec[$value]+$bcd_rej[$value]); 
// 				if($diff < 0)  
// 				{
// 					$diff = 0;
// 				}
// 				$wip[$value] = $diff;
// 			}
// 			else
// 			{	
// 				$ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code='$value'";
// 				$result_ops_seq_check = $link->query($ops_seq_check);
// 				while($row = $result_ops_seq_check->fetch_assoc()) 
// 				{
// 					$ops_seq = $row['ops_sequence'];
// 					$seq_id = $row['id'];
// 					$ops_order = $row['operation_order'];
// 				}
// 				$post_ops_check = "SELECT tsm.operation_code AS operation_code FROM brandix_bts.tbl_style_ops_master tsm 
// 				LEFT JOIN brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE style='$style' AND color='$color' AND tor.display_operations='yes' AND CAST(tsm.operation_order AS CHAR) < '$ops_order' GROUP BY tsm.operation_code ORDER BY LENGTH(tsm.operation_order) desc limit 1";
// 				$result_post_ops_check = $link->query($post_ops_check);
// 				$row = mysqli_fetch_array($result_post_ops_check);
// 				$pre_op_code = $row['operation_code'];
// 				// echo $post_ops_check."-<br>";
// 				// echo $pre_op_code."--<br>";
// 				$diff= $bcd_rec[$pre_op_code] - ($bcd_rec[$value]+$bcd_rej[$value]);

// 				if($diff < 0)  
// 				{
// 					$diff = 0;
// 				}
// 				$wip[$value] = $diff;
// 			}
// 			if(strlen($ops_get_code[$value]) > 0)
// 			$table_data .= "<td>".$wip[$value]."</td>";
// 			$ii++;
// 		} 
// 		$table_data .= "</tr>";
// 		unset($bcd_rec);
// 		unset($bcd_rej);
// 		unset($cpk_main_qty);
// 	}
// 	echo $table_data."</tbody></table>";
// }

?>
