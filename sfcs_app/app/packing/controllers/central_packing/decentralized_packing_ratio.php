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
		var url1 = '<?= getFullUrl($_GET['r'],'decentralized_packing_ratio.php','N'); ?>';
		window.location.href =url1+"&style="+document.decentralized_packing_ratio.style.value;
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
	

	$(document).ready(function(){
		$('#SS_MS_save').on('click',function(event, redirect=true)
		{
			if(redirect != false){
				event.preventDefault();
				submit_form($(this));
			}
		});
		
		function submit_form(submit_btn)
		{
			var noofcart=document.getElementById('noofcartons').value;
			var noofpack=document.getElementById('noofpackjobs').value;
			
			if(noofcart==0 || noofcart=='')
			{
				sweetAlert('Please enter no of cartons','greater than zero','warning');
				return;
			}
			if(noofpack==0 || noofpack=='')
			{
				sweetAlert('Please enter no of pack jobs','greater than zero','warning');
				return;
			}
		}
		
				
		function submit_form1(submit_btn)
		{
			var noofcart=document.getElementById('noofcartons').value;
			var noofpack=document.getElementById('noofpackjobs').value;
			
			if(noofcart==0 || noofcart=='')
			{
				sweetAlert('Please enter no of cartons','greater than zero','warning');
				return;
			}
			if(noofpack==0 || noofpack=='')
			{
				sweetAlert('Please enter no of pack jobs','greater than zero','warning');
				return;
			}
		}
	
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
		$pack_method=$_POST['pack_method'];
	}
	else
	{
		$style=$_GET['style'];
		$schedule=$_GET['schedule'];
		$pack_method=$_POST['pack_method'];
	}

?>

	
<div class="panel panel-primary">
	<div class="panel-heading"><strong>Add Packing Ratio</strong></div>
	<div class="panel-body">
		<div class="col-md-12">
			<form method="POST" class="form-inline" name="decentralized_packing_ratio">
				<label>Style:</label>
				<?php
					// Style
					echo "<select name=\"style\" id=\"style\"  class='form-control' onchange=\"firstbox();\" disabled>";
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
					echo "<select class='form-control' name='schedule' id='schedule' disabled>";
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
		
		</br></br></br>

				
		<?php
			if (isset($_POST["submit"]) or ($_GET['style'] and $_GET['schedule'] and $_POST['pack_method']))
			{
				if ($_GET['style'] and $_GET['schedule']) {
					$style_code=$_GET['style'];
					$schedule=$_GET['schedule'];
					$pack_method=$_POST['pack_method'];
				} else if ($_POST['style'] and $_POST['schedule']){
					$style_code=$_POST['style'];
					$schedule=$_POST['schedule'];	
					$pack_method=$_POST['pack_method'];	
				}
				//echo $style_code.'<br>'.$schedule.'<br>'.$pack_method.'<br>';
				$c_ref = echo_title("$bai_pro3.tbl_pack_ref","id","ref_order_num",$schedule,$link);
				$schedule_original = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
				$valid_result = echo_title("$bai_pro3.tbl_pack_ref","COUNT(*)","ref_order_num",$schedule,$link);
				$parent_id=echo_title("$bai_pro3.tbl_pack_ref","id","ref_order_num",$schedule,$link);
				$updated_carton_method = echo_title("$bai_pro3.tbl_pack_size_ref","pack_method","parent_id",$parent_id,$link);
			
				// for($i=0;$i<sizeof($sizes_array);$i++)
				// {
				// 	$orderqty="select sum(order_s_".$sizes_array[$i].") from $bai_pro3.bai_orders_db where order_del_no=$schedule_original";
				// 	$orderqtyrslt=mysqli_query($link, $orderqty) or exit("Error while getting order qty Details");
				// 	while($orqty=mysqli_fetch_array($orderqtyrslt)) 
				// 	{
						
				// 	}
				// }
				// if ($valid_result > 0)
				// {
				// 	echo "<script>sweetAlert('Packing Ratio Already Updated for this Schedule - $schedule_original','Go to Sewing Job Creation','warning')</script>";
				// 	echo '<br><br><br><div class="col-md-12"><h4>Pack Method: <span class="label label-info">'.$operation[$updated_carton_method].'</span></h4></div>';
				// 	$sewing_jobratio_sizes_query = "SELECT parent_id,GROUP_CONCAT(DISTINCT color) AS color, GROUP_CONCAT(DISTINCT ref_size_name) AS size FROM $bai_pro3.tbl_pack_size_ref WHERE parent_id IN (SELECT id FROM $bai_pro3.tbl_pack_ref WHERE ref_order_num=$schedule AND style_code=$style_code)";
				// 	$sewing_jobratio_sizes_result=mysqli_query($link, $sewing_jobratio_sizes_query) or exit("Error while getting Job Ratio Details");
				// 	echo "<br><div class='col-md-12'><b>Garments Per Poly Bag: </b>
				// 		<table class=\"table table-bordered\">
				// 			<tr>
				// 				<th>Color</th>";
				// 	while($sewing_jobratio_color_details=mysqli_fetch_array($sewing_jobratio_sizes_result)) 
				// 	{
				// 		$parent_id = $sewing_jobratio_color_details['parent_id'];
				// 		$color = $sewing_jobratio_color_details['color'];
				// 		$size = $sewing_jobratio_color_details['size'];
				// 		$color1 = explode(",",$color);
				// 		$size1 = explode(",",$size);
				// 		// var_dump($size);
				// 	}
				// 	// GArments per Poly Bag Details Start
				// 	{
						
				// 		for ($i=0; $i < sizeof($size1); $i++)
				// 		{
				// 			$Original_size_query = "SELECT DISTINCT size_title FROM `brandix_bts`.`tbl_orders_sizes_master` WHERE parent_id = $schedule AND ref_size_name=$size1[$i]";
				// 			// echo $Original_size_query;
				// 			$Original_size_result=mysqli_query($link, $Original_size_query) or exit("Error while getting Qty Details");
				// 			while($Original_size_details=mysqli_fetch_array($Original_size_result)) 
				// 			{
				// 				$Ori_size = $Original_size_details['size_title'];
				// 			}
				// 			echo "<th>".$Ori_size."</th>";
				// 		}
				// 		echo "</tr>";
				// 		for ($j=0; $j < sizeof($color1); $j++)
				// 		{
				// 			echo "<tr>
				// 					<td>$color1[$j]</td>";
				// 					for ($i=0; $i < sizeof($size1); $i++)
				// 					{
				// 						$qty_query = "SELECT quantity FROM $bai_pro3.`tbl_pack_size_ref` WHERE ref_size_name=$size1[$i] AND parent_id=$parent_id AND color='".$color1[$j]."'";
				// 						// echo $qty_query;
				// 						$qty_query_result=mysqli_query($link, $qty_query) or exit("Error while getting Qty Details");
				// 						while($qty_query_details=mysqli_fetch_array($qty_query_result)) 
				// 						{
				// 							$qty = $qty_query_details['quantity'];
				// 							if ($qty == '') {
				// 								$qty=0;
				// 							}
				// 							echo "<td>".$qty.'</td>';
				// 						}
				// 					}
				// 			echo "</tr>";
				// 		}
				// 		echo "</table></div>";
				// 	}
				// 	// GArments per Poly Bag Details End

				// 	// Poly Bags per Carton Start
				// 	{
				// 		if ($pack_method == 3 || $pack_method == 4)
				// 		{
				// 			$poly_bags_per_carton_query = "SELECT distinct(poly_bags_per_carton) as poly_bags_per_carton FROM $bai_pro3.`tbl_pack_size_ref` WHERE parent_id=$c_ref";
				// 			// echo $poly_bags_per_carton_query;
				// 			$poly_bags_per_carton_result=mysqli_query($link, $poly_bags_per_carton_query) or exit("Error while getting poly_bags_per_carton Details");
				// 			while($poly_bags_per_carton_details=mysqli_fetch_array($poly_bags_per_carton_result)) 
				// 			{
				// 				echo "<br><div class='col-md-4'>
				// 							<table class=\"table table-bordered\">
				// 								<tr><th>Number of Poly Bags Per Carton:</th><th>".$poly_bags_per_carton_details['poly_bags_per_carton']."</th>
				// 								</tr>
				// 							</table>
				// 						</div>";
				// 			}
				// 			echo "<br><br>";
				// 		}
				// 		else if ($pack_method == 1 || $pack_method == 2)
				// 		{
				// 			$poly_bags_per_carton=array();
				// 			$size_title=array();
				// 			$poly_bags_per_carton_query = "SELECT poly_bags_per_carton,size_title FROM $bai_pro3.`tbl_pack_size_ref` WHERE parent_id=$c_ref GROUP BY size_title DESC";
				// 			// echo $poly_bags_per_carton_query;
				// 			$poly_bags_per_carton_result=mysqli_query($link, $poly_bags_per_carton_query) or exit("Error while getting poly_bags_per_carton Details");
				// 			while($poly_bags_per_carton_details=mysqli_fetch_array($poly_bags_per_carton_result)) 
				// 			{
				// 				$poly_bags_per_carton[]=$poly_bags_per_carton_details['poly_bags_per_carton'];
				// 				$size_title[]=$poly_bags_per_carton_details['size_title'];
				// 			}

				// 			echo "<br><div class='col-md-12'><b>Number of Poly Bags Per Carton: </b>
				// 			<table class=\"table table-bordered\">
				// 				<tr>";
				// 				for ($i=0; $i < sizeof($size_title); $i++)
				// 				{ 
				// 					echo "<th>$size_title[$i]</th>";
				// 				}
				// 				echo "</tr><tr>";
				// 				for ($i=0; $i < sizeof($poly_bags_per_carton); $i++)
				// 				{ 
				// 					echo "<td>$poly_bags_per_carton[$i]</td>";
				// 				}
				// 				echo "</tr>
				// 			</table></div>";
				// 		}				
				// 	}
				// 	// Poly Bags per Carton end

				// 	// Garments Per Carton Start
				// 	{
				// 		$sewing_jobratio_sizes_query = "SELECT GROUP_CONCAT(DISTINCT size_title) AS size, GROUP_CONCAT(DISTINCT order_col_des) AS color FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN ($schedule)";
				// 		// echo $sewing_jobratio_sizes_query.'<br>';
				// 		$sewing_jobratio_sizes_result=mysqli_query($link, $sewing_jobratio_sizes_query) or exit("Error while getting Job Ratio Details");
				// 		while($sewing_jobratio_color_details=mysqli_fetch_array($sewing_jobratio_sizes_result)) 
				// 		{
				// 			$parent_id = $sewing_jobratio_color_details['parent_id'];
				// 			$color = $sewing_jobratio_color_details['color'];
				// 			$ref_size = $sewing_jobratio_color_details['size'];
				// 			$color1 = explode(",",$color);
				// 			$size1 = explode(",",$ref_size);
				// 			// var_dump($size);
				// 		}
				// 		echo "
				// 			<div class='col-md-12'><b>Garments Per Carton: </b>
				// 				<div class='table-responsive'>
				// 					<table class=\"table table-bordered\">
				// 						<tr>
				// 							<th>Color</th>";
				// 							// Display Sizes
				// 							for ($i=0; $i < sizeof($size1); $i++)
				// 							{
				// 								echo "<th>".$size1[$i]."</th>";
				// 							}
				// 						echo "</tr>";
				// 						// Display Textboxes
				// 						$row_count=0;
				// 						for ($j=0; $j < sizeof($color1); $j++)
				// 						{
				// 							echo "<tr>
				// 									<td>$color1[$j]</td>";
				// 									for ($size_count=0; $size_count < sizeof($size1); $size_count++)
				// 									{
				// 										$individual_sizes_query = "SELECT size_title FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style_code AND product_schedule=$schedule_original) AND order_col_des='".$color1[$j]."'  AND size_title='".$size1[$size_count]."'";
				// 										// echo $individual_sizes_query.'<br>';
				// 										$individual_sizes_result=mysqli_query($link, $individual_sizes_query) or exit("Error while getting individual size Details");
				// 										while($individual_sizes_details=mysqli_fetch_array($individual_sizes_result)) 
				// 										{
				// 											$individual_color = $individual_sizes_details['size_title'];
				// 										}

				// 										$qty_query = "SELECT garments_per_carton FROM $bai_pro3.`tbl_pack_size_ref` WHERE size_title='$size1[$size_count]' AND parent_id=$c_ref AND color='".$color1[$j]."'";
				// 										// echo '<br>'.$qty_query.'<br>';
				// 										$qty_query_result=mysqli_query($link, $qty_query) or exit("Error while getting Qty Details");
				// 										while($qty_query_details=mysqli_fetch_array($qty_query_result)) 
				// 										{
				// 											$qty = $qty_query_details['garments_per_carton'];
				// 											if ($qty == '') {
				// 												$qty=0;
				// 											}
				// 											if (mysqli_num_rows($individual_sizes_result) >0)
				// 											{
				// 												if ($size1[$size_count] == $individual_color) {
				// 													echo "<td>".$qty."</td>";
				// 												}
				// 											}
				// 											else
				// 											{
				// 												echo "<td>".$qty."</td>";
				// 											}
				// 										}
														
				// 									}
				// 							echo "</tr>";
				// 							$row_count++;
				// 						}
				// 					echo "</table>
				// 				</div>
				// 			<div>
				// 		";
				// 	}
				// 	// Garments Per Carton End
				// }
				// else
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
							} else {
								$title = "Multi Color Single Size";
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
									
									echo "<div class='col-md-6 col-sm-6 col-xs-12'>
									<label>Description :</label>
									<input type='text' name='description' id='description' size='60' maxlength='60' class='form-control' required>
									</div>";
									echo"<div class='col-md-3 col-sm-3 col-xs-12'>
									<label>No of cartons per Pack Job :</label>
									<input type='text' name='noofcartons' id='noofcartons'  class='form-control integer' required onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value=0>
									</div>";
									echo"<div class='col-md-3 col-sm-3 col-xs-12'>
									<label>No of Cartons  :</label>
									<input type='text' name='noofpackjobs' id='noofpackjobs'  class='form-control integer' required onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value=0>
									</div>";
									echo "</br></br></br></br>";
								
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
																echo "</tr>";
															// Display Textboxes
															echo "<input type='hidden' name='noOfSizes' id='noOfSizes' value='".sizeof($color1)."' />";
															$row_count=0;
															for ($j=0; $j < sizeof($color1); $j++)
															{
															
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
																					echo "<td><input type='text' size='6' maxlength='5' required name='GarPerBag[$j][]' id='GarPerBag_".$row_count."_".$size_count."' class='form-control integer' onkeyup=calculateqty($size_count,$size_of_ordered_colors); onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value='0'></td>";
																				}
																			}
																			else
																			{
																				echo "<td><input type='hidden' name='GarPerBag[$j][]' id='GarPerBag_".$row_count."_".$size_count."' onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value='0'/></td>";
																			}																
																		}
																		echo "</tr>";
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
																	echo "<td><input type='text' size='6' maxlength='5' required name='BagPerCart[]' id='BagPerCart_".$size_count."' onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value='0' class='form-control integer' onkeyup=calculateqty($size_count,$size_of_ordered_colors);></td>";
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
							} else {
								$title = "Single Color Multi Size";
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
									echo "<div class='col-md-3 col-sm-3 col-xs-12'>
									<label>Description :</label>
									<input type='text' name='description' id='description' class='form-control' required>
									</div>";
									echo"<div class='col-md-3 col-sm-3 col-xs-12'>
									<label>No of cartons per Pack Job :</label>
									<input type='text' name='noofcartons' id='noofcartons'  class='form-control integer' required onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value='0'>
									</div>";
									echo"<div class='col-md-3 col-sm-3 col-xs-12'>
									<label>No of Pack Jobs per Pack  :</label>
									<input type='text' name='noofpackjobs' id='noofpackjobs'  class='form-control integer' required onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value='0'>
									</div>";
									echo "</br></br></br></br>";
										//first table
										echo "<div class='panel panel-primary'>";
												echo "<div class='panel-heading'>Number of Garments Per Poly Bag</div>
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
																// echo "<th>Combo</th>";
															echo "</tr>";
															// Display Textboxes
															echo "<input type='hidden' name='noOfSizes' id='noOfSizes' value='".sizeof($color1)."' />";
															$row_count=0;
															for ($j=0; $j < sizeof($color1); $j++)
															{
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
																					echo "<td><input type='text' size='6' maxlength='5' required name='GarPerBag[$j][]' id='GarPerBag_".$row_count."_".$size_count."' class='form-control integer' onkeyup=calculateqty1($sizeofsizes,$size_of_ordered_colors); onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value='0'></td>";
																				}
																			}
																			else
																			{
																				echo "<td><input type='hidden' size='6' maxlength='5' name='GarPerBag[$j][]' id='GarPerBag_".$row_count."_".$size_count."' onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value='0'/></td>";
																			}
																		}
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
												echo "<div class='col-xs-12'>Number of Poly Bags Per Carton : <input type='text' required name='BagPerCart' id='BagPerCart' class='form-control integer' onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value='0' onkeyup=calculateqty1($sizeofsizes,$size_of_ordered_colors);></div>";
													
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
			$statuscode=0;	
			if (isset($_POST["SS_MS_save"]))
			{
				$original_size = $_POST['size'];
				$ref_size = $_POST['size1'];
				$color = $_POST['color'];
				$style = $_POST['style'];
				$schedule = $_POST['schedule'];
				$pack_method = $_POST['pack_method'];
				$schedule_original = $_POST['schedule_original'];
				$GarPerBag = $_POST['GarPerBag'];
				$BagPerCart = $_POST['BagPerCart'];
				$GarPerCart = $_POST['GarPerCart'];
				
				$descr=$_POST['description'];
				$noofcartons=$_POST['noofcartons'];
				$noofpackjobs=$_POST['noofpackjobs'];
				
				
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


				$get_inserted_id = "select id from $bai_pro3.tbl_pack_ref where ref_order_num='".$schedule."' and style_code='".$style."' ";
				$get_insert_id_result=mysqli_query($link, $get_inserted_id) or exit("Errror while selecting ID ");
				// echo $get_inserted_id.'<br>';
				while ($get_insert_id_details=mysqli_fetch_array($get_insert_id_result))
				{
					$id = $get_insert_id_details['id'];
				}


				if($id=='')
				{	
					$insert_carton_ref="insert ignore into $bai_pro3.tbl_pack_ref (ref_order_num,style_code) values('".$schedule."','".$style."')";
					$insert_carton_ref_result=mysqli_query($link, $insert_carton_ref) or exit("Errror while saving parent details");
					// echo $insert_carton_ref.'<br>';
				}	
				$get_inserted_id = "select id from $bai_pro3.tbl_pack_ref where ref_order_num='".$schedule."' and style_code='".$style."' ";
				$get_insert_id_result=mysqli_query($link, $get_inserted_id) or exit("Errror while selecting ID ");
				// echo $get_inserted_id.'<br>';
				while ($get_insert_id_details=mysqli_fetch_array($get_insert_id_result))
				{
					$id = $get_insert_id_details['id'];
				}
				
				//last sequence no from tbl_pack_size_ref
				$lastseqno="select ps.seq_no from $bai_pro3.tbl_pack_size_ref ps left join $bai_pro3.tbl_pack_ref p on p.id=ps.parent_id where ref_order_num='".$schedule."' and style_code='".$style."' group by ps.seq_no DESC LIMIT 0,1";
				$seqnorslt=mysqli_query($link, $lastseqno) or exit("Error while getting last seqno details");
				if($seq=mysqli_fetch_array($seqnorslt))
				{
					$lastseq=$seq['seq_no'];
				}
				if($lastseq!='')
				{
					$seqnew=$lastseq+1;
				}
				else
				{
					$seqnew=1;	
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
							
							

							$insert_tbl_carton_size_ref="insert ignore into $bai_pro3.tbl_pack_size_ref (parent_id, color, ref_size_name, quantity, poly_bags_per_carton, garments_per_carton, size_title, seq_no, cartons_per_pack_job, pack_job_per_pack_method, pack_method, pack_description) values('".$id."','".$color[$i]."','".$ref_size_name."','".$GarPerBag[$i][$j]."','".$BagPerCart[$j]."','".$GarPerCart[$i][$j]."','".$original_size[$j]."','".$seqnew."','".$noofcartons."','".$noofpackjobs."','".$pack_method."','".$descr."')";
							$insert_tbl_carton_ref_result=mysqli_query($link, $insert_tbl_carton_size_ref) or exit("Error while saving child details");
							// echo $insert_tbl_carton_size_ref.'<br>';
							$statuscode=1;
						}
					}
				}
				// echo "<script>sweetAlert('Packing Ratio Saved Successfully','','success')</script>";
				if($statuscode==1)
				{	
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
					function Redirect() {
						sweetAlert('Packing Ratio Saved Successfully','','success');
						location.href = \"".getFullURLLevel($_GET['r'], "order_qty_vs_packed_qty.php", "0", "N")."&style=$style&schedule=$schedule\";
						}
					</script>";
				}
				else
				{
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
					function Redirect() {
						sweetAlert('Packing Ratio not updated.',' Please Re-add Pack Method','warning');
						location.href = \"".getFullURLLevel($_GET['r'], "order_qty_vs_packed_qty.php", "0", "N")."&style=$style&schedule=$schedule\";
						}
					</script>";
				}
			}

			if (isset($_POST["MM_SM_save"]))
			{
				$original_size = $_POST['size'];
				$ref_size = $_POST['size1'];
				$color = $_POST['color'];
				$style = $_POST['style'];
				$schedule = $_POST['schedule'];
				$pack_method = $_POST['pack_method'];
				$schedule_original = $_POST['schedule_original'];
				$GarPerBag = $_POST['GarPerBag'];
				$BagPerCart = $_POST['BagPerCart'];
				$GarPerCart = $_POST['GarPerCart'];
				$descr=$_POST['description'];
				$noofcartons=$_POST['noofcartons'];
				$noofpackjobs=$_POST['noofpackjobs'];
			
				
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
				$get_inserted_id = "select id from $bai_pro3.tbl_pack_ref where ref_order_num='".$schedule."' and style_code='".$style."' ";
				$get_insert_id_result=mysqli_query($link, $get_inserted_id) or exit("Errror while selecting ID ");
				// echo $get_inserted_id.'<br>';
				while ($get_insert_id_details=mysqli_fetch_array($get_insert_id_result))
				{
					$id = $get_insert_id_details['id'];
				}
				if($id=='')
				{
					$insert_carton_ref="insert ignore into $bai_pro3.tbl_pack_ref (ref_order_num,style_code) values('".$schedule."','".$style."')";
					$insert_carton_ref_result=mysqli_query($link, $insert_carton_ref) or exit("Errror while saving parent details");
					// echo $insert_carton_ref.'<br>';
				}
				$get_inserted_id = "select id from $bai_pro3.tbl_pack_ref where ref_order_num='".$schedule."' and style_code='".$style."' ";
				$get_insert_id_result=mysqli_query($link, $get_inserted_id) or exit("Errror while selecting ID ");
				// echo $get_inserted_id.'<br>';
				while ($get_insert_id_details=mysqli_fetch_array($get_insert_id_result))
				{
					$id = $get_insert_id_details['id'];
				}
				
				$lastseqno="select ps.seq_no from $bai_pro3.tbl_pack_size_ref ps left join $bai_pro3.tbl_pack_ref p on p.id=ps.parent_id where ref_order_num='".$schedule."' and style_code='".$style."' group by ps.seq_no DESC LIMIT 0,1";
				$seqnorslt=mysqli_query($link, $lastseqno) or exit("Error while getting last seqno details");
				if($seq=mysqli_fetch_array($seqnorslt))
				{
					$lastseq=$seq['seq_no'];
				}
				if($lastseq!='')
				{
					$seqnew=$lastseq+1;
				}
				else
				{
					$seqnew=1;	
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
							$insert_tbl_carton_size_ref="insert ignore into $bai_pro3.tbl_pack_size_ref (parent_id, color, ref_size_name, quantity, poly_bags_per_carton, garments_per_carton, size_title, seq_no, cartons_per_pack_job, pack_job_per_pack_method, pack_method, pack_description) values('".$id."','".$color[$i]."','".$ref_size_name."','".$GarPerBag[$i][$j]."','".$BagPerCart."','".$GarPerCart[$i][$j]."','".$original_size[$j]."','".$seqnew."','".$noofcartons."','".$noofpackjobs."','".$pack_method."','".$descr."')";
							$insert_tbl_carton_ref_result=mysqli_query($link, $insert_tbl_carton_size_ref) or exit("Error while saving child details");
							// echo $insert_tbl_carton_size_ref.'<br>';
							$statuscode=1;
						}
					}
				}
				// echo "<script>sweetAlert('Packing Ratio Saved Successfully','','success')</script>";
				if($statuscode==1)
				{	
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
					function Redirect() {
						sweetAlert('Packing Ratio Saved Successfully','','success');
						location.href = \"".getFullURLLevel($_GET['r'], "order_qty_vs_packed_qty.php", "0", "N")."&style=$style&schedule=$schedule\";
						}
					</script>";
				}
				else
				{
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
					function Redirect() {
						sweetAlert('Packing Ratio not updated.',' Please Re-add Pack Method','warning');
						location.href = \"".getFullURLLevel($_GET['r'], "order_qty_vs_packed_qty.php", "0", "N")."&style=$style&schedule=$schedule\";
						}
					</script>";
				}
					
			}
		?>
	</div>
</div>
	

