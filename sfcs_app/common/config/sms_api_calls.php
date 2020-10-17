<?php  
/*
    function to get operations from SMS
    @params:style,color,plantcode,operations_version_id
    @returns:operationCode,operationName
*/
function getJobOpertions($style, $color, $plant, $variant) {
    include("api_calls.php");
    include("server_urls.php");
    //Bearer token
    $url1="$KEY_LOCK_IP";
    $auth="grant_type=password&client_id=mdm-back-end&client_secret=68c57575-8f6a-4dfc-bdef-d021ecbc459f&username=bhuvan&password=bhuvan";
    $get_auth= getAuthenication($url1,$auth);
    $request= $get_auth['access_token'];
    $url="$SMS_SERVER_IP/job-group-sequencing/getJobGroupSequence";
    $req['style'] = $style;
    $req['color'] = $color;
    $req['variant'] = $variant;
    $req['plantCode'] = $plant;
    $styleColorOps = getInfoFromApi($url,$req,$request);
   // var_dump($styleColorOps);
	return $styleColorOps['data'][0]['jobOperations'];
}

?>