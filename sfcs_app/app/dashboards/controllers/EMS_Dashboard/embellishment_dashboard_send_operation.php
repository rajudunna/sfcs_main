
<!--
Core Module:This is to show priorities for fabric issuing as per the requests.

Changes Log:

2014-02-03/kirang/Ticket #976613 change the buyer division display based on the pink,logo,IU as per plan_modules
2014-03-05/kirang/Ticket #177328 add the Blinking Option for Exceeding Fabric Request Dockets and IU module show "IU" in that boxes and if it is emblishment display "IX"
-->
<?php
  $double_modules=array();
  include($_SERVER['DOCUMENT_ROOT'].'template/helper.php');
  $php_self = explode('/',$_SERVER['PHP_SELF']);
  array_pop($php_self);
  $url_r = base64_encode(implode('/',$php_self)."/embellishment_dashboard_send_operation.php");
  $has_permission=haspermission($url_r); 
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
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R')); 
set_time_limit(200000);
?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
<!-- <head> -->
<title>EMS Dashboard</title>
<link rel="stylesheet" href="../../../../common/css/bootstrap.min.css">
<?php
  $hour=date("H.i");
  echo '<META HTTP-EQUIV="refresh" content="120">';
?>
<script type="text/javascript" src="../../../../common/js/jquery.js"></script>
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

<script>

function redirect_view()
{
  //  x=document.getElementById('view_cat').value;
  y=document.getElementById('view_div').value;
  //window.location = "embellishment_dashboard.php?view=2&view_cat="+x+"&view_div="+y;
  window.location = "<?= getFullURL($_GET['r'],'embellishment_dashboard_send_operation.php','N') ?>"+"&view=2&view_div="+y;
  }

  function redirect_dash()
  {
  x=document.getElementById('view_cat').value;
  y=document.getElementById('view_div').value;
  z=document.getElementById('view_dash').value;
  window.location = "<?= getFullURL($_GET['r'],'embellishment_dashboard_send_operation.php','N') ?>"+"&view="+z+"&view_cat="+x+"&view_div="+y;
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
<script language="JavaScript">
<!--


var message="Function Disabled!";
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
$sqlx="select * from $bai_pro3.plan_dash_doc_summ where act_cut_issue_status='DONE'";
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

echo "<div class='panel-heading'><span style='float'><strong>EMB Send Dashboard</strong></a>
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
echo "<option value='".$buyer_name."' selected>".$buyer_div."</option>";  
} 
else 
{
echo "<option value='".$buyer_name."' >".$buyer_div."</option>"; 
}
}
echo '</select>';
echo '</div>';

echo '<br><br>';
//For blinking priorties as per the section module wips
$bindex=0;
$blink_docs=array();

$sqlx="select * from $bai_pro3.tbl_emb_table where emb_table_id>0";
mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
// $section=$sql_rowx['sec_id'];
// $section_head=$sql_rowx['sec_head'];
$section_mods=$sql_rowx['emb_table_id'];
$emb_tbl_name=$sql_rowx['emb_table_name'];

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
$url=getFullURLLevel($_GET['r'],'board_update.php',0,'R');
echo "<tr><th colspan=2'><center><h2><b>$emb_tbl_name</b></h2></center></th></tr>";

//For Section level blinking
$blink_minimum=0;


//for($x=0;$x<sizeof($mods);$x++)
{
$module=$mods[$x];
$blink_check=0;

echo "<tr class='bottom'><td>";

$cut_wip_control=3000;
$fab_wip=0;
$pop_restriction=0;
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

$sql2="select doc_no,log_time as req_time,module,log_time from $bai_pro3.embellishment_plan_dashboard where module in ($section_mods) and orginal_qty<>send_qty  order by log_time,module";
// echo $sql2;
$result2=mysqli_query($link, $sql2) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row2=mysqli_fetch_array($result2))
{
$doc_ref[]=$row2['doc_no'];
$req_time[]=$row2['module'].") ".date("M-d H:i",strtotime($row2['req_time']));
$lay_time[]=$row2['log_time'];
$req_date_time[]=$row2['req_time'];
}

// start style wise display by dharani 10-26-2013 

$sql1="SELECT * from $bai_pro3.plan_dash_doc_summ_embl where doc_no in (".implode(",",$doc_ref).") order by field(doc_no,".implode(",",$doc_ref).")";

//echo $_GET["view_div"];
if($_GET["view_div"] == 'M')
{
$_GET["view_div"] = "M&S";
}
$leter = str_split($_GET["view_div"]);

if($_GET["view_div"]=="ALL" or $_GET["view_div"]=="")
{
$sql1="SELECT * from $bai_pro3.plan_dash_doc_summ_embl where doc_no in (".implode(",",$doc_ref).")  order by field(doc_no,".implode(",",$doc_ref).")";
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

$sql1="SELECT * from $bai_pro3.plan_dash_doc_summ_embl where order_style_no  in (select order_style_no from $bai_pro3.bai_orders_db_confirm where order_div = ".'"'.$buyer_identity.'"'.") and doc_no in (".implode(",",$doc_ref).") order by field(doc_no,".implode(",",$doc_ref).")";         
}
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

$sql112="select co_no from $bai_pro3.bai_orders_db_confirm where order_del_no='$schedule' and order_col_des='$color'";
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
  $sql11="select ft_status from $bai_pro3.bai_orders_db_confirm where order_del_no='$schedule' and order_joins=2";
  $sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

  if(mysqli_num_rows($sql_result11)>0)
  {
    $sql11="select ft_status from $bai_pro3.bai_orders_db_confirm where order_joins='J$schedule'";
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


$id="yash";
if($cut_new=="DONE")
{
  $id="blue";
  $embscanurl = "www.google.com";
}else{
  $embscanurl = "#";
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
$sql11="select order_col_des,color_code,doc_no,material_req,(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies as total from $bai_pro3.order_cat_doc_mk_mix where order_del_no='$schedule' and clubbing=".$sql_row1['clubbing']." and acutno=".$sql_row1['acutno'];

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



$colors_db=array_unique($colors_db);
$club_c_code=array_unique($club_c_code);
$club_docs=array_unique($club_docs);

//$title=str_pad("Style:".trim($style),80).str_pad("Schedule:".$schedule,80).str_pad("Color:".trim(implode(",",$colors_db)),80).str_pad("Job_No:".implode(", ",$club_c_code),80).str_pad("Total_Qty:".$total_qty,80).str_pad("Log_Time:".$log_time,80).str_pad("Remarks:".$rem." / Bundle_Location:".$bundle_location,80);
$title=str_pad("Style:".trim($style),80)."\n".str_pad("CO:".trim($co_no),80)."\n".str_pad("Schedule:".$schedule,80)."\n".str_pad("Color:".trim(implode(",",$colors_db)),50)."\n".str_pad("Cut_No:".implode(", ",$club_c_code),80)."\n".str_pad("Total_Qty:".$total_qty,80)."\n".str_pad("Plan_Time:".$log_time,50)."\n";


$clr=trim(implode(',',$colors_db),50);

// if($id=="blue")
{
  echo "<div id='$doc_no' class='$id' style='font-size:12px;color:white; text-align:center; float:left;' title='$title'><a href=".$embscanurl.">$schedule(".implode(", ",$club_c_code).")</a></div><br>"; 
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

if((in_array($authorized,$has_permission)))
{
  echo "<script>";
  echo "blink_new_priority('".implode(",",$blink_docs)."');";
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
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'cps.htm',0,'R')); 
?>
<!-- </body>
</html> -->

<?php

((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res);
((is_null($___mysqli_res = mysqli_close($link_new))) ? false : $___mysqli_res);
//mysql_close($link_new2);

?>