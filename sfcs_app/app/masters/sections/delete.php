<script src="/sfcs_app/common/js/jquery-2.1.3.min.js"></script>
  <script src="/sfcs_app/common/js/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

<?php
$rid=$_GET['rowid'];
// echo $rid;
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

	$url=getFullURL($_GET['r'],'add_section.php','N');
	echo"<script>setTimeout(function () { 
		swal({
		  title: 'Are you sure?',
		  text: 'Your will not be able to recover this Record!',
		  type: 'warning',
		  confirmButtonText: 'OK'
		},
		function(isConfirm){
		  if (isConfirm) {
			window.location.href = \"$url\";
		  }
		}); }, 100);</script>";
$delete="delete from $bai_pro3.sections_db where sec_id='$rid'";
if (mysqli_query($conn, $delete)) {
			// header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL3NlY3Rpb25zL2FkZF9zZWN0aW9uLnBocA==');
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

?>
