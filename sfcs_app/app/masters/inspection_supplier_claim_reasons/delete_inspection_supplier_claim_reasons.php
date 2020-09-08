
<script src="<?= getFullURLLevel($_GET['r'],'common/js/jquery-2.1.3.min.js',3,'R'); ?>"></script>
  <script src="<?= getFullURLLevel($_GET['r'],'common/js/sweetalert-dev.js',3,'R'); ?>"></script>
  <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/sweetalert.css',3,'R'); ?>">

<?php
$tid=$_GET['tid'];
$plant_code=$_SESSION['plantCode'];
$username=$_SESSION['userName']; 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
if (!$conn) { 
  die("Connection failed: " . mysqli_connect_error());
}
$url=getFullURL($_GET['r'],'save_inspection_supplier_claim_reasons.php','N');
 
$delete="delete from $mdm.inspection_complaint_reasons where tid='$tid'";

$sql_result=mysqli_query($link, $delete) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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

//header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2Rvd250aW1lcmVhc29uL2Rvd25fdGltZV9yZWFzb25fYWRkLnBocA==');

?> 