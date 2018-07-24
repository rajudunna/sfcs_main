

<?php 

   
    include('../dbconf.php');
   
    $role_menu_id = $_POST['role_menu_id'];
    $new_permissions = json_decode($_POST['permission_ids']);
    $old_records = $_POST['ids'];
    $old_records = json_decode($old_records);


    if($old_records){

        // Delete Old Permission Records

        foreach ($old_records as $key => $rid) {
            $sql_insert_query = "DELETE FROM rbac_role_menu_per WHERE role_menu_per_id = '$rid'";
            $query_result = mysqli_query($link_ui, $sql_insert_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
        }

        if($new_permissions){

            // Insert New Permissions

            foreach ($new_permissions as $key => $pid) {
                $pid = $pid->permission_id;
                $sql_insert_query = "insert into rbac_role_menu_per (role_menu_id,permission_id) values ('$role_menu_id','$pid')";
                $query_result = mysqli_query($link_ui, $sql_insert_query) or exit("Sql Error2=".mysqli_error($GLOBALS["___mysqli_ston"]));
            }

        }else{

            // Delete Old Menu Record

            $sql_insert_query = "DELETE FROM rbac_role_menu WHERE role_menu_id = '$role_menu_id'";
            $query_result = mysqli_query($link_ui, $sql_insert_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

        }

        $_SESSION["msg"]='Permissions updated successfully';
        $_SESSION["status"]=1;
        $url = getFullURL($_GET['r'],'view_all_user_access_mapping_data.php','N');
        header("Location:".$url); 

    }
    

?>