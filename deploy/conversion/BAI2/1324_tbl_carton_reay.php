<?php

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

$get_code = "SELECT operation_code from $brandix_bts.tbl_ims_ops where operation_name='Carton_Ready'";
$bcd_result1 = mysqli_query($link,$get_code);
while($row1 = mysqli_fetch_array($bcd_result1)){
	$op_code=$row1['operation_code'];
}	
if($op_code=='' || $op_code==0)
{
	$op_code=130;
}


$get_code51 = "TRUNCATE `bai_pro3`.`tbl_carton_ready`";
$bcd_result51 = mysqli_query($link,$get_code51);

$bcd_data_query = "SELECT mo_no,sum(if(op_code=$op_code,good_quantity,0)) as output,sum(if(op_code=200,good_quantity,0)) as carton from bai_pro3.mo_operation_quantites group by mo_no";

$bcd_result = mysqli_query($link,$bcd_data_query);
while($row = mysqli_fetch_array($bcd_result)){
	$mo_no = $row['mo_no'];
	$output = $row['output'];
	$carton = $row['carton'];
	$code = $op_code;
	
	if($carton==0)
	{
		$remain=$output;
	}
	else
	{
		$remain = $output-$carton;
	}
	if($output > 0)	
	{
		//$op_code = $row['operation_id'];
		//updateM3Transactions($bundle_no,$op_code,$qty);
		$update_qry = "INSERT INTO `bai_pro3`.`tbl_carton_ready` (`operation_id`, `mo_no`, `remaining_qty`, `cumulative_qty`) VALUES ($code, $mo_no, $remain, $output); ";
		$ims_pro_qty_updating = mysqli_query($link,$update_qry) or exit("While updating mo_operation_quantites".mysqli_error($GLOBALS["___mysqli_ston"]));
	}	
	
}

echo "Successful";
?>