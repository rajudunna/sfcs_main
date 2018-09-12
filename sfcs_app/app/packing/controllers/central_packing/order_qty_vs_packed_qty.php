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
						$del_id = $_GET['schedule'];
					} 
					else if ($_POST['style'] and $_POST['schedule'])
					{
						$style=$_POST['style'];
						$schedule=$_POST['schedule'];
						$del_id = $_POST['schedule'];	
					}
					// echo $style."---".$schedule;
					//getting parent id from tbl_pack_ref
					$getparentid="select id from $bai_pro3.tbl_pack_ref where ref_order_num='$schedule' and style_code='$style'";
					$parentidrslt=mysqli_query($link, $getparentid) or exit("Error while getting parent id");
					if($row=mysqli_fetch_array($parentidrslt))
					{
						$parent=$row['id'];
					}
							
					//echo "Style= ".$style."<br>Schedule= ".$schedule.'<br>';
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

						$sewing_jobratio_sizes_query = "SELECT GROUP_CONCAT(DISTINCT size_title) AS size FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN ($del_id)";
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
							$tot_ordered = 0;
							$tot_planned = 0;
							$pack_tot = 0;
							foreach ($sizes_array as $key => $value)
							{
								$plannedQty_query = "SELECT SUM(p_plies*p_$sizes_array[$key]) AS plannedQty FROM $bai_pro3.plandoc_stat_log WHERE cat_ref IN (SELECT tid FROM $bai_pro3.cat_stat_log WHERE category IN ($in_categories) AND order_tid IN  (SELECT order_tid FROM $bai_pro3.`bai_orders_db_confirm` WHERE order_del_no=$schedule and order_col_des = '$col_array[$j]'))";
								// echo $plannedQty_query.'<br>';
								$plannedQty_result=mysqli_query($link, $plannedQty_query) or exit("Sql Error2");
								while($planneQTYDetails=mysqli_fetch_array($plannedQty_result))
								{
									$planned_qty[] = $planneQTYDetails['plannedQty'];
								}

								$orderQty_query = "SELECT SUM(order_s_$sizes_array[$key]) AS orderedQty FROM $bai_pro3.`bai_orders_db_confirm` WHERE order_del_no=$schedule and order_col_des = '$col_array[$j]' ";
								// echo $orderQty_query.'<br>';
								$Order_qty_resut=mysqli_query($link, $orderQty_query) or exit("Sql Error2");
								while($orderQty_details=mysqli_fetch_array($Order_qty_resut))
								{
									$ordered_qty[] = $orderQty_details['orderedQty'];
								}

								$getpackqty="select sum(carton_act_qty) as qty from $bai_pro3.pac_stat_log where schedule='$schedule' and color='$col_array[$j]' and size_code='$sizes_array[$key]'";
								// echo $getpackqty;
								$packqtyrslt=mysqli_query($link, $getpackqty) or exit("Error while getting parent id");
								if($row=mysqli_fetch_array($packqtyrslt))
								{
									$pack_qty[]=$row['qty'];
								}
							}
							// echo $col_array[$i];
							

							echo "<tr>
									<td rowspan=3>$col_array[$j]</td>
									<td>Order Qty</td>";
									for ($i=0; $i < $sizeofsizes; $i++)
									{ 
										echo "<td>$ordered_qty[$i]</td>";
										$tot_ordered = $tot_ordered + $ordered_qty[$i];
									}
									echo "<td>$tot_ordered</td>
								</tr>";

							echo "<tr>
									<td>Plan Qty</td>";
									for ($i=0; $i < $sizeofsizes; $i++)
									{ 
										echo "<td>$planned_qty[$i]</td>";
										$tot_planned = $tot_planned + $planned_qty[$i];
									}
									echo "<td>$tot_planned</td>
								</tr>";

							echo "<tr>
									<td>Pack Generated</td>";
									for ($i=0; $i < $sizeofsizes; $i++)
									{
										// $getpackqty="select sum(carton_act_qty) as qty from $bai_pro3.pac_stat_log where schedule='$schedule' and color='$col_array[$j]' and size_tit='$size'";
										// // echo $getpackqty;
										// $packqtyrslt=mysqli_query($link, $getpackqty) or exit("Error while getting parent id");
										// if($row=mysqli_fetch_array($packqtyrslt))
										// {
										// 	$qty=$row['qty'];
										// }
										
										echo "<td>".$pack_qty[$i]."</td>";
										$pack_tot += $pack_qty[$i];

										// echo "<td>$planned_qty[$i]</td>";
										// $tot_planned = $tot_planned + $planned_qty[$i];
									}
									echo "<td>$pack_tot</td>
								</tr>";
						}
						echo "</table>
							</div>";
					}
					// Order Details Display End
				}
				//packing method details
				//echo "Test";
				//$style=$_POST['style'];
				//$schedule=$_POST['schedule'];
				if ($_GET['style'] and $_GET['schedule'])
					{
						$style=$_GET['style'];
						$scheduleid=$_GET['schedule'];
					} 
					else if ($_POST['style'] and $_POST['schedule'])
					{
						$style=$_POST['style'];
						$scheduleid=$_POST['schedule'];	
					}
				$get_pack_id=" select id from $bai_pro3.tbl_pack_ref where ref_order_num=$scheduleid AND style_code='".$style."'"; 
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
									$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$scheduleid,$link);
									$statusqry="select * from $bai_pro3.pac_stat_log where schedule='$schedule' and pac_seq_no='$seq_no'";
									//echo $statusqry;
									$statusrslt=mysqli_query($link, $statusqry) or exit("Error while getting status".mysqli_error($GLOBALS["___mysqli_ston"]));
									
									if(mysqli_num_rows($statusrslt)==0)
									{
										echo "<td><a class='btn btn-success btn-sm' href='$url&c_ref=$parent_id&pack_method=$pack_method&seq_no=$seq_no' target='_blank'>Generate pack Job</a>
										<a class='btn btn-danger' href=$url1&seq_no=$seq_no&parent_id=$parent_id&pack_method=$pack_method&schedule=$scheduleid&style=$style>Delete</a></td>";
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
							<a class='btn btn-success btn-sm' href='$url2&schedule=$scheduleid&style=$style' >Add Packing Method</a>
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