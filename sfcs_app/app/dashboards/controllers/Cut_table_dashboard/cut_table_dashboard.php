<?php
$double_modules=array();
include($_SERVER['DOCUMENT_ROOT'].'template/helper.php');
$php_self = explode('/',$_SERVER['PHP_SELF']);
array_pop($php_self);
$url_r = base64_encode(implode('/',$php_self)."/cut_table_dashboard.php");
$has_permission=haspermission($url_r); 
$dash='CTD';
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


$sqlx="select * from $bai_pro3.tbl_cutting_table where tbl_id>0 and status='active'";
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_resultx) > 0){
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
     $section_mods=$sql_rowx['tbl_id'];
    $emb_tbl_name=$sql_rowx['tbl_name'];
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
 $sql1d="SELECT tbl_id as modx from $bai_pro3.tbl_cutting_table where tbl_id in (".$section_mods.") order by tbl_id*1";
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
   
    $sql2="select * from $bai_pro3.cutting_table_plan where cutting_tbl_id in (".$section_mods.") group by doc_no order by log_time,cutting_tbl_id";
    $result2=mysqli_query($link, $sql2) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row2=mysqli_fetch_array($result2))
    {
      $doc_no_ref[]=$row2['doc_no'];
      $doc_no=$row2['doc_no'];
      //$req_time[]=date("M-d H:i",strtotime($row2['log_time']));
      // $lay_time[]=$row2['log_time'];   
  }

   
  // start style wise display by dharani 10-26-2013 
  
    $sql1="SELECT * from $bai_pro3.cut_tbl_dash_doc_summ where doc_no in (select doc_ref from $bai_pro3.fabric_priorities where doc_ref in (".implode(",",$doc_no_ref).")) and act_cut_status<>'DONE' and fabric_status_new !='5' order by field(doc_no,".implode(",",$doc_no_ref).")";
  
      //echo $_GET["view_div"];
      if($_GET["view_div"] == 'M')
      {
        $_GET["view_div"] = "M&S";
      }
      $leter = str_split($_GET["view_div"]);
    
       if($_GET["view_div"]=="ALL" or $_GET["view_div"]=="")
      {
        $sql1="SELECT * from $bai_pro3.cut_tbl_dash_doc_summ where doc_no in (select doc_ref from $bai_pro3.fabric_priorities where doc_ref in (".implode(",",$doc_no_ref).")) and act_cut_status<>'DONE' and fabric_status_new !='5' order by field(doc_no,".implode(",",$doc_no_ref).")";
      }
      else
      {
        $dashe = $_GET["view_div"];
        $sql_qry = "select * from $bai_pro2.buyer_codes where buyer_name =".'"'.$dashe.'"';
        
        $res = mysqli_query($link, $sql_qry);
        $sql_count_check = mysqli_num_rows($res);
        
        while($row_res = mysqli_fetch_array($res))
        {
          $buyer_identity = $row_res['buyer_name'];
        }
          
        $sql1="SELECT * from $bai_pro3.cut_tbl_dash_doc_summ where order_style_no  in (select order_style_no from $bai_pro3.bai_orders_db_confirm where order_div = ".'"'.$buyer_identity.'"'.") and doc_no in (select doc_ref from $bai_pro3.fabric_priorities where doc_ref in (".implode(",",$doc_no_ref).")) and act_cut_status<>'DONE' and fabric_status_new !='5' order by field(doc_no,".implode(",",$doc_no_ref).")"; 
        
      }
      
  // close style wise display 
    //NEw check
    $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    // echo $sql1."<br>";
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
        
        // $fabric_status=$sql_row1['ft_status'];
        $ft_status=$sql_row1['ft_status'];

        if($ft_status==5)
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
       $sql10="select doc_ref,req_time from $bai_pro3.fabric_priorities where doc_ref ='$doc_no' order by req_time asc";
		$result21=mysqli_query($link, $sql10) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		 
		while($row21=mysqli_fetch_array($result21))
		{
		  $req_time=date("M-d h:ia",strtotime($row21['req_time']));
		  $req_date_time=$row21['req_time'];
		  
		}
      
      
      $sql11="select sum(ims_pro_qty) as 'bac_qty', sum(emb) as 'emb_sum' from (SELECT ims_pro_qty, if(ims_status='EPR' or ims_status='EPS',1,0) as 'emb' FROM $bai_pro3.ims_log where ims_log.ims_doc_no=$doc_no UNION ALL SELECT ims_pro_qty, if(ims_status='EPR' or ims_status='EPS',1,0) as 'emb' FROM $bai_pro3.ims_log_backup WHERE ims_log_backup.ims_mod_no<>0 and ims_log_backup.ims_doc_no=$doc_no) as t";
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
        $sql11="select ft_status from $bai_pro3.bai_orders_db_confirm where order_del_no='$schedule' and $order_joins_in_2";
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
          
          // $fabric_status=$join_ft_status;
          $ft_status=$join_ft_status;

        }
        //To get the status of join orders
      }
      //NEW FSP
      switch ($fabric_status)
      {
        case "1":
        {
            $id="yellow";
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
      if($fabric_status==1 and $ft_status==1)
      {
            $id="yellow";
      }

      if($fabric_status!=1 and $ft_status==1)
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
        if(strtolower($remarks) == 'recut'){
          $cut_str = 'R';
          $id = 'pink';
        }else
          $cut_str = chr($sql_row1['color_code']);

        $colors_db[]=$color;
        $club_c_code[]=$cut_str.''.leading_zeros($sql_row1['acutno'],3);
        $club_docs[]=$doc_no;
      }
      
      $fabric_required=0;
      $cat_yy=0;
      $sql11="select catyy,material_req from $bai_pro3.order_cat_doc_mk_mix where category in ('".implode("','",$in_categories)."') and order_del_no='$schedule' and order_col_des='$color' and doc_no=".$sql_row1['doc_no'];
      //echo $sql11."<br>";
      $sql_result111=mysqli_query($link, $sql11) or exit("Sql Error123".mysqli_error($GLOBALS["___mysqli_ston"]));
      while($sql_row111=mysqli_fetch_array($sql_result111))
      {
        $fabric_required+=$sql_row111['material_req'];
        //echo "Test=".$fabric_required."<br>";
        $cat_yy+=$sql_row111['catyy'];
      }   
      
      $order_total_qty=0;
      $sql111="select order_s_xs+order_s_s+order_s_m+order_s_l+order_s_xl+order_s_xxl+order_s_xxxl+order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50 as total from $bai_pro3.bai_orders_db_confirm where order_del_no='$schedule' and order_col_des='$color'";        
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
          
    $title=str_pad("Style:".trim($style),80)."\n".str_pad("CO:".trim($co_no),80)."\n".str_pad("Schedule:".$schedule,80)."\n".str_pad("Color:".trim(implode(",",$colors_db)),50)."\n".str_pad("Cut Job_No:".implode(", ",$club_c_code),80)."\n".str_pad("Docket No:".implode(", ",$club_docs),80)."\n".str_pad("Total_Qty:".$total_qty,80)."\n".str_pad("Plan_Time:".$log_time,50)."\n".str_pad("Lay_Req_Time:".$lay_time[array_search($doc_no,$doc_no_ref)],80)."\n".str_pad("Fab_Loc.:".$fabric_location."Bundle_Loc.:".$bundle_location,80);
    
    
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
    

      if($lay_time[array_search($doc_no,$doc_no_ref)]<date("Y-m-d H:i:s"))
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
    $sqlt="SELECT * from $bai_pro3.cut_tbl_dash_doc_summ where  doc_no in ($doc_no) and act_cut_issue_status<>'DONE' and (order_style_no like 'L%Y%' or order_style_no like 'L%Z%' or order_style_no like 'O%Y%' or order_style_no like 'O%Z%') order by field(doc_no,$doc_no) " ;
    //echo "query=".$sqlt;
    mysqli_query($link, $sqlt) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql_result12=mysqli_query($link, $sqlt) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    $check_num_rows=mysqli_num_rows($sql_result12);   
     
    while($sql_row12=mysqli_fetch_array($sql_result12))
    {
      $sel_sty=$sql_row12['order_style_no'];
      $sel_sch=$sql_row12['order_del_no'];      
    }


    $fab_pop_details = getFullURLLevel($_GET['r'],'cps/fab_pop_details.php',1,'R');
    $fab_pop_details1 = getFullURLLevel($_GET['r'],'cps/fab_pop_alert.php',1,'R');
  if($check_num_rows>0 && $ord_style==$sel_sty)
  {

      if($id=="blue")
      {
        echo "<div id='$doc_no' class='$id' style='font-size:12px; text-align:center; float:left;' title='$title' >$iustyle $emb_stat_title</div>"; 
      }
      else
      {
        // Ticket #177328 / compare the req_time with current date and time for Blinking Option for Exceeding Fabric Request Dockets
        //echo "blue1 : ".$req_date_time[array_search($doc_no,$doc_no_ref)]."-".date("Y-m-d H:i:s")."</br>";
        if($req_date_time<date("Y-m-d H:i:s"))
        { 
          echo "<div id='S$schedule' style='float:left;'><div id='$doc_no' class='$id' style='font-size:12px; text-align:center; float:left; color:$id' title='$title' ><a href='fab_pop_details.php?doc_no=$doc_no&dash=$dash&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."' onclick='Popup=window.open('fab_pop_details.php?doc_no=$doc_no&dash=$dash&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;'><span class='blink'>".$req_time." (".$iustyle."".$emb_stat_title.")</span></a></div></div><br/>";
        }
        else
        {
          echo "<div id='S$schedule' style='float:left;'><div id='$doc_no' class='$id' style='font-size:12px; text-align:center; float:left; color:$id' title='$title' ><a href='".$fab_pop_details."?doc_no=$doc_no&dash=$dash&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."' onclick='Popup=window.open('fab_pop_details.php?doc_no=$doc_no&dash=$dash&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;'>".$req_time." (".$iustyle."".$emb_stat_title.")</a></div></div><br/>";
        }
      }
  }
  else
  {
    
      if($id=="blue")
      {
        echo "<div id='$doc_no' class='$id' style='font-size:12px; text-align:center; float:left;' title='$title' >$emb_stat_title</div>"; 
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
            echo "<div id='S$schedule' style='float:left;'><div id='$doc_no' class='$id' style='font-size:12px; text-align:center; float:left; color:$id' title='$title' ><a href='".$fab_pop_details."?doc_no=$doc_no&dash=$dash&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."' onclick='Popup=window.open('fab_pop_details.php?doc_no=$doc_no&dash=$dash&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;'><span class='blink'>$emb_stat_title ".$req_time."</span></a></div></div><br/>";
          }
          else
          {
            echo "<div id='S$schedule' style='float:left;'><div id='$doc_no' class='$id' style='font-size:12px; text-align:center; float:left; color:$id' title='$title' ><a href='".$fab_pop_details."?doc_no=$doc_no&dash=$dash&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."' onclick='Popup=window.open(".$fab_pop_details."'doc_no=$doc_no&dash=$dash&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;'>$emb_stat_title ".$req_time."</a></div></div><br/>";
          }
        }
        else if($id=="green")
        {   
          //echo "Thick Green</br>";
          //echo "Thick Green :".$req_date_time[array_search($doc_no,$doc_no_ref)]."-".date("Y-m-d H:i:s")."</br>"; 
          if($req_date_time<date("Y-m-d H:i:s"))
          {
          echo "<div id='S$schedule' style='float:left;'><div id='$doc_no' class='$id' style='font-size:12px; text-align:center; float:left; color:$id' title='$title' ><a href='".$fab_pop_details."?doc_no=$doc_no&dash=$dash&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."' onclick='Popup=window.open(".$fab_pop_details."'doc_no=$doc_no&dash=$dash&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;'><span class='blink'>$emb_stat_title ".$req_time."</span></a></div></div><br/>";
          }
          else
          {
            echo "<div id='S$schedule' style='float:left;'><div id='$doc_no' class='$id' style='font-size:12px; text-align:center; float:left; color:$id' title='$title' ><a href='".$fab_pop_details."?doc_no=$doc_no&dash=$dash&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."' onclick='Popup=window.open(".$fab_pop_details."'doc_no=$doc_no&dash=$dash&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;'>$emb_stat_title ".$req_time."</a></div></div><br/>";
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
              echo "<div id='S$schedule' style='float:left;'><div id='$doc_no' class='$id' style='font-size:12px; text-align:center; float:left; color:$id' title='$title' ><a href='".$fab_pop_details."?doc_no=$doc_no&dash=$dash&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."' onclick='Popup=window.open(".$fab_pop_details."'doc_no=$doc_no&dash=$dash&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;'><span>$emb_stat_title ".$req_time."</span></a></div></div><br/>";
            }
            else
            {
              echo "<div id='S$schedule' style='float:left;'><div id='$doc_no' class='$id' style='font-size:12px; text-align:center; float:left; color:$id' title='$title' ><a href='".$fab_pop_details."?doc_no=$doc_no&dash=$dash&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."' onclick='Popup=window.open(".$fab_pop_details."'doc_no=$doc_no&&dash=$dashpop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;'>$emb_stat_title ".$req_time."</a></div></div><br/>";
            }
          }else{
              $id='orange';
              //Not Allowed
            if(in_array($authorized,$has_permission)){

              //echo "orange : ".$req_date_time[array_search($doc_no,$doc_no_ref)]."-".date("Y-m-d H:i:s")."</br>";
              if($req_date_time<date("Y-m-d H:i:s"))
              {
                echo "<div id='S$schedule' style='float:left;'><div id='$doc_no' class='$id' style='font-size:12px; text-align:center; float:left; color:$id' title='$title' ><a href='".$fab_pop_details1."' onclick='Popup=window.open(".$fab_pop_details1.",'Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;'><span class='blink'>$emb_stat_title ".$req_time."</span></a></div></div><br/>";
              }
              else
              {
                echo "<div id='S$schedule' style='float:left;'><div id='$doc_no' class='$id' style='font-size:12px; text-align:center; float:left; color:$id' title='$title' ><a href='".$fab_pop_details1."' onclick='Popup=window.open(".$fab_pop_details1.",'Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;'>$emb_stat_title ".$req_time."</a></div></div><br/>";
              }
            }else{
              //echo "Orange : ".$req_date_time[array_search($doc_no,$doc_no_ref)]."-".date("Y-m-d H:i:s")."</br>";
              if($req_date_time<date("Y-m-d H:i:s"))
              {
                echo "<div id='S$schedule' style='float:left;'><div id='$doc_no' class='$id' style='font-size:12px; text-align:center; float:left; color:$id' title='$title' ><a href='".$fab_pop_details."?doc_no=$doc_no&dash=$dash&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."' onclick='Popup=window.open(".$fab_pop_details."'doc_no=$doc_no&dash=$dash&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;'><span class='blink'>$emb_stat_title ".$req_time."</span></a></div></div><br/>";
              }
              else
              {
                echo "<div id='S$schedule' style='float:left;'><div id='$doc_no' class='$id' style='font-size:12px; text-align:center; float:left; color:$id' title='$title' ><a href='".$fab_pop_details."?doc_no=$doc_no&dash=$dash&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."' onclick='Popup=window.open(".$fab_pop_details."'doc_no=$doc_no&dash=$dash&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;'>$emb_stat_title ".$req_time."</a></div></div><br/>";
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