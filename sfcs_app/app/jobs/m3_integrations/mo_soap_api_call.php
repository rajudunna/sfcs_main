<?php
/*
	=========== Create By Chandu =============
	Created at : 08-09-2018
	Updated at : 11-09-2018
	Input : Call SOAP URL.
	Output : Save the response in mo_details,order_details&shipment_plan tables in m3_inputs database.
*/
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');


$log="";
$log.='<table border=1><tr><th>SL no</th><th>Query</th><th>Start Time</th><th>End Time</th><th>Difference</th></tr>';	
set_time_limit(6000000);

	// include($_SERVER['DOCUMENT_ROOT'].'/template/dbconf.php');
	error_reporting(E_ALL);
	//var_dump($link);
	$log.="<tr><th></th><th>SOAP CALL</th>";
	$msc1=microtime(true);
	$log.="<th>".$msc1."</th>";
	
	$headerbody = array("user"=>$api_username,"password"=>$api_password,"company"=>$company_no);
	$header = new SOAPHeader("http://lawson.com/ws/credentials", "lws", $headerbody);
	$soap_client = new SoapClient( $api_hostname.":".$api_port_no.$mo_soap_api,array("login" => $api_username,"password" => $api_password));
	$soap_client->__setSoapHeaders($header);
	try{
		$to = date('Ymd',  strtotime('+3 month'));
		$from = date('Ymd',  strtotime('-1 month'));
		//$from="20200422";
		//$to="20200422";
		$result2 = $soap_client->MOData(array('Facility'=>$global_facility_code,'FromDate'=>$from,'ToDate'=>$to));
		$msc2=microtime(true);
		$log.="<th>".$msc2."</th>";
		$msc3=$msc2-$msc1;
		$log.="<th>".$msc3."</th></tr>";
		$i=1;
		// $new_ids = [];
		echo "From Date:<b>".date('Y-m-d',strtotime($from))."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To date:<b>".date('Y-m-d',strtotime($to))."</b><br/>";
		// echo "<table>";
		// echo "<tr><th>S.NO</th><th>MONUMBER</th><th>MOQTY</th><th>STARTDATE</th><th>VPO</th><th>COLORNAME</th><th>COLOURDESC</th><th>SIZENAME</th><th>SIZEDESC</th><th>ZNAME</th><th>ZDESC</th><th>SCHEDULE</th><th>STYLE</th><th>PRODUCT</th><th>PRDNAME</th><th>PRDDESC</th><th>REFERENCEORDER</th><th>REFORDLINE</th><th>MOSTS</th><th>MAXOPERATIONSTS</th><th>COPLANDELDATE</th><th>COREQUESTEDDELDATE</th><th>SIZECODE</th><th>COLORCODE</th><th>ZCODE</th></tr>";
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
			$i++;
			$mo_number=trim($value->MONUMBER);
			$basic_auth = base64_encode($api_username.':'.$api_password);
			$log.="<tr><th>".$i."</th><th>".($api_hostname.":".$api_port_no.'/m3api-rest/execute/OIS100MI/GetLine?CONO='.$company_no.'&ORNO='.$value->REFERENCEORDER.'&PONR='.$value->REFORDLINE)."--To get ORST</th>";
			$msc4=microtime(true);
			$log.="<th>".$msc4."</th>";
			$rest_call = getCurlAuthRequestLocal($api_hostname.":".$api_port_no.'/m3api-rest/execute/OIS100MI/GetLine?CONO='.$company_no.'&ORNO='.$value->REFERENCEORDER.'&PONR='.$value->REFORDLINE,$basic_auth);
			$msc5=microtime(true);
			$log.="<th>".$msc5."</th>";
			$msc6=$msc5-$msc4;
			$log.="<th>".$msc6."</th></tr>";

			
				//1940 exclude mo's whcih are having status 99
				if($rest_call['response']['ORST'] !='99'){

						if($rest_call['status'] && isset($rest_call['response']['ITNO']) && $rest_call['response']['ITNO']!=''){

							$log.="<tr><th>".$i."</th><th>".($api_hostname.":".$api_port_no.'/m3api-rest/execute/MDBREADMI/GetMITMASX1?CONO='.$company_no.'&ITNO='.urlencode($rest_call['response']['ITNO']))."--To  get_buyer_details</th>";
							$msc7=microtime(true);
							$log.="<th>".$msc7."</th>";

							$get_buyer_details = getCurlAuthRequestLocal($api_hostname.":".$api_port_no.'/m3api-rest/execute/MDBREADMI/GetMITMASX1?CONO='.$company_no.'&ITNO='.urlencode($rest_call['response']['ITNO']),$basic_auth);
							$msc8=microtime(true);
							$log.="<th>".$msc8."</th>";
							$msc9=$msc8-$msc7;
							$log.="<th>".$msc9."</th></tr>";

							$last_buyer_details = ['status'=>false];
							if($get_buyer_details['status'] && isset($get_buyer_details['response']['BUAR']) && $get_buyer_details['response']['BUAR']!=''){

								$log.="<tr><th>".$i."</th><th>".($api_hostname.":".$api_port_no.'/m3api-rest/execute/CRS036MI/LstBusinessArea?CONO='.$company_no.'&FRBU='.$get_buyer_details['response']['BUAR'].'&TOBU='.$get_buyer_details['response']['BUAR'])."--To  last_buyer_details</th>";
								$msc10=microtime(true);
								$log.="<th>".$msc10."</th>";

								$last_buyer_details = getCurlAuthRequestLocal($api_hostname.":".$api_port_no.'/m3api-rest/execute/CRS036MI/LstBusinessArea?CONO='.$company_no.'&FRBU='.$get_buyer_details['response']['BUAR'].'&TOBU='.$get_buyer_details['response']['BUAR'],$basic_auth);

								$msc11=microtime(true);
								$log.="<th>".$msc11."</th>";
								$msc12=$msc11-$msc10;
								$log.="<th>".$msc12."</th></tr>";

							}
							if($last_buyer_details['status'] && isset($last_buyer_details['response']['TX40']) && $last_buyer_details['response']['TX40']!='')
							{

								$sql_mo_check_qry="select MONUMBER FROM $m3_inputs.mo_details WHERE MONUMBER ='$mo_number'";
								echo $sql_mo_check_qry."<br/>";
								$result_check_mo = $link->query($sql_mo_check_qry);
								if(($result_check_mo->num_rows) == 0)
								{
									$ins_qry = "INSERT INTO `m3_inputs`.`mo_details` (`MONUMBER`, `MOQTY`, `STARTDATE`, `VPO`, `COLORNAME`, `COLOURDESC`, `COLORCODE`, `SIZENAME`, `SIZEDESC`, `SIZECODE`, `ZNAME`, `ZDESC`, `ZCODE`,`SCHEDULE`, `STYLE`, `PRODUCT`, `PRDNAME`, `PRDDESC`, `REFERENCEORDER`, `REFORDLINE`, `MOSTS`, `MAXOPERATIONSTS`, `COPLANDELDATE`, `COREQUESTEDDELDATE`,`packing_method`,`destination`,`cpo`,`buyer_id`) VALUES ('".$mo_number."','".$value->MOQTY."','".date('Y-m-d',strtotime($value->STARTDATE))."','".$value->VPO."','".trim($value->COLORNAME)."','".trim($value->COLOURDESC)."','".trim($value->COLORCODE)."','".$value->SIZENAME."','".$value->SIZEDESC."','".$value->SIZECODE."','".$value->ZNAME."','".$value->ZDESC."','".$value->ZCODE."','".$value->SCHEDULE."','".$value->STYLE."','".$value->PRODUCT."','".$value->PRDNAME."','".$value->PRDDESC."','".$value->REFERENCEORDER."','".$value->REFORDLINE."','".$value->MOSTS."','".$value->MAXOPERATIONSTS."','".date('Y-m-d',strtotime($value->COPLANDELDATE))."','".date('Y-m-d',strtotime($value->COREQUESTEDDELDATE))."','".$rest_call['response']['TEPA']."','".$rest_call['response']['ADID']."','".$rest_call['response']['CUOR']."','".$last_buyer_details['response']['TX40']."')";
									
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
		// echo "</table>";
		
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
	$log.="<tr><th>".$i."</th><th>total job execution</th>";
	$log.="<th>".$start_timestamp."</th>";
	$end_timestamp=microtime(true);
	$log.="<th>".$end_timestamp."</th>";
	$rerer=$end_timestamp-$start_timestamp;
	$log.="<th>".$rerer."</th></tr>";
	//$include_path=getenv('config_job_path');
	$directory = $include_path.'\sfcs_app\app\jobs\log\\'.'soap_call';
	if (!file_exists($directory)) {
		mkdir($directory, 0777, true);
	}
	$fileName="mo_soap_api_call";
	$file_name_string = $fileName.'_'.date("Y-m-d-H-i-s").'.html';
	$my_file=$include_path.'\sfcs_app\app\jobs\log\\'.'soap_call\\'.$file_name_string;
	$handle = fopen($my_file, 'a') or die('Cannot open file:  '.$my_file);
	$file_data_request = $log;
	fwrite($handle,"\n".$file_data_request); 
	
	$files = glob($include_path.'\sfcs_app\app\jobs\log\soap_call\mo_soap_api_call_'."*");
    $now   = time();
    foreach ($files as $file) {
		 if (is_file($file)) {
			if ($now - filemtime($file) >= 60 * 60 * 24 * 15) { // 15 days
				 unlink($file);
		}
	  }
	}

	fclose($handle); 
	$end_timestamp = microtime(true);
	$duration = $end_timestamp - $start_timestamp;
 	print("mo_soap_api_call file Execution took ".$duration." seconds.");
?>

