

<div class="panel panel-primary" style="height:150px;">

    <div class="panel-heading">Permission Creation</div>

        <div class="panel-body">  

            <h2>Permission Creation</h2> 

            <form name = "form1" action="permission_creation_ui.php" method = "post">    
                <div class = "container">    
                    <div class = "form_group">    
                        <label>Permission Name:</label>    
                        <input type = "text" name = "pname" value = "" required/> 
                        <label>Permission Desciption:</label>    
                        <input type = "text" name = "pdes" value = ""/>   
                    </div>  
                    <div class='col-md-2'>
                        <input type="submit" value="Save" name="submit" class="btn btn-primary">
                    </div>    
                </div>    
            </form>   

            <?php

                include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

                if(isset($_POST['submit']))
                {
                    $permission_name = $_POST['pname'];
                    $permission_des = $_POST['pdes'];
                   
                    $sql_select_query = "SELECT COUNT(*) as count FROM $central_administration_sfcs.rbac_permission WHERE permission_name = '$permission_name'";
                    $query_result = mysqli_query($link, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

                    $role_names = mysqli_fetch_array($query_result);
                    $unique_count = $role_names['count'];
                    
                    if($unique_count == 0){
                        $sql_insert_query = "insert into $central_administration_sfcs.rbac_permission (permission_name,permission_des,status) values ('$permission_name','$permission_des','active')";
                        $query_result = mysqli_query($link, $sql_insert_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        if ($query_result) {
                            echo "Permission created successfully";
                            header("Location:permissions_list_view.php"); 
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error; 
                        }
                    }else{
                        echo "Permission already exist";
                    }
                    
                    $link->close();
                    
                }
            ?>
        </div> 
    </div> 
</div> 

