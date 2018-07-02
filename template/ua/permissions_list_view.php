

<div class="panel panel-primary">
    <div class="panel-heading">All Permissions List</div>

        <div class="panel-body">  
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
                if($status==1){
            ?>
                
            <div class='alert alert-success' align="center"><b><?= $msg ?></b></div>
                
            <?php
                }elseif($status==2){
            ?> 

            <div class='alert alert-info' align="center"><b><?= $msg ?></b></div>

            <?php }else{ echo "";} ?>

            <?php

                $sql_select_query = "SELECT permission_id,permission_name,permission_des FROM rbac_permission";
                $query_result = mysqli_query($link_ui, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

                
                if ($query_result->num_rows > 0) {
                    echo "<table class='table table-bordered'><tr><th class='col-md-3'>PERMISSION NAME</th><th class='col-md-9'>PERMISSION DESCRIPTION</th></tr>";
                    // output data of each row
                    while($row = $query_result->fetch_assoc()) {
                        echo "<tr><td>".$row["permission_name"]."</td><td>".$row["permission_des"]."</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<div class='alert alert-danger'>No Data Found</div>";
                }
                
                $link_ui->close();

            ?>
        </div> 
    </div> 
</div> 

