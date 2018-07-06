<?php

    include('../dbconf.php');

    $role_id = $_GET['role_id'];
    $menu_id = $_GET['menu_id'];

    // $role_id = 9;
    // $menu_id = 1541;

    $sql_select_query = "SELECT COUNT(*) as count FROM rbac_role_menu WHERE roll_id = '$role_id' and menu_pid = '$menu_id'";
    $query_result = mysqli_query($link_ui, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

    $role_menu_data = mysqli_fetch_array($query_result);
    $unique_count = $role_menu_data['count'];

    if($unique_count == '0'){

        echo json_encode(['status'=>'Proceed']);
        
    }else{

        $sql_select_query = "SELECT role_menu_id FROM rbac_role_menu WHERE roll_id = '$role_id' and menu_pid = '$menu_id'";
        $query_result = mysqli_query($link_ui, $sql_select_query) or exit("Sql Error2=".mysqli_error($GLOBALS["___mysqli_ston"]));

        $data = mysqli_fetch_array($query_result);
        $role_menu_id = $data['role_menu_id'];

        $sql_select_query = "SELECT COUNT(*) as count FROM rbac_role_menu_per WHERE role_menu_id = '$role_menu_id'";
        $query_result = mysqli_query($link_ui, $sql_select_query) or exit("Sql Error3=".mysqli_error($GLOBALS["___mysqli_ston"]));

        $role_menu_data = mysqli_fetch_array($query_result);
        $unique_count = $role_menu_data['count'];
        
        if($unique_count == '0'){

            echo 'Proceed';
            die();

        }else{
            
            echo 'Stop';
            die();
        }

    }
   
    $link_ui->close();

?>