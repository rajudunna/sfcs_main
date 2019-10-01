<head>
	<style>
		table tr th,
		td {
			text-align: center;

		}
	</style>
</head>

<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));

if(isset($_GET['parent_id']) or isset($_POST['parent_id']))
{
	$parent_id=$_GET['parent_id']  or $_POST['parent_id'];
	$sno=$_GET['id']  or $_POST['id'];
}
$flag = false;
?>

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
					      </tr>
					      <tr>
							  <?php
								$get_details_main="select supplier_invoice,rm_color,supplier_po,supplier_batch from `bai_rm_pj1`.`inspection_population` where parent_id=$parent_id and status in (1,2,3)";
					
								$details1_result=mysqli_query($link,$get_details_main) or exit("get_details_main Error".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($row1=mysqli_fetch_array($details1_result))
								{
									$invoice = $row1['supplier_invoice'];
									$batch = $row1['supplier_batch'];
									$color = $row1['rm_color'];
									$po = $row1['supplier_po'];
								}
						  echo "<td>$invoice</td> 
						      	<td>$color</td>
						      	<td>$batch</td>
						      	<td>$po</td>";
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
					?>
					 
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
							   $url = getFullURLLevel($_GET['r'],'4_point_roll_inspection_child.php',0,'N');
							   $get_details1="select * from `bai_rm_pj1`.`inspection_population` where parent_id=$parent_id and status in (1,2,3,4)";
								
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
							  if($status == 1 || $status == 3){
								$tr="<tr data-href='$url&supplier=$roll_id&roll=$supplier_id&invoice=$invoice&lot=$lot_id&parent_id=$parent_id&store_id=$store_in_id'>";
							}else{
								$tr="<tr style='background: #96f7ee;'>";
							}
					      	  echo 
					      	  "$tr
								 <input type='hidden' name='insp_id[$id]' id='insp_id[$id]' value=$id> 
								<td>".$row2['supplier_roll_no']."</td>
					      		<td>".$row2['sfcs_roll_no']."</td>
					      		<td>".$row2['ctex_length']."</td>
					      		<td>".$row2['ctex_width']."</td>
					      		<td>".$row2['item_code']."</td>
					      		<td>".$row2['rm_color']."</td>
	                            <td>".$row2['item_desc']."</td>
	                            <td>".$lot_id."</td>
								<td>".$row2['qty']."</td>";

		
								 $get_status_details="select sno,inspection_status from $bai_rm_pj1.roll_inspection_child where store_in_tid in ('". $store_in_id."')";
								 
								 echo $get_status_details;
						      	 $status_details_result=mysqli_query($link,$get_status_details) or exit("get_status_details Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	                             while($row5=mysqli_fetch_array($status_details_result))
	                             { 
		
									$sno=$row5['sno'];
								}
								$four_point_count = "select * from ";
								//    $point2=$row5['2_point']*2;
								//    $point3=$row5['3_point']*3;
								//    $point4=$row5['4_point']*4;
								
								//    $main_points =  $point1+$point2+$point3+$point4;
		                            echo"
		                            <td>".$main_points."</td>
		                            <td>".$row5['inspection_status']."</td>
						      	   </tr>";
                                }
                             
                             ?>	
					      </tbody>
					    </table>
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
if(isset($_POST['confirm']))
{
	$insp_id=$_POST['insp_id'];
	$sno_array = implode(",", $insp_id);

	$update_inspection="update $bai_rm_pj1.`inspection_population` set status=2 where sno in ($sno_array)";
	$result_query_update = $link->query($update_inspection) or exit('query error in updating111');
	$flag = true;
	echo "<script>swal('Data inserted...','Successfully','success')</script>";
	$url = getFullURLLevel($_GET['r'], '4_point_roll_inspection.php', 0, 'N') ;
	echo "<script>location.href = '" . $url . "&parent_id=$parent_id'</script>";

}
?>

<script>
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
