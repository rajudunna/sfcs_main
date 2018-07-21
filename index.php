<?php

ob_start();
session_start();
ini_set('max_execution_time', 30000);
if(!isset($_GET['r'])){
    unset($_SESSION['link']);
}
require_once("configuration/API/confr.php");
include "template/helper.php";
require_once 'sfcs_app/common/vendor/autoload.php';


$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>XAPPERL</title>
        
        <link rel="stylesheet" href="template/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="template/vendors/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="template/vendors/css/vendor.bundle.addons.css">
        <link rel="stylesheet" href="template/css/style.css">
        <link rel="stylesheet" href="assets/css/datepicker.css" />
        <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css" />
        <link rel="stylesheet" href="assets/vendors/select2/dist/css/select2.min.css" />
        <link rel="stylesheet" href="assets/css/font-awesome.min.css" />
        <!-- <link rel="stylesheet" href="assets/css/custom.min.css" /> -->
        <link rel="stylesheet" href="assets/css/style.css" />
       
        <!-- jquery data table -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
        <!--  font awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css" integrity="sha384-v2Tw72dyUXeU3y4aM2Y0tBJQkGfplr39mxZqlTBDUZAb9BGoC40+rdFCG0m10lXk" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/fontawesome.css" integrity="sha384-q3jl8XQu1OpdLgGFvNRnPdj5VIlCvgsDQTQB6owSOHWlAurxul7f+JpUOVdAiJ5P" crossorigin="anonymous">
       
    </head>

    <body>
        <div class="container-scroller">
            <?php include("template/navbar.php"); ?>
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="row">
                            <div class="col-lg-9">

                                <!-- <div class="card">
                                    <div class="card-body">
                                    </div>
                                </div> -->

                                <div ng-app="App">
                                    <div class="right_col" role="main">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12" style="min-height:640px;">

                                                <!-- <div class="col-md-12 col-sm-12 col-xs-12" style="min-height:640px" id="body">
                                                        
                                                </div> -->

                                                <?php
                                                    if(isset($_GET['r']) && $_GET['r']!=''){
                                                        if(hasviewpermission($_GET['r'])){
                                                            $get_file_path = getFILE($_GET['r']);
                                                            if($get_file_path){
                                                                if($get_file_path['type'] == 'php' || $get_file_path['type'] == 'htm' || $get_file_path['type'] == 'html'){                           
                                                                    include($_SERVER["DOCUMENT_ROOT"].$get_file_path['path']);
                                                                }
                                                                else{
                                                                    if($get_file_path['type'] == 'xlsm'){
                                                                        echo "<a class='btn btn-primary' href='".$get_file_path['path']."' target='_blank'>Click here to dowload Tool</a>";
                                                                    }else{
                                                                        echo "<a class='btn btn-primary' href='".$get_file_path['path']."' target='_blank'>Get ".$get_file_path['type']." file to click here..</a>";
                                                                    }
                                                                }
                                                            }elseif(isset($_GET['r'])){
                                                                echo "<div class='col-sm-12'>
                                                                        <div class='col-sm-6'><img src='images/error-page.png'></img></div>
                                                                        <div class='col-sm-6'>
                                                                            <br/><br/><br/>
                                                                            <h1 class='text-danger'><i class='fas fa-exclamation-triangle'></i> Error..</h1>
                                                                            <br/><br/><br/><br/>
                                                                            <h1 class='text-warning'>Page not found..</h1>
                                                                        </div>
                                                                    </div>";
                                                            }
                                                        }else{
                                                            echo "<div class='col-sm-12'>
                                                                    <div class='col-sm-4'><h1 style='font-size: 150px !important;margin: 68px 0px 0px 100px;' class='text-center text-warning'><i class='fa fa-user-times'></i></h1></div>
                                                                    <div class='col-sm-8'>
                                                                    <br/><br/><br/>
                                                                    <h1 class='text-danger text-center'><i class='fa fa-ban'></i> Restricted..</h1>
                                                                    <br/><br/><br/><br/>
                                                                    <h1 class='text-danger text-center'>unauthorized access..</h1>
                                                                    </div>
                                                            </div>";
                                                        }
                                                    }elseif($link_ui == Null){
                                                        echo "<div class='col-sm-12'>
                                                                    <br/><br/><br/>
                                                                    <h1 class='text-warning text-center'><i class='fa fa-unlink'></i> Warning..</h1>
                                                                    <br/><br/><br/><br/>
                                                                    <h1 class='text-danger text-center'>DB link fails..</h1>
                                                            </div>";
                                                    }else{
                                                        echo "<div class='col-sm-12'>
                                                                    <h1 class='text-primary text-center'>Welcome to SFCS</h1>
                                                                    <h1 class='text-center text-danger bg-info'><img src='images/favicon.ico' alt='Logo' height='40' width='40'> Brandix </h1>
                                                                    <img style='width:60%;margin:5px 240px' src='images/brandix sew.jpg'/>
                                                                    <h1 class='text-center bg-primary'><img src='images/logo-schemax.png' alt='Schemax'> 
                                                                    </h1>
                                                                    
                                                                
                                                            </div>";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-3">
                                <div class="list-group" id="list-tab" role="tablist">
                                    <a class="list-group-item d-flex justify-content-between align-items-center active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Home <span class="badge badge-info badge-pill">14</span></a>
                                    <a class="list-group-item d-flex justify-content-between align-items-center" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">Profile</a>
                                    <a class="list-group-item d-flex justify-content-between align-items-center" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab" aria-controls="messages">Messages</a>
                                    <a class="list-group-item d-flex justify-content-between align-items-center" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">Settings</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include("template/footer.php"); ?>
                </div>
            </div>
        </div>
        <script src="template/vendors/js/vendor.bundle.base.js"></script>
        <!-- <script src="vendors/js/vendor.bundle.addons.js"></script> -->
        <!-- <script src="js/off-canvas.js"></script>
            <script src="js/misc.js"></script> -->
        <!-- <script src="js/dashboard.js"></script> -->
    </body>
</html>

<style>
    .main-panel {
        width:100% !important;
    }
</style>
