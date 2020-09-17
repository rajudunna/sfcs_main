<script src="/sfcs_app/common/js/jquery-2.1.3.min.js"></script>
  <script src="/sfcs_app/common/js/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/sweetalert.css',3,'R'); ?>">
<?php
$tbl_id=$_GET['tid'];

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
$plant_code=$_SESSION['plantCode'];
$username=$_SESSION['userName']; 
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

	$url=getFullURL($_GET['r'],'cutting_table_add.php','N');
	
$delete="delete from $pms.`tbl_leader_name` where id='$tbl_id' and plant_code='$plant_code'";
$sql_result=mysqli_query($link, $delete) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    echo "<script>window.location = '".$url."'</script>";

//header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2N1dHRpbmcvY3V0dGluZ190YWJsZV9hZGQucGhw');
?>