<?php
set_time_limit(2000);
include("../../../../common/config/config.php");
$sec_x=$_GET['sec_x'];
?>

<html>
<head>
<meta http-equiv="refresh" content="120" >


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


.fontn a { display: block; height: 20px; padding: 5px; background-color:blue; text-decoration:none; color: white; font-family: Arial; font-size:12px; }

.fontn a:hover { display: block; height: 20px; padding: 5px; background-color:green; font-family: Arial; font-size:12px;}

.fontnn a { color: white; font-family: Arial; font-size:12px; }

</style>


<style>

a{
	text-decoration:none;
	color: #000000;
}

#white {
  width:20px;
  height:20px;
  background-color: #ffffff;
  display:block;
  float: left;
  margin: 2px;
}

#white a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#white a:hover {
  text-decoration:none;
  background-color: #ffffff;
}


#red {
  width:20px;
  height:20px;
  background-color: #ff0000;
  display:block;
  float: left;
  margin: 2px;
}

#red a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#red a:hover {
  text-decoration:none;
  background-color: #ff0000;
}

#green {
  width:20px;
  height:20px;
  background-color: #00ff00;
  display:block;
  float: left;
  margin: 2px;
}

#green a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#green a:hover {
  text-decoration:none;
  background-color: #00ff00;
}

#yellow {
  width:20px;
  height:20px;
  background-color: #ffff00;
  display:block;
  float: left;
  margin: 2px;
}

#yellow a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#yellow a:hover {
  text-decoration:none;
  background-color: #ffff00;
}


#pink {
  width:20px;
  height:20px;
  background-color: #ff00ff;
  display:block;
  float: left;
  margin: 2px;
}

#pink a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#pink a:hover {
  text-decoration:none;
  background-color: #ff00ff;
}

#orange {
  width:20px;
  height:20px;
  background-color: #991144;
  display:block;
  float: left;
  margin: 2px;
}

#orange a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#orange a:hover {
  text-decoration:none;
  background-color: #991144;
}

#blue {
  width:20px;
  height:20px;
  background-color: #15a5f2;
  display:block;
  float: left;
  margin: 2px;
}

#blue a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#blue a:hover {
  text-decoration:none;
  background-color: #15a5f2;
}


#yash {
  width:20px;
  height:20px;
  background-color: #999999;
  display:block;
  float: left;
  margin: 2px;
}

#yash a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#yash a:hover {
  text-decoration:none;
  background-color: #999999;
}

#black {
  width:20px;
  height:20px;
  background-color: black;
  display:block;
  float: left;
  margin: 2px;
}

#black a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#black a:hover {
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

//NEW to correct



//echo '<div style="border: 0px coral solid; width: 100%; height:50px; float: left; margin: 10px; padding: 10px; overflow: none; display:block;">';
//echo '<strong><table class="new"><tr class="new" valign="middle"><td><div id="green"></div> RM Ready</td><td><div id="yellow"></div> Partial Input</td><td><div id="orange"></div> CUT Pending/RM N/A</td><td><div id="blue"></div> Cut Completed</td><td><div id="pink"></div> RM Ready CUT Pending</td><td><div id="red"></div> RM Pending</td><td><div id="yash"></div> All Pending</td><td><div id="white"></div> Slot Available</td><td><div id="black"></div> Partial Input/RM N/U</td></tr></table></strong>';
//echo '</div>';

$sqlx="SELECT GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM $bai_pro3.`module_master` where section = $sec_x GROUP BY section ORDER BY section + 0";
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$section=$sql_rowx['sec_id'];
	$sec=$section;
	$section_head=$sql_rowx['sec_head'];
	$section_mods=$sql_rowx['sec_mods'];

	echo '<div style="width:160px;background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin: 10px; padding: 10px;">';
	echo "<p>";
	echo "<font size=5><a href=\"#\">Absenteeism</a></font>";
	echo "<table>";
	echo '<tr><td></td><td>Fixed</td><td>| Avail.</td></tr>';
	//echo "<tr><th colspan=2><h2><a href=\"board_update.php?section_no=$section\" onclick=\"Popup=window.open('board_update.php?section_no=$section"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">SECTION - $section</a></h2></th></th></tr>";

	$mods=array();
	$mods=explode(",",$section_mods);
  $teams=array();
  $sql2="SELECT  DISTINCT bac_shift FROM $bai_pro.bai_log_buf WHERE bac_date=\"".date("Y-m-d")."\"";
  // echo '<br>'.$sql2.'<br>';
  $sql_result2=mysqli_query($link, $sql2) or exit("Error While getting Shift Details");
  while($sql_row2=mysqli_fetch_array($sql_result2))
  {
    $teams[]=$sql_row2['bac_shift'];
  }
  // $avail_criteria='sum(avail_'.implode('+avail_',$teams).')';
  // $absen_criteria='sum(absent_'.implode('+absent_',$teams).')';
  $date=date("Y-m-d");
	for($x=0;$x<sizeof($mods);$x++)
	{
    $module=$mods[$x];
    $id_new="green";
    $sql2="select sum(present+jumper) as \"avail\", sum(absent) as \"absent\" from $bai_pro.pro_attendance where module=$module and date='".$date."'";
    // echo $sql2;
    $sql_result2=mysqli_query($link, $sql2) or exit("Error While getting Attendance Details");
    while($sql_row2=mysqli_fetch_array($sql_result2))
    {
      $avail=$sql_row2['avail'];
      $absent=$sql_row2['absent'];		
    }
    $sql2="select sum(nop) as fix_nop from $bai_pro.grand_rep where module =$module and date=\"".date("Y-m-d")."\"";
    //secho $sql2;
    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error7896".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row2=mysqli_fetch_array($sql_result2))
    {
      $fixed=$sql_row2['fix_nop'];
      
    }

    if($avail>0) // ERROR CORRECTION
    {
      if($fixed > 0)
      {
        $percent=round(((($avail-$absent)/$fixed))*100,0);
      }
      else
      {
        $percent=0;
      }
      
    }
    else // ERROR CORRECTION
    {
      $percent=10;
    }

    if($percent>=4)
    {
      $id_new="red";
    }
    else
    {
      if($percent<=2)
      {
        $id_new="green";
      }
      else
      {
        $id_new="yellow";
      }
    }
		echo "<tr class=\"bottom\">";
		echo "<td class=\"bottom\"><strong><font class=\"fontnn\" color=black >$module</font></strong></td><td>";

		$title=str_pad("Absents:".$absent,80).str_pad("Available:".$avail,80);
		//echo "<div id=\"$id_new\"><a href=\"#\" title=\"$title\" onclick=\"Popup=window.open('$dna_adr3/projects/alpha/attendance/daily_attendance/pop_cadre_report.php?date=".date("Y-m-d")."&module=$module&days=5&team=".implode(",",$teams)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\" ></a></div>$fixed/".($avail-$absent)."</td>";
		echo "&nbsp;$fixed</td><td>".($avail-$absent)."</td>";
		echo "</tr>";

	}
	echo "</table>";
	echo "</p>";
	echo '</div>';
}
?>
<div style="clear: both;"> </div>
</body>
</html>
