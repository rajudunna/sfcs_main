<head>
	<script>
		$(document).ready(function() {
			var table = $('#myTable').DataTable({
				"bInfo": false,
				paging: false,
				"bSort": true,
				"dom": '<"top"iflp<"clear">>rt',
				select: {
					style: 'multi'
				},
				order: [
					[1, 'asc']
				], 
				initComplete: function() {
					this.api().columns().every(function() {
						var column = this;
						var select = $('<select><option value=""></option></select>')
							.appendTo($(column.header()))
							.on('change', function() {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);

								column
									.search(val ? '^' + val + '$' : '', true, false)
									.draw();
							});

						column.data().unique().sort().each(function(d, j) {
							select.append('<option value="' + d + '">' + d + '</option>')

						});

					});
				}
			});

			/**
			 * selection of the single row and selecting all the rows at on click
			 */
			$("#myTable tbody tr input[type=checkbox]").change(function(e) {
				if (e.target.checked) {
					$(this).closest("tr").addClass("selected");
					calculateTotal()
				} else {
					$(this).closest("tr").removeClass("selected");
					calculateTotal()
				}
			});

			$("#myTable tbody tr").click(function(e) {
				if (e.target.type != 'checkbox' && e.target.tagName != 'A') {
					var cb = $(this).find("input[type=checkbox]");
					cb.trigger('click');
				}

			});
			$('#selectAlll').click(function(e) {
				var tableone = $(e.target).closest('table');

				if (e.target.checked) {
					$('tr', tableone).addClass("selected");
					$('td input:checkbox', tableone).prop('checked', true);
					calculateTotal()
				} else {
					$('tr', tableone).removeClass("selected");
					$('td input:checkbox', tableone).prop('checked', false);
					calculateTotal()
				}
			});
			/**
			 * End of the Selection code 
			 */
			/**
			counting logic start 
			*/
			function calculateTotal() {
				const data = table.rows('.selected').data();
				const distinctRolls = new Set();
				let sumValue = 0;
				data.map(x => {
					var intVal = function(i) {
						return typeof i === 'string' ?
							i.replace(/[\$,]/g, '') * 1 :
							typeof i === 'number' ?
							i : 0;
					};
					let valtobecheck = x[6] + "-" + x[10];
					sumValue = intVal(sumValue) + intVal(x[10]);
					distinctRolls.add(valtobecheck);

				});
				$('#total_rolls').text(distinctRolls.size);
				$("#total_length").text(sumValue);
			}
			/**
			counting logic end
			 */

		});
	</script>
	<style>
		.alert,
		strong,
		body,
		table th,
		td {
			text-align: center;
		}

		#populate_div {
			position: absolute;
			top: 176px;
			right: 78px;
		}
	</style>
	
	<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'], 'common/js/openbundle_report.min.js', 3, 'R'); ?>"></script>

</head>
<?php

include(getFullURLLevel($_GET['r'], 'common/config/config.php', 4, 'R'));
include(getFullURLLevel($_GET['r'], 'common/config/functions.php', 4, 'R'));
include($_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/config.php', 3, 'R'));
include($_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/functions.php', 3, 'R'));
include($_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/user_acl_v1.php', 3, 'R'));
?>

<body>
	<div class="container" id='main'>
		<div class="panel panel-primary">
			<div class="panel-heading" style="text-align: left;">Digital Inspection Report</div>
			<div class="panel-body" id="hide_div">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-lg-6">
						<div class="panel-body" style="background-color:#f1f1f1">
							<form class="form-horizontal form-label-left" method="post" name="input2">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">
										Enter PO NO<span class="required"></span>
									</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text" id="course" name="po_no" class="form-control col-md-3 col-xs-12 input-sm" autocomplete="off">
									</div>
								</div>
								<b class='text-center col-sm-10'>(OR)</b>
								<div class="form-group">
									<label class="control-label col-md-3" for="last-name">
										Enter Supplier Invoice<span class="required"></span>
									</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text" id="course1" name="supplier_invoice" class="form-control col-md-3 col-xs-12 input-sm integer" autocomplete="off">
									</div>
								</div>
								<b class='text-center col-sm-10'>(OR)</b>
								<div class="form-group">
									<label class="control-label col-md-3" for="last-name">
										Enter Supplier Batch<span class="required"></span>
									</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text" id="course1" name="supplier_batch" class="form-control col-md-3 col-xs-12 input-sm integer" autocomplete="off">
									</div>
								</div>
								<b class='text-center col-sm-10'>(OR)</b>
								<div class="form-group">
									<label class="control-label col-md-3" for="last-name">
										Enter lot no<span class="required"></span>
									</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text" id="course1" name="lot_no" class="form-control col-md-3 col-xs-12 input-sm integer" autocomplete="off">
									</div>
								</div>
								<div class='col-sm-12'>
									<center> <input type="submit" class="btn btn-primary" name="submit" value="Search"> </center>
								</div>
							</form>
						</div>
					</div>
					<?php

					function message_sql()
					{
						echo "<script>swal('something went wrong......please try again','','warning');</script>";
					}

					if (isset($_POST['submit'])) {
						$po_no = $_POST['po_no'];
						$lot_no_inp = $_POST['lot_no'];
						$supplier_invoice = $_POST['supplier_invoice'];
						$supplier_batch = $_POST['supplier_batch'];
						// echo "Po number".$po_no." and lot no".$lot_no_inp." and supplier_invoice ".$supplier_invoice." and supplier_invoice ".$supplier_batch;

						if ($lot_no_inp != '' && ($po_no == '' && $supplier_invoice == '' && $supplier_batch == '')) {
							$sql_lot_no = "SELECT lot_no FROM $bai_rm_pj1.sticker_report WHERE lot_no=\"" . ($lot_no_inp) . "\"";
							// echo $sql_lot_no."<br/>";
							$sql_result = mysqli_query($link, $sql_lot_no) or exit(message_sql());

							while ($row = mysqli_fetch_array($sql_result)) {
								$lot_nos[] = $row["lot_no"];
							}
							$lot_number = implode(",", $lot_nos);

							$sql_po_no = "SELECT sr.po_no as po_no,sr.po_line as po_line,sr.po_subline as po_subline,sr.inv_no as inv_no,sr.item as item,sr.item_desc as item_desc,sr.lot_no as lot_no,sr.supplier as supplier, si.supplier_no as supplier_no,si.ref2 as ref2,si.ref3 as ref3 FROM bai_rm_pj1.sticker_report sr LEFT JOIN bai_rm_pj1.store_in si ON si.lot_no=sr.lot_no WHERE sr.lot_no='$lot_no_inp' AND si.lot_no IN($lot_number) GROUP BY si.tid order by si.lot_no*1,si.ref2*1";
						}
						if ($po_no != '' && ($lot_no_inp == '' && $supplier_invoice == '' && $supplier_batch == '')) {
							$sql_lot_no = "SELECT lot_no FROM $bai_rm_pj1.sticker_report WHERE po_no=\"" . ($po_no) . "\"";
							$sql_result = mysqli_query($link, $sql_lot_no) or exit(message_sql());

							while ($row = mysqli_fetch_array($sql_result)) {
								$lot_nos[] = $row["lot_no"];
							}
							$lot_number = implode(",", $lot_nos);

							$sql_po_no = "SELECT sr.po_no as po_no,sr.po_line as po_line,sr.po_subline as po_subline,sr.inv_no as inv_no,sr.item as item,sr.item_desc as item_desc,sr.lot_no as lot_no,sr.supplier as supplier, si.supplier_no as supplier_no,si.ref2 as ref2,si.ref3 as ref3 FROM bai_rm_pj1.sticker_report sr LEFT JOIN bai_rm_pj1.store_in si ON si.lot_no=sr.lot_no WHERE sr.po_no='$po_no' AND si.lot_no IN($lot_number) GROUP BY si.tid order by si.lot_no*1,si.ref2*1";
						}
						if ($supplier_invoice != '' && ($lot_no_inp == '' && $po_no == '' && $supplier_batch == '')) {
							$sql_lot_no = "SELECT lot_no FROM $bai_rm_pj1.sticker_report WHERE inv_no=\"" . ($supplier_invoice) . "\"";

							$sql_result = mysqli_query($link, $sql_lot_no) or exit(message_sql());

							while ($row = mysqli_fetch_array($sql_result)) {
								$lot_nos[] = $row["lot_no"];
							}
							$lot_number = implode(",", $lot_nos);


							$sql_po_no = "SELECT sr.po_no as po_no,sr.po_line as po_line,sr.po_subline as po_subline,sr.inv_no as inv_no,sr.item as item,sr.item_desc as item_desc,sr.lot_no as lot_no,sr.supplier as supplier, si.supplier_no as supplier_no,si.ref2 as ref2,si.ref3 as ref3 FROM bai_rm_pj1.sticker_report sr LEFT JOIN bai_rm_pj1.store_in si ON si.lot_no=sr.lot_no WHERE sr.inv_no='$supplier_invoice' AND si.lot_no IN($lot_number) GROUP BY si.tid order by si.lot_no*1,si.ref2*1";
						}
						if ($supplier_batch != '' && ($lot_no_inp == '' && $po_no == '' && $supplier_invoice == '')) {
							$sql_lot_no = "SELECT lot_no FROM $bai_rm_pj1.sticker_report WHERE supplier=\"" . ($supplier_batch) . "\"";

							$sql_result = mysqli_query($link, $sql_lot_no) or exit(message_sql());

							while ($row = mysqli_fetch_array($sql_result)) {
								$lot_nos[] = $row["lot_no"];
							}
							$lot_number = implode(",", $lot_nos);


							$sql_po_no = "SELECT sr.po_no as po_no,sr.po_line as po_line,sr.po_subline as po_subline,sr.inv_no as inv_no,sr.item as item,sr.item_desc as item_desc,sr.lot_no as lot_no,sr.supplier as supplier, si.supplier_no as supplier_no,si.ref2 as ref2,si.ref3 as ref3 FROM bai_rm_pj1.sticker_report sr LEFT JOIN bai_rm_pj1.store_in si ON si.lot_no=sr.lot_no WHERE sr.supplier='$supplier_batch' AND si.lot_no IN($lot_number) GROUP BY si.tid order by si.lot_no*1,si.ref2*1";
						}
						// echo $sql_po_no;

						$sql_result_po = mysqli_query($link, $sql_po_no) or exit(message_sql());
						if (mysqli_num_rows($sql_result_po) == 0) {
							$idx = "<div class='alert alert-info'><strong>Info!</strong> Sorry No Records Found......!</div>";
						} else {
							?>
							<div class="col-xs-6 col-sm-6 col-lg-6">
								<div class="panel-body" style="background-color:#f1f1f1;height:167px;">
									<div class="row">
										<div class="col-sm-4" style="position: relative;left: 62px;">
											<div class="panel panel-default">
												<div class="panel-heading"><strong>Total Rolls</strong></div>
												<div class="panel-body" id="total_rolls">0</div>
											</div>
										</div>
										<div class="col-sm-4" style="margin: 0 0 0 123px;">
											<div class="panel panel-default">
												<div class="panel-heading"><strong>Total Length</strong></div>
												<div class="panel-body" id="total_length">0</div>
											</div>
										</div>
									</div>

								</div>
							</div>
				</div>
			</div>
			<div class="panel panel-primary" style="overflow-x: scroll;">
				<div class="panel-body">
				<form action="<?php getFullURLLevel($_GET["r"], "digital_inspection_report_v1.php", "0", "N") ?>" method="POST">
					<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Supplier PO</th>
								<th>Po line</th>
								<th>Po Subline</th>
								<th>Supplier Invoice</th>
								<th>Item Code</th>
								<th>Item Description</th>
								<th>Lot No</th>
								<th>Supplier Batch</th>
								<th>RM Colour</th>
								<th>Supplier Roll No</th>
								<th>FCS Roll No</th>
								<th>Quantity</th>

								
									<th>Select<input type="checkbox" id="selectAlll"></th>
							</tr>
						</thead>
						<tbody>
						<?php
								while ($sql_row = mysqli_fetch_array($sql_result_po)) {
									$po_no_1 = $sql_row['po_no'];
									$po_line = $sql_row['po_line'];
									$po_subline = $sql_row['po_subline'];
									$inv_no = $sql_row['inv_no'];
									$item_code = $sql_row['item'];
									$item_desc = $sql_row['item_desc'];
									$lot_no = $sql_row['lot_no'];
									$supplier_batch = $sql_row['supplier'];
									$supplier_no = $sql_row['supplier_no'];
									$ref2 = $sql_row['ref2'];
									$ref3 = $sql_row['ref3'];

									if ($po_no_1 == '') {
										$po_no_1 = 0;
									} else {
										$po_no_1;
									}

									if ($po_line == '') {
										$po_line = 0;
									} else {
										$po_line;
									}
									if ($po_subline == '') {
										$po_subline = 0;
									} else {
										$po_subline;
									}
									if ($inv_no == '') {
										$inv_no = 0;
									} else {
										$inv_no;
									}
									if ($item_code == '') {
										$item_code = 0;
									} else {
										$item_code;
									}
									if ($item_desc == '') {
										$item_desc = 0;
									} else {
										$item_desc;
									}
									if ($lot_no == '') {
										$lot_no = 0;
									} else {
										$lot_no;
									}
									if ($supplier_batch == '') {
										$supplier_batch = 0;
									} else {
										$supplier_batch;
									}
									if ($supplier_no == '') {
										$supplier_no = 0;
									} else {
										$supplier_no;
									}
									if ($ref2 == '') {
										$ref2 = 0;
									} else {
										$ref2;
									}
									if ($ref3 == '') {
										$ref3 = 0;
									} else {
										$ref3;
									}

									echo '<tr><td>' . $po_no_1 . '</td><td>' . $po_line . '</td><td>' . $po_subline . '</td><td>' . $inv_no . '</td><td>' . $item_code . '</td><td>' . $item_desc . '</td><td>' . $lot_no . '</td><td>' . $supplier_batch . '</td><td>' . '--' . '</td><td>' . $supplier_no . '</td><td>' . $ref2 . '</td><td>' . $ref3 . '</td>';
									echo "<td><input type='checkbox' name='bindingdata[]' value='" . $po_no_1 . '/' . $po_line . '/' . $po_subline . '/' . $inv_no . '/' . $item_code . '/' . $item_desc . '/' . $lot_no . '/' . $supplier_batch . '/' . $supplier_no . '/' . $ref2 . '/' . $ref3 . "'></td></tr>";
								}
							}
							?>
						</tbody>
					</table>

						<?php
							if (!$idx)
							{
								echo '<div class="col-sm-4" id="populate_div">
								<center><input type="submit" class="btn btn-md btn-primary" name="set_insp_pop" value="Set Inspection Population"> </center>
								</div>';
							}
						?>
					</div>
				</form>
				<?php echo $idx; ?>
			</div>
		</div>

	<?php } ?>
	</div>

	</div>
	<?php
	if (isset($_POST['bindingdata'])) {
		$binddetails = $_POST['bindingdata'];

		$count1 = count($binddetails);
		if ($count1 > 0) {
			for ($j = 0; $j < $count1; $j++) {
				$id = $binddetails[$j];
				$exp = explode("/", $id);
				$supplier_po = $exp[0];
				$po_line = $exp[1];
				$po_subline = $exp[2];
				$inv_no = $exp[3];
				$item_code = $exp[4];
				$item_desc = $exp[5];
				$lot_no = $exp[6];
				$batch = $exp[7];
				$rm_color = $exp[8];
				$supplier_roll_no = $exp[9];
				$fcs_no = $exp[10];
				$qty = $exp[11];

				$insertbinditems = "INSERT ignore INTO $bai_rm_pj1.inspection_population(lot_no,supplier_po,po_line,po_subline,supplier_invoice,item_code,item_desc,supplier_batch,rm_color,supplier_roll_no,sfcs_roll_no,qty,status) VALUES (\"" . $lot_no . "\",\"" . $supplier_po . "\",\"" . $po_line . "\",\"" . $po_subline . "\",\"" . $inv_no . "\",\"" . $item_code . "\",\"" . $item_desc . "\",\"" . $batch . "\",\"0\",\"" . $supplier_roll_no . "\",\"" . $fcs_no . "\",\"" . $qty . "\",0)";
				mysqli_query($link, $insertbinditems) or exit(message_sql());
			}
		}
		echo "<script>swal('Data inserted...','Successfully','success')</script>";
		echo "<script>location.href = '" . getFullURLLevel($_GET['r'], 'digital_inspection_report_v1.php', 0, 'N') . "'</script>";
	}
	?>
	</div> 