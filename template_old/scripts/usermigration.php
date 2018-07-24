<?php
include('../dbconf.php');
GLOBAL $link_ui;

$ins_permissions = "insert  into `rbac_permission`(`permission_id`,`permission_des`,`permission_name`,`status`) values (1,'user can have view access only','view','active'),(2,'user can have manual edit rights','edit','active'),(3,'user can have update rights','update','active'),(4,'user can have delete rights','delete','active'),(5,'user can have approve access','approve','active'),(6,'user can have authorize access','authorized','active'),(7,'authorize Level - 1','authorizeLevel_1','active'),(8,'authorize Level - 2','authorizeLevel_2','active'),(9,'authorize Level - 3','authorizeLevel_3','active'),(10,'authorize Level - 4','authorizeLevel_4','active'),(11,'authorize Level - 5','authorizeLevel_5','active'),(12,'authorize Level - 6','authorizeLevel_6','active')";
mysqli_query($link_ui, $ins_permissions) or exit($ins_permissions."<br/>Error 0.01".mysqli_error($GLOBALS["___mysqli_ston"]));

$ins_role = "INSERT INTO `rbac_roles`(role_name) VALUES ('Super User')";
mysqli_query($link_ui, $ins_role) or exit($ins_role."<br/>Error 0.1".mysqli_error($GLOBALS["___mysqli_ston"]));

$role_id = mysqli_insert_id($link_ui);

$ins_user = "INSERT INTO `rbac_users`(role_id,`user_name`) VALUES (".$role_id.",'sfcsproject1')";
mysqli_query($link_ui, $ins_user) or exit($ins_user."<br/>Error 0.2".mysqli_error($GLOBALS["___mysqli_ston"]));


$sql_menus = "SELECT menu_pid,link_description FROM tbl_menu_list WHERE link_location!=''";
$res_menus = mysqli_query($link_ui, $sql_menus) or exit($sql_menus."<br/>Error 2".mysqli_error($GLOBALS["___mysqli_ston"]));

while($menu_rs = mysqli_fetch_array($res_menus)){
    //======== insert menu data ======================
    $ins_menu = "INSERT INTO `rbac_role_menu`(menu_pid,menu_description,roll_id) VALUES ('".$menu_rs['menu_pid']."','".$menu_rs['link_description']."',".$role_id.")";
    mysqli_query($link_ui, $ins_menu) or exit($ins_menu."<br/>Error 3".mysqli_error($GLOBALS["___mysqli_ston"]));
    $menu_id = mysqli_insert_id($link_ui);
    $sql_permissions = "SELECT permission_id FROM rbac_permission";
    $res_permissions = mysqli_query($link_ui, $sql_permissions) or exit($sql_permissions."<br/>Error 1".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($permission_rs = mysqli_fetch_array($res_permissions)){
        //============= insert permission data ================
        $query_per = "INSERT INTO `rbac_role_menu_per`(role_menu_id,permission_id) VALUES ('".$menu_id."','".$permission_rs['permission_id']."')";
        mysqli_query($link_ui, $query_per) or exit($query_per."<br/>Error 4".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
}

?>