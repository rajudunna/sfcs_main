<?php
error_reporting(0);
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_dashboard.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_v2.php');

$data=array();

$sectionId=$_GET["sec_id"];
$sectionName=$_GET["sec_name"];
$plantCode=$_GET["plant_code"];
$priorityLimit=$_GET["priority_limit"];
$tasktype = TaskTypeEnum::SEWINGJOB;
$getModuleDetails = getWorkstationsForSectionId($plantCode,$sectionId);
$v_r = explode('/',$_SERVER['REQUEST_URI']);
array_pop($v_r);
$popup_url = "http://".$_SERVER['HTTP_HOST'].implode('/',$v_r)."/board_update_V2_input.php";


	$ips_data='<div style="margin-left:15%">';
	$ips_data.="<p>";
	$ips_data.="<table>";
	$ips_data.="<tr><th colspan=2><h2><a href=\"javascript:void(0)\" onclick=\"Popup=window.open('$popup_url?section_no=$sectionId"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=880,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$sectionName</a></h2></th></th></tr>";
foreach($getModuleDetails as $moduleKey =>$moduleRecord)
{
	$workstationID =$moduleRecord['workstationId'];
	$workstationCode =$moduleRecord['workstationCode'];
	$workstationCode =$moduleRecord['workstationCode'];
	$workstationCode =$moduleRecord['workstationCode'];
	
	// var_dump($workstationID);
	
	//hardcode 
	$wip = 0;
	$ips_data.="<tr class=\"bottom\">";
	$ips_data.="<td class=\"bottom\"><strong><a href=\"javascript:void(0)\" title=\"WIP : $wip\"><font class=\"fontnn\" color=black >$workstationCode</font></a></strong></td><td>";
	$ips_data.="</tr>";
	
	// $result_planned_jobs=getPlannedJobs($workstationID,$tasktype,$plantCode);
	// var_dump($result_planned_jobs);
}
	$ips_data.="</table>";
	$ips_data.="</p>";
	$ips_data.="</div>";

$data['data']=$ips_data;
$data['sec']=$sectionId;
echo json_encode($data);

?>