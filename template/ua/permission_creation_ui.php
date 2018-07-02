

<div class="panel panel-primary">

    <div class="panel-heading">Permission Creation</div>

        <div class="panel-body">  

            <form name = "form1" action="<?= getFullURL($_GET['r'],'permission_creation_ui.php','N'); ?>" method = "post">    
                <div class = "row">    
                    <div class = "form_group col-md-3">    
                        <label>Permission Name:</label>    
                        <input type = "text" name = "pname" value = "" class="form-control" required/> 
                    </div>
                    <div class = "form_group col-md-3">   
                        <label>Permission Desciption:</label>    
                        <input type = "text" name = "pdes" value = "" class="form-control" required/>   
                    </div>  
                    <div class='col-md-2'>
                        <input type="submit" value="Save" name="submit" class="btn btn-primary" style="margin-top:22px;">
                    </div>    
                </div>    
            </form>   

            <?php

                include('../dbconf.php');

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

                if(isset($_POST['submit']))
                {
                    $permission_name = $_POST['pname'];
                    $permission_des = $_POST['pdes'];
                   
                    $sql_select_query = "SELECT COUNT(*) as count FROM rbac_permission WHERE permission_name = '$permission_name'";
                    $query_result = mysqli_query($link_ui, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

                    $role_names = mysqli_fetch_array($query_result);
                    $unique_count = $role_names['count'];
                    
                    if($unique_count == 0){
                        $sql_insert_query = "insert into rbac_permission (permission_name,permission_des,status) values ('$permission_name','$permission_des','active')";
                        $query_result = mysqli_query($link_ui, $sql_insert_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        if ($query_result) {
                            $_SESSION["msg"]='Permission created successfully';
                            $_SESSION["status"] = 1;
                            $url = getFullURL($_GET['r'],'permissions_list_view.php','N');
                            header("Location:$url"); 
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error; 
                        }
                    }else{
                        echo "<span class='label label-danger'>Permission already exist</span>";
                    }
                    
                    $link_ui->close();
                    
                }
            ?>
        </div> 
    </div> 
</div> 

