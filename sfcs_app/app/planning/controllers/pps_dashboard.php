<!--
Code Module:Updating the Fabric, Sewing, Packing Trims Availability here.

Description:Here sourcing team will be update the status of Fabric,Sewing,Packing availabilty.

Changes Log:
-->
<?php
header("Location:pps_dashboard_V2.php");
?>
<?php
$double_modules=array();
?>


<?php
set_time_limit(2000);
include("dbconf.php"); 
include("functions.php"); 

$wip_target=1000;
?>

<html>
<head>
 <META HTTP-EQUIV="refresh" content="120">
 <script type="text/javascript" src="jquery.js"></script>


<style>
body
{
	background-color:#333333;
	color: WHITE;
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
	 border-bottom: 1px solid white; 
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
	color: white;
}

.white {
  width:20px;
  height:20px;
  background-color: #ffffff;
  display:block;
  float: left;
  margin: 2px;
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

<script>
function blink_new(x)
{
	obj="#"+x;
	
	if ( $(obj).length ) 
	{
		for(i=1;i<300;i++)
		{
			$(obj).fadeIn(300).fadeOut(300);
		}
				
	}
	//else
	//{
	//	alert("Your request is doesnt exist");
	//}
}

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


//NEW to correct
$remove_docs=array();
$sqlx="select doc_no from plan_dash_doc_summ where act_cut_issue_status=\"DONE\"";
mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$remove_docs[]=$sql_rowx['doc_no'];
}

if(sizeof($remove_docs)>0)
{
	
$sqlx="delete from plan_dashboard where doc_no in (".implode(",",$remove_docs).")";
mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
}

echo "<p style=\"float:right;\"><font size=4><a href=\"ips_legend.jpg\" onclick=\"Popup=window.open('ips_legend.jpg"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">Color Codes</a></font></p>";
 
echo "<font size=4>LIVE INPUT PLANNING DASHBOARD</font>";
//echo "<font color=yellow>Refresh Rate: 120 Sec. (ALPHA TESTING)</font>";

//echo '<div style="border: 0px coral solid; width: 100%; height:20px; float: left; margin: 5px; padding: 5px; overflow: none; display:block;">';
//echo '<strong><table class="new"><tr class="new" valign="middle"><td><div class="green"></div> Sewing Trims Ready</td><td><div class="yellow"></div> Partial Input</td><td><div class="orange"></div> CUT Pending/RM N/A</td><td><div class="blue"></div> Cut Completed</td><td><div class="pink"></div> RM Ready CUT Pending</td><td><div class="red"></div> RM Pending</td><td><div class="yash"></div> All Pending</td><td><div class="white"></div> Slot Available</td><td><div class="black"></div> Partial Input/RM N/U</td></tr></table></strong>';


//echo '</div>';


$sqlx="select * from sections_db where sec_id>0";
mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$section=$sql_rowx['sec_id'];
	$section_head=$sql_rowx['sec_head'];
	$section_mods=$sql_rowx['sec_mods'];
	$sql12="SELECT section_display_name FROM $bai_pro3.sections_master WHERE sec_name=$section";
	$result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row12=mysqli_fetch_array($result12))
	{
		$section_display_name=$sql_row12["section_display_name"];
	}
	echo '<div style="border: 3px coral solid; width: 170px; height: 650px; float: left; margin: 10px; padding: 10px; overflow: hidden;">';
	echo "<p>";
	echo "<table>";
	echo "<tr><th colspan=2><h2><a href=\"board_update.php?section_no=$section\" onclick=\"Popup=window.open('board_update.php?section_no=$section"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$section_display_name</a></h2></th></th></tr>";

	$mods=array();
	$mods=explode(",",$section_mods);

	for($x=0;$x<sizeof($mods);$x++)
	{
		
		$module=$mods[$x];
		$wip_highlight=0; //false

		$sql11="select sum(ims_qty-ims_pro_qty) as \"wip\" from ims_log where ims_mod_no=$module";
		mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row11=mysqli_fetch_array($sql_result11))
		{
			$wip=$sql_row11['wip'];
		} 
		
		echo "<tr class=\"bottom\">";

		echo "<td class=\"bottom\"><strong><a href=\"#\" title=\"WIP : $wip\"><font class=\"fontnn\" color=orange >$module</font></a></strong></td><td>";
				
		
		//$sql1="SELECT * from plan_dash_doc_summ where module=$module order by priority limit 4"; New to correct
		//OLD: $sql1="SELECT clubbing,act_cut_status,act_cut_issue_status,rm_date,cut_inp_temp,doc_no,order_tid,order_style_no,order_del_no,order_col_des,total,acutno,color_code,st_status,emb_stat from plan_dash_doc_summ where module=$module and act_cut_issue_status<>\"DONE\" order by priority limit 4";
		//Isolate PPS with Other Dashboards
		$sql1="SELECT clubbing,act_cut_status,act_cut_issue_status,rm_date,cut_inp_temp,doc_no,order_tid,order_style_no,order_del_no,order_col_des,total,acutno,color_code,st_status,emb_stat from plan_dash_doc_summ where module=$module and (rm_date is null or hour(rm_date)=0 or minute(rm_date)=0) order by priority limit 4";
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result1);
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$cut_new=$sql_row1['act_cut_status'];
			$cut_input_new=$sql_row1['act_cut_issue_status'];
			$rm_new=strtolower(chop($sql_row1['rm_date']));
			$rm_update_new=strtolower(chop($sql_row1['rm_date']));
			$rm_issued_status=strtolower(chop($sql_row1['rm_date'])); //NEW
			$input_temp=strtolower(chop($sql_row1['cut_inp_temp']));
			$doc_no=$sql_row1['doc_no'];
			$order_tid=$sql_row1['order_tid'];
			
			$style=$sql_row1['order_style_no'];
			$schedule=$sql_row1['order_del_no'];
			$color=$sql_row1['order_col_des'];
			$total_qty=$sql_row1['total'];
			
			$cut_no=$sql_row1['acutno'];
			$color_code=$sql_row1['color_code'];
			$emb_stat=$sql_row1['emb_stat'];
			
			
			$sql11="select sum(ims_pro_qty) as \"bac_qty\", sum(emb) as \"emb_sum\" from (SELECT ims_pro_qty, if(ims_status='EPR' or ims_status='EPS',1,0) as \"emb\" FROM ims_log where ims_log.ims_doc_no=$doc_no UNION ALL SELECT ims_pro_qty, if(ims_status='EPR' or ims_status='EPS',1,0) as \"emb\" FROM ims_log_backup WHERE ims_log_backup.ims_mod_no<>0 and ims_log_backup.ims_doc_no=$doc_no) as t";
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
			
			if($cut_new=="DONE"){ $cut_new="T";	} else { $cut_new="F"; }
			if($rm_update_new==""){ $rm_update_new="F"; } else { $rm_update_new="T"; }
			if($rm_new=="0000-00-00 00:00:00" or $rm_new=="") { $rm_new="F"; } else { $rm_new="T";	}
			if($input_temp==1) { $input_temp="T";	} else { $input_temp="F"; }
			if($cut_input_new=="DONE") { $cut_input_new="T";	} else { $cut_input_new="F"; }
			
			
				//New RM Status from FSP
				$st_status=$sql_row1['st_status'];
				
				//To get the status of join orders
				$sql11="select st_status from bai_orders_db_confirm where order_del_no=\"$schedule\" and order_joins=2";
				$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				if(mysqli_num_rows($sql_result11)>0)
				{
					$sql11="select st_status from bai_orders_db_confirm where order_joins=\"J$schedule\"";
					$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row11=mysqli_fetch_array($sql_result11))
					{
						$join_st_status=$sql_row11['st_status'];
						if($sql_row11['st_status']==0 or $sql_row11['st_status']>1 or $sql_row11['st_status']=="")
						{
							break;
						}
					}
					
					$st_status=$join_st_status;
				}
				//To get the status of join orders
				
				if($st_status==""){ $rm_update_new="F"; } else { $rm_update_new="T"; }
				if($st_status>1 or $st_status=="") { $rm_new="F"; } else { $rm_new="T";	}
				
				switch($st_status)
				{
					case 1:
					{
						$remarks="Available";
						break;
					}
					case 2:
					{
						$remarks="In House Issue";
						break;
					}
					case 3:
					{
						$remarks="GRN Issue";
						break;
					}
					case 4:
					{
						$remarks="Inspection Issue";
						break;
					}
					default:
					{
						$remarks="Not Updated";
					}
				}
			//New RM Status from FSP
			
			
			$check_string=$cut_new.$rm_update_new.$rm_new.$input_temp.$cut_input_new;
			//echo $check_string."<br/>";
			
			switch ($check_string)
			{
				case "TTTTF":
				{
					$id="yellow";
					break;
				}
				case "TTTFF":
				{
					$id="green";
					break;
				}
				case "TTFFF":
				{
					//$id="orange";
					$id="red";
					break;
				}
				case "TFFFF":
				{
					$id="blue";
					break;
				}
				case "FTTFF":
				{
					$id="pink";
					break;
				}
				case "FTFFF":
				{
					//$id="red";
					$id="orange";
					break;
				}
				case "FFFFF":
				{
					$id="yash";
					break;
				}
				
				default:
				{
					$id="black";
					break;
				}
			}
			//echo "<a href=\"pop_details.php?doc_no=$doc_no\" onclick=\"Popup=window.open('pop_details.php?doc_no=$doc_no"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><div id=\"$id\" style=\"font-size:10px; text-align:center;\" title=\"\" >".trim(substr($order_tid,0,15))."</div></a>"; 

			//$title=str_pad("Style:".trim(substr($order_tid,0,15)),60).str_pad("Schedule:".check_style(substr($order_tid,15-(strlen($order_tid)))),80).str_pad("Color:".substr($order_tid,(15+strlen(check_style(substr($order_tid,15-(strlen($order_tid))))))-strlen($order_tid)),60);


			//For Color Clubbing
			unset($club_c_code);
			unset($club_docs);
			$club_c_code=array();
			$club_docs=array();
			$colors_db=array();
			if($sql_row1['clubbing']>0)
			{
					
				$total_qty=0;
				$sql11="select order_col_des,color_code,doc_no,(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s06+p_s08+p_s10+p_s12+p_s14+p_s16+p_s18+p_s20+p_s22+p_s24+p_s26+p_s28+p_s30)*p_plies as total from order_cat_doc_mk_mix where category in ($in_categories) and order_del_no=$schedule and clubbing=".$sql_row1['clubbing']." and acutno=".$sql_row1['acutno'];
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
			//$title=str_pad("Style:".$style,80).str_pad("Schedule:".$schedule,80).str_pad("Color:".$color,80).str_pad("Job_No:".chr($sql_row1['color_code']).leading_zeros($sql_row1['acutno'],3),80).str_pad("Total_Qty:".$total_qty,80).str_pad("Output_Qty:".$output,80).str_pad("RM_Remarks:".$remarks,80);
			
			$title=str_pad("Style:".$style,80)."\n".str_pad("Schedule:".$schedule,80)."\n".str_pad("Color:".implode(",",$colors_db),80)."\n".str_pad("Job_No:".implode(", ",$club_c_code),80)."\n".str_pad("Total_Qty:".$total_qty,80)."\n".str_pad("Output_Qty:".$output,80)."\n".str_pad("RM_Remarks:".$remarks,80);
			
			
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
			
			$msg="";
			if($rm_issued_status!="0000-00-00 00:00:00" and strtolower(chop($rm_issued_status))!="" and date("H",strtotime($rm_issued_status))==0)
			{
				//$msg="<font color=black size=2>&#8730;</font>";
				$msg="<font color=black size=2></font>";
			}
			if($rm_issued_status!="0000-00-00 00:00:00" and strtolower(chop($rm_issued_status))!="" and date("H",strtotime($rm_issued_status))>0)
			{
				//$msg="<font color=black size=2>X</font>";
				$msg="<font color=black size=2></font>";
			}
					
			//echo "<div  id=\"$doc_no\" class=\"$id\" style=\"font-size:10px; text-align:center;\" title=\"$title\"><a href=\"pop_details.php?doc_no=$doc_no\" onclick=\"Popup=window.open('pop_details.php?doc_no=$doc_no"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$msg</a></div>";

			echo "<div  id=\"$doc_no\" class=\"$id\" style=\"font-size:10px; text-align:center;\" title=\"$title\">$emb_stat_title</div>";

			//if($wip_highlight==0 and $wip<=$wip_target and ($rm_issued_status=="0000-00-00 00:00:00" or strtolower(chop($rm_issued_status))=="") and $id!="yellow" )
			if($wip_highlight==0 and $wip<=$wip_target and $id!="yellow" )
			{
				if($id!="black")
				{
					if($rm_issued_status=="0000-00-00 00:00:00" or strtolower(chop($rm_issued_status))=="")
					{
						//echo "<script>blink_new($doc_no);</script>"; //To stop blinking
					
					}
					$wip_highlight=1;
				}
			}


//echo "<div id=\"$id\" style=\"font-size:10px; text-align:center;\"><a href=\"pop_details.php?doc_no=$doc_no\" onclick=\"Popup=window.open('pop_details.php?doc_no=$doc_no"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">".$check_string."</a></div>"; 
		}
		
		if(!in_array($module,$double_modules))
		{
			for($i=1;$i<=(4-$sql_num_check);$i++)
			{
				echo "<div class=\"white\"><a href=\"test.php\"></a></div>";
			}
			echo substr($style,0,1); //Style Code
		}
		
		
		echo "</td>";
		echo "</tr>";
		
	}

	echo "</table>";
	echo "</p>";
	echo '</div>';
	
	/*
	//RECUT - Old Version
	
	echo '<div style="border: 3px coral solid; width: 80px; height: 650px; float: left; margin: 10px; padding: 10px; overflow: hidden;">';
	echo "<p>";
	echo "<table>";
	echo "<tr><th colspan=2><h2><a href=\"board_update.php?section_no=$section\" onclick=\"Popup=window.open('board_update.php?section_no=$section"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">RCut</a></h2></th></th></tr>";

	$mods=array();
	$mods=explode(",",$section_mods);

	for($x=0;$x<sizeof($mods);$x++)
	{
		
		$module=$mods[$x];
		
		
		echo "<tr class=\"bottom\">";

		echo "<td>";
			
			
		$sql11="select * from recut_v2 where plan_module=$module and cut_inp_temp is null and remarks in (\"Body\",\"Front\") limit 2";
		$sql_result11=mysql_query($sql11,$link) or exit("Sql Error".mysql_error());
		$recut_count=mysql_num_rows($sql_result11);
		
			if($recut_count>0)
			{
				
					while($sql_row11=mysql_fetch_array($sql_result11))
					{
						$rec_doc_no=$sql_row11['doc_no'];
						$mk_ref=$sql_row11['mk_ref'];
						$fab_status=$sql_row11['fabric_status'];
						$act_cut_status=$sql_row11['act_cut_status'];
						$cut_inp=$sql_row11['cut_inp_temp'];
						
						$a=$b=$c=$d=$e=$f="";
						
						$id="white";
						if($mk_ref>0) {	$a="T";	}else{ $a="F";	} //Marker Update
						if($fab_status>0) {	$b="T";	}else{ $b="F";	} //fabric update
						if($fab_status==1 or $fab_status==5) {	$c="T";	}else{ $c="F";	} // fabric update
						if($fab_status==5) {	$d="T";	}else{ $d="F";	} // fabric available
						if($act_cut_status=="DONE") { $e="T";	}else{ $e="F";	} // cut completion status
						if($cut_inp==1) { $f="T";	}else{ $f="F";	} // cut completion status
						
						$test=$a.$b.$c.$d.$e.$f;
						$path="";
				
						switch($test)
						{
							case "FFFFFF":
							{
								$id="yash";
								$path="../cut_plan_new/recut_v2/cad_pop_details.php?code=1&doc_no=$rec_doc_no";
								break;
							}
							case "TFFFFF":
							{
								$id="pink";
								$path="../cut_plan_new/recut_v2/cad_pop_details.php?code=2&doc_no=$rec_doc_no";
								break;
							}
							case "TTTFFF":
							{
								$id="green";
								$path="fab_pop_details_recut_v2.php?doc_no=$rec_doc_no";
								break;
							}
							case "TTFFFF":
							{
								$id="red";
								$path="../cut_plan_new/recut_v2/cad_pop_details.php?code=2&doc_no=$rec_doc_no";
								break;
							}
							case "TTTTFF":
							{
								$id="yellow";
								$path="../cut_plan_new/recut_v2/cad_pop_details.php?code=0&doc_no=$rec_doc_no";
								break;
							}
							case "TTTTTF":
							{
								$id="blue";
								$path="../cut_plan_new/recut_v2/cad_pop_details.php?code=3&doc_no=$rec_doc_no";
								break;
							}
						}
						
					echo "<div class=\"$id\" title=\"Req. Time:".$sql_row11['date']."\"><a href=\"$path\" onclick=\"Popup=window.open('$path"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"></a></div>";
						
					}
									
					for($i=0;$i<2-$recut_count;$i++)
					{
						echo "<div class=\"white\"></div>";
					}
					
			}
				
			else
			{
				for($i=0;$i<2;$i++)
				{
					echo "<div class=\"white\"></div>";
				}
			}
			
			
			

				
		
		echo "</td>";
		echo "</tr>";
		
	}

	echo "</table>";
	echo "</p>";
	echo '</div>';
	
	//RECUT - Old Version
	*/
}

/*
//RECUT - EMB Old Version
	
	echo '<div style="border: 3px coral solid; width: 80px; height: 650px; float: left; margin: 10px; padding: 10px; overflow: hidden;">';
	echo "<p>";
	echo "<table>";
	echo "<tr><th colspan=2><h2><a href=\"board_update.php?section_no=$section\" onclick=\"Popup=window.open('board_update.php?section_no=$section"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">RCut <br/>EMB<br/>CUT</a></h2></th></th></tr>";

	$mods=array("ENP","CUT");
	//$mods=explode(",",$section_mods);

	for($x=0;$x<sizeof($mods);$x++)
	{
		
		$module=$mods[$x];
		
		
		echo "<tr class=\"bottom\">";

		echo "<td>";
			
			
		$sql11="select * from recut_v2 where plan_module=\"$module\" and cut_inp_temp is null and remarks in (\"Body\",\"Front\") limit 2";
		$sql_result11=mysql_query($sql11,$link) or exit("Sql Error".mysql_error());
		$recut_count=mysql_num_rows($sql_result11);
		
			if($recut_count>0)
			{
				
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
						if($mk_ref>0) {	$a="T";	}else{ $a="F";	} //Marker Update
						if($fab_status>0) {	$b="T";	}else{ $b="F";	} //fabric update
						if($fab_status==1 or $fab_status==5) {	$c="T";	}else{ $c="F";	} // fabric update
						if($fab_status==5) {	$d="T";	}else{ $d="F";	} // fabric available
						if($act_cut_status=="DONE") { $e="T";	}else{ $e="F";	} // cut completion status
						if($cut_inp==1) { $f="T";	}else{ $f="F";	} // cut completion status
						
						$test=$a.$b.$c.$d.$e.$f;
						$path="";
				
						switch($test)
						{
							case "FFFFFF":
							{
								$id="yash";
								$path="../cut_plan_new/recut_v2/cad_pop_details.php?code=1&doc_no=$rec_doc_no";
								break;
							}
							case "TFFFFF":
							{
								$id="pink";
								$path="../cut_plan_new/recut_v2/cad_pop_details.php?code=2&doc_no=$rec_doc_no";
								break;
							}
							case "TTTFFF":
							{
								$id="green";
								$path="fab_pop_details_recut_v2.php?doc_no=$rec_doc_no";
								break;
							}
							case "TTFFFF":
							{
								$id="red";
								$path="../cut_plan_new/recut_v2/cad_pop_details.php?code=2&doc_no=$rec_doc_no";
								break;
							}
							case "TTTTFF":
							{
								$id="yellow";
								$path="../cut_plan_new/recut_v2/cad_pop_details.php?code=0&doc_no=$rec_doc_no";
								break;
							}
							case "TTTTTF":
							{
								$id="blue";
								$path="../cut_plan_new/recut_v2/cad_pop_details.php?code=3&doc_no=$rec_doc_no";
								break;
							}
						}
						
					echo "<div class=\"$id\" title=\"".$title."\"><a href=\"$path\" onclick=\"Popup=window.open('$path"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"></a></div>";
						
					}
									
					for($i=0;$i<2-$recut_count;$i++)
					{
						echo "<div class=\"white\"></div>";
					}
					
			}
				
			else
			{
				for($i=0;$i<2;$i++)
				{
					echo "<div class=\"white\"></div>";
				}
			}
			
			
			

				
		
		echo "</td>";
		echo "</tr>";
		
	}

	echo "</table>";
	echo "</p>";
	echo '</div>';
	
	//RECUT- EMB Old Version
	*/
	
?>
<div style="clear: both;"> </div>
</body>
</html>