

<?php

    session_start();
    if(isset($_SESSION["errormsg"])) {
        $error = $_SESSION["errormsg"]; 
        session_unset($_SESSION["errormsg"]);
    } else {
        $error = "";
    }

?>

<?php 
    if($error){
?>

<span class="label label-success"><?= $error ?></span>

<?php
    }

    echo "View Page Under Devlo-pment";
?>

