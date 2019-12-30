<?php
    include('../dbconf.php');

if($_GET['pname'] != ''){
    $pname=strtoupper($_GET['pname']);
    $sql12="SELECT * from rbac_permission where permission_name = '".$pname."'";
    $sql_result12=mysqli_query($link_ui, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql_num_check12=mysqli_num_rows($sql_result12);
    if($sql_num_check12 > 0){
        echo 'duplicate';
        exit();
    } else {
        echo ($pname);
        exit(); 
    }
}
