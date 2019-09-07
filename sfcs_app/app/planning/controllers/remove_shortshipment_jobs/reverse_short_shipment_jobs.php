<?php
    $id=$_GET['id'];
    $username = getrbac_user()['uname'];
    $updated_date = date("Y-m-d h:i:s");

    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));


    $update_revers_qry = "update $bai_pro3.`short_shipment_job_track` set shipment_remove_status=0,removed_by=$username,updated_by=$updated_date where id=".$id;
    // var_dump($update_revers_qry);
    // die();
    $update_revers_qry_result = mysqli_query($link, $update_revers_qry) or exit("update error".mysqli_error($GLOBALS["___mysqli_ston"]));

    if($update_revers_qry_result) {

    }

?>