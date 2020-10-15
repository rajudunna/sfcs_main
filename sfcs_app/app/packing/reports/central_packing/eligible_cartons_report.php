<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
		text-align: center;
	}
</style>
	<title>Eligible Carton Report</title>
	<?php
		include(getFullURLLevel($_GET['r'],'common/config/config_ajax.php',4,'R'));
		include(getFullURLLevel($_GET['r'],'common/config/enums.php',4,'R'));
		if(isset($_POST['vpo']))
		{
			$style = $_POST['style'];
			$vpo = $_POST['vpo'];
			$schedule = $_POST['schedule'];
		}
		else
		{
			$style = $_GET['style'];
			$vpo = $_GET['vpo'];
		}
		$plantcode=$_SESSION['plantCode'];
		$username=$_SESSION['userName'];
		$packing_operation = 200;
	?>
</head>
<script>
	function firstbox()
	{
		//alert("test");
		window.location.href ="<?= getFullURLLevel($_GET['r'],'eligible_cartons_report.php',0,'N'); ?>&vpo="+document.test.vpo.value;
	}

	function secondbox()
	{
		window.location.href ="<?= getFullURLLevel($_GET['r'],'eligible_cartons_report.php',0,'N'); ?>&style="+document.test.style.value+"&vpo="+document.test.vpo.value;
	}
	
	
</script> 
<body>
	<div class="panel panel-primary">
		<div class="panel-heading">Eligible Cartons</div>
		<div class="panel-body">
			<form name="test" class="form-inline" action="<?php $_GET['r'] ?>" method="POST">
			<label>Select VPO: </label>
				<select name="vpo" id="vpo" class="form-control" onchange="firstbox();" required="true">
					<option value="">Please Select</option>
					<?php
						$sql="SELECT vpo FROM $oms.oms_mo_details WHERE po_number<>'' and plant_code='$plantcode' GROUP BY vpo";
						$sql_result=mysqli_query($link, $sql) or exit("error while fetching VPO numbers");
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							// echo $sql_row['vpo']."--".strlen(trim($sql_row['vpo']))."==".strcmp(trim($sql_row['vpo']),trim($vpo))."==".strlen(trim($vpo))."--".$vpo."</br>";
							if(trim($sql_row['vpo'])==trim($vpo))
							{
								echo "<option value=\"".$sql_row['vpo']."\" selected>".$sql_row['vpo']."</option>";
							}
							else
							{
								echo "<option value=\"".$sql_row['vpo']."\">".$sql_row['vpo']."</option>";
							}
						}
					?>
				</select>
				&nbsp;&nbsp;
				<label>Select Style: </label>
				<select name="style" id="style" class="form-control" onchange="secondbox();" required>
					<option value="">Please Select</option>
					<?php
						$sql="SELECT mo_number FROM $oms.oms_mo_details WHERE po_number<>'' and plant_code='$plantcode' and vpo='$vpo'";
						$sql_result=mysqli_query($link, $sql) or exit("error while fetching mo numbers for vpo");
						while($sql_row=mysqli_fetch_array($sql_result))
						{							
							$mo_no1[] = $sql_row['mo_number'];
						}
						$mos1 = implode(',', $mo_no1);
						$sql="SELECT style FROM $oms.oms_products_info WHERE mo_number in ($mos1) GROUP BY style";
						$sql_result=mysqli_query($link, $sql) or exit("error while fetching styles");
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							if(str_replace(" ","",$sql_row['style'])==str_replace(" ","",$style))
							{
								echo "<option value=\"".$sql_row['style']."\" selected>".$sql_row['style']."</option>";
							}
							else
							{
								echo "<option value=\"".$sql_row['style']."\">".$sql_row['style']."</option>";
							}
						}
					?>
				</select>
				&nbsp;&nbsp;		
				<label>Select Schedule: </label>
				<select name="schedule" id="schedule" class="form-control" required="true">
					<option value="">Please Select</option>
					<?php
						$sql="SELECT mo_number FROM $oms.oms_products_info WHERE style='$style'";
						$sql_result=mysqli_query($link, $sql) or exit("error while fetching mo numbers for style");
						while($sql_row=mysqli_fetch_array($sql_result))
						{							
							$mo_no2[] = $sql_row['mo_number'];
						}
						$mos2 = implode(',', $mo_no2);
						$sql="SELECT schedule FROM $oms.oms_mo_details WHERE mo_number in($mos2) and po_number<>'' and plant_code='$plantcode' GROUP BY schedule";
						$sql_result=mysqli_query($link, $sql) or exit("error while fetching schedules");
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							if(str_replace(" ","",$sql_row['schedule'])==str_replace(" ","",$schedule))
							{
								echo "<option value=\"".$sql_row['schedule']."\" selected>".$sql_row['schedule']."</option>";
							}
							else
							{
								echo "<option value=\"".$sql_row['schedule']."\">".$sql_row['schedule']."</option>";
							}
						}
					?>
				</select>
				&nbsp;&nbsp;				
				<input type="submit" name="submit" id="submit" class="btn btn-success" value="Submit">
			</form>
			<?php
				if (isset($_POST['submit']))
				{					
					$url2=getFullURLLevel($_GET['r'],'controllers/central_packing/barcode_carton.php',2,'R');
					$vpo = $_POST['vpo'];
					$style = $_POST['style'];
					$schedule = $_POST['schedule'];					
					echo "<div class='col-md-12'>
					<div class=\"panel panel-primary\">
					<div class=\"panel-heading\">Style - ".$style."  &nbsp&nbsp&nbsp&nbsp Schedule - ".$schedule."</div>
					<div class=\"panel-body\">";								
					$cart_no=array();
					$complete_cart_no=array();
					$elgible_cart_no=array();
					$elgible_cart_id=array();
					$pending_cart_no=array();
					$eliminate=array();
					$mo=array();
					$mono=array();

					$oms_mo_details_sql="SELECT mo_number FROM $oms.oms_mo_details WHERE po_number<>'' and schedule='$schedule' and plant_code='$plantcode'";
					$oms_mo_details_sql_result=mysqli_query($link, $oms_mo_details_sql) or exit("error while fetching mo numbers for schedule");
					while($sql_row=mysqli_fetch_array($oms_mo_details_sql_result))
					{							
						$mo_nos3[] = $sql_row['mo_number'];
					}
					$mos3 = implode(',', $mo_nos3);
					$pm_mo_alloc_sql="SELECT pm_ct_mo_alloc_id FROM $pps.pm_container_mo_alloc WHERE mo_number in ($mos3) and plant_code='$plantcode'";
					$pm_mo_alloc_result=mysqli_query($link, $pm_mo_alloc_sql) or exit("error while fetching pack methods");
					if (mysqli_num_rows($pm_mo_alloc_result) > 0)
					{
						$pm_mo_alloc_sql="SELECT pmct.pm_packing_list_id, GROUP_CONCAT(pm_mo_alloc.mo_number) as mo_numbers, pmct.description FROM $pps.pm_container_mo_alloc as pm_mo_alloc left join $pps.pm_container_template as pmct on pm_mo_alloc.pm_container_template_id = pmct.pm_container_template_id WHERE pm_mo_alloc.mo_number in ($mos3) and pm_mo_alloc.plant_code='$plantcode' group by pmct.pm_packing_list_id";
						$pm_mo_alloc_result=mysqli_query($link, $pm_mo_alloc_sql) or exit("error while fetching pack list");
						if (mysqli_num_rows($pm_mo_alloc_result) > 0)
						{
							while($row_result=mysqli_fetch_array($pm_mo_alloc_result))
							{
								$packing_list_ids[]=$row_result['pm_packing_list_id'];
								$packing_list_mos[$row_result['pm_packing_list_id']][] = $row_result['mo_numbers'];
								$packing_methods[$row_result['pm_packing_list_id']]=$row_result['description'];
							}
							foreach($packing_list_ids as $pack_list) {
								$mo_numbers_str = $packing_list_mos[$pack_list][0];
								$jm_pack_container_sql="SELECT jm_pack_container_id FROM $pps.jm_pack_container_line WHERE mo_number IN ($mo_numbers_str) AND plant_code='$plantcode'";
								$jm_pack_container_result=mysqli_query($link, $jm_pack_container_sql) or exit("error while fetching pack containers");
								if (mysqli_num_rows($jm_pack_container_result) > 0)
								{
									while($row_result=mysqli_fetch_array($jm_pack_container_result))
									{
										$containerIds[]=$row_result['jm_pack_container_id'];
									}
									$container_ids = implode(',', $containerIds);
									$container_ids = "'".str_replace(",","','",$container_ids)."'";
									$barcode_type_packing = BarcodeType::PCRT;
									$barcode_sql="SELECT barcode_id,quantity FROM $pts.`barcode` WHERE external_ref_id IN (
									$container_ids) AND barcode_type= '$barcode_type_packing' AND plant_code = '$plantcode'";
									$barcode_result=mysqli_query($link, $barcode_sql) or exit("error while fetching barcodes");
									if (mysqli_num_rows($barcode_result) > 0)
									{
										while($row_result=mysqli_fetch_array($barcode_result))
										{
											$barcode_id = $row_result['barcode_id'];
											$quantity = $row_result['quantity'];
											$transaction_log_sql="SELECT sum(good_quantity+rejected_quantity) as reported_quantity  FROM $pts.`transaction_log` WHERE barcode_id = '$barcode_id' AND operation = '$packing_operation' AND plant_code = '$plantcode'";
											$transaction_log_result=mysqli_query($link, $transaction_log_sql) or exit("error while fetching operations data for barcode");
											if (mysqli_num_rows($transaction_log_result) > 0)
											{
												while($row_result=mysqli_fetch_array($transaction_log_result))
												{
													$reported_quantity = $row_result['reported_quantity'];
												}
											}
											// completed cartons
											if($quantity == $reported_quantity) {
												$complete_cart_no[] = $barcode_id;
											} else {
												// eligible cartons
												$fg_barcode_sql="SELECT finished_good_id FROM $pts.`fg_barcode` WHERE barcode_id ='$barcode_id' AND plant_code = '$plantcode'";
												$fg_barcode_result=mysqli_query($link, $fg_barcode_sql) or exit("error while fetching fgs");
												if (mysqli_num_rows($fg_barcode_result) > 0)
												{
													$comp_flag = true;
													// get previous operation for packing for one fg
													$singe_fg_id = mysqli_fetch_array($fg_prev_opr_result)[0]['finished_good_id'];
													$fg_prev_opr_sql="SELECT previous_operation FROM $pts.`fg_operation` WHERE finished_good_id ='$singe_fg_id' AND operation_code='$packing_operation' AND plant_code = '$plantcode' ";
													$fg_prev_opr_result=mysqli_query($link, $fg_prev_opr_sql) or exit("error while fetching fg operations");
													if (mysqli_num_rows($fg_prev_opr_result) > 0)
													{
														$pre_operation=mysqli_fetch_array($fg_prev_opr_result)[0]['previous_operation'];
													}
													
													// check components equal or not
													while($row_result=mysqli_fetch_array($fg_barcode_result))
													{
														$fg_id = $row_result['finished_good_id'];
														$fg_opr_comp_sql="SELECT required_components,completed_components FROM $pts.`fg_operation` WHERE finished_good_id ='$fg_id' AND operation_code='$pre_operation' AND plant_code = '$plantcode' ";
														$fg_opr_comp_result=mysqli_query($link, $fg_opr_comp_sql) or exit("error while fetching fg operation components");
														if (mysqli_num_rows($fg_opr_comp_result) > 0)
														{
															$fg_comp_data =mysqli_fetch_array($fg_opr_comp_result)[0];
															if($fg_comp_data['required_components'] != $fg_comp_data['completed_components']) {
																$comp_flag = false;
																break; 
															}
														}
													}
													// if true show it in eligible carton and false its pending carton
													if($comp_flag) {
														// eligible cartons
														$elgible_cart_no[] = $barcode_id;
														$label_concat .= $barcode_id.",";
													} else {
														// Pending cartons
														$pending_cart_no[] = $barcode_id;
													}
													$label_concat=substr($label_concat,0,-1);

													if ($label_concat == '' || $label_concat == null)
													{
														$hide = "style='display: none'";
													}
													else
													{
														$hide = '';
													}
												}
											}											
										}
									}
								}
								echo "<br>
								<div class='col-md-12'>
									<div class=\"panel panel-primary\">
										<div class=\"panel-heading\">".$packing_methods[$pack_list]."</div>
										<div class=\"panel-body\">
											<table class='table table-bordered'>
												<thead>
													<tr class='info'>
														<th width=\"33%\">Completed Cartons</th>
														<th width=\"33%\">Eligible Cartons</th>
														<th width=\"33%\">Pending Cartons</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>";
														//&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <a class='btn btn-warning btn-xs' href='$url2?schedule=$schedule&carton_no=$label_concat' target='_blank' $hide>Print All Cartons</a>
														$k=0;
														if(sizeof($complete_cart_no)>0)
														{
															for($j=0;$j<sizeof($complete_cart_no);$j++)
															{	
																if($k==10)
																{
																	echo "<br>";
																	$k=0;
																}															
																echo "<a class='btn btn-success btn-xs'>".$complete_cart_no[$j]."</a>";
															}
														}
														echo"</td><td>";
														$k=0;
														if(sizeof($elgible_cart_no)>0)
														{
															for($jj=0;$jj<sizeof($elgible_cart_no);$jj++)
															{
																if($k==10)
																{
																	echo "<br>";
																	$k=0;
																}	
																//href='$url2?schedule=$schedule&carton_no=$elgible_cart_no[$jj]&seq_no=".$pack_result12['pac_seq_no']."' target='_blank'
																echo "<a class='btn btn-warning btn-xs'>".$elgible_cart_no[$jj]."</a>";
																$k++;
															}
														}																	
														echo"</td><td>";
														$k=0;
														if(sizeof($pending_cart_no)>0)
														{
															for($jjj=0;$jjj<sizeof($pending_cart_no);$jjj++)
															{
																if($k==10)
																{
																	echo "<br>";
																	$k=0;
																}
																echo "<a class='btn btn-danger btn-xs'>".$pending_cart_no[$jjj]."</a>";
															}
														}														
														echo"
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>";
								unset($complete_cart_no);
								unset($elgible_cart_no);
								unset($pending_cart_no);
							}
						}					
					}
					else
					{
						echo " <div class='alert alert-info alert-dismissible'><h3>Packing List is not yet generated.<br></h3>";			
						echo "</div>";
					}
					echo "</div>
				  </div>
				  </div>";
				  echo "</br>";					
				}
			?>
		</div>
	</div>
</body>
</html>