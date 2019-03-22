
<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$url=getFullURL($_GET['r'],'plant_timings_add.php','N');

$id = $_GET['id'];

$conn = $link;
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$delete="delete from $bai_pro3.`tbl_plant_timings` where time_id='$id'";
if(mysqli_query($conn, $delete)) {
    echo"<script>swal('Deleted Successfully','','success');setTimeout(function(){ window.location.href = \"$url\";} ,1000);</script>";
    
}else{
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?>