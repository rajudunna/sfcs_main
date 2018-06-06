<!--
Core Module:In this interface we can get module wise trims allocation details.

Description: We can see the trims availability status.

Changes Log:2013-11-25/DharaniD/Ticket #988194 change order in trims status ie($trims_statusx)
2014-02-01/DharaniD/Ticket #663887 change the buyer division display based on the pink,logo,IU as per plan_modules  
2014-02-08/DharaniD/Ticket #424781 Disply buyer division from the database level plan_module table, change the display buyer name as per plan_modules table.  

2014-02-08/DharaniD/Ticket #688771 Display IU modues Priorit boxes with "IU" Symbol , if it is emblishment display "IX".

2014-07-10/ DharaniD / service request #359982 / Add IU for new schedule like L____W(or)X(or)Y(or)Z and  O____W(or)X(or)Y(or)Z (previously L____Y(or)Z and  O____Y(or)Z)

edited by sudheer and chandu in 23-04-2018 at 17.6868° N, 83.2185° E
-->



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

.lgreen {
  width:20px;
  height:20px;
  background-color: #339900;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
 
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
  background-color: #991144;
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
  background-color: #991144;
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

.brown {
  width:20px;
  height:20px;
  background-color: #333333;
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

<?php
$double_modules=array();
//$username_list=explode('\\',$_SERVER['REMOTE_USER']);
//$username=strtolower($username_list[1]);
$username="sfcsproject1";
$authorized=array("sfcsproject1");//Job Loading
$authorized1=array("sfcsproject1");

set_time_limit(200000);
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));

?>

<!DOCTYPE html>
<html>
<head>
<title>IPS Dashboard</title>
<?php

	echo '<META HTTP-EQUIV="refresh" content="120">';	
?>
<!--<script type="text/javascript" src="jquery.js"></script>-->

<!--<link rel="stylesheet" href="styles/bootstrap.min.css">-->
<?php

//$username_list=explode('\\',$_SERVER['REMOTE_USER']);
//$username=strtolower($username_list[1]);
// $username="sfcsproject1";
$special_users=array("sfcsproject1","kirang","rameshk","chathurangad","indikades","minuram","sfcsproject1","buddhikam");
if(!in_array($username,$special_users))
{
	echo '<script>
	var ctrlPressed = false;
	$(document).keydown(function(evt) {
	  if (evt.which == 17 || evt.which == 13) { // ctrl
	    ctrlPressed = true;
		sweetAlert("This key has been disabled.","","warning");
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
		y=document.getElementById('view_div').value;
		window.location = "<?= getFullURL($_GET['r'],'tms_dashboard_input_v22.php','N') ?>+&view=2&view_div="+encodeURIComponent(y);
	}

	function redirect_dash()
	{
		y=document.getElementById('view_div').value;
		z=document.getElementById('view_dash').value;
		window.location = "<?= getFullURL($_GET['r'],'tms_dashboard_input_v22.php','N') ?>+&view="+z+"&view_div="+encodeURIComponent(y);
	}
</script>

<script>
function blink_new(x)
{	
	// obj="#"+x;
	
	// if ( $(obj).length ) 
	// {
	// 	$(obj).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
	// }
	$("div[id='SJ"+x+"']").each(function() {
	
	$(this).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
	});
}

function blink_new3(x)
{
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
	}
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

<?php

$newtempname="plan_doc_summ_input_".$username;
// echo $newtempname;
$sql="DROP TABLE IF EXISTS temp_pool_db.$newtempname";
//echo $sql."<br/>";
mysqli_query($link, $sql) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));

//$sql="CREATE  TABLE temp_pool_db.$newtempname ENGINE = MYISAM SELECT MIN(st_status) AS st_status,order_style_no,input_job_no_random,GROUP_CONCAT(DISTINCT order_del_no) AS order_del_no,GROUP_CONCAT(DISTINCT input_job_no) AS input_job_no,GROUP_CONCAT(DISTINCT doc_no) AS doc_no FROM plan_doc_summ_input GROUP BY input_job_no_random";
$sql="CREATE  TABLE $temp_pool_db.$newtempname ENGINE = myisam SELECT st_status,act_cut_status,doc_no,order_style_no,order_del_no,order_col_des,carton_act_qty AS total,input_job_no AS acutno,GROUP_CONCAT(DISTINCT CHAR(color_code)) AS color_code,input_job_no,input_job_no_random,input_job_no_random_ref FROM $bai_pro3.plan_dash_doc_summ_input GROUP BY input_job_no_random_ref ORDER BY input_priority";
if($username='sfcsproject1'){
	//echo $sql."<br/>";
}


mysqli_query($link, $sql) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));

//echo "<font size=4>LIVE TRIMS STATUS DASHBOARD";
?>
<div class="panel panel-primary">
<div class="panel-heading"><strong>IPS Dashboard</strong></div>
<div class="panel-body">
	<div class="form-inline">
		<div class="form-group">
			<?php
				echo 'Sewing Job Track: <input type="text" name="sewing" id="sewing" class="form-control alpha" onkeyup="blink_new(this.value)" size="10">&nbsp;&nbsp;';
			?>
		</div>
		<div class="form-group">
			<?php
				echo 'Schedule Track: <input type="text" name="schedule" id="schedule"  class="form-control integer" onkeyup="blink_new3(this.value)" size="10"> &nbsp;&nbsp;';
			?>
		</div>

		<div class="form-group">
		<?php	
			echo 'Buyer Division :
			<select name="view_div" id="view_div" class="form-control" onchange="redirect_view()">';
			echo "<option value=\"ALL\" selected >ALL</option>";
			//$sqly="select distinct(buyer_div) from plan_modules";
			$sqly="SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code";
			//echo $sqly."<br>";

			// mysqli_query($link, $sqly) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rowy=mysqli_fetch_array($sql_resulty))
			{
				$buyer_div=$sql_rowy['buyer_div'];
				$buyer_name=$sql_rowy['buyer_name'];

				if(urldecode($_GET["view_div"])=="$buyer_name") 
				{
					echo "<option value=\"".$buyer_name."\" selected>".$buyer_div."</option>";  
				} 
				else 
				{
					echo "<option value=\"".$buyer_name."\" >".$buyer_div."</option>"; 
				}
			}

			echo '</select>';
			echo "</font></br>";
			?>
		</div>
	</div>
<?php

//For blinking priorties as per the section module wips
$bindex=0;
$blink_docs=array();
$table_name="temp_pool_db.plan_dash_doc_summ_input_".$username;

$sql="DROP TABLE IF EXISTS $table_name";
//echo $sql."<br/>";
mysqli_query($link, $sql) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="CREATE  TABLE $table_name ENGINE = myisam SELECT * FROM $bai_pro3.plan_dash_doc_summ_input ";
if($username='sfcsproject1'){
	//echo $sql."<br/>";
}
mysqli_query($link, $sql) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));



$sqlx="select * from $bai_pro3.sections_db where sec_id>0";
//echo $sqlx;
// mysqli_query($link, $sqlx) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$section=$sql_rowx['sec_id'];
	$section_head=$sql_rowx['sec_head'];
	$section_mods=$sql_rowx['sec_mods'];

	if($_GET["view_div"]!='ALL' && $_GET["view_div"]!='')
	{
		//echo "Buyer=".urldecode($_GET["view_div"])."<br>";
		$buyer_division=urldecode($_GET["view_div"]);
		//echo '"'.str_replace(",",'","',$buyer_division).'"'."<br>";
		$buyer_division_ref='"'.str_replace(",",'","',$buyer_division).'"';
		$order_div_ref="and order_div in (".$buyer_division_ref.")";
	}
	else {
		 $order_div_ref='';
	}	
	// Ticket #424781 change the buyer division display based on the pink,logo,IU as per plan_modules
	$sql1d="SELECT module_id as modx from $bai_pro3.plan_modules where module_id in (".$section_mods.") order by module_id*1";
    if($_GET["view_div"]=="ALL" or $_GET["view_div"]=="")
    {
		$sql1d="SELECT module_id as modx from $bai_pro3.plan_modules where module_id in (".$section_mods.") order by module_id*1";
	}
	else
	{
		$sql1d="SELECT module_id as modx from $bai_pro3.plan_modules where module_id in (".$section_mods.") order by module_id*1"; 
	}
	//echo $sql1d."<br>";
	$sql_num_checkd=0;
	// mysqli_query($link, $sql1d) or exit("Sql Errord".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result1d=mysqli_query($link, $sql1d) or exit("Sql Errordd".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_checkd=mysqli_num_rows($sql_result1d);
	//echo $sql_num_checkd."<br>";
	if($sql_num_checkd > 0)
	{		
		$mods=array();
		while($sql_row1d=mysqli_fetch_array($sql_result1d))
		{
			$mods[]=$sql_row1d["modx"];
		}
	$popup_url = getFullURLLevel($_GET['r'],'board_update_V2_input.php',0,'R');
	echo '<div style="background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin: 10px; padding: 10px;height:100%;">';
	echo "<p>";
	echo "<table>";
	echo "<tr><th colspan=2><h2><a href=\"javascript:void(0)\" onclick=\"Popup=window.open('$popup_url?section_no=$section"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=880,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">SECTION - $section</a></h2></th></th></tr>";

	//$mods=array();  // commented for module division seperation
	//$mods=explode(",",$section_mods);  // commented for module division seperation
	
	//For Section level blinking
	$blink_minimum=0;
	

	for($x=0;$x<sizeof($mods);$x++)
	{
		$module=$mods[$x];
		$blink_check=0;
		
		$sql11="select sum(ims_qty-ims_pro_qty) as \"wip\" from $bai_pro3.ims_log where ims_mod_no=$module";
		 
		//echo "query=".$sql11;
		// mysqli_query($link, $sql11) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row11=mysqli_fetch_array($sql_result11))
		{
			$wip=$sql_row11['wip'];
		} 
		
		echo "<tr class=\"bottom\">";
		echo "<td class=\"bottom\"><strong><a href=\"javascript:void(0)\" title=\"WIP : $wip\"><font class=\"fontnn\" color=black >$module</font></a></strong></td><td>";
		$id="yash";
		$y=0;
		$sql="SELECT * FROM $table_name WHERE (input_trims_status!=4 or input_trims_status IS NULL or input_panel_status!=2 or input_panel_status IS NULL) and input_module=$module and date(log_time) >=\"2013-01-09\" ".$order_div_ref." GROUP BY input_job_no_random_ref order by input_priority asc";	
		
		// echo $sql."<br>";
		$result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($result))
		{
			if($y==4)
			{
				break;
			}
			
			$input_job_no_random_ref=$row["input_job_no_random_ref"];
			$input_trims_status=$row["input_trims_status"];
			
			$add_css="behavior: url(border-radius-ie8.htc);  border-radius: 10px;";
			if($input_trims_status>1)
			{
				$add_css="";
			}
			
			$sql3="select DISTINCT(SUBSTRING_INDEX(order_joins,'J',-1)) AS order_joins from $bai_pro3.packing_summary_input WHERE input_job_no_random=\"".$input_job_no_random_ref."\"";
			// echo $sql3."<br>";
			$result3=mysqli_query($link, $sql3) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row3=mysqli_fetch_array($result3))
			{
				$clubbed_schedule_ref=$row3['order_joins'];
			}
			
			$sql2="SELECT min(st_status) as st_status,order_style_no,group_concat(distinct order_del_no) as order_del_no,group_concat(distinct input_job_no) as input_job_no,group_concat(distinct doc_no) as doc_no FROM $temp_pool_db.$newtempname WHERE input_job_no_random='$input_job_no_random_ref'";	
			
				// echo $sql2."<br>";
			
			$result2=mysqli_query($link, $sql2) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row2=mysqli_fetch_array($result2))
			{
				$trims_status=$row2['st_status'];
				$style=$row2['order_style_no'];
				$schedule=$row2['order_del_no'];
				$input_job_no=$row2['input_job_no'];
				$doc_no_ref=$row2['doc_no'];
				$schedule_no=$row2['order_del_no'];
			}
			
			if($clubbed_schedule_ref > 0)
			{
				$schedule=$clubbed_schedule_ref;
				$sql_doc="select group_concat(doc_no) as doc_ref from $bai_pro3.plandoc_stat_log where order_tid like \"%".$clubbed_schedule_ref."%\"";
				$result_doc=mysqli_query($link, $sql_doc) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row_doc=mysqli_fetch_array($result_doc))
				{
					$doc_no_ref=$row_doc["doc_ref"];
				}
			}
			
			$ft_status_min="";
			if($schedule!="")
			{
				$sel_fab_sts="select max(ft_status) as ft_status from $bai_pro3.bai_orders_db_confirm where order_del_no in (".$schedule.")";
				$result_fab_sts=mysqli_query($link, $sel_fab_sts) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row_fab_sts=mysqli_fetch_array($result_fab_sts))
				{
					$fabric_status=$row_fab_sts['ft_status'];
				}
			
			
			$doc_no_ref_explode=explode(",",$doc_no_ref);
			
			$num_docs=sizeof($doc_no_ref_explode);
			//echo sizeof($num_docs)."-".$fabric_status."<br>";
			switch ($fabric_status)
			{
				case "1":
				{
					$id="green";					
					$rem="Available";
					if(sizeof($num_docs) > 0)
					{
						$sql1x1="select * from $bai_pro3.fabric_priorities where doc_ref in ($doc_no_ref) and hour(issued_time)+minute(issued_time)>0";
						//echo $sql1x1."<br>";
						$sql_result1x1=mysqli_query($link, $sql1x1) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($sql_result1x1)==$num_docs)
						{
							$id="yellow";
						}
						else
						{
							$id="green";
							//$id=$id;
						}
					}
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
					if(sizeof($num_docs) > 0)
					{
						$sql1x1="select * from $bai_pro3.fabric_priorities where doc_ref in ($doc_no_ref) and hour(issued_time)+minute(issued_time)>0";
						//echo $sql1x1."<br>";
						$sql_result1x1=mysqli_query($link, $sql1x1) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($sql_result1x1)==$num_docs)
						{
							$id="yellow";
						}
						else
						{
							$id="green";
							//$id=$id;
						}
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
			
			$sqly="SELECT group_concat(doc_no) as doc_no,sum(carton_act_qty) as carton_qty FROM $bai_pro3.packing_summary_input WHERE input_job_no_random='".$input_job_no_random_ref."' ORDER BY acutno";
			//echo $sqly."<br>";
			$resulty=mysqli_query($link, $sqly) or die("Error=$sqly".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rowy=mysqli_fetch_array($resulty))
			{
				$doc_no_ref_input=$sql_rowy["doc_no"];
				$carton_qty=$sql_rowy["carton_qty"];
			}
			if(strlen($doc_no_ref_input)==0)
			{
				$doc_no_ref_input=0;
			}
			$sql11x="select * from $bai_pro3.fabric_priorities where doc_ref in (".$doc_no_ref_input.")";
			// echo $sql11x."<br>";
			$sql_result11x=mysqli_query($link, $sql11x) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result11x)==$num_docs and $id!="yellow")
			{
				$id="lgreen";	
			} 
			
			$sql1x1="select * from $bai_pro3.fabric_priorities where doc_ref in (".$doc_no_ref_input.") and hour(issued_time)+minute(issued_time)>0";
			$sql_result1x1=mysqli_query($link, $sql1x1) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result1x1)>0)
			{
				$id="yellow";
			}
			
			$sql11x1="select * from $bai_pro3.plandoc_stat_log where doc_no in (".$doc_no_ref_input.") and act_cut_status=\"DONE\"";
			//echo $sql11x1."<br>";
			$sql_result11x1=mysqli_query($link, $sql11x1) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result11x1)>0 and $id=="yellow")
			{
				$id="blue";
			} 
			
			$firststy=substr($order_tid,0,strpos($order_tid," "));
			
			unset($club_c_code);
			$club_c_code=array();
			
			$sql33x1="SELECT * FROM $bai_pro3.plan_dash_doc_summ where doc_no in (".$doc_no_ref_input.")";
			$sql_result33x1=mysqli_query($link, $sql33x1) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row33x1=mysqli_fetch_array($sql_result33x1))
			{
			 $clubbing=$sql_row33x1['clubbing'];
					
				if($clubbing>0)
				{
					$sql111="select color_code,acutno from $bai_pro3.order_cat_doc_mk_mix where category in ('Body','Front') and order_del_no=$schedule_no and clubbing=".$sql_row33x1['clubbing']." and acutno=".$sql_row33x1['acutno'];
					$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row111=mysqli_fetch_array($sql_result111))
					{
						$club_c_code[]=chr($sql_row111['color_code']).leading_zeros($sql_row111['acutno'],3);
					} 
				}
				else
				{
					$club_c_code[]=chr($sql_row33x1['color_code']).leading_zeros($sql_row33x1['acutno'],3);
				}
			}
			
			$club_c_code=array_unique($club_c_code);
			
			$title=str_pad("Style:".$style,50)."\n".str_pad("Schedule:".$schedule,50)."\n".str_pad("Sewing Job No:".'J'.leading_zeros($input_job_no,3),50)."\n".str_pad("Total_Qty:".$carton_qty,50)."\n".str_pad("Cut Job No:".implode(", ",$club_c_code),50);
				$ui_url=getFullURL($_GET['r'],'input_status_update_input.php','R');		
				if(in_array($username,$authorized1))
				{
					if($id=="blue" or $id=="yellow")
					{
						echo "<div id=\"S$schedule\" style=\"float:left;\">
								<div id=\"SJ$input_job_no\" style=\"float:left;\">
									<div id=\"$input_job_no_random_ref\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id;$add_css\" title=\"$title\" ><a href=\"$ui_url?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no_random_ref&job_status=$id\" onclick=\"Popup=window.open('$ui_url?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no_random_ref&job_status=$id','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=auto, top=23'); if (window.focus) {Popup.focus()} return false;\"><font style=\"color:black;\">$letter$ft_status</font></a>
									</div>
								</div>
							</div>";
					}
					else
					{
						echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"SJ$input_job_no\" style=\"float:left;\"><div id=\"$input_job_no_random_ref\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id;$add_css\" title=\"$title\" ><a href=\"$ui_url?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no_random_ref&job_status=$id\" onclick=\"Popup=window.open('$ui_url?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no_random_ref&job_status=$id','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><font style=\"color:black;\">$letter$ft_status</font></a></div></div></div>";
					}
				}
				else
				{
					echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"SJ$input_job_no\" style=\"float:left;\"><div id=\"$input_job_no_random_ref\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id\" title=\"$title\" ><a href=\"#\" ><font style=\"color:black;\">$letter$ft_status</font></a></div></div></div>";

				}
				
			$y++;
			}
		}
		for($j=$y+1;$j<=4;$j++)
		{
			if(in_array($username,$authorized))
			{
				
				$urll = getFullURLLevel($_GET["r"],'cut_jobs_loading.php',0,'N');
				// echo $urll;
				echo "<div id=\"\" style=\"float:left;\"><div id=\"$input_job_no_random_ref\" style=\"float:left;\"><div id=\"$input_job_no_random_ref\" class=\"white\" style=\"font-size:12px; text-align:center; color:white\"><a href=\"javascript:void(0)\" onclick=\"Popup=window.open('".$urll."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=1200,height=800, top=23'); if (window.focus) {Popup.focus()} return false;\"><font style=\"font-size:15px;color:#000000;\"></font></a></div></div></div>";

			}
			else
			{
				echo "<div id=\"\" style=\"float:left;\">
						<div id=\"$input_job_no_random_ref\" style=\"float:left;\">
							<div id=\"$input_job_no_random_ref\" class=\"white\" style=\"font-size:12px; text-align:center; color:white\">
							</div>
						</div>
					</div>";

			}
		}
		
		// Ticket #663887 dispaly the buyer name of module at the end of boxes
        $sqly="select buyer_div from $bai_pro3.plan_modules where module_id=$module";
	    //echo $sqly."<br>";
		// mysqli_query($link, $sqly) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowy=mysqli_fetch_array($sql_resulty))
		{
			$buyer_div=$sql_rowy['buyer_div'];
			
			if(substr($buyer_div,0,1)=="M")
			{
				$cut_wip_control=7000;
			}		
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
}
if((in_array(strtolower($username),$authorized)))
	{
		echo "<script>";
		echo "blink_new_priority('".implode(",",$blink_docs)."');";
		echo "</script>";
	}
?>

<div style="clear: both;"> </div>

<?php
include "include_legends_ips.php";
?>
</div>
</div>
</div>
</div>
</body>
</html>