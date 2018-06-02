<?php
$date="";
include"header.php";
//include"data.php";
$today=date("Y-m-d");
$start="2011-12-01";
$end="2011-12-31";

$sql=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT distinct(DATE) FROM grand_rep WHERE DATE BETWEEN \"$start\" AND \"$end\" order by date");
//echo "SELECT DISTINCT(DATE) FROM grand_rep WHERE DATE BETWEEN \"$start\" AND \"$end\"";
while($row=mysqli_fetch_array($sql))
{
	$date2[]=$row["DATE"];
}

$date=array("2012-01-02","2012-01-03","2012-01-04","2012-01-05","2012-01-06","2012-01-07","2012-01-08","2012-01-09","2012-01-10","2012-01-11","2012-01-12","2012-01-13","2012-01-18","2012-01-19","2012-01-20","2012-01-21","2012-01-23","2012-01-24","2012-01-25","2012-01-26","2012-01-27","2012-01-28","2012-01-30","2012-01-31");

$date1=array("02","03","04","05","06","07","08","09","10","11","12","13","18","19","20","21","23","24","25","26","27","28","30","31");

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
	$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(act_sth),sum(plan_sth) FROM grand_rep where date=\"$date[$i]\"");
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
//echo "<br>".$size."<br>";

//$message= "<chart caption='Daily Plan VS Actual SAH Graph' subcaption='(from $sah_start to $today)' lineThickness='4' showValues='0' formatNumberScale='0' anchorRadius='4' divLineAlpha='20' divLineColor='8AA01D' divLineIsDashed='1' showAlternateHGridColor='1' alternateHGridColor='CC3300' shadowAlpha='40' labelStep=\"1\" numvdivlines='28' chartRightMargin=\"35\" bgColor='FFFFFF,CC3300' bgAngle='270' bgAlpha='10,10'><categories >";
$message= "<chart lineThickness='4' showValues='0' formatNumberScale='0' anchorRadius='4' divLineAlpha='20' divLineColor='8AA01D' divLineIsDashed='1' showAlternateHGridColor='1' alternateHGridColor='CC3300' shadowAlpha='40' labelStep='1' numvdivlines='28' chartRightMargin='35' bgColor='FFFFFF,CC3300' bgAngle='270' bgAlpha='10,10'><categories >";
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
	
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"vled.php\"; }</script>";
?>