

<?php

    include('../dbconf.php');

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

// Get Role and Menu and Permissions Data


<?php 

$RolsMenusPermissionsMappingData = [];

$sql_select_query = "SELECT role_menu_per_id as record_id,role_name,rbac_role_menu_per.role_menu_id as role_menu_parent_id,menu_description,group_concat(permission_name) as permissions,group_concat(rbac_role_menu_per.permission_id) as permissions_parent_ids from rbac_roles right join rbac_role_menu on rbac_roles.role_id= rbac_role_menu.roll_id right join rbac_role_menu_per on rbac_role_menu.role_menu_id=rbac_role_menu_per.role_menu_id right join rbac_permission on rbac_role_menu_per.permission_id=rbac_permission.permission_id group by role_name,menu_description";
$query_result = mysqli_query($link_ui, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
$i = 0;
if($query_result->num_rows > 0){

    while ($row = $query_result->fetch_assoc()) {

        $RolsMenusPermissionsMappingData[$i]['id']= $row['record_id'];
        $RolsMenusPermissionsMappingData[$i]['role_name']= $row['role_name'];
        $RolsMenusPermissionsMappingData[$i]['menu_name']= $row['menu_description'];
        $RolsMenusPermissionsMappingData[$i]['role_menu_id']= $row['role_menu_parent_id'];

        $myString = $row['permissions'];
        $permissionNamesArray = explode(',', $myString);
       
        $RolsMenusPermissionsMappingData[$i]['permission_names']= $permissionNamesArray;

        $myString = $row['permissions_parent_ids'];
        $permissionIdsArray = explode(',', $myString);
       
        $RolsMenusPermissionsMappingData[$i]['permission_ids']= $permissionIdsArray;
        $i++;
    }

    var_dump($RolsMenusPermissionsMappingData);
    die();
}


