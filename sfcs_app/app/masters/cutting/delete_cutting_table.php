<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
$tbl_id=$_GET['rowid'];

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if($tbl_id!=''){
	$url=getFullURL($_GET['r'],'cutting_table_add.php','N');
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
$delete="delete from $bai_pro3.`tbl_cutting_table` where tbl_id='$tbl_id'";
//echo $delete;
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
	}
//header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2N1dHRpbmcvY3V0dGluZ190YWJsZV9hZGQucGhw');
?>