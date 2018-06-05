<?php
$start_timestamp = microtime(true);

$date="";
include("header_sch.php");
include"data.php";
$today=date("Y-m-d");
$start="2011-12-01";
$end="2011-12-31";

$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select distinct(DATE) FROM bai_pro.grand_rep WHERE DATE BETWEEN \"$start\" AND \"$end\" order by date");
while($row=mysqli_fetch_array($sql))
{
	$date2[]=$row["DATE"];
}

$plan_sth="";
$act_sth="";

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
	$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(act_sth),sum(plan_sth) FROM bai_pro.grand_rep where date=\"$date[$i]\"");
	//echo "<br>select sum(act_sth),sum(plan_sth) FROM grand_rep where date=\"$date[$i]\"<br><br>";
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

$message= "<chart lineThickness='4' showValues='0' formatNumberScale='0' anchorRadius='4' divLineAlpha='20' divLineColor='8AA01D' divLineIsDashed='1' showAlternateHGridColor='1' alternateHGridColor='CC3300' shadowAlpha='40' labelStep='1' numvdivlines='28' chartRightMargin='35' bgColor='FFFFFF,CC3300' bgAngle='270' bgAlpha='10,10' showYAxisValues='0' yAxisMinValue='2000' yAxisMaxValue='17000'><categories >";
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
<line startValue='10000' color='FF0000' displayvalue='10,000' />
<line startValue='12000' color='FF0000' displayvalue='12,000' />
<line startValue='14000' color='000000' displayvalue='14,000' />
<line startValue='16000' color='000000' displayvalue='16,000' />
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
	$myFile = "line_include.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "<?php echo \" ".$message."\"; ?>";
	fwrite($fh, $stringData);
	fclose($fh);
	//To Write File
	
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");

?>
