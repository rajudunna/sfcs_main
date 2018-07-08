<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<?php
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
	
	error_reporting(0);
	// Report simple running errors
	error_reporting(E_ERROR | E_WARNING | E_PARSE);

	
		$style=$_GET['style'];
		$schedule=$_GET['schedule'];
?>



<div class="panel panel-primary">
	<div class="panel-heading"><b>Order Details</b></div>
	<div class="panel-body">
			
			<div class="col-md-12">
			
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
						
						$mini_order_ref = echo_title("$brandix_bts.tbl_min_ord_ref","id","ref_crt_schedule",$sch_id,$link);
						$bundle = echo_title("$brandix_bts.tbl_miniorder_data","count(*)","mini_order_ref",$mini_order_ref,$link);
						$c_ref = echo_title("$brandix_bts.tbl_carton_ref","id","ref_order_num",$sch_id,$link);
						$carton_qty = echo_title("$brandix_bts.tbl_carton_size_ref","sum(quantity)","parent_id",$c_ref,$link);

						$validation_query = "SELECT * FROM $brandix_bts.`tbl_carton_ref` WHERE style_code=".$style_id." AND ref_order_num=".$sch_id."";
						// echo $validation_query;
						$sql_result=mysqli_query($link, $validation_query) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($sql_result)>0)
						{
							// echo "carton props added, You can proceed";
							if($bundle==0)
							{
								// Order Details Display Start
								{
									$col_array = array();
									$sizes_query = "SELECT order_col_des FROM $bai_pro3.`bai_orders_db` WHERE order_del_no=$schedule AND order_style_no='".$style."'";
									//echo $sizes_query;die();
									$sizes_result=mysqli_query($link, $sizes_query) or exit("Sql Error2");
									$row_count = mysqli_num_rows($sizes_result);
									while($sizes_result1=mysqli_fetch_array($sizes_result))
									{
										$col_array[]=$sizes_result1['order_col_des'];
									}

									foreach ($col_array as $key1 => $value1)
									{
										foreach ($sizes_array as $key => $value)
										{
											$query = "SELECT bod.order_s_$sizes_array[$key] as order_qty, bod.title_size_$sizes_array[$key] as title, sum(psl.a_$sizes_array[$key]*psl.a_plies) AS planned_qty FROM $bai_pro3.bai_orders_db bod LEFT JOIN $bai_pro3.plandoc_stat_log psl ON psl.order_tid=bod.order_tid WHERE order_del_no=$schedule AND order_style_no='".$style."' AND order_s_$sizes_array[$key]>0 GROUP BY order_col_des";
											// echo $query.'<br>';
											$qty=mysqli_query($link, $query) or exit("Sql Error2");
											while($qty_result=mysqli_fetch_array($qty))
											{
												// echo $qty_result['title'];
												$sizes_order_array[] = $qty_result['title'];
												$order_array[$col_array[$key1]][$qty_result['title']] = $qty_result['order_qty'];
												$planned_array[$col_array[$key1]][$qty_result['title']] = $qty_result['planned_qty'];
												$balance_array[$col_array[$key1]][$qty_result['title']] = $qty_result['order_qty']-$qty_result['planned_qty'];
											}
										}
									}
									//var_dump($order_array);
									echo "<br><div class='col-md-12'><b>Order Details: </b>
										<table class=\"table table-bordered\">
											<tr>
												<th>Details</th>
												<th>Colors</th>";
												foreach(array_unique($sizes_order_array) as $size)
												{
													echo "<th>$size</th>";
												}	
												
												echo "<th>Total</th>
											</tr>";

											$counter = 0;
											foreach ($order_array as $key => $value) 
											{
												$order_total = 0;
												if($counter == 0)
												{
													echo "<tr><td rowspan='$row_count'>Order Qty</td>";
												}
												echo "<td>".$key."</td>";
												foreach ($value as $key1 => $value1) 
												{
													foreach(array_unique($sizes_order_array) as $size)
													{
														if($key1 == $size){
															echo "<td>".$value1."</td>";
															$order_total += $value1;
														}
													}
												}
												echo "<td>$order_total</td></tr>";
												$counter++;
											}

											$counter1 = 0;
											foreach ($planned_array as $key => $value) 
											{
												$planned_total = 0;
												if($counter1 == 0)
												{
													echo "<tr><td rowspan='$row_count'>Planned Qty</td>";
												}
												echo "<td>".$key."</td>";
												foreach ($value as $key1_1 => $order_value)
												{
													foreach(array_unique($sizes_order_array) as $size)
													{
														if($key1_1 == $size){
															echo "<td>".$order_value."</td>";
															$planned_total += $order_value;
														}
													}
												}
												echo "<td>$planned_total</td></tr>";
												$counter1++;
											}

											$counter3 = 0;
											foreach ($balance_array as $key => $value) 
											{
												$balance_total = 0;
												if($counter3 == 0)
												{
													echo "<tr><td rowspan='$row_count'>Balance Qty</td>";
												}
												echo "<td>".$key."</td>";
												foreach ($value as $key1 => $balance_value) 
												{
													foreach(array_unique($sizes_order_array) as $size)
													{
														if($key1 == $size){
															echo "<td>".$balance_value."</td>";
															$balance_total += $balance_value;
														}
													}
												}
												echo "<td>$balance_total</td></tr>";
												$counter3++;
											}

									echo "</table></div>";
								}
								// Order Details Display End

								

								
							}
														
							if($bundle > 0)
							{									
								include("input_job_mix_ch_report.php");
							}
						}
						else
						{							
							echo "<script>sweetAlert('Please Update Carton Details ','Before Creating Sewing Jobs!','warning');</script>";
						}	
					}
				}
				
				?> 
		</div>
	</div>
</div>


<style>
#table1 {
  display: inline-table;
  width: 100%;
}


div#table_div {
    width: 30%;
}
#test{
margin-left:8%;
margin-bottom:2%;
}
</style>
