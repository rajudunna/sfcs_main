<?php 
$start_timestamp = microtime(true);

include('C:\xampp\htdocs\sfcs_main\sfcs_app\common\config\config_jobs.php');
set_time_limit(1000000);
/* Connect to the local server using Windows Authentication and
specify the AdventureWorks database as the database in use. */
// $serverName = "GD-SQL-UAT";
// /* Get UID and PWD from application-specific files.  */
// $uid = "SFCS_BIA_FF";
// $pwd = "Ba@rUpr6";
// $databasename="BELMasterUAT";
$connectionInfo = array( "DRIVER={SQL Server};","UID"=>$uid,"PWD"=>$pwd,"Database"=>$databasename);
?>

<?php
$connect = odbc_connect("Driver={SQL Server Native Client 11.0};Server=$serverName;Database=$databasename;", $uid,$pwd);
$schedule_from="400001";
$schedule_to="600000";
$default_operations=array("100","101","129","130");

$sql22="truncate table $bai_pro3.schedule_oprations_master_backup";
mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql21="insert into $bai_pro3.schedule_oprations_master_backup select * from $bai_pro3.schedule_oprations_master";
mysqli_query($link, $sql21) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql2="truncate table $bai_pro3.schedule_oprations_master";
mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

$tsql="SELECT 
[BELMasterUAT].[m3].[MO].Style,
[BELMasterUAT].[m3].[MOOperation].ScheduleNumber,
[BELMasterUAT].[m3].[StyleMaster].ColorId,
[BELMasterUAT].[m3].[ColorMaster].Description,
[BELMasterUAT].[m3].[StyleMaster].SizeId,
[BELMasterUAT].[m3].[StyleMaster].ZFeature,
[BELMasterUAT].[m3].[StyleMaster].ZFeatureId,
[BELMasterUAT].[m3].[MOOperation].MONumber,
[BELMasterUAT].[m3].[MOOperation].SMV,
[BELMasterUAT].[m3].[MOOperation].OperationDescription,
[BELMasterUAT].[m3].[MOOperation].OperationNumber,
[BELMasterUAT].[m3].[StyleMaster].SequenceNoForSorting,
[BELMasterUAT].[m3].[MOOperation].WorkCenterId,
[BELMasterUAT].[m3].[OperationMaster].OperationCode,
[BELMasterUAT].[m3].[OperationMaster].WorkCenterId
FROM [BELMasterUAT].[m3].[MOOperation]
FULL OUTER JOIN [BELMasterUAT].[m3].[OperationMaster] ON [BELMasterUAT].[m3].[OperationMaster].FactoryId=[BELMasterUAT].[m3].[MOOperation].FactoryId and [BELMasterUAT].[m3].[OperationMaster].WorkCenterId=[BELMasterUAT].[m3].[MOOperation].WorkCenterId 
INNER JOIN [BELMasterUAT].[m3].[MO] ON [BELMasterUAT].[m3].[MO].MONumber=[BELMasterUAT].[m3].[MOOperation].MONumber
INNER JOIN [BELMasterUAT].[m3].[StyleMaster] ON [BELMasterUAT].[m3].[StyleMaster].SKU=[BELMasterUAT].[m3].[MOOperation].SKU
INNER JOIN [BELMasterUAT].[m3].[ColorMaster] ON [BELMasterUAT].[m3].[ColorMaster].ColorId=[BELMasterUAT].[m3].[StyleMaster].ColorId
WHERE [BELMasterUAT].[m3].[MO].FactoryId='EKG' and [BELMasterUAT].[m3].[MOOperation].ScheduleNumber BETWEEN 400000 AND 500100
ORDER BY [BELMasterUAT].[m3].[StyleMaster].SequenceNoForSorting,[BELMasterUAT].[m3].[MOOperation].MONumber,[BELMasterUAT].[m3].[MOOperation].OperationNumber";
// echo $tsql."<br>";
$result = odbc_exec($connect, $tsql);
while(odbc_fetch_row($result))
{	
	 $Style=odbc_result($result,1);
	 $ScheduleNumber=odbc_result($result,2);
	 $ColorId=str_replace('"',"",odbc_result($result,3));
	 $Description=odbc_result($result,4);
	 $SizeId=odbc_result($result,5);
	 $ZFeature=odbc_result($result,6);
	 $ZFeatureId=odbc_result($result,7);
	 $MONumber=odbc_result($result,8);
	 $SMV=odbc_result($result,9);
	 $OperationDescription=odbc_result($result,10);
	 $OperationNumber=odbc_result($result,11);
	 $SequenceNoForSorting=odbc_result($result,12);
	 $Main_OperationNumber=odbc_result($result,14);
	 $WorkCenterId=odbc_result($result,13);
	 $Main_WorkCenterId=odbc_result($result,15);
	 //$sql41="select * from brandix_bts.tbl_style_ops_master where style='".$Style."' and schedule='".$ScheduleNumber."' and color='".$Description."' and operation_code='".$OperationNumber."'";
	 $sql41="select * from $brandix_bts.tbl_style_ops_master where style='".$Style."' and color='".$Description."' and operation_code='".$OperationNumber."'";
	//  echo $sql41."<br>";
	 $result41=mysqli_query($link, $sql41) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	 if(mysqli_num_rows($result41) == 0)
	 {
		 $sql21="select id from $brandix_bts.tbl_orders_ops_ref where operation_code=".$OperationNumber."";
		 $result21=mysqli_query($link, $sql21) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		//  echo "<BR>Rows=".mysqli_num_rows($result21);
		 if(mysqli_num_rows($result21) > 0)
		 {
			$resultd=mysqli_fetch_row($result21);
			
			$ops_sequence="0";
			$barcode_status="No";

			if(in_array($OperationNumber,$default_operations))
			{
				$ops_sequence="1";
				$barcode_status="Yes";
			}
		
			$sql1="insert $brandix_bts.tbl_style_ops_master(operation_name,operation_order,style, schedule, color, smv,m3_smv, operation_code,default_operration,priority,main_operationnumber,ops_sequence,barcode) values('".$resultd[0]."','".$OperationNumber."','".$Style."','".$ScheduleNumber."','".$Description."','".$SMV."','".$SMV."','".$OperationNumber."','Yes','".$OperationNumber."','".$Main_OperationNumber."','".$ops_sequence."','".$barcode_status."')";
			// echo "1=".$sql1."<br>";
			mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		 }
		 else
		 {
			$form="Panel Form";
			if($OperationNumber >= 130 && $OperationNumber <300)
			{
				$form="Garment Form";
			}
			$ops_sequence="0";
			$barcode_status="No";

			if(in_array($OperationNumber,$default_operations))
			{
				$ops_sequence="1";
				$barcode_status="Yes";
			}
			$sql3="insert into $brandix_bts.tbl_orders_ops_ref(operation_name,default_operation,operation_code,operation_description,type) values('".$OperationDescription."','Yes','".$OperationNumber."','".$OperationDescription."','".$form."')";
			mysqli_query($link, $sql3) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$LastId=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
			// echo "2=".$sql3."<br>";
			
			$sql4="insert $brandix_bts.tbl_style_ops_master(operation_name,operation_order,style, schedule, color, smv,m3_smv, operation_code,default_operration,priority,main_operationnumber,ops_sequence,barcode) values('".$LastId."','".$OperationNumber."','".$Style."','".$ScheduleNumber."','".$Description."','".$SMV."','".$SMV."','".$OperationNumber."','Yes','".$OperationNumber."','".$Main_OperationNumber."','".$ops_sequence."','".$barcode_status."')";
			// echo "3=".$sql4."<br>";
			mysqli_query($link, $sql4) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
		 }
	 }
	$sql1="insert $bai_pro3.schedule_oprations_master(Style, ScheduleNumber, ColorId, Description, SizeId, ZFeature, ZFeatureId, MONumber,SMV, OperationDescription, OperationNumber, SequenceNoForSorting,WorkCenterId,Main_OperationNumber,Main_WorkCenterId) values('".$Style."','".$ScheduleNumber."','".$ColorId."','".$Description."','".$SizeId."','".$ZFeature."','".$ZFeatureId."','".$MONumber."','".$SMV."','".$OperationDescription."','".$OperationNumber."','".$SequenceNoForSorting."','".$WorkCenterId."','".$Main_OperationNumber."','".$Main_WorkCenterId."')";
	// echo $sql1."<br>";
	mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
}
//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"ssc_porcess4.php\"; }</script>";
print( "Operations Successfully Integrated")."\n";
print( memory_get_usage())."\n";
	
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");

?>

