<?php

  
function getJobOpertions($style, $color, $plant, $variant) {
    include("api_calls.php");
    include("server_urls.php");
    $url="$SMS_SERVER_IP/job-group-sequencing/getJobGroupSequence";
    $req['style'] = $style;
    $req['color'] = $color;
    $req['variant'] = $variant;
    $req['plantCode'] = $plant;
	$styleColorOps = getInfoFromApi($url,$req);
	return $styleColorOps['data'][0]['jobOperations'];
}

?>