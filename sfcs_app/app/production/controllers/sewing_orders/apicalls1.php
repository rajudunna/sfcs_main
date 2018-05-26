<?php
error_reporting(0);


if(isset($_GET['bundlenumber']))
{
	$bundlenumber = $_GET['bundlenumber'];
	if($bundlenumber != '')
	{		
		getoperations($bundlenumber);
	}
}

function getoperations($bundlenumber){	
	header('Content-Type: application/json');
	$host = "10.227.220.238:3321";
	$user = "baiall";
	$password = "baiall";
	$database = "brandix_bts";

	$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_select_db($link, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));
	$bundle_number_exp = explode(',', $bundlenumber);
	$bundle_number = explode('-', $bundle_number_exp[0]);
	$sequence_no = $bundle_number[1]-1;
	$present_ops_validation = "SELECT recevied_qty FROM  bundle_creation_data LEFT JOIN tbl_orders_ops_ref ON tbl_orders_ops_ref.operation_code = bundle_creation_data.operation_id WHERE bundle_number =$bundle_number[0] AND operation_sequence =$bundle_number[1] AND operation_id = $bundle_number_exp[1]";
	//echo $present_ops_validation;
	$operations_result_present_ops_validation=mysqli_query($link, $present_ops_validation);
	$noofrows_ops = mysqli_num_rows($operations_result_present_ops_validation);		
	if($noofrows_ops > 0)
	{
		$row = mysqli_fetch_row($operations_result_present_ops_validation);
		$rec_qty = $row[0];
		if($rec_qty == 0)
		{
			$operations="SELECT operation_id,operation_name,original_qty,send_qty,recevied_qty,is_sewing_order,sewing_order FROM  bundle_creation_data LEFT JOIN tbl_orders_ops_ref ON tbl_orders_ops_ref.operation_code = bundle_creation_data.operation_id WHERE bundle_number =$bundle_number[0] AND operation_sequence =$bundle_number[1] AND operation_id = $bundle_number_exp[1]";
			//echo $operations;
			//"SELECT operation_id,operation_name,original_qty,send_qty,recevied_qty FROM  bundle_creation_data left join tbl_orders_ops_ref on tbl_orders_ops_ref.operation_code = bundle_creation_data.operation_id WHERE bundle_number =".$bundle_number[0]." and operation_sequence =".$bundle_number[1]."
			$operations_result=mysqli_query($link, $operations);
			$noofrows1 = mysqli_num_rows($operations_result);		
			if($noofrows1 > 0)
			{
				$row = mysqli_fetch_row($operations_result);
				if($row[5] == "Yes")
				{
					if($row[6] > 0)
					{
						$result['operation_id'] = $row[0];
						$result['operation_name'] = $row[1];
						$result['original_qty'] = $row[2];
						$result['send_qty'] = $row[3];
						$result['recevied_qty'] = $row[4];
					}
					else
					{
						$result['status'] = "Sewing order not yet generated for this bundle,Please create sewing order";
					}
				}
				else if($row[5] == "No")
				{
					$result['operation_id'] = $row[0];
					$result['operation_name'] = $row[1];
					$result['original_qty'] = $row[2];
					$result['send_qty'] = $row[3];
					$result['recevied_qty'] = $row[4];
				}
				else
				{
					$result['status'] = "Bundle Number is not valid / All operations scanned  with this bundle number";
				}
				
			}
			
		
		}
		else
		{
			$result['status'] = "This bundle already scanned for this operation.";
			
		}
	}
	else
	{
		$result['status'] = "Invalid Operation for this bundle.";
		
	}
		
	echo json_encode($result);
}

if(isset($_GET['reason']))
{

	header('Content-Type: application/json');
	$host = "10.227.220.238:3321";
	$user = "baiall";
	$password = "baiall";
	$database = "bai_pro3";

	$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_select_db($link, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

	$reasons="SELECT sno,reason_desc,rej_reason_code FROM  bai_qms_rejection_reason ORDER BY reason_order";
	$reasons_result=mysqli_query($link, $reasons) or exit("Error at getting rejection reasons".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($reasons_result);
	if($sql_num_check > 0){
		$reasons = array();
		$result = array();
		while ($row = mysqli_fetch_array($reasons_result)) {
			$result['id'] = $row['sno'];
			$result['text'] = $row['rej_reason_code']."-".$row['reason_desc'];
			array_push($reasons, $result);
		}
		echo json_encode($reasons);
	}
}

if(isset($_POST['submit']))
{
	$username = strtoupper($_SERVER['PHP_AUTH_USER']);
	$bundlenumber = $_POST['bundlenumber'];
	$operation = $_POST['operation'];
	$send_qty = $_POST['send_qty'];
	$operationid = $_POST['operationid'];
	$good = $_POST['good'];
	$bad = ($_POST['bad'])?$_POST['bad']:0;
	$missing = ($_POST['missing'])?$_POST['missing']:0;
	$remarks1 = $_POST['remarks'];
	$shift = $_POST['shift'];
	$noofreasons = $_POST['reason'];
	$panelnos = $_POST['panel'];
	$rejections = $_POST['rejection'];
	$rejection = "";
	if(sizeof($rejections)>0){		
		foreach ($rejections as $key => $rej) {
			$rejection.= $rej['reason']."-".$rej['panelno']."$";
		}
	}

	//header('Content-Type: application/json');
	$host = "10.227.220.238:3321";
	$user = "baiall";
	$password = "baiall";
	$database = "brandix_bts";

	$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_select_db($link, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

	$bundle_number = explode('-', $bundlenumber);
	$result = array();

	$qty = $bad+$missing;
	$scanned_user = "Sfcsproject1";	
	$current_date = date("Y-m-d H:i:s");

	
	//updating into bundle_creation_data send_qty and recevied_qty
	$updatescandata="UPDATE bundle_creation_data SET recevied_qty=".$good.", missing_qty=".$missing.", rejected_qty=".$bad.",scanned_date='".$current_date."',shift='".$shift."',scanned_user='".$scanned_user."' WHERE bundle_number =".$bundle_number[0]." AND operation_sequence =".$bundle_number[1]." AND operation_id =".$operationid." and recevied_qty=0";
	$updatescandata_result=mysqli_query($link, $updatescandata);

	if($updatescandata_result){
		//If there are any rejections the below code will execute
		$getmoduledetails = "SELECT assigned_module FROM  bundle_creation_data WHERE bundle_number =".$bundle_number[0]." and operation_sequence =".$bundle_number[1]." and operation_id =".$operationid." LIMIT 0,1";
			$getmoduledetails_result=mysqli_query($link, $getmoduledetails);
			$assigned_module = mysqli_fetch_row($getmoduledetails_result);
		if($qty>0){
			$getopcodedetails = "SELECT * FROM  bundle_creation_data WHERE bundle_number =".$bundle_number[0]." and operation_sequence =".$bundle_number[1]." and operation_id =".$operationid." LIMIT 0,1";
			$getopcodedetails_result=mysqli_query($link, $getopcodedetails);
			$sql_num_check1=mysqli_num_rows($getopcodedetails_result);
			if($sql_num_check1 >0){
				while($row = mysqli_fetch_array($getopcodedetails_result)){
					$subArray['tran_type'] = 3;
					$remarks = $row['assigned_module']."-".$shift."-P";
					$insertrejctions = "INSERT INTO bai_pro3.bai_qms_db (qms_style,qms_schedule,qms_color,log_user,log_date,qms_size,qms_qty,qms_tran_type,remarks,ref1,doc_no,cut_no,panel_nos,no_of_reasons,bundle_number) VALUES('".$row['style']."','".$row['schedule']."','".$row['color']."','".$username."',NOW(),'".$row['size_title']."',".$qty.",'3','".$remarks."','".$rejection."','".$row['docket_number']."','".$row['cut_number']."','".$panelnos."','".$noofreasons."','".$row['id']."')";						
					//echo $insertrejctions;
					$insertrejctions_result=mysqli_query($link, $insertrejctions);	
					if(!$insertrejctions_result){
						$updatescandata="UPDATE bundle_creation_data SET recevied_qty=0, missing_qty=0, rejected_qty=0,scanned_date=null,shift=null,scanned_user=null WHERE bundle_number =".$bundle_number[0]." AND operation_sequence =".$bundle_number[1]." AND operation_id =".$operationid;
						$updatescandata_result=mysqli_query($link, $updatescandata);
						$result = '<h3><span style="color:red;">Error inserting into bai_qms_db</span></h3><br/><a href="scan_emb_bundles.php">Go back to Scan Screen</a>';
						echo $result;
					}
				}
			}else{
				$updatescandata="UPDATE bundle_creation_data SET recevied_qty=0, missing_qty=0, rejected_qty=0,scanned_date=null,shift=null,scanned_user=null WHERE bundle_number =".$bundle_number[0]." AND operation_sequence =".$bundle_number[1]." AND operation_id =".$operationid;
				$updatescandata_result=mysqli_query($link, $updatescandata);
				$result = '<h3><span style="color:red;">Error at getting operation details from bundle_creation_data</span></h3><br/><a href="scan_emb_bundles.php">Go back to Scan Screen</a>';
				echo $result;
			}
		}
		//End of rejection insert code

		//Getting the next operation and updating send quantities.
		$getnextopcode = "SELECT operation_id FROM  bundle_creation_data WHERE bundle_number =".$bundle_number[0]." and operation_sequence =".$bundle_number[1]." and operation_id >".$operationid." and recevied_qty=0 LIMIT 0,1";
		$getnextopcode_result=mysqli_query($link, $getnextopcode);
		$sql_num_check=mysqli_num_rows($getnextopcode_result);		
		if($sql_num_check>0){
			$row = mysqli_fetch_row($getnextopcode_result);
			$updatenextoperationdata="UPDATE bundle_creation_data SET send_qty=".$good.",remarks='".$remarks1."',assigned_module='".$assigned_module[0]."' WHERE bundle_number =".$bundle_number[0]." AND operation_sequence = ".$bundle_number[1]." AND operation_id =".$row[0]." and recevied_qty=0";
			$updatenextoperationdata_result=mysqli_query($link, $updatenextoperationdata);
			if($updatenextoperationdata_result){
				//M3 tran log insertion Start
				$getopdesc = "SELECT default_operation FROM  tbl_orders_ops_ref WHERE operation_code =".$operationid;
				$getopdesc_result=mysqli_query($link, $getopdesc);
				$df = mysqli_fetch_row($getopdesc_result);
				if($df[0] == "Yes"){
					$getopcodedetails = "SELECT * FROM  bundle_creation_data WHERE bundle_number =".$bundle_number[0]." and operation_sequence =".$bundle_number[1]." and operation_id =".$operationid." LIMIT 0,1";
					$getopcodedetails_result=mysqli_query($link, $getopcodedetails);
					$sql_num_check1=mysqli_num_rows($getopcodedetails_result);
					if($sql_num_check1 >0){
						while($data = mysqli_fetch_array($getopcodedetails_result)){
							$size_id = $data['size_id'];
							$getsizecodeqry = "SELECT size_name FROM `tbl_orders_size_ref` WHERE id= $size_id";
							//echo $getsizecodeqry;
							$getsizecodeqry_result=mysqli_query($link, $getsizecodeqry);
							$data_size_id = mysqli_fetch_row($getsizecodeqry_result);
							//echo $data_size_id;
							$getopdesc = "SELECT operation_name FROM  tbl_orders_ops_ref WHERE operation_code =".$data['operation_id'];
							$getopdesc_result=mysqli_query($link, $getopdesc);
							$desc = mysqli_fetch_row($getopdesc_result);
							$insertM3Tranlog1 = "INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_reason,sfcs_remarks,sfcs_log_user,m3_op_code,sfcs_job_no,sfcs_mod_no,sfcs_shift,m3_op_des,sfcs_tid_ref) VALUES(NOW(),'".$data['style']."','".$data['schedule']."','".$data['color']."','".$data_size_id[0]."','".$data['size_title']."','".$data['docket_number']."','".$good."','','".$data['remarks']."','".$username."','".$data['operation_id']."','".$data['cut_number']."','".$data['assigned_module']."','".$shift."','".$desc[0]."','".$data['id']."')";
							
							$insertM3Tranlog_result1=mysqli_query($link, $insertM3Tranlog1);
							if($insertM3Tranlog_result1){
								if($qty >0){								
									if(sizeof($rejections)>0){	
										$flag = false;	
										foreach ($rejections as $key => $rej) 
										{
											$getopcode = "SELECT rej_reason_code FROM  bai_pro3.bai_qms_rejection_reason WHERE sno =".$rej['reason'];
											$getopcode_result=mysqli_query($link, $getopcode);
											$code = mysqli_fetch_row($getopcode_result);
											if($code[0] != "MI")
											{
												$insertM3Tranlog = "INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_reason,sfcs_remarks,sfcs_log_user,m3_op_code,sfcs_job_no,sfcs_mod_no,sfcs_shift,m3_op_des,sfcs_tid_ref) VALUES(NOW(),'".$data['style']."','".$data['schedule']."','".$data['color']."','".$data_size_id[0]."','".$data['size_title']."','".$data['docket_number']."','".$rej['panelno']."','".$code[0]."','".$data['remarks']."','".$username."','".$data['operation_id']."','".$data['cut_number']."','".$data['assigned_module']."','".$shift."','".$desc[0]."','".$data['id']."')";
												$insertM3Tranlog_result=mysqli_query($link, $insertM3Tranlog);
												$flag = ($insertM3Tranlog_result)?true:false;
											}										
										}
										if($flag){
											
											$schedule = $_POST['schedule'];
											$color = $_POST['color'];
											$style = $_POST['style'];
											$operation = $_POST['operation_id_po'];
											$operation_name = $_POST['operation_name'];
											$shift = $_POST['shift'];
											//die();
											header("Location: scan_emb_bundles.php?style=$style&schedule=$schedule&color=$color&operation=$operation&operation_name=$operation_name&shift=$shift&SUBMIT=Continue");
										}else{
											//if M3 update fails roll backing all updates
											$updatescandata="UPDATE bundle_creation_data SET recevied_qty=0, missing_qty=0, rejected_qty=0,scanned_date=null,shift=null,scanned_user=null WHERE bundle_number =".$bundle_number[0]." AND operation_sequence =".$bundle_number[1]." AND operation_id =".$operationid;
											$updatescandata_result=mysqli_query($link, $updatescandata);

											$updatenextoperationdata="UPDATE bundle_creation_data SET send_qty=".$send_qty.",remarks='',assigned_module='0' WHERE bundle_number =".$bundle_number[0]." AND operation_sequence = ".$bundle_number[1]." AND operation_id =".$row[0]." and recevied_qty=0";
											$updatenextoperationdata_result=mysqli_query($link, $updatenextoperationdata);

											$getopcodedetails = "SELECT id FROM  bundle_creation_data WHERE bundle_number =".$bundle_number[0]." and operation_sequence =".$bundle_number[1]." and operation_id =".$operationid." LIMIT 0,1";
											$getopcodedetails_result=mysqli_query($link, $getopcodedetails);
											$sql_num_check1=mysqli_num_rows($getopcodedetails_result);
											if($sql_num_check1 >0){
												$row = mysqli_fetch_row($getopcodedetails_result);
												$deleterejections ="delete from bai_pro3.bai_qms_db where bundle_number=".$row[0];	
												$deleterejections_result=mysqli_query($link, $deleterejections);	
											}					

											$result = '<h3><span style="color:red;">Error at updating in m3_tran_log,Please try again!!</span></h3><br/><a href="scan_emb_bundles.php">Go back to Scan Screen</a>';
											echo $result;
										}
									}
								}else{
									$schedule = $_POST['schedule'];
									$color = $_POST['color'];
									$style = $_POST['style'];
									$operation = $_POST['operation_id_po'];
									$operation_name = $_POST['operation_name'];
									$shift = $_POST['shift'];
									//die();
									header("Location: scan_emb_bundles.php?style=$style&schedule=$schedule&color=$color&operation=$operation&operation_name=$operation_name&shift=$shift&SUBMIT=Continue");
								}
							}else{
								$updatescandata="UPDATE bundle_creation_data SET recevied_qty=0, missing_qty=0, rejected_qty=0,scanned_date=null,shift=null,scanned_user=null WHERE bundle_number =".$bundle_number[0]." AND operation_sequence =".$bundle_number[1]." AND operation_id =".$operationid;
								$updatescandata_result=mysqli_query($link, $updatescandata);

								$updatenextoperationdata="UPDATE bundle_creation_data SET send_qty=".$send_qty.",remarks='',assigned_module='0' WHERE bundle_number =".$bundle_number[0]." AND operation_sequence = ".$bundle_number[1]." AND operation_id =".$row[0]." and recevied_qty=0";
								$updatenextoperationdata_result=mysqli_query($link, $updatenextoperationdata);
								
								$result = '<h3><span style="color:red;">Error at updating in m3_tran_log,Please try again!!</span></h3><br/><a href="scan_emb_bundles.php">Go back to Scan Screen</a>';
								echo $result;
							}							
						}
					}else{
						$schedule = $_POST['schedule'];
						$color = $_POST['color'];
						$style = $_POST['style'];
						$operation = $_POST['operation_id_po'];
						$operation_name = $_POST['operation_name'];
						$shift = $_POST['shift'];
						//die();
						header("Location: scan_emb_bundles.php?style=$style&schedule=$schedule&color=$color&operation=$operation&operation_name=$operation_name&shift=$shift&SUBMIT=Continue");
					}
				}else{
					$schedule = $_POST['schedule'];
					$color = $_POST['color'];
					$style = $_POST['style'];
					$operation = $_POST['operation_id_po'];
					$operation_name = $_POST['operation_name'];
					$shift = $_POST['shift'];
					//die();
					header("Location: scan_emb_bundles.php?style=$style&schedule=$schedule&color=$color&operation=$operation&operation_name=$operation_name&shift=$shift&SUBMIT=Continue");
				}			
				//M3 tran log insertion End
			}else{	
				$updatescandata="UPDATE bundle_creation_data SET recevied_qty=0, missing_qty=0, rejected_qty=0,scanned_date=null,shift=null,scanned_user=null WHERE bundle_number =".$bundle_number[0]." AND operation_sequence =".$bundle_number[1]." AND operation_id =".$operationid;
				$updatescandata_result=mysqli_query($link, $updatescandata);
				if($qty>0){
					$getopcodedetails = "SELECT id FROM  bundle_creation_data WHERE bundle_number =".$bundle_number[0]." and operation_sequence =".$bundle_number[1]." and operation_id =".$operationid." LIMIT 0,1";
					$getopcodedetails_result=mysqli_query($link, $getopcodedetails);
					$sql_num_check1=mysqli_num_rows($getopcodedetails_result);
					if($sql_num_check1 >0){
						$row = mysqli_fetch_row($getopcodedetails_result);
						$deleterejections ="delete from bai_pro3.bai_qms_db where bundle_number=".$row[0];						
						$deleterejections_result=mysqli_query($link, $deleterejections);	
					}
				}										
				$result = '<h3><span style="color:red;">Error at updating send_qty in bundle_creation_data</span></h3><br/><a href="scan_emb_bundles.php">Go back to Scan Screen</a>';
				echo $result;
			}
		}else{
			$schedule = $_POST['schedule'];
			$color = $_POST['color'];
			$style = $_POST['style'];
			$operation = $_POST['operation_id_po'];
			$operation_name = $_POST['operation_name'];
			$shift = $_POST['shift'];
			
			//M3 tran log insertion Start
				$getopdesc = "SELECT default_operation FROM  tbl_orders_ops_ref WHERE operation_code =".$operationid;
				$getopdesc_result=mysqli_query($link, $getopdesc);
				$df = mysqli_fetch_row($getopdesc_result);
				if($df[0] == "Yes"){
					$getopcodedetails = "SELECT * FROM  bundle_creation_data WHERE bundle_number =".$bundle_number[0]." and operation_sequence =".$bundle_number[1]." and operation_id =".$operationid." LIMIT 0,1";
					$getopcodedetails_result=mysqli_query($link, $getopcodedetails);
					$sql_num_check1=mysqli_num_rows($getopcodedetails_result);
					if($sql_num_check1 >0){
						while($data = mysqli_fetch_array($getopcodedetails_result)){
							$size_id = $data['size_id'];
							$getsizecodeqry = "SELECT size_name FROM `tbl_orders_size_ref` WHERE id= $size_id";
							//echo $getsizecodeqry;
							$getsizecodeqry_result=mysqli_query($link, $getsizecodeqry);
							$data_size_id = mysqli_fetch_row($getsizecodeqry_result);
							$getopdesc = "SELECT operation_name FROM  tbl_orders_ops_ref WHERE operation_code =".$data['operation_id'];
							$getopdesc_result=mysqli_query($link, $getopdesc);
							$desc = mysqli_fetch_row($getopdesc_result);
							$insertM3Tranlog1 = "INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_reason,sfcs_remarks,sfcs_log_user,m3_op_code,sfcs_job_no,sfcs_mod_no,sfcs_shift,m3_op_des,sfcs_tid_ref) VALUES(NOW(),'".$data['style']."','".$data['schedule']."','".$data['color']."','".$data_size_id[0]."','".$data['size_title']."','".$data['docket_number']."','".$good."','','".$data['remarks']."','".$username."','".$data['operation_id']."','".$data['cut_number']."','".$data['assigned_module']."','".$shift."','".$desc[0]."','".$data['id']."')";
							$insertM3Tranlog_result1=mysqli_query($link, $insertM3Tranlog1);
							if($insertM3Tranlog_result1){
								if($qty >0){								
									if(sizeof($rejections)>0){	
										$flag = false;	
										foreach ($rejections as $key => $rej) {
											$getopcode = "SELECT rej_reason_code FROM  bai_pro3.bai_qms_rejection_reason WHERE sno =".$rej['reason'];
											$getopcode_result=mysqli_query($link, $getopcode);
											$code = mysqli_fetch_row($getopcode_result);
											if($code[0] != "MI"){
												$insertM3Tranlog = "INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_reason,sfcs_remarks,sfcs_log_user,m3_op_code,sfcs_job_no,sfcs_mod_no,sfcs_shift,m3_op_des,sfcs_tid_ref) VALUES(NOW(),'".$data['style']."','".$data['schedule']."','".$data['color']."','".$data_size_id[0]."','".$data['size_title']."','".$data['docket_number']."','".$rej['panelno']."','".$code[0]."','".$data['remarks']."','".$username."','".$data['operation_id']."','".$data['cut_number']."','".$data['assigned_module']."','".$shift."','".$desc[0]."','".$data['id']."')";
												$insertM3Tranlog_result=mysqli_query($link, $insertM3Tranlog);
												$flag = ($insertM3Tranlog_result)?true:false;
											}										
										}
										if($flag){
											
											$schedule = $_POST['schedule'];
											$color = $_POST['color'];
											$style = $_POST['style'];
											$operation = $_POST['operation_id_po'];
											$operation_name = $_POST['operation_name'];
											$shift = $_POST['shift'];
											//die();
											header("Location: scan_emb_bundles.php?style=$style&schedule=$schedule&color=$color&operation=$operation&operation_name=$operation_name&shift=$shift&SUBMIT=Continue");
										}else{
											//if M3 update fails roll backing all updates
											$updatescandata="UPDATE bundle_creation_data SET recevied_qty=0, missing_qty=0, rejected_qty=0,scanned_date=null,shift=null,scanned_user=null WHERE bundle_number =".$bundle_number[0]." AND operation_sequence =".$bundle_number[1]." AND operation_id =".$operationid;
											$updatescandata_result=mysqli_query($link, $updatescandata);

											$updatenextoperationdata="UPDATE bundle_creation_data SET send_qty=".$send_qty.",remarks='',assigned_module='0' WHERE bundle_number =".$bundle_number[0]." AND operation_sequence = ".$bundle_number[1]." AND operation_id =".$operationid." and recevied_qty=0";
											$updatenextoperationdata_result=mysqli_query($link, $updatenextoperationdata);

											$getopcodedetails = "SELECT id FROM  bundle_creation_data WHERE bundle_number =".$bundle_number[0]." and operation_sequence =".$bundle_number[1]." and operation_id =".$operationid." LIMIT 0,1";
											$getopcodedetails_result=mysqli_query($link, $getopcodedetails);
											$sql_num_check1=mysqli_num_rows($getopcodedetails_result);
											if($sql_num_check1 >0){
												$row = mysqli_fetch_row($getopcodedetails_result);
												$deleterejections ="delete from bai_pro3.bai_qms_db where bundle_number=".$row[0];	
												$deleterejections_result=mysqli_query($link, $deleterejections);	
											}					

											$result = '<h3><span style="color:red;">Error at updating in m3_tran_log,Please try again!!</span></h3><br/><a href="scan_emb_bundles.php">Go back to Scan Screen</a>';
											echo $result;
										}
									}
								}else{
									$schedule = $_POST['schedule'];
									$color = $_POST['color'];
									$style = $_POST['style'];
									$operation = $_POST['operation_id_po'];
									$operation_name = $_POST['operation_name'];
									$shift = $_POST['shift'];
									//die();
									header("Location: scan_emb_bundles.php?style=$style&schedule=$schedule&color=$color&operation=$operation&operation_name=$operation_name&shift=$shift&SUBMIT=Continue");
								}
							}else{
								$updatescandata="UPDATE bundle_creation_data SET recevied_qty=0, missing_qty=0, rejected_qty=0,scanned_date=null,shift=null,scanned_user=null WHERE bundle_number =".$bundle_number[0]." AND operation_sequence =".$bundle_number[1]." AND operation_id =".$operationid;
								$updatescandata_result=mysqli_query($link, $updatescandata);

								$updatenextoperationdata="UPDATE bundle_creation_data SET send_qty=".$send_qty.",remarks='',assigned_module='0' WHERE bundle_number =".$bundle_number[0]." AND operation_sequence = ".$bundle_number[1]." AND operation_id =".$operationid." and recevied_qty=0";
								$updatenextoperationdata_result=mysqli_query($link, $updatenextoperationdata);
								
								$result = '<h3><span style="color:red;">Error at updating in m3_tran_log,Please try again!!</span></h3><br/><a href="scan_emb_bundles.php">Go back to Scan Screen</a>';
								echo $result;
							}							
						}
					}else{
						$schedule = $_POST['schedule'];
						$color = $_POST['color'];
						$style = $_POST['style'];
						$operation = $_POST['operation_id_po'];
						$operation_name = $_POST['operation_name'];
						$shift = $_POST['shift'];
						//die();
						header("Location: scan_emb_bundles.php?style=$style&schedule=$schedule&color=$color&operation=$operation&operation_name=$operation_name&shift=$shift&SUBMIT=Continue");
					}
				}else{
					$schedule = $_POST['schedule'];
					$color = $_POST['color'];
					$style = $_POST['style'];
					$operation = $_POST['operation_id_po'];
					$operation_name = $_POST['operation_name'];
					$shift = $_POST['shift'];
					//die();
					header("Location: scan_emb_bundles.php?style=$style&schedule=$schedule&color=$color&operation=$operation&operation_name=$operation_name&shift=$shift&SUBMIT=Continue");
				}			
				//M3 tran log insertion End
				
			//header("Location: scan_emb_bundles.php?style=$style&schedule=$schedule&color=$color&operation=$operation&operation_name=$operation_name&shift=$shift&SUBMIT=Continue");
		}
		//End of updating send qty of next operation
	}else{
		$result = '<h3><span style="color:red;">Error at updating qunatites in bundle_creation_data</span></h3><br/><a href="scan_emb_bundles.php">Go back to Scan Screen</a>';
		echo $result;
	}
}

?>