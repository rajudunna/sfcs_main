
<?php
//Ticket #809580 KiranG 20140604 Module number considered as integer where floating number is converted to integer as per OPU requirements.
$start_timestamp = microtime(true);
include('C:\xampp\htdocs\sfcs_main\sfcs_app\common\config\config_jobs.php');

//set_time_limit(50000);
set_time_limit(0);


// Turn off all error reporting
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);
?>
<?php

/* Connect to the local server using Windows Authentication and
specify the AdventureWorks database as the database in use. */

$serverName = "berwebsrv01";
/* Get UID and PWD from application-specific files.  */
$uid = "sa";
$pwd = "BAWR123";
$dbase="AutoMo";
$connectionInfo = array( "UID"=>$uid,
                         "PWD"=>$pwd,
                         "Database"=>$dbase,
						 'ReturnDatesAsStrings'=> true, 
						 "CharacterSet" => 'utf-8' );

/* Connect using SQL Server Authentication. */
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "Could not connect.\n";
     die( print_r( sqlsrv_errors(), true));
}

?>

<?php

$unit='BEK';

// if(isset($_GET['currentdate']))
// {
 	$max_allowed_date=date("Y-m-d");
// }
// else
// {
// 	$date=date("Y-m-d",strtotime("-1 day"));

// 	$sql="SELECT DISTINCT bac_date FROM bai_log_buf WHERE bac_date<\"".date("Y-m-d")."\" ORDER BY bac_date DESC LIMIT 1";
// 	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
// 	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
// 	while($sql_row=mysqli_fetch_array($sql_result))
// 	{
// 		$max_allowed_date=$sql_row['bac_date'];
// 	}
// }

$date=$max_allowed_date;
// echo $date;
$sdate=$date;
$edate=$date;

//New block create to flush data from the begginig of the month to till date  and refresh the data in SFCS - kiran 20150722
$sdate=date("Y-m")."-01";
$edate=$date;

$tsql="delete from  day_end_stat where Plant='".$unit."' and Date_1 between '$sdate' and '$edate'";
sqlsrv_query( $conn, $tsql);
$tsql="delete from  plant_basic_data where Plant='".$unit."' and Date_1 between '$sdate' and '$edate'";
sqlsrv_query( $conn, $tsql);


//$tsql="delete from bai_production_details_v1 where date between '$sdate' and '$edate'";
//sqlsrv_query( $conn, $tsql);


$sql="SELECT CONCAT(bac_date,'-',bac_no,'-',bac_shift) AS tid, ROUND(SUM((bac_qty*smv)/60),2) AS sah, sum(bac_Qty) as outp FROM bai_pro.bai_log_buf WHERE bac_date between \"$sdate\" and \"$edate\" GROUP BY CONCAT(bac_date,'-',bac_no,'-',bac_shift) ";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	
	$sql_new="update bai_pro.grand_rep set act_sth=".$sql_row['sah'].", act_out=".$sql_row['outp']." where tid='".$sql_row['tid']."'";
	mysqli_query($link, $sql_new) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
}
//New block create to flush data from the begginig of the month to till date  and refresh the data in SFCS - kiran 20150722


$sql="select date,round(sum(plan_out),0) as plan_out, round(sum(act_out),0) as act_out, SUBSTRING_INDEX(module,\".\",1) as module, left(styles,18) as styles,left(buyer,18) as buyer, round(sum(plan_clh),2) as plan_clh, round(sum(act_clh),2) as act_clh, round(sum(plan_sth),2) as plan_sth,  round(sum(act_sth),2) as act_sth, COALESCE(ROUND(SUM(act_sth)/SUM(act_clh)*100,2),0) AS act_eff, COALESCE(ROUND(SUM(plan_sth)/SUM(plan_clh)*100,2),0) AS plan_eff, SUM(rework_qty) AS rework_qty  from bai_pro.grand_rep where date between \"$sdate\" and \"$edate\" group by date";

//GROUP BY SUBSTRING_INDEX(module,\".\",1),DATE ORDER BY DATE,module
//echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
		
	$tsql="select * from  day_end_stat where Plant='".$unit."' and Date_1='$sql_row[date]'";
	
	if(sqlsrv_num_rows(sqlsrv_query( $conn, $tsql , array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET )))==0)
	{
		$tsql="insert into day_end_stat (Plant,Date_1,Output_1,SAH,Effi,Rework,Clock_Hours,Planned_ClockHours) values ('".$unit."','$sql_row[date]',$sql_row[act_out],$sql_row[act_sth],$sql_row[act_eff],$sql_row[rework_qty],$sql_row[act_clh],$sql_row[plan_clh]) ";
		$stmt = sqlsrv_query( $conn, $tsql);
	}	
	
	$tsql2="select * from  plant_basic_data where Plant='".$unit."' and DATE_1='$sql_row[date]'";
	
	if(sqlsrv_num_rows(sqlsrv_query( $conn, $tsql2 , array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET )))==0)
	{
		$tsql2="insert into plant_basic_data (Plant,DATE_1,P_SAH,P_OUT,P_EFFI) values ('".$unit."','$sql_row[date]',$sql_row[plan_sth],$sql_row[plan_out],$sql_row[plan_eff]) ";
		$stmt2 = sqlsrv_query( $conn, $tsql2);
	}	
	
}

//sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);


$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
echo "Execution took ".$duration." milliseconds.";
?>



</body>
</html>