<head>
	<style>
		table tr th,
		td {
			text-align: center;

		}
	</style>
</head>
<?php
echo "<input type='hidden' name='reject_reasons' id='reject_reasons'>";
include($_SERVER['DOCUMENT_ROOT'] . "/sfcs_app/common/config/config.php");

if (isset($_GET['parent_id']) or isset($_POST['parent_id'])) {
	$parent_id = $_GET['parent_id'] or $_POST['parent_id'];
	$store_id =	$_GET['store_id'] or $_POST['store_id'];
}
$get_inspection_population_info = "select * from $bai_rm_pj1.`roll_inspection_child` where store_in_tid=$store_id";
$info_result = mysqli_query($link, $get_inspection_population_info) or exit("get_details Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($row22 = mysqli_fetch_array($info_result)) {

	$sno_points = $row22['sno'];
	$inspected_per = $row22['inspected_per'];
	$inspected_qty = $row22['inspected_qty'];
	$width_s = $row22['width_s'];
	$width_m = $row22['width_m'];
	$width_e = $row22['width_e'];
	$actual_height = $row22['actual_height'];
	$actual_repeat_height = $row22['actual_repeat_height'];
	$skw = $row22['skw'];
	$bow = $row22['bow'];
	$ver = $row22['ver'];
	$gsm = $row22['gsm'];
	$comment = $row22['comment'];
	$marker_type = $row22['marker_type'];
	$inspection_status = $row111['ins_status'];
}

$get_details = "select * from $bai_rm_pj1.`inspection_population` where store_in_id=$store_id";
$details_result = mysqli_query($link, $get_details) or exit("get_details Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($row1 = mysqli_fetch_array($details_result)) {
	$invoice = $row1['supplier_invoice'];
	$batch = $row1['supplier_batch'];
	$po = $row1['supplier_po'];
	$item_code = $row1['item_code'];
	$item_desc = $row1['item_desc'];
	$color = $row1['rm_color'];
	$lot_no = $row1['lot_no'];
	$invoice_qty = $row1['rec_qty'];	
	if($row1['status']==1)
	{
		$status='Pending';
	}
	elseif($row1['status']==2)
	{
		$status='In Progress';
	}		
}

$get_details1 = "select * from $bai_rm_pj1.`main_population_tbl` where id=$parent_id";
$details_result1 = mysqli_query($link, $get_details1) or exit("get_details Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($row111 = mysqli_fetch_array($details_result1)) 
{
	$fabric_composition = $row111['fab_composition'];
	$spec_width = $row111['s_width'];
	
	$repeat_length = $row111['repeat_len'];
	$spec_weight = $row111['s_weight'];
	$lab_testing = $row111['lab_testing'];
	$tolerance = $row111['tolerance'];
}

?>
<div class="container-fluid">
	<div class="panel panel-primary">
		<div class="panel-heading">4 Point Roll Inspection Update</div>
		<div class="panel-body">
			<div class="container">
				<?php
				echo "<a class=\"btn btn-xs btn-warning pull-left\" href=\"" . getFullURLLevel($_GET['r'], "4_point_roll_inspection.php", "0", "N") . "&parent_id=$parent_id\"><<<< Click here to Go Back</a>";
				?>
				<div class="table-responsive col-sm-12">
					<table class="table table-bordered">
						<tbody>
							<tr style="background-color: antiquewhite;">
								<th>Invoice #</th>
								<th>Color</th>
								<th>Batch</th>
								<th>PO#</th>
								<th>Lot No</th>
							</tr>
							<tr>
								<?php
							echo "<td>$invoice</td> 
						      	<td>$color</td>
						      	<td>$batch</td>
						      	<td>$po</td>
						      	<td>$lot_no</td>";
								?>
							</tr>
						</tbody>
					</table>
				</div>
				<form id='myForm' method='post' name='input_main'>
					<div class="table-responsive col-sm-12">
						<table class="table table-bordered">
							<tbody>
								<tr>
									<td></td>
									<td></td>
									<td colspan="3">Tolerance</td>
								</tr>
								<tr>
									<td>Fabric Composition</td>
									<td><input type="text" id="fabric_composition" name="fabric_composition" autocomplete="off" autocomplete="off" value="<?= $fabric_composition ?>" <?php if ($fabric_composition) echo "readonly" ?> class="float"></td>
									<td rowspan="2"><input type="text" id="tolerance" name="tolerance" value="<?= $tolerance ?>" <?php if ($tolerance) echo "readonly" ?> class="float"></td>
								</tr>
								<tr>
									<td>Inspection Status</td>
									<td>
										<select name="inspection_status" id="inspection_status">
											<option value="" selected>Select Status</option>
											<option value="approval" <?php if ($inspection_status == "approval") echo "selected" ?>>Aprroval</option>
											<option value="rejected" <?php if ($inspection_status == "rejected") echo "selected" ?>>Rejected</option>
											<option value="partial rejected" <?php if ($inspection_status == "partial rejected") echo "selected" ?>>Partial Rejected</option>
										</select>
									</td>
								</tr>
								<tr style="background-color: antiquewhite;">
									<th style=text-align:center colspan="3">Spec Details</th>
								</tr>
								<tr>
									<td>Spec Width</td>
									<td><input type="text" id="spec_width" name="spec_width" autocomplete="off" value="<?= $spec_width ?>" <?php if ($spec_width) echo "readonly" ?> class="float"></td>
									<!-- <td><input type="text" id="tolerance" name="tolerance"></td> -->
								</tr>
								<tr>
									<td>Spec Weight</td>
									<td><input type="text" id="spec_weight" name="spec_weight" autocomplete="off" value="<?= $spec_weight ?>" <?php if ($spec_weight)  ?> class="float"></td>
									<!-- <td><input type="text" id="tolerance" name="tolerance"></td> -->
								</tr>
								<tr>
									<td>Repeat Length</td>
									<td><input type="text" id="repeat_length" name="repeat_length" autocomplete="off" value="<?= $repeat_length ?>" <?php if ($repeat_length) echo "readonly" ?> class="float"></td>
									<!-- <td><input type="text" id="tolerance" name="tolerance"></td> -->
								</tr>
								<tr style="background-color: antiquewhite;">
									<th style=text-align:center colspan=3>Inspection Summary</th>
								</tr>
								<tr>
									<td>Lab Testing</td>
									<td><input type="text" id="lab_testing" name="lab_testing" autocomplete="off" value="<?= $lab_testing ?>" <?php if ($lab_testing) echo "readonly" ?> class="float"></td>
									<!-- <td rowspan="2"><input type="text" id="tolerance" name="tolerance"></td> -->
								</tr>
							</tbody>
						</table>
					</div>
					<div class="table-responsive col-sm-12">
						<table class="table table-bordered">
							<tbody>
								<tr style="background-color: antiquewhite;">
									<th>Supplier Roll No</th>
									<th>SFCS Roll No</th>
									<th>Item Code</th>
									<th>Color</th>
									<th>Description</th>
									<th>Lot No</th>
									<th>Qty</th>
									<th>Num of Points</th>
									<th>Roll Inspection Status</th>
								</tr>

								<?php

								echo
									"<tr>
					      	    <td>" . $supplier_id . "</td>
					      		<td>" . $roll_id . "</td>
					      		<td>" . $item_code . "</td>
					      		<td>" . $color . "</td>
	                            <td>" . $item_desc . "</td>
	                            <td>" . $lot_number . "</td>
								<td>" . $qty . "</td>";
								if($sno_points>0)
								{
									$get_status_details = "select sum(points) as points from $bai_rm_pj1.four_points_table where insp_child_id = ".$sno_points."";
									//echo $get_status_details;
									$status_details_result = mysqli_query($link, $get_status_details) or exit("get_status_details Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
									if(mysqli_num_rows($status_details_result)>0)
									{
										while ($row5 = mysqli_fetch_array($status_details_result)) 
										{
											$main_points = $row5['points'];
										}
									}
									else
									{
										$main_points=0;	
									}	
								}
								else
								{
									$main_points=0;	
								}	
								echo "
								<td>" . $main_points . "</td>
								<td>" . $status . "</td>
							   </tr>";
								
								?>
							</tbody>
						</table>
					</div>
					<div class="table-responsive col-sm-12">
						<table class="table table-bordered">
							<tbody>

								<tr style="background-color: antiquewhite;">
									<th>Item Code</th>
									<th>Roll No</th>
									<th>Inspected %</th>
									<th>Inspected Qty</th>
									<th>Invoice Qty</th>
									<th style=text-align:center colspan=3>Width(cm)</th>
									<th>Actual Height</th>
									<th>Actual Repeat Height</th>
									<th>SKW</th>
									<th>BOW</th>
									<th>Ver</th>
									<th>GSM(s/sqm)</th>
									<th>Comments</th>
									<th>Marker Type</th>
								</tr>
								<tr>
									<td><input type="hidden" id="item_code" name="item_code" autocomplete="off" value="<?= $item_code ?>"><?php echo $item_code; ?></td>
									<td><input type="hidden" id="roll_no" name="roll_no" autocomplete="off" value="<?= $roll_id ?>"><?php echo $roll_id; ?></td>
									<td><input type="text" id="inspected_per" name="inspected_per" autocomplete="off" value="<?= $inspected_per ?>" <?php if ($inspected_per) echo "readonly" ?> class="float"></td>
									<td><input type="text" id="inspected_qty" name="inspected_qty" autocomplete="off" value="<?= $inspected_qty ?>" <?php if ($inspected_qty) echo "readonly" ?> class="float"></td>
									<td><input type="hidden" id="invoice_qty" name="invoice_qty" autocomplete="off" value="<?= $qty ?>" class="float"><?php echo $qty; ?></td><td>
										<center>S</center><input type="text" id="s" name="s" colspan=3 autocomplete="off" value="<?= $width_s ?>" <?php if ($width_s) echo "readonly" ?> class="float">
									</td>
									<td>
										<center>M</center><input type="text" id="m" name="m" colspan=3 autocomplete="off" value="<?= $width_m ?>" <?php if ($width_m) echo "readonly" ?> class="float">
									</td>
									<td>
										<center>E</center><input type="text" id="e" name="e" colspan=3 autocomplete="off" value="<?= $width_e ?>" <?php if ($width_e) echo "readonly" ?> class="float">
									</td>
									<td><input type="text" id="actual_height" name="actual_height" autocomplete="off" value="<?= $actual_height ?>" <?php if ($actual_height) echo "readonly" ?> class="float"></td>
									<td><input type="text" id="actual_repeat_height" autocomplete="off" name="actual_repeat_height" value="<?= $actual_repeat_height ?>" <?php if ($actual_repeat_height) echo "readonly" ?> class="float"></td>
									<td><input type="text" id="skw" name="skw" autocomplete="off" value="<?= $skw ?>" <?php if ($skw) echo "readonly" ?>></td>
									<td><input type="text" id="bow" name="bow" autocomplete="off" value="<?= $bow ?>" <?php if ($bow) echo "readonly" ?>></td>
									<td><input type="text" id="ver" name="ver" autocomplete="off" value="<?= $ver ?>" <?php if ($ver) echo "readonly" ?>></td>
									<td><input type="text" id="gsm" name="gsm" autocomplete="off" value="<?= $gsm ?>" <?php if ($gsm) echo "readonly" ?>></td>
									<td><input type="text" id="comment" name="comment" autocomplete="off" value="<?= $comment ?>" <?php if ($comment) echo "readonly" ?>></td>
									<td><input type="text" id="marker_type" name="marker_type" autocomplete="off" value="<?= $marker_type ?>" <?php if ($marker_type) echo "readonly" ?>></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="form-inline col-sm-12">
						<div class="table-responsive col-sm-3">
							<table class="table table-bordered" style="margin-top: 48px;">
								<tbody>
									<tr style="background-color: antiquewhite;">
										<th>CODE</th>
										<th>DAMAGE DESCRIPTION</th>
									</tr>
									<tr>
										<td>C-1</td>
										<td>Hole</td>
									</tr>
									<tr>
										<td>C-2</td>
										<td>Stain Mark</td>
									</tr>
									<tr>
										<td>C-3</td>
										<td>Knot</td>
									</tr>
									<tr>
										<td>C-4</td>
										<td>Mark</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="form-horizontal col-sm-2">
							<div>
								<table class="table table-bordered" style="margin-top: 56px;">
									<tbody>
										<tr>
											<?php
											$path_report = getFullURLLevel($_GET['r'], "fabric_inspection_report.php", "0", "R") . "?id=$id_no&color=$color&batch=$batch";

											echo "<td><a class='btn btn-sm btn-primary' href='$path_report' onclick='return popitup(" . $path_report . ")'>Print Report</a></td>";
											?>
										</tr>
										<tr>
											<td><button type="sumbit" class="btn btn-sm btn-primary" name="save" id="save">Save</button></td>
										</tr>
										<tr>
											<td><button type="sumbit" class="btn btn-sm btn-primary" name="confirm" id="confirm">Confirm</button></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="table-responsive col-sm-7">
							<table class="table table-bordered" style="margin-top: 48px;">
								<tbody>
									<tr style="background-color: antiquewhite;">
										<th>Reject Code</th>
										<th>Damage Desc</th>
										<th>1 Point</th>
										<th>2 Points</th>
										<th>3 Points</th>
										<th>4 Points</th>
										<th>Control</th>
									</tr>

									<?php
									if ($sno_points != '') 
									{
										$select_four_points = "select * from $bai_rm_pj1.`four_points_table` where insp_child_id = $sno_points";
										$fourpoints_result = mysqli_query($link, $select_four_points) or exit("get_parent_id Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
										$num_rows = mysqli_num_rows($fourpoints_result);
									}
									else 
									{
										$num_rows = 0;
									}

									if ($num_rows >0) 
									{									
										$i = 0;
										while ($row44 = mysqli_fetch_array($fourpoints_result)) 
										{
											$code = $row44['code'];
											$description = $row44['description'];
											$point = $row44['points'];
											
											echo '<tr>
											<td><input type="hidden" name="submit_value_' . $i . '" id="submit_value_' . $i . '>"><input type="text" class="code" id="code_' . $i . '" name="code[]" autocomplete="off" value = "' . $code . '"></td>
											<td><input type="text" class="damage" value = "' . $description . '" id="damage_' . $i . '" name="damage[]" readonly></td>';
											if ($point == 1) {
												echo '<td><input type="radio" value="1" id="point_' . $i . '" name="point[]" checked="checked"></td>';
											} else {
												echo '<td><input type="radio" value="1" id="point_' . $i . '" name="point[]" ></td>';
											}
											if ($point == 2) {
												echo '<td><input type="radio" value="2" id="point_' . $i . '" name="point[]" checked="checked"></td>';
											} else {
												echo '<td><input type="radio" value="2" id="point_' . $i . '" name="point[]" ></td>';
											}
											if ($point == 3) {
												echo '<td><input type="radio" value="3" id="point_' . $i . '" name="point[]" checked="checked"></td>';
											} else {
												echo '<td><input type="radio" value="3" id="point_' . $i . '" name="point[]" ></td>';
											}
											if ($point == 4) {
												echo '<td><input type="radio" value="4" id="point_' . $i . '" name="point[]"  checked="checked"></td>';
											} else {
												echo '<td><input type="radio" value="4" id="point_' . $i . '" name="point[]" ></td>';
											}

											echo '<td><button type="button" class="btn btn-primary btn-sm" id="clear" onclick="clearValues(' . $i . ')" value="' . $i . '">Clear</button></td></tr>';
											$i++;
										}
									} 
									else 
									{
										for ($i = 0; $i < 4; $i++) 
										{
											?>
											<tr>
												<td>
												<input type="hidden" name="submit_value_<?php echo $i; ?>" id="submit_value_<?php echo $i; ?>">
												<input type="text" class="code" id="code_<?php echo $i; ?>" name="code[]" autocomplete="off" value=></td>
												<td><input type="text" class="damage" id="damage_<?php echo $i; ?>" name="damage[]" readonly></td>
												<td><input type="radio" value="1" id="point_<?= $i ?>" name="point[<?= $i ?>]" ></td>
												<td><input type="radio" value="2" id="point_<?= $i ?>" name="point[<?= $i ?>]" ></td>
												<td><input type="radio" value="3" id="point_<?= $i ?>" name="point[<?= $i ?>]" ></td>
												<td><input type="radio" value="4" id="point_<?= $i ?>" name="point[<?= $i ?>]" ></td>
												<td><button type="button" class="btn btn-primary btn-sm" id='clear' onclick='clearValues(<?= $i ?>)' value='<?= $i ?>'>Clear</button></td>
											</tr>
											<?php
										}
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
					<input type="hidden" name="parent_id" value='<?= $parent_id ?>'>
				</form>
			</div>
		</div>
	</div>
</div>
<?php

?>


<?php
if (isset($_POST['confirm'])) {
	
	$parent_id = $_POST['parent_id'];
	$fabric_composition = $_POST['fabric_composition'];
	if ($fabric_composition == '') {
		$fabric_composition = 0;
	} else {
		$fabric_composition;
	}

	$spec_width = $_POST['spec_width'];
	if ($spec_width == '') {
		$spec_width = 0;
	} else {
		$spec_width;
	}

	$inspection_status = $_POST['inspection_status'];

	$spec_weight = $_POST['spec_weight'];
	if ($spec_weight == '') {
		$spec_weight = 0;
	} else {
		$spec_weight;
	}

	$repeat_length = $_POST['repeat_length'];
	if ($repeat_length == '') {
		$repeat_length = 0;
	} else {
		$repeat_length;
	}

	$lab_testing = $_POST['lab_testing'];
	if ($lab_testing == '') {
		$lab_testing = 0;
	} else {
		$lab_testing;
	}

	$tolerance = $_POST['tolerance'];
	if ($tolerance == '') {
		$tolerance = 0;
	} else {
		$tolerance;
	}

	$inspected_per = $_POST['inspected_per'];
	if ($inspected_per == '') {
		$inspected_per = 0;
	} else {
		$inspected_per;
	}

	$inspected_qty = $_POST['inspected_qty'];
	if ($inspected_qty == '') {
		$inspected_qty = 0;
	} else {
		$inspected_qty;
	}
	
	$s = $_POST['s'];
	if ($s == '') {
		$s = 0;
	} else {
		$s;
	}

	$m = $_POST['m'];
	if ($m == '') {
		$m = 0;
	} else {
		$m;
	}

	$e = $_POST['e'];
	if ($e == '') {
		$e = 0;
	} else {
		$e;
	}

	$actual_height = $_POST['actual_height'];
	if ($actual_height == '') {
		$actual_height = 0;
	} else {
		$actual_height;
	}

	$actual_repeat_height = $_POST['actual_repeat_height'];
	if ($actual_repeat_height == '') {
		$actual_repeat_height = 0;
	} else {
		$actual_repeat_height;
	}

	$skw = $_POST['skw'];
	if ($skw == '') {
		$skw = 0;
	} else {
		$skw;
	}

	$bow = $_POST['bow'];
	if ($bow == '') {
		$bow = 0;
	} else {
		$bow;
	}

	$ver = $_POST['ver'];
	if ($ver == '') {
		$ver = 0;
	} else {
		$ver;
	}

	$gsm = $_POST['gsm'];
	if ($gsm == '') {
		$gsm = 0;
	} else {
		$gsm;
	}

	$comment = $_POST['comment'];
	if ($comment == '') {
		$comment = 0;
	} else {
		$comment;
	}

	$marker_type = $_POST['marker_type'];
	if ($marker_type == '') {
		$marker_type = 0;
	} else {
		$marker_type;
	}


	if (isset($_POST['code'])) {
		$code = $_POST['code'];
		$count = count($code);
		$damage = $_POST['damage'];
		
		$sql_rows="update $bai_rm_pj1.main_population_tbl set fabric_composition='" . $fabric_composition . "',spec_width='" . $spec_width . "'repeat_length='" . $repeat_length . "',lab_testing='" . $lab_testing . "',tolerance='" . $tolerance . "' where id=".$parent_id."";
		mysqli_query($link, $sql_rows) or die("Error---1111" . mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$id_parent = $parent_id;

		$check_store_tid = "select sno from $bai_rm_pj1.roll_inspection_child where store_in_tid='" . $store_id . "'";
		$details_check_store_tid = mysqli_query($link, $check_store_tid) or die("Error---1111" . mysqli_error($GLOBALS["___mysqli_ston"]));
		$row_sid = mysqli_num_rows($details_check_store_tid);
		$row_store_tid = mysqli_fetch_array($details_check_store_tid);
		if ($row_sid == 1) 
		{
			
			$update_status_insp = "update $bai_rm_pj1.roll_inspection_child SET inspected_per='" . $inspected_per . "',inspection_status='" . $inspection_status . "',inspected_qty='" . $inspected_qty . "',invoice_qty='" . $invoice_qty . "',width_s='" . $s . "',width_m='" . $m . "',width_e='" . $e . "',actual_height='" . $actual_height . "',actual_repeat_height='" . $actual_repeat_height . "',skw='" . $skw . "',bow='" . $bow . "',ver='" . $ver . "',gsm='" . $gsm . "',comment='" . $comment . "',marker_type='" . $marker_type . "',status = 3 where store_in_tid='".$store_id."'";
			$roll_inspection_update = $link->query($update_status_insp) or exit('query error in updating222');
			$delete_child = "Delete from  $bai_rm_pj1.four_points_table where insp_child_id='" .$store_id. "'";
			$roll_inspection_update = $link->query($delete_child) or exit('query error in deleteing222');
			$roll_id = $store_id;
			$insert_four_points = "insert ignore into $bai_rm_pj1.four_points_table(insp_child_id,code,description,points) values ";
			for ($i = 0; $i < $count; $i++) 
			{
				$flag=0;$points=0;
				$submitted_val_array = explode("$", $_POST['submit_value_' . $i]);
				var_dump($submitted_val_array)."<br>";		
				 for($j=2;$j<sizeof($submitted_val_array);$j++)
				{
					if($submitted_val_array[0]<>'' && $submitted_val_array[$j]>0)
					{	
						$insert_four_points .=  "($roll_id,'$submitted_val_array[0]','$submitted_val_array[1]',
						'$submitted_val_array[$j]'),";	
					}		
				}
				unset($submitted_val_array);		
			}
			$insert_four_points = rtrim($insert_four_points, ",");
			mysqli_query($link, $insert_four_points) or die("Error---122" . mysqli_error($GLOBALS["___mysqli_ston"]));
		
			$update_status = "update $bai_rm_pj1.inspection_population SET status=3 where store_in_id='" . $store_id . "'";
			// echo $update_status;
			$result_query_update = $link->query($update_status) or exit('query error in updating222');
			echo "<script>swal('Data Update...','Successfully','success')</script>";
			$url = getFullURLLevel($_GET['r'], '4_point_roll_inspection.php', 0, 'N');
			echo "<script>location.href = '" . $url . "&parent_id=$parent_id'</script>";
			die();
		}
		else 
		{
			$insert_query = "insert into $bai_rm_pj1.roll_inspection_child(inspection_status,inspected_per,inspected_qty,width_s,width_m,width_e,actual_height,actual_repeat_height,skw,bow,ver,gsm,comment,marker_type,parent_id,status,store_in_tid) values ('$inspection_status','$inspected_per','$inspected_qty','$s','$m','$e','$actual_height','$actual_repeat_height','$skw','$bow','$ver','$gsm','$comment','$marker_type',$id_parent,3,$store_id)";
			//echo $insert_query;
			$result_query = $link->query($insert_query) or exit('query error in inserting11111');
			$roll_id = $store_id;
			$insert_four_points = "insert ignore into $bai_rm_pj1.four_points_table(insp_child_id,code,description,points) values ";
			for ($i = 0; $i < $count; $i++) 
			{
				$flag=0;$points=0;
				$submitted_val_array = explode("$", $_POST['submit_value_' . $i]);
				var_dump($submitted_val_array)."<br>";		
				 for($j=2;$j<sizeof($submitted_val_array);$j++)
				{
					if($submitted_val_array[0]<>'' && $submitted_val_array[$j]>0)
					{	
						$insert_four_points .=  "($roll_id,'$submitted_val_array[0]','$submitted_val_array[1]',
						'$submitted_val_array[$j]'),";	
					}		
				}
				unset($submitted_val_array);		
			}
			$insert_four_points = rtrim($insert_four_points, ",");
			mysqli_query($link, $insert_four_points) or die("Error---122" . mysqli_error($GLOBALS["___mysqli_ston"]));
		
			$update_status = "update $bai_rm_pj1.inspection_population SET status=3 where store_in_id='" . $store_id . "'";
			// echo $update_status;
			$result_query_update = $link->query($update_status) or exit('query error in updating222');
		}
		echo "<script>swal('Confirmation Updated..','Successfully','success')</script>";
		$url = getFullURLLevel($_GET['r'], '4_point_roll_inspection.php', 0, 'N');
		echo "<script>location.href = '" . $url . "&parent_id=$parent_id'</script>";
		die();
	}
}


?>
<?php
if (isset($_POST['save'])) {
	
	$code = $_POST['code'];
	$count = count($code);
	
	$parent_id = $_POST['parent_id'];
	$fabric_composition = $_POST['fabric_composition'];
	if ($fabric_composition == '') {
		$fabric_composition = 0;
	} else {
		$fabric_composition;
	}

	$spec_width = $_POST['spec_width'];
	if ($spec_width == '') {
		$spec_width = 0;
	} else {
		$spec_width;
	}

	$inspection_status = $_POST['inspection_status'];

	$spec_weight = $_POST['spec_weight'];
	if ($spec_weight == '') {
		$spec_weight = 0;
	} else {
		$spec_weight;
	}

	$repeat_length = $_POST['repeat_length'];
	if ($repeat_length == '') {
		$repeat_length = 0;
	} else {
		$repeat_length;
	}

	$lab_testing = $_POST['lab_testing'];
	if ($lab_testing == '') {
		$lab_testing = 0;
	} else {
		$lab_testing;
	}

	$tolerance = $_POST['tolerance'];
	if ($tolerance == '') {
		$tolerance = 0;
	} else {
		$tolerance;
	}

	$inspected_per = $_POST['inspected_per'];
	if ($inspected_per == '') {
		$inspected_per = 0;
	} else {
		$inspected_per;
	}

	$inspected_qty = $_POST['inspected_qty'];
	if ($inspected_qty == '') {
		$inspected_qty = 0;
	} else {
		$inspected_qty;
	}
	
	$s = $_POST['s'];
	if ($s == '') {
		$s = 0;
	} else {
		$s;
	}

	$m = $_POST['m'];
	if ($m == '') {
		$m = 0;
	} else {
		$m;
	}

	$e = $_POST['e'];
	if ($e == '') {
		$e = 0;
	} else {
		$e;
	}

	$actual_height = $_POST['actual_height'];
	if ($actual_height == '') {
		$actual_height = 0;
	} else {
		$actual_height;
	}

	$actual_repeat_height = $_POST['actual_repeat_height'];
	if ($actual_repeat_height == '') {
		$actual_repeat_height = 0;
	} else {
		$actual_repeat_height;
	}

	$skw = $_POST['skw'];
	if ($skw == '') {
		$skw = 0;
	} else {
		$skw;
	}

	$bow = $_POST['bow'];
	if ($bow == '') {
		$bow = 0;
	} else {
		$bow;
	}

	$ver = $_POST['ver'];
	if ($ver == '') {
		$ver = 0;
	} else {
		$ver;
	}

	$gsm = $_POST['gsm'];
	if ($gsm == '') {
		$gsm = 0;
	} else {
		$gsm;
	}

	$comment = $_POST['comment'];
	if ($comment == '') {
		$comment = 0;
	} else {
		$comment;
	}

	$marker_type = $_POST['marker_type'];
	if ($marker_type == '') {
		$marker_type = 0;
	} else {
		$marker_type;
	}


	if (isset($_POST['code'])) {
		$code = $_POST['code'];
		$count = count($code);
		$damage = $_POST['damage'];
		
		$sql_rows="update $bai_rm_pj1.main_population_tbl set fabric_composition='" . $fabric_composition . "',spec_width='" . $spec_width . "',repeat_length='" . $repeat_length . "',lab_testing='" . $lab_testing . "',tolerance='" . $tolerance . "' where id=".$parent_id."";
		mysqli_query($link, $sql_rows) or die("Error---1111" . mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$id_parent = $parent_id;

		$check_store_tid = "select sno from $bai_rm_pj1.roll_inspection_child where store_in_tid='" . $store_id . "'";
		$details_check_store_tid = mysqli_query($link, $check_store_tid) or die("Error---1111" . mysqli_error($GLOBALS["___mysqli_ston"]));
		$row_sid = mysqli_num_rows($details_check_store_tid);
		$row_store_tid = mysqli_fetch_array($details_check_store_tid);
		if ($row_sid == 1) 
		{
			$update_status_insp = "update $bai_rm_pj1.roll_inspection_child SET inspected_per='" . $inspected_per . "',inspected_qty='" . $inspected_qty . "',invoice_qty='" . $invoice_qty . "',width_s='" . $s . "',width_m='" . $m . "',width_e='" . $e . "',actual_height='" . $actual_height . "',actual_repeat_height='" . $actual_repeat_height . "',skw='" . $skw . "',bow='" . $bow . "',ver='" . $ver . "',gsm='" . $gsm . "',comment='" . $comment . "',marker_type='" . $marker_type . "',status = 2 where store_in_tid='".$store_id."'";
			$roll_inspection_update = $link->query($update_status_insp) or exit('query error in updating222');
			
			$delete_child = "Delete from  $bai_rm_pj1.four_points_table where insp_child_id='" .$store_id. "'";
			$roll_inspection_update = $link->query($delete_child) or exit('query error in deleteing222');
			
			$update_status = "update $bai_rm_pj1.inspection_population SET status=2 where store_in_id='" . $store_id . "'";
			// echo $update_status;
			$result_query_update = $link->query($update_status) or exit('query error in updating222');
			$roll_id = $store_id;
			$insert_four_points = "insert ignore into $bai_rm_pj1.four_points_table(insp_child_id,code,description,points) values ";
			for ($i = 0; $i < $count; $i++) 
			{
				$flag=0;$points=0;
				$submitted_val_array = explode("$", $_POST['submit_value_' . $i]);
				var_dump($submitted_val_array)."<br>";		
				 for($j=2;$j<sizeof($submitted_val_array);$j++)
				{
					if($submitted_val_array[0]<>'' && $submitted_val_array[$j]>0)
					{	
						$insert_four_points .=  "($roll_id,'$submitted_val_array[0]','$submitted_val_array[1]',
						'$submitted_val_array[$j]'),";	
					}		
				}
				unset($submitted_val_array);		
			}
			$insert_four_points = rtrim($insert_four_points, ",");
			mysqli_query($link, $insert_four_points) or die("Error---122" . mysqli_error($GLOBALS["___mysqli_ston"]));
		
			echo "<script>swal('Data Update...','Successfully','success')</script>";
			$url = getFullURLLevel($_GET['r'], '4_point_roll_inspection.php', 0, 'N');
			echo "<script>location.href = '" . $url . "&parent_id=$parent_id'</script>";
			die();
		}
		else 
		{
			$insert_query = "insert into $bai_rm_pj1.roll_inspection_child(inspected_qty,inspected_per,inspected_qty,width_s,width_m,width_e,actual_height,actual_repeat_height,skw,bow,ver,gsm,comment,marker_type,parent_id,status,store_in_tid) values ('$inspected_qty','$inspected_per','$inspected_qty','$s','$m','$e','$actual_height','$actual_repeat_height','$skw','$bow','$ver','$gsm','$comment','$marker_type',$id_parent,2,$store_id)";
			//echo $insert_query;
			$result_query = $link->query($insert_query) or exit('query error in inserting11111');
			$roll_id = $store_id;
			$insert_four_points = "insert ignore into $bai_rm_pj1.four_points_table(insp_child_id,code,description,points) values ";
			for ($i = 0; $i < $count; $i++) 
			{
				$flag=0;$points=0;
				$submitted_val_array = explode("$", $_POST['submit_value_' . $i]);
				var_dump($submitted_val_array)."<br>";		
				 for($j=2;$j<sizeof($submitted_val_array);$j++)
				{
					if($submitted_val_array[0]<>'' && $submitted_val_array[$j]>0)
					{	
						$insert_four_points .=  "($roll_id,'$submitted_val_array[0]','$submitted_val_array[1]',
						'$submitted_val_array[$j]'),";	
					}		
				}
				unset($submitted_val_array);		
			}
			$insert_four_points = rtrim($insert_four_points, ",");
			mysqli_query($link, $insert_four_points) or die("Error---122" . mysqli_error($GLOBALS["___mysqli_ston"]));
		
			$update_status = "update $bai_rm_pj1.inspection_population SET status=2 where store_in_id='" . $store_id . "'";
			// echo $update_status;
			$result_query_update = $link->query($update_status) or exit('query error in updating222');
		}
		echo "<script>swal('Confirmation Updated..','Successfully','success')</script>";
		$url = getFullURLLevel($_GET['r'], '4_point_roll_inspection.php', 0, 'N');
		echo "<script>location.href = '" . $url . "&parent_id=$parent_id'</script>";
		die();
	}
	
}


?>




<script>
	function clearValues(i) {
		var id = i;
		$('#point1_' + id).removeAttr('checked');
		$('#point2_' + id).removeAttr('checked');
		$('#point3_' + id).removeAttr('checked');
		$('#point4_' + id).removeAttr('checked');
	}

	$(document).ready(function() {
		$('input.code').on('change', function(e) {
			
			var url = "<?php echo getFullURL($_GET['r'], 'submit.php', 'R'); ?>"
			const target_id = "damage_" + (e.target.id).split("_")[1];
			const code_id_array=['code_0','code_1','code_2','code_3'];
			let present_id=e.target.id;
			let present_value=e.target.value;
			const newcode_id_array=code_id_array.filter((codeid)=>{
				return codeid !=present_id;
			})
			let flag_for_duplicate=0;
			newcode_id_array.forEach((code_id)=>{
			let presnt_code_valu=$('#'+code_id).val();
			if(presnt_code_valu == present_value)
			{
				flag_for_duplicate=1;
			}

			})	
			console.log(newcode_id_array);
			console.log(flag_for_duplicate);
			if(!flag_for_duplicate)
			{
			$.ajax({
				url: url,
				dataType: 'text',
				type: 'post',
				// contentType: 'applicatoin/x-www-form-urlencoded',
				data: {
					getalldata: e.target.value
				},
				success: function(data, textStatus, jQxhr) {
					var data = $.parseJSON(data);
					if (data.status == 200)
						$('#' + target_id).val(data.message);
					else {
						alert(data.message);
						$('#' + e.target.id).val('');
					}
				},
				error: function(jqXhr, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
			console.log(e.target.id + "-->" + e.target.value)
	
		} else{
			swal('warning','Duplicate Code selected.','warning')
			$('#' + e.target.id).val('');
		}
		$('#clear1').click(function() {
			// alert();
			var id = $(this).val();
			$('#point1_' + id).val('');
			$('#point2_' + id).val('');
			$('#point3_' + id).val('');
			$('#point4_' + id).val('');
			// alert();
		});
	})

	function sample(row, column) {
		if ($('#point' + column + '_' + row).attr('checked', 'checked')) {
			for (var i = 1; i <= 4; i++) {
				if (column != i)
					$('#point' + i + '_' + row).removeAttr("checked");
			}
		} else {
			for (var i = 1; i <= 4; i++) {
				$('#point' + i + '_' + row).removeAttr("checked");
			}
		}
	}

	$(function() {
		$("#save").click(function(e) {
			// e.preventDefault();
			for (let i = 0; i < 4; i++) {
				let point1_value = point2_value = point3_value = point4_value = 0;
				if ($("#point1_" + i).prop("checked")) {
					point1_value = $("#point1_" + i).val();
				}
				if ($("#point2_" + i).prop("checked")) {
					point2_value = $("#point2_" + i).val();
				}
				if ($("#point3_" + i).prop("checked")) {
					point3_value = $("#point3_" + i).val();
				}
				if ($("#point4_" + i).prop("checked")) {
					point4_value = $("#point4_" + i).val();
				}
				let x = $("#code_" + i).val() + "$" + $("#damage_" + i).val() + "$" + point1_value + "$" + point2_value + "$" + point3_value + "$" + point4_value;
				$('#submit_value_' + i).val(x)
			}
			var inspected_per = $("#inspected_per").val();
			var ddlFruits = $("#inspection_status");	
			if (inspected_per > 100) {
				swal('warning','Enter only bellow 100%.','warning')
				return false;
			} else if (ddlFruits.val() == "") {
				swal('warning','Please select Inspection Status!.','warning')
				return false;
			}
			return true;
		});
	});
	$(function() {
		$("#confirm").click(function(e) {
			// e.preventDefault();
			for (let i = 0; i < 4; i++) {
				let point1_value = point2_value = point3_value = point4_value = 0;
				if ($("#point1_" + i).prop("checked")) {
					point1_value = $("#point1_" + i).val();
				}
				if ($("#point2_" + i).prop("checked")) {
					point2_value = $("#point2_" + i).val();
				}
				if ($("#point3_" + i).prop("checked")) {
					point3_value = $("#point3_" + i).val();
				}
				if ($("#point4_" + i).prop("checked")) {
					point4_value = $("#point4_" + i).val();
				}
				let x = $("#code_" + i).val() + "$" + $("#damage_" + i).val() + "$" + point1_value + "$" + point2_value + "$" + point3_value + "$" + point4_value;
				$('#submit_value_' + i).val(x)
			}
			var inspected_per = $("#inspected_per").val();
			var ddlFruits = $("#inspection_status");
			if (inspected_per > 100) {
				alert("Enter only bellow 100%");
				return false;
			} else if (ddlFruits.val() == "") {
				alert("Please select Inspection Status!");
				return false;
			}
			return true;
		});
	});
});
</script>