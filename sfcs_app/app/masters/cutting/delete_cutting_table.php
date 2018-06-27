<?php
$tbl_id=$_GET['rowid'];
// echo $tbl_id;
// $servername = "192.168.0.110:3326";
// $username = "baiall";
// $password = "baiall";
// $dbname = "bai_pro3";
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
// Create connection
// $conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$delete="delete from bai_pro3.`tbl_cutting_table` where tbl_id='$tbl_id'";
// echo $delete;
if (mysqli_query($conn, $delete)) {
			echo "Record Deleted successfully";
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2N1dHRpbmcvY3V0dGluZ190YWJsZV9hZGQucGhw');
?>