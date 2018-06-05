
<?php 
	include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	$view_emp_data = getFullURLLevel($_GET['r'],'view_emp_data.php',0,'N');
	$insert_emp_data = getFullURLLevel($_GET['r'],'insert_emp_data.php',0,'N');
		
?>
	<style>
	/* th
	{
		background-color: #003366;
		color: WHITE;
		border-bottom: 5px solid white;
		border-top: 5px solid white;
		padding: 5px;
		white-space:nowrap;
		border-collapse:collapse;
		text-align:center;
		font-family:Calibri;
		font-size:110%;

	} */
	th,td {
		text-align:center;
	}
	table{
		white-space:nowrap; 
		border-collapse:collapse;
		font-size:12px;
		background-color: white;
	}
	</style>
	<script type="text/javascript">
		function validateForm()
		{
			var x=document.getElementById('qty_value').value;
			if (x==null || x=="" || x=="Enter Cartoned Qty")
			{
				alert("First name must be filled out");
				return false;
			}
		}

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
	
<div class="panel panel-primary">
	<div class="panel-heading">Update Employee Attendance</div>
		<div class="panel-body">
			<?php  $today=date("Y-m-d"); ?>
			<div style="float: right;">
			
				<a href="<?= $view_emp_data.'&date='.$today;  ?>" class='btn btn-primary'>View Attendance >></a>
			</div>
			<form method="POST" action="<?= $insert_emp_data ?>" >
				<div class="row">
					<div class="col-md-2">
						<label>Date:</label>
						<input type='text' class="form-control" name='date' value='<?php echo $today;  ?>' id="datepicker" readonly="true">
					</div>
				</div><br/><hr/><br/>
				<div class="row">
					<div class="col-md-2"></div>
					<div class="col-md-8" style='max-height:600px;overflow-y:scroll;'>
						<table class="table table-bordered">
							<tr>
								<th> Module </th>
								<th style='display:none;'> Present Emp </th>
								<th> Absent (Forcasted) </th>
								<th> Absent (Non Forcasted) </th>
								<th> Jumpers </th>
							</tr>
							<?php 
								$module='';
								$module_query="SELECT module_id FROM $bai_pro3.plan_modules ORDER BY module_id*1";
								$module_result=mysqli_query($link, $module_query) or exit($module_query."--Error Finding Modules");
								while($sql_row=mysqli_fetch_array($module_result))
								{
									$modules[]=$sql_row['module_id'];
								}
								for($i=0;$i<sizeof($modules);$i++) 
								{ ?>
									<tr>
										<td><?php echo $modules[$i]; ?></td>
										<td style='display:none;'>
											<input type="text" value="0" onkeypress="return validateQty(event);" class="form-control" name="pr<?php echo $i; ?>">
										</td>
										<td>
											<input type="text" value="0" onkeypress="return validateQty(event);" class="form-control" id="abf" name="abf<?php echo $i; ?>">
										</td>
										<td>
											<input type="text" value="0" onkeypress="return validateQty(event);" class="form-control" name="abnf<?php echo $i; ?>">
										</td>
										<td>
											<input type="text" value="0" onkeypress="return validateQty(event);" class="form-control" name="ju<?php echo $i; ?>">
										</td>
									</tr>
							
							<?php 	} ?>
						</table>
					</div>
					<div class="row">
					<br><br>
						<div class="col-md-5"></div>
						<div class="col-md-2"><input class="btn btn-success" type="submit" id="submit" value="Submit" disabled></div>
					</div>	
				</div>
			</form>
		</div>
	</div>
</div>
</div> 

<script type="text/javascript">
    $(document).ready(function () {
        $('form')
    .each(function(){
        $(this).data('serialized', $(this).serialize())
    })
    .on('change input', function(){
        $(this)             
            .find('input:submit, button:submit')
                .prop('disabled', $(this).serialize() == $(this).data('serialized'))
        ;
     })
    .find('input:submit, button:submit')
        .prop('disabled', true);
    });

</script>