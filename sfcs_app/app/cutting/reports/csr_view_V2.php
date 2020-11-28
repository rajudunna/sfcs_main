<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',3,'R'));
$plantcode = $_SESSION['plantCode'];
$username=$_SESSION['userName'];
?>
<script>
function verify_date(){
		var val1 = $('#sdate').val();
		var val2 = $('#edate').val();
		
		if(val1 > val2){
			sweetAlert('Start Date Should  be less than End Date','','warning');
			return false;
		}
		else
		{
			return true;
		}
}

</script>
<style>
 th,td { color : #000;}
</style>
		<?php
			$from_date=$_POST['from_date'];
			$to_date=$_POST['to_date'];
			$section=$_POST['section'];
			// $shift=$_POST['shift'];
			$reptype=$_POST['reptype'];
		?>
		<div class="panel panel-primary">
		<div class="panel-heading">Cutting Status Report</div>
		<div class="panel-body">
		<form method="post" name="input" action="<?php echo '?r='.$_GET['r']; ?>">
			<div class="row">
			<div class="col-md-2">
			<label>Start Date: </label>
			<!--<input  id="demo1" onclick="javascript:NewCssCal('demo1','yyyymmdd','dropdown')" type="text" name="from_date" size="8" value="<?php if(isset($_POST['from_date'])) { echo $_POST['from_date']; } else { echo date("Y-m-d"); } ?>">-->
			<input type="text" data-toggle='datepicker' id="sdate"  name="from_date" class="form-control" size="8" value="<?php  if(isset($_POST['from_date'])) { echo $_POST['from_date']; } else { echo date("Y-m-d"); } ?>" />
			</div>
			<div class="col-md-2">
			<label>End Date:</label> 
			<!--<input id="demo2" title="click select end date" onclick="javascript:NewCssCal('demo2','yyyymmdd','dropdown')" type="text" size="8" name="to_date" value="<?php if(isset($_POST['to_date'])) { echo $_POST['to_date']; } else { echo date("Y-m-d"); } ?>">-->
			<input type="text" data-toggle='datepicker' id="edate" onchange='return verify_date();' name="to_date" class="form-control" size="8" value="<?php  if(isset($_POST['to_date'])) { echo $_POST['to_date']; } else { echo date("Y-m-d"); } ?>" />
			</div>

			<?php
			// $sqlxx="select workstation_type_id from $pms.workstation_type where plant_code='$plantcode' and workstation_type_description='Cutting'";
			// $sql_resultx1=mysqli_query($link, $sqlxx) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			// while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
			// {
			// 	 $workstation_type_id=$sql_rowx1['workstation_type_id'];
			// }
			
			$all_sec_query="SELECT GROUP_CONCAT('\"',section_id,'\"') as sec,sections.section_name,departments.department_type,departments.department_id from $pms.sections left join $pms.departments ON departments.department_id=sections.department_id where sections.plant_code='$plantcode' and departments.department_type='CUTTING'";
			
			// $sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		
				// $all_sec_query = "SELECT GROUP_CONCAT('\"',section_id,'\"') as sec FROM $pms.sections where plant_code='$plantcode'";
				$sec_result_all = mysqli_query($link,$all_sec_query) or exit('Unable to load sections all');
				while($res1 = mysqli_fetch_array($sec_result_all)){
					$all_secs = $res1['sec'];
				}

			?>
			<div class="col-md-2">
				<label>Section: </label>
				<select name="section" class="form-control" required>
					<!-- <option value=''>Please Select</option> -->
					<?php if($all_secs){
					echo "<option value='$all_secs'>All</option>";
					}
					?>
					<?php
					$all_sec_query1="select sections.section_id,sections.section_name,departments.department_type,departments.department_id from $pms.sections left join $pms.departments ON departments.department_id=sections.department_id where sections.plant_code='$plantcode' and departments.department_type='CUTTING'";
					$sec_result_all1 = mysqli_query($link,$all_sec_query1) or exit('Unable to load sections all');
					while($res11 = mysqli_fetch_array($sec_result_all1)){
							echo "<option value='\"".$res11['section_id']."\"'>".$res11['section_name']."</option>";
						}
					?>
				</select>
			</div>
			<!-- <div class="col-md-2">
				<label>Shift: </label>
				<select name="shift" class="form-control" >
					<?php 
					// foreach($shifts_array as $key=>$shift){
					// 	echo "<option value=\"'$shift'\">$shift</option>";
					// 	$all_shifts = $all_shifts."'$shift',";
					// }
				?>
				<option value=" //rtrim($all_shifts,',') ?>" selected>All</option>
				</select>
			</div> -->
			<div class="col-md-2">
				<label>Report: </label>
				<select name="reptype" class="form-control">
					<option value=1 <?php if($reptype==1){ echo "selected"; } ?> >Detailed</option>
					<option value=2 <?php if($reptype==2){ echo "selected"; } ?>>Summary</option>
				</select>
			</div>
			<div class="col-md-2">
			<input type="submit" value="Show" name="submit" class="btn btn-success" onclick='return verify_date();' style="margin-top:22px;">
			</div>
			</div>
		</form>

		<?php
			if(isset($_POST['submit']))
			{
				$row_count = 0;
				$shift = $_POST['shift'];
		?>	<hr/>
			<div class='panel panel-default'>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-4">
							<label>Date Range : </label>
							<span class="label label-info" style="font-size: 12px;">
							<?php echo $from_date." to ".$to_date; ?>
							</span>
						</div>
						<!-- <div class="col-md-3">
							<label>Shift : </label>
							<span class="label label-info" style="font-size: 12px;">
							// echo str_replace('"',"",$shift); 
							</span>
						</div> -->
					</div>
					<div class="row">
						<div class="col-md-3">
							<label>Section : </label>
							<span class="label label-info" style="font-size: 12px;margin-left: -10px;">

							<?php 
							$sql_query="select section_id,section_name from $pms.sections where plant_code='$plantcode' and section_id in ($section)";
							$result_sql_query=mysqli_query($link, $sql_query) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($res2 = mysqli_fetch_array($result_sql_query)){
								$section_name[] = $res2['section_name'];
							}
							echo implode(",",$section_name); ?>
							</span>
						</div>
					</div>
				</div>
			</div>
		<?php
				$from_date=$_POST['from_date'];
				$to_date=$_POST['to_date'];
				$section=$_POST['section'];
				// $shift=$_POST['shift'];
				$reptype=$_POST['reptype'];
				$from_date=date('Y/m/d', strtotime($from_date));
				$to_date=date('Y/m/d', strtotime($to_date));
			}
		?>
  

		<?php
		if(isset($_POST['submit']) && $reptype==1)
		{
				echo " <div class='panel panel-default'>
			  			<div class='panel-heading' align='center'>
							  <b>Detailed Report </b>
						</div>
					    <div class='panel-body'><div style='max-height:700px;overflow-y:scroll'>";	  
				$workstation_query="select workstation_id,workstation_code  from $pms.workstation where section_id in($section) and plant_code='$plantcode'";
				$workstation_query_sql_query1=mysqli_query($link, $workstation_query) or exit("$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row11=mysqli_fetch_array($workstation_query_sql_query1))
				{
					
					$workstation_id[]=$sql_row11['workstation_id'];
					
				}
				$workstation="'".implode("','",$workstation_id)."'";

				$sql1="select task_header.task_header_id,task_jobs.task_jobs_id,task_header.planned_date_time,task_header.resource_id,task_header.planned_date_time from $tms.task_header left join $tms.task_jobs on task_header.task_header_id=task_jobs.task_header_id  where task_header.plant_code='$plantcode' and task_header.resource_id in ($workstation) and 
				STR_TO_DATE(task_header.planned_date_time,'%c/%e/%Y') between \"$from_date\" and \"$to_date\" and task_header.task_type='CUTJOB' and task_jobs.task_type='DOCKET'";
				
				$result_sql_query1=mysqli_query($link, $sql1) or exit("$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($result_sql_query1);
				$row_count = 0;
			
				echo "<div class='table-responsive'>
						<table class='table table-bordered'>";
				echo "<tr class='warning'>
						<th class='tblheading'>Date</th>
						<th class='tblheading' >Table</th><th class='tblheading'>Docket No</th>
						<th class='tblheading'>Style</th><th class='tblheading'>Schedule</th>
						<th class='tblheading'>Color</th><th class='tblheading'>Category</th>
						<th class='tblheading'>Cut No</th><th class='tblheading'>Cut Plies</th><th>Size</th><th>Qty</th>";
					 		
				while($sql_row=mysqli_fetch_array($result_sql_query1))
				{	
					$task_jobs_id=$sql_row['task_jobs_id'];
					$task_header_id=$sql_row['task_header_id'];
					$planned_date_time=$sql_row['planned_date_time'];
					$date=date('d-m-Y', strtotime($planned_date_time));
					$resource_id=$sql_row['resource_id'];
					$sql4="select sections.section_name from $pms.workstation left join $pms.sections on sections.section_id=workstation.section_id where workstation.workstation_id='$resource_id' and workstation.plant_code='$plantcode'";
					$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row4=mysqli_fetch_array($sql_result4))
					{
						$workstation_description=$sql_row4['section_name'];
					}
					$sql9="select attribute_value from $tms.task_attributes where task_jobs_id='$task_jobs_id'  and plant_code='$plantcode' and attribute_name='DOCKETNO'";

					$sql_result9=mysqli_query($link, $sql9) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row9=mysqli_fetch_array($sql_result9))
					{
						$attribute_value=$sql_row9['attribute_value'];
					
						$sql2="SELECT jm_docket_lines.jm_docket_id,jm_docket_lines.plies,jm_docket_lines.jm_docket_line_id,jm_docket_lines.docket_line_number,jm_cut_job.cut_number,lp_ratio_component_group.ratio_id,lp_ratio_size.size,lp_ratio_size.size_ratio,jm_cut_job.po_number,jm_docket_cg_bundle.jm_dcgb_id,jm_docket_cg_bundle.cg_name
						FROM $pps.jm_docket_lines 
						LEFT JOIN $pps.jm_dockets ON jm_dockets.jm_docket_id=jm_docket_lines.jm_docket_id LEFT JOIN $pps.jm_cut_job ON  jm_cut_job.
						jm_cut_job_id=jm_dockets.jm_cut_job_id LEFT JOIN $pps.lp_ratio_component_group ON lp_ratio_component_group.lp_ratio_cg_id
						=jm_dockets.ratio_comp_group_id LEFT JOIN $pps.jm_docket_cg_bundle ON jm_docket_cg_bundle.jm_docket_line_id=jm_docket_lines.jm_docket_line_id LEFT JOIN $pps.lp_ratio_size ON lp_ratio_size.ratio_id=lp_ratio_component_group.ratio_id  
						WHERE jm_docket_lines.plant_code='$plantcode' AND docket_type='NORMAL' AND jm_docket_lines.docket_line_number IN  ($attribute_value) GROUP BY lp_ratio_size.size,jm_docket_cg_bundle.cg_name";
						$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
						$rows=mysqli_num_rows($sql_result2);
						$total=0;
						$total_qty=0;
						if($rows>0){	
							while($sql_row2=mysqli_fetch_array($sql_result2))
							{
								$docket_line_number=$sql_row2['docket_line_number'];
								$cut_number=$sql_row2['cut_number'];
								$size=$sql_row2['size'];
								$size_ratio=$sql_row2['size_ratio'];
								$po_number=$sql_row2['po_number'];
								$plies=$sql_row2['plies'];
								$jm_docket_line_id=$sql_row2['jm_docket_line_id'];
								$jm_dcgb_id=$sql_row2['jm_dcgb_id'];
								$category_name=$sql_row2['cg_name'];

							
							
								if($plantcode!='' and $docket_line_number!=''){
									$result_mp_color_details=getJmDockets($docket_line_number,$plantcode);
									$style=$result_mp_color_details['style'];
									$fg_color=$result_mp_color_details['fg_color'];
									
									
								}
								// if($plantcode!='' and $docket_line_number!=''){
								// 	$result_category=getDocketInformation($docket_line_number,$plantcode);
								// 	$category=$result_category['category'];	
								// }
								
								$qry_mp_mo_qty="SELECT jm_pplb_id FROM $pps.jm_docket_logical_bundle WHERE plant_code='$plantcode' AND `jm_docket_bundle_id`='$jm_dcgb_id'";
								$qry_mp_mo_qty_result=mysqli_query($link_new, $qry_mp_mo_qty) or exit("Sql Errorat 34_mp_mo_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row5=mysqli_fetch_array($qry_mp_mo_qty_result))
								{
									$jm_product_logical_bundle_id=$sql_row5['jm_pplb_id'];
								}
								$qry_schedule="SELECT feature_value FROM $pps.jm_product_logical_bundle WHERE `jm_pplb_id`='$jm_product_logical_bundle_id' AND plant_code='$plantcode'";
								$qry_schedule_result=mysqli_query($link_new, $qry_schedule) or exit("Sql Errorat343444_mp_mo_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row6=mysqli_fetch_array($qry_schedule_result))
								{
									$schedule=$sql_row6['feature_value'];
								}
								echo "<tr>
								<td>".$date."</td> 
								<td>".$workstation_description."</td> 
								<td>".$docket_line_number."</td> 
								<td>$style</td> 
								<td>$schedule</td> 
								<td>$fg_color</td> 
								<td>$category_name</td> 
								<td>".$cut_number."</td>
								<td>".$plies."</td>";
								echo "<td>".$size."</td>";		
								echo "<td>".$plies*$size_ratio."</td>";
								echo "</tr>";
								$total+=$plies;
								$total_qty+=$plies*$size_ratio;
							}
						}
			
						if($rows>0){
							echo "<tr>";
							echo "<td colspan=7></td>
							<td class='info'>Total Plies:</td>
							<td class='info'>$total</td>
							<td class='info'>Total Qty:</td>
							<td class='info'>$total_qty</td>";
							echo "</tr>"; 
						}	
				
					}
	
  				
				}
			
			echo "</table>
				</div>";    
 		
			/**Recut logic*/
				$sql1="select task_header.task_header_id,task_jobs.task_jobs_id,task_header.planned_date_time,task_header.resource_id,task_header.planned_date_time from $tms.task_header left join $tms.task_jobs on task_header.task_header_id=task_jobs.task_header_id  where task_header.plant_code='$plantcode' and task_header.resource_id in ($workstation) and 
				STR_TO_DATE(task_header.planned_date_time,'%c/%e/%Y') between \"$from_date\" and \"$to_date\" and task_header.task_type='CUTJOB' and task_jobs.task_type='DOCKET'";
				
				$result_sql_query1=mysqli_query($link, $sql1) or exit("$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($result_sql_query1);
				$row_count = 0;
			
				// echo "<div class='table-responsive'>
				// 		<table class='table table-bordered'>";
				// echo "<tr class='warning'>
				// 		<th class='tblheading'>Date</th>
				// 		<th class='tblheading' >Table</th><th class='tblheading'>Docket No</th>
				// 		<th class='tblheading'>Style</th><th class='tblheading'>Schedule</th>
				// 		<th class='tblheading'>Color</th><th class='tblheading'>Category</th>
				// 		<th class='tblheading'>Cut No</th><th class='tblheading'>Cut Plies</th><th>Size</th><th>Qty</th>";

			if($sql_num_check > 0){
				echo "<div class='table-responsive'><table class='table table-bordered'>";
				echo "<tr class='warning'>
						<th class='tblheading'>Date 2</th>
						<th class='tblheading'>Docket No</th>
						<th class='tblheading'>Style</th>
						<th class='tblheading'>Schedule</th>
						<th class='tblheading'>Color</th>
						<th class='tblheading'>Category</th>
						<th class='tblheading'>Cut No</th>
						<th class='tblheading'>Cut Plies</th>
						<th>Size</th>
						<th>Qty</th>";
						while($sql_row=mysqli_fetch_array($result_sql_query1))
						{	
							$task_jobs_id=$sql_row['task_jobs_id'];
							$task_header_id=$sql_row['task_header_id'];
							$planned_date_time=$sql_row['planned_date_time'];
							$date=date('d-m-Y', strtotime($planned_date_time));
							$resource_id=$sql_row['resource_id'];
							$sql4="select sections.section_name from $pms.workstation left join $pms.sections on sections.section_id=workstation.section_id where workstation.workstation_id='$resource_id' and workstation.plant_code='$plantcode'";
							$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row4=mysqli_fetch_array($sql_result4))
							{
								$workstation_description=$sql_row4['section_name'];
							}
							$sql9="select attribute_value from $tms.task_attributes where task_jobs_id='$task_jobs_id'  and plant_code='$plantcode' and attribute_name='DOCKETNO'";
		
							$sql_result9=mysqli_query($link, $sql9) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row9=mysqli_fetch_array($sql_result9))
							{
								$attribute_value=$sql_row9['attribute_value'];
							
								$sql2="SELECT jm_docket_lines.jm_docket_id,jm_docket_lines.plies,jm_docket_lines.jm_docket_line_id,jm_docket_lines.docket_line_number,jm_cut_job.cut_number,lp_ratio_component_group.ratio_id,lp_ratio_size.size,lp_ratio_size.size_ratio,jm_cut_job.po_number,jm_docket_cg_bundle.jm_dcgb_id,jm_docket_cg_bundle.cg_name
								FROM $pps.jm_docket_lines 
								LEFT JOIN $pps.jm_dockets ON jm_dockets.jm_docket_id=jm_docket_lines.jm_docket_id LEFT JOIN $pps.jm_cut_job ON  jm_cut_job.
								jm_cut_job_id=jm_dockets.jm_cut_job_id LEFT JOIN $pps.lp_ratio_component_group ON lp_ratio_component_group.lp_ratio_cg_id
								=jm_dockets.ratio_comp_group_id LEFT JOIN $pps.jm_docket_cg_bundle ON jm_docket_cg_bundle.jm_docket_line_id=jm_docket_lines.jm_docket_line_id LEFT JOIN $pps.lp_ratio_size ON lp_ratio_size.ratio_id=lp_ratio_component_group.ratio_id  
								WHERE jm_docket_lines.plant_code='$plantcode' AND docket_type='RECUT' AND jm_docket_lines.docket_line_number IN  ($attribute_value) GROUP BY lp_ratio_size.size,jm_docket_cg_bundle.cg_name";
								$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
								$rows=mysqli_num_rows($sql_result2);
								$total=0;
								$total_qty=0;
								if($rows>0){	
									while($sql_row2=mysqli_fetch_array($sql_result2))
									{
										$docket_line_number=$sql_row2['docket_line_number'];
										$cut_number=$sql_row2['cut_number'];
										$size=$sql_row2['size'];
										$size_ratio=$sql_row2['size_ratio'];
										$po_number=$sql_row2['po_number'];
										$plies=$sql_row2['plies'];
										$jm_docket_line_id=$sql_row2['jm_docket_line_id'];
										$jm_dcgb_id=$sql_row2['jm_dcgb_id'];
										$category_name=$sql_row2['cg_name'];
		
									
									
										if($plantcode!='' and $docket_line_number!=''){
											$result_mp_color_details=getJmDockets($docket_line_number,$plantcode);
											$style=$result_mp_color_details['style'];
											$fg_color=$result_mp_color_details['fg_color'];
											
											
										}
										// if($plantcode!='' and $docket_line_number!=''){
										// 	$result_category=getDocketInformation($docket_line_number,$plantcode);
										// 	$category=$result_category['category'];	
										// }
										
										$qry_mp_mo_qty="SELECT jm_pplb_id FROM $pps.jm_docket_logical_bundle WHERE plant_code='$plantcode' AND `jm_docket_bundle_id`='$jm_dcgb_id'";
										$qry_mp_mo_qty_result=mysqli_query($link_new, $qry_mp_mo_qty) or exit("Sql Errorat 34_mp_mo_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
										while($sql_row5=mysqli_fetch_array($qry_mp_mo_qty_result))
										{
											$jm_product_logical_bundle_id=$sql_row5['jm_pplb_id'];
										}
										$qry_schedule="SELECT feature_value FROM $pps.jm_product_logical_bundle WHERE `jm_pplb_id`='$jm_product_logical_bundle_id' AND plant_code='$plantcode'";
										$qry_schedule_result=mysqli_query($link_new, $qry_schedule) or exit("Sql Errorat343444_mp_mo_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
										while($sql_row6=mysqli_fetch_array($qry_schedule_result))
										{
											$schedule=$sql_row6['feature_value'];
										}
										echo "<tr>
										<td>".$date."</td> 
										<td>".$workstation_description."</td> 
										<td>".$docket_line_number."</td> 
										<td>$style</td> 
										<td>$schedule</td> 
										<td>$fg_color</td> 
										<td>$category_name</td> 
										<td>".$cut_number."</td>
										<td>".$plies."</td>";
										echo "<td>".$size."</td>";		
										echo "<td>".$plies*$size_ratio."</td>";
										echo "</tr>";
										$total+=$plies;
										$total_qty+=$plies*$size_ratio;
									}
								}
					
								if($rows>0){
									echo "<tr>";
									echo "<td colspan=7></td>
									<td class='info'>Total Plies:</td>
									<td class='info'>$total</td>
									<td class='info'>Total Qty:</td>
									<td class='info'>$total_qty</td>";
									echo "</tr>"; 
								}	
						
							}
			
							
						}
			}
				echo "</table>
				</div>";
				echo "</div></div>";
		}
	 ?>
	 <?php
 		if(isset($_POST['submit']) && $reptype==2)
		{
			echo " <div class='panel panel-default'>
			<h2 align='center'><b>Summary Report for Cut Quantity</b></h2>
			<div class='panel-body'>";
			//echo"(Summary Report for Cut Quantity)";
			echo"
			<table class='table table-bordered' >
			<tr class='warning'>
			<th class='tblheading'>Section</th>
			<th class='tblheading'>Docket No</th>
			<th class='tblheading'>Category</th>
			<th class='tblheading'>Cut Qty</th>
			</tr>";		 
			$workstation_query="select workstation_id,workstation_code  from $pms.workstation where section_id in($section) and plant_code='$plantcode'";
			$workstation_query_sql_query1=mysqli_query($link, $workstation_query) or exit("$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row11=mysqli_fetch_array($workstation_query_sql_query1))
			{
				
				$workstation_id[]=$sql_row11['workstation_id'];
				
			}
		  		$workstation="'".implode("','",$workstation_id)."'";
				$sql1="select task_header.task_header_id,task_jobs.task_jobs_id,task_header.planned_date_time,task_header.resource_id from $tms.task_header left join $tms.task_jobs on task_header.task_header_id=task_jobs.task_header_id  where task_header.plant_code='$plantcode' and task_header.resource_id in ($workstation) and 
				STR_TO_DATE(task_header.planned_date_time,'%c/%e/%Y') between \"$from_date\" and \"$to_date\" and task_header.task_type='CUTJOB' and task_jobs.task_type='DOCKET'";
				mysqli_query($link, $sql1) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error222".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row1=mysqli_fetch_array($sql_result1))
				{
					$row_count++;
					$task_jobs_id=$sql_row1['task_jobs_id'];
					$task_header_id=$sql_row1['task_header_id'];
					$planned_date_time=$sql_row1['planned_date_time'];
					$resource_id=$sql_row1['resource_id'];
					$sql4="select sections.section_name from $pms.workstation left join $pms.sections on sections.section_id=workstation.section_id where workstation.workstation_id='$resource_id' and workstation.plant_code='$plantcode'";
					$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row4=mysqli_fetch_array($sql_result4))
					{
						$workstation_description=$sql_row4['section_name'];
					}
					$sql99="select attribute_value from $tms.task_attributes where task_jobs_id='$task_jobs_id' and plant_code='$plantcode' and attribute_name='DOCKETNO'";
					//echo $sql9;
					$sql_result99=mysqli_query($link, $sql99) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row99=mysqli_fetch_array($sql_result99))
					{
						$attribute_value=$sql_row99['attribute_value'];
						$sql11="SELECT component_name,docket_line_number,jm_docket_cg_bundle.jm_docket_line_id FROM $pps.jm_docket_cg_bundle LEFT JOIN $pps.jm_docket_lines ON 
						jm_docket_cg_bundle.jm_docket_line_id=jm_docket_lines.jm_docket_line_id 
						WHERE jm_docket_lines.plant_code='$plantcode' AND jm_docket_lines.docket_type='NORMAL' AND jm_docket_lines.docket_line_number IN ($attribute_value) GROUP BY component_name";
						//mysqli_query($link, $sql2) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error222".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row8=mysqli_fetch_array($sql_result11))
						{

							$category_name=$sql_row8['component_name'];
							$jm_docket_line_id=$sql_row8['jm_docket_line_id'];
							// $size_ratio=$sql_row8['size_ratio'];
							$docket_number=$sql_row8['docket_line_number'];

							$sql111="SELECT jm_docket_lines.jm_docket_id,jm_docket_lines.jm_docket_line_id,jm_docket_lines.docket_line_number,jm_cut_job.cut_number,lp_ratio_component_group.ratio_id,lp_ratio_size.size,sum(lp_ratio_size.size_ratio) as size_ratio,jm_cut_job.po_number
							FROM $pps.jm_docket_lines 
							LEFT JOIN $pps.jm_dockets ON jm_dockets.jm_docket_id=jm_docket_lines.jm_docket_id LEFT JOIN $pps.jm_cut_job ON  jm_cut_job.
							jm_cut_job_id=jm_dockets.jm_cut_job_id LEFT JOIN $pps.lp_ratio_component_group ON lp_ratio_component_group.lp_ratio_cg_id
							=jm_dockets.ratio_comp_group_id LEFT JOIN $pps.lp_ratio_size ON lp_ratio_size.ratio_id=lp_ratio_component_group.ratio_id  
							WHERE jm_docket_lines.plant_code='$plantcode'  AND jm_docket_lines.jm_docket_line_id IN  ('$jm_docket_line_id')";


						
							$sql111_result11=mysqli_query($link_new, $sql111) or exit("Sql Error9098at_mp_sub_mo_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row4111=mysqli_fetch_array($sql111_result11))
							{
								$size_ratio=$sql_row4111['size_ratio'];
							
							}
								
							$sql3="select sum(plies) as plies from $pps.jm_docket_lines where jm_docket_line_id='$jm_docket_line_id' and plant_code='$plantcode'";
							$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row3=mysqli_fetch_array($sql_result3))
							{
								$plies=$sql_row3['plies'];
							}
						
							$total=$plies*$size_ratio;
							echo "<tr >";
							echo "<td >$workstation_description</td>";
						
							echo "<td >$docket_number</td>";
							echo "<td >$category_name</td>";
							echo "<td >$total</td>";
							echo "</tr>";
						}
			
					}		
				}
			if($row_count == 0){
				echo "<tr><td colspan=4 style='color:#ff0000'>No Data found</td></tr>";
			}
			echo "</table></div></div>";
			
	
	
			/**Recut Logic */

			echo "<br/>";
			echo " <div class='panel panel-default'>
			<h2 align='center'>
			<b>Summary Report for Re-Cut Quantity</b></h2>
			<div class='panel-body'>";
			
			// echo"<table class='table table-bordered'>
			// 	  <tr class='warning'>
			// 	  <th class='tblheading'>Section</th>
			// 	  <th class='tblheading'>Shift</th>
			// 	  <th class='tblheading'>Category</th>
			// 	  <th class='tblheading'>Re Cut Qty</th>
			// 	  </tr>";

				echo"
				<table class='table table-bordered' >
				<tr class='warning'>
				<th class='tblheading'>Section</th>
				<th class='tblheading'>Docket No</th>
				<th class='tblheading'>Category</th>
				<th class='tblheading'>Re Cut Qty</th>
				</tr>";

				$sql1="select task_header.task_header_id,task_jobs.task_jobs_id,task_header.planned_date_time,task_header.resource_id from $tms.task_header left join $tms.task_jobs on task_header.task_header_id=task_jobs.task_header_id  where task_header.plant_code='$plantcode' and task_header.resource_id in ($workstation) and 
				STR_TO_DATE(task_header.planned_date_time,'%c/%e/%Y') between \"$from_date\" and \"$to_date\" and task_header.task_type='CUTJOB' and task_jobs.task_type='DOCKET'";
				mysqli_query($link, $sql1) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error222".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row1=mysqli_fetch_array($sql_result1))
				{
					$row_count++;
					$task_jobs_id=$sql_row1['task_jobs_id'];
					$task_header_id=$sql_row1['task_header_id'];
					$planned_date_time=$sql_row1['planned_date_time'];
					$resource_id=$sql_row1['resource_id'];
					$sql4="select sections.section_name from $pms.workstation left join $pms.sections on sections.section_id=workstation.section_id where workstation.workstation_id='$resource_id' and workstation.plant_code='$plantcode'";
					$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row4=mysqli_fetch_array($sql_result4))
					{
						$workstation_description=$sql_row4['section_name'];
					}
					$sql99="select attribute_value from $tms.task_attributes where task_jobs_id='$task_jobs_id' and plant_code='$plantcode' and attribute_name='DOCKETNO'";
					//echo $sql9;
					$sql_result99=mysqli_query($link, $sql99) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row99=mysqli_fetch_array($sql_result99))
					{
						$attribute_value=$sql_row99['attribute_value'];
						$sql11="SELECT component_name,docket_line_number,jm_docket_cg_bundle.jm_docket_line_id FROM $pps.jm_docket_cg_bundle LEFT JOIN $pps.jm_docket_lines ON 
						jm_docket_cg_bundle.jm_docket_line_id=jm_docket_lines.jm_docket_line_id 
						WHERE jm_docket_lines.plant_code='$plantcode' AND jm_docket_lines.docket_type='RECUT' AND jm_docket_lines.docket_line_number IN ($attribute_value) GROUP BY component_name";
						//mysqli_query($link, $sql2) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error222".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row8=mysqli_fetch_array($sql_result11))
						{

							$category_name=$sql_row8['component_name'];
							$jm_docket_line_id=$sql_row8['jm_docket_line_id'];
							// $size_ratio=$sql_row8['size_ratio'];
							$docket_number=$sql_row8['docket_line_number'];

							$sql111="SELECT jm_docket_lines.jm_docket_id,jm_docket_lines.jm_docket_line_id,jm_docket_lines.docket_line_number,jm_cut_job.cut_number,lp_ratio_component_group.ratio_id,lp_ratio_size.size,sum(lp_ratio_size.size_ratio) as size_ratio,jm_cut_job.po_number
							FROM $pps.jm_docket_lines 
							LEFT JOIN $pps.jm_dockets ON jm_dockets.jm_docket_id=jm_docket_lines.jm_docket_id LEFT JOIN $pps.jm_cut_job ON  jm_cut_job.
							jm_cut_job_id=jm_dockets.jm_cut_job_id LEFT JOIN $pps.lp_ratio_component_group ON lp_ratio_component_group.lp_ratio_cg_id
							=jm_dockets.ratio_comp_group_id LEFT JOIN $pps.lp_ratio_size ON lp_ratio_size.ratio_id=lp_ratio_component_group.ratio_id  
							WHERE jm_docket_lines.plant_code='$plantcode'  AND jm_docket_lines.jm_docket_line_id IN  ('$jm_docket_line_id')";


						
							$sql111_result11=mysqli_query($link_new, $sql111) or exit("Sql Error9098at_mp_sub_mo_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row4111=mysqli_fetch_array($sql111_result11))
							{
								$size_ratio=$sql_row4111['size_ratio'];
							
							}
								
							$sql3="select sum(plies) as plies from $pps.jm_docket_lines where jm_docket_line_id='$jm_docket_line_id' and plant_code='$plantcode'";
							$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row3=mysqli_fetch_array($sql_result3))
							{
								$plies=$sql_row3['plies'];
							}
						
							$total=$plies*$size_ratio;
							echo "<tr >";
							echo "<td >$workstation_description</td>";
						
							echo "<td >$docket_number</td>";
							echo "<td >$category_name</td>";
							echo "<td >$total</td>";
							echo "</tr>";
						}
			
					}		
				}
			if($row_count == 0){
				echo "<tr><td colspan=4 style='color:#ff0000'>No Data found</td></tr>";
			}
			echo "</table></div></div>";
			echo "</div></div>";
		}
 	?>
		</div>
</div>
</div>
