<?php
  
// error_reporting(0);

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
$table_filter = getFullURLLevel($_GET['r'],'common/js/tablefilter.js',3,'R');
$plantcode = $_SESSION['plantCode'];
$username=$_SESSION['userName'];
// $plantcode = 'AIP';
?>

<title>RMS Requisition status</title>
<script type="text/javascript">
	function verify_date(){
		var from_date = $('#sdate').val();
		var to_date =  $('#edate').val();
		if(to_date < from_date){
			sweetAlert('End Date must not be less than Start Date','','warning');
			return false;
		}
		else
		{
			return true;
		}
	}
</script>

<style>

th,td{
	color : #000;
}

#page_heading{
    width: 100%;
    height: 25px;
    color: WHITE;
    background-color: #29759c;
    z-index: -999;
    font-family:Arial;
    font-size:15px;  
	margin-bottom: 10px;
}

#page_heading h3{
	vertical-align: middle;
	margin-left: 15px;
	margin-bottom: 0;	
	padding: 0px;
 }

#page_heading img{
    margin-top: 2px;
    margin-right: 15px;
}
</style>

<div class='panel panel-primary'>
	<div class="panel-heading">
		<b>RMS Requisition Report</b>
	</div>
	<div class="panel-body">
		<form method="post" name="input" action="?r=<?php echo $_GET['r'] ?>">
			<div class="col-sm-3 form-group">
				<label for='sdate'>Start Date  </label>
				<input class="form-control" type="text" data-toggle="datepicker" id="sdate" name="sdate" size=8 value="<?php  if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>"/>
			</div>
			<div class="col-sm-3 form-group">
				<label for='edate'>End Date </label>
				<input class="form-control" type="text" data-toggle="datepicker" id="edate" onchange="return verify_date();" name="edate" size=8 value="<?php  if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>"/>
			</div>
			<div class="col-sm-1">
				<br>
				<input class="btn btn-success" type="submit" name="show" value="Show" id="show" 
				onclick="return verify_date();"/>
			</div>	
		</form>
		<hr>
		


<?php
if(isset($_POST['show']))
{
	$s_date=$_POST['sdate'];
	$e_date=$_POST['edate'];
	//get cut 
	$get_cut_jobs="select ratio_id,jm_cut_job_id,cut_number,po_number from $pps.jm_cut_job where date(created_at) between '".$s_date."' and '".$e_date."' and plant_code='$plantcode' and is_active=true";
	// echo $get_cut_jobs;
	$get_cut_jobs_result=mysqli_query($link, $get_cut_jobs) or exit("Sql Error--1x==".$get_cut_jobs.mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($get_cut_jobs_result)>0)
	{
	echo "<div class='col-sm-12' style='max-height : 600px;overflow-y : scroll;overflow-x:scroll;'>
			<table id='table1' class='table table-bordered table-responsive' style='width: 100%''>
			<tr class='danger'>
				<th>Style </th>
				<th>PO </th>
				<th>SUB PO </th>
				<th>Schedule</th>
				<th>Color</th>
				<th>Cut Job</th>
				<th>Pending Dockets</th>
				<th>Planned Dockets</th>
				<th>Cut Completed Dockets</th>
			</tr>";
		
	while($get_cut_jobs_row=mysqli_fetch_array($get_cut_jobs_result))
	{
		$ratio_id=$get_cut_jobs_row['ratio_id'];
		$jm_cut_job_id=$get_cut_jobs_row['jm_cut_job_id'];
		$cut_number=$get_cut_jobs_row['cut_number'];
		$po_number=$get_cut_jobs_row['po_number'];


		//get po_description,master_po_number from po_number
		$get_sub_po="select po_description,master_po_number from $pps.mp_sub_order where plant_code='$plantcode' and po_number='$po_number' and is_active=true";
		// echo $get_sub_po;
		$get_sub_po_result=mysqli_query($link, $get_sub_po) or exit("Sql Error--1x==".$get_sub_po.mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($get_sub_po_result)>0)
		{
			while($get_sub_po_row=mysqli_fetch_array($get_sub_po_result))
			{

				$po_description=$get_sub_po_row['po_description'];
				$master_po_number=$get_sub_po_row['master_po_number'];
				
				 /**So we will show master description based on masetr po number */
				 $master_po_description='';
				 $qry_toget_podescri="SELECT master_po_description FROM $pps.mp_order WHERE master_po_number = '$master_po_number'";
				//  echo $qry_toget_podescri;
				 $toget_podescri_result=mysqli_query($link, $qry_toget_podescri) or exit("Sql Error at mp_order".mysqli_error($GLOBALS["___mysqli_ston"]));
				 $toget_podescri_num=mysqli_num_rows($toget_podescri_result);
				 if($toget_podescri_num>0){
					 while($toget_podescri_row=mysqli_fetch_array($toget_podescri_result))
					{
						$master_po_description=$toget_podescri_row["master_po_description"];
					}
				 }


				//get style,color from master_po_number
				$get_mpo="select style,group_concat(distinct(color)) as color from $pps.mp_color_detail where plant_code='$plantcode' and master_po_number='$master_po_number' and is_active=true limit 1";
				$get_mpo_result=mysqli_query($link, $get_mpo) or exit("Sql Error--1x==".$get_mpo.mysqli_error($GLOBALS["___mysqli_ston"]));
				// echo $get_mpo;
				if(mysqli_num_rows($get_mpo_result)>0)
				{
					while($get_mpo_row=mysqli_fetch_array($get_mpo_result))
					{
						$style=$get_mpo_row['style'];
						// $color=$get_mpo_row['color'];

						$qry_get_sch_col="SELECT schedule,color FROM $pps.`mp_sub_mo_qty` LEFT JOIN $pps.`mp_mo_qty` ON mp_sub_mo_qty.`mp_mo_qty_id`= mp_mo_qty.`mp_mo_qty_id`
						WHERE po_number='$po_number' AND mp_sub_mo_qty.plant_code='$plantcode'";
						$qry_get_sch_col_result=mysqli_query($link_new, $qry_get_sch_col) or exit("Sql Error at qry_get_sch_col".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($row=mysqli_fetch_array($qry_get_sch_col_result))
						{
							$schedule[]=$row['schedule'];
							$colors[]=$row['color'];
						}
						$schedules = implode(",",array_unique($schedule));
						$color = implode(",",array_unique($colors));

						// $master_po_details_id=array();
						// $qry_mp_color_detail="SELECT master_po_details_id FROM $pps.mp_color_detail WHERE plant_code='$plantcode' AND style='$style'";
						// $mp_color_detail_result=mysqli_query($link_new, $qry_mp_color_detail) or exit("Sql Error at mp_color_detail".mysqli_error($GLOBALS["___mysqli_ston"]));
						// $mp_color_detail_num=mysqli_num_rows($mp_color_detail_result);
						// if($mp_color_detail_num>0){
						// 	while($mp_color_detail_row=mysqli_fetch_array($mp_color_detail_result))
						// 	{
						// 		$master_po_details_id[]=$mp_color_detail_row["master_po_details_id"];
						// 	}

						// 	$schedule=array();
						// 	$qry_mp_mo_qty="SELECT schedule FROM $pps.mp_mo_qty WHERE plant_code='$plantcode' AND master_po_details_id IN ('".implode("','" , $master_po_details_id)."')";
						// 	$mp_mo_qty_result=mysqli_query($link_new, $qry_mp_mo_qty) or exit("Sql Error at mp_color_detail".mysqli_error($GLOBALS["___mysqli_ston"]));
						// 	$mp_mo_qty_num=mysqli_num_rows($mp_mo_qty_result);
						// 	if($mp_mo_qty_num>0){
						// 		while($mp_mo_qty_row=mysqli_fetch_array($mp_mo_qty_result))
						// 			{
										
						// 				$schedule[]=$mp_mo_qty_row["schedule"];
						// 			}
						// 			$bulk_schedule=array_unique($schedule);
						// 			$schedules = implode(",",$bulk_schedule);

						// 	}
						// }
					}
				}

				//get component_group_id from ratio_id
				$get_component_id="select component_group_id from $pps.lp_ratio_component_group where ratio_id='$ratio_id' and plant_code='$plantcode' and is_active=true";
				// echo $get_component_id;
				$get_component_id_result=mysqli_query($link, $get_component_id) or exit("Sql Error--1x==".$get_component_id.mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($get_component_id_result)>0)
				{
					while($get_component_id_row=mysqli_fetch_array($get_component_id_result))
					{
						$component_group_id=$get_component_id_row['component_group_id'];

						//get main component from master_po_component_group_id
						$get_component_name="select component_group_name from $pps.lp_component_group where lp_cg_id='$component_group_id' and is_main_component_group =true and is_active=true";
						// echo $get_component_name;
						$get_component_name_result=mysqli_query($link, $get_component_name) or exit("Sql Error--1x==".$get_component_name.mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($get_component_name_result)>0)
						{
							while($get_component_name_row=mysqli_fetch_array($get_component_name_result))
							{
								$component_group_name=$get_component_name_row['component_group_name'];
								
								//get docket numbers from cut number
								$open_dockets_list = array();
								$pending_dockets_list = array();
								$completed_list = array();
								$open_dockets = '';
								$pending_dockets = '';
								$completed_dockets = '';
								$completed = '';
								$get_docket="SELECT jd.jm_docket_id,jd.docket_number FROM $pps.jm_dockets jd WHERE jd.jm_cut_job_id='$jm_cut_job_id' AND jd.plant_code='$plantcode' AND jd.is_active=true order by jd.docket_number";
								// echo $get_docket.'<br/>';
								$get_docket_result=mysqli_query($link, $get_docket) or exit("Sql Error--1x== get_docket".mysqli_error($GLOBALS["___mysqli_ston"]));
								if(mysqli_num_rows($get_docket_result)>0)
								{
									while($get_docket_row=mysqli_fetch_array($get_docket_result))
									{
										$jm_docket_id = $get_docket_row['jm_docket_id'];
										$dockets_list[]= $component_group_name.':'.$get_docket_row['docket_number'];
										$get_pending_dockets="select cut_report_status from $pps.lp_lay where jm_docket_id='$jm_docket_id' and plant_code='$plantcode' and is_active=true limit 1";
										// echo $get_pending_dockets.'<br/>';
										$get_pending_dockets_result=mysqli_query($link, $get_pending_dockets) or exit("Sql Error--1x==".$get_pending_dockets.mysqli_error($GLOBALS["___mysqli_ston"]));
										if(mysqli_num_rows($get_pending_dockets_result) > 0)
										{
											while($get_pending_docket_row=mysqli_fetch_array($get_pending_dockets_result))
											{
												if($get_pending_docket_row['cut_report_status']=='OPEN'){
													$pending_dockets_list[] = $component_group_name.':'.$get_docket_row['docket_line_number'];
													$completed = 1;
												} 
												else if($get_pending_docket_row['cut_report_status']=='DONE'){
													$completed_dockets_list[] =$component_group_name.':'.$get_docket_row['docket_line_number'];
													$completed = 1;
												} 
											}
										}else {
											$open_dockets_list[] =$component_group_name.':'.$get_docket_row['docket_line_number'];
										}
									}
									
									$open_dockets = implode(",",$open_dockets_list);
									$pending_dockets = implode(",",$pending_dockets_list);
									$completed_dockets = implode(",",$completed_dockets_list);
									
									echo "<tr>";
									echo "<td>".$style."</td>";
									echo "<td>".$master_po_description."</td>";
									echo "<td>".$po_description."</td>";
									echo "<td style='word-break:break-all;'>".$schedules."</td>";
									echo "<td>".$color."</td>";
									echo "<td>".$cut_number."</td>";
									echo "<td>".$open_dockets."</td>";
									echo "<td>".$pending_dockets."</td>";
									echo "<td>".$completed_dockets."</td>";
									echo "</tr>";
								}

								Unset($ratio_id);
								unset($jm_cut_job_id);
								unset($cut_number);
								unset($po_number);
								unset($po_description);
								unset($master_po_number);
								unset($style);	
								unset($colors);	
								unset($schedule);	
								unset($component_group_id);	
								unset($component_group_name);	
								unset($open_dockets);	
								unset($pending_dockets);	
								unset($completed_dockets);	
								unset($pending_dockets_list);	
								unset($completed_dockets_list);	
								unset($open_dockets_list);	
							}
						}
					}
				}

			}
		}
		
	}
		echo "</table>
	</div>";	
	}
	else
	{
		echo "<h4 style='color:red'>No Data Found</h4>";
	}
}
?>


</div><!-- panel body -->
</div><!--  panel -->
</div>
