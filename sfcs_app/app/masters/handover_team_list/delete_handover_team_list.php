
<script src="<?= getFullURLLevel($_GET['r'],'common/js/jquery-2.1.3.min.js',3,'R'); ?>"></script>
  <script src="<?= getFullURLLevel($_GET['r'],'common/js/sweetalert-dev.js',3,'R'); ?>"></script>
  <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/sweetalert.css',3,'R'); ?>">

<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$team_id=$_GET['team_id'];
$plant_code=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
$conn=$link;
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
$url=getFullURL($_GET['r'],'save_handover_team_list.php','N');
  
$delete="delete from $pms.tbl_fg_crt_handover_team_list where team_id='$team_id' and plant_code='$plant_code'";
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