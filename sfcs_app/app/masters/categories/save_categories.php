<?php
// echo $_POST['table_name'];
$category_name=$_REQUEST['category_name'];
$row_id=$_REQUEST['c_id'];
// echo $row_id;die();
$category_status=$_REQUEST['category_status'];
$cat_select=$_REQUEST['cat_selection'];

// echo $status;die();
// $servername = "192.168.0.110:3326";
// $username = "baiall";
// $password = "baiall";
// $dbname = "bai_pro3";
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
// Create connection
// $conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }
if (empty($category_name) || empty($category_status) || empty($cat_select)) 
{
	echo "Please fill values";
}
else
{
	if($row_id>0)
	{
		//update
		$sql = "update tbl_category set cat_name='$category_name',status='$category_status',cat_selection='$cat_select' where id=$row_id";
		
		if (mysqli_query($conn, $sql)) {
			echo "Record updated successfully";
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
	else
	{
		$sql = "INSERT INTO tbl_category (cat_name, status,cat_selection)
		VALUES ('$category_name','$category_status','$cat_select')";

		if (mysqli_query($conn, $sql)) 
		{
		    echo "New record created successfully";
		} 
		else 
		{
		    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
}

mysqli_close($conn);
header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2NhdGVnb3JpZXMvYWRkX2NhdGVnb3JpZXMucGhw');
exit;
?>