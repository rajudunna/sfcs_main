<?php
// echo $_POST['table_name'];

$pack_method_name =$_REQUEST['pack_method_name'];
$status =$_REQUEST['packing_status'];
$pack_id=$_REQUEST['pack_id'];
// echo $status;die();

$servername = "192.168.0.110:3326";
$username = "baiall";
$password = "baiall";
$dbname = "bai_pro3";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (empty($pack_method_name) || empty($status)) {
	echo "Please fill values";
}else{
	if($pack_id>0)
	{
		//update
		$sql = "update pack_methods set pack_method_name='$pack_method_name',status='$status' where pack_id=$pack_id";
		//echo $sql;
		if (mysqli_query($conn, $sql)) {
			echo "Record updated successfully";
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}else{
		//insert 
		$sql = "INSERT INTO pack_methods (pack_method_name, status) VALUES ('$pack_method_name','$status')";
		if (mysqli_query($conn, $sql)) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
}




mysqli_close($conn);
header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL3BhY2tfbWV0aG9kcy9hZGRfcGFja2luZ19tZXRob2QucGhw');
exit;
?>