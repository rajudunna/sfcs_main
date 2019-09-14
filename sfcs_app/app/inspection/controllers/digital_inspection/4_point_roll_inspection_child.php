<?php

 include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
 $lot_number = $_GET['lot'];
 $roll_id = $_GET['roll'];
 $supplier_id = $_GET['supplier'];
 $get_details="select * from `bai_rm_pj1`.`inspection_population` where lot_no='$lot_number' and supplier_roll_no='$supplier_id' and sfcs_roll_no='$roll_id'";
 $details_result=mysqli_query($link,$get_details) or exit("get_details Error".mysqli_error($GLOBALS["___mysqli_ston"]));
 while($row1=mysqli_fetch_array($details_result))
 {
    $invoice = $row1['supplier_invoice'];
    $color = $row1['rm_color'];
    $batch = $row1['supplier_batch'];
    $po = $row1['supplier_po'];
    $item_code = $row1['item_code'];
    $item_desc = $row1['item_desc'];
 }

 $inspection_details = "select fabric_composition,spec_width,inspection_status,spec_weight,repeat_length,lab_testing from $bai_rm_pj1.roll_inspection where lot_no='$lot_number' and supplier_roll_no='$supplier_id' and sfcs_roll_no='$roll_id'";
  //echo $inspection_details;
  $inspection_details_result=mysqli_query($link,$inspection_details) or exit("inspection_details Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  while($row4=mysqli_fetch_array($inspection_details_result))
  {
     $fabric = $row4['fabric_composition'];
     $width = $row4['spec_width'];
     $status = $row4['inspection_status'];
     $weight = $row4['spec_weight'];
     $length = $row4['repeat_length'];
     $testing = $row4['lab_testing'];
  }
?>

<?php
if(isset($_POST['save']))
{
  $fabric_composition = $_POST['fabric_composition'];
  $spec_width = $_POST['spec_width'];
  $inspection_status = $_POST['inspection_status'];
  $spec_weight = $_POST['spec_weight'];
  $repeat_length = $_POST['repeat_length'];
  $lab_testing = $_POST['lab_testing'];
  $lot_num = $_POST['lot_no'];
  $supplier_no = $_POST['supply_no'];
  $roll_no = $_POST['roll'];
  $tolerance = $_POST['tolerance'];

    if(isset($_POST['code']))
	{
	    $code = $_POST['code'];
	    $count=count($code);
	    $damage = $_POST['damage'];
	    for($i=0;$i<$count;$i++)
	    {
	          $code1 = $_POST['code'][$i];
	          $damage1 = $_POST['damage'][$i];
	          $point1 = $_POST['point1'][$i];
	          $point2 = $_POST['point2'][$i];
	          $point3 = $_POST['point3'][$i];
	          $point4 = $_POST['point4'][$i];

	           if($point1 != 0 || $point2 != 0 || $point3 != 0 || $point4 != 0)
	           {
	             $insert_query="insert into $bai_rm_pj1.roll_inspection(lot_no,supplier_roll_no,sfcs_roll_no,fabric_composition,spec_width,inspection_status,spec_weight,repeat_length,lab_testing,tolerance,code,damage_desc,1_points,2_points,3_points,4_points) values ('$lot_num','$supplier_no','$roll_no','$fabric_composition','$spec_width','$inspection_status','$spec_weight','$repeat_length','$lab_testing','$tolerance','$code1','$damage1','$point1','$point2','$point3','$point4')";
	              //echo $insert_query;
	             $result_query = $link->query($insert_query) or exit('query error in inserting');

	             $update_status = "update $bai_rm_pj1.inspection_population SET status=4 where supplier_roll_no='$supplier_no' and sfcs_roll_no='$roll_no' and lot_no='$lot_num'";
	             $result_query_update = $link->query($update_status) or exit('query error in updating');
	           }
	    }
	}
	echo "<script>sweetAlert('Data Saved Sucessfully','','info');</script>";
}

?>

<?php
if(isset($_POST['confirm']))
{
  $fabric_composition = $_POST['fabric_composition'];
  $spec_width = $_POST['spec_width'];
  $inspection_status = $_POST['inspection_status'];
  $spec_weight = $_POST['spec_weight'];
  $repeat_length = $_POST['repeat_length'];
  $lab_testing = $_POST['lab_testing'];
  $lot_num = $_POST['lot_no']; 
  $supplier_no = $_POST['supply_no'];
  $roll_no = $_POST['roll'];
  $tolerance = $_POST['tolerance'];

    if(isset($_POST['code']))
	{
	    $code = $_POST['code'];
	    $count=count($code);
	    $damage = $_POST['damage'];
	    for($i=0;$i<$count;$i++)
	    {
	          $code1 = $_POST['code'][$i];
	          $damage1 = $_POST['damage'][$i];
	          $point1 = $_POST['point1'][$i];
	          $point2 = $_POST['point2'][$i];
	          $point3 = $_POST['point3'][$i];
	          $point4 = $_POST['point4'][$i];

	           if($point1 != 0 || $point2 != 0 || $point3 != 0 || $point4 != 0)
	           {
	             $insert_query="insert into $bai_rm_pj1.roll_inspection(lot_no,supplier_roll_no,sfcs_roll_no,fabric_composition,spec_width,inspection_status,spec_weight,repeat_length,lab_testing,tolerance,code,damage_desc,1_points,2_points,3_points,4_points) values ('$lot_num','$supplier_no','$roll_no','$fabric_composition','$spec_width','$inspection_status','$spec_weight','$repeat_length','$lab_testing','$tolerance','$code1','$damage1','$point1','$point2','$point3','$point4')";
	              //echo $insert_query;
	             $result_query = $link->query($insert_query) or exit('query error in inserting');

	             $update_status = "update $bai_rm_pj1.inspection_population SET status=4 where supplier_roll_no='$supplier_no' and sfcs_roll_no='$roll_no' and lot_no='$lot_num'";
	             $result_query_update = $link->query($update_status) or exit('query error in updating');
	           }
	    }
	}
	echo "<script>sweetAlert('Updated Sucessfully','','info');</script>";
}

?>

<div class="container-fluid">
		<div class="panel panel-primary">
			<div class="panel-heading">4 Point Roll Inspection Update</div>
			<div class="panel-body">
				<div class="container">
					<?php
                       echo "<a class=\"btn btn-xs btn-warning pull-left\" href=\"".getFullURLLevel($_GET['r'], "4_point_roll_inspection.php", "0", "N")."&lot_number=$lot_number\"><<<< Click here to Go Back</a>";
					?>
					<div class="table-responsive col-sm-12">
					    <table class="table table-bordered">
					      <tbody>
					      <tr>
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
				  <form id='myForm' method='post' name='input_main' action="?r=<?= $_GET['r'] ?>">
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
					  				<td><input type="text" id="fabric_composition" name="fabric_composition" value="<?= $fabric ?>" class="integer"></td>
					  				<td rowspan="2"><input type="text" id="tolerance" name="tolerance"></td>
					  			</tr>
					  			<tr>	
					  				<td>Inspection Status</td>
					  				<td>
					  					<select  name="inspection_status" id="inspection_status" value="<?= $status ?>">
				                     	<option value="" disabled selected>Select Status</option>
				                     	<option value="Aprroval">Aprroval</option>
				                     	<option value="Rejected">Rejected</option>
				                     	<option value="Partial Rejected">Partial Rejected</option>
									</select>
					  				</td>
					  			</tr>
					  			<tr>	
					  				<th style=text-align:center colspan="3">Spec Details</th>
					  			</tr>	
					  			<tr>
					  				<td>Spec Width</td>
					  				<td><input type="text" id="spec_width" name="spec_width" value="<?= $width ?>" class="integer"></td>
					  				<td><input type="text" id="tolerance" name="tolerance"></td>
					  			</tr>
					  			<tr>
					  				<td>Spec Weight</td>
					  				<td><input type="text" id="spec_weight" name="spec_weight" value="<?= $weight ?>" class="integer"></td>
					  				<td><input type="text" id="tolerance" name="tolerance"></td>
					  			</tr>
					  			<tr>
					  				<td>Repeat Length</td>
					  				<td><input type="text" id="repeat_length" name="repeat_length" value="<?= $length ?>" class="integer"></td>
					  				<td><input type="text" id="tolerance" name="tolerance"></td>
					  			</tr>
					  			<tr>
					  				<th style=text-align:center colspan=3>Inspection Summary</th>
					  			</tr>
					  			<tr>
					  				<td>Lab Testing</td>
					  				<td><input type="text" id="lab_testing" name="lab_testing" value="<?= $testing ?>" class="integer"></td>
					  				<td rowspan="2"><input type="text" id="tolerance" name="tolerance"></td>
					  			</tr>	
					  		</tbody>	
					  	</table>	
					  </div> 
					  <div class="table-responsive col-sm-12">
					    <table class="table table-bordered">
					      <tbody>
					      	<tr>
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
					      	<!-- <tr> -->
					      	<?php
                             $get_details1="select ref5 as ctex_length,ref3 as ctex_width,qty_issued from $bai_rm_pj1.store_in where lot_no='$lot_number' and supplier_no='$supplier_id' and ref2='$roll_id'";
                             $details1_result=mysqli_query($link,$get_details1) or exit("get_details1 Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                             while($row2=mysqli_fetch_array($details1_result))
                             {
					      	  echo 
					      	  "<tr>
					      	    <td>".$supplier_id."</td>
					      		<td>".$roll_id."</td>
					      		<td>".$row2['ctex_length']."</td>
					      		<td>".$row2['ctex_width']."</td>
					      		<td>".$item_code."</td>
					      		<td>".$color."</td>
	                            <td>".$item_desc."</td>
	                            <td>".$lot_number."</td>
	                            <td>".$row2['qty_issued']."</td>
	                            <td></td>
	                            <td></td>
					      	   </tr>";
                             }
					      	?>	
					      </tbody>
					    </table>
					  </div>
					<div class="table-responsive col-sm-12">
					    <table class="table table-bordered">
					      <tbody>
					      	<tr>
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
					      		<td></td>
					      		<td></td>
					      		<td></td>
					      		<td></td>
					      		<td></td>
					      		<td></td>
					      		<td></td>
					      		<td></td>
					      		<td></td>
					      		<td></td>
					      		<td></td>
					      		<td></td>
					      		<td></td>
					      		<td></td>
					      		<td></td>
					      		<td></td>
					      	</tr>	
					     </tbody>
					    </table>
					</div>
					<div class="form-inline col-sm-12">
							<div class="table-responsive col-sm-3">
						     <table class="table table-bordered">
						       <tbody>
						      	<tr>
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
							     <table class="table table-bordered">
							       <tbody>
							      	<tr>
							      		<td><button type="button" class="btn btn-outline-primary">Print Report</button></td>
							      	</tr>
							      	<tr>	
							      		<td><button type="sumbit" class="btn btn-outline-primary" name="save" id="save">Save</button></td>
							      	</tr>
							      	<tr>	
							      		<td><button type="sumbit" class="btn btn-outline-primary" name="confirm" id="confirm">Confirm</button></td>
							      	</tr>
							      </tbody>
							     </table>
							    </div> 
							 </div> 
                             <div class="table-responsive col-sm-7">
						     <table class="table table-bordered">
						       <tbody>
						      	<tr>
						      		<th>Code</th>
						      		<th>Damage Des</th>
						      		<th>1 Points</th>
						      		<th>2 Points</th>
						      		<th>3 Points</th>
						      		<th>4 Points</th>
						      		<th>Control</th>
						      	</tr>
						      	<?php 
						      	    for($i=0;$i<4;$i++){
						      	?>
						      	<tr>
						      		<td><input type="text" id="code" name="code[]"></td>
						      		<td><input type="text" id="damage" name="damage[]"></td>
						      		<td><input type="text" id="point1_<?= $i ?>" name="point1[]" onchange="sample(<?= $i ?>,1)"></td>
						      		<td><input type="text" id="point2_<?= $i ?>" name="point2[]" onchange="sample(<?= $i ?>,2)"></td>
						      		<td><input type="text" id="point3_<?= $i ?>" name="point3[]" onchange="sample(<?= $i ?>,3)"></td>
						      		<td><input type="text" id="point4_<?= $i ?>" name="point4[]" onchange="sample(<?= $i ?>,4)"></td>
						      		<td><button type="button" class="btn btn-primary btn-sm" id='clear' onclick='clearValues(<?= $i ?>)' value='<?= $i ?>'>Clear</button></td>
						      	</tr>
						      	<?php
						            }
						      	?>
						      </tbody>
						     </table>
						    </div>
                    </div>
                    <input type="hidden" name="lot_no" value='<?= $lot_number ?>'> 
                    <input type="hidden" name="supply_no" value='<?= $supplier_id ?>'> 
                    <input type="hidden" name="roll" value='<?= $roll_id ?>'>    
				   </form>      	  	
				</div>
			</div>
        </div>
</div>


<script>
	function clearValues(i){
		alert();
		var id = i;
        $('#point1_'+id).val('');$('#point2_'+id).val('');
        $('#point3_'+id).val('');$('#point4_'+id).val('');
	}

	$(document).ready(function(){

		

		$('#clear1').click(function(){
			alert();
	        var id = $(this).val();
	        $('#point1_'+id).val('');$('#point2_'+id).val('');
	        $('#point3_'+id).val('');$('#point4_'+id).val('');
	        alert();
	    });
	})

	function sample(row,column)
	{
	 if($('#point'+column+'_'+row).val()) {
       for(var i=1;i<=4;i++)
       {
       	if(column != i)
       	 $('#point'+i+'_'+row).attr("readonly","true");
       }
   } else {
   	for(var i=1;i<=4;i++)
       {
       	 $('#point'+i+'_'+row).attr("readonly",false);
       }
   }
	}
	
</script>






                
