<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
$q_id=$_GET['rowid'];
// echo $dr_id;
// $servername = "192.168.0.110:3326";
// $username = "baiall";
// $password = "baiall";
// $dbname = "bai_pro2";

// Create connection
// $conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$url=getFullURL($_GET['r'],'surplus_table.php','N');

$delete="delete from $pms.bai_qms_location_db where q_id='$q_id'";
$sql_result=mysqli_query($link, $delete) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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

//header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2Rvd250aW1lcmVhc29uL2Rvd25fdGltZV9yZWFzb25fYWRkLnBocA==');
?>