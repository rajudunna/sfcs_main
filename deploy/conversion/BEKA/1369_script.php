
<?php
echo "Started<br/>";
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/mo_filling.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/m3Updations.php');

$dockets = [397,398,399,413,414,415,1549,1550,1551,1552,1553];
$reported_status = '';	
$op_code = 15;

echo "Inserting<br/>";
foreach($dockets as $doc){
    $function = doc_size_wise_bundle_insertion($doc);
}

echo "Updating<br/>";
foreach($dockets as $doc){
	$qry_cut_qty_check_qry = "SELECT * FROM bai_pro3.plandoc_stat_log WHERE doc_no = $doc";
	$result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
	while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
	{
		$org_doc_no = $row['org_doc_no'];
		$order_tid = $row['order_tid'];
		$act_cut_status = $row['act_cut_status'];
		$p_plies = $row['p_plies'];
		$a_plies = $row['a_plies'];	
		if($p_plies == $a_plies){
			$reported_status = 'F';			
		}else{
			$reported_status = 'P';
		}	
		if($act_cut_status=='')
			$reported_status = '';

		for ($i=0; $i < sizeof($sizes_array); $i++)
		{ 
			if ($row['a_'.$sizes_array[$i]] > 0)
			{
				$cut_done_qty[$sizes_array[$i]] = $row['a_'.$sizes_array[$i]] * $row['a_plies'];
			}
		}
		
	}
	foreach($cut_done_qty as $key => $value)
	{
		$update_query = "UPDATE bai_pro3.cps_log set remaining_qty = remaining_qty+$value,reported_status='$reported_status' where doc_no = $doc and size_code = '$key' 
						and operation_code = $op_code";
		mysqli_query($link,$update_query) or exit('Updating CPS Error');

		$update_bcd_query = "UPDATE brandix_bts.bundle_creation_data 
        set recevied_qty = recevied_qty+$value WHERE docket_number = $doc AND size_id = '$key' AND operation_id = $op_code ";
		mysqli_query($link,$update_bcd_query) or exit('Updating BCD Error');

		$bundle_no_query = "SELECT bundle_number from brandix_bts.bundle_creation_data WHERE docket_number = $doc AND size_id = '$key' AND operation_id = $op_code ";
		$bundle_result = mysqli_query($link,$bundle_no_query) or exit('No Bundles Found');

		while($rowb = mysqli_fetch_array($bundle_result))	
			$bundle_no = $rowb['bundle_number'];				
		$updation_m3 = updateM3Transactions($bundle_no,$op_code,$value);
	}
}
echo "DONE";



?>