<script src="<?= getFullURLLevel($_GET['r'],'common/js/jquery-2.1.3.min.js',3,'R'); ?>"></script>
  <script src="<?= getFullURLLevel($_GET['r'],'common/js/sweetalert-dev.js',3,'R'); ?>"></script>
  <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/sweetalert.css',3,'R'); ?>">
<?php
$rid=$_GET['rowid'];
//echo $rid;
// $servername = "192.168.0.110:3326";
// 	$username = "baiall";
// 	$password = "baiall";
// 	$dbname = "bai_pro3";

// Create connection
// $conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$url=getFullURL($_GET['r'],'add_packing_method.php','N');
// echo"<script>setTimeout(function () { 
// 	swal({
// 	  title: 'Are you sure?',
// 	  text: 'Your will not be able to recover this Record!',
// 	  type: 'warning',
// 	  confirmButtonText: 'OK'
// 	},
// 	function(isConfirm){
// 	  if (isConfirm) {
// 		window.location.href = \"$url\";
// 	  }
// 	}); }, 100);</script>";
$delete="delete from $bai_pro3.`pack_methods` where pack_id='$rid'";
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