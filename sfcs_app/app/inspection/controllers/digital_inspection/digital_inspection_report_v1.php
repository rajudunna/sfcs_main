<?php
if(isset($_GET['parent_id'])){
	$parent_id=$_GET['parent_id'];
}
$status=0;
if(isset($_GET['status'])>0){
	$status=$_GET['status'];
}
?>

<head>
 <script>
		
		$(document).ready(function() {
			if (screen.width <= 1070) 
            {
                $BODY.toggleClass('nav-md nav-sm');
            }
			$('#disable_id').on('click',function(){
		        $('#submit_type').val('Proceed for Inspection');
			});
			$('#disable_id1').on('click',function(){
		        $('#submit_type').val('Color Contuinity Report');
			});

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
				
					$('#selectAlll').prop( "checked", true );
				} else {
					if (!($('#disable_id').is(":disabled"))) {
						$('#disable_id').prop('disabled', true);
					}
				
					$('#selectAlll').prop( "checked", false );
				}
			});

			$("#myTable tbody tr").click(function(e) {
				if (e.target.type != 'checkbox' && e.target.tagName != 'A') {
					var cb = $(this).find("input[type=checkbox]");
					cb.trigger('click');
				}
				let data = table.rows('.selected').data();
				if (data.length) {
					if ($('#disable_id').is(":disabled")) {
						$('#disable_id').prop('disabled', false);
						
					}
					
					$('#selectAlll').prop( "checked", true );
				} else {
					if (!($('#disable_id').is(":disabled"))) {
						$('#disable_id').prop('disabled', true);
					}
					
					$('#selectAlll').prop( "checked", false );
				}
			});

			$('#selectAlll').click(function(e) {
				var tableone = $(e.target).closest('table');
				if (e.target.checked) {
					$('tr', tableone).addClass("selected");
					$('td input:checkbox', tableone).prop('checked', true);
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
				var intVal = function(i) {
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '') * 1 :
						typeof i === 'number' ?
						i : 0;
				};
				data.map(x => {

					let valtobecheck = x[1] + "-" + x[0];
					sumValue = intVal(sumValue) + intVal(x[13]);
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
				let displayvalue_roll_length = sumValue.toFixed(2) + "(" + totallengthpercent + "%)";
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
					let valtobecheck = x[1] + "-" + x[0];
					sumValue = intVal(sumValue) + intVal(x[13]);
					distinctRolls.add(valtobecheck);

				});
				$('#fixed_rolls').text(distinctRolls.size);
				$('#fixed_rolls_input_val').val(distinctRolls.size);
				$("#fixed_length").text(sumValue.toFixed(2));
				$('#fixed_length_input_val').val(sumValue);
			}
			/**
			counting logic end
			 */
			calculateTotalForFixed();
		});
		
	</script>
	<style>
	body,table {
	  -webkit-overflow-scrolling: touch; /* Lets it scroll lazy */
	}

		.add_fix{
			position: fixed;
    		top: 340px;
    		left: 424px;
   			z-index: 4;
		}
		.black{
			
            position:sticky;
            top: 0.25rem;
			z-index:1;
		}
		/* .sticky_div {
            font-weight: 900;
            font-size: 1.5rem;
            line-height: 1.5;
            padding: 0.25rem 1rem;
            color: whitesmoke;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.8);
            position:sticky;
            top: 0.25rem;
			z-index:1;
            
        } */
		.output_div{
			font-weight: 900;
			font-size: 1.5rem;
			line-height: 1.5;
			padding: 0.25rem 1rem;
			color: #d05d5d;
			text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.4);
		}
		.alert,
		strong,
		#myTable th,
		td,.position_div {
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
       
		.populate_div {
			position: absolute;
    		top: 251px;
    		right:294px;

		}
		.position_div{
			position: relative;
    		left: 70px;
		}		
		.panel-heading{
			background-color: #f4fdd0;
		}
		@media (min-device-width: 591px) and (max-device-width: 991px) {
		.populate_div {
  		  position: absolute;
			top: 251px;
   			 right: 20%
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
}
	</style>

	<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'], 'common/js/openbundle_report.min.js', 4, 'R'); ?>"></script>

</head>

<?php

include($_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/config.php', 4, 'R'));
include($_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/functions.php', 4, 'R'));
$plant_code = $_GET['plant_code'];
$username = $_GET['username'];
?>

<div class="panel panel-primary" id="navbar">
<nav>	
<div class="panel-body sticky_div" >
		<div class="col-xs-6 col-sm-10 col-lg-6">
			<div class="panel-body output_div" style="background-color:#f5ecec;height: 280px;">
				<div class="row position_div">
					<div class="col-sm-4 col-md-4 col-lg-4">
						<div class="panel panel-default">
							<div class="panel-heading"><strong>Total Rolls</strong></div>
							<div class="panel-body" id="fixed_rolls">0</div>
							<input type="hidden" id="fixed_rolls_input_val">
						</div>
					</div>
					<div class="col-sm-4 col-md-4 col-lg-4">
						<div class="panel panel-default">
							<div class="panel-heading"><strong>Total Length</strong></div>
							<div class="panel-body" id="fixed_length">0</div>
							<input type="hidden" id="fixed_length_input_val">
						</div>
					</div>
				</div>
				<div class="row position_div">
					<div class="col-sm-4 col-md-4 col-lg-4">
						<div class="panel panel-default">
							<div class="panel-heading"><strong>Selected Rolls</strong></div>
							<div class="panel-body" id="total_rolls">0</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4 col-md-4 col-lg-4">
							<div class="panel panel-default">
								<div class="panel-heading"><strong>Selected Length</strong></div>
								<div class="panel-body" id="total_length">0</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div></nav><br/>
	
			<form action="<?php getFullURLLevel($_GET["r"], "digital_inspection_report_v1.php", "0", "N") ?>" method="POST" name="form1" id="form1">
					<?php
						echo "<input type='hidden' value=".$parent_id." name='parent_id'>";
						echo "<input type='hidden' value=".$plant_code." name='plant_code' id='plant_code'>";
						echo "<input type='hidden' value=".$username." name='username' id='username'>";
						$sql_query = "select * from $wms.inspection_population where parent_id=$parent_id and plant_code='".$plant_code."'";
						$k=0;
						$sql_result = mysqli_query($link, $sql_query) or exit("Sql Error1" . mysqli_error($GLOBALS["___mysqli_ston"]));
						if (mysqli_num_rows($sql_result) == 0) {
							echo "<div class='alert alert-info'><strong>Info!</strong> Sorry No Records Found......!</div>";
						}else{
							echo '<div class="panel panel-primary" style="overflow-x:scroll;">
							<div class="panel-body">
							<table id="myTable" class="table table-striped table-bordered tableFixHead" cellspacing="0" width="100%">
							<thead>
						<tr>
						<th>Select<input type="checkbox" id="selectAlll"></th>
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
					<tbody>';
						
						while ($sql_row = mysqli_fetch_array($sql_result)) {
							$k++;
							$sno = $sql_row['sno'];
							$lot_no = $sql_row['lot_no'];
							$po_no_1 = $sql_row['supplier_po'];
							$po_line = $sql_row['po_line'];
							$po_subline = $sql_row['po_subline'];
							$inv_no = $sql_row['supplier_invoice'];
							$item_code = $sql_row['item_code'];
							$item_desc = $sql_row['item_desc'];
							$item_name = $sql_row['item_name'];
							$supplier_batch = $sql_row['supplier_batch'];
							$rm_color = $sql_row['rm_color'];
							$supplier_roll_no = $sql_row['sfcs_roll_no'];
							$fcs_roll_no = $sql_row['supplier_roll_no'];
							$qty = $sql_row['rec_qty'];

							if ($po_no_1 == '') { $po_no_1 = 0;	} else { $po_no_1; }
							if ($po_line == '') { $po_line = 0; } else { $po_line; }
							if ($po_subline == '') { $po_subline = 0; } else { $po_subline;	}
							if ($inv_no == '') { $inv_no = 0; } else { $inv_no;	}
							if ($item_code == '') {	$item_code = 0;	} else { $item_code; }
							if ($item_desc == '') {	$item_desc = 0; } else { $item_desc; }
							if ($item_name == '') {	$item_name = 0; } else { $item_name; }
							if ($lot_no == '') { $lot_no = 0; } else { $lot_no; }
							if ($supplier_batch == '') { $supplier_batch = 0; } else { $supplier_batch;	}
							if ($supplier_roll_no == '') { $supplier_roll_no = 0; } else {	$supplier_roll_no; }
							if ($fcs_roll_no == '') { $fcs_roll_no = 0;	} else { $fcs_roll_no; }
							if ($qty == '') { $qty = 0;	} else { $qty; }
							if ($rm_color == '') { $rm_color = '--'; } else { $rm_color; }
							echo '<tr><td><input type="checkbox" name="bindingdata[]" value="' . $sno . "$" . $lot_no . '"></td><td>' . $fcs_roll_no . '</td><td>' . $supplier_roll_no . '</td><td>' . $po_no_1 . '</td><td>' . $po_line . '</td><td>' . $po_subline . '</td><td>' . $inv_no . '</td><td>' . $item_code . '</td><td>' . $item_desc . '</td><td>' . $item_name . '</td><td>' . $lot_no . '</td><td>' . $supplier_batch . '</td><td>' . $rm_color . '</td><td>' . $qty . '</td></tr>';
							
						}

						?>
					</tbody>
				</table>
				<div class="button_pop col-sm-8 col-md-8 col-lg-8 populate_div" >
					<?php
					if($status==0)
					{
					?>
					<input type="submit" class="btn btn-sm btn-primary" name="set_insp_pop" id="disable_id" value="Proceed for 4 Point Inspection" style="margin-right: 25px;">
					<?php
					}
					?>					
					<input type="submit" class="btn btn-sm btn-primary" name="color_report" id="disable_id1" value="Color Contuinity Report" style="margin-right: 25px;">
					<input type="hidden" name='submit_type' id="submit_type" value="">
				</div>
				
			</form>
		</div>
	</div>
</div>
</div>
<Script>

</Script>
<?php
    
	if($_POST['submit_type'] == "Proceed for Inspection")
    {
      	if (isset($_POST['bindingdata'])) 
		{
			$binddetails = $_POST['bindingdata'];
			$parent_id = $_POST['parent_id'];
			$plant_code = $_POST['plant_code'];
			$username = $_POST['username'];
			$count1 = count($binddetails);
			if ($count1 > 0) 
			{
				for ($j = 0; $j < $count1; $j++)
				{
					$id = $binddetails[$j];
					$exp = explode("$", $id);
					$sno = $exp[0];
					$lot_num[] = $exp[1];
					$insertbinditems = "update $wms.inspection_population set status=1,updated_user= '".$username."',updated_at=NOW() where parent_id=$parent_id and sno=$sno and plant_code='".$plant_code."'";
					mysqli_query($link, $insertbinditems) or exit("Sql Error2" . mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				$lot_array = implode(",", $lot_num);
			}
			 echo "<script>swal('Get ready form Inspection Process.','Successfully','success')</script>";
	         $url = getFullURLLevel($_GET['r'], '4_point_roll_inspection.php', 0, 'N') ;
	         echo "<script>location.href = '" . $url . "&parent_id=$parent_id&plant_code=$plant_code&username=$username'</script>";
	    }
    }
    else 
    {
      if($_POST['submit_type'] == "Color Contuinity Report")
      {
          $parent_id = $_POST['parent_id'];
 	      //$lot = array();
	   //    $get_details = "select lot_no,supplier_batch from $wms.inspection_population where parent_id=$parent_id";
	   //    $sql_result=mysqli_query($link, $get_details) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  // while($sql_row=mysqli_fetch_array($sql_result))
		  // {
		  // 	$lot = $sql_row['lot_no'];
		  // 	$batch = $sql_row['supplier_batch'];
		  // }
	      echo "<script>swal('Proceed to Color Contunity Report','Successfully','success')</script>";
	      $url = getFullURLLevel($_GET['r'], 'c_tex_interface_v6.php', 0, 'N') ;
	       echo "<script>location.href = '" . $url . "&parent_id=$parent_id'</script>";
	     // echo "<script>location.href = '" . $url . "&batch_no=".urlencode($batch)."&lot_ref=".urlencode($lot)."&parent_id=$parent_id'</script>";
      }
    }	
}
?>

