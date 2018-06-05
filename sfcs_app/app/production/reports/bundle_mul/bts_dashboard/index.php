<?php
include("dbconf.php");
include("session_check.php");  
?>
 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title>Layout with a Frame</title>

	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="jquery.ui.all.js"></script>
	<script type="text/javascript" src="jquery.layout.js"></script>

	<script type="text/javascript">

	var myLayout; // a var is required because this page utilizes: myLayout.allowOverflow() method

	$(document).ready(function () {

		myLayout = $('body').layout({
			west__size:					200
		,	west__spacing_closed:		20
		,	west__togglerLength_closed:	100
		,	west__togglerAlign_closed:	"top"
		,	west__togglerContent_closed:"M<BR>E<BR>N<BR>U"
		,	west__togglerTip_closed:	"Open & Pin Menu"
		,	west__sliderTip:			"Slide Open Menu"
		,	west__slideTrigger_open:	"click"
		});

 	});

	</script>


	<style type="text/css">
	/**
	 *	Basic Layout Theme
	 */
	.ui-layout-pane { /* all 'panes' */ 
		border: 1px solid #BBB; 
	} 
	.ui-layout-pane-center { /* IFRAME pane */ 
		padding: 0;
		margin:  0;
	} 
	.ui-layout-pane-west { /* west pane */ 
		padding: 0 10px; 
		background-color: #EEE !important;
		overflow: auto;
	} 

	.ui-layout-resizer { /* all 'resizer-bars' */ 
		background: red; 
		} 
		.ui-layout-resizer-open:hover { /* mouse-over */
			background: #9D9; 
		}

	.ui-layout-toggler { /* all 'toggler-buttons' */ 
		background: yellow; 
		
		} 
		.ui-layout-toggler-closed { /* closed toggler-button */ 
			background: #CCC; 
			border-bottom: 1px solid #BBB;	
			} 
		.ui-layout-toggler .content { /* toggler-text */ 
			font: 14px bold Verdana, Verdana, Arial, Helvetica, sans-serif;
		}
		.ui-layout-toggler:hover { /* mouse-over */ 
			background: #DCA; 
			} 
			.ui-layout-toggler:hover .content { /* mouse-over */ 
				color: #009; 
				}

	/* class to make the 'iframe mask' visible */
	.ui-layout-mask {
		opacity: 0.2 !important;
		filter:	 alpha(opacity=20) !important;
		background-color: #666 !important;
	}

/*
	body {
		background-color: black;
		font-family: Geneva, Arial, Helvetica, sans-serif;
	}

	ul {  //basic menu styling 
		margin:		1ex 0;
		padding:	0;
		list-style:	none;
		position:	relative;
	}
	li {
		padding: 0.15em 1em 0.3em 5px;
	}
*/
	input
	{
		border: 1px solid black;
	}

	table
	{
		font-size: 12px;
	}


	</style>


<link rel="stylesheet" href="menu_include/jquery.treeview.css" />
<link rel="stylesheet" href="menu_include/red-treeview.css" />
<link rel="stylesheet" href="menu_include/screen.css" />



<script src="menu_include/lib/jquery.cookie.js" type="text/javascript"></script>
<script src="menu_include/jquery.treeview.js" type="text/javascript"></script>
<script src="css-pop.js" type="text/javascript"></script>

<script type="text/javascript">
		$(function() {
			$("#tree").treeview({
				collapsed: true,
				animated: "medium",
				control:"#sidetreecontrol",
				persist: "location"
			});
		})
		
	</script>
<script>
$(document).click(function() {
       //alert("Test");     
	});
</script>



<script>
<!-- to open popup of search -->

	function search_pop()
	{
		
		var search=document.quicksearch.search.value;
		search=search.toLowerCase();

		
		var x="";
		if(search.length>0 && $('#cmd'+search).length > 0)
		{
			x= document.getElementById('cmd'+search).innerHTML;
 			//

			var url = x
			var loading_url = "loading.PHP"
			document.getElementById("mainFrame").src = loading_url;
			$.ajax({
				    url: url,
				    type: 'GET',
				    complete: function(e, xhr, settings){
				         if(e.status === 200){
				              $("#mainFrame").attr("src", x);
						$('#mainFrame').fadeIn(3000);
				         }
				    }
			});
		}
		else
		{
			alert("Please enter valid command.");
		}

		
	}

</script>
<style>
#blanket {
background-color:BLACK;
opacity: 0.65;
*background:none;
position:absolute;
z-index: 9001;
top:0px;
left:0px;
width:100%;
}

#popUpDiv {
position:absolute;
background-color: black;
color:white;
width:600px;
height:400px;
border:5px solid #000;
z-index: 9002;
}

#popUpDiv table{
    color: white;
}

</style>
</head>
<!-- <body onload="popup('popUpDiv')"> -->
<body>

<div id="blanket" style="display:none"></div>
<div id="popUpDiv" style="display:none">

<a href="#" onclick="popup('popUpDiv')" style="color:white; float:right;">Click to Close Pop Up</a>
<h2 style="color:yellow;">Message Box</h2>
<h4>Dear Associates,<br/>
Please follow the below commands to access respective dashboard/reports.<br/><br/></h4>
<table>
<tr><th>Command (CMD)</th><th>Description</th><th>Dashboard/Report Name</th></tr>
<tr><td>RMS</td><td>Raw Material Management System</td><td>Fabric Status Dashboard</td></tr>
<tr><td>IPS</td><td>Input Planning System</td><td>Production Input Status Tracking Dashboard</td></tr>
<tr><td>IMS</td><td>Input Management System</td><td>Input Management System - Production WIP Dashboard</td></tr>
<tr><td>LMS</td><td>Logistics Management System</td><td>Cartons Work in Progress Dashboard</td></tr>
<tr><td>TMS</td><td>Trims Management System</td><td>Sewing Trims Status Dashboard</td></tr>
<tr><td>RLS</td><td>Rework Live Status</td><td>RLS (Rework Live Status)</td></tr>
<tr><td>EMS</td><td>Embellishment Management System</td><td>Printing & Embellishment Track Panel? </td></tr>
<tr><td>AMT</td><td>Additional Material Tracking</td><td>Additional Material Requisition Log </td></tr>
<tr><td>HPT</td><td>Hourly Production Tracking</td><td>Focus - Production Tracking Dashboard</td></tr>
<tr><td>PLD</td><td>Production Live Dashboard</td><td>Production Live Dashboard</td></tr>
<tr><td>WDP</td><td>Weekly Delivery Plan</td><td>Weekly Delivery Plan</td></tr>
<tr><td>CPS</td><td>Cut Priority System</td><td>Cut Priority Dashboard</td></tr>
<tr><td>RTS</td><td>Recut Tracking System</td><td>Recut Status Dashboard</td></tr>
<tr><td>FSP</td><td>Fabric Sewing Packing RM Forecast</td><td>Single Window Summary</td></tr>

</table>
</div>





<div class="ui-layout-west">


<div id="main">
	<div id="sidetree">
<div class="treeheader">&nbsp;</div>



<?php

$sql="select time_stamp from snap_session_track where session_id=1";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$lu=$sql_row['time_stamp'];
}

$sql="SELECT tbl_orders_style_ref_product_style FROM $view_set_snap_1_tbl where bundle_transactions_20_repeat_operation_id!=5 GROUP BY tbl_orders_style_ref_product_style";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result)==0)
{
	echo "<h3>Data Refresh is in progress... <br/>Please wait for 15 minutes...</h3>";
}
else
{
	echo "<h4>Total Running Styles: ".mysqli_num_rows($sql_result)."<br/><font color=\"red\">Last Updated on : $lu</font><br/></h4></center>";
echo "<span style=\"cursor: pointer; cursor: hand; color:blue;\" onclick=\"Popup=window.open('master_performance_report.php','Popup','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">Day wise Performance Reports</span><br/>";
echo "<ul>";
}


$first_style="";
while($sql_row=mysqli_fetch_array($sql_result))
{
	$style=$sql_row['tbl_orders_style_ref_product_style'];
	
	echo "<li><a href=\"redirect_page.php?filterstyle=$style\" target=\"main\">".$style."</a></li>";
	
	if($first_style=="")
	{
		$first_style=$style;
	}
	
}
echo "</ul>";
 ?>
 


 
</div>
</div>
</div>

<iframe id="mainFrame" name="main" class="ui-layout-center" 
	width="100%" height="600" frameborder="0" scrolling="auto"
	src="production_daily_kpi.php?filterstyle=Y77919M6 "></iframe>


</body>
</html>