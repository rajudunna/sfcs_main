<!--
Core Module:In this interface we can get module wise fabric allocation details.

Description: We can see the Fabric availability status. 

Changes Log:

2014-02-08/kirang/Ticket #424781 change the display buyer name as per plan_modules table.  
2014-02-01/kirang/Ticket #688771 Display IU modues Priorit boxes with "IU" Symbol , if it is emblishment display "IX".
2014-03-27/ kirang/ Ticket #108968 / Add the bharathidevik user name at $auth_users_to_req_cut_priority array
2014-05-23/ kirang/ Ticket #545935 / Add the bheemunaidug user name at $auth_users_to_req_cut_priority array
2014-08-28/ kirang/ service request #545961 / Add the naidug user name at $auth_users_to_req_cut_priority array
2014-09-09/ kirang / CR:160 / Need to display the Partial cutting/ Input

2014-09-16/ kirang / CR# 182/ Need to display the IU modules based on the status of dbconf file. 
							 // for speed_delivery schedules (100% cut)
2014-12-16/ kirang/ service request #174562 / Add the "nookunaidum","sanyasiraog","bhaskarraok" user names at $auth_users_to_req_cut_priority array
-->
<?php
// error_reporting(0);
$double_modules=array();
?>


<?php
error_reporting(0);
include ("../../../../common/config/config.php");
include ("../../../../common/config/functions.php");
$authorized=array("kirang","kirang","sfcsproject1","vemanas","srinivasaraot");


?>

<?php
set_time_limit(200000);
?>

<html>
<head>
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
<script type="text/javascript" src="jquery.js"></script>


<?php

$username=array("kirang","kirang","sfcsproject1");
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
	x=document.getElementById('view_cat').value;
	y=document.getElementById('view_div').value;
	z=document.getElementById('view_dash').value;
	var ajax_url = "fab_pps_dashboard_v2.php?view="+z+"&view_cat="+x+"&view_div="+y;
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


.fontn a { display: block; height: 20px; padding: 5px; background-color:blue; text-decoration:none; color: white; font-family: Arial; font-size:12px; } 

.fontn a:hover { display: block; height: 20px; padding: 5px; background-color:green; font-family: Arial; font-size:12px;}

.fontnn a { color: white; font-family: Arial; font-size:12px; } 

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

.lgreen {
  width:20px;
  height:20px;
  background-color: #339900;
  display:block;
  float: left;
  margin: 2px;
 
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

.brown {
  width:20px;
  height:20px;
  background-color: #333333;
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

// for speed_delivery schedules
$speed_sch=array();
$sqlq= "SELECT speed_schedule FROM $bai_pro3.speed_del_dashboard";
$sql_result13=mysqli_query($link, $sqlq) or exit("sql error11".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row13=mysqli_fetch_array($sql_result13))
{
	$speed_sch[]=$sql_row13['speed_schedule'];
}


//NEW to correct
$remove_docs=array();
$sqlx="select * from $bai_pro3.plan_dash_doc_summ where act_cut_issue_status=\"DONE\"";
// mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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



//echo '<div style="border: 0px coral solid; width: 100%; height:50px; float: left; margin: 10px; padding: 10px; overflow: none; display:block;">';
//echo '<strong><table class="new"><tr class="new" valign="middle"><td><div id="green"></div> RM Ready</td><td><div id="yellow"></div> Partial Input</td><td><div id="orange"></div> CUT Pending/RM N/A</td><td><div id="blue"></div> Cut Completed</td><td><div id="pink"></div> RM Ready CUT Pending</td><td><div id="red"></div> RM Pending</td><td><div id="yash"></div> All Pending</td><td><div id="white"></div> Slot Available</td><td><div id="black"></div> Partial Input/RM N/U</td></tr></table></strong>';
//echo '</div>';

//For blinking priorties as per the section module wips
$bindex=0;
$blink_docs=array();

$sqlx="select * from $bai_pro3.sections_db where sec_id=".$_GET['sec_x'];
// mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$section=$sql_rowx['sec_id'];
	$section_head=$sql_rowx['sec_head'];
	$section_mods=$sql_rowx['sec_mods'];

	echo '<div style="width:170px;background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin: 10px; padding: 10px;">';
	echo "<p>";
	echo "<table>";
	echo "<tr><th colspan=2><h2><a href=\"javascript:void(0)\" onclick=\"Popup=window.open('board_update_V2.php?section_no=$section"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">Fabric</a></h2></th></th></tr>";

	$mods=array();
	$mods=explode(",",$section_mods);
	
	//For Section level blinking
	$blink_minimum=0;
	

	for($x=0;$x<sizeof($mods);$x++)
	{
		$module=$mods[$x];
		$blink_check=0;
		
		$sql11="select sum(ims_qty-ims_pro_qty) as \"wip\" from $bai_pro3.ims_log where ims_mod_no=$module";
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row11=mysqli_fetch_array($sql_result11))
		{
			$wip=$sql_row11['wip'];
		} 
		
		$iu_module_highlight="";
		if (!empty($iu_modules))
		{
			if(in_array($module,$iu_modules))
			{
				$iu_module_highlight="bgcolor=\"$iu_module_highlight_color\"";
			}
		}		
		echo "<tr class=\"bottom\">";
		echo "<td class=\"bottom\" $iu_module_highlight><strong><a href=\"javascript:void(0)\" title=\"WIP : $wip\"><font class=\"fontnn\" color=black >$module</font></a></strong></td><td>";
		
		//To disable issuing fabric to cutting tables
		//All yellow colored jobs will be treated as Fabric Wip
		$cut_wip_control=3000;
		$fab_wip=0;
		$pop_restriction=0;
		
		//$sql1="SELECT * from plan_dash_doc_summ where module=$module order by priority limit 4"; New to correct
		//Filter view to avoid Cut Completed and Fabric Issued Modules
		
		
		$sql1="SELECT * from $bai_pro3.plan_dash_doc_summ where module=$module and act_cut_issue_status<>\"DONE\" order by priority limit 4";
		
		//Filter view to avoid Cut Completed and Fabric Issued Modules
		if($_GET['view']==1)
		{
			$sql1="SELECT * from $bai_pro3.plan_dash_doc_summ where module=$module and act_cut_issue_status<>\"DONE\" order by priority";
			$view_count=0;
		}
		
		//filter to show only cut completed
		if($_GET['view']==3)
		{
			$sql1="SELECT * from $bai_pro3.plan_dash_doc_summ where module=$module and act_cut_status<>\"DONE\" order by priority limit 4";
			$view_count=0;
		}
		// mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
			$ord_style=$sql_row1['order_style_no'];
			//$fabric_status=$sql_row1['fabric_status'];
			$fabric_status=$sql_row1['fabric_status_new']; //NEW due to plan dashboard clearing regularly and to stop issuing issued fabric.
			
			
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
			
			$sql11="select sum(ims_pro_qty) as \"bac_qty\", sum(emb) as \"emb_sum\" from (SELECT ims_pro_qty, if(ims_status='EPR' or ims_status='EPS',1,0) as \"emb\" FROM ims_log where ims_log.ims_doc_no=$doc_no UNION ALL SELECT ims_pro_qty, if(ims_status='EPR' or ims_status='EPS',1,0) as \"emb\" FROM ims_log_backup WHERE ims_log_backup.ims_mod_no<>0 and ims_log_backup.ims_doc_no=$doc_no) as t";
			// mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
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
					/*if($fab_wip>$cut_wip_control)
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
					$sql1x1="select doc_ref from $bai_pro3.fabric_priorities where doc_ref=$doc_no and hour(issued_time)+minute(issued_time)>0";
					$sql_result1x1=mysqli_query($link, $sql1x1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					if(mysqli_num_rows($sql_result1x1)>0)
					{
						$id="yellow";
					}
					else
					{
						$id="green";
					}
					break;
				}				
				default:
				{
					$id="yash";
					$rem="Not Update";
					break;
				}
			}
			
			//To highlight colors when it was requested.
			
			$sql11x="select * from $bai_pro3.fabric_priorities where doc_ref=\"$doc_no\"";
			$sql_result11x=mysqli_query($link, $sql11x) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if(mysqli_num_rows($sql_result11x)>0 and $id!="yellow")
			{
				$id="lgreen";	
			} 
			
			
			if($cut_new=="T")
			{
				$id="blue";
			}
			
			// start for partial Cutting/input 
			
			if($cut_new=="T")
			{
				$id_temp=partial_cut_color($doc_no,$link);
				
				if($id_temp=="false" or $id_temp=="")
				{
					
				}
				else
				{
					$id=$id_temp;
				}
				
			}
			// close for partial Cutting/input 
			
			if($id!="blue" and $id!="yellow" and $blink_check==0)
			{
				//For Section Level Blinking
				if($blink_minimum==0)
				{
					$blink_minimum=$fab_wip;
					$blink_docs[$bindex]=$doc_no;
				}
				else
				{
					if($fab_wip<$blink_minimum)
					{
						$blink_minimum=$fab_wip;
						$blink_docs[$bindex]=$doc_no;
					}	
				}
				$blink_check=1;
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
				$sql11="select order_col_des,color_code,doc_no,(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies as total from $bai_pro3.order_cat_doc_mk_mix where category in ('".implode("','",$in_categories)."') and order_del_no=$schedule and clubbing=".$sql_row1['clubbing']." and acutno=".$sql_row1['acutno'];
				$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row11=mysqli_fetch_array($sql_result11))
				{
					$club_c_code[]=chr($sql_row11['color_code']).leading_zeros($sql_row1['acutno'],3);
					$club_docs[]=$sql_row11['doc_no'];
					$total_qty+=$sql_row11['total'];
					$colors_db[]=trim($sql_row11['order_col_des']);
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
			
			//For Fabric Wip Tracking
			
			if($cut_new!="T" and $id=="yellow")
			{
				$fab_wip+=$total_qty;
			}
					
		
		//$title=str_pad("Style:".trim($style),80).str_pad("Schedule:".$schedule,80).str_pad("Color:".trim(implode(",",$colors_db)),80).str_pad("Job_No:".implode(", ",$club_c_code),80).str_pad("Total_Qty:".$total_qty,80).str_pad("Log_Time:".$log_time,80).str_pad("Remarks:".$rem." / Bundle_Location:".$bundle_location,80);
$title=str_pad("Style:".trim($style),80)."\n".str_pad("Schedule:".$schedule,80)."\n".str_pad("Color:".trim(implode(",",$colors_db)),80)."\n".str_pad("Job_No:".implode(", ",$club_c_code),80)."\n".str_pad("Total_Qty:".$total_qty,80)."\n".str_pad("Log_Time:".$log_time,80)."\n".str_pad("Fab_Loc.:".$fabric_location."Bundle_Loc.:".$bundle_location,80);


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
			$iustyle_show=$iustyle;
			//include("dbconf.php"); 
			//echo $emb_stat."-".$emb_sum."-".$input_count."$";
			if(($emb_stat==1 or $emb_stat==3) and $emb_sum>0)
			{
				$emb_stat_title="<font color=black size=2>X</font>";
				$iustyle_show=substr($iustyle,0,1);
			}
			else
			{
				if(($emb_stat==1 or $emb_stat==3) and $emb_sum==0 and $input_count>0)
				{
					$emb_stat_title="<font color=black size=2>&#8730;</font>";
					$iustyle_show=substr($iustyle,0,1);
				}
				else
				{
					if(($emb_stat==1 or $emb_stat==3))
					{
						$emb_stat_title="<font color=black size=2>X</font>";
						$iustyle_show=substr($iustyle,0,1);
					}
				}
			}
			//echo $emb_sum;
			//Embellishment Tracking
		
// 	Ticket #688771 Display IU modues Priorit boxes with "IU" Symbol.
			$sqlt="SELECT * from $bai_pro3.plan_dash_doc_summ where (order_style_no like \"L%Y%\" or order_style_no like \"L%Z%\" or order_style_no like \"O%Y%\" or order_style_no like \"O%Z%\") and module=$module and doc_no=$doc_no and act_cut_issue_status<>\"DONE\"" ;
			//echo $sqlt;	
		// mysqli_query($link, $sqlt) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result12=mysqli_query($link, $sqlt) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$check_num_rows=mysqli_num_rows($sql_result12);		
	    while($sql_row12=mysqli_fetch_array($sql_result12))
		{
			$sel_sty=$sql_row12['order_style_no'];
			$sel_sch=$sql_row12['order_del_no'];
		}
		//echo $module."-schedules:".$sel_sch."-".$sel_sty."-".$ord_style."<br/>";	
		
	if(($check_num_rows>0 && $sel_sty==$ord_style)||in_array($schedule,$speed_sch))
	{
		$emb_style= $iustyle_show."".$emb_stat_title;
			
	}
	else
	{
		$emb_style= $emb_stat_title;
	}			
			if($id=="blue")
			{
				echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$id\" style=\"font-size:12px; text-align:center;\" title=\"$title\">$emb_style</div></div>";
				//echo $schedule;
			}						
			else
			{
		    	$auth_users_to_req_cut_priority=array("sfcsproject1","kirang","sowjanyag","chandrasekhard","prabathsa","baiadmn","naleenn","kirang","priyankat","malithad","kirang","bharathidevik","bheemunaidug","naidug","nookunaidum","sanyasiraog","bhaskarraok");
				if(in_array($username,$auth_users_to_req_cut_priority) and $id!="yellow" and $id!="blue")
				{
				
				echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id\" title=\"$title\" ><a href=\"fabric_requisition.php?module=$module&section=$section&doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."\" onclick=\"Popup=window.open('fabric_requisition.php?module=$module&section=$section&doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$emb_style</a>";
			//echo $schedule;
					//if($module==3)
					//{
					//	echo $style."-".$id;
				//	}
					echo "</div></div>";
				}
				else
				{
					//echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id\" title=\"$title\" ><a href=\"fab_pop_details.php?doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."\" onclick=\"Popup=window.open('fab_pop_details.php?doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$emb_stat_title</a></div></div>";
					echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id\" title=\"$title\" ><a href=\"#\">$emb_style</a></div></div>";
				//echo $schedule;
					
				}			
				
			 
			}
			
	
	

//echo "<div id=\"$id\" style=\"font-size:10px; text-align:center;\"><a href=\"pop_details.php?doc_no=$doc_no\" onclick=\"Popup=window.open('pop_details.php?doc_no=$doc_no"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">".$check_string."</a></div>"; 
			
		}
		
		//Ticket #424781 change the display buyer name as per plan_modules table.
		$sqly="select buyer_div from $bai_pro3.plan_modules where module_id=$module";
		//echo $sqly."<br>";
		// mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowy=mysqli_fetch_array($sql_resulty))
		{
			$buyer_div=$sql_rowy['buyer_div'];
			
			if(substr($buyer_div,0,1)=="M")
			{
				$cut_wip_control=7000;
			}		
		}
		
		if(!in_array($module,$double_modules))
		{
			/* if($_GET['view']==1 or $_GET['view']==3)
			{
				echo substr($style,0,1);
			}
			else
			{
				for($i=1;$i<=(4-$sql_num_check);$i++)
				{
					echo "<div class=\"white\"><a href=\"#\"></a></div>";
				}
				echo substr($style,0,1);
			} */
			
			if($_GET['view']==1)
			{
				for($i=1;$i<=(4-$view_count);$i++)
				{
					echo "<div class=\"white\"><a href=\"#\"></a></div>";
				}
				//echo substr($style,0,1);
				echo substr($buyer_div,0,1);
			}
			else
			{
				for($i=1;$i<=(4-$sql_num_check);$i++)
				{
					echo "<div class=\"white\"><a href=\"#\"></a></div>";
				}
				//echo substr($style,0,1);
				echo substr($buyer_div,0,1);
			}
			
		}
		
		echo "</td>";
		echo "</tr>";
	}
	
	//Blinking at section level
	$bindex++;

	echo "</table>";
	echo "</p>";
	echo '</div>';
	
	//RECUT
	
	echo '<div style="width:170px;background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin: 10px; padding: 10px;">';
	echo "<p>";
	echo "<table>";
	echo "<tr>
			<th colspan=2>
				<h2>
					<a href=\"board_update.php?section_no=$section\" onclick=\"Popup=window.open('board_update_V2.php?section_no=$section"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">ReCut</a>
				</h2>
			</th>
		</tr>";

	$mods=array();
	$mods=explode(",",$section_mods);

	for($x=0;$x<sizeof($mods);$x++)
	{
		
		$module=$mods[$x];
		
		
		echo "<tr class=\"bottom\">";
		echo "<td class=\"bottom\" $><strong><font class=\"fontnn\" color=black >$module</font></strong></td>";
		echo "<td>";
			
			
		$sql11="select * from $bai_pro3.recut_v2 where plan_module=$module and cut_inp_temp is null and remarks in ('".implode("','",$in_categories)."')";
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$recut_count=mysqli_num_rows($sql_result11);
		
			if($recut_count>0)
			{
					if((isset($_GET['view']) or isset($_GET['div'])) and $_GET['view']==2)
					{
						$view_cat_check=0;
						while($sql_row11=mysqli_fetch_array($sql_result11))
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
							$total_qty=($sql_row11['a_xs']+$sql_row11['a_s']+$sql_row11['a_m']+$sql_row11['a_l']+$sql_row11['a_xl']+$sql_row11['a_xxl']+$sql_row11['a_xxxl']+$sql_row11['a_s01']+$sql_row11['a_s02']+$sql_row11['a_s03']+$sql_row11['a_s04']+$sql_row11['a_s05']+$sql_row11['a_s06']+$sql_row11['a_s07']+$sql_row11['a_s08']+$sql_row11['a_s09']+$sql_row11['a_s10']+$sql_row11['a_s11']+$sql_row11['a_s12']+$sql_row11['a_s13']+$sql_row11['a_s14']+$sql_row11['a_s15']+$sql_row11['a_s16']+$sql_row11['a_s17']+$sql_row11['a_s18']+$sql_row11['a_s19']+$sql_row11['a_s20']+$sql_row11['a_s21']+$sql_row11['a_s22']+$sql_row11['a_s23']+$sql_row11['a_s24']+$sql_row11['a_s25']+$sql_row11['a_s26']+$sql_row11['a_s27']+$sql_row11['a_s28']+$sql_row11['a_s29']+$sql_row11['a_s30']+$sql_row11['a_s31']+$sql_row11['a_s32']+$sql_row11['a_s33']+$sql_row11['a_s34']+$sql_row11['a_s35']+$sql_row11['a_s36']+$sql_row11['a_s37']+$sql_row11['a_s38']+$sql_row11['a_s39']+$sql_row11['a_s40']+$sql_row11['a_s41']+$sql_row11['a_s42']+$sql_row11['a_s43']+$sql_row11['a_s44']+$sql_row11['a_s45']+$sql_row11['a_s46']+$sql_row11['a_s47']+$sql_row11['a_s48']+$sql_row11['a_s49']+$sql_row11['a_s50'])*$sql_row11['a_plies'];
	
							
							$sql111="select order_style_no,order_del_no,order_col_des from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
							$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row111=mysqli_fetch_array($sql_result111))
							{
								$style=$sql_row111['order_style_no'];
								$schedule=$sql_row111['order_del_no'];
								$color=$sql_row111['order_col_des'];
							}
							$title=str_pad("Style:".$style,80).str_pad("Schedule:".$schedule,80).str_pad("Color:".$color,80).str_pad("Total_Qty:".$total_qty,80).str_pad("Req_Time:".$req_date,80).str_pad("Source Conf. Time:".$source_conf_time,80);
							//
							
							$a=$b=$c=$d=$e=$f="";
							
							$id="white";
							if($mk_ref>0) {	$a="T";	}else{ $a="F";	} //Marker Update
							if($fab_status>0) {	$b="T";	}else{ $b="F";	} //fabric update
							if($fab_status==1 or $fab_status==5) {	$c="T";	}else{ $c="F";	} // fabric update
							if($fab_status==5) {	$d="T";	}else{ $d="F";	} // fabric available
							if($act_cut_status=="DONE") { $e="T";	}else{ $e="F";	} // cut completion status
							if($cut_inp==1) { $f="T";	}else{ $f="F";	} // cut completion status
							
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
	echo '</div>';
	
	//RECUT

}


	
	//To show section level priority only to RM-Fabric users only.
	if((in_array(strtolower($username),$authorized)))
	{
		echo "<script>";
		echo "blink_new_priority('".implode(",",$blink_docs)."');";
		echo "</script>";
	}
	
	//RECUT
	
?>
<div style="clear: both;"> </div>
</body>
</html>