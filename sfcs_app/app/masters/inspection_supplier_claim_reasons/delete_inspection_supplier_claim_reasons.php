
<script src="/sfcs_app/common/js/jquery-2.1.3.min.js"></script>
  <script src="/sfcs_app/common/js/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

<?php
$tid=$_GET['tid'];

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
if (!$conn) { 
  die("Connection failed: " . mysqli_connect_error());
}
$url=getFullURL($_GET['r'],'save_inspection_supplier_claim_reasons.php','N');
  
$delete="delete from bai_rm_pj1.inspection_complaint_reasons where tid='$tid'";

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