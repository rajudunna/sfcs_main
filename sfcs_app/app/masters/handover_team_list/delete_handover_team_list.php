
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

<?php
$team_id=$_GET['team_id'];

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
$url=getFullURL($_GET['r'],'save_handover_team_list.php','N');
  
$delete="delete from bai_pro3.tbl_fg_crt_handover_team_list where team_id='$team_id'";
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
			// header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2luc3BlY3Rpb25fc3VwcGxpZXJzX2RiL3NhdmVfaW5zcGVjdGlvbl9zdXBwbGllcnMucGhw==');
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
?>