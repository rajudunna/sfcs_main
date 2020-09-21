<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/enums.php');
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
$color=$_GET['color'];
$input_job=$_GET['input_job'];
$inputJobNo=$_GET['inputJobNo'];
$date=date('Y-m-d');

	/**
	 * getting cut jobs based on jm jg header 
	 */
	$taskType = TaskTypeEnum::SEWINGJOB;
	//Qry to check sewing job planned or not
	$check_job_status="SELECT task_header_id,resource_id FROM $tms.task_header WHERE task_ref='$input_job' AND plant_code='$plantcode' AND task_type='$taskType' AND (resource_id IS NOT NULL OR  resource_id!='')";
	$job_status_result=mysqli_query($link_new, $check_job_status) or exit("Sql Error at check_job_status".mysqli_error($GLOBALS["___mysqli_ston"]));    
	$job_status_num=mysqli_num_rows($job_status_result);
	if($job_status_num>0){
		while($task_header_id_row=mysqli_fetch_array($job_status_result))
			{
				$task_header_id[]=$task_header_id_row['task_header_id'];
				$resource_id=$task_header_id_row['resource_id'];
			}

			/**
			 * getting workstation based resource id
			 */
			$qryGetWorkstation="SELECT workstation_description FROM $pms.workstation WHERE workstation_id='$resource_id' AND plant_code='$plantcode' AND is_active=1";
			$getWorkstationResult=mysqli_query($link_new, $qryGetWorkstation) or exit("Sql Error at check_job_status".mysqli_error($GLOBALS["___mysqli_ston"]));    
			$workstationNum=mysqli_num_rows($getWorkstationResult);
			if($workstationNum>0){
				while($workstationRow=mysqli_fetch_array($getWorkstationResult))
				{
					$workstationDescription=$workstationRow['workstation_description'];
				}
			}
		//Qry to fetch taskrefrence from task_job  
		$qry_toget_taskrefrence="SELECT task_jobs_id FROM $tms.task_jobs WHERE task_type='$tasktype' AND plant_code='$plantcode' AND task_header_id IN ('".implode("','" , $task_header_id)."')";
		$toget_taskrefrence_result=mysqli_query($link_new, $qry_toget_taskrefrence) or exit("Sql Error at toget_task_job".mysqli_error($GLOBALS["___mysqli_ston"]));
		$toget_taskrefrence_num=mysqli_num_rows($toget_taskrefrence_result);
		if($toget_taskrefrence_num>0){
				while($toget_taskrefrence_row=mysqli_fetch_array($toget_taskrefrence_result))
				{  
					$task_jobs_id[]=$toget_taskrefrence_row['task_jobs_id'];
				}

				/**getting cut jobs based on task job id */
				$qry_toget_style_sch="SELECT GROUP_CONCAT(IF(attribute_name='SCHEDULE', attribute_VALUE, NULL) SEPARATOR ',') AS SCHEDULE,GROUP_CONCAT(IF(attribute_name='STYLE', attribute_VALUE, NULL) SEPARATOR ',') AS STYLEGROUP_CONCAT(IF(attribute_name='PONUMBER', attribute_VALUE, NULL) SEPARATOR ',') AS PONUMBER, FROM $tms.`task_attributes` WHERE  plant_code='AIP' AND task_jobs_id IN ('".implode("','" , $task_jobs_id)."') GROUP BY attribute_name";
				echo $qry_toget_style_sch;
				$qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) {
					
						if($row2['SCHEDULE']!=''){
							$schedules = $row2['SCHEDULE'];
						}
						if($row2['STYLE']!=''){
							$styles = $row2['STYLE'];
						}
						if($row2['PONUMBER']!=''){
							$poNumber = $row2['PONUMBER'];
						}
				}
		}
	}

	/**
	 * getting destination from oms details
	 */
	$qryGetDestination="SELECT destination,vpo FROM $oms.oms_mo_details WHERE po_number='$poNumber' AND plant_code='$plantcode' AND is_active='1' LIMIT 0,1";
	$getDestinationResult=mysqli_query($link_new, $qryGetDestination) or exit("Sql Error at destination".mysqli_error($GLOBALS["___mysqli_ston"]));    
	$destinationNum=mysqli_num_rows($getDestinationResult);
	if($destinationNum>0){
		while($destinationRow=mysqli_fetch_array($getDestinationResult))
			{
				$c_block=$destinationRow['destination'];
				$vpo=$destinationRow['vpo'];
			}
		}

?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 15">
<link rel=File-List href="line_reconsile_files/filelist.xml">
<style id="Book2_32733_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl1532733
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6332733
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6432733
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6532733
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6632733
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl6732733
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6832733
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl6932733
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7032733
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7132733
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7232733
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7332733
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:"Short Date";
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7432733
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7532733
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7632733
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7732733
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7832733
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
-->
body{
	zoom:100%;
}

</style>

<style type="text/css">
@page
{
	size: landscape;
	margin: 0cm;
}
</style>

<style>

@media print {
@page narrow {size: 9in 11in}
@page rotated {size: landscape}
DIV {page: narrow}
TABLE {page: rotated}
#non-printable { display: none; }
#printable { display: block; }
#logo { display: block; }
body { zoom:100%;}
#ad{ display:none;}
#leftbar{ display:none;}
#CUT_PLAN_NEW_13019{ width:57%; margin-left:20px;}
}
</style>

<script>
function printpr()
{
var OLECMDID = 7;
/* OLECMDID values:
* 6 - print
* 7 - print preview
* 1 - open window
* 4 - Save As
*/
var PROMPT = 1; // 2 DONTPROMPTUSER
var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
WebBrowser1.ExecWB(OLECMDID, PROMPT);
WebBrowser1.outerHTML = "";
}
</script>
</head>

<body onload="printpr();">
<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Excel's Publish as Web
Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<div id="Book2_32733" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=1172 style='border-collapse:
 collapse;table-layout:fixed;width:881pt'>
 <col width=35 style='mso-width-source:userset;mso-width-alt:1280;width:26pt'>
 <col width=88 style='mso-width-source:userset;mso-width-alt:3218;width:66pt'>
 <col width=87 style='mso-width-source:userset;mso-width-alt:3181;width:65pt'>
 <col width=64 span=2 style='width:48pt'>
 <col width=37 style='mso-width-source:userset;mso-width-alt:1353;width:28pt'>
 <col width=66 style='mso-width-source:userset;mso-width-alt:2413;width:50pt'>
 <col width=99 style='mso-width-source:userset;mso-width-alt:3620;width:74pt'>
 <col width=93 style='mso-width-source:userset;mso-width-alt:3401;width:70pt'>
 <col width=58 style='mso-width-source:userset;mso-width-alt:2121;width:44pt'>
 <col width=59 style='mso-width-source:userset;mso-width-alt:2157;width:44pt'>
 <col width=57 span=2 style='mso-width-source:userset;mso-width-alt:2084;
 width:43pt'>
 <col width=102 style='mso-width-source:userset;mso-width-alt:3730;width:77pt'>
 <col width=166 style='mso-width-source:userset;mso-width-alt:6070;width:125pt'>
 <col width=40 style='mso-width-source:userset;mso-width-alt:1462;width:30pt'>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'><a
  name="RANGE!A1"></a></td>
  <td class=xl6632733 width=88 style='width:66pt'></td>
  <td class=xl6632733 width=87 style='width:65pt'></td>
  <td class=xl6632733 width=64 style='width:48pt'></td>
  <td class=xl6632733 width=64 style='width:48pt'></td>
  <td class=xl6632733 width=37 style='width:28pt'></td>
  <td class=xl6632733 width=66 style='width:50pt'></td>
  <td class=xl6632733 width=99 style='width:74pt'></td>
  <td class=xl6632733 width=93 style='width:70pt'></td>
  <td class=xl6632733 width=58 style='width:44pt'></td>
  <td class=xl6632733 width=59 style='width:44pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl6632733 width=102 style='width:77pt'></td>
  <td class=xl6632733 width=166 style='width:125pt'></td>
  <td class=xl6632733 width=40 style='width:30pt'></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'></td>
  <td colspan=14 class=xl7132733 width=1097 style='width:825pt'>Line
  Reconciliation sheet &amp; Line input sheet</td>
  <td class=xl6632733 width=40 style='width:30pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'></td>
  <td class=xl6632733 width=88 style='width:66pt'></td>
  <td class=xl6632733 width=87 style='width:65pt'></td>
  <td class=xl6632733 width=64 style='width:48pt'></td>
  <td class=xl6632733 width=64 style='width:48pt'></td>
  <td class=xl6632733 width=37 style='width:28pt'></td>
  <td class=xl6632733 width=66 style='width:50pt'></td>
  <td class=xl6632733 width=99 style='width:74pt'></td>
  <td class=xl6632733 width=93 style='width:70pt'></td>
  <td class=xl6632733 width=58 style='width:44pt'></td>
  <td class=xl6632733 width=59 style='width:44pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl7232733 width=102 style='width:77pt'></td>
  <td class=xl1532733></td>
  <td class=xl6632733 width=40 style='width:30pt'></td>
 </tr>
  <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'></td>
  <td class=xl6632733 width=88 style='width:66pt'></td>
  <td class=xl6632733 width=87 style='width:65pt'></td>
  <td class=xl6632733 width=64 style='width:48pt'></td>
  <td class=xl6632733 width=64 style='width:48pt'></td>
  <td class=xl6632733 width=37 style='width:28pt'></td>
  <td class=xl6632733 width=66 style='width:50pt'></td>
  <td class=xl6632733 width=99 style='width:74pt'></td>
  <td class=xl6632733 width=93 style='width:70pt'></td>
  <td class=xl6632733 width=58 style='width:44pt'></td>
  <td class=xl6632733 width=59 style='width:44pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl7232733 width=102 style='width:77pt'>Date:</td>
  <td class=xl7332733 width=166 style='width:125pt'><?php echo $date;?></td>
  <td class=xl6632733 width=40 style='width:30pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'></td>
  <td class=xl6932733 width=88 style='width:66pt'>Style</td>
  <td class=xl7032733 width=87 style='border-left:none;width:65pt'><?php echo $styles;?></td>
  <td class=xl6932733 width=64 style='border-left:none;width:48pt'>Schedule</td>
  <td class=xl7032733 width=64 style='border-left:none;width:48pt'><?php echo $schedules;?></td>
  <td class=xl6632733 width=37 style='width:28pt'></td>
  <td class=xl6632733 width=66 style='width:50pt'></td>
  <td class=xl6632733 width=99 style='width:74pt'></td>
  <td class=xl6632733 width=93 style='width:70pt'></td>
  <td class=xl6632733 width=58 style='width:44pt'></td>
  <td class=xl6632733 width=59 style='width:44pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl6632733 width=102 style='width:77pt'></td>
  <td class=xl7232733 width=166 style='width:125pt'></td>
  <td class=xl6632733 width=40 style='width:30pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'></td>
  <td class=xl6932733 width=88 style='border-top:none;width:66pt'>Color</td>
  <td colspan=3 class=xl7432733 width=215 style='border-right:.5pt solid black;
  border-left:none;width:161pt'><?php echo $color;?></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl6532733>VPO</td>
  <td  colspan=4 class=xl6532733><?php echo $vpo;?></td>
 
  <td class=xl1532733></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'></td>
  <td class=xl6932733 width=88 style='border-top:none;width:66pt'>Country code</td>
  <td class=xl6932733 width=87 style='border-top:none;border-left:none;
  width:65pt'><?php echo $c_block;?></td>
  <td rowspan=2 class=xl7732733 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'>Line no</td>
  <td rowspan=2 class=xl7732733 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php echo $workstationDescription; ?></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
 
  
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'></td>
  <td class=xl6932733 width=88 style='border-top:none;width:66pt'>Sewing Job no</td>
  <td class=xl7032733 width=87 style='border-top:none;border-left:none;
  width:65pt'><?php echo $inputJobNo; ?></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
   
  
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl6632733 width=37 style='width:28pt'></td>
  <td class=xl6632733 width=66 style='width:50pt'></td>
  <td class=xl6632733 width=99 style='width:74pt'></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl6632733 width=102 style='width:77pt'></td>
  <td class=xl6632733 width=166 style='width:125pt'></td>
  <td class=xl6632733 width=40 style='width:30pt'></td>
 </tr>
  <tr height=40 style='mso-height-source:userset;height:30.0pt'>
  <td height=40 class=xl6632733 width=35 style='height:30.0pt;width:26pt'></td>
  <td class=xl6932733 width=88 style='width:66pt'>S. No.</td>
  <td class=xl6932733 width=87 style='border-left:none;width:65pt'>Bundle #</td>
  <td class=xl6932733 width=64 style='border-left:none;width:48pt'>Size</td>
  <td class=xl6932733 width=64 style='border-left:none;width:48pt'>In Qty</td>
  <td class=xl6932733 colspan=2 width=93 style='border-left:none;width:80pt'>Date</td>
  <td class=xl6932733 width=99 style='border-left:none;width:74pt'>Rec. Sign</td>
   <td class=xl6932733 width=58 style='border-left:none;width:44pt'>Out Qty</td>
  <td class=xl6932733 width=59 style='border-left:none;width:44pt'>Variance</td>
  <td class=xl6932733 width=57 style='border-left:none;width:43pt'>Reject</td>
  <td class=xl6932733 width=57 style='border-left:none;width:43pt'>Sample</td>
  <td class=xl6932733 width=102 style='border-left:none;width:77pt'>Packing
  Rec.</td>
  <td class=xl6932733 colspan=2  width=166 style='border-left:none;width:125pt'>Remarks</td>
  <td class=xl6632733 width=40 style='width:30pt'></td>
 </tr>
  <?php
  $total=0;
	/**
	 * getting bundles info based on input job and color
	 */
	$qryBundleInfo="SELECT bundle_number,quantity,size FROM $pps.jm_job_bundles WHERE jm_jg_header_id='$input_job' AND fg_color='$color' AND plant_code='$plantcode' AND is_active=1 GROUP BY bundle_number";
	$qryBundleInfoResult=mysqli_query($link_new, $qryBundleInfo) or exit("Sql Error at destination".mysqli_error($GLOBALS["___mysqli_ston"]));    
	$destinationNum=mysqli_num_rows($qryBundleInfoResult);
	if($destinationNum>0){
		while($bundleRow=mysqli_fetch_array($qryBundleInfoResult))
			{
				$bundle_number=$bundleRow['bundle_number'];
				$quantity=$bundleRow['quantity'];
				$size=$bundleRow['size'];

				?>
				<tr height=30 style='mso-height-source:userset;height:22.5pt'>
				<td height=30 class=xl6632733 width=35 style='height:22.5pt;width:26pt'></td>
				<td class=xl7132733 width=88 style='border-top:none;width:66pt'><?php echo ($i+1);?></td>
				<td class=xl7132733 width=87 style='border-top:none;border-left:none;
				width:65pt'><?php echo $bundle_number;?></td>
				<td class=xl7132733 width=93 style='border-top:none;border-left:none;
				width:48pt'><?php echo $size;?></td>
				<td class=xl7132733 width=64 style='border-top:none;border-left:none;
				width:48pt'><?php echo $quantity;?></td>
				<td class=xl6932733 colspan=2 width=37 style='border-top:none;border-left:none;
				width:80pt'>&nbsp;</td>

				<td class=xl6932733 width=99 style='border-top:none;border-left:none;
				width:74pt'>&nbsp;</td>
				
				<td class=xl6932733 width=58 style='border-top:none;border-left:none;
				width:44pt'>&nbsp;</td>
				<td class=xl6932733 width=59 style='border-top:none;border-left:none;
				width:44pt'>&nbsp;</td>
				<td class=xl6932733 width=57 style='border-top:none;border-left:none;
				width:43pt'>&nbsp;</td>
				<td class=xl6932733 width=57 style='border-top:none;border-left:none;
				width:43pt'>&nbsp;</td>
				<td class=xl6932733 width=102 style='border-top:none;border-left:none;
				width:77pt'>&nbsp;</td>
				<td class=xl6932733 colspan=2 width=166 style='border-top:none;border-left:none;
				width:125pt'>&nbsp;</td>
				<td class=xl6632733 width=40 style='width:30pt'></td>
				</tr>
				<?php
					$total+= $quantity[$bundle_num[$i]];	
			}
	}
	
  
  ?>
 <tr height=30 style='mso-height-source:userset;height:22.5pt'>
  <td height=30 class=xl6632733 width=35 style='height:22.5pt;width:26pt'></td>
  <td class=xl7132733 colspan=3 width=88 style='border-top:none;width:66pt'>Total</td>
  <td class=xl7132733 width=64 style='border-top:none;border-left:none;
  width:48pt'><?php echo $total;?></td>
  <td class=xl6932733 colspan=2 width=37 style='border-top:none;border-left:none;
  width:28pt'>&nbsp;</td>
  <td class=xl6932733 width=99 style='border-top:none;border-left:none;
  width:74pt'>&nbsp;</td>
  <td class=xl6932733 width=93 style='border-top:none;border-left:none;
  width:70pt'>&nbsp;</td>
  <td class=xl6932733 width=58 style='border-top:none;border-left:none;
  width:44pt'>&nbsp;</td>
  <td class=xl6932733 width=59 style='border-top:none;border-left:none;
  width:44pt'>&nbsp;</td>
  <td class=xl6932733 width=57 style='border-top:none;border-left:none;
  width:43pt'>&nbsp;</td>
  <td class=xl6932733 width=57 style='border-top:none;border-left:none;
  width:43pt'>&nbsp;</td>
  <td class=xl6932733 colspan=2 width=102 style='border-top:none;border-left:none;
  width:77pt'>&nbsp;</td>
   <td class=xl6632733 width=40 style='width:30pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'></td>
  <td class=xl6632733 width=88 style='width:66pt'></td>
  <td class=xl6632733 width=87 style='width:65pt'></td>
  <td class=xl6632733 width=64 style='width:48pt'></td>
  <td class=xl6632733 width=64 style='width:48pt'></td>
  <td class=xl6632733 width=37 style='width:28pt'></td>
  <td class=xl6632733 width=66 style='width:50pt'></td>
  <td class=xl6632733 width=99 style='width:74pt'></td>
  <td class=xl6632733 width=93 style='width:70pt'></td>
  <td class=xl6632733 width=58 style='width:44pt'></td>
  <td class=xl6632733 width=59 style='width:44pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl6632733 width=102 style='width:77pt'></td>
  <td class=xl6632733 width=166 style='width:125pt'></td>
  <td class=xl6632733 width=40 style='width:30pt'></td>
 </tr>
 <tr class=xl1532733 height=20 style='height:15.0pt'>
  <td height=20 class=xl6732733 style='height:15.0pt'></td>
  <td class=xl6732733 colspan=2>-----------------</td>
  <td class=xl6732733></td>
  <td colspan=3 class=xl6332733>--------------------------</td>
  <td class=xl6732733></td>
  <td colspan=2 class=xl6332733>-------------------</td>
  <td class=xl6732733></td>
  <td colspan=2 class=xl6332733>-------------------</td>
  <td class=xl6732733></td>
  <td class=xl6732733>-----------------</td>
  <td class=xl6732733></td>
 </tr>
 <tr class=xl1532733 height=20 style='height:15.0pt'>
  <td height=20 class=xl6732733 style='height:15.0pt'></td>
  <td class=xl6332733>Recorder</td>
  <td class=xl1532733></td>
  <td class=xl1532733></td>
  <td colspan=3 class=xl6332733>Production Co-Ordinator</td>
  <td class=xl1532733></td>
  <td colspan=2 class=xl6332733>Line Leader</td>
  <td class=xl1532733></td>
  <td colspan=2 class=xl6332733>Supervisor</td>
  <td class=xl1532733></td>
  <td class=xl6732733>QC supervisor</td>
  <td class=xl6732733></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6632733 width=35 style='height:15.0pt;width:26pt'></td>
  <td class=xl6632733 width=88 style='width:66pt'></td>
  <td class=xl6632733 width=87 style='width:65pt'></td>
  <td class=xl6632733 width=64 style='width:48pt'></td>
  <td class=xl6632733 width=64 style='width:48pt'></td>
  <td class=xl6632733 width=37 style='width:28pt'></td>
  <td class=xl6632733 width=66 style='width:50pt'></td>
  <td class=xl6632733 width=99 style='width:74pt'></td>
  <td class=xl6632733 width=93 style='width:70pt'></td>
  <td class=xl6632733 width=58 style='width:44pt'></td>
  <td class=xl6632733 width=59 style='width:44pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl6632733 width=57 style='width:43pt'></td>
  <td class=xl6632733 width=102 style='width:77pt'></td>
  <td class=xl6632733 width=166 style='width:125pt'></td>
  <td class=xl6632733 width=40 style='width:30pt'></td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=35 style='width:26pt'></td>
  <td width=88 style='width:66pt'></td>
  <td width=87 style='width:65pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=37 style='width:28pt'></td>
  <td width=66 style='width:50pt'></td>
  <td width=99 style='width:74pt'></td>
  <td width=93 style='width:70pt'></td>
  <td width=58 style='width:44pt'></td>
  <td width=59 style='width:44pt'></td>
  <td width=57 style='width:43pt'></td>
  <td width=57 style='width:43pt'></td>
  <td width=102 style='width:77pt'></td>
  <td width=166 style='width:125pt'></td>
  <td width=40 style='width:30pt'></td>
 </tr>
 <![endif]>
</table>

</div>


<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
</body>

</html>
