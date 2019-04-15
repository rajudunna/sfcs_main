<?php 

$include_path=getenv('config_job_path');
include($include_path.'\configuration\API\confr.php');
$conf = new confr($include_path.'\configuration\API\saved_fields\fields.json');
$mail_alert = [];
for($i=1;$i<=20;$i++){
	$mail_alert[$i-1]=$conf->get('mail'.$i);
}
//Without LDAP , With LDAP Unblock LDAP Code
$username="sfcsproject1";
$remove_user_name = true; // set false for static username removing 

//SFCS Db Configurations
$mysql_details=[];
$mysql_details = $conf->getDBConfig();
$host=$mysql_details['db_host'].":".$mysql_details['db_port'];
$user=$mysql_details['db_user'];
$pass=$mysql_details['db_pass'];

$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $pass)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
// Schedules Operations Capturing
$serverName=$conf->get('mssql-server-name');
$uid=$conf->get('mssql-user-name');
$pwd = $conf->get('mssql-password');
$m3_databasename=$conf->get('m3database');
$driver_name=$conf->get('driver_name');

//sfcs-ffsp configurations
$sfsp_serverName=$conf->get('sf_sp_servername');
$sfsp_m3_databasename=$conf->get('sf_sp_dbname');
$sfsp_uid=$conf->get('sf_sp_username');
$sfsp_pwd=$conf->get('sf_sp_pwd');


//ms-sql jobs 
$user_ms = "BAISFCS";
$password_ms = "fcs@m3pr";
$conn_string = "DRIVER={iSeries Access ODBC Driver};System=10.227.40.10;Uid=".$user_ms.";Pwd=".$password_ms.";";
//HRMS DATABASE CONNECTIONS
$hrms_server_name=$conf->get('hrms-server-name');
$hrms_server_port=$conf->get('hrms-port');
$hrms_host=$hrms_server_name.":".$hrms_server_port;
$hrms_user=$conf->get('hrms-user-name');
$hrms_pass = $conf->get('hrms-password');

$host_ms = $conf->get('m3_system_id');
$user_ms = $conf->get('m3_user_name');
$password_ms = $conf->get('m3_password');
$m3_db = $conf->get('m3_db');
$conn_string = "DRIVER={iSeries Access ODBC Driver};System=".$host_ms.";Uid=".$user_ms.";Pwd=".$password_ms.";";

// Production Status Connections
$prod_status_server_name=$conf->get('prod-status-server-name');
$prod_status_username=$conf->get('prod-status-user-name');
$prod_status_password = $conf->get('prod-status-password');
$prod_status_database=$conf->get('prod-status-db');
$prod_status_driver_name=$conf->get('prod-status-driver-name');


//material requirement in week_del_mail_v2
$server="GD-RPTSQL";
$database="M3_BEL";
$userid="BAIMacroReaders";
$password="BAI@macrosm3";

// bel data upload Sqlsrv Connections
$sqsrv_server = "berwebsrv01";
$sqsrv_id = "sa";
$sqsrv_pwd = "BAWR123";
$sqsrv_db="AutoMo";
//m3 integration plant codes
$grn_details=$conf->get('grndetails');
$cluster_code=$conf->get('cluster_code');
$comp_no=$conf->get('company_no');
$central_wh_code=$conf->get('central_wh_code');
$plant_wh_code=$conf->get('plant_wh_code');
$plant_prod_code=$conf->get('plant_prod_code');
// schedules Operation Capturing MDM
$odbc_host="BAIDBSRV01";
$odbc_user="sa";
$odbc_pass="Brandix@7";
//To Facilitate SFCS Filters
$global_facility_code=$conf->get('plantcode');
$facility_code=$global_facility_code;

$sizes_array=array('s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50');

$sizes_code=array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50');

$sizes_title=array('S01','S02','S03','S04','S05','S06','S07','S08','S09','S10','S11','S12','S13','S14','S15','S16','S17','S18','S19','S20','S21','S22','S23','S24','S25','S26','S27','S28','S29','S30','S31','S32','S33','S34','S35','S36','S37','S38','S39','S40','S41','S42','S43','S44','S45','S46','S47','S48','S49','S50');

$plant_name = $conf->get('plantname');
$fab_uom = $conf->get('uom');

$shifts_array = $conf->get('shifts');
$teams_array = $conf->get('teams');

//M3 Rest API Calls Details
$company_no = $conf->get('companey-number');
$api_username = $conf->get('api-user-name');
$api_password = $conf->get('api-password');
$api_hostname = $conf->get('api-host-name');
$api_port_no = $conf->get('api-port');

//Mo SOAP CALL
$mo_soap_api = $conf->get('mo_soap_api');

//Central Administraion Group ID's
$group_id_sfcs=8;
$group_id_Main=5;

$bai_pro3="bai_pro3";
$bai_pro="bai_pro";
$bai_pro4="bai_pro4";
$bai_pro2="bai_pro2";
$bai_rm_pj1="bai_rm_pj1";
$bai_rm_pj2="bai_rm_pj2";
$brandix_bts="brandix_bts";
$brandix_bts_uat="brandix_bts_uat";
$m3_inputs="m3_inputs";
$m3_bulk_ops_rep_db="m3_bulk_ops_rep_db";
$bai_kpi="bai_kpi";
$bai_ict="bai_ict";
?>
<?php
$path=$include_path."/sfcs_app/app";
// $mail_to_test=$mail_alert[2];
$smtp_user=$conf->get('smtp-user-name');
$header_name=$smtp_user." Alert";
$header_mail=$conf->get('smtp_mail_from');
 $header_from= 'From: BEKSFCS Alert <bek_sfcs@brandix.com>';
// $header_from="From: Shop Floor System Alert <'".$smtp_user."'>";
$order_summary_report=$conf->get('order_summary_mail');
$mrn_mail=$conf->get('mrn_week_summary_alert_mail');
$inspection_rep_email=$conf->get('rm_summary_report_email');
$pps_board_summary=$conf->get('ips_dashboard_summary_mail');
$dashboard_email_dialy_H_14=$conf->get('sah_dashboard_email');
$dashboard_email_dialy=$conf->get('sah_dashboard_email');
$daily_cod_events=$conf->get('dailly_delivery_failures_mail');
$plan_vs_output_analysis_mail=$conf->get('plan_vs_output_mail');
$SFCS_PRO_SI_WED=$conf->get('pro_si_wed_output_details_mail');
$transaction_audit_alert=$conf->get('bulk_or_fail_alert');
$week_del_mail_v2=$conf->get('week_del_plan_status_mail');
$SAH_Countdown_alert=$conf->get('sah_countdown_email');
$line_wip_track=$conf->get('production_wip_status_mail');
$pop_pending_list_mail=$conf->get('carton_pendings_mail');
$Aod_gate_pass=$conf->get('pro_aod_gatepass_update_to_belbal_co_invoice_mail');
// m3 to sfcs operations report mail
$m3_vs_sfcs_operation_reporting=$conf->get('m3_vs_sfcs_operation_reporting');

//sah countdown
$http_host=gethostname();
$command ="webshotcmd /url 'http://$http_host/sfcs_app/app/jobs/planning/SAH_Countdown/Plan_sah.php' /bwidth 1500 /bheight 700 /out echart.png /username baischtasksvc /password pass@123";

// quality->critical rejection 
$reasons=array("Miss Yarn","Fabric Holes","Slub","Foreign Yarn","Stain Mark","Color Shade","Panel Un-Even","Stain Mark","Strip Match","Cut Dmg","Stain Mark","Heat Seal","M ment Out","Shape Out","Emb Defects");


?>



