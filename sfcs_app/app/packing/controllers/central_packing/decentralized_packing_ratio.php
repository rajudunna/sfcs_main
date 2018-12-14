<script language="javascript" type="text/javascript">

	function calculateqty(size,sizeOfColors)
	{
		var min_cart_array = new Array();	var ss_ms_pac_gen_total = 0;
		for (var color = 0; color < sizeOfColors; color++)
		{
			var GarPerBag=document.getElementById('GarPerBag_'+color+'_'+size).value;
			var BagPerCart=document.getElementById('BagPerCart_'+size).value;
			var GarPerCart = Number(GarPerBag)*Number(BagPerCart);
			document.getElementById('GarPerCart_'+color+'_'+size).value = GarPerCart;
			// alert(GarPerCart+' == '+GarPerBag);
			// Automatic No of Cratons Logic
			var order_size_wise=document.getElementById('order_qty_'+color+'_'+size).value;
			if(GarPerBag>0)
			{
				// alert(GarPerCart+' == 7 '+GarPerBag);
				if (GarPerCart == 0 || GarPerCart == null || GarPerCart =='')
				{
					document.getElementById('NoOf_Cartons_'+size).value = 0;
				}
				else
				{
					// alert(GarPerCart+' == 8 '+GarPerBag);
					// console.log(GarPerCart);
					var new_temp = Number(order_size_wise)/Number(GarPerCart);
					// console.log('temp value = '+new_temp);
					if(isNaN(new_temp))
					{
						new_temp=0;
					}
					// min_cart_array[color] = Math.floor(new_temp);
					min_cart_array.push(Math.floor(new_temp));
					var min_no = Math.min.apply(null, min_cart_array);
					// console.log('array = '+min_cart_array);
					// console.log('min no45 = '+min_no);
					document.getElementById('NoOf_Cartons_'+size).value = min_no;
					document.getElementById('NoOf_Cartons_'+size).max = min_no;

				}

				// Pack Generated Logic
				var ss_ms_no_of_cart = document.getElementById('NoOf_Cartons_'+size).value;
				if (ss_ms_no_of_cart == 0)
				{
					document.getElementById('ss_ms_pac_gen_'+color+'_'+size).innerHTML = 0;
				}
				else
				{
					var temppp = ss_ms_no_of_cart * GarPerCart;
					document.getElementById('ss_ms_pac_gen_'+color+'_'+size).innerHTML = temppp;
					ss_ms_pac_gen_total = ss_ms_pac_gen_total + temppp;
				}

				// Version 2
				// var ss_ms_no_of_cart = document.getElementById('NoOf_Cartons_'+size).value;
				// if (ss_ms_no_of_cart == 0)
				// {
				// 	document.getElementById('ss_ms_pac_gen_'+color+'_'+size).innerHTML = 0;
				// 	var order_size_wise=document.getElementById('order_qty_'+color+'_'+size).value;
				// 	if (GarPerCart == 0)
				// 	{
				// 		document.getElementById('NoOf_Cartons_'+size).value = 0;
				// 	}
				// 	else
				// 	{
				// 		var new_temp = Number(order_size_wise)/Number(GarPerCart);
				// 		min_cart_array[color] = Math.floor(new_temp);
				// 		var min_no = Math.min.apply(null, min_cart_array);
				// 		console.log('min no = '+min_no);
				// 		document.getElementById('NoOf_Cartons_'+size).value = min_no;
				// 	}
				// }
				// else
				// {
				// 	var temppp = ss_ms_no_of_cart * GarPerCart;
				// 	document.getElementById('ss_ms_pac_gen_'+color+'_'+size).innerHTML = temppp;
				// }
			}	
		}
		var no_of_sizes = document.getElementById('size_size1').value;
		// console.log('array1 = '+min_cart_array);
		
		for (var color = 0; color < sizeOfColors; color++)
		{
			var abc = 0;
			for (var size = 0; size < no_of_sizes; size++)
			{
				var test = document.getElementById('ss_ms_pac_gen_'+color+'_'+size).innerHTML;
				// console.log('color = '+color+', size = '+size+', pac_gen = '+test);
				if (test > 0)
				{
					abc = abc + Number(test);
				}
			}
			document.getElementById('ss_ms_pac_gen_total_'+color).innerHTML = abc;
		}
	}

	function calculateqty1(sizeofsizes,sizeOfColors)
	{
		var pac_gen_tot_temp=0;	var mm_sm_min_cart = new Array();	var counter = 0;	var col_gpc_tot = 0;
		for (var color = 0; color < sizeOfColors; color++)
		{
			for(var size=0;size < sizeofsizes; size++)
			{
				var GarPerBag=document.getElementById('GarPerBag_'+color+'_'+size).value;
				var BagPerCart=document.getElementById('BagPerCart').value;
				var GarPerCart = GarPerBag*BagPerCart;
				document.getElementById('GarPerCart_'+color+'_'+size).value=GarPerCart;
				col_gpc_tot = col_gpc_tot + GarPerCart;
				if(GarPerBag>0)
				{
					// Store data to array (No of Cartons)
					var mm_sm_order_size_wise=document.getElementById('mm_sm_order_qty_'+color+'_'+size).value;
					if (GarPerCart == 0 || GarPerCart == null || GarPerCart =='')
					{
						document.getElementById('NoOf_Cartons1').value = 0;
					}
					else
					{
						var new_temp = Number(mm_sm_order_size_wise)/Number(GarPerCart);
						// mm_sm_min_cart[counter] = Math.floor(new_temp);
						mm_sm_min_cart.push(Math.floor(new_temp));
						counter++;
					}
				}
			}
			document.getElementById('total_'+color).value = col_gpc_tot;
			col_gpc_tot=0;
		}

		// Check Min no and assign to No of cartons
		// console.log('array = '+mm_sm_min_cart);
		if(mm_sm_min_cart.length > 0)
		{
			var min_no = Math.min.apply(null, mm_sm_min_cart);
			// console.log('min no = '+min_no);
			document.getElementById('NoOf_Cartons1').value = min_no;
			document.getElementById('NoOf_Cartons1').max = min_no;
		}

		// Pack Generated Qty Logic
		for (var col = 0; col < sizeOfColors; col++)
		{
			for(var siz=0;siz < sizeofsizes; siz++)
			{
				var gpc = document.getElementById('GarPerCart_'+col+'_'+siz).value;
				var noc = document.getElementById('NoOf_Cartons1').value;
				if (noc == 0)
				{
					document.getElementById('mm_sm_pac_gen_'+col+'_'+siz).innerHTML = 0;
				}
				else
				{
					var test = gpc * noc;
					pac_gen_tot_temp = pac_gen_tot_temp + test;
					document.getElementById('mm_sm_pac_gen_'+col+'_'+siz).innerHTML = test;
				}
			}
			document.getElementById('mm_sm_pac_gen_total_'+col).innerHTML = pac_gen_tot_temp;
			pac_gen_tot_temp=0;
		}		
	}

	function ss_ms_cart_func(no_of_cols, tot_no_of_sizes)
	{
		for (var col = 0; col < no_of_cols; col++)
		{
			var ss_ms_pac_genTotal = 0;
			for (var z = 0; z < tot_no_of_sizes; z++)
			{
				GarPerCart = document.getElementById('GarPerCart_'+col+'_'+z).value;
				var ss_ms_no_of_cart = document.getElementById('NoOf_Cartons_'+z).value;

				if (ss_ms_no_of_cart == 0)
				{
					document.getElementById('ss_ms_pac_gen_'+col+'_'+z).innerHTML = 0;
				}
				else
				{
					var temppp = ss_ms_no_of_cart * GarPerCart;
					document.getElementById('ss_ms_pac_gen_'+col+'_'+z).innerHTML = temppp;
					ss_ms_pac_genTotal = ss_ms_pac_genTotal + temppp;
				}
			}
			// console.log('tot = '+ss_ms_pac_genTotal);
			document.getElementById('ss_ms_pac_gen_total_'+col).innerHTML = ss_ms_pac_genTotal;	
		}
	}

	function mm_sm_cart_func(no_of_sizes,no_of_cols)
	{
		for (var col = 0; col < no_of_cols; col++)
		{
			var pac_gen_total = 0;
			for(var size=0;size < no_of_sizes; size++)
			{
				GarperCarton = document.getElementById('GarPerCart_'+col+'_'+size).value;
				var NoOf_Cartons1 = document.getElementById('NoOf_Cartons1').value;
				if (NoOf_Cartons1 == 0)
				{
					document.getElementById('mm_sm_pac_gen_'+col+'_'+size).innerHTML = 0;
				}
				else
				{
					var test = GarperCarton * NoOf_Cartons1;
					document.getElementById('mm_sm_pac_gen_'+col+'_'+size).innerHTML = test;
					pac_gen_total = pac_gen_total + test;
				}
			}
			document.getElementById('mm_sm_pac_gen_total_'+col).innerHTML = pac_gen_total;
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
			var noOfCols=document.getElementById('noOfCols').value;
			var temp = 0;	var temp1 = 0;	var carton_temp = 0;	var bag_per_cart = 0;	var temp2 = 0;
			if(noofcart_packjob==0 || noofcart_packjob=='')
			{
				sweetAlert('Enter Valid Cartons per Pack Job','','warning');
				return;
			}
			else
			{
				for (var col = 0; col < noOfCols; col++)
				{
					for (var siz = 0; siz < size_count; siz++)
					{
						var no_carts = Number(document.getElementById('NoOf_Cartons_'+siz).value);
						var max_cartons = Number(document.getElementById('NoOf_Cartons_'+siz).max);
						// console.log('entered cartons = '+no_carts+', max cartons = '+max_cartons);
						if (no_carts > max_cartons)
						{
							sweetAlert('No of Cartons Exceeding Max Cratons','','warning');
							return;
						}

						temp1 = Number(document.getElementById('GarPerBag_'+col+'_'+siz).value);
						temp = temp + temp1;
					}
				}
				if (temp > 0)
				{
					for (var siz = 0; siz < size_count; siz++)
					{
						temp2 = Number(document.getElementById('BagPerCart_'+siz).value);
						bag_per_cart = bag_per_cart + temp2;
					}
					if (bag_per_cart > 0)
					{
						for (var i = 0; i < size_count; i++)
						{
							if (document.getElementById('NoOf_Cartons_'+i).value > 0)
							{
								no_of_cartons_size_wise.push(document.getElementById('NoOf_Cartons_'+i).value);
								carton_temp = carton_temp + document.getElementById('NoOf_Cartons_'+i).value;
							}
							// no_of_cartons_size_wise.push(document.getElementById('NoOf_Cartons_'+i).value);
							// carton_temp = carton_temp + document.getElementById('NoOf_Cartons_'+i).value;
						}
						// console.log(no_of_cartons_size_wise);
						if (carton_temp > 0)
						{
							var min_no = Math.min.apply(null, no_of_cartons_size_wise);
							if (min_no == 0 || min_no == '')
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
						else
						{
							sweetAlert('Enter Valid No of Cartons','','warning');
							return;
						}
					}
					else
					{
						sweetAlert('Enter Valid Bags per Carton','','warning');
						return;
					}
				}
				else
				{
					sweetAlert('Enter Valid Garments Per Bag','','warning');
					return;		
				}
			}
		}
		
				
		function submit_form1(submit_btn)
		{
			var noofcart_packjob=document.getElementById('noofcartons_packjob').value;
			var NoOf_Cartons=document.getElementById('NoOf_Cartons1').value;
			var size_count=document.getElementById('size_size1').value;
			var noOfCols=document.getElementById('noOfCols').value;
			var BagPerCart=document.getElementById('BagPerCart').value;
			var temp = 0;	var temp1 = 0;	var carton_temp = 0;
			if (NoOf_Cartons == 0)
			{
				sweetAlert('Enter Valid No of Cartons','','warning');
				return;
			}
			else
			{
				var no_carts = Number(document.getElementById('NoOf_Cartons1').value);
				var max_cartons = Number(document.getElementById('NoOf_Cartons1').max);
				// console.log('entered cartons = '+no_carts+', max cartons = '+max_cartons);
				if (no_carts > max_cartons)
				{
					sweetAlert('No of Cartons Exceeding Max Cratons','','warning');
					return;
				}
				for (var col = 0; col < noOfCols; col++)
				{
					for (var siz = 0; siz < size_count; siz++)
					{
						temp1 = Number(document.getElementById('GarPerBag_'+col+'_'+siz).value);
						temp = temp + temp1;
					}
				}
				if (temp > 0)
				{
					if (BagPerCart == 0 || BagPerCart == '' || BagPerCart == null)
					{	
						sweetAlert('Enter Valid Bags Per Carton','','warning');
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
				else
				{
					sweetAlert('Enter Valid Garments Per Bag','','warning');
					return;
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

	$url2=getFullURL($_GET['r'],'order_qty_vs_packed_qty.php','N');
	
?>

	
<div class="panel panel-primary">
	<div class="panel-heading"><strong>Add Packing Ratio</strong> <?php echo "<a class='btn btn-warning	pull-right btn-sm' href='$url2&style=$style&schedule=$schedule' >Go Back</a>";  ?></div>
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
									
									echo "<label>Description :</label>
											<input type='text' name='description' id='description' size='60' maxlength='60' class='form-control' required>
										&nbsp;&nbsp;
										<label>No of Cartons per Pack Job :</label>
											<input type='text' name='noofcartons_packjob' id='noofcartons_packjob'  class='form-control integer' required onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value=0>";
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
															echo "<input type='hidden' name='noOfCols' id='noOfCols' value='".sizeof($color1)."' />";
															$row_count=0;
															for ($j=0; $j < sizeof($color1); $j++)
															{															
																// echo $combo_value;
																echo "<tr>
																		<td>$color1[$j]</td>
																		<input type='hidden' name=color[] value='".$color1[$j]."'>";
																		for ($size_count=0; $size_count < sizeof($size1); $size_count++)
																		{
																			$individual_sizes_query = "SELECT size_title FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style_id AND product_schedule='$schedule') AND order_col_des='".$color1[$j]."' AND size_title='".$size1[$size_count]."'";
																			// echo $individual_sizes_query.'<br>';
																			$individual_sizes_result=mysqli_query($link, $individual_sizes_query) or exit("Error while getting individual size Details");
																			while($individual_sizes_details=mysqli_fetch_array($individual_sizes_result)) 
																			{
																				$individual_color = $individual_sizes_details['size_title'];
																			}
																			if (mysqli_num_rows($individual_sizes_result) >0)
																			{
																				if ($size1[$size_count] == $individual_color) {
																					echo "<td><input type='text' size='6' maxlength='5' required name='GarPerBag[$j][]' id='GarPerBag_".$row_count."_".$size_count."' class='form-control integer' oninput=calculateqty($size_count,$size_of_ordered_colors); onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value='0'></td>";
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
																	echo "<td><input type='text' size='6' maxlength='5' required name='BagPerCart[]' id='BagPerCart_".$size_count."' onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value='0' class='form-control integer' oninput=calculateqty($size_count,$size_of_ordered_colors);></td>";
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
																			$individual_sizes_query = "SELECT size_title FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style_id AND product_schedule='$schedule') AND order_col_des='".$color1[$j]."' AND size_title='".$size1[$size_count]."'";
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
																	echo "<td><input type='number' size='6' maxlength='5' required name='NoOf_Cartons[]' oninput=ss_ms_cart_func($size_of_ordered_colors,".sizeof($size1).");  id='NoOf_Cartons_".$size_count."' onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value='0' min='0' max='0' class='form-control integer'></td>";
																}
															echo "</tr>
														</table>
													</div>
												</div>
											</div>";

										// Order Details Display Start
										{
											echo "<div class='panel panel-primary'>";
												echo "<div class='panel-heading'>Details</div>
												<div class='panel-body'>";
											$col_array = array();
											$sizes_query = "SELECT order_col_des FROM $bai_pro3.`bai_orders_db` WHERE order_del_no='".$schedule."' AND order_style_no='".$style."' and order_joins not in (1,2)";
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
											$pack_qty = array();

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
														// echo sizeof($col_array);ssss
														for ($j=0; $j < sizeof($col_array); $j++)
														{
															$tot_ordered = 0;	$pack_tot_saved = 0;
															$tot_planned = 0;
															$pack_tot = 0;
															for($kk=0;$kk<sizeof($size_main);$kk++)
															//foreach ($sizes_array as $key => $value)
															{
																$plannedQty_query = "SELECT SUM(quantity*planned_plies) AS plannedQty FROM $brandix_bts.tbl_cut_size_master 
																LEFT JOIN $brandix_bts.tbl_cut_master ON tbl_cut_size_master.parent_id=tbl_cut_master.id 
																LEFT JOIN $brandix_bts.tbl_orders_sizes_master ON tbl_orders_sizes_master.parent_id=tbl_cut_master.ref_order_num
																WHERE tbl_cut_master.ref_order_num=$schedule_id AND tbl_orders_sizes_master.order_col_des='$col_array[$j]' AND tbl_orders_sizes_master.size_title='$size_main[$kk]' AND tbl_cut_size_master.ref_size_name=tbl_orders_sizes_master.ref_size_name AND tbl_cut_size_master.color=tbl_orders_sizes_master.order_col_des";
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
																$orderQty_query = "SELECT SUM(order_act_quantity) AS orderedQty FROM $brandix_bts.tbl_orders_sizes_master 
																WHERE parent_id=$schedule_id AND tbl_orders_sizes_master.size_title='$size_main[$kk]' AND order_col_des = '$col_array[$j]'";
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

																$getpack_saved_qty="SELECT SUM(garments_per_carton*pack_job_per_pack_method) AS qty FROM bai_pro3.`tbl_pack_size_ref` LEFT JOIN bai_pro3.`tbl_pack_ref` ON tbl_pack_ref.`id`=tbl_pack_size_ref.`parent_id` WHERE schedule = '$schedule' AND color='$col_array[$j]' AND size_title='$size_main[$kk]'";
																// echo $getpack_saved_qty;
																$packqtyrslt=mysqli_query($link, $getpack_saved_qty) or exit("Error while getting parent id88");
																if($pack_row=mysqli_fetch_array($packqtyrslt))
																{
																	if($pack_row['qty']=='')
																	{
																		$pack_qty_saved[$col_array[$j]][$size_main[$kk]]=0;
																	}
																	else
																	{
																		$pack_qty_saved[$col_array[$j]][$size_main[$kk]]=$pack_row['qty'];
																	}
																}
															}
															// echo $col_array[$i];
															

															echo "<tr>
																	<td rowspan=4>$col_array[$j]</td>
																	<td>Order Qty</td>";
																	for ($i=0; $i < sizeof($size_main); $i++)
																	{
																		echo "<input type='hidden' name='order_qty' id='order_qty_".$j."_".$i."' value='".($planned_qty[$col_array[$j]][$size_main[$i]] - $pack_qty_saved[$col_array[$j]][$size_main[$i]]) ."' />";
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
																	<td>Pack Saved Quantity</td>";
																	for ($i=0; $i < sizeof($size_main); $i++)
																	{									
																		echo "<td>".$pack_qty_saved[$col_array[$j]][$size_main[$i]]."</td>";
																		$pack_tot_saved = $pack_tot_saved + $pack_qty_saved[$col_array[$j]][$size_main[$i]];
																	}
																	echo "<td>$pack_tot_saved</td>
																</tr>";

															echo "<tr>
																	<td>New Pack Quantity</td>";

																	for ($i=0; $i < sizeof($size_main); $i++)
																	{
																		echo "<td><p id='ss_ms_pac_gen_".$j."_".$i."'></p></td>";
																	}
																	echo "<td><p id='ss_ms_pac_gen_total_".$j."'></p></td>
																</tr>";
														}
											echo "</table>
												</div>
											</div>
											</div>";
										}
										// Order Details Display End

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
									echo "<label>Description :</label>
											<input type='text' name='description' id='description' size='60' maxlength='60' class='form-control' required>
										&nbsp;&nbsp;
										<label>No of Cartons per Pack Job :</label>
											<input type='text' name='noofcartons_packjob' id='noofcartons_packjob'  class='form-control integer' required onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value=0>";
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
															echo "<input type='hidden' name='size_size1' id='size_size1' value='".sizeof($size1)."' />";
															echo "<input type='hidden' name='noOfCols' id='noOfCols' value='".sizeof($color1)."' />";
															$row_count=0;
															for ($j=0; $j < sizeof($color1); $j++)
															{
																echo "<tr>
																		<td>$color1[$j]</td>
																		<input type='hidden' name=color[] value='".$color1[$j]."'>";
																		for ($size_count=0; $size_count < sizeof($size1); $size_count++)
																		{
																			$individual_sizes_query = "SELECT size_title FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style_id AND product_schedule='$schedule') AND order_col_des='".$color1[$j]."'  AND size_title='".$size1[$size_count]."'";
																				// echo $individual_sizes_query.'<br>';
																			$individual_sizes_result=mysqli_query($link, $individual_sizes_query) or exit("Error while getting individual size Details");
																			while($individual_sizes_details=mysqli_fetch_array($individual_sizes_result)) 
																			{
																				$individual_color = $individual_sizes_details['size_title'];
																			}
																			if (mysqli_num_rows($individual_sizes_result) >0)
																			{
																				if ($size1[$size_count] == $individual_color) {
																					echo "<td><input type='text' size='6' maxlength='5' required name='GarPerBag[$j][]' id='GarPerBag_".$row_count."_".$size_count."' class='form-control integer' oninput=calculateqty1($sizeofsizes,$size_of_ordered_colors); onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value='0'></td>";
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
												echo "<div class='col-xs-12'>Number of Poly Bags Per Carton : <input type='text' required name='BagPerCart' id='BagPerCart' class='form-control integer' onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} value='0' oninput=calculateqty1($sizeofsizes,$size_of_ordered_colors);></div>";
													
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
																			$individual_sizes_query = "SELECT size_title FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style_id AND product_schedule='$schedule') AND order_col_des='".$color1[$j]."' AND size_title='".$size1[$size_count]."'";
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
												echo "<div class='col-xs-12'>Number of Cartons : <input type='number' required name='NoOf_Cartons1' id='NoOf_Cartons1' class='form-control integer' onfocus=if(this.value==0){this.value=''} onblur=if(this.value==''){this.value=0;} oninput=mm_sm_cart_func($sizeofsizes,$size_of_ordered_colors); min='0' max='0' value='0' ></div>";
												echo "</div>
											</div>";

										// Order Details Display Start
										{
											echo "<div class='panel panel-primary'>";
												echo "<div class='panel-heading'>Details</div>
												<div class='panel-body'>";
											$col_array = array();
											$sizes_query = "SELECT order_col_des FROM $bai_pro3.`bai_orders_db` WHERE order_del_no='".$schedule."' AND order_style_no='".$style."' and order_joins not in (1,2)";
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
														// echo sizeof($col_array);ssss
														for ($j=0; $j < sizeof($col_array); $j++)
														{
															$tot_ordered = 0;	$pack_tot_saved=0;
															$tot_planned = 0;
															$pack_tot = 0;
															for($kk=0;$kk<sizeof($size_main);$kk++)
															//foreach ($sizes_array as $key => $value)
															{
																$plannedQty_query = "SELECT SUM(quantity*planned_plies) AS plannedQty FROM $brandix_bts.tbl_cut_size_master 
																LEFT JOIN $brandix_bts.tbl_cut_master ON tbl_cut_size_master.parent_id=tbl_cut_master.id 
																LEFT JOIN $brandix_bts.tbl_orders_sizes_master ON tbl_orders_sizes_master.parent_id=tbl_cut_master.ref_order_num
																WHERE tbl_cut_master.ref_order_num=$schedule_id AND tbl_orders_sizes_master.order_col_des='$col_array[$j]' AND tbl_orders_sizes_master.size_title='$size_main[$kk]' AND tbl_cut_size_master.ref_size_name=tbl_orders_sizes_master.ref_size_name AND tbl_cut_size_master.color=tbl_orders_sizes_master.order_col_des";
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
																$orderQty_query = "SELECT SUM(order_act_quantity) AS orderedQty FROM $brandix_bts.tbl_orders_sizes_master 
																WHERE parent_id=$schedule_id AND tbl_orders_sizes_master.size_title='$size_main[$kk]' AND order_col_des = '$col_array[$j]'";
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

																$getpack_saved_qty="SELECT SUM(garments_per_carton*pack_job_per_pack_method) AS qty FROM bai_pro3.`tbl_pack_size_ref` LEFT JOIN bai_pro3.`tbl_pack_ref` ON tbl_pack_ref.`id`=tbl_pack_size_ref.`parent_id` WHERE schedule = '$schedule' AND color='$col_array[$j]' AND size_title='$size_main[$kk]'";
																// echo $getpack_saved_qty;
																$packqtyrslt=mysqli_query($link, $getpack_saved_qty) or exit("Error while getting parent id88");
																if($pack_row=mysqli_fetch_array($packqtyrslt))
																{
																	if($pack_row['qty']=='')
																	{
																		$pack_qty_saved[$col_array[$j]][$size_main[$kk]]=0;
																	}
																	else
																	{
																		$pack_qty_saved[$col_array[$j]][$size_main[$kk]]=$pack_row['qty'];
																	}
																}
															}
															// echo $col_array[$i];
															

															echo "<tr>
																	<td rowspan=4>$col_array[$j]</td>
																	<td>Order Quantity</td>";
																	for ($i=0; $i < sizeof($size_main); $i++)
																	{
																		echo "<input type='hidden' name='order_qty' id='mm_sm_order_qty_".$j."_".$i."' value='".($planned_qty[$col_array[$j]][$size_main[$i]] - $pack_qty_saved[$col_array[$j]][$size_main[$i]])."' />";
																		echo "<td>".$ordered_qty[$col_array[$j]][$size_main[$i]]."</td>";
																		$tot_ordered = $tot_ordered + $ordered_qty[$col_array[$j]][$size_main[$i]];
																	}
																	echo "
																		<input type='hidden' name='order_qty_total' id='order_qty_total' value='".$tot_ordered."' />
																		<td>$tot_ordered</td>
																</tr>";

															echo "<tr>
																	<td>Cut Plan Quantity</td>";
																	for ($i=0; $i < sizeof($size_main); $i++)
																	{ 
																		echo "<td>".$planned_qty[$col_array[$j]][$size_main[$i]]."</td>";
																		$tot_planned = $tot_planned + $planned_qty[$col_array[$j]][$size_main[$i]];
																	}
																	echo "<td>$tot_planned</td>
																</tr>";

															echo "<tr>
																	<td>Pack Saved Quantity</td>";
																	for ($i=0; $i < sizeof($size_main); $i++)
																	{									
																		echo "<td>".$pack_qty_saved[$col_array[$j]][$size_main[$i]]."</td>";
																		$pack_tot_saved = $pack_tot_saved + $pack_qty_saved[$col_array[$j]][$size_main[$i]];
																	}
																	echo "<td>$pack_tot_saved</td>
																</tr>";

															echo "<tr>
																	<td>New Pack Quantity</td>";
																	for ($i=0; $i < sizeof($size_main); $i++)
																	{									
																		echo "<td><p id='mm_sm_pac_gen_".$j."_".$i."'></p></td>";
																	}
																	echo "<td><p id='mm_sm_pac_gen_total_".$j."'></p></td>
																</tr>";
														}
											echo "</table>
												</div>
											</div>
											</div>";
										}
										// Order Details Display End

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
							$get_ref_size_query = "SELECT ref_size_name FROM $brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM $brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style_id AND product_schedule='$schedule') AND order_col_des='".$color[$i]."' AND size_title='".$original_size[$j]."'";
							$get_ref_size_result=mysqli_query($link, $get_ref_size_query) or exit("Error while ref_size_name details");
							// echo $get_ref_size_query.'<br>';
							while ($get_ref_size_deatils=mysqli_fetch_array($get_ref_size_result))
							{
								$ref_size_name = $get_ref_size_deatils['ref_size_name'];
							}						

							if ($NoOf_Cartons[$j] > 0)
							{
								$insert_tbl_carton_size_ref="insert ignore into $bai_pro3.tbl_pack_size_ref (parent_id, color, ref_size_name, quantity, poly_bags_per_carton, garments_per_carton, size_title, seq_no, cartons_per_pack_job, pack_job_per_pack_method, pack_method, pack_description) values('".$id."','".$color[$i]."','".$ref_size_name."','".$GarPerBag[$i][$j]."','".$BagPerCart[$j]."','".$GarPerCart[$i][$j]."','".$original_size[$j]."','".$seqnew."','".$noofcartons_packjob."','".$NoOf_Cartons[$j]."','".$pack_method."','".$descr."')";
								$insert_tbl_carton_ref_result=mysqli_query($link, $insert_tbl_carton_size_ref) or exit("Error while saving child details");
								// echo $insert_tbl_carton_size_ref.'<br>';
								$statuscode=1;
							}
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
							$get_ref_size_query = "SELECT ref_size_name FROM $brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM $brandix_bts.`tbl_orders_master` WHERE ref_product_style=$style_id AND product_schedule='$schedule') AND order_col_des='".$color[$i]."' AND size_title='".$original_size[$j]."'";
							$get_ref_size_result=mysqli_query($link, $get_ref_size_query) or exit("Error while saving child details");
							// echo $get_ref_size_query.'<br>';
							while ($get_ref_size_deatils=mysqli_fetch_array($get_ref_size_result))
							{
								$ref_size_name = $get_ref_size_deatils['ref_size_name'];
							}

							if ($NoOf_Cartons > 0)
							{
								$insert_tbl_carton_size_ref="insert ignore into $bai_pro3.tbl_pack_size_ref (parent_id, color, ref_size_name, quantity, poly_bags_per_carton, garments_per_carton, size_title, seq_no, cartons_per_pack_job, pack_job_per_pack_method, pack_method, pack_description) values('".$id."','".$color[$i]."','".$ref_size_name."','".$GarPerBag[$i][$j]."','".$BagPerCart."','".$GarPerCart[$i][$j]."','".$original_size[$j]."','".$seqnew."','".$noofcartons_packjob."','".$NoOf_Cartons."','".$pack_method."','".$descr."')";
								$insert_tbl_carton_ref_result=mysqli_query($link, $insert_tbl_carton_size_ref) or exit("Error while saving child details");
								// echo $insert_tbl_carton_size_ref.'<br>';
								$statuscode=1;
							}							
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
	

