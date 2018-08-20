<?php 
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
include($include_path.'\sfcs_app\common\config\m3_api_calls.php');
set_time_limit(1000000);

//details from config tool
$comapny_no=200;
$facility_id='Q01';


//getting mo numbers from mo_details table
$qry_modetails="SELECT DISTINCT(mo_no) AS mo_num,item_code,style,SCHEDULE,color,size,zfeature  FROM $bai_pro3.mo_details WHERE ops_master_status='0'";
$result_qry_modetails=mysqli_query($link, $qry_modetails) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($result_qry_modetails))
{
	echo "MO Number :".$sql_row['mo_num']."- Item Code : ".$sql_row['item_code']."- Style : ".$sql_row['style']."- Schedule : ".$sql_row['SCHEDULE']."- Color : ".$sql_row['color']."- Size : ".$sql_row['size']."- Zfeature : ".$sql_row['zfeature']."</br>";
	
	/*
	
	//sending api with parameters
	$url  = 'http://eka-mvxsod-01.brandixlk.org:22105//m3api-rest/execute/PMS100MI/SelOperations?CONO='.$comapny_no.'&FACI='.$facility_id.'&MFNO='.$sql_row['mo_num'].'&PRNO='.$sql_row['item_code'];	
	$url = str_replace(" ", '%20', $url);	
    $result = $obj->getCurlRequest($url);	
	$resultObj = json_decode($result);

	//getting request values 
	$operation_desc = $resultObj[0]->OPDS;
	$MONumber = $resultObj[0]->MFNO;
	$WorkCenterId = $resultObj[0]->PLG1;
	$SMV = $resultObj[0]->PITI;
	$operation_code = $resultObj[0]->OPNO;

	//getting values from MO details
	$Style=$sql_row['style'];
	$ScheduleNumber=$sql_row['SCHEDULE'];
	$ColorId=$sql_row['color'];
	$Description=$sql_row['color'];
	$SizeId=$sql_row['size'];
	$ZFeature=$sql_row['zfeature'];
	$ZFeatureId=$sql_row['zfeature'];




	//insertion query for schedule_oprations_master table
	$sql1="insert $bai_pro3.schedule_oprations_master(Style, ScheduleNumber, ColorId, Description, SizeId, ZFeature, ZFeatureId, MONumber,SMV, OperationDescription, OperationNumber,WorkCenterId,Main_OperationNumber,Main_WorkCenterId) values('".$Style."','".$ScheduleNumber."','".$ColorId."','".$Description."','".$SizeId."','".$ZFeature."','".$ZFeatureId."','".$MONumber."','".$SMV."','".$operation_code."','".$operation_code."','".$WorkCenterId."','".$operation_code."','".$WorkCenterId."')";

	*/

	// echo $sql1."<br>";
	//mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));


}


exit;

?>

