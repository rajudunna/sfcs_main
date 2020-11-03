<?php
error_reporting(E_ALL & ~E_NOTICE);
$start_timestamp = microtime(true);

set_time_limit(6000000);
$include_path=getenv('config_job_path');
// $include_path='C:\xampp\htdocs\sfcs_main';
include($include_path.'\sfcs_app\common\config\config_jobs.php');
// var_dump($shifts_array);
if(isset($_GET['plantCode']))
{
	$plant_Code= $_GET['plantCode']; 
	$username= $_GET['username']; 
}
else
{
	$plant_Code = $_SESSION['plantCode'];
	$username = $_SESSION['userName'];
}
//Getting from OMS regarding order information
$sql_oms="SELECT CONCAT(SUBSTR(omd.planned_delivery_date,-8,4),'-',SUBSTR(omd.planned_delivery_date,-4,2),'-',SUBSTR(omd.planned_delivery_date,-2,2)) AS Ex_Factory_New,
omd.customer_order_no ,omd.customer_order_line_no,omd.vpo,omd.cpo,omd.buyer_desc,omd.buyer_desc AS buyer_Division,opi.style,omd.schedule,opi.color_name,opi.size_name,opi.zfeature_name,
SUM(omd.mo_quantity) AS qty,omd.planned_delivery_date,omd.destination,omd.packing_method FROM 
$oms.oms_mo_details AS omd LEFT JOIN $oms.oms_products_info AS opi ON omd.mo_number=opi.mo_number where plant_code='".$plant_Code."' GROUP BY opi.style,omd.SCHEDULE,opi.color_name,opi.size_name,omd.planned_delivery_date,omd.destination";
$sql_oms_result=mysqli_query($link, $sql_oms) or exit("Error While getting information from OMS".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_oms_result))
{
	$Style_No=$sql_row['style'];
	$Schedule_No=$sql_row['schedule'];		
	$Colour=$sql_row['color_name'];	
	$Size=$sql_row['size_name'];	
	$Destination=$sql_row['destination'];		
	$Ex_Factory=$sql_row['planned_delivery_date'];		
	$Ex_Factory_New=$sql_row["Ex_Factory_New"];
	$cpo=$sql_row["cpo"];
	$color=$sql_row["color_name"];
	$division=$sql_row["buyer_Division"];
	$buyer=$sql_row["buyer"];
	$product="";
	$style=$sql_row["style"];
	$to_get_week = new DateTime($Ex_Factory_New);
	$week = $to_get_week->format("W");

	//Verifying the data weather already availble in Shipment
	$sql_check="select ssc_code_week_plan from $pps.shipment_plan where plant_code='".$plant_Code."' and ssc_code_week_plan='".$Style_No.$Schedule_No.$Colour."-".$Size."-".$Ex_Factory."-".$Destination."'";
	$sql_check_res=mysqli_query($link, $sql_check) or exit("Checking weekly plan information".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_check_res)==0)
	{
		$sql_insert="INSERT INTO $pps.shipment_plan(cm_value,fob_price_per_piece,created_at,created_user,plant_code,ssc_code_week_plan,updated_at) value(0,0,\"".date('Y-m-d')."\",'".$username."','".$plant_Code."','".$Style_No.$Schedule_No.$Colour."-".$Size."-".$Ex_Factory."-".$Destination."',\"".date('Y-m-d')."\")";
		mysqli_query($link, $sql_insert) or exit("Inserting shipment_plan information".mysqli_error($GLOBALS["___mysqli_ston"]));
	}	
	//Updating data to the Shipment
	$update_sql="update $pps.shipment_plan set updated_at='".date('Y-m-d')."',updated_user='".$username."',plant_code='".$plant_Code."',order_no=\"".$sql_row["customer_order_no"]."\",delivery_no=\"".$sql_row["customer_order_no"]."\",del_status=\"".$sql_row["CO_Line_Scustomer_order_line_notatus"]."\",mpo=\"".$sql_row["vpo"]."\",cpo=\"".$cpo."\",buyer=\"".$buyer."\",product=\"".$product."\",buyer_division=\"".$division."\",style=\"".$style."\",schedule_no=\"".$sql_row["schedule"]."\",color=\"".$color."\",size=\"".$Size."\",z_feature=\"".$sql_row["zfeature_name"]."\",ord_qty='".$sql_row["qty"]."',ex_factory_date='".$Ex_Factory_New."',destination=\"".$Destination."\",packing_method=\"".$sql_row["packing_method"]."\",fob_price_per_piece=0,week_code='".$week."',ssc_code_new=\"".$Style_No.$Schedule_No.$Colour."\" where ssc_code_week_plan=\"".$Style_No.$Schedule_No.$Colour."-".$Size."-".$Ex_Factory."-".$Destination."\" and plant_code='".$plant_Code."'";
	mysqli_query($link, $update_sql) or exit("Updating shipment_plan information".mysqli_error($GLOBALS["___mysqli_ston"]));
	
}
	//Updating data to the Weekly delivery
	$sql_insert_week="INSERT INTO $pps.week_delivery_plan(shipment_plan_id,size_code,rev_exfactory,original_order_qty,act_exfact,plant_code,created_user,created_at,updated_at,remarks) SELECT ship_tid,size,ex_factory_date,ord_qty,ex_factory_date,plant_code,'".$username."',\"".date('Y-m-d')."\",\"".date('Y-m-d')."\",'No Remarks' FROM $pps.shipment_plan where ship_tid not in (select shipment_plan_id from $pps.week_delivery_plan where plant_code='".$plant_Code."')";
	$res=mysqli_query($link, $sql_insert_week) or exit("Inserted into week_delivery_plan table successfully".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($res){
		print("Inserted into week_delivery_plan table successfully");
	}

$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>
