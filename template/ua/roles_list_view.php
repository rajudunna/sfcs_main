

<?php

session_start();
if(isset($_SESSION["errormsg"])) {
    $error = $_SESSION["errormsg"]; 
    session_unset($_SESSION["errormsg"]);
} else {
    $error = "";
}

?>

<div class="panel panel-primary" style="height:150px;">
    <div class="panel-heading">All Roles List</div>

        <div class="panel-body">  
         
            <h2>All Roles List</h2>   

            <?php

                include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

                $sql_select_query = "SELECT role_id,role_name FROM $central_administration_sfcs.rbac_roles";
                $query_result = mysqli_query($link, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

                if ($query_result->num_rows > 0) {

                    echo "<table><tr><th>Name</th><th>Action</th></tr>";
                    // output data of each row
                    while($row = $query_result->fetch_assoc()) {
                        $rid = $row["role_id"];
                        $rname = $row["role_name"];
                        
                        // $url = $_SERVER['DOCUMENT_ROOT'].'/ui/role_creation_ui?rname='.$row["role_name"];
                        echo "<tr>
                                <td>".$row["role_name"]."</td>
                                <td><a href='http://localhost/template/ua/role_creation_updation_ui.php?rid=$rid&rname=$rname'><button class='btn btn-sm btn-success'>Edit</button></td>
                            </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No Data Found";
                }
                
                $link->close();

            ?><br><br>

             <?php 
                if($error){
            ?>

            <div id='alert'><div class=' alert alert-block alert-info fade in center'><?= $error ?></div></div>

            <?php
                }
            ?>  

        </div> 
    </div> 
</div> 


