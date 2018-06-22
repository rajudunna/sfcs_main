

<?php 

    include('../dbconf.php');

    $role_menu_id = $_POST['role_menu_id'];
    $new_permissions = $_POST['permission_ids'];
    $old_records = $_POST['ids'];

    // Delete Old Permission Records

    foreach ($old_records as $key => $rid) {
        $sql_insert_query = "DELETE FROM rbac_role_menu_per WHERE role_menu_per_id = '$rid'";
        $query_result = mysqli_query($link, $sql_insert_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
    }

    // Insert New Permissions

    foreach ($new_permissions as $key => $pid) {
        $sql_insert_query = "insert into rbac_role_menu_per (role_menu_id,permission_id) values ('$role_menu_id','$pid')";
        $query_result = mysqli_query($link, $sql_insert_query) or exit("Sql Error2=".mysqli_error($GLOBALS["___mysqli_ston"]));
    }

    $_SESSION["msg"]='Permissions updated successfully';
    $_SESSION["status"]=1;
    $url = getFullURL($_GET['r'],'view_all_user_access_mapping_data.php','N');
    header("Location:".$url); 


?>