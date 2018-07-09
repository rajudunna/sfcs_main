<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/configuration/API/confr.php");
$conf1 = new confr($_SERVER['DOCUMENT_ROOT']."/configuration/API/saved_fields/fields.json");

function get_config_values($config_id){
    $conf = new confr($_SERVER['DOCUMENT_ROOT']."/configuration/API/saved_fields/fields.json");
    if($config_id=='getmysqldb'){
    return $conf->getDBConfig();
    }else{
    return $conf->get($config_id);
    }
}

$mysql_details = get_config_values('getmysqldb');
//SFCS Db Configurations
$host=$mysql_details['db_host'].":".$mysql_details['db_port'];
$user=$mysql_details['db_user'];
$pass=$mysql_details['db_pass'];
$central_administration_sfcs='central_administration_sfcs';
$tbl_view_view_menu="tbl_view_view_menu";
$view_menu_role="view_menu_role";
$username = getrbac_user()['uname'];

$bai_pro3="bai_pro3";
$bai_pro="bai_pro";
$bai_pro4="bai_pro4";
$bai_pro2="bai_pro2";
$bai_rm_pj1="bai_rm_pj1";
$bai_rm_pj2="bai_rm_pj2";
$brandix_bts="brandix_bts";
$bai_pack="bai_pack";
$bai_kpi="bai_kpi";
$brandix_bts_uat="brandix_bts_uat";
$m3_inputs="m3_inputs";
$m3_bulk_ops_rep_db="m3_bulk_ops_rep_db";
$temp_pool_db="temp_pool_db";
$in_categories = '"'.strtoupper( implode('","',$conf1->get('category-display-dashboard')) ).'"';

$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $pass)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));


?>