<!DOCTYPE html>
<html>
<head>
	<title>Carton Reversal</title>
	<?php
		include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
		// include(getFullURLLevel($_GET['r'],'common/config/config_ajax.php',4,'R'));
		include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
		include(getFullURLLevel($_GET['r'],'common/config/m3Updations.php',4,'R'));
		$plant_code = $_SESSION['plantCode'];
        $username = $_SESSION['userName'];
	?>
</head>
<body>
	<div class="panel panel-primary">
		<div class="panel-heading">Carton Reversal</div>
		<div class="panel-body">
			<form class="form-inline" action="<?php $_GET['r'] ?>" method="POST">
				<label>Carton Barcode ID: </label>
				<input type="text" name="carton_id" class="form-control" id="carton_id" value="" required>
				&nbsp;&nbsp;
				<input type="hidden" name="operation_id" id="operation_id" value="<?php echo $operation_id; ?>">
				<input type="hidden" name="plant_code" id="plant_code" value="<?php echo $plant_code; ?>">
				<input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
				<input type="submit" name="submit" id="submit" class="btn btn-success confirm-submit" onclick="return cartonReversal()">
			</form>
			
		</div>
	</div>
</body>
</html>
<script>


function cartonReversal(){
	var carton_id = document.getElementById("carton_id").value;
	var plant_code =document.getElementById("plant_code").value;
	var username =document.getElementById("username").value;
	var operation_id =document.getElementById("operation_id").value;
	if (carton_id != '')
			{
				$.ajax({
					url: "<?php echo $BackendServ_ip?>/fg-reporting/reportCartonReversal",
					dataType: "json", 
					type: "POST",
					data: {barcode:carton_id,operation:operation_id,plantCode:plant_code,createdUser:username},    
					cache: false,
					success: function (response) 
					{
						if(response.status)
                       {
						swal(response.internalMessage);
						   
					   }
					   else
						{
							swal(response.internalMessage);
						} 
					}
				})
			}

}
</script>
