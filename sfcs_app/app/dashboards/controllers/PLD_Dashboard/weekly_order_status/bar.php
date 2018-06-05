<?php

include"header.php";

/*$date = $dat; 
$date=date("Y-m-d",strtotime("3 day"));
//$weekday = date('l', strtotime($date));
$weekday = date('l', strtotime($date));

$monday=date("Y-m-d",strtotime("-2 day"));
$thuesday=date("Y-m-d",strtotime("-1 day"));
$wednesday=date("Y-m-d",strtotime("-0 day"));
$thursday=date("Y-m-d",strtotime("+1 day"));
$friday=date("Y-m-d",strtotime("+2 day"));
$saturday=date("Y-m-d",strtotime("+3 day"));
echo "<br>".$weekday."---".$monday."---".$tuesday."---".$wednesday."---".$thursday."---".$friday."---".$saturday;*/

$sql1=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(ord_qty_new),SUM(output) FROM week_delivery_plan_ref WHERE ex_factory_date_new=\"$monday\" ");
//echo "SELECT SUM(ord_qty_new),SUM(output) FROM week_delivery_plan_ref WHERE ex_factory_date_new=\"$monday\" and where style not like \"M%\"";
while($row1=mysqli_fetch_array($sql1))
{
	$ord_qty_new1=$row1["SUM(ord_qty_new)"];
	$output1=$row1["SUM(output)"];
}

$sql2=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(ord_qty_new),SUM(output) FROM week_delivery_plan_ref WHERE ex_factory_date_new=\"$thuesday\" ");
//echo "SELECT SUM(ord_qty_new),SUM(output) FROM week_delivery_plan_ref WHERE ex_factory_date_new=\"$thuesday\"";
while($row2=mysqli_fetch_array($sql2))
{
	$ord_qty_new2=$row2["SUM(ord_qty_new)"];
	$output2=$row2["SUM(output)"];
}

$sql3=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(ord_qty_new),SUM(output) FROM week_delivery_plan_ref WHERE ex_factory_date_new=\"$wednesday\" ");
//echo "SELECT SUM(ord_qty_new),SUM(output) FROM week_delivery_plan_ref WHERE ex_factory_date_new=\"$wednesday\"";
while($row3=mysqli_fetch_array($sql3))
{
	$ord_qty_new3=$row3["SUM(ord_qty_new)"];
	$output3=$row3["SUM(output)"];
}

$sql4=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(ord_qty_new),SUM(output) FROM week_delivery_plan_ref WHERE ex_factory_date_new=\"$thursday\" ");
//echo "SELECT SUM(ord_qty_new),SUM(output) FROM week_delivery_plan_ref WHERE ex_factory_date_new=\"$thursday\"";
while($row4=mysqli_fetch_array($sql4))
{
	$ord_qty_new4=$row4["SUM(ord_qty_new)"];
	$output4=$row4["SUM(output)"];
}

$sql5=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(ord_qty_new),SUM(output) FROM week_delivery_plan_ref WHERE ex_factory_date_new=\"$friday\" ");
//echo "SELECT SUM(ord_qty_new),SUM(output) FROM week_delivery_plan_ref WHERE ex_factory_date_new=\"$friday\"";
while($row5=mysqli_fetch_array($sql5))
{
	$ord_qty_new5=$row5["SUM(ord_qty_new)"];
	$output5=$row5["SUM(output)"];
}

$sql6=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(ord_qty_new),SUM(output) FROM week_delivery_plan_ref WHERE ex_factory_date_new=\"$saturday\" ");
//echo "SELECT SUM(ord_qty_new),SUM(output) FROM week_delivery_plan_ref WHERE ex_factory_date_new=\"$saturday\"";
while($row6=mysqli_fetch_array($sql6))
{
	$ord_qty_new6=$row6["SUM(ord_qty_new)"];
	$output6=$row6["SUM(output)"];
}
 
$bal1=round(($ord_qty_new1-$output1),0);
$bal2=round(($ord_qty_new2-$output2),0);
$bal3=round(($ord_qty_new3-$output3),0);
$bal4=round(($ord_qty_new4-$output4),0);
$bal5=round(($ord_qty_new5-$output5),0);
$bal6=round(($ord_qty_new6-$output6),0);
if($bal1 > 0)
{
	$bal11=$bal1;
}
else
{
	$bal11="";
}

if($bal2 > 0)
{
	$bal21=$bal2;
}
else
{
	$bal21="";
}

if($bal3 > 0)
{
	$bal31=$bal3;
}
else
{
	$bal31="";
}

if($bal4 > 0)
{
	$bal41=$bal4;
}
else
{
	$bal41="";
}

if($bal5 > 0)
{
	$bal51=$bal5;
}
else
{
	$bal51="";
}

if($bal6 > 0)
{
	$bal61=$bal6;
}
else
{
	$bal61="";
}
$message= " <chart palette='1' shownames='1' showvalues='1' numberPrefix='' sYAxisValuesDecimals='2' connectNullData='0' PYAxisName='Order Quantity Vs Output' SYAxisName='' numDivLines='8' formatNumberScale='0'>
 <categories>
  <category label='Monday,	$monday' /> 
  <category label='Tuesday,  $thuesday' /> 
  <category label='Wednesday,  $wednesday' /> 
  <category label='Thursday,  $thursday' /> 
  <category label='Friday,  $friday' /> 
  <category label='Saturday,  $saturday' /> 
  </categories>
 <dataset seriesName='Output' showValues='0'>
  <set value='$output1' /> 
  <set value='$output2' /> 
  <set value='$output3' /> 
  <set value='$output4' /> 
  <set value='$output5' /> 
  <set value='$output6' /> 
  </dataset>
 <dataset seriesName='Balance Qty' showValues='0'>
  <set value='$bal11' /> 
  <set value='$bal21' />  
  <set value='$bal31' /> 
  <set value='$bal41' />  
  <set value='$bal51' /> 
  <set value='$bal61' />  
  </dataset>
  </chart>";
  
   //To Write File
	$myFile = "bar_include.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "<?php echo \" ".$message."\"; ?>";
	fwrite($fh, $stringData);
	fclose($fh);
	//To Write File
	
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"linear.php\"; }</script>";
?>