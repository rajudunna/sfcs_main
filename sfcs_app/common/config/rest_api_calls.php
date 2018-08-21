<?php 
class rest_api_calls {	
	public function getCurlRequest($url){			
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}
}
$obj = new rest_api_calls();	

?>