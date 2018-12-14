<head>
	<script language="javascript" type="text/javascript">
	
	var url1 = '<?= getFullURL($_GET['r'],'pack_method_loading.php','N'); ?>';
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
    $has_permission=haspermission($_GET['r']);
	
	error_reporting(0);
?>

<div class="panel panel-primary">
	<div class="panel-heading"><b>Packing List Loading</b></div>
	<div class="panel-body">
	<?php
		$order_tid=$_GET['order_tid'];

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
		echo "<div class='col-md-12'>
				<form name=\"mini_order_report\" action=\"#\" method=\"post\" class='form-inline'>
					<label>Style: </label>";
						// Style
						echo "<select name=\"style\" id=\"style\" class='form-control' onchange=\"firstbox();\" required>";
						$sql="select * from $bai_pro3.pac_stat group by style order by style*1";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
						echo "<option value=''>Select Style</option>";
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
						echo "</select>
						&nbsp;
					<label>Schedule:</label>";
						// Schedule
						echo "<select class='form-control' name=\"schedule\" id=\"schedule\"  required>";
						$sql="select schedule from $bai_pro3.pac_stat where style='".$style."' group by schedule order by schedule*1";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						echo "<option value=''>Select Schedule</option>";
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
						echo "</select>";
					?>
					&nbsp;&nbsp;
					<input type="submit" name="submit" id="submit" class="btn btn-success " value="Submit">
				</form>
			</div>
		<div class="col-md-12">
			<br><br>
	<?php
		
			if(isset($_POST['submit']))
			{
				$size_title_array = array();	$plan_total_new = 0;	$order_total_new = 0;
				//packing method details
				$style1=$_POST['style'];
				$schedule=$_POST['schedule'];
				
				$check="select * from $bai_pro3.pac_stat where schedule=$schedule";
				$check_resu=mysqli_query($link, $check) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$row1 = mysqli_fetch_row($check_resu);
				if($row1>0)
				{
					$schedule_id = echo_title("$brandix_bts.tbl_orders_master","id","product_schedule",$schedule,$link);
					$style_id = echo_title("$brandix_bts.tbl_orders_style_ref","id","product_style",$style,$link); 
				
								
					//end logic
					$get_pack_id=" select id from $bai_pro3.tbl_pack_ref where schedule='$schedule' AND style='$style'"; 
					$get_pack_id_res=mysqli_query($link, $get_pack_id) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$row = mysqli_fetch_row($get_pack_id_res);
					$pack_id=$row[0];
					
					$sql="select * from $bai_pro3.bai_orders_db_confirm where order_del_no='$schedule'";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error p".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						$style=$sql_row['order_style_no'];
						$cpo=$sql_row['order_po_no'];
						$mpo=$sql_row['vpo'];
						$cust_ord=$sql_row['co_no'];
						$division=$sql_row['order_div'];
					} ?>

					<div class="col-md-12">
						<table class="table table-bordered">
							<tr>
								<th>Style</th><td><?php echo $style ?></td>
								<th>Buyer Division</th><td><?php echo $division ?></td>
								<th>Schedule</th><td><?php echo $schedule ?></td>
							</tr>
							<tr>
								<th>MPO</th><td><?php echo $mpo ?></td>
								<th>CPO</th><td><?php echo $cpo ?></td>
								<th>Customer Order</th><td><?php echo $cust_ord ?></td>
							</tr>
						</table>
					</div>

					<?php

					$sewing_jobratio_sizes_query = "SELECT GROUP_CONCAT(DISTINCT size_title) AS size FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id =$schedule_id";
					// echo $sewing_jobratio_sizes_query.'<br>';
					$sewing_jobratio_sizes_result=mysqli_query($link, $sewing_jobratio_sizes_query) or exit("Error while getting Job Ratio Details");
					while($sewing_jobratio_color_details=mysqli_fetch_array($sewing_jobratio_sizes_result)) 
					{
						$ref_size = $sewing_jobratio_color_details['size'];
						$size_main = explode(",",$ref_size);
						// var_dump($size);
					}
					$sizeofsizes=sizeof($size_main);

					// Order Details Display Start
					//{
						$planned_qty = array();
						$ordered_qty = array();
						$pac_qty = array();
						$tot_ordered = 0;
						$tot_planned = 0;
						$tot_pac = 0;
						for($kk=0;$kk<sizeof($size_main);$kk++)
						//foreach ($sizes_array as $key => $value)
						{					
							$plannedQty_query = "SELECT SUM(quantity*planned_plies) AS plan_qty FROM $brandix_bts.tbl_cut_size_master 
							LEFT JOIN $brandix_bts.tbl_cut_master ON tbl_cut_size_master.parent_id=tbl_cut_master.id 
							LEFT JOIN $brandix_bts.tbl_orders_sizes_master ON tbl_orders_sizes_master.parent_id=tbl_cut_master.ref_order_num
							WHERE tbl_cut_master.ref_order_num=$schedule_id AND tbl_orders_sizes_master.size_title='$size_main[$kk]' AND tbl_cut_size_master.ref_size_name=tbl_orders_sizes_master.ref_size_name AND tbl_cut_size_master.color=tbl_orders_sizes_master.order_col_des";
							//echo $plannedQty_query.'<br>';
							$plannedQty_result=mysqli_query($link, $plannedQty_query) or exit("Sql Error22");
							while($planneQTYDetails=mysqli_fetch_array($plannedQty_result))
							{
								$planned_qty[$size_main[$kk]] = $planneQTYDetails['plan_qty'];
								//echo $planned_qty[$size_main[$kk]]."---Testing<br>";
							}
							$orderQty_query = "SELECT SUM(order_act_quantity) AS orderedQty FROM $brandix_bts.tbl_orders_sizes_master 
							WHERE parent_id=$schedule_id AND tbl_orders_sizes_master.size_title='$size_main[$kk]'";
							//echo $orderQty_query.'<br>';
							$Order_qty_resut=mysqli_query($link, $orderQty_query) or exit("Sql Error23");
							while($orderQty_details=mysqli_fetch_array($Order_qty_resut))
							{
								$ordered_qty[$size_main[$kk]] = $orderQty_details['orderedQty'];
							}
							
							$pacQty_query = "SELECT SUM(carton_act_qty) AS pack_qty FROM $bai_pro3.packing_summary 
							WHERE order_del_no='$schedule' AND size_tit='$size_main[$kk]'";
							//echo $pacQty_query.'<br>';
							$pac_qty_resut=mysqli_query($link, $pacQty_query) or exit("Sql Error24");
							while($pacQty_details=mysqli_fetch_array($pac_qty_resut))
							{
								$pac_qty[$size_main[$kk]] = $pacQty_details['pack_qty'];
							}
						}
						echo "<br>
						<div class='col-md-12 table-responsive'>
							<table class=\"table table-bordered\">
								<tr class=\"info\">
									<th>Size</th>";
									for ($i=0; $i < sizeof($size_main); $i++)
									{
										echo "<th>$size_main[$i]</th>";
									}	
									
									echo "<th>Total</th>
								</tr>";

								echo "<tr>
										<td>Order Qty</td>";
										for ($i=0; $i < sizeof($size_main); $i++)
										{ 
											echo "<td>".$ordered_qty[$size_main[$i]]."</td>";
											$tot_ordered = $tot_ordered + $ordered_qty[$size_main[$i]];
										}
										echo "<td>$tot_ordered</td>
									</tr>";

								echo "<tr>
										<td>Cut Plan Qty</td>";
										for ($i=0; $i < sizeof($size_main); $i++)
										{ 
											echo "<td>".$planned_qty[$size_main[$i]]."</td>";
											$tot_planned = $tot_planned + $planned_qty[$size_main[$i]];
										}
										echo "<td>$tot_planned</td>
									</tr>";
								echo "<tr>
										<td>Pack Qty</td>";
										for ($i=0; $i < sizeof($size_main); $i++)
										{ 
											echo "<td>".$pac_qty[$size_main[$i]]."</td>";
											$tot_pac = $tot_pac + $pac_qty[$size_main[$i]];
										}
										echo "<td>$tot_pac</td>
									</tr>";	
							echo "</table>
						</div>";
					//}
					$url=getFullURL($_GET['r'],'check_list.php','R');
					$url2=getFullURL($_GET['r'],'barcode_carton.php','R');
					echo "
						<div class='col-md-12'>
							<div class='pull-right'>
								<a class='btn btn-warning' href='$url?p_status=2&seq_no=0&schedule=$schedule&style=$style' target='_blank' >Print Packing list
								<a class='btn btn-warning' href='$url?p_status=1&seq_no=0&schedule=$schedule&style=$style' target='_blank' >Print Carton track
								<a class='btn btn-warning' href='$url2?schedule=$schedule' target='_blank' >Print All Labels</a>
							</div>
						</div>";
					echo "<br>
							<div class='col-md-12'>
								<table class=\"table table-bordered\">
									<tr class=\"info\">
										<th>S.No</th>
										<th>Packing Method</th>
										<th>Description</th>
										<th>Colors</th>
										<th>Sizes</th>
										<th>No Of Cartons</th>
										<th>Quantity</th>
										<th>Controls</th></tr>";
										$i = 1;
									$pack_meth_qry="
									SELECT MAX(carton_no) AS cartons, SUM(carton_qty) AS qty,seq_no,pack_description,pack_method,GROUP_CONCAT(DISTINCT TRIM(size_title)) AS size ,GROUP_CONCAT(DISTINCT TRIM(color)) AS color FROM bai_pro3.pac_stat 
									LEFT JOIN tbl_pack_ref ON tbl_pack_ref.schedule=pac_stat.schedule 
									LEFT JOIN tbl_pack_size_ref ON tbl_pack_ref.id=tbl_pack_size_ref.parent_id AND pac_stat.pac_seq_no=tbl_pack_size_ref.seq_no WHERE pac_stat.schedule='$schedule'
									GROUP BY seq_no ORDER BY seq_no*1";
									$pack_meth_qty=mysqli_query($link, $pack_meth_qry) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
									while($pack_result1=mysqli_fetch_array($pack_meth_qty))
									{
										$seq_no=$pack_result1['seq_no'];
										$carton_qty_pac_stat=echo_title("$bai_pro3.pac_stat","sum(carton_qty)","schedule='".$schedule."' and pac_seq_no",$seq_no,$link);
										$pack_method=$pack_result1['pack_method'];
										echo "<tr>
											<td>$i</td>
											<td>".$operation[$pack_method]."</td>
											<td>".$pack_result1['pack_description']."</td>
											<td>".$pack_result1['color']."</td>
											<td>".$pack_result1['size']."</td>
											<td>".$pack_result1['cartons']."</td>
											<td>".$carton_qty_pac_stat."</td>
											<td>
												<a class='btn btn-warning' href='$url?p_status=2&schedule=$schedule&seq_no=$seq_no&style=$style' target='_blank' >FG Check List
												<a class='btn btn-warning' href='$url?p_status=1&schedule=$schedule&seq_no=$seq_no&style=$style' target='_blank' >Carton Track
												<a class='btn btn-warning' href='$url2?schedule=$schedule&seq_no=$seq_no' target='_blank' >Print Lables</a>
											</td>
											<tr>";
											$i++;
									}
									echo "
								</table>
							</div>";
				}
				else
				{
					echo "<script>sweetAlert('Packing List Not Yet Generated.','','warning');</script>";
				}		
			}
			?> 
		</div>
	</div>
</div>