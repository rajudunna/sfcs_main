<?php

    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

    $role_id = $_GET['role_id'];
    $menu_id = $_GET['menu_id'];

    // $role_id = 3;
    // $menu_id = 1538;

    $sql_select_query = "SELECT COUNT(*) as count FROM $central_administration_sfcs.rbac_role_menu WHERE roll_id = '$role_id' and menu_pid = '$menu_id'";
    $query_result = mysqli_query($link, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

    $role_menu_data = mysqli_fetch_array($query_result);
    $unique_count = $role_menu_data['count'];

    if($unique_count == '0'){

        echo 'proceed';
        
    }else{

        $sql_select_query = "SELECT role_menu_id FROM $central_administration_sfcs.rbac_role_menu WHERE roll_id = '$role_id' and menu_pid = '$menu_id'";
        $query_result = mysqli_query($link, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

        $data = mysqli_fetch_array($query_result);
        $role_menu_id = $data['role_menu_id'];

        $sql_select_query = "SELECT COUNT(*) as count FROM $central_administration_sfcs.rbac_role_menu_per WHERE role_menu_id = '$role_menu_id'";
        $query_result = mysqli_query($link, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

        $role_menu_data = mysqli_fetch_array($query_result);
        $unique_count = $role_menu_data['count'];
        
        if($unique_count == '0'){

            echo 'proceed';

        }else{
            
            echo 'stop';
        }

    }
   
    $link->close();

?>