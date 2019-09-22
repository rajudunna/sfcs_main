<?php

$include_path=getenv('config_job_path');
include($include_path.'\configuration\API\confr.php');
$conf = new confr($include_path.'\configuration\API\saved_fields\fields.json');



// SFCS Old Configuration
$host_old=$conf->get('old_sfcs_name').":".$conf->get('old_sfcs_port');
$user_old=$conf->get('old_sfcs_user');
$pass_old=$conf->get('old_db_pass');
$link_sfcs= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host_old, $user_old, $pass_old)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
$facility_code_old=$conf->get('plantcode_old');
$comp_no_old=$conf->get('company_no_old');
$api_username = $conf->get('api-user-name');
$api_password = $conf->get('api-password');
$api_hostname = $conf->get('api-host-name');
$api_port_no = $conf->get('api-port');

?>