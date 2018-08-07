<!DOCTYPE html>
<html>
	<head>
		<title>Module Wise Forecast Details</title>
		<?php
			include(getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
			$has_permission=haspermission($_GET['r']);
			$sql_module = "select sec_mods FROM $bai_pro3.sections_db where sec_id>0";
			$result_module = mysqli_query($link, $sql_module) or exit("Error while getting Module Details");

			if ($_GET['date']) {
				$module1 = $_GET['module'];
				$date1 = $_GET['date'];
			} else {
				$module1 = $_POST['module'];
				$date1 = $_POST['date'];
			}
			
		?>
		<script type="text/javascript">
			function edit_row(fr_id)
			{
				var edit = "edit";
				var fr_id = fr_id;
				var smv=document.getElementById("smv_"+fr_id).value;
				var fr_qty=document.getElementById("fr_qty_"+fr_id).value;
				var hours=document.getElementById("hours_"+fr_id).value;
				// alert(smv+' == '+fr_qty+' == '+hours);
				if (smv!='' && fr_qty!='' && hours!='')
				{
					var function_text = "<?php echo getFullURL($_GET['r'],'module_wise_forecast_ajax.php','R'); ?>";
					//start the ajax
					$.ajax({
						url: function_text,  
						type: "GET",
						data: {edit:edit,fr_id:fr_id,smv:smv,fr_qty:fr_qty,hours:hours},    
						cache: false,
						success: function (response) 
						{
							if(response==1)
							{
								sweetAlert("Updated Sucessfully!","","success");
								location.reload();
							}
						}

					});
				}
				else
				{
					sweetAlert("Please Check the Values","","warning");
				}	
			}

			function delete_row(fr_id)
			{
				var edit = "delete";
				var fr_id = fr_id;
				var smv=document.getElementById("smv_"+fr_id).value;
				var fr_qty=document.getElementById("fr_qty_"+fr_id).value;
				var hours=document.getElementById("hours_"+fr_id).value;
				var function_text = "<?php echo getFullURL($_GET['r'],'module_wise_forecast_ajax.php','R'); ?>";
				//start the ajax
				sweetAlert({
					title: "Are you sure to Delete?",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				}).then((isConfirm)=>{
					if (isConfirm) {
						$.ajax({
							url: function_text,  
							type: "GET",
							data: {delete:edit,fr_id:fr_id},    
							cache: false,
							success: function(response) {  
								if(response==1)
								{
									sweetAlert("Deleted Sucessfully!","","success");
									location.reload();
								}
							}
						});
					} else {
						sweetAlert("Cancelled","","error");
					}
				});
			}
		</script>
	</head>
	<body>
		<div class="panel panel-primary">
			<div class="panel-heading"><strong>Module Wise Forecast Details</strong></div>
			<div class="panel-body">
				<form action="#" method="POST">
					<div class="form-group col-sm-3">
						<label for="date">Date: </label>
						<input type="text" id="date" data-toggle="datepicker" name="date" class="form-control" value="<?php  if(isset($date1)) { echo $date1; } else { echo date("Y-m-d"); } ?>"  required>
					</div>
					<div class="form-group col-sm-3">
						<label for="module">Module: </label>
						<select id="module" name="module" required class="form-control">
							<option value="">Select Module</option>
							<?php
								while($row=mysqli_fetch_array($result_module))
								{
									$list = explode(',',$row['sec_mods']);
									foreach($list as $pv)
									{
										if(isset($module1) && $module1==$pv)
										echo "<option value='".$pv."' selected>".$pv."</option>";
										else
										echo "<option value='".$pv."'>".$pv."</option>";
									}
								}
							?>
						</select>
					</div>
					<div class='col-sm-3'>
						<br>
						<input type="submit" name="submit" id="submit" value="Submit" class="btn btn-primary">
					</div>
				</form>

				
				<?php					
					if (isset($_POST['submit']) || ($_GET['module'] && $_GET['date']))
					{
						$self_url = getFullURL($_GET['r'],'module_wise_forecast_add.php','N');
						echo "<a href='$self_url&module=$module1&date=$date1' class='btn btn-primary pull-right' id='add' name='add'><i class=\"fa fa-plus\" aria-hidden=\"true\"></i>&nbsp;Add</a>";
						// $date = $_POST['date'];
						// $module = $_POST['module'];
						// echo $date.'<br>'.$module;
						$get_fr_details_query = "SELECT * FROM $bai_pro2.`fr_data` WHERE frdate = '$date1' AND team = '$module1'";
						// echo $get_fr_details_query;
						$fr_details_result = mysqli_query($link, $get_fr_details_query) or exit("Error while getting FR details for the date: $date1 and module: $module1");
						if (mysqli_num_rows($fr_details_result)> 0)
						{
							echo '<div class="table-responsive">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th><center>Style</center></th>
												<th><center>Schedule</center></th>
												<th><center>Color</center></th>
												<th><center>SMV</center></th>
												<th><center>FR Qty</center></th>
												<th><center>Hours</center></th>
												<th><center>Control</center></th>
											</tr>
										</thead>
										<tbody>';
										while ($fr_details = mysqli_fetch_array($fr_details_result))
										{
											echo "
											<tr>
												<td><center>".$fr_details['style']."</center></td>
												<td><center>".$fr_details['schedule']."</center></td>
												<td><center>".$fr_details['color']."</center></td>
												<td><center><input type='text' name='smv' id='smv_".$fr_details['fr_id']."' class='form-control float' size=4 value='".$fr_details['smv']."'></center></td>
												<td><center><input type='text' name='fr_qty' id='fr_qty_".$fr_details['fr_id']."' class='form-control integer' size=4 value='".$fr_details['fr_qty']."'></center></td>
												<td><center><input type='text' name='hours' id='hours_".$fr_details['fr_id']."' class='form-control integer' size=4 value='".$fr_details['hours']."'></center></td>
												<td>
													<center>
														<button class='btn btn-info btn-sm' id='edit_btn' onclick='edit_row(".$fr_details['fr_id'].")'><i class='fa fa-edit'></i> Update</button>
														<button class='btn btn-danger btn-sm' id='delete_btn' onclick='delete_row(".$fr_details['fr_id'].")'><i class='fa fa-trash'></i> Delete</button>
													</center>
												</td>
											</tr>";
										}
										echo '</tbody>
									</table>
								</div>';
						}
						else
						{
							echo "<div class='alert alert-danger'><strong>No data found for Module: $module and Date: $date</strong></div>";
						}			
					}
				?>
			</div>
		</div>
	</body>
</html>