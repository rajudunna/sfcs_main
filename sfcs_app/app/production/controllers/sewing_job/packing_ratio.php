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
				Style:
				<?php
					// Style
					echo "<select name=\"style\" id=\"style\"  class='form-control integer' onchange=\"firstbox();\">";
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
				Schedule:
				<?php
					echo "<select class='form-control integer' name='schedule' id='schedule'>";
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
				Pack Method: 
				<?php 
				echo "<select id=\"pack_method\" class='form-control integer' name=\"pack_method\" >";
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

				$schedule_original = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
				$validation_query = "SELECT * FROM $brandix_bts.tbl_carton_ref WHERE carton_barcode=$schedule_original";
				// echo $sewing_jobratio_sizes_query.'<br>';
				$validation_result=mysqli_query($link, $validation_query) or exit("Error while getting Job Ratio Details");
				if (mysqli_num_rows($validation_result) > 0)
				{
					echo "<script>sweetAlert('Packing Ratio Already Updated for this Schedule - $schedule_original','Go to Sewing Job Creation','warning')</script>";
				}
				else
				{
					$o_colors = echo_title("$bai_pro3.bai_orders_db","group_concat(distinct order_col_des order by order_col_des)","bai_orders_db.order_joins NOT IN ('1','2') AND order_del_no",$schedule_original,$link);	
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

						$sewing_jobratio_sizes_query = "SELECT GROUP_CONCAT(DISTINCT size_title) AS size, GROUP_CONCAT(DISTINCT order_col_des) AS color FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style_code AND product_schedule=$schedule_original)";
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
															<tr>
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
																					echo "<td><input type='text' required name='GarPerBag[$j][]' id='GarPerBag_".$row_count."_".$size_count."' class='form-control integer' value=''></td>";
																				}
																			}
																			else
																			{
																				echo "<td><input type='hidden' name='GarPerBag[$j][]' id='GarPerBag_".$row_count."_".$size_count."' value='0' /></td>";
																			}																
																		}
																		echo "<td><input type='text' required name='combo[]' id='combo' class='form-control integer' value='".$combo_value."' $readonly></td>
																	</tr>";
																$row_count++;
															}
														echo "</table>
													</div>
												</div>
											</div>";
										
										//second table
										echo "<div class='panel panel-primary'>";
												echo "<div class='panel-heading'>Number of Poly Bags Per Carton</div>";
												echo "<div class='panel-body'>";
													echo "<input type='hidden' name='size_size1' id='size_size1' value='".sizeof($size1)."' />";
													echo "<div class='table-responsive'><table class='table table-bordered'>
														<tr>";
															// Show Sizes
															for ($i=0; $i < sizeof($size1); $i++)
															{
																echo "<th>".$size1[$i]."</th>";
															}
														echo "</tr>";
														echo "<tr>";
															for ($size_count=0; $size_count < sizeof($size1); $size_count++)
															{
																echo "<td><input type='text' required name='BagPerCart[]' id='BagPerCart_".$size_count."' class='form-control integer' onchange=calculateqty($size_count,$size_of_ordered_colors);></td>";
															}
														echo "</tr>";
													echo "</div></table>
												</div>
											</div>";
										
										//third table	
										echo "<div class='panel panel-primary'>
												<div class='panel-heading'>Number of Garments Per Carton</div>
												<div class='panel-body'>
													<div class='table-responsive'>
														<table class=\"table table-bordered\">
															<tr>
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
																					echo "<td><input type='text' required readonly='true' name='GarPerCart[$j][]' id='GarPerCart_".$row_count."_".$size_count."' class='form-control integer' value=''></td>";
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
										echo "<input type='submit' class='btn btn-success' name='SS_MS_save' id='SS_MS_save' value='Save' />
									</div>
								</div>
							</form>";
						}
						if ($pack_method==3 or $pack_method==4)
						{
							if ($pack_method==3)
							{
								$title = "Single Color Multi Size";
								$combo='YES';
							} else {
								$title = "Multi Color Multi Size";
								$combo='NO';
							}
							echo '<form method="POST" class="form-inline" name="MM_SM" action="#">';
								echo "<input type='hidden' name='style' id='style' value='".$style_code."' />";
								echo "<input type='hidden' name='schedule' id='schedule' value='".$schedule."' />";
								echo "<input type='hidden' name='schedule_original' id='schedule' value='".$schedule_original."' />";
								echo "<input type='hidden' name='pack_method' id='pack_method' value='".$pack_method."' />";
								echo "<input type='hidden' name='size1' id='size1' value='".$size1."' />";
								echo "<div class='panel panel-primary'>";
									echo "<div class='panel-heading'>Multi Color Multi Size</div>";
									echo "<div class='panel-body'>";
										//first table
										echo "<div class='panel panel-primary'>";
												echo "<div class='panel-heading'>Poly Bag Ratio</div>
												<div class='panel-body'>
													<div class='table-responsive'>
														<table class=\"table table-bordered\">
															<tr>
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
																					echo "<td><input type='text' required name='GarPerBag[$j][]' id='GarPerBag_".$row_count."_".$size_count."' class='form-control integer' value=''></td>";
																				}
																			}
																			else
																			{
																				echo "<td><input type='hidden' name='GarPerBag[$j][]' id='GarPerBag_".$row_count."_".$size_count."' value='0' /></td>";
																			}
																		}
																		echo "<td><input type='text' required name='combo[]' id='combo' value='".$combo_value."' $readonly class='form-control integer'></td>";
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
												echo "<div class='col-md-3 col-sm-3 col-xs-12'>Number of Poly Bags Per Carton : <input type='text' required name='BagPerCart' id='BagPerCart' class='form-control integer' onchange=calculateqty1($sizeofsizes,$size_of_ordered_colors);></div>";
													
												echo "</div>
											 </div>";
										
										//third table	
										echo "<div class='panel panel-primary'>
												<div class='panel-heading'>Total FG Per Carton Size Wise</div>
												<div class='panel-body'>
													<div class='table-responsive'>
														<table class=\"table table-bordered\">
															<tr>
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
																					echo "<td><input type='text' required readonly='true' name='GarPerCart[$j][]' id='GarPerCart_".$row_count."_".$size_count."' class='form-control integer' value=''></td>";
																				}
																			}
																			else 
																			{
																				echo "<td><input type='hidden' readonly='true' name='GarPerCart[$j][]' id='GarPerCart_".$row_count."_".$size_count."' class='form-control integer' value='0'></td>";
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
							$get_ref_size_result=mysqli_query($link, $get_ref_size_query) or exit("Error while saving child details");
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
				echo "<script>sweetAlert('Data Saved Successfully','','success')</script>";
			}

			if (isset($_POST["MM_SM_save"]))
			{
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
				echo "<script>sweetAlert('Data Saved Successfully','','success')</script>";
			}
		?>
	</div>
</div>
	

