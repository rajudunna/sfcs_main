
<?php
    if(isset($_GET['rid'])){
        $rid = $_GET['rid'];
        $rname = $_GET['rname'];
    }else{
        $rid = '';
        $rname = '';
    }

  
    session_start();
    if(isset($_SESSION["errormsg"])) {
        $error = $_SESSION["errormsg"]; 
        session_unset($_SESSION["errormsg"]);
    } else {
        $error = "";
    }

?>

<div class="panel panel-primary" style="height:150px;">

    <div class="panel-heading"><?php if(isset($_GET['rname'])){
                            echo 'Role Updation';
                        }else{
                            echo 'Role Creation';
                        } ?></div>

        <div class="panel-body">

            <h2><?php if(isset($_GET['rname'])){
                            echo 'Role Updation';
                        }else{
                            echo 'Role Creation';
                        } ?></h2> 

            <form name = "form1" action="role_creation_updation_ui.php" method = "post">    
                <div class = "container">    
                    <div class = "form_group">    
                        <label>Role Name:</label>    
                        <input type = "text" name = "rname" value = "<?= $rname ?>" required/>   
                        <input type="hidden" name="roleid"  value="<?= $rid ?>"/>
                    </div>  
                    <div class='col-md-2'>
                        <input type="submit" value="<?php if(isset($_GET['rname'])){
                            echo 'Update';
                        }else{
                            echo 'Save';
                        } ?>" name="submit" class="btn btn-primary">
                    </div>    
                </div>    
            </form>  

            <?php 
                if($error){
            ?>

            <div id='alert'><div class=' alert alert-block alert-info fade in center'><?= $error ?></div></div>

            <?php
                }
            ?> 

            <?php

                include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

                if(isset($_POST['submit']))
                {
                    $role_name = $_POST['rname'];
                    $roleid = $_POST['roleid'];
                  
                    if($_POST['submit'] == 'Update'){

                        $sql_select_query = "SELECT COUNT(*) as count FROM $central_administration_sfcs.rbac_roles WHERE role_name = '$role_name'";
                        $query_result = mysqli_query($link, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

                        $role_names = mysqli_fetch_array($query_result);
                        $unique_count = $role_names['count'];

                        if($unique_count == 0){

                            $sql_update_query = "update $central_administration_sfcs.rbac_roles set role_name = '$role_name' where role_id='$roleid'";
                            $query_result = mysqli_query($link, $sql_update_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            if ($query_result) {
                                $_SESSION["errormsg"]='Role Name updated successfully';
                                header("Location:roles_list_view.php"); 
                            } else {
                                echo "Error: " . $sql . "<br>" . $conn->error; 
                            }
                        }else{
                            $_SESSION["errormsg"]='Role Name already exist';
                            header("Location:role_creation_updation_ui.php?rid=".$roleid."&rname=".$role_name);
                        }
                        
                        $link->close();
                       
                    }else{

                        $sql_select_query = "SELECT COUNT(*) as count FROM $central_administration_sfcs.rbac_roles WHERE role_name = '$role_name'";
                        $query_result = mysqli_query($link, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

                        $role_names = mysqli_fetch_array($query_result);
                        $unique_count = $role_names['count'];
                        
                        if($unique_count == 0){
                            $sql_insert_query = "insert into $central_administration_sfcs.rbac_roles (role_name) values ('$role_name')";
                            $query_result = mysqli_query($link, $sql_insert_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            if ($query_result) {
                                header("Location:roles_list_view.php");
                                echo "Role Name created successfully"; 
                            } else {
                                echo "Error: " . $sql . "<br>" . $conn->error; 
                            }
                        }else{
                            echo "Role Name already exist";
                        }
                        
                        $link->close();
                        
                    }

                }
            ?>
        </div> 
    </div> 
</div> 

