<?php
$rid=$_GET['tid'];


include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$url=getFullURL($_GET['r'],'save_suppliers_master_data.php','N');
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
$delete="delete from $bai_rm_pj1.`inspection_supplier_db` where tid='$rid'";
// echo $delete;
if (mysqli_query($conn, $delete)) {
			
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
//header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2Rvd250aW1lcmVhc29uL2Rvd25fdGltZV9yZWFzb25fYWRkLnBocA==');
?>