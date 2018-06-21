<?php

session_start();
if(isset($_SESSION["errormsg"])) {
    $error = $_SESSION["errormsg"]; 
    session_unset($_SESSION["errormsg"]);
} else {
    $error = "";
}

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

if(is_array($_POST) && !empty($_POST))
{

    $role_id = $_POST['role'];
    $menu_id = $_POST['menu'];
    $menu_name = $_POST['menu_name'];
    $permissions = $_POST['id'];
   
    $sql_insert_query = "insert into $central_administration_sfcs.rbac_role_menu (roll_id,menu_pid,menu_description) values ('$role_id','$menu_id','$menu_name')";
    $query_result = mysqli_query($link, $sql_insert_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    $role_menu_id = $link->insert_id;

    if ($role_menu_id) {

        foreach ($permissions as $key => $permission) {
            $sql_insert_query = "insert into $central_administration_sfcs.rbac_role_menu_per (role_menu_id,permission_id) values ('$role_menu_id','$permission')";
            $query_result = mysqli_query($link, $sql_insert_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
        }

        $_SESSION["errormsg"]='Role Menu and Permissions created successfully';
        $url = getFullURL($_GET['r'],'view_all_user_access_mapping_data.php','N');
        header("Location:".$url); 
      
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; 
    }

    $link->close();
} 


?>