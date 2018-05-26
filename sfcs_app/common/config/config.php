<?php 
//Without LDAP , With LDAP Unblock LDAP Code
$username="sfcsproject1";
$remove_user_name = true; // set false for static username removing 

//SFCS Db Configurations
$host="192.168.0.110:3326";
$user="baiall";
$pass="baiall";

//To Facilitate SFCS Filters
$global_facility_code="'N02'";

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


$sizes_array=array('s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50');

$sizes_code=array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50');

$sizes_title=array('S01','S02','S03','S04','S05','S06','S07','S08','S09','S10','S11','S12','S13','S14','S15','S16','S17','S18','S19','S20','S21','S22','S23','S24','S25','S26','S27','S28','S29','S30','S31','S32','S33','S34','S35','S36','S37','S38','S39','S40','S41','S42','S43','S44','S45','S46','S47','S48','S49','S50');

$plant_name = 'Brandix Essentials Ltd - Koggala';

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
$brandix_bts_uat="brandix_bts_uat";
$m3_inputs="m3_inputs";
$m3_bulk_ops_rep_db="m3_bulk_ops_rep_db";

$link= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $pass)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link, $bai_pro3) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

?>