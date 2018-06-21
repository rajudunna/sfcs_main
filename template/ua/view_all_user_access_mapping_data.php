

<?php

    session_start();
    if(isset($_SESSION["msg"])) {
        $msg = $_SESSION["msg"];
        $status =  $_SESSION["status"];
        session_unset($_SESSION["msg"]);
        session_unset($_SESSION["status"]);
    } else {
        $msg = "";
        $status = "";
    }

?>

<?php 
    if($status==1){
?>

<div class='alert alert-success' align="center"><b><?= $msg ?></b></div>

<?php
    }elseif($status==2){
?> 

<div class='alert alert-info' align="center"><b><?= $msg ?></b></div>

<?php }else{ echo "";} ?>

