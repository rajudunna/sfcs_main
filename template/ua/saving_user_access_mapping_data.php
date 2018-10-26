<?php

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

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

if(is_array($_POST) && !empty($_POST))
{

    $role_id = $_POST['role'];
    $menu_id = $_POST['menu'];
    $menu_name = $_POST['menu_name'];
    $permissions = $_POST['id'];
    $menucount = sizeof($menu_id);
    //echo $menucount;
    if($menucount > 1 && $menu_name == '')
    {
      $menu = implode(",", $menu_id);
      $getmenuname = "SELECT menu_pid,link_description FROM $central_administration_sfcs.tbl_menu_list WHERE menu_pid IN ($menu)";
     // echo $getmenuname;
      $query_result = mysqli_query($link, $getmenuname) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
      while($row = mysqli_fetch_array($query_result)){
        $menuname = $row['link_description'];
        $id       = $row['menu_pid'];
        $menu_insert_query = "insert into $central_administration_sfcs.rbac_role_menu (roll_id,menu_pid,menu_description) values ('$role_id','$id','$menuname')";
        $query_result1 = mysqli_query($link, $menu_insert_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
        $role_menu_id = $link->insert_id;
        if ($role_menu_id) {

            foreach ($permissions as $key => $permission) {
                $sql_insert_query = "insert into $central_administration_sfcs.rbac_role_menu_per (role_menu_id,permission_id) values ('$role_menu_id','$permission')";
                 $query_result2 = mysqli_query($link, $sql_insert_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
                echo $sql_insert_query;
                
            }
        $_SESSION["msg"]='Role Menu and Permissions created successfully';
        $_SESSION["status"]=1;
        $url = getFullURL($_GET['r'],'view_all_user_access_mapping_data.php','N');
        header("Location:".$url); 
             //echo $sql_insert_query;
           
          
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error; 
        }

        }
       
    }
    else
    {
    $sql_insert_query = "insert into $central_administration_sfcs.rbac_role_menu (roll_id,menu_pid,menu_description) values ('$role_id','$menu_id','$menu_name')";
    $query_result = mysqli_query($link, $sql_insert_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    $role_menu_id = $link->insert_id;

    if ($role_menu_id) {

        foreach ($permissions as $key => $permission) {
            $sql_insert_query = "insert into $central_administration_sfcs.rbac_role_menu_per (role_menu_id,permission_id) values ('$role_menu_id','$permission')";
            $query_result = mysqli_query($link, $sql_insert_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
        }
         //echo $sql_insert_query;
        $_SESSION["msg"]='Role Menu and Permissions created successfully';
        $_SESSION["status"]=1;
        $url = getFullURL($_GET['r'],'view_all_user_access_mapping_data.php','N');
        header("Location:".$url); 
      
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; 
    }
    } 
    $link->close();
} 


?>