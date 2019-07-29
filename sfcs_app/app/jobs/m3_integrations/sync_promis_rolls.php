<?php
error_reporting(0); 
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');

function get_lot_no($table_name,$field,$compare,$key,$link)
{
	$sql="select $field as result from $table_name where $compare=$key";
	$sql_result=mysqli_query($link, $sql) or exit("Fetching Lot Number".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		return $sql_row['result'];
	}
	((mysqli_free_result($sql_result) || (is_object($sql_result) && (get_class($sql_result) == "mysqli_result"))) ? true : false);
}

$conn = odbc_connect("$promis_sql_driver_name;Server=$promis_sql_odbc_server;Database=$promis_db;", $promis_sql_odbc_user,$promis_sql_odbc_pass);
if($conn)
{
	$get_details = "SELECT * FROM [$promis_db].[dbo].[ProMIS_SX_WH_Inventory] WHERE SFCS_Sync = 0 and Inspect_Approve = 1";
	$result = odbc_exec($connect, $get_details);
	while(odbc_fetch_row($result))
	{ 
		$id = odbc_result($result, 1);
		$rol_no = odbc_result($result, 11);
		$qty_rec = odbc_result($result, 12);
		$ctex_length = odbc_result($result, 46);
		$ticket_width = 0;
		$ctex_width = odbc_result($result, 47);
		$user_id = odbc_result($result, 23);
		$loc_id = odbc_result($result, 22);
		$shade = odbc_result($result, 22);
		$split_id = odbc_result($result, 54);
		$rol_remars = odbc_result($result, 37);
		$status = 0;
		$date=date('Y-m-d');
		$remarks='From Promis';
		$barcode=$facility_code."-".$id;
		$lot_no=0;
		$lot_no= get_lot_no("bai_rm_pj1.sticker_report","lot_no","po_subline=".odbc_result($result, 41)." and po_line",odbc_result($result, 40),$link);
		if($lot_no>0)
		{
			$sql="INSERT INTO `bai_rm_pj1`.`store_in`(`tid`, `lot_no`, `ref1`, `ref2`, `ref3`, `qty_rec`, `qty_issued`, `qty_ret`, `date`, `log_user`, `remarks`, `log_stamp`, `status`, `ref4`, `ref5`, `ref6`, `allotment_status`, `qty_allocated`, `roll_joins`, `roll_status`, `partial_appr_qty`, `upload_file`, `shrinkage_length`, `shrinkage_width`, `shrinkage_group`, `roll_remarks`, `rejection_reason`, `m3_call_status`, `split_roll`, `barcode_number`, `ref_tid`)
			VALUES (".$id.", '".$lot_no."', '', '".$loc_id."', '".$ctex_width."', '".$qty_rec."', '0.00', '0.00', '".$date."', '".$user_id."', 'Directly came ".$remarks."', '".date("Y-m-d H:i:s")."', '0', '".$shade."', '".$ctex_length."', '".$ticket_width."', '0', '0.00', '0', '0', '0.00', NULL, '0', '0', '0', '".$rol_remars."', '', 'N', '".$split_id."', '".$barcode."', '0')";
			$result_module = $link->query($sql);
			
			$update_query = "UPDATE [$promis_db].[dbo].[ProMIS_SX_WH_Inventory] SFCS_Sync = 1 WHERE ID = '".$id."'";
			odbc_exec($conn, $update_query);
		}		
	}
}
else
{
	print("Connection Failed")."\n";
}

$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.")."\n";

?>

