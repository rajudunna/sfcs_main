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
	$lot_number = $_GET['lot'] or $_POST['lot'];
	$roll_id = $_GET['roll'] or $_POST['roll'];
	$parent_id = $_GET['parent_id'] or $_POST['parent_id'];
	$supplier_id = $_GET['supplier'] or $_POST['supplier'];
	$invoice_get = $_GET['invoice'] or $_POST['invoice'];
	$lot_get = $_GET['lot'] or $_POST['lot'];
	$store_id =	$_GET['store_id'] or $_POST['store_id'];
}
$get_inspection_population_info = "select * from $bai_rm_pj1.`roll_inspection_child` where store_in_tid=$store_id";
$info_result = mysqli_query($link, $get_inspection_population_info) or exit("get_details Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($row22 = mysqli_fetch_array($info_result)) {

	$sno_points = $row22['sno'];
	$fabric_composition = $row22['fabric_composition'];
	$spec_width = $row22['spec_width'];
	$inspection_status = $row22['inspection_status'];
	$repeat_length = $row22['repeat_length'];
	$spec_weight = $row22['spec_weight'];
	$lab_testing = $row22['lab_testing'];
	$tolerance = $row22['tolerance'];
	$item_code_child = $row22['item_code'];
	$roll_no_child = $row22['roll_no'];
	$inspected_per = $row22['inspected_per'];
	$inspected_qty = $row22['inspected_qty'];
	$invoice_qty = $row22['invoice_qty'];
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
}


$get_details = "select * from `bai_rm_pj1`.`inspection_population` where lot_no='$lot_number' and supplier_roll_no='$supplier_id' and sfcs_roll_no='$roll_id' and parent_id=$parent_id";

$details_result = mysqli_query($link, $get_details) or exit("get_details Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($row1 = mysqli_fetch_array($details_result)) {
	$invoice = $row1['supplier_invoice'];
	$color = $row1['rm_color'];
	$batch = $row1['supplier_batch'];
	$po = $row1['supplier_po'];
	$item_code = $row1['item_code'];
	$item_desc = $row1['item_desc'];
	$ctex_width = $row1['ctex_width'];
	$ctex_length = $row1['ctex_length'];
	$qty = $row1['qty'];
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
							</tr>
							<tr>
								<?php

								echo "<td>$invoice</td>
						      	<td>$color</td>
						      	<td>$batch</td>
						      	<td>$po</td>";
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
									<td><input type="text" id="spec_weight" name="spec_weight" autocomplete="off" value="<?= $spec_weight ?>" <?php if ($spec_weight) echo "readonly" ?> class="float"></td>
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
									<th>Ticket Length</th>
									<th>Ticket Width</th>
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
					      		<td>" . $ctex_length . "</td>
					      		<td>" . $ctex_width . "</td>
					      		<td>" . $item_code . "</td>
					      		<td>" . $color . "</td>
	                            <td>" . $item_desc . "</td>
	                            <td>" . $lot_number . "</td>
								<td>" . $qty . "</td>";

								$get_status_details = "select SUM(1_point) as 1_points,SUM(2_point) as 2_points,SUM(3_point) as 3_points,SUM(4_point) as 4_points from $bai_rm_pj1.four_points_table where insp_child_id = '$id'";
								//echo $get_status_details;
								$status_details_result = mysqli_query($link, $get_status_details) or exit("get_status_details Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
								while ($row5 = mysqli_fetch_array($status_details_result)) {
									$roll = $row5['supplier_roll_no'];
									$status = $row5['inspection_status'];
									$point1 = $row5['1_points'] * 1;
									$point2 = $row5['2_points'] * 2;
									$point3 = $row5['3_points'] * 3;
									$point4 = $row5['4_points'] * 4;
									$main_points =  $point1 + $point2 + $point3 + $point4;
									echo "
		                            <td>" . $main_points . "</td>
		                            <td>" . $status . "</td>
						      	   </tr>";
								}

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
									<td><input type="text" id="item_code" name="item_code" autocomplete="off" value="<?= $item_code_child ?>"></td>
									<td><input type="text" id="roll_no" name="roll_no" autocomplete="off" value="<?= $roll_no_child ?>"></td>
									<td><input type="text" id="inspected_per" name="inspected_per" autocomplete="off" value="<?= $inspected_per ?>" <?php if ($inspected_per) echo "readonly" ?> class="float"></td>
									<td><input type="text" id="inspected_qty" name="inspected_qty" autocomplete="off" value="<?= $inspected_qty ?>" <?php if ($inspected_qty) echo "readonly" ?> class="float"></td>
									<td><input type="text" id="invoice_qty" name="invoice_qty" autocomplete="off" value="<?= $invoice_qty ?>" <?php if ($invoice_qty) echo "readonly" ?> class="float"></td>
									<td>
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
										<th>Code</th>
										<th>Damage Des</th>
										<th>1 Points</th>
										<th>2 Points</th>
										<th>3 Points</th>
										<th>4 Points</th>
										<th>Control</th>
									</tr>

									<?php
									// echo $sno_points;
									if ($sno_points != '') {
										$select_four_points = "select * from $bai_rm_pj1.`four_points_table` where insp_child_id = $sno_points";
										// echo $select_four_points;
										$fourpoints_result = mysqli_query($link, $select_four_points) or exit("get_parent_id Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
										$num_rows = mysqli_num_rows($fourpoints_result);
									} else {
										$num_rows = 0;
									}

									if ($num_rows == 4) {
										$i = 0;
										while ($row44 = mysqli_fetch_array($fourpoints_result)) {
											$code = $row44['code'];
											$description = $row44['description'];
											$first_point = $row44['1_point'];
											$sec_point = $row44['2_point'];
											$third_point = $row44['3_point'];
											$fourth_point = $row44['4_point'];
											echo '<tr>
       									<td><input type="hidden" name="submit_value_' . $i . '" id="submit_value_' . $i . '>"><input type="text" class="code" id="code_' . $i . '" name="code[]" autocomplete="off" value = "' . $code . '"></td>
										<td><input type="text" class="damage" value = "' . $description . '" id="damage_' . $i . '" name="damage[]" readonly></td>';
											if ($first_point == 1) {
												echo '<td><input type="radio" value="1" id="point1_' . $i . '" name="point1[]" onchange="sample(' . $i . ',1)" checked="checked"></td>';
											} else {
												echo '<td><input type="radio" value="1" id="point1_' . $i . '" name="point1[]" onchange="sample(' . $i . ',1)" ></td>';
											}

											if ($sec_point == 2) {
												echo '<td><input type="radio" value="2" id="point2_' . $i . '" name="point2[]" onchange="sample(' . $i . ',2)" checked="checked"></td>';
											} else {
												echo '<td><input type="radio" value="2" id="point2_' . $i . '" name="point2[]" onchange="sample(' . $i . ',2)"></td>';
											}
											if ($third_point == 3) {
												echo '<td><input type="radio" value="3" id="point3_' . $i . '" name="point3[]" onchange="sample(' . $i . ',3)" checked="checked"></td>';
											} else {
												echo '<td><input type="radio" value="3" id="point3_' . $i . '" name="point3[]" onchange="sample(' . $i . ',3)"></td>';
											}
											if ($fourth_point == 4) {
												echo '<td><input type="radio" value="4" id="point4_' . $i . '" name="point4[]" onchange="sample(' . $i . ',4)" checked="checked"></td>';
											} else {
												echo '<td><input type="radio" value="4" id="point4_' . $i . '" name="point4[]" onchange="sample(' . $i . ',4)"></td>';
											}

											echo '<td><button type="button" class="btn btn-primary btn-sm" id="clear" onclick="clearValues(' . $i . ')" value="' . $i . '">Clear</button></td>
									</tr>';
											$i++;
										}
									} else {
										for ($i = 0; $i < 4; $i++) {
											?>
											<tr>

												<td><input type="hidden" name="submit_value_<?php echo $i; ?>" id="submit_value_<?php echo $i; ?>"><input type="text" class="code" id="code_<?php echo $i; ?>" name="code[]" autocomplete="off" value=<?php echo $code; ?>></td>
												<td><input type="text" class="damage" id="damage_<?php echo $i; ?>" name="damage[]" readonly></td>
												<td><input type="radio" value="1" id="point1_<?= $i ?>" name="point1[]" onchange="sample(<?= $i ?>,1)"></td>
												<td><input type="radio" value="2" id="point2_<?= $i ?>" name="point2[]" onchange="sample(<?= $i ?>,2)"></td>
												<td><input type="radio" value="3" id="point3_<?= $i ?>" name="point3[]" onchange="sample(<?= $i ?>,3)"></td>
												<td><input type="radio" value="4" id="point4_<?= $i ?>" name="point4[]" onchange="sample(<?= $i ?>,4)"></td>
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
					<input type="hidden" name="lot_no" value='<?= $lot_number ?>'>
					<input type="hidden" name="supply_no" value='<?= $supplier_id ?>'>
					<input type="hidden" name="roll" value='<?= $roll_id ?>'>
					<input type="hidden" name="po" value='<?= $po ?>'>
					<input type="hidden" name="batch" value='<?= $batch ?>'>
					<input type="hidden" name="color" value='<?= $color ?>'>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
$get_parent_id = "select id from $bai_rm_pj1.roll_inspection where batch_no='$batch' and po_no='$po'";
$get_parent_id_result = mysqli_query($link, $get_parent_id) or exit("get_parent_id Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($row12 = mysqli_fetch_array($get_parent_id_result)) {
	$id_no = $row12['id'];
}
$path_report = getFullURLLevel($_GET['r'], "fabric_inspection_report.php", "0", "R") . "?id=$id_no&color=$color&batch=$batch";

$path = getFullURLLevel($_GET['r'], "submit.php", "0", "R");

$inspection_details = "select * from $bai_rm_pj1.roll_inspection_child where lot_no='$lot_number' and supplier_roll_no='$supplier_id' and sfcs_roll_no='$roll_id'";
//   echo $inspection_details;	
$inspection_details_result = mysqli_query($link, $inspection_details) or exit("inspection_details Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($row4 = mysqli_fetch_array($inspection_details_result)) {
	$status = $row4['inspection_status'];
	$weight = $row4['spec_weight'];
	$length = $row4['repeat_length'];
	$testing = $row4['lab_testing'];
	$fabric = $row4['fabric_composition'];
	$width = $row4['spec_width'];
	$tolerance = $row4['tolerance'];
	$item_code1 = $row4['item_code'];
	$roll_no = $row4['roll_no'];
	$inspected_per = $row4['inspected_per'];
	$inspected_qty = $row4['inspected_qty'];
	$invoice_qty = $row4['invoice_qty'];
	$s = $row4['width_s'];
	$m = $row4['width_m'];
	$e = $row4['width_e'];
	$actual_height = $row4['actual_height'];
	$actual_repeat_height = $row4['actual_repeat_height'];
	$skw = $row4['skw'];
	$bow = $row4['bow'];
	$ver = $row4['ver'];
	$gsm = $row4['gsm'];
	$comment = $row4['comment'];
	$marker_type = $row4['marker_type'];
}
?>


<?php
if (isset($_POST['confirm'])) {
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

	$lot_nums = $_POST['lot_nos'];
	if ($lot_nums == '') {
		$lot_nums = 0;
	} else {
		$lot_nums;
	}

	$tolerance = $_POST['tolerance'];
	if ($tolerance == '') {
		$tolerance = 0;
	} else {
		$tolerance;
	}

	$item_code1 = $_POST['item_code1'];
	if ($item_code1 == '') {
		$item_code1 = 0;
	} else {
		$item_code1;
	}

	$roll_no = $_POST['roll_no'];
	if ($roll_no == '') {
		$roll_no = 0;
	} else {
		$roll_no;
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

	$invoice_qty = $_POST['invoice_qty'];
	if ($invoice_qty == '') {
		$invoice_qty = 0;
	} else {
		$invoice_qty;
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

	$po_no = $_POST['po'];
	if ($po_no == '') {
		$po_no = 0;
	} else {
		$po_no;
	}

	$batch_no = $_POST['batch'];
	if ($batch_no == '') {
		$batch_no = 0;
	} else {
		$batch_no;
	}

	$color = $_POST['color'];
	if ($color == '') {
		$color = 0;
	} else {
		$color;
	}


	if (isset($_POST['code'])) {
		$code = $_POST['code'];
		$count = count($code);
		$damage = $_POST['damage'];

		$insert_roll_details = "insert ignore into $bai_rm_pj1.roll_inspection(po_no,batch_no,color) values ('$po_no','$batch_no','$color')";
		mysqli_query($link, $insert_roll_details) or die("Error---1111" . mysqli_error($GLOBALS["___mysqli_ston"]));

		$check_store_tid = "select sno from $bai_rm_pj1.roll_inspection_child where store_in_tid='" . $store_id . "'";
		$details_check_store_tid = mysqli_query($link, $check_store_tid) or die("Error---1111" . mysqli_error($GLOBALS["___mysqli_ston"]));
		$row_sid = mysqli_num_rows($details_check_store_tid);
		$row_store_tid = mysqli_fetch_array($details_check_store_tid);
		$id_child = $row_store_tid['sno'];
		if ($row_sid == 1) {
			$update_status_insp = "update $bai_rm_pj1.roll_inspection_child SET lot_no='" . $lot_number . "',supplier_roll_no='" . $supplier_id . "',sfcs_roll_no='" . $roll_id . "',fabric_composition='" . $fabric_composition . "',spec_width='" . $spec_width . "',inspection_status='" . $inspection_status . "',repeat_length='" . $repeat_length . "',lab_testing='" . $lab_testing . "',tolerance='" . $tolerance . "',item_code='" . $item_code . "',roll_no='" . $roll_no . "',inspected_per='" . $inspected_per . "',inspected_qty='" . $inspected_qty . "',invoice_qty='" . $invoice_qty . "',width_s='" . $s . "',width_m='" . $m . "',width_e='" . $e . "',actual_height='" . $actual_height . "',actual_repeat_height='" . $actual_repeat_height . "',skw='" . $skw . "',bow='" . $bow . "',ver='" . $ver . "',gsm='" . $gsm . "',comment='" . $comment . "',marker_type='" . $marker_type . "' where store_in_tid='".$store_id."'";
			$roll_inspection_update = $link->query($update_status_insp) or exit('query error in updating222');
			$delete_child = "Delete from $bai_rm_pj1.four_points_table where insp_child_id='" . $id_child . "'";
			//echo $delete_child;
			$roll_inspection_update = $link->query($delete_child) or exit('query error in deleteing222');
			$insert_four_points = "insert ignore into $bai_rm_pj1.four_points_table(insp_child_id,code,description,1_point,2_point,3_point,4_point) values ";
			for ($i = 0; $i < $count; $i++) {
				$submitted_val_array = explode("$", $_POST['submit_value_' . $i]);
				//$submitted_val_array=
				$insert_four_points .=  "($roll_id,'$submitted_val_array[0]','$submitted_val_array[1]',
			'$submitted_val_array[2]','$submitted_val_array[3]','$submitted_val_array[4]','$submitted_val_array[5]'),";
			}
			$insert_four_points = rtrim($insert_four_points, ",");

			mysqli_query($link, $insert_four_points) or die("Error---122" . mysqli_error($GLOBALS["___mysqli_ston"]));
			echo "<script>swal('Data Update...','Successfully','success')</script>";
			$url = getFullURLLevel($_GET['r'], '4_point_roll_inspection.php', 0, 'N');
			echo "<script>location.href = '" . $url . "&parent_id=$parent_id'</script>";
			die();
		} else {
			$insert_query = "insert into $bai_rm_pj1.roll_inspection_child(lot_no,supplier_roll_no,sfcs_roll_no,fabric_composition,spec_width,inspection_status,spec_weight,repeat_length,lab_testing,tolerance,item_code,roll_no,inspected_per,inspected_qty,invoice_qty,width_s,width_m,width_e,actual_height,actual_repeat_height,skw,bow,ver,gsm,comment,marker_type,parent_id,status,store_in_tid) values ('$lot_number','$supplier_id','$roll_id',$fabric_composition,'$spec_width','$inspection_status','$spec_weight','$repeat_length','$lab_testing','$tolerance','$item_code','$roll_no_child','$inspected_per','$inspected_qty','$invoice_qty','$s','$m','$e','$actual_height','$actual_repeat_height','$skw','$bow','$ver','$gsm','$comment','$marker_type',$id_parent,1,$store_id)";
			//echo $insert_query;

			$result_query = $link->query($insert_query) or exit('query error in inserting11111');
			$roll_id = mysqli_insert_id($link);


			$insert_four_points = "insert ignore into $bai_rm_pj1.four_points_table(insp_child_id,code,description,1_point,2_point,3_point,4_point) values ";
			for ($i = 0; $i < $count; $i++) {
				$submitted_val_array = explode("$", $_POST['submit_value_' . $i]);
				//$submitted_val_array=
				$insert_four_points .=  "($roll_id,'$submitted_val_array[0]','$submitted_val_array[1]',
			'$submitted_val_array[2]','$submitted_val_array[3]','$submitted_val_array[4]','$submitted_val_array[5]'),";
			}
			$insert_four_points = rtrim($insert_four_points, ",");

			mysqli_query($link, $insert_four_points) or die("Error---122" . mysqli_error($GLOBALS["___mysqli_ston"]));
			$update_status = "update $bai_rm_pj1.inspection_population SET status=4 where store_in_id='" . $store_id . "'";
			// echo $update_status;
			$result_query_update = $link->query($update_status) or exit('query error in updating222');

			// }
		}
		echo "<script>swal('Data inserted...','Successfully','success')</script>";
		$url = getFullURLLevel($_GET['r'], '4_point_roll_inspection.php', 0, 'N');
		echo "<script>location.href = '" . $url . "&parent_id=$parent_id'</script>";
		die();
	}
}


?>
<?php
if (isset($_POST['save'])) {
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

	$lot_nums = $_POST['lot_nos'];
	if ($lot_nums == '') {
		$lot_nums = 0;
	} else {
		$lot_nums;
	}

	$tolerance = $_POST['tolerance'];
	if ($tolerance == '') {
		$tolerance = 0;
	} else {
		$tolerance;
	}

	$item_code1 = $_POST['item_code1'];
	if ($item_code1 == '') {
		$item_code1 = 0;
	} else {
		$item_code1;
	}

	$roll_no = $_POST['roll_no'];
	if ($roll_no == '') {
		$roll_no = 0;
	} else {
		$roll_no;
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

	$invoice_qty = $_POST['invoice_qty'];
	if ($invoice_qty == '') {
		$invoice_qty = 0;
	} else {
		$invoice_qty;
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

	$po_no = $_POST['po'];
	if ($po_no == '') {
		$po_no = 0;
	} else {
		$po_no;
	}

	$batch_no = $_POST['batch'];
	if ($batch_no == '') {
		$batch_no = 0;
	} else {
		$batch_no;
	}

	$color = $_POST['color'];
	if ($color == '') {
		$color = 0;
	} else {
		$color;
	}


	if (isset($_POST['code'])) {
		$code = $_POST['code'];
		$count = count($code);
		$damage = $_POST['damage'];

		$insert_roll_details = "insert ignore into $bai_rm_pj1.roll_inspection(po_no,batch_no,color) values ('$po_no','$batch_no','$color')";
		mysqli_query($link, $insert_roll_details) or die("Error---1111" . mysqli_error($GLOBALS["___mysqli_ston"]));

		$insert_roll_details_select = "select id from $bai_rm_pj1.roll_inspection where po_no='" . $po_no . "' and batch_no='" . $batch_no . "' and color='" . $color . "'";

		$details_result_select = mysqli_query($link, $insert_roll_details_select) or die("Error---1111" . mysqli_error($GLOBALS["___mysqli_ston"]));
		$row1 = mysqli_fetch_array($details_result_select);
		$id_parent = $row1['id'];

		$check_store_tid = "select sno from $bai_rm_pj1.roll_inspection_child where store_in_tid='" . $store_id . "'";
		$details_check_store_tid = mysqli_query($link, $check_store_tid) or die("Error---1111" . mysqli_error($GLOBALS["___mysqli_ston"]));
		$row_sid = mysqli_num_rows($details_check_store_tid);
		$row_store_tid = mysqli_fetch_array($details_check_store_tid);
		$id_child = $row_store_tid['sno'];
		if ($row_sid == 1) {
			$update_status_insp = "update $bai_rm_pj1.roll_inspection_child SET lot_no='" . $lot_number . "',supplier_roll_no='" . $supplier_id . "',sfcs_roll_no='" . $roll_id . "',fabric_composition='" . $fabric_composition . "',spec_width='" . $spec_width . "',inspection_status='" . $inspection_status . "',repeat_length='" . $repeat_length . "',lab_testing='" . $lab_testing . "',tolerance='" . $tolerance . "',item_code='" . $item_code . "',roll_no='" . $roll_no . "',inspected_per='" . $inspected_per . "',inspected_qty='" . $inspected_qty . "',invoice_qty='" . $invoice_qty . "',width_s='" . $s . "',width_m='" . $m . "',width_e='" . $e . "',actual_height='" . $actual_height . "',actual_repeat_height='" . $actual_repeat_height . "',skw='" . $skw . "',bow='" . $bow . "',ver='" . $ver . "',gsm='" . $gsm . "',comment='" . $comment . "',marker_type='" . $marker_type . "' where store_in_tid='".$store_id."'";
			 echo $update_status_insp;
			$roll_inspection_update = $link->query($update_status_insp) or exit('query error in updating222');
			$delete_child = "Delete from  $bai_rm_pj1.four_points_table where insp_child_id='" . $id_child . "'";
			//echo $delete_child;
			$roll_inspection_update = $link->query($delete_child) or exit('query error in deleteing222');
			$insert_four_points = "insert ignore into $bai_rm_pj1.four_points_table(insp_child_id,code,description,1_point,2_point,3_point,4_point) values ";
			for ($i = 0; $i < $count; $i++) {
				$submitted_val_array = explode("$", $_POST['submit_value_' . $i]);
				//$submitted_val_array=
				$insert_four_points .=  "($roll_id,'$submitted_val_array[0]','$submitted_val_array[1]',
			'$submitted_val_array[2]','$submitted_val_array[3]','$submitted_val_array[4]','$submitted_val_array[5]'),";
			}
			$insert_four_points = rtrim($insert_four_points, ",");

			mysqli_query($link, $insert_four_points) or die("Error---122" . mysqli_error($GLOBALS["___mysqli_ston"]));
			echo "<script>swal('Data Update...','Successfully','success')</script>";
			$url = getFullURLLevel($_GET['r'], '4_point_roll_inspection.php', 0, 'N');
			echo "<script>location.href = '" . $url . "&parent_id=$parent_id'</script>";
			die();
		} else {
			$insert_query = "insert into $bai_rm_pj1.roll_inspection_child(lot_no,supplier_roll_no,sfcs_roll_no,fabric_composition,spec_width,inspection_status,spec_weight,repeat_length,lab_testing,tolerance,item_code,roll_no,inspected_per,inspected_qty,invoice_qty,width_s,width_m,width_e,actual_height,actual_repeat_height,skw,bow,ver,gsm,comment,marker_type,parent_id,status,store_in_tid) values ('$lot_number','$supplier_id','$roll_id',$fabric_composition,'$spec_width','$inspection_status','$spec_weight','$repeat_length','$lab_testing','$tolerance','$item_code','$roll_no_child','$inspected_per','$inspected_qty','$invoice_qty','$s','$m','$e','$actual_height','$actual_repeat_height','$skw','$bow','$ver','$gsm','$comment','$marker_type',$id_parent,2,$store_id)";
			//echo $insert_query;

			$result_query = $link->query($insert_query) or exit('query error in inserting11111');
			$roll_id = mysqli_insert_id($link);


			$insert_four_points = "insert ignore into $bai_rm_pj1.four_points_table(insp_child_id,code,description,1_point,2_point,3_point,4_point) values ";
			for ($i = 0; $i < $count; $i++) {
				$submitted_val_array = explode("$", $_POST['submit_value_' . $i]);
				//$submitted_val_array=
				$insert_four_points .=  "($roll_id,'$submitted_val_array[0]','$submitted_val_array[1]',
			'$submitted_val_array[2]','$submitted_val_array[3]','$submitted_val_array[4]','$submitted_val_array[5]'),";
			}
			$insert_four_points = rtrim($insert_four_points, ",");

			mysqli_query($link, $insert_four_points) or die("Error---122" . mysqli_error($GLOBALS["___mysqli_ston"]));
			$update_status = "update $bai_rm_pj1.inspection_population SET status=3 where store_in_id='" . $store_id . "'";
			// echo $update_status;
			$result_query_update = $link->query($update_status) or exit('query error in updating222');

			// }
		}
		echo "<script>swal('Data inserted...','Successfully','success')</script>";
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
			//alert("hai")
			var url = "<?php echo getFullURL($_GET['r'], 'submit.php', 'R'); ?>"
			const target_id = "damage_" + (e.target.id).split("_")[1];
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
		});
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
				alert("Enter only bellow 100%");
				return false;
			} else if (ddlFruits.val() == "") {
				alert("Please select Inspection Status!");
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
</script>