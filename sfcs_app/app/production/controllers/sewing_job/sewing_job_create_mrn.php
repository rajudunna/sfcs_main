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
		//alert("report");
		window.location.href =url1+"&style="+document.mini_order_report.style.value
	}

	function check_val()
	{
		//alert('dfsds');
		$("#loading-image").show();

		var style=document.getElementById("style").value;
		var schedule=document.getElementById("schedule").value;
		
		if(style == 'NIL' || schedule == 'NIL')
		{
			$("#loading-image").hide();
			sweetAlert('Please select the values','','warning');
			// document.getElementById('submit').style.display=''
			// document.getElementById('msg').style.display='none';
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
	$has_permission=haspermission($_GET['r']);
	if(isset($_POST['style']))
	{
	    $style=$_POST['style'];
	    $schedule=$_POST['schedule'];
	}
	else
	{
		$style=$_GET['style'];
		$schedule=$_GET['schedule'];
	}
	
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
					// Style
					echo "<select name=\"style\" id=\"style\" class='form-control' onchange=\"firstbox();\" >";
					$sql="select * from $brandix_bts.tbl_orders_style_ref order by product_style";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check=mysqli_num_rows($sql_result);
					echo "<option value=\"NIL\" selected>Select Style</option>";
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$style))
						{
							echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['product_style']."</option>";
						}
						else
						{
							echo "<option value=\"".$sql_row['id']."\">".$sql_row['product_style']."</option>";
						}
					}
					echo "</select>";
				?>

				&nbsp;Schedule:
				<?php
					// Schedule
					echo "<select class='form-control' name=\"schedule\" id=\"schedule\"  >";
					$sql="select * from $brandix_bts.tbl_orders_master where ref_product_style='".$style."'";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check=mysqli_num_rows($sql_result);
					echo "<option value=\"NIL\" selected>Select Schedule</option>";
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$schedule))
						{
							echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['product_schedule']."</option>";
						}
						else
						{
							echo "<option value=\"".$sql_row['id']."\">".$sql_row['product_schedule']."</option>";
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
				if(isset($_POST['submit']) or ($_GET['style'] and $_GET['schedule']))
				{	
					if ($_GET['style'] and $_GET['schedule'])
					{
						$style_id=$_GET['style'];
						$sch_id=$_GET['schedule'];
					} 
					else if ($_POST['style'] and $_POST['schedule'])
					{
						$style_id=$_POST['style'];
						$sch_id=$_POST['schedule'];	
					}

					$op_code1=1;
					if ($style_id =='NIL' or $sch_id =='NIL') 
					{						
						echo " ";
					}
					else
					{
						$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link);
						$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$sch_id,$link);
						$packing_summary_input_check = echo_title("$bai_pro3.packing_summary_input","count(*)","order_del_no",$schedule,$link);
						if($packing_summary_input_check > 0)
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
							$sql="SELECT type_of_sewing,input_job_no_random,input_job_no,GROUP_CONCAT(DISTINCT doc_no_ref ORDER BY doc_no) AS doc_no_ref,GROUP_CONCAT(DISTINCT m3_size_code order by m3_size_code) AS size_code,group_concat(distinct order_col_des order by order_col_des) as order_col_des,doc_no,GROUP_CONCAT(DISTINCT CONCAT(order_col_des,'$',acutno) ORDER BY doc_no SEPARATOR ',') AS acutno,SUM(carton_act_qty) AS carton_act_qty ,sum(mrn_status) as mrn_status FROM $bai_pro3.packing_summary_input WHERE order_del_no='$schedule' GROUP BY input_job_no_random ORDER BY acutno*1, input_job_no*1";
							// echo $sql."<br>";
							$temp=0;
							$job_no=0;
							$color="";
							$sql_result=mysqli_query($link, $sql) or exit("Sql Error90 = $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row=mysqli_fetch_array($sql_result))
							{

								$sql88="select type_of_sewing,prefix,bg_color from $brandix_bts.tbl_sewing_job_prefix where type_of_sewing=".$sql_row['type_of_sewing']."";
								$sql_result88=mysqli_query($link, $sql88) or exit("Sql Error44b $sql4".mysqli_error($GLOBALS["___mysqli_ston"]));
									while($sql_row88=mysqli_fetch_array($sql_result88))
									{
										$bg_color=$sql_row88["bg_color"];
										$prefix=$sql_row88["prefix"];
									}

								$total_cuts=explode(",",$sql_row['acutno']);
								$cut_jobs_new='';
								for($ii=0;$ii<sizeof($total_cuts);$ii++)
								{
									$arr = explode("$", $total_cuts[$ii], 2);;
									$sql4="select color_code from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$schedule."\" and order_col_des='".$arr[0]."'";
									$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error44b $sql4".mysqli_error($GLOBALS["___mysqli_ston"]));
									while($sql_row4=mysqli_fetch_array($sql_result4))
									{
										$color_code=$sql_row4["color_code"];
									}
									$cut_jobs_new .= chr($color_code).leading_zeros($arr[1], 3)."<br>";
									unset($arr);
								}
								echo "<tr style='background-color:$bg_color;'>";
								echo "<td>$prefix"."00".$sql_row['input_job_no']."</td>";
								echo "<td>".$schedule."</td>";
								echo "<td>".$sql_row['order_col_des']."</td>";
								echo "<td>".$cut_jobs_new."</td>";
								echo "<td>".strtoupper($sql_row['size_code'])."</td>";
								echo "<td>".$sql_row['carton_act_qty']."</td>";
								$mrn_status=$sql_row['mrn_status']; 
								if($mrn_status>0)
								{							
									echo "<td><center>Confirmed</center></td>";
									if(in_array($authorized,$has_permission))
									{ 
										echo "<td><center><a class='btn btn-info btn-xs' href=\"".getFullURL($_GET['r'], "sewing_job_create_mrn.php", "N")."&inputjobno=".$sql_row['input_job_no_random']."&style=$style&schedule=".$schedule."&var1=1\" onclick=\"clickAndDisable(this);\" name=\"return\">Return</a></center></td>";
									}
									else{
										echo "<td></td>";
									}
									echo"</tr>";																			
								}
								else
								{
									
									$sql57="SELECT tid FROM $bai_pro3.pac_stat_log_input_job WHERE input_job_no_random='".$sql_row['input_job_no_random']."'";
									$sql_result02=mysqli_query($link, $sql57) or exit("Sql Error01".mysqli_error($GLOBALS["___mysqli_ston"]));
									while($sql_row02=mysqli_fetch_array($sql_result02))
									{				
										$tid1[]=$sql_row02['tid'];
									}
									$op_code=1;
									$tid2=implode(",",$tid1);
									$mo_operation_quantites_query1="SELECT mo_no,sum(bundle_quantity) as bundle_quantity,op_code,op_desc,ref_no FROM $bai_pro3.mo_operation_quantites WHERE ref_no in ($tid2) and op_code='$op_code' group by mo_no";
									$sql_result50=mysqli_query($link, $mo_operation_quantites_query1) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
									$mo_operation_count=mysqli_num_rows($sql_result50);
									if($mo_operation_count>0){
										$sql98="SELECT input_job_rand_no_ref FROM $bai_pro3.ims_log_backup WHERE input_job_rand_no_ref='".$sql_row['input_job_no_random']."'";
										$sql_result011=mysqli_query($link, $sql98) or exit("Sql Error01".mysqli_error($GLOBALS["___mysqli_ston"]));
										$ims_log_backup_count=mysqli_num_rows($sql_result011);
										$sql66="SELECT input_job_no_random_ref FROM $bai_pro3.plan_dashboard_input WHERE input_job_no_random_ref='".$sql_row['input_job_no_random']."'";
										$sql_result012=mysqli_query($link, $sql66) or exit("Sql Error01".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql_num_check_count=mysqli_num_rows($sql_result012);
									
										if($sql_num_check_count>0 or $ims_log_backup_count>0){
										echo "<td ><center><a class='btn btn-info btn-xs' href=\"".getFullURL($_GET['r'], "sewing_job_create_mrn.php", "N")."&style=$style&schedule=".$schedule."&inputjobno=".$sql_row['input_job_no_random']."&var1=2\" onclick=\"clickAndDisable(this);\">Confirm</a></center></td>";
										echo "<td></td>";
										}else{
											echo"<td><center>Plan Not Done</center></td>";
											echo "<td></td>";	
										}
									     echo"</tr>"; 
									 }
									 else{
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
					//added m3 db in query
					$conn = odbc_connect("$ms_sql_driver_name;Server=$ms_sql_odbc_server;Database=$mssql_db;", $ms_sql_odbc_user,$ms_sql_odbc_pass);
					$schedule=$_GET['schedule'];
					$style=$_GET['style'];
					$inputjobno=$_GET['inputjobno'];
					$op_code=1;
					$sql14="SELECT co_no FROM $bai_pro3.bai_orders_db_confirm WHERE order_del_no='$schedule' and order_style_no='$style'";					
					$sql_result14=mysqli_query($link, $sql14) or exit("Sql Error71".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row14=mysqli_fetch_array($sql_result14))
					{
						$co_no=$sql_row14['co_no'];
					}
					$sql76="SELECT input_module  FROM $bai_pro3.plan_dashboard_input WHERE  input_job_no_random_ref='$inputjobno'";
					$sql_result76=mysqli_query($link, $sql76) or exit("Sql Error01".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row76=mysqli_fetch_array($sql_result76))
					{
						$input_module=$sql_row76['input_module'];
					}
					$sql55="SELECT tid,input_job_no,order_del_no  FROM $bai_pro3.packing_summary_input WHERE input_job_no_random='$inputjobno'";
					$sql_result01=mysqli_query($link, $sql55) or exit("Sql Error01".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check1=mysqli_num_rows($sql_result01);
					// $tid=array();
					if($sql_num_check1>0)
					{
						while($sql_row01=mysqli_fetch_array($sql_result01))
						{

							$tid[]=$sql_row01['tid'];
							$input_job_no=$sql_row01['input_job_no'];
							$order_del_no=$sql_row01['order_del_no'];
							$date=date('Ymd');
							$employee_no=$order_del_no."-".$input_job_no;
							$remarks="Team"."-".$input_module."::".$date;
						}
						if(strlen($employee_no) > 10)
						{
							$employee_no = substr($employee_no,-10);
						}
						$tid1=implode(",",$tid);
						$mo_operation_quantites_query="SELECT mo_no,sum(bundle_quantity) as bundle_quantity,op_code,op_desc,ref_no FROM $bai_pro3.mo_operation_quantites WHERE ref_no in ($tid1) and op_code='$op_code' group by mo_no";
						$mssql_insert_query="insert into [$mssql_db].[dbo].[M3_MRN_Link] (Company,Facility,MONo,OperationNo, ManufacturedQty,EmployeeNo,Remark,CONO,Schedule,Status,DSP1,DSP2,DSP3,DSP4) values";
						$values = array();
						$ref_no = array();
						$sql_result5=mysqli_query($link, $mo_operation_quantites_query) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row5=mysqli_fetch_array($sql_result5))
						{
							$id=$sql_row5['id'];
							$mo_no=$sql_row5['mo_no'];
							$bundle_quantity=$sql_row5['bundle_quantity']*-1;
							$op_code=$sql_row5['op_code'];
							$op_desc=$sql_row5['op_desc'];
							$ref_no[]=$sql_row5['ref_no'];
							array_push($values, "('" . $company_no . "','" . $facility_code . "','" . $mo_no . "','" . $op_code . "','" . $bundle_quantity . "','".$employee_no."','".$remarks."','".$co_no."','".$order_del_no."',NULL,'1','1','1','1')"); 
						}
						$ref_no1=implode(",",$ref_no);
						$mssql_insert_query_result=odbc_exec($conn, $mssql_insert_query . implode(', ', $values));
						$sql_num_check5=odbc_num_rows($mssql_insert_query_result);
						$sql="select * from $brandix_bts.tbl_orders_style_ref where product_style='$style'";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row10=mysqli_fetch_array($sql_result))
						{
							$id=$sql_row10['id'];
						}
						$sql8="select * from $brandix_bts.tbl_orders_master where product_schedule='$schedule'";
						$sql_result8=mysqli_query($link, $sql8) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row11=mysqli_fetch_array($sql_result8))
						{
							$schedule_id=$sql_row11['id'];
						}
						if($sql_num_check5>0)
						{
							$pass_update1="update $bai_pro3.pac_stat_log_input_job set mrn_status='0' where input_job_no_random='$inputjobno'";
							$pass_update1_result=mysqli_query($link, $pass_update1) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
							echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
							$('#loading-image').hide();
							function Redirect() {
							sweetAlert('MRN Reversal successfully Completed','','success');
							location.href = \"".getFullURLLevel($_GET['r'], "sewing_job_create_mrn.php", "0", "N")."&style=$id&schedule=$schedule_id\";
							}
							</script>";
						}
						else
						{
							echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
							$('#loading-image').hide();
							function Redirect() {
							sweetAlert('Reversal Failed','','success');
							location.href = \"".getFullURLLevel($_GET['r'], "sewing_job_create_mrn.php", "0", "N")."&style=$id&schedule=$schedule_id\";

							}
							</script>";
						}
					}
				}
				elseif($_GET['var1']==2)
				{	
					$conn = odbc_connect("$ms_sql_driver_name;Server=$ms_sql_odbc_server;Database=$mssql_db;", $ms_sql_odbc_user,$ms_sql_odbc_pass);
					$schedule=$_GET['schedule'];
					$style=$_GET['style'];
					$inputjobno=$_GET['inputjobno'];
					$op_code=1;
					$sql14="SELECT co_no FROM $bai_pro3.bai_orders_db_confirm WHERE order_del_no='$schedule' and order_style_no='$style'";					
					$sql_result14=mysqli_query($link, $sql14) or exit("Sql Error71".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row14=mysqli_fetch_array($sql_result14))
					{
						$co_no=$sql_row14['co_no'];
					}
					$sql76="SELECT input_module  FROM $bai_pro3.plan_dashboard_input WHERE  input_job_no_random_ref='$inputjobno'";
					$sql_result76=mysqli_query($link, $sql76) or exit("Sql Error01".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row76=mysqli_fetch_array($sql_result76))
					{
						$input_module=$sql_row76['input_module'];
					}
					$sql55="SELECT tid,input_job_no,order_del_no  FROM $bai_pro3.packing_summary_input WHERE  input_job_no_random='$inputjobno'";
					$sql_result01=mysqli_query($link, $sql55) or exit("Sql Error01".mysqli_error($GLOBALS["___mysqli_ston"]));
					// $tid=array();
					$sql_num_check1=mysqli_num_rows($sql_result01);
					// $tid=array();
					if($sql_num_check1>0)
					{
						while($sql_row01=mysqli_fetch_array($sql_result01))
						{
							$tid[]=$sql_row01['tid'];
							$input_job_no=$sql_row01['input_job_no'];
							$order_del_no=$sql_row01['order_del_no'];
							$date=date('Ymd');
							$employee_no=$order_del_no."-".$input_job_no;
							$remarks="Team"."-".$input_module."::".$date;
						}
						if(strlen($employee_no) > 10)
						{
							$employee_no = substr($employee_no,-10);
						}					
						$tid1=implode(",",$tid);
						$mo_operation_quantites_query="SELECT mo_no,sum(bundle_quantity) as bundle_quantity,op_code,op_desc,ref_no FROM $bai_pro3.mo_operation_quantites WHERE ref_no in ($tid1) and op_code='$op_code' group by mo_no";
						//echo $mo_operation_quantites_query."<br>";
						//die();
						//added m3 db in query
						$mssql_insert_query="insert into [$mssql_db].[dbo].[M3_MRN_Link] (Company,Facility,MONo,OperationNo, ManufacturedQty,EmployeeNo,Remark,CONO,Schedule,Status,DSP1,DSP2,DSP3,DSP4) values";
						$values = array();
						$ref_no = array();
						$sql_result5=mysqli_query($link, $mo_operation_quantites_query) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row5=mysqli_fetch_array($sql_result5))
						{
							$id=$sql_row5['id'];
							$mo_no=$sql_row5['mo_no'];
							$bundle_quantity=$sql_row5['bundle_quantity'];
							$op_code=$sql_row5['op_code'];
							$op_desc=$sql_row5['op_desc'];
							$ref_no[]=$sql_row5['ref_no'];
							array_push($values, "('" . $company_no . "','" . $facility_code . "','" . $mo_no . "','" . $op_code . "','" . $bundle_quantity . "','".$employee_no."','".$remarks."','".$co_no."','".$order_del_no."',NULL,'1','1','1','1')"); 
						}
						$ref_no1=implode(",",$ref_no);
						$mssql_insert_query_result=odbc_exec($conn, $mssql_insert_query . implode(', ', $values));
						$sql_num_check5=odbc_num_rows($mssql_insert_query_result);
						
						$sql="select * from $brandix_bts.tbl_orders_style_ref where product_style='$style'";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row10=mysqli_fetch_array($sql_result))
						{
							$id=$sql_row10['id'];
						}
						$sql8="select * from $brandix_bts.tbl_orders_master where product_schedule='$schedule'";
						$sql_result8=mysqli_query($link, $sql8) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row11=mysqli_fetch_array($sql_result8))
						{
							$schedule_id=$sql_row11['id'];
						}
						if($sql_num_check5>0)
						{
							$pass_update1="update $bai_pro3.pac_stat_log_input_job set mrn_status='1' where input_job_no_random='$inputjobno'";
							$pass_update1_result=mysqli_query($link, $pass_update1) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
							echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
							$('#loading-image').hide();
							function Redirect() {
							sweetAlert('MRN Confirmed Successfully','','success');
							location.href = \"".getFullURLLevel($_GET['r'], "sewing_job_create_mrn.php", "0", "N")."&style=$id&schedule=$schedule_id\";

							}
							</script>";
						}						
						else
						{
							echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
							$('#loading-image').hide();
							function Redirect() {
							sweetAlert('MRN Confirmed Failed','','warning');
							location.href = \"".getFullURLLevel($_GET['r'], "sewing_job_create_mrn.php", "0", "N")."&style=$id&schedule=$schedule_id\";

							}
							</script>";
						}	
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