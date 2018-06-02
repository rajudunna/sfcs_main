<?php
$start_timestamp = microtime(true);
include("header_sch.php");

$start=date("Y-m-01");
$end=date("Y-m-31");
if(strtotime(date("Y-m-d"))<=strtotime("2014-12-31"))  // comment 1:
{
$start='2014-11-27';
$end='2014-12-31';
}
echo $start."---".$end;
$act_sths=array();
$plan_sths=array();
$pers=array();

$full="350000";
$total="330000";
$sections=array();
$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(act_sth),sum(plan_sth),section FROM bai_pro.grand_rep where date between \"$start\" and \"$end\"  and section between 1 and 6 group by section order by round(sum(act_sth)*100/sum(plan_sth),0)");
while($row=mysqli_fetch_array($sql))
{
	if($row["sum(plan_sth)"]>0)
	{
	$pers[]=round($row["sum(act_sth)"]*100/$row["sum(plan_sth)"],0);
	}
	$sections[]=$row["section"];
	$act_sths[]=round($row["sum(act_sth)"],0);
	echo "<br>".round($row["sum(act_sth)"],0)."-".round($row["sum(plan_sth)"],0);
}
//echo sizeof($act_sths);
$act_sth_sort=sort($act_sths);
$act_sths_array=implode(",",$act_sths);
echo "<br>".$act_sths_array;

$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(act_sth),sum(plan_sth) FROM bai_pro.grand_rep where date between \"$start\" and \"$end\" and section=4");
while($row=mysqli_fetch_array($sql))
{
	$plan_sth=round($row["sum(plan_sth)"],0);
	$act_sth=round($row["sum(act_sth)"],0);
}
echo "<br>Act=".$act_sth;
echo "<br>Key = ".(array_search($act_sth,$act_sths));
echo "<br>Key = ".(6-array_search($act_sth,$act_sths));
$key=6-(array_search($act_sth,$act_sths));

$today_bal=$plan_sth-$act_sth;
if($plan_sth>0)
{
$per=round(($act_sth/$plan_sth)*100,0);
}
$key=6-(array_search(4,$sections));
//echo $per;
if($per >= 100)
{
	$col="00CC11";
}
else if($per <100 && $per >=70)
{
	$col="FFA500";
}
else
{
	$col="FF0000";
}

$today_bal=$plan_sth-$act_sth;

if($plan_sth >= $act_sth)
{
	$val=$act_sth;
}
else
{
	$val=$plan_sth;
}

$message= "<chart palette='1' lowerLimit='0' upperLimit='$plan_sth' majorTMNumber='0' canvasLeftMargin='120' caption='S-4' subcaption='$per%' showBorder='0' showValue='1' showTickMarks='0' showTickValues='0' targetColor='FF0000' plotFillColor='$col' ticksOnRight='1' >
    <colorRange>
        <color minValue='0' maxValue='$plan_sth' code='DDDDDD'/>
    </colorRange> 
    <value>$act_sth</value>
	
</chart>";
	
//To Write File
	$myFile = "hbullet".$key."_include.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "<?php echo \" ".$message."\"; ?>";
	fwrite($fh, $stringData);
	fclose($fh);
	//To Write File

$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>
