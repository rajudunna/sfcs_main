<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 

    $id=$_GET['id'];

    $is_requested="SELECT doc_no FROM $wms.material_deallocation_track WHERE id=$id";
    $is_requested_result=mysqli_query($link, $is_requested) or exit("Sql Error0: fabric_status_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row1=mysqli_fetch_array($is_requested_result))
    {
        $delete_qry="DELETE FROM $wms.material_deallocation_track WHERE id=$id";
        $delete_qry_result=mysqli_query($link, $delete_qry) or exit("Sql Error0: fabric_status_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
        echo "<script>swal('Error','Deleted Successfully','error')</script>";
        $url = getFullUrlLevel($_GET['r'],'material_deallocation.php',0,'N');
        echo "<script>setTimeout(function(){
                    location.href='$url' 
                },2000);
                </script>";
        exit();
    }