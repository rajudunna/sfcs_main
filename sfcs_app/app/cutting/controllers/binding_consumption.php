<?php 
include("../../../common/config/config_ajax.php");
?>
<script src="../../../common/js/sweetalert.min.js"></script>
<?php
// global $link;
// global $bai_pro3;


if(isset($_GET['row_id']))
{
    $php_self = explode('/',$_SERVER['PHP_HOST']);
    array_pop($php_self);
    $url_r = base64_encode(implode('/',$php_self)."/sfcs_app/app/cutting/controllers/seperate_docket.php");
    $url1 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/index-no-navi.php?r=".$url_r;
  

    $row_id = $_GET['row_id'];
    $status = $_GET['status'];
    $plant_code = $_GET['plantcodename'];
$username = $_GET['username'];
    if($status== 'Reject'){
        $status_new = 'Close';
    }

    $deletedata="delete from $pps.binding_consumption_items where parent_id='$row_id' and plant_code='$plant_code'";
	$deletedata_query = mysqli_query($link,$deletedata);
	
	$deletemain="delete from $pps.binding_consumption where id = '$row_id'and plant_code='$plant_code'";
	$deletemain_query = mysqli_query($link,$deletemain);
    $query = "UPDATE $pps.binding_consumption set status = '".$status_new."',status_at= '".date("Y-m-d H:i:s")."',updated_user= '".$username."',updated_at=NOW() where id = $row_id and plant_code='$plant_code'";
    $update_query = mysqli_query($link,$query);
   
  
    echo "<script type='text/javascript'>
    document.addEventListener('DOMContentLoaded', function(event) {
      swal('Error','Rejected Successfully','error');
    });
    </script>";                            
    echo "<script>setTimeout(function(){
       
                location.href='$url1' 
            },2000);
            </script>";
 
    
    
}



?>