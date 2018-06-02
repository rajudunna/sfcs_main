<?php
include("dbconf.php");
?>


<?php

$sql="SELECT 0_tbl_snap FROM snap_session_track WHERE session_id=1";
// echo $sql."<br/><br/>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$tblsnap=$sql_row['0_tbl_snap'];
}

$sql="SELECT MAX(bundle_transactions_20_repeat_id) as max_id FROM $tblsnap WHERE bundle_transactions_20_repeat_operation_id IN (3,4)"; 
//echo $sql."<br>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$filterlimit=$sql_row['max_id'];
}
//echo $filterlimit."<br>";
if($filterlimit>0)
{

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

	$var_case_tag=($var_sycn_operation_id*10)+$var_sync_operaiton_code;
	
	$var_size_name="";
	

	$sql1="SELECT tbl_orders_size_ref_size_name,bundle_transactions_20_repeat_quantity,DATE(bundle_transactions_date_time) as date_in
	,CONCAT(DATE(bundle_transactions_date_time),bundle_transactions_20_repeat_act_module) as result
	,tbl_shifts_master_shift_name, bundle_transactions_20_repeat_operation_id,bundle_transactions_20_repeat_act_module,tbl_miniorder_data_docket_number
	 FROM $tblsnap WHERE bundle_transactions_20_repeat_id=$var_sync_rep_id AND bundle_transactions_20_repeat_operation_id IN (3,4)";
	 //echo $sql1."<br/><br/>";
	 //echo $sql1."<br/><br/>";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$var_size_name=$sql_row1['tbl_orders_size_ref_size_name'];
		$doc_no=$sql_row1['tbl_miniorder_data_docket_number'];
		if($var_sycn_operation_id==4 and $sql_row1['bundle_transactions_20_repeat_operation_id']==4)
		{
			$var_date_team=$sql_row1['result'];
		}
		$var_team=$sql_row1['tbl_shifts_master_shift_name'];
		$var_mod=$sql_row1['bundle_transactions_20_repeat_act_module'];
		$date_in=$sql_row1['date_in'];
		
	} 
	
	$sql11="select * from bai_pro3.plandoc_stat_log where doc_no ='".$doc_no."'";
	$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($sql_result11))
	{
		$cut_num=$row1['pcutno'];
		$act_cut_status=$row1['act_cut_status'];
		$act_cut_issue_status=$row1['act_cut_issue_status'];
		$col_code=echo_title("bai_pro3.bai_orders_db_confirm","color_code","order_tid",$row1['order_tid'],$link);
		$job_no=chr($col_code).leading_zeros($cut_num,3);
		$ims_cid=echo_title("bai_pro3.plandoc_stat_log","cat_ref","doc_no",$row1['doc_no'],$link);
	}
	//echo $var_size_name."--".$var_bts_tran_id."<br>";
	if(strlen($var_size_name)!=0)
	{
		
		switch($var_case_tag)
		{
			case 30:
			{				
				$sql1="SELECT rand_track FROM bai_pro3.ims_log WHERE rand_track=".$var_sync_rep_id;
				$sql_result_set=mysqli_query($link, $sql1) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($sql_result_set)==0)
				{
					
					$sql1="insert ignore into bai_pro3.ims_log (rand_track,ims_qty,ims_shift,
				ims_mod_no,ims_date,ims_size,ims_style,ims_color,ims_schedule,ims_log_date,
				ims_doc_no,bai_pro_ref,ims_cid) select bundle_transactions_20_repeat_id,bundle_transactions_20_repeat_quantity,
				tbl_shifts_master_shift_name,bundle_transactions_module_id,bundle_transactions_date_time,
				concat('a_',tbl_orders_size_ref_size_name),tbl_orders_style_ref_product_style,tbl_miniorder_data_color,
				tbl_orders_master_product_schedule,bundle_transactions_date_time,tbl_miniorder_data_docket_number,tbl_miniorder_data_bundle_number,'".$ims_cid."' 
				from ".$tblsnap." where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
				
					mysqli_query($link, $sql1) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					 echo "EFFECTED ROWS:".mysqli_affected_rows($link)."<br/><br/>";
					if(mysqli_affected_rows($link)>0)
					{
						$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=1 WHERE bts_tran_id=".$var_bts_tran_id;
						// echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no)  
						select NOW(),tbl_orders_style_ref_product_style,tbl_orders_master_product_schedule,tbl_miniorder_data_color,tbl_orders_size_ref_size_name,tbl_orders_sizes_master_size_title,
						tbl_miniorder_data_docket_number,bundle_transactions_20_repeat_quantity,'BAINet@localhost','SIN',bundle_transactions_20_repeat_id,
						bundle_transactions_module_id,tbl_shifts_master_shift_name,'".$job_no."' from ".$tblsnap." where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
						
						mysqli_query($link, $sql1) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						if($act_cut_status == 'DONE' && $act_cut_issue_status <> 'DONE')
						{
							$sql1="UPDATE bai_pro3.plandoc_stat_log SET act_cut_issue_status='DONE' WHERE doc_no='".$doc_no."'";
							// echo $sql1."<br/><br/>";
							mysqli_query($link, $sql1) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							$sql121="insert into `bai_pro3`.`act_cut_issue_status` (`doc_no`, `date`, `remarks`, `mod_no`, `shift`) values ('".$doc_no."', '".$date_in."', 'nil', '".$var_mod."', '".$var_team."')";
							mysqli_query($link, $sql121) or exit("Sql Error122".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
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
			
			case 40:
			{
				$sql1="SELECT ims_tid FROM bai_pro.bai_log WHERE ims_tid=".$var_sync_rep_id."";
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
					bundle_transactions_date_time,view_set_2_snap_smv,tbl_miniorder_data_docket_number,
					bundle_transactions_20_repeat_id,bundle_transactions_date_time,bundle_transactions_20_repeat_quantity,'".$var_nop."','ims_log','".$couple."'
					from ".$tblsnap." where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
					// echo $sql1."<br/><br/>";
					mysqli_query($link, $sql1) or exit("Sql Error15".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$sql1="insert ignore into bai_pro.bai_log_buf (bac_Qty,bac_shift,bac_no,size_xs,bac_style,
					color,delivery,buyer,bac_sec,bac_lastup,smv,ims_doc_no,ims_tid,bac_date,size_".$var_size_name.",nop,ims_table_name,couple
					) select bundle_transactions_20_repeat_quantity,tbl_shifts_master_shift_name,
					bundle_transactions_20_repeat_act_module,tbl_orders_size_ref_size_name,tbl_orders_style_ref_product_style,
					tbl_miniorder_data_color,tbl_orders_master_product_schedule,order_div,tbl_module_ref_module_section,
					bundle_transactions_date_time,view_set_2_snap_smv,tbl_miniorder_data_docket_number,
					bundle_transactions_20_repeat_id,bundle_transactions_date_time,bundle_transactions_20_repeat_quantity,'".$var_nop."','ims_log','".$couple."'
					from ".$tblsnap." where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
					// echo $sql1."<br/><br/>";
					mysqli_query($link, $sql1) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					// echo "EFFECTED ROWS:".mysql_affected_rows($link)."<br/><br/>";
					if(mysqli_affected_rows($link)>0)
					{
						$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=1 WHERE bts_tran_id=".$var_bts_tran_id;
						// echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						$sql1="UPDATE bai_pro3.ims_log SET ims_status='DONE',ims_pro_qty=(SELECT bundle_transactions_20_repeat_quantity FROM ".$tblsnap." where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id.") where bai_pro_ref=".$var_sync_bundle_id;
						// echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no) select NOW(),tbl_orders_style_ref_product_style,tbl_orders_master_product_schedule,tbl_miniorder_data_color,tbl_orders_size_ref_size_name,tbl_orders_sizes_master_size_title,	tbl_miniorder_data_docket_number,bundle_transactions_20_repeat_quantity,'BAINet@localhost','SOT',bundle_transactions_20_repeat_id,bundle_transactions_20_repeat_act_module,tbl_shifts_master_shift_name,'".$job_no."' from ".$tblsnap." where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
						//echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error27".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						$sql="insert ignore into bai_pro3.ims_log_backup (select * from bai_pro3.ims_log where bai_pro_ref='".$var_sync_bundle_id."')";
						mysqli_query($link, $sql) or exit("Sql Error19-1".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						$sql="delete from bai_pro3.ims_log where bai_pro_ref='".$var_sync_bundle_id."'";
						//echo "<br/>$sql";
						mysqli_query($link, $sql) or exit("Sql Error19-2".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						
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
			
			case 31:
			{
				
				$sql11="select bundle_transactions_20_repeat_quantity,bundle_transactions_module_id,tbl_shifts_master_shift_name,date(bundle_transactions_date_time) as ims_date FROM ".$tblsnap." where bundle_transactions_20_repeat_id='".$var_sync_rep_id."' and bundle_transactions_20_repeat_operation_id='".$var_sycn_operation_id."'";
				$resutlt11=mysqli_query($link, $sql11) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row11=mysqli_fetch_array($resutlt11))
				{
					$sql11="UPDATE bai_pro3.ims_log SET ims_qty='".$row11['bundle_transactions_20_repeat_quantity']."',ims_mod_no='".$row11['bundle_transactions_module_id']."',ims_shift='".$row11['tbl_shifts_master_shift_name']."',ims_date='".$row11['ims_date']."' where bai_pro_ref=".$var_sync_bundle_id;
					// echo $sql1."<br/><br/>";
					mysqli_query($link, $sql11) or exit("Sql Error23".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				
				// echo "EFFECTED ROWS:".mysql_affected_rows($link)."<br/><br/>";
				if(mysqli_affected_rows($link)>0)
				{
					$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=1 WHERE bts_tran_id=".$var_bts_tran_id;
					// echo $sql1."<br/><br/>";
					mysqli_query($link, $sql1) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no) select NOW(),tbl_orders_style_ref_product_style,tbl_orders_master_product_schedule,tbl_miniorder_data_color,tbl_orders_size_ref_size_name,tbl_orders_sizes_master_size_title,	
			        tbl_miniorder_data_docket_number,bundle_transactions_20_repeat_rejection_quantity*-1,'BAINet@localhost','SIN',bundle_transactions_20_repeat_id,
					bundle_transactions_module_id,tbl_shifts_master_shift_name,'".$job_no."' from ".$tblsnap." where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
					// echo $sql1."<br/><br/>";
					mysqli_query($link, $sql1) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));	
				}
					
				break;
			}
			case 41:
			{
			
				$sql12="select bundle_transactions_20_repeat_quantity,bundle_transactions_module_id,bundle_transactions_20_repeat_act_module,tbl_shifts_master_shift_name,bundle_transactions_date_time,date(bundle_transactions_date_time) as op_date FROM ".$tblsnap." where tbl_miniorder_data_bundle_number='".$var_sync_bundle_id."' and bundle_transactions_20_repeat_operation_id='".$var_sycn_operation_id."'";
				//echo $sql12."<br>";
				$resutlt12=mysqli_query($link, $sql12) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row12=mysqli_fetch_array($resutlt12))
				{
					$sql1="UPDATE bai_pro3.ims_log SET ims_status='DONE',ims_pro_qty='".$row12['bundle_transactions_20_repeat_quantity']."' where bai_pro_ref=".$var_sync_bundle_id;
					// echo $sql1."<br/><br/>";
					mysqli_query($link, $sql1) or exit("Sql Error23".mysqli_error($GLOBALS["___mysqli_ston"]));
									
					$sql1="UPDATE bai_pro.bai_log SET bac_lastup='".$row12['bundle_transactions_date_time']."',bac_date='".$row12['op_date']."',
					bac_qty='".$row12['bundle_transactions_20_repeat_quantity']."',bac_no='".$row12['bundle_transactions_20_repeat_act_module']."',bac_shift='".$row12['tbl_shifts_master_shift_name']."',size_".$var_size_name."='".$row12['bundle_transactions_20_repeat_quantity']."' where ims_tid=".$var_sync_rep_id;
					// echo $sql1."<br/><br/>";
					mysqli_query($link, $sql1) or exit("Sql Error24".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$sql1="UPDATE bai_pro.bai_log_buf SET bac_lastup='".$row12['bundle_transactions_date_time']."',bac_date='".$row12['op_date']."',
					bac_qty='".$row12['bundle_transactions_20_repeat_quantity']."',bac_no='".$row12['bundle_transactions_20_repeat_act_module']."',bac_shift='".$row12['tbl_shifts_master_shift_name']."',size_".$var_size_name."='".$row12['bundle_transactions_20_repeat_quantity']."' where ims_tid=".$var_sync_rep_id;
					// echo $sql1."<br/><br/>";
					mysqli_query($link, $sql1) or exit("Sql Error25".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				}
				
				// echo "EFFECTED ROWS:".mysql_affected_rows($link)."<br/><br/>";
				if(mysqli_affected_rows($link)>0)
				{
					$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=1 WHERE bts_tran_id=".$var_bts_tran_id;
					// echo $sql1."<br/><br/>";
					mysqli_query($link, $sql1) or exit("Sql Error26".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no) select NOW(),tbl_orders_style_ref_product_style,tbl_orders_master_product_schedule,tbl_miniorder_data_color,tbl_orders_size_ref_size_name,tbl_orders_sizes_master_size_title,	tbl_miniorder_data_docket_number,bundle_transactions_20_repeat_rejection_quantity*-1,'BAINet@localhost','SOT',bundle_transactions_20_repeat_id,bundle_transactions_20_repeat_act_module,tbl_shifts_master_shift_name,'".$job_no."' from ".$tblsnap." where bundle_transactions_20_repeat_id=".$var_sync_rep_id." and bundle_transactions_20_repeat_operation_id=".$var_sycn_operation_id;
					// echo $sql1."<br/><br/>";
					mysqli_query($link, $sql1) or exit("Sql Error27".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				else
				{
					$bac_qty=0;
					$bun_qty=0;
					
					$sql1="SELECT quantity FROM brandix_bts.bundle_transactions_20_repeat where id=".$var_sync_rep_id;
					// echo $sql1."<br/><br/>";
					$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error28".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row1=mysqli_fetch_array($sql_result1))
					{
						$bun_qty=$sql_row1['quantity'];
					}
					
					$sql1="SELECT bac_qty FROM bai_pro.bai_log_buf where ims_tid=".$var_sync_rep_id;
					// echo $sql1."<br/><br/>";
					$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error29".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row1=mysqli_fetch_array($sql_result1))
					{
						$bac_qty=$sql_row1['bac_qty'];
					}
					
					if($bac_qty==$bun_qty)
					{
						$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=-1 WHERE bts_tran_id=".$var_bts_tran_id;
						// echo $sql1."<br/><br/>";
						mysqli_query($link, $sql1) or exit("Sql Error30".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				}
					
				break;
			}
			
			
		}
			
	}
	else
	{
		Switch($var_case_tag)
		{
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
				$sql1="DELETE FROM bai_pro3.ims_log WHERE rand_track=".$var_sync_rep_id;
				// echo $sql1."<br/><br/>";
				mysqli_query($link, $sql1) or exit("Sql Error38".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				// echo "EFFECTED ROWS:".mysql_affected_rows($link)."<br/><br/>";
				if(mysqli_affected_rows($link)>0)
				{
					$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=1 WHERE bts_tran_id=".$var_bts_tran_id;
					// echo $sql1."<br/><br/>";
					mysqli_query($link, $sql1) or exit("Sql Error39".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift) 
					select sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty*-1,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_tid_ref=".$var_sync_rep_id." and m3_op_des='SIN' and sfcs_reason=''";
					// echo $sql1."<br/><br/>";
					mysqli_query($link, $sql1) or exit("Sql Error40".mysqli_error($GLOBALS["___mysqli_ston"]));
					
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
				$sql1="UPDATE bai_pro3.ims_log SET ims_status='',ims_pro_qty=0 where bai_pro_ref=".$var_sync_bundle_id;
				// echo $sql1."<br/><br/>";
				mysqli_query($link, $sql1) or exit("Sql Error43".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql1="insert into bai_pro.bai_log_deleted select * from  bai_pro.bai_log where ims_tid='".$var_sync_rep_id."'";	
				mysqli_query($link, $sql1) or exit("Sql Error45.1".mysqli_error($GLOBALS["___mysqli_ston"]));	
				
				$sql1="DELETE FROM bai_pro.bai_log WHERE ims_tid=".$var_sync_rep_id;
				// echo $sql1."<br/><br/>";
				mysqli_query($link, $sql1) or exit("Sql Error44".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql1="DELETE FROM bai_pro.bai_log_buf WHERE ims_tid=".$var_sync_rep_id;
				// echo $sql1."<br/><br/>";
				mysqli_query($link, $sql1) or exit("Sql Error45".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				// echo "EFFECTED ROWS:".mysql_affected_rows($link)."<br/><br/>";
				if(mysqli_affected_rows($link)>0)
				{
					$sql1="UPDATE brandix_bts.bts_to_sfcs_sync SET sync_status=1 WHERE bts_tran_id=".$var_bts_tran_id;
					// echo $sql1."<br/><br/>";
					mysqli_query($link, $sql1) or exit("Sql Error46".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no) select sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty*-1,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_tid_ref=".$var_sync_rep_id." and m3_op_des='SOT' and sfcs_reason=''";
					// echo $sql1."<br/><br/>";
					mysqli_query($link, $sql1) or exit("Sql Error47".mysqli_error($GLOBALS["___mysqli_ston"]));
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
		}
	}
}
	
}

//echo "done";
echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
?>