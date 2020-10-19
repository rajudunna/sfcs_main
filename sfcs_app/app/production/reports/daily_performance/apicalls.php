<?php
error_reporting(0);

if(isset($_GET['date'])){
	$date = $_GET['date'];
	$plant = $_GET['plant'];
	getData($date, $plant);
}

function getData($date, $plant){
	
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');

	$plant_code = $plant;
	$operation_code = [];	
	$operations_yes = [];
	$operations_no = [];
	$over_all_operations = [];
	$opertion_names = [];	
	$total_data = [];
	$main_result = [];
	
	//To get all the operations	
	//To get default Operations 
	$get_operations_workflow= "select *  from $pms.operation_mapping  where sequence = true and plant_code = '$plant_code' order by priority*1";
	$result1 = $link->query($get_operations_workflow);
	$op_count = mysqli_num_rows($result1);
	if($op_count>0){
		while($row1 = $result1->fetch_assoc())
		{
			$operation_code[] = ['op_code'=>$row1['operation_code']];
		}
	}
	if(count($operation_code)>0){
		foreach ($operation_code as $key => $value) {	
			//columns
			$get_operations_no= "select DISTINCT(operation) from $pts.transaction_log where date(updated_at) = '$date' and operation ='".$value['op_code']."' and plant_code = '$plant_code'";				
			$result4 = $link->query($get_operations_no);
			$op_count = mysqli_num_rows($result4);
			if($op_count){
				while($row3 = $result4->fetch_assoc()){
					$over_all_operations[] = $row3['operation'];
					$operations_no[] = $row3['operation'];
				}
			}
		}
	}
	// var_dump($over_all_operations);
	// die();
	if(count($over_all_operations)>0){
		$operation_codes_no = implode(',',$over_all_operations);
		// echo $operation_codes_no;
		//columns Data
		$get_data_bcd_temp= "SELECT style,schedule,color,size,sum(good_quantity) as recevied_qty,operation as op_code FROM $pts.`transaction_log` WHERE date(updated_at) BETWEEN '$date' AND '$date' and plant_code = '$plant_code' AND operation in ($operation_codes_no) GROUP BY style,schedule,color,size,operation";
		$result5 = $link->query($get_data_bcd_temp);
		$op_count1 = mysqli_num_rows($result5);
		if($op_count1>0){
			while($row5 = $result5->fetch_assoc()){
				if($row5['recevied_qty']){
					$rec_qty = (int)$row5['recevied_qty'];
					$data = ['style'=>trim($row5['style']),'schedule'=>$row5['schedule'],'color'=>trim($row5['color']),'size'=>trim($row5['size']),$row5['op_code']=>$rec_qty,'op_code'=>$row5['op_code']];
					array_push($total_data,$data);
				}
			}
		}
	}

	$operation_codes_str = implode(',',$over_all_operations);
	//To get operation names
	$get_ops_query = "SELECT * FROM $mdm.operations where operation_code in ($operation_codes_str) order by field(operation_code,$operation_codes_str) ";
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