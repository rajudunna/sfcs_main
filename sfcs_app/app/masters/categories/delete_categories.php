<?php
$rid=$_GET['rowid'];
echo $rid;
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php', 3,'R'));

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
$delete="delete from $bai_pro3.tbl_category where id='$rid'";
if (mysqli_query($link, $delete)) {
			header('location: '.getFullURLLevel($_GET['r'],'add_categories.php',0,'N'));
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

?>
<!-- index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2NhdGVnb3JpZXMvYWRkX2NhdGVnb3JpZXMucGhw -->