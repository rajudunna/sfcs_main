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
			
			$sqlx="select section_id,section_name from $pms.sections where plant_code='$plantcode'";
			$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		
				$all_sec_query = "SELECT GROUP_CONCAT('\"',section_id,'\"') as sec FROM $pms.sections where plant_code='$plantcode'";
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
						foreach($sql_resultx as $key=>$value){
							echo "<option value='\"".$value['section_id']."\"'>".$value['section_name']."</option>";
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

			$sql1="select task_header.task_header_id,task_jobs.task_jobs_id,task_header.planned_date_time,task_header.resource_id,task_header.created_at from $tms.task_header left join $tms.task_jobs on task_header.task_header_id=task_jobs.task_header_id  where task_header.plant_code='$plantcode' and task_header.resource_id in ($workstation) and 
			task_header.created_at between \"$from_date\" and \"$to_date\" and task_header.task_type='CUTJOB' and task_jobs.task_type='DOCKET'";
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
				$planned_date_time=$sql_row['created_at'];
				$date=date('d-m-Y', strtotime($planned_date_time));
				$resource_id=$sql_row['resource_id'];
				$sql4="select workstation_description from $pms.workstation where workstation_id='$resource_id' and plant_code='$plantcode'";
				$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row4=mysqli_fetch_array($sql_result4))
				{
					$workstation_description=$sql_row4['workstation_description'];
				}
				$sql9="select attribute_value from $tms.task_attributes where task_jobs_id='$task_jobs_id'  and plant_code='$plantcode' and attribute_name='DOCKETNO'";
				$sql_result9=mysqli_query($link, $sql9) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row9=mysqli_fetch_array($sql_result9))
				{
					$attribute_value=$sql_row9['attribute_value'];
				
				$sql2="SELECT jm_docket_lines.jm_docket_id,jm_docket_lines.jm_docket_line_id,jm_docket_lines.docket_line_number,jm_cut_job.cut_number,lp_ratio_component_group.ratio_id,lp_ratio_size.size,lp_ratio_size.size_ratio,jm_cut_job.po_number
				FROM $pps.jm_docket_lines 
				LEFT JOIN $pps.jm_dockets ON jm_dockets.jm_docket_id=jm_docket_lines.jm_docket_id LEFT JOIN $pps.jm_cut_job ON  jm_cut_job.
			   jm_cut_job_id=jm_dockets.jm_cut_job_id LEFT JOIN $pps.lp_ratio_component_group ON lp_ratio_component_group.lp_ratio_cg_id
			   =jm_dockets.ratio_comp_group_id LEFT JOIN $pps.lp_ratio_size ON lp_ratio_size.ratio_id=lp_ratio_component_group.ratio_id  
			   WHERE jm_docket_lines.plant_code='$plantcode'  AND jm_docket_lines.docket_line_number IN  ($attribute_value) ";
			 
                $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$docket_line_number=$sql_row2['docket_line_number'];
				$cut_number=$sql_row2['cut_number'];
				$size=$sql_row2['size'];
				$size_ratio=$sql_row2['size_ratio'];
				$po_number=$sql_row2['po_number'];
				$jm_docket_line_id=$sql_row2['jm_docket_line_id'];

				$sql3="select sum(plies) as plies from $pps.lp_lay where jm_docket_line_id='$jm_docket_line_id' and plant_code='$plantcode'";
				$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row3=mysqli_fetch_array($sql_result3))
			{
				$plies=$sql_row3['plies'];
			}
                if($plantcode!='' and $docket_line_number!=''){
					$result_mp_color_details=getJmDockets($docket_line_number,$plantcode);
					$style=$result_mp_color_details['style'];
					$fg_color=$result_mp_color_details['fg_color'];
					
					
				}
				// if($plantcode!='' and $docket_line_number!=''){
				// 	$result_category=getDocketInformation($docket_line_number,$plantcode);
				// 	$category=$result_category['category'];
					
					
					
				// }
				$qry_mp_sub_mo_qty="SELECT jm_docket_bundle_id,component_name FROM $pps.jm_docket_bundle WHERE jm_docket_line_id='$jm_docket_line_id' AND plant_code='$plantcode'";
				$mp_sub_mo_qty_result=mysqli_query($link_new, $qry_mp_sub_mo_qty) or exit("Sql Error9098at_mp_sub_mo_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row4=mysqli_fetch_array($mp_sub_mo_qty_result))
					{
						$jm_docket_bundle_id=$sql_row4['jm_docket_bundle_id'];
						$category_name=$sql_row4['component_name'];
					}
				$qry_mp_sub_mo_qty;
				$qry_mp_mo_qty="SELECT jm_product_logical_bundle_id FROM $pps.jm_docket_logical_bundle WHERE `jm_docket_bundle_id`='$jm_docket_bundle_id' AND plant_code='$plantcode'";
                $qry_mp_mo_qty_result=mysqli_query($link_new, $qry_mp_mo_qty) or exit("Sql Errorat 34_mp_mo_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row5=mysqli_fetch_array($qry_mp_mo_qty_result))
				{
					$jm_pplb_id=$sql_row5['jm_pplb_id'];
				}
				$qry_schedule="SELECT feature_value FROM $pps.jm_product_logical_bundle WHERE `jm_pplb_id`='$jm_pplb_id' AND plant_code='$plantcode'";
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
			   echo "<tr>";
			   
				
			}
		}
			// echo "<tr>";
			// 	echo "<td colspan=7></td>
			// 		  <td class='info'>Total Plies:</td>
			// 		  <td class='info'>$act_plies</td>
			// 		  <td class='info'>Total Qty:</td>
			// 		  <td class='info'>$act_total</td>";
			// 	echo "</tr>";
				// $date=$sql_row['date'];
				// $act_shift=$sql_row['shift'];
				// $act_section=$sql_row['section'];
				// $cut_remarks=$sql_row["remarks"];
				// $cut_remarks_explode=explode("$",$cut_remarks);
				// //var_dump($cut_remarks_explode);
				// $act_total=0;$act_plies=0;
				// for($ii=0;$ii<sizeof($cut_remarks_explode);$ii++)
				// {
				// 	$cut_details_explode=explode("^",$cut_remarks_explode[$ii]);
				// 	$cut_plies=$cut_details_explode[8];
				// 	$cut_date=$cut_details_explode[0];
				// 	$sql1="select * from $bai_pro3.plandoc_stat_log where doc_no=$doc_no";					
				// 	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
				// 	while($sql_row1=mysqli_fetch_array($sql_result1))
				// 	{
				// 		$cat_ref=$sql_row1['cat_ref'];
				// 		$act_cut_no=$sql_row1['acutno'];
				// 		$act_s = array();
				// 		for($i=0;$i<sizeof($sizes_array);$i++)
				// 		{												
				// 			$act_s[$i]=$sql_row1["a_".$sizes_array[$i].""]*$cut_plies;	
				// 		}						
				// 	}
				// 	$sql1="select * from $bai_pro3.cat_stat_log where tid=\"$cat_ref\"";
				// 	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
				// 	while($sql_row1=mysqli_fetch_array($sql_result1))
				// 	{
				// 		$category=$sql_row1['category'];
				// 		$order_tid=$sql_row1['order_tid'];
				// 	}
				// 	$sql1="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
				// 	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
				// 	while($sql_row1=mysqli_fetch_array($sql_result1))
				// 	{
				// 		$style=$sql_row1['order_style_no'];
				// 		$schedule=$sql_row1['order_del_no'];
				// 		$color_code=$sql_row1['color_code'];
				// 		$color=$sql_row1['order_col_des'];
				// 		for($i=0;$i<sizeof($sizes_array);$i++)
				// 		{												
				// 			if($sql_row1["title_size_".$sizes_array[$i].""]<>"")
				// 			{
				// 				$size[$i]=$sql_row1["title_size_".$sizes_array[$i].""];
				// 			}							
				// 		}						
				// 	}
				// 	for($i=0;$i<sizeof($size);$i++)
				// 	{
				// 		if($act_s[$i]>0)
				// 		{
				// 			echo "<tr>
				// 			<td>".$cut_details_explode[0]."</td> 
				// 			<td>".$cut_details_explode[2]."</td> 
				// 			<td>".$cut_details_explode[1]."</td> 
				// 			<td>".leading_zeros($doc_no,9)."</td> 
				// 			<td>$style</td> 
				// 			<td>$schedule</td> 
				// 			<td>$color</td> 
				// 			<td>$category</td> 
				// 			<td>".chr($color_code).leading_zeros($act_cut_no,3)."</td>
				// 			<td>".$cut_plies."</td>";
				// 			echo "<td>".$size[$i]."</td>";		
				// 			echo "<td>".$act_s[$i]."</td>";
				// 			echo "</tr>";
				// 			$act_total=$act_s[$i]+$act_total;
				// 		}							
				// 	}
				// 	$act_plies=$act_plies+$cut_plies;
				// 	unset($act_s);
				// }		
				// echo "<tr>";
				// echo "<td colspan=8></td>
				// 	  <td class='info'>Total Plies:</td>
				// 	  <td class='info'>$act_plies</td>
				// 	  <td class='info'>Total Qty:</td>
				// 	  <td class='info'>$act_total</td>";
				// echo "</tr>";
				// $act_total = 0;
  				
			}
			
			echo "</table>
				</div>";    
 		
			//Recut

			// $sql="select * from $pps.act_cut_status_recut_v2 where plant_code='$plantcode' and section in ($section) and shift in ($shift) and date between \"$from_date\" and \"$to_date\"";
			// //echo $sql;
			// mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
			// $sql_result=mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
			// $sql_num_check=mysqli_num_rows($sql_result);

			// if($sql_num_check > 0){
			// 	echo "<div class='table-responsive'><table class='table table-bordered'>";
			// 	echo "<tr class='warning'>
			// 			<th class='tblheading'>Date 2</th><th class='tblheading'>Shift 2</th>
			// 			<th class='tblheading' >Section</th>
			// 			<th class='tblheading'>Docket No</th>
			// 			<th class='tblheading'>Style</th>
			// 			<th class='tblheading'>Schedule</th>
			// 			<th class='tblheading'>Color</th>
			// 			<th class='tblheading'>Category</th>
			// 			<th class='tblheading'>Cut No</th>
			// 			<th>Size</th>
			// 			<th>Qty</th>";
			// }

			while($sql_row=mysqli_fetch_array($sql_result))
			{
				
				$doc_no=$sql_row['doc_no'];
				$date=$sql_row['date'];
				$act_shift=$sql_row['shift'];
				$act_section=$sql_row['section'];
				
				
				$sql1="select * from $bai_pro3.recut_v2 where doc_no=\"$doc_no\"";
				mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row1=mysqli_fetch_array($sql_result1))
				{
					$cat_ref=$sql_row1['cat_ref'];
					$act_cut_no=$sql_row1['acutno'];
					$act_xs=$sql_row1['a_xs']*$sql_row1['a_plies'];
					$act_s=$sql_row1['a_s']*$sql_row1['a_plies'];
					$act_m=$sql_row1['a_m']*$sql_row1['a_plies'];
					$act_l=$sql_row1['a_l']*$sql_row1['a_plies'];
					$act_xl=$sql_row1['a_xl']*$sql_row1['a_plies'];
					$act_xxl=$sql_row1['a_xxl']*$sql_row1['a_plies'];
					$act_xxxl=$sql_row1['a_xxxl']*$sql_row1['a_plies'];

					// $act_s01=$sql_row1['a_s01']*$sql_row1['a_plies'];
					// $act_s02=$sql_row1['a_s02']*$sql_row1['a_plies'];
					// $act_s03=$sql_row1['a_s03']*$sql_row1['a_plies'];
					// $act_s04=$sql_row1['a_s04']*$sql_row1['a_plies'];
					// $act_s05=$sql_row1['a_s05']*$sql_row1['a_plies'];
					// $act_s06=$sql_row1['a_s06']*$sql_row1['a_plies'];
					// $act_s07=$sql_row1['a_s07']*$sql_row1['a_plies'];
					// $act_s08=$sql_row1['a_s08']*$sql_row1['a_plies'];
					// $act_s09=$sql_row1['a_s09']*$sql_row1['a_plies'];
					// $act_s10=$sql_row1['a_s10']*$sql_row1['a_plies'];
					// $act_s11=$sql_row1['a_s11']*$sql_row1['a_plies'];
					// $act_s12=$sql_row1['a_s12']*$sql_row1['a_plies'];
					// $act_s13=$sql_row1['a_s13']*$sql_row1['a_plies'];
					// $act_s14=$sql_row1['a_s14']*$sql_row1['a_plies'];
					// $act_s15=$sql_row1['a_s15']*$sql_row1['a_plies'];
					// $act_s16=$sql_row1['a_s16']*$sql_row1['a_plies'];
					// $act_s17=$sql_row1['a_s17']*$sql_row1['a_plies'];
					// $act_s18=$sql_row1['a_s18']*$sql_row1['a_plies'];
					// $act_s19=$sql_row1['a_s19']*$sql_row1['a_plies'];
					// $act_s20=$sql_row1['a_s20']*$sql_row1['a_plies'];
					// $act_s21=$sql_row1['a_s21']*$sql_row1['a_plies'];
					// $act_s22=$sql_row1['a_s22']*$sql_row1['a_plies'];
					// $act_s23=$sql_row1['a_s23']*$sql_row1['a_plies'];
					// $act_s24=$sql_row1['a_s24']*$sql_row1['a_plies'];
					// $act_s25=$sql_row1['a_s25']*$sql_row1['a_plies'];
					// $act_s26=$sql_row1['a_s26']*$sql_row1['a_plies'];
					// $act_s27=$sql_row1['a_s27']*$sql_row1['a_plies'];
					// $act_s28=$sql_row1['a_s28']*$sql_row1['a_plies'];
					// $act_s29=$sql_row1['a_s29']*$sql_row1['a_plies'];
					// $act_s30=$sql_row1['a_s30']*$sql_row1['a_plies'];
					// $act_s31=$sql_row1['a_s31']*$sql_row1['a_plies'];
					// $act_s32=$sql_row1['a_s32']*$sql_row1['a_plies'];
					// $act_s33=$sql_row1['a_s33']*$sql_row1['a_plies'];
					// $act_s34=$sql_row1['a_s34']*$sql_row1['a_plies'];
					// $act_s35=$sql_row1['a_s35']*$sql_row1['a_plies'];
					// $act_s36=$sql_row1['a_s36']*$sql_row1['a_plies'];
					// $act_s37=$sql_row1['a_s37']*$sql_row1['a_plies'];
					// $act_s38=$sql_row1['a_s38']*$sql_row1['a_plies'];
					// $act_s39=$sql_row1['a_s39']*$sql_row1['a_plies'];
					// $act_s40=$sql_row1['a_s40']*$sql_row1['a_plies'];
					// $act_s41=$sql_row1['a_s41']*$sql_row1['a_plies'];
					// $act_s42=$sql_row1['a_s42']*$sql_row1['a_plies'];
					// $act_s43=$sql_row1['a_s43']*$sql_row1['a_plies'];
					// $act_s44=$sql_row1['a_s44']*$sql_row1['a_plies'];
					// $act_s45=$sql_row1['a_s45']*$sql_row1['a_plies'];
					// $act_s46=$sql_row1['a_s46']*$sql_row1['a_plies'];
					// $act_s47=$sql_row1['a_s47']*$sql_row1['a_plies'];
					// $act_s48=$sql_row1['a_s48']*$sql_row1['a_plies'];
					// $act_s49=$sql_row1['a_s49']*$sql_row1['a_plies'];
					// $act_s50=$sql_row1['a_s50']*$sql_row1['a_plies'];

					$act_s = array();
					for($i=1;$i<=50;$i++){	
						if($i<=9){										
							$act_s[$i]=$sql_row1['a_s0'.$i]*$cut_plies;									
						}else{
							$act_s[$i]=$sql_row1['a_s'.$i]*$cut_plies;
						}
					}			
					//$act_total = $act_xs+$act_s+$act_m+$act_l+$act_xl+$act_xxl+$act_xxxl;					
					foreach($act_s as $val){
						$act_total+=$val;
					}
							
					// $act_total=$act_xs+$act_s+$act_m+$act_l+$act_xl+$act_xxl+$act_xxxl+$act_s01+$act_s02+$act_s03+$act_s04+$act_s05+$act_s06+$act_s07+$act_s08+$act_s09+$act_s10+$act_s11+$act_s12+$act_s13+$act_s14+$act_s15+$act_s16+$act_s17+$act_s18+$act_s19+$act_s20+$act_s21+$act_s22+$act_s23+$act_s24+$act_s25+$act_s26+$act_s27+$act_s28+$act_s29+$act_s30+$act_s31+$act_s32+$act_s33+$act_s34+$act_s35+$act_s36+$act_s37+$act_s38+$act_s39+$act_s40+$act_s41+$act_s42+$act_s43+$act_s44+$act_s45+$act_s46+$act_s47+$act_s48+$act_s49+$act_s50;
				}
	
				// $sql1="select * from cat_stat_log where tid=$cat_ref";
				// mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				// $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				// while($sql_row1=mysqli_fetch_array($sql_result1))
				// {
				// 	$category=$sql_row1['category'];
				// 	$order_tid=$sql_row1['order_tid'];
				// }	
	
				// $sql1="select * from bai_orders_db where order_tid=\"$order_tid\"";
				// mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				// $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				// while($sql_row1=mysqli_fetch_array($sql_result1))
				// {
				// 	$style=$sql_row1['order_style_no'];
				// 	$schedule=$sql_row1['order_del_no'];
				// 	$color_code=$sql_row1['color_code'];
				// 	$color=$sql_row1['order_col_des'];
				// 	for($i=0;$i<50;$i++)
				// 			{
				// 				$key1 = 'title_size_s'.str_pad($i+1, 2, "0", STR_PAD_LEFT);
				// 				$size[$i] = $sql_row1[$key1];
				// 			}
					
				// }
              
			/*echo "<th class='tblheading'>01</th><th class='tblheading'>02</th><th class='tblheading'>03</th><th class='tblheading'>04</th><th class='tblheading'>05</th><th class='tblheading'>06</th><th class='tblheading'>07</th><th class='tblheading'>08</th><th class='tblheading'>09</th><th class='tblheading'>10</th><th class='tblheading'>11</th><th class='tblheading'>12</th><th class='tblheading'>13</th><th class='tblheading'>14</th><th class='tblheading'>15</th><th class='tblheading'>16</th><th class='tblheading'>17</th><th class='tblheading'>18</th><th class='tblheading'>19</th><th class='tblheading'>20</th><th class='tblheading'>21</th><th class='tblheading'>22</th><th class='tblheading'>23</th><th class='tblheading'>24</th><th class='tblheading'>25</th><th class='tblheading'>26</th><th class='tblheading'>27</th><th class='tblheading'>28</th><th class='tblheading'>29</th><th class='tblheading'>30</th><th class='tblheading'>31</th><th class='tblheading'>32</th><th class='tblheading'>33</th><th class='tblheading'>34</th><th class='tblheading'>35</th><th class='tblheading'>36</th><th class='tblheading'>37</th><th class='tblheading'>38</th><th class='tblheading'>39</th><th class='tblheading'>40</th><th class='tblheading'>41</th><th class='tblheading'>42</th><th class='tblheading'>43</th><th class='tblheading'>44</th><th class='tblheading'>45</th><th class='tblheading'>46</th><th class='tblheading'>47</th><th class='tblheading'>48</th><th class='tblheading'>49</th><th class='tblheading'>50</th>";*/
				$inner_count = 0;
				echo "<td>$date</td>
						<td>$act_shift</td> 
						<td>$act_section</td> 
						<td>".leading_zeros($doc_no,9)."</td> 
						<td>$style</td> 
						<td>$schedule</td> 
						<td>$color</td> 
						<td>$category</td> 
						<td>"."R".leading_zeros($act_cut_no,3)."</td>";
				
				for($i=0;$i<50;$i++)
				{
					if($size[$i]!=''){
						if($inner_count==0){
							echo "<td>".$size[$i]."</td>";
							echo "<td>".$act_s[$i+1]."</td>";
							echo "</tr>";
							$inner_count++;
						}
						else{
							echo "<tr>
								<td>".$cut_details_explode[0]."</td> 
								<td>".$cut_details_explode[2]."</td> 
								<td>".$cut_details_explode[1]."</td> 
								<td>".leading_zeros($doc_no,9)."</td> 
								<td>$style</td> 
								<td>$schedule</td> 
								<td>$color</td> 
								<td>$category</td> 
								<td>".chr($color_code).leading_zeros($act_cut_no,3)."</td>";
						echo "<td>".$size[$i]."</td>";		
						echo "<td>".$act_s[$i+1]."</td>";
						echo "</tr>";
						}
					}
				}
				echo "<tr>";
				echo "<td></td><td></td><td></td><td>
							  </td><td></td><td></td>
							  <td></td><td></td><td></td>
							  <td class='info'>Total :</td>
							  <td class='info'>$act_total</td>";
				echo "</tr>";
				echo "</tr>";
				 $act_total = 0;

			}
			echo "</table></div>";
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
			// while($sql_row=mysqli_fetch_array($sql_result))
			// {
			// 	$row_count++;
			// 	$section=$sql_row['workstation_id'];
			// 	$workstation_description=$sql_row['workstation_description'];
			$sql1="select task_header.task_header_id,task_jobs.task_jobs_id,task_header.planned_date_time,task_header.resource_id from $tms.task_header left join $tms.task_jobs on task_header.task_header_id=task_jobs.task_header_id  where task_header.plant_code='$plantcode' and task_header.resource_id in ($workstation) and 
			task_header.created_at between \"$from_date\" and \"$to_date\" and task_header.task_type='CUTJOB' and task_jobs.task_type='DOCKET'";
				mysqli_query($link, $sql1) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error222".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row1=mysqli_fetch_array($sql_result1))
				{

					$row_count++;
				
					$task_jobs_id=$sql_row1['task_jobs_id'];
					$task_header_id=$sql_row1['task_header_id'];
					$planned_date_time=$sql_row1['planned_date_time'];
					$resource_id=$sql_row1['resource_id'];
					$sql4="select workstation_description from $pms.workstation where workstation_id='$resource_id' and plant_code='$plantcode'";
					$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row4=mysqli_fetch_array($sql_result4))
					{
						$workstation_description=$sql_row4['workstation_description'];
					}
					$sql99="select attribute_value from $tms.task_attributes where task_jobs_id='$task_jobs_id' and plant_code='$plantcode' and attribute_name='DOCKETNO'";
					//echo $sql9;
					$sql_result99=mysqli_query($link, $sql99) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row99=mysqli_fetch_array($sql_result99))
					{
						$attribute_value=$sql_row99['attribute_value'];
					
				$sql11="SELECT jm_docket_lines.jm_docket_id,jm_docket_lines.jm_docket_line_id,jm_docket_lines.docket_line_number,jm_dockets.ratio_comp_group_id,lp_ratio_component_group.ratio_id,lp_ratio_size.size,lp_ratio_size.size_ratio,SUM(lp_ratio_size.size_ratio) AS
				size_ratio,jm_docket_bundle.component_name
				FROM $pps.jm_docket_lines 
				LEFT JOIN $pps.jm_dockets ON jm_dockets.jm_docket_id=jm_docket_lines.jm_docket_id LEFT JOIN $pps.lp_ratio_component_group ON lp_ratio_component_group.lp_ratio_cg_id
			   =jm_dockets.ratio_comp_group_id LEFT JOIN $pps.lp_ratio_size ON lp_ratio_size.ratio_id=lp_ratio_component_group.ratio_id  left join $pps.jm_docket_bundle on jm_docket_bundle.jm_docket_line_id=jm_docket_lines.jm_docket_line_id
			   WHERE jm_docket_lines.plant_code='$plantcode' and jm_docket_lines.docket_line_number in ($attribute_value) GROUP BY jm_docket_bundle.component_name,jm_docket_lines.docket_line_number";
			   //mysqli_query($link, $sql2) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
			   $sql_result11=mysqli_query($link, $sql11) or exit("Sql Error222".mysqli_error($GLOBALS["___mysqli_ston"]));
			    while($sql_row8=mysqli_fetch_array($sql_result11))
				{

					$component_name=$sql_row8['component_name'];
					$jm_docket_line_id=$sql_row8['jm_docket_line_id'];
					$size_ratio=$sql_row8['size_ratio'];
					$docket_number=$sql_row8['docket_line_number'];
				
					$qry_mp_sub_mo_qty="SELECT jm_docket_bundle_id,component_name FROM $pps.jm_docket_bundle WHERE jm_docket_line_id='$jm_docket_line_id' AND plant_code='$plantcode'";
					$mp_sub_mo_qty_result=mysqli_query($link_new, $qry_mp_sub_mo_qty) or exit("Sql Error9098at_mp_sub_mo_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row4=mysqli_fetch_array($mp_sub_mo_qty_result))
						{
							$jm_docket_bundle_id=$sql_row4['jm_docket_bundle_id'];
							$category_name=$sql_row4['component_name'];
						}
				
				$sql3="select sum(plies) as plies from $pps.lp_lay where jm_docket_line_id='$jm_docket_line_id' and plant_code='$plantcode'";
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
		       
					// $shift_new=$sql_row1['shift'];
					// $doc_list="";
					// $sql2="select doc_no from $pps.act_cut_status where plant_code='$plantcode' and date between \"$from_date\" and \"$to_date\" and section=\"$section_new\" and shift=\"$shift_new\"";
					// mysqli_query($link, $sql2) or exit("Sql Error456".mysqli_error($GLOBALS["___mysqli_ston"]));
					// $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error456".mysqli_error($GLOBALS["___mysqli_ston"]));
					// while($sql_row2=mysqli_fetch_array($sql_result2))
					// {
					// 	$doc_list=$doc_list.$sql_row2['doc_no'].", ";
					// }
					// $doc_list=substr($doc_list,0,-2);
					// $cat_list="";
					// $sql2="select distinct cat_ref from $bai_pro3.plandoc_stat_log where doc_no in ($doc_list) order by cat_ref";
					// mysqli_query($link, $sql2) or exit("Sql Error789".mysqli_error($GLOBALS["___mysqli_ston"]));
					// $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error789".mysqli_error($GLOBALS["___mysqli_ston"]));
					// while($sql_row2=mysqli_fetch_array($sql_result2))
					// {
					// 	$cat_list=$cat_list.$sql_row2['cat_ref'].", ";
					// }
					// $cat_list=substr($cat_list,0,-2);
				// 	$sql2="SELECT jm_docket_lines.jm_docket_id,jm_docket_lines.jm_docket_line_id,jm_docket_lines.docket_line_number,jm_cut_job.cut_number,lp_ratio_component_group.ratio_id,lp_ratio_size.size,lp_ratio_size.size_ratio,jm_cut_job.po_number
				// 	FROM $pps.jm_docket_lines 
				// 	LEFT JOIN $pps.jm_dockets ON jm_dockets.jm_docket_id=jm_docket_lines.jm_docket_id LEFT JOIN $pps.jm_cut_job ON  jm_cut_job.
				//    jm_cut_job_id=jm_dockets.jm_cut_job_id LEFT JOIN $pps.lp_ratio_component_group ON lp_ratio_component_group.lp_ratio_cg_id
				//    =jm_dockets.ratio_comp_group_id LEFT JOIN $pps.lp_ratio_size ON lp_ratio_size.ratio_id=lp_ratio_component_group.ratio_id  
				//    WHERE jm_docket_lines.plant_code='$plantcode'  AND jm_docket_lines.docket_line_number IN  ($attribute_value)";
				// 	mysqli_query($link, $sql2) or exit("Sql Error111".mysqli_error($GLOBALS["___mysqli_ston"]));
				// 	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error111".mysqli_error($GLOBALS["___mysqli_ston"]));
				// 	while($sql_row2=mysqli_fetch_array($sql_result2))
				// 	{
				// 		$category=$sql_row2['category'];
				// 		$cat_base="";
						// $sql3="select distinct tid from $bai_pro3.cat_stat_log where category=\"$category\" and tid in ($cat_list)";
						// mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						// $sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						// while($sql_row3=mysqli_fetch_array($sql_result3))
						// {
						// 	$cat_base=$cat_base.$sql_row3['tid'].", ";
						// }
						// $cat_base=substr($cat_base,0,-2);
						// $sql3="select sum((a_xs+a_s+a_m+a_l+a_xl+a_xxl+a_xxxl+a_s01+a_s02+a_s03+a_s04+a_s05+a_s06+a_s07+a_s08+a_s09+a_s10+a_s11+a_s12+a_s13+a_s14+a_s15+a_s16+a_s17+a_s18+a_s19+a_s20+a_s21+a_s22+a_s23+a_s24+a_s25+a_s26+a_s27+a_s28+a_s29+a_s30+a_s31+a_s32+a_s33+a_s34+a_s35+a_s36+a_s37+a_s38+a_s39+a_s40+a_s41+a_s42+a_s43+a_s44+a_s45+a_s46+a_s47+a_s48+a_s49+a_s50)*a_plies) as \"cut_qty\" from $bai_pro3.plandoc_stat_log where doc_no in ($doc_list) and cat_ref in ($cat_base)";
						// mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						// $sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						// while($sql_row3=mysqli_fetch_array($sql_result3))
						// {
						// 	$cut_qty=$sql_row3['cut_qty'];
						// }
				
	 					
 
						}
				//}
			//}
			if($row_count == 0){
				echo "<tr><td colspan=4 style='color:#ff0000'>No Data found</td></tr>";
			}
			echo "</table></div></div>";
			
	
	
	//recut

	// echo "<br/>";
	// echo " <div class='panel panel-default'>
	// <h2 align='center'>
	// <b>Summary Report for Re-Cut Quantity</b></h2>
	// <div class='panel-body'>";
	
	// echo"<table class='table table-bordered'>
	// 	  <tr class='warning'>
	// 	  <th class='tblheading'>Section</th>
	// 	  <th class='tblheading'>Shift</th>
	// 	  <th class='tblheading'>Category</th>
	// 	  <th class='tblheading'>Re Cut Qty</th>
	// 	  </tr>";
 	// 		$sql="select distinct section from $pps.act_cut_status_recut_v2 where plant_code='$plantcode' and section in ($section) and shift in ($shift) and date between \"$from_date\" and \"$to_date\" order by section";
			
	// 		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// 		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// 		$sql_num_check=mysqli_num_rows($sql_result);
	// 		$row_count = 0;
	// 		while($sql_row=mysqli_fetch_array($sql_result))
	// 		{
	// 			$section_new=$sql_row['section'];
	// 			$sql1="select distinct shift from $pps.act_cut_status_recut_v2 where plant_code='$plantcode' and date between \"$from_date\" and \"$to_date\" and section=\"$section_new\" and shift in ($shift) order by shift";
	// 			mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// 			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// 			while($sql_row1=mysqli_fetch_array($sql_result1))
	// 			{
	// 				$row_count++;
	// 				$shift_new=$sql_row1['shift'];
	// 				$doc_list="";
	// 				$sql2="select doc_no from $pps.act_cut_status_recut_v2 where plant_code='$plantcode' and date between \"$from_date\" and \"$to_date\" and section=$section_new and shift=\"$shift_new\"";
	// 				mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// 				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// 				while($sql_row2=mysqli_fetch_array($sql_result2))
	// 				{
	// 					$doc_list=$doc_list.$sql_row2['doc_no'].", ";
	// 				}
	// 				$doc_list=substr($doc_list,0,-2);
	// 				$cat_list="";
	// 				$sql2="select distinct cat_ref from $bai_pro3.recut_v2 where doc_no in ($doc_list) order by cat_ref";
	// 				mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// 				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// 				while($sql_row2=mysqli_fetch_array($sql_result2))
	// 				{
	// 					$cat_list=$cat_list.$sql_row2['cat_ref'].", ";
	// 				}
	// 				$cat_list=substr($cat_list,0,-2);
	// 				$sql2="select distinct category from $bai_pro3.cat_stat_log where tid in ($cat_list)";
	// 				mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// 				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// 				while($sql_row2=mysqli_fetch_array($sql_result2))
	// 				{
	// 					$category=$sql_row2['category'];
	// 					$cat_base="";
	// 					$sql3="select distinct tid from $bai_pro3.cat_stat_log where category=\"$category\" and tid in ($cat_list)";
	// 					mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// 					$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// 					while($sql_row3=mysqli_fetch_array($sql_result3))
	// 					{
	// 						$cat_base=$cat_base.$sql_row3['tid'].", ";
	// 					}
	// 					$cat_base=substr($cat_base,0,-2);
	// 					$sql3="select sum((a_xs+a_s+a_m+a_l+a_xl+a_xxl+a_xxxl+a_s01+a_s02+a_s03+a_s04+a_s05+a_s06+a_s07+a_s08+a_s09+a_s10+a_s11+a_s12+a_s13+a_s14+a_s15+a_s16+a_s17+a_s18+a_s19+a_s20+a_s21+a_s22+a_s23+a_s24+a_s25+a_s26+a_s27+a_s28+a_s29+a_s30+a_s31+a_s32+a_s33+a_s34+a_s35+a_s36+a_s37+a_s38+a_s39+a_s40+a_s41+a_s42+a_s43+a_s44+a_s45+a_s46+a_s47+a_s48+a_s49+a_s50)*a_plies) as \"cut_qty\" from $bai_pro3.recut_v2 where doc_no in ($doc_list) and cat_ref in ($cat_base)";
	// 					mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// 					$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// 					while($sql_row3=mysqli_fetch_array($sql_result3))
	// 					{
	// 						$cut_qty=$sql_row3['cut_qty'];
	// 					}
	// 					$row_count++;
	//  					echo "<tr >";
	// 				    echo "<td >$section_new</td>";
	// 				  	echo "<td >$shift_new</td>";
	// 				  	echo "<td >$category</td>";
	// 				  	echo "<td >$cut_qty</td>";
	//  					echo "</tr>";
 
 	// 				}
	// 			}
	// 		}
	// 		if($row_count == 0){
	// 			echo "<tr><td colspan=4 style='color:#ff0000'>No Data found</td></tr>";
	// 		}
	// 		echo "</table></div>";
			
			echo "</div></div>";
		}
 	?>
		</div>
</div>
</div>