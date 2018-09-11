<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'], "common/config/config.php", 4, 'R')); 
//include("../../../../common/config/config_ajax.php");
$doc_no_ref = $_GET['doc_no_ref'];
// $doc_no_ref = 1336;
$go_back_to = $_GET['go_back_to'];
$bundle_no = array();
$cut_done_qty = array();
$qry_to_find_in_out = "select * from $brandix_bts.bundle_creation_data where docket_number='$doc_no_ref'";
// echo $qry_to_find_in_out;
$qry_to_find_in_out_result = $link->query($qry_to_find_in_out);
error_reporting(0);
if(mysqli_num_rows($qry_to_find_in_out_result) > 0)
{
	$plies = $_GET['plies'];
	$qry_cut_qty_check_qry = "SELECT * FROM $bai_pro3.plandoc_stat_log WHERE doc_no = '$doc_no_ref' ";
	$result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
	while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
	{
		// $doc_array[$row['doc_no']] = $row['act_cut_status'];
		for ($i=0; $i < sizeof($sizes_array); $i++)
		{ 
			if ($row['a_'.$sizes_array[$i]] > 0)
			{
				$cut_done_qty[$sizes_array[$i]] = $row['a_'.$sizes_array[$i]] * $plies;
			}
		}
	}
	$rec_qty =0 ;
	$left_over_qty = 0;
	foreach ($cut_done_qty as $key => $value)
	{
		//updating cut qty into bundle_creation_data and cps log
		$selecting_qry = "SELECT * FROM $brandix_bts.bundle_creation_data WHERE docket_number = '$doc_no_ref' AND size_id = '$key' AND operation_id = '15'";
		$result_selecting_qry = $link->query($selecting_qry);
		while($row_result_selecting_qry = $result_selecting_qry->fetch_assoc()) 
		{
			$id_to_update = $row_result_selecting_qry['id'];
		}
		$update_qry = "update $brandix_bts.bundle_creation_data set recevied_qty = recevied_qty+$value where id = $id_to_update";
		$updating_bundle_data = mysqli_query($link,$update_qry) or exit("While updating budle_creation_data".mysqli_error($GLOBALS["___mysqli_ston"]));
		//updating cut qty into  cps log
		$selecting_cps_qry = "SELECT * FROM $bai_pro3.cps_log WHERE `doc_no`='$doc_no_ref' AND `size_code`=  '$key' AND operation_code = '15'";
		$result_selecting_cps_qry = $link->query($selecting_cps_qry);
		while($row_result_selecting_cps_qry = $result_selecting_cps_qry->fetch_assoc()) 
		{
			$id_to_update_cps = $row_result_selecting_cps_qry['id'];
		}
		$update_qry_cps = "update $bai_pro3.cps_log set remaining_qty = remaining_qty+$value where id = $id_to_update_cps";
		$updating_cps = mysqli_query($link,$update_qry_cps) or exit("While updating cps".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
}
// die();
echo "<div class=\"alert alert-success\">
<strong>Successfully Cutting Reported.</strong>
</div>";
if ($go_back_to == 'doc_track_panel_cut')
{
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = '".getFullURLLevel($_GET['r'],'doc_track_panel_cut.php',0,'N')."'; }</script>";
}
else if ($go_back_to == 'doc_track_panel_withrolls')
{
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = '".getFullURLLevel($_GET['r'],'cut_qty_reporting_withrolls/doc_track_panel.php',1,'N')."'; }</script>";
}
else if ($go_back_to == 'doc_track_panel_withrolls_recut')
{
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = '".getFullURLLevel($_GET['r'],'cut_qty_reporting_withrolls/doc_track_panel_recut.php',1,'N')."'; }</script>";
}
else if ($go_back_to == 'doc_track_panel_without_recut')
{
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = '".getFullURLLevel($_GET['r'],'doc_track_panel.php',1,'N')."'; }</script>";
}


?>