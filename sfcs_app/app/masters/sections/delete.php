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
$delete="delete from bai_pro3.sections_db where sec_id='$rid'";
if (mysqli_query($conn, $delete)) {
			header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL3NlY3Rpb25zL2FkZF9zZWN0aW9uLnBocA==');
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

?>