<?php
include("dbconf_sch.php");

$sql="SELECT MIN((TIMESTAMPDIFF(MINUTE,updated_time_stamp,NOW()))) AS hrsdff FROM brandix_bts.`bts_to_sfcs_sync` WHERE sync_status=1";
$sql_result2=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row2=mysqli_fetch_array($sql_result2))
{
	$current_session=$sql_row2['hrsdff'];	
}


if($current_session>10)
{
		include("dbconf_sch.php");
		 
		//Track Execution - 20171225 KK
		$sql2="insert into brandix_bts_uat.syn_tran_monitor_log (logdate,startdate,status) values (curdate(),now(),1)";
		//echo $sql2."<br>";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$iLastID=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);

		$sql2="call brandix_bts_uat.sp_snap_view_uat()";
		//echo $sql2."<br>";
		//mysql_query($sql2,$link) or exit("Sql Error".mysql_error());

	
		$bundle_id=array();
		$sql2="select bai_pro_ref from bai_pro3.ims_log where ims_status in ('EPS','EPR')";
		//echo $sql2."<br>";
		$sql_result3=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result3)>0)
		{
			while($sql_row3=mysqli_fetch_array($sql_result3))
			{
				$bundle_id[]=$sql_row3['bai_pro_ref'];
			}
		}
		//echo sizeof($bundle_id)."<br>";
		$bundle_id_tmp=array();
		$sql2="select * from brandix_bts.bundle_transactions_20_repeat where operation_id='2' and bundle_id in (".implode(",",$bundle_id).")";
		//echo $sql2."<br>";
		$sql_result3=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result3)>0)
		{
			while($sql_row3=mysqli_fetch_array($sql_result3))
			{
				$bundle_id_tmp[]=$sql_row3['bundle_id'];
			}
			
			$sql3="insert ignore into bai_pro3.ims_log_ems select * from bai_pro3.ims_log where bai_pro_ref in (".implode(",",$bundle_id_tmp).")";
			$sql_result4=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			//echo $sql3."<br>";
			$sql3="delete from bai_pro3.ims_log where bai_pro_ref in (".implode(",",$bundle_id_tmp).")";
			$sql_result4=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		}


		$sql="SELECT 0_tbl_snap FROM snap_session_track WHERE session_id=1";
		// echo $sql."<br/><br/>";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$tblsnap=$sql_row['0_tbl_snap'];
		}

		$sql="SELECT MAX(bundle_transactions_20_repeat_id) as max_id FROM $tblsnap WHERE bundle_transactions_20_repeat_operation_id IN (2,3,4,6,7)"; 
		//echo $sql."<br>";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$filterlimit=$sql_row['max_id'];
		}
		//echo $filterlimit."<br>";
		if($filterlimit>0)
		{

		//KK To track records process count- 20171225
		$sql="SELECT min(bts_tran_id) as min_bts_tran_id,max(bts_tran_id) as max_bts_tran_id, min(sync_rep_id) as min_sync_rep_id, max(sync_rep_id) as max_sync_rep_id FROM brandix_bts.bts_to_sfcs_sync WHERE sync_status=0 AND sync_rep_id<=$filterlimit  ORDER BY bts_tran_id";

		$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$min_bts_tran_id=$sql_row['min_bts_tran_id'];	
			$max_bts_tran_id=$sql_row['max_bts_tran_id'];
			$max_sync_rep_id=$sql_row['max_sync_rep_id'];
			$min_sync_rep_id=$sql_row['min_sync_rep_id'];	
		}


		$sql="SELECT bts_tran_id,sync_bundle_id,sync_operation_id,sync_operation_code,sync_rep_id FROM brandix_bts.bts_to_sfcs_sync WHERE sync_status=0 AND sync_rep_id<=$filterlimit  ORDER BY bts_tran_id";

		//echo $sql."<br>";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($sql_row=mysqli_fetch_array($sql_result))
		{
			
			$var_bts_tran_id=$sql_row['bts_tran_id'];
			$var_sync_bundle_id=$sql_row['sync_bundle_id'];
			$var_sycn_operation_id=$sql_row['sync_operation_id'];
			$var_sync_operaiton_code=$sql_row['sync_operation_code'];
			$var_sync_rep_id=$sql_row['sync_rep_id'];
			$user_name=echo_title("brandix_bts_uat.view_set_1_snap","bundle_transactions_employee_id","bundle_transactions_20_repeat_operation_id='".$var_sycn_operation_id."' and bundle_transactions_20_repeat_bundle_id",$var_sync_bundle_id,$link);

			$var_case_tag=($var_sycn_operation_id*10)+$var_sync_operaiton_code;
			
			$var_size_name="";

			$sql1="SELECT date(bundle_transactions_date_time) as date_in,tbl_orders_size_ref_size_name,bundle_transactions_20_repeat_quantity
			,CONCAT(DATE(bundle_transactions_date_time),bundle_transactions_20_repeat_act_module) as result
			,tbl_shifts_master_shift_name, bundle_transactions_20_repeat_operation_id,bundle_transactions_20_repeat_act_module,tbl_miniorder_data_docket_number,view_set_2_snap_smv
			 FROM $tblsnap WHERE bundle_transactions_20_repeat_id=$var_sync_rep_id AND bundle_transactions_20_repeat_operation_id IN (2,3,4,6,7)";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$smv=$sql_row1['view_set_2_snap_smv'];
				$var_size_name=$sql_row1['tbl_orders_size_ref_size_name'];
				$date_in=$sql_row1['date_in'];
				$doc_no=$sql_row1['tbl_miniorder_data_docket_number'];
				//if($var_sycn_operation_id==4 and $sql_row1['bundle_transactions_20_repeat_operation_id']==4)
				//{
					$var_date_team=$sql_row1['result'];
					$var_team=$sql_row1['tbl_shifts_master_shift_name'];
					$var_mod=$sql_row1['bundle_transactions_20_repeat_act_module'];
				//}
				
			}
			$sql11="select * from bai_pro3.plandoc_stat_log where doc_no ='".$doc_no."'";
			$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row1=mysqli_fetch_array($sql_result11))
			{
				$cut_num=$row1['pcutno'];
				$act_cut_status=$row1['act_cut_status'];
				$act_cut_issue_status=$row1['act_cut_issue_status'];
				$col_code=echo_title("bai_pro3.bai_orders_db_confirm","color_code","order_tid",$row1['order_tid'],$link);
				$schedule=echo_title("bai_pro3.bai_orders_db_confirm","order_del_no","order_tid",$row1['order_tid'],$link);
				$job_no=chr($col_code).leading_zeros($cut_num,3);
				$ims_cid=echo_title("bai_pro3.plandoc_stat_log","cat_ref","doc_no",$row1['doc_no'],$link);
			}
			$emb_status=echo_title("brandix_bts.tbl_orders_master","emb_status","product_schedule",$schedule,$link);
			//echo $var_sync_bundle_id."---".$emb_status."----".$var_case_tag."---".$var_size_name."--".$var_bts_tran_id."<br>";
			if(strlen($var_size_name)!=0)
			{
				
				switch($var_case_tag)
				{
					
					case 20:
					{				
						$sql12="SELECT bai_pro_ref FROM bai_pro3.ims_log WHERE bai_pro_ref=".$var_sync_bundle_id;
						$sql_result_set2=mysqli_query($link, $sql12) or exit("Sql Error72".mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($sql_result_set2)==0)
						{
							$sql13="insert ignore into bai_pro3.ims_log (rand_track,ims_qty,ims_shift,
							ims_mod_no,ims_date,ims_size,ims_style,ims_color,ims_schedule,bai_pro_ref,ims_cid,ims_doc_no) select bundle_transactions_20_repeat_id,bundle_transactions_20_repeat_quantity,
							tbl_shifts_master_shift_name,bundle_transactions_module_id,bundle_transactions_date_time,
							concat('a_',tbl_orders_size_ref_size_name),tbl_orders_style_ref_product_style,tbl_miniorder_data_color,
							tbl_orders_master_product_schedule,tbl_miniorder_data_bundle_number,'".$ims_cid."',tbl_miniorder_data_docket_number 
							from ".$tblsnap." where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
							mysqli_query($link, $sql13) or exit("Sql Error83".mysqli_error($GLOBALS["___mysqli_ston"]));
							/*
							if(mysql_affected_rows($link)>0)
							{
								$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no)  
								select NOW(),tbl_orders_style_ref_product_style,tbl_orders_master_product_schedule,tbl_miniorder_data_color,tbl_orders_size_ref_size_name,tbl_orders_sizes_master_size_title
								,'".$doc_no."',bundle_transactions_20_repeat_quantity,'".$user_name."@localhost','SIN',bundle_transactions_20_repeat_id,
								bundle_transactions_module_id,tbl_shifts_master_shift_name,'".$job_no."' from ".$tblsnap." where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
								mysql_query($sql1,$link) or exit("Sql Error10".mysql_error());
							*/	
								$sql1112="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=1 WHERE bts_tran_id=".$var_bts_tran_id;
								// echo $sql1."<br/><br/>";
								mysqli_query($link, $sql1112) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
							/*	
								if($act_cut_status == 'DONE' && $act_cut_issue_status == '')
								{
									$sql1="UPDATE bai_pro3.plandoc_stat_log SET act_cut_issue_status='DONE' WHERE doc_no='".$doc_no."'";
									// echo $sql1."<br/><br/>";
									mysql_query($sql1,$link) or exit("Sql Error9".mysql_error());
								}
							}
							*/
						}
						else
						{
							$sql1112="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=-1 WHERE bts_tran_id=".$var_bts_tran_id;
								// echo $sql1."<br/><br/>";
							mysqli_query($link, $sql1112) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
						break;
						
					}	
					
					case 30:
					{				
						$sql14="SELECT sfcs_tid_ref FROM m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE m3_op_des='SIN' and sfcs_tid_ref='".$var_sync_rep_id."'";
						$sql_result_set14=mysqli_query($link, $sql14) or exit("Sql Error-1".mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($sql_result_set14)==0)
						{
						/*	$sql1="insert ignore into bai_pro3.ims_log (rand_track,ims_qty,ims_shift,
							ims_mod_no,ims_date,ims_size,ims_style,ims_color,ims_schedule,bai_pro_ref,ims_cid,ims_doc_no) select bundle_transactions_20_repeat_id,bundle_transactions_20_repeat_quantity,
							tbl_shifts_master_shift_name,bundle_transactions_module_id,bundle_transactions_date_time,
							concat('a_',tbl_orders_size_ref_size_name),tbl_orders_style_ref_product_style,tbl_miniorder_data_color,
							tbl_orders_master_product_schedule,tbl_miniorder_data_bundle_number,'".$ims_cid."','".$doc_no."' 
							from ".$tblsnap." where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
							mysql_query($sql1,$link) or exit("Sql Error8".mysql_error());
						*/	
							//if(mysql_affected_rows($link)>0)
							//{
								$sql19="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no)  
								select NOW(),tbl_orders_style_ref_product_style,tbl_orders_master_product_schedule,tbl_miniorder_data_color,tbl_orders_size_ref_size_name,tbl_orders_sizes_master_size_title
								,'".$doc_no."',bundle_transactions_20_repeat_quantity,'".$user_name."@localhost','SIN',bundle_transactions_20_repeat_id,
								bundle_transactions_module_id,tbl_shifts_master_shift_name,'".$job_no."' from ".$tblsnap." where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
								mysqli_query($link, $sql19) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
								
								$sql18="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=1 WHERE bts_tran_id=".$var_bts_tran_id;
								// echo $sql1."<br/><br/>";
								mysqli_query($link, $sql18) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
								
								if($act_cut_status == 'DONE' && $act_cut_issue_status == '')
								{
									$sql16="UPDATE bai_pro3.plandoc_stat_log SET act_cut_issue_status='DONE' WHERE doc_no='".$doc_no."'";
									// echo $sql1."<br/><br/>";
									mysqli_query($link, $sql16) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
									
									$sql10="insert ignore into `bai_pro3`.`act_cut_issue_status` (`doc_no`, `date`, `remarks`, `mod_no`, `shift`) values ('".$doc_no."', '".$date_in."', 'nil', '".$var_mod."', '".$var_team."')";
									mysqli_query($link, $sql10) or exit("Sql Error1-10".mysqli_error($GLOBALS["___mysqli_ston"]));
								}
							//}
						}
						else
						{
							$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=-1 WHERE bts_tran_id=".$var_bts_tran_id;
							// echo $sql1."<br/><br/>";
							mysqli_query($link, $sql1) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
						break;
						
					}
					
					case 40:
					{
						$sql1="SELECT ims_tid FROM bai_pro.bai_log WHERE bac_style<>'0' and ims_tid=".$var_sync_rep_id."";
						// echo $sql1."<br/><br/>";
						$sql_result_set=mysqli_query($link, $sql1) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($sql_result_set)==0)
						{
							$var_nop=0;
							
							if($var_team=="A")
							{
								$sql1="SELECT COALESCE(avail_A,0) as result FROM bai_pro.pro_atten WHERE atten_id='".$var_date_team."'";
								// echo $sql1."<br/><br/>";
								$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row1=mysqli_fetch_array($sql_result1))
								{
									$var_nop=$sql_row1['result'];
								}
							}
							else
							{
								
								
								$sql1="SELECT COALESCE(avail_B,0) as result FROM bai_pro.pro_atten WHERE atten_id='".$var_date_team."'";
								// echo $sql1."<br/><br/>";
								$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error14$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row1=mysqli_fetch_array($sql_result1))
								{
									$var_nop=$sql_row1['result'];
								}
							}
							
							$couple=echo_title("bai_pro.pro_plan_today","couple","mod_no",$var_mod,$link);
							
							if($var_nop==null)
							{
								$var_nop=0;
							}
							
							$sql1="insert ignore into bai_pro.bai_log (bac_Qty,bac_shift,bac_no,size_xs,bac_style,
							color,delivery,buyer,bac_sec,bac_lastup,smv,ims_doc_no,ims_tid,bac_date,size_".$var_size_name.",nop,ims_table_name,couple
							) select bundle_transactions_20_repeat_quantity,tbl_shifts_master_shift_name,
							bundle_transactions_20_repeat_act_module,tbl_orders_size_ref_size_name,tbl_orders_style_ref_product_style,
							tbl_miniorder_data_color,tbl_orders_master_product_schedule,order_div,tbl_module_ref_module_section,
							bundle_transactions_date_time,view_set_2_snap_smv,'".$doc_no."',
							bundle_transactions_20_repeat_id,bundle_transactions_date_time,bundle_transactions_20_repeat_quantity,'".$var_nop."','ims_log','".$couple."'
							from ".$tblsnap." where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
							// echo $sql1."<br/><br/>";
							mysqli_query($link, $sql1) or exit("Sql Error15".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							$sql1="insert ignore into bai_pro.bai_log_buf (bac_Qty,bac_shift,bac_no,size_xs,bac_style,
							color,delivery,buyer,bac_sec,bac_lastup,smv,ims_doc_no,ims_tid,bac_date,size_".$var_size_name.",nop,ims_table_name,couple
							) select bundle_transactions_20_repeat_quantity,tbl_shifts_master_shift_name,
							bundle_transactions_20_repeat_act_module,tbl_orders_size_ref_size_name,tbl_orders_style_ref_product_style,
							tbl_miniorder_data_color,tbl_orders_master_product_schedule,order_div,tbl_module_ref_module_section,
							bundle_transactions_date_time,view_set_2_snap_smv,'".$doc_no."',
							bundle_transactions_20_repeat_id,bundle_transactions_date_time,bundle_transactions_20_repeat_quantity,'".$var_nop."','ims_log','".$couple."'
							from ".$tblsnap." where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
							// echo $sql1."<br/><br/>";
							mysqli_query($link, $sql1) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							// echo "EFFECTED ROWS:".mysql_affected_rows($link)."<br/><br/>";
							if(mysqli_affected_rows($link)>0)
							{
								
								$sql1="UPDATE bai_pro3.ims_log SET ims_status='DONE',ims_pro_qty=(SELECT bundle_transactions_20_repeat_quantity FROM ".$tblsnap." where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id.") where bai_pro_ref=".$var_sync_bundle_id;
								// echo $sql1."<br/><br/>";
								mysqli_query($link, $sql1) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));
								
								$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,
								sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no) select NOW(),tbl_orders_style_ref_product_style,
								tbl_orders_master_product_schedule,tbl_miniorder_data_color,tbl_orders_size_ref_size_name,tbl_orders_sizes_master_size_title,	
								'".$doc_no."',bundle_transactions_20_repeat_quantity,'".$user_name."@localhost','SOT',
								bundle_transactions_20_repeat_id,bundle_transactions_20_repeat_act_module,tbl_shifts_master_shift_name,'".$job_no."' from 
								".$tblsnap." where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id
								=".$var_sycn_operation_id;
								//echo $sql1."<br/><br/>";
								mysqli_query($link, $sql1) or exit("Sql Error27".mysqli_error($GLOBALS["___mysqli_ston"]));
								
								$sql="insert ignore into bai_pro3.ims_log_backup select * from bai_pro3.ims_log where bai_pro_ref='".$var_sync_bundle_id."'";
								mysqli_query($link, $sql) or exit("Sql Error19-1".mysqli_error($GLOBALS["___mysqli_ston"]));
								
								//if(mysql_affected_rows($link)>0)
								//{
									$sql="delete from bai_pro3.ims_log where bai_pro_ref='".$var_sync_bundle_id."'";
									//echo "<br/>$sql";
									mysqli_query($link, $sql) or exit("Sql Error19-2".mysqli_error($GLOBALS["___mysqli_ston"]));
								//}
								
								$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=1 WHERE bts_tran_id=".$var_bts_tran_id;
								// echo $sql1."<br/><br/>";
								mysqli_query($link, $sql1) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
								
							}
						}
						else
						{
							$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=-1 WHERE bts_tran_id=".$var_bts_tran_id;
								// echo $sql1."<br/><br/>";
								mysqli_query($link, $sql1) or exit("Sql Error19".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
						break;	
						
					}
					
					case 21:
					{
						
						$sql11="select bundle_transactions_20_repeat_quantity,bundle_transactions_20_repeat_rejection_quantity,bundle_transactions_module_id,tbl_shifts_master_shift_name,date(bundle_transactions_date_time) as ims_date FROM brandix_bts.view_set_1 where bundle_transactions_20_repeat_id='".$var_sync_rep_id."' and bundle_transactions_20_repeat_operation_id='".$var_sycn_operation_id."'";
						$resutlt11=mysqli_query($link, $sql11) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($row11=mysqli_fetch_array($resutlt11))
						{
							$sql11="UPDATE bai_pro3.ims_log SET rand_track='".$row11['bundle_transactions_20_repeat_id']."',ims_qty='".$row11['bundle_transactions_20_repeat_quantity']."',ims_mod_no='".$row11['bundle_transactions_module_id']."',ims_shift='".$row11['tbl_shifts_master_shift_name']."',ims_date='".$row11['ims_date']."' where bai_pro_ref=".$var_sync_bundle_id;
							mysqli_query($link, $sql11) or exit("Sql Error23".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							$sql1="UPDATE brandix_bts_uat.view_set_1_snap SET bundle_transactions_20_repeat_quantity='".$row11['bundle_transactions_20_repeat_quantity']."',bundle_transactions_20_repeat_rejection_quantity='".$row11['bundle_transactions_20_repeat_rejection_quantity']."' where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
							mysqli_query($link, $sql1) or exit("Sql Error24".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							$sql1="UPDATE ".$tblsnap." SET bundle_transactions_20_repeat_quantity='".$row11['bundle_transactions_20_repeat_quantity']."',bundle_transactions_20_repeat_rejection_quantity='".$row11['bundle_transactions_20_repeat_rejection_quantity']."' where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
							mysqli_query($link, $sql1) or exit("Sql Error25".mysqli_error($GLOBALS["___mysqli_ston"]));
						}					
						//if(mysql_affected_rows($link)>0)
						//{
							$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=1 WHERE bts_tran_id=".$var_bts_tran_id;
							mysqli_query($link, $sql1) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
						//}
							
						break;
					}
					
					case 31:
					{
						
							$sql11="select bundle_transactions_20_repeat_quantity,bundle_transactions_20_repeat_rejection_quantity,bundle_transactions_module_id,tbl_shifts_master_shift_name,date(bundle_transactions_date_time) as ims_date FROM brandix_bts.view_set_1 where bundle_transactions_20_repeat_id='".$var_sync_rep_id."' and bundle_transactions_20_repeat_operation_id='".$var_sycn_operation_id."'";
							$resutlt11=mysqli_query($link, $sql11) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($row11=mysqli_fetch_array($resutlt11))
							{
								$sql11="UPDATE bai_pro3.ims_log SET rand_track='".$row11['bundle_transactions_20_repeat_id']."',ims_qty='".$row11['bundle_transactions_20_repeat_quantity']."',ims_mod_no='".$row11['bundle_transactions_module_id']."',ims_shift='".$row11['tbl_shifts_master_shift_name']."',ims_date='".$row11['ims_date']."' where bai_pro_ref=".$var_sync_bundle_id;
								mysqli_query($link, $sql11) or exit("Sql Error23".mysqli_error($GLOBALS["___mysqli_ston"]));
								
								$sql1="UPDATE brandix_bts_uat.view_set_1_snap SET bundle_transactions_20_repeat_quantity='".$row11['bundle_transactions_20_repeat_quantity']."',bundle_transactions_20_repeat_rejection_quantity='".$row11['bundle_transactions_20_repeat_rejection_quantity']."' where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
								mysqli_query($link, $sql1) or exit("Sql Error24".mysqli_error($GLOBALS["___mysqli_ston"]));
								
								$sql1="UPDATE ".$tblsnap." SET bundle_transactions_20_repeat_quantity='".$row11['bundle_transactions_20_repeat_quantity']."',bundle_transactions_20_repeat_rejection_quantity='".$row11['bundle_transactions_20_repeat_rejection_quantity']."' where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
								mysqli_query($link, $sql1) or exit("Sql Error25".mysqli_error($GLOBALS["___mysqli_ston"]));
							}					
							//if(mysql_affected_rows($link)>0)
							//{
								$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=1 WHERE bts_tran_id=".$var_bts_tran_id;
								mysqli_query($link, $sql1) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
							//}
							
						break;
					}
					case 41:
					{
					
						$sql12="select bundle_transactions_20_repeat_quantity,bundle_transactions_module_id,bundle_transactions_20_repeat_act_module,tbl_shifts_master_shift_name,bundle_transactions_date_time,date(bundle_transactions_date_time) as op_date,bundle_transactions_20_repeat_rejection_quantity FROM brandix_bts.view_set_1 where bundle_transactions_20_repeat_id='".$var_sync_rep_id."' and bundle_transactions_20_repeat_bundle_id='".$var_sync_bundle_id."' and bundle_transactions_20_repeat_operation_id='".$var_sycn_operation_id."'";
						$resutlt12=mysqli_query($link, $sql12) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($row12=mysqli_fetch_array($resutlt12))
						{
							$sql1="UPDATE bai_pro3.ims_log SET ims_status='DONE',ims_pro_qty='".$row12['bundle_transactions_20_repeat_quantity']."' where bai_pro_ref=".$var_sync_bundle_id;
							mysqli_query($link, $sql1) or exit("Sql Error23".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							$sql1="UPDATE bai_pro3.ims_log_backup SET ims_status='DONE',ims_pro_qty='".$row12['bundle_transactions_20_repeat_quantity']."' where bai_pro_ref=".$var_sync_bundle_id;
							mysqli_query($link, $sql1) or exit("Sql Error23".mysqli_error($GLOBALS["___mysqli_ston"]));
											
							$sql1="UPDATE bai_pro.bai_log SET bac_lastup='".$row12['bundle_transactions_date_time']."',bac_date='".$row12['op_date']."',
							bac_qty='".$row12['bundle_transactions_20_repeat_quantity']."',bac_no='".$row12['bundle_transactions_20_repeat_act_module']."',bac_shift='".$row12['tbl_shifts_master_shift_name']."',size_".$var_size_name."='".$row12['bundle_transactions_20_repeat_quantity']."' where ims_tid=".$var_sync_rep_id;
							mysqli_query($link, $sql1) or exit("Sql Error24".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							$sql1="UPDATE bai_pro.bai_log_buf SET bac_lastup='".$row12['bundle_transactions_date_time']."',bac_date='".$row12['op_date']."',
							bac_qty='".$row12['bundle_transactions_20_repeat_quantity']."',bac_no='".$row12['bundle_transactions_20_repeat_act_module']."',bac_shift='".$row12['tbl_shifts_master_shift_name']."',size_".$var_size_name."='".$row12['bundle_transactions_20_repeat_quantity']."' where ims_tid=".$var_sync_rep_id;
							mysqli_query($link, $sql1) or exit("Sql Error25".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							$sql1="UPDATE brandix_bts_uat.view_set_1_snap SET bundle_transactions_20_repeat_quantity='".$row12['bundle_transactions_20_repeat_quantity']."',bundle_transactions_20_repeat_rejection_quantity='".$row12['bundle_transactions_20_repeat_rejection_quantity']."' where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
							mysqli_query($link, $sql1) or exit("Sql Error24".mysqli_error($GLOBALS["___mysqli_ston"]));
							$sah=0;
							$sah=round(($row12['bundle_transactions_20_repeat_quantity']*$smv)/60,2);
							$sql1="UPDATE ".$tblsnap." SET bundle_transactions_20_repeat_quantity='".$row12['bundle_transactions_20_repeat_quantity']."',bundle_transactions_20_repeat_rejection_quantity='".$row12['bundle_transactions_20_repeat_rejection_quantity']."',sah='".$sah."' where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
							mysqli_query($link, $sql1) or exit("Sql Error25".mysqli_error($GLOBALS["___mysqli_ston"]));
															
						}
						if(mysqli_affected_rows($link)>0)
						{
							$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=1 WHERE bts_tran_id=".$var_bts_tran_id;
							mysqli_query($link, $sql1) or exit("Sql Error26".mysqli_error($GLOBALS["___mysqli_ston"]));	
						}
						else
						{
							$bac_qty=0;
							$bun_qty=0;
							
							$sql1="SELECT quantity FROM brandix_bts.bundle_transactions_20_repeat where id=".$var_sync_rep_id;
							$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error28".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row1=mysqli_fetch_array($sql_result1))
							{
								$bun_qty=$sql_row1['quantity'];
							}
							
							$sql1="SELECT bac_qty FROM bai_pro.bai_log_buf where ims_tid=".$var_sync_rep_id;
							$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error29".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row1=mysqli_fetch_array($sql_result1))
							{
								$bac_qty=$sql_row1['bac_qty'];
							}
							if($bac_qty==$bun_qty)
							{
								$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=1 WHERE bts_tran_id=".$var_bts_tran_id;
								// echo $sql1."<br/><br/>";
								mysqli_query($link, $sql1) or exit("Sql Error30".mysqli_error($GLOBALS["___mysqli_ston"]));
							}
							else
							{
								
							}
						}
							
						break;
					}
					
					case 60:
					{				
						$sql1="SELECT bai_pro_ref FROM bai_pro3.ims_log WHERE ims_status='EPS' and bai_pro_ref=".$var_sync_bundle_id;
						$sql_result_set=mysqli_query($link, $sql1) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($sql_result_set)==0)
						{
							//$bun_qty=echo_title("brandix_bts.tbl_miniorder_data","quantity","bundle_number",$var_sync_bundle_id,$link);				
							$sql1="insert ignore into bai_pro3.ims_log (rand_track,ims_qty,ims_shift,
							ims_mod_no,ims_date,ims_size,ims_style,ims_color,ims_schedule,bai_pro_ref,ims_cid,ims_doc_no,ims_status) select bundle_transactions_20_repeat_id,bundle_transactions_20_repeat_quantity,
							tbl_shifts_master_shift_name,bundle_transactions_module_id,bundle_transactions_date_time,
							concat('a_',tbl_orders_size_ref_size_name),tbl_orders_style_ref_product_style,tbl_miniorder_data_color,
							tbl_orders_master_product_schedule,tbl_miniorder_data_bundle_number,'".$ims_cid."','".$doc_no."','EPS' 
							from ".$tblsnap." where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
							mysqli_query($link, $sql1) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
							//echo $sql1."<br>";
							$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no)  
							select NOW(),tbl_orders_style_ref_product_style,tbl_orders_master_product_schedule,tbl_miniorder_data_color,tbl_orders_size_ref_size_name,tbl_orders_sizes_master_size_title,
							tbl_miniorder_data_docket_number,bundle_transactions_20_repeat_quantity,'".$user_name."@localhost','EPS',bundle_transactions_20_repeat_id,
							bundle_transactions_module_id,tbl_shifts_master_shift_name,'".$job_no."' from ".$tblsnap." where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
							mysqli_query($link, $sql1) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
							//echo $sql1."<br>";
							$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=1 WHERE bts_tran_id=".$var_bts_tran_id;
							mysqli_query($link, $sql1) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
							//echo $sql1."<br>";
							
						}
						else
						{
							$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=-1 WHERE bts_tran_id=".$var_bts_tran_id;
							// echo $sql1."<br/><br/>";
							mysqli_query($link, $sql1) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
						
						break;
						
					}
					
					case 70:
					{				
						$sql1="SELECT bai_pro_ref FROM bai_pro3.ims_log WHERE ims_status='EPS' and bai_pro_ref=".$var_sync_bundle_id;
						$sql_result_set=mysqli_query($link, $sql1) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($sql_result_set)>0)
						{
							//$bun_qty=echo_title("brandix_bts.tbl_miniorder_data","quantity","bundle_number",$var_sync_bundle_id,$link);
							$sql12="select * FROM ".$tblsnap." where tbl_miniorder_data_bundle_number='".$var_sync_bundle_id."' and bundle_transactions_20_repeat_operation_id='".$var_sycn_operation_id."'";
							$resutlt12=mysqli_query($link, $sql12) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
							//echo mysql_num_rows($resutlt12)."<br>";
							while($row12=mysqli_fetch_array($resutlt12))
							{
								$sql="UPDATE bai_pro3.ims_log SET ims_date = '".$row12['bundle_transactions_date_time']."' , ims_shift = '".$row12['tbl_shifts_master_shift_name']."' , ims_qty = '".$row12['bundle_transactions_20_repeat_quantity']."' , ims_status = 'EPR' , ims_log_date = '".$row12['bundle_transactions_date_time']."' WHERE bai_pro_ref = '".$row12['tbl_miniorder_data_bundle_number']."'";
								$resutlt12=mysqli_query($link, $sql) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
								//echo $sql."<br>";
								$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no)  
								select NOW(),tbl_orders_style_ref_product_style,tbl_orders_master_product_schedule,tbl_miniorder_data_color,tbl_orders_size_ref_size_name,tbl_orders_sizes_master_size_title,
								tbl_miniorder_data_docket_number,bundle_transactions_20_repeat_quantity,'".$user_name."@localhost','EPR',bundle_transactions_20_repeat_id,
								bundle_transactions_module_id,tbl_shifts_master_shift_name,'".$job_no."' from ".$tblsnap." where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
								mysqli_query($link, $sql1) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
								//echo $sql1."<br>";
								$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=1 WHERE bts_tran_id=".$var_bts_tran_id;
								mysqli_query($link, $sql1) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
								//echo $sql1."<br>";
								
							}
							
						}
						else
						{
							$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=-1 WHERE bts_tran_id=".$var_bts_tran_id;
							// echo $sql1."<br/><br/>";
							mysqli_query($link, $sql1) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
						break;
					}
					
				}
					
			}
			else
			{
				Switch($var_case_tag)
				{
					case 20:
					{
						$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=-1 WHERE bts_tran_id=".$var_bts_tran_id;
						//echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error42".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						break;
					}
					case 21:
					{
						$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=-1 WHERE bts_tran_id=".$var_bts_tran_id;
						//echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error42".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						break;
					}	
					case 22:
					{
						$sql1="DELETE FROM bai_pro3.ims_log WHERE rand_track=".$var_sync_rep_id;
						mysqli_query($link, $sql1) or exit("Sql Error38".mysqli_error($GLOBALS["___mysqli_ston"]));	
						
						$sql121="DELETE FROM `brandix_bts_uat`.`view_set_1_snap` WHERE bundle_transactions_20_repeat_operation_id='2' and bundle_transactions_20_repeat_id='".$var_sync_rep_id."'";	
						//mysql_query($sql121,$link) or exit("Sql Error45.1".mysql_error());
										
						$sql122="DELETE FROM `brandix_bts_uat`.`view_set_snap_1_tbl` WHERE bundle_transactions_20_repeat_operation_id='2' and bundle_transactions_20_repeat_id='".$var_sync_rep_id."'";	
						//mysql_query($sql122,$link) or exit("Sql Error45.1".mysql_error());
						
						$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=1 WHERE bts_tran_id=".$var_bts_tran_id;
						// echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error39".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						break;
					}
					case 30:
					{
						$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=-1 WHERE bts_tran_id=".$var_bts_tran_id;
						//echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error42".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						break;
					}
					case 31:
					{
						$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=-1 WHERE bts_tran_id=".$var_bts_tran_id;
						//echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error42".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						break;
					}	
					case 32:
					{
						
						$sql121="DELETE FROM `brandix_bts_uat`.`view_set_1_snap` WHERE bundle_transactions_20_repeat_operation_id='3' and bundle_transactions_20_repeat_id='".$var_sync_rep_id."'";	
						//mysql_query($sql121,$link) or exit("Sql Error45.1".mysql_error());
										
						$sql122="DELETE FROM `brandix_bts_uat`.`view_set_snap_1_tbl` WHERE bundle_transactions_20_repeat_operation_id='3' and bundle_transactions_20_repeat_id='".$var_sync_rep_id."'";	
						//mysql_query($sql122,$link) or exit("Sql Error45.1".mysql_error());
						
						$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift) select sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty*-1,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_tid_ref=".$var_sync_rep_id." and m3_op_des='SIN' and sfcs_reason=''";
						// echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error40".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						if(mysqli_affected_rows($link)>0)
						{
							$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=1 WHERE bts_tran_id=".$var_bts_tran_id;
							// echo $sql1."<br/><br/>";
							mysqli_query($link, $sql1) or exit("Sql Error39".mysqli_error($GLOBALS["___mysqli_ston"]));
							
						}
						else
						{
							$sql1xy="select * from bai_pro3.ims_log where rand_track=".$var_sync_rep_id;
							$sql_result1xy=mysqli_query($link, $sql1xy) or exit("Sql Error41".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							if(mysqli_num_rows($sql_result1xy)==0)
							{
								$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=-1 WHERE bts_tran_id=".$var_bts_tran_id;
								// echo $sql1."<br/><br/>";
								mysqli_query($link, $sql1) or exit("Sql Error42".mysqli_error($GLOBALS["___mysqli_ston"]));
							}
						}
						break;
					}
					case 40:
					{
						$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=-1 WHERE bts_tran_id=".$var_bts_tran_id;
						//echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error42".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						break;
					}
					case 41:
					{
						$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=-1 WHERE bts_tran_id=".$var_bts_tran_id;
						//echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error42".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						break;
					}
					case 42:
					{
						$sql121="DELETE FROM `brandix_bts_uat`.`view_set_1_snap` WHERE bundle_transactions_20_repeat_operation_id='4' and bundle_transactions_20_repeat_id='".$var_sync_rep_id."'";	
						//mysql_query($sql121,$link) or exit("Sql Error45.1".mysql_error());
										
						$sql122="DELETE FROM `brandix_bts_uat`.`view_set_snap_1_tbl` WHERE bundle_transactions_20_repeat_operation_id='4' and bundle_transactions_20_repeat_id='".$var_sync_rep_id."'";	
						//mysql_query($sql122,$link) or exit("Sql Error45.1".mysql_error());
						
						$sql1="insert ignore into bai_pro.bai_log_deleted select * from  bai_pro.bai_log where ims_tid='".$var_sync_rep_id."'";	
						mysqli_query($link, $sql1) or exit("Sql Error45.1".mysqli_error($GLOBALS["___mysqli_ston"]));	
						
						$sql1="DELETE FROM bai_pro.bai_log WHERE ims_tid=".$var_sync_rep_id;
						// echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error44".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						$sql1="DELETE FROM bai_pro.bai_log_buf WHERE ims_tid=".$var_sync_rep_id;
						// echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error45".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						$sql1="insert ignore into bai_pro3.ims_log select * from  bai_pro3.ims_log_backup where bai_pro_ref=".$var_sync_bundle_id;
						mysqli_query($link, $sql1) or exit("Sql Error45.1".mysqli_error($GLOBALS["___mysqli_ston"]));
							
						$sql1="UPDATE bai_pro3.ims_log SET ims_status='',ims_pro_qty=0 where bai_pro_ref=".$var_sync_bundle_id;
						mysqli_query($link, $sql1) or exit("Sql Error38".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						$sql1="DELETE FROM bai_pro3.ims_log_backup WHERE rand_track=".$var_sync_rep_id;
						// echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error45".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no) select sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty*-1,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_tid_ref=".$var_sync_rep_id." and m3_op_des='SOT' and sfcs_reason=''";
						// echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error47".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						if(mysqli_affected_rows($link)>0)
						{
							$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=1 WHERE bts_tran_id=".$var_bts_tran_id;
							// echo $sql1."<br/><br/>";
							mysqli_query($link, $sql1) or exit("Sql Error46".mysqli_error($GLOBALS["___mysqli_ston"]));
											
						}
						else
						{
							$sql1xy="select * from bai_pro.bai_log where ims_tid=".$var_sync_rep_id;
							$sql_result1xy=mysqli_query($link, $sql1xy) or exit("Sql Error48".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							if(mysqli_num_rows($sql_result1xy)==0)
							{
								$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=-1 WHERE bts_tran_id=".$var_bts_tran_id;
								// echo $sql1."<br/><br/>";
								mysqli_query($link, $sql1) or exit("Sql Error49".mysqli_error($GLOBALS["___mysqli_ston"]));
							}
						}
						
						break;
					}
					case 60:
					{
						$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=-1 WHERE bts_tran_id=".$var_bts_tran_id;
						//echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error42".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						break;
					}
					case 61:
					{
						$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=-1 WHERE bts_tran_id=".$var_bts_tran_id;
						//echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error42".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						break;
					}
					case 62:
					{
						$sql121="DELETE FROM `brandix_bts_uat`.`view_set_1_snap` WHERE bundle_transactions_20_repeat_operation_id='6' and bundle_transactions_20_repeat_id='".$var_sync_rep_id."'";	
						//mysql_query($sql121,$link) or exit("Sql Error45.1".mysql_error());
										
						$sql122="DELETE FROM `brandix_bts_uat`.`view_set_snap_1_tbl` WHERE bundle_transactions_20_repeat_operation_id='6' and bundle_transactions_20_repeat_id='".$var_sync_rep_id."'";	
						//mysql_query($sql122,$link) or exit("Sql Error45.1".mysql_error());
						
						
						$sql1="DELETE from bai_pro3.ims_log where bai_pro_ref=".$var_sync_bundle_id;
						// echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error43".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=1 WHERE bts_tran_id=".$var_bts_tran_id;
						// echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error46".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no) select sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty*-1,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_tid_ref=".$var_sync_rep_id." and m3_op_des='EPS' and sfcs_reason=''";
						// echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error47".mysqli_error($GLOBALS["___mysqli_ston"]));
										
						break;
					} 
					case 70:
					{
						$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=-1 WHERE bts_tran_id=".$var_bts_tran_id;
						//echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error42".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						break;
					}
					case 71:
					{
						$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=-1 WHERE bts_tran_id=".$var_bts_tran_id;
						//echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error42".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						break;
					}
					case 72:
					{
						$sql121="DELETE FROM `brandix_bts_uat`.`view_set_1_snap` WHERE bundle_transactions_20_repeat_operation_id='7' and bundle_transactions_20_repeat_id='".$var_sync_rep_id."'";	
						//mysql_query($sql121,$link) or exit("Sql Error45.1".mysql_error());
										
						$sql122="DELETE FROM `brandix_bts_uat`.`view_set_snap_1_tbl` WHERE bundle_transactions_20_repeat_operation_id='7' and bundle_transactions_20_repeat_id='".$var_sync_rep_id."'";	
						//mysql_query($sql122,$link) or exit("Sql Error45.1".mysql_error());
						
						
						$sql1="UPDATE bai_pro3.ims_log SET ims_status='EPS' where bai_pro_ref=".$var_sync_bundle_id;
						mysqli_query($link, $sql1) or exit("Sql Error38".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=1 WHERE bts_tran_id=".$var_bts_tran_id;
						// echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error46".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no) select sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty*-1,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_tid_ref=".$var_sync_rep_id." and m3_op_des='EPR' and sfcs_reason=''";
						// echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error47".mysqli_error($GLOBALS["___mysqli_ston"]));
										
						break;
					} 			
				}
			}
		}
			
		}


		//Track Execution - 20171225 KK
		$sql2="update brandix_bts_uat.syn_tran_monitor_log set enddate=now(),status=2,min_bts_tran_id=$min_bts_tran_id,max_bts_tran_id=$max_bts_tran_id,max_sync_rep_id=$max_sync_rep_id,min_sync_rep_id=$min_sync_rep_id	 where tid=$iLastID";
		//echo $sql2."<br>";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));


		echo "Job Completed Successfully";
		// echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";

}
else
{
	echo "BTS TO SFCS SYNC  not Yet Started";
	// echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
}

?>