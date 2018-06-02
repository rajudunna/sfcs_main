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
                if($link != Null){
                    include("functions.php");
                    echo CategoryList(8);
                }
            }catch(Exception $e){
                
            }
        ?>
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
                    <div class='col-sm-6 pull-right' ng-cloak>
                        <div class="input-group">
                            <input type="text" class="form-control" ng-model="menuctrl.ser_box" ng-change="menuctrl.sugissions()">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                        </div>
                        <div class='col-sm-12' style="position: absolute;background: white;margin-top: -10px;z-index:999" ng-show='menuctrl.ss'>
                            <h4>Suggestions : {{menuctrl.ser_box}}</h4><hr/>
                            <div ng-repeat="menuctrlre in menuctrl.res121">
                                <a ng-href={{menuctrlre.link_location}}>{{menuctrlre.link_description}}</a>
                            </div>
                        </div>
                    </div>
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

