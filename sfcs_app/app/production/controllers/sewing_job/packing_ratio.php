<script language="javascript" type="text/javascript">

	function calculateqty(size_count,sizeOfColors)
	{
		for (var row_count = 0; row_count < sizeOfColors; row_count++)
		{
			var GarPerBag=document.getElementById('GarPerBag_'+row_count+'_'+size_count).value;
			var BagPerCart=document.getElementById('BagPerCart_'+size_count).value;
			var GarPerCart = Number(GarPerBag)*Number(BagPerCart);
			document.getElementById('GarPerCart_'+row_count+'_'+size_count).value = GarPerCart;
		}
	}

	function calculateqty1(sizeofsizes,sizeOfColors)
	{
		var total=0;
		for (var row_count = 0; row_count < sizeOfColors; row_count++)
		{
			for(var size=0;size < sizeofsizes; size++)
			{
				var GarPerBag=document.getElementById('GarPerBag_'+row_count+'_'+size).value;
				var BagPerCart=document.getElementById('BagPerCart').value;
				var GarPerCart = GarPerBag*BagPerCart;
				document.getElementById('GarPerCart_'+row_count+'_'+size).value=GarPerCart;
				total = total+GarPerCart;
			}
			document.getElementById('total_'+row_count).value=total;
			total=0;
		}
	}

	function firstbox()
	{
		var url1 = '<?= getFullUrl($_GET['r'],'packing_ratio.php','N'); ?>';
		window.location.href =url1+"&style="+document.packing_ratio.style.value;
	}

	function check_val()
	{
		var style=document.getElementById("style").value;
		var schedule=document.getElementById("schedule").value;
		var pack_method=document.getElementById("pack_method").value;

		if(style=='NIL' || schedule=='NIL' || pack_method=='0')
		{
			sweetAlert('Please Select the Values','','warning');
			return false;
		}
		else
		{
			return true;
		}
	}
</script>
<style>
	table, th, td {
		text-align: center;
	}
</style>
<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	$has_permission=haspermission($_GET['r']);

	if(isset($_POST['style']))
	{
		$style=$_POST['style'];
		$schedule=$_POST['schedule'];
		$pack_method=$_POST['pack_method'];
	}
	else
	{
		$style=$_GET['style'];
		$schedule=$_GET['schedule'];
		$pack_method=$_GET['pack_method'];
	}

?>

	
<div class="panel panel-primary">
	<div class="panel-heading"><strong>Packing Ratio</strong></div>
	<div class="panel-body">
		<div class="col-md-12">
			<form method="POST" class="form-inline" name="packing_ratio" action="index.php?r=<?php echo $_GET['r']; ?>">
				<label>Style:</label>
				<?php
					// Style
					echo "<select name=\"style\" id=\"style\"  class='form-control' onchange=\"firstbox();\">";
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
				&nbsp;&nbsp;
				<label>Schedule:</label>
				<?php
					echo "<select class='form-control' name='schedule' id='schedule'>";
					$sql="select id,product_schedule as schedule from $brandix_bts.tbl_orders_master where ref_product_style=\"$style\" group by schedule";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check=mysqli_num_rows($sql_result);
					echo "<option value=\"NIL\" selected>Select Schedule</option>";
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$schedule))
						{
							echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['schedule']."</option>";
						}
						else
						{
							echo "<option value=\"".$sql_row['id']."\">".$sql_row['schedule']."</option>";
						}
					}
					echo "</select>";
				?>
				&nbsp;&nbsp;
				<label>Pack Method:</label>
				<?php 
				echo "<select id=\"pack_method\" class='form-control' name=\"pack_method\" >";
				for($j=0;$j<sizeof($operation);$j++)
				{
					$selected='';
					if ($pack_method == $j)
					{
						$selected='selected';
					}
					echo "<option value=\"".$j."\" $selected>".$operation[$j]."</option>";
				}
				echo "</select>";
				?>
				<input type="submit" name="submit" id="submit" class="btn btn-success" onclick="return check_val();" value="Submit">
				</form>
		</div>

				
		<?php
			if (isset($_POST["submit"]) or ($_GET['style'] and $_GET['schedule'] and $_GET['pack_method']))
			{
				if ($_GET['style'] and $_GET['schedule']) {
					$style_code=$_GET['style'];
					$schedule=$_GET['schedule'];
					$pack_method=$_GET['pack_method'];
				} else if ($_POST['style'] and $_POST['schedule']){
					$style_code=$_POST['style'];
					$schedule=$_POST['schedule'];	
					$pack_method=$_POST['pack_method'];	
				}
				// echo $style_code.'<br>'.$schedule.'<br>'.$pack_method.'<br>';
				$c_ref = echo_title("$brandix_bts.tbl_carton_ref","id","ref_order_num",$schedule,$link);
				$schedule_original = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
				$valid_result = echo_title("$brandix_bts.tbl_carton_ref","COUNT(*)","carton_barcode",$schedule_original,$link);
				$updated_carton_method = echo_title("$brandix_bts.tbl_carton_ref","carton_method","carton_barcode",$schedule_original,$link);
				if ($valid_result > 0)
				{
					echo "<script>sweetAlert('Packing Ratio Already Updated for this Schedule - $schedule_original','Go to Sewing Job Creation','warning')</script>";
					echo '<br><br><br><div class="col-md-12"><h4>Pack Method: <span class="label label-info">'.$operation[$updated_carton_method].'</span></h4></div>';
					$sewing_jobratio_sizes_query = "SELECT parent_id,GROUP_CONCAT(DISTINCT color) AS color, GROUP_CONCAT(DISTINCT ref_size_name) AS size FROM $brandix_bts.tbl_carton_size_ref WHERE parent_id IN (SELECT id FROM $brandix_bts.tbl_carton_ref WHERE ref_order_num=$schedule AND style_code=$style_code)";
					$sewing_jobratio_sizes_result=mysqli_query($link, $sewing_jobratio_sizes_query) or exit("Error while getting Job Ratio Details");
					echo "<br><div class='col-md-12'><b>Garments Per Poly Bag: </b>
					<div class='table-responsive'>
						<table class=\"table table-bordered\">
							<tr class='info'>
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
					// GArments per Poly Bag Details Start
					{
						
						for ($i=0; $i < sizeof($size1); $i++)
						{
							$Original_size_query = "SELECT DISTINCT size_title FROM `brandix_bts`.`tbl_orders_sizes_master` WHERE parent_id = $schedule AND ref_size_name=$size1[$i]";
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
						echo "</table></div></div>";
					}
					// GArments per Poly Bag Details End

					// Poly Bags per Carton Start
					{
						if ($updated_carton_method == 3 || $updated_carton_method == 4)
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
						else if ($updated_carton_method == 1 || $updated_carton_method == 2)
						{
							$poly_bags_per_carton=array();
							$size_title=array();
							$poly_bags_per_carton_query = "SELECT poly_bags_per_carton,size_title FROM $brandix_bts.`tbl_carton_size_ref` WHERE parent_id=$c_ref GROUP BY size_title DESC";
							// echo $poly_bags_per_carton_query;
							$poly_bags_per_carton_result=mysqli_query($link, $poly_bags_per_carton_query) or exit("Error while getting poly_bags_per_carton Details");
							while($poly_bags_per_carton_details=mysqli_fetch_array($poly_bags_per_carton_result)) 
							{
								$poly_bags_per_carton[]=$poly_bags_per_carton_details['poly_bags_per_carton'];
								$size_title[]=$poly_bags_per_carton_details['size_title'];
							}

							echo "<br><div class='col-md-12'><b>Number of Poly Bags Per Carton: </b>
							<div class='table-responsive'>
							<table class=\"table table-bordered\">
								<tr class='info'>";
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
							</table></div></div>";
						}				
					}
					// Poly Bags per Carton end

					// Garments Per Carton Start
					{
						$sewing_jobratio_sizes_query = "SELECT GROUP_CONCAT(DISTINCT size_title) AS size, GROUP_CONCAT(DISTINCT order_col_des) AS color FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN ($schedule)";
						// echo $sewing_jobratio_sizes_query.'<br>';
						$sewing_jobratio_sizes_result=mysqli_query($link, $sewing_jobratio_sizes_query) or exit("Error while getting Job Ratio Details");
						while($sewing_jobratio_color_details=mysqli_fetch_array($sewing_jobratio_sizes_result)) 
						{
							$parent_id = $sewing_jobratio_color_details['parent_id'];
							$color = $sewing_jobratio_color_details['color'];
							$ref_size = $sewing_jobratio_color_details['size'];
							$color1 = explode(",",$color);
							$size1 = explode(",",$ref_size);
							// var_dump($size);
						}
						echo "
							<div class='col-md-12'><b>Garments Per Carton: </b>
								<div class='table-responsive'>
									<table class=\"table table-bordered\">
										<tr class='info'>
											<th>Color</th>";
											// Display Sizes
											for ($i=0; $i < sizeof($size1); $i++)
											{
												echo "<th>".$size1[$i]."</th>";
											}
										echo "</tr>";
										// Display Textboxes
										$row_count=0;
										for ($j=0; $j < sizeof($color1); $j++)
										{
											echo "<tr>
													<td>$color1[$j]</td>";
													for ($size_count=0; $size_count < sizeof($size1); $size_count++)
													{
														$individual_sizes_query = "SELECT size_title FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style_code AND product_schedule=$schedule_original) AND order_col_des='".$color1[$j]."'  AND size_title='".$size1[$size_count]."'";
														// echo $individual_sizes_query.'<br>';
														$individual_sizes_result=mysqli_query($link, $individual_sizes_query) or exit("Error while getting individual size Details");
														while($individual_sizes_details=mysqli_fetch_array($individual_sizes_result)) 
														{
															$individual_color = $individual_sizes_details['size_title'];
														}

														$qty_query = "SELECT garments_per_carton FROM $brandix_bts.`tbl_carton_size_ref` WHERE size_title='$size1[$size_count]' AND parent_id=$c_ref AND color='".$color1[$j]."'";
														// echo '<br>'.$qty_query.'<br>';
														$qty_query_result=mysqli_query($link, $qty_query) or exit("Error while getting Qty Details");
														while($qty_query_details=mysqli_fetch_array($qty_query_result)) 
														{
															$qty = $qty_query_details['garments_per_carton'];
															if ($qty == '') {
																$qty=0;
															}
															if (mysqli_num_rows($individual_sizes_result) >0)
															{
																if ($size1[$size_count] == $individual_color) {
																	echo "<td>".$qty."</td>";
																}
															}
															else
															{
																echo "<td>".$qty."</td>";
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
				}
				else
				{
					$o_colors = echo_title("$bai_pro3.bai_orders_db","group_concat(distinct order_col_des order by order_col_des)","bai_orders_db.$order_joins_not_in AND order_del_no",$schedule_original,$link);	
					$p_colors = echo_title("$brandix_bts.tbl_orders_sizes_master","group_concat(distinct order_col_des order by order_col_des)","parent_id",$schedule,$link);
					if($o_colors<>'')
					{
						$order_colors=explode(",",$o_colors);
						$size_of_ordered_colors=sizeof($order_colors);
					}
					else
					{
						$size_of_ordered_colors=0;
					}              
					if($p_colors<>'')
					{
						$planned_colors=explode(",",$p_colors);
						$size_of_planned_colors=sizeof($planned_colors);
					}
					else
					{
						$size_of_planned_colors=0;
					}

					// echo 'order_colors: '.$size_of_ordered_colors.'<br>planned: '.$size_of_planned_colors;

					if ($size_of_ordered_colors!=$size_of_planned_colors)
					{
						echo "<script>sweetAlert('Please prepare Lay Plan for all Colors in this Schedule - $schedule_original','','warning')</script>";
					}
					else
					{
						$sewing_jobratio_sizes_query = "SELECT GROUP_CONCAT(DISTINCT order_col_des) AS color, GROUP_CONCAT(DISTINCT size_title) AS size FROM $brandix_bts.tbl_orders_sizes_master WHERE parent_id IN ($schedule)";
						// echo $sewing_jobratio_sizes_query;
						$sewing_jobratio_sizes_result=mysqli_query($link, $sewing_jobratio_sizes_query) or exit("Error while getting Job Ratio Details");
						while($sewing_jobratio_color_details=mysqli_fetch_array($sewing_jobratio_sizes_result)) 
						{
							$color = $sewing_jobratio_color_details['color'];
							$size = $sewing_jobratio_color_details['size'];
							$color1 = explode(",",$color);
							$size1 = explode(",",$size);
							// var_dump($size);
							// var_dump($color);
						}
						echo "<br><br><br>";
						if ($pack_method==1 or $pack_method==2 or $_GET['pack_method']==1 or $_GET['pack_method']==2)
						{
							if ($pack_method==1)
							{
								$title = "Single Color Single Size";
								$combo='NO';
							} else {
								$title = "Multi Color Single Size";
								$combo='YES';
							}
							echo '<form method="POST" class="form-inline" name="SS_MS" action="#">';
								echo "<input type='hidden' name='style' id='style' value='".$style_code."' />";
								echo "<input type='hidden' name='schedule' id='schedule' value='".$schedule."' />";
								echo "<input type='hidden' name='schedule_original' id='schedule' value='".$schedule_original."' />";
								echo "<input type='hidden' name='pack_method' id='pack_method' value='".$pack_method."' />";
								echo "<input type='hidden' name='size1' id='size1' value='".$size1."' />";
								echo "<div class='panel panel-primary'>";
									echo "<div class='panel-heading'>$title</div>";
									echo "<div class='panel-body'>";
										//first table
										echo "<div class='panel panel-primary'>";
												echo "<div class='panel-heading'>Number of Garments Per Poly Bag</div>
												<div class='panel-body'>
													<div class='table-responsive'>
														<table class=\"table table-bordered\">
															<tr class='info'>
																<th>Color</th>";
																// Display Sizes
																for ($i=0; $i < sizeof($size1); $i++)
																{
																	echo "<th>".$size1[$i]."</th>";
																	echo "<input type='hidden' name=size[] value='".$size1[$i]."'>";
																}
																echo "<th>Combo</th>
															</tr>";
															// Display Textboxes
															echo "<input type='hidden' name='noOfSizes' id='noOfSizes' value='".sizeof($color1)."' />";
															$row_count=0;
															for ($j=0; $j < sizeof($color1); $j++)
															{
																if ($combo=='YES') {
																	$combo_value=1;
																	$readonly = '';
																} else if ($combo=='NO') {
																	$combo_value=$j+1;
																	$readonly = 'readonly';
																}
																// echo $combo_value;
																echo "<tr>
																		<td>$color1[$j]</td>
																		<input type='hidden' name=color[] value='".$color1[$j]."'>";
																		for ($size_count=0; $size_count < sizeof($size1); $size_count++)
																		{
																			$individual_sizes_query = "SELECT size_title FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style_code AND product_schedule=$schedule_original) AND order_col_des='".$color1[$j]."' AND size_title='".$size1[$size_count]."'";
																			// echo $individual_sizes_query.'<br>';
																			$individual_sizes_result=mysqli_query($link, $individual_sizes_query) or exit("Error while getting individual size Details");
																			while($individual_sizes_details=mysqli_fetch_array($individual_sizes_result)) 
																			{
																				$individual_color = $individual_sizes_details['size_title'];
																			}
																			if (mysqli_num_rows($individual_sizes_result) >0)
																			{
																				if ($size1[$size_count] == $individual_color) {
																					echo "<td><input type='text' size='6' maxlength='5' required name='GarPerBag[$j][]' id='GarPerBag_".$row_count."_".$size_count."' class='form-control integer' onkeyup=calculateqty($size_count,$size_of_ordered_colors); value=''></td>";
																				}
																			}
																			else
																			{
																				echo "<td><input type='hidden' name='GarPerBag[$j][]' id='GarPerBag_".$row_count."_".$size_count."' value='0' /></td>";
																			}																
																		}
																		echo "<td><input type='text' size='6' maxlength='5' required name='combo[]' id='combo' class='form-control integer' value='".$combo_value."' $readonly></td>
																	</tr>";
																$row_count++;
															}
														echo "</table>
													</div>
												</div>
											</div>";
										
										//second table
										echo "<div class='panel panel-primary'>
												<div class='panel-heading'>Number of Poly Bags Per Carton</div>
												<div class='panel-body'>
													<input type='hidden' name='size_size1' id='size_size1' value='".sizeof($size1)."' />
													<div class='table-responsive'>
														<table class='table table-bordered'>
															<tr class='info'>";
																// Show Sizes
																for ($i=0; $i < sizeof($size1); $i++)
																{
																	echo "<th>".$size1[$i]."</th>";
																}
															echo "</tr>";
															echo "<tr>";
																for ($size_count=0; $size_count < sizeof($size1); $size_count++)
																{
																	echo "<td><input type='text' size='6' maxlength='5' required name='BagPerCart[]' id='BagPerCart_".$size_count."' class='form-control integer' onkeyup=calculateqty($size_count,$size_of_ordered_colors);></td>";
																}
															echo "</tr>
														</table>
													</div>
												</div>
											</div>";
										
										//third table	
										echo "<div class='panel panel-primary'>
												<div class='panel-heading'>Number of Garments Per Carton</div>
												<div class='panel-body'>
													<div class='table-responsive'>
														<table class=\"table table-bordered\">
															<tr class='info'>
																<th>Color</th>";
																	for ($i=0; $i < sizeof($size1); $i++)
																	{
																		echo "<th>".$size1[$i]."</th>";
																	}
															echo "</tr>";
															$row_count=0;
															for ($j=0; $j < sizeof($color1); $j++)
															{
																echo "<tr>";
																		echo "<td>$color1[$j]</td>";
																		for ($size_count=0; $size_count < sizeof($size1); $size_count++)
																		{
																			$individual_sizes_query = "SELECT size_title FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style_code AND product_schedule=$schedule_original) AND order_col_des='".$color1[$j]."' AND size_title='".$size1[$size_count]."'";
																			// echo $individual_sizes_query.'<br>';
																			$individual_sizes_result=mysqli_query($link, $individual_sizes_query) or exit("Error while getting individual size Details");
																			while($individual_sizes_details=mysqli_fetch_array($individual_sizes_result)) 
																			{
																				$individual_color = $individual_sizes_details['size_title'];
																			}
																			if (mysqli_num_rows($individual_sizes_result) >0)
																			{
																				if ($size1[$size_count] == $individual_color) {
																					echo "<td><input type='text' size='6' maxlength='5' required readonly='true' name='GarPerCart[$j][]' id='GarPerCart_".$row_count."_".$size_count."' class='form-control integer' value=''></td>";
																				}
																			}
																			else 
																			{
																				echo "<td><input type='hidden' readonly='true' name='GarPerCart[$j][]' id='GarPerCart_".$row_count."_".$size_count."' class='form-control integer' value='0'></td>";
																			}
																			
																		}
																echo "</tr>";
																$row_count++;
															}
														echo "</table>
													</div>
												</div>
											</div>";
										echo "<input type='submit' class='btn btn-success confirm-submit' name='SS_MS_save' id='SS_MS_save' value='Save' />
									</div>
								</div>
							</form>";
						}
						if ($pack_method==3 or $pack_method==4)
						{
							if ($pack_method==3)
							{
								$title = "Multi Color Multi Size";
								$combo='YES';
							} else {
								$title = "Single Color Multi Size";
								$combo='NO';
							}
							echo '<form method="POST" class="form-inline" name="MM_SM" action="#">';
								echo "<input type='hidden' name='style' id='style' value='".$style_code."' />";
								echo "<input type='hidden' name='schedule' id='schedule' value='".$schedule."' />";
								echo "<input type='hidden' name='schedule_original' id='schedule' value='".$schedule_original."' />";
								echo "<input type='hidden' name='pack_method' id='pack_method' value='".$pack_method."' />";
								echo "<input type='hidden' name='size1' id='size1' value='".$size1."' />";
								echo "<div class='panel panel-primary'>";
									echo "<div class='panel-heading'>$title</div>";
									echo "<div class='panel-body'>";
										//first table
										echo "<div class='panel panel-primary'>";
												echo "<div class='panel-heading'>Number of Garments Per Poly Bag</div>
												<div class='panel-body'>
													<div class='table-responsive'>
														<table class=\"table table-bordered\">
															<tr class='info'>
																<th>Color</th>";
																// Display Sizes
																$sizeofsizes=sizeof($size1);
																for ($i=0; $i < sizeof($size1); $i++)
																{
																	echo "<th>".$size1[$i]."</th>";
																	echo "<input type='hidden' name=size[] value='".$size1[$i]."'>";
																}
																echo "<th>Combo</th>";
															echo "</tr>";
															// Display Textboxes
															echo "<input type='hidden' name='noOfSizes' id='noOfSizes' value='".sizeof($color1)."' />";
															$row_count=0;
															for ($j=0; $j < sizeof($color1); $j++)
															{
																if ($combo=='YES') {
																	$combo_value=1;
																	$readonly = '';
																} else if ($combo=='NO') {
																	$combo_value=$j+1;
																	$readonly = 'readonly';
																}
																echo "<tr>
																		<td>$color1[$j]</td>
																		<input type='hidden' name=color[] value='".$color1[$j]."'>";
																		for ($size_count=0; $size_count < sizeof($size1); $size_count++)
																		{
																			$individual_sizes_query = "SELECT size_title FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style_code AND product_schedule=$schedule_original) AND order_col_des='".$color1[$j]."'  AND size_title='".$size1[$size_count]."'";
																				// echo $individual_sizes_query.'<br>';
																			$individual_sizes_result=mysqli_query($link, $individual_sizes_query) or exit("Error while getting individual size Details");
																			while($individual_sizes_details=mysqli_fetch_array($individual_sizes_result)) 
																			{
																				$individual_color = $individual_sizes_details['size_title'];
																			}
																			if (mysqli_num_rows($individual_sizes_result) >0)
																			{
																				if ($size1[$size_count] == $individual_color) {
																					echo "<td><input type='text' size='6' maxlength='5' required name='GarPerBag[$j][]' id='GarPerBag_".$row_count."_".$size_count."' class='form-control integer' onkeyup=calculateqty1($sizeofsizes,$size_of_ordered_colors); value=''></td>";
																				}
																			}
																			else
																			{
																				echo "<td><input type='hidden' size='6' maxlength='5' name='GarPerBag[$j][]' id='GarPerBag_".$row_count."_".$size_count."' value='0' /></td>";
																			}
																		}
																		echo "<td><input type='text' size='6' maxlength='5' required name='combo[]' id='combo' value='".$combo_value."' $readonly class='form-control integer'></td>";
																echo "</tr>";
																$row_count++;
															}
														echo "</table>
													</div>
												</div>
											</div>";
										
										//second table
										echo "<div class='panel panel-primary'>";
												echo "<div class='panel-heading'>Poly Bags Per Carton</div>";
												echo "<div class='panel-body'>";
												echo "<div class='col-xs-12'>Number of Poly Bags Per Carton : <input type='text' required name='BagPerCart' id='BagPerCart' class='form-control integer' onkeyup=calculateqty1($sizeofsizes,$size_of_ordered_colors);></div>";
													
												echo "</div>
											 </div>";
										
										//third table	
										echo "<div class='panel panel-primary'>
												<div class='panel-heading'>Total FG Per Carton Size Wise</div>
												<div class='panel-body'>
													<div class='table-responsive'>
														<table class=\"table table-bordered\">
															<tr class='info'>
																<th>Color</th>";
																	for ($i=0; $i < sizeof($size1); $i++)
																	{
																		echo "<th>".$size1[$i]."</th>";
																	}
																echo "<th>Total</th>";
															echo "</tr>";
															$row_count=0;
															for ($j=0; $j < sizeof($color1); $j++)
															{
																echo "<tr>";
																		echo "<td>$color1[$j]</td>";
																		for ($size_count=0; $size_count < sizeof($size1); $size_count++)
																		{
																			$individual_sizes_query = "SELECT size_title FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style_code AND product_schedule=$schedule_original) AND order_col_des='".$color1[$j]."' AND size_title='".$size1[$size_count]."'";
																			// echo $individual_sizes_query.'<br>';
																			$individual_sizes_result=mysqli_query($link, $individual_sizes_query) or exit("Error while getting individual size Details");
																			while($individual_sizes_details=mysqli_fetch_array($individual_sizes_result)) 
																			{
																				$individual_color = $individual_sizes_details['size_title'];
																			}
																			if (mysqli_num_rows($individual_sizes_result) >0)
																			{
																				if ($size1[$size_count] == $individual_color) {
																					echo "<td><input type='text' size='6' maxlength='5' required readonly='true' name='GarPerCart[$j][]' id='GarPerCart_".$row_count."_".$size_count."' class='form-control integer' value=''></td>";
																				}
																			}
																			else 
																			{
																				echo "<td><input type='hidden' size='6' maxlength='5' readonly='true' name='GarPerCart[$j][]' id='GarPerCart_".$row_count."_".$size_count."' class='form-control integer' value='0'></td>";
																			}
																		}
																		echo "<td><input type='text' required name='total_".$j."' id='total_".$j."' readonly='true' class='form-control integer' value=''></td>";
																echo "</tr>";
																$row_count++;
															}
														echo "</table>
													</div>
												</div>
											</div>";
											echo "<input type='submit' class='btn btn-success' name='MM_SM_save' id='MM_SM_save' value='Save' />
										</div>
								</div>";
							echo "</form>";
						}
					}
				}
			}

			if (isset($_POST["SS_MS_save"]))
			{
				$psl_doc_array = array();	$tcm_doc_array = array();
				$original_size = $_POST['size'];
				$ref_size = $_POST['size1'];
				$color = $_POST['color'];
				$style = $_POST['style'];
				$combo = $_POST['combo'];
				$schedule = $_POST['schedule'];
				$pack_method = $_POST['pack_method'];
				$schedule_original = $_POST['schedule_original'];
				$GarPerBag = $_POST['GarPerBag'];
				$BagPerCart = $_POST['BagPerCart'];
				$GarPerCart = $_POST['GarPerCart'];

				$get_doc_plandoc_stat_log = "SELECT doc_no from $bai_pro3.order_cat_doc_mk_mix
					WHERE category IN ($in_categories) AND order_del_no='".$schedule_original."'";
				$plandoc_stat_result=mysqli_query($link, $get_doc_plandoc_stat_log) or exit("Errror while getting docket from plandoc_stat_log");
				// echo $get_doc_plandoc_stat_log.'<br>';
				while ($rows=mysqli_fetch_array($plandoc_stat_result))
				{
					$psl_doc_array[] = $rows['doc_no'];
				}

				$get_doc_tbl_cut_master = "SELECT doc_num FROM $brandix_bts.`tbl_cut_master` WHERE product_schedule= '".$schedule_original."'";
				$cut_master_result=mysqli_query($link, $get_doc_tbl_cut_master) or exit("Errror while getting docket from tbl_cut_master");
				// echo $get_doc_tbl_cut_master.'<br>';
				while ($row=mysqli_fetch_array($cut_master_result))
				{
					$tcm_doc_array[] = $row['doc_num'];
				}
				$result=array_diff($psl_doc_array,$tcm_doc_array);
				// echo count($result);
				if(count($result) > 0)
				{
					$sizesMasterQuery="select id,upper(size_name) as size_name from $brandix_bts.tbl_orders_size_ref order by size_name";
						$result2=mysqli_query($link, $sizesMasterQuery) or ("Sql error778".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sizes_tmp=array();
					while($s=mysqli_fetch_array($result2))
					{
						for ($i=0; $i < sizeof($sizes_array); $i++)
						{
							if($s['size_name'] == $sizes_title[$i])
							{
								$sizes_tmp[]=$s['id'];
							}
						}
					}

					$productsQuery=echo_title("$brandix_bts.tbl_orders_master","id","ref_product_style='".$style."' and product_schedule",$schedule_original,$link);
					if($productsQuery>0 || $productsQuery!='')
					{
						$order_id=$productsQuery;
					}
					else
					{
						$insertOrdersMaster="INSERT INTO $brandix_bts.tbl_orders_master(ref_product_style, product_schedule,order_status) VALUES ('".$style."','".$schedule_original."', 'OPEN')";
						$result6=mysqli_query($link, $insertOrdersMaster) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$order_id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
					}

					// difference in plandoc_stat_log and tbl_cut_master
					$layPlanQuery="SELECT plandoc_stat_log.*,cat_stat_log.category FROM $bai_pro3.plandoc_stat_log as plandoc_stat_log
					LEFT JOIN $bai_pro3.cat_stat_log as cat_stat_log ON plandoc_stat_log.cat_ref = cat_stat_log.tid
					WHERE cat_stat_log.category IN ($in_categories) AND  plandoc_stat_log.doc_no in (".implode(",",$result).")";
					// echo $layPlanQuery."<br>";
					$result7=mysqli_query($link, $layPlanQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					if (mysqli_num_rows($result7) > 0)
					{
						while($l=mysqli_fetch_array($result7))
						{
							$order_tid = $l['order_tid'];
							$col_code=echo_title("$bai_pro3.bai_orders_db_confirm","color_code","order_tid",$order_tid,$link);
							$color_code=echo_title("$bai_pro3.bai_orders_db_confirm","order_col_des","order_tid",$order_tid,$link);
							$doc_num=$l['doc_no'];
							$cut_num=$l['acutno'];
							$cut_status=$l['act_cut_status'];
							$planned_module=$l['plan_module'];
							if($planned_module==NULL)
							{
								$planned_module=0;
							}
							$request_time=$l['rm_date'];
							$issued_time=$l['date'];
							$planned_plies=$l['p_plies'];
							$actual_plies=$l['a_plies'];
							$plan_date=$l['date'];
							$cat_ref=$l['cat_ref'];
							$mk_ref=$l['mk_ref'];
							$cuttable_ref=$l['cuttable_ref'];
							//Insert data into layplan(tbl_cut_master) table
							$inserted_id_query1 = "select count(id) as id from $brandix_bts.tbl_cut_master where doc_num='".$doc_num."'";
							$inserted_id_result1=mysqli_query($link, $inserted_id_query1) or ("Sql error1111");
							while($inserted_id_details1=mysqli_fetch_array($inserted_id_result1))
							{
								$layplan_id1=$inserted_id_details1['id'];
							}
							if($layplan_id1==0)
							{
								$insertLayPlanQuery="INSERT IGNORE INTO $brandix_bts.tbl_cut_master(doc_num,ref_order_num,cut_num,cut_status,planned_module,request_time,issued_time,planned_plies,actual_plies,plan_date,style_id,product_schedule,cat_ref,cuttable_ref,mk_ref,col_code) VALUES	('$doc_num',$order_id,$cut_num,'$cut_status','$planned_module','$request_time','$issued_time',$planned_plies,$actual_plies,'$plan_date',$style,'$schedule_original',$cat_ref,$cuttable_ref,$mk_ref,$col_code)";
								// echo $insertLayPlanQuery."</br>";
								$result8=mysqli_query($link, $insertLayPlanQuery) or ("Sql error999".mysqli_error($GLOBALS["___mysqli_ston"]));
								$inserted_id_query = "select id from $brandix_bts.tbl_cut_master where doc_num='".$doc_num."'";
								$inserted_id_result=mysqli_query($link, $inserted_id_query) or ("Sql error1111");
								while($inserted_id_details=mysqli_fetch_array($inserted_id_result))
								{
									$layplan_id=$inserted_id_details['id'];
								}
								//Insert data into layplan reference table (tbl_cut_size_master)
								for ($i=0; $i < sizeof($sizes_array); $i++)
								{
									if($l["p_".$sizes_array[$i].""]>0)
									{
									 	$insertLayplanItemsQuery="INSERT IGNORE INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."','".$layplan_id."','".$sizes_tmp[$i]."','".$l["p_".$sizes_array[$i].""]."')";
										 // echo $insertLayplanItemsQuery."</br>";
									 	$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
									}
								}
							}
						}
					}
				}

				for($i=0;$i<sizeof($color);$i++)
				{
					for ($j=0; $j < sizeof($original_size); $j++)
					{
						if ($GarPerCart[$i][$j]>0)
						{
							$tot = $tot + $GarPerCart[$i][$j];
						}
					}
				}
				$insert_carton_ref="insert ignore into $brandix_bts.tbl_carton_ref (carton_barcode,carton_tot_quantity,ref_order_num,style_code,carton_method) values('".$schedule_original."','".$tot."','".$schedule."','".$style."','".$pack_method."')";
				$insert_carton_ref_result=mysqli_query($link, $insert_carton_ref) or exit("Errror while saving parent details");
				// echo $insert_carton_ref.'<br>';

				$get_inserted_id = "select id from $brandix_bts.tbl_carton_ref where ref_order_num='".$schedule."' and style_code='".$style."' and carton_method='".$pack_method."' and carton_barcode='".$schedule_original."' and carton_tot_quantity='".$tot."' ";
				$get_insert_id_result=mysqli_query($link, $get_inserted_id) or exit("Errror while selecting ID ");
				// echo $get_inserted_id.'<br>';
				while ($get_insert_id_details=mysqli_fetch_array($get_insert_id_result))
				{
					$id = $get_insert_id_details['id'];
				}

				for($i=0;$i<sizeof($color);$i++)
				{
					for ($j=0; $j < sizeof($original_size); $j++)
					{
						if ($GarPerCart[$i][$j]>0 && $GarPerBag[$i][$j]>0)
						{
							$get_ref_size_query = "SELECT ref_size_name FROM $brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM $brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style AND product_schedule=$schedule_original) AND order_col_des='".$color[$i]."' AND size_title='".$original_size[$j]."'";
							$get_ref_size_result=mysqli_query($link, $get_ref_size_query) or exit("Error while ref_size_name details");
							// echo $get_ref_size_query.'<br>';
							while ($get_ref_size_deatils=mysqli_fetch_array($get_ref_size_result))
							{
								$ref_size_name = $get_ref_size_deatils['ref_size_name'];
							}

							$insert_tbl_carton_size_ref="insert ignore into $brandix_bts.tbl_carton_size_ref (parent_id, color, ref_size_name, quantity, poly_bags_per_carton, garments_per_carton, combo_no, size_title) values('".$id."','".$color[$i]."','".$ref_size_name."','".$GarPerBag[$i][$j]."','".$BagPerCart[$j]."','".$GarPerCart[$i][$j]."','".$combo[$i]."','".$original_size[$j]."')";
							$insert_tbl_carton_ref_result=mysqli_query($link, $insert_tbl_carton_size_ref) or exit("Error while saving child details");
							// echo $insert_tbl_carton_size_ref.'<br>';
						}
					}
				}
				echo "<script>sweetAlert('Packing Ratio Saved Successfully','','success')</script>";
			}

			if (isset($_POST["MM_SM_save"]))
			{
				$psl_doc_array = array();	$tcm_doc_array = array();
				$original_size = $_POST['size'];
				$ref_size = $_POST['size1'];
				$color = $_POST['color'];
				$style = $_POST['style'];
				$combo = $_POST['combo'];
				$schedule = $_POST['schedule'];
				$pack_method = $_POST['pack_method'];
				$schedule_original = $_POST['schedule_original'];
				$GarPerBag = $_POST['GarPerBag'];
				$BagPerCart = $_POST['BagPerCart'];
				$GarPerCart = $_POST['GarPerCart'];
				$tot = 0;

				$get_doc_plandoc_stat_log = "SELECT doc_no from $bai_pro3.order_cat_doc_mk_mix
					WHERE category IN ($in_categories) AND order_del_no='".$schedule_original."'";
				$plandoc_stat_result=mysqli_query($link, $get_doc_plandoc_stat_log) or exit("Errror while getting docket from plandoc_stat_log");
				// echo $get_doc_plandoc_stat_log.'<br>';
				while ($rows=mysqli_fetch_array($plandoc_stat_result))
				{
					$psl_doc_array[] = $rows['doc_no'];
				}

				$get_doc_tbl_cut_master = "SELECT doc_num FROM $brandix_bts.`tbl_cut_master` WHERE product_schedule= '".$schedule_original."'";
				$cut_master_result=mysqli_query($link, $get_doc_tbl_cut_master) or exit("Errror while getting docket from tbl_cut_master");
				// echo $get_doc_tbl_cut_master.'<br>';
				while ($row=mysqli_fetch_array($cut_master_result))
				{
					$tcm_doc_array[] = $row['doc_num'];
				}
				$result=array_diff($psl_doc_array,$tcm_doc_array);
				// echo count($result);
				if(count($result) > 0)
				{
					$sizesMasterQuery="select id,upper(size_name) as size_name from $brandix_bts.tbl_orders_size_ref order by size_name";
						$result2=mysqli_query($link, $sizesMasterQuery) or ("Sql error778".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sizes_tmp=array();
					while($s=mysqli_fetch_array($result2))
					{
						for ($i=0; $i < sizeof($sizes_array); $i++)
						{
							if($s['size_name'] == $sizes_title[$i])
							{
								$sizes_tmp[]=$s['id'];
							}
						}
					}

					$productsQuery=echo_title("$brandix_bts.tbl_orders_master","id","ref_product_style='".$style."' and product_schedule",$schedule_original,$link);
					if($productsQuery>0 || $productsQuery!='')
					{
						$order_id=$productsQuery;
					}
					else
					{
						$insertOrdersMaster="INSERT INTO $brandix_bts.tbl_orders_master(ref_product_style, product_schedule,order_status) VALUES ('".$style."','".$schedule_original."', 'OPEN')";
						$result6=mysqli_query($link, $insertOrdersMaster) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$order_id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
					}

					// difference in plandoc_stat_log and tbl_cut_master
					$layPlanQuery="SELECT plandoc_stat_log.*,cat_stat_log.category FROM $bai_pro3.plandoc_stat_log as plandoc_stat_log
					LEFT JOIN $bai_pro3.cat_stat_log as cat_stat_log ON plandoc_stat_log.cat_ref = cat_stat_log.tid
					WHERE cat_stat_log.category IN ($in_categories) AND  plandoc_stat_log.doc_no in (".implode(",",$result).")";
					// echo $layPlanQuery."<br>";
					$result7=mysqli_query($link, $layPlanQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					if (mysqli_num_rows($result7) > 0)
					{
						while($l=mysqli_fetch_array($result7))
						{
							$order_tid = $l['order_tid'];
							$col_code=echo_title("$bai_pro3.bai_orders_db_confirm","color_code","order_tid",$order_tid,$link);
							$color_code=echo_title("$bai_pro3.bai_orders_db_confirm","order_col_des","order_tid",$order_tid,$link);
							$doc_num=$l['doc_no'];
							$cut_num=$l['acutno'];
							$cut_status=$l['act_cut_status'];
							$planned_module=$l['plan_module'];
							if($planned_module==NULL)
							{
								$planned_module=0;
							}
							$request_time=$l['rm_date'];
							$issued_time=$l['date'];
							$planned_plies=$l['p_plies'];
							$actual_plies=$l['a_plies'];
							$plan_date=$l['date'];
							$cat_ref=$l['cat_ref'];
							$mk_ref=$l['mk_ref'];
							$cuttable_ref=$l['cuttable_ref'];
							//Insert data into layplan(tbl_cut_master) table
							$inserted_id_query1 = "select count(id) as id from $brandix_bts.tbl_cut_master where doc_num='".$doc_num."'";
							$inserted_id_result1=mysqli_query($link, $inserted_id_query1) or ("Sql error1111");
							while($inserted_id_details1=mysqli_fetch_array($inserted_id_result1))
							{
								$layplan_id1=$inserted_id_details1['id'];
							}
							if($layplan_id1==0)
							{
								$insertLayPlanQuery="INSERT IGNORE INTO $brandix_bts.tbl_cut_master(doc_num,ref_order_num,cut_num,cut_status,planned_module,request_time,issued_time,planned_plies,actual_plies,plan_date,style_id,product_schedule,cat_ref,cuttable_ref,mk_ref,col_code) VALUES	('$doc_num',$order_id,$cut_num,'$cut_status','$planned_module','$request_time','$issued_time',$planned_plies,$actual_plies,'$plan_date',$style,'$schedule_original',$cat_ref,$cuttable_ref,$mk_ref,$col_code)";
								// echo $insertLayPlanQuery."</br>";
								$result8=mysqli_query($link, $insertLayPlanQuery) or ("Sql error999".mysqli_error($GLOBALS["___mysqli_ston"]));
								$inserted_id_query = "select id from $brandix_bts.tbl_cut_master where doc_num='".$doc_num."'";
								$inserted_id_result=mysqli_query($link, $inserted_id_query) or ("Sql error1111");
								while($inserted_id_details=mysqli_fetch_array($inserted_id_result))
								{
									$layplan_id=$inserted_id_details['id'];
								}
								//Insert data into layplan reference table (tbl_cut_size_master)
								for ($i=0; $i < sizeof($sizes_array); $i++)
								{
									if($l["p_".$sizes_array[$i].""]>0)
									{
									 	$insertLayplanItemsQuery="INSERT IGNORE INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."','".$layplan_id."','".$sizes_tmp[$i]."','".$l["p_".$sizes_array[$i].""]."')";
										 // echo $insertLayplanItemsQuery."</br>";
									 	$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
									}
								}
							}
						}
					}
				}

				for($i=0;$i<sizeof($color);$i++)
				{
					for ($j=0; $j < sizeof($original_size); $j++)
					{
						if ($GarPerCart[$i][$j]>0)
						{
							$tot = $tot + $GarPerCart[$i][$j];
						}
					}
				}
				// echo $tot;
				$insert_carton_ref="insert ignore into $brandix_bts.tbl_carton_ref (carton_barcode,carton_tot_quantity,ref_order_num,style_code,carton_method) values('".$schedule_original."','".$tot."','".$schedule."','".$style."','".$pack_method."')";
				$insert_carton_ref_result=mysqli_query($link, $insert_carton_ref) or exit("Errror while saving parent details");
				// echo $insert_carton_ref.'<br>';

				$get_inserted_id = "select id from $brandix_bts.tbl_carton_ref where ref_order_num='".$schedule."' and style_code='".$style."' and carton_method='".$pack_method."' and carton_barcode='".$schedule_original."' and carton_tot_quantity='".$tot."' ";
				$get_insert_id_result=mysqli_query($link, $get_inserted_id) or exit("Errror while selecting ID ");
				// echo $get_inserted_id.'<br>';
				while ($get_insert_id_details=mysqli_fetch_array($get_insert_id_result))
				{
					$id = $get_insert_id_details['id'];
				}

				for($i=0;$i<sizeof($color);$i++)
				{
					for ($j=0; $j < sizeof($original_size); $j++)
					{
						if ($GarPerCart[$i][$j]>0 && $GarPerBag[$i][$j]>0)
						{
							$get_ref_size_query = "SELECT ref_size_name FROM $brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM $brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style AND product_schedule=$schedule_original) AND order_col_des='".$color[$i]."' AND size_title='".$original_size[$j]."'";
							$get_ref_size_result=mysqli_query($link, $get_ref_size_query) or exit("Error while saving child details");
							// echo $get_ref_size_query.'<br>';
							while ($get_ref_size_deatils=mysqli_fetch_array($get_ref_size_result))
							{
								$ref_size_name = $get_ref_size_deatils['ref_size_name'];
							}

							$insert_tbl_carton_size_ref="insert ignore into $brandix_bts.tbl_carton_size_ref (parent_id, color, ref_size_name, quantity, poly_bags_per_carton, garments_per_carton, combo_no, size_title) values('".$id."','".$color[$i]."','".$ref_size_name."','".$GarPerBag[$i][$j]."','".$BagPerCart."','".$GarPerCart[$i][$j]."','".$combo[$i]."','".$original_size[$j]."')";
							$insert_tbl_carton_ref_result=mysqli_query($link, $insert_tbl_carton_size_ref) or exit("Error while saving child details");
							// echo $insert_tbl_carton_size_ref.'<br>';
						}
					}
				}
				echo "<script>sweetAlert('Packing Ratio Saved Successfully','','success')</script>";
			}
		?>
	</div>
</div>
	

