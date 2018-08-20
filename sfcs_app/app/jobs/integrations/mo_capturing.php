<?php 
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
set_time_limit(6000000);
							
$sql="SELECT MO_NUMBER,MO_Qty,Style,SCHEDULE,GMT_Color,GMT_Size,Destination,GMT_Z_Feature,Item_Code FROM $m3_inputs.order_details WHERE MO_Released_Status_Y_N='Y' AND mo_number > 0 GROUP BY MO_NUMBER,Style,SCHEDULE,GMT_Color,GMT_Size,Destination,GMT_Z_Feature,Item_Code ORDER BY MO_NUMBER*1,MO_Qty,Style,SCHEDULE,GMT_Color,GMT_Size,Destination,GMT_Z_Feature,Item_Code";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$MO_NUMBER=$sql_row['MO_NUMBER'];
	$MO_Qty=$sql_row['MO_Qty'];
	$Style=$sql_row['Style'];
	$SCHEDULE=$sql_row['SCHEDULE'];
	$GMT_Color=$sql_row['GMT_Color'];
	$GMT_Size=$sql_row['GMT_Size'];
	$Destination=$sql_row['Destination'];
	$GMT_Z_Feature=$sql_row['GMT_Z_Feature'];
	$Item_Code=$sql_row['Item_Code'];
	
	$insert_mos="insert ignore into $bai_pro3.mo_details(date_time,mo_no,mo_quantity,style,schedule,color,size,destination,zfeature,item_code) values('".date("Y-m-d H:i:s")."','".$MO_NUMBER."','".$MO_Qty."','".$Style."','".$SCHEDULE."','".$GMT_Color."','".$GMT_Size."','".$Destination."','".$GMT_Z_Feature."','".$Item_Code."')";
	mysqli_query($link, $insert_mos) or exit("insert_mos=$insert_mos".mysqli_error($GLOBALS["___mysqli_ston"]));
}

// echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";		
?>


	