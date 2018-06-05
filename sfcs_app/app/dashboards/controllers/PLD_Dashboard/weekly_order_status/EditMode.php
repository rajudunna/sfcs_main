<HTML>
<HEAD>
<meta http-equiv="refresh" content="2000">

<style type="text/css">
div.ex
{
width:10px;
height:2px;
padding:10px;
border:1px solid black;
margin:0px;
background:red;
color:white;
}
div.fx
{
width:10px;
height:10px;
padding:10px;
border:1px solid black;
margin:0px;
background:green;
color:white;
}

</style>


<style>
body
{
	background:#fffbf0;
}
a
{
	color:#ffffff;
}
</style>

<TITLE>Production Live Status</TITLE>
<script type="text/javascript" src="../Charts_New/FusionCharts.js"></script>
<script language="javascript">
	//FC_ChartUpdated method is called when user has changed dial value.
	function FC_ChartUpdated(DOMId){
		//Check if DOMId is that of the chart we want
		if (DOMId=="ChId1")
		{
			//Get reference to the chart
			var chartRef = getChartFromId(DOMId);
			//Get the current value
			var dialValue = chartRef.getData(1);			
			//You can also use getDataForId method as commented below, to get the dial value.
			//var dialValue = chartRef.getDataForId("CS");				
			//Update display
			var divToUpdate = document.getElementById("contentDiv");
			divToUpdate.innerHTML = "<span class='text'>Your satisfaction index: <B>" + Math.round(dialValue) + "%</B></span>";
			
		}
	}	
</script>
<style type="text/css">
.text{
	font-family:Arial, Helvetica, sans-serif;
	font-size:10pt;
}
</style>
</HEAD>
<BODY>

<?php

include"header.php";

?>

<table align="center">

<tr>
<th>
<div id="chart1div">
  This text is replaced by the Flash movie.
</div>

<script type="text/javascript">
   var chart1 = new FusionCharts("../Charts_New/StackedColumn2D.swf", "ChId1", "750", "500", "0", "1");
   chart1.setDataURL("bar_include.php");
   chart1.render("chart1div");
</script>
<DIV id="contentDiv">
	<span class='text'><h3 style="color:red;">Factory</h3></span>
</DIV>
</th>
</tr>
<tr>
<th>
<div id="chart2div">
  This text is replaced by the Flash movie.
</div>

<script type="text/javascript">
   var chart1 = new FusionCharts("../Charts_New/HLinearGauge.swf", "ChId1", "750", "150", "0", "1");
   chart1.setDataURL("linear_include.php");
   chart1.render("chart2div");
</script>
<DIV id="contentDiv">
	<span class='text'><h3 style="color:red;">Factory</h3></span>
</DIV>
</th>
</tr>
</table>
</BODY>
</HTML>