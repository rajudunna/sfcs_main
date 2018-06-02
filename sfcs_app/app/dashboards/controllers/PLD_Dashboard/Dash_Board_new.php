<?php
    include("..".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include("..".getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
    include("..".getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R'));
    include("..".getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    $view_access=user_acl("SFCS_0245",$username,1,$group_id_sfcs);
?>
<?php

//CR# 146 - Kirang // 2014-08-14
//Changed the path

//Please remember to change the host name`
    include(getFullURLLevel($_GET['r'],'FusionCharts.php',0,'R'));



//$sections_db=array(1,3,4,5,2,6);
$sections_db=array();

$sqlx="select sec_id from $bai_pro3.sections_db where sec_id>0 and ims_priority_boxes>0";
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$sections_db[]=$sql_rowx['sec_id'];
}

$dns_adr="http://".$_SERVER['HTTP_HOST'];
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
$iu_week=sizeof($start_iu_dates)-2-5;
$rurl = getFullURLLevel($_GET['r'],'week_display_floor.php',0,'N'); 
// echo $rurl;
?>
<!--
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">-->
<!-- <meta http-equiv="refresh" content="900;url=dash_board_new.php?new=<?php echo date("His").rand(10,100); ?>" >  -->
<meta http-equiv="refresh" content="150;url=<?php echo $rurl; ?>" >
<!-- content="150;url=<?php echo $dns_adr; ?>/sfcs/week_display_floor.php" -->
<!--<head>-->
<title>Production Live Dashboard</title>


<style id="Book1_6519_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}


#monthsah .xl636519
	{
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
	white-space:nowrap;}

	#monthsah .xl636518
	{
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
	white-space:nowrap;}

	iframe.hidden
	{
	display:none
	}
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
<script type="text/javascript" src=<?= getFullURLLevel($_GET['r'],'common/js/Charts/FusionCharts.js',4,'R'); ?>></script>
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
table
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
</style>

<script>
function load_content()
{
	// $('#content').append( "<p>Loading Data......</p>" );
	// $('#content').fadeOut("slow").load('<?php echo $dns_adr; ?>/sfcs/projects/dashboards/production/index.php?randval='+Math.random()).fadeIn("slow");
}

</script>

<!--</head>-->

<!-- <body onload="load('<?php echo $dns_adr; ?>/sfcs/projects/dashboards/production/factory_kpi.php?randval=36273','content');return false;"> -->
<body onload="load_content();">

<!-- <a href="file1.html" onclick="load('<?php echo $dns_adr; ?>/sfcs/projects/dashboards/production/index.php','content');return false;">File 1</a> -->

<div id="Dash_Board_26515" align=center x:publishsource="Excel">
<div class="table-responsive">
<table border=0 cellpadding=0 cellspacing=0 width=1655 class=xl6626515
 style='border-collapse:collapse;table-layout:fixed;width:1244pt'>
 <col class=xl6626515 width=25 style='mso-width-source:userset;mso-width-alt: 914;width:19pt'>
 <col class=xl6626515 width=64 span=3 style='width:48pt'>
 <col class=xl6626515 width=92 style='mso-width-source:userset;mso-width-alt: 3364;width:69pt'>
 <col class=xl6626515 width=62 style='mso-width-source:userset;mso-width-alt: 2267;width:47pt'>
 <col class=xl6626515 width=26 style='mso-width-source:userset;mso-width-alt: 950;width:20pt'>
 <col class=xl6626515 width=64 span=2 style='width:48pt'>
 <col class=xl6626515 width=24 style='mso-width-source:userset;mso-width-alt: 877;width:18pt'>
 <col class=xl6626515 width=25 style='mso-width-source:userset;mso-width-alt: 914;width:19pt'>
 <col class=xl6626515 width=18 style='mso-width-source:userset;mso-width-alt: 658;width:14pt'>
 <col class=xl6626515 width=120 style='mso-width-source:userset;mso-width-alt: 4388;width:90pt'>
 <col class=xl6626515 width=64 span=2 style='width:48pt'>
 <col class=xl6626515 width=26 style='mso-width-source:userset;mso-width-alt: 950;width:20pt'>
 <col class=xl6626515 width=63 style='mso-width-source:userset;mso-width-alt: 2304;width:47pt'>
 <col class=xl6626515 width=29 style='mso-width-source:userset;mso-width-alt: 1060;width:22pt'>
 <col class=xl6626515 width=99 style='mso-width-source:userset;mso-width-alt: 3620;width:74pt'>
 <col class=xl6626515 width=98 style='mso-width-source:userset;mso-width-alt: 3584;width:74pt'>
 <col class=xl6626515 width=19 style='mso-width-source:userset;mso-width-alt: 694;width:14pt'>
 <col class=xl6626515 width=122 style='mso-width-source:userset;mso-width-alt: 4461;width:92pt'>
 <col class=xl6626515 width=31 style='mso-width-source:userset;mso-width-alt: 1133;width:23pt'>
 <col class=xl6626515 width=64 style='mso-width-source:userset;mso-width-alt: 2340;width:95pt'>
 <col class=xl6626515 width=23 style='mso-width-source:userset;mso-width-alt: 841;width:17pt'>
 <col class=xl6626515 width=64 style='mso-width-source:userset;mso-width-alt: 2340;width:95pt'>
 <col class=xl6626515 width=22 style='mso-width-source:userset;mso-width-alt: 804;width:17pt'>
 <col class=xl6626515 width=31 style='mso-width-source:userset;mso-width-alt: 1133;width:23pt'>
 <col class=xl6626515 width=93 style='mso-width-source:userset;mso-width-alt: 3401;width:70pt'>
 <col class=xl6626515 width=31 style='mso-width-source:userset;mso-width-alt: 1133;width:23pt'>

  <tr height=24 style='height:18.0pt'>
  <td height=24 class=xl6626515 width=25 style='height:18.0pt;width:19pt'><a
  name="RANGE!A1:AD30"></a></td>
  <td class=xl6626515x  align='left' colspan='10'><u>Production Live Dashboard</u></td>

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
  <td colspan=5 rowspan=6 class=xl6326515 title="Factory Efficiency">
  <div id="chart1div2c1"></div>

  <script type="text/javascript">
   var chart1 = new FusionCharts("<?= getFullURLLevel($_GET['r'],'common/js/Charts/AngularGauge.swf',4,'R'); ?>", "ChId1", "344", "204", "0", "0");
   //chart1.setDataURL("Eff/eff_guage_include_temp.php");
   chart1.setDataURL("<?= getFullURLLevel($_GET['r'],'Eff/eff_guage_include.php',0,'R'); ?>?randval=1001");
   chart1.render("chart1div2c1");

</script>


  </td>
  <td class=xl6626515></td>
  <td colspan=10 rowspan=9 class=xl6326515 title="Weekly Production Status">

  <div id="chart1divc2"></div>

<script type="text/javascript">
   var chart1 = new FusionCharts("<?= getFullURLLevel($_GET['r'],'common/js/Charts/StackedColumn2D.swf',4,'R');?>", "ChId1", "530", "280", "0", "1");
   chart1.setDataURL("<?= getFullURLLevel($_GET['r'],'weekly_order_status/bar_include.php',0,''); ?>?randval=1002");
   chart1.render("chart1divc2");
</script>

  </td>
  <td class=xl6626515></td>
  <td colspan=11 rowspan=6 class=xl6326515 title="Monthly SAH vs Actual Plan">
  <div id="chart11divc3"></div>

<script type="text/javascript">
   var chart1 = new FusionCharts("<?= getFullURLLevel($_GET['r'],'common/js/Charts/MSLine.swf',4,'R'); ?>", "ChId1", "795", "203", "0", "1");
   chart1.setDataURL("<?= getFullURLLevel($_GET['r'],'sah_monthly_status/line_include.php',0,'R');?>?randval=1003");
   chart1.render("chart11divc3");
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
  <td colspan=5 class=xl6426515>Factory Efficiency (YDA)</td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td colspan=11 class=xl6426515>Monthly SAH Plan Vs. Actual (Live)</td>
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
  <td colspan=5 rowspan=6 class=xl6326515 title="Section Efficiency">

  <div id="chart1div3c4"></div>
<script type="text/javascript">
   var chart1 = new FusionCharts("<?= getFullURLLevel($_GET['r'],'common/js/Charts/StackedColumn2D.swf',4,'R'); ?>", "ChId2", "344", "210", "0", "0");
   //chart1.setDataURL("Eff/eff_bar_include_temp.php");
   chart1.setDataURL("<?= getFullURLLevel($_GET['r'],'Eff/eff_bar_include.php',0,'R'); ?>?randval=1004");
   chart1.render("chart1div3c4");
</script>

  </td>
  <td class=xl6626515></td>
  <td class=xl6626515></td>
  <td colspan=6 rowspan=6 class=xl6326515 title="Section Wise SAH">
  <table width="100%"><tr><td>

<?php
$x=0;
// $fvbullet=
for($i=0;$i<sizeof($sections_db);$i++)
{
	$url = getFullURL($_GET['r'],'sah_monthly_status/hbullet'.(1+$x).'_include.php','R');
echo '<div id="chart'.(3+$x).'1divc'.(5+$x).'" style="float:left; padding-left:25px;"></div>

   <script type="text/javascript">
	var myChart1 = new FusionCharts("'.getFullURLLevel($_GET["r"],"common/js/Charts/VBullet.swf",4,"R").'", "myChart'.(1+$x).'Id", "70", "200", "0", "0");
	myChart1.setDataURL("'.$url.'?randval=1005");
	myChart1.render("chart'.(3+$x).'1divc'.(5+$x).'");
   </script>';
$x++;

}
//getFullURLLevel($_GET['r'],'sah_monthly_status/hbullet'.(1+$x).'_include.php',0,'R');
/*
  <div id="chart31divc5" style="float:left; padding-left:25px;"></div>

   <script type="text/javascript">
	var myChart1 = new FusionCharts("Charts_New/VBullet.swf", "myChart1Id", "70", "200", "0", "0");
	myChart1.setDataURL("sah_monthly_status/hbullet1_include.php?randval=1005");
	myChart1.render("chart31divc5");
   </script>


	 <div id="chart41divc6" style="float:left;"></div>
   <script type="text/javascript">
	var myChart2 = new FusionCharts("Charts_New/VBullet.swf", "myChart2Id", "70", "200", "0", "0");
	myChart2.setDataURL("sah_monthly_status/hbullet2_include.php?randval=1006");
	myChart2.render("chart41divc6");
   </script>


	 <div id="chart51divc7" align="center"  style="float:left;"></div>
   <script type="text/javascript">
	var myChart3 = new FusionCharts("Charts_New/VBullet.swf", "myChart3Id", "70", "200", "0", "0");
	myChart3.setDataURL("sah_monthly_status/hbullet3_include.php?randval=1007");
	myChart3.render("chart51divc7");
   </script>



	 <div id="chart61divc8" align="center"  style="float:left;"></div>
   <script type="text/javascript">
	var myChart4 = new FusionCharts("Charts_New/VBullet.swf", "myChart4Id", "70", "200", "0", "0");
	myChart4.setDataURL("sah_monthly_status/hbullet4_include.php?randval=1008");
	myChart4.render("chart61divc8");
   </script>


	 <div id="chart71divc9" align="center"  style="float:left;"></div>
   <script type="text/javascript">
	var myChart5 = new FusionCharts("Charts_New/VBullet.swf", "myChart5Id", "70", "200", "0", "0");
	myChart5.setDataURL("sah_monthly_status/hbullet5_include.php?randval=1009");
	myChart5.render("chart71divc9");
   </script>


	 <div id="chart81divc10" align="center"  style="float:left;"></div>
   <script type="text/javascript">
	var myChart5 = new FusionCharts("Charts_New/VBullet.swf", "myChart5Id", "70", "200", "0", "0");
	myChart5.setDataURL("sah_monthly_status/hbullet6_include.php?randval=1010");
	myChart5.render("chart81divc10");
   </script>
*/
?>
  	</td></tr>
	<tr><td><center><font color="#00CC11" style="font-weight: bold;">>= 100</font> |
	<font color="#FFA500" style="font-weight: bold;">70 to 99</font> |
	<font color="#FF0000" style="font-weight: bold;">< 70</font>
	 </center></td></tr>
	</table>
  </td>
  <td class=xl6626515></td>
  <td colspan=4 rowspan=6 class=xl6326515 title="Factory SAH" align="middle">
  <div id="monthsah">
  <?php //include"sah_monthly_status/vled_include_old.php";

  include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'sah_monthly_status/vled_include.php',0,'R')); ?>
  </div>

  </td>
  <td class=xl6626515></td>
 </tr>
 <tr height=31 style='mso-height-source:userset;height:23.25pt'>
  <td height=31 class=xl6626515 style='height:23.25pt'></td>
  <td class=xl6626515></td>
  <td colspan=10 class=xl6426515>Week Production Status (Live)</td>
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
  <td colspan=10 rowspan=3 class=xl6326515 title="Week Progress Status">

  <div id="chart2divc11"></div>

<script type="text/javascript">
   var chart1 = new FusionCharts("<?= getFullURLLevel($_GET['r'],'common/js/Charts/HLinearGauge.swf',4,'R'); ?>", "ChId1", "531", "131", "0", "1");
   chart1.setDataURL("<?= getFullURLLevel($_GET['r'],'weekly_order_status/linear_include.php',0,'R'); ?>?randval=1011");
   chart1.render("chart2divc11");
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
  <td colspan=5 class=xl6426515>Section Efficiency (YDA)</td>
  <td class=xl6626515></td>
  <td colspan=10 class=xl6426515>Week Progress Status (Live)</td>
  <td class=xl6626515></td>
  <td colspan=6 class=xl6426515>Section SAH Achievement (Live)</td>
  <td class=xl6626515></td>
  <td colspan=4 class=xl6426515>Factory SAH (Live)</td>
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
  <td colspan=8 rowspan=11 class=xl6326515 title="Factory View">
  <div id="content">
      <?php 
          // include("..".getFullURLLevel($_GET['r'],'Factory_View/index.php',1,'R'));
          // $url=getFullURLLevel($_GET['r'],'Factory_View/index.php',1,'R');
          // $url = "http://".$_SERVER['HTTP_HOST']."/sfcs_app/app/dashboards/controllers/Factory_View/index.php";
          // // echo $url;
          // include( $url); 
          include('index_live.php'); 
      ?>
  </div>

  </td>
  <td class=xl6626515></td>
  <td colspan=5 rowspan=11 class=xl6326515 title="IU Clock" align="left">
    <?php
  //include("IU_Clock/iu_clock_include.php");

  //echo renderChart("Charts/AngularGauge.swf", "",str_replace("radius='230'","radius='80'",$strXML), "FactorySum2", "290", "260", "0", "0");


  ?>

  <div id="ius_clock"></div>
   <script type="text/javascript">
	var myChart1 = new FusionCharts("<?= getFullURLLevel($_GET['r'],'common/js/Charts/AngularGauge.swf',4,'R'); ?>", "FactorySum2", "290", "260", "0", "0");
	myChart1.setDataURL("<?= getFullURLLevel($_GET['r'],'IU_Clock/iu_clock_include1.php',0,'R'); ?>?randval=1012");
	myChart1.render("ius_clock");
   </script>

  </td>
  <td class=xl6626515></td>
  <td colspan=4 rowspan=11 class=xl6326515 title="HRMS Absentism Status">

<!-- <div id="chart123divc12"></div>
   <script type="text/javascript">
	var myChart1 = new FusionCharts("Charts_New/SparkWinLoss.swf", "myChart1Id", "270", "35", "0", "0");
	myChart1.setDataURL("IU_Weeks/spark1_include_old_old.php?randval=1013");
	myChart1.render("chart123divc12");
   </script>


   <div id="chart124divc13"></div>
   <script type="text/javascript">
	var myChart1 = new FusionCharts("Charts_New/SparkWinLoss.swf", "myChart1Id", "270", "35", "0", "0");
	myChart1.setDataURL("IU_Weeks/spark2_include_old.php?randval=1014");
	myChart1.render("chart124divc13");
   </script>


   <div id="chart125divc14"></div>
   <script type="text/javascript">
	var myChart1 = new FusionCharts("Charts_New/SparkWinLoss.swf", "myChart1Id", "270", "35", "0", "0");
	myChart1.setDataURL("IU_Weeks/spark3_include_old.php?randval=1015");
	myChart1.render("chart125divc14");
   </script>

   <div id="chart126divc15"></div>
   <script type="text/javascript">
	var myChart1 = new FusionCharts("Charts_New/SparkWinLoss.swf", "myChart1Id", "270", "35", "0", "0");
	myChart1.setDataURL("IU_Weeks/spark4_include_old.php?randval=1016");
	myChart1.render("chart126divc15");
   </script>

   <div id="chart127divc16"></div>
   <script type="text/javascript">
	var myChart1 = new FusionCharts("Charts_New/SparkWinLoss.swf", "myChart1Id", "270", "35", "0", "0");
	myChart1.setDataURL("IU_Weeks/spark5_include_old_temp.php?randval=1017");
	myChart1.render("chart127divc16");
   </script>

   <div id="chart128divc17"></div>
   <script type="text/javascript">
	var myChart1 = new FusionCharts("Charts_New/SparkWinLoss.swf", "myChart1Id", "270", "35", "0", "0");
	myChart1.setDataURL("IU_Weeks/spark6_include_new.php?randval=1018");
	myChart1.render("chart128divc17");
   </script>


   <div id="chart129divc18"></div>
   <script type="text/javascript">
	var myChart1 = new FusionCharts("Charts_New/SparkWinLoss.swf", "myChart1Id", "270", "35", "0", "0");
	myChart1.setDataURL("IU_Weeks/spark7_include_new_temp.php?randval=1019");
	myChart1.render("chart129divc18");
   </script> -->
   <?php include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'manpower_absenteeism/manpower_absenteeism_include.php',0,'R')); ?>
  </td>
  <td class=xl6626515></td>
  <td colspan=3 rowspan=11 class=xl6326515 title="WIP">
  <?php include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'number_boards/matric_include.php',0,'R')); ?>
  <div id="matrix1"><?php include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'number_boards/matric_include1.php',0,'R')); ?></div>
  </td>
  <td class=xl6626515></td>
  <td colspan=4 rowspan=11 class=xl6326515 title="MTD Achievement"> <?php //echo $table2; ?>
  <div id="matrix2"><?php include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'number_boards/matric_include2.php',0,'R')); ?></div>
  </td>
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
  <td colspan=8 class=xl6426515>Factory Dashboard (Live)</td>
  <td class=xl6626515></td>
  <td colspan=5 class=xl6426515>IU Clock(<?php echo "Week #".$iu_week; ?>)</td>
  <td class=xl6626515></td>
  <td colspan=4 class=xl6426515>HRMS Absenteeism Status</td>
  <td class=xl6626515></td>
  <td colspan=3 class=xl6426515>Work in Progress (Live)</td>
  <td class=xl6626515></td>
  <td colspan=4 class=xl6426515>MTD Achievement (Live)</td>
  <td class=xl6626515></td>
 </tr>
 <!-- <tr height=24 style='height:30.0pt'>
  <td height=24 class=xl6626515 style='height:30.0pt'></td>
  <td class=xl6626515 colspan="8"><h1>Working Hours Violation - 1</h1></td>
  <td class=xl6626515></td>
  <td class=xl6626515 colspan="8"><h1>OT Hours - 5</h1></td>
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
 </tr> -->
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
</table>

</div>
</div>
<script>
$(document).ready(function() {

	//document.getElementById("content").innerHTML='Fetching Data...';
	//$('#content').fadeOut("fast").load('<?php echo $dns_adr; ?>/sfcs/projects/dashboards/production/factory_kpi.php?randval='+Math.random()).fadeIn("fast");
    // setInterval("ajaxd()",60000);
});

	function ajaxd()
	{

		var chart1 = new FusionCharts("<?php echo getFullURLLevel($_GET['r'],'common/js/Charts/StackedColumn2D.swf',4,'R'); ?>", "ChId1", "530", "280", "0", "1");
   chart1.setDataURL("<?php echo getFullURLLevel($_GET['r'],'Control_Room_Charts/weekly_order_status/bar_include.php',0,'R'); ?>?randval="+Math.random());
   chart1.render("chart1divc2");

 var chart1 = new FusionCharts("<?php echo getFullURLLevel($_GET['r'],'common/js/Charts/AngularGauge.swf',4,'R'); ?>", "ChId1", "344", "204", "0", "0");
   //chart1.setDataURL("Eff/eff_guage_include_temp.php");
   chart1.setDataURL("<?php echo getFullURLLevel($_GET['r'],'Eff/eff_guage_include.php',0,'R'); ?>?randval="+Math.random());
   chart1.render("chart1div2c1");

    var chart1 = new FusionCharts("<?php echo getFullURLLevel($_GET['r'],'Charts_New/MSLine.swf',0,'R'); ?>", "ChId1", "795", "203", "0", "1");
   chart1.setDataURL("<?php echo getFullURLLevel($_GET['r'],'sah_monthly_status/line_include.php',0,'R'); ?>?randval="+Math.random());
   chart1.render("chart11divc3");

var chart1 = new FusionCharts("<?php echo getFullURLLevel($_GET['r'],'Charts_New/StackedColumn2D.swf',0,'R'); ?>", "ChId2", "344", "210", "0", "0");
   //chart1.setDataURL("Eff/eff_bar_include_temp.php?randval="+Math.random());
   chart1.setDataURL("<?php echo getFullURLLevel($_GET['r'],'Eff/eff_bar_include.php',0,'R'); ?>?randval="+Math.random());
   chart1.render("chart1div3c4");

var myChart1 = new FusionCharts("<?php echo getFullURLLevel($_GET['r'],'Charts_New/VBullet.swf',0,'R'); ?>", "myChart1Id", "70", "200", "0", "0");

	myChart1.setDataURL("<?php echo getFullURLLevel($_GET['r'],'sah_monthly_status/hbullet1_include.php',0,'R');?>?randval="+Math.random());
	myChart1.render("chart31divc5");

var myChart2 = new FusionCharts("<?php echo getFullURLLevel($_GET['r'],'Charts_New/VBullet.swf',0,'R'); ?>", "myChart2Id", "70", "200", "0", "0");
	myChart2.setDataURL("<?php echo getFullURLLevel($_GET['r'],'sah_monthly_status/hbullet2_include.php',0,'R'); ?>?randval="+Math.random());
	myChart2.render("chart41divc6");

var myChart3 = new FusionCharts("<?php echo getFullURLLevel($_GET['r'],'Charts_New/VBullet.swf',0,'R'); ?>", "myChart3Id", "70", "200", "0", "0");
	myChart3.setDataURL("<?php echo getFullURLLevel($_GET['r'],'sah_monthly_status/hbullet3_include.php',0,'R'); ?>?randval="+Math.random());
	myChart3.render("chart51divc7");

var myChart4 = new FusionCharts("<?php echo getFullURLLevel($_GET['r'],'Charts_New/VBullet.swf',0,'R'); ?>", "myChart4Id", "70", "200", "0", "0");
	myChart4.setDataURL("<?php echo getFullURLLevel($_GET['r'],'sah_monthly_status/hbullet4_include.php',0,'R'); ?>?randval="+Math.random());
	myChart4.render("chart61divc8");

var myChart5 = new FusionCharts("<?php echo getFullURLLevel($_GET['r'],'Charts_New/VBullet.swf',0,'R'); ?>", "myChart5Id", "70", "200", "0", "0");
	myChart5.setDataURL("<?php echo getFullURLLevel($_GET['r'],'sah_monthly_status/hbullet5_include.php',0,'R'); ?>?randval="+Math.random());
	myChart5.render("chart71divc9");

var myChart5 = new FusionCharts("<?php echo getFullURLLevel($_GET['r'],'Charts_New/VBullet.swf',0,'R'); ?>", "myChart5Id", "70", "200", "0", "0");
	myChart5.setDataURL("<?php echo getFullURLLevel($_GET['r'],'sah_monthly_status/hbullet6_include.php',0,'R'); ?>?randval="+Math.random());
	myChart5.render("chart81divc10");

var chart1 = new FusionCharts("<?php echo getFullURLLevel($_GET['r'],'Charts_New/HLinearGauge.swf',0,'R'); ?>", "ChId1", "531", "131", "0", "1"); 
  chart1.setDataURL("<?php echo getFullURLLevel($_GET['r'],'weekly_order_status/linear_include.php',0,'R'); ?>?randval="+Math.random());
  chart1.render("chart2divc11");

var myChart1 = new FusionCharts("<?php echo getFullURLLevel($_GET['r'],'Charts_New/SparkWinLoss.swf',0,'R'); ?>", "myChart1Id", "270", "35", "0", "0");
	myChart1.setDataURL("<?php echo getFullURLLevel($_GET['r'],'spark1_include_old_old.php',0,'R'); ?>?randval="+Math.random());
	myChart1.render("chart123divc12");

var myChart1 = new FusionCharts("<?php echo getFullURLLevel($_GET['r'],'spark1_include_old_old.php',0,'R'); ?>/sfcs/projects/beta/reports/Production_Live_Chart/Control_Room_Charts/Charts_New/SparkWinLoss.swf", "myChart1Id", "270", "35", "0", "0");
	myChart1.setDataURL("<?php echo getFullURLLevel($_GET['r'],'IU_Weeks/spark2_include_old.php',0,'R'); ?>?randval="+Math.random());
	myChart1.render("chart124divc13");

var myChart1 = new FusionCharts("<?= getFullURLLevel($_GET['r'],'Charts_New/SparkWinLoss.swf',0,'R'); ?>", "myChart1Id", "270", "35", "0", "0");
	myChart1.setDataURL("<?= getFullURLLevel($_GET['r'],'IU_Weeks/spark3_include_old.php',0,'R'); ?>?randval="+Math.random());
	myChart1.render("chart125divc14");

var myChart1 = new FusionCharts("<?php echo getFullURLLevel($_GET['r'],'Charts_New/SparkWinLoss.swf',0,'R'); ?>", "myChart1Id", "270", "35", "0", "0");
	myChart1.setDataURL("<?php echo getFullURLLevel($_GET['r'],'IU_Weeks/spark4_include_old.php',0,'R'); ?>?randval="+Math.random());
	myChart1.render("chart126divc15");

var myChart1 = new FusionCharts("<?php echo getFullURLLevel($_GET['r'],'Charts_New/SparkWinLoss.swf',0,'R');  ?>", "myChart1Id", "270", "35", "0", "0");
	myChart1.setDataURL("<?php echo getFullURLLevel($_GET['r'],'IU_Weeks/spark5_include_old_temp.php',0,'R'); ?>?randval="+Math.random());
	myChart1.render("chart127divc16");

var myChart1 = new FusionCharts("<?php echo getFullURLLevel($_GET['r'],'Charts_New/SparkWinLoss.swf',0,'R'); ?>", "myChart1Id", "270", "35", "0", "0");
	myChart1.setDataURL("<?php echo getFullURLLevel($_GET['r'],'IU_Weeks/spark6_include_new.php',0,'R'); ?>?randval="+Math.random());
	myChart1.render("chart128divc17");

var myChart1 = new FusionCharts("<?php echo getFullURLLevel($_GET['r'],'Charts_New/SparkWinLoss.swf',0,'R'); ?>", "myChart1Id", "270", "35", "0", "0");
	myChart1.setDataURL("<?php echo getFullURLLevel($_GET['r'],'IU_Weeks/spark7_include_new_temp.php',0,'R'); ?>?randval="+Math.random());
	myChart1.render("chart129divc18");


   $('#matrix1').fadeOut("slow").load('<?php echo getFullURLLevel($_GET['r'],'number_boards/matric_include1.php',0,'R'); ?>?randval='+Math.random()).fadeIn("slow");

 $('#matrix2').fadeOut("slow").load('<?php echo getFullURLLevel($_GET['r'],'number_boards/matric_include2.php',0,'R'); ?>?randval='+Math.random()).fadeIn("slow");
	$('#content').fadeOut("slow").load('<?php echo getFullURLLevel($_GET['r'],'dashboards/production/index.php',4,'R'); ?>?randval='+Math.random()).fadeIn("slow");
$('#monthsah').fadeOut("slow").load('<?php echo getFullURLLevel($_GET['r'],'sah_monthly_status/vled_include.php',0,'R'); ?>?randval='+Math.random()).fadeIn("slow");


var myChart1 = new FusionCharts("<?php echo getFullURLLevel($_GET['r'],'Charts/AngularGauge.swf',0,'R'); ?>", "FactorySum2", "290", "260", "0", "0");
	myChart1.setDataURL("<?php echo getFullURLLevel($_GET['r'],'IU_Clock/iu_clock_include1.php',0,'R'); ?>?randval="+Math.random());
	myChart1.render("ius_clock");

	}

</script>

<!-- <iframe src="<?php echo $dns_adr; ?>/sfcs/projects/dashboards/production/index.php" width="0" height="0" tabindex="-1" title="empty" class="hidden"> -->

</body>
