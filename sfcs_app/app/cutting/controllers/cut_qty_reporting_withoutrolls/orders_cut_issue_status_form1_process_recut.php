<?php 
//KiranG - 2015-09-02 : passing link as parameter in update_m3_or function to avoid missing user name.
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/m3Updations.php',4,'R')); 
//API related data
$plant_code = $global_facility_code;
$company_num = $company_no;
$host= $api_hostname;
$port= $api_port_no;
$current_date = date('Y-m-d h:i:s');


$op_code = 15;
$b_op_id = 15;
?>

<?php

if(isset($_POST['Update']))
{
	$input_date=$_POST['date'];
	$input_section=$_POST['section'];
	$input_shift=$_POST['shift'];
	$input_fab_rec=$_POST['fab_rec'];
	$input_fab_ret=$_POST['fab_ret'];
	$input_damages=$_POST['damages'];
	$input_shortages=$_POST['shortages'];
	$input_remarks=$_POST['remarks'];
	$input_doc_no=$_POST['doc_no'];
	$tran_order_tid=$_POST['tran_order_tid'];
	$leader_name = $_POST['leader_name'];

	$plies=$_POST['plies'];
	$old_plies=$_POST['old_plies'];

	$old_input_fab_rec=$_POST['old_fab_rec'];
	$old_input_fab_ret=$_POST['old_fab_ret'];
	$old_input_damages=$_POST['old_damages'];
	$old_input_shortages=$_POST['old_shortages'];

	if(strlen($_POST['remarks'])>0)
	{
		$input_remarks=$_POST['remarks']."$".$input_date."^".$input_section."^".$input_shift."^".$input_fab_rec."^".$input_fab_ret."^".$input_damages."^".$input_shortages;
	}
	else
	{
		$input_remarks=$input_date."^".$input_section."^".$input_shift."^".$input_fab_rec."^".$input_fab_ret."^".$input_damages."^".$input_shortages;
	}

	$input_fab_rec+=$old_input_fab_rec;
	$input_fab_ret+=$old_input_fab_ret;
	$input_damages+=$old_input_damages;
	$input_shortages+=$old_input_shortages;



if($plies>0)
{
			
	$sql="insert ignore into $bai_pro3.act_cut_status_recut_v2 (doc_no) values ($input_doc_no)";
	//echo $sql;
	mysqli_query($link, $sql) or exit("Sql Error a".mysqli_error($GLOBALS["___mysqli_ston"]));

	$sql="update $bai_pro3.act_cut_status_recut_v2 set date=\"$input_date\", section=\"$input_section\", shift=\"$input_shift\", fab_received=$input_fab_rec, fab_returned=$input_fab_ret, damages=$input_damages, shortages=$input_shortages, remarks=\"$input_remarks\" ,leader_name='$leader_name' where doc_no=$input_doc_no";
	//echo $sql;
	mysqli_query($link, $sql) or exit("Sql Error b".mysqli_error($GLOBALS["___mysqli_ston"]));

	$sql="update $bai_pro3.recut_v2 set act_cut_status=\"DONE\", a_plies=".($plies+$old_plies)." where doc_no=$input_doc_no";
	mysqli_query($link, $sql) or exit("Sql Error c".mysqli_error($GLOBALS["___mysqli_ston"]));
}
}
//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"orders_cut_issue_status_list.php?tran_order_tid=$tran_order_tid\"; }</script>";
// $url = getFullURL($_GET['r'],'doc_track_panel.php','N');
// echo "<script>sweetAlert('Updated Successfully','','success')</script>";
// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"$url\"; }</script>";

	$go_back = 'doc_track_panel_without_recut';
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",10); function Redirect() {  location.href = '".getFullURLLevel($_GET['r'],'trail.php',0,'N')."&doc_no_ref=$input_doc_no&plies=$plies&go_back_to=$go_back'; }</script>";

?>

