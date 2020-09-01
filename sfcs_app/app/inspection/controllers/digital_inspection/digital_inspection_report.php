<head>
	<script>
//	var $th = $('.panel.panel-primary').find('thead th')
//$('.panel.panel-primary').on('scroll', function() {
 // $th.css('transform', 'translateY('+ this.scrollTop +'px)');
//});
		function foo(x,y){
			if(x==1){
			 
				swal("warning","Roll Already inspected...","warning");
				var id='data_'+y;
				document.getElementById(id).checked = false;
			}
		}
		$(document).ready(function() {
			if (screen.width <= 1070) 
            {
                $BODY.toggleClass('nav-md nav-sm');
            }
			$("body");
			//$('#myTable thead th:last select').css('visibility','hidden');
			$("#po_no").change(function(){
				$("#supplier_invoice").val('');
				$("#supplier_batch").val('');
				$("#lot_no").val('');
			});
			$("#supplier_invoice").change(function(){
				$("#po_no").val('');
				$("#supplier_batch").val('');
				$("#lot_no").val('');
			});
			$("#supplier_batch").change(function(){
				$("#po_no").val('');
				$("#supplier_invoice").val('');
				$("#lot_no").val('');
			});
			$("#lot_no").change(function(){
				$("#po_no").val('');
				$("#supplier_invoice").val('');
				$("#supplier_batch").val('');
			});
			$(".tr-class-disable").css('background-color', '#70eb77')
			$('#disable_id').on('click', function(e) {	
				let falg_array=new Set();
				$(".select_Check_flag").each(function() {
					falg_array.add($(this).val())
				})
				if(falg_array.size!=1){
					e.preventDefault();
					swal("warning","Please Remove Filter Before Submitting..","warning");
					//$("#disable_id").prop("disabled", true);
				}
			})
			$("#disable_id").prop("disabled", true);
		
			var table = $('#myTable').DataTable({
				"bInfo": false,
				paging: false,
				// "bSort": true, 
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
						var select = $('<select class="select_Check_flag"><option value="">Select All</option></select>')
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
					foo()
					$(this).closest("tr").addClass("selected");
					calculateTotal()
					
					if ($('#disable_id').is(":disabled")) {
						$('#disable_id').prop('disabled', false);
					}
				} else {
					$(this).closest("tr").removeClass("selected");
					calculateTotal()
				}
				let data = table.rows('.selected').data();
				if (data.length) {
					if ($('#disable_id').is(":disabled")) {
						$('#disable_id').prop('disabled', false);
					}
					$('#selectAlll').prop("checked", true);
				} else {
					if (!($('#disable_id').is(":disabled"))) {
						$('#disable_id').prop('disabled', true);
					}
					$('#selectAlll').prop("checked", false);
				}
			});

			$("#myTable tbody tr").click(function(e) {
				foo()
				if (e.target.type != 'checkbox' && e.target.tagName != 'A') {
					var cb = $(this).find("input[type=checkbox]");
					cb.trigger('click');
				}
				let data = table.rows('.selected').data();
				if (data.length) {
					if ($('#disable_id').is(":disabled")) {
						$('#disable_id').prop('disabled', false);

					}
					$('#selectAlll').prop("checked", true);
				} else {
					if (!($('#disable_id').is(":disabled"))) {
						$('#disable_id').prop('disabled', true);
					}
					$('#selectAlll').prop("checked", false);
			
				}
			});

			$('#selectAlll').click(function(e) {
				// foo()
				var tableone = $(e.target).closest('table');
				if (e.target.checked) {
					// $('tr', tableone).addClass("selected");
					$(".need-to-check").each(function() {
						// $('tr', tableone).addClass("selected");
						$(".tr-class-enable").addClass("selected")
						$('.need-to-check input:checkbox').prop('checked', true);
						// if($(this).hasClass('tr-class-enable')){
						// 	$(this).addClass("selected")
						// }
					})
					// if($('tr', tableone).hasClass("need-to-check"))
					// 	$('td input:checkbox', tableone).prop('checked', true);
					calculateTotal()
				
					if ($('#disable_id').is(":disabled")) {
						$('#disable_id').prop('disabled', false);
					}
				} else {
					$('tr', tableone).removeClass("selected");
					$('td input:checkbox', tableone).prop('checked', false);
					calculateTotal()
					if (!($('#disable_id').is(":disabled"))) {
						$('#disable_id').prop('disabled', true);
					}
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
					let valtobecheck = x[1] + "-" + x[0];
					sumValue = intVal(sumValue) + intVal(x[13]);
					distinctRolls.add(valtobecheck);


				});

				$('#total_rolls').text(distinctRolls.size);
				$('#total_length').text(sumValue.toFixed(2));

				$('#hide_total').val(sumValue);
				$('#hide_rolls').val(distinctRolls.size);

			}

			function constructCommaseparatedValues(key, value, set) {
				let commaVal = value + ",";
			}

		});
	</script>
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
	<style>
		.alert,
		strong,
		#myTable th,
		td,#populate_div,#second_row_div,#second_row_child_div {
			text-align: center;
		}

		table tr td {
			cursor: pointer;
		}
		#myTable_wrapper {
			height: 500px;
		}
		#myTable thead th:first-child select {
		display:none;
	}
		#populate_div {
			position: absolute;
		    top: 203px;
    		right: 7%;

		}
		.colunm-select{
			visibility: hidden;
		}
		#output_div {
			background-color:#f5ecec;
			height:190px;
			font-weight: 900;
			font-size: 1.5rem;
			line-height: 1.5;
			padding: 0.25rem 1rem;
			color: #d05d5d;
			text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.4);
		}
		#second_row_div{
			position: relative;
			left: 62px;
			top: 13px;
		}
		#second_row_child_div
		{
			/* margin: 0 0 0 123px;  */
			position: relative;
   			left: 25%;
			top:13px;
		}
		/* .custom-div-1{
			
		} */
		/* @media only screen and (min-width:1187px) {
			{
				position: absolute;
    			margin: 0 0 0 233px;
				
			}
		} */
		@media only screen and (max-width: 720px) {
			
		}
	#myTable thead.Fixed
{
    position: absolute;
}

  .tableFixHead {
            overflow-y: auto; height: 100px; 
         }
        .tableFixHead thead th { 
            position: sticky; top: 0; 
        }

        .tableFixHead table  {
             border-collapse: collapse; width: 100%; 
        }
        th { background:antiquewhite; }
		@media only screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait){

	#second_row_child_div{
		position: absolute;
		bottom:22px;
		left: 248px;

	}
/* 
  #populate_div{
    position: absolute;
    top: 160px;
    right: 40px;
 } */
 #output_div{
	height: 195px;
 }

}
	</style>

	<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'], 'common/js/openbundle_report.min.js', 4, 'R'); ?>"></script>

</head>
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/config.php', 4, 'R'));
include($_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/functions.php', 4, 'R'));
$plant_code = $_SESSION['plantCode'];
$username = $_SESSION['userName'];
?>

<body>
	<div class="container" id='main'>
		<div class="panel panel-primary">
			<div class="panel-heading" style="text-align: left;">Digital Inspection Report</div>
			<div class="panel-body" id="hide_div">
				<div class="row">
					<div class="custom-div-1">
					<div class="col-xs-6 col-sm-6 col-lg-6">
						<div class="panel-body" style="background-color:#f5ecec">
							<form class="form-horizontal form-label-left" method="post" name="input2">
							<input type="hidden" name="plant_code" id="plant_code" value="<?php echo $plant_code; ?>">
							<input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-lg-3">
										Enter PO NO<span class="required"></span>
									</label>
									<div class="col-md-4 col-sm-4 col-xs-12">

										<input type="text" id="po_no" name="po_no" value="<?php echo $_POST['po_no']; ?>" class="form-control col-md-3 col-xs-12 input-sm" autocomplete="off">
									</div>
								</div>
								<b class='text-center col-sm-10'>(OR)</b>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-lg-3" for="last-name">
										Enter Supplier Invoice<span class="required"></span>
									</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text" id="supplier_invoice" name="supplier_invoice" value="<?php echo $_POST['supplier_invoice']; ?>" class="form-control col-md-3 col-xs-12" autocomplete="off">
									</div>
								</div>
								<b class='text-center col-sm-10'>(OR)</b>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-lg-3" for="last-name">
										Enter Supplier Batch<span class="required"></span>
									</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text" id="supplier_batch" name="supplier_batch" value="<?php echo $_POST['supplier_batch']; ?>" class="form-control col-md-3 col-xs-12 " autocomplete="off">
									</div>
								</div>
								<b class='text-center col-sm-10'>(OR)</b>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-lg-3" for="last-name">
										Enter lot no<span class="required"></span>
									</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text" id="lot_no" name="lot_no" value="<?php echo $_POST['lot_no']; ?>" class="form-control col-md-3 col-xs-12" autocomplete="off">
									</div>
								</div>
								<div class='col-sm-12'>
									<center> <input type="submit" class="btn btn-primary" name="submit" value="Search"> </center>
								</div>
							</form>
						</div>
					</div>
					</div>
					<?php

					function message_sql()
					{
						echo "<script>swal('warning','Data not avaible for this criteria','warning');</script>";
					}

					if (isset($_POST['submit'])) {
						$po_no = $_POST['po_no'];
						$plant_code = $_POST['plant_code'];
						$username = $_POST['username'];
						$lot_no_inp = $_POST['lot_no'];
						$supplier_invoice = $_POST['supplier_invoice'];
						$supplier_batch = $_POST['supplier_batch'];

						if ($lot_no_inp != '' && ($po_no == '' && $supplier_invoice == '' && $supplier_batch == '')) {
							$sql_lot_no = "SELECT lot_no FROM $wms.sticker_report WHERE lot_no=\"" . ($lot_no_inp) . "\" and plant_code='".$plant_code."'";
							// echo $sql_lot_no."<br/>";
							$sql_result = mysqli_query($link, $sql_lot_no) or exit(message_sql());

							while ($row = mysqli_fetch_array($sql_result)) {
								$lot_nos[] = $row["lot_no"];
							}
							$lot_number = implode("','", $lot_nos);

							$sql_po_no = "SELECT sr.po_no as po_no,sr.po_line as po_line,sr.po_subline as po_subline,sr.inv_no as inv_no,sr.item as item,sr.item_desc as item_desc,sr.lot_no as lot_no,sr.batch_no as batch_no, si.supplier_no as supplier_no,si.ref2 as ref2,si.qty_rec as qty_rec, si.tid as tid,si.ref3 as ctex_width,si.ref5 as ctex_length,si.four_point_status as four_point_status,sr.item_name as item_name,sr.rm_color as rm_color FROM $wms.sticker_report sr LEFT JOIN $wms.store_in si ON si.lot_no=sr.lot_no WHERE sr.lot_no='$lot_no_inp' AND si.lot_no IN('$lot_number') GROUP BY si.tid order by si.lot_no*1,si.ref2*1";
						}

						if ($po_no != '' && ($lot_no_inp == '' && $supplier_invoice == '' && $supplier_batch == '')) {
							$sql_lot_no = "SELECT lot_no FROM $wms.sticker_report WHERE plant_code='".$plant_code."' AND po_no=\"" . ($po_no) . "\"";
							$sql_result = mysqli_query($link, $sql_lot_no) or exit(message_sql());

							while ($row = mysqli_fetch_array($sql_result)) {
								$lot_nos[] = $row["lot_no"];
							}
							$lot_number = implode("','", $lot_nos);

							$sql_po_no = "SELECT sr.po_no as po_no,sr.po_line as po_line,sr.po_subline as po_subline,sr.inv_no as inv_no,sr.item as item,sr.item_desc as item_desc,sr.lot_no as lot_no,sr.batch_no as batch_no, si.supplier_no as supplier_no,si.ref2 as ref2,si.qty_rec as qty_rec,si.tid as tid,si.ref3 as ctex_width,si.ref5 as ctex_length,si.four_point_status as four_point_status,sr.item_name as item_name,sr.rm_color as rm_color FROM $wms.sticker_report sr LEFT JOIN $wms.store_in si ON si.lot_no=sr.lot_no WHERE sr.po_no='$po_no' AND si.lot_no IN('$lot_number') GROUP BY si.tid order by si.lot_no*1,si.ref2*1";
						}
						if ($supplier_invoice != '' && ($lot_no_inp == '' && $po_no == '' && $supplier_batch == '')) {
							$sql_lot_no = "SELECT lot_no FROM $wms.sticker_report WHERE inv_no=\"" . ($supplier_invoice) . "\" and plant_code='".$plant_code."'";

							$sql_result = mysqli_query($link, $sql_lot_no) or exit(message_sql());

							while ($row = mysqli_fetch_array($sql_result)) {
								$lot_nos[] = $row["lot_no"];
							}
							$lot_number = implode("','", $lot_nos);


							$sql_po_no = "SELECT sr.po_no as po_no,sr.po_line as po_line,sr.po_subline as po_subline,sr.inv_no as inv_no,sr.item as item,sr.item_desc as item_desc,sr.lot_no as lot_no,sr.batch_no as batch_no, si.supplier_no as supplier_no,si.ref2 as ref2,si.qty_rec as qty_rec,si.tid as tid,si.ref3 as ctex_width,si.ref5 as ctex_length,si.four_point_status as four_point_status,sr.item_name as item_name,sr.rm_color as rm_color FROM $wms.sticker_report sr LEFT JOIN $wms.store_in si ON si.lot_no=sr.lot_no WHERE sr.inv_no='$supplier_invoice' AND si.lot_no IN('$lot_number') GROUP BY si.tid order by si.lot_no*1,si.ref2*1";
						}
						if ($supplier_batch != '' && ($lot_no_inp == '' && $po_no == '' && $supplier_invoice == '')) {
							$sql_lot_no = "SELECT lot_no FROM $wms.sticker_report WHERE batch_no=\"" . ($supplier_batch) . "\" and plant_code='".$plant_code."'";

							$sql_result = mysqli_query($link, $sql_lot_no) or exit(message_sql());

							while ($row = mysqli_fetch_array($sql_result)) {
								$lot_nos[] = $row["lot_no"];
							}
							$lot_number = implode("','", $lot_nos);


							$sql_po_no = "SELECT sr.po_no as po_no,sr.po_line as po_line,sr.po_subline as po_subline,sr.inv_no as inv_no,sr.item as item,sr.item_desc as item_desc,sr.lot_no as lot_no,sr.batch_no as batch_no, si.supplier_no as supplier_no,si.ref2 as ref2,si.qty_rec as qty_rec,si.tid as tid,si.ref3 as ctex_width,si.ref5 as ctex_length,si.four_point_status as four_point_status,sr.item_name as item_name,sr.rm_color as rm_color FROM $wms.sticker_report sr LEFT JOIN $wms.store_in si ON si.lot_no=sr.lot_no WHERE sr.batch_no='$supplier_batch' AND si.lot_no IN('$lot_number') GROUP BY si.tid order by si.lot_no*1,si.ref2*1";
						}
					//echo $sql_po_no;
						$sql_result_po = mysqli_query($link, $sql_po_no) or exit(message_sql());
						$num_rows = mysqli_num_rows($sql_result_po) == 0;
						if ($num_rows) {
							echo "<script>swal('No Records Found...','Info','info')</script>";
						} else {
							?>
							<div class="col-xs-6 col-sm-6 col-lg-6">
							
								<div class="panel-body" id="output_div">
									<div class="row">
										<div class="col-sm-4 col-sm-4 " id="second_row_div">
											<div class="panel panel-default">
												<div class="panel-heading" style="background-color: #f4fdd0;"><strong>Total Rolls</strong></div>
												<div class="panel-body" id="total_rolls">0</div>
											</div>
										</div>
										<div class="col-sm-4" id="second_row_child_div">
											<div class="panel panel-default">
												<div class="panel-heading" style="background-color: #f4fdd0;"><strong>Total Length</strong></div>
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
					<form action="<?php getFullURLLevel($_GET["r"], "digital_inspection_report.php", "0", "N") ?>" method="POST">
						<input type="hidden" id="hide_rolls" name="hidden_rolls" value='0'>
						<input type="hidden" id="hide_total" name="hidden_total" value='0'>
						<input type="hidden" name="plant_code" id="plant_code" value="<?php echo $plant_code; ?>">
						<input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
						<table id="myTable" class="table table-striped table-bordered tableFixHead" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Select<input type="checkbox" id="selectAlll"></th>
									<!-- <th>S NO</th> -->
									<th>Supplier Roll No</th>
									<th>SFCS Roll No</th>
									<th>Supplier PO</th>
									<th>Po line</th>
									<th>Po Subline</th>
									<th>Supplier Invoice</th>
									<th>Item Code</th>
									<th>Item Description</th>
									<th>Item Name</th>
									<th>Lot No</th>
									<th>Supplier Batch</th>
									<th>RM Colour</th>
									<th>Quantity</th>


									
								</tr>
							</thead>
							<tbody>
							<?php
									$i=1;
									while ($sql_row = mysqli_fetch_array($sql_result_po)) {
										$var = '';
										$tid = $sql_row['tid'];
										$po_no_1 = $sql_row['po_no'];
										$po_line = $sql_row['po_line'];
										$po_subline = $sql_row['po_subline'];
										$inv_no = $sql_row['inv_no'];
										$item_code = $sql_row['item'];
										$item_desc = $sql_row['item_desc'];
										$item_name = $sql_row['item_name'];
										$lot_no = $sql_row['lot_no'];
										$supplier_batch = $sql_row['batch_no'];
										$supplier_no = $sql_row['supplier_no'];
										$ref2 = $sql_row['ref2'];
										$ref3 = $sql_row['qty_rec'];
										$ctex_width = $sql_row['ctex_width'];
										$ctex_length = $sql_row['ctex_length'];
										$rm_color = $sql_row['rm_color'];
										$four_point_status = $sql_row['four_point_status'];
										if($four_point_status==0){
											$var = 'need-to-check';
										}
										if ($ctex_width == '') {
											$ctex_width = 0;
										} else {
											$ctex_width;
										}
										if ($ctex_length == '') {
											$ctex_length = 0;
										} else {
											$ctex_length;
										}
										if ($po_no_1 == '') {
											$po_no_1 = 0;
										} else {
											$po_no_1;
										}
										if ($po_line == '') {
											$po_line = '--';
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
										if ($item_name == '') {
											$item_name = 0;
										} else {
											$item_name;
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
										//$rm_color = 0;
										if($four_point_status==1)
										{
											$check_status = 'disabled';
											$check_tr_class='tr-class-disable';
										}
										else
										{
											$check_status = '';
										    $check_tr_class='tr-class-enable';
										}

										echo "<tr class='$check_tr_class' onclick=foo('$four_point_status','$i')>
										<td>
										<span class='$var'><input type='checkbox' $check_status id='data_$i' name='bindingdata[]' value='" . $po_no_1 . '$' . $po_line . '$' . $po_subline . '$' . $inv_no . '$' . $item_code . '$' . $item_desc . '$' . $lot_no . '$' . $supplier_batch . '$' . $rm_color . '$' . $supplier_no . '$' . $ref2 . '$' . $ref3 . '$' . $tid . '$' . $item_name . "'>
										</span></td>";

										echo '<td>' . $supplier_no . '</td><td>' . $ref2 . '</td><td>' . $po_no_1 . '</td><td>' . $po_line . '</td><td>' . $po_subline . '</td><td>' . $inv_no . '</td><td>' . $item_code . '</td><td>' . $item_desc . '</td><td>' . $item_name . '</td><td>' . $lot_no . '</td><td>' . $supplier_batch . '</td><td>' . $rm_color . '</td><td>' . $ref3 . '</td><input type="hidden" name="main_id" value="' . $tid . '">';
										
										
										
										echo "</tr>";
										$i++;
									}
								}
								?>
							</tbody>
						</table>
						<?php
							if (!$num_rows) {
								echo '<div class="col-sm-4 col-md-4 col-lg-4" id="populate_div">
										<center><input type="submit" class="btn btn-md btn-primary" id="disable_id" name="set_insp_pop" value="Set Inspection Population"> </center>
										</div>';
							}
							?>
				</div>
				</form>

			</div>
		</div>

	<?php } ?>
	</div>

	</div>
	<?php
	if (isset($_POST['bindingdata'])) {
		$binddetails = $_POST['bindingdata'];
		$plant_code = $_POST['plant_code'];
		$username = $_POST['username'];
		$count1 = count($binddetails);

		if ($count1 > 0) {

			$hid_roll = $count1;
			$hid_total = $_POST['hidden_total'];

			for ($jj = 0; $jj < $count1; $jj++) {
				$id = $binddetails[$jj];
				$exp = explode("$", $id);
				$pos_array[] = $exp[0];
				$lot_nos_array[] = $exp[6];
				$invoice_no_array[] = $exp[3];
				$batch_no_array[] = $exp[7];
				$rm_color[] = $exp[8];
			}

			$insert_main_pop = "insert into $wms.`main_population_tbl` (no_of_rolls,qty,supplier,invoice_no,batch,lot_no,rm_color,plant_code,created_user,updated_user,updated_at) VALUES('" . $hid_roll . "','" . $hid_total . "','" . rtrim(implode(',', array_unique($pos_array)), ",") . "','" . rtrim(implode(',', array_unique($invoice_no_array)), ",") . "','" . rtrim(implode(',', array_unique($batch_no_array)), ",") . "','" . rtrim(implode(',', array_unique($lot_nos_array)), ",") . "', '" . rtrim(implode(',', array_unique($rm_color)), ",") . "','".$plant_code."','".$username."','".$username."',NOW())";

			mysqli_query($link, $insert_main_pop) or exit(message_sql());

			$lastinsert_id = $link->insert_id;

			$insertbinditems = "INSERT IGNORE INTO $wms.inspection_population(lot_no,supplier_po,po_line,po_subline,supplier_invoice,item_code,item_desc,item_name,supplier_batch,rm_color,supplier_roll_no,sfcs_roll_no,rec_qty,status,parent_id,store_in_id,plant_code,created_user,updated_user,updated_at) VALUES";

			for ($j = 0; $j < $count1; $j++) {

				$id = $binddetails[$j];
				$exp = explode("$", $id);
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
				$main_id = $exp[12];
				$item_name = $exp[13];
				$width = $exp[14];
				$length = $exp[15];
				$main_item_name = str_replace('"', '',$item_name);
				$insertbinditems .= ' ("' . $lot_no . '","' . $supplier_po . '","' . $po_line . '","' . $po_subline . '","' . $inv_no . '","' . $item_code . '","' . $item_desc . '","'.$main_item_name.'","' . $batch . '","' . $rm_color . '","' . $supplier_roll_no . '","' . $fcs_no . '","' . $qty . '",0,' . $lastinsert_id . ',' . $main_id . ',"'.$plant_code.'","'.$username.'","'.$username.'",NOW()),';
        
				$update_4point_status = "update $wms.store_in set four_point_status=1,updated_user= '".$username."',updated_at=NOW() where tid in ('" . $main_id . "') and plant_code='".$plant_code."'";

				mysqli_query($link, $update_4point_status) or exit(message_sql());
			}
            
			$insertbinditems = rtrim($insertbinditems, ",");
			mysqli_query($link, $insertbinditems) or exit(message_sql());
		}
         // die();
		echo "<script>swal('Successfully Selected.','Successfully','success')</script>";
		$url = getFullURLLevel($_GET['r'], 'digital_inspection_report_v1.php', 0, 'N');
		echo "<script>location.href = '" . $url . "&parent_id=$lastinsert_id&plant_code=$plant_code&username=$username'</script>";
	}
	?>
	</div>
