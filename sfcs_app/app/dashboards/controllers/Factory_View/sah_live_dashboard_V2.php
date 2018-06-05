<?php
	include ("../../../../common/config/config.php");
	include ("../../../../common/config/functions.php");
	set_time_limit(2000);
	include("../../../../common/js/Charts/FusionCharts.php");
	error_reporting(0);
?>

<html>
<head>

<script type="text/javascript" src="../../../../common/js/jquery.min.js"></script>
<script type="text/javascript" src="../../../../common/js/Charts/FusionCharts.js"></script>
<style>
iframe 
{
	height:100%;
	border: 0;
	overflow:auto;
}

body 
{
	zoom: 90%;
	overflow:auto;
	background-color:#eeeeee;
	color: #000000;
	font-family: Trebuchet MS;
}

table
{
	height:auto;
}
th
{
	font-size:75px;
	width:100px;
}

td
{
	
	vertical-align:top;
	
}

</style>
</head>
<body>
<?php
$sec_x=$_GET['sec_x'];
$date="";
include"header.php";
include"data.php";
$today=date("Y-m-d");
$start="2011-12-01";
$end="2011-12-31";

$sql=mysqli_query($link, "SELECT distinct(DATE) FROM $bai_pro.grand_rep WHERE DATE BETWEEN \"$start\" AND \"$end\" and section=$sec_x order by date");
//echo "SELECT DISTINCT(DATE) FROM $bai_pro.grand_rep WHERE DATE BETWEEN \"$start\" AND \"$end\"";
while($row=mysqli_fetch_array($sql))
{
	$date2[]=$row["DATE"];
}

// $plan_sth="";
$plan_sth = array();
$act_sth=array();

for($x=0;$x<sizeof($date);$x++)
{
	if($date[$x] == $today)
	{
		$limit=$x+1;
	}
}
//echo "<br>".$limit."<br>";
for($i=0;$i<$limit;$i++)
{
	$sql=mysqli_query($link, "select sum(act_sth),sum(plan_sth) FROM $bai_pro.grand_rep where date=\"$date[$i]\" and section=$sec_x");
	//echo "<br>select sum(act_sth),sum(plan_sth) FROM $bai_pro.grand_rep where date=\"$date[$i]\"<br><br>";
	while($row=mysqli_fetch_array($sql))
	{
		$plan_sth[]=round($row["sum(plan_sth)"],0);
		$act_sth[]=round($row["sum(act_sth)"],0);
	}
}

$size=sizeof($date);
$sizes=$size-1;
$sah_start=$date[0];
$sah_end=$date[$sizes];
//echo "<br>".$size."<br>";

//$message= "<chart caption='Daily Plan VS Actual SAH Graph' subcaption='(from $sah_start to $today)' lineThickness='4' showValues='0' formatNumberScale='0' anchorRadius='4' divLineAlpha='20' divLineColor='8AA01D' divLineIsDashed='1' showAlternateHGridColor='1' alternateHGridColor='CC3300' shadowAlpha='40' labelStep=\"1\" numvdivlines='28' chartRightMargin=\"35\" bgColor='FFFFFF,CC3300' bgAngle='270' bgAlpha='10,10'><categories >";
$message= "<chart lineThickness='4' showValues='0' formatNumberScale='0' anchorRadius='4' divLineAlpha='20' divLineColor='8AA01D' divLineIsDashed='1' showAlternateHGridColor='1' alternateHGridColor='CC3300' shadowAlpha='40' labelStep='1' numvdivlines='10' chartRightMargin='35' bgColor='FFFFFF,CC3300' bgAngle='270' bgAlpha='10,10' showYAxisValues='0' yAxisMinValue='0' yAxisMaxValue='4500'><categories >";
for($i=0;$i<sizeof($date1);$i++)
{
	$message.= "<category label='".$date1[$i]."' />";
}

$message.= "</categories>
<dataset seriesName='Plan SAH' color='F1683C' anchorBorderColor='F1683C' anchorBgColor='F1683C'>";
	for($j=0;$j<sizeof($plan_sth);$j++)
	{
		$message.= "<set value='".$plan_sth[$j]."' />";
	}
$message.= "</dataset>

<dataset seriesName='Actual SAH' color='2AD62A' anchorBorderColor='2AD62A' anchorBgColor='2AD62A'>";
	for($k=0;$k<sizeof($act_sth);$k++)
	{
		$message.= "<set value='".$act_sth[$k]."' />";
	}
	
$message.= "</dataset>

<trendLines>
<line startValue='500' color='FF0000' displayvalue='500' />
<line startValue='1100' color='FF0000' displayvalue='1,100' />
<line startValue='2200' color='000000' displayvalue='2,200' />
<line startValue='4000' color='000000' displayvalue='4,000' />
</trendLines>

	<styles>                
		<definition>
                         
			<style name='CaptionFont' type='font' size='12'/>
		</definition>
		<application>
			<apply toObject='CAPTION' styles='CaptionFont' />
			<apply toObject='SUBCAPTION' styles='CaptionFont' />
		</application>
	</styles>

</chart>";

//To Write File
	$myFile = "line_include_$sec_x.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "<?php echo \" ".$message."\"; ?>";
	fwrite($fh, $stringData);
	fclose($fh);
	//To Write File

?>
<table>
<tr>
<td colspan="2"><iframe style="width: 1200px; height:525px;" src="../HPT_Dashboard/Hourly_Eff_Live.php?sec_x=<?php echo $_GET['sec_x']; ?>" frameborder="no"> </iframe>
</td>
</tr>
<tr>
<td>

<div style="float:left;">
<div id="chart11divc3"></div>

   <?php 
		echo "<script type=\"text/javascript\">
		   var chart1 = new FusionCharts(\"../../../../common/js/Charts/MSLine.swf\", \"ChId1\", \"1200\", \"325\",\"0\", \"1\");
		   chart1.setDataURL(\"line_include_".$sec_x.".php\");
		   chart1.render(\"chart11divc3\");
		</script>";
   ?>

</div>
</td>
</tr>

</table>
<div style="clear: both;"> </div>

</body>
</html>
