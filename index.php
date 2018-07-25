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
            border-top-color: #3c8dbc;
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

    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">

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
            <section class="content">
                <div class="row">
                    <div class="col-lg-9" id="body">
                    </div>
                    <div class="col-lg-3">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                              <h3 class="box-title">Workorders</h3>

                              <div class="box-tools">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                              </div>
                            </div>
                            
                            <div class="box-body no-padding">
                              <ul class="nav nav-pills nav-stacked">
                                <?php include("template/new_sidebar.php");?>
                              </ul>
                            </div>
                        <!-- /.box-body -->
                        </div>
                    </div>
                </div>
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

var get_r = '<?php echo $_GET['r'] ?>';

window.onload = onloadAjaxCall(get_r);

function onloadAjaxCall(get_r){

    var url = "ajax_handler.php?r="+get_r;
    
    myLoad1();
    return $.ajax ({ 
        url:url,
        type: "GET",
        success: function(response)
        {   
            window.history.pushState("object or string", "Title", "?r="+get_r);
            jQuery("#body").html(response);
            setTimeout(function(){ myLoadStop(); }, 700000);
            
        }
    });

}

function ajaxCall(e,get){

    e.preventDefault();
    var get_url = new URL(get);
    var r = get_url.searchParams.get("r");

    var url = "ajax_handler.php?r="+r;
    
    // $.blockUI({ css: { border: 'none', padding: '15px', backgroundColor:'#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff' } });
    return $.ajax ({ 
        url:url,
        type: "GET",
        success: function(response)
        {   
            window.history.pushState("object or string", "Title", get_url);
            jQuery("#body").html(response);
            // $.unblockUI();
        }
    });

}

$(document).ready(function () {
    $('.nav li a').click(function(e) {

        $('.nav li.active').removeClass('active');

        var $parent = $(this).parent();
        $parent.addClass('active');
        e.preventDefault();
    });
});
</script>
