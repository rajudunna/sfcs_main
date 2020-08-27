<?php
$include_path=getenv('config_job_path');
$conf = new confr($include_path.'\configuration\API\saved_fields\fields.json');
//M3 Rest API Calls Details
$api_username = $conf->get('api-user-name');
$api_password = $conf->get('api-password');
$api_hostname = $conf->get('api-host-name');
$api_port_no = $conf->get('api-port');


//FG Warehouse API Calls Details

$fg_token = $conf->get('fg-api-bearer-token');
$fg_api_hostname = $conf->get('fg-api-host-name');
$fg_api_port_no = $conf->get('fg-api-port');

$facility_code = $conf->get('plantcode');

//REST API TimeOut
$API_CALL_TIME_OUT = $conf->get('api_call_time_out');
?>