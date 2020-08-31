<?php
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_ajax.php');
include($include_path.'\sfcs_app\common\config\api_call.php');

function getJobGroups($style, $color, $plant, $variant) {
    $url="$BackendServ_ip/job-group-sequencing/getJobGroupSequence";
    $req['style'] = $style;
    $req['color'] = $color;
    $req['variant'] = $variant;
    $req['defaultOperation'] = true;
    $req['plantCode'] = $plant;
	$styleColorOps = getInfoFromApi($url,$req);
	return $styleColorOps['data'][0]['jobOperations'];

}
?>