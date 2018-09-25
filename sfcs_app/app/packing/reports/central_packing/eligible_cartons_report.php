<!DOCTYPE html>
<html>
<head>
	<title>Eligible Carton Report</title>
	<?php
		include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
		include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
		if(isset($_POST['vpo']))
		{
			$vpo = $_POST['vpo'];
		}
		else
		{
			$vpo = $_POST['vpo'];
		}
	?>
</head>
<body>
	<div class="panel panel-primary">
		<div class="panel-heading">Eligible Cartons</div>
		<div class="panel-body">
			<form class="form-inline" action="<?php $_GET['r'] ?>" method="POST">
				<label>Select VPO: </label>
				<select name="vpo" id="vpo" class="form-control" required="true">
					<option value="">Please Select</option>
					<?php
						$sql="SELECT zfeature as vpo FROM $bai_pro3.mo_details WHERE zfeature<>'' GROUP BY zfeature";
						$sql_result=mysqli_query($link, $sql) or exit("error while fetching VPO numbers");
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							if(str_replace(" ","",$sql_row['vpo'])==str_replace(" ","",$vpo))
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
				<input type="submit" name="submit" id="submit" class="btn btn-success">
			</form>
			<?php
				if (isset($_POST['submit']))
				{
					$vpo = $_POST['vpo'];
					$mo_no_query = "SELECT pac_stat.style AS style, GROUP_CONCAT(DISTINCT pac_stat.schedule) AS schedules FROM bai_pro3.mo_details LEFT JOIN bai_pro3.pac_stat ON pac_stat.schedule=mo_details.schedule WHERE zfeature ='".$vpo."' GROUP BY style";
					//echo $mo_no_query;
					$mo_result=mysqli_query($link, $mo_no_query) or exit("Error while getting schedules");
					if (mysqli_num_rows($mo_result) > 0)
					{
						while($row_result=mysqli_fetch_array($mo_result))
						{
							if($row_result['schedules'] <> '')
							{
								$style = $row_result['style'];
								$schedule_tmp = explode(",",$row_result['schedules']);
								echo "<div class='col-md-12'>
									<div class=\"panel panel-primary\">
									<div class=\"panel-heading\">Style - ".$style." </div>
									<div class=\"panel-body\">";
								for($k=0;$k<sizeof($schedule_tmp);$k++)
								{
									$schedule=$schedule_tmp[$k];
									echo "<div class='col-md-12'>
									<div class=\"panel panel-primary\">
									<div class=\"panel-heading\">Schedule - ".$schedule."</div>
									<div class=\"panel-body\">";								
									$cart_no=array();
									$complete_cart_no=array();
									$elgible_cart_no=array();
									$elgible_cart_id=array();
									$pending_cart_no=array();
									$eliminate=array();
									$mo=array();
									$mono=array();
									$pack_meth_qry1="SELECT pac_seq_no FROM $bai_pro3.pac_stat WHERE style='$style' and schedule='$schedule' GROUP BY pac_seq_no ORDER BY pac_seq_no";
									//echo $pack_meth_qry1;
									$pack_meth_qty12=mysqli_query($link, $pack_meth_qry1) or exit("error while fetching pack methods1");
									if (mysqli_num_rows($pack_meth_qty12) > 0)
									{
										// All MO details
										$mo_sql="SELECT * FROM $bai_pro3.mo_details WHERE schedule='$schedule'";
										//echo $mo_sql."<br>";
										$sql_result=mysqli_query($link, $mo_sql) or exit("error while fetching pack methods2");
										while($row_result=mysqli_fetch_array($sql_result))
										{
											$mo[]=$row_result['mo_no'];
										}
										//var_dump($mo)."<br>";
										//echo implode(",",$mo)."<br>";
										while($pack_result12=mysqli_fetch_array($pack_meth_qty12))
										{ 									
											// Eligible Quantity MO Wise
											$mo_sql1="SELECT * FROM $bai_pro3.tbl_carton_ready WHERE mo_no in (".implode(",",$mo).")";
											$sql_result23=mysqli_query($link, $mo_sql1) or exit("error while fetching pack methods3");
											while($row_result23=mysqli_fetch_array($sql_result23))
											{
												if($row_result23['remaining_qty']>0)
												{
													$eligible[$row_result23['mo_no']]=$row_result23['remaining_qty'];
												}
											}
											$pac_stat="SELECT pac_stat_id,carton_no,status,group_concat(tid) as tids FROM $bai_pro3.packing_summary WHERE order_del_no='$schedule' and seq_no='".$pack_result12['pac_seq_no']."' group by pac_stat_id";
											//echo $pac_stat."<bR>";
											$label_concat='';
											$pac_stat_result=mysqli_query($link, $pac_stat) or exit("error while fetching pack methods4");
											while($row_result1=mysqli_fetch_array($pac_stat_result))
											{
												$status=0;
												if($row_result1['status']=='DONE')
												{
													$complete_cart_no[]=$row_result1['carton_no'];
													$cart_no[]=$row_result1['carton_no'];
												}
												else
												{	
													$mo_qty="SELECT mo_no,sum(bundle_quantity) as qty FROM $bai_pro3.mo_operation_quantites WHERE ref_no in (".$row_result1['tids'].")  and op_code='200' group by mo_no";
													//echo $mo_qty."<br>";
													$mo_qty_result=mysqli_query($link, $mo_qty) or exit("error while fetching pack methods6");
													while($mo_qty_row=mysqli_fetch_array($mo_qty_result))
													{
														if(($eligible[$mo_qty_row['mo_no']]-$mo_qty_row['qty'])<0)
														{
															$status=1;
														}
														$eliminate[$mo_qty_row['mo_no']]=$mo_qty_row['qty'];	
														$mono[]=$mo_qty_row['mo_no'];
													}
													//echo $status."--Status--<br>";
													//echo $row_result1['carton_no']."--Carton--<br>";
													//echo $eliminate[$mo_qty_row['mo_no']]."<br>";
													
													if($status==0)
													{
														for($i=0;$i<sizeof($mono);$i++)
														{
															//echo "Before---".$mono[$i]."-----".$eligible[$mono[$i]]."----".$eliminate[$mono[$i]]."<br>";
															$eligible[$mono[$i]]=$eligible[$mono[$i]]-$eliminate[$mono[$i]];
															//echo "After---".$eligible[$mono[$i]]."<br>";
														}
														$elgible_cart_no[]=$row_result1['carton_no'];
														$label_concat .= $row_result1['carton_no'].",";
														$elgible_cart_id[]=$row_result1['pac_stat_id'];
														$cart_no[]=$row_result1['carton_no'];
													}										
												}
												unset($eliminate);
												unset($mono);
											}
											$label_concat=substr($label_concat,0,-1);
											//echo $label_concat."<br>";											
											//var_dump($elgible_cart_no);	
											$pac_stat3="SELECT * FROM $bai_pro3.pac_stat WHERE schedule='$schedule' and pac_seq_no='".$pack_result12['pac_seq_no']."' and carton_no not in (".implode(",",$cart_no).")";
											//echo $pac_stat3."<br>";
											$pac_stat_result3=mysqli_query($link, $pac_stat3) or exit("error while fetching pack methods8");
											if(mysqli_num_rows($pac_stat_result3)>0)
											{
												while($row_result3=mysqli_fetch_array($pac_stat_result3))
												{
													$pending_cart_no[]=$row_result3['carton_no'];
												}
											}									
											$pack_meth_qry="SELECT pack_method,pack_description FROM bai_pro3.tbl_pack_ref LEFT JOIN bai_pro3.tbl_pack_size_ref ON bai_pro3.tbl_pack_ref.id=bai_pro3.tbl_pack_size_ref.parent_id WHERE bai_pro3.tbl_pack_size_ref.seq_no='".$pack_result12['pac_seq_no']."' AND bai_pro3.tbl_pack_ref.schedule='$schedule' LIMIT 1";
											//echo $pack_meth_qry;
											$pack_meth_qty=mysqli_query($link, $pack_meth_qry) or exit("error while fetching pack methods9");
											while($pack_result1=mysqli_fetch_array($pack_meth_qty))
											{
												$pack_method=$pack_result1['pack_method'];
												$pack_description=$pack_result1['pack_description'];
											}
											
											//$url2=getFullURL($_GET['r'],'barcode_carton.php','R');
											
											$url2=getFullURLLevel($_GET['r'],'controllers/central_packing/barcode_carton.php',2,'R');
											echo "<br>
											<div class='col-md-12'>
												<div class=\"panel panel-primary\">
													<div class=\"panel-heading\">".$operation[$pack_method]." --- ".$pack_description."</div>
													<div class=\"panel-body\">
														<table class='table table-bordered'>
															<thead>
																<tr class='info'>
																	<th width=\"33%\">Completed Cartons</th>
																	<th width=\"33%\">Eligible Cartons </th>
																	<th width=\"33%\">Pending Cartons</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>";
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
																			echo "<a class='btn btn-warning btn-xs' href='$url2?schedule=$schedule&carton_no=$elgible_cart_no[$jj]&seq_no=".$pack_result12['pac_seq_no']."' target='_blank'>".$elgible_cart_no[$jj]."</a>";
																			$k++;
																		}
																	}
																	echo "<a class='btn btn-warning btn-xs' href='$url2?schedule=$schedule&carton_no=$label_concat&seq_no=".$pack_result12['pac_seq_no']."' target='_blank'>Print All Cartons</a>";	
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
											unset($eligible);
											unset($cart_no);
											unset($complete_cart_no);
											unset($elgible_cart_no);
											unset($elgible_cart_id);
											unset($pending_cart_no);
											unset($eliminate);
											unset($mono);
										}
									}
									echo "</div>
								  </div>
								  </div>";
								  echo "</br>";
								}
								echo "</div>
								  </div>
								  </div>";
								echo "</br>";								
							}															  
						}
					}	
					else
					{
						echo "<script>sweetAlert('No Schedule Numbers available with this VPO - ".$vpo."','','warning')</script>";
					}					
				}
			?>
		</div>
	</div>
</body>
</html>