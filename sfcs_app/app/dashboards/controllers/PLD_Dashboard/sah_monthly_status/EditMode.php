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
   var chart1 = new FusionCharts("../Charts_New/MSLine.swf", "ChId1", "1000", "450", "0", "1");
   chart1.setDataURL("line_include.php");
   chart1.render("chart1div");
</script>
<DIV id="contentDiv">
	<span class='text'><h3 style="color:red;">Factory</h3></span>
</DIV>
</th>
<th>
<div id="chart2div">
  This text is replaced by the Flash movie.
</div>

<script type="text/javascript">
	var myChart = new FusionCharts("../Charts_New/VLED.swf", "myChartId", "250", "450", "0", "0");
	myChart.setDataURL("vled_include.php");
	myChart.render("chart2div");
   </script>
<DIV id="contentDiv">
	<span class='text'><h3 style="color:red;">Factory</h3></span>
</DIV>
</th>
</tr>
</table>
<table>
<tr >
  <td colspan="2">
   <div id="chart6div">FusionGadgets</div>
   <script type="text/javascript">
	var myChart1 = new FusionCharts("../Charts_New/VBullet.swf", "myChart1Id", "150", "350", "0", "0");
	myChart1.setDataURL("hbullet1_include.php");
	myChart1.render("chart6div");
   </script>  </td>
   
     <td align="center">
	 <div id="chart7div">FusionGadgets</div>
   <script type="text/javascript">
	var myChart2 = new FusionCharts("../Charts_New/VBullet.swf", "myChart2Id", "150", "350", "0", "0");
	myChart2.setDataURL("hbullet2_include.php");
	myChart2.render("chart7div");
   </script>	 </td>
   
     <td align="center">
	 <div id="chart3div" align="center">FusionGadgets</div>
   <script type="text/javascript">
	var myChart3 = new FusionCharts("../Charts_New/VBullet.swf", "myChart3Id", "150", "350", "0", "0");
	myChart3.setDataURL("hbullet3_include.php");
	myChart3.render("chart3div");
   </script>	 </td>
   
   
     <td align="center">
	 <div id="chart4div" align="center">FusionGadgets</div>
   <script type="text/javascript">
	var myChart4 = new FusionCharts("../Charts_New/VBullet.swf", "myChart4Id", "150", "350", "0", "0");
	myChart4.setDataURL("hbullet4_include.php");
	myChart4.render("chart4div");
   </script>	 </td>
   
     <td align="center">
	 <div id="chart5div" align="center">FusionGadgets</div>
   <script type="text/javascript">
	var myChart5 = new FusionCharts("../Charts_New/VBullet.swf", "myChart5Id", "150", "350", "0", "0");
	myChart5.setDataURL("hbullet5_include.php");
	myChart5.render("chart5div");
   </script>	 </td>
   
      <td align="center">
	 <div id="chart8div" align="center">FusionGadgets</div>
   <script type="text/javascript">
	var myChart5 = new FusionCharts("../Charts_New/VBullet.swf", "myChart5Id", "150", "350", "0", "0");
	myChart5.setDataURL("hbullet6_include.php");
	myChart5.render("chart8div");
   </script>	 </td>
   </tr>
</table>
</BODY>
</HTML>