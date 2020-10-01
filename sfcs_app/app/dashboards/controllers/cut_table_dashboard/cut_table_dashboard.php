<?php
// $double_modules=array();
// include($_SERVER['DOCUMENT_ROOT'].'template/helper.php');
// $php_self = explode('/',$_SERVER['PHP_SELF']);
// array_pop($php_self);
// $url_r = base64_encode(implode('/',$php_self)."/cut_table_dashboard.php");
// $has_permission=haspermission($url_r); 
// $dash='CTD';
// $dashboard_name="CTDW";
?>
<script type="text/javascript">
jQuery(document).ready(function($){
   $('#schedule,#docket').keypress(function (e) {
       var regex = new RegExp("^[0-9\]+$");
       var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
       if (regex.test(str)) {
           return true;
       }
       e.preventDefault();
       return false;
   });
});


</script>
<script>
$(document).ready(function() {
//Select all anchor tag with rel set to tooltip
$('div[rel=tooltip]').mouseover(function(e) {
  
  //Grab the title attribute's value and assign it to a variable
  var tip = $(this).attr('data-title');  
  
  //Remove the title attribute's to avoid the native tooltip from the browser
  $(this).attr('data-title','');
  
  //Append the tooltip template and its value
  $(this).append('<div id="tooltip"><div class="tipHeader"></div><div class="tipBody">' + tip + '</div><div class="tipFooter"></div></div>');   
  
}).mousemove(function(e) {

  //Keep changing the X and Y axis for the tooltip, thus, the tooltip move along with the mouse
  console.log('y = '+e.pageY+' : '+e.view.parent.pageYOffset);
  console.log(e);

  //e.pageY + 0.5 * e.view.parent.pageYOffset
  $('#tooltip').css('top',$(this).offset.top-$(window).scrollTop());
  $('#tooltip').css('left',$(this).offset.left - 255 );
   $('#tooltip').css('margin-left','135px' );
   $('#tooltip').css('text-align','left' );
   $('#tooltip').css('margin-top','10px' );
   $('#tooltip').css('position', 'absolute' );
   $('#tooltip').css('z-index', '999999' );
}).mouseout(function() {

  //Put back the title attribute's value
  $(this).attr('data-title',$('.tipBody').html());

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
width:450px;
}
#tooltip {
position:absolute;
z-index:9999;
color:#fff;
font-size:12px;
width:450px;
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

<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',4,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',4,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R'));
$url = '/'.getFullURLLevel($_GET['r'],'cps/fabric_requisition_report_v2.php',1,'R'); 
?>

<?php
set_time_limit(200000);
?>

<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"> -->
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
<!-- <head> -->
<title>CTD Dashboard</title>
<link rel="stylesheet" href="../../../../common/css/bootstrap.min.css">
<?php
$hour=date("H.i");
echo '<META HTTP-EQUIV="refresh" content="120">';


?>
<script type="text/javascript" src="../../../../common/js/jquery.js"></script>
<!-- <script type='text/javascript' src='jquery-1.6.2.js'></script> -->
<!--Ticket #177328  Add the java script for Text blinking -->
<script type="text/javascript">
 <!--
spe=700;
 na=document.all.tags("blink");
 swi=1;
 bringBackBlinky();
 function bringBackBlinky() {
 if (swi == 1) {
 sho="visible";
 swi=0;
 }
 else {
 sho="hidden";
 swi=1;
 }
 for(i=0;i<na.length;i++) {
 na[i].style.visibility=sho;
 }
 setTimeout("bringBackBlinky()", spe);
 }
 -->
 </script>

<?php

// $username_list=explode('\\',$_SERVER['REMOTE_USER']);
// $username=strtolower($username_list[1]);
$special_users=array("kirang","kirang","sfsc");

?>

<script>

function redirect_view()
{
//  x=document.getElementById('view_cat').value;
  y=document.getElementById('view_div').value;
  //window.location = "fab_priority_dashboard.php?view=2&view_cat="+x+"&view_div="+y;
  window.location = "<?= getFullURL($_GET['r'],'cut_table_dashboard.php','N') ?>"+"&view=2&view_div="+y;
}

function redirect_dash()
{
  x=document.getElementById('view_cat').value;
  y=document.getElementById('view_div').value;
  z=document.getElementById('view_dash').value;
  window.location = "<?= getFullURL($_GET['r'],'cut_table_dashboard.php','N') ?>"+"&view="+z+"&view_cat="+x+"&view_div="+y;
}


</script>


<script>
function blink_new(x)
{
  
  obj="#"+x;
  
  if ( $(obj).length ) 
  {
    $(obj).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
  }
  //else
  //{
  //  alert("Your request is doesnt exist");
  //}
}

function blink_new3(x)
{
  // alert(x);

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

function blink_new_priority(x)
{
  var temp=x.split(",");
  for(i=0;i<x.length;i++)
  {
    blink_new1(temp[i]);
    document.getElementById(temp[i]).style.color='pink';
  }
  
}

</script>


<style>

/*blink css for req time exceeding */
@-webkit-keyframes blinker {
  from {opacity: 1.0;}
  to {opacity: 0.0;}
}
.blink{
  text-decoration: blink;
  -webkit-animation-name: blinker;
  -webkit-animation-duration: 0.6s;
  -webkit-animation-iteration-count:infinite;
  -webkit-animation-timing-function:ease-in-out;
  -webkit-animation-direction: alternate;
}

body
{
  background-color:#eeeeee;
  color: #000000;
  font-family: Arial;
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
   border-bottom: 1px solid white; 
  padding-bottom: 5px;
  padding-top: 5px;
}


.fontn a { display: block; height: 20px; padding: 5px; background-color:blue; text-decoration:none; color: #000000; font-family: Arial; font-size:12px; } 

.fontn a:hover { display: block; height: 20px; padding: 5px; background-color:green; font-family: Arial; font-size:12px;}

.fontnn a { color: #000000; font-family: Arial; font-size:12px; } 

</style>


<style>

.recut{
  border-left  : 15px solid pink;
  border-right : 15px solid pink;
  border-top : 1px solid black;
  border-bottom : 1px solid black;
}
.normal{
  border : 1px solid black;
}

a{
  text-decoration:none;
  color: white;
}

.white {
  max-width:150px; min-width:20px;
  height:20px;
  background-color: #ffffff;
  display:block;
  float: left;
  margin: 2px;
/* border: 1px solid #000000; */
height: 25px;
    width: 250px;
   padding: 4px;
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
  max-width:150px; min-width:20px;
  height:20px;
  background-color: #ff0000;
  display:block;
  float: left;
  margin: 2px;
/* border: 1px solid #000000; */
height: 25px;
    width: 250px;
   padding: 4px;
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
  max-width:150px; min-width:20px;
  height:20px;
  background-color: #00ff00;
  color: black;
  display:block;
  float: left;
  margin: 2px;
/* border: 1px solid #000000; */
height: 25px;
    width: 250px;
   padding: 4px;

}

.green a {
  display:block;
   color: black;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.green a:hover {
  text-decoration:none;
   color: black;
  background-color: #00ff00;
}

.lgreen {
  max-width:150px; min-width:20px;
   color: white;
  height:20px;
  background-color: #339900;
  display:block;
  float: left;
  margin: 2px;
/* border: 1px solid #000000; */
height: 25px;
    width: 250px;
    padding: 1px;
 
 }

.lgreen a {
  display:block;
   color: white;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
 
}

.lgreen a:hover {
  text-decoration:none;
   color: white;
  background-color: #339900;
  
}

.yellow {
  max-width:150px; min-width:20px;
  height:20px;
  background-color: #ffff00;
  display:block;
  float: left;
  margin: 2px;
  color:black;
/* border: 1px solid #000000; */
height: 25px;
    width: 250px;
   /*padding: 4px;*/
}

.yellow a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
  color:black;
}

.yellow a:hover {
  text-decoration:none;
  background-color: #ffff00;
  color:black;
}


.pink {
  max-width:150px; min-width:20px;
  height:20px;
  background-color: #ff00ff;
  display:block;
  float: left;
  margin: 2px;
/* border: 1px solid #000000; */
height: 25px;
    width: 250px;
   padding: 4px;
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
  background-color: #ff00ff;
}

.orange {
  max-width:150px; min-width:20px;
  height:20px;
  background-color: #991144;
  display:block;
  float: left;
  margin: 2px;
/* border: 1px solid #000000; */
  height: 25px;
    width: 250px;
    /* padding: 4px; */
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
  background-color: #991144;
}

.blue {
  max-width:150px; min-width:20px;
  height:20px;
  background-color: #15a5f2;
  display:block;
  float: left;
  margin: 2px;
/* border: 1px solid #000000; */
height: 25px;
    width: 250px;
    /* padding: 4px; */
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
  max-width:150px; min-width:20px;
  height:20px;
  background-color: #999999;
  display:block;
  float: left;
  margin: 2px;
/* border: 1px solid #000000; */
  height: 25px;
    width: 250px;
    /* padding: 4px; */
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
  max-width:150px; min-width:20px;
  height:20px;
  background-color: black;
  display:block;
  float: left;
  margin: 2px;
/* border: 1px solid #000000; */
height: 25px;
    width: 250px;
   padding: 4px;
}

.brown {
  max-width:150px; min-width:20px;
  height:20px;
  background-color: #333333;
  display:block;
  float: left;
  margin: 2px;
/* border: 1px solid #000000; */
height: 25px;
    width: 250px;
   padding: 4px;
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

<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/common/js/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<SCRIPT>
<!--
function doBlink() {
  var blink = document.all.tags("BLINK")
  for (var i=0; i<blink.length; i++)
    blink[i].style.visibility = blink[i].style.visibility == "" ? "hidden" : "" 
}

function startBlink() {
  if (document.all)
    setInterval("doBlink()",1000)
}
window.onload = startBlink;
// -->
</SCRIPT>

<!-- CLOCK -->

<script language="JavaScript" type="text/javascript">
<!-- Copyright 2003, Sandeep Gangadharan -->
<!-- For more free scripts go to http://www.sivamdesign.com/scripts/ -->
<!-- 

function sivamtime() {
  now=new Date();
  hour=now.getHours();
  min=now.getMinutes();
  sec=now.getSeconds();

if (min<=9) { min="0"+min; }
if (sec<=9) { sec="0"+sec; }
if (hour>12) { add="pm"; /*hour=hour-12;*/  }
else { hour=hour; add="am"; }
if (hour==12) { add="pm"; }

time = ((hour<=9) ? "0"+hour : hour) + ":" + min + ":" + sec + " " + add;

if (document.getElementById) { /*document.getElementById('theTime').innerHTML = time;*/ }
else if (document.layers) {
 document.layers.theTime.document.write(time);
 document.layers.theTime.document.close(); }

setTimeout("sivamtime()", 1000);
}
window.onload = sivamtime;

// -->

</script>
<!-- </head> -->

<!-- <body style="overflow-x:scroll;"> -->

<script language="JavaScript">
<!--

//Disable right mouse click Script
//By Maximus (maximus@nsimail.com) w/ mods by DynamicDrive
//For full source code, visit http://www.dynamicdrive.com

//var message="Function Disabled!";

///////////////////////////////////
// function clickIE4(){
// if (event.button==2){
// sweetAlert("Info!", message, "warning");
// return false;
// }
// }

// function clickNS4(e){
// if (document.layers||document.getElementById&&!document.all){
// if (e.which==2||e.which==3){
// sweetAlert("Info!", message, "warning");
// return false;
// }
// }
// }

// if (document.layers){
// document.captureEvents(Event.MOUSEDOWN);
// document.onmousedown=clickNS4;
// }
// else if (document.all&&!document.getElementById){
// document.onmousedown=clickIE4;
// }

// document.oncontextmenu=new Function("sweetAlert('Info!', message, 'warning');return false")

// --> 
</script>

<?php
$plant_code = $_SESSION['plantCode'];
$username = $_SESSION['userName'];
echo "<div style='width=100%;'>";
//NEW to correct

if($_GET['view']==1)
{
  echo "<font color=yellow> - Quick View</font>";
}
if($_GET['view']==3)
{
  echo "<font color=yellow> - Cut View</font>";
}
echo "</font>";

echo '<div class="panel panel-primary">';

echo "<div class='panel-heading'><span style='float'><strong><a href=".$url."  target='_blank'>Cut Table Dashboard (Warehouse)</a></strong></a>
</span><span style='float: right; margin-top: 0px'><b>
<a href='javascript:void(0)' onclick='Popup=window.open('cps.htm"."','Popup',
'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); 
if (window.focus) {Popup.focus()} return false;'></a></b></span></div>";

echo '<div class="panel-body">
    <div class="form-inline">
      <div class="form-group">';
        echo 'Docket Track: <input type="text" name="docket" id="docket" class="form-control" onkeyup="blink_new(this.value)" size="10">&nbsp;&nbsp;&nbsp;';
      echo "</div>";
      echo'<div class="form-group">';
        echo 'Schedule Track: <input type="text" name="schedule" id="schedule" class="form-control" onkeyup="blink_new3(this.value)" size="10">';
      echo "</div>";

// echo'<div class="form-group">';
// echo '&nbsp;&nbsp;&nbsp;Buyer Division: 
// <select name="view_div" id="view_div" class="form-control" onchange="redirect_view()">';
// if($_GET['view_div']=="ALL") { 
//   echo '<option value="ALL" selected>All</option>'; 
// } else { 
//   echo '<option value="ALL">All</option>'; }
// echo "</div>";
// echo "</div>";
// $sqly="SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $pps.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code";
// //echo $sqly."<br>";

// mysqli_query($link, $sqly) or exit("Sql Error324".mysqli_error($GLOBALS["___mysqli_ston"]));
// $sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error7658".mysqli_error($GLOBALS["___mysqli_ston"]));
// while($sql_rowy=mysqli_fetch_array($sql_resulty))
// {
//   $buyer_div=$sql_rowy['buyer_div'];
//   $buyer_name=$sql_rowy['buyer_name'];

//   if(urldecode($_GET["view_div"])=="$buyer_name") 
//   {
//     echo "<option value='".$buyer_name."' selected>".$buyer_div."</option>";  
//   } 
//   else 
//   {
//     echo "<option value='".$buyer_name."' >".$buyer_div."</option>"; 
//   }
// }
// echo '</select>';
// echo '</div>';

echo '<br><br>';
//For blinking priorties as per the section module wips
$bindex=0;
$blink_docs=array();
$department= DepartmentTypeEnum::CUTTING;
    /**Qry to get departmen wise id's */
    $Qry_department="SELECT `department_id` FROM $pms.`departments` WHERE department_type='$department' AND plant_code='$plant_code' AND is_active=1";
    $Qry_department_result=mysqli_query($link_new, $Qry_department) or exit("Sql Error at department ids".mysqli_error($GLOBALS["___mysqli_ston"]));
    $Qry_department_result_num=mysqli_num_rows($Qry_department_result);
    if($Qry_department_result_num>0){
        while($department_row=mysqli_fetch_array($Qry_department_result))
        {
            $department_id[]=$department_row['department_id'];
        }
    }
    $departments = implode("','", $department_id);
    /**Getting work station type against department*/
    $qry_workstation_type="SELECT workstation_type_id FROM $pms.workstation_type WHERE department_id IN ('$departments') AND plant_code='$plant_code' AND is_active=1";
    $workstation_type_result=mysqli_query($link_new, $qry_workstation_type) or exit("Sql Error at workstation type".mysqli_error($GLOBALS["___mysqli_ston"]));
    $workstationtype=array();
    $workstation_typet_num=mysqli_num_rows($workstation_type_result);
    if($workstation_typet_num>0){
        while($workstaton_type_row=mysqli_fetch_array($workstation_type_result))
        {
            $workstationtype[]=$workstaton_type_row['workstation_type_id'];
        }
    }
    $workstations = implode("','", $workstationtype);

$sqlx="select workstation_id,workstation_description from $pms.workstation where plant_code='$plant_code' and workstation_type_id in ('$workstations')";
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_resultx) > 0){
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
     $section_mods=$sql_rowx['workstation_id'];
    $emb_tbl_name=$sql_rowx['workstation_description'];
  if($_GET["view_div"]!='ALL' && $_GET["view_div"]!='')
  {
    //echo "Buyer=".urldecode($_GET["view_div"])."<br>";
    $buyer_division=urldecode($_GET["view_div"]);
    //echo '"'.str_replace(",",'","',$buyer_division).'"'."<br>";
    $buyer_division_ref='"'.str_replace(",",'","',$buyer_division).'"';
    $order_div_ref=" and buyer_div in (".$buyer_division_ref.")";
  }
  else {
     $order_div_ref='';
  }

  // Ticket #976613 change the buyer division display based on the pink,logo,IU as per plan_modules
 $sql1d="SELECT workstation_id as modx from $pms.workstation where workstation_id in ('$section_mods') and plant_code='$plant_code' 
";
  $sql_num_checkd=0;
  $sql_result1d=mysqli_query($link, $sql1d) or exit("Sql Errordd".mysqli_error($GLOBALS["___mysqli_ston"]));
  $sql_num_checkd=mysqli_num_rows($sql_result1d);
  if($sql_num_checkd > 0)
  {   
    $mods=array();
    while($sql_row1d=mysqli_fetch_array($sql_result1d))
    {
      $mods[]=$sql_row1d["modx"];
    }

  echo '<div style="background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin: 10px; padding: 10px;">';
  echo "<p>";
  echo "<table>";
  // $url=getFullURLLevel($_GET['r'],'board_update.php',0,'R');
    echo "<tr><th colspan=2'><center><h2><b>$emb_tbl_name</b></h2></center></th></tr>";
 
  //$mods=array();
  //$mods=explode(",",$section_mods);
  
  //For Section level blinking
  $blink_minimum=0;
  

  //for($x=0;$x<sizeof($mods);$x++)
  // {
    $module=$mods[$x];
    $blink_check=0;
    
    echo "<tr class='bottom'><td>";
    //To disable issuing fabric to cutting tables
    //All yellow colored jobs will be treated as Fabric Wip
    $cut_wip_control=3000;
    $fab_wip=0;
    $pop_restriction=0;
    
    //$sql1="SELECT * from cut_tbl_dash_doc_summ where module=$module order by priority limit 4"; New to correct
    //Filter view to avoid Cut Completed and Fabric Issued Modules
    unset($doc_no_ref);
    unset($req_time);
    unset($lay_time);
    unset($req_date_time);
    $doc_no_ref=array();
    $req_time=array();
    $lay_time=array();
    $req_date_time=array();
    $doc_no_ref[]=0;
    $req_time[]=0;
    $req_date_time[]=0;
   
//     $sql2="select doc_no from $bai_pro3.cutting_table_plan where cutting_tbl_id in (".$section_mods.") AND doc_no IN (SELECT doc_no FROM $bai_pro3.`plandoc_stat_log` WHERE act_cut_status <> 'DONE') group by doc_no order by log_time,cutting_tbl_id";
//     $result2=mysqli_query($link, $sql2) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
//     while($row2=mysqli_fetch_array($result2))
//     {
//       $doc_no_ref[]=$row2['doc_no'];
//       $doc_no=$row2['doc_no'];
//       //$req_time[]=date("M-d H:i",strtotime($row2['log_time']));
//       // $lay_time[]=$row2['log_time'];   
//   }

   
  // start style wise display by dharani 10-26-2013 
  //$sql1="SELECT * from $bai_pro3.cut_tbl_dash_doc_summ where doc_no in (select doc_ref from $bai_pro3.fabric_priorities where doc_ref in (".implode(",",$doc_no_ref).")) and act_cut_status<>'DONE' and fabric_status_new !='5' order by field(doc_no,".implode(",",$doc_no_ref).")";
  // $sql1="SELECT c.print_status,c.plan_lot_ref,c.bundle_location,c.fabric_status_new,c.doc_no,
  // c.cutting_tbl_id,c.priority,c.act_cut_status,c.rm_date,c.cut_inp_temp,c.order_tid,c.fabric_status,
  // c.color_code,c.clubbing,c.order_style_no,c.order_div,c.order_col_des,c.acutno,c.ft_status,c.st_status,c.pt_status,
  // c.trim_status,c.act_movement_status,c.order_del_no,c.log_time,c.emb_stat,c.cat_ref,f.doc_ref,f.req_time,c.remarks FROM bai_pro3.cut_tbl_dash_doc_summ c  LEFT JOIN bai_pro3.fabric_priorities f ON f.doc_ref=c.doc_no WHERE f.doc_ref IN (".implode(",",$doc_no_ref).") and c.act_cut_status<>'DONE' AND c.fabric_status_new !='5' order by f.req_time asc";
//   $sql1="SELECT c.print_status,c.plan_lot_ref,c.pcutdocid as bundle_location,c.fabric_status as fabric_status_new,c.doc_no, ctp.cutting_tbl_id,ctp.priority,c.act_cut_status,c.rm_date,c.cut_inp_temp,c.order_tid, bodc.color_code,csl.clubbing,bodc.order_style_no,bodc.order_div,bodc.order_col_des,c.acutno,bodc.ft_status,bodc.st_status,bodc.pt_status, bodc.trim_status,c.act_movement_status,bodc.order_del_no,ctp.log_time,c.cat_ref,f.doc_ref,f.req_time,c.remarks,(IF(((bodc.`order_embl_a` + bodc.`order_embl_b`) > 0),1,0) + IF(((bodc.`order_embl_e` + bodc.`order_embl_f`) > 0),2,0)) AS `emb_stat1` FROM bai_pro3.bai_orders_db_confirm AS bodc,bai_pro3.cat_stat_log AS csl,`bai_pro3`.`cutting_table_plan` ctp,bai_pro3.plandoc_stat_log AS c LEFT JOIN bai_pro3.fabric_priorities f ON f.doc_ref=c.doc_no WHERE f.doc_ref IN (".implode(",",$doc_no_ref).") AND ctp.`doc_no` = c.`doc_no` AND bodc.`order_tid` = c.`order_tid` AND csl.`tid` = c.`cat_ref` AND c.act_cut_status<>'DONE' AND c.fabric_status !='5' AND ctp.short_shipment_status=0 ORDER BY f.req_time ASC";
  
      //echo $_GET["view_div"];
    //   if($_GET["view_div"] == 'M')
    //   {
    //     $_GET["view_div"] = "M&S";
    //   }
    //   $leter = str_split($_GET["view_div"]);
    
    //    if($_GET["view_div"]=="ALL" or $_GET["view_div"]=="")
    //   {
       // $sql1="SELECT * from $bai_pro3.cut_tbl_dash_doc_summ where doc_no in (select doc_ref from $bai_pro3.fabric_priorities where doc_ref in (".implode(",",$doc_no_ref).")) and act_cut_status<>'DONE' and fabric_status_new !='5' order by field(doc_no,".implode(",",$doc_no_ref).")";
       // $sql1="SELECT c.print_status,c.plan_lot_ref,c.bundle_location,c.fabric_status_new,c.doc_no,
       // c.cutting_tbl_id,c.priority,c.act_cut_status,c.rm_date,c.cut_inp_temp,c.order_tid,c.fabric_status,
       // c.color_code,c.clubbing,c.order_style_no,c.order_div,c.order_col_des,c.acutno,c.ft_status,c.st_status,c.pt_status,
       // c.trim_status,c.act_movement_status,c.order_del_no,c.log_time,c.emb_stat,c.cat_ref,f.doc_ref,f.req_time,c.remarks FROM bai_pro3.cut_tbl_dash_doc_summ c  LEFT JOIN bai_pro3.fabric_priorities f ON f.doc_ref=c.doc_no WHERE f.doc_ref IN (".implode(",",$doc_no_ref).") and c.act_cut_status<>'DONE' AND c.fabric_status_new !='5' order by f.req_time asc";
    //     $sql1="SELECT c.print_status,c.plan_lot_ref,c.pcutdocid as bundle_location,c.fabric_status as fabric_status_new,c.doc_no, ctp.cutting_tbl_id,ctp.priority,c.act_cut_status,c.rm_date,c.cut_inp_temp,c.order_tid, bodc.color_code,csl.clubbing,bodc.order_style_no,bodc.order_div,bodc.order_col_des,c.acutno,bodc.ft_status,bodc.st_status,bodc.pt_status, bodc.trim_status,c.act_movement_status,bodc.order_del_no,ctp.log_time,c.cat_ref,f.doc_ref,f.req_time,c.remarks,(IF(((bodc.`order_embl_a` + bodc.`order_embl_b`) > 0),1,0) + IF(((bodc.`order_embl_e` + bodc.`order_embl_f`) > 0),2,0)) AS `emb_stat1` FROM bai_pro3.bai_orders_db_confirm AS bodc,bai_pro3.cat_stat_log AS csl,`bai_pro3`.`cutting_table_plan` ctp,bai_pro3.plandoc_stat_log AS c LEFT JOIN bai_pro3.fabric_priorities f ON f.doc_ref=c.doc_no WHERE f.doc_ref IN (".implode(",",$doc_no_ref).") AND ctp.`doc_no` = c.`doc_no` AND bodc.`order_tid` = c.`order_tid` AND csl.`tid` = c.`cat_ref` AND c.act_cut_status<>'DONE' AND c.fabric_status !='5' AND ctp.short_shipment_status=0 ORDER BY f.req_time ASC";
    //   }
    //   else
    //   {
    //     $dashe = $_GET["view_div"];
    //     $sql_qry = "select * from $bai_pro2.buyer_codes where buyer_name =".'"'.$dashe.'"';
        
    //     $res = mysqli_query($link, $sql_qry);
    //     $sql_count_check = mysqli_num_rows($res);
        
    //     while($row_res = mysqli_fetch_array($res))
    //     {
    //       $buyer_identity = $row_res['buyer_name'];
    //     }
          
       // $sql1="SELECT * from $bai_pro3.cut_tbl_dash_doc_summ where order_style_no  in (select order_style_no from $bai_pro3.bai_orders_db_confirm where order_div = ".'"'.$buyer_identity.'"'.") and doc_no in (select doc_ref from $bai_pro3.fabric_priorities where doc_ref in (".implode(",",$doc_no_ref).")) and act_cut_status<>'DONE' and fabric_status_new !='5' order by field(doc_no,".implode(",",$doc_no_ref).")"; 

       // $sql1="SELECT c.print_status,c.plan_lot_ref,c.bundle_location,c.fabric_status_new,c.doc_no,
       // c.cutting_tbl_id,c.priority,c.act_cut_status,c.rm_date,c.cut_inp_temp,c.order_tid,c.fabric_status,
       // c.color_code,c.clubbing,c.order_style_no,c.order_div,c.order_col_des,c.acutno,c.ft_status,c.st_status,c.pt_status,
       // c.trim_status,c.act_movement_status,c.order_del_no,c.log_time,c.emb_stat,c.cat_ref,b.order_style_no,b.order_div,f.doc_ref,f.req_time,c.remarks FROM bai_pro3.cut_tbl_dash_doc_summ c LEFT JOIN bai_pro3.bai_orders_db_confirm b ON b.order_style_no
       // =c.order_style_no LEFT JOIN bai_pro3.fabric_priorities f ON f.doc_ref=c.doc_no WHERE f.doc_ref IN(".implode(",",$doc_no_ref).") and b.order_div=".'"'.$buyer_identity.'"'." AND c.act_cut_status<>'DONE' AND c.fabric_status_new !='5' order by f.req_time asc";

    //      $sql1="SELECT c.print_status,c.plan_lot_ref,c.pcutdocid as bundle_location,c.fabric_status as fabric_status_new,c.doc_no, ctp.cutting_tbl_id,ctp.priority,c.act_cut_status,c.rm_date,c.cut_inp_temp,c.order_tid, bodc.color_code,csl.clubbing,bodc.order_style_no,bodc.order_div,bodc.order_col_des,c.acutno,bodc.ft_status,bodc.st_status,bodc.pt_status, bodc.trim_status,c.act_movement_status,bodc.order_del_no,ctp.log_time,c.cat_ref,f.doc_ref,f.req_time,c.remarks,(IF(((bodc.`order_embl_a` + bodc.`order_embl_b`) > 0),1,0) + IF(((bodc.`order_embl_e` + bodc.`order_embl_f`) > 0),2,0)) AS `emb_stat1` FROM bai_pro3.bai_orders_db_confirm AS bodc,bai_pro3.cat_stat_log AS csl,`bai_pro3`.`cutting_table_plan` ctp,bai_pro3.plandoc_stat_log AS c LEFT JOIN bai_pro3.fabric_priorities f ON f.doc_ref=c.doc_no WHERE f.doc_ref IN (".implode(",",$doc_no_ref).") AND ctp.`doc_no` = c.`doc_no` AND bodc.`order_tid` = c.`order_tid` AND csl.`tid` = c.`cat_ref`  AND bodc.order_div=".'"'.$buyer_identity.'"'."AND c.act_cut_status<>'DONE' AND c.fabric_status !='5' AND ctp.short_shipment_status=0 ORDER BY f.req_time ASC";
        
    //   }

      // echo $sql1;
  // close style wise display 
    //NEw check
    $requested_dockets="select * from $pps.fabric_prorities where work_station_id='$section_mods' and plant_code='$plant_code' and (issued_time='0000-00-00 00:00:00' or issued_time is null)";
    $sql_result1=mysqli_query($link, $requested_dockets) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    // echo $sql1."<br>";
    $sql_num_check=mysqli_num_rows($sql_result1);
    if($sql_num_check>0){
    while($sql_row1=mysqli_fetch_array($sql_result1))
    {
    //   $cut_new=$sql_row1['act_cut_status'];
    //   $cut_input_new=$sql_row1['act_cut_issue_status'];
    //   $docket_remarks=$sql_row1['remarks'];
    //   $rm_new=strtolower(chop($sql_row1['rm_date']));
    //   $rm_update_new=strtolower(chop($sql_row1['rm_date']));
    //   $input_temp=strtolower(chop($sql_row1['cut_inp_temp']));
    
      $doc_no=$sql_row1['jm_docket_line_id'];
      if($doc_no!=" " && $plant_code!=' '){
        //this is function to get style,color,and cutjob
        $result_jmdockets=getDocketInformation($doc_no,$plant_code);
        $style =$result_jmdockets['style'];
        $fg_color =$result_jmdockets['fg_color'];
      }
      $req_time=date("M-d h:ia",strtotime($sql_row1['req_time']));
          $req_date_time=$sql_row1['req_time'];
          $log_time=$sql_row1['log_time'];
          $lay_time=$sql_row1['req_time'];
          $get_order_joins="select plan_lot_ref,fabric_status,print_status from $pps.requested_dockets where jm_docket_line_id=\"$doc_no\" and plant_code='$plant_code'";
          $sql_result=mysqli_query($link, $get_order_joins) or exit("Sql Error27".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($sql_row1236=mysqli_fetch_array($sql_result))
        {
            $plan_lot_ref_v1 = $sql_row1236['plan_lot_ref'];
            $fabric_status=$sql_row1236['fabric_status'];
            $print_status=$sql_row1236['print_status'];
            
        }
      //$fabric_status=$sql_row1['fabric_status'];
    //   $plan_lot_ref_v1=$sql_row1['plan_lot_ref'];
      
     //NEW due to plan dashboard clearing regularly and to stop issuing issued fabric.
    //   if($fabric_status==null or $fabric_status==0){
        
    //     // $fabric_status=$sql_row1['ft_status'];
    //     // $ft_status=$sql_row1['ft_status'];

    //     // if($ft_status==5)
    //     // {
    //     //   $fabric_status=4;
    //     // }
        
    //   }
      
     
      $doc_no_ref[]=$sql_row1['jm_docket_line_id'];
    //   $bundle_location="";
    //   if(sizeof(explode("$",$sql_row1['bundle_location']))>1)
    //   {
    //     $bundle_location=end(explode("$",$sql_row1['bundle_location']));
    //   }
      $fabric_location="";
      if(sizeof(explode("$",$sql_row1['plan_lot_ref']))>1)
      {
        $fabric_location=end(explode("$",$sql_row1['plan_lot_ref']));
      }
      
      
    //   $style=$sql_row1['order_style_no'];
    //   $schedule=$sql_row1['order_del_no'];
    //   $color=$sql_row1['order_col_des'];
      // $total_qty=$sql_row1['total'];
      
      if($doc_no!=" " && $plant_code!=' '){
        //this is function to get style,color,and cutjob
        $result_jmdockets=getJmDockets($doc_no,$plant_code);
        $jm_cut_job_id =$result_jmdockets['jm_cut_job_id'];
      }
      

    //   $get_order_joins="select order_joins from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
    //     $sql_result=mysqli_query($link, $get_order_joins) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
    //   while($sql_row1236=mysqli_fetch_array($sql_result))
    //   {
    //       $ord_joins = $sql_row1236['order_joins'];
    //   }

    //   $original_details = array();
    //   if($ord_joins<>'0')
    //   {
    //       if(strlen($schedule)<8)
    //       {
    //           // color clubbing
    //           $orders_join='J'.substr($color,-1);
              
    //           $select_sql="select trim(order_col_des) as order_col_des from $bai_pro3.bai_orders_db_confirm where order_joins='".$orders_join."'";
    //           //echo $select_sql."<br>";
    //           $result=mysqli_query($link, $select_sql);
    //           while($rows=mysqli_fetch_array($result))
    //           {
    //               $original_details[]=$rows['order_col_des'];
    //           }
    //       }
    //       else
    //       {
    //           // schedule clubbing
    //           $select_sql="select order_del_no from $bai_pro3.bai_orders_db_confirm where order_joins='J".$schedule."'";
    //           //echo $select_sql."<br>";
    //           $result=mysqli_query($link, $select_sql);
    //           while($rows=mysqli_fetch_array($result))
    //           {
    //               $original_details[]=$rows['order_del_no'];
    //           }
    //       }   
    //   }

    //   if (count($original_details) > 0) {
    //       $tool_tip = str_pad("Original Details:".trim(implode(",",$original_details)),80)."\n";
    //   } else {
    //       $tool_tip = '';
    //   }

      //Exception for M&S WIP - 7000
      
      if(substr($style,0,1)=="M")
      {
        $cut_wip_control=7000;
      }
    //    $sql10="select doc_ref,req_time from $bai_pro3.fabric_priorities where doc_ref ='$doc_no'";
		// $result21=mysqli_query($link, $sql10) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		 
		// while($row21=mysqli_fetch_array($result21))
		// {
		//   $req_time=date("M-d h:ia",strtotime($row21['req_time']));
		//   $req_date_time=$row21['req_time'];
		  
		// }
      
      
      // $sql11="select sum(ims_pro_qty) as 'bac_qty', sum(emb) as 'emb_sum' from (SELECT ims_pro_qty, if(ims_status='EPR' or ims_status='EPS',1,0) as 'emb' FROM $bai_pro3.ims_log where $bai_pro3.ims_log.ims_doc_no=$doc_no UNION ALL SELECT ims_pro_qty, if(ims_status='EPR' or ims_status='EPS',1,0) as 'emb' FROM $bai_pro3.ims_log_backup WHERE $bai_pro3.ims_log_backup.ims_mod_no<>0 and $bai_pro3.ims_log_backup.ims_doc_no=$doc_no) as t";
      // mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
      
      // $sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
      // $input_count=mysqli_num_rows($sql_result11);
      // while($sql_row11=mysqli_fetch_array($sql_result11))
      // {
      //   $output=$sql_row11['bac_qty'];
      //   $emb_sum=$sql_row11['emb_sum'];
      //   if($emb_sum==NULL)
      //   {
      //     $input_count=0;
      //   }
      // } 
      
    //   if($cut_new=="DONE"){ $cut_new="T";} else { $cut_new="F"; }
    //   if($rm_update_new==""){ $rm_update_new="F"; } else { $rm_update_new="T"; }
    //   if($rm_new=="0000-00-00 00:00:00" or $rm_new=="") { $rm_new="F"; } else { $rm_new="T";  }
    //   if($input_temp==1) { $input_temp="T"; } else { $input_temp="F"; }
    //   if($cut_input_new=="DONE") { $cut_input_new="T";  } else { $cut_input_new="F"; }
      
    //   $check_string=$cut_new.$rm_update_new.$rm_new.$input_temp.$cut_input_new;
    //   $rem="Nil";
      
    //   $sql112="select co_no from $bai_pro3.bai_orders_db_confirm where order_del_no='$schedule' and order_col_des='$color'";
    //   //echo $sql112;
    //   $sql_result112=mysqli_query($link, $sql112) or exit("Sql Error1".$sql112."".mysqli_error($GLOBALS["___mysqli_ston"]));
    //   while($sql_row112=mysqli_fetch_array($sql_result112))
    //   {
    //     $co_no=$sql_row112['co_no'];
    //   }
      
      //New change to restrict only M&S 2013-06-18 12:25 PM Kiran
      //NEW FSP
    //   if($fabric_status!=5 and substr($style,0,1)=='M')
    //   {
    //     //$fabric_status=$sql_row1['ft_status'];
    //     //To get the status of join orders
    //     $sql11="select ft_status from $bai_pro3.bai_orders_db_confirm where order_del_no='$schedule' and $order_joins_in_2";
    //     $sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        
    //     if(mysqli_num_rows($sql_result11)>0)
    //     {
    //       $sql11="select ft_status from $bai_pro3.bai_orders_db_confirm where order_joins='J$schedule'";
    //       $sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    //       while($sql_row11=mysqli_fetch_array($sql_result11))
    //       {
    //         $join_ft_status=$sql_row11['ft_status'];
    //         if($sql_row11['ft_status']==0 or $sql_row11['ft_status']>1)
    //         {
    //           break;
    //         }
    //       }
          
    //       // $fabric_status=$join_ft_status;
    //       $ft_status=$join_ft_status;

    //     }
    //     //To get the status of join orders
    //   }
      //NEW FSP
      switch ($fabric_status)
      {
        case "1":
        {
            $id="green";
            /* if($fab_wip>$cut_wip_control)
            {
              $id="lgreen";
              $pop_restriction=1;
            } */
          $rem="Available";
          break;
        }
        case "0":
        {
          $id="red";
          $rem="Not Available";
          break;
        }
        case "2":
        {
          $id="red";
          $rem="In House Issue";
          break;
        }
        case "3":
        {
          $id="red";
          $rem="GRN issue";
          break;
        }
        case "4":
        {
          $id="red";
          $rem="Put Away Issue";
          break;
        }   
        case "5":
        {
          $id="yellow";
          break;
        }       
        default:
        {
          $id="yash";
          $rem="Not Update";
          break;
        }
      }
      if($fabric_status==1)
      {
            $id="yellow";
      }
     
      if($fabric_status!=1 && $fabric_status!=5)
      {
        $id="green";

      }
      if($id!='yellow')
      {
          if(strlen($plan_lot_ref_v1)>0)
          {
            $id="lgreen";
          }
      }
      $printed="";
      if(strtotime($print_status)>0)
      {
        //$id="lgreen";
        $printed="Allocated";
      }

      
    //   if($cut_new=="T")
    //   {
    //     $id="blue";
    //   }
      
      
      //Filter view to avoid Cut Completed and Fabric Issued Modules
      if($_GET['view']==1)
      {
        if($fabric_status==5)
        {
          continue;
          
        }
        else
        {
          $view_count++;
        }
        if($view_count==5)
        {
          break;
        }
      }
    

      

      //For Color Clubbing
     
      
      $fabric_required=0;
      $cat_yy=0;
      if($doc_no!='' && $plant_code!=''){
		$result_docketinfo=getDocketInformation($doc_no,$plant_code);
		$style =$result_docketinfo['style'];
		$colorx =$result_docketinfo['fg_color'];
		$cut_no =$result_docketinfo['cut_no'];
		$cat_refnce =$result_docketinfo['category'];
		$cat_compo =$result_docketinfo['rm_sku'];
		$fabric_required =$result_docketinfo['docket_quantity'];
		$length =$result_docketinfo['length'];
		$shrinkage =$result_docketinfo['shrinkage'];
    $width =$result_docketinfo['width'];
    $docket_number =$result_docketinfo['docket_line_number'];
    $po_number =$result_docketinfo['sub_po'];
    
		
  }
  if($po_number!='' && $plant_code!=''){
		$result_scheduleinfo= getMpMoQty($po_number,$plant_code);
		$schedule =$result_scheduleinfo['schedule'];
		
  }
  
      $sql11="select customer_order_no from $oms.oms_mo_details where schedule in ('".implode("','",$schedule)."') and plant_code='$plant_code' group by customer_order_no";
      //echo $sql11."<br>";
      $sql_result111=mysqli_query($link, $sql11) or exit("Sql Error123".mysqli_error($GLOBALS["___mysqli_ston"]));
      while($sql_row111=mysqli_fetch_array($sql_result111))
      {
        $customer_order_no[]=$sql_row111['customer_order_no'];
        //echo "Test=".$fabric_required."<br>";
        // $cat_yy+=$sql_row111['catyy'];
      }   
      $co_no=implode(",",$customer_order_no) ;
    //   $order_total_qty=0;
    //   $sql111="select order_s_xs+order_s_s+order_s_m+order_s_l+order_s_xl+order_s_xxl+order_s_xxxl+order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50 as total from $bai_pro3.bai_orders_db_confirm where order_del_no='$schedule' and order_col_des='$color'";        
    //   $sql_result1111=mysqli_query($link, $sql111) or exit("Sql Error111".mysqli_error($GLOBALS["___mysqli_ston"]));
    //   while($sql_row1111=mysqli_fetch_array($sql_result1111))
    //   {
    //     $order_total_qty+=$sql_row1111['total'];
    //   }
      
      $colors_db=array_unique($colors_db);
      $club_c_code=array_unique($club_c_code);
      $club_docs=array_unique($club_docs);
      
      //For Fabric Wip Tracking
      
      if($id=="yellow")
      {
        $fab_wip+=$total_qty;
      }  
      $schedule=implode(",",$schedule); 
    $title=str_pad("Style:".trim($style),80)."</br>".
            str_pad("CO NO:".($co_no),120)."</br>".
            str_pad("Schedule:".trim($schedule),80)."</br>".
            str_pad("Color:".$colorx,50)."</br>".
            str_pad("Cut Job No:".$cut_no,80)."</br>".
            $tool_tip.
            str_pad("Docket No:".$docket_number,80)."</br>".
            str_pad("Total_Qty:".$fabric_required,80)."</br>".
            str_pad("Plan Time:".$log_time,50)."</br>".
            str_pad("Lay Req Time:".$lay_time,50);
            // str_pad("Fab_Loc.:".$fabric_location."Bundle_Loc.:".$bundle_location,80);
  
    
   // $clr=trim(implode(',',$colors_db),50);
    /*Getting required qty and allocated qty and catyy and Cuttable excess% and fab cad alloaction*/
    
    
    //echo "Fabric Required qty : ".$fabric_required."</br>";
      
      
    //getting allocated qty;
      $sql_fabcadallow="SELECT COALESCE(SUM(allocated_qty),0) as allocated_qty FROM $wms.fabric_cad_allocation WHERE doc_no='$doc_no' and plant_code='$plant_code'";
      mysqli_query($link, $sql_fabcadallow) or exit("Sql Error fab cad".mysqli_error($GLOBALS["___mysqli_ston"]));
      $sql_fabcadallow_result=mysqli_query($link, $sql_fabcadallow) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
      $sql_num_check=mysqli_num_rows($sql_fabcadallow_result);
      while($sql_fabcadallow_row=mysqli_fetch_array($sql_fabcadallow_result))
      { 
        $allocated_qty=$sql_fabcadallow_row['allocated_qty'];       
      }
      // echo "Allocated qty  : ".$allocated_qty."</br>";
    
      //getting requested qty 
      if($doc_no!='' && $plant_code!=''){
		$result_docketinfo=getDocketInformation($doc_no,$plant_code);
		
		$req_qty =$result_docketinfo['requirement'];
		
		
	}
      // echo "Requested qty  : ".$req_qty."</br>";

      //total reqsted qty
      $total_req_qty=$cat_yy*$order_total_qty;

      // echo "Tota Requested Qty : ".$total_req_qty."</br>";
    

      if($lay_time[array_search($doc_no,$doc_no_ref)]<date("Y-m-d H:i:s"))
      {
        $blink_docs[]=$doc_no;
      }


      //Embellishment Tracking
      // if($emb_sum=="")
      // {
      //   $emb_sum=0;
      // }
      // if($input_count=="")
      // {
      //   $input_count=0;
      // }
      $emb_stat_title="";
      // $iustyle="IU";
      // //echo $emb_stat."-".$emb_sum."-".$input_count."$";
      // if(($emb_stat==1 or $emb_stat==3) and $emb_sum>0)
      // {
      //   $emb_stat_title="<font color=black size=2>X</font>";
      //   $iustyle="I";
      // }
      // else
      // {
      //   if(($emb_stat==1 or $emb_stat==3) and $emb_sum==0 and $input_count>0)
      //   {
      //     $emb_stat_title="<font color=black size=2>&#8730;</font>";
      //     $iustyle="I";
      //   }
      //   else
      //   {
      //     if(($emb_stat==1 or $emb_stat==3))
      //     {
      //       $emb_stat_title="<font color=black size=2>X</font>";
      //       $iustyle="I";
      //     }
      //   }
      // }
      //echo $emb_sum;
      //Embellishment Tracking
    //unset($sel_sty);
  //Ticket #177328 add the Blinking Option for Exceeding Fabric Request Dockets and IU module show "IU" in that boxes and if it is emblishment display "IX"
    // $sqlt="SELECT * from $bai_pro3.cut_tbl_dash_doc_summ where  doc_no in ($doc_no) and act_cut_issue_status<>'DONE' and (order_style_no like 'L%Y%' or order_style_no like 'L%Z%' or order_style_no like 'O%Y%' or order_style_no like 'O%Z%') order by field(doc_no,$doc_no) " ;
    // //echo "query=".$sqlt;
    // mysqli_query($link, $sqlt) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    // $sql_result12=mysqli_query($link, $sqlt) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    // $check_num_rows=mysqli_num_rows($sql_result12);   
     
    // while($sql_row12=mysqli_fetch_array($sql_result12))
    // {
    //   $sel_sty=$sql_row12['order_style_no'];
    //   $sel_sch=$sql_row12['order_del_no'];      
    // }

  

    $fab_pop_details = getFullURLLevel($_GET['r'],'cps/fab_pop_details.php',1,'R');
    $fab_pop_details1 = getFullURLLevel($_GET['r'],'cps/fab_pop_alert.php',1,'R');
    if($check_num_rows>0 && $ord_style==$sel_sty)
    {
  
        if($id=="blue")
        {
          echo "<a data-title='$title' rel='tooltip'><div id='$docket_number' class='$id $recut_class' style='font-size:12px; text-align:center; float:left;' >$iustyle $emb_stat_title</div></a>"; 
        }
        else
        {
          // Ticket #177328 / compare the req_time with current date and time for Blinking Option for Exceeding Fabric Request Dockets
          //echo "blue1 : ".$req_date_time[array_search($doc_no,$doc_no_ref)]."-".date("Y-m-d H:i:s")."</br>";
          if($req_date_time<date("Y-m-d H:i:s"))
          { 
            echo "<div data-title='$title' rel='tooltip'><div id='S$schedule' style='float:left;'><div id='$docket_number' class='$id $recut_class' style='font-size:12px; text-align:center; float:left; color:$id' ><a href='".$fab_pop_details."?doc_no=$doc_no&dash=$dash&plantcode_name=$plant_code&username=$username&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."' onclick='Popup=window.open('fab_pop_details.php?doc_no=$doc_no&dash=$dash&plantcode_name=$plant_code&username=$username&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;' ><div class='blink'>".$req_time." (".$iustyle."".$emb_stat_title.")</div></a></div></div></div><br/>";
          }
          else
          {
            echo "<div data-title='$title' rel='tooltip'><div id='S$schedule' style='float:left;'><div id='$docket_number' class='$id $recut_class' style='font-size:12px; text-align:center; float:left; color:$id' ><a href='".$fab_pop_details."?doc_no=$doc_no&dash=$dash&plantcode_name=$plant_code&username=$username&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."' onclick='Popup=window.open('fab_pop_details.php?doc_no=$doc_no&dash=$dash&plantcode_name=$plant_code&username=$username&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;' >".$req_time." (".$iustyle."".$emb_stat_title.")</a></div></div></div><br/>";
          }
        }
    }
    else
    {
      
        if($id=="blue")
        {
          echo "<a data-title='$title' rel='tooltip'><div id='$docket_number' class='$id $recut_class' style='font-size:12px; text-align:center; float:left;' >$emb_stat_title</div></a>"; 
        }
        else
        {
          
          if($id=="lgreen")
          { 
            
            //echo "Light Green</br>";
            // Ticket #177328 / compare the req_time with current date and time for Blinking Option for Exceeding Fabric Request Dockets
            //echo "Light green :".$req_date_time[array_search($doc_no,$doc_no_ref)]."-".date("Y-m-d H:i:s")."</br>"; 
            if($req_date_time<date("Y-m-d H:i:s"))
            {
              echo "<div data-title='$title' rel='tooltip'><div id='S$schedule' style='float:left;' ><div id='$docket_number' class='$id $recut_class' style='font-size:12px; text-align:center; float:left; color:$id' ><a href='".$fab_pop_details."?doc_no=$doc_no&dash=$dash&plantcode_name=$plant_code&username=$username&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."' onclick='Popup=window.open('fab_pop_details.php?doc_no=$doc_no&dash=$dash&plantcode_name=$plant_code&username=$username&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;'><div class='blink'>$emb_stat_title".$req_time."</div></a></div></div></div><br/>";
            }
            else
            {
              echo "<div data-title='$title' rel='tooltip'><div id='S$schedule' style='float:left;'><div id='$docket_number' class='$id $recut_class' style='font-size:12px; text-align:center; float:left; color:$id'><a href='".$fab_pop_details."?doc_no=$doc_no&dash=$dash&plantcode_name=$plant_code&username=$username&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."' onclick='Popup=window.open(".$fab_pop_details."'doc_no=$doc_no&dash=$dash&plantcode_name=$plant_code&username=$username&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;'>$emb_stat_title ".$req_time."</a></div></div></div><br/>";
            }
          }
          else if($id=="green")
          {   
            //echo "Thick Green</br>";
            //echo "Thick Green :".$req_date_time[array_search($doc_no,$doc_no_ref)]."-".date("Y-m-d H:i:s")."</br>"; 
           if($req_date_time<date("Y-m-d H:i:s"))
            {
            echo "<div data-title='$title' rel='tooltip'><div id='S$schedule' style='float:left;'><div id='$docket_number' class='$id $recut_class' style='font-size:12px; text-align:center; float:left; color:$id' ><a href='".$fab_pop_details."?doc_no=$doc_no&dash=$dash&plantcode_name=$plant_code&username=$username&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."' onclick='Popup=window.open(".$fab_pop_details."'doc_no=$doc_no&dash=$dash&plantcode_name=$plant_code&username=$username&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;' ><div class='blink'>$emb_stat_title ".$req_time."</div></a></div></div></div><br/>";
            }
            else
            {
              echo "<div data-title='$title' rel='tooltip'><div id='S$schedule' style='float:left;'><div id='$docket_number' class='$id $recut_class' style='font-size:12px; text-align:center; float:left; color:$id' ><a href='".$fab_pop_details."?doc_no=$doc_no&dash=$dash&plantcode_name=$plant_code&username=$username&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."' onclick='Popup=window.open(".$fab_pop_details."'doc_no=$doc_no&dash=$dash&plantcode_name=$plant_code&username=$username&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;' >$emb_stat_title ".$req_time."</a></div></div></div><br/>";
            }
          }
          else
          { 
            // echo "Hash Color</br>";
            // edited by ram kumar
            // echo "fabric req :".$fabric_required."</br>";
            // echo "total req :".$total_req_qty."</br>";
         
        /*For testing logic changed*/ 
            if($fabric_required<=$total_req_qty){
          // if($fabric_required>$total_req_qty){
                //$id='blue';
                //echo "<blink>blue2 : ".$req_date_time[array_search($doc_no,$doc_no_ref)]."-".date("Y-m-d H:i:s")."</blink></br>";
                //allowed
                // Ticket #177328 / compare the req_time with current date and time for Blinking Option for Exceeding Fabric Request Dockets
              if($req_date_time<date("Y-m-d H:i:s"))
              { 
                echo "<div data-title='$title' rel='tooltip'><div id='S$schedule' style='float:left;'><div id='$docket_number' class='$id $recut_class' style='font-size:12px; text-align:center; float:left; color:$id' ><a href='".$fab_pop_details."?doc_no=$doc_no&dash=$dash&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."' onclick='Popup=window.open(".$fab_pop_details."'doc_no=$doc_no&dash=$dash&plantcode_name=$plant_code&username=$username&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;' >$emb_stat_title ".$req_time."</a></div></div></div><br/>";
              }
              else
              {
                echo "<div data-title='$title' rel='tooltip'><div id='S$schedule' style='float:left;'><div id='$docket_number' class='$id $recut_class' style='font-size:12px; text-align:center; float:left; color:$id' ><a href='".$fab_pop_details."?doc_no=$doc_no&dash=$dash&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."' onclick='Popup=window.open(".$fab_pop_details."'doc_no=$doc_no&plantcode_name=$plant_code&username=$username&dash=$dashpop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;' >$emb_stat_title ".$req_time."</a></div></div></div><br/>";
              }
            }else{
                $id='yellow';
                //Not Allowed
              if(in_array($authorized,$has_permission)){
  
                //echo "orange : ".$req_date_time[array_search($doc_no,$doc_no_ref)]."-".date("Y-m-d H:i:s")."</br>";
                if($req_date_time<date("Y-m-d H:i:s"))
                {
                  echo "<div data-title='$title' rel='tooltip'><div id='S$schedule' style='float:left;'><div id='$docket_number' class='$id $recut_class' style='font-size:12px; text-align:center; float:left; color:$id' ><a href='".$fab_pop_details1."' onclick='Popup=window.open(".$fab_pop_details1.",'Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;'><div class='blink'>$emb_stat_title ".$req_time."</div></a></div></div></div><br/>";
                }
                else
                {
                  echo "<div data-title='$title' rel='tooltip'><div id='S$schedule' style='float:left;'><div id='$docket_number' class='$id $recut_class' style='font-size:12px; text-align:center; float:left; color:$id' ><a href='".$fab_pop_details1."' onclick='Popup=window.open(".$fab_pop_details1.",'Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;' >$emb_stat_title ".$req_time."</a></div></div></div><br/>";
                }
              }else{
                //echo "Orange : ".$req_date_time[array_search($doc_no,$doc_no_ref)]."-".date("Y-m-d H:i:s")."</br>";
                if($req_date_time<date("Y-m-d H:i:s"))
                {
                  echo "<div data-title='$title' rel='tooltip'><div id='S$schedule' style='float:left;'><div id='$docket_number' class='$id $recut_class' style='font-size:12px; text-align:center; float:left; color:$id' ><a href='".$fab_pop_details."?doc_no=$doc_no&dash=$dash&plantcode_name=$plant_code&username=$username&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."' onclick='Popup=window.open(".$fab_pop_details."'doc_no=$doc_no&dash=$dash&plantcode_name=$plant_code&username=$username&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;' ><div class='blink'>$emb_stat_title ".$req_time."</div></a></div></div></div><br/>";
                }
                else
                {
                  echo "<div data-title='$title' rel='tooltip'><div id='S$schedule' style='float:left;'><div id='$docket_number' class='$id $recut_class' style='font-size:12px; text-align:center; float:left; color:$id' ><a href='".$fab_pop_details."?doc_no=$doc_no&dash=$dash&plantcode_name=$plant_code&username=$username&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."' onclick='Popup=window.open(".$fab_pop_details."'doc_no=$doc_no&dash=$dash&plantcode_name=$plant_code&username=$username&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;' >$emb_stat_title ".$req_time."</a></div></div></div><br/>";
                }
              }
            }
            
          }
  
        }
    }   
  
        
      }
    }
  
    echo "</td>";
    echo "</tr>";
  }
  echo "</div>";  
  //Blinking at section level
  $bindex++;

  echo "</table>";
  echo "</p>";
  echo '</div>';
} 
} 
  
  //To show section level priority only to RM-Fabric users only.
  if((in_array($authorized,$has_permission)))
  {
    echo "<script>";
    //echo "blink_new_priority('".implode(",",$blink_docs)."');";
    echo "</script>";
  }
  
  //RECUT
  
?>
<script>
document.getElementById()
</script>
<div style="clear: both;"> </div>
</br>
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'ctd.htm',0,'R')); 
?>
<!-- </body>
</html> -->

<?php

((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res);
((is_null($___mysqli_res = mysqli_close($link_new))) ? false : $___mysqli_res);
//mysql_close($link_new2);

?>
