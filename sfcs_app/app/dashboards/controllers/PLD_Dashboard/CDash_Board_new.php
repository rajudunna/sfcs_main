<?php
include("fusion_charts/Includes/FusionCharts.php");
?>
<?php
$start_iu_dates[]="2010-11-11";

$start_iu_date="2010-11-11";
$check_date=$start_iu_date;
$end_date=date("Y-m-d");

while ($check_date <= $end_date) 
{    
	$check_date=date ("Y-m-d", strtotime ("+7 day", strtotime($check_date)));
	$start_iu_dates[]=$check_date;
}
$iu_week=sizeof($start_iu_dates)-2;
?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<meta http-equiv="refresh" content="900;url=dash_board_new.php?new=<?php echo date("His").rand(10,100); ?>" >
<head>
<title>Production Live Dashboard : BAI</title>


<style id="Book1_6519_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl636519
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl636518
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}	

-->
</style>

<style>

#content table
{
	width:100%;
	float:center;
	border: 3px solid white;
	font-size: 15px;
}

#content tr
{
	border-bottom: 1px solid black;
	padding: 3px;
}
#content td
{
	border-bottom: 1px solid black;
	padding: 3px;
}

table.wip
{
	width:100%;
	float:center;
	border: 3px solid white;
	font-size: 15px;
}

table.wip tr
{
	padding: 5px;
	background-color:#33DDEE;
	border: 3px solid white;
	font-size: 15px;
}


table.wip td
{
	padding: 5px;
	border: 3px solid white;
	font-size: 15px;
}


</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="Charts_New/FusionCharts.js"></script>
<SCRIPT LANGUAGE="Javascript" SRC="fusion_charts/FusionCharts/FusionCharts.js"></SCRIPT>

<script>

function ahah(url, target) {
  document.getElementById(target).innerHTML = ' Fetching data...';
  if (window.XMLHttpRequest) {
    req = new XMLHttpRequest();
  } else if (window.ActiveXObject) {
    req = new ActiveXObject("Microsoft.XMLHTTP");
  }
  if (req != undefined) {
    req.onreadystatechange = function() {ahahDone(url, target);};
    req.open("GET", url, true);
    req.send("");
  }
}  

function ahahDone(url, target) {
  if (req.readyState == 4) { // only if req is "loaded"
    if (req.status == 200) { // only if "OK"
      document.getElementById(target).innerHTML = req.responseText;
    } else {
      document.getElementById(target).innerHTML=" AHAH Error:\n"+ req.status + "\n" +req.statusText;
    }
  }
}

function load(name, div) {
	ahah(name,div);
	return false;
}


</script>


<style>
#white {
  width:40px;
  height:20px;
  background-color: #ffffff;
  display:block;
  float: left;
  margin: 2px;
}

#white a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#white a:hover {
  text-decoration:none;
  background-color: #ffffff;
}


#red {
  width:40px;
  height:20px;
  background-color: #ff0000;
  display:block;
  float: left;
  margin: 2px;
}

#red a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#red a:hover {
  text-decoration:none;
  background-color: #ff0000;
}

#green {
  width:40px;
  height:20px;
  background-color: #00ff00;
  display:block;
  float: left;
  margin: 2px;
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
  width:40px;
  height:20px;
  background-color: #ffff00;
  display:block;
  float: left;
  margin: 2px;
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


#pink {
  width:40px;
  height:20px;
  background-color: #ff00ff;
  display:block;
  float: left;
  margin: 2px;
}

#pink a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#pink a:hover {
  text-decoration:none;
  background-color: #ff00ff;
}

#orange {
  width:40px;
  height:20px;
  background-color: #991144;
  display:block;
  float: left;
  margin: 2px;
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
  background-color: #991144;
}

#blue {
  width:40px;
  height:20px;
  background-color: #15a5f2;
  display:block;
  float: left;
  margin: 2px;
}

#blue a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#blue a:hover {
  text-decoration:none;
  background-color: #15a5f2;
}


#yash {
  width:40px;
  height:20px;
  background-color: #999999;
  display:block;
  float: left;
  margin: 2px;
}

#yash a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#yash a:hover {
  text-decoration:none;
  background-color: #999999;
}

#black {
  width:40px;
  height:20px;
  background-color: black;
  display:block;
  float: left;
  margin: 2px;
}

#black a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#black a:hover {
  text-decoration:none;
  background-color: black;
}
</style>


<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 14">
<link rel=File-List href="Dash_Board_files/filelist.xml">
<style id="Dash_Board_26515_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl6326515
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:14.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid #A6A6A6;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6426515
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:white;
	font-size:14.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid #A6A6A6;
	background:#0D0D0D;
	mso-pattern:black none;
	white-space:nowrap;}
.xl6526515
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:14.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid #A6A6A6;
	background:#0D0D0D;
	mso-pattern:black none;
	white-space:nowrap;}
.xl6626515
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:14.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
-->
</style>
</head>

<body onload="load('http://bainet:8080/projects/dashboards/production/index.php','content');return false;">
<!-- <a href="file1.html" onclick="load('http://bainet:8080/projects/dashboards/production/index.php','content');return false;">File 1</a> -->

<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Excel's Publish as Web
Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<div id="Dash_Board_26515" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=1655 class=xl6626515
 style='border-collapse:collapse;table-layout:fixed;width:1244pt'>
 <col class=xl6626515 width=25 style='mso-width-source:userset;mso-width-alt:
 914;width:19pt'>
 <col class=xl6626515 width=64 span=3 style='width:48pt'>
 <col class=xl6626515 width=92 style='mso-width-source:userset;mso-width-alt:
 3364;width:69pt'>
 <col class=xl6626515 width=62 style='mso-width-source:userset;mso-width-alt:
 2267;width:47pt'>
 <col class=xl6626515 width=26 style='mso-width-source:userset;mso-width-alt:
 950;width:20pt'>
 <col class=xl6626515 width=64 span=2 style='width:48pt'>
 <col class=xl6626515 width=24 style='mso-width-source:userset;mso-width-alt:
 877;width:18pt'>
 <col class=xl6626515 width=25 style='mso-width-source:userset;mso-width-alt:
 914;width:19pt'>
 <col class=xl6626515 width=18 style='mso-width-source:userset;mso-width-alt:
 658;width:14pt'>
 <col class=xl6626515 width=120 style='mso-width-source:userset;mso-width-alt:
 4388;width:90pt'>
 <col class=xl6626515 width=64 span=2 style='width:48pt'>
 <col class=xl6626515 width=26 style='mso-width-source:userset;mso-width-alt:
 950;width:20pt'>
 <col class=xl6626515 width=63 style='mso-width-source:userset;mso-width-alt:
 2304;width:47pt'>
 <col class=xl6626515 width=29 style='mso-width-source:userset;mso-width-alt:
 1060;width:22pt'>
 <col class=xl6626515 width=99 style='mso-width-source:userset;mso-width-alt:
 3620;width:74pt'>
 <col class=xl6626515 width=98 style='mso-width-source:userset;mso-width-alt:
 3584;width:74pt'>
 <col class=xl6626515 width=19 style='mso-width-source:userset;mso-width-alt:
 694;width:14pt'>
 <col class=xl6626515 width=122 style='mso-width-source:userset;mso-width-alt:
 4461;width:92pt'>
 <col class=xl6626515 width=31 style='mso-width-source:userset;mso-width-alt:
 1133;width:23pt'>
 <col class=xl6626515 width=64 style='mso-width-source:userset;mso-width-alt:
 2340;width:95pt'>
 <col class=xl6626515 width=23 style='mso-width-source:userset;mso-width-alt:
 841;width:17pt'>
 <col class=xl6626515 width=64 style='mso-width-source:userset;mso-width-alt:
 2340;width:95pt'>
 <col class=xl6626515 width=22 style='mso-width-source:userset;mso-width-alt:
 804;width:17pt'>
 <col class=xl6626515 width=31 style='mso-width-source:userset;mso-width-alt:
 1133;width:23pt'>
 <col class=xl6626515 width=93 style='mso-width-source:userset;mso-width-alt:
 3401;width:70pt'>
 <col class=xl6626515 width=31 style='mso-width-source:userset;mso-width-alt:
 1133;width:23pt'>
 
  <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 width=25 style='height:18.0pt;width:19pt'><a
  name="RANGE!A1:AD30"></a></td>
  <td class=xl6626515x  align='left' colspan='10'><u>BAI Production Live Dashboard</u></td>

  <td class=xl6626515 width=18 style='width:14pt'></td>
  <td class=xl6626515 width=120 style='width:90pt'></td>
  <td class=xl6626515 width=64 style='width:48pt'></td>
  <td class=xl6626515 width=64 style='width:48pt'></td>
  <td class=xl6626515 width=26 style='width:20pt'></td>
  <td class=xl6626515 width=63 style='width:47pt'></td>
  <td class=xl6626515 width=29 style='width:22pt'></td>
  <td class=xl6626515 width=99 style='width:74pt'></td>
  <td class=xl6626515 width=98 style='width:74pt'></td>
  <td class=xl6626515 width=19 style='width:14pt'></td>
  <td class=xl6626515 width=122 style='width:92pt'></td>
  <td class=xl6626515 width=31 style='width:23pt'></td>
  <td class=xl6626515 width=64 style='width:95pt'></td>
  <td class=xl6626515 width=23 style='width:17pt'></td>
  <td class=xl6626515 width=64 style='width:95pt'></td>
  <td class=xl6626515 width=22 style='width:17pt'></td>
  <td class=xl6626515 width=31 style='width:23pt'></td>
  <td class=xl6626515 width=93 style='width:70pt'></td>
  <td class=xl6626515 width=31 style='width:23pt'></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 width=25 style='height:18.0pt;width:19pt'><a
  name="RANGE!A1:AD30"></a></td>
  <td class=xl6626515 width=64 style='width:48pt'></td>
  <td class=xl6626515 width=64 style='width:48pt'></td>
  <td class=xl6626515 width=64 style='width:48pt'></td>
  <td class=xl6626515 width=92 style='width:69pt'></td>
  <td class=xl6626515 width=62 style='width:47pt'></td>
  <td class=xl6626515 width=26 style='width:20pt'></td>
  <td class=xl6626515 width=64 style='width:48pt'></td>
  <td class=xl6626515 width=64 style='width:48pt'></td>
  <td class=xl6626515 width=24 style='width:18pt'></td>
  <td class=xl6626515 width=25 style='width:19pt'></td>
  <td class=xl6626515 width=18 style='width:14pt'></td>
  <td class=xl6626515 width=120 style='width:90pt'></td>
  <td class=xl6626515 width=64 style='width:48pt'></td>
  <td class=xl6626515 width=64 style='width:48pt'></td>
  <td class=xl6626515 width=26 style='width:20pt'></td>
  <td class=xl6626515 width=63 style='width:47pt'></td>
  <td class=xl6626515 width=29 style='width:22pt'></td>
  <td class=xl6626515 width=99 style='width:74pt'></td>
  <td class=xl6626515 width=98 style='width:74pt'></td>
  <td class=xl6626515 width=19 style='width:14pt'></td>
  <td class=xl6626515 width=122 style='width:92pt'></td>
  <td class=xl6626515 width=31 style='width:23pt'></td>
  <td class=xl6626515 width=64 style='width:95pt'></td>
  <td class=xl6626515 width=23 style='width:17pt'></td>
  <td class=xl6626515 width=64 style='width:95pt'></td>
  <td class=xl6626515 width=22 style='width:17pt'></td>
  <td class=xl6626515 width=31 style='width:23pt'></td>
  <td class=xl6626515 width=93 style='width:70pt'></td>
  <td class=xl6626515 width=31 style='width:23pt'></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td colspan=5 rowspan=6 class=xl6326515 title="Eff_gauge">  
  <div id="chart1div2"></div>
  
  <script type="text/javascript">
   var chart1 = new FusionCharts("Charts_New/AngularGauge.swf", "ChId1", "344", "204", "0", "0");
   //chart1.setDataURL("Eff/eff_guage_include_temp.php");
   chart1.setDataURL("Eff/eff_guage_include.php");
   chart1.render("chart1div2");
   
   $(document).ready(function() {
    setInterval("ajaxd()",10000);
});

	function ajaxd()
	{
		var chart1 = new FusionCharts("Charts_New/AngularGauge.swf", "ChId1", "344", "204", "0", "0");
	   //chart1.setDataURL("Eff/eff_guage_include_temp.php");
	   chart1.setDataURL("Eff/eff_guage_include.php");
	   chart1.render("chart1div2");
	}

</script>


  </td>
  <td class=xl6626515></td>
  <td colspan=10 rowspan=9 class=xl6326515 title="week_del">
  
  <div id="chart1div"></div>

<script type="text/javascript">
   var chart1 = new FusionCharts("Charts_New/StackedColumn2D.swf", "ChId1", "530", "280", "0", "1");
   chart1.setDataURL("weekly_order_status/bar_include.php");
   chart1.render("chart1div");
</script>
  
  </td>
  <td class=xl6626515></td>
  <td colspan=11 rowspan=6 class=xl6326515 title="line_chart">
  <div id="chart11div"></div>

<script type="text/javascript">
   var chart1 = new FusionCharts("Charts_New/MSLine.swf", "ChId1", "795", "203", "0", "1");
   chart1.setDataURL("sah_monthly_status/line_include.php");
   chart1.render("chart11div");
</script>

  </td>
  <td class=xl6626515></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=85 style='mso-height-source:userset;height:63.75pt'>
  <td height=85 class=xl6626515 style='height:63.75pt'></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=31 style='mso-height-source:userset;height:23.25pt'>
  <td height=31 class=xl6626515 style='height:23.25pt'></td>
  <td colspan=5 class=xl6426515>Factory Efficiency</td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td colspan=11 class=xl6426515>Monthly SAH Plan Vs. Actual</td>
  <td class=xl6626515></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td colspan=5 rowspan=6 class=xl6326515 title="sec_Eff">
  
  <div id="chart1div3"></div>
<script type="text/javascript">
   var chart1 = new FusionCharts("Charts_New/StackedColumn2D.swf", "ChId2", "344", "210", "0", "0");
   //chart1.setDataURL("Eff/eff_bar_include_temp.php");
   chart1.setDataURL("Eff/eff_bar_include.php");
   chart1.render("chart1div3");
</script>

  </td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td colspan=6 rowspan=6 class=xl6326515 title="cylender_sec_chart">
   
  <div id="chart61div" style="float:left; padding-left:25px;"></div>
   <script type="text/javascript">
	var myChart1 = new FusionCharts("Charts_New/VBullet.swf", "myChart1Id", "70", "200", "0", "0");
	myChart1.setDataURL("sah_monthly_status/hbullet1_include.php");
	myChart1.render("chart61div");
   </script>  
   
     
	 <div id="chart71div" style="float:left;"></div>
   <script type="text/javascript">
	var myChart2 = new FusionCharts("Charts_New/VBullet.swf", "myChart2Id", "70", "200", "0", "0");
	myChart2.setDataURL("sah_monthly_status/hbullet2_include.php");
	myChart2.render("chart71div");
   </script>	 
   
     
	 <div id="chart31div" align="center"  style="float:left;"></div>
   <script type="text/javascript">
	var myChart3 = new FusionCharts("Charts_New/VBullet.swf", "myChart3Id", "70", "200", "0", "0");
	myChart3.setDataURL("sah_monthly_status/hbullet3_include.php");
	myChart3.render("chart31div");
   </script>	 
   
   
     
	 <div id="chart41div" align="center"  style="float:left;"></div>
   <script type="text/javascript">
	var myChart4 = new FusionCharts("Charts_New/VBullet.swf", "myChart4Id", "70", "200", "0", "0");
	myChart4.setDataURL("sah_monthly_status/hbullet4_include.php");
	myChart4.render("chart41div");
   </script>	 
   
     
	 <div id="chart51div" align="center"  style="float:left;"></div>
   <script type="text/javascript">
	var myChart5 = new FusionCharts("Charts_New/VBullet.swf", "myChart5Id", "70", "200", "0", "0");
	myChart5.setDataURL("sah_monthly_status/hbullet5_include.php");
	myChart5.render("chart51div");
   </script>	 
   
      
	 <div id="chart81div" align="center"  style="float:left;"></div>
   <script type="text/javascript">
	var myChart5 = new FusionCharts("Charts_New/VBullet.swf", "myChart5Id", "70", "200", "0", "0");
	myChart5.setDataURL("sah_monthly_status/hbullet6_include.php");
	myChart5.render("chart81div");
   </script>	 
  
  </td>
  <td class=xl6626515></td>
  <td colspan=4 rowspan=6 class=xl6326515 title="cilender_chart" align="middle">
  
  <?php //include"sah_monthly_status/vled_include_old.php";
  
  include"sah_monthly_status/vled_include.php"; ?>
   Graph<br>Graph<br>Graph<br>Graph<br>Graph
  </td>
  <td class=xl6626515></td>
 </tr>
 <tr height=31 style='mso-height-source:userset;height:23.25pt'>
  <td height=31 class=xl6626515 style='height:23.25pt'></td>
  <td class=xl6626515></td>
  <td colspan=10 class=xl6426515>Week Production Status</td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td class=xl6626515></td>
  <td colspan=10 rowspan=3 class=xl6326515 title="liner_gau">
  
  <div id="chart2div"></div>

<script type="text/javascript">
   var chart1 = new FusionCharts("Charts_New/HLinearGauge.swf", "ChId1", "531", "131", "0", "1");
   chart1.setDataURL("weekly_order_status/linear_include.php");
   chart1.render("chart2div");
</script>
  
  </td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=82 style='mso-height-source:userset;height:61.5pt'>
  <td height=82 class=xl6626515 style='height:61.5pt'></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=31 style='mso-height-source:userset;height:23.25pt'>
  <td height=31 class=xl6626515 style='height:23.25pt'></td>
  <td colspan=5 class=xl6426515>Section Efficiency</td>
  <td class=xl6626515></td>
  <td colspan=10 class=xl6426515>Week Progress Status</td>
  <td class=xl6626515></td>
  <td colspan=6 class=xl6426515>Section SAH Achivement</td>
  <td class=xl6626515></td>
  <td colspan=4 class=xl6426515>Factory SAH</td>
  <td class=xl6626515></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td colspan=8 rowspan=11 class=xl6326515 title="factory_view">
  <div id="content"></div>
  
  </td>
  <td class=xl6626515></td>
  <td colspan=5 rowspan=11 class=xl6326515 title="iu_clock" align="left">
    <?php
  include("IU_Clock/iu_clock_include.php");
  
  echo renderChart("Charts/AngularGauge.swf", "",str_replace("radius='230'","radius='80'",$strXML), "FactorySum2", "290", "260", "0", "0");
  ?>
  
  
  </td>
  <td class=xl6626515></td>
  <td colspan=4 rowspan=11 class=xl6326515 title="week_iu">

 <div id="chart123div"></div>
   <script type="text/javascript">
	var myChart1 = new FusionCharts("Charts_New/SparkWinLoss.swf", "myChart1Id", "270", "35", "0", "0");
	myChart1.setDataURL("IU_Weeks/spark1_include_old_old.php");
	myChart1.render("chart123div");
   </script> 
   
   
   <div id="chart124div"></div>
   <script type="text/javascript">
	var myChart1 = new FusionCharts("Charts_New/SparkWinLoss.swf", "myChart1Id", "270", "35", "0", "0");
	myChart1.setDataURL("IU_Weeks/spark2_include_old.php");
	myChart1.render("chart124div");
   </script> 
   
   
   <div id="chart125div"></div>
   <script type="text/javascript">
	var myChart1 = new FusionCharts("Charts_New/SparkWinLoss.swf", "myChart1Id", "270", "35", "0", "0");
	myChart1.setDataURL("IU_Weeks/spark3_include_old.php");
	myChart1.render("chart125div");
   </script> 
   
   <div id="chart126div"></div>
   <script type="text/javascript">
	var myChart1 = new FusionCharts("Charts_New/SparkWinLoss.swf", "myChart1Id", "270", "35", "0", "0");
	myChart1.setDataURL("IU_Weeks/spark4_include_old.php");
	myChart1.render("chart126div");
   </script> 
   
   <div id="chart127div"></div>
   <script type="text/javascript">
	var myChart1 = new FusionCharts("Charts_New/SparkWinLoss.swf", "myChart1Id", "270", "35", "0", "0");
	myChart1.setDataURL("IU_Weeks/spark5_include_old_temp.php");
	myChart1.render("chart127div");
   </script> 
   
   <div id="chart128div"></div>
   <script type="text/javascript">
	var myChart1 = new FusionCharts("Charts_New/SparkWinLoss.swf", "myChart1Id", "270", "35", "0", "0");
	myChart1.setDataURL("IU_Weeks/spark6_include_new.php");
	myChart1.render("chart128div");
   </script> 
   
   
   <div id="chart129div"></div>
   <script type="text/javascript">
	var myChart1 = new FusionCharts("Charts_New/SparkWinLoss.swf", "myChart1Id", "270", "35", "0", "0");
	myChart1.setDataURL("IU_Weeks/spark7_include_new_temp.php");
	myChart1.render("chart129div");
   </script>  
      
  </td>
  <td class=xl6626515></td>
  <td colspan=3 rowspan=11 class=xl6326515 title="number_matrix">
  <?php include("number_boards/matric_include.php"); ?>
  <?php echo $table1; ?>
  </td>
  <td class=xl6626515></td>
  <td colspan=4 rowspan=11 class=xl6326515 title="number_matrix"> <?php echo $table2; ?></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <tr height=32 style='mso-height-source:userset;height:24.0pt'>
  <td height=32 class=xl6626515 style='height:24.0pt'></td>
  <td colspan=8 class=xl6426515>Factory Dashboard</td>
  <td class=xl6626515></td>
  <td colspan=5 class=xl6426515>IU Clock(<?php echo "Week #".$iu_week; ?>)</td>
  <td class=xl6626515></td>
  <td colspan=4 class=xl6426515>IU Weeks Delivery Status</td>
  <td class=xl6626515></td>
  <td colspan=3 class=xl6426515>Work in Progress</td>
  <td class=xl6626515></td>
  <td colspan=4 class=xl6426515>MTD Achievement</td>
  <td class=xl6626515></td>
 </tr>
 <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 style='height:18.0pt'></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=25 style='width:19pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=92 style='width:69pt'></td>
  <td width=62 style='width:47pt'></td>
  <td width=26 style='width:20pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=24 style='width:18pt'></td>
  <td width=25 style='width:19pt'></td>
  <td width=18 style='width:14pt'></td>
  <td width=120 style='width:90pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=26 style='width:20pt'></td>
  <td width=63 style='width:47pt'></td>
  <td width=29 style='width:22pt'></td>
  <td width=99 style='width:74pt'></td>
  <td width=98 style='width:74pt'></td>
  <td width=19 style='width:14pt'></td>
  <td width=122 style='width:92pt'></td>
  <td width=31 style='width:23pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=23 style='width:17pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=22 style='width:17pt'></td>
  <td width=31 style='width:23pt'></td>
  <td width=93 style='width:70pt'></td>
  <td width=31 style='width:23pt'></td>
 </tr>
 <![endif]>
</table>

</div>


<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
</body>

</html>
