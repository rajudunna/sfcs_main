<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/global_error_function.php',4,'R'));
	$main_url=getFullURL($_GET['r'],'delete_deallocation.php','R');
    $id=$_GET['id'];
	$plant_code=$_GET['plant_code'];
    $username=$_GET['username'];

    $is_requested="SELECT doc_no FROM $wms.material_deallocation_track WHERE id=$id and plant_code='".$plant_code."'";
    $is_requested_result=mysqli_query($link, $is_requested) or exit("Sql Error0: fabric_status_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
	log_statement('debug',$is_requested,$main_url,__LINE__);
	log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
    while($sql_row1=mysqli_fetch_array($is_requested_result))
    {
        $delete_qry="DELETE FROM $wms.material_deallocation_track WHERE id=$id and plant_code='".$plant_code."'";
        $delete_qry_result=mysqli_query($link, $delete_qry) or exit("Sql Error0: fabric_status_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
		log_statement('debug',$delete_qry,$main_url,__LINE__);
		log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
        echo "<script>swal('Error','Deleted Successfully','error')</script>";
        $url = getFullUrlLevel($_GET['r'],'material_deallocation.php',0,'N');
        echo "<script>setTimeout(function(){
                    location.href='$url' 
                },2000);
                </script>";
        exit();
    }