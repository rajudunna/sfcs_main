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
											echo '<input type="hidden" name="mix_colors" value="'.$mix_colors.'">';
											echo '<input type="hidden" name="job_qty" value="'.$job_qty.'">';

						                    echo "<div class='row'>
											<table class='table table-bordered'>";
												echo "<tr>";
												echo "<th>Sewing Job No</th>";
												echo "<th>Schedule</th>";
												echo "<th>Color Set</th>";
												echo "<th>Cut Job#</th>";
												echo "<th>Size Set</th>";
												echo "<th>Total Sewing Job Quantity</th>";
												echo "<th colspan=2><center>Action</center></th>";

												echo "</tr>";


								$sql="SELECT type_of_sewing,input_job_no_random,sch_mix,input_job_no,GROUP_CONCAT(DISTINCT tid ORDER BY tid) AS tid,GROUP_CONCAT(DISTINCT doc_no_ref ORDER BY doc_no) AS doc_no_ref,GROUP_CONCAT(DISTINCT m3_size_code order by m3_size_code) AS size_code,group_concat(distinct order_col_des order by order_col_des) as order_col_des,doc_no,group_concat(distinct order_del_no) as order_del_no,GROUP_CONCAT(DISTINCT CONCAT(order_col_des,'$',acutno) ORDER BY doc_no SEPARATOR ',') AS acutno,SUM(carton_act_qty) AS carton_act_qty FROM (SELECT DISTINCT(SUBSTRING_INDEX(order_joins,'J',-1)) AS sch_mix,order_del_no, input_job_no, input_job_no_random, tid, doc_no, doc_no_ref, m3_size_code, order_col_des, acutno, SUM(carton_act_qty) AS carton_act_qty, type_of_sewing FROM $bai_pro3.packing_summary_input WHERE order_del_no in ($schedule) $exp_query GROUP BY order_col_des,order_del_no,input_job_no_random,acutno,m3_size_code order by field(order_del_no,'$schedule'),field(m3_size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')) AS t GROUP BY input_job_no_random ORDER BY acutno*1, input_job_no*1, field(m3_size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')";
								// echo $sql."<br>";
								$temp=0;
                                    $job_no=0;
                                    $color="";
                                    $sql_result=mysqli_query($link, $sql) or exit("Sql Error90 = $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($sql_row=mysqli_fetch_array($sql_result))
                            {
                                $temp+=$sql_row['carton_act_qty'];
                                if($temp>$job_qty or $color!=$sql_row['order_col_des'] or in_array($sql_row['order_del_no'],$donotmix_sch_list))
                                	{
                                        $job_no++;
                                        $temp=0;
                                        $temp+=$sql_row['carton_act_qty'];
                                        $color=$sql_row['order_col_des'];
                                    }
                                    $bg_color = get_sewing_job_prefix("bg_color","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$sql_row['input_job_no'],$link);
                                    $sql4="select order_tid from $bai_pro3.bai_orders_db where order_del_no=\"".$sql_row["sch_mix"]."\"";
                                     $sql_result4=mysqli_query($link, $sql4) or exit("Sql Error44a $sql4".mysqli_error($GLOBALS["___mysqli_ston"]));
                                     while($sql_row4=mysqli_fetch_array($sql_result4))
                                        {
                                            $order_tid=$sql_row4["order_tid"];
                                        }
                                        $total_cuts=explode(",",$sql_row['acutno']);
                                        $cut_jobs_new='';
                                        for($ii=0;$ii<sizeof($total_cuts);$ii++)
                                        {
                                            $arr = explode("$", $total_cuts[$ii], 2);;
                                           // $col = $arr[0];
                                            $sql4="select color_code from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$schedule."\" and order_col_des='".$arr[0]."'";
                                            //echo $sql4."<br>";
                                            $sql_result4=mysqli_query($link, $sql4) or exit("Sql Error44b $sql4".mysqli_error($GLOBALS["___mysqli_ston"]));
                                            while($sql_row4=mysqli_fetch_array($sql_result4))
                                            {
                                                $color_code=$sql_row4["color_code"];
                                            }
                                            $cut_jobs_new .= chr($color_code).leading_zeros($arr[1], 3)."<br>";
                                            unset($arr);
                                        }
                                        $doc_tag=$sql_row["doc_no"];

                                        $sql_des="select group_concat(distinct size_code ORDER BY old_size) as size_code from $bai_pro3.packing_summary_input where order_del_no=\"".$schedule."\" and input_job_no='".$sql_row['input_job_no']."'";
                                        // echo $sql_des.'<br>';
                                        $sql_result4x=mysqli_query($link, $sql_des) or exit("Sql Error44c $sql_des".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        while($sql_row4x=mysqli_fetch_array($sql_result4x))
                                        {
                                            $size_codes=$sql_row4x['size_code'];
                                        }


									echo "<tr style='background-color:$bg_color;'>";
									echo "<td>".$sql_row['input_job_no']."</td>";
									echo "<td>".$sql_row['order_del_no']."</td>";
									echo "<td>".$sql_row['order_col_des']."</td>";
									echo "<td>".$cut_jobs_new."</td>";
									echo "<td>".strtoupper($size_codes)."</td>";
									echo "<td>".$sql_row['carton_act_qty']."</td>";

									$query1="select sum(mrn_status) as mrn_status from $bai_pro3.packing_summary_input where order_del_no=\"".$schedule."\" and input_job_no='".$sql_row['input_job_no']."' group by input_job_no";
									$query1_result=mysqli_query($link, $query1) or exit("Sql Error44 $query1_result".mysqli_error($GLOBALS["___mysqli_ston"]));
								
												while($sql_row4x1=mysqli_fetch_array($query1_result))
												{
														$mrn_status=$sql_row4x1['mrn_status']; 
														if($mrn_status>0){
															echo "<td><center>Confirmed</center></td>";
																	if(in_array($authorized,$has_permission))
																	{ 
																		echo "<td><center><a class='btn btn-info btn-xs' href=\"".getFullURL($_GET['r'], "sewing_job_create_mrn.php", "N")."&inputjobno=".$sql_row['input_job_no_random']."&seq_no=$seq_no&style=$style&schedule=".$sql_row['order_del_no']."&color=".$sql_row['order_col_des']."&var1=1\" onclick=\"clickAndDisable(this);\" name=\"return\">Return</a></center></td>";
																	}
																echo"</tr>";
																								
														}
														else{
															echo "<td ><center><a class='btn btn-info btn-xs' href=\"".getFullURL($_GET['r'], "sewing_job_create_mrn.php", "N")."&jobno=".$sql_row['input_job_no']."&style=$style&schedule=".$sql_row['order_del_no']."&color=".$sql_row['order_col_des']."&inputjobno=".$sql_row['input_job_no_random']."&seq_no=$seq_no&style=$style&schedule=".$sql_row['order_del_no']."&color=".$sql_row['order_col_des']."&var1=2\" onclick=\"clickAndDisable(this);\">Confirm</a></center></td>";
															echo "<td></td>";
															echo"</tr>"; 
														}

												}
								}
								echo"</table>";
					echo"</form>";
			echo"</div>";
		 echo"</div>";
	echo"</div>";
								}
							
						

					}
				}
		
if($_GET['var1']==1){
	$conn = odbc_connect("$ms_sql_driver_name;Server=$ms_sql_odbc_server;Database=$mssql_db;", $ms_sql_odbc_user,$ms_sql_odbc_pass);
	$schedule=$_GET['schedule'];
	$style=$_GET['style'];
	$color=$_GET['color'];
	$inputjobno=$_GET['inputjobno'];
	$op_code=1;
	$sql14="SELECT co_no FROM $bai_pro3.bai_orders_db_confirm WHERE order_del_no='$schedule' and order_style_no='$style' and order_col_des='$color'";
					
        $sql_result14=mysqli_query($link, $sql14) or exit("Sql Error71".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($sql_row14=mysqli_fetch_array($sql_result14))
        {
            $co_no=$sql_row14['co_no'];
		}
		$sql55="SELECT tid,input_job_no,order_del_no  FROM $bai_pro3.packing_summary_input WHERE  input_job_no_random='$inputjobno'";
		$sql_result01=mysqli_query($link, $sql55) or exit("Sql Error01".mysqli_error($GLOBALS["___mysqli_ston"]));
		// $tid=array();
		while($sql_row01=mysqli_fetch_array($sql_result01))
		{

			$tid[]=$sql_row01['tid'];
			$input_job_no=$sql_row01['input_job_no'];
			$order_del_no=$sql_row01['order_del_no'];
			$date=date('Ymd');
			$employee_no=$order_del_no."-".$input_job_no;
			$remarks=$order_del_no."-".$date;
		}
		$tid1=implode(",",$tid);
			$mo_operation_quantites_query="SELECT mo_no,sum(bundle_quantity) as bundle_quantity,op_code,op_desc,ref_no FROM $bai_pro3.mo_operation_quantites WHERE ref_no in ($tid1) and op_code='$op_code' group by mo_no";
			$mssql_insert_query="insert into [MRN_V2].[dbo].[M3_MRN_Link] (Company,Facility,MONo,OperationNo, ManufacturedQty,EmployeeNo,Remark,CONO,Schedule,Status) values";
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
                                    array_push($values, "('" . $company_no . "','" . $facility_code . "','" . $mo_no . "','" . $op_code . "','" . $bundle_quantity . "','".$employee_no."','".$remarks."','".$co_no."','".$order_del_no."','')"); 
               
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
								if($sql_num_check5>0){
                                    $pass_update1="update $bai_pro3.pac_stat_log_input_job set mrn_status='0' where tid in ($ref_no1)";
                                    $pass_update1_result=mysqli_query($link, $pass_update1) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
            
                                    echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
                                    function Redirect() {
                                    sweetAlert('MRN Reversal successfully Completed','','success');
                                    location.href = \"".getFullURLLevel($_GET['r'], "sewing_job_create_mrn.php", "0", "N")."&style=$id&schedule=$schedule_id\";
            
                                    }
                                    </script>";
                                }
								else
								{
                                    echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
                                    function Redirect() {
                                    sweetAlert('Reversal Failed','','success');
                                    location.href = \"".getFullURLLevel($_GET['r'], "sewing_job_create_mrn.php", "0", "N")."&style=$id&schedule=$schedule_id\";
            
                                    }
                                    </script>";
                                }
						
}
elseif($_GET['var1']==2){
	
	$conn = odbc_connect("$ms_sql_driver_name;Server=$ms_sql_odbc_server;Database=$mssql_db;", $ms_sql_odbc_user,$ms_sql_odbc_pass);
	    $schedule=$_GET['schedule'];
		$style=$_GET['style'];
		$color=$_GET['color'];
		$inputjobno=$_GET['inputjobno'];
		$op_code=1;
		$sql14="SELECT co_no FROM $bai_pro3.bai_orders_db_confirm WHERE order_del_no='$schedule' and order_style_no='$style' and order_col_des='$color'";
		$sql_result14=mysqli_query($link, $sql14) or exit("Sql Error71".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row14=mysqli_fetch_array($sql_result14))
		{
			$co_no=$sql_row14['co_no'];
		}
		$sql55="SELECT tid,input_job_no,order_del_no  FROM $bai_pro3.packing_summary_input WHERE input_job_no_random='$inputjobno'";
		$sql_result01=mysqli_query($link, $sql55) or exit("Sql Error01".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row01=mysqli_fetch_array($sql_result01))
		{
			
			        $tid[]=$sql_row01['tid'];
					$input_job_no=$sql_row01['input_job_no'];
					$order_del_no=$sql_row01['order_del_no'];
					$date=date('Ymd');
					$employee_no=$order_del_no."-".$input_job_no;
					$remarks=$order_del_no."-".$date;
				
		}
		$tid1=implode(",",$tid);
					$mo_operation_quantites_query="SELECT mo_no,sum(bundle_quantity) as bundle_quantity,op_code,op_desc,ref_no FROM $bai_pro3.mo_operation_quantites WHERE ref_no in ($tid1) and op_code='$op_code' group by mo_no";
					$sql_result5=mysqli_query($link, $mo_operation_quantites_query) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
					$mssql_insert_query="insert into [MRN_V2].[dbo].[M3_MRN_Link] (Company,Facility,MONo,OperationNo, ManufacturedQty,EmployeeNo,Remark,CONO,Schedule,Status) values";
					$values = array();
					$ref_no = array();
					while($sql_row5=mysqli_fetch_array($sql_result5))
					{
						$id=$sql_row5['id'];
						$mo_no=$sql_row5['mo_no'];
						$bundle_quantity=$sql_row5['bundle_quantity'];
						$op_code=$sql_row5['op_code'];
						$op_desc=$sql_row5['op_desc'];
						$ref_no[]=$sql_row5['ref_no'];
						array_push($values, "('" . $company_no . "','" . $facility_code . "','" . $mo_no . "','" . $op_code . "','" . $bundle_quantity . "','".$employee_no."','".$remarks."','".$co_no."','".$order_del_no."','')");
					}
					$ref_no1=implode(",",$ref_no);
					$mssql_insert_query_result=odbc_exec($conn, $mssql_insert_query . implode(', ', $values));
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
					$sql_num_check5=odbc_num_rows($mssql_insert_query_result);
					if($sql_num_check5>0){
						$pass_update1="update $bai_pro3.pac_stat_log_input_job set mrn_status='1' where tid in ($ref_no1)";
						$pass_update1_result=mysqli_query($link, $pass_update1) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));

						echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
						function Redirect() {
						sweetAlert('Records Inserted Successfully','','success');
						location.href = \"".getFullURLLevel($_GET['r'], "sewing_job_create_mrn.php", "0", "N")."&style=$id&schedule=$schedule_id\";

						}
						</script>";
					}
					else
					{
						echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
						function Redirect() {
						sweetAlert('Records Insert Failed','','success');
						location.href = \"".getFullURLLevel($_GET['r'], "sewing_job_create_mrn.php", "0", "N")."&style=$id&schedule=$schedule_id\";

						}
						</script>";
					}	

	
			
	}
			?> 
		</div>
	</div>
</div>

<script> 
   function clickAndDisable(link) {
     // disable subsequent clicks
     link.onclick = function(event) {
        event.preventDefault();
     }
   }   
</script>