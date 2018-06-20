

<div class="panel panel-primary" style="height:150px;">
    <div class="panel-heading">All Permissions List</div>

        <div class="panel-body">  

            <h2>All Permissions List</h2>    
           
            <?php

                include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

                $sql_select_query = "SELECT permission_id,permission_name,permission_des FROM $central_administration_sfcs.rbac_permission";
                $query_result = mysqli_query($link, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

                if ($query_result->num_rows > 0) {

                    echo "<table><tr><th>Permission Name</th><th>Permission Desciption</th></tr>";
                    // output data of each row
                    while($row = $query_result->fetch_assoc()) {
                        echo "<tr><td>".$row["permission_name"]."</td><td>".$row["permission_des"]."</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No Data Found";
                }
                
                $link->close();

            ?>
        </div> 
    </div> 
</div> 

