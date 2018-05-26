<?php
$username="sfcsproject1";
$remove_user_name = true; // set false for static username removing
// Un Hide the code from line 84 to 98
$host_adr="192.168.0.110:3323";
//$host_adr_un=(isset($username)?$username:"baiall");
$host_adr_un="baiall";
$host_adr_pw="baiall";

$host_adr1="192.168.0.110:3323";
$host_adr1_un="baiall";
$host_adr1_pw="baiall";

$host_adr_rep="10.227.100.74";
$host_adr_rep_un="baiall";
$host_adr_rep_pw="baiall";

//MSSQL
$host_adr2="192.168.0.110:3323";
$host_adr2_un="sa";
$host_adr2_pw="root";
//cynergies
$host_adr3="BAIDBSRV02";
$host_adr3_un="baihrms";
$host_adr3_pw="bai@hr";

//M3 download
$host_adr4="BAIAPPSRV03";
$host_adr4_un="sa";
//$host_adr4_pw="Bai@123$";
$host_adr4_pw="Brandix@7";


//BAI-2 HRMS Access Details
$host_adr1_bai2="BAIDBSRV03";
$host_adr1_bai2_un="qcinet";
$host_adr1_bai2_pw="qcinet";
//MSSQL
$host_adr2_bai2="BAIDBSRV03";
$host_adr2_bai2_un="sa";
$host_adr2_bai2_pw="Brandix@7";

$host_adr3_bai2="BAIAPPSRV02";
$host_adr3_bai2_un="baiall";
$host_adr3_bai2_pw="baiall";


$dns_adr="http://".$_SERVER['HTTP_HOST'];

$mail_adr="10.227.19.18";

$dns_adr1="http://192.168.0.110"; //port 80
$dns_adr2="http://192.168.0.110:81/master"; //port 81 secured
$dns_adr3="http://".$_SERVER['HTTP_HOST']."/sfcs"; //port 8080
$dns_adr4="http://192.168.0.110:8000"; //port 8000 64 bit sql server conn. & execution
$dns_adr5="http://192.168.0.110:8084/master"; //For Gallery and other applications

$dns_adr6="http://bai2net:8080"; //BAI UNIT -2 Links

$dns_adr70="http://bai3net:8080"; //BAI UNIT -3 Links

$dnr_adr_sp_chain = "http://192.168.0.110:8002";

//To Facilitate SFCS Filters
$global_facility_code="'N02'";
//$global_style_codes="'P','K','L','O','M'";
$global_style_codes="'Q','W','E','R','T','Y','U','I','O','P','A','S','D','F','G','H','J','K','L','Z','X','C','V','B','N','M'";

$input_excess_cut_as_full_input=0; //1-No/0-Yes
$global_auto_club_cuts_ims=1; //1-No, 0-Yes

$plan_as_input=0; //1-No, 0-Yes (To give plan input to module)
$session_login_fg_carton_scan=0; //1-No, 0-Yes

$fab_uom='Yds';
//take smv values from M3 (bai_orders_db_confirm)
$smv_from_m3=0; //0-Yes, 1-No
?>


<?php

	
	$server_soft=$_SERVER['SERVER_SOFTWARE'];
	
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
	
	$autoclose_page_exempted=array("baiadmn","baisysadmin","baiictadmin","baischtasksvc","sfcsproject1"); //Auto Close Exempted Pages
	$autoclose_period=1800000;
	
	//Auto close window after 30 mins
	if(!in_array($username,$autoclose_page_exempted))
	{
	echo "<script language=\"javascript\">
		setTimeout(\"window.open('', '_self'); window.close();\",$autoclose_period);
	</script>";
	}
	
?>


<!-- To Disable Back Space-->
<script language="JavaScript">

<!--
  javascript:window.history.forward(1);
//-->
</script>

<!-- To Disable Right Click-->
<script language="JavaScript">
<!--

//Disable right mouse click Script
//By Maximus (maximus@nsimail.com) w/ mods by DynamicDrive
//For full source code, visit http://www.dynamicdrive.com

var message="Function Disabled!";

///////////////////////////////////
function clickIE4(){
if (event.button==2){
alert("This Function is Disabled.","","warning");
return false;
}
}

function clickNS4(e){
if (document.layers||document.getElementById&&!document.all){
if (e.which==2||e.which==3){
swal(message);
return false;
}
}
}

if (document.layers){
document.captureEvents(Event.MOUSEDOWN);
document.onmousedown=clickNS4;
}
else if (document.all&&!document.getElementById){
document.onmousedown=clickIE4;
}

document.oncontextmenu=new Function("swal('This Function is Disabled.','','warning');return false")

// --> 
</script>

<!-- Disable Selection -->

<?php

if($username=="kiran")
{
?>
<script>
	
	//disable cut copy past
var message = "";
function clickIE() { if (document.all) { (message); return false; } }
function clickNS(e) {
    if(document.layers || (document.getElementById && !document.all)) {
        if (e.which == 2 || e.which == 3) { (message); return false; }
    }
}
if (document.layers)
{ document.captureEvents(Event.MOUSEDOWN); document.onmousedown = clickNS; }
else { document.onmouseup = clickNS; document.oncontextmenu = clickIE; }
 document.oncontextmenu = new Function("return false")


//for disable select option
document.onselectstart = new Function('return false');
function dMDown(e) { return false; }
function dOClick() { return true; }
document.onmousedown = dMDown;
//document.onclick = dOClick;
</script>

<?php
}

$sizes_array=array('s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50');

$sizes_code=array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50');

$sizes_title=array('S01','S02','S03','S04','S05','S06','S07','S08','S09','S10','S11','S12','S13','S14','S15','S16','S17','S18','S19','S20','S21','S22','S23','S24','S25','S26','S27','S28','S29','S30','S31','S32','S33','S34','S35','S36','S37','S38','S39','S40','S41','S42','S43','S44','S45','S46','S47','S48','S49','S50');

$shifts_array = array('A', 'B');

$plant_name = 'Brandix Essentials Ltd - Koggala';

$mod_names = array("1","2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "40");
?>