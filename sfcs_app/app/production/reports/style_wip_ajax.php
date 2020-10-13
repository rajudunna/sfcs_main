<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/enums.php");
//error_reporting(0);
if($_GET['some'] == 'bundle_no')
{
	     //Bundle Wise Report C
		$bundle_number = $_GET['bundle'];
		$plantCode = $_GET['plantCode'];

		$qryGetBundleDetails="SELECT external_ref_id,barcode_id FROM $pts.barcode WHERE barcode='$bundle_number' AND plant_code='$plantCode' AND barcode_type='PSLB' AND is_active=1";
		$bundleResult = $link_new->query($qryGetBundleDetails);
		while($bundleRow = $bundleResult->fetch_assoc())
		{
			$external_ref_id = $bundleRow['external_ref_id'];
			$barcode_id = $bundleRow['barcode_id'];
		}
		/**getting parent barcode from parentbarcode */
		$qryGetParentBarcode="SELECT parent_barcode FROM $pts.parent_barcode WHERE child_barcode='1a26e672-7036-4b4a-9637-3bb46f74171f' AND `parent_barcode_type`='PPLB' and plant_code='$plantCode' and is_active=1";
		$parentBarcodeResult = $link_new->query($qryGetParentBarcode);
		while($parentRow = $parentBarcodeResult->fetch_assoc())
		{
			$parent_barcode = $parentRow['parent_barcode'];
		}
		/**get planned bacrcode*/
		$qryPlannedbarcode="SELECT barcode FROM $pts.barcode WHERE barcode_id='$parent_barcode' AND plant_code='$plantCode' AND is_active=1";
		$plannedBUndleResult = $link_new->query($qryPlannedbarcode);
		while($pplbRow = $plannedBUndleResult->fetch_assoc())
		{
			$barcodePPLB = $pplbRow['barcode'];
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
			$qrygetTaskjobs="SELECT task_jobs_id FROM $tms.task_jobs WHERE task_job_reference='$jm_jg_header_id' AND plant_code='$plantCode' AND is_active=1";
			$taskjobsResult = $link_new->query($qrygetTaskjobs);
			while($jobRow = $taskjobsResult->fetch_assoc())
			{
				$task_job_id = $jobRow['task_jobs_id'];	

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
		
		//var_dump($operations);
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

		$qryGetoperation="SELECT operation,good_quantity,rejected_quantity FROM $pts.transaction_log WHERE parent_barcode='$barcodePPLB' AND style='$style' AND SCHEDULE='$schedule' AND color='$color' AND size='$size' AND plant_code='$plantCode' AND is_active=1 GROUP BY operation";
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
else
{
	//Style Wip Report Code
	$counter = 0;
	$style = $_GET['style'];
	$schedule = $_GET['schedule'];
	$color = $_GET['color'];
	$size_get = $_GET['size'];
	$plant_code = $_GET['plant'];


	if($schedule == 'all')
	{
		$get_subpos= "SELECT distinct sub_po as sub_po FROM $pts.transaction_log WHERE style='$style' AND plant_code='$plant_code'";			
		$main_query = "where style='$style' AND plant_code='$plant_code' group by schedule,color";
	}
	else if ($schedule == 'all' && $color != 'all')
	{
		$get_subpos= "SELECT distinct sub_po as sub_po FROM $pts.transaction_log WHERE style='$style' AND color='$color' AND plant_code='$plant_code'";
		$main_query = "where style='$style' and color ='$color' AND plant_code='$plant_code' group by schedule";                  
	}
	else if ($schedule != 'all' && $color == 'all')
	{
		$get_subpos= "SELECT distinct sub_po as sub_po FROM $pts.transaction_log WHERE style='$style' and schedule ='$schedule' AND plant_code='$plant_code'";
		$main_query = "where style='$style' and schedule ='$schedule' AND plant_code='$plant_code' group by color";                  
	}
	else
	{	
		$get_subpos= "SELECT distinct sub_po as sub_po FROM $pts.transaction_log WHERE style='$style' AND color='$color' AND plant_code='$plant_code'";
		$main_query = " where style='$style' and schedule ='$schedule' and color='$color' AND plant_code='$plant_code'";
		if($_GET['size']!='')
		{
		   $main_query =  $main_query.' group by size';  
		}
		else
		{
			$main_query =  $main_query.' limit 1';
		}
	}
	$result1 = $link->query($get_subpos);
	while($row2 = $result1->fetch_assoc())
	{
		$subpos[] = $row2['sub_po'];		
	}

	$subpo_ids = "'" . implode( "','", $subpos) . "'";
	
	$get_fg_id="SELECT DISTINCT finished_good_id AS finished_good_id  FROM $pts.`finished_good` WHERE sub_po IN ($subpo_ids);";
	$result2 = $link->query($get_fg_id);
	while($row3 = $result2->fetch_assoc())
	{
		$finished_good_ids[] = $row3['finished_good_id'];		
	}

	$fg_ids = "'" . implode( "','", $finished_good_ids) . "'";

	$get_fg_operation="SELECT DISTINCT operation_code AS operation_code  FROM $pts.`fg_operation` WHERE finished_good_id IN ($fg_ids);";
	$result3 = $link->query($get_fg_operation);
	while($row4 = $result3->fetch_assoc())
	{
		$operation_codes[] = $row4['operation_code'];		
	}
	$operation_codes_no = implode(',',$operation_codes);
	$operation_mapping="SELECT operation_code,operation_name FROM $pms.`operation_mapping` WHERE operation_code IN ($operation_codes_no) AND sequence=1 AND plant_code=$plant_code and is_active = 1 ORDER BY priority ASC";
	$result4 = $link->query($operation_mapping);
	while($row5 = $result4->fetch_assoc())
	{
		$operation_ids[] = $row5['operation_code'];
		$ops_get_code[$row5['operation_code']] = $row5['operation_name'];	
	}
	$col_span = count($operation_ids);
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
	$op_string_data='';		
	foreach ($operation_ids as $op_code) 
	{
		if(strlen($ops_get_code[$op_code]) > 0){
			$table_data .= "<th>".$ops_get_code[$op_code]."<br>(Good)</th>";
			$table_data .= "<th>".$ops_get_code[$op_code]."<br>(Rejection)</th>";
			$op_string_data .=",IF(sum(operation=$op_code,good_quantity,0) as 'good_'.$op_code),IF(sum(operation=$op_code,rejected_quantity,0) as 'rej_'.$op_code)";
		}
	}		
	foreach ($operation_ids as $op_code) 
	{
		if(strlen($ops_get_code[$op_code]) > 0)
			$table_data .= "<th>$ops_get_code[$op_code]</th>";
	}
	$table_data .= "</tr></thead><tbody>";

	$sql_trans="SELECT style,schedule,color,size, group_concat(distinct barcode) as barcodes $op_string_data FROM $pts.transaction_log $main_query";
	$sql_trans_result = mysqli_query($link,$sql_trans);
	while($row_main = mysqli_fetch_array($sql_trans_result))
	{			
		$style = $row_main['style'];
		$schedule = $row_main['schedule'];
		$color = $row_main['color'];
		$size = $row_main['size'];
		$barcodes = $row_main['barcodes'];

		$barcode_list = "'".str_replace(",","','",$barcodes)."'";

		$order_qty_qry = "select sum(quantity) from $pps.barcode where barcode IN ($barcode_list) ";
		$sql_order_qty_result = mysqli_query($link,$order_qty_qry);
		$order_qty=0;

		while($row_main_qty = mysqli_fetch_array($sql_order_qty_result))
		{	
			$order_qty = $row_main_qty['quantity'];
		}
		$counter++;
		$table_data .= "<tr><td>$counter</td><td>$schedule</td><td>$color</td>";
		if($size_get != '')
		{
		   $table_data .="<td>$size</td>";
		}
		$table_data .="<td>$order_qty</td>";

		foreach ($operation_ids as $key => $value) 
		{
			if(strlen($ops_get_code[$value]) > 0){
					
				$table_data .= "<td>".$row_main['good_'.$key]."</td>";
				$table_data .= "<td>".$row_main['rej_'.$key]."</td>";
			}
		} 
		foreach ($operation_ids as $key => $value) 
		{
			if(strlen($ops_get_code[$value]) > 0){
				$wip=$order_qty-($row_main['good_'.$key]+$row_main['rej_'.$key]);
				if($wip <0){
					$wip=0;
				}	
				$table_data .= "<td>".$wip."</td>";
			}
		} 
		$table_data .= "</tr>";
	}
	echo $table_data."</tbody></table>";
}

?>
