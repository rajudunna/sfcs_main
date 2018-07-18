<?php	
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');	

?>
hkjukjn 
<?php
die();	
	//getting bundle creation temp data to sync

	$bundles_qry="select * FROM $brandix_bts.bundle_creation_data_temp WHERE (operation_id='129' or operation_id='100') AND sync_status=0 and recevied_qty!=0";
	$bundles_qry_result=mysqli_query($link,$bundles_qry) or exit("Bundles Query Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($bundles_qry_result)>0)
	{
		while($row = mysqli_fetch_array($bundles_qry_result))
		{
			$sizevalue="a_".$row['size_id'];
			$ims_date=date('Y-m-d', strtotime($row['scanned_date']));
			$ims_log_date=date("Y-m-d");
			/*For our identification/unique we maintain bundle no and operation id operation_sequence*/
			// $bundle_op_id=$row['bundle_number']."-".$row['operation_id']."-".$row['input_job_no']."-".$row['id'];			
			$remarks_ref=$row['remarks'];
			if($remarks_ref=="Normal")
			{
				$remarks_ref="Nil";
			}
			$bundle_op_id=$row['bundle_number']."-".$row['operation_id']."-".$row['input_job_no']."-".$row['assigned_module']."-".$row['remarks'];
			/*getting sections from section db by assign module*/
			$sections_qry="select sec_id,sec_head FROM $bai_pro3.sections_db WHERE sec_id>0 AND  sec_mods LIKE '%,".$row['assigned_module'].",%' OR  sec_mods LIKE '".$row['assigned_module'].",%' LIMIT 0,1";
			$sections_qry_result=mysqli_query($link,$sections_qry) or exit("sections Query Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($buyer_qry_row=mysqli_fetch_array($sections_qry_result))
			{
				$sec_head=$buyer_qry_row['sec_id'];
			}
			/*getting cat ref from plandoc stat log*/
			$cat_ref=0;
			$catrefd_qry="select * FROM $bai_pro3.plandoc_stat_log WHERE order_tid in (select order_tid FROM bai_pro3.bai_orders_db WHERE order_style_no='".$row['style']."' AND order_del_no='".$row['schedule']."' AND order_col_des='".$row['color']."')";
			// echo "<br>Cat Qry :".$catrefd_qry."</br>";
			$catrefd_qry_result=mysqli_query($link,$catrefd_qry) or exit("Cat ref Query Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($buyer_qry_row=mysqli_fetch_array($catrefd_qry_result))
			{
				$cat_ref=$buyer_qry_row['cat_ref'];
			}
			echo "</br>Cat :".$cat_ref."</br>";
			
			$ims_check="select * from $bai_pro3.ims_log where bai_pro_ref='".$bundle_op_id."'";
			$ims_check_result=mysqli_query($link,$ims_check) or exit("IMS Check Query Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$ims_check_rows=mysqli_num_rows($ims_check_result);
			
			if($ims_check_rows==0)
			{
				/*Inserting data into Ims log*/
				$insert_imslog="insert into $bai_pro3.ims_log (ims_date,ims_cid,ims_doc_no,ims_mod_no,ims_shift,
				ims_size,ims_qty,ims_log_date,ims_style,ims_schedule,ims_color,rand_track,bai_pro_ref,input_job_rand_no_ref,input_job_no_ref,pac_tid,ims_remarks,operation_id) values ('".$ims_date."','".$cat_ref."','".$row['docket_number']."','".$row['assigned_module']."','".$row['shift']."','".trim($sizevalue)."','".$row['recevied_qty']."','".$row['date_time']."','".$row['style']."','".$row['schedule']."','".$row['color']."','".$row['id']."','".$bundle_op_id."','".$row['input_job_no_random_ref']."','".$row['input_job_no']."','".$row['bundle_number']."','".STRTOUPPER($remarks_ref)."','".$row['operation_id']."')";
				echo "Insert Ims log :".$insert_imslog."</br>";
				$qry_status=mysqli_query($link,$insert_imslog) or exit("IMS Insert Query Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				if($qry_status)
				{
					echo "Inserted into ims_log table successfully<br>";
					// /*update sync_status into 1*/
					$update_sync="UPDATE $brandix_bts.bundle_creation_data_temp SET sync_status='1' WHERE id=".$row['id'];
					$qry_status1=mysqli_query($link,$update_sync);
					if($qry_status1)
					{
						echo "Updated bundle_creation_data table successfully<br>";
					}
				}
			}
			else
			{
				$update_imslog="update $bai_pro3.ims_log set ims_qty=ims_qty+".$row['recevied_qty']." where bai_pro_ref='".$bundle_op_id."'";
				echo "Update Ims log :".$update_imslog."<br>";
				$qry_status=mysqli_query($link,$update_imslog) or exit("IMS Insert Query Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				if($qry_status)
				{
					echo "Inserted into ims_log table successfully<br>";
					// /*update sync_status into 1*/
					$update_sync="UPDATE $brandix_bts.bundle_creation_data_temp SET sync_status='1' WHERE id=".$row['id'];
					$qry_status1=mysqli_query($link,$update_sync);
					if($qry_status1)
					{
						echo "Updated bundle_creation_data table successfully<br>";
					}
				}
			}			
		}				
	}
	
	$bundles_qry="select *,DATE(date_time) as date_ref,HOUR(date_time) as hour_ref FROM $brandix_bts.bundle_creation_data_temp WHERE (operation_id='101' or operation_id='130') AND sync_status=0";
	$bundles_qry_result=mysqli_query($link,$bundles_qry) or exit("Bundles Query Error17".mysqli_error($GLOBALS["___mysqli_ston"]));	
	if(mysqli_num_rows($bundles_qry_result)>0)
	{
		while($row = mysqli_fetch_array($bundles_qry_result))
		{			
			//$sizevalue="size_s".sprintf ("%02d\n",$row['size_id']);
			$sizevalue="size_".$row['size_id'];
			$bac_dat=date('Y-m-d', strtotime($row['scanned_date']));
			$log_time=date("Y-m-d");
			$bun_id=$row['id'];
			
			/*For our identification/unique we maintain bundle no and operation id */
			$bundle_op_id=$row['bundle_number']."-".$row['operation_id']."-".$row['input_job_no']."-".$row['id'];
			
			/*getting buyer division from bai orders db*/
			$buyer_qry="select order_div FROM $bai_pro3.bai_orders_db WHERE order_style_no='".$row['style']."' AND order_del_no='".$row['schedule']."' AND order_col_des='".$row['color']."'";
			$buyer_qry_result=mysqli_query($link,$buyer_qry) or exit("Bundles Query Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($buyer_qry_row=mysqli_fetch_array($buyer_qry_result)){
					$buyer_div=str_replace("'","",(str_replace('"',"",$buyer_qry_row['order_div'])));
				}
			/*getting sections from section db by assign module*/
			$sections_qry="select sec_id,sec_head FROM $bai_pro3.sections_db WHERE sec_id>0 AND  sec_mods LIKE '%,".$row['assigned_module'].",%' OR  sec_mods LIKE '".$row['assigned_module'].",%' LIMIT 0,1";
			$sections_qry_result=mysqli_query($link,$sections_qry) or exit("Bundles Query Error15".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($buyer_qry_row=mysqli_fetch_array($sections_qry_result)){
					$sec_head=$buyer_qry_row['sec_id'];
			}
				
			/*Getting number of operators fro bai_pro.pro_atten*/
			$qry_nop="select avail_A,avail_B FROM $bai_pro.pro_atten WHERE module=".$row['assigned_module']." AND date='$bac_dat'";
			$qry_nop_result=mysqli_query($link,$qry_nop) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
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
			) values ('".$row['assigned_module']."','".$sec_head."','".$row['recevied_qty']."','".$row['date_ref']." ".$row['hour_ref'].":00:00"."','".$bac_dat."','".$row['shift']."','".$row['style']."','Active','".$log_time."','".$buyer_div."','".$row['schedule']."','".$row['color']."','".$row['scanned_user']."','".$row['docket_number']."','".$row['sfcs_smv']."','".$row['recevied_qty']."','ims_log','".$bundle_op_id."','".$nop."','".$bundle_op_id."','".$row['operation_id']."','".$row['input_job_no']."')";
			echo "Bai log : ".$insert_bailog."</br>";
			$qry_status=mysqli_query($link,$insert_bailog) or exit("BAI Log Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			if($qry_status)
			{
				echo "Inserted into bai_log table successfully<br>";
				/*Insert same data into bai_pro.bai_log_buf table*/
				$insert_bailogbuf="insert into $bai_pro.bai_log_buf (bac_no,bac_sec,bac_Qty,bac_lastup,bac_date,
				bac_shift,bac_style,bac_stat,log_time,buyer,delivery,color,loguser,ims_doc_no,smv,".$sizevalue.",ims_table_name,ims_tid,nop,ims_pro_ref,ope_code,jobno
				) values ('".$row['assigned_module']."','".$sec_head."','".$row['recevied_qty']."','".$row['date_ref']." ".$row['hour_ref'].":00:00"."','".$bac_dat."','".$row['shift']."','".$row['style']."','Active','".$log_time."','".$buyer_div."','".$row['schedule']."','".$row['color']."','".$row['scanned_user']."','".$row['docket_number']."','".$row['sfcs_smv']."','".$row['recevied_qty']."','ims_log','".$bundle_op_id."','".$nop."','".$bundle_op_id."','".$row['operation_id']."','".$row['input_job_no']."')";
				echo "</br>Insert Bailog buf: ".$insert_bailogbuf."</br>";
				$qrybuf_status=mysqli_query($link,$insert_bailogbuf) or exit("BAI Log Buf Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				if($qrybuf_status)
				{
					echo "Inserted into bai_log_buf table successfully<br>";
				}
				
				/*Getting updated operation id bundle num and sequence*/
				$qry_opid="select * FROM $brandix_bts.bundle_creation_data_temp WHERE bundle_number='".$row['bundle_number']."' AND id <'".$bun_id."'  ORDER BY id DESC LIMIT 0,1";
				//echo "getting id :".$qry_opid."</br>";
				$qry_opid_result=mysqli_query($link,$qry_opid) or exit("Bundles Query Error13".mysqli_error($GLOBALS["___mysqli_ston"]));	;
				while($qry_opid_row=mysqli_fetch_array($qry_opid_result))
				{
					$updt_bundle_opid=$qry_opid_row['bundle_number']."-".$qry_opid_row['operation_id']."-".$qry_opid_row['input_job_no']."-".$qry_opid_row['id'];
				}
				
				/*update sync_status into 1*/
				// $update_sync="UPDATE brandix_bts.bundle_creation_data_temp SET sync_status='1' WHERE id=".$row['id'];
				// $qry_status1=mysqli_query($link,$update_sync) or exit("Bundles Query Error12".mysqli_error($GLOBALS["___mysqli_ston"]));		
				// if($qry_status1)
				// {
					// echo "Updated bundle_creation_data table successfully<br>";
				// }				
			}	
		}				
	}
	
	
	$bundles_output_sql="select * FROM $brandix_bts.bundle_creation_data_temp WHERE (operation_id='130' or operation_id='101') AND sync_status=0";
	$bundles_output_sql_result=mysqli_query($link,$bundles_output_sql) or exit("Bundles Query Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row = mysqli_fetch_array($bundles_output_sql_result))
	{
		$style=$sql_row['style'];
		$schedule=$sql_row['schedule'];
		$color=$sql_row['color'];
		$bundle_number=$sql_row['bundle_number'];
		$input_job_no_random_ref=$sql_row['input_job_no_random_ref'];
		$input_job_no=$sql_row['input_job_no'];
		$operation_id=$sql_row['operation_id'];
		$assigned_module=$sql_row['assigned_module'];
		$remarks=$sql_row['remarks'];
		$reported_qty=$sql_row['recevied_qty'];
		$orginal_reported_qty=$reported_qty;
		$size_id=$sql_row["size_id"];
		if($remarks=="Normal")
		{
			$remarks="Nil";
		}
		$tran_id=$sql_row["id"];
		
		
		
		$prev_ops="select operation_code FROM $brandix_bts.tbl_style_ops_master WHERE style='".$style."' AND COLOR='".$color."' AND operation_code<'".$operation_id."' ORDER BY operation_code DESC LIMIT 1";
		$prev_ops_sql_result=mysqli_query($link,$prev_ops) or exit("Bundles Query Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($prev_ops_row = mysqli_fetch_array($prev_ops_sql_result))
		{
			$prevs_op_code=$prev_ops_row["operation_code"];
		}
		
		echo $prevs_op_code."<br>";		
		
		$bundle_op_id1=$sql_row['bundle_number']."-".$prevs_op_code."-".$sql_row['input_job_no']."-".$sql_row['assigned_module']."-".$sql_row['remarks'];
		
		$update_ims_pro_log="update $bai_pro3.ims_log set ims_pro_qty=ims_pro_qty+".$sql_row['recevied_qty']." where bai_pro_ref='".$bundle_op_id1."'";
		echo $update_ims_pro_log."<br>";
		$qry_status=mysqli_query($link,$update_ims_pro_log) or exit("IMS Pro Update Query Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($qry_status)
		{
			echo "Inserted into ims_log table successfully<br>";
			// /*update sync_status into 1*/
			$update_sync="UPDATE $brandix_bts.bundle_creation_data_temp SET sync_status='1' WHERE id=".$tran_id;
			$qry_status1=mysqli_query($link,$update_sync);
			if($qry_status1)
			{
				echo "Updated bundle_creation_data table successfully<br>";
			}
		}		
	}	
	
	$ims_status="update $bai_pro3.ims_log set ims_status=\"DONE\" where ims_qty=ims_pro_qty";
	mysqli_query($link,$ims_status) or exit("Bundles Query Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$ims_status="update $bai_pro3.ims_log set ims_status=\"\" where ims_qty!=ims_pro_qty";
	mysqli_query($link,$ims_status) or exit("Bundles Query Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	// $ims_status_1="update $bai_pro3.ims_log_backup set ims_status=\"NULL\" where ims_qty!=ims_pro_qty";
	// mysqli_query($link,$ims_status_1) or exit("Bundles Query Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	// $ims_backup="insert ignore into $bai_pro3.ims_log_backup select * from bai_pro3.ims_log where ims_status=\"DONE\"";
	// mysqli_query($link,$ims_backup) or exit("Bundles Query Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	// $ims_backup_2="insert ignore into $bai_pro3.ims_log select * from bai_pro3.ims_log_backup where ims_status!=\"DONE\"";
	// mysqli_query($link,$ims_backup_2) or exit("Bundles Query Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	// $ims_delete="delete from $bai_pro3.ims_log where ims_status=\"DONE\"";
	// mysqli_query($link,$ims_delete) or exit("Bundles Query Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	// $ims_delete_2="delete from $bai_pro3.ims_log_backup where ims_status!=\"DONE\"";
	// mysqli_query($link,$ims_delete_2) or exit("Bundles Query Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	echo memory_get_usage();
	$end_timestamp = microtime(true);
	$duration = $end_timestamp - $start_timestamp;
	print("Execution took ".$duration." milliseconds.")."\n";	
// ?>