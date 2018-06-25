

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

?>

<?php 
    if($status==1){
?>

<div class='alert alert-success' align="center"><b><?= $msg ?></b></div>

<?php
    }elseif($status==2){
?> 

<div class='alert alert-info' align="center"><b><?= $msg ?></b></div>

<?php }else{ echo "";} ?>

<div class="panel panel-primary">

    <div class="panel-heading">All Users And Assigned Roles List</div>

        <div class="panel-body">  
         

            <?php

                include('../dbconf.php');

                $sql_select_query = "SELECT user_id,user_name,rbac_roles.role_id as role_id,role_name FROM rbac_roles right join rbac_users on rbac_roles.role_id = rbac_users.role_id";
                $query_result = mysqli_query($link_ui, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

                if ($query_result->num_rows > 0) {

                    echo "<div class='col-sm-8'><table class='table table-bordered'><tr><th class='col-sm-2'>USER NAME</th><th class='col-sm-2'>ROLE NAME</th><th class='col-sm-4'>ACTION</th></tr>";
                    // output data of each row
                    while($row = $query_result->fetch_assoc()) {
                        
                        $uid = $row["user_id"];
                        $uname = $row["user_name"];
                        $rid = $row["role_id"];
                        $rname = $row["role_name"];
                        
                        // $url = $_SERVER['DOCUMENT_ROOT'].'/ui/role_creation_ui?uname='.$row["user_name"];
                        $url1 = getFullURL($_GET['r'],'user_name_updation.php','N');
                        $url2 = getFullURL($_GET['r'],'user_assigned_role_updation.php','N');
                        echo "<tr>
                                <td>".$row["user_name"]."</td>
                                <td>".$row["role_name"]."</td>
                                <td><a href='$url1&uid=$uid&uname=$uname'><button class='btn btn-sm btn-primary'>Update User Name</button>
                                <a href='$url2&uid=$uid&uname=$uname&rid=$rid'><button class='btn btn-sm btn-success'>Update User Role</button></td>
                            </tr>";
                    }
                    echo "</table></div>";
                } else {
                    echo "<div class='alert alert-info' align='center'>No Data Found</div>";
                }
                
                $link_ui->close();

            ?>

        </div> 
    </div> 
</div> 


