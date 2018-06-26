<?php

$dr_id=$_REQUEST['dr_id'];
$code=$_REQUEST['code'];
$department=$_REQUEST['department'];
$reason=$_REQUEST['reason'];

$servername = "192.168.0.110:3326";
$username = "baiall";
$password = "baiall";
$dbname = "bai_pro2";
// echo $code;
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (empty($code) || empty($department) || empty($reason)) 
{
	echo "Please fill values";
}
else
{
	if($dr_id>0)
	{
		//update
		$sql = "update downtime_reason set code='$code',rdept='$department',reason='$reason' where id=$dr_id";
		
		if (mysqli_query($conn, $sql)) {
			echo "Record updated successfully";
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
	else
	{
		$sql = "INSERT INTO downtime_reason (code, rdept,reason)
		VALUES ('$code','$department','$reason')";

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
header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2Rvd250aW1lcmVhc29uL2Rvd25fdGltZV9yZWFzb25fYWRkLnBocA==');
exit;
?>