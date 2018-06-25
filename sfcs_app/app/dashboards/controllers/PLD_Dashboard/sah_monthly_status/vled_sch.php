<?php
$start_timestamp = microtime(true);

include("header_sch.php");

$start=date("Y-m-01");
$end=date("Y-m-31");
//echo $start."---".$end;

//$full="470000";
$full=$fac_plan_sah;
$total="300000";

$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(act_sth),sum(plan_sth) FROM bai_pro.grand_rep where date between \"$start\" and \"$end\"");
//echo "<br>select sum(act_sth),sum(plan_sth) FROM grand_rep where date=\"$date[$i]\"<br><br>";
while($row=mysqli_fetch_array($sql))
{
	$plan_sth=round($row["sum(plan_sth)"],0);
	$act_sth=round($row["sum(act_sth)"],0);
	//echo "<br>".$plan_sth."---".$act_sth;
}

$today_bal=$plan_sth-$act_sth;

$message= "<chart Caption='Section wise Efficiency Graph' upperLimit='$full' lowerLimit='0' numberSuffix='' majorTMNumber='' majorTMColor='646F8F' majorTMHeight='' minorTMNumber='' minorTMColor='646F8F' showValues='1' minorTMHeight='' majorTMThickness='1' decimalPrecision='0' ledGap='0' ledSize='1' ledBorderThickness='4'>

	<colorRange>
		<color minValue='0' maxValue='$plan_sth' code='FFFF00' name='$act_sth' />
		<color minValue='$plan_sth' maxValue='$total' code='FF0000' />
		<color minValue='$total' maxValue='$full' code='00FF00' />		
	</colorRange>
	<value>$act_sth</value>
	 <styles>
 <definition>
  <style name='ValueFont' type='Font' bgColor='333333' size='10' color='FFFFFF' /> 
  </definition>
 <application>
  <apply toObject='VALUE' styles='valueFont' /> 
  </application>
  </styles>
</chart>";

//To Write File
	$myFile = "vled_include.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "<?php echo \" ".$message."\"; ?>";
	fwrite($fh, $stringData);
	fclose($fh);
	//To Write File
	
	//NEW Way to represent the same chart
		
		include"data.php";
		$start=date("Y-m-01");
		$end=date("Y-m-31");
		
		$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(act_sth),sum(plan_sth) FROM bai_pro.grand_rep where date between \"$start\" and \"$end\"");
		//echo "<br>select sum(act_sth),sum(plan_sth) FROM grand_rep where date=\"$date[$i]\"<br><br>";
		while($row=mysqli_fetch_array($sql))
		{
			$plan_sth=round($row["sum(plan_sth)"],0);
			$act_sth=round($row["sum(act_sth)"],0);
			//echo "<br>".$plan_sth."---".$act_sth;
		}
		
		$plan=$plan_sth;
		$actual=$act_sth;
		//$fac_plan="300000";
		//$fac_ac="470000";
		$fac_ac=$fac_plan_sah;
		echo $fac_ac."<br>";
		echo $plan."<br>";
		echo $actual."<br>";
		
		$plan_per=round($plan*100/$fac_ac,0);
		$acu_fac=round($actual*100/$fac_ac,0);
		$mtd=$plan_per+$acu_fac;
		$fac_plan_fac=round($fac_plan*100/$fac_ac,0);
		$act_per=$acu_fac-$plan_per;
		$fac_per=$fac_plan_fac-$acu_fac;
		$fac_cap_per=100-$plan_per-$act_per-$fac_per;
		
		
		$message= "<table class\"wif\" border=0 height=\"".(100+20)."px\" width=\"8%\">";
		$message.= "<tr>";
		$message.= "<th class=xl636518 bgcolor=\"#FF0000\" height=\"".abs($fac_cap_per+20)."px\">Factory Capacity</th>";
		$message.= "<th class=xl636519>$fac_ac(100%)</th>";
		$message.= "</tr>";
		$message.= "<tr>";
		$message.= "<th class=xl636518 bgcolor=\"#008000\" height=\"".abs($fac_per+20)."px\">Monthly Plan</th>";
		$message.= "<th class=xl636519>$fac_plan($fac_plan_fac%)</th>";
		$message.= "</tr>";
		$message.= "<tr>";
		$message.= "<th class=xl636518 bgcolor=\"#00FF00\" height=\"".abs($act_per+20)."px\">MTD Plan</th>";
		$message.= "<th class=xl636519>$plan($plan_per%)</th>";
		$message.= "</tr>";
		$message.= "<tr>";
		$message.= "<th class=xl636518 bgcolor=\"#FFA500\" height=\"".abs($plan_per+20)."px\">MTD Actual</th>";
		$message.= "<th class=xl636519>$actual($acu_fac%)</th>";
		$message.= "</tr>";
		$message.= "</table>";
		echo $message;
		//To Write File
		$myFile = "vled_include.php";
		$fh = fopen($myFile, 'w') or die("can't open file");
		$stringData = "<?php echo '".$message."'; ?>";
		fwrite($fh, $stringData);
		fclose($fh);
		//To Write File

	
	//New Way to represent the same chart
	
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");

?>
