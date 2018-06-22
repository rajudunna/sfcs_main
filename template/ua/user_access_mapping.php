
<?php 

include('../dbconf.php');

?>

<div class="panel panel-primary"  ng-app="app" id="App2">

    <div class="panel-heading">Assign Menus and Permissions To Role</div>

        <div class="panel-body" ng-controller="userAccessController">

            <form name="form1" action="<?= getFullURL($_GET['r'],'saving_user_access_mapping_data.php','N');?>" method = "post">    

                <div class="row">

                    <div class="col-md-3">

                        <label>Role Name:</label>
                        <select class="form-control" name='role' id='role'>

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

                    <div class="col-md-5">
                        
                        <label>Menu Name:</label>
                        <select class="form-control" name='menu' id='menu'>

                            <option value="">Select Menu Name</option>

                            <?php

                                $sql_select_query = "SELECT menu_pid,link_description FROM tbl_menu_list where fk_group_id=8 and link_location != ''";
                                $query_result = mysqli_query($link_ui, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

                                if($query_result->num_rows > 0){
                                    while ($row = $query_result->fetch_assoc()) {
                                        echo '<option value="'.$row['menu_pid'].'">'.$row['link_description'].'</option>';
                                    }
                                }
                            ?>

                        </select>

                        <input type="hidden" id="menu_name" name="menu_name" ng-model="menu_name" value=''>
                       
                    </div>

                    <div class='col-md-3'>
                        <input id="b1" type="button" value="Add Menu To Role" name="submit" class="btn btn-success" style="margin-top:22px;" ng-click="showPermissions()">
                        <input id="b2" type="button" value="Back" name="submit" class="btn btn-success" style="margin-top:22px;display:none;" ng-click="hidePermissions()">
                        <input id="b3" type="button" value="Save" name="submit" class="btn btn-primary" style="margin-top:22px;display:none;" ng-click="save()">
                        <input id="b4" type="submit" value="Submit" name="submit" class="btn btn-primary" style="margin-top:22px;display:none;">
                    </div>
                    
                    <div style="display:none" id="permissions">

                        <div class="panel-primary">
                            <div class="col-md-6 col-md-offset-2">
                            <br>
                            <hr>

                               <p> <table class='table table-bordered'> 
                                    <tr>
                                        <th><b>Permission Name</b></th>
                                        <th style="width:10px"><b>Action</b></th> 
                                    </tr>
                                        
                                    <?php

                                        $sql_select_query = "SELECT permission_id,permission_name FROM rbac_permission";
                                        $query_result = mysqli_query($link_ui, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        
                                        if($query_result->num_rows > 0){
                                        
                                            while ($row = $query_result->fetch_assoc()) {
                                            
                                                echo "<tr><td style='display:none'>".$row['permission_id']."</td><td>".$row['permission_name']."</td><td><input class='chkbox' type='checkbox' value='".$row['permission_id']."' name='id[]'></td></tr>";
                                            }
                                        }

                                    ?>
                                </table></p>

                            </div>

                        </div>

                    </div>

                </div>
               
            </form> 

        </div>

    </div>

</div>

<script src="<?= getFullURLLevel($_GET['r'],'assets/js/ua_rbac.js',2,'R') ?>"></script>



