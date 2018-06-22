
<?php 

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

?>

<div class="panel panel-primary"  ng-app="app" id="App2">

    <div class="panel-heading">Role Menu Permisssions Update</div>

        <div class="panel-body" ng-controller="userAccessController">

            <form name="form1" action="<?= getFullURL($_GET['r'],'saving_user_access_mapping_data.php','N');?>" method = "post">    

                <div class="row">

                    <div class="col-md-3">

                        <label>Role Name:</label>
                        <input type="text" class="form-control" value="" readonly/>
                    </div>

                    <div class="col-md-5">
                        
                        <label>Menu Name:</label>
                        <input type="text" id="menu_name" name="menu_name" class="form-control" readonly value=''>
                       
                    </div>

                    <div class='col-md-3'>
                        <input id="b4" type="submit" value="Update Permissions" name="submit" class="btn btn-primary" style="margin-top:22px;">
                    </div>

                    <div id="permissions">

                        <div class="panel-primary">

                            <div class="col-md-5">

                               <p> <table class='table table-bordered'> 
                                    <tr>
                                        <th><b>Permission Name</b></th>
                                        <th style="width:10px"><b>Action</b></th> 
                                    </tr>
                                        
                                    <?php

                                        $sql_select_query = "SELECT permission_id,permission_name FROM $central_administration_sfcs.rbac_permission";
                                        $query_result = mysqli_query($link, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        
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

<!-- <script src="<?= getFullURLLevel($_GET['r'],'assets/js/ua_rbac.js',2,'R') ?>"></script> -->



