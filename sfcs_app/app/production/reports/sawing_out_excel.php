<!--
CR -Sawing out Reporting Process in BEK .
Report for date range (Excel extraction)
-->
<!--
CR -Sawing out Reporting Process in BEK .
Report for date range
-->


<style>
body
{
	font-family:calibri;
	font-size:12px;
}

table tr
{
	border: solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: solid black;
	text-align: right;
white-space:nowrap; 
text-align:left;
}

table th
{
	border: solid black;
	text-align: center;
    	background-color: RED;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
}


}

}
</style>


<?php 
		include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');  
		$dat1=$_GET['sdate'];	
		$dat2=$_GET['edate'];
		
		$table.="<table border=1>";
		$table.="<tr><td colspan=11><h2><center><strong>Daily Production Status Report</strong></center></h2></td></tr>";
		$table.="<tr><td colspan=11>For the period: $dat1 to $dat2</td></tr>";
		
		$sql="SELECT barcode,parent_job,shift,created_at as date FROM $pts.`transaction_log` WHERE plant_code='$plant_code' AND DATE(created_at) BETWEEN '$dat1' AND '$dat2' AND parent_job_type IN ('PSJ','PSEJ')";
		$sql_result=mysqli_query($link, $sql) or exit("Error While Getting transaction log".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));

		$table.="<table id='table5' border=1>
					<tr>
					    <th>Barcode ID</th>
						<th>Date and Time</th>
						<th>Style</th>
						<th>Schedule</th>
						<th>Color</th>
						<th>Size</th>
						<th>Qty</th>
					</tr>";

					while($sql_row=mysqli_fetch_array($sql_result))
					{
						$barcode=$sql_row['barcode'];
						$parent_job=$sql_row['parent_job'];
						$shift=$sql_row['shift'];
						$date=$sql_row['date'];
						//getting barcode id
						$sql_barcode_qry="Select barcode_id from $pts.barcode where barcode='$barcode' AND plant_code='$plant_code'";
						$sql_result_det=mysqli_query($link, $sql_barcode_qry) or exit("Sql Error getting barcode id".$sql_barcode_qry.mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row_id=mysqli_fetch_array($sql_result_det))
						{
							$barcode_id=$sql_row_id['barcode_id'];
						}
						//getting parent_ext_ref_id
						$sql_ext_ref_qry="select jm_jg_header_id from $pps.jm_jg_header where job_number='$parent_job' AND plant_code='$plant_code'";
						$sql_result_data=mysqli_query($link, $sql_ext_ref_qry) or exit("Sql Error getting jm_jg_header_id".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row_ref=mysqli_fetch_array($sql_result_data))
						{
							$parent_ext_ref_id=$sql_row_ref['jm_jg_header_id'];
						}
						
						//getting finished good id
						$get_finshgood_qry="SELECT finished_good_id FROM $pts.`fg_barcode` WHERE barcode_id='$barcode_id' AND plant_code='$plant_code'";
						$get_finshgood_qry_result=mysqli_query($link, $get_finshgood_qry) or exit("Sql Error finished_good_id".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($get_finshgood_qry_row=mysqli_fetch_array($get_finshgood_qry_result))
						{
							$finished_good_id=$get_finshgood_qry_row['finished_good_id'];
							//getting style,schedule,color,size
							$get_det_qry="SELECT style,schedule,color,size FROM $pts.`finished_good` WHERE finished_good_id='$finished_good_id' AND plant_code='$plant_code'";
							$get_det_qry_result=mysqli_query($link, $get_det_qry) or exit("Sql Error getting details".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($get_det_qry_row=mysqli_fetch_array($get_det_qry_result))
							{
								$style=$get_det_qry_row['style'];
								$schedule=$get_det_qry_row['schedule'];
								$color=$get_det_qry_row['color'];
								$size=$get_det_qry_row['size'];
								//getting task job id
								$get_taskjobid_qry="SELECT task_jobs_id FROM $tms.`task_jobs` WHERE task_job_reference='$parent_ext_ref_id' AND plant_code='$plant_code'";
								$get_taskjobid_qry_result=mysqli_query($link, $get_taskjobid_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($get_taskjobid_qry_result_row=mysqli_fetch_array($get_taskjobid_qry_result))
								{
									$task_jobs_id=$get_taskjobid_qry_result_row['task_jobs_id'];
								}
								//getting max operation
								$qrytoGetMaxOperation="SELECT operation_code FROM $tms.`task_job_status` WHERE task_jobs_id='".$task_jobs_id."' AND plant_code='$plant_code' AND is_active=1 ORDER BY operation_seq DESC LIMIT 0,1";
								$maxOperationResult = mysqli_query($link_new,$qrytoGetMaxOperation) or exit('Problem in getting operations data for job');
								if(mysqli_num_rows($maxOperationResult)>0)
								{
									while($minOperationResultRow = mysqli_fetch_array($maxOperationResult))
									{
										$maxOperation=$minOperationResultRow['operation_code'];
									}
								}
								
								//getting quantity 
								$get_quant_qry="select sum(good_quantity) as quantity from $tms.`task_job_status` WHERE task_jobs_id='".$task_jobs_id."' AND plant_code='$plant_code' AND is_active=1 and operation_code=$maxOperation";
								$get_quant_qry_result = mysqli_query($link_new, $get_quant_qry) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
								while ($get_quant_qry_row = mysqli_fetch_array($get_quant_qry_result)) 
								{
									$quantity=$get_quant_qry_row['quantity'];
								}

								$table.="<tr>";
								$table.="<td>$barcode</td>";
								$table.="<td>$date</td>";
								$table.="<td>$style</td>";
								$table.="<td>$schedule</td>";
								$table.="<td>$color</td>";
								$table.="<td>".$size."</td>";
								$table.="<td>$quantity</td>";
								$table.="</tr>";
							}
						}
					}
		$table.="</table>";
	    header("Content-type: application/x-msdownload"); 
		# replace excelfile.xls with whatever you want the filename to default to
		header("Content-Disposition: attachment; filename=carton_out_report.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $table;
?>	