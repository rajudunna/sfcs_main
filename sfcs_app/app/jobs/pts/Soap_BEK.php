<?php
$start_timestamp = microtime(true);
set_time_limit(6000000);
    include('C:\xampp\htdocs\sfcs_app\common\config\config_jobs.php');
    
	include('Soap_Op_Update_bek.php');
	require ('SoapWsdlClasses.php');
	// error_reporting(0);
	// if(function_exists($_GET['f']))
	// {
	    // echo $_GET['f']($_GET['insert_id']);
	// }
	
	//function soapcall($insert_id)
	{
	
		
	
		
		
		function leading_zeros1($value, $places)
		{
			for($x = 1; $x <= $places; $x++){
				$ceiling = pow(10, $x);
				if($value < $ceiling){
					$zeros = $places - $x;
					for($y = 1; $y <= $zeros; $y++){
						$leading .= "0";
					}
					$x = $places + 1;
				}
			}
			$output = $leading . $value;
			return $output;
		}
		
		$sql = "select sfcs_color as ColorCode,sfcs_schedule as SchelduleCode,sfcs_style as StyleCode,m3_mo_no as MONumber,m3_size as SizeCode,sfcs_qty as Quantity,sfcs_shift as ShiftCode,sfcs_reason as ScrapReason,m3_op_des,sfcs_mod_no,m3_op_code,sfcs_tid as RemarkKey,sfcs_job_no as JobNumber,sfcs_date as TransactionDate,work_centre from $m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE sfcs_status IN (0,40) order by sfcs_tid*1 limit 500";
				
		// echo $sql."<br>";
	    $result = mysqli_query($link, $sql);
		$InputValue = array();
		$normal_ids = array();
		$scrap_ids = array();
		$data = array();
		if ($result->num_rows > 0) 
		{
			while($row = $result->fetch_assoc()) {
				$InputValue[] = $row;
				if($row['ScrapReason'] == ""){
					$normal_ids[] = $row['RemarkKey'];
				}
				if($row['ScrapReason'] != ""){
					$scrap_ids[] = $row['RemarkKey'];
				}
			}
			$count_of_ids = $result->num_rows;
			$normal_ids = json_encode($normal_ids);
			$scrap_ids = json_encode($scrap_ids);
			$insert_batch_log_sql = "INSERT INTO $m3_bulk_ops_rep_db.sfcs_to_m3_batch_log (no_of_records,normal_records_ids,scrap_records_ids) VALUES ($count_of_ids,'$normal_ids','$scrap_ids')";
			$data['count'] = $count_of_ids;
			mysqli_query($link, $insert_batch_log_sql);
			$Success_ids = array();
			$Error_ids = array();
			foreach($InputValue as $Key => $value){
				
				$ArrayOfInputValue = new ArrayOfInputValue();
				$ArrayOfInputValue->InputValue = $value;
				
				$InputData = new InputData();
				$InputData->FactoryCode = $facility_code;
				$InputData->UserName = "SFCS-".$facility_code;
				if($value['ScrapReason'] == ""){
					if((int)$value['Quantity'] > 0){
						$InputData->Application = "SFCSGoodPositive";
					}
					if((int)$value['Quantity'] < 0){
						$InputData->Application = "SFCSGoodNegative";
					}
				}
				if($value['ScrapReason'] != ""){
					if((int)$value['Quantity'] > 0){
						$InputData->Application = "SFCSScrapPositive";
					}
					if((int)$value['Quantity'] < 0){
						$InputData->Application = "SFCSScrapNegative";
					}
				}
				$InputData->ShiftCode = $value['ShiftCode'];
				$InputData->TransactionDate = $value['TransactionDate'];
				$InputData->JobNumber = $value['JobNumber'];
				$sfcs_mod_no=$value['sfcs_mod_no'];
				if($value['sfcs_mod_no']=='')
				{
					$sfcs_mod_no=1;
				}
				
				$InputData->DeviationWorkCenter = $value['work_centre'];
				// if($value['m3_op_des']=='ASPS' or $value['m3_op_des']=='ASPR')
				// {
					// $InputData->DeviationWorkCenter = $facility_code.$value['m3_op_des'].$sfcs_mod_no;
				// }
				// else
				// {
					// $InputData->DeviationWorkCenter = $facility_code.$value['m3_op_des'].str_pad("0",2,$sfcs_mod_no);
				// }
				$InputData->InputValues = $ArrayOfInputValue;
				// var_dump($InputData);
				// die();
				$OperationType = new OperationType();
				if($value['ScrapReason'] == ""){
					
					$UpdateM3 = new UpdateM3();
				   
					foreach($OperationType::$OperationTypeArray as $key => $val){
						if($key == (int)$value['m3_op_code']){
							$UpdateM3->type = $val;
						}
					}
					
					if((int)$value['Quantity'] > 0){
						$UpdateM3->action = "Actual";
					}
					if((int)$value['Quantity'] < 0){
						$UpdateM3->action = "Reversal";
					}
					$UpdateM3->inputData = $InputData;
				}
				
				if($value['ScrapReason'] != ""){
					
					$UpdateScrap = new UpdateScrap();
					foreach($OperationType::$OperationTypeArray as $key => $val){
						if($key == (int)$value['m3_op_code']){
							$UpdateScrap->type = $val;
						}
					}
					if((int)$value['Quantity'] > 0){
						$UpdateScrap->action = "Actual";
					}
					if((int)$value['Quantity'] < 0){
						$UpdateScrap->action = "Reversal";
					}
					$UpdateScrap->inputData = $InputData;
				}
				
				$RemarkKey = $value['RemarkKey'];
				$insert_log_sql = "INSERT INTO $m3_bulk_ops_rep_db.sfcs_to_m3_response_log (m3_sfcs_tran_log_id) VALUES ($RemarkKey)";
				echo $insert_log_sql."<br>";
				if (mysqli_query($link, $insert_log_sql)) {
					echo "Success in inserting into sfcs_to_m3_response_log<br>";
					$last_id = $link->insert_id;
					$PTSService = new PTSService();
					if($value['ScrapReason'] == ""){
						$response = $PTSService->UpdateM3($UpdateM3);
					}
					if($value['ScrapReason'] != ""){
						$response = $PTSService->UpdateScrap($UpdateScrap);
					}
					
					if(isset($response->detail)){
						$Error = $response->detail->FaultDetail->ErrorCode.'-'.$response->detail->FaultDetail->Message;
					}
					
					if(isset($response->UpdateM3Result)){
						if($response->UpdateM3Result->M3UpdateResult->HasError == true){
							$Error = $response->UpdateM3Result->M3UpdateResult->ErrorCode.'-'.$response->UpdateM3Result->M3UpdateResult->ErrorDescription;
						}
						if($response->UpdateM3Result->M3UpdateResult->IsSucess == true){
							$Error = "TRUE";
						}
						
					}
					if(isset($response->UpdateScrapResult)){
						if($response->UpdateScrapResult->M3UpdateResult->HasError == true){
							$Error = $response->UpdateScrapResult->M3UpdateResult->ErrorCode.'-'.$response->UpdateScrapResult->M3UpdateResult->ErrorDescription;
							// dd($Error);
						}
						if($response->UpdateScrapResult->M3UpdateResult->IsSucess == true){
							$Error = "TRUE";
						}
					}
					
					$m3_sfcs_tran_log_sql = "SELECT * from $m3_bulk_ops_rep_db.sfcs_to_m3_response_log where id = $last_id";
					// echo $m3_sfcs_tran_log_sql."<br>";
					$m3_sfcs_tran_log_id = $link->query($m3_sfcs_tran_log_sql);
					$m3_sfcs_tran_log_id = $m3_sfcs_tran_log_id->fetch_assoc();
					$m3_sfcs_tran_log_id = (int)$m3_sfcs_tran_log_id["m3_sfcs_tran_log_id"];
					if($Error == "TRUE"){
						$Success_ids[] =  $m3_sfcs_tran_log_id;
						$sql = "UPDATE m3_sfcs_tran_log SET m3_error_code='$Error',sfcs_status=30 WHERE sfcs_tid=$m3_sfcs_tran_log_id";
					}else{
						$Error_ids[] =  $m3_sfcs_tran_log_id;
						$sql = "UPDATE $m3_bulk_ops_rep_db.m3_sfcs_tran_log SET m3_error_code='$Error',sfcs_status=40 WHERE sfcs_tid=$m3_sfcs_tran_log_id";
					}
					if ($link->query($sql) === TRUE) {
						echo 'Successfully updated m3_sfcs_tran_log1!<br><br>';
					} else {
						return "Error updating record: " . $link->error;
					}
				} else {
					return "Error: " . $insert_log_sql . "<br>" . mysqli_error($link);
				}
			}
			$data['Success_ids'] = count($Success_ids);
			$data['Error_ids'] = count($Error_ids);
			return json_encode($data);
			echo '<br><strong>Code Executed Successfully!</strong><br>';
		} else {
			$insert_batch_log_sql = "INSERT INTO $m3_bulk_ops_rep_db.sfcs_to_m3_batch_log (no_of_records,normal_records_ids,scrap_records_ids) VALUES (0,'','')";
			mysqli_query($link, $insert_batch_log_sql);
			$data['count'] = 0;
			return json_encode($data);
			echo '<br><strong>Not Updated in "m3_sfcs_tran_log"</strong><br>';
		}
		
	}
    //return "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
		//$M3UpdateResult = new M3UpdateResult();
		
		// $UpdateM3Response = new UpdateM3Response();
		// $UpdateM3Response->UpdateM3Result = $response->UpdateM3Result;
		// var_dump($response);
		// die();
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
echo "Execution took ".$duration." milliseconds.";
?>
