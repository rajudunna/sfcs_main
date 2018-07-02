<?php

include("header_sch.php");

$start=date("Y-m-01");
$end=date("Y-m-31");
echo $start."---".$end;

$full="470000";
$total="300000";

$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select sum(act_sth),sum(plan_sth) FROM grand_rep where date between \"$start\" and \"$end\"");
//echo "<br>select sum(act_sth),sum(plan_sth) FROM grand_rep where date=\"$date[$i]\"<br><br>";
while($row=mysqli_fetch_array($sql))
{
	$plan_sth=round($row["sum(plan_sth)"],0);
	$act_sth=round($row["sum(act_sth)"],0);
	//echo "<br>".$plan_sth."---".$act_sth;
}

$plan_bal=$plan_sth-$act_sth;
$plan_mon_bal=$total-$plan_sth;
$fac_bal=$full-$total;

$message= "  <chart palette='2' shownames='0' showvalues='0' numberPrefix='$' showSum='0' decimals='0'>
 <categories>
  <category label='SAH' /> 
  </categories>
 <dataset color='AFD8F8' showValues='1'>
  <set value='$act_sth' /> 
  </dataset>
 <dataset color='F6BD0F' showValues='1'>
  <set value='$plan_sth' />  
  </dataset>
 <dataset color='8BBA00' showValues='1'>
  <set value='$total' /> 
  </dataset>
  <dataset color='E23AFF' showValues='1'>
  <set value='$full' /> 
  </dataset>
  </chart>";
  
   //To Write File
	$myFile = "linear_include.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "<?php echo \"".$message."\"; ?>";
	fwrite($fh, $stringData);
	fclose($fh);
	//To Write File
	
	// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../sah_monthly_status/hbullet1.php\"; }</script>";
?>