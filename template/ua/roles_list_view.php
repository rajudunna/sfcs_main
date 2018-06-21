

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

    <div class="panel-heading">All Roles List</div>

        <div class="panel-body">  
         
            <h2>All Roles List</h2>   

            <?php

                include('../dbconf.php');

                $sql_select_query = "SELECT role_id,role_name FROM rbac_roles";
                $query_result = mysqli_query($link_ui, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

                if ($query_result->num_rows > 0) {

                    echo "<table class='table table-bordered'><tr><th>Name</th><th>Action</th></tr>";
                    // output data of each row
                    while($row = $query_result->fetch_assoc()) {
                        $rid = $row["role_id"];
                        $rname = $row["role_name"];
                        
                        // $url = $_SERVER['DOCUMENT_ROOT'].'/ui/role_creation_ui?rname='.$row["role_name"];
                        $url = getFullURL($_GET['r'],'role_creation_updation_ui.php','N');
                        echo "<tr>
                                <td>".$row["role_name"]."</td>
                                <td><a href='$url&rid=$rid&rname=$rname'><button class='btn btn-sm btn-success'>Edit</button></td>
                            </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<div class='alert alert-info' align='center'>No Data Found</div>";
                }
                
                $link_ui->close();

            ?>

        </div> 
    </div> 
</div> 


