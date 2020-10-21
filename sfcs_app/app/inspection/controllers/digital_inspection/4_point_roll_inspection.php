<head>
 <script>
		
		$(document).ready(function() {
			if (screen.width <= 1070) 
            {
                $BODY.toggleClass('nav-md nav-sm');
            }
		}
</script>		
	<style>
		.selected{
			background-color:#B0BED9;
		}
		table tr th,
		td {
			text-align: center;
		}
		#myTable tr td {
			cursor: pointer;
		}
.red {
  width:20px;
  height:20px;
  background-color: #ff0000;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}
#myTable thead th:first-child select {
		display:none;
	}
.red a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.red a:hover {
  text-decoration:none;
  background-color: #ff0000;
}

.green {
  width:20px;
  height:20px;
  background-color:green;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}
.legend_info{
	font-weight: 900;
    font-size: 1.5rem;
    line-height: 1.5;
    color: #79787e;
    text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.4);
}
.green a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.green a:hover {
  text-decoration:none;
  background-color: #00ff00;
}
	</style>
</head>

<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
$plant_code = $_SESSION['plantCode'];
$username = $_SESSION['userName'];
if(isset($_GET['parent_id']) or isset($_POST['parent_id']))
{
	$parent_id=$_GET['parent_id']  or $_POST['parent_id'];
	$plant_code=$_GET['plant_code']  or $_POST['plant_code'];
	$username=$_GET['username']  or $_POST['username'];
	$sno=$_GET['id']  or $_POST['id'];
}
$pop_up_path="../sfcs_app/app/inspection/reports/4_point_inspection_report.php";
$flag = false;
?>
	<div class="modal fade" id="myModalHorizontal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    				<div class="modal-dialog">
     	 			  <div class="modal-content">
            				<!-- Modal Header -->
            					<div class="modal-header">
               						 <button type="button" class="close" data-dismiss="modal">
                      					 <span aria-hidden="true">&times;</span>
                       							<span class="sr-only">Close</span>
               						 </button>
              						  <h4 class="modal-title" id="myModalLabel"> Add more rolls from here</h4>
            					</div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                <form class="form-horizontal" role="form" action="<?php getFullURLLevel($_GET["r"], "4_point_roll_inspection.php", "0", "N") ?>" method="POST">
					<div class="panel-body">
						<div class="panel panel-primary" style="overflow-x:scroll;">
							<div class="panel-body">
								<table class="table table-bordered" id="myTable">  
								<?php
									echo "<input type='hidden' value=".$parent_id." name='parent_id'>";
									$sql_query = "select sno,lot_no,supplier_po,po_line,po_subline,supplier_invoice,item_code,item_desc,item_name,supplier_batch,rm_color,sfcs_roll_no,supplier_roll_no,rec_qty from $wms.inspection_population where parent_id=$parent_id and status = 0 and plant_code='".$plant_code."'";
									$k=0;
									$sql_result = mysqli_query($link, $sql_query) or exit("Sql Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
									if (mysqli_num_rows($sql_result) == 0) {
										echo "<div class='alert alert-info'><strong>Info!</strong> Sorry No Records Found......!</div>";
									}else{
								?>
									<thead>
										<tr>
											
											<th>Select<input type="checkbox" id="selectAlll"></th>
											<th>Supplier Roll No</th>
											<th>FCS Roll No</th>
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
										<?php
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
					

							echo '<tbody><tr><td><input type="checkbox" name="bindingdata[]" value="' . $sno . "$" . $lot_no . '"></td><td>' . $fcs_roll_no . '</td><td>' . $supplier_roll_no . '</td><td>' . $po_no_1 . '</td><td>' . $po_line . '</td><td>' . $po_subline . '</td><td>' . $inv_no . '</td><td>' . $item_code . '</td><td>' . $item_desc . '</td><td>' . $item_name . '</td><td>' . $lot_no . '</td><td>' . $supplier_batch . '</td><td>' . $rm_color . '</td><td>' . $qty . '</td></tr>';
						}
					}
						?>										

									</tbody>
								</table>
							</div>
						</div>
					</div>
			
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<!-- <button type="button" class="btn btn-primary">Procede</button> -->
				<input type="submit" class="btn btn-md btn-primary" name="set_insp_pop" id="disable_id" value="Proceed">

			</div>
			</form>
        </div>
    </div>
</div>
<div class="container-fluid">
		<div class="panel panel-primary">
			<div class="panel-heading">4 Point Roll Inspection Update</div>
				<div class="panel-body">
					<div class="container">
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
								$get_details_main="select invoice_no,batch,rm_color,supplier,lot_no,status from $wms.main_population_tbl where id=$parent_id and plant_code='".$plant_code."'";					
								$details1_result=mysqli_query($link,$get_details_main) or exit("get_details_main Error".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($row1=mysqli_fetch_array($details1_result))
								{
									$invoice = $row1['invoice_no'];
									$batch = $row1['batch'];
									$color = $row1['rm_color'];
									$po = $row1['supplier'];
									$lot_no = $row1['lot_no'];
									$pop_status = $row1['status'];
								}
								if($color==''){	$color='--'; }else{	$color;	}
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
					<form id='myForm' method='post' name='input_main' action="?r=<?= $_GET['r']."&parent_id=".$parent_id ?>">
					<?php
					"<input type='hidden' name='invoice_four_point' value='".$invoice."'>";
					"<input type='hidden' name='color_four_point' value='".$color."'>";
					"<input type='hidden' name='batch_four_point' value='".$batch."'>";
					"<input type='hidden' name='po_four_point' value='".$po."'>";
					"<input type='hidden' name='lot_four_point' value='".$lot_no."'>";
					$url = getFullURLLevel($_GET['r'],'4_point_roll_inspection_child.php',0,'N');
					$get_details12="select * from $wms.`inspection_population` where parent_id=$parent_id and status<>0 and plant_code='".$plant_code."'";
					$details1_result22=mysqli_query($link,$get_details12) or exit("get_details1 Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$val=mysqli_num_rows($details1_result22);
					?>
					 
					  <div class="table-responsive col-sm-12">
					    <table class="table table-bordered">
					      <tbody>
					      	<tr style="background-color: antiquewhite;">
					      		<th>Supplier Roll No</th>
					      		<th>SFCS Roll No</th>
					      		<th>Item Code</th>
					      		<th>Color</th>
					      		<th>Description</th>
					      		<th>Item Name</th>
					      		<th>Lot No</th>
					      		<th>Qty</th>
					      		<th>Points Rate</th>
								<th>Inspection Status</th>
								<?php
								if($val>0 && $pop_status !=2)
								{
									?>
								
								<th><p class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModalHorizontal"> Add</p></th>
								
								<?php
								}
								else
								{
									?>
									<th><p> Control</p></th>
									<?php
								}
									?>									
					      	</tr>
		
							 <?php
							
							$val2=0;
							$val2_1=0;
							$val2_2=0;
							$get_details1="select * from $wms.`inspection_population` where parent_id=$parent_id and status<>0 and plant_code='".$plant_code."' order by sno";
							$details1_result=mysqli_query($link,$get_details1) or exit("get_details1 Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							$path= getFullURLLevel($_GET['r'], "fabric_inspection_report.php", "0", "R")."?id=$parent_id";
							while($row2=mysqli_fetch_array($details1_result))
							{
								$roll_id = $row2['supplier_roll_no'];	
								$supplier_id = $row2['sfcs_roll_no'];	
								$lot_id = $row2['lot_no'];
								$lotids[]=$row2['lot_no'];
								$invoice=$row2['supplier_invoice'];
								$store_in_id=$row2['store_in_id'];
								$id=$row2['sno'];
								$status=$row2['status'];
								$main_points=0;
									
								$get_details_points = "select rec_qty from $wms.`inspection_population` where store_in_id=$store_in_id and plant_code='".$plant_code."'";
								$details_result_points = mysqli_query($link, $get_details_points) or exit("get_details--1Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
								while($row522=mysqli_fetch_array($details_result_points))
								{ 
									$invoice_qty=$row522['rec_qty'];
									if($fab_uom == "meters"){
										$invoice_qty=round($invoice_qty*1.09361,2);
									}else
									{
										$invoice_qty;
									}
								}
								$get_min_value = "select width_s,width_m,width_e from $wms.roll_inspection_child where store_in_tid=$store_in_id and plant_code='".$plant_code."'";
								$min_value_result=mysqli_query($link,$get_min_value) or exit("get_min_value Error".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($row_min=mysqli_fetch_array($min_value_result))
								{
                                   $width_s = $row_min['width_s'];
                                   $width_m = $row_min['width_m'];
                                   $width_e = $row_min['width_e'];
								}
                                $min_value = min($width_s,$width_m,$width_e);
                                $inch_value=round($min_value/(2.54),2);
                                // echo $min_value;
                                // echo $inch_value."</br>";
                                // echo $invoice_qty;
								$back_color="";		
								$four_point_count = "select sum(points) as pnt from $wms.four_points_table where insp_child_id=".$store_in_id." and plant_code='".$plant_code."'";
								$status_details_result2=mysqli_query($link,$four_point_count) or exit("get_status_details Error".mysqli_error($GLOBALS["___mysqli_ston"]));
								if(mysqli_num_rows($status_details_result2)>0)
								{	
									while($row52=mysqli_fetch_array($status_details_result2))
									{ 
										$point=$row52['pnt'];
										if($inch_value > 0)
										{
										  $main_points=((($row52['pnt']/$invoice_qty)*(36/$inch_value))*100);	
										}
										else
										{
											$main_points=0;
										}	
										
										$main_points = round($main_points,2);
									}
									
									if($point>0)
									{	
										if($main_points<28)
										{
											$back_color="style='background: green;color:white;'";
										}
										else
										{
											$back_color="style='background: red;color:white;'";
										}
									}
									else
									{
										if($status == 3)
										{
											$back_color="style='background: green;color:white;'";
										}
										else
										{
											$back_color="";
										}	
									}	
								}
								else
								{
									$back_color="";
								}	
								$h_ref="";
								if($status == 1)
								{
									$val2_2 =1;
									$status_main = 'Pending';
									$h_ref="data-href='$url&parent_id=$parent_id&store_id=$store_in_id&plant_code=$plant_code&username=$username'";
								}
								else if($status == 2)
								{
									$val2_1=1;
									$status_main = 'Inprogress';
									$h_ref="data-href='$url&parent_id=$parent_id&store_id=$store_in_id&plant_code=$plant_code&username=$username'";									
								}
								else
								{
									$val2=1;
									$status_main = 'Complete';
									$h_ref="";
								}	
								
								echo "<tr $back_color>";
								echo "<input type='hidden' name='insp_id[$id]' id='insp_id[$id]' value=$id> 
								<td $h_ref>".$row2['supplier_roll_no']."</td>
								<td $h_ref>".$row2['sfcs_roll_no']."</td>
								<td $h_ref>".$row2['item_code']."</td>
								<td $h_ref>".$row2['rm_color']."</td>
								<td $h_ref>".$row2['item_desc']."</td>
								<td $h_ref>".$row2['item_name']."</td>
								<td $h_ref>".$lot_id."</td>
								<td $h_ref>".$row2['rec_qty']."</td>									
								<td $h_ref>".$main_points."</td>
								<td $h_ref>".$status_main."</td>";
								if($status == 3)
								{
									echo "<td> <span class='glyphicon glyphicon-ok'></span></td></tr>";
								}
								else
								{									
									echo "<td><span class='glyphicon glyphicon-glyphicon glyphicon-trash' style = 'cursor:pointer;' onclick = delete_row(event,$store_in_id)></span></td></tr>";
								}									
							
							}

							if($val2==1 && $status == 3 && $val2_1 ==0 && $val2_2 ==0)
							{
								echo "<tr><td><a class='btn btn-primary' href=\"$pop_up_path?parent_id=$parent_id&plant_code=$plant_code&username=$username\" onclick=\"Popup1=window.open('$pop_up_path?parent_id=$parent_id&plant_code=$plant_code&username=$username','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">Get Report</a></td></tr>";
                            }
							?>
							
					      </tbody>
						</table>
						<div class="table-responsive col-sm-4" style="float: right;">
					    	<table class="table table-bordered">
								<tr>
									<td class="legend_info">Color Legends</td>
									<td><div class="green" ></div>Pass</td>
									<td><div class="red" ></div>Rejected</td>
								</tr>
							</table>
						</div>
						<!-- <div>
							<h4>Color Legends</h4>
							<div>
							<div class="green" ></div> <b>Pass</b>
							</div>
							<div>
							<div class="red" ></div><b> Rejected</b>
							</div>
							<div style="clear: both;"> </div>
						</div> -->
					  </div>
					
					<!-- <div class="form-inline col-md-12">
						<button type="sumbit" class='btn btn-sm btn-primary' name="confirm" id="confirm">Confirm</button>
						<button type="sumbit" class='btn btn-sm btn-primary' name="print" id="print">Print</button>
					</div>  -->
					
                    </div>
                    <?php $implot=implode(',',$lot_num); ?>
                    <input type="hidden" name="lot_nos" value='<?=  $implot ?>'>
                    <input type="hidden" name="po" value='<?=  $po ?>'> 
                    <input type="hidden" name="batch" value='<?=  $batch ?>'> 
                    <input type="hidden" name="color" value='<?=  $color ?>'>     
				   </form>      	  	
				</div>
			</div>
        </div>
</div>
<?php 

if (isset($_POST['bindingdata'])) {

	$binddetails = $_POST['bindingdata'];
	$parent_id = $_POST['parent_id'];
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
			mysqli_query($link, $insertbinditems) or exit("Sql Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		$lot_array = implode(",", $lot_num);
	}
	echo "<script>swal('Get ready form Inspection Process.','Successfully','success')</script>";
	$url = getFullURLLevel($_GET['r'], '4_point_roll_inspection.php',0, 'N') ;
	echo "<script>location.href = '" . $url . "&parent_id=$parent_id'</script>";
	echo "<script>swal('Data Updated..','Successfully','success')</script>";
	$url = getFullURLLevel($_GET['r'], '4_point_roll_inspection.php', 0, 'N');
	echo "<script>location.href = '" . $url . "&parent_id=$parent_id'</script>";
	die();
}
if(isset($_POST['confirm']))
{
	$insp_id=$_POST['insp_id'];
	$sno_array = implode(",", $insp_id);

	$update_inspection="update $wms.`inspection_population` set status=2,updated_user= '".$username."',updated_at=NOW() where sno in ($sno_array) and plant_code='".$plant_code."'";
	$result_query_update = $link->query($update_inspection) or exit('query error in updating111');
	$flag = true;
	echo "<script>swal('Data inserted...','Successfully','success')</script>";
	$url = getFullURLLevel($_GET['r'], '4_point_roll_inspection.php', 0, 'N') ;
	echo "<script>location.href = '" . $url . "&parent_id=$parent_id'</script>";

}
?>

<script>
	function delete_row(e,store_in_id){
		e.preventDefault();
        var v = sweetAlert({
            title: "Are you sure to Delete this Roll?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["No, Cancel It!", "Yes, I am Sure!"],
        }).then(function(isConfirm){
            if (isConfirm) {
				var delete_sid =store_in_id;
		$.ajax({
		
   		 url : "<?php echo getFullURL($_GET['r'], 'submit.php', 'R'); ?>",  
   		 type: "POST",
   		 data : {"delete_id" : delete_sid},
			success: function(data) {
                    var data = $.parseJSON(data);
                    if (data.status == 200){
					swal('Removed from 4 point..','Successfully','success');
					setTimeout(function(){
          			 location.reload();
      				}, 1000); 
					}
       				else {
                       console.log('error');
                    }
                }
     		});
            return true;
            } 
    
	});
 };
	
	function clearValues(i){
		
		var id = i;
        $('#point1_'+id).removeAttr('checked');
		$('#point2_'+id).removeAttr('checked');
        $('#point3_'+id).removeAttr('checked');
		$('#point4_'+id).removeAttr('checked');
	}

	$(document).ready(function(){
		

		$('#clear1').click(function(){
		
	        var id = $(this).val();
	        $('#point1_'+id).val('');
			$('#point2_'+id).val('');
	        $('#point3_'+id).val('');
			$('#point4_'+id).val('');
	        alert();
	    });
	})
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
					$('tbody tr', tableone).addClass("selected");
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
		
</script>

<script type="text/javascript">
	jQuery(document).ready(function($) {
    $('*[data-href]').on('click', function() {
        window.location = $(this).data("href");
    });
});

	
</script>
<style type="text/css">
	[data-href] {
    cursor: pointer;
}
</style>
