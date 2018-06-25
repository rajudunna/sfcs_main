
<?php

    include('../dbconf.php');

    if(isset($_GET['uid'])){
        $uid = $_GET['uid'];
        $uname = $_GET['uname'];
        $rid = $_GET['rid'];
    }else{
        $uid = '';
        $uname = '';
        $rid = '';
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
                            echo 'User and Assigned Role Updation';
                        }else{
                            echo 'User Creation and Assign Role';
                        } ?></div>

        <div class="panel-body">


            <form name = "form1" action="<?= getFullURL($_GET['r'],'user_assigned_role_updation.php','N');?>" method = "post">    
                <div class = "row">    
                    <div class ="col-md-3">    
                        <label>User Name:</label>    
                        <input type = "text" name = "uname" value = "<?= $uname ?>" class="form-control" required readonly/>   
                        <input type="hidden" name="uid"  value="<?= $uid ?>"/>
                    </div> 
                    <div class="col-md-3">
                        <label>Role Name:</label>
                        <select class="form-control" name='rid' id='role'>

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

                        $sql_select_query = "SELECT COUNT(*) as count FROM rbac_users WHERE user_id = '$user_id' and role_id='$role_id'";
                        $query_result = mysqli_query($link_ui, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

                        $assined_role = mysqli_fetch_array($query_result);
                        $unique_count = $assined_role['count'];

                        if($unique_count == 0){

                            $sql_update_query = "update rbac_users set role_id = '$role_id' where user_id='$user_id'";
                            $query_result = mysqli_query($link_ui, $sql_update_query) or exit("Sql Error2=".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            if ($query_result) {
                                $_SESSION["msg"]='User Role updated successfully';
                                $_SESSION["status"] = 2;
                                $url = getFullURL($_GET['r'],'view_all_users_and_assigned_roles.php','N');
                                header("Location:".$url); 
                            } else {
                                echo "Error: " . $sql . "<br>" . $conn->error; 
                            }
                        }else{
                            $_SESSION["msg"]='This Role already assined to this user';
                            $_SESSION["status"] = 0;
                            $url = getFullURL($_GET['r'],'user_assigned_role_updation.php','N');
                            header("Location: $url&uid=".$user_id."&uname=".$user_name."&rid=".$role_id);
                        }
                        
                        $link_ui->close();
                        
                    }
                }
            ?>
        </div> 
    </div> 
</div> 

<script>

$(document).ready( function () {

  var role = '<?= $rid ?>';

  if(role){
       $("#role").val(role);
  }

});

</script>

