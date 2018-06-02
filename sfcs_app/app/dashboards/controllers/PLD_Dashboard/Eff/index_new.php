<?php
include("header.php");
include("fusion_charts/Includes/FusionCharts.php");
?>
<HTML>
<HEAD>
<TITLE>FusionWidgets v3 - Edit Mode</TITLE>
<script type="text/javascript" src="../Charts_New/FusionCharts.js"></script>
<SCRIPT LANGUAGE="Javascript" SRC="fusion_charts/FusionCharts/FusionCharts.js"></SCRIPT>
</HEAD>
<BODY>
<table align="center">
<tr>
<td>
<div id="chart1div2">
  This text is replaced by the Flash movie.
</div>
<script type="text/javascript">
   var chart1 = new FusionCharts("../Charts_New/AngularGauge.swf", "ChId1", "600", "300", "0", "0");
   chart1.setDataURL("eff_guage_include.php");
   chart1.render("chart1div2");
</script>
</td>
</tr>
<tr>
<td>
<div id="chart1div3">
  This text is replaced by the Flash movie.
</div>
<script type="text/javascript">
   var chart1 = new FusionCharts("../Charts_New/StackedColumn2D.swf", "ChId2", "600", "300", "0", "0");
   chart1.setDataURL("eff_bar_include.php");
   chart1.render("chart1div3");
</script>
</td>
</tr>
</table>
<BR>
</BR>
</BODY>
</HTML>