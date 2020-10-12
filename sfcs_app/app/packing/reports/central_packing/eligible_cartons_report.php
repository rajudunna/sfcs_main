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
		include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
		include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
		include(getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',4,'R'));
		if(isset($_POST['vpo']))
		{
			$style = $_POST['style'];
			$vpo = $_POST['vpo'];
			$schedule = $_POST['schedule'];
		}
		else
		{
			$style = style_decode($_GET['style']);
			$vpo = $_GET['vpo'];
		}
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
		window.location.href ="<?= getFullURLLevel($_GET['r'],'eligible_cartons_report.php',0,'N'); ?>&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))+"&vpo="+document.test.vpo.value;
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
						$sql="SELECT vpo FROM $bai_pro3.bai_orders_db_confirm left join $bai_pro3.pac_stat on $bai_pro3.pac_stat.style=$bai_pro3.bai_orders_db_confirm.order_style_no WHERE vpo<>'' GROUP BY vpo";
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
						$sql="SELECT order_style_no as style FROM $bai_pro3.bai_orders_db_confirm left join $bai_pro3.pac_stat on $bai_pro3.pac_stat.style=$bai_pro3.bai_orders_db_confirm.order_style_no WHERE vpo='$vpo'and vpo<>'' GROUP BY order_style_no";
						$sql_result=mysqli_query($link, $sql) or exit("error while fetching VPO numbers");
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
						$sql="SELECT order_del_no as schedule FROM $bai_pro3.bai_orders_db_confirm WHERE vpo='$vpo' and order_style_no='$style' GROUP BY order_del_no";
						$sql_result=mysqli_query($link, $sql) or exit("error while fetching VPO numbers");
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
					$pack_meth_qry1="SELECT pac_seq_no FROM $bai_pro3.pac_stat WHERE style='$style' and schedule='$schedule' GROUP BY pac_seq_no ORDER BY pac_seq_no";
					//echo $pack_meth_qry1;
					$pack_meth_qty12=mysqli_query($link, $pack_meth_qry1) or exit("error while fetching pack methods1");
					if (mysqli_num_rows($pack_meth_qty12) > 0)
					{
						// All MO details
						$mo_sql="SELECT mo_no FROM $bai_pro3.mo_details WHERE schedule='$schedule'";
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
							$mo_sql1="SELECT mo_no,remaining_qty FROM $bai_pro3.tbl_carton_ready WHERE mo_no in ('".implode("','",$mo)."')";
							$sql_result23=mysqli_query($link, $mo_sql1) or exit("error while fetching pack methods3");
							while($row_result23=mysqli_fetch_array($sql_result23))
							{
								if($row_result23['remaining_qty']>0)
								{
									$eligible[$row_result23['mo_no']]=$row_result23['remaining_qty'];
								}
							}
							$pac_stat="SELECT pac_stat_id,carton_no,status as cart_status,group_concat(tid) as tids FROM $bai_pro3.packing_summary WHERE order_del_no='$schedule' and seq_no='".$pack_result12['pac_seq_no']."' group by pac_stat_id";
							//echo $pac_stat."<bR>";
							$label_concat='';
							$pac_stat_result=mysqli_query($link, $pac_stat) or exit("error while fetching pack methods4");
							while($row_result1=mysqli_fetch_array($pac_stat_result))
							{
								$status=0;
								if($row_result1['cart_status']=='DONE')
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
							if(sizeof($cart_no)>0)
							{												
								$pac_stat3="SELECT * FROM $bai_pro3.pac_stat WHERE schedule='$schedule' and pac_seq_no='".$pack_result12['pac_seq_no']."' and carton_no not in (".implode(",",$cart_no).")";
							}
							else
							{
								$pac_stat3="SELECT * FROM $bai_pro3.pac_stat WHERE schedule='$schedule' and pac_seq_no='".$pack_result12['pac_seq_no']."'";
							}
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
							if ($label_concat == '' || $label_concat == null)
							{
								$hide = "style='display: none'";
							}
							else
							{
								$hide = '';
							}
							
							$url2=getFullURLLevel($_GET['r'],'controllers/central_packing/barcode_carton.php',2,'R');
							echo "<br>
							<div class='col-md-12'>
								<div class=\"panel panel-primary\">
									<div class=\"panel-heading\">".$operation[$pack_method]." --- ".$pack_description."</div>
									<div class=\"panel-body\">
										<table class='table table-bordered'>
											<thead>
												<tr class='info'>
													<th width=\"33%\">Completed Cartons</th>";
													// echo "<th width=\"33%\">Eligible Cartons &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp<a class='btn btn-warning btn-xs' href='$url2?schedule=$schedule&carton_no=$label_concat&seq_no=".$pack_result12['pac_seq_no']."' target='_blank' $hide>Print All Cartons</a></th>";
													echo "<th><form action='$url2' method='POST'>Eligible Cartons &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp<input type='hidden' name='schedule' value='$schedule'><input type='hidden' name='carton_no' value='$label_concat'><input type='hidden' name='seq_no' value='".$pack_result12['pac_seq_no']."'>
														<button type='submit' class='btn btn-warning btn-xs' target='_blank' $hide>Print All Cartons</button>
													</form></th><th width=\"33%\">Pending Cartons</th>
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