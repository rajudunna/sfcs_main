<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
  $view_access=user_acl("SFCS_0245",$username,1,$group_id_sfcs); 

  //Ticket #419256 - KiranG 2013-05-06 : Embellishment Excess Reporting has been given.

  //CR# 221 - KiranG / 20141105: Revised calculation on Embellishment values. (Changed module code to 0)

  $double_modules=array();
  set_time_limit(2000);
?>

<html>
<head>
<META HTTP-EQUIV="refresh" content="300; URL="<?= getFullURL($_GET['r'],'timeout.php','R'); ?>>

<?php include("header_scripts.php"); ?>


<style>
body
{
	background-color:#EEEEEE;
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
	border: 1px solid #000000;
	white-space:nowrap;
	border-collapse:collapse;
}

.new th
{
	border: 1px solid #000000;
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
  width:60px;
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

#activex {
  width:20px;
  height:20px;
  background-color: #00FF11;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

#activex a {
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
  width:60px;
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

#downx {
  width:20px;
  height:20px;
  background-color: #FF0000;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}



#downx a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
  text-align:center;
}

#yash {
  width:60px;
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

#white {
  width:60px;
  height:22px;
  background-color: white;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

#white1 {
  width:80px;
  height:22px;
  background-color: white;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}



#white a {
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
  width:60px;
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

#speedx {
  width:20px;
  height:20px;
  background-color: #0080ff;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}



#speedx a {
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
  width:60px;
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

#waitx {
  width:20px;
  height:20px;
  background-color: #FFFF00;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

#waitx a {
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


<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>
<style>

a{
	text-decoration:none;
	color: #000000;
}

.white {
  width:20px;
  height:20px;
  background-color: #eeeeee;
  display:block;
  float: left;
  margin: 2px;
}

.white a {
  background-color: #eeeeee;
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.white a:hover {
  text-decoration:none;
  background-color: #eeeeee;
}


.red {
  width:20px;
  height:20px;
  background-color: #ff0000;
  display:block;
  float: left;
  margin: 2px;
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
  margin: 2px;
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
  margin: 2px;
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
  background-color: #991144;
  display:block;
  float: left;
  margin: 2px;
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
  width:20px;
  height:20px;
  background-color: #15a5f2;
  display:block;
  float: left;
  margin: 2px;
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
<div class="panel panel-primary">
<div class="panel-heading">Printing & Embellishment Track Panel<a href="<?= getFullURL($_GET['r'],'ems.htm','R'); ?>" class="btn btn-success btn-xs pull-right"  target="_blank">?</a></div>
<div class="panel-body">
<div class="table-responsive">
<?php //include("../../menu_content.php"); ?>

<script language="JavaScript">
<!--

//Disable right mouse click Script
//By Maximus (maximus@nsimail.com) w/ mods by DynamicDrive
//For full source code, visit http://www.dynamicdrive.com

//var message="Function Disabled!";

///////////////////////////////////
// function clickIE4(){
// if (event.button==2){
// sweetAlert("Function Disabled!","","warning");
// return false;
// }
// }

// function clickNS4(e){
// if (document.layers||document.getElementById&&!document.all){
// if (e.which==2||e.which==3){
// sweetAlert("Function Disabled!","","warning");
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

// document.oncontextmenu=new Function("sweetAlert('Function Disabled!','','warning');return false")

// --> 
</script>

<!--<div id="page_heading"><span style="float: "><h3>Printing & Embellishment Track Panel</h3></span><span style="float: right"><b><a href="ems.htm" target="_blank">?</a></b>&nbsp;</span></div>-->
<?php

//echo "<font size=4>Printing & Embellishment Track Panel</font>";
//IMS Included for tracking status in one screen.

//Speed_del_Delivery
$speed_delivery_list=array();
$sql11="select speed_schedule from $bai_pro3.speed_del_dashboard";
//echo $sql11;
$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

while($sql_rowx=mysqli_fetch_array($sql_result11))
{
	$speed_delivery_list[]=$sql_rowx['speed_schedule'];
}

	$sql1="select group_concat(distinct module) as \"module\" from $bai_pro3.plan_dash_doc_summ where emb_stat in (1,3) order by module+1";
	//echo $sql1;
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$section_mods=$sql_row1['module'];
	}
	
if(strlen($section_mods)>0)
{	
	echo '<div style="background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin: 10px; padding: 10px;">';
echo "<p>";

echo "<table><tr><td>IMS:</td></tr></table>";
	

echo "<table>";

$mods=array();
$mods=explode(",",$section_mods);
sort($mods);
  
//NEW for showing all modules
/* $sql="select distinct ims_mod_no as \"module\" from ims_log where ims_mod_no>0 and ims_mod_no in ($section_mods) union select distinct ims_mod_no as \"module\" from ims_log_backup where ims_mod_no>0  and ims_mod_no in ($section_mods) order by module ";
//$sql="select distinct ims_mod_no as \"module\" from ims_log where ims_mod_no>0 and ims_mod_no in ($section_mods)";
mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
while($sql_row=mysql_fetch_array($sql_result))*/
for($x=0;$x<sizeof($mods);$x++)
{
	//NEW for showing all modules
	
	//$module=$sql_row['module'];
	$module=$mods[$x];
	
	echo "<tr class=\"bottom\">";
	echo "<td class=\"bottom\"><font class=\"fontnn\" color=white ><a href=\"mod_rep.php?module=$module\" onclick=\"Popup=window.open('mod_rep.php?module=$module"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$module</a></font></td>";
	
	echo "<td class=\"bottom\"></td>";
	echo "<td class=\"bottom\" style=\"width=100px\">";
	
	$wip_qty=0;
	
	$sql1="SELECT distinct rand_track FROM $bai_pro3.ims_log WHERE ims_mod_no=$module AND ims_status <> \"DONE\" order by tid";
 // echo $sql1;
	mysqli_query($link, $sql1) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result1);
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$rand_track=$sql_row1['rand_track'];
		
		//NEW
		
		$sql11="select * from $bai_pro3.ims_exceptions where ims_rand_track=$rand_track";
   // echo $sql11;
		mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rand_check=mysqli_num_rows($sql_result11);
		while($sql_row11=mysqli_fetch_array($sql_result11))
		{
			$end_time=$sql_row11['req_date'];
		}
		
		$blink_start_tag="";
		$blink_end_tag="";
		if($rand_check>0)
		{
			if(strtotime($end_time)<strtotime((date("Y-m-d H:i:s"))))
			{
				$blink_start_tag="<blink>X";
				$blink_end_tag="</blink>";
				//$blink_start_tag="";
				//$blink_end_tag="";
			}
		}
		
		
		//NEW
		
		$sql11="SELECT ims_doc_no, sum(ims_qty-ims_pro_qty) as \"wip\" FROM $bai_pro3.ims_log WHERE ims_mod_no=$module AND ims_status <> \"DONE\" and rand_track=$rand_track";
   // echo $sql11;
		mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row11=mysqli_fetch_array($sql_result11))
		{
			$ims_doc_no=$sql_row11['ims_doc_no'];
			$wip_qty+=$sql_row11['wip'];
		}
		
		//SPEED Project
		//$sql11="select * from $bai_pro3.speed_del_dashboard where speed_schedule in (SELECT distinct ims_schedule FROM ims_log WHERE ims_mod_no=$module AND ims_status <> \"DONE\" and rand_track=$rand_track)"; 2012-05-02 //Due to performance tuning
		/*
		$sql11="select speed_schedule from $bai_pro3.speed_del_dashboard where speed_schedule in (SELECT ims_schedule FROM ims_log WHERE ims_mod_no=$module AND ims_status <> \"DONE\" and rand_track=$rand_track)";
		mysql_query($sql11,$link) or exit("Sql Error".mysql_error());
		$sql_result11=mysql_query($sql11,$link) or exit("Sql Error".mysql_error());
		$check_speed_dels=mysql_num_rows($sql_result11);
		*/
		
		$check_speed_dels=0;
		if(in_array($schedule_no,$speed_delivery_list))
		{
			$check_speed_dels=1;
		}
		
		
		if($check_speed_dels>0)
		{
			echo "<div id=\"speedx\"><a href=".getFullURL($_GET['r'],'pop.php','N')."&module=$module&doc_ref=$ims_doc_no&rand_track=$rand_track\" onclick=\"Popup=window.open('".getFullURL($_GET['r'],'pop.php','N')."&module=$module&doc_ref=$ims_doc_no&rand_track=$rand_track"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$blink_start_tag$blink_end_tag</a></div>    ";
		}
		else
		{
			echo "<div id=\"downx\"><a href=".getFullURL($_GET['r'],'pop.php','N')."&module=$module&doc_ref=$ims_doc_no&rand_track=$rand_track\" onclick=\"Popup=window.open('".getFullURL($_GET['r'],'pop.php','N')."&module=$module&doc_ref=$ims_doc_no&rand_track=$rand_track"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$blink_start_tag$blink_end_tag</a></div>    ";
		}

	}
	
/*	$sql1="SELECT distinct ims_doc_no FROM recut_ims_log WHERE ims_mod_no=$module AND ims_status <> \"DONE\"";
	mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
	$sql_result1=mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
	$sql_num_check=$sql_num_check+mysql_num_rows($sql_result1);
	while($sql_row1=mysql_fetch_array($sql_result1))
	{
		$ims_doc_no=$sql_row1['ims_doc_no'];
		echo "<a href=\"pop_recut.php?module=$module&doc_ref=$ims_doc_no\" onclick=\"Popup=window.open('pop_recut.php?module=$module&doc_ref=$ims_doc_no"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><img src=\"images\down.gif\" border=0></a>    ";
	} */
	
	
	$diff=2-$sql_num_check;
	
	for($i=1; $i<=$diff; $i++)
	{
		if($wip_qty<=2000)
		{
			echo "<div id=\"activex\"><a hre=\"Input_pop.php?module=$module&doc_ref=$ims_doc_no\" onclick=\"Popup=window.open('Input_pop.php?module=$module&doc_ref=$ims_doc_no"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"></a></div>   ";
		}
		else
		{
			echo "<div id=\"waitx\"></div>   ";
		}
	}
	
	if($sql_num_check==2 and $wip_qty<=2000)
	{
			echo "<div id=\"activex\"><a hre=\"Input_pop.php?module=$module&doc_ref=$ims_doc_no\" onclic=\"Popup=window.open('Input_pop.php?module=$module&doc_ref=$ims_doc_no"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"></a></div>   ";
	}

	echo "</td>";
	
	echo "<td class=\"bottom\"></td>";
	echo "<td class=\"bottom\"></td>";
	//IPS 
	{
	echo "<td>";
	//$sql1="SELECT * from $bai_pro3.plan_dash_doc_summ where module=$module order by priority limit 4"; New to correct
		$sql1="SELECT * from $bai_pro3.plan_dash_doc_summ where module=$module and act_cut_issue_status<>\"DONE\" order by priority limit 1";
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result1);
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$cut_new=$sql_row1['act_cut_status'];
			$cut_input_new=$sql_row1['act_cut_issue_status'];
			$rm_new=strtolower(chop($sql_row1['rm_date']));
			$rm_update_new=strtolower(chop($sql_row1['rm_date']));
			$input_temp=strtolower(chop($sql_row1['cut_inp_temp']));
			$doc_no=$sql_row1['doc_no'];
			$order_tid=$sql_row1['order_tid'];
			//$fabric_status=$sql_row1['fabric_status'];
			$fabric_status=$sql_row1['fabric_status_new']; //NEW due to plan dashboard clearing regularly and to stop issuing issued fabric.
			
			$style=$sql_row1['order_style_no'];
			$schedule=$sql_row1['order_del_no'];
			$color=$sql_row1['order_col_des'];
			$total_qty=$sql_row1['total'];
			
			$cut_no=$sql_row1['acutno'];
			$color_code=$sql_row1['color_code'];
			$log_time=$sql_row1['log_time'];
			$emb_stat=$sql_row1['emb_stat'];
			
			
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
			if($rm_new=="0000-00-00 00:00:00" or $rm_new=="") { $rm_new="F"; } else { $rm_new="T";	}
			if($input_temp==1) { $input_temp="T";	} else { $input_temp="F"; }
			if($cut_input_new=="DONE") { $cut_input_new="T";	} else { $cut_input_new="F"; }
			
			$check_string=$cut_new.$rm_update_new.$rm_new.$input_temp.$cut_input_new;
			$rem="Nil";
			
			//NEW FSP
			if($fabric_status!=5)
			{
				$fabric_status=$sql_row1['ft_status'];
			}
			//NEW FSP

			switch ($fabric_status)
			{
				case "1":
				{
					$id="green";
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
			
			if($cut_new=="T")
			{
				$id="blue";
			}
			//echo "<a href=\"pop_details.php?doc_no=$doc_no\" onclick=\"Popup=window.open('pop_details.php?doc_no=$doc_no"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><div id=\"$id\" style=\"font-size:10px; text-align:center;\" title=\"\" >".trim(substr($order_tid,0,15))."</div></a>"; 

			//$title=str_pad("Style:".trim(substr($order_tid,0,15)),60).str_pad("Schedule:".check_style(substr($order_tid,15-(strlen($order_tid)))),80).str_pad("Color:".substr($order_tid,(15+strlen(check_style(substr($order_tid,15-(strlen($order_tid))))))-strlen($order_tid)),60);
			
			//$title=str_pad("Style:".$style,80).str_pad("Schedule:".$schedule,80).str_pad("Color:".$color,80).str_pad("Job_No:".chr($sql_row1['color_code']).leading_zeros($sql_row1['acutno'],3),80).str_pad("Total_Qty:".$total_qty,80).str_pad("Output_Qty:".$output,80).str_pad("Log_Time:".$log_time,80).str_pad("Remarks:".$rem,80);
		
		$title=str_pad("Style:".$style,80).str_pad("Schedule:".$schedule,80).str_pad("Color:".$color,80).str_pad("Job_No:".chr($sql_row1['color_code']).leading_zeros($sql_row1['acutno'],3),80).str_pad("Total_Qty:".$total_qty,80).str_pad("Log_Time:".$log_time,80).str_pad("Remarks:".$rem,80);


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
			//echo $emb_stat."-".$emb_sum."-".$input_count."$";
			if(($emb_stat==1 or $emb_stat==3) and $emb_sum>0)
			{
				$emb_stat_title="<font color=black size=2>X</font>";
			}
			else
			{
				if(($emb_stat==1 or $emb_stat==3) and $emb_sum==0 and $input_count>0)
				{
					$emb_stat_title="<font color=black size=2>&#8730;</font>";
				}
				else
				{
					if(($emb_stat==1 or $emb_stat==3))
					{
						$emb_stat_title="<font color=black size=2>X</font>";
					}
				}
			}
			//echo $emb_sum;
			//Embellishment Tracking
		

			if($id=="blue")
			{
				echo "<div id=\"$doc_no\" class=\"$id\" style=\"font-size:12px; text-align:center;\" title=\"$title\" >$emb_stat_title</div>"; 
			}
			else
			{
				echo "<div id=\"$doc_no\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id\" title=\"$title\" ><a hre=\"fab_pop_details.php?doc_no=$doc_no\" onclic=\"Popup=window.open('fab_pop_details.php?doc_no=$doc_no"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$emb_stat_title</a></div>"; 
			}
			

//echo "<div id=\"$id\" style=\"font-size:10px; text-align:center;\"><a href=\"pop_details.php?doc_no=$doc_no\" onclick=\"Popup=window.open('pop_details.php?doc_no=$doc_no"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">".$check_string."</a></div>"; 
		}
		
	
	echo "</td>";
	//IPS
	}
	//echo "<td class=\"bottom\"><font color=white>$sql_num_check</font></td>";
	echo "</tr>";
	
}

echo "</table>";
echo "</p>";
echo '</div>';
}

//IMS Included for tracking status in one screen.

//EMB Stat
$module=1;


//echo "<font color=yellow>Refresh Rate: 120 Sec.</font>";



echo '<div style="background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin: 10px; padding: 10px;">';

//echo "<table><tr><td>Allocate from Cutting:</td><td><div id=\"white\"><a href=\"Input_pop.php?module=$module&doc_ref=$ims_doc_no\" onclick=\"Popup=window.open('Input_pop.php?module=$module&doc_ref=$ims_doc_no"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">Allocate</a></div>   </td></tr></table>";
$url1=getFullURL($_GET['r'],'Input_pop.php','N');
$url2=getFullURLLevel($_GET['r'],'ims_allsizes_zero.php',1,'N');
echo "<table>
        <tr>
            <td>Allocate from Cutting:</td>
            <td>
                <div id=\"white\"><span style=\"cursor: pointer; color:RED;\">&nbsp; Allocate</span></div>
            </td>
            <td>
                <div id=\"white1\"><span style=\"cursor: pointer; color:RED;\">&nbsp;Excess-EMB</span></div>
            </td>
        </tr>
</table>";
	
echo "<table>";

$sqlx="select distinct ims_schedule from $bai_pro3.ims_log where ims_mod_no=$module and ims_remarks not in ('EMB')";
//echo $sqlx;
mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$schedule=$sql_rowx['ims_schedule'];
	
	echo "<tr class=\"bottom\">";
	
	echo "<td class=\"bottom\"><font class=\"fontnn\" color=#000000 >$schedule</font></td>";
	echo "<td class=\"bottom\">";
	$sql1="SELECT rand_track, group_concat(ims_status) as \"ims_status\", ims_doc_no FROM $bai_pro3.ims_log WHERE ims_mod_no=$module  and ims_schedule=\"".$schedule."\" and ims_remarks not in ('EXCESS','EMB') group by rand_track order by tid";
	mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result1);
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$rand_track=$sql_row1['rand_track'];
		$ims_doc_no=$sql_row1['ims_doc_no'];
		$ims_status=array();
		$ims_status=explode(",",$sql_row1['ims_status']);
		
		
		$sql11="select color_code,acutno from $bai_pro3.order_cat_doc_mix where doc_no=$ims_doc_no";
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row11=mysqli_fetch_array($sql_result11))
		{
			$job_no=chr($sql_row11['color_code']).leading_zeros($sql_row11['acutno'],3);
		}
		
		switch($ims_status[0])
		{
			case "EPS":
			{
				$id="yash";
				break;
			}
			case "EPR":
			{
				$id="down";
				break;
			}
			case "EPC":
			{
				//To check all sizes are completed or not. 20111128
				if(in_array("EPR",$ims_status) or in_array("EPS",$ims_status))
				{
					$id="down";
					break;
				}
				else
				{
					$id="active";
					break;
				}
			}
		}
	
		
		
		echo "<div id=\"$id\"><a hre=\"pop_emb.php?module=$module&doc_ref=$ims_doc_no&rand_track=$rand_track\" onclic=\"Popup=window.open('pop_emb.php?module=$module&doc_ref=$ims_doc_no&rand_track=$rand_track"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$job_no</a></div>    ";
		
		
	}
	echo "</td>";
	echo "</tr>";
}



echo "</table>";
echo "</p>";
echo '</div>';


//EMB Stat


//EMB Garment stat


echo '<div style="background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin: 10px; padding: 10px;">';
echo "<table><tr><td><a hre=\"$dns_adr3/projects/beta/packing/packing/popup_report_emb.php\" onclic=\"return popitup("."'"."$dns_adr3/projects/beta/packing/packing/popup_report_emb.php"."'".")\">Allocate from Production</a>:</td><td><div id=\"white\"><a href=\"#\">Allocate</a></div></td></tr></table>";
echo "<table>";

$sqlx="select order_del_no as \"ims_schedule\", group_concat(tid) as \"label_id_db\", group_concat(status) as \"status_db\" from $bai_pro3.packing_summary where STATUS!=\"NULL\" and status!=\"DONE\" and status!='' group by order_del_no";
mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$schedule=$sql_rowx['ims_schedule'];
	$label_id_db=array();
	$status_db=array();
	$label_id_db=explode(",",$sql_rowx['label_id_db']);
	$status_db=explode(",",$sql_rowx['status_db']);
	
	echo "<tr class=\"bottom\">";
	
	
	echo "<td class=\"bottom\"><font class=\"fontnn\" color=white >$schedule</font></td>";
	echo "<td class=\"bottom\">";
	for($i=0;$i<sizeof($label_id_db);$i++)
	{
		$lable_id=$label_id_db[$i];
		$ims_status=$status_db[$i];
		switch($ims_status)
		{
			case "EGS":
			{
				$id="yash";
				break;
			}
			case "EGR":
			{
				$id="down";
				break;
			}
			case "EGI":
			{
				$id="active";
				break;
			}
		}
	
		
		
		echo "<div id=\"$id\"><a hre=\"input_emb.php?label_id=$lable_id\" onclic=\"Popup=window.open('input_emb.php?label_id=$lable_id"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">".str_pad($lable_id,8," ",STR_PAD_BOTH)."</a></div>    ";
		
		
	}
	echo "</td>";
}
	echo "</tr>";




echo "</table>";
echo "</p>";
echo '</div>';


//EMB Garment stat
?>
<div style="clear: both;"> </div>
</div></div></div>
</body>
</html>

<?php
((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res);

?>
