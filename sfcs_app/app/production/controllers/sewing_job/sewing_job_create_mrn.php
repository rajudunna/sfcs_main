<style>
#loading-image{
	position:fixed;
	top:0px;
	right:0px;
	width:100%;
	height:100%;
	background-color:#666;
	/* background-image:url('ajax-loader.gif'); */
	background-repeat:no-repeat;
	background-position:center;
	z-index:10000000;
	opacity: 0.4;
	filter: alpha(opacity=40); /* For IE8 and earlier */
}
</style>
<script language="javascript" type="text/javascript">
	
	var url1 = '<?= getFullURL($_GET['r'],'sewing_job_create_mrn.php','N'); ?>';

	function firstbox()
	{
		window.location.href =url1+"&style="+document.mini_order_report.style.value;
	}

	function secondbox()
	{
		window.location.href =url1+"&style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value;
		
	}
	function thirdbox()
	{
		window.location.href =url1+"&style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value+"&color="+document.mini_order_report.color.value;
	}

	function fourthbox()
	{
		window.location.href =url1+"&style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value+"&color="+document.mini_order_report.color.value+"&mpo="+document.mini_order_report.mpo.value;
	}

	function fifthbox()
	{
		window.location.href =url1+"&style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value+"&color="+document.mini_order_report.color.value+"&mpo="+document.mini_order_report.mpo.value+"&sub_po="+document.mini_order_report.sub_po.value;
	}

	function check_val()
	{
		//alert('dfsds');
		$("#loading-image").show();

		var style=document.getElementById("style").value;
		var schedule=document.getElementById("schedule").value;
		var color=document.getElementById("color").value;
		var mpo=document.getElementById("mpo").value;
		var sub_po=document.getElementById("sub_po").value;
		
		if(style == 'NIL' || schedule == 'NIL' || color == 'NIL' || mpo == 'NIL' || sub_po == 'NIL')
		{
			$("#loading-image").hide();
			sweetAlert('Please select the values','','warning');
			return false;
		}
		return true;	
	}
	

	$(document).ready(function(){
		$('#generate').on('click',function(event, redirect=true)
		{
			if(redirect != false){
				event.preventDefault();
				submit_form($(this));
			}
		});
	});
	
	
</script>


<?php
	include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions_v2.php',4,'R')); 
	include(getFullURLLevel($_GET['r'],'common/config/sms_api_calls.php',4,'R')); 
	include(getFullURLLevel($_GET['r'],'common/config/global_error_function.php',4,'R'));
	$plant_code = $_SESSION['plantCode'];
	$username =  $_SESSION['userName'];
	// $has_permission=haspermission($_GET['r']);
    $main_url=getFullURL($_GET['r'],'sewing_job_create_mrn.php','R');

	$get_style=$_GET['style'];
	$get_schedule=$_GET['schedule'];
	$get_color=$_GET['color']; 
	$get_mpo=$_GET['mpo']; 
	$get_sub_po=$_GET['sub_po']; 
	
	
?>
<div class="ajax-loader" id="loading-image" style="display: none">
    <center><img src='<?= getFullURLLevel($_GET['r'],'common/images/ajax-loader.gif',2,'R'); ?>' class="img-responsive" style="padding-top: 250px"/></center>
</div>
<div class="panel panel-primary">
	<div class="panel-heading"><b>MRN Integration</b></div>
	<div class="panel-body">
		<div class="col-md-12">
			<?php
			echo "<form name=\"mini_order_report\" action=\"?r=".$_GET["r"]."\" class=\"form-inline\" method=\"post\" >";
				?>
				Style:
				<?php
				    echo "<select name=\"style\" id=\"style\" class='form-control' onchange=\"firstbox();\" >";
					/*function to get style from getdata_mp_color_detail
					@params : $plantcode
					@returns: $style
					*/
					$result_mp_color_details=getMpColorDetail($plant_code);
		            $style=$result_mp_color_details['style'];
					echo "<option value=\"NIL\" selected>Select Style</option>";
					foreach ($style as $style_value) {
						if(str_replace(" ","",$style_value)==str_replace(" ","",$get_style)) 
						{ 
							echo '<option value=\''.$style_value.'\' selected>'.$style_value.'</option>'; 
						} 
						else 
						{ 
							echo '<option value=\''.$style_value.'\'>'.$style_value.'</option>'; 
						}
					}
					echo "</select>";
				?>

				&nbsp;Schedule:
				<?php
					// Schedule
					echo "<select class='form-control' name=\"schedule\" id=\"schedule\" onchange=\"secondbox();\" >";
					/*function to get schedule from getdata_bulk_schedules
					@params : plantcode,style
					@returns: schedule
					*/
					if($get_style!=''){
						$result_bulk_schedules=getBulkSchedules($get_style,$plant_code);
						$bulk_schedule=$result_bulk_schedules['bulk_schedule'];
					}
					echo "<option value=\"NIL\" selected>Select Schedule</option>";
					foreach ($bulk_schedule as $bulk_schedule_value) {
						if(str_replace(" ","",$bulk_schedule_value)==str_replace(" ","",$get_schedule)) 
						{ 
							echo '<option value=\''.$bulk_schedule_value.'\' selected>'.$bulk_schedule_value.'</option>'; 
						} 
						else 
						{ 
							echo '<option value=\''.$bulk_schedule_value.'\'>'.$bulk_schedule_value.'</option>'; 
						}
					}
					echo "</select>";
				?>

				&nbsp;Color:
				<?php
					echo "<select class='form-control' name=\"color\" id=\"color\" onchange=\"thirdbox();\" >";
					/*function to get color from get_bulk_colors
					@params : plantcode,schedule
					@returns: color
					*/
					if($get_style!='' && $get_schedule!=''){
						$result_bulk_colors=getBulkColors($get_schedule,$plant_code);
						$bulk_color=$result_bulk_colors['color_bulk'];
					}
					echo "<option value=\"NIL\" selected>Select Color</option>";
					foreach ($bulk_color as $bulk_color_value) {
						if(str_replace(" ","",$bulk_color_value)==str_replace(" ","",$get_color)) 
						{ 
							echo '<option value=\''.$bulk_color_value.'\' selected>'.$bulk_color_value.'</option>'; 
						} 
						else 
						{ 
							echo '<option value=\''.$bulk_color_value.'\'>'.$bulk_color_value.'</option>'; 
						}
					}
					echo "</select>";
				?>

				&nbsp;Master PO:
				<?php
					echo "<select class='form-control' name=\"mpo\" id=\"mpo\" onchange=\"fourthbox();\" >";
					/*function to get mpo from getdata_MPOs
					@params : plantcode,schedule,color
					@returns: mpo
					*/
					if($get_schedule!='' && $get_color!=''){
						$result_bulk_MPO=getMpos($get_schedule,$get_color,$plant_code);
						$master_po_description=$result_bulk_MPO['master_po_description'];
					}
					echo "<option value=\"NIL\" selected>Select MPO</option>";
					foreach ($master_po_description as $key=>$master_po_description_val) {
						if(str_replace(" ","",$master_po_description_val)==str_replace(" ","",$get_mpo)) 
						{ 
							echo '<option value=\''.$master_po_description_val.'\' selected>'.$key.'</option>'; 
						} 
						else 
						{ 
							echo '<option value=\''.$master_po_description_val.'\'>'.$key.'</option>'; 
						}
					} 
					echo "</select>";
				?>

				&nbsp;Sub PO:
				<?php
					echo "<select class='form-control' name=\"sub_po\" id=\"sub_po\" onchange=\"fifthbox();\" >";
					/*function to get subpo from getdata_bulk_subPO
						@params : plantcode,mpo
						@returns: subpo
					*/
					if($get_mpo!='' && $plant_code!=''){
						$result_bulk_subPO=getBulkSubPo($get_mpo,$plant_code);
						$sub_po_description=$result_bulk_subPO['sub_po_description'];
					}
					echo "<option value=\"NIL\" selected>Select SubPO</option>";
					foreach ($sub_po_description as $key=>$sub_po_description_val) {
						if(str_replace(" ","",$sub_po_description_val)==str_replace(" ","",$get_sub_po)) 
						{ 
							echo '<option value=\''.$sub_po_description_val.'\' selected>'.$key.'</option>'; 
						} 
						else 
						{ 
							echo '<option value=\''.$sub_po_description_val.'\'>'.$key.'</option>'; 
						}
					}
					echo "</select>";
				?>
				&nbsp;&nbsp;
				<input type="submit" name="submit" id="submit" class="btn btn-success generate_btn" onclick="return check_val();" value="Submit">
			</form>
		</div>

		<div class="col-md-12">
			<?php
				if(isset($_POST['submit']))
				{	
					$style=$_GET['style'];
					$schedule=$_GET['schedule'];
					$color=$_GET['color']; 
					$mpo=$_GET['mpo']; 
					$sub_po=$_GET['sub_po']; 
					//get operations_version_id
					$get_operations_version_id="SELECT operations_version_id FROM $pps.mp_color_detail WHERE style='$style' AND color='$color' AND master_po_number='$mpo' AND plant_code='$plant_code'";
					$version_id_result=mysqli_query($link_new, $get_operations_version_id) or exit("Sql Error at get_operations_version_id".mysqli_error($GLOBALS["___mysqli_ston"]));
					log_statement('debug',$get_operations_version_id,$main_url,__LINE__);
					log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
					while($row14=mysqli_fetch_array($version_id_result))
					{
                      $operations_version_id = $row14['operations_version_id'];
					}
					$op_code1=1;
					$result_mrn_operation=getJobOpertions($style,$color,$plant_code,$operations_version_id);
					$operation_codes=$result_mrn_operation;
					foreach($operation_codes as $key){
						
						if($op_code1  == $key['operationCode'])
						{
                          $status = "True";
						}
					}	
					
					if ($style =='NIL' or $schedule =='NIL') 
					{						
						echo " ";
					}
					else
					{
						//check jobs are avaialabe or not
						$check_jobs="SELECT jm_job_header_id,job_header_type FROM $pps.jm_job_header WHERE po_number='$sub_po' AND ref_type='SEWING' AND plant_code='$plant_code'";
						$check_jobs_result=mysqli_query($link_new, $check_jobs) or exit("Sql Error at check_jobs".mysqli_error($GLOBALS["___mysqli_ston"]));
						log_statement('debug',$check_jobs,$main_url,__LINE__);
					    log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
						while($row1=mysqli_fetch_array($check_jobs_result))
						{
							$job_header_id=$row1['jm_job_header_id'];
							$job_header_type=$row1['job_header_type'];
						}
						//get jobs from jm_jg_header
						$job_number=array();
						$get_input_jobs="SELECT job_number,jm_jg_header_id,mrn_status FROM $pps.jm_jg_header WHERE jm_job_header='$job_header_id' AND plant_code='$plant_code'";
						$get_input_jobs_result=mysqli_query($link_new, $get_input_jobs) or exit("Sql Error at get_input_jobs".mysqli_error($GLOBALS["___mysqli_ston"]));
						log_statement('debug',$get_input_jobs,$main_url,__LINE__);
					    log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
						while($row2=mysqli_fetch_array($get_input_jobs_result))
						{
							$job_number[$get_input_jobs_result['jm_jg_header_id']]=$get_input_jobs_result['job_number'];
							$mrn_status[$get_input_jobs_result['jm_jg_header_id']]=$get_input_jobs_result['mrn_status'];
						}
						//get bgcolor fron prefix
						$get_prefix_color="SELECT bg_color FROM $mdm.tbl_sewing_job_prefix WHERE prefix_name='$job_header_type' AND plant_code='$plant_code'";
						$sql_result88=mysqli_query($link_new, $get_prefix_color) or exit("Sql Error44b $get_prefix_color".mysqli_error($GLOBALS["___mysqli_ston"]));
						log_statement('debug',$get_prefix_color,$main_url,__LINE__);
					    log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
						while($row3=mysqli_fetch_array($sql_result88))
						{
							$bg_color=$row3["bg_color"];
						}
						if(mysqli_num_rows($check_jobs_result) > 0)
						{
							
							echo '<br>
								<div class="panel panel-primary panel-body">
								<div class="col-md-12 ">';       
							echo '</div>';
							echo '<form name="new" method="post" action="?r='.$_GET['r'].'">';
							echo "<div class='col-12 col-sm-12 col-lg-12 table-responsive'>
							<table class='table table-bordered'>";
							echo "<tr class='info'>";
							echo "<th>Sewing Job No</th>";
							echo "<th>Schedule</th>";
							echo "<th>Color Set</th>";
							echo "<th>Cut Job#</th>";
							echo "<th>Size Set</th>";
							echo "<th>Total Sewing Job Quantity</th>";
							echo "<th colspan=2><center>Action</center></th>";
							echo "</tr>";
							
							foreach($job_number as $key=>$value)
                            {
                                //to get qty from jm job lines
								$toget_qty_qry="SELECT sum(quantity) as qty,GROUP_CONCAT(DISTINCT size ORDER BY m3_size_code) AS size,fg_color from $pps.jm_job_bundles where jm_jg_header_id ='$key' and plant_code='$plant_code'";
								$toget_qty_qry_result=mysqli_query($link_new, $toget_qty_qry) or exit("Sql Error at toget_style_sch".mysqli_error($GLOBALS["___mysqli_ston"]));
								log_statement('debug',$toget_qty_qry,$main_url,__LINE__);
					            log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
								$toget_qty=mysqli_num_rows($toget_qty_qry_result);
								if($toget_qty>0){
									while($toget_qty_det=mysqli_fetch_array($toget_qty_qry_result))
									{
									   $sew_qty = $toget_qty_det['qty'];
									   $size = $toget_qty_det['size'];
									   $color = $toget_qty_det['fg_color'];
									}
								}
								$input_job_no=$job_number[$value];
								$jm_jg_header_id=$key;
								$cut_number=0;
								echo "<tr style='background-color:$bg_color;'>";
								echo "<td>".$input_job_no."</td>";
								echo "<td>".$schedule."</td>";
								echo "<td>".$color."</td>";
								echo "<td>".$cut_number."</td>";
								echo "<td>".strtoupper($size)."</td>";
								echo "<td>".$sew_qty."</td>";
								$mrn_status=$mrn_status[$value];
								if($mrn_status>0)
								{							
									echo "<td><center>Confirmed</center></td>";
									
									echo "<td><center><a class='btn btn-info btn-xs' href=\"".getFullURL($_GET['r'], "sewing_job_create_mrn.php", "N")."&inputjobno=".$input_job_no."&jm_jg_header_id=".$jm_jg_header_id."&style=".$style."&schedule=".$schedule."&color=".$color."&mpo=".$mpo."&sub_po=".$sub_po."&var1=1\" onclick=\"clickAndDisable(this);\" name=\"return\">Return</a></center></td>";
									
									echo"</tr>";																			
								}
								else
								{
									//Checking if MRN operation is there or not
									if($status == "True")
									{
                                     	//check wheter sewing job planned or not
										$qry_get_module="SELECT * FROM $tms.task_header LEFT JOIN $tms.task_jobs ON task_header.task_header_id=task_jobs.task_header_id WHERE task_job_reference='$key'";
										$get_module_result=mysqli_query($link_new, $qry_get_module) or exit("Sql Error at qry_get_module".mysqli_error($GLOBALS["___mysqli_ston"]));
										log_statement('debug',$qry_get_module,$main_url,__LINE__);
					                    log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
										$sql_num_check_count_new=mysqli_num_rows($get_module_result);
											
										if($sql_num_check_count_new>0){
										echo "<td ><center><a class='btn btn-info btn-xs' href=\"".getFullURL($_GET['r'], "sewing_job_create_mrn.php", "N")."&style=".$style."&schedule=".$schedule."&inputjobno=".$input_job_no."&jm_jg_header_id=".$jm_jg_header_id."&color=".$color."&mpo=".$mpo."&sub_po=".$sub_po."&var1=2\" onclick=\"clickAndDisable(this);\">Confirm</a></center></td>";
										echo "<td></td>";
										}else{
											echo"<td><center>Plan Not Done</center></td>";
											echo "<td></td>";	
										}
											echo"</tr>"; 
									}
									else
									{
										echo"<td><center>NO MRN Operation</center></td>";
										echo "<td></td>";

									}
								}
							}	
							echo"</table>";
							echo"</form>";
							echo"</div>";
							echo"</div>";
							echo"</div>";
						}
						else
						{
							echo "<script type=\"text/javascript\">;
							sweetAlert('Sewing Jobs not Generated.','','warning')
							</script>";
						}
						if($_GET['var1']==1)
						{
							$schedule=$_GET['schedule'];
							$style=$_GET['style'];
							$color=$_GET['color'];
							$inputjobno=$_GET['inputjobno'];
							$jmjgheaderid=$_GET['jm_jg_header_id'];
							$mpo=$_GET['mpo'];
							$sub_po=$_GET['sub_po'];
							$op_code1=1;
							
							//added m3 db in query
							$conn = odbc_connect("$ms_sql_driver_name;Server=$ms_sql_odbc_server;Database=$mssql_db;", $ms_sql_odbc_user,$ms_sql_odbc_pass);
							//To check MRN status
							$check_mrn="SELECT * FROM $pps.jm_jg_header WHERE jm_jg_header_id='$jmjgheaderid' AND mrn_status ='1' AND plant_code='$plant_code'";
							$check_mrn_result=mysqli_query($link_new, $check_mrn) or exit("check_mrn".mysqli_error($GLOBALS["___mysqli_ston"]));
							log_statement('debug',$check_mrn,$main_url,__LINE__);
					        log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
							$sql_num_check1=mysqli_num_rows($check_mrn_result);
							if($sql_num_check1 > 0)
							{
                               //To get resource id
								$qry_get_module="SELECT resource_id FROM $tms.task_header LEFT JOIN $tms.task_jobs ON task_header.task_header_id=task_jobs.task_header_id WHERE task_job_reference='$jmjgheaderid' AND task_header.plant_code='$plant_code'";
								$get_module_result=mysqli_query($link_new, $qry_get_module) or exit("Sql Error at qry_get_module".mysqli_error($GLOBALS["___mysqli_ston"]));
								log_statement('debug',$qry_get_module,$main_url,__LINE__);
					            log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
								while($get_module_row=mysqli_fetch_array($get_module_result))
								{
									$module = $get_module_row['resource_id'];
								}
								//to get qty from jm job lines
								$toget_qty_qry="SELECT sum(quantity) as qty from $pps.jm_job_bundles where jm_jg_header_id ='$key' AND plant_code='$plant_code'";
								$toget_qty_qry_result=mysqli_query($link_new, $toget_qty_qry) or exit("Sql Error at toget_style_sch".mysqli_error($GLOBALS["___mysqli_ston"]));
								log_statement('debug',$toget_qty_qry,$main_url,__LINE__);
					            log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
								$toget_qty=mysqli_num_rows($toget_qty_qry_result);
								while($toget_qty_det=mysqli_fetch_array($toget_qty_qry_result))
								{
									$sew_qty = $toget_qty_det['qty'];
								}
								$date=date('Ymd');
								$employee_no=$schedule."-".$inputjobno;
								$remarks="Team"."-".$module."::".$date;
								if(strlen($employee_no) > 10)
								{
									$employee_no = substr($employee_no,-10);
								}
								//To get mo_number
								$get_mo_number="SELECT mo_number FROM $pps.jm_job_bundle_mo_qty LEFT JOIN $pps.jm_job_bundles ON jm_job_bundle_mo_qty.jm_job_bundle_id = jm_job_bundles.jm_job_bundle_id WHERE jm_jg_header_id='$jmjgheaderid' AND jm_job_bundle_mo_qty.plant_code='$plant_code'";
								$mo_number_result=mysqli_query($link_new, $get_mo_number) or exit("Sql Error at get_mo_number".mysqli_error($GLOBALS["___mysqli_ston"]));
								log_statement('debug',$get_mo_number,$main_url,__LINE__);
					            log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
								while($row4=mysqli_fetch_array($mo_number_result))
								{
                                  $mo_number=$row4['mo_number'];
								}
								//To get customer_order_no
								$get_co="SELECT customer_order_no $oms.oms_mo_details WHERE mo_number='$mo_number' AND plant_code='$plant_code'";
								$co_result=mysqli_query($link_new, $get_co) or exit("Sql Error at get_co".mysqli_error($GLOBALS["___mysqli_ston"]));
								log_statement('debug',$get_co,$main_url,__LINE__);
					            log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
								while($row5=mysqli_fetch_array($co_result))
								{
                                  $co_no=$row5['customer_order_no'];
								}	
								$mssql_insert_query="insert into [$mssql_db].[dbo].[M3_MRN_Link] (Company,Facility,MONo,OperationNo, ManufacturedQty,EmployeeNo,Remark,CONO,Schedule,Status,DSP1,DSP2,DSP3,DSP4) values";
								$values = array();
								array_push($values, "('" . $company_no . "','" . $facility_code . "','" . $mo_number . "','" . $op_code1 . "','" . $sew_qty . "','".$employee_no."','".$remarks."','".$co_no."','".$schedule."',NULL,'1','1','1','1')");
								$mssql_insert_query_result=odbc_exec($conn, $mssql_insert_query . implode(', ', $values));
								$odbc_num_check=odbc_num_rows($mssql_insert_query_result);
								if($odbc_num_check>0)
								{
									$pass_update1="UPDATE $pps.jm_jg_header SET mrn_status='0' WHERE job_number='$inputjobno' AND jm_jg_header_id='$jmjgheaderid' AND plant_code='$plant_code'";
									$pass_update1_result=mysqli_query($link, $pass_update1) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
									log_statement('debug',$pass_update1,$main_url,__LINE__);
					                log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
									echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
									$('#loading-image').hide();
									function Redirect() {
									sweetAlert('MRN Reversal successfully Completed','','success');
									location.href = \"".getFullURLLevel($_GET['r'], "sewing_job_create_mrn.php", "0", "N")."&style=$style&schedule=$schedule&color=$color&mpo=$mpo&sub_po=$sub_po\";
									}
									</script>";
								}
								else
								{
									echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
									$('#loading-image').hide();
									function Redirect() {
									sweetAlert('Reversal Failed','','success');
									location.href = \"".getFullURLLevel($_GET['r'], "sewing_job_create_mrn.php", "0", "N")."&style=$style&schedule=$schedule&color=$color&mpo=$mpo&sub_po=$sub_po\";

									}
									</script>";
								}
							}
							else
							{
                                echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
								$('#loading-image').hide();
								function Redirect() {
								sweetAlert('MRN Reversal Already Done','','warning');
								location.href = \"".getFullURLLevel($_GET['r'], "sewing_job_create_mrn.php", "0", "N")."&style=$style&schedule=$schedule&color=$color&mpo=$mpo&sub_po=$sub_po\";

								}
								</script>";
							}
						}
						elseif($_GET['var1']==2)
						{
							$schedule=$_GET['schedule'];
							$style=$_GET['style'];
							$color=$_GET['color'];
							$inputjobno=$_GET['inputjobno'];
							$jmjgheaderid=$_GET['jm_jg_header_id'];
							$mpo=$_GET['mpo'];
							$sub_po=$_GET['sub_po'];

							$conn = odbc_connect("$ms_sql_driver_name;Server=$ms_sql_odbc_server;Database=$mssql_db;", $ms_sql_odbc_user,$ms_sql_odbc_pass);
							if($promis_val==1)
							{
								$conn2 = odbc_connect("$promis_sql_driver_name;Server=$promis_sql_odbc_server;Database=$promis_db;", $promis_sql_odbc_user,$promis_sql_odbc_pass);
								$get_module_desc = "select * from $pps.promis_module_mapping WHERE plant_code='$plant_code'";
								$result_module = $link->query($get_module_desc);
								log_statement('debug',$get_module_desc,$main_url,__LINE__);
					            log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
								while($row_mod = $result_module->fetch_assoc())
								{
									$prom_div_name[$row_mod['sfcs_module_name']] = $row_mod['promis_division_name'];
								}
							}

                           //To check MRN status
							$check_mrn="SELECT * FROM $pps.jm_jg_header WHERE jm_jg_header_id='$jmjgheaderid' AND (mrn_status IS NULL OR mrn_status='0') AND plant_code='$plant_code'";
							$check_mrn_result=mysqli_query($link_new, $check_mrn) or exit("check_mrn".mysqli_error($GLOBALS["___mysqli_ston"]));
							log_statement('debug',$check_mrn,$main_url,__LINE__);
					        log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
							$sql_num_check1=mysqli_num_rows($check_mrn_result);
							if($sql_num_check1 > 0)
							{
							    //To get resource id
								$qry_get_module="SELECT resource_id,planned_date_time FROM $tms.task_header LEFT JOIN $tms.task_jobs ON task_header.task_header_id=task_jobs.task_header_id WHERE task_job_reference='$jmjgheaderid' AND task_header.plant_code='$plant_code'";
								$get_module_result=mysqli_query($link_new, $qry_get_module) or exit("Sql Error at qry_get_module".mysqli_error($GLOBALS["___mysqli_ston"]));
								log_statement('debug',$qry_get_module,$main_url,__LINE__);
					            log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
								while($get_module_row=mysqli_fetch_array($get_module_result))
								{
									$module = $get_module_row['resource_id'];
									$log_time = $get_module_row['planned_date_time'];
								}
								//to get qty from jm job lines
								$toget_qty_qry="SELECT sum(quantity) as qty from $pps.jm_job_bundles where jm_jg_header_id ='$key' AND plant_code='$plant_code'";
								$toget_qty_qry_result=mysqli_query($link_new, $toget_qty_qry) or exit("Sql Error at toget_style_sch".mysqli_error($GLOBALS["___mysqli_ston"]));
								log_statement('debug',$toget_qty_qry,$main_url,__LINE__);
					            log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
								$toget_qty=mysqli_num_rows($toget_qty_qry_result);
								while($toget_qty_det=mysqli_fetch_array($toget_qty_qry_result))
								{
									$sew_qty = $toget_qty_det['qty'];
								}
								$date=date('Ymd');
								$employee_no=$schedule."-".$inputjobno;
								$remarks="Team"."-".$module."::".$date;
								if(strlen($employee_no) > 10)
								{
									$employee_no = substr($employee_no,-10);
								}
								//To get mo_number
								$get_mo_number="SELECT mo_number FROM $pps.jm_job_bundle_mo_qty LEFT JOIN $pps.jm_job_bundles ON jm_job_bundle_mo_qty.jm_job_bundle_id = jm_job_bundles.jm_job_bundle_id WHERE jm_jg_header_id='$jmjgheaderid' AND jm_job_bundle_mo_qty.plant_code='$plant_code'";
								$mo_number_result=mysqli_query($link_new, $get_mo_number) or exit("Sql Error at get_mo_number".mysqli_error($GLOBALS["___mysqli_ston"]));
								log_statement('debug',$get_mo_number,$main_url,__LINE__);
					            log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
								while($row4=mysqli_fetch_array($mo_number_result))
								{
                                  $mo_number=$row4['mo_number'];
								}
								//To get customer_order_no
								$get_co="SELECT customer_order_no $oms.oms_mo_details WHERE mo_number='$mo_number' AND plant_code='$plant_code'";
								$co_result=mysqli_query($link_new, $get_co) or exit("Sql Error at get_co".mysqli_error($GLOBALS["___mysqli_ston"]));
								log_statement('debug',$get_co,$main_url,__LINE__);
					            log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
								while($row5=mysqli_fetch_array($co_result))
								{
                                  $co_no=$row5['customer_order_no'];
								}
								if($promis_val==1)
						        {
									$insert_qry="INSERT INTO [$promis_db].[dbo].[ProMIS_SX_SJ_Master](MRNNo, CO_ID, Schedule_ID, Colour_Code, Size_Code, Country_ID, Colour_Description,    Size_Description, Quantity, Prod_Line, Plan_Date, Manual_Flag, Freez_Flag, Sew_Line, Plan_Date2, Error_Flag) values('".$inputjobno."','".$co_no."','".$schedule."','".$color_code."','".$sizecode."', '1' ,'".$color."','".$size."','".$sew_qty."','".$prom_div_name[$input_module]."','". $log_time ."','".$sewing_type."','1',NULL,NULL,'0')"; 
									$query_result=odbc_exec($conn2, $insert_qry);
								}
								$mssql_insert_query="insert into [$mssql_db].[dbo].[M3_MRN_Link] (Company,Facility,MONo,OperationNo, ManufacturedQty,EmployeeNo,Remark,CONO,Schedule,Status,DSP1,DSP2,DSP3,DSP4) values";
								$values = array();
								array_push($values, "('" . $company_no . "','" . $facility_code . "','" . $mo_number . "','" . $op_code1 . "','" . $sew_qty . "','".$employee_no."','".$remarks."','".$co_no."','".$schedule."',NULL,'1','1','1','1')");
								$mssql_insert_query_result=odbc_exec($conn, $mssql_insert_query . implode(', ', $values));
								$odbc_num_check=odbc_num_rows($mssql_insert_query_result);
								if($odbc_num_check>0)
								{
									$pass_update1="UPDATE $pps.jm_jg_header SET mrn_status='0' WHERE job_number='$inputjobno' AND jm_jg_header_id='$jmjgheaderid' AND plant_code='$plant_code'";
									$pass_update1_result=mysqli_query($link, $pass_update1) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
									log_statement('debug',$pass_update1,$main_url,__LINE__);
					                log_statement('error',mysqli_error($GLOBALS["___mysqli_ston"]),$main_url,__LINE__);
									echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
									$('#loading-image').hide();
									function Redirect() {
									sweetAlert('MRN Confirmed Successfully','','success');
									location.href = \"".getFullURLLevel($_GET['r'], "sewing_job_create_mrn.php", "0", "N")."&style=$style&schedule=$schedule&color=$color&mpo=$mpo&sub_po=$sub_po\";
									}
									</script>";
								}
								else
								{
									echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
									$('#loading-image').hide();
									function Redirect() {
									sweetAlert('MRN Confirmed Failed','','success');
									location.href = \"".getFullURLLevel($_GET['r'], "sewing_job_create_mrn.php", "0", "N")."&style=$style&schedule=$schedule&color=$color&mpo=$mpo&sub_po=$sub_po\";

									}
									</script>";
								}

							}
							else
							{
								echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
								$('#loading-image').hide();
								function Redirect() {
								sweetAlert('MRN Already Confirmed','','warning');
								location.href = \"".getFullURLLevel($_GET['r'], "sewing_job_create_mrn.php", "0", "N")."&style=$style&schedule=$schedule&color=$color&mpo=$mpo&sub_po=$sub_po\";

								}
								</script>";
							}
						}

					}	
					
				}
			?> 
		</div>
	</div>
</div>

<script> 
   function clickAndDisable(link) {
	$("#loading-image").show();
     // disable subsequent clicks
     link.onclick = function(event) {
        event.preventDefault();
     }
   }   
</script>