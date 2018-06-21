
<?php 

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

$permissions_data = [];

?>


<div class="panel panel-primary" ng-app="app" id="App2">

    <div class="panel-heading">Role Based Access Control System</div>

        <div class="panel-body">

            <div ng-controller="userAccessController">

                <div class="row">

                    <div class="col-md-3">

                        <label>Role Name:</label>
                        <select class="form-control" name='role' id='role'>

                            <option value="">Select Role Name</option>

                            <?php

                                $sql_select_query = "SELECT role_id,role_name FROM $central_administration_sfcs.rbac_roles";
                                $query_result = mysqli_query($link, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
                                
                                if($query_result->num_rows > 0){
                                    while ($row = $query_result->fetch_assoc()) {
                                     echo '<option value="'.$row['role_id'].'">'.$row['role_name'].'</option>';
                                    }
                                } 
                            ?>

                        </select>

                    </div>

                    <div class="col-md-3">
                        
                        <label>Menu Name:</label>
                        <select class="form-control" name='menu' id='menu'>

                            <option value="">Select Menu Name</option>

                            <?php

                                $sql_select_query = "SELECT menu_pid,link_description FROM $central_administration_sfcs.tbl_menu_list";
                                $query_result = mysqli_query($link, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));

                                if($query_result->num_rows > 0){
                                    while ($row = $query_result->fetch_assoc()) {
                                        echo '<option value="'.$row['menu_pid'].'">'.$row['link_description'].'</option>';
                                    }
                                }
                            ?>

                        </select>

                    </div>

                    <?php

                        $sql_select_query = "SELECT permission_id,permission_name FROM $central_administration_sfcs.rbac_permission";
                        $query_result = mysqli_query($link, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                        if($query_result->num_rows > 0){
                            $i=0;
                            while ($row = $query_result->fetch_assoc()) {
                                $permissions_data[$i]['p_id'] = $row['permission_id'];
                                $permissions_data[$i]['p_name'] = $row['permission_name'];
                                $i++;
                            }
                        }
                       
                    ?>

                    <div class='col-md-3' ng-init="permissions_data='<?php json_encode($permissions_data); ?>'">
                        <input type="button" value="Add Menu To Role" name="submit" class="btn btn-primary" style="margin-top:22px;" onclick="OpenModal();">
                    </div>

                </div>
               
            </div>

        </div>

    </div>

</div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Select Permissions For This Menu</h4>
        </div>
        <div class="modal-body">

            <table class='table table-bordered'> 
                <tr>
                    
                    <th><b>Permission Name</b></th>
                    <th style="width:10px"><b>Action</b></th> 
                </tr>
                <?php 

                    foreach ($permissions_data as $key => $value) {
                        echo "<tr><td style='display:none'>".$value['p_id']."</td><td>".$value['p_name']."</td><td align='center'><input type='checkbox'></td></tr>";
                    }
                ?>
            </table>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
</div>

<script src="<?= getFullURLLevel($_GET['r'],'assets/js/ua_rbac.js',2,'R') ?>"></script>

<script type="text/javascript">

    var role_menu_data = [];

    function OpenModal(){

        var data = '<?= json_encode($permissions_data); ?>';

        var role_id = $("#role option:selected").val();
        var menu_id = $("#menu option:selected").val();
        var menu_name = $("#menu option:selected").text();

        role_menu_data.push({
            'role_id' : role_id,
            'menu_id' : menu_id,
            'menu_name' : menu_name,
        });

        if(role_menu_data.length > 0){

            $('#myModal').modal('toggle');
            $('#myModal').modal('show');
            
        }
    }

</script>