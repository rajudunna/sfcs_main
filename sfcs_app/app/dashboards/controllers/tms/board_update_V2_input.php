<!--
Core Module:In this interface we can get module wise plan details for fabric issuing priority.

Description: We can allocate fabric based on the plan priority.

Changes Log:
-->
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>
<?php
set_time_limit(2000);
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php'); 
$section_no=$_GET['section_no'];
$plant_code=$_GET['plant_code'];
$username=$_GET['username'];
?>


<?php

//New Implementation to restrict as per time lines to update Planning Board 20111211
	/* $hour=date("H");
	$restricted_hours=array(7,8,9,15,16);
	if(in_array($hour,$restricted_hours))
	{
		header("Location:time_out.php?msg=2");
	} */
	
	$hour=date("H.i");
		
	//if(($hour>=7.45 and $hour<=10.00) or ($hour>=15.15 and $hour<=16.45)) //OLD
	if(($hour>=7.45 and $hour<=9.45) or ($hour>=12.30 and $hour<=14.00) or ($hour>=16.00 and $hour<=17.30))
	//if(($hour>=7.15 and $hour<=9.45) or ($hour>=15.15 and $hour<=17.15))
	{
		//header("Location:time_out.php?msg=2");
	}
	else
	{
		
	}
	
?>

<html>
<head>
<title>Board Update</title>
</head>

<body>
	<form action="board_update_V2_input_excel.php" method="post">
		<input type="hidden" name="section" value="<?= $_GET['section_no']; ?>">
		<input type="hidden" name="uname1" value="<?= $_GET['uname']; ?>">
		<input type="submit" name="export_excel" value="Export to Excel">
	</form>
<div class="panel panel-primary">
	<div class="panel-heading">Input Job Plan Details</div><br/>
	<div class="panel-body">
		<?php
		echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color=\"blue\">Please wait while preparing dashboard...</font></h1></center></div>";
		ob_end_flush();
		flush();
		usleep(1);
		$sqlx1="SELECT section_name as section_display_name FROM $pms.`sections` WHERE plant_code='$plant_code' AND is_active=1 AND section_id='$section_no'";
		$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$section_display_name=$sql_rowx1['section_display_name'];
		}
		?>
		<div class="table table-responsive">
		<table class="table table-bordered">
			<tr>
			<th colspan=10 >Production Plan for <?= $section_display_name; ?></th>
			<th colspan=20 >Date :<?= date('Y-m-d H:i'); ?></th>
			</tr>
			<tr><th>Mod#</th><th>Legend</th><th>Priority 1</th><th>Priority 2</th><th>Priority 3</th><th>Priority 4</th><th>Priority 5</th><th>Priority 6</th><th>Priority 7</th><th>Priority 8</th><th>Priority 9</th><th>Priority 10</th><th>Priority 11</th><th>Priority 12</th><th>Priority 13</th><th>Priority 14</th></tr>

<?php
$sqlx="SELECT GROUP_CONCAT(`workstation_id` ORDER BY workstation_id+0 ASC) AS sec_mods FROM $pms.`sections` s
LEFT JOIN $pms.`workstation` w ON w.section_id=s.section_id
WHERE s.section_id='$section_no' AND s.plant_code='$plant_code' and s.is_active=1";
$sql_resultx=mysqli_query($link,$sqlx) or exit("Sql Error1".mysqli_error());
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$section_mods=$sql_rowx['sec_mods'];
	
	$mods=array();
	$mods=explode(",",$section_mods);

	for($x=0;$x<sizeof($mods);$x++)
	{
		//getting workstation code to display
		$get_wrkcode_qry="select workstation_code from $pms.workstation where workstation_id='".$mods[$x]."'";
		$wrkcode_resultx=mysqli_query($link,$get_wrkcode_qry) or exit("Sql Error1".mysqli_error());
		while($code_row=mysqli_fetch_array($wrkcode_resultx))
		{
			$workstation_code=$code_row['workstation_code'];
		}
		echo "<tr>";
		echo "<td>".$workstation_code."</td>";
		echo "<td align=\"right\">Style:<br/>Schedule:<br/>Job:<br/>Total Qty:<br/>Fab. Status:<br/>Trim Status:</td>";
		$$work_id=$mods[$x];
		
		$tasktype=TaskTypeEnum::SEWINGJOB;
		$result_planned_jobs=getPlannedJobs($work_id,$tasktype,$plant_code);
		$job_number=$result_planned_jobs['job_number'];
		$task_header_id=$result_planned_jobs['task_header_id'];
		foreach($job_number as $sew_num=>$jm_sew_id)
		{
			//To get taskjobs_id
		  $task_jobs_id = [];
		  $qry_get_task_job="SELECT task_jobs_id FROM $tms.task_jobs WHERE task_job_reference='$jm_sew_id' AND plant_code='$plant_code' AND task_type='$tasktype'";
		 // echo $qry_get_task_job;
		  $qry_get_task_job_result = mysqli_query($link_new, $qry_get_task_job) or exit("Sql Error at qry_get_task_job" . mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($row21 = mysqli_fetch_array($qry_get_task_job_result)) {
			  $task_jobs_id[] = $row21['task_jobs_id'];
			  $task_job_id = $row21['task_jobs_id'];
		  }
          //TO GET STYLE AND COLOR FROM TASK ATTRIBUTES USING TASK JOB ID
		  $job_detail_attributes = [];
		  $qry_toget_style_sch = "SELECT * FROM $tms.task_attributes where task_jobs_id in ('".implode("','" , $task_jobs_id)."') and plant_code='$plant_code'";
		  $qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("Sql Error at toget_style_sch" . mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) {
	        $job_detail_attributes[$row2['attribute_name']] = $row2['attribute_value'];
		  }
		  //TaskAttributeNamesEnum
		//    $sewing_job_attributes=['style'=>'STYLE','schedule'=>'SCHEDULE','color'=>'COLOR','ponumber'=>'PONUMBER','masterponumber'=>'MASTERPONUMBER','cutjobno'=>'CUTJOBNO', 'embjobno' => 'EMBJOBNO','docketno'=>'DOCKETNO','sewingjobno'=>'SEWINGJOBNO','bundleno'=>'BUNDLENO','packingjobno'=>'PACKINGJOBNO','cartonno'=>'CARTONNO','componentgroup'=>'COMPONENTGROUP', 'cono' => 'CONO'];
		  $style = $job_detail_attributes[$sewing_job_attributes['style']];
		  $color = $job_detail_attributes[$sewing_job_attributes['color']];
		  $schedule = $job_detail_attributes[$sewing_job_attributes['schedule']];
		  $sewingjobno = $job_detail_attributes[$sewing_job_attributes['sewingjobno']]; 
		  $cono = $job_detail_attributes[$sewing_job_attributes['cono']];  
		  $doc_no_ref = $job_detail_attributes[$sewing_job_attributes['docketno']];  
          
		  //to get qty from jm job lines
		  $toget_qty_qry="SELECT sum(quantity) as qty from $pps.jm_job_bundles where jm_jg_header_id ='$jm_sew_id' and plant_code='$plant_code'";
		  $toget_qty_qry_result=mysqli_query($link_new, $toget_qty_qry) or exit("Sql Error at toget_style_sch".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $toget_qty=mysqli_num_rows($toget_qty_qry_result);
		  if($toget_qty>0){
			  while($toget_qty_det=mysqli_fetch_array($toget_qty_qry_result))
			  {
				 $sew_qty = $toget_qty_det['qty'];
			  }
		  }
		  //qry to get trim status
		  $get_trims_status="SELECT trim_status FROM $tms.job_trims WHERE task_job_id ='$task_job_id'";
		  $get_trims_status_result = mysqli_query($link_new, $get_trims_status) or exit("Sql Error at get_trims_status" . mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($row2 = mysqli_fetch_array($get_trims_status_result)) 
			{
			   $input_trims_status=$row2['trim_status'];
			}
			
			//qry to get fabric status
		  $get_fabric_status="SELECT fabric_status FROM $pps.requested_dockets WHERE doc_no ='$doc_no_ref' and plant_code='".$plant_code."'";
		  $get_fabric_status_result = mysqli_query($link_new, $get_fabric_status) or exit("Sql Error at get_fabric_status" . mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($row_stat = mysqli_fetch_array($get_fabric_status_result)) 
			{
			   $fabric_status=$row_stat['fabric_status'];
			}
			$rem="Nil";

			$doc_no_ref_input = implode("','",$doc_no_ref);
			$doc_no_ref_explode=explode(",",$doc_no_ref);
			
			$num_docs=sizeof($doc_no_ref_explode);
			
			switch ($fabric_status)
			{
				case "1":
				{
					$id="L-Green";					
					$rem="Available";
					if(sizeof($num_docs) > 0)
					{
						$sql1x1="select * from $pps.fabric_priorities where doc_ref in ('$doc_no_ref_input') and hour(issued_time)+minute(issued_time)>0 and plant_code='$plant_code'";
						//echo $sql1x1."<br>";
						$sql_result1x1=mysqli_query($link,$sql1x1) or exit("Sql Error7".mysqli_error());
						if(mysqli_num_rows($sql_result1x1)==$num_docs)
						{
							$id="Yellow";
						}
						else
						{
							$id="L-Green";
							//$id=$id;
						}
					}
					break;
				}
				case "0":
				{
					$id="red";
					$rem="Not Available";
					break;
				}
				case "2":
				{
					$id="red";
					$rem="In House Issue";
					break;
				}
				case "3":
				{
					$id="red";
					$rem="GRN issue";
					break;
				}
				case "4":
				{
					$id="red";
					$rem="Put Away Issue";
					break;
				}		
				case "5":
				{
					if(sizeof($num_docs) > 0)
					{
						$sql1x1="select * from $pps.fabric_priorities where doc_ref in ('$doc_no_ref_input') and hour(issued_time)+minute(issued_time)>0 and plant_code='$plant_code'";
						//echo $sql1x1."<br>";
						$sql_result1x1=mysqli_query($link,$sql1x1) or exit("Sql Error9".mysqli_error());
						if(mysqli_num_rows($sql_result1x1)==$num_docs)
						{
							$id="Yellow";
						}
						else
						{
							$id="L-Green";
							//$id=$id;
						}
					}
					break;
				}				
				default:
				{
					$id="Ash";
					$rem="Not Update";
					break;
				}
			}
			
			$sql11x="select * from $pps.fabric_priorities where doc_ref in ('$doc_no_ref_input') and plant_code='$plant_code'";
			//echo $sql11x."<br>";
			$sql_result11x=mysqli_query($link,$sql11x) or exit("Sql Error9".mysqli_error());
			if(mysqli_num_rows($sql_result11x)==$num_docs and $id!="yellow")
			//if(mysqli_num_rows($sql_result11x) and $id!="yellow")
			{
				$id="D-Green";	
			} 
			
			$sql1x1="select * from $pps.fabric_priorities where doc_ref in ('$doc_no_ref_input') and hour(issued_time)+minute(issued_time)>0 and plant_code='$plant_code'";
			//echo $sql1x1."<br>";
			$sql_result1x1=mysqli_query($link,$sql1x1) or exit("Sql Error10".mysqli_error());
			if(mysqli_num_rows($sql_result1x1)==$num_docs)
			{
				$id="Yellow";
			}
			//echo $num_docs."<br>";
			$sql11x1="select * from $bai_pro3.plandoc_stat_log where doc_no in ('$doc_no_ref_input') and act_cut_status=\"DONE\"";
			//echo $sql11x1."<br>";
			$sql_result11x1=mysqli_query($link,$sql11x1) or exit("Sql Error11".mysqli_error());
			if(mysqli_num_rows($sql_result11x1)==$num_docs and $id=="Yellow")
			{
				$id="Blue";
			} 
			
            			
			if($trim_status == TrimStatusEnum::OPEN)
			{
				$trimid="yash";
			}
			else if($trim_status == TrimStatusEnum::PREPARINGMATERIAL)
			{
				$trimid="yellow";
			}
			else if($trim_status == TrimStatusEnum::MATERIALREADYFORPRODUCTION)
			{
                $trimid="blue"; 
			}
			else if($trim_status == TrimStatusEnum::PARTIALISSUED)
			{
                $trimid="orange";
			}
			else if($trim_status == TrimStatusEnum::ISSUED)
			{
                $trimid="pink"; 
			}
			
			
			echo "<td >".$style."<br/><strong>".$schedule."<br/>".$sewingjobno."</strong><br/>".$sew_qty."<br>".$id."<br>".$trimid."</td>";

		}
		
		for($i=1;$i<=14-$sql_num_check;$i++)
		{
			echo "<td></td>";
		}
		echo "</tr>";
	}
}

echo "</table>";
?>
</body>
<script>
	document.getElementById("msg").style.display="none";		
</script>
</html>

<style type="text/css">
	table{
    border-collapse: collapse;
}
td {
    background-color: WHITE;
    color: BLACK;
    border: 1px solid #660000;
    padding: 1px;
    white-space: nowrap;
}
th {
	background-color: RED;
    color: WHITE;
    border: 1px solid #660000;
    padding: 10px;
    white-space: nowrap;
}
</style>

