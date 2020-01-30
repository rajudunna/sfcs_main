<?php
/*
	=========== Create By Chandu =============
	Created at : 08-09-2018
	Updated at : 11-09-2018
	Input : Call SOAP URL.
	Output : Save the response in mo_details,order_details&shipment_plan tables in m3_inputs database.
*/
$start_timestamp = microtime(true);
print("\n mo_soad_api_call file start : ".$start_timestamp." milliseconds.")."\n";
$total_api_calls_duration=0;
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
set_time_limit(6000000);

	error_reporting(E_ALL);
	$headerbody = array("user"=>$api_username,"password"=>$api_password,"company"=>$company_no);
	$header = new SOAPHeader("http://lawson.com/ws/credentials", "lws", $headerbody);
	$soap_client = new SoapClient( $api_hostname.":".$api_port_no.$mo_soap_api,array("login" => $api_username,"password" => $api_password));
	$soap_client->__setSoapHeaders($header);
	try{
		$to = date('Ymd',  strtotime('+3 month'));
		$from = date('Ymd',  strtotime('-1 month'));

		$mosc1=microtime(true);
		print("Soap Call  Start :".$mosc1." Milliseconds. Parameters: (Facility->".$global_facility_code.";FromDate->".$from.";ToDate->".$to.")")."\n";
		$result2 = $soap_client->MOData(array('Facility'=>$global_facility_code,'FromDate'=>$from,'ToDate'=>$to));
		$mosc2=microtime(true);
		print("Soap Call  End :".$mosc2." Milliseconds")."\n";
		$total_api_calls_duration+=$mosc2-$mosc1;
		print("Soap Call Duration:".($mosc2-$mosc1)." Milliseconds")."\n";
		$call_count=1;
	 //	$new_ids = [];
		//echo "From Date:<b>".date('Y-m-d',strtotime($from))."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To date:<b>".date('Y-m-d',strtotime($to))."</b><br/>";
		//echo "<table>";
		//echo "<tr><th>S.NO</th><th>MONUMBER</th><th>MOQTY</th><th>STARTDATE</th><th>VPO</th><th>COLORNAME</th><th>COLOURDESC</th><th>SIZENAME</th><th>SIZEDESC</th><th>ZNAME</th><th>ZDESC</th><th>SCHEDULE</th><th>STYLE</th><th>PRODUCT</th><th>PRDNAME</th><th>PRDDESC</th><th>REFERENCEORDER</th><th>REFORDLINE</th><th>MOSTS</th><th>MAXOPERATIONSTS</th><th>COPLANDELDATE</th><th>COREQUESTEDDELDATE</th><th>SIZECODE</th><th>COLORCODE</th><th>ZCODE</th></tr>";
		foreach(($result2->new1Collection)->new1Item as $value){
			// echo "<tr>";
			// 	echo "<td>".$i++."</td>";
			// 	echo "<td>".$value->MONUMBER."</td>";
			// 	echo "<td>".$value->MOQTY."</td>";
			// 	echo "<td>".$value->STARTDATE."</td>";
			// 	echo "<td>".$value->VPO."</td>";
			// 	echo "<td>".$value->COLORNAME."</td>";
			// 	echo "<td>".$value->COLOURDESC."</td>";
			// 	echo "<td>".$value->SIZENAME."</td>";
			// 	echo "<td>".$value->SIZEDESC."</td>";
			// 	echo "<td>".$value->ZNAME."</td>";
			// 	echo "<td>".$value->ZDESC."</td>";
			// 	echo "<td>".$value->SCHEDULE."</td>";
			// 	echo "<td>".$value->STYLE."</td>";
			// 	echo "<td>".$value->PRODUCT."</td>";
			// 	echo "<td>".$value->PRDNAME."</td>";
			// 	echo "<td>".$value->PRDDESC."</td>";
			// 	echo "<td>".$value->REFERENCEORDER."</td>";
			// 	echo "<td>".$value->REFORDLINE."</td>";
			// 	echo "<td>".$value->MOSTS."</td>";
			// 	echo "<td>".$value->MAXOPERATIONSTS."</td>";
			// 	echo "<td>".$value->COPLANDELDATE."</td>";
			// 	echo "<td>".$value->COREQUESTEDDELDATE."</td>";
			// 	echo "<td>".$value->SIZECODE."</td>";
			// 	echo "<td>".$value->COLORCODE."</td>";
			// 	echo "<td>".$value->ZCODE."</td>";
			// echo "</tr>";

			$mo_number=trim($value->MONUMBER);
			$basic_auth = base64_encode($api_username.':'.$api_password);
			
			$moac1=microtime(true);
			$args=$api_hostname.":".$api_port_no.'/m3api-rest/execute/OIS100MI/GetLine?CONO='.$company_no.'&ORNO='.$value->REFERENCEORDER.'&PONR='.$value->REFORDLINE.'&PONR='.$value->REFORDLINE.','.$basic_auth;
			print("rest_call $call_count API Call Start: ".$moac1." milliseconds. Parameters: ".$args."; ")."\n";
			
			$rest_call = getCurlAuthRequestLocal($api_hostname.":".$api_port_no.'/m3api-rest/execute/OIS100MI/GetLine?CONO='.$company_no.'&ORNO='.$value->REFERENCEORDER.'&PONR='.$value->REFORDLINE,$basic_auth);
			
			$moac2=microtime(true);
			print("rest_call $call_count API call End : ".$moac2."milliseconds")."\n";
			$total_api_calls_duration+=$moac2-$moac1;
			print("rest_call $call_count API call Duration : ".($moac2-$moac1)."milliseconds")."\n";

				//1940 exclude mo's whcih are having status 99
				if($rest_call['response']['ORST'] !='99'){

						if($rest_call['status'] && isset($rest_call['response']['ITNO']) && $rest_call['response']['ITNO']!=''){
							
							$moac3=microtime(true);
							$args1=$api_hostname.":".$api_port_no.'/m3api-rest/execute/MDBREADMI/GetMITMASX1?CONO='.$company_no.'&ITNO='.urlencode($rest_call['response']['ITNO']).','.$basic_auth;
							print("get_buyer_details $call_count API Call Start: ".$moac3." milliseconds. Parameters: ".$args1."; ")."\n";
							
							$get_buyer_details = getCurlAuthRequestLocal($api_hostname.":".$api_port_no.'/m3api-rest/execute/MDBREADMI/GetMITMASX1?CONO='.$company_no.'&ITNO='.urlencode($rest_call['response']['ITNO']),$basic_auth);
							
							$moac4=microtime(true);
							print("get_buyer_details $call_count API call End : ".$moac4."milliseconds")."\n";
							$total_api_calls_duration+=$moac4-$moac3;
							print("get_buyer_details $call_count API call Duration : ".($moac4-$moac3)."milliseconds")."\n";

							$last_buyer_details = ['status'=>false];
							if($get_buyer_details['status'] && isset($get_buyer_details['response']['BUAR']) && $get_buyer_details['response']['BUAR']!=''){
								
								$moac5=microtime(true);
								$args=$api_hostname.":".$api_port_no.'/m3api-rest/execute/CRS036MI/LstBusinessArea?CONO='.$company_no.'&FRBU='.$get_buyer_details['response']['BUAR'].'&TOBU='.$get_buyer_details['response']['BUAR'].','.$basic_auth;
								print("last_buyer_details $call_count API Call Start: ".$moac5." milliseconds. Parameters: ".$args."; ")."\n";
							
								$last_buyer_details = getCurlAuthRequestLocal($api_hostname.":".$api_port_no.'/m3api-rest/execute/CRS036MI/LstBusinessArea?CONO='.$company_no.'&FRBU='.$get_buyer_details['response']['BUAR'].'&TOBU='.$get_buyer_details['response']['BUAR'],$basic_auth);

								$moac6=microtime(true);
								print("last_buyer_details $call_count API call End : ".$moac6."milliseconds")."\n";
								$total_api_calls_duration+=$moac6-$moac5;
								print("last_buyer_details $call_count API call Duration : ".($moac6-$moac5)."milliseconds")."\n";

							}
							if($last_buyer_details['status'] && isset($last_buyer_details['response']['TX40']) && $last_buyer_details['response']['TX40']!='')
							{

								$sql_mo_check_qry="select MONUMBER FROM $m3_inputs.mo_details WHERE MONUMBER ='$mo_number'";
								$result_check_mo = $link->query($sql_mo_check_qry);
								if(($result_check_mo->num_rows) == 0)
								{
									$ins_qry = "INSERT  INTO `m3_inputs`.`mo_details` (`MONUMBER`, `MOQTY`, `STARTDATE`, `VPO`, `COLORNAME`, `COLOURDESC`, `COLORCODE`, `SIZENAME`, `SIZEDESC`, `SIZECODE`, `ZNAME`, `ZDESC`, `ZCODE`,`SCHEDULE`, `STYLE`, `PRODUCT`, `PRDNAME`, `PRDDESC`, `REFERENCEORDER`, `REFORDLINE`, `MOSTS`, `MAXOPERATIONSTS`, `COPLANDELDATE`, `COREQUESTEDDELDATE`,`packing_method`,`destination`,`cpo`,`buyer_id`) VALUES ('".$mo_number."','".$value->MOQTY."','".date('Y-m-d',strtotime($value->STARTDATE))."','".$value->VPO."','".trim($value->COLORNAME)."','".trim($value->COLOURDESC)."','".trim($value->COLORCODE)."','".$value->SIZENAME."','".$value->SIZEDESC."','".$value->SIZECODE."','".$value->ZNAME."','".$value->ZDESC."','".$value->ZCODE."','".$value->SCHEDULE."','".$value->STYLE."','".$value->PRODUCT."','".$value->PRDNAME."','".$value->PRDDESC."','".$value->REFERENCEORDER."','".$value->REFORDLINE."','".$value->MOSTS."','".$value->MAXOPERATIONSTS."','".date('Y-m-d',strtotime($value->COPLANDELDATE))."','".date('Y-m-d',strtotime($value->COREQUESTEDDELDATE))."','".$rest_call['response']['TEPA']."','".$rest_call['response']['ADID']."','".$rest_call['response']['CUOR']."','".$last_buyer_details['response']['TX40']."')";
									$ins_qry1 = "INSERT  INTO bai_pro3.`mo_details`(`date_time`, `mo_no`, `mo_quantity`, `style`, `schedule`, `color`, `size`, `destination`, `zfeature`, `item_code`, `ops_master_status`, `product_sku`,packing_method,cpo,buyer_id,material_master_status,shipment_master_status) VALUES ('".date('Y-m-d H:i:s')."','".$mo_number."','".$value->MOQTY."','".$value->STYLE."','".$value->SCHEDULE."','".trim($value->COLOURDESC)."','".$value->SIZENAME."','".$rest_call['response']['ADID']."','".$value->ZNAME."','','','".$value->PRODUCT."','".$rest_call['response']['TEPA']."','".$rest_call['response']['CUOR']."','".$last_buyer_details['response']['TX40']."',0,0)";
									$result = mysqli_query($link, $ins_qry) or exit("Sql Error Insert m3_inputs.mo_details".mysqli_error($GLOBALS["___mysqli_ston"]));
									$result1 = mysqli_query($link, $ins_qry1) or exit("Sql Error Insert bai_pro3.mo_details".mysqli_error($GLOBALS["___mysqli_ston"]));
								}
							}
						}
			}else{

				//validate that particular mo already layplan created or not,if yes dont delete that MO
				$qry_validat_layplan="SELECT * FROM `bai_pro3`.`bai_orders_db_confirm` WHERE order_style_no='$value->STYLE' AND order_del_no='$value->SCHEDULE' AND order_col_des='$value->COLOURDESC'";
				$result_qry_validat_layplan = $link->query($qry_validat_layplan);

				if(($result_qry_validat_layplan->num_rows) <= 0){
					
					//delete queries  for if already inserted records exists in mo details and  bom details
					$mo_details_delete1="DELETE FROM bai_pro3.`mo_details` WHERE mo_no ='$mo_number'";
					$mo_details_delete1_result = mysqli_query($link, $mo_details_delete1) or exit("Sql Error delete bai_pro3.mo_details".mysqli_error($GLOBALS["___mysqli_ston"]));

					$mo_details_delete2="DELETE FROM `m3_inputs`.`mo_details` WHERE MONUMBER ='$mo_number'";
					$mo_details_delete2_result = mysqli_query($link, $mo_details_delete2) or exit("Sql Error delete m3_inputs.mo_details".mysqli_error($GLOBALS["___mysqli_ston"]));

					$bom_details_delete="DELETE FROM `m3_inputs`.`bom_details` WHERE mo_no='$mo_number'";
					$bom_details_delete_result = mysqli_query($link, $bom_details_delete) or exit("Sql Error delete m3_inputs.mo_details".mysqli_error($GLOBALS["___mysqli_ston"]));

					//Deleted mo's track here 
					$insert_deleted_mos="INSERT INTO `m3_inputs`.`deleted_mos`(`mo_number`,`orts_status`,`updated_date`) VALUES ('$mo_number','".$rest_call['response']['ORST']."','".date('Y-m-d H:i:s')."')";
					$insert_deleted_mos_result = mysqli_query($link, $insert_deleted_mos) or exit("Sql Error Insert m3_inputs.deleted_mos".mysqli_error($GLOBALS["___mysqli_ston"])); 
				}

			}
		}
		echo "</table>";
	}
	catch(Exception $e){
		var_dump($e->getMessage());
	}

	function getCurlAuthRequestLocal($url,$basic_auth){
		$include_path=getenv('config_job_path');
		include_once($include_path.'\sfcs_app\common\config\rest_api_calls.php'); 
		$obj1 = new rest_api_calls();
		try{ 
			$val = $obj1->getCurlAuthRequest($url);  
			$response = json_decode($val,true);
			$res = [];
			if(count($response)>0 && isset($response['MIRecord'][0]['NameValue']) && count($response['MIRecord'][0]['NameValue'])>0){
				foreach($response['MIRecord'][0]['NameValue'] as $fields){
					$res[$fields['Name']] = $fields['Value'];
				}
				return ['status'=>true,'response'=>$res];
			}else{
				return ['status'=>false,'response'=>'No data found.'];
			}
			
		}catch(Exception $err){
			return ['status'=>false,'response'=>'Error: '.$err];
		}
		
	}
	print("\n mo_soad_api_call file Total Api Calls Duration : ".$total_api_calls_duration." milliseconds.")."\n";
	$end_timestamp = microtime(true);
	$duration=$end_timestamp-start_timestamp;
	print("mo_soad_api_call file End : ".$end_timestamp." milliseconds.")."\n";
	print("mo_soad_api_call file total Duration : ".$duration." milliseconds.")."\n";
?>

