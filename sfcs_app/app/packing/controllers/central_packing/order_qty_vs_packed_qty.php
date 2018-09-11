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

	function check_val()
	{
		//alert('dfsds');
		var style=document.getElementById("style").value;
		var schedule=document.getElementById("schedule").value;
		
		if(style == 'NIL' || schedule == 'NIL')
		{
			sweetAlert('Please select style and schedule','','warning');
			// document.getElementById('submit').style.display=''
			// document.getElementById('msg').style.display='none';
			return false;
		}
		return true;	
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
					<input type="submit" name="submit" id="submit" class="btn btn-success " onclick="return check_val();" value="Submit" style="margin-top: 18px;">
					</div>
				</form>
		<div class="col-md-12">
			<?php
			if(isset($_POST['submit']) or $_GET['style'] and $_GET['schedule'])
			{	
				// if($_POST['style'] and $_POST['schedule'])
				{
					
					if ($_GET['style'] and $_GET['schedule'])
					{
						$style=$_GET['style'];
						$schedule=$_GET['schedule'];
					} 
					else if ($_POST['style'] and $_POST['schedule'])
					{
						$style=$_POST['style'];
						$schedule=$_POST['schedule'];	
					}
					// echo $style."---".$schedule;
					//getting parent id from tbl_pack_ref
					$getparentid="select id from $bai_pro3.tbl_pack_ref where ref_order_num='$schedule' and style_code='$style'";
					$parentidrslt=mysqli_query($link, $getparentid) or exit("Error while getting parent id");
					if($row=mysqli_fetch_array($parentidrslt))
					{
						$parent=$row['id'];
					}
					
					
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
								<tr class='info'>
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
									echo "<tr><td rowspan='4'>".$key."</td>";
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
									
									
									
									
									
									echo "<tr>";
									$pack_tot = 0;
									
										echo "<td>Pack Generated</td>";
									
									
									foreach ($value as $key1_1 => $order_value)
									{
										foreach(array_unique($sizes_order_array) as $size)
										{
											if($key1_1 == $size){
												// echo $key."---".$size."</br>";
												$getpackqty="select sum(carton_act_qty) as qty from $bai_pro3.pac_stat_log where schedule='$schedule' and color='$key' and size_tit='$size'";
												// echo $getpackqty;
												$packqtyrslt=mysqli_query($link, $getpackqty) or exit("Error while getting parent id");
												if($row=mysqli_fetch_array($packqtyrslt))
												{
													$qty=$row['qty'];
												}
												
												echo "<td>".$qty."</td>";
												$pack_tot += $qty;
											}
										}
									}
									echo "<td>$pack_tot</td>";
									
									
									
									
									
									
									
									//pack generated
									echo "<tr>";
									$balance_total = 0;
									
										// echo "<td>Total</td>";
									
									
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
												// echo "<td></td>";
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
									echo "</tr>";
									$counter3++;
								}

						echo "</table></div>";
					}
					// Order Details Display End
				}
				//packing method details
				// $style=$_POST['style'];
				// $schedule=$_POST['schedule'];
				if ($_GET['style'] and $_GET['schedule'])
					{
						$style=$_GET['style'];
						$schedule=$_GET['schedule'];
					} 
					else if ($_POST['style'] and $_POST['schedule'])
					{
						$style=$_POST['style'];
						$schedule=$_POST['schedule'];	
					}
				$get_pack_id=" select id from $bai_pro3.tbl_pack_ref where ref_order_num=$schedule AND style_code='".$style."'"; 
				// echo $get_pack_id;
				$get_pack_id_res=mysqli_query($link, $get_pack_id) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$row = mysqli_fetch_row($get_pack_id_res);
				$pack_id=$row[0];
				// echo $pack_id;
				// die();
				$pack_meth_qry="SELECT *,parent_id,sum(garments_per_carton)*cartons_per_pack_job*pack_job_per_pack_method as qnty,GROUP_CONCAT(size_title) as size ,GROUP_CONCAT(color) as color,seq_no,pack_method FROM $bai_pro3.tbl_pack_size_ref WHERE parent_id='$pack_id' GROUP BY seq_no order by seq_no";
				// echo $pack_meth_qry;
				// $sizes_result=mysqli_query($link, $sizes_query) or exit("Sql Error2 $sizes_query");
				$pack_meth_qty=mysqli_query($link, $pack_meth_qry) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			
				echo "<br><div class='col-md-12'>
				
							<table class=\"table table-bordered\">
								<tr class=\"info\">
									<th>S.No</th>
									<th>Packing Method</th>
									<th>Description</th>
									<th>Quantity</th>
									<th>No Of Colors</th>
									<th>No Of Sizes</th>
									<th>Controlls</th></tr>";
								while($pack_result1=mysqli_fetch_array($pack_meth_qty))
								{
									
									// var_dump($operation);
									$seq_no=$pack_result1['seq_no'];
									$parent_id=$pack_result1['parent_id'];
									$pack_method=$pack_result1['pack_method'];
									// echo $pack_method;
									// $col_array[]=$sizes_result1['order_col_des'];
									echo "<tr><td>".$pack_result1['seq_no']."</td>";
									echo"<td>".$operation[$pack_method]."</td>";
									echo "<td>".$pack_result1['pack_description']."</td>";
									echo "<td>".$pack_result1['qnty']."</td>";
									echo "<td>".$pack_result1['color']."</td>";
									echo "<td>".$pack_result1['size']."</td>";
									$url=getFullURL($_GET['r'],'pack_jobs_generate.php','N');
									$url1=getFullURL($_GET['r'],'order_qty_vs_packed_qty.php','N');
									$url2=getFullURL($_GET['r'],'decentralized_packing_ratio.php','N');
									// $url3=getFullURL($_GET['r'],'.php','R');
									// $url4=getFullURL($_GET['r'],'.php','R');
									$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
									$statusqry="select * from $bai_pro3.pac_stat_log where schedule='$schedule' and pac_seq_no='$seq_no' and status='DONE'";
									// echo $statusqry;
									$statusrslt=mysqli_query($link, $statusqry) or exit("Error while getting status".mysqli_error($GLOBALS["___mysqli_ston"]));
									
									if(mysqli_num_rows($statusrslt)==0)
									{
										echo "<td><a class='btn btn-success btn-sm' href='$url&c_ref=$parent_id&pack_method=$pack_method&seq_no=$seq_no' target='_blank'>Generate pack Job</a>
										<a class='btn btn-danger' href=$url1&seq_no=$seq_no&parent_id=$parent_id&pack_method=$pack_method&schedule=$schedule&style=$style>Delete</a></td>";
									}
									else
									{
										echo"<td>Packing List Generated</td>";
									}
									echo "<tr>";
									
								}	
							
						echo "</table></div>";
						$pack_qnty = $_GET['order_total'];
						$ordr_qnty = $_GET['ordr_qnty'];
						$url2=getFullURL($_GET['r'],'decentralized_packing_ratio.php','N');
						echo "<div class='col-md-12 col-sm-12 col-xs-12'>
							<a class='btn btn-success btn-sm' href='$url2&schedule=$schedule&style=$style' >Add Packing Method</a>
							</div>";
											
			}
				if($_GET['seq_no'] && $_GET['parent_id'] && $_GET['pack_method'])
				{
					$seq_no=$_GET['seq_no'];
					$parent_id=$_GET['parent_id'];
					$pack_method=$_GET['pack_method'];
					$schedule=$_GET['schedule'];
					$style=$_GET['style'];
					$delete_pack_meth="delete from $bai_pro3.tbl_pack_size_ref where seq_no='$seq_no' and parent_id='$parent_id' and pack_method='$pack_method'";
				    // echo $delete_pack_meth;die();
					$dele_pack_qry_res=mysqli_query($link, $delete_pack_meth) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
					if(! $dele_pack_qry_res ) {
						die('Could not delete data: ' . mysql_error());
								   }
					//echo '<script>swal("Packing Method Deleted Sucessfully","","warning")</script>';
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
					function Redirect() {
						swal('Packing Method Deleted Sucessfully','','warning');
						location.href = \"".getFullURLLevel($_GET['r'], "order_qty_vs_packed_qty.php", "0", "N")."&style=$style&schedule=$schedule\";
						}
					</script>";					
				}

			?> 
		</div>
	</div>
</div>