<?php

// include"header.php";
include"../../../../common/config/config.php";

$sql2=mysqli_query($link, "SELECT SUM(plan_pro) FROM $bai_pro.pro_plan WHERE DATE=\"$dat\" and sec_no=\"1\"");
while($row2=mysqli_fetch_array($sql2))
{
	$plan=$row2["SUM(plan_pro)"]/16;
}

$sql=mysqli_query($link, "SELECT SUM(act_out) FROM $bai_pro.grand_rep WHERE DATE=\"$dat\" and section=\"1\"");
while($row=mysqli_fetch_array($sql))
{
	$act=$row["SUM(act_out)"]/16;
}

$sql1=mysqli_query($link, "select max(bac_lastup) from $bai_pro.bai_log where bac_date=\"$dat\" and bac_sec=\"1\"");
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
		$var="<point startValue='0' endValue='1' color='FFCCDD' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";
		break;
	}
	case "1":
	{
		$var="<point startValue='1' endValue='2' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";
		break;
	}
	case "2":
	{
		$var="<point startValue='2' endValue='3' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";
		break;
	}
	case "3":
	{
		$var="<point startValue='3' endValue='4' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
	case "4":
	{
		$var="<point startValue='4' endValue='5' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
	case "5":
	{
		$var="<point startValue='5' endValue='6' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";	
		break;
	}
	case "6":
	{
		$var="<point startValue='6' endValue='7' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
	case "7":
	{
		$var="<point startValue='7' endValue='8' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
	case "8":
	{
		$var="<point startValue='8' endValue='9' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
	case "9":
	{
		$var="<point startValue='9' endValue='10' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
	case "10":
	{
		$var="<point startValue='10' endValue='11' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
	case "11":
	{
		$var="<point startValue='11' endValue='12' color='FFCCDD' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
	case "12":
	{
		$var="<point startValue='12' endValue='13' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
	case "13":
	{
		$var="<point startValue='13' endValue='14' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
	case "14":
	{
		$var="<point startValue='14' endValue='15' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
	case "15":
	{
		$var="<point startValue='15' endValue='16' color='00BBBB' alpha='40' radius='125' innerRadius='5' showBorder='0'/>";		
		break;
	}
}
echo "value = ".$hour;
echo "<chart showTickMarks='1' showTickValues='1'  adjustTM='1' majorTMNumber='16' minorTMNumber='0' pivotFillColor='HDFEDD' lowerLimit='0' upperLimit='16' lowerLimitDisplay='0' upperLimitDisplay='16' gaugeStartAngle='180' gaugeEndAngle='0' palette='1' numberSuffix='' tickValueDistance='25' showValue='0' decimals='0' editMode='0' baseFontColor='F1f1f1' baseFontSize ='18' bold='1' bgColor='333333' bgAlpha='100' showBorder='0'><trendpoints>".$var."</trendpoints><colorRange><color minValue='0' maxValue='1' code='000088'/><color minValue='1' maxValue='2' code='000088'/><color minValue='2' maxValue='3' code='000088'/><color minValue='3' maxValue='4' code='000088'/><color minValue='4' maxValue='5' code='000088'/><color minValue='5' maxValue='6' code='000088'/><color minValue='6' maxValue='7' code='000088'/><color minValue='7' maxValue='8' code='000088'/><color minValue='8' maxValue='9' code='000088'/><color minValue='9' maxValue='10' code='000088'/><color minValue='10' maxValue='11' code='000088'/><color minValue='11' maxValue='12' code='000088'/><color minValue='12' maxValue='13' code='000088'/><color minValue='13' maxValue='14' code='000088'/><color minValue='14' maxValue='15' code='000088'/><color minValue='15' maxValue='16' code='000088'/></colorRange><dials><dial id='CS' baseWidth='20' bgColor='FF0000' value='$final_value' rearExtension='10'/></dials><styles><definition><style type='font' name='myValueFont' bgColor='333333' borderColor='333333' /><style type='font' name='myValueback' bgColor='333333' borderColor='333333' /></definition><application><apply toObject='Value' styles='myValueFont' /><apply toObject='Background' styles='myValueback' /></application></styles></chart>";
?>