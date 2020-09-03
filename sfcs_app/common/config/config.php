<?php
//Without LDAP , With LDAP Unblock LDAP Code
//$username="sfcsproject1";
// echo $_SERVER['DOCUMENT_ROOT'];
error_reporting(0);
require_once($_SERVER['DOCUMENT_ROOT']."/configuration/API/confr.php");
$conf1 = new confr($_SERVER['DOCUMENT_ROOT']."/configuration/API/saved_fields/fields.json");

$mysql_details = $conf1->getDBConfig();
$mssql_odbc_details = $conf1->get('mssql-odbc');
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$user=$username=strtolower($username_list[1]);
$remove_user_name = true; // set false for static username removing 

//SFCS Mysql Db Configurations
$host=$mysql_details['db_host'].":".$mysql_details['db_port'];
$user=$mysql_details['db_user'];
$pass=$mysql_details['db_pass'];

//MSSql Configurations
$ms_sql_odbc_host = $conf1->get('mssql-odbc');
$ms_sql_odbc_server = $conf1->get('mssql-server-name');
$ms_sql_odbc_user = $conf1->get('mssql-user-name');
$ms_sql_odbc_pass = $conf1->get('mssql-password');
$mssql_db = $conf1->get('m3database');
$ms_sql_driver_name = $conf1->get('driver_name');

//Promis Configurations
$promis_val = $conf1->get('promis_val');
$promis_sql_odbc_host = $conf1->get('promis-mssql-odbc');
$promis_sql_odbc_server = $conf1->get('promis-server-name');
$promis_sql_odbc_user = $conf1->get('promis-user-name');
$promis_sql_odbc_pass = $conf1->get('promis-password');
$promis_db = $conf1->get('promisdatabase');
$promis_sql_driver_name = $conf1->get('promis_driver_name');

//Barcode Configuration
$barcode_4x2 = $conf1->get('4x2-barcode');
$barcode_2x1 = $conf1->get('2x1-barcode');

//MY SQL host
$ms_sql_odbc_host = $conf1->get('mysql-odbc');
//ms-sql sticker_report
$host_ms = $conf1->get('m3_system_id');
$user_ms = $conf1->get('m3_user_name');
$password_ms = $conf1->get('m3_password');
$m3_db = $conf1->get('m3_db');
$conn_string = "DRIVER={iSeries Access ODBC Driver};System=".$host_ms.";Uid=".$user_ms.";Pwd=".$password_ms.";";
//echo $conn_string;
//M3 MSSQL DB Configurations
$m3_mssql_odbc_name="bcimovsms01_bai";
$m3_mssql_username="brandix_india_user1";
$m3_mssql_password="styleRM123";

//Local MSSQL DB Configurations
$local_mssql_odbc_name="BAINET_INTRANET_NEW";
$local_mssql_username="sa";
$local_mssql_password="Brandix@7";

//To Facilitate SFCS Filters
$global_facility_code=$conf1->get('plantcode');
$facility_code=$global_facility_code;

/**at the time of getting data from pms and pps tables we inlcude plantcode also */
//$plantcode=$global_facility_code;
session_start();
$plant_code = $_SESSION['plantCode'];
$username = $_SESSION['userName'];

$plant_alert_code=$conf1->get('plant-alert-code');     //plant-alert-code
$message_sent_via=$conf1->get('msg-sent-via');  //msg-sent-via
$rms_request_time = $conf1->get('rms_request_time');
//User access code
$server_soft=$_SERVER['SERVER_SOFTWARE'];


//get plant details and adress
$plant_head=$conf1->get('plant_head');
$plant_address=$conf1->get('plant_address');
$plant_location=$conf1->get('plant_location');

//M3 Rest API Calls Details
$company_no = $conf1->get('companey-number');
$api_username = $conf1->get('api-user-name');
$api_password = $conf1->get('api-password');
$api_hostname = $conf1->get('api-host-name');
$api_port_no = $conf1->get('api-port');

$enable_api_call = $conf1->get('enable-api-call');

// Total Plant working hours
$tot_plant_working_hrs = $conf1->get('tot_plant_working_hrs');
// Copy fr qty to forecast qty (yes/no)
$copy_fr_to_forecast = $conf1->get('copy-fr-to-forecast');

//Scanning Methods
$scanning_methods = $conf1->get('scaning-method');

//Display Reporting Qty
$display_reporting_qty = $conf1->get('reporting-quantity');
// Cut Quantity Reporting Validation
$cut_qty_reporting_validation=$conf1->get('cut-qty-reporting-validation');
$line_in = $conf1->get('line-in');

//LDAP CODE STARTS***
// if(substr($server_soft,0,13)=="Apache/2.4.28")
// {
// 	$username_list=explode('\\',$_SERVER['REMOTE_USER']);
// 	$username=strtolower($username_list[1]);
// 	//$_SESSION['intra_user_name']=$username;
// }
// else
// {
// 	//list($domain,$username) = explode('[\]',$_SERVER['AUTH_USER'],2);

// 	$username = explode('\\',$_SERVER['AUTH_USER']);
// 	$username=strtolower($username[1]);

// 	//$_SESSION['intra_user_name']=$username;
// }
//LDAP CODE ENDS***

//For Logo Path
$logo = '/sfcs_app/common/images/logo.png';
if(!isset($dashboard_name)){
//Auto Close Exempted Pages
$autoclose_page_exempted=array("baiadmn","baisysadmin","baiictadmin","baischtasksvc","sfcsproject1");
$autoclose_period=1800000;

//Auto close window after 30 mins
if(!in_array($username,$autoclose_page_exempted))
{
echo "<script language=\"javascript\">
    setTimeout(\"window.open('', '_self'); window.close();\",$autoclose_period);
</script>";
}
}
$dnr_adr_sp_chain = "http://192.168.0.110:8002"; 
$fab_uom=$conf1->get('uom');
$sizes_array=array('s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50');

$sizes_code=array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50');

$sizes_title=array('S01','S02','S03','S04','S05','S06','S07','S08','S09','S10','S11','S12','S13','S14','S15','S16','S17','S18','S19','S20','S21','S22','S23','S24','S25','S26','S27','S28','S29','S30','S31','S32','S33','S34','S35','S36','S37','S38','S39','S40','S41','S42','S43','S44','S45','S46','S47','S48','S49','S50');

$shifts_array = $conf1->get('shifts');
$plant_hours=7.5;
$teams_array = $conf1->get('teams');
//$shifts_array = array("A","B","C","G","ALL");

$mod_names = array("1","2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "40");

$plant_name = $conf1->get('plantname');

//TaskAttributeNamesEnum
$sewing_job_attributes=['style'=>'STYLE','schedule'=>'SCHEDULE','color'=>'COLOR','ponumber'=>'PONUMBER','masterponumber'=>'MASTERPONUMBER','cutjobno'=>'CUTJOBNO','docketno'=>'DOCKETNO','sewingjobno'=>'SEWINGJOBNO','bundleno'=>'BUNDLENO','packingjobno'=>'PACKINGJOBNO','cartonno'=>'CARTONNO','componentgroup'=>'COMPONENTGROUP'];

//M3 Rest API Calls Details
$company_no = $conf1->get('companey-number');
$api_username = $conf1->get('api-user-name');
$api_password = $conf1->get('api-password');
$api_hostname = $conf1->get('api-host-name');
$api_port_no = $conf1->get('api-port');

//m3 integration plant codes
$grn_details=$conf1->get('grndetails');
$fabricstatus=$conf1->get('fabricstatus');
$strimstatus=$conf1->get('strimstatus');
$ptrimstatus=$conf1->get('ptrimstatus');
$cluster_code=$conf1->get('cluster_code');
$comp_no=$conf1->get('company_no');
$central_wh_code=$conf1->get('central_wh_code');
$plant_wh_code=$conf1->get('plant_wh_code');
$plant_prod_code=$conf1->get('plant_prod_code');
$shrinkage_inspection=$conf1->get('shrinkage-inspection');
$roll_splitting=$conf1->get('roll-splitting');
$sewing_rejection=$conf1->get('sewing_rejection');



$logo = '/sfcs_app/common/images/logo.png';
$icon2='/sfcs_app/common/images/BAI_Logo.JPG';

$in_categories = '"'.strtoupper( implode('","',$conf1->get('category-display-dashboard')) ).'"';
$select_pack_method= $conf1->get('pack_code');
$plant_start_time = $conf1->get('plant-start-time');
$plant_end_time = $conf1->get('plant-end-time');
$detailed_bundle_sticker = $conf1->get('detailed-bundle-sticker');
//Central Administraion Group ID's
$group_id_sfcs=8;
$group_id_Main=5;
// mail header
$smtp_user=$conf1->get('smtp-user-name');
// $header_from="From: Shop Floor System Alert <ictsysalert@brandix.com>";
$header_from="From: Shop Floor System Alert <'".$smtp_user."'>";
$header_name=$smtp_user." Alert";
$header_mail=$conf1->get('smtp_mail_from');
$dispatch_mail = $conf1->get('dispatch_mail');
$short_shipment_mail = $conf1->get('short_shipment_mail');

$wpt_refresh_time = $conf1->get('wpt-refresh-time');

//Central Administration Menu Access
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
/*These all are related 2.0 integration databses*/
$mdm="mdm_prod";
$oms="oms_prod";
$pps="pps_prod";
$pms="pms_prod";
$sms="sms_prod";
$tms="tms";
$wms="wms_prod";
$module_limit = 32;

$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $pass)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link, $wms) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

//Link For 2.0
$link_new= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $pass)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link, $wms) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

$operation=array("Please Select","Single Colour & Single Size","Multi Colour & Single Size","Multi Colour & Multi Size","Single Colour & Multi Size");

$order_joins_not_in="order_joins not in ('1','2')";

$order_joins_in="order_joins in ('1','2')";

$order_joins_in_full="order_joins in ('0','1','2')";

$order_joins_in_2 ="order_joins='2'";

$order_joins_in_1 ="order_joins='1'";

// var_dump($pack_methods);
//***************************************************
//======== for central warehouse connections ========
//***************************************************
  /*  $is_chw = $conf1->get('central_warehouse');
    $cwh_link = Null;
    // if($is_chw == 'yes'){
    //     $cwh_host = $conf1->get('cw_host');
    //     $cwh_user_name = $conf1->get('cw_username');
    //     $cwh_password = $conf1->get('cw_password');
    //     $cwh_port = $conf1->get('cw_port');
    //     $cwh_link = ($GLOBALS["___mysqli_ston"] = mysqli_connect($cwh_host.":".$cwh_port, $cwh_user_name, $cwh_password)) or die("Could not connect cwh: ".mysqli_error($GLOBALS["___mysqli_ston"]));

    // }
//===================================================*/
class TaskTypeEnum { 
    const CUTJOB = 'CUTJOB';
    const DOCKET = 'DOCKET';
    const DOCKETBUNDLE = 'DOCKETBUNDLE';
    const SEWINGJOB = 'SEWINGJOB';
    const PACKINGJOB = 'PACKINGJOB';
    const CARTON = 'CARTON';
    const EMBELLISHMENTJOB = 'CUTEMBJOB';
    const LOGICALBUNDLE = 'LOGICALBUNDLE';
    const POLYBAG = 'POLYBAG';
    const PLANNEDSEWINGJOB = 'PSJ';
    const PLANNEDSEWINGEMBELLISHMENTJOB = 'PSEJ';
}

//IP for backend services
$BackendServ_ip="http://192.168.0.34:3336";


?>
