<!DOCTYPE html>
<html>
<head>
	<title>Carton Reversal</title>
	<?php
		include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
		// include(getFullURLLevel($_GET['r'],'common/config/config_ajax.php',4,'R'));
		include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
		// include(getFullURLLevel($_GET['r'],'common/config/m3Updations.php',4,'R'));
		include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/server_urls.php");
		$plant_code = $_SESSION['plantCode'];
		$username = $_SESSION['userName'];
		$operation_id = '200';
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
				<input type="button" name="submit" id="submit" class="btn btn-success submit" onclick="return cartonReversal()" value="Submit">
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
				var bearer_token;
				bearer_token = '<?php $_SESSION['authToken'] ?>';
				$.ajax({
					url: "<?php echo $PTS_SERVER_IP?>/fg-reporting/reportCartonReversal",
					headers: { 'Content-Type': 'application/x-www-form-urlencoded','Authorization': 'Bearer ' +  bearer_token },
					dataType: "json", 
					type: "POST",
					data: {barcode:carton_id,operationCode:operation_id,plantCode:plant_code,createdUser:username},    
					cache: false,
					success: function (response) 
					{
						if(response.status){
							swal('', response.internalMessage, 'success'); 
						} else {
							swal('', response.internalMessage, 'error');
						} 
					}
				})
				
				// $.ajax({
				// 	url: "<?php //echo $PTS_SERVER_IP?>/fg-reporting/reportCartonReversal",
				// 	dataType: "json", 
				// 	type: "POST",
				// 	data: {barcode:carton_id,operationCode:operation_id,plantCode:plant_code,createdUser:username},    
				// 	cache: false,
				// 	success: function (response) 
				// 	{
				// 		if(response.status){
				// 			swal('', response.internalMessage, 'success'); 
				// 		} else {
				// 			swal('', response.internalMessage, 'error');
				// 		} 
				// 	}
				// })
			}

}
</script>
