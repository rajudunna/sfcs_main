<?php

set_time_limit(100000000000);
include"header.php";
echo "Hi";

$message="<chart canvasBgColor='F1F1FF, FFFFFF'  canvasBgAngle='90' dateFormat='dd/mm/yyyy' outputDateFormat='hh12:mn ampm' ganttLineColor='0372AB' ganttLineAlpha='8' gridBorderColor='0372AB' canvasBorderColor='0372AB' showShadow='0'>
 <categories bgColor='0372AB'>
		<category start='00:00:00' end='23:59:59' name='Modules Live Status' fontColor='FFFFFF' />
</categories>
<categories bgAlpha='0'>
		<category start='00:00:00' end='23:59:59' name='Hours' />
</categories>
<processes isBold='1' headerbgColor='0372AB' fontColor='0372AB' bgColor='FFFFFF' > ";

$sql="select distinct(bac_no) as module from bai_log where bac_sec=\"1\" and bac_date=\"2011-01-18\" order by bac_no";
$result=mysqli_query($con, $sql) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row=mysqli_fetch_array($result))
{
	$message.="<process Name='Machine ".$row["module"]."' id='".$row["module"]."'  />";
}
 
$message.="</processes>
<tasks >";

$sql2="select distinct(bac_no) as module from bai_log where bac_sec=\"1\" and bac_date=\"2011-01-18\" order by bac_no";
$result2=mysqli_query($con, $sql2) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row2=mysqli_fetch_array($result2))
{
	$module=$row2["module"];
	$sql3="SELECT SUBSTRING_INDEX(TIME(bac_lastup),':',1) AS timer,bac_stat,bac_date,bac_no FROM bai_log WHERE bac_stat!=\"Active\" AND bac_date=\"2011-01-18\" and bac_no=\"".$module."\" GROUP BY bac_no,TIME(bac_lastup)";
	echo $sql3."<br>";
	$result3=mysqli_query($con, $sql3) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row3=mysqli_fetch_array($result3))
	{
		$time=$row3["timer"];
		$time1=$time+1;
		$message.="<task name='In Use' processId='".$module."' start='".$time.":00:00' end='".$time1.":00:00'  taskId='B' borderColor='FF654F' color='FF654F' />";		//echo "task name='In Use' processId='".$module."' start='".$time.":00:00' end='".$time1.":00:00'  taskId='B' borderColor='FF654F' color='FF654F'"."-".$time."-".$time1."<br>";
	}
		
}

$message.="</tasks>
<connectors>
		<connector fromTaskId='2' toTaskId='1'  color='' alpha='' thickness='' isDotted='' />
</connectors>

<legend>
	<item label='In use' color='FF654F' />
	<item label='Repair' color='F6BD0F' />
	<item label='Idle' color='8BBA00' />
</legend>

</chart>"; 

$myFile = "module_live_status_include.php";
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = "<?php echo \" ".$message."\"; ?>";
fwrite($fh, $stringData);
fclose($fh);

?>