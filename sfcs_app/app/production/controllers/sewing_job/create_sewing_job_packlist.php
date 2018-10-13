<head>
	<script language="javascript" type="text/javascript">
	
	var url1 = '<?= getFullURL($_GET['r'],'create_sewing_job_packlist.php','N'); ?>';
	function myFunction() {
		document.getElementById("generate").style.visibility = "hidden";
	}

	function firstbox()
	{
		//alert("report");
		window.location.href =url1+"&style="+document.mini_order_report.style.value
	}

	function secondbox()
	{
		//alert('test');
		window.location.href =url1+"&style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
	}

	function check_val()
	{
		//alert('dfsds');
		var style=document.getElementById("style").value;
		var schedule=document.getElementById("schedule").value;
		
		if(style == 'NIL' || schedule == 'NIL')
		{
			sweetAlert('Please select style and schedule','','warning');
			// document.getElementById('submit').style.display=''
			// document.getElementById('msg').style.display='none';
			return false;
		}
		return true;	
	}
</script>
</head>
<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/header_scripts.php',2,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/menu_content.php',2,'R')); 
    $has_permission=haspermission($_GET['r']);
	
	error_reporting(0);
?>
<style>
	table, th, td {
		text-align: center;
	}
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
<div class="ajax-loader" id="loading-image" style="display: none">
    <center><img src='<?= getFullURLLevel($_GET['r'],'common/images/ajax-loader.gif',2,'R'); ?>' class="img-responsive" style="padding-top: 250px"/></center>
</div>
<div class="panel panel-primary">
	<div class="panel-heading"><b>Sewing Job Generation (Packing List Based)</b></div>
	<div class="panel-body">
	<?php
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
				echo "<form name=\"mini_order_report\" action=\"?r=".$_GET['r']."\" method=\"post\" >";
				echo "<div class='col-md-3 col-sm-3 col-xs-12'>";
				?>
					Style:
					<?php
						// Style
						echo "<select name=\"style\" id=\"style\" class='form-control' onchange=\"firstbox();\" >";
						$sql="select DISTINCT style as product_style from $bai_pro3.pac_stat";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result);
						echo "<option value=\"NIL\" selected>Select Style</option>";
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							if(str_replace(" ","",$sql_row['product_style'])==str_replace(" ","",$style))
							{
								echo "<option value=\"".$sql_row['product_style']."\" selected>".$sql_row['product_style']."</option>";
							}
							else
							{
								echo "<option value=\"".$sql_row['product_style']."\">".$sql_row['product_style']."</option>";
							}
						}
						echo "</select>";
						echo "</div>";
						echo "<div class='col-md-3 col-sm-3 col-xs-12'>";
					?>
					&nbsp;Schedule:
					<?php
						// Schedule
						echo "<select class='form-control' name=\"schedule\" id=\"schedule\"  >";
						$sql="select DISTINCT schedule as product_schedule from $bai_pro3.pac_stat where style='".$style."'";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						echo "<option value=\"NIL\" selected>Select Schedule</option>";
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							if(str_replace(" ","",$sql_row['product_schedule'])==str_replace(" ","",$schedule))
							{
								echo "<option value=\"".$sql_row['product_schedule']."\" selected>".$sql_row['product_schedule']."</option>";
							}
							else
							{
								echo "<option value=\"".$sql_row['product_schedule']."\">".$sql_row['product_schedule']."</option>";
							}
						}
						echo "</select>";
						echo "</div>";
					?>
					&nbsp;&nbsp;
					<div class='col-md-3 col-sm-3 col-xs-12'>
					<input type="submit" name="submit" id="submit" class="btn btn-success " onclick="return check_val();" value="Submit" style="margin-top: 18px;">
					</div>
				</form>
		<div class="col-md-12">
			<?php
			if(isset($_POST['submit']) or ($_GET['style'] and $_GET['schedule']))
			{					
				if ($_GET['style'] and $_GET['schedule'])
				{
					$style=$_GET['style'];
					$schedule = $_GET['schedule'];
				} 
				else if ($_POST['style'] and $_POST['schedule'])
				{
					$style=$_POST['style'];
					$schedule = $_POST['schedule'];	
				}
				
				$style_id = echo_title("$brandix_bts.tbl_orders_style_ref","id","product_style",$style,$link); 
				$schedule_id = echo_title("$brandix_bts.tbl_orders_master","id","product_schedule",$schedule,$link);
				// echo $style."---".$schedule;
				
				$pac_stat_input_check = echo_title("$bai_pro3.pac_stat_input","count(*)","schedule",$schedule,$link);
				$packing_summary_input_check = echo_title("$bai_pro3.packing_summary_input","count(*)","order_del_no",$schedule,$link);
				$pack_size_ref_check = echo_title("$bai_pro3.tbl_pack_ref","count(*)","schedule",$schedule,$link);

				if ($packing_summary_input_check > 0)
				{
					if ($pac_stat_input_check > 0)
					{
						$display_check = 1;
					}
					else
					{
						echo '<br><div class="alert alert-danger">
								  <strong>Warning!</strong><br>You have prepared Sewing Jobs in Normal process, Please go to the interface and check';
								echo "&nbsp;&nbsp;&nbsp;&nbsp;<a class='btn btn-primary' href = '".getFullURLLevel($_GET['r'],'sewing_job_create_original.php',0,'N')."'>Click Here</a>
								</div>";
					}
				}
				else
				{
					$display_check = 1;
				}

				if ($display_check == 1)
				{
					// Order Details Display Start
					{
						$col_array = array();
						$sizes_query = "SELECT order_col_des FROM $bai_pro3.`bai_orders_db` WHERE order_del_no=$schedule AND order_style_no='".$style."' and order_joins not in (1,2)";
						//echo $sizes_query;die();
						$sizes_result=mysqli_query($link, $sizes_query) or exit("Sql Error2 $sizes_query");
						$row_count = mysqli_num_rows($sizes_result);
						while($sizes_result1=mysqli_fetch_array($sizes_result))
						{
							$col_array[]=$sizes_result1['order_col_des'];
						}
						
						$sewing_jobratio_sizes_query = "SELECT GROUP_CONCAT(DISTINCT size_title) AS size FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id=$schedule_id";
						// echo $sewing_jobratio_sizes_query.'<br>';
						$sewing_jobratio_sizes_result=mysqli_query($link, $sewing_jobratio_sizes_query) or exit("Error while getting Job Ratio Details");
						while($sewing_jobratio_color_details=mysqli_fetch_array($sewing_jobratio_sizes_result)) 
						{
							$ref_size = $sewing_jobratio_color_details['size'];
							$size_main = explode(",",$ref_size);
							// var_dump($size);
						}
						$sizeofsizes=sizeof($size_main);

						$planned_qty = array();
						$ordered_qty = array();
						$sewing_gen_qty = array();

						echo "<br>
							<div class='col-md-12 table-responsive'>
								<table class=\"table table-bordered\">
									<tr class=\"info\">
										<th>Colors</th>
										<th>Details</th>";
										for ($i=0; $i < sizeof($size_main); $i++)
										{
											echo "<th>$size_main[$i]</th>";
										}	
										
										echo "<th>Total</th>
									</tr>";
						// echo sizeof($col_array);
						for ($j=0; $j < sizeof($col_array); $j++)
						{
							$tot_ordered = 0;
							$tot_planned = 0;
							$sewing_gen_tot = 0;
							for($kk=0;$kk<sizeof($size_main);$kk++)
							//foreach ($sizes_array as $key => $value)
							{
								$plannedQty_query = "SELECT SUM(quantity*planned_plies) AS plannedQty FROM $brandix_bts.tbl_cut_size_master LEFT JOIN $brandix_bts.tbl_cut_master ON tbl_cut_size_master.parent_id=tbl_cut_master.id LEFT JOIN $brandix_bts.tbl_orders_sizes_master ON tbl_orders_sizes_master.parent_id=tbl_cut_master.ref_order_num	WHERE tbl_cut_master.ref_order_num='$schedule_id' AND tbl_orders_sizes_master.order_col_des='$col_array[$j]' AND tbl_orders_sizes_master.size_title='$size_main[$kk]' AND tbl_cut_size_master.ref_size_name=tbl_orders_sizes_master.ref_size_name AND tbl_cut_size_master.color=tbl_orders_sizes_master.order_col_des";
								//echo $plannedQty_query.'<br>';
								$plannedQty_result=mysqli_query($link, $plannedQty_query) or exit("Sql Error2");
								while($planneQTYDetails=mysqli_fetch_array($plannedQty_result))
								{
									if($planneQTYDetails['plannedQty']=='')
									{
										$planned_qty[$col_array[$j]][$size_main[$kk]]=0;
									}
									else
									{
										$planned_qty[$col_array[$j]][$size_main[$kk]] = $planneQTYDetails['plannedQty'];
									}
								}
								$orderQty_query = "SELECT SUM(order_act_quantity) AS orderedQty FROM $brandix_bts.tbl_orders_sizes_master WHERE parent_id='$schedule_id' AND tbl_orders_sizes_master.size_title='$size_main[$kk]' AND order_col_des = '$col_array[$j]'";
								//echo $orderQty_query.'<br>';
								$Order_qty_resut=mysqli_query($link, $orderQty_query) or exit("Sql Error2");
								while($orderQty_details=mysqli_fetch_array($Order_qty_resut))
								{
									if($orderQty_details['orderedQty']=='')
									{
										$ordered_qty[$col_array[$j]][$size_main[$kk]]=0;
									}
									else
									{
										$ordered_qty[$col_array[$j]][$size_main[$kk]] = $orderQty_details['orderedQty'];
									}
									
								}

								$getpackqty="SELECT SUM(carton_act_qty) AS sewing_gen_qty FROM $bai_pro3.packing_summary_input WHERE order_del_no='$schedule' AND size_code='$size_main[$kk]' AND order_col_des='$col_array[$j]'";
								$packqtyrslt=mysqli_query($link, $getpackqty) or exit("Error while getting parent id");
								if($pack_row=mysqli_fetch_array($packqtyrslt))
								{
									if($pack_row['sewing_gen_qty']=='')
									{
										$sewing_gen_qty[$col_array[$j]][$size_main[$kk]]=0;
									}
									else
									{
										$sewing_gen_qty[$col_array[$j]][$size_main[$kk]]=$pack_row['sewing_gen_qty'];
									}
								}
							}
							// echo $col_array[$i];
							

							echo "<tr>
									<td rowspan=3>$col_array[$j]</td>
									<td>Order Qty</td>";
									for ($i=0; $i < sizeof($size_main); $i++)
									{ 
										echo "<td>".$ordered_qty[$col_array[$j]][$size_main[$i]]."</td>";
										$tot_ordered = $tot_ordered + $ordered_qty[$col_array[$j]][$size_main[$i]];
									}
									echo "<td>$tot_ordered</td>
								</tr>";

							echo "<tr>
									<td>Cut Plan Qty</td>";
									for ($i=0; $i < sizeof($size_main); $i++)
									{ 
										echo "<td>".$planned_qty[$col_array[$j]][$size_main[$i]]."</td>";
										$tot_planned = $tot_planned + $planned_qty[$col_array[$j]][$size_main[$i]];
									}
									echo "<td>$tot_planned</td>
								</tr>";

							echo "<tr>
									<td>Sewing Job Generated</td>";
									for ($i=0; $i < sizeof($size_main); $i++)
									{									
										echo "<td>".$sewing_gen_qty[$col_array[$j]][$size_main[$i]]."</td>";
										$sewing_gen_tot = $sewing_gen_tot + $sewing_gen_qty[$col_array[$j]][$size_main[$i]];
									}
									echo "<td>$sewing_gen_tot</td>
								</tr>";
						}
						echo "</table>
							</div>";
					}
					// Order Details Display End

					//packing method details					
					$get_pack_id=" select id from $bai_pro3.tbl_pack_ref where schedule=$schedule AND style='".$style."'"; 
					// echo $get_pack_id;
					$get_pack_id_res=mysqli_query($link, $get_pack_id) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$row = mysqli_fetch_row($get_pack_id_res);
					$pack_id=$row[0];
					$pack_meth_qry="SELECT *,parent_id,sum(garments_per_carton*pack_job_per_pack_method) as qnty,GROUP_CONCAT(size_title SEPARATOR '<br>') as size ,GROUP_CONCAT(color SEPARATOR '<br>') as color,seq_no,pack_method,min(pack_job_per_pack_method) as min_carton FROM $bai_pro3.tbl_pack_size_ref WHERE parent_id='$pack_id' GROUP BY seq_no order by seq_no";
					// echo $pack_meth_qry;
					$pack_meth_qty=mysqli_query($link, $pack_meth_qry) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
					if (mysqli_num_rows($pack_meth_qty) > 0)
					{
						$count = 0;
						echo "<br><div class='col-md-12'>
								<table class=\"table table-bordered\">
									<tr class=\"info\">
										<th>S.No</th>
										<th>Sewing Job Method</th>
										<th style='display: none;'>Mix Jobs</th>
										<th>Description</th>	
										<th>Bundle Size</th>
										<th>No of Cartons<br>per Sewing Job</th>										
										<th>Quantity</th>
										<th colspan=3>Colors</th>
										<th>Sizes</th>
										<th>Controls</th></tr>";
									while($pack_result1=mysqli_fetch_array($pack_meth_qty))
									{
										$get_sew_method = 0;	$bundle_size_sew = -1;	$no_of_cartons_sew = 0;
										echo '<form name="input" method="post" id="form_id_'.$count.'"  onsubmit="return test_man('.$count.',event);" action="'.getFullURL($_GET['r'],'sewing_jobs_generate_packlist.php','N').'">';
											$seq_no=$pack_result1['seq_no'];

											$check_status = echo_title("$bai_pro3.packing_summary_input","count(*)","order_del_no='$schedule' and pac_seq_no",$seq_no,$link);
											if($check_status==0)
											{
												$readonly = '';
												$disabled = '';
											}
											else
											{
												$readonly='readonly';
												$disabled='disabled';
												$get_sew_method = echo_title("$bai_pro3.pac_stat_input","pack_method","schedule='$schedule' and pac_seq_no",$seq_no,$link);
												$bundle_size_sew = echo_title("$bai_pro3.pac_stat_input","bundle_qty","schedule='$schedule' and pac_seq_no",$seq_no,$link);
												$no_of_cartons_sew = echo_title("$bai_pro3.pac_stat_input","no_of_cartons","schedule='$schedule' and pac_seq_no",$seq_no,$link);
												// echo $get_sew_method;
											}
											$max_crton = $pack_result1['min_carton'];
											$parent_id=$pack_result1['parent_id'];
											$pack_method=$pack_result1['pack_method'];
											echo "<tr>
												<td>".$pack_result1['seq_no']."</td>
												<td><select id=\"pack_method_".$count."\"  class='form-control' $disabled name=\"pack_method\" >";
													for($j=0;$j<sizeof($operation);$j++)
													{
														if ($get_sew_method == $j){
															$selected_pm = 'selected';
														} else {
															$selected_pm = '';
														}

														if ($j==0)
														{
															echo "<option value=''>".$operation[$j]."</option>";
														}
														else
														{
															echo "<option value=\"".$j."\" $selected_pm>".$operation[$j]."</option>";
														}
													}
													echo "</select>
												</td>
												<td style='display: none;'>
													<center>
														<select name='mix_jobs' id='mix_jobs' class='form-control'>
															<option value=''>Please Select</option>
															<option value='1'>Yes</option>
															<option value='2' selected>No</option>
														</select>
													</center>
												</td>
												<td>".$pack_result1['pack_description']."</td>
												<td><input type='text' size=5 $readonly class='form-control integer' name='bund_size' id='bund_size_".$count."' onfocus=if(this.value==-1){this.value=''} onblur=if(this.value==''){this.value=-1;} value='$bundle_size_sew'></td>
												<input type='hidden' name='seq_no' id='seq_no' value='$seq_no'>
												<input type='hidden' name='max_crton' id='max_crton_".$count."' value='$max_crton'>
												<input type='hidden' name='schedule' id='schedule' value='$schedule'>
												<input type='hidden' name='style' id='style' value='$style'>
												<td><input type='text' size=5 $readonly  class='form-control integer' name='no_of_cartons' id='no_of_cartons_".$count."' onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value='$no_of_cartons_sew'></td>
												<td>".$pack_result1['qnty']."</td>
												<td colspan=3>".$pack_result1['color']."</td>
												<td>".$pack_result1['size']."</td>";
											
											if ($max_crton > 0)
											{
												if($check_status==0)
												{
													echo "<td>
													<input type=\"submit\" class=\"btn btn-success\" value=\"Generate Sewing Jobs\" name=\"generate\" id=\"generate\" />
													</td>";
												}
												else
												{
													$url=getFullURL($_GET['r'],'input_job_mix_ch_report.php','N');
													echo"<td>
															<h4><span class='label label-success'>Sewing Job Generated</span></h4>
															<br>
															<a class='btn btn-info' href='$url&schedule=$schedule&seq_no=$seq_no&style=$style'>Print Job Sheets</a>
														</td>";
												}
											}
											else
											{
												echo"<td><h4><span class='label label-danger'>Packing List not yet Generated</span></h4></td>";
											}
											echo "<tr>
										</form>";
										echo '<input type="hidden" name="count" value="'.$count.'" id="count">';
										$count++;
									}	
								
							echo "</table></div>";
					}
					$pack_qnty = $_GET['order_total'];
					$ordr_qnty = $_GET['ordr_qnty'];
				}		
			}
			?>

			<script type="text/javascript">

				function test_man(count,event)
				{
					event.preventDefault();
					var sew_pack_method = document.getElementById('pack_method_'+count).value;
					var sew_bundle_size = document.getElementById('bund_size_'+count).value;
					var sew_no_of_cart = Number(document.getElementById('no_of_cartons_'+count).value);
					var max_carton = Number(document.getElementById('max_crton_'+count).value);
					//alert(sew_pack_method+' == '+sew_bundle_size+' == '+sew_no_of_cart+' == '+max_carton);
					if (sew_pack_method == 0)
					{
						sweetAlert('Please Select Sewing Job Method','','warning');
					}
					else
					{
						if (sew_no_of_cart > max_carton)
						{
							// sweetAlert('No of Cartons exceeding Max Cartons','','warning');
							sweetAlert('Enter Cartons Less than or equal to '+max_carton,'','warning');
						}
						else
						{
							if (sew_bundle_size == -1 || sew_bundle_size == null)
							{
								sweetAlert('Enter Valid Bundle Size','','warning');
							}
							else
							{
								if (sew_bundle_size > 0)
								{
									title_to_show = "";
								}
								else
								{
									title_to_show = "Bundle Size not defined, Deafult bundle size will be applied";
								}

								if (sew_no_of_cart == 0 || sew_no_of_cart == null)
								{
									sweetAlert('Enter Valid Number of Cartons','','warning');
								}
								else
								{
									sweetAlert({
										title: "Are you sure to generate Sewing Jobs?",
										text: title_to_show,
										icon: "warning",
										buttons: true,
										dangerMode: true,
										buttons: ["No, Cancel It!", "Yes, I am Sure!"],
									}).then(function(isConfirm){
										if (isConfirm) {
											document.getElementById('form_id_'+count).submit();
											$("#loading-image").show();
										} else {
											sweetAlert("Request Cancelled",'','error');
											return false;
										}
									});
									return;
								}
							}
						}
					}
					return false;
				}
			</script>
		</div>
	</div>
</div>