<?php
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');	

set_time_limit(6000000);

$plantcode=$_SESSION['plantCode'];

//Getting from OMS regarding order information
$sql_oms="SELECT CONCAT(SUBSTR(omd.planned_delivery_date,-8,4),'-',SUBSTR(omd.planned_delivery_date,-4,2),'-',SUBSTR(omd.planned_delivery_date,-2,2)) AS Ex_Factory_New,
omd.customer_order_no ,omd.customer_order_line_no,omd.vpo,omd.cpo,omd.buyer_desc,omd.buyer_desc AS buyer_Division,opi.style,omd.schedule,opi.color_name,opi.size_name,opi.zfeature_name,
SUM(omd.mo_quantity) AS qty,omd.planned_delivery_date,omd.destination,omd.packing_method FROM 
$oms.oms_mo_details AS omd LEFT JOIN $oms.oms_products_info AS opi ON omd.mo_number=opi.mo_number where plant_code='".$plantcode."'
GROUP BY opi.style,omd.SCHEDULE,opi.color_name,opi.size_name,omd.planned_delivery_date,omd.destination";

$sql_oms_result=mysqli_query($link, $Getting) or exit("Error While getting information from OMS".mysqli_error($GLOBALS["___mysqli_ston"]));
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
	$week = $Ex_Factory_New->format("W");

	//Verifying the data weather already availble in Shipment
    $sql_check="select ssc_code_week_plan from $pps.shipment_plan where plant_code='".$plantcode."' and ssc_code_week_plan='".$Style_No.$Schedule_No.$Colour."-".$Size."-".$Ex_Factory."-".$Destination."'";
	$sql_check_res=mysqli_query($link, $sql_check) or exit("Checking weekly plan information".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_check_res)==0)
	{
		$sql_insert="INSERT INTO $pps.shipment_plan(plant_code,ssc_code_week_plan) value('".$plantcode."','".$Style_No.$Schedule_No.$Colour."-".$Size."-".$Ex_Factory."-".$Destination."')";
		mysqli_query($link, $sql_insert) or exit("Inserting weekly plan information".mysqli_error($GLOBALS["___mysqli_ston"]));
	}	
	//Updating data to the Shipment
	$update_sql="update $pps.shipment_plan set plant_code='".$plantcode."',order_no=\"".$sql_row["customer_order_no"]."\",delivery_no=\"".$sql_row["customer_order_no"]."\",del_status=\"".$sql_row["CO_Line_Scustomer_order_line_notatus"]."\",mpo=\"".$sql_row["vpo"]."\",cpo=\"".$cpo."\",buyer=\"".$buyer."\",product=\"".$product."\",buyer_division=\"".$division."\",style=\"".$style."\",schedule_no=\"".$sql_row["schedule"]."\",color=\"".$color."\",size=\"".$Size."\",z_feature=\"".$sql_row["zfeature_name"]."\",ord_qty='".$sql_row["qty"]."',ex_factory_date='".$Ex_Factory_New."',destination=\"".$Destination."\",packing_method=\"".$sql_row["packing_method"]."\",fob_price_per_piece=0,week_code='".$week."'ssc_code_new=\"".$Style_No.$Schedule_No.$Colour."\" where ssc_code_week_plan=\"".$Style_No.$Schedule_No.$Colour."-".$Size."-".$Ex_Factory."-".$Destination."\"";
	mysqli_query($link, $update_sql) or exit("Updating weekly plan information".mysqli_error($GLOBALS["___mysqli_ston"]));
}
	//Updating data to the Weekly delivery
	$sql_insert_week="INSERT INTO $pps.week_delivery_plan(shipment_plan_id,size_code,rev_exfactory,original_order_qty,act_exfact,plant_code) SELECT ship_tid,size,ex_factory_date,ord_qty,ex_factory_date,plant_code FROM $pps.shipment_plan where ship_tid not in (select shipment_plan_id from $pps.week_delivery_plan where plant_code='".$plantcode."')";
	$res=mysqli_query($link, $sql_insert_week) or exit("Inserted into week_delivery_plan table successfully".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($res){
		print("Inserted into week_delivery_plan table successfully");
	}

$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>
