<?php
include('../dbconf.php');
GLOBAL $link;


$sql_menus = "SELECT menu_pid,link_description FROM tbl_menu_list WHERE link_location!='' order by menu_pid limit 0,100";
$res_menus = mysqli_query($link, $sql_menus) or exit($sql_menus."<br/>Error 2".mysqli_error($GLOBALS["___mysqli_ston"]));

while($menu_rs = mysqli_fetch_array($res_menus)){
    //======== insert menu data ======================
    $ins_menu = "INSERT INTO `rbac_role_menu`(menu_pid,menu_description,roll_id) VALUES ('".$menu_rs['menu_pid']."','".$menu_rs['link_description']."',1)";
    mysqli_query($link, $ins_menu) or exit($ins_menu."<br/>Error 3".mysqli_error($GLOBALS["___mysqli_ston"]));
    $menu_id = mysqli_insert_id($link);
    $sql_permissions = "SELECT permission_id FROM rbac_permission order by permission_id limit 0,4";
    $res_permissions = mysqli_query($link, $sql_permissions) or exit($sql_permissions."<br/>Error 1".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($permission_rs = mysqli_fetch_array($res_permissions)){
        //============= insert permission data ================
        $query_per = "INSERT INTO `rbac_role_menu_per`(role_menu_id,permission_id) VALUES ('".$menu_id."','".$permission_rs['permission_id']."')";
        mysqli_query($link, $query_per) or exit($query_per."<br/>Error 4".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
}

?>