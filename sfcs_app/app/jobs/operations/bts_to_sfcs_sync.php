<?php	
$start_timestamp = microtime(true);
include('C:\xampp\htdocs\sfcs_main\sfcs_app\common\config\config_jobs.php');
?>

<?php
	/* ====By ram 10-01-2018====
	Sync data from bundles data creation into bai_pro3.ims_log
	*/
	/*getting data from bundle creation*/ 
	//$bundles_qry="SELECT * FROM brandix_bts.bundle_creation_data WHERE sfcs_smv =0 AND recevied_qty>0 AND sync_status=0";
	//$bundles_qry="SELECT * FROM brandix_bts.bundle_creation_data WHERE is_sewing_order='Yes' AND sewing_order>0 AND recevied_qty>0 AND sync_status=0";
	
	$bundles_qry="select * FROM $brandix_bts.bundle_creation_data_temp WHERE (operation_id='129' or operation_id='100') AND sync_status=0";
	//echo $bundles_qry."<br>";exit;
	//$result = $conn->query($bundles_qry);
	$bundles_qry_result=mysqli_query($link,$bundles_qry) or exit("Bundles Query Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($bundles_qry_result)>0){
		while($row = mysqli_fetch_array($bundles_qry_result)){
					//$sizevalue="a_".sprintf ("%02d\n",$row['size_id']);
					$sizevalue="a_".$row['size_id'];
					$ims_date=date('Y-m-d', strtotime($row['scanned_date']));
					$ims_log_date=date("Y-m-d");
					/*For our identification/unique we maintain bundle no and operation id operation_sequence*/
					$bundle_op_id=$row['bundle_number']."-".$row['operation_id']."-".$row['input_job_no']."-".$row['id'];
					
					/*getting sections from section db by assign module*/
					$sections_qry="select sec_id,sec_head FROM $bai_pro3.sections_db WHERE sec_id>0 AND  sec_mods LIKE '%,".$row['assigned_module'].",%' OR  sec_mods LIKE '".$row['assigned_module'].",%' LIMIT 0,1";
					$sections_qry_result=mysqli_query($link,$sections_qry);
					while($buyer_qry_row=mysqli_fetch_array($sections_qry_result)){
							$sec_head=$buyer_qry_row['sec_id'];
						}
					/*getting cat ref from plandoc stat log*/
					$catrefd_qry="select * FROM $bai_pro3.plandoc_stat_log WHERE order_tid=(SELECT order_tid FROM bai_pro3.bai_orders_db WHERE order_style_no='".$row['style']."' AND order_del_no='".$row['schedule']."' AND order_col_des='".$row['color']."')";
					//echo "<br>Cat Qry :".$catrefd_qry."</br>";
					$catrefd_qry_result=mysqli_query($link,$catrefd_qry);
					while($buyer_qry_row=mysqli_fetch_array($catrefd_qry_result)){
							$cat_ref=$buyer_qry_row['cat_ref'];
						}
					//echo "</br>Cat :".$cat_ref."</br>";
					/*Inserting data into Ims log*/
					$insert_imslog="insert into $bai_pro3.ims_log (ims_date,ims_cid,ims_doc_no,ims_mod_no,ims_shift,
					ims_size,ims_qty,ims_log_date,ims_remarks,ims_style,ims_schedule,ims_color,rand_track,bai_pro_ref,input_job_rand_no_ref,input_job_no_ref,pac_tid) values ('".$ims_date."','".$cat_ref."','".$row['docket_number']."','".$row['assigned_module']."','".$row['shift']."','".trim($sizevalue)."','".$row['recevied_qty']."','".$ims_log_date."','','".$row['style']."','".$row['schedule']."','".$row['color']."','".$row['id']."','".$bundle_op_id."','".$row['input_job_no_random_ref']."','".$row['input_job_no']."','".$row['bundle_number']."')";
					// echo "Insert Ims log :".$insert_imslog."</br>";
					$qry_status=mysqli_query($link,$insert_imslog);
					if($qry_status){
						print("Inserted into ims_log table successfully")."\n";
						/*update sync_status into 1*/
						$update_sync="update $brandix_bts.bundle_creation_data_temp SET sync_status='1' WHERE id=".$row['id'];
						$qry_status1=mysqli_query($link,$update_sync);
						if($qry_status1)
						{
							print("Updated bundle_creation_data table successfully")."\n";
						}
					}	
				}
				
	}
	
	/* ====By ram 09-01-2018====
	Sync data from bundles data creation into bai_pro.bai_log
	*/
	/*getting data from bundle creation*/
	
	$bundles_qry="select * FROM $brandix_bts.bundle_creation_data_temp WHERE (operation_id='101' or operation_id='130') AND sync_status=0";
	$bundles_qry_result=mysqli_query($link,$bundles_qry);
	if(mysqli_num_rows($bundles_qry_result)>0){
		while($row = mysqli_fetch_array($bundles_qry_result)){
			
					//$sizevalue="size_s".sprintf ("%02d\n",$row['size_id']);
					$sizevalue="size_".$row['size_id'];
					$bac_dat=date('Y-m-d', strtotime($row['scanned_date']));
					$log_time=date("Y-m-d");
					$bun_id=$row['id'];
					
					/*For our identification/unique we maintain bundle no and operation id */
					$bundle_op_id=$row['bundle_number']."-".$row['operation_id']."-".$row['input_job_no']."-".$row['id'];
					
					/*getting buyer division from bai orders db*/
					$buyer_qry="select order_div FROM $bai_pro3.bai_orders_db WHERE order_style_no='".$row['style']."' AND order_del_no='".$row['schedule']."' AND order_col_des='".$row['color']."'";
					$buyer_qry_result=mysqli_query($link,$buyer_qry);
					while($buyer_qry_row=mysqli_fetch_array($buyer_qry_result)){
							$buyer_div=$buyer_qry_row['order_div'];
						}
					/*getting sections from section db by assign module*/
					$sections_qry="select sec_id,sec_head FROM $bai_pro3.sections_db WHERE sec_id>0 AND  sec_mods LIKE '%,".$row['assigned_module'].",%' OR  sec_mods LIKE '".$row['assigned_module'].",%' LIMIT 0,1";
					$sections_qry_result=mysqli_query($link,$sections_qry);
					while($buyer_qry_row=mysqli_fetch_array($sections_qry_result)){
							$sec_head=$buyer_qry_row['sec_id'];
					}
						
					/*Getting number of operators fro bai_pro.pro_atten*/
					$qry_nop="select avail_A,avail_B FROM $bai_pro.pro_atten WHERE module=".$row['assigned_module']." AND date='$bac_dat'";
					$qry_nop_result=mysqli_query($link,$qry_nop);
					while($nop_qry_row=mysqli_fetch_array($qry_nop_result)){
							$avail_A=$nop_qry_row['avail_A'];
							$avail_B=$nop_qry_row['avail_B'];
					}
					if(mysqli_num_rows($qry_nop_result)>0){
						if($row['shift']=='A'){
							$nop=$avail_A;
						}else{
							$nop=$avail_B;
						}
					}else{
						$nop=0;
					}
					
					/*Inserting data into bai log*/
					$insert_bailog="insert into $bai_pro.bai_log (bac_no,bac_sec,bac_Qty,bac_lastup,bac_date,
					bac_shift,bac_style,bac_stat,log_time,buyer,delivery,color,loguser,ims_doc_no,smv,".$sizevalue.",ims_table_name,ims_tid,nop,ims_pro_ref,ope_code,jobno
					) values ('".$row['assigned_module']."','".$sec_head."','".$row['recevied_qty']."','".$row['scanned_date']."','".$bac_dat."','".$row['shift']."','".$row['style']."','Active','".$log_time."','".$buyer_div."','".$row['schedule']."','".$row['color']."','".$row['scanned_user']."','".$row['docket_number']."','".$row['sfcs_smv']."','".$row['recevied_qty']."','ims_log','".$bundle_op_id."','".$nop."','".$bundle_op_id."','".$row['operation_id']."','".$row['input_job_no']."')";
					//echo "Bai log : ".$insert_bailog."</br>";
					$qry_status=mysqli_query($link,$insert_bailog);
					if($qry_status){
						print("Inserted into bai_log table successfully")."\n";
						/*Insert same data into bai_pro.bai_log_buf table*/
						$insert_bailogbuf="insert into $bai_pro.bai_log_buf (bac_no,bac_sec,bac_Qty,bac_lastup,bac_date,
						bac_shift,bac_style,bac_stat,log_time,buyer,delivery,color,loguser,ims_doc_no,smv,".$sizevalue.",ims_table_name,ims_tid,nop,ims_pro_ref,ope_code,jobno
						) values ('".$row['assigned_module']."','".$sec_head."','".$row['recevied_qty']."','".$row['scanned_date']."','".$bac_dat."','".$row['shift']."','".$row['style']."','Active','".$log_time."','".$buyer_div."','".$row['schedule']."','".$row['color']."','".$row['scanned_user']."','".$row['docket_number']."','".$row['sfcs_smv']."','".$row['recevied_qty']."','ims_log','".$bundle_op_id."','".$nop."','".$bundle_op_id."','".$row['operation_id']."','".$row['input_job_no']."')";
						//echo "</br>Insert Bailog : ".$insert_bailogbuf."</br>";
						$qrybuf_status=mysqli_query($link,$insert_bailogbuf);
						if($qrybuf_status)
						{
							print("Inserted into bai_log_buf table successfully")."\n";
						}
						
						/*Getting updated operation id bundle num and sequence*/
						$qry_opid="select * FROM $brandix_bts.bundle_creation_data_temp WHERE bundle_number='".$row['bundle_number']."' AND id <'".$bun_id."'  ORDER BY id DESC LIMIT 0,1";
						//echo "getting id :".$qry_opid."</br>";
						$qry_opid_result=mysqli_query($link,$qry_opid);
						while($qry_opid_row=mysqli_fetch_array($qry_opid_result)){
								$updt_bundle_opid=$qry_opid_row['bundle_number']."-".$qry_opid_row['operation_id']."-".$qry_opid_row['input_job_no']."-".$qry_opid_row['id'];
						}
						
						/*Getting updated operation id bundle num and sequence*/
						$qry_ims_opid="select * FROM $bai_pro3.ims_log WHERE bai_pro_ref='".$updt_bundle_opid."' and ims_qty='".$row['recevied_qty']."'";
						//echo "Ims Data : ".$qry_ims_opid."</br>";
						$qry_ims_opid_result=mysqli_query($link,$qry_ims_opid);
						$sql_num_check=mysqli_num_rows($qry_ims_opid_result);
						if($sql_num_check>0){
							while($qry_imsopidrow=mysqli_fetch_array($qry_ims_opid_result)){
									/*Insert into ims_logbackup*/
									$insert_imsbackup="insert into $bai_pro3.ims_log_backup (ims_date,ims_cid,ims_doc_no,ims_mod_no,ims_shift,
									ims_size,ims_qty,ims_log_date,ims_remarks,ims_style,ims_schedule,ims_color,rand_track,bai_pro_ref,tid,input_job_rand_no_ref,input_job_no_ref,pac_tid) values ('".$qry_imsopidrow['ims_date']."','".$qry_imsopidrow['ims_cid']."','".$qry_imsopidrow['ims_doc_no']."','".$qry_imsopidrow['ims_mod_no']."','".$qry_imsopidrow['ims_shift']."','".$qry_imsopidrow['ims_size']."','".$qry_imsopidrow['ims_qty']."','".$qry_imsopidrow['ims_log_date']."','','".$qry_imsopidrow['ims_style']."','".$qry_imsopidrow['ims_schedule']."','".$qry_imsopidrow['ims_color']."','".$qry_imsopidrow['rand_track']."','".$qry_imsopidrow['bai_pro_ref']."','".$qry_imsopidrow['tid']."','".$qry_imsopidrow['input_job_rand_no_ref']."','".$qry_imsopidrow['input_job_no_ref']."','".$qry_imsopidrow['pac_tid']."')";
									//echo "</br>Insert Logbackup :".$insert_imsbackup."</br>";
									$qry_imsbackup_status=mysqli_query($link,$insert_imsbackup);
									if($qry_imsbackup_status){
										/*Update input qty and status*/
										$update_imslog="update $bai_pro3.ims_log_backup SET ims_pro_qty='".$row['recevied_qty']."',ims_status='DONE' WHERE bai_pro_ref='".$updt_bundle_opid."'";
										//echo "Update qry : ".$update_imslog."</br>";
										$qryimslog_status=mysqli_query($link,$update_imslog);
										
										/*Delete completed row in ims_log*/
										$del_imslog="delete FROM $bai_pro3.ims_log WHERE bai_pro_ref='".$qry_imsopidrow['bai_pro_ref']."'";
										$qry_imsdelete_status=mysqli_query($link,$del_imslog);
									}
							
							}

						}else{

							$update_imslog_forqty="update $bai_pro3.ims_log SET ims_pro_qty='".$row['recevied_qty']."' WHERE bai_pro_ref='".$updt_bundle_opid."'";
							//echo "Update qry : ".$update_imslog."</br>";
							$update_imslog_forqty_status=mysqli_query($link,$update_imslog_forqty);

						}
						
						/*update sync_status into 1*/
						$update_sync="update $brandix_bts.bundle_creation_data_temp SET sync_status='1' WHERE id=".$row['id'];
						$qry_status1=mysqli_query($link,$update_sync);
						if($qry_status1)
						{
							print("Updated bundle_creation_data table successfully")."\n";
						}
						
					}	
				}
				
	}
	echo memory_get_usage();
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.")."\n";
	
?>
