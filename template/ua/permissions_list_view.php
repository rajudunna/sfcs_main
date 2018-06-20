

<div class="panel panel-primary">
    <div class="panel-heading">All Permissions List</div>

        <div class="panel-body">  

            <h2>All Permissions List</h2>    
           
            <?php

                include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

                $sql_select_query = "SELECT permission_id,permission_name,permission_des FROM $central_administration_sfcs.rbac_permission";
                $query_result = mysqli_query($link, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

                if ($query_result->num_rows > 0) {

                    echo "<table class='table table-bordered'><tr><th>Permission Name</th><th>Permission Desciption</th></tr>";
                    // output data of each row
                    while($row = $query_result->fetch_assoc()) {
                        echo "<tr><td>".$row["permission_name"]."</td><td>".$row["permission_des"]."</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<div class='alert alert-danger'>No Data Found</div>";
                }
                
                $link->close();

            ?>
        </div> 
    </div> 
</div> 

