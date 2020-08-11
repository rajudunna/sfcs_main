<?php
    //==================== IPS Dashboard ========================
    /* ==========================================================
                      Created By: Chandu
    Input & output: get section details and send ajax call to server and display it in sections div
    Created at: 19-09-2018
    Updated at: 21-09-2018 
    ============================================================ */
    
    $ui_url1 ='?r='.base64_encode('/sfcs_app/app/production/controllers/sewing_job/sewing_job_scaning/scan_input_jobs.php');
    $v_r = explode('/',base64_decode($_GET['r']));
    array_pop($v_r);
    $url = "http://".$_SERVER['HTTP_HOST'].implode('/',$v_r)."/ips_dashboard.php";
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',4,'R'));
    $dashboard_name="IPS";
    $sec_result = mysqli_query($link, "SELECT DISTINCT sec_name FROM $bai_pro3.sections_master WHERE sec_name>0 order by sec_name") or exit("Sec qry".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sections = mysqli_fetch_all($sec_result,MYSQLI_ASSOC);
    echo "<script>var sec_ids = '".implode(',',array_column($sections, 'sec_name'))."';</script>";
    echo "<div class='panel panel-primary'>
            <div class='panel-heading'><h3 class='panel-title'>IPS Dashboard</h3></div>
            <div class='panel-body'>
            <div class='col-sm-12' style='padding-bottom:20px'>
            <div class='form-group'>
              <div class='col-sm-3'>";
                echo 'Sewing Job Track: <input type="text" name="sewing" id="sewing" class="form-control alpha" onkeyup="blink_new(this.value)" size="10">';
              echo "</div><div class='col-sm-3'>";
                echo 'Schedule Track: <input type="text" name="schedule" id="schedule"  class="form-control integer" onkeyup="blink_new3(this.value)" size="10"> &nbsp;&nbsp;';
              echo "</div>
              <div class='col-sm-3'>
                Shift :<select class='form-control' id='shift' name='shift' required>
                    <option value=''>Select</option>";
                    foreach($shifts_array as $shift){
                      echo "<option value='$shift'>$shift</option>";
                  }
              echo "</select></div>";
              echo '<div class="col-sm-3">Priorities:
              <select class="form-control" id="view_priority" onchange="redirect_priority()">
              <option value="4" selected>4</option>
              <option value="6">6</option>
              <option value="8">8</option>';
              echo '</select></div>';

              echo "</div>
            </div>
            <div class='col-sm-12'>";
            $inc=0;
    foreach($sections as $sec){
        echo "<div style='width:20%;float:left;padding:5px'>
            <div class='panel panel-success'>
                <div class='panel-body sec-box'>
                    <div class='loading-block' id='sec-load-".$sec['sec_name']."' style='display:block'></div>
                    <div id='sec-".$sec['sec_name']."'>

                    </div>
                </div>
            </div>
        </div>";
        $inc++;
        if($inc%5==0){
          echo "</div><div class='col-sm-12'>";
        }
    }
    echo "</div>";
    echo "<div class='col-sm-12'>";
    include "include_legends_ips.php";
    echo "</div></div></div>";
?>

<script>

function redirect_priority()
{
  call_server();
}

</script>

<script>
var sec_id_ar = sec_ids.split(',');
jQuery( document ).ready(function() {
    call_server();
});

function call_server(){
    for(var i=0;i<sec_id_ar.length;i++){
      ajax_calls(sec_id_ar[i],false);
    }
}
setInterval(function() {
  ajax_calls(sec_id_ar[0],true);
}, 120000); 


function ajax_calls(value,sync_type){
  $('#sec-load-'+value).css('display','block');
  $('#sec-'+value).html('');
  $.ajax({
      url: "<?= $url ?>?sec="+value+"&priority_limit="+$('#view_priority').val()
  }).done(function(data) {
      try{
        var r_data = JSON.parse(data) ;
        $('#sec-'+r_data.sec).html(r_data.data);
        $('#sec-load-'+r_data.sec).css('display','none');
        if(sync_type){
          var ind = sec_id_ar.indexOf(r_data.sec);
          if(sec_id_ar[ind+1]){
            ajax_calls(sec_id_ar[ind+1],true);
          }
        }
      }catch(err){
        if(sync_type){
          $('#sec-'+value).html('<b>couldn\'t fetch the data & It will automatically refresh in 2 mins</b>');
          $('#sec-load-'+value).css('display','none');
          if(sync_type){
            var ind = sec_id_ar.indexOf(value);
            if(sec_id_ar[ind+1]){
              ajax_calls(sec_id_ar[ind+1],true);
            }
          }
        }
      }
  }).fail(function(){
    if(sync_type){
      $('#sec-'+value).html('<b>Network Error.It will automatically refresh in 2 mins.</b>');
      $('#sec-load-'+value).css('display','none');
        var ind = sec_id_ar.indexOf(value);
        if(sec_id_ar[ind+1]){
          ajax_calls(sec_id_ar[ind+1],true);
        }
      }else{

      }
  });
}


function viewPopupCenter(style,schedule,module,input_job_no_random_ref,operation_code,sidemenu){
  url = '<?= $ui_url1 ?>'+'&style='+style+'&schedule='+schedule+'&module='+module+'&input_job_no_random_ref='+input_job_no_random_ref+'&operation_id='+operation_code+'&sidemenu='+sidemenu+'&shift=';
  PopupCenter(url, 'myPop1',800,600);
}
function PopupCenter(pageURL, title,w,h) {
    
    var shift= $('#shift').val();
    if(shift==''){
      swal('Please Select Shift First','','error');
      return false;
    }else{
      pageURL+=shift;
    }
 
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}

function blink_new_priority(x)
{
	var temp=x.split(",");
	
	for(i=0;i<x.length;i++)
	{
		blink_new1(temp[i]);
	}
}

function blink_new(x)
{	
	$("div[id='SJ"+x+"']").each(function() {
	
	$(this).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
	});
}

function blink_new3(x)
{
	$("div[id='S"+x+"']").each(function() {
	
	$(this).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
	});
}

function blink_new1(x)
{	
	obj="#"+x;
	
	if ( $(obj).length ) 
	{
		$(obj).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
	}
}
</script>
<script>
$(document).ready(function() {
//Select all anchor tag with rel set to tooltip
$('div[rel=tooltip]').hover(function(e) {
  
  //Grab the title attribute's value and assign it to a variable
  var tip = $(this).attr('title');  
  
  //Remove the title attribute's to avoid the native tooltip from the browser
  $(this).attr('title','');
  
  //Append the tooltip template and its value
  $(this).append('<div id="tooltip"><div class="tipHeader"></div><div class="tipBody">' + tip + '</div><div class="tipFooter"></div></div>');   
  
}).mousemove(function(e) {

  //Keep changing the X and Y axis for the tooltip, thus, the tooltip move along with the mouse
  console.log('y = '+e.pageY+' : '+e.view.parent.pageYOffset);
  console.log(e);

  //e.pageY + 0.5 * e.view.parent.pageYOffset
  $('#tooltip').css('top',$(this).offset.top-$(window).scrollTop());
  $('#tooltip').css('left',$(this).offset.left - 255 );
   $('#tooltip').css('margin-left','10px' );
   $('#tooltip').css('text-align','left' );
   $('#tooltip').css('margin-top','10px' );
   $('#tooltip').css('position', 'absolute' );
   $('#tooltip').css('z-index', '999999' );
}).mouseout(function() {

  //Put back the title attribute's value
  $(this).attr('title',$('.tipBody').html());

  //Remove the appended tooltip template
  $(this).children('div#tooltip').remove();
  
});

});
</script>
<style>
.tooltip {
    
    outline: none;
    cursor: auto; 
    text-decoration: none;
    position: relative;
    color:#333;
    
  }
  .tooltip span {
    margin-left: -1500em;
    position: absolute;
    
  }
  .tooltip:hover span {
    border-radius: 5px 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; 
    box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.1); -webkit-box-shadow: 5px 5px rgba(0, 0, 0, 0.1); -moz-box-shadow: 5px 5px rgba(0, 0, 0, 0.1);
    font-family: Calibri, Tahoma, Geneva, sans-serif;
    position: absolute; 
    left: 0em; top: 0em; z-index: 99;
    margin-left: -100px; width: 150px;
    margin-top: -100px;
    


  }
  .tooltip:hover img {
    border: 0; 
    margin: -10px 0 0 -55px;
    float: left; position: absolute;
  }
  .tooltip:hover em {
    font-family: Candara, Tahoma, Geneva, sans-serif; font-size: 1.2em; font-weight: bold;
    display: block; padding: 0.2em 0 0.6em 0;
  }
  .classic { padding: 0.8em 1em; }
  .custom { padding: 0.5em 0.8em 0.8em 2em; }
  * html a:hover { background: transparent; }
  .classic {background: #000; border: 1px solid #FFF;font-weight:bold; }
  .critical { background: #FFCCAA; border: 1px solid #FF3334; }
  .help { background: #9FDAEE; border: 1px solid #2BB0D7; }
  .info { background: #9FDAEE; border: 1px solid #2BB0D7; }
  .warning { background: #FFFFAA; border: 1px solid #FFAD33; }
  

  /* Tooltip */
.red-tooltip + .tooltip > .tooltip-inner {
background-color: black;
width:350px;
}
#tooltip {
position:absolute;
z-index:9999;
color:#fff;
font-size:12px;
width:250px;
pointer-events: none; 

}

#tooltip .tipHeader {
height:8px;
/*background:url('<?= getFullURL($_GET['r'],'common/images/tipHeader.gif',2,'R');?>') no-repeat;*/
font-size:0px;
}


#tooltip .tipBody {
background-color:#000;
padding:5px 5px 5px 15px;
}

#tooltip .tipFooter {
 height:8px;
 /*background:url('<?= getFullURL($_GET['r'],'common/images/tipFooter.gif',2,'R');?>') no-repeat;*/
}

</style>

<style>
.sec-box{
    min-height:100px;
}
.loading-block{
    border: 10px solid #f3f3f3; 
    border-top: 10px solid #156b0a; 
    border-radius: 50%;
    width: 70px;
    height: 70px;
    animation: spin 2s linear infinite;
    margin : 0 auto;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
a {text-decoration: none;}

table
{
	border-collapse:collapse;
}
.new td
{
	border: 1px solid red;
	white-space:nowrap;
	border-collapse:collapse;
}

.new th
{
	border: 1px solid red;
	white-space:nowrap;
	border-collapse:collapse;
}

.bottom th,td
{
	 border-bottom: 1px solid #000000; 
	padding-bottom: 5px;
	padding-top: 5px;
}


.fontn a { display: block; height: 20px; padding: 5px; background-color:blue; text-decoration:none; color: #000000; font-family: Arial; font-size:12px; } 

.fontn a:hover { display: block; height: 20px; padding: 5px; background-color:green; font-family: Arial; font-size:12px;}

.fontnn a { color: #000000; font-family: Arial; font-size:12px; } 

a{
	text-decoration:none;
	color: #000000;
}

.white {
  width:20px;
  height:20px;
  background-color: #ffffff;
  display:block;
  float: left;
  margin: 2px;
  border: 1px solid black;
}

.white a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.white a:hover {
  text-decoration:none;
  background-color: #ffffff;
}


.red {
  width:20px;
  height:20px;
  background-color: #ff0000;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.red a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.red a:hover {
  text-decoration:none;
  background-color: #ff0000;
}

.green {
  width:20px;
  height:20px;
  background-color: #339900;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.green a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.green a:hover {
  text-decoration:none;
  background-color: #339900;
}

.lgreen {
  width:20px;
  height:20px;
  background-color: #59ff05;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
 
 }

.lgreen a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
 
}

.lgreen a:hover {
  text-decoration:none;
  background-color: #59ff05;
  
}

.yellow {
  width:20px;
  height:20px;
  background-color: #ffff00;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.yellow a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.yellow a:hover {
  text-decoration:none;
  background-color: #ffff00;
}


.pink {
  width:20px;
  height:20px;
  background-color: pink;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.pink a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.pink a:hover {
  text-decoration:none;
  background-color: pink;
}

.orange {
  width:20px;
  height:20px;
  background-color: #eda11e;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.orange a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.orange a:hover {
  text-decoration:none;
  background-color: #eda11e;
}

.blue {
  width:20px;
  height:20px;
  background-color: #15a5f2;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.blue a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.blue a:hover {
  text-decoration:none;
  background-color: #15a5f2;
}


.yash {
  width:20px;
  height:20px;
  background-color: #999999;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.yash a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.yash a:hover {
  text-decoration:none;
  background-color: #999999;
}

.black {
  width:20px;
  height:20px;
  background-color: black;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.brown {
  width:20px;
  height:20px;
  background-color: #333333;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.black a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}
.black a:hover {
  text-decoration:none;
  background-color: black;
}

</style>



