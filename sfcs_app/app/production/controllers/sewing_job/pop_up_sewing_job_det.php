<head>
	<link rel="stylesheet" type="text/css" href="../../../../common/css/bootstrap.min.css">
	<title>Color Wise Order Details</title>
</head>
<?php
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
	
	error_reporting(0);
?>

<div class="panel panel-primary">
	<div class="panel-heading"><b>Order Details - Color Wise</b></div>
	<div class="panel-body">
		<div class="col-md-12">
			<?php
				if($_GET['style'] and $_GET['schedule'])
				{
					$style=$_GET['style'];
					$schedule=$_GET['schedule'];
					$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style,$link);
					$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
					// Order Details Display Start
					{
						$col_array = array();
						$planned_qty = array();
						$ordered_qty = array();
						$col_array = array();
						$size_values=array();
						$filter_size=array();
						$size_tit=array();
						$sizes_query = "SELECT * FROM $bai_pro3.`bai_orders_db` WHERE order_tid not in (SELECT order_tid FROM $bai_pro3.`bai_orders_db_confirm` WHERE order_del_no=$schedule AND order_style_no='".$style."') AND order_del_no=$schedule AND order_style_no='".$style."' and $order_joins_not_in";
						$sizes_result=mysqli_query($link, $sizes_query) or exit("Sql Error2 $sizes_query");
						$row_count2 = mysqli_num_rows($sizes_result);
						if($row_count2>0)
						{
							while($sizes_result11=mysqli_fetch_array($sizes_result))
							{
								$col_array[]=$sizes_result11['order_col_des'];
								for($kki=0;$kki<sizeof($sizes_array);$kki++)
								{												
									if($sizes_result11["title_size_".$sizes_array[$kki].""]<>"")
									{
										$order_array[$sizes_result11['order_col_des']][$sizes_result11["title_size_".$sizes_array[$kki].""]]=$sizes_result11["order_s_".$sizes_array[$kki].""];
										$size_tit[]=$sizes_result11["title_size_".$sizes_array[$kki].""];
										$filter_size[]=$sizes_result11["title_size_".$sizes_array[$kki].""];
									}
								}
							}
						}
						$sizes_query1 = "SELECT * FROM $bai_pro3.`bai_orders_db_confirm` WHERE order_del_no=$schedule AND order_style_no='".$style."' and $order_joins_not_in";
						//echo $sizes_query1."<br>";
						$sizes_result1=mysqli_query($link, $sizes_query1) or exit("Sql Error2 $sizes_query");
						$row_count1 = mysqli_num_rows($sizes_result1);
						$row_count=$row_count1+$row_count2;
						if($row_count1>0)
						{
							while($sizes_result12=mysqli_fetch_array($sizes_result1))
							{
								$col_array[]=$sizes_result12['order_col_des'];
								for($kki=0;$kki<sizeof($sizes_array);$kki++)
								{												
									if($sizes_result12["title_size_".$sizes_array[$kki].""]<>"")
									{
										$plannedQty_query = "SELECT SUM(p_plies*p_$sizes_array[$kki]) AS plannedQty FROM $bai_pro3.plandoc_stat_log WHERE cat_ref IN (SELECT tid FROM $bai_pro3.cat_stat_log WHERE category IN ($in_categories) AND order_tid IN  (SELECT order_tid FROM $bai_pro3.`bai_orders_db_confirm` WHERE order_del_no=$schedule AND order_col_des='".$sizes_result12['order_col_des']."' AND $order_joins_not_in))";
										//echo $plannedQty_query."<br>";
										$plannedQty_result=mysqli_query($link, $plannedQty_query) or exit("Sql Error2");
										while($planneQTYDetails=mysqli_fetch_array($plannedQty_result))
										{
											$planned_array[$sizes_result12['order_col_des']][$sizes_result12["title_size_".$sizes_array[$kki].""]] = $planned_array[$size_tit[$kki]]+$planneQTYDetails['plannedQty'];
										}
										$order_array[$sizes_result12['order_col_des']][$sizes_result12["title_size_".$sizes_array[$kki].""]]=$sizes_result12["order_s_".$sizes_array[$kki].""];
										$size_tit[]=$sizes_result12["title_size_".$sizes_array[$kki].""];
										$filter_size[]=$sizes_result12["title_size_".$sizes_array[$kki].""];
									}
								}
							}
						}
						
						echo "<br><div class='col-md-12'>
						<div class='table-responsive'>
							<table class=\"table table-bordered\">
								<tr>
									<th>Details</th>
									<th>Colors</th>";
									foreach(array_unique($filter_size) as $size)
									{
										echo "<th>$size</th>";
									}	
									
									echo "<th>Total</th>
								</tr>";
								$order_total=0;
								echo "<tr><td rowspan='$row_count'>Order Qty</td>";
								for($kk=0;$kk<sizeof($col_array);$kk++)
								{
									echo "<td>".$col_array[$kk]."</td>";
									for($kki=0;$kki<sizeof(array_unique($filter_size));$kki++)
									{
										if($order_array[$col_array[$kk]][$filter_size[$kki]]<>"")
										{
											echo "<td>".$order_array[$col_array[$kk]][$filter_size[$kki]]."</td>";
											$order_total += $order_array[$col_array[$kk]][$filter_size[$kki]];
										}
										else
										{
											echo "<td>0</td>";
										}	
									}
									echo "<td>$order_total</td></tr>";
								}
								$planned_total=0;
								echo "<tr><td rowspan='$row_count'>Planned Qty</td>";
								for($kk=0;$kk<sizeof($col_array);$kk++)
								{
									echo "<td>".$col_array[$kk]."</td>";
									for($kki=0;$kki<sizeof(array_unique($filter_size));$kki++)
									{
										if($planned_array[$col_array[$kk]][$filter_size[$kki]]<>"")
										{
											echo "<td>".$planned_array[$col_array[$kk]][$filter_size[$kki]]."</td>";
											$planned_total  += $planned_array[$col_array[$kk]][$filter_size[$kki]];
										}
										else
										{
											echo "<td>0</td>";
										}	
									}
									echo "<td>$planned_total</td></tr>";
								}	
								$balance_value=0;$balance_total = 0;
								echo "<tr><td rowspan='$row_count'>Balance Qty</td>";
								for($kk=0;$kk<sizeof($col_array);$kk++)
								{
									echo "<td>".$col_array[$kk]."</td>";
									for($kki=0;$kki<sizeof(array_unique($filter_size));$kki++)
									{
										if($planned_array[$col_array[$kk]][$filter_size[$kki]]<>"")
										{
											$balance_value=$order_array[$col_array[$kk]][$filter_size[$kki]]-$planned_array[$col_array[$kk]][$filter_size[$kki]];
											if ($balance_value > 0) {
												$color = '#00b33c';
											} else if ($balance_value < 0 ) {
												$color = '#FF0000';
											} else if ($balance_value == 0 ) {
												$color = '#000000';
											}
											echo "<td style='color:".$color."; font-weight:bold'>".$balance_value."</td>";
											$balance_total += $balance_value;
										}
										else
										{
											$color = '#000000';
											echo "<td style='color:".$color."; font-weight:bold'>0</td>";
										}	
									}
									if ($balance_total > 0) {
										$color = '#00b33c';
									} else if ($balance_total < 0 ) {
										$color = '#FF0000';
									} else if ($balance_total == 0 ) {
										$color = '#000000';
									}
									echo "<td style='color:".$color."; font-weight:bold'>$balance_total</td></tr>";
								}								

						echo "</table></div></div>";
					}
					// Order Details Display End
				}
			?> 
		</div>
	</div>
</div>