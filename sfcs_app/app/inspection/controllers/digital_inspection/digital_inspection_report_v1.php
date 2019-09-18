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
				var intVal = function(i) {
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '') * 1 :
						typeof i === 'number' ?
						i : 0;
				};
				data.map(x => {

					let valtobecheck = x[6] + "-" + x[11];
					sumValue = intVal(sumValue) + intVal(x[11]);
					distinctRolls.add(valtobecheck);

				});
				let total_fixed_rolls = (intVal($('#fixed_rolls_input_val').val()) > 0) ? intVal($('#fixed_rolls_input_val').val()) : 1;
				let total_fixed_length = (intVal($('#fixed_length_input_val').val()) > 0) ? intVal($('#fixed_length_input_val').val()) : 1;

				/**
				percentage calculations start */
				let totalrollpercent = Math.floor((((distinctRolls.size) / total_fixed_rolls) * 100));
				let totallengthpercent = Math.floor(((intVal((sumValue)) / total_fixed_length) * 100));
				/**
				percentage calculations END */
				let displayvalue_roll_total = (distinctRolls.size).toString() + "(" + totalrollpercent + "%)";
				let displayvalue_roll_length = sumValue.toString() + "(" + totallengthpercent + "%)";
				$('#total_rolls').text(displayvalue_roll_total);
				$("#total_length").text(displayvalue_roll_length);
			}
			/**
			counting logic end
			 */

			/**
			counting logic start 
			*/
			function calculateTotalForFixed() {
				const data = table.rows().data();
				const distinctRolls = new Set();
				let sumValue = 0;
				data.map(x => {
					var intVal = function(i) {
						return typeof i === 'string' ?
							i.replace(/[\$,]/g, '') * 1 :
							typeof i === 'number' ?
							i : 0;
					};
					let valtobecheck = x[6] + "-" + x[11];
					sumValue = intVal(sumValue) + intVal(x[11]);
					distinctRolls.add(valtobecheck);

				});
				$('#fixed_rolls').text(distinctRolls.size);
				$('#fixed_rolls_input_val').val(distinctRolls.size);
				$("#fixed_length").text(sumValue);
				$('#fixed_length_input_val').val(sumValue);
			}
			/**
			counting logic end
			 */
			calculateTotalForFixed();
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

		table tr td {
			cursor: pointer;
		}

		#populate_div {
			position: absolute;
			top: 250px;

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

<div class="panel panel-primary" id="navbar">
	<div class="panel-body" >
		<div class="col-xs-6 col-sm-6 col-lg-6">
			<div class="panel-body" style="background-color:#f1f1f1;height: 280px;">
				<div class="row">
					<div class="col-sm-4">
						<div class="panel panel-default">
							<div class="panel-heading"><strong>Total Rolls</strong></div>
							<div class="panel-body" id="fixed_rolls">0</div>
							<input type="hidden" id="fixed_rolls_input_val">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="panel panel-default">
							<div class="panel-heading"><strong>Total Length</strong></div>
							<div class="panel-body" id="fixed_length">0</div>
							<input type="hidden" id="fixed_length_input_val">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<div class="panel panel-default">
							<div class="panel-heading"><strong>Selected Rolls</strong></div>
							<div class="panel-body" id="total_rolls">0</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<div class="panel panel-default">
								<div class="panel-heading"><strong>Selected Length</strong></div>
								<div class="panel-body" id="total_length">0</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><br/>
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
						$sql_query = "select * from $bai_rm_pj1.inspection_population where status=0";
						$sql_result = mysqli_query($link, $sql_query) or exit("Sql Error" . mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($sql_row = mysqli_fetch_array($sql_result)) {
							$sno = $sql_row['sno'];
							$lot_no = $sql_row['lot_no'];
							$po_no_1 = $sql_row['supplier_po'];
							$po_line = $sql_row['po_line'];
							$po_subline = $sql_row['po_subline'];
							$inv_no = $sql_row['supplier_invoice'];
							$item_code = $sql_row['item_code'];
							$item_desc = $sql_row['item_desc'];
							$supplier_batch = $sql_row['supplier_batch'];
							$rm_color = $sql_row['rm_color'];
							$supplier_roll_no = $sql_row['sfcs_roll_no'];
							$fcs_roll_no = $sql_row['supplier_roll_no'];

							$qty = $sql_row['qty'];

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
							if ($supplier_roll_no == '') {
								$supplier_roll_no = 0;
							} else {
								$supplier_roll_no;
							}
							if ($fcs_roll_no == '') {
								$fcs_roll_no = 0;
							} else {
								$fcs_roll_no;
							}
							if ($qty == '') {
								$qty = 0;
							} else {
								$qty;
							}
							if ($rm_color == '') {
								$rm_color = '--';
							} else {
								$rm_color;
							}
							echo '<tr><td>' . $po_no_1 . '</td><td>' . $po_line . '</td><td>' . $po_subline . '</td><td>' . $inv_no . '</td><td>' . $item_code . '</td><td>' . $item_desc . '</td><td>' . $lot_no . '</td><td>' . $supplier_batch . '</td><td>' . $rm_color . '</td><td>' . $fcs_roll_no . '</td><td>' . $supplier_roll_no . '</td><td>' . $qty . '</td>';
							echo "<td><input type='checkbox' name='bindingdata[]' value='" . $sno . '/' . $lot_no . "'></td></tr>";
						}

						?>
					</tbody>
				</table>
				<div class="button_pop col-sm-4" id="populate_div">
					<center><input type="submit" class="btn btn-md btn-primary" name="set_insp_pop" value="Proceed for Inspection"> </center>
				</div>
			</form>
		</div>
	</div>

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
			$sno = $exp[0];
			$lot_num[] = $exp[1];

			$insertbinditems = "update $bai_rm_pj1.inspection_population set status=1 where sno=$sno";
			mysqli_query($link, $insertbinditems) or exit("Sql Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		$lot_array = implode(",", $lot_num);
		// echo $lot_array;
	}
	echo "<script>swal('Data inserted...','Successfully','success')</script>";
	$url = getFullURLLevel($_GET['r'], '4_point_roll_inspection.php', 0, 'N') . "&lot_no=$lot_array";
	echo "<script>location.href = '" . $url . "'</script>";
}
?>
<script>
window.onscroll = function() {myFunction()};

var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
</script>