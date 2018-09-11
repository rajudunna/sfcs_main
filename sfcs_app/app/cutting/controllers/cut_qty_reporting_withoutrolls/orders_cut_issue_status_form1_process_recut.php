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

//function to update M3 Bulk OR
function update_m3_or($doc_no,$plies,$operation,$link)
{
	global $in_categories;
	global $bai_pro3;
	global $m3_bulk_ops_rep_db;
	global $link;

	$size_code_db=array('xs','s','m','l','xl','xxl','xxxl','s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50');
	$size_qty=array();
	
	$sql="select * from $bai_pro3.order_cat_recut_doc_mix where doc_no=\"$doc_no\" and remarks in ($in_categories)"; //20110911

	$sql_result=mysqli_query($link, $sql) or exit("Sql Error d".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$size_qty[]=$sql_row['a_xs']*$plies;
		$size_qty[]=$sql_row['a_s']*$plies;
		$size_qty[]=$sql_row['a_m']*$plies;
		$size_qty[]=$sql_row['a_l']*$plies;
		$size_qty[]=$sql_row['a_xl']*$plies;
		$size_qty[]=$sql_row['a_xxl']*$plies;
		$size_qty[]=$sql_row['a_xxxl']*$plies;
		$size_qty[]=$sql_row['a_s01']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s02']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s03']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s04']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s05']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s06']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s07']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s08']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s09']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s10']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s11']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s12']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s13']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s14']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s15']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s16']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s17']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s18']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s19']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s20']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s21']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s22']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s23']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s24']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s25']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s26']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s27']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s28']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s29']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s30']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s31']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s32']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s33']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s34']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s35']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s36']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s37']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s38']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s39']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s40']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s41']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s42']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s43']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s44']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s45']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s46']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s47']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s48']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s49']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s50']*$sql_row['a_plies'];
		$plan_module=$sql_row['plan_module'];
		$order_tid=$sql_row['order_tid'];
		$jobno=$sql_row['acutno'];
	}
	
	
	
	
	//validation to exclude non primary components (Gusset)
	$other_docs=mysqli_num_rows($sql_result);
	
	$sql111="select order_style_no,order_del_no,order_col_des,color_code from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
	$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error e".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row111=mysqli_fetch_array($sql_result111))
	{
		$style=$sql_row111['order_style_no'];
		$schedule=$sql_row111['order_del_no'];
		$color=$sql_row111['order_col_des'];
		$job='R'.leading_zeros($jobno,3);		
	}
	
	$check=0;
	$query_array=array();

	if($other_docs>0)
	{
		//commenting this for #759 CR

		// for($i=0;$i<sizeof($size_code_db);$i++)
		// {
		// 	//validation to report previous operation. //kirang 2015-10-14
		// 	//$sql111="select sfcs_tid from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_style='$style' and sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size='".$size_code_db[$i]."' and sfcs_doc_no='$doc_no' and m3_op_des='LAY' and sfcs_status<>90";
		// 	//$sql_result1112=mysql_query($sql111,$link) or exit("Sql Error".mysql_error());

		// 	//Validation to avoid duplicates
		// 	$sql111="select sfcs_tid from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_style='$style' and sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size='".$size_code_db[$i]."' and sfcs_doc_no='$doc_no' and sfcs_qty=".$size_qty[$i]." and m3_op_des='$operation'";
		// 	$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error 1".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			
		// 	if($size_qty[$i]>0 and mysqli_num_rows($sql_result111)==0 )
		// 	{
								
		// 		//$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_job_no) values (NOW(),'$style','$schedule','$color','".$size_code_db[$i]."',$doc_no,".$size_qty[$i].",USER(),'$operation',$doc_no,'$job')"; 
			
		// 		//echo $sql."<br/>";
		// 		//mysql_query($sql1,$link) or exit("Sql Error6$sql1".mysql_error());
				
		// 		$query_array[]="(NOW(),'$style','$schedule','$color','".$size_code_db[$i]."',$doc_no,".$size_qty[$i].",USER(),'$operation',$doc_no,'$job')";
				
		// 		if($check==0)
		// 		{
		// 			$check=1;
		// 		}
		// 	}
		// }
		
	
	}
	
	if($check==1 OR $other_docs==0)
	{
		//commenting this for #759 CR
		// for($j=0;$j<sizeof($query_array);$j++)
		// {
		// 	$sql1="INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_job_no) values ".$query_array[$j]; 
			
		// 		//echo $sql."<br/>";
		// 		mysqli_query($link, $sql1) or exit("Sql Error6$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
		// }
		
		
		$sql="update $bai_pro3.recut_v2 set act_cut_status=\"DONE\" where doc_no=$doc_no";
		mysqli_query($link, $sql) or exit("Sql Error 2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
		return 'TRUE';
	}
	else
	{
		return 'FALSE';
	}
	
	
}

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
	$ret=update_m3_or($input_doc_no,$plies,'CUT',$link);
	
	if($ret=="TRUE")
	{
		
		$sql="insert ignore into $bai_pro3.act_cut_status_recut_v2 (doc_no) values ($input_doc_no)";
		//echo $sql;
		mysqli_query($link, $sql) or exit("Sql Error a".mysqli_error($GLOBALS["___mysqli_ston"]));

		$sql="update $bai_pro3.act_cut_status_recut_v2 set date=\"$input_date\", section=\"$input_section\", shift=\"$input_shift\", fab_received=$input_fab_rec, fab_returned=$input_fab_ret, damages=$input_damages, shortages=$input_shortages, remarks=\"$input_remarks\" ,leader_name='$leader_name' where doc_no=$input_doc_no";
		//echo $sql;
		mysqli_query($link, $sql) or exit("Sql Error b".mysqli_error($GLOBALS["___mysqli_ston"]));
	
		$sql="update $bai_pro3.recut_v2 set act_cut_status=\"DONE\", a_plies=".($plies+$old_plies)." where doc_no=$input_doc_no";
		mysqli_query($link, $sql) or exit("Sql Error c".mysqli_error($GLOBALS["___mysqli_ston"]));

		//--- M3 Transactions updating starts here................
		/*
		$doc_no_ref = $input_doc_no;
		$op_code = '15';
		$b_op_id = '15';
		$b_shift = $input_shift;
		//getting work_station_id
		$qry_to_get_work_station_id = "SELECT work_center_id,short_cut_code FROM $brandix_bts.`tbl_orders_ops_ref` WHERE operation_code = '$b_op_id'";
		// echo $qry_to_get_work_station_id;
		$result_qry_to_get_work_station_id=mysqli_query($link,$qry_to_get_work_station_id) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($result_qry_to_get_work_station_id))
		{
			$work_station_id = $row['work_center_id'];
			$short_key_code = $row['short_cut_code'];
		}
		if(!$work_station_id)
		{
			$qry_to_get_work_station_id = "SELECT work_station_id FROM bai_pro3.`work_stations_mapping` WHERE operation_code = '$short_key_code' AND module = '$b_module'";
			//echo $qry_to_get_work_station_id;
			$result_qry_to_get_work_station_id=mysqli_query($link,$qry_to_get_work_station_id) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row=mysqli_fetch_array($result_qry_to_get_work_station_id))
			{
				$work_station_id = $row['work_station_id'];
			} 
		}
		//getting mos and filling up
		$qry_cut_qty_check_qry = "SELECT * FROM $bai_pro3.plandoc_stat_log WHERE doc_no = '$doc_no_ref' ";
		$result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
		while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
		{
			// $doc_array[$row['doc_no']] = $row['act_cut_status'];
			$plan_module = $row['plan_module'];
			$order_tid = $row['order_tid'];
			for ($i=0; $i < sizeof($sizes_array); $i++)
			{ 
				if ($row['a_'.$sizes_array[$i]] > 0)
				{
					$cut_done_qty[$sizes_array[$i]] = $row['a_'.$sizes_array[$i]] * $plies;
				}
			}
		}
		$b_module = $plan_module;
		//var_dump($cut_done_qty);
		// INSERTING INTO M3_TRANSACTOINS TABLE AND UPDATING INTO M3_OPS_DETAILS
		foreach($cut_done_qty as $key => $value)
		{
			//759 CR additions Started
			//fetching size_title
			$qty_to_fetch_size_title = "SELECT title_size_$key  FROM $bai_pro3.bai_orders_db_confirm WHERE order_tid ='$order_tid'";
			// echo $qty_to_fetch_size_title;
			$res_qty_to_fetch_size_title=mysqli_query($link,$qty_to_fetch_size_title) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($nop_res_qty_to_fetch_size_title=mysqli_fetch_array($res_qty_to_fetch_size_title))
			{
				// echo "hi";
				$size_title = $nop_res_qty_to_fetch_size_title["title_size_$key"];
				//echo 'ore'.$size_title;
			}
			$qry_to_check_mo_numbers = "SELECT *,mq.id as mq_id FROM $bai_pro3.`mo_operation_quantites`  mq LEFT JOIN bai_pro3.mo_details md ON md.mo_no=mq.`mo_no` WHERE doc_no = '$doc_no_ref' AND op_code = '$op_code' and size = '$size_title' order by mq.mo_no";
			// echo $qry_to_check_mo_numbers;
			$qry_nop_result=mysqli_query($link,$qry_to_check_mo_numbers) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
			$total_bundle_present_qty = $value;
			$total_bundle_rec_present_qty = $value;
			while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
			{
				$total_bundle_present_qty = $total_bundle_rec_present_qty;
				// echo $total_bundle_present_qty;
				if($total_bundle_present_qty > 0)
				{
					$mo_number = $nop_qry_row['mo_no'];
					$mo_quantity = $nop_qry_row['bundle_quantity'];
					$good_quantity_past = $nop_qry_row['good_quantity'];
					$rejected_quantity_past = $nop_qry_row['rejected_quantity'];
					$id = $nop_qry_row['mq_id'];
					$ops_des = $nop_qry_row ['op_desc'];
					$balance_max_updatable_qty = $mo_quantity - ($good_quantity_past + $rejected_quantity_past);
					// echo $balance_max_updatable_qty .'-'. $total_bundle_rec_present_qty;
					if($balance_max_updatable_qty > 0)
					{
						if($balance_max_updatable_qty >= $total_bundle_rec_present_qty)
						{
							$to_update_qty = $total_bundle_rec_present_qty; 
							$actual_rep_qty = $good_quantity_past+$total_bundle_rec_present_qty;
							$update_qry = "update $bai_pro3.mo_operation_quantites set good_quantity = $actual_rep_qty where id= $id";
							$total_bundle_rec_present_qty = 0;
						}
						else
						{
							$to_update_qty = $balance_max_updatable_qty; 
							$actual_rep_qty = $good_quantity_past+$balance_max_updatable_qty;
							$update_qry = "update $bai_pro3.mo_operation_quantites set good_quantity = $actual_rep_qty where id= $id";
							$total_bundle_rec_present_qty = $total_bundle_rec_present_qty - $balance_max_updatable_qty;
						}
							//echo $update_qry.'</br>';
						$ims_pro_qty_updating = mysqli_query($link,$update_qry) or exit("While updating mo_operation_quantites".mysqli_error($GLOBALS["___mysqli_ston"]));
							// if($is_m3 == 'yes')
							// {
								$inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_transactions` (`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`) VALUES ('$mo_number',$to_update_qty,'','Normal',user(),'',$b_module,'$b_shift',$b_op_id,'$ops_des',$id,'$work_station_id','')";
						//echo $inserting_into_m3_tran_log.'</br>';
							mysqli_query($link,$inserting_into_m3_tran_log) or exit("While inserting into m3_tranlog".mysqli_error($GLOBALS["___mysqli_ston"]));
						// }
							$insert_id=mysqli_insert_id($link);

							// //M3 Rest API Call
							$api_url = $host.":".$port."/m3api-rest/execute/PMS070MI/RptOperation?CONO=$company_num&FACI=$plant_code&MFNO=$mo_number&OPNO=$b_op_id&DPLG=$work_station_id&MAQA=$to_update_qty&SCQA=''&SCRE=''&DSP1=1&DSP2=1&DSP3=1&DSP4=1";
							$api_data = $obj->getCurlAuthRequest($api_url);
							$decoded = json_decode($api_data,true);
							$type=$decoded['@type'];
							$code=$decoded['@code'];
							$message=$decoded['Message'];

							//validating response pass/fail and inserting log
							if($type!='ServerReturnedNOK'){
								//updating response status in m3_transactions
								$qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='pass' WHERE id=".$insert_id;
								mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));

							}else{
								//updating response status in m3_transactions
								$qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='fail' WHERE id=".$insert_id;
								mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 Transactions".mysqli_error($GLOBALS["___mysqli_ston"]));

								//insert transactions details into transactions_log
								$qry_transactionslog="INSERT INTO $brandix_bts.`transactions_log` (`transaction_id`,`response_message`,`created_by`,`created_at`) VALUES ('$insert_id',$message,USER(),$current_date)"; 
								mysqli_query($link,$qry_transactionslog) or exit("While inserting into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
							}
					
						}
					}
			
				}
			}
			*/
			//---------Logic Ends Here ----------------------------------
			$updating = updateM3Transactions($input_doc_no,$op_code,$b_op_id,$input_shift,$plan_module);
			if($updating == true){
				//Updated Successfully
			}
		}
	}
}
//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"orders_cut_issue_status_list.php?tran_order_tid=$tran_order_tid\"; }</script>";
// $url = getFullURL($_GET['r'],'doc_track_panel.php','N');
// echo "<script>sweetAlert('Updated Successfully','','success')</script>";
// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"$url\"; }</script>";

	$go_back = 'doc_track_panel_without_recut';
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",10); function Redirect() {  location.href = '".getFullURLLevel($_GET['r'],'trail.php',0,'N')."&doc_no_ref=$input_doc_no&plies=$plies&go_back_to=$go_back'; }</script>";

?>

