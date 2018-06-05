<?php

//System Restriction

include('C:\xampp\htdocs\sfcs_app\common\config\config_jobs.php');
// Turn off all error reporting
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// if($username!="baiadmn"){
	//header("Location:$dns_adr3/projects/alpha/bai_hrms/restricted.php");
// }

//For Employee/Walking Database
$database="bai_hr_database";
$user=$user;
$password=$pass;
$host=$host;
//$host="baidbsrv02";


$active_status=array("11","12","13","30","35","40","45","50","55"); //30-Taken for Training & sht allocated,35-eligible for prod,40,45,50,55,11-pregnant,12-kept in remider,13-on long leave,14-Inactive,17-long absentism
$active_status=implode(",",$active_status);

$emp_active_status=array("11","13","40","45","50","55");
$emp_active_status=implode(",",$emp_active_status);

$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $password)) or die("Could not connect: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link, $database) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

//For multiple execution.
$database_sqli="bai_hr_payroll_db";
$link_sqli=@mysqli_connect($host, $user, $password, $database_sqli);

//For Shop Floor System Access

$database_sfs="bai_pro";
$user1=$host_adr_un;
$password1=$host_adr_pw;
$host1=$host_adr;
//$host1="baiappsrv02";
$link_sfs= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host1, $user1, $password1)) or die("Could not connect: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link_sfs, $database_sfs) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));


//For Attendance Database
$tr_att_year_db="bai_hr_tna_tr_".date("y").date("y");
$em_att_year_db="bai_hr_tna_em_".date("y").date("y");

set_time_limit(6000000);


$filter_code=array('','0','5','2','10','4','15','20','7','25','30','35','40','45','50','55','11','12','13','14','16','17','70','75','80','85','90','95');
$filter_desc=array('','Walk-in','Registered - Eligible for Interview','Rejected / Not Eligible','Test Pass (Level 1)','Test Fail (Level 1)','Hold','Medical Pass','Medical Fail','Eligible for Training','Taken for Training & Shif Allocated','Eligible for Production (Test Level 2)','HOD Approved for TC to PC','Given onroll employee status','Full scale employee ( Completed all doc. Procedures & Formalities)','Rejoined Employee','Pregnant Lady','Kept in Reminder','On long leave','In Active','Warned','More than 45 days absent','Terminated (below 1 year)','Terminated (above 1 year)','Resigned (below 1 year)','Resigned (above 1 year)','Legal Issue','Full & Final Settlement');


//To update attendance Manually
$attn_code=array('A','P','px','x','CO','TU','OD','PR','PE');
$attn_val=array(0,1,0.5,0.5,1,1,1,1,1);
$attn_desc=array('Full day Absent','Full Day Present','Half day consider as present (General Shift)','Present but Not worked for 8 Hrs','Compensatory Off','Tour','Out Door Duty','Full day permission','Excess Worked');

//PE for worked excess and eligible for compoff

//Exempted Leaves
//for no pay - Loss of Pay Leave
//other one for extension of medical - Prolonged Illness Leave

//******************************NOTE***************************

//Please check functions to call the leave value in mysql.
//SET GLOBAL log_bin_trust_function_creators = 1;

//******************************NOTE***************************


$leave_base=array('CL','SL','ML','EL','AL','cl','sl','el','LP','PL'); //for leave types
$leave_val=array(1,1,1,1,1,0.5,0.5,0.5,0,0);
$count_for_payroll=array(1,1,0,1,0,1,1,1,0,0);
$leave_base_title2=array('Casual Leave','Sick Leave','Maternity Leave','Earned Leave','Annual Leave','Casual Leave','Sick Leave','Earned Leave','Loss of Pay','Prolonged Illness Leave'); //For Leave Form
$leave_base_title=array('Full Casual Leave','Full Sick Leave','Maternity Leave','Full Earned Leave','Annual Leave','Half Casual Leave','Half Sick Leave','Half Earned Leave'); //for leave types

//Halfday exemption leave groups
$half_leave_exemp_groups=array("LGR2");

//For Time Slots
$time_slots=array("08:00-17:00","06:00-14:00","14:00-22:00","18:00-06:00");
$team_ref=array("A","B","C","G");

//Day types
$day_code=array("W","H","O","X");
$day_description=array("W-Working Day","H-Holiday","O-Week Off","X-Working Day");

//Section Details

$section_id=array(0,1,2,3,4,5,6,7);
$section_title=array("N/A","Section - 1","Section - 2","Section - 3","Section - 4","Section - 5","Section - 6","R&D Section - 7");
$section_mods_codes=array("N/A","1,2,3,4,5,6,7,8,9,10,11,12,81,91","13,14,15,16,17,18,19,20,21,22,23,24","25,26,27,28,29,30,31,32,33,34,35,36,82,83","37,38,39,40,41,42,43,44,45,46,47,48,84,93","49,50,51,52,53,54,55,56,57,58,59,60,85","61,62,63,64,65,66,67,68,69,70,71,72","92"); // as per dabase table codes
//added 93 module as per mail confirmetion from usditha on 21st june 2013
$section_authors=array("","kirang,kirang,senthoorans,dileepd,udarak,rahmana","kirang,senthoorans,dileepd,indikaw,rahmana","kirang,kirang,senthoorans,dileepd,rahmana","kirang,kirang,senthoorans,dileepd,rahmana","kirang,kirang,senthoorans,dileepd,udarak,rahmana","kirang,kirang,senthoorans,dileepd,indikaw,rahmana","kirang,kirang,senthoorans,dileepd,udarak,rahmana");

//Attendance Manual Upload Reason Codes
$attn_manual_reason_code=array("0","1","2","3","4","5","6","7","8","9");
$attn_manual_reason_title=array("N/A","Card Lost","Card Not Isssued","Card Forgotten","Validating Log","Card Misused","Leagal Adjustment","Flash Missed","Card Not Working","Others");

/*
$sql="select * from bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
while($sql_row=mysql_fetch_array($sql_result))
{
}
*/

//Leave Accumulation Track
$leave_accum_track="leave_accum_track";

//Basic Config

$inactive_criteria_period=5; //5 days excluding today (always limit+1)
$encash_limit=15; //Encash leaves will be calculated based on the encash limit.

//Tables

$walk_in_master="walk_in_master";
$walkin_remarks="walkin_remarks";
$batch_track="batch_track";
$qual_reference="qual_reference";
$qual_track="qual_track";

$reg_rej_reference="reg_rej_reference";
$reg_rej_w_db="reg_rej_w_db";

$walkin_status_log="walkin_status_log";
$geo_source_reference="geo_source_reference";

$pic_point_reference="pic_point_reference";
$geo_source_reference="geo_source_reference";
$emp_team_reference="emp_team_reference";
$emp_desg_reference="emp_desg_reference";

$emp_skill_test_track="emp_skill_test_track";
$test_levels="test_levels";
$test_reference="test_reference";
$emp_med_test_track="emp_med_test_track";
$med_reference="med_reference";

$emp_item_issue_track="emp_item_issue_track";
$emp_items_reference="emp_items_reference";

$emp_ver_track="emp_ver_track";
$ver_reference="ver_reference";
$expat_id_map="expat_id_map";

$emp_personal_info_track="emp_personal_info_track";


$emp_address_track="emp_address_track";
$emp_join_type_reference="emp_join_type_reference";
$emp_section_reference="emp_section_reference";
$emp_dep_reference="emp_dep_reference";
$emp_grade_reference="emp_grade_reference";
$emp_category_reference="emp_category_reference";
$emp_opr_reference="emp_opr_reference";

$emp_join_remarks="emp_join_remarks";
$emp_join_track="emp_join_track";
$opr_machine_det="opr_machine_det";

$pic_point_reference="pic_point_reference";
$train_id_map="train_id_map";
$emp_join_remarks="emp_join_remarks";
$emp_id_map="emp_id_map";

//For Leave Status
$emp_super_user_ref="emp_super_user_ref";
$emp_leave_master="emp_leave_master";
$emp_leave_balances_log="emp_leave_balances_log";
$emp_leave_tran_log="emp_leave_tran_log";

$calendar="calendar";

$emp_attn_manual_log="emp_attn_manual_log";
$tr_attn_manual_log="tr_attn_manual_log";

$emp_payment_mode_db="emp_payment_mode_db";
$emp_payment_mode_queries="emp_payment_mode_queries";

//Payroll Exclued px for continues absentees
$non_cons_attn_type="px";

//Titles
$epf_company_title="AP/VSP/0055010/000/";

//Auto Fill attendance status types
$auto_fill_attn=array('TU','OD','PR');
$auto_fill_cosider_status=array('A','px');

include("db_functions_sch.php");


//Authentication
//Domain Login Name
// $username_list=explode('\\',$_SERVER['REMOTE_USER']);
// $username=strtolower($username_list[1]);
$username="baischtasksvc";

$production_team=array("mohana","sandeepab","madhurib","deepad","diland","keerthirathnad","ranjang","pasanj","aselak","santhoshk","bhavanik","ruwanmh","channam","nalakam","santhoshm","purnimap","durgaprasadr","buddhikarr","nihals","denakas","ajithkw","chinthakalw","maheshkumary","baiuser","baiprosec1","baiprosec2","baiprosec3","baiprosec4","baiprosec5","baiprosec6","baicutsec1","baicutsec2","baicutsec3","baiworkstudy","senthoorans","diland","pasanj","udarak","sajitha","indikaw","gubbala","prasanthim","sankars","pavanir","jyothsnas","arunag");//sankhaj,indiaw are added on 28th as per the Venkatesh sir oral approval

$hr_team=array("kirang","gowria","maheshpr","raghup","dileepd","adityar","sunilkumars","baiadmn","baisysadmin","baischtasksvc","kirang","seshavardhank","sampathfr","prathyushak","vijayt","kirang","swethap","rajesht","baihr","pavanib","udithaw","baihr","lohitham","prasanthis","manjulathak","sanjeewanim","lathas","pratapr","baitransport","welfarebai","baimedical","srividyag","srinivast","ravibo","indiras", "phanikumarv", "bhanuprakashv", "suseelak","rajeshk","sushumaa","sudharania","swapnan","prasanthis","ganeshch","palgunav","ganeshka","niramalas","naidup","rameshpit","sanjayv","balakrishnal","snehach","lakshmiy","geethak","lalithap","kirang");

$external_users=array("kaushalap","erangar","asutoshg","danushape","erangar","gayanl","udithaw","venkateshg","udayad","ravinj");
$finance_users=array("satyar");

//Employee Access

$regular_employee_access=array();
//$regular_employee_access=explode("$",echo_title3($emp_super_user_ref,"group_concat(domain_login SEPARATOR '$')","length(domain_login)>0",$link));//commented due to group_contaact is limited length(1024bytes)

$sql_emp="select domain_login from $emp_super_user_ref where length(domain_login)>0";	
$res_sql_emp=mysqli_query($link, "$sql_emp") or exit("SQL Eror-EMP_access".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row_set=mysqli_fetch_array($res_sql_emp))
{
	$regular_employee_access[]=$row_set['domain_login'];
}


$authorized_users=array_merge($production_team,$hr_team,$regular_employee_access,$external_users,$finance_users);

// if(!in_array($username,$authorized_users))
// {
	// header("Location: restricted.php");
// }
//For Attendance Update (Manually)
$tr_attn_man_up_users=array("gowria","kirang","kirang","seshavardhank","sanjayv","balakrishnal");
$em_attn_man_up_users=array("kirang","dileepd","kirang","vijayt","venkateshg","lathas","srinivast","seshavardhank");
//For General data updates
$update_rights=array("gowria","kirang","dileepd","adityar","sunilkumars","prathyushak","kirang","vijayt","swethap","rajesht","pavanib","lohitham","prasanthis","manjulathak","sanjeewanim","pratapr","lathas","baiadmn","baisysadmin","srinivast","ravibo","satishs","seshavardhank","suseelak","sanjayv","balakrishnal");

$update_rights_emp_allocation=array("gowria","kirang","dileepd","kirang","vijayt","swethap","rajesht","baiadmn","baisysadmin","seshavardhank","sanjayv","balakrishnal");

$work_study_users=array("senthoorans","udarak","indikaw","baiworkstudy");

$external_update_rights=array_merge($update_rights,$work_study_users);


//For Test passing/other/TR ID/ EMP ID level process etc.,
$alloc_rights=array("kirang","gowria","swethap","vijayt","kirang","seshavardhank","dileepd","sanjayv","balakrishnal");
//To Validate Application and before assigning employee number.
$alloc_rights_admin=array("kirang","gowria","swethap","vijayt","kirang","seshavardhank","sanjayv","balakrishnal");
$expat_alloc_rights_admin=array("vijayt","kirang","kirang");
//For Statutory allocation (EPF)
$leagal_rights=array("kirang","kirang");

//Authentication
//Leave Application and Approve Rights
$leave_app_rights=array("kirang","dileepd","kirang","vijayt","lathas","baiadmn","srinivast");
//To enable Option to auto approve checkboxes
$leave_auto_approve_rights=array("kirang","dileepd","kirang","vijayt","lathas","baiadmn");

//Confidential Infor View Access
$confidential_access=array("kirang","seshavardhank","gowria","kirang","dileepd","swethap","baiadmn");

//Probation period
$probation_period=6; //Months

//Power Users
$power_users=array("kirang","dileepd");

//Admin Users (View rights to check system level data/configurations)/ Attendance Log
$admin_users=array("kirang","kirang");

//ABC absenteesim verification control users added on 8th dec 8:13
$abc_updates="abc_updates";
$abc_password="abc_password";
$abc_approved_user=array("kirang","kirang","dileepd","baihr","srinivast");
$reset_master=array("kirang","dileepd","kirang","baihr","srinivast");
$reset_abc_members=array("kirang","kirang","welfarebai","prathyushak","sushumaa","sudharania","swapnan");

//********NOTE::::: Please modify view while changing this information
//Employee Allocation Designation Categories
$auto_allocation_desg_cats=array(-1,2,35,39,51,59,65,71,95);
$auto_allocation_desg_titles=array('','SM','HS','JM','TS','TA','QA','PA','BW');
$head_count_desg_cats=array(2,35,39,51,95);
//2:SMO
//35:HSL Operator (PINK)
//39:Jumper (DBLUE)
//51:Tr.SMO
//59:Tatoo Operator (ORANGE)
//65:Quality Checker - End Line (YELLOW)
//71:Packing Operator - (LBLUE)
$auto_allocation_desg_cats_bgcolor=array("nil","#FFFFFF","#ff80ff","#333344","#FFFFFF","#f5cf7e","#ffff00","#00ffff","#ccaaee");
$auto_allocation_desg_cats_ftcolor=array("black","#000000","#000000","#FFFFFF","#000000","#000000","#000000","#000000","#000000");
$auto_allocation_dep_cats=array(-1,4,7,41);
//4:Production Sewing
//7:Finising
//41:Quality
$auto_allocation_dep_cats_bgcolor=array("nil","#FFFFFF","#00ffff","#ffff00");
$auto_allocation_dep_cats_ftcolor=array("black","#000000","#000000","#000000");


//Shop Floor System Tables
$sfs_style_table="bai_pro2.movex_styles";

//Payroll Configuration
$pay_days=26;
$pay_days_payroll=26;

//To calculate leave balance (eligible leave types)
$payroll_leave_bal_cats="'SL','EL','CL'";
?>


