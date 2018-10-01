
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

<?php
$rid=$_GET['tid'];

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
$url=getFullURL($_GET['r'],'save_inspection_supplier_claim_reasons.php','N');
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
$delete="delete from bai_rm_pj1.inspection_complaint_reasons where tid='$rid'";
if (mysqli_query($conn, $delete)) {

	  } else {
		  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	  }
//header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2Rvd250aW1lcmVhc29uL2Rvd25fdGltZV9yZWFzb25fYWRkLnBocA==');
?>