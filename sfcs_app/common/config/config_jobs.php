<?php 
include('C:/xampp\htdocs\sfcs_main\configuration\API\confr.php');
$conf = new confr('C:\xampp\htdocs\sfcs_main\configuration\config-builder\saved_fields\fields.json');
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
$serverName = "GD-SQL-UAT";
$uid = "SFCS_BIA_FF";
$pwd = "Ba@rUpr6";
$databasename="BELMasterUAT";
//material requirement in week_del_mail_v2
$server="GD-RPTSQL";
$database="M3_BEL";
$userid="BAIMacroReaders";
$passwrd="BAI@macrosm3";

//To Facilitate SFCS Filters
$global_facility_code=$conf->get('plantcode');
$facility_code=$global_facility_code;

$sizes_array=array('s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50');

$sizes_code=array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50');

$sizes_title=array('S01','S02','S03','S04','S05','S06','S07','S08','S09','S10','S11','S12','S13','S14','S15','S16','S17','S18','S19','S20','S21','S22','S23','S24','S25','S26','S27','S28','S29','S30','S31','S32','S33','S34','S35','S36','S37','S38','S39','S40','S41','S42','S43','S44','S45','S46','S47','S48','S49','S50');

$plant_name = $conf->get('plantname');
$fab_uom = $conf->get('uom');
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
?>
<?php
$path="C:/xampp/htdocs/sfcs_main/sfcs_app/app";

$mail_to_test=$mail_alert[2];
$smtp_user=$conf->get('smtp-user-name');
$header_from="From: Shop Floor System Alert <ictsysalert@brandix.com>";
$order_summary_report=$mail_alert[2];
$mrn_mail=$mail_alert[2];
$inspection_rep_email=$mail_alert[2];
$pps_board_summary=$mail_alert[2];
$dashboard_email_dialy_H_14=$mail_alert[2];
$dashboard_email_dialy=$mail_alert[2];
$daily_cod_events=$mail_alert[2];
$plan_vs_output_analysis_mail=$mail_alert[2];
$SFCS_PRO_SI_WED=$mail_alert[2];
$transaction_audit_alert=$mail_alert[2];
$week_del_mail_v2=$mail_alert[2];
$SAH_Countdown_alert=array($mail_alert[2],$mail_alert[1]);
$line_wip_track=$mail_alert[2];
$pop_pending_list_mail=$mail_alert[2];
$Aod_gate_pass=$mail_alert[2];


//sah countdown

$command ='webshotcmd /url "http://localhost/sfcs_main/sfcs_app/app/jobs/planning/SAH_Countdown/Plan_sah.php" /bwidth 1500 /bheight 700 /out echart.png /username baischtasksvc /password pass@123';
?>


