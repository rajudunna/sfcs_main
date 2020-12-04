<!--
Core Module:In this interface we can get module wise plan details for fabric issuing priority.

Description: We can allocate fabric based on the plan priority.

Changes Log:
-->

<?php
set_time_limit(2000);
include("../../../../common/config/config.php");
include("../../../../common/config/functions.php");
include("../../../../common/config/functions_dashboard.php");
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_v2.php');
error_reporting(0);
$section_no=$_GET['section_no'];
?>

<html>
<head>

<title>Board Update</title>

<link rel="stylesheet" type="text/css" href= "../../common/css/page_style.css" />
<style>
body
{
	font-family: Century Gothic;
	font-size: 14px;
}
table{
	font-size:10px;
}

.white {
  width:20px;
  height:20px;
  background-color: #ffffff;
  display:block;
  float: left;
  margin: 2px;
  border: 1px solid black;
}

.white a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.white a:hover {
  text-decoration:none;
  background-color: #ffffff;
}


.red {
  width:20px;
  height:20px;
  background-color: #ff0000;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.red a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.red a:hover {
  text-decoration:none;
  background-color: #ff0000;
}

.green {
  width:20px;
  height:20px;
  background-color: #00ff00;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.green a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.green a:hover {
  text-decoration:none;
  background-color: #00ff00;
}

.lgreen {
  width:20px;
  height:20px;
  background-color: #339900;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
 
 }

.lgreen a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
 
}

.lgreen a:hover {
  text-decoration:none;
  background-color: #339900;
  
}

.yellow {
  width:20px;
  height:20px;
  background-color: #ffff00;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.yellow a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.yellow a:hover {
  text-decoration:none;
  background-color: #ffff00;
}


.pink {
  width:20px;
  height:20px;
  background-color: #ff00ff;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.pink a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.pink a:hover {
  text-decoration:none;
  background-color: #ff00ff;
}

.orange {
  width:20px;
  height:20px;
  background-color: #991144;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.orange a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.orange a:hover {
  text-decoration:none;
  background-color: #991144;
}

.blue {
  width:20px;
  height:20px;
  background-color: #15a5f2;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.blue a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.blue a:hover {
  text-decoration:none;
  background-color: #15a5f2;
}


.yash {
  width:20px;
  height:20px;
  background-color: #999999;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.yash a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.yash a:hover {
  text-decoration:none;
  background-color: #999999;
}

.black {
  width:20px;
  height:20px;
  background-color: black;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.brown {
  width:20px;
  height:20px;
  background-color: #333333;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.black a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}
.black a:hover {
  text-decoration:none;
  background-color: black;
}
</style>
</head>

<body>
<h2><font color="blue">Input Job Plan Details</font></h2>
<?php
echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color=\"blue\">Please wait while preparing dashboard...</font></h1></center></div>";
ob_end_flush();
flush();
usleep(1);
$sqlx1="SELECT section_name as  section_display_name, plant_code FROM $pms.`sections` WHERE section_id = '$section_no'";
$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
{
	$section_display_name=$sql_rowx1['section_display_name'];
	$plantCode = $sql_rowx1['plant_code'];
}
echo "<table>";
echo "<tr><th style='background-color:red;' colspan=10 >Production Plan for $section_display_name</th><th style='background-color:red;' colspan=20 style='text-align:left;'>Date : ".date("Y-m-d H:i")."</th></tr>";
echo "<tr><th>Mod#</th><th>Legend</th><th>Priority 1</th><th>Remarks</th><th>Priority 2</th><th>Remarks</th><th>Priority 3</th><th>Remarks</th><th>Priority 4</th><th>Remarks</th><th>Priority 5</th><th>Remarks</th><th>Priority 6</th><th>Remarks</th><th>Priority 7</th><th>Remarks</th><th>Priority 8</th><th>Remarks</th><th>Priority 9</th><th>Remarks</th><th>Priority 10</th><th>Remarks</th><th>Priority 11</th><th>Remarks</th><th>Priority 12</th><th>Remarks</th><th>Priority 13</th><th>Remarks</th><th>Priority 14</th><th>Remarks</th></tr>";
$getModuleDetails = getWorkstationsForSectionId($plantCode,$section_no);

foreach($getModuleDetails as $moduleKey =>$moduleRecord)
{	
	echo " module: ".$moduleRecord['workstationCode'];
	echo "<tr>";
	echo "<td>".$moduleRecord['workstationCode']."</td>";
	echo "<td align=\"right\">Style:<br/>Schedule:<br/>Sewing Job:<br/>Cut Job:<br/>Job Qty:<br/></td>";
	$module=$moduleRecord['workstationId'];		
	$order_col="";
	// getting task jobs for module in the loop
	$task_jobs_qry = "SELECT DISTINCT  tj.task_jobs_id as task_jobs_id FROM `$tms`.`task_header` th 
	LEFT JOIN $tms.`task_jobs` tj ON tj.`task_header_id` = th.`task_header_id`
	LEFT  JOIN $tms.`job_trims` tm ON tm.`task_job_id` = tj.`task_jobs_id`
	WHERE `resource_id` = '$module' AND trim_status = 'OPEN' ORDER BY tj.`priority`";
	$task_jobs_qry_result1=mysqli_query($link, $task_jobs_qry) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($task_job_row=mysqli_fetch_array($task_jobs_qry_result1))
	{
		$task_job_id = $task_job_row['task_jobs_id'];
		$qry_toget_style_sch = "SELECT attribute_name,attribute_value FROM $tms.task_attributes where task_jobs_id = '$task_job_id' and plant_code='$plantCode' and is_active=1";
		// echo $qry_toget_style_sch.'<br/>';
		$qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("Sql Error at toget_style_sch" . mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) {
			$job_detail_attributes[$row2['attribute_name']] = $row2['attribute_value'];
		}
		$doc_no_ref = $job_detail_attributes[$sewing_job_attributes['docketno']];
		// echo $doc_no_ref.'<br/>';
		$doc_no_ref1 = $job_detail_attributes[$sewing_job_attributes['docketno']];
		$input_job_no_random_ref= $task_job_id;
		$doc_no_ref_input = $job_detail_attributes[$sewing_job_attributes['docketno']];
		$style = $job_detail_attributes[$sewing_job_attributes['style']];
		$schedule = $job_detail_attributes[$sewing_job_attributes['schedule']];
		$schedule_no = $job_detail_attributes[$sewing_job_attributes['schedule']];
		$order_cols = $job_detail_attributes[$sewing_job_attributes['color']];
		$color = $job_detail_attributes[$sewing_job_attributes['color']];
		$cols_de = str_pad("Color:".trim($color),80)."\n";
		$jobno = $job_detail_attributes[$sewing_job_attributes['sewingjobno']];
		$type_of_sewing = $job_detail_attributes[$sewing_job_attributes['remarks']];
		$co_no = $job_detail_attributes[$sewing_job_attributes['cono']];
		$club_c_code = $job_detail_attributes[$sewing_job_attributes['cutjobno']];

		$qry_toget_first_ops_qry = "SELECT operation_code,original_quantity,good_quantity,rejected_quantity FROM $tms.task_job_status where task_jobs_id = '$task_job_id' and plant_code='$plantCode' and is_active=1 order by operation_seq asc limit 1";
		$qry_toget_first_ops_qry_result = mysqli_query($link_new, $qry_toget_first_ops_qry) or exit("Sql Error at toget_style_sch" . mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($row3 = mysqli_fetch_array($qry_toget_first_ops_qry_result)) {
			$input_ops_code = $row3['operation_code'];
			$input = $row3['good_quantity'];
			$rejection = $row3['rejected_quantity'];
			$total_qty=$row3["original_quantity"];
		}
		$cols=explode(",",$order_cols);
		for($i=0;$i<sizeof($cols);$i++)
		{				
			$order_col .= $cols[$i]."<br>";
		}
		$display_prefix1= $jobno;
		$doc_no_ref_explode=explode(",",$doc_no_ref);
		$num_docs=sizeof($doc_no_ref_explode);
		$sqlDocketLineIds="SELECT GROUP_CONCAT(CONCAT('''', jm_docket_id, '''' )) AS docket_line_ids FROM $pps.`jm_dockets` WHERE docket_number IN ($doc_no_ref)";
		// echo $sqlDocketLineIds.'<br/>';
		$sql_resultsqlDocketLineIds=mysqli_query($link, $sqlDocketLineIds) or exit("Sql Error1000".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($docket_row123=mysqli_fetch_array($sql_resultsqlDocketLineIds))
		{
			$docket_line_ids=$docket_row123['docket_line_ids'];
		}
		if($doc_no_ref){
			$sql1x1="select * from $pps.docket_number where lay_status<>'DONE' and docket_number in ($doc_no_ref)";
			$sql_result1x1=mysqli_query($link, $sql1x1) or exit("Sql Error81".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result1x1)>0)
			{
				$cut_status="0";
			}
			else
			{
				$cut_status="5";
			}
		}
		$fabric_req= '0';
		if($docket_line_ids){
			// fabric request logic
			$sql1x115="SELECT *  FROM  `$pps`.`fabric_prorities` WHERE `jm_docket_id` IN ($docket_line_ids)";
			// echo $sql1x115;
			$sql_result1x115=mysqli_query($link, $sql1x115) or exit("Sql Error82".mysqli_error($GLOBALS["___mysqli_ston"]));
			// echo mysqli_num_rows($sql_result1x115);
			if(mysqli_num_rows($sql_result1x115)>0)
			{
				if(sizeof($doc_no_ref_explode)<>mysqli_num_rows($sql_result1x115))
				{
					$fabric_req="0";
				}
				else
				{
					$fabric_req="5";
				}	
			}
			else
			{
				$fabric_req="0";
			}
			// fabric status logic
			$fabric_status="";
			$sql1x12="SELECT *  FROM  `$pps`.`requested_dockets` WHERE `jm_docket_id` IN ($docket_line_ids) and fabric_status='1'";
			$sql_result1x12=mysqli_query($link, $sql1x12) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result1x12)>0)
			{
				if(sizeof($doc_no_ref_explode) == mysqli_num_rows($sql_result1x12))
				{
					$fabric_status="1";
				}
			}
			$sql1x11="SELECT *  FROM  `$pps`.`requested_dockets` WHERE `jm_docket_id` IN ($docket_line_ids) and fabric_status = '5'";
			$sql_result1x11=mysqli_query($link, $sql1x11) or exit("Sql Error83".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result1x11)>0)
			{
				if(sizeof($doc_no_ref_explode) == mysqli_num_rows($sql_result1x11))
				{
					$fabric_status="5";
				}
			}
		}
		if ($fabric_status == "")
		{
			$fabric_status="0";
		}
		if($cut_status=="5")
		{
			$id="blue";					
		}
		elseif($fabric_status=='5')
		{
			$id="yellow";					
		}
		elseif($fabric_status=='1')
		{
			$id="pink";					
		}
		elseif($fabric_req=="5")
		{
			$id="green";					
		}
		elseif($fabric_status<"5")
		{
			switch ($ft_status)
			{
				case "1":
				{
					$id="lgreen";					
					break;
				}
				case "0":
				{
					$id="red";
					break;
				}
				case "2":
				{
					$id="red";
					break;
				}
				case "3":
				{
					$id="red";
					break;
				}
				case "4":
				{
					$id="red";
					break;
				}									
				default:
				{
					$id="yash";
					break;
				}
			}
		}
		else
		{
			$id="yash";
		}

		if($id=="blue" || $id=="yellow")
		{
			$cut_input_report_query="SELECT original_quantity AS cut_qty, (good_quantity + rejected_quantity) AS report_qty, good_quantity AS recevied_qty FROM $tms.`task_job_status`
					WHERE `task_jobs_id` = '$input_job_no_random_ref' AND `operation_code` = '$input_ops_code'";
			$cut_input_report_result=mysqli_query($link, $cut_input_report_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($cut_input_report_result))
			{
				$cut_origional_qty=$sql_row['cut_qty'];
				$report_origional_qty=$sql_row['report_qty'];
				$recevied_qty=$sql_row['recevied_qty'];									
			}
			
			if(($cut_origional_qty > $report_origional_qty) && $recevied_qty>0){
				$id='orange';
			}
		}
		$ex_factory="NIP";
		if($schedule!='')
		{			
			echo "<td>".$style."<br/><strong>".$schedule."<br/>".$display_prefix1."</strong><br/>".$club_c_code."<br/>".$total_qty."</td><td><b>Back Col</b>:".strtoupper($id)."</br><b>Col</b>:".strtoupper($order_col)."</br><b>Ex-FT: $ex_factory</b><br/><b>DID: ".$doc_no_ref."</b></td>";
		}
		$order_col="";
	}	
	echo "</tr>";
}
echo "</table>";
//echo "Legend: NIP=Not in Plan; DID=Docket ID; F.L=Fabric Location; B.L=Bundle Location; Blue Background: Current Week Deliveries; Red Background: Today Ex-factory."
echo "Legend: NIP=Not in Plan; DID=Docket ID; Back Col = Box Background Color in IPS; Col= No of Colors in Sewing job;Ex-FT = Ex factory date."

?>
</body>
<script>
	document.getElementById("msg").style.display="none";		
</script>
</html>
