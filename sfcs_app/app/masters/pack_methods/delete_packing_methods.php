<?php
$rid=$_GET['rowid'];
echo $rid;
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
$delete="delete from bai_pro3.`pack_methods` where pack_id='$rid'";
if (mysqli_query($conn, $delete)) {
			header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL3BhY2tfbWV0aG9kcy9hZGRfcGFja2luZ19tZXRob2QucGhw');
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

?>