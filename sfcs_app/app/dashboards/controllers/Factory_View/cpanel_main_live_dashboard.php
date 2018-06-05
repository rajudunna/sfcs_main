<!--

Ticket #504203/KiranG
Added Tool tip/Dashboard Representation as per the proposal.
Excluded Excess Panel Reported Modules

Ticket #376109/Kirang - 2014-9-13
Changed filter critier where included TTT to cover all failure cases.

Service Request #350284 /kirang - 2015-04-17
Modify the IMS modules priorities based on plan modules. 
-->
<?php
include ("../../../../common/config/config.php");
include ("../../../../common/config/functions.php");
//$view_access=user_acl("SFCS_0203",$username,1,$group_id_sfcs); 
?>
<?php

//To find time days difference between two dates

function dateDiff($start, $end) {

$start_ts = strtotime($start);

$end_ts = strtotime($end);

$diff = $end_ts - $start_ts;

return round($diff / 86400);

}


function dateDiffsql($link,$start,$end)
{
	$sql="select distinct bac_date from $bai_pro.bai_log_buf where bac_date<='$start' and bac_date>='$end'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	return mysqli_num_rows($sql_result);
}



?>


<?php
$double_modules=array();
set_time_limit(2000);
?>

<html>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<head>
<!-- <META HTTP-EQUIV="refresh" content="300; URL=timeout.php"> -->

<?php

$upated=echo_title("bai_pro3.ims_log","MAX(ims_log_date)","1","1",$link);	

?>


<script>
function blink_new(x)
{
	//alert(x);
	//obj="#"+x;
	
	
	$("div[id='M"+x+"']").each(function() {
	
	$(this).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
	});
}

function blink_new3_v2(x)
{
	//alert("Hi");	
	//alert(x);
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

function blink_new3(x)
{
	//alert("Hi");	
	//alert(x);
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
	background-color:#EEEEEE;
	color: #000000;
	font-family: Arial;
	
}
a {text-decoration: none; color:#000000;}

table
{
	border-collapse:collapse;
}
.new td
{
	border: 1px solid #000000;
	white-space:nowrap;
	border-collapse:collapse;
}

.new th
{
	border: 1px solid red;
	white-space:nowrap;
	border-collapse:collapse;
}

.bottom
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
	color: white;
}
#active {
  width:20px;
  height:20px;
  background-color: #00FF11;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

#active a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#active a:hover {
  text-decoration:none;
  background-color: #00FF11;
}

#down {
  width:20px;
  height:20px;
  background-color: #FF0000;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}



#down a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
  text-align:center;
}

#downdark {
  width:20px;
  height:20px;
  background-color: #fda006;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}



#downdark a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
  text-align:center;
}

#floorset {
  width:20px;
  height:20px;
  background-color: #ff00ff;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}



#floorset a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
  text-align:center;
}

#floorsetdark {
  width:20px;
  height:20px;
  background-color: #ee00ee;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}



#floorsetdark a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
  text-align:center;
}


#yash {
  width:20px;
  height:20px;
  background-color: #c0c0c0;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}



#yash a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
  text-align:center;
}

#down a:hover {
  text-decoration:none;
  background-color: #FF0000;
}

#speed {
  width:20px;
  height:20px;
  background-color: #0080ff;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}



#speed a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
  text-align:center;
}

#speeddark {
  width:20px;
  height:20px;
  background-color: #0054a8;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}



#speeddark a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
  text-align:center;
}

#speed a:hover {
  text-decoration:none;
  background-color: #0080ff;
}


#wait {
  width:20px;
  height:20px;
  background-color: #FFFF00;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

#wait a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#wait a:hover {
  text-decoration:none;
  background-color: #FFFF00;
}



</style>


<style>

a{
	text-decoration:none;
	color: white;
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
  background-color: #ff3333;
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
  background-color: #ff3333;
}

.green {
  width:20px;
  height:20px;
  background-color: #00ff00;
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
  background-color: #00ff00;
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
  background-color: #ff99ff;
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
  background-color: #ff99ff;
}

.orange {
  width:20px;
  height:20px;
  background-color: #ff9933;
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
  background-color: #ff9933;
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
border: 1px solid black;
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

#page_heading{
    width: 100%;
    height: 25px;
    color: WHITE;
    background-color: #29759c;
    z-index: -999;
    font-family:Arial;
    font-size:15px;  
	margin-bottom: 10px;
}

#page_heading h3{
	vertical-align: middle;
	margin-left: 15px;
	margin-bottom: 0;	
	padding: 0px;
 }

#page_heading img{
    margin-top: 2px;
    margin-right: 15px;
}

<?php

//More than 3 days (T), Quality 0.8% above (T), <=Today Exfactory (T)
//class color codes
$css_type=array(".",".",".",".",".",".",".","#","#","#","#","#","#","#","#","#");
$cc_codes=array("red","green","yellow","pink","orange","blue","yash","active","down","floorset","yash","speed","wait","downdark","speeddark","floorsetdark");
//class color
$cc_col_codes=array("#ff3333","#00ff00","#ffff00","#ff99ff","#ff9933","#15a5f2","#999999","#00FF11","#FF0000","#ff00ff","#c0c0c0","#0080ff","#FFFF00","#fda006","#0054a8","#ee00ee");
//class alternative coverage
$cc_col_cov_code_ltr=array("F,F,T","F,T,F","F,T,T","T,F,F","T,F,T","T,T,F");
$boolcode=array("FFT","FTF","FTT","TFF","TFT","TTF");


for($j=0;$j<sizeof($cc_codes);$j++)
{
	for($i=0;$i<sizeof($boolcode);$i++)
	{
		$temp=explode(",",$cc_col_cov_code_ltr[$i]);

		echo $css_type[$j].$cc_codes[$j]."-".$boolcode[$i]." {
	  width: 0px;
	  height: 0px;
	  display:block;
	  float: left;
	  margin: 2px;
	  border-left: 10px solid ".($temp[0]=="F"?$cc_col_codes[$j]:"black")."; 
	  border-top: 10px solid ".($temp[1]=="F"?$cc_col_codes[$j]:"#DDDDDD").";
	  border-right: 10px solid ".($temp[2]=="F"?$cc_col_codes[$j]:"black").";
	  border-bottom: 10px solid ".$cc_col_codes[$j].";
	} \n";	

		unset($temp);

	}
}

?>


</style>

<script>
function redirect_view()
{
	//x=document.getElementById('view_cat').value;
	y=document.getElementById('cust_view').value;
	//window.location = "pps_dashboard_v2.php?view=2&view_cat="+x+"&view_div="+y;
	window.location = "cpanel_main_v2.php?cust_view="+y;
}
</script>


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

<script type='text/javascript' src='jquery-1.6.2.js'></script>
<script type="text/javascript" src="jquery.corner.js"></script>
<script type='text/javascript'>
$('.roundedCorner').corner();
</script>

<script type="text/javascript" src="progressbar.js"></script>

	<style>
	#progressBar {
		width: 140px;
		height: 15px;
		border: 1px solid #060000;
		background-color: #f80701;
	}

	#progressBar div {
		height: 100%;
		color: #000000;
		text-align: right;
		line-height: 15px; /* same as #progressBar height if we want text middle aligned */
		width: 0;
		background-image: url(pbar-ani.gif);
		background-color: #2ffc03;
	}
	</style>

</head>

<body>



<?php //include("../../menu_content.php"); 

//echo '<div id="page_heading"><div id="page_heading"><span style="float: left"><h3> LIVE PRODUCTION WIP</h3></span></div></div>';

?>

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
$sections_wip=array(0,360,480,300);
if(isset($_GET['cust_view']))
{
	$cust_view=$_GET['cust_view'];
}
else
{
	$cust_view="0";
}

?>

<?php

//echo "<font color=yellow>Refresh Rate: 120 Sec.</font>";

$sql="select max(ims_log_date) as \"lastup\" from $bai_pro3.ims_log";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	//echo "Last Update at: ".$sql_row['lastup']."<br/>";
}

$sqlx="select * from $bai_pro3.sections_db where sec_id='".$_GET['sec_x']."'";
//echo "</br>".$sqlx;
mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$section=$sql_rowx['sec_id'];
	$section_head=$sql_rowx['sec_head'];
	$section_mods=$sql_rowx['sec_mods'];
	$priority_limit=$sql_rowx['ims_priority_boxes'];	
	echo '<div style="background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin: 10px; padding: 10px;">';
	echo "<p>";
		
	//echo "<a href=\"bundle_details.php?section=$section&ops=3\" onclick=\"Popup=window.open('bundle_details.php?section=$section&ops=3"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><b>SECTION - $section</b><br><font style=\"font-size:16px;font-color:#000000;\">($section_head)</font></font></a>";
	echo "<div style=\"text-align:center;>
	<a href=\"bundle_details.php?sec=$section&ops=3&type=$cust_view\" onclick=\"Popup=window.open('bundle_details.php?sec=$section&ops=3&type=$cust_view"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">
	<font style=\"font-size:24px;color:#000000;\"><centre><b>IMS</b></centre></font></a></div>";
	echo "<table>";

	$mods=array();
	$mods=explode(",",$section_mods);

	$tot_boxes_section=0;
	$more_than_3days=0;
	$sec_priority=$priority_limit;	
	for($x=0;$x<sizeof($mods);$x++)
	{
		$module=$mods[$x];
		
		echo "<tr class=\"bottom\">";
		echo "<td class=\"bottom\" style=\"width=15px\"><font class=\"fontnn\" color=white >
		<a href=\"bundle_details.php?module=$module&ops=2&type=$cust_view\" onclick=\"Popup=window.open('bundle_details.php?module=$module&ops=2&type=$cust_view"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">
		$module</a></font></td>";
		
		echo "<td class=\"bottom\"></td>";
		echo "<td class=\"bottom\" style=\"width=200\">";
		
		$wip_qty=0;
		$wip_qty_tot=0;
		if($cust_view=='0')
		{		
			$sql11="SELECT GROUP_CONCAT(DISTINCT v2.docket_number) AS doc,v1.ims_mod_no,v2.mini_order_ref,v2.mini_order_num,MIN(ims_date) AS DATE,v1.ims_style AS style, v1.ims_schedule AS sch,GROUP_CONCAT(DISTINCT v1.ims_color) AS col,GROUP_CONCAT(DISTINCT v1.bai_pro_ref) AS bundles,SUM(v1.ims_qty) AS wip,	DATEDIFF(CURDATE(),MIN(ims_date)) AS days	FROM $bai_pro3.ims_log AS v1 LEFT JOIN $brandix_bts.tbl_miniorder_data AS v2 ON v2.bundle_number=v1.bai_pro_ref	WHERE v1.ims_mod_no='".$module."' AND v1.ims_status='' GROUP BY v2.mini_order_ref,v2.mini_order_num,v1.ims_mod_no ORDER BY v2.mini_order_num";
		
			$sql1="SELECT SUM(ims_qty) AS wip FROM $bai_pro3.ims_log where ims_mod_no='".$module."' and ims_status=''";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$wip_qty_tot=$sql_row1['wip'];
			}
		}
		else if($cust_view=='1')
		{
			$sql11="SELECT group_concat(distinct v2.docket_number) as doc,v1.ims_mod_no,v2.mini_order_ref,v2.mini_order_num,MIN(ims_date) as date,v1.ims_style as style, v1.ims_schedule as sch,group_concat(distinct v1.ims_color) as col,GROUP_CONCAT(v1.bai_pro_ref) as bundles,SUM(v1.ims_qty) AS wip, DATEDIFF(CURDATE(),MIN(ims_date)) AS days	FROM $bai_pro3.ims_log AS v1 LEFT JOIN $brandix_bts.tbl_miniorder_data AS v2 ON v2.bundle_number=v1.bai_pro_ref where v1.ims_mod_no='".$module."' and v1.ims_status='' GROUP BY v2.mini_order_ref,v2.mini_order_num,v1.ims_mod_no having days>3 ORDER BY v2.mini_order_num";
			
			$sql1="SELECT sum(tmp.ims_qty) as wip  from (SELECT ims_mod_no,ims_qty,DATEDIFF(NOW(),MIN(ims_date)) AS days
			FROM $bai_pro3.ims_log where ims_mod_no='".$module."' and ims_status='' GROUP BY bai_pro_ref having days>3 ) as tmp group by tmp.ims_mod_no";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$wip_qty_tot=$sql_row1['wip'];
			}
			
		}	
		else if($cust_view=='2')
		{
			$sql11="SELECT GROUP_CONCAT(DISTINCT v2.docket_number) AS doc,v1.ims_mod_no,v2.mini_order_ref,v2.mini_order_num,MIN(ims_date) AS DATE,v1.ims_style AS style, v1.ims_schedule AS sch,GROUP_CONCAT(DISTINCT v1.ims_color) AS col,GROUP_CONCAT(v1.bai_pro_ref) AS bundles,SUM(v1.ims_qty) AS wip,DATEDIFF(CURDATE(),MIN(ims_date)) AS days	FROM $bai_pro3.ims_log AS v1 LEFT JOIN $brandix_bts.tbl_miniorder_data AS v2 ON v2.bundle_number=v1.bai_pro_ref LEFT JOIN $bai_pro3.bai_orders_db_confirm AS v3 ON v3.order_style_no=v1.ims_style AND v3.order_del_no=v1.ims_schedule AND v3.order_col_des=v1.ims_color 	WHERE v1.ims_mod_no='".$module."' AND v3.order_date='".date("Y-m-d")."' and v1.ims_status='' GROUP BY v2.mini_order_ref,v2.mini_order_num,v1.ims_mod_no ORDER BY v2.mini_order_num";
			
			$sql1="SELECT SUM(v1.ims_qty) AS wip FROM $bai_pro3.ims_log AS v1 	LEFT JOIN $bai_pro3.bai_orders_db_confirm AS v3 ON v3.order_style_no=v1.ims_style AND v3.order_del_no=v1.ims_schedule AND v3.order_col_des=v1.ims_color	WHERE v1.ims_mod_no='".$module."' AND v1.ims_status='' AND (v3.order_date='".date("Y-m-d")."' OR v3.order_date='".date("Y-m-d")."') GROUP BY v1.ims_mod_no";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$wip_qty_tot=$sql_row1['wip'];
			}
		}
		$jj=0;	
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error--2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row11=mysqli_fetch_array($sql_result11))
		{
			$ims_doc_no=$sql_row11['doc'];
			$wip_qty=$sql_row11['wip'];
			$schedule_no=$sql_row11['sch'];
			$date=$sql_row11['date'];
			$color=$sql_row11['col'];
			$mini_order_ref=$sql_row11["mini_order_ref"];
			$mini_order_num=$sql_row11["mini_order_num"];
			$ims_style=$sql_row11["style"];
			//$rand_track=$sql_row1['rand_track'];
			$age=$sql_row11['days'];
			$id="green";
			$today=date("Y-m-d");
			if($cust_view == '0')
			{
				$exfactory1=echo_title("bai_pro3.bai_orders_db_confirm","order_date","order_del_no",$schedule_no,$link);
				$exfactory=date_create(echo_title("bai_pro3.bai_orders_db_confirm","order_date","order_del_no",$schedule_no,$link));
				$date1=date_create(date("Y-m-d"));
				//echo $date1."--".$exfactory."<br>";
				$diff=date_diff($date1,$exfactory);
				$t_diff=$diff->format("%R%a");
				
				if($exfactory1 == $today)
				{
					$id="red";
				}
				else if($t_diff<0)
				{
					$id="yash";
				}
				else if($t_diff < 7 && $age>3)
				{
					$id="red";
				}
				else if($t_diff < 7 && $t_diff>0)
				{
					$id="red";
				}
				else if($age > 3)
				{ 
					$id="pink";
				}
				else
				{
					$id="green";
				}
				
			}
			if($cust_view=='1')
			{
				$exfactory1=echo_title("bai_pro3.bai_orders_db_confirm","order_date","order_del_no",$schedule_no,$link);
				$exfactory=date_create(echo_title("bai_pro3.bai_orders_db_confirm","order_date","order_del_no",$schedule_no,$link));
				$date1=date_create(date("Y-m-d"));
				$diff=date_diff($date1,$exfactory);
				$t_diff=$diff->format("%R%a");
				//echo $t_diff."<br>";
				
				if($exfactory1==$today)
				{
					$id="red";
				}
				else if($t_diff<0)
				{
					$id="yash";
				}
				else if($t_diff<7 && $t_diff>0)
				{
					$id="red";
				}
				else
				{
					$id="pink";
				}
				$sql1="SELECT SUM(tmp.ims_qty) as qty FROM (SELECT *,	DATEDIFF(CURDATE(),MIN(v1.ims_date)) AS days	FROM $bai_pro3.ims_log AS v1 LEFT JOIN $brandix_bts.tbl_miniorder_data AS v2 ON v2.bundle_number=v1.bai_pro_ref AND v2.color=v1.ims_color	WHERE v1.ims_mod_no='".$module."' AND v1.ims_status='' AND v2.mini_order_num=".$mini_order_num." AND v2.mini_order_ref='".$mini_order_ref."' GROUP BY v1.bai_pro_ref HAVING days> 3 ORDER BY v2.mini_order_num) AS tmp";
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row1=mysqli_fetch_array($sql_result1))
				{
					$wip_qty=$sql_row1['qty'];
				}				
			}
			if($cust_view=='2')
			{
				$exfactory=date_create(echo_title("bai_pro3.bai_orders_db_confirm","order_date","order_del_no",$schedule_no,$link));
				$date1=date_create(date("Y-m-d"));
				$diff=date_diff($date1,$exfactory);
				$t_diff=$diff->format("%R%a");
				
				if($age>3)
				{
					$id="pink";
				}
				else if($t_diff<0)
				{
					$id="yash";
				}
				else
				{
					$id="red";
				}			
			}
			$min=floor($mini_order_num);
			$style_no=substr($ims_style,1,5);
			//$title="Style:$ims_style\nSchedule:$schedule_no\nColor:$color_name\nWIP:$job_wip\nRejections:$rej_perc\nExfactory:$ex_factory\nAGE:".abs(dateDiffsql($link,date("Y-m-d"),$ims_date));
			$title=str_pad("Style:".$ims_style,50).str_pad("Schedule:".$schedule_no,50).str_pad("Mini Order No:".$mini_order_num,50).str_pad("Quantity:".$wip_qty,50);
			
			if($jj==3)
			{
				echo "
				<div id=\"S$style_no\" class=\"$id\" style=\"font-size:14px; text-align:center;  width: 40px; height: 7px; color:$id\" title=\"$title\" >
				<div id=\"S$schedule_no\" style=\"font-size:14px; text-align:center;  width: 40px; height: 7px;\" title=\"$title\" >
				<div id=\"M$min\" style=\"font-size:14px; text-align:center;  width: 40px; height: 7px;\" title=\"$title\" >
				<a style=\"color:black\" href=\"bundle_details.php?mini_order=$mini_order_num&mini_order_ref=$mini_order_ref&module=$module&wip=$wip_qty&ops=1&type=$cust_view\" 
				onclick=\"Popup=window.open('bundle_details.php?mini_order=$mini_order_num&mini_order_ref=$mini_order_ref&module=$module&wip=$wip_qty&ops=1&type=$cust_view"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">
				".$mini_order_num."</a></div></div></div>"; 
				$jj=0;
			}
			else
			{
				echo "<div id=\"S$style_no\" class=\"$id\" style=\"font-size:14px; text-align:center;  width: 40px; height: 7px; color:$id\" title=\"$title\"  >
				<div id=\"S$schedule_no\" style=\"font-size:14px; text-align:center;  width: 40px; height: 7px;\" title=\"$title\"  >
				<div id=\"M$min\" style=\"font-size:14px; text-align:center; width: 40px; height: 7px;\" title=\"$title\" >
				<a style=\"color:black\" href=\"bundle_details.php?mini_order=$mini_order_num&mini_order_ref=$mini_order_ref&module=$module&wip=$wip_qty&ops=1&type=$cust_view\" 
				onclick=\"Popup=window.open('bundle_details.php?mini_order=$mini_order_num&mini_order_ref=$mini_order_ref&module=$module&wip=$wip_qty&ops=1&type=$cust_view"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">
				".$mini_order_num."</a></div></div></div>"; 
				$jj++;
			}
			
		}
		echo "<td class=\"bottom\"></td>";
		echo "</td>";	
		echo "<td class=\"bottom\" style=\"width=80px\">";
		if($wip_qty_tot>0)
		{
			if($cust_view==0)
			{		
				$tot_bundle=echo_title("bai_pro3.ims_log","count(*)","ims_mod_no",$module,$link);
			}
			else if($cust_view==1)
			{		
				$tot_bundle=echo_title("bai_pro3.ims_log","count(*)","DATEDIFF(CURDATE(),ims_date) >3 AND ims_mod_no",$module,$link);
			}
			else if($cust_view==2)
			{		
				//	$tot_bundle=echo_title("bai_pro3.ims_log","count(*)","left join bai_orders_db_confirm on bai_orders_db_confirm.order_del_no=ims_log.ims_schedule and bai_orders_db_confirm.order_date='".date("Y-m-d")."' and ims_log.ims_mod_no",$module,$link);
				$sql1="SELECT count(*) as bundle FROM $bai_pro3.ims_log AS v1	LEFT JOIN $bai_pro3.bai_orders_db_confirm AS v3 ON v3.order_del_no=v1.ims_schedule AND v3.order_col_des=v1.ims_color	WHERE v1.ims_mod_no='".$module."' AND v3.order_date='".date("Y-m-d")."'";
				//echo $sql1."<br>";
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row1=mysqli_fetch_array($sql_result1))
				{
					$tot_bundle=$sql_row1['bundle'];
				}
				
			}
			//$id='';			
			if($wip_qty_tot <= $sections_wip[$section])
			{
				$id="green";
				$val=1;
			}
			else if($wip_qty_tot > $sections_wip[$section])
			{
				$id="yellow";
				$val=2;
			}
			echo "<div class=\"$id\" style=\"font-size:14px; text-align:center; color:black\" title=\"$title\" >$wip_qty_tot</div>"; 
			//echo "<div style=\"font-size:14px; text-align:center; color:black\" title=\"$title\" >$tot_bundle</div>"; 
		}
		echo "</td>";
		echo "</tr>";
		$tot_bundle='';
	}

echo "</table>";
echo "</p>";
echo '</div>';

}




?>
<div style="clear: both;"> </div>

<!-- To blink sample input entries-->
<script>
	
	function blink(selector){
	$(selector).fadeOut('slow', function(){
	    $(this).fadeIn('slow', function(){
	        blink(this);
	    });
	});
	}
	    
	blink('.blink');
</script>
</body>
</html>

<?php
((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res);

?>