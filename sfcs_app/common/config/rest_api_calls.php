<?php 
class rest_api_calls {
	//For rest api calls basic 
	public function getCurlRequest($url){			
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}
	
	//For rest api calls m3 authentication based 
	public function getCurlAuthRequest($url){
		$include_path=getenv('config_job_path');
		include($include_path.'\sfcs_app\common\config\m3_api_const.php');
        $basic_auth=base64_encode($api_username.':'.$api_password);
        $curl = curl_init();
        curl_setopt_array($curl, array(
			CURLOPT_PORT => $api_port_no,
			CURLOPT_URL => $ur,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"Accept: application/json",
				"Authorization: Basic ".$basic_auth,
				"Cache-Control: no-cache",
				"Content-Type: application/json"
				// "Postman-Token: df10b2f5-8494-4d56-a7b0-d41c05016563"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

        if ($err) {
			//return "cURL Error #:" . $err;
			return "api_call_fail";
        }else{
            return $response;
        }
	}		
}
$obj = new rest_api_calls();	

?>