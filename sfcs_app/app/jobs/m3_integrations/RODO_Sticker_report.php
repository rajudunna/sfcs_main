<?php
$start_timestamp = microtime(true);
// $include_path=getenv('config_job_path');
// include($include_path.'\sfcs_app\common\config\config_jobs.php');
set_time_limit(6000000);
	include('mssql_conn.php');
	error_reporting(E_ALL & ~E_NOTICE);
	if($conn)
	{
		include('mysql_db_config.php');
		$curr_date = date(Ymd);
		$query_text = "CALL  BAISFCS.RPT_APL_SFCS_M3_INTEGRATION('BEL',200,'BAL','E54','".$curr_date."','".$curr_date."',0,'%','%','RODO')";
		$result = odbc_exec($conn, $query_text);
		while($row = odbc_fetch_array($result))
		{
			$j=0;
			$item_no = str_replace('"', '\"', $row['ITEM_NO']);
			$item_name = str_replace('"', '\"', $row['ITEM_NAME']);
			$item_des = str_replace('"', '\"', $row['ITEM_DESCRIPTION']);
			$invoice_no = str_replace('"', '\"', $row['INVOICE_NO']);
			$supp_name = str_replace('"', '\"', $row['SUPPLIER_NAME']);
			$po_ro = str_replace('"', '\"', $row['PO_RO_DO_NUMBER']);
			$po_line = str_replace('"', '\"', $row['PO_LINE_PRICE']);
			$po_tot_val = str_replace('"', '\"', $row['PO_TOTAL_VALUE']);
			$del_no = str_replace('"', '\"', $row['DELIVERY_NO']);
			$rec_qty = str_replace('"', '\"', $row['RECEIVED_QTY']);
			$umo = str_replace('"', '\"', $row['UOM']);
			$lot_num = str_replace('"', '\"', $row['LOT_NUMBER']);
			$batch_num = str_replace('"', '\"', $row['BATCH_NUMBER']);
			$grn_loc = str_replace('"', '\"', $row['GRN_LOCATION']);
			$buyer_buss_area = str_replace('"', '\"', $row['BUYER_BUSINESS_AREA']);
			$proc_grp = str_replace('"', '\"', $row['PROC_GROUP']);
			$grn_date = str_replace('"', '\"', $row['GRN_DATE']);
			$grn_entry_no = str_replace('"', '\"', $row['GRN_ENTRY_NO']);
			$style = str_replace('"', '\"', $row['STYLE']);
			$order_type = str_replace('"', '\"', $row['ORDER_TYPE']);
			$warehouse = str_replace('"', '\"', $row['WAREHOUSE']); 
	
			$sql_lot_rodo = "INSERT IGNORE INTO $bai_rm_pj1.sticker_report (lot_no) VALUES (\"".$lot_num."\")";
			$result_lot_rodo = mysqli_query($link, $sql_lot_rodo);
			$sql_sticker_det_rodo = "UPDATE $bai_rm_pj1.sticker_report SET item = \"".$item_no."\", item_name = \"".$item_name."\", item_desc = \"".$item_des."\", inv_no = \"".$invoice_no."\", po_no = \"".$po_ro."\", rec_no = \"".$del_no."\", rec_qty = \"".$rec_qty."\", lot_no = \"".$lot_num."\", batch_no = \"".$batch_num ."\", buyer = \"".$buyer_buss_area."\", product_group = \"".$proc_grp."\", pkg_no = '', grn_date = \"".$grn_date."\", supplier = \"".$supp_name."\", uom = \"".$umo."\", grn_location = \"".$grn_loc."\", po_line_price = \"".$po_line."\", po_total_cost = \"".$po_tot_val."\", style_no = \"".$style."\", grn_type = 'RODO'  WHERE lot_no = \"".$lot_num."\"";
			$result_rec_insert_rodo = mysqli_query($link, $sql_sticker_det_rodo);
			if($result_rec_insert_rodo ){
				$j++;
			}
		}
		if($j>0)
		{
			print("Updated $j Records in Sticker Report Successfully ")."\n";

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