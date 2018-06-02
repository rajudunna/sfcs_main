
<!--
Core Module:This is to show priorities for fabric issuing as per the requests.

Changes Log:

2014-02-03/kirang/Ticket #976613 change the buyer division display based on the pink,logo,IU as per plan_modules
2014-03-05/kirang/Ticket #177328 add the Blinking Option for Exceeding Fabric Request Dockets and IU module show "IU" in that boxes and if it is emblishment display "IX"
-->
<?php
$double_modules=array();
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


<?php
include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
include('../'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
include('../'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R')); 
include('../'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R')); 
// include("dbconf.php"); 
// include("functions.php"); 
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/user_acl_v1.php");
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php");
$view_access=user_acl("SFCS_0199",$username,1,$group_id_sfcs); 
$authorized=user_acl("SFCS_0199",$username,7,$group_id_sfcs); 


//list($domain,$username) = split('[\]',$_SERVER['AUTH_USER'],2);
//$username_list=explode('\\',$_SERVER['REMOTE_USER']);
//$username=$username_list[1];

//$authorized=array("kirang","kirang","santhoshbo","vemanas","srinivasaraot");
//$username='sfcsproject1';
// echo "User : ".$username;
?>

<?php
set_time_limit(200000);
?>

<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"> -->
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
<!-- <head> -->
<title>CPS Dashboard</title>
<!-- <link rel="stylesheet" href="styles/bootstrap.min.css"> -->
<?php
$hour=date("H.i");
echo '<META HTTP-EQUIV="refresh" content="120">';

/*    
//if(($hour>=7.45 and $hour<=10.00) or ($hour>=15.15 and $hour<=16.45)) //OLD
if(($hour>=7.45 and $hour<=10.45) or ($hour>=12.30 and $hour<=14.00) or ($hour>=16.00 and $hour<=17.30)){ 
}else
{
  echo '<META HTTP-EQUIV="refresh" content="120">'; 
} 
*/
?>
<!--<script type="text/javascript" src="jquery.js"></script>
<script type='text/javascript' src='jquery-1.6.2.js'></script>-->
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
  window.location = "<?= getFullURL($_GET['r'],'fab_priority_dashboard.php','N') ?>"+"&view=2&view_div="+y;
}

function redirect_dash()
{
  x=document.getElementById('view_cat').value;
  y=document.getElementById('view_div').value;
  z=document.getElementById('view_dash').value;
  window.location = "<?= getFullURL($_GET['r'],'fab_priority_dashboard.php','N') ?>"+"&view="+z+"&view_cat="+x+"&view_div="+y;
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
  
  /*
  obj="#S"+x;

  
  if ( $(obj).length ) 
  {
    $(obj).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
  }
  */
  //else
  //{
  //  alert("Your request is doesnt exist");
  //}
}


function blink_new1(x)
{
  
  obj="#"+x;
  
  if ( $(obj).length ) 
  {
    $(obj).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
  }
  //else
  //{
  //  alert("Your request is doesnt exist");
  //}
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

a{
  text-decoration:none;
  color: white;
}

.white {
  max-width:130px; min-width:20px;
  height:20px;
  background-color: #ffffff;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid #000000;
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
  max-width:130px; min-width:20px;
  height:20px;
  background-color: #ff0000;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid #000000;
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
  max-width:130px; min-width:20px;
  height:20px;
  background-color: #00ff00;
  color: black;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid #000000;
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
  max-width:130px; min-width:20px;
   color: white;
  height:20px;
  background-color: #339900;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid #000000;
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
  max-width:130px; min-width:20px;
  height:20px;
  background-color: #ffff00;
  display:block;
  float: left;
  margin: 2px;
  color:black;
border: 1px solid #000000;
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
  max-width:130px; min-width:20px;
  height:20px;
  background-color: #ff00ff;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid #000000;
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
  max-width:130px; min-width:20px;
  height:20px;
  background-color: #991144;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid #000000;
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
  max-width:130px; min-width:20px;
  height:20px;
  background-color: #15a5f2;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid #000000;
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
  max-width:130px; min-width:20px;
  height:20px;
  background-color: #999999;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid #000000;
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
  max-width:130px; min-width:20px;
  height:20px;
  background-color: black;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid #000000;
height: 25px;
    width: 250px;
   padding: 4px;
}

.brown {
  max-width:130px; min-width:20px;
  height:20px;
  background-color: #333333;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid #000000;
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
<?php //echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/master/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; 
?>
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

var message="Function Disabled!";

///////////////////////////////////
function clickIE4(){
if (event.button==2){
sweetAlert("Info!", message, "warning");
return false;
}
}

function clickNS4(e){
if (document.layers||document.getElementById&&!document.all){
if (e.which==2||e.which==3){
sweetAlert("Info!", message, "warning");
return false;
}
}
}

if (document.layers){
document.captureEvents(Event.MOUSEDOWN);
document.onmousedown=clickNS4;
}
else if (document.all&&!document.getElementById){
document.onmousedown=clickIE4;
}

document.oncontextmenu=new Function("sweetAlert('Info!', message, 'warning');return false")

// --> 
</script>

<?php

echo "<div style='width=100%;'>";
//NEW to correct
$remove_docs=array();
$sqlx="select * from $bai_pro3.plan_dash_doc_summ where act_cut_issue_status=\"DONE\"";
mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
  $remove_docs[]=$sql_rowx['doc_no'];
}

if(sizeof($remove_docs)>0)
{
  
$sqlx="delete from $bai_pro3.plan_dashboard where doc_no in (".implode(",",$remove_docs).")";
mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
}

//echo "<p style=\"float:right;\"><font size=4><a href=\"javascript:void(0)\" onclick=\"Popup=window.open('fab_legend.jpg"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">Color Codes</a></font>";
//echo "<br/>";
//echo "<font size=4><a href=\"javascript:void(0)\" onclick=\"Popup=window.open('cutting_wip_alert_email.php?alertfilter=1"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">Available Input</a></font>";
//echo "<br/><font size=4><a onmouseover=\"window.status='BAINet'; return true;\" href=\"fab_priority_dashboard.php?view=1\"  onmouseover=\"window.status='BAINet'; return true;\" onmouseout=\"window.status='';return true;\">Quick View</a></font><br/><font size=4><a onmouseover=\"window.status='BAINet'; return true;\" href=\"fab_priority_dashboard.php?view=3\"  onmouseover=\"window.status='BAINet'; return true;\" onmouseout=\"window.status='';return true;\">Cut View</a></font>";
//echo '<span id="theTime" style="color: yellow; font-family: arial; font-size: 14pt"></span>';
echo "</p>";
 
//echo "<font size=4><a href=\"javascript:void(0)\" onclick=\"Popup=window.open('fabric_requisition_report.php"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">LIVE CUT PLAN DASHBOARD</a>";
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

echo "<div class='panel-heading'><span style=\"float\"><strong>CPS Dashboard</strong></a>
</span><span style=\"float: right; margin-top: 0px\"><b>
<a href=\"javascript:void(0)\" onclick=\"Popup=window.open('cps.htm"."','Popup',
'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); 
if (window.focus) {Popup.focus()} return false;\"></a></b></span></div>";
//echo "<div class='panel-heading'><span style=\"float\"><a href=\"javascript:void(0)\" onclick=\"Popup=window.open('fabric_requisition_report.php"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><strong>CPS Dashboard</strong></a></span><span style=\"float: right; margin-top: 0px\"><b><a href=\"javascript:void(0)\" onclick=\"Popup=window.open('/sfcs/projects/Beta/production_planning/cps.htm"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">?</a></b></span></div>";
//echo "<div id=\"page_heading\"><span style=\"float\"><a href=\"javascript:void(0)\" onclick=\"Popup=window.open('fabric_requisition_report.php"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><h3>Cut Priority Dashboard</h3></a></span><span style=\"float: right; margin-top: -20px\"><b><a href=\"javascript:void(0)\" onclick=\"Popup=window.open('cps.htm"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">?</a></b>&nbsp;</span></div>";
//echo "<font color=yellow>Refresh Rate: 120 Sec. (ALPHA TESTING)</font>";
echo '<div class="panel-body">
    <div class="form-inline">
      <div class="form-group">';
        echo 'Docket Track: <input type="text" name="docket" id="docket" class="form-control" onkeyup="blink_new(this.value)" size="10">&nbsp;&nbsp;&nbsp;';
      echo "</div>";
      echo'<div class="form-group">';
        echo 'Schedule Track: <input type="text" name="schedule" id="schedule" class="form-control" onkeyup="blink_new3(this.value)" size="10">';
      echo "</div>";

echo'<div class="form-group">';
echo '&nbsp;&nbsp;&nbsp;Buyer Division: 
<select name="view_div" id="view_div" class="form-control" onchange="redirect_view()">';
if($_GET['view_div']=="ALL") { 
  echo '<option value="ALL" selected>All</option>'; 
} else { 
  echo '<option value="ALL">All</option>'; }
echo "</div>";
echo "</div>";
$sqly="SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code";
//echo $sqly."<br>";

mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowy=mysqli_fetch_array($sql_resulty))
{
  $buyer_div=$sql_rowy['buyer_div'];
  $buyer_name=$sql_rowy['buyer_name'];

  if(urldecode($_GET["view_div"])=="$buyer_name") 
  {
    echo "<option value=\"".$buyer_name."\" selected>".$buyer_div."</option>";  
  } 
  else 
  {
    echo "<option value=\"".$buyer_name."\" >".$buyer_div."</option>"; 
  }
}
echo '</select>';
echo '</div>';

echo '<br><br>';
//For blinking priorties as per the section module wips
$bindex=0;
$blink_docs=array();

$sqlx="select * from $bai_pro3.sections_db where sec_id>0";
mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
  $section=$sql_rowx['sec_id'];
  $section_head=$sql_rowx['sec_head'];
  $section_mods=$sql_rowx['sec_mods'];

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
  $sql1d="SELECT module_id as modx from $bai_pro3.plan_modules where module_id in (".$section_mods.") order by module_id*1";
    if($_GET["view_div"]=="ALL" or $_GET["view_div"]=="")
    {
    $sql1d="SELECT module_id as modx from $bai_pro3.plan_modules where module_id in (".$section_mods.") order by module_id*1";
  }
  else
  {
    $sql1d="SELECT module_id as modx from $bai_pro3.plan_modules where module_id in (".$section_mods.") order by module_id*1"; 
  }
  
  $sql_num_checkd=0;
  mysqli_query($link, $sql1d) or exit("Sql Errord".mysqli_error($GLOBALS["___mysqli_ston"]));
  $sql_result1d=mysqli_query($link, $sql1d) or exit("Sql Errordd".mysqli_error($GLOBALS["___mysqli_ston"]));
  $sql_num_checkd=mysqli_num_rows($sql_result1d);
  //echo $sql_num_checkd."<br>";
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
  echo "<tr><th colspan=2\"><h2><a href=\"javascript:void(0)\" onclick=\"Popup=window.open('".getFullURLLevel($_GET['r'],'board_update.php',0,'N')."&section_no=$section"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><font style=\"font-size:24px;color:#000000;\"><b>SECTION - $section</b></font></a></h2></th></th></tr>";

  //$mods=array();
  //$mods=explode(",",$section_mods);
  
  //For Section level blinking
  $blink_minimum=0;
  

  //for($x=0;$x<sizeof($mods);$x++)
  {
    $module=$mods[$x];
    $blink_check=0;
    
    echo "<tr class=\"bottom\"><td>";
    //echo "<td class=\"bottom\"><strong><a href=\"javascript:void(0)\" title=\"WIP : $wip\"><font class=\"fontnn\" color=orange >$module</font></a></strong></td><td>";
    
    //To disable issuing fabric to cutting tables
    //All yellow colored jobs will be treated as Fabric Wip
    $cut_wip_control=3000;
    $fab_wip=0;
    $pop_restriction=0;
    
    //$sql1="SELECT * from plan_dash_doc_summ where module=$module order by priority limit 4"; New to correct
    //Filter view to avoid Cut Completed and Fabric Issued Modules
    unset($doc_ref);
    unset($req_time);
    unset($lay_time);
    unset($req_date_time);
    $doc_ref=array();
    $req_time=array();
    $lay_time=array();
    $req_date_time=array();
    $doc_ref[]=0;
    $req_time[]=0;
    $req_date_time[]=0;
    //$sql2="select doc_ref,req_time,module,log_time from bai_pro3.fabric_priorities where issued_time=\"0000-00-00 00:00:00\" and section=$section order by section,req_time";
    
    //Changed on 2013-10-03 to facilitate module change requirements. - KiranG
    $sql2="select doc_ref,req_time,module,log_time from $bai_pro3.fabric_priorities where issued_time=\"0000-00-00 00:00:00\" and module in ($section_mods) order by req_time,module";
    //echo $sql2;
    $result2=mysqli_query($link, $sql2) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row2=mysqli_fetch_array($result2))
    {
      $doc_ref[]=$row2['doc_ref'];
      $req_time[]=$row2['module'].") ".date("M-d H:i",strtotime($row2['req_time']));
      $lay_time[]=$row2['log_time'];
      $req_date_time[]=$row2['req_time'];
    }
    
  // start style wise display by dharani 10-26-2013 
  
    $sql1="SELECT * from $bai_pro3.plan_dash_doc_summ where doc_no in (".implode(",",$doc_ref).") and act_cut_status<>\"DONE\" order by field(doc_no,".implode(",",$doc_ref).")";
    
      //echo $_GET["view_div"];
      if($_GET["view_div"] == 'M')
      {
        $_GET["view_div"] = "M&S";
      }
      $leter = str_split($_GET["view_div"]);
    
       if($_GET["view_div"]=="ALL" or $_GET["view_div"]=="")
      {
        $sql1="SELECT * from $bai_pro3.plan_dash_doc_summ where doc_no in (".implode(",",$doc_ref).") and act_cut_status<>\"DONE\" order by field(doc_no,".implode(",",$doc_ref).")";
      }
      else
      {
        $dash = $_GET["view_div"];
        $sql_qry = "select * from $bai_pro2.buyer_codes where buyer_name =".'"'.$dash.'"';
        
        $res = mysqli_query($link, $sql_qry);
        $sql_count_check = mysqli_num_rows($res);
        
        while($row_res = mysqli_fetch_array($res))
        {
          $buyer_identity = $row_res['buyer_name'];
        }
          
        $sql1="SELECT * from $bai_pro3.plan_dash_doc_summ where order_style_no  in (select order_style_no from $bai_pro3.bai_orders_db_confirm where order_div = ".'"'.$buyer_identity.'"'.") and doc_no in (".implode(",",$doc_ref).") and act_cut_status<>\"DONE\" order by field(doc_no,".implode(",",$doc_ref).")"; 
        
      }
      
      
  //echo "query".$sql1; 
  // close style wise display 
    //NEw check
    
    
    mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql_num_check=mysqli_num_rows($sql_result1);
    if($sql_num_check>0){
    while($sql_row1=mysqli_fetch_array($sql_result1))
    {
      $cut_new=$sql_row1['act_cut_status'];
      $cut_input_new=$sql_row1['act_cut_issue_status'];
      $rm_new=strtolower(chop($sql_row1['rm_date']));
      $rm_update_new=strtolower(chop($sql_row1['rm_date']));
      $input_temp=strtolower(chop($sql_row1['cut_inp_temp']));
      $doc_no=$sql_row1['doc_no'];
      $order_tid=$sql_row1['order_tid'];
      $ord_style=$sql_row1['order_style_no'];
      //$fabric_status=$sql_row1['fabric_status'];
      $plan_lot_ref_v1=$sql_row1['plan_lot_ref'];
      
      $fabric_status=$sql_row1['fabric_status_new']; //NEW due to plan dashboard clearing regularly and to stop issuing issued fabric.
      if($fabric_status==null or $fabric_status==0){
        
        $fabric_status=$sql_row1['ft_status'];
        if($fabric_status==5)
        {
          $fabric_status=4;
        }
        
      }
      
      $print_status=$sql_row1['print_status'];
      
      $bundle_location="";
      if(sizeof(explode("$",$sql_row1['bundle_location']))>1)
      {
        $bundle_location=end(explode("$",$sql_row1['bundle_location']));
      }
      $fabric_location="";
      if(sizeof(explode("$",$sql_row1['plan_lot_ref']))>1)
      {
        $fabric_location=end(explode("$",$sql_row1['plan_lot_ref']));
      }
      
      
      $style=$sql_row1['order_style_no'];
      $schedule=$sql_row1['order_del_no'];
      $color=$sql_row1['order_col_des'];
      $total_qty=$sql_row1['total'];
      
      $cut_no=$sql_row1['acutno'];
      $color_code=$sql_row1['color_code'];
      $log_time=$sql_row1['log_time'];
      $emb_stat=$sql_row1['emb_stat'];
      
      //Exception for M&S WIP - 7000
      
      if(substr($style,0,1)=="M")
      {
        $cut_wip_control=7000;
      }
      
      
      //$sql11="select sum(ims_pro_qty) as \"bac_qty\" from (SELECT * FROM ims_log where ims_log.ims_doc_no=$doc_no UNION ALL SELECT * FROM ims_log_backup WHERE ims_log_backup.ims_mod_no<>0 and ims_log_backup.ims_doc_no=$doc_no) as t";
      
      $sql11="select sum(ims_pro_qty) as \"bac_qty\", sum(emb) as \"emb_sum\" from (SELECT ims_pro_qty, if(ims_status='EPR' or ims_status='EPS',1,0) as \"emb\" FROM $bai_pro3.ims_log where ims_log.ims_doc_no=$doc_no UNION ALL SELECT ims_pro_qty, if(ims_status='EPR' or ims_status='EPS',1,0) as \"emb\" FROM $bai_pro3.ims_log_backup WHERE ims_log_backup.ims_mod_no<>0 and ims_log_backup.ims_doc_no=$doc_no) as t";
      mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
      
      $sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
      $input_count=mysqli_num_rows($sql_result11);
      while($sql_row11=mysqli_fetch_array($sql_result11))
      {
        $output=$sql_row11['bac_qty'];
        $emb_sum=$sql_row11['emb_sum'];
        if($emb_sum==NULL)
        {
          $input_count=0;
        }
      } 
      
      if($cut_new=="DONE"){ $cut_new="T";} else { $cut_new="F"; }
      if($rm_update_new==""){ $rm_update_new="F"; } else { $rm_update_new="T"; }
      if($rm_new=="0000-00-00 00:00:00" or $rm_new=="") { $rm_new="F"; } else { $rm_new="T";  }
      if($input_temp==1) { $input_temp="T"; } else { $input_temp="F"; }
      if($cut_input_new=="DONE") { $cut_input_new="T";  } else { $cut_input_new="F"; }
      
      $check_string=$cut_new.$rm_update_new.$rm_new.$input_temp.$cut_input_new;
      $rem="Nil";
      
      $sql112="select co_no from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\" and order_col_des=\"$color\"";
      //echo $sql112;
      $sql_result112=mysqli_query($link, $sql112) or exit("Sql Error1".$sql112."".mysqli_error($GLOBALS["___mysqli_ston"]));
      while($sql_row112=mysqli_fetch_array($sql_result112))
      {
        $co_no=$sql_row112['co_no'];
      }
      
      //New change to restrict only M&S 2013-06-18 12:25 PM Kiran
      //NEW FSP
      if($fabric_status!=5 and substr($style,0,1)=='M')
      {
        //$fabric_status=$sql_row1['ft_status'];
        
        //To get the status of join orders
        $sql11="select ft_status from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\" and order_joins=2";
        $sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        if(mysqli_num_rows($sql_result11)>0)
        {
          $sql11="select ft_status from $bai_pro3.bai_orders_db_confirm where order_joins=\"J$schedule\"";
          $sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
          while($sql_row11=mysqli_fetch_array($sql_result11))
          {
            $join_ft_status=$sql_row11['ft_status'];
            if($sql_row11['ft_status']==0 or $sql_row11['ft_status']>1)
            {
              break;
            }
          }
          
          $fabric_status=$join_ft_status;
        }
        //To get the status of join orders
      }
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

      
      if($cut_new=="T")
      {
        $id="blue";
      }
      
      
      //Filter view to avoid Cut Completed and Fabric Issued Modules
      if($_GET['view']==1)
      {
        if($cut_new=="T" or $fabric_status==5)
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
    
      //echo "<a href=\"pop_details.php?doc_no=$doc_no\" onclick=\"Popup=window.open('pop_details.php?doc_no=$doc_no"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><div id=\"$id\" style=\"font-size:10px; text-align:center;\" title=\"\" >".trim(substr($order_tid,0,15))."</div></a>"; 

      //$title=str_pad("Style:".trim(substr($order_tid,0,15)),60).str_pad("Schedule:".check_style(substr($order_tid,15-(strlen($order_tid)))),80).str_pad("Color:".substr($order_tid,(15+strlen(check_style(substr($order_tid,15-(strlen($order_tid))))))-strlen($order_tid)),60);
      
      //$title=str_pad("Style:".$style,80).str_pad("Schedule:".$schedule,80).str_pad("Color:".$color,80).str_pad("Job_No:".chr($sql_row1['color_code']).leading_zeros($sql_row1['acutno'],3),80).str_pad("Total_Qty:".$total_qty,80).str_pad("Output_Qty:".$output,80).str_pad("Log_Time:".$log_time,80).str_pad("Remarks:".$rem,80);

      //For Color Clubbing
      unset($club_c_code);
      unset($club_docs);
      $club_c_code=array();
      $club_docs=array();
      $colors_db=array();
      if($sql_row1['clubbing']>0)
      {
        $total_qty=0;
        $fabric_required=0;
        $sql11="select order_col_des,color_code,doc_no,material_req,(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies as total from $bai_pro3.order_cat_doc_mk_mix where order_del_no=$schedule and clubbing=".$sql_row1['clubbing']." and acutno=".$sql_row1['acutno'];
        
        $sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($sql_row11=mysqli_fetch_array($sql_result11))
        {
          $club_c_code[]=chr($sql_row11['color_code']).leading_zeros($sql_row1['acutno'],3);
          $club_docs[]=$sql_row11['doc_no'];
          $total_qty+=$sql_row11['total'];
          $colors_db[]=trim($sql_row11['order_col_des']);
          $fabric_required+=$sql_row11['material_req'];
        } 
      }
      else
      {
        
        $colors_db[]=$color;
        $club_c_code[]=chr($sql_row1['color_code']).leading_zeros($sql_row1['acutno'],3);
        $club_docs[]=$doc_no;
      }
      
      $fabric_required=0;
      $cat_yy=0;
      $sql11="select catyy,material_req from $bai_pro3.order_cat_doc_mk_mix where category in ('Body','Front') and order_del_no=\"$schedule\" and order_col_des=\"$color\" and doc_no=".$sql_row1['doc_no'];
      //echo $sql11."<br>";
      $sql_result111=mysqli_query($link, $sql11) or exit("Sql Error123".mysqli_error($GLOBALS["___mysqli_ston"]));
      while($sql_row111=mysqli_fetch_array($sql_result111))
      {
        $fabric_required+=$sql_row111['material_req'];
        //echo "Test=".$fabric_required."<br>";
        $cat_yy+=$sql_row111['catyy'];
      }   
      
      $order_total_qty=0;
      $sql111="select order_s_xs+order_s_s+order_s_m+order_s_l+order_s_xl+order_s_xxl+order_s_xxxl+order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50 as total from $bai_pro3.bai_orders_db_confirm where order_del_no=$schedule and order_col_des=\"$color\"";        
      $sql_result1111=mysqli_query($link, $sql111) or exit("Sql Error111".mysqli_error($GLOBALS["___mysqli_ston"]));
      while($sql_row1111=mysqli_fetch_array($sql_result1111))
      {
        $order_total_qty+=$sql_row1111['total'];
      }
      
      $colors_db=array_unique($colors_db);
      $club_c_code=array_unique($club_c_code);
      $club_docs=array_unique($club_docs);
      
      //For Fabric Wip Tracking
      
      if($cut_new!="T" and $id=="yellow")
      {
        $fab_wip+=$total_qty;
      }
          
    
    //$title=str_pad("Style:".trim($style),80).str_pad("Schedule:".$schedule,80).str_pad("Color:".trim(implode(",",$colors_db)),80).str_pad("Job_No:".implode(", ",$club_c_code),80).str_pad("Total_Qty:".$total_qty,80).str_pad("Log_Time:".$log_time,80).str_pad("Remarks:".$rem." / Bundle_Location:".$bundle_location,80);
    $title=str_pad("Style:".trim($style),80)."\n".str_pad("CO:".trim($co_no),80)."\n".str_pad("Schedule:".$schedule,80)."\n".str_pad("Color:".trim(implode(",",$colors_db)),50)."\n".str_pad("Job_No:".implode(", ",$club_c_code),80)."\n".str_pad("Total_Qty:".$total_qty,80)."\n".str_pad("Plan_Time:".$log_time,50)."\n".str_pad("Lay_Req_Time:".$lay_time[array_search($doc_no,$doc_ref)],80)."\n".str_pad("Fab_Loc.:".$fabric_location."Bundle_Loc.:".$bundle_location,80);
    
    
    $clr=trim(implode(',',$colors_db),50);
    /*Getting required qty and allocated qty and catyy and Cuttable excess% and fab cad alloaction*/
    
    
    //echo "Fabric Required qty : ".$fabric_required."</br>";
      
      
    //getting allocated qty;
      $sql_fabcadallow="SELECT COALESCE(SUM(allocated_qty),0) as allocated_qty FROM $bai_rm_pj1.fabric_cad_allocation WHERE doc_no=$doc_no";
      mysqli_query($link, $sql_fabcadallow) or exit("Sql Error fab cad".mysqli_error($GLOBALS["___mysqli_ston"]));
      $sql_fabcadallow_result=mysqli_query($link, $sql_fabcadallow) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
      $sql_num_check=mysqli_num_rows($sql_fabcadallow_result);
      while($sql_fabcadallow_row=mysqli_fetch_array($sql_fabcadallow_result))
      { 
        $allocated_qty=$sql_fabcadallow_row['allocated_qty'];       
      }
      // echo "Allocated qty  : ".$allocated_qty."</br>";
    
      //getting requested qty 
      $sql_req_qty="SELECT material_req FROM $bai_pro3.order_cat_doc_mk_mix WHERE order_cat_doc_mk_mix.doc_no=$doc_no";
      // mysql_query($sql_req_qty,$link) or exit("Sql Error req qty".mysql_error());
      $sql_req_qty_result=mysqli_query($link, $sql_req_qty) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
      $sql_num_check=mysqli_num_rows($sql_req_qty_result);
      while($sql_req_qty_row=mysqli_fetch_array($sql_req_qty_result))
      { 
        $req_qty=round($sql_req_qty_row['material_req'],2);       
      }
      // echo "Requested qty  : ".$req_qty."</br>";

      //total reqsted qty
      $total_req_qty=$cat_yy*$order_total_qty;

      // echo "Tota Requested Qty : ".$total_req_qty."</br>";
    

      if($lay_time[array_search($doc_no,$doc_ref)]<date("Y-m-d H:i:s"))
      {
        $blink_docs[]=$doc_no;
      }


      //Embellishment Tracking
      if($emb_sum=="")
      {
        $emb_sum=0;
      }
      if($input_count=="")
      {
        $input_count=0;
      }
      $emb_stat_title="";
      $iustyle="IU";
      //echo $emb_stat."-".$emb_sum."-".$input_count."$";
      if(($emb_stat==1 or $emb_stat==3) and $emb_sum>0)
      {
        $emb_stat_title="<font color=black size=2>X</font>";
        $iustyle="I";
      }
      else
      {
        if(($emb_stat==1 or $emb_stat==3) and $emb_sum==0 and $input_count>0)
        {
          $emb_stat_title="<font color=black size=2>&#8730;</font>";
          $iustyle="I";
        }
        else
        {
          if(($emb_stat==1 or $emb_stat==3))
          {
            $emb_stat_title="<font color=black size=2>X</font>";
            $iustyle="I";
          }
        }
      }
      //echo $emb_sum;
      //Embellishment Tracking
    //unset($sel_sty);
  //Ticket #177328 add the Blinking Option for Exceeding Fabric Request Dockets and IU module show "IU" in that boxes and if it is emblishment display "IX"
    $sqlt="SELECT * from $bai_pro3.plan_dash_doc_summ where  doc_no in ($doc_no) and act_cut_issue_status<>\"DONE\" and (order_style_no like \"L%Y%\" or order_style_no like \"L%Z%\" or order_style_no like \"O%Y%\" or order_style_no like \"O%Z%\") order by field(doc_no,$doc_no) " ;
    //echo "query=".$sqlt;
    mysqli_query($link, $sqlt) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql_result12=mysqli_query($link, $sqlt) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    $check_num_rows=mysqli_num_rows($sql_result12);   
     
    while($sql_row12=mysqli_fetch_array($sql_result12))
    {
      $sel_sty=$sql_row12['order_style_no'];
      $sel_sch=$sql_row12['order_del_no'];      
    }

    //echo "time=".$req_time[array_search($doc_no,$doc_ref)];
    //echo "&nbsp;&nbsp;schedules:".$sel_sch."-".$sel_sty."-".$ord_style."<br/>"; 
    //echo "<br>".$ord_style."-".$sel_sty."<br>";
          $fab_pop_details = getFullURLLevel($_GET['r'],'fab_pop_details.php',0,'R');
  if($check_num_rows>0 && $ord_style==$sel_sty)
  {

      if($id=="blue")
      {
        echo "<div id=\"$doc_no\" class=\"$id\" style=\"font-size:12px; text-align:center; float:left;\" title=\"$title\" >$iustyle $emb_stat_title</div>"; 
      }
      else
      {
        // Ticket #177328 / compare the req_time with current date and time for Blinking Option for Exceeding Fabric Request Dockets
        //echo "blue1 : ".$req_date_time[array_search($doc_no,$doc_ref)]."-".date("Y-m-d H:i:s")."</br>";
        if($req_date_time[array_search($doc_no,$doc_ref)]<date("Y-m-d H:i:s"))
        { 
          echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$id\" style=\"font-size:12px; text-align:center; float:left; color:$id\" title=\"$title\" ><a href=\"\"".$fab_pop_details."?doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."\" onclick=\"Popup=window.open(".$fab_pop_details."'?doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><span class='blink'>".$req_time[array_search($doc_no,$doc_ref)]." (".$iustyle."".$emb_stat_title.")</span></a></div></div><br/>";
        }
        else
        {
          echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$id\" style=\"font-size:12px; text-align:center; float:left; color:$id\" title=\"$title\" ><a href=\"".$fab_pop_details."?doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."\" onclick=\"Popup=window.open(".$fab_pop_details."'?doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">".$req_time[array_search($doc_no,$doc_ref)]." (".$iustyle."".$emb_stat_title.")</a></div></div><br/>";
        }
      }
  }
  else
  {
    
      if($id=="blue")
      {
        echo "<div id=\"$doc_no\" class=\"$id\" style=\"font-size:12px; text-align:center; float:left;\" title=\"$title\" >$emb_stat_title</div>"; 
      }
      else
      {
        
        if($id=="lgreen")
        { 
          //echo "Light Green</br>";
          // Ticket #177328 / compare the req_time with current date and time for Blinking Option for Exceeding Fabric Request Dockets
          //echo "Light green :".$req_date_time[array_search($doc_no,$doc_ref)]."-".date("Y-m-d H:i:s")."</br>"; 
          if($req_date_time[array_search($doc_no,$doc_ref)]<date("Y-m-d H:i:s"))
          {
            echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$id\" style=\"font-size:12px; text-align:center; float:left; color:$id\" title=\"$title\" ><a href=\"".$fab_pop_details."?doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."\" onclick=\"Popup=window.open(".$fab_pop_details."'?doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><span class='blink'>$emb_stat_title ".$req_time[array_search($doc_no,$doc_ref)]."</span></a></div></div><br/>";
          }
          else
          {
            echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$id\" style=\"font-size:12px; text-align:center; float:left; color:$id\" title=\"$title\" ><a href=\"".$fab_pop_details."?doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."\" onclick=\"Popup=window.open(".$fab_pop_details."'doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$emb_stat_title ".$req_time[array_search($doc_no,$doc_ref)]."</a></div></div><br/>";
          }
        }
        else if($id=="green")
        {   
          //echo "Thick Green</br>";
          //echo "Thick Green :".$req_date_time[array_search($doc_no,$doc_ref)]."-".date("Y-m-d H:i:s")."</br>"; 
          if($req_date_time[array_search($doc_no,$doc_ref)]<date("Y-m-d H:i:s"))
          {
          echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$id\" style=\"font-size:12px; text-align:center; float:left; color:$id\" title=\"$title\" ><a href=\"".$fab_pop_details."?doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."\" onclick=\"Popup=window.open(".$fab_pop_details."'doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><span class='blink'>$emb_stat_title ".$req_time[array_search($doc_no,$doc_ref)]."</span></a></div></div><br/>";
          }
          else
          {
            echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$id\" style=\"font-size:12px; text-align:center; float:left; color:$id\" title=\"$title\" ><a href=\"".$fab_pop_details."?doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."\" onclick=\"Popup=window.open(".$fab_pop_details."'doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$emb_stat_title ".$req_time[array_search($doc_no,$doc_ref)]."</a></div></div><br/>";
          }
        }
        else
        { 
          // echo "Hash Color</br>";
          // edited by ram kumar
          // echo "fabric req :".$fabric_required."</br>";
           //echo "total req :".$total_req_qty."</br>";
          if($fabric_required<=$total_req_qty){
              //$id='blue';
              //echo "<blink>blue2 : ".$req_date_time[array_search($doc_no,$doc_ref)]."-".date("Y-m-d H:i:s")."</blink></br>";
              //allowed
              // Ticket #177328 / compare the req_time with current date and time for Blinking Option for Exceeding Fabric Request Dockets
            if($req_date_time[array_search($doc_no,$doc_ref)]<date("Y-m-d H:i:s"))
            { 
              
              echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$id\" style=\"font-size:12px; text-align:center; float:left; color:$id\" title=\"$title\" ><a href=\"".$fab_pop_details."?doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."\" onclick=\"Popup=window.open(".$fab_pop_details."'doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><span class='blink'>$emb_stat_title ".$req_time[array_search($doc_no,$doc_ref)]."</span></a></div></div><br/>";
            }
            else
            {
              echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$id\" style=\"font-size:12px; text-align:center; float:left; color:$id\" title=\"$title\" ><a href=\"".$fab_pop_details."?doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."\" onclick=\"Popup=window.open(".$fab_pop_details."'doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$emb_stat_title ".$req_time[array_search($doc_no,$doc_ref)]."</a></div></div><br/>";
            }
          }else{
              $id='orange';
              //Not Allowed
            if($username=='sfcsproject1'){

              //echo "orange : ".$req_date_time[array_search($doc_no,$doc_ref)]."-".date("Y-m-d H:i:s")."</br>";
              if($req_date_time[array_search($doc_no,$doc_ref)]<date("Y-m-d H:i:s"))
              {
                echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$id\" style=\"font-size:12px; text-align:center; float:left; color:$id\" title=\"$title\" ><a href='/sfcs/projects/Beta/production_planning/fab_pop_alert.php' onclick=\"Popup=window.open('/sfcs/projects/Beta/production_planning/fab_pop_alert.php','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><span class='blink'>$emb_stat_title ".$req_time[array_search($doc_no,$doc_ref)]."</span></a></div></div><br/>";
              }
              else
              {
                echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$id\" style=\"font-size:12px; text-align:center; float:left; color:$id\" title=\"$title\" ><a href='/sfcs/projects/Beta/production_planning/fab_pop_alert.php' onclick=\"Popup=window.open('/sfcs/projects/Beta/production_planning/fab_pop_alert.php','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$emb_stat_title ".$req_time[array_search($doc_no,$doc_ref)]."</a></div></div><br/>";
              }
            }else{
              //echo "Orange : ".$req_date_time[array_search($doc_no,$doc_ref)]."-".date("Y-m-d H:i:s")."</br>";
              if($req_date_time[array_search($doc_no,$doc_ref)]<date("Y-m-d H:i:s"))
              {
                echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$id\" style=\"font-size:12px; text-align:center; float:left; color:$id\" title=\"$title\" ><a href=\"".$fab_pop_details."?doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."\" onclick=\"Popup=window.open(".$fab_pop_details."'doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><span class='blink'>$emb_stat_title ".$req_time[array_search($doc_no,$doc_ref)]."</span></a></div></div><br/>";
              }
              else
              {
                echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$id\" style=\"font-size:12px; text-align:center; float:left; color:$id\" title=\"$title\" ><a href=\"".$fab_pop_details."?doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."\" onclick=\"Popup=window.open(".$fab_pop_details."'doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$emb_stat_title ".$req_time[array_search($doc_no,$doc_ref)]."</a></div></div><br/>";
              }
            }
          }
          
        }

      }
  }   

//echo "<div id=\"$id\" style=\"font-size:10px; text-align:center;\"><a href=\"pop_details.php?doc_no=$doc_no\" onclick=\"Popup=window.open('pop_details.php?doc_no=$doc_no"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">".$check_string."</a></div>"; 
      
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
  //RECUT
  
  /*echo '<div style="border: 3px coral solid; width: 80px; height: 650px; float: left; margin: 10px; padding: 10px; overflow: hidden;">';
  echo "<p>";
  echo "<table>";
  echo "<tr><th colspan=2><h2><a href=\"board_update.php?section_no=$section\" onclick=\"Popup=window.open('board_update.php?section_no=$section"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">RCut</a></h2></th></th></tr>";

  $mods=array();
  $mods=explode(",",$section_mods);

  for($x=0;$x<sizeof($mods);$x++)
  {
    
    $module=$mods[$x];
    
    
    echo "<tr class=\"bottom\">";

    echo "<td class=\"bottom\"><strong><a href=\"javascript:void(0)\" title=\"WIP : $wip\"><font class=\"fontnn\" color=orange >$module</font></a></strong></td><td>";
      
      
    $sql11="select * from recut_v2 where plan_module=$module and cut_inp_temp is null and remarks in (\"Body\",\"Front\")";
    $sql_result11=mysql_query($sql11,$link) or exit("Sql Error".mysql_error());
    $recut_count=mysql_num_rows($sql_result11);
    
      if($recut_count>0)
      {
          if((isset($_GET['view']) or isset($_GET['div'])) and $_GET['view']==2)
          {
            $view_cat_check=0;
            while($sql_row11=mysql_fetch_array($sql_result11))
            {
              $rec_doc_no=$sql_row11['doc_no'];
              $mk_ref=$sql_row11['mk_ref'];
              $fab_status=$sql_row11['fabric_status'];
              $act_cut_status=$sql_row11['act_cut_status'];
              $cut_inp=$sql_row11['cut_inp_temp'];
              //
              $req_date=$sql_row11['date'];
              $order_tid=$sql_row11['order_tid'];
              $source_conf_time=$sql_row11['lastup'];
              $total_qty=($sql_row11['a_xs']+$sql_row11['a_s']+$sql_row11['a_m']+$sql_row11['a_l']+$sql_row11['a_xl']+$sql_row11['a_xxl']+$sql_row11['a_xxxl']+$sql_row11['a_s06']+$sql_row11['a_s08']+$sql_row11['a_s10']+$sql_row11['a_s12']+$sql_row11['a_s14']+$sql_row11['a_s16']+$sql_row11['a_s18']+$sql_row11['a_s20']+$sql_row11['a_s22']+$sql_row11['a_s24']+$sql_row11['a_s26']+$sql_row11['a_s28']+$sql_row11['a_s30'])*$sql_row11['a_plies'];
  
              
              $sql111="select order_style_no,order_del_no,order_col_des from bai_orders_db_confirm where order_tid=\"$order_tid\"";
              $sql_result111=mysql_query($sql111,$link) or exit("Sql Error".mysql_error());
              while($sql_row111=mysql_fetch_array($sql_result111))
              {
                $style=$sql_row111['order_style_no'];
                $schedule=$sql_row111['order_del_no'];
                $color=$sql_row111['order_col_des'];
              }
              $title=str_pad("Style:".$style,80).str_pad("Schedule:".$schedule,80).str_pad("Color:".$color,80).str_pad("Total_Qty:".$total_qty,80).str_pad("Req_Time:".$req_date,80).str_pad("Source Conf. Time:".$source_conf_time,80);
              //
              
              $a=$b=$c=$d=$e=$f="";
              
              $id="white";
              if($mk_ref>0) { $a="T"; }else{ $a="F";  } //Marker Update
              if($fab_status>0) { $b="T"; }else{ $b="F";  } //fabric update
              if($fab_status==1 or $fab_status==5) {  $c="T"; }else{ $c="F";  } // fabric update
              if($fab_status==5) {  $d="T"; }else{ $d="F";  } // fabric available
              if($act_cut_status=="DONE") { $e="T"; }else{ $e="F";  } // cut completion status
              if($cut_inp==1) { $f="T"; }else{ $f="F";  } // cut completion status
              
              $test=$a.$b.$c.$d.$e.$f;
              
              $view_cat_temp=array();
              $view_cat_temp=explode(",",$_GET['view_cat']);
              
              $view_div_temp=array();
              $view_div_temp=explode(",",$_GET['view_div']);
              
              if((in_array($test,$view_cat_temp) or $_GET['view_cat']=="ALL") and (in_array(substr($style,0,1),$view_div_temp) or $_GET['view_div']=="ALL"))
              {
                $view_cat_check=1;
                break;
              }
              
            }
            
            if($view_cat_check==0)
            {
              echo "<div class=\"brown\"></div>";
            }
            else
            {
              $id="white";
            
              echo "<div class=\"$id\"><a href=\"fab_pps_recut_interface.php?module_ref=$module\" onclick=\"Popup=window.open('fab_pps_recut_interface.php?module_ref=$module"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><font color=red>$recut_count</font></a></div>";
            }
            
          }
          else
          {
            $id="white";
            
            echo "<div class=\"$id\"><a href=\"fab_pps_recut_interface.php?module_ref=$module\" onclick=\"Popup=window.open('fab_pps_recut_interface.php?module_ref=$module"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><font color=red>$recut_count</font></a></div>";
          }
          
            
        
      }
        
      else
      {
        for($i=0;$i<1;$i++)
        {
          echo "<div class=\"brown\"></div>";
        }
      }
      
      
      

        
    
    echo "</td>";
    echo "</tr>";
    
  }

  echo "</table>";
  echo "</p>";
  echo '</div>';*/
  
  //RECUT

}


//RECUT
  
  /*echo '<div style="border: 3px coral solid; width: 80px; height: 650px; float: left; margin: 10px; padding: 10px; overflow: hidden;">';
  echo "<p>";
  echo "<table>";
  echo "<tr><th colspan=2><h2><a href=\"board_update.php?section_no=$section\" onclick=\"Popup=window.open('board_update.php?section_no=$section"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">RCut <br/>EMB<br/>CUT<br/>TOP</a></h2></th></th></tr>";

  $mods=array("ENP","CUT","TOP");
  //$mods=explode(",",$section_mods);

  for($x=0;$x<sizeof($mods);$x++)
  {
    
    $module=$mods[$x];
    
    
    echo "<tr class=\"bottom\">";

    echo "<td>";
      
      
    $sql11="select * from recut_v2 where plan_module=\"$module\" and cut_inp_temp is null and remarks in (\"Body\",\"Front\")";
    $sql_result11=mysql_query($sql11,$link) or exit("Sql Error".mysql_error());
    $recut_count=mysql_num_rows($sql_result11);
    
      if($recut_count>0)
      {
        
          if(isset($_GET['view']) and $_GET['view']==2)
          {
            $view_cat_check=0;
            while($sql_row11=mysql_fetch_array($sql_result11))
            {
              $rec_doc_no=$sql_row11['doc_no'];
              $mk_ref=$sql_row11['mk_ref'];
              $fab_status=$sql_row11['fabric_status'];
              $act_cut_status=$sql_row11['act_cut_status'];
              $cut_inp=$sql_row11['cut_inp_temp'];
              //
              $req_date=$sql_row11['date'];
              $order_tid=$sql_row11['order_tid'];
              $source_conf_time=$sql_row11['lastup'];
              $total_qty=($sql_row11['a_xs']+$sql_row11['a_s']+$sql_row11['a_m']+$sql_row11['a_l']+$sql_row11['a_xl']+$sql_row11['a_xxl']+$sql_row11['a_xxxl']+$sql_row11['a_s06']+$sql_row11['a_s08']+$sql_row11['a_s10']+$sql_row11['a_s12']+$sql_row11['a_s14']+$sql_row11['a_s16']+$sql_row11['a_s18']+$sql_row11['a_s20']+$sql_row11['a_s22']+$sql_row11['a_s24']+$sql_row11['a_s26']+$sql_row11['a_s28']+$sql_row11['a_s30'])*$sql_row11['a_plies'];
  
              
              $sql111="select order_style_no,order_del_no,order_col_des from bai_orders_db_confirm where order_tid=\"$order_tid\"";
              $sql_result111=mysql_query($sql111,$link) or exit("Sql Error".mysql_error());
              while($sql_row111=mysql_fetch_array($sql_result111))
              {
                $style=$sql_row111['order_style_no'];
                $schedule=$sql_row111['order_del_no'];
                $color=$sql_row111['order_col_des'];
              }
              $title=str_pad("Style:".$style,80).str_pad("Schedule:".$schedule,80).str_pad("Color:".$color,80).str_pad("Total_Qty:".$total_qty,80).str_pad("Req_Time:".$req_date,80).str_pad("Source Conf. Time:".$source_conf_time,80);
              //
              
              $a=$b=$c=$d=$e=$f="";
              
              $id="white";
              if($mk_ref>0) { $a="T"; }else{ $a="F";  } //Marker Update
              if($fab_status>0) { $b="T"; }else{ $b="F";  } //fabric update
              if($fab_status==1 or $fab_status==5) {  $c="T"; }else{ $c="F";  } // fabric update
              if($fab_status==5) {  $d="T"; }else{ $d="F";  } // fabric available
              if($act_cut_status=="DONE") { $e="T"; }else{ $e="F";  } // cut completion status
              if($cut_inp==1) { $f="T"; }else{ $f="F";  } // cut completion status
              
              $test=$a.$b.$c.$d.$e.$f;
              
              $view_cat_temp=array();
              $view_cat_temp=explode(",",$_GET['view_cat']);
              
              if(in_array($test,$view_cat_temp) or $_GET['view_cat']=="ALL")
              {
                $view_cat_check=1;
                break;
              }
              
            }
            
            if($view_cat_check==0)
            {
              echo "<div class=\"brown\"></div>";
            }
            else
            {
              $id="white";
            
              echo "<div class=\"$id\"><a href=\"fab_pps_recut_interface.php?module_ref=$module\" onclick=\"Popup=window.open('fab_pps_recut_interface.php?module_ref=$module"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><font color=red>$recut_count</font></a></div>";
            }
            
          }
          else
          {
            $id="white";
            
            echo "<div class=\"$id\"><a href=\"fab_pps_recut_interface.php?module_ref=$module\" onclick=\"Popup=window.open('fab_pps_recut_interface.php?module_ref=$module"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><font color=red>$recut_count</font></a></div>";
          }
          
            
        
      }
        
      else
      {
        for($i=0;$i<1;$i++)
        {
          echo "<div class=\"brown\"></div>";
        }
      }
      
      
      
      

        
    
    echo "</td>";
    echo "</tr>";
    
  }

  echo "</table>";
  echo "</p>";
  echo '</div>';*/
  
  //To show section level priority only to RM-Fabric users only.
  //if((in_array(strtolower($username),$authorized)))
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
include('../'.getFullURLLevel($_GET['r'],'cps.htm',0,'R')); 
?>
<!-- </body>
</html> -->

<?php

((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res);
((is_null($___mysqli_res = mysqli_close($link_new))) ? false : $___mysqli_res);
//mysql_close($link_new2);

?>