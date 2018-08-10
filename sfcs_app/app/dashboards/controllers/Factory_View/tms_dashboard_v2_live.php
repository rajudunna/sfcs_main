<!--
Core Module:In this interface we can get module wise trims allocation details.

Description: We can see the trims availability status.

Changes Log:
2014-02-08/kirang/Ticket #424781 change the display buyer name as per plan_modules table.
2014-02-08/kirang/Ticket #688771 Display IU modues Priorit boxes with "IU" Symbol , if it is emblishment display "IX".

2014-08-29/kirang/ Added orange Color for partial inputs and prepared the trims re	question system for issuing the trims based on priority	

2014-09-02/ kirang / CR:160 / Need to display the Partial Input

2014-12-01/ kirang / CR# 182/ Need to display the IU modules based on the status of dbconf file. 
							 // for speed_delivery schedules (100% cut)
-->
<?php
set_time_limit(200000);
error_reporting(0);
include("../../../../common/config/config.php");
$double_modules=array();
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);
$authorized=array("kirang","sfcsproject1");//production
$authorized1=array("kirang","sfcsproject1","kishorek","sarojiniv","ravipu","ramanav","sekhark","ganeshb","pithanic","duminduw","kirangs","apparaop","satyako","rameshv","sekhark","sunithau","kirang","kirang","shanmukharaop","vijayadurgag","chirikis","gunakararaor");//trim
?>

<html>
<head>
<?php

	echo '<META HTTP-EQUIV="refresh" content="30">';	
?>
<script type="text/javascript" src="../../../../common/js/jquery.min.js"></script>


<?php

$special_users=array("kirang","kirang","sfcsproject1");
if(!in_array($username,$special_users))
{
	echo '<script>
	var ctrlPressed = false;
	$(document).keydown(function(evt) {
	  if (evt.which == 17 || evt.which == 13) { // ctrl
	    ctrlPressed = true;
		alert("This key has been disabled.");
	  }
	}).keyup(function(evt) {
	  if (evt.which == 17) { // ctrl
	    ctrlPressed = false;
	  }
	});
	
	$(document).click(function() {
	  if (ctrlPressed) {
	    // do something
		//alert("Test");
	  } else {
	    // do something else
	  }
	});
	</script>';
}

?>

<script>

function redirect_view()
{
	x=document.getElementById('view_cat').value;
	y=document.getElementById('view_div').value;
	var ajax_url = "fab_pps_dashboard_v2.php?view=2&view_cat="+x+"&view_div="+y;
	Ajaxify(ajax_url);

}

function redirect_dash()
{
	//x=document.getElementById('view_cat').value;
	//y=document.getElementById('view_div').value;
	z=document.getElementById('view_dash').value;
	//window.location = "fab_pps_dashboard_v2.php?view="+z+"&view_cat="+x+"&view_div="+y;
	var ajax_url = "fab_pps_dashboard_v2.php?view="+z;
	Ajaxify(ajax_url);

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
	//	alert("Your request is doesnt exist");
	//}
}

function blink_new3(x)
{
	
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
	//	alert("Your request is doesnt exist");
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
	//	alert("Your request is doesnt exist");
	//}
}

function blink_new_priority(x)
{
	var temp=x.split(",");
	for(i=0;i<x.length;i++)
	{
		blink_new1(temp[i]);
	}
}

</script>


<style>
body
{
	background-color:#eeeeee;
	color: #000000;
	font-family: Trebuchet MS;
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

</style>


<style>

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
  margin: 2px; border: 1px solid black;
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
  margin: 2px; border: 1px solid black;
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
  background-color: #00ff00;
  display:block;
  float: left;
  margin: 2px; border: 1px solid black;
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
  background-color: #00ff00;
}

.lgreen {
  width:20px;
  height:20px;
  background-color: #339900;
  display:block;
  float: left;
  margin: 2px; border: 1px solid black;
 
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
  background-color: #339900;
  
}

.yellow {
  width:20px;
  height:20px;
  background-color: #ffff00;
  display:block;
  float: left;
  margin: 2px; border: 1px solid black;
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
  background-color: #ff00ff;
  display:block;
  float: left;
  margin: 2px; border: 1px solid black;
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
  width:20px;
  height:20px;
  background-color: #db8400;
  display:block;
  float: left;
  margin: 2px; border: 1px solid black;
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
  background-color: #db8400;
}

.blue {
  width:20px;
  height:20px;
  background-color: #15a5f2;
  display:block;
  float: left;
  margin: 2px; border: 1px solid black;
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
  margin: 2px; border: 1px solid black;
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
  margin: 2px; border: 1px solid black;
}

.brown {
  width:20px;
  height:20px;
  background-color: #333333;
  display:block;
  float: left;
  margin: 2px; border: 1px solid black;
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

</head>

<body>

<script language="JavaScript">
<!--

//Disable right mouse click Script
//By Maximus (maximus@nsimail.com) w/ mods by DynamicDrive
//For full source code, visit http://www.dynamicdrive.com

var message="Function Disabled!";

///////////////////////////////////
function clickIE4(){
if (event.button==2){
alert(message);
return false;
}
}

function clickNS4(e){
if (document.layers||document.getElementById&&!document.all){
if (e.which==2||e.which==3){
alert(message);
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

document.oncontextmenu=new Function("alert(message);return false")

// --> 
</script>

<?php


//echo "<font size=4>LIVE TRIMS STATUS DASHBOARD";
//echo "</font>";
//echo "<font color=yellow>Refresh Rate: 120 Sec. (ALPHA TESTING)</font>";
/*echo '<div style="position:fixed; right:0; top:20px;">Docket Track: <input type="text" onkeyup="blink_new(this.value)" size="10">&nbsp;&nbsp;&nbsp;
Schedule Track: <input type="text" onkeyup="blink_new3(this.value)" size="10"></div><br/>';*/
//echo '<strong><table class="new"><tr class="new" valign="middle"><td><div class="yash"></div>RM Not Updated</td><td><div class="red"></div>RM Not Available</td><td><div class="green"></div> RM Available</td><td><div class="blue"></div>RM in Pool</td><td>X Trims Requested</td><td><div class="yellow"></div>Under Transit</td></tr></table></strong>';

// for speed_delivery schedules
$speed_sch=array();
$sqlq= "SELECT speed_schedule FROM $bai_pro3.speed_del_dashboard";
$sql_result13=mysqli_query($link, $sqlq) or exit("sql error11".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row13=mysqli_fetch_array($sql_result13))
{
	$speed_sch[]=$sql_row13['speed_schedule'];
}

// for speed_delivery schedules
$speed_sch=array();
$sqlq= "SELECT speed_schedule FROM $bai_pro3.speed_del_dashboard";
$sql_result13=mysqli_query($link, $sqlq) or exit("sql error11".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row13=mysqli_fetch_array($sql_result13))
{
	$speed_sch[]=$sql_row13['speed_schedule'];
}

//For blinking priorties as per the section module wips
$bindex=0;
$blink_docs=array();
$sec_id_live=$_GET["sec_x"];
$sqlx="select * from $bai_pro3.sections_db where sec_id=$sec_id_live";
mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$section=$sql_rowx['sec_id'];
	$section_head=$sql_rowx['sec_head'];
	$section_mods=$sql_rowx['sec_mods'];

	echo '<div style="background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin: 10px; padding: 10px;">';
	echo "<p>";
	echo "<table>";
	echo "<tr><th colspan=2><h2><a href=\"javascript:void(0)\" onclick=\"Popup=window.open('trims_report.php?section=$section"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=890,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">TMS</a></h2></th></th></tr>";

	$mods=array();
	$mods=explode(",",$section_mods);
	
	//For Section level blinking
	$blink_minimum=0;
	

	for($x=0;$x<sizeof($mods);$x++)
	{
		$module=$mods[$x];
		$blink_check=0;
		
		$sql11="select sum(ims_qty-ims_pro_qty) as \"wip\" from $bai_pro3.ims_log where ims_mod_no=$module";
		 
		//echo "query=".$sql11;
		mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row11=mysqli_fetch_array($sql_result11))
		{
			$wip=$sql_row11['wip'];
		} 
		
		echo "<tr class=\"bottom\">";
		echo "<td class=\"bottom\"><strong><a href=\"javascript:void(0)\" title=\"WIP : $wip\"><font class=\"fontnn\" color=black >$module</font></a></strong></td><td>";
		$id="yash";
		$y=0;
		$sql="SELECT doc_ref,trims_status as stat,date(trims_req_time) as rtime FROM $bai_pro3.trims_dashboard WHERE trims_status!=4 and module=$module and date(plan_time) >=\"2013-01-09\" order by plan_time,priority,doc_ref+0";	
		
		
		
		//echo $sql;
		$result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($result))
		{
			if($y==4)
			{
				break;
			}
			
			$doc=$row["doc_ref"];
			$trims_statusx=$row["stat"];
			$trims_req_time=$row["rtime"];
			$title=$doc;
			
			$letter="";
			//$iustyle="IU";
			//include("header.php"); 
			$iustyle_show=$iustyle;
			if($trims_req_time!="0000-00-00")
			{
				$letter="X";
				$iustyle_show=substr($iustyle,0,1);
			}
			
			$order_tid="";
			$cut_nosx="";
			$cut_qty="";
			
			$sql2="SELECT order_tid as tid,acutno,(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies as qty FROM $bai_pro3.plandoc_stat_log WHERE doc_no=$doc";
		
		  /*   if($_GET["view_div"]=="ALL")
		{
			$sql2="SELECT order_tid as tid,acutno,(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s06+p_s08+p_s10+p_s12+p_s14+p_s16+p_s18+p_s20+p_s22+p_s24+p_s26+p_s28+p_s30)*p_plies as qty FROM plandoc_stat_log WHERE doc_no=$doc";
				//echo "query".$sql1; 
		}
		if($_GET["view_div"]=="P,K")
		{
			$sql2="SELECT order_tid as tid,acutno,(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s06+p_s08+p_s10+p_s12+p_s14+p_s16+p_s18+p_s20+p_s22+p_s24+p_s26+p_s28+p_s30)*p_plies as qty FROM plandoc_stat_log WHERE left(order_tid,1) in (\"P\",\"K\") and doc_no=$doc ";
		//	echo "query".$sql1; 
		}
		if($_GET["view_div"]=="L,O,G")
		{
			$sql2="SELECT order_tid as tid,acutno,(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s06+p_s08+p_s10+p_s12+p_s14+p_s16+p_s18+p_s20+p_s22+p_s24+p_s26+p_s28+p_s30)*p_plies as qty FROM plandoc_stat_log WHERE left(order_tid,1) in (\"L\",\"O\",\"G\") and doc_no=$doc ";
		//	echo "query".$sql1; 
		}
		if($_GET["view_div"]=="L,O")
		{
			$sql2="SELECT order_tid as tid,acutno,(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s06+p_s08+p_s10+p_s12+p_s14+p_s16+p_s18+p_s20+p_s22+p_s24+p_s26+p_s28+p_s30)*p_plies as qty FROM plandoc_stat_log WHERE left(order_tid,1) in (\"L\",\"O\") and (order_tid like \"%Z_%\" or order_tid like \"______Y_%\") and doc_no=$doc";
			//echo "query".$sql1; 
		}	
		*/
		
			$result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row2=mysqli_fetch_array($result2))
			{
				$order_tid=$row2["tid"];
				$cut_nosx=$row2["acutno"];
				$cut_qty=$row2["qty"];
			}
			
			if($order_tid=="")
			{
				continue;
			}
			$y=$y+1;
			
			$zeros="00";
	
			if($cut_nosx > 9)
			{
				$zeros="0";
			}
			
			//$sql1x="SELECT order_style_no as style,order_del_no as sch,order_col_des as col,st_status as sta,color_code FROM bai_orders_db WHERE order_tid=\"".$order_tid."\"";
			$sql1x="SELECT order_style_no as style,order_del_no as sch,order_col_des as col,st_status as sta,color_code FROM $bai_pro3.bai_orders_db WHERE REPLACE(order_tid,\" \",\"\")=REPLACE(\"$order_tid\",\" \",\"\")";
			//echo $sql1x."<BR>";
			$result1x=mysqli_query($link, $sql1x) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row1x=mysqli_fetch_array($result1x))
			{
				$style=$row1x["style"];
				$schedule=$row1x["sch"];
				$color=$row1x["col"];
				$trims_status=$row1x["sta"];
				//echo "Trims=".$trims_status."<br>";
				$color_codex=$row1x["color_code"];
			}
			
			$sqlq="select clubbing from $bai_pro3.cat_stat_log where order_tid like \"% $schedule$color%\"";
			//echo $sqlq;
			$resultq=mysqli_query($link, $sqlq) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rowq=mysqli_fetch_array($resultq))
			{
				$clubbing=$rowq["clubbing"];
			}
			//echo "Clu=".$clubbing;
			unset($club_c_code);
			unset($club_docs);
			$club_c_code=array();
			$club_docs=array();
			$colors_db=array();
			
			if($clubbing>0)
			{
				$total_qty=0;
				$sql11="select order_col_des,color_code,doc_no,(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies as total from $bai_pro3.order_cat_doc_mk_mix where category in ('".implode("','",$in_categories)."') and order_del_no=$schedule and clubbing=".$clubbing." and acutno=$cut_nosx";
				//echo $sql11;
				$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row11=mysqli_fetch_array($sql_result11))
				{
					$club_c_code[]=chr($sql_row11['color_code']).$zeros.$cut_nosx;
					$club_docs[]=$sql_row11['doc_no'];
					$total_qty+=$sql_row11['total'];
					$colors_db[]=trim($sql_row11['order_col_des']);
				} 
			}
			else
			{
				$colors_db[]=$color;
				$club_c_code[]=chr($color_codex).$zeros.$cut_nosx;
				$club_docs[]=$doc;
				$total_qty=$cut_qty;
			}
			
			$colors_db=array_unique($colors_db);
			$club_c_code=array_unique($club_c_code);
			$club_docs=array_unique($club_docs);
			
			$id="yash";
			
			if($trims_status=="(NULL)" || $trims_status=="")
			{
				$id="yash";
			}			
			else if($trims_status == 0 || $trims_status == 9)
			{
				$id="red";
			}			
			else if($trims_status == 1)
			{
				$id="green";
			}			
			else
			{
				$id="red";
			}
			
			if($trims_statusx == 0 && $trims_req_time!="0000-00-00")
			{
				$id="lgreen";
			}				
				
			if($trims_statusx == 1)
			{
				$id="yellow";
			}
			
			if($trims_statusx == 2)
			{
				$id="blue"; 
			}
			
			if($trims_statusx == 3)
			{
				$id="orange"; 
			}
			
			
			$doc_no=$doc;
			// start for partial Cutting 
			$id_temp=partial_cut_color($doc_no,$link);
		/*	
			if($id_temp=="orange")
			{
				$id="orange";
			}*/
			if($id_temp=="false" or $id_temp=="")
			{
				
			}
			else
			{
				$id=$id_temp;
			}
			// close for partial cutting
			
			$firststy=substr($order_tid,0,strpos($order_tid," "));
			//echo "status=".$trims_statusx;
			
			//$letter.=$trims_statusx.$trims_status;
			//$title=str_pad("Style:".trim($style),80)."\n".str_pad("Schedule:".$schedule,80)."\n".str_pad("Color:".$color,80)."\n".str_pad("Job_No:".chr($color_codex).$zeros.$cut_nosx,80)."\n".str_pad("Total_Qty:".$cut_qty,80)."\n".str_pad("Log_Time:".$trims_req_time,80);
			
			$title=str_pad("Style:".$style,80).str_pad("Schedule:".$schedule,80).str_pad("Color:".implode(",",$colors_db),80).str_pad("Job_No:".implode(", ",$club_c_code),80).str_pad("Total_Qty:".$total_qty,80);
			
	//		Ticket #688771 Display IU modues Priorit boxes with "IU" Symbol.
			$sql12="select order_style_no as style from $bai_pro3.bai_orders_db where order_tid in (SELECT order_tid FROM $bai_pro3.plandoc_stat_log where doc_no=$doc and (order_tid like \"L%Y%\" or order_tid like \"L%Z%\" or order_tid like \"O%Y%\" or order_tid like \"O%Z%\")) and (order_style_no like \"L%Y%\" or order_style_no like \"L%Z%\" or order_style_no like \"O%Y%\" or order_style_no like \"O%Z%\")";
		
			mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$check_num_rows=mysqli_num_rows($sql_result12);		
		    while($sql_row12=mysqli_fetch_array($sql_result12))
			{
				$sel_sty=$sql_row12['style'];
			}		
		
		$secondsty=substr($sel_sty,0,strpos($sel_sty," "));
		//echo  $firststy."-".$secondsty." ";
		//if($check_num_rows>0 && $firststy==$secondsty)
		
		if(($check_num_rows>0 && $firststy==$secondsty)||in_array($schedule,$speed_sch))
		{
			$emb_style= $iustyle_show."".$letter;
				
		}
		else
		{
			$emb_style= $letter;
		}			
			
				if(in_array($username,$authorized1))
				{
					//echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc\" style=\"float:left;\"><div id=\"$doc\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id\" title=\"$title\" ><a href=\"trims_status_update.php?module=$module&section=$section&doc_no=$doc\" onclick=\"Popup=window.open('trims_status_update.php?module=$module&section=$section&doc_no=$doc','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><font style=\"color:black;\">$emb_style</font></a></div></div></div>";
					echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc\" style=\"float:left;\"><div id=\"$doc\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id\" title=\"$title\" ><a href=\"trims_requestion.php?module=$module&section=$section&doc_no=$doc\" onclick=\"Popup=window.open('trims_requestion.php?module=$module&section=$section&doc_no=$doc','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><font style=\"color:black;\">$emb_style</font></a></div></div></div>";
				}
				//else if(in_array($username,$authorized))
				else
				{
					echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc\" style=\"float:left;\"><div id=\"$doc\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id\" title=\"$title\" ><a href=\"trims_requestion.php?module=$module&section=$section&doc_no=$doc\" onclick=\"Popup=window.open('trims_requestion.php?module=$module&section=$section&doc_no=$doc','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><font style=\"color:black;\">$emb_style</font></a></div></div></div>";
				}
		
			
			/*else
			{
				echo "<div id=\"$doc\" style=\"float:left;\"><div id=\"$doc\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id\" title=\"$title\" >$letter</div></div>";
			}*/		
			//$id="";
		}
		//Ticket #424781 change the display buyer name as per plan_modules table.
		$sqly="select buyer_div from $bai_pro3.plan_modules where module_id=$module";
		//echo $sqly."<br>";
		mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowy=mysqli_fetch_array($sql_resulty))
		{
			$buyer_div=$sql_rowy['buyer_div'];
			
			if(substr($buyer_div,0,1)=="M")
			{
				$cut_wip_control=7000;
			}		
		}
		for($j=$y+1;$j<=4;$j++)
		{
			echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc\" style=\"float:left;\"><div id=\"$doc\" class=\"White\" style=\"font-size:12px; text-align:center; color:white\"></div></div></div>";
			
		}
		//echo substr($style,0,1);
		echo substr($buyer_div,0,1);
		echo "</td>";
		echo "</tr>";
	}
	
	//Blinking at section level
	$bindex++;

	echo "</table>";
	echo "</p>";
	echo '</div>';
}

?>
<div style="clear: both;"> </div>
</body>
</html>