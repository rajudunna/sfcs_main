<!--2014-01-18/kirang/Ticket:394485/ Add kirang in $auth_cad_mem.-->
<?php

include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
//if(!isset($_SESSION)) { session_start(); }

	$auth_cad_mem=array("lokeshk","chandrasekhard","srinub","prabathsa","kirang","dineshin","sandhyaranik","kirang","kirang","pavanm","sanyasiraop","naveendw","sanyasiraog","kirang","baischtasksvc","sfcsproject1","sfcsproject2","sfcsproject3","sfcsproject4","chameeram","shaliyas");
	
	if(in_array($username,$auth_cad_mem))
	{
		$_SESSION['SESS_USER_LEVEL']=1;
		$_SESSION['SESS_MEMBER_ID']=1;
	}
	else
	{
		
	}
	
	

$basepath="$dns_adr/projects/beta/cut_plan_new/";

/*	
echo "<div id=\"colortab\" class=\"ddcolortabs\">";
echo "<ul>";
echo "<li><a href=\"".$basepath."test"."."."php\" title=\"Home\"><span>Search</span></a></li>";
if($_SESSION['SESS_USER_LEVEL']==1) {
echo "<li><a title=\"Work Place\" rel=\"dropmenu2\"><span>Work Place</span></a></li>";
echo "<li><a title=\"Audit Place\" rel=\"dropmenu22\"><span>Audit Place</span></a></li>";
}

if($_SESSION['SESS_USER_LEVEL']==2) {
echo "<li><a title=\"Audit Place\" rel=\"dropmenu22\"><span>Audit Place</span></a></li>";
}

echo "<li><a title=\"Reports\" rel=\"dropmenu3\"><span>Reports</span></a></li>";


if($_SESSION['SESS_USER_LEVEL']==1) {
echo "<li><a title=\"Control Panel\" rel=\"dropmenu1\"><span>Control Panel</span></a></li>";
}

echo "<li><a title=\"Forms\" rel=\"dropmenu6\"><span>Forms</span></a></li>";

if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) {
echo "<li><a href=\"".$basepath."phplogin/logout"."."."php\" title=\"Logout\"><span>Logout</span></a></li>";
}
else{
echo "<li><a href=\"".$basepath."phplogin/login-form"."."."php\" title=\"Login\"><span>Login</span></a></li>";	
}

echo "</ul>";
echo "</div>";

echo "<div class=\"ddcolortabsline\">&nbsp;</div>";


                                               
echo "<div id=\"dropmenu2\" class=\"dropmenudiv_a\">";

echo "<a href=\"".$basepath."dumindu/interact"."."."php\">CAD Jobs</a>";
//echo "<a href=\"".$basepath."ims/ims"."."."php\">Production Input Track</a>";
//echo "<a href=\"".$basepath."ims/recut_ims"."."."php\">ReCUT Input Track</a>";
echo "<a href=\"".$basepath."recut_v1/recut_db"."."."php\">ReCUT CAD Panel</a>";
echo "</div>";


echo "<div id=\"dropmenu22\" class=\"dropmenudiv_a\">";
//echo "<a href=\"".$basepath."ims_v1/ims_check"."."."php\">Input Audit</a>";
echo "<a href=\"".$basepath."dumindu/doc_track_panel"."."."php\">Cutting Fabric Track</a>";
echo "<a href=\"".$basepath."ims_v1/transaction_log"."."."php\">Input Transaction Log</a>";
echo "<a href=\"".$basepath."ims_v1/transaction_log_zero"."."."php\">ZERO Input Transaction Log</a>";
//echo "<a href=\"".$basepath."ims_v1/recut_transaction_log"."."."php\">Recut Input Transaction Log</a>";
echo "<a href=\"".$basepath."dumindu/kpi_input_form"."."."php\">KPI Input Form</a>";
echo "</div>";

echo "<div id=\"dropmenu6\" class=\"dropmenudiv_a\">";
echo "<a href=\"".$basepath."recut_v2/search"."."."php\">Recut Docket</a>";
//echo "<a href=\""."$dns_adr/projects/beta/cut_plan_new_ms/"."recut_v1/search"."."."php\">M&S Recut Docket</a>";
echo "</div>";

                                  
echo "<div id=\"dropmenu1\" class=\"dropmenudiv_a\" style=\"width: 150px;\">";
echo "<a href=\"".$basepath."Movex_Order_Tool_v1.1"."."."xls\">DB Update Tool</a>";
echo "<a href=\"".$basepath."temp/upload_ac"."."."php\">Upload</a>";
echo "</div>";

echo "<div id=\"dropmenu3\" class=\"dropmenudiv_a\">";
echo "<a href=\"".$basepath."reports/view/csr_view"."."."php\">Cutting Status Report</a>";
echo "<a href=\"".$basepath."reports/view/cr_view"."."."php\">Consumption Report</a>";
echo "<a href=\"".$basepath."reports/view/fsr_view"."."."php\">Fabric Saving Report</a>";
echo "<a href=\"".$basepath."reports/view/isr_view"."."."php\">Input Status Report</a>";
echo "<a href=\"".$basepath."reports/view/kpi"."."."php\">Key Performance Indicator</a>";
echo "<a href=\"".$basepath."reports/view/ssrcd_view"."."."php\">Style Status Report - Cut Details</a>";
echo "<a href=\"".$basepath."reports/view/ssrfd_view"."."."php\">Style Status Report - Fabric Details</a>";
echo "<a href=\"".$basepath."ims/cpanel/cpanel_main"."."."php\">WIP Track CPANEL</a>";
echo "</div>";


echo "<script type=\"text/javascript\">";
echo "tabdropdown"."."."init(\"colortab\", 3)";
echo "</script>";
*/
?>