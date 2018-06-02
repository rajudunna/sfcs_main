<?php

include"header.php";

$sql2=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(plan_sth) FROM grand_rep WHERE DATE=\"$dat\" and section=\"2\"");
while($row2=mysqli_fetch_array($sql2))
{
	$plan=$row2["SUM(plan_sth)"]/16;
	$plan_act=round($row2["SUM(plan_sth)"],0);
}

$sql=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(act_sth) FROM grand_rep WHERE DATE=\"$dat\" and section=\"2\"");
while($row=mysqli_fetch_array($sql))
{
	$actl=$row["SUM(act_sth)"]/16;
	$act_act=round($row["SUM(act_sth)"],0);
}

if($plan_act > $act_act)
{
	$final=$plan_act;
	$act=$plan;
}
else
{
	$final=$act_act;
	$act=$actl;
}
//echo "Final = ".$final."<br>";

$sql1=mysqli_query($GLOBALS["___mysqli_ston"], "select max(bac_lastup) from bai_log where bac_date=\"$dat\" and bac_sec=\"2\"");
while($row1=mysqli_fetch_array($sql1))
{
	$time=$row1["max(bac_lastup)"];
}

$time_split=explode(" ",$time);
$clock=$time_split[1];

$clock_split=explode(":",$clock);

$hour=$clock_split[0];

echo "Hour = ".$hour;

$hour_value=$hour-6;

$act_val=round($act,0)*$hour_value;
$plan_val=round($plan,0)*$hour_value;

$final_value=round(($act_val/$plan_val)*16,2);

$hour=$present_time;

echo "HOUR = ".$final_value." hOUR vALUE = ".$hour_value;

switch($hour)
{
	case "0":
	{
		$var="<point startValue='0' endValue='".(round($act*1,0))."' color='FFCCDD' alpha='40' radius='199' innerRadius='5' showBorder='0'/>";
		break;
	}
	case "1":
	{
		$var="<point startValue='".(round($act*1,0))."' endValue='".(round($act*2,0))."' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";
		break;
	}
	case "2":
	{
		$var="<point startValue='".(round($act*2,0))."' endValue='".(round($act*3,0))."' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";
		break;
	}
	case "3":
	{
		$var="<point startValue='".(round($act*3,0))."' endValue='".(round($act*4,0))."' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
	case "4":
	{
		$var="<point startValue='".(round($act*4,0))."' endValue='".(round($act*5,0))."' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
	case "5":
	{
		$var="<point startValue='".(round($act*5,0))."' endValue='".(round($act*6,0))."' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";	
		break;
	}
	case "6":
	{
		$var="<point startValue='".(round($act*6,0))."' endValue='".(round($act*7,0))."' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
	case "7":
	{
		$var="<point startValue='".(round($act*7,0))."' endValue='".(round($act*8,0))."' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
	case "8":
	{
		$var="<point startValue='".(round($act*8,0))."' endValue='".(round($act*9,0))."' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
	case "9":
	{
		$var="<point startValue='".(round($act*9,0))."' endValue='".(round($act*10,0))."' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
	case "10":
	{
		$var="<point startValue='".(round($act*10,0))."' endValue='".(round($act*11,0))."' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
	case "11":
	{
		$var="<point startValue='".(round($act*11,0))."' endValue='".(round($act*12,0))."' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
	case "12":
	{
		$var="<point startValue='".(round($act*12,0))."' endValue='".(round($act*13,0))."' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
	case "13":
	{
		$var="<point startValue='".(round($act*13,0))."' endValue='".(round($act*14,0))."' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
	case "14":
	{
		$var="<point startValue='".(round($act*14,0))."' endValue='".(round($act*15,0))."' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
	case "15":
	{
		$var="<point startValue='".(round($act*15,0))."' endValue='".(round($act*16,0))."' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
}
echo "value = ".$hour;
if($plan_act > 0 && $act_act > 0)
{
$message= "<chart showTickMarks='0' showTickValues='1' adjustTM='0' majorTMNumber='8' minorTMNumber='0' pivotFillColor='HDFEDD' lowerLimit='0' upperLimit='$final' lowerLimitDisplay='0' upperLimitDisplay='$final' gaugeStartAngle='180' gaugeEndAngle='0' palette='1' numberSuffix='' tickValueDistance='25' showValue='0' decimals='0' editMode='0' baseFontColor='F1f1f1' baseFontSize ='18' bold='1' bgColor='333333' bgAlpha='100' showBorder='0'><trendpoints>".$var."</trendpoints><colorRange><color minValue='0' maxValue='".(round($act*1,0))."' code='000088'/><color minValue='".(round($act*1,0))."' maxValue='".(round($act*2,0))."' code='000088'/><color minValue='".(round($act*2,0))."' maxValue='".(round($act*3,0))."' code='000088'/><color minValue='".(round($act*3,0))."' maxValue='".(round($act*4,0))."' code='000088'/><color minValue='".(round($act*4,0))."' maxValue='".(round($act*5,0))."' code='000088'/><color minValue='".(round($act*5,0))."' maxValue='".(round($act*6,0))."' code='000088'/><color minValue='".(round($act*6,0))."' maxValue='".(round($act*7,0))."' code='000088'/><color minValue='".(round($act*7,0))."' maxValue='".(round($act*8,0))."' code='000088'/><color minValue='".(round($act*8,0))."' maxValue='".(round($act*9,0))."' code='000088'/><color minValue='".(round($act*9,0))."' maxValue='".(round($act*10,0))."' code='000088'/><color minValue='".(round($act*10,0))."' maxValue='".(round($act*11,0))."' code='000088'/><color minValue='".(round($act*11,0))."' maxValue='".(round($act*12,0))."' code='000088'/><color minValue='".(round($act*12,0))."' maxValue='".(round($act*13,0))."' code='000088'/><color minValue='".(round($act*13,0))."' maxValue='".(round($act*14,0))."' code='000088'/><color minValue='".(round($act*14,0))."' maxValue='".(round($act*15,0))."' code='000088'/><color minValue='".(round($act*15,0))."' maxValue='".(round($act*16,0))."' code='000088'/></colorRange><dials><dial id='CS' baseWidth='20' bgColor='FF0000' value='$act_act' rearExtension='10'/></dials><styles><definition><style type='font' name='myValueFont' bgColor='333333' borderColor='333333' /><style type='font' name='myValueback' bgColor='333333' borderColor='333333' /></definition><application><apply toObject='Value' styles='myValueFont' /><apply toObject='Background' styles='myValueback' /></application></styles></chart>";
}
else
{
	$message= "<h2>No Data to Display</h2>";
}

 //To Write File
	$myFile = "section_2_include.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "<?php echo \" ".$message."\"; ?>";
	fwrite($fh, $stringData);
	fclose($fh);
	//To Write File
	
?>