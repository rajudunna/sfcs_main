<HTML>
<HEAD>


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

<TITLE>FusionWidgets v3 - Edit Mode</TITLE>
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
<BODY onload="openNewWindow();">
<table>
<tr>
<td></td>
<td colspan="2">
<div id="chart1div">
  This text is replaced by the Flash movie.
</div>
<script type="text/javascript">
   var chart1 = new FusionCharts("../Charts_New/AngularGauge.swf", "ChId1", "900", "300", "0", "0");
   chart1.setDataURL("factory_include.php");
   chart1.render("chart1div");
</script>
</td>
</tr>
<tr>
<td>
<div id="chart1div1">
  This text is replaced by the Flash movie.
</div>
<script type="text/javascript">
   var chart1 = new FusionCharts("../Charts_New/AngularGauge.swf", "ChId1", "450", "240", "0", "0");
   chart1.setDataURL("section_1_include.php");
   chart1.render("chart1div1");
</script>
</td>
<td>
<div id="chart1div2">
  This text is replaced by the Flash movie.
</div>
<script type="text/javascript">
   var chart1 = new FusionCharts("../Charts_New/AngularGauge.swf", "ChId1", "450", "240", "0", "0");
   chart1.setDataURL("section_2_include.php");
   chart1.render("chart1div2");
</script>
</td>
<td>
<div id="chart1div3">
  This text is replaced by the Flash movie.
</div>
<script type="text/javascript">
   var chart1 = new FusionCharts("../Charts_New/AngularGauge.swf", "ChId1", "450", "240", "0", "0");
   chart1.setDataURL("section_3_include.php");
   chart1.render("chart1div3");
</script>
</td>
</tr>
<tr>
<td>
<div id="chart1div4">
  This text is replaced by the Flash movie.
</div>
<script type="text/javascript">
   var chart1 = new FusionCharts("../Charts_New/AngularGauge.swf", "ChId1", "450", "240", "0", "0");
   chart1.setDataURL("section_4_include.php");
   chart1.render("chart1div4");
</script>
</td>
<td>
<div id="chart1div5">
  This text is replaced by the Flash movie.
</div>
<script type="text/javascript">
   var chart1 = new FusionCharts("../Charts_New/AngularGauge.swf", "ChId1", "450", "240", "0", "0");
   chart1.setDataURL("section_5_include.php");
   chart1.render("chart1div5");
</script>
</td>
<td>
<div id="chart1div6">
  This text is replaced by the Flash movie.
</div>
<script type="text/javascript">
   var chart1 = new FusionCharts("../Charts_New/AngularGauge.swf", "ChId1", "450", "240", "0", "0");
   chart1.setDataURL("section_6_include.php");
   chart1.render("chart1div6");
</script>
</td>
</tr>
</table>
<BR>
<BR>
</BR>
</BODY>
</HTML>