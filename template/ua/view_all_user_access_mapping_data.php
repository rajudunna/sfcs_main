
<?php 

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

?>


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

?>

<?php 
    if($status==1){
?>

<div class='alert alert-success' align="center"><b><?= $msg ?></b></div>

<?php
    }elseif($status==2){
?> 

<div class='alert alert-info' align="center"><b><?= $msg ?></b></div>

<?php }else{ echo "";} ?>



<?php 
// Get Role and Menu and Permissions Data

$RolsMenusPermissionsMappingData = [];
$role_name = getrbac_user()['role'];
$sql_select_query = "SELECT group_concat(role_menu_per_id) as record_ids,role_name,rbac_role_menu_per.role_menu_id as role_menu_parent_id,menu_description,group_concat(permission_name) as permissions,group_concat(rbac_role_menu_per.permission_id) as permissions_parent_ids from rbac_roles right join rbac_role_menu on rbac_roles.role_id= rbac_role_menu.roll_id right join rbac_role_menu_per on rbac_role_menu.role_menu_id=rbac_role_menu_per.role_menu_id right join rbac_permission on rbac_role_menu_per.permission_id=rbac_permission.permission_id where rbac_roles.role_name <> '$role_name'  group by role_name,menu_description";

$query_result = mysqli_query($link_ui, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
$i = 0;
if($query_result->num_rows > 0){

    while ($row = $query_result->fetch_assoc()) {

        $myString = $row['record_ids'];
        $recordIdsArray = explode(',', $myString);

        $RolsMenusPermissionsMappingData[$i]['ids']= $recordIdsArray;
        $RolsMenusPermissionsMappingData[$i]['role_name']= $row['role_name'];
        $RolsMenusPermissionsMappingData[$i]['menu_name']= $row['menu_description'];
        $RolsMenusPermissionsMappingData[$i]['role_menu_id']= $row['role_menu_parent_id'];


        $myString = $row['permissions'];
        $permissionNamesArray = explode(',', $myString);
       
        $RolsMenusPermissionsMappingData[$i]['permission_names']= $permissionNamesArray;

        $myString = $row['permissions_parent_ids'];
        $permissionIdsArray = explode(',', $myString);
       
        $RolsMenusPermissionsMappingData[$i]['permission_ids']= $permissionIdsArray;
        $i++;
    }

    // var_dump($RolsMenusPermissionsMappingData);
    // die();
}
$perm_query = "SELECT * from rbac_permission where status = 'Active'";
$query1_result = mysqli_query($link_ui, $perm_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
$i = 0;
if($query1_result->num_rows > 0){
    while ($row = $query1_result->fetch_assoc()) {
        $rbac_permissions[$i] = $row;
        $i++;
    }
}
// var_dump($rbac_permissions);
// die();
?>

<div class="panel panel-primary" ng-app="brandix" id="App3" ng-init="mapping_data = <?= htmlspecialchars(json_encode($RolsMenusPermissionsMappingData)) ?> " ng-cloak>
    <div class="panel-heading" ng-init="rbac_permissions=<?= htmlspecialchars(json_encode($rbac_permissions)) ?>">User Role Menus And Permissions List</div>
    <div class="panel-body"  ng-controller="accessmenuctrl" ng-cloak>
        <div class="table-responsive">
            <table class="table table-bordered table-fixed">
                <thead>
                    <tr>   
                        <th class="col-sm-2">ROLE NAME</th>
                        <th class="col-sm-3">MENU DESCRIPTION</th>
                        <th class="col-sm-3">PERMISSION NAME</th>
                        <th class="col-sm-2">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        
                        <td><input type="text" ng-model="search.role_name"  class="form-control"></td>
                        <td><input type="text" ng-model="search.menu_name"  class="form-control"></td>
                        <td><input type="text" ng-model="search.permission_names"  class="form-control"></td>
                        <td></td>
                    </tr>
                    <tr ng-repeat="data in access_mapping_data | filter: search" valign="center">
                        <td >{{data.role_name}}</td>
                        <td >{{data.menu_name}}</td>
                        <td ><h2 ng-repeat="perms in data.permission_names track by $index"><span class="label label-success" >{{perms}}</span><br></h2></td>
                        <td><button class="btn btn-primary" ng-click="edit(data)" data-toggle="modal" data-target="#myModal">Edit Menu Permissions</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Permissions</h4>
                    </div>
                    <div class="modal-body">
                        <form action="<?= getFullURL($_GET['r'],'update_test_page.php','N');?>" method="POST">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Role Name:</label>
                                <input type="text" class="form-control" value="{{edit_mapping_data.role_name}}" readonly/>
                            </div>
                            <div class="col-md-5">
                                <label>Menu Name:</label>
                                <input type="text" id="menu_name" name="menu_name" class="form-control" readonly value='{{edit_mapping_data.menu_name}}'>
                            </div>
                            <input type="hidden" name="role_menu_id" class="form-control" value='{{role_menu_id}}'>
                            <input type="hidden" name="ids" class="form-control" value='{{ids}}'>
                            <input type="hidden" name="permission_ids" class="form-control" value='{{permission_ids}}'>

                            <div class='col-md-3'>
                                <input id="b4" type="submit" value="Update Permissions" name="submit" class="btn btn-primary" style="margin-top:22px;" ng-click="SaveData()">
                            </div>
                        </div>
                        </form>
                        <hr>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1" style="height:350px;overflow:auto;">
                                <table class='table table-bordered'> 
                                    <tr>
                                        <th><b>Permission Name</b></th>
                                        <th style="width:10px"><input class='chkbox' type='checkbox' ng-model="Checkedall" ng-click="Checkall()"></th> 
                                    </tr> 
                                    <tr ng-repeat="rbac in rbac_permission">
                                        <td style='display:none'>{{ rbac.permission_id }}</td>
                                        <td>{{rbac.permission_name}}</td>
                                        <td>
                                        <input class='chkbox' type='checkbox' value='{{ rbac.permission_id }}' name='id[]' ng-model="rbac.isChecked">
                                        </td>
                                        
                                    </tr>     
                                </table>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/user_access_mapping.js"></script>


