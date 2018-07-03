<?php
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');	

set_time_limit(6000000);
	
$sql="SELECT WEEK(CONCAT(SUBSTR(Ex_Factory,-8,4),\"-\",SUBSTR(Ex_Factory,-4,2),\"-\",SUBSTR(Ex_Factory,-2,2))) AS WEEK_NO,CONCAT(SUBSTR(Ex_Factory,-8,4),'-',SUBSTR(Ex_Factory,-4,2),'-',SUBSTR(Ex_Factory,-2,2)) AS Ex_Factory_New,Customer_Order_No AS A,CO_Line_Status,MPO,CPO,Buyer,Product,Buyer_Division,Style_No,Schedule_No,Colour,Size,ZFeature,SUM(Order_Qty) as qty,Ex_Factory,MODE,Destination,Packing_Method,FOB_Price_per_piece,CM_Value,EMB_A,EMB_B,EMB_C,EMB_D,EMB_E,EMB_F,EMB_G,EMB_H FROM $m3_inputs.shipment_plan WHERE schedule_no > 0 GROUP BY Style_No,Schedule_No,Colour,Size,Ex_Factory,Destination";
// echo $sql."<br>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$Style_No=str_pad($sql_row['Style_No'],"15"," ");
	$Schedule_No=$sql_row['Schedule_No'];		
	$Colour=str_pad($sql_row['Colour'],"30"," ");	
	$Size=$sql_row['Size'];	
	$Destination=$sql_row['Destination'];		
	$Ex_Factory=$sql_row['Ex_Factory'];		
	$Ex_Factory_New=$sql_row["Ex_Factory_New"];

	$sql1="INSERT IGNORE INTO $bai_pro4.shipment_plan(ssc_code_week_plan) value('".$Style_No.$Schedule_No.$Colour."-".$Size."-".$Ex_Factory."-".$Destination."')";
	// echo $sql1."<br><br>";
	mysqli_query($link, $sql1) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql2="update $bai_pro4.shipment_plan set order_no='".$sql_row["A"]."',delivery_no='".$sql_row["A"]."',del_status='".$sql_row["CO_Line_Status"]."',mpo='".$sql_row["MPO"]."',cpo='".$sql_row["CPO"]."',buyer='".$sql_row["Buyer"]."',product='".$sql_row["Product"]."',buyer_division=\"".$sql_row["Buyer_Division"]."\",style='".$sql_row["Style_No"]."',schedule_no='".$sql_row["Schedule_No"]."',color='".$sql_row["Colour"]."',size='".$sql_row["Size"]."',z_feature='".$sql_row["ZFeature"]."',ord_qty='".$sql_row["qty"]."',ex_factory_date='".$Ex_Factory_New."',MODE='".$sql_row["MODE"]."',destination='".$sql_row["Destination"]."',packing_method='".$sql_row["Packing_Method"]."',fob_price_per_piece='".$sql_row["FOB_Price_per_piece"]."',cm_value='".$sql_row["CM_Value"]."',week_code='".$sql_row["WEEK_NO"]."',order_embl_a='".$sql_row["EMB_A"]."',order_embl_b='".$sql_row["EMB_B"]."',order_embl_c='".$sql_row["EMB_C"]."',order_embl_d='".$sql_row["EMB_D"]."',order_embl_e='".$sql_row["EMB_E"]."',order_embl_f='".$sql_row["EMB_F"]."',order_embl_g='".$sql_row["EMB_G"]."',order_embl_h='".$sql_row["EMB_H"]."',ssc_code_new='".$Style_No.$Schedule_No.$Colour."' where ssc_code_week_plan='".$Style_No.$Schedule_No.$Colour."-".$Size."-".$Ex_Factory."-".$Destination."'";
	// echo $sql2."<br><br>";
	mysqli_query($link, $sql2) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
}

$sql4="INSERT INTO $bai_pro4.week_delivery_plan(shipment_plan_id,size_code,rev_exfactory,original_order_qty,act_exfact) SELECT ship_tid,size,ex_factory_date,ord_qty,ex_factory_date FROM $bai_pro4.shipment_plan where ship_tid not in (select shipment_plan_id from $bai_pro4.week_delivery_plan)";
// echo $sql4."<br><br>";
$res=mysqli_query($link, $sql4) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
if($res){
	print("Inserted into week_delivery_plan table successfully");
}

$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>
<!-- <script language="javascript"> setTimeout("CloseWindow()",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script> -->