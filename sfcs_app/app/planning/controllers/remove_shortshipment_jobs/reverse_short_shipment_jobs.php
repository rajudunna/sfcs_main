<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    $id=$_GET['id'];
    $username = getrbac_user()['uname'];
    $updated_date = date("Y-m-d h:i:s");



    $update_revers_qry = "update $bai_pro3.`short_shipment_job_track` set remove_type='0',updated_by='".$username."',updated_at='".$updated_date."' where id=".$id;
    // var_dump($update_revers_qry);
    // die();
    $update_revers_qry_result = mysqli_query($link, $update_revers_qry) or exit("update error".mysqli_error($GLOBALS["___mysqli_ston"]));

    if($update_revers_qry_result) {

    }

?>

