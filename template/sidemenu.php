<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
        <a href="index.php" class="site_title"><img src="images/favicon.ico" alt="Logo" height="40" width="40">  <span>Brandix</span></a>
    </div>
    <div class="clearfix"></div>
    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
       <!-- <ul class="nav side-menu">
            <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="#level1_1">Level One</a>
                <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                    <li class="sub_menu"><a href="level2.html">Level Two</a>
                    </li>
                    <li><a href="#level2_1">Level Two</a>
                    </li>
                    <li><a href="#level2_2">Level Two</a>
                    </li>
                    </ul>
                </li>
                <li><a href="#level1_2">Level One</a>
                </li>
            </ul>
            </li>                  
        </ul>-->
        
        <ul class="nav side-menu">
		<?php
            try{
                include('dbconf.php');
                if($link_ui != Null){
                    include("functions.php");
                    echo CategoryList(8);
                }
            }catch(Exception $e){
                
            }
        ?>
        <?php 
            if(getrbac_user()['role_id']=='1'){ 
                $ma = 'User Access';
                GLOBAL $link_ui;
                $query = "SELECT * FROM tbl_menu_list WHERE parent_id=(SELECT menu_pid FROM tbl_menu_list WHERE link_description='".$ma."')";
                $res = mysqli_query($link_ui, $query);
                
        ?>
        <li><a><i class='fa fa-cog'></i>Settings <span class="fa fa-chevron-down"></span></a>
            <ul class='nav child_menu'>
                <li>
                    <a>User Access <span class="fa fa-chevron-down"></span></a>
                        <ul class='nav child_menu'>
                        <?php
                            while($mann = mysqli_fetch_array($res)){
                                if(base64_decode($_GET['r'])==$mann['link_location']){
                                    echo "<li class='current-page'>
                                        <a href='?r=".base64_encode($mann['link_location'])."'>".$mann['link_description']."</a>
                                    </li>";
                                }else{
                                    echo "<li>
                                    <a href='?r=".base64_encode($mann['link_location'])."'>".$mann['link_description']."</a>
                                    </li>";
                                }
                            }
                        ?>
                        </ul>
                </li>
            </ul>
        </li>
        <?php } ?>
        </ul>
        </div>
    </div>
    <!-- /sidebar menu -->
    </div>
</div>


<div class="top_nav">
    <div class="nav_menu">
        <nav>
        <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
            <div class="nav navbar-nav navbar-right" ng-app="brand">
                <div ng-controller="menu as menuctrl"><br/>
                    <div class='col-sm-6 ' ng-cloak>
                        <!--<div class="input-group">
                            <input type="text" class="form-control" ng-model="menuctrl.ser_box" ng-change="menuctrl.sugissions()">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                        </div>-->
                        <div class='col-sm-12' style="position: absolute;background: white;margin-top: -10px;z-index:999" ng-show='menuctrl.ss'>
                            <h4>Suggestions : {{menuctrl.ser_box}}</h4><hr/>
                            <div ng-repeat="menuctrlre in menuctrl.res121">
                                <a ng-href={{menuctrlre.link_location}}>{{menuctrlre.link_description}}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='col-sm-3 pull-right text-center'>
                    <h4 class='text-danger'><i class="fas fa-user"></i>&nbsp;<?= getrbac_user()['uname'] ?></h4>
                    <b class='text-info' data-toggle="modal" data-target="#myModalab" style="cursor: pointer;" title="Permissions List"><u data-toggle="tooltip" title="Permissions List" data-placement="bottom"><i class="fas fa-suitcase"></i>&nbsp;<?= getrbac_user()['role'] ?></u></b>
                </div>
            </div>
           <!-- <ul class="nav navbar-nav">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user"></i> Admin User
                            <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="javascript:;">Help</a></li>
                    </ul>
                </li>
            </ul>-->
        </nav>
    </div>
</div>
<?php if(!isset($_GET['r'])){ ?>
  <!-- Modal -->
  <div class="modal fade" id="myModalab" role="dialog">
<?php 
    // Get Role and Menu and Permissions Data

    $RolsMenusPermissionsMappingData = [];
    $role_name = getrbac_user()['role'];
    $sql_select_query = "SELECT group_concat(role_menu_per_id) as record_ids,role_name,rbac_role_menu_per.role_menu_id as role_menu_parent_id,menu_description,group_concat(permission_name) as permissions,group_concat(rbac_role_menu_per.permission_id) as permissions_parent_ids from rbac_roles right join rbac_role_menu on rbac_roles.role_id= rbac_role_menu.roll_id right join rbac_role_menu_per on rbac_role_menu.role_menu_id=rbac_role_menu_per.role_menu_id right join rbac_permission on rbac_role_menu_per.permission_id=rbac_permission.permission_id where rbac_roles.role_name = '$role_name'   group by role_name,menu_description";

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

    }
?>
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close"  data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Menu Permissions List</h4>
        </div>
        <div class="modal-body" style=" height: 450px; overflow-y: auto;">
            <div class="panel panel-primary App3" ng-app="brandix" ng-init="mapping_data = <?= htmlspecialchars(json_encode($RolsMenusPermissionsMappingData)) ?> "  ng-cloak>
                <div class="panel-heading" >User Role Menus And Permissions List</div>
                <div class="panel-body"  ng-controller="accessmenuctrl" ng-cloak>
                    <div class="table-responsive">
                        <table class="table table-bordered table-fixed">
                            <thead>
                                <tr>   
                                    <th class="col-sm-2">ROLE NAME</th>
                                    <th class="col-sm-3">MENU DESCRIPTION</th>
                                    <th class="col-sm-3">PERMISSION NAME</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    
                                    <td><input type="text" ng-model="search.role_name"  class="form-control"></td>
                                    <td><input type="text" ng-model="search.menu_name"  class="form-control"></td>
                                    <td><input type="text" ng-model="search.permission_names"  class="form-control"></td>
                                </tr>
                                <tr ng-repeat="data in access_mapping_data | filter: search" valign="center">
                                    <td >{{data.role_name}}</td>
                                    <td >{{data.menu_name}}</td>
                                    <td ><h2 ng-repeat="perms in data.permission_names track by $index"><span class="label label-success" >{{perms}}</span><br></h2></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
</div>
<script src="assets/js/user_access_mapping.js"></script>
<?php } ?>

