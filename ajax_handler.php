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
                        if($_GET['r'] == 'L3NmY3NfYXBwL2FwcC9kYXNoYm9hcmRzL2NvbnRyb2xsZXJzL2Nwcy9mYWJfcHJpb3JpdHlfZGFzaGJvYXJkLnBocA=='){
                            echo "<h4>Instructions Here : </h4>";
                        }
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
<div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" aria-label="Close" onclick="modalClose()">
        <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body" id="modal-body">
            <p>One fine body&hellip;</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left custom-btn" onclick="modalClose()">Close</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<script type="text/javascript">

 
$('form').on("submit",function(event) {
    event.preventDefault(); 

    var form = $(this);
    var url;
    var get_url;
    var form_url;
    
    get_url = window.location.href;
    get_url = get_url.split("=").pop();
    form_url = form.attr('action');
    
    if(form_url !== undefined){
        if(form_url.trim().length > 0){
            var index = form_url.includes("ajax_handler.php");
            if(index == false){
                var url = form_url.split("?").pop();
                url = "ajax_handler.php?"+url;
            }else{
                url = form_url;
            }
            
        }else{
            url = "ajax_handler.php?r="+get_url;
        }
    }else{
        url = "ajax_handler.php?r="+get_url;
    }

    var from_data=form.serializeArray();

    if($("input[type=submit]").attr("name") !== undefined){
        from_data.push({ name: $("input[type=submit]").attr("name"), value: $("input[type=submit]").attr("value") });
    }else{
        from_data.push({ name: $("button[type=submit]").attr("name"), value: $("button[type=submit]").attr("value") });
    }


    myLoad1();
        $.ajax({
          type:'POST',
          url: url,
          cache:false,
          data: from_data
        }).done(function(resp) {
            // url = new URL(url);
            // var c = url.searchParams.get("r");
            // var c = url.split("?").pop();
            // window.history.pushState("object or string", "Title", "?"+c);
            jQuery("#modal-body").html(resp);
            $('#myModal').modal('show'); 

        }).fail(function(erespo) {
            jQuery("#modal-body").html(erespo);
            $('#myModal').modal('show'); 
        });
    myLoadStop();
});

function anchortag(event,href_url=0){
    event.preventDefault();
    var url;
    var href_url;
    var split_url;
    if(href_url == 0){
        href_url = $(this).attr("href");
    }else{
        href_url = href_url;
    }
    data_toggle = $(this).attr("data-toggle");
    myattribute = $(this).attr("myattribute");
    if(href_url !== "#" && data_toggle == undefined){
        split_url = href_url.split("?").pop();
        url = "ajax_handler.php?"+split_url;
        myLoad1();
        $.ajax({
          type:'GET',
          url: url,
          cache:false,
        }).done(function(resp) {

            function GetURLParameter(sParam)
            {
                var sPageURL = url.substring(1);
                var sURLVariables = sPageURL.split('&');
                for (var i = 0; i < sURLVariables.length; i++)
                {
                    var sParameterName = sURLVariables[i].split('=');
                    if (sParameterName[0] == sParam)
                    {
                        return sParameterName[1];
                    }
                }
            }
            var lot = GetURLParameter("lot");
            lot = decodeURIComponent(lot);

            var batch = GetURLParameter("batch");
            batch = decodeURIComponent(batch);

            var style = GetURLParameter("style");
            style = decodeURIComponent(style);
           
            if(myattribute == "body"){
                var sfcs_app = url.includes("sfcs_app");
                var menu = GetURLParameter("menu");
                if(sfcs_app == false){
                    var c = url.split("?").pop();
                    window.history.pushState("object or string", "Title", "?"+c);
                }
                if(menu == "production"){
                    $("#production_body").remove();
                    jQuery("#"+myattribute).append("<div id='production_body'>"+resp+"</div>");
                }else{
                    jQuery("#"+myattribute).html(resp);
                }
            }else{

                jQuery("#modal-body").html(resp);
               
                $('input[name="lot_no"]').val(lot);
                $('input[name="reference"]').val(batch);
                $('input[name="txtbatch"]').val(batch);
                $('input[name="lot_no_ref"]').val(lot);
                $('input[name="lot_no1"]').val(lot);
                // $('input[name="submit"]').click();
                // $('input[name="show"]').click();
                // $('input[name="submit2"]').click();
                //  document.getElementById("myBtn").click();
             
                $('#myModal').modal('show');
            }
           
            myLoadStop();

        }).fail(function(erespo) {

            if(myattribute == "body"){
                jQuery("#"+myattribute).html(erespo);
            }else{
                jQuery("#modal-body").html(erespo);
                $('#myModal').modal('show');
            }

        });
    }
}

$("#body a").unbind().bind('click',anchortag);


$('[data-toggle="datepicker"]').datepicker(
{
    format: 'yyyy-mm-dd',
    autoHide: true,
}).attr("readonly","true").css({"background-color": "#fff"});


function Ajaxify (href_url,body=0) {
    var url;
    var index = href_url.includes("index.php");
    if(index == true){
        split_url = href_url.split("?").pop();
        url = "ajax_handler.php?"+split_url;
    }else{
        url = href_url;
    }

    $.ajax({
        type:'GET',
        url: url,
        cache:false,
    }).done(function(resp) {

        function GetURLParameter(sParam)
        {
            var sPageURL = window.location.search.substring(1);
            var sURLVariables = sPageURL.split('&');
            for (var i = 0; i < sURLVariables.length; i++)
            {
                var sParameterName = sURLVariables[i].split('=');
                if (sParameterName[0] == sParam)
                {
                    return sParameterName[1];
                }
            }
        }

        if(body == "body"){
            var menu = GetURLParameter("menu");
            if(menu == "production"){
                $("#production_body").remove();
                jQuery("#"+body).append("<div id='production_body'>"+resp+"</div>");
            }else{
                jQuery("#"+body).html(resp);
            }
        }else{
            jQuery("#modal-body").html(resp);
            $('#myModal').modal('show');
        }
       
        // $.unblockUI();

    }).fail(function(erespo) {

         if(body == "body"){
            jQuery("#"+body).html(resp);
        }else{
            jQuery("#modal-body").html(resp);
            $('#myModal').modal('show');
        }

    });
   
}

var size;
var color;
var name;

function modal(size,color,name){
    size = size;
    color = color;
    name = name;
    $(".modal-title").html('<b>'+name+'</b>');
    if(size.trim().length > 0){
        $('.modal-dialog').removeClass('modal-lg');
        $('.modal-dialog').addClass('modal-'+size);
    }
    $('.modal').addClass('modal-'+color);
    $('.custom-btn').removeClass('btn-default');
    if(color.trim().length > 0){
        if(color != "default"){
            $('.custom-btn').addClass('btn-outline');
        }
    }
    $('#myModal').modal('toggle');
}


function modalClose(){
    event.preventDefault();
    swal({
      title: "Are you sure?",
      text: "You want to stop the transaction",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
            $('.modal-dialog').removeClass('modal-'+size);
            $('.modal').removeClass('modal-'+color);
            $('.custom-btn').removeClass('btn-outline');
            $('.custom-btn').addClass('btn-default');
            $('.modal-dialog').addClass('modal-lg');
            $('#myModal').modal('hide');
            $("#modal-body").html("");
            $('table').DataTable().ajax.reload(null, false);
      } else {
            // $('#myModal').modal('show');
      }
    });
}
$(".modal").on("hidden.bs.modal", function(){
    $(".modal-body").html("");
});

</script>