<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R')); 
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R')); 
?>


<div class="container" id='main'>
	<div class="panel panel-primary">
		<div class="panel-heading">Digital Inspection Report
		</div>
			<div class="panel-body">
				<form class="form-horizontal form-label-left" method="post" name="input2">
				  	<div class="form-group">
				    	<label class="control-label col-md-3 col-sm-3 col-xs-12" >
                        Enter Supplier PO<span class="required"></span>
				    	</label>
		    			<div class="col-md-4 col-sm-4 col-xs-12">
					      	<input type="text" id="course" name="supplier_po" class="form-control col-md-3 col-xs-12 input-sm">
					    </div>
					    <input type="submit" class="btn btn-primary" onclick="return check_bat();"  name="submit" value="Search">
					 </div>
				  		<div class='col-sm-12'><b class='text-center col-sm-10'>(OR)</b></div>
			  		<div class="form-group">
				    	<label class="control-label col-md-3" for="last-name">
                        Enter Supplier Invoice<span class="required"></span>
				    	</label>
				    	<div class="col-md-4 col-sm-4 col-xs-12">
				      		<input type="text"  id="course1" name="supplier_invoice"  class="form-control col-md-3 col-xs-12 input-sm integer">
				    	</div>
				    	<input type="submit" class="btn btn-primary" onclick="return check_lot();" name="submit1" value="Search">
				  	</div>
                      <div class='col-sm-12'><b class='text-center col-sm-10'>(OR)</b></div>
			  		<div class="form-group">
				    	<label class="control-label col-md-3" for="last-name">
                        Enter Supplier Batch<span class="required"></span>
				    	</label>
				    	<div class="col-md-4 col-sm-4 col-xs-12">
				      		<input type="text"  id="course1" name="supplier_batch"  class="form-control col-md-3 col-xs-12 input-sm integer">
				    	</div>
				    	<input type="submit" class="btn btn-primary" onclick="return check_lot();" name="submit2" value="Search">
				  	</div>
                      <div class='col-sm-12'><b class='text-center col-sm-10'>(OR)</b></div>
			  		<div class="form-group">
				    	<label class="control-label col-md-3" for="last-name">
				    		Enter lot no<span class="required"></span>
				    	</label>
				    	<div class="col-md-4 col-sm-4 col-xs-12">
				      		<input type="text"  id="course1" name="lot_no"  class="form-control col-md-3 col-xs-12 input-sm integer">
				    	</div>
				    	<input type="submit" class="btn btn-primary" onclick="return check_lot();" name="submit3" value="Search">
				  	</div>
				</form>

