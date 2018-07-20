<?php
ob_start();
session_start();
ini_set('max_execution_time', 30000);
if(!isset($_GET['r'])){
    unset($_SESSION['link']);
}
require_once("configuration/API/confr.php");
include "template/helper.php";
include "template/header.php";
include "template/sidemenu.php";
require_once 'sfcs_app/common/vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

?>

<link rel="stylesheet" href="assets/css/datepicker.css" />
<script src="assets/js/datepicker.js"></script>
<script src="template/helperjs.js"></script>
<div ng-app="App">
<div class="right_col" role="main">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12" style="min-height:640px;">
<div class="col-md-12 col-sm-12 col-xs-12" style="min-height:640px" id="body">
<!--
    Temprory Dashboard Test
-->
<!-- <div align="center"> 
    <br><br><br><br><br><br><br><br><br><br><br><br>  <b><h1><font color="black">Welcome to</font> <br><font color="red">Shop Floor Control System</font></h1></b>
</div>"; -->

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
// $('[data-toggle="datepicker"]').datepicker(
//             {
//                 format: 'yyyy-mm-dd',
//                 autoHide: true,
//             }).attr("readonly","true").css({"background-color": "#fff"});

/*$.ajaxSetup({
    beforeSend: function(jqXHR, settings) {

        // Only GET Method
       settings.url=settings.url.replace("http://","");
        settings.url = "http://localhost/"+settings.url
     

    },
    
});*/
</script>
<script>

var get_r = '<?php echo $_GET['r'] ?>';

window.onload = onloadAjaxCall(get_r);

function onloadAjaxCall(get_r){

    var url = "ajax_handler.php?r="+get_r;
    
    // $.blockUI({ css: { border: 'none', padding: '15px', backgroundColor:'#000', '-webkit-border-radius': '10px', '-moz-border-radius': '10px', opacity: .5, color: '#fff' } });
    return $.ajax ({ 
        url:url,
        type: "GET",
        success: function(response)
        {   
            window.history.pushState("object or string", "Title", "?r="+get_r);
            jQuery("#body").html(response);
            // $.unblockUI();
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


</script>





