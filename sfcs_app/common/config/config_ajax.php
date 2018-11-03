<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/configuration/API/confr.php");
$conf1 = new confr($_SERVER['DOCUMENT_ROOT']."/configuration/API/saved_fields/fields.json");
//M3 Rest API Calls Details
$company_no   = $conf1->get('companey-number');
$api_username = $conf1->get('api-user-name');
$api_password = $conf1->get('api-password');
$api_hostname = $conf1->get('api-host-name');
$api_port_no  = $conf1->get('api-port');

$ims_boxes_count =  $conf1->get('ims_boxes');

$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);

$global_facility_code=$conf1->get('plantcode');
$enable_api_call = $conf1->get('enable-api-call');
$sewing_rejection=$conf1->get('sewing_rejection');
// function get_config_values($config_id){
//     error_reporting(0);
//     $conf = new confr($_SERVER['DOCUMENT_ROOT']."/configuration/API/saved_fields/fields.json");
//     if($config_id=='getmysqldb'){
//         return $conf->getDBConfig();
//     }else{
//         return $conf->get($config_id);
//     }
// }
$global_facility_code=$conf1->get('plantcode');
//get_config_values('getmysqldb');
$mysql_details = $conf1->getDBConfig();
//SFCS Db Configurations
$host=$mysql_details['db_host'].":".$mysql_details['db_port'];
$user=$mysql_details['db_user'];
$pass=$mysql_details['db_pass'];
$central_administration_sfcs='central_administration_sfcs';
$tbl_view_view_menu="tbl_view_view_menu";
$view_menu_role="view_menu_role";
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
$sizes_array=array('s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50');

$sizes_code=array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50');

$sizes_title=array('S01','S02','S03','S04','S05','S06','S07','S08','S09','S10','S11','S12','S13','S14','S15','S16','S17','S18','S19','S20','S21','S22','S23','S24','S25','S26','S27','S28','S29','S30','S31','S32','S33','S34','S35','S36','S37','S38','S39','S40','S41','S42','S43','S44','S45','S46','S47','S48','S49','S50');
?>
