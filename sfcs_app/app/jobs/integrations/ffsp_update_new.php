<?php
error_reporting(0);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
include($include_path.'\sfcs_app\common\config\rest_api_calls.php');
include('../../../common/config/config.php');
if($_GET['plantCode']){
    $plant_code = $_GET['plantCode'];
}else{
    $plant_code = $argv[1];
}
$username = $_SESSION['userName'];

$store_data = [];
$get_details="select schedule,style,color_desc as color from $oms.oms_mo_details LEFT JOIN $oms.`oms_products_info` ON oms_products_info.`mo_number`= oms_mo_details.`mo_number` where plant_code='$plant_code' group by schedule,style,color_desc";
$result=mysqli_query($link, $get_details) or exit("error at getting style and shedule and color details".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row = mysqli_fetch_array($result))
{
    $details = [];
    $details['style'] = $row['style'];
    $details['schedule'] = $row['schedule'];
    $details['color'] = $row['color'];
    array_push($store_data,$details);
}

$count=0;
//looping the data to send it in API
foreach($store_data as $data){
    $url  = $rm_dashboard_api.'api/ScheduleStatus?style='.$data['style'].'&schedule='.$data['schedule'].'&color='.$data['color'];	
	$url = str_replace(" ", '%20', $url);	
	$start_timestamp = microtime(true);
    $result = $obj->getCurlRequest($url);	
    $resultObj = json_decode($result);
	$end_timestamp = microtime(true);
	$duration = $end_timestamp - $start_timestamp;
	print("Execution took ".$duration." milliseconds.")."<br/>";
	
	$style = $data['style'];
	$schedule = $data['schedule'];
	$color = $data['color'];
	
	$fabHigherStatus = $resultObj[0]->FabHigherStatus;
	$sTRIMHigherStatus = $resultObj[0]->STRIMHigherStatus;
	$pTRIMHigherStatus = $resultObj[0]->PTRIMHigherStatus;
		
	$ft_status=null;
    if(in_array($fabHigherStatus,array(10,11,13)))
    {
        $ft_status=1;
    }
    else
    {
        $ft_status=0;
    }
    
    $st_status=null;
    if(in_array($sTRIMHigherStatus,array(10,11,13)))
    {
        $st_status=1;
    }
    else
    {
        $st_status=0;
    }
    
    $pt_status=null;
    if(in_array($pTRIMHigherStatus,array(10,11,13)))
    {
        $pt_status=1;
    }
    else
    {
        $pt_status=0;
    }    
   
    $ft_query="select * from $wms.trims_status where style=\"$style\" and schedule=\"$schedule\" and color='$color' and plant_code=\"$plant_code\" and status_key='FT STATUS'";
    $ft_result=mysqli_query($link, $ft_query) or exit("Sql Error3".$ft_query."".mysqli_error($GLOBALS["___mysqli_ston"]));
    if(mysqli_num_rows($ft_result)>0){
        $ft_update="update $wms.trims_status set status_key='FT STATUS',status_value='$ft_status' where style=\"$style\" and schedule=\"$schedule\" and color='$color' and plant_code=\"$plant_code\" and status_key='FT STATUS'";
        $ft_update_result=mysqli_query($link,$ft_update)or exit("Error updating bai_order_db".mysqli_error($GLOBALS["___mysqli_ston"])); 
        if($ft_update_result>0)
        {
            print("Updated FT STATUS for trims_status Sucessfully")."<br/>";
        }
    } else{
        $ft_insert="insert into $wms.trims_status (style,schedule,color,status_key,status_value,plant_code,created_at,created_user,updated_at,updated_user) VALUES ('".$style."','$schedule','$color','FT STATUS','$ft_status','$plant_code',NOW(),'$username',NOW(),'$username')";
        $ft_insert_result = mysqli_query($link, $ft_insert) or exit("Sql Errore".mysqli_error($GLOBALS["___mysqli_ston"]));
        if($ft_insert_result>0)
        {
            print("Inserted FT STATUS for trims_status Sucessfully")."<br/>";
        }
    }

    $st_query="select * from $wms.trims_status where style=\"$style\" and schedule=\"$schedule\" and color='$color' and plant_code=\"$plant_code\" and status_key='ST STATUS'";
    $st_result=mysqli_query($link, $st_query) or exit("Sql Error3".$st_query."".mysqli_error($GLOBALS["___mysqli_ston"]));
    if(mysqli_num_rows($st_result)>0){
        $st_update="update $wms.trims_status set status_key='ST STATUS',status_value='$st_status' where style=\"$style\" and schedule=\"$schedule\" and color='$color' and plant_code=\"$plant_code\" and status_key='ST STATUS'";
        $st_update_result=mysqli_query($link,$st_update)or exit("Error updating bai_order_db".mysqli_error($GLOBALS["___mysqli_ston"])); 
        if($st_update_result>0)
        {
            print("Updated ST STATUS for trims_status Sucessfully")."<br/>";
        }
    } else{
        $st_insert="insert into $wms.trims_status (style,schedule,color,status_key,status_value,plant_code,created_at,created_user,updated_at,updated_user) VALUES ('".$style."','$schedule','$color','ST STATUS','$st_status','$plant_code',NOW(),'$username',NOW(),'$username')";
        $st_insert_result = mysqli_query($link, $st_insert) or exit("Sql Errore".mysqli_error($GLOBALS["___mysqli_ston"]));
        if($st_insert_result>0)
        {
            print("Inserted ST STATUS for trims_status Sucessfully")."<br/>";
        }
    }

    $pt_query="select * from $wms.trims_status where style=\"$style\" and schedule=\"$schedule\" and color='$color' and plant_code=\"$plant_code\" and status_key='PT STATUS'";
    $pt_result=mysqli_query($link, $pt_query) or exit("Sql Error3".$pt_query."".mysqli_error($GLOBALS["___mysqli_ston"]));
    if(mysqli_num_rows($pt_result)>0){
        $pt_update="update $wms.trims_status set status_key='PT STATUS',status_value='$pt_status' where style=\"$style\" and schedule=\"$schedule\" and color='$color' and plant_code=\"$plant_code\" and status_key='PT STATUS'";
        $pt_update_result=mysqli_query($link,$pt_update)or exit("Error updating bai_order_db".mysqli_error($GLOBALS["___mysqli_ston"])); 
        if($pt_update_result>0)
        {
            print("Updated PT STATUS for trims_status Sucessfully")."<br/>";
        }
    } else{
        $pt_insert="insert into $wms.trims_status (style,schedule,color,status_key,status_value,plant_code,created_at,created_user,updated_at,updated_user) VALUES ('".$style."','$schedule','$color','PT STATUS','$pt_status','$plant_code',NOW(),'$username',NOW(),'$username')";
        $pt_insert_result = mysqli_query($link, $pt_insert) or exit("Sql Errore".mysqli_error($GLOBALS["___mysqli_ston"]));
        if($st_insert_result>0)
        {
            print("Inserted PT STATUS for trims_status Sucessfully")."<br/>";
        }
    }
    $count++;
}
print("Total Records :".$count)."\n";
?>