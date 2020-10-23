<?php
	error_reporting(0);
	$plant_code = $_SESSION['plantCode'];
    $username = $_SESSION['userName'];
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
	$operation_mapping="SELECT operation_code,operation_name FROM $pms.`operation_mapping` WHERE sequence=1 AND plant_code='$plant_code' and is_active = 1 ORDER BY priority ASC";
	$result1 = $link->query($operation_mapping);
	while($row5 = $result1->fetch_assoc())
	{
		$op_code = $row5['operation_code'];
		$operation_ids[] = $op_code;
		$ops_get_code[$row5['operation_code']] = $row5['operation_name'];	
		$opertion_names[] = ['op_name'=>$row5['operation_name'],'op_code'=>$row5['operation_code']];
		$op_string_data .=",SUM(IF(operation=".$op_code.",good_quantity,0)) as good_".$op_code.",SUM(IF(operation=".$op_code.",rejected_quantity,0)) as rej_".$op_code;
	}
	
	$op_count = count($operation_ids);

	$today=date("Y-m-d"); 
	$sql_trans="SELECT style,schedule,color,size, group_concat(distinct barcode) as barcodes $op_string_data FROM $pts.transaction_log where plant_code='$plant_code' group by style, schedule, color,size";
	// echo $sql_trans;
	$sql_trans_result = mysqli_query($link,$sql_trans);
	while($row_main = mysqli_fetch_array($sql_trans_result))
	{			
		$style = $row_main['style'];
		$schedule = $row_main['schedule'];
		$color = $row_main['color'];
		$size = $row_main['size'];
		$barcodes = $row_main['barcodes'];
		$barcode_list = "'".str_replace(",","','",$barcodes)."'";

		$order_qty_qry = "select sum(quantity) as quantity from $pts.barcode where barcode IN ($barcode_list) ";
		$sql_order_qty_result = mysqli_query($link,$order_qty_qry);
		$order_qty=0;

		while($row_main_qty = mysqli_fetch_array($sql_order_qty_result))
		{	
			$order_qty = $row_main_qty['quantity'];
		}

		$sql112="select customer_order_no from $oms.oms_mo_details where schedule=\"$schedule\" and plant_code=\"$plant_code\"";
		$sql_result112=mysqli_query($link, $sql112) or exit("Sql Error3".$sql112."".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row112=mysqli_fetch_array($sql_result112))
		{
			$co_no=$sql_row112['customer_order_no'];
		}

		$single_data = ['style'=>$style,'cono'=>$co_no,'schedule'=>$schedule,'color'=>$color,'size'=>$size, 'orderqty'=>$order_qty];

		foreach($operation_ids as $op_key => $op_value){
			$wip_quantity_val=$order_qty-($row_main['good_'.$op_value]+$row_main['rej_'.$op_value]);
			if($wip_quantity_val < 0){
				$wip_quantity_val=0;
			}
			$single_data['good'.$op_value] = $row_main['good_'.$op_value];
			$single_data['rej'.$op_value] = $row_main['rej_'.$op_value];
			$single_data['wip'.$op_value]= $wip_quantity_val;
		}
		array_push($main_data,$single_data);
		unset($single_data);
	}
	$result['main_data'] = $main_data;
	$result['operations'] = $opertion_names;
	echo json_encode($result);
       
?>