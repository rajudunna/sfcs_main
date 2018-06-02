<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
 	


	<title>BAI BTS -POPUP </title>

	<script type="text/javascript" src="js_theme/jquery.js"></script>
	<script type="text/javascript" src="js_theme/jquery.ui.all.js"></script>
	<script type="text/javascript" src="js_theme/jquery.layout.js"></script>

	<script type="text/javascript">

	var myLayout; // a var is required because this page utilizes: myLayout.allowOverflow() method

	$(document).ready(function () {

		myLayout = $('body').layout({
			west__size:					203
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

<link rel="stylesheet" type="text/css" href="style.css">

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
		padding: 0 0px; 
		background-color: #EEE !important;
		overflow: auto;
	} 

	.ui-layout-resizer { /* all 'resizer-bars' */ 
		background: RED; /*#DDD;*/ 
		} 
		.ui-layout-resizer-open:hover { /* mouse-over */
			background: #9D9; 
		}

	.ui-layout-toggler { /* all 'toggler-buttons' */ 
		background: #AAA; 
		} 
		.ui-layout-toggler-closed { /* closed toggler-button */ 
			background: #CCC; 
			border-bottom: 1px solid #BBB; 
		} 
		.ui-layout-toggler .content { /* toggler-text */ 
			font: 14px bold Verdana, Verdana, "Arial", Helvetica, sans-serif;
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

*{
	font-family:arial;
	font-size:12px;
}

	body {
		background-color: black;
		font-family: Geneva, Arial, Helvetica, sans-serif;
	}

	ul {  
		margin:		1ex 0;
		padding:	0;
		list-style:	none;
		position:	relative;
	}
	li {
		padding: 0.15em 1em 0.3em 5px;
	}

	</style>



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
	
	

	</head>
	<body>

	<iframe id="mainFrame" name="main" class="ui-layout-center" width="100%" height="600" frameborder="0" scrolling="auto" src="welcome.php"></iframe>
	<div class="ui-layout-west">
	<center><h2><font color="#ff0000" size="50">BAI BTS Reports</font></h2></center>
	<div id="main">
	<div id="sidetree">
	
	
	<div class="treeheader">&nbsp;</div>
	

	<strong>Navigator:</strong><br/><br/>

	<!-- Menu -->
<?php	
	$filter_query="";
	$title="Filter: Complete Factory";
	if(isset($_GET['style']))
	{
		$filter_query.='&style='.$_GET['style'];
		$title="Filter: Style : ".$_GET['style'];
	}

	if(isset($_GET['schedule']))
	{
		$filter_query.='&schedule='.$_GET['schedule'];
		$title="Filtered by Schedule : ".$_GET['schedule'];
	}
	echo "<strong>$title</strong><br/><br/>";
	echo '	<ul>
	<li><a href="performance_report.php?rep_format=1'.$filter_query.'" target="main">Color/Size Wise Performance Report</a></li><br/>
	<li><a href="performance_report.php?rep_format=2'.$filter_query.'" target="main">Mini-Order Wise Performance Report</a></li><br/>
	<li><a href="performance_report.php?rep_format=3'.$filter_query.'" target="main">Bundle Wise Performance Report</a></li><br/>
	<li><a href="performance_report.php?rep_format=4'.$filter_query.'" target="main">Output Vs Carton Packing</a></li><br/>
	<li><a href="performance_report.php?rep_format=5'.$filter_query.'" target="main">Day Wise Operations Performance Report</a></li><br/>
	<li><a href="performance_report.php?rep_format=6'.$filter_query.'" target="main">Day Wise Production Performance Report</a></li><br/>
	<li><a href="performance_report.php?rep_format=7'.$filter_query.'" target="main">Mini-Order Vs Output Vs Carton Packing</a></li><br/>
	<li><a href="performance_report.php?rep_format=8'.$filter_query.'" target="main">Bundle wise Production WIP Report</a></li><br/>
	<li><a href="performance_report.php?rep_format=9'.$filter_query.'" target="main">Carton WIP Report</a></li><br/>
	</ul>
	';
	?>
	<br/>


</div>
	</div>
	
	<div class="ui-layout-north">
 
</div>

</div>
		
	</body>
	
	

</html>