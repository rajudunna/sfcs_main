<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
$dr_id=$_GET['tid'];


include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$url=getFullURL($_GET['r'],'transport_modes_add.php','N');

$delete="delete from $bai_pro3.`transport_modes` where sno='$dr_id' ";
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
?>