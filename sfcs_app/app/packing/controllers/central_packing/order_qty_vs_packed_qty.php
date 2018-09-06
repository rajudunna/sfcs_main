<head>
	<script language="javascript" type="text/javascript">
	
	var url1 = '<?= getFullURL($_GET['r'],'order_qty_vs_packed_qty.php','N'); ?>';
	function myFunction() {
		document.getElementById("generate").style.visibility = "hidden";
	}

	function firstbox()
	{
		//alert("report");
		window.location.href =url1+"&style="+document.mini_order_report.style.value
	}

	function secondbox()
	{
		//alert('test');
		window.location.href =url1+"&style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
	}

</script>
</head>
<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/header_scripts.php',2,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/menu_content.php',2,'R')); 
    $has_permission=haspermission($_GET['r']);
	
	error_reporting(0);
?>

<div class="panel panel-primary">
	<div class="panel-heading"><b>Order Details Vs Packed Details</b></div>
	<div class="panel-body">
	<?php
	if(isset($_POST['style']))
	{
	    $style=$_POST['style'];
	    $schedule=$_POST['schedule'];
	}
	else
	{
		$style=$_GET['style'];
		$schedule=$_GET['schedule'];
	}
				echo "<form name=\"mini_order_report\" action=\"#\" method=\"post\" >";
				echo "<div class='col-md-3 col-sm-3 col-xs-12'>";
				?>
					Style:
					<?php
						// Style
						echo "<select name=\"style\" id=\"style\" class='form-control' onchange=\"firstbox();\" >";
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
						echo "</div>";
						echo "<div class='col-md-3 col-sm-3 col-xs-12'>";
					?>

					&nbsp;Schedule:
					<?php
						// Schedule
						echo "<select class='form-control' name=\"schedule\" id=\"schedule\"  >";
						$sql="select * from $brandix_bts.tbl_orders_master where ref_product_style='".$style."'";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result);
						echo "<option value=\"NIL\" selected>Select Schedule</option>";
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$schedule))
							{
								echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['product_schedule']."</option>";
							}
							else
							{
								echo "<option value=\"".$sql_row['id']."\">".$sql_row['product_schedule']."</option>";
							}
						}
						echo "</select>";
						echo "</div>";
					?>
					&nbsp;&nbsp;
					<div class='col-md-3 col-sm-3 col-xs-12'>
					<input type="submit" name="submit" id="submit" class="btn btn-success " value="Submit" style="margin-top: 18px;">
					</div>
				</form>
		<div class="col-md-12">
			<?php
			if(isset($_POST['submit']))
			{	
				if($_POST['style'] and $_POST['schedule'])
				{
					$style=$_POST['style'];
					$schedule=$_POST['schedule'];
					// echo "Style= ".$style_id."<br>Schedule= ".$sch_id.'<br>';
					$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style,$link);
					$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
					
					$mini_order_ref = echo_title("$brandix_bts.tbl_min_ord_ref","id","ref_crt_schedule",$schedule,$link);
					$bundle = echo_title("$brandix_bts.tbl_miniorder_data","count(*)","mini_order_ref",$mini_order_ref,$link);
					$c_ref = echo_title("$brandix_bts.tbl_carton_ref","id","ref_order_num",$sch_id,$link);
					$carton_qty = echo_title("$brandix_bts.tbl_carton_size_ref","sum(quantity)","parent_id",$c_ref,$link);


					// Order Details Display Start
					{
						$col_array = array();
						$sizes_query = "SELECT order_col_des FROM $bai_pro3.`bai_orders_db` WHERE order_del_no=$schedule AND order_style_no='".$style."'";
						//echo $sizes_query;die();
						$sizes_result=mysqli_query($link, $sizes_query) or exit("Sql Error2 $sizes_query");
						$row_count = mysqli_num_rows($sizes_result);
						while($sizes_result1=mysqli_fetch_array($sizes_result))
						{
							$col_array[]=$sizes_result1['order_col_des'];
							
						}

						foreach ($sizes_array as $key => $value)
						{
							$query = "SELECT bod.order_s_$sizes_array[$key] as order_qty, bod.title_size_$sizes_array[$key] as title, sum(psl.p_$sizes_array[$key]*psl.p_plies) AS planned_qty,order_col_des FROM $bai_pro3.bai_orders_db bod LEFT JOIN $bai_pro3.plandoc_stat_log psl ON psl.order_tid=bod.order_tid WHERE order_del_no=$schedule AND order_style_no='".$style."' AND order_s_$sizes_array[$key]>0 GROUP BY order_col_des";
						//	echo $query.'<br>';
							$qty=mysqli_query($link, $query) or exit("Sql Error2");
							while($qty_result=mysqli_fetch_array($qty))
							{
								// echo $qty_result['title'];
								$sizes_order_array[] = $qty_result['title'];
								//echo $col_array[$key1]."-".$qty_result['order_col_des']."-".$qty_result['title']."-".$qty_result['order_qty']."</br>";
								$order_array[$qty_result['order_col_des']][$qty_result['title']] = $qty_result['order_qty'];
								$planned_array[$qty_result['order_col_des']][$qty_result['title']] = $qty_result['planned_qty'];
								$balance_array[$qty_result['order_col_des']][$qty_result['title']] = $qty_result['planned_qty']-$qty_result['order_qty'];
							}
						}
						//var_dump($order_array);
						echo "<br><div class='col-md-12'>
							<table class=\"table table-bordered\">
								<tr>
									<th>Colors</th>
									<th>Details</th>";
									foreach(array_unique($sizes_order_array) as $size)
									{
										echo "<th>$size</th>";
									}	
									
									echo "<th>Total</th></tr>";
									// echo "<th></th></tr>";

								$counter = 0;
								foreach ($order_array as $key => $value) 
								{
									//order qty
									echo "<tr><td rowspan='3'>".$key."</td>";
									$finkey=$key;
									$order_total = 0;
									
										echo "<td>Order</td>";
									
									
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
									echo "<td>$order_total</td>";
									// echo "<td></td>";
									$counter++;
									//Cut qty
									echo "<tr>";
									$planned_total = 0;
									
										echo "<td>Cut</td>";
									
									
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
									echo "<td>$planned_total</td>";
									// echo "<td></td>";
									$counter1++;
									//pack generated
									echo "<tr>";
									$balance_total = 0;
									
										echo "<td>Pack Generated</td>";
									
									
									foreach ($value as $key1 => $balance_value) 
									{
										foreach(array_unique($sizes_order_array) as $size)
										{
											if($key1 == $size){
												if ($balance_value > 0) {
													$color = '#00b33c';
												} else if ($balance_value < 0 ) {
													$color = '#FF0000';
												} else if ($balance_value == 0 ) {
													$color = '#000000';
												}
												// echo "<td style='color:".$color."; font-weight:bold'>".$balance_value."</td>";
												echo "<td></td>";
												$balance_total += $balance_value;
											}
										}
									}

									if ($balance_total > 0) {
										$color = '#00b33c';
									} else if ($balance_total < 0 ) {
										$color = '#FF0000';
									} else if ($balance_total == 0 ) {
										$color = '#000000';
									}
									// echo "<td style='color:".$color."; font-weight:bold'>$balance_total</td></tr>";
									echo "<td></td></tr>";
									$counter3++;
								}

						echo "</table></div>";
					}
					// Order Details Display End
				}
				
						
			}
			?> 
		</div>
	</div>
</div>