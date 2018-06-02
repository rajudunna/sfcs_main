<html>
<head>
	<title>FusionGadgets Chart Gallery - Spark Win/Loss Chart</title>
	<script language="JavaScript" src="../JSClass/FusionCharts.js"></script>
</head>
<body bgcolor="#ffffff">
<table width='200' align='center' cellpadding='2' cellspacing='0' style='border:1px #cccccc solid;'>
<tr height='5'>
  <td></td>
  </tr>

<tr>  <td align="center">
   <div id="chart1div" align="center">FusionGadgets</div>
   <script type="text/javascript">
	var myChart1 = new FusionCharts("../Charts_New/SparkWinLoss.swf", "myChart1Id", "200", "35", "0", "0");
	myChart1.setDataURL("spark3_include.php");
	myChart1.render("chart1div");
   </script>   </td>
   </tr>
 
  
   <tr height='5'>
  <td></td>
  </tr>
   <tr height='10'>
   <td></td>
   </tr>
</table>
</body>
</html>
