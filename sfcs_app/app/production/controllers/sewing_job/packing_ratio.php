<script language="javascript" type="text/javascript">
	function calculateqty(size_count,sizeOfColors)
	{
		for (var row_count = 0; row_count < sizeOfColors; row_count++)
		{
			var GarPerBag=document.getElementById('GarPerBag_'+size_count+'_'+row_count).value;
			var BagPerCart=document.getElementById('BagPerCart_'+size_count).value;
			var GarPerCart = GarPerBag*BagPerCart;
			document.getElementById('GarPerCart_'+size_count+'_'+row_count).value=GarPerCart;
		}
	}

	function calculateqty1(sizeofsizes,sizeOfColors)
	{
		var total=0;
		for (var row_count = 0; row_count < sizeOfColors; row_count++)
		{
			for(var size=0;size < sizeofsizes; size++)
			{
				var GarPerBag=document.getElementById('GarPerBag_'+size+'_'+row_count).value;
				var BagPerCart=document.getElementById('BagPerCart').value;
				var GarPerCart = GarPerBag*BagPerCart;
				document.getElementById('GarPerCart_'+size+'_'+row_count).value=GarPerCart;
				total = total+GarPerCart;
			}
			document.getElementById('total_'+row_count).value=total;
			total=0;
		}
	}

	function firstbox()
	{
		var url1 = '<?= getFullUrl($_GET['r'],'polybag_ratio.php','N'); ?>';
		window.location.href =url1+"&style="+document.mini_order_report.style.value;
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
			<form method="POST" class="form-inline" name="mini_order_report" action="index.php?r=<?php echo $_GET['r']; ?>">
				Style:
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
				Schedule:
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
				Pack Method: 
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
				// $style_code='13';
				// $schedule="3";
				$schedule_original = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
				$o_colors = echo_title("$bai_pro3.bai_orders_db","group_concat(distinct order_col_des order by order_col_des)","bai_orders_db.order_joins NOT IN ('1','2') AND order_del_no",$schedule_original,$link);	
				$p_colors = echo_title("$brandix_bts.tbl_orders_sizes_master","group_concat(distinct order_col_des order by order_col_des)","parent_id",$schedule,$link);
				$order_colors=explode(",",$o_colors);	
				$planned_colors=explode(",",$p_colors);
				$size_of_ordered_colors=sizeof($order_colors);
				$size_of_planned_colors=sizeof($planned_colors);
				// echo 'order_colors: '.$size_of_ordered_colors.'<br>planned: '.$size_of_planned_colors;

				if ($size_of_ordered_colors!=$size_of_planned_colors)
				{
					echo "<script>sweetAlert('Please prepare Lay Plan for all Colors in this Schedule - $schedule_original','','warning')</script>";
				}
				else
				{
					$sewing_jobratio_sizes_query = "SELECT parent_id,GROUP_CONCAT(DISTINCT color) AS color, GROUP_CONCAT(DISTINCT ref_size_name) AS size FROM $brandix_bts.tbl_carton_size_ref WHERE parent_id IN (SELECT id FROM $brandix_bts.tbl_carton_ref WHERE ref_order_num=$schedule AND style_code=$style_code)";
					$sewing_jobratio_sizes_result=mysqli_query($link, $sewing_jobratio_sizes_query) or exit("Error while getting Job Ratio Details");
					while($sewing_jobratio_color_details=mysqli_fetch_array($sewing_jobratio_sizes_result)) 
					{
						$parent_id = $sewing_jobratio_color_details['parent_id'];
						$color = $sewing_jobratio_color_details['color'];
						$size = $sewing_jobratio_color_details['size'];
						$color1 = explode(",",$color);
						$size1 = explode(",",$size);
						// var_dump($size);
					}
					echo "<br><br><br>";
					if ($pack_method==1 or $pack_method==2)
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
							echo "<div class='panel panel-primary'>";
								echo "<div class='panel-heading'>$title</div>";
								echo "<div class='panel-body'>";
									//first table
									echo "<div class='panel panel-primary'>";
											echo "<div class='panel-heading'>Number of Garments Per Poly Bag</div>
											<div class='panel-body'>
												<table class=\"table table-bordered\">
													<tr>
														<th>Color</th>";
														// Display Sizes
														$sizes_to_display=array();
														for ($i=0; $i < sizeof($size1); $i++)
														{
															$Original_size_query = "SELECT DISTINCT size_title FROM `brandix_bts`.`tbl_orders_sizes_master` WHERE parent_id = $schedule AND ref_size_name=$size1[$i]";
															// echo $Original_size_query;	
															$Original_size_result=mysqli_query($link, $Original_size_query) or exit("Error while getting Size Details $Original_size_query");
															while($Original_size_details=mysqli_fetch_array($Original_size_result)) 
															{
																$Ori_size = $Original_size_details['size_title'];
																$sizes_to_display[] = $Original_size_details['size_title'];
															}
															echo "<th>".$Ori_size."</th>";
														}
														echo "<th>Combo</th>
													</tr>";
													// Display Textboxes
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
																<td>$color1[$j]</td>";
																for ($size_count=0; $size_count < sizeof($size1); $size_count++)
																{
																	echo "<td><input type='text' name='GarPerBag' id='GarPerBag_".$size_count."_".$row_count."' class='form-control' value=''></td>";
																}
																echo "<td><input type='text' name='combo' id='combo' class='form-control' value='".$combo_value."' $readonly></td>
															</tr>";
														$row_count++;
													}
												echo "</table>
											</div>
										</div>";
									
									//second table
									echo "<div class='panel panel-primary'>";
											echo "<div class='panel-heading'>Number of Poly Bags Per Carton</div>";
											echo "<div class='panel-body'>";
												echo "<table class='table table-bordered'>
													<tr>";
														// Show Sizes
														for ($i=0; $i < sizeof($sizes_to_display); $i++)
														{
															echo "<th>".$sizes_to_display[$i]."</th>";
														}
													echo "</tr>";
													echo "<tr>";
														for ($size_count=0; $size_count < sizeof($size1); $size_count++)
														{
															echo "<td><input type='text' name='BagPerCart' id='BagPerCart_".$size_count."' class='form-control' onchange=calculateqty($size_count,$size_of_ordered_colors);></td>";
														}
													echo "</tr>";
												echo "</table>
											</div>
										</div>";
									
									//third table	
									echo "<div class='panel panel-primary'>
											<div class='panel-heading'>Number of Garments Per Carton</div>
											<div class='panel-body'>
												<table class=\"table table-bordered\">
													<tr>
														<th>Color</th>";
															for ($i=0; $i < sizeof($sizes_to_display); $i++)
															{
																echo "<th>".$sizes_to_display[$i]."</th>";
															}
													echo "</tr>";
													$row_count=0;
													for ($j=0; $j < sizeof($color1); $j++)
													{
														echo "<tr>";
																echo "<td>$color1[$j]</td>";
																for ($size_count=0; $size_count < sizeof($size1); $size_count++)
																{
																	echo "<td><input type='text' readonly='true' name='GarPerCart' id='GarPerCart_".$size_count."_".$row_count."' class='form-control' value=''></td>";
																}
														echo "</tr>";
														$row_count++;
													}
												echo "</table>
											</div>
										</div>";
								echo "</div>
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
						echo "<div class='panel panel-primary'>";
							echo "<div class='panel-heading'>Multi Color Multi Size</div>";
							echo "<div class='panel-body'>";
								//first table
								echo "<div class='panel panel-primary'>";
										echo "<div class='panel-heading'>Poly Bag Ratio</div>
										<div class='panel-body'>
											<table class=\"table table-bordered\">
												<tr>
													<th>Color</th>";
													// Display Sizes
													$sizes_to_display=array();
													for ($i=0; $i < sizeof($size1); $i++)
													{
														$Original_size_query = "SELECT DISTINCT size_title FROM `brandix_bts`.`tbl_orders_sizes_master` WHERE parent_id = $schedule AND ref_size_name=$size1[$i]";
														// echo $Original_size_query;
														$Original_size_result=mysqli_query($link, $Original_size_query) or exit("Error while getting Qty Details");
														while($Original_size_details=mysqli_fetch_array($Original_size_result)) 
														{
															$Ori_size = $Original_size_details['size_title'];
															$sizes_to_display[] = $Original_size_details['size_title'];
														}
														$sizeofsizes=sizeof($sizes_to_display);
														echo "<th>".$Ori_size."</th>";
													}
													echo "<th>Combo</th>";
												echo "</tr>";
												// Display Textboxes
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
															<td>$color1[$j]</td>";
															for ($size_count=0; $size_count < sizeof($size1); $size_count++)
															{
																echo "<td><input type='text' name='GarPerBag' id='GarPerBag_".$size_count."_".$row_count."' class='form-control' value=''></td>";
															}
															echo "<td><input type='text' name='combo' id='combo' value='".$combo_value."' $readonly class='form-control'></td>";
													echo "</tr>";
													$row_count++;
												}
											echo "</table>
										</div>
									</div>";
								
								//second table
								echo "<div class='panel panel-primary'>";
										echo "<div class='panel-heading'>Poly Bags Per Carton</div>";
										echo "<div class='panel-body'>";

										echo "<div class='col-md-3 col-sm-3 col-xs-12'>Number of Poly Bags Per Carton : <input type='text' name='BagPerCart' id='BagPerCart' class='form-control' onchange=calculateqty1($sizeofsizes,$size_of_ordered_colors);></div>";
											
										echo "</div>
									 </div>";
								
								//third table	
								echo "<div class='panel panel-primary'>
										<div class='panel-heading'>Total FG Per Carton Size Wise</div>
										<div class='panel-body'>
											<table class=\"table table-bordered\">
												<tr>
													<th>Color</th>";
														for ($i=0; $i < sizeof($sizes_to_display); $i++)
														{
															echo "<th>".$sizes_to_display[$i]."</th>";
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
																echo "<td><input type='text' readonly='true' name='GarPerCart' id='GarPerCart_".$size_count."_".$row_count."' class='form-control' value=''></td>";
															}
															echo "<td><input type='text' name='total_".$j."' id='total_".$j."' readonly='true' class='form-control'></td>";
													echo "</tr>";
													$row_count++;
												}
											echo "</table>
										</div>
									</div>";
							echo "</div>
						</div>";
					}
					// switch ($pack_method)
					// {
					// 	// case 1:
					// 	// 	echo "<br><br><br>";
					// 	// 	include 'single_color_single_size.php';
					// 	// 	break;

					// 	// case 2:
					// 	// 	echo "<br><br><br>";
					// 	// 	include 'multi_color_single_size.php';
					// 	// 	break;

					// 	case 3:
					// 		echo "<br><br><br>";
					// 		include 'multi_color_multi_size.php';
					// 		break;

					// 	case 4:
					// 		echo "<br><br><br>";
					// 		include 'single_color_multi_size.php';
					// 		break;
						
					// 	default:
					// 		echo "<br><br><br>";
					// 		echo "Please Select Pack Method";
					// 		break;
					// }
				}
			}
		?>
	</div>
</div>
	

