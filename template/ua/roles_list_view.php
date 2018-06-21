

<?php

session_start();
if(isset($_SESSION["errormsg"])) {
    $error = $_SESSION["errormsg"]; 
    session_unset($_SESSION["errormsg"]);
} else {
    $error = "";
}

?>

<?php 
    if($error){
?>

<div class='alert alert-info' align="center"><?= $error ?></div></div>

<?php
    }
?>  
<div class="panel panel-primary">

    <div class="panel-heading">All Roles List</div>

        <div class="panel-body">  
         
            <h2>All Roles List</h2>   

            <?php

                include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

                $sql_select_query = "SELECT role_id,role_name FROM $central_administration_sfcs.rbac_roles";
                $query_result = mysqli_query($link, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

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
                
                $link->close();

            ?>

        </div> 
    </div> 
</div> 


