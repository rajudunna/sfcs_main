<?php
$code=$_POST['code'];
// echo $table_name;die();
$department=$_POST['department'];
// echo $status;die();
$reason=$_POST['reason'];
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

$sql = "INSERT INTO downtime_reason (code, rdept,reason)
VALUES ('$code','$department','$reason')";

if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>