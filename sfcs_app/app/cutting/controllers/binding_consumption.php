<?php 
include("../../../common/config/config_ajax.php");
?>
<?php
// global $link;
// global $bai_pro3;

// var_dump($_GET['row_id']);
if(isset($_GET['row_id']))
{
    $row_id = $_GET['row_id'];
    $status = $_GET['status'];
    if($status== 'Allocate'){
        $status_new = 'Allocated';
    }
    $query = "UPDATE $bai_pro3.binding_consumption set status = '".$status_new."' where id = $row_id";
    $update_query = mysqli_query($link,$query);

    $message = 'success';
    echo json_encode($message);
    exit;
    // test();
}

// function test(){
//     var_dump($message);

//     return $message;
// }

?>