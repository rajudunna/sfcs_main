<?php
ob_start();
session_start();
ini_set('max_execution_time', 30000);
if(!isset($_GET['r'])){
    unset($_SESSION['link']);
}
include "template/helper.php";
include "template/header.php";
include "template/sidemenu.php";

?>

<link rel="stylesheet" href="assets/css/datepicker.css" />
<script src="assets/js/datepicker.js"></script>
<script src="template/helperjs.js"></script>
<div ng-app="App">
<div class="right_col" role="main">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12" style="min-height:640px;">
<div class="col-md-12 col-sm-12 col-xs-12" style="min-height:640px">
<!--
    Temprory Dashboard Test
-->
<!-- <div align="center"> 
    <br><br><br><br><br><br><br><br><br><br><br><br>  <b><h1><font color="black">Welcome to</font> <br><font color="red">Shop Floor Control System</font></h1></b>
</div>"; -->
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

<!-- footer content -->
</div>
</div>
<!-- <footer>
    <div class="pull-right">
    Powered by SchemaX Tech
    </div>
    <div class="clearfix"></div>
</footer> -->
<!-- /footer content -->
<?php
include "template/footer.php";
?>

<script>
$('[data-toggle="datepicker"]').datepicker(
            {
                format: 'yyyy-mm-dd',
                autoHide: true,
            }).attr("readonly","true").css({"background-color": "#fff"});

/*$.ajaxSetup({
    beforeSend: function(jqXHR, settings) {

        // Only GET Method
       settings.url=settings.url.replace("http://","");
        settings.url = "http://localhost/"+settings.url
     

    },
    
});*/
</script>





