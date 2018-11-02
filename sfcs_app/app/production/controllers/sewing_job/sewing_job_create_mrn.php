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

		function submit_form(submit_btn)
		{
			var split_tot = 0;
			var comboSize=document.getElementById("comboSize").value;
			for(var combo_size=1;combo_size <= comboSize; combo_size++)
			{
				var split=document.getElementById("split_qty_"+combo_size).value;
				// confirm("split_qty_"+combo_size+" => "+split);
				if (split == -1 || split == '')
				{
					sweetAlert('Enter valid Garments Per Bundle','','warning');
					return;
				}
				split_tot = split_tot + split;
			}
			// var exces_from=document.getElementById("exces_from").value;
			var mix_jobs=document.getElementById("mix_jobs").value;
			// alert(mix_jobs);
			if (mix_jobs == '')
			{
				sweetAlert('Please Select Mix Jobs','','warning');
			}
			else
			{
				// if (exces_from == 0)
				// {
				// 	sweetAlert('Please Select Excess From','','warning');
				// }
				// else
				// {
					if (split_tot > 0)
					{
						title_to_show = "";
					}
					else
					{
						title_to_show = "Bundle Size not defined, Deafult bundle size will be applied";
					}
					sweetAlert({
						title: "Are you sure to generate Sewing Jobs?",
						text: title_to_show,
						icon: "warning",
						buttons: true,
						dangerMode: true,
						buttons: ["No, Cancel It!", "Yes, I am Sure!"],
					}).then(function(isConfirm){
						if (isConfirm) {
								$('#'+submit_btn.attr('id')).trigger('click',false);
						} else {
							sweetAlert("Request Cancelled",'','error');
							return;
						}
					});
					return;
				// }
			}
		}
	});
	
	function pack_method_1_4_fun(sizeofsizes,combo_no)
	{
		for(var size=0;size < sizeofsizes; size++)
		{
			var GarPerCart=document.getElementById('GarPerCart_'+size+'_'+combo_no).value;
			var no_of_cartons=document.getElementById('no_of_cartons_'+combo_no).value;
			var SewingJobQty = GarPerCart*no_of_cartons;
			document.getElementById('SewingJobQty_'+size+'_'+combo_no).value=SewingJobQty;
		}
	}

	function pack_method_2_3_fun(sizeofsizes,combo_no,val)
	{
		for (var i = 0; i < val; i++)
		{
			for(var size=0;size < sizeofsizes; size++)
			{
				var GarPerCart=document.getElementById('GarPerCart_'+size+'_'+combo_no+'_'+i).value;
				var no_of_cartons=document.getElementById('no_of_cartons_'+combo_no).value;
				var SewingJobQty = GarPerCart*no_of_cartons;
				document.getElementById('SewingJobQty_'+size+'_'+combo_no+'_'+i).value=SewingJobQty;
			}
		}	
	}
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
				<input type="submit" name="submit" id="submit" class="btn btn-success " onclick="return check_val();" value="Submit">
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
						// echo "Style= ".$style_id."<br>Schedule= ".$sch_id.'<br>';
						$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link);
						$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$sch_id,$link);
						
						$pac_stat_input_check = echo_title("$bai_pro3.pac_stat_input","count(*)","schedule",$schedule,$link);
						$packing_summary_input_check = echo_title("$bai_pro3.packing_summary_input","count(*)","order_del_no",$schedule,$link);
						$pack_size_ref_check = echo_title("$bai_pro3.tbl_pack_ref","count(*)","schedule",$schedule,$link);

						if ($packing_summary_input_check > 0)
						{
							if ($pac_stat_input_check > 0)
							{
								// echo '<br><div class="alert alert-danger">
								//   <strong>Warning!</strong>
								//   <br>You have already created sewing jobs based on pack method, So You should go with the same process.';
								// echo "&nbsp;&nbsp;&nbsp;&nbsp;<a class='btn btn-primary' href = '".getFullURLLevel($_GET['r'],'create_sewing_job_packlist.php',0,'N')."'>Click Here to Go</a>
								// </div>";
							}
							else
							{
								$display_check = 1;
							}
						}
						else
						{
							$display_check = 1;
						}	
						
						if ($display_check == 1)
						{
							$c_ref = echo_title("$brandix_bts.tbl_carton_ref","id","ref_order_num",$sch_id,$link);
							$bundle = echo_title("$brandix_bts.tbl_miniorder_data","count(*)","mini_order_ref",$c_ref,$link);
							$carton_qty = echo_title("$brandix_bts.tbl_carton_size_ref","sum(quantity)","parent_id",$c_ref,$link);
							$pack_method = echo_title("$brandix_bts.tbl_carton_ref","carton_method","carton_barcode",$schedule,$link);
							$tbl_carton_ref_check = echo_title("$brandix_bts.tbl_carton_ref","count(*)","style_code='".$style_id."' AND ref_order_num",$sch_id,$link);
							$o_colors = echo_title("$bai_pro3.bai_orders_db_confirm","group_concat(distinct order_col_des order by order_col_des)","bai_orders_db_confirm.order_joins NOT IN ('1','2') AND order_del_no",$schedule,$link);	
							$p_colors = echo_title("$brandix_bts.tbl_orders_sizes_master","group_concat(distinct order_col_des order by order_col_des)","parent_id",$sch_id,$link);
							$order_colors=explode(",",$o_colors);	
							$planned_colors=explode(",",$p_colors);
							$val=sizeof($order_colors);
							$val1=sizeof($planned_colors);
							if($tbl_carton_ref_check>0)
							{
								// echo '<h4>Pack Method: <span class="label label-info">'.$operation[$pack_method].'</span></h4>';
								// echo "carton props added, You can proceed";
								if($bundle == 0)
								{
									$combo = array();
									$get_combo_query = "SELECT DISTINCT (combo_no) AS combo FROM `brandix_bts`.`tbl_carton_size_ref` WHERE parent_id = $c_ref";
									// echo $get_combo_query;
									$combo_result=mysqli_query($link, $get_combo_query) or exit("Error while getting Combo Details");
									while($combo_details=mysqli_fetch_array($combo_result)) 
									{
										$combo[] = $combo_details['combo'];
									}

									$sewing_jobratio_sizes_query = "SELECT GROUP_CONCAT(DISTINCT size_title) AS size, GROUP_CONCAT(DISTINCT order_col_des) AS color FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN ($sch_id)";
									// echo $sewing_jobratio_sizes_query.'<br>';
									$sewing_jobratio_sizes_result=mysqli_query($link, $sewing_jobratio_sizes_query) or exit("Error while getting Job Ratio Details");
									while($sewing_jobratio_color_details=mysqli_fetch_array($sewing_jobratio_sizes_result)) 
									{
										$color = $sewing_jobratio_color_details['color'];
										$ref_size = $sewing_jobratio_color_details['size'];
										$color_main = explode(",",$color);
										$size_main = explode(",",$ref_size);
										// var_dump($size);
									}

									$sizeofsizes=sizeof($size_main);
									$size_of_ordered_colors=sizeof($color_main);

									// Order Details Display Start
									{
										$planned_qty = array();
										$ordered_qty = array();
										$tot_ordered = 0;
										$tot_planned = 0;
										$tot_balance = 0;
										foreach ($sizes_array as $key => $value)
										{
											$plannedQty_query = "SELECT SUM(p_plies*p_$sizes_array[$key]) AS plannedQty FROM $bai_pro3.plandoc_stat_log WHERE cat_ref IN (SELECT tid FROM $bai_pro3.cat_stat_log WHERE category IN ($in_categories) AND order_tid IN  (SELECT order_tid FROM $bai_pro3.`bai_orders_db_confirm` WHERE order_del_no=$schedule))";
											// echo $plannedQty_query.'<br>';
											$plannedQty_result=mysqli_query($link, $plannedQty_query) or exit("Sql Error2");
											while($planneQTYDetails=mysqli_fetch_array($plannedQty_result))
											{
												$planned_qty[] = $planneQTYDetails['plannedQty'];
											}

											$orderQty_query = "SELECT SUM(order_s_$sizes_array[$key]) AS orderedQty FROM $bai_pro3.`bai_orders_db_confirm` WHERE order_del_no=$schedule";
											// echo $orderQty_query.'<br>';
											$Order_qty_resut=mysqli_query($link, $orderQty_query) or exit("Sql Error2");
											while($orderQty_details=mysqli_fetch_array($Order_qty_resut))
											{
												$ordered_qty[] = $orderQty_details['orderedQty'];
											}
										}

										$url1 = getFullURLLevel($_GET['r'],'pop_up_sewing_job_det.php',0,'R');
										echo "<br><a class='btn btn-success' href='$url1?schedule=$schedule' onclick=\"return popitup2('$url1?schedule=$sch_id&style=$style_id')\" target='_blank'>Click Here For Color Wise Order Details</a>";

										echo "<br>
										<div class='col-md-12'><b>Order Details: </b>
											<table class=\"table table-bordered\">
												<tr>
													<th>Details</th>";
													for ($i=0; $i < sizeof($size_main); $i++)
													{
														echo "<th>$size_main[$i]</th>";
													}	
													
													echo "<th>Total</th>
												</tr>";

												echo "<tr>
														<td>Order Qty</td>";
														for ($i=0; $i < $sizeofsizes; $i++)
														{ 
															echo "<td>$ordered_qty[$i]</td>";
															$tot_ordered = $tot_ordered + $ordered_qty[$i];
														}
														echo "<td>$tot_ordered</td>
													</tr>";

												echo "<tr>
														<td>Cut Plan Qty</td>";
														for ($i=0; $i < $sizeofsizes; $i++)
														{ 
															echo "<td>$planned_qty[$i]</td>";
															$tot_planned = $tot_planned + $planned_qty[$i];
														}
														echo "<td>$tot_planned</td>
													</tr>";

												echo "<tr>
														<td>Balance Qty</td>";
														for ($i=0; $i < $sizeofsizes; $i++)
														{
															$balance = $planned_qty[$i]-$ordered_qty[$i];
															if ($balance > 0) {
																$color = '#00b33c';
															} else if ($balance < 0 ) {
																$color = '#FF0000';
															} else if ($balance == 0 ) {
																$color = '#73879C';
															}
															echo "<td style='color:".$color."; font-weight:bold'>".$balance."</td>";
															$tot_balance = $tot_balance + $balance;
														}
														if ($tot_balance > 0) {
															$color = '#00b33c';
														} else if ($tot_balance < 0 ) {
															$color = '#FF0000';
														} else if ($tot_balance == 0 ) {
															$color = '#73879C';
														}
														echo "<td style='color:".$color."; font-weight:bold'>$tot_balance</td>
													</tr>";
											echo "</table>
										</div>";
									}
									// Order Details Display End

									// Poly Bag Ratio Details Start
									{
										$sewing_jobratio_sizes_query = "SELECT parent_id,GROUP_CONCAT(DISTINCT color) AS color, GROUP_CONCAT(DISTINCT ref_size_name) AS size FROM $brandix_bts.tbl_carton_size_ref WHERE parent_id IN (SELECT id FROM $brandix_bts.tbl_carton_ref WHERE ref_order_num=$sch_id AND style_code=$style_id)";
										$sewing_jobratio_sizes_result=mysqli_query($link, $sewing_jobratio_sizes_query) or exit("Error while getting Job Ratio Details");
										echo "<br><div class='col-md-12'><b>Garments Per Poly Bag: </b>
											<table class=\"table table-bordered\">
												<tr>
													<th>Color</th>";
										while($sewing_jobratio_color_details=mysqli_fetch_array($sewing_jobratio_sizes_result)) 
										{
											$parent_id = $sewing_jobratio_color_details['parent_id'];
											$color = $sewing_jobratio_color_details['color'];
											$size = $sewing_jobratio_color_details['size'];
											$color1 = explode(",",$color);
											$size1 = explode(",",$size);
											// var_dump($size);
										}
										for ($i=0; $i < sizeof($size1); $i++)
										{
											$Original_size_query = "SELECT DISTINCT size_title FROM `brandix_bts`.`tbl_orders_sizes_master` WHERE parent_id = $sch_id AND ref_size_name=$size1[$i]";
											// echo $Original_size_query;
											$Original_size_result=mysqli_query($link, $Original_size_query) or exit("Error while getting Qty Details");
											while($Original_size_details=mysqli_fetch_array($Original_size_result)) 
											{
												$Ori_size = $Original_size_details['size_title'];
											}
											echo "<th>".$Ori_size."</th>";
										}
										echo "</tr>";
										for ($j=0; $j < sizeof($color1); $j++)
										{
											echo "<tr>
													<td>$color1[$j]</td>";
													for ($i=0; $i < sizeof($size1); $i++)
													{
														$qty_query = "SELECT quantity FROM $brandix_bts.`tbl_carton_size_ref` WHERE ref_size_name=$size1[$i] AND parent_id=$parent_id AND color='".$color1[$j]."'";
														// echo $qty_query;
														$qty_query_result=mysqli_query($link, $qty_query) or exit("Error while getting Qty Details");
														while($qty_query_details=mysqli_fetch_array($qty_query_result)) 
														{
															$qty = $qty_query_details['quantity'];
															if ($qty == '') {
																$qty=0;
															}
															echo "<td>".$qty.'</td>';
														}
													}
											echo "</tr>";
										}
										echo "</table></div>";
									}
									// Poly Bag Ratio Details End

									// Poly Bags per Carton Start
									{
										if ($pack_method == 3 || $pack_method == 4)
										{
											$poly_bags_per_carton_query = "SELECT distinct(poly_bags_per_carton) as poly_bags_per_carton FROM $brandix_bts.`tbl_carton_size_ref` WHERE parent_id=$c_ref";
											// echo $poly_bags_per_carton_query;
											$poly_bags_per_carton_result=mysqli_query($link, $poly_bags_per_carton_query) or exit("Error while getting poly_bags_per_carton Details");
											while($poly_bags_per_carton_details=mysqli_fetch_array($poly_bags_per_carton_result)) 
											{
												echo "<br><div class='col-md-4'>
															<table class=\"table table-bordered\">
																<tr><th>Number of Poly Bags Per Carton:</th><th>".$poly_bags_per_carton_details['poly_bags_per_carton']."</th>
																</tr>
															</table>
														</div>";
											}
											echo "<br><br>";
										}
										else if ($pack_method == 1 || $pack_method == 2)
										{
											$poly_bags_per_carton=array();
											$size_title=array();
											$poly_bags_per_carton_query = "SELECT poly_bags_per_carton,size_title FROM $brandix_bts.`tbl_carton_size_ref` WHERE parent_id=$c_ref GROUP BY size_title ORDER BY ref_size_name";
											// echo $poly_bags_per_carton_query;
											$poly_bags_per_carton_result=mysqli_query($link, $poly_bags_per_carton_query) or exit("Error while getting poly_bags_per_carton Details");
											while($poly_bags_per_carton_details=mysqli_fetch_array($poly_bags_per_carton_result)) 
											{
												$poly_bags_per_carton[]=$poly_bags_per_carton_details['poly_bags_per_carton'];
												$size_title[]=$poly_bags_per_carton_details['size_title'];
											}

											echo "<br><div class='col-md-12'><b>Number of Poly Bags Per Carton: </b>
											<table class=\"table table-bordered\">
												<tr>";
												for ($i=0; $i < sizeof($size_title); $i++)
												{ 
													echo "<th>$size_title[$i]</th>";
												}
												echo "</tr><tr>";
												for ($i=0; $i < sizeof($poly_bags_per_carton); $i++)
												{ 
													echo "<td>$poly_bags_per_carton[$i]</td>";
												}
												echo "</tr>
											</table></div>";
										}				
									}
									// Poly Bags per Carton end

									// Garments Per Carton Start
									{
										echo "
											<div class='col-md-12'><b>Garments Per Carton: </b>
												<div class='table-responsive'>
													<table class=\"table table-bordered\">
														<tr>
															<th>Color</th>
															<th>Combo</th>";
															// Display Sizes
															for ($i=0; $i < sizeof($size_main); $i++)
															{
																echo "<th>".$size_main[$i]."</th>";
															}
														echo "</tr>";
														// Display Textboxes
														$row_count=0;
														for ($j=0; $j < sizeof($color_main); $j++)
														{
															echo "<tr>
																	<td>$color_main[$j]</td>";
																	$combo_count=0;
																	for ($size_count=0; $size_count < sizeof($size_main); $size_count++)
																	{
																		$individual_sizes_query = "SELECT size_title FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style_id AND product_schedule=$schedule) AND order_col_des='".$color_main[$j]."'  AND size_title='".$size_main[$size_count]."'";
																		// echo $individual_sizes_query.'<br>';
																		$individual_sizes_result=mysqli_query($link, $individual_sizes_query) or exit("Error while getting individual size Details");
																		while($individual_sizes_details=mysqli_fetch_array($individual_sizes_result)) 
																		{
																			$individual_color = $individual_sizes_details['size_title'];
																		}

																		$get_combo_query = "SELECT distinct(combo_no) FROM $brandix_bts.`tbl_carton_size_ref` WHERE size_title='$size_main[$size_count]' AND parent_id=$c_ref AND color='".$color_main[$j]."'";
																		// echo '<br>'.$get_combo_query;
																		$combo_query_result=mysqli_query($link, $get_combo_query) or exit("Error while getting combo Details");
																		while($combo_query_details=mysqli_fetch_array($combo_query_result)) 
																		{
																			$comboNO = $combo_query_details['combo_no'];
																		}
																		$qty_query = "SELECT group_concat(garments_per_carton) as garments_per_carton FROM $brandix_bts.`tbl_carton_size_ref` WHERE size_title='$size_main[$size_count]' AND parent_id=$c_ref AND color='".$color_main[$j]."'";
																		// echo '<br>'.$qty_query;
																		$qty_query_result=mysqli_query($link, $qty_query) or exit("Error while getting Qty Details");
																		while($qty_query_details=mysqli_fetch_array($qty_query_result)) 
																		{
																			$qty = $qty_query_details['garments_per_carton'];
																			// $comboNO = $qty_query_details['combo_no'];
																			if ($qty == '') {
																				$qty=0;
																			}
																			if ($combo_count == 0) {
																				echo "<td>$comboNO</td>";
																				$combo_count++;
																			}
																			if ($pack_method == 1 || $pack_method == 4)
																			{
																				$gar_per_cart_id = "'GarPerCart_".$size_count."_".$comboNO."'";
																			}
																			if ($pack_method == 3 || $pack_method == 2)
																			{
																				$combo_count_query = "SELECT DISTINCT(combo_no) FROM $brandix_bts.tbl_carton_size_ref WHERE parent_id=$c_ref";
																				// echo '<br>'.$combo_count_query;
																				$como_count_result=mysqli_query($link, $combo_count_query) or exit("Error while getting combo count Details");
																				if(mysqli_num_rows($como_count_result) > 1)
																				{
																					$gar_per_cart_id = "'GarPerCart_".$size_count."_".$comboNO."'";
																				}
																				else
																				{
																					$gar_per_cart_id = "'GarPerCart_".$size_count."_".$comboNO."_".$j."'";
																				}
																			}
																			if (mysqli_num_rows($individual_sizes_result) >0)
																			{
																				if ($size_main[$size_count] == $individual_color)
																				{
																					echo "<td><input type='text'  readonly name='GarPerCart[$j][]' id=$gar_per_cart_id class='form-control integer' value='".$qty."'></td>";
																				}
																			}
																			else
																			{
																				echo "<td><input type='hidden' readonly name='GarPerCart[$j][]' id=$gar_per_cart_id value='0' /></td>";
																			}
																		}
																		
																	}
															echo "</tr>";
															$row_count++;
														}
													echo "</table>
												</div>
											<div>
										";
									}
									// Garments Per Carton End


									if(in_array($authorized,$has_permission))
									{

										// echo $val."--".$val1."<br>";						

										echo '<form name="input" method="post" action="'.getFullURL($_GET['r'],'sewing_job_create_mrn.php','N').'">';
											$comboSize = sizeof($combo);
											echo  "<input type=\"hidden\" value=\"$style_id\" id=\"style_id\" name=\"style_id\">";
											echo  "<input type=\"hidden\" value=\"$sch_id\" id=\"sch_id\" name=\"sch_id\">";
											echo  "<input type=\"hidden\" value=\"$pack_method\" id=\"pack_method\" name=\"pack_method\">";
											echo  "<input type=\"hidden\" value=\"$c_ref\" id=\"c_ref\" name=\"c_ref\">";
											echo  "<input type=\"hidden\" value=\"$comboSize\" id=\"comboSize\" name=\"comboSize\">";
											echo  "<input type=\"hidden\" value=\"$val\" id=\"size_of_colors\" name=\"size_of_colors\">";
											// Combo wise no of cartons start
											{
												echo "<div class='col-md-12'>
													<table class='table table-bordered'>
														<tr>
															<th>Combo</th>
															<th>No of Cartons</th>";
															if($scanning_methods=='Bundle Level')
															{
															  echo "<th>Garments Per Bundle</th>";	
															}	
														echo "</tr>";
														

														for ($i=0; $i < sizeof($combo); $i++)
														{
															$get_combo_color_query = "SELECT GROUP_CONCAT(DISTINCT color) AS color FROM `brandix_bts`.`tbl_carton_size_ref` WHERE parent_id = $c_ref  AND combo_no = $combo[$i]";
															$combo_color_result=mysqli_query($link, $get_combo_color_query) or exit("Error while getting Combo Details");
															while($combo_color_details=mysqli_fetch_array($combo_color_result)) 
															{
																$combo_color = $combo_color_details['color'];
															}
															echo "<tr>
																<td>$combo[$i]</td>";
																if ($pack_method == 1 || $pack_method == 4)
																{
																	$onchange_fun = "pack_method_1_4_fun($sizeofsizes,$combo[$i]);";
																}
																if ($pack_method == 2 || $pack_method == 3)
																{
																	$combo_count_query = "SELECT DISTINCT(combo_no) FROM $brandix_bts.tbl_carton_size_ref WHERE parent_id=$c_ref";
																	// echo '<br>'.$combo_count_query;
																	$como_count_result=mysqli_query($link, $combo_count_query) or exit("Error while getting combo count Details");
																	if(mysqli_num_rows($como_count_result) > 1)
																	{
																		$onchange_fun = "pack_method_1_4_fun($sizeofsizes,$combo[$i]);";
																	}
																	else
																	{
																		$onchange_fun = "pack_method_2_3_fun($sizeofsizes,$combo[$i],$val);";
																	}																
																}
																echo "<input type='hidden' name=combo[] value='".$combo[$i]."'>
																<td><input type='text' required name='no_of_cartons[]' onkeyup=$onchange_fun id='no_of_cartons_$combo[$i]' class='form-control integer' value=''></td>
																";
																if($scanning_methods=='Bundle Level')
																{
																	echo"<td><input type='text' name='split_qty[]' required id='split_qty_$combo[$i]' class='form-control integer' value='-1'></td>";
																}
																else
																{
																	echo"<input type='hidden' name='split_qty[]' required id='split_qty_$combo[$i]' class='form-control integer' value='0'>";
																}
															echo "</tr>";
														}	
												echo "</table></div>";
											}
											// Combo wise no of cartons end
											// Sewing Job Qty Start
											{
												echo "<br>
													<div class='col-md-12'><b>Sewing Job Qty: </b>
														<table class=\"table table-bordered\">
															<tr>
																<th>Color</th>
																<th>Combo</th>";
																	for ($i=0; $i < sizeof($size_main); $i++)
																	{
																		echo "<th>".$size_main[$i]."</th>";
																	}
															echo "</tr>";
															$row_count=0;
															for ($j=0; $j < sizeof($color_main); $j++)
															{
																echo "<tr>";
																		echo "<td>$color_main[$j]</td>";
																		$combo_count=0;
																		for ($size_count=0; $size_count < sizeof($size_main); $size_count++)
																		{
																			$individual_sizes_query = "SELECT size_title FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style_id AND product_schedule=$schedule) AND order_col_des='".$color_main[$j]."' AND size_title='".$size1[$size_count]."'";
																			// echo $individual_sizes_query.'<br>';
																			$individual_sizes_result=mysqli_query($link, $individual_sizes_query) or exit("Error while getting individual size Details");
																			while($individual_sizes_details=mysqli_fetch_array($individual_sizes_result)) 
																			{
																				$individual_color = $individual_sizes_details['size_title'];
																			}

																			$qty_query = "SELECT distinct(combo_no) FROM $brandix_bts.`tbl_carton_size_ref` WHERE size_title='$size_main[$size_count]' AND parent_id=$c_ref AND color='".$color_main[$j]."'";
																			// echo '<br>'.$qty_query;
																			$qty_query_result=mysqli_query($link, $qty_query) or exit("Error while getting Qty Details");
																			while($qty_query_details=mysqli_fetch_array($qty_query_result)) 
																			{
																				$comboNO = $qty_query_details['combo_no'];
																			}

																			if($combo_count == 0) 
																			{
																				echo "<td>$comboNO</td>";
																				$combo_count++;
																			}

																			if ($pack_method == 1 || $pack_method == 4)
																			{
																				$sew_job_qty_id = "'SewingJobQty_".$size_count."_".$comboNO."'";
																			}
																			if ($pack_method == 2 || $pack_method == 3)
																			{
																				$combo_count_query = "SELECT DISTINCT(combo_no) FROM $brandix_bts.tbl_carton_size_ref WHERE parent_id=$c_ref";
																				// echo '<br>'.$combo_count_query;
																				$como_count_result=mysqli_query($link, $combo_count_query) or exit("Error while getting combo count Details");
																				if(mysqli_num_rows($como_count_result) > 1)
																				{
																					$sew_job_qty_id = "'SewingJobQty_".$size_count."_".$comboNO."'";
																				}
																				else
																				{
																					$sew_job_qty_id = "'SewingJobQty_".$size_count."_".$comboNO."_".$j."'";
																				}														
																			}
 
																			echo "<td><input type='text' readonly='true' name='SewingJobQty[$j][]' id=$sew_job_qty_id class='form-control integer' value='0'></td>";
																		}
																echo "</tr>";
																$row_count++;
															}
														echo "</table>
													</div>
												";
											}
											// Sewing Job Qty End
											// var_dump($combo);
											echo "<div class='col-md-2'>
												<table class='table table-bordered'>
													<tr>
														<th style='display: none;'><center>Mix Cut Jobs</center></th>
														<th style='display: none;'><center>Excess From</center></th>
														<th><center>Control</center></th>
													</tr>
													<tr>
														<td style='display: none;'>
															<center>
																<select name='mix_jobs' id='mix_jobs' class='form-control'>
																	<option value=''>Please Select</option>
																	<option value='1'>Yes</option>
																	<option value='2' selected>No</option>
																</select>
															</center>
														</td>
														<td style='display: none;'>
															<center>
																<select name='exces_from' id='exces_from' class='form-control'>
																	<option value=''>Please Select</option>
																	<option value='1'>First Cut</option>
																	<option value='2'>Last Cut</option>
																</select>
															<center>
														</td>
														<td>
															<center>";
														$count = 0;
														for ($i=0; $i < $sizeofsizes; $i++)
														{
															if ($ordered_qty[$i] > $planned_qty[$i]) 
															{
																$flag = 1;
																$count = $count + $flag;
															}
														}
														if ($count > 0)
														{
															echo '<b><font color="red">Please Prepare Lay Plan for Complete Order Quantity</font></b>';
														}
														else {
															echo "<input type=\"submit\" class=\"btn btn-success\" value=\"Generate\" name=\"generate\" id=\"generate\" />";
															echo "<span id=\"msg1\" style=\"display:none;\"><h5>Please Wait..Sewing Job Generating.<h5></span>";
															// echo "<input type=\"submit\" class=\"btn btn-success\" value=\"Generate\" name=\"generate\" id=\"generate\" />";
														}
														echo "</center></td>
													</tr>
												</table>
											</div>";
										echo "</form>";
									} 
									else {
										echo "<br><div class='alert alert-danger'>You are Not Authorized to Generate Sewing Jobs</div>";
									}
								}
															
								if($bundle > 0)
								{									
									include("input_job_mix_ch_report_mrn.php");
								}
							}
							else
							{							
								echo "<script>sweetAlert('Please Update Packing Ratio ','Before Creating Sewing Jobs!','warning');</script>";
							}
						}

					}
				}
				if(isset($_POST['generate']))
				{
					$split_qty=$_POST['split_qty'];
					$no_of_cartons=$_POST['no_of_cartons'];
					$style_id=$_POST['style_id'];
					$sch_id=$_POST['sch_id'];
					$pack_method=$_POST['pack_method'];

					$sum = array_sum($no_of_cartons);
					if ($sum>0)
					{
						$merge_status=$_POST['mix_jobs'];
						// $exces_from=$_POST['exces_from'];
						$c_ref=$_POST['c_ref'];
						$combo=$_POST['combo'];
						
						$sql="update $brandix_bts.`tbl_carton_ref` set exces_from='0', merge_status='".$merge_status."' where id='".$c_ref."'";
						// echo $sql."<br>";
						mysqli_query($link, $sql) or exit("Failed to update Carton Details");
						for ($i=0; $i < sizeof($combo); $i++)
						{
							if ($split_qty[$i] == '')
							{
								$split_qty[$i]=0;
							}
							$sql="update $brandix_bts.`tbl_carton_size_ref` set split_qty='".$split_qty[$i]."', no_of_cartons='".$no_of_cartons[$i]."'  where parent_id='".$c_ref."' and combo_no = $combo[$i]";
							// echo $sql."<br>";
							mysqli_query($link, $sql) or exit("Failed to update Carton Details1");
						}
						
						
						echo "<h2>Sewing orders Generation under process Please wait.....<h2>";
						$url5 = getFullURLLevel($_GET['r'],'mini_order_gen_v2.php',0,'N');
						echo "<script>location.href = '".$url5."&id=$c_ref';</script>";
					}
					else
					{
						echo "<script>sweetAlert('Number of Cartons is Zero','Cannot create Sewing Jobs','warning');</script>";
						$url5 = getFullURLLevel($_GET['r'],'sewing_job_create1.php',0,'N');
						echo "<script>location.href = '".$url5."&style=$style_id&schedule=$sch_id';</script>";
					}
				}
			?> 
		</div>
	</div>
</div>