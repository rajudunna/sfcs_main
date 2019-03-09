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
set_time_limit(6000000);

	// include($_SERVER['DOCUMENT_ROOT'].'/template/dbconf.php');
	error_reporting(E_ALL);
	//var_dump($link);
	$headerbody = array("user"=>$api_username,"password"=>$api_password,"company"=>$company_no);
	$header = new SOAPHeader("http://lawson.com/ws/credentials", "lws", $headerbody);
	$soap_client = new SoapClient( $api_hostname.":".$api_port_no."/lws-ws/".$mo_soap_api."/SFCS?wsdl",array("login" => $api_username,"password" => $api_password));
	$soap_client->__setSoapHeaders($header);
	try{
		$to = date('Ymd',  strtotime('+3 month'));
		$from = date('Ymd',  strtotime('-1 month'));
		$result2 = $soap_client->MOData(array('Facility'=>$global_facility_code,'FromDate'=>$from,'ToDate'=>$to));
		$i=1;
		$new_ids = [];
		echo "From Date:<b>".date('Y-m-d',strtotime($from))."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To date:<b>".date('Y-m-d',strtotime($to))."</b><br/>";
		echo "<table>";
		echo "<tr><th>S.NO</th><th>MONUMBER</th><th>MOQTY</th><th>STARTDATE</th><th>VPO</th><th>COLORNAME</th><th>COLOURDESC</th><th>SIZENAME</th><th>SIZEDESC</th><th>ZNAME</th><th>ZDESC</th><th>SCHEDULE</th><th>STYLE</th><th>PRODUCT</th><th>PRDNAME</th><th>PRDDESC</th><th>REFERENCEORDER</th><th>REFORDLINE</th><th>MOSTS</th><th>MAXOPERATIONSTS</th><th>COPLANDELDATE</th><th>COREQUESTEDDELDATE</th></tr>";
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
			// echo "</tr>";
			$basic_auth = base64_encode($api_username.':'.$api_password);
			$rest_call = getCurlAuthRequestLocal($api_hostname.":".$api_port_no.'/m3api-rest/execute/OIS100MI/GetLine?CONO='.$company_no.'&ORNO='.$value->REFERENCEORDER.'&PONR='.$value->REFORDLINE,$basic_auth);
			
            if($rest_call['status'] && isset($rest_call['response']['ITNO']) && $rest_call['response']['ITNO']!=''){
				$get_buyer_details = getCurlAuthRequestLocal($api_hostname.":".$api_port_no.'/m3api-rest/execute/MDBREADMI/GetMITMASX1?CONO='.$company_no.'&ITNO='.urlencode($rest_call['response']['ITNO']),$basic_auth);
				$last_buyer_details = ['status'=>false];
				if($get_buyer_details['status'] && isset($get_buyer_details['response']['BUAR']) && $get_buyer_details['response']['BUAR']!=''){
					$last_buyer_details = getCurlAuthRequestLocal($api_hostname.":".$api_port_no.'/m3api-rest/execute/CRS036MI/LstBusinessArea?CONO='.$company_no.'&FRBU='.$get_buyer_details['response']['BUAR'].'&TOBU='.$get_buyer_details['response']['BUAR'],$basic_auth);
				}
				if($last_buyer_details['status'] && isset($last_buyer_details['response']['TX40']) && $last_buyer_details['response']['TX40']!=''){
					$ins_qry1 = "INSERT IGNORE INTO `bai_pro3`.`mo_details`(`date_time`, `mo_no`, `mo_quantity`, `style`, `schedule`, `color`, `size`, `destination`, `zfeature`, `item_code`, `ops_master_status`, `product_sku`,`packing_method`,`cpo,buyer_id`,`material_master_status`,`shipment_master_status`,`vpo`,`startdate`,`coplandeldate`,`referenceorder`) VALUES ('".date('Y-m-d H:i:s')."','".$value->MONUMBER."','".$value->MOQTY."','".$value->STYLE."','".$value->SCHEDULE."','".$value->COLOURDESC."','".$value->SIZENAME."','".$rest_call['response']['ADID']."','".$value->ZNAME."','','','".$value->PRODUCT."','".$rest_call['response']['TEPA']."','".$rest_call['response']['CUOR']."','".$last_buyer_details['response']['TX40']."',0,0,'".$value->VPO."','".date('Y-m-d',strtotime($value->STARTDATE))."','".date('Y-m-d',strtotime($value->COPLANDELDATE))."','".$value->REFERENCEORDER."')";
					$result1 = mysqli_query($link, $ins_qry1) or exit("Sql Error Insert bai_pro3.mo_details".mysqli_error($GLOBALS["___mysqli_ston"]));
					if($result){
						//$new_ids[] = mysqli_insert_id($link);
					}
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
?>

