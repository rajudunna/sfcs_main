
<?php

    include('../dbconf.php');

    if(isset($_GET['rid'])){
        $rid = $_GET['rid'];
        $rname = $_GET['rname'];
    }else{
        $rid = '';
        $rname = '';
    }

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

<div class="panel panel-primary">

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

            <form name = "form1" action="<?= getFullURL($_GET['r'],'role_creation_updation_ui.php','N');?>" method = "post">    
                <div class = "row">    
                    <div class = "form_group col-md-3">    
                        <label>Role Name:</label>    
                        <input type = "text" name = "rname" value = "<?= $rname ?>" class="form-control" required />   
                        <input type="hidden" name="roleid"  value="<?= $rid ?>"/>
                    </div>  
                    <div class='col-md-2'>
                        <input type="submit" value="<?php if(isset($_GET['rname'])){
                            echo 'Update';
                        }else{
                            echo 'Save';
                        } ?>" name="submit" class="btn btn-primary" style="margin-top:22px;">
                    </div>    
                </div>    
            </form>  

            <?php 
                if($msg){
            ?>

            <span class="label label-danger"><?= $msg ?></span>

            <?php
                }
            ?> 

            <?php

                if(isset($_POST['submit']))
                {
                    $role_name = $_POST['rname'];
                    $roleid = $_POST['roleid'];
                  
                    if($_POST['submit'] == 'Update'){

                        $sql_select_query = "SELECT COUNT(*) as count FROM rbac_roles WHERE role_name = '$role_name'";
                        $query_result = mysqli_query($link_ui, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

                        $role_names = mysqli_fetch_array($query_result);
                        $unique_count = $role_names['count'];

                        if($unique_count == 0){

                            $sql_update_query = "update rbac_roles set role_name = '$role_name' where role_id='$roleid'";
                            $query_result = mysqli_query($link_ui, $sql_update_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            if ($query_result) {
                                $_SESSION["msg"]='Role Name updated successfully';
                                $_SESSION["status"] = 2;
                                $url = getFullURL($_GET['r'],'roles_list_view.php','N');
                                header("Location:".$url); 
                            } else {
                                echo "Error: " . $sql . "<br>" . $conn->error; 
                            }
                        }else{
                            $_SESSION["msg"]='Role Name already exist';
                            $_SESSION["status"] = 0;
                            $url = getFullURL($_GET['r'],'role_creation_updation_ui.php','N');
                            header("Location: $url&rid=".$roleid."&rname=".$role_name);
                        }
                        
                        $link_ui->close();
                       
                    }else{

                        $sql_select_query = "SELECT COUNT(*) as count FROM rbac_roles WHERE role_name = '$role_name'";
                        $query_result = mysqli_query($link_ui, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

                        $role_names = mysqli_fetch_array($query_result);
                        $unique_count = $role_names['count'];
                        
                        if($unique_count == 0){
                            $sql_insert_query = "insert into rbac_roles (role_name) values ('$role_name')";
                            $query_result = mysqli_query($link_ui, $sql_insert_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            if ($query_result) {
                                $_SESSION["msg"]='Role Name created successfully';
                                $_SESSION["status"] = 1;
                                $url = getFullURL($_GET['r'],'roles_list_view.php','N');
                                header("Location:".$url); 
                            } else {
                                echo "Error: " . $sql . "<br>" . $conn->error; 
                            }
                        }else{
                            echo "<span class='label label-danger'>Role Name already exist</span>";
                        }
                        
                        $link_ui->close();
                        
                    }

                }
            ?>
        </div> 
    </div> 
</div> 

