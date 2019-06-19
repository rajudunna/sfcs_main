<?php
error_reporting(0);

if(isset($_GET['date'])){
	$date = $_GET['date'];
	getData($date);
}

function getData($date){
	
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');

	$operation_code = [];	
	$operations_yes = [];
	$operations_no = [];
	$over_all_operations = [];
	$opertion_names = [];	
	$total_data = [];
	$main_result = [];
	
	//To get all the operations	
	//To get default Operations
	$get_operations_workflow= "select DISTINCT(operation_code),default_operration from $brandix_bts.default_operation_workflow order by operation_order*1";
	$result1 = $link->query($get_operations_workflow);
	$op_count = mysqli_num_rows($result1);
	if($op_count>0){
		while($row1 = $result1->fetch_assoc())
		{
			$operation_code[] = ['op_code'=>$row1['operation_code'],'def_op'=>$row1['default_operration']];
		}
	}

	if(count($operation_code)>0){
		foreach ($operation_code as $key => $value) {	
			//columns
			$get_operations_no= "select DISTINCT(operation_id) from $brandix_bts.bundle_creation_data_temp where date(scanned_date) = '$date' and operation_id ='".$value['op_code']."'";				
			$result4 = $link->query($get_operations_no);
			$op_count = mysqli_num_rows($result4);
			if($op_count){
				while($row3 = $result4->fetch_assoc()){
					$over_all_operations[] = $row3['operation_id'];
					$operations_no[] = $row3['operation_id'];
				}
			}
		}
	}

	if(count($over_all_operations)>0){
		$operation_codes_no = implode(',',$over_all_operations);
		//columns Data
		$get_data_bcd_temp= "SELECT style,SCHEDULE,color,size_title,sum(recevied_qty) as recevied_qty,operation_id as op_code FROM brandix_bts.`bundle_creation_data_temp` WHERE scanned_date BETWEEN '$date 00:00:00.0000' AND '$date 23:59:59.9999' AND operation_id in ($operation_codes_no) GROUP BY style,SCHEDULE,color,size_title,operation_id";
		$result5 = $link->query($get_data_bcd_temp);
		$op_count1 = mysqli_num_rows($result5);
		if($op_count1>0){
			while($row5 = $result5->fetch_assoc()){
				if($row5['recevied_qty']){
					$rec_qty = (int)$row5['recevied_qty'];
					$data = ['style'=>trim($row5['style']),'schedule'=>$row5['SCHEDULE'],'color'=>trim($row5['color']),'size'=>trim($row5['size_title']),$row5['op_code']=>$rec_qty,'op_code'=>$row5['op_code']];
					array_push($total_data,$data);
				}
			}
		}
	}

	$operation_codes_str = implode(',',$over_all_operations);
	//To get operation names
	$get_ops_query = "SELECT operation_name,operation_code FROM $brandix_bts.tbl_orders_ops_ref where operation_code in ($operation_codes_str) order by field(operation_code,$operation_codes_str) ";
	$ops_query_result=$link->query($get_ops_query);
	$op_count = mysqli_num_rows($ops_query_result);
	if($op_count >0){		
		while ($row3 = $ops_query_result->fetch_assoc())
		{
			$opertion_names[]= ['op_name'=>$row3['operation_name'],'op_code'=>$row3['operation_code']];
		}
	}

	$main_result['columns'] = $opertion_names;
	$main_result['data'] = $total_data;
	echo json_encode($main_result);
	
}

 
?>