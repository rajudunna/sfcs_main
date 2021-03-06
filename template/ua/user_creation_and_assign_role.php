
<?php

    include('../dbconf.php');

    if(isset($_GET['uid'])){
        $uid = $_GET['uid'];
        $uname = $_GET['uname'];
    }else{
        $uid = '';
        $uname = '';
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

    <div class="panel-heading"><?php if(isset($_GET['uname'])){
                            echo 'User Name Updation';
                        }else{
                            echo 'User Creation';
                        } ?></div>

        <div class="panel-body">


            <form name = "form1" action="<?= getFullURL($_GET['r'],'user_creation_and_assign_role.php','N');?>" method = "post">    
                <div class = "row">    
                    <div class = "col-md-3">    
                        <label>User Name:</label>    
                        <input type = "text" name = "uname" value = "<?= $uname ?>" class="form-control" required />   
                        <input type="hidden" name="uid"  value="<?= $uid ?>"/>
                    </div> 
                    <div class="col-md-3">
                        <label>Role Name:</label>
                        <select class="form-control" name='rid' id='role' required >

                            <option value="">Select Role Name</option>

                            <?php

                                $sql_select_query = "SELECT role_id,role_name FROM rbac_roles";
                                $query_result = mysqli_query($link_ui, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
                                
                                if($query_result->num_rows > 0){
                                    while ($row = $query_result->fetch_assoc()) {
                                     echo '<option value="'.$row['role_id'].'">'.$row['role_name'].'</option>';
                                    }
                                } 
                            ?>

                        </select>
                    </div>  
                    <div class='col-md-2'>
                        <input type="submit" value="<?php if(isset($_GET['uname'])){
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
                    $user_name = $_POST['uname'];
                    $user_id = $_POST['uid'];
                    $role_id = $_POST['rid'];

                    if($_POST['submit'] == 'Update'){

                        $sql_select_query = "SELECT COUNT(*) as count FROM rbac_users WHERE user_name = '$user_name'";
                        $query_result = mysqli_query($link_ui, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

                        $user_names = mysqli_fetch_array($query_result);
                        $unique_count = $user_names['count'];

                        if($unique_count == 0){

                            $sql_update_query = "update rbac_users set user_name = '$user_name' where user_id='$user_id'";
                            $query_result = mysqli_query($link_ui, $sql_update_query) or exit("Sql Error2=".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            if ($query_result) {
                                $_SESSION["msg"]='User Name updated successfully';
                                $_SESSION["status"] = 2;
                                $url = getFullURL($_GET['r'],'view_all_users_and_assigned_roles.php','N');
                                header("Location:".$url); 
                            } else {
                                echo "Error: " . $sql . "<br>" . $conn->error; 
                            }
                        }else{
                            $_SESSION["msg"]='User Name already exist';
                            $_SESSION["status"] = 0;
                            $url = getFullURL($_GET['r'],'user_creation_and_assign_role.php','N');
                            header("Location: $url&uid=".$user_id."&uname=".$user_name);
                        }
                        
                        $link_ui->close();
                       
                    }else{

                        $sql_select_query = "SELECT COUNT(*) as count FROM rbac_users WHERE user_name = '$user_name'";
                        $query_result = mysqli_query($link_ui, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

                        $user_names = mysqli_fetch_array($query_result);
                        $unique_count = $user_names['count'];
                        
                        if($unique_count == 0){
                            $sql_insert_query = "insert into rbac_users (user_name, role_id) values ('$user_name', '$role_id')";
                            $query_result = mysqli_query($link_ui, $sql_insert_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            if ($query_result) {
                                $_SESSION["msg"]='User Name Created and Role Assigned successfully';
                                $_SESSION["status"] = 1;
                                $url = getFullURL($_GET['r'],'view_all_users_and_assigned_roles.php','N');
                                header("Location:".$url); 
                            } else {
                                echo "Error: " . $sql . "<br>" . $conn->error; 
                            }
                        }else{
                            echo "<span class='label label-danger'>User Name with Role already exist</span>";
                        }
                        
                        $link_ui->close();
                        
                    }

                }
            ?>
        </div> 
    </div> 
</div> 

