<?php
$start_timestamp = microtime(true);

include("header_sch.php");

$sql=mysqli_query($GLOBALS["___mysqli_ston"], "select MAX(DATE) as date FROM bai_pro.grand_rep where date <=\"$dat_tmp\" and max_out > 0");
while($row=mysqli_fetch_array($sql))
{
	$date_new=$row["date"];
}

$sql2=mysqli_query($GLOBALS["___mysqli_ston"], "select SUM(plan_clh),SUM(act_clh),SUM(plan_sth),SUM(act_sth) FROM bai_pro.grand_rep WHERE DATE=\"$date_new\"");
while($row2=mysqli_fetch_array($sql2))
{
	$plan_sth=round($row2["SUM(plan_sth)"],0);
	$plan_clh=round($row2["SUM(plan_clh)"],0);
	$act_sth=round($row2["SUM(act_sth)"],0);
	$act_clh=round($row2["SUM(act_clh)"],0);
}
if($plan_clh>0){
$plan_eff=round($plan_sth*100/$plan_clh,0);
}
if($act_clh>0){
$act_eff=round(($act_sth/$act_clh)*100,0);
   
}

//<dial id='CPU1' value='$plan_eff' rearExtension='10' bgcolor='ff0000' valueY='120' />
$message = "<chart lowerLimit='0' upperLimit='100' gaugeStartAngle='180' gaugeEndAngle='0' palette='1' numberSuffix='%' tickValueDistance='20' showValue='1' decimals='0' dataStreamURL='CPUData.asp' refreshInterval='3' preSuffix='%'>
   <colorRange>
      <color minValue='0' maxValue='50' code='FF654F'/>
      <color minValue='50' maxValue='75' code='F6BD0F'/>		
      <color minValue='75' maxValue='100' code='8BBA00'/>
   </colorRange>
   <dials>
      
	  <dial id='CPU1' value='$act_eff' rearExtension='15' bgcolor='33ff00' valueY='150'/>
   </dials>
   <styles>
      <definition>
         <style type='font' name='myValueFont' bgColor='ffffff' borderColor='999999' />
      </definition>
      <application>
         <apply toObject='Value' styles='myValueFont' />
      </application>
   </styles>
</chart>";

//To Write File
	$myFile = "Eff_guage_include.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "<?php echo \" ".$message."\"; ?>";
	fwrite($fh, $stringData);
	fclose($fh);
	//To Write File
// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../manpower_absenteeism/manpower_absenteeism.php\"; }</script>";
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>
