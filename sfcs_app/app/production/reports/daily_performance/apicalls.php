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
			if($value['def_op'] == 'yes'){
				//columns
				$get_operations_yes= "select DISTINCT(op_code) from $bai_pro3.m3_transactions where date(date_time) = '$date' and op_code ='".$value['op_code']."'";
				$result2 = $link->query($get_operations_yes);
				$op_count = mysqli_num_rows($result2);
				if($op_count > 0){
					while($row2 = $result2->fetch_assoc()){
						$over_all_operations[] = $row2['op_code'];
						$operations_yes[] = $row2['op_code'];
					}					
				}
			}
			
			if($value['def_op'] == 'No'){
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
	}

	// if(count($operations_yes)>0){
	// 	$operation_codes_yes = implode(',',$operations_yes);
	// 	//columns Data
	// 	$get_data_m3tran= "SELECT mo.style as style,mo.schedule as schedule,mo.color as color,mo.size as size_title,tran.quantity as recevied_qty,tran.op_code as op_code FROM
	// 	$bai_pro3.m3_transactions AS tran LEFT JOIN $bai_pro3.mo_details AS mo ON tran.`mo_no` = mo.`mo_no`
	// 	WHERE DATE(tran.date_time) = '$date' AND tran.op_code in ($operation_codes_yes) GROUP BY mo.`style`,mo.`schedule`,mo.`color`,mo.`size`,tran.op_code";	
	// 	$result3 = $link->query($get_data_m3tran);
	// 	$op_count1 = mysqli_num_rows($result3);
	// 	if($op_count1>0){
	// 		while($row4 = $result3->fetch_assoc()){
	// 			if($row4['recevied_qty']){
	// 				$rec_qty = (int)$row4['recevied_qty'];
	// 				$data =  ['style'=>$row4['style'],'schedule'=>$row4['schedule'],'color'=>$row4['color'],'size'=>$row4['size_title'],$row4['op_code']=>$rec_qty,'op_code'=>$row4['op_code']];	
	// 				array_push($total_data,$data);
	// 			}
				
	// 		}
	// 	}
	// }

	if(count($over_all_operations)>0){
		$operation_codes_no = implode(',',$over_all_operations);
		//columns Data
		$get_data_bcd_temp= "SELECT style,SCHEDULE,color,size_title,recevied_qty,operation_id as op_code FROM brandix_bts.`bundle_creation_data_temp` WHERE DATE(scanned_date) = '$date' AND operation_id in ($operation_codes_no) GROUP BY style,SCHEDULE,color,size_title,operation_id";
		$result5 = $link->query($get_data_bcd_temp);
		$op_count1 = mysqli_num_rows($result5);
		if($op_count1>0){
			while($row5 = $result5->fetch_assoc()){
				if($row5['recevied_qty']){
					$rec_qty = (int)$row5['recevied_qty'];
					$data = ['style'=>$row5['style'],'schedule'=>$row5['SCHEDULE'],'color'=>$row5['color'],'size'=>$row5['size_title'],$row5['op_code']=>$rec_qty,'op_code'=>$row5['op_code']];
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