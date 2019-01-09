<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
$rid=$_GET['tid'];
// echo $rid;
// $servername = "192.168.0.110:3326";
// 	$username = "baiall";
// 	$password = "baiall";
// 	$dbname = "bai_rm_pj1";

// Create connection
// $conn = mysqli_connect($servername, $username, $password, $dbname);
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$url=getFullURL($_GET['r'],'save_inspection_suppliers.php','N');

$delete="delete from bai_rm_pj1.`inspection_supplier_db` where tid='$rid'";
if (mysqli_query($conn, $delete)) {
	echo"<script>setTimeout(function () { 
		swal({
			title: 'Deleted successfully.',
			type: 'success',
			confirmButtonText: 'OK'
		},
		function(isConfirm){
			if (isConfirm) {
			window.location.href = \"$url\";
			}
		}); }, 100);</script>";
	echo "<script>window.location.href = \"$url\"</script>";

		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

?>