<?php

if(isset($_GET['total_quantity']) && isset($_GET['op_code']) && isset($_GET['bundle_number']))
{

	$total_quantity = $_GET['total_quantity'];
	$op_code = $_GET['op_code'];
	$bundle_number = $_GET['bundle_number'];

	// echo $total_quantity;
	if($total_quantity != '' && $op_code != '' && $bundle_number != '')
	{
		validatequantity($total_quantity, $op_code, $bundle_number);
	}
}

if(isset($_GET['bundle_number']) && !isset($_GET['total_quantity']) && !isset($_GET['op_code']))
{

	$bundle_number = $_GET['bundle_number'];
	// echo $bundle_number;
	if($bundle_number != '')
	{
		getopcodes($bundle_number);
	}
}
function getopcodes($bundle_number)
{
	error_reporting (0);

	$servername = "192.168.0.110:3321";
	$username = "baiall";
	$password = "baiall";
	$dbname = "brandix_bts";
	// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}else{
		// echo "Connection Success";
	}
	$bundle_num=explode("-",$bundle_number);
	$bundle_number=$bundle_num[0];
	$op_sequence=$bundle_num[1];
	$op_query = "select operation_name, operation_code from bundle_creation_data LEFT JOIN tbl_orders_ops_ref ON tbl_orders_ops_ref.operation_code = bundle_creation_data.operation_id WHERE bundle_number= '".$bundle_number."' and operation_sequence='".$op_sequence."'";
	// echo $op_query;	
	$result1 = $conn->query($op_query);
	// if(mysqli_num_rows($result1) > 0)
    while($row1 = $result1->fetch_assoc()){
        $json1[$row1['operation_code']] = $row1['operation_name'];
   	}
	// }else {

	// }
   echo json_encode($json1);

}
function validatequantity($total_quantity, $op_code, $bundle_number)
{
	error_reporting (0);

	$servername = "192.168.0.110:3321";
	$username = "baiall";
	$password = "baiall";
	$dbname = "brandix_bts";
	// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}else{
		// echo "Connection Success";
	}
	$op_query = "select * from bundle_creation_data WHERE bundle_number= '".$bundle_number."' and operation_id='".$op_code."'";
	// echo $op_query;	
	$result1 = $conn->query($op_query);
	// if(mysqli_num_rows($result1) > 0)
    while($row1 = $result1->fetch_assoc()){
        // $json1[$row1['operation_code']] = $row1['operation_name'];
        $data = $row1['missing_qty'];

   	}
	// }else {

	// }
	// echo $total_quantity;
	if ($data >= $total_quantity) {
		$json2['status'] = 'true';
		$json2['data'] = $data;
		
		echo json_encode($json2);
	}else {
		$json2['status'] = 'false';
		$json2['data'] = $data;

		echo json_encode($json2);
	}
   // echo json_encode($json1);

}

?>