<?php 
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
	
$connect = odbc_connect("$driver_name;Server=$serverName;Database=$m3_databasename;", $uid,$pwd);
?>

<?php
	$tsql="SELECT DeliveryMode FROM [$m3_databasename].[m3].[PlannedPurchaseOrder] where len(DeliveryMode) > 0  group by DeliveryMode order by DeliveryMode";
	$result = odbc_exec($connect, $tsql);
	while(odbc_fetch_row($result))
	{	
		$Transport_Mode=odbc_result($result,1);	 
		$sql41="select * from $bai_pro3.transport_modes where transport_mode='".$Transport_Mode."'";
		$result41=mysqli_query($link, $sql41) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($result41) == 0)
		{
			$sql1="insert $bai_pro3.transport_modes(transport_mode) values('".$Transport_Mode."')";
			mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}

print( memory_get_usage())."\n";
	
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>



