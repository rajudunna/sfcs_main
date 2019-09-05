<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
?>

<div class="container-fluid">
		<div class="panel panel-primary">
			<div class="panel-heading">4 Point Roll Inspection Update</div>
			<div class="panel-body">
				<div class='row'>
					<div class="form-inline col-sm-12">

						<label><font size="2">Invoice #: </font></label>
						<input type="text" id="invoice" name="invoice" class="form-control">
						
						<label><font size="2">Color: </font></label>
						<input type="text"  id="color" name="color"  class="form-control">

						<label><font size="2">Batch: </font></label>
						<input type="text"  id="batch" name="batch"  class="form-control">

						<label><font size="2">Po #: </font></label>
						<input type="text"  id="po_no" name="po_no"  class="form-control">
                    </div>
				</div>
			</div>

			<div class="panel-body">
				<form class="form-horizontal form-label-right" method="post" name="input">
					<div class="form-inline col-sm-12">
						<label><font size="2">Fabric Composition </font></label>
						<input type="text" id="fabric_composition" name="fabric_composition" class="form-control">
					</div>	
					<div class="form-inline col-sm-12">	
						<label><font size="2">Fabric Composition </font></label>
						<input type="text" id="fabric_composition" name="fabric_composition" class="form-control">
					</div>
                    <div class="form-inline col-sm-12">
						<label><font size="2">Fabric Composition </font></label>
						<input type="text" id="fabric_composition" name="fabric_composition" class="form-control">
					</div>	

				</form>	
			</div>
        </div>
</div>




				

                
