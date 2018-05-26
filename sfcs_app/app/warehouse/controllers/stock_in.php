<script type="text/javascript">
	function validateQty(event) 
	{
		event = (event) ? event : window.event;
		var charCode = (event.which) ? event.which : event.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}
</script>

<?php

		echo'<div class="panel panel-primary">
			<div class="panel-heading"><b>Update RM Receiving (Stock IN)</b></div>
            <div class="panel-body">
            	<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<form method="post" name="inputx" action="'.getURL(getBASE($_GET['r'])['path'])['url'].'">
								<div class="col-md-8">
									<label>Receiving / Lot #:</label>
									<input type="text" id="course" name="lot_no" class="form-control integer" required />
								</div>
								<div class="col-md-4">
									<input type="submit" name="submit" value="Search" class="btn btn-success" style="margin-top: 22px;" >
								</div>
							</form>
						</div>
						<div class="col-sm-6">
							<form method="post" name="testx" action="'. getFullURL($_GET['r'],'quick_insert_v1.php','N').'">
								<div class="col-md-8">
										<label>Invoice/Batch/PO #:</label> 
										<input type="text" name="reference" value="" class="form-control alpha" required />
								</div>
								<div class="col-md-4">
										<input type="submit" value="Search" name="submit" class="btn btn-success" style="margin-top: 22px;">
								</div>
							</form>
						</div>
					</div>
				</div><br/>
			';

// echo
?>