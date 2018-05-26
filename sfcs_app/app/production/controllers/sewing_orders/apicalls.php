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

	$bundle_number = explode('-', $bundlenumber);
	$sequence_no = $bundle_number[1]-1;
	$operations="SELECT operation_id,operation_name,original_qty,send_qty,recevied_qty,is_sewing_order,sewing_order FROM  bundle_creation_data left join tbl_orders_ops_ref on tbl_orders_ops_ref.operation_code = bundle_creation_data.operation_id WHERE bundle_number =".$bundle_number[0]." and operation_sequence =".$bundle_number[1]." and recevied_qty>0";	

	$operations_result=mysqli_query($link, $operations);
	$noofrows1 = mysqli_num_rows($operations_result);		
	if($noofrows1 > 0){
		$resultArray = array();
		while($row = mysqli_fetch_array($operations_result)){
			if($row['is_sewing_order'] == "Yes"){
				if($row['sewing_order'] > 0){
					$result['operation_id'] = $row['operation_id'];
					$result['operation_name'] = $row['operation_name'];
					$result['original_qty'] = $row['original_qty'];
					$result['send_qty'] = $row['send_qty'];
					$result['recevied_qty'] = $row['recevied_qty'];					
				}else{
					$result['status'] = "Sewing order not yet generated for this bundle,Please create sewing order";
				}
			}else if($row['is_sewing_order'] == "No"){
				$result['operation_id'] = $row['operation_id'];
				$result['operation_name'] = $row['operation_name'];
				$result['original_qty'] = $row['original_qty'];
				$result['send_qty'] = $row['send_qty'];
				$result['recevied_qty'] = $row['recevied_qty'];
			}
			array_push($resultArray, $result);			
		}		
		echo json_encode($resultArray);
	}else{
		$result['status'] = "Bundle Number is not valid / All operations scanned  with this bundle number";
		echo json_encode($result);
	}	
}


if(isset($_GET['bundlenumber1']) && isset($_GET['operation']))
{
	$bundlenumber = $_GET['bundlenumber1'];
	$operation = $_GET['operation'];
	if($bundlenumber != '' && $operation != '')
	{		
		validateNextoperation($bundlenumber,$operation);
	}
}

function validateNextoperation($bundlenumber,$operation){	

	header('Content-Type: application/json');
	$host = "10.227.220.238:3321";
	$user = "baiall";
	$password = "baiall";
	$database = "brandix_bts";

	$bundle_number = explode('-', $bundlenumber);
	$operationid = $operation;
	$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_select_db($link, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

	$next_operation_details = "SELECT recevied_qty FROM bundle_creation_data WHERE bundle_number =".$bundle_number[0]." AND operation_sequence =".$bundle_number[1]." AND operation_id >".$operationid." limit 0,1";	
	$next_operation_details_result=mysqli_query($link, $next_operation_details);
	$rowscount = mysqli_fetch_row($next_operation_details_result);
	if($rowscount[0] != 0){
		$result['status'] = 'Next Operation is already scanned, Please unscan the next operation';			
	}else{
		$result['status'] = 0;	
	}
	echo json_encode($result);
}




if(isset($_POST['submit']))
{
	$username = strtoupper($_SERVER['PHP_AUTH_USER']);

	$bundlenumber = $_POST['bundlenumber'];
	$operationid = $_POST['operation'];
	
	$host = "10.227.220.238:3321";
	$user = "baiall";
	$password = "baiall";
	$database = "brandix_bts";

	$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_select_db($link, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

	$bundle_number = explode('-', $bundlenumber);


	$next_operation_details = "SELECT recevied_qty FROM bundle_creation_data WHERE bundle_number =".$bundle_number[0]." AND operation_sequence =".$bundle_number[1]." AND operation_id >".$operationid." limit 0,1";
	$next_operation_details_result=mysqli_query($link, $next_operation_details);
	$rowscount = mysqli_fetch_row($next_operation_details_result);
	if($rowscount[0] == 0){
		$get_operation_details = "SELECT * FROM bundle_creation_data WHERE bundle_number =".$bundle_number[0]." AND operation_sequence =".$bundle_number[1]." AND operation_id =".$operationid;
		$get_operation_details_result=mysqli_query($link, $get_operation_details);
		$sql_num_check=mysqli_num_rows($get_operation_details_result);
		if($sql_num_check > 0){
			while($row = mysqli_fetch_array($get_operation_details_result)){
				if($row['rejected_qty']>0){				
					//insert into qms_db_deleted
					$insertrejctions = "INSERT INTO bai_pro3.bai_qms_db_deleted SELECT * FROM bai_pro3.bai_qms_db WHERE bundle_number =".$row['id'];
					$insertrejctions_result=mysqli_query($link, $insertrejctions) or exit("Error at inserting QMS_DB_DELETED".mysqli_error($GLOBALS["___mysqli_ston"]));
					//delete from QMS_DB based on bundle number
					$deleterejections ="delete from bai_pro3.bai_qms_db where bundle_number=".$row['id'];
					$deleterejections_result=mysqli_query($link, $deleterejections) or exit("Error at deleting QMS_DB".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				//get data from m3 tran log based on sfcs_tid_ref
				$get_m3_data = "SELECT * FROM m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE sfcs_tid_ref =".$row['id']." AND m3_op_code =".$row['operation_id'];
				$get_m3_data_result=mysqli_query($link, $get_m3_data);
				$sql_num_check1=mysqli_num_rows($get_m3_data_result);
				if($sql_num_check1){
					//update m3 tran log
					while($data = mysqli_fetch_assoc($get_m3_data_result)){
						$insertM3Tranlog = "INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_reason,sfcs_remarks,sfcs_log_user,m3_op_code,sfcs_job_no,sfcs_mod_no,sfcs_shift,m3_op_des,sfcs_tid_ref) VALUES(NOW(),'".$data['sfcs_style']."','".$data['sfcs_schedule']."','".$data['sfcs_color']."','".$data['sfcs_size']."','".$data['sfcs_size']."','".$data['sfcs_doc_no']."','-".$data['sfcs_qty']."','".$data['sfcs_reason']."','".$data['sfcs_remarks']."','".$username."','".$data['m3_op_code']."','".$data['sfcs_job_no']."','".$data['sfcs_mod_no']."','".$data['sfcs_shift']."','".$data['m3_op_des']."','".$row['id']."')";
						$insertM3Tranlog_result=mysqli_query($link, $insertM3Tranlog) or exit("Error at inserting m3_sfcs_tran_log".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				}else{
					$result = '<h3><span style="color:red;">M3 records not found please contact IT team</span></h3><br/><a href="scan_emb_bundles1.php">Go back to Scan Screen</a>';
					echo $result;
				}

				//delete from bai_log
					$deletebailog ="delete from bai_pro.bai_log where ims_pro_ref='".$bundle_number[0]."-".$operationid."'";
					$deletebailog_result=mysqli_query($link, $deletebailog) or exit("Error at deleting bai_log".mysqli_error($GLOBALS["___mysqli_ston"]));

				//delete from bai_log_buff
					$deletebailog1 ="delete from bai_pro.bai_log_buf where ims_pro_ref='".$bundle_number[0]."-".$operationid."'";
					$deletebailog1_result=mysqli_query($link, $deletebailog1) or exit("Error at deleting bai_log_buff".mysqli_error($GLOBALS["___mysqli_ston"]));

				//update bundle creation data
				$updatescandata="UPDATE bundle_creation_data SET recevied_qty=0, missing_qty=0, rejected_qty=0, scanned_date=null,shift=null,scanned_user=null,sync_status=0 WHERE bundle_number =".$bundle_number[0]." AND operation_sequence =".$bundle_number[1]." AND operation_id =".$operationid." and recevied_qty>0";
				$updatescandata_result=mysqli_query($link, $updatescandata);
				header("Location: scan_emb_bundles1.php");
			}
		}else{
			$result = '<h3><span style="color:red;">Bundle number not found please try again</span></h3><br/><a href="scan_emb_bundles1.php">Go back to Scan Screen</a>';
			echo $result;
		}
	}else{
		$result = '<h3><span style="color:red;">Next Operation is already scanned, Please unscan the next operation</span></h3><br/><a href="scan_emb_bundles1.php">Go back to Scan Screen</a>';
			echo $result;
	}
}

?>