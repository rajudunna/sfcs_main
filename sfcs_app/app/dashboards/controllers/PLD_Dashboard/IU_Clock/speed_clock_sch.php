<?php
$start_timestamp = microtime(true);

include("dbconf_sch.php");

// include("../fusion_charts/Includes/FusionCharts.php");
$include_path=getenv('config_job_path');
include($include_path.'/sfcs_app/app/dashboards/controllers/PLD_Dashboard/FusionCharts.php');
$act_eff=6;
$day=date("D");

$sqlxx="select sum(speed_order_qty) as \"order\", sum(speed_out_qty) as \"out\" from bai_pro3.speed_del_dashboard";
//echo $sqlx;
$sql_resultxx=mysqli_query($link, $sqlxx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowxx=mysqli_fetch_array($sql_resultxx))
{
	$ord=$sql_rowxx['order'];
	$out=$sql_rowxx['out'];
}

$per_day=round(($ord/6),0);
if($per_day>0)
{
	$act_eff=round(($out/$per_day),1);
}
else
{
	$act_eff=0;
}
//VISIT SHOW
//$act_eff++;

switch($day)
{
	case "Mon":
	{
		$add="<point startValue='3' endValue='4' color='00BBBB' alpha='40' radius='230' innerRadius='5' showBorder='0'/>";
		break;
	}
	case "Tue":
	{
		$add="<point startValue='4' endValue='5' color='00BBBB' alpha='40' radius='230' innerRadius='5' showBorder='0'/>";
		break;
	}
	case "Wed":
	{
		$add="<point startValue='5' endValue='6' color='00BBBB' alpha='40' radius='230' innerRadius='5' showBorder='0'/>";
		break;
	}
	case "Thu":
	{
		$add="<point startValue='0' endValue='1' color='00BBBB' alpha='40' radius='230' innerRadius='5' showBorder='0'/>";
		
		break;
	}
	case "Fri":
	{
		$add="<point startValue='1' endValue='2' color='00BBBB' alpha='40' radius='230' innerRadius='5' showBorder='0'/>";
		
		break;
	}
	case "Sat":
	{
		$add="<point startValue='2' endValue='3' color='00BBBB' alpha='40' radius='230' innerRadius='5' showBorder='0'/>";
		
		break;
	}
}


$strXML  = "";
$strXML .= "<chart showTickMarks='1' showTickValues='1'  adjustTM='6' majorTMNumber='7' minorTMNumber='1' pivotFillColor='000000' lowerLimit='0' upperLimit='6' lowerLimitDisplay='Thu' upperLimitDisplay='Wed' gaugeStartAngle='245' gaugeEndAngle='-60' palette='1' numberSuffix='' tickValueDistance='20' showValue='1' decimals='0' editMode='0' baseFontColor='FFFFFF' baseFontSize ='18' bold='1' bgColor='333333' bgAlpha='100' showBorder='0'><trendpoints>$add</trendpoints><colorRange><color minValue='0' maxValue='7' code='000088' /><color minValue='7' maxValue='14' code='000088'/><color minValue='14' maxValue='21' code='000088'/><color minValue='21' maxValue='28' code='000088'/><color minValue='28' maxValue='35' code='000088'/><color minValue='35' maxValue='42' code='000088'/><color minValue='42' maxValue='49' code='000088'/><color minValue='49' maxValue='56' code='000088'/></colorRange><dials><dial id='CS' baseWidth='20' bgColor='FF0000' value='".$act_eff."' rearExtension='10'/></dials><styles><definition><style type='font' name='myValueFont' bgColor='F1f1f1' borderColor='333333' /><style type='font' name='myValueback' bgColor='333333' borderColor='333333' /></definition><application><apply toObject='Value' styles='myValueFont' /><apply toObject='Background' styles='myValueback' /></application></styles></chart>";
//$strXML .= "<chart adjustTM='12' majorTMNumber='1' minorTMNumber='1' pivotFillColor='000000' lowerLimit='0' upperLimit='100' lowerLimitDisplay='100' upperLimitDisplay='0' gaugeStartAngle='-60' gaugeEndAngle='244' palette='1' numberSuffix='' tickValueDistance='20' showValue='0' decimals='0' editMode='1'><trendpoints><point startValue='0' endValue='14' color='00BBBB' alpha='40' radius='230' innerRadius='5' showBorder='0'/></trendpoints><colorRange><color minValue='0' maxValue='14' code='000088' /><color minValue='14' maxValue='28' code='000088'/><color minValue='28' maxValue='42' code='000088'/><color minValue='42' maxValue='56' code='000088'/><color minValue='56' maxValue='70' code='000088'/><color minValue='70' maxValue='84' code='000088'/><color minValue='84' maxValue='100' code='000088'/></colorRange><dials><dial id='CS' value='".$act_eff."' rearExtension='20' /></dials><styles><definition><style type='font' name='myValueFont' bgColor='F1f1f1' borderColor='999999' /><style type='font' name='myValueback' bgColor='000000' borderColor='999999' /></definition><application><apply toObject='Value' styles='myValueFont' /><apply toObject='Background' styles='myValueback' /></application></styles></chart>";

?>
<html>
<head>
<META HTTP-EQUIV="REFRESH" CONTENT="900">
<style>
body
{
	color:white;
	font-family: arial;
}
</style>


</head>
<body bgcolor="#333333">


<script type="text/javascript" src="../Charts/FusionCharts.js"></script>
<script language="javascript">
	//FC_ChartUpdated method is called when user has changed dial value.
	function FC_ChartUpdated(DOMId){
		//Check if DOMId is that of the chart we want
		if (DOMId=="ChId1"){
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

<?php
//echo "<center><h1>IU CLOCK</h1></center>";
//echo renderChart("../Charts/AngularGauge.swf", "",$strXML, "FactorySum2", "600", "600", "0", "0");


//To Write File
	$myFile = "iu_clock_include.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData="<?php $";
	$stringData.="strXML=\"";
	$stringData.=$strXML;
	$stringData.="\"; ?>";
	
	fwrite($fh, $stringData);
	fclose($fh);
	//To Write File
	
	
	//To Write File
	$myFile = "iu_clock_include1.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData="<?php ";
	$stringData.="echo \"";
	$stringData.=str_replace("radius='230'","radius='80'",$strXML);
	$stringData.="\"; ?>";
	
	fwrite($fh, $stringData);
	fclose($fh);
	//To Write File
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>

