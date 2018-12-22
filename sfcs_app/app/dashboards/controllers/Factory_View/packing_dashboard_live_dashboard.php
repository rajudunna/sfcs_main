<?php

//CR#552 // 2015-04-28 // kirang // View Section And Module Wise carton status details.  

?>
<?php
	set_time_limit(2000);
	include ("../../../../common/config/config.php");
	include ("../../../../common/config/functions.php");
	$sec_x=$_GET['sec_x'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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

#white {
  width:20px;
  height:20px;
  background-color: #ffffff;
  display:block;
  float: left;
  margin: 2px;
  border: 1px solid #000000;
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
  border: 1px solid #000000;
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
border: 1px solid #000000;
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
border: 1px solid #000000;
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
border: 1px solid #000000;
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
border: 1px solid #000000;
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
border: 1px solid #000000;
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
border: 1px solid #000000;
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
border: 1px solid #000000;
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

<script type='text/javascript' src='../../common/js/jquery-1.6.2.js'></script>
<script type="text/javascript" src="../../common/js/jquery.corner.js"></script>
<script type='text/javascript'>
$('.roundedCorner').corner();
</script>


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

//TEMP Table

$emb_schedules=array(); //Emb Schedules - Garment Form
$sql="select order_del_no from $bai_pro3.bai_orders_db where order_embl_e=1 or order_embl_f=1";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$emb_schedules[]=$sql_row['order_del_no'];
}

//include("packing_dashboard_prepare.php"); //AUTO
/*//NEW ADD 2011-07-14
$sql1="truncate packing_dashboard_temp";
mysql_query($sql1,$link) or exit("Sql Error".mysql_error());

$sql1="insert into packing_dashboard_temp SELECT tid,doc_no,size_code,carton_no,carton_mode,carton_act_qty,status,lastup,remarks,doc_no_ref,ims_style,ims_schedule,ims_color,input_date,ims_pro_qty,ims_mod_no,ims_log_date from packing_dashboard";
mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
*///NEW ADD 2011-07-14
//TEMP Table


$sqlx="SELECT GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM $bai_pro3.`module_master` where section = '".$sec_x."' GROUP BY section ORDER BY section + 0";
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$section=$sql_rowx['sec_id'];
	// $section_head=$sql_rowx['sec_head'];
	$section_mods=$sql_rowx['sec_mods'];

	echo '<div style="border: 3px coral solid; width: 160px; height: auto; float: left; margin: 0px; padding: 10px;">';

	echo "<p>";
	echo "<font size=5><a href=\"popup_report.php?section_no=$sec_x\" onclick=\"Popup=window.open('popup_report.php?section_no=$sec_x"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"> LMS</a></font>";
	echo "<table>";
	//echo "<tr><th colspan=2><a href=\"popup_report.php?section_no=$section\" onclick=\"return popitup("."'"."popup_report.php?section_no=$section"."'".")\"><h2>SEC. - $section</h2></a></th></tr>";

	$mods=array();
	$mods=explode(",",$section_mods);

	for($x=0;$x<sizeof($mods);$x++)
	{
		
		$module=$mods[$x];
		{
		
		echo "<tr class=\"bottom\">";
		echo "<td class=\"bottom\"><strong><font class=\"fontnn\" color=black >$module</font></strong></td><td>";
		
		$sql1="SELECT *,HOUR(TIMEDIFF(ims_log_date,\"".date("Y-m-d H:i:s")."\")) as \"diff\" from $bai_pro3.packing_dashboard_temp where ims_mod_no=$module order by lastup";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result1);
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$carton_qty=$sql_row1['carton_act_qty'];
			$carton_mode=$sql_row1['carton_mode'];
			$out_qty=$sql_row1['ims_pro_qty'];
			$carton_no=$sql_row1['carton_no']; 
			$lastup=$sql_row1['lastup'];
			$style=substr($sql_row1['ims_style'],0,1);
			$diff=$sql_row1['diff'];
			$ims_doc_no=$sql_row1['doc_no'];
			$ims_size=$sql_row1['size_code'];
			$ims_tid_qty=$sql_row1['carton_act_qty'];
			$carton_id_ref=$sql_row1['tid'];
			$add_css="";
			
			$sqla="select sum(ims_pro_qty) as qty from $bai_pro3.ims_log where ims_doc_no=$ims_doc_no and ims_size=\"a_$ims_size\" and ims_mod_no > 0";
			$sql_resulta=mysqli_query($link, $sqla) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rowa=mysqli_fetch_array($sql_resulta))
			{
				$output_qty=$sql_rowa["qty"];	
			}
			
			$sqla1="select sum(ims_pro_qty) as qty from $bai_pro3.ims_log_backup where ims_doc_no=$ims_doc_no and ims_size=\"a_$ims_size\" and ims_mod_no > 0";
			//echo $sqla1;
			$sql_resulta1=mysqli_query($link, $sqla1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rowa1=mysqli_fetch_array($sql_resulta1))
			{
				$output_qty1=$sql_rowa1["qty"];	
			}
			
			$sqlb="select sum(carton_act_qty) as qty from $bai_pro3.pac_stat_log where doc_no=$ims_doc_no and size_code=\"".$ims_size."\" and status=\"DONE\"";
			$sql_resultb=mysqli_query($link, $sqlb) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rowb=mysqli_fetch_array($sql_resultb))
			{
				$packing_qty=$sql_rowb["qty"];	
			}
			
			$text_ref="";
			$id="blue";
			$hour_1=0;
			$hour_2=0;
			$carton_status=0;
			
			$sql42="SELECT * FROM aql_track_log WHERE carton_id=$carton_id_ref AND log_time=(SELECT MAX(log_time) AS log_time FROM $bai_pro3.aql_track_log WHERE carton_id=$carton_id_ref)";
			$result42=mysqli_query($link, $sql42) or exit("Sql Error42".$sql42."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($result42)>0)
			{
				while($row42=mysqli_fetch_array($result42))
				{
					$carton_status=$row42["carton_status"];
					$aql_tid_ref=$row42["tid"];
				}
			}
			
			if($carton_status==1)
			{
				$id="Red";
				$sql41="select * from $bai_pro3.aql_track_log where carton_id=$carton_id_ref and carton_status=1";
				$result41=mysqli_query($link, $sql41) or exit("Sql Error41".$sql41."-".mysqli_error($GLOBALS["___mysqli_ston"]));	
				//echo $sql41."<br>";
				if(mysqli_num_rows($result41)>0)
				{
					$sql41x="select HOUR(TIMEDIFF(NOW(),log_time)) AS hourd from $bai_pro3.aql_track_log where carton_id=$carton_id_ref and carton_status=1 and tid=$aql_tid_ref";
					//echo $sql41x."<br>";
					$result41x=mysqli_query($link, $sql41x) or exit("Sql Error41".$sql41x."-".mysqli_error($GLOBALS["___mysqli_ston"]));	
					while($row41x=mysqli_fetch_array($result41x))
					{
						$hour_1=$row41x["hourd"];
					}
				}
				if(mysqli_num_rows($result41)>1)
				{
					$text_ref="X";
				}
			}
			
			if($carton_status==2)
			{
				$id="Yellow";
				$sql42x="select HOUR(TIMEDIFF(NOW(),log_time)) AS hourd from $bai_pro3.aql_track_log where carton_id=$carton_id_ref and tid=$aql_tid_ref";
				$result42x=mysqli_query($link, $sql42x) or exit("Sql Error42".$sql42x."-".mysqli_error($GLOBALS["___mysqli_ston"]));				
				while($row42x=mysqli_fetch_array($result42x))
				{
					$hour_2=$row42x["hourd"];
				}
			}
			
			if($carton_status==3)
			{
				$id="Green";
				$sql_sta="select status from $bai_pro3.pac_stat_log where tid=$carton_id_ref";
				$result_sta=mysqli_query($link, $sql_sta) or exit("Sql Error_sta".$sql_sta."-".mysqli_error($GLOBALS["___mysqli_ston"]));				
				while($row_sta=mysqli_fetch_array($result_sta))
				{
					$carton_scan_status=$row_sta["status"];
				}
				if($carton_scan_status!="DONE")
				{
					$sql43x="select MINUTE(TIMEDIFF(NOW(),log_time)) AS mintd from $bai_pro3.aql_track_log where carton_id=$carton_id_ref and tid=$aql_tid_ref";
					$result43x=mysqli_query($link, $sql43x) or exit("Sql Error43".$sql43x."-".mysqli_error($GLOBALS["___mysqli_ston"]));				
					while($row43x=mysqli_fetch_array($result43x))
					{
						$mint_3=$row43x["mintd"];
					}
				}
			}
			
			if(mysqli_num_rows($result42)>0)
			{			
				if($hour_1 > 0)
				{
					$add_css="class=\"blink\"";
				}
				
				if($hour_2 > 0)
				{
					$add_css="class=\"blink\"";
				}
				
				if($mint_3 > 30)
				{
					$add_css="class=\"blink\"";
				}
			}
			
			$title=str_pad("Carton ID:".$carton_id_ref,80).str_pad("Carton Qty:".$carton_qty,80);
			
			//embellishment highlight
			$emb_text="";
			if(in_array($sql_row1['ims_schedule'],$emb_schedules))
			{
				$emb_text="E";
			}
			
			if((($output_qty+$output_qty1)-$packing_qty) >= $ims_tid_qty)
			{
				echo "<div id=\"$id\" style=\"color:black;text-align:center;\" $add_css title=\"$title\"><font style=\"color:black;text-align:center;\"><b>$emb_text$text_ref</b></font></div>";
			}	
			$hour_1=0;	
			$hour_2=0;			
		}	
		
		echo "</td>";
		echo "</tr>";
		}
		
	}

	echo "</table>";
	echo "</p>";
	echo '</div>';

}


?>
<div style="clear: both;"> </div>
</body>
</html>