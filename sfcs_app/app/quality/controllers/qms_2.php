<?php
// include("dbconf.php");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/m3Updations.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',3,'R'));
//include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));

//$has_perm=haspermission($_GET['r']);
// $view_access=user_acl("SFCS_0142",$username,1,$group_id_sfcs);
// $auth_users=user_acl("SFCS_0142",$username,7,$group_id_sfcs);
// $url=getFullURL($_GET['r'],'restricted.php','N');
 //$auth_users=array("kirang","mohanr","gayanl","buddhikam");
// if(!in_array($authorized,$has_perm))
// {
// 	header("Location:$url");
// }


?>


<head>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.min.js',3,'R'); ?>"></script>

<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/jquery.autocomplete.css',1,'R'); ?>" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.autocomplete.js',1,'R'); ?>"></script>

<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/filtergrid.css',3,'R'); ?>"></script>

<!---<style type="text/css">
#div-1a {
 position:absolute;
 top:65px;
 right:0;
 width:auto;
float:right;

</style>



<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
body{ 
	/* margin:15px; padding:15px; border:1px solid #666; */
	font-family:Arial, Helvetica, sans-serif; font-size:88%; 
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px;  padding:5px; background-color:#f4f4f4; solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; outset #f4f4f4; margin:2px; }
.mytable th{ background-color:#29759c; color:#FFF; padding:2px; solid #ccc; white-space: nowrap;}
td{ padding:2px; white-space: nowrap;}
</style> -->
<script type="text/javascript">
$(document).ready(function(){
 $("#tag").autocomplete("autocomplete.php", {
		selectFirst: true
	});
	$("#fade1").fadeOut(3000);
});
</script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
</head>

<!-- <div id="page_heading"><span style="float"><h3>Quality Rejection Reversal Form</h3></span><span style="float: right">&nbsp;</span></div> -->
<br/>

<div class='panel panel-primary'>
<div class='panel-heading'>Quality Rejection Reversal Form</div>
<div class='panel-body'>
<div class='form-group'>
<div class='table-responsive'>

<form action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="POST">


<div class='col-md-3 col-sm-3 col-xs-12'>
<h5>Schedule:</h5><input name="schedule" type="text" class="form-control col-md-7 col-xs-12 float" value="<?php $_POST['schedule'];?>" id="tag" size="20" required/>
</div>
<div class='col-md-2 col-sm-3 col-xs-12'>
<input type="submit" value="Search" name="search" class="btn btn-success" style="margin-top: 34px;">
<a href="<?= getFullURL($_GET['r'],'qms_3.php','N'); ?>"  class="btn btn-link"><p style="margin-top: -31px;margin-left: 70px;">Deleted Transactions</p></a>
</div>

</form>


<?php 
if(isset($_GET['tid']))
{

	$tid_ref=$_GET['tid'];
	$locationid=$_GET['location'];
	$qms_qty=$_GET['qms_qty1'];
	$parent_id = $_GET['parent_id'];
	$bcd_id = $_GET['bcd_id'];
	
	$sql1="select bundle_no,qms_style,qms_color,input_job_no,operation_id,qms_size,SUBSTRING_INDEX(remarks,'-',1) as module,SUBSTRING_INDEX(remarks,'-',-1) AS form,ref1,doc_no,qms_schedule from $bai_pro3.bai_qms_db where qms_tid='".$tid_ref."' ";
	// echo $sql1."<br>";
	// die();
	$result1=mysqli_query($link, $sql1) or die("Sql error".$sql1.mysqli_errno($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($result1))
	{
		$input_job_no=$sql_row["input_job_no"];
		$operation_id=$sql_row["operation_id"];
		$qms_size=$sql_row["qms_size"];
		$module_ref=$sql_row["module"];
		$rejections_ref=$sql_row["ref1"];
		$style=$sql_row["qms_style"];
		$color=$sql_row["qms_color"];
		$bundle_no_ref=$sql_row["bundle_no"];
		$doc_no = $sql_row['doc_no'];
		$schedule = $sql_row['qms_schedule'];
		$form = $sql_row['form'];
	}

	$url = '?r='.$_GET['r'];
	$job_deacive = "SELECT * FROM $bai_pro3.job_deactive_log where schedule = '$schedule' and input_job_no_random='$input_job_no' and remove_type = '3'";
	$job_deacive_res=mysqli_query($link, $job_deacive) or die("Sql error".$sql1.mysqli_errno($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($job_deacive_res)>0){
		echo "<script>swal('Sewing Job Deactivated!','','warning');window.location = '".$url."'</script>"; 
		return false;
	}
	
	$emb_cut_check_flag = 0;
	$ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code=$operation_id";
	// echo $ops_seq_check;
	$result_ops_seq_check = $link->query($ops_seq_check);
	if($result_ops_seq_check->num_rows > 0)
	{
		while($row = $result_ops_seq_check->fetch_assoc()) 
		{
			$ops_seq = $row['ops_sequence'];
			$seq_id = $row['id'];
			$ops_order = $row['operation_order'];
		}
	}
	$pre_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) < '$ops_order' and operation_code NOT IN  (10,200) ORDER BY operation_order DESC LIMIT 1";
	$result_pre_ops_check = $link->query($pre_ops_check);
	if($result_pre_ops_check->num_rows > 0)
	{
		while($row = $result_pre_ops_check->fetch_assoc()) 
		{
			$pre_ops_code = $row['operation_code'];
		}
		$category=['cutting','Send PF','Receive PF'];
		$checking_qry = "SELECT category FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code = '$pre_ops_code'";
		$result_checking_qry = $link->query($checking_qry);
		while($row_cat = $result_checking_qry->fetch_assoc()) 
		{
			$category_act = $row_cat['category'];
		}
		if(in_array($category_act,$category))
		{
			$emb_cut_check_flag = 1;
		}
	}
	if($emb_cut_check_flag == 1)
	{
		$cps_update = "update $bai_pro3.cps_log set remaining_qty=remaining_qty+$qms_qty where doc_no = $doc_no and operation_code = $pre_ops_code and size_code = '$qms_size'";
		mysqli_query($link, $cps_update) or die("Sql error".$cps_update.mysqli_errno($GLOBALS["___mysqli_ston"]));
	}
	// $ops_sequence="SELECT ops_sequence FROM $brandix_bts.tbl_style_ops_master WHERE style='".$style."' AND COLOR='".$color."' AND operation_code='".$operation_id."'";
	// $ops_sequence_sql_result=mysqli_query($link,$ops_sequence) or exit("ops_sequence Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// while($ops_sequence_row = mysqli_fetch_array($ops_sequence_sql_result))
	// {
	// 	$ops_sequence=$ops_sequence_row["ops_sequence"];
	// }
	// $form="P";
	// if($ops_sequence > 0)
	// {	
	// 	$max_ops="SELECT max(id) as operation_code FROM $brandix_bts.tbl_style_ops_master WHERE style='".$style."' AND COLOR='".$color."' AND ops_sequence='".$ops_sequence."'";
	// 	$max_ops_sql_result=mysqli_query($link,$max_ops) or exit("max_ops Error".$max_ops.mysqli_error($GLOBALS["___mysqli_ston"]));
	// 	while($max_ops_row = mysqli_fetch_array($max_ops_sql_result))
	// 	{
	// 		$max_ops_code=$max_ops_row["operation_code"];
	// 	}
		
	// 	$ops_dependency="SELECT ops_dependency FROM $brandix_bts.tbl_style_ops_master WHERE style='".$style."' AND COLOR='".$color."' AND id='".$max_ops_code."'";
	// 	$ops_dependency_sql_result=mysqli_query($link,$ops_dependency) or exit("ops_dependency Error".$ops_dependency.mysqli_error($GLOBALS["___mysqli_ston"]));
	// 	while($ops_dependency_row = mysqli_fetch_array($ops_dependency_sql_result))
	// 	{
	// 		$ops_dependency=$ops_dependency_row["ops_dependency"];
	// 	}
		
	// 	if($ops_dependency > 0)
	// 	{
	// 		if($ops_dependency < 130)
	// 		{
	// 			$form="P";
	// 		}
	// 		else
	// 		{
	// 			$form="G";
	// 		}
	// 	}
	// 	else
	// 	{
	// 		if($operation_id < 130)
	// 		{
	// 			$form="P";
	// 		}
	// 		else
	// 		{
	// 			$form="G";
	// 		}
	// 	}
	// }
	// else
	// {
	// 	if($operation_id < 130)
	// 	{
	// 		$form="P";
	// 	}
	// 	else
	// 	{
	// 		$form="G";
	// 	}
	// }
	
	// echo "<br>Form=".$form."<br><br>";
	$reason = array();	$r_reasons = array();	$reason_qty = array();
	$rejections_ref_explode=explode("$",$rejections_ref);
	for ($i=0; $i < sizeof($rejections_ref_explode); $i++)
	{ 
		$rejections_ref_explode_ref=explode("-",$rejections_ref_explode[$i]);
		$reason[] = $rejections_ref_explode_ref[0];
		$reason_qty[] = $rejections_ref_explode_ref[1];
	}

	for ($z=0; $z < sizeof($reason); $z++)
	{ 
		$rej_code="select m3_reason_code from $bai_pro3.bai_qms_rejection_reason where form_type='".$form."' and reason_code='".$reason[$z]."'";
		$rej_code_sql_result=mysqli_query($link,$rej_code) or exit("m3_reason_code Error".$ops_dependency.mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rej_code_row = mysqli_fetch_array($rej_code_sql_result))
		{
			$r_reasons[]=$rej_code_row["m3_reason_code"];
		}
	}
	// die();
	$sql_module="SELECT * from $brandix_bts.bundle_creation_data where bundle_number='".$bundle_no_ref."' and operation_id='".$operation_id."' and input_job_no_random_ref='".$input_job_no."'  and assigned_module='".$module_ref."' and size_id='".$qms_size."'";
	$sql_result_module=mysqli_query($link, $sql_module) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result_module) == 0)
    {
		$sql_module1="SELECT assigned_module from $brandix_bts.bundle_creation_data where bundle_number='".$bundle_no_ref."' and operation_id='".$operation_id."' and input_job_no_random_ref='".$input_job_no."'  and size_id='".$qms_size."'";
		$sql_result_module1=mysqli_query($link, $sql_module1) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row_mod=mysqli_fetch_array($sql_result_module1))
		{
			$module_ref1=$sql_row_mod['assigned_module'];
		}
	}
	else
	{
		$module_ref1=$module_ref;
	}
		$bts_update="update $brandix_bts.bundle_creation_data set rejected_qty=rejected_qty-".$qms_qty." where bundle_number='".$bundle_no_ref."' and operation_id='".$operation_id."' and input_job_no_random_ref='".$input_job_no."'  and assigned_module='".$module_ref1."' and size_id='".$qms_size."'";
		// echo $bts_update."<br>";
		mysqli_query($link, $bts_update) or die("Sql error".$bts_update.mysqli_errno($GLOBALS["___mysqli_ston"]));
	// echo $bts_update.'</br>';
	
	//5176 rejection reversal - appear in IPS and IMS 
	$application_ips='IPS';
	$scanning_query_ips="select operation_name,operation_code from $brandix_bts.tbl_ims_ops where appilication='$application_ips'";
	$scanning_result_ips=mysqli_query($link, $scanning_query_ips)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row_ips=mysqli_fetch_array($scanning_result_ips))
	{
		$operation_name=$sql_row_ips['operation_name'];
		$operation_code=$sql_row_ips['operation_code'];
	}
	if($operation_code == 'Auto'){
		$get_ips_op = get_ips_operation_code($link,$style,$color);
		$operation_code=$get_ips_op['operation_code'];
		$operation_name=$get_ips_op['operation_name'];
	}

	$application_ims = 'IMS_OUT';
	$scanning_query_ims="select operation_code from $brandix_bts.tbl_ims_ops where appilication='$application_ims'";
	$scanning_result_ims=mysqli_query($link, $scanning_query_ims)or exit("scanning_error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row_ims=mysqli_fetch_array($scanning_result_ims))
	{
		$ims_code=$sql_row_ims['operation_code'];
	}
						
	$sql="SELECT COALESCE(SUM(send_qty),0) AS send_qty,COALESCE(SUM(recevied_qty),0) AS rec_qty,COALESCE(SUM(rejected_qty),0) AS rej_qty,bundle_qty_status from $brandix_bts.bundle_creation_data where bundle_number='".$bundle_no_ref."' and operation_id='".$operation_id."' and input_job_no_random_ref='".$input_job_no."'  and assigned_module='".$module_ref1."' and size_id='".$qms_size."'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$send_qty=$sql_row["send_qty"];
		$qty_val = $sql_row["rec_qty"] + $sql_row["rej_qty"];
		$bundle_status = $sql_row["bundle_qty_status"];
	}
	
	if($qms_qty>0)
	{
		if($bundle_status == 1)
		{
			$status_update_query = "UPDATE $brandix_bts.bundle_creation_data SET `bundle_qty_status`= '0' where bundle_number =$bundle_no_ref and operation_id = ".$operation_id;
			$status_result_query = $link->query($status_update_query) or exit('query error in updating status');
		}

		if($operation_id == $operation_code)
		{
			$checking_qry_plan_dashboard = "SELECT * FROM `$bai_pro3`.`plan_dashboard_input` WHERE input_job_no_random_ref = '$input_job_no'";
            $result_checking_qry_plan_dashboard = $link->query($checking_qry_plan_dashboard);
            if(mysqli_num_rows($result_checking_qry_plan_dashboard) == 0)
            {   
                $insert_qry_ips = "INSERT INTO `$bai_pro3`.`plan_dashboard_input` 
                SELECT * FROM `$bai_pro3`.`plan_dashboard_input_backup`
                WHERE input_job_no_random_ref = '$input_job_no' order by input_trims_status desc limit 1";
				mysqli_query($link, $insert_qry_ips) or exit("insert_qry_ips".mysqli_error($GLOBALS["___mysqli_ston"]));
				$affectced_rows_ips=mysqli_affected_rows($link);
				
				if($affectced_rows_ips > 0)
				{
					$sqlx="delete from $bai_pro3.plan_dashboard_input_backup where input_job_no_random_ref='".$input_job_no."'";
					mysqli_query($link, $sqlx) or exit("delete_qry_ips".mysqli_error($GLOBALS["___mysqli_ston"]));
				}

			}
		}
	
		if($operation_id == $ims_code)
		{
			$checking_qry_ims_dashboard = "SELECT * FROM `$bai_pro3`.`ims_log` WHERE pac_tid= $bundle_no_ref ";
            $result_checking_qry_ims_dashboard = $link->query($checking_qry_ims_dashboard);
            if(mysqli_num_rows($result_checking_qry_ims_dashboard) == 0)
            {
				$update_status_query = "update $bai_pro3.ims_log_backup set ims_status = '' where pac_tid= $bundle_no_ref ";
				mysqli_query($link,$update_status_query) or exit('query error in updating status ims_log_backup');

				$ims_backup="insert into $bai_pro3.ims_log select * from bai_pro3.ims_log_backup where pac_tid= $bundle_no_ref";
				mysqli_query($link,$ims_backup) or exit("Error while inserting into ims_backup".mysqli_error($GLOBALS["___mysqli_ston"]));
				$affectced_rows_ims=mysqli_affected_rows($link);

				if($affectced_rows_ims > 0)
				{
					$ims_delete="delete from $bai_pro3.ims_log_backup where pac_tid= $bundle_no_ref";
					mysqli_query($link,$ims_delete) or exit("While Delete ims_log_backup".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		}
	}

	if($send_qty > 0 && $qty_val == 0)
	{
		$operations_qry="select operation_code from $brandix_bts.tbl_orders_ops_ref where category ='sewing' AND display_operations='yes'";
		$operations_res=mysqli_query($link,$operations_qry) or exit("Sql Error_operations".mysqli_error());
		while($row_res=mysqli_fetch_array($operations_res))
		{
			$operations[] = $row_res['operation_code'];
		}
		$sewing_operations = implode ( ", ", $operations);

		$check_bcd="select * from $brandix_bts.bundle_creation_data WHERE bundle_number =$bundle_no_ref and operation_id in ($sewing_operations) and bundle_qty_status=5";
		$result_status= mysqli_query($link, $check_bcd);
		if(mysqli_num_rows($result_status) > 0)
		{
			$status_update_query = "UPDATE $brandix_bts.bundle_creation_data SET `bundle_qty_status`= '0' where bundle_number =$bundle_no_ref and operation_id in ($sewing_operations) and bundle_qty_status = 5";
			$status_result_query = $link->query($status_update_query) or exit('query error in updating status');
		}
	}


	$bts_insert="insert into $brandix_bts.bundle_creation_data_temp(cut_number,style,SCHEDULE,color,size_id,size_title,sfcs_smv,bundle_number,rejected_qty,docket_number,assigned_module,remarks,shift,input_job_no,input_job_no_random_ref,operation_id) select cut_number,style,SCHEDULE,color,size_id,size_title,sfcs_smv,bundle_number,'".(-1*$qms_qty)."',docket_number,assigned_module,remarks,shift,input_job_no,input_job_no_random_ref,operation_id from $brandix_bts.bundle_creation_data_temp where bundle_number='".$bundle_no_ref."' and operation_id='".$operation_id."' and input_job_no_random_ref='".$input_job_no."'  and assigned_module='".$module_ref."' and size_id='".$qms_size."' limit 1";
	// echo $bts_insert;
	mysqli_query($link,$bts_insert) or die("Sql error".$sql1.mysqli_errno($GLOBALS["___mysqli_ston"]));
	
	$updated = updateM3TransactionsRejectionsReversal($bundle_no_ref,$operation_id,$reason_qty,$r_reasons);

	//Insert selected row into table deleted table
	$sql1="insert ignore into $bai_pro3.bai_qms_db_deleted select * from bai_pro3.bai_qms_db where qms_tid='".$tid_ref."' ";
	// echo $sql1."<br>";
	$result1=mysqli_query($link, $sql1) or die("Sql error".$sql1.mysqli_errno($GLOBALS["___mysqli_ston"]));
	//reduce qty from location table based on location
	if($locationid != null) {
		$sql3="update $bai_pro3.bai_qms_location_db set qms_cur_qty=(qms_cur_qty-$qms_qty) where qms_location_id='".$locationid."'";
		// echo $sql3."<br>";
		$result3=mysqli_query($link, $sql3) or die("Sql error".$sql3.mysqli_errno($GLOBALS["___mysqli_ston"]));
	}
	//delete selected row from bai_qms_db table
	$sql2="delete from $bai_pro3.bai_qms_db where qms_tid='".$tid_ref."'";
	// echo $sql2."<br>";
	$result2=mysqli_query($link, $sql2) or die("Sql error".$sql2.mysqli_errno($GLOBALS["___mysqli_ston"]));
	
	//updating rejection_log_chile

	$update_qry = "update $bai_pro3.rejection_log_child set rejected_qty = rejected_qty-$qms_qty where bcd_id = $bcd_id";
	// echo $update_qry.'</br>';
	mysqli_query($link, $update_qry) or die("update_qry".$sql2.mysqli_errno($GLOBALS["___mysqli_ston"]));

	$search_qry="SELECT id FROM $bai_pro3.rejections_log where style='$style' and schedule='$schedule' and color='$color'";
					// echo $search_qry;
	$result_search_qry = mysqli_query($link,$search_qry) or exit("rejections_log search query".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($result_search_qry->num_rows > 0)
	{
		while($row_result_search_qry=mysqli_fetch_array($result_search_qry))
		{

			$rejection_log_id = $row_result_search_qry['id'];
			$update_qry_rej_lg = "update $bai_pro3.rejections_log set rejected_qty = rejected_qty-$qms_qty,remaining_qty=remaining_qty-$qms_qty where id = $rejection_log_id";
			// echo $update_qry_rej_lg;
			$update_qry_rej_lg = $link->query($update_qry_rej_lg);
			$parent_id = $rejection_log_id;

		}

	}
	$url = '?r='.$_GET['r'];
	echo "<script>sweetAlert('Deleted Successfully!!!','','success');window.location = '".$url."'</script>"; 
	
}
if(isset($_POST['search']) || $_GET['schedule_id'])
{
	
	$schedule=$_POST['schedule'];
	if($_GET['schedule_id'])
	{
		$schedule=$_GET['schedule_id'];
	}
	$sql3="SELECT order_style_no,order_del_no FROM bai_pro3.`bai_orders_db` WHERE order_del_no='".$schedule."'";
	$getstyle=mysqli_query($link, $sql3) or die("Sql error".$sql3.mysqli_errno($GLOBALS["___mysqli_ston"]));;
	while($getresult=mysqli_fetch_array($getstyle))
	{
		$qms_style=$getresult['order_style_no'];
		$qms_schedule=$getresult['order_del_no'];
	}

	 $sewing_cat = 'sewing';
	 $cutting_cat = 'cutting';
	 $embs_cat = 'Send PF';
	 $embr_cat = 'Receive PF';
	$op_code_query  ="SELECT group_concat(operation_code) as codes FROM $brandix_bts.tbl_orders_ops_ref 
						WHERE trim(category) in ('$sewing_cat','$cutting_cat','$embs_cat','$embr_cat') ";
	$op_code_result = mysqli_query($link, $op_code_query) or exit("No Operations Found for Sewing");
	while($row=mysqli_fetch_array($op_code_result)) 
	{
		$op_codes  = $row['codes'];	
	}
	if(short_shipment_status($qms_style,$qms_schedule,$link)){
		$sql="SELECT rej.`parent_id`,rej.`bcd_id`,qms.qms_tid AS qms_tid,qms.`bundle_no` AS bundle_no,qms.`qms_qty` AS qms_qty,rej.`recut_qty`,
		ref1,location_id,SUBSTRING_INDEX(qms.remarks,'-',-1) AS form,qms_style,qms_schedule,qms_color,qms_size,qms_remarks,qms.operation_id,qms.input_job_no,qms.log_date,log_time 
		FROM bai_pro3.bai_qms_db qms 
		LEFT JOIN brandix_bts.`bundle_creation_data` bts ON bts.`bundle_number` = qms.`bundle_no` AND bts.`operation_id` = qms.`operation_id` 
		LEFT JOIN bai_pro3.`rejection_log_child` rej ON rej.`bcd_id` = bts.`id` LEFT JOIN  bai_pro3.`lay_plan_recut_track` track ON track.bcd_id=bts.id  WHERE qms_tran_type=3 AND qms_schedule='$schedule' 
		AND recut_qty = 0 AND replaced_qty = 0 and bts.`operation_id` in ($op_codes) AND track.recut_raised_qty IS NULL
		";
		
		$result=mysqli_query($link, $sql) or die("Sql error".$sql.mysqli_errno($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($result)>0)
		{
			$msg="<table border='1px' class=\"table table-bordered\"  id=\"table1\"><tr><th>Style</th><th>ScheduleNo</th><th>Color</th><th>Size</th><th>Qms_remarks</th><th>Rejection Type</th><th>Bundle_no</th><th>Operation_id</th><th>Input_job_no</th><th>Date</th><th>Quantity</th><th>Control</th></tr>";
			while($row=mysqli_fetch_array($result))
			{
				$tid=$row["qms_tid"];
				$location_id=$row["location_id"];
				$qms_qty1=$row["qms_qty"];
				$bcd_id = $row['bcd_id'];
				$parent_id = $row['parent_id']; 
				$form = $row['form'];

				
				if($row['form']=="G")
				{
					$form="Garment";
				}else
				{
					$form="Panel";
				}
				
				$url = '?r='.$_GET['r'];
				$order_tid = '';
				$qms_size_title = ims_sizes($order_tid,$row["qms_schedule"],$row["qms_style"],$row["qms_color"],$row["qms_size"],$link);
				
				$msg.="<tr><td>".$row["qms_style"]."</td><td>".$row["qms_schedule"]."</td><td>".$row["qms_color"]."</td><td>".$qms_size_title."</td><td>".$row["qms_remarks"]."</td><td>".$form."</td><td>".$row["bundle_no"]."</td><td>".$row["operation_id"]."</td><td>".$row["input_job_no"]."</td><td>".$row["log_date"]."</td><td>".$row["qms_qty"]."</td><td><a href=\"$url&tid=$tid&schedule_id=$schedule&location=$location_id&bcd_id=$bcd_id&parent_id=$parent_id&qms_qty1=$qms_qty1\" class=\"btn btn-danger\">Delete</a></td></tr>";		
			}
			$msg.="</table>";
			echo $msg;
		}
		else
		{
			echo "<script>sweetAlert('This Schedule no is not available','','error')</script>";
		}
	}
}


?>
</div>
</div>
</div>
</div>
<script language="javascript" type="text/javascript">
	var table6_Props = 	{
							rows_counter: true,
							btn_reset: true,
							loader: true,
							loader_text: "Filtering data..."
						};
	setFilterGrid( "table1",table6_Props );
</script>
