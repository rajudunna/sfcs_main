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
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>XAPPERL</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php include("template/header_links.php");?>
    <style>
        .content-wrapper,
        .main-footer {
            margin-left: 0px;
        }
        
        .skin-blue .main-header .logo {
            background-color: #3c8dbc;
        }
        
        .main-header .navbar {
            margin-left: 0px;
        }
        
        .skin-blue .main-header .navbar {
            background: linear-gradient(120deg, #00e4d0, #5983e8);
        }
        
        .navbar {
            -webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .16), 0 2px 10px 0 rgba(0, 0, 0, .12);
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .16), 0 2px 10px 0 rgba(0, 0, 0, .12);
        }
        .panel {
            position: relative;
            border-radius: 3px;
            background: #ffffff;
            border-top: 3px solid #d2d6de;
            margin-bottom: 20px;
            width: 100%;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .16), 0 2px 10px 0 rgba(0, 0, 0, .12);
        }
        .panel-primary {
            border-color: #fff;
        }
        .panel.panel-primary {
            border-top-color: #00c0ef;
        }
        .panel-heading {
            border-bottom: 1px solid #f4f4f4 !important;
        }
        .panel-primary>.panel-heading {
            color: #333; 
            background-color: #fff; 
            /*border-bottom: 1px solid #f4f4f4;*/
        }
        .panel.panel-info {
            border-top-color: #00c0ef;
        }
        .panel.panel-success {
            border-top-color: #00a65a;
        }
        .panel.panel-warning {
            border-top-color: #f39c12;
        }
        body::-webkit-scrollbar {
            width: 6px;
        }
         
        body::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        }
         
        body::-webkit-scrollbar-thumb {
          background: linear-gradient(120deg, #5983e8, #00e4d0);
          /* outline: 1px solid slategrey; */
        }
        .box{
            border-radius: 6px;
        }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <!-- Loading Division -->
    <div id="overlay" style="display:none;"> 
        <!-- <br>&nbsp;&nbsp;&nbsp;<button onclick="myLoadStop()">Stop</button> -->
        <div id="load1" class="circle" style="display:none;"></div>
        <div id="load2" class="circle" style="display:none;"></div>
        <div id="load3" class="circle" style="display:none;"></div>
        <div id="load4" class="circle" style="display:none;"></div>
        <div id="load5" class="circle" style="display:none;"></div>
    </div>

    <div class="wrapper">

        <?php include("template/navbar.php");?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
           
            <section class="content-header">
            </section>
            <!-- Main content -->
            <section class="content" id="body">
                
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include("template/footer.php");?>
    </div>
    <?php  include("template/footer_scripts.php"); ?>
</body>

</html>

<script>

$(document).ajaxStart(function() { Pace.restart(); }); 

var qs = decodeURIComponent(location.search);
$('a[href="' + qs + '"]').parents('li').addClass('active');

var get_url = window.location.href;
var r = get_url.split("?").pop();
// var r = get_url.searchParams.get("r");
if(r != null){
    window.onload = onloadAjaxCall(r);
}

function onloadAjaxCall(get_r){
    var url = "ajax_handler.php?"+get_r;
    
    myLoad1();
    return $.ajax ({ 
        url:url,
        type: "GET",
        success: function(response)
        {   
            window.history.pushState("object or string", "Title", "?"+get_r);
            jQuery("#body").html(response);
            myLoadStop();
            
        }
    });

}

function ajaxCall(e,get){
    e.preventDefault();
    var get_url = new URL(get);
    var r = get_url.searchParams.get("r");

    var url = "ajax_handler.php?r="+r;
    
    myLoad1();
    return $.ajax ({ 
        url:url,
        type: "GET",
        success: function(response)
        {   
            window.history.pushState("object or string", "Title", get_url);
            jQuery("#body").html(response);
            myLoadStop();
        }
    });

}

$(document).ready(function () {
    $('.custom-nav li a').click(function(e) {

        $('.custom-nav li.active').removeClass('active');

        var $parent = $(this).parent();
        $parent.addClass('active');
        e.preventDefault();
    });

   
});
window.onbeforeunload = function (e) {
    e = e || window.event;

    // For IE and Firefox prior to version 4
    if (e) {
        e.returnValue = 'Sure?';
    }

    // For Safari
    return 'Sure?';
};
</script>
