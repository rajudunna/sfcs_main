<?php
// echo $_POST['table_name'];
$tbl_id=$_REQUEST['tbl_id'];
// echo $tbl_id;
$tbl_name =$_REQUEST['table_name'];
// echo $tbl_name;die();
$p_status =$_REQUEST['table_status'];
// echo $status;die();

// echo $status;die();
// $servername = "192.168.0.110:3326";
// $username = "baiall";
// $password = "baiall";
// $dbname = "bai_pro3";

// Create connection
// $conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }
//echo $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php';
// echo $_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php';die();
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
// echo 





if (empty($tbl_name) || empty($p_status)) {
	echo "Please fill values";
}else{
	if($p_status == 1)
	{
		$tblstatus = 'active';
	}
	else
	{
		$tblstatus = 'inactive';
	}
	if($tbl_id>0){
		
		//update
		
		$sql = "update tbl_cutting_table set tbl_name='$tbl_name',status='$tblstatus' where tbl_id=$tbl_id";
		// echo $sql;die();
		if (mysqli_query($conn, $sql)) {
			echo "Record updated successfully";
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}else{
		//insert 
		$sql = "INSERT INTO tbl_cutting_table (tbl_name,status)
			VALUES ('$tbl_name','$tblstatus')";
		if (mysqli_query($conn, $sql)) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
}

mysqli_close($conn);
header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2N1dHRpbmcvY3V0dGluZ190YWJsZV9hZGQucGhw');
exit;


?>