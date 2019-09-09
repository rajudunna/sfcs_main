<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
?>

<div class="container-fluid">
		<div class="panel panel-primary">
			<div class="panel-heading">4 Point Roll Inspection Update</div>
			<div class="panel-body">
				<div class="container">
				 <div class="table-responsive col-sm-12">
				    <table class="table table-bordered">
				      <tbody>
				      <tr>
				      	<td>Invoice #</td>
				      	<td></td>
				      	<td>Color</td>
				      	<td></td>
				      	<td>Batch</td>
				      	<td></td>
				      	<td>PO#</td>
				      	<td></td>
				      </tr>
				      </tbody>
				    </table>
				  </div>
				  <form  method="post" name="input">
					  <div class="table-responsive col-sm-12">
					  	<table class="table table-bordered">
					  		<tr>
	                            <td style="text-align:right;" colspan="3">Tolerance</td>
					  		</tr>
					  		
					  		<tbody>		
					  			<tr>	
					  				<td>Fabric Composition</td>
					  				<td><input type="text" id="fabric_composition" name="fabric_composition"></td>
					  			</tr>
					  			<tr>	
					  				<td>Inspection Status</td>
					  				<td>
					  					<select  name="inspection_status" id="inspection_status" ">
				                     	<option value="" disabled selected>Select Status</option>
				                     	<option value="1">Aprroval</option>
				                     	<option value="1">Rejected</option>
				                     	<option value="1">Partial Rejected</option>
									</select>
					  				</td>
					  			</tr>
					  			<tr>	
					  				<th style=text-align:center colspan="3">Spec Details</th>
					  			</tr>	
					  			<tr>
					  				<td>Spec Width</td>
					  				<td><input type="text" id="spec_width" name="spec_width"></td>
					  			</tr>
					  			<tr>
					  				<td>Spec Weight</td>
					  				<td><input type="text" id="spec_weight" name="spec_weight"></td>
					  			</tr>
					  			<tr>
					  				<td>Repeat Length</td>
					  				<td><input type="text" id="repeat_length" name="repeat_length"></td>
					  			</tr>
					  			<tr>
					  				<th style=text-align:center colspan=3>Inspection Summary</th>
					  			</tr>
					  			<tr>
					  				<td>Lab Testing</td>
					  				<td><input type="text" id="lab_testing" name="lab_testing"></td>
					  			</tr>	
					  		</tbody>	
					  	</table>	
					  </div>
					</form> 
					<form  method="post" name="input"> 
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
					      	</tr>	
					      </tbody>
					    </table>
					  </div>
					</form>
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
					<form method="post" name="input">
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
							      		<td><button type="button" class="btn btn-outline-primary">Save</button></td>
							      	</tr>
							      	<tr>	
							      		<td><button type="button" class="btn btn-outline-primary">Confirm</button></td>
							      	</tr>
							      </tbody>
							     </table>
							    </div> 
							 </div>   
						     <div class="table-responsive col-sm-6">
						     <table class="table table-bordered">
						       <tbody>
						      	<tr>
						      		<th>Code</th>
						      		<th>Damage Des</th>
						      		<th>1 Points</th>
						      		<th>2 Points</th>
						      		<th>3 Points</th>
						      		<th>4 Points</th>
						      	</tr>
						      	<tr>
						      		<td><input type="text" id="" name=""></td>
						      		<td><input type="text" id="" name=""></td>
						      		<td><input type="text" id="" name=""></td>
						      		<td><input type="text" id="" name=""></td>
						      		<td><input type="text" id="" name=""></td>
						      		<td><input type="text" id="" name=""></td>
						      	</tr>
						      	<tr>
						      		<td><input type="text" id="" name=""></td>
						      		<td><input type="text" id="" name=""></td>
						      		<td><input type="text" id="" name=""></td>
						      		<td><input type="text" id="" name=""></td>
						      		<td><input type="text" id="" name=""></td>
						      		<td><input type="text" id="" name=""></td>
						      	</tr>
						      	<tr>
						      		<td><input type="text" id="" name=""></td>
						      		<td><input type="text" id="" name=""></td>
						      		<td><input type="text" id="" name=""></td>
						      		<td><input type="text" id="" name=""></td>
						      		<td><input type="text" id="" name=""></td>
						      		<td><input type="text" id="" name=""></td>
						      	</tr>
						      	<tr>
						      		<td><input type="text" id="" name=""></td>
						      		<td><input type="text" id="" name=""></td>
						      		<td><input type="text" id="" name=""></td>
						      		<td><input type="text" id="" name=""></td>
						      		<td><input type="text" id="" name=""></td>
						      		<td><input type="text" id="" name=""></td>
						      	</tr>
	
						      </tbody>
						     </table>
						    </div>

						</div>    
					</form>      	  	
				</div>
			</div>
        </div>
</div>




				

                
