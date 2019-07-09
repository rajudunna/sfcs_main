<?php 
include("../../../common/config/config_ajax.php");
?>
<?php
// global $link;
// global $bai_pro3;


if(isset($_GET['row_id']))
{
    $php_self = explode('/',$_SERVER['HTTP_HOST']);
    array_pop($php_self);
    $url_r = base64_encode(implode('/',$php_self)."/sfcs_app/app/cutting/controllers/seperate_docket.php");
    $url1 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/index.php?r=".$url_r;


    $row_id = $_GET['row_id'];
    $status = $_GET['status'];
    if($status== 'Reject'){
        $status_new = 'Close';
    }
    
    $query = "UPDATE $bai_pro3.binding_consumption set status = '".$status_new."',status_at= '".date("Y-m-d H:i:s")."' where id = $row_id";
    $update_query = mysqli_query($link,$query);

    echo"<script>swal('Successfully Deleted.','','success')</script>";
	echo"<script>location.href =  '".$url1."';</script>"; 
}



?>