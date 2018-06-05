<?php
$start_timestamp = microtime(true);
include("header_sch.php");

$sql1=mysqli_query($GLOBALS["___mysqli_ston"], "select SUM(ord_qty_new),SUM(output) FROM bai_pro4.week_delivery_plan_ref WHERE ex_factory_date_new=\"$monday\" ");
while($row1=mysqli_fetch_array($sql1))
{
	$ord_qty_new1=$row1["SUM(ord_qty_new)"];
	$output1=$row1["SUM(output)"];
}

$sql2=mysqli_query($GLOBALS["___mysqli_ston"], "select SUM(ord_qty_new),SUM(output) FROM bai_pro4.week_delivery_plan_ref WHERE ex_factory_date_new=\"$thuesday\" ");
while($row2=mysqli_fetch_array($sql2))
{
	$ord_qty_new2=$row2["SUM(ord_qty_new)"];
	$output2=$row2["SUM(output)"];
}

$sql3=mysqli_query($GLOBALS["___mysqli_ston"], "select SUM(ord_qty_new),SUM(output) FROM bai_pro4.week_delivery_plan_ref WHERE ex_factory_date_new=\"$wednesday\" ");
while($row3=mysqli_fetch_array($sql3))
{
	$ord_qty_new3=$row3["SUM(ord_qty_new)"];
	$output3=$row3["SUM(output)"];
}

$sql4=mysqli_query($GLOBALS["___mysqli_ston"], "select SUM(ord_qty_new),SUM(output) FROM bai_pro4.week_delivery_plan_ref WHERE ex_factory_date_new=\"$thursday\" ");
while($row4=mysqli_fetch_array($sql4))
{
	$ord_qty_new4=$row4["SUM(ord_qty_new)"];
	$output4=$row4["SUM(output)"];
}

$sql5=mysqli_query($GLOBALS["___mysqli_ston"], "select SUM(ord_qty_new),SUM(output) FROM bai_pro4.week_delivery_plan_ref WHERE ex_factory_date_new=\"$friday\" ");
while($row5=mysqli_fetch_array($sql5))
{
	$ord_qty_new5=$row5["SUM(ord_qty_new)"];
	$output5=$row5["SUM(output)"];
}

$sql6=mysqli_query($GLOBALS["___mysqli_ston"], "select SUM(ord_qty_new),SUM(output) FROM bai_pro4.week_delivery_plan_ref WHERE ex_factory_date_new=\"$saturday\" ");
while($row6=mysqli_fetch_array($sql6))
{
	$ord_qty_new6=$row6["SUM(ord_qty_new)"];
	$output6=$row6["SUM(output)"];
}

$tot1=$ord_qty_new1+$ord_qty_new2;
$tot2=$tot1+$ord_qty_new3;
$tot3=$tot2+$ord_qty_new4;
$tot4=$tot3+$ord_qty_new5;
$tot5=$tot4+$ord_qty_new6;

$totl1=$output1+$output2;
$totl2=$totl1+$output3;
$totl3=$totl2+$output4;
$totl4=$totl3+$output5;
$totl5=$totl4+$output6;

$div=round($tot5/6,0);
//echo $weekday;
if($weekday == "Monday")
{
	$id1="8BBA00";
	//echo "<br>".$id1."<br>";
}
else
{
	$id1="F1683C";
	//echo "<br>".$id1."<br>";
}
if($weekday == "Tuesday")
{
	$id2="8BBA00";
	//echo "<br>".$id2."<br>";
}
else
{
	$id2="F1683C";
	//echo "<br>".$id2."<br>";
}
if($weekday == "Wednesday")
{
	$id3="8BBA00";
	//echo "<br>".$id3."<br>";
}
else
{
	$id3="F1683C";
	//echo "<br>".$id3."<br>";
}
if($weekday == "Thursday")
{
	$id4="8BBA00";
	//echo "<br>".$id4."<br>";
}
else
{
	$id4="F1683C";
	//echo "<br>".$id4."<br>";
}
if($weekday == "Friday")
{
	$id5="8BBA00";
	//echo "<br>".$id5."<br>";
}
else
{
	$id5="F1683C";
	//echo "<br>".$id5."<br>";
}
if($weekday == "Saturday")
{
	$id6="8BBA00";
	//echo "<br>".$id6."<br>";
}
else
{
	$id6="F1683C";
	//echo "<br>".$id6."<br>";
}



$message= " <Chart bgColor='FFFFFF' bgAlpha='0' showBorder='1' upperLimit='".($div*6)."' lowerLimit='0' gaugeRoundRadius='5' chartBottomMargin='10' ticksBelowGauge='0' showValues='1' showGaugeLabels='1' valueAbovePointer='0' pointerOnTop='1' pointerRadius='9'>
 <colorRange>
  <color minValue='0' maxValue='".($div*1)."' code='$id1' name='Monday' /> 
  <color minValue='".($div*1)."' maxValue='".($div*2)."' code='$id2' name='Tuesday' /> 
  <color minValue='".($div*2)."' maxValue='".($div*3)."' code='$id3' name='Wednesday' /> 
  <color minValue='".($div*3)."' maxValue='".($div*4)."' code='$id4' name='Thursday' /> 
  <color minValue='".($div*4)."' maxValue='".($div*5)."' code='$id5' name='Friday' /> 
  <color minValue='".($div*5)."' maxValue='".($div*6)."' code='$id6' name='Saturday' /> 
  </colorRange>
  <value>$totl5</value> 
 <styles>
 <definition>
  <style name='ValueFont' type='Font' bgColor='333333' size='10' color='FFFFFF' /> 
  </definition>
 <application>
  <apply toObject='VALUE' styles='valueFont' /> 
  </application>
  </styles>
  </Chart>";
  
   //To Write File
	$myFile = "linear_include.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "<?php echo \" ".$message."\"; ?>";
	fwrite($fh, $stringData);
	fclose($fh);
	//To Write File
	
	
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>
