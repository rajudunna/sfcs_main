<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
$rid=$_GET['rowid1'];
// echo $rid;
// $servername = "192.168.0.110:3326";
// $username = "baiall";
// $password = "baiall";
// $dbname = "bai_pro3";

// Create connection
// $conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
//
//
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if($rid!=''){
	$url=getFullURL($_GET['r'],'create_short_key_code.php','N');
	$delete="delete from $brandix_bts.ops_short_cuts where id='$rid'";
	if (mysqli_query($conn, $delete)) {
				header("location: $url");
			} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}
?>