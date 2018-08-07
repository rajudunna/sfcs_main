<html>
	<head>
		<?php
			include(getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
			$has_permission=haspermission($_GET['r']);
			$module = $_GET['module'];
			$date = $_GET['date'];
		?>
	</head>
	<body>
		<div class="panel panel-primary">
			<div class="panel-heading"><strong>Module Wise Forecast Details</strong></div>
			<div class="panel-body">
				<form action="#" method="POST">
					<input type="hidden" id="module" name="module" class="form-control" value="<?php echo $module ?>"  required>
					<input type="hidden" id="date" name="date" class="form-control" value="<?php echo $date ?>"  required>
					<div class="form-group col-sm-3">
						<label for="style">Style: </label>
						<input type="text" id="style" name="style" class="form-control" value=""  required>
					</div>
					<div class="form-group col-sm-3">
						<label for="schedule">Schedule: </label>
						<input type="text" id="schedule" name="schedule" class="form-control integer" value=""  required>
					</div>
					<div class="form-group col-sm-3">
						<label for="color">Color: </label>
						<input type="text" id="color" name="color" class="form-control" value=""  required>
					</div>
					<div class="form-group col-sm-3">
						<label for="smv">SMV: </label>
						<input type="text" id="smv" name="smv" class="form-control float" value=""  required>
					</div>
					<div class="form-group col-sm-3">
						<label for="fr_qty">FR Qty: </label>
						<input type="text" id="fr_qty" name="fr_qty" class="form-control integer" value=""  required>
					</div>
					<div class="form-group col-sm-3">
						<label for="hours">Hours: </label>
						<input type="text" id="hours" name="hours" class="form-control integer" value=""  required>
					</div>
					<div class='col-sm-3'>
						<br>
						<input type="submit" name="submit" id="submit" value="Submit" class="btn btn-primary">
					</div>
				</form>

				
				<?php
					if (isset($_POST['submit']))
					{
						$style = $_POST['style'];
						$schedule = $_POST['schedule'];
						$color = $_POST['color'];
						$smv = $_POST['smv'];
						$fr_qty = $_POST['fr_qty'];
						$module = $_POST['module'];
						$hours = $_POST['hours'];
						$date = $_POST['date'];

						$add_new = "INSERT INTO bai_pro2.`fr_data` (frdate, team, style, smv, fr_qty, hours, schedule, color) VALUES( '$date', '$module', '$style', '$smv', '$fr_qty', '$hours', '$schedule', '$color')";
						// echo $add_new;
						// $result = mysqli_query($link, $add_new) or exit("Error while Saving details");
						if (mysqli_query($link, $add_new))
						{
							echo "<script>sweetAlert('Successfully Added!!','','success')</script>";
							echo("<script>location.href = '".getFullURLLevel($_GET['r'],'module_wise_forecast.php',0,'N')."&date=$date&module=$module';</script>");
						}
						else
						{
							echo "<script>sweetAlert('Failes to Add!!','','error')</script>";
							echo("<script>location.href = '".getFullURLLevel($_GET['r'],'module_wise_forecast.php',0,'N')."&date=$date&module=$module';</script>");
						}		
					}
				?>
			</div>
		</div>
	</body>
</html>