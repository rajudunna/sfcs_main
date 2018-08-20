
<!--
Core Module:In this interface we can get module wise fabric allocation details.

Description: We can see the Fabric availability status.

Changes Log:

Service Request #525434/ kirang/ 2014-01-10: Add the ordercut details in RTS dashboard. 
-->

<?php
	$double_modules=array();
?>

<?php

	set_time_limit(200000);
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
    $view_access=user_acl("SFCS_0197",$username,1,$group_id_sfcs);
	$authorized=user_acl("SFCS_0197",$username,7,$group_id_sfcs); 

?>
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

<!-- <script type="text/javascript" src="jquery.js"></script> -->


<?php

	$username_list=explode('\\',$_SERVER['REMOTE_USER']);
	$username=strtolower($username_list[1]);
	$special_users=array("kirang","kirang","kirang","kirang");
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
		y=document.getElementById('view_div').value;
		x=document.getElementById('view_cat').value;
		var ajax_url = "<?= getFullURL($_GET['r'],'fab_pps_recut_dashboard_v4.php','N') ?>+&view=2&view_cat="+x+"&view_div="+encodeURIComponent(y);
		Ajaxify(ajax_url,'production_body');


		/* Old Code for Re-direction*/
		// url = "<?= getFullURL($_GET['r'],'fab_pps_recut_dashboard_v4.php','N') ?>";
		// alert(url);
		// y=document.getElementById('view_div').value;
		// x=document.getElementById('view_cat').value;
		// alert(y);
		// window.location = url+"&view=2&view_cat="+x+"&view_div="+y;
		//alert(x+"-"+y);	
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
		
		$(this).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400);
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
  margin: 2px;
border: 1px solid #000000;
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
border: 1px solid #000000;
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
border: 1px solid #000000;
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
border: 1px solid #000000;
 
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
border: 1px solid #000000;
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
border: 1px solid #000000;
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
border: 1px solid #000000;
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
border: 1px solid #000000;
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
border: 1px solid #000000;
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
border: 1px solid #000000;
}

.brown {
  width:20px;
  height:20px;
  background-color: #333333;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid #000000;
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
	//Add the ordercut details in RTS dashboard. 
	// for speed_delivery schedules


	$speed_sch=array();
	$sqlq= "SELECT speed_schedule FROM $bai_pro3.speed_del_dashboard";
	$sql_result13=mysqli_query($link, $sqlq) or exit("sql error11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row13=mysqli_fetch_array($sql_result13))
	{
		$speed_sch[]=$sql_row13['speed_schedule'];
	}

	//NEW to correct
	/*
	$remove_docs=array();
	$sqlx="select doc_no from plan_dash_doc_summ where act_cut_issue_status=\"DONE\"";
	mysql_query($sqlx,$link) or exit("Sql Error".mysql_error());
	$sql_resultx=mysql_query($sqlx,$link) or exit("Sql Error".mysql_error());
	while($sql_rowx=mysql_fetch_array($sql_resultx))
	{
		$remove_docs[]=$sql_rowx['doc_no'];
	}

	if(sizeof($remove_docs)>0)
	{
		
	$sqlx="delete from plan_dashboard where doc_no in (".implode(",",$remove_docs).")";
	mysql_query($sqlx,$link) or exit("Sql Error".mysql_error());
	}
	*/

	/*echo "<p style=\"float:right;\"><font size=4><table>
	<tr>
	<td><div class='yash'></div></td><td>Requested.|</td>
	<td><div class='pink'></div></td><td>Marker Ready.|</td>
	<td><div class='red'></div></td><td>RM Not Available.|</td>
	<td><div class='green'></div></td><td>RM Available.|</td>
	<td><div class='yellow'></div></td><td>RM Issued.|</td>
	<td><div class='blue'></div></td><td>Cut Completed.|</td>
	<td><div style=\"color:white;\">X</div></td><td>=Today ExFactory.</td>
	</tr>
	</table></font>
	<br/>";*/
	//echo "<font size=4><a href=\"javascript:void(0)\" onclick=\"Popup=window.open('cutting_wip_alert_email.php?alertfilter=1"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">Available Input</a></font>";
	//echo "<br/><font size=4><a onmouseover=\"window.status='BAINet'; return true;\" href=\"fab_pps_dashboard_v2.php?view=1\"  onmouseover=\"window.status='BAINet'; return true;\" onmouseout=\"window.status='';return true;\">Quick View</a></font><br/><font size=4><a onmouseover=\"window.status='BAINet'; return true;\" href=\"fab_pps_dashboard_v2.php?view=3\"  onmouseover=\"window.status='BAINet'; return true;\" onmouseout=\"window.status='';return true;\">Cut View</a></font>";

	// echo "</p>";
	// $url = getFullURL($_GET['r'],'recut.htm','N');
	echo "<div class='panel panel-primary'>
			<div class='panel-heading'><b>Recut Status Dashboard</b><button class='btn btn-warning btn-xs pull-right'><a href='".getFullURL($_GET['r'],'recut.htm','N')."' target=\"_blank\">?</a></button></div>
			<div class='panel-body'>";
	//echo "<font size=4>LIVE RECUT STATUS DASHBOARD";
	if($_GET['view']==1)
	{
		echo "<font color=yellow> - Quick View</font>";
	}
	if($_GET['view']==3)
	{
		echo "<font color=yellow> - Cut View</font>";
	}
	echo "</font>";
	//echo "<font color=yellow>Refresh Rate: 120 Sec. (ALPHA TESTING)</font>";
	echo '<br/><div class="col-md-12">
	<div class="col-md-3">
		Recut Category Filter
		<select name="view_cat" id="view_cat" onchange="redirect_view()" class="form-control">';
		if($_GET['view_cat']=="ALL") { echo '<option value="ALL" selected>All</option>'; } else { echo '<option value="ALL">All</option>'; }
		if($_GET['view_cat']=="FFFFFF") { echo '<option value="FFFFFF" selected>CAD</option>'; } else { echo '<option value="FFFFFF">CAD</option>'; }
		//if($_GET['view_cat']=="TFFFFF,TTFFFF") { echo '<option value="TFFFFF,TTFFFF" selected>Sourcing</option>'; } else { echo '<option value="TFFFFF,TTFFFF">Sourcing</option>'; }
		if($_GET['view_cat']=="TFFFFF") { echo '<option value="TFFFFF" selected>Sourcing</option>'; } else { echo '<option value="TFFFFF">Sourcing</option>'; }
		if($_GET['view_cat']=="TTTFFF") { echo '<option value="TTTFFF" selected>RM</option>'; } else { echo '<option value="TTTFFF">RM</option>'; }
		if($_GET['view_cat']=="TTTTFF") { echo '<option value="TTTTFF" selected>Cutting</option>'; } else { echo '<option value="TTTTFF">Cutting</option>'; }
		if($_GET['view_cat']=="TTTTTF,TFFFTF") { echo '<option value="TTTTTF,TFFFTF" selected>Production</option>'; } else { echo '<option value="TTTTTF,TFFFTF">Production</option>'; }
		echo '</select>
	</div>';
	echo '<div class="col-md-3">
		Recut Buyer Division
		<select name="view_div" id="view_div" onchange="redirect_view()" class="form-control">';
		if($_GET['view_div']=="ALL") { echo '<option value="ALL" selected>All</option>'; } else { echo '<option value="ALL">All</option>'; }
		/*if($_GET['view_div']=="P,K") { echo '<option value="P,K" selected>Pink</option>'; } else { echo '<option value="P,K">Pink</option>'; }
		if($_GET['view_div']=="L,O,G") { echo '<option value="L,O,G" selected>Logo</option>'; } else { echo '<option value="L,O,G">Logo</option>'; }
		if($_GET['view_div']=="M") { echo '<option value="M" selected>M&S</option>'; } else { echo '<option value="M">M&S</option>'; }
		if($_GET['view_div']=="Y") { echo '<option value="Y" selected>LBI</option>'; } else { echo '<option value="Y">LBI</option>'; }*/

		// $sqly="select distinct(buyer_div) from plan_modules";
		//echo $sqly."<br>";

		// mysqli_query($link, $sqly) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		// $sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		// while($sql_rowy=mysqli_fetch_array($sql_resulty))
		// {
		// 	$buyer_div=$sql_rowy['buyer_div'];
			
		// 	if($_GET["view_div"]=="M")
		// 	{
		// 		$_GET["view_div"]="M&S";
		// 	}
			
		// 	if($_GET['view_div']=="$buyer_div") 
		// 	{
		// 		echo "<option value=\"".$buyer_div."\" selected>".$buyer_div."</option>";  
		// 	} 
		// 	else 
		// 	{
		// 		echo "<option value=\"".$buyer_div."\" >".$buyer_div."</option>"; 
		// 	}
		// }

		$sqly="SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code";
	    // echo $sqly."<br>";
	    $sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	    while($sql_rowy=mysqli_fetch_array($sql_resulty))
		{
			$buyer_div=$sql_rowy['buyer_div'];
			$buyer_name=$sql_rowy['buyer_name'];
	        if($_GET['view_div']==$buyer_name) 
			{
				echo "<option value=\"".$buyer_name."\" selected>".$buyer_div."</option>";  
			} 
			else 
			{
				echo "<option value=\"".$buyer_name."\" >".$buyer_div."</option>"; 
			}
		}

		echo '</select>
	</div>';

	echo "<div class='col-md-3'>
		Schedule Track: <input class='form-control' type=\"text\" onkeyup=\"blink_new3(this.value)\" size=\"10\">&nbsp;&nbsp;&nbsp;
	</div>";
	
	// echo "<div class='col-md-3'>
	// 		<button class='btn btn-info' style='margin-top: 18px;'><a href='".getFullURL($_GET['r'],'recut_color_codes.php','N')."' target=\"_blank\" onclick=\"Popup=window.open('".getFullURL($_GET['r'],'recut_color_codes.php','N').'"'."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">
	// 	Color Codes</a></button>
	// </div>";

	//echo '<div style="border: 0px coral solid; width: 100%; height:50px; float: left; margin: 10px; padding: 10px; overflow: none; display:block;">';
	//echo '<strong><table class="new"><tr class="new" valign="middle"><td><div id="green"></div> RM Ready</td><td><div id="yellow"></div> Partial Input</td><td><div id="orange"></div> CUT Pending/RM N/A</td><td><div id="blue"></div> Cut Completed</td><td><div id="pink"></div> RM Ready CUT Pending</td><td><div id="red"></div> RM Pending</td><td><div id="yash"></div> All Pending</td><td><div id="white"></div> Slot Available</td><td><div id="black"></div> Partial Input/RM N/U</td></tr></table></strong>';
	//echo '</div>';

	//For blinking priorties as per the section module wips
	$bindex=0;
	$blink_docs=array();


	//To reduce overload on bai_pro4 to extract schedule notes_body
	$exdate_arr=array();
	$exdate_sch_arr=array();
	/*$sql_del1="select distinct schedule_no,ex_factory_date_new as exdate from bai_pro4.week_delivery_plan_ref";
	$sql_del_result1=mysql_query($sql_del1,$link) or exit("Sql Error".mysql_error());
	while($sql_row_del1=mysql_fetch_array($sql_del_result1))
	{
		$exdate_sch_arr[]=$sql_row_del1["schedule_no"];
		$exdate_arr[]=$sql_row_del1["exdate"];
	}
	*/
	$sqlx="select * from $bai_pro3.sections_db where sec_id>0";
	$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_rowx=mysqli_fetch_array($sql_resultx))
	{
		$section=$sql_rowx['sec_id'];
		$section_head=$sql_rowx['sec_head'];
		$section_mods=$sql_rowx['sec_mods'];

		echo '<div style="width:300px;background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin: 10px; padding: 10px;">';
		echo "<p>";
		echo "<table>";
		$url = getFullURL($_GET['r'],'board_update_recut.php','N');
		echo "<tr><th colspan=2><h2><a href=\"$url&section_no=$section\" >SECTION - $section</a></h2></th></th></tr>";	
		// echo "<tr><th colspan=2><h2><a href=\"$url&section_no=$section\" onclick=\"Popup=window.open('$url&section_no=$section"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">SECTION - $section</a></h2></th></th></tr>";				
		$mods=array();
		$mods=explode(",",$section_mods);
		
		//For Section level blinking
		$blink_minimum=0;
		

		for($x=0;$x<sizeof($mods);$x++)
		{
			$module=$mods[$x];
				
			echo "<tr class=\"bottom\">";
			echo "<td>$module</td>";

			echo "<td>";
			
			

			// if($_GET["view_div"]=="M&S")
			// {
			// 	$_GET["view_div"]="M";
			// }
			// if($_GET["view_div"]=="CK")
			// {
			// 	$_GET["view_div"]="C";
			// }
			
			// echo $_GET["view_div"];
			// $leter = str_split($_GET["view_div"]);
			$comma = "','";
			$order_tid_query = 'SELECT GROUP_CONCAT(DISTINCT order_tid SEPARATOR "'.$comma.'") AS order_tid FROM '.$bai_pro3.'.bai_orders_db WHERE order_tid IN (SELECT order_tid FROM '.$bai_pro3.'.recut_v2) AND order_div = "'.$_GET["view_div"].'"';
			// echo $order_tid_query.'<br>';
			// die();
			$order_tid_result=mysqli_query($link, $order_tid_query) or exit("Error while getting Order Tid");
			while($sql_row11=mysqli_fetch_array($order_tid_result))
			{
				$order_tid_1=$sql_row11['order_tid'];
			}
			// echo 'order tid:- '.$order_tid_1;
			// die();

			// $sql11="select * from recut_v2 where plan_module=\"$module\" and cut_inp_temp is null and remarks in (\"Body\",\"Front\")";
			//echo $sql11;
			if($_GET["view_div"]=="ALL" or $_GET["view_div"]=="")
			{
				$sql11="select * from $bai_pro3.recut_v2 where plan_module=\"$module\" and cut_inp_temp is null and remarks in ('Body','Front')";
				// echo $sql11;
			}
			else
			{
				// $sql11="select * from recut_v2 where plan_module=\"$module\" and cut_inp_temp is null and remarks in (\"Body\",\"Front\") and (order_tid like \"".$leter[0]."%\")";
				$sql11="select * from $bai_pro3.recut_v2 where plan_module=\"$module\" and cut_inp_temp is null and remarks in (\"Body\",\"Front\") and order_tid IN ('".$order_tid_1."')";
				//echo $sql11;
			}
			// echo $sql11;
			// die();
			/*if($_GET["view_div"]=="P,K")
			{
				$sql11="select * from recut_v2 where plan_module=\"$module\" and cut_inp_temp is null and remarks in (\"Body\",\"Front\") and (order_tid like \"P%\" or order_tid like \"K%\")";		//echo $sql11;	
			}
			
			if($_GET["view_div"]=="L,O,G")
			{
				$sql11="select * from recut_v2 where plan_module=\"$module\" and cut_inp_temp is null and remarks in (\"Body\",\"Front\") and (order_tid like \"L%\" or order_tid like \"O%\" OR order_tid like \"G%\" OR order_tid like \"U%\")";
			}
			if($_GET["view_div"]=="Y")
			{
				$sql11="select * from recut_v2 where plan_module=\"$module\" and cut_inp_temp is null and remarks in (\"Body\",\"Front\") and (order_tid like \"Y%\")";
			}
			if($_GET["view_div"]=="CK")
			{
				$sql11="select * from recut_v2 where plan_module=\"$module\" and cut_inp_temp is null and remarks in (\"Body\",\"Front\") and (order_tid like \"C%\")";
				
			}
			if($_GET["view_div"]=="M")
			{
				$sql11="select * from recut_v2 where plan_module=\"$module\" and cut_inp_temp is null and remarks in (\"Body\",\"Front\") and (order_tid like \"M%\")";
			}*/
			//echo $sql11;
			$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$recut_count=mysqli_num_rows($sql_result11);
			
				if($recut_count>0)
				{
						while($sql_row11=mysqli_fetch_array($sql_result11))
						{
							$rec_doc_no=$sql_row11['doc_no'];
							$mk_ref=$sql_row11['mk_ref'];
							$fab_status=$sql_row11['fabric_status'];
							$act_cut_status=$sql_row11['act_cut_status'];
							$cut_inp=$sql_row11['cut_inp_temp'];
							$plan_lot_ref=$sql_row11['plan_lot_ref'];
							//EMB
							$act_cut_issue_status=$sql_row11['act_cut_issue_status'];
							//EMB
							
							//
							$req_date=$sql_row11['date'];
							$order_tid=$sql_row11['order_tid'];
							$source_conf_time=$sql_row11['lastup'];
							$total_qty=($sql_row11['a_xs']+$sql_row11['a_s']+$sql_row11['a_m']+$sql_row11['a_l']+$sql_row11['a_xl']+$sql_row11['a_xxl']+$sql_row11['a_xxxl']+$sql_row11['a_s01']+$sql_row11['a_s02']+$sql_row11['a_s03']+$sql_row11['a_s04']+$sql_row11['a_s05']+$sql_row11['a_s06']+$sql_row11['a_s07']+$sql_row11['a_s08']+$sql_row11['a_s09']+$sql_row11['a_s10']+$sql_row11['a_s11']+$sql_row11['a_s12']+$sql_row11['a_s13']+$sql_row11['a_s14']+$sql_row11['a_s15']+$sql_row11['a_s16']+$sql_row11['a_s17']+$sql_row11['a_s18']+$sql_row11['a_s19']+$sql_row11['a_s20']+$sql_row11['a_s21']+$sql_row11['a_s22']+$sql_row11['a_s23']+$sql_row11['a_s24']+$sql_row11['a_s25']+$sql_row11['a_s26']+$sql_row11['a_s27']+$sql_row11['a_s28']+$sql_row11['a_s29']+$sql_row11['a_s30']+$sql_row11['a_s31']+$sql_row11['a_s32']+$sql_row11['a_s33']+$sql_row11['a_s34']+$sql_row11['a_s35']+$sql_row11['a_s36']+$sql_row11['a_s37']+$sql_row11['a_s38']+$sql_row11['a_s39']+$sql_row11['a_s40']+$sql_row11['a_s41']+$sql_row11['a_s42']+$sql_row11['a_s43']+$sql_row11['a_s44']+$sql_row11['a_s45']+$sql_row11['a_s46']+$sql_row11['a_s47']+$sql_row11['a_s48']+$sql_row11['a_s49']+$sql_row11['a_s50'])*$sql_row11['a_plies'];

							//EMB Status
							$sql111="select co_no,order_style_no,order_del_no,order_col_des, (IF(((order_embl_a + order_embl_b) > 0),1,0) + IF(((order_embl_e + order_embl_f) > 0),0,0)) AS emb_stat1 from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
							$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row111=mysqli_fetch_array($sql_result111))
							{
								$style=$sql_row111['order_style_no'];
								$schedule=$sql_row111['order_del_no'];
								$color=$sql_row111['order_col_des'];
								$co_no=$sql_row111['co_no'];
								$emb_stat=$sql_row111['emb_stat1'];
							}
							//EMB Status
							
							$exdate="";
							
							/*$sql_del="select ex_factory_date_new as exdate from bai_pro4.week_delivery_plan_ref where schedule_no=\"$schedule\"";
							$sql_del_result=mysql_query($sql_del,$link) or exit("Sql Error".mysql_error());
							while($sql_row_del=mysql_fetch_array($sql_del_result))
							{
								$exdate=$sql_row_del["exdate"];
							}*/
							
							$key=0;
							$key=array_search($schedule,$exdate_sch_arr);
							$exdate=$exdate_arr[$key];
							$letter="";
							if(date("Y-m-d")== $exdate)
							{
								$letter="x";
								$iustyle=substr($iustyle,0,1);
							}
							
							//EMB Status
							if($emb_stat==1 or $emb_stat==3)
							{
								$letter="<font color=black size=2>X</font>";
								if(strlen($act_cut_issue_status)>0)
								{
									$letter="<font color=black size=2>".substr($act_cut_issue_status,-1)."</font>";
								}
							}
							//EMB Status
							
							$sql_del="select max(ims_log_date) as last_up from $bai_pro3.ims_log where ims_schedule=\"$schedule\"";
							$sql_del_result=mysqli_query($link, $sql_del) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row_del=mysqli_fetch_array($sql_del_result))
							{
								$lastup=$sql_row_del["last_up"];
							}
							
							$title=str_pad("Style:".$style,20).str_pad("CO:".$co_no,20).'&#013'.str_pad("Schedule:".$schedule,20).str_pad("Color:".$color,20).'&#013'.str_pad("Total_Qty:".$total_qty,20).str_pad("Req_Time:".$req_date,20).'&#013'.str_pad("Source Conf. Time:".$source_conf_time,20).'&#013'.str_pad("Last Pro. Rep.:".$lastup,20);
							//
							
							$a=$b=$c=$d=$e=$f="";
							
							
							if($mk_ref>0) {	$a="T";	}else{ $a="F";	} //Marker Update
							if($fab_status>0) {	$b="T";	}else{ $b="F";	} //fabric update
							if($fab_status==1 or $fab_status==5) {	$c="T";	}else{ $c="F";	} // fabric update
							if($fab_status==5) {	$d="T";	}else{ $d="F";	} // fabric available
							if($act_cut_status=="DONE") { $e="T";	}else{ $e="F";	} // cut completion status
							if($cut_inp==1) { $f="T";	}else{ $f="F";	} // cut completion status
							
							$test=$a.$b.$c.$d.$e.$f;
							//echo $test;
							$path="";
							
							$view_cat_color=$_GET["view_cat"];
							$view_cat_colors=explode(",",$view_cat_color);
							//echo $test."-".$view_cat_color."<br>";
							if($view_cat_color!="")
							{
								if(in_array("ALL",$view_cat_colors))
								{
									$test=$test;
								}	
								else if(in_array($test,$view_cat_colors))
								{
									$test=$view_cat_color;
								}
								else
								{
									$test="";
									$letter="";
								}
							}
							//echo $test."<br>";
							$path1 =  getFullURL($_GET['r'],'cad_pop_details.php','N');
							$path2 =  getFullURL($_GET['r'],'fab_pop_details_recut_v2.php','N');				
							switch($test)
							{
								case "FFFFFF":
								{
									$id="yash";
									$path= $path1."&code=1&doc_no=$rec_doc_no";
									break;
								}
								case "TFFFFF":
								{
									$id="pink";
									$path=$path1."&code=2&doc_no=$rec_doc_no";
									break;
								}
								case "TTTFFF":
								{
									$id="green";
									if(strlen($plan_lot_ref)>0)
										{
											$id="lgreen";
										}
									$path=$path2."&doc_no=$rec_doc_no";
									break;
								}
								case "TTFFFF":
								{
									$id="red";
									$path=$path1."&code=2&doc_no=$rec_doc_no";
									break;
								}
								case "TTTTFF":
								{
									$id="yellow";
									$path=$path1."&code=0&doc_no=$rec_doc_no";
									break;
								}
								case "TTTTTF":
								{
									$id="blue";
									$path=$path1."&code=3&doc_no=$rec_doc_no&emb_stat=$emb_stat&act_cut_issue_status=$act_cut_issue_status";
									break;
								}
								case "TFFFTF": //new condition came when fabric issues and cut reported as completed without any logical constrins.
								{
									$id="blue";
									$path=$path1."&code=3&doc_no=$rec_doc_no&emb_stat=$emb_stat&act_cut_issue_status=$act_cut_issue_status";
									break;
								}
								case "TTTTTF,TFFFTF": //new condition came when fabric issues and cut reported as completed without any logical constrins.
								{
									$id="blue";
									$path=$path1."&code=3&doc_no=$rec_doc_no&emb_stat=$emb_stat&act_cut_issue_status=$act_cut_issue_status";
									break;
								}
							}
							
	//Add the ordercut details in RTS dashboard.						
							$sqlt="SELECT * from $bai_pro3.recut_v2 where (order_tid like \"L%Y%\" or order_tid like \"L%Z%\" or order_tid like \"O%Y%\" or order_tid like \"O%Z%\" or order_tid like \"L%X%\" or order_tid like \"L%W%\" or order_tid like \"O%X%\" or order_tid like \"O%W%\") and plan_module=$module and doc_no=$rec_doc_no" ;
				//echo $sqlt;	
			$sql_result12=mysqli_query($link, $sqlt) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$check_num_rows=mysqli_num_rows($sql_result12);		
			while($sql_row12=mysqli_fetch_array($sql_result12))
			{
				$sel_style=$sql_row12['order_tid'];
				//$sel_sch=$sql_row12['order_del_no'];
				$sel_sty=substr($sel_style,0,9);
			}
			
			//echo $module."-schedules:".$sel_sch."-".$sel_sty."-".$ord_style."<br/>";		
		if(($check_num_rows>0 && $sel_sty==$style)||in_array($schedule,$speed_sch))
		{
			$emb_sty=$iustyle."".$letter;
				
		}
		else
		{
			$emb_sty=$letter; 
		}	

							if($test != "")
							{
								echo "<div id=\"S$schedule\" style=\"float:left;\"><div class=\"$id\" title=\"".$title."\"><a href=\"$path\"><center><font color=#ffffff>$emb_sty</font></center></a></div></div>";

								// echo "<div id=\"S$schedule\" style=\"float:left;\"><div class=\"$id\" title=\"".$title."\"><a href=\"$path\" onclick=\"Popup=window.open('$path"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><center><font color=#ffffff>$emb_sty</font></center></a></div></div>";
							}
							
							
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
		
		//RECU
	}


	//RECUT
		
		echo '<div style="width:160px;background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin: 10px; padding: 10px;">';
		echo "<p>";
		echo "<table>";
		$url = getFullURL($_GET['r'],'board_update.php','N');
		echo "<tr><th colspan=2><h2><a href='$url&section_no=$section' >RCut <br/>EMB<br/>CUT<br/>TOP</a></h2></th></th></tr>";
		// echo "<tr><th colspan=2><h2><a href='$url&section_no=$section' onclick=\"Popup=window.open('$url&section_no=$section','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">RCut <br/>EMB<br/>CUT<br/>TOP</a></h2></th></th></tr>";
		
		$mods=array("ENP","CUT","TOP");
		$mods_ex=array("Emb","Cut","Smp");
		//$mods=explode(",",$section_mods);

		for($x=0;$x<sizeof($mods);$x++)
		{
			
			$module=$mods[$x];
			$module_ex=$mods_ex[$x];
			
			
			echo "<tr class=\"bottom\">";
			echo "<td>$module_ex</td>";

			echo "<td>";
				
					
			$sql11="select * from $bai_pro3.recut_v2 where plan_module=\"$module\" and cut_inp_temp is null and remarks in (\"Body\",\"Front\")";
			if($_GET["view_div"]=="ALL" or $_GET["view_div"]=="")
			{
				$sql11="select * from $bai_pro3.recut_v2 where plan_module=\"$module\" and cut_inp_temp is null and remarks in (\"Body\",\"Front\")";
			}
			else
			{
				$sql11="select * from $bai_pro3.recut_v2 where plan_module=\"$module\" and cut_inp_temp is null and remarks in (\"Body\",\"Front\") and (order_tid like \"".$_GET['view_div']."%\")";
			}
			/*$sql11="select * from recut_v2 where plan_module=\"$module\" and cut_inp_temp is null and remarks in (\"Body\",\"Front\")";
			if($_GET["view_div"]=="ALL")
			{
				$sql11="select * from recut_v2 where plan_module=\"$module\" and cut_inp_temp is null and remarks in (\"Body\",\"Front\")";
			}
			
			if($_GET["view_div"]=="P,K")
			{
				$sql11="select * from recut_v2 where plan_module=\"$module\" and cut_inp_temp is null and remarks in (\"Body\",\"Front\") and (order_tid like \"P%\" or order_tid like \"K%\")";		//echo $sql11;	
			}
			
			if($_GET["view_div"]=="L,O,G")
			{
				$sql11="select * from recut_v2 where plan_module=\"$module\" and cut_inp_temp is null and remarks in (\"Body\",\"Front\") and (order_tid like \"L%\" or order_tid like \"O%\" OR order_tid like \"G%\" OR order_tid like \"U%\")";
			}
			
			if($_GET["view_div"]=="M")
			{
				$sql11="select * from recut_v2 where plan_module=\"$module\" and cut_inp_temp is null and remarks in (\"Body\",\"Front\") and (order_tid like \"M%\")";
			}
			
			if($_GET["view_div"]=="Y")
			{
				$sql11="select * from recut_v2 where plan_module=\"$module\" and cut_inp_temp is null and remarks in (\"Body\",\"Front\") and (order_tid like \"Y%\")";
			}*/
			
			$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$recut_count=mysqli_num_rows($sql_result11);
			
				if($recut_count>0)
				{
					
						while($sql_row11=mysqli_fetch_array($sql_result11))
						{
							$rec_doc_no=$sql_row11['doc_no'];
							$mk_ref=$sql_row11['mk_ref'];
							$fab_status=$sql_row11['fabric_status'];
							$act_cut_status=$sql_row11['act_cut_status'];
							$cut_inp=$sql_row11['cut_inp_temp'];
							$plan_lot_ref1=$sql_row11['plan_lot_ref'];
							//EMB
							$act_cut_issue_status=$sql_row11['act_cut_issue_status'];
							//EMB
							
							//
							$req_date=$sql_row11['date'];
							$order_tid=$sql_row11['order_tid'];
							$source_conf_time=$sql_row11['lastup'];
							$total_qty=($sql_row11['a_xs']+$sql_row11['a_s']+$sql_row11['a_m']+$sql_row11['a_l']+$sql_row11['a_xl']+$sql_row11['a_xxl']+$sql_row11['a_xxxl']+$sql_row11['a_s01']+$sql_row11['a_s02']+$sql_row11['a_s03']+$sql_row11['a_s04']+$sql_row11['a_s05']+$sql_row11['a_s06']+$sql_row11['a_s07']+$sql_row11['a_s08']+$sql_row11['a_s09']+$sql_row11['a_s10']+$sql_row11['a_s11']+$sql_row11['a_s12']+$sql_row11['a_s13']+$sql_row11['a_s14']+$sql_row11['a_s15']+$sql_row11['a_s16']+$sql_row11['a_s17']+$sql_row11['a_s18']+$sql_row11['a_s19']+$sql_row11['a_s20']+$sql_row11['a_s21']+$sql_row11['a_s22']+$sql_row11['a_s23']+$sql_row11['a_s24']+$sql_row11['a_s25']+$sql_row11['a_s26']+$sql_row11['a_s27']+$sql_row11['a_s28']+$sql_row11['a_s29']+$sql_row11['a_s30']+$sql_row11['a_s31']+$sql_row11['a_s32']+$sql_row11['a_s33']+$sql_row11['a_s34']+$sql_row11['a_s35']+$sql_row11['a_s36']+$sql_row11['a_s37']+$sql_row11['a_s38']+$sql_row11['a_s39']+$sql_row11['a_s40']+$sql_row11['a_s41']+$sql_row11['a_s42']+$sql_row11['a_s43']+$sql_row11['a_s44']+$sql_row11['a_s45']+$sql_row11['a_s46']+$sql_row11['a_s47']+$sql_row11['a_s48']+$sql_row11['a_s49']+$sql_row11['a_s50'])*$sql_row11['a_plies'];

							
							//EMB Status
							$sql111="select co_no,order_style_no,order_del_no,order_col_des, (IF(((order_embl_a + order_embl_b) > 0),1,0) + IF(((order_embl_e + order_embl_f) > 0),0,0)) AS emb_stat1 from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
							$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row111=mysqli_fetch_array($sql_result111))
							{
								$style=$sql_row111['order_style_no'];
								$schedule=$sql_row111['order_del_no'];
								$color=$sql_row111['order_col_des'];
								$co_no=$sql_row111['co_no'];
								$emb_stat=$sql_row111['emb_stat1'];
							}
							//EMB Status
							
							$exdate1="";
							/*$sql_del1="select ex_factory_date_new as exdate from bai_pro4.week_delivery_plan_ref where schedule_no=\"$schedule\"";
							$sql_del_result1=mysql_query($sql_del1,$link) or exit("Sql Error".mysql_error());
							while($sql_row_del1=mysql_fetch_array($sql_del_result1))
							{
								$exdate1=$sql_row_del1["exdate"];
							}*/
							
							$key=0;
							$key=array_search($schedule,$exdate_sch_arr);
							$exdate1=$exdate_arr[$key];
							$letter1="";
							if(date("Y-m-d")== $exdate1)
							{
								$letter1="x";
								$iustyle=substr($iustyle,0,1);
							}
							
							//EMB Status
							if($emb_stat==1 or $emb_stat==3)
							{
								$letter="<font color=black size=2>X</font>";
								if(strlen($act_cut_issue_status)>0)
								{
									$letter="<font color=black size=2>".substr($act_cut_issue_status,-1)."</font>";
								}
							}
							//EMB Status
							
							//Last Production Reporoted
							$sql_del1="select max(ims_log_date) as last_up from $bai_pro3.ims_log where ims_schedule=\"$schedule\"";
							$sql_del_result1=mysqli_query($link, $sql_del1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row_del1=mysqli_fetch_array($sql_del_result1))
							{
								$lastup=$sql_row_del1["last_up"];
							}
							
							$title=str_pad("Style:".$style,20).str_pad("CO:".$co_no,20).str_pad("Schedule:".$schedule,20).str_pad("Color:".$color,20).str_pad("Total_Qty:".$total_qty,20).str_pad("Req_Time:".$req_date,20).str_pad("Source Conf. Time:".$source_conf_time,20).str_pad("Last Pro. Rep.:".$lastup,20);

							
							//
							
							$a=$b=$c=$d=$e=$f="";
							
							//$id="white";
							if($mk_ref>0) {	$a="T";	}else{ $a="F";	} //Marker Update
							if($fab_status>0) {	$b="T";	}else{ $b="F";	} //fabric update
							if($fab_status==1 or $fab_status==5) {	$c="T";	}else{ $c="F";	} // fabric update
							if($fab_status==5) {	$d="T";	}else{ $d="F";	} // fabric available
							if($act_cut_status=="DONE") { $e="T";	}else{ $e="F";	} // cut completion status
							if($cut_inp==1) { $f="T";	}else{ $f="F";	} // cut completion status
							
							$test=$a.$b.$c.$d.$e.$f;
							//echo $test;
							$path="";
							
							if(isset($_GET["view_cat"]))
							{
								$view_cat_color1=$_GET["view_cat"];
							}
							else
							{
								$view_cat_color1='ALL';
							}
							
							$view_cat_colors1=explode(",",$view_cat_color1);
							//echo $test."-".$view_cat_color."<br>";
							
							if(in_array("ALL",$view_cat_colors1))
							{
								$test=$test;
							}	
							else if(in_array($test,$view_cat_colors1))
							{
								$test=$view_cat_color1;
							}
							else
							{
								$test="";
								$letter="";
							}

							$path1 =  getFullURL($_GET['r'],'cad_pop_details.php','N');
							 $path2 =  getFullURL($_GET['r'],'fab_pop_details_recut_v2.php','N');
					
							switch($test)
							{
								case "FFFFFF":
								{
									$id="yash";
									$path=$path1."&code=1&doc_no=$rec_doc_no";
									break;
								}
								case "TFFFFF":
								{
									$id="pink";
									$path=$path1."&code=2&doc_no=$rec_doc_no";
									break;
								}
								case "TTTFFF":
								{
									$id="green";
									if(strlen($plan_lot_ref1)>0)
										{
											$id="lgreen";
										}
									$path=$path2."&doc_no=$rec_doc_no";
									break;
								}
								case "TTFFFF":
								{
									$id="red";
									$path=$path1."&code=2&doc_no=$rec_doc_no";
									break;
								}
								case "TTTTFF":
								{
									$id="yellow";
									$path=$path1."&code=0&doc_no=$rec_doc_no";
									break;
								}
								case "TTTTTF":
								{
									$id="blue";
									$path=$path1."&code=3&doc_no=$rec_doc_no&emb_stat=$emb_stat&act_cut_issue_status=$act_cut_issue_status";
									break;
								}
								case "TFFFTF": //new condition came when fabric issues and cut reported as completed without any logical constrins.
								{
									$id="blue";
									$path=$path1."&code=3&doc_no=$rec_doc_no&emb_stat=$emb_stat&act_cut_issue_status=$act_cut_issue_status";
									break;
								}
								case "TTTTTF,TFFFTF": //new condition came when fabric issues and cut reported as completed without any logical constrins.
								{
									$id="blue";
									$path=$path1."&code=3&doc_no=$rec_doc_no&emb_stat=$emb_stat&act_cut_issue_status=$act_cut_issue_status";
									break;
								}
							}
		
		//Add the ordercut details in RTS dashboard.							
		$sqlr="SELECT * from $bai_pro3.recut_v2 where (order_tid like \"L%Y%\" or order_tid like \"L%Z%\" or order_tid like \"O%Y%\" or order_tid like \"O%Z%\" or order_tid like \"L%X%\" or order_tid like \"L%W%\" or order_tid like \"O%X%\" or order_tid like \"O%W%\") and plan_module=\"$module\" and doc_no=$rec_doc_no" ;
				//echo $sqlt;	
			$sql_result12=mysqli_query($link, $sqlr) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$check_num_rows=mysqli_num_rows($sql_result12);		
			while($sql_row12=mysqli_fetch_array($sql_result12))
			{
				$sel_style=$sql_row12['order_tid'];
				//$sel_sch=$sql_row12['order_del_no'];
				$sel_sty=substr($sel_style,0,9);
			}
			
			//echo $module."-schedules:".$sel_sch."-".$sel_sty."-".$ord_style."<br/>";		
		if(($check_num_rows>0 && $sel_sty==$style)||in_array($schedule,$speed_sch))
		{
			$emb_sty=$iustyle."".$letter1;
				
		}
		else
		{
			$emb_sty=$letter1; 
		}
							if($test != "")
							{
								echo "<div id=\"S$schedule\" style=\"float:left;\"><div class=\"$id\" title=\"".$title."\"><a href=\"$path\"><center><font color=white>$emb_sty</font></center></a></div></div>";
								// echo "<div id=\"S$schedule\" style=\"float:left;\"><div class=\"$id\" title=\"".$title."\"><a href=\"$path\" onclick=\"Popup=window.open('$path"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><center><font color=white>$emb_sty</font></center></a></div></div>";
							}
							
						
							
						}
						
						
				}
							
				

					
			
			echo "</td>";
			echo "</tr>";
			
		}

		echo "</table>";
		echo "</p>";
		echo '</div>';
		
		//To show section level priority only to RM-Fabric users only.
		// if((in_array(strtolower($username),$authorized)))
		// {
			// echo "<script>";
			// echo "blink_new_priority('".implode(",",$blink_docs)."');";
			// echo "</script>";
		// }
		
		//RECUT
		
?>
<div style="clear: both;"> </div>
</div>
</div>
</div>

