<!--
CR: 207 extrashipment dashboard based on IMS.

-->
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
$view_access=user_acl("SFCS_0201",$username,1,$group_id_sfcs); 
set_time_limit(2000);
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
  include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	$sql="select distinct bac_date from $bai_pro.bai_log_buf where bac_date<='$start' and bac_date>='$end'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	return mysqli_num_rows($sql_result);
}

?>

<?php
$double_modules=array();
?>

<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'extra_ship_fun.php',0,'R')); ?>

<html>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<head>
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

.data
{
    border: 1px solid #000000;
	white-space:nowrap;
	border-collapse:collapse;
	cellspacing:0px;
	cellpadding:0px;
	table-layout:fixed;
    width:100%;
}
td{
	white-space: nowrap;
    /* text-overflow: ellipsis; */
    overflow: hidden;
}
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

#green {
  width:20px;
  height:20px;
  background-color: #00ff00;
  display:block;
  float: left;
  margin: 2px;
  border: 1px solid black;
  font-size : 10px;
  color : #fff;
  width : auto;
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
  border: 1px solid black;
  font-size : 10px;
  color : #fff;
  width : auto;
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




#orange {
  width:20px;
  height:20px;
  background-color: #ce831e;
  display:block;
  float: left;
  margin: 2px;
  border: 1px solid black;
  font-size : 10px;
  color : #fff;
  width : auto;
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
  background-color: #ce831e;
}

#down {
  width:20px;
  height:20px;
  background-color: #FF0000;
  display:block;
  float: left;
  margin: 2px;
  border: 1px solid black;
  font-size : 10px;
  color : #fff;
  width : auto;
}



#down a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
  line-height : 3px;
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
  background-color: #ff0000;
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
  background-color: #ff0000;
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
  background-color: #ff00ff;
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
  background-color: #ff00ff;
}

.orange {
  width:20px;
  height:20px;
  background-color: #ce831e;
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
  background-color: #ce831e;
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
sweetAlert("Function Disabled!","","warning");
return false;
}
}

function clickNS4(e){
if (document.layers||document.getElementById&&!document.all){
if (e.which==2||e.which==3){
sweetAlert("Function Disabled!","","warning");
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

document.oncontextmenu=new Function("sweetAlert('Function Disabled!','','warning');return false")

// --> 
</script>

<div class="panel panel-primary">
<div class="panel-heading">Extra Shipment Monitoring Dashboard<span class="pull-right"><b><a href="<?= getFullURLLevel($_GET['r'],'Achievement.htm',0,'N');?>" target="_blank">?</a></b>&nbsp;</span></div>

	<div class="panel-body">
		<?php
		if(isset($_GET['cust_view']))
		{
			$cust_view=$_GET['cust_view'];
		}
		else
		{
			$cust_view="ALL";
		}
		?>
		<?php
		//echo "<font color=yellow>Refresh Rate: 120 Sec.</font>";
		$sql="select max(ims_log_date) as \"lastup\" from $bai_pro3.ims_log";
		// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			//echo "Last Update at: ".$sql_row['lastup']."<br/>";
		}
		$sqlx="SELECT section_display_name,section_head AS sec_head,ims_priority_boxs,GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM bai_pro3.`module_master` LEFT JOIN bai_pro3.sections_master ON module_master.section=sections_master.sec_name WHERE section>0 GROUP BY section ORDER BY section + 0";
		// mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowx=mysqli_fetch_array($sql_resultx))
		{
			$section=$sql_rowx['sec_id'];
			$section_head=$sql_rowx['sec_head'];
			$section_mods=$sql_rowx['sec_mods'];
			$section_display_name=$sql_rowx['section_display_name'];
			$priority_limit=$sql_rowx['ims_priority_boxes'];

		//echo '<div style="border: 3px coral solid; width: 200px; height: 1200px; float: left; margin: 10px; padding: 10px; overflow: scroll;">';
		echo '<div style="background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin: 5px; padding: 10px;width:300px;">';
		echo "<p>";
		//echo "<a href=\"$dns_adr/projects/alpha/anu/ims/sec_rep.php?section=$section\" onclick=\"Popup=window.open('$dns_adr/projects/alpha/anu/ims/sec_rep.php?section=$section"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><font style=\"font-size:24px;color:#000000;\"><b>SECTION - $section</b><br><font style=\"font-size:16px;font-color:#000000;\">($section_head)</font></font></a>";
		echo "<font style=\"font-size:24px;color:#000000;\"><b>$section_display_name</b><br><font style=\"font-size:16px;font-color:#000000;\"></font></font></a>";
		//echo "<br/><div id=\"progressBar\" class=\"progressBar$section\"><div></div></div>";
		echo "<table>";
		//echo "modules no".$section_mods;
		$sch_count=ims_schedules($link,$section_mods);
		$sch_values=ims_schedules_input($link,$section_mods);

		//$loss_val=loss_sca($link,$section_mods);
		$mods=array();
		$mods=explode(",",$section_mods);
		$tot_boxes_section=0;
		$more_than_3days=0;
		for($x=0;$x<sizeof($mods);$x++)
		{
			//NEW for showing all modules
			//$module=$sql_row['module'];
			$module=$mods[$x];
			if(!in_array($module,$double_modules))
			{
				//$iu_module_highlight="";
				//if(in_array($module,$iu_modules))
				//{
				//	$iu_module_highlight="bgcolor=\"$iu_module_highlight_color\"";
				//}
			echo "<tr class=\"bottom\">";
			
			echo "<td class=\"bottom\" style=\"width=20px\"><font class=\"fontnn\" color=Black >$module</font></td>";
			
			echo "<td class=\"bottom\"></td>";
			echo "<td class=\"bottom\" style=\"width=470px\">";
			
			$wip_qty=0;
			$sql1="SELECT distinct(ims_schedule) as schedule ,rand_track FROM $bai_pro3.ims_log WHERE ims_mod_no=$module AND ims_status <> \"DONE\" AND ims_remarks not in ('EXCESS') group by ims_schedule order by tid";
			// mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result1);
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$ims_schedule=$sql_row1['schedule'];
				$rand_track=$sql_row1['rand_track'];
				//NEW
				$sql11="select req_date from $bai_pro3.ims_exceptions where ims_rand_track=$rand_track";
				// mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$rand_check=mysqli_num_rows($sql_result11);
				while($sql_row11=mysqli_fetch_array($sql_result11))
				{
					$end_time=$sql_row11['req_date'];
				}
				$blink_start_tag="";
				$blink_end_tag="";
				//NEW
				$sql11="SELECT ims_doc_no, sum(ims_qty-ims_pro_qty) as \"wip\",ims_schedule as sch,ims_color as col,ims_date,ims_style,ims_remarks FROM $bai_pro3.ims_log WHERE ims_mod_no=$module AND ims_status <> \"DONE\" and ims_schedule=$ims_schedule";
				//echo $sql11;
				// mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row11=mysqli_fetch_array($sql_result11))
				{
					$ims_doc_no=$sql_row11['ims_doc_no'];
					$wip_qty+=$sql_row11['wip'];
					$schedule_no=$sql_row11['sch'];
					$color_name=$sql_row11["col"];
					$ims_date=$sql_row11["ims_date"];
					$ims_style=$sql_row11["ims_style"];
					$job_wip=$sql_row11["wip"];
					$tot_boxes_section+=1;
					$ims_remarks=$sql_row11['ims_remarks'];
				}
				//$schedule_no=215635;
				$ex_factory="";
				$sql="select * from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$schedule_no."\" and order_col_des=\"".$color_name."\"";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error2 =".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$order_total_qty=$sql_row["order_s_xs"]+$sql_row["order_s_s"]+$sql_row["order_s_m"]+$sql_row["order_s_l"]+$sql_row["order_s_xl"]+$sql_row["order_s_xxl"]+$sql_row["order_s_xxxl"]+$sql_row["order_s_s06"]+$sql_row["order_s_s08"]+$sql_row["order_s_s10"]+$sql_row["order_s_s12"]+$sql_row["order_s_s14"]+$sql_row["order_s_s16"]+$sql_row["order_s_s18"]+$sql_row["order_s_s20"]+$sql_row["order_s_s22"]+$sql_row["order_s_s24"]+$sql_row["order_s_s26"]+$sql_row["order_s_s28"]+$sql_row["order_s_s30"];
					
					$rej_perc=0;
					if($sql_row["output"]>0)
					{
						$rej_perc=round((($sql_row["act_rej"]/$sql_row["output"])*100),1);
					}
					
					//If Ex-Factory is missing then consider the order date as exfactory
					$ex_factory=$sql_row['order_date'];
				}
				//Ex-Factory
				$sql="select ex_factory_date_new as ex_factory from $bai_pro4.week_delivery_plan_ref where schedule_no=\"".$schedule_no."\"";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error2 =$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$ex_factory=$sql_row['ex_factory'];
				}
				if($cust_view=="ALL")
				{
					$sch_color='';
				$sch_values2=ims_schedules_input2($link,$section_mods,$schedule_no);
					$sch_color=$sch_values2[0];
					
				if($sch_color>=0 && $sch_color<=25 )
				{
					$ids="down";
				}
				else if($sch_color>=26 && $sch_color<=60 )
				{
					$ids="orange";
				}
				else if($sch_color>=61 && $sch_color<=85 )
				{
					$ids="yellow";
				}
				else
				{
					$ids="green";
				}	
					$title=str_pad("Style: ".$sch_values2[1],20)."\n".str_pad("Schedule: ".$sch_values2[2],20)."\n".str_pad("Customer Order Quantity: ".$sch_values2[6],20)."\n".str_pad("Committed Order/Ship Quantity: ".$sch_values2[7],20)."\n".str_pad("Cut Quantity: ".$sch_values2[5],20)."\n".str_pad("Input Quantity: ".$sch_values2[3],20)."\n".str_pad("Output Quantity: ".$sch_values2[4],20)."\n".str_pad("Production Loss %: ".$sch_values2[9],20)."\n".str_pad("Target Achievement %: ".$sch_values2[8],25)."\n".str_pad("Actual Achievement %: ".$sch_values2[10],20);
					echo "<div id=\"$ids\" $add_css  title=\"$title\" >$schedule_no</div>    ";	
				}
			}
			echo "</td>";
			echo "<td class=\"bottom\"></td>";
			echo "<td class=\"bottom\"></td>";
			//IPS 
			{
			echo "<td>";
			//$sql1="SELECT * from plan_dash_doc_summ where module=$module order by priority limit 4"; New to correct
				$sql1="SELECT * from $bai_pro3.plan_dash_doc_summ where module=$module and act_cut_issue_status<>\"DONE\" order by priority limit 1";
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
					
				}
			echo "</td>";
			//IPS
			}
			//echo "<td class=\"bottom\"><font color=white>$sql_num_check</font></td>";
			echo "</tr>";

		}
		}
		//echo "schedule Count fun ".$sch_counte;
		//echo "sch count=".$sch_count;	
     
		echo "<table class=\"data\" border=1px ><tr><td>Total Schedules</td><td>Extra Shipment Completed Schedules</td><td>%</td></tr>";
    if($sch_count>0)
		$ext_ach_per=round((($sch_values[1]/$sch_count)*100),2);
		echo "<tr><td>$sch_count</td><td>$sch_values[1]</td><td>$ext_ach_per%</td></tr>";

		echo "<tr border=1px><td COLSPAN=2>Total Achievement</td><td>$sch_values[0]%</td></tr>";
		echo "</table> </table>";
		echo "</p>";
		echo '</div>';
		}
		?>
	</div>
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