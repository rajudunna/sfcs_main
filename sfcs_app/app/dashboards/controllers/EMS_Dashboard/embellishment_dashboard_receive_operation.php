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
<script>
$(document).ready(function() {
//Select all anchor tag with rel set to tooltip
$('a[rel=tooltip]').mouseover(function(e) {
  
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
   $('#tooltip').css('margin-left','50px' );
   $('#tooltip').css('text-align','left' );
   $('#tooltip').css('margin-top','20px' );
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
width:350px;
}
#tooltip {
position:absolute;
z-index:9999;
color:#fff;
font-size:12px;
width:220px;
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
  include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));  
  include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R')); 
  include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',4,'R')); 
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
  //echo '<META HTTP-EQUIV="refresh" content="120">';
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
function redirect_view()
{
  y=document.getElementById('view_div').value;
  window.location = "<?= getFullURL($_GET['r'],'embellishment_dashboard_receive_operation.php','N') ?>"+"&view=2&view_div="+y;
}

function redirect_dash()
{
  x=document.getElementById('view_cat').value;
  y=document.getElementById('view_div').value;
  z=document.getElementById('view_dash').value;
  window.location = "<?= getFullURL($_GET['r'],'embellishment_dashboard_receive_operation.php','N') ?>"+"&view="+z+"&view_cat="+x+"&view_div="+y;
}
function blink_new3(x)
{
	$("div[id='S"+x+"']").each(function() {
	
	$(this).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
	});
}
function blink_new(x)
{	
	$("div[id='D"+x+"']").each(function() {
	
	$(this).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
	});
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
a{
  text-decoration:none;
  color: white;
}

.orange {
  max-width:130px; min-width:20px;
  height:20px;
  background-color: #FFA500;
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
  background-color: #FFA500;
}

.red {
  max-width:130px; min-width:20px;
  height:20px;
  background-color:#FF0000;
  display:block;
  float: left;
  margin: 2px;
  border: 1px solid #000000;
  height: 25px;
  width: 250px;
  /* padding: 4px; */
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
  background-color:#FF0000;
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

</style>
<?php

echo "<div style='width=100%;'>"; 

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

echo "<div class='panel-heading'><span style='float'><strong>EMB Receive Dashboard</strong></a>
</span><span style='float: right; margin-top: 0px'><b>
<a href='javascript:void(0)' onclick='Popup=window.open('cps.htm"."','Popup',
'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); 
if (window.focus) {Popup.focus()} return false;'></a></b></span></div>";
echo '<div class="panel-body">
<div class="form-inline">';
echo '<div class="form-group">';
echo '&nbsp;&nbsp;&nbsp;Shift: 
  <select class="form-control" id="shift" name="shift">
  <option value="">Select</option>';
        $shifts = (isset($_GET['shift']))?$_GET['shift']:'';
        foreach($shifts_array as $shift){
          if($shift == $shifts){
            echo "<option value='$shift' selected>$shift</option>";
          }else{
             echo "<option value='$shift'>$shift</option>";
          }
         
        }
echo '</select>   
</div>
<div class="form-group">';
echo 'Docket Track: <input type="text" name="docket" id="docket" class="form-control" onkeyup="blink_new(this.value)" size="10">&nbsp;&nbsp;&nbsp;';
echo "</div>";
echo'<div class="form-group">';
echo 'Schedule Track: <input type="text" name="schedule" id="schedule" class="form-control" onkeyup="blink_new3(this.value)" size="10">';
echo "</div>";

echo'<div class="form-group">';
echo '&nbsp;&nbsp;&nbsp;Buyer Division: 
<select name="view_div" id="view_div" class="form-control" onchange="redirect_view()">';
if($_GET['view_div']=="ALL") 
{ 
  echo '<option value="ALL" selected>All</option>'; 
} 
else 
{ 
  echo '<option value="ALL">All</option>'; 
}
echo "</div>";
echo "</div>";

$sqly="SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code";
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
?>
<div>
    <div style="margin-top: 4px;border: 1px solid #000;float: left;background-color: #FFA500;color: white;margin-left: 10px;">
    <div>Partially Received from Embellishment</div>
    </div>&nbsp;&nbsp;&nbsp;
    <div style="margin-top: 4px;border: 1px solid #000;float: left;background-color: #999999;color: white;margin-left: 30px;">
    <div>Not Yet Received From Embellishment</div>
    </div>
    <div style="clear: both;"> </div>
</div>
<?php
//For blinking priorties as per the section module wips
$bindex=0;
$blink_docs=array();

$sqlx="select * from $bai_pro3.tbl_emb_table where emb_table_status = 'active' and emb_table_id>0";
mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{

  $section_mods=$sql_rowx['emb_table_id'];
  $emb_tbl_name=$sql_rowx['emb_table_name'];

  if($_GET["view_div"]!='ALL' && $_GET["view_div"]!='')
  {
    $buyer_division=urldecode($_GET["view_div"]);
    $buyer_division_ref='"'.str_replace(",",'","',$buyer_division).'"';
    $order_div_ref=" and buyer_div in (".$buyer_division_ref.")";
  }
  else 
  {
    $order_div_ref='';
  }

  $sql1d="SELECT emb_table_id as modx from $bai_pro3.tbl_emb_table where emb_table_status = 'active' and emb_table_id in (".$section_mods.") order by emb_table_id*1";
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
    $url=getFullURLLevel($_GET['r'],'board_update.php',0,'R');
    echo "<tr><th colspan=2'><center><h2><b>$emb_tbl_name</b></h2></center></th></tr>";

    $blink_minimum=0;
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
      $track_ids = [];

      $sql2="select doc_no,module,track_id from $bai_pro3.embellishment_plan_dashboard where module in ($section_mods) and send_qty > 0 and send_qty>receive_qty and receive_op_code>0 and short_shipment_status=0 order by log_time,module";
      $result2=mysqli_query($link, $sql2) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
      while($row2=mysqli_fetch_array($result2))
      {
          $doc_ref[]=$row2['doc_no'];
          $req_time[]=$row2['module'].") ".date("M-d H:i",strtotime($row2['req_time']));
          $track_ids[] = $row2['track_id'];
      }

      $sql1="SELECT * from $bai_pro3.plan_dash_doc_summ_embl where doc_no in (".implode(",",$doc_ref).") order by field(doc_no,".implode(",",$doc_ref).")";
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
      $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
      $sql_num_check=mysqli_num_rows($sql_result1);
      if($sql_num_check>0){
      while($sql_row1=mysqli_fetch_array($sql_result1))
      {
          $track_id=$sql_row1['track_id'];
           if(!in_array($track_id,$track_ids))
              continue;
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
          $total=$sql_row1['total'];
          
          
          $fabric_status=$sql_row1['fabric_status_new']; //NEW due to plan dashboard clearing regularly and to stop issuing issued fabric.
          if($fabric_status==null or $fabric_status==0)
          {
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

          $sql21="select orginal_qty,send_qty,receive_qty,send_op_code,receive_op_code from $bai_pro3.embellishment_plan_dashboard where doc_no='".$doc_no."' and track_id=$track_id and receive_op_code>0";
          // echo $sql2;
          $result21=mysqli_query($link, $sql21) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
          while($row21=mysqli_fetch_array($result21))
          {
            $orginal_qty=$row21['orginal_qty'];
            $send_qty=$row21['send_qty'];
            $receive_qty=$row21['receive_qty'];
            $send_op_code=$row21['send_op_code'];
            $receive_op_code=$row21['receive_op_code'];
          }
		  $reject_qty_s=0;
		  $reject_qty_r=0;
		  $sql221="select sum(rejected_qty) as rej_qty from $bai_pro3.rejection_log_child where doc_no=".$doc_no." and operation_id=$send_op_code";
          // echo $sql2;
          $result212=mysqli_query($link, $sql221) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
          while($row212=mysqli_fetch_array($result212))
          {
            $reject_qty_s=$row212['rej_qty'];            
          }
		$sql2212="select sum(rejected_qty) as rej_qty from $bai_pro3.rejection_log_child where doc_no=".$doc_no." and operation_id=$receive_op_code";
          // echo $sql2;
          $result2122=mysqli_query($link, $sql2212) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
          while($row2122=mysqli_fetch_array($result2122))
          {
            $reject_qty_r=$row2122['rej_qty'];            
          }
		if(($send_qty-$reject_qty_s)<> ($receive_qty))
		{		
          $id="yash";
          if($receive_qty==0)
          {
            $id="yash";   
          }
          
          if($orginal_qty!=$receive_qty && $receive_qty > 0)
          {
            $id="orange";
            
          }

          if($receive_qty>$send_qty)
          {
            $id="red";
          }
          //To get Encoded Color & style
          $main_style = style_encode($style);
          $main_color = color_encode($color);
          $page_flag = 'receive';
          $emb_url = getFullURLLevel($_GET["r"],'cutting/controllers/emb_cut_scanning/emb_cut_scanning.php',3,'N')."&style=$main_style&schedule=$schedule&color=$main_color&tablename=$section_mods&doc_no=$doc_no&operation_id=$receive_op_code&page_flag=$page_flag";

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

          $title=str_pad("Style:".trim($style),80)."</br>".str_pad("CO:".trim($co_no),80)."</br>".str_pad("Schedule:".$schedule,80)."</br>".str_pad("Color:".trim(implode(",",$colors_db)),50)."</br>".str_pad("Cut_No:".implode(", ",$club_c_code),80)."</br>".str_pad("DOC No:".implode(", ",$club_docs),80)."</br>".str_pad("Total Plan Qty:".$orginal_qty,80)."</br>".str_pad("Actual Cut Qty:".$total,80)."</br>".str_pad("Send Qty:".($send_qty-$reject_qty_s),80)."</br>".str_pad("Received Qty:".($receive_qty-$reject_qty_r),80)."</br>".str_pad("Rejected Qty:".$reject_qty_r,80)."</br>".str_pad("Plan_Time:".$log_time,50)."</br>";

          $clr=trim(implode(',',$colors_db),50);
          
          if($send_qty > 0)
          {            
            echo "<a onclick=\"loadpopup('$emb_url')\" style='cursor:pointer;' data-title='$title' rel='tooltip'><div id=\"S$schedule\" style=\"float:left;\"><div id='D$doc_no' class='$id' style='font-size:12px;color:white; text-align:center; float:left;'>$schedule(".implode(", ",$club_c_code).")-OP:$receive_op_code</div></div></a><br>"; 
          }          
        }
		}
      }   
      echo "</td>";
      echo "</tr>";
    }
    echo "</div>";  
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
?>

<div style="clear: both;"> </div>
</br>
<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'cps.htm',0,'R')); 
?>

<?php
  ((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res);
  ((is_null($___mysqli_res = mysqli_close($link_new))) ? false : $___mysqli_res);
?>

<script>
function loadpopup(url){ 
  var shift = document.getElementById('shift').value;
  if(shift){
    url = url+'&shift='+shift;
    window.open(url,'Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=auto, top=23'); if (window.focus) {Popup.focus()} return false;
  }else{
        swal({
                title: "Warning!",
                text: "Please select shift",
                type: "warning"
            }).then(function() {
                // window.close();
            });
  }
}
setTimeout(function(){
   var shift = document.getElementById('shift').value; 
   var url = window.location.href+'&shift='+shift;
    if(shift){
      window.location.href = url;    
    }
   }, 120000);
</script>