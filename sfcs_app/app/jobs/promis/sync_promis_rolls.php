<?php
error_reporting(0); 
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
if($_GET['plantCode']){
	$plant_code = $_GET['plantCode'];
}else{
	$plant_code = $argv[1];
}
$username = $_SESSION['userName'];
function get_lot_no($table_name,$field,$compare,$key,$link,$plant_code)
{
	$sql="select $field as result from $table_name where $compare=$key and plant_code= '$plant_code'";
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
	$get_details = "SELECT id,Roll_Number,Qty,CTex_Length,CTex_Width,User_ID,Loc_ID,CPL,Split_ID,Ins_Clr_HDR_Comment,PO_Number,PO_SubLine,PO_Line,GRNNo FROM 
	[$promis_db].[dbo].[ProMIS_SX_WH_Inventory] WHERE SFCS_Sync = 0 and Inspect_Approve = 1 and PO_Line >= 0 and PO_SubLine >= 0";
	$sql_result1 = odbc_exec($conn, $get_details);
	while(odbc_fetch_row($sql_result1))
	{ 
		$id = odbc_result($sql_result1,'id'); 
		$rol_no = odbc_result($sql_result1,'Roll_Number');
		$qty_rec = odbc_result($sql_result1,'Qty');
		$ctex_length = odbc_result($sql_result1,'CTex_Length');
		$ctex_width = odbc_result($sql_result1,'CTex_Width');
		$user_id = odbc_result($sql_result1,'User_ID');
		$loc_id = odbc_result($sql_result1,'Loc_ID');
		$shade = odbc_result($sql_result1,'CPL');
		$split_id = odbc_result($sql_result1,'Split_ID');
		$rol_remars = odbc_result($sql_result1,'Ins_Clr_HDR_Comment');
		$po_number = odbc_result($sql_result1,'PO_Number');
		$po_subline = odbc_result($sql_result1,'PO_SubLine');
		$po_line = odbc_result($sql_result1,'PO_Line');
		$rec_no = odbc_result($sql_result1,'GRNNo');
		$ticket_width = 0;
		$status = 0;
		$date=date('Y-m-d');
		$remarks='From Promis';
		$barcode=$id;
		$lot_no= get_lot_no("$wms.sticker_report","lot_no","po_no='".$po_number."' and rec_no='".$rec_no."' and po_subline=".$po_subline." and po_line",$po_line,$link,$plant_code);
		if($lot_no>0)
		{
			$sql="INSERT INTO `$wms`.`store_in`(`ref_tid`, `lot_no`, `ref1`, `ref2`, `ref3`, `qty_rec`, `qty_issued`, `qty_ret`, `date`, `log_user`, `remarks`, `log_stamp`, `status`, `ref4`, `ref5`, `ref6`, `allotment_status`, `qty_allocated`, `roll_joins`, `roll_status`, `partial_appr_qty`, `upload_file`, `shrinkage_length`, `shrinkage_width`, `shrinkage_group`, `roll_remarks`, `rejection_reason`, `m3_call_status`, `split_roll`, `barcode_number`,,plant_code,created_user,updated_user,updated_at) VALUES (".$id.", '".$lot_no."', '".$loc_id."', '".$rol_no."', '".$ctex_width."', '".$qty_rec."', '0.00', '0.00', '".$date."', '".$user_id."', 'Directly came ".$remarks."', '".date("Y-m-d H:i:s")."', '0', '".$shade."', '".$ctex_length."', '".$ticket_width."', '0', '0.00', '0', '0', '0.00', NULL, '0', '0', '0', '".$rol_remars."', '', 'N', '".$split_id."', '".$barcode."','".$plant_code."','".$username."','".$username."',NOW())";
			$result_value = mysqli_query($link,$sql);
			if($result_value)
			{
				$update_query = "UPDATE [$promis_db].[dbo].[ProMIS_SX_WH_Inventory] set SFCS_Sync = 1 WHERE ID = '".$id."'";
				odbc_exec($conn, $update_query);
			}
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

