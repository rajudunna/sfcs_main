

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

$sql_select_query = "SELECT role_menu_per_id as record_id,role_name,rbac_role_menu_per.role_menu_id as role_menu_parent_id,menu_description,group_concat(permission_name) as permissions,group_concat(rbac_role_menu_per.permission_id) as permissions_parent_ids from rbac_roles right join rbac_role_menu on rbac_roles.role_id= rbac_role_menu.roll_id right join rbac_role_menu_per on rbac_role_menu.role_menu_id=rbac_role_menu_per.role_menu_id right join rbac_permission on rbac_role_menu_per.permission_id=rbac_permission.permission_id group by role_name,menu_description limit 10";
$query_result = mysqli_query($link_ui, $sql_select_query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
$i = 0;
if($query_result->num_rows > 0){

    while ($row = $query_result->fetch_assoc()) {

        $RolsMenusPermissionsMappingData[$i]['id']= $row['record_id'];
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
    <div class="panel-heading" ng-init="rbac_permissions=<?= htmlspecialchars(json_encode($rbac_permissions)) ?>">User Access Mapping Info</div>
    <div class="panel-body"  ng-controller="accessmenuctrl" ng-cloak>
        <div class="table-responsive">
            <table class="table table-bordered table-fixed">
                <thead>
                    <tr>   
                        <th class="col-sm-2">Sl.No</th> 
                        <th class="col-sm-2">Role</th>
                        <th class="col-sm-3">Menu Description</th>
                        <th class="col-sm-3">Permission</th>
                        <th class="col-sm-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td><input type="text" ng-model="search.role_name"  class="form-control"></td>
                        <td><input type="text" ng-model="search.menu_name"  class="form-control"></td>
                        <td><input type="text" ng-model="search.permission_names"  class="form-control"></td>
                        <td></td>
                    </tr>
                    <tr ng-repeat="data in access_mapping_data | filter: search" valign="center">
                        <td >{{$index+1}}</td>
                        <td >{{data.role_name}}</td>
                        <td >{{data.menu_name}}</td>
                        <td ><h2 ng-repeat="perms in data.permission_names track by $index"><span class="label label-success" >{{perms}}</span><br></h2></td>
                        <td><button class="btn btn-primary" ng-click="edit(data)" data-toggle="modal" data-target="#myModal">Edit Permissions</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Permissions</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                        <b>Role Name:</b> {{edit_mapping_data.role_name}}
                        </div>
                        <div class="col-md-6">
                        <b>Menu Description:</b> {{edit_mapping_data.menu_name}}
                        </div>
                        <!-- <div class="col-md-3">
                        </div>
                        <div class="col-md-3">
                        </div> -->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <ui-select multiple ng-model="perms" theme="bootstrap"  close-on-select="false" style="width: 300px;" title="Choose a permission">
                                <ui-select-match placeholder="Choose permissions">{{$item}}</ui-select-match>
                                <ui-select-choices repeat="rbac_perm in rbac_permission | filter:$select.search">
                                {{rbac_perm}}
                                </ui-select-choices>
                            </ui-select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script src="assets/js/user_access_mapping.js"></script>


