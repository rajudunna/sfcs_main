<?php 
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
set_time_limit(1000000);

// $connect = odbc_connect("BAIDBSRV01", "sa","Brandix@7");
$connect = odbc_connect( $odbc_host, $odbc_user, $odbc_pass);
$styles_array=array();
$styles_array[]=-1;

$sql="SELECT DISTINCT order_style_no AS sch FROM $bai_pro3.bai_orders_db WHERE order_del_no > 0";
$result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($result))
{
	$styles_array[]=$sql_row["sch"];
}	

$default_operations=array("100","101","129","130");

$sql22="truncate table $bai_pro3.schedule_oprations_master_backup";
mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql21="insert into $bai_pro3.schedule_oprations_master_backup select * from $bai_pro3.schedule_oprations_master";
mysqli_query($link, $sql21) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql2="truncate table $bai_pro3.schedule_oprations_master";
mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$k=0;
for($i=0;$i<sizeof($styles_array);$i++)
{

$tsql="EXEC [M3_DB_LINK].[dbo].[OPRATION_DETAILS_GLOBAL] '".$styles_array[$i]."','".$plant_prod_code."'";
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
	 $OperationNumber=odbc_result($result,14);
	 $SequenceNoForSorting=odbc_result($result,12);
	 $Main_OperationNumber=odbc_result($result,11);
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
	$res=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($res )
	{
		$k++;
	}
}
}
	if($k>0)
	{
		print("Inserted $k Records in schedule_oprations_master  table Successfully ")."\n";

	}
//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"ssc_porcess4.php\"; }</script>";
print( "Operations Successfully Integrated")."\n";
print( memory_get_usage())."\n";
	
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");

?>

