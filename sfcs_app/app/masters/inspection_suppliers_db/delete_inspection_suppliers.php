<?php
$rid=$_GET['tid'];
echo $rid;
$servername = "192.168.0.110:3326";
	$username = "baiall";
	$password = "baiall";
	$dbname = "bai_rm_pj1";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$delete="delete from bai_rm_pj1.`inspection_supplier_db` where tid='$rid'";
if (mysqli_query($conn, $delete)) {
			header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2luc3BlY3Rpb25fc3VwcGxpZXJzX2RiL3NhdmVfaW5zcGVjdGlvbl9zdXBwbGllcnMucGhw==');
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

?>