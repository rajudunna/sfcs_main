<?php

set_time_limit(100000000000);
include"header.php";
for($i=1;$i<=6;$i++)   
{
$sql15=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(plan_clh),SUM(act_clh),SUM(plan_sth),SUM(act_sth) FROM grand_rep WHERE DATE=\"$dat\" and section=\"$i\"");
while($row2=mysqli_fetch_array($sql15))
{
	$plan_sth1[]=round($row2["SUM(plan_sth)"],0);
	$plan_clh1[]=round($row2["SUM(plan_clh)"],0);
	$act_sth1[]=round($row2["SUM(act_sth)"],0);
	$act_clh1[]=round($row2["SUM(act_clh)"],0);
	$j=$i-1;
	$plan_eff1[]=round($plan_sth1[$j]*100/$plan_clh1[$j],0);
	$act_eff1[]=round($act_sth1[$j]*100/$act_clh1[$j],0);
	$sections[]=$i;
}
}

$message= "<chart palette='2' caption='' shownames='1' showvalues='1' numberPrefix='' sYAxisValuesDecimals='2' connectNullData='0' PYAxisName='Order Quantity Vs Output' SYAxisName='' numDivLines='8' formatNumberScale='0' showBorder='1' numberSuffix='%' preSuffix='%'>
 <categories>
  <category label='S-1' /> 
  <category label='S-2' /> 
  <category label='S-3' /> 
  <category label='S-4' /> 
  <category label='S-5' /> 
  <category label='S-6' /> 
  </categories>
 <dataset seriesName='Reached Efficiency' showValues='1'>";
 for($k=0;$k<sizeof($sections);$k++)
 {
    $message.= "<set value='".$act_eff1[$k]."' /> ";
 } 
 $message.= " </dataset>
 
 <dataset seriesName='Balance Efficiency' showValues='1'>";
 for($k=0;$k<sizeof($sections);$k++)
 {
    $balance=($plan_eff1[$k]-$act_eff1[$k]);
	if($balance >= 0)
	{
		$message.= "<set value='".$balance."' /> ";
	}
	else
	{
		$message.= "<set value='".($balance*(-1))."' /> ";
	}
	
 } 
 $message.= " </dataset>
 
 
 </chart>";
 
 /*$message= "<chart caption='Section Wise Efficiency' xAxisName='Sections' yAxisName='Efficiency ' showValues='1' decimals='0' formatNumberScale='0'>";
 
 for($k=0;$k<sizeof($sections);$k++)
 {
    $message.= "<set label='".$k."' value='".$act_eff1[$k]."' /> ";
 } 
 $message.= " </chart>"*/
 
 //To Write File
	$myFile = "Eff_bar_include.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "<?php echo \" ".$message."\"; ?>";
	fwrite($fh, $stringData);
	fclose($fh);
	//To Write File
	
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"Eff_gauge.php\"; }</script>";
?>