<?php 
//Without LDAP , With LDAP Unblock LDAP Code
//$username="sfcsproject1";
$mysql_details = get_config_values(getmysqldb);
$mssql_odbc_details = get_config_values(mssql-odbc);
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$user=$username=strtolower($username_list[1]);
$remove_user_name = true; // set false for static username removing 

//SFCS Mysql Db Configurations
$host=$mysql_details['db_host'].":".$mysql_details['db_port'];
$user=$mysql_details['db_user'];
$pass=$mysql_details['db_pass'];

//MSSql Configurations
$ms_sql_odbc_host = get_config_values(mssql-odbc);
$ms_sql_odbc_user = get_config_values(mssql-user-name);
$ms_sql_odbc_pass = get_config_values(mssql-password);

//MY SQL host
$ms_sql_odbc_host = get_config_values(mysql-odbc);

//To Facilitate SFCS Filters
$global_facility_code=get_config_values(plantcode);

//User access code
$server_soft=$_SERVER['SERVER_SOFTWARE'];
    
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
$dnr_adr_sp_chain = "http://192.168.0.110:8002"; 
$fab_uom=get_config_values(uom);
$sizes_array=array('s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50');

$sizes_code=array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50');

$sizes_title=array('S01','S02','S03','S04','S05','S06','S07','S08','S09','S10','S11','S12','S13','S14','S15','S16','S17','S18','S19','S20','S21','S22','S23','S24','S25','S26','S27','S28','S29','S30','S31','S32','S33','S34','S35','S36','S37','S38','S39','S40','S41','S42','S43','S44','S45','S46','S47','S48','S49','S50');

$shifts_array = get_config_values(shifts);

$mod_names = array("1","2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "40");

$plant_name = get_config_values(plantname);

$in_categories = get_config_values('category-display-dashboard');

//Central Administraion Group ID's
$group_id_sfcs=8;
$group_id_Main=5;


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

$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $pass)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link, $bai_pro3) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

$operation=array("Please Select","Single Colour & Single Size","Multi Colour & Single Size","Multi Colour & Multi Size","Single Colour & Multi Size(Non Ratio Pack)","Single Colour & Multi Size(Ratio Pack)");

$filter_joins="order_joins not in (1,2) and ";

$sql_query = "select * from $central_administration_sfcs.rbac_permission where status='active'";
$res_query = mysqli_query($link, $sql_query);
while($sql_row=mysqli_fetch_array($res_query))
{
	parse_str($sql_row['permission_name']."=".$sql_row['permission_id']);   
}

$pack_query="SELECT * FROM $bai_pro3.`pack_methods` WHERE STATUS='active'";
$pack_result=mysqli_query($link, $pack_query) or exit("Error getting pack details");
while($methods=mysqli_fetch_array($table_result))
{
    $pack_methods[]=$methods['pack_method_name'];
}
?>