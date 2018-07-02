<?php
$dr_id=$_GET['rowid'];
// echo $dr_id;
$servername = "192.168.0.110:3326";
$username = "baiall";
$password = "baiall";
$dbname = "bai_pro2";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$delete="delete from bai_pro2.`downtime_reason` where id='$dr_id'";
// echo $delete;
if (mysqli_query($conn, $delete)) {
			echo "Record Deleted successfully";
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2Rvd250aW1lcmVhc29uL2Rvd25fdGltZV9yZWFzb25fYWRkLnBocA==');
?>