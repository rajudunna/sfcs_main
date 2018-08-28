<?php
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
set_time_limit(6000000);
    // include('mssql_conn.php');
    $conn = odbc_connect($conn_string,$user_ms,$password_ms);
	error_reporting(E_ALL & ~E_NOTICE);
    if($conn)
    {
     
		$from = date("Ymd", strtotime('-1 months'));
		$to = date("Ymd", strtotime('+5 months'));
		//$query_text2 = "CALL BAISFCS.RPT_APL_ORDER_DETAILS('BEL','EKG',NULL,NULL,'".$from."','".$to."','2')";
		$query_text2 = "CALL M3BRNPRD.RPT_APL_ORDER_DETAILS('BEL','EKG',NULL,NULL,'".$from."','".$to."','2')";
		$result2 = odbc_exec($conn, $query_text2);

		$trunc_order = "TRUNCATE TABLE $m3_inputs.order_details";
		$sql_trunc_order = mysqli_query($link, $trunc_order);
		$j=0;
		while($row = odbc_fetch_array($result2))
		{
			$facility = str_replace('"', '\"', $row['FACILITY']);
			$cust_style_no = str_replace('"', '\"', $row['CUSTOMER_STYLE_NO']);
			$cpo_no = str_replace('"', '\"', $row['CPO_NO']);
			$vpo_no = str_replace('"', '\"', $row['VPO NO']);
			$co_no = str_replace('"', '\"', $row['CO#']);
			$style = str_replace('"', '\"', $row['STYLE']);
			$schedule = str_replace('"', '\"', $row['SCHEDULE']);
			$mnf_sch_no = str_replace('"', '\"', $row['MANUFACTURING_SCHEDULE_NO']);
			$mo_split_method = str_replace('"', '\"', $row['MO_SPLIT_METHOD']);
			$mo_rel_stat = str_replace('"', '\"', $row['MO_RELESED_STATUS']);
			$gmt_clr = str_replace('"', '\"', $row['GMT_COLOR']);
			$gmt_size = str_replace('"', '\"', $row['GMT_SIZE']);
			$gmt_z_fet = str_replace('"', '\"', $row['GMT_Z_FEATURE']);
			$graphic_no = str_replace('"', '\"', $row['GRAPHIC_NO']);
			$co_qty = str_replace('"', '\"', $row['COQTY']);
			$mo_qty = str_replace('"', '\"', $row['MOQTY']);
			$pcd = str_replace('"', '\"', $row['PCD']);
			$plan_del_dt = str_replace('"', '\"', $row['PLAN_DELIVERY_DATE']);
			$dest = str_replace('"', '\"', $row['DESTINATION']);
			$pack_method = str_replace('"', '\"', $row['PACKING_METHOD']);
			$item_code = str_replace('"', '\"', $row['ITEM_CODE']);
			$item_desc = str_replace('"', '\"', $row['ITEM_DESCRIPTION']);
			$rm_clr_desc = str_replace('"', '\"', $row['RM_COLOR_DESCRIPTION']);
			$order_yy = str_replace('"', '\"', $row['ORDER_YY']);
			$wastage = str_replace('"', '\"', $row['WASTAGE']);
			$req_qty = str_replace('"', '\"', $row['REQUIRED_QTY']);
			$uom = str_replace('"', '\"', $row['UOM']);
			$a15_nxt = str_replace('"', '\"', $row['A15NEXT']);
			$a15 = str_replace('"', '\"', $row['A15']);
			$a20 = str_replace('"', '\"', $row['A20']);
			$a30 = str_replace('"', '\"', $row['A30']);
			$a40 = str_replace('"', '\"', $row['A40']);
			$a50 = str_replace('"', '\"', $row['A50']);
			$a60 = str_replace('"', '\"', $row['A60']);
			$a70 = str_replace('"', '\"', $row['A70']);
			$a75 = str_replace('"', '\"', $row['A75']);
			$a80 = str_replace('"', '\"', $row['A80']);
			$a90 = str_replace('"', '\"', $row['A90']);
			$a100 = str_replace('"', '\"', $row['A100']);
			$a110 = str_replace('"', '\"', $row['A110']);
			$a115 = str_replace('"', '\"', $row['A115']);
			$a120 = str_replace('"', '\"', $row['A120']);
			$a125 = str_replace('"', '\"', $row['A125']);
			$a130 = str_replace('"', '\"', $row['A130']);
			$a140 = str_replace('"', '\"', $row['A140']);
			$a143 = str_replace('"', '\"', $row['A143']);
			$a144 = str_replace('"', '\"', $row['A144']);
			$a147 = str_replace('"', '\"', $row['A147']);
			$a148 = str_replace('"', '\"', $row['A148']);
			$a150 = str_replace('"', '\"', $row['A150']);
			$a160 = str_replace('"', '\"', $row['A160']);
			$a170 = str_replace('"', '\"', $row['A170']);
			$a175 = str_replace('"', '\"', $row['A175']);
			$a180 = str_replace('"', '\"', $row['A180']);
			$a190 = str_replace('"', '\"', $row['A190']);
			$a200 = str_replace('"', '\"', $row['A200']);
			$mo_num = str_replace('"', '\"', $row['MO_NUMBER']);
			$seq_num = str_replace('"', '\"', $row['SEQ_NUMBER']);
			
			$sql_insert_order = "INSERT INTO $m3_inputs.order_details(Facility, Customer_Style_No, CPO_NO,  VPO_NO, CO_no, Style, Schedule, Manufacturing_Schedule_no, MO_Split_Method, MO_Released_Status_Y_N, GMT_Color, GMT_Size, GMT_Z_Feature, Graphic_Number, CO_Qty, MO_Qty, PCD, Plan_Delivery_Date, Destination, Packing_Method, Item_Code, Item_Description, RM_Color_Description, Order_YY_WO_Wastage, Wastage, Required_Qty, UOM, A15NEXT, A15, A20, A30, A40, A50, A60, A70, A75, A80, A90, A100, A110, A115, A120, A125, A130, A140, A143, A144, A147, A148, A150, A160, A170, A175, A180, A190, A200, MO_NUMBER, SEQ_NUMBER) VALUES (\"".$facility."\", \"".$cust_style_no."\", \"".$cpo_no."\", \"".$vpo_no."\", \"".$co_no."\", \"".$style."\", \"".$schedule."\", \"".$mnf_sch_no."\", \"".$mo_split_method."\", \"".$mo_rel_stat."\", \"".$gmt_clr."\", \"".$gmt_size."\", \"".$gmt_z_fet."\", \"".$graphic_no."\", \"".$co_qty."\", \"".$mo_qty."\", \"".$pcd."\", \"".$plan_del_dt."\", \"".$dest."\", \"".$pack_method."\", \"".$item_code."\", \"".$item_desc."\", \"".$rm_clr_desc."\", \"".$order_yy."\", \"".$wastage."\", \"".$req_qty."\", \"".$uom."\", \"".$a15_nxt."\", \"".$a15."\", \"".$a20."\", \"".$a30."\", \"".$a40."\", \"".$a50."\", \"".$a60."\", \"".$a70."\", \"".$a75."\", \"".$a80."\", \"".$a90."\", \"".$a100."\", \"".$a110."\", \"".$a115."\", \"".$a120."\", \"".$a125."\", \"".$a130."\", \"".$a140."\", \"".$a143."\", \"".$a144."\", \"".$a147."\", \"".$a148."\", \"".$a150."\", \"".$a160."\", \"".$a170."\", \"".$a175."\", \"".$a180."\", \"".$a190."\", \"".$a200."\", \"".$mo_num."\", \"".$seq_num."\");";
			$result_insert_order = mysqli_query($link, $sql_insert_order);
			if($result_insert_order )
			{
				$j++;
			}
		}
		if($j>0)
		{
			print("Inserted $j Records in Order Details  Successfully ")."\n";

		}
	}
	else
	{
		print("Connection Failed")."\n";
	}
	$end_timestamp = microtime(true);
	$duration = $end_timestamp - $start_timestamp;
	print("Execution took ".$duration." milliseconds.");
?>