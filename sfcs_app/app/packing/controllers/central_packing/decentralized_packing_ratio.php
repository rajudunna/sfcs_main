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
			var description=document.getElementById('description').value;
			if (description == '' || description == null)
			{
				sweetAlert('Enter Description','','warning');
				return;
			}
			else
			{
				if(redirect != false){
					event.preventDefault();
					submit_form($(this));
				}
			}				
		});
		
		$('#MM_SM_save').on('click',function(event, redirect=true)
		{
			var description=document.getElementById('description').value;
			if (description == '' || description == null)
			{
				sweetAlert('Enter Description','','warning');
				return;
			}
			else
			{
				if(redirect != false){
					event.preventDefault();
					submit_form1($(this));
				}
			}
		});

		function submit_form(submit_btn)
		{
			var no_of_cartons_size_wise = new Array();
			var noofcart_packjob=document.getElementById('noofcartons_packjob').value;		
			var size_count=document.getElementById('size_size1').value;		
			if(noofcart_packjob==0 || noofcart_packjob=='')
			{
				sweetAlert('Enter Valid Cartons per Pack Job','','warning');
				return;
			}
			else
			{
				for (var i = 0; i < size_count; i++)
				{
					no_of_cartons_size_wise[i]=document.getElementById('NoOf_Cartons_'+i).value;
				}
				var min_no = Math.min.apply(null, no_of_cartons_size_wise);
				if (min_no == 0)
				{
					sweetAlert('Enter Valid No of Cartons','','warning');
					return;
				}
				else
				{
					if(Number(noofcart_packjob) > Number(min_no))
					{
						sweetAlert('Cartons Per Pack should be less than No of Cartons','','warning');
						return;
					}
					else
					{
						sweetAlert({
							title: "Are you sure to Save the Packing Ratio?",
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
					}
				}
					
			}
		}
		
				
		function submit_form1(submit_btn)
		{
			var noofcart_packjob=document.getElementById('noofcartons_packjob').value;
			var NoOf_Cartons=document.getElementById('NoOf_Cartons1').value;
			if (NoOf_Cartons == 0)
			{
				sweetAlert('Enter Valid No of Cartons','','warning');
				return;
			}
			else
			{
				if(noofcart_packjob==0 || noofcart_packjob=='')
				{
					sweetAlert('Enter Valid Cartons per Pack Job','','warning');
					return;
				}
				else
				{
					if(Number(noofcart_packjob) > Number(NoOf_Cartons))
					{
						sweetAlert('Cartons Per Pack should be less than No of Cartons','','warning');
						return;
					}
					else
					{
						sweetAlert({
							title: "Are you sure to Save the Packing Ratio?",
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
					}
				}
			}
		}
	});
	
</script>
<style type="text/css">
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
		$pack_method=$_POST['pack_method'];
	}

?>

	
<div class="panel panel-primary">
	<div class="panel-heading"><strong>Add Packing Ratio</strong></div>
	<div class="panel-body">
		<div class="col-md-12">
			<form method="POST" class="form-inline" name="decentralized_packing_ratio">
				<label>Style:</label><input type="text" readonly name="style" id="style" value="<?php echo $style; ?>"  class='form-control'>
				&nbsp;&nbsp;
				<label>Schedule:</label><input type="text" readonly name="schedule" id="schedule" value="<?php echo $schedule; ?>"  class='form-control'>
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
				&nbsp;&nbsp;
				<input type="submit" name="submit" id="submit" class="btn btn-success" onclick="return check_val();" value="Submit">
				</form>
		</div>
		
		</br>
						
		<?php
			if (isset($_POST["submit"]) or ($_GET['style'] and $_GET['schedule'] and $_POST['pack_method']))
			{
				if ($_GET['style'] and $_GET['schedule']) {
					$style=$_GET['style'];
					$schedule=$_GET['schedule'];
					$pack_method=$_POST['pack_method'];
				} else if ($_POST['style'] and $_POST['schedule']) {
					$style=$_POST['style'];
					$schedule=$_POST['schedule'];	
					$pack_method=$_POST['pack_method'];	
				}
				//echo $style.'<br>'.$schedule.'<br>'.$pack_method.'<br>';
				$c_ref = echo_title("$bai_pro3.tbl_pack_ref","id","schedule",$schedule,$link);
				$schedule_id = echo_title("$brandix_bts.tbl_orders_master","id","product_schedule",$schedule,$link);
				$style_id = echo_title("$brandix_bts.tbl_orders_style_ref","id","product_style",$style,$link); 
				$valid_result = echo_title("$bai_pro3.tbl_pack_ref","COUNT(*)","schedule",$schedule,$link);
				$parent_id=echo_title("$bai_pro3.tbl_pack_ref","id","schedule",$schedule,$link);
				$updated_carton_method = echo_title("$bai_pro3.tbl_pack_size_ref","pack_method","parent_id",$parent_id,$link);
				{
					$o_colors = echo_title("$bai_pro3.bai_orders_db","group_concat(distinct order_col_des order by order_col_des)","bai_orders_db.order_joins NOT IN ('1','2') AND order_del_no",$schedule,$link);	
					$p_colors = echo_title("$brandix_bts.tbl_orders_sizes_master","group_concat(distinct order_col_des order by order_col_des)","parent_id",$schedule_id,$link);
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
						echo "<script>sweetAlert('Please prepare Lay Plan for all Colors in this Schedule - $schedule','','warning')</script>";
					}
					else
					{
						$sewing_jobratio_sizes_query = "SELECT GROUP_CONCAT(DISTINCT order_col_des) AS color, GROUP_CONCAT(DISTINCT size_title) AS size FROM $brandix_bts.tbl_orders_sizes_master WHERE parent_id IN ($schedule_id)";
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
							echo '<form method="POST" class="form-inline" name="SS_MS" action="?r='.$_GET['r'].'">';
								echo "<input type='hidden' name='style' id='style' value='".$style."' />";
								echo "<input type='hidden' name='schedule' id='schedule' value='".$schedule."' />";
								echo "<input type='hidden' name='pack_method' id='pack_method' value='".$pack_method."' />";
								echo "<input type='hidden' name='size1' id='size1' value='".$size1."' />";
								
								echo "<div class='panel panel-primary'>";
									echo "<div class='panel-heading'>$title</div>";
									echo "<div class='panel-body'>";
									
									echo "<div class='col-md-6 col-sm-6 col-xs-12'>
									<label>Description :</label>
									<input type='text' name='description' id='description' size='60' maxlength='60' class='form-control' required>
									</div>";
									echo"<div class=''>
									<label>No of Cartons per Pack Job :</label>
									<input type='text' name='noofcartons_packjob' id='noofcartons_packjob'  class='form-control integer' required onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value=0>
									</div>";
									/* echo"<div class='col-md-3 col-sm-3 col-xs-12'>
									<label>No of Cartons  :</label>
									<input type='text' name='noofpackjobs_packmethod' id='noofpackjobs_packmethod'  class='form-control integer' required onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value=0>
									</div>"; */
									echo "</br></br>";
								
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
																			$individual_sizes_query = "SELECT size_title FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style_id AND product_schedule=$schedule) AND order_col_des='".$color1[$j]."' AND size_title='".$size1[$size_count]."'";
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
																			$individual_sizes_query = "SELECT size_title FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style_id AND product_schedule=$schedule) AND order_col_des='".$color1[$j]."' AND size_title='".$size1[$size_count]."'";
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

										//Fourth table
										echo "<div class='panel panel-primary'>
												<div class='panel-heading'>Number of Cartons</div>
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
																	echo "<td><input type='text' size='6' maxlength='5' required name='NoOf_Cartons[]' id='NoOf_Cartons_".$size_count."' onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value='0' class='form-control integer'></td>";
																}
															echo "</tr>
														</table>
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
								$title = "Multi Color Multi Size";
							} else {
								$title = "Single Color Multi Size";
							}
							echo '<form method="POST" class="form-inline" name="MM_SM" action="?r='.$_GET['r'].'">';
								echo "<input type='hidden' name='style' id='style' value='".$style."' />";
								echo "<input type='hidden' name='schedule' id='schedule' value='".$schedule."' />";
								echo "<input type='hidden' name='pack_method' id='pack_method' value='".$pack_method."' />";
								echo "<input type='hidden' name='size1' id='size1' value='".$size1."' />";
								
								echo "<div class='panel panel-primary'>";
									echo "<div class='panel-heading'>$title</div>";
									echo "<div class='panel-body'>";
									echo "<div class='col-md-6 col-sm-6 col-xs-12'>
									<label>Description :</label>
									<input type='text' name='description' id='description' size='60' maxlength='60' class='form-control' required>
									</div>";
									echo"<div class=''>
									<label>No of Cartons per Pack Job :</label>
									<input type='text' name='noofcartons_packjob' id='noofcartons_packjob'  class='form-control integer' required onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value=0>
									</div>";
									/* echo"<div class='col-md-3 col-sm-3 col-xs-12'>
									<label>No of Cartons  :</label>
									<input type='text' name='noofpackjobs_packmethod' id='noofpackjobs_packmethod'  class='form-control integer' required onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value=0>
									</div>"; */
									echo "</br></br>";
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
																			$individual_sizes_query = "SELECT size_title FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style_id AND product_schedule=$schedule) AND order_col_des='".$color1[$j]."'  AND size_title='".$size1[$size_count]."'";
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
																			$individual_sizes_query = "SELECT size_title FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style_id AND product_schedule=$schedule) AND order_col_des='".$color1[$j]."' AND size_title='".$size1[$size_count]."'";
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

										//Fourth table
										echo "<div class='panel panel-primary'>";
												echo "<div class='panel-heading'>No of Cartons</div>";
												echo "<div class='panel-body'>";
												echo "<div class='col-xs-12'>Number of Cartons : <input type='text' required name='NoOf_Cartons1' id='NoOf_Cartons1' class='form-control integer' onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value='0' ></div>";
												echo "</div>
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
				$schedule = $_POST['schedule'];
				$GarPerBag = $_POST['GarPerBag'];
				$BagPerCart = $_POST['BagPerCart'];
				$NoOf_Cartons = $_POST['NoOf_Cartons'];
				$GarPerCart = $_POST['GarPerCart'];
				$style_id = echo_title("$brandix_bts.tbl_orders_style_ref","id","product_style",$style,$link); 
				$schedule_id = echo_title("$brandix_bts.tbl_orders_master","id","product_schedule",$schedule_id,$link);
				$descr=$_POST['description'];
				$noofcartons_packjob=$_POST['noofcartons_packjob'];
				// $noofpackjobs_packmethod=$_POST['noofpackjobs_packmethod'];
				
				
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


				$get_inserted_id = "select id from $bai_pro3.tbl_pack_ref where schedule='".$schedule."' and style='".$style."' ";
				$get_insert_id_result=mysqli_query($link, $get_inserted_id) or exit("Errror while selecting ID ");
				// echo $get_inserted_id.'<br>';
				while ($get_insert_id_details=mysqli_fetch_array($get_insert_id_result))
				{
					$id = $get_insert_id_details['id'];
				}


				if($id=='')
				{	
					$insert_carton_ref="insert ignore into $bai_pro3.tbl_pack_ref (schedule,style) values('".$schedule."','".$style."')";
					$insert_carton_ref_result=mysqli_query($link, $insert_carton_ref) or exit("Errror while saving parent details");
					// echo $insert_carton_ref.'<br>';
				}	
				$get_inserted_id = "select id from $bai_pro3.tbl_pack_ref where schedule='".$schedule."' and style='".$style."' ";
				$get_insert_id_result=mysqli_query($link, $get_inserted_id) or exit("Errror while selecting ID ");
				// echo $get_inserted_id.'<br>';
				while ($get_insert_id_details=mysqli_fetch_array($get_insert_id_result))
				{
					$id = $get_insert_id_details['id'];
				}
				
				//last sequence no from tbl_pack_size_ref
				$lastseqno="select ps.seq_no from $bai_pro3.tbl_pack_size_ref ps left join $bai_pro3.tbl_pack_ref p on p.id=ps.parent_id where schedule='".$schedule."' and style='".$style."' group by ps.seq_no DESC LIMIT 0,1";
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
							$get_ref_size_query = "SELECT ref_size_name FROM $brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM $brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style_id AND product_schedule=$schedule) AND order_col_des='".$color[$i]."' AND size_title='".$original_size[$j]."'";
							$get_ref_size_result=mysqli_query($link, $get_ref_size_query) or exit("Error while ref_size_name details");
							// echo $get_ref_size_query.'<br>';
							while ($get_ref_size_deatils=mysqli_fetch_array($get_ref_size_result))
							{
								$ref_size_name = $get_ref_size_deatils['ref_size_name'];
							}						

							$insert_tbl_carton_size_ref="insert ignore into $bai_pro3.tbl_pack_size_ref (parent_id, color, ref_size_name, quantity, poly_bags_per_carton, garments_per_carton, size_title, seq_no, cartons_per_pack_job, pack_job_per_pack_method, pack_method, pack_description) values('".$id."','".$color[$i]."','".$ref_size_name."','".$GarPerBag[$i][$j]."','".$BagPerCart[$j]."','".$GarPerCart[$i][$j]."','".$original_size[$j]."','".$seqnew."','".$noofcartons_packjob."','".$NoOf_Cartons[$j]."','".$pack_method."','".$descr."')";
							$insert_tbl_carton_ref_result=mysqli_query($link, $insert_tbl_carton_size_ref) or exit("Error while saving child details");
							// echo $insert_tbl_carton_size_ref.'<br>';
							$statuscode=1;
						}
					}
				}

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
				$schedule = $_POST['schedule'];
				$GarPerBag = $_POST['GarPerBag'];
				$BagPerCart = $_POST['BagPerCart'];
				$GarPerCart = $_POST['GarPerCart'];
				$descr=$_POST['description'];
				$noofcartons_packjob=$_POST['noofcartons_packjob'];
				// $noofpackjobs_packmethod=$_POST['noofpackjobs_packmethod'];
				$NoOf_Cartons=$_POST['NoOf_Cartons1'];
				$style_id = echo_title("$brandix_bts.tbl_orders_style_ref","id","product_style",$style,$link); 
				$schedule_id = echo_title("$brandix_bts.tbl_orders_master","id","product_schedule",$schedule,$link);
				
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
				$get_inserted_id = "select id from $bai_pro3.tbl_pack_ref where schedule='".$schedule."' and style='".$style."' ";
				$get_insert_id_result=mysqli_query($link, $get_inserted_id) or exit("Errror while selecting ID ");
				// echo $get_inserted_id.'<br>';
				while ($get_insert_id_details=mysqli_fetch_array($get_insert_id_result))
				{
					$id = $get_insert_id_details['id'];
				}
				if($id=='')
				{
					$insert_carton_ref="insert ignore into $bai_pro3.tbl_pack_ref (schedule,style) values('".$schedule."','".$style."')";
					$insert_carton_ref_result=mysqli_query($link, $insert_carton_ref) or exit("Errror while saving parent details");
					// echo $insert_carton_ref.'<br>';
				}
				$get_inserted_id = "select id from $bai_pro3.tbl_pack_ref where schedule='".$schedule."' and style='".$style."' ";
				$get_insert_id_result=mysqli_query($link, $get_inserted_id) or exit("Errror while selecting ID ");
				// echo $get_inserted_id.'<br>';
				while ($get_insert_id_details=mysqli_fetch_array($get_insert_id_result))
				{
					$id = $get_insert_id_details['id'];
				}
				
				$lastseqno="select ps.seq_no from $bai_pro3.tbl_pack_size_ref ps left join $bai_pro3.tbl_pack_ref p on p.id=ps.parent_id where schedule='".$schedule."' and style='".$style."' group by ps.seq_no DESC LIMIT 0,1";
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
							$get_ref_size_query = "SELECT ref_size_name FROM $brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM $brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style_id AND product_schedule=$schedule) AND order_col_des='".$color[$i]."' AND size_title='".$original_size[$j]."'";
							$get_ref_size_result=mysqli_query($link, $get_ref_size_query) or exit("Error while saving child details");
							// echo $get_ref_size_query.'<br>';
							while ($get_ref_size_deatils=mysqli_fetch_array($get_ref_size_result))
							{
								$ref_size_name = $get_ref_size_deatils['ref_size_name'];
							}
							$insert_tbl_carton_size_ref="insert ignore into $bai_pro3.tbl_pack_size_ref (parent_id, color, ref_size_name, quantity, poly_bags_per_carton, garments_per_carton, size_title, seq_no, cartons_per_pack_job, pack_job_per_pack_method, pack_method, pack_description) values('".$id."','".$color[$i]."','".$ref_size_name."','".$GarPerBag[$i][$j]."','".$BagPerCart."','".$GarPerCart[$i][$j]."','".$original_size[$j]."','".$seqnew."','".$noofcartons_packjob."','".$NoOf_Cartons."','".$pack_method."','".$descr."')";
							$insert_tbl_carton_ref_result=mysqli_query($link, $insert_tbl_carton_size_ref) or exit("Error while saving child details");
							// echo $insert_tbl_carton_size_ref.'<br>';
							$statuscode=1;
						}
					}
				}

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
	

